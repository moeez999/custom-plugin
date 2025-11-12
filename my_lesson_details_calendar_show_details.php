<style>
  #my_lesson_calendar_slots_menu {
  position: absolute;
  min-width: 240px;
  background: #fff;
  border-radius: 14px;
  box-shadow: 0 4px 32px rgba(0,0,0,0.14);
  padding: 10px 0;
  z-index: 5000;
  display: none;
  font-family: inherit;
  margin-left:10%;  
}
#my_lesson_calendar_slots_menu ul {
  list-style: none;
  margin: 0;
  padding: 0;
}
#my_lesson_calendar_slots_menu li {
  display: flex;
  align-items: center;
  gap: 12px;
  padding: 13px 24px 13px 22px;
  font-size: 1.07rem;
  color: #1a1a1a;
  cursor: pointer;
  transition: background 0.13s;
  border-radius: 7px;
}
#my_lesson_calendar_slots_menu li:hover {
  background: #f5f7fa;
}
#my_lesson_calendar_slots_menu li i {
  font-size: 1.19rem;
}
#my_lesson_calendar_slots_menu li:last-child {
  color: #e74c3c;
}

</style>

<!-- Calendar Slot Context Menu -->
<div id="my_lesson_calendar_slots_menu" style="display:none;">
  <ul>
    <li class="my_lesson_calendar_slots_menu_reschedule">
      <i class="fas fa-calendar-alt"></i> Reschedule
    </li>
    <li class="my_lesson_calendar_slots_menu_message">
      <i class="fas fa-comment-dots"></i> Message Tutor
    </li>
    <li class="my_lesson_calendar_slots_menu_profile">
      <i class="fas fa-user"></i> See Tutor Profile
    </li>
    <li class="my_lesson_calendar_slots_menu_cancel">
      <i class="fas fa-ban" style="color:#e74c3c;"></i> Cancel
    </li>
  </ul>
</div>

<script>

  $(function() {
  // Hide menu if anywhere else is clicked
  $(document).on('mousedown', function(e) {
    if (!$(e.target).closest('#my_lesson_calendar_slots_menu, .my_lessons_calendar_event.my_lessons_event_weekly').length) {
      $('#my_lesson_calendar_slots_menu').hide();
    }
    
  });

  // Show the context menu when clicking on the weekly event
  $('.my_lessons_calendar_event.my_lessons_event_weekly').on('click', function(e) {
    e.stopPropagation();
    const $menu = $('#my_lesson_calendar_slots_menu');
    // Get click position, adjust for scroll
    const offset = $(this).offset();
    const menuWidth = $menu.outerWidth();
    let top = offset.top + $(this).outerHeight() + 6; // slightly below
    let left = offset.left;

    // Prevent going off right edge
    if (left + menuWidth > $(window).width() - 20) {
      left = $(window).width() - menuWidth - 20;
    }

    $menu.css({
      top: top + 'px',
      left: left + 'px',
      display: 'block'
    });
  });

  // You can add handlers for menu actions:
  $('#my_lesson_calendar_slots_menu_reschedule').on('click', function() {
    // Your reschedule logic here
    $('#my_lesson_calendar_slots_menu').hide();
  });
  // Add more click handlers as needed...
});

</script>