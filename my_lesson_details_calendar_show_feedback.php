  <style>
    .my_lessons_calendar_event {
      display: flex;
      flex-direction: column;
      border: 2px solid #fe4c22;
      border-radius: 13px;
      /* width: 180px;
      padding: 13px 15px 10px 15px;
      margin: 40px; */
      position: relative;
      cursor: pointer;
    }
    .my_lessons_event_avatar {
      width: 40px;
      height: 40px;
      border-radius: 50%;
      margin-bottom: 7px;
    }
    .my_lessons_event_icon {
      position: absolute;
      top: 10px;
      right: 13px;
      font-size: 1.2rem;
      background: #232323;
      color: #fff;
      border-radius: 50%;
      width: 26px;
      height: 26px;
      display: flex;
      align-items: center;
      justify-content: center;
    }
    .my_lessons_event_time {
      font-size: 0.95rem;
      margin-bottom: 2px;
    }
    .my_lessons_event_name {
      font-weight: bold;
      font-size: 1.15rem;
    }

    /* Tooltip CSS */
    #my_lesson_calendar_slot_tooltip_rate {
      position: absolute;
      z-index: 5555;
      display: none;
      width: 15%;
      margin-top: 25%;
    }
    .my_lesson_calendar_slot_tooltip_content {
      background: #fff;
      border-radius: 16px;
      box-shadow: 0 4px 24px rgba(0,0,0,0.14);
      display: flex;
      align-items: center;
      gap: 24px;
      padding: 18px 36px;
      font-size: 1.16rem;
      font-weight: 500;
    }
    .my_lesson_calendar_slot_rate {
      color: #232323;
      font-size: 1.13rem;
      font-weight: 500;
      display: flex;
      align-items: center;
      gap: 10px;
    }
    .my_lesson_calendar_slot_rate i {
      color: #232323;
    }
  </style>


<style>
    #my_lessons_details_show_add_feedback_rating_modal_backdrop {
  display: none;
  position: fixed; inset: 0;
  background: rgba(0,0,0,0.25); z-index: 5999;
}
#my_lessons_details_show_add_feedback_rating_modal {
  display: none;
  position: fixed; left: 50%; top: 50%;
  transform: translate(-50%, -50%);
  width: 96%; max-width: 420px;
  background: #fff;
  border-radius: 16px;
  box-shadow: 0 4px 32px rgba(0,0,0,0.19);
  z-index: 6000;
  text-align: center;
  padding: 32px 20px 24px 20px;
  font-family: inherit;
}
.my_lessons_details_show_add_feedback_rating_close {
  position: absolute;
  right: 18px;
  top: 18px;
  font-size: 2.1rem;
  cursor: pointer;
  font-weight: bold;
}
.my_lessons_details_show_add_feedback_rating_avatar_wrap {
  margin-bottom: 14px;
}
.my_lessons_details_show_add_feedback_rating_avatar {
  width: 72px; height: 72px;
  border-radius: 11px;
  object-fit: cover;
  display: block;
  margin: 0 auto;
}
.my_lessons_details_show_add_feedback_rating_heading {
  font-size: 1.39rem;
  font-weight: 700;
  margin: 10px 0 8px 0;
}
.my_lessons_details_show_add_feedback_rating_subheading {
  color: #888;
  font-size: 1rem;
  margin-bottom: 22px;
}
.my_lessons_details_show_add_feedback_rating_stars {
  font-size: 2.3rem;
  color: #bbb;
  margin-bottom: 32px;
  user-select: none;
}
.my_lessons_details_show_add_feedback_rating_stars .fa-star {
  margin: 0 6px;
  cursor: pointer;
  transition: color 0.18s;
}
.my_lessons_details_show_add_feedback_rating_stars .fa-star.selected {
  color: #232323;
}
#my_lessons_details_show_add_feedback_rating_submit {
  width: 100%;
  margin: 0 auto 15px auto;
  padding: 15px 0;
  background: #fe4c22;
  color: #fff;
  font-size: 1.2rem;
  font-weight: bold;
  border: 2px solid #fe4c22;
  border-radius: 10px;
  cursor: pointer;
  transition: background 0.15s;
  display: block;
}
#my_lessons_details_show_add_feedback_rating_submit:disabled {
  opacity: 0.5;
  cursor: not-allowed;
}
.my_lessons_details_show_add_feedback_rating_skip {
  margin: 8px 0 0 0;
}
.my_lessons_details_show_add_feedback_rating_skip a {
  color: #232323;
  font-size: 1rem;
  font-weight: 600;
  text-decoration: underline;
  cursor: pointer;
}

</style>

<!-- Tooltip HTML -->
<div id="my_lesson_calendar_slot_tooltip_rate" style="display:none;">
  <div class="my_lesson_calendar_slot_tooltip_content">
    <span class="my_lesson_calendar_slot_rate">
      <i class="fas fa-star"></i> Rate
    </span>
  </div>
</div>







<!-- Feedback/Rating Modal -->
<div id="my_lessons_details_show_add_feedback_rating_modal_backdrop" style="display:none;"></div>
<div id="my_lessons_details_show_add_feedback_rating_modal" style="display:none;">
  <span class="my_lessons_details_show_add_feedback_rating_close">&times;</span>
  <div class="my_lessons_details_show_add_feedback_rating_avatar_wrap">
    <img src="https://randomuser.me/api/portraits/women/4.jpg" class="my_lessons_details_show_add_feedback_rating_avatar" alt="Tutor">
  </div>
  <div class="my_lessons_details_show_add_feedback_rating_heading">
    How did it go with <span id="my_lessons_details_show_add_feedback_rating_tutorname">Daniela</span>?
  </div>
  <div class="my_lessons_details_show_add_feedback_rating_subheading">
    Your feedback is anonymous and helps us improve.
  </div>
  <div class="my_lessons_details_show_add_feedback_rating_stars">
    <i class="fas fa-star" data-star="1"></i>
    <i class="fas fa-star" data-star="2"></i>
    <i class="fas fa-star" data-star="3"></i>
    <i class="fas fa-star" data-star="4"></i>
    <i class="fas fa-star" data-star="5"></i>
  </div>
  <button id="my_lessons_details_show_add_feedback_rating_submit" style="display:none;">
    Rate lesson
  </button>
  <div class="my_lessons_details_show_add_feedback_rating_skip">
    <a href="#" id="my_lessons_details_show_add_feedback_rating_skip_link">Skip rating</a>
  </div>
</div>














<script>
$(function() {
  // Hide the tooltip when clicking outside
  $(document).on('mousedown', function(e) {
    if (!$(e.target).closest('#my_lesson_calendar_slot_tooltip_rate, .my_lessons_calendar_event.my_lessons_event_single').length) {
      $('#my_lesson_calendar_slot_tooltip_rate').hide();
    }
  });

  // Show the Rate tooltip when clicking the "Mary Janes" event slot
  $('.my_lessons_calendar_event.my_lessons_event_single').on('click', function(e) {
    e.stopPropagation();

    // Hide others
    $('#my_lesson_calendar_slot_tooltip_rate').hide();

    const $tooltip = $('#my_lesson_calendar_slot_tooltip_rate');
    const offset = $(this).offset();
    const eventWidth = $(this).outerWidth();
    const top = offset.top + ($(this).outerHeight() / 2) - 32;
    const left = offset.left + eventWidth + 16;

    $tooltip.css({
      top: top + 'px',
      left: left + 'px',
      display: 'block'
    });
  });
});
</script>


<script>
    $(function() {
  // Tooltip existing code...

  // 1. Show the Rate tooltip
  $('.my_lessons_calendar_event.my_lessons_event_single').on('click', function(e) {
    e.stopPropagation();

    $('#my_lesson_calendar_slot_tooltip_rate').hide();

    const $tooltip = $('#my_lesson_calendar_slot_tooltip_rate');
    const offset = $(this).offset();
    const eventWidth = $(this).outerWidth();
    const top = offset.top + ($(this).outerHeight() / 2) - 32;
    const left = offset.left + eventWidth + 16;

    $tooltip.css({
      top: top + 'px',
      left: left + 'px',
      display: 'block'
    });
  });

  // 2. Hide the tooltip when clicking outside
  $(document).on('mousedown', function(e) {
    if (!$(e.target).closest('#my_lesson_calendar_slot_tooltip_rate, .my_lessons_calendar_event.my_lessons_event_single').length) {
      $('#my_lesson_calendar_slot_tooltip_rate').hide();
    }
  });

  // 3. Open feedback/rating modal when clicking tooltip
  $('#my_lesson_calendar_slot_tooltip_rate').on('click', function(e) {
    e.stopPropagation();
    $(this).hide();
    $('#my_lessons_details_show_add_feedback_rating_modal_backdrop, #my_lessons_details_show_add_feedback_rating_modal').fadeIn(150);

    // Optionally set tutor name and avatar dynamically here if needed
    // $('#my_lessons_details_show_add_feedback_rating_tutorname').text('Daniela');
    // $('.my_lessons_details_show_add_feedback_rating_avatar').attr('src', '...');
  });

  // 4. Hide modal on close or skip
  $('.my_lessons_details_show_add_feedback_rating_close, #my_lessons_details_show_add_feedback_rating_modal_backdrop, #my_lessons_details_show_add_feedback_rating_skip_link').on('click', function(e) {
    e.preventDefault();
    $('#my_lessons_details_show_add_feedback_rating_modal_backdrop, #my_lessons_details_show_add_feedback_rating_modal').fadeOut(150);
    // Reset stars and button
    $('.my_lessons_details_show_add_feedback_rating_stars .fa-star').removeClass('selected');
    $('#my_lessons_details_show_add_feedback_rating_submit').hide();
  });

  // 5. Star selection logic
  $('.my_lessons_details_show_add_feedback_rating_stars .fa-star').on('click', function() {
    var selected = $(this).data('star');
    $('.my_lessons_details_show_add_feedback_rating_stars .fa-star').removeClass('selected');
    // Select all stars up to and including this one
    $('.my_lessons_details_show_add_feedback_rating_stars .fa-star').each(function(i){
      if(i < selected) $(this).addClass('selected');
    });
    // If all 5 stars are selected, show the Rate button
    if(selected == 5){
      $('#my_lessons_details_show_add_feedback_rating_submit').show();
    } else {
      $('#my_lessons_details_show_add_feedback_rating_submit').hide();
    }
  });
});

</script>
