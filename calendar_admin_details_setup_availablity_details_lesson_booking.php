<!-- Inter font to match your UI -->
<!-- <link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700;800&display=swap" rel="stylesheet">

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script> -->

<link rel="stylesheet" href="<?php echo $CFG->wwwroot; ?>/local/customplugin/css/calendar_admin_details_setup_availablity_details_lesson_booking.css">

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
        // Get teacher info from main page
        const $userBtn = window.parent ? $(window.parent.document).find(
            '#calendar_admin_details_setup_availablity_userbtn') : $(
            '#calendar_admin_details_setup_availablity_userbtn');
        const teacherPayload = {
            name: $userBtn.data('teacher-name') || $userBtn.find(
                '#calendar_admin_details_setup_availablity_username').text(),
            img: $userBtn.data('teacher-img') || $userBtn.find(
                '#calendar_admin_details_setup_availablity_avatar').attr('src'),
            id: $userBtn.data('teacher-id') || null
        };
        console.log('Lesson booking save payload:', {
            teacher: teacherPayload,
            settings: calendar_admin_details_lesson_availability_lesson_booking_state
        });
    });
});
</script>