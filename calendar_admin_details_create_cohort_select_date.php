<style>
/* ====== MAIN MODAL STYLES ====== */
.calendar_admin_details_create_cohort_customrec_modal_backdrop {
    display: none;
    position: fixed;
    z-index: 2050;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background: rgba(0, 0, 0, 0.18);
}

.calendar_admin_details_create_cohort_customrec_modal {
    background: #fff;
    border-radius: 13px;
    box-shadow: 0 10px 36px 0 rgba(0, 0, 0, .16);
    width: 340px;
    min-width: 320px;
    max-width: 97vw;
    padding: 10px 18px 12px 18px;
    position: absolute;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%);
    font-size: 1.03rem;
}

.calendar_admin_details_create_cohort_close.customrec {
    position: absolute;
    top: 16px;
    right: 16px;
    font-size: 23px;
    cursor: pointer;
    color: #232323;
}

.customrec_stepper {
    border: none;
    background: #f3f3f3;
    border-radius: 50%;
    width: 36px;
    height: 36px;
    font-size: 1.27rem;
    font-weight: 600;
    color: #232323;
    cursor: pointer;
    transition: background 0.13s;
}

.customrec_stepper:active {
    background: #ececec;
}

.customrec_dropdown_wrapper {
    position: relative;
}

.customrec_dropdown_btn {
    display: flex;
    align-items: center;
    background: #fff;
    border: 1.3px solid #dadada;
    border-radius: 11px;
    padding: 8px 18px;
    font-size: 1.01rem;
    cursor: pointer;
    min-width: 120px;
    font-weight: 600;
    margin-left: 10px;
}

.customrec_dropdown_btn svg {
    margin-left: 7px;
}

.customrec_dropdown_list {
    display: none;
    position: absolute;
    top: 110%;
    left: 0;
    width: 160px;
    background: #fff;
    border: 1.5px solid #dadada;
    border-radius: 13px;
    box-shadow: 0 4px 18px #0001;
    z-index: 110;
}

.customrec_option {
    padding: 13px 18px;
    font-size: 1rem;
    border-radius: 9px;
    cursor: pointer;
    transition: background 0.15s;
    font-weight: 500;
    color: #232323;
}

.customrec_option:hover {
    background: #f6f6f6;
    color: #fe2e0c;
}

.customrec_date_btn {
    background: #ececec;
    border: none;
    border-radius: 7px;
    font-size: 1.01rem;
    font-weight: 500;
    color: #6d6d6d;
    padding: 8px 14px;
    cursor: pointer;
    opacity: 0.6;
}

.customrec_date_btn.enabled {
    background: #fff;
    color: #232323;
    border: 1.3px solid #dadada;
    opacity: 1;
}

.customrec_occurrence_counter {
    display: inline-flex;
    align-items: center;
}

.customrec_occurrence_counter button {
    margin: 0 5px;
}

/* ---- Monthly row style ---- */
.customrec_monthly_picker_wrapper {
    display: flex;
    align-items: center;
    margin-top: 12px;
    padding-bottom: 8px;
    border-bottom: 2px solid #fe2e0c;
    justify-content: space-between;
    cursor: pointer;
}

.customrec_monthly_picker_label {
    font-size: 1.14rem;
    font-weight: 500;
    color: #232323;
}

.customrec_monthly_picker_date {
    font-size: 1.12rem;
    font-weight: 500;
    margin-left: 8px;
    color: #232323;
}

.customrec_monthly_picker_arrow {
    margin-left: 12px;
    margin-top: 3px;
}

.calendar_admin_details_create_cohort_btn_cr {
    border-radius: 8px;
    padding: 12px 0;
    width: 100%;
    font-size: 1.09rem;
    font-weight: bold;
    transition: background .14s, color .14s, border .14s;
    border: none;
    box-shadow: 0 2px 8px #0001;
    letter-spacing: 0.01em;
    margin-bottom: 0;
    outline: none;
    cursor: pointer;
    margin-top: 10px;
}

/* ====== CALENDAR MODAL STYLES (UNIQUE) ====== */
.monthly_cal_modal_backdrop {
    display: none;
    position: fixed;
    z-index: 9999;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background: rgba(0, 0, 0, 0.14);
}

.monthly_cal_modal {
    background: #fff;
    border-radius: 15px;
    box-shadow: 0 10px 36px 0 rgba(0, 0, 0, .16);
    max-width: 300px;
    max-width: 97vw;
    padding: 26px 24px 24px 24px;
    position: absolute;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%);
    font-family: inherit;
}

.monthly_cal_header {
    display: flex;
    align-items: center;
    justify-content: space-between;
    margin-bottom: 16px;
}

.monthly_cal_month_label {
    font-size: 1.18rem;
    font-weight: 600;
}

.monthly_cal_grid {
    display: grid;
    grid-template-columns: repeat(7, 36px);
    grid-gap: 6px;
    justify-content: center;
}

.monthly_cal_day,
.monthly_cal_date {
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

.monthly_cal_day {
    font-weight: bold;
    color: #888;
    cursor: default;
}

.monthly_cal_date.selected,
.monthly_cal_date:hover {
    background: #fe2e0c;
    color: #fff;
}

.monthly_cal_date.inactive {
    color: #c2c2c2;
    background: #fff;
    pointer-events: none;
    cursor: default;
}

.monthly_cal_done_btn {
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

.monthly_cal_done_btn:active {
    background: #e52b10;
}

/* ====== Scroll Widget (now acts as the day toggle) ====== */
.scroll-widget {
    box-sizing: border-box;
    width: 41px;
    min-height: 41px;
    background-color: #f2f2f2;
    border: 1px solid rgba(0, 0, 0, 0.12);
    border-radius: 104.61px;
    display: flex;
    flex-direction: column;
    justify-content: center;
    align-items: center;
    gap: 8px;

    user-select: none;
    cursor: pointer;
    opacity: 0.55;
    transition: opacity .15s, box-shadow .15s, transform .06s;
}

.scroll-widget:active {
    transform: translateY(1px);
}

.scroll-widget.selected {
    opacity: 1;
    box-shadow: 0 2px 10px #0001;
    padding: 14px 0px;
    border: 1px solid #fe2e0c;
}

.scroll-widget__text {
    color: #ff2500;
    font-family: "Poppins", sans-serif;
    font-weight: 500;
    font-size: 14px;
    line-height: 21px;
}

.scroll-widget__divider {
    width: 25px;
    border-top: 0.5px solid rgba(0, 0, 0, 0.2);
    display: none;
}

/* Divider only visible when selected */
.scroll-widget.selected .scroll-widget__divider {
    display: block;
}

.scroll-widget__button {
    box-sizing: border-box;
    width: 25px;
    height: 25px;
    background-color: #ffffff;
    border-radius: 50%;
    display: none;
    justify-content: center;
    align-items: center;
    cursor: pointer;
}

/* Arrow button only visible when selected */
.scroll-widget.selected .scroll-widget__button {
    display: flex;
}

.scroll-widget__arrow {
    width: 0;
    height: 0;
    border-left: 6px solid transparent;
    border-right: 6px solid transparent;
    border-top: 6px solid #000000;
}

/* ====== Time readout inside the day widget ====== */
.scroll-widget__time {
    display: none;
    /* appears only when widget is selected and time set */
    flex-direction: column;
    align-items: center;
    gap: 2px;
    text-align: center;
    font-family: "Poppins", sans-serif;
}

.scroll-widget.selected .scroll-widget__time.has-time {
    display: flex;
}

.scroll-widget__hm {
    color: #000;
    font-weight: 500;
    font-size: 11px;
    line-height: 14px;
}

.scroll-widget__period {
    color: #ff2500;
    font-weight: 500;
    font-size: 11px;
    line-height: 14px;
    cursor: pointer;
    user-select: none;
    transition: opacity 0.2s ease;
}

.scroll-widget__period:hover {
    opacity: 0.7;
}

.scroll-widget__dash {
    font-size: 11px;
    line-height: 14px;
    color: #000;
    opacity: .8;
}

/* ====== Time Picker Card styles (reused inside modal) ====== */
#time-picker {
    width: 100%;
    display: flex;
    justify-content: center;
    padding: 20px;
}

.time-picker-card {
    background-color: #ffffff;
    border: 0.75px solid rgba(0, 0, 0, 0.12);
    border-radius: 10px;
    box-shadow: 0px 8px 32px 0px rgba(18, 17, 23, 0.15), 0px 16px 48px 0px rgba(18, 17, 23, 0.15);
    max-width: 265px;
    width: 100%;
    padding: 16px 24px;
    display: flex;
    flex-direction: column;

}

.card-title {
    color: #000000;
    font-family: "Poppins", sans-serif;
    font-weight: 600;
    font-size: 16px;
    line-height: 24px;
    margin: 0;
}

.time-inputs-container {
    display: flex;
    justify-content: space-between;
    align-items: center;
}

.time-input {
    border: 2px solid rgba(0, 0, 0, 0.12);
    border-radius: 10px;
    padding: 9px 8px;
    width: 99px;
    height: 40px;
    display: flex;
    justify-content: center;
    align-items: center;
}

.time-text {
    color: #000000;
    font-family: "Poppins", sans-serif;
    font-weight: 400;
    font-size: 14px;
    line-height: 21px;
    margin: 0;
}

.time-separator {
    background-color: #000000;
    width: 7px;
    height: 1px;
}

.button-container {
    display: flex;
    justify-content: flex-end;
}

.done-button {
    background-color: #ff2500;
    border: 2px solid #121117;
    border-radius: 8px;
    color: #ffffff;
    font-family: "Poppins", sans-serif;
    font-weight: 600;
    font-size: 16px;
    width: 99px;
    height: 40px;
    padding: 0;
    display: flex;
    justify-content: center;
    align-items: center;
    cursor: pointer;
}

/* Layout helper for the weekly row of widgets */
.customrec_weekly_row {
    display: flex;
    gap: 9px;
    margin-top: 10px;
    align-items: flex-start;
    flex-wrap: nowrap;
}

/* Hide the arrow when a time has been set */
.scroll-widget__button.has-time {
    display: none !important;
}

/* The "tp dot" that displays the time inside the arrow button area */
.scroll-widget__button .tp-dot {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    min-width: 28px;
    height: 18px;
    padding: 0 6px;
    border-radius: 999px;
    background: #ff2500;
    color: #fff;
    font-family: "Poppins", sans-serif;
    font-weight: 600;
    font-size: 10px;
    line-height: 18px;
    margin-left: 4px;
}
</style>


<!-- ========= CALENDAR MODAL HTML ========= -->
<div class="monthly_cal_modal_backdrop" id="monthly_cal_modal_backdrop">
    <div class="monthly_cal_modal">
        <div class="monthly_cal_header">
            <button id="monthly_cal_prev"
                style="background:none;border:none;font-size:1.4rem;cursor:pointer;">&#8592;</button>
            <span class="monthly_cal_month_label" id="monthly_cal_month"></span>
            <button id="monthly_cal_next"
                style="background:none;border:none;font-size:1.4rem;cursor:pointer;">&#8594;</button>
        </div>
        <div class="monthly_cal_grid" id="monthly_cal_days"></div>
        <div class="monthly_cal_grid" id="monthly_cal_dates"></div>
        <button class="monthly_cal_done_btn" id="monthly_cal_done">Done</button>
    </div>
</div>

<!-- ========= REUSABLE TIME PICKER MODAL ========= -->
<div class="monthly_cal_modal_backdrop" id="timePickerModalBackdrop" style="display:none;">
    <div class="monthly_cal_modal">
        <div class="time-picker-card" style="box-shadow:none;border:none;padding:0;">
            <h2 class="card-title" id="tp_day_label">Select Start & End Time</h2>
            <div class="d-flex" id="customTimeFields" style="margin-top: 10px;">
                <div class="custom-time-pill">
                    <input id="tp_start" type="text" class="form-control time-input" value="09:00 AM" autocomplete="off"
                        readonly />
                    <div class="custom-time-dropdown"></div>
                </div>
                <div class="time-dash">–</div>
                <div class="custom-time-pill">
                    <input id="tp_end" type="text" class="form-control time-input" value="10:00 AM" autocomplete="off"
                        readonly />
                    <div class="custom-time-dropdown"></div>
                </div>

            </div>
            <div class="button-container" style="margin-top:16px;">
                <button id="tp_cancel" class="customrec_date_btn enabled"
                    style="border:1.3px solid #dadada;background:#fff;color:#232323;width:99px;height:40px;">Cancel</button>
                <button id="tp_done" class="done-button" style="margin-left:8px;">Done</button>
            </div>
        </div>
    </div>
</div>

<!-- ========= MAIN CUSTOM RECURRENCE MODAL HTML ========= -->
<div id="customRecurrenceModalBackdrop" class="calendar_admin_details_create_cohort_customrec_modal_backdrop"
    style="display:none;">
    <div class="calendar_admin_details_create_cohort_customrec_modal">
        <span class="calendar_admin_details_create_cohort_close_sub customrec">&times;</span>
        <h2 style="margin-bottom:16px;">Custom Recurrence</h2>

        <div style="margin-bottom:16px;">
            <label style="font-weight:600;">Repeat Every</label>
            <div style="display:flex; align-items:center; gap:13px; margin-top:7px;">
                <button class="customrec_stepper" id="customrec_minus">−</button>
                <span id="customrec_interval" style="font-size:1.18rem;font-weight:bold;">1</span>
                <button class="customrec_stepper" id="customrec_plus">+</button>

                <div class="customrec_dropdown_wrapper">
                    <div class="customrec_dropdown_btn" id="customrec_period_btn">
                        <span id="customrec_period_val">Week</span>
                        <svg width="18" height="18" viewBox="0 0 20 20">
                            <path d="M7 8l3 3 3-3" fill="none" stroke="#232323" stroke-width="2"></path>
                        </svg>
                    </div>
                    <div class="customrec_dropdown_list" id="customrec_period_list">
                        <div class="customrec_option">1 Day</div>
                        <div class="customrec_option">Week</div>
                        <div class="customrec_option">Monthly</div>
                        <div class="customrec_option">Year</div>
                    </div>
                </div>
            </div>
        </div>

        <hr style="border:none; border-top:1.3px solid #ececec; margin:10px 0 15px 0;">

        <!-- Repeat On (WEEK) using Scroll Widgets -->
        <div id="customrec_repeat_on_container">
            <label style="font-weight:600;">Repeat on</label>
            <div class="customrec_weekly_row" id="weekly_scroll_widgets">
                <!-- Widgets injected by JS -->
            </div>
        </div>

        <!-- Monthly Date Picker (Show only for Monthly) -->
        <div id="customrec_monthly_picker_container" style="display:none;">
            <div class="customrec_monthly_picker_wrapper" id="customrec_monthly_picker_btn">
                <span class="customrec_monthly_picker_label" id="customrec_monthly_picker_label">
                    Monthly on <span class="customrec_monthly_picker_date" id="customrec_monthly_picker_date"></span>
                </span>
                <svg class="customrec_monthly_picker_arrow" width="18" height="18" viewBox="0 0 20 20">
                    <path d="M7 8l3 3 3-3" fill="none" stroke="#232323" stroke-width="2"></path>
                </svg>
            </div>
        </div>

        <hr style="border:none; border-top:1.3px solid #ececec; margin:15px 0;">

        <div>
            <label style="font-weight:600;">Ends</label>
            <div style="margin-top:8px;">
                <div style="display:flex;align-items:center; gap:10px; margin-bottom:6px;">
                    <input type="radio" id="customrec_end_never" name="customrec_end" checked>
                    <label for="customrec_end_never" style="font-size:1.05rem;">Never</label>
                </div>
                <div style="display:flex;align-items:center; gap:10px; margin-bottom:6px;">
                    <input type="radio" id="customrec_end_on" name="customrec_end">
                    <label for="customrec_end_on" style="font-size:1.05rem;">On</label>
                    <button id="customrec_end_date_btn" disabled style="margin-left:10px;"
                        class="customrec_date_btn">Sep 27,2024</button>
                </div>
                <div style="display:flex;align-items:center; gap:10px;">
                    <input type="radio" id="customrec_end_after" name="customrec_end">
                    <label for="customrec_end_after" style="font-size:1.05rem;">After</label>
                    <div class="customrec_occurrence_counter" style="margin-left:12px;">
                        <button class="customrec_stepper" id="customrec_occ_minus" disabled>−</button>
                        <span id="customrec_occ_val" style="font-size:1.11rem;font-weight:600;color:#555;">13
                            occurrences</span>
                        <button class="customrec_stepper" id="customrec_occ_plus" disabled>+</button>
                    </div>
                </div>
            </div>
        </div>

        <div style="display:flex; gap:12px;">
            <button class="calendar_admin_details_create_cohort_btn_cr" id="customrec_cancel"
                style="background:#fff;color:#232323;border:2px solid #232323;">Cancel</button>
            <button class="calendar_admin_details_create_cohort_btn_cr" id="customrec_done"
                style="background:#fe2e0c;">Done</button>
        </div>
    </div>
</div>

<!-- jQuery -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<script>
$('.customrec-close, #customrec_cancel, #customRecurrenceModalBackdrop, .calendar_admin_details_create_cohort_close_sub')
    .on('click', function(e) {
        if (e.target === this || $(e.target).hasClass('customrec-close') || e.target.id ===
            'customrec_cancel') {
            $('#customRecurrenceModalBackdrop').fadeOut();
        }
    });

function to12h(hhmm) {
    // expects "HH:MM" or "HH:MM AM/PM" and returns {hm:"hh:mm", period:"AM|PM"}
    let t = hhmm.trim().toUpperCase();
    if (/AM|PM/.test(t)) {
        // already 12h (e.g., "9:30 AM")
        let [hm, period] = t.split(/\s+/);
        let [h, m] = hm.split(':').map(s => s.padStart(2, '0'));
        return {
            hm: `${h}:${m}`,
            period
        };
    } else {
        // 24h -> 12h
        let [h, m] = t.split(':').map(Number);
        let period = h >= 12 ? 'PM' : 'AM';
        h = h % 12;
        if (h === 0) h = 12;
        return {
            hm: `${String(h).padStart(2,'0')}:${String(m).padStart(2,'0')}`,
            period
        };
    }
}

function renderWidgetTime(key, start, end) {
    const s = to12h(start),
        e = to12h(end);
    const $w = $(`.scroll-widget[data-key="${key}"]`);
    let $time = $w.find('.scroll-widget__time');
    if (!$time.length) {
        $time = $(`
      <div class="scroll-widget__time">
        <div class="scroll-widget__hm s"></div>
        <span class="scroll-widget__period sp"></span>
        <span class="scroll-widget__dash">-</span>
        <div class="scroll-widget__hm e"></div>
        <span class="scroll-widget__period ep"></span>
      </div>
    `);
        // insert under the divider, above the arrow
        $w.find('.scroll-widget__divider').after($time);
    }
    $time.find('.s').text(s.hm);
    $time.find('.sp').text(s.period);
    $time.find('.e').text(e.hm);
    $time.find('.ep').text(e.period);
    $time.addClass('has-time');
}

/* ---------- Date utils ---------- */
function pad(n) {
    return n < 10 ? '0' + n : n;
}

function formatDate(dateObj) {
    const months = ["Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec"];
    return `${months[dateObj.getMonth()]} ${pad(dateObj.getDate())},${dateObj.getFullYear()}`;
}

$(function() {
    // Initial Monthly and "On" date are today
    let monthlyDate = new Date();
    let endsOnDate = new Date();
    $('#customrec_monthly_picker_date').text(formatDate(monthlyDate));
    $('#customrec_end_date_btn').text(formatDate(endsOnDate));

    // Track where the calendar was opened from
    let calendarTarget = null; // "monthly" or "endsOn"

    // DEMO open (hook to your real opener)
    $('.conference_modal_repeat_btn').on('click', function() {
        $('#customRecurrenceModalBackdrop').fadeIn();
    });

    /* ---------- Period dropdown ---------- */
    $('#customrec_period_btn').on('click', function(e) {
        e.stopPropagation();
        $('#customrec_period_list').toggle();
    });
    $(document).on('click', function() {
        $('#customrec_period_list').hide();
    });

    $('#customrec_period_list .customrec_option').on('click', function() {
        let period = $(this).text().trim();
        $('#customrec_period_val').text(period);
        $('#customrec_period_list').hide();

        if (period.toLowerCase() === 'week') {
            $('#customrec_repeat_on_container').slideDown(130);
            $('#customrec_monthly_picker_container').slideUp(130);
        } else if (period.toLowerCase() === 'monthly') {
            $('#customrec_repeat_on_container').slideUp(130);
            $('#customrec_monthly_picker_container').slideDown(130);
            $('#customrec_monthly_picker_date').text(formatDate(monthlyDate));
        } else {
            $('#customrec_repeat_on_container').slideUp(130);
            $('#customrec_monthly_picker_container').slideUp(130);
        }
    });

    // Initial state on load
    if ($('#customrec_period_val').text().trim().toLowerCase() === 'week') {
        $('#customrec_repeat_on_container').show();
        $('#customrec_monthly_picker_container').hide();
    } else if ($('#customrec_period_val').text().trim().toLowerCase() === 'monthly') {
        $('#customrec_repeat_on_container').hide();
        $('#customrec_monthly_picker_container').show();
        $('#customrec_monthly_picker_date').text(formatDate(monthlyDate));
    } else {
        $('#customrec_repeat_on_container').hide();
        $('#customrec_monthly_picker_container').hide();
    }

    /* ---------- Ends radio logic ---------- */
    function updateEndsUI() {
        if ($('#customrec_end_on').is(':checked')) {
            $('#customrec_end_date_btn').prop('disabled', false).addClass('enabled');
            $('#customrec_occ_minus,#customrec_occ_plus').prop('disabled', true);
        } else if ($('#customrec_end_after').is(':checked')) {
            $('#customrec_end_date_btn').prop('disabled', true).removeClass('enabled');
            $('#customrec_occ_minus,#customrec_occ_plus').prop('disabled', false);
        } else {
            $('#customrec_end_date_btn').prop('disabled', true).removeClass('enabled');
            $('#customrec_occ_minus,#customrec_occ_plus').prop('disabled', true);
        }
    }
    $('input[name="customrec_end"]').on('change', updateEndsUI);
    updateEndsUI();

    /* ---------- Interval ---------- */
    let recInt = 1;
    $('#customrec_plus').on('click', function() {
        recInt++;
        $('#customrec_interval').text(recInt);
    });
    $('#customrec_minus').on('click', function() {
        if (recInt > 1) recInt--;
        $('#customrec_interval').text(recInt);
    });

    /* ---------- Occurrences ---------- */
    let occVal = 13;
    $('#customrec_occ_plus').on('click', function() {
        if ($('#customrec_end_after').is(':checked')) {
            occVal++;
            $('#customrec_occ_val').text(occVal + ' occurrences');
        }
    });
    $('#customrec_occ_minus').on('click', function() {
        if ($('#customrec_end_after').is(':checked') && occVal > 1) {
            occVal--;
            $('#customrec_occ_val').text(occVal + ' occurrences');
        }
    });

    $('#customrec_done').on('click', function() {
        $('#customRecurrenceModalBackdrop').fadeOut(); /* save if needed */
    });

    // Close main modal
    $('.calendar_admin_details_create_cohort_close.customrec, #customrec_cancel, #customRecurrenceModalBackdrop')
        .on('click', function(e) {
            if (e.target === this || $(e.target).hasClass(
                    'calendar_admin_details_create_cohort_close') || e.target.id === 'customrec_cancel') {
                $('#customRecurrenceModalBackdrop').fadeOut();
            }
        });

    /* ======== MONTHLY CALENDAR MODAL LOGIC ======== */
    let calSelectedDate = new Date();
    let calViewMonth = calSelectedDate.getMonth();
    let calViewYear = calSelectedDate.getFullYear();

    // Open modal on monthly row click
    $('#customrec_monthly_picker_btn').on('click', function() {
        calendarTarget = 'monthly';
        calSelectedDate = new Date(monthlyDate.getTime());
        calViewMonth = calSelectedDate.getMonth();
        calViewYear = calSelectedDate.getFullYear();
        renderMonthlyCal();
        $('#monthly_cal_modal_backdrop').fadeIn(90);
    });

    // Open modal from "Ends On" date button (only if enabled)
    $('#customrec_end_date_btn').on('click', function() {
        if (!$(this).prop('disabled')) {
            calendarTarget = 'endsOn';
            calSelectedDate = new Date(endsOnDate.getTime());
            calViewMonth = calSelectedDate.getMonth();
            calViewYear = calSelectedDate.getFullYear();
            renderMonthlyCal();
            $('#monthly_cal_modal_backdrop').fadeIn(90);
        }
    });

    function renderMonthlyCal() {
        let monthNames = ["January", "February", "March", "April", "May", "June", "July", "August",
            "September", "October", "November", "December"
        ];
        $('#monthly_cal_month').text(monthNames[calViewMonth] + " " + calViewYear);

        let days = ["Mo", "Tu", "We", "Th", "Fr", "Sa", "Su"];
        let $daysRow = $('#monthly_cal_days').empty();
        for (let i = 0; i < 7; i++) {
            $daysRow.append('<div class="monthly_cal_day">' + days[i] + '</div>');
        }

        let $datesRow = $('#monthly_cal_dates').empty();
        let firstDay = new Date(calViewYear, calViewMonth, 1).getDay(); // 0=Sun,1=Mon
        let offset = (firstDay + 6) % 7; // so Monday=0
        let daysInMonth = new Date(calViewYear, calViewMonth + 1, 0).getDate();

        for (let i = 0; i < offset; i++) {
            $datesRow.append('<div class="monthly_cal_date inactive"></div>');
        }
        for (let d = 1; d <= daysInMonth; d++) {
            let isSel = d === calSelectedDate.getDate() && calViewMonth === calSelectedDate.getMonth() &&
                calViewYear === calSelectedDate.getFullYear();
            $datesRow.append('<div class="monthly_cal_date' + (isSel ? ' selected' : '') + '" data-date="' +
                d + '">' + d + '</div>');
        }
        $('.monthly_cal_date').off('click').on('click', function() {
            if ($(this).hasClass('inactive')) return;
            let day = parseInt($(this).attr('data-date'), 10);
            calSelectedDate.setFullYear(calViewYear);
            calSelectedDate.setMonth(calViewMonth);
            calSelectedDate.setDate(day);
            renderMonthlyCal();
        });
    }

    $('#monthly_cal_prev').on('click', function() {
        if (calViewMonth === 0) {
            calViewMonth = 11;
            calViewYear--;
        } else calViewMonth--;
        renderMonthlyCal();
    });
    $('#monthly_cal_next').on('click', function() {
        if (calViewMonth === 11) {
            calViewMonth = 0;
            calViewYear++;
        } else calViewMonth++;
        renderMonthlyCal();
    });

    $('#monthly_cal_done').on('click', function() {
        if (calendarTarget === 'monthly') {
            monthlyDate = new Date(calSelectedDate.getTime());
            $('#customrec_monthly_picker_date').text(formatDate(monthlyDate));
        } else if (calendarTarget === 'endsOn') {
            endsOnDate = new Date(calSelectedDate.getTime());
            $('#customrec_end_date_btn').text(formatDate(endsOnDate));
        } else if (calendarTarget === 'manageSession') {
            // Update manage session modal date button
            const $dateBtn = $('#session-event-date-btn');
            const year = calSelectedDate.getFullYear();
            const month = calSelectedDate.getMonth();
            const day = calSelectedDate.getDate();
            const monthNames = ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct',
                'Nov', 'Dec'
            ];
            const formattedDate = monthNames[month] + ' ' + day + ', ' + year;
            const rawDate = year + '-' + String(month + 1).padStart(2, '0') + '-' + String(day)
                .padStart(2, '0');

            $dateBtn.text(formattedDate);
            $dateBtn.data('raw-date', rawDate);
        } else if (calendarTarget === 'peertalk' && window.peertalkDateButton) {
            // Update peertalk date button
            const year = calSelectedDate.getFullYear();
            const month = calSelectedDate.getMonth();
            const day = calSelectedDate.getDate();
            const monthNames = ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct',
                'Nov', 'Dec'
            ];
            const formattedDate = monthNames[month] + ' ' + day + ', ' + year;
            const rawDate = year + '-' + String(month + 1).padStart(2, '0') + '-' + String(day)
                .padStart(2, '0');

            window.peertalkDateButton.text(formattedDate);
            window.peertalkDateButton.data('raw-date', rawDate);
            window.peertalkDateButton.removeClass('field-error');
        }
        $('#monthly_cal_modal_backdrop').fadeOut(80);
    });
    $('#monthly_cal_modal_backdrop').on('click', function(e) {
        if (e.target === this) $('#monthly_cal_modal_backdrop').fadeOut(80);
    });

    /* === Recurrence label sync === */
    var $recurrenceTargetBtn = null;
    $(document).on('click', '.conference_modal_repeat_btn, .cohort_schedule_btn', function() {
        $recurrenceTargetBtn = $(this);

        // Parse values from button and prefill if it's cohort_schedule_btn
        if ($(this).hasClass('cohort_schedule_btn')) {
            const buttonText = $(this).clone().find('.cohort_schedule_arrow').remove().end().text()
                .trim();

            // Day name to index mapping
            const dayMap = {
                'sun': 0,
                'mon': 1,
                'tue': 2,
                'wed': 3,
                'thu': 4,
                'fri': 5,
                'sat': 6
            };

            // Reset modal first
            resetCustomRecurrenceModal();

            // Parse and select days with times
            const dayPattern =
                /(mon|tue|wed|thu|fri|sat|sun)\s*\((\d{1,2}):(\d{2})\s*(am|pm)\s*-\s*(\d{1,2}):(\d{2})\s*(am|pm)\)/gi;
            let match;

            while ((match = dayPattern.exec(buttonText)) !== null) {
                const dayName = match[1].toLowerCase();
                const dayIndex = dayMap[dayName];

                if (dayIndex !== undefined) {
                    // Parse times
                    let startHour = parseInt(match[2], 10);
                    const startMin = match[3];
                    const startPeriod = match[4].toLowerCase();

                    let endHour = parseInt(match[5], 10);
                    const endMin = match[6];
                    const endPeriod = match[7].toLowerCase();

                    // Convert to 24h format
                    if (startPeriod === 'pm' && startHour !== 12) startHour += 12;
                    if (startPeriod === 'am' && startHour === 12) startHour = 0;

                    if (endPeriod === 'pm' && endHour !== 12) endHour += 12;
                    if (endPeriod === 'am' && endHour === 12) endHour = 0;

                    const start = `${String(startHour).padStart(2, '0')}:${startMin}`;
                    const end = `${String(endHour).padStart(2, '0')}:${endMin}`;

                    // Select the widget
                    const $widget = $(`.scroll-widget[data-key="${dayIndex}"]`);
                    $widget.addClass('selected').attr('aria-pressed', 'true');

                    // Save time
                    dayTimes[dayIndex] = {
                        start,
                        end
                    };

                    // Render the big time readout
                    renderWidgetTime(dayIndex, start, end);

                    // Add tp-dot badge
                    const s12 = to12h(start);
                    const e12 = to12h(end);
                    const sh = parseInt(s12.hm.split(':')[0], 10);
                    const eh = parseInt(e12.hm.split(':')[0], 10);
                    const shortLabel = `${sh}\u2013${eh}`;

                    const $btn = $widget.find('.scroll-widget__button');
                    $btn.addClass('has-time');
                    if (!$btn.find('.tp-dot').length) {
                        $btn.append(`<span class="tp-dot">${shortLabel}</span>`);
                    } else {
                        $btn.find('.tp-dot').text(shortLabel);
                    }
                }
            }
        } else {
            resetCustomRecurrenceModal();
        }

        $('#customRecurrenceModalBackdrop').fadeIn();
    });

    function normalizePeriod() {
        var raw = ($('#customrec_period_val').text() || '').trim().toLowerCase();
        if (raw.indexOf('day') > -1) return 'day';
        if (raw.indexOf('week') > -1) return 'week';
        if (raw.indexOf('month') > -1) return 'month';
        if (raw.indexOf('year') > -1) return 'year';
        return '';
    }


    function trimmedDateFrom(sel) {
        return ($(sel).text() || '').trim().replace(/,\s*\d{4}$/, '');
    }

    function selectedWeekdaysLabel() {
        var names = ['Sun', 'Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat'];
        var picked = [];
        $('#weekly_scroll_widgets .scroll-widget.selected').each(function() {
            var idx = parseInt($(this).attr('data-key'), 10);
            var dayLabel = names[idx];

            // If this day has a time set, append it
            if (dayTimes[idx]) {
                var s = to12h(dayTimes[idx].start);
                var e = to12h(dayTimes[idx].end);
                dayLabel += '(<span class="time-range">' + s.hm + ' ' + s.period + ' - ' + e.hm + ' ' +
                    e.period + '</span>)';
            }

            picked.push(dayLabel);
        });
        return picked.join(', ');
    }

    function computeRecurrenceLabel() {
        var n = parseInt($('#customrec_interval').text(), 10) || 1;
        var p = normalizePeriod();
        if (!p) return 'Does not repeat';
        if (p === 'day') {
            return (n === 1) ? 'Daily' : ('Every ' + n + ' days');
        }
        if (p === 'week') {
            var days = selectedWeekdaysLabel();
            if (n === 1) return days ? ('Weekly on ' + days) : 'Weekly';
            return 'Every ' + n + ' weeks' + (days ? (' on ' + days) : '');
        }
        if (p === 'month') {
            var on = trimmedDateFrom('#customrec_monthly_picker_date') || trimmedDateFrom(
                '#customrec_end_date_btn');
            return (n === 1) ? ('Monthly on ' + on) : ('Every ' + n + ' months on ' + on);
        }
        if (p === 'year') {
            var onY = trimmedDateFrom('#customrec_end_date_btn') || trimmedDateFrom(
                '#customrec_monthly_picker_date');
            return (n === 1) ? ('Annually on ' + onY) : ('Every ' + n + ' years on ' + onY);
        }
        return 'Does not repeat';
    }

    function updateRepeatButtonLabel() {
        var $btn = ($recurrenceTargetBtn && $recurrenceTargetBtn.length) ? $recurrenceTargetBtn : $(
            '.conference_modal_repeat_btn, .cohort_schedule_btn').first();
        if (!$btn.length) return;
        var label = computeRecurrenceLabel();
        if ($btn.hasClass('cohort_schedule_btn')) {
            $btn.html(label + ' <span class="cohort_schedule_arrow">&#9660;</span>');
        } else if ($btn.hasClass('conference_modal_repeat_btn')) {
            $btn.html(label + '<span style="float:right; font-size:1rem;">&#9660;</span>');
        } else {
            $btn.text(label);
        }
    }
    $(document).on('click', '#customrec_period_list .customrec_option, #customrec_plus, #customrec_minus',
        function() {
            setTimeout(updateRepeatButtonLabel, 0);
        });
    $(document).on('click', '#monthly_cal_done, #customrec_done', function() {
        setTimeout(updateRepeatButtonLabel, 0);
    });

    /* ==================== WEEKLY SCROLL WIDGETS ==================== */
    const dayNamesShort = ['S', 'M', 'T', 'W', 'T', 'F', 'S'];
    const dayNamesLong = ['Sun', 'Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat'];
    const $weeklyRow = $('#weekly_scroll_widgets');

    // Map key (0..6) -> {start,end}
    var dayTimes = {};
    var currentDayKey = null;

    function widgetTemplate(letter, key) {
        return `
      <div class="scroll-widget" data-key="${key}" role="button" aria-pressed="false" title="${letter}">
        <span class="scroll-widget__text">${letter}</span>
        <div class="scroll-widget__divider"></div>
        <div class="scroll-widget__button" data-arrow="1" aria-label="Set time for ${letter}">
          <div class="scroll-widget__arrow"></div>
        </div>
      </div>
    `;
    }

    // Build 7 widgets (all start deselected)
    for (let i = 0; i < 7; i++) {
        $weeklyRow.append(widgetTemplate(dayNamesShort[i], i));
    }

    // Toggle select/deselect when clicking the widget (but NOT when clicking the arrow)
    $(document).on('click', '.scroll-widget', function(e) {
        if ($(e.target).closest('[data-arrow]').length) return; // arrow has its own handler
        const $w = $(this);
        const sel = !$w.hasClass('selected');
        $w.toggleClass('selected', sel).attr('aria-pressed', sel ? 'true' : 'false');

        // If deselected, clear saved time for that day
        // If deselected, clear saved time for that day
        if (!sel) {
            const key = parseInt($w.attr('data-key'), 10);
            delete dayTimes[key];
            // remove any dot and arrow-hidden state
            $w.find('.scroll-widget__button').removeClass('has-time').find('.tp-dot').remove();
            // also clear big time readout
            $w.find('.scroll-widget__time').removeClass('has-time').remove();
        }

        setTimeout(updateRepeatButtonLabel, 0);
    });

    // Handle period (AM/PM) toggle on click
    $(document).on('click', '.scroll-widget__period', function(e) {
        e.stopPropagation();
        const $period = $(this);
        const $widget = $period.closest('.scroll-widget');
        const key = parseInt($widget.attr('data-key'), 10);

        if (dayTimes[key]) {
            const current = $period.text().trim();
            const newPeriod = current === 'AM' ? 'PM' : 'AM';

            // Determine if this is start period (sp) or end period (ep)
            const isStartPeriod = $period.hasClass('sp');

            // Get current time in 24h format
            const timeStr = isStartPeriod ? dayTimes[key].start : dayTimes[key].end;
            const [h, m] = timeStr.split(':').map(Number);

            // Convert current 24h time to 12h to get current period
            const currentPeriodFromTime = h >= 12 ? 'PM' : 'AM';

            // Calculate the offset to apply
            let newH = h;
            if (newPeriod === 'PM' && currentPeriodFromTime === 'AM') {
                // Converting from AM to PM: add 12 hours (unless it's 12:xx AM which becomes 12:xx PM)
                if (h !== 0) newH = h + 12;
                // 0:xx AM (midnight) becomes 12:xx PM = hour 12
                else newH = 12;
            } else if (newPeriod === 'AM' && currentPeriodFromTime === 'PM') {
                // Converting from PM to AM: subtract 12 hours
                if (h !== 12) newH = h - 12;
                // 12:xx PM becomes 12:xx AM = hour 0 (midnight)
                else newH = 0;
            }

            // Update the 24h time
            const new24hTime = `${String(newH).padStart(2, '0')}:${String(m).padStart(2, '0')}`;

            if (isStartPeriod) {
                dayTimes[key].start = new24hTime;
            } else {
                dayTimes[key].end = new24hTime;
            }

            // Update the display
            renderWidgetTime(key, dayTimes[key].start, dayTimes[key].end);

            // Update the repeat button label
            setTimeout(updateRepeatButtonLabel, 0);
        }
    });

    $('#timePickerModalBackdrop .monthly_cal_modal').on('click', function(e) {
        e.stopPropagation();
    });
    // Open time picker on arrow click (only visible when selected)
    $(document).on('click', '.scroll-widget .scroll-widget__button', function(e) {
        e.stopPropagation();
        const $w = $(this).closest('.scroll-widget');
        currentDayKey = parseInt($w.attr('data-key'), 10);
        const labelLong = dayNamesLong[currentDayKey] || '';
        const cur = dayTimes[currentDayKey] || {
            start: '09:00',
            end: '10:00'
        };
        $('#tp_start').val(cur.start);
        $('#tp_end').val(cur.end);

        $('#timePickerModalBackdrop').fadeIn(90);
    });

    // Time picker close/save
    function closeTP() {

        $('#timePickerModalBackdrop').fadeOut(80);
    }
    $('#tp_cancel').on('click', closeTP);


    $('#tp_done').on('click', function() {
        if (currentDayKey == null) return;

        // Get the time values from inputs (may be in 12h format with AM/PM)
        const startInput = ($('#tp_start').val() || '09:00 AM').trim();
        const endInput = ($('#tp_end').val() || '10:00 AM').trim();

        // Convert 12h format to 24h format
        function convert12to24(timeStr) {
            const match = timeStr.match(/^(\d{1,2}):(\d{2})(?:\s*(AM|PM))?$/i);
            if (!match) return '09:00'; // fallback
            let h = parseInt(match[1], 10);
            const m = match[2];
            const period = (match[3] || 'AM').toUpperCase();

            if (period === 'PM' && h !== 12) h += 12;
            if (period === 'AM' && h === 12) h = 0;

            return `${String(h).padStart(2, '0')}:${m}`;
        }

        let start = convert12to24(startInput);
        let end = convert12to24(endInput);

        // Allow times crossing midnight (e.g., 5:00 PM to 2:00 AM next day)
        // Only auto-increment if end < start AND they're in the same period
        if (end < start) {
            // Check if this is likely a midnight crossing (PM to AM) vs user error
            const startHour = parseInt(start.split(':')[0], 10);
            const endHour = parseInt(end.split(':')[0], 10);
            const startIsPM = startHour >= 12;
            const endIsAM = endHour < 12;

            // If start is PM and end is AM, it's intentional midnight crossing - allow it
            if (startIsPM && endIsAM) {
                // Keep as-is, this is valid (e.g., 5:00 PM to 2:00 AM)
            } else {
                // Otherwise, auto-increment end to next hour (user likely made a mistake)
                const [h, m] = start.split(':').map(Number);
                const h2 = (h + 1) % 24;
                end = `${String(h2).padStart(2,'0')}:${String(m).padStart(2,'0')}`;
            }
        }

        dayTimes[currentDayKey] = {
            start,
            end
        };

        // --- Update the big time readout under the divider ---
        renderWidgetTime(currentDayKey, start, end);

        // --- Build a short label for the tp-dot (hours only: 9–10) ---
        const s12 = to12h(start),
            e12 = to12h(end);
        const sh = parseInt(s12.hm.split(':')[0], 10);
        const eh = parseInt(e12.hm.split(':')[0], 10);
        const shortLabel = `${sh}\u2013${eh}`;

        // --- Insert/update tp-dot and hide arrow via class ---
        const $btn = $(`.scroll-widget[data-key="${currentDayKey}"] .scroll-widget__button`);
        $btn.addClass('has-time'); // hides the arrow via CSS

        if ($btn.length) {
            const $dot = $btn.find('.tp-dot');
            if ($dot.length) {
                $dot.text(shortLabel);
            }
        }

        // close modal
        $('#timePickerModalBackdrop').fadeOut(80);
    });


    // Hide widgets when not in weekly mode; re-show when back to weekly mode
    function isWeekly() {
        return ($('#customrec_period_val').text() || '').trim().toLowerCase().includes('week');
    }
    $(document).on('click', '#customrec_period_list .customrec_option', function() {
        setTimeout(() => {
            if (isWeekly()) $('#customrec_repeat_on_container').show();
        }, 0);
    });

    // Export payload on Done (example hook)
    $('#customrec_done').on('click', function() {
        const payload = [];
        $('#weekly_scroll_widgets .scroll-widget.selected').each(function() {
            const key = parseInt($(this).attr('data-key'), 10);
            const t = dayTimes[key] || null;
            payload.push({
                dayIndex: key,
                day: dayNamesLong[key],
                ...(t || {})
            });
        });
        // console.log('Selected day times:', payload);
        // TODO: send payload to your backend / state store
    });

    /* ---------- Reset modal ---------- */
    function resetCustomRecurrenceModal() {
        // Reset interval
        recInt = 1;
        $('#customrec_interval').text(recInt);
        // Reset occurrences
        occVal = 13;
        $('#customrec_occ_val').text(occVal + ' occurrences');
        // Reset period to Week
        $('#customrec_period_val').text('Week');
        $('#customrec_repeat_on_container').show();
        $('#customrec_monthly_picker_container').hide();
        // Reset dates to today
        monthlyDate = new Date();
        endsOnDate = new Date();
        $('#customrec_monthly_picker_date').text(formatDate(monthlyDate));
        $('#customrec_end_date_btn').text(formatDate(endsOnDate));
        // Reset end option to Never
        $('#customrec_end_never').prop('checked', true);
        updateEndsUI();
        // Reset calendar view
        calSelectedDate = new Date();
        calViewMonth = calSelectedDate.getMonth();
        calViewYear = calSelectedDate.getFullYear();
        // Reset weekly widgets selection & times
        $('#weekly_scroll_widgets .scroll-widget').removeClass('selected').attr('aria-pressed', 'false')
            .find('.tp-dot').remove();
        dayTimes = {};
        currentDayKey = null;
    }
});
</script>