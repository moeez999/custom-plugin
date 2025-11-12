$(function(){
  var $overlay = $('#trialModalOverlay');

  // Open → Step 1
  $('#openTrialModal').on('click', function(){
    $overlay.css('display','flex');
    $('#step1').show();
    $('#step2, #step3').hide();
    $('.modal-window').css({ width:'380px', maxHeight:'95vh' });
  });

  // Close
  $('#step1Close, #step2Close, #step3Close').on('click', function(){
    $overlay.hide();
  });
  $overlay.on('click', function(e){
    if(e.target === this) $overlay.hide();
  });

  // Step1 → Step2
  $('.book_trial_step1 .duration-option').on('click', function(){
    var d = $(this).data('duration');
    $('#step1').hide();
    $('#step2').show();
    $('.book_trial_step2 .duration-tab').removeClass('active')
      .filter('[data-duration="'+d+'"]').addClass('active');
  });

  // Back Step2 → Step1
  $('#step2Back').on('click', function(){
    $('#step2').hide();
    $('#step1').show();
  });

  // Continue Step2 → Step3
  $('#continueToStep3').on('click', function(){
    $('#step2').hide();
    $('#step3').show();
    $('.modal-window').css({ width:'90vw', maxHeight:'95vh' });
  });

  // Back Step3 → Step2
  $('#step3Back').on('click', function(){
    $('#step3').hide();
    $('#step2').show();
    $('.modal-window').css({ width:'380px', maxHeight:'95vh' });
  });

  // Tabs & Selections
  $('.book_trial_step2 .duration-tab').on('click', function(){
    $('.book_trial_step2 .duration-tab').removeClass('active');
    $(this).addClass('active');
  });
  $('.book_trial_step2 .calendar-days .day').on('click', function(){
    $('.book_trial_step2 .calendar-days .day').removeClass('selected');
    $(this).addClass('selected');
  });
  $('.book_trial_step2 .time-slot').on('click', function(){
    $('.book_trial_step2 .time-slot').removeClass('selected');
    $(this).addClass('selected');
  });

  // Confirm
  $('#confirmSubscription').on('click', function(){
    alert('Subscription confirmed! 🎉');
    $overlay.hide();
  });
});
