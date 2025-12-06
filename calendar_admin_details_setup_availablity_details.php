<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Availability Setup</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

    <style>
    /* Your existing CSS remains the same */
    :root {
        --cal-setup-timecol: 76px;
        --cal-setup-hour: 80px;
        --cal-setup-half: 40px;
        --cal-setup-night-start-hour: 1;
        --cal-setup-night-end-hour: 5;
        --cal-setup-block-gutter: 2px;
        --cal-setup-pagebg: #f3f4f8;
        --cal-setup-bg: #f6f7fb;
        --cal-setup-card: #fff;
        --cal-setup-border: #e7e8f1;
        --cal-setup-grid: #e8e8f2;
        --cal-setup-grid-strong: #3a3a45;
        --cal-setup-text: #141414;
        --cal-setup-muted: #6f7380;
        --cal-setup-row-alt: #fbfbfe;
        --cal-setup-night-bg: #eff1f6;
        --cal-setup-accent: #0f56d8;
        --cal-setup-accent-ink: #fff;
        --cal-setup-slot-peak: #ffb2a8;
        --cal-setup-slot-late: #b7c0ea;
        --cal-setup-slot-pill: 26px;
    }

    body {
        color: var(--cal-setup-text);
        font-weight: 400;
        background: var(--cal-setup-pagebg);
    }

    .calendar_admin_details_setup_availablity_wrap {
        max-width: 100%;
        margin: 0;
    }

    .calendar_admin_details_setup_availablity_title {
        letter-spacing: -.2px;
        font-size: clamp(22px, 2.2vw, 25px);
        margin: 6px 0 18px;
    }

    /* Compact pill look */
    .calendar_admin_details_setup_availablity_block.is-compact {
        height: var(--cal-setup-slot-pill) !important;
        box-sizing: border-box;
        padding: 4px 10px;
        margin: 0 0;
        top: calc(var(--_slotTop) + (var(--cal-setup-half) - var(--cal-setup-slot-pill)) / 2) !important;
    }

    .calendar_admin_details_setup_availablity_block.is-compact .calendar_admin_details_setup_availablity_timelabel {
        font-size: 12px;
        font-weight: 700;
        line-height: 1;
    }

    /* ===== Layout ===== */
    .calendar_admin_details_setup_availablity_layout {
        display: grid;
        grid-template-columns: 330px 1fr;
        gap: 20px;
    }

    @media (max-width: 992px) {
        .calendar_admin_details_setup_availablity_layout {
            grid-template-columns: 1fr;
        }
    }

    /* ===== Sidebar ===== */
    .calendar_admin_details_setup_availablity_sidebar {
        background: var(--cal-setup-bg);
        border: 1px solid var(--cal-setup-border);
        border-radius: 8px;
        padding: 16px;
        position: sticky;
        top: 12px;
    }

    .calendar_admin_details_setup_availablity_userbtn {
        width: 100%;
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 10px;
        background: #fff;
        border: 1px solid var(--cal-setup-border);
        border-radius: 8.55px;
        padding: 12px 14px;
        cursor: pointer;
        box-shadow: 0 8px 20px rgba(10, 10, 20, .06);
        color: var(--cal-setup-text);
    }

    .calendar_admin_details_setup_availablity_userbtn_left {
        display: flex;
        align-items: center;
        gap: 10px;
    }

    .calendar_admin_details_setup_availablity_avatar {
        width: 38px;
        height: 38px;
        border-radius: 10px;
        object-fit: cover;
    }

    .calendar_admin_details_setup_availablity_username {
        font-weight: 600;
    }

    .calendar_admin_details_setup_availablity_chev {
        transition: transform .15s ease;
    }

    .calendar_admin_details_setup_availablity_userbtn.open .calendar_admin_details_setup_availablity_chev {
        transform: rotate(180deg);
    }

    .calendar_admin_details_setup_availablity_menu {
        position: absolute;
        max-width: 92vw;
        max-height: 420px;
        overflow: auto;
        background: #fff;
        z-index: 5000;
        display: none;
        max-width: 453px;
        width: 100%;
        border: 1.07px solid #f4f4f8;
        border-radius: 8.5px;
        box-shadow: 0px 8.5px 34.2px 0px rgba(18, 17, 23, 0.15), 0px 17.1px 51.3px 0px rgba(18, 17, 23, 0.15);
        padding: 12px;
        flex-direction: column;
        gap: 10px;
    }

    .calendar_admin_details_setup_availablity_menu::-webkit-scrollbar {
        width: 4px;
        background: transparent;
    }

    .calendar_admin_details_setup_availablity_menu_item {
        display: flex;
        align-items: center;
        gap: 12px;
        padding: 10px 16px;
        cursor: pointer;
    }

    .calendar_admin_details_setup_availablity_menu_item:hover {
        background: #f7f8ff;
    }

    .calendar_admin_details_setup_availablity_menu_avatar {
        width: 36px;
        height: 36px;
        border-radius: 10px;
        object-fit: cover;
    }

    .calendar_admin_details_setup_availablity_menu_name {
        font-weight: 600;
    }

    .calendar_admin_details_setup_availablity_sidebtn {
        width: 100%;
        text-align: left;
        font-weight: 600;
        background: transparent;
        color: #111;
        border: 1px solid var(--cal-setup-border);
        padding: 14px 16px;
        border-radius: 8.55px;
        margin-top: 12px;
    }

    .calendar_admin_details_setup_availablity_sidebtn.active {
        border: 2px solid #111;
        padding: 13px 15px;
    }

    .calendar_admin_details_setup_availablity_viewbox {
        border-radius: 16px;
        padding: 14px;
        margin-top: 14px;
    }

    .calendar_admin_details_setup_availablity_viewtitle {
        font-weight: 700;
        margin-bottom: 10px;
    }

    /* ===== Calendar ===== */
    .calendar_admin_details_setup_availablity_calendar {
        background: #fff;
        border: 1px solid var(--cal-setup-border);
        overflow: hidden;
    }

    .calendar_admin_details_setup_availablity_head {
        display: grid;
        grid-template-columns: var(--cal-setup-timecol) repeat(7, 1fr);
        align-items: center;
        border-bottom: 1px solid var(--cal-setup-grid);
        background: #fff;
    }

    .calendar_admin_details_setup_availablity_timehead {
        color: transparent;
        border-right: 1px solid var(--cal-setup-grid);
        padding: 14px 6px;
    }

    .calendar_admin_details_setup_availablity_daycell {
        text-align: center;
        padding: 14px 6px;
        font-weight: 600;
        border-right: 1px solid var(--cal-setup-grid);
    }

    .calendar_admin_details_setup_availablity_body {
        position: relative;
        height: calc(100vh - 260px);
        min-height: 560px;
        overflow: auto;
        background: #fff;
    }

    .calendar_admin_details_setup_availablity_body::-webkit-scrollbar {
        width: 0px;
        background: transparent;
    }

    .calendar_admin_details_setup_availablity_grid {
        position: relative;
        min-width: 980px;
        display: grid;
        grid-template-columns: var(--cal-setup-timecol) repeat(7, 1fr);
    }

    /* Time column */
    .calendar_admin_details_setup_availablity_timecol {
        border-right: 1px solid var(--cal-setup-grid);
        background: #fff;
        position: relative;
        z-index: 6;
    }

    .calendar_admin_details_setup_availablity_hourlabel {
        height: var(--cal-setup-hour);
        border-bottom: 1px solid var(--cal-setup-grid);
        color: var(--cal-setup-muted);
        font-size: .95rem;
        display: flex;
        align-items: center;
        justify-content: flex-end;
        padding: 0 8px 0 0;
        background: #fff;
    }

    /* Day columns with 30-min boxes */
    .calendar_admin_details_setup_availablity_day {
        position: relative;
        border-right: 1px solid var(--cal-setup-grid);
    }

    .calendar_admin_details_setup_availablity_halfbox {
        height: var(--cal-setup-half);
        border-bottom: 1px solid var(--cal-setup-grid);
        background: #fff;
    }

    /* Zebra rows – skip the night band */
    .calendar_admin_details_setup_availablity_day .calendar_admin_details_setup_availablity_halfbox:nth-child(odd):not(.calendar_admin_details_setup_availablity_nightbg) {
        background: var(--cal-setup-row-alt);
    }

    /* Middle gray band cells */
    .calendar_admin_details_setup_availablity_halfbox.calendar_admin_details_setup_availablity_nightbg {
        background: var(--cal-setup-night-bg) !important;
    }

    /* Heat overlay */
    .calendar_admin_details_setup_availablity_heat {
        position: absolute;
        top: 0;
        bottom: 0;
        left: var(--cal-setup-timecol);
        right: 0;
        pointer-events: none;
        display: grid;
        grid-template-columns: repeat(7, 1fr);
        z-index: 2;
    }

    .calendar_admin_details_setup_availablity_heat>div {
        position: relative;
    }

    .calendar_admin_details_setup_availablity_midday {
        position: absolute;
        left: 0;
        right: 0;
        background: linear-gradient(to bottom, var(--cal-setup-slot-peak), transparent 75%);
        opacity: .65;
    }

    .calendar_admin_details_setup_availablity_evening {
        position: absolute;
        left: 0;
        right: 0;
        background: linear-gradient(to bottom, transparent, var(--cal-setup-slot-late) 80%);
        opacity: .70;
    }

    /* "Night time" divider + chip at END (05:00) */
    .calendar_admin_details_setup_availablity_nightline {
        position: absolute;
        left: var(--cal-setup-timecol);
        right: 0;
        top: calc(var(--cal-setup-hour) * var(--cal-setup-night-end-hour));
        border-top: 2px solid var(--cal-setup-grid-strong);
        z-index: 3;
    }

    .calendar_admin_details_setup_availablity_nightchip {
        position: absolute;
        left: 50%;
        transform: translateX(-50%);
        top: calc(var(--cal-setup-hour) * var(--cal-setup-night-end-hour) - 16px);
        background: #2e2f3a;
        color: #fff;
        font-size: 12px;
        padding: 6px 10px;
        border-radius: 8px;
        z-index: 4;
        box-shadow: 0 4px 10px rgba(0, 0, 0, .18);
    }

    /* Blocks */
    .calendar_admin_details_setup_availablity_blocklayer {
        position: absolute;
        inset: 0;
        z-index: 5;
        pointer-events: none;
    }

    .calendar_admin_details_setup_availablity_block {
        position: absolute;
        left: 0;
        right: 0;
        margin: 0 var(--cal-setup-block-gutter);
        background: var(--cal-setup-accent);
        color: var(--cal-setup-accent-ink);
        box-shadow: 0 2px 4px rgba(10, 80, 200, .2);
        font-weight: 600;
        font-size: 12px;
        line-height: 1;
        box-sizing: border-box;
        pointer-events: auto;
        user-select: none;
        padding: 2px 4px;
    }

    .calendar_admin_details_setup_availablity_resize {
        position: absolute;
        bottom: -11px;
        left: 50%;
        transform: translateX(-50%);
        width: 22px;
        height: 22px;
        border-radius: 50%;
        background: #fff;
        color: #111;
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: 700;
        font-size: 12px;
        box-shadow: 0 2px 6px rgba(0, 0, 0, .18);
        cursor: ns-resize;
    }

    /* Mobile */
    @media (max-width: 576px) {
        :root {
            --cal-setup-timecol: 58px;
        }

        .calendar_admin_details_setup_availablity_grid {
            min-width: 760px;
        }

        .calendar_admin_details_setup_availablity_hourlabel {
            height: 56px;
        }
    }

    /* ===== Delete bubble + selected state + time label ===== */
    .calendar_admin_details_setup_availablity_deletebtn {
        position: absolute;
        top: -6px;
        left: 50%;
        transform: translateX(-50%);
        background: #fff;
        color: #0f0f0f;
        border: 1px solid #d8d9e5;
        border-radius: 10px;
        padding: 6px 10px;
        font-size: 13px;
        font-weight: 600;
        display: flex;
        align-items: center;
        gap: 6px;
        box-shadow: 0 6px 18px rgba(0, 0, 0, .16);
        cursor: pointer;
        white-space: nowrap;
        z-index: 10;
    }

    .calendar_admin_details_setup_availablity_deletebtn svg {
        width: 14px;
        height: 14px;
    }

    .calendar_admin_details_setup_availablity_block.calendar_admin_details_setup_availablity_selected {
        outline: 2px solid rgba(15, 86, 216, .15);
    }

    .calendar_admin_details_setup_availablity_block.calendar_admin_details_setup_availablity_selected::before {
        content: "";
        position: absolute;
        left: 0;
        right: 0;
        top: 0;
        height: 18px;
        background: rgba(0, 0, 0, .14);
        border-radius: 18px 18px 0 0;
    }

    .calendar_admin_details_setup_availablity_block .calendar_admin_details_setup_availablity_timelabel {
        display: block;
        font-weight: 700;
        line-height: 1;
        pointer-events: none;
    }

    /* Back header above the user dropdown (anchor version) */
    .calendar_admin_details_setup_availablity_back {
        display: flex;
        align-items: center;
        gap: 10px;
        background: transparent;
        border: none;
        padding: 6px 0 12px;
        font-size: 18px;
        color: #111;
        cursor: pointer;
        width: 100%;
        text-align: left;
        text-decoration: none;
    }

    .calendar_admin_details_setup_availablity_back:hover {
        color: #0f56d8;
        text-decoration: none;
    }

    .calendar_admin_details_setup_availablity_back:focus {
        outline: 2px solid #0f56d8;
        outline-offset: 2px;
    }

    .calendar_admin_details_setup_availablity_back svg {
        width: 20px;
        height: 20px;
        flex: 0 0 20px;
    }

    .custom-checkbox {
        appearance: none;
        -webkit-appearance: none;
        -moz-appearance: none;
        width: 18px;
        height: 18px;
        border: 2px solid #000;
        border-radius: 4px;
        background-color: transparent;
        position: relative;
        cursor: pointer;
        transition: all 0.2s ease-in-out;
    }

    .custom-checkbox:checked {
        background-color: #000;
        border-color: #000;
    }

    .custom-checkbox:checked::after {
        content: '';
        position: absolute;
        left: 5px;
        top: 2px;
        width: 4px;
        height: 8px;
        border: solid #fff;
        border-width: 0 2px 2px 0;
        transform: rotate(45deg);
    }

    #teacherSearch {
        font-size: 14px;
        border-radius: 8px;
    }

    @keyframes spin {
        from {
            transform: rotate(0deg);
        }

        to {
            transform: rotate(360deg);
        }
    }

    .spin-logo {
        animation: spin 2s linear infinite;
    }
    </style>
</head>

<body>
    <!-- Loader -->
    <div id="loader"
        style="display:none; position:fixed; top:0; left:0; width:100%; height:100%; background:rgba(255,255,255,0.6); z-index:9999; align-items:center; justify-content:center;">
        <img src="../../img/loader.png" alt="Loading..." class="spin-logo" style="width:100px;height:100px;">
    </div>

    <!-- Toast Notification -->
    <div id="toastNotificationForAvailability" style="display:none; position:fixed; top:30px; right:30px; 
         background:#000; color:#fff; padding:16px 24px; 
         border-radius:8px; font-size:1rem; 
         box-shadow:0 4px 12px rgba(0,0,0,0.3);
         z-index:99999; opacity:0; transition:opacity .3s, transform .3s;
         transform:translateY(20px);">
        Availability updated successfully!
    </div>

    <div class="calendar_admin_details_setup_availablity_wrap">
        <div class="calendar_admin_details_setup_availablity_layout">
            <!-- ===== Sidebar ===== -->
            <aside class="calendar_admin_details_setup_availablity_sidebar">
                <a href="calendar_admin.php" class="calendar_admin_details_setup_availablity_back"
                    aria-label="Back to Calendar">
                    <img src="./img/arrow-back.svg" alt="">
                    <span class="fw-semibold">Calendar</span>
                </a>

                <button type="button" id="calendar_admin_details_setup_availablity_userbtn"
                    class="calendar_admin_details_setup_availablity_userbtn" aria-expanded="false">
                    <span class="calendar_admin_details_setup_availablity_userbtn_left">
                        <img id="calendar_admin_details_setup_availablity_avatar"
                            class="calendar_admin_details_setup_availablity_avatar"
                            src="https://randomuser.me/api/portraits/women/65.jpg" alt="">
                        <span id="calendar_admin_details_setup_availablity_username"
                            class="calendar_admin_details_setup_availablity_username">Daniela</span>
                    </span>
                    <img src="./img/dropdown-arrow-down.svg" alt="">
                </button>

                <button type="button" id="btnAvailability"
                    class="calendar_admin_details_setup_availablity_sidebtn active">Availability</button>
                <button type="button" id="btnLessonBooking"
                    class="calendar_admin_details_setup_availablity_sidebtn">Lesson booking</button>
                <button type="button" id="btnCalendarSettings"
                    class="calendar_admin_details_setup_availablity_sidebtn">Calendar settings</button>
                <button type="button" id="btnGoogleCalendar"
                    class="calendar_admin_details_setup_availablity_sidebtn">Google Calendar</button>

                <div class="calendar_admin_details_setup_availablity_viewbox">
                    <div class="calendar_admin_details_setup_availablity_viewtitle">View options</div>
                    <label class="form-check align-items-center gap-2">
                        <input class="form-check-input custom-checkbox" type="checkbox" checked
                            id="calendar_admin_details_setup_availablity_popular_toggle">
                        <span>Popular slots</span>
                        <img src="./img/info.svg" alt="">
                    </label>
                </div>
            </aside>

            <!-- ===== Right side contents (switcher) ===== -->
            <div>
                <!-- AVAILABILITY TAB -->
                <div id="contentAvailability" class="calendar-content" style="display:block;">
                    <h1 class="calendar_admin_details_setup_availablity_title">Select time slots when you're available
                        for booking</h1>
                    <section class="calendar_admin_details_setup_availablity_calendar">
                        <div class="calendar_admin_details_setup_availablity_head">
                            <div class="calendar_admin_details_setup_availablity_timehead">&nbsp;</div>
                            <div class="calendar_admin_details_setup_availablity_daycell">Mon</div>
                            <div class="calendar_admin_details_setup_availablity_daycell">Tue</div>
                            <div class="calendar_admin_details_setup_availablity_daycell">Wed</div>
                            <div class="calendar_admin_details_setup_availablity_daycell">Thu</div>
                            <div class="calendar_admin_details_setup_availablity_daycell">Fri</div>
                            <div class="calendar_admin_details_setup_availablity_daycell">Sat</div>
                            <div class="calendar_admin_details_setup_availablity_daycell">Sun</div>
                        </div>

                        <div class="calendar_admin_details_setup_availablity_body">
                            <div class="calendar_admin_details_setup_availablity_grid">
                                <div class="calendar_admin_details_setup_availablity_timecol"
                                    id="calendar_admin_details_setup_availablity_timecol"></div>

                                <div class="calendar_admin_details_setup_availablity_day" data-day="0"></div>
                                <div class="calendar_admin_details_setup_availablity_day" data-day="1"></div>
                                <div class="calendar_admin_details_setup_availablity_day" data-day="2"></div>
                                <div class="calendar_admin_details_setup_availablity_day" data-day="3"></div>
                                <div class="calendar_admin_details_setup_availablity_day" data-day="4"></div>
                                <div class="calendar_admin_details_setup_availablity_day" data-day="5"></div>
                                <div class="calendar_admin_details_setup_availablity_day" data-day="6"></div>

                                <div class="calendar_admin_details_setup_availablity_nightline"></div>
                                <div class="calendar_admin_details_setup_availablity_nightchip">Night time</div>

                                <div class="calendar_admin_details_setup_availablity_heat"
                                    id="calendar_admin_details_setup_availablity_heat">
                                    <!-- Heat overlay content remains the same -->
                                    <div>
                                        <div class="calendar_admin_details_setup_availablity_midday"
                                            style="top:calc(var(--cal-setup-hour) * 8); height:calc(var(--cal-setup-hour)*7);">
                                        </div>
                                    </div>
                                    <div>
                                        <div class="calendar_admin_details_setup_availablity_midday"
                                            style="top:calc(var(--cal-setup-hour) * 8); height:calc(var(--cal-setup-hour)*7);">
                                        </div>
                                    </div>
                                    <div>
                                        <div class="calendar_admin_details_setup_availablity_midday"
                                            style="top:calc(var(--cal-setup-hour) * 8); height:calc(var(--cal-setup-hour)*7);">
                                        </div>
                                    </div>
                                    <div>
                                        <div class="calendar_admin_details_setup_availablity_midday"
                                            style="top:calc(var(--cal-setup-hour) * 8); height:calc(var(--cal-setup-hour)*6);">
                                        </div>
                                        <div class="calendar_admin_details_setup_availablity_evening"
                                            style="top:calc(var(--cal-setup-hour) * 14); height:calc(var(--cal-setup-hour)*7);">
                                        </div>
                                    </div>
                                    <div>
                                        <div class="calendar_admin_details_setup_availablity_evening"
                                            style="top:calc(var(--cal-setup-hour) * 9); height:calc(var(--cal-setup-hour)*12);">
                                        </div>
                                    </div>
                                    <div>
                                        <div class="calendar_admin_details_setup_availablity_evening"
                                            style="top:calc(var(--cal-setup-hour) * 13); height:calc(var(--cal-setup-hour)*9);">
                                        </div>
                                    </div>
                                    <div>
                                        <div class="calendar_admin_details_setup_availablity_evening"
                                            style="top:calc(var(--cal-setup-hour) * 13); height:calc(var(--cal-setup-hour)*9);">
                                        </div>
                                    </div>
                                </div>

                                <div class="calendar_admin_details_setup_availablity_blocklayer"
                                    id="calendar_admin_details_setup_availablity_blocks">
                                    <!-- Blocks will be rendered dynamically -->
                                </div>
                            </div>
                        </div>
                    </section>
                </div>

                <div id="contentLessonBooking" class="calendar-content" style="display:none;">
                    <?php require_once("calendar_admin_details_setup_availablity_details_lesson_booking.php"); ?>
                </div>

                <div id="contentCalendarSettings" class="calendar-content" style="display:none;">
                    <?php require_once("calendar_admin_details_setup_availablity_details_calendar_settings.php"); ?>
                </div>

                <div id="contentGoogleCalendar" class="calendar-content" style="display:none;">
                    <?php require_once("calendar_admin_details_setup_availablity_details_google_calendar.php"); ?>
                </div>
            </div>
        </div>
    </div>

    <script>
    // ===== TOAST NOTIFICATION FUNCTION =====
    function showToast(message, type = 'success', duration = 5000) {
        const toast = document.getElementById('toastNotificationForAvailability');
        if (!toast) {
            console.warn('Toast element not found');
            return;
        }

        // Set message and styling
        toast.textContent = message;
        toast.style.background = type === 'error' ? '#dc3545' :
            type === 'warning' ? '#ffc107' :
            type === 'info' ? '#17a2b8' : '#28a745';
        toast.style.color = type === 'warning' ? '#212529' : '#fff';
        toast.style.display = 'block';
        toast.style.zIndex = '999999';

        // Animate in
        setTimeout(() => {
            toast.style.opacity = '1';
            toast.style.transform = 'translateY(0)';
        }, 10);

        // Auto hide
        const toastTimeout = setTimeout(() => {
            toast.style.opacity = '0';
            toast.style.transform = 'translateY(20px)';
            setTimeout(() => {
                toast.style.display = 'none';
            }, 300);
        }, duration);

        // Return dismiss function for manual control
        return {
            dismiss: () => {
                clearTimeout(toastTimeout);
                toast.style.opacity = '0';
                toast.style.transform = 'translateY(20px)';
                setTimeout(() => {
                    toast.style.display = 'none';
                }, 300);
            }
        };
    }

    // ===== CORE UTILITY FUNCTIONS =====
    function getDayName(dayIndex) {
        const days = ['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday'];
        return days[parseInt(dayIndex)] || 'Unknown';
    }

    function getStartDate() {
        const d = new Date();
        const day = (d.getDay() + 6) % 7;
        d.setDate(d.getDate() - day);
        return d.toISOString().split("T")[0];
    }

    // Improved payload builder and logger
    function logAvailabilityPayload(action, specificBlock = null) {
        const $userBtn = $('#calendar_admin_details_setup_availablity_userbtn');
        const teacherPayload = {
            name: $userBtn.data('teacher-name') || $userBtn.attr('data-teacher-name') || $(
                '#calendar_admin_details_setup_availablity_username').text(),
            img: $userBtn.data('teacher-img') || $userBtn.attr('data-teacher-img') || $(
                '#calendar_admin_details_setup_availablity_avatar').attr('src'),
            id: $userBtn.data('teacher-id') || $userBtn.attr('data-teacher-id') || null
        };

        const slots = [];

        if (specificBlock) {
            const $block = $(specificBlock);
            const dayIndex = $block.attr('data-day');
            const label = $block.find('.calendar_admin_details_setup_availablity_timelabel').text();
            const timeParts = label.split('–').map(t => t.trim());
            const startTime = timeParts[0] || '';
            const endTime = timeParts[1] || '';
            const slotId = $block.attr('data-id');
            slots.push({
                day: getDayName(dayIndex),
                startTime: startTime,
                endTime: endTime,
                ...(slotId ? {
                    id: slotId
                } : {})
            });
        } else {
            $('.calendar_admin_details_setup_availablity_day .calendar_admin_details_setup_availablity_block').each(
                function() {
                    const $block = $(this);
                    const dayIndex = $block.attr('data-day');
                    const label = $block.find('.calendar_admin_details_setup_availablity_timelabel').text();
                    const timeParts = label.split('–').map(t => t.trim());
                    const startTime = timeParts[0] || '';
                    const endTime = timeParts[1] || '';
                    slots.push({
                        day: getDayName(dayIndex),
                        startTime: startTime,
                        endTime: endTime
                    });
                });
        }

        console.log('Availability payload:', {
            teacher: teacherPayload,
            slots: slots,
            action: action,
            startDate: getStartDate()
        });

        // =============================
        // AJAX CALL TO BACKEND
        // =============================

        // Show loader
        const loader = document.getElementById('loader');
        if (loader) loader.style.display = 'flex';

        $.ajax({
            url: M.cfg.wwwroot + "/local/customplugin/ajax/teacher_availability.php",
            type: "POST",
            data: JSON.stringify({
                teacher: teacherPayload,
                slots: slots,
                action: action,
                startDate: getStartDate()
            }),
            contentType: "application/json",
            success: function(response) {
                console.log("Availability Response:", response);

                if (response.status === "success") {
                    // Show toast instead of alert
                    if (typeof showToast === 'function') {
                        showToast('Availability saved successfully (' + response.action + ')', 'success');
                    } else {
                        console.log("Availability saved successfully (" + response.action + ")");
                    }

                    // Refresh calendar to show updated availability
                    if (window.refetchCustomPluginData) {
                        window.refetchCustomPluginData('teacher-availability');
                    } else if (window.fetchCalendarEvents) {
                        window.fetchCalendarEvents();
                    }
                } else {
                    // Show error toast instead of alert
                    if (typeof showToast === 'function') {
                        showToast('Error: ' + response.error, 'error');
                    } else {
                        console.error("Error: " + response.error);
                    }
                }
            },
            error: function(xhr) {
                console.error("Availability Error:", xhr.responseText);
                // Show error toast instead of alert
                if (typeof showToast === 'function') {
                    showToast('Something went wrong while saving availability.', 'error');
                } else {
                    console.error("Something went wrong while saving availability.");
                }
            },
            complete: function() {
                // Hide loader always
                if (loader) loader.style.display = 'none';
            }
        });
    }

    // ===== CALENDAR INITIALIZATION =====
    (function() {
        // Build hour labels + 30-min boxes
        const $timeCol = $('#calendar_admin_details_setup_availablity_timecol');
        for (let h = 0; h < 24; h++) {
            const label = (h < 10 ? '0' + h : h) + ':00';
            $timeCol.append('<div class="calendar_admin_details_setup_availablity_hourlabel">' + label + '</div>');
        }

        const css = getComputedStyle(document.documentElement);
        const nightStartHour = parseFloat(css.getPropertyValue('--cal-setup-night-start-hour')) || 1;
        const nightEndHour = parseFloat(css.getPropertyValue('--cal-setup-night-end-hour')) || 5;
        const startHalf = Math.round(nightStartHour * 2);
        const endHalf = Math.round(nightEndHour * 2);

        $('.calendar_admin_details_setup_availablity_day').each(function() {
            const $col = $(this);
            for (let i = 0; i < 48; i++) {
                const $slot = $('<div class="calendar_admin_details_setup_availablity_halfbox"></div>');
                if (i >= startHalf && i < endHalf) {
                    $slot.addClass('calendar_admin_details_setup_availablity_nightbg');
                }
                $col.append($slot);
            }
        });

        // Popular slots toggle
        $('#calendar_admin_details_setup_availablity_popular_toggle').on('change', function() {
            $('#calendar_admin_details_setup_availablity_heat').css('display', this.checked ? 'grid' :
                'none');
        });
    })();

    // ===== TEACHER DROPDOWN =====
    <?php
    require_once(__DIR__ . '/../../config.php');
    require_login();
    global $DB, $PAGE;
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
    $teachers = [];
    if ($userIds) {
        list($inSql, $params) = $DB->get_in_or_equal($userIds, SQL_PARAMS_NAMED);
        $fields = "id, firstname, lastname, picture, imagealt, firstnamephonetic, lastnamephonetic, middlename, alternatename";
        $teachers = $DB->get_records_select('user', "id $inSql AND deleted = 0 AND suspended = 0", $params, 'firstname ASC, lastname ASC', $fields);
    }
    $teacherJsArray = [];
    if (!empty($teachers)) {
        foreach ($teachers as $teacher) {
            $picture = new user_picture($teacher);
            $picture->size = 50;
            $imageUrl = $picture->get_url($PAGE)->out(false);
            $name   = fullname($teacher, true);
            $teacherJsArray[] = [
                'id' => (int)$teacher->id,
                'name' => $name,
                'img' => $imageUrl
            ];
        }
    }
    ?>
        (function() {
            const teachers =
                <?php echo json_encode($teacherJsArray, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE); ?>;
            const $btn = $('#calendar_admin_details_setup_availablity_userbtn');
            const $menu = $(`
            <div id="calendar_admin_details_setup_availablity_menu" class="calendar_admin_details_setup_availablity_menu" role="menu" aria-hidden="true">
                <div class="p-2 border-bottom">
                    <input type="text" id="teacherSearch" class="form-control" placeholder="Enter Teacher Name" />
                </div>
            </div>
        `);

            teachers.forEach(t => {
                $menu.append(
                    `<div class="calendar_admin_details_setup_availablity_menu_item" role="menuitem" tabindex="0" data-name="${t.name}" data-img="${t.img}" data-userid="${t.id}">
                    <img class="calendar_admin_details_setup_availablity_menu_avatar" src="${t.img}" alt="">
                    <div class="calendar_admin_details_setup_availablity_menu_name">${t.name}</div>
                </div>`
                );
            });

            $('body').append($menu);

            function fetchTeacherAvailability(payload) {
                $.ajax({
                    url: M.cfg.wwwroot + "/local/customplugin/ajax/get_teacher_availability.php",
                    type: "POST",
                    data: JSON.stringify(payload),
                    contentType: "application/json",
                    success: function(res) {
                        console.log("Teacher availability response:", res);

                        if (!res || res.ok === false) {
                            if (typeof showToast === 'function') {
                                showToast("Failed to load availability: " + (res && res.error ? res
                                    .error : "Unknown error"), 'error');
                            } else {
                                console.error("Failed to load availability: " + (res && res.error ? res
                                    .error : "Unknown error"));
                            }
                            return;
                        }

                        const slots = Array.isArray(res.availability) ? res.availability : [];
                        if (typeof window.renderAvailability === "function") {
                            window.renderAvailability(slots);
                        } else {
                            console.warn("renderAvailability not ready; availability data skipped");
                        }
                    },
                    error: function(xhr) {
                        console.error("Load teacher availability error:", xhr.responseText);
                        if (typeof showToast === 'function') {
                            showToast('Something went wrong while loading availability.', 'error');
                        } else {
                            console.error("Something went wrong while loading availability.");
                        }
                    }
                });
            }

            // Initialize first teacher
            if (teachers.length > 0) {
                $('#calendar_admin_details_setup_availablity_username').text(teachers[0].name);
                $('#calendar_admin_details_setup_availablity_avatar').attr('src', teachers[0].img);
                const $userBtn = $('#calendar_admin_details_setup_availablity_userbtn');
                $userBtn.data('teacher-id', teachers[0].id)
                    .data('teacher-name', teachers[0].name)
                    .data('teacher-img', teachers[0].img)
                    .attr('data-teacher-id', teachers[0].id)
                    .attr('data-teacher-name', teachers[0].name)
                    .attr('data-teacher-img', teachers[0].img);
                fetchTeacherAvailability(teachers[0]);
            }

            function pos() {
                const r = $btn[0].getBoundingClientRect(),
                    gap = 8;
                let l = r.left,
                    t = r.bottom + gap,
                    w = $menu.outerWidth(),
                    vw = innerWidth;
                if (l + w > vw - 12) l = vw - w - 12;
                $menu.css({
                    left: l + scrollX,
                    top: t + scrollY
                });
            }

            function open() {
                pos();
                $menu.show();
                $btn.addClass('open').attr('aria-expanded', 'true');
                $(document).on('click._m', dcl).on('keydown._m', k);
            }

            function close() {
                $menu.hide();
                $btn.removeClass('open').attr('aria-expanded', 'false');
                $(document).off('click._m keydown._m');
            }

            function dcl(e) {
                if (!$(e.target).closest(
                        '#calendar_admin_details_setup_availablity_menu,#calendar_admin_details_setup_availablity_userbtn'
                    ).length) close();
            }

            function k(e) {
                if (e.key === 'Escape') close();
            }

            $btn.on('click', () => $menu.is(':visible') ? close() : open());
            $(window).on('resize scroll', () => {
                if ($menu.is(':visible')) pos();
            });

            // Live search filter
            $menu.on('input', '#teacherSearch', function() {
                const val = $(this).val().toLowerCase();
                $menu.find('.calendar_admin_details_setup_availablity_menu_item').each(function() {
                    const name = $(this).data('name').toLowerCase();
                    $(this).toggle(name.includes(val));
                });
            });

            $menu.on('click keydown', '.calendar_admin_details_setup_availablity_menu_item', function(e) {
                if (e.type === 'keydown' && e.key !== 'Enter') return;
                const payload = {
                    name: $(this).data('name'),
                    id: $(this).data('userid'),
                    img: $(this).data('img')
                };
                console.log('Selected teacher payload:', payload);
                fetchTeacherAvailability(payload);
                $('#calendar_admin_details_setup_availablity_username').text(payload.name);
                $('#calendar_admin_details_setup_availablity_avatar').attr('src', payload.img);
                const $userBtn = $('#calendar_admin_details_setup_availablity_userbtn');
                $userBtn.data('teacher-id', payload.id)
                    .data('teacher-name', payload.name)
                    .data('teacher-img', payload.img);
                close();
            });
        })();

    // ===== SIDEBAR NAVIGATION =====
    (function() {
        const map = {
            btnAvailability: '#contentAvailability',
            btnLessonBooking: '#contentLessonBooking',
            btnCalendarSettings: '#contentCalendarSettings',
            btnGoogleCalendar: '#contentGoogleCalendar'
        };

        $('.calendar_admin_details_setup_availablity_sidebtn').on('click', function() {
            $('.calendar_admin_details_setup_availablity_sidebtn').removeClass('active');
            $(this).addClass('active');
            $('.calendar-content').hide();
            const target = map[this.id];
            if (target) $(target).show();
        });
    })();

    // ===== BLOCK MANAGEMENT (CREATE, DRAG, RESIZE, DELETE) =====
    (function() {
        const HOUR_PX = parseFloat(getComputedStyle(document.documentElement).getPropertyValue(
            '--cal-setup-hour')) || 60;
        const HALF_H = parseFloat(getComputedStyle(document.documentElement).getPropertyValue(
            '--cal-setup-half')) || 30;
        const SLOT_H = HALF_H;
        const PILL_H = parseFloat(getComputedStyle(document.documentElement).getPropertyValue(
            '--cal-setup-slot-pill')) || 26;
        const SNAP_PX = HOUR_PX / 4;
        const MIN_H = SNAP_PX * 2;

        let dragging = null,
            resizing = null;
        const clamp = (v, min, max) => Math.max(min, Math.min(max, v));

        // Time formatting functions
        function pxToMinutes(px) {
            return Math.round(px / SNAP_PX) * 15;
        }

        function minutesToHHMM(m) {
            const h = Math.floor(m / 60),
                mm = m % 60;
            const mmStr = mm === 0 ? '00' : mm === 15 ? '15' : mm === 30 ? '30' : '45';
            return (h < 10 ? '0' : '') + h + ':' + mmStr;
        }

        function hhmm(m) {
            const h = Math.floor(m / 60),
                mm = m % 60;
            return (h < 10 ? '0' : '') + h + ':' + (mm === 0 ? '00' : '30');
        }

        // Unified label update function
        function updateLabel($block, startMin = null, endMin = null) {
            let label;
            if (startMin !== null && endMin !== null) {
                label = `${hhmm(startMin)} – ${hhmm(endMin)}`;
            } else {
                const top = parseFloat($block.css('top')) || 0;
                const h = $block.outerHeight();
                const startMin = pxToMinutes(top);
                const durMin = pxToMinutes(h);
                const endMin = startMin + durMin;
                label = `${minutesToHHMM(startMin)} – ${minutesToHHMM(endMin)}`;
            }

            let $lbl = $block.children('.calendar_admin_details_setup_availablity_timelabel');
            if ($lbl.length) $lbl.text(label);
            else $block.prepend(`<span class="calendar_admin_details_setup_availablity_timelabel">${label}</span>`);
        }
        window.__cal_updateLabel = updateLabel;

        // Render availability blocks from backend payload
        const DAY_TO_INDEX = {
            monday: 0,
            tuesday: 1,
            wednesday: 2,
            thursday: 3,
            friday: 4,
            saturday: 5,
            sunday: 6
        };

        function toMinutes(val) {
            if (typeof val === 'number' && !Number.isNaN(val)) return val;
            if (typeof val === 'string') {
                if (val.includes(':')) {
                    const parts = val.split(':');
                    const h = parseInt(parts[0], 10);
                    const m = parseInt(parts[1] || '0', 10);
                    if (!Number.isNaN(h)) return h * 60 + (Number.isNaN(m) ? 0 : m);
                }
                const parsed = parseInt(val, 10);
                if (!Number.isNaN(parsed)) return parsed;
            }
            return null;
        }

        function renderAvailability(slots = []) {
            $('.calendar_admin_details_setup_availablity_day .calendar_admin_details_setup_availablity_block')
                .remove();
            $('#calendar_admin_details_setup_availablity_blocks').empty();

            if (!Array.isArray(slots)) return;

            slots.forEach((slot) => {
                const dayIdx = DAY_TO_INDEX[String(slot.day || '').toLowerCase()];
                if (typeof dayIdx !== 'number') return;

                const startMin = toMinutes(slot.startTime);
                const endMin = toMinutes(slot.endTime);
                if (startMin === null || endMin === null || endMin <= startMin) return;

                const $day = $('.calendar_admin_details_setup_availablity_day').eq(dayIdx);
                if (!$day.length) return;

                const slotIndex = Math.floor(startMin / 30);
                const topPx = slotIndex * SLOT_H;
                const heightPx = Math.max(MIN_H, ((endMin - startMin) / 30) * SLOT_H);

                const $block = $(`
                    <div class="calendar_admin_details_setup_availablity_block" data-day="${dayIdx}" data-slot="${slotIndex}" style="top:${topPx}px; height:${heightPx}px;">
                        <div class="calendar_admin_details_setup_availablity_timelabel"></div>
                        <div class="calendar_admin_details_setup_availablity_resize">v</div>
                    </div>
                `);
                // Attach slot id if present
                if (slot.id) $block.attr('data-id', slot.id);

                $day.append($block);
                updateLabel($block, startMin, endMin);
            });
        }
        window.renderAvailability = renderAvailability;

        // Delete UI management
        function clearDeleteUI() {
            $('.calendar_admin_details_setup_availablity_deletebtn').remove();
            $('.calendar_admin_details_setup_availablity_block').removeClass(
                'calendar_admin_details_setup_availablity_selected');
        }

        function showDeleteUI($block) {
            clearDeleteUI();
            $block.addClass('calendar_admin_details_setup_availablity_selected');
            const $btn = $(`
                <div class="calendar_admin_details_setup_availablity_deletebtn">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M19 7l-.9 12.1A2 2 0 0 1 16.1 21H7.9a2 2 0 0 1-2-1.9L5 7m5-4h4a1 1 0 0 1 1 1v1H9V4a1 1 0 0 1 1-1z"/>
                    </svg>
                    Delete Slot
                </div>
            `);
            $btn.on('click', function(ev) {
                ev.stopPropagation();
                logAvailabilityPayload('delete', $block);
                $block.remove();
                clearDeleteUI();
            });
            $block.append($btn);
        }

        window.__cal_delete = {
            clear: clearDeleteUI,
            show: showDeleteUI
        };

        // Block creation
        $('.calendar_admin_details_setup_availablity_day').on('click',
            '.calendar_admin_details_setup_availablity_halfbox',
            function(e) {
                e.stopPropagation();
                const $day = $(this).closest('.calendar_admin_details_setup_availablity_day');
                const dayIndex = parseInt($day.data('day'), 10);
                const slotIndex = $(this).index();
                const slotTop = slotIndex * SLOT_H;

                if ($day.find(`.calendar_admin_details_setup_availablity_block[data-slot='${slotIndex}']`)
                    .length) return;

                const startMin = slotIndex * 30;
                const endMin = startMin + 30;

                const $block = $(`
                <div class="calendar_admin_details_setup_availablity_block is-compact"
                     data-day="${dayIndex}" data-slot="${slotIndex}" data-top="${slotTop}"
                     style="--_slotTop:${slotTop}px; top:${slotTop}px; height:${PILL_H}px; z-index:5;">
                    <div class="calendar_admin_details_setup_availablity_timelabel"></div>
                    <div class="calendar_admin_details_setup_availablity_resize">v</div>
                </div>
            `);

                $day.append($block);
                updateLabel($block, startMin, endMin);
                setTimeout(() => logAvailabilityPayload('create', $block[0]), 10);
            });

        // Initialize labels for existing blocks
        $('#calendar_admin_details_setup_availablity_blocks .calendar_admin_details_setup_availablity_block').each(
            function() {
                updateLabel($(this));
            });

        // Drag and resize functionality
        function $container($el) {
            const $p = $el.parent();
            if ($p.is('#calendar_admin_details_setup_availablity_blocks')) return $p;
            if ($p.hasClass('calendar_admin_details_setup_availablity_day')) return $p;
            return $p;
        }

        function dayRects() {
            const rects = [];
            $('.calendar_admin_details_setup_availablity_day').each(function(i) {
                const $d = $(this);
                const o = $d.offset();
                rects.push({
                    idx: i,
                    $el: $d,
                    left: o.left,
                    right: o.left + $d.outerWidth(),
                    top: o.top,
                    bottom: o.top + $d.outerHeight()
                });
            });
            return rects;
        }

        function getActionForBlock($block, isDrag = false) {
            if (isDrag) return 'drag';
            return $block.attr('data-id') ? 'update' : 'create';
        }


        function columnAt(pageX) {
            const rs = dayRects();
            for (let r of rs) {
                if (pageX >= r.left && pageX < r.right) return r;
            }
            if (rs.length) return pageX < rs[0].left ? rs[0] : rs[rs.length - 1];
            return null;
        }

        function moveBlockToDay($el, targetDayRect, pageY) {
            const $from = $el.parent();
            const fromOff = $from.offset();
            const oldAbsTop = (parseFloat($el.css('top')) || 0) + fromOff.top;
            const newTop = oldAbsTop - targetDayRect.top;
            $el.css({
                left: '',
                right: '',
                width: '',
                top: Math.max(0, Math.round(newTop / SNAP_PX) * SNAP_PX)
            });
            $el.appendTo(targetDayRect.$el);
            $el.attr('data-day', targetDayRect.idx);
            const slotIndex = Math.round((parseFloat($el.css('top')) || 0) / HALF_H);
            $el.attr('data-slot', slotIndex);
            if (dragging) {
                dragging.$host = targetDayRect.$el;
                dragging.top0 = parseFloat($el.css('top')) || 0;
                dragging.y0 = pageY;
            }
            updateLabel($el);
        }

        // Event handlers for drag and resize
        $(document).on('mousedown touchstart', '.calendar_admin_details_setup_availablity_block', function(e) {
            if ($(e.target).closest('.calendar_admin_details_setup_availablity_resize').length) return;
            const $el = $(this);
            if ($el.hasClass('is-compact')) {
                $el.removeClass('is-compact');
                if ($el.outerHeight() < MIN_H) $el.css('height', MIN_H + 'px');
            }
            const y = e.pageY || e.originalEvent.touches?. [0]?.pageY;
            const x = e.pageX || e.originalEvent.touches?. [0]?.pageX;
            dragging = {
                $el,
                y0: y,
                x0: x,
                top0: parseFloat($el.css('top')) || 0,
                $host: $container($el),
                moved: 0
            };
            e.stopPropagation();
            $('body').addClass('user-select-none');
        });

        $(document).on('mousedown touchstart', '.calendar_admin_details_setup_availablity_resize', function(e) {
            const $el = $(this).closest('.calendar_admin_details_setup_availablity_block');
            if ($el.hasClass('is-compact')) {
                $el.removeClass('is-compact');
                if ($el.outerHeight() < MIN_H) $el.css('height', MIN_H + 'px');
            }
            const y = e.pageY || e.originalEvent.touches?. [0]?.pageY;
            resizing = {
                $el,
                y0: y,
                h0: $el.outerHeight(),
                $host: $container($el),
                moved: 0
            };
            e.stopPropagation();
            $('body').addClass('user-select-none');
        });

        $(document).on('mousemove touchmove', function(e) {
            const pageY = e.pageY || e.originalEvent.touches?. [0]?.pageY;
            const pageX = e.pageX || e.originalEvent.touches?. [0]?.pageX;

            if (dragging) {
                const deltaY = Math.abs(pageY - dragging.y0);
                const deltaX = Math.abs(pageX - (dragging.x0 || pageX));
                dragging.moved = Math.max(deltaY, deltaX);

                const col = columnAt(pageX);
                if (col && !dragging.$host.is(col.$el)) moveBlockToDay(dragging.$el, col, pageY);

                const hostH = dragging.$host.height();
                let top = dragging.top0 + (pageY - dragging.y0);
                const maxTop = hostH - dragging.$el.outerHeight();
                top = clamp(Math.round(top / SNAP_PX) * SNAP_PX, 0, Math.max(0, maxTop));
                dragging.$el.css('top', top + 'px');
                updateLabel(dragging.$el);
            } else if (resizing) {
                resizing.moved = Math.abs(pageY - resizing.y0);
                const hostH = resizing.$host.height();
                const curTop = parseFloat(resizing.$el.css('top')) || 0;
                let h = resizing.h0 + (pageY - resizing.y0);
                const maxH = hostH - curTop;
                h = clamp(Math.round(h / SNAP_PX) * SNAP_PX, MIN_H, Math.max(MIN_H, maxH));
                resizing.$el.css('height', h + 'px');
                updateLabel(resizing.$el);
            }
        });

        $(document).on('mouseup touchend', function() {
            if (dragging && Math.abs(dragging.moved || 0) > 5) {
                const $el = dragging.$el;
                logAvailabilityPayload(getActionForBlock($el, true), $el[0]);
            } else if (resizing && Math.abs(resizing.moved || 0) > 5) {
                const $el = resizing.$el;
                logAvailabilityPayload(getActionForBlock($el), $el[0]);
            }

            dragging = null;
            resizing = null;
            $('body').removeClass('user-select-none');
        });

        // Block selection and delete UI
        $(document).on('click', '.calendar_admin_details_setup_availablity_block', function(e) {
            if ($(e.target).closest('.calendar_admin_details_setup_availablity_deletebtn').length) return;
            const $block = $(this);
            if ($(e.target).closest('.calendar_admin_details_setup_availablity_resize').length) {
                showDeleteUI($block);
                return;
            }
            showDeleteUI($block);
            logAvailabilityPayload('select');
        });

        $(document).on('click', function(e) {
            if (!$(e.target).closest(
                    '.calendar_admin_details_setup_availablity_block,.calendar_admin_details_setup_availablity_deletebtn'
                ).length) {
                clearDeleteUI();
            }
        });

        $('<style>.user-select-none{user-select:none;-webkit-user-select:none}</style>').appendTo(document.head);
    })();
    </script>

</body>

</html>