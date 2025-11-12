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

// Helper function to get teacher color index (1-10) based on teacher ID
function getTeacherColorIndex(teacherId) {
  if (!teacherId) return 1;
  return ((Math.abs(teacherId) % 10) || 10);
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
      perDay[di].push(e);
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
        
        // Get teacher color class if teacher ID exists
        const teacherColorClass = ev.teacherId ? `teacher-${getTeacherColorIndex(ev.teacherId)} has-teacher-indicator` : "";
        
        const $ev = $(`
          <div class="event ${ev.color || "e-blue"} ${teacherColorClass}" data-start="${
          ev.start
        }" data-end="${ev.end}" ${ev.teacherId ? `data-teacher-id="${ev.teacherId}"` : ""}>
            <div class="ev-top">
              <div class="ev-left">${
                ev.avatar
                  ? `<img class="ev-avatar" src="${ev.avatar}" alt="">`
                  : ""
              }</div>
              ${
                ev.repeat
                  ? `<span class="ev-repeat" title="Repeats"><img src="./img/ev-repeat.svg" alt=""></span>`
                  : ""
              }
            </div>
            <div class="ev-when">${fmt12(ev.start)} – ${fmt12(ev.end)}</div>
            <div class="ev-title">${ev.title || ""}</div>
          </div>
        `).css({ top: top + "px", height: h + "px", ...cssPos });

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
  let selectedCohortId = null;
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
        console.log("Triggering calendar reload...");
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

    wrap.innerHTML = `
            <label class="teacher-label">
                <div class="teacher-details">
                    <div class="teacher-avatar-container">
                        <img class="teacher-avatar" src="${
                          t.avatar || ""
                        }" alt="${t.name}">
                    </div>
                    <span class="teacher-name">${t.name}</span>
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
      const id = parseInt(wrap.dataset.teacherId, 10);
      const wasChecked = checkbox.checked;
      checkbox.checked = !wasChecked;

      if (checkbox.checked) {
        if (!selectedTeacherIds.includes(id)) selectedTeacherIds.push(id);
        wrap.classList.add("selected");
      } else {
        selectedTeacherIds = selectedTeacherIds.filter((x) => x !== id);
        wrap.classList.remove("selected");
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
      // Add teacher color data attribute
      const colorIndex = getTeacherColorIndex(id);
      img.dataset.teacherColor = colorIndex;
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

  function selectCohort(cohortId) {
    const opt = cohortFieldset.querySelector(`[data-cohort-id="${cohortId}"]`);

    if (!opt) {
      console.log("Cohort option not found for ID:", cohortId);
      return;
    }

    console.log("Selecting cohort:", cohortId);

    // Clear previous selections
    cohortFieldset.querySelectorAll(".cohort-option").forEach((o) => {
      o.classList.remove("selected");
      const r = o.querySelector(".cohort-radio");
      if (r) r.checked = false;
    });

    // Select new cohort
    opt.classList.add("selected");
    const radio = opt.querySelector(".cohort-radio");
    if (radio) radio.checked = true;

    selectedCohortId = cohortId;
    cohortHidden.value = cohortId;
    cohortDisplayText.textContent = opt.dataset.cohortName || "Select Cohort";

    // Close dropdown
    cohortWidget.style.display = "none";

    // Load students and trigger calendar refresh
    loadStudentsForSingleCohort(cohortId).then(() => {
      triggerCalendarReload();
    });
  }

  function createCohortOption(c) {
    const wrap = document.createElement("div");
    wrap.className = "cohort-option";
    wrap.dataset.cohortId = c.id;
    wrap.dataset.cohortName = c.name;

    wrap.innerHTML = `
            <label class="cohort-label">
                <div class="cohort-details">
                    <span class="cohort-name">${c.name}</span>
                </div>
                <div class="radio-custom">
                    <div class="radio-custom-dot"></div>
                </div>
            </label>
            <input type="radio" name="cohort-radio" class="visually-hidden cohort-radio">
        `;

    wrap.addEventListener("click", (e) => {
      e.preventDefault();
      e.stopPropagation();

      const cohortId = parseInt(wrap.dataset.cohortId, 10);
      selectCohort(cohortId);
    });

    // Also handle label clicks
    const label = wrap.querySelector(".cohort-label");
    if (label) {
      label.addEventListener("click", (e) => {
        e.preventDefault();
        e.stopPropagation();
        wrap.click();
      });
    }

    return wrap;
  }

  async function loadAllCohorts() {
    clear(cohortFieldset);
    cohortNoResults.style.display = "none";

    const data = await fetchJSON(`${API_BASE}?action=cohorts`);
    if (!data.ok) return [];

    const list = data.data || [];
    if (!list.length) {
      cohortNoResults.style.display = "block";
      return [];
    }

    list.forEach((c) => cohortFieldset.appendChild(createCohortOption(c)));
    return list;
  }

  async function loadCohortsForTeachers(teacherIds, returnList = false) {
    clear(cohortFieldset);
    cohortNoResults.style.display = "none";

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

    list.forEach((c) => cohortFieldset.appendChild(createCohortOption(c)));
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
      triggerCalendarReload();
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
          triggerCalendarReload();
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

  studentSearchInput.addEventListener("input", () => {
    const term = studentSearchInput.value.trim().toLowerCase();
    studentFieldset.querySelectorAll(".student-option").forEach((opt) => {
      const name = (opt.dataset.studentName || "").toLowerCase();
      opt.style.display = !term || name.includes(term) ? "" : "none";
    });
  });

  // ---------- Filter change logic ----------

  async function onTeacherFilterChange() {
    console.log("Teacher filter changed, selected:", selectedTeacherIds);

    // Reset cohort + student UI
    selectedCohortId = null;
    cohortHidden.value = "";
    cohortDisplayText.textContent = "Select Cohort";
    clear(cohortFieldset);

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
      // Do NOT auto-select any cohort
      cohortDisplayText.textContent = "Select Cohort";
      cohortHidden.value = "";
      // Keep students empty until a cohort is picked
      clear(studentFieldset);
      const helper = document.createElement("div");
      helper.style.padding = "8px";
      helper.textContent = "Select a cohort to see its students";
      studentFieldset.appendChild(helper);

      // Refresh calendar using only the teacher filter
      triggerCalendarReload();
    } else {
      // No cohorts for that teacher -> keep students empty and show message
      clear(studentFieldset);
      const div = document.createElement("div");
      div.style.padding = "8px";
      div.textContent = "No cohorts for selected teacher";
      cohortFieldset.appendChild(div);
      triggerCalendarReload();
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
    getSelectedCohort: () => selectedCohortId,
    getSelectedStudents: () => [...selectedStudentIds],
  };
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

  function getSelectedCohortId() {
    // Use the exposed state if available
    if (window.calendarFilterState) {
      const cohortId = window.calendarFilterState.getSelectedCohort();
      if (cohortId) return cohortId;
    }

    // selected cohort option
    const selected = document.querySelector(
      ".cohort-option.selected, .cohort-option input.cohort-radio:checked"
    );
    if (selected) {
      const li = selected.classList.contains("cohort-option")
        ? selected
        : selected.closest(".cohort-option");
      if (li) {
        const cohortId = li.getAttribute("data-cohort-id");
        if (cohortId) {
          return parseInt(cohortId, 10) || 0;
        }
      }
    }

    // from hidden field (if you set it elsewhere)
    const hidden = document.getElementById("cohort-value");
    if (hidden && hidden.value) {
      return parseInt(hidden.value, 10) || 0;
    }

    return 0;
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

  // ---------------- API call ----------------

  async function fetchCalendarEvents() {
    const teacherid = getSelectedTeacherId();
    const cohortid = getSelectedCohortId();
    const studentid = getSelectedStudentId();

    console.log("Fetching calendar events with filters:", {
      teacherid,
      cohortid,
      studentid,
      dateRange: `${formatYMD(currentStart)} to ${formatYMD(currentEnd)}`,
    });

    const params = new URLSearchParams();
    params.set("start", formatYMD(currentStart));
    params.set("end", formatYMD(currentEnd));

    if (teacherid) params.set("teacherid", teacherid);
    if (cohortid) params.set("cohortid", cohortid);
    if (studentid) params.set("studentid", studentid);
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

          return {
            date: startDate.toISOString().split("T")[0],
            title: ev.title,
            start: startDate.toTimeString().slice(0, 5),
            end: endDate.toTimeString().slice(0, 5),
            color: ev.class_type === "weekly" ? "e-blue" : "e-green",
            repeat: ev.is_recurring,
            meetingurl: ev.meetingurl,
            avatar: "",
            teacherId: ev.teacher_id || null,
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
