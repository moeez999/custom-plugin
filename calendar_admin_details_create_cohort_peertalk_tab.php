<!-- ✅ Peer Talk Tab -->
<div id="peerTalkTabContent" style="display:none;">
    <form id="peerTalkForm">
        <div class="conference_modal_schedule">
            <img src="./img/conference-schedule.svg" alt=""> Peer Talk Schedule
        </div>

        <!-- Repeat + Date -->
        <div class="conference_modal_repeat_row">
            <div style="width:100%;">
                <div class="conference_modal_repeat_btn" style="border-bottom:2.5px solid #fe2e0c;">

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
                    <span id="eventTimezoneDropdown_peertalk_selected">(GMT-05:00) Eastern</span>
                    <img class="calendar_admin_details_cohort_tab_timezone_arrow" src="./img/dropdown-arrow-down.svg"
                        alt="">
                    <div class="calendar_admin_details_cohort_tab_timezone_list"
                        id="eventTimezoneDropdown_peertalk_list">
                        <ul>
                            <li>(GMT-05:00) Eastern</li>
                            <li>(GMT+01:00) Berlin, Paris</li>
                            <li>(GMT+05:30) India</li>
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
                        <span class="color-circle" style="background:#1736e6"></span>
                        <span style="float:right; font-size:1rem;">
                            <img class="calendar_admin_details_cohort_tab_timezone_arrow"
                                src="./img/dropdown-arrow-down.svg" alt="">
                        </span>
                    </button>
                    <div class="color-dropdown-list" id="colorDropdownList_peertalk">
                        <div class="color-dropdown-color" data-color="#1736e6" style="background:#1736e6"></div>
                        <div class="color-dropdown-color" data-color="#22b07e" style="background:#22b07e"></div>
                        <div class="color-dropdown-color" data-color="#ff2f1b" style="background:#ff2f1b"></div>
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
        $parent.find('.conference_modal_repeat_btn').each(function() {
            const $this = $(this);
            const text = $this.text().trim();

            // Match "Weekly on Mon (09:00 AM - 10:00 AM)"
            const dayMatch = text.match(/on\s+([A-Za-z]{3})/);
            const timeMatch = text.match(
                /(\d{1,2}:\d{2}\s?[APMapm]{2})\s*-\s*(\d{1,2}:\d{2}\s?[APMapm]{2})/);

            if (dayMatch && timeMatch) {
                scheduleArray.push({
                    day: dayMatch[1],
                    startTime: timeMatch[1],
                    endTime: timeMatch[2]
                });
                $this.removeClass('field-error');
            } else {
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

        const payload = {
            repeat: $parent.find('.conference_modal_repeat_btn').text().trim(),
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

        console.log('✅ Peer Talk payload:', payload);
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