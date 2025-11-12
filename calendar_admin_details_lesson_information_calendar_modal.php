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
    z-index: 9999;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background: rgba(0, 0, 0, 0.09);
}

.merge-calendar-modal {
    background: #fff;
    border-radius: 17px;
    box-shadow: 0 8px 30px 0 rgba(0, 0, 0, .13);
    width: 340px;
    max-width: 96vw;
    margin: 5vh auto;
    padding: 0 0 24px 0;
    position: absolute;
    left: 50%;
    top: 48%;
    transform: translate(-50%, -50%);
    animation: fadeIn .18s;
}

@keyframes fadeIn {
    from {
        opacity: 0;
    }

    to {
        opacity: 1;
    }
}

.merge-calendar-header {
    display: flex;
    align-items: center;
    justify-content: space-between;
    font-size: 1.21rem;
    font-weight: bold;
    padding: 24px 24px 6px 24px;
}

.merge-calendar-header button {
    background: #fff;
    border: 2px solid #ececec;
    border-radius: 9px;
    font-size: 1.4rem;
    color: #232323;
    cursor: pointer;
    font-weight: 600;
    transition: border .15s, background .13s;
}

.merge-calendar-header button:hover {
    border: 2px solid #fe2e0c;
    background: #fff7f4;
}

#mergeCalendarMonth {
    font-size: 1.19rem;
    font-weight: 600;
    color: #232323;
    letter-spacing: .5px;
    flex: 1;
    text-align: center;
}

.merge-calendar-days {
    display: grid;
    grid-template-columns: repeat(7, 1fr);
    gap: 2px;
    padding: 0 22px 0 22px;
    margin: 6px 0 7px 0;
    font-size: 1.08rem;
}

.merge-calendar-day-header {
    color: #b2b2b2;
    font-weight: 600;
    padding: 8px 0 5px 0;
    background: none;
    text-align: center;
}

.merge-calendar-day,
.merge-calendar-day-inactive {
    padding: 12px 0;
    border-radius: 7px;
    cursor: pointer;
    font-size: 1.09rem;
    font-weight: 500;
    text-align: center;
    background: #fff;
    transition: background .13s, color .12s, border .15s;
}

.merge-calendar-day-inactive {
    color: #cccccc;
    background: #fff;
    cursor: not-allowed;
    font-weight: 400;
}

.merge-calendar-day.selected {
    border: 2px solid #fe2e0c;
    color: #fe2e0c;
    background: #fff;
    font-weight: 700;
}

.merge-calendar-done-btn {
    width: 92%;
    margin: 16px 4% 0 4%;
    background: linear-gradient(90deg, #fe2e0c 40%, #ff3e10 100%);
    color: #fff;
    font-size: 1.13rem;
    font-weight: bold;
    border-radius: 10px;
    border: 2px solid #232323;
    padding: 13px 0;
    cursor: pointer;
    transition: background .12s, border .11s;
    box-shadow: 0 2px 10px #2323231a;
    display: block;
}

.merge-calendar-done-btn:hover {
    background: #ff3e10;
    border: 2px solid #fe2e0c;
}
</style>

<!-- <button type="button" class="merge-date-btn" id="mergeClosingDateBtn">Select Date</button> -->

<!-- Calendar Modal -->
<div class="merge-calendar-modal-backdrop" id="mergeCalendarModalBackdrop" style="display:none;">
    <div class="merge-calendar-modal" id="mergeCalendarModal">
        <div class="merge-calendar-header">
            <button type="button" class="merge-calendar-prev"><svg width="22" height="22" viewBox="0 0 24 24">
                    <polyline points="9 19 16 12 9 5" fill="none" stroke="#111" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></polyline>
                </svg></button>
            <span id="mergeCalendarMonth"></span>
            <button type="button" class="merge-calendar-next"><svg width="22" height="22" viewBox="0 0 24 24">
                    <polyline points="15 19 8 12 15 5" fill="none" stroke="#111" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></polyline>
                </svg></button>
        </div>
        <div class="merge-calendar-days"></div>
        <button class="merge-calendar-done-btn" type="button">Done</button>
    </div>
</div>

<script>
// Calendar logic
let mergeDateTargetBtn = null;
let mergeCalendarMonth = null;
let mergeSelectedCalendarDate = null;

function mergeDaysInMonth(year, month) {
    return new Date(year, month + 1, 0).getDate();
}
// Show modal on button click
$('#resched_date_label, #mergeMergingDateBtn').click(function(e) {
    e.preventDefault();
    mergeDateTargetBtn = $(this);
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
$('.merge-calendar-done-btn').click(function() {
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
$('#mergeCalendarModalBackdrop').click(function(e) {
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
</script>