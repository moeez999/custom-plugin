<link rel="stylesheet"
    href="<?php echo $CFG->wwwroot; ?>/local/customplugin/css/calendar_admin_details_create_cohort_manage_class_tab.css">

<div class="calendar_admin_details_create_cohort_content tab-content" id="manageclassTabContent" style="display:none;">

    <form id="manageOneToOneForm" class="manage-one2one-form" novalidate>

    <div class="calendar_admin_details_create_cohort_manage_class_tab_wrap"
        id="calendar_admin_details_create_cohort_manage_class_tab_widget">
        <div class="calendar_admin_details_create_cohort_manage_class_tab_label">Teacher</div>

        <!-- Trigger -->
        <button type="button" class="calendar_admin_details_create_cohort_manage_class_tab_trigger"
            aria-haspopup="listbox" aria-expanded="false"
            id="calendar_admin_details_create_cohort_manage_class_tab_trigger">
            <div class="calendar_admin_details_create_cohort_manage_class_tab_left">
                <img class="calendar_admin_details_create_cohort_manage_class_tab_avatar"
                    id="calendar_admin_details_create_cohort_manage_class_tab_current_img"
                    src="https://images.unsplash.com/photo-1544005313-94ddf0286df2?q=80&w=200&auto=format&fit=crop"
                    alt="Selected teacher">
                <span class="calendar_admin_details_create_cohort_manage_class_tab_name"
                    id="calendar_admin_details_create_cohort_manage_class_tab_current_label">Daniela</span>
            </div>

            <img class="calendar_admin_details_create_cohort_manage_class_tab_chev" src="./img/dropdown-arrow-down.svg"
                alt="">
        </button>

        <!-- Dropdown -->
        <div class="calendar_admin_details_create_cohort_manage_class_tab_menu"
            id="calendar_admin_details_create_cohort_manage_class_tab_menu">
            <div class="calendar_admin_details_create_cohort_manage_class_tab_panel" role="listbox"
                aria-labelledby="calendar_admin_details_create_cohort_manage_class_tab_trigger"
                id="calendar_admin_details_create_cohort_manage_class_tab_list">
                <input type="text" id="teacherSearchInputManage" class="dropdown-search"
                    placeholder="Enter Teacher Name...">
                <!-- Items (dynamic) -->
                <?php
require_once(__DIR__ . '/../../config.php');
require_login();

global $DB, $PAGE, $OUTPUT;

/** Collect unique teacher user IDs from cohorts */
$userIds = $DB->get_fieldset_sql("
    SELECT DISTINCT uid
      FROM (
            SELECT cohortmainteacher AS uid FROM {cohort}
             WHERE cohortmainteacher IS NOT NULL AND cohortmainteacher > 0
            UNION
            SELECT cohortguideteacher AS uid FROM {cohort}
             WHERE cohortguideteacher IS NOT NULL AND cohortguideteacher > 0
      ) t
");

/** Fetch user records (not deleted/suspended) */
$teachers = [];
if ($userIds) {
    list($inSql, $params) = $DB->get_in_or_equal($userIds, SQL_PARAMS_NAMED);
    $fields = "id, firstname, lastname, picture, imagealt, firstnamephonetic, lastnamephonetic, middlename, alternatename";
    $teachers = $DB->get_records_select('user', "id $inSql AND deleted = 0 AND suspended = 0", $params, 'firstname ASC, lastname ASC', $fields);
}
$teachersItemsHtml = '';

if (!empty($teachers)) {
    foreach ($teachers as $teacher) {
        $picture = new user_picture($teacher);
        $picture->size = 50;
        $imageUrl = $picture->get_url($PAGE)->out(false);
        $name   = fullname($teacher, true);

        $teachersItemsHtml .=
            '<div class="calendar_admin_details_create_cohort_manage_class_tab_item" role="option" '.
                'data-userid="'.(int)$teacher->id.'" '.
                'data-name="'.s($name).'" '.
                'data-img="'.s($imageUrl).'">'.
                '<img class="calendar_admin_details_create_cohort_manage_class_tab_avatar" src="'.s($imageUrl).'" alt="'.s($name).'" />'.
                '<span class="calendar_admin_details_create_cohort_manage_class_tab_item_name">'.format_string($name).'</span>'.
            '</div>';
    }
} else {
    $teachersItemsHtml =
        '<div class="calendar_admin_details_create_cohort_manage_class_tab_item" role="option" aria-disabled="true">'.
            '<span class="calendar_admin_details_create_cohort_manage_class_tab_item_name">No teachers found</span>'.
        '</div>';
}
echo $teachersItemsHtml;
?>
            </div>
        </div>
    </div>

    <label class="one2one-section-label">Student</label>
    <div class="one2one-student-dropdown-wrapper disabled" id="studentDropdownWrapper">
        <div class="one2one-add-student-card disabled" id="one2oneAddStudentBtnManage" tabindex="0">
            <span class="one2one-add-student-icon">
                <svg width="21" height="21" viewBox="0 0 20 20" fill="none">
                    <circle cx="10" cy="7" r="4" fill="#000" />
                    <ellipse cx="10" cy="15.3" rx="6.5" ry="3.3" fill="#000" />
                </svg>
            </span>
            <span class="one2one-add-student-placeholder" style="color:#aaa;">Select a teacher first</span>
        </div>
        <div class="one2one-student-dropdown-list" id="one2oneStudentDropdownManage" style="display:none;">
            <input type="text" id="studentSearchInputManage" class="dropdown-search"
                placeholder="Enter student name...">
            <?php
global $DB, $PAGE;

// 1) Resolve the Student role id (fallback to id=5 if shortname not found).
$studentRole = $DB->get_record('role', ['shortname' => 'student']);
$studentRoleId = $studentRole ? (int)$studentRole->id : 5;

// 2) Get distinct user IDs that have the Student role (any context).
$userIds = $DB->get_fieldset_sql("
    SELECT DISTINCT ra.userid
      FROM {role_assignments} ra
     WHERE ra.roleid = ?
", [$studentRoleId]);

$studentsItemsHtml = '';

if (!empty($userIds)) {
    list($inSql, $params) = $DB->get_in_or_equal($userIds, SQL_PARAMS_NAMED, 'u');
    // 3) Fetch user records (not deleted/suspended)
    $fields = "id, firstname, lastname, picture, imagealt, firstnamephonetic, lastnamephonetic, middlename, alternatename";
    $users = $DB->get_records_select('user', "id $inSql AND deleted = 0 AND suspended = 0", $params, 'firstname ASC, lastname ASC', $fields);

    // Helper: choose the correct membership-check function name you provided.
    $checkFunction = function_exists('membership_check_user_subscription') ? 'membership_check_user_subscription'
             : (function_exists('membership_check_user_subscriptionr') ? 'membership_check_user_subscriptionr' : null);

    foreach ($users as $user) {
        // 4) Must have an ACTIVE subscription
        $isActive = false;
        $methodLabel = 'Subscription';

        if ($checkFunction) {
            $status = $checkFunction($user->id);
            if (!empty($status) && isset($status['state']) && $status['state'] === 'active') {
                $isActive = true;
                if (isset($status['method']) && $status['method']) {
                    // Optional: show method like PayPal/Braintree/Patreon/Manual
                    $methodLabel = 'Subscription';
                }
            }
        } else {
            // If checker not available, skip (or set your own fallback)
            continue;
        }

        if (!$isActive) {
            continue;
        }

        // 5) Build avatar URL just like teachers
        $picture = new user_picture($user);
        $picture->size = 50;
        $imageUrl = $picture->get_url($PAGE)->out(false);
        $name   = fullname($user, true);

        // 6) Build item (keep structure/classes the same)
        $studentsItemsHtml .=
            '<div class="one2one-student-list-item" data-userid="'.(int)$user->id.'" data-name="'.s($name).'">'.
                '<div class="one2one-student-list-avatar">'.
                    '<img src="'.s($imageUrl).'" alt="'.s($name).'" style="width:24px;height:24px;border-radius:50%;object-fit:cover;" />'.
                '</div>'.
                '<div class="one2one-student-list-meta">'.
                    '<div class="one2one-student-list-name">'.format_string($name).'</div>'.
                    '<div class="one2one-student-list-lessons">0 Lessons</div>'.
                '</div>'.
                '<div class="one2one-student-list-status">'.$methodLabel.'</div>'.
            '</div>';
    }
}

// 7) Empty state
if ($studentsItemsHtml === '') {
    $studentsItemsHtml =
        '<div class="one2one-student-list-item" aria-disabled="true">'.
            '<div class="one2one-student-list-meta">'.
                '<div class="one2one-student-list-name">No active subscribers</div>'.
                '<div class="one2one-student-list-lessons">—</div>'.
            '</div>'.
            '<div class="one2one-student-list-status">—</div>'.
        '</div>';
}

echo $studentsItemsHtml;
?>
        </div>
    </div>

    <!-- Change Teacher Checkbox -->
    <div class="one2one-change-teacher-section" style="margin-top: 15px;">
        <label class="one2one-checkbox-label"
            style="display: flex; justify-content: end; align-items: center; gap: 8px; cursor: pointer;">
            <input type="checkbox" id="changeTeacherCheckbox"
                style="display:none;width: 18px; height: 18px; cursor: pointer;">
            <span style="font-size: 14px; font-weight: 600; display:flex;gap:5px; align-item:center;"><img
                    src="./img/assign-teacher.svg" alt=""> Assign
                Tutor</span>
        </label>
    </div>

    <!-- New Teacher Dropdown (hidden by default) -->
    <div id="newTeacherDropdownSection" style="display: none; margin-top: 15px;">
        <div class="calendar_admin_details_create_cohort_manage_class_tab_wrap">
            <div class="calendar_admin_details_create_cohort_manage_class_tab_label">New Teacher</div>

            <!-- Trigger -->
            <button type="button" class="calendar_admin_details_create_cohort_manage_class_tab_trigger"
                aria-haspopup="listbox" aria-expanded="false" id="newTeacherDropdownTrigger">
                <div class="calendar_admin_details_create_cohort_manage_class_tab_left">
                    <img class="calendar_admin_details_create_cohort_manage_class_tab_avatar" id="newTeacherCurrentImg"
                        src="https://images.unsplash.com/photo-1544005313-94ddf0286df2?q=80&w=200&auto=format&fit=crop"
                        alt="Selected teacher">
                    <span class="calendar_admin_details_create_cohort_manage_class_tab_name"
                        id="newTeacherCurrentLabel">Select new teacher</span>
                </div>

                <img class="calendar_admin_details_create_cohort_manage_class_tab_chev"
                    src="./img/dropdown-arrow-down.svg" alt="">
            </button>

            <!-- Dropdown -->
            <div class="calendar_admin_details_create_cohort_manage_class_tab_menu" id="newTeacherDropdownMenu">
                <div class="calendar_admin_details_create_cohort_manage_class_tab_panel" role="listbox"
                    aria-labelledby="newTeacherDropdownTrigger" id="newTeacherDropdownList">
                    <input type="text" id="newTeacherSearchInput" class="dropdown-search"
                        placeholder="Enter Teacher Name...">
                    <!-- Items (dynamic) -->
                    <?php
                    /** Collect unique teacher user IDs from cohorts */
                    $userIds = $DB->get_fieldset_sql("
                        SELECT DISTINCT uid
                          FROM (
                                SELECT cohortmainteacher AS uid FROM {cohort}
                                 WHERE cohortmainteacher IS NOT NULL AND cohortmainteacher > 0
                                UNION
                                SELECT cohortguideteacher AS uid FROM {cohort}
                                 WHERE cohortguideteacher IS NOT NULL AND cohortguideteacher > 0
                          ) t
                    ");

                    /** Fetch user records (not deleted/suspended) */
                    $teachersNew = [];
                    if ($userIds) {
                        list($inSql, $params) = $DB->get_in_or_equal($userIds, SQL_PARAMS_NAMED);
                        $fields = "id, firstname, lastname, picture, imagealt, firstnamephonetic, lastnamephonetic, middlename, alternatename";
                        $teachersNew = $DB->get_records_select('user', "id $inSql AND deleted = 0 AND suspended = 0", $params, 'firstname ASC, lastname ASC', $fields);
                    }
                    $teachersNewHtml = '';

                    if (!empty($teachersNew)) {
                        foreach ($teachersNew as $teacher) {
                            $picture = new user_picture($teacher);
                            $picture->size = 50;
                            $imageUrl = $picture->get_url($PAGE)->out(false);
                            $name   = fullname($teacher, true);

                            $teachersNewHtml .=
                                '<div class="calendar_admin_details_create_cohort_manage_class_tab_item new-teacher-item" role="option" '.
                                    'data-userid="'.(int)$teacher->id.'" '.
                                    'data-name="'.s($name).'" '.
                                    'data-img="'.s($imageUrl).'">'.
                                    '<img class="calendar_admin_details_create_cohort_manage_class_tab_avatar" src="'.s($imageUrl).'" alt="'.s($name).'" />'.
                                    '<span class="calendar_admin_details_create_cohort_manage_class_tab_item_name">'.format_string($name).'</span>'.
                                '</div>';
                        }
                    } else {
                        $teachersNewHtml =
                            '<div class="calendar_admin_details_create_cohort_manage_class_tab_item" role="option" aria-disabled="true">'.
                                '<span class="calendar_admin_details_create_cohort_manage_class_tab_item_name">No teachers found</span>'.
                            '</div>';
                    }
                    echo $teachersNewHtml;
                    ?>
                </div>
            </div>
        </div>
    </div>

    <label class="one2one-section-label">Lesson type</label>
    <div class="one2one-lesson-type-row">
        <div class="one2one-lesson-type-btn-manage " data-type="single">
            <span class="one2one-lesson-type-icon">
                <img src="./img/single-lesson" alt="">
            </span>
            Single lessons
            <input type="radio" class="one2one-radio" name="lessonType" value="single">
        </div>
        <div class="one2one-lesson-type-btn-manage" data-type="weekly">
            <span class="one2one-lesson-type-icon">
                <img src="./img/weekly-lesson" alt="">
            </span>
            Weekly lessons
            <input type="radio" class="one2one-radio" name="lessonType" value="weekly">
        </div>
    </div>

    <div id="custom-single-lesson-manage">
        <label class="one2one-section-label">Select Single Lesson</label>
        <div class="dropdown-container" id="singleLessonDropdownWrapper">
            <div class="dropdown-display" id="singleLessonDropdownDisplayManage"> Single Lessons
            </div>

            <section id="single-lesson-dropdown-section">
                <div class="single-lesson-dropdown-card dropdown-content">

                </div>
            </section>
        </div>
        <label class="one2one-section-label">Date and time</label>

        <div class="dropdown-container" id="durationDropdownWrapper">
            <div class="dropdown-display" id="durationDropdownDisplayManage">50 Minutes (Standard time)</div>
            <div class="dropdown-content" id="durationDropdownListManage">
                <div class="one2one-duration-option" data-minutes="20">20 Minutes</div>
                <div class="one2one-duration-option selected" data-minutes="50">50 Minutes</div>
                <div class="one2one-duration-option" data-minutes="60">1 Hour</div>
                <div class="one2one-duration-option" data-minutes="90">1 Hour 30 Minutes</div>
                <div class="one2one-duration-option" data-minutes="120">2 Hours</div>
            </div>
        </div>

        <div class="one2one-datetime-dropdown-row">
            <div class="one2one-date-dropdown-display" id="customDateDropdownDisplayManage"
                style="width:100%; padding:13px 14px; border-radius:10px; border:1.5px solid #dadada; background:#fff; font-size:1.05rem; color:#232323; margin-bottom:12px; cursor:pointer; display:flex; align-items:center; justify-content:center;">
                <span id="selectedDateTextManage">Tue, Feb11</span>
            </div>
            <div class="d-flex" id="customTimeFields" style="width:100%;">
                <div class="custom-time-pill" style="width:100%;">
                    <input type="text" class="form-control time-input" value="10:30 am" autocomplete="off" readonly
                        style="background-color:#ffffff; height: 50px;" />
                    <div class="custom-time-dropdown"></div>
                </div>
            </div>
        </div>
    </div>

    <div id="custom-weekly-lesson-manage" style="display:none;">

        <label class="one2one-section-label">Select Weekly Lesson</label>
        <div class="dropdown-container" id="weeklyLessonDropdownWrapper">
            <div class="dropdown-display" id="weeklyLessonDropdownDisplayManage"> Weekly Lessons
            </div>
            <section id="weekly-single-lesson">
                <div class="weekly-single-lesson-container dropdown-content">

                </div>
            </section>
        </div>

        <div id="weeklyLessonModalBackdropManage" class="weekly_lesson_modal_backdrop">
            <div class="weekly_lesson_modal_container">
                <div style="margin-bottom:16px;">
                    <div style="display:flex; align-items:center; gap:13px; margin-top:7px;">
                        <label style="font-weight:600; color:#000000;">Repeat Every</label>

                        <button class="weekly_lesson_stepper_manage" id="weeklyLessonIntervalMinusManage">−</button>
                        <span id="weeklyLessonIntervalDisplayManage"
                            style="font-size:1.18rem;font-weight:bold;">1</span>
                        <button class="weekly_lesson_stepper_manage" id="weeklyLessonIntervalPlusManage">+</button>
                        <div class="weekly_lesson_dropdown_wrapper">
                            <div class="weekly_lesson_dropdown_btn" id="weeklyLessonPeriodBtnManage">
                                <span id="weeklyLessonPeriodDisplayManage">Week</span>
                                <svg width="18" height="18" viewBox="0 0 20 20">
                                    <path d="M7 8l3 3 3-3" fill="none" stroke="#232323" stroke-width="2"></path>
                                </svg>
                            </div>
                            <div class="weekly_lesson_dropdown_list_manage" id="weeklyLessonPeriodListManage">
                                <div class="weekly_lesson_option_manage">Week</div>
                                <div class="weekly_lesson_option_manage">Bi-Weekly</div>
                            </div>
                        </div>
                    </div>
                </div>

                <hr class="weekly_lesson_hr">
                <div style="margin-bottom:16px; display:flex; align-items:center; gap:10px;">
                    <label style="font-weight:600; color:#000000;">Start Date</label>
                    <button id="weeklyLessonStartDateBtnManage" class="weekly_lesson_date_btn enabled"
                        style="margin-top:7px; text-align:left; padding:12px 18px;">
                        <span id="weeklyLessonStartDateTextManage">Select start date</span>
                    </button>
                </div>

                <div class="monthly_cal_modal_backdrop" id="weeklyLessonStartDateCalendarBackdropManage"
                    style="display:none;">
                    <div class="monthly_cal_modal">
                        <div class="monthly_cal_header">
                            <button id="weeklyLessonCalendarPrevManage"
                                style="background:none;border:none;font-size:1.4rem;cursor:pointer;color:#232323;"
                                aria-label="Previous month">&#8592;</button>
                            <span class="monthly_cal_month_label" id="weeklyLessonCalendarMonthManage"></span>
                            <button id="weeklyLessonCalendarNextManage"
                                style="background:none;border:none;font-size:1.4rem;cursor:pointer;color:#232323;"
                                aria-label="Next month">&#8594;</button>
                        </div>
                        <div class="monthly_cal_grid" id="weeklyLessonCalendarDaysManage"></div>
                        <div class="monthly_cal_grid" id="weeklyLessonCalendarDatesManage"></div>
                        <button class="monthly_cal_done_btn" id="weeklyLessonCalendarDoneManage">Done</button>
                    </div>
                </div>
                <div id="weeklyLessonRepeatContainerManage">
                    <label style="font-weight:600; color:#000000;">Repeat on</label>
                    <div class="weekly_lesson_widget_row" id="weeklyLessonWidgetsRowManage">
                        <!-- Widgets injected by JS -->
                    </div>
                </div>

                <hr class="weekly_lesson_hr large">

                <div>
                    <label style="font-weight:600;">Ends</label>
                    <div style="margin-top:8px;">
                        <div style="display:flex;align-items:center; gap:10px; margin-bottom:6px;">
                            <input type="radio" id="weeklyLessonEndNeverManage" name="weeklyLessonEndOptionManage"
                                checked>
                            <label for="weeklyLessonEndNeverManage" style="font-size:1.05rem;">Never</label>
                        </div>
                        <div style="display:flex;align-items:center; gap:10px; margin-bottom:6px;">
                            <input type="radio" id="weeklyLessonEndOnManage" name="weeklyLessonEndOptionManage">
                            <label for="weeklyLessonEndOnManage" style="font-size:1.05rem;">On</label>
                            <button id="weeklyLessonEndDateBtnManage" disabled class="weekly_lesson_date_btn">Sep 27,
                                2024</button>
                        </div>
                        <div style="display:flex;align-items:center; gap:10px;">
                            <input type="radio" id="weeklyLessonEndAfterManage" name="weeklyLessonEndOptionManage">
                            <label for="weeklyLessonEndAfterManage" style="font-size:1.05rem;">After</label>
                            <div class="weekly_lesson_occurrence_counter" style="margin-left:12px;">
                                <button class="weekly_lesson_stepper_manage" id="weeklyLessonOccurrenceMinusManage"
                                    disabled>−</button>
                                <span id="weeklyLessonOccurrenceDisplayManage"
                                    style="font-size:1.11rem;font-weight:600;">13
                                    occurrences</span>
                                <button class="weekly_lesson_stepper_manage" id="weeklyLessonOccurrencePlusManage"
                                    disabled>+</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- ========= TIME PICKER FOR WEEKLY ========= -->
        <div id="weeklyLessonTimepickerBackdropManage" class="weekly_lesson_timepicker_modal_backdrop_manage">
            <div class="weekly_lesson_timepicker_modal">
                <h2 class="weekly_lesson_timepicker_card_title" id="weeklyLessonTimepickerDayLabelManage">Select Start &
                    End Time</h2>
                <div class="weekly_lesson_timepicker_inputs_container">
                    <input id="weekly_lesson_timepicker_start_manage" type="text" class="weekly_lesson_timepicker_input"
                        value="09:00 AM" />
                    <span style="color:#232323;">–</span>
                    <input id="weekly_lesson_timepicker_end_manage" type="text" class="weekly_lesson_timepicker_input"
                        value="10:00 AM" />
                </div>
                <div class="weekly_lesson_timepicker_button_container">
                    <button id="weeklyLessonTimepickerCancelBtnManage"
                        class="weekly_lesson_timepicker_cancel_btn_manage">Cancel</button>
                    <button id="weeklyLessonTimepickerDoneBtnManage"
                        class="weekly_lesson_timepicker_done_btn_manage">Done</button>
                </div>
            </div>
        </div>
    </div>

    <div class="manage-one2one-hidden-fields" aria-hidden="true" style="display:none;">
        <input type="hidden" name="teacherid" id="manageTeacherIdInput">
        <input type="hidden" name="studentid" id="manageStudentIdInput">
        <input type="hidden" name="lessontype" id="manageLessonTypeInput">
        <input type="hidden" name="cmid" id="manageCmidInput">
        <input type="hidden" name="eventid" id="manageEventIdInput">
        <input type="hidden" name="changeteacher" id="manageChangeTeacherInput">
        <input type="hidden" name="newteacherid" id="manageNewTeacherIdInput">
        <input type="hidden" name="singledate" id="manageSingleDateInput">
        <input type="hidden" name="singletime" id="manageSingleTimeInput">
        <input type="hidden" name="singleduration" id="manageSingleDurationInput">
        <input type="hidden" name="singlefulldatetime" id="manageSingleFullDateTimeInput">
        <input type="hidden" name="weeklystartdate" id="manageWeeklyStartDateInput">
        <input type="hidden" name="weeklyinterval" id="manageWeeklyIntervalInput">
        <input type="hidden" name="weeklyperiod" id="manageWeeklyPeriodInput">
        <input type="hidden" name="weeklyendoption" id="manageWeeklyEndOptionInput">
        <input type="hidden" name="weeklyendson" id="manageWeeklyEndsOnInput">
        <input type="hidden" name="weeklyoccurrences" id="manageWeeklyOccurrencesInput">
        <input type="hidden" name="weeklydays" id="manageWeeklyDaysInput">
        <input type="hidden" name="updatescope" id="manageUpdateScopeInput">
        <input type="hidden" name="allevents" id="manageAllEventsInput">
        <input type="hidden" name="reschedulereason" id="manageRescheduleReasonInput">
        <input type="hidden" name="reschedulemessage" id="manageRescheduleMessageInput">
        <input type="hidden" name="timestamp" id="manageTimestampInput">
    </div>

    <button type="submit" class="calendar_admin_details_create_cohort_schedule_btn_manage" disabled>Update 1:1
        class</button>
    </form>
</div>

<!-- Loader Overlay -->
<div class="loader-overlay" id="loaderOverlay">
    <div class="loader"></div>
</div>

<!-- Custom Calendar Modal -->
<div class="calendar-modal-backdrop" id="calendarModalBackdropManage">
    <div class="calendar-modal" id="calendarModal">
        <div class="calendar-modal-header">
            <button type="button" class="calendar-modal-arrow" id="calendarPrevMonthManage"><svg width="22" height="22"
                    viewBox="0 0 24 24">
                    <polyline points="15 19 8 12 15 5" fill="none" stroke="#111" stroke-width="2" stroke-linecap="round"
                        stroke-linejoin="round"></polyline>
                </svg></button>
            <span id="calendarMonthYearManage">January 2025</span>
            <button type="button" class="calendar-modal-arrow" id="calendarNextMonthManage"><svg width="22" height="22"
                    viewBox="0 0 24 24">
                    <polyline points="9 19 16 12 9 5" fill="none" stroke="#111" stroke-width="2" stroke-linecap="round"
                        stroke-linejoin="round"></polyline>
                </svg></button>
        </div>
        <div class="calendar-modal-grid">
            <div class="calendar-modal-weekdays">
                <div>Mo</div>
                <div>Tu</div>
                <div>We</div>
                <div>Th</div>
                <div>Fr</div>
                <div>Sa</div>
                <div>Su</div>
            </div>
            <div class="calendar-modal-days" id="calendarDaysGridManage">
                <!-- Days rendered by JS -->
            </div>
        </div>
        <div class="calendar-modal-footer">
            <button class="calendar-modal-done" id="calendarDoneBtnManage">Done</button>
        </div>
    </div>
</div>

<!-- Global Backdrop for Dropdowns -->
<div class="dropdown-backdrop" id="globalDropdownBackdrop"></div>

<!-- Manage 1:1 Update Scope Modal -->
<div class="manage-update-scope-modal-backdrop" id="manageUpdateScopeModalBackdrop">
    <div class="manage-update-scope-modal">
        <h3 class="manage-update-scope-title">Manage 1:1</h3>
        <div class="manage-update-scope-options">
            <div class="manage-update-scope-option">
                <input type="radio" name="updateScope" id="updateScopeThisEvent" value="this" checked>
                <label for="updateScopeThisEvent">This event</label>
            </div>
            <div class="manage-update-scope-option">
                <input type="radio" name="updateScope" id="updateScopeFollowing" value="following">
                <label for="updateScopeFollowing">This and all following events</label>
            </div>
        </div>
        <div class="manage-update-scope-buttons">
            <button type="button" class="manage-update-scope-cancel-btn" id="manageUpdateScopeCancelBtn">Cancel</button>
            <button type="button" class="manage-update-scope-ok-btn" id="manageUpdateScopeOkBtn">Ok</button>
        </div>
    </div>
</div>

<!-- Reschedule Lesson Modal -->
<div class="reschedule-lesson-modal-backdrop" id="rescheduleLessonModalBackdrop">
    <div class="reschedule-lesson-modal">
        <div class="reschedule-lesson-header">
            <button class="reschedule-lesson-back-btn" id="rescheduleLessonBackBtn">
                <img src="./img/arrow-back.svg" alt="arrow-left">
            </button>
            <button class="reschedule-lesson-close-btn" id="rescheduleLessonCloseBtn">&times;</button>
        </div>

        <h2 class="reschedule-lesson-title">Reschedule lesson</h2>
        <div class="reschedule-lesson-badge">Updated lesson</div>

        <div class="reschedule-lesson-card">
            <div class="reschedule-lesson-card-header">
                <img src="" alt="" class="reschedule-lesson-avatar" id="rescheduleLessonAvatar">
                <div class="reschedule-lesson-info">
                    <p class="reschedule-lesson-date" id="rescheduleLessonDate">Friday, Sep 06</p>
                    <p class="reschedule-lesson-time" id="rescheduleLessonTime">07:00 - 07:25</p>
                </div>
            </div>
            <div class="reschedule-lesson-meta">
                <span class="reschedule-lesson-student" id="rescheduleLessonStudent">Jonas | Subscription</span>
                <span class="reschedule-lesson-count" id="rescheduleLessonCount">
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none">
                        <path d="M8 2v4M16 2v4M3 10h18M5 4h14a2 2 0 012 2v14a2 2 0 01-2 2H5a2 2 0 01-2-2V6a2 2 0 012-2z"
                            stroke="#666" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                    </svg>
                    2 Lessons
                </span>
            </div>
        </div>

        <div class="reschedule-lesson-dropdown">
            <label class="reschedule-lesson-label">Select a reason to reschedule the lesson.</label>
            <button type="button" class="reschedule-lesson-dropdown-btn" id="rescheduleReasonBtn">
                <span id="rescheduleReasonDisplay">Select Reason</span>
                <svg width="20" height="20" viewBox="0 0 24 24" fill="none">
                    <path d="M6 9l6 6 6-6" stroke="#232323" stroke-width="2" stroke-linecap="round"
                        stroke-linejoin="round" />
                </svg>
            </button>
            <div class="reschedule-lesson-dropdown-list" id="rescheduleReasonList">
                <div class="reschedule-lesson-dropdown-item" data-value="not_able_to_make_it">He's not able to make it
                    today.</div>
                <div class="reschedule-lesson-dropdown-item" data-value="timing_not_working">The timing isn't working
                    out today.</div>
                <div class="reschedule-lesson-dropdown-item" data-value="tech_issues">There are some tech issues, so we
                    can't run the class.</div>
                <div class="reschedule-lesson-dropdown-item" data-value="teacher_unavailable">The teacher isn't
                    available right now.</div>
            </div>
        </div>

        <div>
            <label class="reschedule-lesson-label">Message for Student</label>
            <textarea class="reschedule-lesson-textarea" id="rescheduleMessage"
                placeholder="Message for Jonas"></textarea>
        </div>

        <button class="reschedule-lesson-confirm-btn" id="rescheduleConfirmBtn" disabled>Confirm new time</button>
    </div>
</div>

<!-- Toast Notification -->
<div id="toastNotificationForManageClass" style="display:none; position:fixed; top:30px; right:30px; 
            background:#000; color:#fff; padding:16px 24px; 
            border-radius:8px; font-size:1rem; 
            box-shadow:0 4px 12px rgba(0,0,0,0.3);
            z-index:99999; opacity:0; transition:opacity .3s, transform .3s;
            transform:translateY(20px);">
</div>

<!-- Include centralized time, date, toast, and API utilities -->
<script src="js/time_utils.js"></script>
<script src="js/date_utils.js"></script>
<script src="js/toast_utils.js"></script>
<script src="js/api_utils.js"></script>
<!-- One2One Form Management Utilities -->
<script src="js/one2one_form_state_manager.js"></script>
<script src="js/one2one_form_populator.js"></script>
<script src="js/one2one_form_reset.js"></script>
<script src="js/one2one_update_payload_builder.js"></script>

<script>
// ====== TOAST NOTIFICATION FUNCTION ======
// showToast() is now in js/toast_utils.js
// Using: showToast() from toast_utils.js
// For backward compatibility, alias showToastManage to showToast
function showToastManage(message, duration = 5000) {
    return window.showToast(message, 'success', duration, 'toastNotificationForManageClass');
}

// ====== GLOBAL STATE AND UTILITIES ======
const DropdownManager = {
    activeDropdown: null,

    init() {
        // Set up global backdrop click handler
        const backdrop = document.getElementById('globalDropdownBackdrop');
        if (backdrop) {
            backdrop.addEventListener('click', () => {
                this.closeAll();
            });
        }

        // Initialize all dropdowns
        this.initializeDropdowns();
    },

    initializeDropdowns() {
        // Find all dropdown containers
        const dropdownContainers = document.querySelectorAll('.dropdown-container');

        dropdownContainers.forEach(container => {
            const display = container.querySelector('.dropdown-display');
            const content = container.querySelector('.dropdown-content');

            if (display && content) {
                display.addEventListener('click', (e) => {
                    e.stopPropagation();
                    this.toggleDropdown(container, content);
                });

                // Close dropdown when clicking an option
                content.addEventListener('click', (e) => {
                    if (e.target.classList.contains('one2one-duration-option') ||
                        e.target.classList.contains('single-lesson-dropdown-item') ||
                        e.target.classList.contains('weekly-single-lesson-item')) {
                        setTimeout(() => this.closeAll(), 100);
                    }
                });
            }
        });
    },

    toggleDropdown(container, content) {
        if (this.activeDropdown === content) {
            this.closeAll();
            return;
        }

        this.closeAll();
        this.activeDropdown = content;
        content.classList.add('active');
        const backdrop = document.getElementById('globalDropdownBackdrop');
        if (backdrop) {
            backdrop.classList.add('active');
        }
    },

    closeAll() {
        if (this.activeDropdown) {
            this.activeDropdown.classList.remove('active');
            this.activeDropdown = null;
        }
        const backdrop = document.getElementById('globalDropdownBackdrop');
        if (backdrop) {
            backdrop.classList.remove('active');
        }
    }
};

// ====== GLOBAL FUNCTIONS ======

function formatMinutesToDisplay(minutes) {
    if (minutes < 60) {
        return `${minutes} Minutes`;
    }

    const hours = Math.floor(minutes / 60);
    const mins = minutes % 60;

    if (mins === 0) {
        return hours === 1 ? '1 Hour' : `${hours} Hours`;
    }

    return `${hours} Hour${hours > 1 ? 's' : ''} ${mins} Minutes`;
}

function getSelectedDurationInMinutes() {
    // First try to get from the display element's data attribute
    const displayEl = document.getElementById('durationDropdownDisplayManage');
    if (displayEl && displayEl.dataset.minutes) {
        return parseInt(displayEl.dataset.minutes) || 50;
    }

    // Fallback to selected option
    const selectedOption = document.querySelector('.one2one-duration-option.selected');
    return selectedOption ? parseInt(selectedOption.dataset.minutes) || 50 : 50;
}

function updateEndsUI() {
    const $ = (sel, root = document) => root.querySelector(sel);
    const onChecked = $('#weeklyLessonEndOnManage')?.checked;
    const afterChecked = $('#weeklyLessonEndAfterManage')?.checked;

    const endBtn = $('#weeklyLessonEndDateBtnManage');
    if (endBtn) {
        endBtn.disabled = !onChecked;
        endBtn.classList.toggle('enabled', !!onChecked);
    }

    const occMinusBtn = $('#weeklyLessonOccurrenceMinusManage');
    const occPlusBtn = $('#weeklyLessonOccurrencePlusManage');

    if (occMinusBtn) occMinusBtn.disabled = !afterChecked;
    if (occPlusBtn) occPlusBtn.disabled = !afterChecked;
}

// Time conversion functions are now in js/time_utils.js
// Using: convert12hTo24h() and convert24hTo12h() from time_utils.js

function renderWidgetTimeManage(key, start, end) {
    const widget = document.querySelector(`.weekly_lesson_scroll_widget_manage[data-key="${key}"]`);
    if (!widget) return;

    // Convert 24h to 12h for display
    const start12h = convert24hTo12h(start);
    const end12h = convert24hTo12h(end);

    const [startTime, startPeriod] = start12h.split(' ');
    const [endTime, endPeriod] = end12h.split(' ');

    let timeElement = widget.querySelector('.weekly_lesson_widget_time_manage');
    if (!timeElement) {
        timeElement = document.createElement('div');
        timeElement.className = 'weekly_lesson_widget_time_manage';
        timeElement.innerHTML = `
            <div class="weekly_lesson_widget_hour_minute_manage start">${startTime}</div>
            <span class="weekly_lesson_widget_period_manage start-period">${startPeriod}</span>
            <span class="weekly_lesson_widget_dash_manage">-</span>
            <div class="weekly_lesson_widget_hour_minute_manage end">${endTime}</div>
            <span class="weekly_lesson_widget_period_manage end-period">${endPeriod}</span>
        `;

        // Insert after the divider
        const divider = widget.querySelector('.weekly_lesson_widget_divider_manage');
        if (divider) {
            divider.after(timeElement);
        }
    } else {
        // Update existing time element
        timeElement.querySelector('.start').textContent = startTime;
        timeElement.querySelector('.start-period').textContent = startPeriod;
        timeElement.querySelector('.end').textContent = endTime;
        timeElement.querySelector('.end-period').textContent = endPeriod;
    }

    // **FIX: Mark time element as having time**
    timeElement.classList.add('has-time');

    // **FIX: Hide the arrow button and show time dot instead**
    const button = widget.querySelector('.weekly_lesson_widget_button_manage');
    if (button) {
        button.classList.add('has-time');

        // Create time pill badge on the button (for when button shows)
        let dot = button.querySelector('.weekly_lesson_dot');
        if (!dot) {
            dot = document.createElement('span');
            dot.className = 'weekly_lesson_dot';
            button.appendChild(dot);
        }
        // short label - just show hours
        const startHour = startTime.split(':')[0];
        const endHour = endTime.split(':')[0];
        dot.textContent = `${startHour}–${endHour}`;
    }

    // **FIX: Make the time element clickable to edit**
    timeElement.style.cursor = 'pointer';
    timeElement.onclick = function(e) {
        e.stopPropagation();
        // Trigger the time picker
        const pickerBackdrop = $('#weeklyLessonTimepickerBackdropManage');
        if (pickerBackdrop) {
            weeklyLessonCurrentDayKey = key;

            const current = window.weeklyLessonDayTimes[key] || {
                start: '09:00',
                end: '10:00'
            };
            const start12h = convert24hTo12h(current.start);
            const end12h = convert24hTo12h(current.end);

            $('#weekly_lesson_timepicker_start_manage').value = start12h;
            $('#weekly_lesson_timepicker_end_manage').value = end12h;

            // Ensure pbd is always a single element
            let pbd = pickerBackdrop?. [0] ?? pickerBackdrop;
            pbd.style.display = 'block';


        }
    };
}

// Date formatting functions are now in js/date_utils.js
// Time formatting functions are now in js/time_utils.js
// Using: formatDate() from date_utils.js
// Using: formatTime12Hour() and formatTime12HourFromParts() from time_utils.js

function getDayIcon(day) {
    const iconMap = {
        'Sun': './img/ev-repeat.svg',
        'Mon': './img/ev-repeat.svg',
        'Tue': './img/ev-repeat.svg',
        'Wed': './img/ev-repeat.svg',
        'Thu': './img/ev-repeat.svg',
        'Fri': './img/ev-repeat.svg',
        'Sat': './img/ev-repeat.svg'
    };
    return iconMap[day] || './img/ev-repeat.svg';
}

// ====== STUDENT MANAGEMENT ======
async function loadStudentsForTeacher(teacherId, selectFirst = true) {
    const studentDropdownWrap = document.getElementById('one2oneStudentDropdownManage');
    const addStudentBtn = document.getElementById('one2oneAddStudentBtnManage');
    const studentDropdownWrapper = document.getElementById('studentDropdownWrapper');
    const loaderOverlay = document.getElementById('loaderOverlay');

    if (!teacherId || !studentDropdownWrap) return;

    // Show loader
    if (loaderOverlay) loaderOverlay.classList.add('active');

    try {

        const response =


            await fetch('ajax/ajax_one2one_students.php?teacherid=' + encodeURIComponent(teacherId), {
                credentials: 'same-origin'
            });
        const data = await response.json();

        // if no students, reset dropdown
        if (!data.html || data.html.trim() === '' || data.html.includes('No students found')) {
            studentDropdownWrap.innerHTML = `
            <input type="text" id="studentSearchInputManage" class="dropdown-search" placeholder="Enter student name...">
            <div class="one2one-no-students" style="padding:10px; color:#777;">No students available</div>
        `;
            if (addStudentBtn) {
                addStudentBtn.innerHTML = `<span style="color:#aaa;">No student selected</span>`;
                addStudentBtn.classList.remove('active');
            }
            // Enable dropdown wrapper even if no students
            if (studentDropdownWrapper) {
                studentDropdownWrapper.classList.remove('disabled');
                addStudentBtn.classList.remove('disabled');
            }
            if (loaderOverlay) loaderOverlay.classList.remove('active');
            validateForm();
            return;
        }

        // normal case — populate list
        studentDropdownWrap.innerHTML = `
        <input type="text" id="studentSearchInputManage" class="dropdown-search" placeholder="Enter student name...">
        ${data.html}
    `;

        // Enable dropdown wrapper
        if (studentDropdownWrapper) {
            studentDropdownWrapper.classList.remove('disabled');
            if (addStudentBtn) addStudentBtn.classList.remove('disabled');
        }

        // auto-select first student if available
        if (selectFirst) {
            const items = studentDropdownWrap.querySelectorAll('.one2one-student-list-item:not([aria-disabled])');
            if (items.length) {
                items.forEach(item => item.classList.remove('selected'));
                items[0].classList.add('selected');

                // reflect on "Add student" pill
                if (addStudentBtn) {
                    const avatar = items[0].querySelector('.one2one-student-list-avatar')?.innerHTML || '';
                    const name = items[0].dataset.name || items[0].querySelector('.one2one-student-list-name')
                        ?.textContent || 'Student';
                    addStudentBtn.innerHTML = `
                    <span class="one2one-add-student-icon">${avatar}</span>
                    <span style="font-weight:600; color:#232323;">${name}</span>
                `;
                    addStudentBtn.classList.add('active');
                }
            } else {
                // no selectable students
                if (addStudentBtn) {
                    addStudentBtn.innerHTML = `<span style="color:#aaa;">No student selected</span>`;
                    addStudentBtn.classList.remove('active');
                }
            }
        }
        // Hide loader after students loaded
        if (loaderOverlay) loaderOverlay.classList.remove('active');
        validateForm();
    } catch (error) {
        console.warn('Could not load students for teacher', error);
        // reset if request failed
        studentDropdownWrap.innerHTML = `
        <input type="text" id="studentSearchInputManage" class="dropdown-search" placeholder="Enter student name...">
        <div class="one2one-no-students" style="padding:10px; color:#777;">Unable to load students</div>
    `;
        if (addStudentBtn) {
            addStudentBtn.innerHTML = `<span style="color:#aaa;">No student selected</span>`;
            addStudentBtn.classList.remove('active');
        }
        // Hide loader on error
        if (loaderOverlay) loaderOverlay.classList.remove('active');
        validateForm();
    }
}

// ====== FORM VALIDATION ======
function validateForm() {
    const scheduleBtn = document.querySelector('.calendar_admin_details_create_cohort_schedule_btn_manage');
    if (!scheduleBtn) return;

    const teacherTrigger = document.getElementById('calendar_admin_details_create_cohort_manage_class_tab_trigger');
    const teacherId = teacherTrigger?.dataset.userid;

    const studentDropdownWrap = document.getElementById('one2oneStudentDropdownManage');
    const selectedStudent = studentDropdownWrap?.querySelector('.one2one-student-list-item.selected');
    const studentId = selectedStudent?.dataset.userid;

    const lessonType = document.querySelector('.one2one-lesson-type-btn-manage.selected')?.dataset.type;

    // Enable button only if all required fields are selected
    if (teacherId && studentId && lessonType) {
        scheduleBtn.disabled = false;
    } else {
        scheduleBtn.disabled = true;
    }
}

// Keep a real form in sync with the custom UI selections
function syncManageHiddenInputs(formData, extras = {}) {
    const form = document.getElementById('manageOneToOneForm');
    if (!form) return;

    const setValue = (id, value) => {
        const el = form.querySelector(`#${id}`);
        if (el) {
            el.value = value ?? '';
        }
    };

    setValue('manageTeacherIdInput', formData.teacherId ?? '');
    setValue('manageStudentIdInput', formData.studentId ?? '');
    setValue('manageLessonTypeInput', formData.lessonType ?? '');
    setValue('manageCmidInput', formData.cmid ?? '');
    setValue('manageEventIdInput', formData.eventId ?? '');
    setValue('manageChangeTeacherInput', formData.changeTeacher ? '1' : '0');
    setValue('manageNewTeacherIdInput', formData.newTeacherId ?? '');

    const singleLesson = formData.singleLesson || {};
    setValue('manageSingleDateInput', singleLesson.date ?? '');
    setValue('manageSingleTimeInput', singleLesson.time ?? '');
    setValue('manageSingleDurationInput', singleLesson.duration ?? '');
    setValue('manageSingleFullDateTimeInput', singleLesson.fullDateTime ?? '');

    const weeklyLesson = formData.weeklyLesson || {};
    setValue('manageWeeklyStartDateInput', weeklyLesson.startDate ?? '');
    setValue('manageWeeklyIntervalInput', weeklyLesson.interval ?? '');
    setValue('manageWeeklyPeriodInput', weeklyLesson.period ?? '');
    setValue('manageWeeklyEndOptionInput', weeklyLesson.endOption ?? weeklyLesson.endOptionLabel ?? '');
    setValue('manageWeeklyEndsOnInput', weeklyLesson.endsOn ?? '');
    setValue('manageWeeklyOccurrencesInput', weeklyLesson.occurrences ?? '');
    setValue('manageWeeklyDaysInput', weeklyLesson.days ? JSON.stringify(weeklyLesson.days) : '');

    const scopeValue = extras.scope ?? formData.updateScope ?? '';
    setValue('manageUpdateScopeInput', scopeValue);
    const allEventsValue = extras.allEvents ?? formData.allEvents ?? false;
    setValue('manageAllEventsInput', allEventsValue ? '1' : '0');

    setValue('manageRescheduleReasonInput', formData.rescheduleReason ?? '');
    setValue('manageRescheduleMessageInput', formData.rescheduleMessage ?? '');
    setValue('manageTimestampInput', formData.timestamp ?? '');
}

// ====== CORRECTED SINGLE LESSON DROPDOWN ======
function populateSingleLessonDropdown(jsonData) {
    const dropdownCard = document.querySelector('.single-lesson-dropdown-card');
    const dropdownContent = document.getElementById('singleLessonDropdownDisplayManage');
    if (!dropdownCard) return;

    if (jsonData.activities.length === 0) {
        dropdownContent.innerHTML = 'No single lessons found';
        dropdownCard.innerHTML =
            `<div class="single-lesson-dropdown-item"><div style="text-align:center;">No single lessons found</div></div>`;
        return;
    }

    dropdownCard.innerHTML = '';

    if (jsonData.activities && jsonData.activities.length > 0) {
        let firstProcessed = false;

        jsonData.activities.forEach((activity, idx) => {
            const gm = activity.googlemeet;
            if (!gm) return;

            const startDate = parseFirstStartDisp(gm.first_start_disp);
            const month = startDate.toLocaleDateString('en-US', {
                month: 'short'
            });
            const day = startDate.getDate();
            const dayOfWeek = startDate.toLocaleDateString('en-US', {
                weekday: 'long'
            });

            const startTime = formatTime12HourFromParts(parseInt(gm.starthour), parseInt(gm.startminute));
            const endTime = formatTime12HourFromParts(parseInt(gm.endhour), parseInt(gm.endminute));

            const durationSeconds = gm.events[0]?.duration || 0;
            const durationMinutes = Math.round(durationSeconds / 60);

            const item = document.createElement('div');
            item.className = 'single-lesson-dropdown-item';
            item.dataset.activityIndex = idx;
            item.dataset.startTime = startTime;
            item.dataset.endTime = endTime;
            // expose cmid on the DOM element and to the global selected variable when chosen
            try {
                console.log('single activity gm:', gm);
            } catch (e) {}
            if (gm && typeof gm.id !== 'undefined' && gm.id !== null) {
                item.dataset.cmid = String(gm.id);
            }

            item.innerHTML = `
                <div class="single-lesson-dropdown-item__date">
                    <span class="single-lesson-dropdown-date-month">${month}</span>
                    <span class="single-lesson-dropdown-date-day">${day}</span>
                </div>
                <div class="single-lesson-dropdown-item__details">
                    <p class="single-lesson-dropdown-details-time">${dayOfWeek}, ${startTime} - ${endTime}</p>
                    <div class="single-lesson-dropdown-details-info">
                        <span class="single-lesson-dropdown-info-text">Activity ${idx + 1}</span>
                        <span class="single-lesson-dropdown-info-dot"></span>
                        <span class="single-lesson-dropdown-info-text">Single lesson</span>
                        <span class="single-lesson-dropdown-info-dot"></span>
                        <span class="single-lesson-dropdown-info-text">${durationMinutes} min</span>
                    </div>
                </div>
            `;

            item.addEventListener('click', function() {
                dropdownCard.querySelectorAll('.single-lesson-dropdown-item').forEach(i => i.classList
                    .remove('selected'));
                this.classList.add('selected');

                // ✅ Read values dynamically from the clicked element
                const clickedStartTime = this.dataset.startTime;
                const clickedEndTime = this.dataset.endTime;
                const activityIndex = this.dataset.activityIndex;
                const activity = jsonData.activities[activityIndex];

                if (!activity || !activity.googlemeet) return;

                const gm = activity.googlemeet;
                const clickedStartDate = parseFirstStartDisp(gm.first_start_disp);
                const durationSeconds = gm.events[0]?.duration || 0;
                const clickedDurationMinutes = Math.round(durationSeconds / 60);

                const disp = document.getElementById('singleLessonDropdownDisplayManage');
                if (disp) {
                    const month = clickedStartDate.toLocaleDateString('en-US', {
                        month: 'short'
                    });
                    const day = clickedStartDate.getDate();
                    const dayOfWeek = clickedStartDate.toLocaleDateString('en-US', {
                        weekday: 'long'
                    });

                    disp.textContent =
                        `${month} ${day}, ${dayOfWeek}, ${clickedStartTime} - ${clickedEndTime}`;

                    const cmidVal = (gm && typeof gm.id !== 'undefined') ? gm.id : (this.dataset
                        ?.cmid ?? null);
                    if (cmidVal !== null && typeof cmidVal !== 'undefined' && cmidVal !== '') {
                        disp.dataset.cmid = String(cmidVal);
                        const wrapper = document.getElementById('singleLessonDropdownWrapper');
                        if (wrapper) wrapper.dataset.cmid = String(cmidVal);
                    }
                }

                window.selectedCmidManage = (gm && typeof gm.id !== 'undefined') ? gm.id : (this.dataset
                    ?.cmid ?? null);

                // ✅ Use the dynamically read values
                updateDateTimeFields(clickedStartDate, clickedStartTime, clickedEndTime,
                    clickedDurationMinutes);
            });

            dropdownCard.appendChild(item);
            if (!firstProcessed) {
                setTimeout(() => item.click(), 50);
                firstProcessed = true;
            }
        });
    } else {
        dropdownCard.innerHTML =
            `<div class="single-lesson-dropdown-item"><div style="text-align:center;">No single lessons found</div></div>`;
    }
}

// If you need to convert it to a Date object for the calendar:
function parseFirstStartDisp(dispString) {
    // Parse "Tue, 11 Feb 2025 10:30 AM" format
    const parts = dispString.split(' ');
    const day = parseInt(parts[1]);
    const monthStr = parts[2];
    const year = parseInt(parts[3]);

    const monthMap = {
        'Jan': 0,
        'Feb': 1,
        'Mar': 2,
        'Apr': 3,
        'May': 4,
        'Jun': 5,
        'Jul': 6,
        'Aug': 7,
        'Sep': 8,
        'Oct': 9,
        'Nov': 10,
        'Dec': 11
    };

    return new Date(year, monthMap[monthStr], day);
}
// ====== CORRECTED WEEKLY LESSON DROPDOWN ======f
function populateWeeklyLessonDropdown(jsonData) {
    const dropdownContainer = document.querySelector('.weekly-single-lesson-container');
    const dropdownContent = document.getElementById('weeklyLessonDropdownDisplayManage');
    if (jsonData.activities.length === 0) {
        dropdownContent.innerHTML = 'No weekly lessons found';
        dropdownContainer.innerHTML =
            `
            <div class="weekly-single-lesson-item"><div style="text-align:center;">No weekly lessons found</div></div>`;
        return;
    }

    if (!dropdownContainer) return;
    dropdownContainer.innerHTML = '';

    if (jsonData.activities && jsonData.activities.length > 0) {
        let firstProcessed = false;

        jsonData.activities.forEach((activity, idx) => {
            const gm = activity.googlemeet;
            if (!gm) return;

            // Parse days
            const daysObj = JSON.parse(gm.days || '{}');
            const activeDays = Object.keys(daysObj).filter(d => daysObj[d] === "1");
            if (activeDays.length === 0) return;

            const startTime = formatTime12HourFromParts(parseInt(gm.starthour), parseInt(gm.startminute));
            const endTime = formatTime12HourFromParts(parseInt(gm.endhour), parseInt(gm.endminute));
            const durationMinutes = ((gm.endhour * 60 + gm.endminute) - (gm.starthour * 60 + gm.startminute));

            // Join all days in one string like "Monday and Thursday"
            const joinedDays = activeDays.map(d => fullDayName(d)).join(' and ');

            const item = document.createElement('div');
            item.className = 'weekly-single-lesson-item';
            item.dataset.activityIndex = idx;
            item.dataset.startTime = startTime;
            item.dataset.endTime = endTime;
            // expose cmid on the DOM element for later use
            try {
                console.log('weekly activity gm:', gm);
            } catch (e) {}
            if (gm && typeof gm.id !== 'undefined' && gm.id !== null) {
                item.dataset.cmid = String(gm.id);
            }

            item.innerHTML = `
                <img src="${getDayIcon(activeDays[0])}" alt="Repeat icon" class="weekly-single-lesson-icon">
                <div class="weekly-single-lesson-details">
                    <p class="weekly-single-lesson-time">Every ${joinedDays}, ${startTime} - ${endTime}</p>
                    <p class="weekly-single-lesson-description">Weekly lesson • ${durationMinutes} min • Activity ${idx + 1}</p>
                </div>
            `;

            item.addEventListener('click', function() {
                dropdownContainer.querySelectorAll('.weekly-single-lesson-item').forEach(i => i
                    .classList.remove('selected'));
                this.classList.add('selected');

                const disp = document.getElementById('weeklyLessonDropdownDisplayManage');
                if (disp) {
                    disp.textContent = `Every ${joinedDays}, ${startTime} - ${endTime}`;
                    const cmidVal = (gm && typeof gm.id !== 'undefined') ? gm.id : (this.dataset
                        ?.cmid ?? null);
                    if (cmidVal !== null && typeof cmidVal !== 'undefined' && cmidVal !== '') {
                        disp.dataset.cmid = String(cmidVal);
                        const wrapper = document.getElementById('weeklyLessonDropdownWrapper');
                        if (wrapper) wrapper.dataset.cmid = String(cmidVal);
                    } else {
                        disp.removeAttribute('data-cmid');
                        const wrapper = document.getElementById('weeklyLessonDropdownWrapper');
                        if (wrapper) wrapper.removeAttribute('data-cmid');
                    }
                }

                // record the selected cmid for payloads (fallback to element dataset if gm missing)
                window.selectedCmidManage = (gm && typeof gm.id !== 'undefined') ? gm.id : (this
                    .dataset?.cmid ?? null);
                try {
                    console.log('weekly selected cmid:', window.selectedCmidManage, 'element dataset:',
                        this.dataset.cmid, 'display dataset:', document.getElementById(
                            'weeklyLessonDropdownDisplayManage')?.dataset?.cmid, 'gm:', gm);
                } catch (e) {}
                populateWeeklyModalWithData(gm, joinedDays, idx, startTime, endTime);
            });

            dropdownContainer.appendChild(item);
            if (!firstProcessed) {
                setTimeout(() => item.click(), 50);
                firstProcessed = true;
            }
        });

        if (dropdownContainer.innerHTML === '') {
            dropdownContainer.innerHTML =
                `<div class="weekly-single-lesson-item"><div style="text-align:center;">No weekly lessons found</div></div>`;
        }
    } else {
        dropdownContainer.innerHTML =
            `<div class="weekly-single-lesson-item"><div style="text-align:center;">No activities found</div></div>`;
    }
}

// Helper for converting short day names
function fullDayName(short) {
    const map = {
        Sun: 'Sunday',
        Mon: 'Monday',
        Tue: 'Tuesday',
        Wed: 'Wednesday',
        Thu: 'Thursday',
        Fri: 'Friday',
        Sat: 'Saturday'
    };
    return map[short] || short;
}

function calculateDateForDay(dayText, baseDate) {
    /**
     * Calculates the actual date for a given weekday based on a base date.
     * @param {string} dayText - Day abbreviation (e.g., 'Mon', 'Tue', 'Wed')
     * @param {string|Date} baseDate - Reference date (YYYY-MM-DD format or Date object)
     * @returns {string} - Date in YYYY-MM-DD format, or null if calculation fails
     */
    const dayMap = {
        'Sun': 0,
        'Mon': 1,
        'Tue': 2,
        'Wed': 3,
        'Thu': 4,
        'Fri': 5,
        'Sat': 6
    };

    if (!dayText || !baseDate) return null;

    // Parse base date
    let baseDateObj;
    if (typeof baseDate === 'string') {
        // Assume YYYY-MM-DD format
        baseDateObj = new Date(baseDate + 'T00:00:00Z');
    } else if (baseDate instanceof Date) {
        baseDateObj = new Date(baseDate);
    } else {
        return null;
    }

    if (isNaN(baseDateObj.getTime())) return null;

    // Get target day of week
    const targetDayNum = dayMap[dayText];
    if (targetDayNum === undefined) return null;

    // Get current day of week of base date
    const currentDayNum = baseDateObj.getUTCDay();

    // Calculate days to add
    let daysToAdd = targetDayNum - currentDayNum;
    if (daysToAdd <= 0) daysToAdd += 7;

    // Create new date
    const resultDate = new Date(baseDateObj);
    resultDate.setUTCDate(resultDate.getUTCDate() + daysToAdd);

    // Format as YYYY-MM-DD using formatDateUTC() from date_utils.js
    return window.formatDateUTC(resultDate);
}

// parseUnixTimestamp() is now in js/date_utils.js
// Using: parseUnixTimestamp() from date_utils.js

function populateWeeklyModalWithData(googleMeet, selectedDay, activityIndex, startTime, endTime) {
    console.log(`Populating modal for activity ${activityIndex}, day: ${selectedDay}, time: ${startTime} - ${endTime}`);

    // Store original googlemeet data for later comparison
    window.originalGoogleMeetData = {
        id: googleMeet.id,
        days: googleMeet.days || '{}',
        starthour: googleMeet.starthour,
        startminute: googleMeet.startminute,
        endhour: googleMeet.endhour,
        endminute: googleMeet.endminute,
        period: googleMeet.period || 1,
        eventdate: googleMeet.eventdate,
        eventenddate: googleMeet.eventenddate
    };

    // ---- Get "Ends" section elements ----
    const endNeverRadio = document.getElementById('weeklyLessonEndNeverManage');
    const endOnRadio = document.getElementById('weeklyLessonEndOnManage');
    const endAfterRadio = document.getElementById('weeklyLessonEndAfterManage');
    const endDateBtn = document.getElementById('weeklyLessonEndDateBtnManage');

    // ---- Get timestamps ----
    const startDateStr = googleMeet.eventdate;
    const endDateStr = googleMeet.eventenddate;

    // ---- Get the clicked event date to determine which day to select ----
    const clickedEventDate = window.currentEventData?.date || null;

    // ---- Populate Start Date with clicked event date if available ----
    const startDateEl = document.getElementById('weeklyLessonStartDateTextManage');
    if (startDateEl) {
        if (clickedEventDate) {
            // Use clicked event date instead of start date from googleMeet
            // Parse date in UTC to avoid timezone issues
            const dateObj = new Date(clickedEventDate + 'T00:00:00Z');
            // Convert to local date for display (but keep UTC for calculations)
            const localDateObj = new Date(dateObj.getUTCFullYear(), dateObj.getUTCMonth(), dateObj.getUTCDate(), 0, 0,
                0);
            startDateEl.textContent = window.formatDate(localDateObj);
            startDateEl.dataset.fullDate = clickedEventDate;
            window.weeklyLessonStartDate = dateObj; // Store UTC date for consistency
            console.log('Set start date to clicked event date:', clickedEventDate, '→ formatted:', window.formatDate(
                localDateObj), '→ UTC date:', dateObj);
        } else if (startDateStr) {
            // Fallback to start date from googleMeet if no clicked event date
            const startDate = window.parseUnixTimestamp(startDateStr);
            startDateEl.textContent = window.formatDate(startDate);
            // store deterministic ISO date for later parsing
            try {
                startDateEl.dataset.fullDate = startDate.toISOString().split('T')[0];
            } catch (e) {}
            window.weeklyLessonStartDate = startDate;
        }
    }

    // ---- Handle End Date + Radio selection ----
    // Reset radios to avoid leftover state
    [endNeverRadio, endOnRadio, endAfterRadio].forEach(r => {
        if (r) r.checked = false;
    });

    if (endDateStr && endDateStr !== "no" && endDateStr !== "0") {
        const endDate = window.parseUnixTimestamp(endDateStr);
        if (endDateBtn) {
            endDateBtn.textContent = window.formatDate(endDate);
            // Store the date in dataset to avoid timezone issues
            try {
                endDateBtn.dataset.fullDate = window.ymd(endDate);
            } catch (e) {}
            window.weeklyLessonEndDate = endDate;
        }
        if (endOnRadio) endOnRadio.checked = true;

        // ✅ FIX: also update global calendar state
        if (typeof window.setWeeklyCalendarEndDate === 'function') {
            window.setWeeklyCalendarEndDate(endDate);
        }
    } else {
        // ✅ No end date → check "Never"
        if (endNeverRadio) endNeverRadio.checked = true;
    }

    // ---- Parse and apply repeat-day pattern ----
    const daysPattern = JSON.parse(googleMeet.days || '{}');
    const widgetRow = document.getElementById('weeklyLessonWidgetsRowManage');
    if (widgetRow) {
        const dayMap = {
            Sun: 0,
            Mon: 1,
            Tue: 2,
            Wed: 3,
            Thu: 4,
            Fri: 5,
            Sat: 6
        };

        // Clear all widgets
        widgetRow.querySelectorAll('.weekly_lesson_scroll_widget_manage').forEach(widget => {
            const key = parseInt(widget.dataset.key, 10);
            widget.classList.remove('selected');
            widget.setAttribute('aria-pressed', 'false');

            const timeEl = widget.querySelector('.weekly_lesson_widget_time_manage');
            if (timeEl) timeEl.remove();

            const btn = widget.querySelector('.weekly_lesson_widget_button_manage');
            if (btn) {
                btn.classList.remove('has-time');
                const dot = btn.querySelector('.weekly_lesson_dot');
                if (dot) dot.remove();
            }

            if (window.weeklyLessonDayTimes) delete window.weeklyLessonDayTimes[key];
        });

        // Determine which day to select based on clicked event
        let clickedDayOfWeek = null;

        if (clickedEventDate) {
            // Parse the date in UTC to avoid timezone issues
            // Ensure date string is in YYYY-MM-DD format
            let dateStr = clickedEventDate;
            if (dateStr.includes('T')) {
                dateStr = dateStr.split('T')[0];
            }
            const dateObj = new Date(dateStr + 'T00:00:00Z');
            clickedDayOfWeek = dateObj.getUTCDay();

            // Debug logging
            console.log('🔍 Day calculation:', {
                clickedEventDate: clickedEventDate,
                cleanedDate: dateStr,
                utcDate: dateObj.toISOString(),
                utcDayOfWeek: clickedDayOfWeek,
                dayName: ['Sun', 'Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat'][clickedDayOfWeek]
            });
        }

        // Apply active days - select all days from the pattern
        // Always populate all days from the pattern, regardless of which day was clicked
        Object.keys(daysPattern).forEach(day => {
            if (daysPattern[day] === "1" && dayMap[day] !== undefined) {
                const dayKey = dayMap[day];
                const widget = widgetRow.querySelector(
                    `.weekly_lesson_scroll_widget_manage[data-key="${dayKey}"]`
                );
                if (widget) {
                    widget.classList.add('selected');
                    widget.setAttribute('aria-pressed', 'true');

                    const start24h = convert12hTo24h(startTime);
                    const end24h = convert12hTo24h(endTime);

                    if (!window.weeklyLessonDayTimes) window.weeklyLessonDayTimes = {};

                    // If this is the clicked day, store its date
                    const dayData = {
                        start: start24h,
                        end: end24h,
                        activityIndex
                    };

                    if (clickedDayOfWeek !== null && dayKey === clickedDayOfWeek && clickedEventDate) {
                        dayData.date = clickedEventDate;
                    }

                    window.weeklyLessonDayTimes[dayKey] = dayData;

                    renderWidgetTimeManage(dayKey, start24h, end24h);
                    console.log('✅ Selected day:', dayKey, '(', day, ')', clickedDayOfWeek !== null &&
                        dayKey === clickedDayOfWeek ? 'with date: ' + clickedEventDate : '');
                }
            }
        });
    }
}



function updateDateTimeFields(date, startTime, endTime, durationMinutes) {
    // Update date field
    const dateElement = document.getElementById('selectedDateTextManage');
    if (dateElement) {
        const formattedDate = date.toLocaleDateString('en-US', {
            weekday: 'short',
            month: 'short',
            day: 'numeric'
        });
        dateElement.textContent = formattedDate;
        try {
            // Format date manually to avoid timezone issues
            dateElement.dataset.fullDate = window.ymd(date);
        } catch (e) {}
    }

    // Update time input
    const timeInput = document.querySelector('#manageclassTabContent .custom-time-pill .time-input');
    if (timeInput) {
        timeInput.value = startTime.toLowerCase();
    }

    // Update duration dropdown with minutes
    const durationDisplay = document.getElementById('durationDropdownDisplayManage');
    if (durationDisplay && durationMinutes) {
        const displayText = formatMinutesToDisplay(durationMinutes);
        durationDisplay.textContent = `${displayText} (Standard time)`;
        durationDisplay.dataset.minutes = durationMinutes;

        // Update selected option in dropdown
        const durationList = document.getElementById('durationDropdownListManage');
        if (durationList) {
            durationList.querySelectorAll('.one2one-duration-option').forEach(opt => {
                opt.classList.remove('selected');
                if (parseInt(opt.dataset.minutes) === durationMinutes) {
                    opt.classList.add('selected');
                }
            });
        }
    }
}


// ====== INITIALIZATION ======
document.addEventListener('DOMContentLoaded', function() {
    const $ = (sel, root = document) => root.querySelector(sel);
    const $$ = (sel, root = document) => Array.from(root.querySelectorAll(sel));

    // Initialize dropdown manager
    DropdownManager.init();

    // Add after DropdownManager.init();
    const durationDropdownList = document.getElementById('durationDropdownListManage');
    if (durationDropdownList) {
        durationDropdownList.addEventListener('click', (event) => {
            const option = event.target.closest('.one2one-duration-option');
            if (!option) return;

            // Remove previous selection
            durationDropdownList.querySelectorAll('.one2one-duration-option').forEach(opt =>
                opt.classList.remove('selected')
            );

            // Select clicked option
            option.classList.add('selected');

            // Update display
            const minutes = parseInt(option.dataset.minutes);
            const displayText = formatMinutesToDisplay(minutes);
            const displayEl = document.getElementById('durationDropdownDisplayManage');
            if (displayEl) {
                displayEl.textContent = `${displayText} (Standard time)`;
                displayEl.dataset.minutes = minutes; // Store minutes in data attribute
            }
        });
    }

    /* =========================
       ELEMENT REFERENCES
    ========================== */
    const teacherTrigger = $('#calendar_admin_details_create_cohort_manage_class_tab_trigger');
    const teacherMenu = $('#calendar_admin_details_create_cohort_manage_class_tab_menu');
    const teacherList = $('#calendar_admin_details_create_cohort_manage_class_tab_list');
    const teacherImg = $('#calendar_admin_details_create_cohort_manage_class_tab_current_img');
    const teacherLabel = $('#calendar_admin_details_create_cohort_manage_class_tab_current_label');
    const studentDropdownWrap = $('#one2oneStudentDropdownManage');
    const addStudentBtn = $('#one2oneAddStudentBtnManage');
    const studentDropdownWrapper = $('#studentDropdownWrapper');
    const manageForm = $('#manageOneToOneForm');
    const scheduleBtn = $('.calendar_admin_details_create_cohort_schedule_btn_manage');
    const lessonTypeBtns = $$('.one2one-lesson-type-btn-manage');
    const loaderOverlay = $('#loaderOverlay');
    // global holder for selected cmid (from gm.id) for the currently chosen activity
    window.selectedCmidManage = null;
    // global holder for all events flag (false = this event, true = all following events)
    window.allEvents = false;
    // flag to skip the scope modal once the user already chose a scope
    window.weeklyReadyToSubmit = false;
    // track which scope the user picked (default to this event)
    window.weeklyUpdateScope = 'this';
    // global holder for reschedule reason and message
    window.rescheduleReason = null;
    window.rescheduleMessage = null;
    // flag to skip the reschedule modal once the user already chose a reason
    window.singleReadyToSubmit = false;
    // flag indicating we are waiting for scope selection after reschedule (single lessons)
    window.pendingSingleScopeAfterReschedule = false;
    const singleSection = $('#custom-single-lesson-manage');
    const weeklySection = $('#custom-weekly-lesson-manage');

    // When the Update button is submitted, build a minimal payload and log the cmid (if any)
    if (manageForm && scheduleBtn) {
        scheduleBtn.setAttribute('type', 'submit');
        manageForm.addEventListener('submit', (event) => {
            event.preventDefault();
            // Validate before submission
            const teacherId = teacherTrigger?.dataset.userid;
            const selectedStudent = $('.one2one-student-list-item.selected', studentDropdownWrap);
            const studentId = selectedStudent?.dataset.userid;

            if (!teacherId) {
                showToastManage('❌ Please select a teacher first.');
                return;
            }

            if (!studentId) {
                showToastManage('❌ Please select a student first.');
                return;
            }

            const lessonType = document.querySelector('.one2one-lesson-type-btn-manage.selected')
                ?.dataset.type;

            if (!lessonType) {
                showToastManage('❌ Please select a lesson type.');
                return;
            }
            let selectedElement = null;
            if (lessonType === 'single') {
                selectedElement = document.querySelector(
                    '.single-lesson-dropdown-card .single-lesson-dropdown-item.selected');
            } else {
                selectedElement = document.querySelector(
                    '.weekly-single-lesson-container .weekly-single-lesson-item.selected');
            }

            // For weekly lessons, show the modal first before submitting
            if (lessonType === 'weekly') {
                // Only show the scope modal the first time; afterwards submit directly
                // Also check if we're already waiting for modal input to prevent double-showing
                if (!window.weeklyReadyToSubmit && !window.pendingWeeklySubmission) {
                    // Store the data for later submission
                    window.pendingWeeklySubmission = {
                        teacherId,
                        studentId,
                        lessonType,
                        selectedElement
                    };

                    // Show the update scope modal
                    $('#manageUpdateScopeModalBackdrop').classList.add('active');
                    return;
                }
                // If weeklyReadyToSubmit is true, continue to submission (don't show modal again)
            }

            // For single lessons, check if reschedule values are already stored
            if (lessonType === 'single') {
                // Only show the reschedule modal the first time; afterwards submit directly
                if (!window.singleReadyToSubmit) {
                    // Show the reschedule modal for first time
                    window.pendingSingleSubmission = {
                        teacherId,
                        studentId,
                        lessonType,
                        selectedElement
                    };

                    // Populate modal with event data
                    const originalEventData = window.currentEventData || null;
                    if (originalEventData) {
                        // Set avatar
                        const avatar = $('#rescheduleLessonAvatar');
                        if (avatar && originalEventData.avatar) {
                            avatar.src = originalEventData.avatar;
                        }

                        // Set date
                        const dateEl = $('#rescheduleLessonDate');
                        if (dateEl && originalEventData.date) {
                            const date = new Date(originalEventData.date);
                            const options = {
                                weekday: 'long',
                                month: 'short',
                                day: '2-digit'
                            };
                            dateEl.textContent = date.toLocaleDateString('en-US', options);
                        }

                        // Set time
                        const timeEl = $('#rescheduleLessonTime');
                        if (timeEl && originalEventData.start && originalEventData.end) {
                            timeEl.textContent =
                                `${originalEventData.start} - ${originalEventData.end}`;
                        }

                        // Set student name
                        const studentEl = $('#rescheduleLessonStudent');
                        if (studentEl && originalEventData.studentnames) {
                            studentEl.textContent = originalEventData.studentnames.join(', ');
                        }
                    }

                    // Show the reschedule modal
                    $('#rescheduleLessonModalBackdrop').classList.add('active');
                    return;
                }

                // Reset the flag so future clicks reopen the reschedule modal if needed
                window.singleReadyToSubmit = false;
            }
        });
    }

    /* =======================================================
       HELPER: FETCH CLASSES BASED ON LESSON TYPE
    ======================================================== */
    function fetchClassesForLessonType() {
        const teacherId = teacherTrigger?.dataset.userid;
        const selectedStudent = $('.one2one-student-list-item.selected', studentDropdownWrap);
        const studentId = selectedStudent ? selectedStudent.dataset.userid : null;
        const lessonType = $('.one2one-lesson-type-btn-manage.selected')?.dataset.type || 'single';

        if (!teacherId || !studentId) {
            console.warn('Cannot fetch classes: Teacher or student not selected');
            validateForm();
            return;
        }

        // Show loader
        if (loaderOverlay) loaderOverlay.classList.add('active');

        const url =
            `ajax/ajax_one2one_getclasses.php?teacherid=${teacherId}&studentid=${studentId}&classtype=${lessonType}`;
        console.log(`Fetching ${lessonType} lessons:`, url);

        fetch(url, {
                credentials: "same-origin"
            })
            .then(response => response.json())
            .then(data => {
                console.log(`${lessonType} lessons API Response:`, data);
                if (lessonType === 'single') {
                    populateSingleLessonDropdown(data);
                } else {
                    populateWeeklyLessonDropdown(data);
                }
                // Hide loader after data loaded
                if (loaderOverlay) loaderOverlay.classList.remove('active');
                validateForm();
            })
            .catch(error => {
                console.error(`Error fetching ${lessonType} lessons:`, error);
                // Hide loader on error
                if (loaderOverlay) loaderOverlay.classList.remove('active');
                validateForm();
            });
    }

    /* =======================================================
       1) TEACHER DROPDOWN + STUDENT LOADING
    ======================================================== */
    window.loadStudentsForTeacher = loadStudentsForTeacher;

    (function ensureDefaultTeacherDataset() {
        if (!teacherTrigger || !teacherList || !teacherLabel) return;
        if (teacherTrigger.dataset.userid) return;

        const currentName = (teacherLabel.textContent || '').trim();
        const match = $$('.calendar_admin_details_create_cohort_manage_class_tab_item[role="option"]',
                teacherList)
            .find(item => (item.dataset.name || '').trim() === currentName);
        const source = match || teacherList.querySelector(
            '.calendar_admin_details_create_cohort_manage_class_tab_item[role="option"]');

        if (!source) {
            console.warn('No teacher source element found');
            return;
        }

        const userId = source.dataset?.userid || '';
        const name = source.dataset?.name || currentName;
        const imageUrl = source.dataset?.img || (teacherImg ? teacherImg.src : '');

        if (!userId && !name) {
            console.warn('No valid teacher data found');
            return;
        }

        $$('.calendar_admin_details_create_cohort_manage_class_tab_item[aria-selected="true"]', teacherList)
            .forEach(element => element.removeAttribute('aria-selected'));
        source.setAttribute('aria-selected', 'true');

        teacherTrigger.dataset.userid = userId;
        teacherTrigger.dataset.name = name;
        teacherTrigger.dataset.img = imageUrl;

        if (teacherImg && imageUrl) {
            teacherImg.src = imageUrl;
            teacherImg.alt = name;
        }
        if (teacherLabel && name) {
            teacherLabel.textContent = name;
        }

        if (userId) {
            loadStudentsForTeacher(userId);
        } else {
            console.warn('No teacher ID available to load students');
            validateForm();
        }
    })();

    if (teacherList) {
        teacherList.addEventListener('click', (event) => {
            const item = event.target.closest(
                '.calendar_admin_details_create_cohort_manage_class_tab_item[role="option"]');
            if (!item) return;

            $$('.calendar_admin_details_create_cohort_manage_class_tab_item[aria-selected="true"]',
                    teacherList)
                .forEach(element => element.removeAttribute('aria-selected'));
            item.setAttribute('aria-selected', 'true');

            const name = item.dataset.name;
            const imageUrl = item.dataset.img;
            const userId = item.dataset.userid;

            if (teacherImg && imageUrl) {
                teacherImg.src = imageUrl;
                teacherImg.alt = name || 'Selected teacher';
            }
            if (teacherLabel && name) {
                teacherLabel.textContent = name;
            }
            if (teacherTrigger) {
                teacherTrigger.dataset.userid = userId || '';
                teacherTrigger.dataset.name = name || '';
                teacherTrigger.dataset.img = imageUrl || '';
            }

            if (userId) {
                loadStudentsForTeacher(userId);
            } else {
                // Disable student dropdown if no teacher
                if (studentDropdownWrapper) {
                    studentDropdownWrapper.classList.add('disabled');
                    if (addStudentBtn) {
                        addStudentBtn.classList.add('disabled');
                        addStudentBtn.innerHTML =
                            `<span style="color:#aaa;">Select a teacher first</span>`;
                    }
                }
            }
            if (teacherMenu) teacherMenu.style.display = 'none';

            // Fetch classes after teacher change
            fetchClassesForLessonType();
            validateForm();
        });
    }

    /* =========================================
       2) STUDENT SELECTION + AUTO-FETCH CLASSES
    ========================================== */
    if (studentDropdownWrap) {
        studentDropdownWrap.addEventListener('click', (event) => {
            const item = event.target.closest('.one2one-student-list-item:not([aria-disabled])');
            if (!item) return;

            // Remove previous selection
            $$('.one2one-student-list-item', studentDropdownWrap).forEach(el => el.classList.remove(
                'selected'));
            item.classList.add('selected');

            // Update the "Add student" button
            if (addStudentBtn) {
                const avatar = item.querySelector('.one2one-student-list-avatar')?.innerHTML || '';
                const name = item.dataset.name || item.querySelector('.one2one-student-list-name')
                    ?.textContent || 'Student';
                addStudentBtn.innerHTML = `
                    <span class="one2one-add-student-icon">${avatar}</span>
                    <span style="font-weight:600; color:#232323;">${name}</span>
                `;
                addStudentBtn.classList.add('active');
            }

            // Close dropdown
            if (studentDropdownWrap) {
                studentDropdownWrap.style.display = 'none';
            }

            // **FETCH CLASSES WHEN STUDENT SELECTED**
            fetchClassesForLessonType();
            validateForm();
        });
    }

    /* =========================================
       3) SEARCH FILTERS (TEACHER + STUDENT)
    ========================================== */
    document.addEventListener('input', function(event) {
        if (event.target.id === 'teacherSearchInputManage') {
            const filter = event.target.value.toLowerCase();
            $$('.calendar_admin_details_create_cohort_manage_class_tab_item', teacherList)
                .forEach(item => {
                    const name = (item.dataset.name || '').toLowerCase();
                    item.style.display = name.includes(filter) ? '' : 'none';
                });
        }

        if (event.target.id === 'studentSearchInputManage') {
            const filter = event.target.value.toLowerCase();
            $$('.one2one-student-list-item', studentDropdownWrap)
                .forEach(item => {
                    const name = (item.dataset.name || '').toLowerCase();
                    item.style.display = name.includes(filter) ? '' : 'none';
                });
        }
    });

    /* =========================================
       4) LESSON TYPE TOGGLE + AUTO-FETCH
    ========================================== */
    /* =========================================
       4) LESSON TYPE TOGGLE + AUTO-FETCH - FIXED RADIO BUTTONS
    ========================================== */
    lessonTypeBtns.forEach(btn => {
        btn.addEventListener('click', () => {
            // Remove selected class from all buttons
            lessonTypeBtns.forEach(button => button.classList.remove('selected'));

            // Add selected class to clicked button
            btn.classList.add('selected');

            // **FIX: Check the radio button inside the clicked button**
            const radioInput = btn.querySelector('input[type="radio"]');
            if (radioInput) {
                radioInput.checked = true;
            }

            const lessonType = btn.dataset.type;
            if (lessonType === 'single') {
                singleSection.style.display = 'block';
                weeklySection.style.display = 'none';
            } else {
                singleSection.style.display = 'none';
                weeklySection.style.display = 'block';
            }

            // Fetch classes when lesson type changes
            fetchClassesForLessonType();
            validateForm();
        });
    });

    /* =========================================
       5) WEEKLY WIDGET/TIMEPICKER
    ========================================== */
    (function initWeeklyWidgets() {
        const widgetRow = $('#weeklyLessonWidgetsRowManage');
        if (!widgetRow) return;

        let weeklyLessonInterval = 1;
        let weeklyLessonOccurrences = 13;
        window.weeklyLessonCurrentDayKey = null;
        window.weeklyLessonDayTimes = {};

        const dayShort = ['S', 'M', 'T', 'W', 'T', 'F', 'S'];

        for (let i = 0; i < 7; i++) {
            const div = document.createElement('div');
            div.className = 'weekly_lesson_scroll_widget_manage';
            div.dataset.key = i;
            div.innerHTML = `
                <span class="weekly_lesson_widget_text_manage">${dayShort[i]}</span>
                <div class="weekly_lesson_widget_divider_manage"></div>
                <button class="weekly_lesson_widget_button_manage" data-arrow-manage="1">
                    <div class="weekly_lesson_widget_arrow_manage"></div>
                </button>
            `;
            widgetRow.appendChild(div);
        }

        const intervalDisplay = $('#weeklyLessonIntervalDisplayManage');
        $('#weeklyLessonIntervalPlusManage')?.addEventListener('click', () => {
            weeklyLessonInterval++;
            if (intervalDisplay) intervalDisplay.textContent = weeklyLessonInterval;
        });
        $('#weeklyLessonIntervalMinusManage')?.addEventListener('click', () => {
            if (weeklyLessonInterval > 1) weeklyLessonInterval--;
            if (intervalDisplay) intervalDisplay.textContent = weeklyLessonInterval;
        });

        document.addEventListener('click', (event) => {
            const arrowBtn = event.target.closest('[data-arrow-manage]');
            const pickerBackdrop = $('#weeklyLessonTimepickerBackdropManage');

            if (arrowBtn && pickerBackdrop) {
                const wrap = arrowBtn.closest('.weekly_lesson_scroll_widget_manage');
                window.weeklyLessonCurrentDayKey = parseInt(wrap.dataset.key, 10);

                const current = window.weeklyLessonDayTimes[window.weeklyLessonCurrentDayKey] || {
                    start: '09:00',
                    end: '10:00'
                };

                const start12h = convert24hTo12h(current.start);
                const end12h = convert24hTo12h(current.end);

                $('#weekly_lesson_timepicker_start_manage').value = start12h;
                $('#weekly_lesson_timepicker_end_manage').value = end12h;
                // Ensure pbd is always a single element
                let pbd = pickerBackdrop?. [0] ?? pickerBackdrop;
                pbd.style.display = 'block';


                return;
            }

            const widget = event.target.closest('.weekly_lesson_scroll_widget_manage');
            if (widget && !event.target.closest('[data-arrow-manage]')) {
                const key = parseInt(widget.dataset.key, 10);
                const selected = widget.classList.toggle('selected');
                widget.setAttribute('aria-pressed', selected ? 'true' : 'false');

                if (!selected) {
                    delete window.weeklyLessonDayTimes[key];
                    const timeElement = widget.querySelector('.weekly_lesson_widget_time_manage');
                    if (timeElement) timeElement.remove();

                    const button = widget.querySelector('.weekly_lesson_widget_button_manage');
                    if (button) {
                        button.classList.remove('has-time');
                        const dot = button.querySelector('.weekly_lesson_dot');
                        if (dot) dot.remove();
                    }
                } else {
                    const button = widget.querySelector('.weekly_lesson_widget_button_manage');
                    if (button) {
                        button.classList.remove('has-time');
                    }

                    // When a day is selected, calculate and store its date
                    const dayMap = {
                        Sun: 0,
                        Mon: 1,
                        Tue: 2,
                        Wed: 3,
                        Thu: 4,
                        Fri: 5,
                        Sat: 6
                    };
                    const dayName = Object.keys(dayMap).find(k => dayMap[k] === key);

                    if (dayName) {
                        // Get the date to use as base - prefer clicked event date, then start date
                        const currentEventData = window.currentEventData || null;
                        const clickedEventDate = currentEventData?.date || null;
                        let clickedDayOfWeek = null;
                        if (clickedEventDate) {
                            // Ensure date string is in YYYY-MM-DD format
                            let dateStr = clickedEventDate;
                            if (dateStr.includes('T')) {
                                dateStr = dateStr.split('T')[0];
                            }
                            const dateObj = new Date(dateStr + 'T00:00:00Z');
                            clickedDayOfWeek = dateObj.getUTCDay();
                        }
                        const startDateEl = document.getElementById(
                            'weeklyLessonStartDateTextManage');
                        const startDate = startDateEl?.dataset?.fullDate || null;

                        // Calculate date for this day
                        let dayDate = null;
                        if (clickedEventDate) {
                            if (key === clickedDayOfWeek) {
                                // This is the clicked day - use clicked event date directly
                                dayDate = clickedEventDate;
                                console.log('Selected clicked day - using clicked event date:',
                                    dayDate);
                            } else {
                                // This is a different day - calculate from clicked event date
                                dayDate = calculateDateForDay(dayName, clickedEventDate);
                                console.log(
                                    'Selected different day - calculated date from clicked event:',
                                    clickedEventDate, '→', dayDate);
                            }
                        } else if (startDate) {
                            // Fallback to start date
                            dayDate = calculateDateForDay(dayName, startDate);
                            console.log('Calculated date from start date:', startDate, '→',
                                dayDate);
                        }

                        if (dayDate) {
                            // Initialize or update the day times entry
                            if (!window.weeklyLessonDayTimes) window.weeklyLessonDayTimes = {};
                            if (!window.weeklyLessonDayTimes[key]) {
                                window.weeklyLessonDayTimes[key] = {
                                    start: '09:00',
                                    end: '10:00'
                                };
                            }
                            window.weeklyLessonDayTimes[key].date = dayDate;
                            console.log('Stored date for day', dayName, '(', key, '):', dayDate);
                        }
                    }
                }
            }
        });

        $('#weeklyLessonTimepickerCancelBtnManage')?.addEventListener('click', () => {
            $('#weeklyLessonTimepickerBackdropManage').style.display = 'none';
        });

        $('#weeklyLessonTimepickerDoneBtnManage')?.addEventListener('click', () => {
            if (window.weeklyLessonCurrentDayKey == null) return;

            const start12h = $('#weekly_lesson_timepicker_start_manage').value || '09:00 AM';
            const end12h = $('#weekly_lesson_timepicker_end_manage').value || '10:00 AM';
            const start24h = convert12hTo24h(start12h);
            let end24h = convert12hTo24h(end12h);

            if (end24h <= start24h) {
                const [hour, minute] = start24h.split(':').map(Number);
                const hour2 = (hour + 1) % 24;
                end24h = `${String(hour2).padStart(2, '0')}:${String(minute).padStart(2, '0')}`;
            }

            // Store the time change temporarily
            window.pendingWeeklyTimeChange = {
                dayKey: window.weeklyLessonCurrentDayKey,
                start: start24h,
                end: end24h
            };

            // Close time picker
            $('#weeklyLessonTimepickerBackdropManage').style.display = 'none';

            // Show update scope modal
            $('#manageUpdateScopeModalBackdrop').classList.add('active');
        });
    })();

    /* =========================================
       UPDATE SCOPE MODAL HANDLERS
    ========================================== */
    (function initUpdateScopeModal() {
        const modalBackdrop = $('#manageUpdateScopeModalBackdrop');
        const cancelBtn = $('#manageUpdateScopeCancelBtn');
        const okBtn = $('#manageUpdateScopeOkBtn');
        const thisEventRadio = $('#updateScopeThisEvent');
        const followingRadio = $('#updateScopeFollowing');

        if (!modalBackdrop) return;

        // Cancel button - close modal without saving (with form reset)
        // Check for unsaved changes before closing
        if (window.getOne2OneStateManager) {
            const stateManager = window.getOne2OneStateManager('one2oneForm');
            if (stateManager && stateManager.hasUnsavedChanges()) {
                if (!confirm('You have unsaved changes. Are you sure you want to cancel?')) {
                    return; // Don't close if user cancels
                }
            }
        }
        // Reset form on cancel
        if (typeof resetOne2OneForm === 'function') {
            resetOne2OneForm({
                formPrefix: 'manage',
                clearState: false, // Keep state in case user reopens
                onComplete: () => {
                    console.log('Form reset on cancel');
                }
            });
        }
        cancelBtn?.addEventListener('click', () => {
            modalBackdrop.classList.remove('active');
            window.pendingWeeklyTimeChange = null;
            window.pendingWeeklySubmission = null;
            window.weeklyReadyToSubmit = false;
            window.weeklyUpdateScope = 'this';
            window.allEvents = false;
        });

        // Ok button - save the selection and apply the time change or submission
        okBtn?.addEventListener('click', () => {
            // Get selected scope as boolean
            if (thisEventRadio?.checked) {
                window.allEvents = false; // This event only
                window.weeklyUpdateScope = 'this';
            } else if (followingRadio?.checked) {
                window.allEvents = true; // All following events
                window.weeklyUpdateScope = 'all';
            }

            // Apply the pending time change
            if (window.pendingWeeklyTimeChange) {
                const {
                    dayKey,
                    start,
                    end
                } = window.pendingWeeklyTimeChange;
                window.weeklyLessonDayTimes[dayKey] = {
                    start,
                    end
                };
                renderWidgetTimeManage(dayKey, start, end);
                window.pendingWeeklyTimeChange = null;
            }

            // Handle pending submission (when Update button was clicked) for WEEKLY lessons
            // Just save the scope selection - don't submit the form
            // The form will submit when the user clicks "Update 1:1 Class" button
            if (window.pendingWeeklySubmission) {
                // Set the ready flag so the form knows scope has been selected
                // This ensures the main handler knows to proceed without showing modal again
                window.weeklyReadyToSubmit = true;

                // Clear the pending submission flag
                window.pendingWeeklySubmission = null;

                // Close modal - form submission will happen when user clicks "Update 1:1 Class" button
                modalBackdrop.classList.remove('active');
                
                console.log('✅ Scope selected:', window.weeklyUpdateScope, '- Ready to submit when Update button is clicked');

                return; // Exit early to prevent modal from closing again below
            }

            // Handle pending scope selection for SINGLE lessons (after reschedule modal)
            // Just save the scope selection - don't submit the form
            // The form will submit when the user clicks "Update 1:1 Class" button
            if (window.pendingSingleScopeAfterReschedule) {
                // Clear the flag and close the modal
                window.pendingSingleScopeAfterReschedule = false;
                modalBackdrop.classList.remove('active');
                
                console.log('✅ Scope selected for single lesson:', window.weeklyUpdateScope, '- Ready to submit when Update button is clicked');

                return;
            }

            // Close modal
            modalBackdrop.classList.remove('active');

            console.log('All events flag set to:', window.allEvents);
        });

        // Close on backdrop click
        modalBackdrop?.addEventListener('click', (e) => {
            if (e.target === modalBackdrop) {
                modalBackdrop.classList.remove('active');
                window.pendingWeeklyTimeChange = null;
                window.pendingWeeklySubmission = null;
                window.weeklyReadyToSubmit = false;
                window.weeklyUpdateScope = 'this';
                window.allEvents = false;
                window.pendingSingleScopeAfterReschedule = false;
            }
        });
    })();

    /* =========================================
       RESCHEDULE LESSON MODAL HANDLERS
    ========================================== */
    (function initRescheduleLessonModal() {
        const modalBackdrop = $('#rescheduleLessonModalBackdrop');
        const closeBtn = $('#rescheduleLessonCloseBtn');
        const backBtn = $('#rescheduleLessonBackBtn');
        const reasonBtn = $('#rescheduleReasonBtn');
        const reasonList = $('#rescheduleReasonList');
        const reasonDisplay = $('#rescheduleReasonDisplay');
        const messageTextarea = $('#rescheduleMessage');
        const confirmBtn = $('#rescheduleConfirmBtn');

        if (!modalBackdrop) return;

        // Toggle dropdown
        reasonBtn?.addEventListener('click', () => {
            reasonList.classList.toggle('active');
            reasonBtn.classList.toggle('active');
        });

        // Select reason
        reasonList?.addEventListener('click', (e) => {
            const item = e.target.closest('.reschedule-lesson-dropdown-item');
            if (!item) return;

            const value = item.dataset.value;
            const text = item.textContent;

            window.rescheduleReason = value;
            reasonDisplay.textContent = text;
            reasonList.classList.remove('active');
            reasonBtn.classList.remove('active');

            // Enable confirm button if reason is selected
            if (confirmBtn) {
                confirmBtn.disabled = false;
            }
        });

        // Store message
        messageTextarea?.addEventListener('input', () => {
            window.rescheduleMessage = messageTextarea.value;
        });

        // Close handlers
        const closeModal = () => {
            modalBackdrop.classList.remove('active');
            window.pendingSingleSubmission = null;
            window.rescheduleReason = null;
            window.rescheduleMessage = null;
            window.singleReadyToSubmit = false;
            if (reasonDisplay) reasonDisplay.textContent = 'Select Reason';
            if (messageTextarea) messageTextarea.value = '';
            if (confirmBtn) confirmBtn.disabled = true;
        };

        closeBtn?.addEventListener('click', closeModal);
        backBtn?.addEventListener('click', closeModal);

        // Close on backdrop click
        modalBackdrop?.addEventListener('click', (e) => {
            if (e.target === modalBackdrop) {
                closeModal();
            }
        });

        // Confirm button - store values, close modal, and then ask for scope
        confirmBtn?.addEventListener('click', () => {
            if (!window.rescheduleReason) {
                showToastManage('❌ Please select a reschedule reason.');
                return;
            }

            // Store the reschedule reason and message (already stored via input handlers above)
            // Close the reschedule modal
            modalBackdrop.classList.remove('active');
            window.pendingSingleSubmission = null;

            // Values are now stored in window.rescheduleReason and window.rescheduleMessage
            console.log('✅ Reschedule data stored:', {
                reason: window.rescheduleReason,
                message: window.rescheduleMessage
            });

            // Set the flag to allow direct submission after scope selection
            window.singleReadyToSubmit = true;
            window.pendingSingleScopeAfterReschedule = true;

            // Show the update scope modal (This event / This and all following)
            const scopeModal = document.getElementById('manageUpdateScopeModalBackdrop');
            if (scopeModal) {
                scopeModal.classList.add('active');
            }
        });
    })();

    /* =========================================
       6) WEEKLY START/END CALENDAR - FIXED DATE ONLY
    ========================================== */
    (function initWeeklyCalendar() {
        const backdrop = $('#weeklyLessonStartDateCalendarBackdropManage');
        if (!backdrop) return;

        let calendarTarget = 'start';
        // ✅ FIX: Use existing date from window.weeklyLessonStartDate if available (when updating)
        let weeklyLessonStartDate = window.weeklyLessonStartDate ? new Date(window.weeklyLessonStartDate) :
            new Date();
        // **FIX: Set to start of day (no time)**
        weeklyLessonStartDate.setHours(0, 0, 0, 0);

        let weeklyLessonEndsOnDate = new Date();
        // 👇 Add this:
        window.setWeeklyCalendarEndDate = function(date) {
            weeklyLessonEndsOnDate = new Date(date);
        };
        weeklyLessonEndsOnDate.setMonth(weeklyLessonEndsOnDate.getMonth() + 1);
        weeklyLessonEndsOnDate.setHours(0, 0, 0, 0);

        let viewMonth = weeklyLessonStartDate.getMonth();
        let viewYear = weeklyLessonStartDate.getFullYear();
        let selectedDate = new Date(weeklyLessonStartDate);

        const startDateText = $('#weeklyLessonStartDateTextManage');
        const endDateBtn = $('#weeklyLessonEndDateBtnManage');

        if (startDateText) {
            startDateText.textContent = window.formatDate(weeklyLessonStartDate);
            try {
                startDateText.dataset.fullDate = window.ymd(weeklyLessonStartDate);
            } catch (e) {}
        }
        if (endDateBtn) {
            endDateBtn.disabled = false;
            endDateBtn.textContent = window.formatDate(weeklyLessonEndsOnDate);
            try {
                endDateBtn.dataset.fullDate = window.ymd(weeklyLessonEndsOnDate);
            } catch (e) {}
        }

        $('#weeklyLessonStartDateBtnManage')?.addEventListener('click', () => {
            calendarTarget = 'start';

            // Parse current date from button if available
            if (startDateText && startDateText.dataset.fullDate) {
                const dateStr = startDateText.dataset.fullDate;
                const parts = dateStr.split('-');
                if (parts.length === 3) {
                    const year = parseInt(parts[0]);
                    const month = parseInt(parts[1]) - 1;
                    const day = parseInt(parts[2]);
                    selectedDate = new Date(year, month, day, 0, 0, 0);
                    weeklyLessonStartDate = new Date(selectedDate);
                } else {
                    selectedDate = new Date(weeklyLessonStartDate);
                    selectedDate.setHours(0, 0, 0, 0);
                }
            } else {
                selectedDate = new Date(weeklyLessonStartDate);
                selectedDate.setHours(0, 0, 0, 0);
            }

            viewMonth = selectedDate.getMonth();
            viewYear = selectedDate.getFullYear();
            renderCalendar();
            backdrop.style.display = 'block';
        });

        $('#weeklyLessonEndDateBtnManage')?.addEventListener('click', function() {
            if (this.disabled) return;
            calendarTarget = 'ends';

            // Parse current date from button if available
            if (endDateBtn && endDateBtn.dataset.fullDate) {
                const dateStr = endDateBtn.dataset.fullDate;
                const parts = dateStr.split('-');
                if (parts.length === 3) {
                    const year = parseInt(parts[0]);
                    const month = parseInt(parts[1]) - 1;
                    const day = parseInt(parts[2]);
                    selectedDate = new Date(year, month, day, 0, 0, 0);
                    weeklyLessonEndsOnDate = new Date(selectedDate);
                } else {
                    selectedDate = new Date(weeklyLessonEndsOnDate);
                    selectedDate.setHours(0, 0, 0, 0);
                }
            } else {
                selectedDate = new Date(weeklyLessonEndsOnDate);
                selectedDate.setHours(0, 0, 0, 0);
            }

            viewMonth = selectedDate.getMonth();
            viewYear = selectedDate.getFullYear();
            renderCalendar();
            backdrop.style.display = 'block';
        });

        $('#weeklyLessonCalendarPrevManage')?.addEventListener('click', () => {
            if (viewMonth === 0) {
                viewMonth = 11;
                viewYear--;
            } else {
                viewMonth--;
            }
            renderCalendar();
        });

        $('#weeklyLessonCalendarNextManage')?.addEventListener('click', () => {
            if (viewMonth === 11) {
                viewMonth = 0;
                viewYear++;
            } else {
                viewMonth++;
            }
            renderCalendar();
        });

        $('#weeklyLessonCalendarDoneManage')?.addEventListener('click', () => {
            // **FIX: Set to start of day before saving**
            selectedDate.setHours(0, 0, 0, 0);

            if (calendarTarget === 'start') {
                weeklyLessonStartDate = new Date(selectedDate);
                if (startDateText) {
                    startDateText.textContent = window.formatDate(weeklyLessonStartDate);
                    try {
                        startDateText.dataset.fullDate = window.ymd(weeklyLessonStartDate);
                    } catch (e) {}
                }
            } else {
                weeklyLessonEndsOnDate = new Date(selectedDate);
                if (endDateBtn) {
                    endDateBtn.textContent = window.formatDate(weeklyLessonEndsOnDate);
                    try {
                        endDateBtn.dataset.fullDate = window.ymd(weeklyLessonEndsOnDate);
                    } catch (e) {}
                }
            }
            backdrop.style.display = 'none';
        });

        backdrop.addEventListener('click', (event) => {
            if (event.target === backdrop) backdrop.style.display = 'none';
        });

        function renderCalendar() {
            const monthLabel = $('#weeklyLessonCalendarMonthManage');
            const daysRow = $('#weeklyLessonCalendarDaysManage');
            const datesRow = $('#weeklyLessonCalendarDatesManage');

            const monthNames = ["January", "February", "March", "April", "May", "June",
                "July", "August", "September", "October", "November", "December"
            ];

            if (monthLabel) {
                monthLabel.textContent = `${monthNames[viewMonth]} ${viewYear}`;
            }

            if (daysRow) {
                daysRow.innerHTML = '';
                ["Mo", "Tu", "We", "Th", "Fr", "Sa", "Su"].forEach(day => {
                    const div = document.createElement('div');
                    div.className = 'monthly_cal_day';
                    div.textContent = day;
                    daysRow.appendChild(div);
                });
            }

            if (datesRow) {
                datesRow.innerHTML = '';
                const firstDay = new Date(viewYear, viewMonth, 1).getDay();
                const offset = (firstDay + 6) % 7;
                const daysInMonth = new Date(viewYear, viewMonth + 1, 0).getDate();

                for (let i = 0; i < offset; i++) {
                    const d = document.createElement('div');
                    d.className = 'monthly_cal_date inactive';
                    datesRow.appendChild(d);
                }

                for (let day = 1; day <= daysInMonth; day++) {
                    const dateDiv = document.createElement('div');
                    dateDiv.className = 'monthly_cal_date';
                    dateDiv.dataset.date = day;
                    dateDiv.textContent = day;

                    // **FIX: Compare dates without time**
                    const isSelected = day === selectedDate.getDate() &&
                        viewMonth === selectedDate.getMonth() &&
                        viewYear === selectedDate.getFullYear();

                    if (isSelected) dateDiv.classList.add('selected');

                    dateDiv.addEventListener('click', () => {
                        selectedDate.setFullYear(viewYear);
                        selectedDate.setMonth(viewMonth);
                        selectedDate.setDate(day);
                        selectedDate.setHours(0, 0, 0, 0); // **FIX: Clear time**
                        renderCalendar();
                    });

                    datesRow.appendChild(dateDiv);
                }
            }
        }

        window.getWeeklyLessonStartDate = () => weeklyLessonStartDate;
        window.getWeeklyLessonEndsOnDate = () => weeklyLessonEndsOnDate;

        renderCalendar();
    })();

    /* =========================================
       7) TIME PICKER DROPDOWNS FOR WEEKLY
    ========================================== */
    (function initWeeklyTimePickers() {
        const startInput = $('#weekly_lesson_timepicker_start_manage');
        const endInput = $('#weekly_lesson_timepicker_end_manage');
        if (!startInput || !endInput) return;

        function generateTimeOptions() {
            const times = [];
            for (let h = 0; h < 24; h++) {
                for (let m = 0; m < 60; m += 30) {
                    times.push(formatTime12HourFromParts(h, m));
                }
            }
            return times;
        }

        const timeOptions = generateTimeOptions();

        function createTimeDropdown(input) {
            const wrapper = document.createElement('div');
            wrapper.style.position = 'relative';
            wrapper.style.width = '100%';

            const dropdown = document.createElement('div');
            dropdown.className = 'time-dropdown';
            dropdown.style.cssText = `
                position: absolute;
                top: 100%;
                left: 0;
                right: 0;
                background: white;
                border: 1px solid #dadada;
                border-radius: 8px;
                max-height: 200px;
                overflow-y: auto;
                display: none;
                z-index: 1000;
                margin-top: 4px;
                box-shadow: 0 4px 12px rgba(0,0,0,0.15);
            `;

            timeOptions.forEach(time => {
                const option = document.createElement('div');
                option.textContent = time;
                option.style.cssText = `
                    padding: 10px 16px;
                    cursor: pointer;
                    font-size: 14px;
                    transition: background 0.15s;
                `;
                option.addEventListener('mouseenter', () => {
                    option.style.background = '#f6f6f6';
                    option.style.color = '#fe2e0c';
                });
                option.addEventListener('mouseleave', () => {
                    option.style.background = '';
                    option.style.color = '';
                });
                option.addEventListener('click', () => {
                    input.value = time;
                    dropdown.style.display = 'none';
                });
                dropdown.appendChild(option);
            });

            input.parentNode.insertBefore(wrapper, input);
            wrapper.appendChild(input);
            wrapper.appendChild(dropdown);

            input.readOnly = true;
            input.style.cursor = 'pointer';

            input.addEventListener('click', (e) => {
                e.stopPropagation();
                dropdown.style.display = dropdown.style.display === 'none' ? 'block' : 'none';

                const selectedOption = Array.from(dropdown.children).find(
                    opt => opt.textContent === input.value
                );
                if (selectedOption) {
                    selectedOption.scrollIntoView({
                        block: 'nearest'
                    });
                }
            });

            document.addEventListener('click', (e) => {
                if (!wrapper.contains(e.target)) {
                    dropdown.style.display = 'none';
                }
            });
        }

        createTimeDropdown(startInput);
        createTimeDropdown(endInput);
    })();

    /* =========================================
       7B) SINGLE LESSON DATE CALENDAR MODAL
    ========================================== */
    (function initSingleLessonCalendar() {
        const customDateDisplay = $('#customDateDropdownDisplayManage');
        const calendarBackdrop = $('#calendarModalBackdropManage');
        const calendarPrevBtn = $('#calendarPrevMonthManage');
        const calendarNextBtn = $('#calendarNextMonthManage');
        const calendarDoneBtn = $('#calendarDoneBtnManage');
        const calendarMonthYear = $('#calendarMonthYearManage');
        const calendarDaysGrid = $('#calendarDaysGridManage');

        if (!customDateDisplay || !calendarBackdrop) return;

        let currentDate = new Date();
        let viewYear = currentDate.getFullYear();
        let viewMonth = currentDate.getMonth();
        let selectedDate = new Date(currentDate);

        // Parse current date from button text if exists
        function parseCurrentDate() {
            const dateText = $('#selectedDateTextManage');
            if (dateText && dateText.dataset.fullDate) {
                try {
                    // Parse date string manually to avoid timezone issues
                    const dateStr = dateText.dataset.fullDate;
                    const parts = dateStr.split('-');
                    if (parts.length === 3) {
                        const year = parseInt(parts[0]);
                        const month = parseInt(parts[1]) - 1; // Month is 0-indexed
                        const day = parseInt(parts[2]);
                        selectedDate = new Date(year, month, day, 12, 0, 0);
                        viewYear = year;
                        viewMonth = month;
                    }
                } catch (e) {
                    console.warn('Could not parse date:', e);
                }
            }
        }

        // Open calendar when clicking date display
        customDateDisplay.addEventListener('click', () => {
            parseCurrentDate(); // Parse the current date before opening
            renderSingleCalendar();
            calendarBackdrop.style.display = 'flex';
        });

        // Previous month
        if (calendarPrevBtn) {
            calendarPrevBtn.addEventListener('click', () => {
                viewMonth--;
                if (viewMonth < 0) {
                    viewMonth = 11;
                    viewYear--;
                }
                renderSingleCalendar();
            });
        }

        // Next month
        if (calendarNextBtn) {
            calendarNextBtn.addEventListener('click', () => {
                viewMonth++;
                if (viewMonth > 11) {
                    viewMonth = 0;
                    viewYear++;
                }
                renderSingleCalendar();
            });
        }

        // Done button
        if (calendarDoneBtn) {
            calendarDoneBtn.addEventListener('click', () => {
                const dateText = $('#selectedDateTextManage');
                if (dateText) {
                    const formatted = selectedDate.toLocaleDateString('en-US', {
                        weekday: 'short',
                        month: 'short',
                        day: 'numeric'
                    });
                    dateText.textContent = formatted;

                    // Store full date using ymd() from date_utils.js
                    dateText.dataset.fullDate = window.ymd(selectedDate);
                }
                calendarBackdrop.style.display = 'none';
            });
        }

        // Close on backdrop click
        calendarBackdrop.addEventListener('click', (e) => {
            if (e.target === calendarBackdrop) {
                calendarBackdrop.style.display = 'none';
            }
        });

        function renderSingleCalendar() {
            const monthNames = ["January", "February", "March", "April", "May", "June",
                "July", "August", "September", "October", "November", "December"
            ];

            if (calendarMonthYear) {
                calendarMonthYear.textContent = `${monthNames[viewMonth]} ${viewYear}`;
            }

            if (calendarDaysGrid) {
                calendarDaysGrid.innerHTML = '';

                const firstDay = new Date(viewYear, viewMonth, 1).getDay();
                const offset = firstDay === 0 ? 6 : firstDay - 1; // Monday first
                const daysInMonth = new Date(viewYear, viewMonth + 1, 0).getDate();

                // Add empty cells for offset
                for (let i = 0; i < offset; i++) {
                    const emptyDiv = document.createElement('div');
                    emptyDiv.className = 'calendar-modal-day inactive';
                    calendarDaysGrid.appendChild(emptyDiv);
                }

                // Add day cells
                for (let day = 1; day <= daysInMonth; day++) {
                    const dayDiv = document.createElement('div');
                    dayDiv.className = 'calendar-modal-day';
                    dayDiv.textContent = day;

                    // Check if this day is selected
                    const isSelected = day === selectedDate.getDate() &&
                        viewMonth === selectedDate.getMonth() &&
                        viewYear === selectedDate.getFullYear();

                    if (isSelected) {
                        dayDiv.classList.add('selected');
                    }

                    dayDiv.addEventListener('click', () => {
                        selectedDate = new Date(viewYear, viewMonth, day, 12, 0, 0);
                        renderSingleCalendar();
                    });

                    calendarDaysGrid.appendChild(dayDiv);
                }
            }
        }

        renderSingleCalendar();
    })();


    // Add this in your DOMContentLoaded section

    /* =========================================
       9) DETECT MANUAL DATE/TIME CHANGES
    ========================================== */

    // Listen for date changes
    const customDateDisplay = document.getElementById('customDateDropdownDisplayManage');
    if (customDateDisplay) {
        // Create a MutationObserver to watch for text changes
        const dateObserver = new MutationObserver((mutations) => {
            mutations.forEach((mutation) => {
                if (mutation.type === 'childList' || mutation.type === 'characterData') {
                    console.log('Date manually changed to:', customDateDisplay.textContent);
                    // Update the data attribute
                    const selectedDateText = document.getElementById('selectedDateTextManage');
                    if (selectedDateText) {
                        console.log('Updated date data:', selectedDateText.dataset.fullDate);
                    }
                }
            });
        });

        dateObserver.observe(customDateDisplay, {
            childList: true,
            characterData: true,
            subtree: true
        });
    }

    // Listen for time changes
    const timeInput = document.querySelector('#manageclassTabContent .custom-time-pill .time-input');
    if (timeInput) {
        timeInput.addEventListener('change', () => {
            console.log('Time manually changed to:', timeInput.value);
        });

        timeInput.addEventListener('input', () => {
            console.log('Time input changed to:', timeInput.value);
        });
    }

    // Listen for duration changes (already handled, but verify)
    const durationOptions = document.querySelectorAll('.one2one-duration-option');
    durationOptions.forEach(option => {
        option.addEventListener('click', () => {
            const minutes = parseInt(option.dataset.minutes);
            console.log('Duration manually changed to:', minutes, 'minutes');
        });
    });

    /* =========================================
       8) MAIN SCHEDULE BUTTON
    ========================================== */

    scheduleBtn?.addEventListener('click', async () => {
        // Determine current lesson type
        const currentLessonType = document.querySelector('.one2one-lesson-type-btn-manage.selected')
            ?.dataset.type || 'single';

        // For weekly lessons, always require scope selection BEFORE submitting
        if (currentLessonType === 'weekly' && !window.weeklyReadyToSubmit) {
            console.log('⏸️ Waiting for scope selection for weekly lesson, skipping direct submission');
            return;
        }

        // For single lessons, always require reschedule + scope selection BEFORE submitting
        if (currentLessonType === 'single' && !window.singleReadyToSubmit) {
            console.log('⏸️ Waiting for reschedule/scope selection for single lesson, skipping direct submission');
            return;
        }

        // Check if we're waiting for modal input (reschedule or update scope)
        if (window.pendingSingleSubmission || window.pendingWeeklySubmission) {
            console.log('⏸️ Waiting for modal input, skipping direct submission');
            return;
        }

        const teacher = {
            id: teacherTrigger?.dataset.userid || null,
            name: teacherLabel?.textContent.trim() || 'Unknown Teacher',
            imageUrl: teacherImg?.src || ''
        };

        const selectedStudent = $('.one2one-student-list-item.selected', studentDropdownWrap);
        const student = {
            id: selectedStudent ? selectedStudent.dataset.userid : null,
            name: selectedStudent ? selectedStudent.dataset.name : 'No student selected'
        };

        const lessonType = $('.one2one-lesson-type-btn-manage.selected')?.dataset.type || 'single';

        let cmid = null;
        if (lessonType === 'single') {
            const selectedSingleEl = document.querySelector(
                '.single-lesson-dropdown-card .single-lesson-dropdown-item.selected');
            const displayEl = document.getElementById('singleLessonDropdownDisplayManage');
            cmid = window.selectedCmidManage ?? selectedSingleEl?.dataset?.cmid ?? displayEl
                ?.dataset?.cmid ?? null;
        } else {
            const selectedWeeklyEl = document.querySelector(
                '.weekly-single-lesson-container .weekly-single-lesson-item.selected');
            const displayEl = document.getElementById('weeklyLessonDropdownDisplayManage');
            cmid = window.selectedCmidManage ?? selectedWeeklyEl?.dataset?.cmid ?? displayEl
                ?.dataset?.cmid ?? null;
        }

        // Get the original event data from global variable
        const originalEventData = window.currentEventData || null;

        // Extract event ID from multiple possible sources
        let eventId = null;
        if (originalEventData && originalEventData.eventid) {
            eventId = originalEventData.eventid;
        } else if (originalEventData && originalEventData.id) {
            eventId = originalEventData.id;
        } else if (window.eventId) {
            eventId = window.eventId;
        } else {
            // Try to get from URL parameters
            const urlParams = new URLSearchParams(window.location.search);
            eventId = urlParams.get('eventid') || urlParams.get('id') || null;
        }

        console.log('🔍 Event ID Detection:', {
            fromEventid: originalEventData?.eventid || 'not found',
            fromId: originalEventData?.id || 'not found',
            fromWindowEventId: window.eventId || 'not found',
            fromURL: eventId,
            finalEventId: eventId
        });

        const formData = {
            teacher,
            student,
            teacherId: teacher.id || null,
            studentId: student.id || null,
            lessonType,
            cmid: cmid,
            timestamp: new Date().toISOString(),
            // Add event ID
            eventId: eventId,
            // Add current data (original/old data)
            currentData: originalEventData ? {
                eventId: eventId,
                title: originalEventData.title,
                teacherId: originalEventData.teacherId,
                studentids: originalEventData.studentids,
                cohortids: originalEventData.cohortids,
                start: originalEventData.start,
                end: originalEventData.end,
                date: originalEventData.date,
                classType: originalEventData.classType,
                duration: originalEventData.duration
            } : null,
            // Add new data will be populated below after getting all form values
            newData: {},
            updateScope: window.weeklyUpdateScope || 'this',
            allEvents: window.allEvents || false,
            rescheduleReason: window.rescheduleReason || '',
            rescheduleMessage: window.rescheduleMessage || '',
            // Add change teacher info if checkbox is checked
            changeTeacher: window.isChangeTeacherChecked ? window.isChangeTeacherChecked() :
                false,
            newTeacherId: window.isChangeTeacherChecked && window.isChangeTeacherChecked() ?
                (window.getSelectedNewTeacher ? window.getSelectedNewTeacher() : null) : null
        };

        console.log(
            `Event ID: ${formData.eventId ?? 'N/A'} | Teacher ID: ${formData.teacherId ?? 'N/A'} | Student ID: ${formData.studentId ?? 'N/A'} | CMID: ${cmid ?? 'N/A'}`,
            formData.changeTeacher ?
            ` | Change Teacher: YES | New Teacher ID: ${formData.newTeacherId ?? 'N/A'}` : '',
            '\nCurrent Data:', formData.currentData
        );

        if (lessonType === 'single') {
            // ✅ FIX: Always read CURRENT values from DOM
            const durationMinutes = getSelectedDurationInMinutes();
            const durationDisplay = formatMinutesToDisplay(durationMinutes);

            // ✅ Read the ACTUAL current date from the display element
            const dateEl = document.getElementById('selectedDateTextManage');
            const currentDateText = dateEl?.textContent.trim() || '';

            // ✅ Parse the display text to get the actual date
            let date = dateEl?.dataset?.fullDate || '';

            // If dataset.fullDate is not set, parse from text
            if (!date && currentDateText) {
                // Parse format like "Tue, Feb 11" or "Tue, Feb11"
                const parts = currentDateText.replace(',', '').split(' ').filter(p => p);
                if (parts.length >= 3) {
                    const monthStr = parts[1].replace(/\d+/g, ''); // Remove any digits from month
                    const dayMatch = currentDateText.match(/\d+/); // Find first number
                    const day = dayMatch ? parseInt(dayMatch[0]) : 1;
                    const year = new Date().getFullYear(); // Use current year

                    const monthMap = {
                        'Jan': 0,
                        'Feb': 1,
                        'Mar': 2,
                        'Apr': 3,
                        'May': 4,
                        'Jun': 5,
                        'Jul': 6,
                        'Aug': 7,
                        'Sep': 8,
                        'Oct': 9,
                        'Nov': 10,
                        'Dec': 11
                    };

                    const month = monthMap[monthStr];
                    if (month !== undefined) {
                        // ✅ FIX: Create date at noon to avoid timezone issues
                        const dateObj = new Date(year, month, day, 12, 0, 0);
                        // Format as YYYY-MM-DD without timezone conversion
                        date = window.ymd(dateObj);
                    }
                }
            }

            // ✅ Read the ACTUAL current time from the input
            const timeInput = document.querySelector(
                '#manageclassTabContent .custom-time-pill .time-input');
            const time = timeInput?.value.trim() || '';

            formData.singleLesson = {
                duration: durationMinutes,
                durationDisplay: durationDisplay,
                date,
                time,
                cmid: cmid,
                fullDateTime: `${date} at ${time}`
            };

            console.log('✅ CURRENT Single Lesson Data:');
            console.log(`  - Date Display Text: ${currentDateText}`);
            console.log(`  - Parsed Date: ${date}`);
            console.log(`  - Duration: ${durationMinutes} minutes (${durationDisplay})`);
            console.log(`  - Time: ${time}`);
            console.log(`  - CMID: ${cmid}`);
        } else {
            // ✅ FIX: Read CURRENT values for weekly lesson
            const intervalEl = document.getElementById('weeklyLessonIntervalDisplayManage');
            const interval = intervalEl?.textContent.trim() || '1';

            const periodEl = document.getElementById('weeklyLessonPeriodDisplayManage');
            const period = periodEl?.textContent.trim() || 'Week';

            const startEl = document.getElementById('weeklyLessonStartDateTextManage');
            const startDateText = startEl?.textContent.trim() || '';
            const startDate = startEl?.dataset?.fullDate || startDateText;

            const endRadio = document.querySelector(
                'input[name="weeklyLessonEndOptionManage"]:checked');
            const endOption = endRadio?.id || 'weeklyLessonEndNeverManage';
            const endOptionLabel = endRadio?.nextElementSibling?.textContent || 'Never';

            const endsOnEl = document.getElementById('weeklyLessonEndDateBtnManage');
            const endsOn = endsOnEl?.dataset?.fullDate || endsOnEl?.textContent.trim() || 'Never';

            const occurrencesEl = document.getElementById('weeklyLessonOccurrenceDisplayManage');
            const occurrences = occurrencesEl?.textContent.trim() || '';

            // ✅ Read CURRENT selected days and times
            const selectedDays = [];
            const dayWidgets = document.querySelectorAll(
                '.weekly_lesson_scroll_widget_manage.selected');

            const baseDate = originalEventData?.date || null;
            const clickedEventDate = originalEventData?.date || null;
            const isAllEvents = window.allEvents || false;

            // Map single-letter day abbreviations to 3-letter day names
            const dayThreeLetterMap = {
                'M': 'Mon',
                'T': 'Tue',
                'W': 'Wed',
                'Th': 'Thu',
                'F': 'Fri',
                'Sa': 'Sat',
                'Su': 'Sun'
            };

            // If updating only this event (not all events), we need to determine which specific day to update
            let clickedDayOfWeek = null;
            let dayToUpdateForThisEvent = null;

            if (clickedEventDate && !isAllEvents) {
                // Ensure date string is in YYYY-MM-DD format
                let dateStr = clickedEventDate;
                if (dateStr.includes('T')) {
                    dateStr = dateStr.split('T')[0];
                }
                const dateObj = new Date(dateStr + 'T00:00:00Z');
                clickedDayOfWeek = dateObj.getUTCDay();
                console.log('Updating only this event - clicked day:', clickedDayOfWeek,
                    '(', ['Sun', 'Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat'][clickedDayOfWeek],
                    ')',
                    'date:', clickedEventDate, '→ cleaned:', dateStr);

                // Determine which day to update:
                // 1. If user has selected days, use the first selected day
                // 2. If no days selected, use the clicked day (we'll add it back below)
                if (dayWidgets.length > 0) {
                    // User has selected days - use the first selected day
                    dayToUpdateForThisEvent = parseInt(dayWidgets[0].dataset.key, 10);
                    console.log('User selected day(s) - will update only day:',
                        dayToUpdateForThisEvent);
                } else {
                    // No days selected - will use clicked day
                    dayToUpdateForThisEvent = clickedDayOfWeek;
                    console.log('No days selected - will use clicked day:',
                        dayToUpdateForThisEvent);
                }
            }

            dayWidgets.forEach(widget => {
                const dayKey = parseInt(widget.dataset.key, 10);
                let dayText = widget.querySelector('.weekly_lesson_widget_text_manage')
                    ?.textContent || '';

                // Expand single-letter days to 3-letter abbreviations
                if (dayText.length <= 2) {
                    dayText = dayThreeLetterMap[dayText] || dayText;
                }

                // If updating only this event, only include the day to update (first selected day or clicked day)
                if (!isAllEvents && dayToUpdateForThisEvent !== null && dayKey !==
                    dayToUpdateForThisEvent) {
                    console.log('Skipping day', dayText, 'because we are updating only day',
                        dayToUpdateForThisEvent);
                    return; // Skip this day
                }

                const startTime = widget.querySelector(
                    '.weekly_lesson_widget_hour_minute_manage.start')?.textContent || '';
                const endTime = widget.querySelector(
                    '.weekly_lesson_widget_hour_minute_manage.end')?.textContent || '';
                const startPeriod = widget.querySelector(
                        '.weekly_lesson_widget_period_manage.start-period')?.textContent ||
                    '';
                const endPeriod = widget.querySelector(
                    '.weekly_lesson_widget_period_manage.end-period')?.textContent || '';

                if (startTime && endTime) {
                    // Calculate date for this day
                    let dayDate = null;

                    // Get stored date from weeklyLessonDayTimes if available
                    if (window.weeklyLessonDayTimes && window.weeklyLessonDayTimes[
                            dayKey] && window.weeklyLessonDayTimes[dayKey].date) {
                        dayDate = window.weeklyLessonDayTimes[dayKey].date;
                        console.log('Using stored date for day', dayText, ':', dayDate);
                    } else if (isAllEvents) {
                        // For all events, calculate from start date
                        if (startDate) {
                            dayDate = calculateDateForDay(dayText, startDate);
                        }
                    } else {
                        // For this event only, calculate date based on the selected day
                        // If this is the clicked day, use clicked event date directly
                        // If this is a different day, calculate the date for that day from the clicked event date
                        if (clickedEventDate) {
                            if (dayKey === clickedDayOfWeek) {
                                // Same day as clicked - use clicked event date
                                dayDate = clickedEventDate;
                                console.log('Using clicked event date for clicked day:',
                                    dayDate);
                            } else {
                                // Different day - calculate date for this day from clicked event date
                                dayDate = calculateDateForDay(dayText, clickedEventDate);
                                console.log('Calculated date for changed day', dayText,
                                    'from clicked date:', clickedEventDate, '→', dayDate
                                );
                            }
                        } else if (baseDate) {
                            dayDate = calculateDateForDay(dayText, baseDate);
                        }
                    }

                    selectedDays.push({
                        day: dayText,
                        date: dayDate,
                        start: `${startTime} ${startPeriod}`,
                        end: `${endTime} ${endPeriod}`
                    });
                }
            });

            // If updating "this event only" and no days were selected, add the clicked day back with default times
            if (!isAllEvents && selectedDays.length === 0 && clickedDayOfWeek !== null &&
                clickedEventDate) {
                // Find the widget for the clicked day to get its time, or use default times
                const clickedDayWidget = document.querySelector(
                    `.weekly_lesson_scroll_widget_manage[data-key="${clickedDayOfWeek}"]`
                );

                const dayMap = {
                    Sun: 0,
                    Mon: 1,
                    Tue: 2,
                    Wed: 3,
                    Thu: 4,
                    Fri: 5,
                    Sat: 6
                };
                const dayName = Object.keys(dayMap).find(k => dayMap[k] === clickedDayOfWeek);

                if (dayName) {
                    const fullDayName = dayThreeLetterMap[dayName] || dayName;
                    let startTime = '';
                    let endTime = '';
                    let startPeriod = '';
                    let endPeriod = '';

                    if (clickedDayWidget) {
                        // Try to get times from the widget
                        startTime = clickedDayWidget.querySelector(
                            '.weekly_lesson_widget_hour_minute_manage.start')?.textContent || '';
                        endTime = clickedDayWidget.querySelector(
                            '.weekly_lesson_widget_hour_minute_manage.end')?.textContent || '';
                        startPeriod = clickedDayWidget.querySelector(
                                '.weekly_lesson_widget_period_manage.start-period')?.textContent ||
                            '';
                        endPeriod = clickedDayWidget.querySelector(
                            '.weekly_lesson_widget_period_manage.end-period')?.textContent || '';
                    }

                    // If no times found, try to get from weeklyLessonDayTimes
                    if (!startTime || !endTime) {
                        if (window.weeklyLessonDayTimes && window.weeklyLessonDayTimes[
                                clickedDayOfWeek]) {
                            const dayTimes = window.weeklyLessonDayTimes[clickedDayOfWeek];
                            const start12h = convert24hTo12h(dayTimes.start || '09:00');
                            const end12h = convert24hTo12h(dayTimes.end || '10:00');
                            const startParts = start12h.split(' ');
                            const endParts = end12h.split(' ');
                            startTime = startParts[0] || '09:00';
                            startPeriod = startParts[1] || 'AM';
                            endTime = endParts[0] || '10:00';
                            endPeriod = endParts[1] || 'AM';
                        } else {
                            // Default times
                            startTime = '09:00';
                            startPeriod = 'AM';
                            endTime = '10:00';
                            endPeriod = 'AM';
                        }
                    }

                    selectedDays.push({
                        day: fullDayName,
                        date: clickedEventDate,
                        start: `${startTime} ${startPeriod}`,
                        end: `${endTime} ${endPeriod}`
                    });
                    console.log('Added clicked day back to payload:', fullDayName, clickedEventDate,
                        startTime, endTime);
                }
            }

            // Validate that we have at least one day
            if (selectedDays.length === 0) {
                showToastManage('❌ Please select at least one day for the weekly lesson.');
                return;
            }

            console.log('Selected days for payload:', selectedDays, 'isAllEvents:', isAllEvents,
                'clickedDayOfWeek:', clickedDayOfWeek);
            // Reset change-teacher UI so previous selections do not bleed into new events
            const changeTeacherCheckbox = document.getElementById('changeTeacherCheckbox');
            if (changeTeacherCheckbox) {
                changeTeacherCheckbox.checked = false;
                changeTeacherCheckbox.dispatchEvent(new Event('change'));
            }
            formData.weeklyLesson = {
                startDate,
                interval,
                period,
                endOption,
                endOptionLabel,
                endsOn,
                occurrences,
                days: selectedDays,
                totalDays: selectedDays.length,
                cmid: cmid
            };
        }

        // Keep hidden form fields aligned with the latest selections
        syncManageHiddenInputs(formData);

        // Populate newData with only the changed/updated form values
        formData.newData = {};

        // Only add changed fields
        if (formData.changeTeacher && formData.newTeacherId) {
            formData.newData.teacherId = formData.newTeacherId;
        }

        // Add lesson type specific data
        if (formData.lessonType === 'single' && formData.singleLesson) {
            formData.newData.singleLesson = formData.singleLesson;
            // Add reschedule reason and message if present
            if (window.rescheduleReason) {
                formData.newData.rescheduleReason = window.rescheduleReason;
                formData.newData.rescheduleMessage = window.rescheduleMessage || '';
                console.log('📝 Reschedule Reason:', formData.newData.rescheduleReason);
                console.log('💬 Reschedule Message:', formData.newData.rescheduleMessage);
            }
        } else if (formData.lessonType === 'weekly' && formData.weeklyLesson) {
            formData.newData.weeklyLesson = formData.weeklyLesson;
            // Add allEvents flag for weekly lessons
            formData.newData.allEvents = window.allEvents || false;
            console.log('📌 All Events:', formData.newData.allEvents);
        }

        console.log('📤 Final Form Data:', formData);
        console.log('📋 New Data (Updated fields only):', formData.newData);

        // Build payload in the format expected by update_one_on_one.php
        // Determine scope based on update scope selection
        let scope = 'THIS_OCCURRENCE';
        if (window.weeklyUpdateScope === 'all' || window.allEvents) {
            scope = 'THIS_AND_FOLLOWING';
        } else if (window.weeklyUpdateScope === 'following') {
            scope = 'THIS_AND_FOLLOWING';
        }

        // Persist scope/allEvents selections into the hidden form inputs
        formData.scope = scope;
        syncManageHiddenInputs(formData, {
            scope,
            allEvents: window.allEvents
        });

        // Get googlemeetid (cmid)
        const googlemeetid = parseInt(cmid || formData.cmid || 0);

        // ===== USE UTILITY FUNCTIONS FOR CHANGE DETECTION =====
        // Extract normalized event data from API response structure
        const normalizedOriginalEvent = window.One2OneUpdatePayloadBuilder?.extractEventData(originalEventData) || {
            eventId: originalEventData?.eventid || originalEventData?.id || originalEventData?.eventId || null,
            googlemeetid: originalEventData?.googlemeetid || originalEventData?.googlemeetId || originalEventData?.cmid || null,
            date: originalEventData?.date || null,
            start: originalEventData?.start || null,
            end: originalEventData?.end || null,
            teacherId: originalEventData?.teacherId || formData.teacherId || null
        };

        // Detect changes using utility functions
        let timeChange = { timeChanged: false, newStartTime: null, newEndTime: null };
        let dateChange = { dateChanged: false, newDate: null };
        let teacherChanged = false;

        if (window.One2OneUpdatePayloadBuilder) {
            // Use utility functions for change detection
            if (formData.lessonType === 'single') {
                timeChange = window.One2OneUpdatePayloadBuilder.detectSingleLessonTimeChange(formData, normalizedOriginalEvent);
                dateChange = window.One2OneUpdatePayloadBuilder.detectSingleLessonDateChange(formData, normalizedOriginalEvent);
            } else if (formData.lessonType === 'weekly') {
                timeChange = window.One2OneUpdatePayloadBuilder.detectWeeklyLessonTimeChange(formData, normalizedOriginalEvent, scope);
                dateChange = window.One2OneUpdatePayloadBuilder.detectWeeklyLessonDateChange(formData, normalizedOriginalEvent, scope);
            }
            
            teacherChanged = window.One2OneUpdatePayloadBuilder.detectTeacherChange(formData, normalizedOriginalEvent);
        } else {
            // Fallback to inline logic if utility not available
            console.warn('One2OneUpdatePayloadBuilder not available, using fallback logic');
            const originalDate = normalizedOriginalEvent.date;
            const originalTeacherId = normalizedOriginalEvent.teacherId;
            const originalStart = normalizedOriginalEvent.start;
            const originalEnd = normalizedOriginalEvent.end;

            // Fallback inline detection (simplified)
            if (formData.lessonType === 'single' && formData.singleLesson) {
                const timeStr = formData.singleLesson.time || '';
                if (timeStr) {
                    const time24h = convert12hTo24h(timeStr);
                    if (time24h) {
                        const [startHour, startMin] = time24h.split(':').map(Number);
                        const duration = formData.singleLesson.duration || 60;
                        const endMin = startMin + duration;
                        const endHour = startHour + Math.floor(endMin / 60);
                        const endMinFinal = endMin % 60;
                        timeChange.newStartTime = `${String(startHour).padStart(2, '0')}:${String(startMin).padStart(2, '0')}`;
                        timeChange.newEndTime = `${String(endHour).padStart(2, '0')}:${String(endMinFinal).padStart(2, '0')}`;
                        if (originalStart && originalEnd) {
                            const origStart24h = originalStart.includes(' ') ? convert12hTo24h(originalStart) : originalStart;
                            const origEnd24h = originalEnd.includes(' ') ? convert12hTo24h(originalEnd) : originalEnd;
                            timeChange.timeChanged = (origStart24h !== timeChange.newStartTime || origEnd24h !== timeChange.newEndTime);
                        } else {
                            timeChange.timeChanged = true;
                        }
                    }
                }
                if (formData.singleLesson.date) {
                    dateChange.newDate = formData.singleLesson.date.includes('T') ? formData.singleLesson.date.split('T')[0] : formData.singleLesson.date;
                    dateChange.dateChanged = dateChange.newDate !== (originalDate?.includes('T') ? originalDate.split('T')[0] : originalDate);
                }
            }

            teacherChanged = formData.changeTeacher && formData.newTeacherId &&
                parseInt(formData.newTeacherId) !== parseInt(originalTeacherId);
        }

        // Extract values for use below
        const timeChanged = timeChange.timeChanged;
        const newStartTime = timeChange.newStartTime;
        const newEndTime = timeChange.newEndTime;
        const dateChanged = dateChange.dateChanged;
        const newDate = dateChange.newDate;
        const originalDate = normalizedOriginalEvent.date;
        const originalTeacherId = normalizedOriginalEvent.teacherId;

        console.log('👤 Teacher change detection:', {
            changeTeacher: formData.changeTeacher,
            newTeacherId: formData.newTeacherId,
            originalTeacherId,
            teacherChanged
        });

        console.log('📅 Date change detection:', {
            originalDate,
            newDate,
            dateChanged,
            lessonType: formData.lessonType
        });

        console.log('⏰ Time change detection:', {
            timeChanged,
            newStartTime,
            newEndTime,
            originalStart: normalizedOriginalEvent.start,
            originalEnd: normalizedOriginalEvent.end
        });

        // ===== SESSION STORAGE HELPERS FOR THIS_OCCURRENCE =====
        const SESSION_STORAGE_KEY = 'one2one_update_payload';
        
        /**
         * Get stored payload from sessionStorage
         */
        function getStoredPayload() {
            try {
                const stored = sessionStorage.getItem(SESSION_STORAGE_KEY);
                if (stored) {
                    return JSON.parse(stored);
                }
            } catch (e) {
                console.warn('Failed to parse stored payload:', e);
            }
            return null;
        }

        /**
         * Store payload in sessionStorage
         */
        function storePayload(payload) {
            try {
                sessionStorage.setItem(SESSION_STORAGE_KEY, JSON.stringify(payload));
                console.log('💾 Stored payload in sessionStorage:', payload);
            } catch (e) {
                console.warn('Failed to store payload:', e);
            }
        }

        /**
         * Initialize session storage with base payload when form opens
         */
        function initializeStoredPayload(eventId, googlemeetid, originalDate, originalTeacherId) {
            if (scope !== 'THIS_OCCURRENCE') {
                return; // Only use session storage for THIS_OCCURRENCE
            }

            const basePayload = {
                scope: 'THIS_OCCURRENCE',
                eventId: parseInt(eventId || 0),
                googlemeetid: parseInt(googlemeetid || 0),
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

            // Add anchorDate if we have original date
            if (originalDate) {
                let normalizedAnchorDate = originalDate;
                if (normalizedAnchorDate && normalizedAnchorDate.includes('T')) {
                    normalizedAnchorDate = normalizedAnchorDate.split('T')[0];
                }
                basePayload.anchorDate = normalizedAnchorDate;
            }

            storePayload(basePayload);
        }

        /**
         * Merge new payload with stored payload
         */
        function mergeWithStoredPayload(newPayload) {
            if (scope !== 'THIS_OCCURRENCE') {
                return newPayload; // Don't merge for THIS_AND_FOLLOWING
            }

            const stored = getStoredPayload();
            if (!stored) {
                console.log('📦 No stored payload found, using new payload only');
                return newPayload;
            }

            // Safety check: ensure we're merging payloads for the same event
            if (stored.eventId && newPayload.eventId && stored.eventId !== newPayload.eventId) {
                console.warn('⚠️ Event ID mismatch! Stored:', stored.eventId, 'New:', newPayload.eventId);
                console.warn('⚠️ Clearing stored payload and using new payload only');
                clearStoredPayload();
                return newPayload;
            }

            // Merge apply flags (OR operation - if either is true, keep true)
            const mergedApply = {
                time: newPayload.apply?.time || stored.apply?.time || false,
                teacher: newPayload.apply?.teacher || stored.apply?.teacher || false,
                status: newPayload.apply?.status || stored.apply?.status || false,
                days: newPayload.apply?.days || stored.apply?.days || false,
                period: newPayload.apply?.period || stored.apply?.period || false,
                end: newPayload.apply?.end || stored.apply?.end || false,
                date: newPayload.apply?.date || stored.apply?.date || false
            };

            // Merge payload - new values override stored values
            const merged = {
                scope: newPayload.scope || stored.scope,
                eventId: newPayload.eventId || stored.eventId,
                googlemeetid: newPayload.googlemeetid || stored.googlemeetid,
                apply: mergedApply
            };

            // Merge anchorDate (prefer new, fallback to stored)
            if (newPayload.anchorDate) {
                merged.anchorDate = newPayload.anchorDate;
            } else if (stored.anchorDate) {
                merged.anchorDate = stored.anchorDate;
            }

            // Merge time data (new overrides stored)
            // Priority: newPayload.time > newPayload.current > stored.time > stored.current
            if (newPayload.time) {
                merged.time = newPayload.time;
                // Remove current if time exists (time takes precedence when multiple changes)
                delete merged.current;
            } else if (newPayload.current) {
                // Only keep current if no other changes exist
                const hasOtherChanges = mergedApply.teacher || mergedApply.date;
                if (!hasOtherChanges) {
                    merged.current = newPayload.current;
                } else {
                    // Convert current to time if other changes exist
                    merged.time = newPayload.current;
                }
            } else if (stored.time) {
                merged.time = stored.time;
                delete merged.current;
            } else if (stored.current) {
                // Only keep current if no other changes exist
                const hasOtherChanges = mergedApply.teacher || mergedApply.date;
                if (!hasOtherChanges) {
                    merged.current = stored.current;
                } else {
                    // Convert current to time if other changes exist
                    merged.time = stored.current;
                }
            }

            // Merge teacher data (new overrides stored)
            if (newPayload.teacher) {
                merged.teacher = newPayload.teacher;
            } else if (stored.teacher) {
                merged.teacher = stored.teacher;
            }

            // Merge date data (new overrides stored)
            if (newPayload.date) {
                merged.date = newPayload.date;
            } else if (stored.date) {
                merged.date = stored.date;
            }

            console.log('🔄 Merged payload:', {
                stored: stored,
                new: newPayload,
                merged: merged
            });

            return merged;
        }

        /**
         * Clear stored payload (call after successful update or when closing form)
         */
        function clearStoredPayload() {
            try {
                sessionStorage.removeItem(SESSION_STORAGE_KEY);
                console.log('🗑️ Cleared stored payload from sessionStorage');
            } catch (e) {
                console.warn('Failed to clear stored payload:', e);
            }
        }

        // Initialize session storage when form opens (only for THIS_OCCURRENCE)
        if (scope === 'THIS_OCCURRENCE') {
            const payloadEventId = parseInt(eventId || formData.eventId || 0);
            
            // Check if this is a different event - if so, clear old stored payload
            const stored = getStoredPayload();
            if (stored && stored.eventId && stored.eventId !== payloadEventId) {
                console.log('🔄 New event detected, clearing old stored payload');
                clearStoredPayload();
            }
            
            // Initialize or re-initialize for this event
            initializeStoredPayload(payloadEventId, googlemeetid, originalDate, originalTeacherId);
        }

        // Make clearStoredPayload available globally for cleanup
        if (typeof window !== 'undefined') {
            window.clearOne2OneStoredPayload = clearStoredPayload;
        }

        // Build payload - use new format for THIS_AND_FOLLOWING, old format for THIS_OCCURRENCE
        let payload;

        if (scope === 'THIS_AND_FOLLOWING') {
            // New payload format for THIS_AND_FOLLOWING
            const anchorEventId = parseInt(eventId || formData.eventId || 0);
            const anchorEventDate = originalDate || (originalEventData?.date ? originalEventData
                .date.split('T')[0] : null);

            // Validate that we have a valid event ID
            if (!anchorEventId || anchorEventId === 0) {
                showToastManage(
                    '❌ Error: No event selected. Please click on an event in the calendar first to edit it.'
                );
                if (loaderOverlay) loaderOverlay.classList.remove('active');
                return;
            }

            if (!anchorEventDate) {
                showToastManage('❌ Error: Missing event date for THIS_AND_FOLLOWING update');
                if (loaderOverlay) loaderOverlay.classList.remove('active');
                return;
            }

            payload = {
                scope: 'THIS_AND_FOLLOWING',
                anchorEvent: {
                    eventId: anchorEventId,
                    eventDate: anchorEventDate,
                    googlemeetid: googlemeetid
                },
                changes: []
            };

            // Get original days from stored googlemeet data
            let originalDays = [];
            if (window.originalGoogleMeetData && window.originalGoogleMeetData.days) {
                try {
                    const daysObj = JSON.parse(window.originalGoogleMeetData.days || '{}');
                    originalDays = Object.keys(daysObj).filter(d => daysObj[d] === "1");
                } catch (e) {
                    console.warn('Failed to parse original days:', e);
                }
            }

            // Get selected days from form data
            let selectedDaysList = [];
            if (formData.lessonType === 'weekly' && formData.weeklyLesson && formData.weeklyLesson
                .days) {
                selectedDaysList = formData.weeklyLesson.days.map(d => d.day).filter(Boolean);
            }

            // Normalize day names to 3-letter format (Mon, Tue, etc.)
            const normalizeDay = (day) => {
                const dayMap = {
                    'Sun': 'Sun',
                    'Sunday': 'Sun',
                    'Mon': 'Mon',
                    'Monday': 'Mon',
                    'Tue': 'Tue',
                    'Tuesday': 'Tue',
                    'Wed': 'Wed',
                    'Wednesday': 'Wed',
                    'Thu': 'Thu',
                    'Thursday': 'Thu',
                    'Fri': 'Fri',
                    'Friday': 'Fri',
                    'Sat': 'Sat',
                    'Saturday': 'Sat'
                };
                return dayMap[day] || day;
            };

            originalDays = originalDays.map(normalizeDay);
            selectedDaysList = selectedDaysList.map(normalizeDay);

            // Detect new days (days in selected but not in original)
            const newDays = selectedDaysList.filter(d => !originalDays.includes(d));
            const hasNewDays = newDays.length > 0;

            // Build changes array
            // 1. Time update (if time changed)
            if (timeChanged && newStartTime && newEndTime) {
                // Get original time from stored data or event
                let originalStartTime = null;
                let originalEndTime = null;

                if (window.originalGoogleMeetData) {
                    const origSh = window.originalGoogleMeetData.starthour || 0;
                    const origSm = window.originalGoogleMeetData.startminute || 0;
                    const origEh = window.originalGoogleMeetData.endhour || 0;
                    const origEm = window.originalGoogleMeetData.endminute || 0;
                    originalStartTime =
                        `${String(origSh).padStart(2, '0')}:${String(origSm).padStart(2, '0')}`;
                    originalEndTime =
                        `${String(origEh).padStart(2, '0')}:${String(origEm).padStart(2, '0')}`;
                } else if (originalStart && originalEnd) {
                    originalStartTime = originalStart.includes(' ') ? convert12hTo24h(
                        originalStart) : originalStart;
                    originalEndTime = originalEnd.includes(' ') ? convert12hTo24h(originalEnd) :
                        originalEnd;
                }

                payload.changes.push({
                    action: 'UPDATE_EXISTING',
                    googlemeetid: googlemeetid,
                    type: 'recurring',
                    diff: {
                        time: {
                            from: {
                                start: originalStartTime || newStartTime,
                                end: originalEndTime || newEndTime
                            },
                            to: {
                                start: newStartTime,
                                end: newEndTime
                            }
                        }
                    }
                });
            }

            // 2. Teacher update (if teacher changed)
            if (teacherChanged && originalTeacherId && formData.newTeacherId) {
                payload.changes.push({
                    action: 'UPDATE_TEACHER_RECURRING',
                    googlemeetid: googlemeetid,
                    type: 'recurring',
                    diff: {
                        teacher: {
                            from: parseInt(originalTeacherId),
                            to: parseInt(formData.newTeacherId),
                            reason: 'Teacher switched'
                        }
                    }
                });
            }

            // 3. New days creation (if new days selected)
            if (hasNewDays && formData.lessonType === 'weekly' && formData.weeklyLesson) {
                // Get schedule data for new days - use time from first new day or from time change
                let newDayStart24h = newStartTime || '09:00';
                let newDayEnd24h = newEndTime || '10:00';

                // Try to get time from first new day
                const firstNewDay = formData.weeklyLesson.days.find(d => {
                    const normalizedDay = normalizeDay(d.day);
                    return newDays.includes(normalizedDay);
                });

                if (firstNewDay && firstNewDay.start && firstNewDay.end) {
                    const dayStart24h = convert12hTo24h(firstNewDay.start);
                    const dayEnd24h = convert12hTo24h(firstNewDay.end);
                    if (dayStart24h && dayEnd24h) {
                        newDayStart24h = dayStart24h;
                        newDayEnd24h = dayEnd24h;
                    }
                }

                // Get start date (use start date from form or anchor date)
                let scheduleStartDate = formData.weeklyLesson.startDate || anchorEventDate;
                if (scheduleStartDate && scheduleStartDate.includes('T')) {
                    scheduleStartDate = scheduleStartDate.split('T')[0];
                }

                // Get end rule
                let endRule = {
                    type: 'NEVER'
                };
                if (formData.weeklyLesson.endOption === 'weeklyLessonEndOnManage' && formData
                    .weeklyLesson.endsOn && formData.weeklyLesson.endsOn !== 'Never') {
                    let endDate = formData.weeklyLesson.endsOn;
                    if (endDate && endDate.includes('T')) {
                        endDate = endDate.split('T')[0];
                    }
                    if (endDate && endDate.match(/^\d{4}-\d{2}-\d{2}$/)) {
                        endRule = {
                            type: 'ON_DATE',
                            value: endDate
                        };
                    }
                }

                // Get period
                const period = formData.weeklyLesson.period || 1;

                payload.changes.push({
                    action: 'CREATE_NEW',
                    type: 'recurring',
                    schedule: {
                        start: newDayStart24h,
                        end: newDayEnd24h,
                        days: newDays,
                        period: period,
                        startDate: scheduleStartDate,
                        endRule: endRule
                    }
                });

                console.log('📅 Creating new googlemeet for new days:', newDays, 'schedule:', {
                    start: newDayStart24h,
                    end: newDayEnd24h,
                    days: newDays,
                    period: period,
                    startDate: scheduleStartDate,
                    endRule: endRule
                });
            }

            // Validate that we have at least one change
            if (payload.changes.length === 0) {
                showToastManage('❌ No changes detected');
                if (loaderOverlay) loaderOverlay.classList.remove('active');
                return;
            }

        } else {
            // THIS_OCCURRENCE payload format - use utility function if available
            const payloadEventId = parseInt(eventId || formData.eventId || 0);

            // Validate that we have a valid event ID
            if (!payloadEventId || payloadEventId === 0) {
                showToastManage(
                    '❌ Error: No event selected. Please click on an event in the calendar first to edit it.'
                    );
                if (loaderOverlay) loaderOverlay.classList.remove('active');
                return;
            }

            // Use utility function to build payload if available
            if (window.One2OneUpdatePayloadBuilder && window.One2OneUpdatePayloadBuilder.buildThisOccurrencePayload) {
                payload = window.One2OneUpdatePayloadBuilder.buildThisOccurrencePayload({
                    eventId: payloadEventId,
                    googlemeetid: googlemeetid,
                    timeChanged: timeChanged,
                    teacherChanged: teacherChanged,
                    dateChanged: dateChanged,
                    newStartTime: newStartTime,
                    newEndTime: newEndTime,
                    originalTeacherId: originalTeacherId,
                    newTeacherId: formData.newTeacherId,
                    newDate: newDate,
                    originalDate: originalDate
                });
            } else {
                // Fallback: Build payload manually
                payload = {
                    scope: 'THIS_OCCURRENCE',
                    eventId: payloadEventId,
                    googlemeetid: googlemeetid,
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

                // Determine if this is ONLY time change or time + other changes
                const isOnlyTimeChange = timeChanged && !teacherChanged && !dateChanged;

                // Add time data
                if (timeChanged && newStartTime && newEndTime) {
                    payload.apply.time = true;
                    if (isOnlyTimeChange) {
                        payload.current = { start: newStartTime, end: newEndTime };
                    } else {
                        payload.time = { start: newStartTime, end: newEndTime };
                    }
                }

                // Add teacher data
                if (teacherChanged && originalTeacherId && formData.newTeacherId) {
                    payload.apply.teacher = true;
                    payload.teacher = {
                        old: parseInt(originalTeacherId),
                        new: parseInt(formData.newTeacherId)
                    };
                }

                // Add date data
                if (dateChanged && newDate) {
                    payload.apply.date = true;
                    const normalizedNewDate = newDate.includes('T') ? newDate.split('T')[0] : newDate;
                    payload.date = { new: normalizedNewDate };
                    if (originalDate) {
                        const normalizedAnchorDate = originalDate.includes('T') ? originalDate.split('T')[0] : originalDate;
                        payload.anchorDate = normalizedAnchorDate;
                    }
                }
            }

            // Merge with stored payload for THIS_OCCURRENCE to accumulate changes
            payload = mergeWithStoredPayload(payload);
            
            // After merging, determine if we should use "current" or "time" based on final state
            const finalHasMultipleChanges = (payload.apply?.time ? 1 : 0) + 
                                          (payload.apply?.teacher ? 1 : 0) + 
                                          (payload.apply?.date ? 1 : 0) > 1;
            
            // Final cleanup: ensure correct structure based on number of changes
            if (payload.apply?.time) {
                if (finalHasMultipleChanges) {
                    // Multiple changes: use "time" object, remove "current" if exists
                    if (payload.current && !payload.time) {
                        payload.time = payload.current;
                    }
                    delete payload.current;
                } else {
                    // Only time change: use "current" object, remove "time" if exists
                    if (payload.time && !payload.current) {
                        payload.current = payload.time;
                    }
                    delete payload.time;
                }
            }
        }

        console.log('📦 Sending Payload:', payload);

        // Show loader
        if (loaderOverlay) loaderOverlay.classList.add('active');

        try {
            const response = await fetch('ajax/update_one_on_one.php', {
                method: 'POST',
                credentials: 'same-origin',
                headers: {
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify(payload)
            });

            const result = await response.json();
            console.log('Update Response:', result);

            // Check for error - API returns 'ok' field, not 'success'
            if (!result.ok) {
                // Hide loader on error
                if (loaderOverlay) loaderOverlay.classList.remove('active');
                if (window.hideGlobalLoader) window.hideGlobalLoader();

                // Handle error message - check multiple possible error fields
                const errorMessage = result.message || result.error || result.msg ||
                    'An unknown error occurred';
                showToastManage('❌ Error: ' + errorMessage);
                return;
            }

            // Show success message with details for THIS_AND_FOLLOWING
            if (scope === 'THIS_AND_FOLLOWING' && result.result && result.result.actions) {
                const actionCount = result.result.actions.length;
                const actionTypes = result.result.actions.map(a => a.action).join(', ');
                showToastManage(
                    `✅ Updated successfully! (${actionCount} action(s): ${actionTypes})`);
            } else {
                showToastManage('✅ Session updated successfully!');
            }

            // Update session storage with the merged payload after successful update
            if (scope === 'THIS_OCCURRENCE') {
                storePayload(payload);
                console.log('💾 Updated session storage with merged payload after successful update');
            }

            // Keep loader visible during calendar refresh
            // Switch from overlay loader to global loader for calendar fetch
            if (loaderOverlay) loaderOverlay.classList.remove('active');

            // Show global loader for calendar fetch
            if (window.showGlobalLoader) {
                window.showGlobalLoader();
            } else {
                // Fallback: show overlay loader if global loader not available
                if (loaderOverlay) loaderOverlay.classList.add('active');
            }

            // Refresh calendar events - wait for it to complete
            try {
                if (window.refetchCustomPluginData) {
                    // refetchCustomPluginData already shows/hides loader internally
                    await window.refetchCustomPluginData('update-one2one');
                } else if (window.fetchCalendarEvents) {
                    // fetchCalendarEvents shows loader unless skipLoaderShow is true
                    // Since we already showed loader above, we could skip, but let it manage its own loader
                    await window.fetchCalendarEvents(false); // false = don't skip loader
                }
            } catch (fetchError) {
                console.error('Error refreshing calendar:', fetchError);
                // Hide loader on error
                if (window.hideGlobalLoader) window.hideGlobalLoader();
                if (loaderOverlay) loaderOverlay.classList.remove('active');
            }
            // Note: Loader will be hidden by refetchCustomPluginData or fetchCalendarEvents in their finally blocks

            // Reset form after successful submission
            setTimeout(() => {
                resetManageClassForm();
            }, 1000);
        } catch (error) {
            console.error('Update Error:', error);
            // Hide loader
            if (loaderOverlay) loaderOverlay.classList.remove('active');
            showToastManage('❌ Something went wrong while updating the session.');
        }
    });

    /* =======================================================
       RESET FORM FUNCTION
    ======================================================== */
    function resetManageClassForm(clearState = false) {
        // Use new form reset utility if available
        if (typeof resetOne2OneForm === 'function') {
            resetOne2OneForm({
                formPrefix: 'manage',
                clearState: clearState,
                onComplete: (success) => {
                    if (success) {
                        console.log('✅ Form reset successfully using utility');
                    } else {
                        console.warn('⚠️ Form reset had issues, falling back to manual method');
                        // Fall back to manual reset
                        resetManageClassFormManual();
                    }
                }
            });
            return;
        }

        // Fallback to manual reset
        resetManageClassFormManual();
    }

    // Manual reset method (fallback)
    function resetManageClassFormManual() {
        // Reset teacher selection (keep first teacher if available)
        const firstTeacher = teacherList?.querySelector(
            '.calendar_admin_details_create_cohort_manage_class_tab_item[role="option"]');
        if (firstTeacher && teacherTrigger && teacherImg && teacherLabel) {
            const userId = firstTeacher.dataset?.userid;
            const name = firstTeacher.dataset?.name;
            const imageUrl = firstTeacher.dataset?.img;

            teacherTrigger.dataset.userid = userId || '';
            teacherTrigger.dataset.name = name || '';
            teacherTrigger.dataset.img = imageUrl || '';

            if (imageUrl) teacherImg.src = imageUrl;
            if (name) teacherLabel.textContent = name;

            $$('.calendar_admin_details_create_cohort_manage_class_tab_item[aria-selected="true"]', teacherList)
                .forEach(el => el.removeAttribute('aria-selected'));
            firstTeacher.setAttribute('aria-selected', 'true');
        }

        // Reset student dropdown
        if (addStudentBtn) {
            addStudentBtn.innerHTML = `
                <span class="one2one-add-student-icon">
                    <svg width="21" height="21" viewBox="0 0 20 20" fill="none">
                        <circle cx="10" cy="7" r="4" fill="#000" />
                        <ellipse cx="10" cy="15.3" rx="6.5" ry="3.3" fill="#000" />
                    </svg>
                </span>
                <span class="one2one-add-student-placeholder" style="color:#aaa;">Select a teacher first</span>
            `;
            addStudentBtn.classList.remove('active');
        }

        if (studentDropdownWrapper) {
            studentDropdownWrapper.classList.add('disabled');
        }

        if (studentDropdownWrap) {
            $$('.one2one-student-list-item', studentDropdownWrap).forEach(item => {
                item.classList.remove('selected');
            });
        }

        // Reset lesson type selection
        lessonTypeBtns.forEach(btn => {
            btn.classList.remove('selected');
            const radio = btn.querySelector('input[type="radio"]');
            if (radio) radio.checked = false;
        });

        // Show single section by default to prevent button from moving to top
        if (singleSection) singleSection.style.display = 'block';
        if (weeklySection) weeklySection.style.display = 'none';

        // Reset single lesson dropdown
        const singleDropdownDisplay = $('#singleLessonDropdownDisplayManage');
        if (singleDropdownDisplay) {
            singleDropdownDisplay.textContent = 'Single Lessons';
        }

        const singleDropdownCard = $('.single-lesson-dropdown-card');
        if (singleDropdownCard) {
            singleDropdownCard.innerHTML = '';
        }

        // Reset duration dropdown
        const durationDisplay = $('#durationDropdownDisplayManage');
        if (durationDisplay) {
            durationDisplay.textContent = '50 Minutes (Standard time)';
            durationDisplay.dataset.minutes = '50';
        }

        $$('.one2one-duration-option').forEach(opt => opt.classList.remove('selected'));
        const defaultDuration = $('.one2one-duration-option[data-minutes="50"]');
        if (defaultDuration) defaultDuration.classList.add('selected');

        // Reset date display
        const dateText = $('#selectedDateTextManage');
        if (dateText) {
            dateText.textContent = 'Tue, Feb11';
            delete dateText.dataset.fullDate;
        }

        // Reset time input
        const timeInput = $('#manageclassTabContent .custom-time-pill .time-input');
        if (timeInput) {
            timeInput.value = '10:30 am';
        }

        // Reset weekly lesson dropdown
        const weeklyDropdownDisplay = $('#weeklyLessonDropdownDisplayManage');
        if (weeklyDropdownDisplay) {
            weeklyDropdownDisplay.textContent = 'Weekly Lessons';
        }

        const weeklyDropdownContainer = $('.weekly-single-lesson-container');
        if (weeklyDropdownContainer) {
            weeklyDropdownContainer.innerHTML = '';
        }

        // Reset weekly widgets
        const weeklyWidgets = $$('.weekly_lesson_scroll_widget_manage');
        weeklyWidgets.forEach(widget => {
            widget.classList.remove('selected');
            const timeElement = widget.querySelector('.weekly_lesson_widget_time_manage');
            if (timeElement) timeElement.remove();
            const button = widget.querySelector('.weekly_lesson_widget_button_manage');
            if (button) {
                button.classList.remove('has-time');
                const dot = button.querySelector('.weekly_lesson_dot');
                if (dot) dot.remove();
            }
        });

        // Reset weekly modal values
        const intervalDisplay = $('#weeklyLessonIntervalDisplayManage');
        if (intervalDisplay) intervalDisplay.textContent = '1';

        const periodDisplay = $('#weeklyLessonPeriodDisplayManage');
        if (periodDisplay) periodDisplay.textContent = 'Week';

        const startDateText = $('#weeklyLessonStartDateTextManage');
        if (startDateText) {
            startDateText.textContent = 'Select start date';
            delete startDateText.dataset.fullDate;
        }

        // Reset end options
        const endNeverRadio = $('#weeklyLessonEndNeverManage');
        if (endNeverRadio) endNeverRadio.checked = true;

        const endOnRadio = $('#weeklyLessonEndOnManage');
        if (endOnRadio) endOnRadio.checked = false;

        const endAfterRadio = $('#weeklyLessonEndAfterManage');
        if (endAfterRadio) endAfterRadio.checked = false;

        const occurrenceDisplay = $('#weeklyLessonOccurrenceDisplayManage');
        if (occurrenceDisplay) occurrenceDisplay.textContent = '13 occurrences';

        // Reset change-teacher UI so previous selections do not bleed into new events
        const changeTeacherCheckbox = document.getElementById('changeTeacherCheckbox');
        if (changeTeacherCheckbox) {
            changeTeacherCheckbox.checked = false;
            changeTeacherCheckbox.dispatchEvent(new Event('change'));
        }

        // Reset new teacher dropdown
        const newTeacherDropdownSection = document.getElementById('newTeacherDropdownSection');
        if (newTeacherDropdownSection) {
            newTeacherDropdownSection.style.display = 'none';
        }

        const newTeacherCurrentLabel = document.getElementById('newTeacherCurrentLabel');
        if (newTeacherCurrentLabel) {
            newTeacherCurrentLabel.textContent = 'Select new teacher';
        }

        const newTeacherCurrentImg = document.getElementById('newTeacherCurrentImg');
        if (newTeacherCurrentImg) {
            newTeacherCurrentImg.src =
                'https://images.unsplash.com/photo-1544005313-94ddf0286df2?q=80&w=200&auto=format&fit=crop';
        }

        const newTeacherTrigger = document.getElementById('newTeacherDropdownTrigger');
        if (newTeacherTrigger) {
            delete newTeacherTrigger.dataset.userid;
            delete newTeacherTrigger.dataset.name;
            delete newTeacherTrigger.dataset.img;
        }

        // Clear selection from new teacher list items
        const newTeacherItems = document.querySelectorAll('.new-teacher-item[aria-selected="true"]');
        newTeacherItems.forEach(item => item.removeAttribute('aria-selected'));

        // Clear global variables
        window.selectedCmidManage = null;
        window.rescheduleReason = null;
        window.rescheduleMessage = null;
        window.allEvents = false;
        window.weeklyReadyToSubmit = false;
        window.weeklyUpdateScope = 'this';
        window.singleReadyToSubmit = false;
        window.pendingSingleScopeAfterReschedule = false;
        if (window.weeklyLessonDayTimes) {
            window.weeklyLessonDayTimes = {};
        }

        // Re-validate form (should disable submit button)
        validateForm();

        // Reload students if teacher is selected
        const teacherId = teacherTrigger?.dataset.userid;
        if (teacherId) {
            loadStudentsForTeacher(teacherId, true);
        }

        console.log('Form reset successfully');
    }

    // Expose reset so other scripts (modal/tab handlers) can call it safely
    window.resetManageClassForm = resetManageClassForm;

    /* =======================================================
       MODAL CLOSE HANDLER - Reset form on close
    ======================================================== */
    $(document).ready(function() {
        // Handle modal close - reset form and clear state
        $('#calendar_admin_details_create_cohort_modal_backdrop').on('hidden.bs.modal', function() {
            console.log('Modal closed, resetting form');
            resetManageClassForm(true); // Clear state on close
        });

        // Also handle backdrop click and escape key
        $('#calendar_admin_details_create_cohort_modal_backdrop').on('click', function(e) {
            if (e.target === this) {
                // Check for unsaved changes
                if (window.getOne2OneStateManager) {
                    const stateManager = window.getOne2OneStateManager('one2oneForm');
                    if (stateManager && stateManager.hasUnsavedChanges()) {
                        if (!confirm('You have unsaved changes. Are you sure you want to close?')) {
                            e.preventDefault();
                            e.stopPropagation();
                            return false;
                        }
                    }
                }
                resetManageClassForm(true);
            }
        });
    });

    // Helper function to normalize event data for state management
    function normalizeEventDataForState(eventData) {
        if (!eventData) return null;

        return {
            eventId: eventData.eventid || eventData.eventId || eventData.id,
            googlemeetid: eventData.googlemeetid || eventData.googlemeetId,
            teacherId: eventData.teacherId || eventData.teacher?.id || eventData.teacherid,
            studentId: eventData.studentId || eventData.student?.id || eventData.studentid || (eventData.studentids && eventData.studentids[0]),
            date: eventData.date || eventData.eventdate || eventData.eventDate,
            start: eventData.start || eventData.start_time,
            end: eventData.end || eventData.end_time,
            duration: eventData.duration_minutes || eventData.duration,
            lessonType: eventData.classType === 'weekly' || eventData.class_type === 'weekly' || eventData.is_recurring ? 'weekly' : 'single',
            status: eventData.status,
            classType: eventData.classType || eventData.class_type
        };
    }
});

// ========== CHANGE TEACHER FUNCTIONALITY ==========
$(document).ready(function() {
    let selectedNewTeacherId = null;

    // Toggle new teacher dropdown section when checkbox is checked
    $('#changeTeacherCheckbox').on('change', function() {
        if ($(this).is(':checked')) {
            $('#newTeacherDropdownSection').slideDown(200);
        } else {
            $('#newTeacherDropdownSection').slideUp(200);
            selectedNewTeacherId = null;
            // Reset new teacher selection
            $('#newTeacherCurrentLabel').text('Select new teacher');
            $('#newTeacherCurrentImg').attr('src',
                'https://images.unsplash.com/photo-1544005313-94ddf0286df2?q=80&w=200&auto=format&fit=crop'
            );
            $('#newTeacherDropdownTrigger').removeAttr('data-userid');
            $('.new-teacher-item').removeClass('selected');
        }
    });

    // Toggle new teacher dropdown list
    $('#newTeacherDropdownTrigger').on('click', function(e) {
        e.stopPropagation();
        const $menu = $('#newTeacherDropdownMenu');
        const isOpen = $menu.is(':visible');

        // Close all other dropdowns first
        $('.calendar_admin_details_create_cohort_manage_class_tab_menu').not($menu).hide();

        if (isOpen) {
            $menu.hide();
            $(this).attr('aria-expanded', 'false');
        } else {
            $menu.show();
            $(this).attr('aria-expanded', 'true');
        }
    });

    // Close dropdown when clicking outside
    $(document).on('click', function(e) {
        if (!$(e.target).closest('#newTeacherDropdownTrigger, #newTeacherDropdownMenu').length) {
            $('#newTeacherDropdownMenu').hide();
            $('#newTeacherDropdownTrigger').attr('aria-expanded', 'false');
        }
    });

    // Search functionality for new teacher dropdown
    $('#newTeacherSearchInput').on('input', function() {
        const searchTerm = $(this).val().toLowerCase();
        $('.new-teacher-item').each(function() {
            const teacherName = $(this).data('name').toLowerCase();
            if (teacherName.includes(searchTerm)) {
                $(this).show();
            } else {
                $(this).hide();
            }
        });
    });

    // Prevent dropdown from closing when clicking search input
    $('#newTeacherSearchInput').on('click', function(e) {
        e.stopPropagation();
    });

    // Select new teacher
    $(document).on('click', '.new-teacher-item', function() {
        if ($(this).attr('aria-disabled') === 'true') return;

        const teacherId = $(this).data('userid');
        const teacherName = $(this).data('name');
        const teacherImg = $(this).data('img');

        // Update selection
        selectedNewTeacherId = teacherId;
        $('.new-teacher-item').removeClass('selected');
        $(this).addClass('selected');

        // Update trigger button display
        $('#newTeacherCurrentLabel').text(teacherName);
        $('#newTeacherCurrentImg').attr('src', teacherImg);
        $('#newTeacherDropdownTrigger').attr('data-userid', teacherId);

        // Close dropdown
        $('#newTeacherDropdownMenu').hide();
        $('#newTeacherDropdownTrigger').attr('aria-expanded', 'false');

        console.log('New teacher selected:', teacherId, teacherName);
    });

    // Expose getter for selected new teacher
    window.getSelectedNewTeacher = function() {
        return selectedNewTeacherId;
    };

    window.isChangeTeacherChecked = function() {
        return $('#changeTeacherCheckbox').is(':checked');
    };
});
</script>