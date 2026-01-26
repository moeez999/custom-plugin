// js/teacher_utils.js
// Shared helpers for teacher-related UI (colors, labels, etc.)

(function (global) {
  "use strict";

  // Public API container
  const TeacherUtils = {
    /**
     * Returns a stable color index (1–10) for a given teacher id.
     * Useful when you have a finite set of CSS variables or classes.
     */
    getColorIndex(teacherId) {
      if (!teacherId) return 1;
      const idNum = parseInt(teacherId, 10);
      if (!idNum || Number.isNaN(idNum)) return 1;
      // Map to 1–10 range
      const mod = Math.abs(idNum) % 10;
      return mod === 0 ? 10 : mod;
    },

    /**
     * Returns a vibrant HSL color string unique per teacher id.
     * Uses golden-angle distribution for visually distinct hues.
     */
    getColor(teacherId) {
      if (!teacherId) return "#FF1744"; // default vibrant red

      const idNum = parseInt(teacherId, 10);
      if (!idNum || Number.isNaN(idNum)) return "#FF1744";

      // Golden angle trick for stable distinct hues
      const hue = Math.round((Math.abs(idNum) * 137.508) % 360);
      const saturation = 100;
      const lightness = 50;
      return `hsl(${hue}, ${saturation}%, ${lightness}%)`;
    },
  };

  // Expose globally
  global.TeacherUtils = TeacherUtils;
})(window);

