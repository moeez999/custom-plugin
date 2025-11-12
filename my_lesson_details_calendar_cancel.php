<!-- 3) Overlay -->
<div id="my_lesson_details_cancel_overlay" class="my_lesson_details_cancel__overlay"></div>
<!-- 4) Modal container -->
<div id="my_lesson_details_cancel_modal"
     class="my_lesson_details_cancel__modal">
     
  <!-- Step 1: Cancel Lesson -->
  <div class="modal-step my_lesson_details_cancel__step1" data-step="1">
    <div class="my_lesson_details_cancel__header">
      <button type="button"
              class="my_lesson_details_cancel__back"
              aria-label="Go Back">←
      </button>
      <button type="button"
              class="my_lesson_details_cancel__close"
              aria-label="Close">×
      </button>
    </div>
    <div class="my_lesson_details_cancel__body">
      <div class="my_lesson_details_cancel__avatar">
        <img src="https://via.placeholder.com/48" alt="Teacher Avatar">
      </div>
      <h2 class="my_lesson_details_cancel__title">Cancel Lesson</h2>
      <p class="my_lesson_details_cancel__date">
        Wednesday, November 20, 07:00–08:50 PM
      </p>

      <div class="my_lesson_details_cancel__form-group">
        <label for="my_lesson_details_cancel_reason">
          Please choose a reason for cancel lesson
        </label>
        <div class="my_lesson_details_cancel__select-wrapper">
          <select id="my_lesson_details_cancel_reason"
                  class="my_lesson_details_cancel__select">
            <option value="" disabled selected>Select Reason</option>
            <option value="sick">I’m sick</option>
            <option value="emergency">Family emergency</option>
            <option value="other">Other</option>
          </select>
          <span class="my_lesson_details_cancel__select-arrow">▾</span>
        </div>
      </div>

      <div class="my_lesson_details_cancel__form-group">
        <label for="my_lesson_details_cancel_message">
          Message for Daniela • Optional
        </label>
        <textarea id="my_lesson_details_cancel_message"
                  class="my_lesson_details_cancel__textarea"
                  placeholder="Message for Daniela"></textarea>
      </div>
    </div>

    <div class="my_lesson_details_cancel__actions">
      <a href="my_lessons_details_reshedule.php"><button type="button"
              class="my_lesson_details_cancel__btn my_lesson_details_cancel__btn--outline">
        Reschedule instead
      </button></a>
      <button type="button"
              class="my_lesson_details_cancel__btn my_lesson_details_cancel__btn--danger">
        Confirm Cancel
      </button>
    </div>
  </div>

  <!-- Future steps (e.g. step2, step3…) go here, each with class="modal-step" -->
</div>

<!-- 5) Styles (same as before) -->
<style>
  .my_lesson_details_cancel__overlay {
    display: none; position: fixed; inset: 0;
    background: rgba(0,0,0,0.4); z-index: 999;
  }
  .my_lesson_details_cancel__modal {
    display: none; position: fixed; top:50%; left:50%;
    width:90%; max-width:500px;
    background:#fff; border-radius:8px;
    transform:translate(-50%,-50%);
    z-index:1000;
    box-shadow:0 8px 24px rgba(0,0,0,0.2);
    overflow:hidden; font-family:sans-serif;
  }
  .my_lesson_details_cancel__header {
    display:flex; justify-content:space-between;
    align-items:center; padding:12px 16px;
    border-bottom:1px solid #eee;
  }
  .my_lesson_details_cancel__back,
  .my_lesson_details_cancel__close {
    background:none; border:none; font-size:20px;
    cursor:pointer;
  }
  .my_lesson_details_cancel__body { padding:16px; }
  .my_lesson_details_cancel__avatar img {
    width:48px; height:48px; border-radius:50%;
    object-fit:cover;
  }
  .my_lesson_details_cancel__title {
    margin:12px 0 4px; font-size:1.5rem;
  }
  .my_lesson_details_cancel__date {
    color:#666; font-size:0.9rem; margin-bottom:16px;
  }
  .my_lesson_details_cancel__form-group {
    margin-bottom:16px;
  }
  .my_lesson_details_cancel__form-group label {
    display:block; margin-bottom:4px;
    font-weight:500; font-size:0.9rem;
  }
  .my_lesson_details_cancel__select-wrapper {
    position:relative;
  }
  .my_lesson_details_cancel__select {
    width:100%;
    padding:10px 36px 10px 12px;
    font-size:1rem;
    border:1px solid #ccc;
    border-radius:6px;
    appearance:none;
    background:#fff;
  }
  .my_lesson_details_cancel__select-arrow {
    position:absolute; right:12px;
    top:50%; transform:translateY(-50%);
    pointer-events:none;
  }
  .my_lesson_details_cancel__textarea {
    width:100%; min-height:80px;
    padding:10px 12px; font-size:1rem;
    border:1px solid #ccc; border-radius:6px;
    resize:vertical;
  }
  .my_lesson_details_cancel__actions {
    display:flex; justify-content:space-between;
    padding:16px; border-top:1px solid #eee;
  }
  .my_lesson_details_cancel__btn {
    flex:1; padding:10px 0; font-size:1rem;
    border-radius:6px; cursor:pointer;
    border:1px solid transparent; margin:0 4px;
  }
  .my_lesson_details_cancel__btn--outline {
    background:#fff; color:#000; border-color:#000;
  }
  .my_lesson_details_cancel__btn--danger {
    background:#ff3b30; color:#fff; border-color:#ff3b30;
  }
</style>

<!-- 6) jQuery to open Step 1 only -->
<script>
  $(function(){
    // Open modal & show Step 1
    $('.my_lesson_details_cancel__open').on('click', function(e){
      e.preventDefault();
      $('#my_lesson_details_cancel_overlay, #my_lesson_details_cancel_modal').fadeIn(200);
      // hide all steps, then show step1
      $('#my_lesson_details_cancel_modal .modal-step').hide();
      $('#my_lesson_details_cancel_modal .my_lesson_details_cancel__step1').show();
    });

    // Close modal (back, X or overlay)
    $('#my_lesson_details_cancel_overlay, .my_lesson_details_cancel__close, .my_lesson_details_cancel__back')
      .on('click', function(){
        $('#my_lesson_details_cancel_overlay, #my_lesson_details_cancel_modal').fadeOut(200);
      });
  });
</script>
