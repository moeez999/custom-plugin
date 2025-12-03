/* ====== CONFIG ====== */

const START_H = 0,
  END_H = 30,
  SLOT_MIN = 30;
const SLOT_H =
  parseInt(
    getComputedStyle(document.documentElement).getPropertyValue("--slot-h")
  ) || 36;
const PX_PER_MIN = SLOT_H / SLOT_MIN;
const STACK_OFFSET = 18,
  STACK_CAP = 3;
const REVEAL_FRONT =
  parseInt(
    getComputedStyle(document.documentElement).getPropertyValue(
      "--reveal-front"
    )
  ) || 12;
const REVEAL_MID =
  parseInt(
    getComputedStyle(document.documentElement).getPropertyValue("--reveal-mid")
  ) || 8;

// Helper function to get teacher color based on teacher ID (unlimited colors)
function getTeacherColorIndex(teacherId) {
  if (!teacherId) return 1;
  // Use modulo 10 to map to predefined colors 1-10
  return Math.abs(teacherId) % 10 || 10;
}

// Helper function to generate unique vibrant color for any teacher ID
function getTeacherColor(teacherId) {
  if (!teacherId) return "#FF1744"; // Default vibrant red

  // === Step-by-step reveal for PeerTalk and Conference modals ===
  // Assumes: .cohort-column, .teacher-column, .student-column, .modal-next-btn selectors
  function setupStepReveal(modalSelector) {
    const $modal = $(modalSelector);
    $modal.find(".student-column").hide();
    $modal.find(".cohort-column, .teacher-column").show();
    $modal
      .find(".modal-next-btn")
      .off("click")
      .on("click", function () {
        $modal.find(".student-column").slideDown();
        $(this).prop("disabled", true); // Optionally disable after click
      });
  }

  // Call this after modal is opened/populated
  // For PeerTalk modal:
  setupStepReveal("#peerTalkModal");
  // For Conference modal:
  setupStepReveal("#conferenceModal");
  // ...existing code...

  // Generate unique hue based on teacher ID using golden angle for optimal color distribution
  const hue = Math.round((Math.abs(teacherId) * 137.508) % 360); // Golden angle: 137.508°

  // Maximum saturation and optimal lightness for ultra-vibrant colors
  const saturation = 100; // Always 100% for maximum vibrancy
  const lightness = 50; // Fixed at 50% for optimal brightness and color purity

  return `hsl(${hue}, ${saturation}%, ${lightness}%)`;
}

const DOW = ["Mon", "Tue", "Wed", "Thu", "Fri", "Sat", "Sun"];

// White slot windows derived from teacher availability payloads
let whiteSlotRules = [];

// Map event status codes to icons/labels
const STATUS_ICON_MAP = {
  scheduled: { icon: "./img/confirmed.svg", label: "Taught" },

  cancel_no_makeup: {
    icon: "./img/cancelled.svg",
    label: "Cancelled (No Makeup)",
  },

  cancel_reschedule_later: {
    icon: "./img/rescheduled.svg",
    label: "Cancelled (Reschedule Later)",
  },
  reschedule_instant: { icon: "./img/rescheduled.svg", label: "Rescheduled" },
  covered: { icon: "./img/covered.svg", label: "Covered" },
  missed: { icon: "./img/missed.svg", label: "Missed" },
  pendingconfirmation: {
    icon: "./img/pendingconfirmation.svg",
    label: "Pending Confirmation",
  },
  pending_confirmation: {
    icon: "./img/pendingconfirmation.svg",
    label: "Pending Confirmation",
  },

  makeup: { icon: "./img/makeup.svg", label: "Makeup" },
  make_up: { icon: "./img/makeup.svg", label: "Makeup" },
};

function getActiveStatusMeta(statuses) {
  if (!Array.isArray(statuses) || statuses.length === 0) return null;
  const activeStatuses = statuses.filter((s) => s && s.isactive);
  const statusObj = activeStatuses.length
    ? activeStatuses[activeStatuses.length - 1]
    : statuses[statuses.length - 1];
  if (!statusObj || !statusObj.code) return null;
  const code = String(statusObj.code).toLowerCase().trim();
  const direct = STATUS_ICON_MAP[code];
  if (direct) return { ...direct, code, statusObj };
  if (code.startsWith("reschedule")) {
    return { ...STATUS_ICON_MAP.rescheduled, code, statusObj };
  }
  return null;
}

window.events = [];
function pad2(n) {
  return String(n).padStart(2, "0");
}
function fmt12(min) {
  let h = Math.floor(min / 60),
    m = min % 60;
  // Wrap hours beyond 24
  if (h >= 24) h -= 24;
  const ap = h >= 12 ? "PM" : "AM";
  const dispH = h % 12 || 12;
  return `${dispH}:${pad2(m)} ${ap}`;
}

function minutes(hhmm) {
  const [h, m] = hhmm.split(":").map(Number);
  return h * 60 + m;
}
function ymd(d) {
  return `${d.getFullYear()}-${pad2(d.getMonth() + 1)}-${pad2(d.getDate())}`;
}
function mondayOf(date) {
  const d = new Date(date.getFullYear(), date.getMonth(), date.getDate());
  const dow = (d.getDay() + 6) % 7;
  d.setDate(d.getDate() - dow);
  d.setHours(0, 0, 0, 0);
  return d;
}
function rangeText(startDate) {
  const endDate = new Date(startDate);
  endDate.setDate(endDate.getDate() + 6);
  const opts = { month: "long" };
  const m1 = startDate.toLocaleString("default", opts);
  const m2 = endDate.toLocaleString("default", opts);
  const d1 = startDate.getDate();
  const d2 = endDate.getDate();
  const y = startDate.getFullYear();
  return m1 !== m2
    ? `${m1} ${d1} - ${m2} ${d2}, ${y}`
    : `${m1} ${d1} - ${d2}, ${y}`;
}

/* NEW: check if a slot minute falls in any availability-derived white slot rule */
function isWhiteSlotFor(dayIndex, isoDate, minuteOfDay) {
  const toMin = (hhmm) => {
    if (typeof hhmm === "number") return hhmm;
    const [h, m] = String(hhmm).split(":").map(Number);
    if (Number.isNaN(h)) return null;
    return h * 60 + (m || 0);
  };
  for (const rule of whiteSlotRules) {
    if (rule.date && rule.date !== isoDate) continue;
    if (typeof rule.dayIndex === "number" && rule.dayIndex !== dayIndex) {
      continue;
    }
    const s = toMin(rule.start),
      e = toMin(rule.end);
    if (s === null || e === null) continue;
    if (minuteOfDay >= s && minuteOfDay < e) return true;
  }
  return false;
}

/* ====== STATE ====== */
let currentWeekStart = mondayOf(new Date());

$(function () {
  const rows = (END_H - START_H) * (60 / SLOT_MIN);
  document.documentElement.style.setProperty("--rows", rows);

  /* ========= Create Cohort modal (uses your exact code) ========= */
  function openCreateCohortModal() {
    if (window.closeCohortOverlays) window.closeCohortOverlays();
    $("#calendar_admin_details_create_cohort_modal_backdrop").fadeIn();

    const $bd = $("#calendar_admin_details_create_cohort_modal_backdrop");
    $bd.find(".calendar_admin_details_create_cohort_tab").removeClass("active");
    $bd
      .find('.calendar_admin_details_create_cohort_tab[data-tab="cohort"]')
      .addClass("active");

    $("#calendar_admin_details_create_cohort_content").html("");
    $("#mergeTabContent").css("display", "none");
    $("#conferenceTabContent").css("display", "none");
    $("#peerTalkTabContent").css("display", "none");
    $("#addTimeTabContent").css("display", "none");
    $("#addExtraSlotsTabContent").css("display", "none");
    $("#manageclassTabContent").css("display", "none");
    $("#manage_cohort_tab_content").css("display", "none");
    $("#mainModalContent").css("display", "block");
    $("#classTabContent").css("display", "none");
  }

  /* ========= Open PeerTalk Modal With Event Data ========= */
  function openPeerTalkModalWithData(eventData) {
    console.log("Opening PeerTalk modal with data:", eventData);

    // Collect all events with the same eventid for recurrence
    let recurrenceEvents = [];
    if (eventData.eventid && window.events) {
      recurrenceEvents = window.events.filter(function (ev) {
        return (
          ev.eventid === eventData.eventid &&
          (ev.classType === "peertalk" || ev.source === "peertalk")
        );
      });

      console.log(
        `Found ${recurrenceEvents.length} peertalk events with eventid ${eventData.eventid}`
      );
    }

    // Show modal backdrop
    if (window.closeCohortOverlays) window.closeCohortOverlays();
    $("#calendar_admin_details_create_cohort_modal_backdrop").fadeIn();

    const $bd = $("#calendar_admin_details_create_cohort_modal_backdrop");

    // Activate peertalk tab
    $bd.find(".calendar_admin_details_create_cohort_tab").removeClass("active");
    $bd
      .find('.calendar_admin_details_create_cohort_tab[data-tab="peertalk"]')
      .addClass("active");

    // Hide other tab contents and show peertalk tab
    $("#calendar_admin_details_create_cohort_content").html("");
    $("#mergeTabContent").css("display", "none");
    $("#conferenceTabContent").css("display", "none");
    $("#addTimeTabContent").css("display", "none");
    $("#addExtraSlotsTabContent").css("display", "none");
    $("#manageclassTabContent").css("display", "none");
    $("#manage_cohort_tab_content").css("display", "none");
    $("#mainModalContent").css("display", "none");
    $("#classTabContent").css("display", "none");
    $("#peerTalkTabContent").css("display", "block");

    // Populate the peertalk form with event data and recurrence info
    populatePeerTalkForm(eventData, recurrenceEvents);
  }

  /* ========= Populate PeerTalk Form With Event Data ========= */
  function populatePeerTalkForm(eventData, recurrenceEvents) {
    console.log("Populating PeerTalk form with:", eventData);
    console.log("Recurrence events:", recurrenceEvents);

    // Populate date if available
    if (eventData.date) {
      const dateBtn = $(".peertalk_modal_date_btn");

      // Parse date properly to avoid timezone issues
      // eventData.date is in format "YYYY-MM-DD"
      const dateParts = eventData.date.split("-");
      const year = parseInt(dateParts[0], 10);
      const month = parseInt(dateParts[1], 10) - 1; // Month is 0-indexed
      const day = parseInt(dateParts[2], 10);
      const dateObj = new Date(year, month, day);

      const formattedDate = dateObj.toLocaleDateString("en-US", {
        month: "short",
        day: "numeric",
        year: "numeric",
      });
      dateBtn.text(formattedDate);
      dateBtn.data("raw-date", eventData.date);

      console.log(`Set date button: ${formattedDate} (raw: ${eventData.date})`);
    }

    // Populate cohorts if available - trigger clicks on the actual items
    if (eventData.cohortids && eventData.cohortids.length > 0) {
      // Wait a bit for the modal to be fully loaded
      setTimeout(function () {
        // Click each cohort item to trigger the existing selection logic
        eventData.cohortids.forEach(function (cohortId) {
          const $cohortItem = $(
            `#peertalkCohortsList li.peertalk_cohort_item[data-id="${cohortId}"]`
          );
          if ($cohortItem.length > 0) {
            console.log(
              "Clicking cohort:",
              cohortId,
              $cohortItem.text().trim()
            );
            $cohortItem.trigger("click");
          }
        });
      }, 100);
    }

    // Populate teachers if available - trigger click on the actual item
    if (eventData.teacherId) {
      // Wait a bit for the modal to be fully loaded
      setTimeout(function () {
        // Click the teacher item to trigger the existing selection logic
        const $teacherItem = $(
          `#peertalkTeachersList li.peertalk_teacher_item[data-userid="${eventData.teacherId}"]`
        );
        if ($teacherItem.length > 0) {
          console.log(
            "Clicking teacher:",
            eventData.teacherId,
            $teacherItem.find(".teacher_name").text().trim()
          );
          $teacherItem.trigger("click");
        }
      }, 150);
    }

    // Populate time if available
    if (eventData.start && eventData.end) {
      // Convert minutes to time format
      function minutesToTime(mins) {
        const hours = Math.floor(mins / 60);
        const minutes = mins % 60;
        return (
          String(hours).padStart(2, "0") +
          ":" +
          String(minutes).padStart(2, "0")
        );
      }

      console.log(
        "Event times - Start:",
        eventData.start,
        "End:",
        eventData.end
      );
      // These are already in minutes since midnight, so we can use them directly
      // Note: The calendar might have already converted them, so we check the type
      const startMins =
        typeof eventData.start === "number"
          ? eventData.start
          : parseInt(eventData.start);
      const endMins =
        typeof eventData.end === "number"
          ? eventData.end
          : parseInt(eventData.end);

      console.log(
        "Converted times - Start mins:",
        startMins,
        "End mins:",
        endMins
      );
    }

    // Populate title if available
    if (eventData.title) {
      // There might be a title field in the peertalk form - look for it
      const $titleInput = $("#peerTalkForm")
        .find('input[name="title"], input[type="text"]')
        .first();
      if ($titleInput.length > 0) {
        $titleInput.val(eventData.title);
      }
    }

    // Populate color if available
    if (eventData.color) {
      // Update color dropdown
      const colorValue = eventData.color.replace("e-", "#"); // Convert e-purple to color code if needed
      // You might need to adjust this based on how colors are stored
    }

    // Build custom recurrence array from events with same eventid
    if (recurrenceEvents && recurrenceEvents.length > 0) {
      const customRecurrenceArray = recurrenceEvents.map(function (ev) {
        console.log("Processing recurrence event:", ev);

        // Convert minutes (from midnight) to HH:MM format
        function minutesToTime(minutes) {
          if (minutes === undefined || minutes === null) return "00:00";
          const h = Math.floor(minutes / 60);
          const m = minutes % 60;
          return String(h).padStart(2, "0") + ":" + String(m).padStart(2, "0");
        }

        // Convert timestamp to HH:MM format
        function timestampToTime(ts) {
          if (!ts) return "00:00";
          const date = new Date(ts * 1000); // Convert seconds to milliseconds
          const h = date.getHours();
          const m = date.getMinutes();
          return String(h).padStart(2, "0") + ":" + String(m).padStart(2, "0");
        }

        // Convert timestamp to YYYY-MM-DD date
        function timestampToDate(ts) {
          if (!ts) return "";
          const date = new Date(ts * 1000);
          const year = date.getFullYear();
          const month = String(date.getMonth() + 1).padStart(2, "0");
          const day = String(date.getDate()).padStart(2, "0");
          return `${year}-${month}-${day}`;
        }

        // Get date from timestamp or existing date
        const eventDate = ev.start_ts ? timestampToDate(ev.start_ts) : ev.date;

        // Parse date to get day name
        const dateObj = new Date(eventDate);
        const dayNames = [
          "Sunday",
          "Monday",
          "Tuesday",
          "Wednesday",
          "Thursday",
          "Friday",
          "Saturday",
        ];
        const dayName = dayNames[dateObj.getDay()];

        // Get times - handle different formats
        let startTime, endTime;

        console.log(
          `Event data - start: ${ev.start} (type: ${typeof ev.start}), end: ${
            ev.end
          } (type: ${typeof ev.end}), start_ts: ${ev.start_ts}, end_ts: ${
            ev.end_ts
          }`
        );

        // Check if start/end are already in HH:MM format (string)
        if (typeof ev.start === "string" && ev.start.includes(":")) {
          startTime = ev.start;
          endTime = ev.end;
          console.log(`Using time strings directly: ${startTime} - ${endTime}`);
        }
        // Check if start/end are numbers (minutes from midnight)
        else if (typeof ev.start === "number" && !isNaN(ev.start)) {
          startTime = minutesToTime(ev.start);
          endTime = minutesToTime(ev.end);
          console.log(`Converted from minutes: ${startTime} - ${endTime}`);
        }
        // Try parsing as numbers
        else if (!isNaN(parseInt(ev.start, 10))) {
          const startMinutes = parseInt(ev.start, 10);
          const endMinutes = parseInt(ev.end, 10);
          startTime = minutesToTime(startMinutes);
          endTime = minutesToTime(endMinutes);
          console.log(`Parsed and converted: ${startTime} - ${endTime}`);
        }
        // Fall back to timestamps
        else if (ev.start_ts) {
          startTime = timestampToTime(ev.start_ts);
          endTime = timestampToTime(ev.end_ts);
          console.log(`Converted from timestamps: ${startTime} - ${endTime}`);
        }
        // Default fallback
        else {
          startTime = "00:00";
          endTime = "00:00";
          console.log(`Using default times: ${startTime} - ${endTime}`);
        }

        return {
          date: eventDate, // Start date (YYYY-MM-DD)
          day: dayName, // Day name
          start_time: startTime, // Start time (HH:MM)
          end_time: endTime, // End time (HH:MM)
          start_ts: ev.start_ts, // Start timestamp
          end_ts: ev.end_ts, // End timestamp
        };
      });

      console.log("Custom recurrence array built:", customRecurrenceArray);

      // Store the recurrence array globally or in a data attribute for form submission
      window.peerTalkRecurrenceData = customRecurrenceArray;

      // Update the repeat button text in the format: "Weekly on Mon(09:00 AM - 10:00 AM), Tue(09:00 AM - 10:00 AM)"
      const $repeatBtn = $(".peertalk_repeat_btn");
      if ($repeatBtn.length > 0) {
        // Convert 24h time to 12h format with AM/PM
        function formatTime12h(time24) {
          const [hours, minutes] = time24.split(":").map(Number);
          const period = hours >= 12 ? "PM" : "AM";
          const hours12 = hours % 12 || 12;
          return `${String(hours12).padStart(2, "0")}:${String(
            minutes
          ).padStart(2, "0")} ${period}`;
        }

        // Get short day names
        const shortDays = {
          Sunday: "Sun",
          Monday: "Mon",
          Tuesday: "Tue",
          Wednesday: "Wed",
          Thursday: "Thu",
          Friday: "Fri",
          Saturday: "Sat",
        };

        // Build the text: "Weekly on Mon(time), Tue(time), ..."
        const dayTimeParts = customRecurrenceArray.map(function (item) {
          const shortDay = shortDays[item.day];
          const startTime12 = formatTime12h(item.start_time);
          const endTime12 = formatTime12h(item.end_time);
          return `${shortDay}(<span class="time-range">${startTime12} - ${endTime12}</span>)`;
        });

        const repeatText = "Weekly on " + dayTimeParts.join(", ");

        // Update button HTML while preserving the arrow
        $repeatBtn.html(
          repeatText + '<span style="float:right; font-size:1rem;">▼</span>'
        );

        console.log("Updated repeat button to:", repeatText);
      }

      // Optionally populate the custom recurrence UI if it exists
      populateCustomRecurrenceUI(customRecurrenceArray);
    }
  }

  /* ========= Populate Custom Recurrence UI ========= */
  function populateCustomRecurrenceUI(recurrenceArray) {
    // Find the custom recurrence container (adjust selector based on your HTML)
    const $recurrenceContainer = $("#peertalk_custom_recurrence_container");

    if ($recurrenceContainer.length === 0) {
      console.log("Custom recurrence container not found");
      return;
    }

    // Clear existing content
    $recurrenceContainer.empty();

    // Build the recurrence UI
    recurrenceArray.forEach(function (item, index) {
      const $row = $(`
        <div class="recurrence-item" data-index="${index}">
          <span class="recurrence-date">${item.date}</span>
          <span class="recurrence-day">${item.day}</span>
          <span class="recurrence-time">${item.start_time} - ${item.end_time}</span>
          <button type="button" class="remove-recurrence-item" data-index="${index}">×</button>
        </div>
      `);
      $recurrenceContainer.append($row);
    });

    console.log(`Populated ${recurrenceArray.length} recurrence items in UI`);
  }

  // Expose function globally for testing
  window.openPeerTalkModalWithData = openPeerTalkModalWithData;

  /* ========= Handle PeerTalk Repeat Button Click ========= */
  $(document).on("click", ".peertalk_repeat_btn", function (e) {
    e.preventDefault();
    e.stopPropagation();

    console.log("PeerTalk repeat button clicked");

    // Check if we have recurrence data
    if (
      window.peerTalkRecurrenceData &&
      window.peerTalkRecurrenceData.length > 0
    ) {
      console.log(
        "Populating custom recurrence modal with:",
        window.peerTalkRecurrenceData
      );

      // Open the custom recurrence modal
      $("#customRecurrenceModalBackdrop").fadeIn();

      // Populate the modal with existing recurrence data
      setTimeout(function () {
        populateCustomRecurrenceModal(window.peerTalkRecurrenceData);
      }, 100);
    } else {
      console.log("No recurrence data available");
    }
  });

  /* ========= Populate Custom Recurrence Modal ========= */
  function populateCustomRecurrenceModal(recurrenceArray) {
    console.log("Populating custom recurrence modal with:", recurrenceArray);

    if (!recurrenceArray || recurrenceArray.length === 0) {
      console.log("No recurrence data to populate");
      return;
    }

    // Map day names to day keys (0=Sunday, 1=Monday, etc.)
    const dayNameToKey = {
      Sunday: 0,
      Monday: 1,
      Tuesday: 2,
      Wednesday: 3,
      Thursday: 4,
      Friday: 5,
      Saturday: 6,
    };

    // Set "Repeat Every 1 Week"
    $("#customrec_interval").text("1");
    $("#customrec_period_val").text("Week");

    // Get unique days from recurrence array and their times
    const dayTimesMap = {};
    recurrenceArray.forEach(function (item) {
      const dayKey = dayNameToKey[item.day];
      if (dayKey !== undefined) {
        if (!dayTimesMap[dayKey]) {
          dayTimesMap[dayKey] = [];
        }
        dayTimesMap[dayKey].push({
          start_time: item.start_time,
          end_time: item.end_time,
        });
      }
    });

    console.log("Day times map:", dayTimesMap);

    // Helper function to format time to 12h with AM/PM
    function formatTime12h(time24) {
      const [hours, minutes] = time24.split(":");
      let h = parseInt(hours, 10);
      const ampm = h >= 12 ? "PM" : "AM";
      h = h % 12 || 12;
      const formattedTime = (h < 10 ? "0" + h : h) + ":" + minutes;
      console.log(`formatTime12h: ${time24} -> ${formattedTime} ${ampm}`);
      return { time: formattedTime, period: ampm };
    }

    // Select and set times for each day widget
    Object.keys(dayTimesMap).forEach(function (dayKey) {
      const $widget = $(`.scroll-widget[data-key="${dayKey}"]`);
      if ($widget.length > 0) {
        // Mark widget as selected
        $widget.attr("aria-pressed", "true");
        $widget.addClass("selected active");

        // Get the first time entry for this day
        const times = dayTimesMap[dayKey];
        const firstTime = times[0];

        // Format start and end times
        const startFormatted = formatTime12h(firstTime.start_time);
        const endFormatted = formatTime12h(firstTime.end_time);

        // Find or create the time display container
        let $timeContainer = $widget.find(".scroll-widget__time");
        if ($timeContainer.length === 0) {
          $timeContainer = $(
            '<div class="scroll-widget__time has-time"></div>'
          );
          $widget.find(".scroll-widget__divider").after($timeContainer);
        } else {
          $timeContainer.addClass("has-time");
        }

        // Populate time display
        $timeContainer.html(`
          <div class="scroll-widget__hm s">${startFormatted.time}</div>
          <span class="scroll-widget__period sp">${startFormatted.period}</span>
          <span class="scroll-widget__dash">-</span>
          <div class="scroll-widget__hm e">${endFormatted.time}</div>
          <span class="scroll-widget__period ep">${endFormatted.period}</span>
        `);

        // Add has-time class to button
        $widget.find(".scroll-widget__button").addClass("has-time");

        // Store time data on the widget
        $widget.data("times", times);

        console.log(`Selected day ${dayKey} with times:`, times);
      }
    });

    // Set end date from last occurrence
    if (recurrenceArray.length > 0) {
      const lastItem = recurrenceArray[recurrenceArray.length - 1];
      const endDate = new Date(lastItem.date);
      const formattedEndDate = endDate.toLocaleDateString("en-US", {
        month: "short",
        day: "numeric",
        year: "numeric",
      });

      // Set "Ends On" option
      $("#customrec_end_on").prop("checked", true);
      $("#customrec_end_date_btn")
        .text(formattedEndDate)
        .prop("disabled", false);
      $("#customrec_occ_val")
        .closest(".customrec_occurrence_counter")
        .find(".customrec_stepper")
        .prop("disabled", true);
    }

    // Set occurrence count
    $("#customrec_occ_val").text(`${recurrenceArray.length} occurrences`);

    console.log(
      `Populated custom recurrence modal with ${recurrenceArray.length} occurrences`
    );
  }

  // Expose globally
  window.populateCustomRecurrenceModal = populateCustomRecurrenceModal;

  /* ========= Open Conference Modal With Event Data ========= */
  function openConferenceModalWithData(eventData) {
    console.log("Opening Conference modal with data:", eventData);

    // Collect all events with the same eventid for recurrence
    let recurrenceEvents = [];
    if (eventData.eventid && window.events) {
      recurrenceEvents = window.events.filter(function (ev) {
        return (
          ev.eventid === eventData.eventid &&
          (ev.classType === "conference" || ev.source === "conference")
        );
      });

      console.log(
        `Found ${recurrenceEvents.length} conference events with eventid ${eventData.eventid}`
      );
    }

    // Show modal backdrop
    if (window.closeCohortOverlays) window.closeCohortOverlays();
    $("#calendar_admin_details_create_cohort_modal_backdrop").fadeIn();

    const $bd = $("#calendar_admin_details_create_cohort_modal_backdrop");

    // Activate conference tab
    $bd.find(".calendar_admin_details_create_cohort_tab").removeClass("active");
    $bd
      .find('.calendar_admin_details_create_cohort_tab[data-tab="conference"]')
      .addClass("active");

    // Hide other tab contents and show conference tab
    $("#calendar_admin_details_create_cohort_content").html("");
    $("#mergeTabContent").css("display", "none");
    $("#peerTalkTabContent").css("display", "none");
    $("#addTimeTabContent").css("display", "none");
    $("#addExtraSlotsTabContent").css("display", "none");
    $("#manageclassTabContent").css("display", "none");
    $("#manage_cohort_tab_content").css("display", "none");
    $("#mainModalContent").css("display", "none");
    $("#classTabContent").css("display", "none");
    $("#conferenceTabContent").css("display", "block");

    // Populate the conference form with event data and recurrence info
    populateConferenceForm(eventData, recurrenceEvents);
  }

  /* ========= Populate Conference Form With Event Data ========= */
  function populateConferenceForm(eventData, recurrenceEvents) {
    console.log("Populating Conference form with:", eventData);
    console.log("Recurrence events:", recurrenceEvents);

    // Clear existing selections first
    setTimeout(function () {
      $(".conference_modal_cohort_list").empty();
      $(".conference_modal_students_list").empty();
      $(".conference_modal_attendees_list").empty();
    }, 50);

    // Populate date if available
    if (eventData.date) {
      const dateBtn = $(".conference_modal_date_btn");

      // Parse date properly to avoid timezone issues
      // eventData.date is in format "YYYY-MM-DD"
      const dateParts = eventData.date.split("-");
      const year = parseInt(dateParts[0], 10);
      const month = parseInt(dateParts[1], 10) - 1; // Month is 0-indexed
      const day = parseInt(dateParts[2], 10);
      const dateObj = new Date(year, month, day);

      const formattedDate = dateObj.toLocaleDateString("en-US", {
        month: "short",
        day: "numeric",
        year: "numeric",
      });
      dateBtn.text(formattedDate);
      dateBtn.data("raw-date", eventData.date);

      console.log(`Set date button: ${formattedDate} (raw: ${eventData.date})`);
    }

    // Populate cohorts if available - trigger clicks on the actual items
    if (eventData.cohortids && eventData.cohortids.length > 0) {
      console.log("Populating conference cohorts:", eventData.cohortids);
      // Wait a bit for the modal to be fully loaded
      setTimeout(function () {
        // Click each cohort item to trigger the existing selection logic
        eventData.cohortids.forEach(function (cohortId, index) {
          setTimeout(function () {
            const $cohortItem = $(
              `#conferenceCohortsList li.conference_cohort_item[data-id="${cohortId}"]`
            );
            if ($cohortItem.length > 0) {
              console.log(
                "Clicking conference cohort:",
                cohortId,
                $cohortItem.text().trim()
              );
              $cohortItem.trigger("click");
            } else {
              console.warn("Conference cohort not found:", cohortId);
            }
          }, index * 50); // Stagger clicks
        });
      }, 200);
    }

    // Populate students if available
    if (eventData.studentids && eventData.studentids.length > 0) {
      console.log("Populating conference students:", eventData.studentids);
      // Wait a bit for the modal to be fully loaded
      setTimeout(function () {
        // Click each student item to trigger the existing selection logic
        eventData.studentids.forEach(function (studentId, index) {
          setTimeout(function () {
            const $studentItem = $(
              `#conferenceStudentsList li.conference_student_item[data-userid="${studentId}"]`
            );
            if ($studentItem.length > 0) {
              console.log(
                "Clicking conference student:",
                studentId,
                $studentItem.text().trim()
              );
              $studentItem.trigger("click");
            } else {
              console.warn("Conference student not found:", studentId);
            }
          }, index * 50); // Stagger clicks
        });
      }, 400);
    }

    // Populate teachers if available - trigger click on the actual item
    if (eventData.teacherId) {
      console.log("Populating conference teacher:", eventData.teacherId);
      // Wait a bit for the modal to be fully loaded
      setTimeout(function () {
        // Try both teacher lists (view 1 and view 2)
        const $teacherItem1 = $(
          `#conferenceTeachersList li.conference_teacher_item[data-userid="${eventData.teacherId}"]`
        );
        const $teacherItem2 = $(
          `#conferenceTeachersList2 li.conference_teacher_item[data-userid="${eventData.teacherId}"]`
        );

        if ($teacherItem1.length > 0) {
          console.log(
            "Clicking conference teacher (view 1):",
            eventData.teacherId,
            $teacherItem1.text().trim()
          );
          $teacherItem1.trigger("click");
        } else if ($teacherItem2.length > 0) {
          console.log(
            "Clicking conference teacher (view 2):",
            eventData.teacherId,
            $teacherItem2.text().trim()
          );
          $teacherItem2.trigger("click");
        } else {
          console.warn("Conference teacher not found:", eventData.teacherId);
        }
      }, 600);
    }

    // Populate time if available
    if (eventData.start && eventData.end) {
      const startMins =
        typeof eventData.start === "number"
          ? eventData.start
          : parseInt(eventData.start);
      const endMins =
        typeof eventData.end === "number"
          ? eventData.end
          : parseInt(eventData.end);

      console.log(
        "Converted times - Start mins:",
        startMins,
        "End mins:",
        endMins
      );
    }

    // Populate title if available
    if (eventData.title) {
      const $titleInput = $("#conferenceForm .addtime-title-input");
      if ($titleInput.length > 0) {
        $titleInput.val(eventData.title);
        console.log("Set conference title to:", eventData.title);
      }
    }

    // Populate color if available
    if (eventData.color) {
      const $colorCircle = $("#conferenceForm .color-circle");
      const $colorToggle = $("#colorDropdownToggle");
      if ($colorCircle.length > 0) {
        $colorCircle.css("background", eventData.color);
        console.log("Set conference color to:", eventData.color);
      }
    }

    // Populate timezone if available
    if (eventData.timezone) {
      const $timezoneSelected = $(
        "#eventTimezoneDropdown_conference_tab_selected"
      );
      if ($timezoneSelected.length > 0) {
        $timezoneSelected.text(eventData.timezone);
        console.log("Set conference timezone to:", eventData.timezone);
      }
    }

    // Build custom recurrence array from events with same eventid
    if (recurrenceEvents && recurrenceEvents.length > 0) {
      const customRecurrenceArray = recurrenceEvents.map(function (ev) {
        const eventDate = ev.date;
        const dateObj = new Date(eventDate);
        const dayNames = [
          "Sunday",
          "Monday",
          "Tuesday",
          "Wednesday",
          "Thursday",
          "Friday",
          "Saturday",
        ];
        const dayName = dayNames[dateObj.getDay()];

        function minutesToTime(mins) {
          const h = Math.floor(mins / 60);
          const m = mins % 60;
          const hh = h.toString().padStart(2, "0");
          const mm = m.toString().padStart(2, "0");
          return `${hh}:${mm}`;
        }

        const startMins =
          typeof ev.start === "number" ? ev.start : parseInt(ev.start);
        const endMins = typeof ev.end === "number" ? ev.end : parseInt(ev.end);

        const startTime = minutesToTime(startMins);
        const endTime = minutesToTime(endMins);

        return {
          date: eventDate,
          day: dayName,
          start_time: startTime,
          end_time: endTime,
          start_ts: ev.start_ts,
          end_ts: ev.end_ts,
        };
      });

      console.log(
        "Conference custom recurrence array built:",
        customRecurrenceArray
      );

      // Store the recurrence array globally for form submission
      window.conferenceRecurrenceData = customRecurrenceArray;

      // Update the repeat button text
      const $repeatBtn = $(".conference_repeat_btn");
      if ($repeatBtn.length > 0) {
        function formatTime12h(time24) {
          const [hours, minutes] = time24.split(":");
          let h = parseInt(hours, 10);
          const ampm = h >= 12 ? "PM" : "AM";
          h = h % 12 || 12;
          return `${h < 10 ? "0" + h : h}:${minutes} ${ampm}`;
        }

        const shortDays = {
          Sunday: "Sun",
          Monday: "Mon",
          Tuesday: "Tue",
          Wednesday: "Wed",
          Thursday: "Thu",
          Friday: "Fri",
          Saturday: "Sat",
        };

        const dayTimeParts = customRecurrenceArray.map(function (item) {
          const shortDay = shortDays[item.day] || item.day.substring(0, 3);
          const time = formatTime12h(item.start_time);
          return `${shortDay}(${time})`;
        });

        const repeatText = "Weekly on " + dayTimeParts.join(", ");

        $repeatBtn.html(
          repeatText + '<span style="float:right; font-size:1rem;">▼</span>'
        );

        console.log("Updated conference repeat button to:", repeatText);
      }
    }
  }

  // Expose function globally for testing
  window.openConferenceModalWithData = openConferenceModalWithData;

  // // Button → open same modal (kept your trigger class)
  // $(".calendar_admin_details_create_cohort_open")
  //   .off("click.openCohort")
  //   .on("click.openCohort", function (e) {
  //     e.preventDefault();
  //     openCreateCohortModal();
  //   });

  /* ====== CLICK: event -> bring to front + open menu ====== */
  let zSeed = 5000;
  let currentClickedEvent = null; // Store the clicked event data

  // Expose globally
  window.getCurrentClickedEvent = function () {
    return currentClickedEvent;
  };

  $("#grid")
    .off("mousedown", ".event")
    .on("mousedown", ".event", function (e) {
      e.preventDefault();
      e.stopPropagation();

      const $clicked = $(this);
      const $day = $clicked.closest(".day-inner");
      const cs = +$clicked.data("start"),
        ce = +$clicked.data("end");

      const $group = $day.find(".event").filter(function () {
        const s = +$(this).data("start"),
          e = +$(this).data("end");
        return !(e <= cs || s >= ce);
      });

      $group.each(function () {
        this.style.zIndex = "";
      });
      this.style.zIndex = (++zSeed).toString();

      // Highlight active event and gently dim overlapping neighbors for readability
      $(".event").removeClass("event-active event-dimmed");
      $clicked.addClass("event-active");
      $group.not($clicked).addClass("event-dimmed");

      // Find the event data from window.events
      const dateStr = $day.data("date");
      const teacherId = $clicked.data("teacher-id");
      const eventStart = $clicked.data("start");
      const eventEnd = $clicked.data("end");

      // Find matching event from window.events array
      currentClickedEvent = window.events.find((ev) => {
        const evDate = ev.date;
        const evStart =
          typeof ev.start === "string" ? minutes(ev.start) : ev.start;
        const evEnd = typeof ev.end === "string" ? minutes(ev.end) : ev.end;
        return (
          evDate === dateStr && evStart === eventStart && evEnd === eventEnd
        );
      });

      // Check event type and open appropriate modal or menu
      if (currentClickedEvent) {
        const classType = currentClickedEvent.classType;
        const source = currentClickedEvent.source;

        console.log(
          "Event clicked - classType:",
          classType,
          "source:",
          source,
          "Full event:",
          currentClickedEvent
        );

        // Teacher time off: open Time Off modal
        if (classType === "teacher_timeoff" || source === "teacher_timeoff") {
          if (typeof window.openTimeOffModal === "function") {
            window.openTimeOffModal(currentClickedEvent);
          }
          return;
        }

        // Check if event is cancelled (cancel_no_makeup) - show reason modal
        const activeStatus = getActiveStatusMeta(
          currentClickedEvent.statuses || []
        );
        console.log(
          "Active status for clicked event:",
          activeStatus,
          "Statuses:",
          currentClickedEvent.statuses
        );

        if (activeStatus && activeStatus.code === "cancel_no_makeup") {
          console.log(
            "Opening Reason of Cancellation modal for cancelled event",
            currentClickedEvent
          );
          if (typeof window.openReasonOfCancellationModal === "function") {
            window.openReasonOfCancellationModal(currentClickedEvent);
          } else {
            console.error("openReasonOfCancellationModal function not found");
          }
          return;
        }

        // Check if it's a peertalk event
        if (classType === "peertalk" || source === "peertalk") {
          // Open peertalk modal with event data
          openPeerTalkModalWithData(currentClickedEvent);
          return;
        }
        // Check if it's a conference event
        else if (classType === "conference" || source === "conference") {
          console.log(
            "Opening conference modal for event:",
            currentClickedEvent
          );
          // Open conference modal with event data
          openConferenceModalWithData(currentClickedEvent);
          return;
        }
        // Check if it's NOT a 1:1 lesson (for regular group lessons)
        else if (
          classType !== "one2one_weekly" &&
          classType !== "one2one_single"
        ) {
          // This is a group lesson, open the dropdown menu
          openMenuOptionsDropdown(e, this);
          return;
        }
        // If it's a 1:1 lesson, do nothing (no dropdown)
      }
    });

  // Function to open menu options dropdown
  function openMenuOptionsDropdown(event, eventElement) {
    const dropdown = document.getElementById("menu-options");
    const menuContainer = dropdown.querySelector(".menu-container");
    if (!dropdown || !menuContainer) return;

    const activeStatus = getActiveStatusMeta(
      (currentClickedEvent && currentClickedEvent.statuses) || []
    );
    const isCancelRescheduleLater =
      activeStatus && activeStatus.code === "cancel_reschedule_later";

    const toggleMenuItem = (href, show) => {
      const link = menuContainer.querySelector(`a[href="${href}"]`);
      if (!link) return;
      const holder = link.closest(".menu-item") || link.closest("li") || link;
      holder.style.display = show ? "" : "none";
    };

    // Hide manage + cancel-reschedule-later options when status is cancel_reschedule_later
    toggleMenuItem("#manage-session", !isCancelRescheduleLater);
    toggleMenuItem("#cancel-reschedule-later", !isCancelRescheduleLater);

    // Hide the default menu list entirely when CRL, only show the CRL panel
    const menuList = menuContainer.querySelector(".menu-list");
    if (menuList) {
      menuList.style.display = isCancelRescheduleLater ? "none" : "";
    }

    // Build / toggle the dedicated panel for make-up vs no-make-up actions
    let crlPanel = menuContainer.querySelector(
      ".cancel-reschedule-later-panel"
    );

    if (!crlPanel) {
      crlPanel = document.createElement("div");
      crlPanel.className = "cancel-reschedule-later-panel";
      crlPanel.style.display = "none";
      crlPanel.style.flexDirection = "column";
      crlPanel.style.gap = "6px";
      crlPanel.innerHTML = `
        <a href="#schedule-makeup-now" class="menu-link crl-option" style="display:flex; align-items:center; gap:10px; padding:10px 12px; border-radius:10px; background:#f7f7f7; text-decoration:none;">
          <span style="width:20px; height:20px; display:inline-flex; align-items:center; justify-content:center;">
            <img src="./img/manage-session-reschedule.svg" alt="Schedule Make-up Now" style="width:20px; height:20px;">
          </span>
          <span style="color:#111; font-weight:500;">Schedule Make-up Now</span>
        </a>
        <a href="#cancel-no-makeup" class="menu-link crl-option" style="display:flex; align-items:center; gap:10px; padding:10px 12px; border-radius:10px; background:#fff; text-decoration:none; border:1px solid #f3f3f3;">
          <span style="width:20px; height:20px; display:inline-flex; align-items:center; justify-content:center;">
            <img src="./img/cancel-no-make-up.svg" alt="Cancel (no make-up)" style="width:20px; height:20px;">
          </span>
          <span style="color:#d44333; font-weight:600;">Cancel (no make-up)</span>
        </a>
      `;
      menuContainer.appendChild(crlPanel);
    }
    crlPanel.style.display = isCancelRescheduleLater ? "flex" : "none";

    // Close any existing dropdown
    closeMenuOptionsDropdown();

    // Show dropdown
    dropdown.style.display = "block";

    // Position the dropdown near the clicked event
    const eventRect = eventElement.getBoundingClientRect();
    const dropdownRect = menuContainer.getBoundingClientRect();
    const viewportWidth = window.innerWidth;
    const viewportHeight = window.innerHeight;

    // Calculate position (try to place to the right of the event)
    let left = eventRect.right + 10;
    let top = eventRect.top;

    // Adjust if dropdown goes off screen to the right
    if (left + dropdownRect.width > viewportWidth) {
      left = eventRect.left - dropdownRect.width - 10;
    }

    // Adjust if dropdown goes off screen to the left
    if (left < 10) {
      left = 10;
    }

    // Adjust if dropdown goes off screen at bottom
    if (top + dropdownRect.height > viewportHeight) {
      top = viewportHeight - dropdownRect.height - 10;
    }

    // Adjust if dropdown goes off screen at top
    if (top < 10) {
      top = 10;
    }

    menuContainer.style.left = left + "px";
    menuContainer.style.top = top + "px";
  }

  // Function to close menu options dropdown
  window.closeMenuOptionsDropdown = function () {
    const dropdown = document.getElementById("menu-options");
    if (dropdown) {
      dropdown.style.display = "none";
    }
  };

  // Close dropdown when clicking outside
  $(document).on("click", function (e) {
    const dropdown = document.getElementById("menu-options");
    if (dropdown && dropdown.style.display === "block") {
      if (!$(e.target).closest("#menu-options, .event").length) {
        closeMenuOptionsDropdown();
      }
    }
  });

  // Close dropdown with ESC key
  $(document).on("keydown", function (e) {
    if (e.key === "Escape") {
      closeMenuOptionsDropdown();
    }
  });

  // Handle menu option clicks
  $(document).on("click", "#menu-options .menu-link", function (e) {
    e.preventDefault();
    const href = $(this).attr("href");

    if (href === "#manage-cohort" && currentClickedEvent) {
      // Close the dropdown
      closeMenuOptionsDropdown();

      // Open manage cohort modal with the event data
      openManageCohortModal(currentClickedEvent);
    } else if (href === "#manage-session" && currentClickedEvent) {
      // Close the dropdown
      closeMenuOptionsDropdown();

      // Open manage session modal with the event data
      openManageSessionModal(currentClickedEvent);
    } else if (href === "#cancel-reschedule" && currentClickedEvent) {
      // Close the dropdown
      closeMenuOptionsDropdown();

      // Open cancel and reschedule modal
      openCancelRescheduleModal(currentClickedEvent);
    } else if (href === "#cancel" && currentClickedEvent) {
      // Close the dropdown
      closeMenuOptionsDropdown();

      // Open cancel (no make-up) modal
      openCancelNoMakeupModal(currentClickedEvent);
    } else if (href === "#schedule-makeup-now" && currentClickedEvent) {
      closeMenuOptionsDropdown();
      // Open manage session modal instead of cancel/reschedule
      openManageSessionModal(currentClickedEvent);
    } else if (href === "#cancel-no-makeup" && currentClickedEvent) {
      closeMenuOptionsDropdown();
      openCancelNoMakeupModal(currentClickedEvent);
    }
  });

  // Function to open manage cohort modal with event data
  function openManageCohortModal(eventData) {
    console.log("Opening Manage Cohort modal for:", eventData);

    // Check if event has cohort data
    if (
      !eventData.cohortids ||
      !Array.isArray(eventData.cohortids) ||
      eventData.cohortids.length === 0
    ) {
      // Show alert that cohort data is not available
      alert("Cohort data is not available for this event.");
      return;
    }

    // Store event data globally so other scripts can access it
    window.currentEventData = eventData;

    // Trigger the existing manage cohort button click or open modal directly
    $("#calendar_admin_details_manage_cohort").trigger("click");

    // Wait for modal to open and then populate with event data
    setTimeout(() => {
      populateManageCohortModal(eventData);
    }, 300);
  }

  // Function to populate manage cohort modal with event data
  function populateManageCohortModal(eventData) {
    if (!eventData) return;

    console.log("Populating manage cohort modal with:", eventData);

    // If event has cohort ID, select it in the dropdown
    if (eventData.cohortids && eventData.cohortids.length > 0) {
      const cohortId = eventData.cohortids[0]; // Use first cohort
      console.log("Selecting cohort ID:", cohortId);

      // Find the cohort in the dropdown list by cohort ID
      const $cohortList = $("#cohortList");
      const $cohortItem = $cohortList.find(`li[data-cohort-id="${cohortId}"]`);

      if ($cohortItem.length) {
        console.log("Found cohort item:", $cohortItem.text());

        // Update the dropdown button text
        const cohortText = $cohortItem.text().trim();
        $("#cohortDropdownBtn").contents().first()[0].textContent =
          cohortText + " ";

        // Trigger the click to select it (this should trigger any existing event handlers)
        $cohortItem.trigger("click");

        // Close the dropdown
        $("#cohortDropdownList").hide();
      } else {
        console.warn("Cohort not found in list:", cohortId);
      }
    }

    // Populate teacher if available
    if (eventData.teacherId) {
      console.log("Event teacher ID:", eventData.teacherId);
      // Teacher selection will be handled by the manage cohort modal's existing logic
    }

    // Populate date and time if available
    if (eventData.date) {
      console.log("Event date:", eventData.date);
      console.log(
        "Event time:",
        fmt12(eventData.start),
        "-",
        fmt12(eventData.end)
      );
    }

    // Store additional event data for later use
    if (eventData.eventid) {
      console.log("Event ID:", eventData.eventid);
    }
    if (eventData.googlemeetid) {
      console.log("Google Meet ID:", eventData.googlemeetid);
    }
  }

  // Function to open Cancel & Reschedule modal
  function openCancelRescheduleModal(eventData) {
    console.log("Opening Cancel & Reschedule modal for:", eventData);
    $("#cancel-reschedule-modal").data("eventData", eventData);
    // Format the event date and time for display
    let dateStr = "";
    let startTime = "";
    let endTime = "";

    // Parse date from eventData.date (YYYY-MM-DD format)
    if (eventData.date) {
      const dateParts = eventData.date.split("-");
      if (dateParts.length === 3) {
        const year = dateParts[0];
        const month = parseInt(dateParts[1], 10);
        const day = parseInt(dateParts[2], 10);
        const monthNames = [
          "January",
          "February",
          "March",
          "April",
          "May",
          "June",
          "July",
          "August",
          "September",
          "October",
          "November",
          "December",
        ];
        const dateObj = new Date(year, month - 1, day);
        const dayNames = [
          "Sunday",
          "Monday",
          "Tuesday",
          "Wednesday",
          "Thursday",
          "Friday",
          "Saturday",
        ];
        dateStr = `${dayNames[dateObj.getDay()]}, ${
          monthNames[month - 1]
        } ${day}`;
      }
    }

    // Parse start and end times (HH:MM format) using fmt12 function
    if (eventData.start) {
      const startMinutes = minutes(eventData.start);
      startTime = fmt12(startMinutes);
    }
    if (eventData.end) {
      const endMinutes = minutes(eventData.end);
      endTime = fmt12(endMinutes);
    }

    const fullDateTime = `${dateStr}, ${startTime}-${endTime}`;

    // Update modal subtitle with event details
    $("#cancel-reschedule-modal .cr-subtitle").text(fullDateTime);

    // Show the modal
    $("#cancel-reschedule-modal").fadeIn(300);
  }

  // Function to open Cancel (No Make-Up) modal
  function openCancelNoMakeupModal(eventData) {
    console.log("Opening Cancel (No Make-Up) modal for:", eventData);

    $("#cancel-nomakeup-modal").data("eventData", eventData);
    // Format the event date and time for display
    let dateStr = "";
    let startTime = "";
    let endTime = "";

    // Parse date from eventData.date (YYYY-MM-DD format)
    if (eventData.date) {
      const dateParts = eventData.date.split("-");
      if (dateParts.length === 3) {
        const year = dateParts[0];
        const month = parseInt(dateParts[1], 10);
        const day = parseInt(dateParts[2], 10);
        const monthNames = [
          "January",
          "February",
          "March",
          "April",
          "May",
          "June",
          "July",
          "August",
          "September",
          "October",
          "November",
          "December",
        ];
        const dateObj = new Date(year, month - 1, day);
        const dayNames = [
          "Sunday",
          "Monday",
          "Tuesday",
          "Wednesday",
          "Thursday",
          "Friday",
          "Saturday",
        ];
        dateStr = `${dayNames[dateObj.getDay()]}, ${
          monthNames[month - 1]
        } ${day}`;
      }
    }

    // Parse start and end times (HH:MM format) using fmt12 function
    if (eventData.start) {
      const startMinutes = minutes(eventData.start);
      startTime = fmt12(startMinutes);
    }
    if (eventData.end) {
      const endMinutes = minutes(eventData.end);
      endTime = fmt12(endMinutes);
    }

    const fullDateTime = `${dateStr}, ${startTime}-${endTime}`;

    // Update modal subtitle with event details
    $("#cancel-nomakeup-modal .cancel-modal-subtitle").text(fullDateTime);

    // Show the modal
    $("#cancel-nomakeup-modal").fadeIn(300);
  }

  // Function to open manage session modal with event data
  function openManageSessionModal(eventData) {
    console.log("Opening Manage Session modal for:", eventData);

    // Check if event has cohort data
    if (
      !eventData.cohortids ||
      !Array.isArray(eventData.cohortids) ||
      eventData.cohortids.length === 0
    ) {
      // Show alert that cohort data is not available
      alert("Cohort data is not available for this event.");
      return;
    }

    // Populate the modal with event data
    populateManageSessionModal(eventData);

    // Show the modal
    $("#manage-session-modal").fadeIn(300);
  }

  // Function to populate manage session modal with event data
  function populateManageSessionModal(eventData) {
    if (!eventData) return;

    console.log("Populating manage session modal with:", eventData);

    // Store event data for form submission
    $("#manage-session-form").data("eventData", eventData);

    // === 1. Populate Cohort Dropdown from cohortList (same as manage cohort) ===
    const $cohortList = $("#session-cohort-list");
    const $cohortBtn = $("#session-cohort-btn");
    $cohortList.empty();

    // Get cohorts from the cohortList in manage cohort tab
    const cohortListItems = $("#cohortList li[data-cohort-id]");
    let selectedCohortId = null;

    if (cohortListItems.length > 0) {
      cohortListItems.each(function () {
        const cohortId = $(this).data("cohort-id");
        const cohortName = $(this).text().trim();
        const $li = $(`<li data-cohort-id="${cohortId}">${cohortName}</li>`);
        $cohortList.append($li);

        // Select cohort if matches event data
        if (
          eventData.cohortids &&
          eventData.cohortids.length > 0 &&
          cohortId == eventData.cohortids[0]
        ) {
          selectedCohortId = cohortId;
          $cohortBtn.text(cohortName);
          const shortName =
            cohortName.split("-")[0] || cohortName.split(" ")[0] || "";
          $("#session-cohort-short-name").val(shortName);
        }
      });
    } else {
      $cohortList.append(
        '<li style="pointer-events:none;opacity:.6;">No cohorts found</li>'
      );
    }

    if (!selectedCohortId) {
      $cohortBtn.text("Select Cohort");
      $("#session-cohort-short-name").val("");
    }

    // === 2. Populate Teacher Dropdown from teacher list (same as manage cohort) ===
    const $teacherList = $("#session-teacher-list");
    const $teacherBtn = $("#session-teacher-btn");
    $teacherList.empty();

    // Get teachers from teacher1DropdownList (same teacher list used in manage cohort)
    const teacherListItems = $("#teacher1DropdownList .teacher-option");
    let selectedTeacherId = null;
    let selectedTeacherImg = "";
    let selectedTeacherName = "";

    if (teacherListItems.length > 0) {
      teacherListItems.each(function () {
        const teacherId = $(this).data("userid");
        const teacherName = $(this).data("name");
        const teacherPic = $(this).data("pic") || "";

        // Create list item with teacher image
        const $li = $(`
          <li data-teacher-id="${teacherId}" data-teacher-pic="${teacherPic}" data-teacher-name="${teacherName}">
            <img src="${teacherPic}" class="teacher-dropdown-avatar" alt="${teacherName}" onerror="this.src='./img/default-avatar.svg'">
            <span>${teacherName}</span>
          </li>
        `);
        $teacherList.append($li);

        // Select teacher if matches event data
        if (eventData.teacherId && teacherId == eventData.teacherId) {
          selectedTeacherId = teacherId;
          selectedTeacherImg = teacherPic;
          selectedTeacherName = teacherName;
          // Update button with teacher image and name
          $teacherBtn.html(`
            <div class="teacher-info">
              <img class="avatar" src="${teacherPic}" alt="${teacherName}" onerror="this.src='./img/default-avatar.svg'">
              <span class="teacher-name">${teacherName}</span>
            </div>
          `);
        }
      });
    } else {
      $teacherList.append(
        '<li style="pointer-events:none;opacity:.6;">No teachers found</li>'
      );
    }

    if (!selectedTeacherId) {
      $teacherBtn.text("Select Teacher");
    }

    console.log("Selected teacher:", selectedTeacherId, selectedTeacherName);

    // === 3. Populate Class Dropdown (same as manage cohort) ===
    const $classList = $("#session-class-list");
    const $classBtn = $("#session-class-btn");
    $classList.empty();

    const classTypes = [
      { value: "main", label: "Main Class" },
      { value: "tutoring", label: "Tutoring Class" },
      { value: "conversation", label: "Conversational Class" },
    ];

    classTypes.forEach((ct) => {
      const $li = $(`<li data-class-value="${ct.value}">${ct.label}</li>`);
      $classList.append($li);

      // Select class if matches event data
      if (eventData.classType && ct.value === eventData.classType) {
        $classBtn.text(ct.label);
      }
    });

    if (!eventData.classType) {
      $classBtn.text("Select Class");
    }

    // === 4. Populate Student Dropdown ===
    const $studentList = $("#session-student-list");
    const $studentBtn = $("#session-student-btn");
    $studentList.empty();

    // Check if this is a 1:1 class with student data
    if (eventData.studentids && eventData.studentids.length > 0) {
      // Fetch all students from the student search widget if available
      const allStudentItems = $("#search-student .student-option");
      let selectedStudentId = eventData.studentids[0]; // Get first student ID
      let selectedStudentName =
        eventData.studentnames && eventData.studentnames.length > 0
          ? eventData.studentnames[0]
          : "";

      if (allStudentItems.length > 0) {
        allStudentItems.each(function () {
          const studentId = $(this).data("student-id");
          const studentName =
            $(this).data("student-name") ||
            $(this).find(".student-name").text().trim();
          const studentAvatar =
            $(this).data("student-avatar") ||
            $(this).find(".student-avatar").attr("src") ||
            "";

          // Create list item with student image
          const $li = $(`
            <li data-student-id="${studentId}" data-student-name="${studentName}" data-student-avatar="${studentAvatar}">
              <img src="${studentAvatar}" class="teacher-dropdown-avatar" alt="${studentName}" onerror="this.src='./img/default-avatar.svg'">
              <span>${studentName}</span>
            </li>
          `);
          $studentList.append($li);

          // Select student if matches event data
          if (studentId == selectedStudentId) {
            selectedStudentName = studentName;
            $studentBtn.html(`
              <div class="teacher-info">
                <img class="avatar" src="${studentAvatar}" alt="${studentName}" onerror="this.src='./img/default-avatar.svg'">
                <span class="teacher-name">${studentName}</span>
              </div>
            `);
          }
        });
      } else if (selectedStudentName) {
        // If student widget not loaded yet, just show the student from event data
        const studentAvatar = eventData.avatar || "./img/default-avatar.svg";
        const $li = $(`
          <li data-student-id="${selectedStudentId}" data-student-name="${selectedStudentName}" data-student-avatar="${studentAvatar}">
            <img src="${studentAvatar}" class="teacher-dropdown-avatar" alt="${selectedStudentName}" onerror="this.src='./img/default-avatar.svg'">
            <span>${selectedStudentName}</span>
          </li>
        `);
        $studentList.append($li);

        $studentBtn.html(`
          <div class="teacher-info">
            <img class="avatar" src="${studentAvatar}" alt="${selectedStudentName}" onerror="this.src='./img/default-avatar.svg'">
            <span class="teacher-name">${selectedStudentName}</span>
          </div>
        `);
      }

      console.log("Selected student:", selectedStudentId, selectedStudentName);
    } else {
      $studentList.append(
        '<li style="pointer-events:none;opacity:.6;">No students available</li>'
      );
      $studentBtn.text("Select Student");
    }

    // === 5. Set Lesson Type based on classType and googlemeetid ===
    const $lessonTypeBtn = $("#session-lesson-type-btn");

    // Determine if it's single or weekly based on classType
    let lessonType = "";
    if (eventData.classType === "one2one_single") {
      lessonType = "single";
      $lessonTypeBtn.text("Single Lesson");
    } else if (eventData.classType === "one2one_weekly") {
      lessonType = "weekly";
      $lessonTypeBtn.text("Weekly Lesson");
    } else if (eventData.googlemeetid) {
      // If googlemeetid exists, it's a recurring (weekly) lesson
      lessonType = "weekly";
      $lessonTypeBtn.text("Weekly Lesson");
    } else {
      // Default to single lesson if no googlemeetid
      lessonType = "single";
      $lessonTypeBtn.text("Single Lesson");
    }

    console.log(
      "Selected lesson type:",
      lessonType,
      "(googlemeetid:",
      eventData.googlemeetid,
      ", classType:",
      eventData.classType,
      ")"
    );

    // === 6. Set Event Date (format like manage cohort: "Feb 4, 2025") ===
    const $dateBtn = $("#session-event-date-btn");
    if (eventData.date) {
      // Parse date string (YYYY-MM-DD) and format as "MMM D, YYYY"
      const dateParts = eventData.date.split("-");
      if (dateParts.length === 3) {
        const year = dateParts[0];
        const month = parseInt(dateParts[1], 10);
        const day = parseInt(dateParts[2], 10);
        const monthNames = [
          "Jan",
          "Feb",
          "Mar",
          "Apr",
          "May",
          "Jun",
          "Jul",
          "Aug",
          "Sep",
          "Oct",
          "Nov",
          "Dec",
        ];
        const formattedDate = `${monthNames[month - 1]} ${day}, ${year}`;
        $dateBtn.text(formattedDate);
        $dateBtn.data("raw-date", eventData.date); // Store raw date for form submission
      } else {
        $dateBtn.text("Select Date");
        $dateBtn.data("raw-date", "");
      }
    } else {
      $dateBtn.text("Select Date");
      $dateBtn.data("raw-date", "");
    }

    // === 7. Populate Start Time Dropdown ===
    const $startList = $("#session-start-list");
    const $startBtn = $("#session-start-btn");
    $startList.empty();

    for (let h = 0; h < 24; h++) {
      for (let m = 0; m < 60; m += 5) {
        const min = h * 60 + m;
        const label = fmt12(min);
        const $li = $(`<li data-time-value="${min}">${label}</li>`);
        $startList.append($li);
      }
    }

    // Set selected start time
    let startMin = null;
    if (typeof eventData.start === "number" && !isNaN(eventData.start)) {
      startMin = eventData.start;
    } else if (typeof eventData.start === "string" && eventData.start) {
      startMin = minutes(eventData.start);
    }
    if (startMin !== null) {
      $startBtn.text(fmt12(startMin));
    } else {
      $startBtn.text("Select Start Time");
    }

    // === 8. Populate End Time Dropdown ===
    const $endList = $("#session-end-list");
    const $endBtn = $("#session-end-btn");
    $endList.empty();

    for (let h = 0; h < 24; h++) {
      for (let m = 0; m < 60; m += 5) {
        const min = h * 60 + m;
        const label = fmt12(min);
        const $li = $(`<li data-time-value="${min}">${label}</li>`);
        $endList.append($li);
      }
    }

    // Set selected end time
    let endMin = null;
    if (typeof eventData.end === "number" && !isNaN(eventData.end)) {
      endMin = eventData.end;
    } else if (typeof eventData.end === "string" && eventData.end) {
      endMin = minutes(eventData.end);
    }
    if (endMin !== null) {
      $endBtn.text(fmt12(endMin));
    } else {
      $endBtn.text("Select End Time");
    }
  }

  // Make openManageSessionModal globally accessible
  window.openManageSessionModal = openManageSessionModal;

  // === Custom Dropdown Event Handlers for Manage Session Modal ===

  // Toggle dropdown on button click
  $(document).on("click", ".custom-dropdown .dropdown-btn", function (e) {
    e.stopPropagation();
    const $dropdown = $(this).closest(".custom-dropdown");
    const $list = $dropdown.find(".dropdown-list");
    const isOpen = $list.is(":visible");

    // Close all other dropdowns
    $(".custom-dropdown .dropdown-list").hide();

    // Toggle this dropdown
    if (isOpen) {
      $list.hide();
    } else {
      $list.show();
    }
  });

  // Cohort dropdown item click
  $(document).on("click", "#session-cohort-list li", function (e) {
    e.stopPropagation();

    // Skip if this is a disabled "no cohorts" message
    if ($(this).css("pointer-events") === "none") return;

    const cohortId = $(this).data("cohort-id");
    const cohortName = $(this).text().trim();
    $("#session-cohort-btn").text(cohortName);
    $("#session-cohort-list").hide();

    // Update cohort short name (extract first part before dash or space)
    const shortName =
      cohortName.split("-")[0] || cohortName.split(" ")[0] || "";
    $("#session-cohort-short-name").val(shortName);
  });

  // Teacher dropdown item click
  $(document).on("click", "#session-teacher-list li", function (e) {
    e.stopPropagation();

    // Skip if this is a disabled "no teachers" message
    if ($(this).css("pointer-events") === "none") return;

    const teacherId = $(this).data("teacher-id");
    const teacherPic =
      $(this).data("teacher-pic") || "./img/default-avatar.svg";
    const teacherName =
      $(this).find("span").text().trim() || $(this).text().trim();

    // Update button with teacher image and name
    $("#session-teacher-btn").html(`
      <div class="teacher-info">
        <img class="avatar" src="${teacherPic}" alt="${teacherName}" onerror="this.src='./img/default-avatar.svg'">
        <span class="teacher-name">${teacherName}</span>
      </div>
    `);
    $("#session-teacher-list").hide();
  });

  // Class dropdown item click
  $(document).on("click", "#session-class-list li", function (e) {
    e.stopPropagation();
    const classValue = $(this).data("class-value");
    const classLabel = $(this).text();
    $("#session-class-btn").text(classLabel);
    $("#session-class-list").hide();
  });

  // Student dropdown item click
  $(document).on("click", "#session-student-list li", function (e) {
    e.stopPropagation();

    // Skip if this is a disabled "no students" message
    if ($(this).css("pointer-events") === "none") return;

    const studentId = $(this).data("student-id");
    const studentName =
      $(this).data("student-name") || $(this).find("span").text().trim();
    const studentAvatar =
      $(this).data("student-avatar") || "./img/default-avatar.svg";

    // Update button with student image and name
    $("#session-student-btn").html(`
      <div class="teacher-info">
        <img class="avatar" src="${studentAvatar}" alt="${studentName}" onerror="this.src='./img/default-avatar.svg'">
        <span class="teacher-name">${studentName}</span>
      </div>
    `);
    $("#session-student-list").hide();
  });

  // Lesson Type dropdown item click
  $(document).on("click", "#session-lesson-type-list li", function (e) {
    e.stopPropagation();
    const lessonType = $(this).data("lesson-type");
    const lessonLabel = $(this).text();
    $("#session-lesson-type-btn").text(lessonLabel);
    $("#session-lesson-type-list").hide();
  });

  // Start time dropdown item click
  $(document).on("click", "#session-start-list li", function (e) {
    e.stopPropagation();
    const timeValue = $(this).data("time-value");
    const timeLabel = $(this).text();
    $("#session-start-btn").text(timeLabel);
    $("#session-start-list").hide();
  });

  // End time dropdown item click
  $(document).on("click", "#session-end-list li", function (e) {
    e.stopPropagation();
    const timeValue = $(this).data("time-value");
    const timeLabel = $(this).text();
    $("#session-end-btn").text(timeLabel);
    $("#session-end-list").hide();
  });

  // Date button click - open calendar modal
  $(document).on("click", "#session-event-date-btn", function (e) {
    e.stopPropagation();

    // Set calendar target for manage session
    window.calendarTarget = "manageSession";

    // Get current date or use today
    const rawDate = $(this).data("raw-date");
    let selectedDate = new Date();

    if (rawDate) {
      const parts = rawDate.split("-");
      if (parts.length === 3) {
        selectedDate = new Date(
          parseInt(parts[0]),
          parseInt(parts[1]) - 1,
          parseInt(parts[2])
        );
      }
    }

    // Set calendar view to selected date
    if (typeof window.calSelectedDate !== "undefined") {
      window.calSelectedDate = selectedDate;
      window.calViewMonth = selectedDate.getMonth();
      window.calViewYear = selectedDate.getFullYear();
    }

    // Render and show calendar modal
    if (typeof window.renderMonthlyCal === "function") {
      window.renderMonthlyCal();
    }
    $("#monthly_cal_modal_backdrop").fadeIn(90);
  });

  // Close all dropdowns when clicking outside
  $(document).on("click", function (e) {
    if (!$(e.target).closest(".custom-dropdown").length) {
      $(".custom-dropdown .dropdown-list").hide();
    }
  });

  // Close manage session modal
  $(document).on("click", "#close-manage-session", function () {
    $("#manage-session-modal").fadeOut(300);
    // Close all dropdowns when modal closes
    $(".custom-dropdown .dropdown-list").hide();
  });

  // Close Cancel & Reschedule modal
  $(document).on("click", "#close-cancel-reschedule", function () {
    $("#cancel-reschedule-modal").fadeOut(300);
  });

  // Close Cancel (No Make-Up) modal
  $(document).on("click", "#close-cancel-nomakeup", function () {
    $("#cancel-nomakeup-modal").fadeOut(300);
  });

  // Close modal when clicking outside
  $(document).on("click", "#manage-session-modal", function (e) {
    if ($(e.target).hasClass("modal-overlay")) {
      $("#manage-session-modal").fadeOut(300);
      // Close all dropdowns when modal closes
      $(".custom-dropdown .dropdown-list").hide();
    }
  });

  // Close Cancel & Reschedule modal when clicking outside
  $(document).on("click", "#cancel-reschedule-modal", function (e) {
    if ($(e.target).hasClass("modal-overlay")) {
      $("#cancel-reschedule-modal").fadeOut(300);
    }
  });

  // Close Cancel (No Make-Up) modal when clicking outside
  $(document).on("click", "#cancel-nomakeup-modal", function (e) {
    if ($(e.target).hasClass("modal-overlay")) {
      $("#cancel-nomakeup-modal").fadeOut(300);
    }
  });

  // ===== Time Off Modal (Teacher Busy Time) =====
  // Ensure modal markup exists; if not, append it with existing styles
  (function ensureTimeOffModal() {
    if (!document.getElementById("timeoff-modal")) {
      const modalHtml = `
        <div id="timeoff-modal" class="modal-overlay" style="display:none;">
          <div class="modal-card">
            <div class="modal-header">
              <div class="modal-title">Time off</div>
              <button id="close-timeoff" class="modal-close">×</button>
            </div>
            <div class="modal-body">
              <div class="timeoff-row">
                <span class="status-dot busy"></span>
                <span class="status-label">Busy Time</span>
              </div>
              <div class="timeoff-details">
                <div class="date-block">
                  <span class="date-icon">🕘</span>
                  <div class="date-lines">
                    <div class="date-line" id="timeoff-date-line">September 26</div>
                    <div class="date-subline" id="timeoff-day-line">Thursday</div>
                  </div>
                </div>
                <div class="time-block">
                  <span id="timeoff-time-range">06:00 → 07:00</span>
                  <div class="time-subline" id="timeoff-duration">1 hour</div>
                </div>
              </div>
            </div>
            <div class="modal-footer">
              <button id="timeoff-cancel-btn" class="danger-btn">Cancel time off</button>
            </div>
          </div>
        </div>`;
      document.body.insertAdjacentHTML("beforeend", modalHtml);
    }
  })();

  function openTimeOffModal(eventData) {
    // Persist event data for downstream handlers (e.g., cancel click)
    try {
      $("#timeoff-modal").data("eventData", eventData || {});
    } catch (e) {}
    // Format date
    let dateStr = "";
    let dayStr = "";
    if (eventData.date) {
      const [y, m, d] = eventData.date.split("-").map((x) => parseInt(x, 10));
      const dateObj = new Date(y, m - 1, d);
      const monthNames = [
        "January",
        "February",
        "March",
        "April",
        "May",
        "June",
        "July",
        "August",
        "September",
        "October",
        "November",
        "December",
      ];
      const dayNames = [
        "Sunday",
        "Monday",
        "Tuesday",
        "Wednesday",
        "Thursday",
        "Friday",
        "Saturday",
      ];
      dateStr = `${monthNames[dateObj.getMonth()]} ${d}`;
      dayStr = dayNames[dateObj.getDay()];
    }

    // Format time range and duration
    let startMin = null,
      endMin = null;
    if (typeof eventData.start === "number") startMin = eventData.start;
    else if (eventData.start) startMin = minutes(eventData.start);
    if (typeof eventData.end === "number") endMin = eventData.end;
    else if (eventData.end) endMin = minutes(eventData.end);
    const timeRange =
      startMin != null && endMin != null
        ? `${fmt12(startMin)} → ${fmt12(endMin)}`
        : "";
    const durationMin =
      startMin != null && endMin != null ? Math.max(0, endMin - startMin) : 0;
    const durationStr =
      durationMin >= 60
        ? `${Math.floor(durationMin / 60)} hour${
            Math.floor(durationMin / 60) > 1 ? "s" : ""
          }`
        : `${durationMin} min`;

    // Populate
    $("#timeoff-date-line").text(dateStr);
    $("#timeoff-day-line").text(dayStr);
    $("#timeoff-time-range").text(timeRange);
    $("#timeoff-duration").text(durationStr);

    // Show
    $("#timeoff-modal").fadeIn(200);
  }

  // Close Time Off modal
  $(document).on("click", "#close-timeoff", function () {
    $("#timeoff-modal").fadeOut(200);
  });

  // Close when clicking outside
  $(document).on("click", "#timeoff-modal", function (e) {
    if ($(e.target).hasClass("modal-overlay")) {
      $("#timeoff-modal").fadeOut(200);
    }
  });

  // Cancel Time Off action (placeholder; wire to backend if available)
  $(document).on("click", "#timeoff-cancel-btn", function () {
    const ev = window.getCurrentClickedEvent && window.getCurrentClickedEvent();
    if (!ev) {
      $("#timeoff-modal").fadeOut(200);
      return;
    }
    // TODO: call backend to cancel teacher time off; on success, refetch and close
    $("#timeoff-modal").fadeOut(200);
    if (typeof window.refetchCustomPluginData === "function") {
      window.refetchCustomPluginData();
    }
  });

  // Expose globally
  window.openTimeOffModal = openTimeOffModal;

  // Handle manage session form submission
  $(document).on("submit", "#manage-session-form", function (e) {
    e.preventDefault();

    const eventData = $(this).data("eventData");

    // ============================
    // GET SELECTED COHORT
    // ============================
    const selectedCohortId = $("#session-cohort-list li")
      .filter(function () {
        return $(this).text().trim() === $("#session-cohort-btn").text().trim();
      })
      .data("cohort-id");

    // ============================
    // GET SELECTED TEACHER
    // ============================
    const selectedTeacherLi = $("#session-teacher-list li").filter(function () {
      return $(this).text().trim() === $("#session-teacher-btn").text().trim();
    });

    const selectedTeacherId = selectedTeacherLi.data("teacher-id");

    // ============================
    // GET OTHER FIELDS
    // ============================
    const selectedClassValue = $("#session-class-list li")
      .filter(function () {
        return $(this).text().trim() === $("#session-class-btn").text().trim();
      })
      .data("class-value");

    const selectedStartTime = $("#session-start-list li")
      .filter(function () {
        return $(this).text().trim() === $("#session-start-btn").text().trim();
      })
      .data("time-value");

    const selectedEndTime = $("#session-end-list li")
      .filter(function () {
        return $(this).text().trim() === $("#session-end-btn").text().trim();
      })
      .data("time-value");

    const selectedDate = $("#session-event-date-btn").data("raw-date") || "";

    // ============================================================
    // OLD SESSION DATA - FIXED PROPERTY NAMES
    // ============================================================
    const eventId = eventData.eventid;
    const googleMeetId = eventData.googlemeetid;
    const oldTeacherId = eventData.teacherId;
    const oldDate = eventData.date;
    const oldStart = eventData.start;
    const oldEnd = eventData.end;

    // ============================
    // FORMAT TIME FUNCTION
    // ============================
    function formatTime(minutes) {
      if (typeof minutes === "string" && minutes.includes(":")) {
        // Already formatted, return as is
        return minutes;
      }

      const mins = parseInt(minutes);
      if (isNaN(mins)) return "0:00";

      const hours = Math.floor(mins / 60);
      const remainingMinutes = mins % 60;

      // Format as "h:mm" - e.g., "1:30", "2:00", "0:45"
      return `${hours}:${remainingMinutes.toString().padStart(2, "0")}`;
    }

    // ============================================================
    // BUILD PAYLOAD WITH FORMATTED TIMES
    // ============================================================
    const payload = {
      status: "reschedule",
      eventid: eventId,
      googlemeetid: googleMeetId,
      oldTeacherId: oldTeacherId,
      newTeacherId: selectedTeacherId,
      oldDate: oldDate,
      newDate: selectedDate,
      oldStart: formatTime(oldStart),
      oldEnd: formatTime(oldEnd),
      newStart: formatTime(selectedStartTime),
      newEnd: formatTime(selectedEndTime),
    };

    console.log("Final Reschedule Payload:", payload);

    // TODO: Add AJAX call here
    /*
    $.ajax({
        url: 'your-api-endpoint',
        method: 'POST',
        data: JSON.stringify(payload),
        contentType: 'application/json',
        success: function(response) {
            console.log('Session rescheduled successfully:', response);
            $('#manage-session-modal').fadeOut(300);
            $(".custom-dropdown .dropdown-list").hide();
            // Optionally refresh the calendar or show success message
        },
        error: function(xhr, status, error) {
            console.error('Error rescheduling session:', error);
            // Show error message to user
        }
    });
    */

    // Show loader
    if (window.showGlobalLoader) window.showGlobalLoader();

    $.ajax({
      url: M.cfg.wwwroot + "/local/customplugin/ajax/reschedule_groupclass.php",
      type: "POST",
      data: JSON.stringify(payload),
      contentType: "application/json",
      success: function (response) {
        console.log("Reschedule Response:", response);
        if (window.hideGlobalLoader) window.hideGlobalLoader();
        if (window.showToast) {
          window.showToast("Session updated successfully!", "success");
        } else {
          // fallback toast
          let toast = document.createElement("div");
          toast.className = "custom-toast success";
          toast.innerText = "Session updated successfully!";
          toast.style.position = "fixed";
          toast.style.bottom = "32px";
          toast.style.left = "50%";
          toast.style.transform = "translateX(-50%)";
          toast.style.background = "#1649c7";
          toast.style.color = "#fff";
          toast.style.padding = "12px 32px";
          toast.style.borderRadius = "8px";
          toast.style.fontSize = "1rem";
          toast.style.zIndex = 9999;
          toast.style.boxShadow = "0 2px 8px rgba(0,0,0,0.15)";
          document.body.appendChild(toast);
          setTimeout(() => {
            toast.style.opacity = "0";
            setTimeout(() => toast.remove(), 400);
          }, 2200);
        }
        if (window.refetchCustomPluginData) {
          window.refetchCustomPluginData("reschedule");
        } else if (window.fetchCalendarEvents) {
          window.fetchCalendarEvents();
        }
        $("#manage-session-modal").fadeOut(300);
        $(".custom-dropdown .dropdown-list").hide();
      },
      error: function (xhr) {
        if (window.hideGlobalLoader) window.hideGlobalLoader();
        if (window.showToast) {
          window.showToast(
            "Something went wrong while updating session.",
            "error"
          );
        } else {
          let toast = document.createElement("div");
          toast.className = "custom-toast error";
          toast.innerText = "Something went wrong while updating session.";
          toast.style.position = "fixed";
          toast.style.bottom = "32px";
          toast.style.left = "50%";
          toast.style.transform = "translateX(-50%)";
          toast.style.background = "#fe2e0c";
          toast.style.color = "#fff";
          toast.style.padding = "12px 32px";
          toast.style.borderRadius = "8px";
          toast.style.fontSize = "1rem";
          toast.style.zIndex = 9999;
          toast.style.boxShadow = "0 2px 8px rgba(0,0,0,0.15)";
          document.body.appendChild(toast);
          setTimeout(() => {
            toast.style.opacity = "0";
            setTimeout(() => toast.remove(), 400);
          }, 2200);
        }
      },
      complete: function () {
        if (window.hideGlobalLoader) window.hideGlobalLoader();
      },
    });
  });

  /* ====== CLICK: empty slot -> open cohort modal ====== */
  $("#grid")
    .off("mousedown.emptySlot", ".day-inner")
    .on("mousedown.emptySlot", ".day-inner", function (e) {
      if ($(e.target).closest(".event").length) return;
      openCreateCohortModal();
    });

  // First render
  renderWeek(true);

  // Navigation
  $("#prev-week").on("click", () => {
    currentWeekStart.setDate(currentWeekStart.getDate() - 7);
    renderWeek(true);
  });
  $("#next-week").on("click", () => {
    currentWeekStart.setDate(currentWeekStart.getDate() + 7);
    renderWeek(true);
  });

  // Today button: jump to current week (Monday)
  $("#btnToday").on("click", () => {
    currentWeekStart = mondayOf(new Date());
    renderWeek(true);
  });

  // Now line heartbeat
  setInterval(drawNow, 60 * 1000);

  // Update Today button enabled/disabled state
  function updateTodayButton() {
    const todayMonday = mondayOf(new Date());
    const isTodayWeek = todayMonday.getTime() === currentWeekStart.getTime();
    $("#btnToday").prop("disabled", isTodayWeek);
  }

  /* ====== RENDER ====== */
  function renderWeek(resetScroll = false) {
    // Header
    const $head = $("#head");
    $head.find(".day-h").remove();
    for (let i = 0; i < 7; i++) {
      const d = new Date(currentWeekStart);
      d.setDate(d.getDate() + i);
      $('<div class="day-h">')
        .append(`<span class="dow">${DOW[i]}</span>`)
        .append(`<span class="dt">${d.getDate()}</span>`)
        .appendTo($head);
    }
    $("#calendar-range").text(rangeText(currentWeekStart));
    // Keep Today button state in sync
    updateTodayButton();

    // FULL GRID rebuild
    const $grid = $("#grid");
    $grid.empty().append('<div id="gutter" class="gutter"></div>');
    const $gut = $("#gutter");
    for (let m = START_H * 60; m <= END_H * 60; m += SLOT_MIN) {
      const $row = $('<div class="time-row">');
      if (m % 60 === 0)
        $row.append(`<div class="time-label">${fmt12(m)}</div>`);
      $gut.append($row);
    }

    const dayEls = [],
      weekDates = [];
    for (let i = 0; i < 7; i++) {
      const d = new Date(currentWeekStart);
      d.setDate(d.getDate() + i);
      weekDates.push(ymd(d));

      const $col = $('<div class="day" style="z-index:0 !important">');
      const $inner = $('<div class="day-inner">').appendTo($col);
      $inner.attr("data-date", ymd(d));

      // CREATE SLOTS with white background when matched
      const $slots = $('<div class="slots">').appendTo($inner);
      for (let r = 0; r < rows; r++) {
        const minuteOfDay = START_H * 60 + r * SLOT_MIN;
        const makeWhite = isWhiteSlotFor(i, ymd(d), minuteOfDay);
        $("<div>").toggleClass("slot-white", makeWhite).appendTo($slots);
      }

      $grid.append($col);
      dayEls.push($inner);
    }

    // Prepare per-day buckets
    const perDay = Array.from({ length: 7 }, () => []);
    console.log("Events to render:", events);
    events.forEach((raw) => {
      // Check if event has reschedule_instant status with previous/current data
      const statusMeta = getActiveStatusMeta(raw.statuses);
      let hasRescheduleInstant = false;
      let previousEvent = null;
      let currentEvent = null;

      if (
        statusMeta &&
        statusMeta.code === "reschedule_instant" &&
        statusMeta.statusObj &&
        statusMeta.statusObj.details
      ) {
        const details = statusMeta.statusObj.details;
        if (
          details.previous &&
          details.previous.action === "reschedule_instant" &&
          details.current &&
          details.current.action === "reschedule_instant"
        ) {
          hasRescheduleInstant = true;
          previousEvent = details.previous;
          currentEvent = details.current;
        }
      }

      // If reschedule_instant with both previous and current, create two events
      if (hasRescheduleInstant && previousEvent && currentEvent) {
        // Create faded previous event
        const prevIdx = weekDates.indexOf(previousEvent.date);
        if (prevIdx !== -1) {
          const ePrev = { ...raw };
          ePrev.date = previousEvent.date;
          ePrev.start =
            typeof previousEvent.start === "string"
              ? minutes(previousEvent.start)
              : previousEvent.start;
          ePrev.end =
            typeof previousEvent.end === "string"
              ? minutes(previousEvent.end)
              : previousEvent.end;
          ePrev.teacherId = previousEvent.teacher || raw.teacherId;
          ePrev.isFadedReschedule = true; // Mark as faded
          ePrev.isReschedulePrevious = true;

          // Handle midnight-crossing for previous event
          if (ePrev.end < ePrev.start) {
            const pairedId = `paired-prev-${Date.now()}-${Math.random()}`;
            const ePrev1 = { ...ePrev };
            ePrev1.end = 24 * 60;
            ePrev1.isMidnightCrossing = true;
            ePrev1.pairedId = pairedId;
            ePrev1.part = "start";
            perDay[prevIdx].push(ePrev1);

            const ePrev2 = { ...ePrev };
            ePrev2.start = 0;
            ePrev2.isMidnightCrossing = true;
            ePrev2.pairedId = pairedId;
            ePrev2.part = "end";
            if (prevIdx < 6) perDay[prevIdx + 1].push(ePrev2);
          } else {
            perDay[prevIdx].push(ePrev);
          }
        }

        // Create current event
        const currIdx = weekDates.indexOf(currentEvent.date);
        if (currIdx !== -1) {
          const eCurr = { ...raw };
          eCurr.date = currentEvent.date;
          eCurr.start =
            typeof currentEvent.start === "string"
              ? minutes(currentEvent.start)
              : currentEvent.start;
          eCurr.end =
            typeof currentEvent.end === "string"
              ? minutes(currentEvent.end)
              : currentEvent.end;
          eCurr.teacherId = currentEvent.teacher || raw.teacherId;
          eCurr.isRescheduleCurrent = true;

          // Handle midnight-crossing for current event
          if (eCurr.end < eCurr.start) {
            const pairedId = `paired-curr-${Date.now()}-${Math.random()}`;
            const eCurr1 = { ...eCurr };
            eCurr1.end = 24 * 60;
            eCurr1.isMidnightCrossing = true;
            eCurr1.pairedId = pairedId;
            eCurr1.part = "start";
            perDay[currIdx].push(eCurr1);

            const eCurr2 = { ...eCurr };
            eCurr2.start = 0;
            eCurr2.isMidnightCrossing = true;
            eCurr2.pairedId = pairedId;
            eCurr2.part = "end";
            if (currIdx < 6) perDay[currIdx + 1].push(eCurr2);
          } else {
            perDay[currIdx].push(eCurr);
          }
        }

        // Skip normal processing for this event
        return;
      }

      // Normal event processing
      let di = null;
      if (raw.date) {
        const idx = weekDates.indexOf(raw.date);
        if (idx === -1) return;
        di = idx;
      } else if (typeof raw.day === "number") {
        di = raw.day;
      } else {
        return;
      }
      const e = { ...raw };
      e.start = typeof e.start === "string" ? minutes(e.start) : e.start;
      e.end = typeof e.end === "string" ? minutes(e.end) : e.end;

      // Handle midnight-crossing events (e.g., 9 PM to 9 AM)
      // Create two event instances: one for each day
      if (e.end < e.start) {
        // Assign unique ID for pairing
        const pairedId = `paired-${Date.now()}-${Math.random()}`;

        // First part: from start time to end of day (24:00)
        const e1 = { ...e };
        e1.end = 24 * 60; // Ends at midnight
        e1.isMidnightCrossing = true;
        e1.pairedId = pairedId;
        e1.part = "start"; // Indicates this is the start part (PM)
        perDay[di].push(e1);

        // Second part: from start of day (00:00) to original end time
        const e2 = { ...e };
        e2.start = 0; // Starts at midnight
        e2.isMidnightCrossing = true;
        e2.pairedId = pairedId;
        e2.part = "end"; // Indicates this is the end part (AM)

        // Add to next day if within week
        if (di < 6) {
          perDay[di + 1].push(e2);
        }
      } else {
        perDay[di].push(e);
      }
    });

    // Overlap logic (unchanged)
    const MAX_LEFT = 0 + (STACK_CAP - 1) * STACK_OFFSET;

    perDay.forEach((list, di) => {
      list.sort((a, b) => a.start - b.start || a.end - b.end);

      const active = [];
      list.forEach((ev) => {
        for (let i = active.length - 1; i >= 0; i--) {
          if (active[i].end <= ev.start) active.splice(i, 1);
        }
        active.push(ev);

        const conc = active.length;
        active.forEach((a) => {
          a._max = Math.max(a._max || 0, conc);
        });

        ev.stackIndex = Math.min(conc - 1, STACK_CAP - 1);
      });

      list.forEach((ev) => {
        const top = (ev.start - START_H * 60) * PX_PER_MIN;
        const h = (ev.end - ev.start) * PX_PER_MIN - 0;

        const isSingleton = (ev._max || 1) === 1;
        const cssPos = isSingleton
          ? { left: "0px", width: "calc(100% - 0px)" }
          : (() => {
              const leftPx = ev.stackIndex * STACK_OFFSET;
              const rightPad = STACK_OFFSET; // small inset on the right for overlap
              return {
                left: `${leftPx}px`,
                width: `calc(100% - ${leftPx + rightPad}px)`,
              };
            })();

        // Get teacher color class and inline style for unlimited colors
        let teacherColorClass = "";
        let teacherColorStyle = "";

        if (ev.teacherId) {
          const colorIndex = getTeacherColorIndex(ev.teacherId);
          teacherColorClass = `teacher-${colorIndex} has-teacher-indicator`;

          // Generate dynamic color for the ::after pseudo-element (teacher dot indicator)
          const teacherColor = getTeacherColor(ev.teacherId);
          // Debug: log teacher ID and color for troubleshooting

          // Only set --teacher-dot-color for the dot indicator
          // Border and background colors are controlled by class-type CSS classes
          teacherColorStyle = `--teacher-dot-color: ${teacherColor};`;
        }

        // Determine class type CSS class and border color
        let classTypeClass = "class-type-main";
        let borderColorStyle = "";

        if (ev.classType === "tutoring") {
          classTypeClass = "class-type-tutoring";
        } else if (ev.classType === "one2one_weekly") {
          classTypeClass = "class-type-one2one_weekly";
          borderColorStyle = "border-left-color: #4CAF50 !important;"; // Green border for one2one weekly
        } else if (ev.classType === "one2one_single") {
          classTypeClass = "class-type-one2one_single";
          borderColorStyle = "border-left-color: #4CAF50 !important;"; // Green border for one2one single
        } else if (
          ev.classType === "teacher_timeoff" ||
          ev.class_type === "teacher_timeoff" ||
          ev.source === "teacher_timeoff"
        ) {
          classTypeClass = "class-type-timeoff";
          borderColorStyle = "border-color: rgba(253,216,48,0.7) !important;";
        }

        // Combine styles (include any custom inline style from the event object)
        const combinedStyle = `${teacherColorStyle}${borderColorStyle}${
          ev.style || ""
        }`.trim();

        // Check if event is short (less than 1 hour)
        const eventDuration = ev.end - ev.start;
        const isShortEvent = eventDuration < 60;

        const isTimeOffEvent =
          ev.classType === "teacher_timeoff" ||
          ev.class_type === "teacher_timeoff" ||
          ev.source === "teacher_timeoff";
        debugger;
        const statusMeta = getActiveStatusMeta(ev.statuses);
        const statusIconHtml = (() => {
          // Hide status icon for current reschedule events (makeup icon shows instead)
          if (ev.isRescheduleCurrent) return "";
          if (!statusMeta) return "";
          if (statusMeta.code === "cancel_reschedule_later") {
            return `<span class="ev-status-icon" style="position:absolute; top:6px; right:6px; display:inline-flex; gap:4px; align-items:center; justify-content:flex-end; pointer-events:none; z-index:2;">
                <span style="display:inline-flex; align-items:center; justify-content:center; ">
                  <img src="./img/pendingconfirmation.svg" alt="Pending Confirmation" title="Pending Confirmation" style="width:16px; height:16px;">
                </span>
                <span style="display:inline-flex; align-items:center; justify-content:center; ">
                  <img src="./img/cancelled.svg" alt="Cancelled" title="Cancelled" style="width:16px; height:16px;">
                </span>
              </span>`;
          }
          return `<span class="ev-status-icon" title="${statusMeta.label}" aria-label="${statusMeta.label}" style="position:absolute; top:6px; right:6px; display:inline-flex; align-items:center; justify-content:center; pointer-events:none; z-index:2;">
                <img src="${statusMeta.icon}" alt="${statusMeta.label}" style="width:16px; height:16px;">
              </span>`;
        })();

        // Add faded styling for previous reschedule events
        const fadedClass = ev.isFadedReschedule ? " faded-reschedule" : "";
        const fadedStyle = ev.isFadedReschedule
          ? "opacity: 0.4; filter: grayscale(0.5);"
          : "";

        // Build event HTML - hide details for short events
        const $ev = $(`
          <div class="event ${
            ev.color || "e-blue"
          } ${teacherColorClass} ${classTypeClass}${
          ev.isMidnightCrossing ? " midnight-crossing" : ""
        }${
          isShortEvent ? " short-event" : ""
        }${fadedClass}" style="${combinedStyle}${fadedStyle}" data-start="${
          ev.start
        }" data-end="${ev.end}" data-date="${ev.date || ""}" data-title="${(
          ev.title || ""
        ).replace(/"/g, "&quot;")}" ${
          ev.teacherId ? `data-teacher-id="${ev.teacherId}"` : ""
        }${ev.pairedId ? ` data-paired-id="${ev.pairedId}"` : ""}${
          ev.part ? ` data-part="${ev.part}"` : ""
        }${
          ev.studentids && ev.studentids.length > 0
            ? ` data-student-ids="${ev.studentids.join(",")}"`
            : ""
        }${
          ev.studentnames && ev.studentnames.length > 0
            ? ` data-student-names="${ev.studentnames.join(",")}"`
            : ""
        }${ev.avatar ? ` data-avatar="${ev.avatar}"` : ""}${
          ev.cohortids && ev.cohortids.length > 0
            ? ` data-cohort-ids="${ev.cohortids.join(",")}"`
            : ""
        }${ev.eventid ? ` data-event-id="${ev.eventid}"` : ""}${
          ev.cmid ? ` data-cm-id="${ev.cmid}"` : ""
        }${ev.classType ? ` data-class-type="${ev.classType}"` : ""}${
          ev.repeat !== undefined ? ` data-repeat="${ev.repeat}"` : ""
        }${statusMeta ? ` data-status-code="${statusMeta.code}"` : ""}>
            ${statusIconHtml}
            ${
              !isShortEvent
                ? `<div class="ev-top">
              <div class="ev-left">${
                ev.avatar
                  ? `<img class="ev-avatar" src="${ev.avatar}" alt="">`
                  : ""
              }</div>
              ${
                isTimeOffEvent
                  ? ""
                  : ev.isRescheduleCurrent
                  ? `<span class="ev-makeup" title="Make-up Class"><img src="./img/makeup.svg" alt=""></span>`
                  : ev.repeat
                  ? `<span class="ev-repeat" title="Repeats"><img src="./img/ev-repeat.svg" alt=""></span>`
                  : `<span class="ev-single" title="Single Session"><img src="./img/single-lesson.svg" alt=""></span>`
              }
              ${
                ev.isMidnightCrossing
                  ? `<span class="ev-midnight-icon" title="Continues to next day">↪</span>`
                  : ""
              }
            </div>`
                : ""
            }
            <div class="ev-when">${fmt12(ev.start)} – ${fmt12(ev.end)}</div>
            ${
              !isShortEvent
                ? `<div class="ev-title">${
                    (ev.classType === "one2one_weekly" ||
                      ev.classType === "one2one_single") &&
                    ev.studentnames &&
                    ev.studentnames.length > 0
                      ? ev.studentnames.join(", ")
                      : ev.title || ""
                  }</div>`
                : ""
            }
          </div>
        `).css({ top: top + "px", height: h + "px", ...cssPos });

        // Base z-index by stackIndex so layers stay ordered; click will still raise
        const baseZ = 1000 + (ev.stackIndex || 0);
        $ev.css("z-index", baseZ);

        // Add hover tooltip for short events (less than 1 hour)
        if (isShortEvent) {
          // Create tooltip element
          const $tooltip = $(`
            <div class="event-tooltip">
              <div class="tooltip-header">
                <strong>${
                  (ev.classType === "one2one_weekly" ||
                    ev.classType === "one2one_single") &&
                  ev.studentnames &&
                  ev.studentnames.length > 0
                    ? ev.studentnames.join(", ")
                    : ev.title || "Event"
                }</strong>
              </div>
              <div class="tooltip-time">
                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                  <circle cx="12" cy="12" r="10"></circle>
                  <polyline points="12 6 12 12 16 14"></polyline>
                </svg>
                ${fmt12(ev.start)} – ${fmt12(ev.end)}
              </div>
              ${
                ev.avatar
                  ? `
                <div class="tooltip-teacher">
                  <img src="${ev.avatar}" alt="" class="tooltip-avatar">
                  <span>Teacher</span>
                </div>
              `
                  : ""
              }
              <div class="tooltip-type">
                ${
                  ev.repeat
                    ? '<span class="tooltip-badge">Recurring Class</span>'
                    : '<span class="tooltip-badge">Single Session</span>'
                }
                ${
                  ev.classType === "one2one_weekly" ||
                  ev.classType === "one2one_single"
                    ? '<span class="tooltip-badge">1:1 Class</span>'
                    : ev.classType === "tutoring"
                    ? '<span class="tooltip-badge">Tutoring</span>'
                    : '<span class="tooltip-badge">Main Class</span>'
                }
              </div>
            </div>
          `);

          $ev.on("mouseenter", function (e) {
            const $event = $(this);
            const eventOffset = $event.offset();
            const eventWidth = $event.outerWidth();
            const eventHeight = $event.outerHeight();

            // Position tooltip to the right of the event
            $tooltip.css({
              position: "fixed",
              top: eventOffset.top + "px",
              left: eventOffset.left + eventWidth + 10 + "px",
              zIndex: 10000,
            });

            $("body").append($tooltip);

            // Adjust if tooltip goes off screen
            const tooltipRect = $tooltip[0].getBoundingClientRect();
            if (tooltipRect.right > window.innerWidth) {
              // Position to the left instead
              $tooltip.css({
                left: eventOffset.left - $tooltip.outerWidth() - 10 + "px",
              });
            }

            $tooltip.fadeIn(200);
          });

          $ev.on("mouseleave", function () {
            $tooltip.fadeOut(200, function () {
              $tooltip.remove();
            });
          });
        }

        dayEls[di].append($ev);
      });
    });

    if (resetScroll) {
      $grid.scrollTop(0);
    } else {
      // Scroll to first event if there are any events
      const firstEvent = $grid.find(".event").first();
      if (firstEvent.length) {
        const firstEventTop = parseInt(firstEvent.css("top")) || 0;
        // Scroll to position the first event near the top, with some padding
        $grid.scrollTop(Math.max(0, firstEventTop - 50));
      }
    }
    drawNow();
  }
  window.renderWeek = renderWeek;

  function drawNow() {
    $(".now").remove();
    const now = new Date();
    const ws = new Date(currentWeekStart),
      we = new Date(ws);
    we.setDate(we.getDate() + 7);
    if (now < ws || now >= we) return;
    const di = (now.getDay() + 6) % 7;
    const mins = now.getHours() * 60 + now.getMinutes();
    let minsAdj = mins;
    if (now.getHours() < START_H) minsAdj += 24 * 60; // after midnight (e.g. 2 AM → 1560)
    if (minsAdj < START_H * 60 || minsAdj > END_H * 60) return;
    const y = (minsAdj - START_H * 60) * PX_PER_MIN;

    const dayInner = $("#grid .day .day-inner").eq(di);
    $('<div class="now">').css({ top: y }).appendTo(dayInner);
  }
});

//from calender admin php

document.addEventListener("DOMContentLoaded", () => {
  const API_BASE = "ajax/calendar_admin_filters.php";

  // Elements
  const teacherTrigger = document.getElementById("teacher-search-trigger");
  const teacherWidget = document.getElementById("search-teacher");
  const teacherFieldset = teacherWidget.querySelector(
    ".teacher-list-form fieldset"
  );
  const teacherDisplayText = document.getElementById("teacher-display-text");
  const teacherPillsContainer = document.getElementById("teacher-pills");
  const teacherSearchInput = document.getElementById("teacher-search-input");

  const cohortTrigger = document.getElementById("cohort-search-trigger");
  const cohortWidget = document.getElementById("cohort-search-widget");
  const cohortFieldset = document.getElementById("cohort-options-fieldset");
  const cohortDisplayText = document.getElementById("cohort-display-text");
  const cohortHidden = document.getElementById("cohort-value");
  const cohortSearchInput = document.getElementById("cohort-search-input");
  const cohortNoResults = document.getElementById("cohort-no-results");
  const cohortPillsContainer = document.getElementById("cohort-pills");

  // 1:1 Class tab elements
  const oneOnOneFieldset = document.getElementById("oneonone-options-fieldset");
  const oneOnOneSearchInput = document.getElementById("oneonone-search-input");
  const oneOnOneNoResults = document.getElementById("oneonone-no-results");

  const studentTrigger = document.getElementById("student-search-trigger");
  const studentWidget = document.getElementById("search-student");
  const studentFieldset = studentWidget.querySelector(
    ".student-list-form fieldset"
  );
  const studentDisplayText = document.getElementById("student-display-text");
  const studentPillsContainer = document.getElementById("student-pills");
  const studentSearchInput = document.getElementById("student-search-input");

  // State
  let selectedTeacherIds = [];
  let selectedCohortIds = []; // Changed from single to array
  let selectedStudentIds = [];

  // ---------- helpers ----------

  async function fetchJSON(url) {
    try {
      const res = await fetch(url, {
        credentials: "same-origin",
      });
      if (!res.ok) {
        console.error("Request failed:", url, res.status);
        return {
          ok: false,
        };
      }
      return await res.json();
    } catch (e) {
      console.error("Request error:", url, e);
      return {
        ok: false,
      };
    }
  }

  function clear(el) {
    while (el.firstChild) el.removeChild(el.firstChild);
  }

  // Small global loader helpers (ensure loader shows for at least 3 seconds)
  let __loaderShownAt = 0;
  let __loaderHideTimer = null;
  const __LOADER_MIN_MS = 3000; // 3 seconds

  function __setLoaderDisplay(display) {
    try {
      if (window.$) {
        window.$("#loader").css("display", display);
      } else {
        const el = document.getElementById("loader");
        if (el) el.style.display = display;
      }
    } catch (e) {
      /* ignore */
    }
  }

  function showGlobalLoader() {
    if (__loaderHideTimer) {
      clearTimeout(__loaderHideTimer);
      __loaderHideTimer = null;
    }
    __setLoaderDisplay("flex");
    __loaderShownAt = Date.now();
  }

  function hideGlobalLoader() {
    const elapsed = __loaderShownAt
      ? Date.now() - __loaderShownAt
      : __LOADER_MIN_MS;
    function doHide() {
      __setLoaderDisplay("none");
      __loaderShownAt = 0;
      __loaderHideTimer = null;
    }
    if (elapsed >= __LOADER_MIN_MS) {
      doHide();
    } else {
      __loaderHideTimer = setTimeout(doHide, __LOADER_MIN_MS - elapsed);
    }
  }

  // Function to trigger calendar reload
  function triggerCalendarReload() {
    setTimeout(() => {
      if (
        window.fetchCalendarEvents &&
        typeof window.fetchCalendarEvents === "function"
      ) {
        window.fetchCalendarEvents();
      }
    }, 200);
  }

  // ---------- Teachers ----------

  function createTeacherOption(t) {
    const wrap = document.createElement("div");
    wrap.className = "teacher-option";
    wrap.dataset.teacherId = t.id;
    wrap.dataset.teacherName = t.name;
    wrap.dataset.teacherImg = t.avatar || "";

    // Get teacher color for the indicator dot
    const teacherColor = getTeacherColor(t.id);
    const colorIndex = getTeacherColorIndex(t.id);

    wrap.innerHTML = `
            <label class="teacher-label">
                <div class="teacher-details">
                    <div class="teacher-avatar-container">
                        <img class="teacher-avatar" src="${
                          t.avatar || ""
                        }" alt="${
      t.name
    }" style="border-color: ${teacherColor};">
                    </div>
                    <span class="teacher-name">${
                      t.name
                    }<span class="teacher-color-dot" style="--dot-color: ${teacherColor}; display: none;"></span></span>
                </div>
                <div class="radio-custom">
                    <div class="radio-custom-dot"></div>
                </div>
            </label>
            <input type="checkbox" class="visually-hidden teacher-checkbox">
        `;

    wrap.addEventListener("click", (e) => {
      if (e.target.tagName === "INPUT") return;

      const checkbox = wrap.querySelector(".teacher-checkbox");
      const colorDot = wrap.querySelector(".teacher-color-dot");
      const id = parseInt(wrap.dataset.teacherId, 10);
      const wasChecked = checkbox.checked;
      checkbox.checked = !wasChecked;

      if (checkbox.checked) {
        if (!selectedTeacherIds.includes(id)) selectedTeacherIds.push(id);
        wrap.classList.add("selected");
        if (colorDot) colorDot.style.display = "inline-block";
      } else {
        selectedTeacherIds = selectedTeacherIds.filter((x) => x !== id);
        wrap.classList.remove("selected");
        if (colorDot) colorDot.style.display = "none";
      }

      updateTeacherPills();

      // Reload teachers list to re-sort (selected items to top)
      loadTeachers().then(() => {
        onTeacherFilterChange();
      });
    });

    return wrap;
  }

  function updateTeacherPills() {
    // Clear old pills
    clear(teacherPillsContainer);

    const selectedTeachersContainer = document.getElementById(
      "selected-teachers-container"
    );
    clear(selectedTeachersContainer);

    if (!selectedTeacherIds.length) {
      teacherDisplayText.textContent = "Select Teachers";
      selectedTeachersContainer.style.display = "none";
      return;
    }

    teacherDisplayText.textContent = "";
    selectedTeachersContainer.style.display = "flex";

    selectedTeacherIds.forEach((id) => {
      const opt = teacherFieldset.querySelector(
        `.teacher-option[data-teacher-id="${id}"]`
      );
      if (!opt) return;

      const name = opt.dataset.teacherName || "";
      const avatar = opt.dataset.teacherImg || "./img/default-avatar.svg";

      // Dropdown (rich pill)
      const dropdownPill = document.createElement("div");
      dropdownPill.className = "selected-teacher-pill";
      dropdownPill.innerHTML = `
      <div class="pill-user-info">
        <div class="pill-avatar-container">
          <img class="pill-avatar" src="${avatar}" alt="${name}">
        </div>
        <span class="pill-user-name">${name}</span>
      </div>
      <button type="button" class="pill-close-btn" data-teacher-id="${id}">
        <svg width="15" height="15" viewBox="0 0 15 15" fill="none">
          <path d="M11.25 3.75L3.75 11.25M3.75 3.75L11.25 11.25"
            stroke="#6a697c" stroke-width="2" stroke-linecap="round"></path>
        </svg>
      </button>
    `;
      dropdownPill
        .querySelector(".pill-close-btn")
        .addEventListener("click", (e) => {
          e.stopPropagation();

          // Remove from selected array
          selectedTeacherIds = selectedTeacherIds.filter((x) => x !== id);

          // Update the checkbox in the current list immediately
          const currentOption = teacherFieldset.querySelector(
            `.teacher-option[data-teacher-id="${id}"]`
          );
          if (currentOption) {
            const checkbox = currentOption.querySelector(".teacher-checkbox");
            const colorDot = currentOption.querySelector(".teacher-color-dot");
            if (checkbox) checkbox.checked = false;
            currentOption.classList.remove("selected");
            if (colorDot) colorDot.style.display = "none";
          }

          // Reload teacher list (rebuilds with correct selection state)
          loadTeachers().then(() => {
            // Update pills (after list is rebuilt)
            updateTeacherPills();

            // Update calendar
            onTeacherFilterChange();
          });
        });
      selectedTeachersContainer.appendChild(dropdownPill);
    });

    // ---------- Compact top summary (trigger view) ----------
    const maxAvatars = 5; // show first two profile images
    const visibleTeachers = selectedTeacherIds.slice(0, maxAvatars);

    visibleTeachers.forEach((id, idx) => {
      const opt = teacherFieldset.querySelector(
        `.teacher-option[data-teacher-id="${id}"]`
      );
      if (!opt) return;
      const avatar = opt.dataset.teacherImg || "./img/default-avatar.svg";
      const img = document.createElement("img");
      img.src = avatar;
      img.alt = opt.dataset.teacherName || "";
      img.className = "teacher-summary-avatar";
      img.style.zIndex = maxAvatars - idx;
      // Use dynamic teacher color for border
      const teacherColor = getTeacherColor(id);
      img.style.borderColor = teacherColor;
      teacherPillsContainer.appendChild(img);
    });

    // Build initials string for **all selected teachers**
    const initialsList = selectedTeacherIds
      .map((id) => {
        const opt = teacherFieldset.querySelector(
          `.teacher-option[data-teacher-id="${id}"]`
        );
        if (!opt) return "";
        const name = opt.dataset.teacherName || "";
        return getInitial(name);
      })
      .filter(Boolean);

    if (initialsList.length) {
      const initialsText = initialsList.join(", ");
      const text = document.createElement("span");
      text.className = "teacher-summary-initials";
      text.textContent = initialsText;
      teacherPillsContainer.appendChild(text);
    }

    function getInitial(name) {
      const parts = name.trim().split(" ");
      if (parts.length === 0) return "";
      return parts[0][0].toUpperCase();
    }
  }

  async function loadTeachers() {
    clear(teacherFieldset);
    const data = await fetchJSON(`${API_BASE}?action=teachers`);
    if (!data.ok) return [];

    const list = data.data || [];
    if (!list.length) {
      const div = document.createElement("div");
      div.style.padding = "8px";
      div.textContent = "No teachers found";
      teacherFieldset.appendChild(div);
      return [];
    }

    // Sort teachers: selected ones first, then unselected
    const sortedList = list.sort((a, b) => {
      const aSelected = selectedTeacherIds.includes(a.id);
      const bSelected = selectedTeacherIds.includes(b.id);
      if (aSelected && !bSelected) return -1;
      if (!aSelected && bSelected) return 1;
      return 0;
    });

    sortedList.forEach((t) => {
      const option = createTeacherOption(t);
      teacherFieldset.appendChild(option);

      // Restore selection state if previously selected
      if (selectedTeacherIds.includes(t.id)) {
        const checkbox = option.querySelector(".teacher-checkbox");
        const colorDot = option.querySelector(".teacher-color-dot");
        if (checkbox) checkbox.checked = true;
        option.classList.add("selected");
        if (colorDot) colorDot.style.display = "inline-block";
      }
    });

    return list;
  }

  // ---------- Cohorts ----------

  function updateCohortPills() {
    // Clear old pills
    if (cohortPillsContainer) clear(cohortPillsContainer);

    const selectedCohortsContainer = document.getElementById(
      "selected-cohorts-container"
    );
    const selectedOneOnOneContainer = document.getElementById(
      "oneonone-selected-container"
    );

    if (selectedCohortsContainer) clear(selectedCohortsContainer);
    if (selectedOneOnOneContainer) clear(selectedOneOnOneContainer);

    if (!selectedCohortIds.length) {
      cohortDisplayText.textContent = "Select Cohort";
      if (selectedCohortsContainer)
        selectedCohortsContainer.style.display = "none";
      if (selectedOneOnOneContainer)
        selectedOneOnOneContainer.style.display = "none";
      return;
    }

    cohortDisplayText.textContent = "";

    selectedCohortIds.forEach((id) => {
      // Find cohort in either group or 1:1 fieldset
      let opt = cohortFieldset.querySelector(
        `.cohort-option[data-cohort-id="${id}"]`
      );
      let isOneOnOne = false;

      if (!opt && oneOnOneFieldset) {
        opt = oneOnOneFieldset.querySelector(
          `.cohort-option[data-cohort-id="${id}"]`
        );
        isOneOnOne = true;
      }
      if (!opt) return;

      // Use student name for one1one cohorts, otherwise use cohort name
      const cohortType = opt.dataset.cohortType;
      const name =
        cohortType === "one1one" && opt.dataset.studentName
          ? opt.dataset.studentName
          : opt.dataset.cohortName || "";

      // Determine which container to use based on cohort type
      const targetContainer = isOneOnOne
        ? selectedOneOnOneContainer
        : selectedCohortsContainer;

      if (targetContainer) {
        // Show the container
        targetContainer.style.display = "flex";

        const dropdownPill = document.createElement("div");
        dropdownPill.className = "selected-cohort-pill";
        dropdownPill.innerHTML = `
          <div class="pill-user-info">
            <span class="pill-user-name">${name}</span>
          </div>
          <button type="button" class="pill-close-btn" data-cohort-id="${id}">
            <svg width="15" height="15" viewBox="0 0 15 15" fill="none">
              <path d="M11.25 3.75L3.75 11.25M3.75 3.75L11.25 11.25"
                stroke="#6a697c" stroke-width="2" stroke-linecap="round"></path>
            </svg>
          </button>
        `;
        dropdownPill
          .querySelector(".pill-close-btn")
          .addEventListener("click", async (e) => {
            e.stopPropagation();
            selectedCohortIds = selectedCohortIds.filter((x) => x !== id);
            const checkbox = opt.querySelector(".cohort-checkbox");
            if (checkbox) checkbox.checked = false;
            opt.classList.remove("selected");
            updateCohortPills();

            // Update students based on remaining selected cohorts
            await updateStudentsForCohortChange();

            // Trigger immediate calendar reload
            setTimeout(() => {
              if (
                window.fetchCalendarEvents &&
                typeof window.fetchCalendarEvents === "function"
              ) {
                window.fetchCalendarEvents();
              }
            }, 100);
          });
        targetContainer.appendChild(dropdownPill);
      }
    });

    // Top summary (trigger view)
    if (cohortPillsContainer) {
      const namesList = selectedCohortIds
        .map((id) => {
          let opt = cohortFieldset.querySelector(
            `.cohort-option[data-cohort-id="${id}"]`
          );
          if (!opt && oneOnOneFieldset) {
            opt = oneOnOneFieldset.querySelector(
              `.cohort-option[data-cohort-id="${id}"]`
            );
          }
          if (!opt) return "";
          // Use student name for one1one cohorts, otherwise use cohort name
          const cohortType = opt.dataset.cohortType;
          return cohortType === "one1one" && opt.dataset.studentName
            ? opt.dataset.studentName
            : opt.dataset.cohortName || "";
        })
        .filter(Boolean);

      if (namesList.length) {
        const fullText = namesList.join(", ");
        const text = document.createElement("span");
        text.className = "cohort-summary-names";
        text.textContent = fullText;
        text.title = fullText; // Show full text on hover
        cohortPillsContainer.appendChild(text);
      }
    }
  }

  function createCohortOption(c) {
    const wrap = document.createElement("div");
    wrap.className = "cohort-option";
    wrap.dataset.cohortId = c.id;
    wrap.dataset.cohortName = c.name;
    wrap.dataset.cohortType = c.cohorttype || "group";
    // Store student name for one1one cohorts
    if (c.cohorttype === "one1one" && c.studentname) {
      wrap.dataset.studentName = c.studentname;
    }

    // Display student name for one1one cohorts, otherwise show cohort name
    const displayName =
      c.cohorttype === "one1one" && c.studentname ? c.studentname : c.name;

    // Log cohorts being added to dropdown

    console.log("Dropdown Cohort:", c);

    wrap.innerHTML = `
            <label class="cohort-label">
                <div class="cohort-details">
                    <span class="cohort-name">${displayName}</span>
                </div>
                <div class="radio-custom">
                    <div class="radio-custom-dot"></div>
                </div>
            </label>
            <input type="checkbox" class="visually-hidden cohort-checkbox">
        `;

    wrap.addEventListener("click", (e) => {
      if (e.target.tagName === "INPUT") return;
      e.preventDefault();
      e.stopPropagation();

      const checkbox = wrap.querySelector(".cohort-checkbox");
      const id = parseInt(wrap.dataset.cohortId, 10);

      // Toggle checkbox
      checkbox.checked = !checkbox.checked;

      if (checkbox.checked) {
        if (!selectedCohortIds.includes(id)) {
          selectedCohortIds.push(id);
        }
        wrap.classList.add("selected");
      } else {
        selectedCohortIds = selectedCohortIds.filter((x) => x !== id);
        wrap.classList.remove("selected");
      }

      updateCohortPills();

      // Reload cohort lists to re-sort (selected items to top)
      if (selectedTeacherIds.length > 0) {
        loadCohortsForTeachers(selectedTeacherIds, false).then(() => {
          // Load students and auto-select based on events
          updateStudentsForCohortChange();
        });
      } else {
        loadAllCohorts().then(() => {
          // Load students and auto-select based on events
          updateStudentsForCohortChange();
        });
      }

      // Trigger immediate calendar reload
      setTimeout(() => {
        if (
          window.fetchCalendarEvents &&
          typeof window.fetchCalendarEvents === "function"
        ) {
          window.fetchCalendarEvents();
        }
      }, 100);
    });

    // Also handle direct checkbox clicks
    const checkbox = wrap.querySelector(".cohort-checkbox");
    checkbox.addEventListener("change", (e) => {
      e.stopPropagation();
      const id = parseInt(wrap.dataset.cohortId, 10);

      if (checkbox.checked) {
        if (!selectedCohortIds.includes(id)) {
          selectedCohortIds.push(id);
        }
        wrap.classList.add("selected");
      } else {
        selectedCohortIds = selectedCohortIds.filter((x) => x !== id);
        wrap.classList.remove("selected");
      }

      updateCohortPills();

      // Reload cohort lists to re-sort (selected items to top)
      if (selectedTeacherIds.length > 0) {
        loadCohortsForTeachers(selectedTeacherIds, false).then(() => {
          // Load students and auto-select based on events
          updateStudentsForCohortChange();
        });
      } else {
        loadAllCohorts().then(() => {
          // Load students and auto-select based on events
          updateStudentsForCohortChange();
        });
      }

      // Trigger immediate calendar reload
      setTimeout(() => {
        if (
          window.fetchCalendarEvents &&
          typeof window.fetchCalendarEvents === "function"
        ) {
          window.fetchCalendarEvents();
        }
      }, 100);
    });

    return wrap;
  }

  // Function to populate peertalk cohorts dropdown
  function populatePeerTalkCohorts(cohortsList) {
    const $peertalkDropdownList = $("#peertalkCohortsDropdownList ul");
    if (!$peertalkDropdownList.length) return;

    // Clear existing items (except search input)
    $peertalkDropdownList.empty();

    // Filter out one-on-one cohorts for peertalk
    const groupCohorts = cohortsList.filter((c) => c.cohorttype !== "one1one");

    if (groupCohorts.length === 0) {
      $peertalkDropdownList.append(
        '<li style="pointer-events:none;opacity:.6;">No cohorts available</li>'
      );
      return;
    }

    // Add each cohort to the dropdown
    groupCohorts.forEach((cohort) => {
      const cohortName = cohort.name || cohort.idnumber || "";
      const cohortId = cohort.id;
      const cohortIdnumber = cohort.idnumber || "";
      const $li = $(
        `<li class="peertalk_cohort_item" data-id="${cohortId}" data-idnumber="${cohortIdnumber}" data-name="${cohortName}">${cohortName}</li>`
      );
      $peertalkDropdownList.append($li);
    });

    console.log(
      `Populated ${groupCohorts.length} cohorts in peertalk dropdown`
    );
  }

  async function loadAllCohorts() {
    clear(cohortFieldset);
    clear(oneOnOneFieldset);
    cohortNoResults.style.display = "none";
    if (oneOnOneNoResults) oneOnOneNoResults.style.display = "none";

    const data = await fetchJSON(`${API_BASE}?action=cohorts`);
    if (!data.ok) return [];

    const list = data.data || [];
    if (!list.length) {
      cohortNoResults.style.display = "block";
      return [];
    }

    // Populate peertalk cohorts dropdown
    populatePeerTalkCohorts(list);

    // Remove duplicates based on cohort ID
    const uniqueList = Array.from(new Map(list.map((c) => [c.id, c])).values());

    // Separate cohorts by type
    const groupCohorts = uniqueList.filter((c) => c.cohorttype !== "one1one");
    const oneOnOneCohorts = uniqueList.filter(
      (c) => c.cohorttype === "one1one"
    );

    // For 1:1 cohorts, also deduplicate by student name to avoid showing same student multiple times
    const uniqueOneOnOne = Array.from(
      new Map(oneOnOneCohorts.map((c) => [c.studentname || c.name, c])).values()
    );

    // Add group cohorts to Cohorts tab
    if (groupCohorts.length > 0) {
      groupCohorts.forEach((c) => {
        const option = createCohortOption(c);
        cohortFieldset.appendChild(option);

        // Restore selection state if previously selected
        if (selectedCohortIds.includes(c.id)) {
          const checkbox = option.querySelector(".cohort-checkbox");
          if (checkbox) checkbox.checked = true;
          option.classList.add("selected");
        }
        // Log group cohorts appended
        try {
          console.log("Appended Group Cohort:", { id: c.id, name: c.name });
        } catch (e) {}
      });
    } else {
      cohortNoResults.style.display = "block";
    }

    // Add 1:1 cohorts to 1:1 Class tab
    if (uniqueOneOnOne.length > 0) {
      uniqueOneOnOne.forEach((c) => {
        const option = createCohortOption(c);
        oneOnOneFieldset.appendChild(option);

        // Restore selection state if previously selected
        if (selectedCohortIds.includes(c.id)) {
          const checkbox = option.querySelector(".cohort-checkbox");
          if (checkbox) checkbox.checked = true;
          option.classList.add("selected");
        }
        // Log 1:1 cohorts appended
        try {
          console.log("Appended 1:1 Cohort:", {
            id: c.id,
            name: c.studentname || c.name,
          });
        } catch (e) {}
      });
    } else if (oneOnOneNoResults) {
      oneOnOneNoResults.style.display = "block";
    }

    return uniqueList;
  }

  async function loadCohortsForTeachers(teacherIds, returnList = false) {
    clear(cohortFieldset);
    clear(oneOnOneFieldset);
    cohortNoResults.style.display = "none";
    if (oneOnOneNoResults) oneOnOneNoResults.style.display = "none";

    if (!teacherIds || !teacherIds.length) {
      return loadAllCohorts();
    }

    const url = `${API_BASE}?action=cohorts&teacherids=${encodeURIComponent(
      teacherIds.join(",")
    )}`;
    const data = await fetchJSON(url);

    if (!data.ok) return [];

    const list = data.data || [];

    if (!list.length) {
      cohortNoResults.style.display = "block";
      return [];
    }

    // Populate peertalk cohorts dropdown
    populatePeerTalkCohorts(list);

    // Remove duplicates based on cohort ID
    const uniqueList = Array.from(new Map(list.map((c) => [c.id, c])).values());

    // Separate cohorts by type
    const groupCohorts = uniqueList.filter((c) => c.cohorttype !== "one1one");
    const oneOnOneCohorts = uniqueList.filter(
      (c) => c.cohorttype === "one1one"
    );

    // For 1:1 cohorts, also deduplicate by student name to avoid showing same student multiple times
    const uniqueOneOnOne = Array.from(
      new Map(oneOnOneCohorts.map((c) => [c.studentname || c.name, c])).values()
    );

    // Add group cohorts to Cohorts tab
    if (groupCohorts.length > 0) {
      // Sort cohorts: selected ones first, then unselected
      const sortedGroupCohorts = groupCohorts.sort((a, b) => {
        const aSelected = selectedCohortIds.includes(a.id);
        const bSelected = selectedCohortIds.includes(b.id);
        if (aSelected && !bSelected) return -1;
        if (!aSelected && bSelected) return 1;
        return 0;
      });

      sortedGroupCohorts.forEach((c) => {
        const option = createCohortOption(c);
        cohortFieldset.appendChild(option);

        // Restore selection state if previously selected
        if (selectedCohortIds.includes(c.id)) {
          const checkbox = option.querySelector(".cohort-checkbox");
          if (checkbox) checkbox.checked = true;
          option.classList.add("selected");
        }
        // Log group cohorts appended (teacher-filtered)
        try {
          console.log("Appended Group Cohort (by teacher):", {
            id: c.id,
            name: c.name,
          });
        } catch (e) {}
      });
    } else {
      cohortNoResults.style.display = "block";
    }

    // Add 1:1 cohorts to 1:1 Class tab
    if (uniqueOneOnOne.length > 0) {
      // Sort cohorts: selected ones first, then unselected
      const sortedOneOnOne = uniqueOneOnOne.sort((a, b) => {
        const aSelected = selectedCohortIds.includes(a.id);
        const bSelected = selectedCohortIds.includes(b.id);
        if (aSelected && !bSelected) return -1;
        if (!aSelected && bSelected) return 1;
        return 0;
      });

      sortedOneOnOne.forEach((c) => {
        const option = createCohortOption(c);
        oneOnOneFieldset.appendChild(option);

        // Restore selection state if previously selected
        if (selectedCohortIds.includes(c.id)) {
          const checkbox = option.querySelector(".cohort-checkbox");
          if (checkbox) checkbox.checked = true;
          option.classList.add("selected");
        }
        // Log 1:1 cohorts appended (teacher-filtered)
        try {
          console.log("Appended 1:1 Cohort (by teacher):", {
            id: c.id,
            name: c.studentname || c.name,
          });
        } catch (e) {}
      });
    } else if (oneOnOneNoResults) {
      oneOnOneNoResults.style.display = "block";
    }

    return returnList ? uniqueList : [];
  }

  cohortSearchInput.addEventListener("input", () => {
    const term = cohortSearchInput.value.trim().toLowerCase();
    let visible = 0;
    cohortFieldset.querySelectorAll(".cohort-option").forEach((opt) => {
      const name = (opt.dataset.cohortName || "").toLowerCase();
      const show = !term || name.includes(term);
      opt.style.display = show ? "" : "none";
      if (show) visible++;
    });
    cohortNoResults.style.display = visible ? "none" : "block";
  });

  // ---------- Students ----------

  function createStudentOption(s) {
    console.log("Creating student option:", s);
    const wrap = document.createElement("div");
    wrap.className = "student-option";
    wrap.dataset.studentId = s.id;
    wrap.dataset.studentName = s.name;
    wrap.dataset.studentImg = s.avatar || "";

    // Get cohort short name (first 4 characters of cohort idnumber or cohortname)
    const cohortShortName = s.cohortsname
      ? s.cohortsname.substring(0, 4)
      : s.cohortname
      ? s.cohortname.substring(0, 4)
      : "";

    // Check if this is a 1:1 cohort student
    const isOneOnOne = s.cohorttype === "one1one";

    wrap.innerHTML = `
          <label class="student-label">
              <div class="student-details">
                  <div class="student-avatar-container">
                      <img class="student-avatar" src="${
                        s.avatar || ""
                      }" alt="${s.name}">
                  </div>
                  <div class="student-name-wrapper">
                      ${
                        cohortShortName
                          ? `<span class="student-cohort-badge">${cohortShortName}</span>`
                          : ""
                      }
                      <span class="student-name">${s.name}</span>
                      ${
                        isOneOnOne
                          ? '<span class="student-type-badge">1:1</span>'
                          : ""
                      }
                  </div>
              </div>
              <div class="radio-custom">
                  <div class="radio-custom-dot"></div>
              </div>
          </label>
          <input type="checkbox" class="visually-hidden student-checkbox">
      `;

    wrap.addEventListener("click", (e) => {
      if (e.target.tagName === "INPUT") return;
      const checkbox = wrap.querySelector(".student-checkbox");
      const id = parseInt(wrap.dataset.studentId, 10);
      checkbox.checked = !checkbox.checked;

      if (checkbox.checked) {
        if (!selectedStudentIds.includes(id)) selectedStudentIds.push(id);
        wrap.classList.add("selected");
      } else {
        selectedStudentIds = selectedStudentIds.filter((x) => x !== id);
        wrap.classList.remove("selected");
      }

      updateStudentPills();

      // Reload students list to re-sort (selected items to top)
      if (selectedCohortIds.length > 0) {
        loadStudentsForCohorts(selectedCohortIds, false);
      } else {
        loadAllStudents();
      }

      // Trigger immediate calendar reload
      setTimeout(() => {
        if (
          window.fetchCalendarEvents &&
          typeof window.fetchCalendarEvents === "function"
        ) {
          window.fetchCalendarEvents();
        }
      }, 100);
    });

    return wrap;
  }

  function updateStudentPills() {
    // Clear the top trigger pills
    clear(studentPillsContainer);

    // Update inside the dropdown list
    const selectedStudentsContainer = document.getElementById(
      "selected-students-container"
    );
    clear(selectedStudentsContainer);

    if (!selectedStudentIds.length) {
      studentDisplayText.textContent = "Select Students";
      selectedStudentsContainer.style.display = "none";
      return;
    }

    studentDisplayText.textContent = "";
    selectedStudentsContainer.style.display = "flex";

    selectedStudentIds.forEach((id) => {
      const opt = studentFieldset.querySelector(
        `.student-option[data-student-id="${id}"]`
      );
      if (!opt) return;

      const name = opt.dataset.studentName || "";
      const avatar = opt.dataset.studentImg || "./img/default-avatar.svg";

      // Dropdown pill (with avatar + name + close)
      const dropdownPill = document.createElement("div");
      dropdownPill.className = "selected-student-pill";
      dropdownPill.innerHTML = `
      <div class="pill-user-info">
        <div class="pill-avatar-container">
          <img class="pill-avatar" src="${avatar}" alt="${name}">
        </div>
        <span class="pill-user-name">${name}</span>
      </div>
      <button type="button" class="pill-close-btn" data-student-id="${id}">
        <svg width="15" height="15" viewBox="0 0 15 15" fill="none">
          <path d="M11.25 3.75L3.75 11.25M3.75 3.75L11.25 11.25"
            stroke="#6a697c" stroke-width="2" stroke-linecap="round"></path>
        </svg>
      </button>
    `;

      // Handle remove click
      dropdownPill
        .querySelector(".pill-close-btn")
        .addEventListener("click", (e) => {
          e.stopPropagation();
          selectedStudentIds = selectedStudentIds.filter((x) => x !== id);
          const checkbox = opt.querySelector(".student-checkbox");
          if (checkbox) checkbox.checked = false;
          opt.classList.remove("selected");
          updateStudentPills();

          // Trigger immediate calendar reload
          setTimeout(() => {
            if (
              window.fetchCalendarEvents &&
              typeof window.fetchCalendarEvents === "function"
            ) {
              window.fetchCalendarEvents();
            }
          }, 100);
        });

      selectedStudentsContainer.appendChild(dropdownPill);
    });

    // ---------- Compact top summary (trigger view) ----------
    const maxAvatars = 2; // show first two avatars
    const visibleStudents = selectedStudentIds.slice(0, maxAvatars);

    visibleStudents.forEach((id, idx) => {
      const opt = studentFieldset.querySelector(
        `.student-option[data-student-id="${id}"]`
      );
      if (!opt) return;
      const avatar = opt.dataset.studentImg || "./img/default-avatar.svg";
      const img = document.createElement("img");
      img.src = avatar;
      img.alt = opt.dataset.studentName || "";
      img.className = "student-summary-avatar";
      img.style.zIndex = maxAvatars - idx;
      studentPillsContainer.appendChild(img);
    });

    // Build initials for all selected students
    const initialsList = selectedStudentIds
      .map((id) => {
        const opt = studentFieldset.querySelector(
          `.student-option[data-student-id="${id}"]`
        );
        if (!opt) return "";
        const name = opt.dataset.studentName || "";
        return getInitial(name);
      })
      .filter(Boolean);

    if (initialsList.length) {
      const initialsText = initialsList.join(", ");
      const text = document.createElement("span");
      text.className = "student-summary-initials";
      text.textContent = initialsText;
      studentPillsContainer.appendChild(text);
    }

    function getInitial(name) {
      const parts = name.trim().split(" ");
      if (parts.length === 0) return "";
      return parts[0][0].toUpperCase();
    }
  }

  async function loadAllStudents() {
    clear(studentFieldset);
    const data = await fetchJSON(`${API_BASE}?action=students`);
    if (!data.ok) return;

    const list = data.data || [];
    if (!list.length) {
      const div = document.createElement("div");
      div.style.padding = "8px";
      div.textContent = "No students found";
      studentFieldset.appendChild(div);
      return;
    }

    // Sort students: selected ones first, then unselected
    const sortedList = list.sort((a, b) => {
      const aSelected = selectedStudentIds.includes(a.id);
      const bSelected = selectedStudentIds.includes(b.id);
      if (aSelected && !bSelected) return -1;
      if (!aSelected && bSelected) return 1;
      return 0;
    });

    sortedList.forEach((s) =>
      studentFieldset.appendChild(createStudentOption(s))
    );
  }

  async function loadStudentsForCohorts(cohortIds, clearSelection = true) {
    clear(studentFieldset);

    // Only clear selection if explicitly requested
    if (clearSelection) {
      selectedStudentIds = [];
    }

    if (!cohortIds || !cohortIds.length) {
      const div = document.createElement("div");
      div.style.padding = "8px";
      div.textContent = "Select cohorts to see students";
      studentFieldset.appendChild(div);
      return;
    }

    const url = `${API_BASE}?action=students&cohortids=${encodeURIComponent(
      cohortIds.join(",")
    )}`;
    const data = await fetchJSON(url);
    if (!data.ok) {
      return;
    }

    const list = data.data || [];
    if (!list.length) {
      const div = document.createElement("div");
      div.style.padding = "8px";
      div.textContent = "No students found in selected cohorts";
      studentFieldset.appendChild(div);
      return;
    }

    // Group students by cohort
    const studentsByCohort = {};
    list.forEach((s) => {
      const cohortKey = s.cohortid || 0;
      const cohortName = s.cohortname || "Unknown Cohort";

      if (!studentsByCohort[cohortKey]) {
        studentsByCohort[cohortKey] = {
          name: cohortName,
          students: [],
        };
      }
      studentsByCohort[cohortKey].students.push(s);
    });

    // Render grouped students
    Object.keys(studentsByCohort).forEach((cohortKey) => {
      const cohortGroup = studentsByCohort[cohortKey];

      // Add cohort header
      const cohortHeader = document.createElement("div");
      cohortHeader.className = "student-cohort-header";
      cohortHeader.textContent = cohortGroup.name;
      studentFieldset.appendChild(cohortHeader);

      // Sort students in this cohort: selected ones first, then unselected
      const sortedStudents = cohortGroup.students.sort((a, b) => {
        const aSelected = selectedStudentIds.includes(a.id);
        const bSelected = selectedStudentIds.includes(b.id);
        if (aSelected && !bSelected) return -1;
        if (!aSelected && bSelected) return 1;
        return 0;
      });

      // Add students under this cohort
      sortedStudents.forEach((s) => {
        const option = createStudentOption(s);
        studentFieldset.appendChild(option);

        // Restore selection state if previously selected
        // Convert s.id to number to ensure proper comparison
        const studentId = parseInt(s.id, 10);
        if (selectedStudentIds.includes(studentId)) {
          const checkbox = option.querySelector(".student-checkbox");
          if (checkbox) checkbox.checked = true;
          option.classList.add("selected");
        }
      });
    });

    updateStudentPills();
  }

  studentSearchInput.addEventListener("input", () => {
    const term = studentSearchInput.value.trim().toLowerCase();
    studentFieldset.querySelectorAll(".student-option").forEach((opt) => {
      const name = (opt.dataset.studentName || "").toLowerCase();
      opt.style.display = !term || name.includes(term) ? "" : "none";
    });
  });

  // ---------- Filter change logic ----------

  async function onTeacherFilterChange() {
    // Reset cohort + student UI
    selectedCohortIds = [];
    cohortHidden.value = "";
    cohortDisplayText.textContent = "Select Cohort";
    clear(cohortFieldset);
    if (oneOnOneFieldset) clear(oneOnOneFieldset);
    updateCohortPills();

    selectedStudentIds = [];
    updateStudentPills();
    clear(studentFieldset);

    if (!selectedTeacherIds.length) {
      const allCohorts = await loadAllCohorts();

      await loadAllStudents();
      // No teacher selected → clear events and re-render blank calendar
      window.events = [];
      if (typeof renderWeek === "function") renderWeek(true);
      return;
    }

    // Load cohorts for selected teachers
    const cohorts = await loadCohortsForTeachers(selectedTeacherIds, true);

    if (cohorts && cohorts.length) {
      // Fetch events first to determine which cohorts/students have events
      const eventsData = await fetchEventsForTeachers(selectedTeacherIds);

      if (eventsData && eventsData.length > 0) {
        // Extract unique cohort IDs and student IDs from events
        const eventCohortIds = new Set();
        const eventStudentIds = new Set();

        eventsData.forEach((ev, idx) => {
          if (
            ev.cohortids &&
            Array.isArray(ev.cohortids) &&
            ev.cohortids.length > 0
          ) {
            ev.cohortids.forEach((cid) => eventCohortIds.add(cid));
          }

          // Check for studentids in multiple possible formats
          if (
            ev.studentids &&
            Array.isArray(ev.studentids) &&
            ev.studentids.length > 0
          ) {
            ev.studentids.forEach((sid) => eventStudentIds.add(sid));
          } else if (
            ev.studentIds &&
            Array.isArray(ev.studentIds) &&
            ev.studentIds.length > 0
          ) {
            // Try camelCase variant
            ev.studentIds.forEach((sid) => eventStudentIds.add(sid));
          } else if (
            ev.students &&
            Array.isArray(ev.students) &&
            ev.students.length > 0
          ) {
            // Try students array
            ev.students.forEach((s) => {
              if (s.id) eventStudentIds.add(s.id);
              else if (typeof s === "number") eventStudentIds.add(s);
            });
          }
        });

        // Auto-select cohorts that have events
        // This includes both group cohorts (from eventCohortIds) and 1:1 cohorts (inferred from students)
        const cohortsToSelect = new Set();

        // Add cohorts that are directly in events
        eventCohortIds.forEach((cid) => cohortsToSelect.add(cid));

        // For 1:1 events (no cohortids but have studentids), we need to find which specific 1:1 cohorts contain those students
        // We'll do this by loading students for each 1:1 cohort and checking if any event students are in it
        if (eventStudentIds.size > 0) {
          const oneOnOneCohorts = cohorts.filter(
            (c) => c.cohorttype === "one1one"
          );
          // For now, we'll select all 1:1 cohorts and let the student filtering handle it
          // A better approach would be to fetch students for each 1:1 cohort first, but that would be too many API calls
          // Instead, we'll select all 1:1 cohorts and the loadStudentsForCohorts will fetch all their students
          oneOnOneCohorts.forEach((c) => {
            cohortsToSelect.add(c.id);
          });
        }

        // Apply selection to all cohorts that should be selected
        if (cohortsToSelect.size > 0) {
          cohorts.forEach((c) => {
            if (cohortsToSelect.has(c.id)) {
              if (!selectedCohortIds.includes(c.id)) {
                selectedCohortIds.push(c.id);
              }
            }
          });

          cohortDisplayText.textContent = "";
          updateCohortPills();

          // Reload cohorts with sorting applied (selected items to top)
          await loadCohortsForTeachers(selectedTeacherIds, false);
        }

        // Load students for selected cohorts
        // Don't clear selection yet - we'll rebuild it after loading
        if (selectedCohortIds.length > 0) {
          // Use loadStudentsForCohorts to get proper cohort information with headers
          await loadStudentsForCohorts(selectedCohortIds, false);
        } else {
          // If no cohorts selected but we have student IDs from events (1:1 classes),
          // load all students so we can select the ones with events
          await loadAllStudents();
        }

        // Clear previous selection and rebuild based on events
        selectedStudentIds = [];

        // Auto-select only students that have events
        if (eventStudentIds.size > 0) {
          eventStudentIds.forEach((sid) => {
            if (!selectedStudentIds.includes(sid)) {
              selectedStudentIds.push(sid);
            }
          });

          updateStudentPills();

          // Reload students with sorting applied (selected items to top)
          if (selectedCohortIds.length > 0) {
            await loadStudentsForCohorts(selectedCohortIds, false);
          } else {
            await loadAllStudents();
          }
        }
      }

      // Clear events immediately to remove old teacher dots
      window.events = [];
      if (typeof renderWeek === "function") renderWeek(true);

      // Refresh calendar using the teacher and cohort filters - call directly with small delay
      // to ensure all state updates are complete
      setTimeout(() => {
        if (
          window.fetchCalendarEvents &&
          typeof window.fetchCalendarEvents === "function"
        ) {
          window.fetchCalendarEvents();
        }
      }, 100);
    } else {
      // No cohorts for that teacher -> keep students empty and show message
      clear(studentFieldset);
      const div = document.createElement("div");
      div.style.padding = "8px";
      div.textContent = "No cohorts for selected teacher";
      cohortFieldset.appendChild(div);

      // Clear events immediately to remove old teacher dots
      window.events = [];
      if (typeof renderWeek === "function") renderWeek(true);

      // Refresh calendar - call directly with small delay
      setTimeout(() => {
        if (
          window.fetchCalendarEvents &&
          typeof window.fetchCalendarEvents === "function"
        ) {
          window.fetchCalendarEvents();
        }
      }, 100);
    }
  }

  // ---------- Dropdown toggles ----------

  teacherTrigger.addEventListener("click", () => {
    teacherWidget.style.display =
      teacherWidget.style.display === "none" || !teacherWidget.style.display
        ? "block"
        : "none";
  });

  cohortTrigger.addEventListener("click", () => {
    cohortWidget.style.display =
      cohortWidget.style.display === "none" || !cohortWidget.style.display
        ? "block"
        : "none";
  });

  studentTrigger.addEventListener("click", () => {
    studentWidget.style.display =
      studentWidget.style.display === "none" || !studentWidget.style.display
        ? "block"
        : "none";
  });

  // Close dropdowns when clicking outside
  document.addEventListener("click", (e) => {
    if (
      !teacherTrigger.contains(e.target) &&
      !teacherWidget.contains(e.target)
    ) {
      teacherWidget.style.display = "none";
    }
    if (!cohortTrigger.contains(e.target) && !cohortWidget.contains(e.target)) {
      cohortWidget.style.display = "none";
    }
    if (
      !studentTrigger.contains(e.target) &&
      !studentWidget.contains(e.target)
    ) {
      studentWidget.style.display = "none";
    }
  });

  // Helper function to fetch events data for auto-selection (doesn't update UI)
  async function fetchEventsForTeachers(teacherIds) {
    if (!teacherIds || !teacherIds.length) return [];

    const params = new URLSearchParams();
    const now = new Date();
    const startDate = new Date(
      now.getFullYear(),
      now.getMonth(),
      now.getDate() - 30
    );
    const endDate = new Date(
      now.getFullYear(),
      now.getMonth() + 3,
      now.getDate()
    );

    const formatYMD = (d) => {
      const y = d.getFullYear();
      const m = String(d.getMonth() + 1).padStart(2, "0");
      const day = String(d.getDate()).padStart(2, "0");
      return `${y}-${m}-${day}`;
    };

    params.set("start", formatYMD(startDate));
    params.set("end", formatYMD(endDate));
    params.set("teacherids", teacherIds.join(","));

    try {
      const response = await fetch(
        `ajax/calendar_admin_get_events.php?${params.toString()}`,
        {
          credentials: "same-origin",
        }
      );

      if (!response.ok) return [];

      const data = await response.json();
      return data.ok && Array.isArray(data.events) ? data.events : [];
    } catch (err) {
      console.error("Failed to fetch events for auto-selection:", err);
      return [];
    }
  }

  // Helper function to update students when cohort selection changes
  async function updateStudentsForCohortChange() {
    console.log(
      "updateStudentsForCohortChange: Selected cohorts:",
      selectedCohortIds
    );

    if (!selectedCohortIds.length) {
      console.log(
        "updateStudentsForCohortChange: No cohorts selected, clearing students"
      );
      selectedStudentIds = [];
      clear(studentFieldset);
      updateStudentPills();
      return;
    }

    // Load students for selected cohorts first (keep existing selection temporarily)
    await loadStudentsForCohorts(selectedCohortIds, false);

    // Now clear and rebuild selection based on events
    selectedStudentIds = [];

    // If teachers are selected, fetch events and auto-select students based on events
    if (selectedTeacherIds.length > 0) {
      const eventsData = await fetchEventsForTeachers(selectedTeacherIds);

      if (eventsData && eventsData.length > 0) {
        const eventStudentIds = new Set();

        // Get all 1:1 cohort IDs from selected cohorts
        const selected1to1CohortIds = [];
        selectedCohortIds.forEach((cid) => {
          // Check if this cohort is in the 1:1 fieldset
          const option = oneOnOneFieldset?.querySelector(
            `.cohort-option[data-cohort-id="${cid}"]`
          );
          if (option) {
            selected1to1CohortIds.push(cid);
          }
        });

        console.log(
          "updateStudentsForCohortChange: Selected 1:1 cohorts:",
          selected1to1CohortIds
        );

        eventsData.forEach((ev) => {
          // Check if event matches selected cohorts (for group classes)
          const hasMatchingGroupCohort =
            ev.cohortids &&
            ev.cohortids.length > 0 &&
            ev.cohortids.some((cid) => selectedCohortIds.includes(cid));

          // For 1:1 classes: event has empty cohortids but populated studentids
          // We need to check if ANY selected cohort is a 1:1 cohort
          const is1to1Event =
            (!ev.cohortids || ev.cohortids.length === 0) &&
            ev.studentids &&
            ev.studentids.length > 0;

          const shouldInclude =
            hasMatchingGroupCohort ||
            (is1to1Event && selected1to1CohortIds.length > 0);

          if (shouldInclude && ev.studentids && Array.isArray(ev.studentids)) {
            ev.studentids.forEach((sid) => eventStudentIds.add(sid));
          }
        });

        // Auto-select students that have events
        eventStudentIds.forEach((sid) => {
          const option = studentFieldset.querySelector(
            `.student-option[data-student-id="${sid}"]`
          );
          if (option) {
            // Only add to selectedStudentIds if the option exists
            if (!selectedStudentIds.includes(sid)) {
              selectedStudentIds.push(sid);
            }
            const checkbox = option.querySelector(".student-checkbox");
            if (checkbox) checkbox.checked = true;
            option.classList.add("selected");
          }
        });

        updateStudentPills();
      }
    }
  }

  // ---------- Init ----------

  clear(teacherFieldset);
  clear(cohortFieldset);
  clear(studentFieldset);

  (async () => {
    await loadTeachers(); // Load teachers list only
    await loadAllCohorts(); // Show available cohorts (optional)
    await loadAllStudents(); // Show available students (optional)

    // No teachers selected yet → show empty calendar
    window.events = [];
    if (typeof renderWeek === "function") renderWeek(true);
  })();

  // Expose state for calendar query usage
  window.calendarFilterState = {
    getSelectedTeachers: () => [...selectedTeacherIds],
    getSelectedCohorts: () => [...selectedCohortIds],
    getSelectedStudents: () => [...selectedStudentIds],
  };

  // ----------------- Reset buttons for cohort widget -----------------
  // These buttons live in the cohort widget header. "Reset" clears the
  // currently visible tab. "Reset All" clears all cohort-related selections.
  const cohortResetBtnEl = document.getElementById("cohort-reset");
  const cohortResetAllBtnEl = document.getElementById("cohort-reset-all");

  function resetActiveCohortTab() {
    try {
      const activeBtn = document.querySelector(
        ".cohort-tab-btn.cohort-tab-active"
      );
      const tab =
        (activeBtn && activeBtn.dataset && activeBtn.dataset.tab) || "cohort";

      if (tab === "cohort") {
        // clear checkbox selections for cohorts (multi-select)
        cohortFieldset
          .querySelectorAll(".cohort-checkbox:checked")
          .forEach((cb) => {
            cb.checked = false;
            const opt = cb.closest(".cohort-option");
            if (opt) opt.classList.remove("selected");
          });
        selectedCohortIds = [];
        if (cohortHidden) cohortHidden.value = "";
        if (cohortDisplayText) cohortDisplayText.textContent = "Select Cohort";
        updateCohortPills();
      } else if (tab === "oneonone") {
        // clear 1:1 cohort selections
        if (oneOnOneFieldset) {
          oneOnOneFieldset
            .querySelectorAll(".cohort-checkbox:checked")
            .forEach((cb) => {
              cb.checked = false;
              const opt = cb.closest(".cohort-option");
              if (opt) opt.classList.remove("selected");
            });
        }
        // Remove 1:1 cohort IDs from selectedCohortIds
        const oneOnOneIds = Array.from(
          oneOnOneFieldset?.querySelectorAll(".cohort-option") || []
        ).map((opt) => parseInt(opt.dataset.cohortId, 10));
        selectedCohortIds = selectedCohortIds.filter(
          (id) => !oneOnOneIds.includes(id)
        );
        if (cohortHidden) cohortHidden.value = "";
        if (cohortDisplayText) cohortDisplayText.textContent = "Select Cohort";
        updateCohortPills();
      } else {
        // clear checkboxes for the active multi-select tab
        const fs = document.getElementById(tab + "-options-fieldset");
        if (fs) {
          fs.querySelectorAll("input[type=checkbox]:checked").forEach((cb) => {
            cb.checked = false;
            cb.dispatchEvent(new Event("change", { bubbles: true }));
          });
        }
      }
    } catch (err) {
      console.error("resetActiveCohortTab error", err);
    }
  }

  function resetAllCohortTabs() {
    try {
      // Clear cohort checkbox selections (multi-select)
      cohortFieldset
        .querySelectorAll(".cohort-checkbox:checked")
        .forEach((cb) => {
          cb.checked = false;
          const opt = cb.closest(".cohort-option");
          if (opt) opt.classList.remove("selected");
        });
      selectedCohortIds = [];
      if (cohortHidden) cohortHidden.value = "";
      if (cohortDisplayText) cohortDisplayText.textContent = "Select Cohort";
      updateCohortPills();

      // Clear all multi-select tabs (oneonone / conference / peertalk)
      ["oneonone", "conference", "peertalk"].forEach((t) => {
        const fs = document.getElementById(t + "-options-fieldset");
        if (fs) {
          fs.querySelectorAll("input[type=checkbox]:checked").forEach((cb) => {
            cb.checked = false;
            cb.dispatchEvent(new Event("change", { bubbles: true }));
          });
        }
        // clear any selected-pill containers
        const container = document.getElementById(t + "-selected-container");
        if (container) container.innerHTML = "";
      });
    } catch (err) {
      console.error("resetAllCohortTabs error", err);
    }
  }

  if (cohortResetBtnEl) {
    cohortResetBtnEl.addEventListener("click", (e) => {
      e.preventDefault();
      resetActiveCohortTab();
      // trigger calendar reload via exposed helper
      if (typeof triggerCalendarReload === "function") triggerCalendarReload();
      else if (typeof fetchCalendarEvents === "function") fetchCalendarEvents();
    });
  }

  if (cohortResetAllBtnEl) {
    cohortResetAllBtnEl.addEventListener("click", (e) => {
      e.preventDefault();
      resetAllCohortTabs();
      if (typeof triggerCalendarReload === "function") triggerCalendarReload();
      else if (typeof fetchCalendarEvents === "function") fetchCalendarEvents();
    });
  }

  // ----------------- Teacher Reset -----------------
  const teacherResetBtn = document.getElementById("teacher-reset");
  if (teacherResetBtn) {
    teacherResetBtn.addEventListener("click", (e) => {
      e.preventDefault();
      try {
        // Uncheck all teacher checkboxes
        teacherFieldset
          .querySelectorAll(".teacher-checkbox:checked")
          .forEach((cb) => {
            cb.checked = false;
            const opt = cb.closest(".teacher-option");
            if (opt) {
              opt.classList.remove("selected");
              const colorDot = opt.querySelector(".teacher-color-dot");
              if (colorDot) colorDot.style.display = "none";
            }
          });

        // Clear selected teachers array
        selectedTeacherIds = [];
        updateTeacherPills();

        // Clear cohorts and students as they depend on teacher selection
        selectedCohortIds = [];
        selectedStudentIds = [];
        updateCohortPills();
        updateStudentPills();

        // Clear calendar events
        window.events = [];
        if (typeof renderWeek === "function") renderWeek(true);

        // Reload cohorts and students
        loadAllCohorts();
        loadAllStudents();
      } catch (err) {
        console.error("Teacher reset error:", err);
      }
    });
  }

  // ----------------- Student Reset -----------------
  const studentResetBtn = document.getElementById("student-reset");
  if (studentResetBtn) {
    studentResetBtn.addEventListener("click", (e) => {
      e.preventDefault();
      try {
        // Uncheck all student checkboxes
        studentFieldset
          .querySelectorAll(".student-checkbox:checked")
          .forEach((cb) => {
            cb.checked = false;
            const opt = cb.closest(".student-option");
            if (opt) opt.classList.remove("selected");
          });

        // Clear selected students array
        selectedStudentIds = [];
        updateStudentPills();

        // Trigger calendar reload
        setTimeout(() => {
          if (
            window.fetchCalendarEvents &&
            typeof window.fetchCalendarEvents === "function"
          ) {
            window.fetchCalendarEvents();
          }
        }, 100);
      } catch (err) {
        console.error("Student reset error:", err);
      }
    });
  }
});

(function () {
  const API_EVENTS = "ajax/calendar_admin_get_events.php";

  // ---------------- Week range helpers ----------------

  // Start = Monday of current week
  function getWeekStart(date) {
    const d = new Date(date.getFullYear(), date.getMonth(), date.getDate());
    const day = d.getDay(); // 0 (Sun) - 6 (Sat)
    const diff = (day === 0 ? -6 : 1) - day; // make Monday = 1
    d.setDate(d.getDate() + diff);
    d.setHours(0, 0, 0, 0);
    return d;
  }

  function getWeekEnd(startDate) {
    const d = new Date(startDate.getTime());
    d.setDate(d.getDate() + 6);
    d.setHours(23, 59, 59, 999);
    return d;
  }

  function formatYMD(d) {
    const y = d.getFullYear();
    const m = String(d.getMonth() + 1).padStart(2, "0");
    const day = String(d.getDate()).padStart(2, "0");
    return `${y}-${m}-${day}`;
  }

  let currentStart = getWeekStart(new Date());
  let currentEnd = getWeekEnd(currentStart);

  // ---------------- Selected filter helpers ----------------

  function getSelectedTeacherIds() {
    // Use the exposed state if available - returns ALL selected teachers
    if (window.calendarFilterState) {
      const teachers = window.calendarFilterState.getSelectedTeachers();
      return teachers || [];
    }

    // Fallback: get from teacher options
    const selected = Array.from(
      document.querySelectorAll(
        ".teacher-option.selected, .teacher-option input.teacher-checkbox:checked"
      )
    )
      .map((el) => {
        const li = el.classList.contains("teacher-option")
          ? el
          : el.closest(".teacher-option");
        if (li && li.dataset.teacherId) {
          return parseInt(li.dataset.teacherId, 10);
        }
        return null;
      })
      .filter((id) => id !== null);

    return selected;
  }

  function getSelectedCohortIds() {
    // Use the exposed state if available
    if (window.calendarFilterState) {
      const cohortIds = window.calendarFilterState.getSelectedCohorts();
      return cohortIds || [];
    }

    // Fallback: get from cohort options
    const selected = Array.from(
      document.querySelectorAll(
        ".cohort-option.selected, .cohort-option input.cohort-checkbox:checked"
      )
    )
      .map((el) => {
        const li = el.classList.contains("cohort-option")
          ? el
          : el.closest(".cohort-option");
        if (li && li.dataset.cohortId) {
          return parseInt(li.dataset.cohortId, 10);
        }
        return null;
      })
      .filter((id) => id !== null);

    return selected;
  }

  function getSelectedStudentIds() {
    // Use the exposed state if available - returns ALL selected students
    if (window.calendarFilterState) {
      const students = window.calendarFilterState.getSelectedStudents();
      return students || [];
    }

    // Fallback: get from student options
    const selected = Array.from(
      document.querySelectorAll(
        ".student-option.selected, .student-option input.student-checkbox:checked"
      )
    )
      .map((el) => {
        const li = el.classList.contains("student-option")
          ? el
          : el.closest(".student-option");
        if (li && li.dataset.studentId) {
          return parseInt(li.dataset.studentId, 10);
        }
        return null;
      })
      .filter((id) => id !== null);

    return selected;
  }

  const DAY_NAME_TO_INDEX = {
    monday: 0,
    tuesday: 1,
    wednesday: 2,
    thursday: 3,
    friday: 4,
    saturday: 5,
    sunday: 6,
  };

  function normalizeMinutes(val) {
    if (typeof val === "number" && !Number.isNaN(val)) return val;
    if (typeof val === "string") {
      if (val.includes(":")) {
        const [h, m] = val.split(":").map(Number);
        if (!Number.isNaN(h)) return h * 60 + (Number.isNaN(m) ? 0 : m);
      }
      const parsed = parseInt(val, 10);
      if (!Number.isNaN(parsed)) return parsed;
    }
    return null;
  }

  function getSlotsForTeacher(map, tid) {
    if (!map) return [];
    return map[tid] || map[String(tid)] || map[Number(tid)] || [];
  }

  function updateWhiteSlotRules(
    availabilityMap = {},
    extraSlotMap = {},
    activeTeacherIds = []
  ) {
    whiteSlotRules = [];
    const teachers =
      activeTeacherIds && activeTeacherIds.length > 0
        ? activeTeacherIds
        : Object.keys(availabilityMap);

    if (!teachers || teachers.length === 0) return;

    const baseDate = currentStart || new Date();
    const baseMs = baseDate.getTime();
    const weekEndMs =
      currentEnd && currentEnd.getTime
        ? currentEnd.getTime()
        : baseMs + 6 * 24 * 60 * 60 * 1000;

    teachers.forEach((tid) => {
      //
      // 1) NORMAL WEEKLY AVAILABILITY
      //
      const availSlots = getSlotsForTeacher(availabilityMap, tid);
      availSlots.forEach((slot) => {
        const dayIndex =
          DAY_NAME_TO_INDEX[String(slot.day || "").toLowerCase()];
        if (typeof dayIndex !== "number") return;

        const dayDate = new Date(baseDate);
        dayDate.setDate(baseDate.getDate() + dayIndex);

        const startMin = normalizeMinutes(slot.startTime);
        const endMin = normalizeMinutes(slot.endTime);
        if (startMin === null || endMin === null) return;

        whiteSlotRules.push({
          date: ymd(dayDate),
          dayIndex,
          start: startMin,
          end: endMin,
        });
      });

      //
      // 2) EXTRA SLOTS — FIXED TIMEZONE LOGIC
      //
      const extraSlots = getSlotsForTeacher(extraSlotMap, tid);
      extraSlots.forEach((slot) => {
        // ALWAYS parse ISO strings that contain timezone!!
        const startMs = slot.start ? Date.parse(slot.start) : null;
        const endMs = slot.end ? Date.parse(slot.end) : null;

        // If ISO strings are missing, skip. We DO NOT USE start_ts/end_ts anymore.
        if (!startMs || !endMs) return;
        if (endMs <= startMs) return;
        if (startMs < baseMs || startMs > weekEndMs) return;

        const startDate = new Date(startMs);
        const endDate = new Date(endMs);

        console.log("Processing extra slot:", startDate, endDate);

        // ❗IMPORTANT:
        // Use LOCAL TIME from ISO string — NOT UTC.
        // This keeps '09:30-05:00' exactly as 9:30.
        const startMin = startDate.getHours() * 60 + startDate.getMinutes();

        const endMin = endDate.getHours() * 60 + endDate.getMinutes();

        whiteSlotRules.push({
          date: ymd(startDate),
          dayIndex: (startDate.getDay() + 6) % 7,
          start: startMin,
          end: endMin,
        });
      });
    });
  }

  // ---------------- API call ----------------

  async function fetchCalendarEvents() {
    const teacherids = getSelectedTeacherIds();
    const cohortids = getSelectedCohortIds();
    const studentids = getSelectedStudentIds();

    const params = new URLSearchParams();
    params.set("start", formatYMD(currentStart));
    params.set("end", formatYMD(currentEnd));

    if (teacherids && teacherids.length > 0)
      params.set("teacherids", teacherids.join(","));
    if (cohortids && cohortids.length > 0)
      params.set("cohortids", cohortids.join(","));
    if (studentids && studentids.length > 0)
      params.set("studentids", studentids.join(","));
    try {
      $("#loader").css("display", "flex");
    } catch (e) {
      /* ignore */
    }

    try {
      const response = await fetch(`${API_EVENTS}?${params.toString()}`, {
        credentials: "same-origin",
      });

      if (!response.ok) {
        console.error(
          "calendar_admin_get_events.php HTTP error",
          response.status
        );
        return;
      }

      const data = await response.json();
      console.log("Fetched calendar events:", data);

      if (data.ok) {
        updateWhiteSlotRules(
          data.teacher_availability || {},
          data.teacher_extra_slots || {},
          teacherids
        );
      } else {
        whiteSlotRules = [];
      }

      // Merge regular events, peertalk events, conference events, and teacher time off
      let allEvents = [];
      if (data.ok && Array.isArray(data.events)) {
        allEvents = [...data.events];
      }
      if (data.ok && Array.isArray(data.peertalk)) {
        console.log("Adding peertalk events:", data.peertalk);
        allEvents = [...allEvents, ...data.peertalk];
      }
      if (data.ok && Array.isArray(data.conference)) {
        console.log("Adding conference events:", data.conference);
        allEvents = [...allEvents, ...data.conference];
      }
      if (data.ok && data.teacher_timeoff) {
        Object.entries(data.teacher_timeoff).forEach(([tid, items]) => {
          if (!Array.isArray(items)) return;
          items.forEach((item) => {
            if (!item || !item.start || !item.end) return;
            allEvents.push({
              start: item.start,
              end: item.end,
              title: item.title || "Busy",
              classType: "teacher_timeoff",
              class_type: "teacher_timeoff",
              source: "teacher_timeoff",
              teacherids: [Number(tid) || tid],
              teacherid: item.teacherid || Number(tid) || tid,
              timeoffid: typeof item.id !== "undefined" ? item.id : null,
              style:
                "border-color: rgba(253,216,48,0.7); background-color: rgba(253,216,48,0.05);",
              color: "e-timeoff",
            });
          });
        });
      }

      window.events = [];
      allEvents.forEach((ev) => {
        const startDate = new Date(ev.start);
        const endDate = new Date(ev.end);

        // Match event teacher with selected teachers for proper color assignment
        let teacherId = null;
        if (teacherids && teacherids.length > 0) {
          const eventTeacherIds = Array.isArray(ev.teacherids)
            ? ev.teacherids
            : ev.teacher_id
            ? [ev.teacher_id]
            : ev.teacherid
            ? [ev.teacherid]
            : [];
          teacherId =
            teacherids.find((selectedId) =>
              eventTeacherIds.includes(selectedId)
            ) || eventTeacherIds[0];
        } else if (Array.isArray(ev.teacherids) && ev.teacherids.length > 0) {
          teacherId = ev.teacherids[0];
        } else if (ev.teacher_id) {
          teacherId = ev.teacher_id;
        } else if (ev.teacherid) {
          teacherId = ev.teacherid;
        } else if (ev.teacher) {
          teacherId = ev.teacher;
        }

        let eventColor = "e-blue";
        if (
          ev.class_type === "one2one_weekly" ||
          ev.class_type === "one2one_single"
        ) {
          eventColor = "e-green";
        } else if (ev.class_type === "peertalk" || ev.source === "peertalk") {
          eventColor = "e-purple";
        } else if (
          ev.class_type === "conference" ||
          ev.source === "conference"
        ) {
          eventColor = "e-orange";
        } else if (
          ev.class_type === "teacher_timeoff" ||
          ev.classType === "teacher_timeoff" ||
          ev.source === "teacher_timeoff"
        ) {
          eventColor = "e-timeoff";
        }

        // Main event object
        const eventObj = {
          date: startDate.toISOString().split("T")[0],
          title: ev.title || "",
          start: startDate.toTimeString().slice(0, 5),
          end: endDate.toTimeString().slice(0, 5),
          color: eventColor,
          repeat:
            typeof ev.is_recurring !== "undefined"
              ? ev.is_recurring
              : ev.repeat || false,
          meetingurl: ev.meetingurl || "",
          viewurl: ev.viewurl || ev.meetingurl || "",
          avatar: ev.avatar || "",
          teacherId:
            typeof teacherId !== "undefined" && teacherId !== null
              ? teacherId
              : ev.teacherId ||
                ev.teacher_id ||
                ev.teacherid ||
                ev.teacher ||
                (ev.teacherids && ev.teacherids[0]) ||
                "",
          classType: ev.classType || ev.class_type || "",
          source: ev.source || "event",
          studentnames: ev.studentnames || [],
          studentids: ev.studentids || [],
          cohortids: ev.cohortids || [],
          eventid: ev.eventid || "",
          timeoffid:
            typeof ev.timeoffid !== "undefined"
              ? ev.timeoffid
              : typeof ev.id !== "undefined"
              ? ev.id
              : null,
          cmid: ev.cmid || 0,
          googlemeetid:
            typeof ev.googlemeetid !== "undefined" ? ev.googlemeetid : 0,
          courseid: typeof ev.courseid !== "undefined" ? ev.courseid : 0,
          is_parent: typeof ev.is_parent !== "undefined" ? ev.is_parent : false,
          main_event_id:
            typeof ev.main_event_id !== "undefined" ? ev.main_event_id : "",
          sequence: typeof ev.sequence !== "undefined" ? ev.sequence : 1,
          teachernames: ev.teachernames || [],
          statuses: ev.statuses || [],
          rescheduled:
            typeof ev.rescheduled !== "undefined" ? ev.rescheduled : null,
          faded: false,
        };
        window.events.push(eventObj);

        // If event is reschedule_instant, add previous event as faded
        if (
          Array.isArray(ev.statuses) &&
          ev.statuses.some((s) => s.code === "reschedule_instant" && s.previous)
        ) {
          // Find the status with previous
          const statusObj = ev.statuses.find(
            (s) => s.code === "reschedule_instant" && (s.previous || null)
          );
          if (statusObj && statusObj.previous) {
            // Parse previous event date and times
            const prevDate = statusObj.previous.date;
            const prevStart = statusObj.previous.start;
            const prevEnd = statusObj.previous.end;
            // Use previous teacher/avatar if available
            window.events.push({
              ...eventObj,
              date: prevDate,
              start: prevStart,
              end: prevEnd,
              faded: true,
              title: eventObj.title
                ? eventObj.title + " (Previous)"
                : "Previous Event",
              teacherId: statusObj.previous.teacher || eventObj.teacherId,
              avatar: ev.previous_teacher_picture || eventObj.avatar,
              teachernames: [ev.previous_teachername || ""],
            });
          }
        }
      });

      // Re-render your week view
      if (typeof renderWeek === "function") {
        renderWeek(false);
      }
    } catch (err) {
      console.error("Failed to load calendar events:", err);
    } finally {
      try {
        $("#loader").css("display", "none");
      } catch (e) {
        /* ignore */
      }
    }
  }

  // Unified helper to reload dropdown data + calendar after mutations
  async function refetchCustomPluginData(reason = "") {
    try {
      console.log(`Refetching calendar data${reason ? ` (${reason})` : ""}`);

      // Some pages may not have all helpers loaded; guard each call.
      const loadTeachersFn =
        typeof loadTeachers === "function"
          ? loadTeachers
          : () => Promise.resolve();
      const loadCohortsFn =
        typeof loadCohortsForTeachers === "function"
          ? loadCohortsForTeachers
          : typeof loadAllCohorts === "function"
          ? loadAllCohorts
          : () => Promise.resolve();
      const loadStudentsForCohortsFn =
        typeof loadStudentsForCohorts === "function"
          ? loadStudentsForCohorts
          : typeof loadAllStudents === "function"
          ? loadAllStudents
          : () => Promise.resolve();

      const safeSelectedTeachers =
        typeof selectedTeacherIds !== "undefined" &&
        Array.isArray(selectedTeacherIds)
          ? selectedTeacherIds
          : [];
      const safeSelectedCohorts =
        typeof selectedCohortIds !== "undefined" &&
        Array.isArray(selectedCohortIds)
          ? selectedCohortIds
          : [];

      await Promise.allSettled([
        loadTeachersFn(),
        safeSelectedTeachers.length
          ? loadCohortsFn(safeSelectedTeachers, false)
          : loadCohortsFn(),
        safeSelectedCohorts.length
          ? loadStudentsForCohortsFn(safeSelectedCohorts, false)
          : loadStudentsForCohortsFn(),
      ]);

      if (typeof fetchCalendarEvents === "function") {
        await fetchCalendarEvents();
      } else if (typeof triggerCalendarReload === "function") {
        triggerCalendarReload();
      }
    } catch (err) {
      console.error("refetchCustomPluginData failed", err);
    }
  }

  window.refetchCustomPluginData = refetchCustomPluginData;

  // Expose globally so it can be called from filter changes
  window.fetchCalendarEvents = fetchCalendarEvents;

  // Auto-refresh calendar after successful customplugin POSTs (except the fetch itself)
  (function () {
    let refreshTimer = null;
    const debounceRefresh = (reason) => {
      clearTimeout(refreshTimer);
      refreshTimer = setTimeout(() => {
        if (typeof refetchCustomPluginData === "function") {
          refetchCustomPluginData(reason);
        } else if (typeof fetchCalendarEvents === "function") {
          fetchCalendarEvents();
        }
      }, 250);
    };

    // Handle jQuery AJAX POST requests
    $(document).ajaxSuccess(function (_e, _xhr, settings) {
      if (
        !settings ||
        !settings.url ||
        typeof settings.type === "undefined" ||
        String(settings.type).toUpperCase() !== "POST"
      ) {
        return;
      }
      const url = String(settings.url);
      if (!url.includes("/local/customplugin/ajax/")) return;
      // Skip calendar fetch endpoints to avoid loops
      if (
        url.includes("calendar_admin_get_events") ||
        url.includes("calendar_admin_filters")
      )
        return;
      debounceRefresh("ajax-success");
    });

    // Intercept fetch API to auto-refresh on POST/PUT/PATCH
    const originalFetch = window.fetch;
    window.fetch = function (...args) {
      const request = args[0];
      const options = args[1] || {};

      // Get URL from request or args
      const url = typeof request === "string" ? request : request.url || "";
      const method = (options.method || "GET").toUpperCase();

      // Only intercept POST/PUT/PATCH to customplugin endpoints
      if (
        (method === "POST" || method === "PUT" || method === "PATCH") &&
        url.includes("/local/customplugin/ajax/")
      ) {
        // Skip calendar fetch endpoints to avoid loops
        if (
          url.includes("calendar_admin_get_events") ||
          url.includes("calendar_admin_filters") ||
          url.includes("get_cohort_details") ||
          url.includes("get_teacher_availability")
        ) {
          return originalFetch.apply(this, args);
        }

        // Call original fetch and auto-refresh on success
        return originalFetch.apply(this, args).then((response) => {
          // Clone response so we can read it
          const clonedResponse = response.clone();

          // Check if response is successful
          if (response.ok) {
            // Try to parse as JSON to verify success
            clonedResponse
              .json()
              .then((data) => {
                // Check various success indicators
                if (
                  data &&
                  (data.ok === true ||
                    data.success === true ||
                    data.status === "success" ||
                    data.error === false ||
                    data.error === null ||
                    data.error === undefined)
                ) {
                  debounceRefresh("fetch-success");
                }
              })
              .catch(() => {
                // If JSON parse fails, still refresh for successful responses
                debounceRefresh("fetch-success");
              });
          }

          return response;
        });
      }

      // For non-POST/PUT/PATCH or non-customplugin URLs, use original fetch
      return originalFetch.apply(this, args);
    };
  })();

  // ---------------- Wire week navigation ----------------

  function shiftWeek(deltaWeeks) {
    const d = new Date(currentStart.getTime());
    d.setDate(d.getDate() + deltaWeeks * 7);
    currentStart = getWeekStart(d);
    currentEnd = getWeekEnd(currentStart);
    fetchCalendarEvents();
  }

  document.getElementById("prev-week")?.addEventListener("click", function () {
    shiftWeek(-1);
  });

  document.getElementById("next-week")?.addEventListener("click", function () {
    shiftWeek(1);
  });
})();
