
<!-- ===== Trigger button (demo) ===== -->
<!-- <button type="button" class="calendar_admin_details_lesson_information_btn"
        style="border:1.5px solid #e7e7ef;border-radius:10px;padding:10px 16px;font-weight:700;background:#111;color:#fff;">
  Lesson info
</button> -->

<!-- ===== Toast (top-right notification) ===== -->
<div id="calendar_admin_toast" class="calendar_admin_toast" role="status" aria-live="polite" aria-atomic="true">
  <div class="calendar_admin_toast_icon" aria-hidden="true">
    <svg width="18" height="18" viewBox="0 0 24 24"><path d="M20 6L9 17l-5-5" fill="none" stroke="#fff" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg>
  </div>
  <div class="calendar_admin_toast_body">
    <div class="calendar_admin_toast_title">Lesson Rescheduled</div>
    <div class="calendar_admin_toast_text" id="calendar_admin_toast_line2">English with Mary Janes</div>
    <div class="calendar_admin_toast_text" id="calendar_admin_toast_line3">Friday, Sep 6, 6:00 – 6:25 PM</div>
  </div>
  <button type="button" class="calendar_admin_toast_close" aria-label="Close">
    <svg width="16" height="16" viewBox="0 0 24 24"><path d="M6 6l12 12M18 6L6 18" stroke="#fff" stroke-width="2" stroke-linecap="round"/></svg>
  </button>
</div>

<!-- ===== Backdrop (shared by center modal + right drawer + cancel + reschedule step2 + reschedule step3) ===== -->
<div id="calendar_admin_details_lesson_information_backdrop" class="calendar_admin_details_lesson_information_scope">
  <!-- ===== CENTER MODAL: Lesson information ===== -->
  <div class="calendar_admin_details_lesson_information_modal" role="dialog" aria-modal="true" aria-labelledby="cali_title">
    <div class="calendar_admin_details_lesson_information_header">
      <h5 id="cali_title" class="calendar_admin_details_lesson_information_title">Lesson information</h5>
      <button type="button" class="calendar_admin_details_lesson_information_close" aria-label="Close">
        <svg width="22" height="22" viewBox="0 0 24 24"><path d="M6 6l12 12M18 6L6 18" stroke="#111" stroke-width="2" stroke-linecap="round"/></svg>
      </button>
    </div>

    <div class="calendar_admin_details_lesson_information_body">
      <div class="calendar_admin_details_lesson_information_card">
        <div class="calendar_admin_details_lesson_information_row">
          <img class="calendar_admin_details_lesson_information_avatar"
               src="https://randomuser.me/api/portraits/men/32.jpg" alt="Student">
          
          <div class="calendar_admin_details_lesson_information_main">
            <div class="calendar_admin_details_lesson_information_day">Tuesday , Sep 03</div>
            <div class="calendar_admin_details_lesson_information_time">7:00 – 7:25 PM</div>
          </div>


        </div>
        <hr class="calendar_admin_details_lesson_information_divider">
        <div class="calendar_admin_details_lesson_information_meta_row">
          <div class="calendar_admin_details_lesson_information_meta">Jonas | Subscription</div>
          <div class="calendar_admin_details_lesson_information_wallet">
            <svg width="26" height="26" viewBox="0 0 24 24" aria-hidden="true">
              <path d="M21 7H5a2 2 0 0 1 0-4h12" fill="none" stroke="#444" stroke-width="1.6" stroke-linecap="round"/>
              <rect x="3" y="5" width="18" height="14" rx="2" ry="2" fill="none" stroke="#444" stroke-width="1.6"/>
              <circle cx="17" cy="12" r="1.2" fill="#444"/>
            </svg>
            <span class="calendar_admin_details_lesson_information_lessons">2 Lessons</span>
          </div>
        </div>
      </div>

      <button type="button" class="calendar_admin_details_lesson_information_action"
              id="calendar_admin_details_lesson_information_open_chat">Message</button>
      <button type="button" class="calendar_admin_details_lesson_information_action" id="calendar_admin_details_1_1_class">View Or Reschedule Lesson</button>
      <button type="button" class="calendar_admin_details_lesson_information_danger" id="calendar_admin_details_lesson_information_cancel_trigger">Cancel Lesson</button>
    </div>
  </div>

  <!-- ===== CENTER MODAL: Cancel Lesson ===== -->
  <div class="calendar_admin_cancel_modal" role="dialog" aria-modal="true" aria-labelledby="cancel_title">
    <div class="calendar_admin_cancel_header">
      <button type="button" class="calendar_admin_cancel_back" aria-label="Back to lesson info">
        <svg width="22" height="22" viewBox="0 0 24 24"><polyline points="15 19 8 12 15 5" fill="none" stroke="#111" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg>
      </button>
      <h5 id="cancel_title" class="calendar_admin_cancel_title">Are You Sure You Want To Cancel?</h5>
      <button type="button" class="calendar_admin_cancel_close" aria-label="Close">
        <svg width="22" height="22" viewBox="0 0 24 24"><path d="M6 6l12 12M18 6L6 18" stroke="#111" stroke-width="2" stroke-linecap="round"/></svg>
      </button>
    </div>

    <div class="calendar_admin_cancel_body">
      <p class="calendar_admin_cancel_note">
        Please note that the lesson <strong>Tuesday , Sep 03 7:00 – 7:25 with jonas</strong> will be canceled and will not be rescheduled.
        This cancellation is final, and there will be no makeup session. Let us know if any further action is needed.
      </p>

          <label class="form-label fw-semibold mb-2">Please choose a reason for cancel lesson</label>
            <!-- Custom dropdown: Reschedule reason -->
            <div class="ca_dd_wrap" id="resched_reason_dd">
              <button type="button" class="ca_dd_btn" aria-haspopup="listbox" aria-expanded="false">
                <span class="ca_dd_placeholder">Select Reason</span>
                <span class="ca_dd_value" style="display:none;"></span>
                <span class="ca_dd_caret" aria-hidden="true">▾</span>
              </button>

              <div class="ca_dd_menu" role="listbox" tabindex="-1">
                <div class="ca_dd_opt" role="option" data-value="cant-make">He’s not able to make it today.</div>
                <div class="ca_dd_opt" role="option" data-value="timing">The timing isn’t working out today.</div>
                <div class="ca_dd_opt" role="option" data-value="tech-issues">There are some tech issues, so we can’t run the class.</div>
                <div class="ca_dd_opt" role="option" data-value="teacher-na">The teacher isn’t available right now.</div>
              </div>

              <!-- Keep same ID as your old <select> so existing code keeps working -->
              <input type="hidden" id="resched_reason_step3" value="">
            </div>

      <label for="calendar_admin_cancel_message" class="form-label fw-semibold mb-2">Message for Daniela • Optional</label>
      <textarea id="calendar_admin_cancel_message" class="form-control calendar_admin_cancel_textarea mb-3" rows="3" placeholder="Message for Daniela"></textarea>

      <div class="form-check mb-3">
        <input class="form-check-input" type="checkbox" id="calendar_admin_cancel_ack">
        <label class="form-check-label" for="calendar_admin_cancel_ack">
          I know my position will decrease and fewer students will see
        </label>
      </div>

      <button type="button" class="btn calendar_admin_cancel_resched w-100 mb-3" id="calendar_admin_cancel_reschedule_btn">
        Reschedule lesson
      </button>

      <button type="button" class="btn calendar_admin_cancel_confirm w-100" id="calendar_admin_cancel_confirm_btn">
        Confirm Cancel
      </button>
    </div>
  </div>

  <!-- ===== CENTER MODAL: Reschedule Lesson — STEP 2 ===== -->
  <div class="calendar_admin_reschedule_modal" role="dialog" aria-modal="true" aria-labelledby="resched_title">
    <div class="calendar_admin_reschedule_header">
      <button type="button" class="calendar_admin_reschedule_back" aria-label="Back to cancel step">
        <svg width="22" height="22" viewBox="0 0 24 24"><polyline points="15 19 8 12 15 5" fill="none" stroke="#111" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg>
      </button>
      <h5 id="resched_title" class="calendar_admin_reschedule_title">Reschedule lesson</h5>
      <button type="button" class="calendar_admin_reschedule_close" aria-label="Close">
        <svg width="22" height="22" viewBox="0 0 24 24"><path d="M6 6l12 12M18 6L6 18" stroke="#111" stroke-width="2" stroke-linecap="round"/></svg>
      </button>
    </div>

    <div class="calendar_admin_reschedule_body">
      <div class="calendar_admin_reschedule_label">Current lesson</div>

      <!-- Lesson card -->
      <div class="calendar_admin_details_lesson_information_card mb-3">
        <div class="calendar_admin_details_lesson_information_row">
          <div class="calendar_admin_details_lesson_information_header_avatar" style="border-radius:10px;">
            <svg width="22" height="22" viewBox="0 0 24 24"><circle cx="12" cy="8" r="4" fill="#fff"/><path d="M4 20c1.8-4 6.2-6 8-6s6.2 2 8 6" stroke="#fff" stroke-width="1.5" fill="none"/></svg>
          </div>
          <div class="calendar_admin_details_lesson_information_main">
            <div class="calendar_admin_details_lesson_information_day">Friday , Sep 06</div>
            <div class="calendar_admin_details_lesson_information_time">6:00 – 6:25 PM</div>
          </div>
        </div>
        <hr class="calendar_admin_details_lesson_information_divider">
        <div class="calendar_admin_details_lesson_information_meta_row">
          <div class="calendar_admin_details_lesson_information_meta">Mary Janes | Subscription</div>
          <div class="calendar_admin_details_lesson_information_wallet">
            <svg width="26" height="26" viewBox="0 0 24 24" aria-hidden="true">
              <path d="M21 7H5a2 2 0 0 1 0-4h12" fill="none" stroke="#444" stroke-width="1.6" stroke-linecap="round"/>
              <rect x="3" y="5" width="18" height="14" rx="2" ry="2" fill="none" stroke="#444" stroke-width="1.6"/>
              <circle cx="17" cy="12" r="1.2" fill="#444"/>
            </svg>
            <span class="calendar_admin_details_lesson_information_lessons">2 Lessons</span>
          </div>
        </div>
      </div>

      <div class="calendar_admin_reschedule_label">Date and time</div>

        <!-- Custom dropdown: Duration -->
        <div class="ca_dd_wrap" id="resched_duration_dd">
          <button type="button" class="ca_dd_btn" aria-haspopup="listbox" aria-expanded="false">
            <span class="ca_dd_placeholder">50 Minutes ( Standard time )</span>
            <span class="ca_dd_value" style="display:none;"></span>
            <span class="ca_dd_caret" aria-hidden="true">▾</span>
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

<div class="ca_res_row">
  <!-- DATE FIELD (no dropdown) -->
  <div class="ca_res_col">
    <div class="ca_res_selectwrap">
      <!-- Visible button that looks like your select -->
      <button type="button"
              id="resched_date_field"
              class="form-select calendar_admin_details_lesson_info_calendar_modal_field"
              aria-haspopup="dialog" aria-expanded="false">
        <span id="resched_date_label">Tue, Feb11</span>
      </button>

      <!-- Hidden value used by your existing code: $('#resched_date').val() -->
      <input type="hidden" id="resched_date" value="Tue, Feb11">

      <!-- <span class="ca_res_select_icon" aria-hidden="true">▾</span> -->
    </div>
  </div>

  <!-- TIME (unchanged, still a normal dropdown) -->
  <div class="ca_res_col">
    <div class="ca_res_selectwrap">
      <select class="form-select" id="resched_time">
        <option selected>12:00 AM</option>
        <option>12:30 AM</option>
        <option>1:00 AM</option>
        <option>1:30 AM</option>
      </select>
      <span class="ca_res_select_icon" aria-hidden="true">▾</span>
    </div>
  </div>
</div>





      <div class="calendar_admin_reschedule_hint">
        <svg width="18" height="18" viewBox="0 0 24 24"><circle cx="12" cy="12" r="9" fill="none" stroke="#777" stroke-width="1.6"/><path d="M12 8v5m0 4h0" stroke="#777" stroke-width="1.6" stroke-linecap="round"/></svg>
        <span>That's Sunday at 16:30 for Mary Janes</span>
      </div>

      <button type="button" class="btn calendar_admin_reschedule_continue w-100" id="calendar_admin_reschedule_continue_btn">
        Continue
      </button>
    </div>
  </div>

  <!-- ===== CENTER MODAL: Reschedule Lesson — STEP 3 (CONFIRM) ===== -->
  <div class="calendar_admin_reschedule_confirm_modal" role="dialog" aria-modal="true" aria-labelledby="resched_confirm_title">
    <div class="calendar_admin_reschedule_header">
      <button type="button" class="calendar_admin_reschedule_confirm_back" aria-label="Back to step 2">
        <svg width="22" height="22" viewBox="0 0 24 24"><polyline points="15 19 8 12 15 5" fill="none" stroke="#111" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg>
      </button>
      <h5 id="resched_confirm_title" class="calendar_admin_reschedule_title">Reschedule lesson</h5>
      <button type="button" class="calendar_admin_reschedule_close" aria-label="Close">
        <svg width="22" height="22" viewBox="0 0 24 24"><path d="M6 6l12 12M18 6L6 18" stroke="#111" stroke-width="2" stroke-linecap="round"/></svg>
      </button>
    </div>

    <div class="calendar_admin_reschedule_body">
      <span class="ca_res_chip">Updated lesson</span>

      <div class="calendar_admin_lite_card mb-3">
        <div class="calendar_admin_lite_row">
          <div class="calendar_admin_lite_avatar">
            <svg width="22" height="22" viewBox="0 0 24 24"><circle cx="12" cy="8" r="4" fill="#fff"/><path d="M4 20c1.8-4 6.2-6 8-6s6.2 2 8 6" stroke="#fff" stroke-width="1.5" fill="none"/></svg>
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
              <path d="M21 7H5a2 2 0 0 1 0-4h12" fill="none" stroke="#444" stroke-width="1.6" stroke-linecap="round"/>
              <rect x="3" y="5" width="18" height="14" rx="2" ry="2" fill="none" stroke="#444" stroke-width="1.6"/>
              <circle cx="17" cy="12" r="1.2" fill="#444"/>
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
        <span class="ca_res_select_icon" aria-hidden="true">▾</span>
      </div>

      <label for="resched_message_step3" class="form-label fw-semibold mb-2">Message for Daniela • Optional</label>
      <textarea id="resched_message_step3" class="form-control calendar_admin_cancel_textarea mb-3" rows="3" placeholder="Message for Daniela"></textarea>

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
          <svg width="22" height="22" viewBox="0 0 24 24"><circle cx="12" cy="8" r="4" fill="#fff"/><path d="M4 20c1.8-4 6.2-6 8-6s6.2 2 8 6" stroke="#fff" stroke-width="1.5" fill="none"/></svg>
        </div>
        <span class="calendar_admin_details_lesson_information_drawer_title" id="cali_chat_title">Jonas</span>
      </div>
      <button type="button" class="calendar_admin_details_lesson_information_drawer_close" aria-label="Close">
        <svg width="22" height="22" viewBox="0 0 24 24"><path d="M6 6l12 12M18 6L6 18" stroke="#111" stroke-width="2" stroke-linecap="round"/></svg>
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
            Good morning, I want to confirm our meeting today and ask if the meeting will take place within the Latingles virtual classroom or will you provide the information?
          </div>
        </div>
      </div>

      <!-- Self 1 -->
      <div class="calendar_admin_details_lesson_information_msg self">
        <div class="calendar_admin_details_lesson_information_avatar_circle">
          <svg width="20" height="20" viewBox="0 0 24 24"><circle cx="12" cy="8" r="4" fill="#fff"/><path d="M4 20c1.8-4 6.2-6 8-6s6.2 2 8 6" stroke="#fff" stroke-width="1.5" fill="none"/></svg>
        </div>
        <div class="calendar_admin_details_lesson_information_msg_content">
          <div class="calendar_admin_details_lesson_information_msg_head">
            <strong>Latingles</strong> <span>11:06</span>
          </div>
          <div class="calendar_admin_details_lesson_information_msg_text">I'm already in, is anyone joining</div>
        </div>
      </div>

      <!-- Self 2 -->
      <div class="calendar_admin_details_lesson_information_msg self">
        <div class="calendar_admin_details_lesson_information_avatar_circle">
          <svg width="20" height="20" viewBox="0 0 24 24"><circle cx="12" cy="8" r="4" fill="#fff"/><path d="M4 20c1.8-4 6.2-6 8-6s6.2 2 8 6" stroke="#fff" stroke-width="1.5" fill="none"/></svg>
        </div>
        <div class="calendar_admin_details_lesson_information_msg_content">
          <div class="calendar_admin_details_lesson_information_msg_head">
            <strong>Latingles</strong> <span>11:06</span>
          </div>
          <div class="calendar_admin_details_lesson_information_msg_text">Yes Please wait for me ! Thank you</div>
        </div>
      </div>
    </div>

    <!-- Composer panel -->
    <div class="calendar_admin_details_lesson_information_drawer_footer">
      <div class="calendar_admin_details_lesson_information_composerPanel">
        <textarea class="calendar_admin_details_lesson_information_textarea"
                  rows="1" placeholder="Your message"></textarea>

        <div class="calendar_admin_details_lesson_information_composerActions">
          <div class="calendar_admin_details_lesson_information_actions_left">
            <input type="file" id="calendar_admin_details_lesson_information_file" style="display:none">
            <button type="button" class="calendar_admin_details_lesson_information_icon" id="calendar_admin_details_lesson_information_attach" title="Attach">
              <svg width="22" height="22" viewBox="0 0 24 24"><path d="M21 8l-9.4 9.4a5 5 0 01-7.1-7.1L14.5 0" fill="none" stroke="#777" stroke-width="1.7" stroke-linecap="round" stroke-linejoin="round"/></svg>
            </button>
            <button type="button" class="calendar_admin_details_lesson_information_icon" id="calendar_admin_details_lesson_information_emoji" title="Emoji">
              <svg width="22" height="22" viewBox="0 0 24 24"><circle cx="12" cy="12" r="9" fill="none" stroke="#777" stroke-width="1.7"/><circle cx="9" cy="10" r="1"/><circle cx="15" cy="10" r="1"/><path d="M8 14c1.2 1.3 2.6 2 4 2s2.8-.7 4-2" fill="none" stroke="#777" stroke-width="1.7" stroke-linecap="round"/></svg>
            </button>
          </div>

          <div class="calendar_admin_details_lesson_information_actions_right">
            <button type="button" class="calendar_admin_details_lesson_information_icon" id="calendar_admin_details_lesson_information_mic" title="Voice">
              <svg width="22" height="22" viewBox="0 0 24 24"><rect x="9" y="3" width="6" height="10" rx="3" fill="none" stroke="#777" stroke-width="1.7"/><path d="M5 11a7 7 0 0014 0M12 18v3" fill="none" stroke="#777" stroke-width="1.7" stroke-linecap="round"/></svg>
            </button>
          </div>
        </div>
      </div>
    </div>
  </aside>
</div>

<?php require_once('calendar_admin_details_lesson_information_calendar_modal.php');?>

<?php /* Keep external include commented to avoid duplicates:
require_once('calendar_admin_details_lesson_information_cancel_lesson.php'); */?>

<style>
/* ===== Toast ===== */
.calendar_admin_toast{
  position: fixed; top: 18px; right: 18px; z-index: 6000;
  display: none; align-items: flex-start; gap: 10px;
  background:#111; color:#fff; border-radius:12px; padding:12px 14px;
  box-shadow:0 16px 40px rgba(0,0,0,.28);
  min-width: 290px; max-width: 360px;
}
.calendar_admin_toast_icon{ width:28px;height:28px;border-radius:50%;display:grid;place-items:center;background:#2ecc71; }
.calendar_admin_toast_title{ font-weight:900; }
.calendar_admin_toast_text{ opacity:.9; margin-top:2px; }
.calendar_admin_toast_close{
  margin-left:auto; background:transparent; border:0; width:28px; height:28px; border-radius:8px; display:grid; place-items:center; cursor:pointer;
}

/* ===== Backdrop ===== */
#calendar_admin_details_lesson_information_backdrop.calendar_admin_details_lesson_information_scope{
  position: fixed; inset: 0; z-index: 2000;
  display: none; align-items: center; justify-content: center; padding: 18px;
  background: rgba(0,0,0,.45);
}

/* ===== Center Modal: Lesson Info ===== */
.calendar_admin_details_lesson_information_modal{
  width:100%; max-width:520px; background:#fff;
  border:1px solid #e9e9f0; border-radius:12px; overflow:hidden;
  box-shadow:0 20px 50px rgba(0,0,0,.12);
}
.calendar_admin_details_lesson_information_header{ display:flex; align-items:center; justify-content:space-between; padding:18px 20px 6px; }
.calendar_admin_details_lesson_information_title{ margin:0; font-weight:800; font-size:1.65rem; letter-spacing:.2px; color:#111; }
.calendar_admin_details_lesson_information_close{ background:transparent; border:0; width:38px; height:38px; border-radius:8px; display:grid; place-items:center; cursor:pointer; }
.calendar_admin_details_lesson_information_body{ padding:12px 20px 20px; }
.calendar_admin_details_lesson_information_card{ border:1px solid #e9e9f0; border-radius:12px; padding:14px; background:#fff; }
.calendar_admin_details_lesson_information_row{ display:flex; align-items:center; gap:12px; }
.calendar_admin_details_lesson_information_avatar{ width:48px; height:48px; border-radius:10px; object-fit:cover; }
.calendar_admin_details_lesson_information_day{ font-weight:800; font-size:1.22rem; color:#111; line-height:1.1; }
.calendar_admin_details_lesson_information_time{ color:#6b7280; font-weight:600; margin-top:2px; line-height:1.1; }
.calendar_admin_details_lesson_information_divider{ margin:12px 0; border:0; height:1px; background:#ececf3; }
.calendar_admin_details_lesson_information_meta_row{ display:flex; align-items:center; justify-content:space-between; gap:10px; flex-wrap:wrap; }
.calendar_admin_details_lesson_information_meta{ color:#2f323a; font-weight:600; }
.calendar_admin_details_lesson_information_wallet{ display:flex; align-items:center; gap:8px; }
.calendar_admin_details_lesson_information_lessons{ color:#4b4f5c; font-weight:700; }
.calendar_admin_details_lesson_information_action{
  width:100%; margin-top:12px; background:#fff; color:#1e1f25; font-weight:700;
  border:1.25px solid #e7e7ef; border-radius:10px; padding:12px 16px; transition:box-shadow .15s ease;
}
.calendar_admin_details_lesson_information_action:hover{ box-shadow:0 6px 18px rgba(0,0,0,.06); }
.calendar_admin_details_lesson_information_danger{
  width:100%; margin-top:14px; background:#ef2d17; color:#fff; font-weight:800; border:0; border-radius:10px; padding:12px 16px; box-shadow:0 10px 26px rgba(239,45,23,.25);
}

/* ===== Right Drawer (Chat) ===== */
.calendar_admin_details_lesson_information_drawer{
  position:absolute; right:18px; top:18px; bottom:18px;
  width:540px; max-width:calc(100% - 36px);
  background:#fff; border:1px solid #e9e9f0; border-radius:12px;
  box-shadow:0 20px 50px rgba(0,0,0,.12);
  display:flex; flex-direction:column;
  transform:translateX(30px); opacity:0; pointer-events:none;
  transition:transform .18s ease, opacity .18s ease;
}
.calendar_admin_details_lesson_information_drawer_header{
  display:flex; align-items:center; justify-content:space-between;
  padding:16px 18px; border-bottom:1px solid #f0f0f4;
}
.calendar_admin_details_lesson_information_drawer_titlewrap{ display:flex; align-items:center; gap:10px; }
.calendar_admin_details_lesson_information_header_avatar{
  width:32px;height:32px;border-radius:50%;background:#111;display:flex;align-items:center;justify-content:center;color:#fff;
}
.calendar_admin_details_lesson_information_drawer_title{ font-weight:800; font-size:1.25rem; text-decoration:underline; color:#111; }
.calendar_admin_details_lesson_information_drawer_close{ background:transparent; border:0; width:36px; height:36px; border-radius:8px; display:grid; place-items:center; cursor:pointer; }

.calendar_admin_details_lesson_information_drawer_body{ padding:14px 18px; overflow:auto; flex:1; }
.calendar_admin_details_lesson_information_chat_stamp{
  display:inline-block; background:#eef1f6; color:#555; font-weight:700;
  padding:6px 12px; border-radius:9px; margin:8px auto 14px; text-align:center;
}
.calendar_admin_details_lesson_information_msg{ display:flex; gap:10px; margin-bottom:18px; align-items:flex-start; }
.calendar_admin_details_lesson_information_msg img{ width:36px; height:36px; border-radius:50%; object-fit:cover; }
.calendar_admin_details_lesson_information_msg.self .calendar_admin_details_lesson_information_avatar_circle{
  width:36px; height:36px; border-radius:50%; background:#9aa3b2; display:flex; align-items:center; justify-content:center;
}
.calendar_admin_details_lesson_information_msg_content{ max-width:100%; }
.calendar_admin_details_lesson_information_msg_head{ color:#2b2b2b; margin-bottom:4px; }
.calendar_admin_details_lesson_information_msg_head span{ color:#9aa0a6; font-weight:700; margin-left:6px; }
.calendar_admin_details_lesson_information_msg_text{ color:#222; line-height:1.45; }

.calendar_admin_details_lesson_information_drawer_footer{
  border-top:1px solid #f0f0f4; padding:12px; background:#fff;
  padding-bottom: calc(12px + env(safe-area-inset-bottom));
}
.calendar_admin_details_lesson_information_composerPanel{
  background:#fff; border:1px solid #dfe2ea; border-radius:16px;
  padding:10px; box-shadow:0 2px 10px rgba(20,20,20,.03);
}
.calendar_admin_details_lesson_information_textarea{
  width:100%; border:1px solid #e1e3eb; background:#fff; color:#111;
  outline:none; resize:none; border-radius:12px;
  padding:12px 14px; min-height:100px; max-height:160px; line-height:1.35;
}
.calendar_admin_details_lesson_information_textarea::placeholder{ color:#b2b6c3; }

.calendar_admin_details_lesson_information_composerActions{
  display:flex; align-items:center; gap:8px; margin-top:10px;
}
.calendar_admin_details_lesson_information_actions_left{ display:flex; align-items:center; gap:8px; }
.calendar_admin_details_lesson_information_actions_right{ margin-left:auto; display:flex; align-items:center; gap:8px; }

.calendar_admin_details_lesson_information_icon{
  background:#fff; border:1px solid #e1e3eb; width:38px; height:38px;
  border-radius:10px; display:grid; place-items:center; cursor:pointer;
}
.calendar_admin_details_lesson_information_icon:hover{ background:#f7f8fb; }

/* ===== Cancel Modal (snapshot-accurate overrides) ===== */
.calendar_admin_cancel_modal{
  width:100%;
  max-width:530px;
  background:#fff;
  border:1px solid #e9e9f0;
  border-radius:12px;
  overflow:hidden;
  box-shadow:0 20px 50px rgba(0,0,0,.12);
  display:none;
}
.calendar_admin_cancel_header{
  display:flex; align-items:center; justify-content:space-between; gap:8px;
  padding:14px 16px; border-bottom:1px solid #f0f0f4;
}
.calendar_admin_cancel_back, .calendar_admin_cancel_close{
  background:transparent; border:0; width:38px; height:38px; border-radius:8px; display:grid; place-items:center; cursor:pointer;
}
.calendar_admin_cancel_title{
  /* margin:0; */
   font-weight:600; font-size:1.9rem; line-height:1.15;
  color:#111; text-align:left; flex:1; margin-left:6px;
  margin-top:50px;
}
.calendar_admin_cancel_body{ padding:18px 20px 20px; }
.calendar_admin_cancel_note{ color:#20242c; font-size:1rem; line-height:1.6; margin-bottom:18px; }
.calendar_admin_cancel_body .form-label{ font-weight:700; color:#1e1f25; margin-bottom:8px; }
.calendar_admin_cancel_selectwrap{ position:relative; }
.calendar_admin_cancel_selectwrap .form-select{
  height:58px; border-radius:12px; border:1.6px solid #e1e3eb;
  padding:14px 44px 14px 16px; font-size:1.05rem; line-height:1.2; background:#fff;
}
.calendar_admin_cancel_select_icon{
  position:absolute; right:14px; top:50%; transform:translateY(-50%); pointer-events:none;
  color:#222; font-weight:700; font-size:30px;
}
.calendar_admin_cancel_textarea{
  min-height:66px; border-radius:12px; border:1.6px solid #e1e3eb;
  padding:14px 16px; font-size:1.02rem;
}
.form-check .form-check-input{ width:22px; height:22px; margin-top:2px; }
.form-check .form-check_input{ width:22px; height:22px; margin-top:2px; } /* keep both (no removal) */
.form-check .form-check-label{ margin-left:6px; line-height:1.45; color:#1f232b; font-weight:600; }
.calendar_admin_cancel_resched{
  height:58px; border-radius:12px; border:1.8px solid #e7e7ef; font-weight:800; font-size:1.05rem;
}
.calendar_admin_cancel_resched:hover{ box-shadow:0 6px 18px rgba(0,0,0,.06); }
.calendar_admin_cancel_confirm{
  height:60px; border-radius:12px; font-weight:900; font-size:1.08rem; letter-spacing:.2px;
  background:#ef2d17; color:#fff; border:0; padding:12px 16px;
  box-shadow:0 10px 26px rgba(239,45,23,.25);
}

/* ===== Reschedule Modal (STEP 2) ===== */
.calendar_admin_reschedule_modal{
  width:100%;
  max-width:530px;
  background:#fff;
  border:1px solid #e9e9f0;
  border-radius:12px;
  overflow:hidden;
  box-shadow:0 20px 50px rgba(0,0,0,.12);
  display:none;
}
.calendar_admin_reschedule_header{
  display:flex; align-items:center; justify-content:space-between; gap:8px;
  padding:14px 16px; border-bottom:1px solid #f0f0f4;
}
.calendar_admin_reschedule_back, .calendar_admin_reschedule_close{
  background:transparent; border:0; width:38px; height:38px; border-radius:8px; display:grid; place-items:center; cursor:pointer;
}
.calendar_admin_reschedule_title{
  /* margin:0; 
   */
  font-weight:600; font-size:1.9rem; line-height:1.15;
  color:#111; text-align:left; flex:1; margin-left:6px;
  margin-top: 50px;
}
.calendar_admin_reschedule_body{ padding:18px 20px 20px; }
.calendar_admin_reschedule_label{
  color:#7d8392; font-weight:800; letter-spacing:.3px; margin-bottom:8px;
}
.ca_res_selectwrap{ position:relative; }
.ca_res_selectwrap .form-select{
  height:58px; border-radius:12px; border:1.6px solid #e1e3eb;
  padding:14px 44px 14px 16px; font-size:1.05rem; line-height:1.2; background:#fff;
}
.ca_res_select_icon{
  position:absolute; right:14px; top:50%; transform:translateY(-50%); pointer-events:none;
  color:#222; font-weight:700; font-size:30px;
}
.ca_res_row{ display:flex; gap:12px; margin-top:8px; margin-bottom:8px; }
.ca_res_col{ flex:1 1 0; }
.calendar_admin_reschedule_hint{
  display:flex; align-items:center; gap:8px; color:#474c57; font-weight:700; margin:6px 0 14px;
}
.calendar_admin_reschedule_continue{
  height:60px; border-radius:12px; font-weight:900; font-size:1.08rem; letter-spacing:.2px;
  background:#ef2d17; color:#fff; border:0; padding:12px 16px;
  box-shadow:0 10px 26px rgba(239,45,23,.25);
}

/* ===== Reschedule Modal (STEP 3 — Confirm) ===== */
.calendar_admin_reschedule_confirm_modal{
  width:100%;
  max-width:530px;
  background:#fff;
  border:1px solid #e9e9f0;
  border-radius:12px;
  overflow:hidden;
  box-shadow:0 20px 50px rgba(0,0,0,.12);
  display:none;
}
.ca_res_chip{
  display:inline-block; background:#eef1f6; color:#2c313a; font-weight:800;
  padding:6px 12px; border-radius:9px; margin-bottom:10px;
}
.calendar_admin_lite_card{
  border:1px solid #ececf3; border-radius:12px; background:#f7f8fb; padding:14px;
}
.calendar_admin_lite_row{ display:flex; align-items:center; gap:12px; }
.calendar_admin_lite_avatar{
  width:48px;height:48px;border-radius:10px;background:#111;display:flex;align-items:center;justify-content:center;color:#fff;
}
.calendar_admin_lite_day{ font-weight:800; font-size:1.22rem; color:#111; line-height:1.1; }
.calendar_admin_lite_time{ color:#6b7280; font-weight:700; margin-top:2px; line-height:1.1; }
.calendar_admin_lite_divider{ margin:12px 0; border:0; height:1px; background:#e6e8f2; }
.calendar_admin_lite_meta_row{ display:flex; align-items:center; justify-content:space-between; gap:10px; flex-wrap:wrap; }
.calendar_admin_lite_meta{ color:#2f323a; font-weight:600; }
.ca_res_confirm{
  height:60px; border-radius:12px; font-weight:900; font-size:1.08rem; letter-spacing:.2px;
  background:#ef2d17; color:#fff; border:0; padding:12px 16px;
  box-shadow:0 10px 26px rgba(239,45,23,.25);
}

/* ===== States ===== */
#calendar_admin_details_lesson_information_backdrop.calendar_admin_details_lesson_information_scope.is-open{ display:flex; }
.calendar_admin_details_lesson_information_drawer.is-open{ transform:translateX(0); opacity:1; pointer-events:auto; }

/* ===== Responsive ===== */
@media (max-width: 992px){
  .calendar_admin_details_lesson_information_drawer{ right:10px; left:10px; width:auto; max-width:none; }
}
@media (max-width: 560px){
  .ca_res_row{ flex-direction:column; }
}
@media (max-width: 430px){
  .calendar_admin_details_lesson_information_title{ font-size:1.45rem; }
  .calendar_admin_details_lesson_information_day{ font-size:1.11rem; }
  .calendar_admin_details_lesson_information_avatar{ width:44px; height:44px; border-radius:9px; }
  .calendar_admin_cancel_title,
  .calendar_admin_reschedule_title{ font-size:1.55rem; }
}








/* Hide native caret for our wrapped selects (keep the custom ▾ span) */
.calendar_admin_cancel_selectwrap .form-select,
.ca_res_selectwrap .form-select{
  -webkit-appearance: none !important;
  -moz-appearance: none !important;
  appearance: none !important;
  background-image: none !important;   /* overrides Bootstrap's built-in arrow */
  /* keep the padding you already set to reserve space for the custom icon */
}

/* Old IE/Edge */
.calendar_admin_cancel_selectwrap .form-select::-ms-expand,
.ca_res_selectwrap .form-select::-ms-expand{
  display: none;
}















/* === Custom dropdown (snapshot style) === */
.ca_dd_wrap{ position:relative; }
.ca_dd_btn{
  width:100%; height:58px;
  background:#fff; border:1.6px solid #e1e3eb; border-radius:12px;
  display:flex; align-items:center; justify-content:space-between;
  padding:14px 16px; font-size:1.05rem; line-height:1.2; font-weight:600;
  box-shadow:0 2px 10px rgba(20,20,20,.03);
}
.ca_dd_btn:focus{ outline:2px solid #e9e9f5; outline-offset:2px; }
.ca_dd_placeholder{ color:#9aa3b2; }
.ca_dd_value{ color:#1e1f25; font-weight:700; }
.ca_dd_caret{ margin-left:12px; font-size:22px; color:#222; line-height:1; }

.ca_dd_menu{
  position:absolute; left:0; right:0; top:100%; margin-top:10px;
  background:#fff; border-radius:14px; border:1px solid #ececf3;
  box-shadow:0 20px 40px rgba(0,0,0,.18);
  padding:12px 0; display:none; z-index:6000;  /* above modal content */
  max-height:320px; overflow:auto;
}
.ca_dd_opt{
  padding:16px 18px; font-size:1.02rem; line-height:1.5;
  color:#1e1f25; font-weight:700; cursor:pointer;
}
.ca_dd_opt:hover, .ca_dd_opt[aria-selected="true"]{ background:#f7f8fb; }

</style>

<script>
(function($){
  const $backdrop = $('#calendar_admin_details_lesson_information_backdrop');
  const $modal    = $backdrop.find('.calendar_admin_details_lesson_information_modal');
  const $drawer   = $backdrop.find('.calendar_admin_details_lesson_information_drawer');
  const $cancel   = $backdrop.find('.calendar_admin_cancel_modal');
  const $resched  = $backdrop.find('.calendar_admin_reschedule_modal');            // step 2
  const $res3     = $backdrop.find('.calendar_admin_reschedule_confirm_modal');    // step 3
  const $toast    = $('#calendar_admin_toast');

  function openBackdrop(){
    $backdrop.addClass('is-open').hide().fadeIn(100);
    $('body').css('overflow','hidden');
  }
  function closeAll(){
    $drawer.removeClass('is-open');
    $backdrop.fadeOut(100, function(){ $backdrop.removeClass('is-open'); });
    $('body').css('overflow','');
    $modal.show(); $cancel.hide(); $resched.hide(); $res3.hide();
  }
  function openLessonInfo(){ openBackdrop(); $modal.show(); $cancel.hide(); $resched.hide(); $res3.hide(); }
  function openChatDrawer(){
    if (!$backdrop.hasClass('is-open')) openBackdrop();
    $drawer.addClass('is-open');
    setTimeout(()=>$('.calendar_admin_details_lesson_information_textarea').trigger('focus'), 120);
  }
  function openCancelModal(){
    if (!$backdrop.hasClass('is-open')) openBackdrop();
    $modal.hide(); $resched.hide(); $res3.hide(); $cancel.show();
  }
  function openRescheduleModal(){
    if (!$backdrop.hasClass('is-open')) openBackdrop();
    $modal.hide(); $cancel.hide(); $res3.hide(); $resched.show();
  }
  function openRescheduleConfirm(){
    // copy values from Step 2 to Step 3 card
    const dateStr = $('#resched_date').val();
    const timeStr = $('#resched_time').val();
    const endStr  = computeEndTime(timeStr, $('#resched_duration').val());
    $('#res3_day').text(toPrettyDay(dateStr));
    $('#res3_time').text(to24(timeStr)+' – '+to24(endStr));
    if (!$backdrop.hasClass('is-open')) openBackdrop();
    $modal.hide(); $cancel.hide(); $resched.hide(); $res3.show();
  }

  // Utilities to format times
  function parseDurationMins(label){
    const m = (label||'').match(/(\d+)\s*Minutes/i);
    return m ? parseInt(m[1],10) : 50;
  }
  function toMinutes(t){ // "1:30 AM" -> minutes from midnight
    const m = t.match(/^(\d{1,2}):(\d{2})\s*(AM|PM)$/i);
    if(!m) return 0;
    let h = parseInt(m[1],10) % 12;
    const min = parseInt(m[2],10);
    const pm = m[3].toUpperCase()==='PM';
    if(pm) h += 12;
    return h*60+min;
  }
  function minutesTo12(mins){
    mins = ((mins % 1440) + 1440) % 1440;
    let h = Math.floor(mins/60), m = mins%60;
    const ampm = h>=12 ? 'PM':'AM';
    h = h%12; if(h===0) h=12;
    return h+':'+String(m).padStart(2,'0')+' '+ampm;
  }
  function to24(t){ // "1:30 PM" -> "01:30 PM" like your snapshot uses leading zero for hour <10?
    const m = t.match(/^(\d{1,2}):(\d{2})\s*(AM|PM)$/i);
    if(!m) return t;
    let h = parseInt(m[1],10);
    return (h<10?('0'+h):h)+':'+m[2]+' '+m[3].toUpperCase();
  }
  function computeEndTime(startStr, durationLabel){
    const start = toMinutes(startStr);
    const dur   = parseDurationMins(durationLabel);
    return minutesTo12(start + dur);
  }
  function toPrettyDay(raw){ // "Tue, Feb11" -> "Tue, Feb11" (simple passthrough)
    return raw || '';
  }

  // Toast helpers
  let toastTimer = null;
  function showToast(line2, line3, title = 'Lesson Rescheduled'){
    $('#calendar_admin_toast_line2').text(line2||'');
    $('#calendar_admin_toast_line3').text(line3||'');
    $toast.stop(true,true).fadeIn(140);
    clearTimeout(toastTimer);
    toastTimer = setTimeout(hideToast, 4500);
  }
  function hideToast(){
    $toast.fadeOut(180);
    clearTimeout(toastTimer); toastTimer = null;
  }
  $('.calendar_admin_toast_close').on('click', hideToast);

  // Openers
  //$('.calendar_admin_details_lesson_information_btn').on('click', openLessonInfo);

  $(document).on('click', '.event.e-green', function () {
  openLessonInfo();
  });


  $('#calendar_admin_details_lesson_information_open_chat').on('click', openChatDrawer);
  $('#calendar_admin_details_lesson_information_cancel_trigger').on('click', openCancelModal);

  // Cancel modal navigation
  $('.calendar_admin_cancel_back').on('click', function(){ $cancel.hide(); $modal.show(); });
  $('.calendar_admin_cancel_close').on('click', closeAll);

  // Reschedule Step 2 navigation
  $('#calendar_admin_cancel_reschedule_btn').on('click', openRescheduleModal);
  $('.calendar_admin_reschedule_back').on('click', function(){ $resched.hide(); $cancel.show(); });
  $('.calendar_admin_reschedule_close').on('click', closeAll);

  // Step 2 -> Step 3
  $('#calendar_admin_reschedule_continue_btn').on('click', openRescheduleConfirm);

  // Step 3 navigation
  $('.calendar_admin_reschedule_confirm_back').on('click', function(){ $res3.hide(); $resched.show(); });

  // Global backdrop + ESC
  $('.calendar_admin_details_lesson_information_close, .calendar_admin_details_lesson_information_drawer_close').on('click', closeAll);
  $backdrop.on('click', function(e){ if (e.target === this) closeAll(); });
  $modal.on('click', function(e){ e.stopPropagation(); });
  $drawer.on('click', function(e){ e.stopPropagation(); });
  $cancel.on('click', function(e){ e.stopPropagation(); });
  $resched.on('click', function(e){ e.stopPropagation(); });
  $res3.on('click', function(e){ e.stopPropagation(); });
  $(document).on('keyup', function(e){ if (e.key === 'Escape') closeAll(); });

  // Textarea auto-grow (chat)
  const $ta = $('.calendar_admin_details_lesson_information_textarea');
  function autosizeTA(el){ el.style.height='auto'; const h=Math.min(el.scrollHeight,160); el.style.height=(h<52?52:h)+'px'; }
  $ta.each(function(){ autosizeTA(this); });
  $ta.on('input', function(){ autosizeTA(this); });

  // Attach -> hidden file picker
  $('#calendar_admin_details_lesson_information_attach').on('click', function(){
    $('#calendar_admin_details_lesson_information_file').trigger('click');
  });

  // ===== 1_1_CLASS Tab (existing behavior for main "View Or Reschedule Lesson" button) =====
  $('#calendar_admin_details_1_1_class').on('click', function () {
      const $mgmt = $('#calendar_admin_details_create_cohort_modal_backdrop');
      const $lesson = $('#calendar_admin_details_lesson_information_backdrop');

      $mgmt.find('.calendar_admin_details_create_cohort_tab').removeClass('active');
      $mgmt.find('.calendar_admin_details_create_cohort_tab[data-tab="class"]').addClass('active');

      $lesson.hide();
      $mgmt.css('z-index', 1065).fadeIn(120);

      $('#calendar_admin_details_create_cohort_content').html('');
      $('#mergeTabContent, #conferenceTabContent, #peerTalkTabContent, #addTimeTabContent, #addExtraSlotsTabContent, #mainModalContent').hide();
      $('#classTabContent').show();
  });

  // ===== Cancel modal action (demo) =====
  $('#calendar_admin_cancel_confirm_btn').on('click', function(){
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
  $('#calendar_admin_reschedule_confirm_new_time').on('click', function(){
    const durationLabel = $('#resched_duration').val();
    const startStr = $('#resched_time').val();
    const endStr   = computeEndTime(startStr, durationLabel);
    const dateStr  = $('#resched_date').val();

    // Build toast lines
    const line2 = 'English with Mary Janes';
    const line3 = (toPrettyDay(dateStr) || 'Date') + ', ' + to24(startStr) + ' – ' + to24(endStr);

    // Close modals, then show toast and open your management modal
//    closeAll();
    setTimeout(function(){
      showToast(line2, line3);
      // Keep your existing flow to open Management modal
//      $('#calendar_admin_details_1_1_class').trigger('click');
    }, 140);
  });

})(jQuery);







// ===== Custom dropdown behavior (Reschedule reason step 3) =====
(function($){
  var $wrap  = $('#resched_reason_dd');
  var $btn   = $wrap.find('.ca_dd_btn');
  var $menu  = $wrap.find('.ca_dd_menu');
  var $ph    = $wrap.find('.ca_dd_placeholder');
  var $valEl = $wrap.find('.ca_dd_value');
  var $hidden= $('#resched_reason_step3');

  function openMenu(){
    $menu.stop(true,true).fadeIn(120);
    $btn.attr('aria-expanded','true');
  }
  function closeMenu(){
    $menu.stop(true,true).fadeOut(120);
    $btn.attr('aria-expanded','false');
  }

  $btn.on('click', function(e){
    e.stopPropagation();
    ($menu.is(':visible') ? closeMenu() : openMenu());
  });

  // Select option
  $menu.on('click', '.ca_dd_opt', function(e){
    var $opt = $(this);
    $menu.find('.ca_dd_opt').removeAttr('aria-selected');
    $opt.attr('aria-selected','true');

    var text  = $opt.text().trim();
    var value = $opt.data('value') || text;

    $hidden.val(value).trigger('change');
    $valEl.text(text).show();
    $ph.hide();
    closeMenu();
  });

  // Click-away / ESC to close
  $(document).on('click', function(){ closeMenu(); });
  $(document).on('keydown', function(e){ if(e.key === 'Escape') closeMenu(); });

  // Optional: set initial value if present
  if ($hidden.val()){
    var v = $hidden.val();
    var $match = $menu.find('.ca_dd_opt').filter(function(){ return $(this).data('value')==v; }).first();
    if ($match.length){
      $valEl.text($match.text().trim()).show(); $ph.hide();
      $match.attr('aria-selected','true');
    }
  }
})(jQuery);

// ===== Custom dropdown just for Duration =====
(function($){
  var $wrap   = $('#resched_duration_dd');
  var $btn    = $wrap.find('.ca_dd_btn');
  var $menu   = $wrap.find('.ca_dd_menu');
  var $ph     = $wrap.find('.ca_dd_placeholder');
  var $valEl  = $wrap.find('.ca_dd_value');
  var $hidden = $('#resched_duration');

  // Open / close menu
  function openMenu(){
    $menu.stop(true,true).fadeIn(120);
    $btn.attr('aria-expanded','true');
  }
  function closeMenu(){
    $menu.stop(true,true).fadeOut(120);
    $btn.attr('aria-expanded','false');
  }

  // Toggle on button click
  $btn.on('click', function(e){
    e.stopPropagation();
    if ($menu.is(':visible')) closeMenu(); else openMenu();
  });

  // Select option
  $menu.on('click', '.ca_dd_opt', function(){
    var $opt = $(this);
    $menu.find('.ca_dd_opt').removeAttr('aria-selected');
    $opt.attr('aria-selected','true');

    var text = $opt.text().trim();
    var val  = $opt.data('value'); // numeric minutes

    $hidden.val(val).trigger('change');
    $valEl.text(text).show();
    $ph.hide();

    closeMenu();
  });

  // Close on outside click / ESC
  $(document).on('click', function(){ closeMenu(); });
  $(document).on('keydown', function(e){ if (e.key === 'Escape') closeMenu(); });

  // Init from hidden value (default 50)
  (function init(){
    var v = $hidden.val();
    var $match = $menu.find('.ca_dd_opt[data-value="'+v+'"]');
    if ($match.length){
      $valEl.text($match.text().trim()).show();
      $ph.hide();
      $match.attr('aria-selected','true');
    }
  })();
})(jQuery);



</script>
