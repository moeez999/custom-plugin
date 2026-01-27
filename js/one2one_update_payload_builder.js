/**
 * One2One Update Payload Builder
 * 
 * Builds update payloads for 1:1 lesson updates based on the actual API response structure.
 * Handles THIS_OCCURRENCE and THIS_AND_FOLLOWING scopes dynamically.
 * 
 * API Response Structure:
 * {
 *   event: {
 *     eventid, googlemeetid, eventdate, start_time, end_time, duration_minutes, classType
 *   },
 *   summary: {
 *     current: { teacher: { id }, start_time, end_time, status }
 *   }
 * }
 */

(function(global) {
    'use strict';

    /**
     * Extract event data from API response structure
     * @param {Object} eventData - Event data from API (can be window.currentEventData or normalized)
     * @returns {Object} Normalized event data
     */
    function extractEventData(eventData) {
        if (!eventData) return null;

        // Handle nested API structure (event.eventid) or flat structure (eventid)
        const event = eventData.event || eventData;
        const summary = eventData.summary || {};

        return {
            eventId: parseInt(event.eventid || event.id || event.eventId || 0, 10),
            googlemeetid: parseInt(event.googlemeetid || event.googlemeetId || event.cmid || 0, 10),
            date: event.eventdate || event.date || event.eventDate || null,
            start: event.start_time || event.start || summary.current?.start_time || null,
            end: event.end_time || event.end || summary.current?.end_time || null,
            duration: parseInt(event.duration_minutes || event.duration || 0, 10),
            classType: event.classType || event.class_type || 'single',
            teacherId: parseInt(
                summary.current?.teacher?.id || 
                event.teacherId || 
                event.teacher_id || 
                event.teacherid || 
                0, 
            10),
            studentids: event.studentids || (event.student?.id ? [parseInt(event.student.id, 10)] : []),
            studentnames: event.studentnames || (event.student?.name ? [event.student.name] : [])
        };
    }

    /**
     * Normalize date to YYYY-MM-DD format
     * @param {string} date - Date string (may include time)
     * @returns {string} Normalized date
     */
    function normalizeDate(date) {
        if (!date) return null;
        if (date.includes('T')) {
            return date.split('T')[0];
        }
        return date;
    }

    /**
     * Convert 12-hour time to 24-hour format
     * @param {string} time12h - Time in 12h format (e.g., "1:00 PM")
     * @returns {string} Time in 24h format (e.g., "13:00")
     */
    function convert12hTo24h(time12h) {
        if (!time12h) return null;
        
        // If already in 24h format, return as is
        if (!time12h.includes(' ') && time12h.match(/^\d{1,2}:\d{2}$/)) {
            return time12h;
        }

        const parts = time12h.trim().split(' ');
        if (parts.length < 2) return time12h; // Assume 24h if no AM/PM

        const [time, period] = parts;
        const [hours, minutes] = time.split(':').map(Number);
        
        let hour24 = hours;
        if (period.toUpperCase() === 'PM' && hours < 12) {
            hour24 = hours + 12;
        } else if (period.toUpperCase() === 'AM' && hours === 12) {
            hour24 = 0;
        }

        return `${String(hour24).padStart(2, '0')}:${String(minutes).padStart(2, '0')}`;
    }

    /**
     * Find the day in weekly lesson days that matches the clicked event's date
     * @param {Array} days - Array of day objects with {day, date, start, end}
     * @param {string} targetDate - The date to match (YYYY-MM-DD)
     * @param {Object} originalEventData - Original event data for day-of-week fallback
     * @returns {Object|null} Matching day object or null
     */
    function findMatchingDay(days, targetDate, originalEventData) {
        if (!days || days.length === 0 || !targetDate) return null;

        const normalizedTarget = normalizeDate(targetDate);

        // First, try exact date match
        let matchedDay = days.find(day => {
            if (!day.date) return false;
            return normalizeDate(day.date) === normalizedTarget;
        });

        if (matchedDay) return matchedDay;

        // If no exact match, try matching by day of week
        if (originalEventData) {
            const targetDateObj = new Date(normalizedTarget + 'T00:00:00Z');
            const targetDayOfWeek = targetDateObj.getUTCDay();
            
            const dayOfWeekMap = {
                0: 'Sun', 1: 'Mon', 2: 'Tue', 3: 'Wed', 4: 'Thu', 5: 'Fri', 6: 'Sat'
            };
            const targetDayName = dayOfWeekMap[targetDayOfWeek];

            const dayNameMap = {
                'M': 'Mon', 'T': 'Tue', 'W': 'Wed', 'Th': 'Thu', 
                'F': 'Fri', 'Sa': 'Sat', 'Su': 'Sun'
            };

            matchedDay = days.find(day => {
                const dayName = day.day || '';
                const normalizedDayName = dayName.length <= 2 ? 
                    (dayNameMap[dayName] || dayName) : 
                    dayName;
                return normalizedDayName === targetDayName || 
                       normalizedDayName === targetDayName.substring(0, 3);
            });
        }

        return matchedDay || null;
    }

    /**
     * Detect time change for single lesson
     * @param {Object} formData - Form data with singleLesson
     * @param {Object} originalEvent - Original event data
     * @returns {Object} {timeChanged, newStartTime, newEndTime}
     */
    function detectSingleLessonTimeChange(formData, originalEvent) {
        const result = {
            timeChanged: false,
            newStartTime: null,
            newEndTime: null
        };

        if (!formData.singleLesson || !formData.singleLesson.time) {
            return result;
        }

        const timeStr = formData.singleLesson.time;
        const time24h = convert12hTo24h(timeStr);
        
        if (!time24h) return result;

        const [startHour, startMin] = time24h.split(':').map(Number);
        const duration = formData.singleLesson.duration || 60;
        const endMin = startMin + duration;
        const endHour = startHour + Math.floor(endMin / 60);
        const endMinFinal = endMin % 60;

        result.newStartTime = `${String(startHour).padStart(2, '0')}:${String(startMin).padStart(2, '0')}`;
        result.newEndTime = `${String(endHour).padStart(2, '0')}:${String(endMinFinal).padStart(2, '0')}`;

        // Compare with original times
        if (originalEvent && originalEvent.start && originalEvent.end) {
            const origStart24h = originalEvent.start.includes(' ') ? 
                convert12hTo24h(originalEvent.start) : originalEvent.start;
            const origEnd24h = originalEvent.end.includes(' ') ? 
                convert12hTo24h(originalEvent.end) : originalEvent.end;
            
            result.timeChanged = (origStart24h !== result.newStartTime || origEnd24h !== result.newEndTime);
        } else {
            result.timeChanged = true;
        }

        return result;
    }

    /**
     * Detect time change for weekly lesson
     * @param {Object} formData - Form data with weeklyLesson
     * @param {Object} originalEvent - Original event data
     * @param {string} scope - Update scope (THIS_OCCURRENCE or THIS_AND_FOLLOWING)
     * @returns {Object} {timeChanged, newStartTime, newEndTime}
     */
    function detectWeeklyLessonTimeChange(formData, originalEvent, scope) {
        const result = {
            timeChanged: false,
            newStartTime: null,
            newEndTime: null
        };

        if (!formData.weeklyLesson || !formData.weeklyLesson.days || formData.weeklyLesson.days.length === 0) {
            return result;
        }

        const days = formData.weeklyLesson.days;
        let dayToUse = null;

        // For THIS_OCCURRENCE, find the day matching the clicked event's date
        if (scope === 'THIS_OCCURRENCE' && originalEvent && originalEvent.date) {
            dayToUse = findMatchingDay(days, originalEvent.date, originalEvent);
        }

        // Fallback to first day if no match found
        if (!dayToUse) {
            dayToUse = days[0];
        }

        if (!dayToUse || !dayToUse.start || !dayToUse.end) {
            return result;
        }

        const start24h = convert12hTo24h(dayToUse.start);
        const end24h = convert12hTo24h(dayToUse.end);

        if (!start24h || !end24h) {
            return result;
        }

        result.newStartTime = start24h;
        result.newEndTime = end24h;

        // Compare with original times
        if (originalEvent && originalEvent.start && originalEvent.end) {
            const origStart24h = originalEvent.start.includes(' ') ? 
                convert12hTo24h(originalEvent.start) : originalEvent.start;
            const origEnd24h = originalEvent.end.includes(' ') ? 
                convert12hTo24h(originalEvent.end) : originalEvent.end;
            
            result.timeChanged = (origStart24h !== result.newStartTime || origEnd24h !== result.newEndTime);
        } else {
            result.timeChanged = true;
        }

        return result;
    }

    /**
     * Detect teacher change
     * @param {Object} formData - Form data
     * @param {Object} originalEvent - Original event data
     * @returns {boolean} Whether teacher changed
     */
    function detectTeacherChange(formData, originalEvent) {
        if (!formData.changeTeacher || !formData.newTeacherId) {
            return false;
        }

        const originalTeacherId = originalEvent?.teacherId || formData.teacherId || null;
        const newTeacherId = parseInt(formData.newTeacherId, 10);

        return originalTeacherId && parseInt(originalTeacherId, 10) !== newTeacherId;
    }

    /**
     * Detect date change for single lesson
     * @param {Object} formData - Form data with singleLesson
     * @param {Object} originalEvent - Original event data
     * @returns {Object} {dateChanged, newDate}
     */
    function detectSingleLessonDateChange(formData, originalEvent) {
        const result = {
            dateChanged: false,
            newDate: null
        };

        if (!formData.singleLesson || !formData.singleLesson.date) {
            return result;
        }

        result.newDate = normalizeDate(formData.singleLesson.date);
        const originalDate = normalizeDate(originalEvent?.date);

        result.dateChanged = result.newDate !== originalDate;

        return result;
    }

    /**
     * Detect date change for weekly lesson
     * @param {Object} formData - Form data with weeklyLesson
     * @param {Object} originalEvent - Original event data
     * @param {string} scope - Update scope
     * @returns {Object} {dateChanged, newDate}
     */
    function detectWeeklyLessonDateChange(formData, originalEvent, scope) {
        const result = {
            dateChanged: false,
            newDate: null
        };

        // For THIS_AND_FOLLOWING, don't check date changes
        if (scope !== 'THIS_OCCURRENCE') {
            return result;
        }

        if (!formData.weeklyLesson || !formData.weeklyLesson.days || formData.weeklyLesson.days.length === 0) {
            return result;
        }

        const days = formData.weeklyLesson.days;
        const originalDate = normalizeDate(originalEvent?.date);

        // Find the day matching the clicked event's date
        let dayToUse = findMatchingDay(days, originalDate, originalEvent);

        // Fallback to first day
        if (!dayToUse) {
            dayToUse = days[0];
        }

        if (dayToUse && dayToUse.date) {
            result.newDate = normalizeDate(dayToUse.date);
            result.dateChanged = result.newDate !== originalDate;
        }

        return result;
    }

    /**
     * Build THIS_OCCURRENCE payload
     * @param {Object} params - Parameters
     * @param {number} params.eventId - Event ID
     * @param {number} params.googlemeetid - Google Meet ID
     * @param {boolean} params.timeChanged - Whether time changed
     * @param {boolean} params.teacherChanged - Whether teacher changed
     * @param {boolean} params.dateChanged - Whether date changed
     * @param {string} params.newStartTime - New start time (HH:MM)
     * @param {string} params.newEndTime - New end time (HH:MM)
     * @param {number} params.originalTeacherId - Original teacher ID
     * @param {number} params.newTeacherId - New teacher ID
     * @param {string} params.newDate - New date (YYYY-MM-DD)
     * @param {string} params.originalDate - Original date (YYYY-MM-DD)
     * @returns {Object} Payload object
     */
    function buildThisOccurrencePayload(params) {
        const {
            eventId,
            googlemeetid,
            timeChanged,
            teacherChanged,
            dateChanged,
            newStartTime,
            newEndTime,
            originalTeacherId,
            newTeacherId,
            newDate,
            originalDate
        } = params;

        const payload = {
            scope: 'THIS_OCCURRENCE',
            eventId: parseInt(eventId, 10),
            googlemeetid: parseInt(googlemeetid, 10),
            apply: {
                time: false,
                teacher: false,
                status: false,
                days: false,
                period: false,
                end: false,
                date: false
            }
        };

        // Determine if this is ONLY time change or time + other changes
        const isOnlyTimeChange = timeChanged && !teacherChanged && !dateChanged;
        const hasMultipleChanges = (timeChanged ? 1 : 0) + (teacherChanged ? 1 : 0) + (dateChanged ? 1 : 0) > 1;

        // Add time data
        if (timeChanged && newStartTime && newEndTime) {
            payload.apply.time = true;
            
            // If ONLY time changes, use "current" object
            // If time changes WITH other fields, use "time" object
            if (isOnlyTimeChange) {
                payload.current = {
                    start: newStartTime,
                    end: newEndTime
                };
            } else {
                payload.time = {
                    start: newStartTime,
                    end: newEndTime
                };
            }
        }

        // Add teacher data
        if (teacherChanged && originalTeacherId && newTeacherId) {
            payload.apply.teacher = true;
            payload.teacher = {
                old: parseInt(originalTeacherId, 10),
                new: parseInt(newTeacherId, 10)
            };
        }

        // Add date data
        if (dateChanged && newDate) {
            payload.apply.date = true;
            payload.date = {
                new: normalizeDate(newDate)
            };

            // Add anchorDate (original date) when date changes
            if (originalDate) {
                payload.anchorDate = normalizeDate(originalDate);
            }
        }

        return payload;
    }

    /**
     * Main function to build update payload
     * @param {Object} formData - Form data
     * @param {Object} originalEventData - Original event data (from API response)
     * @param {string} scope - Update scope (THIS_OCCURRENCE or THIS_AND_FOLLOWING)
     * @returns {Object} Payload object
     */
    function buildUpdatePayload(formData, originalEventData, scope) {
        // Extract normalized event data
        const originalEvent = extractEventData(originalEventData);
        
        if (!originalEvent) {
            throw new Error('Original event data is required');
        }

        // Detect changes based on lesson type
        let timeChange = { timeChanged: false, newStartTime: null, newEndTime: null };
        let dateChange = { dateChanged: false, newDate: null };
        let teacherChanged = false;

        if (formData.lessonType === 'single') {
            timeChange = detectSingleLessonTimeChange(formData, originalEvent);
            dateChange = detectSingleLessonDateChange(formData, originalEvent);
        } else if (formData.lessonType === 'weekly') {
            timeChange = detectWeeklyLessonTimeChange(formData, originalEvent, scope);
            dateChange = detectWeeklyLessonDateChange(formData, originalEvent, scope);
        }

        teacherChanged = detectTeacherChange(formData, originalEvent);

        // Build payload based on scope
        if (scope === 'THIS_OCCURRENCE') {
            return buildThisOccurrencePayload({
                eventId: originalEvent.eventId,
                googlemeetid: originalEvent.googlemeetid,
                timeChanged: timeChange.timeChanged,
                teacherChanged: teacherChanged,
                dateChanged: dateChange.dateChanged,
                newStartTime: timeChange.newStartTime,
                newEndTime: timeChange.newEndTime,
                originalTeacherId: originalEvent.teacherId,
                newTeacherId: formData.newTeacherId,
                newDate: dateChange.newDate,
                originalDate: originalEvent.date
            });
        } else {
            // THIS_AND_FOLLOWING - return null as it should be handled separately
            // This function focuses on THIS_OCCURRENCE
            return null;
        }
    }

    // Export to global scope
    global.One2OneUpdatePayloadBuilder = {
        extractEventData,
        buildUpdatePayload,
        detectSingleLessonTimeChange,
        detectWeeklyLessonTimeChange,
        detectTeacherChange,
        detectSingleLessonDateChange,
        detectWeeklyLessonDateChange,
        buildThisOccurrencePayload,
        normalizeDate,
        convert12hTo24h,
        findMatchingDay
    };

})(window);
