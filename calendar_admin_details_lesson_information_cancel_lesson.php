
<!-- ====== Cancel Lesson Modal (independent) ====== -->
<div id="calendar_admin_details_lesson_information_cancel_backdrop" class="calendar_admin_details_lesson_information_scope" style="display:none;">
  <div class="calendar_admin_details_lesson_information_cancel_modal" role="dialog" aria-modal="true" aria-labelledby="cali_cancel_title">

    <!-- Top bar -->
    <div class="calendar_admin_details_lesson_information_cancel_topbar">
      <button type="button" class="calendar_admin_details_lesson_information_cancel_back" aria-label="Back">
        <svg width="22" height="22" viewBox="0 0 24 24"><path d="M15 6l-6 6 6 6" fill="none" stroke="#111" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg>
      </button>
      <div class="calendar_admin_details_lesson_information_cancel_brand">Latingles Designs</div>
      <button type="button" class="calendar_admin_details_lesson_information_cancel_close" aria-label="Close">
        <svg width="22" height="22" viewBox="0 0 24 24"><path d="M6 6l12 12M18 6L6 18" stroke="#111" stroke-width="2" stroke-linecap="round"/></svg>
      </button>
    </div>

    <!-- Body -->
    <div class="calendar_admin_details_lesson_information_cancel_body">
      <h1 id="cali_cancel_title" class="calendar_admin_details_lesson_information_cancel_h1">Are You Sure You Want To Cancel?</h1>

      <p class="calendar_admin_details_lesson_information_cancel_desc">
        Please note that the lesson <strong>Tuesday , Sep 03 7:00 – 7:25 with jonas</strong> will be canceled and will not be rescheduled.
        This cancellation is final, and there will be no makeup session. Let us know if any further action is needed.
      </p>

      <label class="calendar_admin_details_lesson_information_cancel_label">Please choose a reason for cancel lesson</label>
      <div class="calendar_admin_details_lesson_information_inputwrap">
        <select class="calendar_admin_details_lesson_information_select">
          <option value="">Select Reason</option>
          <option>Teacher unavailable</option>
          <option>Student requested cancel</option>
          <option>Emergency</option>
          <option>Other</option>
        </select>
        <svg class="calendar_admin_details_lesson_information_select_caret" width="18" height="18" viewBox="0 0 24 24"><path d="M6 9l6 6 6-6" fill="none" stroke="#555" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg>
      </div>

      <label class="calendar_admin_details_lesson_information_cancel_label">Message for Daniela • Optional</label>
      <textarea class="calendar_admin_details_lesson_information_textarea_long" rows="3" placeholder="Message for Daniela"></textarea>

      <label class="calendar_admin_details_lesson_information_checkbox">
        <input type="checkbox">
        <span>I know my position will decrease and fewer students will see</span>
      </label>

      <button type="button" class="calendar_admin_details_lesson_information_btn_secondary w-100">
        Reschedule lesson
      </button>

      <button type="button" class="calendar_admin_details_lesson_information_btn_danger w-100" id="calendar_admin_details_lesson_information_confirm_cancel">
        Confirm Cancel
      </button>
    </div>
  </div>
</div>

<style>
/* Backdrop + centering */
#calendar_admin_details_lesson_information_cancel_backdrop.calendar_admin_details_lesson_information_scope{
  position: fixed; inset: 0; z-index: 3000;
  display: none; align-items: center; justify-content: center; padding: 18px;
  background: rgba(0,0,0,.45);
}

/* Modal shell */
.calendar_admin_details_lesson_information_cancel_modal{
  width: 100%; max-width: 640px; background:#fff;
  border:1px solid #e9e9f0; border-radius:12px; overflow:hidden;
  box-shadow:0 20px 50px rgba(0,0,0,.12); display:flex; flex-direction:column;
}

/* Top bar */
.calendar_admin_details_lesson_information_cancel_topbar{
  display:flex; align-items:center; justify-content:space-between;
  padding:12px 14px; border-bottom:1px solid #efeff5; background:#fff;
}
.calendar_admin_details_lesson_information_cancel_back,
.calendar_admin_details_lesson_information_cancel_close{
  background:transparent; border:0; width:36px; height:36px; border-radius:8px; display:grid; place-items:center; cursor:pointer;
}
.calendar_admin_details_lesson_information_cancel_brand{ font-weight:700; color:#7b7f88; }

/* Body & Typography */
.calendar_admin_details_lesson_information_cancel_body{ padding:18px; }
.calendar_admin_details_lesson_information_cancel_h1{ margin:6px 0 8px; font-size:2rem; font-weight:800; line-height:1.2; color:#111; }
.calendar_admin_details_lesson_information_cancel_desc{ color:#444; line-height:1.55; margin-bottom:18px; }

/* Inputs */
.calendar_admin_details_lesson_information_cancel_label{ font-weight:700; color:#222; margin:8px 0 8px; display:block; }
.calendar_admin_details_lesson_information_inputwrap{ position:relative; margin-bottom:14px; }
.calendar_admin_details_lesson_information_select{
  -webkit-appearance:none; appearance:none; width:100%;
  padding:14px 44px 14px 14px; border:1px solid #e1e3eb; border-radius:10px; background:#fff; color:#111; outline:none;
}
.calendar_admin_details_lesson_information_select_caret{ position:absolute; right:12px; top:50%; transform:translateY(-50%); pointer-events:none; }
.calendar_admin_details_lesson_information_textarea_long{
  width:100%; border:1px solid #e1e3eb; border-radius:10px; padding:12px 14px; outline:none;
  min-height:96px; resize:vertical; color:#111; background:#fff; margin-bottom:14px;
}

/* Checkbox */
.calendar_admin_details_lesson_information_checkbox{ display:flex; gap:10px; align-items:flex-start; margin:8px 0 16px; color:#222; }
.calendar_admin_details_lesson_information_checkbox input{ width:18px; height:18px; margin-top:3px; }

/* Buttons */
.calendar_admin_details_lesson_information_btn_secondary{
  background:#fff; color:#111; border:1.25px solid #e7e7ef;
  border-radius:10px; padding:12px 16px; font-weight:700; margin-bottom:12px; width:100%;
}
.calendar_admin_details_lesson_information_btn_danger{
  background:#ef2d17; color:#fff; border:0; border-radius:10px; padding:12px 16px;
  font-weight:800; box-shadow:0 10px 26px rgba(239,45,23,.25); width:100%;
}
.w-100{ width:100%; }

@media (max-width: 430px){
  .calendar_admin_details_lesson_information_cancel_h1{ font-size:1.7rem; }
}
</style>

<script>
/* Independent open/close (no dependency on other modals) */
(function($){
  const $cancel = $('#calendar_admin_details_lesson_information_cancel_backdrop');

  // Open on any trigger click (delegated)
  $(document).on('click', '#calendar_admin_details_lesson_information_cancel_trigger', function(e){
    e.preventDefault();
    $cancel.css('display','flex').hide().fadeIn(120);
  });

  // Close handlers
  $(document).on('click', '#calendar_admin_details_lesson_information_cancel_backdrop .calendar_admin_details_lesson_information_cancel_close', function(){
    $cancel.fadeOut(100);
  });
  $(document).on('click', '#calendar_admin_details_lesson_information_cancel_backdrop .calendar_admin_details_lesson_information_cancel_back', function(){
    $cancel.fadeOut(100);  // back just closes this modal
  });
  // Click outside to close
  $('#calendar_admin_details_lesson_information_cancel_backdrop').on('click', function(e){
    if (e.target === this) $cancel.fadeOut(100);
  });

  // Confirm cancel (demo: just close)
  $(document).on('click', '#calendar_admin_details_lesson_information_confirm_cancel', function(){
    // TODO: replace with your submit/AJAX
    $cancel.fadeOut(120);
  });

  // Esc to close
  $(document).on('keyup', function(e){ if(e.key === 'Escape') $cancel.fadeOut(100); });
})(jQuery);
</script>
