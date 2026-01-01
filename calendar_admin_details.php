<?php
// calendar_admin_details.php
?>

<link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600&display=swap" rel="stylesheet">

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<link rel="stylesheet" href="css/calendar_admin_details.css">
<link rel="stylesheet" href="css/calendar_admin_details_calendar_content.css">
<link rel="stylesheet" href="css/calendar_admin_details_create_cohort_tab_details.css">
<link rel="stylesheet" href="css/calendar_admin_details_create_cohort_class_tab.css">
<link rel="stylesheet" href="css/calendar_admin_details_create_cohort_merge_tab.css">
<link rel="stylesheet" href="css/calendar_admin_details_create_cohort_add_time_tab.css">
<link rel="stylesheet" href="css/calendar_admin_details_create_cohort.css">

<!-- Global Loader -->
<div id="loader"
    style="display:none; position:fixed; top:0; left:0; width:100%; height:100%; background:rgba(255,255,255,0.8); z-index:99999; align-items:center; justify-content:center;">
    <img src="./img/loader.png" alt="Loading..." class="spin-logo"
        style="width:100px;height:100px; animation:spin 2s linear infinite;">
</div>
<style>
@keyframes spin {
    from {
        transform: rotate(0deg);
    }

    to {
        transform: rotate(360deg);
    }
}
</style>

<div class="calendar_admin_main_wrapper">

    <!-- Sidebar -->
    <aside class="calendar_admin_sidebar">
        <button class="calendar_admin_btn calendar_admin_btn_active calendar_admin_details_create_cohort_open">
            Create Cohort
        </button>
        <button class="calendar_admin_btn" id="calendar_admin_details_manage_cohort">Manage Cohort</button>
        <button class="calendar_admin_btn" id="calendar_admin_details_merge">Merge Cohort</button>
        <button class="calendar_admin_btn calendar_admin_details_1_1_class">1:1 Class</button>
        <button class="calendar_admin_btn" id="calendar_admin_details_manage_class">Manage 1:1 Class</button>
        <button class="calendar_admin_btn calendar_admin_details_conference">Conference</button>
        <button class="calendar_admin_btn" id="calendar_admin_details_peer_talk">Peer talk</button>
        <button class="calendar_admin_btn" id="calendar_admin_details_add_time_off">Add time off</button>
        <button class="calendar_admin_btn" id="calendar_admin_details_add_extra_slots">Add Extra Slots</button>
        <a href="calendar_admin_details_setup_availablity.php">
            <button class="calendar_admin_btn">Setup Availability</button>
        </a>

        <div class="legends-container">
            <section id="event-types-Frequency" class="legend-section">
                <h2 class="legend-title">Event Frequency</h2>
                <ul class="legend-list event-types-list">
                    <li class="legend-item">
                        <span><img src="./img/weekly-lesson.svg" alt=""></span>
                        <span class="legend-label">Recurring Sessions</span>
                    </li>
                    <li class="legend-item">
                        <span><img src="./img/single-lesson.svg" alt=""></span>
                        <span class="legend-label">Single Sessions</span>
                    </li>
                </ul>
            </section>
            <section id="event-types" class="legend-section">
                <h2 class="legend-title">Event Types</h2>
                <ul class="legend-list event-types-list">
                    <li class="legend-item">
                        <span class="legend-dot dot-cohort-main"></span>
                        <span class="legend-label">Cohort Class Main</span>
                    </li>
                    <li class="legend-item">
                        <span><img src="./img/CohortClassTutoring.svg" alt=""></span>
                        <span class="legend-label">Cohort Class Tutoring</span>
                    </li>
                    <li class="legend-item">
                        <span class="legend-dot dot-one-on-one"></span>
                        <span class="legend-label">1:1 Class</span>
                    </li>
                    <li class="legend-item">
                        <span class="legend-dot dot-peer-talk"></span>
                        <span class="legend-label">Peer Talk</span>
                    </li>
                    <li class="legend-item">
                        <span class="legend-dot dot-conference"></span>
                        <span class="legend-label">Conference</span>
                    </li>
                    <li class="legend-item">
                        <span class="legend-dot dot-busy-time"></span>
                        <span class="legend-label">Busy time</span>
                    </li>
                    <li class="legend-item">
                        <span class="legend-dot dot-external-meeting"></span>
                        <span class="legend-label">External Meeting</span>
                    </li>
                </ul>
            </section>
            <section id="session-status" class="legend-section">
                <h2 class="legend-title">Session Status</h2>
                <ul class="legend-list session-status-list">
                    <li class="legend-item">
                        <img class="legend-icon" src="./img/confirmed.svg" alt="Confirmed icon">
                        <span class="legend-label">Taught</span>
                    </li>
                    <li class="legend-item">
                        <img class="legend-icon" src="./img/cancelled.svg" alt="Cancelled icon">
                        <span class="legend-label">Cancelled</span>
                    </li>
                    <li class="legend-item">
                        <img class="legend-icon" src="./img/rescheduled.svg" alt="Rescheduled icon">
                        <span class="legend-label">Rescheduled</span>
                    </li>
                    <li class="legend-item">
                        <img class="legend-icon" src="./img/covered.svg" alt="Covered icon">
                        <span class="legend-label">Covered</span>
                    </li>
                    <li class="legend-item">
                        <img class="legend-icon" src="./img/missed.svg" alt="Missed icon">
                        <span class="legend-label">Missed</span>
                    </li>
                    <li class="legend-item">
                        <img class="legend-icon" src="./img/pendingconfirmation.svg" alt="Pending Confirmation icon">
                        <span class="legend-label">Pending Confirmation</span>
                    </li>
                    <li class="legend-item">
                        <img class="legend-icon" src="./img/makeup.svg" alt="Makeup icon">
                        <span class="legend-label">Makeup</span>
                    </li>
                </ul>
            </section>
        </div>
    </aside>

    <!-- Calendar Main -->
    <main class="calendar_admin_calendar_outer">
        <!-- Header -->
        <div class="calendar_admin_calendar_header">

            <button class="calendar_arrow_btn" id="prev-week">
                <svg width="20" height="20" viewBox="0 0 24 24">
                    <polyline points="15 19 8 12 15 5" fill="none" stroke="#222" stroke-width="2" stroke-linecap="round"
                        stroke-linejoin="round" />
                </svg>
            </button>
            <button class="calendar_arrow_btn" id="next-week">
                <svg width="20" height="20" viewBox="0 0 24 24">
                    <polyline points="9 5 16 12 9 19" fill="none" stroke="#222" stroke-width="2" stroke-linecap="round"
                        stroke-linejoin="round" />
                </svg>
            </button>

            <span class="calendar_admin_calendar_title" id="calendar-range"></span>

            <div class="calendar_admin_header_section">

                <!-- Teacher Trigger -->
                <div class="teacher-search-dropdown" id="teacher-search-trigger">
                    <div class="teacher-search-trigger">
                        <span id="teacher-display-text">Select Teachers</span>
                        <div class="teacher-pill-container" id="teacher-pills"></div>
                        <span class="dropdown-arrow"></span>
                    </div>
                </div>

                <!-- Teacher Search Widget -->
                <section id="search-teacher" class="search-teacher-section" style="display:none">
                    <div class="search-widget-container" id="teacher-search-widget">
                        <div class="widget-header-with-controls">
                            <h1 class="widget-title">Search Teacher</h1>
                            <button type="button" id="teacher-reset" class="calendar-control-btn"><img
                                    src="./img/reset-icon.svg" alt=""> Reset</button>
                        </div>
                        <div class="search-component">
                            <div class="search-input-wrapper">
                                <input type="text" class="search-input-placeholder" id="teacher-search-input"
                                    placeholder="Search Teacher">
                            </div>

                            <div class="selected-teachers-container" id="selected-teachers-container">
                                <!-- Selected teacher pills -->
                            </div>

                            <div class="teacher-list-wrapper">
                                <form class="teacher-list-form">
                                    <fieldset>
                                        <legend class="visually-hidden">Select a teacher</legend>
                                        <!-- JS injected -->
                                    </fieldset>
                                </form>
                            </div>
                        </div>
                    </div>
                </section>

                <!-- Cohort Trigger -->
                <!-- Cohort Trigger -->
                <div class="cohort-search-dropdown" id="cohort-search-trigger">
                    <div class="cohort-search-trigger">
                        <span id="cohort-display-text">Select Cohorts</span>
                        <div class="cohort-pill-container" id="cohort-pills"></div>
                        <span class="dropdown-arrow"></span>
                    </div>
                </div>
                <input type="hidden" id="cohort-value" name="cohort" value="">

                <!-- Cohort Widget with Subtabs -->
                <section id="search-cohort" class="search-cohort-section">
                    <div class="cohort-search-widget-container" id="cohort-search-widget" style="display:none">
                        <div class="cohort-widget-header">
                            <h1 class="widget-title">Search Session</h1>
                            <div class="cohort-controls">
                                <button type="button" id="cohort-reset" class="calendar-control-btn"><img
                                        src="./img/reset-icon.svg" alt=""> Reset</button>
                                <button type="button" id="cohort-reset-all" class="calendar-control-btn"><img
                                        src="./img/reset-icon.svg" alt=""> Reset
                                    All</button>
                            </div>
                        </div>
                        <div class="search-component">
                            <div class="cohort-tabs">
                                <button type="button" class="cohort-tab-btn cohort-tab-active"
                                    data-tab="cohort">Cohort</button>
                                <button type="button" class="cohort-tab-btn" data-tab="oneonone">1:1 Class</button>
                                <button type="button" class="cohort-tab-btn" data-tab="conference">Conference</button>
                                <button type="button" class="cohort-tab-btn" data-tab="peertalk">Peer talk</button>
                            </div>

                            <div class="cohort-tab-contents">
                                <!-- Cohort (multi-select with checkboxes) -->
                                <div class="cohort-tab-content" id="cohort-tab">
                                    <div class="search-input-wrapper">
                                        <input type="text" class="search-input-placeholder" id="cohort-search-input"
                                            placeholder="Search cohorts" />
                                    </div>

                                    <div id="cohort-no-results" class="cohort-no-results"
                                        style="display:none;padding:12px 10px;color:#6a697c;font-size:13px;background:#fff;border-radius:8px;margin-top:12px;">
                                        No cohorts found
                                    </div>

                                    <div class="selected-cohorts-container" id="selected-cohorts-container"></div>

                                    <div class="cohort-list-wrapper">
                                        <form class="cohort-list-form">
                                            <fieldset id="cohort-options-fieldset">
                                                <legend class="visually-hidden">Select cohorts</legend>
                                                <!-- JS injected (checkbox inputs expected) -->
                                            </fieldset>
                                        </form>
                                    </div>
                                </div>

                                <!-- 1:1 Class (multi-select, pills) -->
                                <div class="cohort-tab-content" id="oneonone-tab" style="display:none">
                                    <div class="search-input-wrapper">
                                        <input type="text" class="search-input-placeholder" id="oneonone-search-input"
                                            placeholder="Search 1:1 classes or teachers" />
                                    </div>
                                    <div id="oneonone-no-results" class="cohort-no-results"
                                        style="display:none;padding:12px 10px;color:#6a697c;font-size:13px;background:#fff;border-radius:8px;margin-top:12px;">
                                        No items found</div>
                                    <div class="selected-items-container" id="oneonone-selected-container"></div>
                                    <div class="oneonone-list-wrapper">
                                        <form class="oneonone-list-form">
                                            <fieldset id="oneonone-options-fieldset">
                                                <legend class="visually-hidden">Select 1:1 items</legend>
                                                <!-- JS injected (checkbox inputs expected) -->
                                            </fieldset>
                                        </form>
                                    </div>
                                </div>

                                <!-- Conference (multi-select, pills) -->
                                <div class="cohort-tab-content" id="conference-tab" style="display:none">
                                    <div class="search-input-wrapper">
                                        <input type="text" class="search-input-placeholder" id="conference-search-input"
                                            placeholder="Search Conference" />
                                    </div>
                                    <div id="conference-no-results" class="cohort-no-results"
                                        style="display:none;padding:12px 10px;color:#6a697c;font-size:13px;background:#fff;border-radius:8px;margin-top:12px;">
                                        No items found</div>
                                    <div class="selected-items-container" id="conference-selected-container"></div>
                                    <div class="conference-list-wrapper">
                                        <form class="conference-list-form">
                                            <fieldset id="conference-options-fieldset">
                                                <legend class="visually-hidden">Select conference items</legend>
                                                <!-- JS injected (checkbox inputs expected) -->
                                            </fieldset>
                                        </form>
                                    </div>
                                </div>

                                <!-- PeerTalk (multi-select, pills) -->
                                <div class="cohort-tab-content" id="peertalk-tab" style="display:none">
                                    <div class="search-input-wrapper">
                                        <input type="text" class="search-input-placeholder" id="peertalk-search-input"
                                            placeholder="Search Peer talk" />
                                    </div>
                                    <div id="peertalk-no-results" class="cohort-no-results"
                                        style="display:none;padding:12px 10px;color:#6a697c;font-size:13px;background:#fff;border-radius:8px;margin-top:12px;">
                                        No items found</div>
                                    <div class="selected-items-container" id="peertalk-selected-container"></div>
                                    <div class="peertalk-list-wrapper">
                                        <form class="peertalk-list-form">
                                            <fieldset id="peertalk-options-fieldset">
                                                <legend class="visually-hidden">Select peertalk items</legend>
                                                <!-- JS injected (checkbox inputs expected) -->
                                            </fieldset>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>

                <!-- Student Trigger -->
                <div class="student-search-dropdown" id="student-search-trigger">
                    <div class="student-search-trigger">
                        <span id="student-display-text">Select Students</span>
                        <div class="student-pill-container" id="student-pills"></div>
                        <span class="dropdown-arrow"></span>
                    </div>
                </div>

                <!-- Filter Trigger (right side of student dropdown) -->
                <button type="button" id="extra-search-trigger" class="filter-btn" aria-haspopup="true"
                    aria-expanded="false" style="margin-left:12px;">
                    <span class="filter-text">Filter</span>
                    <span class="filter-icon" aria-hidden="true">
                        <!-- simple filter SVG icon -->
                        <img src="./img/filter-icon.svg" alt="">
                    </span>
                </button>

                <style>
                /* Compact filter button to match snapshot */
                .filter-btn {
                    display: inline-flex;
                    align-items: center;
                    gap: 8px;
                    padding: 12px 16px;
                    border-radius: 8px;
                    border-radius: 8px;
                    border: 2px solid #edecec;
                    background: #fff;
                    cursor: pointer;
                    font-weight: 600;
                    color: #111;
                    font-size: 13px;
                    line-height: 1;
                }

                .filter-btn:active {
                    transform: translateY(1px);
                }

                .filter-btn .filter-icon {
                    display: inline-flex;
                    align-items: center;
                    justify-content: center;
                }

                .filter-btn svg {
                    display: block;
                }
                </style>

                <!-- Student Widget -->
                <section id="search-student" class="search-student-section" style="display:none">
                    <div class="search-widget-container" id="student-search-widget">
                        <div class="widget-header-with-controls">
                            <h1 class="widget-title">Search Student</h1>
                            <button type="button" id="student-reset" class="calendar-control-btn"><img
                                    src="./img/reset-icon.svg" alt=""> Reset</button>
                        </div>
                        <div class="search-component">
                            <div class="search-input-wrapper">
                                <input type="text" class="search-input-placeholder" id="student-search-input"
                                    placeholder="Search Student">
                            </div>

                            <div class="selected-students-container" id="selected-students-container">
                                <!-- Selected student pills -->
                            </div>

                            <div class="student-list-wrapper">
                                <form class="student-list-form">
                                    <fieldset>
                                        <legend class="visually-hidden">Select a student</legend>
                                        <!-- JS injected -->
                                    </fieldset>
                                </form>
                            </div>
                        </div>
                    </div>
                </section>

                <!-- Extra Widget (right side dropdown content) - Events Filter (snapshot) -->
                <style>
                /* Events Filter popover snapshot styles */
                .events-filter-popover {
                    width: 220px;
                    background: #fff;
                    border-radius: 8px;
                    box-shadow: 0 10px 30px rgba(0, 0, 0, 0.12);
                    border: 1px solid #ececf3;
                    padding: 10px 12px;
                    font-family: Inter, system-ui, -apple-system, "Segoe UI", Roboto, "Helvetica Neue", Arial;
                    font-size: 14px;
                    color: #232323;
                }

                .events-filter-popover .ef-header {
                    display: flex;
                    align-items: center;
                    justify-content: space-between;
                    padding: 6px 2px 8px 2px;
                }

                .events-filter-popover .ef-title {
                    font-weight: 700;
                    font-size: 15px;
                    color: #111
                }

                .events-filter-popover .ef-reset {
                    color: #ef2d17;
                    font-weight: 700;
                    cursor: pointer;
                    font-size: 13px
                }

                .events-filter-popover .ef-list {
                    display: flex;
                    flex-direction: column;
                    gap: 8px;
                    padding-top: 6px
                }

                .ef-item {
                    display: flex;
                    align-items: center;
                    gap: 10px
                }

                .ef-label {
                    flex: 1
                }

                /* custom checkbox box */
                .ef-box {
                    width: 24px;
                    height: 24px;
                    border-radius: 6px;
                    border: 1.6px solid #e1e3eb;
                    display: inline-grid;
                    place-items: center;
                    cursor: pointer;
                    background: #fff;
                    color: #fff;
                    font-weight: 800
                }

                input.ef-input {
                    display: none
                }

                input.ef-input:checked+.ef-box {
                    background: #ef2d17;
                    border-color: #ef2d17
                }

                input.ef-input:checked+.ef-box::after {
                    content: '✔';
                    font-size: 13px
                }

                .ef-selectall {
                    display: flex;
                    align-items: center;
                    gap: 10px
                }
                </style>

                <section id="search-extra" class="search-extra-section" style="display:none">
                    <div class="events-filter-popover" id="extra-search-widget">
                        <div class="ef-header">
                            <div class="ef-title">Events Filter</div>
                            <div class="ef-reset" id="ef-reset">Reset</div>
                        </div>

                        <div class="ef-list">
                            <label class="ef-item ef-selectall">
                                <input class="ef-input" type="checkbox" id="ef_select_all" data-value="select-all">
                                <span class="ef-box" aria-hidden="true"></span>
                                <span class="ef-label">Select All</span>
                            </label>

                            <label class="ef-item">
                                <input class="ef-input" type="checkbox" data-value="cohorts" id="ef_cohorts">
                                <span class="ef-box" aria-hidden="true"></span>
                                <span class="ef-label">Cohorts</span>
                            </label>

                            <label class="ef-item">
                                <input class="ef-input" type="checkbox" data-value="one1" id="ef_one1">
                                <span class="ef-box" aria-hidden="true"></span>
                                <span class="ef-label">1:1</span>
                            </label>

                            <label class="ef-item">
                                <input class="ef-input" type="checkbox" data-value="peertalk" id="ef_peertalk">
                                <span class="ef-box" aria-hidden="true"></span>
                                <span class="ef-label">Peer Talk</span>
                            </label>

                            <label class="ef-item">
                                <input class="ef-input" type="checkbox" data-value="conference" id="ef_conference">
                                <span class="ef-box" aria-hidden="true"></span>
                                <span class="ef-label">Conference</span>
                            </label>

                            <label class="ef-item">
                                <input class="ef-input" type="checkbox" data-value="timeoff" id="ef_timeoff">
                                <span class="ef-box" aria-hidden="true"></span>
                                <span class="ef-label">Time off</span>
                            </label>

                            <label class="ef-item">
                                <input class="ef-input" type="checkbox" data-value="extraslots" id="ef_extraslots">
                                <span class="ef-box" aria-hidden="true"></span>
                                <span class="ef-label">Extra Slots</span>
                            </label>

                            <label class="ef-item">
                                <input class="ef-input" type="checkbox" data-value="availability" id="ef_availability">
                                <span class="ef-box" aria-hidden="true"></span>
                                <span class="ef-label">Availability</span>
                            </label>
                        </div>
                    </div>
                </section>

                <?php require_once('calendar_admin_details_tabs.php'); ?>
            </div>
        </div>


        <div class="wrap" id="calendar_admin_calendar_flexrow">
            <div class="cal">
                <div id="head" class="cal-head">
                    <div class="gutter">
                        <div class="filter-toggle-container">
                            <label class="filter-toggle-label">
                                <input type="checkbox" id="filterToggle" class="filter-toggle-checkbox">
                                <span class="filter-toggle-switch"></span>

                            </label>
                        </div>
                    </div>
                </div>
                <div id="grid" class="grid calender-hide-scrollbar">
                    <div id="gutter" class="gutter"></div>
                </div>
            </div>
        </div>

        <?php require_once('calendar_admin_details_agenda_tab.php'); ?>
    </main>
</div>
<script>
$(function() {
    // Tab switching between Semana (Calendar) and Agenda
    $('#calendar_admin_semana_btn').on('click', function() {
        console.log('Semana tab clicked');

        // Update tab active states
        $('#calendar_admin_semana_btn').addClass('active');
        $('#calendar_admin_agenda_btn').removeClass('active');

        // Show calendar, hide agenda
        $('#calendar_admin_calendar_flexrow').show();
        $('#calendar_admin_agenda_content').hide();

        // Re-render calendar view
        if (typeof renderWeek === 'function') {
            renderWeek(false);
        }
    });

    $('#calendar_admin_agenda_btn').on('click', function() {
        console.log('Agenda tab clicked');

        // Update tab active states
        $('#calendar_admin_agenda_btn').addClass('active');
        $('#calendar_admin_semana_btn').removeClass('active');

        // Hide calendar, show agenda
        $('#calendar_admin_calendar_flexrow').hide();
        $('#calendar_admin_agenda_content').show();

        // Render agenda view with current events
        setTimeout(function() {
            console.log('Triggering agenda render from tab click');
            if (typeof renderAgendaView === 'function') {
                renderAgendaView();
            } else {
                console.error('renderAgendaView function not found');
            }
        }, 100);

        // Dispatch event for other listeners
        $(document).trigger('agendaTabActivated');
    });

    // Initial state - ensure correct tab is shown on page load
    if ($('#calendar_admin_agenda_btn').hasClass('active')) {
        $('#calendar_admin_calendar_flexrow').hide();
        $('#calendar_admin_agenda_content').show();
        setTimeout(function() {
            if (typeof renderAgendaView === 'function') {
                renderAgendaView();
            }
        }, 300);
    } else {
        $('#calendar_admin_calendar_flexrow').show();
        $('#calendar_admin_agenda_content').hide();
    }
});
</script>

<script>
$(function() {
    // Tab switching for cohort widget
    function showCohortTab(name) {
        $('.cohort-tab-content').hide();
        $('#' + name + '-tab').show();
        $('.cohort-tab-btn').removeClass('cohort-tab-active');
        $('.cohort-tab-btn[data-tab="' + name + '"]').addClass('cohort-tab-active');

        var map = {
            'cohort': '#cohort-options-fieldset',
            'oneonone': '#oneonone-options-fieldset',
            'conference': '#conference-options-fieldset',
            'peertalk': '#peertalk-options-fieldset'
        };
        var selector = map[name];
        if (selector) {
            var $fs = $(selector);
            var hasInputs = $fs.find('input').length > 0;
            $('#' + name + '-no-results').toggle(!hasInputs);
        }
    }

    showCohortTab('cohort');

    $('.cohort-tabs').on('click', '.cohort-tab-btn', function(e) {
        e.preventDefault();
        var t = $(this).data('tab');
        if (!t) {
            t = $(this).text().toLowerCase().replace(/[^a-z0-9]+/g, '');
        }
        showCohortTab(t);
    });

    // Utility to update hidden input and display text
    function updateCohortValue(obj) {
        try {
            $('#cohort-value').val(JSON.stringify(obj));
        } catch (e) {
            $('#cohort-value').val('');
        }

        if (!obj || !obj.ids || obj.ids.length === 0) {
            $('#cohort-display-text').text('Select Cohorts');
            return;
        }

        const count = obj.ids.length;
        $('#cohort-display-text').text(count + ' cohort' + (count > 1 ? 's' : '') + ' selected');
    }

    // Handle cohort checkbox selection (multi-select)
    $(document).on('change', '#cohort-options-fieldset input[type=checkbox]', function() {
        var selected = [];
        $('#cohort-options-fieldset input[type=checkbox]:checked').each(function() {
            selected.push($(this).val());
        });

        var $container = $('#selected-cohorts-container');
        $container.empty();

        if (selected.length > 0) {
            $container.show();
            selected.forEach(function(sid) {
                var iid = $('#cohort-options-fieldset input[value="' + sid + '"]').attr('id');
                var label = $('label[for="' + iid + '"]').text() || sid;
                var $pill = $('<span class="selected-pill" data-id="' + sid +
                    '" data-type="cohort">' + label +
                    ' <button type="button" class="remove-pill">×</button></span>');
                $container.append($pill);
            });
        } else {
            $container.hide();
        }

        updateCohortValue({
            type: 'cohort',
            ids: selected
        });
    });

    // Click remove on pill -> uncheck corresponding checkbox
    $(document).on('click', '#selected-cohorts-container .remove-pill', function(e) {
        var pid = $(this).parent().data('id');
        var $cb = $('#cohort-options-fieldset input[value="' + pid + '"]');
        if ($cb.length) {
            $cb.prop('checked', false).trigger('change');
        }
    });

    // Handle multi-select for other tabs (oneonone, conference, peertalk)
    var multiTypes = ['oneonone', 'conference', 'peertalk'];
    multiTypes.forEach(function(type) {
        $(document).on('change', '#' + type + '-options-fieldset input[type=checkbox]', function() {
            var selected = [];
            $('#' + type + '-options-fieldset input[type=checkbox]:checked').each(function() {
                selected.push($(this).val());
            });

            var $container = $('#' + type + '-selected-container');
            $container.empty();
            selected.forEach(function(sid) {
                var iid = $('#' + type + '-options-fieldset input[value="' + sid + '"]')
                    .attr('id');
                var label = $('label[for="' + iid + '"]').text() || sid;
                var $pill = $('<span class="selected-pill" data-id="' + sid +
                    '" data-type="' + type + '">' + label +
                    ' <button type="button" class="remove-pill">×</button></span>');
                $container.append($pill);
            });

            updateCohortValue({
                type: type,
                ids: selected
            });
        });

        $(document).on('click', '#' + type + '-selected-container .remove-pill', function(e) {
            var pid = $(this).parent().data('id');
            var $cb = $('#' + type + '-options-fieldset input[value="' + pid + '"]');
            if ($cb.length) {
                $cb.prop('checked', false).trigger('change');
            }
        });
    });
});
</script>

<script src="js/calendar_admin_details.js"></script>
<script src="js/calendar_admin_details_calendar_content.js"></script>
<script>
// Remove initials and ellipsis from teacher and student pill containers after rendering
function cleanUpPillContainers() {
    // Remove initials and ellipsis spans for teachers
    $('#teacher-pills .teacher-summary-initials').remove();
    // Remove initials and ellipsis spans for students
    $('#student-pills .student-summary-initials, #student-pills .student-summary-ellipsis').remove();
}

// Run cleanup after DOM ready and after any event that updates pills
$(function() {
    cleanUpPillContainers();
    // If you have custom events that update pills, hook here:
    $(document).on('teacherPillsUpdated studentPillsUpdated', cleanUpPillContainers);
});
</script>
<script>
// Position and behaviour for the Events Filter popover
$(function() {
    let filterPopoverVisible = false; // Track popover visibility state

    $('#extra-search-trigger').on('click', function(e) {
        e.stopPropagation();

        const $btn = $(this);
        const $popover = $('#search-extra .events-filter-popover');

        // Toggle visibility
        filterPopoverVisible = !filterPopoverVisible;

        if (filterPopoverVisible) {
            // Append to body and position absolutely under the button
            const off = $btn.offset();
            const top = off.top + $btn.outerHeight() + 8;
            const left = $btn.offset().left; // align left edge of popover with button

            $popover.appendTo('body').css({
                position: 'absolute',
                top: top + 'px',
                left: left + 'px',
                zIndex: 9999,
                display: 'block'
            });
        } else {
            // Move back to original location and hide
            $popover.appendTo('#search-extra').css('display', 'none');
        }
    });

    // Close when clicking outside
    $(document).on('click', function(e) {
        const $target = $(e.target);

        // Check if click is outside popover AND button
        if (!$target.closest('.events-filter-popover').length && !$target.closest(
                '#extra-search-trigger').length) {
            // Close popover
            if (filterPopoverVisible) {
                const $popover = $('.events-filter-popover'); // Find it anywhere in DOM
                $popover.hide();
                $popover.appendTo('#search-extra'); // Move back to original location
                filterPopoverVisible = false;
            }
        }
    });

    // Prevent clicks inside popover from closing it
    $(document).on('click', '.events-filter-popover', function(e) {
        e.stopPropagation();
    });

    // Events Filter behaviours
    // Reset link
    $(document).on('click', '#ef-reset', function(e) {
        e.stopPropagation();
        $('.events-filter-popover').find('input.ef-input').prop('checked', false);
        $('#ef_select_all').prop('checked', false);
        $('#extra-search-trigger .filter-text').text('Filter');
        applyEventTypeFilter();
    });

    // Select All behaviour
    $(document).on('change', '#ef_select_all', function() {
        const checked = $(this).is(':checked');
        $('.events-filter-popover').find('input.ef-input').not(this).prop('checked', checked);
        $('.events-filter-popover input.ef-input').trigger('change');
    });

    // If any individual checkbox is unchecked, update Select All and label
    $(document).on('change', '.events-filter-popover input.ef-input', function() {
        const all = $('.events-filter-popover input.ef-input').not('#ef_select_all');
        const checkedCount = all.filter(':checked').length;
        const total = all.length;
        $('#ef_select_all').prop('checked', checkedCount === total);

        // Update display text to show how many selected (if any)
        if (checkedCount === 0) {
            $('#extra-search-trigger .filter-text').text('Filter');
        } else if (checkedCount === total) {
            $('#extra-search-trigger .filter-text').text(total + ' selected');
        } else {
            $('#extra-search-trigger .filter-text').text(checkedCount + ' selected');
        }

        // Apply event type filter to rendered events
        applyEventTypeFilter();
    });

    // Function to filter rendered events by type
    function applyEventTypeFilter() {
        const checkedFilters = [];
        $('.events-filter-popover input.ef-input').not('#ef_select_all').each(function() {
            if ($(this).is(':checked')) {
                checkedFilters.push($(this).data('value'));
            }
        });

        // Check how many teachers are selected
        const selectedTeachers = window.calendarFilterState ? window.calendarFilterState.getSelectedTeachers() :
            [];
        const isSingleTeacher = selectedTeachers.length === 1;

        // If no filters selected, show all events and white slots
        if (checkedFilters.length === 0) {
            $('.event').show();
            // Show white slots only if single teacher is selected
            if (isSingleTeacher) {
                $('.slot-white').show();
            }
            return;
        }

        // Handle white slot visibility (for single teacher: availability and extra slots render as white slots)
        if (isSingleTeacher) {
            console.log('Filtering white slots, checked filters:', checkedFilters);

            // Check if availability or extraslots filters are in the checked filters
            const hasAvailabilityFilter = checkedFilters.includes('availability');
            const hasExtraslotsFilter = checkedFilters.includes('extraslots');

            // If neither availability nor extraslots are checked, hide all white slots
            if (!hasAvailabilityFilter && !hasExtraslotsFilter) {
                $('.slot-white').hide();
            } else {
                // Filter white slots independently based on their source
                $('.slot-white').each(function() {
                    const $slot = $(this);
                    const source = $slot.data('source') || '';

                    let shouldShow = false;
                    if (source === 'availability' && hasAvailabilityFilter) {
                        shouldShow = true;
                    }
                    if (source === 'extra_slot' && hasExtraslotsFilter) {
                        shouldShow = true;
                    }

                    if (shouldShow) {
                        $slot.show();
                    } else {
                        $slot.hide();
                    }
                });
            }
            console.log('White slots filtered. Visible count:', $('.slot-white:visible').length);
        }

        // Filter events based on their type
        $('.event').each(function() {
            const $event = $(this);
            const classType = $event.data('class-type') || '';
            const source = $event.data('source') || '';

            let shouldShow = false;

            // Check each filter
            if (checkedFilters.includes('cohorts')) {
                // Show cohort main classes (not one2one, not peertalk, not conference, not timeoff, not availability, not extra_slot)
                if (!classType || (
                        classType !== 'one2one_weekly' &&
                        classType !== 'one2one_single' &&
                        classType !== 'peertalk' &&
                        classType !== 'conference' &&
                        classType !== 'teacher_timeoff' &&
                        classType !== 'availability' &&
                        classType !== 'extra_slot' &&
                        source !== 'peertalk' &&
                        source !== 'conference' &&
                        source !== 'teacher_timeoff' &&
                        source !== 'availability' &&
                        source !== 'extra_slot'
                    )) {
                    shouldShow = true;
                }
            }

            if (checkedFilters.includes('one1')) {
                if (classType === 'one2one_weekly' || classType === 'one2one_single') {
                    shouldShow = true;
                }
            }

            if (checkedFilters.includes('peertalk')) {
                if (classType === 'peertalk' || source === 'peertalk') {
                    shouldShow = true;
                }
            }

            if (checkedFilters.includes('conference')) {
                if (classType === 'conference' || source === 'conference') {
                    shouldShow = true;
                }
            }

            if (checkedFilters.includes('timeoff')) {
                if (classType === 'teacher_timeoff' || source === 'teacher_timeoff') {
                    shouldShow = true;
                }
            }

            if (checkedFilters.includes('extraslots')) {
                // Multiple teachers: extra slots render as events, so show them
                if (!isSingleTeacher && (classType === 'extra_slot' || source === 'extra_slot')) {
                    shouldShow = true;
                }
                // Single teacher: extra slots render as white slots, not events, so don't show event elements
            }

            if (checkedFilters.includes('availability')) {
                // Multiple teachers: availability renders as events, so show them
                if (!isSingleTeacher && (classType === 'availability' || source === 'availability')) {
                    shouldShow = true;
                }
                // Single teacher: availability renders as white slots, not events, so don't show event elements
            }

            // Show or hide the event
            if (shouldShow) {
                $event.show();
            } else {
                $event.hide();
            }
        });
    }

    // Apply filter on reset
    $(document).on('click', '#ef-reset', function() {
        applyEventTypeFilter();
    });

    // Initialize with all filters selected by default
    $('#ef_select_all').prop('checked', true).trigger('change');
});
</script>
<?php require_once('calendar_admin_details_create_cohort.php'); ?>
<script src="js/calendar_admin_details_create_cohort_tab_details.js"></script>
<script src="js/calendar_admin_details_create_cohort_class_tab.js"></script>
<script src="js/calendar_admin_details_create_cohort_merge_tab.js"></script>
<script src="js/calendar_admin_details_create_cohort_add_time_tab.js"></script>
<script src="js/calendar_admin_details_create_cohort.js"></script>
<?php require_once('calendar_admin_details_time_off.php'); ?>
<?php require_once('calendar_admin_details_lesson_information.php'); ?>
<?php require_once('calendar_admin_details_reschedule_modals.php'); ?>