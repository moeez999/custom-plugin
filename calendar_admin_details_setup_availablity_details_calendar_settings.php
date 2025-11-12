<!-- Inter font -->
<!-- <link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700;800&display=swap" rel="stylesheet">

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
 -->
<style>
body {
    background: #f7f7fb;
    font-family: "Inter", system-ui, -apple-system, "Segoe UI", Roboto, "Helvetica Neue", Arial, sans-serif;
    color: #111;
}

.calendar_admin_details_setup_availability_calendar_settings_section {
    padding: 28px 12px;
}

.calendar_admin_details_setup_availability_calendar_settings_title {
    font-weight: 600;
    font-size: clamp(22px, 2.4vw, 25px);
    margin-bottom: 20px;
    color: #111;
}

.calendar_admin_details_setup_availability_calendar_settings_card {
    background: #fff;


    padding: 18px 0;
}

.calendar_admin_details_setup_availability_calendar_settings_label {
    font-weight: 700;
    margin-bottom: 6px;
    font-size: 18px;
    color: #1b1c1f;
}

.calendar_admin_details_setup_availability_calendar_settings_tip {
    color: #6b6f7b;
    max-width: 62ch;
    line-height: 1.5;
}

.calendar_admin_details_setup_availability_calendar_settings_control {
    background: #fff;
    border: 1px solid #ececf3;
    border-radius: 18px;
    padding: 18px;
    height: 100%;
}

.calendar_admin_details_setup_availability_calendar_settings_control_title {
    margin-bottom: 10px;
    color: #111;
}

/* === Custom Select === */
.calendar_admin_details_setup_availability_calendar_settings_select {
    position: relative;
    width: 100%;
}

.calendar_admin_details_setup_availability_calendar_settings_selectbtn {
    width: 100%;
    display: flex;
    justify-content: space-between;
    align-items: center;
    border: 2px solid #ececf3;
    background: #fff;
    padding: 14px 16px;
    border-radius: 8px;
    color: #111;
    /* box-shadow:0 3px 0 rgba(0,0,0,.20); */
    cursor: pointer;
}

.calendar_admin_details_setup_availability_calendar_settings_caret {
    margin-left: 12px;
    flex: 0 0 auto;
}

.calendar_admin_details_setup_availability_calendar_settings_menu {
    position: absolute;
    top: calc(100% + 10px);
    left: 0;
    width: 100%;
    background: #fff;
    border: 1px solid #eee;
    border-radius: 14px;
    box-shadow: 0 16px 42px rgba(0, 0, 0, .18), 0 6px 18px rgba(0, 0, 0, .10);
    padding: 10px 0;
    z-index: 2005;
    display: none;
}

.calendar_admin_details_setup_availability_calendar_settings_select.open>.calendar_admin_details_setup_availability_calendar_settings_menu {
    display: block;
}

.calendar_admin_details_setup_availability_calendar_settings_item {
    padding: 16px 22px;
    color: #111;
    cursor: pointer;
}

.calendar_admin_details_setup_availability_calendar_settings_item:hover {
    background: #f5f6fb;
}

.calendar_admin_details_setup_availability_calendar_settings_savebtn {
    background: #fe2e0c;
    border: none;
    border-radius: 10px;
    padding: 12px 36px;
    font-weight: 700;
    font-size: 1.05rem;
    color: #fff;
    border: 2px solid #000;
    /* box-shadow:0 2px 0 #000 inset; */
    transition: .2s;
}

.calendar_admin_details_setup_availability_calendar_settings_savebtn:hover {
    background: #e53935;
}
</style>

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
        alert("Saved timezone: " + calendar_admin_details_setup_availability_calendar_settings_state
            .timezone);
    });
});
</script>