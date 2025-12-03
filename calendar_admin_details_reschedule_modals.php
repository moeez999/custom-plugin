<!-- Manage Session Modal -->
<div id="manage-session-modal" class="modal-overlay" style="display: none;">
    <section class="manage-session-section">
        <div class="session-card">
            <header class="session-header">
                <h2 class="header-title">Manage Session</h2>
                <button class="close-button" id="close-manage-session" aria-label="Close">
                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                        stroke-linecap="round" stroke-linejoin="round">
                        <line x1="18" y1="6" x2="6" y2="18"></line>
                        <line x1="6" y1="6" x2="18" y2="18"></line>
                    </svg>
                </button>
            </header>

            <form class="session-form" id="manage-session-form">
                <div class="form-row">
                    <div class="form-group">
                        <label for="session-cohort">Cohort</label>
                        <div id="session-cohort-dropdown" class="custom-dropdown">
                            <button type="button" class="dropdown-btn" id="session-cohort-btn" disabled
                                style="background-color:#f5f5f5;cursor:not-allowed;">Select Cohort</button>
                            <ul class="dropdown-list" id="session-cohort-list"></ul>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="session-cohort-short-name">Cohort's Short Name</label>
                        <input type="text" id="session-cohort-short-name" class="form-control" readonly>
                    </div>
                </div>

                <div class="form-row">
                    <div class="form-group">
                        <label for="session-teacher">Teacher</label>
                        <div id="session-teacher-dropdown" class="custom-dropdown">
                            <button type="button" class="dropdown-btn" id="session-teacher-btn">Select Teacher</button>
                            <ul class="dropdown-list" id="session-teacher-list"></ul>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="session-class-name">Class Name</label>
                        <div id="session-class-dropdown" class="custom-dropdown">
                            <button type="button" class="dropdown-btn" id="session-class-btn" disabled
                                style="background-color:#f5f5f5;cursor:not-allowed;">Select Class</button>
                            <ul class="dropdown-list" id="session-class-list"></ul>
                        </div>
                    </div>
                </div>


                <div class="form-row">
                    <div class="form-group">
                        <label for="session-event-date">Event On :</label>
                        <button type="button" class="form-control date-input" id="session-event-date-btn">Select
                            Date</button>
                    </div>
                    <div class="time-group-wrapper">
                        <div class="form-group time-group">
                            <div id="session-start-dropdown" class="custom-dropdown">
                                <button type="button" class="dropdown-btn" id="session-start-btn">Select Start
                                    Time</button>
                                <ul class="dropdown-list" id="session-start-list"></ul>
                            </div>
                        </div>
                        <div class="form-group time-group">
                            <div id="session-end-dropdown" class="custom-dropdown">
                                <button type="button" class="dropdown-btn" id="session-end-btn">Select End Time</button>
                                <ul class="dropdown-list" id="session-end-list"></ul>
                            </div>
                        </div>
                    </div>
                </div>

                <button type="submit" class="submit-button">Update Session</button>
            </form>
        </div>
    </section>
</div>
<section id="menu-options" class="menu-options-section">
    <div class="menu-container">
        <button class="modal-close-btn" onclick="closeMenuOptionsDropdown()" aria-label="Close menu">
            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                stroke-linecap="round" stroke-linejoin="round">
                <line x1="18" y1="6" x2="6" y2="18"></line>
                <line x1="6" y1="6" x2="18" y2="18"></line>
            </svg>
        </button>
        <nav aria-label="Actions menu">
            <ul class="menu-list">
                <li class="menu-item">
                    <a href="#manage-cohort" class="menu-link">
                        <!--merged image-->
                        <div class="icon-wrapper">
                            <img src="./img/manage-cohort.svg" alt="" class="icon-overlay">

                        </div>
                        <span class="menu-text">Manage Cohort</span>
                    </a>
                </li>
                <li class="menu-item">
                    <a href="#manage-session" class="menu-link">
                        <!--merged image-->
                        <div class="icon-wrapper">
                            <img src="./img/manage-session-reschedule.svg" alt="" class="icon-overlay">

                        </div>
                        <span class="menu-text">Manage Session/Reschedule</span>
                    </a>
                </li>
                <li class="menu-item">
                    <a href="#cancel-reschedule" class="menu-link">
                        <img src="./img/cancel-reschedule.svg" alt="" class="menu-icon">
                        <span class="menu-text">Cancel and Reschedule Later</span>
                    </a>
                </li>
                <li class="menu-item">
                    <a href="#cancel" class="menu-link">
                        <img src="./img/cancel-no-make-up.svg" alt="" class="menu-icon">
                        <span class="menu-text text-danger">Cancel (no make-up)</span>
                    </a>
                </li>
            </ul>
        </nav>
    </div>
</section>



<style>
.menu-options-section {
    display: none;
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    z-index: 10000;
    pointer-events: none;
}

.menu-container {
    position: fixed;
    width: 315px;
    background-color: #ffffff;
    border: 1px solid #f4f4f8;
    border-radius: 8px;
    box-shadow: 0px 8px 32px 0px rgba(18, 17, 23, 0.15), 0px 16px 48px 0px rgba(18, 17, 23, 0.15);
    overflow: hidden;
    pointer-events: auto;
    animation: fadeIn 0.2s ease-out;
}

@keyframes fadeIn {
    from {
        opacity: 0;
        transform: scale(0.95);
    }

    to {
        opacity: 1;
        transform: scale(1);
    }
}

.modal-close-btn {
    position: absolute;
    top: 8px;
    right: 8px;
    background: transparent;
    border: none;
    cursor: pointer;
    padding: 4px;
    color: #121117;
    transition: color 0.2s ease;
    z-index: 1;
    display: none;
}

.modal-close-btn:hover {
    color: #dd352e;
}

.menu-list {
    list-style: none;
    margin: 0;
    padding: 0;
}

.menu-item {
    /* Items are stacked without any margin or border between them */
}

.menu-link {
    display: flex;
    align-items: center;
    gap: 12px;
    padding: 16px 12px;
    text-decoration: none;
    color: #121117;
    font-size: 16px;
    line-height: 24px;
    font-weight: 400;
    transition: background-color 0.2s ease;
}

.menu-link:hover {
    background-color: #f8f8f8;
}

.menu-icon {
    width: 24px;
    height: 24px;
    flex-shrink: 0;
}

.icon-wrapper {
    position: relative;
    width: 24px;
    height: 24px;
    flex-shrink: 0;
}

.icon-overlay {
    position: absolute;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%);
    width: 100%;
    height: 100%;
}

.menu-text {
    flex-grow: 1;
}

.text-danger {
    color: #dd352e;
}

/* Responsive styles for mobile devices */
@media (max-width: 768px) {
    .menu-container {
        width: 280px;
    }
}
</style>


<style>
.modal-overlay {
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background-color: rgba(0, 0, 0, 0.5);
    z-index: 10001;
    display: flex;
    align-items: center;
    justify-content: center;
    padding: 20px;
}

.manage-session-section {
    width: 100%;
    display: flex;
    align-items: center;
    justify-content: center;
}

.session-card {
    max-width: 500px;
    width: 100%;
    margin: 0 auto;
    background-color: #ffffff;
    border: 0.75px solid rgba(0, 0, 0, 0.12);
    border-radius: 10px;
    padding: 24px;
    box-sizing: border-box;
    display: flex;
    flex-direction: column;
    gap: 20px;
}

.session-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
}

.header-title {
    margin: 0;
    color: #000000;
    font-family: 'Poppins', sans-serif;
    font-weight: 600;
    font-size: 20px;
    line-height: 30px;
}

.close-button {
    background: none;
    border: none;
    padding: 8px;
    cursor: pointer;
    display: flex;
    align-items: center;
    justify-content: center;
    color: #121117;
    transition: color 0.2s ease;
}

.close-button:hover {
    color: #dd352e;
}

.close-button img,
.close-button svg {
    width: 24px;
    height: 24px;
}

.session-form {
    display: flex;
    flex-direction: column;
    gap: 20px;
}

.form-row {
    display: flex;
    gap: 20px;
}

.time-group-wrapper {
    display: flex;
    gap: 10px;
    flex: 1;
}

.manage-session-section .form-group {
    display: flex;
    flex-direction: column;

    align-items: start;
    flex: 1;
}

.time-group {
    justify-content: flex-end;
}

.manage-session-section label {
    color: #000000;
    font-family: 'Poppins', sans-serif;
    font-weight: 400;
    font-size: 14px;
    line-height: 21px;
}

.sr-only {
    position: absolute;
    width: 1px;
    height: 1px;
    padding: 0;
    margin: -1px;
    overflow: hidden;
    clip: rect(0, 0, 0, 0);
    white-space: nowrap;
    border-width: 0;
}

.form-control {
    box-sizing: border-box;
    border: 2px solid rgba(0, 0, 0, 0.12);
    border-radius: 10px;
    padding: 12px;
    font-family: 'Poppins', sans-serif;
    font-size: 14px;
    background-color: #ffffff;
    min-height: 52px;
}

input.form-control {
    color: #6a697c;
    line-height: 25px;
}

input#class-name {
    color: #000000;
    font-weight: 500;
    line-height: 21px;
}

.custom-select {
    display: flex;
    align-items: center;
    justify-content: space-between;
    padding-right: 16px;
    cursor: pointer;
}

.teacher-info {
    display: flex;
    align-items: center;
    gap: 8px;
}

.avatar {
    width: 32px;
    height: 32px;
    border-radius: 50%;
    object-fit: cover;
}

.teacher-name {
    color: #000000;
    font-weight: 500;
    font-size: 14px;
    line-height: 21px;
}

.dropdown-arrow {
    width: 0;
    height: 0;
    border-left: 6px solid transparent;
    border-right: 6px solid transparent;
    border-top: 6px solid #000000;
}

.date-input {
    background-color: #e6e5ff;
    border-color: #e6e5ff;
    color: #000000;
    font-weight: 400;
    font-size: 14px;
    line-height: 21px;
    display: flex;
    align-items: center;
    justify-content: center;
    text-align: center;
    cursor: pointer;
    transition: background-color 0.2s ease;
}

.date-input:hover {
    background-color: #d8d7ff;
}

.time-range-wrapper {
    display: flex;
    align-items: center;
    gap: 6px;
}

.time-input {
    padding: 9px 8px;
    text-align: center;
    color: #000000;
    font-weight: 400;
    font-size: 14px;
    line-height: 21px;
    width: 101px;
}

.time-separator {
    color: #000000;
}

.submit-button {
    background-color: #ff2500;
    border: 2px solid #121117;
    border-radius: 8px;
    padding: 11px;
    width: 100%;
    color: #ffffff;
    font-family: 'Poppins', sans-serif;
    font-weight: 600;
    font-size: 18px;
    line-height: 26px;
    text-align: center;
    cursor: pointer;
    margin-top: 4px;
}

/* Custom Dropdown Styles */
.custom-dropdown {
    position: relative;
    width: 100%;
}

.custom-dropdown .dropdown-btn {
    width: 100%;
    box-sizing: border-box;
    border: 2px solid rgba(0, 0, 0, 0.12);
    border-radius: 10px;
    padding: 10px;
    font-family: 'Poppins', sans-serif;
    font-size: 14px;
    background-color: #ffffff;
    min-height: 52px;
    text-align: left;
    cursor: pointer;
    display: flex;
    align-items: center;
    justify-content: space-between;
    color: #000000;
    font-weight: 400;
    transition: border-color 0.2s ease;
}

.custom-dropdown .dropdown-btn:hover {
    border-color: rgba(0, 0, 0, 0.24);
}

.custom-dropdown .dropdown-btn:after {
    content: '';
    width: 0;
    height: 0;
    border-left: 6px solid transparent;
    border-right: 6px solid transparent;
    border-top: 6px solid #000000;
    margin-left: 8px;
}

.custom-dropdown .dropdown-list {
    position: absolute;
    top: calc(100% + 4px);
    left: 0;
    right: 0;
    background-color: #ffffff;
    border: 2px solid rgba(0, 0, 0, 0.12);
    border-radius: 10px;
    max-height: 250px;
    overflow-y: auto;
    z-index: 1000;
    display: none;
    list-style: none;
    margin: 0;
    padding: 8px 0;
    box-shadow: 0px 8px 32px 0px rgba(18, 17, 23, 0.15);
}

.custom-dropdown .dropdown-list li {
    padding: 10px 16px;
    cursor: pointer;
    font-family: 'Poppins', sans-serif;
    font-size: 14px;
    color: #121117;
    transition: background-color 0.2s ease;
    display: flex;
    align-items: center;
    gap: 8px;
}

.custom-dropdown .dropdown-list li:hover {
    background-color: #f8f8f8;
}

/* Teacher dropdown styles with images */
#session-teacher-list li img.teacher-dropdown-avatar {
    width: 32px;
    height: 32px;
    border-radius: 50%;
    object-fit: cover;
}

/* Teacher info in button */
.custom-dropdown .dropdown-btn .teacher-info {
    display: flex;
    align-items: center;
    gap: 8px;
    width: 100%;
}

.custom-dropdown .dropdown-btn .teacher-info .avatar {
    width: 25px;
    height: 25px;
    border-radius: 50%;
    object-fit: cover;
}

.custom-dropdown .dropdown-btn .teacher-info .teacher-name {
    color: #000000;
    font-weight: 500;
    font-size: 14px;
    line-height: 21px;
}

/* Hide dropdown arrow when teacher is selected */
.custom-dropdown .dropdown-btn:has(.teacher-info):after {
    display: none;
}

/* Add arrow inside teacher-info */
.custom-dropdown .dropdown-btn .teacher-info::after {
    content: '';
    width: 0;
    height: 0;
    border-left: 6px solid transparent;
    border-right: 6px solid transparent;
    border-top: 6px solid #000000;
    margin-left: auto;
}

.custom-dropdown .dropdown-list::-webkit-scrollbar {
    width: 8px;
}

.custom-dropdown .dropdown-list::-webkit-scrollbar-track {
    background: #f1f1f1;
    border-radius: 10px;
}

.custom-dropdown .dropdown-list::-webkit-scrollbar-thumb {
    background: #c1c1c1;
    border-radius: 10px;
}

.custom-dropdown .dropdown-list::-webkit-scrollbar-thumb:hover {
    background: #a8a8a8;
}

/* Calendar Modal Styles for Manage Session */
.session_cal_modal_backdrop {
    display: none;
    position: fixed;
    z-index: 10002;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background: rgba(0, 0, 0, 0.14);
}

.session_cal_modal {
    background: #fff;
    border-radius: 15px;
    box-shadow: 0 10px 36px 0 rgba(0, 0, 0, .16);
    max-width: 300px;
    padding: 26px 24px 24px 24px;
    position: absolute;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%);
    font-family: inherit;
}

.session_cal_header {
    display: flex;
    align-items: center;
    justify-content: space-between;
    margin-bottom: 16px;
}

.session_cal_month_label {
    font-size: 1.18rem;
    font-weight: 600;
}

.session_cal_grid {
    display: grid;
    grid-template-columns: repeat(7, 36px);
    grid-gap: 6px;
    justify-content: center;
}

.session_cal_day,
.session_cal_date {
    width: 36px;
    height: 36px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1.01rem;
    border-radius: 50%;
    cursor: pointer;
    transition: background 0.13s;
}

.session_cal_day {
    font-weight: bold;
    color: #888;
    cursor: default;
}

.session_cal_date.selected,
.session_cal_date:hover {
    background: #fe2e0c;
    color: #fff;
}

.session_cal_date.inactive {
    color: #c2c2c2;
    background: #fff;
    pointer-events: none;
    cursor: default;
}

.session_cal_done_btn {
    width: 100%;
    background: #fe2e0c;
    color: #fff;
    border: none;
    border-radius: 8px;
    font-size: 1.1rem;
    font-weight: 600;
    padding: 12px 0;
    margin-top: 19px;
    cursor: pointer;
    transition: background 0.13s;
}

.session_cal_done_btn:active {
    background: #e52b10;
}

@media (max-width: 600px) {
    .session-card {
        padding: 16px;
    }

    .form-row {
        flex-direction: column;
        gap: 20px;
    }

    .time-group {
        justify-content: flex-start;
    }
}
</style>

<!-- Time Off Modal (Teacher Busy Time) -->
<div id="timeoff-modal" class="modal-overlay" style="display:none;">
    <div class="popup"
        style="width:520px; background:#fff; border-radius:12px; padding:20px 24px; box-shadow:0 4px 12px rgba(0,0,0,0.1);">
        <div class="header"
            style="display:flex; justify-content:space-between; align-items:center; font-size:18px; font-weight:600; margin-bottom:12px;">
            <span style="color:#ff3b2f; border-bottom:3px solid #ff3b2f; padding-bottom:4px;">Time off</span>
            <button id="close-timeoff" class="close"
                style="font-size:20px; cursor:pointer; background:none; border:none;">✕</button>
        </div>

        <div class="row" style="display:flex; align-items:center; gap:12px; margin:18px 0;">
            <div class="dot" style="width:18px; height:18px; border-radius:50%; border:3px solid #dab100;"></div>
            <div class="label" style="font-size:16px; font-weight:500;">Busy Time</div>
        </div>

        <div class="date-row" style="display:flex;  margin-top:10px; gap:20px;">
            <div>
                <div class="date-info" style="display:flex; align-items:center; gap:10px;">
                    <div class="clock-icon" style="width:18px; height:18px; ">
                        <img src="./img/busy-clock.svg" alt="">
                    </div>
                    <div id="timeoff-date-line" class="date-text" style="font-size:16px; font-weight:600;">September 26
                    </div>
                </div>
                <div id="timeoff-day-line" class="sub-text" style="font-size:16px; color:gray; margin-top:4px;">
                    Thursday</div>
            </div>
            <div>
                <img src="./img/line.svg" alt="">
            </div>

            <div>
                <div id="timeoff-time-range" class="times"
                    style="font-size:16px; font-weight:600; display:flex; gap:6px; align-items:center;">06:00 → 07:00
                </div>
                <div id="timeoff-duration" class="duration"
                    style="font-size:16px; color:gray; margin-top:4px; text-align:right;">1 hour</div>
            </div>
        </div>

        <button id="timeoff-cancel-btn" class="btn"
            style="width:100%; padding:12px 0; background:none; border:2px solid #ff3b2f; color:#ff3b2f; border-radius:8px; font-size:16px; margin-top:22px; cursor:pointer;">Cancel
            time off</button>
    </div>
</div>

</div>

<!-- ========= CALENDAR MODAL FOR MANAGE SESSION ========= -->
<div class="session_cal_modal_backdrop" id="session_cal_modal_backdrop">
    <div class="session_cal_modal">
        <div class="session_cal_header">
            <button id="session_cal_prev"
                style="background:none;border:none;font-size:1.4rem;cursor:pointer;">&#8592;</button>
            <span class="session_cal_month_label" id="session_cal_month"></span>
            <button id="session_cal_next"
                style="background:none;border:none;font-size:1.4rem;cursor:pointer;">&#8594;</button>
        </div>
        <div class="session_cal_grid" id="session_cal_days"></div>
        <div class="session_cal_grid" id="session_cal_dates"></div>
        <button class="session_cal_done_btn" id="session_cal_done">Done</button>
    </div>
</div>

<script>
// Loader and toast helpers
function showGlobalLoader() {
    if (window.$) {
        window.$('#loader').css('display', 'flex');
    } else {
        var el = document.getElementById('loader');
        if (el) el.style.display = 'flex';
    }
    window.__loaderShownAt = Date.now();
}

function hideGlobalLoader() {
    var elapsed = window.__loaderShownAt ? Date.now() - window.__loaderShownAt : 3000;

    function doHide() {
        if (window.$) {
            window.$('#loader').css('display', 'none');
        } else {
            var el = document.getElementById('loader');
            if (el) el.style.display = 'none';
        }
        window.__loaderShownAt = 0;
    }
    if (elapsed >= 3000) {
        doHide();
    } else {
        setTimeout(doHide, 3000 - elapsed);
    }
}

$(document).ready(function() {
    // Calendar variables for manage session modal
    let sessionCalSelectedDate = new Date();
    let sessionCalViewMonth = sessionCalSelectedDate.getMonth();
    let sessionCalViewYear = sessionCalSelectedDate.getFullYear();

    // Open calendar on date button click
    $(document).on('click', '#session-event-date-btn', function(e) {
        e.stopPropagation();

        // Get current date or use today
        const rawDate = $(this).data('raw-date');
        if (rawDate) {
            const parts = rawDate.split('-');
            if (parts.length === 3) {
                sessionCalSelectedDate = new Date(
                    parseInt(parts[0]),
                    parseInt(parts[1]) - 1,
                    parseInt(parts[2])
                );
            }
        } else {
            sessionCalSelectedDate = new Date();
        }

        sessionCalViewMonth = sessionCalSelectedDate.getMonth();
        sessionCalViewYear = sessionCalSelectedDate.getFullYear();

        renderSessionCalendar();
        $('#session_cal_modal_backdrop').fadeIn(90);
    });

    // Calendar navigation
    $('#session_cal_prev').on('click', function() {
        if (sessionCalViewMonth === 0) {
            sessionCalViewMonth = 11;
            sessionCalViewYear--;
        } else {
            sessionCalViewMonth--;
        }
        renderSessionCalendar();
    });

    $('#session_cal_next').on('click', function() {
        if (sessionCalViewMonth === 11) {
            sessionCalViewMonth = 0;
            sessionCalViewYear++;
        } else {
            sessionCalViewMonth++;
        }
        renderSessionCalendar();
    });

    // Render calendar
    function renderSessionCalendar() {
        const monthNames = ["January", "February", "March", "April", "May", "June", "July", "August",
            "September", "October", "November", "December"
        ];
        $('#session_cal_month').text(monthNames[sessionCalViewMonth] + " " + sessionCalViewYear);

        const days = ["Mo", "Tu", "We", "Th", "Fr", "Sa", "Su"];
        const $daysContainer = $('#session_cal_days').empty();
        days.forEach(d => {
            $daysContainer.append('<div class="session_cal_day">' + d + '</div>');
        });

        const firstDay = new Date(sessionCalViewYear, sessionCalViewMonth, 1);
        let startDayOfWeek = firstDay.getDay();
        if (startDayOfWeek === 0) startDayOfWeek = 7;
        startDayOfWeek--;

        const lastDay = new Date(sessionCalViewYear, sessionCalViewMonth + 1, 0);
        const daysInMonth = lastDay.getDate();

        const prevLastDay = new Date(sessionCalViewYear, sessionCalViewMonth, 0);
        const prevDays = prevLastDay.getDate();

        const $datesContainer = $('#session_cal_dates').empty();

        // Previous month dates
        for (let i = startDayOfWeek - 1; i >= 0; i--) {
            const $date = $('<div class="session_cal_date inactive">' + (prevDays - i) + '</div>');
            $datesContainer.append($date);
        }

        // Current month dates
        for (let d = 1; d <= daysInMonth; d++) {
            const dateObj = new Date(sessionCalViewYear, sessionCalViewMonth, d);
            const isSelected = (
                dateObj.getDate() === sessionCalSelectedDate.getDate() &&
                dateObj.getMonth() === sessionCalSelectedDate.getMonth() &&
                dateObj.getFullYear() === sessionCalSelectedDate.getFullYear()
            );

            const $date = $('<div class="session_cal_date">' + d + '</div>');
            if (isSelected) $date.addClass('selected');

            $date.on('click', function() {
                sessionCalSelectedDate = new Date(sessionCalViewYear, sessionCalViewMonth, d);
                renderSessionCalendar();
            });

            $datesContainer.append($date);
        }

        // Next month dates
        const totalCells = startDayOfWeek + daysInMonth;
        const remainingCells = totalCells % 7 === 0 ? 0 : 7 - (totalCells % 7);
        for (let i = 1; i <= remainingCells; i++) {
            const $date = $('<div class="session_cal_date inactive">' + i + '</div>');
            $datesContainer.append($date);
        }
    }

    // Done button - update date and close
    $('#session_cal_done').on('click', function() {
        const $dateBtn = $('#session-event-date-btn');
        const year = sessionCalSelectedDate.getFullYear();
        const month = sessionCalSelectedDate.getMonth();
        const day = sessionCalSelectedDate.getDate();
        const monthNames = ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov',
            'Dec'
        ];

        const formattedDate = monthNames[month] + ' ' + day + ', ' + year;
        const rawDate = year + '-' + String(month + 1).padStart(2, '0') + '-' + String(day).padStart(2,
            '0');

        $dateBtn.text(formattedDate);
        $dateBtn.data('raw-date', rawDate);

        $('#session_cal_modal_backdrop').fadeOut(80);
    });

    // Close on backdrop click
    $('#session_cal_modal_backdrop').on('click', function(e) {
        if (e.target === this) {
            $('#session_cal_modal_backdrop').fadeOut(80);
        }
    });
});
</script>


<!-- Cancel & Reschedule Modal (new unique classes, same structure & design) -->

<style>
/* ========== CANCEL & RESCHEDULE MODAL (prefixed: cr-) ========== */

.cr-modal-section {
    width: 100%;
    display: flex;
    justify-content: center;
}

.cr-modal-container {
    background-color: #ffffff;
    border: 1px solid #f4f4f8;
    border-radius: 8px;
    box-shadow: 0px 8px 32px rgba(18, 17, 23, 0.15), 0px 16px 48px rgba(18, 17, 23, 0.15);
    display: flex;
    flex-direction: column;
    align-items: center;
    padding: 8px 8px 40px;
    width: 100%;
    max-width: 540px;
}

.cr-modal-header {
    width: 100%;
    display: flex;
    justify-content: flex-end;
    margin-bottom: 8px;
    border: none;
}

.cr-close-btn {
    background-color: transparent;
    border: none;
    padding: 8px;
    cursor: pointer;
    display: flex;
    align-items: center;
    justify-content: center;
    border-radius: 8px;
}

.cr-close-btn svg {
    width: 24px;
    height: 24px;
    color: #121117;
    transition: color 0.2s ease;
}

.cr-close-btn:hover svg {
    color: #dd352e;
}

.cr-content-wrapper {
    display: flex;
    flex-direction: column;
    gap: 23px;
    width: 100%;
    max-width: 456px;
}

.cr-title-group {
    display: flex;
    flex-direction: column;
    gap: 4px;
    text-align: left;
}

.cr-title {
    color: #121117;
    font-family: 'Poppins', sans-serif;
    font-weight: 600;
    font-size: 28px;
    line-height: 1.5;
    margin: 0;
}

.cr-subtitle {
    color: #4d4c5c;
    font-family: 'Poppins', sans-serif;
    font-weight: 400;
    font-size: 16px;
    line-height: 1.5;
    margin: 0;
}

.cr-form {
    display: flex;
    flex-direction: column;
    gap: 23px;
}

.cr-form-group {
    display: flex;
    flex-direction: column;
    gap: 8px;
}

.cr-label {
    color: #121117;
    font-family: 'Poppins', sans-serif;
    font-weight: 400;
    font-size: 14.8px;
    line-height: 1.7;
    text-align: left;
}

.cr-select-wrapper {
    background-color: #ffffff;
    border: 2px solid rgba(0, 0, 0, 0.12);
    border-radius: 8.9px;
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 19px 12px;
    height: 60px;
    cursor: pointer;
}

.cr-select-placeholder {
    color: #232323;
    font-family: 'Poppins', sans-serif;
    font-weight: 400;
    font-size: 14.8px;
    line-height: 1.7;
}

.cr-dropdown-arrow {
    width: 18px;
    height: 10px;
    transition: transform 0.3s ease;
    color: #121117;
}

.cr-textarea {
    background-color: #ffffff;
    border: 2px solid rgba(0, 0, 0, 0.12);
    color: #232323;
    border-radius: 8.9px;
    padding: 12px;
    height: 92px;
    font-family: 'Poppins', sans-serif;
    font-size: 14.8px;
    line-height: 1.7;
    resize: vertical;
}

.cr-textarea::placeholder {
    color: #6a697c;
}

.cr-footer {
    display: flex;
    flex-direction: row;
    gap: 18px;
    width: 100%;
}

.cr-btn {
    font-family: 'Poppins', sans-serif;
    font-weight: 600;
    font-size: 16px;
    line-height: 1.6;
    letter-spacing: 0.09px;
    border-radius: 8px;
    border: 2px solid #121117;
    padding: 11px 24px;
    cursor: pointer;
    text-align: center;
}

.cr-btn-secondary {
    background-color: transparent;
    color: #121117;
    width: 134px;
}

.cr-btn-primary {
    background-color: #ff2500;
    color: #ffffff;
    flex-grow: 1;
}

.cr-select-wrapper {
    position: relative;
}

.cr-dropdown-options {
    position: absolute;
    top: 100%;
    left: 0;
    right: 0;
    background: #fff;
    border: 1px solid #e0e0e0;
    border-radius: 8px;
    margin-top: 4px;
    padding: 8px 0;
    list-style: none;
    z-index: 1000;
    max-height: 250px;
    overflow-y: auto;
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
}

.cr-dropdown-options li {
    padding: 12px 16px;
    cursor: pointer;
    transition: background 0.2s;
    font-size: 0.95rem;
}

.cr-dropdown-options li:hover {
    background: #f5f5f5;
}

.cr-select-wrapper.active .cr-dropdown-arrow {
    transform: rotate(180deg);
}

@media (max-width: 600px) {
    .cr-modal-container {
        padding: 8px 8px 24px;
    }

    .cr-content-wrapper {
        padding: 0 16px;
    }

    .cr-footer {
        flex-direction: column;
        gap: 12px;
    }

    .cr-btn {
        width: 100% !important;
    }
}
</style>

<section id="cancel-reschedule-modal" class="cr-modal-section modal-overlay" style="display: none;">
    <div class="cr-modal-container">
        <div class="cr-modal-header">
            <button class="cr-close-btn" id="close-cancel-reschedule" aria-label="Close modal">
                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                    stroke-linecap="round" stroke-linejoin="round">
                    <line x1="18" y1="6" x2="6" y2="18"></line>
                    <line x1="6" y1="6" x2="18" y2="18"></line>
                </svg>
            </button>
        </div>

        <div class="cr-content-wrapper">
            <div class="cr-title-group">
                <h2 class="cr-title">Cancel and Reschedule Later</h2>
                <p class="cr-subtitle">Monday, September 2, 7:00-8:00 AM</p>
            </div>

            <form class="cr-form">
                <div class="cr-form-group">
                    <label for="cr-reason" class="cr-label">Please choose a reason</label>
                    <div class="cr-select-wrapper" id="cr-reason" role="button" tabindex="0">
                        <span class="cr-select-placeholder">Select Reason</span>
                        <img src="./img/dropdown-arrow-down.svg" alt="Dropdown arrow" class="cr-dropdown-arrow">
                        <ul class="cr-dropdown-options" style="display: none;">
                            <li data-value="timing-teacher">The timing isn't working out for teacher.</li>
                            <li data-value="timing-student">The timing isn't working out for student.</li>
                            <li data-value="tech-issues">There are some tech issues, so we can't run the class.</li>
                            <li data-value="teacher-unavailable">The teacher isn't available right now.</li>
                            <li data-value="unable-today">He's not able to make it today.</li>
                        </ul>
                    </div>
                </div>



                <div class="cr-form-group">
                    <label for="cr-notes" class="cr-label">Add specific notes</label>
                    <textarea id="cr-notes" class="cr-textarea" placeholder="Add specific notes"></textarea>
                </div>
            </form>

            <footer class="cr-footer">
                <button class="cr-btn cr-btn-secondary">Cancel</button>
                <button class="cr-btn cr-btn-primary">Cancel and Reschedule Later</button>
            </footer>
        </div>
    </div>
</section>
<style>
/* Updated CSS with `cancel-` prefix added to all classes */

.cancel-cancel-modal-section {
    width: 100%;
    display: flex;
    justify-content: center;
}

.cancel-modal-container {
    background-color: #ffffff;
    border: 1px solid #f4f4f8;
    border-radius: 8px;
    box-shadow: 0px 8px 32px 0px rgba(18, 17, 23, 0.15), 0px 16px 48px 0px rgba(18, 17, 23, 0.15);
    display: flex;
    flex-direction: column;
    align-items: center;
    padding: 8px 8px 40px;
    width: 100%;
    max-width: 540px;
}

.cancel-cancel-modal-section .cancel-modal-header {
    width: 100%;
    display: flex;
    justify-content: flex-end;
    margin-bottom: 8px;
    border: none;
}

.cancel-close-button {
    background-color: transparent;
    border: none;
    padding: 8px;
    cursor: pointer;
    display: flex;
    align-items: center;
    justify-content: center;
    border-radius: 8px;
}

.cancel-close-button svg {
    width: 24px;
    height: 24px;
    color: #121117;
    transition: color 0.2s ease;
}

.cancel-close-button:hover svg {
    color: #dd352e;
}

.cancel-modal-content-wrapper {
    display: flex;
    flex-direction: column;
    gap: 23px;
    width: 100%;
    max-width: 456px;
}

.cancel-title-group {
    display: flex;
    flex-direction: column;
    gap: 4px;
    text-align: left;
}

.cancel-modal-title {
    color: #121117;
    font-family: 'Poppins', sans-serif;
    font-weight: 600;
    font-size: 28px;
    line-height: 1.5;
    margin: 0;
}

.cancel-modal-subtitle {
    color: #4d4c5c;
    font-family: 'Poppins', sans-serif;
    font-weight: 400;
    font-size: 16px;
    line-height: 1.5;
    margin: 0;
}

.cancel-cancel-form {
    display: flex;
    flex-direction: column;
    gap: 23px;
}

.cancel-form-group {
    display: flex;
    flex-direction: column;
    gap: 8px;
}

.cancel-form-label {
    color: #121117;
    font-family: 'Poppins', sans-serif;
    font-weight: 400;
    font-size: 14.8px;
    line-height: 1.7;
    text-align: left;
}

.cancel-custom-select-wrapper {
    background-color: #ffffff;
    border: 2px solid rgba(0, 0, 0, 0.12);
    border-radius: 8.9px;
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 19px 12px;
    height: 60px;
    cursor: pointer;
}

.cancel-placeholder-text {
    color: #6a697c;
    font-family: 'Poppins', sans-serif;
    font-weight: 400;
    font-size: 14.8px;
    line-height: 1.7;
}

.cancel-dropdown-arrow {
    width: 18px;
    height: 10px;
    transition: transform 0.3s ease;
    color: #121117;
}

.cancel-notes-textarea {
    background-color: #ffffff;
    border: 2px solid rgba(0, 0, 0, 0.12);
    border-radius: 8.9px;
    color: #232323;
    padding: 12px;
    height: 92px;
    font-family: 'Poppins', sans-serif;
    font-size: 14.8px;
    line-height: 1.7;
    resize: vertical;
}

.cancel-notes-textarea::placeholder {
    color: #6a697c;
}

.cancel-modal-footer {
    display: flex;
    flex-direction: row;
    gap: 18px;
    width: 100%;
}

.cancel-btn {
    font-family: 'Poppins', sans-serif;
    font-weight: 600;
    font-size: 16px;
    line-height: 1.6;
    letter-spacing: 0.09px;
    border-radius: 8px;
    border: 2px solid #121117;
    padding: 11px 24px;
    cursor: pointer;
    text-align: center;
}

.cancel-btn-secondary {
    background-color: transparent;
    color: #121117;
    width: 134px;
}

.cancel-btn-primary {
    background-color: #ff2500;
    color: #ffffff;
    flex-grow: 1;
}

.cancel-custom-select-wrapper {
    position: relative;
}

.cancel-dropdown-options {
    position: absolute;
    top: 100%;
    left: 0;
    right: 0;
    background: #fff;
    border: 1px solid #e0e0e0;
    border-radius: 8px;
    margin-top: 4px;
    padding: 8px 0;
    list-style: none;
    z-index: 1000;
    max-height: 250px;
    overflow-y: auto;
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
}

.cancel-dropdown-options li {
    padding: 12px 16px;
    cursor: pointer;
    transition: background 0.2s;
    font-size: 0.95rem;
}

.cancel-dropdown-options li:hover {
    background: #f5f5f5;
}

.cancel-custom-select-wrapper.active .cancel-dropdown-arrow {
    transform: rotate(180deg);
}

@media (max-width: 600px) {
    .cancel-modal-container {
        padding: 8px 8px 24px;
    }

    .cancel-modal-content-wrapper {
        padding: 0 16px;
    }

    .cancel-modal-footer {
        flex-direction: column;
        gap: 12px;
    }

    .cancel-btn {
        width: 100% !important;
    }
}
</style>

<!-- Updated HTML with prefixed classes -->
<section id="cancel-nomakeup-modal" class="cancel-cancel-modal-section modal-overlay" style="display: none;">
    <div class="cancel-modal-container">
        <div class="cancel-modal-header">
            <button class="cancel-close-button" id="close-cancel-nomakeup" aria-label="Close modal">
                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                    stroke-linecap="round" stroke-linejoin="round">
                    <line x1="18" y1="6" x2="6" y2="18"></line>
                    <line x1="6" y1="6" x2="18" y2="18"></line>
                </svg>
            </button>
        </div>
        <div class="cancel-modal-content-wrapper">
            <div class="cancel-title-group">
                <h2 class="cancel-modal-title">Cancel (No Make-Up)</h2>
                <p class="cancel-modal-subtitle">Monday, September 2, 7:00-8:00 Am</p>
            </div>
            <form class="cancel-cancel-form">
                <div class="cancel-form-group">
                    <label for="cancel-reason" class="cancel-form-label">Please choose a reason for cancel
                        lesson</label>
                    <div class="cancel-custom-select-wrapper" id="cancel-reason" role="button" tabindex="0">
                        <span class="cancel-placeholder-text">Select Reason</span>
                        <img src="./img/dropdown-arrow-down.svg" alt="Dropdown arrow" class="cancel-dropdown-arrow">
                        <ul class="cancel-dropdown-options" style="display: none;">
                            <li data-value="timing-teacher">The timing isn't working out for teacher.</li>
                            <li data-value="timing-student">The timing isn't working out for student.</li>
                            <li data-value="tech-issues">There are some tech issues, so we can't run the class.</li>
                            <li data-value="teacher-unavailable">The teacher isn't available right now.</li>
                            <li data-value="unable-today">He's not able to make it today.</li>
                        </ul>
                    </div>
                </div>
                <div class="cancel-form-group">
                    <label for="specific-notes" class="cancel-form-label">Add specific notes</label>
                    <textarea id="specific-notes" class="cancel-notes-textarea"
                        placeholder="Add specific notes"></textarea>
                </div>
            </form>
            <footer class="cancel-modal-footer">
                <button class="cancel-btn cancel-btn-secondary">Cancel</button>
                <button class="cancel-btn cancel-btn-primary">Cancel (no make-up)</button>
            </footer>
        </div>
    </div>
</section>

<!-- Confirmation Modal for Cancel (No Make-Up) -->
<section id="cancel-confirmation-modal" class="cancel-confirmation-modal-section modal-overlay" style="display: none;">
    <div class="cancel-confirmation-container">
        <div class="cancel-confirmation-content">
            <h2 class="cancel-confirmation-title">Are You Sure You Want To Cancel This Session?</h2>
            <p class="cancel-confirmation-subtitle"></p>
            <div class="cancel-confirmation-warning">

                <p>This session will be permanently canceled, and the student will not receive a make-up session.</p>
            </div>
            <div class="cancel-confirmation-buttons">
                <button class="cancel-confirmation-btn cancel-confirmation-btn-cancel">Cancel</button>
                <button class="cancel-confirmation-btn cancel-confirmation-btn-confirm">Confirm</button>
            </div>
        </div>
    </div>
</section>

<!-- Reason of Cancellation Modal (Read-only) -->
<section id="reason-of-cancellation-modal" class="reason-cancellation-modal-section modal-overlay"
    style="display: none;">
    <div class="reason-cancellation-container">
        <button class="reason-cancellation-close-btn" id="close-reason-cancellation" aria-label="Close modal">
            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                stroke-linecap="round" stroke-linejoin="round">
                <line x1="18" y1="6" x2="6" y2="18"></line>
                <line x1="6" y1="6" x2="18" y2="18"></line>
            </svg>
        </button>
        <div class="reason-cancellation-content">
            <h2 class="reason-cancellation-title">Reason Of Cancellation</h2>
            <p class="reason-cancellation-subtitle">Monday, September 2, 7:00-8:00 Am</p>
            <div class="reason-cancellation-text" id="cancellation-reason-text">
                Daniella was unable to attend the online class due to unforeseen personal reasons. Over the past few
                days, I encountered some challenges that required my immediate attention
            </div>
            <button class="reason-cancellation-ok-btn" id="reason-cancellation-ok">Ok</button>
        </div>
    </div>
</section>

<style>
.reason-cancellation-modal-section {
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background-color: rgba(0, 0, 0, 0.5);
    display: flex;
    align-items: center;
    justify-content: center;
    z-index: 10003;
}

.reason-cancellation-container {
    background: white;
    border-radius: 8px;
    max-width: 520px;
    width: 90%;
    padding: 32px;
    box-shadow: 0 4px 24px rgba(0, 0, 0, 0.15);
    position: relative;
}

.reason-cancellation-close-btn {
    position: absolute;
    top: 16px;
    right: 16px;
    background: none;
    border: none;
    cursor: pointer;
    padding: 4px;
    display: flex;
    align-items: center;
    justify-content: center;
    color: #6B7280;
    transition: color 0.2s;
}

.reason-cancellation-close-btn:hover {
    color: #1F2937;
}

.reason-cancellation-title {
    font-size: 28px;
    font-weight: 600;
    color: #232323;
    margin: 0 0 8px 0;
    line-height: 1.3;
}

.reason-cancellation-subtitle {
    font-size: 16px;
    font-weight: 400;
    color: #4D4C5C;
    margin: 0 0 24px 0;
}

.reason-cancellation-text {
    font-size: 15px;
    font-weight: 400;
    color: #232323;
    line-height: 1.6;
    margin: 0 0 32px 0;
    text-align: left;
}

.reason-cancellation-ok-btn {
    width: 100%;
    padding: 12px 24px;
    background-color: #ff2500;
    color: white;
    border: none;
    border-radius: 8px;
    font-size: 16px;
    font-weight: 500;
    cursor: pointer;
    transition: all 0.2s;
}

.reason-cancellation-ok-btn:hover {
    background-color: #e02000;
}

.cancel-confirmation-modal-section {
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background-color: rgba(0, 0, 0, 0.5);
    display: flex;
    align-items: center;
    justify-content: center;
    z-index: 10002;
}

.cancel-confirmation-container {
    background: white;
    border-radius: 12px;
    max-width: 480px;
    width: 90%;
    padding: 32px;
    box-shadow: 0 4px 24px rgba(0, 0, 0, 0.15);
}



.cancel-confirmation-title {
    font-size: 22px;
    font-weight: 600;
    color: #1F2937;
    margin: 0 0 12px 0;
    line-height: 1.3;
}

.cancel-confirmation-subtitle {
    font-size: 16px;
    font-weight: 500;
    color: #6B7280;
    margin: 0 0 24px 0;
}

.cancel-confirmation-warning {
    display: flex;
    align-items: flex-start;
    gap: 12px;

    border-radius: 8px;

    margin-bottom: 24px;
    text-align: left;
}

.cancel-confirmation-warning svg {
    flex-shrink: 0;
    margin-top: 2px;
}

.cancel-confirmation-warning p {
    margin: 0;
    font-size: 16px;
    color: #232323;
    font-weight: 500;
    line-height: 1.5;
}

.cancel-confirmation-buttons {
    display: flex;
    gap: 12px;
    justify-content: center;
}

.cancel-confirmation-btn {
    flex: 1;

    padding: 12px 24px;
    border-radius: 8px;
    font-size: 15px;
    font-weight: 500;
    cursor: pointer;
    transition: all 0.2s;
    border: none;
}

.cancel-confirmation-btn-cancel {
    background-color: #F3F4F6;
    color: #374151;
    border: 1px solid #232323;
}

.cancel-confirmation-btn-cancel:hover {
    background-color: #E5E7EB;
}

.cancel-confirmation-btn-confirm {
    background-color: #ff2500;
    color: white;
    border: 1px solid #232323;
}

.cancel-confirmation-btn-confirm:hover {
    background-color: #ff2500;
}
</style>

<script>
$(document).ready(function() {
    // Cancel & Reschedule modal dropdown
    $('#cr-reason').on('click', function(e) {
        e.stopPropagation();
        $(this).toggleClass('active');
        $(this).find('.cr-dropdown-options').toggle();
    });

    $('.cr-dropdown-options li').on('click', function(e) {
        e.stopPropagation();
        const selectedText = $(this).text();
        const selectedValue = $(this).data('value');

        $('#cr-reason .cr-select-placeholder').text(selectedText);
        $('#cr-reason').removeClass('active').data('selected-value', selectedValue);
        $('#cr-reason').css('border', ''); // Remove error border on selection
        $('.cr-dropdown-options').hide();
    });

    // Cancel (No Make-Up) modal dropdown
    $('#cancel-reason').on('click', function(e) {
        e.stopPropagation();
        $(this).toggleClass('active');
        $(this).find('.cancel-dropdown-options').toggle();
    });

    $('.cancel-dropdown-options li').on('click', function(e) {
        e.stopPropagation();
        const selectedText = $(this).text();
        const selectedValue = $(this).data('value');

        $('#cancel-reason .cancel-placeholder-text').text(selectedText);
        $('#cancel-reason').removeClass('active').data('selected-value', selectedValue);
        $('#cancel-reason').css('border', ''); // Remove error border on selection
        $('.cancel-dropdown-options').hide();
    });

    // Remove error borders when manage session dropdowns are clicked
    $('#session-cohort-btn, #session-teacher-btn, #session-class-btn, #session-event-date-btn, #session-start-btn, #session-end-btn')
        .on('click', function() {
            $(this).css('border', '');
        });

    // Close dropdowns when clicking outside
    $(document).on('click', function(e) {
        if (!$(e.target).closest('#cr-reason, #cancel-reason').length) {
            $('#cr-reason, #cancel-reason').removeClass('active');
            $('.cr-dropdown-options, .cancel-dropdown-options').hide();
        }
    });


    // Cancel & Reschedule modal - Cancel button closes modal
    $('.cr-btn-secondary').on('click', function(e) {
        e.preventDefault();
        $('#cancel-reschedule-modal').fadeOut(300);
    });

    // Cancel & Reschedule modal - Submit button with validation
    $('.cr-btn-primary').on('click', function(e) {
        e.preventDefault();

        // Remove error border first
        $('#cr-reason').css('border', '');

        // Get form values
        const reasonValue = $('#cr-reason').data('selected-value');
        const reasonText = $('#cr-reason .cr-select-placeholder').text().trim();
        const notes = $('#cr-notes').val().trim();

        // Validation
        if (!reasonValue || reasonText === 'Select Reason') {
            $('#cr-reason').css('border', '2px solid #DC2626');
            return;
        }

        // Get event data (assuming it's stored when modal opens)
        const eventData = $('#cancel-reschedule-modal').data('eventData');

        // Build payload matching your format
        const payload = {
            status: 'cancel_reschedule_later',
            eventid: eventData ? eventData.eventid : undefined,
            googlemeetid: eventData ? eventData.googlemeetid : undefined,
            reason: reasonValue,
            reasonText: reasonText,
            notes: notes
        };

        console.log('Cancel and Reschedule Later Payload:', payload);


        // Show loader
        if (typeof showGlobalLoader === 'function') {
            showGlobalLoader();
        } else {
            $("body").append(
                '<div id="custom-global-loader" style="position:fixed;top:0;left:0;width:100vw;height:100vh;z-index:99999;background:rgba(255,255,255,0.7);display:flex;align-items:center;justify-content:center;"><div style="padding:20px;background:#fff;border-radius:8px;box-shadow:0 2px 8px #0002;">Loading...</div></div>'
            );
        }

        $.ajax({
            url: M.cfg.wwwroot + "/local/customplugin/ajax/cancel_reschedule_later.php",
            type: "POST",
            data: JSON.stringify(payload),
            contentType: "application/json",
            success: function(response) {
                console.log("Cancel Later Response:", response);
                // Hide loader
                if (typeof hideGlobalLoader === 'function') {
                    hideGlobalLoader();
                } else {
                    $('#custom-global-loader').remove();
                }
                // Show toast
                if (typeof showToast === 'function') {
                    showToast('Session marked as Cancel (Reschedule Later)', 'success');
                } else {
                    $("body").append(
                        '<div id="custom-toast" style="position:fixed;bottom:30px;left:50%;transform:translateX(-50%);background:#323232;color:#fff;padding:16px 32px;border-radius:8px;z-index:99999;">Session marked as Cancel (Reschedule Later)</div>'
                    );
                    setTimeout(function() {
                        $('#custom-toast').fadeOut(400, function() {
                            $(this).remove();
                        });
                    }, 2200);
                }
                // Reset form
                $('#cr-reason').data('selected-value', null);
                $('#cr-reason .cr-select-placeholder').text('Select Reason');
                $('#cr-notes').val('');

                // Refresh calendar
                if (window.refetchCustomPluginData) {
                    window.refetchCustomPluginData('cancel-reschedule-later');
                } else if (window.fetchCalendarEvents) {
                    window.fetchCalendarEvents();
                }

                // Close modal
                $("#manage-session-modal").fadeOut(300);
                $('#cancel-reschedule-modal').fadeOut(300);
            },
            error: function(xhr) {
                // Hide loader
                if (typeof hideGlobalLoader === 'function') {
                    hideGlobalLoader();
                } else {
                    $('#custom-global-loader').remove();
                }
                // Show toast
                if (typeof showToast === 'function') {
                    showToast('Something went wrong while updating the session.', 'error');
                } else {
                    $("body").append(
                        '<div id="custom-toast" style="position:fixed;bottom:30px;left:50%;transform:translateX(-50%);background:#d32f2f;color:#fff;padding:16px 32px;border-radius:8px;z-index:99999;">Something went wrong while updating the session.</div>'
                    );
                    setTimeout(function() {
                        $('#custom-toast').fadeOut(400, function() {
                            $(this).remove();
                        });
                    }, 2200);
                }
            },
        });

        // TODO: Add AJAX call here
        /*
        $.ajax({
            url: 'your-api-endpoint',
            method: 'POST',
            data: JSON.stringify(payload),
            contentType: 'application/json',
            success: function(response) {
                console.log('Session cancelled successfully:', response);
                $('#cancel-reschedule-modal').fadeOut(300);
                // Optionally refresh the calendar or show success message
            },
            error: function(xhr, status, error) {
                console.error('Error cancelling session:', error);
                // Show error message to user
            }
        });
        */

        // Close modal after successful submission
        // (Handled above)
    });

    // Cancel (No Make-Up) modal - Cancel button closes modal
    $('.cancel-btn-secondary').on('click', function(e) {
        e.preventDefault();
        $('#cancel-nomakeup-modal').fadeOut(300);
    });

    // Cancel (No Make-Up) modal - Submit button with validation opens confirmation modal
    $('.cancel-btn-primary').on('click', function(e) {
        e.preventDefault();

        // Remove error border first
        $('#cancel-reason').css('border', '');

        // Get form values
        const reasonValue = $('#cancel-reason').data('selected-value');
        const reasonText = $('#cancel-reason .cancel-placeholder-text').text().trim();
        const notes = $('#specific-notes').val().trim();

        // Validation
        if (!reasonValue || reasonText === 'Select Reason') {
            $('#cancel-reason').css('border', '2px solid #DC2626');
            return;
        }

        // Get event data
        const eventData = $('#cancel-nomakeup-modal').data('eventData');
        const subtitle = $('#cancel-nomakeup-modal .cancel-modal-subtitle').text();
        $('#cancel-confirmation-modal .cancel-confirmation-subtitle').text(subtitle);

        // Store form data for later use
        $('#cancel-confirmation-modal').data('cancel-data', {
            status: 'cancel_no_makeup',
            eventid: eventData ? eventData.eventid : undefined,
            googlemeetid: eventData ? eventData.googlemeetid : undefined,
            reason: reasonValue,
            reasonText: reasonText,
            notes: notes
        });

        // Show confirmation modal
        $('#cancel-confirmation-modal').fadeIn(300);
    });

    // Confirmation modal - Cancel button closes confirmation and returns to cancel modal
    $('.cancel-confirmation-btn-cancel').on('click', function(e) {
        e.preventDefault();
        $('#cancel-confirmation-modal').fadeOut(300);
    });

    // Confirmation modal - Confirm button performs the actual cancellation
    $('.cancel-confirmation-btn-confirm').on('click', function(e) {
        e.preventDefault();

        // Get stored cancel data
        const payload = $('#cancel-confirmation-modal').data('cancel-data');

        console.log('Cancel (No Make-Up) Payload:', payload);


        // Show loader
        if (typeof showGlobalLoader === 'function') {
            showGlobalLoader();
        } else {
            $("body").append(
                '<div id="custom-global-loader" style="position:fixed;top:0;left:0;width:100vw;height:100vh;z-index:99999;background:rgba(255,255,255,0.7);display:flex;align-items:center;justify-content:center;"><div style="padding:20px;background:#fff;border-radius:8px;box-shadow:0 2px 8px #0002;">Loading...</div></div>'
            );
        }

        $.ajax({
            url: M.cfg.wwwroot + "/local/customplugin/ajax/calendar_admin_cancel_event.php",
            type: "POST",
            data: JSON.stringify(payload),
            contentType: "application/json",
            success: function(response) {
                // Hide loader
                if (typeof hideGlobalLoader === 'function') {
                    hideGlobalLoader();
                } else {
                    $('#custom-global-loader').remove();
                }
                console.log("Cancel Response:", response);
                if (response.status === "success") {
                    // Show toast
                    if (typeof showToast === 'function') {
                        showToast('Class cancelled successfully!', 'success');
                    } else {
                        $("body").append(
                            '<div id="custom-toast" style="position:fixed;bottom:30px;left:50%;transform:translateX(-50%);background:#323232;color:#fff;padding:16px 32px;border-radius:8px;z-index:99999;">Class cancelled successfully!</div>'
                        );
                        setTimeout(function() {
                            $('#custom-toast').fadeOut(400, function() {
                                $(this).remove();
                            });
                        }, 2200);
                    }
                    // Reset form
                    $('#cancel-reason').data('selected-value', null);
                    $('#cancel-reason .cancel-placeholder-text').text('Select Reason');
                    $('#specific-notes').val('');
                } else {
                    // Show toast
                    if (typeof showToast === 'function') {
                        showToast('Error: ' + response.error, 'error');
                    } else {
                        $("body").append(
                            '<div id="custom-toast" style="position:fixed;bottom:30px;left:50%;transform:translateX(-50%);background:#d32f2f;color:#fff;padding:16px 32px;border-radius:8px;z-index:99999;">Error: ' +
                            response.error + '</div>');
                        setTimeout(function() {
                            $('#custom-toast').fadeOut(400, function() {
                                $(this).remove();
                            });
                        }, 2200);
                    }
                }
                // Close modal if you have one
                $("#manage-session-modal").fadeOut(300);
                // Reload calendar
                if (window.refetchCustomPluginData) {
                    window.refetchCustomPluginData('cancel-no-makeup');
                } else if (window.fetchCalendarEvents) {
                    window.fetchCalendarEvents();
                } else if (typeof loadCalendarEvents === "function") {
                    loadCalendarEvents();
                }
                // Close both modals
                $('#cancel-confirmation-modal').fadeOut(300);
                $('#cancel-nomakeup-modal').fadeOut(300);
            },
            error: function(xhr) {
                // Hide loader
                if (typeof hideGlobalLoader === 'function') {
                    hideGlobalLoader();
                } else {
                    $('#custom-global-loader').remove();
                }
                console.error("Cancel Error:", xhr.responseText);
                // Show toast
                if (typeof showToast === 'function') {
                    showToast('Something went wrong while cancelling the class.', 'error');
                } else {
                    $("body").append(
                        '<div id="custom-toast" style="position:fixed;bottom:30px;left:50%;transform:translateX(-50%);background:#d32f2f;color:#fff;padding:16px 32px;border-radius:8px;z-index:99999;">Something went wrong while cancelling the class.</div>'
                    );
                    setTimeout(function() {
                        $('#custom-toast').fadeOut(400, function() {
                            $(this).remove();
                        });
                    }, 2200);
                }
                // Reset form
                $('#cancel-reason').data('selected-value', null);
                $('#cancel-reason .cancel-placeholder-text').text('Select Reason');
                $('#specific-notes').val('');
                // Close both modals
                $('#cancel-confirmation-modal').fadeOut(300);
                $('#cancel-nomakeup-modal').fadeOut(300);
            }
        });

        // TODO: Add AJAX call here to actually cancel the session
        /*
        $.ajax({
            url: 'your-api-endpoint',
            method: 'POST',
            data: JSON.stringify(payload),
            contentType: 'application/json',
            success: function(response) {
                console.log('Session cancelled (no make-up) successfully:', response);
                $('#cancel-confirmation-modal').fadeOut(300);
                $('#cancel-nomakeup-modal').fadeOut(300);
                // Optionally refresh the calendar or show success message
            },
            error: function(xhr, status, error) {
                console.error('Error cancelling session:', error);
                // Show error message to user
            }
        });
        */

        // (Handled above)
    });

    // Close confirmation modal when clicking outside
    $('#cancel-confirmation-modal').on('click', function(e) {
        if ($(e.target).hasClass('modal-overlay')) {
            $(this).fadeOut(300);
        }
    });

    // Reason of Cancellation modal handlers
    $('#close-reason-cancellation, #reason-cancellation-ok').on('click', function(e) {
        e.preventDefault();
        $('#reason-of-cancellation-modal').fadeOut(300);
    });

    // Close reason of cancellation modal when clicking outside
    $('#reason-of-cancellation-modal').on('click', function(e) {
        if ($(e.target).hasClass('modal-overlay')) {
            $(this).fadeOut(300);
        }
    });

    // Function to open reason of cancellation modal
    window.openReasonOfCancellationModal = function(eventData) {
        console.log('Opening Reason of Cancellation modal for:', eventData);

        // Extract cancellation reason from event statuses
        let cancellationReason = '';
        let reasonText = '';

        if (eventData && eventData.statuses && Array.isArray(eventData.statuses)) {
            const cancelStatus = eventData.statuses.find(s => s.code === 'cancel_no_makeup');
            if (cancelStatus) {
                // Check nested structure: details.current or top-level
                const statusData = cancelStatus.details?.current || cancelStatus;

                reasonText = statusData.reasonText || statusData.reason_text || '';
                const notes = statusData.notes || '';
                cancellationReason = reasonText;
                if (notes) {
                    cancellationReason += (reasonText ? '. ' : '') + notes;
                }
            }
        }

        // Format date/time from event data
        const dateStr = eventData.date || '';
        const startTime = eventData.start || '';
        const endTime = eventData.end || '';

        // Format the subtitle (e.g., "Monday, September 2, 7:00-8:00 Am")
        let subtitle = '';
        if (dateStr) {
            const date = new Date(dateStr);
            const dayNames = ['Sunday', 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday'];
            const monthNames = ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August',
                'September', 'October', 'November', 'December'
            ];
            const dayName = dayNames[date.getDay()];
            const monthName = monthNames[date.getMonth()];
            const dayNum = date.getDate();
            subtitle = `${dayName}, ${monthName} ${dayNum}`;

            if (startTime && endTime) {
                subtitle += `, ${startTime}-${endTime}`;
            }
        }

        // Update modal content
        $('#reason-of-cancellation-modal .reason-cancellation-subtitle').text(subtitle);
        $('#cancellation-reason-text').text(cancellationReason || 'No reason provided.');

        // Show the modal
        $('#reason-of-cancellation-modal').fadeIn(300);
    };

    // Ensure Time Off modal receives event data and labels are populated
    (function() {
        var prevOpen = window.openTimeOffModal;

        function formatTime12h(t) {
            if (!t) return '';
            try {
                var h, m;
                if (typeof t === 'string' && t.indexOf(':') > -1) {
                    var p = t.split(':');
                    h = parseInt(p[0], 10);
                    m = parseInt(p[1], 10) || 0;
                } else if (t instanceof Date) {
                    h = t.getHours();
                    m = t.getMinutes();
                } else {
                    return '';
                }
                var ampm = h >= 12 ? 'PM' : 'AM';
                var hh = h % 12;
                if (hh === 0) hh = 12;
                return hh + ':' + String(m).padStart(2, '0') + ' ' + ampm;
            } catch (e) {
                return String(t || '');
            }
        }

        function formatDateParts(dateStr) {
            if (!dateStr) return {
                monthDay: '',
                weekday: ''
            };
            try {
                var d = new Date(dateStr);
                var monthNames = ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August',
                    'September', 'October', 'November', 'December'
                ];
                var dayNames = ['Sunday', 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday',
                    'Saturday'
                ];
                return {
                    monthDay: monthNames[d.getMonth()] + ' ' + d.getDate(),
                    weekday: dayNames[d.getDay()]
                };
            } catch (e) {
                return {
                    monthDay: String(dateStr),
                    weekday: ''
                };
            }
        }

        window.openTimeOffModal = function(eventData) {
            try {
                // Persist raw event for cancel click
                $('#timeoff-modal').data('eventData', eventData || {});

                // Populate labels
                var dateParts = formatDateParts(eventData && (eventData.date || eventData.startDate ||
                    eventData.start));
                if (dateParts.monthDay) $('#timeoff-date-line').text(dateParts.monthDay);
                if (dateParts.weekday) $('#timeoff-day-line').text(dateParts.weekday);

                var startLbl = formatTime12h(eventData && (eventData.start || eventData.startTime));
                var endLbl = formatTime12h(eventData && (eventData.end || eventData.endTime));
                if (startLbl || endLbl) {
                    $('#timeoff-time-range').text((startLbl || '') + (startLbl && endLbl ? ' → ' : '') +
                        (endLbl || ''));
                }

                // Duration from HH:mm
                (function setDuration() {
                    var s = eventData && (eventData.start || eventData.startTime);
                    var e = eventData && (eventData.end || eventData.endTime);
                    if (typeof s === 'string' && typeof e === 'string' && s.indexOf(':') > -1 && e
                        .indexOf(':') > -1) {
                        var sp = s.split(':'),
                            ep = e.split(':');
                        var sm = (+sp[0]) * 60 + (+sp[1]);
                        var em = (+ep[0]) * 60 + (+ep[1]);
                        var diff = Math.max(0, em - sm);
                        var hrs = Math.floor(diff / 60),
                            mins = diff % 60;
                        var label = hrs > 0 ? (hrs + (hrs === 1 ? ' hour' : ' hours')) : '';
                        if (mins > 0) label += (label ? ' ' : '') + mins + ' min';
                        if (label) $('#timeoff-duration').text(label);
                    }
                })();

                $('#timeoff-modal').fadeIn(200);
            } catch (err) {
                console.error('openTimeOffModal error:', err);
            }

            if (typeof prevOpen === 'function') {
                try {
                    return prevOpen(eventData);
                } catch (e) {}
            }
        };
    })();

    // Time Off modal - log payload on cancel click
    $('#timeoff-cancel-btn').on('click', function(e) {
        e.preventDefault();
        var $modal = $('#timeoff-modal');
        var eventData = $modal.data('eventData') || {};

        var payload = {
            action: 'cancel_time_off',
            classType: 'teacher_timeoff',
            timeoffId: eventData.timeoffid || eventData.id || eventData.eventid || null,
            eventid: eventData.eventid || null,
            teacherId: eventData.teacherid || eventData.teacher_id || eventData.teacherId || null,
            dateLabel: $('#timeoff-date-line').text().trim(),
            dayLabel: $('#timeoff-day-line').text().trim(),
            timeRangeLabel: $('#timeoff-time-range').text().replace(/\s+/g, ' ').trim(),
            durationLabel: $('#timeoff-duration').text().trim(),
            start: eventData.start || eventData.startTime || eventData.start_at || null,
            end: eventData.end || eventData.endTime || eventData.end_at || null,
            timezone: (Intl.DateTimeFormat && Intl.DateTimeFormat().resolvedOptions().timeZone) ||
                null,
            source: 'timeoff-modal',
            rawEventData: eventData
        };

        console.log('Time Off Cancel Payload:', payload);
    });
});
</script>