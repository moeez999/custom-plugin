/**
 * Event Icon Utilities
 * 
 * Centralized utility for rendering icons on calendar events based on type and status.
 * This optimizes icon rendering by using lookup maps and reducing conditional logic.
 * 
 * Usage:
 *   <script src="js/event_icon_utils.js"></script>
 *   const iconHtml = EventIconUtils.renderEventIcons(event, options);
 */

(function (global) {
    'use strict';

    // ===== ICON CONFIGURATION MAPS =====

    /**
     * Map of status codes to icon metadata
     * @type {Object<string, {icon: string, label: string}>}
     */
    const STATUS_ICON_MAP = {
        scheduled: { icon: "./img/confirmed.svg", label: "Taught" },
        cancel: { icon: "./img/cancelled.svg", label: "Cancelled" },
        cancel_no_makeup: { icon: "./img/cancelled.svg", label: "Cancelled (No Makeup)" },
        cancel_reschedule_later: { icon: "./img/rescheduled.svg", label: "Cancelled (Reschedule Later)" },
        reschedule_instant: { icon: "./img/rescheduled.svg", label: "Rescheduled" },
        rescheduled: { icon: "./img/rescheduled.svg", label: "Rescheduled" },
        reschedule_one2one: { icon: "./img/rescheduled.svg", label: "Rescheduled 1:1" },
        covered: { icon: "./img/covered.svg", label: "Covered" },
        missed: { icon: "./img/missed.svg", label: "Missed" },
        pendingconfirmation: { icon: "./img/pendingconfirmation.svg", label: "Pending Confirmation" },
        pending_confirmation: { icon: "./img/pendingconfirmation.svg", label: "Pending Confirmation" },
        makeup: { icon: "./img/makeup.svg", label: "Makeup" },
        make_up: { icon: "./img/makeup.svg", label: "Makeup" }
    };

    /**
     * Map of event types to type-specific icons
     * @type {Object<string, {icon: string, label: string, class: string}>}
     */
    const TYPE_ICON_MAP = {
        one2one_weekly: { icon: "./img/single-lesson.svg", label: "Single Session", class: "ev-single" },
        one2one_single: { icon: "./img/single-lesson.svg", label: "Single Session", class: "ev-single" },
        repeat: { icon: "./img/ev-repeat.svg", label: "Repeats", class: "ev-repeat" },
        makeup: { icon: "./img/makeup.svg", label: "Make-up Class", class: "ev-makeup" },
        midnight: { icon: null, label: "Continues to next day", class: "ev-midnight-icon", symbol: "↪" }
    };

    /**
     * Special icon combinations for complex statuses
     * @type {Object<string, Array<{icon: string, label: string}>>}
     */
    const SPECIAL_STATUS_ICONS = {
        cancel_reschedule_later: [
            { icon: "./img/pendingconfirmation.svg", label: "Pending Confirmation" },
            { icon: "./img/cancelled.svg", label: "Cancelled" }
        ]
    };

    // ===== HELPER FUNCTIONS =====

    /**
     * Gets the active status metadata from an array of statuses
     * @param {Array} statuses - Array of status objects
     * @returns {{code: string, icon: string, label: string, statusObj: Object}|null}
     */
    function getActiveStatusMeta(statuses) {
        // If no explicit statuses, fall back to a default "scheduled" icon
        if (!Array.isArray(statuses) || statuses.length === 0) {
            const fallback = STATUS_ICON_MAP.scheduled;
            if (fallback) {
                return {
                    ...fallback,
                    code: 'scheduled',
                    statusObj: null
                };
            }
            return null;
        }

        // Filter active statuses first (same logic as original)
        const activeStatuses = statuses.filter((s) => s && s.isactive);
        const statusObj = activeStatuses.length
            ? activeStatuses[activeStatuses.length - 1]
            : statuses[statuses.length - 1];
        
        if (!statusObj) return null;
        
        // Check both 'code' and 'statuscode' properties (for compatibility)
        const statusCode = statusObj.code || statusObj.statuscode;
        if (!statusCode) return null;
        
        const code = String(statusCode).toLowerCase().trim();
        const direct = STATUS_ICON_MAP[code];

        if (direct) {
            return { ...direct, code, statusObj };
        }

        // Fallback for reschedule-related codes
        if (code.startsWith("reschedule")) {
            return { ...STATUS_ICON_MAP.rescheduled, code, statusObj };
        }

        // Return null if no match found
        return null;
    }

    /**
     * Renders a single icon HTML
     * @param {string} icon - Icon path or symbol
     * @param {string} label - Alt text/title
     * @param {string} className - CSS class
     * @param {Object} options - Additional options (size, style, etc.)
     * @returns {string} HTML string
     */
    function renderIcon(icon, label, className = '', options = {}) {
        const size = options.size || 16;
        const style = options.style || '';
        const wrapperClass = options.wrapperClass || '';
        const isSymbol = options.isSymbol || false;

        if (isSymbol) {
            return `<span class="${className}" title="${label}" aria-label="${label}" style="${style}">${icon}</span>`;
        }

        const wrapper = wrapperClass ? `<span class="${wrapperClass}">` : '';
        const wrapperClose = wrapperClass ? '</span>' : '';

        return `${wrapper}<span class="${className}" title="${label}" aria-label="${label}" style="${style}">
            <img src="${icon}" alt="${label}" style="width:${size}px; height:${size}px;">
        </span>${wrapperClose}`;
    }

    /**
     * Renders status icon(s) for an event
     * @param {Object} event - Event object
     * @param {Object} statusMeta - Pre-computed status metadata (optional, will compute if not provided)
     * @param {Object} options - Rendering options
     * @param {Date|string} currentWeekStart - Current week start date (for teacher change icon date formatting)
     * @returns {string} HTML string for status icons
     */
    function renderStatusIcons(event, statusMeta = null, options = {}, currentWeekStart = null) {
        const {
            hideForRescheduleCurrent = true,
            position = 'absolute',
            top = '6px',
            right = '6px',
            zIndex = 2
        } = options;

        // Hide status icon for current reschedule events (makeup icon shows instead)
        if (hideForRescheduleCurrent && event.isRescheduleCurrent && !event.isTeacherChanged) {
            return '';
        }

        // Show teacher profile if teacher changed (this replaces status icon)
        // Also show covered.svg icon when teacher is changed
        if (event.isTeacherChanged) {
            const teacherIcon = renderTeacherChangeIcon(event, statusMeta, { position, top, right, size: 16 }, currentWeekStart);
            const coveredIcon = renderIcon(STATUS_ICON_MAP.covered.icon, STATUS_ICON_MAP.covered.label, '', { size: 16 });
            
            // Return both icons in a container - covered icon first, then teacher profile
            // Note: pointer-events:auto on teacher icon span allows tooltip interaction
            return `<span class="ev-status-icon" style="position:${position}; top:${top}; right:${right}; display:inline-flex; gap:4px; align-items:center; justify-content:flex-end; z-index:${zIndex};">
                ${coveredIcon}
                ${teacherIcon}
            </span>`;
        }

        // Get status meta if not provided
        if (!statusMeta) {
            statusMeta = getActiveStatusMeta(event.statuses);
        }
        if (!statusMeta) return '';

        // Handle special case: cancel_reschedule_later shows two icons
        if (statusMeta.code === 'cancel_reschedule_later' && SPECIAL_STATUS_ICONS[statusMeta.code]) {
            const icons = SPECIAL_STATUS_ICONS[statusMeta.code];
            const iconHtml = icons.map(iconData =>
                renderIcon(iconData.icon, iconData.label, '', { size: 16 })
            ).join('');

            return `<span class="ev-status-icon" style="position:${position}; top:${top}; right:${right}; display:inline-flex; gap:4px; align-items:center; justify-content:flex-end; pointer-events:none; z-index:${zIndex};">
                ${iconHtml}
            </span>`;
        }

        // Standard single status icon with history tooltip support
        // Add data attribute for history if available
        const hasHistory = event.history && Array.isArray(event.history) && event.history.length > 0;
        const tooltipId = hasHistory ? `status-history-tooltip-${Date.now()}-${Math.random().toString(36).substr(2, 9)}` : '';
        
        return `<span class="ev-status-icon" title="${statusMeta.label}" aria-label="${statusMeta.label}" 
            style="position:${position}; top:${top}; right:${right}; display:inline-flex; align-items:center; justify-content:center; pointer-events:auto; cursor:${hasHistory ? 'help' : 'default'}; z-index:${zIndex};"
            ${hasHistory ? `data-tooltip-id="${tooltipId}" data-event-id="${event.eventid || ''}"` : ''}>
            <img src="${statusMeta.icon}" alt="${statusMeta.label}" style="width:16px; height:16px;">
        </span>`;
    }

    /**
     * Renders type icon (repeat/single/makeup) for an event
     * @param {Object} event - Event object
     * @param {Object} options - Rendering options
     * @returns {string} HTML string for type icon
     */
    function renderTypeIcon(event, options = {}) {
        const { isShortEvent = false } = options;
        const classType = event.classType;
        const isTimeOffEvent = classType === 'teacher_timeoff' || 
                               event.class_type === 'teacher_timeoff' || 
                               event.source === 'teacher_timeoff';

        // Time off events don't show type icons
        if (isTimeOffEvent) return '';

        // Determine which type icon to show
        let iconType = null;

        // 1:1 events show single session icon
        if (classType === 'one2one_weekly' || classType === 'one2one_single') {
            iconType = TYPE_ICON_MAP.one2one_single;
        }
        // Makeup events show makeup icon
        else if (event.isRescheduleCurrent && !event.isTeacherChanged) {
            iconType = TYPE_ICON_MAP.makeup;
        }
        // Recurring events show repeat icon
        else if (event.repeat) {
            iconType = TYPE_ICON_MAP.repeat;
        }

        if (!iconType) return '';

        return renderIcon(iconType.icon, iconType.label, iconType.class);
    }

    /**
     * Renders teacher change indicator icon (complex logic from original implementation)
     * @param {Object} event - Event object
     * @param {Object} statusMeta - Status metadata object
     * @param {Object} options - Rendering options
     * @param {Date|string} currentWeekStart - Current week start date (for teacher change icon date formatting)
     * @returns {string} HTML string for teacher change icon
     */
    function renderTeacherChangeIcon(event, statusMeta = null, options = {}, currentWeekStart = null) {
        if (!event.isTeacherChanged) return '';

        // Get teacher pic from rescheduled or from status details
        // IMPORTANT: Show the PREVIOUS teacher's picture (the one it was reassigned FROM), not the new teacher's
        let teacherPic = null;
        let prevTeacherName = null;
        let newTeacherName = null;

        // Use summary first, fallback to rescheduled for backward compatibility
        const summaryCurrent = event.summary?.current;
        const summaryPrevious = event.summary?.previous;
        const resCurrent = summaryCurrent || event.rescheduled?.current;
        const resPrev = summaryPrevious || event.rescheduled?.previous;

        // Get PREVIOUS teacher picture (the one it was reassigned FROM)
        // Check summary first, then rescheduled, then other sources
        if (summaryPrevious?.teacher?.avatar) {
            teacherPic = summaryPrevious.teacher.avatar;
        } else if (summaryPrevious?.teacher_pic) {
            teacherPic = summaryPrevious.teacher_pic;
        } else if (summaryPrevious?.teacherpic) {
            teacherPic = summaryPrevious.teacherpic;
        } else if (resPrev?.teacher_pic) {
            teacherPic = resPrev.teacher_pic;
        } else if (resPrev?.teacherpic) {
            teacherPic = resPrev.teacherpic;
        } else if (statusMeta?.statusObj?.details?.previous?.teacher_pic) {
            teacherPic = statusMeta.statusObj.details.previous.teacher_pic;
        } else if (event.previousTeacherAvatar) {
            teacherPic = event.previousTeacherAvatar;
        }

        if (!teacherPic) {
            teacherPic = "./img/default-avatar.svg";
        }

        // Get new teacher name
        newTeacherName = summaryCurrent?.teacher?.name ||
            resCurrent?.teacher_name ||
            resCurrent?.teachername ||
            statusMeta?.statusObj?.details?.current?.teacher_name ||
            (Array.isArray(event.teachernames) ? event.teachernames[0] : event.teachernames || "New Teacher");

        // Get previous teacher name
        if (summaryPrevious?.teacher?.name) {
            prevTeacherName = summaryPrevious.teacher.name;
        } else if (resPrev) {
            prevTeacherName = resPrev.teacher_name || resPrev.teachername || "Previous Teacher";
        } else if (statusMeta?.statusObj?.details?.previous) {
            prevTeacherName = statusMeta.statusObj.details.previous.teacher_name || 
                             statusMeta.statusObj.details.previous.teachername || 
                             "Previous Teacher";
        } else if (Array.isArray(event.teachernames) && event.teachernames.length > 1) {
            prevTeacherName = event.teachernames[1];
        } else if (event.previous_teachername) {
            prevTeacherName = event.previous_teachername;
        }

        if (!teacherPic) return '';

        // Format date and time for tooltip
        const eventDate = event.date || currentWeekStart || new Date();
        const dayNames = ["Sunday", "Monday", "Tuesday", "Wednesday", "Thursday", "Friday", "Saturday"];
        const dayName = dayNames[new Date(eventDate).getDay()];
        const monthDay = new Date(eventDate).toLocaleDateString("en-US", { month: "long", day: "numeric" });
        const year = new Date(eventDate).getFullYear();
        
        // Use global fmt12 if available, otherwise format manually
        const formatTime = (typeof window !== 'undefined' && window.TimeUtils && window.TimeUtils.formatTime12h) 
            ? window.TimeUtils.formatTime12h 
            : (typeof window !== 'undefined' && window.fmt12)
            ? window.fmt12
            : (m) => {
                const h = Math.floor(m / 60);
                const min = m % 60;
                const period = h >= 12 ? 'PM' : 'AM';
                const h12 = h % 12 || 12;
                return `${h12}:${String(min).padStart(2, '0')} ${period}`;
            };
        
        const startTime = typeof event.start === 'number' ? formatTime(event.start) : '';
        const endTime = typeof event.end === 'number' ? formatTime(event.end) : '';
        const eventDateTime = `${dayName}, ${monthDay} ${year}, ${startTime}-${endTime}`;

        const size = options.size || 16;
        const position = options.position || 'absolute';
        const top = options.top || '6px';
        const right = options.right || '6px';

        // Return only the teacher icon (without wrapper span, as it will be wrapped by renderStatusIcons)
        // Use the NEW teacher's picture (current teacher), not the previous one
        return `<span style="display:inline-flex; align-items:center; justify-content:center; pointer-events:auto; cursor: pointer; user-select: none;" 
            data-teacher-pic="${teacherPic}" 
            data-prev-teacher="${prevTeacherName || "N/A"}" 
            data-new-teacher="${newTeacherName || "N/A"}" 
            data-event-datetime="${eventDateTime}">
            <img src="${teacherPic}" alt="Teacher Changed" style="width:${size}px; height:${size}px; border-radius:50%;">
        </span>`;
    }

    /**
     * Renders midnight crossing indicator
     * @param {Object} event - Event object
     * @param {Object} options - Rendering options
     * @returns {string} HTML string for midnight icon
     */
    function renderMidnightIcon(event, options = {}) {
        if (!event.isMidnightCrossing) return '';

        const iconType = TYPE_ICON_MAP.midnight;
        return renderIcon(iconType.symbol, iconType.label, iconType.class, { isSymbol: true });
    }

    /**
     * Main function to render all event icons
     * @param {Object} event - Event object
     * @param {Object} statusMeta - Pre-computed status metadata (optional)
     * @param {Object} options - Rendering options
     * @returns {Object} Object containing different icon HTML strings
     */
    function renderEventIcons(event, statusMeta = null, options = {}) {
        const {
            isShortEvent = false,
            showStatusIcon = true,
            showTypeIcon = true,
            showTeacherChangeIcon = true,
            showMidnightIcon = true,
            statusIconOptions = {},
            typeIconOptions = {}
        } = options;

        // Get status meta if not provided
        if (!statusMeta) {
            statusMeta = getActiveStatusMeta(event.statuses);
        }

        return {
            status: showStatusIcon ? renderStatusIcons(event, statusMeta, { ...statusIconOptions, hideForRescheduleCurrent: true }) : '',
            type: showTypeIcon ? renderTypeIcon(event, { isShortEvent, ...typeIconOptions }) : '',
            teacherChange: showTeacherChangeIcon && event.isTeacherChanged ? renderTeacherChangeIcon(event, statusMeta) : '',
            midnight: showMidnightIcon ? renderMidnightIcon(event) : ''
        };
    }

    /**
     * Renders type icon for short events (compact display)
     * @param {Object} event - Event object
     * @returns {string} HTML string
     */
    function renderShortEventTypeIcon(event) {
        const classType = event.classType;
        const isTimeOffEvent = classType === 'teacher_timeoff' || 
                               event.class_type === 'teacher_timeoff' || 
                               event.source === 'teacher_timeoff';

        if (isTimeOffEvent) return '';

        // 1:1 events
        if (classType === 'one2one_weekly' || classType === 'one2one_single') {
            return renderIcon(TYPE_ICON_MAP.one2one_single.icon, TYPE_ICON_MAP.one2one_single.label, TYPE_ICON_MAP.one2one_single.class);
        }

        // Makeup events
        if (event.isRescheduleCurrent && !event.isTeacherChanged) {
            return renderIcon(TYPE_ICON_MAP.makeup.icon, TYPE_ICON_MAP.makeup.label, TYPE_ICON_MAP.makeup.class);
        }

        // Recurring events
        return renderIcon(TYPE_ICON_MAP.repeat.icon, TYPE_ICON_MAP.repeat.label, TYPE_ICON_MAP.repeat.class);
    }

    /**
     * Renders type icon for regular events (with makeup + repeat combination support)
     * @param {Object} event - Event object
     * @returns {string} HTML string
     */
    function renderRegularEventTypeIcon(event) {
        const classType = event.classType;
        const isTimeOffEvent = classType === 'teacher_timeoff' || 
                               event.class_type === 'teacher_timeoff' || 
                               event.source === 'teacher_timeoff';

        if (isTimeOffEvent) return '';

        // Special case: makeup + repeat combination
        if (event.isRescheduleCurrent && !event.isTeacherChanged && event.repeat) {
            return renderIcon(TYPE_ICON_MAP.repeat.icon, TYPE_ICON_MAP.repeat.label, TYPE_ICON_MAP.repeat.class) +
                   renderIcon(TYPE_ICON_MAP.makeup.icon, TYPE_ICON_MAP.makeup.label, TYPE_ICON_MAP.makeup.class);
        }

        // Makeup only
        if (event.isRescheduleCurrent && !event.isTeacherChanged) {
            return renderIcon(TYPE_ICON_MAP.makeup.icon, TYPE_ICON_MAP.makeup.label, TYPE_ICON_MAP.makeup.class);
        }

        // 1:1 events
        if (classType === 'one2one_weekly' || classType === 'one2one_single') {
            return renderIcon(TYPE_ICON_MAP.one2one_single.icon, TYPE_ICON_MAP.one2one_single.label, TYPE_ICON_MAP.one2one_single.class);
        }

        // Recurring events
        return renderIcon(TYPE_ICON_MAP.repeat.icon, TYPE_ICON_MAP.repeat.label, TYPE_ICON_MAP.repeat.class);
    }

    // ===== EXPOSE API =====

    global.EventIconUtils = {
        // Main rendering function
        renderEventIcons,
        
        // Individual icon renderers
        renderStatusIcons,
        renderTypeIcon,
        renderTeacherChangeIcon,
        renderMidnightIcon,
        renderShortEventTypeIcon,
        renderRegularEventTypeIcon,
        
        // Helper functions
        getActiveStatusMeta,
        renderIcon,
        
        // Configuration (for extension)
        STATUS_ICON_MAP,
        TYPE_ICON_MAP,
        SPECIAL_STATUS_ICONS
    };

    // Backward compatibility: expose getActiveStatusMeta globally if it doesn't exist
    if (!global.getActiveStatusMeta) {
        global.getActiveStatusMeta = getActiveStatusMeta;
    }

})(window);

