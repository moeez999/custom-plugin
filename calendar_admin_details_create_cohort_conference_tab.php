<!-- ✅ Conference Tab Form -->
<div id="conferenceTabContent" style="display:none;">
    <form id="conferenceForm">
        <label class="addtime-label" style="margin-top:16px;">Conference Title</label>
        <input type="text" class="addtime-title-input" value="Conference Title" />

        <div class="conference_modal_schedule">
            <img src="./img/conference-schedule.svg" alt=""> Conference Schedule
        </div>

        <div class="conference_modal_repeat_row">
            <div style="width:50%;">
                <div class="conference_modal_repeat_btn" style="border-bottom:2.5px solid #fe2e0c;">
                    Does not repeat
                    <span style="float:right; font-size:1rem;"><img src="./img/dropdown-arrow-down.svg" alt=""></span>
                </div>
            </div>
            <div
                style="display:flex; gap:12px; align-items:center; margin-bottom:7px;width:100%;justify-content:space-around;">
                <div class="conference_modal_label" style="font-weight:400;">Start On</div>
                <button type="button" class="conference_modal_date_btn">Select Date</button>
            </div>
        </div>

        <div
            style="display:flex; gap:12px; align-items:center; margin-bottom:7px; justify-content:space-between;width:100%;">
            <div class="calendar_admin_details_cohort_tab_timezone_wrapper" style="margin-top:10px;width:100%;">
                <label class="calendar_admin_details_cohort_tab_timezone_label">Event time zone</label>
                <div class="calendar_admin_details_cohort_tab_timezone_dropdown"
                    id="eventTimezoneDropdown_conference_tab_wrapper">
                    <span id="eventTimezoneDropdown_conference_tab_selected">(GMT-05:00) Eastern Time (US &
                        Canada)</span>
                    <img class="calendar_admin_details_cohort_tab_timezone_arrow" src="./img/dropdown-arrow-down.svg"
                        alt="">
                    <div class="calendar_admin_details_cohort_tab_timezone_list"
                        id="eventTimezoneDropdown_conference_tab_list">
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
                    <button type="button" class="color-dropdown-toggle" id="colorDropdownToggle" style="width:75px;">
                        <span class="color-circle" style="background:#1649c7"></span>
                        <span style="float:right; font-size:1rem;">
                            <img class="calendar_admin_details_cohort_tab_timezone_arrow"
                                src="./img/dropdown-arrow-down.svg" alt="">
                        </span>
                    </button>
                    <div class="color-dropdown-list" id="colorDropdownList">
                        <div class="color-dropdown-color" data-color="#1649c7" style="background:#1649c7"></div>
                        <div class="color-dropdown-color" data-color="#20a88e" style="background:#20a88e"></div>
                        <div class="color-dropdown-color" data-color="#3f3f48" style="background:#3f3f48"></div>
                        <div class="color-dropdown-color" data-color="#fe2e0c" style="background:#fe2e0c"></div>
                        <div class="color-dropdown-color" data-color="#daa520" style="background:#daa520"></div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Navigation Header -->
        <div style="display: flex; justify-content: space-between; align-items: center; margin: 20px 0 10px 0;">
            <h3 style="margin: 0; font-size: 16px; font-weight: 600;">Conference Participants</h3>
            <div style="display: flex; gap: 8px;">
                <button type="button" class="conference-nav-prev"
                    style="width: 32px; height: 32px; border: 1px solid #ddd; background: white; border-radius: 6px; cursor: pointer; display: flex; align-items: center; justify-content: center;">
                    <img src="./img/prev.svg" alt="">
                </button>
                <button type="button" class="conference-nav-next"
                    style="width: 32px; height: 32px; border: 1px solid #ddd; background: white; border-radius: 6px; cursor: pointer; display: flex; align-items: center; justify-content: center;">
                    <img src="./img/next.svg" alt="">
                </button>
            </div>
        </div>

        <!-- View 1: Teachers & Cohorts -->
        <div class="main-conference-participants-container">
            <div class="conference-view-1" style="display: block;">
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
                        <div class="conference_modal_dropdown_btn" id="conferenceCohortsDropdown">
                            Select Cohort
                            <span style="float:right; font-size:1rem;"><img src="./img/dropdown-arrow-down.svg"
                                    alt=""></span>
                        </div>
                        <div class="conference_modal_dropdown_list" id="conferenceCohortsDropdownList">
                            <input type="text" id="searchCohorts" class="dropdown-search"
                                placeholder="Search cohorts...">
                            <ul id="conferenceCohortsList">
                                <?php
                if ($cohorts) {
                    foreach ($cohorts as $c) {
                        $shortname = format_string($c->name);
                        $idn       = trim((string)$c->idnumber);
                        echo '<li class="conference_cohort_item"
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
                        <div class="conference_modal_dropdown_btn" id="conferenceTeachersDropdown">
                            Select Teacher
                            <span style="float:right; font-size:1rem;"><img src="./img/dropdown-arrow-down.svg"
                                    alt=""></span>
                        </div>
                        <div class="conference_modal_dropdown_list" id="conferenceTeachersDropdownList">
                            <input type="text" id="searchTeachers" class="dropdown-search"
                                placeholder="Search teachers...">
                            <ul id="conferenceTeachersList">
                                <?php
                if (!empty($teachers)) {
                    foreach ($teachers as $teacher) {
                        $picture = new user_picture($teacher);
                        $picture->size = 40;
                        $imageurl = $picture->get_url($PAGE)->out(false);
                        $fullname = fullname($teacher, true);
                        echo '<li class="conference_teacher_item"
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
                    <div>
                        <span class="conference_modal_label">Select Students</span>
                        <div class="conference_modal_dropdown_btn" id="conferenceStudentsDropdown">
                            Select Students
                            <span style="float:right; font-size:1rem;">
                                <img src="./img/dropdown-arrow-down.svg" alt="">
                            </span>
                        </div>
                        <div class="conference_modal_dropdown_list" id="conferenceStudentsDropdownList">
                            <input type="text" id="searchStudents_conference" class="dropdown-search"
                                placeholder="Search students...">
                            <ul id="conferenceStudentsList">
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
                                        echo '<li class="conference_student_item"
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
                </div>
            </div>
            <div class="conferenceParticipantsLists-container">
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
        <button type="submit" class="conference_modal_btn">Schedule Conference</button>
    </form>
</div>

<!-- ✅ JS -->
<script>
(function() {
    // Use IIFE to avoid multiple bindings
    const $parent = $('#conferenceTabContent');
    const $form = $parent.find('#conferenceForm');
    const $tzWrapper = $parent.find('#eventTimezoneDropdown_conference_tab_wrapper');
    const $tzList = $parent.find('#eventTimezoneDropdown_conference_tab_list');
    const $tzSelected = $parent.find('#eventTimezoneDropdown_conference_tab_selected');
    const $colorToggle = $parent.find('#colorDropdownToggle');
    const $colorList = $parent.find('#colorDropdownList');

    // View navigation
    const $view1 = $parent.find('.conference-view-1');
    const $view2 = $parent.find('.conference-view-2');
    const $navNext = $parent.find('.conference-nav-next');
    const $navPrev = $parent.find('.conference-nav-prev');
    const $studentlist = $parent.find('.conference_modal_attendees_section').eq(1);
    const $cohortlist = $parent.find('.conference_modal_attendees_section').first();
    const $participants = $parent.find('.main-conference-participants-container');

    // Navigation click handlers
    $navNext.on('click', function() {
        const scrollAmount = 300; // Adjust this value as needed
        const currentScroll = $participants.scrollLeft();
        $participants.animate({
            scrollLeft: currentScroll + scrollAmount
        }, 300, 'swing');
    });

    $navPrev.on('click', function() {
        const scrollAmount = 300; // Adjust this value as needed
        const currentScroll = $participants.scrollLeft();
        $participants.animate({
            scrollLeft: currentScroll - scrollAmount
        }, 300, 'swing');

    });

    // ✅ Extract and validate schedule info (days + times)
    function extractConferenceSchedules() {
        const scheduleArray = [];
        $parent.find('.conference_modal_repeat_btn').each(function() {
            const $this = $(this);
            const text = $this.text().trim();

            // Match time first: "09:00 AM - 10:00 AM"
            const timeMatch = text.match(
                /(\d{1,2}:\d{2}\s?[APMapm]{2})\s*-\s*(\d{1,2}:\d{2}\s?[APMapm]{2})/);

            if (!timeMatch) {
                // No time found, mark as error
                $this.addClass('field-error');
                return; // continue to next iteration
            }

            const startTime = timeMatch[1];
            const endTime = timeMatch[2];

            // Extract all days from text
            const dayPattern = /\b(Mon|Tue|Wed|Thu|Fri|Sat|Sun)\b/g;
            const dayMatches = text.match(dayPattern);

            if (dayMatches && dayMatches.length > 0) {
                // Found one or more days - create schedule entry for each
                dayMatches.forEach(function(day) {
                    scheduleArray.push({
                        day: day,
                        startTime: startTime,
                        endTime: endTime
                    });
                });
                $this.removeClass('field-error');
            } else {
                // No days found, mark as error
                $this.addClass('field-error');
            }
        });
        console.log("🗓️ Conference Schedule Array:", scheduleArray);
        return scheduleArray;
    }

    // Timezone Dropdown
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

    // Color Dropdown
    $colorToggle.click(function(e) {
        e.stopPropagation();
        $colorList.toggle();
        $parent.find(
                '.conference_modal_dropdown_list, .calendar_admin_details_cohort_tab_timezone_list')
            .hide();
    });
    $colorList.find('.color-dropdown-color').click(function(e) {
        e.stopPropagation();
        const color = $(this).data('color');
        $colorToggle.data('selected-color', color);
        $colorToggle.find('.color-circle').css('background', color);
        $colorList.hide();
        $colorToggle.removeClass('field-error');
    });

    // Cohorts Dropdown
    $parent.find('#conferenceCohortsDropdown').click(function(e) {
        e.stopPropagation();
        $parent.find('#conferenceCohortsDropdownList').toggle();
        $parent.find(
                '#conferenceTeachersDropdownList, #colorDropdownList, #eventTimezoneDropdown_conference_tab_list'
            )
            .hide();
    });
    $parent.find('#conferenceCohortsDropdownList').on('click', 'li.conference_cohort_item', function(e) {
        e.stopPropagation();
        const $item = $(this);
        const cohortName = $item.data('name') || $item.text().trim();
        const cohortId = $item.data('id');
        const cohortIdnumber = $item.data('idnumber');

        console.log('Conference Cohort clicked:', {
            cohortName,
            cohortId,
            cohortIdnumber
        });

        const $dropdown = $parent.find('#conferenceCohortsDropdown');
        const firstNode = $dropdown.contents().first()[0];
        if (firstNode) {
            firstNode.textContent = cohortName + " ";
        }
        $parent.find('#conferenceCohortsDropdownList').hide();

        if ($parent.find('.conference_modal_cohort_list li[data-cohort-id="' + cohortId + '"]')
            .length === 0) {
            $parent.find('.conference_modal_cohort_list').append(`
                <li data-cohort-id="${cohortId}" data-cohort-name="${cohortName}" data-cohort-idnumber="${cohortIdnumber}">
                    <span class="conference_modal_attendee_name">
                        <span class="conference_modal_cohort_chip">${cohortName}</span> ${cohortName}
                    </span>
                    <span class="conference_modal_remove"><img src="./img/delete.svg" alt=""></span>
                </li>
            `);
        }
        $parent.find('#conferenceCohortsDropdown').removeClass('field-error');
    });

    // Teachers Dropdown
    $parent.find('#conferenceTeachersDropdown').click(function(e) {
        e.stopPropagation();
        $parent.find('#conferenceTeachersDropdownList').toggle();
        $parent.find(
                '#conferenceCohortsDropdownList, #colorDropdownList, #eventTimezoneDropdown_conference_tab_list'
            )
            .hide();
    });
    $parent.find('#conferenceTeachersDropdownList').on('click', 'li.conference_teacher_item', function(e) {
        e.stopPropagation();
        const $item = $(this);
        const teacherName = $item.data('name') || $item.text().trim();
        const teacherId = $item.data('userid');
        const teacherImg = $item.data('img') || $item.find('img').attr('src');

        console.log('Conference Teacher clicked:', {
            teacherName,
            teacherId,
            teacherImg
        });

        const $dropdown = $parent.find('#conferenceTeachersDropdown');
        const firstNode = $dropdown.contents().first()[0];
        if (firstNode) {
            firstNode.textContent = teacherName + " ";
        }
        $parent.find('#conferenceTeachersDropdownList').hide();

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
        $parent.find('#conferenceTeachersDropdown').removeClass('field-error');
    });

    // View 2 dropdowns: Students
    $parent.find('#conferenceStudentsDropdown').click(function(e) {
        e.stopPropagation();
        $parent.find('#conferenceStudentsDropdownList').toggle();
        $parent.find(
            '#conferenceTeachersDropdownList2, #colorDropdownList, #eventTimezoneDropdown_conference_tab_list'
        ).hide();
    });

    $parent.find('#conferenceStudentsDropdownList').on('click', 'li.conference_student_item', function(e) {
        e.stopPropagation();
        const $item = $(this);
        const studentName = $item.data('name') || $item.text().trim();
        const studentId = $item.data('userid');
        const studentImg = $item.data('img') || $item.find('img').attr('src');

        const $dropdown = $parent.find('#conferenceStudentsDropdown');
        const firstNode = $dropdown.contents().first()[0];
        if (firstNode) {
            firstNode.textContent = studentName + " ";
        }
        $parent.find('#conferenceStudentsDropdownList').hide();

        if ($parent.find('.conference_modal_students_list li[data-student-id="' + studentId + '"]')
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
        $parent.find('#conferenceStudentsDropdown').removeClass('field-error');
    });

    // View 2 dropdowns: Teachers2
    $parent.find('#conferenceTeachersDropdown2').click(function(e) {
        e.stopPropagation();
        $parent.find('#conferenceTeachersDropdownList2').toggle();
        $parent.find(
            '#conferenceStudentsDropdownList, #colorDropdownList, #eventTimezoneDropdown_conference_tab_list'
        ).hide();
    });

    $parent.find('#conferenceTeachersDropdownList2').on('click', 'li.conference_teacher_item', function(e) {
        e.stopPropagation();
        const $item = $(this);
        const teacherName = $item.data('name') || $item.text().trim();
        const teacherId = $item.data('userid');
        const teacherImg = $item.data('img') || $item.find('img').attr('src');

        const $dropdown = $parent.find('#conferenceTeachersDropdown2');
        const firstNode = $dropdown.contents().first()[0];
        if (firstNode) {
            firstNode.textContent = teacherName + " ";
        }
        $parent.find('#conferenceTeachersDropdownList2').hide();

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
        $parent.find('#conferenceTeachersDropdown2').removeClass('field-error');
    });

    // Remove items - scoped to parent
    $parent.on('click', '.conference_modal_remove', function() {
        $(this).closest('li').fadeOut(200, function() {
            $(this).remove();
        });
    });

    // Search filters
    $parent.find('#searchCohorts').on('keyup', function() {
        const filter = $(this).val().toLowerCase();
        $parent.find('.conference_cohort_item').each(function() {
            $(this).toggle($(this).text().toLowerCase().includes(filter));
        });
    });

    $parent.find('#searchTeachers').on('keyup', function() {
        const filter = $(this).val().toLowerCase();
        $parent.find('.conference_teacher_item').each(function() {
            $(this).toggle($(this).text().toLowerCase().includes(filter));
        });
    });

    // View 2 search filters
    $parent.find('#searchStudents_conference').on('keyup', function() {
        const filter = $(this).val().toLowerCase();
        $parent.find('#conferenceStudentsList li').each(function() {
            $(this).toggle($(this).text().toLowerCase().includes(filter));
        });
    });

    $parent.find('#searchTeachers_conference2').on('keyup', function() {
        const filter = $(this).val().toLowerCase();
        $parent.find('#conferenceTeachersList2 .conference_teacher_item').each(function() {
            $(this).toggle($(this).text().toLowerCase().includes(filter));
        });
    });

    // Outside click closes dropdowns
    $(document).click(function(e) {
        if (!$(e.target).closest('#conferenceTabContent').length) {
            $parent.find(
                '.conference_modal_dropdown_list, .color-dropdown-list, .calendar_admin_details_cohort_tab_timezone_list'
            ).hide();
        }
    });

    // ✅ Validation & Submit
    $form.off('submit').on('submit', function(e) {
        e.preventDefault();
        $parent.find('.field-error').removeClass('field-error');
        let isValid = true;

        const title = $parent.find('.addtime-title-input').val().trim();
        const startDateBtn = $parent.find('.conference_modal_date_btn');
        const startDate = startDateBtn.text().trim();
        const timezone = $tzSelected.text().trim();
        const color = $colorToggle.find('.color-circle').css('background-color');
        const cohorts = $parent.find('.conference_modal_cohort_list li');
        const students = $parent.find('.conference_modal_students_list li');
        const teachers = $parent.find('.conference_modal_attendees_list li');
        const scheduleArray = extractConferenceSchedules();

        if (!title) {
            $parent.find('.addtime-title-input').addClass('field-error');
            isValid = false;
        }
        if (scheduleArray.length === 0) isValid = false;
        // ✅ Date validation
        let dateText = $parent.find('.conference_modal_date_btn').last().text().trim();
        let parsedDate = new Date(dateText);
        if (!dateText || dateText === 'Select Date' || isNaN(parsedDate.getTime())) {
            $parent.find('.conference_modal_date_btn').addClass('field-error');
            isValid = false;
        } else {
            // Optional: Prevent past dates
            const today = new Date();
            today.setHours(0, 0, 0, 0);
            if (parsedDate < today) {
                $parent.find('.conference_modal_date_btn').addClass('field-error');
                isValid = false;
            } else {
                $parent.find('.conference_modal_date_btn').removeClass('field-error');
            }
        }

        if (!timezone || !timezone.includes('GMT')) {
            $tzWrapper.addClass('field-error');
            isValid = false;
        }
        if (!color) {
            $colorToggle.addClass('field-error');
            isValid = false;
        }
        if (cohorts.length === 0 && students.length === 0) {
            $parent.find('#conferenceCohortsDropdown').addClass('field-error');
            $parent.find('#conferenceStudentsDropdown').addClass('field-error');
            isValid = false;
        }
        if (teachers.length === 0) {
            $parent.find('#conferenceTeachersDropdown').addClass('field-error');
            isValid = false;
        }

        if (!isValid) {
            return;
        }

        // Collect cohort IDs
        const cohortIds = [];
        cohorts.each(function() {
            cohortIds.push($(this).data('cohort-id'));
        });

        // Collect student IDs
        const studentIds = [];
        students.each(function() {
            studentIds.push($(this).data('student-id'));
        });

        // Collect teacher IDs
        const teacherIds = [];
        teachers.each(function() {
            teacherIds.push($(this).data('teacher-id'));
        });

        const payload = {
            title,
            startDate,
            timezone,
            color,
            scheduleArray,
            cohorts: cohorts.map(function() {
                return {
                    id: $(this).data('cohort-id'),
                    name: $(this).data('cohort-name'),
                    idnumber: $(this).data('cohort-idnumber')
                };
            }).get(),
            students: students.map(function() {
                return {
                    id: $(this).data('student-id'),
                    name: $(this).data('student-name')
                };
            }).get(),
            teachers: teachers.map(function() {
                return {
                    id: $(this).data('teacher-id'),
                    name: $(this).data('teacher-name')
                };
            }).get(),
            submittedAt: new Date().toISOString()
        };

        // Check if this is an update (editing existing event)
        const eventId = $form.data('eventId');
        if (eventId) {
            payload.id = eventId;
            payload.action = 'update';
        }

        console.log('✅ Conference Payload:', payload);

        // ================================
        //  🔥 SHOW LOADER & MAKE API CALL
        // ================================
        const loader = document.getElementById('loader');
        if (loader) loader.style.display = 'flex';

        const apiUrl = M.cfg.wwwroot + '/local/customplugin/ajax/create_conference.php';
        fetch(apiUrl, {
                method: 'POST',
                credentials: 'same-origin',
                headers: {
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify(payload)
            })
            .then(async (response) => {
                const res = await response.json();
                console.log("📌 Conference API Response:", res);

                if (!response.ok || !res.success) {
                    const action = eventId ? 'update' : 'create';
                    if (typeof showToast === 'function') {
                        showToast("Failed to " + action + " conference: " + (res.message ||
                            "Unknown error"), 'error');
                    } else {
                        alert("❌ Failed to " + action + " conference: " + (res.message ||
                            "Unknown error"));
                    }
                    return;
                }

                // Success: show toast and reset form
                const successMessage = eventId ? 'Conference updated successfully!' : 'Conference created successfully!';
                if (typeof showToast === 'function') {
                    showToast(successMessage, 'success');
                } else {
                    alert("🎉 " + successMessage);
                }

                if (window.refetchCustomPluginData) {
                    window.refetchCustomPluginData('create-conference');
                } else if (window.fetchCalendarEvents) {
                    window.fetchCalendarEvents();
                }

                // Reset conference form
                resetConferenceForm();
            })
            .catch(err => {
                console.error("❌ Conference API Error:", err);
                if (typeof showToast === 'function') {
                    showToast('Server error while creating conference', 'error');
                } else {
                    alert("Server error while creating conference.");
                }
            })
            .finally(() => {
                if (loader) loader.style.display = 'none';
            });
    });

    // Auto clear errors - scoped to parent
    $parent.on('click change',
        '.addtime-title-input, .conference_modal_date_btn, .conference_modal_dropdown_btn',
        function() {
            $(this).removeClass('field-error');
        });

    // Reset Conference Form
    window.resetConferenceForm = function resetConferenceForm() {
        // Reset title
        $parent.find('.addtime-title-input').val('Conference Title');

        // Reset date button
        $parent.find('.conference_modal_date_btn').text('Select Date');

        // Reset timezone to default
        $('#eventTimezoneDropdown_conference_tab_selected').text('(GMT-05:00) Eastern Time (US & Canada)');

        // Reset color to default (blue)
        $colorToggle.find('.color-circle').css('background', '#1649c7');

        // Clear cohorts list
        $parent.find('.conference_modal_cohort_list').empty();

        // Clear students list
        $parent.find('.conference_modal_students_list').empty();

        // Clear teachers list
        $parent.find('.conference_modal_attendees_list').empty();

        // Clear schedule rows
        $parent.find('.conference_modal_time_row').remove();

        // Reset repeat button
        $parent.find('.conference_modal_repeat_btn').html(
            'Does not repeat <span style="float:right; font-size:1rem;"><img src="./img/dropdown-arrow-down.svg" alt=""></span>'
        );

        // Reset button text and clear event ID
        $form.removeData('eventId');
        $parent.find('.conference_modal_btn').text('Schedule Conference');

        console.log('✅ Conference form reset');
    };
})();
</script>

<link rel="stylesheet" href="<?php echo $CFG->wwwroot; ?>/local/customplugin/css/calendar_admin_details_create_cohort_conference_tab.css">