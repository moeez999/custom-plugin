$(".calendar_admin_details_create_cohort_tab").click(function () {
  $(".calendar_admin_details_create_cohort_tab").removeClass("active");
  $(this).addClass("active");
  let tab = $(this).data("tab");
  $("#mainModalContent").toggle(tab === "cohort");
  $("#classTabContent").toggle(tab === "class");
  $("#conferenceTabContent").toggle(tab === "conference");
  $("#peerTalkTabContent").toggle(tab === "peertalk");
  if (["cohort", "class", "conference", "peertalk"].indexOf(tab) === -1) {
    $(
      "#mainModalContent, #classTabContent, #conferenceTabContent, #peerTalkTabContent"
    ).hide();
  }
});

// Toggle student dropdown on click
$("#one2oneAddStudentBtn").on("click keydown", function (e) {
  if (e.type === "click" || e.key === "Enter" || e.key === " ") {
    e.preventDefault();
    $("#one2oneStudentDropdown").toggle();
    $(this).toggleClass("active");
  }
});

$("#one2oneAddStudentBtnManage").on("click keydown", function (e) {
  if (e.type === "click" || e.key === "Enter" || e.key === " ") {
    e.preventDefault();
    $("#one2oneStudentDropdownManage").toggle();
    $(this).toggleClass("active");
  }
});

// Select a student
$("#one2oneStudentDropdown .one2one-student-list-item-class").on(
  "click",
  function () {
    var studentName = $(this).find(".one2one-student-list-name").text();
    var avatarSVG = $(this).find(".one2one-student-list-avatar").html();
    $("#one2oneAddStudentBtn")
      .html(
        `
    <span class="one2one-add-student-icon">${avatarSVG}</span>
    <span style="font-weight:600; color:#232323;">${studentName}</span>
  `
      )
      .addClass("active");

    $("#one2oneStudentDropdown").hide();
  }
);

// Replace the existing manage tab student click handler with this:
$(document).on(
  "click",
  "#one2oneStudentDropdownManage .one2one-student-list-item",
  function () {
    // Remove selected class from all students
    $("#one2oneStudentDropdownManage .one2one-student-list-item").removeClass(
      "selected"
    );

    // Add selected class to clicked student
    $(this).addClass("selected");

    var studentName = $(this).find(".one2one-student-list-name").text();
    var avatarSVG = $(this).find(".one2one-student-list-avatar").html();

    $("#one2oneAddStudentBtnManage")
      .html(
        `
    <span class="one2one-add-student-icon">${avatarSVG}</span>
    <span style="font-weight:600; color:#232323;">${studentName}</span>
  `
      )
      .addClass("active");

    $("#one2oneStudentDropdownManage").hide();
  }
);

// Close dropdown when clicking outside
$(document).on("click", function (event) {
  if (!$(event.target).closest(".one2one-student-dropdown-wrapper").length) {
    $("#one2oneStudentDropdown").hide();
    $("#one2oneAddStudentBtn").removeClass("active");
  }
});

$(document).on("click", function (event) {
  if (!$(event.target).closest(".one2one-student-dropdown-wrapper").length) {
    $("#one2oneStudentDropdownManage").hide();
    $("#one2oneAddStudentBtnManage").removeClass("active");
  }
});

// LESSON TYPE RADIO BUTTON SELECTION FIX
$(".one2one-lesson-type-btn").on("click", function (e) {
  // Remove "selected" class from all, add to clicked
  $(".one2one-lesson-type-btn").removeClass("selected");
  $(this).addClass("selected");
  // Uncheck all radios, check only clicked one
  $('.one2one-lesson-type-btn input[type="radio"]').prop("checked", false);
  $(this).find('input[type="radio"]').prop("checked", true);
});

// LESSON TYPE RADIO BUTTON SELECTION FIX
$(".one2one-lesson-type-btn").on("click", function (e) {
  $(".one2one-lesson-type-btn").removeClass("selected");
  $(this).addClass("selected");
  $('.one2one-lesson-type-btn input[type="radio"]').prop("checked", false);
  $(this).find('input[type="radio"]').prop("checked", true);
});

// --- Custom Duration Dropdown ---
$("#durationDropdownDisplay").on("click", function () {
  $("#durationDropdownList").toggle();
  $(this).toggleClass("active");
});
$("#durationDropdownList .one2one-duration-option").on("click", function () {
  $("#durationDropdownList .one2one-duration-option").removeClass("selected");
  $(this).addClass("selected");
  var text = $(this).text();
  $("#durationDropdownDisplay").text(text);
  $("#durationDropdownList").hide();
});
$(document).on("mousedown", function (event) {
  if (!$(event.target).closest("#durationDropdownWrapper").length) {
    $("#durationDropdownList").hide();
    $("#durationDropdownDisplay").removeClass("active");
  }
});

$("#durationDropdownDisplayManage").on("click", function () {
  $("#durationDropdownListManage").toggle();
  $(this).toggleClass("active");
});
$("#durationDropdownListManage .one2one-duration-option").on(
  "click",
  function () {
    $("#durationDropdownListManage .one2one-duration-option").removeClass(
      "selected"
    );
    $(this).addClass("selected");
    var text = $(this).text();
    $("#durationDropdownDisplayManage").text(text);
    $("#durationDropdownListManage").hide();
  }
);
$(document).on("mousedown", function (event) {
  if (!$(event.target).closest("#durationDropdownWrapper").length) {
    $("#durationDropdownList").hide();
    $("#durationDropdownDisplayManage").removeClass("active");
  }
});

// --- Custom Calendar Modal ---
function getMonthDays(year, month) {
  let firstDay = new Date(year, month, 1);
  let startDay = (firstDay.getDay() + 6) % 7;
  let days = [];
  let prevLast = new Date(year, month, 0).getDate();
  for (let i = 0; i < startDay; ++i)
    days.push({ day: prevLast - startDay + i + 1, disabled: true });
  let numDays = new Date(year, month + 1, 0).getDate();
  for (let d = 1; d <= numDays; ++d) days.push({ day: d, disabled: false });
  while (days.length % 7) days.push({ day: "", disabled: true });
  return days;
}
function monthName(monthIdx) {
  return [
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
  ][monthIdx];
}
// initialize create-calendar state to today
const _now = new Date();
let calendarYear = _now.getFullYear(),
  calendarMonth = _now.getMonth(),
  selectedCalendarDay = _now.getDate();

// manage modal (separate) calendar state
let calendarYearManage = _now.getFullYear(),
  calendarMonthManage = _now.getMonth(),
  selectedCalendarDayManage = _now.getDate();

// Helper to parse displayed date strings in the UI into a Date object

function parseDisplayedDate(txt) {
  if (!txt) return null;
  txt = String(txt).trim();

  // ✅ FIX: ISO YYYY-MM-DD - parse without timezone conversion
  if (/^\d{4}-\d{2}-\d{2}$/.test(txt)) {
    const parts = txt.split("-");
    const year = parseInt(parts[0]);
    const month = parseInt(parts[1]) - 1; // Month is 0-indexed
    const day = parseInt(parts[2]);
    // Create date at noon in local timezone to avoid timezone shifts
    return new Date(year, month, day, 12, 0, 0);
  }

  // Try Date.parse directly
  let d = new Date(txt);
  if (!isNaN(d)) return d;

  // Normalize: remove commas and weekday, add space between month and day if missing
  let cleaned = txt
    .replace(/,/g, "")
    .replace(/^\w{3,9}\s+/, "")
    .trim();
  cleaned = cleaned.replace(/([A-Za-z])(?=\d)/g, "$1 ");
  const hasYear = /\d{4}/.test(cleaned);
  const tryStr = hasYear ? cleaned : `${cleaned} ${new Date().getFullYear()}`;
  d = new Date(tryStr);
  if (!isNaN(d)) return d;
  return null;
}
function renderCalendar() {
  $("#calendarMonthYear").text(monthName(calendarMonth) + " " + calendarYear);
  let days = getMonthDays(calendarYear, calendarMonth);
  let html = "";
  days.forEach((d, i) => {
    let sel = !d.disabled && d.day == selectedCalendarDay ? "selected" : "";
    let dis = d.disabled ? "disabled" : "";
    html += `<div class="calendar-modal-day ${sel} ${dis}" data-day="${
      d.day
    }" data-disabled="${d.disabled}">${d.day || ""}</div>`;
  });
  $("#calendarDaysGrid").html(html);
}
renderCalendar();
$("#calendarPrevMonth").on("click", function () {
  calendarMonth--;
  if (calendarMonth < 0) {
    calendarMonth = 11;
    calendarYear--;
  }
  renderCalendar();
});
$("#calendarNextMonth").on("click", function () {
  calendarMonth++;
  if (calendarMonth > 11) {
    calendarMonth = 0;
    calendarYear++;
  }
  renderCalendar();
});
// Create modal: day click
$(document).on("click", "#calendarDaysGrid .calendar-modal-day", function () {
  if ($(this).data("disabled")) return;
  selectedCalendarDay = $(this).data("day");
  renderCalendar();
});

// Manage modal: day click (separate state)
function renderCalendarManage() {
  $("#calendarMonthYearManage").text(
    monthName(calendarMonthManage) + " " + calendarYearManage
  );
  let days = getMonthDays(calendarYearManage, calendarMonthManage);
  let html = "";
  days.forEach((d, i) => {
    let sel =
      !d.disabled && d.day == selectedCalendarDayManage ? "selected" : "";
    let dis = d.disabled ? "disabled" : "";
    html += `<div class="calendar-modal-day ${sel} ${dis}" data-day="${
      d.day
    }" data-disabled="${d.disabled}">${d.day || ""}</div>`;
  });
  $("#calendarDaysGridManage").html(html);
}

$(document).on(
  "click",
  "#calendarDaysGridManage .calendar-modal-day",
  function () {
    if ($(this).data("disabled")) return;
    selectedCalendarDayManage = $(this).data("day");
    renderCalendarManage();
  }
);

// Manage prev/next
$("#calendarPrevMonthManage").on("click", function () {
  calendarMonthManage--;
  if (calendarMonthManage < 0) {
    calendarMonthManage = 11;
    calendarYearManage--;
  }
  renderCalendarManage();
});
$("#calendarNextMonthManage").on("click", function () {
  calendarMonthManage++;
  if (calendarMonthManage > 11) {
    calendarMonthManage = 0;
    calendarYearManage++;
  }
  renderCalendarManage();
});
$("#customDateDropdownDisplay").on("click", function () {
  // set create calendar view from displayed date if possible
  (function () {
    const txt =
      $("#selectedDateText").attr("data-full-date") ||
      $("#selectedDateText").text().trim();
    const parsed = parseDisplayedDate(txt);
    if (parsed) {
      calendarYear = parsed.getFullYear();
      calendarMonth = parsed.getMonth();
      selectedCalendarDay = parsed.getDate();
      renderCalendar();
    }
  })();
  $("#calendarModalBackdrop").fadeIn(100);
});
$("#customDateDropdownDisplayManage").on("click", function () {
  // set manage calendar view from displayed date if possible
  (function () {
    const txt =
      $("#selectedDateTextManage").attr("data-full-date") ||
      $("#selectedDateTextManage").text().trim();
    const parsed = parseDisplayedDate(txt);
    if (parsed) {
      calendarYearManage = parsed.getFullYear();
      calendarMonthManage = parsed.getMonth();
      selectedCalendarDayManage = parsed.getDate();
      renderCalendarManage();
    }
  })();
  $("#calendarModalBackdropManage").fadeIn(100);
});
$("#calendarDoneBtn").on("click", function () {
  let d = new Date(calendarYear, calendarMonth, selectedCalendarDay);
  let dayStr = d.toLocaleString("en-US", {
    weekday: "short",
    month: "short",
    day: "numeric",
  });
  $("#selectedDateText")
    .text(dayStr)
    .attr("data-full-date", d.toISOString().split("T")[0]);
  $("#calendarModalBackdrop").fadeOut(100);
});
$("#calendarModalBackdrop").on("mousedown", function (e) {
  if (e.target === this) $(this).fadeOut(100);
});

$("#calendarDoneBtnManage").on("click", function () {
  let d = new Date(
    calendarYearManage,
    calendarMonthManage,
    selectedCalendarDayManage,
    12,
    0,
    0 // ✅ Add time at noon to avoid timezone issues
  );

  let dayStr = d.toLocaleString("en-US", {
    weekday: "short",
    month: "short",
    day: "numeric",
  });

  // ✅ FIX: Format date manually without timezone conversion
  const yyyy = d.getFullYear();
  const mm = String(d.getMonth() + 1).padStart(2, "0");
  const dd = String(d.getDate()).padStart(2, "0");
  const formattedDate = `${yyyy}-${mm}-${dd}`;

  $("#selectedDateTextManage")
    .text(dayStr)
    .attr("data-full-date", formattedDate);

  console.log("Date selected:", {
    display: dayStr,
    stored: formattedDate,
    day: selectedCalendarDayManage,
  });

  $("#calendarModalBackdropManage").fadeOut(100);
});
$("#calendarModalBackdropManage").on("mousedown", function (e) {
  if (e.target === this) $(this).fadeOut(100);
});

// --- Custom Time Dropdown ---
function buildTimeOptions() {
  let html = "",
    sel = "selected";
  // Generate standardized times from 12:00 AM to 11:30 PM with 30-minute intervals
  for (let h = 0; h < 24; h++) {
    for (let m = 0; m < 60; m += 30) {
      let hour12 = h % 12 === 0 ? 12 : h % 12;
      let period = h >= 12 ? "PM" : "AM";
      let mm = m < 10 ? "0" + m : m;
      let tstr = `${hour12}:${mm} ${period}`;
      html += `<div class="one2one-time-option ${sel}">${tstr}</div>`;
      sel = "";
    }
  }
  return html;
}
$("#customTimeDropdownList").html(buildTimeOptions()); // Every 30min from 12:00 AM to 11:30 PM

$("#customTimeDropdownDisplay").on("click", function () {
  $("#customTimeDropdownList").toggle();
  $(this).toggleClass("active");
});
$(document).on("click", ".one2one-time-option", function () {
  $("#customTimeDropdownList .one2one-time-option").removeClass("selected");
  $(this).addClass("selected");
  $("#customTimeDropdownDisplay").text($(this).text());
  $("#customTimeDropdownList").hide();
});
$(document).on("mousedown", function (event) {
  if (!$(event.target).closest("#customTimeDropdownWrapper").length) {
    $("#customTimeDropdownList").hide();
    $("#customTimeDropdownDisplay").removeClass("active");
  }
});

//=======================Teacher Dropdown list start====================================//
(function ($) {
  const $widget = $("#calendar_admin_details_create_cohort_class_tab_widget");
  const $trigger = $("#calendar_admin_details_create_cohort_class_tab_trigger");
  const $menuWrap = $("#calendar_admin_details_create_cohort_class_tab_menu");
  const $panel = $("#calendar_admin_details_create_cohort_class_tab_list");
  const $label = $(
    "#calendar_admin_details_create_cohort_class_tab_current_label"
  );
  const $img = $("#calendar_admin_details_create_cohort_class_tab_current_img");

  function openMenu() {
    $widget.addClass("calendar_admin_details_create_cohort_class_tab_open");
    $trigger.attr("aria-expanded", "true");
    $menuWrap.show();
  }
  function closeMenu() {
    $widget.removeClass("calendar_admin_details_create_cohort_class_tab_open");
    $trigger.attr("aria-expanded", "false");
    $menuWrap.hide();
  }

  $trigger.on("click", function (e) {
    e.stopPropagation();
    $menuWrap.is(":visible") ? closeMenu() : openMenu();
  });

  $panel.on(
    "click",
    ".calendar_admin_details_create_cohort_class_tab_item",
    function () {
      const name = $(this).data("name");
      const src = $(this).data("img");
      $panel
        .find(
          '.calendar_admin_details_create_cohort_class_tab_item[aria-selected="true"]'
        )
        .removeAttr("aria-selected");
      $(this).attr("aria-selected", "true");
      $label.text(name);
      $img.attr("src", src).attr("alt", name);
      closeMenu();
    }
  );

  $(document).on("click", function (e) {
    if (
      !$(e.target).closest(
        ".calendar_admin_details_create_cohort_class_tab_wrap"
      ).length
    ) {
      closeMenu();
    }
  });
})(jQuery);

(function ($) {
  const $widget = $(
    "#calendar_admin_details_create_cohort_manage_class_tab_widget"
  );
  const $trigger = $(
    "#calendar_admin_details_create_cohort_manage_class_tab_trigger"
  );
  const $menuWrap = $(
    "#calendar_admin_details_create_cohort_manage_class_tab_menu"
  );
  const $panel = $(
    "#calendar_admin_details_create_cohort_manage_class_tab_list"
  );
  const $label = $(
    "#calendar_admin_details_create_cohort_manage_class_tab_current_label"
  );
  const $img = $(
    "#calendar_admin_details_create_cohort_manage_class_tab_current_img"
  );

  function openMenu() {
    $widget.addClass(
      "calendar_admin_details_create_cohort_manage_class_tab_open"
    );
    $trigger.attr("aria-expanded", "true");
    $menuWrap.show();
  }
  function closeMenu() {
    $widget.removeClass(
      "calendar_admin_details_create_cohort_manage_class_tab_open"
    );
    $trigger.attr("aria-expanded", "false");
    $menuWrap.hide();
  }
  $("#calendar_admin_details_create_cohort_class_tab_trigger").on(
    "click",
    function (e) {
      e.stopPropagation();
      $("#one2oneStudentDropdown").hide();
      $("#one2oneAddStudentBtn").removeClass("active");

      $menuWrap.is(":visible") ? closeMenu() : openMenu();
    }
  );
  $trigger.on("click", function (e) {
    e.stopPropagation();

    // 🔹 Close student dropdowns when teacher dropdown opens
    $("#one2oneStudentDropdown, #one2oneStudentDropdownManage").hide();
    $("#one2oneAddStudentBtn, #one2oneAddStudentBtnManage").removeClass(
      "active"
    );

    $menuWrap.is(":visible") ? closeMenu() : openMenu();
  });

  $panel.on(
    "click",
    ".calendar_admin_details_create_cohort_manage_class_tab_item",
    function () {
      const name = $(this).data("name");
      const src = $(this).data("img");
      $panel
        .find(
          '.calendar_admin_details_create_cohort_manage_class_tab_item[aria-selected="true"]'
        )
        .removeAttr("aria-selected");
      $(this).attr("aria-selected", "true");
      $label.text(name);
      $img.attr("src", src).attr("alt", name);
      // 🧠 Get teacher ID and auto-select first student
      const teacherId = $(this).data("userid") || null;
      const $firstStudent = $(
        "#one2oneStudentDropdown .one2one-student-list-item-class"
      ).first();

      // ✅ Only proceed if a student element actually exists *and* has a user ID
      const studentId = $firstStudent.data("userid");

      if ($firstStudent.length && studentId) {
        // Highlight first student visually
        $(
          "#one2oneStudentDropdown .one2one-student-list-item-class"
        ).removeClass("selected");
        $firstStudent.addClass("selected");

        // Log teacher/student
        console.log(
          `👨‍🏫 Teacher ID: ${
            teacherId ?? "N/A"
          } | 👨‍🎓 Auto-selected Student ID: ${studentId}`
        );

        // Reflect on “Add student” button
        const studentName = $firstStudent
          .find(".one2one-student-list-name")
          .text();
        const avatarSVG = $firstStudent
          .find(".one2one-student-list-avatar")
          .html();
        $("#one2oneAddStudentBtnManage")
          .html(
            `
      <span class="one2one-add-student-icon">${avatarSVG}</span>
      <span style="font-weight:600; color:#232323;">${studentName}</span>
    `
          )
          .addClass("active");
      } else {
        // ✅ No valid student found — skip console log
        console.log(
          `👨‍🏫 Teacher ID: ${teacherId ?? "N/A"} | 🚫 No students available`
        );
      }

      closeMenu();
    }
  );

  $(document).on("click", function (e) {
    if (
      !$(e.target).closest(
        ".calendar_admin_details_create_cohort_manage_class_tab_wrap"
      ).length
    ) {
      closeMenu();
    }
  });
})(jQuery);

//=======================Teacher Dropdown list END====================================//

// ========================================
// SINGLE LESSON DROPDOWN
// ========================================

// Toggle single lesson dropdown on display click
$("#singleLessonDropdownDisplayManage").on("click", function () {
  $("#single-lesson-dropdown-section").toggle();
  $(this).toggleClass("active");
});

// Select a single lesson item
$(document).on("click", ".single-lesson-dropdown-item", function (e) {
  e.stopPropagation();

  // Remove previous selection
  $(".single-lesson-dropdown-item").removeClass("selected");

  // Add selection to clicked item
  $(this).addClass("selected");

  // Get the lesson details
  var month = $(this).find(".single-lesson-dropdown-date-month").text();
  var day = $(this).find(".single-lesson-dropdown-date-day").text();
  var timeText = $(this).find(".single-lesson-dropdown-details-time").text();

  // Format: "Jan 19, Sunday, 10:00 AM - 10:50 AM"
  var displayText = month + " " + day + ", " + timeText;

  // Update the display with selected lesson
  $("#singleLessonDropdownDisplayManage").text(displayText);

  // Hide the dropdown
  $("#single-lesson-dropdown-section").hide();
  $("#singleLessonDropdownDisplayManage").removeClass("active");
});

// Close single lesson dropdown when clicking outside
$(document).on("mousedown", function (event) {
  if (!$(event.target).closest("#singleLessonDropdownWrapper").length) {
    $("#single-lesson-dropdown-section").hide();
    $("#singleLessonDropdownDisplayManage").removeClass("active");
  }
});

// ========================================
// WEEKLY LESSON DROPDOWN
// ========================================

// Toggle weekly lesson dropdown on display click
$("#weeklyLessonDropdownDisplayManage").on("click", function () {
  $("#weekly-single-lesson").toggle();
  $(this).toggleClass("active");
});

// Select a weekly lesson item
$(document).on("click", ".weekly-single-lesson-item", function (e) {
  e.stopPropagation();

  // Remove previous selection
  $(".weekly-single-lesson-item").removeClass("selected");

  // Add selection to clicked item
  $(this).addClass("selected");

  // Get the lesson time text
  var timeText = $(this).find(".weekly-single-lesson-time").text();

  // Update the display with selected lesson
  $("#weeklyLessonDropdownDisplayManage").text(timeText);

  // Hide the dropdown
  $("#weekly-single-lesson").hide();
  $("#weeklyLessonDropdownDisplayManage").removeClass("active");
});

// Close weekly lesson dropdown when clicking outside
$(document).on("mousedown", function (event) {
  if (!$(event.target).closest("#weeklyLessonDropdownWrapper").length) {
    $("#weekly-single-lesson").hide();
    $("#weeklyLessonDropdownDisplayManage").removeClass("active");
  }
});
