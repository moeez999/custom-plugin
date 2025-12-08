<style>
.merge-date-btn {
    background: #fff;
    border: 2px solid #dadada;
    border-radius: 21px;
    padding: 10px 22px;
    font-size: 1.07rem;
    font-weight: 500;
    margin-top: 4px;
    cursor: pointer;
    transition: border .13s;
    box-shadow: 0 1px 8px #2323230d;
}

.merge-date-btn.selected {
    border: 2px solid #fe2e0c;
    color: #fe2e0c;
    background: #fff4f1;
}

.merge-checkbox-label {
    display: flex;
    align-items: center;
    gap: 9px;
    font-size: 1rem;
    color: #232323;
    margin-top: 7px;
}

.merge-checkbox-label input[type="checkbox"] {
    width: 19px;
    height: 19px;
    accent-color: #fe2e0c;
    margin-right: 2px;
}

.merge-cohort-btn {
    width: 100%;
    background: #fe2e0c;
    color: #fff;
    border: none;
    font-weight: bold;
    font-size: 1.09rem;
    border-radius: 9px;
    padding: 14px 0;
    margin-top: 18px;
    cursor: pointer;
    box-shadow: 0 3px 13px 0 rgba(254, 46, 12, .07);
    letter-spacing: .5px;
}

@media (max-width: 600px) {
    .merge-row {
        flex-direction: column;
        gap: 10px;
    }

    .merge-col {
        min-width: 0;
    }

    .merge-dropdown-list {
        width: 98vw;
        left: 50%;
        transform: translateX(-50%);
    }
}

/* --- Calendar Modal Styles (matches your screenshot) --- */
.merge-calendar-modal-backdrop {
    display: none;
    position: fixed;
    z-index: 2000;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background: rgba(0, 0, 0, 0.14);
}

.merge-calendar-modal {
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

.merge-calendar-header {
    display: flex;
    align-items: center;
    justify-content: space-between;
    margin-bottom: 16px;
}

.merge-calendar-header span {
    font-size: 1.18rem;
    font-weight: 600;
}

.merge-calendar-header button {
    background: none;
    border: none;
    font-size: 1.4rem;
    cursor: pointer;
}

#mergeCalendarMonth {
    font-size: 1.18rem;
    font-weight: 600;
}

.merge-calendar-weekdays {
    display: grid;
    grid-template-columns: repeat(7, 36px);
    grid-gap: 6px;
    justify-content: center;
    font-weight: bold;
    color: #888;
    margin-bottom: 6px;
    text-align: center;
    font-size: 1.01rem;
}

.merge-calendar-weekdays > div {
    width: 36px;
    height: 36px;
    display: flex;
    align-items: center;
    justify-content: center;
}

.merge-calendar-days {
    display: grid;
    grid-template-columns: repeat(7, 36px);
    grid-gap: 6px;
    justify-content: center;
}

.merge-calendar-day-header {
    width: 36px;
    height: 36px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-weight: bold;
    color: #888;
    font-size: 1.01rem;
}

.merge-calendar-day,
.merge-calendar-day-inactive {
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

.merge-calendar-day-inactive {
    color: #c2c2c2;
    background: #fff;
    pointer-events: none;
    cursor: default;
}

.merge-calendar-day.selected,
.merge-calendar-day:hover:not(.merge-calendar-day-inactive) {
    background: #fe2e0c;
    color: #fff;
}

.merge-calendar-done-btn {
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

.merge-calendar-done-btn:active {
    background: #e52b10;
}
</style>

<!-- <button type="button" class="merge-date-btn" id="mergeClosingDateBtn">Select Date</button> -->

<!-- Calendar Modal -->
<div class="merge-calendar-modal-backdrop" id="mergeCalendarModalBackdrop" style="display:none;">
    <div class="merge-calendar-modal" id="mergeCalendarModal">
        <div class="merge-calendar-header">
            <button type="button" class="merge-calendar-prev"><svg width="22" height="22" viewBox="0 0 24 24">
                    <polyline points="15 19 8 12 15 5" fill="none" stroke="#111" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></polyline>
                </svg></button>
            <span id="mergeCalendarMonth"></span>
            <button type="button" class="merge-calendar-next"><svg width="22" height="22" viewBox="0 0 24 24">
                    <polyline points="9 19 16 12 9 5" fill="none" stroke="#111" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></polyline>
                </svg></button>
        </div>
        <div class="merge-calendar-days"></div>
        <button class="merge-calendar-done-btn" type="button">Done</button>
    </div>
</div>

<script>
$(document).ready(function() {
// Calendar logic
let mergeDateTargetBtn = null;
let mergeCalendarMonth = null;
let mergeSelectedCalendarDate = null;

function mergeDaysInMonth(year, month) {
    return new Date(year, month + 1, 0).getDate();
}

// Show modal on button click - using event delegation for dynamically loaded content
$(document).on('click', '#resched_date_label, #resched_date_field, #mergeMergingDateBtn', function(e) {
    e.preventDefault();
    e.stopPropagation();
    // Get the label element for updating later
    mergeDateTargetBtn = $(this).is('#resched_date_label') ? $(this) : $('#resched_date_label');
    // Show modal
    $('#mergeCalendarModalBackdrop').fadeIn(100);
    // Set calendar month to current or to the already selected date
    let now = new Date();
    mergeCalendarMonth = {
        year: now.getFullYear(),
        month: now.getMonth()
    };
    mergeSelectedCalendarDate = null;
    mergeRenderCalendarModal();
});

// Month navigation
$(document).on('click', '.merge-calendar-prev', function() {
    mergeCalendarMonth.month--;
    if (mergeCalendarMonth.month < 0) {
        mergeCalendarMonth.month = 11;
        mergeCalendarMonth.year--;
    }
    mergeRenderCalendarModal();
});
$(document).on('click', '.merge-calendar-next', function() {
    mergeCalendarMonth.month++;
    if (mergeCalendarMonth.month > 11) {
        mergeCalendarMonth.month = 0;
        mergeCalendarMonth.year++;
    }
    mergeRenderCalendarModal();
});

// Day select
$(document).on('click', '.merge-calendar-day', function() {
    $('.merge-calendar-day').removeClass('selected');
    $(this).addClass('selected');
    let day = parseInt($(this).attr('data-day'));
    mergeSelectedCalendarDate = new Date(mergeCalendarMonth.year, mergeCalendarMonth.month, day);
});

// Done button
$(document).on('click', '.merge-calendar-done-btn', function() {
    if (mergeDateTargetBtn && mergeSelectedCalendarDate) {
        let d = mergeSelectedCalendarDate;
        let nice = d.toLocaleDateString('en-GB', {
            day: '2-digit',
            month: 'short',
            year: 'numeric'
        });
        mergeDateTargetBtn.text(nice).addClass('selected');
        $('#mergeCalendarModalBackdrop').fadeOut(120);
        mergeDateTargetBtn = null;
    }
});

// Click outside modal closes it
$(document).on('click', '#mergeCalendarModalBackdrop', function(e) {
    if (e.target === this) $(this).fadeOut(120);
});

// Render function
function mergeRenderCalendarModal() {
    const monthNames = ["January", "February", "March", "April", "May", "June", "July", "August", "September",
        "October", "November", "December"
    ];
    let y = mergeCalendarMonth.year,
        m = mergeCalendarMonth.month;
    $('#mergeCalendarMonth').text(`${monthNames[m]} ${y}`);
    let html = '';
    let dayHeaders = ['Mo', 'Tu', 'We', 'Th', 'Fr', 'Sa', 'Su'];
    for (let d = 0; d < 7; d++) html += `<div class="merge-calendar-day-header">${dayHeaders[d]}</div>`;
    let firstDay = new Date(y, m, 1).getDay();
    firstDay = (firstDay + 6) % 7;
    let totalDays = mergeDaysInMonth(y, m);
    let prevMonthDays = firstDay;
    let day = 1;
    for (let i = 0; i < prevMonthDays; i++) html += `<div class="merge-calendar-day-inactive"></div>`;
    for (let d = 1; d <= totalDays; d++) {
        let sel = mergeSelectedCalendarDate &&
            mergeSelectedCalendarDate.getFullYear() === y &&
            mergeSelectedCalendarDate.getMonth() === m &&
            mergeSelectedCalendarDate.getDate() === d ? ' selected' : '';
        html += `<div class="merge-calendar-day${sel}" data-day="${d}">${d}</div>`;
        day++;
    }
    let rem = (prevMonthDays + totalDays) % 7;
    if (rem > 0)
        for (let i = rem; i < 7; i++) html += `<div class="merge-calendar-day-inactive"></div>`;
    $('.merge-calendar-days').html(html);
}

}); // End document.ready
</script>