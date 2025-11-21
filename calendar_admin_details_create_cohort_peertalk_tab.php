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
                <button type="button" class="peertalk_modal_date_btn">Select Date</button>
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

                $(document).ready(function() {
                    const $parent = $('#peerTalkTabContent');
                    const $form = $parent.find('#peerTalkForm');

                    // Scope scroll-widget selection to Peer Talk tab only
                    $parent.on('click', '.scroll-widget__button', function(e) {
                        // Only handle clicks inside Peer Talk tab
                        const $widget = $(this).closest('.scroll-widget');
                        if ($widget.length && $parent.find($widget).length) {
                            // Custom logic for Peer Talk scroll-widget
                            // ...existing code for time selection...
                        }
                    });

                    // ✅ Extract and validate repeat buttons
                    function extractSchedules() {
                        const scheduleArray = [];
                        $parent.find('.peertalk_repeat_btn').each(function() {
                            const $this = $(this);
                            const text = $this.text().trim();

                            // Match time first: "09:00 AM - 10:00 AM"
                            const timeMatch = text.match(
                                /(\d{1,2}:\d{2}\s?[APMapm]{2})\s*-\s*(\d{1,2}:\d{2}\s?[APMapm]{2})/
                                );

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

                    // ...existing code for dropdowns, validation, etc. (unchanged)...
                });
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