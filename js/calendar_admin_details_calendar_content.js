/* ====== CONFIG ====== */

const START_H = 0,
  END_H = 24, // Changed to 24 to include the 11:30 PM to 12:00 AM slot
  SLOT_MIN = 30;
const SLOT_H =
  parseInt(
    getComputedStyle(document.documentElement).getPropertyValue("--slot-h"),
  ) || 36;
const PX_PER_MIN = SLOT_H / SLOT_MIN;
const STACK_OFFSET = 18,
  STACK_CAP = 3;
const REVEAL_FRONT =
  parseInt(
    getComputedStyle(document.documentElement).getPropertyValue(
      "--reveal-front",
    ),
  ) || 12;
const REVEAL_MID =
  parseInt(
    getComputedStyle(document.documentElement).getPropertyValue("--reveal-mid"),
  ) || 8;

let role = localStorage.getItem("role");
let teacherId = localStorage.getItem("teacherId");

// Helper function to get teacher color index based on teacher ID
function getTeacherColorIndex(tid) {
  if (
    window.TeacherUtils &&
    typeof window.TeacherUtils.getColorIndex === "function"
  ) {
    return window.TeacherUtils.getColorIndex(tid);
  }
  if (!tid) return 1;
  const n = parseInt(tid, 10);
  if (!n || Number.isNaN(n)) return 1;
  const mod = Math.abs(n) % 10;
  return mod === 0 ? 10 : mod;
}

// Helper function to generate unique vibrant color for any teacher ID
function getTeacherColor(tid) {
  if (
    window.TeacherUtils &&
    typeof window.TeacherUtils.getColor === "function"
  ) {
    return window.TeacherUtils.getColor(tid);
  }
  if (!tid) return "#FF1744";
  const n = parseInt(tid, 10);
  if (!n || Number.isNaN(n)) return "#FF1744";
  const hue = Math.round((Math.abs(n) * 137.508) % 360);
  const saturation = 100;
  const lightness = 50;
  return `hsl(${hue}, ${saturation}%, ${lightness}%)`;
}

const DOW = ["Mon", "Tue", "Wed", "Thu", "Fri", "Sat", "Sun"];

// White slot windows derived from teacher availability payloads
let whiteSlotRules = [];
window.teacherExtraSlots = window.teacherExtraSlots || {};

// Status icon map and getActiveStatusMeta are now in js/event_icon_utils.js
// Using: EventIconUtils.getActiveStatusMeta() and EventIconUtils.STATUS_ICON_MAP from event_icon_utils.js
// Keep local reference for backward compatibility
const STATUS_ICON_MAP = window.EventIconUtils
  ? window.EventIconUtils.STATUS_ICON_MAP
  : {};

function getActiveStatusMeta(statuses) {
  if (window.EventIconUtils && window.EventIconUtils.getActiveStatusMeta) {
    return window.EventIconUtils.getActiveStatusMeta(statuses);
  }
  // Fallback implementation (simplified)
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

// Helper function to get history icon based on history type
function getHistoryIcon(historyItem) {
  if (
    window.HistoryUtils &&
    typeof window.HistoryUtils.getIcon === "function"
  ) {
    return window.HistoryUtils.getIcon(historyItem);
  }
  // Fallback minimal icon if utils not loaded
  return { icon: "./img/ev-repeat.svg", label: "Updated" };
}

// Helper function to format history item description
function formatHistoryDescription(historyItem) {
  if (
    window.HistoryUtils &&
    typeof window.HistoryUtils.formatDescription === "function"
  ) {
    return window.HistoryUtils.formatDescription(historyItem);
  }
  return "";
}

window.events = [];
// Time utility functions (pad2, fmt12, minutes) are now in js/time_utils.js
// Date utility functions (ymd, formatYMD, mondayOf, timestampToDate) are now in js/date_utils.js
// Ensure time_utils.js and date_utils.js are loaded before this file
// Using: pad2(), fmt12(), and minutes() from time_utils.js
// Using: ymd(), formatYMD(), mondayOf(), timestampToDate() from date_utils.js
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
    if (minuteOfDay >= s && minuteOfDay < e)
      return rule.source || "availability";
  }
  return null;
}

// Toggle whether to draw white-slot background layer (availability/extra slots)
// Will be determined dynamically based on teacher selection
let SHOW_WHITE_SLOTS = false;

// Helper function to format time to 12h with AM/PM
// Returns an object with {time, period} or a string based on returnString parameter
function formatTime12h(time24, returnString = false) {
  let timeStr = String(time24).trim();
  let hours, minutes;

  // Check if already in 12-hour format (contains AM/PM)
  if (timeStr.match(/\s*(am|pm)\s*$/i)) {
    // Already 12-hour format, extract hours and period
    const match = timeStr.match(/^(\d+):?(\d{2})\s*(am|pm)$/i);
    if (match) {
      hours = parseInt(match[1], 10);
      minutes = parseInt(match[2], 10);
      const inputPeriod = match[3].toUpperCase();
      // Convert to 24-hour internally, then back
      if (inputPeriod === "PM" && hours !== 12) {
        hours = hours + 12;
      } else if (inputPeriod === "AM" && hours === 12) {
        hours = 0;
      }
    } else {
      // Can't parse, return as-is
      return returnString ? timeStr : { time: timeStr, period: "AM" };
    }
  } else {
    // 24-hour format
    const parts = timeStr.split(":").map(Number);
    hours = parts[0];
    minutes = parts[1] || 0;
  }

  const period = hours >= 12 ? "PM" : "AM";
  const hours12 = hours % 12 || 12;
  const formattedTime = `${String(hours12).padStart(2, "0")}:${String(minutes).padStart(2, "0")}`;
  
  if (returnString) {
    return `${formattedTime} ${period}`;
  }
  return { time: formattedTime, period: period };
}

/* ====== STATE ====== */
let currentWeekStart = window.mondayOf(new Date());

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

    // Auto-select teacher from sessionStorage in create cohort (teacher1DropdownList)
    const savedTeacherId = sessionStorage.getItem("selectedTeacherId");
    if (savedTeacherId) {
      setTimeout(() => {
        const teacherIdInt = parseInt(savedTeacherId, 10);
        const $teacherItem = $("#teacher1DropdownList").find(
          `.teacher-option[data-userid="${teacherIdInt}"]`,
        );
        if ($teacherItem.length) {
          console.log("Auto-selecting teacher in create cohort:", teacherIdInt);
          $teacherItem.trigger("click");
        }
      }, 300);
    }
  }

  // Helper function to auto-select teacher in various tabs based on their dropdown structure
  function autoSelectTeacherInTab(tabId) {
    const savedTeacherId = sessionStorage.getItem("selectedTeacherId");
    if (!savedTeacherId) return;

    setTimeout(() => {
      const teacherIdInt = parseInt(savedTeacherId, 10);

      // Different selectors for different tabs
      let $teacherItem;

      if (tabId === "classTabContent") {
        // 1:1 Class tab uses calendar_admin_details_create_cohort_class_tab_item
        $teacherItem = $(`#${tabId}`).find(
          `.calendar_admin_details_create_cohort_class_tab_item[data-userid="${teacherIdInt}"]`,
        );
      } else if (tabId === "manageclassTabContent") {
        // Manage Class tab uses calendar_admin_details_create_cohort_manage_class_tab_item
        $teacherItem = $(`#${tabId}`).find(
          `.calendar_admin_details_create_cohort_manage_class_tab_item[data-userid="${teacherIdInt}"]`,
        );
      } else if (
        tabId === "addTimeTabContent" ||
        tabId === "addExtraSlotsTabContent"
      ) {
        // Add time tabs use addtime-teacher-item
        $teacherItem = $(`#${tabId}`).find(
          `.addtime-teacher-item[data-userid="${teacherIdInt}"]`,
        );
      }

      if ($teacherItem && $teacherItem.length) {
        console.log(`Auto-selecting teacher in ${tabId}:`, teacherIdInt);
        $teacherItem.trigger("click");
      }
    }, 300);
  }

  // Monitor tab clicks and auto-select teacher when tabs open
  $(document).on(
    "click",
    ".calendar_admin_details_create_cohort_tab",
    function () {
      const tabName = $(this).data("tab");
      if (tabName === "addtime") {
        autoSelectTeacherInTab("addTimeTabContent");
      } else if (tabName === "extraslots") {
        autoSelectTeacherInTab("addExtraSlotsTabContent");
      } else if (tabName === "manage_class") {
        autoSelectTeacherInTab("manageclassTabContent");
      } else if (tabName === "class") {
        autoSelectTeacherInTab("classTabContent");
      }
    },
  );

  // Check if coming back from setup availability page and auto-select teacher
  $(document).ready(function () {
    const autoSelectTeacherId = sessionStorage.getItem("autoSelectTeacher");
    if (autoSelectTeacherId) {
      sessionStorage.removeItem("autoSelectTeacher");
      // Trigger auto-select for the teacher dropdown
      const $teacherOption = $(
        `#teacher1DropdownList li.teacher-option[data-userid="${autoSelectTeacherId}"]`,
      );
      if ($teacherOption.length) {
        setTimeout(() => {
          $teacherOption.trigger("click");
        }, 500);
      }
    }
  });

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
        `Found ${recurrenceEvents.length} peertalk events with eventid ${eventData.eventid}`,
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

    // Store event ID in form for update purposes
    const $form = $("#peerTalkForm");
    const $parent = $("#peerTalkTabContent");
    if (eventData.eventid) {
      $form.data("eventId", eventData.eventid);
      $parent.find(".peertalk_modal_btn").text("Update Peer Talk");
    } else {
      $form.removeData("eventId");
      $parent.find(".peertalk_modal_btn").text("Schedule Peer Talk");
    }

    // Populate the peertalk form with event data and recurrence info
    populatePeerTalkForm(eventData, recurrenceEvents);
    setTimeout(() => {
      scrollToActiveCohortTab();
    }, 100);
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
            `#peertalkCohortsList li.peertalk_cohort_item[data-id="${cohortId}"]`,
          );
          if ($cohortItem.length > 0) {
            console.log(
              "Clicking cohort:",
              cohortId,
              $cohortItem.text().trim(),
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
          `#peertalkTeachersList li.peertalk_teacher_item[data-userid="${eventData.teacherId}"]`,
        );
        if ($teacherItem.length > 0) {
          console.log(
            "Clicking teacher:",
            eventData.teacherId,
            $teacherItem.find(".teacher_name").text().trim(),
          );
          $teacherItem.trigger("click");
        }
      }, 150);
    }

    // Populate time if available
    if (eventData.start && eventData.end) {
      // Convert minutes to time format
      // minutesToTime() is now in js/time_utils.js
      // Using: minutesToTime() from time_utils.js

      console.log(
        "Event times - Start:",
        eventData.start,
        "End:",
        eventData.end,
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
        endMins,
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
        // minutesToTime() is now in js/time_utils.js
        // Using: minutesToTime() from time_utils.js

        // Helper to convert timestamp to HH:MM format
        const timestampToTime = (ts) => {
          if (!ts) return "00:00";
          const date = new Date(ts * 1000); // Convert seconds to milliseconds
          return `${String(date.getHours()).padStart(2, "0")}:${String(date.getMinutes()).padStart(2, "0")}`;
        };

        // Get date from timestamp or existing date
        // Using timestampToDate() from date_utils.js
        const eventDate = ev.start_ts
          ? window.timestampToDate(ev.start_ts)
          : ev.date;

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
          }`,
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
          const startTime12 = formatTime12h(item.start_time, true);
          const endTime12 = formatTime12h(item.end_time, true);
          return `${shortDay}(<span class="time-range">${startTime12} - ${endTime12}</span>)`;
        });

        const repeatText = "Weekly on " + dayTimeParts.join(", ");

        // Update button HTML while preserving the arrow
        $repeatBtn.html(
          repeatText + '<span style="float:right; font-size:1rem;">▼</span>',
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
        window.peerTalkRecurrenceData,
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
            '<div class="scroll-widget__time has-time"></div>',
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
      `Populated custom recurrence modal with ${recurrenceArray.length} occurrences`,
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
        `Found ${recurrenceEvents.length} conference events with eventid ${eventData.eventid}`,
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

    // Store event ID in form for update purposes
    const $form = $("#conferenceForm");
    const $parent = $("#conferenceTabContent");
    if (eventData.eventid) {
      $form.data("eventId", eventData.eventid);
      $parent.find(".conference_modal_btn").text("Update Conference");
    } else {
      $form.removeData("eventId");
      $parent.find(".conference_modal_btn").text("Schedule Conference");
    }

    // Populate the conference form with event data and recurrence info
    populateConferenceForm(eventData, recurrenceEvents);
    setTimeout(() => {
      scrollToActiveCohortTab();
    }, 100);
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
              `#conferenceCohortsList li.conference_cohort_item[data-id="${cohortId}"]`,
            );
            if ($cohortItem.length > 0) {
              console.log(
                "Clicking conference cohort:",
                cohortId,
                $cohortItem.text().trim(),
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
              `#conferenceStudentsList li.conference_student_item[data-userid="${studentId}"]`,
            );
            if ($studentItem.length > 0) {
              console.log(
                "Clicking conference student:",
                studentId,
                $studentItem.text().trim(),
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
          `#conferenceTeachersList li.conference_teacher_item[data-id="${eventData.teacherId}"]`,
        );
        const $teacherItem2 = $(
          `#conferenceTeachersList2 li.conference_teacher_item[data-id="${eventData.teacherId}"]`,
        );

        if ($teacherItem1.length > 0) {
          console.log(
            "Clicking conference teacher (view 1):",
            eventData.teacherId,
            $teacherItem1.text().trim(),
          );
          $teacherItem1.trigger("click");
        } else if ($teacherItem2.length > 0) {
          console.log(
            "Clicking conference teacher (view 2):",
            eventData.teacherId,
            $teacherItem2.text().trim(),
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
        endMins,
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
        "#eventTimezoneDropdown_conference_tab_selected",
      );
      if ($timezoneSelected.length > 0) {
        $timezoneSelected.text(eventData.timezone);
        console.log("Set conference timezone to:", eventData.timezone);
      }
    }

    // Build custom recurrence array from events with same eventid
    if (recurrenceEvents && recurrenceEvents.length > 0) {
      const customRecurrenceArray = recurrenceEvents.map(function (ev) {
        console.log("Processing recurrence event:", ev);

        // Convert minutes (from midnight) to HH:MM format
        // minutesToTime() is now in js/time_utils.js
        // Using: minutesToTime() from time_utils.js

        return {
          date: ev.date,
          start: ev.start,
          end: ev.end,
          startTime: minutesToTime(ev.start),
          endTime: minutesToTime(ev.end),
          day: ev.day || "",
        };
      });

      console.log(
        "Custom recurrence array for conference:",
        customRecurrenceArray,
      );
      // Store for later use if needed
      window.conferenceRecurrenceData = customRecurrenceArray;
    }
  }

  // Expose function globally for testing
  window.openConferenceModalWithData = openConferenceModalWithData;

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
      // Ignore clicks on availability and extra slot events
      const $clicked = $(this);
      const clickedClassType = $clicked.data("class-type");
      const clickedSource = $clicked.data("source");

      if (
        clickedClassType === "availability" ||
        clickedSource === "availability" ||
        clickedClassType === "extra_slot"
      ) {
        return; // Do nothing for availability/extra slot events
      }

      // Allow dragging for draggable events - don't prevent default on mousedown
      // The dragstart event will handle dragging, clicks are handled separately
      if ($clicked.hasClass("draggable-event")) {
        // Don't prevent default - allow native drag to work
        return;
      }

      e.preventDefault();
      e.stopPropagation();

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
          currentClickedEvent,
        );

        // Mark teacher-changed reschedules (use the clicked event context)
        const statusWithDetails = Array.isArray(currentClickedEvent.statuses)
          ? currentClickedEvent.statuses.find(
              (s) => s.details && (s.details.current || s.details.previous),
            )
          : null;

        const summaryCurrent =
          currentClickedEvent.summary?.current ||
          statusWithDetails?.details?.current;
        const summaryPrevious =
          currentClickedEvent.summary?.previous ||
          statusWithDetails?.details?.previous;

        const prevTeacherId =
          summaryPrevious?.teacher?.id || summaryPrevious?.teacher;
        const currTeacherId =
          summaryCurrent?.teacher?.id || summaryCurrent?.teacher;

        const teacherChanged =
          prevTeacherId && currTeacherId && prevTeacherId !== currTeacherId;

        // Check if time changed by comparing previous and current date/start/end
        const timeChanged =
          summaryPrevious &&
          summaryCurrent &&
          (summaryPrevious.date !== summaryCurrent.date ||
            summaryPrevious.start !== summaryCurrent.start ||
            summaryPrevious.end !== summaryCurrent.end ||
            summaryPrevious.start_ts !== summaryCurrent.start_ts ||
            summaryPrevious.end_ts !== summaryCurrent.end_ts);

        if (teacherChanged) {
          currentClickedEvent.isTeacherChanged = true;

          // Get teacher pics
          let currentPic =
            summaryCurrent?.teacher?.avatar ||
            summaryCurrent?.teacher_pic ||
            null;
          let previousPic =
            summaryPrevious?.teacher?.avatar ||
            summaryPrevious?.teacher_pic ||
            null;

          if (currentClickedEvent.summary?.current && currentPic) {
            if (!currentClickedEvent.summary.current.teacher) {
              currentClickedEvent.summary.current.teacher = {};
            }
            currentClickedEvent.summary.current.teacher.avatar = currentPic;
            currentClickedEvent.summary.current.teacher_pic = currentPic;
          }
          if (currentClickedEvent.summary?.previous && previousPic) {
            if (!currentClickedEvent.summary.previous.teacher) {
              currentClickedEvent.summary.previous.teacher = {};
            }
            currentClickedEvent.summary.previous.teacher.avatar = previousPic;
            currentClickedEvent.summary.previous.teacher_pic = previousPic;
          }
        }
        // Teacher time off: open Time Off modal
        if (classType === "teacher_timeoff" || source === "teacher_timeoff") {
          if (typeof window.openTimeOffModal === "function") {
            window.openTimeOffModal(currentClickedEvent);
          }
          return;
        }

        // Check if event is cancelled (cancel or cancel_no_makeup) - show reason modal
        const activeStatus = getActiveStatusMeta(
          currentClickedEvent.statuses || [],
        );
        console.log(
          "Active status for clicked event:",
          activeStatus,
          "Statuses:",
          currentClickedEvent.statuses,
        );

        if (
          activeStatus &&
          (activeStatus.code === "cancel" ||
            activeStatus.code === "cancel_no_makeup")
        ) {
          console.log(
            "Opening Reason of Cancellation modal for cancelled event",
            currentClickedEvent,
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
            currentClickedEvent,
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
        // If it's a 1:1 lesson, do nothing - the .event.e-green handler in lesson_information.php will handle it
      }
    });

  // Function to open menu options dropdown
  function openMenuOptionsDropdown(event, eventElement) {
    const dropdown = document.getElementById("menu-options");
    const menuContainer = dropdown.querySelector(".menu-container");
    if (!dropdown || !menuContainer) return;

    const activeStatus = getActiveStatusMeta(
      (currentClickedEvent && currentClickedEvent.statuses) || [],
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
      ".cancel-reschedule-later-panel",
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

  // Expose function globally for agenda tab
  window.openMenuOptionsDropdown = openMenuOptionsDropdown;

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

    // Populate teacher if available - check eventData or sessionStorage
    const savedTeacherId = sessionStorage.getItem("selectedTeacherId");
    const teacherIdToSelect =
      eventData.teacherId ||
      (savedTeacherId ? parseInt(savedTeacherId, 10) : null);

    if (teacherIdToSelect) {
      console.log("Event/Saved teacher ID:", teacherIdToSelect);
      // Wait for modal to fully load, then select teacher from first teacher dropdown
      setTimeout(() => {
        const $teacherItem = $("#teacher1DropdownList").find(
          `.teacher-option[data-userid="${teacherIdToSelect}"]`,
        );
        if ($teacherItem.length) {
          console.log("Found teacher in dropdown:", $teacherItem.text().trim());
          // Trigger click to select the teacher
          $teacherItem.trigger("click");
        } else {
          console.warn(
            "Teacher not found in teacher1DropdownList:",
            teacherIdToSelect,
          );
        }
      }, 200);
    }

    // Populate date and time if available
    if (eventData.date) {
      console.log("Event date:", eventData.date);
      console.log(
        "Event time:",
        fmt12(eventData.start),
        "-",
        fmt12(eventData.end),
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
        '<li style="pointer-events:none;opacity:.6;">No cohorts found</li>',
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
        '<li style="pointer-events:none;opacity:.6;">No teachers found</li>',
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
        '<li style="pointer-events:none;opacity:.6;">No students available</li>',
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
      ")",
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

    // Generate standardized times from 12:00 AM to 11:30 PM with 30-minute intervals
    for (let h = 0; h < 24; h++) {
      for (let m = 0; m < 60; m += 30) {
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

    // Generate standardized times from 12:00 AM to 11:30 PM with 30-minute intervals
    for (let h = 0; h < 24; h++) {
      for (let m = 0; m < 60; m += 30) {
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
          parseInt(parts[2]),
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

    // Helper to parse 'h:mm AM/PM' to minutes
    function parse12HourTime(str) {
      const match = str.match(/^(\d{1,2}):(\d{2})\s*([AP]M)$/i);
      if (!match) return null;
      let h = parseInt(match[1], 10);
      const m = parseInt(match[2], 10);
      const ap = match[3].toUpperCase();
      if (ap === "PM" && h !== 12) h += 12;
      if (ap === "AM" && h === 12) h = 0;
      return h * 60 + m;
    }

    // Get selected start time: if not found in list, fallback to button text
    let selectedStartTime = $("#session-start-list li")
      .filter(function () {
        return $(this).text().trim() === $("#session-start-btn").text().trim();
      })
      .data("time-value");
    if (typeof selectedStartTime === "undefined") {
      const btnText = $("#session-start-btn").text().trim();
      selectedStartTime = parse12HourTime(btnText);
    }

    // Get selected end time: if not found in list, fallback to button text
    let selectedEndTime = $("#session-end-list li")
      .filter(function () {
        return $(this).text().trim() === $("#session-end-btn").text().trim();
      })
      .data("time-value");
    if (typeof selectedEndTime === "undefined") {
      const btnText = $("#session-end-btn").text().trim();
      selectedEndTime = parse12HourTime(btnText);
    }

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
    const newStartFormatted = formatTime(selectedStartTime);
    const newEndFormatted = formatTime(selectedEndTime);
    const oldStartFormatted = formatTime(oldStart);
    const oldEndFormatted = formatTime(oldEnd);

    // Check if any changes were made
    const changesDetected =
      oldTeacherId !== selectedTeacherId ||
      oldDate !== selectedDate ||
      oldStartFormatted !== newStartFormatted ||
      oldEndFormatted !== newEndFormatted;

    // Only send if changes were detected
    if (!changesDetected) {
      console.warn("No changes detected in session update");
      if (window.showToast) {
        window.showToast("No changes detected", "info");
      }
      return;
    }

    const payload = {
      eventid: eventId,
      googlemeetid: googleMeetId,
      oldTeacherId: oldTeacherId,
      newTeacherId: selectedTeacherId,
      oldDate: oldDate,
      newDate: selectedDate,
      oldStart: oldStartFormatted,
      oldEnd: oldEndFormatted,
      newStart: newStartFormatted,
      newEnd: newEndFormatted,
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
      success: async function (response) {
        console.log("Reschedule Response:", response);
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
        // Keep loader visible during calendar refresh
        // refetchCustomPluginData will manage showing/hiding the loader
        try {
          if (window.refetchCustomPluginData) {
            await window.refetchCustomPluginData("reschedule");
          } else if (window.fetchCalendarEvents) {
            await window.fetchCalendarEvents();
          }
        } catch (fetchError) {
          console.error("Error refreshing calendar:", fetchError);
          // Hide loader on error
          if (window.hideGlobalLoader) window.hideGlobalLoader();
        }
        // Note: Loader will be hidden by refetchCustomPluginData or fetchCalendarEvents in their finally blocks
        $("#manage-session-modal").fadeOut(300);
        $(".custom-dropdown .dropdown-list").hide();
      },
      error: function (xhr) {
        if (window.hideGlobalLoader) window.hideGlobalLoader();
        if (window.showToast) {
          window.showToast(
            "Something went wrong while updating session.",
            "error",
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

  // ============================================================
  // DRAG AND DROP FUNCTIONALITY
  // ============================================================

  let draggedEvent = null;
  let dragStartY = 0;
  let originalEventStart = 0;
  let originalEventEnd = 0;
  let originalEventDuration = 0;

  // Helper function to calculate time from Y position in day column
  function calculateTimeFromY(y, dayInner) {
    const dayInnerTop = dayInner.getBoundingClientRect().top;
    const relativeY = y - dayInnerTop;
    const minutesFromStart = Math.round(relativeY / PX_PER_MIN);
    const newStartMinutes = START_H * 60 + minutesFromStart;
    // Round to nearest 30-minute slot
    const roundedMinutes = Math.round(newStartMinutes / SLOT_MIN) * SLOT_MIN;
    return Math.max(
      START_H * 60,
      Math.min(END_H * 60 - SLOT_MIN, roundedMinutes),
    );
  }

  // Drag start handler
  $(document)
    .off("dragstart", ".draggable-event")
    .on("dragstart", ".draggable-event", function (e) {
      const $event = $(this);
      draggedEvent = $event;
      dragStartY = e.originalEvent.clientY;
      dragOccurred = false; // Reset flag at start of drag

      // Store original event data
      originalEventStart = parseInt($event.data("start"));
      originalEventEnd = parseInt($event.data("end"));
      originalEventDuration = originalEventEnd - originalEventStart;

      // Add visual feedback
      $event.addClass("dragging");

      // Set drag data
      e.originalEvent.dataTransfer.effectAllowed = "move";
      e.originalEvent.dataTransfer.setData("text/html", this.outerHTML);

      // Prevent default drag image
      const dragImage = document.createElement("div");
      dragImage.style.position = "absolute";
      dragImage.style.top = "-1000px";
      dragImage.innerHTML = this.outerHTML;
      document.body.appendChild(dragImage);
      e.originalEvent.dataTransfer.setDragImage(dragImage, 0, 0);
      setTimeout(() => document.body.removeChild(dragImage), 0);
    });

  // Track if a drag occurred to prevent click handling
  let dragOccurred = false;

  // Drag end handler
  $(document)
    .off("dragend", ".draggable-event")
    .on("dragend", ".draggable-event", function (e) {
      const $event = $(this);
      $event.removeClass("dragging");
      $(".day-inner").removeClass("drag-over");
      dragOccurred = true;
      draggedEvent = null;

      // Reset flag after a short delay to allow click handler to check it
      setTimeout(() => {
        dragOccurred = false;
      }, 100);
    });

  // Drag over handler for day columns
  $(document)
    .off("dragover", ".day-inner")
    .on("dragover", ".day-inner", function (e) {
      if (!draggedEvent) return;
      e.preventDefault();
      e.originalEvent.dataTransfer.dropEffect = "move";
      $(this).addClass("drag-over");
    });

  // Drag leave handler
  $(document)
    .off("dragleave", ".day-inner")
    .on("dragleave", ".day-inner", function (e) {
      // Only remove class if we're actually leaving the element
      if (
        !$(this).is(e.relatedTarget) &&
        !$(this).has(e.relatedTarget).length
      ) {
        $(this).removeClass("drag-over");
      }
    });

  // Drop handler
  $(document)
    .off("drop", ".day-inner")
    .on("drop", ".day-inner", function (e) {
      e.preventDefault();
      e.stopPropagation();

      if (!draggedEvent) return;

      const $dayInner = $(this);
      const $event = draggedEvent;

      // Get drop position
      const dropY = e.originalEvent.clientY;
      const newStartMinutes = calculateTimeFromY(dropY, this);
      const newEndMinutes = newStartMinutes + originalEventDuration;

      // Get event data
      const eventId = $event.data("event-id");
      const googlemeetId = $event.data("googlemeet-id") || $event.data("cm-id");
      const classType = $event.data("class-type");
      const source = $event.data("source");
      const teacherId = $event.data("teacher-id");
      const newDate = $dayInner.data("date");
      // Try both data-date and data-event-date attributes for old date
      const oldDate = $event.data("event-date") || $event.data("date");

      // Validate required data
      if (!eventId) {
        if (window.showToast) {
          window.showToast("Cannot drag this event: missing event ID", "error");
        }
        return;
      }

      // Don't allow drop if date/time hasn't changed
      const oldStartMinutes = originalEventStart;
      if (newDate === oldDate && newStartMinutes === oldStartMinutes) {
        $dayInner.removeClass("drag-over");
        return;
      }

      // Format times for API (HH:MM format)
      const newStartTime = minutesToHHMM(newStartMinutes);
      const newEndTime = minutesToHHMM(newEndMinutes);
      const oldStartTime = minutesToHHMM(oldStartMinutes);
      const oldEndTime = minutesToHHMM(originalEventEnd);

      // Determine which API endpoint to use
      const isOne2One =
        classType === "one2one_weekly" ||
        classType === "one2one_single" ||
        source === "one2one";

      // Show loader
      if (window.showGlobalLoader) window.showGlobalLoader();

      // Prepare payload based on event type
      let apiUrl, payload;

      if (isOne2One) {
        // Use update_one_on_one.php endpoint
        apiUrl =
          M.cfg.wwwroot + "/local/customplugin/ajax/update_one_on_one.php";

        // Get student ID from event data
        const studentIds = $event.data("student-ids");
        const studentId = studentIds
          ? typeof studentIds === "string"
            ? parseInt(studentIds.split(",")[0])
            : parseInt(studentIds[0])
          : null;

        if (!studentId || !teacherId) {
          if (window.hideGlobalLoader) window.hideGlobalLoader();
          if (window.showToast) {
            window.showToast(
              "Cannot drag this event: missing student or teacher ID",
              "error",
            );
          }
          return;
        }

        // Normalize dates to YYYY-MM-DD format (remove time component if present)
        let normalizedOldDate = oldDate;
        let normalizedNewDate = newDate;
        if (normalizedOldDate && normalizedOldDate.includes("T")) {
          normalizedOldDate = normalizedOldDate.split("T")[0];
        }
        if (normalizedNewDate && normalizedNewDate.includes("T")) {
          normalizedNewDate = normalizedNewDate.split("T")[0];
        }

        // Build payload via centralized 1:1 API helper (fallback to inline if missing)
        if (
          window.One2OneApi &&
          typeof window.One2OneApi.buildRescheduleFromDrag === "function"
        ) {
          payload = window.One2OneApi.buildRescheduleFromDrag({
            eventId: parseInt(eventId, 10),
            googlemeetid: parseInt(googlemeetId || $event.data("cm-id"), 10),
            oldDate: normalizedOldDate,
            newDate: normalizedNewDate,
            oldStartMinutes,
            oldEndMinutes: originalEventEnd,
            newStartMinutes,
            newEndMinutes,
          });
        } else {
          const dateChanged = normalizedNewDate !== normalizedOldDate;
          const timeChanged = newStartMinutes !== oldStartMinutes;

          // Build payload with exact structure matching provided examples
          payload = {
            scope: "THIS_OCCURRENCE",
            eventId: parseInt(eventId, 10),
            googlemeetid: parseInt(googlemeetId || $event.data("cm-id"), 10),
            apply: {
              time: false,
              teacher: false,
              status: false,
              days: false,
              period: false,
              end: false,
              date: false
            }
          };

          // Determine if this is ONLY time change or time + date change
          const isOnlyTimeChange = timeChanged && !dateChanged;
          const hasMultipleChanges = timeChanged && dateChanged;

          // Add time data
          if (timeChanged) {
            payload.apply.time = true;
            
            // If ONLY time changes, use "current" object
            // If time changes WITH date, use "time" object
            if (isOnlyTimeChange) {
              payload.current = {
                start: newStartTime,
                end: newEndTime
              };
            } else {
              payload.time = {
                start: newStartTime,
                end: newEndTime
              };
            }
          }

          // Add date data
          if (dateChanged && normalizedNewDate) {
            payload.apply.date = true;
            payload.date = { 
              new: normalizedNewDate 
            };
            
            // Add anchorDate (original date) when date changes
            if (normalizedOldDate) {
              payload.anchorDate = normalizedOldDate;
            }
          }
        }

        console.log("📦 Drag-and-drop payload for 1:1 event:", {
          eventId: payload.eventId,
          googlemeetid: payload.googlemeetid,
          dateChanged,
          timeChanged,
          oldDate: normalizedOldDate,
          newDate: normalizedNewDate,
          oldTime: oldStartTime,
          newTime: newStartTime,
          payload: payload,
        });
      } else {
        // Use reschedule_groupclass.php endpoint
        apiUrl =
          M.cfg.wwwroot + "/local/customplugin/ajax/reschedule_groupclass.php";

        if (!googlemeetId) {
          if (window.hideGlobalLoader) window.hideGlobalLoader();
          if (window.showToast) {
            window.showToast(
              "Cannot drag this event: missing Google Meet ID",
              "error",
            );
          }
          return;
        }

        payload = {
          eventid: eventId,
          googlemeetid: googlemeetId,
          oldTeacherId: teacherId,
          newTeacherId: teacherId, // Keep same teacher for now
          oldDate: oldDate,
          newDate: newDate,
          oldStart: oldStartTime,
          oldEnd: oldEndTime,
          newStart: newStartTime,
          newEnd: newEndTime,
        };
      }

      // Make AJAX call
      $.ajax({
        url: apiUrl,
        type: "POST",
        data: JSON.stringify(payload),
        contentType: "application/json",
        success: async function (response) {
          console.log("Drag and drop reschedule response:", response);

          if (window.showToast) {
            window.showToast("Event moved successfully!", "success");
          }

          // Refresh calendar
          try {
            if (window.refetchCustomPluginData) {
              await window.refetchCustomPluginData("reschedule");
            } else if (window.fetchCalendarEvents) {
              await window.fetchCalendarEvents();
            }
          } catch (fetchError) {
            console.error("Error refreshing calendar:", fetchError);
            if (window.hideGlobalLoader) window.hideGlobalLoader();
          }
        },
        error: function (xhr) {
          console.error("Error rescheduling event:", xhr);
          if (window.hideGlobalLoader) window.hideGlobalLoader();

          let errorMessage = "Failed to move event";
          if (xhr.responseJSON && xhr.responseJSON.error) {
            errorMessage = xhr.responseJSON.error;
          } else if (xhr.responseText) {
            try {
              const errorData = JSON.parse(xhr.responseText);
              errorMessage = errorData.error || errorMessage;
            } catch (e) {
              // Use default error message
            }
          }

          if (window.showToast) {
            window.showToast(errorMessage, "error");
          }
        },
      });

      $dayInner.removeClass("drag-over");
    });

  // Click handler for draggable events (only fires if no drag occurred)
  $(document)
    .off("click.draggable-event", ".draggable-event")
    .on("click.draggable-event", ".draggable-event", function (e) {
      // Only handle click if no drag occurred
      if (dragOccurred) {
        return;
      }

      const $clicked = $(this);
      const $day = $clicked.closest(".day-inner");
      const dateStr = $day.data("date");
      const teacherId = $clicked.data("teacher-id");
      const eventStart = $clicked.data("start");
      const eventEnd = $clicked.data("end");

      // Find matching event from window.events array
      const clickedEvent = window.events.find((ev) => {
        const evDate = ev.date;
        const evStart =
          typeof ev.start === "string" ? minutes(ev.start) : ev.start;
        const evEnd = typeof ev.end === "string" ? minutes(ev.end) : ev.end;
        return (
          evDate === dateStr && evStart === eventStart && evEnd === eventEnd
        );
      });

      if (clickedEvent) {
        currentClickedEvent = clickedEvent;
        const classType = clickedEvent.classType;
        const source = clickedEvent.source;

        // Handle event click - open menu for group events
        if (classType !== "one2one_weekly" && classType !== "one2one_single") {
          if (typeof openMenuOptionsDropdown === "function") {
            openMenuOptionsDropdown(e, this);
          }
        }
      }
    });

  /* ====== CLICK: empty slot -> open cohort modal ====== */
  $("#grid")
    .off("mousedown.emptySlot", ".day-inner")
    .on("mousedown.emptySlot", ".day-inner", function (e) {
      if ($(e.target).closest(".event").length) return;

      // If dropdowns or event menu are open, close them and do not open the cohort modal
      const isMenuOptionsOpen =
        $("#menu-options").is(":visible") ||
        $("#menu-options").css("display") === "block";

      const isAnyDropdownOpen =
        $(".custom-dropdown .dropdown-list").filter(function () {
          const $el = $(this);
          return $el.is(":visible") || $el.css("display") !== "none";
        }).length > 0;

      const isSearchDropdownOpen = [
        ".search-teacher-section",
        ".cohort-search-widget-container",
        ".search-student-section",
      ].some((sel) => {
        const $el = $(sel);
        return (
          $el.length && ($el.is(":visible") || $el.css("display") !== "none")
        );
      });

      // Check if filter popover is open
      const isFilterPopoverOpen = $(".events-filter-popover").is(":visible");

      if (
        isMenuOptionsOpen ||
        isAnyDropdownOpen ||
        isSearchDropdownOpen ||
        isFilterPopoverOpen
      ) {
        if (window.closeMenuOptionsDropdown) window.closeMenuOptionsDropdown();
        if (isAnyDropdownOpen) $(".custom-dropdown .dropdown-list").hide();
        if (isSearchDropdownOpen || isFilterPopoverOpen) e.preventDefault();
        e.stopPropagation();
        return;
      }

      // Get the clicked day and time slot
      const $dayInner = $(this);
      const dateStr = $dayInner.data("date");
      // Find the slot index from mouse position
      let slotIndex = 0;
      const $slots = $dayInner.find(".slots > div");
      const offsetY = e.pageY - $dayInner.offset().top;
      for (let i = 0; i < $slots.length; i++) {
        const slotTop = $($slots[i]).position().top;
        const slotHeight = $($slots[i]).outerHeight();
        if (offsetY >= slotTop && offsetY < slotTop + slotHeight) {
          slotIndex = i;
          break;
        }
      }

      // Highlight the clicked slot - store info before DOM changes
      const $targetSlot = $($slots[slotIndex]);
      window._lastCohortSlotInfo = {
        date: dateStr,
        index: slotIndex,
      };

      // Remove highlight from all slots across all days
      $(".day-inner .slots > div").removeClass("cohort-slot-highlight");
      $targetSlot.addClass("cohort-slot-highlight");
      window._lastCohortSlot = $targetSlot;

      // Calculate start and end time in minutes
      const startMin =
        (typeof START_H !== "undefined" ? START_H : 6) * 60 +
        slotIndex * (typeof SLOT_MIN !== "undefined" ? SLOT_MIN : 30);
      const endMin =
        startMin + (typeof SLOT_MIN !== "undefined" ? SLOT_MIN : 30);

      // Format time as 12h
      // pad2() and fmt12() are now in js/time_utils.js
      // Using: pad2() and fmt12() from time_utils.js

      // Get day name
      const dayNames = ["Sun", "Mon", "Tue", "Wed", "Thu", "Fri", "Sat"];
      const d = new Date(dateStr);
      const dayName = dayNames[d.getDay()];

      // Build label
      const timeLabel = `${fmt12(startMin)} - ${fmt12(endMin)}`;
      const scheduleLabel = `Weekly on ${dayName}(<span class="time-range">${timeLabel}</span>) <span class="cohort_schedule_arrow">&#9660;</span>`;

      // Open modal and set label after modal is visible
      openCreateCohortModal();
      setTimeout(function () {
        $(".cohort_schedule_btn").html(scheduleLabel);
      }, 300);
    });

  // Add CSS for slot highlight
  if (!document.getElementById("cohortSlotStyle")) {
    const cohortSlotStyle = document.createElement("style");
    cohortSlotStyle.id = "cohortSlotStyle";
    cohortSlotStyle.innerHTML = `.cohort-slot-highlight { background: rgba(230,57,70,0.10) !important; }`;
    document.head.appendChild(cohortSlotStyle);
  }

  // Remove highlight when modal closes
  $(document).on(
    "click",
    "#calendar_admin_details_create_cohort_modal_backdrop .modal-close, #calendar_admin_details_create_cohort_modal_backdrop",
    function (e) {
      // Only remove highlight if clicking backdrop or close button, not modal content
      if (
        $(e.target).is(
          "#calendar_admin_details_create_cohort_modal_backdrop",
        ) ||
        $(e.target).closest(".modal-close").length
      ) {
        $(".day-inner .slots > div").removeClass("cohort-slot-highlight");
        window._lastCohortSlot = null;
        window._lastCohortSlotInfo = null;
      }
    },
  );

  // First render
  renderWeek(true);

  // Navigation
  $("#prev-week").on("click", () => {
    clearDateFilter(); // Clear filter when changing weeks
    clearTimeSlotFilter(); // Clear time slot filter when changing weeks
    currentWeekStart.setDate(currentWeekStart.getDate() - 7);
    // Make currentWeekStart available globally for fetchCalendarEvents
    window.currentWeekStart = currentWeekStart;

    // First render the week layout to establish week dates
    renderWeek(true);
    // Then fetch fresh events for this week
    if (
      window.fetchCalendarEvents &&
      typeof window.fetchCalendarEvents === "function"
    ) {
      window.fetchCalendarEvents();
    }
  });
  $("#next-week").on("click", () => {
    clearDateFilter(); // Clear filter when changing weeks
    clearTimeSlotFilter(); // Clear time slot filter when changing weeks
    currentWeekStart.setDate(currentWeekStart.getDate() + 7);
    // Make currentWeekStart available globally for fetchCalendarEvents
    window.currentWeekStart = currentWeekStart;

    // First render the week layout to establish week dates
    renderWeek(true);
    // Then fetch fresh events for this week
    if (
      window.fetchCalendarEvents &&
      typeof window.fetchCalendarEvents === "function"
    ) {
      window.fetchCalendarEvents();
    }
  });

  // Today button: jump to current week (Monday)
  $("#btnToday").on("click", () => {
    currentWeekStart = window.mondayOf(new Date());
    // Make currentWeekStart available globally for fetchCalendarEvents
    window.currentWeekStart = currentWeekStart;

    // Clear date filters when navigating to a new week to avoid hiding events
    // Time slot filters can remain as they're not week-specific
    clearDateFilter();

    // First render the week layout to establish week dates
    renderWeek(true);
    // Then fetch fresh events for this week
    if (
      window.fetchCalendarEvents &&
      typeof window.fetchCalendarEvents === "function"
    ) {
      window.fetchCalendarEvents();
    }
  });

  // Now line heartbeat
  setInterval(drawNow, 60 * 1000);

  // Update Today button enabled/disabled state
  function updateTodayButton() {
    const todayMonday = window.mondayOf(new Date());
    const isTodayWeek = todayMonday.getTime() === currentWeekStart.getTime();
    $("#btnToday").prop("disabled", isTodayWeek);
  }

  /* ====== RENDER ====== */
  function renderWeek(resetScroll = false) {
    // Save highlighted slot info before rebuilding grid
    let highlightedSlotInfo = null;
    if (window._lastCohortSlotInfo) {
      highlightedSlotInfo = window._lastCohortSlotInfo;
    } else if (window._lastCohortSlot && window._lastCohortSlot.length) {
      const $dayInner = window._lastCohortSlot.closest(".day-inner");
      if ($dayInner.length) {
        const dateStr = $dayInner.data("date");
        const slotIndex = window._lastCohortSlot.index();
        highlightedSlotInfo = { date: dateStr, index: slotIndex };
      }
    }

    // Determine whether to show white slots based on teacher selection
    const selectedTeachers = window.calendarFilterState
      ? window.calendarFilterState.getSelectedTeachers()
      : [];

    // Show white slots as background only when exactly 1 teacher is selected
    SHOW_WHITE_SLOTS = selectedTeachers.length === 1;

    // Filter events based on teacher selection
    let eventsToRender = window.events.filter((ev) => {
      // When single teacher selected, exclude availability/extra slot events
      if (selectedTeachers.length === 1) {
        if (
          ev.classType === "availability" ||
          ev.source === "availability" ||
          ev.classType === "extra_slot" ||
          ev.source === "extra_slot"
        ) {
          return false; // Exclude availability/extra slot events
        }
      }
      return true;
    });

    // When multiple teachers selected, add availability data as events
    if (selectedTeachers.length > 1 && whiteSlotRules.length > 0) {
      // Convert white slot rules to availability events for multiple teacher display
      const availabilityEvents = whiteSlotRules.map((rule, index) => ({
        availabilityId: `availability-${index}-${Date.now()}`,
        date: rule.date,
        classType: "availability",
        source: "availability",
        title: "Available",
        start:
          typeof rule.start === "string" ? minutes(rule.start) : rule.start,
        end: typeof rule.end === "string" ? minutes(rule.end) : rule.end,
        color: "e-availability",
        teacherId: rule.teacherid,
      }));
      eventsToRender = [...eventsToRender, ...availabilityEvents];
    }

    // Temporarily replace window.events with modified list
    const originalEvents = window.events;
    window.events = eventsToRender;

    // Header
    const $head = $("#head");
    $head.find(".day-h").remove();
    const today = window.ymd(new Date());
    for (let i = 0; i < 7; i++) {
      const d = new Date(currentWeekStart);
      d.setDate(d.getDate() + i);
      const $dayHeader = $('<div class="day-h">')
        .append(`<span class="dow">${DOW[i]}</span>`)
        .append(`<span class="dt">${d.getDate()}</span>`);

      // Add 'today' class if this is today's date
      if (window.ymd(d) === today) {
        $dayHeader.addClass("today");
      }

      $dayHeader.appendTo($head);
    }
    $("#calendar-range").text(rangeText(currentWeekStart));
    // Keep Today button state in sync
    updateTodayButton();

    // FULL GRID rebuild
    const $grid = $("#grid");
    $grid.empty().append('<div id="gutter" class="gutter"></div>');
    const $gut = $("#gutter");
    for (let m = START_H * 60; m < END_H * 60; m += SLOT_MIN) {
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
      weekDates.push(window.ymd(d));

      const $col = $('<div class="day" style="z-index:0 !important">');
      const $inner = $('<div class="day-inner">').appendTo($col);
      $inner.attr("data-date", window.ymd(d));

      // CREATE SLOTS (white background layer is optional)
      const $slots = $('<div class="slots">').appendTo($inner);
      for (let r = 0; r < rows; r++) {
        const minuteOfDay = START_H * 60 + r * SLOT_MIN;
        const slotSource = SHOW_WHITE_SLOTS
          ? isWhiteSlotFor(i, window.ymd(d), minuteOfDay)
          : null;
        const makeWhite = !!slotSource;
        const $slot = $("<div>").toggleClass("slot-white", makeWhite);
        if (slotSource) {
          $slot.attr("data-source", slotSource);
          // Add dotted border class for extra slots
          if (slotSource === "extra_slot") {
            $slot.addClass("slot-extra");
          }
          if (r === 0 || minuteOfDay % 120 === 0) {
            // Log occasionally to avoid spam
            console.log("White slot created:", {
              date: window.ymd(d),
              minute: minuteOfDay,
              source: slotSource,
            });
          }
        }
        $slot.appendTo($slots);
      }

      $grid.append($col);
      dayEls.push($inner);
    }

    // Prepare per-day buckets
    const perDay = Array.from({ length: 7 }, () => []);
    console.log("Events to render:", events);

    // timeToMinutes() is now in js/time_utils.js
    // Using: timeToMinutes() from time_utils.js (alias for minutes())

    const eventMap = new Map();

    events.forEach((event) => {
      const startMinutes = timeToMinutes(event.start);
      const endMinutes = timeToMinutes(event.end);
      const key = `${event.teacherId}-${event.date}-${startMinutes}-${endMinutes}`;

      if (!eventMap.has(key)) {
        eventMap.set(key, event);
      } else {
        const existing = eventMap.get(key);
        // Prefer e-blue over other colors
        if (event.color === "e-blue") {
          eventMap.set(key, event);
        }
        // else keep existing
      }
    });

    const uniqueEvents = Array.from(eventMap.values());

    // Remove duplicate availability events by availabilityId
    // const seenAvailabilityIds = new Set();
    // const uniqueEvents = events.filter((raw) => {
    //   if (raw.availabilityId && seenAvailabilityIds.has(raw.availabilityId)) {
    //     return false; // Skip duplicate availability
    //   }
    //   if (raw.availabilityId) {
    //     seenAvailabilityIds.add(raw.availabilityId);
    //   }
    //   return true;
    // });

    console.log("Unique events to render:", uniqueEvents);
    uniqueEvents.forEach((raw) => {
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
          previousEvent = raw.summary?.previous || raw.rescheduled?.previous;
          currentEvent = raw.summary?.current || raw.rescheduled?.current;
        }
      }

      // If reschedule_instant with both previous and current, create two events
      if (hasRescheduleInstant && previousEvent && currentEvent) {
        // Convert times to minutes for comparison
        const prevStart =
          typeof previousEvent.start === "string"
            ? minutes(previousEvent.start)
            : previousEvent.start;
        const prevEnd =
          typeof previousEvent.end === "string"
            ? minutes(previousEvent.end)
            : previousEvent.end;
        const currStart =
          typeof currentEvent.start === "string"
            ? minutes(currentEvent.start)
            : currentEvent.start;
        const currEnd =
          typeof currentEvent.end === "string"
            ? minutes(currentEvent.end)
            : currentEvent.end;

        // Check if time has changed (same start and end times)
        const timeUnchanged =
          prevStart === currStart &&
          prevEnd === currEnd &&
          previousEvent.date === currentEvent.date;

        // Check if teacher changed
        const oldTeacherId = previousEvent.teacher;
        const newTeacherId = currentEvent.teacher;
        const teacherChanged =
          oldTeacherId && newTeacherId && oldTeacherId !== newTeacherId;

        // Get teacher images
        const prevTeacherPic =
          previousEvent.teacher_pic ||
          previousEvent.teacherpic ||
          previousEvent.teacher?.avatar ||
          raw.rescheduled?.previous?.teacher_pic ||
          raw.summary?.previous?.teacher_pic ||
          raw.summary?.previous?.teacher?.avatar ||
          null;
        const currTeacherPic =
          currentEvent.teacher_pic ||
          currentEvent.teacherpic ||
          currentEvent.teacher?.avatar ||
          raw.rescheduled?.current?.teacher_pic ||
          raw.summary?.current?.teacher_pic ||
          raw.summary?.current?.teacher?.avatar ||
          null;

        // Create faded previous event
        const prevIdx = weekDates.indexOf(previousEvent.date);
        if (prevIdx !== -1) {
          const ePrev = { ...raw };
          ePrev.date = previousEvent.date;
          ePrev.start = prevStart;
          ePrev.end = prevEnd;
          ePrev.teacherId = previousEvent.teacher || raw.teacherId;
          ePrev.isFadedReschedule = true; // Mark as faded
          ePrev.isReschedulePrevious = true;

          // When teacher changed, previous event keeps previous teacher image
          if (teacherChanged) {
            if (prevTeacherPic) {
              ePrev.avatar = prevTeacherPic;
              if (ePrev.summary && ePrev.summary.previous) {
                ePrev.summary.previous.teacher_pic = ePrev.avatar;
                ePrev.summary.previous.teacherpic = ePrev.avatar;
                if (ePrev.summary.previous.teacher) {
                  ePrev.summary.previous.teacher.avatar = ePrev.avatar;
                }
              }
              if (ePrev.rescheduled && ePrev.rescheduled.previous) {
                ePrev.rescheduled.previous.teacher_pic = ePrev.avatar;
                ePrev.rescheduled.previous.teacherpic = ePrev.avatar;
              }
            } else if (!ePrev.avatar && currTeacherPic) {
              ePrev.avatar = currTeacherPic;
            }
          } else if (prevTeacherPic) {
            // No teacher change, use previous teacher's image
            ePrev.avatar = prevTeacherPic;
          }

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

        // Only create current event if time has changed
        if (!timeUnchanged) {
          const currIdx = weekDates.indexOf(currentEvent.date);
          if (currIdx !== -1) {
            const eCurr = { ...raw };
            eCurr.date = currentEvent.date;
            eCurr.start = currStart;
            eCurr.end = currEnd;
            eCurr.teacherId = currentEvent.teacher || raw.teacherId;
            eCurr.isRescheduleCurrent = true;

            // Check if teacher changed
            if (teacherChanged) {
              eCurr.isTeacherChanged = true;

              // Ensure current teacher's avatar is set first
              if (!eCurr.avatar && currTeacherPic) {
                eCurr.avatar = currTeacherPic;
              }

              // When teacher changed, current event keeps current teacher image
              if (currTeacherPic && eCurr.summary && eCurr.summary.current) {
                if (!eCurr.summary.current.teacher) {
                  eCurr.summary.current.teacher = {};
                }
                if (!eCurr.summary.current.teacher.avatar) {
                  eCurr.summary.current.teacher.avatar = currTeacherPic;
                }
                if (!eCurr.summary.current.teacher_pic) {
                  eCurr.summary.current.teacher_pic = currTeacherPic;
                }
                if (!eCurr.summary.current.teacherpic) {
                  eCurr.summary.current.teacherpic = currTeacherPic;
                }
              }
              if (
                currTeacherPic &&
                eCurr.rescheduled &&
                eCurr.rescheduled.current
              ) {
                if (!eCurr.rescheduled.current.teacher_pic) {
                  eCurr.rescheduled.current.teacher_pic = currTeacherPic;
                }
                if (!eCurr.rescheduled.current.teacherpic) {
                  eCurr.rescheduled.current.teacherpic = currTeacherPic;
                }
              }
            }

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

    // Overlap logic - improved for consistent sequential stacking
    const MAX_LEFT = 0 + (STACK_CAP - 1) * STACK_OFFSET;

    perDay.forEach((list, di) => {
      // Sort events by start time, then by end time for consistent ordering
      list.sort((a, b) => a.start - b.start || a.end - b.end);

      // First pass: calculate _max (maximum concurrent events at any time)
      const active = [];
      list.forEach((ev) => {
        // Remove events that ended before this one starts
        for (let i = active.length - 1; i >= 0; i--) {
          if (active[i].end <= ev.start) active.splice(i, 1);
        }
        active.push(ev);

        const conc = active.length;
        // Update _max for all active events
        active.forEach((a) => {
          a._max = Math.max(a._max || 0, conc);
        });
      });

      // Second pass: assign stackIndex based on position in sorted order for overlaps
      // This ensures events maintain sequential positions left-to-right
      list.forEach((ev) => {
        // Find all events that overlap with this one
        const overlapping = list.filter((other) => {
          // Check if events overlap in time
          return !(other.end <= ev.start || other.start >= ev.end);
        });

        // Sort overlapping events by start time, then end time
        overlapping.sort((a, b) => a.start - b.start || a.end - b.end);

        // Find this event's position in the overlapping group
        const position = overlapping.indexOf(ev);
        ev.stackIndex = Math.min(position, STACK_CAP - 1);
      });

      list.forEach((ev) => {
        const top = (ev.start - START_H * 60) * PX_PER_MIN;
        const h = (ev.end - ev.start) * PX_PER_MIN - 0;

        const isSingleton = (ev._max || 1) === 1;
        const cssPos = (() => {
          if (isSingleton) return { left: "0px", width: "90%" };

          const overlapping = perDay[di]
            .filter(
              (other) => !(other.end <= ev.start || other.start >= ev.end),
            )
            .sort((a, b) => a.start - b.start || a.end - b.end);

          const total = overlapping.length;
          const position = overlapping.indexOf(ev);

          const overlapPercent = 70; // % of slot width for horizontal overlap per event
          const widthPercent =
            100 / (total - (total - 1) * (overlapPercent / 100));
          const leftPercent =
            position * (widthPercent - widthPercent * (overlapPercent / 100));

          return {
            left: `${leftPercent}%`,
            width: `${widthPercent}%`,
            opacity: `1`,
          };
        })();

        // Get teacher color class and inline style for unlimited colors
        let teacherColorClass = "";
        let teacherColorStyle = "";

        if (ev.teacherId) {
          const colorIndex = getTeacherColorIndex(ev.teacherId);

          // Only show teacher indicator dot if more than 1 teacher is selected
          // AND the event is not an availability event (availability uses background color instead)
          const selectedTeachers = window.calendarFilterState
            ? window.calendarFilterState.getSelectedTeachers()
            : [];
          const showTeacherDot =
            selectedTeachers.length > 1 && ev.classType !== "availability";

          teacherColorClass = `teacher-${colorIndex}${
            showTeacherDot ? " has-teacher-indicator" : ""
          }`;

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
        } else if (ev.classType === "availability") {
          classTypeClass = "class-type-availability";
          // Use teacher color for both background and border
          if (ev.teacherId) {
            const teacherColor = getTeacherColor(ev.teacherId);
            borderColorStyle = `border: 2px solid ${teacherColor} !important; background: color-mix(in srgb, ${teacherColor} 15%, #fff) !important;`;
          } else {
            borderColorStyle =
              "border: 2px solid #9aa7b8 !important; background: color-mix(in srgb, #9aa7b8 15%, #fff) !important;";
          }
        } else if (ev.classType === "extra_slot") {
          classTypeClass = "class-type-extra-slot";
          // Use teacher color for both background and dotted border
          if (ev.teacherId) {
            const teacherColor = getTeacherColor(ev.teacherId);
            borderColorStyle = `border: 2px dotted ${teacherColor} !important; background: color-mix(in srgb, ${teacherColor} 15%, #fff) !important;`;
          } else {
            borderColorStyle =
              "border: 2px dotted #7088ff !important; background: color-mix(in srgb, #7088ff 15%, #fff) !important;";
          }
        }

        // Combine styles (include any custom inline style from the event object)
        const combinedStyle = `${teacherColorStyle}${borderColorStyle}${
          ev.style || ""
        }`.trim();

        // Check if event is short (less than 1 hour)
        const eventDuration = ev.end - ev.start;
        const isShortEvent = eventDuration < 31;

        const isTimeOffEvent =
          ev.classType === "teacher_timeoff" ||
          ev.class_type === "teacher_timeoff" ||
          ev.source === "teacher_timeoff";

        // Status and type icons are now rendered using EventIconUtils
        // Status and type icons are now rendered using EventIconUtils
        // Using: EventIconUtils.renderStatusIcons() and EventIconUtils.renderTypeIcon() from event_icon_utils.js
        const statusMeta = getActiveStatusMeta(ev.statuses);
        let statusIconHtml = "";
        if (
          window.EventIconUtils &&
          typeof window.EventIconUtils.renderStatusIcons === "function"
        ) {
          try {
            statusIconHtml = window.EventIconUtils.renderStatusIcons(
              ev,
              statusMeta,
              {
                hideForRescheduleCurrent: true,
                position: "absolute",
                top: "6px",
                right: "6px",
                zIndex: 2,
              },
              currentWeekStart,
            );
          } catch (e) {
            console.warn("EventIconUtils.renderStatusIcons error:", e);
            // Fallback on error
            if (ev.isRescheduleCurrent && !ev.isTeacherChanged) {
              statusIconHtml = "";
            } else if (statusMeta) {
              statusIconHtml = `<span class="ev-status-icon" title="${statusMeta.label}" aria-label="${statusMeta.label}" style="position:absolute; top:6px; right:6px; display:inline-flex; align-items:center; justify-content:center; pointer-events:none; z-index:2;">
                <img src="${statusMeta.icon}" alt="${statusMeta.label}" style="width:16px; height:16px;">
              </span>`;
            }
          }
        } else {
          // Fallback implementation if EventIconUtils is not available
          if (ev.isRescheduleCurrent && !ev.isTeacherChanged) {
            statusIconHtml = "";
          } else if (statusMeta) {
            statusIconHtml = `<span class="ev-status-icon" title="${statusMeta.label}" aria-label="${statusMeta.label}" style="position:absolute; top:6px; right:6px; display:inline-flex; align-items:center; justify-content:center; pointer-events:none; z-index:2;">
              <img src="${statusMeta.icon}" alt="${statusMeta.label}" style="width:16px; height:16px;">
            </span>`;
          }
        }

        // Add faded styling for previous reschedule events and cancelled events
        const isCancelled =
          statusMeta &&
          (statusMeta.code === "cancel" ||
            statusMeta.code === "cancel_no_makeup");
        const fadedClass =
          ev.isFadedReschedule || isCancelled ? " faded-reschedule" : "";
        // Don't apply grayscale filter inline - CSS will handle it while excluding icons/images
        const fadedStyle = "";

        // Determine if event should be draggable (exclude availability and extra_slot events)
        const isDraggable =
          ev.classType !== "availability" &&
          ev.classType !== "extra_slot" &&
          ev.source !== "availability" &&
          ev.source !== "extra_slot" &&
          !ev.isFadedReschedule; // Don't allow dragging faded reschedule events

        // Build event HTML - hide details for short events
        const $ev = $(`
          <div class="event ${
            ev.color || "e-blue"
          } ${teacherColorClass} ${classTypeClass}${
            ev.isMidnightCrossing ? " midnight-crossing" : ""
          }${isShortEvent ? " short-event" : ""}${fadedClass}${
            isDraggable ? " draggable-event" : ""
          }" style="${combinedStyle}${fadedStyle}${
            isDraggable ? " cursor: move;" : ""
          }" data-start="${ev.start}" data-end="${ev.end}" data-date="${
            ev.date || ""
          }" data-event-date="${ev.date || ""}" data-title="${(
            ev.title || ""
          ).replace(/"/g, "&quot;")}" ${
            ev.teacherId ? `data-teacher-id="${ev.teacherId}"` : ""
          }${ev.pairedId ? ` data-paired-id="${ev.pairedId}"` : ""}${
            ev.part ? ` data-part="${ev.part}"` : ""
          }${
            ev.studentids &&
            (Array.isArray(ev.studentids)
              ? ev.studentids.length > 0
              : ev.studentids)
              ? ` data-student-ids="${
                  Array.isArray(ev.studentids)
                    ? ev.studentids.join(",")
                    : ev.studentids
                }"`
              : ""
          }${
            ev.studentnames &&
            (Array.isArray(ev.studentnames)
              ? ev.studentnames.length > 0
              : ev.studentnames)
              ? ` data-student-names="${
                  Array.isArray(ev.studentnames)
                    ? ev.studentnames.join(",")
                    : ev.studentnames
                }"`
              : ""
          }${ev.avatar ? ` data-avatar="${ev.avatar}"` : ""}${
            ev.cohortids &&
            (Array.isArray(ev.cohortids)
              ? ev.cohortids.length > 0
              : ev.cohortids)
              ? ` data-cohort-ids="${
                  Array.isArray(ev.cohortids)
                    ? ev.cohortids.join(",")
                    : ev.cohortids
                }"`
              : ""
          }${ev.eventid ? ` data-event-id="${ev.eventid}"` : ""}${
            ev.cmid ? ` data-cm-id="${ev.cmid}"` : ""
          }${ev.googlemeetid ? ` data-googlemeet-id="${ev.googlemeetid}"` : ""}${
            ev.classType ? ` data-class-type="${ev.classType}"` : ""
          }${ev.source ? ` data-source="${ev.source}"` : ""}
        ${ev.repeat !== undefined ? ` data-repeat="${ev.repeat}"` : ""}${
          statusMeta ? ` data-status-code="${statusMeta.code}"` : ""
        }${isDraggable ? ` draggable="true"` : ""}>
            ${
              isShortEvent &&
              ev.classType !== "availability" &&
              ev.classType !== "extra_slot"
                ? `
                <div class=\"ev-when\" style=\"display:flex;align-items:center;gap:4px;\">
                  ${
                    ev.classType === "one2one_weekly" ||
                    ev.classType === "one2one_single"
                      ? `<span class=\"ev-single\" title=\"Single Session\"><img src=\"./img/single-lesson.svg\" alt=\"\"></span>`
                      : isTimeOffEvent
                        ? ""
                        : ev.isRescheduleCurrent && !ev.isTeacherChanged
                          ? `<span class=\"ev-makeup\" title=\"Make-up Class\"><img src=\"./img/makeup.svg\" alt=\"\"></span>`
                          : `<span class=\"ev-repeat\" title=\"Repeats\"><img src=\"./img/ev-repeat.svg\" alt=\"\"></span>`
                  }
                  <span>${fmt12(
                    typeof ev.start === "string"
                      ? minutes(ev.start)
                      : typeof ev.start === "number"
                        ? ev.start
                        : 0,
                  )} – ${fmt12(
                    typeof ev.end === "string"
                      ? minutes(ev.end)
                      : typeof ev.end === "number"
                        ? ev.end
                        : 0,
                  )}</span>
                  ${statusIconHtml}
                  ${
                    ev.isMidnightCrossing
                      ? `<span class=\"ev-midnight-icon\" title=\"Continues to next day\">↪</span>`
                      : ""
                  }
                </div>
                <div class=\"ev-title\">${
                  (ev.classType === "one2one_weekly" ||
                    ev.classType === "one2one_single") &&
                  ev.studentnames &&
                  (Array.isArray(ev.studentnames)
                    ? ev.studentnames.length > 0
                    : ev.studentnames)
                    ? `<div style="display:flex;align-items:center;gap:6px;">
                        ${
                          ev.studentavatar &&
                          Array.isArray(ev.studentavatar) &&
                          ev.studentavatar.length > 0
                            ? `<img src="${ev.studentavatar[0]}" alt="" style="width:20px;height:20px;border-radius:50%;object-fit:cover;" onerror="this.style.display='none'">`
                            : ""
                        }
                        <span>${
                          Array.isArray(ev.studentnames)
                            ? ev.studentnames.join(", ")
                            : ev.studentnames
                        }</span>
                      </div>`
                    : ev.title || ""
                }</div>
                `
                : `
                  ${statusIconHtml}
                  ${
                    !isShortEvent &&
                    ev.classType !== "availability" &&
                    ev.classType !== "extra_slot"
                      ? `<div class=\"ev-top\">
                      
                          ${
                            isTimeOffEvent
                              ? ""
                              : ev.isRescheduleCurrent &&
                                  !ev.isTeacherChanged &&
                                  ev.repeat
                                ? `<span class=\"ev-repeat\" title=\"Repeats\"><img src=\"./img/ev-repeat.svg\" alt=\"\"></span><span class=\"ev-makeup\" title=\"Make-up Class\"><img src=\"./img/makeup.svg\" alt=\"\"></span>`
                                : ev.isRescheduleCurrent && !ev.isTeacherChanged
                                  ? `<span class=\"ev-makeup\" title=\"Make-up Class\"><img src=\"./img/makeup.svg\" alt=\"\"></span>`
                                  : ev.classType === "one2one_weekly" ||
                                      ev.classType === "one2one_single"
                                    ? `<span class=\"ev-single\" title=\"Single Session\"><img src=\"./img/single-lesson.svg\" alt=\"\"></span>`
                                    : `<span class=\"ev-repeat\" title=\"Repeats\"><img src=\"./img/ev-repeat.svg\" alt=\"\"></span>`
                          }
                          ${
                            ev.isMidnightCrossing
                              ? `<span class=\"ev-midnight-icon\" title=\"Continues to next day\">↪</span>`
                              : ""
                          }
                        </div>`
                      : ""
                  }
                  ${
                    (ev.classType === "one2one_weekly" ||
                      ev.classType === "one2one_single") &&
                    ev.studentavatar &&
                    Array.isArray(ev.studentavatar) &&
                    ev.studentavatar.length > 0 &&
                    ev.classType !== "availability" &&
                    ev.classType !== "extra_slot"
                      ? `<div style="display:flex;justify-content:start;padding:4px 0;">
                          <img src="${ev.studentavatar[0]}" alt="" style="width:23px;height:23px;border-radius:50%;object-fit:cover;" onerror="this.style.display='none'">
                        </div>`
                      : ""
                  }
                  ${
                    ev.classType !== "availability" &&
                    ev.classType !== "extra_slot"
                      ? `<div class=\"ev-when\">${fmt12(
                          ev.start
                            ? typeof ev.start === "string"
                              ? minutes(ev.start)
                              : typeof ev.start === "number"
                                ? ev.start
                                : 0
                            : 0,
                        )} – ${fmt12(
                          ev.end
                            ? typeof ev.end === "string"
                              ? minutes(ev.end)
                              : typeof ev.end === "number"
                                ? ev.end
                                : 0
                            : 0,
                        )}</div>`
                      : ""
                  }
                  ${
                    !isShortEvent &&
                    ev.classType !== "availability" &&
                    ev.classType !== "extra_slot"
                      ? `<div class=\"ev-title\">${
                          (ev.classType === "one2one_weekly" ||
                            ev.classType === "one2one_single") &&
                          ev.studentnames &&
                          (Array.isArray(ev.studentnames)
                            ? ev.studentnames.length > 0
                            : ev.studentnames)
                            ? Array.isArray(ev.studentnames)
                              ? ev.studentnames.join(", ")
                              : ev.studentnames
                            : ev.title || ""
                        }</div>`
                      : ""
                  }
                  ${
                    // Add history section if history exists and event is not too short
                    !isShortEvent &&
                    ev.history &&
                    Array.isArray(ev.history) &&
                    ev.history.length > 0 &&
                    ev.classType !== "availability" &&
                    ev.classType !== "extra_slot"
                      ? `<div class="ev-history" style="margin-top:8px;padding-top:8px;border-top:1px solid rgba(0,0,0,0.1);">
                          <div style="font-size:11px;font-weight:600;color:#666;margin-bottom:6px;text-transform:uppercase;letter-spacing:0.5px;">History</div>
                          <div style="display:flex;flex-direction:column;gap:4px;">
                            ${ev.history
                              .slice(0, 4)
                              .map((hist, idx) => {
                                const histIcon = getHistoryIcon(hist);
                                const histDesc = formatHistoryDescription(hist);
                                return `
                                <div class="ev-history-item" style="display:flex;align-items:center;gap:6px;font-size:11px;color:#666;">
                                  <img src="${histIcon.icon}" alt="${histIcon.label}" style="width:14px;height:14px;opacity:0.7;flex-shrink:0;">
                                  <span style="flex:1;overflow:hidden;text-overflow:ellipsis;white-space:nowrap;" title="${histDesc}">${histDesc}</span>
                                </div>
                              `;
                              })
                              .join("")}
                            ${
                              ev.history.length > 4
                                ? `<div style="font-size:10px;color:#999;font-style:italic;">+${
                                    ev.history.length - 4
                                  } more</div>`
                                : ""
                            }
                          </div>
                        </div>`
                      : ""
                  }
                `
            }
          </div>
        `).css({ top: top + "px", height: h + "px", ...cssPos });

        // Base z-index: availability stays behind everything else
        const baseZ =
          ev.classType === "availability"
            ? 10 + (ev.stackIndex || 0)
            : 1000 + (ev.stackIndex || 0);
        $ev.css("z-index", baseZ);

        // Add hover tooltip for short events (less than 1 hour) - exclude availability and extra_slot events
        if (
          isShortEvent &&
          ev.classType !== "availability" &&
          ev.classType !== "extra_slot"
        ) {
          // Create tooltip element
          const $tooltip = $(`
            <div class="event-tooltip">
              <div class="tooltip-header">
                <strong>${
                  (ev.classType === "one2one_weekly" ||
                    ev.classType === "one2one_single") &&
                  ev.studentnames &&
                  (Array.isArray(ev.studentnames)
                    ? ev.studentnames.length > 0
                    : ev.studentnames)
                    ? Array.isArray(ev.studentnames)
                      ? ev.studentnames.join(", ")
                      : ev.studentnames
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

        // Add hover tooltip for teacher change icon
        // Updated selector: data attributes are now on inner span, not on .ev-status-icon
        const teacherChangeIcon = $ev.find("[data-teacher-pic]");
        if (teacherChangeIcon.length > 0) {
          const $teacherTooltip = $(`
            <div class="notification-card teacher-change-tooltip-card">
              <div class="notification-content">
                <h3 class="notification-title">Session Reassigned</h3>
                <p class="notification-body">This session has been reassigned from <strong>${teacherChangeIcon.attr(
                  "data-prev-teacher",
                )}</strong> to <strong>${teacherChangeIcon.attr(
                  "data-new-teacher",
                )}</strong></p>
              </div>
              <svg class="notification-arrow" width="18" height="12" viewBox="0 0 18 12" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path d="M9 12L0 0H18L9 12Z" fill="#121117"/>
              </svg>
            </div>
          `);

          teacherChangeIcon.on("mouseenter", function (e) {
            const $icon = $(this);
            const iconRect = $icon[0].getBoundingClientRect();
            const gap = 8; // Small gap between icon and tooltip

            $("body").append($teacherTooltip);

            // Get actual tooltip dimensions after appending
            const tooltipRect = $teacherTooltip[0].getBoundingClientRect();
            const tooltipWidth = tooltipRect.width;
            const tooltipHeight = tooltipRect.height;

            // Position tooltip above the icon, centered horizontally, with small gap
            let top = iconRect.top - tooltipHeight - gap;
            let left = iconRect.left + iconRect.width / 2 - tooltipWidth / 2;

            // Adjust if tooltip goes off screen horizontally
            if (left < 10) {
              left = 10;
            } else if (left + tooltipWidth > window.innerWidth - 10) {
              left = window.innerWidth - tooltipWidth - 10;
            }

            // Adjust if tooltip goes off screen vertically (above)
            if (top < 10) {
              // Position below instead
              top = iconRect.bottom + gap;
            }

            // Position tooltip
            $teacherTooltip.css({
              position: "fixed",
              top: top + "px",
              left: left + "px",
              zIndex: 10000,
            });

            $teacherTooltip.fadeIn(200);
          });

          teacherChangeIcon.on("mouseleave", function () {
            $teacherTooltip.fadeOut(200, function () {
              $teacherTooltip.remove();
            });
          });

          // Keep tooltip open when hovering over it
          $(document).on(
            "mouseenter",
            ".teacher-change-tooltip-card",
            function () {
              $teacherTooltip.stop(true, true).fadeIn(200);
            },
          );

          $(document).on(
            "mouseleave",
            ".teacher-change-tooltip-card",
            function () {
              $teacherTooltip.fadeOut(200, function () {
                $teacherTooltip.remove();
              });
            },
          );
        }

        // Add hover tooltip for makeup events
        const summaryPrevious =
          ev.summary?.previous || ev.rescheduled?.previous;
        if (ev.isRescheduleCurrent && !ev.isTeacherChanged && summaryPrevious) {
          // Get previous time from summary or rescheduled
          const prevStart = summaryPrevious.start_time || summaryPrevious.start;
          const prevEnd = summaryPrevious.end_time || summaryPrevious.end;

          const $makeupTooltip = $(`
            <div class="notification-card makeup-tooltip-card">
              <div class="notification-content">
                <h3 class="notification-title">Makeup session detail</h3>
                <p class="notification-body">Old timing : ${fmt12(
                  typeof prevStart === "string"
                    ? minutes(prevStart)
                    : prevStart || 0,
                )} – ${fmt12(
                  typeof prevEnd === "string" ? minutes(prevEnd) : prevEnd || 0,
                )}<br>New timing : ${fmt12(ev.start)} – ${fmt12(ev.end)}</p>
              </div>
              <svg class="notification-arrow" width="18" height="12" viewBox="0 0 18 12" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path d="M9 12L0 0H18L9 12Z" fill="#121117"/>
              </svg>
            </div>
          `);

          $ev.on("mouseenter", function (e) {
            const $event = $(this);
            const eventRect = $event[0].getBoundingClientRect();
            const gap = 8; // Small gap between event and tooltip

            $("body").append($makeupTooltip);

            // Get actual tooltip dimensions after appending
            const tooltipRect = $makeupTooltip[0].getBoundingClientRect();
            const tooltipWidth = tooltipRect.width;
            const tooltipHeight = tooltipRect.height;

            // Position tooltip above the event, centered horizontally, with small gap
            let top = eventRect.top - tooltipHeight - gap;
            let left = eventRect.left + eventRect.width / 2 - tooltipWidth / 2;

            // Adjust if tooltip goes off screen horizontally
            if (left < 10) {
              left = 10;
            } else if (left + tooltipWidth > window.innerWidth - 10) {
              left = window.innerWidth - tooltipWidth - 10;
            }

            // Adjust if tooltip goes off screen vertically (above)
            if (top < 10) {
              // Position below instead
              top = eventRect.bottom + gap;
            }

            // Position tooltip
            $makeupTooltip.css({
              position: "fixed",
              top: top + "px",
              left: left + "px",
              zIndex: 10000,
            });

            $makeupTooltip.fadeIn(200);
          });

          $ev.on("mouseleave", function () {
            $makeupTooltip.fadeOut(200, function () {
              $makeupTooltip.remove();
            });
          });

          // Keep tooltip open when hovering over it
          $(document).on("mouseenter", ".makeup-tooltip-card", function () {
            $makeupTooltip.stop(true, true).fadeIn(200);
          });

          $(document).on("mouseleave", ".makeup-tooltip-card", function () {
            $makeupTooltip.fadeOut(200, function () {
              $makeupTooltip.remove();
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

    // Restore highlighted slot if it existed before render
    if (highlightedSlotInfo) {
      const $dayInner = $(
        `.day-inner[data-date="${highlightedSlotInfo.date}"]`,
      );
      if ($dayInner.length) {
        const $slots = $dayInner.find(".slots > div");
        const $targetSlot = $slots.eq(highlightedSlotInfo.index);
        if ($targetSlot.length) {
          $targetSlot.addClass("cohort-slot-highlight");
          window._lastCohortSlot = $targetSlot;
          window._lastCohortSlotInfo = highlightedSlotInfo;
        }
      }
    }

    // Restore original events array
    window.events = originalEvents;
  }
  window.renderWeek = renderWeek;

  /* ====== DATE FILTER FUNCTIONALITY ====== */
  // Global state for calendar date filter
  // let selectedDateFilter = null; // stores the selected date in YYYY-MM-DD format
  // let selectedTimeSlotFilter = null; // stores the selected time slot in minutes from midnight
  let selectedDateFilters = []; // array of YYYY-MM-DD
  let selectedTimeSlotFilters = new Set(); // minutes
  let filteringEnabled = false; // toggle state for filters - initially disabled

  // Make these variables globally accessible for applyEventTypeFilter
  window.selectedDateFilters = selectedDateFilters;
  window.selectedTimeSlotFilters = selectedTimeSlotFilters;

  function applyFilters() {
    $(".event").hide();

    const hasDateFilter = selectedDateFilters.length > 0;
    const hasTimeFilter = selectedTimeSlotFilters.size > 0;

    // Get checked event type filters
    const checkedFilters = [];
    $(".events-filter-popover input.ef-input")
      .not("#ef_select_all")
      .each(function () {
        if ($(this).is(":checked")) {
          checkedFilters.push($(this).data("value"));
        }
      });
    const hasEventTypeFilter = checkedFilters.length > 0;

    $(".event").each(function () {
      const $event = $(this);
      const eventDate = $event.data("event-date");
      const eventStart = parseInt($event.data("start"), 10);
      const eventEnd = parseInt($event.data("end"), 10);

      if (isNaN(eventStart) || isNaN(eventEnd)) return;

      // Check date filter
      let dateMatch = !hasDateFilter || selectedDateFilters.includes(eventDate);

      // Check time slot filter
      let timeMatch = false;
      if (!hasTimeFilter) {
        timeMatch = true;
      } else {
        for (const slotStart of selectedTimeSlotFilters) {
          const slotEnd = slotStart + 60; // 60 minutes per slot
          if (eventStart < slotEnd && eventEnd > slotStart) {
            timeMatch = true;
            break;
          }
        }
      }

      // Check event type filter if any are selected
      let eventTypeMatch = true;
      if (hasEventTypeFilter) {
        const classType = $event.data("class-type") || "";
        const source = $event.data("source") || "";
        const selectedTeachers = window.calendarFilterState
          ? window.calendarFilterState.getSelectedTeachers()
          : [];
        const isSingleTeacher = selectedTeachers.length === 1;

        eventTypeMatch = false;

        if (checkedFilters.includes("cohorts")) {
          if (
            !classType ||
            (classType !== "one2one_weekly" &&
              classType !== "one2one_single" &&
              classType !== "peertalk" &&
              classType !== "conference" &&
              classType !== "teacher_timeoff" &&
              classType !== "availability" &&
              classType !== "extra_slot" &&
              source !== "peertalk" &&
              source !== "conference" &&
              source !== "teacher_timeoff" &&
              source !== "availability" &&
              source !== "extra_slot")
          ) {
            eventTypeMatch = true;
          }
        }

        if (checkedFilters.includes("one1")) {
          if (
            classType === "one2one_weekly" ||
            classType === "one2one_single"
          ) {
            eventTypeMatch = true;
          }
        }

        if (checkedFilters.includes("peertalk")) {
          if (classType === "peertalk" || source === "peertalk") {
            eventTypeMatch = true;
          }
        }

        if (checkedFilters.includes("conference")) {
          if (classType === "conference" || source === "conference") {
            eventTypeMatch = true;
          }
        }

        if (checkedFilters.includes("timeoff")) {
          if (classType === "teacher_timeoff" || source === "teacher_timeoff") {
            eventTypeMatch = true;
          }
        }

        if (checkedFilters.includes("extraslots")) {
          if (
            !isSingleTeacher &&
            (classType === "extra_slot" || source === "extra_slot")
          ) {
            eventTypeMatch = true;
          }
        }

        if (checkedFilters.includes("availability")) {
          if (
            !isSingleTeacher &&
            (classType === "availability" || source === "availability")
          ) {
            eventTypeMatch = true;
          }
        }
      }

      // Show event only if it matches all active filters
      if (dateMatch && timeMatch && eventTypeMatch) $event.show();
    });

    // Also update white slots if single teacher
    const selectedTeachers = window.calendarFilterState
      ? window.calendarFilterState.getSelectedTeachers()
      : [];
    const isSingleTeacher = selectedTeachers.length === 1;
    if (isSingleTeacher && typeof applyEventTypeFilter === "function") {
      // applyEventTypeFilter will handle white slots
      setTimeout(() => {
        if (typeof applyEventTypeFilter === "function") {
          applyEventTypeFilter();
        }
      }, 0);
    }
  }

  // Expose applyFilters globally
  window.applyFilters = applyFilters;

  // Function to filter events by selected date
  // Function to reset date filter
  function clearDateFilter() {
    selectedDateFilters = [];
    window.selectedDateFilters = selectedDateFilters;
    $("#head .day-h").removeClass("date-filter-active");
    applyFilters();
    // Also trigger event type filter to update
    if (typeof applyEventTypeFilter === "function") {
      applyEventTypeFilter();
    }
  }

  function clearTimeSlotFilter() {
    selectedTimeSlotFilters.clear();
    window.selectedTimeSlotFilters = selectedTimeSlotFilters;
    $(".time-row").removeClass("time-slot-filter-active");
    applyFilters();
    // Also trigger event type filter to update
    if (typeof applyEventTypeFilter === "function") {
      applyEventTypeFilter();
    }
  }

  // Add click handler to calendar header date elements
  $(document).on("click", "#head .day-h", function () {
    if (!filteringEnabled) return;

    const $dayHeader = $(this);
    const dayIndex = $("#head .day-h").index($dayHeader);
    const d = new Date(currentWeekStart);
    d.setDate(d.getDate() + dayIndex);
    const fullDate = window.ymd(d); // YYYY-MM-DD

    const idx = selectedDateFilters.indexOf(fullDate);
    if (idx > -1) {
      selectedDateFilters.splice(idx, 1);
      $dayHeader.removeClass("date-filter-active");
    } else {
      selectedDateFilters.push(fullDate);
      $dayHeader.addClass("date-filter-active");
    }

    window.selectedDateFilters = selectedDateFilters;
    applyFilters();
    // Also trigger event type filter to update
    if (typeof applyEventTypeFilter === "function") {
      applyEventTypeFilter();
    }
  });

  // Add click handler to time slot elements - improved version
  $(document).on("click", ".time-label", function (event) {
    event.stopPropagation();

    // Check if filtering is enabled
    if (!filteringEnabled) {
      return;
    }

    console.log("TIME LABEL CLICKED - Handler triggered");

    const $timeLabel = $(this);
    const labelText = $timeLabel.text().trim();

    console.log("Text content:", labelText);

    // Parse time from text like "2:00 PM"
    let timeMinutes = null;

    // Remove any whitespace and special characters
    const cleanText = labelText.replace(/\s+/g, " ");
    console.log("Clean text:", cleanText);

    // Extract hours, minutes, and period
    const parts = cleanText.match(/(\d+):(\d+)\s+(AM|PM)/i);

    if (parts && parts.length >= 4) {
      let h = parseInt(parts[1], 10);
      const m = parseInt(parts[2], 10);
      const period = parts[3].toUpperCase();

      console.log(
        "Extracted: hours=" + h + ", minutes=" + m + ", period=" + period,
      );

      // Convert to 24-hour format
      if (period === "PM" && h !== 12) h += 12;
      if (period === "AM" && h === 12) h = 0;

      timeMinutes = h * 60 + m;
      console.log("Converted to minutes:" + timeMinutes);
    } else {
      console.log("NO MATCH - could not parse time label");
      return;
    }

    console.log("Final time minutes:", timeMinutes);

    if (isNaN(timeMinutes)) {
      console.error("ERROR: timeMinutes is NaN");
      return;
    }

    const $timeRow = $timeLabel.closest(".time-row");

    // Find the hour block (the time-row with the hour label at m % 60 === 0)
    const $hourBlock = $timeRow;

    // Check if same slot already selected
    if (selectedTimeSlotFilters.has(timeMinutes)) {
      // TOGGLE OFF
      selectedTimeSlotFilters.delete(timeMinutes);
      $hourBlock.removeClass("time-slot-filter-active");
    } else {
      // TOGGLE ON
      selectedTimeSlotFilters.add(timeMinutes);
      $hourBlock.addClass("time-slot-filter-active");
    }

    window.selectedTimeSlotFilters = selectedTimeSlotFilters;
    applyFilters();
    // Also trigger event type filter to update
    if (typeof applyEventTypeFilter === "function") {
      applyEventTypeFilter();
    }
  });

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

  // Toggle filter functionality
  $(document).on("change", "#filterToggle", function () {
    filteringEnabled = $(this).is(":checked");
    console.log("Filtering enabled:", filteringEnabled);

    // Add or remove filtering-enabled class to body for hover effects
    if (filteringEnabled) {
      $("body").addClass("filtering-enabled");
    } else {
      $("body").removeClass("filtering-enabled");
      // Clear all active filters
      clearDateFilter();
      clearTimeSlotFilter();
      $(".event").show();
      $(".time-row").removeClass("time-slot-filter-active");
      $("#head .day-h").removeClass("date-filter-active");
    }
  });
});

//from calender admin php

document.addEventListener("DOMContentLoaded", () => {
  const API_BASE = "ajax/calendar_admin_filters.php";

  // Elements
  const teacherTrigger = document.getElementById("teacher-search-trigger");
  const teacherWidget = document.getElementById("search-teacher");
  const teacherFieldset = teacherWidget
    ? teacherWidget.querySelector(".teacher-list-form fieldset")
    : null;
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
  const studentFieldset = studentWidget
    ? studentWidget.querySelector(".student-list-form fieldset")
    : null;
  const studentDisplayText = document.getElementById("student-display-text");
  const studentPillsContainer = document.getElementById("student-pills");
  const studentSearchInput = document.getElementById("student-search-input");

  // State
  let selectedTeacherIds = [];
  let selectedCohortIds = []; // Changed from single to array
  let selectedStudentIds = [];
  let teacherStudentsCache = []; // Store students array for teachers

  // ---------- helpers ----------

  // fetchJSON is now in js/api_utils.js
  // Using: fetchJSON() from api_utils.js
  // For backward compatibility, use global fetchJSON if available, otherwise fallback
  async function fetchJSON(url) {
    if (window.fetchJSON && window.fetchJSON !== fetchJSON) {
      // Use centralized version
      return window.fetchJSON(url);
    }
    // Fallback implementation
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

  // Loader functions are now in js/loader_utils.js
  // Using: showGlobalLoader() and hideGlobalLoader() from loader_utils.js
  // If loader_utils.js is not loaded, fallback to local implementation
  if (!window.showGlobalLoader || !window.hideGlobalLoader) {
    console.warn("loader_utils.js not loaded, using fallback implementation");
    let __loaderShownAt = 0;
    let __loaderHideTimer = null;
    const __LOADER_MIN_MS = 3000;

    function __setLoaderDisplay(display) {
      try {
        const el = document.getElementById("loader");
        if (el) {
          el.style.display = display;
          if (display === "flex") {
            el.style.zIndex = "99999";
          }
        }
        if (window.$) {
          window.$("#loader").css({
            "display": display,
            "z-index": display === "flex" ? "99999" : "auto",
          });
        }
      } catch (e) {
        console.warn("__setLoaderDisplay error:", e);
      }
    }

    function showGlobalLoader() {
      if (__loaderHideTimer) {
        clearTimeout(__loaderHideTimer);
        __loaderHideTimer = null;
      }
      __setLoaderDisplay("flex");
      __loaderShownAt = Date.now();
      console.log("Loader shown at:", __loaderShownAt);
    }

    function hideGlobalLoader() {
      const elapsed = __loaderShownAt
        ? Date.now() - __loaderShownAt
        : __LOADER_MIN_MS;
      function doHide() {
        __setLoaderDisplay("none");
        __loaderShownAt = 0;
        __loaderHideTimer = null;
        console.log("Loader hidden");
      }
      if (elapsed >= __LOADER_MIN_MS) {
        doHide();
      } else {
        __loaderHideTimer = setTimeout(doHide, __LOADER_MIN_MS - elapsed);
      }
    }

    window.showGlobalLoader = showGlobalLoader;
    window.hideGlobalLoader = hideGlobalLoader;
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
        // Show dot only if more than 1 teacher will be selected
        if (colorDot)
          colorDot.style.display =
            selectedTeacherIds.length > 1 ? "inline-block" : "none";
      } else {
        selectedTeacherIds = selectedTeacherIds.filter((x) => x !== id);
        wrap.classList.remove("selected");
        if (colorDot) colorDot.style.display = "none";
      }

      // Save teacher ID to session storage only if exactly 1 teacher is selected
      if (selectedTeacherIds.length === 1) {
        sessionStorage.setItem("selectedTeacherId", selectedTeacherIds[0]);
        console.log(
          "Single teacher selected. Saved to session storage:",
          selectedTeacherIds[0],
        );
      } else {
        sessionStorage.removeItem("selectedTeacherId");
        console.log(
          "Multiple or no teachers selected. Cleared session storage.",
        );
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
      "selected-teachers-container",
    );
    clear(selectedTeachersContainer);

    if (!selectedTeacherIds.length) {
      teacherDisplayText.textContent = "Select Teachers";
      selectedTeachersContainer.style.display = "none";
      return;
    }

    // Update color dot visibility for all teacher options based on selection count
    const showDots = selectedTeacherIds.length > 1;
    teacherFieldset.querySelectorAll(".teacher-option").forEach((opt) => {
      const colorDot = opt.querySelector(".teacher-color-dot");
      const checkbox = opt.querySelector(".teacher-checkbox");
      if (colorDot && checkbox && checkbox.checked) {
        colorDot.style.display = showDots ? "inline-block" : "none";
      }
    });

    teacherDisplayText.textContent = "";
    selectedTeachersContainer.style.display = "flex";

    selectedTeacherIds.forEach((id) => {
      const opt = teacherFieldset.querySelector(
        `.teacher-option[data-teacher-id="${id}"]`,
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
      const closeBtn = dropdownPill.querySelector(".pill-close-btn");
      if (closeBtn) {
        closeBtn.addEventListener("click", (e) => {
          e.stopPropagation();

          // Remove from selected array
          selectedTeacherIds = selectedTeacherIds.filter((x) => x !== id);

          // Update the checkbox in the current list immediately
          const currentOption = teacherFieldset.querySelector(
            `.teacher-option[data-teacher-id="${id}"]`,
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
      }
      selectedTeachersContainer.appendChild(dropdownPill);
    });

    // ---------- Compact top summary (trigger view) ----------
    // const maxAvatars = 5; // remove this
    const visibleTeachers = selectedTeacherIds; // show all

    visibleTeachers.forEach((id, idx) => {
      const opt = teacherFieldset.querySelector(
        `.teacher-option[data-teacher-id="${id}"]`,
      );
      if (!opt) return;

      const avatar = opt.dataset.teacherImg || "./img/default-avatar.svg";
      const img = document.createElement("img");
      img.src = avatar;
      img.alt = opt.dataset.teacherName || "";
      img.className = "teacher-summary-avatar";

      // Higher z-index for earlier avatars (so they stack nicely)
      img.style.zIndex = visibleTeachers.length - idx;

      // Use dynamic teacher color for border
      const teacherColor = getTeacherColor(id);
      img.style.borderColor = teacherColor;

      teacherPillsContainer.appendChild(img);
    });

    // Do NOT append initials or any text
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
        // Only show dot if more than 1 teacher is selected
        if (colorDot)
          colorDot.style.display =
            selectedTeacherIds.length > 1 ? "inline-block" : "none";
      }
    });

    return list;
  }

  // ---------- Cohorts ----------

  function updateCohortPills() {
    // Clear old pills
    if (cohortPillsContainer) clear(cohortPillsContainer);

    const selectedCohortsContainer = document.getElementById(
      "selected-cohorts-container",
    );
    const selectedOneOnOneContainer = document.getElementById(
      "oneonone-selected-container",
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
        `.cohort-option[data-cohort-id="${id}"]`,
      );
      let isOneOnOne = false;

      if (!opt && oneOnOneFieldset) {
        opt = oneOnOneFieldset.querySelector(
          `.cohort-option[data-cohort-id="${id}"]`,
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
        const closeBtn = dropdownPill.querySelector(".pill-close-btn");
        if (closeBtn) {
          closeBtn.addEventListener("click", async (e) => {
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
              // Also refresh agenda view
              if (typeof window.refreshAgendaView === "function") {
                window.refreshAgendaView();
              }
            }, 100);
          });
        }
        targetContainer.appendChild(dropdownPill);
      }
    });

    // Top summary (trigger view)
    if (cohortPillsContainer) {
      const namesList = selectedCohortIds
        .map((id) => {
          let opt = cohortFieldset.querySelector(
            `.cohort-option[data-cohort-id="${id}"]`,
          );
          if (!opt && oneOnOneFieldset) {
            opt = oneOnOneFieldset.querySelector(
              `.cohort-option[data-cohort-id="${id}"]`,
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
        const text = document.querySelector(".cohort-pill-container");

        // Create spans for each name, separated by commas
        text.innerHTML = namesList.map((name) => `<p>${name}</p>`).join(", ");
        text.title = fullText; // Show full text on hover
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
    const cohortLabel = c.cohortshortname;

    // Log cohorts being added to dropdown

    wrap.innerHTML = `
            <label class="cohort-label">
                <div class="cohort-details">
                    <span class="cohort-name">${displayName}</span>
                    ${
                      c.cohorttype === "one1one"
                        ? `<span class="cohort-shortname">${cohortLabel}</span>`
                        : ""
                    }
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
        // Also refresh agenda view
        if (typeof window.refreshAgendaView === "function") {
          window.refreshAgendaView();
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
        // Also refresh agenda view
        if (typeof window.refreshAgendaView === "function") {
          window.refreshAgendaView();
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
        '<li style="pointer-events:none;opacity:.6;">No cohorts available</li>',
      );
      return;
    }

    // Add each cohort to the dropdown
    groupCohorts.forEach((cohort) => {
      const cohortName = cohort.name || cohort.idnumber || "";
      const cohortId = cohort.id;
      const cohortIdnumber = cohort.idnumber || "";
      const $li = $(
        `<li class="peertalk_cohort_item" data-id="${cohortId}" data-idnumber="${cohortIdnumber}" data-name="${cohortName}">${cohortName}</li>`,
      );
      $peertalkDropdownList.append($li);
    });

    console.log(
      `Populated ${groupCohorts.length} cohorts in peertalk dropdown`,
    );
  }

  async function loadAllCohorts() {
    clear(cohortFieldset);
    clear(oneOnOneFieldset);
    cohortNoResults.style.display = "none";
    if (oneOnOneNoResults) oneOnOneNoResults.style.display = "none";

    let data;
    if (role === "admin") {
      data = await fetchJSON(`${API_BASE}?action=cohorts`);
    } else if (role === "teacher") {
      data = await fetchJSON(
        `${API_BASE}?action=cohorts&teacherId=${teacherId}`,
      );
    } else if (role === "student") {
      data = await fetchJSON(`${API_BASE}?action=cohorts`);
    }

    console.log("Cohort data fetched:", data);
    if (!data.ok) return [];

    // Store students array if role is teacher
    if (role === "teacher" && data.students) {
      teacherStudentsCache = data.students;
      console.log("Teacher students cached:", teacherStudentsCache);
    }

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
      (c) => c.cohorttype === "one1one",
    );

    // For 1:1 cohorts, also deduplicate by student name to avoid showing same student multiple times
    const uniqueOneOnOne = Array.from(
      new Map(
        oneOnOneCohorts.map((c) => [c.studentname || c.name, c]),
      ).values(),
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
      teacherIds.join(","),
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
      (c) => c.cohorttype === "one1one",
    );

    // For 1:1 cohorts, also deduplicate by student name to avoid showing same student multiple times
    const uniqueOneOnOne = Array.from(
      new Map(
        oneOnOneCohorts.map((c) => [c.studentname || c.name, c]),
      ).values(),
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
    const isOneOnOne = s.group === "1:1";

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
                          ? `<div class="cohort_label_teacher_avatar"><span class="student-type-badge">1:1</span><span class="student-type-badge"><img src="${s.teacheravatar}" alt="Teacher Avatar"></span></div>`
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
        // Also refresh agenda view
        if (typeof window.refreshAgendaView === "function") {
          window.refreshAgendaView();
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
      "selected-students-container",
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
        `.student-option[data-student-id="${id}"]`,
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
      const closeBtn = dropdownPill.querySelector(".pill-close-btn");
      if (closeBtn) {
        closeBtn.addEventListener("click", (e) => {
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
            // Also refresh agenda view
            if (typeof window.refreshAgendaView === "function") {
              window.refreshAgendaView();
            }
          }, 100);
        });
      }

      selectedStudentsContainer.appendChild(dropdownPill);
    });

    // ---------- Compact top summary (trigger view) - Like Teachers ----------

    const visibleStudents = selectedStudentIds;

    visibleStudents.forEach((id, idx) => {
      const opt = studentFieldset.querySelector(
        `.student-option[data-student-id="${id}"]`,
      );
      if (!opt) return;

      const avatar = opt.dataset.studentImg || "./img/default-avatar.svg";
      const img = document.createElement("img");
      img.src = avatar;
      img.alt = opt.dataset.studentName || "";
      img.className = "student-summary-avatar";

      // Optional stacking order
      img.style.zIndex = visibleStudents.length - idx;

      studentPillsContainer.appendChild(img);
    });

    // Do NOT append ellipsis or initials
  }

  async function loadAllStudents() {
    clear(studentFieldset);

    let list = [];

    // If role is teacher, use cached students from cohorts response
    if (role === "teacher" && teacherStudentsCache.length > 0) {
      list = teacherStudentsCache;
    } else {
      // Otherwise fetch students separately
      const data = await fetchJSON(`${API_BASE}?action=students`);
      if (!data.ok) return;
      list = data.data || [];
    }

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
      studentFieldset.appendChild(createStudentOption(s)),
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
      cohortIds.join(","),
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

    // First, fetch events for selected teachers to get accurate data
    if (
      window.fetchCalendarEvents &&
      typeof window.fetchCalendarEvents === "function"
    ) {
      await window.fetchCalendarEvents();
    }

    // Load cohorts for selected teachers
    const cohorts = await loadCohortsForTeachers(selectedTeacherIds, true);

    if (cohorts && cohorts.length) {
      // Use existing events from window.events instead of fetching again
      const eventsData = window.events || [];

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
            (c) => c.cohorttype === "one1one",
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
        // Also refresh agenda view
        if (typeof window.refreshAgendaView === "function") {
          window.refreshAgendaView();
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
        // Also refresh agenda view
        if (typeof window.refreshAgendaView === "function") {
          window.refreshAgendaView();
        }
      }, 100);
    }
  }

  // ---------- Dropdown toggles ----------

  teacherTrigger.addEventListener("click", (e) => {
    e.stopPropagation();

    // Close filter popover when opening teacher dropdown
    if (typeof window.closeFilterPopover === "function") {
      window.closeFilterPopover();
    }

    teacherWidget.style.display =
      teacherWidget.style.display === "none" || !teacherWidget.style.display
        ? "block"
        : "none";
  });

  cohortTrigger.addEventListener("click", (e) => {
    e.stopPropagation();

    // Close filter popover when opening cohort dropdown
    if (typeof window.closeFilterPopover === "function") {
      window.closeFilterPopover();
    }
  });

  studentTrigger.addEventListener("click", (e) => {
    e.stopPropagation();

    // Close filter popover when opening student dropdown
    if (typeof window.closeFilterPopover === "function") {
      window.closeFilterPopover();
    }

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
  async function fetchEventsForTeachers(teacherId) {
    if (!teacherId) return [];

    const rangeEl = document.getElementById("calendar-range");
    if (!rangeEl) return [];

    // Example: "December 8 - 14, 2025"
    const text = rangeEl.textContent.trim();
    const match = text.match(/^([A-Za-z]+)\s+(\d+)\s*-\s*(\d+),\s*(\d{4})$/);

    if (!match) {
      console.error("Invalid calendar range format:", text);
      return [];
    }

    const [, monthName, startDay, endDay, year] = match;

    const startDate = new Date(`${monthName} ${startDay}, ${year}`);
    const endDate = new Date(`${monthName} ${endDay}, ${year}`);

    // Format dates as YYYY-MM-DD using formatYMD() from date_utils.js
    const formattedStartDate = window.formatYMD(startDate);
    const formattedEndDate = window.formatYMD(endDate);

    // Build request payload
    const allEvents = [];

    try {
      // Send request for each teacher
      for (const teacherId of teacherIds) {
        const payload = {
          teacherId: teacherId,
          startDate: formattedStartDate,
          endDate: formattedEndDate,
        };

        const response = await fetch(`ajax/get_user_events.php`, {
          method: "POST",
          credentials: "same-origin",
          headers: {
            "Content-Type": "application/json",
          },
          body: JSON.stringify(payload),
        });

        if (!response.ok) continue;

        const data = await response.json();
        if (data.ok && Array.isArray(data.events)) {
          allEvents.push(...data.events);
        }
      }

      return allEvents;
    } catch (err) {
      console.error("Failed to fetch events for auto-selection:", err);
      return [];
    }
  }

  // Helper function to update students when cohort selection changes
  async function updateStudentsForCohortChange() {
    console.log(
      "updateStudentsForCohortChange: Selected cohorts:",
      selectedCohortIds,
    );

    if (!selectedCohortIds.length) {
      console.log(
        "updateStudentsForCohortChange: No cohorts selected, clearing students",
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
            `.cohort-option[data-cohort-id="${cid}"]`,
          );
          if (option) {
            selected1to1CohortIds.push(cid);
          }
        });

        console.log(
          "updateStudentsForCohortChange: Selected 1:1 cohorts:",
          selected1to1CohortIds,
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
            `.student-option[data-student-id="${sid}"]`,
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
    if (role === "admin") {
      await loadTeachers();
    } else {
      document.querySelector(".teacher-search-dropdown").style.display = "none";
    }

    // Load teachers list only
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
        ".cohort-tab-btn.cohort-tab-active",
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
          oneOnOneFieldset?.querySelectorAll(".cohort-option") || [],
        ).map((opt) => parseInt(opt.dataset.cohortId, 10));
        selectedCohortIds = selectedCohortIds.filter(
          (id) => !oneOnOneIds.includes(id),
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
          // Also refresh agenda view
          if (typeof window.refreshAgendaView === "function") {
            window.refreshAgendaView();
          }
        }, 100);
      } catch (err) {
        console.error("Student reset error:", err);
      }
    });
  }
});

(function () {
  const API_EVENTS = "ajax/get_user_events.php";

  // ---------------- Week range helpers ----------------

  // getWeekStart() and getWeekEnd() are now in js/date_utils.js
  // Using: getWeekStart() and getWeekEnd() from date_utils.js
  function getWeekStart(date) {
    if (window.getWeekStart) {
      return window.getWeekStart(date);
    }
    // Fallback
    const d = new Date(date.getFullYear(), date.getMonth(), date.getDate());
    const day = d.getDay(); // 0 (Sun) - 6 (Sat)
    const diff = (day === 0 ? -6 : 1) - day; // make Monday = 1
    d.setDate(d.getDate() + diff);
    d.setHours(0, 0, 0, 0);
    return d;
  }

  function getWeekEnd(startDate) {
    if (window.getWeekEnd) {
      return window.getWeekEnd(startDate);
    }
    // Fallback
    const d = new Date(startDate.getTime());
    d.setDate(d.getDate() + 6);
    d.setHours(23, 59, 59, 999);
    return d;
  }

  // Using formatYMD() from date_utils.js

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
        ".teacher-option.selected, .teacher-option input.teacher-checkbox:checked",
      ),
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
        ".cohort-option.selected, .cohort-option input.cohort-checkbox:checked",
      ),
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
        ".student-option.selected, .student-option input.student-checkbox:checked",
      ),
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
  // for just bug
  const DAY_NAME_TO_INDEX1 = {
    sunday: 0,
    monday: 1,
    tuesday: 2,
    wednesday: 3,
    thursday: 4,
    friday: 5,
    saturday: 6,
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
    activeTeacherIds = [],
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
          DAY_NAME_TO_INDEX1[String(slot.day || "").toLowerCase()];
        if (typeof dayIndex !== "number") return;

        const dayDate = new Date(baseDate);
        dayDate.setDate(baseDate.getDate() + dayIndex);

        const startMin = normalizeMinutes(slot.startTime);
        const endMin = normalizeMinutes(slot.endTime);
        if (startMin === null || endMin === null) return;

        whiteSlotRules.push({
          date: window.ymd(dayDate),
          dayIndex,
          start: startMin,
          end: endMin,
          teacherid: tid,
          source: "availability",
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
          date: window.ymd(startDate),
          dayIndex: (startDate.getDay() + 6) % 7,
          start: startMin,
          end: endMin,
          teacherid: tid,
          source: "extra_slot",
        });
      });
    });
  }

  function minutesToHHMM(mins) {
    const h = Math.floor(mins / 60);
    const m = mins % 60;
    return `${String(h).padStart(2, "0")}:${String(m).padStart(2, "0")}`;
  }

  function buildAvailabilityEvents(
    availabilityMap = {},
    activeTeacherIds = [],
    weekStart,
    weekEnd,
  ) {
    const events = [];
    const addedIds = new Set(); // Track added availability IDs to prevent duplicates
    const teachers =
      activeTeacherIds && activeTeacherIds.length > 0
        ? activeTeacherIds
        : Object.keys(availabilityMap);

    if (!teachers || teachers.length === 0) return events;

    const baseDate = weekStart || currentStart || new Date();

    teachers.forEach((tid) => {
      const slots = getSlotsForTeacher(availabilityMap, tid);
      slots.forEach((slot) => {
        // Skip if this availability ID was already added
        if (slot.id && addedIds.has(slot.id)) {
          return;
        }

        const startMin = normalizeMinutes(slot.startTime);
        const endMin = normalizeMinutes(slot.endTime);
        if (startMin === null || endMin === null) return;

        // Determine the event date using the declared day; respect startDate as the earliest allowed occurrence.
        const dateStr = (() => {
          const startDateObj = slot.startDate
            ? new Date(`${slot.startDate}T00:00:00`)
            : null;

          const dayIndex =
            DAY_NAME_TO_INDEX[String(slot.day || "").toLowerCase()];
          if (typeof dayIndex === "number") {
            const candidate = new Date(baseDate);
            candidate.setDate(baseDate.getDate() + dayIndex);

            // If this candidate week is before the startDate, skip this week
            if (startDateObj && candidate < startDateObj) return null;

            return window.ymd(candidate);
          }

          // Fallback to startDate weekday if day is missing
          if (startDateObj && !Number.isNaN(startDateObj.getTime())) {
            const startDayIdx = (startDateObj.getDay() + 6) % 7;
            const candidate = new Date(baseDate);
            candidate.setDate(baseDate.getDate() + startDayIdx);
            if (candidate < startDateObj) return null;
            return window.ymd(candidate);
          }

          // Last resort: use base date
          return window.ymd(baseDate);
        })();

        // If dateStr is null (week is before startDate), skip this slot for this week
        if (!dateStr) return;

        const startStr = minutesToHHMM(startMin);
        const endStr = minutesToHHMM(endMin);

        const teacherColor = getTeacherColor(tid);
        const bg = teacherColor.replace("50%", "95%");

        // Check if dateStr matches the day name
        if (slot.day) {
          const dateObj = new Date(dateStr);
          const dayNames = [
            "Sunday",
            "Monday",
            "Tuesday",
            "Wednesday",
            "Thursday",
            "Friday",
            "Saturday",
          ];
          const actualDay = dayNames[dateObj.getDay()];
          if (actualDay !== slot.day) {
            console.warn(
              `Availability slot day mismatch: dateStr=${dateStr} is ${actualDay}, but slot.day=${slot.day}`,
            );
          }
        }
        events.push({
          start: `${dateStr}T${startStr}:00`,
          end: `${dateStr}T${endStr}:00`,
          date: dateStr, // Ensure event.date matches slot.startDate
          title: slot.title || "Availability",
          classType: "availability",
          source: "availability",
          teacherids: [Number(tid) || tid],
          teacherid: Number(tid) || tid,
          color: "e-availability",
          style: `border: 1px dashed ${teacherColor}; background-color: ${bg};`,
          availabilityId: slot.id, // Store the availability ID
          day: slot.day || null,
        });

        // Mark this availability ID as added
        if (slot.id) {
          addedIds.add(slot.id);
        }
      });
    });

    return events;
  }

  function buildExtraSlotEvents(
    extraSlotMap = {},
    activeTeacherIds = [],
    weekStart,
    weekEnd,
  ) {
    const events = [];
    const teachers =
      activeTeacherIds && activeTeacherIds.length > 0
        ? activeTeacherIds
        : Object.keys(extraSlotMap);

    if (!teachers || teachers.length === 0) return events;

    const baseMs = (weekStart || currentStart || new Date()).getTime();
    const weekEndMs =
      weekEnd && weekEnd.getTime
        ? weekEnd.getTime()
        : baseMs + 6 * 24 * 60 * 60 * 1000;

    teachers.forEach((tid) => {
      const slots = getSlotsForTeacher(extraSlotMap, tid);
      slots.forEach((slot) => {
        const startMs = slot.start ? Date.parse(slot.start) : null;
        const endMs = slot.end ? Date.parse(slot.end) : null;
        if (!startMs || !endMs) return;
        if (endMs <= startMs) return;
        if (startMs < baseMs || startMs > weekEndMs) return;

        const teacherColor = getTeacherColor(tid);
        const bg = teacherColor.replace("50%", "92%");

        events.push({
          start: slot.start,
          end: slot.end,
          title: slot.title || "Extra Slot",
          classType: "extra_slot",
          source: "extra_slot",
          teacherids: [Number(tid) || tid],
          teacherid: Number(tid) || tid,
          color: "e-extra-slot",
          style: `border: 1px solid ${teacherColor}; background-color: ${bg};`,
        });
      });
    });

    return events;
  }

  // ---------------- API Response Parsing Functions ----------------

  /**
   * Parse and transform events_one_on_one from API response
   * @param {Array} eventsOneOnOne - Array of one-on-one event objects from API
   * @returns {Array} - Transformed events array compatible with calendar rendering
   */
  function parseOneOnOneEvents(eventsOneOnOne) {
    if (!Array.isArray(eventsOneOnOne)) {
      console.warn("parseOneOnOneEvents: Invalid input, expected array");
      return [];
    }

    const transformedEvents = [];

    eventsOneOnOne.forEach((item) => {
      // Skip items that don't have the expected structure
      if (!item || !item.ok || !item.event || !item.summary) {
        console.warn("parseOneOnOneEvents: Skipping invalid item:", item);
        return;
      }

      const eventData = item.event;
      const summary = item.summary.current || item.summary;

      // Validate required fields
      if (!eventData.eventdate || !eventData.start_time) {
        console.warn("parseOneOnOneEvents: Event missing required fields:", eventData);
        return;
      }

      // Calculate end time from start_time + duration_minutes
      let endTime = eventData.end_time || null;
      if (eventData.duration_minutes) {
        const durationMinutes = parseInt(eventData.duration_minutes, 10);
        if (!isNaN(durationMinutes) && durationMinutes > 0) {
          const startMinutes = timeToMinutes(eventData.start_time);
          if (!isNaN(startMinutes)) {
            const endMinutes = startMinutes + durationMinutes;
            endTime = minutesToTime(endMinutes);
          }
        }
      }

      // Fallback to end_time if duration calculation didn't work
      if (!endTime) {
        endTime = eventData.end_time;
      }

      // Final validation
      if (!endTime) {
        console.warn(
          "parseOneOnOneEvents: Event missing end_time and duration_minutes:",
          eventData,
        );
        return;
      }

      // Build start and end times in ISO format
      const startISO = `${eventData.eventdate}T${eventData.start_time}`;
      const endISO = `${eventData.eventdate}T${endTime}`;

      // Map classType: "weekly" to "one2one_weekly", "single" to "one2one_single"
      let classType = "1:1";
      let class_type = "one2one_single";
      if (eventData.classType === "weekly") {
        classType = "one2one_weekly";
        class_type = "one2one_weekly";
      } else if (eventData.classType === "single") {
        classType = "one2one_single";
        class_type = "one2one_single";
      }

      // Build student arrays for compatibility
      const studentids = eventData.student
        ? [Number(eventData.student.id)]
        : [];
      const studentnames = eventData.student
        ? [eventData.student.name]
        : [];
      const studentavatar =
        eventData.student && eventData.student.avatar
          ? [eventData.student.avatar]
          : [];

      // Build title
      let title = "";
      if (summary && summary.teacher && eventData.student) {
        title = `${summary.teacher.name} - ${eventData.student.name}`;
      } else if (eventData.student) {
        title = eventData.student.name;
      } else if (summary && summary.teacher) {
        title = summary.teacher.name;
      }

      // Extract status information
      const statuses = [];
      if (summary && summary.status) {
        statuses.push({
          code: summary.status,
          isactive: true,
          details: null,
          time: Date.now() / 1000, // Current timestamp as fallback
        });
      }

      // Build the transformed event object
      const transformedEvent = {
        eventid: eventData.eventid,
        start: startISO,
        end: endISO,
        date: eventData.eventdate,
        title: title,
        teacherids:
          summary && summary.teacher ? [Number(summary.teacher.id)] : [],
        teacherid:
          summary && summary.teacher ? Number(summary.teacher.id) : null,
        teacher_id:
          summary && summary.teacher ? Number(summary.teacher.id) : null,
        studentid: eventData.student
          ? Number(eventData.student.id)
          : null,
        student: eventData.student || null,
        studentids: studentids,
        studentnames: studentnames,
        studentavatar: studentavatar,
        status: summary ? summary.status : null,
        statuses: statuses,
        classType: classType,
        class_type: class_type,
        googlemeetid: eventData.googlemeetid,
        duration_minutes: eventData.duration_minutes,
        teacher: summary && summary.teacher ? summary.teacher : null,
        history:
          item.history && item.history.timeline
            ? item.history.timeline
            : [],
        summary: item.summary || null,
        source: "one_on_one",
        // Add previous status information for reschedule detection
        previous: item.summary && item.summary.previous ? item.summary.previous : null,
      };

      transformedEvents.push(transformedEvent);
    });

    return transformedEvents;
  }

  /**
   * Parse and transform events_group from API response
   * @param {Array} eventsGroup - Array of group event objects from API
   * @returns {Array} - Transformed events array compatible with calendar rendering
   */
  function parseGroupEvents(eventsGroup) {
    if (!Array.isArray(eventsGroup)) {
      console.warn("parseGroupEvents: Invalid input, expected array");
      return [];
    }

    const transformedEvents = [];

    eventsGroup.forEach((item) => {
      // Skip invalid items
      if (!item || !item.eventid) {
        console.warn("parseGroupEvents: Skipping invalid item:", item);
        return;
      }

      // Extract date from start timestamp or start string
      let eventDate = null;
      if (item.start) {
        if (typeof item.start === "string") {
          // Extract date from ISO string (YYYY-MM-DDTHH:mm:ss-TZ:00)
          const dateMatch = item.start.match(/^(\d{4}-\d{2}-\d{2})/);
          if (dateMatch) {
            eventDate = dateMatch[1];
          }
        }
      } else if (item.start_ts) {
        // Convert timestamp to date string
        const date = new Date(item.start_ts * 1000);
        eventDate = formatYMD(date);
      }

      if (!eventDate) {
        console.warn("parseGroupEvents: Could not extract date from item:", item);
        return;
      }

      // Build the transformed event object
      const transformedEvent = {
        id: item.id || `group-${item.eventid}`,
        eventid: item.eventid,
        main_event_id: item.main_event_id || item.eventid,
        is_parent: item.is_parent || false,
        sequence: item.sequence || 1,
        source: item.source || "group",
        courseid: item.courseid || null,
        cmid: item.cmid || null,
        googlemeetid: item.googlemeetid || null,
        title: item.title || "Untitled Event",
        start_ts: item.start_ts || null,
        end_ts: item.end_ts || null,
        start: item.start || null,
        end: item.end || null,
        date: eventDate,
        teacherids: Array.isArray(item.teacherids) ? item.teacherids : [],
        teacherpic: item.teacherpic || null,
        teachernames: Array.isArray(item.teachernames) ? item.teachernames : [],
        studentids: Array.isArray(item.studentids) ? item.studentids : [],
        studentnames: Array.isArray(item.studentnames) ? item.studentnames : [],
        cohortids: Array.isArray(item.cohortids) ? item.cohortids : [],
        class_type: item.class_type || "main",
        classType: item.class_type || "main",
        is_recurring: item.is_recurring || false,
        meetingurl: item.meetingurl || null,
        viewurl: item.viewurl || null,
        statuses: Array.isArray(item.statuses) ? item.statuses : [],
        rescheduled: item.rescheduled || { status: "no" },
      };

      // Extract teacher ID for compatibility
      if (transformedEvent.teacherids.length > 0) {
        transformedEvent.teacherid = transformedEvent.teacherids[0];
        transformedEvent.teacher_id = transformedEvent.teacherids[0];
      }

      transformedEvents.push(transformedEvent);
    });

    return transformedEvents;
  }

  /**
   * Parse API response structure and return all events in unified format
   * @param {Object} data - API response object
   * @returns {Array} - Array of all transformed events
   */
  function parseApiResponse(data) {
    if (!data || !data.ok) {
      console.warn("parseApiResponse: Invalid or unsuccessful response:", data);
      return [];
    }

    let allEvents = [];

    // Parse one-on-one events
    if (Array.isArray(data.events_one_on_one)) {
      console.log("Parsing events_one_on_one:", data.events_one_on_one.length);
      const oneOnOneEvents = parseOneOnOneEvents(data.events_one_on_one);
      allEvents = [...allEvents, ...oneOnOneEvents];
    }

    // Parse group events
    if (Array.isArray(data.events_group)) {
      console.log("Parsing events_group:", data.events_group.length);
      const groupEvents = parseGroupEvents(data.events_group);
      allEvents = [...allEvents, ...groupEvents];
    }

    // Also handle legacy data.events format for backward compatibility
    if (Array.isArray(data.events)) {
      console.log("Parsing legacy data.events:", data.events.length);
      // Process events with nested structure (existing logic)
      const legacyEvents = data.events.map((item) => {
        if (item.event && item.summary) {
          // This is already handled by parseOneOnOneEvents, but keep for compatibility
          const eventData = item.event;
          const summary = item.summary.current || item.summary;

          if (!eventData.eventdate || !eventData.start_time) {
            console.warn("Event missing required fields:", eventData);
            return item;
          }

          let endTime = eventData.end_time || null;
          if (eventData.duration_minutes) {
            const durationMinutes = parseInt(eventData.duration_minutes, 10);
            if (!isNaN(durationMinutes) && durationMinutes > 0) {
              const startMinutes = timeToMinutes(eventData.start_time);
              if (!isNaN(startMinutes)) {
                const endMinutes = startMinutes + durationMinutes;
                endTime = minutesToTime(endMinutes);
              }
            }
          }

          if (!endTime) {
            endTime = eventData.end_time;
          }

          if (!endTime) {
            console.warn(
              "Event missing end_time and duration_minutes:",
              eventData,
            );
            return item;
          }

          const startISO = `${eventData.eventdate}T${eventData.start_time}`;
          const endISO = `${eventData.eventdate}T${endTime}`;

          let classType = "1:1";
          let class_type = "one2one_single";
          if (eventData.classType === "weekly") {
            classType = "one2one_weekly";
            class_type = "one2one_weekly";
          } else if (eventData.classType === "single") {
            classType = "one2one_single";
            class_type = "one2one_single";
          }

          const studentids = eventData.student
            ? [Number(eventData.student.id)]
            : [];
          const studentnames = eventData.student
            ? [eventData.student.name]
            : [];
          const studentavatar =
            eventData.student && eventData.student.avatar
              ? [eventData.student.avatar]
              : [];

          let title = "";
          if (summary && summary.teacher && eventData.student) {
            title = `${summary.teacher.name} - ${eventData.student.name}`;
          } else if (eventData.student) {
            title = eventData.student.name;
          } else if (summary && summary.teacher) {
            title = summary.teacher.name;
          }

          return {
            eventid: eventData.eventid,
            start: startISO,
            end: endISO,
            date: eventData.eventdate,
            title: title,
            teacherids:
              summary && summary.teacher ? [Number(summary.teacher.id)] : [],
            teacherid:
              summary && summary.teacher ? Number(summary.teacher.id) : null,
            teacher_id:
              summary && summary.teacher ? Number(summary.teacher.id) : null,
            studentid: eventData.student
              ? Number(eventData.student.id)
              : null,
            student: eventData.student || null,
            studentids: studentids,
            studentnames: studentnames,
            studentavatar: studentavatar,
            status: summary ? summary.status : null,
            classType: classType,
            class_type: class_type,
            googlemeetid: eventData.googlemeetid,
            duration_minutes: eventData.duration_minutes,
            teacher: summary && summary.teacher ? summary.teacher : null,
            history:
              item.history && item.history.timeline
                ? item.history.timeline
                : [],
            summary: item.summary || null,
          };
        }
        return item;
      });
      allEvents = [...allEvents, ...legacyEvents];
    }

    return allEvents;
  }

  // ---------------- API call ----------------

  async function fetchCalendarEvents(skipLoaderShow = false) {
    const teacherid = getSelectedTeacherIds();
    const cohortids = getSelectedCohortIds();
    const studentids = getSelectedStudentIds();

    // Use currentWeekStart if available, otherwise fall back to currentStart
    const weekStart =
      window.currentWeekStart || currentStart || getWeekStart(new Date());
    const weekEnd = getWeekEnd(weekStart);

    // Build JSON payload
    const payload = {
      startDate: window.formatYMD(weekStart),
      endDate: window.formatYMD(weekEnd),
    };

    if (teacherid && teacherid.length > 0) payload.teacherId = teacherid;
    if (cohortids && cohortids.length > 0) payload.cohortIds = cohortids;
    if (studentids && studentids.length > 0) payload.studentIds = studentids;

    // Show loader immediately unless told to skip (when called from refetchCustomPluginData)
    if (!skipLoaderShow) {
      try {
        console.log("fetchCalendarEvents: Showing loader");
        if (window.showGlobalLoader) {
          window.showGlobalLoader();
        } else {
          const loaderEl = document.getElementById("loader");
          if (loaderEl) {
            loaderEl.style.display = "flex";
            loaderEl.style.zIndex = "99999";
          } else if (window.$) {
            window.$("#loader").css({ "display": "flex", "z-index": "99999" });
          }
        }
      } catch (e) {
        console.warn("Could not show loader:", e);
      }
    } else {
      console.log("fetchCalendarEvents: Skipping loader show (already shown)");
    }

    try {
      const response = await fetch(API_EVENTS, {
        method: "POST",
        credentials: "same-origin",
        headers: {
          "Content-Type": "application/json",
        },
        body: JSON.stringify(payload),
      });

      if (!response.ok) {
        console.error("get_user_events.php HTTP error", response.status);
        // Don't return early - let finally block handle loader hiding
        return;
      }

      const data = await response.json();
      console.log("Fetched calendar events:", data);

      if (data.ok) {
        updateWhiteSlotRules(
          data.teacher_availability || {},
          data.teacher_extra_slots || {},
          teacherid,
        );
      } else {
        whiteSlotRules = [];
      }

      window.teacherExtraSlots =
        data && data.ok && data.teacher_extra_slots
          ? data.teacher_extra_slots
          : {};
      document.dispatchEvent(
        new CustomEvent("extraSlotsUpdated", {
          detail: { map: window.teacherExtraSlots },
        }),
      );

      // Parse API response structure (events_one_on_one, events_group, and legacy data.events)
      let allEvents = parseApiResponse(data);
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
              start_ts: item.start_ts,
              end_ts: item.end_ts,
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

      // Availability and extra slots as events
      if (data.ok) {
        const availabilityEvents = buildAvailabilityEvents(
          data.teacher_availability || {},
          teacherid,
          currentStart,
          currentEnd,
        );
        const extraSlotEvents = buildExtraSlotEvents(
          data.teacher_extra_slots || {},
          teacherid,
          currentStart,
          currentEnd,
        );
        allEvents = [...allEvents, ...availabilityEvents, ...extraSlotEvents];
      }

      // Optimization: Use a map for teacher ID lookups
      const teacherIdSet = teacherid ? new Set([teacherid]) : null;
      window.events = [];
      for (let i = 0; i < allEvents.length; i++) {
        const ev = allEvents[i];

        // Extract date directly from the string to avoid timezone conversion issues
        let eventDateStr = null;
        if (
          ev.start &&
          typeof ev.start === "string" &&
          ev.start.includes("T")
        ) {
          eventDateStr = ev.start.split("T")[0]; // Get YYYY-MM-DD directly from string
        }

        // Only parse dates once
        const startDate = new Date(ev.start);
        const endDate = new Date(ev.end);
        // Fast teacherId lookup
        let teacherId = null;
        if (teacherIdSet) {
          let eventTeacherIds = Array.isArray(ev.teacherids)
            ? ev.teacherids
            : ev.teacher_id
              ? [ev.teacher_id]
              : ev.teacherid
                ? [ev.teacherid]
                : [];
          for (let tid of eventTeacherIds) {
            if (teacherIdSet.has(tid)) {
              teacherId = tid;
              break;
            }
          }
          if (!teacherId && eventTeacherIds.length > 0)
            teacherId = eventTeacherIds[0];
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
        let eventStart, eventEnd;
        if (
          ev.source === "teacher_timeoff" ||
          ev.classType === "teacher_timeoff"
        ) {
          if (ev.start_ts && ev.end_ts) {
            const startDate_ts = new Date(ev.start_ts * 1000);
            const endDate_ts = new Date(ev.end_ts * 1000);
            eventStart = startDate_ts.toTimeString().slice(0, 5);
            eventEnd = endDate_ts.toTimeString().slice(0, 5);
          } else {
            eventStart = "00:00";
            eventEnd = "23:59";
          }
        } else {
          if (ev.start && ev.start.includes("T")) {
            eventStart = ev.start.split("T")[1].slice(0, 5);
          } else {
            eventStart = startDate.toTimeString().slice(0, 5);
          }
          if (ev.end && ev.end.includes("T")) {
            eventEnd = ev.end.split("T")[1].slice(0, 5);
          } else {
            eventEnd = endDate.toTimeString().slice(0, 5);
          }
        }
        // Use the date extracted directly from the string (no timezone conversion)
        // If we couldn't extract it, fall back to local date components
        const localYMD =
          eventDateStr ||
          startDate.getFullYear() +
            "-" +
            String(startDate.getMonth() + 1).padStart(2, "0") +
            "-" +
            String(startDate.getDate()).padStart(2, "0");

        const eventObj = {
          date: localYMD,
          title: ev.title || "",
          start: eventStart,
          end: eventEnd,
          color: eventColor,
          repeat:
            typeof ev.is_recurring !== "undefined"
              ? ev.is_recurring
              : ev.repeat || false,
          meetingurl: ev.meetingurl || "",
          viewurl: ev.viewurl || ev.meetingurl || "",
          avatar:
            // Prefer CURRENT teacher avatar so reassigned lessons show new tutor
            ev.summary?.current?.teacher?.avatar ||
            ev.summary?.current?.teacher_pic ||
            ev.rescheduled?.current?.teacher_pic ||
            ev.teacher_pic ||
            ev.teacherpic ||
            ev.teacher?.avatar ||
            ev.avatar ||
            "",
          teacherId:
            typeof teacherId !== "undefined" && teacherId !== null
              ? teacherId
              : ev.teacherId ||
                ev.teacher_id ||
                ev.teacherid ||
                ev.teacher ||
                (ev.teacherids && ev.teacherids[0]) ||
                "",
          classType:
            ev.classType ||
            ev.class_type ||
            ev.summary?.current?.class_type ||
            ev.rescheduled?.class_type ||
            ev.source ||
            "",
          source:
            ev.source ||
            ev.summary?.current?.class_type ||
            ev.rescheduled?.class_type ||
            "event",
          studentnames: ev.studentnames || [],
          studentids: ev.studentids || [],
          studentavatar: ev.studentavatar || [],
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
          summary: ev.summary || null, // Include summary with current and previous
          faded: false,
          availabilityId: ev.availabilityId || null,
          // Include history timeline if available
          history: ev.history && Array.isArray(ev.history) ? ev.history : [],
        };

        // Ensure teacherId is set from summary current teacher if missing

        if (!eventObj.teacherId) {
          if (eventObj.summary?.current?.teacher?.id) {
            eventObj.teacherId = eventObj.summary.current.teacher.id;
          } else if (eventObj.summary?.current?.teacher) {
            eventObj.teacherId = eventObj.summary.current.teacher;
          } else if (eventObj.rescheduled?.current?.teacher) {
            eventObj.teacherId = eventObj.rescheduled.current.teacher;
          }
        }

        // Ensure avatar is set from summary current teacher if missing
        if (!eventObj.avatar) {
          if (eventObj.summary?.current?.teacher?.avatar) {
            eventObj.avatar = eventObj.summary.current.teacher.avatar;
          } else if (eventObj.summary?.current?.teacher_pic) {
            eventObj.avatar = eventObj.summary.current.teacher_pic;
          } else if (eventObj.rescheduled?.current?.teacher_pic) {
            eventObj.avatar = eventObj.rescheduled.current.teacher_pic;
          }
        }

        // Mark teacher change for rescheduled 1:1 events so badge shows
        const prevTid =
          eventObj.summary?.previous?.teacher?.id ||
          eventObj.summary?.previous?.teacher ||
          eventObj.rescheduled?.previous?.teacher;
        const currTid =
          eventObj.summary?.current?.teacher?.id ||
          eventObj.summary?.current?.teacher ||
          eventObj.rescheduled?.current?.teacher;
        if (prevTid && currTid && prevTid !== currTid) {
          eventObj.isTeacherChanged = true;
        }
        if (eventObj.isTeacherChanged) {
          const statusWithDetails = Array.isArray(ev.statuses)
            ? ev.statuses.find((s) => s.details && s.details.current)
            : null;
          const currentFromStatus =
            statusWithDetails?.details?.current?.teacher?.avatar ||
            statusWithDetails?.details?.current?.teacher_pic ||
            statusWithDetails?.details?.current?.teacherpic ||
            statusWithDetails?.details?.current?.teacheravatar ||
            null;
          if (currentFromStatus) {
            eventObj.avatar = currentFromStatus;
            if (eventObj.summary && eventObj.summary.current) {
              if (!eventObj.summary.current.teacher) {
                eventObj.summary.current.teacher = {};
              }
              if (!eventObj.summary.current.teacher.avatar) {
                eventObj.summary.current.teacher.avatar = currentFromStatus;
              }
              if (!eventObj.summary.current.teacher_pic) {
                eventObj.summary.current.teacher_pic = currentFromStatus;
              }
              if (!eventObj.summary.current.teacherpic) {
                eventObj.summary.current.teacherpic = currentFromStatus;
              }
            }
          }
        }
        // If event is reschedule_instant, check if time has changed
        let shouldAddMainEvent = true;
        if (
          Array.isArray(ev.statuses) &&
          ev.statuses.some((s) => s.code === "reschedule_instant" && s.previous)
        ) {
          const statusObj = ev.statuses.find(
            (s) => s.code === "reschedule_instant" && (s.previous || null),
          );
          if (statusObj && statusObj.previous) {
            // Convert times to minutes for comparison
            const prevStart =
              typeof statusObj.previous.start === "string"
                ? minutes(statusObj.previous.start)
                : statusObj.previous.start;
            const prevEnd =
              typeof statusObj.previous.end === "string"
                ? minutes(statusObj.previous.end)
                : statusObj.previous.end;
            const currStart =
              typeof eventObj.start === "string"
                ? minutes(eventObj.start)
                : eventObj.start;
            const currEnd =
              typeof eventObj.end === "string"
                ? minutes(eventObj.end)
                : eventObj.end;

            // Check if time has changed (same start, end, and date)
            const timeUnchanged =
              prevStart === currStart &&
              prevEnd === currEnd &&
              statusObj.previous.date === eventObj.date;

            // Check if teacher changed
            const prevTeacherId = statusObj.previous.teacher;
            const currTeacherId =
              eventObj.teacherId || statusObj.current?.teacher;
            const teacherChanged =
              prevTeacherId && currTeacherId && prevTeacherId !== currTeacherId;

            // Get teacher images
            const prevTeacherPic =
              statusObj.previous.teacher_pic ||
              statusObj.previous.teacherpic ||
              statusObj.previous?.teacher?.avatar ||
              eventObj.summary?.previous?.teacher?.avatar ||
              eventObj.avatar ||
              null;
            const currTeacherPic =
              statusObj.current?.teacher_pic ||
              statusObj.current?.teacherpic ||
              eventObj.avatar ||
              null;

            // Add faded previous event
            const prevEvent = {
              ...eventObj,
              date: statusObj.previous.date,
              start: prevStart,
              end: prevEnd,
              faded: true,
              title: eventObj.title
                ? eventObj.title + " (Previous)"
                : "Previous Event",
              teacherId: statusObj.previous.teacher || eventObj.teacherId,
              avatar:
                statusObj.previous?.teacher?.avatar ||
                statusObj.previous.teacher_pic ||
                statusObj.previous.teacherpic ||
                eventObj.summary?.previous?.teacher?.avatar ||
                eventObj.avatar,
              teachernames: [ev.previous_teachername || ""],
            };

            // When teacher changed, previous event keeps previous teacher image
            if (teacherChanged) {
              if (prevTeacherPic) {
                prevEvent.avatar = prevTeacherPic;
                if (prevEvent.summary && prevEvent.summary.previous) {
                  prevEvent.summary.previous.teacher_pic = prevEvent.avatar;
                  prevEvent.summary.previous.teacherpic = prevEvent.avatar;
                  if (prevEvent.summary.previous.teacher) {
                    prevEvent.summary.previous.teacher.avatar =
                      prevEvent.avatar;
                  }
                }
              } else if (!prevEvent.avatar && currTeacherPic) {
                prevEvent.avatar = currTeacherPic;
              }
            } else if (!prevEvent.avatar && prevTeacherPic) {
              // If no teacher change, use previous teacher's image for previous event
              prevEvent.avatar = prevTeacherPic;
            }

            window.events.push(prevEvent);

            // Only add main event if time has changed
            if (timeUnchanged) {
              shouldAddMainEvent = false;
            }
          }
        }

        // Only add main event if time has changed (or if not a reschedule_instant)
        if (shouldAddMainEvent) {
          // If both time and teacher changed: current event shows new time/date + current teacher image
          if (Array.isArray(ev.statuses)) {
            const statusObj = ev.statuses.find(
              (s) => s.code === "reschedule_instant" && (s.previous || null),
            );
            if (statusObj && statusObj.previous) {
              const prevTeacherId = statusObj.previous.teacher;
              const currTeacherId =
                eventObj.teacherId || statusObj.current?.teacher;
              const teacherChanged =
                prevTeacherId &&
                currTeacherId &&
                prevTeacherId !== currTeacherId;

              const prevStart =
                typeof statusObj.previous.start === "string"
                  ? minutes(statusObj.previous.start)
                  : statusObj.previous.start;
              const prevEnd =
                typeof statusObj.previous.end === "string"
                  ? minutes(statusObj.previous.end)
                  : statusObj.previous.end;
              const currStart =
                typeof eventObj.start === "string"
                  ? minutes(eventObj.start)
                  : eventObj.start;
              const currEnd =
                typeof eventObj.end === "string"
                  ? minutes(eventObj.end)
                  : eventObj.end;

              // When teacher changed, current event keeps current teacher image
              if (teacherChanged) {
                const currTeacherPic =
                  statusObj.current?.teacher_pic ||
                  statusObj.current?.teacherpic ||
                  statusObj.current?.teacher?.avatar ||
                  eventObj.avatar ||
                  null;

                if (currTeacherPic) {
                  eventObj.avatar = currTeacherPic;
                  if (eventObj.summary && eventObj.summary.current) {
                    if (!eventObj.summary.current.teacher_pic) {
                      eventObj.summary.current.teacher_pic = currTeacherPic;
                    }
                    if (!eventObj.summary.current.teacherpic) {
                      eventObj.summary.current.teacherpic = currTeacherPic;
                    }
                  }
                  if (eventObj.rescheduled && eventObj.rescheduled.current) {
                    if (!eventObj.rescheduled.current.teacher_pic) {
                      eventObj.rescheduled.current.teacher_pic = currTeacherPic;
                    }
                    if (!eventObj.rescheduled.current.teacherpic) {
                      eventObj.rescheduled.current.teacherpic = currTeacherPic;
                    }
                  }
                }
              }
            }
          }
          window.events.push(eventObj);
        }
      }

      // Re-render your week view
      if (typeof renderWeek === "function") {
        renderWeek(false);
      }

      // Apply filters after rendering to ensure events are properly shown/hidden
      if (typeof applyFilters === "function") {
        applyFilters();
      }

      // ✅ NEW: Refresh agenda view after events are populated
      if (typeof window.refreshAgendaView === "function") {
        window.refreshAgendaView();
      }
    } catch (err) {
      console.error("Failed to load calendar events:", err);
    } finally {
      // Always hide loader in finally block
      try {
        console.log("fetchCalendarEvents: Hiding loader in finally");
        if (window.hideGlobalLoader) {
          window.hideGlobalLoader();
        } else {
          const loaderEl = document.getElementById("loader");
          if (loaderEl) {
            loaderEl.style.display = "none";
          } else if (window.$) {
            window.$("#loader").css("display", "none");
          }
        }
      } catch (e) {
        console.warn("Could not hide loader:", e);
      }
    }
  }

  // Unified helper to reload dropdown data + calendar after mutations
  // Optimized with debouncing to prevent rapid successive calls
  let __refetchTimer = null;
  let __isRefetching = false;

  async function refetchCustomPluginData(reason = "") {
    // Debounce: if already refetching, wait for it to complete
    if (__isRefetching) {
      console.log(
        `Refetch already in progress, skipping duplicate call (${reason})`,
      );
      return;
    }

    // Clear any pending debounce timer
    if (__refetchTimer) {
      clearTimeout(__refetchTimer);
      __refetchTimer = null;
    }

    // Show loader immediately - force show with multiple fallbacks
    try {
      console.log("refetchCustomPluginData: Showing loader for", reason);
      if (window.showGlobalLoader) {
        window.showGlobalLoader();
      } else {
        // Try multiple methods to ensure loader shows
        const loaderEl = document.getElementById("loader");
        if (loaderEl) {
          loaderEl.style.display = "flex";
          loaderEl.style.zIndex = "99999";
        }
        if (window.$) {
          window.$("#loader").css({ "display": "flex", "z-index": "99999" });
        }
      }
      // Force a small delay to ensure DOM update
      await new Promise((resolve) => setTimeout(resolve, 50));
    } catch (e) {
      console.warn("Could not show loader:", e);
    }

    __isRefetching = true;

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

      // Load dropdown data in parallel (optimized)
      await Promise.allSettled([
        loadTeachersFn(),
        safeSelectedTeachers.length
          ? loadCohortsFn(safeSelectedTeachers, false)
          : loadCohortsFn(),
        safeSelectedCohorts.length
          ? loadStudentsForCohortsFn(safeSelectedCohorts, false)
          : loadStudentsForCohortsFn(),
      ]);

      // Fetch calendar events (loader is already shown, pass flag to skip showing again)
      if (typeof fetchCalendarEvents === "function") {
        await fetchCalendarEvents(true); // true = skip loader show since we already showed it
      } else if (typeof triggerCalendarReload === "function") {
        triggerCalendarReload();
      }
    } catch (err) {
      console.error("refetchCustomPluginData failed", err);
      // Ensure loader is hidden even on error
      try {
        if (window.hideGlobalLoader) {
          window.hideGlobalLoader();
        } else {
          $("#loader").css("display", "none");
        }
      } catch (e) {
        console.warn("Could not hide loader:", e);
      }
    } finally {
      __isRefetching = false;
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
    // Also update window.currentWeekStart for consistency
    if (window.currentWeekStart) {
      window.currentWeekStart = new Date(currentStart);
    }
    fetchCalendarEvents();
  }

  document.getElementById("prev-week")?.addEventListener("click", function () {
    shiftWeek(-1);
  });

  document.getElementById("next-week")?.addEventListener("click", function () {
    shiftWeek(1);
  });

  // ====== STATUS ICON HISTORY TOOLTIP HANDLER ======
  document.addEventListener("mouseover", function (e) {
    const statusIcon = e.target.closest(".ev-status-icon[data-tooltip-id]");
    if (statusIcon) {
      const tooltipId = statusIcon.getAttribute("data-tooltip-id");
      const eventId = statusIcon.getAttribute("data-event-id");

      // Check if this is a history tooltip (not teacher change tooltip)
      if (tooltipId && tooltipId.startsWith("status-history-tooltip-")) {
        // Find the event object to get history
        const eventElement = statusIcon.closest(".event");
        if (!eventElement) return;

        // Get event data from window.events
        let eventData = null;
        let history = [];

        // Try to get eventId from the status icon or event element
        const evtId =
          eventId ||
          $(eventElement).data("eventid") ||
          $(eventElement).attr("data-eventid");

        if (window.events && evtId) {
          eventData = window.events.find(
            (ev) =>
              ev.eventid == evtId ||
              ev.id === evtId ||
              String(ev.eventid) === String(evtId),
          );
        }

        // If not found by eventId, try to get from element data attributes
        if (!eventData && eventElement) {
          const $event = $(eventElement);
          const eventDate = $event.closest(".day-inner").data("date");
          const eventStart = $event.data("start") || $event.attr("data-start");
          const eventEnd = $event.data("end") || $event.attr("data-end");

          if (eventDate && window.events) {
            // Try to match by date and time
            eventData = window.events.find((ev) => {
              if (ev.date !== eventDate) return false;
              if (eventStart && ev.start != eventStart) return false;
              if (eventEnd && ev.end != eventEnd) return false;
              return true;
            });
          }
        }

        // Get history from event data
        if (eventData) {
          if (Array.isArray(eventData.history)) {
            history = eventData.history;
          } else if (
            eventData.history &&
            Array.isArray(eventData.history.timeline)
          ) {
            history = eventData.history.timeline;
          }
        }

        if (history.length > 0) {
          // Create or update tooltip
          let tooltip = document.getElementById(tooltipId);
          if (!tooltip) {
            tooltip = document.createElement("div");
            tooltip.id = tooltipId;
            tooltip.className = "status-history-tooltip";
            document.body.appendChild(tooltip);
          }

          // Format history items (show at least 4, up to 10)
          const historyToShow = history.slice(
            0,
            Math.max(4, Math.min(10, history.length)),
          );
          const historyHtml = historyToShow
            .map((hist, idx) => {
              const histIcon = getHistoryIcon(hist);
              const histDesc = formatHistoryDescription(hist);
              return `
              <div class="status-history-item" style="display:flex;align-items:flex-start;gap:8px;padding:6px 0;border-bottom:${
                idx < historyToShow.length - 1 ? "1px solid #f0f1f5" : "none"
              };">
                <img src="${histIcon.icon}" alt="${
                  histIcon.label
                }" style="width:14px;height:14px;opacity:0.7;flex-shrink:0;margin-top:2px;">
                <div style="flex:1;font-size:12px;color:#4b5563;line-height:1.4;">
                  <div style="font-weight:500;color:#111827;margin-bottom:2px;">${
                    histIcon.label
                  }</div>
                  <div style="font-size:11px;color:#6b7280;">${
                    histDesc || "No details"
                  }</div>
                </div>
              </div>
            `;
            })
            .join("");

          const moreCount =
            history.length > historyToShow.length
              ? history.length - historyToShow.length
              : 0;

          tooltip.innerHTML = `
            <div style="background:#fff;border:1px solid #e1e3ec;border-radius:8px;padding:12px;min-width:280px;max-width:360px;box-shadow:0 8px 24px rgba(17,24,39,0.15),0 2px 8px rgba(17,24,39,0.08);">
              <div style="font-size:13px;font-weight:600;color:#111827;margin-bottom:10px;padding-bottom:8px;border-bottom:1px solid #f0f1f5;">Event History</div>
              <div style="max-height:300px;overflow-y:auto;">
                ${historyHtml}
                ${
                  moreCount > 0
                    ? `<div style="font-size:11px;color:#9ca3af;text-align:center;padding-top:8px;font-style:italic;">+${moreCount} more</div>`
                    : ""
                }
              </div>
            </div>
          `;

          // Position tooltip
          const iconRect = statusIcon.getBoundingClientRect();
          const eventRect = eventElement.getBoundingClientRect();
          const tooltipRect = tooltip.getBoundingClientRect();

          let left, top;
          const gap = 8;

          if (eventRect) {
            // Position tooltip above the event, aligned with icon horizontally
            left =
              iconRect.left +
              iconRect.width / 2 -
              (tooltipRect.width || 280) / 2;
            top = eventRect.top - (tooltipRect.height || 200) - gap;
          } else {
            // Fallback: position above icon
            left =
              iconRect.left +
              iconRect.width / 2 -
              (tooltipRect.width || 280) / 2;
            top = iconRect.top - (tooltipRect.height || 200) - gap;
          }

          // Keep within viewport with safety margin
          if (left < 10) left = 10;
          if (left + (tooltipRect.width || 280) > window.innerWidth - 10)
            left = window.innerWidth - (tooltipRect.width || 280) - 10;
          if (top < 10) top = iconRect.bottom + gap; // Show below if no room above
          if (top + (tooltipRect.height || 200) > window.innerHeight - 10)
            top = window.innerHeight - (tooltipRect.height || 200) - 10;

          tooltip.style.left = left + "px";
          tooltip.style.top = top + "px";
          tooltip.style.display = "block";
          tooltip.style.position = "fixed";
          tooltip.style.zIndex = "10000";
        }
        return;
      }

      // Existing teacher change tooltip logic
      const tooltip = document.getElementById(tooltipId);
      if (tooltip) {
        const iconRect = statusIcon.getBoundingClientRect();
        const eventElement = statusIcon.closest(".event, [class*='event']");
        const eventRect = eventElement
          ? eventElement.getBoundingClientRect()
          : null;

        let left, top;
        const tooltipWidth = 320;
        const tooltipHeight = 160;
        const gap = 8;

        if (eventRect) {
          // Position tooltip above the event, aligned with icon horizontally
          left = iconRect.left + iconRect.width / 2 - tooltipWidth / 2;
          top = eventRect.top - tooltipHeight - gap;
        } else {
          // Fallback: position above icon
          left = iconRect.left + iconRect.width / 2 - tooltipWidth / 2;
          top = iconRect.top - tooltipHeight - gap;
        }

        // Keep within viewport with safety margin
        if (left < 10) left = 10;
        if (left + tooltipWidth > window.innerWidth - 10)
          left = window.innerWidth - tooltipWidth - 10;
        if (top < 10) top = 10;
        if (top + tooltipHeight > window.innerHeight - 10)
          top = window.innerHeight - tooltipHeight - 10;

        tooltip.style.left = left + "px";
        tooltip.style.top = top + "px";
        tooltip.style.display = "";
      }
    }
  });

  document.addEventListener("mouseout", function (e) {
    const statusIcon = e.target.closest(".ev-status-icon[data-tooltip-id]");
    if (statusIcon) {
      const tooltipId = statusIcon.getAttribute("data-tooltip-id");
      const tooltip = document.getElementById(tooltipId);
      if (tooltip) {
        // Check if mouse is moving to tooltip
        const relatedTarget = e.relatedTarget;
        if (!relatedTarget || !tooltip.contains(relatedTarget)) {
          tooltip.style.display = "none";
        }
      }
    }

    // Also hide history tooltip when mouse leaves it
    const historyTooltip = e.target.closest(".status-history-tooltip");
    if (historyTooltip) {
      const relatedTarget = e.relatedTarget;
      if (!relatedTarget || !historyTooltip.contains(relatedTarget)) {
        const statusIcon = document.querySelector(
          `.ev-status-icon[data-tooltip-id="${historyTooltip.id}"]`,
        );
        if (!statusIcon || !statusIcon.matches(":hover")) {
          historyTooltip.style.display = "none";
        }
      }
    }
  });

  // Keep tooltip open when hovering over it
  document.addEventListener("mouseover", function (e) {
    if (e.target.closest(".teacher-change-tooltip")) {
      const tooltip = e.target.closest(".teacher-change-tooltip");
      tooltip.style.display = "";
    }
    // Keep history tooltip open when hovering over it
    if (e.target.closest(".status-history-tooltip")) {
      const tooltip = e.target.closest(".status-history-tooltip");
      tooltip.style.display = "block";
    }
  });

  document.addEventListener("mouseout", function (e) {
    if (e.target.closest(".teacher-change-tooltip")) {
      const tooltip = e.target.closest(".teacher-change-tooltip");
      const tooltipId = tooltip.id;
      const statusIcon = document.querySelector(
        `.ev-status-icon[data-tooltip-id="${tooltipId}"]`,
      );
      if (!statusIcon || !statusIcon.matches(":hover")) {
        tooltip.style.display = "none";
      }
    }
  });

  // Expose parsing functions globally for testing and debugging
  window.parseOneOnOneEvents = parseOneOnOneEvents;
  window.parseGroupEvents = parseGroupEvents;
  window.parseApiResponse = parseApiResponse;

  /**
   * Utility function to load and test API response from text file
   * Usage: loadApiResponseFromFile().then(data => { const events = parseApiResponse(data); console.log(events); });
   */
  window.loadApiResponseFromFile = async function(filePath = 'apiresponse.txt') {
    try {
      const response = await fetch(filePath);
      if (!response.ok) {
        throw new Error(`Failed to load file: ${response.status}`);
      }
      const text = await response.text();
      const data = JSON.parse(text);
      console.log('Loaded API response from file:', data);
      return data;
    } catch (error) {
      console.error('Error loading API response from file:', error);
      throw error;
    }
  };
})();
