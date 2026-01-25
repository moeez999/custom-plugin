/**
 * One2One Form Reset Utility
 * Resets 1:1 event form to original state
 * 
 * Handles:
 * - Resetting all form fields
 * - Clearing selections
 * - Restoring original values
 * - State management reset
 */

(function (global) {
  "use strict";

  /**
   * Reset form to original state
   * @param {Object} options - Options
   * @param {string} options.formPrefix - Form prefix ('manage' or 'create')
   * @param {boolean} options.clearState - Whether to clear state manager
   * @param {Function} options.onComplete - Callback when reset is complete
   */
  function resetOne2OneForm(options = {}) {
    const {
      formPrefix = 'manage',
      clearState = false,
      onComplete = null
    } = options;

    console.log('[One2OneFormReset] Resetting form:', { formPrefix, clearState });

    try {
      // 1. Reset state manager if available
      if (window.getOne2OneStateManager) {
        const stateManager = window.getOne2OneStateManager('one2oneForm');
        if (stateManager) {
          stateManager.reset();
        }

        if (clearState) {
          window.removeOne2OneStateManager('one2oneForm');
        }
      }

      // 2. Reset teacher selection
      resetTeacher(formPrefix);

      // 3. Reset student selection
      resetStudent(formPrefix);

      // 4. Reset lesson type
      resetLessonType(formPrefix);

      // 5. Reset single lesson fields
      resetSingleLesson(formPrefix);

      // 6. Reset weekly lesson fields
      resetWeeklyLesson(formPrefix);

      // 7. Clear any temporary data
      clearTemporaryData();

      console.log('[One2OneFormReset] Form reset successfully');

      if (onComplete) {
        onComplete(true);
      }
    } catch (error) {
      console.error('[One2OneFormReset] Error resetting form:', error);
      if (onComplete) {
        onComplete(false);
      }
    }
  }

  /**
   * Reset teacher selection
   */
  function resetTeacher(formPrefix) {
    const triggerId = formPrefix === 'manage'
      ? 'calendar_admin_details_create_cohort_manage_class_tab_trigger'
      : 'calendar_admin_details_create_cohort_class_tab_trigger';

    const imgId = formPrefix === 'manage'
      ? 'calendar_admin_details_create_cohort_manage_class_tab_current_img'
      : 'calendar_admin_details_create_cohort_class_tab_current_img';

    const labelId = formPrefix === 'manage'
      ? 'calendar_admin_details_create_cohort_manage_class_tab_current_label'
      : 'calendar_admin_details_create_cohort_class_tab_current_label';

    // Reset to default
    const $img = $(`#${imgId}`);
    const $label = $(`#${labelId}`);

    if ($img.length && $label.length) {
      $img.attr('src', 'https://images.unsplash.com/photo-1544005313-94ddf0286df2?q=80&w=200&auto=format&fit=crop');
      $label.text('Daniela'); // Default name

      // Clear data attributes
      const $trigger = $(`#${triggerId}`);
      $trigger.removeAttr('data-userid');
      $trigger.removeAttr('data-name');
      $trigger.removeAttr('data-img');
    }

    // Clear selections
    const listId = formPrefix === 'manage'
      ? 'calendar_admin_details_create_cohort_manage_class_tab_list'
      : 'calendar_admin_details_create_cohort_class_tab_list';

    $(`#${listId} .calendar_admin_details_create_cohort_manage_class_tab_item`).removeAttr('aria-selected');

    // Close dropdown
    const $menuWrap = formPrefix === 'manage'
      ? $('#calendar_admin_details_create_cohort_manage_class_tab_menu')
      : $('#calendar_admin_details_create_cohort_class_tab_menu');

    $menuWrap.hide();
  }

  /**
   * Reset student selection
   */
  function resetStudent(formPrefix) {
    const buttonId = formPrefix === 'manage'
      ? 'one2oneAddStudentBtnManage'
      : 'one2oneAddStudentBtn';

    const dropdownId = formPrefix === 'manage'
      ? 'one2oneStudentDropdownManage'
      : 'one2oneStudentDropdown';

    // Reset button to default
    const $button = $(`#${buttonId}`);
    if ($button.length) {
      $button.html(`
        <span class="one2one-add-student-icon">
          <img src="./img/student-placeholder.svg" alt="">
        </span>
        <span class="one2one-add-student-placeholder" style="color:#aaa;">Add student</span>
      `).removeClass('active');
    }

    // Clear selections
    $(`#${dropdownId} .one2one-student-list-item-class`).removeClass('selected');

    // Close dropdown
    $(`#${dropdownId}`).hide();
  }

  /**
   * Reset lesson type
   */
  function resetLessonType(formPrefix) {
    const $singleBtn = $('.one2one-lesson-type-btn[data-type="single"]').first();
    const $weeklyBtn = $('.one2one-lesson-type-btn[data-type="weekly"]').first();

    // Reset to single (default)
    $singleBtn.addClass('selected');
    $singleBtn.find('input[type="radio"]').prop('checked', true);
    $weeklyBtn.removeClass('selected');
    $weeklyBtn.find('input[type="radio"]').prop('checked', false);

    // Show single lesson section, hide weekly
    $('#custom-single-lesson').show();
    $('#custom-weekly-lesson').hide();
    if (formPrefix === 'manage') {
      $('#custom-single-lesson-manage').show();
      $('#custom-weekly-lesson-manage').hide();
    }
  }

  /**
   * Reset single lesson fields
   */
  function resetSingleLesson(formPrefix) {
    // Reset date
    const dateDisplayId = formPrefix === 'manage'
      ? 'selectedDateTextManage'
      : 'selectedDateText';

    const today = new Date();
    const dayStr = today.toLocaleString('en-US', {
      weekday: 'short',
      month: 'short',
      day: 'numeric'
    });
    const dateStr = today.toISOString().split('T')[0];

    $(`#${dateDisplayId}`)
      .text(dayStr)
      .attr('data-full-date', dateStr);

    // Reset time
    const timeDisplayId = formPrefix === 'manage'
      ? 'customTimeDropdownDisplayManage'
      : 'customTimeDropdownDisplay';

    $(`#${timeDisplayId}`).text('12:00 AM');

    const $timeList = formPrefix === 'manage'
      ? $('#customTimeDropdownListManage')
      : $('#customTimeDropdownList');

    $timeList.find('.one2one-time-option').removeClass('selected');
    $timeList.find('.one2one-time-option').first().addClass('selected');

    // Reset duration
    const durationDisplayId = formPrefix === 'manage'
      ? 'durationDropdownDisplayManage'
      : 'durationDropdownDisplay';

    $(`#${durationDisplayId}`).text('50 Minutes ( Standard time )');

    const $durationList = formPrefix === 'manage'
      ? $('#durationDropdownListManage')
      : $('#durationDropdownList');

    $durationList.find('.one2one-duration-option').removeClass('selected');
    $durationList.find('.one2one-duration-option[data-duration="50"]').addClass('selected');
  }

  /**
   * Reset weekly lesson fields
   */
  function resetWeeklyLesson(formPrefix) {
    // Reset start date
    const startDateId = formPrefix === 'manage'
      ? 'weeklyLessonStartDateTextManage'
      : 'weeklyLessonStartDateText';

    const today = new Date();
    if ($(`#${startDateId}`).length) {
      $(`#${startDateId}`)
        .text(window.formatDate ? window.formatDate(today) : today.toLocaleDateString())
        .attr('data-full-date', today.toISOString().split('T')[0]);
    }

    // Reset end date
    const endDateId = formPrefix === 'manage'
      ? 'weeklyLessonEndDateBtnManage'
      : 'weeklyLessonEndDateBtn';

    const endDate = new Date();
    endDate.setMonth(endDate.getMonth() + 1);
    if ($(`#${endDateId}`).length) {
      $(`#${endDateId}`)
        .text(window.formatDate ? window.formatDate(endDate) : endDate.toLocaleDateString())
        .attr('data-full-date', endDate.toISOString().split('T')[0]);
    }

    // Clear selected days
    if (window.weeklyLessonDayTimes) {
      window.weeklyLessonDayTimes = {};
    }

    // Clear day widgets
    $('.weekly_lesson_widget_manage').removeClass('selected');
  }

  /**
   * Clear temporary data
   */
  function clearTemporaryData() {
    // Clear window variables
    if (window.originalEventData) {
      delete window.originalEventData;
    }
    if (window.currentEventData) {
      delete window.currentEventData;
    }
    if (window.rescheduleReason) {
      delete window.rescheduleReason;
    }
    if (window.rescheduleMessage) {
      delete window.rescheduleMessage;
    }
    if (window.allEvents) {
      delete window.allEvents;
    }
    if (window.weeklyUpdateScope) {
      delete window.weeklyUpdateScope;
    }
    if (window.weeklyLessonStartDate) {
      delete window.weeklyLessonStartDate;
    }
  }

  // Export
  global.resetOne2OneForm = resetOne2OneForm;

})(window);
