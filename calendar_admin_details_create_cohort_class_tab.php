<link rel="stylesheet" href="<?php echo $CFG->wwwroot; ?>/local/customplugin/css/calendar_admin_details_create_cohort_class_tab.css">
<!-- Toast Notification -->
<div id="toastNotificationFor1:1Class" style="display:none; position:fixed; top:30px; right:30px; 
            background:#000; color:#fff; padding:16px 24px; 
            border-radius:8px; font-size:1rem; 
            box-shadow:0 4px 12px rgba(0,0,0,0.3);
            z-index:99999; opacity:0; transition:opacity .3s, transform .3s;
            transform:translateY(20px);">
</div>

<div class="calendar_admin_details_create_cohort_content tab-content" id="classTabContent" style="display:none;">
    <form id="one2oneClassForm" name="one2oneClassForm" method="post" novalidate>
        <!-- Hidden form fields for actual submission -->
        <input type="hidden" id="form_teacher_id" name="teacher_id" value="">
        <input type="hidden" id="form_student_id" name="student_id" value="">
        <input type="hidden" id="form_lesson_type" name="lesson_type" value="single">
        <input type="hidden" id="form_single_date" name="single_date" value="">
        <input type="hidden" id="form_single_time" name="single_time" value="">
        <input type="hidden" id="form_single_duration" name="single_duration" value="50">
        <input type="hidden" id="form_weekly_data" name="weekly_data" value="">

        <!-- Step 1: Teacher Selection -->
        <div class="calendar_admin_details_create_cohort_class_tab_wrap"
            id="calendar_admin_details_create_cohort_class_tab_widget">
            <div class="calendar_admin_details_create_cohort_class_tab_label">Teacher</div>

            <button type="button" class="calendar_admin_details_create_cohort_class_tab_trigger" 
                aria-haspopup="listbox" aria-expanded="false" 
                id="calendar_admin_details_create_cohort_class_tab_trigger">
                <div class="calendar_admin_details_create_cohort_class_tab_left">
                    <img class="calendar_admin_details_create_cohort_class_tab_avatar"
                        id="calendar_admin_details_create_cohort_class_tab_current_img"
                        src="https://images.unsplash.com/photo-1544005313-94ddf0286df2?q=80&w=200&auto=format&fit=crop"
                        alt="Selected teacher">
                    <span class="calendar_admin_details_create_cohort_class_tab_name"
                        id="calendar_admin_details_create_cohort_class_tab_current_label">Daniela</span>
                </div>
                <img class="calendar_admin_details_create_cohort_class_tab_chev" src="./img/dropdown-arrow-down.svg" alt="">
            </button>

            <div class="calendar_admin_details_create_cohort_class_tab_menu"
                id="calendar_admin_details_create_cohort_class_tab_menu">
                <div class="calendar_admin_details_create_cohort_class_tab_panel" role="listbox"
                    aria-labelledby="calendar_admin_details_create_cohort_class_tab_trigger"
                    id="calendar_admin_details_create_cohort_class_tab_list">
                    <input type="text" id="teacherSearchInput" class="dropdown-search" placeholder="Enter teacher name...">

                    <?php
                    require_once(__DIR__ . '/../../config.php');
                    require_login();

                    global $DB, $PAGE, $OUTPUT;

                    /** Collect unique teacher user IDs from cohorts */
                    $userids = $DB->get_fieldset_sql("
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
                    if ($userids) {
                        list($insql, $params) = $DB->get_in_or_equal($userids, SQL_PARAMS_NAMED);
                        $fields = "id, firstname, lastname, picture, imagealt, firstnamephonetic, lastnamephonetic, middlename, alternatename";
                        $teachers = $DB->get_records_select('user', "id $insql AND deleted = 0 AND suspended = 0", $params, 'firstname ASC, lastname ASC', $fields);
                    }
                    $teachers_items_html = '';

                    if (!empty($teachers)) {
                        foreach ($teachers as $t) {
                            $pic = new user_picture($t);
                            $pic->size = 50;
                            $imgurl = $pic->get_url($PAGE)->out(false);
                            $name   = fullname($t, true);

                            $teachers_items_html .=
                                '<div class="calendar_admin_details_create_cohort_class_tab_item" role="option" '.
                                    'data-userid="'.(int)$t->id.'" '.
                                    'data-name="'.s($name).'" '.
                                    'data-img="'.s($imgurl).'">'.
                                    '<img class="calendar_admin_details_create_cohort_class_tab_avatar" src="'.s($imgurl).'" alt="'.s($name).'" />'.
                                    '<span class="calendar_admin_details_create_cohort_class_tab_item_name">'.format_string($name).'</span>'.
                                '</div>';
                        }
                    } else {
                        $teachers_items_html =
                            '<div class="calendar_admin_details_create_cohort_class_tab_item" role="option" aria-disabled="true">'.
                                '<span class="calendar_admin_details_create_cohort_class_tab_item_name">No teachers found</span>'.
                            '</div>';
                    }
                    echo $teachers_items_html;
                    ?>
                </div>
            </div>
        </div>

        <!-- Step 2: Student Selection -->
        <label class="one2one-section-label">Student</label>
        <div class="one2one-student-dropdown-wrapper">
            <div class="one2one-add-student-card" id="one2oneAddStudentBtn" tabindex="0">
                <span class="one2one-add-student-icon">
                    <img src="./img/student-placeholder.svg" alt="">
                </span>
                <span class="one2one-add-student-placeholder" style="color:#aaa;">Add student</span>
            </div>
            <div class="one2one-student-dropdown-list" id="one2oneStudentDropdown" style="display:none;">
                <input type="text" id="studentSearchInput" class="dropdown-search" placeholder="Enter student name...">
                <?php
                global $DB, $PAGE;

                $studentrole = $DB->get_record('role', ['shortname' => 'student']);
                $studentroleid = $studentrole ? (int)$studentrole->id : 5;

                $userids = $DB->get_fieldset_sql("
                    SELECT DISTINCT ra.userid
                      FROM {role_assignments} ra
                     WHERE ra.roleid = ?
                ", [$studentroleid]);

                $students_items_html = '';

                if (!empty($userids)) {
                    list($insql, $params) = $DB->get_in_or_equal($userids, SQL_PARAMS_NAMED, 'u');
                    $fields = "id, firstname, lastname, picture, imagealt, firstnamephonetic, lastnamephonetic, middlename, alternatename";
                    $users = $DB->get_records_select('user', "id $insql AND deleted = 0 AND suspended = 0", $params, 'firstname ASC, lastname ASC', $fields);

                    foreach ($users as $u) {
                        $pic = new user_picture($u);
                        $pic->size = 50;
                        $imgurl = $pic->get_url($PAGE)->out(false);
                        $name   = fullname($u, true);
                        $methodlabel = 'subscriptionloading';

                        $students_items_html .=
                            '<div class="one2one-student-list-item-class" data-userid="'.(int)$u->id.'" data-name="'.s($name).'">'.
                                '<div class="one2one-student-list-avatar">'.
                                    '<img src="'.s($imgurl).'" alt="'.s($name).'" style="width:24px;height:24px;border-radius:50%;object-fit:cover;" />'.
                                '</div>'.
                                '<div class="one2one-student-list-meta">'.
                                    '<div class="one2one-student-list-name">'.format_string($name).'</div>'.
                                    '<div class="one2one-student-list-lessons">0 Lessons</div>'.
                                '</div>'.
                                '<div class="one2one-student-list-status">'.$methodlabel.'</div>'.
                            '</div>';
                    }
                }

                if ($students_items_html === '') {
                    $students_items_html =
                        '<div class="one2one-student-list-item-class" aria-disabled="true">'.
                            '<div class="one2one-student-list-meta">'.
                                '<div class="one2one-student-list-name">No active subscribers</div>'.
                                '<div class="one2one-student-list-lessons">—</div>'.
                            '</div>'.
                            '<div class="one2one-student-list-status">—</div>'.
                        '</div>';
                }

                echo $students_items_html;
                ?>
            </div>
        </div>

        <!-- Step 3: Lesson Type Selection -->
        <label class="one2one-section-label">Lesson type</label>
        <div class="one2one-lesson-type-row">
            <div class="one2one-lesson-type-btn selected" data-type="single">
                <span class="one2one-lesson-type-icon">
                    <img src="./img/single-lesson" alt="">
                    Single lessons
                </span>
                <input type="radio" class="one2one-radio" name="lessonType" id="lessonTypeSingle" value="single" checked>
            </div>
            <div class="one2one-lesson-type-btn" data-type="weekly">
                <span class="one2one-lesson-type-icon">
                    <img src="./img/weekly-lesson" alt="">
                    Weekly lessons
                </span>
                <input type="radio" class="one2one-radio" name="lessonType" id="lessonTypeWeekly" value="weekly">
            </div>
        </div>

        <!-- Step 4: Single Lesson Configuration -->
        <div id="custom-single-lesson">
            <label class="one2one-section-label">Date and time</label>
            <div class="one2one-duration-dropdown-wrapper" id="durationDropdownWrapper">
                <div class="one2one-duration-dropdown-display" id="durationDropdownDisplay">50 Minutes ( Standard time )
                    <span>
                        <img src="./img/dropdown-arrow-down.svg" alt="">
                    </span>
                </div>
                <div class="one2one-duration-dropdown-list" id="durationDropdownList" style="display:none;">
                    <div class="one2one-duration-option" data-duration="20">20 Minutes</div>
                    <div class="one2one-duration-option selected" data-duration="50">50 Minutes</div>
                    <div class="one2one-duration-option" data-duration="60">1 Hour</div>
                </div>
            </div>
            <div class="one2one-datetime-dropdown-row">
                <div class="one2one-date-dropdown-display" id="customDateDropdownDisplay"
                    style=" width:100%; padding:13px 14px; border-radius:10px; border:1.5px solid #dadada; background:#fff; font-size:1.05rem; color:#232323; margin-bottom:12px; cursor:pointer; display:flex; align-items:center; justify-content:center;">
                    <span id="selectedDateText">Tue, Feb11</span>
                </div>
                <div class="d-flex" id="customTimeFields" style="width:100%;">
                    <div class="custom-time-pill">
                        <input type="text" id="singleTimeInput" name="single_time_display" 
                            class="form-control time-input" value="10:30 am" autocomplete="off" readonly
                            style="background-color:#ffffff; height: 50px;width:100%;" />
                        <div class="custom-time-dropdown"></div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Step 5: Weekly Lesson Configuration -->
        <div id="custom-weekly-lesson" style="display:none;">
            <div id="weeklyLessonModalBackdrop" class="weekly_lesson_modal_backdrop">
                <div class="weekly_lesson_modal_container-create">
                    <div style="margin-bottom:16px;">
                        <div style="display:flex; align-items:center; gap:13px; margin-top:7px;">
                            <label style="font-weight:600; color:#000000;">Repeat Every</label>
                            <button type="button" class="weekly_lesson_stepper" id="wl_interval_minus">−</button>
                            <span id="wl_interval_display" style="font-size:1.18rem;font-weight:bold;">1</span>
                            <button type="button" class="weekly_lesson_stepper" id="wl_interval_plus">+</button>
                            <div class="weekly_lesson_dropdown_wrapper">
                                <div class="weekly_lesson_dropdown_btn" id="wl_period_btn">
                                    <span id="wl_period_display">Week</span>
                                    <svg width="18" height="18" viewBox="0 0 20 20">
                                        <path d="M7 8l3 3 3-3" fill="none" stroke="#232323" stroke-width="2"></path>
                                    </svg>
                                </div>
                                <div class="weekly_lesson_dropdown_list" id="wl_period_list">
                                    <div class="weekly_lesson_option" data-period="Week">Week</div>
                                    <div class="weekly_lesson_option" data-period="Bi-Weekly">Bi-Weekly</div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <hr class="weekly_lesson_hr">
                    <div style="margin-bottom:16px;">
                        <label style="font-weight:600; color:#000000;">Start Date</label>
                        <button type="button" id="wl_start_date_btn" class="weekly_lesson_date_btn enabled"
                            style="margin-top:7px; width:100%; text-align:left; padding:12px 18px;">
                            <span id="wl_start_date_text">Select start date</span>
                        </button>
                    </div>

                    <div class="monthly_cal_modal_backdrop" id="wlStartDateCalendarBackdrop" style="display:none;">
                        <div class="monthly_cal_modal">
                            <div class="monthly_cal_header">
                                <button type="button" id="wl_cal_prev"
                                    style="background:none;border:none;font-size:1.4rem;cursor:pointer;color:#232323;" aria-label="Previous month">&#8592;</button>
                                <span class="monthly_cal_month_label" id="wl_cal_month"></span>
                                <button type="button" id="wl_cal_next"
                                    style="background:none;border:none;font-size:1.4rem;cursor:pointer;color:#232323;" aria-label="Next month">&#8594;</button>
                            </div>
                            <div class="monthly_cal_grid" id="wl_cal_days"></div>
                            <div class="monthly_cal_grid" id="wl_cal_dates"></div>
                            <button type="button" class="monthly_cal_done_btn" id="wl_cal_done">Done</button>
                        </div>
                    </div>
                    <div id="wl_repeat_container">
                        <label style="font-weight:600; color:#000000;">Repeat on</label>
                        <div class="weekly_lesson_widget_row" id="wl_widgets_row">
                            <!-- Widgets injected by JS -->
                        </div>
                    </div>

                    <hr class="weekly_lesson_hr large">

                    <div>
                        <label style="font-weight:600;">Ends</label>
                        <div style="margin-top:8px;">
                            <div style="display:flex;align-items:center; gap:10px; margin-bottom:6px;">
                                <input type="radio" id="wl_end_never" name="wl_end_option" value="never" checked>
                                <label for="wl_end_never" style="font-size:1.05rem;">Never</label>
                            </div>
                            <div style="display:flex;align-items:center; gap:10px; margin-bottom:6px;">
                                <input type="radio" id="wl_end_on" name="wl_end_option" value="on">
                                <label for="wl_end_on" style="font-size:1.05rem;">On</label>
                                <button type="button" id="wl_end_date_btn" disabled class="weekly_lesson_date_btn">Sep 27, 2024</button>
                            </div>
                            <div style="display:flex;align-items:center; gap:10px;">
                                <input type="radio" id="wl_end_after" name="wl_end_option" value="after">
                                <label for="wl_end_after" style="font-size:1.05rem;">After</label>
                                <div class="weekly_lesson_occurrence_counter" style="margin-left:12px;">
                                    <button type="button" class="weekly_lesson_stepper" id="wl_occ_minus" disabled>−</button>
                                    <span id="wl_occ_display" style="font-size:1.11rem;font-weight:600;color:#555;">13 occurrences</span>
                                    <button type="button" class="weekly_lesson_stepper" id="wl_occ_plus" disabled>+</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Time Picker for Weekly -->
            <div id="wlTimepickerBackdrop" class="wl_timepicker_modal_backdrop">
                <div class="wl_timepicker_modal">
                    <h2 class="wl_tp_card_title" id="wl_tp_day_label">Select Start & End Time</h2>
                    <div class="wl_tp_inputs_container">
                        <input id="wl_tp_start" type="text" class="wl_tp_input" value="09:00 AM" />
                        <span style="color:#232323;">–</span>
                        <input id="wl_tp_end" type="text" class="wl_tp_input" value="10:00 AM" />
                    </div>
                    <div class="wl_tp_button_container">
                        <button type="button" id="wl_tp_cancel_btn" class="wl_tp_cancel_btn">Cancel</button>
                        <button type="button" id="wl_tp_done_btn" class="wl_tp_done_btn">Done</button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Submit Button -->
        <button type="submit" class="calendar_admin_details_create_cohort_schedule_btn" style="position:sticky;">
            Schedule 1:1 Class
        </button>
    </form>
</div>

<!-- Custom Calendar Modal -->
<div class="calendar-modal-backdrop" id="calendarModalBackdrop">
    <div class="calendar-modal" id="calendarModal">
        <div class="calendar-modal-header">
            <button type="button" class="calendar-modal-arrow" id="calendarPrevMonth"><svg width="22" height="22" viewBox="0 0 24 24">
                    <polyline points="15 19 8 12 15 5" fill="none" stroke="#111" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></polyline>
                </svg></button>
            <span id="calendarMonthYear"></span>
            <button type="button" class="calendar-modal-arrow" id="calendarNextMonth"><svg width="22" height="22" viewBox="0 0 24 24">
                    <polyline points="9 19 16 12 9 5" fill="none" stroke="#111" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></polyline>
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
            <div class="calendar-modal-days" id="calendarDaysGrid">
                <!-- Days rendered by JS -->
            </div>
        </div>
        <div class="calendar-modal-footer">
            <button type="button" class="calendar-modal-done" id="calendarDoneBtn">Done</button>
        </div>
    </div>
</div>

<!-- Include centralized time, date, and toast utilities -->
<script src="js/time_utils.js"></script>
<script src="js/date_utils.js"></script>
<script src="js/toast_utils.js"></script>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // ===== STEP 1: INITIALIZE TEACHER SELECTION =====
    const list = document.getElementById('calendar_admin_details_create_cohort_class_tab_list');
    const trigger = document.getElementById('calendar_admin_details_create_cohort_class_tab_trigger');
    const imgEl = document.getElementById('calendar_admin_details_create_cohort_class_tab_current_img');
    const labelEl = document.getElementById('calendar_admin_details_create_cohort_class_tab_current_label');
    const menu = document.getElementById('calendar_admin_details_create_cohort_class_tab_menu');
    const formTeacherId = document.getElementById('form_teacher_id');

    if (!list || !trigger) return;
    
    const firstTeacher = list.querySelector('.calendar_admin_details_create_cohort_class_tab_item[role="option"]');
    if (firstTeacher) {
        const name = firstTeacher.dataset.name;
        const img = firstTeacher.dataset.img;
        const uid = firstTeacher.dataset.userid;

        if (imgEl && img) {
            imgEl.src = img;
            imgEl.alt = name || 'Selected teacher';
        }
        if (labelEl && name) {
            labelEl.textContent = name;
        }
        if (formTeacherId) {
            formTeacherId.value = uid || '';
        }

        trigger.dataset.userid = uid;
        trigger.dataset.name = name;
        trigger.dataset.img = img;
        firstTeacher.setAttribute('aria-selected', 'true');
    }

    list.querySelectorAll('.calendar_admin_details_create_cohort_class_tab_item[role="option"]').forEach(item => {
        item.addEventListener('click', () => {
            list.querySelectorAll('.calendar_admin_details_create_cohort_class_tab_item[aria-selected="true"]')
                .forEach(el => el.removeAttribute('aria-selected'));
            item.setAttribute('aria-selected', 'true');

            const name = item.dataset.name;
            const img = item.dataset.img;
            const uid = item.dataset.userid;

            if (imgEl && img) {
                imgEl.src = img;
                imgEl.alt = name || 'Selected teacher';
            }
            if (labelEl && name) {
                labelEl.textContent = name;
            }
            if (formTeacherId) {
                formTeacherId.value = uid || '';
            }
            
            trigger.dataset.userid = uid;
            trigger.dataset.name = name;
            trigger.dataset.img = img;

            if (menu) menu.style.display = 'none';
        });
    });
});
</script>

<script>
(function() {
    // ===== STEP 2: WEEKLY LESSON WIDGET MANAGEMENT =====
    function renderWidgetTime(key, start, end) {
        const s = to12h(start), e = to12h(end);
        const $w = document.querySelector(`.wl_scroll_widget[data-key="${key}"]`);
        if (!$w) return;

        let $time = $w.querySelector('.wl_widget_time');
        if (!$time) {
            $time = document.createElement('div');
            $time.className = 'wl_widget_time';
            $time.innerHTML = `
                <div class="wl_widget_hm s"></div>
                <span class="wl_widget_period sp"></span>
                <span class="wl_widget_dash">-</span>
                <div class="wl_widget_hm e"></div>
                <span class="wl_widget_period ep"></span>
            `;
            const divider = $w.querySelector('.wl_widget_divider');
            if (divider) divider.after($time);
        }
        $time.querySelector('.s').textContent = s.hm;
        $time.querySelector('.sp').textContent = s.period;
        $time.querySelector('.e').textContent = e.hm;
        $time.querySelector('.ep').textContent = e.period;
        $time.classList.add('has-time');
    }

    let wlInterval = 1;
    let wlOccurrences = 13;
    let wlEndDate = new Date();
    let wlDayTimes = {};
    let wlCurrentDayKey = null;
    const dayNamesShort = ['S', 'M', 'T', 'W', 'Th', 'F', 'Sa'];
    const dayNamesLong = ['Sun', 'Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat'];

    const $widgetRow = document.getElementById('wl_widgets_row');
    if ($widgetRow) {
        for (let i = 0; i < 7; i++) {
            const $widget = document.createElement('div');
            $widget.className = 'wl_scroll_widget';
            $widget.dataset.key = i;
            $widget.innerHTML = `
                <span class="wl_widget_text">${dayNamesShort[i]}</span>
                <div class="wl_widget_divider"></div>
                <button type="button" class="wl_widget_button" data-arrow="1">
                    <div class="wl_widget_arrow"></div>
                </button>
            `;
            $widgetRow.appendChild($widget);
        }
    }

    const wlIntervalPlus = document.getElementById('wl_interval_plus');
    const wlIntervalMinus = document.getElementById('wl_interval_minus');
    if (wlIntervalPlus) {
        wlIntervalPlus.addEventListener('click', () => {
            wlInterval++;
            const display = document.getElementById('wl_interval_display');
            if (display) display.textContent = wlInterval;
        });
    }
    if (wlIntervalMinus) {
        wlIntervalMinus.addEventListener('click', () => {
            if (wlInterval > 1) wlInterval--;
            const display = document.getElementById('wl_interval_display');
            if (display) display.textContent = wlInterval;
        });
    }

    const wlPeriodBtn = document.getElementById('wl_period_btn');
    if (wlPeriodBtn) {
        wlPeriodBtn.addEventListener('click', (e) => {
            e.stopPropagation();
            const periodList = document.getElementById('wl_period_list');
            if (periodList) {
                periodList.style.display = periodList.style.display === 'block' ? 'none' : 'block';
            }
        });
    }
    document.addEventListener('click', () => {
        const periodList = document.getElementById('wl_period_list');
        if (periodList) periodList.style.display = 'none';
    });
    document.querySelectorAll('#wl_period_list .weekly_lesson_option').forEach(opt => {
        opt.addEventListener('click', function() {
            const periodDisplay = document.getElementById('wl_period_display');
            const periodList = document.getElementById('wl_period_list');
            if (periodDisplay) periodDisplay.textContent = this.textContent;
            if (periodList) periodList.style.display = 'none';
        });
    });

    const wlOccPlus = document.getElementById('wl_occ_plus');
    const wlOccMinus = document.getElementById('wl_occ_minus');
    if (wlOccPlus) {
        wlOccPlus.addEventListener('click', () => {
            const endAfter = document.getElementById('wl_end_after');
            if (endAfter && endAfter.checked) {
                wlOccurrences++;
                const occDisplay = document.getElementById('wl_occ_display');
                if (occDisplay) occDisplay.textContent = wlOccurrences + ' occurrences';
            }
        });
    }
    if (wlOccMinus) {
        wlOccMinus.addEventListener('click', () => {
            const endAfter = document.getElementById('wl_end_after');
            if (endAfter && endAfter.checked && wlOccurrences > 1) {
                wlOccurrences--;
                const occDisplay = document.getElementById('wl_occ_display');
                if (occDisplay) occDisplay.textContent = wlOccurrences + ' occurrences';
            }
        });
    }

    function updateEndsUI() {
        const onChecked = document.getElementById('wl_end_on').checked;
        const afterChecked = document.getElementById('wl_end_after').checked;

        document.getElementById('wl_end_date_btn').disabled = !onChecked;
        if (onChecked) document.getElementById('wl_end_date_btn').classList.add('enabled');
        else document.getElementById('wl_end_date_btn').classList.remove('enabled');

        document.getElementById('wl_occ_minus').disabled = !afterChecked;
        document.getElementById('wl_occ_plus').disabled = !afterChecked;
    }
    document.querySelectorAll('input[name="wl_end_option"]').forEach(radio => {
        radio.addEventListener('change', updateEndsUI);
    });
    updateEndsUI();

    document.addEventListener('click', function(e) {
        if (!e.target.closest('[data-arrow]')) {
            const $w = e.target.closest('.wl_scroll_widget');
            if ($w) {
                const sel = !$w.classList.contains('selected');
                $w.classList.toggle('selected', sel);
                $w.setAttribute('aria-pressed', sel ? 'true' : 'false');

                if (!sel) {
                    const key = parseInt($w.dataset.key, 10);
                    delete wlDayTimes[key];
                    $w.querySelector('.wl_widget_button').classList.remove('has-time');
                    const $time = $w.querySelector('.wl_widget_time');
                    if ($time) $time.remove();
                }
            }
        }
    });

    document.addEventListener('click', function(e) {
        if (e.target.closest('[data-arrow]')) {
            const $w = e.target.closest('.wl_scroll_widget');
            wlCurrentDayKey = parseInt($w.dataset.key, 10);
            const cur = wlDayTimes[wlCurrentDayKey] || { start: '09:00', end: '10:00' };

            document.getElementById('wl_tp_start').value = cur.start;
            document.getElementById('wl_tp_end').value = cur.end;
            document.getElementById('wlTimepickerBackdrop').style.display = 'block';
        }
    });

    document.getElementById('wl_tp_cancel_btn').addEventListener('click', () => {
        document.getElementById('wlTimepickerBackdrop').style.display = 'none';
    });

    document.getElementById('wl_tp_done_btn').addEventListener('click', () => {
        if (wlCurrentDayKey == null) return;

        const start = (document.getElementById('wl_tp_start').value || '09:00').slice(0, 5);
        let end = (document.getElementById('wl_tp_end').value || '10:00').slice(0, 5);

        if (end <= start) {
            const [h, m] = start.split(':').map(Number);
            const h2 = (h + 1) % 24;
            end = `${String(h2).padStart(2,'0')}:${String(m).padStart(2,'0')}`;
        }

        wlDayTimes[wlCurrentDayKey] = { start, end };
        renderWidgetTime(wlCurrentDayKey, start, end);

        const $btn = document.querySelector(`.wl_scroll_widget[data-key="${wlCurrentDayKey}"] .wl_widget_button`);
        $btn.classList.add('has-time');

        document.getElementById('wlTimepickerBackdrop').style.display = 'none';
    });

    document.getElementById('wlTimepickerBackdrop').addEventListener('click', function(e) {
        if (e.target === this) this.style.display = 'none';
    });

    function closeModal() {
        document.getElementById('weeklyLessonModalBackdrop').style.display = 'none';
    }

    document.getElementById('weeklyLessonModalBackdrop').addEventListener('click', function(e) {
        if (e.target === this) closeModal();
    });

    window.openWeeklyLessonModal = function() {
        document.getElementById('weeklyLessonModalBackdrop').style.display = 'block';
    };
})();
</script>

<script>
(function() {
    // ===== STEP 3: WEEKLY LESSON CALENDAR MANAGEMENT =====
    let wlCalendarTarget = 'start';
    let wlStartDate = new Date();
    let wlEndsOnDate = new Date();
    wlEndsOnDate.setMonth(wlEndsOnDate.getMonth() + 1);

    let wlCalViewMonth = wlStartDate.getMonth();
    let wlCalViewYear = wlStartDate.getFullYear();
    let wlCalSelectedDate = new Date(wlStartDate);

    document.getElementById('wl_start_date_text').textContent = window.formatDate(wlStartDate);
    document.getElementById('wl_end_date_btn').textContent = window.formatDate(wlEndsOnDate);

    document.getElementById('wl_start_date_btn').addEventListener('click', function() {
        wlCalendarTarget = 'start';
        wlCalSelectedDate = new Date(wlStartDate);
        wlCalViewMonth = wlCalSelectedDate.getMonth();
        wlCalViewYear = wlCalSelectedDate.getFullYear();
        renderWlCalendar();
        document.getElementById('wlStartDateCalendarBackdrop').style.display = 'block';
    });

    document.getElementById('wl_end_date_btn').addEventListener('click', function() {
        if (!this.disabled) {
            wlCalendarTarget = 'ends';
            wlCalSelectedDate = new Date(wlEndsOnDate);
            wlCalViewMonth = wlCalSelectedDate.getMonth();
            wlCalViewYear = wlCalSelectedDate.getFullYear();
            renderWlCalendar();
            document.getElementById('wlStartDateCalendarBackdrop').style.display = 'block';
        }
    });

    function renderWlCalendar() {
        const monthNames = ["January", "February", "March", "April", "May", "June",
            "July", "August", "September", "October", "November", "December"];
        document.getElementById('wl_cal_month').textContent = monthNames[wlCalViewMonth] + " " + wlCalViewYear;

        const days = ["Mo", "Tu", "We", "Th", "Fr", "Sa", "Su"];
        const daysRow = document.getElementById('wl_cal_days');
        daysRow.innerHTML = '';
        for (let i = 0; i < 7; i++) {
            const dayDiv = document.createElement('div');
            dayDiv.className = 'monthly_cal_day';
            dayDiv.textContent = days[i];
            daysRow.appendChild(dayDiv);
        }

        const datesRow = document.getElementById('wl_cal_dates');
        datesRow.innerHTML = '';

        const firstDay = new Date(wlCalViewYear, wlCalViewMonth, 1).getDay();
        const offset = (firstDay + 6) % 7;
        const daysInMonth = new Date(wlCalViewYear, wlCalViewMonth + 1, 0).getDate();

        for (let i = 0; i < offset; i++) {
            const emptyDiv = document.createElement('div');
            emptyDiv.className = 'monthly_cal_date inactive';
            datesRow.appendChild(emptyDiv);
        }

        for (let d = 1; d <= daysInMonth; d++) {
            const dateDiv = document.createElement('div');
            dateDiv.className = 'monthly_cal_date';
            dateDiv.dataset.date = d;
            dateDiv.textContent = d;

            const isSel = d === wlCalSelectedDate.getDate() &&
                wlCalViewMonth === wlCalSelectedDate.getMonth() &&
                wlCalViewYear === wlCalSelectedDate.getFullYear();

            if (isSel) {
                dateDiv.classList.add('selected');
            }

            dateDiv.addEventListener('click', function() {
                if (this.classList.contains('inactive')) return;
                const day = parseInt(this.dataset.date, 10);
                wlCalSelectedDate.setFullYear(wlCalViewYear);
                wlCalSelectedDate.setMonth(wlCalViewMonth);
                wlCalSelectedDate.setDate(day);
                renderWlCalendar();
            });

            datesRow.appendChild(dateDiv);
        }
    }

    document.getElementById('wl_cal_prev').addEventListener('click', function() {
        switch (wlCalViewMonth) {
            case 0:
                wlCalViewMonth = 11;
                wlCalViewYear--;
                break;
            default:
                wlCalViewMonth--;
        }
        renderWlCalendar();
    });

    document.getElementById('wl_cal_next').addEventListener('click', function() {
        switch (wlCalViewMonth) {
            case 11:
                wlCalViewMonth = 0;
                wlCalViewYear++;
                break;
            default:
                wlCalViewMonth++;
        }
        renderWlCalendar();
    });

    document.getElementById('wl_cal_done').addEventListener('click', function() {
        switch (wlCalendarTarget) {
            case 'start':
                wlStartDate = new Date(wlCalSelectedDate);
                document.getElementById('wl_start_date_text').textContent = window.formatDate(wlStartDate);
                document.getElementById('wl_start_date_text').dataset.fullDate = wlStartDate.toISOString().split('T')[0];
                break;
            case 'ends':
                wlEndsOnDate = new Date(wlCalSelectedDate);
                document.getElementById('wl_end_date_btn').textContent = window.formatDate(wlEndsOnDate);
                document.getElementById('wl_end_date_btn').dataset.fullDate = wlEndsOnDate.toISOString().split('T')[0];
                break;
        }
        document.getElementById('wlStartDateCalendarBackdrop').style.display = 'none';
    });

    document.getElementById('wlStartDateCalendarBackdrop').addEventListener('click', function(e) {
        if (e.target === this) {
            this.style.display = 'none';
        }
    });

    window.getWeeklyLessonStartDate = function() {
        return wlStartDate;
    };

    window.getWeeklyLessonEndsOnDate = function() {
        return wlEndsOnDate;
    };
})();
</script>

<script>
document.addEventListener("DOMContentLoaded", () => {
    // ===== STEP 4: INITIALIZE FORM AND VALIDATION =====
    const today = new Date();
    const monthNames = ["Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec"];
    const dayNames = ["Sun", "Mon", "Tue", "Wed", "Thu", "Fri", "Sat"];

    const selectedDateText = document.getElementById('selectedDateText');
    const formSingleDate = document.getElementById('form_single_date');
    if (selectedDateText) {
        selectedDateText.textContent = window.formatDateShort(today, dayNames, monthNames);
        const fullDate = today.toISOString().split('T')[0];
        selectedDateText.dataset.fullDate = fullDate;
        if (formSingleDate) formSingleDate.value = fullDate;
    }

    const wlStartDateText = document.getElementById('wl_start_date_text');
    if (wlStartDateText) {
        wlStartDateText.textContent = window.formatDateLong(today, monthNames);
    }

    function showToastCreateClass(message, type = 'success', duration = 5000) {
        return window.showToast(message, type, duration, 'toastNotificationFor1:1Class');
    }

    // ===== VALIDATION FUNCTIONS =====
    function validateTeacherSelection() {
        const formTeacherId = document.getElementById('form_teacher_id');
        const teacherTrigger = document.getElementById('calendar_admin_details_create_cohort_class_tab_trigger');
        
        if (!formTeacherId || !formTeacherId.value || formTeacherId.value === '') {
            highlightField(teacherTrigger?.closest('#calendar_admin_details_create_cohort_class_tab_trigger'));
            return false;
        }
        return true;
    }

    function validateStudentSelection() {
        const formStudentId = document.getElementById('form_student_id');
        const studentCard = document.getElementById('one2oneAddStudentBtn');

        if (!formStudentId || !formStudentId.value || formStudentId.value === '') {
            highlightField(studentCard);
            return false;
        }
        return true;
    }

    function validateLessonType() {
        const checkedRadio = document.querySelector('.one2one-radio:checked');
        const lessonTypeRow = document.querySelector('.one2one-lesson-type-row');

        if (!checkedRadio) {
            highlightField(lessonTypeRow);
            return false;
        }
        return true;
    }

    function validateSingleLesson() {
        let isValid = true;
        const formSingleDate = document.getElementById('form_single_date');
        const formSingleTime = document.getElementById('form_single_time');
        const formSingleDuration = document.getElementById('form_single_duration');

        if (!formSingleDate || !formSingleDate.value) {
            highlightField(document.getElementById('customDateDropdownDisplay'));
            isValid = false;
        }

        if (!formSingleTime || !formSingleTime.value) {
            highlightField(document.querySelector('.time-input'));
            isValid = false;
        }

        if (!formSingleDuration || !formSingleDuration.value) {
            highlightField(document.getElementById('durationDropdownWrapper'));
            isValid = false;
        }

        return isValid;
    }

    function validateWeeklyLesson() {
        let isValid = true;
        const startDateText = document.getElementById('wl_start_date_text')?.textContent.trim();
        
        if (!startDateText || startDateText === 'Select start date') {
            highlightField(document.getElementById('wl_start_date_btn'));
            isValid = false;
        }

        const selectedDays = document.querySelectorAll('.wl_scroll_widget.selected');
        if (selectedDays.length === 0) {
            highlightField(document.getElementById('wl_widgets_row'));
            isValid = false;
            return isValid;
        }

        let hasMissingTime = false;
        selectedDays.forEach(widget => {
            const hasTime = widget.querySelector('.wl_widget_time.has-time');
            if (!hasTime) {
                highlightField(widget);
                hasMissingTime = true;
            }
        });

        if (hasMissingTime) {
            isValid = false;
        }

        if (document.getElementById('wl_end_on').checked) {
            const endDateText = document.getElementById('wl_end_date_btn')?.textContent.trim();
            if (!endDateText || endDateText === 'Select date') {
                highlightField(document.getElementById('wl_end_date_btn'));
                isValid = false;
            }
        }

        if (document.getElementById('wl_end_after').checked) {
            const occurrences = parseInt(document.getElementById('wl_occ_display')?.textContent || '0');
            if (occurrences < 1) {
                highlightField(document.getElementById('wl_occ_display'));
                isValid = false;
            }
        }

        return isValid;
    }

    function highlightField(element) {
        if (!element) return;
        element.classList.add('field-error');
        element.scrollIntoView({
            behavior: 'smooth',
            block: 'center'
        });
        setTimeout(() => {
            element.classList.remove('field-error');
        }, 2000);
    }

    // ===== TIME PICKER FUNCTIONS =====
    function generateTimeOptions() {
        const options = [];
        for (let h = 0; h < 24; h++) {
            for (let m of [0, 30]) {
                const hh = h % 12 === 0 ? 12 : h % 12;
                const mm = m === 0 ? '00' : m;
                const period = h < 12 ? 'AM' : 'PM';
                options.push(`${hh}:${mm} ${period}`);
            }
        }
        return options;
    }

    function createTimeDropdown(inputId) {
        const input = document.getElementById(inputId);
        if (!input) return;

        const list = document.createElement('div');
        list.className = 'time-dropdown';
        list.style.position = 'absolute';
        list.style.top = '8rem';
        list.style.left = '26px';
        list.style.background = '#fff';
        list.style.border = '1px solid #ddd';
        list.style.borderRadius = '8px';
        list.style.boxShadow = '0 3px 8px rgba(0,0,0,0.1)';
        list.style.maxHeight = '200px';
        list.style.overflowY = 'auto';
        list.style.zIndex = '99999';

        generateTimeOptions().forEach(t => {
            const opt = document.createElement('div');
            opt.textContent = t;
            opt.style.padding = '8px 12px';
            opt.style.cursor = 'pointer';
            opt.addEventListener('click', () => {
                input.value = t;
                const formSingleTime = document.getElementById('form_single_time');
                if (formSingleTime) formSingleTime.value = t;
                list.remove();
            });
            list.appendChild(opt);
        });

        input.parentNode.appendChild(list);
    }

    ['singleTimeInput', 'wl_tp_start', 'wl_tp_end'].forEach(id => {
        const elem = document.getElementById(id);
        if (elem) {
            elem.addEventListener('click', e => {
                document.querySelectorAll('.time-dropdown').forEach(d => d.remove());
                createTimeDropdown(id);
            });
        }
    });

    // ===== LESSON TYPE TOGGLE =====
    const lessonTypeBtns = document.querySelectorAll('.one2one-lesson-type-btn');
    const singleSection = document.getElementById('custom-single-lesson');
    const weeklySection = document.getElementById('custom-weekly-lesson');
    const formLessonType = document.getElementById('form_lesson_type');

    function initializeLessonType() {
        const firstBtn = document.querySelector('.one2one-lesson-type-btn[data-type="single"]');
        if (firstBtn) {
            firstBtn.classList.add('selected');
            const radio = firstBtn.querySelector('.one2one-radio');
            if (radio) radio.checked = true;
            if (formLessonType) formLessonType.value = 'single';
        }
        singleSection.style.display = 'block';
        weeklySection.style.display = 'none';
    }

    lessonTypeBtns.forEach(btn => {
        btn.addEventListener('click', () => {
            lessonTypeBtns.forEach(b => {
                b.classList.remove('selected');
                const radio = b.querySelector('.one2one-radio');
                if (radio) radio.checked = false;
            });

            btn.classList.add('selected');
            const radioInput = btn.querySelector('.one2one-radio');
            if (radioInput) {
                radioInput.checked = true;
                if (formLessonType) formLessonType.value = radioInput.value;
            }

            switch (btn.dataset.type) {
                case 'single':
                    singleSection.style.display = 'block';
                    weeklySection.style.display = 'none';
                    break;
                case 'weekly':
                    singleSection.style.display = 'none';
                    weeklySection.style.display = 'block';
                    break;
            }
        });
    });

    initializeLessonType();

    // ===== STUDENT SELECTION =====
    document.addEventListener('click', (e) => {
        const studentItem = e.target.closest('.one2one-student-list-item-class');
        if (studentItem && !studentItem.hasAttribute('aria-disabled')) {
            document.querySelectorAll('.one2one-student-list-item-class').forEach(i =>
                i.classList.remove('selected')
            );
            studentItem.classList.add('selected');

            const studentId = studentItem.dataset.userid;
            const studentName = studentItem.dataset.name;
            const formStudentId = document.getElementById('form_student_id');
            
            if (formStudentId) formStudentId.value = studentId || '';

            const placeholder = document.querySelector('.one2one-add-student-placeholder');
            if (placeholder && studentName) {
                placeholder.textContent = studentName;
                placeholder.style.color = '#232323';
            }

            const dropdown = document.getElementById('one2oneStudentDropdown');
            if (dropdown) dropdown.style.display = 'none';
        }
    });

    // ===== DURATION SELECTION =====
    const durationDisplay = document.getElementById('durationDropdownDisplay');
    const durationList = document.getElementById('durationDropdownList');
    const formDuration = document.getElementById('form_single_duration');
    
    if (durationDisplay) {
        durationDisplay.addEventListener('click', function(e) {
            e.stopPropagation();
            if (durationList) {
                durationList.style.display = durationList.style.display === 'none' ? 'block' : 'none';
            }
        });
    }

    document.querySelectorAll('.one2one-duration-option').forEach(option => {
        option.addEventListener('click', function(e) {
            e.stopPropagation();
            document.querySelectorAll('.one2one-duration-option').forEach(opt => opt.classList.remove('selected'));
            this.classList.add('selected');
            
            if (durationDisplay) durationDisplay.textContent = this.textContent.trim();
            if (formDuration) formDuration.value = this.dataset.duration || '50';
            if (durationList) durationList.style.display = 'none';
        });
    });

    document.addEventListener('click', function(e) {
        if (!e.target.closest('#durationDropdownWrapper')) {
            if (durationList) durationList.style.display = 'none';
        }
    });

    // ===== SINGLE LESSON DATE CALENDAR PICKER =====
    (function initSingleLessonCalendar() {
        const customDateDisplay = document.getElementById('customDateDropdownDisplay');
        const calendarBackdrop = document.getElementById('calendarModalBackdrop');
        const calendarPrevBtn = document.getElementById('calendarPrevMonth');
        const calendarNextBtn = document.getElementById('calendarNextMonth');
        const calendarDoneBtn = document.getElementById('calendarDoneBtn');
        const calendarMonthYear = document.getElementById('calendarMonthYear');
        const calendarDaysGrid = document.getElementById('calendarDaysGrid');
        const formSingleDate = document.getElementById('form_single_date');

        if (!customDateDisplay || !calendarBackdrop) return;

        let currentDate = new Date();
        let viewYear = currentDate.getFullYear();
        let viewMonth = currentDate.getMonth();
        let selectedDate = new Date(currentDate);

        function parseCurrentDate() {
            const dateText = document.getElementById('selectedDateText');
            if (dateText && dateText.dataset.fullDate) {
                try {
                    const dateStr = dateText.dataset.fullDate;
                    const parts = dateStr.split('-');
                    if (parts.length === 3) {
                        const year = parseInt(parts[0]);
                        const month = parseInt(parts[1]) - 1;
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

        customDateDisplay.addEventListener('click', () => {
            parseCurrentDate();
            renderSingleCalendar();
            calendarBackdrop.style.display = 'flex';
        });

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

        if (calendarDoneBtn) {
            calendarDoneBtn.addEventListener('click', () => {
                const dateText = document.getElementById('selectedDateText');
                if (dateText) {
                    const formatted = selectedDate.toLocaleDateString('en-US', {
                        weekday: 'short',
                        month: 'short',
                        day: 'numeric'
                    });
                    dateText.textContent = formatted;

                    const year = selectedDate.getFullYear();
                    const month = String(selectedDate.getMonth() + 1).padStart(2, '0');
                    const day = String(selectedDate.getDate()).padStart(2, '0');
                    const fullDate = `${year}-${month}-${day}`;
                    
                    dateText.dataset.fullDate = fullDate;
                    if (formSingleDate) formSingleDate.value = fullDate;
                }
                calendarBackdrop.style.display = 'none';
            });
        }

        calendarBackdrop.addEventListener('click', (e) => {
            if (e.target === calendarBackdrop) {
                calendarBackdrop.style.display = 'none';
            }
        });

        function renderSingleCalendar() {
            const monthNames = ["January", "February", "March", "April", "May", "June",
                "July", "August", "September", "October", "November", "December"];
            if (calendarMonthYear) {
                calendarMonthYear.textContent = monthNames[viewMonth] + " " + viewYear;
            }

            if (calendarDaysGrid) {
                calendarDaysGrid.innerHTML = '';

                const firstDay = new Date(viewYear, viewMonth, 1).getDay();
                const offset = (firstDay + 6) % 7;
                const daysInMonth = new Date(viewYear, viewMonth + 1, 0).getDate();

                for (let i = 0; i < offset; i++) {
                    const emptyDiv = document.createElement('div');
                    emptyDiv.className = 'calendar-modal-day inactive';
                    calendarDaysGrid.appendChild(emptyDiv);
                }

                for (let d = 1; d <= daysInMonth; d++) {
                    const dateDiv = document.createElement('div');
                    dateDiv.className = 'calendar-modal-day';
                    dateDiv.textContent = d;

                    const isSel = d === selectedDate.getDate() &&
                        viewMonth === selectedDate.getMonth() &&
                        viewYear === selectedDate.getFullYear();

                    if (isSel) {
                        dateDiv.classList.add('selected');
                    }

                    dateDiv.addEventListener('click', function() {
                        if (this.classList.contains('inactive')) return;
                        document.querySelectorAll('.calendar-modal-day').forEach(day => day.classList.remove('selected'));
                        this.classList.add('selected');
                        selectedDate = new Date(viewYear, viewMonth, d, 12, 0, 0);
                    });

                    calendarDaysGrid.appendChild(dateDiv);
                }
            }
        }
    })();

    // ===== FORM SUBMISSION HANDLER =====
    const form = document.getElementById('one2oneClassForm');
    if (form) {
        form.addEventListener('submit', async function(e) {
            e.preventDefault();

            const loader = document.getElementById('loader');
            if (loader) loader.style.display = 'flex';

            try {
                // Step 1: Validate teacher
                if (!validateTeacherSelection()) {
                    throw new Error('Please select a teacher');
                }

                // Step 2: Validate student
                if (!validateStudentSelection()) {
                    throw new Error('Please select a student');
                }

                // Step 3: Validate lesson type
                if (!validateLessonType()) {
                    throw new Error('Please select a lesson type');
                }

                // Step 4: Get lesson type and validate accordingly
                const lessonType = formLessonType?.value || 'single';
                const formData = {
                    teacher: {
                        id: document.getElementById('form_teacher_id').value,
                        name: document.getElementById('calendar_admin_details_create_cohort_class_tab_current_label')?.textContent.trim() || 'Unknown Teacher',
                        avatar: document.getElementById('calendar_admin_details_create_cohort_class_tab_trigger')?.dataset.img || null
                    },
                    student: {
                        id: document.getElementById('form_student_id').value,
                        name: document.querySelector('.one2one-student-list-item-class.selected')?.dataset.name || 'No student selected'
                    },
                    lessonType: lessonType,
                    timestamp: Math.floor(Date.now() / 1000)
                };

                // Step 5: Build lesson-specific data using switch case
                switch (lessonType) {
                    case 'single':
                        if (!validateSingleLesson()) {
                            throw new Error('Please complete all single lesson fields');
                        }
                        formData.singleLesson = {
                            duration: document.getElementById('form_single_duration').value,
                            date: document.getElementById('form_single_date').value,
                            dateFull: document.getElementById('selectedDateText')?.dataset.fullDate || '',
                            time: document.getElementById('form_single_time').value,
                            durationMinutes: parseInt(document.getElementById('form_single_duration').value) || 50
                        };
                        break;

                    case 'weekly':
                        if (!validateWeeklyLesson()) {
                            throw new Error('Please complete all weekly lesson fields');
                        }
                        
                        const dayMap = {
                            'S': 'Sun', 'M': 'Mon', 'T': 'Tue', 'W': 'Wed',
                            'Th': 'Thu', 'F': 'Fri', 'Sa': 'Sat'
                        };
                        const selectedDays = [];

                        document.querySelectorAll('.wl_scroll_widget.selected').forEach(w => {
                            const rawDay = w.querySelector('.wl_widget_text')?.textContent || '';
                            const start = w.querySelector('.wl_widget_hm.s')?.textContent || '';
                            const end = w.querySelector('.wl_widget_hm.e')?.textContent || '';
                            const p1 = w.querySelector('.wl_widget_period.sp')?.textContent || '';
                            const p2 = w.querySelector('.wl_widget_period.ep')?.textContent || '';
                            const day = dayMap[rawDay] || rawDay;

                            if (day && start && end) {
                                selectedDays.push({
                                    day,
                                    startTime: `${start} ${p1}`,
                                    endTime: `${end} ${p2}`,
                                    start24: convertTo24Hour(`${start} ${p1}`),
                                    end24: convertTo24Hour(`${end} ${p2}`)
                                });
                            }
                        });

                        const endOption = document.querySelector('input[name="wl_end_option"]:checked')?.value || 'never';
                        formData.weeklyLesson = {
                            startDate: document.getElementById('wl_start_date_text')?.dataset?.fullDate || '',
                            startDateUnix: Math.floor(new Date(document.getElementById('wl_start_date_text')?.dataset?.fullDate || document.getElementById('wl_start_date_text')?.textContent).getTime() / 1000),
                            interval: parseInt(document.getElementById('wl_interval_display')?.textContent.trim() || '1'),
                            period: document.getElementById('wl_period_display')?.textContent.trim() || 'Week',
                            endOption: endOption,
                            endsOn: document.getElementById('wl_end_date_btn')?.dataset?.fullDate || 'Never',
                            endsOnUnix: document.getElementById('wl_end_on').checked ?
                                Math.floor(new Date(document.getElementById('wl_end_date_btn')?.dataset?.fullDate || document.getElementById('wl_end_date_btn')?.textContent).getTime() / 1000) : null,
                            occurrences: parseInt(document.getElementById('wl_occ_display')?.textContent.replace('occurrences', '').trim() || '13'),
                            days: selectedDays
                        };
                        break;

                    default:
                        throw new Error('Invalid lesson type');
                }

                // Step 6: Submit to backend
                const courseId = parseInt(form?.dataset?.courseid || '0', 10);
                const topicId = parseInt(form?.dataset?.topicid || '0', 10);

                const url = (window.M?.cfg?.wwwroot || '') + '/local/customplugin/ajax/schedule_one2one.php';
                const payload = {
                    sesskey: window.M?.cfg?.sesskey || '',
                    courseid: courseId,
                    topicid: topicId,
                    data: formData
                };

                const res = await fetch(url, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json'
                    },
                    credentials: 'same-origin',
                    body: JSON.stringify(payload)
                });

                const json = await res.json();

                if (!res.ok || !json || !json.success) {
                    const msg = json?.message || json?.error || (res.status + ' ' + res.statusText);
                    throw new Error(msg);
                }

                showToastCreateClass('✅ 1:1 Class scheduled successfully!', 'success');

                if (window.refetchCustomPluginData) {
                    window.refetchCustomPluginData('create-one2one');
                } else if (window.fetchCalendarEvents) {
                    window.fetchCalendarEvents();
                }

                setTimeout(() => {
                    form.reset();
                    resetOne2OneForm();
                    resetWeeklyLesson();
                }, 1000);

            } catch (error) {
                console.error('❌ Schedule error:', error);
                showToastCreateClass('❌ ' + error.message, 'error');
            } finally {
                if (loader) loader.style.display = 'none';
            }
        });
    }

    // Helper functions
    function convertTo24Hour(time12h) {
        if (!time12h) return null;
        const [time, period] = time12h.split(' ');
        let [hours, minutes] = time.split(':');
        hours = parseInt(hours);
        minutes = parseInt(minutes);
        if (period.toUpperCase() === 'PM' && hours < 12) hours += 12;
        if (period.toUpperCase() === 'AM' && hours === 12) hours = 0;
        return `${String(hours).padStart(2, '0')}:${String(minutes).padStart(2, '0')}`;
    }

    function resetWeeklyLesson() {
        const today = new Date();
        const months = ["Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec"];
        document.getElementById('wl_start_date_text').textContent =
            `${months[today.getMonth()]} ${today.getDate()}, ${today.getFullYear()}`;
        document.getElementById('wl_end_date_btn').textContent =
            `${months[today.getMonth() + 1 > 11 ? 0 : today.getMonth() + 1]} ${today.getDate()}, ${today.getFullYear()}`;
        document.getElementById('wl_interval_display').textContent = '1';
        document.getElementById('wl_period_display').textContent = 'Week';
        document.getElementById('wl_end_never').checked = true;
        document.getElementById('wl_end_date_btn').disabled = true;
        document.getElementById('wl_occ_minus').disabled = true;
        document.getElementById('wl_occ_plus').disabled = true;
        document.getElementById('wl_occ_display').textContent = '13 occurrences';
        document.querySelectorAll('.wl_scroll_widget').forEach(w => {
            w.classList.remove('selected', 'field-error');
            w.removeAttribute('aria-pressed');
            w.querySelector('.wl_widget_button').classList.remove('has-time');
            const timeEl = w.querySelector('.wl_widget_time');
            if (timeEl) timeEl.remove();
        });
    }

    function resetOne2OneForm() {
        const teacherTrigger = document.getElementById('calendar_admin_details_create_cohort_class_tab_trigger');
        const teacherImg = document.getElementById('calendar_admin_details_create_cohort_class_tab_current_img');
        const teacherLabel = document.getElementById('calendar_admin_details_create_cohort_class_tab_current_label');

        if (teacherTrigger) {
            delete teacherTrigger.dataset.userid;
            delete teacherTrigger.dataset.name;
            delete teacherTrigger.dataset.img;
        }
        if (teacherImg) {
            teacherImg.src = "https://images.unsplash.com/photo-1544005313-94ddf0286df2?q=80&w=200&auto=format&fit=crop";
        }
        if (teacherLabel) {
            teacherLabel.textContent = "Daniela";
        }

        document.querySelectorAll('.one2one-student-list-item-class').forEach(item => {
            item.classList.remove('selected');
        });
        const placeholder = document.querySelector('.one2one-add-student-placeholder');
        if (placeholder) {
            placeholder.textContent = "Add student";
            placeholder.style.color = "#aaa";
        }

        document.querySelectorAll('.one2one-lesson-type-btn').forEach(btn => {
            btn.classList.remove('selected');
        });
        document.querySelector('.one2one-lesson-type-btn[data-type="single"]').classList.add('selected');

        document.getElementById('custom-single-lesson').style.display = 'block';
        document.getElementById('custom-weekly-lesson').style.display = 'none';

        const today = new Date();
        const monthNames = ["Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec"];
        const dayNames = ["Sun", "Mon", "Tue", "Wed", "Thu", "Fri", "Sat"];
        document.getElementById('selectedDateText').textContent =
            `${dayNames[today.getDay()]}, ${monthNames[today.getMonth()]}${today.getDate()}`;
        document.getElementById('selectedDateText').dataset.fullDate = today.toISOString().split('T')[0];

        const timeInput = document.querySelector('.time-input');
        if (timeInput) timeInput.value = '10:30 am';
    }

    // ===== SEARCH FILTERS =====
    const teacherSearchInput = document.getElementById('teacherSearchInput');
    if (teacherSearchInput) {
        teacherSearchInput.addEventListener('input', function() {
            const filter = this.value.toLowerCase();
            document.querySelectorAll('#calendar_admin_details_create_cohort_class_tab_list .calendar_admin_details_create_cohort_class_tab_item')
                .forEach(item => {
                    const name = (item.dataset.name || '').toLowerCase();
                    item.style.display = name.includes(filter) ? '' : 'none';
                });
        });
    }

    const studentSearchInput = document.getElementById('studentSearchInput');
    if (studentSearchInput) {
        studentSearchInput.addEventListener('input', function() {
            const filter = this.value.toLowerCase();
            document.querySelectorAll('#one2oneStudentDropdown .one2one-student-list-item-class')
                .forEach(item => {
                    const name = (item.dataset.name || '').toLowerCase();
                    item.style.display = name.includes(filter) ? '' : 'none';
                });
        });
    }
});
</script>
