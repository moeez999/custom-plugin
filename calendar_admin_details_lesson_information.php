<!-- ===== Toast (top-right notification) ===== -->
<div id="calendar_admin_toast" class="calendar_admin_toast" role="status" aria-live="polite" aria-atomic="true">
    <div class="calendar_admin_toast_icon" aria-hidden="true">
        <svg width="18" height="18" viewBox="0 0 24 24">
            <path d="M20 6L9 17l-5-5" fill="none" stroke="#fff" stroke-width="2" stroke-linecap="round"
                stroke-linejoin="round" />
        </svg>
    </div>
    <div class="calendar_admin_toast_body">
        <div class="calendar_admin_toast_title">Lesson Rescheduled</div>
        <div class="calendar_admin_toast_text" id="calendar_admin_toast_line2">English with Mary Janes</div>
        <div class="calendar_admin_toast_text" id="calendar_admin_toast_line3">Friday, Sep 6, 6:00 – 6:25 PM</div>
    </div>
    <button type="button" class="calendar_admin_toast_close" aria-label="Close">
        <svg width="16" height="16" viewBox="0 0 24 24">
            <path d="M6 6l12 12M18 6L6 18" stroke="#fff" stroke-width="2" stroke-linecap="round" />
        </svg>
    </button>
</div>

<!-- ===== Backdrop (shared by center modal + right drawer + cancel + reschedule step2 + reschedule step3) ===== -->
<div id="calendar_admin_details_lesson_information_backdrop" class="calendar_admin_details_lesson_information_scope">
    <!-- ===== CENTER MODAL: Lesson information ===== -->
    <section class="calendar_admin_details_lesson_information_modal" role="dialog" aria-modal="true"
        aria-labelledby="cali_title">
        <header class="calendar_admin_details_lesson_information_header">
            <h2 id="cali_title" class="calendar_admin_details_lesson_information_title">Lesson information</h2>
            <button type="button" class="calendar_admin_details_lesson_information_close" aria-label="Close">
                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M6 6L18 18M18 6L6 18" stroke="currentColor" stroke-width="2" stroke-linecap="round" />
                </svg>
            </button>
        </header>

        <div class="calendar_admin_details_lesson_information_body">
            <div class="calendar_admin_details_lesson_information_card">
                <div class="calendar_admin_details_lesson_information_row">
                    <img class="calendar_admin_details_lesson_information_avatar"
                        src="https://randomuser.me/api/portraits/men/32.jpg" alt="User avatar">

                    <div class="calendar_admin_details_lesson_information_main">
                        <p class="calendar_admin_details_lesson_information_day">Friday , Sep 06</p>
                        <p class="calendar_admin_details_lesson_information_time">09:00 - 10:00 AM</p>
                    </div>
                </div>
                <hr class="calendar_admin_details_lesson_information_divider">
                <div class="calendar_admin_details_lesson_information_meta_row">
                    <p class="calendar_admin_details_lesson_information_meta">Mary Janes | Subscription</p>
                    <div class="calendar_admin_details_lesson_information_wallet">
                        <img src="./img/lesson_icon.svg" alt="Lessons icon">
                        <span class="calendar_admin_details_lesson_information_lessons">3 lessons</span>
                    </div>
                </div>
            </div>

            <div class="calendar_admin_details_lesson_information_action_buttons">
                <button type="button" class="calendar_admin_details_lesson_information_action"
                    id="calendar_admin_details_lesson_information_open_chat">Message</button>
                <button type="button" class="calendar_admin_details_lesson_information_action"
                    id="calendar_admin_details_1_1_class">View or Reschedule lesson</button>
                <button type="button" class="calendar_admin_details_lesson_information_danger"
                    id="calendar_admin_details_lesson_information_cancel_trigger">Cancel lesson</button>
            </div>
        </div>
    </section>

    <!-- ===== CENTER MODAL: Cancel Lesson ===== -->
    <div class="calendar_admin_cancel_modal" role="dialog" aria-modal="true" aria-labelledby="cancel_title">
        <div class="calendar_admin_cancel_header">
            <button type="button" class="calendar_admin_cancel_back" aria-label="Back to lesson info">
                <img src="./img/arrow-back.svg" alt="Back to lesson info">
            </button>
            <button type="button" class="calendar_admin_cancel_close" aria-label="Close">
                <svg width="22" height="22" viewBox="0 0 24 24">
                    <path d="M6 6l12 12M18 6L6 18" stroke="#111" stroke-width="2" stroke-linecap="round" />
                </svg>
            </button>
        </div>

        <div class="calendar_admin_cancel_body">
            <h5 id="cancel_title" class="calendar_admin_cancel_title">Are You Sure You Want To Cancel?</h5>

            <p class="calendar_admin_cancel_note">
                Please note that the lesson <strong>Tuesday , Sep 03 7:00 – 7:25 with jonas</strong> will be canceled
                and will not be rescheduled.
                This cancellation is final, and there will be no makeup session. Let us know if any further action is
                needed.
            </p>

            <label class="form-label fw-semibold mb-2">Please choose a reason for cancel lesson</label>
            <!-- Custom dropdown: Reschedule reason -->
            <div class="ca_dd_wrap" id="resched_reason_dd">
                <button type="button" class="ca_dd_btn" aria-haspopup="listbox" aria-expanded="false">
                    <span class="ca_dd_placeholder">Select Reason</span>
                    <span class="ca_dd_value" style="display:none;"></span>
                    <span class="ca_dd_caret" aria-hidden="true">

                        <img src="./img/dropdown-arrow-down.svg" alt="dropdown arrow">
                    </span>
                </button>

                <div class="ca_dd_menu" role="listbox" tabindex="-1">
                    <div class="ca_dd_opt" role="option" data-value="cant-make">He’s not able to make it today.</div>
                    <div class="ca_dd_opt" role="option" data-value="timing">The timing isn’t working out today.</div>
                    <div class="ca_dd_opt" role="option" data-value="tech-issues">There are some tech issues, so we
                        can’t run the class.</div>
                    <div class="ca_dd_opt" role="option" data-value="teacher-na">The teacher isn’t available right now.
                    </div>
                </div>

                <!-- Keep same ID as your old <select> so existing code keeps working -->
                <input type="hidden" id="resched_reason_step3" value="">
            </div>

            <label for="calendar_admin_cancel_message" class="form-label fw-semibold mb-2">Message for Daniela •
                Optional</label>
            <textarea id="calendar_admin_cancel_message" class="form-control calendar_admin_cancel_textarea mb-3"
                rows="3" placeholder="Message for Daniela"></textarea>

            <div class="form-check mb-3 d-flex align-items-start calendar_admin_cancel_ack_wrap">
                <input class="form-check-input" type="checkbox" id="calendar_admin_cancel_ack">
                <label class="form-check-label" for="calendar_admin_cancel_ack">
                    I know my position will decrease and fewer students will see
                </label>
            </div>

            <button type="button" class="btn calendar_admin_cancel_resched w-100 mb-3"
                id="calendar_admin_cancel_reschedule_btn">
                Reschedule lesson
            </button>

            <button type="button" class="btn calendar_admin_cancel_confirm w-100"
                id="calendar_admin_cancel_confirm_btn">
                Confirm Cancel
            </button>
        </div>
    </div>

    <!-- ===== CENTER MODAL: Reschedule Lesson — STEP 2 ===== -->
    <section class="calendar_admin_reschedule_modal" role="dialog" aria-modal="true" aria-labelledby="resched_title">
        <div class="calendar_admin_reschedule_modal_inner">
            <header class="calendar_admin_reschedule_header">
                <h1 id="resched_title" class="calendar_admin_reschedule_title">Reschedule lesson</h1>
                <button type="button" class="calendar_admin_reschedule_close" aria-label="Close">
                    <svg width="24" height="24" viewBox="0 0 24 24">
                        <path d="M6 6l12 12M18 6L6 18" stroke="#111" stroke-width="2" stroke-linecap="round" />
                    </svg>
                </button>
            </header>

            <div class="calendar_admin_reschedule_body">
                <div class="calendar_admin_reschedule_current_lesson_group">
                    <h2 class="calendar_admin_reschedule_label">Current lesson</h2>
                    <div class="calendar_admin_details_lesson_information_card">
                        <div class="calendar_admin_details_lesson_information_row">
                            <div class="calendar_admin_details_lesson_information_header_avatar">
                                <svg width="22" height="22" viewBox="0 0 24 24">
                                    <circle cx="12" cy="8" r="4" fill="#fff" />
                                    <path d="M4 20c1.8-4 6.2-6 8-6s6.2 2 8 6" stroke="#fff" stroke-width="1.5"
                                        fill="none" />
                                </svg>
                            </div>
                            <div class="calendar_admin_details_lesson_information_main">
                                <p class="calendar_admin_details_lesson_information_day">Friday , Sep 06</p>
                                <p class="calendar_admin_details_lesson_information_time">6:00 - 6:25 PM</p>
                            </div>
                        </div>
                        <hr class="calendar_admin_details_lesson_information_divider">
                        <div class="calendar_admin_details_lesson_information_meta_row">
                            <p class="calendar_admin_details_lesson_information_meta">Mary Janes | Subscription</p>
                            <div class="calendar_admin_details_lesson_information_wallet">
                                <svg width="26" height="26" viewBox="0 0 24 24" aria-hidden="true">
                                    <path d="M21 7H5a2 2 0 0 1 0-4h12" fill="none" stroke="#444" stroke-width="1.6"
                                        stroke-linecap="round" />
                                    <rect x="3" y="5" width="18" height="14" rx="2" ry="2" fill="none" stroke="#444"
                                        stroke-width="1.6" />
                                    <circle cx="17" cy="12" r="1.2" fill="#444" />
                                </svg>
                                <span class="calendar_admin_details_lesson_information_lessons">2 lessons</span>
                            </div>
                        </div>
                    </div>
                </div>

                <form class="calendar_admin_reschedule_form">
                    <fieldset class="calendar_admin_reschedule_form_group">
                        <legend class="calendar_admin_reschedule_label calendar_admin_reschedule_label_form">Date and
                            time</legend>

                        <!-- Custom dropdown: Duration -->
                        <div class="ca_dd_wrap calendar_admin_reschedule_select_control calendar_admin_reschedule_select_control_full_width"
                            id="resched_duration_dd">
                            <button type="button" class="ca_dd_btn" aria-haspopup="listbox" aria-expanded="false">
                                <span class="ca_dd_placeholder">50 Minutes ( Standard time )</span>
                                <span class="ca_dd_value" style="display:none;"></span>
                                <span class="ca_dd_caret" aria-hidden="true"> <img src="./img/dropdown-arrow-down.svg"
                                        alt="dropdown arrow"></span>
                            </button>

                            <div class="ca_dd_menu" role="listbox" tabindex="-1">
                                <div class="ca_dd_opt" role="option" data-value="25">25 Minutes</div>
                                <div class="ca_dd_opt" role="option" data-value="50">50 Minutes</div>
                                <div class="ca_dd_opt" role="option" data-value="60">1 Hour</div>
                                <div class="ca_dd_opt" role="option" data-value="90">1.5 Hour</div>
                            </div>

                            <!-- Keep the SAME id your JS uses -->
                            <input type="hidden" id="resched_duration" value="50">
                        </div>

                        <div class="ca_res_row calendar_admin_reschedule_form_row">
                            <!-- DATE FIELD (custom date picker that opens calendar) -->
                            <div class="ca_res_col">
                                <div class="resched-date-dropdown-display" id="reschedDateDropdownDisplay"
                                    style="width:100%; padding:13px 14px; border-radius:10px; border:1.5px solid #dadada; background:#fff; font-size:1.05rem; color:#232323; margin-bottom:0px; cursor:pointer; display:flex; align-items:center; justify-content:center;">
                                    <span id="reschedDateText">Tue, Feb11</span>
                                </div>

                                <!-- Hidden value used by your existing code: $('#resched_date').val() -->
                                <input type="hidden" id="resched_date" value="Tue, Feb11">
                            </div>

                            <!-- TIME (custom time picker) -->
                            <div class="ca_res_col">
                                <div class="resched-custom-time-pill">
                                    <input type="text" class="form-control resched-time-input" value="12:00 AM"
                                        autocomplete="off" style="background-color:#ffffff; height: 50px;width:100%;"
                                        id="resched_time_input" readonly="readonly">
                                    <div class="resched-custom-time-dropdown" style="display: none;">
                                        <div class="resched-dropdown-item">12:00 AM</div>
                                        <div class="resched-dropdown-item">12:30 AM</div>
                                        <div class="resched-dropdown-item">1:00 AM</div>
                                        <div class="resched-dropdown-item">1:30 AM</div>
                                        <div class="resched-dropdown-item">2:00 AM</div>
                                        <div class="resched-dropdown-item">2:30 AM</div>
                                        <div class="resched-dropdown-item">3:00 AM</div>
                                        <div class="resched-dropdown-item">3:30 AM</div>
                                        <div class="resched-dropdown-item">4:00 AM</div>
                                        <div class="resched-dropdown-item">4:30 AM</div>
                                        <div class="resched-dropdown-item">5:00 AM</div>
                                        <div class="resched-dropdown-item">5:30 AM</div>
                                        <div class="resched-dropdown-item">6:00 AM</div>
                                        <div class="resched-dropdown-item">6:30 AM</div>
                                        <div class="resched-dropdown-item">7:00 AM</div>
                                        <div class="resched-dropdown-item">7:30 AM</div>
                                        <div class="resched-dropdown-item">8:00 AM</div>
                                        <div class="resched-dropdown-item">8:30 AM</div>
                                        <div class="resched-dropdown-item">9:00 AM</div>
                                        <div class="resched-dropdown-item">9:30 AM</div>
                                        <div class="resched-dropdown-item">10:00 AM</div>
                                        <div class="resched-dropdown-item">10:30 AM</div>
                                        <div class="resched-dropdown-item">11:00 AM</div>
                                        <div class="resched-dropdown-item">11:30 AM</div>
                                        <div class="resched-dropdown-item">12:00 PM</div>
                                        <div class="resched-dropdown-item">12:30 PM</div>
                                        <div class="resched-dropdown-item">1:00 PM</div>
                                        <div class="resched-dropdown-item">1:30 PM</div>
                                        <div class="resched-dropdown-item">2:00 PM</div>
                                        <div class="resched-dropdown-item">2:30 PM</div>
                                        <div class="resched-dropdown-item">3:00 PM</div>
                                        <div class="resched-dropdown-item">3:30 PM</div>
                                        <div class="resched-dropdown-item">4:00 PM</div>
                                        <div class="resched-dropdown-item">4:30 PM</div>
                                        <div class="resched-dropdown-item">5:00 PM</div>
                                        <div class="resched-dropdown-item">5:30 PM</div>
                                        <div class="resched-dropdown-item">6:00 PM</div>
                                        <div class="resched-dropdown-item">6:30 PM</div>
                                        <div class="resched-dropdown-item">7:00 PM</div>
                                        <div class="resched-dropdown-item">7:30 PM</div>
                                        <div class="resched-dropdown-item">8:00 PM</div>
                                        <div class="resched-dropdown-item">8:30 PM</div>
                                        <div class="resched-dropdown-item">9:00 PM</div>
                                        <div class="resched-dropdown-item">9:30 PM</div>
                                        <div class="resched-dropdown-item">10:00 PM</div>
                                        <div class="resched-dropdown-item">10:30 PM</div>
                                        <div class="resched-dropdown-item">11:00 PM</div>
                                        <div class="resched-dropdown-item">11:30 PM</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </fieldset>
                </form>

                <div class="calendar_admin_reschedule_hint calendar_admin_reschedule_info_banner">
                    <svg width="18" height="18" viewBox="0 0 24 24">
                        <circle cx="12" cy="12" r="9" fill="none" stroke="#777" stroke-width="1.6" />
                        <path d="M12 8v5m0 4h0" stroke="#777" stroke-width="1.6" stroke-linecap="round" />
                    </svg>
                    <p>That's Sunday at 16:30 for Mary Janes</p>
                </div>
            </div>

            <footer class="calendar_admin_reschedule_footer">
                <button type="button" class="btn calendar_admin_reschedule_continue w-100"
                    id="calendar_admin_reschedule_continue_btn">
                    Continue
                </button>
            </footer>
        </div>
    </section>

    <!-- ===== CENTER MODAL: Reschedule Lesson — STEP 3 (CONFIRM) ===== -->
    <div class="calendar_admin_reschedule_confirm_modal" role="dialog" aria-modal="true"
        aria-labelledby="resched_confirm_title">
        <div class="calendar_admin_reschedule_header">
            <button type="button" class="calendar_admin_reschedule_confirm_back" aria-label="Back to step 2">
                <img src="./img/arrow-back.svg" alt="back arrow">
            </button>
            <button type="button" class="calendar_admin_reschedule_close" aria-label="Close">
                <svg width="22" height="22" viewBox="0 0 24 24">
                    <path d="M6 6l12 12M18 6L6 18" stroke="#111" stroke-width="2" stroke-linecap="round" />
                </svg>
            </button>
        </div>

        <div class="calendar_admin_reschedule_body_sub">
            <h5 id="resched_confirm_title" class="calendar_admin_reschedule_title">Reschedule lesson</h5>

            <span class="ca_res_chip">Updated lesson</span>

            <div class="calendar_admin_lite_card mb-3">
                <div class="calendar_admin_lite_row">
                    <div class="calendar_admin_lite_avatar">
                        <svg width="22" height="22" viewBox="0 0 24 24">
                            <circle cx="12" cy="8" r="4" fill="#fff" />
                            <path d="M4 20c1.8-4 6.2-6 8-6s6.2 2 8 6" stroke="#fff" stroke-width="1.5" fill="none" />
                        </svg>
                    </div>
                    <div class="calendar_admin_lite_main">
                        <div class="calendar_admin_lite_day" id="res3_day">Friday , Sep 06</div>
                        <div class="calendar_admin_lite_time" id="res3_time">07:00 – 07:25</div>
                    </div>
                </div>
                <hr class="calendar_admin_lite_divider">
                <div class="calendar_admin_lite_meta_row">
                    <div class="calendar_admin_lite_meta">Mary Janes | Subscription</div>
                    <div class="calendar_admin_details_lesson_information_wallet">
                        <svg width="26" height="26" viewBox="0 0 24 24" aria-hidden="true">
                            <path d="M21 7H5a2 2 0 0 1 0-4h12" fill="none" stroke="#444" stroke-width="1.6"
                                stroke-linecap="round" />
                            <rect x="3" y="5" width="18" height="14" rx="2" ry="2" fill="none" stroke="#444"
                                stroke-width="1.6" />
                            <circle cx="17" cy="12" r="1.2" fill="#444" />
                        </svg>
                        <span class="calendar_admin_details_lesson_information_lessons">2 Lessons</span>
                    </div>
                </div>
            </div>

            <label class="form-label fw-semibold mb-2">Please choose a reason for Reschedule lesson</label>
            <div class="ca_res_selectwrap mb-3">
                <select class="form-select" id="resched_reason_step3">
                    <option value="" selected disabled>Select Reason</option>
                    <option>Availability changed</option>
                    <option>Scheduling conflict</option>
                    <option>Travel</option>
                    <option>Technical issues</option>
                    <option>Other</option>
                </select>
                <span class="ca_res_select_icon" aria-hidden="true">

                    <img src="./img/dropdown-arrow-down.svg" alt="dropdown arrow">
                </span>
            </div>

            <label for="resched_message_step3" class="form-label fw-semibold mb-2">Message for Daniela •
                Optional</label>
            <textarea id="resched_message_step3" class="form-control calendar_admin_cancel_textarea mb-3" rows="3"
                placeholder="Message for Daniela"></textarea>

            <button type="button" class="btn ca_res_confirm w-100" id="calendar_admin_reschedule_confirm_new_time">
                Confirm new time
            </button>
        </div>
    </div>

    <!-- ===== RIGHT DRAWER: Message (unchanged) ===== -->
    <aside class="calendar_admin_details_lesson_information_drawer" role="dialog" aria-modal="true"
        aria-labelledby="cali_chat_title">
        <div class="calendar_admin_details_lesson_information_drawer_header">
            <div class="calendar_admin_details_lesson_information_drawer_titlewrap">
                <div class="calendar_admin_details_lesson_information_header_avatar">
                    <svg width="22" height="22" viewBox="0 0 24 24">
                        <circle cx="12" cy="8" r="4" fill="#fff" />
                        <path d="M4 20c1.8-4 6.2-6 8-6s6.2 2 8 6" stroke="#fff" stroke-width="1.5" fill="none" />
                    </svg>
                </div>
                <span class="calendar_admin_details_lesson_information_drawer_title" id="cali_chat_title">Jonas</span>
            </div>
            <button type="button" class="calendar_admin_details_lesson_information_drawer_close" aria-label="Close">
                <svg width="22" height="22" viewBox="0 0 24 24">
                    <path d="M6 6l12 12M18 6L6 18" stroke="#111" stroke-width="2" stroke-linecap="round" />
                </svg>
            </button>
        </div>

        <div class="calendar_admin_details_lesson_information_drawer_body">
            <div class="calendar_admin_details_lesson_information_chat_stamp">Today</div>

            <!-- Daniela -->
            <div class="calendar_admin_details_lesson_information_msg">
                <img src="https://randomuser.me/api/portraits/women/44.jpg" alt="Daniela">
                <div class="calendar_admin_details_lesson_information_msg_content">
                    <div class="calendar_admin_details_lesson_information_msg_head">
                        <strong>Daniela</strong> <span>09:34</span>
                    </div>
                    <div class="calendar_admin_details_lesson_information_msg_text">
                        Good morning, I want to confirm our meeting today and ask if the meeting will take place within
                        the Latingles virtual classroom or will you provide the information?
                    </div>
                </div>
            </div>

            <!-- Self 1 -->
            <div class="calendar_admin_details_lesson_information_msg self">
                <div class="calendar_admin_details_lesson_information_avatar_circle">
                    <svg width="20" height="20" viewBox="0 0 24 24">
                        <circle cx="12" cy="8" r="4" fill="#fff" />
                        <path d="M4 20c1.8-4 6.2-6 8-6s6.2 2 8 6" stroke="#fff" stroke-width="1.5" fill="none" />
                    </svg>
                </div>
                <div class="calendar_admin_details_lesson_information_msg_content">
                    <div class="calendar_admin_details_lesson_information_msg_head">
                        <strong>Latingles</strong> <span>11:06</span>
                    </div>
                    <div class="calendar_admin_details_lesson_information_msg_text">I'm already in, is anyone joining
                    </div>
                </div>
            </div>

            <!-- Self 2 -->
            <div class="calendar_admin_details_lesson_information_msg self">
                <div class="calendar_admin_details_lesson_information_avatar_circle">
                    <svg width="20" height="20" viewBox="0 0 24 24">
                        <circle cx="12" cy="8" r="4" fill="#fff" />
                        <path d="M4 20c1.8-4 6.2-6 8-6s6.2 2 8 6" stroke="#fff" stroke-width="1.5" fill="none" />
                    </svg>
                </div>
                <div class="calendar_admin_details_lesson_information_msg_content">
                    <div class="calendar_admin_details_lesson_information_msg_head">
                        <strong>Latingles</strong> <span>11:06</span>
                    </div>
                    <div class="calendar_admin_details_lesson_information_msg_text">Yes Please wait for me ! Thank you
                    </div>
                </div>
            </div>
        </div>

        <!-- Composer panel -->
        <div class="calendar_admin_details_lesson_information_drawer_footer">
            <div class="calendar_admin_details_lesson_information_composerPanel">
                <textarea class="calendar_admin_details_lesson_information_textarea" rows="1"
                    placeholder="Your message"></textarea>

                <div class="calendar_admin_details_lesson_information_composerActions">
                    <div class="calendar_admin_details_lesson_information_actions_left">
                        <input type="file" id="calendar_admin_details_lesson_information_file" style="display:none">
                        <button type="button" class="calendar_admin_details_lesson_information_icon"
                            id="calendar_admin_details_lesson_information_attach" title="Attach">
                            <svg width="22" height="22" viewBox="0 0 24 24">
                                <path d="M21 8l-9.4 9.4a5 5 0 01-7.1-7.1L14.5 0" fill="none" stroke="#777"
                                    stroke-width="1.7" stroke-linecap="round" stroke-linejoin="round" />
                            </svg>
                        </button>
                        <button type="button" class="calendar_admin_details_lesson_information_icon"
                            id="calendar_admin_details_lesson_information_emoji" title="Emoji">
                            <svg width="22" height="22" viewBox="0 0 24 24">
                                <circle cx="12" cy="12" r="9" fill="none" stroke="#777" stroke-width="1.7" />
                                <circle cx="9" cy="10" r="1" />
                                <circle cx="15" cy="10" r="1" />
                                <path d="M8 14c1.2 1.3 2.6 2 4 2s2.8-.7 4-2" fill="none" stroke="#777"
                                    stroke-width="1.7" stroke-linecap="round" />
                            </svg>
                        </button>
                    </div>

                    <div class="calendar_admin_details_lesson_information_actions_right">
                        <button type="button" class="calendar_admin_details_lesson_information_icon"
                            id="calendar_admin_details_lesson_information_mic" title="Voice">
                            <svg width="22" height="22" viewBox="0 0 24 24">
                                <rect x="9" y="3" width="6" height="10" rx="3" fill="none" stroke="#777"
                                    stroke-width="1.7" />
                                <path d="M5 11a7 7 0 0014 0M12 18v3" fill="none" stroke="#777" stroke-width="1.7"
                                    stroke-linecap="round" />
                            </svg>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </aside>
</div>

<!-- Calendar Modal for Reschedule Date Selection -->
<div class="calendar_admin_details_create_cohort_calendar_modal_backdrop" id="rescheduleCalendarBackdrop"
    style="display:none;">
    <div class="calendar_admin_details_create_cohort_calendar_modal" id="rescheduleCalendarModal">
        <div class="calendar_admin_details_create_cohort_calendar_nav">
            <button type="button" class="reschedule_calendar_prev"><svg width="22" height="22" viewBox="0 0 24 24">
                    <polyline points="15 19 8 12 15 5" fill="none" stroke="#111" stroke-width="2" stroke-linecap="round"
                        stroke-linejoin="round"></polyline>
                </svg></button>
            <span id="rescheduleCalendarMonth"></span>
            <button type="button" class="reschedule_calendar_next"><svg width="22" height="22" viewBox="0 0 24 24">
                    <polyline points="9 19 16 12 9 5" fill="none" stroke="#111" stroke-width="2" stroke-linecap="round"
                        stroke-linejoin="round"></polyline>
                </svg></button>
        </div>
        <div class="calendar_admin_details_create_cohort_calendar_days"></div>
        <button class="calendar_admin_details_create_cohort_calendar_done_btn">Done</button>
    </div>
</div>

<?php require_once('calendar_admin_details_lesson_information_calendar_modal.php');?>

<?php /* Keep external include commented to avoid duplicates:
require_once('calendar_admin_details_lesson_information_cancel_lesson.php'); */?>

<style>
/* ===== Toast ===== */
.calendar_admin_toast {
    position: fixed;
    top: 18px;
    right: 18px;
    z-index: 6000;
    display: none;
    align-items: flex-start;
    gap: 10px;
    background: #111;
    color: #fff;
    border-radius: 12px;
    padding: 12px 14px;
    box-shadow: 0 16px 40px rgba(0, 0, 0, .28);
    min-width: 290px;
    max-width: 360px;
}

.calendar_admin_toast_icon {
    width: 28px;
    height: 28px;
    border-radius: 50%;
    display: grid;
    place-items: center;
    background: #2ecc71;
}

.calendar_admin_toast_title {
    font-weight: 900;
}

.calendar_admin_toast_text {
    opacity: .9;
    margin-top: 2px;
}

.calendar_admin_toast_close {
    margin-left: auto;
    background: transparent;
    border: 0;
    width: 28px;
    height: 28px;
    border-radius: 8px;
    display: grid;
    place-items: center;
    cursor: pointer;
}

/* ===== Backdrop ===== */
#calendar_admin_details_lesson_information_backdrop.calendar_admin_details_lesson_information_scope {
    position: fixed;
    inset: 0;
    z-index: 2000;
    display: none;
    align-items: center;
    justify-content: center;
    padding: 18px;
    background: rgba(0, 0, 0, .45);
}

/* ===== CSS Variables ===== */
:root {
    --color-text-primary: #121117;
    --color-text-secondary: #4d4c5c;
    --color-text-white: #ffffff;
    --color-background: #ffffff;
    --color-danger-bg: #ff2500;
    --color-danger-border: #63110d;
    --color-border-light: #dcdce5;
    --color-border-medium: rgba(18, 17, 23, 0.12);
    --color-border-faint: #f4f4f8;
}

/* ===== Center Modal: Lesson Info ===== */
.calendar_admin_details_lesson_information_modal {
    background-color: var(--color-background);
    border: 1px solid var(--color-border-faint);
    border-radius: 8px;
    box-shadow: 0px 8px 32px 0px rgba(18, 17, 23, 0.15), 0px 16px 48px 0px rgba(18, 17, 23, 0.15);
    max-width: 464px;
    width: 100%;
    padding: 24px;
    position: relative;
    display: flex;
    flex-direction: column;
    gap: 11px;
}

.calendar_admin_details_lesson_information_header {
    display: flex;
    justify-content: space-between;
    align-items: center;
}

.calendar_admin_details_lesson_information_title {
    color: var(--color-text-primary);
    font-family: 'Poppins', sans-serif;
    font-weight: 600;
    font-size: 27.875px;
    line-height: 41.81px;
    margin: 0;
}

.calendar_admin_details_lesson_information_close {
    position: absolute;
    top: 24px;
    right: 24px;
    background: transparent;
    border: none;
    padding: 8px;
    cursor: pointer;
    display: flex;
    align-items: center;
    justify-content: center;
    width: 24px;
    height: 24px;
}

.calendar_admin_details_lesson_information_close svg {
    width: 24px;
    height: 24px;
}

.calendar_admin_details_lesson_information_body {
    display: flex;
    flex-direction: column;
    gap: 11px;
}

.calendar_admin_details_lesson_information_card {
    border: 1px solid var(--color-border-light);
    border-radius: 8px;
    padding: 19px 17px;
}

.calendar_admin_details_lesson_information_row {
    display: flex;
    align-items: center;
    gap: 16px;
}

.calendar_admin_details_lesson_information_avatar {
    width: 48px;
    height: 48px;
    border-radius: 4px;
    border: 1px solid rgba(18, 17, 23, 0.06);
    object-fit: cover;
}

.calendar_admin_details_lesson_information_main {
    display: flex;
    flex-direction: column;
}

.calendar_admin_details_lesson_information_main p {
    margin: 0;
}

.calendar_admin_details_lesson_information_day {
    color: var(--color-text-primary);
    font-family: 'Poppins', sans-serif;
    font-weight: 600;
    font-size: 20px;
    line-height: 28px;
    letter-spacing: -0.1px;
}

.calendar_admin_details_lesson_information_time {
    color: var(--color-text-secondary);
    font-family: 'Poppins', sans-serif;
    font-weight: 400;
    font-size: 16px;
    line-height: 24px;
}

.calendar_admin_details_lesson_information_divider {
    border: none;
    height: 1px;
    background-color: var(--color-border-light);
    margin: 14px 0 12px;
}

.calendar_admin_details_lesson_information_meta_row {
    display: flex;
    justify-content: space-between;
    align-items: center;
}

.calendar_admin_details_lesson_information_meta {
    color: var(--color-text-primary);
    font-family: 'Poppins', sans-serif;
    font-weight: 500;
    font-size: 12px;
    line-height: 24px;
    margin: 0;
}

.calendar_admin_details_lesson_information_wallet {
    display: flex;
    align-items: center;
    gap: 8px;
    opacity: 0.7;
}

.calendar_admin_details_lesson_information_wallet img {
    width: 24px;
    height: 23px;
}

.calendar_admin_details_lesson_information_lessons {
    color: var(--color-text-primary);
    font-family: 'Poppins', sans-serif;
    font-weight: 500;
    font-size: 12px;
    line-height: 24px;
}

.calendar_admin_details_lesson_information_action_buttons {
    display: flex;
    flex-direction: column;
    gap: 8px;
    margin-top: 21px;
}

.calendar_admin_details_lesson_information_action {
    width: 100%;
    border-radius: 8px;
    padding: 12px 24px;
    font-family: 'Poppins', sans-serif;
    font-weight: 600;
    font-size: 16px;
    line-height: 1.6;
    cursor: pointer;
    text-align: center;
    background-color: transparent;
    border: 2px solid var(--color-border-medium);
    color: var(--color-text-primary);
}

.calendar_admin_details_lesson_information_action:hover {
    box-shadow: 0 6px 18px rgba(0, 0, 0, .06);
}

.calendar_admin_details_lesson_information_danger {
    width: 100%;
    border-radius: 8px;
    padding: 12px 24px;
    font-family: 'Poppins', sans-serif;
    font-weight: 600;
    font-size: 16px;
    line-height: 1.6;
    cursor: pointer;
    text-align: center;
    background-color: var(--color-danger-bg);
    border: 2px solid var(--color-danger-border);
    color: var(--color-text-white);
}

/* ===== Right Drawer (Chat) ===== */
.calendar_admin_details_lesson_information_drawer {
    position: absolute;
    right: 18px;
    top: 18px;
    bottom: 18px;
    width: 540px;
    max-width: calc(100% - 36px);
    background: #fff;
    border: 1px solid #e9e9f0;
    border-radius: 12px;
    box-shadow: 0 20px 50px rgba(0, 0, 0, .12);
    display: flex;
    flex-direction: column;
    transform: translateX(30px);
    opacity: 0;
    pointer-events: none;
    transition: transform .18s ease, opacity .18s ease;
}

.calendar_admin_details_lesson_information_drawer_header {
    display: flex;
    align-items: center;
    justify-content: space-between;
    padding: 16px 18px;
    border-bottom: 1px solid #f0f0f4;
}

.calendar_admin_details_lesson_information_drawer_titlewrap {
    display: flex;
    align-items: center;
    gap: 10px;
}

.calendar_admin_details_lesson_information_header_avatar {
    width: 32px;
    height: 32px;
    border-radius: 50%;
    background: #111;
    display: flex;
    align-items: center;
    justify-content: center;
    color: #fff;
}

.calendar_admin_details_lesson_information_drawer_title {
    font-weight: 800;
    font-size: 1.25rem;
    text-decoration: underline;
    color: #111;
}

.calendar_admin_details_lesson_information_drawer_close {
    background: transparent;
    border: 0;
    width: 36px;
    height: 36px;
    border-radius: 8px;
    display: grid;
    place-items: center;
    cursor: pointer;
}

.calendar_admin_details_lesson_information_drawer_body {
    padding: 14px 18px;
    overflow: auto;
    flex: 1;
}

.calendar_admin_details_lesson_information_chat_stamp {
    display: inline-block;
    background: #eef1f6;
    color: #555;
    font-weight: 700;
    padding: 6px 12px;
    border-radius: 9px;
    margin: 8px auto 14px;
    text-align: center;
}

.calendar_admin_details_lesson_information_msg {
    display: flex;
    gap: 10px;
    margin-bottom: 18px;
    align-items: flex-start;
}

.calendar_admin_details_lesson_information_msg img {
    width: 36px;
    height: 36px;
    border-radius: 50%;
    object-fit: cover;
}

.calendar_admin_details_lesson_information_msg.self .calendar_admin_details_lesson_information_avatar_circle {
    width: 36px;
    height: 36px;
    border-radius: 50%;
    background: #9aa3b2;
    display: flex;
    align-items: center;
    justify-content: center;
}

.calendar_admin_details_lesson_information_msg_content {
    max-width: 100%;
}

.calendar_admin_details_lesson_information_msg_head {
    color: #2b2b2b;
    margin-bottom: 4px;
}

.calendar_admin_details_lesson_information_msg_head span {
    color: #9aa0a6;
    font-weight: 700;
    margin-left: 6px;
}

.calendar_admin_details_lesson_information_msg_text {
    color: #222;
    line-height: 1.45;
}

.calendar_admin_details_lesson_information_drawer_footer {
    border-top: 1px solid #f0f0f4;
    padding: 12px;
    background: #fff;
    padding-bottom: calc(12px + env(safe-area-inset-bottom));
}

.calendar_admin_details_lesson_information_composerPanel {
    background: #fff;
    border: 1px solid #dfe2ea;
    border-radius: 16px;
    padding: 10px;
    box-shadow: 0 2px 10px rgba(20, 20, 20, .03);
}

.calendar_admin_details_lesson_information_textarea {
    width: 100%;
    border: 1px solid #e1e3eb;
    background: #fff;
    color: #111;
    outline: none;
    resize: none;
    border-radius: 12px;
    padding: 12px 14px;
    min-height: 100px;
    max-height: 160px;
    line-height: 1.35;
}

.calendar_admin_details_lesson_information_textarea::placeholder {
    color: #b2b6c3;
}

.calendar_admin_details_lesson_information_composerActions {
    display: flex;
    align-items: center;
    gap: 8px;
    margin-top: 10px;
}

.calendar_admin_details_lesson_information_actions_left {
    display: flex;
    align-items: center;
    gap: 8px;
}

.calendar_admin_details_lesson_information_actions_right {
    margin-left: auto;
    display: flex;
    align-items: center;
    gap: 8px;
}

.calendar_admin_details_lesson_information_icon {
    background: #fff;
    border: 1px solid #e1e3eb;
    width: 38px;
    height: 38px;
    border-radius: 10px;
    display: grid;
    place-items: center;
    cursor: pointer;
}

.calendar_admin_details_lesson_information_icon:hover {
    background: #f7f8fb;
}

/* ===== Cancel Modal (snapshot-accurate overrides) ===== */
.calendar_admin_cancel_modal {
    width: 100%;
    max-width: 480px;
    background: #fff;
    border: 1px solid #e9e9f0;
    border-radius: 8px;
    overflow: hidden;
    box-shadow: 0 20px 50px rgba(0, 0, 0, .12);
    display: none;
}

.calendar_admin_cancel_header {
    display: flex;
    align-items: center;
    justify-content: space-between;
    gap: 8px;
    padding: 14px 10px;

}

.calendar_admin_cancel_back,
.calendar_admin_cancel_close {
    background: transparent;
    border: 0;
    width: 38px;
    height: 38px;
    border-radius: 8px;
    display: grid;
    place-items: center;
    cursor: pointer;
}

.calendar_admin_cancel_title {
    font-weight: 700;
    font-size: 2rem;
    line-height: 1.15;
    color: #111;
    text-align: left;
    flex: 1;

}

.calendar_admin_cancel_body {
    padding: 0px 24px 20px;
}

.calendar_admin_cancel_note {
    color: #20242c;
    font-size: 1rem;
    line-height: 1.6;
    margin-bottom: 18px;
}

.calendar_admin_cancel_body .form-label {
    color: #232323;
    margin-bottom: 8px;
    font-size: 14px;
}

.calendar_admin_cancel_selectwrap {
    position: relative;
}

.calendar_admin_cancel_selectwrap .form-select {
    height: 58px;
    border-radius: 12px;
    border: 1.6px solid #e1e3eb;
    padding: 14px 44px 14px 16px;
    font-size: 1.05rem;
    line-height: 1.2;
    background: #fff;
}

.calendar_admin_cancel_select_icon {
    position: absolute;
    right: 14px;
    top: 50%;
    transform: translateY(-50%);
    pointer-events: none;
    color: #222;
    font-weight: 700;
    font-size: 30px;
}

.calendar_admin_cancel_textarea {
    min-height: 66px;
    border-radius: 8px !important;
    border: 1.6px solid #e1e3eb;
    padding: 14px 16px;
    font-size: 1.02rem;
    box-shadow: none !important;
}

.calendar_admin_cancel_textarea:hover {
    border: 1.6px solid #232323;
}

.form-check .form-check-input {
    width: 22px;
    height: 22px;
    margin-top: 2px;

    /* remove default browser styling */
    appearance: none;
    -webkit-appearance: none;
    -moz-appearance: none;

    /* custom look */
    background-color: transparent;
    border: 1px solid #232323;
    /* choose a color */
    border-radius: 6px;
    /* adjust radius */
    cursor: pointer;
}

/* checked state */
.form-check-input:checked {
    background-color: #232323;
    /* fill color when checked */
    border-color: #232323;
}

/* optional: checkmark */
.form-check-input:checked::after {
    content: "✔";
    color: white;
    font-size: 16px;
    position: relative;
    left: 2px;
    top: -1px;
}

.form-check .form-check_input {
    width: 22px;
    height: 22px;
    margin-top: 2px;
}

/* keep both (no removal) */
.form-check .form-check-label {
    margin-left: 6px;
    line-height: 1.45;
    color: #232323;

    font-size: 14px;
}

.calendar_admin_cancel_resched {

    border-radius: 8px;
    border: 1.8px solid #e7e7ef;
    font-weight: 800;
    font-size: 1.05rem;
    background: #ffffff;
    color: #121117;
    padding: 12px 16px;
}

.calendar_admin_cancel_resched:hover {
    box-shadow: 0 6px 18px rgba(0, 0, 0, .06);
}

.calendar_admin_cancel_confirm {
    padding: 12px 16px;
    border-radius: 8px;
    font-weight: 900;
    font-size: 1.08rem;
    letter-spacing: .2px;
    background: #ef2d17;
    color: #fff;
    border: 0;
    padding: 12px 16px;
    box-shadow: 0 10px 26px rgba(239, 45, 23, .25);
}

/* ===== Reschedule Modal (STEP 2) ===== */
.calendar_admin_reschedule_modal {
    display: none;
    justify-content: center;
    align-items: flex-start;
    max-width: 500px;
    width: 100%;
}

.calendar_admin_reschedule_modal_inner {
    background-color: #ffffff;
    border: 1px solid #f4f4f8;
    border-radius: 8px;
    box-shadow: 0px 8px 32px 0px rgba(18, 17, 23, 0.15), 0px 16px 48px 0px rgba(18, 17, 23, 0.15);
    max-width: 500px;
    width: 100%;
    padding: 24px;
    display: flex;
    flex-direction: column;
}

.calendar_admin_reschedule_header {
    display: flex;
    justify-content: space-between;
    align-items: center;

}

.calendar_admin_reschedule_title {
    color: #121117;
    font-family: 'Poppins', sans-serif;
    font-weight: 600;
    font-size: 27.875px;
    line-height: 41.8125px;
    margin: 0;
}

.calendar_admin_reschedule_close {
    background: none;
    border: none;
    padding: 8px;
    cursor: pointer;
    line-height: 0;
}

.calendar_admin_reschedule_confirm_back {
    background: none;
    border: none;
    padding: 8px;
    cursor: pointer;
    line-height: 0;
}

.calendar_admin_reschedule_body {
    display: flex;
    flex-direction: column;
    gap: 18px;
}

.calendar_admin_reschedule_body_sub {
    display: flex;
    flex-direction: column;

}

.calendar_admin_reschedule_label {
    color: #121117;
    font-family: 'Poppins', sans-serif;
    font-weight: 400;
    font-size: 16px;
    line-height: 24px;
    margin-bottom: 6px;
}

.calendar_admin_details_lesson_information_card {
    border: 1px solid #dcdce5;
    border-radius: 8px;
    padding: 17px;
}

.calendar_admin_details_lesson_information_row {
    display: flex;
    align-items: center;
    gap: 16px;
}

.calendar_admin_details_lesson_information_header_avatar {
    width: 48px;
    height: 48px;
    background-color: #f4f4f8;
    border: 1px solid rgba(18, 17, 23, 0.06);
    border-radius: 4px;
    display: flex;
    justify-content: center;
    align-items: center;
    flex-shrink: 0;
}

.calendar_admin_details_lesson_information_main {
    display: flex;
    flex-direction: column;
}

.calendar_admin_details_lesson_information_day {
    color: #121117;
    font-family: 'Poppins', sans-serif;
    font-weight: 600;
    font-size: 20px;
    line-height: 28px;
    margin: 0;
}

.calendar_admin_details_lesson_information_time {
    color: #4d4c5c;
    font-family: 'Poppins', sans-serif;
    font-weight: 400;
    font-size: 16px;
    line-height: 24px;
    margin: 0;
}

.calendar_admin_details_lesson_information_divider {
    height: 1px;
    background-color: #dcdce5;
    border: none;
    margin: 14px 0;
}

.calendar_admin_details_lesson_information_meta_row {
    display: flex;
    justify-content: space-between;
    align-items: center;
}

.calendar_admin_details_lesson_information_meta,
.calendar_admin_details_lesson_information_wallet span {
    color: #121117;
    font-family: 'Poppins', sans-serif;
    font-weight: 500;
    font-size: 12px;
    line-height: 24px;
    margin: 0;
}

.calendar_admin_details_lesson_information_wallet {
    display: flex;
    align-items: center;
    gap: 8px;
    opacity: 0.7;
}

.calendar_admin_reschedule_form {
    display: flex;
    flex-direction: column;
}

.calendar_admin_reschedule_form_group {
    border: none;
    padding: 0;
    margin: 0;
    display: flex;
    flex-direction: column;
    gap: 12px;
}

.calendar_admin_reschedule_label_form {
    color: #000000;
    font-weight: 500;
    font-size: 12px;
    line-height: 18px;

}

.calendar_admin_reschedule_select_control {
    display: flex;
    justify-content: space-between;
    align-items: center;
    border: 2px solid rgba(0, 0, 0, 0.12);
    border-radius: 8.93px;
    padding: 0 12px;
    height: 60px;
    cursor: pointer;
    flex-grow: 1;
}

.calendar_admin_reschedule_select_control_full_width {
    width: 100%;
}

.ca_dd_wrap.calendar_admin_reschedule_select_control .ca_dd_btn {
    width: 100%;
    height: 100%;
    border: none;
    background: transparent;
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 0;
    outline: none;
}

.ca_dd_wrap.calendar_admin_reschedule_select_control .ca_dd_btn span {
    color: #000000;
    font-family: 'Poppins', sans-serif;
    font-weight: 500;
    font-size: 14px;
    line-height: 21px;
}

.ca_res_selectwrap {
    position: relative;
    width: 100%;
}

.ca_res_selectwrap.calendar_admin_reschedule_select_control {
    display: flex;
    justify-content: space-between;
    align-items: center;
    border: 2px solid rgba(0, 0, 0, 0.12);
    border-radius: 8.93px;
    padding: 0 12px;
    height: 60px;
    cursor: pointer;
}

.ca_res_selectwrap .form-select {
    width: 100%;
    border: none;
    padding: 0;
    font-family: 'Poppins', sans-serif;
    font-weight: 500;
    font-size: 14px;
    line-height: 21px;
    color: #000000;
    background: transparent;
    cursor: pointer;
    display: flex;
    justify-content: space-between;
    align-items: center;
}

.ca_res_selectwrap.calendar_admin_reschedule_select_control .form-select {
    height: 100%;
    outline: none;
}

.ca_res_selectwrap:not(.calendar_admin_reschedule_select_control) .form-select {
    border: 2px solid rgba(0, 0, 0, 0.12);
    border-radius: 8px;
    padding: 14px 16px;
    height: 60px;
}

.ca_res_select_icon {
    position: static;
    pointer-events: none;
    color: #222;
    font-weight: 700;
    font-size: 30px;
    margin-left: 8px;
}

.ca_res_selectwrap:not(.calendar_admin_reschedule_select_control) .ca_res_select_icon {
    position: absolute;
    right: 14px;
    top: 50%;
    transform: translateY(-50%);
}

.ca_res_row,
.calendar_admin_reschedule_form_row {
    display: flex;
    gap: 12px;
}

.ca_res_col {
    flex: 1 1 0;
}

/* Custom Time Picker Styles for Reschedule Modal */
.resched-custom-time-pill {
    position: relative;
    width: 100%;
}

.resched-time-input {
    width: 100%;
    min-height: auto !important;
    padding: 0 12px !important;
    border: 1px solid #ddd;
    border-radius: 10px !important;
    font-size: 14px;
    cursor: pointer;
    background-color: #ffffff !important;
    margin: 0 !important;
    box-shadow: none !important;

}

.resched-time-input:focus {
    outline: none;
    border-color: #666;
    box-shadow: 0 0 0 2px rgba(0, 0, 0, 0.1);
}

.resched-custom-time-dropdown {
    position: absolute;
    top: 55px;
    left: 0;
    right: 0;
    background: #fff;
    border: 1px solid #ddd;
    border-radius: 8px;
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
    max-height: 300px;
    overflow-y: auto;
    z-index: 10000;
}

.resched-dropdown-item {
    padding: 10px 12px;
    cursor: pointer;
    font-size: 14px;
    color: #333;
    transition: background-color 0.15s ease;
}

.resched-dropdown-item:hover {
    background-color: #f5f5f5;
}

.resched-dropdown-item.active {
    background-color: #e8f0fe;
    color: #1f2937;
    font-weight: 500;
}

/* Custom Date Display for Reschedule Modal */
.resched-date-dropdown-display {
    position: relative;
    transition: all 0.15s ease;
}

.resched-date-dropdown-display:hover {
    border-color: #999;
    box-shadow: 0 2px 8px rgba(0, 0, 0, 0.08);
}

.resched-date-dropdown-display:active {
    transform: scale(0.99);
}

.calendar_admin_reschedule_hint,
.calendar_admin_reschedule_info_banner {
    display: flex;
    align-items: center;
    gap: 8px;
}

.calendar_admin_reschedule_hint p,
.calendar_admin_reschedule_info_banner p {
    color: #4d4c5c;
    font-family: 'Figtree', sans-serif;
    font-weight: 400;
    font-size: 16px;
    line-height: 24px;
    margin: 0;
}

.calendar_admin_reschedule_footer {
    margin-top: 24px;
}

.calendar_admin_reschedule_continue {
    width: 100%;
    background-color: #ff2500;
    border: 2px solid #121117;
    border-radius: 8px;
    padding: 11px 20px;
    color: #ffffff;
    font-family: 'Poppins', sans-serif;
    font-weight: 600;
    font-size: 18px;
    line-height: 26px;
    cursor: pointer;
    text-align: center;
}

@media (max-width: 480px) {

    .ca_res_row,
    .calendar_admin_reschedule_form_row {
        flex-direction: column;
    }

    .calendar_admin_reschedule_title {
        font-size: 24px;
    }
}

/* ===== Reschedule Modal (STEP 3 — Confirm) ===== */
.calendar_admin_reschedule_confirm_modal {
    background-color: #ffffff;
    border: 1px solid #f4f4f8;
    border-radius: 8px;
    box-shadow: 0px 8px 32px 0px rgba(18, 17, 23, 0.15), 0px 16px 48px 0px rgba(18, 17, 23, 0.15);
    max-width: 500px;
    width: 100%;
    padding: 24px;
    display: none;
    flex-direction: column;
}

.ca_res_chip {
    display: inline-block;
    background: #DCDCE5;
    color: #232323;
    font-weight: 800;
    padding: 6px 12px;
    border-radius: 8px;
    margin-bottom: 10px;
    width: max-content;
}

.calendar_admin_lite_card {
    border: 1px solid #ececf3;
    border-radius: 12px;
    background: #f7f8fb;
    padding: 14px;
}

.calendar_admin_lite_row {
    display: flex;
    align-items: center;
    gap: 12px;
}

.calendar_admin_lite_avatar {
    width: 48px;
    height: 48px;
    border-radius: 10px;
    background: #111;
    display: flex;
    align-items: center;
    justify-content: center;
    color: #fff;
}

.calendar_admin_lite_day {
    font-weight: 800;
    font-size: 1.22rem;
    color: #111;
    line-height: 1.1;
}

.calendar_admin_lite_time {
    color: #6b7280;
    font-weight: 700;
    margin-top: 2px;
    line-height: 1.1;
}

.calendar_admin_lite_divider {
    margin: 12px 0;
    border: 0;
    height: 1px;
    background: #e6e8f2;
}

.calendar_admin_lite_meta_row {
    display: flex;
    align-items: center;
    justify-content: space-between;
    gap: 10px;
    flex-wrap: wrap;
}

.calendar_admin_lite_meta {
    color: #2f323a;
    font-weight: 600;
}

.ca_res_confirm {

    width: 100%;
    background-color: #ff2500;
    border: 2px solid #121117;
    border-radius: 8px;
    padding: 11px 20px;
    color: #ffffff;
    font-family: 'Poppins', sans-serif;
    font-weight: 600;
    font-size: 18px;
    line-height: 26px;
    cursor: pointer;
    text-align: center;
}

/* ===== States ===== */
#calendar_admin_details_lesson_information_backdrop.calendar_admin_details_lesson_information_scope.is-open {
    display: flex;
}

.calendar_admin_details_lesson_information_drawer.is-open {
    transform: translateX(0);
    opacity: 1;
    pointer-events: auto;
}

/* ===== Responsive ===== */
@media (max-width: 992px) {
    .calendar_admin_details_lesson_information_drawer {
        right: 10px;
        left: 10px;
        width: auto;
        max-width: none;
    }
}

@media (max-width: 560px) {
    .ca_res_row {
        flex-direction: column;
    }
}

@media (max-width: 430px) {
    .calendar_admin_details_lesson_information_title {
        font-size: 1.45rem;
    }

    .calendar_admin_details_lesson_information_day {
        font-size: 1.11rem;
    }

    .calendar_admin_details_lesson_information_avatar {
        width: 44px;
        height: 44px;
        border-radius: 9px;
    }

    .calendar_admin_cancel_title,
    .calendar_admin_reschedule_title {
        font-size: 1.55rem;
    }
}








/* Hide native caret for our wrapped selects (keep the custom ▾ span) */
.calendar_admin_cancel_selectwrap .form-select,
.ca_res_selectwrap .form-select {
    -webkit-appearance: none !important;
    -moz-appearance: none !important;
    appearance: none !important;
    background-image: none !important;
    /* overrides Bootstrap's built-in arrow */
    /* keep the padding you already set to reserve space for the custom icon */
}

/* Old IE/Edge */
.calendar_admin_cancel_selectwrap .form-select::-ms-expand,
.ca_res_selectwrap .form-select::-ms-expand {
    display: none;
}















/* === Custom dropdown (snapshot style) === */
.ca_dd_wrap {
    position: relative;
}

.ca_dd_btn {
    width: 100%;

    background: #fff;
    border: 1.6px solid #e1e3eb;
    border-radius: 8px;
    display: flex;
    align-items: center;
    justify-content: space-between;
    padding: 14px 12px;
    font-size: 1.05rem;
    line-height: 1.2;
    font-weight: 600;

}

.ca_dd_btn:hover {
    border: 1.6px solid #232323;
}

.ca_dd_btn:focus {
    outline: 2px solid #e9e9f5;
    outline-offset: 2px;
}

.ca_dd_placeholder {
    color: #9aa3b2;
}

.ca_dd_value {
    color: #232323;
    font-weight: 700;
}

.ca_dd_caret {
    margin-left: 12px;
    font-size: 22px;
    color: #222;
    line-height: 1;
}

.ca_dd_menu {
    position: absolute;
    left: 0;
    right: 0;
    top: 100%;
    margin-top: 10px;
    background: #fff;
    border-radius: 14px;
    border: 1px solid #ececf3;
    box-shadow: 0 20px 40px rgba(0, 0, 0, .18);
    padding: 12px 0;
    display: none;
    z-index: 6000;
    /* above modal content */
    max-height: 320px;
    overflow: auto;
}

.ca_dd_opt {
    padding: 16px 18px;
    font-size: 1.02rem;
    line-height: 1.5;
    color: #232323;
    font-weight: 700;
    cursor: pointer;
}

.ca_dd_opt:hover,
.ca_dd_opt[aria-selected="true"] {
    background: #f7f8fb;
}

/* ===== Reschedule Calendar Modal ===== */
.calendar_admin_details_create_cohort_calendar_modal_backdrop {
    display: none;
    position: fixed;
    z-index: 9999;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background: rgba(0, 0, 0, 0.14);
}

.calendar_admin_details_create_cohort_calendar_modal {
    background: #fff;
    border-radius: 15px;
    box-shadow: 0 10px 36px 0 rgba(0, 0, 0, .16);
    max-width: 300px;
    padding: 26px 24px 24px 24px;
    position: absolute;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%);
}

.calendar_admin_details_create_cohort_calendar_nav {
    display: flex;
    align-items: center;
    justify-content: space-between;
    font-size: 1.18rem;
    font-weight: 600;
    margin-bottom: 10px;
}

.calendar_admin_details_create_cohort_calendar_nav button {
    background: none;
    border: none;
    font-size: 1.4rem;
    cursor: pointer;
    padding: 0;
    display: flex;
    align-items: center;
    justify-content: center;
}

.calendar_admin_details_create_cohort_calendar_nav button:hover {
    opacity: 0.7;
}

.calendar_admin_details_create_cohort_calendar_days {
    display: grid;
    grid-template-columns: repeat(7, 1fr);
    gap: 6px;
    text-align: center;
    font-size: 1.07rem;
    margin-bottom: 10px;
    justify-items: center;
}

.calendar_admin_details_create_cohort_calendar_day_header {
    color: #b2b2b2;
    font-weight: 600;
    padding: 7px 0 4px 0;
    width: 36px;
    height: 36px;
    display: flex;
    align-items: center;
    justify-content: center;
}

.calendar_admin_details_create_cohort_calendar_day_res,
.calendar_admin_details_create_cohort_calendar_day_inactive {
    width: 36px;
    height: 36px;
    display: flex;
    align-items: center;
    justify-content: center;
    border-radius: 50%;
    cursor: pointer;
    font-size: 1.11rem;
    font-weight: 500;
    transition: background .15s, color .15s;
    background: #fff;
}

.calendar_admin_details_create_cohort_calendar_day_inactive {
    color: #bdbdbd;
    background: #fff;
    cursor: not-allowed;
}

.calendar_admin_details_create_cohort_calendar_day_res.selected,
.calendar_admin_details_create_cohort_calendar_day_res:hover {
    background: #fe2e0c;
    color: #fff;
    font-weight: 700;
}

.calendar_admin_details_create_cohort_calendar_done_btn {
    width: 100%;
    background: #fe2e0c;
    color: #fff;
    font-weight: bold;
    border: none;
    border-radius: 8px;
    padding: 12px 0;
    margin-top: 19px;
    font-size: 1.12rem;
    cursor: pointer;
    box-shadow: 0 3px 11px 0 rgba(254, 46, 12, .07);
}

@media (max-width: 600px) {
    .calendar_admin_details_create_cohort_calendar_modal {
        width: 96vw;
        padding: 13px 1vw;
    }
}
</style>

<script>
// Pre-declare the functions to make them available globally
let openLessonInfo;
let populateModalWithEventData;
let closeAll;

(function($) {
    const $backdrop = $('#calendar_admin_details_lesson_information_backdrop');
    const $modal = $backdrop.find('.calendar_admin_details_lesson_information_modal');
    const $drawer = $backdrop.find('.calendar_admin_details_lesson_information_drawer');
    const $cancel = $backdrop.find('.calendar_admin_cancel_modal');
    const $resched = $backdrop.find('.calendar_admin_reschedule_modal'); // step 2
    const $res3 = $backdrop.find('.calendar_admin_reschedule_confirm_modal'); // step 3
    const $toast = $('#calendar_admin_toast');

    function openBackdrop() {
        $backdrop.addClass('is-open').hide().fadeIn(100);
        $('body').css('overflow', 'hidden');
    }

    function closeAll() {
        $drawer.removeClass('is-open');
        $backdrop.fadeOut(100, function() {
            $backdrop.removeClass('is-open');
        });
        $('body').css('overflow', '');
        $modal.show();
        $cancel.hide();
        $resched.hide();
        $res3.hide();
    }

    function openLessonInfo() {
        openBackdrop();
        $modal.show();
        $cancel.hide();
        $resched.hide();
        $res3.hide();
    }

    function openChatDrawer() {
        if (!$backdrop.hasClass('is-open')) openBackdrop();
        $drawer.addClass('is-open');
        setTimeout(() => $('.calendar_admin_details_lesson_information_textarea').trigger('focus'), 120);
    }

    function openCancelModal() {
        if (!$backdrop.hasClass('is-open')) openBackdrop();
        $modal.hide();
        $resched.hide();
        $res3.hide();
        $cancel.show();
    }

    function openRescheduleModal() {
        if (!$backdrop.hasClass('is-open')) openBackdrop();
        $modal.hide();
        $cancel.hide();
        $res3.hide();
        $resched.show();
    }

    function openRescheduleConfirm() {
        // copy values from Step 2 to Step 3 card
        const dateStr = $('#resched_date').val();
        const timeStr = $('#resched_time').val();
        const endStr = computeEndTime(timeStr, $('#resched_duration').val());
        $('#res3_day').text(toPrettyDay(dateStr));
        $('#res3_time').text(to24(timeStr) + ' – ' + to24(endStr));
        if (!$backdrop.hasClass('is-open')) openBackdrop();
        $modal.hide();
        $cancel.hide();
        $resched.hide();
        $res3.show();
    }

    // Utilities to format times
    function parseDurationMins(label) {
        const m = (label || '').match(/(\d+)\s*Minutes/i);
        return m ? parseInt(m[1], 10) : 50;
    }

    function toMinutes(t) { // "1:30 AM" -> minutes from midnight
        if (!t) return 0;
        const m = String(t).match(/^(\d{1,2}):(\d{2})\s*(AM|PM)$/i);
        if (!m) return 0;
        let h = parseInt(m[1], 10) % 12;
        const min = parseInt(m[2], 10);
        const pm = m[3].toUpperCase() === 'PM';
        if (pm) h += 12;
        return h * 60 + min;
    }

    function minutesTo12(mins) {
        mins = ((mins % 1440) + 1440) % 1440;
        let h = Math.floor(mins / 60),
            m = mins % 60;
        const ampm = h >= 12 ? 'PM' : 'AM';
        h = h % 12;
        if (h === 0) h = 12;
        return h + ':' + String(m).padStart(2, '0') + ' ' + ampm;
    }

    function to24(t) { // "1:30 PM" -> "01:30 PM" like your snapshot uses leading zero for hour <10?
        if (!t) return '';
        const m = String(t).match(/^(\d{1,2}):(\d{2})\s*(AM|PM)$/i);
        if (!m) return String(t);
        let h = parseInt(m[1], 10);
        return (h < 10 ? ('0' + h) : h) + ':' + m[2] + ' ' + m[3].toUpperCase();
    }

    function computeEndTime(startStr, durationLabel) {
        const start = toMinutes(startStr);
        const dur = parseDurationMins(durationLabel);
        return minutesTo12(start + dur);
    }

    function toPrettyDay(raw) { // "Tue, Feb11" -> "Tue, Feb11" (simple passthrough)
        return raw || '';
    }

    // Toast helpers
    let toastTimer = null;

    function showToast(line2, line3, title = 'Lesson Rescheduled') {
        $('#calendar_admin_toast_line2').text(line2 || '');
        $('#calendar_admin_toast_line3').text(line3 || '');
        $toast.stop(true, true).fadeIn(140);
        clearTimeout(toastTimer);
        toastTimer = setTimeout(hideToast, 4500);
    }

    function hideToast() {
        $toast.fadeOut(180);
        clearTimeout(toastTimer);
        toastTimer = null;
    }
    $('.calendar_admin_toast_close').on('click', hideToast);

    // Store current event data
    let currentEventData = null;

    // Helper function to format date for display
    function formatEventDate(dateStr) {
        const date = new Date(dateStr);
        const days = ['Sunday', 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday'];
        const months = ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'];
        return `${days[date.getDay()]} , ${months[date.getMonth()]} ${String(date.getDate()).padStart(2, '0')}`;
    }

    // Helper function to format time from HH:MM to 12-hour format
    function formatTime(timeStr) {
        if (!timeStr) return '';
        const [hours, minutes] = timeStr.split(':').map(Number);
        const ampm = hours >= 12 ? 'PM' : 'AM';
        const displayHours = hours % 12 || 12;
        return `${String(displayHours).padStart(2, '0')}:${String(minutes).padStart(2, '0')} ${ampm}`;
    }

    // Function to populate modal with event data
    function populateModalWithEventData(eventData) {
        currentEventData = eventData;

        // Update date
        $('.calendar_admin_details_lesson_information_day').text(formatEventDate(eventData.date));

        // Update time
        const startTime = formatTime(eventData.start);
        const endTime = formatTime(eventData.end);
        $('.calendar_admin_details_lesson_information_time').text(`${startTime} - ${endTime}`);

        // Update student name
        if (eventData.studentnames && eventData.studentnames.length > 0) {
            const studentName = eventData.studentnames[0];
            $('.calendar_admin_details_lesson_information_meta').text(`${studentName} | Subscription`);
        } else if (eventData.title) {
            $('.calendar_admin_details_lesson_information_meta').text(eventData.title);
        }

        // Update avatar
        if (eventData.avatar) {
            $('.calendar_admin_details_lesson_information_avatar').attr('src', eventData.avatar);
        }

        // Fetch and update lesson count if student ID is available
        if (eventData.studentids && eventData.studentids.length > 0) {
            const studentId = eventData.studentids[0];
            // Try to get lesson count from student data (if available in window)
            if (typeof window.studentLessonCounts !== 'undefined' && window.studentLessonCounts[studentId]) {
                $('.calendar_admin_details_lesson_information_lessons').text(window.studentLessonCounts[studentId] +
                    ' lessons');
            } else {
                // Fetch lesson count via AJAX
                fetchStudentLessonCount(studentId);
            }
        } else {
            // Default fallback
            $('.calendar_admin_details_lesson_information_lessons').text('3 lessons');
        }
    }

    // Function to fetch student lesson count
    function fetchStudentLessonCount(studentId) {
        $.ajax({
            url: 'ajax/calendar_admin_filters.php',
            method: 'GET',
            data: {
                action: 'student_lesson_count',
                studentid: studentId
            },
            success: function(response) {
                if (response && response.count !== undefined) {
                    $('.calendar_admin_details_lesson_information_lessons').text(response.count +
                        ' lessons');
                    // Store in cache
                    if (typeof window.studentLessonCounts === 'undefined') {
                        window.studentLessonCounts = {};
                    }
                    window.studentLessonCounts[studentId] = response.count;
                } else {
                    $('.calendar_admin_details_lesson_information_lessons').text('3 lessons');
                }
            },
            error: function() {
                // Default fallback
                $('.calendar_admin_details_lesson_information_lessons').text('3 lessons');
            }
        });
    }

    // Openers
    //$('.calendar_admin_details_lesson_information_btn').on('click', openLessonInfo);

    // ===== Custom Time Picker for Reschedule Modal =====
    const $reschedTimeInput = $('.resched-time-input');
    const $reschedTimeDropdown = $('.resched-custom-time-dropdown');
    const $reschedDropdownItems = $('.resched-dropdown-item');

    // Toggle dropdown on input click
    $reschedTimeInput.on('click', function() {
        $reschedTimeDropdown.toggle();

        // Highlight current selection
        const currentValue = $reschedTimeInput.val();
        $reschedDropdownItems.removeClass('active').each(function() {
            if ($(this).text() === currentValue) {
                $(this).addClass('active');
                // Scroll to active item
                $reschedTimeDropdown.scrollTop($(this).offset().top - $reschedTimeDropdown.offset()
                    .top - 100);
            }
        });
    });

    // Handle dropdown item click
    $reschedDropdownItems.on('click', function() {
        const selectedTime = $(this).text();
        $reschedTimeInput.val(selectedTime);

        // Update the hidden resched_time input for backward compatibility
        $('#resched_time').val(selectedTime);

        // Hide dropdown
        $reschedTimeDropdown.hide();

        // Update active state
        $reschedDropdownItems.removeClass('active');
        $(this).addClass('active');
    });

    // Close dropdown when clicking outside
    $(document).on('click', function(e) {
        if (!$(e.target).closest('.resched-custom-time-pill').length) {
            $reschedTimeDropdown.hide();
        }
    });

    // Update date display when date is selected in the calendar
    $(document).on('change', '#resched_date', function() {
        const selectedDate = $(this).val();
        if (selectedDate) {
            $('#reschedDateText').text(selectedDate);
        }
    });

    $(document).on('click', '.event.e-green', function(e) {
        e.preventDefault();
        e.stopPropagation();

        const $event = $(this);
        console.log('Event clicked:', $event);

        // Extract event data from data attributes
        const studentIds = $event.data('student-ids') ? String($event.data('student-ids')).split(',') : [];
        const studentNames = $event.data('student-names') ? String($event.data('student-names')).split(
            ',') : [];
        const cohortIds = $event.data('cohort-ids') ? String($event.data('cohort-ids')).split(',').map(id =>
            parseInt(id)) : [];
        const avatar = $event.data('avatar') || 'https://randomuser.me/api/portraits/men/32.jpg';

        const eventData = {
            date: $event.data('date') || new Date().toISOString().split('T')[0],
            start: String($event.data('start') || '540').padStart(4, '0'), // minutes from midnight
            end: String($event.data('end') || '600').padStart(4, '0'),
            title: $event.data('title') || '',
            teacherId: $event.data('teacher-id') || '',
            studentids: studentIds,
            studentnames: studentNames,
            cohortids: cohortIds,
            avatar: avatar,
            eventid: $event.data('event-id') || '',
            cmid: $event.data('cm-id') || '',
            googlemeetid: $event.data('googlemeet-id') || $event.data('cm-id') || '',
            classType: $event.data('class-type') || '',
            repeat: $event.data('repeat') || false
        };

        console.log('Event data extracted:', eventData);

        // Convert minutes to HH:MM format
        function minutesToTime(mins) {
            const hours = Math.floor(mins / 60);
            const minutes = mins % 60;
            return `${String(hours).padStart(2, '0')}:${String(minutes).padStart(2, '0')}`;
        }

        eventData.start = minutesToTime(parseInt(eventData.start));
        eventData.end = minutesToTime(parseInt(eventData.end));

        // Extract student name from the event title element
        const studentName = $event.find('.ev-title').text().trim() || eventData.title;
        if (studentName) {
            eventData.studentnames = [studentName];
        }

        populateModalWithEventData(eventData);
        openLessonInfo();
    });
    $('#calendar_admin_details_lesson_information_open_chat').on('click', openChatDrawer);
    $('#calendar_admin_details_lesson_information_cancel_trigger').on('click', openCancelModal);

    // Cancel modal navigation
    $('.calendar_admin_cancel_back').on('click', function() {
        $cancel.hide();
        $modal.show();
    });
    $('.calendar_admin_cancel_close').on('click', closeAll);

    // Reschedule Step 2 navigation
    $('#calendar_admin_cancel_reschedule_btn').on('click', openRescheduleModal);
    $('.calendar_admin_reschedule_back').on('click', function() {
        $resched.hide();
        $cancel.show();
    });
    $('.calendar_admin_reschedule_close').on('click', closeAll);

    // Step 2 -> Step 3
    $('#calendar_admin_reschedule_continue_btn').on('click', openRescheduleConfirm);

    // Step 3 navigation
    $('.calendar_admin_reschedule_confirm_back').on('click', function() {
        $res3.hide();
        $resched.show();
    });

    // Global backdrop + ESC
    $('.calendar_admin_details_lesson_information_close, .calendar_admin_details_lesson_information_drawer_close')
        .on('click', closeAll);
    $backdrop.on('click', function(e) {
        if (e.target === this) closeAll();
    });
    $modal.on('click', function(e) {
        e.stopPropagation();
    });
    $drawer.on('click', function(e) {
        e.stopPropagation();
    });
    $cancel.on('click', function(e) {
        e.stopPropagation();
    });
    $resched.on('click', function(e) {
        e.stopPropagation();
    });
    $res3.on('click', function(e) {
        e.stopPropagation();
    });
    $(document).on('keyup', function(e) {
        if (e.key === 'Escape') closeAll();
    });

    // Textarea auto-grow (chat)
    const $ta = $('.calendar_admin_details_lesson_information_textarea');

    function autosizeTA(el) {
        el.style.height = 'auto';
        const h = Math.min(el.scrollHeight, 160);
        el.style.height = (h < 52 ? 52 : h) + 'px';
    }
    $ta.each(function() {
        autosizeTA(this);
    });
    $ta.on('input', function() {
        autosizeTA(this);
    });

    // Attach -> hidden file picker
    $('#calendar_admin_details_lesson_information_attach').on('click', function() {
        $('#calendar_admin_details_lesson_information_file').trigger('click');
    });

    // ===== 1_1_CLASS Tab (existing behavior for main "View Or Reschedule Lesson" button) =====
    $('#calendar_admin_details_1_1_class').on('click', function() {
        // Close lesson info modal
        closeAll();

        // Check if we have current event data
        if (!currentEventData) {
            console.error('No event data available');
            return;
        }

        // Store event data globally so other scripts can access it
        window.currentEventData = currentEventData;

        // Open the Create Cohort modal
        $('#calendar_admin_details_create_cohort_modal_backdrop').fadeIn();

        // Switch to the Manage 1:1 Class tab (data-tab="manageclass")
        const $backdrop = $('#calendar_admin_details_create_cohort_modal_backdrop');
        $backdrop.find('.calendar_admin_details_create_cohort_tab').removeClass('active');
        $backdrop.find('.calendar_admin_details_create_cohort_tab[data-tab="manage_class"]').addClass(
            'active');

        // Hide all tab contents
        $('#calendar_admin_details_create_cohort_content').html('');
        $('#mergeTabContent').css('display', 'none');
        $('#conferenceTabContent').css('display', 'none');
        $('#peerTalkTabContent').css('display', 'none');
        $('#addTimeTabContent').css('display', 'none');
        $('#addExtraSlotsTabContent').css('display', 'none');
        $('#mainModalContent').css('display', 'none');


        $('#manageclassTabContent').show();

        console.log('Opening Manage 1:1 Class tab with event data:', currentEventData);

        // Wait for tab to be visible, then populate with event data
        setTimeout(function() {
            scrollToActiveCohortTab();

            populateManage1To1ClassTab(currentEventData);


        }, 300);
    });

    // Function to populate Manage 1:1 Class tab with event data
    function populateManage1To1ClassTab(eventData) {
        if (!eventData) return;

        console.log('Populating Manage 1:1 Class tab with:', eventData);

        // 1. Select Teacher
        if (eventData.teacherId) {
            const teacherItem = document.querySelector(
                `#calendar_admin_details_create_cohort_manage_class_tab_list .calendar_admin_details_create_cohort_manage_class_tab_item[data-userid="${eventData.teacherId}"]`
            );

            if (teacherItem) {
                const teacherName = teacherItem.dataset.name;
                const teacherImg = teacherItem.dataset.img;
                const teacherId = teacherItem.dataset.userid;

                // Update the trigger button
                const imgEl = document.getElementById(
                    'calendar_admin_details_create_cohort_manage_class_tab_current_img');
                const labelEl = document.getElementById(
                    'calendar_admin_details_create_cohort_manage_class_tab_current_label');
                const triggerBtn = document.getElementById(
                    'calendar_admin_details_create_cohort_manage_class_tab_trigger');

                if (imgEl) imgEl.src = teacherImg;
                if (labelEl) labelEl.textContent = teacherName;

                // Update trigger button data attributes
                if (triggerBtn) {
                    triggerBtn.dataset.userid = teacherId;
                    triggerBtn.dataset.name = teacherName;
                    triggerBtn.dataset.img = teacherImg;
                }

                // Remove previous selection
                document.querySelectorAll(
                        '#calendar_admin_details_create_cohort_manage_class_tab_list .calendar_admin_details_create_cohort_manage_class_tab_item[aria-selected="true"]'
                    )
                    .forEach(el => el.removeAttribute('aria-selected'));

                // Mark as selected
                teacherItem.setAttribute('aria-selected', 'true');

                console.log('✅ Selected teacher:', teacherName, '(ID:', teacherId, ')');

                // 2. Load students and select specific student
                if (typeof window.loadStudentsForTeacher === 'function' && eventData.studentids && eventData
                    .studentids.length > 0) {
                    const targetStudentId = eventData.studentids[0];

                    // Load students without auto-selecting the first one
                    window.loadStudentsForTeacher(teacherId, false).then(() => {
                        console.log('Students loaded, now selecting student ID:', targetStudentId);

                        // Wait for DOM to update, then select the specific student
                        setTimeout(() => {
                            const studentItem = document.querySelector(
                                `#one2oneStudentDropdownManage .one2one-student-list-item[data-userid="${targetStudentId}"]`
                            );

                            if (studentItem) {
                                const addStudentBtn = document.getElementById(
                                    'one2oneAddStudentBtnManage');

                                // Remove previous selection
                                document.querySelectorAll(
                                        '#one2oneStudentDropdownManage .one2one-student-list-item')
                                    .forEach(el => el.classList.remove('selected'));

                                // Mark this student as selected
                                studentItem.classList.add('selected');

                                // Update the "Add student" button
                                if (addStudentBtn) {
                                    const avatar = studentItem.querySelector(
                                        '.one2one-student-list-avatar')?.innerHTML || '';
                                    const name = studentItem.dataset.name || studentItem
                                        .querySelector('.one2one-student-list-name')?.textContent ||
                                        'Student';
                                    addStudentBtn.innerHTML = `
                                        <span class="one2one-add-student-icon">${avatar}</span>
                                        <span style="font-weight:600; color:#232323;">${name}</span>
                                    `;
                                    addStudentBtn.classList.add('active');
                                }

                                console.log('✅ Selected student ID:', targetStudentId);

                                // 3. After student selection, proceed with lesson type and lesson selection
                                selectLessonTypeAndLesson(eventData);
                            } else {
                                console.warn('Student item not found for ID:', targetStudentId);
                            }
                        }, 300);
                    }).catch(error => {
                        console.error('Error loading students:', error);
                    });
                } else if (typeof window.loadStudentsForTeacher === 'function') {
                    // No specific student to select, just load students
                    window.loadStudentsForTeacher(teacherId);
                    console.log('Triggered loadStudentsForTeacher for teacherId:', teacherId);
                }
            }
        }
    }

    // Helper function to select lesson type and specific lesson
    function selectLessonTypeAndLesson(eventData) {
        // Determine lesson type based on classType
        let lessonType = 'single';
        if (eventData.classType === 'one2one_weekly') {
            lessonType = 'weekly';
        } else if (eventData.classType === 'one2one_single') {
            lessonType = 'single';
        }

        console.log('Lesson type determined:', lessonType, 'from classType:', eventData.classType);

        // Wait a bit to ensure student selection is fully processed
        setTimeout(() => {
            // Click the appropriate lesson type button in manage tab
            const lessonTypeBtn = document.querySelector(
                `#manageclassTabContent .one2one-lesson-type-btn-manage[data-type="${lessonType}"]`);

            if (lessonTypeBtn) {
                lessonTypeBtn.click();
                console.log('Clicked lesson type button:', lessonType);

                // After clicking lesson type button, wait for lessons to populate, then select specific lesson
                if (eventData.googlemeetid) {
                    setTimeout(function() {
                        if (lessonType === 'weekly') {
                            // Select weekly lesson in manage tab by data-cmid
                            const weeklyLessonItem = document.querySelector(
                                `.weekly-single-lesson-container .weekly-single-lesson-item[data-cmid="${eventData.googlemeetid}"]`
                            );

                            if (weeklyLessonItem) {
                                weeklyLessonItem.click();
                                console.log('✅ Selected weekly lesson with googlemeetid:', eventData
                                    .googlemeetid);
                            } else {
                                console.warn('Weekly lesson item not found for googlemeetid:',
                                    eventData.googlemeetid);
                                console.log('Available weekly lessons:', document.querySelectorAll(
                                    '.weekly-single-lesson-container .weekly-single-lesson-item'
                                ));
                            }
                        } else {
                            // Select single lesson in manage tab by data-cmid
                            const singleLessonItem = document.querySelector(
                                `.single-lesson-dropdown-card .single-lesson-dropdown-item[data-cmid="${eventData.googlemeetid}"]`
                            );

                            if (singleLessonItem) {
                                singleLessonItem.click();
                                console.log('✅ Selected single lesson with googlemeetid:', eventData
                                    .googlemeetid);
                            } else {
                                console.warn('Single lesson item not found for googlemeetid:',
                                    eventData.googlemeetid);
                                console.log('Available single lessons:', document.querySelectorAll(
                                    '.single-lesson-dropdown-card .single-lesson-dropdown-item'
                                ));
                            }
                        }
                    }, 2000); // Wait 2 seconds for lessons to populate after clicking lesson type
                } else {
                    console.warn('No googlemeetid provided in event data');
                }
            } else {
                console.warn('Lesson type button not found for type:', lessonType);
            }
        }, 500); // Wait 500ms after student selection before clicking lesson type button
    }

    // ===== Cancel modal action (demo) =====
    $('#calendar_admin_cancel_confirm_btn').on('click', function() {
        const payload = {
            reason: $('#calendar_admin_cancel_reason').val() || '',
            message: $('#calendar_admin_cancel_message').val() || '',
            acknowledged: $('#calendar_admin_cancel_ack').is(':checked')
        };
        console.log('Cancel payload', payload);
        $(this).text('Canceled').prop('disabled', true);
        setTimeout(closeAll, 600);
    });

    // ===== Step 3: Confirm new time -> show toast + open Management modal =====
    $('#calendar_admin_reschedule_confirm_new_time').on('click', function() {
        const durationLabel = $('#resched_duration').val();
        const startStr = $('#resched_time').val();
        const endStr = computeEndTime(startStr, durationLabel);
        const dateStr = $('#resched_date').val();

        // Build toast lines
        const line2 = 'English with Mary Janes';
        const line3 = (toPrettyDay(dateStr) || 'Date') + ', ' + to24(startStr) + ' – ' + to24(endStr);

        // Close modals, then show toast and open your management modal
        //    closeAll();
        setTimeout(function() {
            showToast(line2, line3);
            // Keep your existing flow to open Management modal
            //      $('#calendar_admin_details_1_1_class').trigger('click');
        }, 140);
    });

})(jQuery);







// ===== Custom dropdown behavior (Reschedule reason step 3) =====
(function($) {
    var $wrap = $('#resched_reason_dd');
    var $btn = $wrap.find('.ca_dd_btn');
    var $menu = $wrap.find('.ca_dd_menu');
    var $ph = $wrap.find('.ca_dd_placeholder');
    var $valEl = $wrap.find('.ca_dd_value');
    var $hidden = $('#resched_reason_step3');

    function openMenu() {
        $menu.stop(true, true).fadeIn(120);
        $btn.attr('aria-expanded', 'true');
    }

    function closeMenu() {
        $menu.stop(true, true).fadeOut(120);
        $btn.attr('aria-expanded', 'false');
    }

    $btn.on('click', function(e) {
        e.stopPropagation();
        ($menu.is(':visible') ? closeMenu() : openMenu());
    });

    // Select option
    $menu.on('click', '.ca_dd_opt', function(e) {
        var $opt = $(this);
        $menu.find('.ca_dd_opt').removeAttr('aria-selected');
        $opt.attr('aria-selected', 'true');

        var text = $opt.text().trim();
        var value = $opt.data('value') || text;

        $hidden.val(value).trigger('change');
        $valEl.text(text).show();
        $ph.hide();
        closeMenu();
    });

    // Click-away / ESC to close
    $(document).on('click', function() {
        closeMenu();
    });
    $(document).on('keydown', function(e) {
        if (e.key === 'Escape') closeMenu();
    });

    // Optional: set initial value if present
    if ($hidden.val()) {
        var v = $hidden.val();
        var $match = $menu.find('.ca_dd_opt').filter(function() {
            return $(this).data('value') == v;
        }).first();
        if ($match.length) {
            $valEl.text($match.text().trim()).show();
            $ph.hide();
            $match.attr('aria-selected', 'true');
        }
    }
})(jQuery);

// ===== Custom dropdown just for Duration =====
(function($) {
    var $wrap = $('#resched_duration_dd');
    var $btn = $wrap.find('.ca_dd_btn');
    var $menu = $wrap.find('.ca_dd_menu');
    var $ph = $wrap.find('.ca_dd_placeholder');
    var $valEl = $wrap.find('.ca_dd_value');
    var $hidden = $('#resched_duration');

    // Open / close menu
    function openMenu() {
        $menu.stop(true, true).fadeIn(120);
        $btn.attr('aria-expanded', 'true');
    }

    function closeMenu() {
        $menu.stop(true, true).fadeOut(120);
        $btn.attr('aria-expanded', 'false');
    }

    // Toggle on button click
    $btn.on('click', function(e) {
        e.stopPropagation();
        if ($menu.is(':visible')) closeMenu();
        else openMenu();
    });

    // Select option
    $menu.on('click', '.ca_dd_opt', function() {
        var $opt = $(this);
        $menu.find('.ca_dd_opt').removeAttr('aria-selected');
        $opt.attr('aria-selected', 'true');

        var text = $opt.text().trim();
        var val = $opt.data('value'); // numeric minutes

        $hidden.val(val).trigger('change');
        $valEl.text(text).show();
        $ph.hide();

        closeMenu();
    });

    // Close on outside click / ESC
    $(document).on('click', function() {
        closeMenu();
    });
    $(document).on('keydown', function(e) {
        if (e.key === 'Escape') closeMenu();
    });

    // Init from hidden value (default 50)
    (function init() {
        var v = $hidden.val();
        var $match = $menu.find('.ca_dd_opt[data-value="' + v + '"]');
        if ($match.length) {
            $valEl.text($match.text().trim()).show();
            $ph.hide();
            $match.attr('aria-selected', 'true');
        }
    })();

    // ===== Reschedule Calendar Logic =====
    let rescheduleCalendarTargetBtn = null;
    let rescheduleCalendarMonth = null;
    let rescheduleSelectedDate = null;

    function daysInMonth(year, month) {
        return new Date(year, month + 1, 0).getDate();
    }

    // Verify button exists after page loads
    console.log('=== RESCHEDULE CALENDAR INITIALIZATION ===');
    console.log('jQuery version:', $.fn.jquery);
    console.log('Date field button exists:', $('#resched_date_field').length);
    console.log('Date label exists:', $('#resched_date_label').length);
    console.log('Calendar backdrop exists:', $('#rescheduleCalendarBackdrop').length);
    console.log('==========================================');

    // Open calendar when clicking date display in reschedule modal (custom date picker)
    // This handler initializes and displays the calendar modal
    $('#reschedDateDropdownDisplay').on('click', function(e) {
        e.preventDefault();
        e.stopPropagation();

        rescheduleCalendarTargetBtn = $('#reschedDateText');

        let now = new Date();
        rescheduleCalendarMonth = {
            year: now.getFullYear(),
            month: now.getMonth()
        };
        rescheduleSelectedDate = null;

        // Render the calendar
        renderRescheduleCalendar();

        // Show the backdrop
        $('#rescheduleCalendarBackdrop').show();
    }); // Previous month
    $(document).on('click', '.reschedule_calendar_prev', function() {
        if (!rescheduleCalendarMonth) return;
        rescheduleCalendarMonth.month--;
        if (rescheduleCalendarMonth.month < 0) {
            rescheduleCalendarMonth.month = 11;
            rescheduleCalendarMonth.year--;
        }
        renderRescheduleCalendar();
    });

    // Next month
    $(document).on('click', '.reschedule_calendar_next', function() {
        if (!rescheduleCalendarMonth) return;
        rescheduleCalendarMonth.month++;
        if (rescheduleCalendarMonth.month > 11) {
            rescheduleCalendarMonth.month = 0;
            rescheduleCalendarMonth.year++;
        }
        renderRescheduleCalendar();
    });

    // Render calendar
    function renderRescheduleCalendar() {
        if (!rescheduleCalendarMonth) return;
        const monthNames = ["January", "February", "March", "April", "May", "June", "July", "August", "September",
            "October", "November", "December"
        ];
        let y = rescheduleCalendarMonth.year;
        let m = rescheduleCalendarMonth.month;

        $('#rescheduleCalendarMonth').text(monthNames[m] + ' ' + y);

        let html = '';
        let dayHeaders = ['Mo', 'Tu', 'We', 'Th', 'Fr', 'Sa', 'Su'];

        for (let d = 0; d < 7; d++) {
            html += '<div class="calendar_admin_details_create_cohort_calendar_day_header">' + dayHeaders[d] +
                '</div>';
        }

        let firstDay = new Date(y, m, 1).getDay();
        firstDay = (firstDay + 6) % 7;

        let totalDays = daysInMonth(y, m);

        for (let i = 0; i < firstDay; i++) {
            html += '<div class="calendar_admin_details_create_cohort_calendar_day_inactive"></div>';
        }

        for (let d = 1; d <= totalDays; d++) {
            let sel = rescheduleSelectedDate &&
                rescheduleSelectedDate.getFullYear() === y &&
                rescheduleSelectedDate.getMonth() === m &&
                rescheduleSelectedDate.getDate() === d ? ' selected' : '';
            html += '<div class="calendar_admin_details_create_cohort_calendar_day_res' + sel + '" data-day="' + d +
                '">' + d + '</div>';
        }

        let rem = (firstDay + totalDays) % 7;
        if (rem > 0) {
            for (let i = rem; i < 7; i++) {
                html += '<div class="calendar_admin_details_create_cohort_calendar_day_inactive"></div>';
            }
        }

        $('#rescheduleCalendarBackdrop .calendar_admin_details_create_cohort_calendar_days').html(html);
    }

    // Select a day
    $(document).on('click', '#rescheduleCalendarBackdrop .calendar_admin_details_create_cohort_calendar_day_res',
        function() {
            // If the calendar has not been initialized, bail out to avoid null access
            if (!rescheduleCalendarMonth) {
                console.warn('Reschedule calendar month not initialized; ignoring day click');
                return;
            }

            $('#rescheduleCalendarBackdrop .calendar_admin_details_create_cohort_calendar_day_res').removeClass(
                'selected');
            $(this).addClass('selected');
            let day = parseInt($(this).attr('data-day'));
            rescheduleSelectedDate = new Date(rescheduleCalendarMonth.year, rescheduleCalendarMonth.month, day);
        });

    // Done button
    $(document).on('click', '#rescheduleCalendarBackdrop .calendar_admin_details_create_cohort_calendar_done_btn',
        function() {
            if (rescheduleSelectedDate && rescheduleCalendarTargetBtn) {
                let d = rescheduleSelectedDate;
                let nice = d.toLocaleDateString('en-GB', {
                    day: '2-digit',
                    month: 'short',
                    year: 'numeric'
                });

                rescheduleCalendarTargetBtn.text(nice);
                $('#resched_date').val(nice);

                $('#rescheduleCalendarBackdrop').hide();
            }
        });

    // Click outside to close
    $(document).on('click', '#rescheduleCalendarBackdrop', function(e) {
        if (e.target === this) {
            $(this).hide();
        }
    });

    // Expose functions globally for agenda tab and other components
    // Assign to the pre-declared variables so they're available immediately
    window.populateModalWithEventData = populateModalWithEventData;
    window.openLessonInfo = openLessonInfo;
    window.closeAll = closeAll;

})(jQuery);
</script>