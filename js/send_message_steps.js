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

  // Step 3 -> Step 4 (fullscreen)
  $(document).on('click', '#send_message_continue', function() {
    $('.send_message_step3').fadeOut(200, function() {
      $('.send_message_container')
        .addClass('fullscreen');
      $('.send_message_step4').fadeIn(200).addClass('active');
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
});

