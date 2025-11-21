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
                    <span id="eventTimezoneDropdown_conference_tab_selected">(GMT-05:00) Eastern Time (US & Canada)</span>
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

        <div class="conference_modal_fieldrow">
            <div>
                <span class="conference_modal_label">Attending Cohorts</span>
                <div class="conference_modal_dropdown_btn" id="conferenceCohortsDropdown">
                    XX#
                    <span style="float:right; font-size:1rem;"><img src="./img/dropdown-arrow-down.svg" alt=""></span>
                </div>
                <div class="conference_modal_dropdown_list" id="conferenceCohortsDropdownList">
                    <input type="text" id="searchCohorts" class="dropdown-search" placeholder="Search cohorts...">
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
                <div class="conference_modal_dropdown_btn" id="conferenceTeachersDropdown">
                    Select Teacher
                    <span style="float:right; font-size:1rem;"><img src="./img/dropdown-arrow-down.svg" alt=""></span>
                </div>
                <div class="conference_modal_dropdown_list" id="conferenceTeachersDropdownList">
                    <input type="text" id="searchTeachers" class="dropdown-search" placeholder="Search teachers...">
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

        <button type="submit" class="conference_modal_btn">Schedule Conference</button>
    </form>
</div>

<!-- ✅ JS -->
<script>
$(document).ready(function() {
    const $parent = $('#conferenceTabContent');
    const $form = $parent.find('#conferenceForm');
    const $tzWrapper = $parent.find('#eventTimezoneDropdown_conference_tab_wrapper');
    const $tzList = $parent.find('#eventTimezoneDropdown_conference_tab_list');
    const $tzSelected = $parent.find('#eventTimezoneDropdown_conference_tab_selected');
    const $colorToggle = $parent.find('#colorDropdownToggle');
    const $colorList = $parent.find('#colorDropdownList');

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
        console.log("🗓️ Schedule Array:", scheduleArray);
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
    $parent.find('#conferenceCohortsDropdown').click(function(e) {
        e.stopPropagation();
        $parent.find('#conferenceCohortsDropdownList').toggle();
        $parent.find(
                '#conferenceTeachersDropdownList, #colorDropdownList, #eventTimezoneDropdown_conference_tab_list'
            )
            .hide();
    });
    $parent.find('#conferenceCohortsDropdownList li').click(function() {
        const cohort = $(this).text().trim();
        const $dropdown = $parent.find('#conferenceCohortsDropdown');
        const firstNode = $dropdown.contents().first()[0];
        if (firstNode) {
            firstNode.textContent = cohort + " ";
        }
        $parent.find('#conferenceCohortsDropdownList').hide();
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
    $parent.find('#conferenceTeachersDropdownList li').click(function() {
        const name = $(this).text().trim();
        const imgHtml = $(this).find('img').prop('outerHTML');
        $parent.find('#conferenceTeachersDropdown').html($(this).html() +
            '<span style="float:right; font-size:1rem;"><img src="./img/dropdown-arrow-down.svg" alt=""></span>'
        );
        $parent.find('#conferenceTeachersDropdownList').hide();
        if ($parent.find('.conference_modal_attendees_list li:contains("' + name + '")').length === 0) {
            $parent.find('.conference_modal_attendees_list').append(`
                <li class="conference_modal_attendee">
                    <span>${imgHtml} ${name}</span>
                    <span class="conference_modal_remove"><img src="./img/delete.svg" alt=""></span>
                </li>
            `);
        }
        $parent.find('#conferenceTeachersDropdown').removeClass('field-error');
    });

    // Remove items - scoped to parent
    $parent.on('click', '.conference_modal_remove', function() {
        $(this).closest('li').fadeOut(200, function() {
            $(this).remove();
        });
    });

    // Search filters
    $parent.find('#searchCohorts, #searchTeachers').on('keyup', function() {
        const filter = $(this).val().toLowerCase();
        $(this).siblings('ul').find('li').each(function() {
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
    $form.on('submit', function(e) {
        e.preventDefault();
        $parent.find('.field-error').removeClass('field-error');
        let isValid = true;

        const title = $parent.find('.addtime-title-input').val().trim();
        const startDateBtn = $parent.find('.conference_modal_date_btn');
        const startDate = startDateBtn.text().trim();
        const timezone = $tzSelected.text().trim();
        const color = $colorToggle.find('.color-circle').css('background-color');
        const cohorts = $parent.find('.conference_modal_cohort_list li');
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
        if (cohorts.length === 0) {
            $parent.find('#conferenceCohortsDropdown').addClass('field-error');
            isValid = false;
        }
        if (teachers.length === 0) {
            $parent.find('#conferenceTeachersDropdown').addClass('field-error');
            isValid = false;
        }

        if (!isValid) {
            return;
        }

        const payload = {
            title,
            startDate,
            timezone,
            color,
            scheduleArray,
            cohorts: cohorts.map(function() {
                return $(this).data('cohort');
            }).get(),
            teachers: teachers.map(function() {
                return $(this).text().trim();
            }).get(),
            submittedAt: new Date().toISOString()
        };

        console.log('✅ Conference Payload:', payload);
    });

    // Auto clear errors - scoped to parent
    $parent.on('click change',
        '.addtime-title-input, .conference_modal_date_btn, .conference_modal_dropdown_btn',
        function() {
            $(this).removeClass('field-error');
        });
});
</script>

<!-- CSS for red highlights -->
<style>
.field-error {
    border: 2px solid red !important;
    box-shadow: 0 0 5px rgba(255, 0, 0, 0.5);
}

#conferenceTabContent .dropdown-search {
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