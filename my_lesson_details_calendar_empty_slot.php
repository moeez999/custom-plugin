<style>
.my_lessons_calendar_slot_empty {
  cursor: pointer;
  background: #fff; /* or your calendar's background */
  transition: background 0.18s;
  position: relative;
}
.my_lessons_calendar_slot_empty:hover {
  background: #f5f7fa; /* subtle highlight */
}


  #my_lessons_tutor_select_modal_backdrop {
  display:none; position:fixed; top:0; left:0; width:100vw; height:100vh;
  background: rgba(0,0,0,0.11); z-index: 1999;
}
#my_lessons_tutor_select_modal {
  display:none; position:fixed; top:50%; left:50%; transform:translate(-50%,-50%);
  width:430px; max-width:96vw;
  background:#fff; border-radius:16px; box-shadow:0 8px 32px rgba(0,0,0,0.16);
  z-index:2000; padding:0;
}
.my_lessons_tutor_select_modal_header {
  display:flex; justify-content:space-between; align-items:center;
  padding:28px 36px 10px 36px;
}
.modal_title {
  font-size:2.2rem; font-weight:bold;
}
.my_lessons_tutor_select_modal_content {
  padding:12px 36px 36px 36px;
}
.tutor_row {
  display:flex; align-items:center; justify-content:space-between;
  padding:18px 0; border-bottom:1px solid #eee; cursor:pointer;
  transition:background 0.13s;
}
.tutor_row:last-child { border-bottom:none; }
.tutor_row:hover { background:#fafaff; }
.tutor_avatar {
  width:48px; height:48px; border-radius:50%; margin-right:18px;
}
.tutor_name { font-size:1.12rem; font-weight:500; }
.tutor_lessons { font-size:0.97rem; color:#888; }
.tutor_arrow { font-size:1.7rem; color:#bbb; }
.close_tutor_modal { line-height:1; }

</style>

<!-- Tutor Selection Modal & Backdrop -->
<div id="my_lessons_tutor_select_modal_backdrop" style="display:none;"></div>
<div id="my_lessons_tutor_select_modal" style="display:none;">
  <div class="my_lessons_tutor_select_modal_header">
    <span class="modal_title">Which tutor?</span>
    <span class="close_tutor_modal" style="cursor:pointer;font-size:1.7rem;font-weight:bold;">&times;</span>
  </div>
  <div class="my_lessons_tutor_select_modal_content">

  <a href="my_lesson_tutor_profile_detail_schedule_lesson.php">
  <div class="tutor_row">

      <img src="https://randomuser.me/api/portraits/women/68.jpg" class="tutor_avatar"/>
      <div>
        <div class="tutor_name">Daniela</div>
        <div class="tutor_lessons">11 lessons to schedule</div>
      </div>
      <span class="tutor_arrow"><svg width="22" height="22" viewBox="0 0 24 24">
                    <polyline points="15 19 8 12 15 5" fill="none" stroke="#111" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></polyline>
                </svg></span>
    </div>
</a>    
    <div class="tutor_row">
      <img src="https://randomuser.me/api/portraits/men/15.jpg" class="tutor_avatar"/>
      <div>
        <div class="tutor_name">Wade Warren</div>
        <div class="tutor_lessons">0 lessons to schedule</div>
      </div>
      <span class="tutor_arrow"><svg width="22" height="22" viewBox="0 0 24 24">
                    <polyline points="15 19 8 12 15 5" fill="none" stroke="#111" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></polyline>
                </svg></span>
    </div>
    <div class="tutor_row">
      <img src="https://randomuser.me/api/portraits/men/30.jpg" class="tutor_avatar"/>
      <div>
        <div class="tutor_name">Albert Flores</div>
        <div class="tutor_lessons">1 lesson to schedule</div>
      </div>
      <span class="tutor_arrow"><svg width="22" height="22" viewBox="0 0 24 24">
                    <polyline points="15 19 8 12 15 5" fill="none" stroke="#111" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></polyline>
                </svg></span>
    </div>
    <div class="tutor_row">
      <img src="https://randomuser.me/api/portraits/women/44.jpg" class="tutor_avatar"/>
      <div>
        <div class="tutor_name">Annette Black</div>
        <div class="tutor_lessons">0 lessons to schedule</div>
      </div>
      <span class="tutor_arrow"><svg width="22" height="22" viewBox="0 0 24 24">
                    <polyline points="15 19 8 12 15 5" fill="none" stroke="#111" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></polyline>
                </svg></span>
    </div>
    <div class="tutor_row">
      <img src="https://randomuser.me/api/portraits/women/18.jpg" class="tutor_avatar"/>
      <div>
        <div class="tutor_name">Daniel A.</div>
        <div class="tutor_lessons">0 lessons to schedule</div>
      </div>
      <span class="tutor_arrow"><svg width="22" height="22" viewBox="0 0 24 24">
                    <polyline points="15 19 8 12 15 5" fill="none" stroke="#111" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></polyline>
                </svg></span>
    </div>
  </div>
</div>


<script>
  $(function() {
  // 1. Open modal when clicking on empty slot
  $('.my_lessons_calendar_slot_empty').on('click', function(e) {
    $('#my_lessons_tutor_select_modal_backdrop, #my_lessons_tutor_select_modal').fadeIn(180);
  });

  // 2. Close modal
  $('.close_tutor_modal, #my_lessons_tutor_select_modal_backdrop').on('click', function() {
    $('#my_lessons_tutor_select_modal_backdrop, #my_lessons_tutor_select_modal').fadeOut(180);
  });
});

</script>