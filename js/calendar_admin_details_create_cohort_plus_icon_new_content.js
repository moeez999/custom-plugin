$(function () {
  /* -----------------------------------------------------------
   *  A) Neutralize the old per-ID handlers that conflict
   * --------------------------------------------------------- */
  $('#teacher1DropdownBtn, #teacher2DropdownBtn, #className1DropdownBtn, #className2DropdownBtn, #eventTimezoneDropdownRight').off('click');
  $('#teacher1DropdownList li, #teacher2DropdownList li, #className1DropdownList li, #className2DropdownList li, #eventTimezoneDropdownListRight li').off('click');

  /* -----------------------------------------------------------
   *  B) Two-up teacher carousel + Add & Remove buttons
   * --------------------------------------------------------- */
  const $wrap = $('#teacherBlocks');    // the row that holds teacher columns
  let currentLeft = 1;                  // 1-based index of LEFT visible card

  function countTeachers() { return $wrap.children('.teacher-block').length; }

  function renderTwoUp() {
    const leftIdx0 = Math.max(0, currentLeft - 1);
    $wrap.children('.teacher-block').hide();
    $wrap.children('.teacher-block').eq(leftIdx0).css('display','block');
    $wrap.children('.teacher-block').eq(leftIdx0 + 1).css('display','block');
    updateDeleteVisibility();
  }

  function updateDeleteVisibility() {
    // Hide trash when only the original two exist
    const canDelete = countTeachers() > 2;
    $('.calendar_admin_details_create_cohort_event_nav .calendar_admin_details_create_cohort_remove').toggle(canDelete);
  }

  // Build a new teacher block (class-based selectors only)
  function buildTeacherBlock(n) {
    return `
      <div class="teacher-block" data-teacher="${n}">
        <div class="calendar_admin_details_create_cohort_teacher_dropdown_wrapper">
          <label>Teacher ${n}</label>
          <div class="calendar_admin_details_create_cohort_teacher_btn">
            Select Teacher
            <svg viewBox="0 0 20 20"><path d="M7 8l3 3 3-3"></path></svg>
          </div>
          <div class="calendar_admin_details_create_cohort_teacher_list">
            <ul>
              <li><img src="https://randomuser.me/api/portraits/women/45.jpg" class="calendar_admin_details_create_cohort_teacher_avatar"><span style='margin-left:10px;'>Maria</span></li>
              <li><img src="https://randomuser.me/api/portraits/men/38.jpg" class="calendar_admin_details_create_cohort_teacher_avatar"> <span style='margin-left:10px;'>Joseph</span></li>
              <li><img src="https://randomuser.me/api/portraits/women/32.jpg" class="calendar_admin_details_create_cohort_teacher_avatar"><span style='margin-left:10px;'> Lisa</span></li>
              <li><img src="https://randomuser.me/api/portraits/men/21.jpg" class="calendar_admin_details_create_cohort_teacher_avatar"><span style='margin-left:10px;'> Fox</span></li>
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

        <div class="d-flex calendar_admin_details_time_right" style="margin-top:10px;">
          <div class="calendar_admin_details_time_right_time-pill">
            <input type="text" class="form-control calendar_admin_details_time_right_time-input" value="9:30 am" autocomplete="off" readonly style="background-color:#ffffff;"/>
            <div class="calendar_admin_details_time_right_time-dropdown"></div>
          </div>
          <div class="calendar_admin_details_time_right_time-dash">–</div>
          <div class="calendar_admin_details_time_right_time-pill">
            <input type="text" class="form-control calendar_admin_details_time_right_time-input" value="10:30 am" autocomplete="off" readonly style="background-color:#ffffff;"/>
            <div class="calendar_admin_details_time_right_time-dropdown"></div>
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

  // Initial render (Teacher 1 & 2)
  renderTwoUp();

  // Prev/Next
  $('.calendar_admin_details_create_cohort_event_nav .prev').off('click').on('click', function () {
    if (currentLeft > 1) { currentLeft--; renderTwoUp(); }
  });
  $('.calendar_admin_details_create_cohort_event_nav .next').off('click').on('click', function () {

    if (currentLeft < countTeachers() - 1) { currentLeft++; renderTwoUp(); }
  });

  // + Add teacher (new teacher stays hidden until you press ›)
  $('.calendar_admin_details_create_cohort_event_nav .calendar_admin_details_create_cohort_add')
    .off('click').on('click', function () {
      const n = countTeachers() + 1;
      $wrap.append(buildTeacherBlock(n));
      renderTwoUp();                 // keep currentLeft; new card hidden
    });

  // 🗑 Remove last teacher (go back to Teacher 1 & 2 if only two remain)
  $('.calendar_admin_details_create_cohort_event_nav .calendar_admin_details_create_cohort_remove')
    .off('click').on('click', function () {
      if (countTeachers() <= 2) return;         // nothing to delete
      $wrap.children('.teacher-block').last().remove();

      // If we're back to 2, restore the “old flow” (1 & 2)
      if (countTeachers() <= 2) currentLeft = 1;
      else currentLeft = Math.min(currentLeft, countTeachers() - 1);

      renderTwoUp();
    });

  /* -----------------------------------------------------------
   *  C) Delegated dropdowns (work for existing and new blocks)
   * --------------------------------------------------------- */
  // Teacher dropdown
  $(document).on('click', '.teacher-block .calendar_admin_details_create_cohort_teacher_btn', function (e) {
    e.stopPropagation();
    const $list = $(this).siblings('.calendar_admin_details_create_cohort_teacher_list');
    $('.calendar_admin_details_create_cohort_teacher_list').not($list).hide();
    $list.toggle();
  });
  $(document).on('click', '.teacher-block .calendar_admin_details_create_cohort_teacher_list li', function () {
    const html = $(this).html() + '<svg viewBox="0 0 20 20"><path d="M7 8l3 3 3-3"></path></svg>';
    $(this).closest('.calendar_admin_details_create_cohort_teacher_dropdown_wrapper')
           .find('.calendar_admin_details_create_cohort_teacher_btn')
           .html(html);
    $(this).closest('.calendar_admin_details_create_cohort_teacher_list').hide();
  });

  // Class dropdown
  $(document).on('click', '.teacher-block .calendar_admin_details_create_cohort_class_btn', function (e) {
    e.stopPropagation();
    const $list = $(this).siblings('.calendar_admin_details_create_cohort_class_list');
    $('.calendar_admin_details_create_cohort_class_list').not($list).hide();
    $list.toggle();
  });
  $(document).on('click', '.teacher-block .calendar_admin_details_create_cohort_class_list li', function () {
    $(this).closest('.calendar_admin_details_create_cohort_class_dropdown_wrapper')
           .find('.calendar_admin_details_create_cohort_class_btn')
           .contents().first()[0].textContent = $(this).text() + ' ';
    $(this).closest('.calendar_admin_details_create_cohort_class_list').hide();
  });

  // Right timezone dropdown
  $(document).on('click', '.teacher-block .calendar_admin_details_cohort_tab_timezone_dropdown_right', function (e) {
    e.stopPropagation();
    const $list = $(this).find('.calendar_admin_details_cohort_tab_timezone_list_right');
    $('.calendar_admin_details_cohort_tab_timezone_list_right').not($list).hide();
    $list.toggle();
  });
  $(document).on('click', '.teacher-block .calendar_admin_details_cohort_tab_timezone_list_right li', function (e) {
    e.stopPropagation();
    $(this).closest('.calendar_admin_details_cohort_tab_timezone_dropdown_right')
           .find('span').first().text($(this).text());
    $(this).closest('.calendar_admin_details_cohort_tab_timezone_list_right').hide();
  });

  // Click-away close
  $(document).on('click', function () {
    $('.teacher-block .calendar_admin_details_create_cohort_teacher_list, \
       .teacher-block .calendar_admin_details_create_cohort_class_list, \
       .teacher-block .calendar_admin_details_cohort_tab_timezone_list_right').hide();
  });

  /* -----------------------------------------------------------
   *  D) Keep your existing special rule for Teacher 1 -> cohort
   * --------------------------------------------------------- */
});















// === Find-a-time color dropdowns inside teacher blocks (works for NEW cards) ===
(function ($) {
  // Open/close (Left + Right variants)
  $(document).on(
    'click',
    '.teacher-block .create_new_cohort_tab_select_color_left_dropdown, ' +
    '.teacher-block .create_new_cohort_tab_select_color_right_dropdown',
    function (e) {
      e.stopPropagation();
      const $dd   = $(this);
      const $list = $dd.find(
        '.create_new_cohort_tab_select_color_left_list, ' +
        '.create_new_cohort_tab_select_color_right_list'
      );

      // Close any other open color lists in other teacher blocks
      $('.create_new_cohort_tab_select_color_left_list, .create_new_cohort_tab_select_color_right_list')
        .not($list).hide();

      $list.toggle();
    }
  );

  // Pick a color
  $(document).on(
    'click',
    '.teacher-block .create_new_cohort_tab_select_color_left_list li, ' +
    '.teacher-block .create_new_cohort_tab_select_color_right_list li',
    function (e) {
      e.stopPropagation();
      const color = $(this).data('color');
      const $dd   = $(this).closest(
        '.create_new_cohort_tab_select_color_left_dropdown, ' +
        '.create_new_cohort_tab_select_color_right_dropdown'
      );

      // Update the little circle swatch inside this dropdown
      $dd.find(
        '.create_new_cohort_tab_select_color_left_circle, ' +
        '.create_new_cohort_tab_select_color_right_circle'
      ).css('background', color);

      // Close just this menu
      $(this).closest(
        '.create_new_cohort_tab_select_color_left_list, ' +
        '.create_new_cohort_tab_select_color_right_list'
      ).hide();
    }
  );

  // Click-away close for these color lists (doesn't touch other menus)
  $(document).on('click', function () {
    $('.create_new_cohort_tab_select_color_left_list, .create_new_cohort_tab_select_color_right_list').hide();
  });
})(jQuery);
