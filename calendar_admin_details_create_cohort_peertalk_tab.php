<!-- ✅ Peer Talk Tab -->
<div id="peerTalkTabContent" style="display:none;">
    <form id="peerTalkForm">
        <div class="conference_modal_schedule">
            <img src="./img/conference-schedule.svg" alt=""> Peer Talk Schedule
        </div>

        <!-- Repeat + Date -->
        <div class="conference_modal_repeat_row">
            <div style="width:50%;">
                <div class="conference_modal_repeat_btn peertalk_repeat_btn" style="border-bottom:2.5px solid #fe2e0c;">

                    Does not repeat
                    <span style="float:right; font-size:1rem;">
                        <img src="./img/dropdown-arrow-down.svg" alt="">
                    </span>
                </div>
            </div>
            <div
                style="display:flex; gap:12px; align-items:center; margin-bottom:7px;width:100%;justify-content:space-around;">
                <div class="conference_modal_label" style="font-weight:400;">Start On</div>
                <button type="button" class="conference_modal_date_btn peertalk_modal_date_btn">Select Date</button>
            </div>
        </div>

        <!-- Timezone + Color -->
        <div
            style="display:flex; gap:12px; align-items:center; margin-bottom:7px; justify-content:space-between;width:100%;">
            <div class="calendar_admin_details_cohort_tab_timezone_wrapper" style="margin-top:10px;width:100%;">
                <label class="calendar_admin_details_cohort_tab_timezone_label">Event time zone</label>
                <div class="calendar_admin_details_cohort_tab_timezone_dropdown"
                    id="eventTimezoneDropdown_peertalk_wrapper">
                    <span id="eventTimezoneDropdown_peertalk_selected">(GMT-05:00) Eastern Time (US & Canada)</span>
                    <img class="calendar_admin_details_cohort_tab_timezone_arrow" src="./img/dropdown-arrow-down.svg"
                        alt="">
                    <div class="calendar_admin_details_cohort_tab_timezone_list"
                        id="eventTimezoneDropdown_peertalk_list">
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

            <div
                style="display:flex; gap:12px; align-items:center; margin-bottom:7px;width:100%;justify-content:space-around;">
                <a class="conference_modal_findtime_link" href="#">Find a time</a>
                <div class="color-dropdown-wrapper">
                    <button type="button" class="color-dropdown-toggle" id="colorDropdownToggle_peertalk"
                        style="width:75px;">
                        <span class="color-circle" style="background:#1649c7"></span>
                        <span style="float:right; font-size:1rem;">
                            <img class="calendar_admin_details_cohort_tab_timezone_arrow"
                                src="./img/dropdown-arrow-down.svg" alt="">
                        </span>
                    </button>
                    <div class="color-dropdown-list" id="colorDropdownList_peertalk">
                        <div class="color-dropdown-color" data-color="#1649c7" style="background:#1649c7"></div>
                        <div class="color-dropdown-color" data-color="#20a88e" style="background:#20a88e"></div>
                        <div class="color-dropdown-color" data-color="#3f3f48" style="background:#3f3f48"></div>
                        <div class="color-dropdown-color" data-color="#fe2e0c" style="background:#fe2e0c"></div>
                        <div class="color-dropdown-color" data-color="#daa520" style="background:#daa520"></div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Peer Talk Participants Navigation -->
        <div style="display: flex; justify-content: space-between; align-items: center; margin: 20px 0 10px 0;">
            <h3 style="margin: 0; font-size: 16px; font-weight: 600;">Peer Talk Participants</h3>
            <div style="display: flex; gap: 8px;">
                <button type="button" class="peertalk-nav-prev"
                    style="width: 32px; height: 32px; border: 1px solid #ddd; background: white; border-radius: 6px; cursor: pointer; display: flex; align-items: center; justify-content: center;">
                    <img src="./img/prev.svg" alt="">
                </button>
                <button type="button" class="peertalk-nav-next"
                    style="width: 32px; height: 32px; border: 1px solid #ddd; background: white; border-radius: 6px; cursor: pointer; display: flex; align-items: center; justify-content: center;">
                    <img src="./img/next.svg" alt="">
                </button>
            </div>
        </div>

        <!-- View 1: Teachers & Cohorts -->
        <div class="main-peertalk-participants-container">
            <div class="peertalk-view-1" style="display: block;">
                <div class="conference_modal_fieldrow">
                    <?php
            require_once(__DIR__ . '/../../config.php');
            require_login();
            
            global $DB;
            
            /** Fetch cohorts with valid idnumber */
            $sql = "SELECT id, name, idnumber
              FROM {cohort}
             WHERE idnumber IS NOT NULL AND idnumber <> ''
                  ORDER BY timemodified DESC, id DESC";
            
            $cohorts = $DB->get_records_sql($sql);
            ?>
                    <div>
                        <span class="conference_modal_label">Attending Cohorts</span>
                        <div class="conference_modal_dropdown_btn" id="peertalkCohortsDropdown">
                            Select Cohort
                            <span style="float:right; font-size:1rem;">
                                <img src="./img/dropdown-arrow-down.svg" alt="">
                            </span>
                        </div>
                        <div class="conference_modal_dropdown_list" id="peertalkCohortsDropdownList">
                            <input type="text" id="searchCohorts_peertalk" class="dropdown-search"
                                placeholder="Search cohorts...">
                            <ul id="peertalkCohortsList">
                                <?php
                if ($cohorts) {
                    foreach ($cohorts as $c) {
                        $shortname = format_string($c->name);   // SHOW THIS
                        $idn       = trim((string)$c->idnumber); // Use for payload
                        echo '<li class="peertalk_cohort_item"
                                  data-id="'.(int)$c->id.'"
                                  data-idnumber="'.s($idn).'"
                                  data-name="'.s($shortname).'">'.
                                  $shortname.
                             '</li>';
                    }
                } else {
                    echo '<li style="pointer-events:none;opacity:.6;">No cohorts found</li>';
                }
                ?>
                            </ul>
                        </div>
                    </div>
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
                $fields = "id, firstname, lastname, picture, imagealt,
                   firstnamephonetic, lastnamephonetic, middlename, alternatename";
                $teachers = $DB->get_records_select(
            'user',
            "id $inSql AND deleted = 0 AND suspended = 0",
            $params,
            'firstname ASC, lastname ASC',
            $fields
                );
            }
            
            ?>
                    <div>
                        <span class="conference_modal_label">Teachers</span>
                        <div class="conference_modal_dropdown_btn" id="peertalkTeachersDropdown">
                            Select Teacher
                            <span style="float:right; font-size:1rem;">
                                <img src="./img/dropdown-arrow-down.svg" alt="">
                            </span>
                        </div>
                        <div class="conference_modal_dropdown_list" id="peertalkTeachersDropdownList">
                            <input type="text" id="searchTeachers_peertalk" class="dropdown-search"
                                placeholder="Search teachers...">
                            <ul id="peertalkTeachersList">
                                <?php
                if (!empty($teachers)) {
                    foreach ($teachers as $teacher) {
                        $picture = new user_picture($teacher);
                        $picture->size = 40;
                        $imageurl = $picture->get_url($PAGE)->out(false);
                        $fullname = fullname($teacher, true);
                        echo '<li class="peertalk_teacher_item"
                                  data-userid="'.(int)$teacher->id.'"
                                  data-name="'.s($fullname).'"
                                  data-img="'.s($imageurl).'">';
                        echo '<img src="'.s($imageurl).'"
                                  class="calendar_admin_details_create_cohort_teacher_avatar"
                                  alt="'.s($fullname).'" /> ';
                        echo format_string($fullname);
                        echo '</li>';
                    }
                } else {
                    echo '<li aria-disabled="true">No teachers found</li>';
                }
                ?>
                            </ul>
                        </div>
                    </div>
                    <div class="conference_modal_fieldrow">
                        <!-- Students Dropdown -->
                        <div>
                            <span class="conference_modal_label">Select Students</span>
                            <div class="conference_modal_dropdown_btn" id="peertalkStudentsDropdown">
                                Select Students
                                <span style="float:right; font-size:1rem;">
                                    <img src="./img/dropdown-arrow-down.svg" alt="">
                                </span>
                            </div>
                            <div class="conference_modal_dropdown_list" id="peertalkStudentsDropdownList">
                                <input type="text" id="searchStudents_peertalk" class="dropdown-search"
                                    placeholder="Search students...">
                                <ul id="peertalkStudentsList">
                                    <?php
                                // Get all students (users with student role)
                                $studentRole = $DB->get_record('role', ['shortname' => 'student'], 'id');
                                $students = [];
            
                                if ($studentRole) {
                                    // Get users with student role assignments
                                    $sql = "SELECT DISTINCT u.id, u.firstname, u.lastname, u.picture, u.imagealt,
                                                   u.firstnamephonetic, u.lastnamephonetic, u.middlename, u.alternatename
                                            FROM {user} u
                                            JOIN {role_assignments} ra ON ra.userid = u.id
                                            WHERE ra.roleid = :roleid
                                              AND u.deleted = 0
                                              AND u.suspended = 0
                                            ORDER BY u.firstname ASC, u.lastname ASC
                                            LIMIT 500";
            
                                    $students = $DB->get_records_sql($sql, ['roleid' => $studentRole->id]);
                                }
            
                                if (!empty($students)) {
                                    foreach ($students as $student) {
                                        $picture = new user_picture($student);
                                        $picture->size = 40;
                                        $imageurl = $picture->get_url($PAGE)->out(false);
                                        $fullname = fullname($student, true);
                                        echo '<li class="peertalk_student_item"
                                                data-userid="'.(int)$student->id.'"
                                                data-name="'.s($fullname).'"
                                                data-img="'.s($imageurl).'">';
                                        echo '<img src="'.s($imageurl).'"
                                                class="calendar_admin_details_create_cohort_teacher_avatar"
                                                alt="'.s($fullname).'" /> ';
                                        echo format_string($fullname);
                                        echo '</li>';
                                    }
                                } else {
                                    echo '<li style="pointer-events:none;opacity:.6;">No students found</li>';
                                }
                                ?>
                                </ul>
                            </div>
                        </div>
                        <!-- Teachers Dropdown (duplicate from view 1) -->
                        <?php
                    // Get teachers again for view 2
                    $userIds2 = $DB->get_fieldset_sql("
                        SELECT DISTINCT uid
                        FROM (
                                SELECT cohortmainteacher AS uid FROM {cohort}
                                WHERE cohortmainteacher IS NOT NULL AND cohortmainteacher > 0
                                UNION
                                SELECT cohortguideteacher AS uid FROM {cohort}
                                WHERE cohortguideteacher IS NOT NULL AND cohortguideteacher > 0
                        ) t
                    ");
                    $teachers2 = [];
                    if ($userIds2) {
                        list($inSql2, $params2) = $DB->get_in_or_equal($userIds2, SQL_PARAMS_NAMED);
                        $fields2 = "id, firstname, lastname, picture, imagealt,
                                firstnamephonetic, lastnamephonetic, middlename, alternatename";
                        $teachers2 = $DB->get_records_select(
                            'user',
                            "id $inSql2 AND deleted = 0 AND suspended = 0",
                            $params2,
                            'firstname ASC, lastname ASC',
                            $fields2
                        );
                    }
                    ?>
                    </div>
                </div>
            </div>
            <div class="peerTalkParticipantsLists-container">
                <div class="conference_modal_lists_row">
                    <div class="conference_modal_attendees_section">
                        <ul class="conference_modal_cohort_list"></ul>
                    </div>
                    <div class="conference_modal_attendees_section">
                        <ul class="conference_modal_attendees_list"></ul>
                    </div>
                    <div class="conference_modal_attendees_section">
                        <ul class="conference_modal_students_list"></ul>
                    </div>
                </div>
            </div>
        </div>
        <button type="submit" class="peertalk_modal_btn">Schedule Peer Talk</button>
    </form>
</div>

<script>
(function() {
    // Use IIFE to avoid multiple bindings
    const $parent = $('#peerTalkTabContent');
    const $form = $parent.find('#peerTalkForm');
    const $tzWrapper = $parent.find('#eventTimezoneDropdown_peertalk_wrapper');
    const $tzList = $parent.find('#eventTimezoneDropdown_peertalk_list');
    const $tzSelected = $parent.find('#eventTimezoneDropdown_peertalk_selected');
    const $colorToggle = $parent.find('#colorDropdownToggle_peertalk');
    const $colorList = $parent.find('#colorDropdownList_peertalk');

    // View navigation
    const $view1 = $parent.find('.main-peertalk-participants-container');

    const $navNext = $parent.find('.peertalk-nav-next');
    const $navPrev = $parent.find('.peertalk-nav-prev');
    const $studentlist = $parent.find('.conference_modal_attendees_section').eq(1);
    const $cohortlist = $parent.find('.conference_modal_attendees_section').first();
    const $participantsContainer = $parent.find('.peerTalkParticipantsLists-container');
    $navNext.on('click', function() {
        const scrollAmount = 300; // Adjust this value as needed
        const currentScroll = $participantsContainer.scrollLeft();

        $participantsContainer.animate({
            scrollLeft: currentScroll + scrollAmount
        }, 300, 'swing');

        $view1.animate({
            scrollLeft: currentScroll + scrollAmount
        }, 300, 'swing');
    });

    // Scroll to left when prev is clicked
    $navPrev.on('click', function() {
        const scrollAmount = 300; // Adjust this value as needed
        const currentScroll = $participantsContainer.scrollLeft();

        $participantsContainer.animate({
            scrollLeft: currentScroll - scrollAmount
        }, 300, 'swing');

        $view1.animate({
            scrollLeft: currentScroll - scrollAmount
        }, 300, 'swing');
    })

    // These two are for the "End" options in the repeat UI.
    // Add data attributes in your HTML:
    //   data-peertalk-repeat-end-type  -> element holding "Never" / "date" / number
    //   data-peertalk-repeat-end-date  -> button/span with data-raw-date="YYYY-MM-DD"
    const $repeatEndType = $parent.find('[data-peertalk-repeat-end-type]');
    const $repeatEndDateBtn = $parent.find('[data-peertalk-repeat-end-date]');

    const apiUrl = M.cfg.wwwroot + '/local/videocalling/api/saveclass.php';

    // Map UI timezone label → IANA timezone ID
    const TIMEZONE_MAP = {
        "(GMT-12:00) International Date Line West": "Etc/GMT+12",
        "(GMT-11:00) Midway Island, Samoa": "Pacific/Midway",
        "(GMT-10:00) Hawaii": "Pacific/Honolulu",
        "(GMT-09:00) Alaska": "America/Anchorage",
        "(GMT-08:00) Pacific Time (US & Canada)": "America/Los_Angeles",
        "(GMT-07:00) Mountain Time (US & Canada)": "America/Denver",
        "(GMT-06:00) Central Time (US & Canada)": "America/Chicago",
        "(GMT-05:00) Eastern Time (US & Canada)": "America/New_York",
        "(GMT+00:00) London": "Europe/London",
        "(GMT+01:00) Berlin, Paris": "Europe/Berlin",
        "(GMT+03:00) Moscow, Nairobi": "Europe/Moscow",
        "(GMT+05:00) Pakistan": "Asia/Karachi",
        "(GMT+05:30) India": "Asia/Kolkata",
        "(GMT+08:00) Beijing, Singapore": "Asia/Shanghai",
        "(GMT+09:00) Tokyo, Seoul": "Asia/Tokyo",
        "(GMT+10:00) Sydney": "Australia/Sydney"
    };

    // 🔹 Parse "(GMT-05:00) Eastern Time ..." → -300 (minutes)
    function parseOffsetMinutes(tzLabel) {
        const m = tzLabel.match(/\(GMT([+-]\d{2}):(\d{2})\)/);
        if (!m) return 0;
        const sign = m[1][0]; // + or -
        const hours = parseInt(m[1].slice(1), 10);
        const mins = parseInt(m[2], 10);
        let total = hours * 60 + mins;
        if (sign === '-') total = -total;
        return total;
    }

    // Helper: convert "09:00 AM" -> "09:00"
    function to24Hour(timeStr) {
        if (!timeStr) return null;
        timeStr = timeStr.trim();
        const match = timeStr.match(/^(\d{1,2}):(\d{2})\s*([APMapm]{2})$/);
        if (!match) return null;

        let hour = parseInt(match[1], 10);
        const minute = match[2];
        const ampm = match[3].toUpperCase();

        if (ampm === 'PM' && hour !== 12) hour += 12;
        if (ampm === 'AM' && hour === 12) hour = 0;

        return String(hour).padStart(2, '0') + ':' + minute;
    }

    // 🔹 Build ISO in REAL UTC using timezone offset
    // dateYMD = "2025-11-24", time12h = "06:00 AM", offsetMinutes = -300 (for GMT-05:00)
    function buildISODateTime(dateYMD, time12h, offsetMinutes) {
        const t24 = to24Hour(time12h);
        if (!t24) return null;

        const [hh, mm] = t24.split(':').map(Number);
        const y = parseInt(dateYMD.slice(0, 4), 10);
        const m = parseInt(dateYMD.slice(5, 7), 10) - 1;
        const d = parseInt(dateYMD.slice(8, 10), 10);

        // Treat (y,m,d,hh,mm) as LOCAL time in that timezone,
        // then shift to real UTC by subtracting offset.
        const localAsUTCms = Date.UTC(y, m, d, hh, mm, 0);
        const utcMs = localAsUTCms - offsetMinutes * 60 * 1000;
        const finalDate = new Date(utcMs);

        return finalDate.toISOString(); // e.g. "2025-11-24T11:00:00.000Z" for 6:00 at GMT-05
    }

    // 🔹 Normalize any date string -> "YYYY-MM-DD"
    function normalizeYMD(dateStr) {
        if (!dateStr) return null;
        const trimmed = String(dateStr).trim();
        const direct = trimmed.match(/^(\d{4})-(\d{2})-(\d{2})$/);
        if (direct) {
            return direct[1] + '-' + direct[2] + '-' + direct[3];
        }
        const d = new Date(trimmed);
        if (isNaN(d.getTime())) {
            return null;
        }
        const y = d.getFullYear();
        const m = String(d.getMonth() + 1).padStart(2, '0');
        const dd = String(d.getDate()).padStart(2, '0');
        return `${y}-${m}-${dd}`;
    }

    // 🔹 Build repeatOn ISO using timezone offset (00:00 local for that date)
    function buildRepeatOnISO(dateYMD, offsetMinutes) {
        const y = parseInt(dateYMD.slice(0, 4), 10);
        const m = parseInt(dateYMD.slice(5, 7), 10) - 1;
        const d = parseInt(dateYMD.slice(8, 10), 10);

        const localAsUTCms = Date.UTC(y, m, d, 0, 0, 0);
        const utcMs = localAsUTCms - offsetMinutes * 60 * 1000;
        const finalDate = new Date(utcMs);
        return finalDate.toISOString();
    }

    // Build weekDays map from schedule
    function buildWeekDaysMap(scheduleArray) {
        const map = {
            mon: false,
            tue: false,
            wed: false,
            thu: false,
            fri: false,
            sat: false,
            sun: false
        };
        scheduleArray.forEach(s => {
            switch (s.day) {
                case 'Mon':
                    map.mon = true;
                    break;
                case 'Tue':
                    map.tue = true;
                    break;
                case 'Wed':
                    map.wed = true;
                    break;
                case 'Thu':
                    map.thu = true;
                    break;
                case 'Fri':
                    map.fri = true;
                    break;
                case 'Sat':
                    map.sat = true;
                    break;
                case 'Sun':
                    map.sun = true;
                    break;
            }
        });
        return map;
    }

    // Extract schedules
    function extractPeerTalkSchedules() {
        const scheduleArray = [];
        $parent.find('.peertalk_repeat_btn').each(function() {
            const $this = $(this);
            const text = $this.text().trim();

            const timeMatch = text.match(
                /(\d{1,2}:\d{2}\s?[APMapm]{2})\s*-\s*(\d{1,2}:\d{2}\s?[APMapm]{2})/
            );

            if (!timeMatch) {
                $this.addClass('field-error');
                return;
            }

            const startTime = timeMatch[1];
            const endTime = timeMatch[2];

            const dayPattern = /\b(Mon|Tue|Wed|Thu|Fri|Sat|Sun)\b/g;
            const dayMatches = text.match(dayPattern);

            if (dayMatches && dayMatches.length > 0) {
                dayMatches.forEach(function(day) {
                    scheduleArray.push({
                        day: day,
                        startTime: startTime,
                        endTime: endTime
                    });
                });
                $this.removeClass('field-error');
            } else {
                $this.addClass('field-error');
            }
        });
        console.log("🗓️ PeerTalk Schedule Array:", scheduleArray);
        return scheduleArray;
    }

    // Timezone dropdown
    $tzWrapper.on('click', function(e) {
        e.stopPropagation();
        $tzList.toggle();
        $parent.find('.conference_modal_dropdown_list, .color-dropdown-list').hide();
    });
    $tzList.find('li').on('click', function(e) {
        e.stopPropagation();
        $tzSelected.text($(this).text());
        $tzList.hide();
        $tzWrapper.removeClass('field-error');
    });

    // Color dropdown
    $colorToggle.click(function(e) {
        e.stopPropagation();
        $colorList.toggle();
        $parent.find(
            '.conference_modal_dropdown_list, .calendar_admin_details_cohort_tab_timezone_list'
        ).hide();
    });
    $colorList.find('.color-dropdown-color').click(function(e) {
        e.stopPropagation();
        const color = $(this).data('color');
        $colorToggle.data('selected-color', color);
        $colorToggle.find('.color-circle').css('background', color);
        $colorList.hide();
        $colorToggle.removeClass('field-error');
    });

    // Cohorts dropdown
    $parent.find('#peertalkCohortsDropdown').click(function(e) {
        e.stopPropagation();
        $parent.find('#peertalkCohortsDropdownList').toggle();
        $parent.find(
            '#peertalkTeachersDropdownList, #colorDropdownList_peertalk, #eventTimezoneDropdown_peertalk_list'
        ).hide();
    });

    $parent.find('#peertalkCohortsDropdownList').on('click', 'li.peertalk_cohort_item', function(e) {
        e.stopPropagation();
        const $item = $(this);
        const cohortName = $item.data('name') || $item.text().trim();
        const cohortId = $item.data('id');
        const cohortIdnumber = $item.data('idnumber');

        console.log('Peertalk Cohort clicked:', {
            cohortName,
            cohortId,
            cohortIdnumber
        });

        const $dropdown = $parent.find('#peertalkCohortsDropdown');
        const firstNode = $dropdown.contents().first()[0];
        if (firstNode) {
            firstNode.textContent = cohortName + " ";
        }
        $parent.find('#peertalkCohortsDropdownList').hide();

        if ($parent.find('.conference_modal_cohort_list li[data-cohort-id="' + cohortId + '"]').length ===
            0) {
            $parent.find('.conference_modal_cohort_list').append(`
                <li data-cohort-id="${cohortId}" data-cohort-name="${cohortName}" data-cohort-idnumber="${cohortIdnumber}">
                    <span class="conference_modal_attendee_name">
                        <span class="conference_modal_cohort_chip">${cohortName}</span> ${cohortName}
                    </span>
                    <span class="conference_modal_remove"><img src="./img/delete.svg" alt=""></span>
                </li>
            `);
        }
        $parent.find('#peertalkCohortsDropdown').removeClass('field-error');
    });

    // Teachers dropdown
    $parent.find('#peertalkTeachersDropdown').click(function(e) {
        e.stopPropagation();
        $parent.find('#peertalkTeachersDropdownList').toggle();
        $parent.find(
            '#peertalkCohortsDropdownList, #colorDropdownList_peertalk, #eventTimezoneDropdown_peertalk_list'
        ).hide();
    });

    $parent.find('#peertalkTeachersDropdownList').on('click', 'li.peertalk_teacher_item', function(e) {
        e.stopPropagation();
        const $item = $(this);
        const teacherName = $item.data('name') || $item.text().trim();
        const teacherId = $item.data('userid');
        const teacherImg = $item.data('img') || $item.find('img').attr('src');

        console.log('Peertalk Teacher clicked:', {
            teacherName,
            teacherId,
            teacherImg
        });

        const $dropdown = $parent.find('#peertalkTeachersDropdown');
        const firstNode = $dropdown.contents().first()[0];
        if (firstNode) {
            firstNode.textContent = teacherName + " ";
        }
        $parent.find('#peertalkTeachersDropdownList').hide();

        if ($parent.find('.conference_modal_attendees_list li[data-teacher-id="' + teacherId + '"]')
            .length === 0) {
            $parent.find('.conference_modal_attendees_list').append(`
                <li data-teacher-id="${teacherId}" data-teacher-name="${teacherName}">
                    <span class="conference_modal_attendee_name">
                        <img src="${teacherImg}" class="calendar_admin_details_create_cohort_teacher_avatar" alt="${teacherName}"> ${teacherName}
                    </span>
                    <span class="conference_modal_remove"><img src="./img/delete.svg" alt=""></span>
                </li>
            `);
        }
        $parent.find('#peertalkTeachersDropdown').removeClass('field-error');
    });

    // Remove items
    $parent.on('click', '.conference_modal_remove', function() {
        $(this).closest('li').fadeOut(200, function() {
            $(this).remove();
        });
    });

    // Search filters
    $parent.find('#searchCohorts_peertalk').on('keyup', function() {
        const filter = $(this).val().toLowerCase();
        $parent.find('.peertalk_cohort_item').each(function() {
            $(this).toggle($(this).text().toLowerCase().includes(filter));
        });
    });

    $parent.find('#searchTeachers_peertalk').on('keyup', function() {
        const filter = $(this).val().toLowerCase();
        $parent.find('.peertalk_teacher_item').each(function() {
            $(this).toggle($(this).text().toLowerCase().includes(filter));
        });
    });

    // View 2 dropdowns: Students
    $parent.find('#peertalkStudentsDropdown').click(function(e) {
        e.stopPropagation();
        $parent.find('#peertalkStudentsDropdownList').toggle();
        $parent.find(
            '#peertalkTeachersDropdownList2, #colorDropdownList_peertalk, #eventTimezoneDropdown_peertalk_list'
        ).hide();
    });

    $parent.find('#peertalkStudentsDropdownList').on('click', 'li.peertalk_student_item', function(e) {
        e.stopPropagation();
        const $item = $(this);
        const studentName = $item.data('name') || $item.text().trim();
        const studentId = $item.data('userid');
        const studentImg = $item.data('img') || $item.find('img').attr('src');

        const $dropdown = $parent.find('#peertalkStudentsDropdown');
        const firstNode = $dropdown.contents().first()[0];
        if (firstNode) {
            firstNode.textContent = studentName + " ";
        }
        $parent.find('#peertalkStudentsDropdownList').hide();

        if ($parent.find('.conference_modal_attendees_list li[data-student-id="' + studentId + '"]')
            .length === 0) {
            $parent.find('.conference_modal_students_list').append(`
                <li data-student-id="${studentId}" data-student-name="${studentName}">
                    <span class="conference_modal_attendee_name">
                        <img src="${studentImg}" class="calendar_admin_details_create_cohort_teacher_avatar" alt="${studentName}"> ${studentName}
                    </span>
                    <span class="conference_modal_remove"><img src="./img/delete.svg" alt=""></span>
                </li>
            `);
        }
        $parent.find('#peertalkStudentsDropdown').removeClass('field-error');
    });

    // View 2 dropdowns: Teachers2
    $parent.find('#peertalkTeachersDropdown2').click(function(e) {
        e.stopPropagation();
        $parent.find('#peertalkTeachersDropdownList2').toggle();
        $parent.find(
            '#peertalkStudentsDropdownList, #colorDropdownList_peertalk, #eventTimezoneDropdown_peertalk_list'
        ).hide();
    });

    $parent.find('#peertalkTeachersDropdownList2').on('click', 'li.peertalk_teacher_item', function(e) {
        e.stopPropagation();
        const $item = $(this);
        const teacherName = $item.data('name') || $item.text().trim();
        const teacherId = $item.data('userid');
        const teacherImg = $item.data('img') || $item.find('img').attr('src');

        const $dropdown = $parent.find('#peertalkTeachersDropdown2');
        const firstNode = $dropdown.contents().first()[0];
        if (firstNode) {
            firstNode.textContent = teacherName + " ";
        }
        $parent.find('#peertalkTeachersDropdownList2').hide();

        if ($parent.find('.conference_modal_attendees_list li[data-teacher-id="' + teacherId + '"]')
            .length === 0) {
            $parent.find('.conference_modal_attendees_list').append(`
                <li data-teacher-id="${teacherId}" data-teacher-name="${teacherName}">
                    <span class="conference_modal_attendee_name">
                        <img src="${teacherImg}" class="calendar_admin_details_create_cohort_teacher_avatar" alt="${teacherName}"> ${teacherName}
                    </span>
                    <span class="conference_modal_remove"><img src="./img/delete.svg" alt=""></span>
                </li>
            `);
        }
        $parent.find('#peertalkTeachersDropdown2').removeClass('field-error');
    });

    // View 2 search filters
    $parent.find('#searchStudents_peertalk').on('keyup', function() {
        const filter = $(this).val().toLowerCase();
        $parent.find('#peertalkStudentsList li').each(function() {
            $(this).toggle($(this).text().toLowerCase().includes(filter));
        });
    });

    $parent.find('#searchTeachers_peertalk2').on('keyup', function() {
        const filter = $(this).val().toLowerCase();
        $parent.find('#peertalkTeachersList2 .peertalk_teacher_item').each(function() {
            $(this).toggle($(this).text().toLowerCase().includes(filter));
        });
    });

    // Outside click closes dropdowns
    $(document).click(function(e) {
        if (!$(e.target).closest('#peerTalkTabContent').length) {
            $parent.find(
                '.conference_modal_dropdown_list, .color-dropdown-list, .calendar_admin_details_cohort_tab_timezone_list'
            ).hide();
        }
    });

    // Submit - use .off() first to prevent multiple bindings
    $form.off('submit').on('submit', function(e) {
        e.preventDefault();
        $parent.find('.field-error').removeClass('field-error');
        let isValid = true;

        const startDateBtn = $parent.find('.peertalk_modal_date_btn');
        const timezoneLabel = $tzSelected.text().trim();
        const cohorts = $parent.find('.conference_modal_cohort_list li');
        const teachers = $parent.find('.conference_modal_attendees_list li');
        const scheduleArray = extractPeerTalkSchedules();

        if (scheduleArray.length === 0) isValid = false;

        // Date validation
        const rawDate = startDateBtn.data('raw-date');
        let dateText = startDateBtn.text().trim();

        if (!dateText || dateText === 'Select Date') {
            startDateBtn.addClass('field-error');
            isValid = false;
        } else {
            let parsedDate = rawDate ? new Date(rawDate) : new Date(dateText);
            const today = new Date();
            today.setHours(0, 0, 0, 0);
            parsedDate.setHours(0, 0, 0, 0);

            if (isNaN(parsedDate.getTime()) || parsedDate < today) {
                startDateBtn.addClass('field-error');
                isValid = false;
            } else {
                startDateBtn.removeClass('field-error');
            }
        }

        if (!timezoneLabel || !timezoneLabel.includes('GMT')) {
            $tzWrapper.addClass('field-error');
            isValid = false;
        }

        // Color as CSS rgb(...)
        let color = $colorToggle.find('.color-circle').css('background-color');
        if (!color) {
            color = 'rgb(22, 53, 229)'; // fallback
        }

        if (cohorts.length === 0) {
            $parent.find('#peertalkCohortsDropdown').addClass('field-error');
            isValid = false;
        }
        if (teachers.length === 0) {
            $parent.find('#peertalkTeachersDropdown').addClass('field-error');
            isValid = false;
        }

        if (!isValid) {
            return;
        }

        // Normalize start date to YYYY-MM-DD
        let startDateISO = null;
        if (rawDate) {
            startDateISO = rawDate;
        } else {
            const parsed = new Date(dateText);
            if (!isNaN(parsed.getTime())) {
                const y = parsed.getFullYear();
                const m = String(parsed.getMonth() + 1).padStart(2, '0');
                const d = String(parsed.getDate()).padStart(2, '0');
                startDateISO = `${y}-${m}-${d}`;
            }
        }

        const offsetMinutes = parseOffsetMinutes(timezoneLabel);
        const timezoneId = TIMEZONE_MAP[timezoneLabel] || null;

        // Extract cohort IDs
        const cohortIds = [];
        $parent.find('.conference_modal_cohort_list li').each(function() {
            const cohortId = $(this).data('cohort-id');
            if (cohortId) {
                cohortIds.push(String(cohortId));
            }
        });

        // Extract student IDs from the students list
        const studentIds = [];
        $parent.find('.conference_modal_students_list li').each(function() {
            const studentId = $(this).data('student-id');
            if (studentId) {
                studentIds.push(String(studentId));
            }
        });

        const teacherIds = teachers.map(function() {
            return String($(this).data('teacher-id'));
        }).get();

        // Decide classType from repeat label
        const repeatLabelRaw = $parent.find('.peertalk_repeat_btn').text().trim().toLowerCase();
        let classType = 'single';

        if (repeatLabelRaw.startsWith('does not repeat')) {
            classType = 'single';
        } else if (repeatLabelRaw.includes('week')) {
            classType = 'weekly';
        } else {
            if (scheduleArray.length > 1) {
                const times = scheduleArray.map(s => s.startTime + '-' + s.endTime);
                const unique = Array.from(new Set(times));
                classType = (unique.length === 1) ? 'weekly' : 'multi';
            }
        }

        // 🔹 Compute "end" and "repeatOn" from your repeat UI
        let endValue = 'Never'; // default
        let repeatOnISO = null; // null unless 'date'

        if ($repeatEndType.length) {
            let rawEndType = ($repeatEndType.val() || $repeatEndType.text() || '').trim().toLowerCase();

            if (!rawEndType || rawEndType === 'never') {
                endValue = 'Never';
            } else if (rawEndType === 'on' || rawEndType === 'date') {
                endValue = 'date';
            } else if (!isNaN(rawEndType)) {
                // "10" => 10 occurrences
                endValue = parseInt(rawEndType, 10);
            }
        }

        if (endValue === 'date' && $repeatEndDateBtn.length) {
            const endRaw = $repeatEndDateBtn.data('raw-date') || $repeatEndDateBtn.text();
            const endYMD = normalizeYMD(endRaw);
            if (endYMD) {
                repeatOnISO = buildRepeatOnISO(endYMD, offsetMinutes);
            }
        }

        const payloads = [];

        // Check if this is an update (editing existing event)
        const eventId = $form.data('eventId');

        if (classType === 'single') {
            const slot = scheduleArray[0];
            const startISO = buildISODateTime(startDateISO, slot.startTime, offsetMinutes);
            const finishISO = buildISODateTime(startDateISO, slot.endTime, offsetMinutes);

            const payload = {
                edit: eventId ? true : false,
                id: eventId ? eventId : null,
                startTimeEvent: startISO,
                finishTimeEvent: finishISO,
                color: color,
                cohorts: cohortIds,
                teachers: teacherIds,
                students: studentIds,
                timezone: timezoneId,
                repeat: {
                    active: false
                }
            };
            payloads.push(payload);

        } else if (classType === 'weekly') {
            const slot = scheduleArray[0];
            const startISO = buildISODateTime(startDateISO, slot.startTime, offsetMinutes);
            const finishISO = buildISODateTime(startDateISO, slot.endTime, offsetMinutes);
            const weekDays = buildWeekDaysMap(scheduleArray);

            const repeatData = {
                active: true,
                repeatEvery: 1,
                type: 'week',
                weekDays: weekDays,
                end: endValue
            };

            if (endValue === 'date' && repeatOnISO) {
                repeatData.repeatOn = repeatOnISO;
            }

            const payload = {
                edit: eventId ? true : false,
                id: eventId ? eventId : null,
                startTimeEvent: startISO,
                finishTimeEvent: finishISO,
                color: color,
                cohorts: cohortIds,
                teachers: teacherIds,
                students: studentIds,
                timezone: timezoneId,
                repeat: repeatData
            };
            payloads.push(payload);

        } else {
            // multi: different times -> multiple single events
            scheduleArray.forEach(slot => {
                const startISO = buildISODateTime(startDateISO, slot.startTime, offsetMinutes);
                const finishISO = buildISODateTime(startDateISO, slot.endTime, offsetMinutes);

                const payload = {
                    edit: eventId ? true : false,
                    id: eventId ? eventId : null,
                    startTimeEvent: startISO,
                    finishTimeEvent: finishISO,
                    color: color,
                    cohorts: cohortIds,
                    teachers: teacherIds,
                    students: studentIds,
                    timezone: timezoneId,
                    repeat: {
                        active: false
                    }
                };
                payloads.push(payload);
            });
        }

        console.log('✅ Final payloads for saveclass.php:', payloads);

        // Show loader
        const loader = document.getElementById('loader');
        if (loader) loader.style.display = 'flex';

        const requests = payloads.map(p =>
            fetch(apiUrl, {
                method: 'POST',
                credentials: 'same-origin',
                headers: {
                    'Content-Type': 'application/json',
                    'Accept': 'application/json'
                },
                body: JSON.stringify(p)
            }).then(res => res.json())
        );

        Promise.all(requests)
            .then(results => {
                console.log('📦 Responses from saveclass.php:', results);

                // Check if all requests were successful
                // API returns objects with various success indicators
                const allSuccess = results.every(r => {
                    if (!r) return false;
                    // Check for common success indicators in the API response
                    return r.success === true || r.ok === true || r.status === 'success' ||
                        (r.error === false || r.error === undefined || r.error === null);
                });

                // Count successful requests for better feedback
                const successCount = results.filter(r => {
                    if (!r) return false;
                    return r.success === true || r.ok === true || r.status === 'success' ||
                        (r.error === false || r.error === undefined || r.error === null);
                }).length;

                console.log(
                    `✅ Successfully created ${successCount}/${results.length} Peer Talk events`);

                if (allSuccess) {
                    // Success: show toast and reset form
                    const successMessage = eventId ? 'Peer Talk updated successfully!' : 'Peer Talk created successfully!';
                    if (typeof showToast === 'function') {
                        showToast(successMessage, 'success');
                    } else {
                        alert('🎉 ' + successMessage);
                    }

                    if (window.refetchCustomPluginData) {
                        window.refetchCustomPluginData('create-peertalk');
                    } else if (window.fetchCalendarEvents) {
                        window.fetchCalendarEvents();
                    }

                    // Reset peer talk form
                    resetPeerTalkForm();
                } else if (successCount > 0) {
                    // Partial success
                    if (typeof showToast === 'function') {
                        showToast(`${successCount} of ${results.length} Peer Talk events created`,
                            'warning');
                    } else {
                        alert(`⚠️ ${successCount} of ${results.length} Peer Talk events created`);
                    }
                    if (window.refetchCustomPluginData) {
                        window.refetchCustomPluginData('create-peertalk-partial');
                    } else if (window.fetchCalendarEvents) {
                        window.fetchCalendarEvents();
                    }
                } else {
                    // Complete failure
                    if (typeof showToast === 'function') {
                        showToast('Failed to create Peer Talk events', 'error');
                    } else {
                        alert('❌ Failed to create Peer Talk events');
                    }
                }
            })
            .catch(err => {
                console.error('❌ Error calling saveclass.php:', err);
                if (typeof showToast === 'function') {
                    showToast('Error creating Peer Talk', 'error');
                } else {
                    alert('❌ Error creating Peer Talk');
                }
            })
            .finally(() => {
                if (loader) loader.style.display = 'none';
            });
    });

    // Clear errors on click
    $parent.on('click change', '.peertalk_modal_date_btn, .conference_modal_dropdown_btn', function() {
        $(this).removeClass('field-error');
    });

    // Reset PeerTalk Form
    window.resetPeerTalkForm = function resetPeerTalkForm() {
        // Reset date button
        $parent.find('.peertalk_modal_date_btn').text('Select Date');

        // Reset timezone to default
        $('#eventTimezoneDropdown_peertalk_selected').text('(GMT-05:00) Eastern Time (US & Canada)');

        // Reset color to default (blue)
        $('#colorDropdownToggle_peertalk').find('.color-circle').css('background', '#1649c7');

        // Clear cohorts list
        $parent.find('.conference_modal_cohort_list').empty();

        // Clear teachers list
        $parent.find('.conference_modal_attendees_list').empty();

        // Clear schedule rows
        $parent.find('.conference_modal_time_row').remove();

        // Reset repeat button
        $parent.find('.peertalk_repeat_btn').html(
            'Does not repeat <span style="float:right; font-size:1rem;"><img src="./img/dropdown-arrow-down.svg" alt=""></span>'
        );

        // Reset button text and clear event ID
        $form.removeData('eventId');
        $parent.find('.peertalk_modal_btn').text('Schedule Peer Talk');

        console.log('✅ PeerTalk form reset');
    };
})();
</script>

<link rel="stylesheet" href="<?php echo $CFG->wwwroot; ?>/local/customplugin/css/calendar_admin_details_create_cohort_peertalk_tab.css">
