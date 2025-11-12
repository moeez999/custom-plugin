<!-- Inter font to match your UI -->
<!-- <link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700;800&display=swap" rel="stylesheet">

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script> -->

<style>
:root {
    --calendar_admin_details_lesson_availability_lesson_booking-card-radius: 8px;
    --calendar_admin_details_lesson_availability_lesson_booking-border: #ececf3;
    --calendar_admin_details_lesson_availability_lesson_booking-muted: #6b6f7b;
    --calendar_admin_details_lesson_availability_lesson_booking-heading: #131416;
    --calendar_admin_details_lesson_availability_lesson_booking-red: #fe2e0c;
}

html,
body {
    height: 100%;
}

body {
    background: #f7f7fb;
    font-family: "Inter", system-ui, -apple-system, "Segoe UI", Roboto, "Helvetica Neue", Arial, sans-serif;
    color: #111;
}

.calendar_admin_details_lesson_availability_lesson_booking_section {
    padding: 28px 12px;
}

.calendar_admin_details_lesson_availability_lesson_booking_title {
    font-weight: 600;
    letter-spacing: -.2px;
    color: var(--calendar_admin_details_lesson_availability_lesson_booking-heading);
    margin-bottom: 20px;
    font-size: clamp(22px, 2.4vw, 30px);
}

.calendar_admin_details_lesson_availability_lesson_booking_card {
    background: #fff;

    padding: 18px 0;
}

.calendar_admin_details_lesson_availability_lesson_booking_label {
    font-weight: 700;
    color: #1b1c1f;
    margin-bottom: 6px;
    font-size: clamp(16px, 1.8vw, 18px);
}

.calendar_admin_details_lesson_availability_lesson_booking_tip {
    color: var(--calendar_admin_details_lesson_availability_lesson_booking-muted);
    max-width: 62ch;
    line-height: 1.5;
}

.calendar_admin_details_lesson_availability_lesson_booking_control {
    background: #fff;
    border: 1px solid var(--calendar_admin_details_lesson_availability_lesson_booking-border);
    border-radius: var(--calendar_admin_details_lesson_availability_lesson_booking-card-radius);
    padding: 18px;
    height: 100%;
}

.calendar_admin_details_lesson_availability_lesson_booking_control_title {
    color: #26272b;
    margin-bottom: 10px;
}

/* ======= Custom SELECT (matches your screenshot) ======= */
.calendar_admin_details_lesson_availability_lesson_booking_select {
    position: relative;
    width: 100%;
}

.calendar_admin_details_lesson_availability_lesson_booking_selectbtn {
    width: 100%;
    display: flex;
    align-items: center;
    justify-content: space-between;
    border: 2px solid #ececf3;
    background: #fff;
    padding: 14px 16px;
    border-radius: 5px;
    color: #111;
    line-height: 1.1;
    /* box-shadow:0 3px 0 rgba(0,0,0,.20); */
    cursor: pointer;
}

.calendar_admin_details_lesson_availability_lesson_booking_selectbtn:focus-visible {
    outline: 0;
    box-shadow: 0 0 0 .18rem rgba(0, 0, 0, .06), 0 3px 0 rgba(0, 0, 0, .20);
}

.calendar_admin_details_lesson_availability_lesson_booking_caret {
    margin-left: 12px;
    flex: 0 0 auto;
}

.calendar_admin_details_lesson_availability_lesson_booking_menu {
    position: absolute;
    left: 0;
    top: calc(100% + 10px);
    width: 100%;
    background: #fff;
    border: 1px solid #eee;
    border-radius: 14px;
    padding: 10px 0;
    z-index: 2005;
    display: none;
    box-shadow: 0 16px 42px rgba(0, 0, 0, .18), 0 6px 18px rgba(0, 0, 0, .10);
}

.calendar_admin_details_lesson_availability_lesson_booking_select.open>.calendar_admin_details_lesson_availability_lesson_booking_menu {
    display: block;
}

.calendar_admin_details_lesson_availability_lesson_booking_item {
    padding: 16px 22px;
    /* font-weight:600; */
    color: #111;
    cursor: pointer;
    white-space: normal;
}

.calendar_admin_details_lesson_availability_lesson_booking_item:hover {
    background: #f5f6fb;
}

.calendar_admin_details_lesson_availability_lesson_booking_item[aria-selected="true"] {
    background: #f1f4ff;
}

.calendar_admin_details_lesson_availability_lesson_booking_row+.calendar_admin_details_lesson_availability_lesson_booking_row {
    margin-top: 28px;
}

.calendar_admin_details_lesson_availability_lesson_booking_savebtn {
    background: var(--calendar_admin_details_lesson_availability_lesson_booking-red);
    border: none;
    border-radius: 10px;
    padding: 12px 36px;
    font-weight: 700;
    color: #fff;
    font-size: 1.05rem;
    border: 2px solid #000;
    /* box-shadow:0 2px 0 0 #000 inset; */
    transition: background .2s ease;
}

.calendar_admin_details_lesson_availability_lesson_booking_savebtn:hover {
    background: #e53935;
}
</style>

<div class=" calendar_admin_details_lesson_availability_lesson_booking_section">
    <h1 class="calendar_admin_details_lesson_availability_lesson_booking_title">Lesson booking settings</h1>

    <!-- Row 1: Trial lesson -->
    <div class="row g-3 align-items-stretch calendar_admin_details_lesson_availability_lesson_booking_row">
        <div class="col-12 col-lg-7">
            <div class="calendar_admin_details_lesson_availability_lesson_booking_card h-100">
                <div class="calendar_admin_details_lesson_availability_lesson_booking_label">
                    Choose the minimum amount of notice you require from students booking trial lessons.
                </div>
                <div class="calendar_admin_details_lesson_availability_lesson_booking_tip">
                    Tip: make sure your choice gives you enough time to properly prepare your trial lessons.
                </div>
            </div>
        </div>
        <div class="col-12 col-lg-5">
            <div class="calendar_admin_details_lesson_availability_lesson_booking_control">
                <div class="calendar_admin_details_lesson_availability_lesson_booking_control_title">Trial lesson notice
                </div>

                <div class="calendar_admin_details_lesson_availability_lesson_booking_select"
                    id="calendar_admin_details_lesson_availability_lesson_booking_trial_select">
                    <button type="button" class="calendar_admin_details_lesson_availability_lesson_booking_selectbtn"
                        aria-expanded="false" aria-haspopup="listbox">
                        <span class="calendar_admin_details_lesson_availability_lesson_booking_value">At least 2 days
                            notice period</span>
                        <img src="./img/dropdown-arrow-down.svg" alt="">
                    </button>
                    <div class="calendar_admin_details_lesson_availability_lesson_booking_menu" role="listbox">
                        <div class="calendar_admin_details_lesson_availability_lesson_booking_item" role="option"
                            data-value="2d">At least 2 days notice period</div>
                        <div class="calendar_admin_details_lesson_availability_lesson_booking_item" role="option"
                            data-value="1d">At least 1 day notice period</div>
                        <div class="calendar_admin_details_lesson_availability_lesson_booking_item" role="option"
                            data-value="12h">At least 12 hours notice</div>
                        <div class="calendar_admin_details_lesson_availability_lesson_booking_item" role="option"
                            data-value="6h">At least 6 hours notice period</div>
                        <div class="calendar_admin_details_lesson_availability_lesson_booking_item" role="option"
                            data-value="3h">At least 3 hours notice period</div>
                        <div class="calendar_admin_details_lesson_availability_lesson_booking_item" role="option"
                            data-value="1h">At least 1 hour notice</div>
                    </div>
                </div>

            </div>
        </div>
    </div>

    <!-- Row 2: Regular lesson -->
    <div class="row g-3 align-items-stretch calendar_admin_details_lesson_availability_lesson_booking_row">
        <div class="col-12 col-lg-7">
            <div class="calendar_admin_details_lesson_availability_lesson_booking_card h-100">
                <div class="calendar_admin_details_lesson_availability_lesson_booking_label">
                    Choose the minimum amount of notice you require from regular students booking lessons.
                </div>
                <div class="calendar_admin_details_lesson_availability_lesson_booking_tip">
                    Tip: requiring less notice may encourage your regular students to schedule more lessons with you.
                </div>
            </div>
        </div>
        <div class="col-12 col-lg-5">
            <div class="calendar_admin_details_lesson_availability_lesson_booking_control">
                <div class="calendar_admin_details_lesson_availability_lesson_booking_control_title">Regular lesson
                    notice</div>

                <div class="calendar_admin_details_lesson_availability_lesson_booking_select"
                    id="calendar_admin_details_lesson_availability_lesson_booking_regular_select">
                    <button type="button" class="calendar_admin_details_lesson_availability_lesson_booking_selectbtn"
                        aria-expanded="false" aria-haspopup="listbox">
                        <span class="calendar_admin_details_lesson_availability_lesson_booking_value">At least 12 hours
                            notice</span>
                        <img src="./img/dropdown-arrow-down.svg" alt="">
                    </button>
                    <div class="calendar_admin_details_lesson_availability_lesson_booking_menu" role="listbox">
                        <div class="calendar_admin_details_lesson_availability_lesson_booking_item" role="option"
                            data-value="2d">At least 2 days notice period</div>
                        <div class="calendar_admin_details_lesson_availability_lesson_booking_item" role="option"
                            data-value="1d">At least 1 day notice period</div>
                        <div class="calendar_admin_details_lesson_availability_lesson_booking_item" role="option"
                            data-value="12h">At least 12 hours notice</div>
                        <div class="calendar_admin_details_lesson_availability_lesson_booking_item" role="option"
                            data-value="6h">At least 6 hours notice period</div>
                        <div class="calendar_admin_details_lesson_availability_lesson_booking_item" role="option"
                            data-value="3h">At least 3 hours notice period</div>
                        <div class="calendar_admin_details_lesson_availability_lesson_booking_item" role="option"
                            data-value="1h">At least 1 hour notice</div>
                    </div>
                </div>

            </div>
        </div>
    </div>

    <!-- Row 3: Booking window -->
    <div class="row g-3 align-items-stretch calendar_admin_details_lesson_availability_lesson_booking_row">
        <div class="col-12 col-lg-7">
            <div class="calendar_admin_details_lesson_availability_lesson_booking_card h-100">
                <div class="calendar_admin_details_lesson_availability_lesson_booking_label">How far in advance can
                    students book?</div>
                <div class="calendar_admin_details_lesson_availability_lesson_booking_tip">
                    Tip: Tutors can keep their calendars available up to 2 months ahead.
                </div>
            </div>
        </div>
        <div class="col-12 col-lg-5">
            <div class="calendar_admin_details_lesson_availability_lesson_booking_control">
                <div class="calendar_admin_details_lesson_availability_lesson_booking_control_title">Booking window
                </div>

                <div class="calendar_admin_details_lesson_availability_lesson_booking_select"
                    id="calendar_admin_details_lesson_availability_lesson_booking_window_select">
                    <button type="button" class="calendar_admin_details_lesson_availability_lesson_booking_selectbtn"
                        aria-expanded="false" aria-haspopup="listbox">
                        <span class="calendar_admin_details_lesson_availability_lesson_booking_value">1 month in
                            advance</span>
                        <img src="./img/dropdown-arrow-down.svg" alt="">
                    </button>
                    <div class="calendar_admin_details_lesson_availability_lesson_booking_menu" role="listbox">
                        <div class="calendar_admin_details_lesson_availability_lesson_booking_item" role="option"
                            data-value="1m">1 month in advance</div>
                        <div class="calendar_admin_details_lesson_availability_lesson_booking_item" role="option"
                            data-value="2m">2 months in advance</div>
                        <div class="calendar_admin_details_lesson_availability_lesson_booking_item" role="option"
                            data-value="3m">3 months in advance</div>
                    </div>
                </div>

            </div>
        </div>
    </div>

    <!-- Save -->
    <div class="row mt-4">
        <div class="col-12">
            <button class="calendar_admin_details_lesson_availability_lesson_booking_savebtn">Save</button>
        </div>
    </div>
</div>

<script>
// ===== STATE (prefixed) =====
const calendar_admin_details_lesson_availability_lesson_booking_state = {
    trialNotice: '2d',
    regularNotice: '12h',
    bookingWindow: '1m'
};

// ===== UTILITIES =====
function calendar_admin_details_lesson_availability_lesson_booking_closeAll() {
    $('.calendar_admin_details_lesson_availability_lesson_booking_select')
        .removeClass('open')
        .find('.calendar_admin_details_lesson_availability_lesson_booking_selectbtn')
        .attr('aria-expanded', 'false');
}

function calendar_admin_details_lesson_availability_lesson_booking_open($select) {
    calendar_admin_details_lesson_availability_lesson_booking_closeAll();
    $select.addClass('open');
    $select.find('.calendar_admin_details_lesson_availability_lesson_booking_selectbtn').attr('aria-expanded', 'true');
}

function calendar_admin_details_lesson_availability_lesson_booking_bindSelect($root, stateKey) {
    // Toggle open/close
    $root.on('click', '.calendar_admin_details_lesson_availability_lesson_booking_selectbtn', function(e) {
        e.preventDefault();
        e.stopPropagation();
        const $sel = $(this).closest('.calendar_admin_details_lesson_availability_lesson_booking_select');
        if ($sel.hasClass('open')) {
            calendar_admin_details_lesson_availability_lesson_booking_closeAll();
        } else {
            calendar_admin_details_lesson_availability_lesson_booking_open($sel);
        }
    });

    // Pick an item
    $root.on('click', '.calendar_admin_details_lesson_availability_lesson_booking_item', function(e) {
        e.preventDefault();
        e.stopPropagation();
        const text = $(this).text().trim();
        const value = $(this).data('value');

        // Update visual
        $root.find('.calendar_admin_details_lesson_availability_lesson_booking_value').text(text);
        $root.find('.calendar_admin_details_lesson_availability_lesson_booking_item').attr('aria-selected',
            'false');
        $(this).attr('aria-selected', 'true');

        // Update state
        calendar_admin_details_lesson_availability_lesson_booking_state[stateKey] = value;

        calendar_admin_details_lesson_availability_lesson_booking_closeAll();
    });
}

// Close when clicking outside or on ESC
$(document).on('click', function() {
    calendar_admin_details_lesson_availability_lesson_booking_closeAll();
});
$(document).on('keydown', function(e) {
    if (e.key === 'Escape') {
        calendar_admin_details_lesson_availability_lesson_booking_closeAll();
    }
});

// Init 3 selects
$(function() {
    calendar_admin_details_lesson_availability_lesson_booking_bindSelect(
        $('#calendar_admin_details_lesson_availability_lesson_booking_trial_select'), 'trialNotice'
    );
    calendar_admin_details_lesson_availability_lesson_booking_bindSelect(
        $('#calendar_admin_details_lesson_availability_lesson_booking_regular_select'), 'regularNotice'
    );
    calendar_admin_details_lesson_availability_lesson_booking_bindSelect(
        $('#calendar_admin_details_lesson_availability_lesson_booking_window_select'), 'bookingWindow'
    );

    $('.calendar_admin_details_lesson_availability_lesson_booking_savebtn').on('click', function() {
        alert(
            "Saved settings:\n" +
            "Trial: " + calendar_admin_details_lesson_availability_lesson_booking_state
            .trialNotice + "\n" +
            "Regular: " + calendar_admin_details_lesson_availability_lesson_booking_state
            .regularNotice + "\n" +
            "Window: " + calendar_admin_details_lesson_availability_lesson_booking_state
            .bookingWindow
        );
    });
});
</script>