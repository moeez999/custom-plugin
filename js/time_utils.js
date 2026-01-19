/**
 * Centralized Time Formatting Utilities
 * 
 * This file contains all time formatting functions used across the custom plugin.
 * Import this file in your HTML/PHP files to use these functions.
 * 
 * Usage:
 *   <script src="js/time_utils.js"></script>
 *   Then use: fmt12(540) // Returns "9:00 AM"
 */

/**
 * Pad a number with leading zero if needed (for minutes/seconds)
 * @param {number} n - Number to pad
 * @returns {string} - Padded string (e.g., "05" for 5)
 */
function pad2(n) {
    return String(n).padStart(2, '0');
}

/**
 * Convert minutes from midnight to 12-hour format string (HH:MM AM/PM)
 * @param {number} min - Minutes from midnight (e.g., 540 for 9:00 AM)
 * @returns {string} - Formatted time string (e.g., "9:00 AM")
 */
function fmt12(min) {
    if (typeof min !== 'number' || isNaN(min)) {
        console.warn('fmt12: Invalid input', min);
        return '12:00 AM';
    }
    let h = Math.floor(min / 60);
    let m = min % 60;
    // Normalize hours to 0-23 range for display (don't wrap beyond 24)
    h = h % 24;
    // When h >= 12: PM, when h < 12: AM
    const ap = h >= 12 ? "PM" : "AM";
    const dispH = h % 12 || 12;
    return `${dispH}:${pad2(m)} ${ap}`;
}

/**
 * Convert time string (HH:MM or HH:MM AM/PM) to minutes from midnight
 * @param {string} hhmm - Time string in format "HH:MM" or "H:MM AM/PM" (e.g., "09:30" or "9:30 AM")
 * @returns {number} - Minutes from midnight (e.g., 570 for "09:30" or "9:30 AM")
 */
function minutes(hhmm) {
    // If input is already a number (minutes from midnight), return it as-is
    if (typeof hhmm === 'number' && !isNaN(hhmm)) {
        return hhmm;
    }
    
    // Handle null, undefined, or non-string inputs
    if (hhmm === null || hhmm === undefined || typeof hhmm !== 'string') {
        // Silently return 0 for null/undefined to avoid console spam
        return 0;
    }
    
    const trimmed = hhmm.trim();
    
    // Handle empty strings
    if (!trimmed) {
        return 0;
    }
    
    // Check if it's in 12-hour format (contains AM/PM)
    const ampmMatch = trimmed.match(/(\d{1,2}):(\d{2})\s*([APap][Mm])$/);
    if (ampmMatch) {
        let h = parseInt(ampmMatch[1], 10);
        const m = parseInt(ampmMatch[2], 10);
        const period = ampmMatch[3].toUpperCase();
        
        if (isNaN(h) || isNaN(m)) {
            console.warn('minutes: Could not parse', hhmm);
            return 0;
        }
        
        // Convert 12-hour to 24-hour for calculation
        if (period === 'PM' && h !== 12) {
            h += 12;
        } else if (period === 'AM' && h === 12) {
            h = 0;
        }
        
        return h * 60 + m;
    }
    
    // Handle 24-hour format (HH:MM)
    const [h, m] = trimmed.split(":").map(Number);
    if (isNaN(h) || isNaN(m) || trimmed.split(":").length !== 2) {
        console.warn('minutes: Could not parse', hhmm);
        return 0;
    }
    return h * 60 + m;
}

/**
 * Convert 12-hour format time to 24-hour format
 * @param {string} time12h - Time in 12-hour format (e.g., "9:30 AM" or "09:30 PM")
 * @returns {string} - Time in 24-hour format (e.g., "09:30" or "21:30")
 */
function convert12hTo24h(time12h) {
    if (!time12h || typeof time12h !== 'string') {
        console.warn('convert12hTo24h: Invalid input', time12h);
        return '00:00';
    }
    
    // Handle different input formats
    const trimmed = time12h.trim();
    const match = trimmed.match(/^(\d{1,2}):(\d{2})\s*([APap][Mm])?$/);
    
    if (!match) {
        // Try splitting by space (e.g., "9:30 AM")
        const parts = trimmed.split(/\s+/);
        if (parts.length >= 2) {
            const [time, period] = parts;
            const [hours, minutes] = time.split(':');
            let h = parseInt(hours, 10);
            const m = minutes || '00';
            const p = period ? period.toUpperCase() : '';
            
            if (p === 'PM' && h < 12) {
                h += 12;
            } else if (p === 'AM' && h === 12) {
                h = 0;
            }
            
            return `${String(h).padStart(2, '0')}:${m}`;
        }
        console.warn('convert12hTo24h: Could not parse', time12h);
        return '00:00';
    }
    
    let h = parseInt(match[1], 10);
    const m = match[2] || '00';
    const period = match[3] ? match[3].toUpperCase() : '';
    
    if (period === 'PM' && h < 12) {
        h += 12;
    } else if (period === 'AM' && h === 12) {
        h = 0;
    }
    
    return `${String(h).padStart(2, '0')}:${m}`;
}

/**
 * Convert 24-hour format time to 12-hour format
 * @param {string} time24h - Time in 24-hour format (e.g., "09:30" or "21:30")
 * @returns {string} - Time in 12-hour format (e.g., "9:30 AM" or "9:30 PM")
 */
function convert24hTo12h(time24h) {
    if (!time24h || typeof time24h !== 'string') {
        console.warn('convert24hTo12h: Invalid input', time24h);
        return '12:00 AM';
    }
    
    const [hours, minutes] = time24h.split(':');
    if (!hours || !minutes) {
        console.warn('convert24hTo12h: Could not parse', time24h);
        return '12:00 AM';
    }
    
    let hour = parseInt(hours, 10);
    const minute = minutes;
    
    if (isNaN(hour)) {
        console.warn('convert24hTo12h: Invalid hour', hours);
        return '12:00 AM';
    }
    
    const period = hour >= 12 ? 'PM' : 'AM';
    hour = hour % 12;
    if (hour === 0) hour = 12;
    
    return `${hour}:${minute} ${period}`;
}

/**
 * Convert 24-hour format time to 12-hour format (returns object with time and period)
 * @param {string} hhmm - Time in 24-hour format or already 12-hour format (e.g., "09:30" or "9:30 AM")
 * @returns {object} - Object with {hm: "HH:MM", period: "AM|PM"}
 */
function to12h(hhmm) {
    if (!hhmm || typeof hhmm !== 'string') {
        console.warn('to12h: Invalid input', hhmm);
        return {hm: '12:00', period: 'AM'};
    }
    
    // expects "HH:MM" or "HH:MM AM/PM" and returns {hm:"hh:mm", period:"AM|PM"}
    let t = hhmm.trim().toUpperCase();
    if (/AM|PM/.test(t)) {
        // already 12h (e.g., "9:30 AM")
        let [hm, period] = t.split(/\s+/);
        let [h, m] = hm.split(':').map(s => s.padStart(2, '0'));
        return {
            hm: `${h}:${m}`,
            period: period
        };
    } else {
        // 24h -> 12h
        let [h, m] = t.split(':').map(Number);
        if (isNaN(h) || isNaN(m)) {
            console.warn('to12h: Could not parse', hhmm);
            return {hm: '12:00', period: 'AM'};
        }
        let period = h >= 12 ? 'PM' : 'AM';
        h = h % 12;
        if (h === 0) h = 12;
        return {
            hm: `${String(h).padStart(2, '0')}:${String(m).padStart(2, '0')}`,
            period: period
        };
    }
}

/**
 * Format time from Date object to 12-hour format
 * @param {Date} date - Date object
 * @returns {string} - Formatted time string (e.g., "9:30 AM")
 */
function formatTime12Hour(date) {
    if (!date || !(date instanceof Date) || isNaN(date.getTime())) {
        console.warn('formatTime12Hour: Invalid Date object', date);
        return '12:00 AM';
    }
    let hours = date.getHours();
    let minutes = date.getMinutes();
    const ampm = hours >= 12 ? 'PM' : 'AM';
    hours = hours % 12;
    hours = hours ? hours : 12; // the hour '0' should be '12'
    minutes = minutes < 10 ? '0' + minutes : minutes;
    return `${hours}:${minutes} ${ampm}`;
}

/**
 * Format time from hour and minute parts to 12-hour format
 * @param {number} hours - Hour (0-23)
 * @param {number} minutes - Minutes (0-59)
 * @returns {string} - Formatted time string (e.g., "9:30 AM")
 */
function formatTime12HourFromParts(hours, minutes) {
    if (typeof hours !== 'number' || isNaN(hours) || typeof minutes !== 'number' || isNaN(minutes)) {
        console.warn('formatTime12HourFromParts: Invalid input', hours, minutes);
        return '12:00 AM';
    }
    const ampm = hours >= 12 ? 'PM' : 'AM';
    hours = hours % 12;
    hours = hours ? hours : 12; // the hour '0' should be '12'
    minutes = minutes < 10 ? '0' + minutes : minutes;
    return `${hours}:${minutes} ${ampm}`;
}

/**
 * Convert time string to minutes from midnight (alias for minutes function)
 * @param {string} timeStr - Time string in format "HH:MM"
 * @returns {number} - Minutes from midnight
 */
function timeToMinutes(timeStr) {
    return minutes(timeStr);
}

/**
 * Convert minutes from midnight to time string in 24-hour format
 * @param {number} minutes - Minutes from midnight
 * @returns {string} - Time string in 24-hour format (e.g., "09:30")
 */
function minutesToTime(minutes) {
    if (typeof minutes !== 'number' || isNaN(minutes)) {
        console.warn('minutesToTime: Invalid input', minutes);
        return '00:00';
    }
    const h = Math.floor(minutes / 60) % 24;
    const m = minutes % 60;
    return `${String(h).padStart(2, '0')}:${String(m).padStart(2, '0')}`;
}

/**
 * Normalize time input to 12-hour format (handles various input formats)
 * @param {string} inputRaw - Time input in various formats
 * @returns {string|null} - Normalized time in "HH:MM AM/PM" format or null if invalid
 */
function normalizeTimeTo12h(inputRaw) {
    if (!inputRaw) return null;
    let s = String(inputRaw).trim().toLowerCase();

    // keep explicit am/pm, but standardize
    let ampmMatch = s.match(/(am|pm)$/);
    let explicit = ampmMatch ? ampmMatch[1] : null;
    if (explicit) {
        s = s.slice(0, -2);
    } // strip am/pm for parsing

    s = s.replace(/\s+/g, ""); // remove spaces
    s = s.replace(".", ":"); // allow "7.30" -> "7:30"

    let hStr, mStr;
    if (s.includes(":")) {
        [hStr, mStr] = s.split(":");
    } else if (/^\d+$/.test(s)) {
        // "7" -> 7:00, "730"/"0730" -> 7:30, "1330" -> 13:30
        if (s.length <= 2) {
            hStr = s;
            mStr = "00";
        } else {
            hStr = s.slice(0, s.length - 2);
            mStr = s.slice(-2);
        }
    } else {
        return null;
    }

    let h = parseInt(hStr, 10);
    let m = parseInt(mStr || "0", 10);
    if (isNaN(h) || isNaN(m) || h < 0 || m < 0 || m > 59) return null;

    // Resolve AM/PM
    let ampm;
    if (explicit) {
        ampm = explicit.toUpperCase();
        if (h === 0) h = 12; // "0am" => 12 AM
        if (h < 1 || h > 12) return null; // invalid in explicit 12h
    } else {
        if (h > 23) return null; // invalid 24h
        if (h === 0) {
            ampm = "AM";
            h = 12;
        } else if (h === 12) {
            ampm = "PM";
        } else if (h > 12) {
            ampm = "PM";
            h = h - 12;
        } else {
            ampm = "AM";
        }
    }

    const hh = (h < 10 ? "0" : "") + h;
    const mm = (m < 10 ? "0" : "") + m;
    return `${hh}:${mm} ${ampm}`;
}

// Export functions to global scope for backward compatibility
if (typeof window !== 'undefined') {
    window.fmt12 = fmt12;
    window.pad2 = pad2;
    window.minutes = minutes;
    window.convert12hTo24h = convert12hTo24h;
    window.convert24hTo12h = convert24hTo12h;
    window.to12h = to12h;
    window.formatTime12Hour = formatTime12Hour;
    window.formatTime12HourFromParts = formatTime12HourFromParts;
    window.timeToMinutes = timeToMinutes;
    window.minutesToTime = minutesToTime;
    window.normalizeTimeTo12h = normalizeTimeTo12h;
}

