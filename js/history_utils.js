// js/history_utils.js
// Helpers for rendering event history (reschedules, status changes, etc.).

(function (global) {
  "use strict";

  function getIcon(historyItem) {
    if (!historyItem) {
      return { icon: "./img/ev-repeat.svg", label: "Updated" };
    }
    
    // Check for rescheduled status first (even if no type field)
    if (historyItem.status && 
        typeof historyItem.status === "object" &&
        historyItem.status.to === "rescheduled") {
      return { icon: "./img/rescheduled.svg", label: "Rescheduled" };
    }
    
    if (!historyItem.type) {
      // If no type but has time/teacher/date changes, infer type
      if (historyItem.teacher) {
        return { icon: "./img/assign-teacher.svg", label: "Teacher Changed" };
      }
      if (historyItem.time) {
        return { icon: "./img/ev-repeat.svg", label: "Time Updated" };
      }
      if (historyItem.date) {
        return { icon: "./img/ev-repeat.svg", label: "Date Updated" };
      }
      return { icon: "./img/ev-repeat.svg", label: "Updated" };
    }
    const type = String(historyItem.type).toLowerCase();
    
    // Check for rescheduled type
    if (type === "rescheduled") {
      return { icon: "./img/rescheduled.svg", label: "Rescheduled" };
    }
    
    // Check for teacher changes
    if (type === "teacher_changed" || 
        type === "teacher_change" ||
        (historyItem.status && 
         historyItem.status.from === "scheduled" && 
         historyItem.status.to === "teacher_changed") ||
        historyItem.teacher) {
      return { icon: "./img/assign-teacher.svg", label: "Teacher Changed" };
    }
    
    // Check for time changes in updated type
    if (type === "updated" && historyItem.time) {
      return { icon: "./img/ev-repeat.svg", label: "Time Updated" };
    }
    
    // Check for date changes
    if (type === "date_change" || historyItem.date) {
      return { icon: "./img/ev-repeat.svg", label: "Date Changed" };
    }
    
    // Default icon map
    const iconMap = {
      time_change: { icon: "./img/ev-repeat.svg", label: "Time Changed" },
      cancelled: { icon: "./img/cancelled.svg", label: "Cancelled" },
      completed: { icon: "./img/confirmed.svg", label: "Completed" },
    };
    
    return iconMap[type] || { icon: "./img/ev-repeat.svg", label: "Updated" };
  }

  function formatDescription(historyItem) {
    if (!historyItem) return "";

    const parts = [];

    // Teacher change
    if (historyItem.teacher && historyItem.teacher.from && historyItem.teacher.to) {
      parts.push(`Teacher: ${historyItem.teacher.from} → ${historyItem.teacher.to}`);
    }

    // Time change
    if (historyItem.time && historyItem.time.from && historyItem.time.to) {
      let fromStr = historyItem.time.from;
      let toStr = historyItem.time.to;

      if (fromStr.includes(" - ")) {
        const timeParts = fromStr.split(" - ");
        fromStr = timeParts[0] || "";
        toStr = timeParts[1] || "";
      }

      if (global.timeToMinutes && global.fmt12 && fromStr && toStr) {
        const fromMinutes = global.timeToMinutes(fromStr.trim());
        const toMinutes = global.timeToMinutes(toStr.trim());
        if (!isNaN(fromMinutes) && !isNaN(toMinutes)) {
          parts.push(
            `Time: ${global.fmt12(fromMinutes)} → ${global.fmt12(toMinutes)}`
          );
        } else {
          parts.push(`Time: ${fromStr} → ${toStr}`);
        }
      } else {
        parts.push(`Time: ${fromStr} → ${toStr}`);
      }
    }

    // Date change
    if (historyItem.date && historyItem.date.from && historyItem.date.to) {
      parts.push(`Date: ${historyItem.date.from} → ${historyItem.date.to}`);
    }

    // Status change
    if (historyItem.status) {
      if (
        typeof historyItem.status === "object" &&
        historyItem.status.from &&
        historyItem.status.to
      ) {
        // Only show status if it's meaningful (not just "scheduled" to "scheduled")
        if (historyItem.status.from !== historyItem.status.to) {
          const statusFrom = historyItem.status.from.replace(/_/g, " ");
          const statusTo = historyItem.status.to.replace(/_/g, " ");
          parts.push(
            `Status: ${statusFrom} → ${statusTo}`
          );
        }
      } else if (typeof historyItem.status === "string") {
        parts.push(`Status: ${historyItem.status.replace(/_/g, " ")}`);
      }
    }

    // Date/time when change occurred
    if (historyItem.changedAt) {
      const dateStr = String(historyItem.changedAt);
      try {
        const [datePart, timePart] = dateStr.split(" ");
        if (datePart && timePart) {
          const [year, month, day] = datePart.split("-");
          const [hour, minute] = timePart.split(":");
          const date = new Date(
            parseInt(year, 10),
            parseInt(month, 10) - 1,
            parseInt(day, 10),
            parseInt(hour, 10),
            parseInt(minute, 10)
          );
          const formattedDate = date.toLocaleDateString("en-US", {
            month: "short",
            day: "numeric",
            hour: "2-digit",
            minute: "2-digit",
          });
          parts.push(formattedDate);
        } else {
          parts.push(dateStr);
        }
      } catch (e) {
        parts.push(dateStr);
      }
    }

    return parts.join(" • ") || "Updated";
  }

  function renderList(historyArray) {
    if (!Array.isArray(historyArray) || historyArray.length === 0) {
      return "";
    }

    const items = historyArray.slice(0, 4).map((hist) => {
      const icon = getIcon(hist);
      const desc = formatDescription(hist);
      return (
        `<div class="ev-history-item" style="display:flex;align-items:center;gap:6px;font-size:11px;color:#666;">` +
        `<img src="${icon.icon}" alt="${icon.label}" style="width:14px;height:14px;opacity:0.7;flex-shrink:0;">` +
        `<span style="flex:1;overflow:hidden;text-overflow:ellipsis;white-space:nowrap;" title="${desc}">${desc}</span>` +
        `</div>`
      );
    });

    let more = "";
    if (historyArray.length > 4) {
      more =
        `<div style="font-size:10px;color:#999;font-style:italic;">+` +
        (historyArray.length - 4) +
        ` more</div>`;
    }

    return (
      `<div class="ev-history" style="margin-top:8px;padding-top:8px;border-top:1px solid rgba(0,0,0,0.1);">` +
      `<div style="display:flex;flex-direction:column;gap:4px;">` +
      items.join("") +
      more +
      `</div>` +
      `</div>`
    );
  }

  global.HistoryUtils = {
    getIcon,
    formatDescription,
    renderList,
  };
})(window);

