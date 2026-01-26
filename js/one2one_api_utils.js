// js/one2one_api_utils.js
// Central helpers for building 1:1 (one2one) API payloads.

(function (global) {
  "use strict";

  function buildCancelThis(eventData, opts) {
    const reason = (opts && opts.reason) || "";
    const message = (opts && opts.message) || "";

    const eventId = parseInt(
      eventData.eventid || eventData.id || eventData.eventId || 0,
      10
    );
    const googlemeetid = parseInt(
      eventData.googlemeetid || eventData.googlemeetId || eventData.cmid || 0,
      10
    );

    return {
      scope: "THIS_OCCURRENCE",
      eventId,
      googlemeetid,
      cancel: {
        reason,
        message,
      },
    };
  }

  function normalizeDateFromEvent(eventData) {
    let date =
      eventData.date || eventData.eventDate || eventData.event_date || "";
    if (date && date.indexOf("T") !== -1) {
      date = date.split("T")[0];
    }
    return date;
  }

  function buildCancelThisAndFollowing(eventData, opts) {
    const reason = (opts && opts.reason) || "";

    const eventId = parseInt(
      eventData.eventid || eventData.id || eventData.eventId || 0,
      10
    );
    const googlemeetid = parseInt(
      eventData.googlemeetid || eventData.googlemeetId || eventData.cmid || 0,
      10
    );
    const eventDate = normalizeDateFromEvent(eventData);

    return {
      scope: "THIS_AND_FOLLOWING",
      anchorEvent: {
        eventId,
        eventDate,
        googlemeetid,
      },
      changes: [
        {
          action: "CANCEL",
          googlemeetid,
          scope: "THIS_AND_FOLLOWING",
          reason: {
            message: reason,
          },
        },
      ],
    };
  }

  /**
   * Build drag-and-drop reschedule payload for a 1:1 event.
   * Params:
   *  - opts: {
   *      eventId, googlemeetid, oldDate, newDate,
   *      oldStartMinutes, oldEndMinutes,
   *      newStartMinutes, newEndMinutes
   *    }
   */
  function buildRescheduleFromDrag(opts) {
    const {
      eventId,
      googlemeetid,
      oldDate,
      newDate,
      oldStartMinutes,
      oldEndMinutes,
      newStartMinutes,
      newEndMinutes,
    } = opts;

    const dateChanged = newDate !== oldDate;
    const timeChanged = newStartMinutes !== oldStartMinutes;

    const minutesToHHMM = (mins) => {
      const m = parseInt(mins, 10);
      if (Number.isNaN(m)) return "00:00";
      const h = Math.floor(m / 60);
      const mm = m % 60;
      return `${String(h).padStart(2, "0")}:${String(mm).padStart(2, "0")}`;
    };

    const newStartTime = minutesToHHMM(newStartMinutes);
    const newEndTime = minutesToHHMM(newEndMinutes);

    const payload = {
      scope: "THIS_OCCURRENCE",
      eventId: parseInt(eventId, 10),
      googlemeetid: parseInt(googlemeetid, 10),
      apply: {
        time: timeChanged,
        teacher: false,
        status: false,
        days: false,
        period: false,
        end: false,
        date: dateChanged,
      },
    };

    if (dateChanged && oldDate) {
      payload.anchorDate = oldDate;
    }

    if (timeChanged) {
      payload.time = {
        start: newStartTime,
        end: newEndTime,
      };
      payload.current = {
        start: newStartTime,
        end: newEndTime,
      };
    }

    if (dateChanged && newDate) {
      payload.date = { new: newDate };
    }

    return payload;
  }

  global.One2OneApi = {
    buildCancelThis,
    buildCancelThisAndFollowing,
    buildRescheduleFromDrag,
  };
})(window);

