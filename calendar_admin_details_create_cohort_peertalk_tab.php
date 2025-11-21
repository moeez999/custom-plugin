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
                <button type="button" class="conference_modal_date_btn">Select Date</button>
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
            <div>
                <span class="conference_modal_label">Attending Cohorts</span>
                <div class="conference_modal_dropdown_btn" id="peertalkCohortsDropdown">
                    XX#
                    <span style="float:right; font-size:1rem;">
                        <img src="./img/dropdown-arrow-down.svg" alt="">
                    </span>
                </div>
                <div class="conference_modal_dropdown_list" id="peertalkCohortsDropdownList">
                    <input type="text" id="searchCohorts_peertalk" class="dropdown-search"
                        placeholder="Search cohorts...">
                    <ul>
                        <li>FL1</li>
                        <li>TX1</li>
                        <li>NY2</li>
                        <li>OHI2</li>
                    </ul>
                </div>
            </div>

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
                    <ul>
                        <li><img src="https://randomuser.me/api/portraits/men/11.jpg"
                                class="calendar_admin_details_create_cohort_teacher_avatar"> Edwards</li>
                        <li><img src="https://randomuser.me/api/portraits/women/44.jpg"
                                class="calendar_admin_details_create_cohort_teacher_avatar"> Daniela</li>
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

    // ✅ Extract and validate repeat buttons
    function extractSchedules() {
        const scheduleArray = [];
        $parent.find('.peertalk_repeat_btn').each(function() {
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
            // Match patterns like:
            // "Weekly on Mon (09:00 AM - 10:00 AM)"
            // "Weekly on Mon, Wed, Fri (09:00 AM - 10:00 AM)"
            // "on Mon, Wed, Fri (09:00 AM - 10:00 AM)"
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

        console.log('🗓️ Schedule Array:', scheduleArray);
        return scheduleArray;
    }

    // Timezone Dropdown
    const $tzWrapper = $parent.find('#eventTimezoneDropdown_peertalk_wrapper');
    const $tzList = $parent.find('#eventTimezoneDropdown_peertalk_list');
    const $tzSelected = $parent.find('#eventTimezoneDropdown_peertalk_selected');

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
    const $colorToggle = $parent.find('#colorDropdownToggle_peertalk');
    const $colorList = $parent.find('#colorDropdownList_peertalk');
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
    $parent.find('#peertalkCohortsDropdownList li').click(function() {
        const cohort = $(this).text().trim();
        $parent.find('#peertalkCohortsDropdown').contents().first()[0].textContent = cohort + " ";
        $parent.find('#peertalkCohortsDropdownList').hide();
        if ($parent.find('.conference_modal_cohort_list li[data-cohort="' + cohort + '"]').length ===
            0) {
            $parent.find('.conference_modal_cohort_list').append(`
                <li data-cohort="${cohort}">
                    <span class="conference_modal_attendee_name">
                        <span class="conference_modal_cohort_chip">${cohort}</span> ${cohort}
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
    $parent.find('#peertalkTeachersDropdownList li').click(function() {
        const name = $(this).text().trim();
        const imgHtml = $(this).find('img').prop('outerHTML');
        $parent.find('#peertalkTeachersDropdown').html($(this).html() +
            '<span style="float:right; font-size:1rem;"><img src="./img/dropdown-arrow-down.svg" alt=""></span>'
        );
        $parent.find('#peertalkTeachersDropdownList').hide();
        if ($parent.find('.conference_modal_attendees_list li:contains("' + name + '")').length === 0) {
            $parent.find('.conference_modal_attendees_list').append(`
                <li class="conference_modal_attendee">
                    <span>${imgHtml} ${name}</span>
                    <span class="conference_modal_remove"><img src="./img/delete.svg" alt=""></span>
                </li>
            `);
        }
        $parent.find('#peertalkTeachersDropdown').removeClass('field-error');
    });

    // Remove items - scoped to parent
    $parent.on('click', '.conference_modal_remove', function() {
        $(this).closest('li').fadeOut(200, function() {
            $(this).remove();
        });
    });

    // Search filters
    $parent.find('#searchCohorts_peertalk, #searchTeachers_peertalk').on('keyup', function() {
        const filter = $(this).val().toLowerCase();
        $(this).siblings('ul').find('li').each(function() {
            $(this).toggle($(this).text().toLowerCase().includes(filter));
        });
    });

    // Outside click closes - only affects this parent's dropdowns
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

        const startDateBtn = $parent.find('.conference_modal_date_btn');
        const startDate = startDateBtn.text().trim();
        const timezone = $tzSelected.text().trim();
        const cohorts = $parent.find('.conference_modal_cohort_list li');
        const teachers = $parent.find('.conference_modal_attendees_list li');
        const color = $colorToggle.find('.color-circle').css('background-color');

        // ✅ Extract schedules
        const scheduleArray = extractSchedules();

        // Validate
        if (scheduleArray.length === 0) isValid = false;
        if (!startDate || startDate === 'Select Date') {
            startDateBtn.addClass('field-error');
            isValid = false;
        }
        if (!timezone || !timezone.includes('GMT')) {
            $tzWrapper.addClass('field-error');
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
        if (!color) {
            $colorToggle.addClass('field-error');
            isValid = false;
        }

        if (!isValid) {
            return;
        }

        // ✅ Build timestamps from startDate and first schedule
        const firstSchedule = scheduleArray[0];
        let startTs = null;
        let endTs = null;

        if (startDate && startDate !== 'Select Date' && firstSchedule) {
            // Parse date (assuming format like "Nov 21, 2025")
            const dateObj = new Date(startDate);

            // Parse start time (e.g., "09:00 AM")
            const startTimeParts = firstSchedule.startTime.match(/(\d{1,2}):(\d{2})\s?(AM|PM)/i);
            if (startTimeParts) {
                let hours = parseInt(startTimeParts[1], 10);
                const minutes = parseInt(startTimeParts[2], 10);
                const meridiem = startTimeParts[3].toUpperCase();

                if (meridiem === 'PM' && hours !== 12) hours += 12;
                if (meridiem === 'AM' && hours === 12) hours = 0;

                dateObj.setHours(hours, minutes, 0, 0);
                startTs = Math.floor(dateObj.getTime() / 1000);
            }

            // Parse end time (e.g., "10:00 AM")
            const endTimeParts = firstSchedule.endTime.match(/(\d{1,2}):(\d{2})\s?(AM|PM)/i);
            if (endTimeParts) {
                let hours = parseInt(endTimeParts[1], 10);
                const minutes = parseInt(endTimeParts[2], 10);
                const meridiem = endTimeParts[3].toUpperCase();

                if (meridiem === 'PM' && hours !== 12) hours += 12;
                if (meridiem === 'AM' && hours === 12) hours = 0;

                const endDateObj = new Date(startDate);
                endDateObj.setHours(hours, minutes, 0, 0);
                endTs = Math.floor(endDateObj.getTime() / 1000);
            }
        }

        // Convert timestamps to ISO strings
        const startISO = startTs ? new Date(startTs * 1000).toISOString() : new Date().toISOString();
        const finishISO = endTs ? new Date(endTs * 1000).toISOString() : new Date().toISOString();

        // ✅ Parse repeat information
        const repeatText = $parent.find('.peertalk_repeat_btn').text().trim();
        let repeatActive = false;
        let repeatType = 'day';
        let repeatEvery = 1;
        let weekDays = [];
        let repeatEnd = 'never';
        let repeatOn = null;

        if (repeatText.toLowerCase().includes('weekly')) {
            repeatActive = true;
            repeatType = 'week';
            repeatEvery = 1;

            // Extract day from "Weekly on Mon"
            const dayMatch = repeatText.match(/on\s+([A-Za-z]{3})/i);
            if (dayMatch) {
                const dayMap = {
                    'mon': 1,
                    'tue': 2,
                    'wed': 3,
                    'thu': 4,
                    'fri': 5,
                    'sat': 6,
                    'sun': 0
                };
                const dayKey = dayMatch[1].toLowerCase();
                if (dayMap.hasOwnProperty(dayKey)) {
                    weekDays = [dayMap[dayKey]];
                }
            }
        } else if (!repeatText.toLowerCase().includes('does not repeat')) {
            repeatActive = true;
            repeatType = 'day';
            repeatEvery = 1;
        }

        // ✅ Build cohorts array (convert cohort names to IDs if needed)
        const cohortsArray = cohorts.map(function() {
            const cohortName = $(this).data('cohort');
            // TODO: Map cohort name to cohort ID from your data source
            // For now, returning cohort name - you may need to fetch the actual ID
            return cohortName;
        }).get();

        // ✅ Build teachers array with iduser and fullname
        const teachersArray = teachers.map(function() {
            const teacherText = $(this).text().trim();
            const teacherImg = $(this).find('img');
            // TODO: Extract actual teacher ID from data attribute
            // For now, using placeholder structure
            return {
                iduser: 0, // TODO: Get actual teacher ID from data-teacher-id or similar
                fullname: teacherText
            };
        }).get();

        // ✅ Build confData object
        const confData = {
            title: 'Peer Talk', // TODO: Add title field to form if needed
            description: '',
            startTimeEvent: startISO,
            finishTimeEvent: finishISO,
            color: $colorToggle.find('.color-circle').css('background-color') || '#007bff',
            typecall: 'videocalling',
            maxstudents: 0,
            cohorts: cohortsArray,
            teachers: teachersArray,
            repeat: {
                active: repeatActive,
                type: repeatType,
                repeatEvery: repeatEvery,
                weekDays: weekDays,
                end: repeatEnd,
                repeatOn: repeatOn
            }
        };

        // ✅ Final payload matching the required structure
        const payload = {
            id: null,
            idcurrentprofile: 0,
            data: confData
        };

        console.log('✅ Peer Talk payload:', payload);
        console.log('📅 Start timestamp:', startTs, '→', startISO);
        console.log('📅 End timestamp:', endTs, '→', finishISO);
        console.log('🔁 Repeat config:', confData.repeat);

        // ✅ Send to API
        savePeerTalkToAPI(payload);
    });

    // ✅ Function to save Peer Talk via API
    async function savePeerTalkToAPI(payload) {
        try {
            showGlobalLoader();

            const response = await fetch(M.cfg.wwwroot + '/local/videocalling/api/saveclass.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-Requested-With': 'XMLHttpRequest'
                },
                credentials: 'same-origin',
                body: JSON.stringify(payload)
            });

            if (!response.ok) {
                const errorText = await response.text();
                throw new Error('videocalling API error: ' + errorText);
            }

            const result = await response.json();
            console.log('✅ Peer Talk created successfully:', result);

            hideGlobalLoader();

            // Close modal and reload calendar
            $('#calendar_admin_details_create_cohort_modal_backdrop').fadeOut();
            if (typeof window.fetchCalendarEvents === 'function') {
                window.fetchCalendarEvents();
            }

            // Reset form
            $form[0].reset();
            $parent.find('.conference_modal_cohort_list, .conference_modal_attendees_list').empty();

        } catch (error) {
            console.error('❌ Failed to create Peer Talk:', error);
            hideGlobalLoader();
            alert('Failed to create Peer Talk: ' + error.message);
        }
    }

    // ✅ Loader helpers (if not already defined globally)
    function showGlobalLoader() {
        if (typeof window.showGlobalLoader === 'function') {
            window.showGlobalLoader();
        } else if (window.$) {
            window.$('#loader').css('display', 'flex');
        }
    }

    function hideGlobalLoader() {
        if (typeof window.hideGlobalLoader === 'function') {
            window.hideGlobalLoader();
        } else if (window.$) {
            window.$('#loader').css('display', 'none');
        }
    }
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