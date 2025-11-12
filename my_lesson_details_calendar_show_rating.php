<style>
  #my_lesson_calendar_slot_tooltip {
  position: absolute;
  z-index: 5555;
  display: none;
  margin-top: 22%;

}
.my_lesson_calendar_slot_tooltip_content {
  background: #fff;
  border-radius: 16px;
  box-shadow: 0 4px 24px rgba(0,0,0,0.14);
  display: flex;
  align-items: center;
  gap: 24px;
  padding: 18px 30px;
  font-size: 1.16rem;
  font-weight: 500;
}
.my_lesson_calendar_slot_paid {
  background: #e6faf2;
  color: #0e6655;
  border-radius: 8px;
  padding: 4px 16px;
  font-size: 1.04rem;
  font-weight: 500;
}
.my_lesson_calendar_slot_rating {
  color: #232323;
  font-size: 1.13rem;
  font-weight: 500;
  display: flex;
  align-items: center;
  gap: 7px;
}
.my_lesson_calendar_slot_rating i {
  color: #232323;
}

</style>


<!-- Mary Janes Slot Tooltip -->
<div id="my_lesson_calendar_slot_tooltip" style="display:none;">
  <div class="my_lesson_calendar_slot_tooltip_content">
    <span class="my_lesson_calendar_slot_paid">Paid $5.40</span>
    <span class="my_lesson_calendar_slot_rating">
      <i class="fas fa-star"></i> 4
    </span>
  </div>
</div>

<script>
  $(function() {
  // Hide tooltip when clicking outside
  $(document).on('mousedown', function(e) {
    if (!$(e.target).closest('#my_lesson_calendar_slot_tooltip, .my_lessons_calendar_event.my_lessons_event_confirmed').length) {
      $('#my_lesson_calendar_slot_tooltip').hide();
    }
  });

  // Show the tooltip when clicking the Mary Janes "confirmed" event slot
  $('.my_lessons_calendar_event.my_lessons_event_confirmed').on('click', function(e) {
    e.stopPropagation();
    const $tooltip = $('#my_lesson_calendar_slot_tooltip');
    const offset = $(this).offset();
    const eventWidth = $(this).outerWidth();
    const tooltipWidth = $tooltip.outerWidth();
    const top = offset.top + ($(this).outerHeight() / 2) - 28; // vertically center-ish
    const left = offset.left + eventWidth + 14; // right side of event

    $tooltip.css({
      top: top + 'px',
      left: left + 'px',
      display: 'block'
    });
  });
});

</script>
