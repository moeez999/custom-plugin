<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Cohort Modal with Calendar Picker</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="../css/calendar_admin_details_create_cohort.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="js/toast_utils.js"></script>
    <script src="js/modal_utils.js"></script>
</head>

<body>
    <div id="loader"
        style=" display:none; position:fixed; top:0; left:0; width:100%; height:100%; background:rgba(255,255,255,0.6); z-index:9999; align-items:center; justify-content:center; ">
        <div class="loader"></div>
    </div>
    <!-- Toast Notification -->
    <div id="toastNotificationForCreateCohort" style="display:none; position:fixed; top:30px; right:30px; 
         background:#000; color:#fff; padding:16px 24px; 
         border-radius:8px; font-size:1rem; 
         box-shadow:0 4px 12px rgba(0,0,0,0.3);
         z-index:99999; opacity:0; transition:opacity .3s, transform .3s;
         transform:translateY(20px);">
        Cohort created successfully!
    </div>
    <div id="calendar_admin_details_create_cohort_modal_backdrop">
        <div id="calendar_admin_details_create_cohort_modal">
            <span class="calendar_admin_details_create_cohort_close">&times;</span>
            <h2>Management</h2>
            <div class="calendar_admin_details_create_cohort_tabs_scroll">
                <div class="calendar_admin_details_create_cohort_tabs">
                    <div class="calendar_admin_details_create_cohort_tab active" data-tab="cohort">Cohort</div>
                    <div class="calendar_admin_details_create_cohort_tab" data-tab="manage">Manage Cohort</div>
                    <div class="calendar_admin_details_create_cohort_tab" data-tab="class">1:1 Class</div>
                    <div class="calendar_admin_details_create_cohort_tab" data-tab="manage_class">Manage 1:1 Class</div>
                    <div class="calendar_admin_details_create_cohort_tab" data-tab="merge">Merge</div>
                    <div class="calendar_admin_details_create_cohort_tab" data-tab="conference">Conference</div>
                    <div class="calendar_admin_details_create_cohort_tab" data-tab="peertalk">Peer Talk</div>
                    <div class="calendar_admin_details_create_cohort_tab" data-tab="addtime">Add Time</div>
                    <div class="calendar_admin_details_create_cohort_tab" data-tab="extraslots">Add Extra Slots</div>
                </div>
            </div>
            <div class="calendar_admin_details_create_cohort_content" id="mainModalContent">
                <div class="calendar_admin_details_create_cohort_row">
                    <div class="w-100">
                        <!-- One row, fixed halves -->
                        <div class="d-flex mb-3" style="gap:16px;">
                            <!-- Left column -->
                            <div class="position-relative" style="flex:1 1 0;max-width:50%;box-sizing:border-box;">
                                <label for="cohortInput" class="form-label"
                                    style="font-weight:500;color:#232323;font-size:1.05rem;display:block;margin-bottom:6px;">
                                    Cohort
                                </label>
                                <!-- Wrap to anchor tooltip below the input -->
                                <div style="position:relative;display:block;">
                                    <input type="text" readonly aria-readonly="true"
                                        class="form-control cohort-tooltip-target" id="cohortInput"
                                        placeholder="XXX-#-#####-###"
                                        style="width:100%;height:50px;border-radius:8px;border:1.5px solid #e3e3e7; font-size:1rem;color:#818191;font-weight:500;background:#fff; letter-spacing:2px;cursor:default;">
                                    <!-- Tooltip: BELOW the field -->
                                    <div class="custom-tooltip"
                                        style="display:none;position:absolute;left:0;top:calc(100% + 8px); background:#111;color:#fff;border-radius:20px;padding:8px 14px; font-size:.95rem;font-weight:500;white-space:nowrap; box-shadow:0 6px 18px rgba(0,0,0,.25);pointer-events:none;z-index:10;">
                                        <span
                                            style="font-size:1.2em;vertical-align:-2px;margin-right:6px;">&#9432;</span>
                                        Start selecting below
                                    </div>
                                </div>
                            </div>
                            <!-- Right column -->
                            <div class="position-relative" style="flex:1 1 0;max-width:50%;box-sizing:border-box;">
                                <label for="cohortShortInput" class="form-label"
                                    style="font-weight:500;color:#232323;font-size:1.05rem;display:block;margin-bottom:6px;">
                                    Cohort's Short Name
                                </label>
                                <div style="position:relative;display:block;">
                                    <input type="text" readonly aria-readonly="true"
                                        class="form-control cohort-tooltip-target" id="cohortShortInput"
                                        placeholder="XX#"
                                        style="width:100%;height:50px;border-radius:8px;border:1.5px solid #e3e3e7; font-size:1rem;color:#818191;font-weight:500;background:#fff; letter-spacing:2px;cursor:default;">
                                    <!-- Tooltip: BELOW the field -->
                                    <div class="custom-tooltip"
                                        style="display:none;position:absolute;left:0;top:calc(100% + 8px); background:#111;color:#fff;border-radius:20px;padding:8px 14px; font-size:.95rem;font-weight:500;white-space:nowrap; box-shadow:0 6px 18px rgba(0,0,0,.25);pointer-events:none;z-index:10;">
                                        <span
                                            style="font-size:1.2em;vertical-align:-2px;margin-right:6px;">&#9432;</span>
                                        Start selecting below
                                    </div>
                                </div>
                            </div>
                        </div>
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
                    <button type="button" class="calendar_admin_details_create_cohort_remove"
                        aria-label="Remove last teacher">
                        <!-- trash icon -->
                        <svg viewBox="0 0 24 24" width="20" height="20" fill="currentColor" aria-hidden="true">
                            <path
                                d="M9 3h6a1 1 0 0 1 1 1v1h4v2h-1v12a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V7H4V5h4V4a1 1 0 0 1 1-1Zm1 2v0h4V4h-4v1Zm-2 2v12h8V7H8Zm2 2h2v8h-2V9Zm4 0h2v8h-2V9Z" />
                        </svg>
                    </button>
                </div>
                <!-- 2-up teacher carousel -->
                <div class="calendar_admin_details_create_cohort_row" id="teacherBlocks">
                    <!-- Teacher 1 -->
                    <div class="teacher-block" data-teacher="1">
                        <div>
                            <?php 
                           require_once(__DIR__ . '/../../config.php');
                           require_login();
                           global $DB, $PAGE, $OUTPUT;
                           
                           /** Collect unique teacher user IDs from cohorts */
                           $userids = $DB->get_fieldset_sql("
                               SELECT DISTINCT uid FROM (
                                   SELECT cohortmainteacher AS uid FROM {cohort} WHERE cohortmainteacher IS NOT NULL AND cohortmainteacher > 0
                                   UNION
                                   SELECT cohortguideteacher AS uid FROM {cohort} WHERE cohortguideteacher IS NOT NULL AND cohortguideteacher > 0
                               ) t
                           ");
                           
                           /** Fetch user records (not deleted/suspended) */
                           $teachers = [];
                           if ($userids) {
                               list($insql, $params) = $DB->get_in_or_equal($userids, SQL_PARAMS_NAMED);
                               $fields = "id, firstname, lastname, picture, imagealt, firstnamephonetic, lastnamephonetic, middlename, alternatename";
                               $teachers = $DB->get_records_select('user', "id $insql AND deleted = 0 AND suspended = 0", $params, 'firstname ASC, lastname ASC', $fields);
                           }
                           
                           /** Build reusable <li> HTML */
                           $teachers_li_html = '';
                           if ($teachers) {
                               foreach ($teachers as $t) {
                                   $pic = new user_picture($t);
                                   $pic->size = 50;
                                   $url = $pic->get_url($PAGE)->out(false);
                                   $name = fullname($t, true);
                                   $teachers_li_html .= '<li class="teacher-option" data-userid="'.(int)$t->id.'" data-name="'.s($name).'" data-pic="'.s($url).'">'
                                       .'<img src="'.s($url).'" class="calendar_admin_details_create_cohort_teacher_avatar" alt="'.s($name).'">'
                                       .'<span style="margin-left:10px;">'.format_string($name).'</span>'
                                       .'</li>';
                               }
                           } else {
                               $teachers_li_html = '<li class="muted">No teachers found</li>';
                           }
                           ?>
                            <div class="calendar_admin_details_create_cohort_teacher_dropdown_wrapper">
                                <label>Teacher 1</label>
                                <div class="calendar_admin_details_create_cohort_teacher_btn" id="teacher1DropdownBtn">
                                    <span class="label">Select Teacher</span>
                                    <img src="./img/dropdown-arrow-down.svg" alt="">
                                </div>
                                <!-- store the selected teacher id for this block -->
                                <input type="hidden" name="teacher1_userid" id="teacher1UserId" value="">
                                <div class="calendar_admin_details_create_cohort_teacher_list"
                                    id="teacher1DropdownList">
                                    <ul>
                                        <?php echo $teachers_li_html; ?>
                                    </ul>
                                </div>
                            </div>
                            <script>
                            (function() {
                                // For every teacher dropdown wrapper on the page
                                document.querySelectorAll(
                                    '.calendar_admin_details_create_cohort_teacher_dropdown_wrapper').forEach(
                                    function(wrapper) {
                                        const btn = wrapper.querySelector(
                                            '.calendar_admin_details_create_cohort_teacher_btn');
                                        const list = wrapper.querySelector(
                                            '.calendar_admin_details_create_cohort_teacher_list');
                                        const label = btn.querySelector('.label') ||
                                            btn; // fallback if label span missing
                                        const hidden = wrapper.querySelector('input[type="hidden"]');

                                        // Open/close the list
                                        btn.addEventListener('click', function(e) {
                                            if (!e.target.closest(
                                                    '.calendar_admin_details_create_cohort_teacher_list'
                                                )) {
                                                list.classList.toggle('open');
                                            }
                                        });

                                        // Close when clicking outside this wrapper
                                        document.addEventListener('click', function(e) {
                                            if (!wrapper.contains(e.target)) list.classList.remove(
                                                'open');
                                        });

                                        // Select a teacher
                                        list.addEventListener('click', function(e) {
                                            const li = e.target.closest('li.teacher-option');
                                            if (!li) return;
                                            // Update label text (you can also inject the avatar if you want)
                                            label.textContent = li.dataset.name;
                                            // Save selected id
                                            if (hidden) hidden.value = li.dataset.userid;
                                            // Close
                                            list.classList.remove('open');
                                        });
                                    });
                            })();
                            </script>
                            <div class="calendar_admin_details_create_cohort_class_dropdown_wrapper">
                                <label>Class Name</label>
                                <div class="calendar_admin_details_create_cohort_class_btn" id="className1DropdownBtn">
                                    Select Class
                                    <img src="./img/dropdown-arrow-down.svg" alt="">
                                </div>
                                <div class="calendar_admin_details_create_cohort_class_list"
                                    id="className1DropdownList">
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
                                    <span>Class Schedule</span>
                                </div>
                                <button type="button" class="cohort_schedule_btn">
                                    Does not repeat
                                    <span class="cohort_schedule_arrow"><img src="./img/dropdown-arrow-down.svg"
                                            alt=""></span>
                                </button>
                            </div>
                            <div class="calendar_admin_details_cohort_tab_timezone_wrapper" style="margin-top:10px;">
                                <label class="calendar_admin_details_cohort_tab_timezone_label">Event time zone</label>
                                <div class="calendar_admin_details_cohort_tab_timezone_dropdown"
                                    id="eventTimezoneDropdown">
                                    <span id="eventTimezoneSelected">(GMT-05:00) Eastern</span>
                                    <img class="calendar_admin_details_cohort_tab_timezone_arrow"
                                        src="./img/dropdown-arrow-down.svg" alt="">
                                    <div class="calendar_admin_details_cohort_tab_timezone_list"
                                        id="eventTimezoneDropdownList">
                                        <ul>
                                            <li>(GMT-12:00) International Date Line West</li>
                                            <li>(GMT-11:00) Midway Island, Samoa</li>
                                            <li>(GMT-10:00) Hawaii</li>
                                            <li>(GMT-09:00) Alaska</li>
                                            <li>(GMT-08:00) Pacific Time (US & Canada)</li>
                                            <li>(GMT-07:00) Mountain Time (US & Canada)</li>
                                            <li>(GMT-06:00) Central Time (US & Canada)</li>
                                            <li>(GMT-05:00) Eastern Time (US & Canada)</li>
                                            <li>(GMT+00:00) London</li>
                                            <li>(GMT+01:00) Berlin, Paris</li>
                                            <li>(GMT+03:00) Moscow, Nairobi</li>
                                            <li>(GMT+05:00) Pakistan</li>
                                            <li>(GMT+05:30) India</li>
                                            <li>(GMT+08:00) Beijing, Singapore</li>
                                            <li>(GMT+09:00) Tokyo, Seoul</li>
                                            <li>(GMT+10:00) Sydney</li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                            <div class="calendar_admin_details_create_cohort_selectDate_left">
                                <label>Start On</label>
                                <button class="conference_modal_date_btn">Select Date</button>
                            </div>
                            <div class="create_new_cohort_tab_select_color_left_row">
                                <label class="create_new_cohort_tab_select_color_left_label">Find a time</label>
                                <div class="create_new_cohort_tab_select_color_left_dropdown"
                                    id="createNewCohortSelectColorLeft">
                                    <span class="create_new_cohort_tab_select_color_left_selected"
                                        id="createNewCohortSelectedColorLeft">
                                        <span class="create_new_cohort_tab_select_color_left_circle"
                                            style="background:#1649c7"></span>
                                    </span>
                                    <img class="calendar_admin_details_cohort_tab_timezone_arrow"
                                        src="./img/dropdown-arrow-down.svg" alt="">
                                    <div class="create_new_cohort_tab_select_color_left_list"
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
                            <div class="calendar_admin_details_create_cohort_teacher_dropdown_wrapper"
                                id="teacher2Wrapper">
                                <label>Teacher 2</label>
                                <div class="calendar_admin_details_create_cohort_teacher_btn" id="teacher2DropdownBtn">
                                    <span class="label">Select Teacher</span>
                                    <img src="./img/dropdown-arrow-down.svg" alt="">
                                </div>
                                <!-- store the selected Teacher 2 user id -->
                                <input type="hidden" name="teacher2_userid" id="teacher2UserId" value="">
                                <div class="calendar_admin_details_create_cohort_teacher_list"
                                    id="teacher2DropdownList">
                                    <ul>
                                        <?php echo $teachers_li_html; ?>
                                    </ul>
                                </div>
                            </div>
                            <script>
                            $('#teacher2DropdownList').on('click', 'li.teacher-option', function() {
                                $('#teacher2UserId').val($(this).data('userid') || '');
                            });
                            </script>
                            <div class="calendar_admin_details_create_cohort_class_dropdown_wrapper">
                                <label>Class Name</label>
                                <div class="calendar_admin_details_create_cohort_class_btn" id="className2DropdownBtn">
                                    Select Class
                                    <img src="./img/dropdown-arrow-down.svg" alt="">
                                </div>
                                <div class="calendar_admin_details_create_cohort_class_list"
                                    id="className2DropdownList">
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
                                    <span class="cohort_schedule_arrow"><img src="./img/dropdown-arrow-down.svg"
                                            alt=""></span>
                                </button>
                            </div>
                            <div class="calendar_admin_details_cohort_tab_timezone_wrapper_right">
                                <label class="calendar_admin_details_cohort_tab_timezone_label_right">Event time
                                    zone</label>
                                <div class="calendar_admin_details_cohort_tab_timezone_dropdown_right"
                                    id="eventTimezoneDropdownRight">
                                    <span id="eventTimezoneSelectedRight">(GMT+05:00) Pakistan</span>
                                    <img class="calendar_admin_details_cohort_tab_timezone_arrow_right"
                                        src="./img/dropdown-arrow-down.svg" alt="">
                                    <div class="calendar_admin_details_cohort_tab_timezone_list_right"
                                        id="eventTimezoneDropdownListRight">
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
                                <label>End On</label>
                                <button class="conference_modal_date_btn">Select Date</button>
                            </div>
                            <div class="create_new_cohort_tab_select_color_right_row">
                                <label class="create_new_cohort_tab_select_color_right_label">Find a time</label>
                                <div class="create_new_cohort_tab_select_color_right_dropdown"
                                    id="createNewCohortSelectColorRight">
                                    <span class="create_new_cohort_tab_select_color_right_selected"
                                        id="createNewCohortSelectedColorRight">
                                        <span class="create_new_cohort_tab_select_color_right_circle"
                                            style="background:#1649c7"></span>
                                    </span>
                                    <img class="calendar_admin_details_cohort_tab_timezone_arrow"
                                        src="./img/dropdown-arrow-down.svg" alt="">
                                    <div class="create_new_cohort_tab_select_color_right_list"
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
                <button class="calendar_admin_details_create_cohort_btn">Create Cohort</button>
            </div>
            <script>
            (function() {
                // =========================
                // Utilities
                // =========================
                const $ = (s, r = document) => r.querySelector(s);
                const $$ = (s, r = document) => Array.from(r.querySelectorAll(s));
                const txt = (s, r = document) => (r.querySelector(s)?.textContent ?? '').trim();
                const val = (s, r = document) => (r.querySelector(s)?.value ?? '').trim();
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
                const mins = (t) => (t && Number.isFinite(t.hour) && Number.isFinite(t.minute)) ? (t.hour * 60 + t
                    .minute) : null;
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
                    // Anchor at local noon so converting between timezones
                    // (e.g. to America/New_York) does not roll the calendar
                    // date backward due to midnight offsets.
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

                // =========================
                // Teacher pickers & class dropdowns
                // =========================
                $$('.calendar_admin_details_create_cohort_teacher_dropdown_wrapper').forEach((wrapper) => {
                    const btn = wrapper.querySelector('.calendar_admin_details_create_cohort_teacher_btn');
                    const list = wrapper.querySelector(
                        '.calendar_admin_details_create_cohort_teacher_list');
                    const hid = wrapper.querySelector('input[type="hidden"]');
                    if (!btn || !list) return;

                    btn.addEventListener('click', (e) => {
                        if (!e.target.closest(
                                '.calendar_admin_details_create_cohort_teacher_list')) {
                            list.classList.toggle('open');
                        }
                    });

                    document.addEventListener('click', (e) => {
                        if (!wrapper.contains(e.target)) list.classList.remove('open');
                    });

                    list.addEventListener('click', (e) => {
                        const li = e.target.closest('li.teacher-option');
                        if (!li) return;
                        const full = (li.dataset.name || '').trim();
                        const parts = full.split(/\s+/);
                        const short = parts[parts.length - 1] || full;
                        const pic = li.dataset.pic || '';
                        const uid = li.dataset.userid || '';
                        if (hid) hid.value = uid;
                        const svg = btn.querySelector('svg')?.outerHTML || '';
                        const avatar = pic ?
                            `<img class="calendar_admin_details_create_cohort_teacher_avatar" src="${pic}" alt="${full}">` :
                            (btn.querySelector('img')?.outerHTML || '');
                        btn.innerHTML =
                            `${avatar}<span class="label" data-fullname="${full}" style="margin-left:10px;">${short}</span>${svg}`;
                        list.classList.remove('open');
                    });
                });

                $$('.calendar_admin_details_create_cohort_class_dropdown_wrapper').forEach((wrap) => {
                    const btn = wrap.querySelector('.calendar_admin_details_create_cohort_class_btn');
                    const list = wrap.querySelector('.calendar_admin_details_create_cohort_class_list');
                    if (!btn || !list) return;

                    btn.addEventListener('click', () => list.classList.toggle('open'));
                    document.addEventListener('click', (e) => {
                        if (!wrap.contains(e.target)) list.classList.remove('open');
                    });

                    list.addEventListener('click', (e) => {
                        const li = e.target.closest('li');
                        if (!li) return;

                        const text = li.textContent.trim() || ''; // fallback
                        const icon =
                            '<img src="./img/dropdown-arrow-down.svg" alt="">';

                        btn.innerHTML = `${text} ${icon}`.trim();
                        list.classList.remove('open');
                    });
                });

                // =========================
                // Colors
                // =========================
                const bindColorPicker = (dropdownSel, listSel, circleSel) => {
                    const dd = $(dropdownSel);
                    const list = $(listSel);
                    const circle = $(circleSel);
                    if (!dd || !list || !circle) return;

                    dd.addEventListener('click', () => list.classList.toggle('open'));
                    document.addEventListener('click', (e) => {
                        if (!dd.parentElement.contains(e.target)) list.classList.remove('open');
                    });

                    list.addEventListener('click', (e) => {
                        const li = e.target.closest('li[data-color]');
                        if (!li) return;
                        circle.style.background = li.dataset.color;
                        list.classList.remove('open');
                    });
                };

                bindColorPicker('#createNewCohortSelectColorLeft', '#createNewCohortColorListLeft',
                    '#createNewCohortSelectedColorLeft .create_new_cohort_tab_select_color_left_circle');
                bindColorPicker('#createNewCohortSelectColorRight', '#createNewCohortColorListRight',
                    '#createNewCohortSelectedColorRight .create_new_cohort_tab_select_color_right_circle');

                // =========================
                // Custom Recurrence modal
                // =========================
                const modal = $('.calendar_admin_details_create_cohort_customrec_modal');
                const stateByTeacher = new Map();

                const widgetSelected = (w) => w.classList.contains('selected') || w.getAttribute('aria-pressed') ===
                    'true';
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

                const readModal = () => {
                    const interval = parseInt($('#customrec_interval')?.textContent || '1', 10) || 1;
                    const period = $('#customrec_period_val')?.textContent?.trim() || 'Week';
                    const days = [];
                    const perDayTimes = {};

                    $$('#weekly_scroll_widgets .scroll-widget', modal).forEach(w => {
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

                const applyStateToModal = (state) => {
                    if (!modal || !state) return;

                    const span = $('#customrec_interval', modal);
                    if (span) span.textContent = String(state.interval || 1);

                    const pspan = $('#customrec_period_val', modal);
                    if (pspan && state.period) pspan.textContent = state.period;

                    $$('#weekly_scroll_widgets .scroll-widget', modal).forEach(w => {
                        w.classList.remove('selected');
                        w.setAttribute('aria-pressed', 'false');
                    });

                    (state.days || []).forEach(d3 => {
                        const idx = DAY3.indexOf(d3);
                        if (idx === -1) return;
                        const w = $(`.scroll-widget[data-key="${idx}"]`, modal);
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

                let currentTeacherIdx = null;

                document.addEventListener('click', (e) => {
                    const t1Btn = e.target.closest('.teacher-block[data-teacher="1"] .cohort_schedule_btn');
                    const t2Btn = e.target.closest('.teacher-block[data-teacher="2"] .cohort_schedule_btn');
                    if (!t1Btn && !t2Btn) return;

                    currentTeacherIdx = t1Btn ? 1 : 2;
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
                    modal?.classList?.add('open');
                    modal?.setAttribute('aria-hidden', 'false');
                }, true);

                const closeModal = () => {
                    modal?.classList?.remove('open');
                    modal?.setAttribute('aria-hidden', 'true');
                };

                document.addEventListener('click', (e) => {
                    if (e.target.closest('#customrec_cancel') || e.target.closest(
                            '.calendar_admin_details_create_cohort_close_sub.customrec')) {
                        closeModal();
                    }
                });



                $('#customrec_minus')?.addEventListener('click', () => {
                    const span = $('#customrec_interval');
                    if (!span) return;
                    const v = Math.max(1, (parseInt(span.textContent || '1', 10) || 1) - 1);
                    span.textContent = String(v);
                });

                $('#customrec_plus')?.addEventListener('click', () => {
                    const span = $('#customrec_interval');
                    if (!span) return;
                    const v = (parseInt(span.textContent || '1', 10) || 1) + 1;
                    span.textContent = String(v);
                });

                const periodBtn = $('#customrec_period_btn');
                const periodList = $('#customrec_period_list');
                periodBtn?.addEventListener('click', () => periodList?.classList?.toggle('open'));

                periodList?.addEventListener('click', (e) => {
                    const opt = e.target.closest('.customrec_option');
                    if (!opt) return;
                    $('#customrec_period_val').textContent = opt.textContent.trim();
                    periodList.classList.remove('open');

                    const showMonthly = /month/i.test(opt.textContent);
                    $('#customrec_monthly_picker_container').style.display = showMonthly ? '' : 'none';
                });

                document.addEventListener('click', (e) => {
                    if (!periodBtn?.parentElement?.contains(e.target)) periodList?.classList?.remove(
                        'open');
                });

                $('#weekly_scroll_widgets')?.addEventListener('click', (e) => {
                    const w = e.target.closest('.scroll-widget');
                    if (!w) return;
                    if (!e.target.closest('.scroll-widget__button')) {
                        const sel = widgetSelected(w);
                        w.classList.toggle('selected', !sel);
                        w.setAttribute('aria-pressed', String(!sel));
                    }
                });

                $('#customrec_done')?.addEventListener('click', () => {
                    if (currentTeacherIdx == null) return;
                    const st = readModal();
                    const periodLower = (st.period || 'Week').toLowerCase();

                    if (periodLower.includes('week') && st.days.length) {
                        for (const d of st.days) {
                            const td = st.perDayTimes[d] || {};
                            if (!td.startLabel || !td.endLabel) {
                                alert(`Please set start & end time for ${d}.`);
                                return;
                            }
                            const s = mins(td.start24),
                                e = mins(td.end24);
                            if (s != null && e != null && e <= s) {
                                alert(`${d}: End time must be after start time.`);
                                return;
                            }
                        }
                    }

                    stateByTeacher.set(currentTeacherIdx, st);
                    const block = document.querySelector(
                        `.teacher-block[data-teacher="${currentTeacherIdx}"]`);
                    const btn = block?.querySelector('.cohort_schedule_box .cohort_schedule_btn');
                    if (btn) {
                        const svg = btn.querySelector('.cohort_schedule_arrow')?.outerHTML ||
                            '<span class="cohort_schedule_arrow"><img src="./img/dropdown-arrow-down.svg" alt=""></span>';
                        btn.innerHTML = `${labelFromState(st)} ${svg}`;
                    }
                    closeModal();
                });

                // =========================
                // Read Teacher
                // =========================
                const readTeacher = (teacherIdx) => {
                    const root = document.querySelector(`.teacher-block[data-teacher="${teacherIdx}"]`) ||
                        document;
                    const idVal = teacherIdx === 1 ? val('#teacher1UserId') : val('#teacher2UserId');

                    let fullName; {
                        const sel = teacherIdx === 1 ? '#teacher1DropdownBtn .label' :
                            '#teacher2DropdownBtn .label';
                        const labelEl = document.querySelector(sel);
                        fullName = (labelEl?.dataset?.fullname || '').trim();
                        if (!fullName) {
                            const listSel = teacherIdx === 1 ? '#teacher1DropdownList' :
                                '#teacher2DropdownList';
                            const li = document.querySelector(
                                `${listSel} li.teacher-option[data-userid="${idVal}"]`);
                            fullName = li?.dataset?.name?.trim() || '';
                        }
                    }

                    const shortName = (fullName.split(/\s+/).slice(-1)[0] || '');
                    const classBtn = teacherIdx === 1 ? $('#className1DropdownBtn') : $(
                        '#className2DropdownBtn');
                    const className = cleanLbl(classBtn);
                    const classType = inferClassType(className);
                    const tzLabel = teacherIdx === 1 ? txt('#eventTimezoneSelected') : txt(
                        '#eventTimezoneSelectedRight');
                    const tzIANA = tzLabelToIana(tzLabel);

                    const colorSel = teacherIdx === 1 ?
                        '#createNewCohortSelectedColorLeft .create_new_cohort_tab_select_color_left_circle' :
                        '#createNewCohortSelectedColorRight .create_new_cohort_tab_select_color_right_circle';
                    const colorHex = (() => {
                        const node = document.querySelector(colorSel);
                        const rgb = node ? getComputedStyle(node).backgroundColor : '';
                        return rgbToHex(rgb);
                    })();

                    const dateLabel = root.querySelector(
                            '.teacher-block[data-teacher="1"] .conference_modal_date_btn')?.textContent
                        .trim() || '';
                    const endDateLabel = root.querySelector(
                            '.teacher-block[data-teacher="2"] .conference_modal_date_btn')?.textContent
                        .trim() || '';
                    const startDateUnix = parseDateLabelToUnix(dateLabel);
                    const endDateUnix = parseDateLabelToUnix(endDateLabel);

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

                    // BUILD CLEAN SCHEDULE ARRAY
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
                        startDateUnix,
                        endDateLabel,
                        endDateUnix
                    };
                };

                // =========================
                // Validation
                // =========================
                const validate = ({
                    t1,
                    t2
                }) => {
                    const errors = [];

                    if (!val('#cohortInput')) errors.push({
                        msg: 'Cohort is required',
                        node: $('#cohortInput')
                    });
                    if (!val('#cohortShortInput')) errors.push({
                        msg: 'Cohort short name is required',
                        node: $('#cohortShortInput')
                    });

                    const checkTeacher = (t, idx) => {
                        const root = document.querySelector(`.teacher-block[data-teacher="${idx}"]`) ||
                            document;
                        if (!t.id) errors.push({
                            msg: `Select Teacher ${idx}`,
                            node: root.querySelector(
                                '.calendar_admin_details_create_cohort_teacher_btn')
                        });
                        if (!t.className || /select class/i.test(t.className)) errors.push({
                            msg: `Select Class for Teacher ${idx}`,
                            node: root.querySelector(`#className${idx}DropdownBtn`)
                        });
                        if (!t.scheduleLabel) errors.push({
                            msg: `Choose a schedule for Teacher ${idx}`,
                            node: root.querySelector('.cohort_schedule_btn')
                        });
                        // Validate if no days are selected
                        if (t.schedule.type === 'WEEKLY' && (!t.schedule.scheduleArray || t.schedule
                                .scheduleArray.length === 0)) {
                            errors.push({
                                msg: `Teacher ${idx}: Please select at least one day for the schedule.`,
                                node: root.querySelector('.cohort_schedule_btn')
                            });
                        }


                        if (t.schedule.type === 'WEEKLY' && (t.schedule.scheduleArray || []).length) {
                            t.schedule.scheduleArray.forEach(item => {
                                const startTime = parseTime12to24(item.startTime);
                                const endTime = parseTime12to24(item.endTime);
                                const s = mins(startTime),
                                    e = mins(endTime);
                                if (!item.startTime || !item.endTime) {
                                    errors.push({
                                        msg: `Teacher ${idx}: Pick start & end time for ${item.day}`,
                                        node: modal || root
                                    });
                                } else if (s != null && e != null && e <= s) {
                                    errors.push({
                                        msg: `Teacher ${idx}: ${item.day} end time must be after start time`,
                                        node: modal || root
                                    });
                                }
                            });
                        }

                        if (!t.timezoneLabel) errors.push({
                            msg: `Pick event time zone for Teacher ${idx}`,
                            node: idx === 1 ? $('#eventTimezoneDropdown') : $(
                                '#eventTimezoneDropdownRight')
                        });

                        // Check appropriate date field based on teacher index
                        const dateField = idx === 1 ? t.startDateUnix : t.endDateUnix;
                        const dateLabel = idx === 1 ? 'Start' : 'End';
                        const dateBtn = idx === 1 ?
                            root.querySelector(
                                '.teacher-block[data-teacher="1"] .conference_modal_date_btn') :
                            root.querySelector(
                                '.teacher-block[data-teacher="2"] .conference_modal_date_btn');

                        if (!dateField) errors.push({
                            msg: `Select ${dateLabel} Date for Teacher ${idx}`,
                            node: dateBtn
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

                // =========================
                // Payload
                // =========================
                const buildPayload = (t1, t2) => {
                    const main = (t1.classType === 'main') ? t1 : (t2.classType === 'main') ? t2 : t1;
                    const tutor = (main === t1) ? t2 : t1;

                    const cohort = {
                        idNumber: val('#cohortInput') || '',
                        shortName: val('#cohortShortInput') || '',
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

                // =========================
                // Wire Create Cohort
                // =========================
                const createBtn = $('.calendar_admin_details_create_cohort_btn');
                createBtn?.addEventListener('click', (e) => {
                    e.preventDefault();
                    const loader = document.getElementById('loader');
                    loader.style.display = 'flex'; // show loader

                    const t1 = readTeacher(1);
                    const t2 = readTeacher(2);
                    const check = validate({
                        t1,
                        t2
                    });

                    if (!check.ok) {
                        loader.style.display = 'none';
                        return;
                    }

                    const payload = buildPayload(t1, t2);

                    // choose which teacher block is the "main" class
                    const main = t1.classType === 'main' ? t1 : t2.classType === 'main' ? t2 : t1;
                    const tutor = main === t1 ? t2 : t1;

                    const cleanTime = (s) => (s || '').replace(/[^\d:apm\s]/gi, '').replace(/\s+/g, ' ')
                        .trim();
                    const toHM = (timeLabel) => {
                        const m = cleanTime(timeLabel).match(/^(\d{1,2})(?::(\d{2}))?\s*([ap]m)$/i);
                        if (!m) return {
                            hours: null,
                            minutes: null,
                        };
                        let h = parseInt(m[1], 10);
                        const min = parseInt(m[2] ?? '0', 10);
                        const ampm = m[3].toLowerCase();
                        if (ampm === 'pm' && h < 12) h += 12;
                        if (ampm === 'am' && h === 12) h = 0;
                        return {
                            hours: h,
                            minutes: min
                        };
                    };

                    const earliestStartHM = (schedule) => {
                        const arr = schedule?.scheduleArray || [];
                        if (!arr.length) return {
                            hours: null,
                            minutes: null,
                        };
                        let best = null,
                            bestMin = Infinity;
                        for (const it of arr) {
                            const hm = toHM(it.startTime);
                            if (hm.hours == null || hm.minutes == null) continue;
                            const mm = hm.hours * 60 + hm.minutes;
                            if (mm < bestMin) {
                                bestMin = mm;
                                best = hm;
                            }
                        }
                        return best || {
                            hours: null,
                            minutes: null
                        };
                    };

                    const daysToFlags = (arr = [], {
                        tutor = false
                    } = {}) => {
                        const has = (d) => arr.includes(d);
                        return tutor ? {
                            cohorttutormonday: has('Mon') ? 1 : 0,
                            cohorttutortuesday: has('Tue') ? 1 : 0,
                            cohorttutorwednesday: has('Wed') ? 1 : 0,
                            cohorttutorthursday: has('Thu') ? 1 : 0,
                            cohorttutorfriday: has('Fri') ? 1 : 0,
                        } : {
                            cohortmonday: has('Mon') ? 1 : 0,
                            cohorttuesday: has('Tue') ? 1 : 0,
                            cohortwednesday: has('Wed') ? 1 : 0,
                            cohortthursday: has('Thu') ? 1 : 0,
                            cohortfriday: has('Fri') ? 1 : 0,
                        };
                    };

                    const enabled = document.querySelector('#toggleActive')?.classList.contains('active') ?
                        1 : 0;
                    const visible = document.querySelector('#toggleAvailable')?.classList.contains(
                        'active') ? 1 : 0;
                    const idnumber = (document.querySelector('#cohortInput')?.value || '').trim();
                    const shortname = (document.querySelector('#cohortShortInput')?.value || '').trim();
                    const name = shortname || idnumber || 'New Cohort';
                    const startdate = main.startDateUnix || tutor.startDateUnix || null;
                    const enddate = main.endDateUnix || tutor.endDateUnix || null;

                    const mainHM = earliestStartHM(main.schedule);
                    const tutorHM = earliestStartHM(tutor.schedule);

                    const mainDays = daysToFlags((main.schedule?.scheduleArray || []).map((x) => x.day));
                    const tutorDays = daysToFlags((tutor.schedule?.scheduleArray || []).map((x) => x.day), {
                        tutor: true
                    });

                    const teacher1Id = (t1.id || '').trim() || null;
                    const teacher2Id = (t2.id || '').trim() || null;

                    const singleCohort = {
                        name,
                        idnumber,
                        shortname,
                        enabled,
                        visible,
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



                    (async () => {
                        try {
                            const url = (window.M?.cfg?.wwwroot || '') +
                                '/local/customplugin/ajax/create_cohort.php';
                            const res = await fetch(url, {
                                method: 'POST',
                                headers: {
                                    'Content-Type': 'application/json'
                                },
                                credentials: 'same-origin',
                                body: JSON.stringify({
                                    sesskey: window.M?.cfg?.sesskey || '',
                                    cohort: singleCohort,
                                }),
                            });

                            const json = await res.json().catch(() => null);
                            if (!json || !json.ok) {
                                alert('Failed to create cohort:\n' + (json?.error || res.status +
                                    ' ' + res.statusText));
                                console.error('Create cohort error:', {
                                    json,
                                    status: res.status
                                });
                                return;
                            }

                            showToast('Cohort created successfully: ' + name);

                            if (window.refetchCustomPluginData) {
                                window.refetchCustomPluginData('create-cohort');
                            } else if (window.fetchCalendarEvents) {
                                window.fetchCalendarEvents();
                            }


                            resetCohortFields();
                        } catch (err) {
                            console.error(err);
                            alert('Unexpected error creating cohort.');
                        } finally {
                            loader.style.display = 'none'; // hide loader always
                        }
                    })();


                }, {
                    passive: false
                });
            })();
            </script>
            <?php require_once('calendar_admin_details_create_cohort_class_tab.php');?>
            <?php require_once('calendar_admin_details_create_cohort_manage_class_tab.php');?>
            <?php require_once('calendar_admin_details_create_cohort_merge_tab.php');?>
            <?php require_once('calendar_admin_details_create_cohort_manage_cohort.php');?>
            <?php require_once('calendar_admin_details_create_cohort_conference_tab.php');?>
            <?php require_once('calendar_admin_details_create_cohort_peertalk_tab.php');?>
            <?php require_once('calendar_admin_details_create_cohort_add_time_tab.php');?>
            <?php require_once('calendar_admin_details_create_cohort_add_extra_slots_tab.php');?>
        </div>
        <!-- Time Picker Modal -->
        <div class="calendar_admin_details_create_cohort_time_modal_backdrop" id="timeModalBackdrop">
            <div class="calendar_admin_details_create_cohort_time_modal" id="timeModal">
                <ul>
                    <!-- Time options rendered via JS -->
                </ul>
            </div>
        </div>
        <!-- Calendar Date Picker Modal -->
        <div class="calendar_admin_details_create_cohort_calendar_modal_backdrop" id="calendarDateModalBackdrop"
            style="display:none;">
            <div class="calendar_admin_details_create_cohort_calendar_modal" id="calendarDateModal">
                <div class="calendar_admin_details_create_cohort_calendar_nav">
                    <button class="calendar_prev_month"><svg width="22" height="22" viewBox="0 0 24 24">
                            <polyline points="15 19 8 12 15 5" fill="none" stroke="#111" stroke-width="2"
                                stroke-linecap="round" stroke-linejoin="round"></polyline>
                        </svg></button>
                    <span id="calendarDateMonth"></span>
                    <button class="calendar_next_month"><svg width="22" height="22" viewBox="0 0 24 24">
                            <polyline points="9 19 16 12 9 5" fill="none" stroke="#111" stroke-width="2"
                                stroke-linecap="round" stroke-linejoin="round"></polyline>
                        </svg></button>
                </div>
                <div class="calendar_admin_details_create_cohort_calendar_days"></div>
                <button class="calendar_admin_details_create_cohort_calendar_done_btn">Done</button>
            </div>
        </div>
    </div>
    <script>
    $(document).ready(function() {

        $('.calendar_admin_btn').click(function() {
            $('.calendar_admin_btn').removeClass('calendar_admin_btn_active');
            $(this).addClass('calendar_admin_btn_active');
            setTimeout(() => {
                scrollToActiveCohortTab();
            }, 500);
        });

        // Make sure only one cohort-related modal/backdrop is visible at a time
        // Using ModalUtils for centralized modal management when available
        function closeCohortOverlays() {
            const modalIds = [
                'customRecurrenceModalBackdrop',
                'calendarDateModalBackdrop',
                'monthly_cal_modal_backdrop',
                'timePickerModalBackdrop'
            ];
            modalIds.forEach(id => {
                if (window.ModalUtils && window.ModalUtils.isOpen(id)) {
                    window.ModalUtils.close(id);
                } else if (window.$) {
                    $('#' + id).fadeOut(0);
                }
            });
        }
        // expose for other scripts (e.g. calendar_admin_details_calendar_content.js)
        window.closeCohortOverlays = closeCohortOverlays;

        // ===== UNIFIED TAB HANDLER =====
        function openTab(tabName) {

            // Remove all active classes
            $('.calendar_admin_details_create_cohort_tab').removeClass('active');

            // Add active class to the correct tab
            $(`.calendar_admin_details_create_cohort_tab[data-tab="${tabName}"]`).addClass('active');

            // Hide ALL tab contents
            $('#mainModalContent').hide();
            $('#peerTalkTabContent').hide();
            $('#mergeTabContent').hide();
            $('#addTimeTabContent').hide();
            $('#addExtraSlotsTabContent').hide();
            $('#classTabContent').hide();
            $('#manageclassTabContent').hide();
            $('#manage_cohort_tab_content').hide();
            $('#conferenceTabContent').hide();

            // Show the correct tab content
            switch (tabName) {
                case 'cohort':
                    $('#mainModalContent').show();
                    resetCohortFields();
                    break;
                case 'manage':
                    $('#manage_cohort_tab_content').show();
                    break;
                case 'class':
                    $('#classTabContent').css('display', 'flex');
                    break;
                case 'manage_class':
                    $('#manageclassTabContent').show();
                    // When opening Manage 1:1 tab, ensure it starts clean
                    if (window.resetManageClassForm && typeof window.resetManageClassForm === 'function') {
                        try {
                            window.resetManageClassForm();
                        } catch (e) {
                            console.warn('resetManageClassForm failed on openTab(manage_class):', e);
                        }
                    }
                    break;
                case 'merge':
                    $('#mergeTabContent').show();
                    break;
                case 'conference':
                    $('#conferenceTabContent').show();
                    // Reset conference form when opening from sidebar
                    if (typeof resetConferenceForm === 'function') {
                        resetConferenceForm();
                    }
                    break;
                case 'peertalk':
                    $('#peerTalkTabContent').show();
                    // Reset peer talk form when opening from sidebar
                    if (typeof resetPeerTalkForm === 'function') {
                        resetPeerTalkForm();
                    }
                    break;
                case 'addtime':
                    $('#addTimeTabContent').show();
                    // Pass slot info if available from empty slot click
                    if (window._lastCohortSlotInfo) {
                        resetAddTimeForm(null, null, window._lastCohortSlotInfo);
                    } else {
                        resetAddTimeForm();
                    }
                    break;
                case 'extraslots':
                    $('#addExtraSlotsTabContent').show();
                    // Pass slot info if available from empty slot click
                    if (window._lastCohortSlotInfo) {
                        resetAddTimeFormExtraSlots(null, null, window._lastCohortSlotInfo);
                    }
                    break;
            }

            // Show the modal
            closeCohortOverlays();
            $('#calendar_admin_details_create_cohort_modal_backdrop').fadeIn();
            $('#calendar_admin_details_create_cohort_content').html('');

            // Scroll to active tab
            setTimeout(() => {
                scrollToActiveCohortTab();
            }, 100);

            // Auto-select teacher from sessionStorage
            setTimeout(() => {
                const savedTeacherId = sessionStorage.getItem('selectedTeacherId');
                if (!savedTeacherId) return;

                const teacherIdInt = parseInt(savedTeacherId, 10);
                let $teacherItem = null;

                switch (tabName) {
                    case 'cohort':
                        $teacherItem = $(
                            '#mainModalContent #teacher1DropdownList li.teacher-option[data-userid="' +
                            teacherIdInt + '"]');
                        break;
                    case 'manage':
                        // Don't auto-select on manage cohort tab
                        break;
                    case 'conference':
                        $teacherItem = $(
                            '#conferenceTeachersDropdownList li.conference_teacher_item[data-userid="' +
                            teacherIdInt + '"]');
                        break;
                    case 'peertalk':
                        $teacherItem = $(
                            '#peertalkTeachersDropdownList li.peertalk_teacher_item[data-userid="' +
                            teacherIdInt + '"]');
                        break;
                    case 'class':
                        $teacherItem = $(
                            '#classTabContent .calendar_admin_details_create_cohort_class_tab_item[data-userid="' +
                            teacherIdInt + '"]');
                        break;
                    case 'manage_class':
                        $teacherItem = $(
                            '#manageclassTabContent .calendar_admin_details_create_cohort_manage_class_tab_item[data-userid="' +
                            teacherIdInt + '"]');
                        break;
                    case 'addtime':
                    case 'extraslots':
                        $teacherItem = $('#addtimeTeacherList .addtime-teacher-item[data-userid="' +
                            teacherIdInt + '"]');
                        break;
                }

                if ($teacherItem && $teacherItem.length > 0) {
                    console.log('Auto-selecting teacher in ' + tabName + ' tab:', teacherIdInt);
                    $teacherItem.trigger('click');
                }
            }, 400);
        }

        // Modal open with cohort tab
        $('.calendar_admin_details_create_cohort_open').click(function() {
            openTab('cohort');
        });

        // Direct button clicks
        $('.calendar_admin_details_1_1_class').click(function() {
            openTab('class');
        });

        $('#calendar_admin_details_manage_class').click(function() {
            openTab('manage_class');
        });

        $('.calendar_admin_details_conference').click(function() {
            openTab('conference');
        });

        $('#calendar_admin_details_peer_talk').click(function() {
            openTab('peertalk');
        });

        $('#calendar_admin_details_merge').click(function() {
            openTab('merge');
        });

        $('#calendar_admin_details_manage_cohort').click(function() {
            openTab('manage');
        });

        $('#calendar_admin_details_add_time_off').click(function() {
            openTab('addtime');
        });

        $('#calendar_admin_details_add_extra_slots').click(function() {
            openTab('extraslots');
        });

        // Tab clicks (when clicking the tab itself)
        $('.calendar_admin_details_create_cohort_tab').click(function() {
            const tabName = $(this).data('tab');
            openTab(tabName);
        });
        // Teacher dropdowns
        $('#teacher1DropdownBtn').click(function(e) {
            e.stopPropagation();
            $('#teacher1DropdownList').toggle();
            $('#teacher2DropdownList, #className1DropdownList, #className2DropdownList').hide();
        });

        $('#teacher1DropdownList li').click(function() {
            $('#teacher1DropdownBtn').html($(this).html() +
                '<img src="./img/dropdown-arrow-down.svg" alt="" >');
            $('#teacher1DropdownList').hide();
        });

        $('#teacher2DropdownBtn').click(function(e) {
            e.stopPropagation();
            $('#teacher2DropdownList').toggle();
            $('#teacher1DropdownList, #className1DropdownList, #className2DropdownList').hide();
        });

        $('#teacher2DropdownList li').click(function() {
            $('#teacher2DropdownBtn').html($(this).html() +
                '<img src="./img/dropdown-arrow-down.svg" alt="" >');
            $('#teacher2DropdownList').hide();
        });

        $('#className1DropdownBtn').click(function(e) {
            e.stopPropagation();
            $('#className1DropdownList').toggle();
            $('#teacher1DropdownList, #teacher2DropdownList, #className2DropdownList').hide();
        });

        $('#className1DropdownList li').click(function() {
            debugger
            var svg = $('#className1DropdownBtn').find('svg').prop('outerHTML') ||
                '<img src="./img/dropdown-arrow-down.svg" alt="" >';
            debugger
            $('#className1DropdownBtn').html($(this).text() + ' ' + svg);
            $('#className1DropdownList').hide();
        });

        $('#className2DropdownBtn').click(function(e) {
            e.stopPropagation();
            $('#className2DropdownList').toggle();
            $('#teacher1DropdownList, #teacher2DropdownList, #className1DropdownList').hide();
        });

        $('#className2DropdownList li').click(function() {
            $('#className2DropdownBtn').contents().first()[0].textContent = $(this).text() + " ";
            $('#className2DropdownList').hide();
        });

        // Toggles
        $('#toggleActive, #toggleAvailable').click(function() {
            $(this).toggleClass('active');
        });

        // Time picker
        $(document).on("click", ".calendar_admin_details_create_cohort_time_btn, .conference_modal_time_btn",
            function(e) {
                e.stopPropagation();
                openTimePickerModal($(this));
            });

        $('#timeModal').off("click", "li").on("click", "li", function() {
            let $btn = $('#timeModalBackdrop').data('targetBtn');
            $btn.text($(this).text()).addClass('selected');
            $('#timeModalBackdrop').hide();
        });

        $('#timeModalBackdrop').off("click").on("click", function(e) {
            if (e.target === this) $(this).hide();
        });

        $(document).on("keydown", function(e) {
            if (e.key === "Escape") $('#timeModalBackdrop').hide();
        });

        // Calendar picker logic
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

            // Get the current date from the button if available
            const rawDate = $(this).data('raw-date');
            let initialDate;

            if (rawDate) {
                // Parse YYYY-MM-DD format
                const parts = rawDate.split('-');
                initialDate = new Date(parseInt(parts[0]), parseInt(parts[1]) - 1, parseInt(parts[2]));
            } else if ($(this).parents('#peerTalkTabContent').length) {
                // For peertalk tab, use current date if no raw date is set
                initialDate = new Date();
            } else {
                initialDate = new Date();
            }

            calendarModalMonth = {
                year: initialDate.getFullYear(),
                month: initialDate.getMonth()
            };

            selectedCalendarDate = null;
            renderCalendarModal();
            $('#calendarDateModalBackdrop').fadeIn();
        });

        $(document).on('click', '.calendar_prev_month', function() {
            if (!calendarModalMonth) return; // safety guard
            calendarModalMonth.month--;
            if (calendarModalMonth.month < 0) {
                calendarModalMonth.month = 11;
                calendarModalMonth.year--;
            }
            renderCalendarModal();
        });

        $(document).on('click', '.calendar_next_month', function() {
            if (!calendarModalMonth) return; // safety guard
            calendarModalMonth.month++;
            if (calendarModalMonth.month > 11) {
                calendarModalMonth.month = 0;
                calendarModalMonth.year++;
            }
            renderCalendarModal();
        });

        function renderCalendarModal() {
            if (!calendarModalMonth) return; // safety guard
            const monthNames = ["January", "February", "March", "April", "May", "June", "July", "August",
                "September", "October", "November", "December"
            ];
            let y = calendarModalMonth.year,
                m = calendarModalMonth.month;
            $('#calendarDateMonth').text(`${monthNames[m]} ${y}`);
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
                let sel = selectedCalendarDate && selectedCalendarDate.getFullYear() === y &&
                    selectedCalendarDate.getMonth() === m && selectedCalendarDate.getDate() === d ?
                    ' selected' : '';
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
            if (!calendarModalMonth) return; // safety guard
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

                // Format date as YYYY-MM-DD for raw-date
                const year = d.getFullYear();
                const month = String(d.getMonth() + 1).padStart(2, '0');
                const day = String(d.getDate()).padStart(2, '0');
                const rawDate = `${year}-${month}-${day}`;

                calendarDateTargetBtn.text(nice);
                calendarDateTargetBtn.data('raw-date', rawDate);
                calendarDateTargetBtn.attr('data-raw-date', rawDate);

                console.log('Updated date button:', {
                    displayDate: nice,
                    rawDate: rawDate
                });

                $('#calendarDateModalBackdrop').fadeOut();
            }
        });

        // Timezone dropdowns
        $('#eventTimezoneDropdown').click(function(e) {
            e.stopPropagation();
            $('#eventTimezoneDropdownList').toggle();
        });

        $('#eventTimezoneDropdownList li').click(function(e) {
            e.stopPropagation();
            $('#eventTimezoneSelected').text($(this).text());
            $('#eventTimezoneDropdownList').hide();
        });

        $(document).click(function() {
            $('#eventTimezoneDropdownList').hide();
        });

        $('#eventTimezoneDropdownRight').click(function(e) {
            e.stopPropagation();
            $('#eventTimezoneDropdownListRight').toggle();
        });

        $('#eventTimezoneDropdownListRight li').click(function(e) {
            e.stopPropagation();
            $('#eventTimezoneSelectedRight').text($(this).text());
            $('#eventTimezoneDropdownListRight').hide();
        });

        $(document).click(function() {
            $('#eventTimezoneDropdownListRight').hide();
        });

        // When a Teacher 1 option is clicked, set #cohortInput
        $(document).on('click', '#teacher1DropdownList li', function() {
            const $cohort = $('#cohortInput');
            if (!$cohort.length) return;

            // Build query string
            const $li = $(this);
            const teacherIndex = $li.index() + 1;
            const params = new URLSearchParams({
                sesskey: M.cfg.sesskey,
                teacherid: $li.data('userid') || '',
                teacher_name: $li.data('name') || '',
                teacher_pic: $li.data('pic') || '',
                teacher_index: teacherIndex || ''
            });

            fetch(M.cfg.wwwroot + '/local/customplugin/ajax/get_cohort_template.php?' + params
                    .toString(), {
                        method: 'GET',
                        credentials: 'same-origin'
                    })
                .then(res => {
                    if (!res.ok) throw new Error(`HTTP ${res.status}`);
                    return res.json();
                })
                .then(resp => {
                    if (resp && resp.success && resp.template) {
                        $cohort.val(resp.template).trigger('input').trigger('change');
                        const shortname = resp.nextshortname || String(resp.template).split('-')[
                            0] || '';
                        if ($('#cohortShortInput').length && shortname) {
                            $('#cohortShortInput').val(shortname).trigger('input').trigger(
                                'change');
                            $('#cohortShortInput').closest('div').find('.custom-tooltip').hide();
                        }
                    } else {
                        const template = ($cohort.val() || $cohort.attr('placeholder') || '')
                            .trim();
                        if (!template) return;
                        let updated = template.replace(/^XXX(?=-|$)/, 'CO1');
                        if (updated === template) updated = template.replace(/^[^-]+/, 'CO1');
                        $cohort.val(updated).trigger('input').trigger('change');
                    }
                })
                .catch(() => {
                    const template = ($cohort.val() || $cohort.attr('placeholder') || '').trim();
                    if (!template) return;
                    let updated = template.replace(/^XXX(?=-|$)/, 'CO1');
                    if (updated === template) updated = template.replace(/^[^-]+/, 'CO1');
                    $cohort.val(updated).trigger('input').trigger('change');
                });
        });
    });

    // Show tooltip on hover/focus for BOTH fields; place BELOW the input
    (function($) {
        $('.cohort-tooltip-target')
            .on('mouseenter focus', function() {
                $(this).siblings('.custom-tooltip').stop(true, true).fadeIn(140);
            })
            .on('mouseleave blur', function() {
                $(this).siblings('.custom-tooltip').stop(true, true).fadeOut(140);
            });
    })(jQuery);

    // Class Name dropdown
    function wireClassDropdown(btnSel, listSel) {
        $(btnSel).off('click').on('click', function(e) {
            e.stopPropagation();
            const $btn = $(this);
            const $list = $(listSel);
            $('.calendar_admin_details_create_cohort_class_list').not($list).hide();
            $('.calendar_admin_details_create_cohort_class_btn').not($btn).removeClass('open');
            $btn.toggleClass('open');
            if ($btn.hasClass('open')) {
                $list.show();
                const current = ($btn.contents().first()[0].textContent || '').trim();
                $list.find('li').removeClass('selected')
                    .filter(function() {
                        return $(this).text().trim() === current;
                    })
                    .addClass('selected');
            } else {
                $list.hide();
            }
        });

        $(listSel).off('click', 'li').on('click', 'li', function(e) {
            e.stopPropagation();
            const text = $(this).text().trim();
            const $btn = $(btnSel);
            const icon = $btn.find('svg, img').prop('outerHTML') ||
                '<img src="./img/dropdown-arrow-down.svg" alt="">';

            $btn.html(text + ' ' + icon);

            $(listSel).hide();
            $btn.removeClass('open');
        });
    }

    wireClassDropdown('#className1DropdownBtn', '#className1DropdownList');
    wireClassDropdown('#className2DropdownBtn', '#className2DropdownList');

    $(document).off('click.classdd').on('click.classdd', function() {
        $('.calendar_admin_details_create_cohort_class_list').hide();
        $('.calendar_admin_details_create_cohort_class_btn').removeClass('open');
    });

    // ====== TOAST NOTIFICATION FUNCTION ======
    // showToast() is now in js/toast_utils.js
    // Using: showToast() from toast_utils.js
    // For backward compatibility, keep showToast wrapper
    function showToast(message, type = 'success', duration = 5000) {
        return window.showToast(message, type, duration, 'toastNotificationForCreateCohort');
    }

    function resetRecurrenceModal() {
        const modal = document.querySelector('.calendar_admin_details_create_cohort_customrec_modal');
        if (!modal) return;

        // Reset interval to 1
        const intervalSpan = modal.querySelector('#customrec_interval');
        if (intervalSpan) intervalSpan.textContent = '1';

        // Reset period to 'Week'
        const periodVal = modal.querySelector('#customrec_period_val');
        if (periodVal) periodVal.textContent = 'Week';

        // Hide monthly picker
        const monthlyPicker = modal.querySelector('#customrec_monthly_picker_container');
        if (monthlyPicker) monthlyPicker.style.display = 'none';

        // Reset all day widgets
        const dayWidgets = modal.querySelectorAll('#weekly_scroll_widgets .scroll-widget');
        dayWidgets.forEach(widget => {
            // Remove selected state
            widget.classList.remove('selected');
            widget.setAttribute('aria-pressed', 'false');

            // Reset time displays
            const timeContainer = widget.querySelector('.scroll-widget__time');
            const startHM = widget.querySelector('.scroll-widget__hm.s');
            const startPeriod = widget.querySelector('.scroll-widget__period.sp');
            const endHM = widget.querySelector('.scroll-widget__hm.e');
            const endPeriod = widget.querySelector('.scroll-widget__period.ep');
            const scrollButton = widget.querySelector('.scroll-widget__button');

            // Reset time values to empty/default
            if (startHM) startHM.textContent = '';
            if (startPeriod) startPeriod.textContent = '';
            if (endHM) endHM.textContent = '';
            if (endPeriod) endPeriod.textContent = '';

            // Remove time styling
            if (timeContainer) timeContainer.classList.remove('has-time');
            if (scrollButton) scrollButton.classList.remove('has-time');
        });
    }

    // reset form on success
    function resetCohortFields() {
        // Reset cohort inputs
        const cohortInput = document.getElementById('cohortInput');
        const cohortShort = document.getElementById('cohortShortInput');
        if (cohortInput) cohortInput.value = '';
        if (cohortShort) cohortShort.value = '';

        // Reset teacher selections
        const t1 = document.getElementById('teacher1UserId');
        const t2 = document.getElementById('teacher2UserId');
        if (t1) t1.value = '';
        if (t2) t2.value = '';

        const teacher1Btn = document.getElementById('teacher1DropdownBtn');
        const teacher2Btn = document.getElementById('teacher2DropdownBtn');
        if (teacher1Btn) teacher1Btn.innerHTML =
            '<span class="label">Select Teacher</span><img src="./img/dropdown-arrow-down.svg" alt="">';
        if (teacher2Btn) teacher2Btn.innerHTML =
            '<span class="label">Select Teacher</span><img src="./img/dropdown-arrow-down.svg" alt="">';

        // Reset class selections
        const class1 = document.getElementById('className1DropdownBtn');
        const class2 = document.getElementById('className2DropdownBtn');
        if (class1) class1.innerHTML = 'Select Class <img src="./img/dropdown-arrow-down.svg" alt="">';
        if (class2) class2.innerHTML = 'Select Class <img src="./img/dropdown-arrow-down.svg" alt="">';

        // Reset schedule buttons
        document.querySelectorAll('.cohort_schedule_btn').forEach(btn => {
            btn.innerHTML =
                'Does not repeat <span class="cohort_schedule_arrow"><img src="./img/dropdown-arrow-down.svg" alt=""></span>';
        });

        // Reset timezones
        const tzLeft = document.getElementById('eventTimezoneSelected');
        const tzRight = document.getElementById('eventTimezoneSelectedRight');
        if (tzLeft) tzLeft.textContent = '(GMT-05:00) Eastern Time (US & Canada)';
        if (tzRight) tzRight.textContent = '(GMT-05:00) Eastern Time (US & Canada)';

        // Reset dates
        document.querySelectorAll('.conference_modal_date_btn').forEach(btn => {
            btn.textContent = 'Select Date';
        });

        // Reset colors
        const leftColor = document.querySelector(
            '#createNewCohortSelectedColorLeft .create_new_cohort_tab_select_color_left_circle');
        const rightColor = document.querySelector(
            '#createNewCohortSelectedColorRight .create_new_cohort_tab_select_color_right_circle');
        if (leftColor) leftColor.style.background = '#1649c7';
        if (rightColor) rightColor.style.background = '#1649c7';

        // Reset toggles
        document.querySelectorAll('#toggleActive, #toggleAvailable').forEach(btn => {
            btn.classList.remove('active');
        });

        // Clear the schedule state
        if (typeof stateByTeacher !== 'undefined' && stateByTeacher instanceof Map) {
            stateByTeacher.clear();
        } else if (window.stateByTeacher && window.stateByTeacher instanceof Map) {
            window.stateByTeacher.clear();
        }

        // Reset the recurrence modal UI - THIS IS THE KEY ADDITION
        resetRecurrenceModal();

        // Also clear any global state
        if (window.currentTeacherIdx !== undefined) {
            window.currentTeacherIdx = null;
        }
    }

    // Helper: reset Manage 1:1 tab when the main modal is closed
    function resetManageTabIfLoaded() {
        if (window.resetManageClassForm && typeof window.resetManageClassForm === 'function') {
            try {
                window.resetManageClassForm();
            } catch (e) {
                console.warn('resetManageClassForm failed:', e);
            }
        }
    }

    // Modal close functionality
    // Close button click handler
    $('.calendar_admin_details_create_cohort_close').click(function() {
        resetCohortFields();
        resetManageTabIfLoaded();
        // Also close the recurrence modal if it's open
        $('.calendar_admin_details_create_cohort_customrec_modal').removeClass('open').attr('aria-hidden',
        'true');
        // Remove slot highlight when closing modal
        $(".day-inner .slots > div").removeClass("cohort-slot-highlight");
        if (window._lastCohortSlot) {
            window._lastCohortSlot = null;
        }
        if (window._lastCohortSlotInfo) {
            window._lastCohortSlotInfo = null;
        }
        $('#calendar_admin_details_create_cohort_modal_backdrop').fadeOut();
    });

    // Backdrop click handler
    $('#calendar_admin_details_create_cohort_modal_backdrop').click(function(e) {
        if (e.target === this) {
            resetCohortFields();
            resetManageTabIfLoaded();
            // Also close the recurrence modal if it's open
            $('.calendar_admin_details_create_cohort_customrec_modal').removeClass('open').attr('aria-hidden',
                'true');
            $(this).fadeOut();
        }
    });

    // ESC key handler
    $(document).keydown(function(e) {
        if (e.key === "Escape") {
            resetCohortFields();
            resetManageTabIfLoaded();
            // Also close the recurrence modal if it's open
            $('.calendar_admin_details_create_cohort_customrec_modal').removeClass('open').attr('aria-hidden',
                'true');
            $('#calendar_admin_details_create_cohort_modal_backdrop').fadeOut();
        }
    });

    // ==================== AUTO SCROLL ACTIVE TAB INTO VIEW ====================
    function scrollToActiveCohortTab() {
        const $scrollContainer = $('.calendar_admin_details_create_cohort_tabs_scroll');
        const $activeTab = $scrollContainer.find('.calendar_admin_details_create_cohort_tab.active');

        if ($activeTab.length === 0) return;

        const container = $scrollContainer.get(0);
        const tab = $activeTab.get(0);

        const containerWidth = container.clientWidth;
        const tabLeft = tab.offsetLeft;
        const tabWidth = tab.offsetWidth;

        // Center the active tab
        const scrollTo = tabLeft - (containerWidth / 2) + (tabWidth / 2);

        $scrollContainer.animate({
            scrollLeft: scrollTo
        }, 400, 'swing');
    }
    </script>
    <script src="js/calendar_admin_details_create_cohort_plus_icon_new_content.js"></script>
    <?php require_once('calendar_admin_details_create_cohort_select_date.php');?>
    <?php require_once('calendar_admin_details_create_cohort_tab_does_repeat.php');?>
</body>

</html>