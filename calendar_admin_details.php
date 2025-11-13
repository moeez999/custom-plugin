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
                        <span id="cohort-display-text">Select Session</span>
                        <span class="dropdown-arrow"><img src="./img/dropdown-arrow-down.svg" alt=""></span>
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
                                <!-- Cohort (single-select radios) -->
                                <div class="cohort-tab-content" id="cohort-tab">
                                    <div class="search-input-wrapper">
                                        <input type="text" class="search-input-placeholder" id="cohort-search-input"
                                            placeholder="Entre cohort name" />
                                    </div>

                                    <div id="cohort-no-results" class="cohort-no-results"
                                        style="display:none;padding:12px 10px;color:#6a697c;font-size:13px;background:#fff;border-radius:8px;margin-top:12px;">
                                        No cohorts found
                                    </div>

                                    <div class="cohort-list-wrapper">
                                        <form class="cohort-list-form">
                                            <fieldset id="cohort-options-fieldset">
                                                <legend class="visually-hidden">Select a cohort</legend>
                                                <!-- JS injected (radio inputs expected) -->
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

<script>
$(function() {
    // Tab switching for cohort widget
    function showCohortTab(name) {
        $('.cohort-tab-content').hide();
        $('#' + name + '-tab').show();
        $('.cohort-tab-btn').removeClass('cohort-tab-active');
        $('.cohort-tab-btn[data-tab="' + name + '"]').addClass('cohort-tab-active');
        // show per-tab no-results if no inputs injected
        // cohort -> check #cohort-options-fieldset
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

    // initialize
    showCohortTab('cohort');

    // click handler for tabs (delegate to container for robustness)
    $('.cohort-tabs').on('click', '.cohort-tab-btn', function(e) {
        e.preventDefault();
        var t = $(this).data('tab');
        if (!t) {
            // fallback: try to read from text
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

        if (!obj) {
            $('#cohort-display-text').text('Select Cohort');
            return;
        }

        if (obj.type === 'cohort') {
            var id = obj.id || '';
            if (!id) {
                $('#cohort-display-text').text('Select Cohort');
            } else {
                // try to find label text for selected radio
                var $input = $('#cohort-options-fieldset input[value="' + id + '"]');
                var text = id;
                if ($input.length) {
                    var rid = $input.attr('id');
                    var lab = $('label[for="' + rid + '"]').text();
                    if (lab) {
                        text = lab;
                    }
                }
                $('#cohort-display-text').text(text);
            }
        } else {
            var count = (obj.ids || []).length;
            $('#cohort-display-text').text(count ? (count + ' selected') : 'Select Cohort');
        }
    }

    // handle cohort radio selection (single-select)
    $(document).on('change', '#cohort-options-fieldset input[type=radio]', function() {
        var val = $(this).val();
        updateCohortValue({
            type: 'cohort',
            id: val
        });
    });

    // handle multi-select (checkbox) behavior for oneonone / conference / peertalk
    var multiTypes = ['oneonone', 'conference', 'peertalk'];
    multiTypes.forEach(function(type) {
        // checkbox change -> rebuild pills and update hidden value
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

        // click remove on pill -> uncheck corresponding checkbox
        $(document).on('click', '#' + type + '-selected-container .remove-pill', function(e) {
            var pid = $(this).parent().data('id');
            var $cb = $('#' + type + '-options-fieldset input[value="' + pid + '"]');
            if ($cb.length) {
                $cb.prop('checked', false).trigger('change');
            } else {
                // if input not present, just remove pill
                $(this).parent().remove();
                // rebuild value
                var remaining = [];
                $('#' + type + '-options-fieldset input[type=checkbox]:checked').each(
                    function() {
                        remaining.push($(this).val());
                    });
                updateCohortValue({
                    type: type,
                    ids: remaining
                });
            }
        });
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