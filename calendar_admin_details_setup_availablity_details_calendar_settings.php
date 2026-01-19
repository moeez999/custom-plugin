<!-- Inter font -->
<!-- <link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700;800&display=swap" rel="stylesheet">

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
 -->
<link rel="stylesheet" href="<?php echo $CFG->wwwroot; ?>/local/customplugin/css/calendar_admin_details_setup_availablity_details_calendar_settings.css">

<div class="calendar_admin_details_setup_availability_calendar_settings_section">
    <h1 class="calendar_admin_details_setup_availability_calendar_settings_title">Calendar settings</h1>

    <div class="row g-3 align-items-stretch">
        <div class="col-12 col-lg-7">
            <div class="calendar_admin_details_setup_availability_calendar_settings_card h-100">
                <div class="calendar_admin_details_setup_availability_calendar_settings_label">
                    Time zone and calendar view
                </div>
                <div class="calendar_admin_details_setup_availability_calendar_settings_tip">
                    Choose your current time zone to avoid time zone confusion with your students. Customize calendar
                    view the way it suits you.
                </div>
            </div>
        </div>

        <div class="col-12 col-lg-5">
            <div class="calendar_admin_details_setup_availability_calendar_settings_control">
                <div class="calendar_admin_details_setup_availability_calendar_settings_control_title">Current time zone
                </div>

                <div class="calendar_admin_details_setup_availability_calendar_settings_select"
                    id="calendar_admin_details_setup_availability_calendar_settings_timezone_select">
                    <button type="button" class="calendar_admin_details_setup_availability_calendar_settings_selectbtn">
                        <span class="calendar_admin_details_setup_availability_calendar_settings_value">America/Caracas
                            GMT -4:00</span>
                        <svg class="calendar_admin_details_setup_availability_calendar_settings_caret" width="18"
                            height="18" viewBox="0 0 20 20">
                            <path d="M6 8l4 4 4-4" stroke="#111" stroke-width="2" fill="none" stroke-linecap="round"
                                stroke-linejoin="round" />
                        </svg>
                    </button>
                    <div class="calendar_admin_details_setup_availability_calendar_settings_menu">
                        <div class="calendar_admin_details_setup_availability_calendar_settings_item" data-value="EST">
                            EST (Eastern Standard Time) – UTC -5</div>
                        <div class="calendar_admin_details_setup_availability_calendar_settings_item" data-value="PST">
                            PST (Pacific Standard Time) – UTC -8</div>
                        <div class="calendar_admin_details_setup_availability_calendar_settings_item" data-value="CST">
                            CST (Central Standard Time) – UTC -6</div>
                        <div class="calendar_admin_details_setup_availability_calendar_settings_item" data-value="IST">
                            IST (Indian Standard Time) – UTC +5:30</div>
                        <div class="calendar_admin_details_setup_availability_calendar_settings_item" data-value="GMT">
                            GMT (Greenwich Mean Time) – UTC 0</div>
                    </div>
                </div>

            </div>
        </div>
    </div>

    <!-- Save -->
    <div class="row mt-4">
        <div class="col-12">
            <button class="calendar_admin_details_setup_availability_calendar_settings_savebtn">Save</button>
        </div>
    </div>
</div>

<script>
const calendar_admin_details_setup_availability_calendar_settings_state = {
    timezone: "America/Caracas GMT -4:00"
};

function calendar_admin_details_setup_availability_calendar_settings_closeAll() {
    $('.calendar_admin_details_setup_availability_calendar_settings_select')
        .removeClass('open')
        .find('.calendar_admin_details_setup_availability_calendar_settings_selectbtn')
        .attr('aria-expanded', 'false');
}

function calendar_admin_details_setup_availability_calendar_settings_bindSelect($root) {
    $root.on('click', '.calendar_admin_details_setup_availability_calendar_settings_selectbtn', function(e) {
        e.stopPropagation();
        if ($root.hasClass('open')) {
            calendar_admin_details_setup_availability_calendar_settings_closeAll();
        } else {
            calendar_admin_details_setup_availability_calendar_settings_closeAll();
            $root.addClass('open');
        }
    });

    $root.on('click', '.calendar_admin_details_setup_availability_calendar_settings_item', function(e) {
        e.stopPropagation();
        const text = $(this).text().trim();
        calendar_admin_details_setup_availability_calendar_settings_state.timezone = text;
        $root.find('.calendar_admin_details_setup_availability_calendar_settings_value').text(text);
        calendar_admin_details_setup_availability_calendar_settings_closeAll();
    });
}

$(function() {
    const $tz = $('#calendar_admin_details_setup_availability_calendar_settings_timezone_select');
    calendar_admin_details_setup_availability_calendar_settings_bindSelect($tz);

    $(document).on('click', function() {
        calendar_admin_details_setup_availability_calendar_settings_closeAll();
    });
    $(document).on('keydown', function(e) {
        if (e.key === "Escape") calendar_admin_details_setup_availability_calendar_settings_closeAll();
    });

    $('.calendar_admin_details_setup_availability_calendar_settings_savebtn').on('click', function() {
        // Get teacher info from main page
        const $userBtn = window.parent ? $(window.parent.document).find('#calendar_admin_details_setup_availablity_userbtn') : $('#calendar_admin_details_setup_availablity_userbtn');
        const teacherPayload = {
            name: $userBtn.data('teacher-name') || $userBtn.find('#calendar_admin_details_setup_availablity_username').text(),
            img: $userBtn.data('teacher-img') || $userBtn.find('#calendar_admin_details_setup_availablity_avatar').attr('src'),
            id: $userBtn.data('teacher-id') || null
        };
        console.log('Calendar settings save payload:', {
            teacher: teacherPayload,
            settings: calendar_admin_details_setup_availability_calendar_settings_state
        });
    });
});
</script>