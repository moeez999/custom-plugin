$(function() {
  // Open modal -> Step 1
  $(document).on('click', '#send_message_btn', function(e) {
    e.preventDefault();
    $('.send_message_container').removeClass('fullscreen');
    $('#send_message_modal .send_message_step')
      .removeClass('active')
      .filter('.send_message_step1').addClass('active');
    $('#send_message_modal').fadeIn(200);
  });

  // Close (×)
  $(document).on('click', '#send_message_close', function() {
    $('#send_message_modal').fadeOut(200);
  });

  // Step 1 -> Step 2
  $(document).on('click', '#send_message_submit', function() {
    $('.send_message_step1').fadeOut(200, function() {
      $('.send_message_step2').fadeIn(200).addClass('active');
    }).removeClass('active');
  });

  // Step 2 -> Step 3
  $(document).on('click', '#send_message_book', function() {
    $('.send_message_step2').fadeOut(200, function() {
      $('.send_message_step3').fadeIn(200).addClass('active');
    }).removeClass('active');
  });
  
  // Step 3 -> Step 4
   $(document).on('click', '#send_message_book_c', function() {
    $('.send_message_step3').fadeOut(200, function() {
      $('.send_message_step4').fadeIn(200).addClass('active');
    }).removeClass('active');
  });
  // Step 4 -> Step 5 (fullscreen)
  $(document).on('click', '.send_message_step_4_to_5', function() {
    $('.send_message_step4').fadeOut(200, function() {
      $('.send_message_container')
        .addClass('fullscreen');
      $('.send_message_step5').fadeIn(200).addClass('active');
    }).removeClass('active');
  });

  // Confirm subscription
  $(document).on('click', '#send_message_confirm', function() {
    alert('Subscribed!');
    $('#send_message_modal').fadeOut(200);
  });

  // Show more tutors
  $(document).on('click', '#send_message_more', function() {
    $('#send_message_modal').fadeOut(200);
    // TODO: show tutor list
  });

  // toggle Checkbox
  $(document).on('click', '.send-message-checkbox.checkbox', function () {
    $(this).toggleClass('selected');
  });

  // step3 
  $('.arrow-calendar').on('click', function () {
        // Add active class to the clicked tab
        $(".send_message_week").addClass('d-none');
        $(".cal-heading").addClass('d-none');
        $("#cal-"+$(this).data('target')).removeClass('d-none');
        $("#hed-"+$(this).data('target')).removeClass('d-none');
    });
  // calendar clickable
   $('.send_message_date').on('click', function () {
        $('.send_message_date').removeClass('selected');
        $(this).addClass('selected');
    });


  // toggle tabs
   $('.send_message_tab').on('click', function () {
        // Remove active class from all tabs
        $('.send_message_tab').removeClass('active');

        // Add active class to the clicked tab
        $(this).addClass('active');
    });

  // step 5
  // review read more
  $('.reveal-review').on('click', function () {
    $(this).addClass('d-none');
    $("#"+$(this).data('target')).removeClass('d-none');
  });
});

