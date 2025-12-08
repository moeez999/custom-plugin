let startDate = new Date();
startDate.setHours(0, 0, 0, 0);
// Always set to Monday of current week
startDate.setDate(startDate.getDate() - ((startDate.getDay() + 6) % 7));

// ====== DATE RANGE ======
function getDateRangeText2(startDate) {
  let endDate = new Date(startDate);
  endDate.setDate(endDate.getDate() + 6);
  let opts = { month: "long" };
  let m1 = startDate.toLocaleString("default", opts);
  let d1 = startDate.getDate();
  let m2 = endDate.toLocaleString("default", opts);
  let d2 = endDate.getDate();
  let y = startDate.getFullYear();
  if (m1 !== m2) return `${m1} ${d1} - ${m2} ${d2}, ${y}`;
  return `${m1} ${d1} - ${d2}, ${y}`;
}

function renderTopbarRange() {
  $("#calendar-range").text(getDateRangeText2(startDate));
}

// ====== WEEK NAVIGATION ======
function prevWeek() {
  startDate.setDate(startDate.getDate() - 7);
  updateCalendar();
}
function nextWeek() {
  startDate.setDate(startDate.getDate() + 7);
  updateCalendar();
}
function goToday() {
  startDate = new Date();
  updateCalendar();
}

// ====== TAB SWITCHING ======
function switchTab(tab) {
  if (tab === "agenda") {
    $("#agenda-btn").addClass("active");
    $("#semana-btn").removeClass("active");
    $("#calendar-grid-wrapper").hide();
    $("#agendaList").show();
  } else {
    $("#agenda-btn").removeClass("active");
    $("#semana-btn").addClass("active");
    $("#calendar-grid-wrapper").show();
    $("#agendaList").hide();
  }
}

// ====== UPDATE CALENDAR ======
function updateCalendar() {
  renderTopbarRange();
  // no hours, days, or grid rendering
}

// ====== DROPDOWN HELPERS ======

function showDropdownMenu($trigger, $dropdown) {
  closeAllDropdowns();
  let offset = $trigger.offset();
  let height = $trigger.outerHeight();
  $dropdown.css({
    display: "block",
    top: offset.top + height + 4,
    left: offset.left,
  });
}

// ====== DOCUMENT READY ======
$(function () {
  updateCalendar();
  $("#agendaList").hide();

  // Dropdown actions
  $("#cohort-select").click(function (e) {
    e.stopPropagation();
    showDropdownMenu($(this), $("#cohort-dropdown"));
    $("#profile-dropdown").hide();
  });
  $("#profile-dropdown-trigger").click(function (e) {
    e.stopPropagation();
    showDropdownMenu($(this), $("#profile-dropdown"));
    $("#cohort-dropdown").hide();
  });

  $(document).click(function () {
    closeAllDropdowns();
  });
  $(".dropdown-menu, .profile-menu").click(function (e) {
    e.stopPropagation();
  });

  $("#select-all-cohorts").on("change", function () {
    $(this)
      .closest("form")
      .find('input[type="checkbox"]')
      .not(this)
      .prop("checked", this.checked);
  });

  $(".profile-option").on("click", function () {
    let img = $(this).find("img").attr("src");
    let name = $(this).find(".profile-option-header").text().trim();
    $("#profile-dropdown-trigger .profile-pic").attr("src", img);
    $("#profile-dropdown-trigger")
      .contents()
      .filter(function () {
        return this.nodeType == 3;
      })
      .remove();
    $("#profile-dropdown-trigger").append(document.createTextNode(" " + name));
    $("#profile-dropdown").hide();
  });

  // Tabs
  $("#agenda-btn").click(() => switchTab("agenda"));
  $("#semana-btn").click(() => switchTab("semana"));

  // Navigation
  $("#prev-week").click(() => prevWeek());
  $("#next-week").click(() => nextWeek());
  $("#today-btn").click(() => goToday());
});

$(function () {
  let selectedTeachers = [];

  // Toggle teacher search widget
  $("#teacher-search-trigger").click(function (e) {
    e.stopPropagation();
    const widget = $("#teacher-search-widget");
    const trigger = $(this);
    const offset = trigger.offset();
    const height = trigger.outerHeight();
    closeAllDropdowns();
    if (widget.is(":visible")) {
      widget.hide();
    } else {
      widget.css({
        display: "flex",
        top: offset.top + height + 4,
        left: offset.left,
      });
    }
  });

  // Close widget when clicking outside
  $(document).click(function (e) {
    if (
      !$(e.target).closest("#teacher-search-widget, #teacher-search-trigger")
        .length
    ) {
      $("#teacher-search-widget").hide();
    }
  });

  // Prevent widget from closing when clicking inside
  $("#teacher-search-widget").click(function (e) {
    e.stopPropagation();
  });

  // Handle teacher selection
  $(".teacher-option").click(function () {
    const teacherId = String($(this).data("teacher-id"));
    const teacherName = $(this).data("teacher-name");
    const teacherImg = $(this).data("teacher-img");
    const checkbox = $(this).find(".teacher-checkbox");

    if ($(this).hasClass("selected")) {
      $(this).removeClass("selected");
      checkbox.prop("checked", false);
      selectedTeachers = selectedTeachers.filter(
        (t) => String(t.id) !== teacherId
      );
    } else {
      $(this).addClass("selected");
      checkbox.prop("checked", true);
      selectedTeachers.push({
        id: teacherId,
        name: teacherName,
        img: teacherImg,
      });
    }

    // Save to session storage only if exactly 1 teacher is selected
    if (selectedTeachers.length === 1) {
      sessionStorage.setItem("selectedTeacherId", selectedTeachers[0].id);
    } else {
      sessionStorage.removeItem("selectedTeacherId");
    }

    updateSelectedTeachers();
    updateTriggerDisplay();
  });

  // Update selected teachers display in widget
  function updateSelectedTeachers() {
    const container = $("#selected-teachers-container");
    container.empty();

    if (selectedTeachers.length === 0) {
      container.hide();
    } else {
      container.show();
      selectedTeachers.forEach((teacher) => {
        // inside updateSelectedTeachers()
        const pill = $(`
  <div class="selected-teacher-pill">
    <div class="pill-user-info">
      <div class="pill-avatar-container">
        <img class="pill-avatar" src="${teacher.img}" alt="${teacher.name}">
      </div>
      <span class="pill-user-name">${teacher.name}</span>
    </div>
    <button type="button" class="pill-close-btn" data-teacher-id="${teacher.id}">
      <svg width="15" height="15" viewBox="0 0 15 15" fill="none">
        <path d="M11.25 3.75L3.75 11.25M3.75 3.75L11.25 11.25" stroke="#6a697c" stroke-width="2" stroke-linecap="round"/>
      </svg>
    </button>
  </div>
`);

        container.append(pill);
      });
    }
  }

  // Update trigger button display
  function updateTriggerDisplay() {
    const displayText = $("#teacher-display-text");
    const pillContainer = $("#teacher-pills");

    if (selectedTeachers.length === 0) {
      displayText.text("Select Teachers").show();
      pillContainer.empty();
    } else if (selectedTeachers.length <= 2) {
      displayText.hide();
      pillContainer.empty();
      selectedTeachers.forEach((teacher) => {
        const miniPill = $(`
        <div class="mini-teacher-pill" data-teacher-id="${teacher.id}">
          <img src="${teacher.img}" alt="${teacher.name}">
          <span>${teacher.name}</span>
        </div>
      `);
        pillContainer.append(miniPill);
      });
    } else {
      displayText.text(`${selectedTeachers.length} Teachers`).show();
      pillContainer.empty();
    }
  }

  // Remove teacher from selection
  // Normalize IDs to strings everywhere
  function asId(x) {
    return String(x);
  }

  // Delegate on the static container instead of document (either is fine, this is tighter)
  $("#selected-teachers-container").on(
    "click",
    ".pill-close-btn, .pill-close-btn *",
    function (e) {
      e.stopPropagation();
      e.preventDefault();

      const $btn = $(e.target).closest(".pill-close-btn");
      const teacherId = asId($btn.data("teacher-id"));

      // Remove from selected array
      selectedTeachers = selectedTeachers.filter(
        (t) => asId(t.id) !== teacherId
      );

      // Unselect in the list
      $(`.teacher-option[data-teacher-id="${teacherId}"]`)
        .removeClass("selected")
        .find(".teacher-checkbox")
        .prop("checked", false);

      updateSelectedTeachers();
      updateTriggerDisplay();
    }
  );

  // Remove teacher from mini pills on trigger button
  $(document).on("click", ".mini-teacher-pill", function (e) {
    e.stopPropagation();
    e.preventDefault();

    const teacherId = String($(this).data("teacher-id"));
    selectedTeachers = selectedTeachers.filter((t) => t.id !== teacherId);

    $(`.teacher-option[data-teacher-id="${teacherId}"]`)
      .removeClass("selected")
      .find(".teacher-checkbox")
      .prop("checked", false);

    updateSelectedTeachers();
    updateTriggerDisplay();
  });

  // Search functionality
  $("#teacher-search-input").on("input", function () {
    const searchTerm = $(this).val().toLowerCase();

    $(".teacher-option").each(function () {
      const teacherName = $(this).data("teacher-name").toLowerCase();
      if (teacherName.includes(searchTerm)) {
        $(this).show();
      } else {
        $(this).hide();
      }
    });
  });

  // Auto-select teacher from session storage when page loads or returning from setup availability
  function autoSelectTeacherFromStorage() {
    const savedTeacherId = sessionStorage.getItem("selectedTeacherId");
    const autoSelectTeacherId = sessionStorage.getItem("autoSelectTeacher");
    const teacherIdToSelect = autoSelectTeacherId || savedTeacherId;

    if (teacherIdToSelect) {
      if (autoSelectTeacherId) {
        sessionStorage.removeItem("autoSelectTeacher");
      }

      setTimeout(() => {
        const $teacherOption = $(
          `.teacher-option[data-teacher-id="${teacherIdToSelect}"]`
        );
        if ($teacherOption.length && !$teacherOption.hasClass("selected")) {
          $teacherOption.trigger("click");
        }
      }, 300);
    }
  }

  // Initialize
  updateSelectedTeachers();
  autoSelectTeacherFromStorage();
});

$(function () {
  let selectedStudents = [];

  // --- helpers
  function asId(x) {
    return String(x);
  }

  // Toggle student search widget
  $("#student-search-trigger").click(function (e) {
    e.stopPropagation();
    const widget = $("#student-search-widget");
    const trigger = $(this);
    const offset = trigger.offset();
    const height = trigger.outerHeight();
    closeAllDropdowns();
    if (widget.is(":visible")) {
      widget.hide();
    } else {
      widget.css({
        display: "flex",
        top: offset.top + height + 4,
        left: offset.left,
      });
    }
  });

  // Close widget when clicking outside
  $(document).click(function (e) {
    if (
      !$(e.target).closest("#student-search-widget, #student-search-trigger")
        .length
    ) {
      $("#student-search-widget").hide();
    }
  });

  // Prevent widget from closing when clicking inside
  $("#student-search-widget").click(function (e) {
    e.stopPropagation();
  });

  // Handle student selection
  $(".student-option").click(function () {
    const studentId = String($(this).data("student-id"));
    const studentName = $(this).data("student-name");
    const studentImg = $(this).data("student-img");
    const checkbox = $(this).find(".student-checkbox");

    if ($(this).hasClass("selected")) {
      $(this).removeClass("selected");
      checkbox.prop("checked", false);
      selectedStudents = selectedStudents.filter(
        (s) => asId(s.id) !== studentId
      );
    } else {
      $(this).addClass("selected");
      checkbox.prop("checked", true);
      selectedStudents.push({
        id: studentId,
        name: studentName,
        img: studentImg,
      });
    }

    updateSelectedStudents();
    updateStudentTriggerDisplay();
  });

  // Update selected students display in widget
  function updateSelectedStudents() {
    const container = $("#selected-students-container");
    container.empty();

    if (selectedStudents.length === 0) {
      container.hide();
    } else {
      container.show();
      selectedStudents.forEach((student) => {
        const pill = $(`
          <div class="selected-student-pill">
            <div class="pill-user-info">
              <div class="pill-avatar-container">
                <img class="pill-avatar" src="${student.img}" alt="${student.name}">
              </div>
              <span class="pill-user-name">${student.name}</span>
            </div>
            <button type="button" class="pill-close-btn" data-student-id="${student.id}">
              <svg width="15" height="15" viewBox="0 0 15 15" fill="none">
                <path d="M11.25 3.75L3.75 11.25M3.75 3.75L11.25 11.25" stroke="#6a697c" stroke-width="2" stroke-linecap="round"/>
              </svg>
            </button>
          </div>
        `);
        container.append(pill);
      });
    }
  }

  // Update trigger button display
  function updateStudentTriggerDisplay() {
    const displayText = $("#student-display-text");
    const pillContainer = $("#student-pills");

    if (selectedStudents.length === 0) {
      displayText.text("Select Students").show();
      pillContainer.empty();
    } else if (selectedStudents.length <= 2) {
      displayText.hide();
      pillContainer.empty();
      selectedStudents.forEach((student) => {
        const miniPill = $(`
          <div class="mini-student-pill" data-student-id="${student.id}">
            <img src="${student.img}" alt="${student.name}">
            <span>${student.name}</span>
          </div>
        `);
        pillContainer.append(miniPill);
      });
    } else {
      displayText.text(`${selectedStudents.length} Students`).show();
      pillContainer.empty();
    }
  }

  // Remove student from selection (from big pills)
  $("#selected-students-container").on(
    "click",
    ".pill-close-btn, .pill-close-btn *",
    function (e) {
      e.stopPropagation();
      e.preventDefault();

      const $btn = $(e.target).closest(".pill-close-btn");
      const studentId = asId($btn.data("student-id"));

      selectedStudents = selectedStudents.filter(
        (s) => asId(s.id) !== studentId
      );

      $(`.student-option[data-student-id="${studentId}"]`)
        .removeClass("selected")
        .find(".student-checkbox")
        .prop("checked", false);

      updateSelectedStudents();
      updateStudentTriggerDisplay();
    }
  );

  // Remove student from mini pills on trigger button
  $(document).on("click", ".mini-student-pill", function (e) {
    e.stopPropagation();
    e.preventDefault();

    const studentId = String($(this).data("student-id"));
    selectedStudents = selectedStudents.filter((s) => asId(s.id) !== studentId);

    $(`.student-option[data-student-id="${studentId}"]`)
      .removeClass("selected")
      .find(".student-checkbox")
      .prop("checked", false);

    updateSelectedStudents();
    updateStudentTriggerDisplay();
  });

  // Search functionality
  $("#student-search-input").on("input", function () {
    const searchTerm = $(this).val().toLowerCase();

    $(".student-option").each(function () {
      const studentName = $(this).data("student-name").toLowerCase();
      $(this).toggle(studentName.includes(searchTerm));
    });
  });

  // Initialize
  updateSelectedStudents();
});

$(function () {
  // --- state ---
  const selected = new Map(); // id -> name
  let focusIndex = -1;

  // --- els ---
  const $widget = $("#cohort-search-widget");
  const $trigger = $("#cohort-search-trigger");
  const $input = $("#cohort-search-input");
  const $hidden = $("#cohort-value");
  const $label = $("#cohort-display-text");

  // Ensure inputs act as checkboxes even if HTML says "radio"
  $("#search-cohort .cohort-option .cohort-radio")
    .attr("type", "checkbox")
    .prop("checked", false);

  // Open/position widget
  $trigger.on("click", function (e) {
    e.stopPropagation();
    const off = $trigger.offset();
    const h = $trigger.outerHeight();
    closeAllDropdowns();
    $(".cohort-search-widget-container").not($widget).hide();
    $widget.css({ display: "flex", top: off.top + h + 4, left: off.left });
    setTimeout(() => $input.trigger("focus"), 0);
  });

  // Close on outside / Esc
  $(document).on("click", (e) => {
    if (
      !$(e.target).closest("#cohort-search-widget, #cohort-search-trigger")
        .length
    )
      closeWidget();
  });
  $(document).on("keydown", (e) => {
    if (e.key === "Escape") closeWidget();
  });
  $widget.on("click", (e) => e.stopPropagation());

  // ---- MULTI-SELECT TOGGLE ----
  $("#cohort-search-widget").on("click", ".cohort-option", function (e) {
    const $opt = $(this);
    const id = String($opt.data("cohort-id"));
    const name = $opt.data("cohort-name");
    const $box = $opt.find(".cohort-radio");

    const isOn = $opt.hasClass("selected");
    if (isOn) {
      // turn off
      $opt.removeClass("selected");
      $box.prop("checked", false).val("");
      selected.delete(id);
    } else {
      // turn on
      $opt.addClass("selected");
      $box.prop("checked", true).val(id);
      selected.set(id, name);
    }

    updateDisplay();
    // NOTE: do NOT close widget here; allow multiple picks
  });

  // Live search filter
  $input.on("input", function () {
    const term = $(this).val().toLowerCase();
    let visible = 0;
    $("#search-cohort .cohort-option").each(function () {
      const $opt = $(this);
      const name = ($opt.data("cohort-name") || "").toLowerCase();
      const id = (String($opt.data("cohort-id")) || "").toLowerCase();
      const show = name.includes(term) || id.includes(term);
      $opt.toggle(show);
      if (show) visible++;
    });
    $("#cohort-no-results").toggle(visible === 0);
    focusIndex = -1;
    $("#search-cohort .cohort-option").removeClass("kbd-focus");
  });

  // Keyboard nav (↓/↑ then Enter toggles current)
  function visibleOptions() {
    return $("#search-cohort .cohort-option:visible");
  }
  $input.on("keydown", function (e) {
    const opts = visibleOptions();
    if (!opts.length) return;

    if (e.key === "ArrowDown") {
      e.preventDefault();
      focusIndex = (focusIndex + 1) % opts.length;
      opts.removeClass("kbd-focus");
      $(opts[focusIndex])
        .addClass("kbd-focus")[0]
        .scrollIntoView({ block: "nearest" });
    } else if (e.key === "ArrowUp") {
      e.preventDefault();
      focusIndex = (focusIndex - 1 + opts.length) % opts.length;
      opts.removeClass("kbd-focus");
      $(opts[focusIndex])
        .addClass("kbd-focus")[0]
        .scrollIntoView({ block: "nearest" });
    } else if (e.key === "Enter") {
      e.preventDefault();
      const $pick = focusIndex >= 0 ? $(opts[focusIndex]) : $(opts[0]);
      $pick.trigger("click"); // toggle without closing
    }
  });

  function updateDisplay() {
    const ids = Array.from(selected.keys());
    const names = Array.from(selected.values());

    // Hidden input as comma list (e.g., "FL1,TX1,TX2")
    $hidden.val(ids.join(",")).trigger("change");
    $(document).trigger("cohort:change", { ids, names });

    // Trigger text
    if (names.length === 0) {
      $label.text("Select Cohort");
    } else if (names.length <= 2) {
      $label.text(names.join(", "));
    } else {
      $label.text(`${names.length} cohorts`);
    }
  }

  function closeWidget() {
    $widget.hide();
    focusIndex = -1;
    $("#search-cohort .cohort-option").removeClass("kbd-focus");
  }

  // Keyboard focus style (optional)
  $("<style>")
    .text(
      `
      #search-cohort .cohort-option.kbd-focus{
        outline: 2px solid #121117;
        outline-offset: 2px;
        background: rgba(0,0,0,0.03);
        border-radius: 10px;
      }
      /* visual selected state for cohorts */
      .cohort-option.selected { background-color: rgba(0,0,0,0.03); }
      .cohort-option.selected .radio-custom { border-color: #121117; }
      .cohort-option.selected .radio-custom-dot { display: block; }
    `
    )
    .appendTo(document.head);
});
function closeAllDropdowns() {
  $(
    "#cohort-dropdown, #profile-dropdown, #teacher-search-widget, #cohort-search-widget, #student-search-widget"
  ).hide();
}
