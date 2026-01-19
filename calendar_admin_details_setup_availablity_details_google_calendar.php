<!-- Inter font -->
<!-- <link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700;800&display=swap" rel="stylesheet">

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
 -->
<link rel="stylesheet" href="<?php echo $CFG->wwwroot; ?>/local/customplugin/css/calendar_admin_details_setup_availablity_details_google_calendar.css">
    --gc-green: #d9f6ef;
    --gc-red: #fe2e0c;
    --gc-black: #121212;
}

body {
    background: #f7f7fb;
    color: #111;
    font-family: "Inter", system-ui, -apple-system, "Segoe UI", Roboto, "Helvetica Neue", Arial, sans-serif;
}

.calendar_admin_details_setup_availability_google_calendar_wrap {
    padding: 28px 12px;
}

.calendar_admin_details_setup_availability_google_calendar_title {
    font-weight: 800;
    font-size: clamp(22px, 2.4vw, 30px);
    margin-bottom: 18px;
}

/* Banner */
.calendar_admin_details_setup_availability_google_calendar_banner {
    background: var(--gc-green);
    border: 1px solid #c7eee5;
    border-radius: 8px;
    padding: 8px 16px;
    position: relative;
    display: flex;
    align-items: center;
    justify-content: space-between;
    gap: 16px;
}

.calendar_admin_details_setup_availability_google_calendar_banner_left {
    display: flex;
    align-items: center;
    gap: 14px;
}

.calendar_admin_details_setup_availability_google_calendar_badge {
    width: 44px;
    height: 44px;
    border-radius: 50%;
    background: #19b68e;
    display: grid;
    place-items: center;
    box-shadow: inset 0 0 0 3px rgba(255, 255, 255, .45);
}

.calendar_admin_details_setup_availability_google_calendar_banner_text {
    font-size: 15px;
}

.calendar_admin_details_setup_availability_google_calendar_disconnect {
    background: #d9f6ef;
    border: 2px solid #0c0c0c;
    color: #0c0c0c;
    border-radius: 10px;
    padding: 10px 16px;
}

/* Section label */
.calendar_admin_details_setup_availability_google_calendar_label {
    font-size: 16px;
    margin: 22px 0 10px;
}

/* Calendar list card */
.calendar_admin_details_setup_availability_google_calendar_listcard {
    background: #fff;
    border: 1px solid var(--gc-border);
    border-radius: 12px;
    overflow: hidden;
    width: 50%;
}

.calendar_admin_details_setup_availability_google_calendar_listrow {
    display: flex;
    align-items: center;
    gap: 12px;
    padding: 16px 18px;
    border-top: 1px solid var(--gc-border);
}

.calendar_admin_details_setup_availability_google_calendar_listrow:first-child {
    border-top: none;
}

/* Custom checkbox */
.calendar_admin_details_setup_availability_google_calendar_check {
    position: relative;
    width: 22px;
    height: 22px;
    border-radius: 6px;
    border: 2px solid #d1d5db;
    background: #fff;
    flex: 0 0 22px;
    cursor: pointer;
}

.calendar_admin_details_setup_availability_google_calendar_check[data-checked="true"] {
    background: #fe3a2f;
    border-color: #fe3a2f;
}

.calendar_admin_details_setup_availability_google_calendar_check svg {
    position: absolute;
    inset: 0;
    margin: auto;
    width: 14px;
    height: 14px;
    display: none;
}

.calendar_admin_details_setup_availability_google_calendar_check[data-checked="true"] svg {
    display: block;
    fill: #fff;
}

.calendar_admin_details_setup_availability_google_calendar_row_disabled {
    color: #a7a9b1;
}

.calendar_admin_details_setup_availability_google_calendar_check[aria-disabled="true"] {
    background: #f1f2f5;
    border-color: #e1e3e8;
    cursor: not-allowed;
}

/* “Block availability” checkbox & text */
.calendar_admin_details_setup_availability_google_calendar_blockwrap {
    margin-top: 22px;
}

.calendar_admin_details_setup_availability_google_calendar_blockbox {
    display: flex;
    align-items: center;
    gap: 12px;
    font-weight: 700;
}

.calendar_admin_details_setup_availability_google_calendar_block_desc {
    color: var(--gc-muted);
    margin-top: 10px;
    max-width: 70ch;
    line-height: 1.55;
}

/* Save button */
.calendar_admin_details_setup_availability_google_calendar_save {
    margin-top: 22px;
    background: var(--gc-red);
    color: #fff;
    padding: 14px 34px;
    font-weight: 700;
    border-radius: 10px;
    border: 2px solid #000;
    /* box-shadow:0 2px 0 0 #000 inset; */
}

/* Responsive */
@media (max-width: 576px) {
    .calendar_admin_details_setup_availability_google_calendar_banner {
        flex-direction: column;
        align-items: flex-start;
    }

<div class=" calendar_admin_details_setup_availability_google_calendar_wrap">
    <h1 class="calendar_admin_details_setup_availability_google_calendar_title">Google Calendar settings</h1>

    <!-- Connected banner -->
    <div class="calendar_admin_details_setup_availability_google_calendar_banner">
        <div class="calendar_admin_details_setup_availability_google_calendar_banner_left">
            <!-- Updated green circle with refresh icon -->
            <div class="calendar_admin_details_setup_availability_google_calendar_badge" aria-hidden="true"
                style="background:#007f5f;">
                <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" viewBox="0 0 24 24" fill="none"
                    stroke="#fff" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <polyline points="23 4 23 10 17 10"></polyline>
                    <polyline points="1 20 1 14 7 14"></polyline>
                    <path d="M3.51 9a9 9 0 0 1 14.85-3.36L23 10M1 14l4.64 4.36A9 9 0 0 0 20.49 15"></path>
                </svg>
            </div>
            <div class="calendar_admin_details_setup_availability_google_calendar_banner_text">
                Your Google Calendar, <strong>ranaali2247407@gmail.com</strong>, is connected
            </div>
        </div>
        <button type="button" class="calendar_admin_details_setup_availability_google_calendar_disconnect">
            Disconnect Google Calendar
        </button>
    </div>





    <!-- Choose calendars -->
    <div class="calendar_admin_details_setup_availability_google_calendar_label fw-semibold">
        Choose which Google Calendars you’d like to see on Latingles
    </div>
    <div class="calendar_admin_details_setup_availability_google_calendar_listcard"
        id="calendar_admin_details_setup_availability_google_calendar_list">
        <!-- Row 1 (checked) -->
        <div class="calendar_admin_details_setup_availability_google_calendar_listrow" data-key="primary">
            <div class="calendar_admin_details_setup_availability_google_calendar_check" role="checkbox" tabindex="0"
                aria-checked="true" data-checked="true" aria-label="Primary calendar">
                <svg viewBox="0 0 24 24">
                    <path
                        d="M20.285 6.709a1 1 0 0 0-1.414-1.418l-9.9 9.9-3.84-3.84a1 1 0 1 0-1.414 1.415l4.547 4.546a1 1 0 0 0 1.414 0l10.007-10.603Z" />
                </svg>
            </div>
            <div class="calendar_admin_details_setup_availability_google_calendar_rowtext">
                ranaali2247407@gmail.com
            </div>
        </div>

        <!-- Row 2 (disabled / grey) -->
        <div class="calendar_admin_details_setup_availability_google_calendar_listrow" data-key="on_latingles">
            <div class="calendar_admin_details_setup_availability_google_calendar_check" role="checkbox"
                aria-disabled="true" aria-checked="false" data-checked="false" aria-label="On latingles (disabled)">
            </div>
            <div
                class="calendar_admin_details_setup_availability_google_calendar_rowtext calendar_admin_details_setup_availability_google_calendar_row_disabled">
                On latingles
            </div>
        </div>
    </div>

    <!-- Block availability toggle -->
    <div class="calendar_admin_details_setup_availability_google_calendar_blockwrap">
        <div class="calendar_admin_details_setup_availability_google_calendar_blockbox">
            <div class="calendar_admin_details_setup_availability_google_calendar_check"
                id="calendar_admin_details_setup_availability_google_calendar_block_checkbox" role="checkbox"
                aria-checked="false" data-checked="false" tabindex="0"
                aria-label="Allow Google Calendar events to block your availability">
                <svg viewBox="0 0 24 24">
                    <path
                        d="M20.285 6.709a1 1 0 0 0-1.414-1.418l-9.9 9.9-3.84-3.84a1 1 0 1 0-1.414 1.415l4.547 4.546a1 1 0 0 0 1.414 0l10.007-10.603Z" />
                </svg>
            </div>
            <div>Allow Google Calendar events to block your availability</div>
        </div>
        <div class="calendar_admin_details_setup_availability_google_calendar_block_desc">
            If you allow, students can’t book lessons when you have events in the Google Calendars synced to Latingles.
            Exception: events longer than 24 hours won’t block your Latingles availability.
        </div>
    </div>

    <!-- Save -->
    <button class="calendar_admin_details_setup_availability_google_calendar_save"
        id="calendar_admin_details_setup_availability_google_calendar_savebtn">Save</button>
</div>

<script>
// ===== STATE =====
const calendar_admin_details_setup_availability_google_calendar_state = {
    connectedEmail: "ranaali2247407@gmail.com",
    calendars: {
        primary: true,
        on_latingles: false // disabled in UI
    },
    blockAvailability: false
};

// ===== HELPERS =====
function calendar_admin_details_setup_availability_google_calendar_toggle($box) {
    if ($box.attr('aria-disabled') === 'true') return;
    const now = $box.attr('data-checked') === 'true';
    $box.attr('data-checked', String(!now)).attr('aria-checked', String(!now));
}

// click handlers for list checkboxes
$('#calendar_admin_details_setup_availability_google_calendar_list')
    .on('click', '.calendar_admin_details_setup_availability_google_calendar_check', function() {
        const $row = $(this).closest('.calendar_admin_details_setup_availability_google_calendar_listrow');
        const key = $row.data('key');
        if ($(this).attr('aria-disabled') === 'true') return;

        calendar_admin_details_setup_availability_google_calendar_toggle($(this));
        calendar_admin_details_setup_availability_google_calendar_state.calendars[key] =
            $(this).attr('data-checked') === 'true';
    })
    .on('keydown', '.calendar_admin_details_setup_availability_google_calendar_check', function(e) {
        if (e.key === ' ' || e.key === 'Enter') {
            e.preventDefault();
            $(this).trigger('click');
        }
    });

// Block availability toggle
$('#calendar_admin_details_setup_availability_google_calendar_block_checkbox')
    .on('click', function() {
        calendar_admin_details_setup_availability_google_calendar_toggle($(this));
        calendar_admin_details_setup_availability_google_calendar_state.blockAvailability =
            $(this).attr('data-checked') === 'true';
    })
    .on('keydown', function(e) {
        if (e.key === ' ' || e.key === 'Enter') {
            e.preventDefault();
            $(this).trigger('click');
        }
    });

// Disconnect button (demo)
$('.calendar_admin_details_setup_availability_google_calendar_disconnect').on('click', function() {
    alert('Disconnect flow would start here (OAuth revoke, etc.).');
});

// Save button (demo)
$('#calendar_admin_details_setup_availability_google_calendar_savebtn').on('click', function() {
    // Get teacher info from main page
    const $userBtn = window.parent ? $(window.parent.document).find('#calendar_admin_details_setup_availablity_userbtn') : $('#calendar_admin_details_setup_availablity_userbtn');
    const teacherPayload = {
        name: $userBtn.data('teacher-name') || $userBtn.find('#calendar_admin_details_setup_availablity_username').text(),
        img: $userBtn.data('teacher-img') || $userBtn.find('#calendar_admin_details_setup_availablity_avatar').attr('src'),
        id: $userBtn.data('teacher-id') || null
    };
    console.log('Google calendar save payload:', {
        teacher: teacherPayload,
        settings: calendar_admin_details_setup_availability_google_calendar_state
    });
});
</script>