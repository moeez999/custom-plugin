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
    :root {
        /* Layout */
        --cal-setup-timecol: 76px;
        --cal-setup-hour: 80px;
        /* 60px per hour */
        --cal-setup-half: 40px;
        /* 30-min slot */
        --cal-setup-night-start-hour: 1;
        /* ⬅️ gray band starts 01:00 */
        --cal-setup-night-end-hour: 5;
        /* ⬅️ gray band ends 05:00 */
        --cal-setup-block-gutter: 2px;
        /* set 0px for absolutely no side gap */


        /* Backgrounds */
        --cal-setup-pagebg: #f3f4f8;
        /* page bg */
        --cal-setup-bg: #f6f7fb;
        /* left panel bg */
        --cal-setup-card: #fff;

        /* Lines & text */
        --cal-setup-border: #e7e8f1;
        --cal-setup-grid: #e8e8f2;
        --cal-setup-grid-strong: #3a3a45;
        --cal-setup-text: #141414;
        --cal-setup-muted: #6f7380;

        /* Alternating rows */
        --cal-setup-row-alt: #fbfbfe;
        --cal-setup-night-bg: #eff1f6;
        /* middle gray band */

        /* Blocks & heat */
        --cal-setup-accent: #0f56d8;
        --cal-setup-accent-ink: #fff;
        --cal-setup-slot-peak: #ffb2a8;
        /* warm mid-day */
        --cal-setup-slot-late: #b7c0ea;
        /* cool evening */

        /* Compact pill height */
        --cal-setup-slot-pill: 26px;
        /* tweak to 20–30px to taste */
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
        /* force the short height */
        box-sizing: border-box;
        padding: 4px 10px;
        margin: 0 0;
        /* pills flush; big blocks keep the global gutter */
    }

    /* Center the pill inside the 30-min slot */
    .calendar_admin_details_setup_availablity_block.is-compact {
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

    /* “Night time” divider + chip at END (05:00) */
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
        /* allow clicks through empty layer */
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
        /* ← anchor reset */
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

    /* When checked: black background, white tick */
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
    </style>
</head>

<body>

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
                    <h1 class="calendar_admin_details_setup_availablity_title">Select time slots when you’re available
                        for
                        booking
                    </h1>
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
                                    <div class="calendar_admin_details_setup_availablity_block"
                                        style="top:calc(var(--cal-setup-hour)*8); height:calc(var(--cal-setup-hour)*3);
                          left:calc((100% - var(--cal-setup-timecol))/7*3 + var(--cal-setup-timecol));
                          right:calc((100% - var(--cal-setup-timecol)) - ((100% - var(--cal-setup-timecol))/7*4 + var(--cal-setup-timecol)));">
                                        <div class="calendar_admin_details_setup_availablity_timelabel"></div>
                                        <div class="calendar_admin_details_setup_availablity_resize">v</div>
                                    </div>
                                    <div class="calendar_admin_details_setup_availablity_block"
                                        style="top:calc(var(--cal-setup-hour)*11); height:calc(var(--cal-setup-hour)*3);
                          left:calc((100% - var(--cal-setup-timecol))/7*4 + var(--cal-setup-timecol));
                          right:calc((100% - var(--cal-setup-timecol)) - ((100% - var(--cal-setup-timecol))/7*5 + var(--cal-setup-timecol)));">
                                        <div class="calendar_admin_details_setup_availablity_timelabel"></div>
                                        <div class="calendar_admin_details_setup_availablity_resize">v</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </section>
                </div>

                <div id="contentLessonBooking" class="calendar-content" style="display:none;">
                    <?php require_once("calendar_admin_details_setup_availablity_details_lesson_booking.php"); ?>
                </div>

                <div id="contentCalendarSettings" class="calendar-content" style="display:none;">
                    <?php  require_once("calendar_admin_details_setup_availablity_details_calendar_settings.php"); ?>
                </div>

                <div id="contentGoogleCalendar" class="calendar-content" style="display:none;">
                    <?php  require_once("calendar_admin_details_setup_availablity_details_google_calendar.php"); ?>
                </div>
            </div>
        </div>
    </div>

    <script>
    /* Build hour labels + 30-min boxes; color the middle gray band between START and END hours */
    (function() {
        const $timeCol = $('#calendar_admin_details_setup_availablity_timecol');
        for (let h = 0; h < 24; h++) {
            const label = (h < 10 ? '0' + h : h) + ':00';
            $timeCol.append('<div class="calendar_admin_details_setup_availablity_hourlabel">' + label + '</div>');
        }

        const css = getComputedStyle(document.documentElement);
        const nightStartHour = parseFloat(css.getPropertyValue('--cal-setup-night-start-hour')) || 1;
        const nightEndHour = parseFloat(css.getPropertyValue('--cal-setup-night-end-hour')) || 5;
        const startHalf = Math.round(nightStartHour * 2);
        const endHalf = Math.round(nightEndHour * 2); // exclusive

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
    })();

    /* Popular slots toggle */
    $('#calendar_admin_details_setup_availablity_popular_toggle').on('change', function() {
        $('#calendar_admin_details_setup_availablity_heat').css('display', this.checked ? 'grid' : 'none');
    });
    </script>

    <!-- ===== UNIVERSAL drag + resize (existing + new slots) — with LEFT/RIGHT cross-day dragging ===== -->
    <script>
    (function() {
        const HOUR_PX = parseFloat(getComputedStyle(document.documentElement).getPropertyValue(
            '--cal-setup-hour')) || 60;
        const HALF_H = parseFloat(getComputedStyle(document.documentElement).getPropertyValue(
            '--cal-setup-half')) || 30; // px per 30m
        const SNAP_PX = HOUR_PX / 4; // 15 min
        const MIN_H = SNAP_PX * 2; // 30 min min height

        let dragging = null,
            resizing = null;
        const clamp = (v, min, max) => Math.max(min, Math.min(max, v));

        function $container($el) {
            const $p = $el.parent();
            if ($p.is('#calendar_admin_details_setup_availablity_blocks')) return $p;
            if ($p.hasClass('calendar_admin_details_setup_availablity_day')) return $p;
            return $p;
        }

        // Day geometry
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

        function columnAt(pageX) {
            const rs = dayRects();
            for (let r of rs) {
                if (pageX >= r.left && pageX < r.right) return r;
            }
            if (rs.length) return pageX < rs[0].left ? rs[0] : rs[rs.length - 1];
            return null;
        }

        function pxToMinutes(px) {
            return Math.round(px / SNAP_PX) * 15;
        }

        function minutesToHHMM(m) {
            const h = Math.floor(m / 60),
                mm = m % 60;
            const mmStr = mm === 0 ? '00' : mm === 15 ? '15' : mm === 30 ? '30' : '45';
            return (h < 10 ? '0' : '') + h + ':' + mmStr;
        }

        function updateLabel($el) {
            const top = parseFloat($el.css('top')) || 0;
            const h = $el.outerHeight();
            const startMin = pxToMinutes(top);
            const durMin = pxToMinutes(h);
            const endMin = startMin + durMin;
            const lbl = `${minutesToHHMM(startMin)} – ${minutesToHHMM(endMin)}`;
            let $lbl = $el.children('.calendar_admin_details_setup_availablity_timelabel');
            if ($lbl.length) $lbl.text(lbl);
            else $el.prepend(`<span class="calendar_admin_details_setup_availablity_timelabel">${lbl}</span>`);
        }
        window.__cal_updateLabel = updateLabel;

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

        // Start DRAG
        $(document).on('mousedown touchstart', '.calendar_admin_details_setup_availablity_block', function(e) {
            if ($(e.target).closest('.calendar_admin_details_setup_availablity_resize').length) return;
            const $el = $(this);

            // Promote compact pill to resizable block on first drag
            if ($el.hasClass('is-compact')) {
                $el.removeClass('is-compact');
                if ($el.outerHeight() < MIN_H) $el.css('height', MIN_H + 'px');
            }

            const pageY = e.pageY || e.originalEvent.touches?. [0]?.pageY;
            const pageX = e.pageX || e.originalEvent.touches?. [0]?.pageX;

            // If it lives on week layer, reparent immediately to the day under pointer
            const $parent = $container($el);
            if ($parent.is('#calendar_admin_details_setup_availablity_blocks')) {
                const col = columnAt(pageX);
                if (col) moveBlockToDay($el, col, pageY);
            }

            dragging = {
                $el,
                y0: pageY,
                top0: parseFloat($el.css('top')) || 0,
                $host: $container($el)
            };
            $('body').addClass('user-select-none');
        });

        // Start RESIZE
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
                $host: $container($el)
            };
            e.stopPropagation();
            $('body').addClass('user-select-none');
        });

        // Move (vertical snap + horizontal reparent)
        $(document).on('mousemove touchmove', function(e) {
            const pageY = e.pageY || e.originalEvent.touches?. [0]?.pageY;
            const pageX = e.pageX || e.originalEvent.touches?. [0]?.pageX;

            if (dragging) {
                // Horizontal → if pointer enters another column, reparent
                const col = columnAt(pageX);
                if (col && !dragging.$host.is(col.$el)) moveBlockToDay(dragging.$el, col, pageY);

                // Vertical inside host
                const hostH = dragging.$host.height();
                let top = dragging.top0 + (pageY - dragging.y0);
                const maxTop = hostH - dragging.$el.outerHeight();
                top = clamp(Math.round(top / SNAP_PX) * SNAP_PX, 0, Math.max(0, maxTop));
                dragging.$el.css('top', top + 'px');
                updateLabel(dragging.$el);
            } else if (resizing) {
                const hostH = resizing.$host.height();
                const curTop = parseFloat(resizing.$el.css('top')) || 0;
                let h = resizing.h0 + (pageY - resizing.y0);
                const maxH = hostH - curTop;
                h = clamp(Math.round(h / SNAP_PX) * SNAP_PX, MIN_H, Math.max(MIN_H, maxH));
                resizing.$el.css('height', h + 'px');
                updateLabel(resizing.$el);
            }
        });

        // End
        $(document).on('mouseup touchend', function() {
            dragging = null;
            resizing = null;
            $('body').removeClass('user-select-none');
        });

        $('<style>.user-select-none{user-select:none;-webkit-user-select:none}</style>').appendTo(document.head);
    })();
    </script>

    <script>
    /* Tutor dropdown */
    (function() {
        const people = [{
                name: 'Edwards',
                img: 'https://randomuser.me/api/portraits/men/32.jpg'
            },
            {
                name: 'Daniela',
                img: 'https://randomuser.me/api/portraits/women/65.jpg'
            },
            {
                name: 'Hawkins',
                img: 'https://randomuser.me/api/portraits/men/15.jpg'
            },
            {
                name: 'Lane',
                img: 'https://randomuser.me/api/portraits/men/41.jpg'
            },
            {
                name: 'Warren',
                img: 'https://randomuser.me/api/portraits/men/72.jpg'
            },
            {
                name: 'Fox',
                img: 'https://randomuser.me/api/portraits/men/11.jpg'
            }
        ];

        const $btn = $('#calendar_admin_details_setup_availablity_userbtn');
        const $menu = $(`
  <div id="calendar_admin_details_setup_availablity_menu" class="calendar_admin_details_setup_availablity_menu" role="menu" aria-hidden="true">
    <div class="p-2 border-bottom">
      <input type="text" id="teacherSearch" class="form-control" placeholder="Enter Teacher Name" />
    </div>
  </div>
`);

        people.forEach(p => {
            $menu.append(
                `<div class="calendar_admin_details_setup_availablity_menu_item" role="menuitem" tabindex="0" data-name="${p.name}" data-img="${p.img}">
         <img class="calendar_admin_details_setup_availablity_menu_avatar" src="${p.img}" alt="">
         <div class="calendar_admin_details_setup_availablity_menu_name">${p.name}</div>
       </div>`
            );
        });
        // Live search filter
        $menu.on('input', '#teacherSearch', function() {
            const val = $(this).val().toLowerCase();
            $menu.find('.calendar_admin_details_setup_availablity_menu_item').each(function() {
                const name = $(this).data('name').toLowerCase();
                $(this).toggle(name.includes(val));
            });
        });

        $('body').append($menu);

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
            $(document).on('click._m', dcl);
            $(document).on('keydown._m', k);
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
        $menu.on('click keydown', '.calendar_admin_details_setup_availablity_menu_item', function(e) {
            if (e.type === 'keydown' && e.key !== 'Enter') return;
            $('#calendar_admin_details_setup_availablity_username').text($(this).data('name'));
            $('#calendar_admin_details_setup_availablity_avatar').attr('src', $(this).data('img'));
            close();
        });
    })();

    /* ===== Sidebar navigation toggle ===== */
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
    </script>

    <!-- ===== Create-on-empty v1 (kept for DELETE UI only; creation disabled to avoid double blocks) ===== -->
    <script>
    (function() {
        const $layer = $('#calendar_admin_details_setup_availablity_blocks');
        const HOUR_PX = parseFloat(getComputedStyle(document.documentElement).getPropertyValue(
            '--cal-setup-hour')) || 60;
        const SNAP_MIN = 30;
        const SNAP_PX = HOUR_PX * (SNAP_MIN / 60);

        function pxToMinutes(px) {
            return Math.round(px / SNAP_PX) * SNAP_MIN;
        }

        function minutesToHHMM(m) {
            const h = Math.floor(m / 60),
                mm = m % 60;
            return (h < 10 ? '0' : '') + h + ':' + (mm === 0 ? '00' : '30');
        }

        function setLabel30($block) {
            const top = parseFloat($block.css('top')) || 0;
            const h = $block.outerHeight();
            const startMin = pxToMinutes(top);
            const durMin = pxToMinutes(h);
            const endMin = startMin + durMin;
            const label = `${minutesToHHMM(startMin)} – ${minutesToHHMM(endMin)}`;
            let $lbl = $block.children('.calendar_admin_details_setup_availablity_timelabel');
            if ($lbl.length) $lbl.text(label);
            else $block.prepend(`<span class="calendar_admin_details_setup_availablity_timelabel">${label}</span>`);
        }

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
            d="M19 7l-.9 12.1A2 2 0 0 1 16.1 21H7.9a2 2 0 0 1-2-1.9L5 7m5-4h4a1 1 0 0 1 1 1v1H9V4a1 1 0 0 1 1-1z" />
        </svg>
        Delete Slot
      </div>
    `);
            $btn.on('click', function(ev) {
                ev.stopPropagation();
                $block.remove();
                clearDeleteUI();
            });
            $block.append($btn);
        }

        /* Init labels for initial hard-coded blocks */
        $layer.find('.calendar_admin_details_setup_availablity_block').each(function() {
            if (window.__cal_updateLabel) window.__cal_updateLabel($(this));
            else setLabel30($(this));
        });

        /* Click a blue block → show delete bubble */
        $layer.on('click', '.calendar_admin_details_setup_availablity_block', function(e) {
            if ($(e.target).closest('.calendar_admin_details_setup_availablity_resize').length) return;
            showDeleteUI($(this));
        });

        /* Click outside → hide bubble */
        $(document).on('click', function(e) {
            if (!$(e.target).closest('.calendar_admin_details_setup_availablity_block').length) {
                clearDeleteUI();
            }
        });
    })();
    </script>

    <!-- ===== Compact 1-slot CREATOR (active) ===== -->
    <script>
    (function() {
        const cssRoot = getComputedStyle(document.documentElement);
        const SLOT_H = parseFloat(cssRoot.getPropertyValue('--cal-setup-half')) || 30; // px per 30-min slot
        const PILL_H = parseFloat(cssRoot.getPropertyValue('--cal-setup-slot-pill')) || 26;

        function hhmm(m) {
            const h = Math.floor(m / 60),
                mm = m % 60;
            return (h < 10 ? '0' : '') + h + ':' + (mm === 0 ? '00' : '30');
        }

        function setLabel($block, startMin, endMin) {
            const label = `${hhmm(startMin)} – ${hhmm(endMin)}`;
            const $lbl = $block.children('.calendar_admin_details_setup_availablity_timelabel');
            if ($lbl.length) $lbl.text(label);
            else $block.prepend(`<span class="calendar_admin_details_setup_availablity_timelabel">${label}</span>`);
        }

        // Click on an empty 30-min cell → create a COMPACT pill for ONE slot (30 min)
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
                setLabel($block, startMin, endMin);
            });
    })();
    </script>

    <script>
    /* Delete bubble for ALL blocks (big & compact pills) */
    (function() {
        function clearDeleteUI() {
            $('.calendar_admin_details_setup_availablity_deletebtn').remove();
            $('.calendar_admin_details_setup_availablity_block')
                .removeClass('calendar_admin_details_setup_availablity_selected');
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
                $block.remove();
                clearDeleteUI();
            });
            $block.append($btn);
        }

        window.__cal_delete = {
            clear: clearDeleteUI,
            show: showDeleteUI
        };

        $(document).on('click', '.calendar_admin_details_setup_availablity_block', function(e) {
            if ($(e.target).closest('.calendar_admin_details_setup_availablity_resize').length) return;
            showDeleteUI($(this));
        });

        $(document).on('click', function(e) {
            if (!$(e.target).closest(
                    '.calendar_admin_details_setup_availablity_block,.calendar_admin_details_setup_availablity_deletebtn'
                ).length) {
                clearDeleteUI();
            }
        });
    })();
    </script>

</body>

</html>