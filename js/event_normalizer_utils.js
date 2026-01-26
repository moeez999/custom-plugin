// js/event_normalizer_utils.js
// Normalize mixed API event payloads into a single calendar-friendly structure.
//
// Input shape (from get_user_events.php / calendar_admin_get_events.php):
//   - data.events      → main events (1:1 + group)
//   - data.peertalk    → optional peertalk events
//   - data.conference  → optional conference events
//   - data.teacher_timeoff[teacherid][] → teacher time off blocks
//
// Output shape (per event):
//   {
//     date, title, start, end, color, classType, source,
//     teacherId, teacherids, studentids, cohortids,
//     eventid, googlemeetid, courseid, is_parent, main_event_id, sequence,
//     teachernames, statuses, rescheduled, summary, history, avatar, ...
//   }
//
(function (global) {
  "use strict";

  /**
   * Normalize nested 1:1 items (item.event + item.summary) into flat events.
   */
  function normalizeOneToOneItem(item) {
    if (!item || !item.event || !item.summary) return item;

    const eventData = item.event;
    const summary = item.summary.current || item.summary;

    if (!eventData.eventdate || !eventData.start_time) {
      console.warn("Event missing required fields:", eventData);
      return item;
    }

    // Compute end time from duration when needed
    let endTime = eventData.end_time || null;
    if (!endTime && eventData.duration_minutes && global.timeToMinutes) {
      const durationMinutes = parseInt(eventData.duration_minutes, 10);
      if (!Number.isNaN(durationMinutes) && durationMinutes > 0) {
        const startMinutes = global.timeToMinutes(eventData.start_time);
        if (!Number.isNaN(startMinutes)) {
          const endMinutes = startMinutes + durationMinutes;
          if (global.minutesToTime) {
            endTime = global.minutesToTime(endMinutes);
          }
        }
      }
    }

    if (!endTime) {
      console.warn("Event missing end_time and duration_minutes:", eventData);
      return item;
    }

    const startISO = `${eventData.eventdate}T${eventData.start_time}`;
    const endISO = `${eventData.eventdate}T${endTime}`;

    let classType = "1:1";
    let class_type = "one2one_single";
    if (eventData.classType === "weekly") {
      classType = "one2one_weekly";
      class_type = "one2one_weekly";
    } else if (eventData.classType === "single") {
      classType = "one2one_single";
      class_type = "one2one_single";
    }

    const studentids = eventData.student ? [Number(eventData.student.id)] : [];
    const studentnames = eventData.student ? [eventData.student.name] : [];
    const studentavatar =
      eventData.student && eventData.student.avatar
        ? [eventData.student.avatar]
        : [];

    let title = "";
    if (summary && summary.teacher && eventData.student) {
      title = `${summary.teacher.name} - ${eventData.student.name}`;
    } else if (eventData.student) {
      title = eventData.student.name;
    } else if (summary && summary.teacher) {
      title = summary.teacher.name;
    }

    return {
      eventid: eventData.eventid,
      start: startISO,
      end: endISO,
      date: eventData.eventdate,
      title: title,
      teacherids:
        summary && summary.teacher ? [Number(summary.teacher.id)] : [],
      teacherid: summary && summary.teacher ? Number(summary.teacher.id) : null,
      teacher_id:
        summary && summary.teacher ? Number(summary.teacher.id) : null,
      studentid: eventData.student ? Number(eventData.student.id) : null,
      student: eventData.student || null,
      studentids: studentids,
      studentnames: studentnames,
      studentavatar: studentavatar,
      status: summary ? summary.status : null,
      classType: classType,
      class_type: class_type,
      googlemeetid: eventData.googlemeetid,
      duration_minutes: eventData.duration_minutes,
      teacher: summary && summary.teacher ? summary.teacher : null,
      history:
        item.history && item.history.timeline ? item.history.timeline : [],
      summary: item.summary || null,
    };
  }

  /**
   * Flatten teacher_timeoff map into event objects.
   */
  function normalizeTeacherTimeoff(timeoffMap) {
    const out = [];
    if (!timeoffMap) return out;

    Object.entries(timeoffMap).forEach(([tid, items]) => {
      if (!Array.isArray(items)) return;
      items.forEach((item) => {
        if (!item || !item.start || !item.end) return;
        out.push({
          start: item.start,
          end: item.end,
          start_ts: item.start_ts,
          end_ts: item.end_ts,
          title: item.title || "Busy",
          classType: "teacher_timeoff",
          class_type: "teacher_timeoff",
          source: "teacher_timeoff",
          teacherids: [Number(tid) || tid],
          teacherid: item.teacherid || Number(tid) || tid,
          timeoffid: typeof item.id !== "undefined" ? item.id : null,
          style:
            "border-color: rgba(253,216,48,0.7); background-color: rgba(253,216,48,0.05);",
          color: "e-timeoff",
        });
      });
    });

    return out;
  }

  /**
   * Normalize all API events (1:1 + group + peertalk + conference + timeoff)
   * into canonical calendar events.
   *
   * @param {Object} data Raw API response
   * @param {number|null} teacherFilter Optional teacherid filter (for color/teacherId)
   * @returns {Array<Object>} canonical events
   */
  function normalizeApiEvents(data, teacherFilter) {
    let allEvents = [];

    // 1) Base events (1:1 + group)
    if (data && data.ok && Array.isArray(data.events)) {
      allEvents = data.events.map((item) => {
        if (item && item.event && item.summary) {
          return normalizeOneToOneItem(item);
        }
        return item;
      });
    }

    // 2) Peertalk + conference
    if (data && data.ok && Array.isArray(data.peertalk)) {
      allEvents = allEvents.concat(data.peertalk);
    }
    if (data && data.ok && Array.isArray(data.conference)) {
      allEvents = allEvents.concat(data.conference);
    }

    // 3) Teacher time off
    if (data && data.ok && data.teacher_timeoff) {
      allEvents = allEvents.concat(
        normalizeTeacherTimeoff(data.teacher_timeoff),
      );
    }

    // 4) Canonical calendar events
    const teacherIdSet = teacherFilter ? new Set([teacherFilter]) : null;
    const canonical = [];

    for (let i = 0; i < allEvents.length; i++) {
      const ev = allEvents[i];
      if (!ev || !ev.start || !ev.end) continue;

      // Extract date part without timezone issues
      let eventDateStr = null;
      if (typeof ev.start === "string" && ev.start.includes("T")) {
        eventDateStr = ev.start.split("T")[0];
      }

      const startDate = new Date(ev.start);
      const endDate = new Date(ev.end);

      // Resolve teacherId
      let teacherId = null;
      if (teacherIdSet) {
        let eventTeacherIds = Array.isArray(ev.teacherids)
          ? ev.teacherids
          : ev.teacher_id
            ? [ev.teacher_id]
            : ev.teacherid
              ? [ev.teacherid]
              : [];
        for (let tid of eventTeacherIds) {
          if (teacherIdSet.has(tid)) {
            teacherId = tid;
            break;
          }
        }
        if (!teacherId && eventTeacherIds.length > 0) {
          teacherId = eventTeacherIds[0];
        }
      } else if (Array.isArray(ev.teacherids) && ev.teacherids.length > 0) {
        teacherId = ev.teacherids[0];
      } else if (ev.teacher_id) {
        teacherId = ev.teacher_id;
      } else if (ev.teacherid) {
        teacherId = ev.teacherid;
      } else if (ev.teacher) {
        teacherId = ev.teacher;
      }

      // Color by type
      let eventColor = "e-blue";
      if (
        ev.class_type === "one2one_weekly" ||
        ev.class_type === "one2one_single" ||
        ev.classType === "one2one_weekly" ||
        ev.classType === "one2one_single"
      ) {
        eventColor = "e-green";
      } else if (ev.class_type === "peertalk" || ev.source === "peertalk") {
        eventColor = "e-purple";
      } else if (ev.class_type === "conference" || ev.source === "conference") {
        eventColor = "e-orange";
      } else if (
        ev.class_type === "teacher_timeoff" ||
        ev.classType === "teacher_timeoff" ||
        ev.source === "teacher_timeoff"
      ) {
        eventColor = "e-timeoff";
      }

      // Start/end as HH:MM
      let eventStart, eventEnd;
      if (
        ev.source === "teacher_timeoff" ||
        ev.classType === "teacher_timeoff"
      ) {
        if (ev.start_ts && ev.end_ts) {
          const startDate_ts = new Date(ev.start_ts * 1000);
          const endDate_ts = new Date(ev.end_ts * 1000);
          eventStart = startDate_ts.toTimeString().slice(0, 5);
          eventEnd = endDate_ts.toTimeString().slice(0, 5);
        } else {
          eventStart = "00:00";
          eventEnd = "23:59";
        }
      } else {
        if (typeof ev.start === "string" && ev.start.includes("T")) {
          eventStart = ev.start.split("T")[1].slice(0, 5);
        } else {
          eventStart = startDate.toTimeString().slice(0, 5);
        }
        if (typeof ev.end === "string" && ev.end.includes("T")) {
          eventEnd = ev.end.split("T")[1].slice(0, 5);
        } else {
          eventEnd = endDate.toTimeString().slice(0, 5);
        }
      }

      const localYMD =
        eventDateStr ||
        startDate.getFullYear() +
          "-" +
          String(startDate.getMonth() + 1).padStart(2, "0") +
          "-" +
          String(startDate.getDate()).padStart(2, "0");

      const eventObj = {
        date: localYMD,
        title: ev.title || "",
        start: eventStart,
        end: eventEnd,
        color: eventColor,
        repeat:
          typeof ev.is_recurring !== "undefined"
            ? ev.is_recurring
            : ev.repeat || false,
        meetingurl: ev.meetingurl || "",
        viewurl: ev.viewurl || ev.meetingurl || "",
        // Prefer CURRENT teacher avatar first so reassigned lessons show new tutor
        avatar:
          ev.summary?.current?.teacher?.avatar ||
          ev.summary?.current?.teacher_pic ||
          ev.rescheduled?.current?.teacher_pic ||
          ev.avatar ||
          "",
        teacherId:
          typeof teacherId !== "undefined" && teacherId !== null
            ? teacherId
            : ev.teacherId ||
              ev.teacher_id ||
              ev.teacherid ||
              ev.teacher ||
              (ev.teacherids && ev.teacherids[0]) ||
              "",
        classType:
          ev.classType ||
          ev.class_type ||
          ev.summary?.current?.class_type ||
          ev.rescheduled?.class_type ||
          ev.source ||
          "",
        source:
          ev.source ||
          ev.summary?.current?.class_type ||
          ev.rescheduled?.class_type ||
          "event",
        studentnames: ev.studentnames || [],
        studentids: ev.studentids || [],
        studentavatar: ev.studentavatar || [],
        cohortids: ev.cohortids || [],
        eventid: ev.eventid || "",
        timeoffid:
          typeof ev.timeoffid !== "undefined"
            ? ev.timeoffid
            : typeof ev.id !== "undefined"
              ? ev.id
              : null,
        cmid: ev.cmid || 0,
        googlemeetid:
          typeof ev.googlemeetid !== "undefined" ? ev.googlemeetid : 0,
        courseid: typeof ev.courseid !== "undefined" ? ev.courseid : 0,
        is_parent: typeof ev.is_parent !== "undefined" ? ev.is_parent : false,
        main_event_id:
          typeof ev.main_event_id !== "undefined" ? ev.main_event_id : "",
        sequence: typeof ev.sequence !== "undefined" ? ev.sequence : 1,
        teachernames: ev.teachernames || [],
        statuses: ev.statuses || [],
        rescheduled:
          typeof ev.rescheduled !== "undefined" ? ev.rescheduled : null,
        summary: ev.summary || null,
        faded: false,
        availabilityId: ev.availabilityId || null,
        history: ev.history && Array.isArray(ev.history) ? ev.history : [],
      };

      // Fill teacherId/ avatar from summary / rescheduled when missing
      if (!eventObj.teacherId) {
        if (eventObj.summary?.current?.teacher?.id) {
          eventObj.teacherId = eventObj.summary.current.teacher.id;
        } else if (eventObj.summary?.current?.teacher) {
          eventObj.teacherId = eventObj.summary.current.teacher;
        } else if (eventObj.rescheduled?.current?.teacher) {
          eventObj.teacherId = eventObj.rescheduled.current.teacher;
        }
      }

      if (!eventObj.avatar) {
        if (eventObj.summary?.current?.teacher?.avatar) {
          eventObj.avatar = eventObj.summary.current.teacher.avatar;
        } else if (eventObj.summary?.current?.teacher_pic) {
          eventObj.avatar = eventObj.summary.current.teacher_pic;
        } else if (eventObj.rescheduled?.current?.teacher_pic) {
          eventObj.avatar = eventObj.rescheduled.current.teacher_pic;
        }
      }

      // Flag teacher changes on rescheduled 1:1
      const prevTid =
        eventObj.summary?.previous?.teacher?.id ||
        eventObj.summary?.previous?.teacher ||
        eventObj.rescheduled?.previous?.teacher;
      const currTid =
        eventObj.summary?.current?.teacher?.id ||
        eventObj.summary?.current?.teacher ||
        eventObj.rescheduled?.current?.teacher;
      if (prevTid && currTid && prevTid !== currTid) {
        eventObj.isTeacherChanged = true;
      }

      canonical.push(eventObj);
    }

    return canonical;
  }

  global.EventNormalizer = {
    normalizeApiEvents,
    normalizeOneToOneItem,
    normalizeTeacherTimeoff,
  };
})(window);
