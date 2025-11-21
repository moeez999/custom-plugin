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

        <!-- Cohorts & Teachers -->
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
        </div>

        <div class="conference_modal_lists_row">
            <div class="conference_modal_attendees_section">
                <ul class="conference_modal_cohort_list"></ul>
            </div>
            <div class="conference_modal_attendees_section">
                <ul class="conference_modal_attendees_list"></ul>
            </div>
        </div>

        <button type="submit" class="peertalk_modal_btn">Schedule Peer Talk</button>
    </form>
</div>

<!-- ✅ JS -->
<script>
$(document).ready(function() {
    const $parent = $('#peerTalkTabContent');
    const $form = $parent.find('#peerTalkForm');
    const $tzWrapper = $parent.find('#eventTimezoneDropdown_peertalk_wrapper');
    const $tzList = $parent.find('#eventTimezoneDropdown_peertalk_list');
    const $tzSelected = $parent.find('#eventTimezoneDropdown_peertalk_selected');
    const $colorToggle = $parent.find('#colorDropdownToggle_peertalk');
    const $colorList = $parent.find('#colorDropdownList_peertalk');

    // ✅ Extract and validate schedule info (days + times)
    function extractPeerTalkSchedules() {
        const scheduleArray = [];
        $parent.find('.peertalk_repeat_btn').each(function() {
            const $this = $(this);
            const text = $this.text().trim();

            // Match time first: "09:00 AM - 10:00 AM"
            const timeMatch = text.match(
                /(\d{1,2}:\d{2}\s?[APMapm]{2})\s*-\s*(\d{1,2}:\d{2}\s?[APMapm]{2})/);

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
        $colorToggle.find('.color-circle').css('background', color);
        $colorList.hide();
        $colorToggle.removeClass('field-error');
    });

    // Cohorts Dropdown
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
        $parent.find('#peertalkCohortsDropdown').removeClass('field-error');
    });

    // Teachers Dropdown
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

    // Outside click closes dropdowns
    $(document).click(function(e) {
        if (!$(e.target).closest('#peerTalkTabContent').length) {
            $parent.find(
                '.conference_modal_dropdown_list, .color-dropdown-list, .calendar_admin_details_cohort_tab_timezone_list'
            ).hide();
        }
    });

    // ✅ Validation & Submit
    $form.on('submit', function(e) {
        e.preventDefault();
        $parent.find('.field-error').removeClass('field-error');
        let isValid = true;

        const startDateBtn = $parent.find('.peertalk_modal_date_btn');
        const startDate = startDateBtn.text().trim();
        const timezone = $tzSelected.text().trim();
        const color = $colorToggle.find('.color-circle').css('background-color');
        const cohorts = $parent.find('.conference_modal_cohort_list li');
        const teachers = $parent.find('.conference_modal_attendees_list li');
        const scheduleArray = extractPeerTalkSchedules();

        if (scheduleArray.length === 0) isValid = false;

        // Validate date using raw-date data attribute or text
        const rawDate = startDateBtn.data('raw-date');
        let dateText = startDateBtn.text().trim();

        console.log('Date Validation:', {
            rawDate,
            dateText
        });

        if (!dateText || dateText === 'Select Date') {
            console.log('Date validation failed: no date text');
            startDateBtn.addClass('field-error');
            isValid = false;
        } else {
            // Use raw date if available, otherwise parse text
            let parsedDate;
            if (rawDate) {
                // Parse YYYY-MM-DD format to avoid timezone issues
                const parts = rawDate.split('-');
                parsedDate = new Date(parseInt(parts[0]), parseInt(parts[1]) - 1, parseInt(parts[2]));
            } else {
                parsedDate = new Date(dateText);
            }
            
            const today = new Date();
            today.setHours(0, 0, 0, 0);
            parsedDate.setHours(0, 0, 0, 0);

            console.log('Parsed Date:', parsedDate, 'Raw Date:', rawDate, 'Today:', today, 'Valid:', !isNaN(parsedDate
                .getTime()));

            if (isNaN(parsedDate.getTime())) {
                console.log('Date validation failed: invalid date format');
                startDateBtn.addClass('field-error');
                isValid = false;
            } else if (parsedDate < today) {
                console.log('Date validation failed: date is in the past');
                startDateBtn.addClass('field-error');
                isValid = false;
            } else {
                console.log('Date validation passed');
                startDateBtn.removeClass('field-error');
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

        const payload = {
            title: 'Peer Talk',
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
            teachers: teachers.map(function() {
                return {
                    id: $(this).data('teacher-id'),
                    name: $(this).data('teacher-name')
                };
            }).get(),
            submittedAt: new Date().toISOString()
        };

        console.log('✅ PeerTalk Payload:', payload);
    });

    // Auto clear errors
    $parent.on('click change', '.peertalk_modal_date_btn, .conference_modal_dropdown_btn', function() {
        $(this).removeClass('field-error');
    });
});
</script>

<!-- ✅ CSS for red highlights -->
<style>
.field-error {
    border: 2px solid red !important;
    box-shadow: 0 0 5px rgba(255, 0, 0, 0.5);
}

#peerTalkTabContent .dropdown-search {
    width: 90%;
    margin: 5px auto;
    display: block;
    padding: 5px 8px;
    border: 1px solid #ccc;
    border-radius: 6px;
    outline: none;
    font-size: 0.9rem;
}
</style>