<style>
/* Calendar Modal Styles for Reschedule */
.reschedule_calendar_modal_backdrop {
    display: none;
    position: fixed;
    z-index: 9999 !important;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background: rgba(0, 0, 0, 0.5);
    align-items: center;
    justify-content: center;
}

.reschedule_calendar_modal {
    background: #fff;
    border-radius: 17px;
    box-shadow: 0 8px 30px 0 rgba(0, 0, 0, .13);
    width: 340px;
    max-width: 96vw;
    padding: 0 0 24px 0;
    position: relative;
    animation: fadeIn .18s;
}

@keyframes fadeIn {
    from { opacity: 0; }
    to { opacity: 1; }
}

.reschedule_calendar_header {
    display: flex;
    align-items: center;
    justify-content: space-between;
    padding: 20px 24px 16px;
    font-weight: 700;
    font-size: 1.14rem;
    color: #111;
}

.reschedule_calendar_prev,
.reschedule_calendar_next {
    background: #f4f5f8;
    border: 1px solid #e3e4ed;
    width: 36px;
    height: 36px;
    border-radius: 8px;
    display: flex;
    align-items: center;
    justify-content: center;
    cursor: pointer;
    transition: all .14s;
}

.reschedule_calendar_prev:hover,
.reschedule_calendar_next:hover {
    background: #e8eaf0;
}

.reschedule_calendar_prev svg {
    transform: rotate(180deg);
}

.reschedule_calendar_days {
    display: grid;
    grid-template-columns: repeat(7, 1fr);
    gap: 4px;
    padding: 0 16px;
}

.reschedule_calendar_day_header {
    text-align: center;
    font-size: 0.81rem;
    font-weight: 600;
    color: #8b90a0;
    padding: 8px 0;
}

.reschedule_calendar_day,
.reschedule_calendar_day_inactive {
    text-align: center;
    padding: 11px 0;
    border-radius: 9px;
    cursor: pointer;
    font-weight: 600;
    transition: all .12s;
    color: #1f2937;
}

.reschedule_calendar_day_inactive {
    color: #d1d5db;
    cursor: default;
}

.reschedule_calendar_day:hover {
    background: #f3f4f6;
}

.reschedule_calendar_day.selected {
    background: #fe2e0c;
    color: #fff;
}

.reschedule_calendar_done_btn {
    width: calc(100% - 32px);
    background: #fe2e0c;
    color: #fff;
    border: none;
    font-weight: 700;
    font-size: 1.05rem;
    border-radius: 10px;
    padding: 14px 0;
    margin: 20px 16px 0;
    cursor: pointer;
    transition: background .14s;
}

.reschedule_calendar_done_btn:hover {
    background: #e82a0b;
}

@media (max-width: 600px) {
    .reschedule_calendar_modal {
        width: 96vw;
        padding: 13px 1vw;
    }
}
</style>

<!-- Reschedule Calendar Modal -->
<div class="reschedule_calendar_modal_backdrop" id="rescheduleCalendarBackdrop">
    <div class="reschedule_calendar_modal" id="rescheduleCalendarModal">
        <div class="reschedule_calendar_header">
            <button type="button" class="reschedule_calendar_prev">
                <svg width="22" height="22" viewBox="0 0 24 24">
                    <polyline points="9 19 16 12 9 5" fill="none" stroke="#111" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></polyline>
                </svg>
            </button>
            <span id="rescheduleCalendarMonth"></span>
            <button type="button" class="reschedule_calendar_next">
                <svg width="22" height="22" viewBox="0 0 24 24">
                    <polyline points="15 19 8 12 15 5" fill="none" stroke="#111" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></polyline>
                </svg>
            </button>
        </div>
        <div class="reschedule_calendar_days"></div>
        <button class="reschedule_calendar_done_btn" type="button">Done</button>
    </div>
</div>

<script>
$(document).ready(function() {
    // Calendar variables
    let rescheduleCalendarTargetBtn = null;
    let rescheduleCalendarMonth = null;
    let rescheduleSelectedDate = null;

    function daysInMonth(year, month) {
        return new Date(year, month + 1, 0).getDate();
    }

    // Open calendar when clicking the date button
    $(document).on('click', '#resched_date_field, #resched_date_label', function(e) {
        e.preventDefault();
        e.stopPropagation();
        
        console.log('=== CALENDAR CLICK DEBUG ===');
        console.log('Event triggered on:', e.target);
        console.log('This element:', this);
        console.log('jQuery version:', $.fn.jquery);
        console.log('Clicked element ID:', $(this).attr('id'));
        
        // Check if backdrop exists
        const $backdrop = $('#rescheduleCalendarBackdrop');
        console.log('Backdrop found:', $backdrop.length);
        console.log('Backdrop element:', $backdrop[0]);
        console.log('Backdrop current display:', $backdrop.css('display'));
        console.log('Backdrop current visibility:', $backdrop.css('visibility'));
        console.log('Backdrop current opacity:', $backdrop.css('opacity'));
        
        // Store reference to update label later
        rescheduleCalendarTargetBtn = $('#resched_date_label');
        console.log('Target button set:', rescheduleCalendarTargetBtn.length);
        
        // Initialize calendar to current month
        let now = new Date();
        rescheduleCalendarMonth = {
            year: now.getFullYear(),
            month: now.getMonth()
        };
        rescheduleSelectedDate = null;
        
        console.log('Calendar month initialized:', rescheduleCalendarMonth);
        
        // Render and show
        console.log('Rendering calendar...');
        renderRescheduleCalendar();
        console.log('Calendar rendered');
        
        console.log('Showing backdrop...');
        $backdrop.css('display', 'flex').hide().fadeIn(150);
        console.log('FadeIn called');
        
        // Check again after 200ms
        setTimeout(function() {
            console.log('After fadeIn - display:', $backdrop.css('display'));
            console.log('After fadeIn - visibility:', $backdrop.css('visibility'));
            console.log('After fadeIn - is visible:', $backdrop.is(':visible'));
        }, 200);
        
        console.log('=== END DEBUG ===');
    });

    // Previous month
    $(document).on('click', '.reschedule_calendar_prev', function() {
        rescheduleCalendarMonth.month--;
        if (rescheduleCalendarMonth.month < 0) {
            rescheduleCalendarMonth.month = 11;
            rescheduleCalendarMonth.year--;
        }
        renderRescheduleCalendar();
    });

    // Next month
    $(document).on('click', '.reschedule_calendar_next', function() {
        rescheduleCalendarMonth.month++;
        if (rescheduleCalendarMonth.month > 11) {
            rescheduleCalendarMonth.month = 0;
            rescheduleCalendarMonth.year++;
        }
        renderRescheduleCalendar();
    });

    // Render calendar
    function renderRescheduleCalendar() {
        const monthNames = ["January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December"];
        let y = rescheduleCalendarMonth.year;
        let m = rescheduleCalendarMonth.month;
        
        $('#rescheduleCalendarMonth').text(`${monthNames[m]} ${y}`);
        
        let html = '';
        let dayHeaders = ['Mo', 'Tu', 'We', 'Th', 'Fr', 'Sa', 'Su'];
        
        // Day headers
        for (let d = 0; d < 7; d++) {
            html += `<div class="reschedule_calendar_day_header">${dayHeaders[d]}</div>`;
        }
        
        // Get first day of month (0=Sunday, adjust to Monday=0)
        let firstDay = new Date(y, m, 1).getDay();
        firstDay = (firstDay + 6) % 7;
        
        let totalDays = daysInMonth(y, m);
        
        // Inactive days before month starts
        for (let i = 0; i < firstDay; i++) {
            html += `<div class="reschedule_calendar_day_inactive"></div>`;
        }
        
        // Actual days
        for (let d = 1; d <= totalDays; d++) {
            let sel = rescheduleSelectedDate &&
                rescheduleSelectedDate.getFullYear() === y &&
                rescheduleSelectedDate.getMonth() === m &&
                rescheduleSelectedDate.getDate() === d ? ' selected' : '';
            html += `<div class="reschedule_calendar_day${sel}" data-day="${d}">${d}</div>`;
        }
        
        // Fill remaining cells
        let rem = (firstDay + totalDays) % 7;
        if (rem > 0) {
            for (let i = rem; i < 7; i++) {
                html += `<div class="reschedule_calendar_day_inactive"></div>`;
            }
        }
        
        $('.reschedule_calendar_days').html(html);
    }

    // Select a day
    $(document).on('click', '.reschedule_calendar_day', function() {
        $('.reschedule_calendar_day').removeClass('selected');
        $(this).addClass('selected');
        let day = parseInt($(this).attr('data-day'));
        rescheduleSelectedDate = new Date(rescheduleCalendarMonth.year, rescheduleCalendarMonth.month, day);
    });

    // Done button - update the date field
    $(document).on('click', '.reschedule_calendar_done_btn', function() {
        if (rescheduleSelectedDate && rescheduleCalendarTargetBtn) {
            let d = rescheduleSelectedDate;
            
            // Format: "Tue, Feb 11"
            const days = ['Sun', 'Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat'];
            const months = ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'];
            let formatted = `${days[d.getDay()]}, ${months[d.getMonth()]} ${String(d.getDate()).padStart(2, '0')}`;
            
            // Update button label
            rescheduleCalendarTargetBtn.text(formatted);
            
            // Update hidden input (used by existing code)
            $('#resched_date').val(formatted);
            
            // Close modal
            $('#rescheduleCalendarBackdrop').fadeOut(150);
            
            console.log('Date selected:', formatted);
        }
    });

    // Click outside to close
    $(document).on('click', '#rescheduleCalendarBackdrop', function(e) {
        if (e.target === this) {
            $(this).fadeOut(150);
        }
    });
});
</script>
