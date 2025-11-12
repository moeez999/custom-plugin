$(function () {
  /* If this stray token exists anywhere, remove it from your file:
     });className1DropdownList_manage_cohort
  */

  // Scope to MANAGE tab
  const $manage = $('#manage_cohort_tab_content');

  // 1) Find nav and the specific row that holds Teacher 1 & 2 (the row right after nav)
  const $nav = $manage.find('.calendar_admin_details_create_cohort_event_nav').first();
  const $row = $nav.nextAll('.calendar_admin_details_create_cohort_row').first();

  if ($row.length === 0) {
    // Nothing to wire up
    return;
  }

  // Helper: the teacher columns are the direct children of $row that contain the teacher dropdown wrapper
  function $teacherCols() {
    return $row.children('div').filter(function () {
      return $(this).find('.calendar_admin_details_create_cohort_teacher_dropdown_wrapper').length > 0;
    });
  }

  let left = 1; // 1-based index of the LEFT visible column

  function render() {
    const $cols = $teacherCols();
    const total = $cols.length;
    if (!total) return;

    // Clamp so we always show a valid pair
    if (left < 1) left = 1;
    if (left > Math.max(1, total - 1)) left = Math.max(1, total - 1);

    // Hide all teacher columns, then show the two we want
    $cols.css('display', 'none');
    $cols.eq(left - 1).css('display', '');           // left
    if (left < total) $cols.eq(left).css('display', ''); // right (if exists)

    // Toggle delete visibility and nav disabled states (optional UX)
    $nav.find('.calendar_admin_details_create_cohort_remove').toggle(total > 2);
    $nav.find('.prev').prop('disabled', left === 1);
    $nav.find('.next').prop('disabled', left >= total - 1);

    // Ensure color dropdowns aren't left open when sliding
    $manage.find('.create_new_cohort_tab_select_color_left_list, .create_new_cohort_tab_select_color_right_list').hide();
    $manage.find('.create_new_cohort_tab_select_color_left_dropdown, .create_new_cohort_tab_select_color_right_dropdown').removeClass('open');
  }

  // ====== Build a new teacher column (no IDs needed) ======
  function buildTeacherColumn(n) {
    return `
      <div>
        <div class="calendar_admin_details_create_cohort_teacher_dropdown_wrapper">
          <label>Teacher ${n}</label>
          <div class="calendar_admin_details_create_cohort_teacher_btn">
            Select Teacher
            <svg viewBox="0 0 20 20"><path d="M7 8l3 3 3-3"></path></svg>
          </div>
          <div class="calendar_admin_details_create_cohort_teacher_list">
            <ul>
              <li><img src="https://randomuser.me/api/portraits/women/45.jpg" class="calendar_admin_details_create_cohort_teacher_avatar"><span style="margin-left:10px">Maria</span></li>
              <li><img src="https://randomuser.me/api/portraits/men/38.jpg" class="calendar_admin_details_create_cohort_teacher_avatar"><span style="margin-left:10px">Joseph</span></li>
              <li><img src="https://randomuser.me/api/portraits/women/32.jpg" class="calendar_admin_details_create_cohort_teacher_avatar"><span style="margin-left:10px">Lisa</span></li>
              <li><img src="https://randomuser.me/api/portraits/men/21.jpg" class="calendar_admin_details_create_cohort_teacher_avatar"><span style="margin-left:10px">Fox</span></li>
            </ul>
          </div>
        </div>

        <div class="calendar_admin_details_create_cohort_class_dropdown_wrapper">
          <label>Class Name</label>
          <div class="calendar_admin_details_create_cohort_class_btn">
            Select Class
            <svg viewBox="0 0 20 20"><path d="M7 8l3 3 3-3"></path></svg>
          </div>
          <div class="calendar_admin_details_create_cohort_class_list">
            <ul>
              <li>Main Class</li>
              <li>Tutoring Class</li>
              <li>Conversational Class</li>
            </ul>
          </div>
        </div>

        <div class="cohort_schedule_box">
          <div class="cohort_schedule_header">
            <span class="cohort_schedule_icon">&#9432;</span>
            <span>Tutoring Schedule</span>
          </div>
          <button type="button" class="cohort_schedule_btn">
            Does not repeat
            <span class="cohort_schedule_arrow">&#9660;</span>
          </button>
        </div>

        <div class="d-flex" style="margin-top:10px;">
          <div class="custom-time-pill">
            <input type="text" class="form-control time-input" value="9:30 am" autocomplete="off" readonly style="background-color:#ffffff;"/>
            <div class="custom-time-dropdown"></div>
          </div>
          <div class="time-dash">–</div>
          <div class="custom-time-pill">
            <input type="text" class="form-control time-input" value="10:30 am" autocomplete="off" readonly style="background-color:#ffffff;"/>
            <div class="custom-time-dropdown"></div>
          </div>
        </div>

        <div class="calendar_admin_details_cohort_tab_timezone_wrapper_right">
          <label class="calendar_admin_details_cohort_tab_timezone_label_right">Event time zone (Right)</label>
          <div class="calendar_admin_details_cohort_tab_timezone_dropdown_right">
            <span>(GMT+05:00) Pakistan</span>
            <svg class="calendar_admin_details_cohort_tab_timezone_arrow_right" width="18" height="18" viewBox="0 0 20 20">
              <path d="M7 8l3 3 3-3" stroke="#232323" stroke-width="2" fill="none" stroke-linecap="round"/>
            </svg>
            <div class="calendar_admin_details_cohort_tab_timezone_list_right">
              <ul>
                <li>(GMT+00:00) London</li>
                <li>(GMT+01:00) Berlin, Paris</li>
                <li>(GMT+03:00) Moscow, Nairobi</li>
                <li>(GMT+05:00) Pakistan</li>
                <li>(GMT+05:30) India</li>
                <li>(GMT+08:00) Beijing, Singapore</li>
                <li>(GMT+09:00) Tokyo, Seoul</li>
                <li>(GMT+10:00) Sydney</li>
                <li>(GMT-05:00) Eastern Time (US & Canada)</li>
                <li>(GMT-06:00) Central Time (US & Canada)</li>
                <li>(GMT-07:00) Mountain Time (US & Canada)</li>
                <li>(GMT-08:00) Pacific Time (US & Canada)</li>
              </ul>
            </div>
          </div>
        </div>

        <label style="margin-top:20px;">Start On</label>
        <button class="conference_modal_date_btn">Select Date</button>

        <div class="create_new_cohort_tab_select_color_right_row">
          <label class="create_new_cohort_tab_select_color_right_label">Find a time</label>
          <div class="create_new_cohort_tab_select_color_right_dropdown">
            <span class="create_new_cohort_tab_select_color_right_selected">
              <span class="create_new_cohort_tab_select_color_right_circle" style="background:#1649c7"></span>
            </span>
            <svg width="18" height="18" class="create_new_cohort_tab_select_color_right_arrow" viewBox="0 0 20 20">
              <path d="M7 8l3 3 3-3" stroke="#232323" stroke-width="2" fill="none" stroke-linecap="round"/>
            </svg>
            <div class="create_new_cohort_tab_select_color_right_list">
              <ul>
                <li data-color="#1649c7" style="background:#1649c7"></li>
                <li data-color="#20a88e" style="background:#20a88e"></li>
                <li data-color="#3f3f48" style="background:#3f3f48"></li>
                <li data-color="#fe2e0c" style="background:#fe2e0c"></li>
                <li data-color="#daa520" style="background:#daa520"></li>
              </ul>
            </div>
          </div>
        </div>
      </div>
    `;
  }

  // Initial paint (show first two)
  render();

  // ===== Nav buttons =====
  $nav.on('click', '.prev', function (e) {
    e.preventDefault();
    if (left > 1) { left--; render(); }
  });

  $nav.on('click', '.next', function (e) {
    e.preventDefault();
    const total = $teacherCols().length;
    if (left < total - 1) { left++; render(); }
  });

  // + Add teacher (keeps current slide; new one visible on ›)
  $nav.on('click', '.calendar_admin_details_create_cohort_add', function (e) {
    e.preventDefault();
    const n = $teacherCols().length + 1;
    $row.append(buildTeacherColumn(n));
    render();
  });

  // 🗑 Remove last teacher (snap back to 1–2 when <=2)
  $nav.on('click', '.calendar_admin_details_create_cohort_remove', function (e) {
    e.preventDefault();
    const $cols = $teacherCols();
    if ($cols.length <= 2) return;
    $cols.last().remove();
    if ($teacherCols().length <= 2) left = 1;
    else left = Math.min(left, $teacherCols().length - 1);
    render();
  });

  /* ===== Delegated dropdowns inside the manage tab (work for new blocks) ===== */
  // Teacher dropdown
  $manage.on('click', '.calendar_admin_details_create_cohort_teacher_btn', function (e) {
    e.stopPropagation();
    const $list = $(this).siblings('.calendar_admin_details_create_cohort_teacher_list');
    $manage.find('.calendar_admin_details_create_cohort_teacher_list').not($list).hide();
    $list.toggle();
  });
  $manage.on('click', '.calendar_admin_details_create_cohort_teacher_list li', function () {
    const html = $(this).html() + '<svg viewBox="0 0 20 20"><path d="M7 8l3 3 3-3"></path></svg>';
    $(this).closest('.calendar_admin_details_create_cohort_teacher_dropdown_wrapper')
           .find('.calendar_admin_details_create_cohort_teacher_btn')
           .html(html);
    $(this).closest('.calendar_admin_details_create_cohort_teacher_list').hide();
  });

  // Class dropdown
  $manage.on('click', '.calendar_admin_details_create_cohort_class_btn', function (e) {
    e.stopPropagation();
    const $list = $(this).siblings('.calendar_admin_details_create_cohort_class_list');
    $manage.find('.calendar_admin_details_create_cohort_class_list').not($list).hide();
    $list.toggle();
  });
  $manage.on('click', '.calendar_admin_details_create_cohort_class_list li', function () {
    $(this).closest('.calendar_admin_details_create_cohort_class_dropdown_wrapper')
           .find('.calendar_admin_details_create_cohort_class_btn')
           .contents().first()[0].textContent = $(this).text() + ' ';
    $(this).closest('.calendar_admin_details_create_cohort_class_list').hide();
  });

  // Right timezone
  $manage.on('click', '.calendar_admin_details_cohort_tab_timezone_dropdown_right', function (e) {
    e.stopPropagation();
    const $list = $(this).find('.calendar_admin_details_cohort_tab_timezone_list_right');
    $manage.find('.calendar_admin_details_cohort_tab_timezone_list_right').not($list).hide();
    $list.toggle();
  });
  $manage.on('click', '.calendar_admin_details_cohort_tab_timezone_list_right li', function (e) {
    e.stopPropagation();
    $(this).closest('.calendar_admin_details_cohort_tab_timezone_dropdown_right')
           .find('span').first().text($(this).text());
    $(this).closest('.calendar_admin_details_cohort_tab_timezone_list_right').hide();
  });

  /* ===== Find-a-time color dropdowns (Manage tab) ===== */
  // Toggle open (works for both left & right, and for dynamically added columns)
  $manage.on('click',
    '.create_new_cohort_tab_select_color_left_dropdown, .create_new_cohort_tab_select_color_right_dropdown',
    function (e) {
      e.stopPropagation();
      const $dd = $(this);
      const $myList = $dd.find('.create_new_cohort_tab_select_color_left_list, .create_new_cohort_tab_select_color_right_list');

      // Close others in Manage tab
      $manage.find('.create_new_cohort_tab_select_color_left_list, .create_new_cohort_tab_select_color_right_list')
             .not($myList).hide();
      $manage.find('.create_new_cohort_tab_select_color_left_dropdown.open, .create_new_cohort_tab_select_color_right_dropdown.open')
             .not($dd).removeClass('open');

      // Toggle mine
      $dd.toggleClass('open');
      $myList.toggle();
    }
  );

  // Pick a color
  $manage.on('click',
    '.create_new_cohort_tab_select_color_left_list li, .create_new_cohort_tab_select_color_right_list li',
    function (e) {
      e.stopPropagation();
      const color = $(this).data('color') || $(this).css('background-color');
      const $dd = $(this).closest('.create_new_cohort_tab_select_color_left_dropdown, .create_new_cohort_tab_select_color_right_dropdown');

      // Update the little circle inside this dropdown
      $dd.find('.create_new_cohort_tab_select_color_left_circle, .create_new_cohort_tab_select_color_right_circle')
         .css('background', color);

      $(this).addClass('selected').siblings().removeClass('selected');

      // Close the list
      $dd.removeClass('open')
         .find('.create_new_cohort_tab_select_color_left_list, .create_new_cohort_tab_select_color_right_list')
         .hide();
    }
  );

  // Global click-away for manage tab dropdowns (include color lists)
  $(document).on('click', function () {
    $manage.find(
      '.calendar_admin_details_create_cohort_teacher_list, ' +
      '.calendar_admin_details_create_cohort_class_list, ' +
      '.calendar_admin_details_cohort_tab_timezone_list_right, ' +
      '.create_new_cohort_tab_select_color_left_list, ' +
      '.create_new_cohort_tab_select_color_right_list'
    ).hide();

    $manage.find(
      '.create_new_cohort_tab_select_color_left_dropdown.open, ' +
      '.create_new_cohort_tab_select_color_right_dropdown.open'
    ).removeClass('open');
  });

  // ESC closes color lists
  $(document).on('keydown', function (e) {
    if (e.key === 'Escape') {
      $manage.find('.create_new_cohort_tab_select_color_left_list, .create_new_cohort_tab_select_color_right_list').hide();
      $manage.find('.create_new_cohort_tab_select_color_left_dropdown.open, .create_new_cohort_tab_select_color_right_dropdown.open').removeClass('open');
    }
  });

  // If the tab becomes visible later, re-render to ensure pair is correct
  $manage.on('show', render); // call manually if you trigger custom events on tab switch
});
