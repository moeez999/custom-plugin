<!-- ===== Reschedule Modal (narrow, left-aligned, top-left SVG) ===== -->
<style>
  #my_lessons_reschedule_details_lesson_modal_content_overlay{
    position:fixed; inset:0; z-index:1000; display:none;
  }
  #my_lessons_reschedule_details_lesson_modal_content_backdrop{
    position:absolute; inset:0; background:rgba(0,0,0,.50);
  }
  .my_lessons_reschedule_center{
    position:absolute; inset:0; display:flex; align-items:center; justify-content:center; padding:16px;
  }

  /* Card — narrower + left-aligned */
  #my_lessons_reschedule_details_lesson_modal_content_modal{
    width:315px;          /* ⬅️ narrower to match your shot */
    max-width:92vw;
    background:#fff; border:1px solid #E6E7EF; border-radius:12px;
    box-shadow:0 12px 32px rgba(16,18,27,.18);
    padding:18px 20px 16px;
    position:relative;
    font-family:Inter, system-ui, -apple-system, Segoe UI, Roboto, Helvetica, Arial;
    text-align:left;      /* ensure left alignment */
  }

  /* Close (X) */
  #my_lessons_reschedule_details_lesson_modal_content_close{
    position:absolute; top:10px; right:10px; width:32px; height:32px;
    border:0; background:transparent; cursor:pointer; display:grid; place-items:center;
    color:#5f6570; font-size:18px; line-height:1;
  }
  #my_lessons_reschedule_details_lesson_modal_content_close:hover{ color:#111; }


  /* Title + copy (left) */
  .my_lessons_reschedule_title{
    margin:0; color:#0f1115; font-weight:600; letter-spacing:-.2px;
    font-size:20px; line-height:28px;
  }
  .my_lessons_reschedule_desc{
    margin:8px 0 12px; color:#5f6570; font-size:14px; line-height:22px;
  }

  /* Textarea */
  #my_lessons_reschedule_details_lesson_modal_content_textarea{
    width:100%; min-height:112px; resize:vertical; outline:0;
    border:1.5px solid #D9DBE3; border-radius:12px;
    padding:12px; font-size:15px; line-height:22px; color:#0f1115;
  }
  #my_lessons_reschedule_details_lesson_modal_content_textarea::placeholder{ color:#9aa0a6; }
  #my_lessons_reschedule_details_lesson_modal_content_textarea:focus{ border-color:#111; }

  /* Actions */
  .my_lessons_reschedule_actions{ display:flex; justify-content:flex-start; gap:12px; margin-top:14px; }
  .mylessons-btn{ height:44px; padding:0 18px; border-radius:5px; font-weight:700; font-size:13px; }

  #my_lessons_reschedule_details_lesson_modal_content_cancel{
    background:#fff; color:#111; border:2px solid #111;
  }
  #my_lessons_reschedule_details_lesson_modal_content_cancel:hover{ background:#f6f6f6; }

  /* Disabled matches snapshot */
  #my_lessons_reschedule_details_lesson_modal_content_confirm{
    border:2px solid #CFD3DC; background:#E9EAF1; color:#6B7280;
    cursor:not-allowed; box-shadow:inset 0 -1px 0 rgba(0,0,0,.04);
  }
  #my_lessons_reschedule_details_lesson_modal_content_confirm.enabled{
    background:#ff3b1f; border-color:#ff3b1f; color:#fff; cursor:pointer; box-shadow:none;
  }
  #my_lessons_reschedule_details_lesson_modal_content_confirm.enabled:hover{ opacity:.92; }





  #my_lessons_reschedule_details_lesson_modal_content_confirm{
    border:2px solid #CFD3DC; background:#E9EAF1; color:#6B7280;
    cursor:not-allowed; box-shadow:inset 0 -1px 0 rgba(0,0,0,.04);
  }
  /* ✅ When enabled (textarea has text): red bg + 2px BLACK border */
  #my_lessons_reschedule_details_lesson_modal_content_confirm.enabled{
    background:#ff3b1f; border-color:#111; color:#fff; cursor:pointer; box-shadow:none;
  }
  #my_lessons_reschedule_details_lesson_modal_content_confirm.enabled:hover{ opacity:.92; }


.my_lessons_reschedule_icon{
  margin:0 0 12px 0;
  width:28px; height:28px;
}
.my_lessons_reschedule_icon img{
  width:28px; height:28px;
  display:block;
  margin-top: 30px;
}

</style>

<div id="my_lessons_reschedule_details_lesson_modal_content_overlay" aria-hidden="true">
  <div id="my_lessons_reschedule_details_lesson_modal_content_backdrop"></div>

  <div class="my_lessons_reschedule_center">
    <div id="my_lessons_reschedule_details_lesson_modal_content_modal" role="dialog" aria-modal="true" aria-labelledby="my_lessons_reschedule_details_lesson_modal_content_title">

      <!-- TOP-LEFT SVG ICON (inline) -->
      <div class="my_lessons_reschedule_icon" aria-hidden="true">
        
      
  <img src="img/reschedule_lesson.svg" alt="Reschedule Icon">


      </div>

      <!-- Close -->
      <button id="my_lessons_reschedule_details_lesson_modal_content_close" aria-label="Close modal">×</button>

      <!-- Title + description (left-aligned under the icon) -->
      <h2 id="my_lessons_reschedule_details_lesson_modal_content_title" class="my_lessons_reschedule_title">
        Rescheduling the lesson
      </h2>
      <p class="my_lessons_reschedule_desc">
        Tell your tutor why the new time works better for you. It helps to organize your learning process properly.
      </p>

      <!-- Textarea -->
      <textarea id="my_lessons_reschedule_details_lesson_modal_content_textarea"
                placeholder="Sorry, I have an urgent need to …"></textarea>

      <!-- Actions (left) -->
      <div class="my_lessons_reschedule_actions">
        <button id="my_lessons_reschedule_details_lesson_modal_content_cancel" class="mylessons-btn" type="button">
          Don’t reschedule
        </button>
        <button id="my_lessons_reschedule_details_lesson_modal_content_confirm" class="mylessons-btn" type="button" disabled>
          Reschedule
        </button>
      </div>
    </div>
  </div>
</div>

<script>
  $(function () {
    const $cta        = $('#my_lessons_details_reshedule_cta');
    const $overlay    = $('#my_lessons_reschedule_details_lesson_modal_content_overlay');
    const $backdrop   = $('#my_lessons_reschedule_details_lesson_modal_content_backdrop');
    const $modal      = $('#my_lessons_reschedule_details_lesson_modal_content_modal');
    const $close      = $('#my_lessons_reschedule_details_lesson_modal_content_close');
    const $cancel     = $('#my_lessons_reschedule_details_lesson_modal_content_cancel');
    const $textarea   = $('#my_lessons_reschedule_details_lesson_modal_content_textarea');
    const $confirmBtn = $('#my_lessons_reschedule_details_lesson_modal_content_confirm');

    function showOverlay(show){
      if(show){
        $overlay.show();
        $modal.css({opacity:0, transform:'translateY(12px)'}).animate({opacity:1}, 140, function(){
          $(this).css('transform','translateY(0)');
        });
        setTimeout(()=> $textarea.trigger('focus'), 30);
      }else{
        $overlay.hide();
      }
    }

    function updateConfirm(){
      const hasText = $.trim($textarea.val()).length > 0;
      $confirmBtn.prop('disabled', !hasText).toggleClass('enabled', hasText);
    }

    $cta.on('click', function(e){ e.preventDefault(); showOverlay(true); });
    $backdrop.on('click', ()=> showOverlay(false));
    $close.on('click',    ()=> showOverlay(false));
    $cancel.on('click',   ()=> showOverlay(false));
    $(document).on('keydown', function(e){ if(e.key==='Escape' && $overlay.is(':visible')) showOverlay(false); });

    $modal.on('click', function(e){ e.stopPropagation(); });

    $textarea.on('input', updateConfirm);
    updateConfirm();
  });
</script>
