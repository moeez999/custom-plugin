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
                        <span class="legend-label">Confirmed</span>
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
                        <span class="dropdown-arrow"><img src="./img/dropdown-arrow-down.svg" alt=""></span>
                    </div>
                </div>

                <!-- Teacher Search Widget -->
                <section id="search-teacher" class="search-teacher-section" style="display:none">
                    <div class="search-widget-container" id="teacher-search-widget">
                        <h1 class="widget-title">Search Teacher</h1>
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
                <div class="cohort-search-dropdown" id="cohort-search-trigger">
                    <div class="cohort-search-trigger">
                        <span id="cohort-display-text">Select Cohort</span>
                        <span class="dropdown-arrow"><img src="./img/dropdown-arrow-down.svg" alt=""></span>
                    </div>
                </div>
                <input type="hidden" id="cohort-value" name="cohort" value="">

                <!-- Cohort Widget -->
                <section id="search-cohort" class="search-cohort-section">
                    <div class="cohort-search-widget-container" id="cohort-search-widget" style="display:none">
                        <h1 class="widget-title">Select Cohort</h1>
                        <div class="search-component">
                            <div class="search-input-wrapper">
                                <input type="text" class="search-input-placeholder" id="cohort-search-input"
                                    placeholder="Search Cohort" />
                            </div>

                            <div id="cohort-no-results"
                                style="display:none;padding:8px 2px;color:#6a697c;font-size:12px;">
                                No cohorts found
                            </div>

                            <div class="cohort-list-wrapper">
                                <form class="cohort-list-form">
                                    <fieldset id="cohort-options-fieldset">
                                        <legend class="visually-hidden">Select a cohort</legend>
                                        <!-- JS injected -->
                                    </fieldset>
                                </form>
                            </div>
                        </div>
                    </div>
                </section>

                <!-- Student Trigger -->
                <div class="student-search-dropdown" id="student-search-trigger">
                    <div class="student-search-trigger">
                        <span id="student-display-text">Select Students</span>
                        <div class="student-pill-container" id="student-pills"></div>
                        <span class="dropdown-arrow"><img src="./img/dropdown-arrow-down.svg" alt=""></span>
                    </div>
                </div>

                <!-- Student Widget -->
                <section id="search-student" class="search-student-section" style="display:none">
                    <div class="search-widget-container" id="student-search-widget">
                        <h1 class="widget-title">Search Student</h1>
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

                <?php require_once('calendar_admin_details_tabs.php'); ?>
            </div>
        </div>

        <!-- Calendar Content -->
        <style>
        #grid .day .day-inner .slots>div.slot-white {
            background: #fff !important;
        }
        </style>

        <div class="wrap" id="calendar_admin_calendar_flexrow">
            <div class="cal">
                <div id="head" class="cal-head">
                    <div class="gutter"></div>
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
    $('#calendar_admin_semana_btn').on('click', function() {
        $('#calendar_admin_semana_btn').addClass('active');
        $('#calendar_admin_agenda_btn').removeClass('active');
        $('#calendar_admin_calendar_flexrow').show();
        $('#calendar_admin_agenda_content').hide();
    });

    $('#calendar_admin_agenda_btn').on('click', function() {
        $('#calendar_admin_agenda_btn').addClass('active');
        $('#calendar_admin_semana_btn').removeClass('active');
        $('#calendar_admin_calendar_flexrow').hide();
        $('#calendar_admin_agenda_content').show();
    });
});
</script>

<script src="js/calendar_admin_details.js"></script>
<script src="js/calendar_admin_details_calendar_content.js"></script>
<?php require_once('calendar_admin_details_create_cohort.php'); ?>
<script src="js/calendar_admin_details_create_cohort_tab_details.js"></script>
<script src="js/calendar_admin_details_create_cohort_class_tab.js"></script>
<script src="js/calendar_admin_details_create_cohort_merge_tab.js"></script>
<script src="js/calendar_admin_details_create_cohort_add_time_tab.js"></script>
<script src="js/calendar_admin_details_create_cohort.js"></script>
<?php require_once('calendar_admin_details_time_off.php'); ?>
<?php require_once('calendar_admin_details_lesson_information.php'); ?>