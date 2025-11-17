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

  // Generate unique hue based on teacher ID using golden angle for optimal color distribution
  const hue = Math.round((Math.abs(teacherId) * 137.508) % 360); // Golden angle: 137.508°

  // Maximum saturation and optimal lightness for ultra-vibrant colors
  const saturation = 100; // Always 100% for maximum vibrancy
  const lightness = 50; // Fixed at 50% for optimal brightness and color purity

  return `hsl(${hue}, ${saturation}%, ${lightness}%)`;
}

const DOW = ["Mon", "Tue", "Wed", "Thu", "Fri", "Sat", "Sun"];

/* ====== WHITE SLOT WINDOWS ======
   days: 'all' | [0..6]  (Mon=0 ... Sun=6)
   Or target a specific ISO date with { date:'YYYY-MM-DD', ... }
*/

const WHITE_SLOTS = [
  // Example per your ask: 10:00–11:00 PM and 11:00 PM–12:00 AM every day
  { days: "all", start: "22:00", end: "23:00" },
  { days: "all", start: "23:00", end: "24:00" },
  // More examples you can add later:
  // { days:[5,6], start:'18:00', end:'20:00' },
  // { date:'2025-08-31', start:'10:00', end:'12:00' },
];

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

/* NEW: check if a slot minute falls in any WHITE_SLOTS rule */
function isWhiteSlotFor(dayIndex, isoDate, minuteOfDay) {
  const toMin = (hhmm) => {
    if (typeof hhmm === "number") return hhmm;
    const [h, m] = String(hhmm).split(":").map(Number);
    return h * 60 + (m || 0);
  };
  for (const rule of WHITE_SLOTS) {
    // date-specific rule
    if (rule.date) {
      if (rule.date !== isoDate) continue;
    } else {
      // day-of-week rules
      if (rule.days === "all") {
        // ok
      } else if (Array.isArray(rule.days)) {
        if (!rule.days.includes(dayIndex)) continue;
      } else {
        continue;
      }
    }
    const s = toMin(rule.start),
      e = toMin(rule.end);
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
    $("#mainModalContent").css("display", "block");
    $("#classTabContent").css("display", "none");
  }

  // // Button → open same modal (kept your trigger class)
  // $(".calendar_admin_details_create_cohort_open")
  //   .off("click.openCohort")
  //   .on("click.openCohort", function (e) {
  //     e.preventDefault();
  //     openCreateCohortModal();
  //   });

  /* ====== CLICK: event -> bring to front only ====== */
  let zSeed = 5000;
  $("#grid")
    .off("mousedown", ".event")
    .on("mousedown", ".event", function () {
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
    });

  /* ====== CLICK: empty slot -> open cohort modal ====== */
  $("#grid")
    .off("mousedown.emptySlot", ".day-inner")
    .on("mousedown.emptySlot", ".day-inner", function (e) {
      if ($(e.target).closest(".event").length) return;
      // openCreateCohortModal();
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
    events.forEach((raw) => {
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
          : {
              left: MAX_LEFT - ev.stackIndex * STACK_OFFSET + "px",
              width: `calc(100% - ${MAX_LEFT + 1}px)`,
            };

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
        }

        // Combine styles
        const combinedStyle = `${teacherColorStyle}${borderColorStyle}`.trim();

        // Check if event is short (less than 1 hour)
        const eventDuration = ev.end - ev.start;
        const isShortEvent = eventDuration < 60;

        // Build event HTML - hide details for short events
        const $ev = $(`
          <div class="event ${
            ev.color || "e-blue"
          } ${teacherColorClass} ${classTypeClass}${
          ev.isMidnightCrossing ? " midnight-crossing" : ""
        }${
          isShortEvent ? " short-event" : ""
        }" style="${combinedStyle}" data-start="${ev.start}" data-end="${
          ev.end
        }" ${ev.teacherId ? `data-teacher-id="${ev.teacherId}"` : ""}${
          ev.pairedId ? ` data-paired-id="${ev.pairedId}"` : ""
        }${ev.part ? ` data-part="${ev.part}"` : ""}>
            ${
              !isShortEvent
                ? `<div class="ev-top">
              <div class="ev-left">${
                ev.avatar
                  ? `<img class="ev-avatar" src="${ev.avatar}" alt="">`
                  : ""
              }</div>
              ${
                ev.repeat
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

    if (resetScroll) $grid.scrollTop(0);
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
      onTeacherFilterChange();
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
          selectedTeacherIds = selectedTeacherIds.filter((x) => x !== id);
          const checkbox = opt.querySelector(".teacher-checkbox");
          if (checkbox) checkbox.checked = false;
          opt.classList.remove("selected");
          // Hide the color dot when deselecting
          const colorDot = opt.querySelector(".teacher-color-dot");
          if (colorDot) colorDot.style.display = "none";
          updateTeacherPills();
          onTeacherFilterChange();
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

    list.forEach((t) => {
      teacherFieldset.appendChild(createTeacherOption(t));
    });

    return list;
  }

  function autoSelectFirstTeacher() {
    const first = teacherFieldset.querySelector(".teacher-option");
    if (!first) return null;

    const id = parseInt(first.dataset.teacherId, 10);
    const checkbox = first.querySelector(".teacher-checkbox");

    if (checkbox && !checkbox.checked) {
      checkbox.checked = true;
    }
    first.classList.add("selected");

    if (!selectedTeacherIds.includes(id)) {
      selectedTeacherIds.push(id);
    }

    updateTeacherPills();
    return id;
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

      const name = opt.dataset.cohortName || "";

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
          return opt.dataset.cohortName || "";
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

    wrap.innerHTML = `
            <label class="cohort-label">
                <div class="cohort-details">
                    <span class="cohort-name">${c.name}</span>
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

      // Load students and auto-select based on events
      updateStudentsForCohortChange();

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

      // Load students and auto-select based on events
      updateStudentsForCohortChange();

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

    // Separate cohorts by type
    const groupCohorts = list.filter((c) => c.cohorttype !== "one1one");
    const oneOnOneCohorts = list.filter((c) => c.cohorttype === "one1one");

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
    if (oneOnOneCohorts.length > 0) {
      oneOnOneCohorts.forEach((c) => {
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

    return list;
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

    // Separate cohorts by type
    const groupCohorts = list.filter((c) => c.cohorttype !== "one1one");
    const oneOnOneCohorts = list.filter((c) => c.cohorttype === "one1one");

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
    if (oneOnOneCohorts.length > 0) {
      oneOnOneCohorts.forEach((c) => {
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

    return returnList ? list : [];
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

    wrap.innerHTML = `
            <label class="student-label">
                <div class="student-details">
                    <div class="student-avatar-container">
                        <img class="student-avatar" src="${
                          s.avatar || ""
                        }" alt="${s.name}">
                    </div>
                    <span class="student-name">${s.name}</span>
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

    list.forEach((s) => studentFieldset.appendChild(createStudentOption(s)));
  }

  async function loadStudentsForSingleCohort(cohortId) {
    clear(studentFieldset);
    selectedStudentIds = [];
    updateStudentPills();

    if (!cohortId) {
      await loadAllStudents();
      return;
    }

    const data = await fetchJSON(
      `${API_BASE}?action=students&cohortid=${encodeURIComponent(cohortId)}`
    );
    if (!data.ok) return;

    const list = data.data || [];
    if (!list.length) {
      const div = document.createElement("div");
      div.style.padding = "8px";
      div.textContent = "No students found in this cohort";
      studentFieldset.appendChild(div);
      return;
    }

    list.forEach((s) => studentFieldset.appendChild(createStudentOption(s)));
  }

  async function loadStudentsForCohorts(cohortIds) {
    clear(studentFieldset);
    selectedStudentIds = [];

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
    if (!data.ok) return;

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

      // Add students under this cohort
      cohortGroup.students.forEach((s) => {
        const option = createStudentOption(s);
        studentFieldset.appendChild(option);

        // Restore selection state if previously selected
        if (selectedStudentIds.includes(s.id)) {
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
        console.log("Auto-selection: Processing", eventsData.length, "events");

        // Extract unique cohort IDs and student IDs from events
        const eventCohortIds = new Set();
        const eventStudentIds = new Set();

        eventsData.forEach((ev) => {
          if (
            ev.cohortids &&
            Array.isArray(ev.cohortids) &&
            ev.cohortids.length > 0
          ) {
            ev.cohortids.forEach((cid) => eventCohortIds.add(cid));
          }
          if (ev.studentids && Array.isArray(ev.studentids)) {
            ev.studentids.forEach((sid) => eventStudentIds.add(sid));
          }
        });

        console.log(
          "Auto-selection: Found cohort IDs from events:",
          Array.from(eventCohortIds)
        );
        console.log(
          "Auto-selection: Found student IDs from events:",
          Array.from(eventStudentIds)
        );

        // Auto-select cohorts that have events
        // This includes both group cohorts (from eventCohortIds) and 1:1 cohorts (inferred from students)
        const cohortsToSelect = new Set();

        // Add cohorts that are directly in events
        eventCohortIds.forEach((cid) => cohortsToSelect.add(cid));

        // For 1:1 events (no cohortids but have studentids), find which 1:1 cohorts contain those students
        if (eventStudentIds.size > 0) {
          cohorts.forEach((c) => {
            // Check if this is a 1:1 cohort that should be selected based on student presence
            if (c.cohorttype === "one1one") {
              // We need to select 1:1 cohorts - we'll select them all if there are student IDs
              // since we don't have the cohort-student mapping at this point
              // The students will be loaded and filtered correctly later
              cohortsToSelect.add(c.id);
            }
          });
        }

        // Apply selection to all cohorts that should be selected
        if (cohortsToSelect.size > 0) {
          console.log(
            "Auto-selection: Selecting cohorts:",
            Array.from(cohortsToSelect)
          );

          cohorts.forEach((c) => {
            if (cohortsToSelect.has(c.id)) {
              if (!selectedCohortIds.includes(c.id)) {
                selectedCohortIds.push(c.id);
              }
              // Update UI for selected cohort
              const fieldset =
                c.cohorttype === "one1one" ? oneOnOneFieldset : cohortFieldset;
              const option = fieldset?.querySelector(
                `.cohort-option[data-cohort-id="${c.id}"]`
              );
              if (option) {
                const checkbox = option.querySelector(".cohort-checkbox");
                if (checkbox) checkbox.checked = true;
                option.classList.add("selected");
                console.log(
                  "Auto-selection: Selected cohort",
                  c.id,
                  c.name,
                  "type:",
                  c.cohorttype
                );
              } else {
                console.warn(
                  "Auto-selection: Could not find option for cohort",
                  c.id,
                  "in fieldset"
                );
              }
            }
          });

          console.log(
            "Auto-selection: Final selectedCohortIds:",
            selectedCohortIds
          );
          cohortDisplayText.textContent = "";
          updateCohortPills();
        }

        // Load students for selected cohorts (or all students if no cohorts)
        if (selectedCohortIds.length > 0) {
          await loadStudentsForCohorts(selectedCohortIds);
        } else {
          // If no cohorts selected but we have student IDs from events (1:1 classes),
          // load all students so we can select the ones with events
          await loadAllStudents();
        }

        // Auto-select only students that have events
        if (eventStudentIds.size > 0) {
          console.log(
            "Auto-selection: Selecting students:",
            Array.from(eventStudentIds)
          );

          eventStudentIds.forEach((sid) => {
            if (!selectedStudentIds.includes(sid)) {
              selectedStudentIds.push(sid);
            }
            const option = studentFieldset.querySelector(
              `.student-option[data-student-id="${sid}"]`
            );
            if (option) {
              const checkbox = option.querySelector(".student-checkbox");
              if (checkbox) checkbox.checked = true;
              option.classList.add("selected");
            } else {
              console.warn(
                "Auto-selection: Could not find option for student",
                sid
              );
            }
          });

          console.log(
            "Auto-selection: Final selectedStudentIds:",
            selectedStudentIds
          );
          updateStudentPills();
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

    // Clear current student selection
    selectedStudentIds = [];

    if (!selectedCohortIds.length) {
      console.log(
        "updateStudentsForCohortChange: No cohorts selected, clearing students"
      );
      clear(studentFieldset);
      updateStudentPills();
      return;
    }

    // Load students for selected cohorts
    await loadStudentsForCohorts(selectedCohortIds);

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

        console.log(
          "updateStudentsForCohortChange: Students to auto-select:",
          Array.from(eventStudentIds)
        );

        // Auto-select students that have events
        eventStudentIds.forEach((sid) => {
          if (!selectedStudentIds.includes(sid)) {
            selectedStudentIds.push(sid);
          }
          const option = studentFieldset.querySelector(
            `.student-option[data-student-id="${sid}"]`
          );
          if (option) {
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

  function getSelectedTeacherId() {
    // Use the exposed state if available
    if (window.calendarFilterState) {
      const teachers = window.calendarFilterState.getSelectedTeachers();
      return teachers && teachers.length > 0 ? teachers[0] : 0;
    }

    // Fallback: pill priority
    const pill = document.querySelector("#teacher-pills .teacher-pill");
    if (pill && pill.dataset.userid) {
      return parseInt(pill.dataset.userid, 10) || 0;
    }

    // fallback: selected list item
    const opt = document.querySelector(
      ".teacher-option.selected, .teacher-option input.teacher-checkbox:checked"
    );
    if (opt) {
      const li = opt.classList.contains("teacher-option")
        ? opt
        : opt.closest(".teacher-option");
      if (li && li.dataset.teacherId) {
        return parseInt(li.dataset.teacherId, 10) || 0;
      }
    }

    return 0;
  }

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

  function getSelectedStudentId() {
    // Use the exposed state if available
    if (window.calendarFilterState) {
      const students = window.calendarFilterState.getSelectedStudents();
      return students && students.length > 0 ? students[0] : 0;
    }

    // multi-select: just send first selected for now
    const checked = document.querySelector(
      ".student-option input.student-checkbox:checked"
    );
    if (checked) {
      const li = checked.closest(".student-option");
      if (li && li.dataset.studentId) {
        return parseInt(li.dataset.studentId, 10) || 0;
      }
    }

    const pill = document.querySelector("#student-pills .student-pill");
    if (pill && pill.dataset.studentId) {
      return parseInt(pill.dataset.studentId, 10) || 0;
    }

    return 0;
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
      console.log("Calendar events API result:", data);

      if (data.ok && Array.isArray(data.events)) {
        window.events = data.events.map((ev) => {
          const startDate = new Date(ev.start);
          const endDate = new Date(ev.end);

          // Match event teacher with selected teachers for proper color assignment
          let teacherId = null;

          if (teacherids && teacherids.length > 0) {
            // Find which selected teacher is associated with this event
            const eventTeacherIds = Array.isArray(ev.teacherids)
              ? ev.teacherids
              : ev.teacher_id
              ? [ev.teacher_id]
              : [];

            // Find first match between selected teachers and event teachers
            teacherId =
              teacherids.find((selectedId) =>
                eventTeacherIds.includes(selectedId)
              ) || eventTeacherIds[0]; // Fallback to event's first teacher
          } else if (Array.isArray(ev.teacherids) && ev.teacherids.length > 0) {
            // No teacher filter: use first teacher from event data
            teacherId = ev.teacherids[0];
          } else if (ev.teacher_id) {
            // Fallback: use single teacher_id field
            teacherId = ev.teacher_id;
          }

          // Determine event color based on class type
          let eventColor = "e-blue"; // Default for main classes
          if (
            ev.class_type === "one2one_weekly" ||
            ev.class_type === "one2one_single"
          ) {
            eventColor = "e-green";
          }

          return {
            date: startDate.toISOString().split("T")[0],
            title: ev.title,
            start: startDate.toTimeString().slice(0, 5),
            end: endDate.toTimeString().slice(0, 5),
            color: eventColor,
            repeat: ev.is_recurring,
            meetingurl: ev.meetingurl,
            avatar: "",
            teacherId: teacherId,
            classType: ev.class_type,
            studentnames: ev.studentnames || [],
            studentids: ev.studentids || [],
          };
        });

        console.log("Mapped events:", window.events.length);

        // Re-render your week view
        if (typeof renderWeek === "function") {
          renderWeek(true);
        }
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

  // Expose globally so it can be called from filter changes
  window.fetchCalendarEvents = fetchCalendarEvents;

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
