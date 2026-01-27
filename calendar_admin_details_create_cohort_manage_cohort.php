<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="js/toast_utils.js"></script>
<script src="js/api_utils.js"></script>

<!-- Toast Notification -->
<div id="toastNotificationForManageCohort" style="display:none; position:fixed; top:30px; right:30px; 
            background:#000; color:#fff; padding:16px 24px; 
            border-radius:8px; font-size:1rem; 
            box-shadow:0 4px 12px rgba(0,0,0,0.3);
            z-index:99999; opacity:0; transition:opacity .3s, transform .3s;
            transform:translateY(20px);">

</div>

<div class="calendar_admin_details_create_cohort_content tab-content" id="manage_cohort_tab_content"
    style="display:none;">
    <div class="calendar_admin_details_create_cohort_row">
        <div class="calendar_admin_details_create_cohort_dropdown_wrapper">
            <label>Cohort</label>
            <div class="calendar_admin_details_create_cohort_dropdown_btn cohortDropdownBtn" id="cohortDropdownBtn">
                Select Existing Cohort
                <img src="./img/dropdown-arrow-down.svg" alt="dropdown">
            </div>
            <div class="calendar_admin_details_create_cohort_dropdown_list cohortDropdownList" id="cohortDropdownList">
                <strong>Existing Cohorts</strong>
                <ul class="cohortList" id="cohortList">
                    <?php
                  // List all cohorts that have a non-empty idnumber (newest first)
                  global $DB;
                  $sql = "SELECT id, idnumber
                            FROM {cohort}
                           WHERE idnumber IS NOT NULL AND idnumber <> ''
                        ORDER BY timemodified DESC, id DESC";
                  $rows = $DB->get_records_sql($sql);
                  
                  if ($rows) {
                      foreach ($rows as $r) {
                          $idn = trim((string)$r->idnumber);
                          if ($idn === '') { continue; }
                          // data-cohort-id and data-idnumber for JS selection
                          echo '<li data-cohort-id="' . (int)$r->id . '" data-idnumber="' . s($idn) . '">' . format_string($idn) . '</li>';
                      }
                  } else {
                      echo '<li style="pointer-events:none;opacity:.6;">No cohorts found</li>';
                  }
                  ?>
                </ul>
            </div>
        </div>
        <div class="calendar_admin_details_create_cohort_input_wrapper">
            <label for="cohortShortNameInput">Cohort's Short Name</label>
            <input type="text" id="cohortShortNameInput"
                class="calendar_admin_details_create_cohort_input cohortShortNameInput"
                placeholder="Enter short name (e.g., TX1, FL6)" value="">
        </div>
    </div>
    <!-- Event navigation -->
    <div class="calendar_admin_details_create_cohort_event_nav">
        <div class="calendar_event_group">
            <button type="button" class="calendar_event_nav_btn prev" aria-label="Previous">
                <svg viewBox="0 0 24 24">
                    <polyline points="15 19 8 12 15 5" stroke="currentColor" stroke-width="2.2" fill="none"
                        stroke-linecap="round" stroke-linejoin="round" />
                </svg>
            </button>
            <span class="calendar_event_nav_title">Events</span>
            <button type="button" class="calendar_event_nav_btn next" aria-label="Next">
                <svg viewBox="0 0 24 24">
                    <polyline points="9 5 16 12 9 19" stroke="currentColor" stroke-width="2.2" fill="none"
                        stroke-linecap="round" stroke-linejoin="round" />
                </svg>
            </button>
        </div>
        <!-- this keeps the red + visible on the far right -->
        <button type="button" class="calendar_admin_details_create_cohort_add">+</button>
        <!-- NEW: delete button -->
        <button type="button" class="calendar_admin_details_create_cohort_remove" aria-label="Remove last teacher">
            <!-- trash icon -->
            <svg viewBox="0 0 24 24" width="20" height="20" fill="currentColor" aria-hidden="true">
                <path
                    d="M9 3h6a1 1 0 0 1 1 1v1h4v2h-1v12a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V7H4V5h4V4a1 1 0 0 1 1-1Zm1 2v0h4V4h-4v1Zm-2 2v12h8V7H8Zm2 2h2v8h-2V9Zm4 0h2v8h-2V9Z" />
            </svg>
        </button>
    </div>
    <!-- 2-up teacher carousel -->
    <div class="calendar_admin_details_create_cohort_row teacherBlocks" id="teacherBlocks">
        <!-- Teacher 1 -->
        <div class="teacher-block" data-teacher="1">
            <div>
                <div class="calendar_admin_details_create_cohort_teacher_dropdown_wrapper">
                    <label>Teacher 1</label>
                    <div class="calendar_admin_details_create_cohort_teacher_btn teacher1DropdownBtn"
                        id="teacher1DropdownBtn">
                        <span class="label">Select Teacher</span>
                        <img src="./img/dropdown-arrow-down.svg" alt="dropdown">
                    </div>
                    <!-- store the selected teacher id for this block -->
                    <input type="hidden" name="teacher1_userid" id="teacher1UserId" value="" class="teacher1UserId">
                    <div class="calendar_admin_details_create_cohort_teacher_list teacher1DropdownList"
                        id="teacher1DropdownList">
                        <ul>
                            <?php echo $teachers_li_html; ?>
                        </ul>
                    </div>
                </div>
                <div class="calendar_admin_details_create_cohort_class_dropdown_wrapper">
                    <label>Class Name</label>
                    <div class="calendar_admin_details_create_cohort_class_btn className1DropdownBtn"
                        id="className1DropdownBtn">
                        Select Class
                        <img src="./img/dropdown-arrow-down.svg" alt="dropdown">
                    </div>
                    <div class="calendar_admin_details_create_cohort_class_list className1DropdownList"
                        id="className1DropdownList">
                        <ul>
                            <li data-classname="main">Main Class</li>
                            <li data-classname="tutor">Tutoring Class</li>
                            <li data-classname="conversation">Conversational Class</li>
                        </ul>
                    </div>
                </div>
                <div class="cohort_schedule_box">
                    <div class="cohort_schedule_header">
                        <span class="cohort_schedule_icon">&#9432;</span>
                        <span>Class Schedule</span>
                    </div>
                    <button type="button" class="cohort_schedule_btn">
                        Does not repeat
                        <span class="cohort_schedule_arrow"> <img src="./img/dropdown-arrow-down.svg" alt=""></span>
                    </button>
                </div>

                <div class="calendar_admin_details_cohort_tab_timezone_wrapper_right">
                    <label class="calendar_admin_details_cohort_tab_timezone_label_right">Event time zone</label>
                    <div class="calendar_admin_details_cohort_tab_timezone_dropdown_right">
                        <span>(GMT+05:00) Pakistan</span>

                        <img class="calendar_admin_details_cohort_tab_timezone_arrow_right"
                            src="./img/dropdown-arrow-down.svg" alt="dropdown">

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
                <div class="calendar_admin_details_create_cohort_selectDate_left">
                    <label style="margin-top:20px;">Start On</label>
                    <button class="conference_modal_date_btn conference_modal_start_date_btn">Select Date</button>
                </div>
                <div class="create_new_cohort_tab_select_color_left_row">
                    <label class="create_new_cohort_tab_select_color_left_label">Find a time</label>
                    <div class="create_new_cohort_tab_select_color_left_dropdown createNewCohortSelectColorLeft"
                        id="createNewCohortSelectColorLeft">
                        <span class="create_new_cohort_tab_select_color_left_selected createNewCohortSelectedColorLeft"
                            id="createNewCohortSelectedColorLeft">
                            <span class="create_new_cohort_tab_select_color_left_circle"
                                style="background:#1649c7"></span>
                        </span>
                        <img class="create_new_cohort_tab_select_color_left_arrow" src="./img/dropdown-arrow-down.svg"
                            alt="dropdown">

                        <div class="create_new_cohort_tab_select_color_left_list createNewCohortColorListLeft"
                            id="createNewCohortColorListLeft">
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
        </div>
        <!-- Teacher 2 -->
        <div class="teacher-block" data-teacher="2">
            <div>
                <div class="calendar_admin_details_create_cohort_teacher_dropdown_wrapper teacher2Wrapper"
                    id="teacher2Wrapper">
                    <label>Teacher 2</label>
                    <div class="calendar_admin_details_create_cohort_teacher_btn teacher2DropdownBtn"
                        id="teacher2DropdownBtn">
                        <span class="label">Select Teacher</span>
                        <img src="./img/dropdown-arrow-down.svg" alt="dropdown">
                    </div>
                    <!-- store the selected Teacher 2 user id -->
                    <input type="hidden" name="teacher2_userid" id="teacher2UserId" class="teacher2UserId" value="">
                    <div class="calendar_admin_details_create_cohort_teacher_list teacher2DropdownList"
                        id="teacher2DropdownList">
                        <ul>
                            <?php echo $teachers_li_html; ?>
                        </ul>
                    </div>
                </div>
                <div class="calendar_admin_details_create_cohort_class_dropdown_wrapper">
                    <label>Class Name</label>
                    <div class="calendar_admin_details_create_cohort_class_btn className2DropdownBtn"
                        id="className2DropdownBtn">
                        Select Class
                        <img src="./img/dropdown-arrow-down.svg" alt="dropdown">
                    </div>
                    <div class="calendar_admin_details_create_cohort_class_list className2DropdownList"
                        id="className2DropdownList">
                        <ul>
                            <li data-classname="main">Main Class</li>
                            <li data-classname="tutor">Tutoring Class</li>
                            <li data-classname="conversation">Conversational Class</li>
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
                        <span class="cohort_schedule_arrow"> <img src="./img/dropdown-arrow-down.svg" alt=""></span>
                    </button>
                </div>

                <div class="calendar_admin_details_cohort_tab_timezone_wrapper_right">
                    <label class="calendar_admin_details_cohort_tab_timezone_label_right">Event time zone
                        (Right)</label>
                    <div class="calendar_admin_details_cohort_tab_timezone_dropdown_right">
                        <span>(GMT+05:00) Pakistan</span>
                        <img class="calendar_admin_details_cohort_tab_timezone_arrow_right"
                            src="./img/dropdown-arrow-down.svg" alt="dropdown">

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
                <div class="calendar_admin_details_create_cohort_selectDate_right">
                    <label style="margin-top:20px;">End On</label>
                    <button class="conference_modal_date_btn conference_modal_end_date_btn">Select Date</button>
                </div>
                <div class="create_new_cohort_tab_select_color_right_row">
                    <label class="create_new_cohort_tab_select_color_right_label">Find a time</label>
                    <div class="create_new_cohort_tab_select_color_right_dropdown createNewCohortSelectColorRight"
                        id="createNewCohortSelectColorRight">
                        <span
                            class="create_new_cohort_tab_select_color_right_selected createNewCohortSelectedColorRight"
                            id="createNewCohortSelectedColorRight">
                            <span class="create_new_cohort_tab_select_color_right_circle"
                                style="background:#1649c7"></span>
                        </span>
                        <img class="create_new_cohort_tab_select_color_right_arrow" src="./img/dropdown-arrow-down.svg"
                            alt="dropdown">

                        <div class="create_new_cohort_tab_select_color_right_list createNewCohortColorListRight"
                            id="createNewCohortColorListRight">
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
        </div>
    </div>
    <div class="calendar_admin_details_create_cohort_bottom">
        <div class="calendar_admin_details_create_cohort_switch">
            <div class="calendar_admin_details_create_cohort_toggle toggleActiveManage" id="toggleActiveManage"></div>
            Active
        </div>
        <div class="calendar_admin_details_create_cohort_switch">
            <div class="calendar_admin_details_create_cohort_toggle toggleAvailableManage" id="toggleAvailableManage">
            </div>
            Available
        </div>
    </div>
    <button class="calendar_admin_details_create_cohort_btn">Update Cohort</button>
</div>

<link rel="stylesheet" href="<?php echo $CFG->wwwroot; ?>/local/customplugin/css/calendar_admin_details_create_cohort_manage_cohort.css">

<!-- Time Picker Modal -->
<div class="calendar_admin_details_create_cohort_time_modal_backdrop timeModalBackdrop" id="timeModalBackdrop">
    <div class="calendar_admin_details_create_cohort_time_modal timeModal" id="timeModal">
        <ul>
            <!-- Time options rendered via JS -->
        </ul>
    </div>
</div>

<!-- Calendar Date Picker Modal -->
<div class="calendar_admin_details_create_cohort_calendar_modal_backdrop calendarDateModalBackdrop"
    id="calendarDateModalBackdrop" style="display:none;">
    <div class="calendar_admin_details_create_cohort_calendar_modal calendarDateModal" id="calendarDateModal">
        <div class="calendar_admin_details_create_cohort_calendar_nav">
            <button class="calendar_prev_month"><svg width="22" height="22" viewBox="0 0 24 24">
                    <polyline points="15 19 8 12 15 5" fill="none" stroke="#111" stroke-width="2" stroke-linecap="round"
                        stroke-linejoin="round"></polyline>
                </svg></button>
            <span class="calendarDateMonth" id="calendarDateMonth"></span>
            <button class="calendar_next_month"><svg width="22" height="22" viewBox="0 0 24 24">
                    <polyline points="9 19 16 12 9 5" fill="none" stroke="#111" stroke-width="2" stroke-linecap="round"
                        stroke-linejoin="round"></polyline>
                </svg></button>
        </div>
        <div class="calendar_admin_details_create_cohort_calendar_days"></div>
        <button class="calendar_admin_details_create_cohort_calendar_done_btn">Done</button>
    </div>
</div>

<script>
// ===== SCOPE ALL QUERIES TO THE PARENT CONTAINER =====
const $scope = $('#manage_cohort_tab_content');

// Function to disable all form fields
function disableAllFields() {
    // Disable all input fields
    $scope.find('.cohortShortNameInput').prop('disabled', true).addClass('disabled');

    // Disable all dropdowns by adding a disabled class and pointer-events
    $scope.find(
        '.calendar_admin_details_create_cohort_teacher_btn, .calendar_admin_details_create_cohort_class_btn, .cohort_schedule_btn, .conference_modal_date_btn'
    ).addClass('disabled').css('pointer-events', 'none');

    // Disable toggles
    $scope.find('.toggleActiveManage, .toggleAvailableManage').addClass('disabled').css('pointer-events', 'none');

    // Disable color pickers
    $scope.find('.createNewCohortSelectColorLeft, .createNewCohortSelectColorRight').addClass('disabled')
        .css('pointer-events', 'none');

    // Disable timezone dropdowns
    $scope.find('.calendar_admin_details_cohort_tab_timezone_dropdown_right').addClass('disabled').css(
        'pointer-events', 'none');

    // Disable navigation buttons
    $scope.find(
        '.calendar_event_nav_btn, .calendar_admin_details_create_cohort_add, .calendar_admin_details_create_cohort_remove'
    ).prop('disabled', true).css('pointer-events', 'none');

    // Disable update button
    $scope.find('.calendar_admin_details_create_cohort_btn').prop('disabled', true).addClass('disabled');
}

// Function to enable all form fields
function enableAllFields() {
    // Enable all input fields
    $scope.find('.cohortShortNameInput').prop('disabled', false).removeClass('disabled');

    // Enable all dropdowns
    $scope.find(
        '.calendar_admin_details_create_cohort_teacher_btn, .calendar_admin_details_create_cohort_class_btn, .cohort_schedule_btn, .conference_modal_date_btn'
    ).removeClass('disabled').css('pointer-events', 'auto');

    // Enable toggles
    $scope.find('.toggleActiveManage, .toggleAvailableManage').removeClass('disabled').css('pointer-events', 'auto');

    // Enable color pickers
    $scope.find('.createNewCohortSelectColorLeft, .createNewCohortSelectColorRight').removeClass('disabled')
        .css('pointer-events', 'auto');

    // Enable timezone dropdowns
    $scope.find('.calendar_admin_details_cohort_tab_timezone_dropdown_right').removeClass('disabled').css(
        'pointer-events', 'auto');

    // Enable navigation buttons
    $scope.find(
        '.calendar_event_nav_btn, .calendar_admin_details_create_cohort_add, .calendar_admin_details_create_cohort_remove'
    ).prop('disabled', false).css('pointer-events', 'auto');

    // Enable update button
    $scope.find('.calendar_admin_details_create_cohort_btn').prop('disabled', false).removeClass(
        'disabled');
}

// Initially disable all fields
disableAllFields();

// Enable fields when cohort is selected
$scope.on('click', '.cohortDropdownList li, .cohortList li', function() {
    const idnumber = $(this).data('idnumber');
    if (idnumber) {
        enableAllFields();
    }
});

// If cohort dropdown is changed back to default, disable fields again
$('.cohortDropdownBtn').on('click', function() {
    const currentText = $(this).text().trim();
    if (currentText === 'Select Existing Cohort') {
        disableAllFields();
    }
});

// =========================
// Reset manage cohort form
// =========================

// showToast() is now in js/toast_utils.js
// Using: showToast() from toast_utils.js
// For backward compatibility, alias showToastManage to showToast
function showToastManage(message, duration = 5000) {
    return window.showToast(message, 'success', duration, 'toastNotificationForManageCohort');
}
$('.cohortDropdownBtn').click(function(e) {
    e.stopPropagation();
    $('.cohortDropdownList').toggle();
});

function resetManageCohortFields() {
    const $scope = $('#manage_cohort_tab_content');

    // 1. Reset cohort dropdown to default
    $scope.find('.cohortDropdownBtn').html(
        'Select Existing Cohort <img src="./img/dropdown-arrow-down.svg" alt=""/>'
    ).removeAttr('data-idnumber').removeAttr('data-label');

    // 2. Clear short name input
    $scope.find('.cohortShortNameInput').val('');

    // 3. Reset teacher selections
    const resetTeacherBtn = (btnSel, hiddenSel) => {
        $scope.find(btnSel).html(
            '<span class="label">Select Teacher</span><img src="./img/dropdown-arrow-down.svg" alt=""/>'
        );
        $scope.find(hiddenSel).val('');
    };

    resetTeacherBtn('#teacher1DropdownBtn, .teacher1DropdownBtn', '#teacher1UserId, .teacher1UserId');
    resetTeacherBtn('#teacher2DropdownBtn, .teacher2DropdownBtn', '#teacher2UserId, .teacher2UserId');

    // 4. Reset class name dropdowns
    $scope.find('#className1DropdownBtn, .className1DropdownBtn').html(
        'Select Class <img src="./img/dropdown-arrow-down.svg" alt=""/>'
    );
    $scope.find('#className2DropdownBtn, .className2DropdownBtn').html(
        'Select Class <img src="./img/dropdown-arrow-down.svg" alt=""/>'
    );

    // 5. Reset schedule buttons
    $scope.find('.teacher-block[data-teacher="1"] .cohort_schedule_btn').html(
        'Does not repeat <span class="cohort_schedule_arrow"> <img src="./img/dropdown-arrow-down.svg" alt=""></span>'
    );
    $scope.find('.teacher-block[data-teacher="2"] .cohort_schedule_btn').html(
        'Does not repeat <span class="cohort_schedule_arrow"> <img src="./img/dropdown-arrow-down.svg" alt=""></span>'
    );

    // 6. Reset timezone dropdowns
    $scope.find('.calendar_admin_details_cohort_tab_timezone_dropdown_right span').first().text(
        '(GMT+05:00) Pakistan');

    // 7. Reset date buttons
    $scope.find('.conference_modal_start_date_btn').text('Select Date');
    $scope.find('.conference_modal_end_date_btn').text('Select Date');

    // 8. Reset color pickers to default blue
    $scope.find('.createNewCohortSelectedColorLeft .create_new_cohort_tab_select_color_left_circle')
        .css('background', '#1649c7')
        .attr('data-color', '#1649c7');
    $scope.find('.createNewCohortSelectedColorRight .create_new_cohort_tab_select_color_right_circle')
        .css('background', '#1649c7')
        .attr('data-color', '#1649c7');

    // Mark default color as selected
    $scope.find('.createNewCohortColorListLeft li, .createNewCohortColorListRight li')
        .removeClass('selected')
        .filter('[data-color="#1649c7"]')
        .addClass('selected');

    // 9. Reset toggle buttons
    $scope.find('.toggleActiveManage, .toggleAvailableManage').removeClass('active');

    // 10. Clear state maps
    if (window.stateByTeacher) {
        window.stateByTeacher.clear();
    }

    // 11. Disable all fields again (since no cohort is selected)
    disableAllFields();

    console.log('✅ Manage cohort form reset');
}

const S = (sel) => $scope.find(sel); // scoped query
const on = (evt, sel, handler) => $scope.on(evt, sel, handler); // scoped delegation

// ===== IMPROVED COHORT SELECTION AND PREFILL LOGIC =====
on('click', '.cohortDropdownList li, .cohortList li', async function() {
    const $li = $(this);
    const idnumber = $li.data('idnumber');
    if (!idnumber) return;

    // Update cohort dropdown text
    S('.cohortDropdownBtn').html(
        $li.text().trim() + ' <img src="./img/dropdown-arrow-down.svg" alt=""/>'
    );

    // ✅ Store the real idnumber + label for manage validation
    S('.cohortDropdownBtn')
        .attr('data-idnumber', idnumber)
        .attr('data-label', $li.text().trim());

    S('.cohortDropdownList').hide();

    const base = (window.M && M.cfg && M.cfg.wwwroot) || '';
    const url = base + '/local/customplugin/ajax/get_cohort_details.php';
    const sesskey = (window.M && M.cfg && M.cfg.sesskey) || '';

    try {
        console.log('=== MAKING AJAX REQUEST ===');
        const res = await fetch(url, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded'
            },
            body: 'idnumber=' +
                encodeURIComponent(idnumber) +
                '&sesskey=' +
                encodeURIComponent(sesskey),
        });

        const text = await res.text();
        console.log('=== RAW RESPONSE ===');
        console.log('Response text:', text);

        let data;
        try {
            data = JSON.parse(text);
        } catch (e) {
            console.error('JSON parse error:', e);
            showToastManage('Error parsing server response: ' + e.message, 5000);
            return;
        }

        console.log('=== PARSED DATA ===');
        console.log('Full response:', data);

        if (!data || !data.ok) {
            showToastManage('Error: ' + (data.error || 'Unknown error'), 5000);
            return;
        }

        const c = data.cohort;
        console.log('=== COHORT DATA ===');
        console.log('Full cohort object:', c);

        // Prefill all form fields
        await prefillCohortForm(c);

        console.log('=== FORM POPULATION COMPLETE ===');
    } catch (err) {
        console.error('=== FETCH ERROR ===', err);
        showToastManage('Error fetching cohort data: ' + err.message, 5000);
    }
});

// ===== MAIN PREFILL FUNCTION =====
async function prefillCohortForm(cohortData) {
    const c = cohortData;

    // 1. Short Name
    if (c.shortname) {
        console.log('Setting shortname:', c.shortname);
        S('.cohortShortNameInput').val(c.shortname);
    }

    // 2. Toggle states
    console.log('Setting toggles - enabled:', c.enabled, 'visible:', c.visible);
    S('.toggleActiveManage').toggleClass('active', c.enabled === 1);
    S('.toggleAvailableManage').toggleClass('active', c.visible === 1);

    // 3. Color - Set both left and right color pickers
    if (c.color) {
        const color = normalizeColor(c.color);
        console.log('Setting color (normalized):', color);
        if (color) {
            // Left picker
            S('.createNewCohortSelectedColorLeft .create_new_cohort_tab_select_color_left_circle')
                .css('background', color)
                .attr('data-color', color);

            // Right picker
            S('.createNewCohortSelectedColorRight .create_new_cohort_tab_select_color_right_circle')
                .css('background', color)
                .attr('data-color', color);

            // Mark matching chips
            S('.createNewCohortColorListLeft li, .createNewCohortColorListRight li')
                .removeClass('selected')
                .filter(`[data-color="${color}"], [data-color="${String(color).toLowerCase()}"]`)
                .addClass('selected');
        }
    }

    // 4. Date formatting helper
    const fmtDate = (d) => {
        if (!d) return 'Select Date';
        const date = new Date(d * 1000);
        return date.toLocaleDateString('en-GB', {
            day: '2-digit',
            month: 'short',
            year: 'numeric'
        });
    };

    // 5. Weekly label helper
    const weeklyLabel = (days, startLabel, endLabel, timesByDay = null) => {
        if (!days || !days.length) return 'Does not repeat';

        // If specific times per day are provided, prefer them.
        if (timesByDay && typeof timesByDay === 'object') {
            const parts = days.map(d => {
                const t = timesByDay[d] || {};
                const s = (t.startLabel || t.start || startLabel || '').trim();
                const e = (t.endLabel || t.end || endLabel || '').trim();
                return (s && e) ? `${d} (${s} - ${e})` : d;
            });
            return `Weekly on ${parts.join(', ')}`;
        }

        // Otherwise, use the same start/end for all days (if present)
        if (startLabel && endLabel) {
            return `Weekly on ${days
        .map(d => `${d} <span class="time-range">(${startLabel} - ${endLabel})</span>`)
        .join(', ')}`;
        }

        // Fallback: just days
        return 'Weekly on ' + days.join(', ');
    };

    // === Teacher 1 (Main Class) ===
    if (c.main) {
        console.log('=== POPULATING TEACHER 1 ===');
        await populateTeacherBlock(1, c.main, fmtDate, weeklyLabel, c.startdate);
    }

    // === Teacher 2 (Tutor Class) ===
    if (c.tutor) {
        console.log('=== POPULATING TEACHER 2 ===');
        await populateTeacherBlock(2, c.tutor, fmtDate, weeklyLabel, c.enddate); // Pass enddate here
    }
}

// ===== POPULATE INDIVIDUAL TEACHER BLOCK =====
async function populateTeacherBlock(teacherNum, teacherData, fmtDate, weeklyLabel, startdate) {
    console.log(`Populating Teacher ${teacherNum}:`, teacherData);

    const isTeacher1 = teacherNum === 1;
    const timeInputSelector = isTeacher1 ?
        `.teacher-block[data-teacher="${teacherNum}"] .time-input` :
        `.teacher-block[data-teacher="${teacherNum}"] .calendar_admin_details_time_right_time-input`;

    // 1. Schedule
    if (teacherData.days) {
        const scheduleText = weeklyLabel(
            teacherData.days,
            teacherData.start, // one common start time like "9:00 AM"
            teacherData.end, // one common end time   like "10:00 AM"
            teacherData.perDayTimes // optional map: { Mon:{startLabel,endLabel}, ... }
        );
        S(`.teacher-block[data-teacher="${teacherNum}"] .cohort_schedule_btn`).html(
            scheduleText +
            ' <span class="cohort_schedule_arrow"> <img src="./img/dropdown-arrow-down.svg" alt=""></span>'
        );
    }
    // 2. Times
    const $timeInputs = S(timeInputSelector);
    console.log(`Teacher ${teacherNum} time inputs found:`, $timeInputs.length);
    if (teacherData.start) {
        console.log(`Setting start time: ${teacherData.start}`);
        $timeInputs.eq(0).val(teacherData.start);
    }
    if (teacherData.end) {
        console.log(`Setting end time: ${teacherData.end}`);
        $timeInputs.eq(1).val(teacherData.end);
    }

    // 3. Teacher Selection
    if (teacherData.teacher && teacherData.teacher.id) {
        console.log(`Selecting teacher with ID: ${teacherData.teacher.id}`);
        await selectTeacherFromDropdown(isTeacher1 ? 'teacher1' : 'teacher2', teacherData.teacher);
    }

    // 4. Class Name
    const className = teacherData.classname || (isTeacher1 ? 'Main Class' : 'Tutoring Class');
    console.log(`Setting class name: ${className}`);
    S(`#${isTeacher1 ? 'className1' : 'className2'}DropdownBtn`).html(
        className + ' <img src="./img/dropdown-arrow-down.svg" alt=""/>'
    );

    // 5. Start Date
    if (startdate) {
        const dateText = fmtDate(startdate);
        console.log(`Setting start date: ${dateText}`);
        const dateSelector = isTeacher1 ?
            `.teacher-block[data-teacher="${teacherNum}"] .conference_modal_start_date_btn` :
            `.teacher-block[data-teacher="${teacherNum}"] .conference_modal_end_date_btn`;
        S(dateSelector).text(dateText);
    }
}

function setTeacherSelection(btnSel, userIdSel, {
    id,
    name,
    pic
}) {
    ensureTeacherBtn(btnSel);

    const $btn = S(btnSel);
    S(userIdSel).val(id);
    $btn.attr('data-userid', id);

    // ✅ only update the label inside .teacher-info
    const $label = $btn.find('.teacher-info .label');
    if ($label.length) {
        $label.text(name || 'Unknown');
    }

    // Avatar
    const $img = $btn.find('img.calendar_admin_details_create_cohort_teacher_avatar');
    if ($img.length) {
        if (pic) {
            $img.attr('src', pic).attr('alt', name || '').show();
            $img.off('error.__avatar').on('error.__avatar', function() {
                console.warn('Avatar failed to load:', $(this).attr('src'));
                $(this).hide();
            });
        } else {
            $img.removeAttr('src').hide();
        }
    }
}


function ensureTeacherBtn(btnSel, defaultText = 'Select Teacher') {
    const $btn = S(btnSel);
    if (!$btn.length) return;

    // Detach chevron or arrow temporarily
    const $svg = $btn.children('svg').detach();
    const $arrow = $btn.children('img[src*="dropdown"]').detach(); // catch arrow icon too

    // 🧹 Remove any old label outside .teacher-info
    $btn.children('.label').not('.teacher-info .label').remove();

    // Ensure container for image + name
    let $infoDiv = $btn.find('.teacher-info');
    if (!$infoDiv.length) {
        $infoDiv = $('<div class="teacher-info"></div>');
        $btn.prepend($infoDiv);
    }

    // Ensure avatar
    let $img = $infoDiv.find('img.calendar_admin_details_create_cohort_teacher_avatar');
    if (!$img.length) {
        $img = $('<img class="calendar_admin_details_create_cohort_teacher_avatar" alt="">');
        $infoDiv.prepend($img);
    }

    // Ensure label
    let $label = $infoDiv.find('.label');
    if (!$label.length) {
        $label = $(`<span class="label">${defaultText}</span>`);
        $infoDiv.append($label);
    }

    // Put chevron/arrow back
    if ($svg.length) $btn.append($svg);
    if ($arrow && $arrow.length) $btn.append($arrow);

    // Layout
    $btn.css({
        display: 'flex',
        alignItems: 'center',
        justifyContent: 'space-between',
        gap: '8px'
    });

    $infoDiv.css({
        display: 'flex',
        alignItems: 'center',
        gap: '8px'
    });

    $img.css({
        width: '28px',
        height: '28px',
        borderRadius: '50%',
        objectFit: 'cover'
    });
}



// ===== SELECT TEACHER FROM DROPDOWN (scoped + robust for #id or .class) =====
function selectTeacherFromDropdown(teacherNumber, teacherData) {
    return new Promise((resolve) => {
        const listSel = `#${teacherNumber}DropdownList, .${teacherNumber}DropdownList`;
        const btnSel = `#${teacherNumber}DropdownBtn, .${teacherNumber}DropdownBtn`;
        const userIdSel = `#${teacherNumber}UserId, .${teacherNumber}UserId`;

        ensureTeacherBtn(btnSel);

        const $opt = S(`${listSel} li[data-userid="${teacherData.id}"]`).first();
        const displayName =
            teacherData.name ||
            $opt.data('name') ||
            $opt.text().trim();

        const imgSrc = teacherData.avatar || $opt.data('pic') || $opt.find('img').attr('src') || '';

        S(btnSel).attr('data-userid', teacherData.id)
            .find('.teacher-info .label') // ✅ only inside teacher-info
            .text(displayName);

        S(userIdSel).val(teacherData.id);
        const $img = S(btnSel).find('img.calendar_admin_details_create_cohort_teacher_avatar');
        if ($img.length) {
            if (imgSrc) {
                // Try all ways of setting src to avoid edge cases
                $img.attr('src', imgSrc);
                $img.prop('src', imgSrc);
                const el = $img.get(0);
                if (el) el.src = imgSrc;
                $img.attr('alt', displayName || '').show();
            } else {
                $img.removeAttr('src').hide();
            }
        }

        // mark selected and close the list
        S(`${listSel} li`).removeClass('selected');
        if ($opt.length) $opt.addClass('selected');
        S(listSel).hide();

        resolve();
    });
}

// ===== GATHER INDIVIDUAL TEACHER DATA (scoped) =====
function gatherTeacherData(teacherNum) {
    const isTeacher1 = teacherNum === 1;
    const teacherPrefix = isTeacher1 ? 'teacher1' : 'teacher2';
    const classPrefix = isTeacher1 ? 'className1' : 'className2';
    const timeInputSelector = isTeacher1 ?
        `.teacher-block[data-teacher="${teacherNum}"] .time-input` :
        `.teacher-block[data-teacher="${teacherNum}"] .calendar_admin_details_time_right_time-input`;

    return {
        id: S(`#${teacherPrefix}UserId, .${teacherPrefix}UserId`).val(),
        name: S(`#${teacherPrefix}DropdownBtn, .${teacherPrefix}DropdownBtn`).find('span').first().text().trim(),
        className: S(`#${classPrefix}DropdownBtn`).contents().first()[0].textContent.trim(),
        schedule: S(`.teacher-block[data-teacher="${teacherNum}"] .cohort_schedule_btn`).contents().first()[0]
            .textContent.trim(),
        startTime: S(timeInputSelector).eq(0).val(),
        endTime: S(timeInputSelector).eq(1).val(),
        startDate: S(`.teacher-block[data-teacher="${teacherNum}"] .conference_modal_date_btn`).text().trim(),
    };
}

// ===== UPDATE COHORT BUTTON HANDLER (single, scoped) =====
on('click', '.teacher1DropdownList li', function() {
    setTeacherSelection('#teacher1DropdownBtn', '#teacher1UserId', {
        id: $(this).data('userid'),
        name: $(this).data('name') || $(this).text().trim(),
        pic: $(this).data('pic') || $(this).find('img').attr('src') || ''
    });
    S('#teacher1DropdownList').hide();
});

on('click', '.teacher2DropdownList li', function() {
    setTeacherSelection('#teacher2DropdownBtn', '#teacher2UserId', {
        id: $(this).data('userid'),
        name: $(this).data('name') || $(this).text().trim(),
        pic: $(this).data('pic') || $(this).find('img').attr('src') || ''
    });
    S('#teacher2DropdownList').hide();
});

// ===== CLASS NAME DROPDOWN HANDLERS (scoped) =====
on('click', '.className1DropdownList li', function() {
    const className = $(this).text().trim();
    S('.className1DropdownBtn, #className1DropdownBtn').html(
        className + ' <img src="./img/dropdown-arrow-down.svg" alt=""/>'
    );
    S('.className1DropdownList, #className1DropdownList').hide();
});

on('click', '.className2DropdownList li', function() {
    const className = $(this).text().trim();
    S('.className2DropdownBtn, #className2DropdownBtn').html(
        className + ' <img src="./img/dropdown-arrow-down.svg" alt=""/>'
    );
    S('.className2DropdownList, #className2DropdownList').hide();
});

// ===== UTIL =====
function normalizeColor(input) {
    if (!input) return null;
    let c = String(input).trim();

    if (/^(rgb|hsl)a?\(/i.test(c)) return c; // already rgb/rgba/hsl/hsla
    if (/^[0-9a-f]{3,8}$/i.test(c)) return '#' + c; // bare hex -> #hex
    if (/^#[0-9a-f]{3,8}$/i.test(c)) return c; // valid #hex
    return c; // fallback (named, etc.)
}

// ===== GATHER WHOLE COHORT FORM (scoped) =====
function gatherCohortFormData() {
    return {
        cohortId: S('.cohortDropdownBtn').attr('data-idnumber') || '', // <- FIXED
        shortName: S('.cohortShortNameInput').val(),
        enabled: S('.toggleActiveManage').hasClass('active') ? 1 : 0,
        visible: S('.toggleAvailableManage').hasClass('active') ? 1 : 0,
        color: S('.createNewCohortSelectedColorLeft .create_new_cohort_tab_select_color_left_circle')
            .css('background-color'),
        teacher1: gatherTeacherData(1),
        teacher2: gatherTeacherData(2),
    };
}

// Extract ["Sun (09:00 AM - 10:00 AM)", "Mon (...)", ...] → [{day,startTime,endTime}, ...]
const parseScheduleLabelToArray = (label) => {
    const arr = [];
    if (!label) return arr;
    // e.g. "Weekly on Sun (09:00 AM - 10:00 AM), Mon (09:00 AM - 10:00 AM ▼)"
    const parts = label.replace(/▼/g, '').split(/\s*,\s*/);
    for (const p of parts) {
        const m = p.match(
            /\b(Sun|Mon|Tue|Wed|Thu|Fri|Sat)\b.*?\((\d{1,2}:\d{2}\s*[AP]M)\s*-\s*(\d{1,2}:\d{2}\s*[AP]M)\)/i);
        if (m) {
            arr.push({
                day: m[1],
                startTime: m[2].toUpperCase(),
                endTime: m[3].toUpperCase()
            });
        }
    }
    return arr;
};

// "09:00 AM" → {hour:9, minute:0}
const time12to24 = (s) => {
    const m = s.trim().match(/^(\d{1,2}):(\d{2})\s*([AP]M)$/i);
    if (!m) return null;
    let h = parseInt(m[1], 10),
        min = parseInt(m[2], 10);
    const ampm = m[3].toUpperCase();
    if (ampm === 'PM' && h < 12) h += 12;
    if (ampm === 'AM' && h === 12) h = 0;
    return {
        hour: h,
        minute: min
    };
};

$(document).ready(function() {
    // Calendar Date Picker Logic
    // daysInMonth() is now in js/date_utils.js
    // Using: daysInMonth() from date_utils.js
    function daysInMonth(year, month) {
        if (window.daysInMonth) {
            return window.daysInMonth(year, month);
        }
        // Fallback
        return new Date(year, month + 1, 0).getDate();
    }

    let calendarDateTargetBtn = null;
    let selectedCalendarDate = null;
    let calendarModalMonth = null;

    $(document).on('click', '.conference_modal_date_btn', function(e) {
        e.preventDefault();
        calendarDateTargetBtn = $(this);
        let now = new Date();
        calendarModalMonth = {
            year: now.getFullYear(),
            month: now.getMonth()
        };
        selectedCalendarDate = null;
        renderCalendarModal();
        $('.calendarDateModalBackdrop').fadeIn();
    });

    $(document).on('click', '.calendar_prev_month', function() {
        calendarModalMonth.month--;
        if (calendarModalMonth.month < 0) {
            calendarModalMonth.month = 11;
            calendarModalMonth.year--;
        }
        renderCalendarModal();
    });

    $(document).on('click', '.calendar_next_month', function() {
        calendarModalMonth.month++;
        if (calendarModalMonth.month > 11) {
            calendarModalMonth.month = 0;
            calendarModalMonth.year++;
        }
        renderCalendarModal();
    });

    function renderCalendarModal() {
        const monthNames = ["January", "February", "March", "April", "May", "June", "July", "August",
            "September", "October", "November", "December"
        ];
        let y = calendarModalMonth.year,
            m = calendarModalMonth.month;
        $('.calendarDateMonth').text(`${monthNames[m]} ${y}`);
        let html = '';
        let dayHeaders = ['Mo', 'Tu', 'We', 'Th', 'Fr', 'Sa', 'Su'];
        for (let d = 0; d < 7; d++) html +=
            `<div class="calendar_admin_details_create_cohort_calendar_day_header">${dayHeaders[d]}</div>`;
        let firstDay = new Date(y, m, 1).getDay();
        firstDay = (firstDay + 6) % 7;
        let totalDays = daysInMonth(y, m);
        let prevMonthDays = firstDay;
        let day = 1;
        for (let i = 0; i < prevMonthDays; i++) html +=
            `<div class="calendar_admin_details_create_cohort_calendar_day_inactive"></div>`;
        for (let d = 1; d <= totalDays; d++) {
            let sel = selectedCalendarDate &&
                selectedCalendarDate.getFullYear() === y &&
                selectedCalendarDate.getMonth() === m &&
                selectedCalendarDate.getDate() === d ? ' selected' : '';
            html +=
                `<div class="calendar_admin_details_create_cohort_calendar_day${sel}" data-day="${d}">${d}</div>`;
            day++;
        }
        let rem = (prevMonthDays + totalDays) % 7;
        if (rem > 0)
            for (let i = rem; i < 7; i++) html +=
                `<div class="calendar_admin_details_create_cohort_calendar_day_inactive"></div>`;
        $('.calendar_admin_details_create_cohort_calendar_days').html(html);
    }

    $(document).on('click', '.calendar_admin_details_create_cohort_calendar_day', function() {
        $('.calendar_admin_details_create_cohort_calendar_day').removeClass('selected');
        $(this).addClass('selected');
        let day = parseInt($(this).attr('data-day'));
        selectedCalendarDate = new Date(calendarModalMonth.year, calendarModalMonth.month, day);
    });

    $('.calendar_admin_details_create_cohort_calendar_done_btn').click(function() {
        if (selectedCalendarDate && calendarDateTargetBtn) {
            let d = selectedCalendarDate;
            let nice = d.toLocaleDateString('en-GB', {
                day: '2-digit',
                month: 'short',
                year: 'numeric'
            });
            calendarDateTargetBtn.text(nice);
            $('.calendarDateModalBackdrop').fadeOut();
        }
    });

    $('.calendarDateModalBackdrop').click(function(e) {
        if (e.target === this) $(this).fadeOut();
    });

    // Toggles
    $('.toggleActiveManage, .toggleAvailableManage').click(function() {
        $(this).toggleClass('active');
    });
});

// ========= UPDATE COHORT FUNCTIONALITY =========
(function() {
    const PARENT_ID = 'manage_cohort_tab_content';
    const ROOT = document.getElementById(PARENT_ID);
    if (!ROOT) {
        console.warn('[manage] Parent not found:', PARENT_ID);
        return;
    }

    // ========= UTILITIES =========
    const $ = (sel, root = ROOT) => root.querySelector(sel);
    const $$ = (sel, root = ROOT) => Array.from(root.querySelectorAll(sel));
    const txt = (sel, root = ROOT) => (root.querySelector(sel)?.textContent ?? '').trim();
    const val = (sel, root = ROOT) => (root.querySelector(sel)?.value ?? '').trim();

    const DAY3 = ['Sun', 'Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat'];
    const to2 = (n) => (n < 10 ? '0' + n : '' + n);

    const parseTime12to24 = (s) => {
        if (!s) return null;
        const m = s.trim().match(/^(\d{1,2})(?::(\d{2}))?\s*([ap]m)$/i);
        if (!m) return null;
        let h = parseInt(m[1], 10);
        const min = parseInt(m[2] ?? '0', 10);
        const ampm = m[3].toLowerCase();
        if (ampm === 'pm' && h < 12) h += 12;
        if (ampm === 'am' && h === 12) h = 0;
        return {
            hour: h,
            minute: min,
            label: `${((h%12)||12)}:${to2(min)} ${ampm.toUpperCase()}`
        };
    };

    const mins = (t) => (t && Number.isFinite(t.hour) && Number.isFinite(t.minute)) ?
        (t.hour * 60 + t.minute) : null;

    const cleanLbl = (el) => (el?.textContent ?? '').replace(/▼/g, '').replace(/\s+/g, ' ').trim();

    const rgbToHex = (rgb) => {
        if (!rgb) return null;
        const m = rgb.match(/rgba?\((\d+),\s*(\d+),\s*(\d+)/i);
        if (!m) return null;
        const toHex = (n) => ('0' + (parseInt(n, 10) & 255).toString(16)).slice(-2).toUpperCase();
        return `#${toHex(m[1])}${toHex(m[2])}${toHex(m[3])}`;
    };

    const tzLabelToIana = (s) => {
        s = (s || '').toLowerCase();
        if (!s) return null;
        if (s.includes('international date line')) return 'Etc/GMT+12';
        if (s.includes('midway') || s.includes('samoa')) return 'Pacific/Pago_Pago';
        if (s.includes('hawaii')) return 'Pacific/Honolulu';
        if (s.includes('alaska')) return 'America/Anchorage';
        if (s.includes('pacific')) return 'America/Los_Angeles';
        if (s.includes('mountain')) return 'America/Denver';
        if (s.includes('central')) return 'America/Chicago';
        if (s.includes('eastern')) return 'America/New_York';
        if (s.includes('london')) return 'Europe/London';
        if (s.includes('berlin') || s.includes('paris')) return 'Europe/Berlin';
        if (s.includes('moscow')) return 'Europe/Moscow';
        if (s.includes('nairobi')) return 'Africa/Nairobi';
        if (s.includes('pakistan')) return 'Asia/Karachi';
        if (s.includes('india')) return 'Asia/Kolkata';
        if (s.includes('beijing') || s.includes('singapore')) return 'Asia/Singapore';
        if (s.includes('tokyo') || s.includes('seoul')) return 'Asia/Tokyo';
        if (s.includes('sydney')) return 'Australia/Sydney';
        return null;
    };

    const parseDateLabelToUnix = (label) => {
        if (!label || /select date/i.test(label)) return null;
        const d = new Date(label);
        if (isNaN(d.getTime())) return null;
        // Anchor at local noon so timezone conversions (e.g. to
        // America/New_York) do not push the date back a day.
        d.setHours(12, 0, 0, 0);
        return Math.floor(d.getTime() / 1000);
    };

    const highlight = (node) => {
        if (!node) return;
        node.classList.add('field-error');
        node.scrollIntoView?.({
            behavior: 'smooth',
            block: 'center'
        });
        setTimeout(() => node.classList.remove('field-error'), 1500);
    };

    const inferClassType = (className) => {
        const s = (className || '').toLowerCase();
        if (s.includes('main')) return 'main';
        if (s.includes('tutor')) return 'tutor';
        if (s.includes('convers')) return 'conversation';
        return 'class';
    };

    // ========= STATE MANAGEMENT =========
    const stateByTeacher = new Map();
    let currentTeacherIdx = null; // Track which teacher is editing

    const widgetSelected = (w) => w.classList.contains('selected') ||
        w.getAttribute('aria-pressed') === 'true';

    const getWidgetDay3 = (w) => {
        const key = parseInt(w.getAttribute('data-key') || '-1', 10);
        return (key >= 0 && key <= 6) ? DAY3[key] : null;
    };

    const getWidgetTimes = (w) => {
        const sHM = w.querySelector('.scroll-widget__hm.s')?.textContent?.trim() || '';
        const sP = w.querySelector('.scroll-widget__period.sp')?.textContent?.trim() || '';
        const eHM = w.querySelector('.scroll-widget__hm.e')?.textContent?.trim() || '';
        const eP = w.querySelector('.scroll-widget__period.ep')?.textContent?.trim() || '';

        const sLbl = sHM && sP ? `${sHM} ${sP}` : '';
        const eLbl = eHM && eP ? `${eHM} ${eP}` : '';
        return {
            startLabel: sLbl,
            endLabel: eLbl,
            start24: parseTime12to24(sLbl),
            end24: parseTime12to24(eLbl)
        };
    };

    const readModalState = () => {
        const modal = document.querySelector('.calendar_admin_details_create_cohort_customrec_modal');
        if (!modal) return null;

        const interval = parseInt(modal.querySelector('#customrec_interval')?.textContent || '1', 10) || 1;
        const period = modal.querySelector('#customrec_period_val')?.textContent?.trim() || 'Week';

        const days = [];
        const perDayTimes = {};
        modal.querySelectorAll('#weekly_scroll_widgets .scroll-widget').forEach(w => {
            if (!widgetSelected(w)) return;
            const d3 = getWidgetDay3(w);
            if (!d3) return;
            const tt = getWidgetTimes(w);
            days.push(d3);
            perDayTimes[d3] = tt;
        });

        const orderedDays = DAY3.filter(d => days.includes(d));
        return {
            interval,
            period,
            days: orderedDays,
            perDayTimes
        };
    };

    const applyStateToModal = (state) => {
        const modal = document.querySelector('.calendar_admin_details_create_cohort_customrec_modal');
        if (!modal || !state) return;

        const span = modal.querySelector('#customrec_interval');
        if (span) span.textContent = String(state.interval || 1);

        const pspan = modal.querySelector('#customrec_period_val');
        if (pspan && state.period) pspan.textContent = state.period;

        // Clear all selections first
        modal.querySelectorAll('#weekly_scroll_widgets .scroll-widget').forEach(w => {
            w.classList.remove('selected');
            w.setAttribute('aria-pressed', 'false');
        });

        // Apply state for this teacher
        (state.days || []).forEach(d3 => {
            const idx = DAY3.indexOf(d3);
            if (idx === -1) return;
            const w = modal.querySelector(`.scroll-widget[data-key="${idx}"]`);
            if (!w) return;
            w.classList.add('selected');
            w.setAttribute('aria-pressed', 'true');

            const info = state.perDayTimes?. [d3];
            if (info) {
                const sHM = w.querySelector('.scroll-widget__hm.s');
                const sP = w.querySelector('.scroll-widget__period.sp');
                const eHM = w.querySelector('.scroll-widget__hm.e');
                const eP = w.querySelector('.scroll-widget__period.ep');
                const sl = (info.startLabel || '').trim();
                const el = (info.endLabel || '').trim();
                const sMatch = sl.match(/^(\d{1,2}:\d{2})\s*([AP]M)$/i);
                const eMatch = el.match(/^(\d{1,2}:\d{2})\s*([AP]M)$/i);
                if (sMatch) {
                    if (sHM) sHM.textContent = sMatch[1];
                    if (sP) sP.textContent = sMatch[2].toUpperCase();
                }
                if (eMatch) {
                    if (eHM) eHM.textContent = eMatch[1];
                    if (eP) eP.textContent = eMatch[2].toUpperCase();
                }
                w.querySelector('.scroll-widget__time')?.classList?.add('has-time');
                w.querySelector('.scroll-widget__button')?.classList?.add('has-time');
            }
        });
    };

    // Handle modal open for BOTH teacher blocks
    ROOT.addEventListener('click', (e) => {
        const t1Btn = e.target.closest('.teacher-block[data-teacher="1"] .cohort_schedule_btn');
        const t2Btn = e.target.closest('.teacher-block[data-teacher="2"] .cohort_schedule_btn');
        if (!t1Btn && !t2Btn) return;

        currentTeacherIdx = t1Btn ? 1 : 2;
        console.log(`🔵 Opening modal for Teacher ${currentTeacherIdx}`);

        let st = stateByTeacher.get(currentTeacherIdx);
        if (!st) {
            st = {
                interval: 1,
                period: 'Week',
                days: [],
                perDayTimes: {}
            };
            stateByTeacher.set(currentTeacherIdx, st);
        }

        applyStateToModal(st);

        const modal = document.querySelector('.calendar_admin_details_create_cohort_customrec_modal');
        modal?.classList?.add('open');
        modal?.setAttribute('aria-hidden', 'false');
    }, true);

    // Handle modal close
    const closeModal = () => {
        const modal = document.querySelector('.calendar_admin_details_create_cohort_customrec_modal');
        modal?.classList?.remove('open');
        modal?.setAttribute('aria-hidden', 'true');
    };

    // Handle modal Done button
    const doneBtn = document.querySelector('#customrec_done');
    if (doneBtn && !doneBtn.hasAttribute('data-manage-bound')) {
        doneBtn.setAttribute('data-manage-bound', 'true');
        doneBtn.addEventListener('click', () => {
            if (currentTeacherIdx == null) return;

            const st = readModalState();

            const periodLower = (st.period || 'Week').toLowerCase();
            if (periodLower.includes('week') && st.days.length) {
                for (const d of st.days) {
                    const td = st.perDayTimes[d] || {};
                    if (!td.startLabel || !td.endLabel) {

                        showToastManage(`Please set start & end time for ${d}.`);

                        return;
                    }
                    const s = mins(td.start24),
                        e = mins(td.end24);
                    if (s != null && e != null && e <= s) {

                        showToastManage(`${d}: End time must be after start time.`);
                        return;
                    }
                }
            }

            stateByTeacher.set(currentTeacherIdx, st);
            console.log(`✅ Saved state for Teacher ${currentTeacherIdx}:`, st);

            const block = ROOT.querySelector(`.teacher-block[data-teacher="${currentTeacherIdx}"]`);
            const btn = block?.querySelector('.cohort_schedule_box .cohort_schedule_btn');
            if (btn) {
                const svg = btn.querySelector('.cohort_schedule_arrow')?.outerHTML ||
                    '<span class="cohort_schedule_arrow"> <img src="./img/dropdown-arrow-down.svg" alt=""></span>';
                btn.innerHTML = `${labelFromState(st)} ${svg}`;
            }

            closeModal();
        });
    }

    const labelFromState = ({
        interval,
        period,
        days,
        perDayTimes
    }) => {
        const p = (period || 'Week').toLowerCase();
        if (p.includes('day') && interval === 1) return 'Daily';
        if (p.includes('day')) return `Every ${interval} days`;
        if (p.includes('week')) {
            const base = interval === 1 ? 'Weekly' : `Every ${interval} weeks`;
            if (!days.length) return base;

            const dayTimePairs = days.map(d => {
                const times = perDayTimes?. [d];
                if (times?.startLabel && times?.endLabel) {
                    return `${d} (${times.startLabel} - ${times.endLabel})`;
                }
                return d;
            }).join(', ');

            return `${base} on ${dayTimePairs}`;
        }
        if (p.includes('month')) return `Every ${interval} month${interval>1?'s':''}`;
        if (p.includes('year')) return `Every ${interval} year${interval>1?'s':''}`;
        return 'Custom';
    };

    // ========= READ TEACHER DATA =========
    const readTeacher = (teacherIdx) => {
        const root = $(`.teacher-block[data-teacher="${teacherIdx}"]`) || ROOT;

        const idVal = teacherIdx === 1 ? val('#teacher1UserId') : val('#teacher2UserId');
        let fullName; {
            const sel = teacherIdx === 1 ? '#teacher1DropdownBtn .label' : '#teacher2DropdownBtn .label';
            const labelEl = document.querySelector(sel);
            fullName = (labelEl?.dataset?.fullname || '').trim();
            if (!fullName) {
                const listSel = teacherIdx === 1 ? '#teacher1DropdownList' : '#teacher2DropdownList';
                const li = document.querySelector(`${listSel} li.teacher-option[data-userid="${idVal}"]`);
                fullName = li?.dataset?.name?.trim() || '';
            }
        }
        const shortName = (fullName.split(/\s+/).slice(-1)[0] || '');

        const classBtn = teacherIdx === 1 ? $('#className1DropdownBtn') : $('#className2DropdownBtn');
        const className = cleanLbl(classBtn);
        const classType = inferClassType(className);

        const tzLabel = teacherIdx === 1 ?
            txt('#eventTimezoneSelected') :
            txt('#eventTimezoneSelectedRight');
        const tzIANA = tzLabelToIana(tzLabel);

        const colorSel = teacherIdx === 1 ?
            '#createNewCohortSelectedColorLeft .create_new_cohort_tab_select_color_left_circle' :
            '#createNewCohortSelectedColorRight .create_new_cohort_tab_select_color_right_circle';
        const colorHex = (() => {
            const node = document.querySelector(colorSel);
            const rgb = node ? getComputedStyle(node).backgroundColor : '';
            return rgbToHex(rgb);
        })();

        const dateLabel = root.querySelector('.conference_modal_date_btn')?.textContent.trim() || '';
        const startDateUnix = parseDateLabelToUnix(dateLabel);

        let st = stateByTeacher.get(teacherIdx);

        if (!st || (st.days && st.days.length === 0)) {
            const btn = root.querySelector('.cohort_schedule_btn');
            const label = btn?.textContent || '';
            console.log(`Parsing schedule from button: "${label}"`);

            // Enhanced parsing - look for weekly patterns
            if (label.includes('Weekly on')) {
                const days = [];
                const perDayTimes = {};

                // More robust regex to capture days and times
                const dayPattern = /(Mon|Tue|Wed|Thu|Fri|Sat|Sun)\s*\(([^)]+)\)/g;
                let match;

                while ((match = dayPattern.exec(label)) !== null) {
                    const day = match[1];
                    const timeRange = match[2].trim();
                    const timeParts = timeRange.split('-').map(s => s.trim());

                    if (timeParts.length === 2) {
                        const startLabel = timeParts[0];
                        const endLabel = timeParts[1];
                        days.push(day);
                        perDayTimes[day] = {
                            startLabel: startLabel,
                            endLabel: endLabel,
                            start24: parseTime12to24(startLabel),
                            end24: parseTime12to24(endLabel)
                        };
                    }
                }

                if (days.length > 0) {
                    st = {
                        interval: 1,
                        period: 'Week',
                        days: days,
                        perDayTimes
                    };
                    stateByTeacher.set(teacherIdx, st);
                    console.log(`Parsed schedule for teacher ${teacherIdx}:`, st);
                }
            }
        }


        if (!st) {
            st = {
                interval: 1,
                period: 'Week',
                days: [],
                perDayTimes: {}
            };
        }

        const scheduleLabel = labelFromState(st);

        const scheduleArray = (st.days || []).map(day => {
            const dayTimes = st.perDayTimes?. [day] || {};
            return {
                day: day,
                startTime: dayTimes.startLabel || '',
                endTime: dayTimes.endLabel || ''
            };
        });

        return {
            id: idVal || null,
            fullName,
            shortName,
            className,
            classType,
            timezoneLabel: tzLabel,
            timezoneIANA: tzIANA,
            colorHex,
            scheduleLabel,
            schedule: {
                type: (() => {
                    const p = (st.period || 'Week').toLowerCase();
                    if (p.includes('day')) return 'DAILY';
                    if (p.includes('week')) return 'WEEKLY';
                    if (p.includes('month')) return 'MONTHLY';
                    if (p.includes('year')) return 'YEARLY';
                    return 'UNKNOWN';
                })(),
                doesRepeat: true,
                interval: st.interval || 1,
                scheduleArray: scheduleArray,
                label: scheduleLabel
            },
            startDateLabel: dateLabel,
            startDateUnix
        };
    };

    // ========= VALIDATION =========
    const validate = ({
        cohortId,
        shortName,
        t1,
        t2
    }) => {
        const errors = [];

        if (!cohortId) errors.push({
            msg: 'Select a cohort',
            node: $('.cohortDropdownBtn')
        });

        if (!shortName) errors.push({
            msg: 'Cohort short name is required',
            node: $('.cohortShortNameInput')
        });

        const checkTeacher = (t, idx) => {
            const root = $(`.teacher-block[data-teacher="${idx}"]`) || ROOT;
            if (!t.id) errors.push({
                msg: `Select Teacher ${idx}`,
                node: root.querySelector('.calendar_admin_details_create_cohort_teacher_btn')
            });
            if (!t.className || /select class/i.test(t.className)) errors.push({
                msg: `Select Class for Teacher ${idx}`,
                node: root.querySelector(`#className${idx}DropdownBtn`)
            });

            // Enhanced schedule validation with better debugging
            console.log(`Teacher ${idx} schedule validation:`, {
                scheduleLabel: t.scheduleLabel,
                scheduleType: t.schedule?.type,
                scheduleArray: t.schedule?.scheduleArray,
                scheduleArrayLength: t.schedule?.scheduleArray?.length,
                hasDays: t.schedule?.scheduleArray && t.schedule.scheduleArray.length > 0
            });

            // Check if schedule is set up at all
            if (!t.scheduleLabel || /does not repeat/i.test(t.scheduleLabel)) {
                errors.push({
                    msg: `Please set up a schedule for Teacher ${idx}`,
                    node: root.querySelector('.cohort_schedule_btn')
                });
            }
            // Only check for days if it's a weekly schedule AND the label indicates days are selected
            else if (t.schedule?.type === 'WEEKLY') {
                // Check if the schedule label actually contains day information
                const hasDaysInLabel = /(Mon|Tue|Wed|Thu|Fri|Sat|Sun)/i.test(t.scheduleLabel);
                const hasScheduleArray = t.schedule?.scheduleArray && t.schedule.scheduleArray.length > 0;

                console.log(`Teacher ${idx} weekly schedule check:`, {
                    hasDaysInLabel,
                    hasScheduleArray,
                    scheduleLabel: t.scheduleLabel
                });

                if (!hasDaysInLabel && !hasScheduleArray) {
                    errors.push({
                        msg: `Teacher ${idx}: Please select at least one day for the weekly schedule.`,
                        node: root.querySelector('.cohort_schedule_btn')
                    });
                }

                // Validate time slots only if we have days
                if (hasScheduleArray) {
                    t.schedule.scheduleArray.forEach(item => {
                        const startTime = parseTime12to24(item.startTime);
                        const endTime = parseTime12to24(item.endTime);
                        const s = mins(startTime),
                            e = mins(endTime);
                        if (!item.startTime || !item.endTime) {
                            errors.push({
                                msg: `Teacher ${idx}: Pick start & end time for ${item.day}`,
                                node: root
                            });
                        } else if (s != null && e != null && e <= s) {
                            errors.push({
                                msg: `Teacher ${idx}: ${item.day} end time must be after start time`,
                                node: root
                            });
                        }
                    });
                }
            }

            if (!t.startDateUnix) errors.push({
                msg: `Select ${idx===1?'Start':'End'} Date for Teacher ${idx}`,
                node: root.querySelector('.conference_modal_date_btn')
            });
        };

        checkTeacher(t1, 1);
        checkTeacher(t2, 2);

        if (errors.length) {
            console.warn('Validation errors:', errors.map(e => e.msg));
            highlight(errors[0].node);
            return {
                ok: false,
                errors
            };
        }
        return {
            ok: true,
            errors: []
        };
    };

    // ========= BUILD PAYLOAD =========
    const buildPayload = (cohortId, shortName, enabled, visible, t1, t2) => {
        const main = (t1.classType === 'main') ? t1 : (t2.classType === 'main') ? t2 : t1;
        const tutor = (main === t1) ? t2 : t1;

        const cohort = {
            idNumber: cohortId,
            shortName: shortName,
            enabled: enabled,
            visible: visible,
            teachers: {
                teacher1: t1,
                teacher2: t2
            },
            scheduleLabels: {
                main: main.schedule.label || 'Does not repeat',
                tutor: tutor.schedule.label || 'Does not repeat',
                timezoneMainLabel: main.timezoneLabel || '',
                timezoneTutorLabel: tutor.timezoneLabel || ''
            }
        };
        return [cohort];
    };

    // ========= WIRE UPDATE BUTTON =========
    const updateBtn = $('.calendar_admin_details_create_cohort_btn');
    if (updateBtn) {
        updateBtn.addEventListener('click', (e) => {
            e.preventDefault();

            // ✅ Show loader
            const loader = document.getElementById('loader');
            if (loader) loader.style.display = 'flex';

            const cohortBtn = $('.cohortDropdownBtn');
            const cohortId = cohortBtn?.getAttribute('data-idnumber') || '';
            const shortName = val('.cohortShortNameInput');
            const enabled = $('.toggleActiveManage')?.classList.contains('active') ? 1 : 0;
            const visible = $('.toggleAvailableManage')?.classList.contains('active') ? 1 : 0;

            let t1 = readTeacher(1);
            let t2 = readTeacher(2);

            const check = validate({
                cohortId,
                shortName,
                t1,
                t2
            });

            if (!check.ok) {
                // ✅ Hide loader on validation error
                if (loader) loader.style.display = 'none';
                return;
            }

            const payload = buildPayload(cohortId, shortName, enabled, visible, t1, t2);

            console.log('✅ Update Cohort payload:', payload);
            console.log('✅ JSON:\n', JSON.stringify(payload, null, 2));

            t1 = payload[0].teachers.teacher1;
            t2 = payload[0].teachers.teacher2;
            const main = (t1.classType === 'main') ? t1 : (t2.classType === 'main') ? t2 : t1;
            const tutor = (main === t1) ? t2 : t1;

            // helpers (local to this block)
            const toHM = lbl => {
                const p = (lbl ? parseTime12to24(lbl) : null);
                return {
                    hours: p?.hour ?? null,
                    minutes: p?.minute ?? null
                };
            };
            const flagsFromScheduleArr = (arr = []) => {
                const set = new Set(arr.map(d => d.day));
                return {
                    cohortmonday: set.has('Mon') ? 1 : 0,
                    cohorttuesday: set.has('Tue') ? 1 : 0,
                    cohortwednesday: set.has('Wed') ? 1 : 0,
                    cohortthursday: set.has('Thu') ? 1 : 0,
                    cohortfriday: set.has('Fri') ? 1 : 0,
                };
            };

            const idnumber = ($('.cohortDropdownBtn')?.getAttribute('data-idnumber') || '').trim();
            const shortname = ($('.cohortShortNameInput')?.value || '').trim();
            const name = shortname || idnumber || 'Cohort';

            const startdate = main.startDateUnix || tutor.startDateUnix || 0;
            // Use tutor's date (teacher 2) as cohort end date if present,
            // otherwise fall back to main's date so we never silently force 0.
            const enddate = tutor.startDateUnix || main.startDateUnix || 0;

            const mainFirst = (main.schedule?.scheduleArray && main.schedule.scheduleArray[0]) || null;
            const tutorFirst = (tutor.schedule?.scheduleArray && tutor.schedule.scheduleArray[0]) || null;

            const mainHM = mainFirst ? toHM(mainFirst.startTime) : toHM(null);
            const tutorHM = tutorFirst ? toHM(tutorFirst.startTime) : toHM(null);

            const mainDays = flagsFromScheduleArr(main.schedule?.scheduleArray || []);
            const tutorDays = (() => {
                const set = new Set((tutor.schedule?.scheduleArray || []).map(d => d.day));
                return {
                    cohorttutormonday: set.has('Mon') ? 1 : 0,
                    cohorttutortuesday: set.has('Tue') ? 1 : 0,
                    cohorttutorwednesday: set.has('Wed') ? 1 : 0,
                    cohorttutorthursday: set.has('Thu') ? 1 : 0,
                    cohorttutorfriday: set.has('Fri') ? 1 : 0,
                };
            })();

            const teacher1Id = ($('#teacher1UserId')?.value || '').trim() || null;
            const teacher2Id = ($('#teacher2UserId')?.value || '').trim() || null;

            const singleCohort = {
                name,
                idnumber,
                shortname,
                visible,
                enabled,
                description: '',
                descriptionformat: 1,
                cohortcolor: main.colorHex || tutor.colorHex || null,
                startdate,
                enddate,
                cohorthours: mainHM.hours,
                cohortminutes: mainHM.minutes,
                cohorttutorhours: tutorHM.hours,
                cohorttutorminutes: tutorHM.minutes,
                ...mainDays,
                ...tutorDays,
                cohortmainteacher: teacher1Id,
                cohortguideteacher: teacher2Id,
                cohortmaintz: main.timezoneIANA || main.timezoneLabel || null,
                cohorttutortz: tutor.timezoneIANA || tutor.timezoneLabel || null,
                cohortmainclassname: main.className || null,
                cohorttutorclassname: tutor.className || null,
            };

            console.log('➡ [manage] singleCohort ready for backend:', singleCohort);

            // POST to your UPDATE PHP
            (async () => {
                try {
                    const url = (window.M?.cfg?.wwwroot || '') +
                        '/local/customplugin/ajax/update_cohort.php';
                    const res = await fetch(url, {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json'
                        },
                        credentials: 'same-origin',
                        body: JSON.stringify({
                            sesskey: window.M?.cfg?.sesskey || '',
                            cohort: singleCohort
                        })
                    });

                    let json = null;
                    try {
                        json = await res.json();
                    } catch (e) {
                        console.error('JSON parse error:', e);
                    }

                    const ok = !!(json && (json.ok || json.success));
                    const cid = json?.id ?? json?.cohortid ?? null;

                    if (!ok) {
                        const msg = json?.message || json?.error || (res.status + ' ' + res
                            .statusText);

                        // Use showNotification if available, otherwise alert
                        if (typeof showNotification === 'function') {
                            showNotification('Failed to update cohort: ' + msg, 'error');
                        } else {

                            showToastManage('❌ Failed to update cohort: ' + msg);
                        }

                        console.error('[manage] Update cohort error:', {
                            json,
                            status: res.status
                        });
                        return;
                    }

                    // ✅ Success notification
                    if (typeof showNotification === 'function') {
                        showToastManage('Cohort updated' + (cid ? ` (id ${cid})` : '') + ': ' +
                            name, 'success');
                    } else {
                        showToastManage('✅ Cohort updated' + (cid ? ` (id ${cid})` : '') + ': ' +
                            name);
                    }

                    console.log('✅ cohort_update_cohort OK:', json);

                    // Keep loader visible during calendar refresh
                    // Show global loader if not already shown
                    if (window.showGlobalLoader) {
                        window.showGlobalLoader();
                    }

                    // Refresh calendar events - wait for it to complete
                    try {
                        if (window.refetchCustomPluginData) {
                            // refetchCustomPluginData already shows/hides loader internally
                            await window.refetchCustomPluginData('update-cohort');
                        } else if (window.fetchCalendarEvents) {
                            // fetchCalendarEvents shows loader unless skipLoaderShow is true
                            await window.fetchCalendarEvents(false); // false = don't skip loader
                        }
                    } catch (fetchError) {
                        console.error('Error refreshing calendar:', fetchError);
                        // Hide loader on error
                        if (window.hideGlobalLoader) window.hideGlobalLoader();
                        if (loader) loader.style.display = 'none';
                    }
                    // Note: Loader will be hidden by refetchCustomPluginData or fetchCalendarEvents in their finally blocks

                    // Reset form after 1 second
                    setTimeout(() => {
                        resetManageCohortFields();
                    }, 1000);

                } catch (err) {
                    console.error('[manage] Unexpected error:', err);

                    if (typeof showNotification === 'function') {
                        showNotification('Unexpected error updating cohort', 'error');
                    } else {

                        showToastManage('❌ Unexpected error updating cohort');
                    }
                    // Hide loader on error
                    if (window.hideGlobalLoader) window.hideGlobalLoader();
                    if (loader) loader.style.display = 'none';
                }
                // Note: Don't hide loader in finally - let refetchCustomPluginData or fetchCalendarEvents handle it
            })();

        }, {
            passive: false
        });
    }
})();
</script>

<script src="js/calendar_admin_details_manage_cohort_plus_icon_new_content.js"></script>

<?php require_once('calendar_admin_details_create_cohort_select_date.php');?>
<?php require_once('calendar_admin_details_create_cohort_tab_does_repeat.php');?>
