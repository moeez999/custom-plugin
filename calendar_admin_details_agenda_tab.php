<style>
#calendar_admin_agenda_content {
    background: #ffffff;
    padding: 0px 14px 7px 14px;
    min-height: 100vh;
    padding-top: 24px;
    padding-bottom: 48px;
}

.calendar-meeting-items {
    margin-top: 17px;
}

/* Remove excessive boldness, set left alignment, normal font weight */
.calendar_admin_agenda_event_card {
    border: 1.2px solid #ededed;
    border-radius: 8px;
    background: #fff;
    padding: 16px 36px;
    display: flex;
    align-items: center;
    gap: 20px;
    margin-bottom: 0;
    font-family: 'Inter', Arial, sans-serif;
    font-weight: 500;
    max-width: 100%;
    margin-left: 0;
    margin-right: 0;
    margin-top: 10px;
}

.calendar_admin_agenda_title {
    font-weight: 600 !important;
    /* lighter bold */
    color: #222;
    font-size: 16px;
    line-height: 1.2;
}

.calendar_admin_agenda_time {
    /* font-weight: 500; */
    color: #222;
    min-width: 120px;
    font-size: 14px;
    letter-spacing: 0.01em;
}

.calendar_admin_agenda_daycol {

    padding-top: 10px;
    display: flex;

    justify-content: center;

    flex-direction: column;
    align-items: center;
}

.calendar_admin_agenda_date {
    font-weight: 600;
    font-size: 18px;
    color: #23272f;
    margin-bottom: 2px;
}

.calendar_admin_agenda_day {
    font-size: 15px;
    color: #888;
}

.calendar_admin_agenda_hr {
    border: none;
    border-top: 1.5px solid #e4dcdc;
    margin: 26px 0 0 0;
}

@media (max-width: 768px) {
    .calendar_admin_agenda_event_card {
        max-width: 98vw;
        padding: 12px 8px;
        font-size: 14px;
    }

    .calendar_admin_agenda_title {
        font-size: 15px;
    }

    .calendar_admin_agenda_time {
        font-size: 13px;
        min-width: 75px;
    }

    .calendar_admin_agenda_date {
        font-size: 1.1rem;
    }
}
</style>

<!-- Agenda Tab Content -->
<div id="calendar_admin_agenda_content" style="display:none;">
    <div class="container-fluid calendar_admin_agenda_bg px-0">
        <!-- Mon 2 -->
        <div class="row g-0 align-items-center calendar-meeting-items">
            <div class="col-2 col-sm-1 calendar_admin_agenda_daycol">
                <div class="calendar_admin_agenda_date">2</div>
                <div class="calendar_admin_agenda_day">Mon</div>
            </div>
            <div class="col-10 col-sm-11">
                <div class="calendar_admin_agenda_event_card">
                    <span class="calendar_admin_agenda_time">18:30 - 19:30</span>
                    <span class="calendar_admin_agenda_title">Latingles - Teachers' Team Meeting</span>
                </div>
            </div>
        </div>
        <hr class="calendar_admin_agenda_hr">

        <!-- Tue 3 -->
        <div class="row g-0 align-items-center calendar-meeting-items">
            <div class="col-2 col-sm-1 calendar_admin_agenda_daycol">
                <div class="calendar_admin_agenda_date">3</div>
                <div class="calendar_admin_agenda_day">Tue</div>
            </div>
            <div class="col-10 col-sm-11">
                <div class="calendar_admin_agenda_event_card">
                    <span class="calendar_admin_agenda_time">18:30 - 19:30</span>
                    <span class="calendar_admin_agenda_title">Latingles - Teachers' Team Meeting</span>
                </div>
                <div class="calendar_admin_agenda_event_card">
                    <span class="calendar_admin_agenda_time">20:30 - 21:30</span>
                    <span class="calendar_admin_agenda_title">Latingles - Teachers' Team Meeting</span>
                </div>
            </div>
        </div>
        <hr class="calendar_admin_agenda_hr">

        <!-- Wed 4 -->
        <div class="row g-0 align-items-center calendar-meeting-items">
            <div class="col-2 col-sm-1 calendar_admin_agenda_daycol">
                <div class="calendar_admin_agenda_date">4</div>
                <div class="calendar_admin_agenda_day">Wed</div>
            </div>
            <div class="col-10 col-sm-11">
                <div class="calendar_admin_agenda_event_card">
                    <span class="calendar_admin_agenda_time">18:30 - 19:30</span>
                    <span class="calendar_admin_agenda_title">Latingles - Teachers' Team Meeting</span>
                </div>
            </div>
        </div>
        <hr class="calendar_admin_agenda_hr">

        <!-- Thu 5 -->
        <div class="row g-0 align-items-center calendar-meeting-items">
            <div class="col-2 col-sm-1 calendar_admin_agenda_daycol">
                <div class="calendar_admin_agenda_date">5</div>
                <div class="calendar_admin_agenda_day">Thu</div>
            </div>
            <div class="col-10 col-sm-11">
                <div class="calendar_admin_agenda_event_card">
                    <span class="calendar_admin_agenda_time">18:30 - 19:30</span>
                    <span class="calendar_admin_agenda_title">Latingles - Teachers' Team Meeting</span>
                </div>
            </div>
        </div>
        <hr class="calendar_admin_agenda_hr">

        <!-- Fri 6 -->
        <div class="row g-0 align-items-center calendar-meeting-items">
            <div class="col-2 col-sm-1 calendar_admin_agenda_daycol">
                <div class="calendar_admin_agenda_date">6</div>
                <div class="calendar_admin_agenda_day">Fri</div>
            </div>
            <div class="col-10 col-sm-11">
                <div class="calendar_admin_agenda_event_card">
                    <span class="calendar_admin_agenda_time">18:30 - 19:30</span>
                    <span class="calendar_admin_agenda_title">Latingles - Teachers' Team Meeting</span>
                </div>
            </div>
        </div>
        <hr class="calendar_admin_agenda_hr">

        <!-- Sat 7 -->
        <div class="row g-0 align-items-center calendar-meeting-items">
            <div class="col-2 col-sm-1 calendar_admin_agenda_daycol">
                <div class="calendar_admin_agenda_date">7</div>
                <div class="calendar_admin_agenda_day">Sat</div>
            </div>
            <div class="col-10 col-sm-11">
                <div class="calendar_admin_agenda_event_card">
                    <span class="calendar_admin_agenda_time">18:30 - 19:30</span>
                    <span class="calendar_admin_agenda_title">Latingles - Teachers' Team Meeting</span>
                </div>
            </div>
        </div>
        <hr class="calendar_admin_agenda_hr">

        <!-- Sun 8 -->
        <div class="row g-0 align-items-center mb-3">
            <div class="col-2 col-sm-1 calendar_admin_agenda_daycol">
                <div class="calendar_admin_agenda_date">8</div>
                <div class="calendar_admin_agenda_day">Sun</div>
            </div>
            <div class="col-10 col-sm-11">
                <div class="calendar_admin_agenda_event_card">
                    <span class="calendar_admin_agenda_time">18:30 - 19:30</span>
                    <span class="calendar_admin_agenda_title">Latingles - Teachers' Team Meeting</span>
                </div>
            </div>
        </div>
    </div>
</div>