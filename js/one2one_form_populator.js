/**
 * One2One Form Populator
 * Utility to populate 1:1 event form with data
 * 
 * Handles:
 * - Teacher selection
 * - Student selection
 * - Date/time population
 * - Lesson type (single/weekly)
 * - Duration
 * - All form fields
 */

(function (global) {
  "use strict";

  /**
   * Populate form with event data
   * @param {Object} eventData - Event data from backend
   * @param {Object} options - Options
   * @param {string} options.formPrefix - Form prefix ('manage' or 'create')
   * @param {Function} options.onComplete - Callback when population is complete
   */
  function populateOne2OneForm(eventData, options = {}) {
    const {
      formPrefix = 'manage',
      onComplete = null
    } = options;

    if (!eventData) {
      console.warn('[One2OneFormPopulator] No event data provided');
      if (onComplete) onComplete(false);
      return;
    }

    console.log('[One2OneFormPopulator] Populating form with data:', eventData);

    try {
      // Wait for DOM to be ready
      setTimeout(() => {
        // 1. Populate Teacher
        populateTeacher(eventData, formPrefix);

        // 2. Populate Student
        populateStudent(eventData, formPrefix);

        // 3. Determine lesson type
        const lessonType = determineLessonType(eventData);
        populateLessonType(lessonType, formPrefix);

        // 4. Populate lesson-specific data
        if (lessonType === 'single') {
          populateSingleLesson(eventData, formPrefix);
        } else {
          populateWeeklyLesson(eventData, formPrefix);
        }

        // 5. Store original data for state management
        if (window.getOne2OneStateManager) {
          const stateManager = window.getOne2OneStateManager('one2oneForm');
          stateManager.initialize(normalizeEventDataForState(eventData));
        }

        console.log('[One2OneFormPopulator] Form populated successfully');

        if (onComplete) {
          onComplete(true);
        }
      }, 100);
    } catch (error) {
      console.error('[One2OneFormPopulator] Error populating form:', error);
      if (onComplete) {
        onComplete(false);
      }
    }
  }

  /**
   * Populate teacher selection
   */
  function populateTeacher(eventData, formPrefix) {
    const teacherId = eventData.teacherId || eventData.teacher?.id || eventData.teacherid;
    if (!teacherId) return;

    const triggerId = formPrefix === 'manage'
      ? 'calendar_admin_details_create_cohort_manage_class_tab_trigger'
      : 'calendar_admin_details_create_cohort_class_tab_trigger';

    const listId = formPrefix === 'manage'
      ? 'calendar_admin_details_create_cohort_manage_class_tab_list'
      : 'calendar_admin_details_create_cohort_class_tab_list';

    const imgId = formPrefix === 'manage'
      ? 'calendar_admin_details_create_cohort_manage_class_tab_current_img'
      : 'calendar_admin_details_create_cohort_class_tab_current_img';

    const labelId = formPrefix === 'manage'
      ? 'calendar_admin_details_create_cohort_manage_class_tab_current_label'
      : 'calendar_admin_details_create_cohort_class_tab_current_label';

    const $teacherItem = $(`#${listId} .calendar_admin_details_create_cohort_manage_class_tab_item[data-userid="${teacherId}"]`);
    if ($teacherItem.length === 0) {
      console.warn('[One2OneFormPopulator] Teacher not found:', teacherId);
      return;
    }

    const teacherName = $teacherItem.data('name') || $teacherItem.find('.calendar_admin_details_create_cohort_manage_class_tab_item_name').text();
    const teacherImg = $teacherItem.data('img') || $teacherItem.find('img').attr('src');

    // Update trigger button
    $(`#${imgId}`).attr('src', teacherImg).attr('alt', teacherName);
    $(`#${labelId}`).text(teacherName);

    // Mark as selected
    $teacherItem.attr('aria-selected', 'true');
    $teacherItem.siblings().removeAttr('aria-selected');

    // Update trigger data attributes
    const $trigger = $(`#${triggerId}`);
    $trigger.attr('data-userid', teacherId);
    $trigger.attr('data-name', teacherName);
    $trigger.attr('data-img', teacherImg);

    console.log('[One2OneFormPopulator] Teacher populated:', teacherId, teacherName);
  }

  /**
   * Populate student selection
   */
  function populateStudent(eventData, formPrefix) {
    const studentId = eventData.studentId || eventData.student?.id || eventData.studentid;
    if (!studentId) return;

    const dropdownId = formPrefix === 'manage'
      ? 'one2oneStudentDropdownManage'
      : 'one2oneStudentDropdown';

    const buttonId = formPrefix === 'manage'
      ? 'one2oneAddStudentBtnManage'
      : 'one2oneAddStudentBtn';

    const $studentItem = $(`#${dropdownId} .one2one-student-list-item-class[data-userid="${studentId}"]`);
    if ($studentItem.length === 0) {
      console.warn('[One2OneFormPopulator] Student not found:', studentId);
      return;
    }

    const studentName = $studentItem.data('name') || $studentItem.find('.one2one-student-list-name').text();
    const avatarHTML = $studentItem.find('.one2one-student-list-avatar').html();

    // Update button
    $(`#${buttonId}`)
      .html(`
        <span class="one2one-add-student-icon">${avatarHTML}</span>
        <span style="font-weight:600; color:#232323;">${studentName}</span>
      `)
      .addClass('active');

    // Mark as selected
    $studentItem.addClass('selected');
    $studentItem.siblings().removeClass('selected');

    console.log('[One2OneFormPopulator] Student populated:', studentId, studentName);
  }

  /**
   * Determine lesson type from event data
   */
  function determineLessonType(eventData) {
    // Check explicit classType
    if (eventData.classType === 'single' || eventData.class_type === 'single') {
      return 'single';
    }
    if (eventData.classType === 'weekly' || eventData.class_type === 'weekly' || eventData.is_recurring) {
      return 'weekly';
    }

    // Check source
    if (eventData.source === 'one2one_single') {
      return 'single';
    }
    if (eventData.source === 'one2one_weekly') {
      return 'weekly';
    }

    // Default to single
    return 'single';
  }

  /**
   * Populate lesson type selection
   */
  function populateLessonType(lessonType, formPrefix) {
    const $singleBtn = formPrefix === 'manage'
      ? $('.one2one-lesson-type-btn[data-type="single"]').first()
      : $('.one2one-lesson-type-btn[data-type="single"]').first();

    const $weeklyBtn = formPrefix === 'manage'
      ? $('.one2one-lesson-type-btn[data-type="weekly"]').first()
      : $('.one2one-lesson-type-btn[data-type="weekly"]').first();

    if (lessonType === 'single') {
      $singleBtn.addClass('selected');
      $singleBtn.find('input[type="radio"]').prop('checked', true);
      $weeklyBtn.removeClass('selected');
      $weeklyBtn.find('input[type="radio"]').prop('checked', false);
    } else {
      $weeklyBtn.addClass('selected');
      $weeklyBtn.find('input[type="radio"]').prop('checked', true);
      $singleBtn.removeClass('selected');
      $singleBtn.find('input[type="radio"]').prop('checked', false);
    }

    // Trigger change event to show/hide sections
    $singleBtn.trigger('click');
    if (lessonType === 'weekly') {
      setTimeout(() => $weeklyBtn.trigger('click'), 50);
    }

    console.log('[One2OneFormPopulator] Lesson type populated:', lessonType);
  }

  /**
   * Populate single lesson data
   */
  function populateSingleLesson(eventData, formPrefix) {
    // Extract date
    let eventDate = eventData.date || eventData.eventdate || eventData.eventDate;
    if (eventDate && eventDate.includes('T')) {
      eventDate = eventDate.split('T')[0];
    }

    // Extract time
    let startTime = eventData.start || eventData.start_time;
    let endTime = eventData.end || eventData.end_time;

    // Convert 24h to 12h if needed
    if (startTime && !startTime.includes(' ')) {
      startTime = convert24hTo12h(startTime);
    }
    if (endTime && !endTime.includes(' ')) {
      endTime = convert24hTo12h(endTime);
    }

    // Extract duration
    const duration = eventData.duration_minutes || eventData.duration || 50;

    // Populate date
    if (eventDate) {
      const dateDisplayId = formPrefix === 'manage'
        ? 'selectedDateTextManage'
        : 'selectedDateText';

      const dateObj = new Date(eventDate + 'T12:00:00');
      const dayStr = dateObj.toLocaleString('en-US', {
        weekday: 'short',
        month: 'short',
        day: 'numeric'
      });

      $(`#${dateDisplayId}`)
        .text(dayStr)
        .attr('data-full-date', eventDate);
    }

    // Populate time
    if (startTime) {
      const timeDisplayId = formPrefix === 'manage'
        ? 'customTimeDropdownDisplayManage'
        : 'customTimeDropdownDisplay';

      $(`#${timeDisplayId}`).text(startTime);

      // Select in dropdown
      const $timeList = formPrefix === 'manage'
        ? $('#customTimeDropdownListManage')
        : $('#customTimeDropdownList');

      $timeList.find('.one2one-time-option').removeClass('selected');
      $timeList.find(`.one2one-time-option:contains("${startTime}")`).first().addClass('selected');
    }

    // Populate duration
    const durationDisplayId = formPrefix === 'manage'
      ? 'durationDropdownDisplayManage'
      : 'durationDropdownDisplay';

    const durationText = `${duration} Minutes ( Standard time )`;
    $(`#${durationDisplayId}`).text(durationText);

    const $durationList = formPrefix === 'manage'
      ? $('#durationDropdownListManage')
      : $('#durationDropdownList');

    $durationList.find('.one2one-duration-option').removeClass('selected');
    $durationList.find(`.one2one-duration-option[data-duration="${duration}"]`).addClass('selected');

    console.log('[One2OneFormPopulator] Single lesson populated:', {
      date: eventDate,
      startTime,
      endTime,
      duration
    });
  }

  /**
   * Populate weekly lesson data
   */
  function populateWeeklyLesson(eventData, formPrefix) {
    // This is more complex - would need to populate:
    // - Start date
    // - End date / occurrences
    // - Days of week
    // - Times for each day
    // - Period/interval

    console.log('[One2OneFormPopulator] Weekly lesson population - complex, may need custom implementation');
    // TODO: Implement weekly lesson population if needed
  }

  /**
   * Convert 24h time to 12h format
   */
  function convert24hTo12h(time24h) {
    if (!time24h || time24h.includes(' ')) {
      return time24h; // Already 12h or invalid
    }

    const [hours, minutes] = time24h.split(':').map(Number);
    if (isNaN(hours) || isNaN(minutes)) {
      return time24h;
    }

    const period = hours >= 12 ? 'PM' : 'AM';
    const hours12 = hours % 12 || 12;
    const minutesStr = String(minutes).padStart(2, '0');

    return `${hours12}:${minutesStr} ${period}`;
  }

  /**
   * Normalize event data for state management
   */
  function normalizeEventDataForState(eventData) {
    return {
      eventId: eventData.eventid || eventData.eventId || eventData.id,
      googlemeetid: eventData.googlemeetid || eventData.googlemeetId,
      teacherId: eventData.teacherId || eventData.teacher?.id || eventData.teacherid,
      studentId: eventData.studentId || eventData.student?.id || eventData.studentid,
      date: eventData.date || eventData.eventdate || eventData.eventDate,
      start: eventData.start || eventData.start_time,
      end: eventData.end || eventData.end_time,
      duration: eventData.duration_minutes || eventData.duration,
      lessonType: determineLessonType(eventData),
      status: eventData.status,
      classType: eventData.classType || eventData.class_type
    };
  }

  // Export
  global.populateOne2OneForm = populateOne2OneForm;

})(window);
