<style>
/* ====== WEEKLY LESSON MODAL STYLES ====== */
.calendar_admin_details_create_cohort_schedule_btn_manage {
    width: 100%;
    background-color: #fe2e0c;
    color: white;
    padding: 15px 0;
    border: none;
    font-weight: bold;
    font-size: 1.11rem;
    margin-top: 13px;
    border-radius: 9px;
    cursor: pointer;
    letter-spacing: .5px;
    box-shadow: 0 3px 13px 0 rgba(254, 46, 12, .07);
    position: sticky;
    bottom: 0;
    z-index: 5;
}

.weekly_lesson_modal_container {
    border-radius: 13px;
    border: 1.5px solid #dadada;
    padding: 10px 18px 12px 18px;
}

.time-dropdown div:hover {
    background: #f6f6f6;
    color: #fe2e0c;
}

#weekly_lesson_timepicker_start_manage {
    width: auto;
}

#weekly_lesson_timepicker_end_manage {
    width: auto;
}

.weekly_lesson_modal_container {
    width: 100%;
    font-size: 1.03rem;
}

.weekly_lesson_close_btn {
    position: absolute;
    top: 16px;
    right: 16px;
    font-size: 23px;
    cursor: pointer;
    color: #232323;
    background: none;
    border: none;
}

.weekly_lesson_stepper_manage {
    border: none;
    background: #f3f3f3;
    border-radius: 50%;
    width: 36px;
    height: 36px;
    font-size: 1.27rem;
    font-weight: 600;
    color: #232323;
    cursor: pointer;
    transition: background 0.13s;
}

.weekly_lesson_stepper_manage:active {
    background: #ececec;
}

.weekly_lesson_dropdown_wrapper {
    position: relative;
}

.weekly_lesson_dropdown_btn {
    display: flex;
    align-items: center;
    background: #fff;
    border: 1.3px solid #dadada;
    border-radius: 11px;
    padding: 8px 18px;
    font-size: 1.01rem;
    cursor: pointer;
    min-width: 120px;
    font-weight: 600;
    margin-left: 10px;
}

.weekly_lesson_dropdown_btn svg {
    margin-left: 7px;
}

.weekly_lesson_dropdown_list_manage {
    display: none;
    position: absolute;
    top: 110%;
    left: 0;
    width: 160px;
    background: #fff;
    border: 1.5px solid #dadada;
    border-radius: 13px;
    box-shadow: 0 4px 18px #0001;
    z-index: 110;
}

.weekly_lesson_option_manage {
    padding: 13px 18px;
    font-size: 1rem;
    border-radius: 9px;
    cursor: pointer;
    transition: background 0.15s;
    font-weight: 500;
    color: #232323;
}

.weekly_lesson_option_manage:hover {
    background: #f6f6f6;
    color: #fe2e0c;
}

.weekly_lesson_date_btn {
    background: #f9f9f9;
    border: none;
    border-radius: 7px;
    font-size: 1.01rem;
    font-weight: 500;
    border: 1.3px solid #dadada;
    border-radius: 8px;
    color: #232323;
    padding: 8px 14px;
    cursor: pointer;
    opacity: 0.6;
}

.weekly_lesson_date_btn:hover {
    border: 2px solid #232323;
}

.weekly_lesson_date_btn.enabled {
    background: #fff;
    color: #232323;
    border: 1.3px solid #dadada;
    opacity: 1;
}

.weekly_lesson_occurrence_counter {
    display: inline-flex;
    align-items: center;
}

.weekly_lesson_occurrence_counter button {
    margin: 0 5px;
}

/* ---- Weekly day widgets ---- */
.weekly_lesson_widget_row {
    display: flex;
    gap: 9px;
    margin-top: 10px;
    align-items: flex-start;
    flex-wrap: nowrap;
}

.weekly_lesson_scroll_widget_manage {
    box-sizing: border-box;
    width: 41px;
    min-height: 41px;
    background-color: #f2f2f2;
    border: 1px solid rgba(0, 0, 0, 0.12);
    border-radius: 104.61px;
    display: flex;
    flex-direction: column;
    justify-content: center;
    align-items: center;
    gap: 8px;
    user-select: none;
    cursor: pointer;
    opacity: 0.55;
    transition: opacity .15s, box-shadow .15s, transform .06s;
}

.weekly_lesson_scroll_widget_manage:active {
    transform: translateY(1px);
}

.weekly_lesson_scroll_widget_manage.selected {
    opacity: 1;
    box-shadow: 0 2px 10px #0001;
    padding: 14px 0px;
    border: 1px solid #fe2e0c;
}

.weekly_lesson_widget_text_manage {
    color: #121212;
    font-family: "Poppins", sans-serif;
    font-weight: 500;
    font-size: 14px;
    line-height: 21px;
}

.weekly_lesson_widget_divider_manage {
    width: 25px;
    border-top: 0.5px solid rgba(0, 0, 0, 0.2);
    display: none;
}

.weekly_lesson_scroll_widget_manage.selected .weekly_lesson_widget_divider_manage {
    display: block;
}

.weekly_lesson_widget_button_manage {
    box-sizing: border-box;
    width: 25px;
    height: 25px;
    background-color: #ffffff;
    border-radius: 50%;
    display: none;
    justify-content: center;
    align-items: center;
    cursor: pointer;
    border: none;
}

.weekly_lesson_scroll_widget_manage.selected .weekly_lesson_widget_button_manage {
    display: flex;
}

.weekly_lesson_widget_arrow_manage {
    width: 0;
    height: 0;
    border-left: 6px solid transparent;
    border-right: 6px solid transparent;
    border-top: 6px solid #000000;
}

.weekly_lesson_widget_time_manage {
    display: none;
    flex-direction: column;
    align-items: center;
    gap: 2px;
    text-align: center;
    font-family: "Poppins", sans-serif;
}

.weekly_lesson_scroll_widget_manage.selected .weekly_lesson_widget_time_manage.has-time {
    display: flex;
}

.weekly_lesson_widget_hour_minute_manage {
    color: #000;
    font-weight: 500;
    font-size: 11px;
    line-height: 14px;
}

.weekly_lesson_widget_period_manage {
    color: #ff2500;
    font-weight: 500;
    font-size: 11px;
    line-height: 14px;
}

.weekly_lesson_widget_dash_manage {
    font-size: 11px;
    line-height: 14px;
    color: #000;
    opacity: .8;
}

.weekly_lesson_widget_button_manage.has-time {
    display: none !important;
}

.weekly_lesson_widget_button_manage .weekly_lesson_dot {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    min-width: 28px;
    height: 18px;
    padding: 0 6px;
    border-radius: 999px;
    background: #ff2500;
    color: #fff;
    font-family: "Poppins", sans-serif;
    font-weight: 600;
    font-size: 10px;
    line-height: 18px;
    margin-left: 4px;
}

.weekly_lesson_btn {
    border-radius: 8px;
    padding: 12px 0;
    width: 100%;
    font-size: 1.09rem;
    font-weight: bold;
    transition: background .14s, color .14s, border .14s;
    border: none;
    box-shadow: 0 2px 8px #0001;
    letter-spacing: 0.01em;
    margin-top: 10px;
    outline: none;
    cursor: pointer;
}

/* ====== Time Picker for Weekly ====== */
.weekly_lesson_timepicker_modal_backdrop_manage {
    display: none;
    position: fixed;
    z-index: 9999;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background: rgba(0, 0, 0, 0.14);
}

.weekly_lesson_timepicker_modal {
    background: #fff;
    border-radius: 15px;
    box-shadow: 0 10px 36px 0 rgba(0, 0, 0, .16);
    max-width: 300px;
    max-width: 97vw;
    padding: 26px 24px 24px 24px;
    position: absolute;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%);
    font-family: inherit;
}

.weekly_lesson_timepicker_card_title {
    color: #000000;
    font-family: "Poppins", sans-serif;
    font-weight: 600;
    font-size: 16px;
    line-height: 24px;
    margin: 0 0 16px 0;
}

.weekly_lesson_timepicker_inputs_container {
    display: flex;
    justify-content: space-between;
    align-items: center;
    gap: 8px;
    margin-bottom: 16px;
}

.weekly_lesson_timepicker_input {
    border: 2px solid rgba(0, 0, 0, 0.12);
    border-radius: 10px;
    padding: 9px 8px;
    width: 99px;
    height: 40px;
    display: flex;
    justify-content: center;
    align-items: center;
    font-size: 14px;
    background: #fff;
}

.weekly_lesson_timepicker_button_container {
    display: flex;
    justify-content: flex-end;
    gap: 8px;
}

.weekly_lesson_timepicker_cancel_btn_manage {
    background: #fff;
    border: 1.3px solid #dadada;
    border-radius: 8px;
    color: #232323;
    font-weight: 600;
    font-size: 16px;
    width: 99px;
    height: 40px;
    padding: 0;
    cursor: pointer;
}

.weekly_lesson_timepicker_done_btn_manage {
    background-color: #fe2e0c;
    border: none;
    border-radius: 8px;
    color: #ffffff;
    font-weight: 600;
    font-size: 16px;
    width: 99px;
    height: 40px;
    padding: 0;
    cursor: pointer;
}

.weekly_lesson_timepicker_done_btn_manage:active {
    background: #e52b10;
}

hr.weekly_lesson_hr {
    border: none;
    border-top: 1.3px solid #ececec;
    margin: 10px 0 15px 0;
}

hr.weekly_lesson_hr.large {
    margin: 15px 0;
}

.single-lesson-dropdown-card {
    background-color: #ffffff;
    border: 2px solid rgba(0, 0, 0, 0.12);
    border-radius: 8px;
    box-shadow: 0px 8px 32px 0px rgba(18, 17, 23, 0.15),
        0px 16px 48px 0px rgba(18, 17, 23, 0.15);
    padding: 14px;
    display: flex;
    flex-direction: column;
    gap: 10px;
    width: 100%;
    position: absolute;
    z-index: 10;
    height: 300px;
    overflow-y: auto;
}

.single-lesson-dropdown-card::-webkit-scrollbar {
    width: 4px;
    background: transparent;
}

.single-lesson-dropdown-card::-webkit-scrollbar-thumb {
    background-color: #d1d1d1;
    border-radius: 2px;
}

.single-lesson-dropdown-item {
    display: flex;
    align-items: center;
    gap: 12px;
    background-color: #ffffff;
    border-radius: 10px;
    padding: 16px 32px;
}

.single-lesson-dropdown-item__date {
    display: flex;
    flex-direction: column;
    align-items: center;
    gap: 4px;
    flex-shrink: 0;
}

.single-lesson-dropdown-date-month {
    font-family: 'Figtree', sans-serif;
    font-weight: 600;
    font-size: 14px;
    line-height: 20px;
    color: #121117;
    text-align: center;
}

.single-lesson-dropdown-date-day {
    font-family: 'Figtree', sans-serif;
    font-weight: 600;
    font-size: 16px;
    line-height: 24px;
    color: #121117;
    text-align: center;
}

.single-lesson-dropdown-item__details {
    display: flex;
    flex-direction: column;
    gap: 4px;
    flex-grow: 1;
}

.single-lesson-dropdown-details-time {
    margin: 0;
    font-family: 'Poppins', sans-serif;
    font-weight: 600;
    font-size: 16px;
    line-height: 24px;
    color: #121117;
}

.single-lesson-dropdown-details-info {
    display: flex;
    align-items: center;
    gap: 5px;
}

.single-lesson-dropdown-info-text {
    font-family: 'Poppins', sans-serif;
    font-weight: 400;
    font-size: 14px;
    line-height: 20px;
    color: #4d4c5c;
}

.single-lesson-dropdown-info-dot {
    width: 4px;
    height: 4px;
    background-color: #4d4c5c;
    border-radius: 50%;
    flex-shrink: 0;
}

@media (max-width: 480px) {
    .single-lesson-dropdown-item {
        padding: 12px 16px;
    }
}

.weekly-single-lesson-container {
    background-color: #ffffff;
    border: 2px solid rgba(0, 0, 0, 0.12);
    border-radius: 8px;
    box-shadow: 0px 8px 32px 0px rgba(18, 17, 23, 0.15),
        0px 16px 48px 0px rgba(18, 17, 23, 0.15);
    padding: 14px;
    width: 100%;
    margin: 0 auto;
    display: flex;
    flex-direction: column;
    gap: 10px;
    height: 290px;
    overflow-y: auto;
}

.weekly-single-lesson-container::-webkit-scrollbar {
    width: 4px;
    background: transparent;
}

.weekly-single-lesson-container::-webkit-scrollbar-thumb {
    background: #d6d6d6;
    border-radius: 2px;
    border: 1px solid transparent;
}

.weekly-single-lesson-item {
    display: flex;
    align-items: center;
    gap: 20px;
    padding: 16px 15px;
}

.weekly-single-lesson-icon {
    width: 24px;
    height: 24px;
    flex-shrink: 0;
}

.weekly-single-lesson-details {
    display: flex;
    flex-direction: column;
    gap: 4px;
}

.weekly-single-lesson-time {
    color: #121117;
    font-family: 'Poppins', sans-serif;
    font-weight: 600;
    font-size: 15px;
    line-height: 24px;
    margin: 0;
}

.weekly-single-lesson-description {
    color: #4d4c5c;
    font-family: 'Poppins', sans-serif;
    font-weight: 400;
    font-size: 14px;
    line-height: 20px;
    letter-spacing: 0.07px;
    margin: 0;
}

#manageclassTabContent .dropdown-search {
    width: 95% !important;
    margin: 10px auto;
    padding: 8px 12px;
    border: 1.3px solid #ccc;
    border-radius: 8px;
    display: block;
    font-size: 0.95rem;
    outline: none;
}

#manageclassTabContent .dropdown-search:focus {
    border-color: #fe2e0c;
    box-shadow: 0 0 0 2px rgba(254, 46, 12, 0.1);
}

#manageclassTabContent .custom-time-pill {
    width: 100% !important;
}

#manageclassTabContent .custom-time-dropdown::-webkit-scrollbar {
    width: 0.5rem;
}

#manageclassTabContent .custom-time-dropdown::-webkit-scrollbar-track {
    background-color: transparent;
}

/* ====== DROPDOWN MANAGEMENT ====== */
.dropdown-container {
    position: relative;
    padding: 14px 18px;
    border: 2px solid #ececec;
    border-radius: 12px;
    background: #fff;
    font-size: 1.08rem;
    color: #232323;

    cursor: pointer;
    margin-bottom: 0;
    position: relative;
    box-sizing: border-box;
    transition: border 0.15s;
    margin-bottom: 14px;
}

.dropdown-display {
    cursor: pointer;
}

.dropdown-content {
    display: none;
    position: absolute;
    z-index: 100;
    width: 100%;
    background: white;
    border: 1px solid #dadada;
    border-radius: 8px;
    box-shadow: 0 4px 18px rgba(0, 0, 0, 0.1);
    max-height: 300px;
    overflow-y: auto;
    top: 110%;
    /* 👇 Center it relative to parent */
    left: 50%;
    transform: translateX(-50%);

}


.dropdown-content.active {
    display: block;
}

.dropdown-backdrop {
    display: none;
    position: fixed;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    z-index: 99;
    background: transparent;
}

.dropdown-backdrop.active {
    display: block;
}

/* Disabled dropdown states */
.one2one-student-dropdown-wrapper.disabled {
    opacity: 0.5;
    pointer-events: none;
    cursor: not-allowed;
}

.one2one-add-student-card.disabled {
    opacity: 0.5;
    cursor: not-allowed;
    background-color: #f5f5f5;
}

/* Loader overlay */
.loader-overlay {
    display: none;
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background: rgba(255, 255, 255, 0.6);
    z-index: 9999;
    align-items: center;
    justify-content: center;
}

.loader-overlay.active {
    display: flex;
}

/* Disabled button state */
.calendar_admin_details_create_cohort_schedule_btn_manage:disabled {
    opacity: 0.5;
    cursor: not-allowed;
    background-color: #cccccc;
}

/* ====== MANAGE 1:1 UPDATE SCOPE MODAL ====== */
.manage-update-scope-modal-backdrop {
    display: none;
    position: fixed;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background: rgba(0, 0, 0, 0.5);
    z-index: 10000;
    align-items: center;
    justify-content: center;
}

.manage-update-scope-modal-backdrop.active {
    display: flex;
}

.manage-update-scope-modal {
    background: #fff;
    border-radius: 12px;
    padding: 24px;
    width: 90%;
    max-width: 340px;
    box-shadow: 0 10px 40px rgba(0, 0, 0, 0.2);
}

.manage-update-scope-title {
    font-family: 'Poppins', sans-serif;
    font-weight: 600;
    font-size: 18px;
    line-height: 27px;
    color: #000;
    margin: 0 0 20px 0;
}

.manage-update-scope-options {
    display: flex;
    flex-direction: column;
    gap: 12px;
    margin-bottom: 24px;
}

.manage-update-scope-option {
    display: flex;
    align-items: center;
    gap: 12px;
    cursor: pointer;
    padding: 4px 0;
}

.manage-update-scope-option input[type="radio"] {
    appearance: none;
    width: 24px;
    height: 24px;
    border: 2px solid #dadada;
    border-radius: 50%;
    outline: none;
    cursor: pointer;
    position: relative;
    flex-shrink: 0;
}

.manage-update-scope-option input[type="radio"]:checked {
    border-color: #fe2e0c;
}

.manage-update-scope-option input[type="radio"]:checked::after {
    content: '';
    position: absolute;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%);
    width: 12px;
    height: 12px;
    background: #fe2e0c;
    border-radius: 50%;
}

.manage-update-scope-option label {
    font-family: 'Poppins', sans-serif;
    font-weight: 400;
    font-size: 15px;
    line-height: 22px;
    color: #232323;
    cursor: pointer;
    user-select: none;
}

.manage-update-scope-buttons {
    display: flex;
    gap: 12px;
    justify-content: flex-end;
}

.manage-update-scope-cancel-btn,
.manage-update-scope-ok-btn {
    border: none;
    border-radius: 8px;
    font-family: 'Poppins', sans-serif;
    font-weight: 600;
    font-size: 16px;
    padding: 10px 24px;
    cursor: pointer;
    transition: all 0.2s;
}

.manage-update-scope-cancel-btn {
    background: #fff;
    border: 1.3px solid #dadada;
    color: #232323;
}

.manage-update-scope-cancel-btn:hover {
    background: #f5f5f5;
}

.manage-update-scope-ok-btn {
    background: #fe2e0c;
    color: #fff;
    min-width: 80px;
}

.manage-update-scope-ok-btn:hover {
    background: #e52b10;
}

/* ====== RESCHEDULE LESSON MODAL ====== */
.reschedule-lesson-modal-backdrop {
    display: none;
    position: fixed;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background: rgba(0, 0, 0, 0.5);
    z-index: 10000;
    align-items: center;
    justify-content: center;
}

.reschedule-lesson-modal-backdrop.active {
    display: flex;
}

.reschedule-lesson-modal {
    background: #fff;
    border-radius: 8px;
    padding: 12px;
    width: 90%;
    max-width: 520px;
    box-shadow: 0 10px 40px rgba(0, 0, 0, 0.2);
    max-height: 90vh;
    overflow-y: auto;
}

.reschedule-lesson-header {
    display: flex;
    align-items: center;
    justify-content: space-between;
    margin-bottom: 16px;
}

.reschedule-lesson-back-btn {
    background: none;
    border: none;
    cursor: pointer;
    padding: 8px;
    display: flex;
    align-items: center;
    justify-content: center;
}

.reschedule-lesson-close-btn {
    background: none;
    border: none;
    cursor: pointer;
    padding: 8px;
    font-size: 24px;
    line-height: 1;
    color: #232323;
}

.reschedule-lesson-title {
    font-family: 'Poppins', sans-serif;
    font-weight: 600;
    font-size: 24px;
    line-height: 36px;
    color: #000;
    margin: 0 0 8px 0;
}

.reschedule-lesson-badge {
    display: inline-block;
    background: #f0f0f0;
    border-radius: 6px;
    padding: 4px 12px;
    font-family: 'Poppins', sans-serif;
    font-weight: 500;
    font-size: 13px;
    color: #666;
    margin-bottom: 20px;
}

.reschedule-lesson-card {
    background: #f8f8f8;
    border: 1px solid #e0e0e0;
    border-radius: 12px;
    padding: 16px;
    margin-bottom: 20px;
}

.reschedule-lesson-card-header {
    display: flex;
    align-items: center;
    gap: 12px;
    margin-bottom: 12px;
}

.reschedule-lesson-avatar {
    width: 48px;
    height: 48px;
    border-radius: 50%;
    object-fit: cover;
}

.reschedule-lesson-info {
    flex: 1;
}

.reschedule-lesson-date {
    font-family: 'Poppins', sans-serif;
    font-weight: 600;
    font-size: 16px;
    line-height: 24px;
    color: #000;
    margin: 0 0 2px 0;
}

.reschedule-lesson-time {
    font-family: 'Poppins', sans-serif;
    font-weight: 400;
    font-size: 14px;
    line-height: 20px;
    color: #666;
    margin: 0;
}

.reschedule-lesson-meta {
    display: flex;
    align-items: center;
    gap: 16px;
}

.reschedule-lesson-student {
    font-family: 'Poppins', sans-serif;
    font-weight: 400;
    font-size: 14px;
    color: #666;
}

.reschedule-lesson-count {
    display: flex;
    align-items: center;
    gap: 6px;
    font-family: 'Poppins', sans-serif;
    font-weight: 400;
    font-size: 14px;
    color: #666;
}

.reschedule-lesson-label {
    font-family: 'Poppins', sans-serif;
    font-weight: 500;
    font-size: 14px;
    line-height: 21px;
    color: #000;
    margin: 0 0 8px 0;
}

.reschedule-lesson-dropdown {
    position: relative;
    margin-bottom: 20px;
}

.reschedule-lesson-dropdown-btn {
    width: 100%;
    background: #fff;
    border: 1.5px solid #dadada;
    border-radius: 8px;
    padding: 12px 16px;
    font-family: 'Poppins', sans-serif;
    font-weight: 400;
    font-size: 15px;
    color: #999;
    cursor: pointer;
    display: flex;
    align-items: center;
    justify-content: space-between;
    transition: border-color 0.2s;
}

.reschedule-lesson-dropdown-btn:hover,
.reschedule-lesson-dropdown-btn.active {
    border-color: #fe2e0c;
}

.reschedule-lesson-dropdown-list {
    display: none;
    position: absolute;
    top: calc(100% + 4px);
    left: 0;
    right: 0;
    background: #fff;
    border: 1.5px solid #dadada;
    border-radius: 10px;
    box-shadow: 0 4px 18px rgba(0, 0, 0, 0.1);
    max-height: 200px;
    overflow-y: auto;
    z-index: 10;
}

.reschedule-lesson-dropdown-list.active {
    display: block;
}

.reschedule-lesson-dropdown-item {
    padding: 12px 16px;
    font-family: 'Poppins', sans-serif;
    font-weight: 400;
    font-size: 14px;
    color: #232323;
    cursor: pointer;
    transition: background 0.15s;
}

.reschedule-lesson-dropdown-item:hover {
    background: #f6f6f6;
}

.reschedule-lesson-textarea {
    width: 100%;
    background: #fff;
    border: 1.5px solid #dadada;
    border-radius: 8px;
    padding: 12px 16px;
    font-family: 'Poppins', sans-serif;
    font-weight: 400;
    font-size: 14px;
    color: #232323;
    resize: vertical;
    min-height: 100px;
    transition: border-color 0.2s;
    box-sizing: border-box;
}

.reschedule-lesson-textarea:focus {
    outline: none;
    border-color: #fe2e0c;
}

.reschedule-lesson-textarea::placeholder {
    color: #999;
}

.reschedule-lesson-confirm-btn {
    width: 100%;
    background: #fe2e0c;
    color: #fff;
    border: none;
    border-radius: 10px;
    padding: 14px;
    font-family: 'Poppins', sans-serif;
    font-weight: 600;
    font-size: 16px;
    cursor: pointer;
    transition: background 0.2s;
    margin-top: 20px;
}

.reschedule-lesson-confirm-btn:hover {
    background: #e52b10;
}

.reschedule-lesson-confirm-btn:disabled {
    background: #cccccc;
    cursor: not-allowed;
}
</style>

<div class="calendar_admin_details_create_cohort_content tab-content" id="manageclassTabContent" style="display:none;">

    <div class="calendar_admin_details_create_cohort_manage_class_tab_wrap"
        id="calendar_admin_details_create_cohort_manage_class_tab_widget">
        <div class="calendar_admin_details_create_cohort_manage_class_tab_label">Teacher</div>

        <!-- Trigger -->
        <button type="button" class="calendar_admin_details_create_cohort_manage_class_tab_trigger"
            aria-haspopup="listbox" aria-expanded="false"
            id="calendar_admin_details_create_cohort_manage_class_tab_trigger">
            <div class="calendar_admin_details_create_cohort_manage_class_tab_left">
                <img class="calendar_admin_details_create_cohort_manage_class_tab_avatar"
                    id="calendar_admin_details_create_cohort_manage_class_tab_current_img"
                    src="https://images.unsplash.com/photo-1544005313-94ddf0286df2?q=80&w=200&auto=format&fit=crop"
                    alt="Selected teacher">
                <span class="calendar_admin_details_create_cohort_manage_class_tab_name"
                    id="calendar_admin_details_create_cohort_manage_class_tab_current_label">Daniela</span>
            </div>

            <img class="calendar_admin_details_create_cohort_manage_class_tab_chev" src="./img/dropdown-arrow-down.svg"
                alt="">
        </button>

        <!-- Dropdown -->
        <div class="calendar_admin_details_create_cohort_manage_class_tab_menu"
            id="calendar_admin_details_create_cohort_manage_class_tab_menu">
            <div class="calendar_admin_details_create_cohort_manage_class_tab_panel" role="listbox"
                aria-labelledby="calendar_admin_details_create_cohort_manage_class_tab_trigger"
                id="calendar_admin_details_create_cohort_manage_class_tab_list">
                <input type="text" id="teacherSearchInputManage" class="dropdown-search"
                    placeholder="Enter Teacher Name...">
                <!-- Items (dynamic) -->
                <?php
require_once(__DIR__ . '/../../config.php');
require_login();

global $DB, $PAGE, $OUTPUT;

/** Collect unique teacher user IDs from cohorts */
$userIds = $DB->get_fieldset_sql("
    SELECT DISTINCT uid
      FROM (
            SELECT cohortmainteacher AS uid FROM {cohort}
             WHERE cohortmainteacher IS NOT NULL AND cohortmainteacher > 0
            UNION
            SELECT cohortguideteacher AS uid FROM {cohort}
             WHERE cohortguideteacher IS NOT NULL AND cohortguideteacher > 0
      ) t
");

/** Fetch user records (not deleted/suspended) */
$teachers = [];
if ($userIds) {
    list($inSql, $params) = $DB->get_in_or_equal($userIds, SQL_PARAMS_NAMED);
    $fields = "id, firstname, lastname, picture, imagealt, firstnamephonetic, lastnamephonetic, middlename, alternatename";
    $teachers = $DB->get_records_select('user', "id $inSql AND deleted = 0 AND suspended = 0", $params, 'firstname ASC, lastname ASC', $fields);
}
$teachersItemsHtml = '';

if (!empty($teachers)) {
    foreach ($teachers as $teacher) {
        $picture = new user_picture($teacher);
        $picture->size = 50;
        $imageUrl = $picture->get_url($PAGE)->out(false);
        $name   = fullname($teacher, true);

        $teachersItemsHtml .=
            '<div class="calendar_admin_details_create_cohort_manage_class_tab_item" role="option" '.
                'data-userid="'.(int)$teacher->id.'" '.
                'data-name="'.s($name).'" '.
                'data-img="'.s($imageUrl).'">'.
                '<img class="calendar_admin_details_create_cohort_manage_class_tab_avatar" src="'.s($imageUrl).'" alt="'.s($name).'" />'.
                '<span class="calendar_admin_details_create_cohort_manage_class_tab_item_name">'.format_string($name).'</span>'.
            '</div>';
    }
} else {
    $teachersItemsHtml =
        '<div class="calendar_admin_details_create_cohort_manage_class_tab_item" role="option" aria-disabled="true">'.
            '<span class="calendar_admin_details_create_cohort_manage_class_tab_item_name">No teachers found</span>'.
        '</div>';
}
echo $teachersItemsHtml;
?>
            </div>
        </div>
    </div>

    <label class="one2one-section-label">Student</label>
    <div class="one2one-student-dropdown-wrapper disabled" id="studentDropdownWrapper">
        <div class="one2one-add-student-card disabled" id="one2oneAddStudentBtnManage" tabindex="0">
            <span class="one2one-add-student-icon">
                <svg width="21" height="21" viewBox="0 0 20 20" fill="none">
                    <circle cx="10" cy="7" r="4" fill="#000" />
                    <ellipse cx="10" cy="15.3" rx="6.5" ry="3.3" fill="#000" />
                </svg>
            </span>
            <span class="one2one-add-student-placeholder" style="color:#aaa;">Select a teacher first</span>
        </div>
        <div class="one2one-student-dropdown-list" id="one2oneStudentDropdownManage" style="display:none;">
            <input type="text" id="studentSearchInputManage" class="dropdown-search"
                placeholder="Enter student name...">
            <?php
global $DB, $PAGE;

// 1) Resolve the Student role id (fallback to id=5 if shortname not found).
$studentRole = $DB->get_record('role', ['shortname' => 'student']);
$studentRoleId = $studentRole ? (int)$studentRole->id : 5;

// 2) Get distinct user IDs that have the Student role (any context).
$userIds = $DB->get_fieldset_sql("
    SELECT DISTINCT ra.userid
      FROM {role_assignments} ra
     WHERE ra.roleid = ?
", [$studentRoleId]);

$studentsItemsHtml = '';

if (!empty($userIds)) {
    list($inSql, $params) = $DB->get_in_or_equal($userIds, SQL_PARAMS_NAMED, 'u');
    // 3) Fetch user records (not deleted/suspended)
    $fields = "id, firstname, lastname, picture, imagealt, firstnamephonetic, lastnamephonetic, middlename, alternatename";
    $users = $DB->get_records_select('user', "id $inSql AND deleted = 0 AND suspended = 0", $params, 'firstname ASC, lastname ASC', $fields);

    // Helper: choose the correct membership-check function name you provided.
    $checkFunction = function_exists('membership_check_user_subscription') ? 'membership_check_user_subscription'
             : (function_exists('membership_check_user_subscriptionr') ? 'membership_check_user_subscriptionr' : null);

    foreach ($users as $user) {
        // 4) Must have an ACTIVE subscription
        $isActive = false;
        $methodLabel = 'Subscription';

        if ($checkFunction) {
            $status = $checkFunction($user->id);
            if (!empty($status) && isset($status['state']) && $status['state'] === 'active') {
                $isActive = true;
                if (isset($status['method']) && $status['method']) {
                    // Optional: show method like PayPal/Braintree/Patreon/Manual
                    $methodLabel = 'Subscription';
                }
            }
        } else {
            // If checker not available, skip (or set your own fallback)
            continue;
        }

        if (!$isActive) {
            continue;
        }

        // 5) Build avatar URL just like teachers
        $picture = new user_picture($user);
        $picture->size = 50;
        $imageUrl = $picture->get_url($PAGE)->out(false);
        $name   = fullname($user, true);

        // 6) Build item (keep structure/classes the same)
        $studentsItemsHtml .=
            '<div class="one2one-student-list-item" data-userid="'.(int)$user->id.'" data-name="'.s($name).'">'.
                '<div class="one2one-student-list-avatar">'.
                    '<img src="'.s($imageUrl).'" alt="'.s($name).'" style="width:24px;height:24px;border-radius:50%;object-fit:cover;" />'.
                '</div>'.
                '<div class="one2one-student-list-meta">'.
                    '<div class="one2one-student-list-name">'.format_string($name).'</div>'.
                    '<div class="one2one-student-list-lessons">0 Lessons</div>'.
                '</div>'.
                '<div class="one2one-student-list-status">'.$methodLabel.'</div>'.
            '</div>';
    }
}

// 7) Empty state
if ($studentsItemsHtml === '') {
    $studentsItemsHtml =
        '<div class="one2one-student-list-item" aria-disabled="true">'.
            '<div class="one2one-student-list-meta">'.
                '<div class="one2one-student-list-name">No active subscribers</div>'.
                '<div class="one2one-student-list-lessons">—</div>'.
            '</div>'.
            '<div class="one2one-student-list-status">—</div>'.
        '</div>';
}

echo $studentsItemsHtml;
?>
        </div>
    </div>

    <!-- Change Teacher Checkbox -->
    <div class="one2one-change-teacher-section" style="margin-top: 15px;">
        <label class="one2one-checkbox-label"
            style="display: flex; justify-content: end; align-items: center; gap: 8px; cursor: pointer;">
            <input type="checkbox" id="changeTeacherCheckbox"
                style="display:none;width: 18px; height: 18px; cursor: pointer;">
            <span style="font-size: 14px; font-weight: 600; display:flex;gap:5px; align-item:center;"><img
                    src="./img/assign-teacher.svg" alt=""> Assign
                Tutor</span>
        </label>
    </div>

    <!-- New Teacher Dropdown (hidden by default) -->
    <div id="newTeacherDropdownSection" style="display: none; margin-top: 15px;">
        <div class="calendar_admin_details_create_cohort_manage_class_tab_wrap">
            <div class="calendar_admin_details_create_cohort_manage_class_tab_label">New Teacher</div>

            <!-- Trigger -->
            <button type="button" class="calendar_admin_details_create_cohort_manage_class_tab_trigger"
                aria-haspopup="listbox" aria-expanded="false" id="newTeacherDropdownTrigger">
                <div class="calendar_admin_details_create_cohort_manage_class_tab_left">
                    <img class="calendar_admin_details_create_cohort_manage_class_tab_avatar" id="newTeacherCurrentImg"
                        src="https://images.unsplash.com/photo-1544005313-94ddf0286df2?q=80&w=200&auto=format&fit=crop"
                        alt="Selected teacher">
                    <span class="calendar_admin_details_create_cohort_manage_class_tab_name"
                        id="newTeacherCurrentLabel">Select new teacher</span>
                </div>

                <img class="calendar_admin_details_create_cohort_manage_class_tab_chev"
                    src="./img/dropdown-arrow-down.svg" alt="">
            </button>

            <!-- Dropdown -->
            <div class="calendar_admin_details_create_cohort_manage_class_tab_menu" id="newTeacherDropdownMenu">
                <div class="calendar_admin_details_create_cohort_manage_class_tab_panel" role="listbox"
                    aria-labelledby="newTeacherDropdownTrigger" id="newTeacherDropdownList">
                    <input type="text" id="newTeacherSearchInput" class="dropdown-search"
                        placeholder="Enter Teacher Name...">
                    <!-- Items (dynamic) -->
                    <?php
                    /** Collect unique teacher user IDs from cohorts */
                    $userIds = $DB->get_fieldset_sql("
                        SELECT DISTINCT uid
                          FROM (
                                SELECT cohortmainteacher AS uid FROM {cohort}
                                 WHERE cohortmainteacher IS NOT NULL AND cohortmainteacher > 0
                                UNION
                                SELECT cohortguideteacher AS uid FROM {cohort}
                                 WHERE cohortguideteacher IS NOT NULL AND cohortguideteacher > 0
                          ) t
                    ");

                    /** Fetch user records (not deleted/suspended) */
                    $teachersNew = [];
                    if ($userIds) {
                        list($inSql, $params) = $DB->get_in_or_equal($userIds, SQL_PARAMS_NAMED);
                        $fields = "id, firstname, lastname, picture, imagealt, firstnamephonetic, lastnamephonetic, middlename, alternatename";
                        $teachersNew = $DB->get_records_select('user', "id $inSql AND deleted = 0 AND suspended = 0", $params, 'firstname ASC, lastname ASC', $fields);
                    }
                    $teachersNewHtml = '';

                    if (!empty($teachersNew)) {
                        foreach ($teachersNew as $teacher) {
                            $picture = new user_picture($teacher);
                            $picture->size = 50;
                            $imageUrl = $picture->get_url($PAGE)->out(false);
                            $name   = fullname($teacher, true);

                            $teachersNewHtml .=
                                '<div class="calendar_admin_details_create_cohort_manage_class_tab_item new-teacher-item" role="option" '.
                                    'data-userid="'.(int)$teacher->id.'" '.
                                    'data-name="'.s($name).'" '.
                                    'data-img="'.s($imageUrl).'">'.
                                    '<img class="calendar_admin_details_create_cohort_manage_class_tab_avatar" src="'.s($imageUrl).'" alt="'.s($name).'" />'.
                                    '<span class="calendar_admin_details_create_cohort_manage_class_tab_item_name">'.format_string($name).'</span>'.
                                '</div>';
                        }
                    } else {
                        $teachersNewHtml =
                            '<div class="calendar_admin_details_create_cohort_manage_class_tab_item" role="option" aria-disabled="true">'.
                                '<span class="calendar_admin_details_create_cohort_manage_class_tab_item_name">No teachers found</span>'.
                            '</div>';
                    }
                    echo $teachersNewHtml;
                    ?>
                </div>
            </div>
        </div>
    </div>

    <label class="one2one-section-label">Lesson type</label>
    <div class="one2one-lesson-type-row">
        <div class="one2one-lesson-type-btn-manage " data-type="single">
            <span class="one2one-lesson-type-icon">
                <img src="./img/single-lesson" alt="">
            </span>
            Single lessons
            <input type="radio" class="one2one-radio" name="lessonType" value="single">
        </div>
        <div class="one2one-lesson-type-btn-manage" data-type="weekly">
            <span class="one2one-lesson-type-icon">
                <img src="./img/weekly-lesson" alt="">
            </span>
            Weekly lessons
            <input type="radio" class="one2one-radio" name="lessonType" value="weekly">
        </div>
    </div>

    <div id="custom-single-lesson-manage">
        <label class="one2one-section-label">Select Single Lesson</label>
        <div class="dropdown-container" id="singleLessonDropdownWrapper">
            <div class="dropdown-display" id="singleLessonDropdownDisplayManage"> Single Lessons
            </div>

            <section id="single-lesson-dropdown-section">
                <div class="single-lesson-dropdown-card dropdown-content">

                </div>
            </section>
        </div>
        <label class="one2one-section-label">Date and time</label>

        <div class="dropdown-container" id="durationDropdownWrapper">
            <div class="dropdown-display" id="durationDropdownDisplayManage">50 Minutes (Standard time)</div>
            <div class="dropdown-content" id="durationDropdownListManage">
                <div class="one2one-duration-option" data-minutes="20">20 Minutes</div>
                <div class="one2one-duration-option selected" data-minutes="50">50 Minutes</div>
                <div class="one2one-duration-option" data-minutes="60">1 Hour</div>
                <div class="one2one-duration-option" data-minutes="90">1 Hour 30 Minutes</div>
                <div class="one2one-duration-option" data-minutes="120">2 Hours</div>
            </div>
        </div>

        <div class="one2one-datetime-dropdown-row">
            <div class="one2one-date-dropdown-display" id="customDateDropdownDisplayManage"
                style="width:100%; padding:13px 14px; border-radius:10px; border:1.5px solid #dadada; background:#fff; font-size:1.05rem; color:#232323; margin-bottom:12px; cursor:pointer; display:flex; align-items:center; justify-content:center;">
                <span id="selectedDateTextManage">Tue, Feb11</span>
            </div>
            <div class="d-flex" id="customTimeFields" style="width:100%;">
                <div class="custom-time-pill" style="width:100%;">
                    <input type="text" class="form-control time-input" value="10:30 am" autocomplete="off" readonly
                        style="background-color:#ffffff; height: 50px;" />
                    <div class="custom-time-dropdown"></div>
                </div>
            </div>
        </div>
    </div>

    <div id="custom-weekly-lesson-manage" style="display:none;">

        <label class="one2one-section-label">Select Weekly Lesson</label>
        <div class="dropdown-container" id="weeklyLessonDropdownWrapper">
            <div class="dropdown-display" id="weeklyLessonDropdownDisplayManage"> Weekly Lessons
            </div>
            <section id="weekly-single-lesson">
                <div class="weekly-single-lesson-container dropdown-content">

                </div>
            </section>
        </div>

        <div id="weeklyLessonModalBackdropManage" class="weekly_lesson_modal_backdrop">
            <div class="weekly_lesson_modal_container">
                <div style="margin-bottom:16px;">
                    <div style="display:flex; align-items:center; gap:13px; margin-top:7px;">
                        <label style="font-weight:600; color:#000000;">Repeat Every</label>

                        <button class="weekly_lesson_stepper_manage" id="weeklyLessonIntervalMinusManage">−</button>
                        <span id="weeklyLessonIntervalDisplayManage"
                            style="font-size:1.18rem;font-weight:bold;">1</span>
                        <button class="weekly_lesson_stepper_manage" id="weeklyLessonIntervalPlusManage">+</button>
                        <div class="weekly_lesson_dropdown_wrapper">
                            <div class="weekly_lesson_dropdown_btn" id="weeklyLessonPeriodBtnManage">
                                <span id="weeklyLessonPeriodDisplayManage">Week</span>
                                <svg width="18" height="18" viewBox="0 0 20 20">
                                    <path d="M7 8l3 3 3-3" fill="none" stroke="#232323" stroke-width="2"></path>
                                </svg>
                            </div>
                            <div class="weekly_lesson_dropdown_list_manage" id="weeklyLessonPeriodListManage">
                                <div class="weekly_lesson_option_manage">Week</div>
                                <div class="weekly_lesson_option_manage">Bi-Weekly</div>
                            </div>
                        </div>
                    </div>
                </div>

                <hr class="weekly_lesson_hr">
                <div style="margin-bottom:16px; display:flex; align-items:center; gap:10px;">
                    <label style="font-weight:600; color:#000000;">Start Date</label>
                    <button id="weeklyLessonStartDateBtnManage" class="weekly_lesson_date_btn enabled"
                        style="margin-top:7px; text-align:left; padding:12px 18px;">
                        <span id="weeklyLessonStartDateTextManage">Select start date</span>
                    </button>
                </div>

                <div class="monthly_cal_modal_backdrop" id="weeklyLessonStartDateCalendarBackdropManage"
                    style="display:none;">
                    <div class="monthly_cal_modal">
                        <div class="monthly_cal_header">
                            <button id="weeklyLessonCalendarPrevManage"
                                style="background:none;border:none;font-size:1.4rem;cursor:pointer;color:#232323;"
                                aria-label="Previous month">&#8592;</button>
                            <span class="monthly_cal_month_label" id="weeklyLessonCalendarMonthManage"></span>
                            <button id="weeklyLessonCalendarNextManage"
                                style="background:none;border:none;font-size:1.4rem;cursor:pointer;color:#232323;"
                                aria-label="Next month">&#8594;</button>
                        </div>
                        <div class="monthly_cal_grid" id="weeklyLessonCalendarDaysManage"></div>
                        <div class="monthly_cal_grid" id="weeklyLessonCalendarDatesManage"></div>
                        <button class="monthly_cal_done_btn" id="weeklyLessonCalendarDoneManage">Done</button>
                    </div>
                </div>
                <div id="weeklyLessonRepeatContainerManage">
                    <label style="font-weight:600; color:#000000;">Repeat on</label>
                    <div class="weekly_lesson_widget_row" id="weeklyLessonWidgetsRowManage">
                        <!-- Widgets injected by JS -->
                    </div>
                </div>

                <hr class="weekly_lesson_hr large">

                <div>
                    <label style="font-weight:600;">Ends</label>
                    <div style="margin-top:8px;">
                        <div style="display:flex;align-items:center; gap:10px; margin-bottom:6px;">
                            <input type="radio" id="weeklyLessonEndNeverManage" name="weeklyLessonEndOptionManage"
                                checked>
                            <label for="weeklyLessonEndNeverManage" style="font-size:1.05rem;">Never</label>
                        </div>
                        <div style="display:flex;align-items:center; gap:10px; margin-bottom:6px;">
                            <input type="radio" id="weeklyLessonEndOnManage" name="weeklyLessonEndOptionManage">
                            <label for="weeklyLessonEndOnManage" style="font-size:1.05rem;">On</label>
                            <button id="weeklyLessonEndDateBtnManage" disabled class="weekly_lesson_date_btn">Sep 27,
                                2024</button>
                        </div>
                        <div style="display:flex;align-items:center; gap:10px;">
                            <input type="radio" id="weeklyLessonEndAfterManage" name="weeklyLessonEndOptionManage">
                            <label for="weeklyLessonEndAfterManage" style="font-size:1.05rem;">After</label>
                            <div class="weekly_lesson_occurrence_counter" style="margin-left:12px;">
                                <button class="weekly_lesson_stepper_manage" id="weeklyLessonOccurrenceMinusManage"
                                    disabled>−</button>
                                <span id="weeklyLessonOccurrenceDisplayManage"
                                    style="font-size:1.11rem;font-weight:600;">13
                                    occurrences</span>
                                <button class="weekly_lesson_stepper_manage" id="weeklyLessonOccurrencePlusManage"
                                    disabled>+</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- ========= TIME PICKER FOR WEEKLY ========= -->
        <div id="weeklyLessonTimepickerBackdropManage" class="weekly_lesson_timepicker_modal_backdrop_manage">
            <div class="weekly_lesson_timepicker_modal">
                <h2 class="weekly_lesson_timepicker_card_title" id="weeklyLessonTimepickerDayLabelManage">Select Start &
                    End Time</h2>
                <div class="weekly_lesson_timepicker_inputs_container">
                    <input id="weekly_lesson_timepicker_start_manage" type="text" class="weekly_lesson_timepicker_input"
                        value="09:00 AM" />
                    <span style="color:#232323;">–</span>
                    <input id="weekly_lesson_timepicker_end_manage" type="text" class="weekly_lesson_timepicker_input"
                        value="10:00 AM" />
                </div>
                <div class="weekly_lesson_timepicker_button_container">
                    <button id="weeklyLessonTimepickerCancelBtnManage"
                        class="weekly_lesson_timepicker_cancel_btn_manage">Cancel</button>
                    <button id="weeklyLessonTimepickerDoneBtnManage"
                        class="weekly_lesson_timepicker_done_btn_manage">Done</button>
                </div>
            </div>
        </div>
    </div>

    <button class="calendar_admin_details_create_cohort_schedule_btn_manage" disabled>Update 1:1 class</button>
</div>

<!-- Loader Overlay -->
<div class="loader-overlay" id="loaderOverlay">
    <img src="../../img/loader.png" alt="Loading..." class="spin-logo" style="width:100px;height:100px;">
</div>

<!-- Custom Calendar Modal -->
<div class="calendar-modal-backdrop" id="calendarModalBackdropManage">
    <div class="calendar-modal" id="calendarModal">
        <div class="calendar-modal-header">
            <button type="button" class="calendar-modal-arrow" id="calendarPrevMonthManage"><svg width="22" height="22"
                    viewBox="0 0 24 24">
                    <polyline points="15 19 8 12 15 5" fill="none" stroke="#111" stroke-width="2" stroke-linecap="round"
                        stroke-linejoin="round"></polyline>
                </svg></button>
            <span id="calendarMonthYearManage">January 2025</span>
            <button type="button" class="calendar-modal-arrow" id="calendarNextMonthManage"><svg width="22" height="22"
                    viewBox="0 0 24 24">
                    <polyline points="9 19 16 12 9 5" fill="none" stroke="#111" stroke-width="2" stroke-linecap="round"
                        stroke-linejoin="round"></polyline>
                </svg></button>
        </div>
        <div class="calendar-modal-grid">
            <div class="calendar-modal-weekdays">
                <div>Mo</div>
                <div>Tu</div>
                <div>We</div>
                <div>Th</div>
                <div>Fr</div>
                <div>Sa</div>
                <div>Su</div>
            </div>
            <div class="calendar-modal-days" id="calendarDaysGridManage">
                <!-- Days rendered by JS -->
            </div>
        </div>
        <div class="calendar-modal-footer">
            <button class="calendar-modal-done" id="calendarDoneBtnManage">Done</button>
        </div>
    </div>
</div>

<!-- Global Backdrop for Dropdowns -->
<div class="dropdown-backdrop" id="globalDropdownBackdrop"></div>

<!-- Manage 1:1 Update Scope Modal -->
<div class="manage-update-scope-modal-backdrop" id="manageUpdateScopeModalBackdrop">
    <div class="manage-update-scope-modal">
        <h3 class="manage-update-scope-title">Manage 1:1</h3>
        <div class="manage-update-scope-options">
            <div class="manage-update-scope-option">
                <input type="radio" name="updateScope" id="updateScopeThisEvent" value="this" checked>
                <label for="updateScopeThisEvent">This event</label>
            </div>
            <div class="manage-update-scope-option">
                <input type="radio" name="updateScope" id="updateScopeFollowing" value="following">
                <label for="updateScopeFollowing">This and all following events</label>
            </div>
        </div>
        <div class="manage-update-scope-buttons">
            <button class="manage-update-scope-cancel-btn" id="manageUpdateScopeCancelBtn">Cancel</button>
            <button class="manage-update-scope-ok-btn" id="manageUpdateScopeOkBtn">Ok</button>
        </div>
    </div>
</div>

<!-- Reschedule Lesson Modal -->
<div class="reschedule-lesson-modal-backdrop" id="rescheduleLessonModalBackdrop">
    <div class="reschedule-lesson-modal">
        <div class="reschedule-lesson-header">
            <button class="reschedule-lesson-back-btn" id="rescheduleLessonBackBtn">
                <img src="./img/arrow-back.svg" alt="arrow-left">
            </button>
            <button class="reschedule-lesson-close-btn" id="rescheduleLessonCloseBtn">&times;</button>
        </div>

        <h2 class="reschedule-lesson-title">Reschedule lesson</h2>
        <div class="reschedule-lesson-badge">Updated lesson</div>

        <div class="reschedule-lesson-card">
            <div class="reschedule-lesson-card-header">
                <img src="" alt="" class="reschedule-lesson-avatar" id="rescheduleLessonAvatar">
                <div class="reschedule-lesson-info">
                    <p class="reschedule-lesson-date" id="rescheduleLessonDate">Friday, Sep 06</p>
                    <p class="reschedule-lesson-time" id="rescheduleLessonTime">07:00 - 07:25</p>
                </div>
            </div>
            <div class="reschedule-lesson-meta">
                <span class="reschedule-lesson-student" id="rescheduleLessonStudent">Jonas | Subscription</span>
                <span class="reschedule-lesson-count" id="rescheduleLessonCount">
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none">
                        <path d="M8 2v4M16 2v4M3 10h18M5 4h14a2 2 0 012 2v14a2 2 0 01-2 2H5a2 2 0 01-2-2V6a2 2 0 012-2z"
                            stroke="#666" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                    </svg>
                    2 Lessons
                </span>
            </div>
        </div>

        <div class="reschedule-lesson-dropdown">
            <label class="reschedule-lesson-label">Select a reason to reschedule the lesson.</label>
            <button type="button" class="reschedule-lesson-dropdown-btn" id="rescheduleReasonBtn">
                <span id="rescheduleReasonDisplay">Select Reason</span>
                <svg width="20" height="20" viewBox="0 0 24 24" fill="none">
                    <path d="M6 9l6 6 6-6" stroke="#232323" stroke-width="2" stroke-linecap="round"
                        stroke-linejoin="round" />
                </svg>
            </button>
            <div class="reschedule-lesson-dropdown-list" id="rescheduleReasonList">
                <div class="reschedule-lesson-dropdown-item" data-value="not_able_to_make_it">He's not able to make it
                    today.</div>
                <div class="reschedule-lesson-dropdown-item" data-value="timing_not_working">The timing isn't working
                    out today.</div>
                <div class="reschedule-lesson-dropdown-item" data-value="tech_issues">There are some tech issues, so we
                    can't run the class.</div>
                <div class="reschedule-lesson-dropdown-item" data-value="teacher_unavailable">The teacher isn't
                    available right now.</div>
            </div>
        </div>

        <div>
            <label class="reschedule-lesson-label">Message for Student</label>
            <textarea class="reschedule-lesson-textarea" id="rescheduleMessage"
                placeholder="Message for Jonas"></textarea>
        </div>

        <button class="reschedule-lesson-confirm-btn" id="rescheduleConfirmBtn" disabled>Confirm new time</button>
    </div>
</div>

<!-- Toast Notification -->
<div id="toastNotificationForManageClass" style="display:none; position:fixed; top:30px; right:30px; 
            background:#000; color:#fff; padding:16px 24px; 
            border-radius:8px; font-size:1rem; 
            box-shadow:0 4px 12px rgba(0,0,0,0.3);
            z-index:99999; opacity:0; transition:opacity .3s, transform .3s;
            transform:translateY(20px);">
</div>

<script>
// ====== TOAST NOTIFICATION FUNCTION ======
function showToastManage(message, duration = 5000) {
    const toast = document.getElementById('toastNotificationForManageClass');
    if (!toast) return;

    toast.textContent = message;
    toast.style.display = 'block';
    setTimeout(() => {
        toast.style.opacity = '1';
        toast.style.transform = 'translateY(0)';
    }, 100);
    setTimeout(() => {
        toast.style.opacity = '0';
        toast.style.transform = 'translateY(20px)';
        setTimeout(() => {
            toast.style.display = 'none';
        }, 300);
    }, duration);
}

// ====== GLOBAL STATE AND UTILITIES ======
const DropdownManager = {
    activeDropdown: null,

    init() {
        // Set up global backdrop click handler
        document.getElementById('globalDropdownBackdrop').addEventListener('click', () => {
            this.closeAll();
        });

        // Initialize all dropdowns
        this.initializeDropdowns();
    },

    initializeDropdowns() {
        // Find all dropdown containers
        const dropdownContainers = document.querySelectorAll('.dropdown-container');

        dropdownContainers.forEach(container => {
            const display = container.querySelector('.dropdown-display');
            const content = container.querySelector('.dropdown-content');

            if (display && content) {
                display.addEventListener('click', (e) => {
                    e.stopPropagation();
                    this.toggleDropdown(container, content);
                });

                // Close dropdown when clicking an option
                content.addEventListener('click', (e) => {
                    if (e.target.classList.contains('one2one-duration-option') ||
                        e.target.classList.contains('single-lesson-dropdown-item') ||
                        e.target.classList.contains('weekly-single-lesson-item')) {
                        setTimeout(() => this.closeAll(), 100);
                    }
                });
            }
        });
    },

    toggleDropdown(container, content) {
        if (this.activeDropdown === content) {
            this.closeAll();
            return;
        }

        this.closeAll();
        this.activeDropdown = content;
        content.classList.add('active');
        document.getElementById('globalDropdownBackdrop').classList.add('active');
    },

    closeAll() {
        if (this.activeDropdown) {
            this.activeDropdown.classList.remove('active');
            this.activeDropdown = null;
        }
        document.getElementById('globalDropdownBackdrop').classList.remove('active');
    }
};

// ====== GLOBAL FUNCTIONS ======

function formatMinutesToDisplay(minutes) {
    if (minutes < 60) {
        return `${minutes} Minutes`;
    }

    const hours = Math.floor(minutes / 60);
    const mins = minutes % 60;

    if (mins === 0) {
        return hours === 1 ? '1 Hour' : `${hours} Hours`;
    }

    return `${hours} Hour${hours > 1 ? 's' : ''} ${mins} Minutes`;
}

function getSelectedDurationInMinutes() {
    // First try to get from the display element's data attribute
    const displayEl = document.getElementById('durationDropdownDisplayManage');
    if (displayEl && displayEl.dataset.minutes) {
        return parseInt(displayEl.dataset.minutes) || 50;
    }

    // Fallback to selected option
    const selectedOption = document.querySelector('.one2one-duration-option.selected');
    return selectedOption ? parseInt(selectedOption.dataset.minutes) || 50 : 50;
}

function updateEndsUI() {
    const $ = (sel, root = document) => root.querySelector(sel);
    const onChecked = $('#weeklyLessonEndOnManage')?.checked;
    const afterChecked = $('#weeklyLessonEndAfterManage')?.checked;

    const endBtn = $('#weeklyLessonEndDateBtnManage');
    if (endBtn) {
        endBtn.disabled = !onChecked;
        endBtn.classList.toggle('enabled', !!onChecked);
    }

    const occMinusBtn = $('#weeklyLessonOccurrenceMinusManage');
    const occPlusBtn = $('#weeklyLessonOccurrencePlusManage');

    if (occMinusBtn) occMinusBtn.disabled = !afterChecked;
    if (occPlusBtn) occPlusBtn.disabled = !afterChecked;
}

function convert12hTo24h(time12h) {
    const [time, period] = time12h.split(' ');
    let [hours, minutes] = time.split(':');

    hours = parseInt(hours);
    minutes = minutes || '00';

    if (period === 'PM' && hours < 12) {
        hours += 12;
    }
    if (period === 'AM' && hours === 12) {
        hours = 0;
    }

    return `${String(hours).padStart(2, '0')}:${minutes}`;
}

function convert24hTo12h(time24h) {
    const [hours, minutes] = time24h.split(':');
    let hour = parseInt(hours);
    const minute = minutes;

    const period = hour >= 12 ? 'PM' : 'AM';
    hour = hour % 12;
    if (hour === 0) hour = 12;

    return `${hour}:${minute} ${period}`;
}

function renderWidgetTimeManage(key, start, end) {
    const widget = document.querySelector(`.weekly_lesson_scroll_widget_manage[data-key="${key}"]`);
    if (!widget) return;

    // Convert 24h to 12h for display
    const start12h = convert24hTo12h(start);
    const end12h = convert24hTo12h(end);

    const [startTime, startPeriod] = start12h.split(' ');
    const [endTime, endPeriod] = end12h.split(' ');

    let timeElement = widget.querySelector('.weekly_lesson_widget_time_manage');
    if (!timeElement) {
        timeElement = document.createElement('div');
        timeElement.className = 'weekly_lesson_widget_time_manage';
        timeElement.innerHTML = `
            <div class="weekly_lesson_widget_hour_minute_manage start">${startTime}</div>
            <span class="weekly_lesson_widget_period_manage start-period">${startPeriod}</span>
            <span class="weekly_lesson_widget_dash_manage">-</span>
            <div class="weekly_lesson_widget_hour_minute_manage end">${endTime}</div>
            <span class="weekly_lesson_widget_period_manage end-period">${endPeriod}</span>
        `;

        // Insert after the divider
        const divider = widget.querySelector('.weekly_lesson_widget_divider_manage');
        if (divider) {
            divider.after(timeElement);
        }
    } else {
        // Update existing time element
        timeElement.querySelector('.start').textContent = startTime;
        timeElement.querySelector('.start-period').textContent = startPeriod;
        timeElement.querySelector('.end').textContent = endTime;
        timeElement.querySelector('.end-period').textContent = endPeriod;
    }

    // **FIX: Mark time element as having time**
    timeElement.classList.add('has-time');

    // **FIX: Hide the arrow button and show time dot instead**
    const button = widget.querySelector('.weekly_lesson_widget_button_manage');
    if (button) {
        button.classList.add('has-time');

        // Create time pill badge on the button (for when button shows)
        let dot = button.querySelector('.weekly_lesson_dot');
        if (!dot) {
            dot = document.createElement('span');
            dot.className = 'weekly_lesson_dot';
            button.appendChild(dot);
        }
        // short label - just show hours
        const startHour = startTime.split(':')[0];
        const endHour = endTime.split(':')[0];
        dot.textContent = `${startHour}–${endHour}`;
    }

    // **FIX: Make the time element clickable to edit**
    timeElement.style.cursor = 'pointer';
    timeElement.onclick = function(e) {
        e.stopPropagation();
        // Trigger the time picker
        const pickerBackdrop = $('#weeklyLessonTimepickerBackdropManage');
        if (pickerBackdrop) {
            weeklyLessonCurrentDayKey = key;

            const current = window.weeklyLessonDayTimes[key] || {
                start: '09:00',
                end: '10:00'
            };
            const start12h = convert24hTo12h(current.start);
            const end12h = convert24hTo12h(current.end);

            $('#weekly_lesson_timepicker_start_manage').value = start12h;
            $('#weekly_lesson_timepicker_end_manage').value = end12h;

            // Ensure pbd is always a single element
            let pbd = pickerBackdrop?. [0] ?? pickerBackdrop;
            pbd.style.display = 'block';


        }
    };
}

function formatDate(dateObj) {
    const months = ["Jan", "Feb", "Mar", "Apr", "May", "Jun",
        "Jul", "Aug", "Sep", "Oct", "Nov", "Dec"
    ];
    const day = dateObj.getDate().toString().padStart(2, '0');
    return `${months[dateObj.getMonth()]} ${day}, ${dateObj.getFullYear()}`;
}

function formatTime12Hour(date) {
    let hours = date.getHours();
    let minutes = date.getMinutes();
    const ampm = hours >= 12 ? 'PM' : 'AM';

    hours = hours % 12;
    hours = hours ? hours : 12; // the hour '0' should be '12'
    minutes = minutes < 10 ? '0' + minutes : minutes;

    return `${hours}:${minutes} ${ampm}`;
}

function formatTime12HourFromParts(hours, minutes) {
    const ampm = hours >= 12 ? 'PM' : 'AM';
    hours = hours % 12;
    hours = hours ? hours : 12; // the hour '0' should be '12'
    minutes = minutes < 10 ? '0' + minutes : minutes;
    return `${hours}:${minutes} ${ampm}`;
}

function getDayIcon(day) {
    const iconMap = {
        'Sun': './img/ev-repeat.svg',
        'Mon': './img/ev-repeat.svg',
        'Tue': './img/ev-repeat.svg',
        'Wed': './img/ev-repeat.svg',
        'Thu': './img/ev-repeat.svg',
        'Fri': './img/ev-repeat.svg',
        'Sat': './img/ev-repeat.svg'
    };
    return iconMap[day] || './img/ev-repeat.svg';
}

// ====== STUDENT MANAGEMENT ======
async function loadStudentsForTeacher(teacherId, selectFirst = true) {
    const studentDropdownWrap = document.getElementById('one2oneStudentDropdownManage');
    const addStudentBtn = document.getElementById('one2oneAddStudentBtnManage');
    const studentDropdownWrapper = document.getElementById('studentDropdownWrapper');
    const loaderOverlay = document.getElementById('loaderOverlay');

    if (!teacherId || !studentDropdownWrap) return;

    // Show loader
    if (loaderOverlay) loaderOverlay.classList.add('active');

    try {

        const response =


            await fetch('ajax/ajax_one2one_students.php?teacherid=' + encodeURIComponent(teacherId), {
                credentials: 'same-origin'
            });
        const data = await response.json();

        // if no students, reset dropdown
        if (!data.html || data.html.trim() === '' || data.html.includes('No students found')) {
            studentDropdownWrap.innerHTML = `
            <input type="text" id="studentSearchInputManage" class="dropdown-search" placeholder="Enter student name...">
            <div class="one2one-no-students" style="padding:10px; color:#777;">No students available</div>
        `;
            if (addStudentBtn) {
                addStudentBtn.innerHTML = `<span style="color:#aaa;">No student selected</span>`;
                addStudentBtn.classList.remove('active');
            }
            // Enable dropdown wrapper even if no students
            if (studentDropdownWrapper) {
                studentDropdownWrapper.classList.remove('disabled');
                addStudentBtn.classList.remove('disabled');
            }
            if (loaderOverlay) loaderOverlay.classList.remove('active');
            validateForm();
            return;
        }

        // normal case — populate list
        studentDropdownWrap.innerHTML = `
        <input type="text" id="studentSearchInputManage" class="dropdown-search" placeholder="Enter student name...">
        ${data.html}
    `;

        // Enable dropdown wrapper
        if (studentDropdownWrapper) {
            studentDropdownWrapper.classList.remove('disabled');
            if (addStudentBtn) addStudentBtn.classList.remove('disabled');
        }

        // auto-select first student if available
        if (selectFirst) {
            const items = studentDropdownWrap.querySelectorAll('.one2one-student-list-item:not([aria-disabled])');
            if (items.length) {
                items.forEach(item => item.classList.remove('selected'));
                items[0].classList.add('selected');

                // reflect on "Add student" pill
                if (addStudentBtn) {
                    const avatar = items[0].querySelector('.one2one-student-list-avatar')?.innerHTML || '';
                    const name = items[0].dataset.name || items[0].querySelector('.one2one-student-list-name')
                        ?.textContent || 'Student';
                    addStudentBtn.innerHTML = `
                    <span class="one2one-add-student-icon">${avatar}</span>
                    <span style="font-weight:600; color:#232323;">${name}</span>
                `;
                    addStudentBtn.classList.add('active');
                }
            } else {
                // no selectable students
                if (addStudentBtn) {
                    addStudentBtn.innerHTML = `<span style="color:#aaa;">No student selected</span>`;
                    addStudentBtn.classList.remove('active');
                }
            }
        }
        // Hide loader after students loaded
        if (loaderOverlay) loaderOverlay.classList.remove('active');
        validateForm();
    } catch (error) {
        console.warn('Could not load students for teacher', error);
        // reset if request failed
        studentDropdownWrap.innerHTML = `
        <input type="text" id="studentSearchInputManage" class="dropdown-search" placeholder="Enter student name...">
        <div class="one2one-no-students" style="padding:10px; color:#777;">Unable to load students</div>
    `;
        if (addStudentBtn) {
            addStudentBtn.innerHTML = `<span style="color:#aaa;">No student selected</span>`;
            addStudentBtn.classList.remove('active');
        }
        // Hide loader on error
        if (loaderOverlay) loaderOverlay.classList.remove('active');
        validateForm();
    }
}

// ====== FORM VALIDATION ======
function validateForm() {
    const scheduleBtn = document.querySelector('.calendar_admin_details_create_cohort_schedule_btn_manage');
    if (!scheduleBtn) return;

    const teacherTrigger = document.getElementById('calendar_admin_details_create_cohort_manage_class_tab_trigger');
    const teacherId = teacherTrigger?.dataset.userid;

    const studentDropdownWrap = document.getElementById('one2oneStudentDropdownManage');
    const selectedStudent = studentDropdownWrap?.querySelector('.one2one-student-list-item.selected');
    const studentId = selectedStudent?.dataset.userid;

    const lessonType = document.querySelector('.one2one-lesson-type-btn-manage.selected')?.dataset.type;

    // Enable button only if all required fields are selected
    if (teacherId && studentId && lessonType) {
        scheduleBtn.disabled = false;
    } else {
        scheduleBtn.disabled = true;
    }
}

// ====== CORRECTED SINGLE LESSON DROPDOWN ======
function populateSingleLessonDropdown(jsonData) {
    const dropdownCard = document.querySelector('.single-lesson-dropdown-card');
    const dropdownContent = document.getElementById('singleLessonDropdownDisplayManage');
    if (!dropdownCard) return;

    if (jsonData.activities.length === 0) {
        dropdownContent.innerHTML = 'No single lessons found';
        dropdownCard.innerHTML =
            `<div class="single-lesson-dropdown-item"><div style="text-align:center;">No single lessons found</div></div>`;
        return;
    }

    dropdownCard.innerHTML = '';

    if (jsonData.activities && jsonData.activities.length > 0) {
        let firstProcessed = false;

        jsonData.activities.forEach((activity, idx) => {
            const gm = activity.googlemeet;
            if (!gm) return;

            const startDate = parseFirstStartDisp(gm.first_start_disp);
            const month = startDate.toLocaleDateString('en-US', {
                month: 'short'
            });
            const day = startDate.getDate();
            const dayOfWeek = startDate.toLocaleDateString('en-US', {
                weekday: 'long'
            });

            const startTime = formatTime12HourFromParts(parseInt(gm.starthour), parseInt(gm.startminute));
            const endTime = formatTime12HourFromParts(parseInt(gm.endhour), parseInt(gm.endminute));

            const durationSeconds = gm.events[0]?.duration || 0;
            const durationMinutes = Math.round(durationSeconds / 60);

            const item = document.createElement('div');
            item.className = 'single-lesson-dropdown-item';
            item.dataset.activityIndex = idx;
            item.dataset.startTime = startTime;
            item.dataset.endTime = endTime;
            // expose cmid on the DOM element and to the global selected variable when chosen
            try {
                console.log('single activity gm:', gm);
            } catch (e) {}
            if (gm && typeof gm.id !== 'undefined' && gm.id !== null) {
                item.dataset.cmid = String(gm.id);
            }

            item.innerHTML = `
                <div class="single-lesson-dropdown-item__date">
                    <span class="single-lesson-dropdown-date-month">${month}</span>
                    <span class="single-lesson-dropdown-date-day">${day}</span>
                </div>
                <div class="single-lesson-dropdown-item__details">
                    <p class="single-lesson-dropdown-details-time">${dayOfWeek}, ${startTime} - ${endTime}</p>
                    <div class="single-lesson-dropdown-details-info">
                        <span class="single-lesson-dropdown-info-text">Activity ${idx + 1}</span>
                        <span class="single-lesson-dropdown-info-dot"></span>
                        <span class="single-lesson-dropdown-info-text">Single lesson</span>
                        <span class="single-lesson-dropdown-info-dot"></span>
                        <span class="single-lesson-dropdown-info-text">${durationMinutes} min</span>
                    </div>
                </div>
            `;

            item.addEventListener('click', function() {
                dropdownCard.querySelectorAll('.single-lesson-dropdown-item').forEach(i => i.classList
                    .remove('selected'));
                this.classList.add('selected');

                // ✅ Read values dynamically from the clicked element
                const clickedStartTime = this.dataset.startTime;
                const clickedEndTime = this.dataset.endTime;
                const activityIndex = this.dataset.activityIndex;
                const activity = jsonData.activities[activityIndex];

                if (!activity || !activity.googlemeet) return;

                const gm = activity.googlemeet;
                const clickedStartDate = parseFirstStartDisp(gm.first_start_disp);
                const durationSeconds = gm.events[0]?.duration || 0;
                const clickedDurationMinutes = Math.round(durationSeconds / 60);

                const disp = document.getElementById('singleLessonDropdownDisplayManage');
                if (disp) {
                    const month = clickedStartDate.toLocaleDateString('en-US', {
                        month: 'short'
                    });
                    const day = clickedStartDate.getDate();
                    const dayOfWeek = clickedStartDate.toLocaleDateString('en-US', {
                        weekday: 'long'
                    });

                    disp.textContent =
                        `${month} ${day}, ${dayOfWeek}, ${clickedStartTime} - ${clickedEndTime}`;

                    const cmidVal = (gm && typeof gm.id !== 'undefined') ? gm.id : (this.dataset
                        ?.cmid ?? null);
                    if (cmidVal !== null && typeof cmidVal !== 'undefined' && cmidVal !== '') {
                        disp.dataset.cmid = String(cmidVal);
                        const wrapper = document.getElementById('singleLessonDropdownWrapper');
                        if (wrapper) wrapper.dataset.cmid = String(cmidVal);
                    }
                }

                window.selectedCmidManage = (gm && typeof gm.id !== 'undefined') ? gm.id : (this.dataset
                    ?.cmid ?? null);

                // ✅ Use the dynamically read values
                updateDateTimeFields(clickedStartDate, clickedStartTime, clickedEndTime,
                    clickedDurationMinutes);
            });

            dropdownCard.appendChild(item);
            if (!firstProcessed) {
                setTimeout(() => item.click(), 50);
                firstProcessed = true;
            }
        });
    } else {
        dropdownCard.innerHTML =
            `<div class="single-lesson-dropdown-item"><div style="text-align:center;">No single lessons found</div></div>`;
    }
}

// If you need to convert it to a Date object for the calendar:
function parseFirstStartDisp(dispString) {
    // Parse "Tue, 11 Feb 2025 10:30 AM" format
    const parts = dispString.split(' ');
    const day = parseInt(parts[1]);
    const monthStr = parts[2];
    const year = parseInt(parts[3]);

    const monthMap = {
        'Jan': 0,
        'Feb': 1,
        'Mar': 2,
        'Apr': 3,
        'May': 4,
        'Jun': 5,
        'Jul': 6,
        'Aug': 7,
        'Sep': 8,
        'Oct': 9,
        'Nov': 10,
        'Dec': 11
    };

    return new Date(year, monthMap[monthStr], day);
}
// ====== CORRECTED WEEKLY LESSON DROPDOWN ======f
function populateWeeklyLessonDropdown(jsonData) {
    const dropdownContainer = document.querySelector('.weekly-single-lesson-container');
    const dropdownContent = document.getElementById('weeklyLessonDropdownDisplayManage');
    if (jsonData.activities.length === 0) {
        dropdownContent.innerHTML = 'No weekly lessons found';
        dropdownContainer.innerHTML =
            `
            <div class="weekly-single-lesson-item"><div style="text-align:center;">No weekly lessons found</div></div>`;
        return;
    }

    if (!dropdownContainer) return;
    dropdownContainer.innerHTML = '';

    if (jsonData.activities && jsonData.activities.length > 0) {
        let firstProcessed = false;

        jsonData.activities.forEach((activity, idx) => {
            const gm = activity.googlemeet;
            if (!gm) return;

            // Parse days
            const daysObj = JSON.parse(gm.days || '{}');
            const activeDays = Object.keys(daysObj).filter(d => daysObj[d] === "1");
            if (activeDays.length === 0) return;

            const startTime = formatTime12HourFromParts(parseInt(gm.starthour), parseInt(gm.startminute));
            const endTime = formatTime12HourFromParts(parseInt(gm.endhour), parseInt(gm.endminute));
            const durationMinutes = ((gm.endhour * 60 + gm.endminute) - (gm.starthour * 60 + gm.startminute));

            // Join all days in one string like "Monday and Thursday"
            const joinedDays = activeDays.map(d => fullDayName(d)).join(' and ');

            const item = document.createElement('div');
            item.className = 'weekly-single-lesson-item';
            item.dataset.activityIndex = idx;
            item.dataset.startTime = startTime;
            item.dataset.endTime = endTime;
            // expose cmid on the DOM element for later use
            try {
                console.log('weekly activity gm:', gm);
            } catch (e) {}
            if (gm && typeof gm.id !== 'undefined' && gm.id !== null) {
                item.dataset.cmid = String(gm.id);
            }

            item.innerHTML = `
                <img src="${getDayIcon(activeDays[0])}" alt="Repeat icon" class="weekly-single-lesson-icon">
                <div class="weekly-single-lesson-details">
                    <p class="weekly-single-lesson-time">Every ${joinedDays}, ${startTime} - ${endTime}</p>
                    <p class="weekly-single-lesson-description">Weekly lesson • ${durationMinutes} min • Activity ${idx + 1}</p>
                </div>
            `;

            item.addEventListener('click', function() {
                dropdownContainer.querySelectorAll('.weekly-single-lesson-item').forEach(i => i
                    .classList.remove('selected'));
                this.classList.add('selected');

                const disp = document.getElementById('weeklyLessonDropdownDisplayManage');
                if (disp) {
                    disp.textContent = `Every ${joinedDays}, ${startTime} - ${endTime}`;
                    const cmidVal = (gm && typeof gm.id !== 'undefined') ? gm.id : (this.dataset
                        ?.cmid ?? null);
                    if (cmidVal !== null && typeof cmidVal !== 'undefined' && cmidVal !== '') {
                        disp.dataset.cmid = String(cmidVal);
                        const wrapper = document.getElementById('weeklyLessonDropdownWrapper');
                        if (wrapper) wrapper.dataset.cmid = String(cmidVal);
                    } else {
                        disp.removeAttribute('data-cmid');
                        const wrapper = document.getElementById('weeklyLessonDropdownWrapper');
                        if (wrapper) wrapper.removeAttribute('data-cmid');
                    }
                }

                // record the selected cmid for payloads (fallback to element dataset if gm missing)
                window.selectedCmidManage = (gm && typeof gm.id !== 'undefined') ? gm.id : (this
                    .dataset?.cmid ?? null);
                try {
                    console.log('weekly selected cmid:', window.selectedCmidManage, 'element dataset:',
                        this.dataset.cmid, 'display dataset:', document.getElementById(
                            'weeklyLessonDropdownDisplayManage')?.dataset?.cmid, 'gm:', gm);
                } catch (e) {}
                populateWeeklyModalWithData(gm, joinedDays, idx, startTime, endTime);
            });

            dropdownContainer.appendChild(item);
            if (!firstProcessed) {
                setTimeout(() => item.click(), 50);
                firstProcessed = true;
            }
        });

        if (dropdownContainer.innerHTML === '') {
            dropdownContainer.innerHTML =
                `<div class="weekly-single-lesson-item"><div style="text-align:center;">No weekly lessons found</div></div>`;
        }
    } else {
        dropdownContainer.innerHTML =
            `<div class="weekly-single-lesson-item"><div style="text-align:center;">No activities found</div></div>`;
    }
}

// Helper for converting short day names
function fullDayName(short) {
    const map = {
        Sun: 'Sunday',
        Mon: 'Monday',
        Tue: 'Tuesday',
        Wed: 'Wednesday',
        Thu: 'Thursday',
        Fri: 'Friday',
        Sat: 'Saturday'
    };
    return map[short] || short;
}

function parseUnixTimestamp(timestamp) {
    // Handle both seconds and milliseconds timestamps
    const ts = parseInt(timestamp, 10);
    return new Date(ts < 1e12 ? ts * 1000 : ts);
}

function populateWeeklyModalWithData(googleMeet, selectedDay, activityIndex, startTime, endTime) {
    console.log(`Populating modal for activity ${activityIndex}, day: ${selectedDay}, time: ${startTime} - ${endTime}`);

    // ---- Get "Ends" section elements ----
    const endNeverRadio = document.getElementById('weeklyLessonEndNeverManage');
    const endOnRadio = document.getElementById('weeklyLessonEndOnManage');
    const endAfterRadio = document.getElementById('weeklyLessonEndAfterManage');
    const endDateBtn = document.getElementById('weeklyLessonEndDateBtnManage');

    // ---- Get timestamps ----
    const startDateStr = googleMeet.eventdate;
    const endDateStr = googleMeet.eventenddate;

    // ---- Populate Start Date ----
    const startDateEl = document.getElementById('weeklyLessonStartDateTextManage');
    if (startDateEl && startDateStr) {
        const startDate = parseUnixTimestamp(startDateStr);
        startDateEl.textContent = formatDate(startDate);
        // store deterministic ISO date for later parsing
        try {
            startDateEl.dataset.fullDate = startDate.toISOString().split('T')[0];
        } catch (e) {}
        window.weeklyLessonStartDate = startDate;
    }

    // ---- Handle End Date + Radio selection ----
    // Reset radios to avoid leftover state
    [endNeverRadio, endOnRadio, endAfterRadio].forEach(r => {
        if (r) r.checked = false;
    });

    if (endDateStr && endDateStr !== "no" && endDateStr !== "0") {
        const endDate = parseUnixTimestamp(endDateStr);
        if (endDateBtn) {
            endDateBtn.textContent = formatDate(endDate);
            // Store the date in dataset to avoid timezone issues
            try {
                const yyyy = endDate.getFullYear();
                const mm = String(endDate.getMonth() + 1).padStart(2, '0');
                const dd = String(endDate.getDate()).padStart(2, '0');
                endDateBtn.dataset.fullDate = `${yyyy}-${mm}-${dd}`;
            } catch (e) {}
            window.weeklyLessonEndDate = endDate;
        }
        if (endOnRadio) endOnRadio.checked = true;

        // ✅ FIX: also update global calendar state
        if (typeof window.setWeeklyCalendarEndDate === 'function') {
            window.setWeeklyCalendarEndDate(endDate);
        }
    } else {
        // ✅ No end date → check "Never"
        if (endNeverRadio) endNeverRadio.checked = true;
    }

    // ---- Parse and apply repeat-day pattern ----
    const daysPattern = JSON.parse(googleMeet.days || '{}');
    const widgetRow = document.getElementById('weeklyLessonWidgetsRowManage');
    if (widgetRow) {
        const dayMap = {
            Sun: 0,
            Mon: 1,
            Tue: 2,
            Wed: 3,
            Thu: 4,
            Fri: 5,
            Sat: 6
        };

        // Clear all widgets
        widgetRow.querySelectorAll('.weekly_lesson_scroll_widget_manage').forEach(widget => {
            const key = parseInt(widget.dataset.key, 10);
            widget.classList.remove('selected');
            widget.setAttribute('aria-pressed', 'false');

            const timeEl = widget.querySelector('.weekly_lesson_widget_time_manage');
            if (timeEl) timeEl.remove();

            const btn = widget.querySelector('.weekly_lesson_widget_button_manage');
            if (btn) {
                btn.classList.remove('has-time');
                const dot = btn.querySelector('.weekly_lesson_dot');
                if (dot) dot.remove();
            }

            if (window.weeklyLessonDayTimes) delete window.weeklyLessonDayTimes[key];
        });

        // Apply active days
        Object.keys(daysPattern).forEach(day => {
            if (daysPattern[day] === "1" && dayMap[day] !== undefined) {
                const widget = widgetRow.querySelector(
                    `.weekly_lesson_scroll_widget_manage[data-key="${dayMap[day]}"]`
                );
                if (widget) {
                    widget.classList.add('selected');
                    widget.setAttribute('aria-pressed', 'true');

                    const start24h = convert12hTo24h(startTime);
                    const end24h = convert12hTo24h(endTime);

                    if (!window.weeklyLessonDayTimes) window.weeklyLessonDayTimes = {};
                    window.weeklyLessonDayTimes[dayMap[day]] = {
                        start: start24h,
                        end: end24h,
                        activityIndex
                    };

                    renderWidgetTimeManage(dayMap[day], start24h, end24h);
                }
            }
        });
    }
}



function updateDateTimeFields(date, startTime, endTime, durationMinutes) {
    // Update date field
    const dateElement = document.getElementById('selectedDateTextManage');
    if (dateElement) {
        const formattedDate = date.toLocaleDateString('en-US', {
            weekday: 'short',
            month: 'short',
            day: 'numeric'
        });
        dateElement.textContent = formattedDate;
        try {
            // Format date manually to avoid timezone issues
            const yyyy = date.getFullYear();
            const mm = String(date.getMonth() + 1).padStart(2, '0');
            const dd = String(date.getDate()).padStart(2, '0');
            dateElement.dataset.fullDate = `${yyyy}-${mm}-${dd}`;
        } catch (e) {}
    }

    // Update time input
    const timeInput = document.querySelector('#manageclassTabContent .custom-time-pill .time-input');
    if (timeInput) {
        timeInput.value = startTime.toLowerCase();
    }

    // Update duration dropdown with minutes
    const durationDisplay = document.getElementById('durationDropdownDisplayManage');
    if (durationDisplay && durationMinutes) {
        const displayText = formatMinutesToDisplay(durationMinutes);
        durationDisplay.textContent = `${displayText} (Standard time)`;
        durationDisplay.dataset.minutes = durationMinutes;

        // Update selected option in dropdown
        const durationList = document.getElementById('durationDropdownListManage');
        if (durationList) {
            durationList.querySelectorAll('.one2one-duration-option').forEach(opt => {
                opt.classList.remove('selected');
                if (parseInt(opt.dataset.minutes) === durationMinutes) {
                    opt.classList.add('selected');
                }
            });
        }
    }
}


// ====== INITIALIZATION ======
document.addEventListener('DOMContentLoaded', function() {
    const $ = (sel, root = document) => root.querySelector(sel);
    const $$ = (sel, root = document) => Array.from(root.querySelectorAll(sel));

    // Initialize dropdown manager
    DropdownManager.init();

    // Add after DropdownManager.init();
    const durationDropdownList = document.getElementById('durationDropdownListManage');
    if (durationDropdownList) {
        durationDropdownList.addEventListener('click', (event) => {
            const option = event.target.closest('.one2one-duration-option');
            if (!option) return;

            // Remove previous selection
            durationDropdownList.querySelectorAll('.one2one-duration-option').forEach(opt =>
                opt.classList.remove('selected')
            );

            // Select clicked option
            option.classList.add('selected');

            // Update display
            const minutes = parseInt(option.dataset.minutes);
            const displayText = formatMinutesToDisplay(minutes);
            const displayEl = document.getElementById('durationDropdownDisplayManage');
            if (displayEl) {
                displayEl.textContent = `${displayText} (Standard time)`;
                displayEl.dataset.minutes = minutes; // Store minutes in data attribute
            }
        });
    }

    /* =========================
       ELEMENT REFERENCES
    ========================== */
    const teacherTrigger = $('#calendar_admin_details_create_cohort_manage_class_tab_trigger');
    const teacherMenu = $('#calendar_admin_details_create_cohort_manage_class_tab_menu');
    const teacherList = $('#calendar_admin_details_create_cohort_manage_class_tab_list');
    const teacherImg = $('#calendar_admin_details_create_cohort_manage_class_tab_current_img');
    const teacherLabel = $('#calendar_admin_details_create_cohort_manage_class_tab_current_label');
    const studentDropdownWrap = $('#one2oneStudentDropdownManage');
    const addStudentBtn = $('#one2oneAddStudentBtnManage');
    const studentDropdownWrapper = $('#studentDropdownWrapper');
    const scheduleBtn = $('.calendar_admin_details_create_cohort_schedule_btn_manage');
    const lessonTypeBtns = $$('.one2one-lesson-type-btn-manage');
    const loaderOverlay = $('#loaderOverlay');
    // global holder for selected cmid (from gm.id) for the currently chosen activity
    window.selectedCmidManage = null;
    // global holder for all events flag (false = this event, true = all following events)
    window.allEvents = false;
    // flag to skip the scope modal once the user already chose a scope
    window.weeklyReadyToSubmit = false;
    // track which scope the user picked (default to this event)
    window.weeklyUpdateScope = 'this';
    // global holder for reschedule reason and message
    window.rescheduleReason = null;
    window.rescheduleMessage = null;
    // flag to skip the reschedule modal once the user already chose a reason
    window.singleReadyToSubmit = false;
    const singleSection = $('#custom-single-lesson-manage');
    const weeklySection = $('#custom-weekly-lesson-manage');

    // When the Update button is clicked, build a minimal payload and log the cmid (if any)
    if (scheduleBtn) {
        scheduleBtn.addEventListener('click', () => {
            // Validate before submission
            const teacherId = teacherTrigger?.dataset.userid;
            const selectedStudent = $('.one2one-student-list-item.selected', studentDropdownWrap);
            const studentId = selectedStudent?.dataset.userid;

            if (!teacherId) {
                showToastManage('❌ Please select a teacher first.');
                return;
            }

            if (!studentId) {
                showToastManage('❌ Please select a student first.');
                return;
            }

            const lessonType = document.querySelector('.one2one-lesson-type-btn-manage.selected')
                ?.dataset.type;

            if (!lessonType) {
                showToastManage('❌ Please select a lesson type.');
                return;
            }
            let selectedElement = null;
            if (lessonType === 'single') {
                selectedElement = document.querySelector(
                    '.single-lesson-dropdown-card .single-lesson-dropdown-item.selected');
            } else {
                selectedElement = document.querySelector(
                    '.weekly-single-lesson-container .weekly-single-lesson-item.selected');
            }

            // For weekly lessons, show the modal first before submitting
            if (lessonType === 'weekly') {
                // Only show the scope modal the first time; afterwards submit directly
                if (!window.weeklyReadyToSubmit) {
                    // Store the data for later submission
                    window.pendingWeeklySubmission = {
                        teacherId,
                        studentId,
                        lessonType,
                        selectedElement
                    };

                    // Show the update scope modal
                    $('#manageUpdateScopeModalBackdrop').classList.add('active');
                    return;
                }

                // Reset the flag so future clicks reopen the scope modal if needed
                window.weeklyReadyToSubmit = false;
            }

            // For single lessons, check if reschedule values are already stored
            if (lessonType === 'single') {
                // Only show the reschedule modal the first time; afterwards submit directly
                if (!window.singleReadyToSubmit) {
                    // Show the reschedule modal for first time
                    window.pendingSingleSubmission = {
                        teacherId,
                        studentId,
                        lessonType,
                        selectedElement
                    };

                    // Populate modal with event data
                    const originalEventData = window.currentEventData || null;
                    if (originalEventData) {
                        // Set avatar
                        const avatar = $('#rescheduleLessonAvatar');
                        if (avatar && originalEventData.avatar) {
                            avatar.src = originalEventData.avatar;
                        }

                        // Set date
                        const dateEl = $('#rescheduleLessonDate');
                        if (dateEl && originalEventData.date) {
                            const date = new Date(originalEventData.date);
                            const options = {
                                weekday: 'long',
                                month: 'short',
                                day: '2-digit'
                            };
                            dateEl.textContent = date.toLocaleDateString('en-US', options);
                        }

                        // Set time
                        const timeEl = $('#rescheduleLessonTime');
                        if (timeEl && originalEventData.start && originalEventData.end) {
                            timeEl.textContent =
                                `${originalEventData.start} - ${originalEventData.end}`;
                        }

                        // Set student name
                        const studentEl = $('#rescheduleLessonStudent');
                        if (studentEl && originalEventData.studentnames) {
                            studentEl.textContent = originalEventData.studentnames.join(', ');
                        }
                    }

                    // Show the reschedule modal
                    $('#rescheduleLessonModalBackdrop').classList.add('active');
                    return;
                }

                // Reset the flag so future clicks reopen the reschedule modal if needed
                window.singleReadyToSubmit = false;
            }
        });
    }

    /* =======================================================
       HELPER: FETCH CLASSES BASED ON LESSON TYPE
    ======================================================== */
    function fetchClassesForLessonType() {
        const teacherId = teacherTrigger?.dataset.userid;
        const selectedStudent = $('.one2one-student-list-item.selected', studentDropdownWrap);
        const studentId = selectedStudent ? selectedStudent.dataset.userid : null;
        const lessonType = $('.one2one-lesson-type-btn-manage.selected')?.dataset.type || 'single';

        if (!teacherId || !studentId) {
            console.warn('Cannot fetch classes: Teacher or student not selected');
            validateForm();
            return;
        }

        // Show loader
        if (loaderOverlay) loaderOverlay.classList.add('active');

        const url =
            `ajax/ajax_one2one_getclasses.php?teacherid=${teacherId}&studentid=${studentId}&classtype=${lessonType}`;
        console.log(`Fetching ${lessonType} lessons:`, url);

        fetch(url, {
                credentials: "same-origin"
            })
            .then(response => response.json())
            .then(data => {
                console.log(`${lessonType} lessons API Response:`, data);
                if (lessonType === 'single') {
                    populateSingleLessonDropdown(data);
                } else {
                    populateWeeklyLessonDropdown(data);
                }
                // Hide loader after data loaded
                if (loaderOverlay) loaderOverlay.classList.remove('active');
                validateForm();
            })
            .catch(error => {
                console.error(`Error fetching ${lessonType} lessons:`, error);
                // Hide loader on error
                if (loaderOverlay) loaderOverlay.classList.remove('active');
                validateForm();
            });
    }

    /* =======================================================
       1) TEACHER DROPDOWN + STUDENT LOADING
    ======================================================== */
    window.loadStudentsForTeacher = loadStudentsForTeacher;

    (function ensureDefaultTeacherDataset() {
        if (!teacherTrigger || !teacherList || !teacherLabel) return;
        if (teacherTrigger.dataset.userid) return;

        const currentName = (teacherLabel.textContent || '').trim();
        const match = $$('.calendar_admin_details_create_cohort_manage_class_tab_item[role="option"]',
                teacherList)
            .find(item => (item.dataset.name || '').trim() === currentName);
        const source = match || teacherList.querySelector(
            '.calendar_admin_details_create_cohort_manage_class_tab_item[role="option"]');

        if (!source) {
            console.warn('No teacher source element found');
            return;
        }

        const userId = source.dataset?.userid || '';
        const name = source.dataset?.name || currentName;
        const imageUrl = source.dataset?.img || (teacherImg ? teacherImg.src : '');

        if (!userId && !name) {
            console.warn('No valid teacher data found');
            return;
        }

        $$('.calendar_admin_details_create_cohort_manage_class_tab_item[aria-selected="true"]', teacherList)
            .forEach(element => element.removeAttribute('aria-selected'));
        source.setAttribute('aria-selected', 'true');

        teacherTrigger.dataset.userid = userId;
        teacherTrigger.dataset.name = name;
        teacherTrigger.dataset.img = imageUrl;

        if (teacherImg && imageUrl) {
            teacherImg.src = imageUrl;
            teacherImg.alt = name;
        }
        if (teacherLabel && name) {
            teacherLabel.textContent = name;
        }

        if (userId) {
            loadStudentsForTeacher(userId);
        } else {
            console.warn('No teacher ID available to load students');
            validateForm();
        }
    })();

    if (teacherList) {
        teacherList.addEventListener('click', (event) => {
            const item = event.target.closest(
                '.calendar_admin_details_create_cohort_manage_class_tab_item[role="option"]');
            if (!item) return;

            $$('.calendar_admin_details_create_cohort_manage_class_tab_item[aria-selected="true"]',
                    teacherList)
                .forEach(element => element.removeAttribute('aria-selected'));
            item.setAttribute('aria-selected', 'true');

            const name = item.dataset.name;
            const imageUrl = item.dataset.img;
            const userId = item.dataset.userid;

            if (teacherImg && imageUrl) {
                teacherImg.src = imageUrl;
                teacherImg.alt = name || 'Selected teacher';
            }
            if (teacherLabel && name) {
                teacherLabel.textContent = name;
            }
            if (teacherTrigger) {
                teacherTrigger.dataset.userid = userId || '';
                teacherTrigger.dataset.name = name || '';
                teacherTrigger.dataset.img = imageUrl || '';
            }

            if (userId) {
                loadStudentsForTeacher(userId);
            } else {
                // Disable student dropdown if no teacher
                if (studentDropdownWrapper) {
                    studentDropdownWrapper.classList.add('disabled');
                    if (addStudentBtn) {
                        addStudentBtn.classList.add('disabled');
                        addStudentBtn.innerHTML =
                            `<span style="color:#aaa;">Select a teacher first</span>`;
                    }
                }
            }
            if (teacherMenu) teacherMenu.style.display = 'none';

            // Fetch classes after teacher change
            fetchClassesForLessonType();
            validateForm();
        });
    }

    /* =========================================
       2) STUDENT SELECTION + AUTO-FETCH CLASSES
    ========================================== */
    if (studentDropdownWrap) {
        studentDropdownWrap.addEventListener('click', (event) => {
            const item = event.target.closest('.one2one-student-list-item:not([aria-disabled])');
            if (!item) return;

            // Remove previous selection
            $$('.one2one-student-list-item', studentDropdownWrap).forEach(el => el.classList.remove(
                'selected'));
            item.classList.add('selected');

            // Update the "Add student" button
            if (addStudentBtn) {
                const avatar = item.querySelector('.one2one-student-list-avatar')?.innerHTML || '';
                const name = item.dataset.name || item.querySelector('.one2one-student-list-name')
                    ?.textContent || 'Student';
                addStudentBtn.innerHTML = `
                    <span class="one2one-add-student-icon">${avatar}</span>
                    <span style="font-weight:600; color:#232323;">${name}</span>
                `;
                addStudentBtn.classList.add('active');
            }

            // Close dropdown
            if (studentDropdownWrap) {
                studentDropdownWrap.style.display = 'none';
            }

            // **FETCH CLASSES WHEN STUDENT SELECTED**
            fetchClassesForLessonType();
            validateForm();
        });
    }

    /* =========================================
       3) SEARCH FILTERS (TEACHER + STUDENT)
    ========================================== */
    document.addEventListener('input', function(event) {
        if (event.target.id === 'teacherSearchInputManage') {
            const filter = event.target.value.toLowerCase();
            $$('.calendar_admin_details_create_cohort_manage_class_tab_item', teacherList)
                .forEach(item => {
                    const name = (item.dataset.name || '').toLowerCase();
                    item.style.display = name.includes(filter) ? '' : 'none';
                });
        }

        if (event.target.id === 'studentSearchInputManage') {
            const filter = event.target.value.toLowerCase();
            $$('.one2one-student-list-item', studentDropdownWrap)
                .forEach(item => {
                    const name = (item.dataset.name || '').toLowerCase();
                    item.style.display = name.includes(filter) ? '' : 'none';
                });
        }
    });

    /* =========================================
       4) LESSON TYPE TOGGLE + AUTO-FETCH
    ========================================== */
    /* =========================================
       4) LESSON TYPE TOGGLE + AUTO-FETCH - FIXED RADIO BUTTONS
    ========================================== */
    lessonTypeBtns.forEach(btn => {
        btn.addEventListener('click', () => {
            // Remove selected class from all buttons
            lessonTypeBtns.forEach(button => button.classList.remove('selected'));

            // Add selected class to clicked button
            btn.classList.add('selected');

            // **FIX: Check the radio button inside the clicked button**
            const radioInput = btn.querySelector('input[type="radio"]');
            if (radioInput) {
                radioInput.checked = true;
            }

            const lessonType = btn.dataset.type;
            if (lessonType === 'single') {
                singleSection.style.display = 'block';
                weeklySection.style.display = 'none';
            } else {
                singleSection.style.display = 'none';
                weeklySection.style.display = 'block';
            }

            // Fetch classes when lesson type changes
            fetchClassesForLessonType();
            validateForm();
        });
    });

    /* =========================================
       5) WEEKLY WIDGET/TIMEPICKER
    ========================================== */
    (function initWeeklyWidgets() {
        const widgetRow = $('#weeklyLessonWidgetsRowManage');
        if (!widgetRow) return;

        let weeklyLessonInterval = 1;
        let weeklyLessonOccurrences = 13;
        window.weeklyLessonCurrentDayKey = null;
        window.weeklyLessonDayTimes = {};

        const dayShort = ['S', 'M', 'T', 'W', 'T', 'F', 'S'];

        for (let i = 0; i < 7; i++) {
            const div = document.createElement('div');
            div.className = 'weekly_lesson_scroll_widget_manage';
            div.dataset.key = i;
            div.innerHTML = `
                <span class="weekly_lesson_widget_text_manage">${dayShort[i]}</span>
                <div class="weekly_lesson_widget_divider_manage"></div>
                <button class="weekly_lesson_widget_button_manage" data-arrow-manage="1">
                    <div class="weekly_lesson_widget_arrow_manage"></div>
                </button>
            `;
            widgetRow.appendChild(div);
        }

        const intervalDisplay = $('#weeklyLessonIntervalDisplayManage');
        $('#weeklyLessonIntervalPlusManage')?.addEventListener('click', () => {
            weeklyLessonInterval++;
            if (intervalDisplay) intervalDisplay.textContent = weeklyLessonInterval;
        });
        $('#weeklyLessonIntervalMinusManage')?.addEventListener('click', () => {
            if (weeklyLessonInterval > 1) weeklyLessonInterval--;
            if (intervalDisplay) intervalDisplay.textContent = weeklyLessonInterval;
        });

        document.addEventListener('click', (event) => {
            const arrowBtn = event.target.closest('[data-arrow-manage]');
            const pickerBackdrop = $('#weeklyLessonTimepickerBackdropManage');

            if (arrowBtn && pickerBackdrop) {
                const wrap = arrowBtn.closest('.weekly_lesson_scroll_widget_manage');
                window.weeklyLessonCurrentDayKey = parseInt(wrap.dataset.key, 10);

                const current = window.weeklyLessonDayTimes[window.weeklyLessonCurrentDayKey] || {
                    start: '09:00',
                    end: '10:00'
                };

                const start12h = convert24hTo12h(current.start);
                const end12h = convert24hTo12h(current.end);

                $('#weekly_lesson_timepicker_start_manage').value = start12h;
                $('#weekly_lesson_timepicker_end_manage').value = end12h;
                // Ensure pbd is always a single element
                let pbd = pickerBackdrop?. [0] ?? pickerBackdrop;
                pbd.style.display = 'block';


                return;
            }

            const widget = event.target.closest('.weekly_lesson_scroll_widget_manage');
            if (widget && !event.target.closest('[data-arrow-manage]')) {
                const key = parseInt(widget.dataset.key, 10);
                const selected = widget.classList.toggle('selected');
                widget.setAttribute('aria-pressed', selected ? 'true' : 'false');

                if (!selected) {
                    delete window.weeklyLessonDayTimes[key];
                    const timeElement = widget.querySelector('.weekly_lesson_widget_time_manage');
                    if (timeElement) timeElement.remove();

                    const button = widget.querySelector('.weekly_lesson_widget_button_manage');
                    if (button) {
                        button.classList.remove('has-time');
                        const dot = button.querySelector('.weekly_lesson_dot');
                        if (dot) dot.remove();
                    }
                } else {
                    const button = widget.querySelector('.weekly_lesson_widget_button_manage');
                    if (button) {
                        button.classList.remove('has-time');
                    }
                }
            }
        });

        $('#weeklyLessonTimepickerCancelBtnManage')?.addEventListener('click', () => {
            $('#weeklyLessonTimepickerBackdropManage').style.display = 'none';
        });

        $('#weeklyLessonTimepickerDoneBtnManage')?.addEventListener('click', () => {
            if (window.weeklyLessonCurrentDayKey == null) return;

            const start12h = $('#weekly_lesson_timepicker_start_manage').value || '09:00 AM';
            const end12h = $('#weekly_lesson_timepicker_end_manage').value || '10:00 AM';
            const start24h = convert12hTo24h(start12h);
            let end24h = convert12hTo24h(end12h);

            if (end24h <= start24h) {
                const [hour, minute] = start24h.split(':').map(Number);
                const hour2 = (hour + 1) % 24;
                end24h = `${String(hour2).padStart(2, '0')}:${String(minute).padStart(2, '0')}`;
            }

            // Store the time change temporarily
            window.pendingWeeklyTimeChange = {
                dayKey: window.weeklyLessonCurrentDayKey,
                start: start24h,
                end: end24h
            };

            // Close time picker
            $('#weeklyLessonTimepickerBackdropManage').style.display = 'none';

            // Show update scope modal
            $('#manageUpdateScopeModalBackdrop').classList.add('active');
        });
    })();

    /* =========================================
       UPDATE SCOPE MODAL HANDLERS
    ========================================== */
    (function initUpdateScopeModal() {
        const modalBackdrop = $('#manageUpdateScopeModalBackdrop');
        const cancelBtn = $('#manageUpdateScopeCancelBtn');
        const okBtn = $('#manageUpdateScopeOkBtn');
        const thisEventRadio = $('#updateScopeThisEvent');
        const followingRadio = $('#updateScopeFollowing');

        if (!modalBackdrop) return;

        // Cancel button - close modal without saving
        cancelBtn?.addEventListener('click', () => {
            modalBackdrop.classList.remove('active');
            window.pendingWeeklyTimeChange = null;
            window.pendingWeeklySubmission = null;
            window.weeklyReadyToSubmit = false;
            window.weeklyUpdateScope = 'this';
            window.allEvents = false;
        });

        // Ok button - save the selection and apply the time change or submission
        okBtn?.addEventListener('click', () => {
            // Get selected scope as boolean
            if (thisEventRadio?.checked) {
                window.allEvents = false; // This event only
                window.weeklyUpdateScope = 'this';
            } else if (followingRadio?.checked) {
                window.allEvents = true; // All following events
                window.weeklyUpdateScope = 'all';
            }

            // Apply the pending time change
            if (window.pendingWeeklyTimeChange) {
                const {
                    dayKey,
                    start,
                    end
                } = window.pendingWeeklyTimeChange;
                window.weeklyLessonDayTimes[dayKey] = {
                    start,
                    end
                };
                renderWidgetTimeManage(dayKey, start, end);
                window.pendingWeeklyTimeChange = null;
            }

            // Handle pending submission (when Update button was clicked)
            if (window.pendingWeeklySubmission) {
                const {
                    selectedElement
                } = window.pendingWeeklySubmission;
                const cmid = window.selectedCmidManage ?? selectedElement?.dataset?.cmid ?? null;
                const originalEventData = window.currentEventData || null;
                const payload = {
                    lessonType: 'weekly',
                    cmid,
                    activityIndex: selectedElement?.dataset?.activityIndex ?? null,
                    eventId: originalEventData ? originalEventData.id : null,
                    updateScope: window.weeklyUpdateScope
                };

                // Log the payload
                console.log('Update 1:1 class payload (manage):', payload);

                // TODO: Submit the payload to your backend
                // fetch('your-api-endpoint', { method: 'POST', body: JSON.stringify(payload) })

                window.pendingWeeklySubmission = null;

                // We already have the scope choice; immediately submit the update payload
                // by re-triggering the main click handler with the guard flag set.
                window.weeklyReadyToSubmit = true;
                const submitButton = document.querySelector(
                    '.calendar_admin_details_create_cohort_schedule_btn_manage');
                if (submitButton) submitButton.click();
            }

            // Close modal
            modalBackdrop.classList.remove('active');

            console.log('All events flag set to:', window.allEvents);
        });

        // Close on backdrop click
        modalBackdrop?.addEventListener('click', (e) => {
            if (e.target === modalBackdrop) {
                modalBackdrop.classList.remove('active');
                window.pendingWeeklyTimeChange = null;
                window.pendingWeeklySubmission = null;
                window.weeklyReadyToSubmit = false;
                window.weeklyUpdateScope = 'this';
                window.allEvents = false;
            }
        });
    })();

    /* =========================================
       RESCHEDULE LESSON MODAL HANDLERS
    ========================================== */
    (function initRescheduleLessonModal() {
        const modalBackdrop = $('#rescheduleLessonModalBackdrop');
        const closeBtn = $('#rescheduleLessonCloseBtn');
        const backBtn = $('#rescheduleLessonBackBtn');
        const reasonBtn = $('#rescheduleReasonBtn');
        const reasonList = $('#rescheduleReasonList');
        const reasonDisplay = $('#rescheduleReasonDisplay');
        const messageTextarea = $('#rescheduleMessage');
        const confirmBtn = $('#rescheduleConfirmBtn');

        if (!modalBackdrop) return;

        // Toggle dropdown
        reasonBtn?.addEventListener('click', () => {
            reasonList.classList.toggle('active');
            reasonBtn.classList.toggle('active');
        });

        // Select reason
        reasonList?.addEventListener('click', (e) => {
            const item = e.target.closest('.reschedule-lesson-dropdown-item');
            if (!item) return;

            const value = item.dataset.value;
            const text = item.textContent;

            window.rescheduleReason = value;
            reasonDisplay.textContent = text;
            reasonList.classList.remove('active');
            reasonBtn.classList.remove('active');

            // Enable confirm button if reason is selected
            if (confirmBtn) {
                confirmBtn.disabled = false;
            }
        });

        // Store message
        messageTextarea?.addEventListener('input', () => {
            window.rescheduleMessage = messageTextarea.value;
        });

        // Close handlers
        const closeModal = () => {
            modalBackdrop.classList.remove('active');
            window.pendingSingleSubmission = null;
            window.rescheduleReason = null;
            window.rescheduleMessage = null;
            window.singleReadyToSubmit = false;
            if (reasonDisplay) reasonDisplay.textContent = 'Select Reason';
            if (messageTextarea) messageTextarea.value = '';
            if (confirmBtn) confirmBtn.disabled = true;
        };

        closeBtn?.addEventListener('click', closeModal);
        backBtn?.addEventListener('click', closeModal);

        // Close on backdrop click
        modalBackdrop?.addEventListener('click', (e) => {
            if (e.target === modalBackdrop) {
                closeModal();
            }
        });

        // Confirm button - store values, close modal, and trigger submission
        confirmBtn?.addEventListener('click', () => {
            if (!window.rescheduleReason) {
                showToastManage('❌ Please select a reschedule reason.');
                return;
            }

            // Store the reschedule reason and message (already stored via input handlers above)
            // Close the modal
            modalBackdrop.classList.remove('active');
            window.pendingSingleSubmission = null;

            // Values are now stored in window.rescheduleReason and window.rescheduleMessage
            console.log('✅ Reschedule data stored:', {
                reason: window.rescheduleReason,
                message: window.rescheduleMessage
            });

            // Set the flag to allow direct submission
            window.singleReadyToSubmit = true;

            // Immediately trigger the main submit handler
            const submitButton = document.querySelector(
                '.calendar_admin_details_create_cohort_schedule_btn_manage');
            if (submitButton) submitButton.click();
        });
    })();

    /* =========================================
       6) WEEKLY START/END CALENDAR - FIXED DATE ONLY
    ========================================== */
    (function initWeeklyCalendar() {
        const backdrop = $('#weeklyLessonStartDateCalendarBackdropManage');
        if (!backdrop) return;

        let calendarTarget = 'start';
        let weeklyLessonStartDate = new Date();
        // **FIX: Set to start of day (no time)**
        weeklyLessonStartDate.setHours(0, 0, 0, 0);

        let weeklyLessonEndsOnDate = new Date();
        // 👇 Add this:
        window.setWeeklyCalendarEndDate = function(date) {
            weeklyLessonEndsOnDate = new Date(date);
        };
        weeklyLessonEndsOnDate.setMonth(weeklyLessonEndsOnDate.getMonth() + 1);
        weeklyLessonEndsOnDate.setHours(0, 0, 0, 0);

        let viewMonth = weeklyLessonStartDate.getMonth();
        let viewYear = weeklyLessonStartDate.getFullYear();
        let selectedDate = new Date(weeklyLessonStartDate);

        const startDateText = $('#weeklyLessonStartDateTextManage');
        const endDateBtn = $('#weeklyLessonEndDateBtnManage');

        if (startDateText) {
            startDateText.textContent = formatDate(weeklyLessonStartDate);
            try {
                const yyyy = weeklyLessonStartDate.getFullYear();
                const mm = String(weeklyLessonStartDate.getMonth() + 1).padStart(2, '0');
                const dd = String(weeklyLessonStartDate.getDate()).padStart(2, '0');
                startDateText.dataset.fullDate = `${yyyy}-${mm}-${dd}`;
            } catch (e) {}
        }
        if (endDateBtn) {
            endDateBtn.disabled = false;
            endDateBtn.textContent = formatDate(weeklyLessonEndsOnDate);
            try {
                const yyyy = weeklyLessonEndsOnDate.getFullYear();
                const mm = String(weeklyLessonEndsOnDate.getMonth() + 1).padStart(2, '0');
                const dd = String(weeklyLessonEndsOnDate.getDate()).padStart(2, '0');
                endDateBtn.dataset.fullDate = `${yyyy}-${mm}-${dd}`;
            } catch (e) {}
        }

        $('#weeklyLessonStartDateBtnManage')?.addEventListener('click', () => {
            calendarTarget = 'start';

            // Parse current date from button if available
            if (startDateText && startDateText.dataset.fullDate) {
                const dateStr = startDateText.dataset.fullDate;
                const parts = dateStr.split('-');
                if (parts.length === 3) {
                    const year = parseInt(parts[0]);
                    const month = parseInt(parts[1]) - 1;
                    const day = parseInt(parts[2]);
                    selectedDate = new Date(year, month, day, 0, 0, 0);
                    weeklyLessonStartDate = new Date(selectedDate);
                } else {
                    selectedDate = new Date(weeklyLessonStartDate);
                    selectedDate.setHours(0, 0, 0, 0);
                }
            } else {
                selectedDate = new Date(weeklyLessonStartDate);
                selectedDate.setHours(0, 0, 0, 0);
            }

            viewMonth = selectedDate.getMonth();
            viewYear = selectedDate.getFullYear();
            renderCalendar();
            backdrop.style.display = 'block';
        });

        $('#weeklyLessonEndDateBtnManage')?.addEventListener('click', function() {
            if (this.disabled) return;
            calendarTarget = 'ends';

            // Parse current date from button if available
            if (endDateBtn && endDateBtn.dataset.fullDate) {
                const dateStr = endDateBtn.dataset.fullDate;
                const parts = dateStr.split('-');
                if (parts.length === 3) {
                    const year = parseInt(parts[0]);
                    const month = parseInt(parts[1]) - 1;
                    const day = parseInt(parts[2]);
                    selectedDate = new Date(year, month, day, 0, 0, 0);
                    weeklyLessonEndsOnDate = new Date(selectedDate);
                } else {
                    selectedDate = new Date(weeklyLessonEndsOnDate);
                    selectedDate.setHours(0, 0, 0, 0);
                }
            } else {
                selectedDate = new Date(weeklyLessonEndsOnDate);
                selectedDate.setHours(0, 0, 0, 0);
            }

            viewMonth = selectedDate.getMonth();
            viewYear = selectedDate.getFullYear();
            renderCalendar();
            backdrop.style.display = 'block';
        });

        $('#weeklyLessonCalendarPrevManage')?.addEventListener('click', () => {
            if (viewMonth === 0) {
                viewMonth = 11;
                viewYear--;
            } else {
                viewMonth--;
            }
            renderCalendar();
        });

        $('#weeklyLessonCalendarNextManage')?.addEventListener('click', () => {
            if (viewMonth === 11) {
                viewMonth = 0;
                viewYear++;
            } else {
                viewMonth++;
            }
            renderCalendar();
        });

        $('#weeklyLessonCalendarDoneManage')?.addEventListener('click', () => {
            // **FIX: Set to start of day before saving**
            selectedDate.setHours(0, 0, 0, 0);

            if (calendarTarget === 'start') {
                weeklyLessonStartDate = new Date(selectedDate);
                if (startDateText) {
                    startDateText.textContent = formatDate(weeklyLessonStartDate);
                    try {
                        const yyyy = weeklyLessonStartDate.getFullYear();
                        const mm = String(weeklyLessonStartDate.getMonth() + 1).padStart(2, '0');
                        const dd = String(weeklyLessonStartDate.getDate()).padStart(2, '0');
                        startDateText.dataset.fullDate = `${yyyy}-${mm}-${dd}`;
                    } catch (e) {}
                }
            } else {
                weeklyLessonEndsOnDate = new Date(selectedDate);
                if (endDateBtn) {
                    endDateBtn.textContent = formatDate(weeklyLessonEndsOnDate);
                    try {
                        const yyyy = weeklyLessonEndsOnDate.getFullYear();
                        const mm = String(weeklyLessonEndsOnDate.getMonth() + 1).padStart(2, '0');
                        const dd = String(weeklyLessonEndsOnDate.getDate()).padStart(2, '0');
                        endDateBtn.dataset.fullDate = `${yyyy}-${mm}-${dd}`;
                    } catch (e) {}
                }
            }
            backdrop.style.display = 'none';
        });

        backdrop.addEventListener('click', (event) => {
            if (event.target === backdrop) backdrop.style.display = 'none';
        });

        function renderCalendar() {
            const monthLabel = $('#weeklyLessonCalendarMonthManage');
            const daysRow = $('#weeklyLessonCalendarDaysManage');
            const datesRow = $('#weeklyLessonCalendarDatesManage');

            const monthNames = ["January", "February", "March", "April", "May", "June",
                "July", "August", "September", "October", "November", "December"
            ];

            if (monthLabel) {
                monthLabel.textContent = `${monthNames[viewMonth]} ${viewYear}`;
            }

            if (daysRow) {
                daysRow.innerHTML = '';
                ["Mo", "Tu", "We", "Th", "Fr", "Sa", "Su"].forEach(day => {
                    const div = document.createElement('div');
                    div.className = 'monthly_cal_day';
                    div.textContent = day;
                    daysRow.appendChild(div);
                });
            }

            if (datesRow) {
                datesRow.innerHTML = '';
                const firstDay = new Date(viewYear, viewMonth, 1).getDay();
                const offset = (firstDay + 6) % 7;
                const daysInMonth = new Date(viewYear, viewMonth + 1, 0).getDate();

                for (let i = 0; i < offset; i++) {
                    const d = document.createElement('div');
                    d.className = 'monthly_cal_date inactive';
                    datesRow.appendChild(d);
                }

                for (let day = 1; day <= daysInMonth; day++) {
                    const dateDiv = document.createElement('div');
                    dateDiv.className = 'monthly_cal_date';
                    dateDiv.dataset.date = day;
                    dateDiv.textContent = day;

                    // **FIX: Compare dates without time**
                    const isSelected = day === selectedDate.getDate() &&
                        viewMonth === selectedDate.getMonth() &&
                        viewYear === selectedDate.getFullYear();

                    if (isSelected) dateDiv.classList.add('selected');

                    dateDiv.addEventListener('click', () => {
                        selectedDate.setFullYear(viewYear);
                        selectedDate.setMonth(viewMonth);
                        selectedDate.setDate(day);
                        selectedDate.setHours(0, 0, 0, 0); // **FIX: Clear time**
                        renderCalendar();
                    });

                    datesRow.appendChild(dateDiv);
                }
            }
        }

        window.getWeeklyLessonStartDate = () => weeklyLessonStartDate;
        window.getWeeklyLessonEndsOnDate = () => weeklyLessonEndsOnDate;

        renderCalendar();
    })();

    /* =========================================
       7) TIME PICKER DROPDOWNS FOR WEEKLY
    ========================================== */
    (function initWeeklyTimePickers() {
        const startInput = $('#weekly_lesson_timepicker_start_manage');
        const endInput = $('#weekly_lesson_timepicker_end_manage');
        if (!startInput || !endInput) return;

        function generateTimeOptions() {
            const times = [];
            for (let h = 0; h < 24; h++) {
                for (let m = 0; m < 60; m += 30) {
                    times.push(formatTime12HourFromParts(h, m));
                }
            }
            return times;
        }

        const timeOptions = generateTimeOptions();

        function createTimeDropdown(input) {
            const wrapper = document.createElement('div');
            wrapper.style.position = 'relative';
            wrapper.style.width = '100%';

            const dropdown = document.createElement('div');
            dropdown.className = 'time-dropdown';
            dropdown.style.cssText = `
                position: absolute;
                top: 100%;
                left: 0;
                right: 0;
                background: white;
                border: 1px solid #dadada;
                border-radius: 8px;
                max-height: 200px;
                overflow-y: auto;
                display: none;
                z-index: 1000;
                margin-top: 4px;
                box-shadow: 0 4px 12px rgba(0,0,0,0.15);
            `;

            timeOptions.forEach(time => {
                const option = document.createElement('div');
                option.textContent = time;
                option.style.cssText = `
                    padding: 10px 16px;
                    cursor: pointer;
                    font-size: 14px;
                    transition: background 0.15s;
                `;
                option.addEventListener('mouseenter', () => {
                    option.style.background = '#f6f6f6';
                    option.style.color = '#fe2e0c';
                });
                option.addEventListener('mouseleave', () => {
                    option.style.background = '';
                    option.style.color = '';
                });
                option.addEventListener('click', () => {
                    input.value = time;
                    dropdown.style.display = 'none';
                });
                dropdown.appendChild(option);
            });

            input.parentNode.insertBefore(wrapper, input);
            wrapper.appendChild(input);
            wrapper.appendChild(dropdown);

            input.readOnly = true;
            input.style.cursor = 'pointer';

            input.addEventListener('click', (e) => {
                e.stopPropagation();
                dropdown.style.display = dropdown.style.display === 'none' ? 'block' : 'none';

                const selectedOption = Array.from(dropdown.children).find(
                    opt => opt.textContent === input.value
                );
                if (selectedOption) {
                    selectedOption.scrollIntoView({
                        block: 'nearest'
                    });
                }
            });

            document.addEventListener('click', (e) => {
                if (!wrapper.contains(e.target)) {
                    dropdown.style.display = 'none';
                }
            });
        }

        createTimeDropdown(startInput);
        createTimeDropdown(endInput);
    })();

    /* =========================================
       7B) SINGLE LESSON DATE CALENDAR MODAL
    ========================================== */
    (function initSingleLessonCalendar() {
        const customDateDisplay = $('#customDateDropdownDisplayManage');
        const calendarBackdrop = $('#calendarModalBackdropManage');
        const calendarPrevBtn = $('#calendarPrevMonthManage');
        const calendarNextBtn = $('#calendarNextMonthManage');
        const calendarDoneBtn = $('#calendarDoneBtnManage');
        const calendarMonthYear = $('#calendarMonthYearManage');
        const calendarDaysGrid = $('#calendarDaysGridManage');

        if (!customDateDisplay || !calendarBackdrop) return;

        let currentDate = new Date();
        let viewYear = currentDate.getFullYear();
        let viewMonth = currentDate.getMonth();
        let selectedDate = new Date(currentDate);

        // Parse current date from button text if exists
        function parseCurrentDate() {
            const dateText = $('#selectedDateTextManage');
            if (dateText && dateText.dataset.fullDate) {
                try {
                    // Parse date string manually to avoid timezone issues
                    const dateStr = dateText.dataset.fullDate;
                    const parts = dateStr.split('-');
                    if (parts.length === 3) {
                        const year = parseInt(parts[0]);
                        const month = parseInt(parts[1]) - 1; // Month is 0-indexed
                        const day = parseInt(parts[2]);
                        selectedDate = new Date(year, month, day, 12, 0, 0);
                        viewYear = year;
                        viewMonth = month;
                    }
                } catch (e) {
                    console.warn('Could not parse date:', e);
                }
            }
        }

        // Open calendar when clicking date display
        customDateDisplay.addEventListener('click', () => {
            parseCurrentDate(); // Parse the current date before opening
            renderSingleCalendar();
            calendarBackdrop.style.display = 'flex';
        });

        // Previous month
        if (calendarPrevBtn) {
            calendarPrevBtn.addEventListener('click', () => {
                viewMonth--;
                if (viewMonth < 0) {
                    viewMonth = 11;
                    viewYear--;
                }
                renderSingleCalendar();
            });
        }

        // Next month
        if (calendarNextBtn) {
            calendarNextBtn.addEventListener('click', () => {
                viewMonth++;
                if (viewMonth > 11) {
                    viewMonth = 0;
                    viewYear++;
                }
                renderSingleCalendar();
            });
        }

        // Done button
        if (calendarDoneBtn) {
            calendarDoneBtn.addEventListener('click', () => {
                const dateText = $('#selectedDateTextManage');
                if (dateText) {
                    const formatted = selectedDate.toLocaleDateString('en-US', {
                        weekday: 'short',
                        month: 'short',
                        day: 'numeric'
                    });
                    dateText.textContent = formatted;

                    // Store full date
                    const yyyy = selectedDate.getFullYear();
                    const mm = String(selectedDate.getMonth() + 1).padStart(2, '0');
                    const dd = String(selectedDate.getDate()).padStart(2, '0');
                    dateText.dataset.fullDate = `${yyyy}-${mm}-${dd}`;
                }
                calendarBackdrop.style.display = 'none';
            });
        }

        // Close on backdrop click
        calendarBackdrop.addEventListener('click', (e) => {
            if (e.target === calendarBackdrop) {
                calendarBackdrop.style.display = 'none';
            }
        });

        function renderSingleCalendar() {
            const monthNames = ["January", "February", "March", "April", "May", "June",
                "July", "August", "September", "October", "November", "December"
            ];

            if (calendarMonthYear) {
                calendarMonthYear.textContent = `${monthNames[viewMonth]} ${viewYear}`;
            }

            if (calendarDaysGrid) {
                calendarDaysGrid.innerHTML = '';

                const firstDay = new Date(viewYear, viewMonth, 1).getDay();
                const offset = firstDay === 0 ? 6 : firstDay - 1; // Monday first
                const daysInMonth = new Date(viewYear, viewMonth + 1, 0).getDate();

                // Add empty cells for offset
                for (let i = 0; i < offset; i++) {
                    const emptyDiv = document.createElement('div');
                    emptyDiv.className = 'calendar-modal-day inactive';
                    calendarDaysGrid.appendChild(emptyDiv);
                }

                // Add day cells
                for (let day = 1; day <= daysInMonth; day++) {
                    const dayDiv = document.createElement('div');
                    dayDiv.className = 'calendar-modal-day';
                    dayDiv.textContent = day;

                    // Check if this day is selected
                    const isSelected = day === selectedDate.getDate() &&
                        viewMonth === selectedDate.getMonth() &&
                        viewYear === selectedDate.getFullYear();

                    if (isSelected) {
                        dayDiv.classList.add('selected');
                    }

                    dayDiv.addEventListener('click', () => {
                        selectedDate = new Date(viewYear, viewMonth, day, 12, 0, 0);
                        renderSingleCalendar();
                    });

                    calendarDaysGrid.appendChild(dayDiv);
                }
            }
        }

        renderSingleCalendar();
    })();


    // Add this in your DOMContentLoaded section

    /* =========================================
       9) DETECT MANUAL DATE/TIME CHANGES
    ========================================== */

    // Listen for date changes
    const customDateDisplay = document.getElementById('customDateDropdownDisplayManage');
    if (customDateDisplay) {
        // Create a MutationObserver to watch for text changes
        const dateObserver = new MutationObserver((mutations) => {
            mutations.forEach((mutation) => {
                if (mutation.type === 'childList' || mutation.type === 'characterData') {
                    console.log('Date manually changed to:', customDateDisplay.textContent);
                    // Update the data attribute
                    const selectedDateText = document.getElementById('selectedDateTextManage');
                    if (selectedDateText) {
                        console.log('Updated date data:', selectedDateText.dataset.fullDate);
                    }
                }
            });
        });

        dateObserver.observe(customDateDisplay, {
            childList: true,
            characterData: true,
            subtree: true
        });
    }

    // Listen for time changes
    const timeInput = document.querySelector('#manageclassTabContent .custom-time-pill .time-input');
    if (timeInput) {
        timeInput.addEventListener('change', () => {
            console.log('Time manually changed to:', timeInput.value);
        });

        timeInput.addEventListener('input', () => {
            console.log('Time input changed to:', timeInput.value);
        });
    }

    // Listen for duration changes (already handled, but verify)
    const durationOptions = document.querySelectorAll('.one2one-duration-option');
    durationOptions.forEach(option => {
        option.addEventListener('click', () => {
            const minutes = parseInt(option.dataset.minutes);
            console.log('Duration manually changed to:', minutes, 'minutes');
        });
    });

    /* =========================================
       8) MAIN SCHEDULE BUTTON
    ========================================== */

    scheduleBtn?.addEventListener('click', async () => {
        // Check if we're waiting for modal input (reschedule or update scope)
        if (window.pendingSingleSubmission || window.pendingWeeklySubmission) {
            console.log('⏸️ Waiting for modal input, skipping direct submission');
            return;
        }

        const teacher = {
            id: teacherTrigger?.dataset.userid || null,
            name: teacherLabel?.textContent.trim() || 'Unknown Teacher',
            imageUrl: teacherImg?.src || ''
        };

        const selectedStudent = $('.one2one-student-list-item.selected', studentDropdownWrap);
        const student = {
            id: selectedStudent ? selectedStudent.dataset.userid : null,
            name: selectedStudent ? selectedStudent.dataset.name : 'No student selected'
        };

        const lessonType = $('.one2one-lesson-type-btn-manage.selected')?.dataset.type || 'single';

        let cmid = null;
        if (lessonType === 'single') {
            const selectedSingleEl = document.querySelector(
                '.single-lesson-dropdown-card .single-lesson-dropdown-item.selected');
            const displayEl = document.getElementById('singleLessonDropdownDisplayManage');
            cmid = window.selectedCmidManage ?? selectedSingleEl?.dataset?.cmid ?? displayEl
                ?.dataset?.cmid ?? null;
        } else {
            const selectedWeeklyEl = document.querySelector(
                '.weekly-single-lesson-container .weekly-single-lesson-item.selected');
            const displayEl = document.getElementById('weeklyLessonDropdownDisplayManage');
            cmid = window.selectedCmidManage ?? selectedWeeklyEl?.dataset?.cmid ?? displayEl
                ?.dataset?.cmid ?? null;
        }

        // Get the original event data from global variable
        const originalEventData = window.currentEventData || null;

        // Extract event ID from multiple possible sources
        let eventId = null;
        if (originalEventData && originalEventData.eventid) {
            eventId = originalEventData.eventid;
        } else if (originalEventData && originalEventData.id) {
            eventId = originalEventData.id;
        } else if (window.eventId) {
            eventId = window.eventId;
        } else {
            // Try to get from URL parameters
            const urlParams = new URLSearchParams(window.location.search);
            eventId = urlParams.get('eventid') || urlParams.get('id') || null;
        }

        console.log('🔍 Event ID Detection:', {
            fromEventid: originalEventData?.eventid || 'not found',
            fromId: originalEventData?.id || 'not found',
            fromWindowEventId: window.eventId || 'not found',
            fromURL: eventId,
            finalEventId: eventId
        });

        const formData = {
            teacher,
            student,
            teacherId: teacher.id || null,
            studentId: student.id || null,
            lessonType,
            cmid: cmid,
            timestamp: new Date().toISOString(),
            // Add event ID
            eventId: eventId,
            // Add current data (original/old data)
            currentData: originalEventData ? {
                eventId: eventId,
                title: originalEventData.title,
                teacherId: originalEventData.teacherId,
                studentids: originalEventData.studentids,
                cohortids: originalEventData.cohortids,
                start: originalEventData.start,
                end: originalEventData.end,
                date: originalEventData.date,
                classType: originalEventData.classType,
                duration: originalEventData.duration
            } : null,
            // Add new data will be populated below after getting all form values
            newData: {},
            // Add change teacher info if checkbox is checked
            changeTeacher: window.isChangeTeacherChecked ? window.isChangeTeacherChecked() :
                false,
            newTeacherId: window.isChangeTeacherChecked && window.isChangeTeacherChecked() ?
                (window.getSelectedNewTeacher ? window.getSelectedNewTeacher() : null) : null
        };

        console.log(
            `Event ID: ${formData.eventId ?? 'N/A'} | Teacher ID: ${formData.teacherId ?? 'N/A'} | Student ID: ${formData.studentId ?? 'N/A'} | CMID: ${cmid ?? 'N/A'}`,
            formData.changeTeacher ?
            ` | Change Teacher: YES | New Teacher ID: ${formData.newTeacherId ?? 'N/A'}` : '',
            '\nCurrent Data:', formData.currentData
        );

        if (lessonType === 'single') {
            // ✅ FIX: Always read CURRENT values from DOM
            const durationMinutes = getSelectedDurationInMinutes();
            const durationDisplay = formatMinutesToDisplay(durationMinutes);

            // ✅ Read the ACTUAL current date from the display element
            const dateEl = document.getElementById('selectedDateTextManage');
            const currentDateText = dateEl?.textContent.trim() || '';

            // ✅ Parse the display text to get the actual date
            let date = dateEl?.dataset?.fullDate || '';

            // If dataset.fullDate is not set, parse from text
            if (!date && currentDateText) {
                // Parse format like "Tue, Feb 11" or "Tue, Feb11"
                const parts = currentDateText.replace(',', '').split(' ').filter(p => p);
                if (parts.length >= 3) {
                    const monthStr = parts[1].replace(/\d+/g, ''); // Remove any digits from month
                    const dayMatch = currentDateText.match(/\d+/); // Find first number
                    const day = dayMatch ? parseInt(dayMatch[0]) : 1;
                    const year = new Date().getFullYear(); // Use current year

                    const monthMap = {
                        'Jan': 0,
                        'Feb': 1,
                        'Mar': 2,
                        'Apr': 3,
                        'May': 4,
                        'Jun': 5,
                        'Jul': 6,
                        'Aug': 7,
                        'Sep': 8,
                        'Oct': 9,
                        'Nov': 10,
                        'Dec': 11
                    };

                    const month = monthMap[monthStr];
                    if (month !== undefined) {
                        // ✅ FIX: Create date at noon to avoid timezone issues
                        const dateObj = new Date(year, month, day, 12, 0, 0);
                        // Format as YYYY-MM-DD without timezone conversion
                        const yyyy = dateObj.getFullYear();
                        const mm = String(dateObj.getMonth() + 1).padStart(2, '0');
                        const dd = String(dateObj.getDate()).padStart(2, '0');
                        date = `${yyyy}-${mm}-${dd}`;
                    }
                }
            }

            // ✅ Read the ACTUAL current time from the input
            const timeInput = document.querySelector(
                '#manageclassTabContent .custom-time-pill .time-input');
            const time = timeInput?.value.trim() || '';

            formData.singleLesson = {
                duration: durationMinutes,
                durationDisplay: durationDisplay,
                date,
                time,
                cmid: cmid,
                fullDateTime: `${date} at ${time}`
            };

            console.log('✅ CURRENT Single Lesson Data:');
            console.log(`  - Date Display Text: ${currentDateText}`);
            console.log(`  - Parsed Date: ${date}`);
            console.log(`  - Duration: ${durationMinutes} minutes (${durationDisplay})`);
            console.log(`  - Time: ${time}`);
            console.log(`  - CMID: ${cmid}`);
        } else {
            // ✅ FIX: Read CURRENT values for weekly lesson
            const intervalEl = document.getElementById('weeklyLessonIntervalDisplayManage');
            const interval = intervalEl?.textContent.trim() || '1';

            const periodEl = document.getElementById('weeklyLessonPeriodDisplayManage');
            const period = periodEl?.textContent.trim() || 'Week';

            const startEl = document.getElementById('weeklyLessonStartDateTextManage');
            const startDateText = startEl?.textContent.trim() || '';
            const startDate = startEl?.dataset?.fullDate || startDateText;

            const endRadio = document.querySelector(
                'input[name="weeklyLessonEndOptionManage"]:checked');
            const endOption = endRadio?.id || 'weeklyLessonEndNeverManage';
            const endOptionLabel = endRadio?.nextElementSibling?.textContent || 'Never';

            const endsOnEl = document.getElementById('weeklyLessonEndDateBtnManage');
            const endsOn = endsOnEl?.dataset?.fullDate || endsOnEl?.textContent.trim() || 'Never';

            const occurrencesEl = document.getElementById('weeklyLessonOccurrenceDisplayManage');
            const occurrences = occurrencesEl?.textContent.trim() || '';

            // ✅ Read CURRENT selected days and times
            const selectedDays = [];
            const dayWidgets = document.querySelectorAll(
                '.weekly_lesson_scroll_widget_manage.selected');

            dayWidgets.forEach(widget => {
                const dayText = widget.querySelector('.weekly_lesson_widget_text_manage')
                    ?.textContent || '';
                const startTime = widget.querySelector(
                    '.weekly_lesson_widget_hour_minute_manage.start')?.textContent || '';
                const endTime = widget.querySelector(
                    '.weekly_lesson_widget_hour_minute_manage.end')?.textContent || '';
                const startPeriod = widget.querySelector(
                        '.weekly_lesson_widget_period_manage.start-period')?.textContent ||
                    '';
                const endPeriod = widget.querySelector(
                    '.weekly_lesson_widget_period_manage.end-period')?.textContent || '';

                if (startTime && endTime) {
                    selectedDays.push({
                        day: dayText,
                        start: `${startTime} ${startPeriod}`,
                        end: `${endTime} ${endPeriod}`
                    });
                }
            });

            formData.weeklyLesson = {
                startDate,
                interval,
                period,
                endOption,
                endOptionLabel,
                endsOn,
                occurrences,
                days: selectedDays,
                totalDays: selectedDays.length,
                cmid: cmid
            };
        }

        // Populate newData with only the changed/updated form values
        formData.newData = {};

        // Only add changed fields
        if (formData.changeTeacher && formData.newTeacherId) {
            formData.newData.teacherId = formData.newTeacherId;
        }

        // Add lesson type specific data
        if (formData.lessonType === 'single' && formData.singleLesson) {
            formData.newData.singleLesson = formData.singleLesson;
            // Add reschedule reason and message if present
            if (window.rescheduleReason) {
                formData.newData.rescheduleReason = window.rescheduleReason;
                formData.newData.rescheduleMessage = window.rescheduleMessage || '';
                console.log('📝 Reschedule Reason:', formData.newData.rescheduleReason);
                console.log('💬 Reschedule Message:', formData.newData.rescheduleMessage);
            }
        } else if (formData.lessonType === 'weekly' && formData.weeklyLesson) {
            formData.newData.weeklyLesson = formData.weeklyLesson;
            // Add allEvents flag for weekly lessons
            formData.newData.allEvents = window.allEvents || false;
            console.log('📌 All Events:', formData.newData.allEvents);
        }

        console.log('📤 Final Form Data:', formData);
        console.log('📋 New Data (Updated fields only):', formData.newData);

        const payload = {
            data: formData,
            eventId: formData.eventId
        };

        console.log('📦 Sending Payload with Event ID:', payload.eventId, '| Full Payload:',
            payload);

        // Show loader
        if (loaderOverlay) loaderOverlay.classList.add('active');

        try {
            const response = await fetch('ajax/update_one2one.php', {
                method: 'POST',
                credentials: 'same-origin',
                headers: {
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify(payload)
            });

            const result = await response.json();
            console.log('Update Response:', result);

            // Hide loader
            if (loaderOverlay) loaderOverlay.classList.remove('active');

            if (!result.success) {
                showToastManage('❌ Error: ' + result.message);
                return;
            }

            showToastManage('✅ Session updated successfully!');

            if (window.refetchCustomPluginData) {
                window.refetchCustomPluginData('update-one2one');
            } else if (window.fetchCalendarEvents) {
                window.fetchCalendarEvents();
            }

            // Reset form after successful submission
            setTimeout(() => {
                resetManageClassForm();
            }, 1000);
        } catch (error) {
            console.error('Update Error:', error);
            // Hide loader
            if (loaderOverlay) loaderOverlay.classList.remove('active');
            showToastManage('❌ Something went wrong while updating the session.');
        }
    });

    /* =======================================================
       RESET FORM FUNCTION
    ======================================================== */
    function resetManageClassForm() {
        // Reset teacher selection (keep first teacher if available)
        const firstTeacher = teacherList?.querySelector(
            '.calendar_admin_details_create_cohort_manage_class_tab_item[role="option"]');
        if (firstTeacher && teacherTrigger && teacherImg && teacherLabel) {
            const userId = firstTeacher.dataset?.userid;
            const name = firstTeacher.dataset?.name;
            const imageUrl = firstTeacher.dataset?.img;

            teacherTrigger.dataset.userid = userId || '';
            teacherTrigger.dataset.name = name || '';
            teacherTrigger.dataset.img = imageUrl || '';

            if (imageUrl) teacherImg.src = imageUrl;
            if (name) teacherLabel.textContent = name;

            $$('.calendar_admin_details_create_cohort_manage_class_tab_item[aria-selected="true"]', teacherList)
                .forEach(el => el.removeAttribute('aria-selected'));
            firstTeacher.setAttribute('aria-selected', 'true');
        }

        // Reset student dropdown
        if (addStudentBtn) {
            addStudentBtn.innerHTML = `
                <span class="one2one-add-student-icon">
                    <svg width="21" height="21" viewBox="0 0 20 20" fill="none">
                        <circle cx="10" cy="7" r="4" fill="#000" />
                        <ellipse cx="10" cy="15.3" rx="6.5" ry="3.3" fill="#000" />
                    </svg>
                </span>
                <span class="one2one-add-student-placeholder" style="color:#aaa;">Select a teacher first</span>
            `;
            addStudentBtn.classList.remove('active');
        }

        if (studentDropdownWrapper) {
            studentDropdownWrapper.classList.add('disabled');
        }

        if (studentDropdownWrap) {
            $$('.one2one-student-list-item', studentDropdownWrap).forEach(item => {
                item.classList.remove('selected');
            });
        }

        // Reset lesson type selection
        lessonTypeBtns.forEach(btn => {
            btn.classList.remove('selected');
            const radio = btn.querySelector('input[type="radio"]');
            if (radio) radio.checked = false;
        });

        // Show single section by default to prevent button from moving to top
        if (singleSection) singleSection.style.display = 'block';
        if (weeklySection) weeklySection.style.display = 'none';

        // Reset single lesson dropdown
        const singleDropdownDisplay = $('#singleLessonDropdownDisplayManage');
        if (singleDropdownDisplay) {
            singleDropdownDisplay.textContent = 'Single Lessons';
        }

        const singleDropdownCard = $('.single-lesson-dropdown-card');
        if (singleDropdownCard) {
            singleDropdownCard.innerHTML = '';
        }

        // Reset duration dropdown
        const durationDisplay = $('#durationDropdownDisplayManage');
        if (durationDisplay) {
            durationDisplay.textContent = '50 Minutes (Standard time)';
            durationDisplay.dataset.minutes = '50';
        }

        $$('.one2one-duration-option').forEach(opt => opt.classList.remove('selected'));
        const defaultDuration = $('.one2one-duration-option[data-minutes="50"]');
        if (defaultDuration) defaultDuration.classList.add('selected');

        // Reset date display
        const dateText = $('#selectedDateTextManage');
        if (dateText) {
            dateText.textContent = 'Tue, Feb11';
            delete dateText.dataset.fullDate;
        }

        // Reset time input
        const timeInput = $('#manageclassTabContent .custom-time-pill .time-input');
        if (timeInput) {
            timeInput.value = '10:30 am';
        }

        // Reset weekly lesson dropdown
        const weeklyDropdownDisplay = $('#weeklyLessonDropdownDisplayManage');
        if (weeklyDropdownDisplay) {
            weeklyDropdownDisplay.textContent = 'Weekly Lessons';
        }

        const weeklyDropdownContainer = $('.weekly-single-lesson-container');
        if (weeklyDropdownContainer) {
            weeklyDropdownContainer.innerHTML = '';
        }

        // Reset weekly widgets
        const weeklyWidgets = $$('.weekly_lesson_scroll_widget_manage');
        weeklyWidgets.forEach(widget => {
            widget.classList.remove('selected');
            const timeElement = widget.querySelector('.weekly_lesson_widget_time_manage');
            if (timeElement) timeElement.remove();
            const button = widget.querySelector('.weekly_lesson_widget_button_manage');
            if (button) {
                button.classList.remove('has-time');
                const dot = button.querySelector('.weekly_lesson_dot');
                if (dot) dot.remove();
            }
        });

        // Reset weekly modal values
        const intervalDisplay = $('#weeklyLessonIntervalDisplayManage');
        if (intervalDisplay) intervalDisplay.textContent = '1';

        const periodDisplay = $('#weeklyLessonPeriodDisplayManage');
        if (periodDisplay) periodDisplay.textContent = 'Week';

        const startDateText = $('#weeklyLessonStartDateTextManage');
        if (startDateText) {
            startDateText.textContent = 'Select start date';
            delete startDateText.dataset.fullDate;
        }

        // Reset end options
        const endNeverRadio = $('#weeklyLessonEndNeverManage');
        if (endNeverRadio) endNeverRadio.checked = true;

        const endOnRadio = $('#weeklyLessonEndOnManage');
        if (endOnRadio) endOnRadio.checked = false;

        const endAfterRadio = $('#weeklyLessonEndAfterManage');
        if (endAfterRadio) endAfterRadio.checked = false;

        const occurrenceDisplay = $('#weeklyLessonOccurrenceDisplayManage');
        if (occurrenceDisplay) occurrenceDisplay.textContent = '13 occurrences';

        // Clear global variables
        window.selectedCmidManage = null;
        window.rescheduleReason = null;
        window.rescheduleMessage = null;
        window.allEvents = false;
        if (window.weeklyLessonDayTimes) {
            window.weeklyLessonDayTimes = {};
        }

        // Re-validate form (should disable submit button)
        validateForm();

        // Reload students if teacher is selected
        const teacherId = teacherTrigger?.dataset.userid;
        if (teacherId) {
            loadStudentsForTeacher(teacherId, true);
        }

        console.log('Form reset successfully');
    }
});

// ========== CHANGE TEACHER FUNCTIONALITY ==========
$(document).ready(function() {
    let selectedNewTeacherId = null;

    // Toggle new teacher dropdown section when checkbox is checked
    $('#changeTeacherCheckbox').on('change', function() {
        if ($(this).is(':checked')) {
            $('#newTeacherDropdownSection').slideDown(200);
        } else {
            $('#newTeacherDropdownSection').slideUp(200);
            selectedNewTeacherId = null;
            // Reset new teacher selection
            $('#newTeacherCurrentLabel').text('Select new teacher');
            $('#newTeacherCurrentImg').attr('src',
                'https://images.unsplash.com/photo-1544005313-94ddf0286df2?q=80&w=200&auto=format&fit=crop'
            );
            $('#newTeacherDropdownTrigger').removeAttr('data-userid');
            $('.new-teacher-item').removeClass('selected');
        }
    });

    // Toggle new teacher dropdown list
    $('#newTeacherDropdownTrigger').on('click', function(e) {
        e.stopPropagation();
        const $menu = $('#newTeacherDropdownMenu');
        const isOpen = $menu.is(':visible');

        // Close all other dropdowns first
        $('.calendar_admin_details_create_cohort_manage_class_tab_menu').not($menu).hide();

        if (isOpen) {
            $menu.hide();
            $(this).attr('aria-expanded', 'false');
        } else {
            $menu.show();
            $(this).attr('aria-expanded', 'true');
        }
    });

    // Close dropdown when clicking outside
    $(document).on('click', function(e) {
        if (!$(e.target).closest('#newTeacherDropdownTrigger, #newTeacherDropdownMenu').length) {
            $('#newTeacherDropdownMenu').hide();
            $('#newTeacherDropdownTrigger').attr('aria-expanded', 'false');
        }
    });

    // Search functionality for new teacher dropdown
    $('#newTeacherSearchInput').on('input', function() {
        const searchTerm = $(this).val().toLowerCase();
        $('.new-teacher-item').each(function() {
            const teacherName = $(this).data('name').toLowerCase();
            if (teacherName.includes(searchTerm)) {
                $(this).show();
            } else {
                $(this).hide();
            }
        });
    });

    // Prevent dropdown from closing when clicking search input
    $('#newTeacherSearchInput').on('click', function(e) {
        e.stopPropagation();
    });

    // Select new teacher
    $(document).on('click', '.new-teacher-item', function() {
        if ($(this).attr('aria-disabled') === 'true') return;

        const teacherId = $(this).data('userid');
        const teacherName = $(this).data('name');
        const teacherImg = $(this).data('img');

        // Update selection
        selectedNewTeacherId = teacherId;
        $('.new-teacher-item').removeClass('selected');
        $(this).addClass('selected');

        // Update trigger button display
        $('#newTeacherCurrentLabel').text(teacherName);
        $('#newTeacherCurrentImg').attr('src', teacherImg);
        $('#newTeacherDropdownTrigger').attr('data-userid', teacherId);

        // Close dropdown
        $('#newTeacherDropdownMenu').hide();
        $('#newTeacherDropdownTrigger').attr('aria-expanded', 'false');

        console.log('New teacher selected:', teacherId, teacherName);
    });

    // Expose getter for selected new teacher
    window.getSelectedNewTeacher = function() {
        return selectedNewTeacherId;
    };

    window.isChangeTeacherChecked = function() {
        return $('#changeTeacherCheckbox').is(':checked');
    };
});
</script>