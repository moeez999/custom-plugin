<style>
#calendar_admin_agenda_content {
    background: #ffffff;
    padding: 0px 14px 7px 14px;
    max-height: 75vh;
    padding-top: 24px;
    padding-bottom: 48px;
    overflow-y: auto;
    overflow-x: hidden;
}

#calendar_admin_agenda_content::-webkit-scrollbar {
    width: 0px;
}

#calendar_admin_agenda_content::-webkit-scrollbar-track {
    background: #f1f1f1;
}

#calendar_admin_agenda_content::-webkit-scrollbar-thumb {
    background: #888;
}

#calendar_admin_agenda_content::-webkit-scrollbar-thumb:hover {
    background: #555;
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

/* Event color classes - match main calendar */
.calendar_admin_agenda_event_card.e-blue {
    --event-border-color: #7c96ff;
    border-color: var(--event-border-color);
    background: color-mix(in srgb, #7c96ff 10%, #ffffff);
}

.calendar_admin_agenda_event_card.e-green {
    --event-border-color: #2faa7f;
    border-color: var(--event-border-color);
    background: color-mix(in srgb, #2faa7f 10%, #ffffff);
}

.calendar_admin_agenda_event_card.e-purple {
    --event-border-color: #b535ff;
    border-color: rgba(181, 53, 255, 0.7) !important;
    background: color-mix(in srgb, #b535ff 10%, #ffffff) !important;
    border-bottom-color: rgba(181, 53, 255, 0.7) !important;
}

.calendar_admin_agenda_event_card.e-orange {
    --event-border-color: #ff8a06;
    border-color: rgba(255, 138, 6, 0.7) !important;
    background: color-mix(in srgb, #ff8a06 10%, #ffffff) !important;
    border-bottom-color: rgba(255, 138, 6, 0.7) !important;
}

.calendar_admin_agenda_event_card.e-timeoff {
    --event-border-color: rgba(253, 216, 48, 0.7);
    border-color: rgba(253, 216, 48, 0.7);
    background: color-mix(in srgb, #fdd830 10%, #ffffff);
}

/* Hover effect: slightly darken the background for each color class */
.calendar_admin_agenda_event_card:hover {
    filter: brightness(0.96);
    transition: filter 0.18s;
}

.calendar_admin_agenda_event_card.e-blue:hover {
    background: color-mix(in srgb, #7c96ff 18%, #ffffff);
}

.calendar_admin_agenda_event_card.e-green:hover {
    background: color-mix(in srgb, #2faa7f 18%, #ffffff);
}

.calendar_admin_agenda_event_card.e-purple:hover {
    background: color-mix(in srgb, #b535ff 18%, #ffffff) !important;
}

.calendar_admin_agenda_event_card.e-orange:hover {
    background: color-mix(in srgb, #ff8a06 18%, #ffffff) !important;
}

.calendar_admin_agenda_event_card.e-timeoff:hover {
    background: color-mix(in srgb, #fdd830 18%, #ffffff);
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

    </div>
</div>
<script>
// --- AGENDA VIEW FUNCTIONS ---

// Helper functions
function pad2(n) {
    return String(n).padStart(2, '0');
}

function fmt12(min) {
    let h = Math.floor(min / 60),
        m = min % 60;
    if (h >= 24) h -= 24;
    const ap = h >= 12 ? 'PM' : 'AM';
    const dispH = h % 12 || 12;
    return `${dispH}:${pad2(m)} ${ap}`;
}

function minutes(hhmm) {
    const [h, m] = hhmm.split(':').map(Number);
    return h * 60 + m;
}

function ymd(d) {
    return `${d.getFullYear()}-${pad2(d.getMonth() + 1)}-${pad2(d.getDate())}`;
}

function mondayOf(date) {
    const d = new Date(date.getFullYear(), date.getMonth(), date.getDate());
    const dow = (d.getDay() + 6) % 7;
    d.setDate(d.getDate() - dow);
    d.setHours(0, 0, 0, 0);
    return d;
}

// Get agenda data from window.events
function getAgendaData() {
    console.log('getAgendaData: window.events =', window.events);

    if (!window.events || window.events.length === 0) {
        console.log('No events available');
        return {};
    }

    // Get current week range
    const currentWeekStart = window.currentWeekStart || mondayOf(new Date());
    console.log('Current week start:', currentWeekStart);

    const weekDates = [];
    for (let i = 0; i < 7; i++) {
        const d = new Date(currentWeekStart);
        d.setDate(d.getDate() + i);
        weekDates.push(ymd(d));
    }
    console.log('Week dates:', weekDates);

    // Filter events for current week
    const weekEvents = window.events.filter(ev => {
        return weekDates.includes(ev.date);
    });
    console.log('Week events:', weekEvents);

    // Group events by date
    const eventsByDate = {};
    weekEvents.forEach(ev => {
        if (!eventsByDate[ev.date]) {
            eventsByDate[ev.date] = [];
        }
        eventsByDate[ev.date].push(ev);
    });

    // Sort events within each date by start time
    Object.keys(eventsByDate).forEach(dateStr => {
        eventsByDate[dateStr].sort((a, b) => {
            const startA = typeof a.start === 'string' ? minutes(a.start) : a.start;
            const startB = typeof b.start === 'string' ? minutes(b.start) : b.start;
            return startA - startB;
        });
    });

    console.log('Events by date:', eventsByDate);
    return eventsByDate;
}

// Render agenda view
function renderAgendaView() {
    console.log('renderAgendaView called');

    const $container = $('#calendar_admin_agenda_content .container-fluid');
    $container.empty();

    const eventsByDate = getAgendaData();
    const currentWeekStart = window.currentWeekStart || mondayOf(new Date());

    const dayNames = ['Sun', 'Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat'];

    // Check if there are any events
    const hasEvents = Object.keys(eventsByDate).length > 0;

    if (!hasEvents) {
        $container.append(`
            <div style="text-align: center; padding: 60px 20px; color: #888;">
                <div style="font-size: 48px; margin-bottom: 20px; opacity: 0.3;">📅</div>
                <div style="font-size: 20px; font-weight: 500; color: #666;">No events scheduled</div>
                <div style="font-size: 16px; margin-top: 8px; color: #999;">Select a teacher or cohort to view events</div>
            </div>
        `);
        return;
    }

    // Generate agenda for each day of the week
    for (let i = 0; i < 7; i++) {
        const d = new Date(currentWeekStart);
        d.setDate(d.getDate() + i);
        const dateStr = ymd(d);
        const dayName = dayNames[d.getDay()];
        const dateNum = d.getDate();

        const dayEvents = eventsByDate[dateStr] || [];

        // Skip days with no events
        if (dayEvents.length === 0) continue;

        // Create day section
        const $daySection = $(`
            <div class="row g-0 align-items-center calendar-meeting-items">
                <div class="col-2 col-sm-1 calendar_admin_agenda_daycol">
                    <div class="calendar_admin_agenda_date">${dateNum}</div>
                    <div class="calendar_admin_agenda_day">${dayName}</div>
                </div>
                <div class="col-10 col-sm-11" id="events-for-${dateStr}"></div>
            </div>
        `);

        $container.append($daySection);

        // Add events for this day
        const $eventsCol = $daySection.find(`#events-for-${dateStr}`);

        dayEvents.forEach(event => {
            const startTime = typeof event.start === 'string' ? event.start : fmt12(event.start);
            const endTime = typeof event.end === 'string' ? event.end : fmt12(event.end);

            // Get teacher color if available
            let teacherColorStyle = '';
            if (event.teacherId && typeof getTeacherColor === 'function') {
                const teacherColor = getTeacherColor(event.teacherId);
                teacherColorStyle = `border-left: 4px solid #2323232;`;
            }

            // Get color class
            const colorClass = event.color || 'e-blue';

            // Build event title - show student name for 1:1 classes
            let eventTitle = event.title;
            if ((event.classType === 'one2one_weekly' || event.classType === 'one2one_single') &&
                event.studentnames && event.studentnames.length > 0) {
                eventTitle = event.studentnames.join(', ');
            }

            // Get status icon (same logic as main calendar)
            let statusIconHTML = '';
            if (event.statuses && Array.isArray(event.statuses) && event.statuses.length > 0 &&
                typeof getActiveStatusMeta === 'function') {
                const statusMeta = getActiveStatusMeta(event.statuses);
                if (statusMeta && statusMeta.icon) {
                    statusIconHTML = `
                        <span style="display: inline-flex; align-items: center; margin-left: 8px;" title="${statusMeta.label || ''}">
                            <img src="${statusMeta.icon}" alt="${statusMeta.label || ''}" style="width: 16px; height: 16px; opacity: 0.85;">
                        </span>
                    `;
                }
            }

            // Create event card with color class
            const $eventCard = $(`
                <div class="calendar_admin_agenda_event_card ${colorClass}" 
                     style="${teacherColorStyle} cursor: pointer;"
                     data-event-id="${event.eventid || ''}"
                     data-cmid="${event.cmid || ''}"
                     data-class-type="${event.classType || ''}"
                     data-source="${event.source || ''}"
                     data-date="${dateStr}">
                    <span class="calendar_admin_agenda_time">${startTime} - ${endTime}</span>
                    <div style="flex: 1; display: flex; align-items: center; gap: 12px;">
                        ${event.avatar ? `
                            <img src="${event.avatar}" alt="" 
                                 style="width: 32px; height: 32px; border-radius: 50%; border: 2px solid #edecec;">
                        ` : ''}
                        <div style="flex: 1;">
                            <span class="calendar_admin_agenda_title">${eventTitle}</span>
                            ${event.studentnames && event.studentnames.length > 0 && 
                              event.classType !== 'one2one_weekly' && 
                              event.classType !== 'one2one_single' ? `
                                <div style="font-size: 13px; color: #888; margin-top: 2px; font-weight: 400;">
                                    ${event.studentnames.join(', ')}
                                </div>
                            ` : ''}
                        </div>
                    </div>
                    ${statusIconHTML}
                    ${event.repeat ? `
                        <span style="opacity: 0.6; margin-left: 8px;" title="Recurring event">
                            <img src="./img/ev-repeat.svg" alt="repeat" style="width: 16px; height: 16px;">
                        </span>
                    ` : ''}
                 
                </div>
            `);

            $eventsCol.append($eventCard);
        });

        // Add separator line after each day except the last one
        const isLastDay = i === 6 || (i < 6 && !Object.keys(eventsByDate).some(date => {
            const checkDate = new Date(date);
            const nextDayStart = new Date(d);
            nextDayStart.setDate(nextDayStart.getDate() + 1);
            return checkDate >= nextDayStart;
        }));

        if (!isLastDay) {
            $container.append('<hr class="calendar_admin_agenda_hr">');
        }
    }

    // Add click handlers for event cards
    setupAgendaEventHandlers();
}

// Setup click handlers for agenda event cards
function setupAgendaEventHandlers() {
    console.log('Setting up agenda event handlers');

    // Remove any existing handlers first
    $(document).off('click', '.calendar_admin_agenda_event_card');

    // Add click handler for agenda event cards
    $(document).on('click', '.calendar_admin_agenda_event_card', function(e) {
        e.preventDefault();
        e.stopPropagation();

        console.log('Agenda event card clicked');

        const $card = $(this);
        const eventId = $card.data('event-id');
        const cmid = $card.data('cmid');
        const classType = $card.data('class-type');
        const source = $card.data('source');
        const dateStr = $card.data('date');

        console.log('Event data:', {
            eventId,
            cmid,
            classType,
            source,
            dateStr
        });

        // Find the full event data from window.events
        if (window.events && window.events.length > 0) {
            let eventData = null;

            // Try to find exact match by eventid and date
            if (eventId) {
                eventData = window.events.find(ev =>
                    ev.eventid === eventId && ev.date === dateStr
                );
            }

            // If not found by eventid, try by cmid
            if (!eventData && cmid) {
                eventData = window.events.find(ev =>
                    ev.cmid === cmid && ev.date === dateStr
                );
            }

            // If still not found, try by date and other properties
            if (!eventData) {
                eventData = window.events.find(ev =>
                    ev.date === dateStr &&
                    ev.classType === classType &&
                    (ev.source === source || ev.classType === source)
                );
            }

            console.log('Found event data:', eventData);

            if (eventData) {
                // Store the current event data globally (needed for dropdown menu)
                window.currentClickedEvent = eventData;

                // === REPLICATE EXACT MAIN CALENDAR LOGIC ===

                // 1. Teacher time off: open Time Off modal
                if (classType === 'teacher_timeoff' || source === 'teacher_timeoff') {
                    console.log('Opening Time Off modal for teacher busy time');
                    if (typeof window.openTimeOffModal === 'function') {
                        window.openTimeOffModal(eventData);
                    }
                    return;
                }

                // 2. Check if event is cancelled (cancel_no_makeup) - show reason modal
                const activeStatus = typeof getActiveStatusMeta === 'function' ?
                    getActiveStatusMeta(eventData.statuses || []) :
                    null;
                console.log('Active status for clicked event:', activeStatus, 'Statuses:', eventData.statuses);

                if (activeStatus && activeStatus.code === 'cancel_no_makeup') {
                    console.log('Opening Reason of Cancellation modal for cancelled event', eventData);
                    if (typeof window.openReasonOfCancellationModal === 'function') {
                        window.openReasonOfCancellationModal(eventData);
                    } else {
                        console.error('openReasonOfCancellationModal function not found');
                    }
                    return;
                }

                // 3. Check if it's a peertalk event
                if (classType === 'peertalk' || source === 'peertalk') {
                    console.log('Opening PeerTalk modal for event:', eventData);
                    if (typeof window.openPeerTalkModalWithData === 'function') {
                        window.openPeerTalkModalWithData(eventData);
                    }
                    return;
                }

                // 4. Check if it's a conference event
                if (classType === 'conference' || source === 'conference') {
                    console.log('Opening Conference modal for event:', eventData);
                    if (typeof window.openConferenceModalWithData === 'function') {
                        window.openConferenceModalWithData(eventData);
                    }
                    return;
                }

                // 5. Check if it's NOT a 1:1 lesson (for regular group lessons)
                if (classType !== 'one2one_weekly' && classType !== 'one2one_single') {
                    console.log('Opening menu dropdown for group lesson');
                    // This is a group lesson, open the dropdown menu
                    if (typeof window.openMenuOptionsDropdown === 'function') {
                        window.openMenuOptionsDropdown(e, $card[0]);
                    } else {
                        console.error('openMenuOptionsDropdown function not found');
                    }
                    return;
                }

                // 6. If it's a 1:1 lesson, create a synthetic event to trigger the lesson info handler
                if (classType === 'one2one_weekly' || classType === 'one2one_single') {
                    console.log('Creating synthetic event for 1:1 lesson to trigger lesson info handler');

                    // Convert time format from HH:MM to minutes from midnight
                    function timeToMinutes(timeStr) {
                        if (!timeStr) return 540;
                        const parts = timeStr.split(':');
                        return parseInt(parts[0]) * 60 + parseInt(parts[1]);
                    }

                    const startMins = timeToMinutes(eventData.start);
                    const endMins = timeToMinutes(eventData.end);

                    // Create a synthetic event element with all data attributes
                    const $syntheticEvent = $('<div class="event e-green" style="display:none;"></div>')
                        .attr('data-date', eventData.date)
                        .attr('data-start', String(startMins).padStart(4, '0'))
                        .attr('data-end', String(endMins).padStart(4, '0'))
                        .attr('data-title', eventData.title)
                        .attr('data-teacher-id', eventData.teacherId)
                        .attr('data-event-id', eventData.eventid)
                        .attr('data-cm-id', eventData.cmid)
                        .attr('data-googlemeet-id', eventData.googlemeetid || eventData.cmid)
                        .attr('data-class-type', eventData.classType)
                        .attr('data-repeat', eventData.repeat ? 'true' : 'false')
                        .attr('data-student-ids', (eventData.studentids || []).join(','))
                        .attr('data-student-names', (eventData.studentnames || []).join(','))
                        .attr('data-cohort-ids', (eventData.cohortids || []).join(','))
                        .attr('data-avatar', eventData.avatar ||
                            'https://randomuser.me/api/portraits/men/32.jpg');

                    // Add title element for student name extraction
                    $syntheticEvent.append($('<span class="ev-title"></span>').text(
                        eventData.studentnames && eventData.studentnames.length > 0 ?
                        eventData.studentnames[0] :
                        eventData.title
                    ));

                    // Append to body temporarily
                    $('body').append($syntheticEvent);

                    // Wait for the .event.e-green handler to be attached
                    let attempts = 0;
                    const maxAttempts = 50; // 2.5 seconds max wait

                    function triggerClickWhenReady() {
                        attempts++;

                        // After max attempts, trigger anyway
                        if (attempts > maxAttempts) {
                            console.warn('Event handler not ready after max attempts, triggering anyway');
                        }

                        // Try to click
                        $syntheticEvent.click();

                        // Remove the synthetic element after a short delay
                        setTimeout(function() {
                            $syntheticEvent.remove();
                        }, 100);
                    }

                    // Small delay to ensure handlers are ready
                    setTimeout(triggerClickWhenReady, 100);

                    return;
                }

            } else {
                console.warn('Could not find event data for clicked card');
            }
        } else {
            console.warn('No events available in window.events');
        }
    });
}

// Expose function globally so calendar can trigger updates
window.refreshAgendaView = function() {
    console.log('refreshAgendaView called, visible:', $('#calendar_admin_agenda_content').is(':visible'));
    if ($('#calendar_admin_agenda_content').is(':visible')) {
        renderAgendaView();
    }
};

// Initial setup
$(function() {
    console.log('Agenda view script initialized');

    // Clear any existing content on load
    $('#calendar_admin_agenda_content .container-fluid').empty();

    // Listen for calendar events updates
    $(document).on('calendarEventsUpdated', function() {
        console.log('calendarEventsUpdated event received');
        if ($('#calendar_admin_agenda_content').is(':visible')) {
            renderAgendaView();
        }
    });
});
</script>