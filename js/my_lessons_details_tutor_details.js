$(function(){
  // Step 1: add extra lessons
  var pricePerLesson = 5;
  var minLessons = 1;
  var maxLessons = 10;
  var lessonCount = 2;
  
  // Step 4: custom plan
  var customPlanMin = 1;
  var customPlanMax = 30;
  var customPlanLessonCount = 9;
  var customPlanPricePerLesson = 8;
  function updateModal() {
    $('#my_lessons_tutors_tab_add_extra_lessons_count').text(lessonCount);
    $('#my_lessons_tutors_tab_add_extra_lessons_total_price').text(lessonCount * pricePerLesson);
    $('#my_lessons_tutors_tab_add_extra_lessons_minus').prop('disabled', lessonCount <= minLessons);
    $('#my_lessons_tutors_tab_add_extra_lessons_plus').prop('disabled', lessonCount >= maxLessons);
  }
  function updateCustomPlan() {
    $('#my_lessons_tutors_tab_add_extra_lessons_step4_count').text(customPlanLessonCount);
    $('#my_lessons_tutors_tab_add_extra_lessons_step4_total_price').text(customPlanLessonCount * customPlanPricePerLesson);
    $('#my_lessons_tutors_tab_add_extra_lessons_step4_minus').prop('disabled', customPlanLessonCount <= customPlanMin);
    $('#my_lessons_tutors_tab_add_extra_lessons_step4_plus').prop('disabled', customPlanLessonCount >= customPlanMax);
  }
  function showStep(stepNum) {

  $('#my_lessons_tutors_tab_add_extra_lessons_modal').removeClass('wide-step9');
  $('.my_lessons_tutors_tab_add_extra_lessons_step1, .my_lessons_tutors_tab_add_extra_lessons_step2, .my_lessons_tutors_tab_add_extra_lessons_step3, .my_lessons_tutors_tab_add_extra_lessons_step4, .my_lessons_tutors_tab_add_extra_lessons_step5, .my_lessons_tutors_tab_add_extra_lessons_step6, .my_lessons_tutors_tab_add_extra_lessons_step7, .my_lessons_tutors_tab_add_extra_lessons_step8, .my_lessons_tutors_tab_add_extra_lessons_step9').hide();

// $('.my_lessons_tutors_tab_add_extra_lessons_step1, .my_lessons_tutors_tab_add_extra_lessons_step2, .my_lessons_tutors_tab_add_extra_lessons_step3, .my_lessons_tutors_tab_add_extra_lessons_step4, .my_lessons_tutors_tab_add_extra_lessons_step5, .my_lessons_tutors_tab_add_extra_lessons_step6, .my_lessons_tutors_tab_add_extra_lessons_step7, .my_lessons_tutors_tab_add_extra_lessons_step8, .my_lessons_tutors_tab_add_extra_lessons_step9').hide();

    if(stepNum == 1) $('.my_lessons_tutors_tab_add_extra_lessons_step1').fadeIn(120);
    if(stepNum == 2) $('.my_lessons_tutors_tab_add_extra_lessons_step2').fadeIn(120);
    if(stepNum == 3) $('.my_lessons_tutors_tab_add_extra_lessons_step3').fadeIn(120);
    if(stepNum == 4) $('.my_lessons_tutors_tab_add_extra_lessons_step4').fadeIn(120);
    if(stepNum == 5) $('.my_lessons_tutors_tab_add_extra_lessons_step5').fadeIn(120);
    if(stepNum == 6) $('.my_lessons_tutors_tab_add_extra_lessons_step6').fadeIn(120);
    if(stepNum == 7) $('.my_lessons_tutors_tab_add_extra_lessons_step7').fadeIn(120);
    if(stepNum == 8) $('.my_lessons_tutors_tab_add_extra_lessons_step8').fadeIn(120);
//    if(stepNum == 9) $('.my_lessons_tutors_tab_add_extra_lessons_step9').fadeIn(120);

  if(stepNum == 9) {
    $('#my_lessons_tutors_tab_add_extra_lessons_modal').addClass('wide-step9');
    $('.my_lessons_tutors_tab_add_extra_lessons_step9').fadeIn(120);
  }


  }

  $('#my_lessons_tutors_tab_add_extra_lessons_open_modal').on('click', function(){
    $('#my_lessons_tutors_tab_add_extra_lessons_modal_backdrop').fadeIn(140);
    $('#my_lessons_tutors_tab_add_extra_lessons_modal').fadeIn(180);
    showStep(1);
    updateModal();
    $('.my_lessons_tutors_tab_add_extra_lessons_step3_optionbox').removeClass('selected');
    $('.my_lessons_tutors_tab_add_extra_lessons_step3_continue_btn').prop('disabled', true);
    customPlanLessonCount = 9;
    updateCustomPlan();
    $('.my_lessons_tutors_tab_add_extra_lessons_step5_option').removeClass('selected');
    $('.my_lessons_tutors_tab_add_extra_lessons_step5_option[data-value="now"]').addClass('selected');
    updateStep5Radios();
  });

  function closeModal() {
    $('#my_lessons_tutors_tab_add_extra_lessons_modal').fadeOut(120);
    $('#my_lessons_tutors_tab_add_extra_lessons_modal_backdrop').fadeOut(100);
  }
  $('.my_lessons_tutors_tab_add_extra_lessons_header .close-icon, .my_lessons_tutors_tab_add_extra_lessons_step6_header .close-icon, .my_lessons_tutors_tab_add_extra_lessons_step7_close, #modal_step9_close').on('click', closeModal);
  $('#my_lessons_tutors_tab_add_extra_lessons_modal_backdrop').on('click', closeModal);
  $('.my_lessons_tutors_tab_add_extra_lessons_step1 .back-arrow').on('click', closeModal);
  $('.my_lessons_tutors_tab_add_extra_lessons_step2 .back-arrow').on('click', function(){ showStep(1); });
  $('.my_lessons_tutors_tab_add_extra_lessons_step3 .back-arrow').on('click', function(){ showStep(2); });
  $('.my_lessons_tutors_tab_add_extra_lessons_step4 .back-arrow').on('click', function(){ showStep(3); });
  $('.my_lessons_tutors_tab_add_extra_lessons_step5 .back-arrow').on('click', function(){ showStep(3); });
  $('.my_lessons_tutors_tab_add_extra_lessons_step6 .back-arrow').on('click', function(){ showStep(2); });
  $('.my_lessons_tutors_tab_add_extra_lessons_step8 .back-arrow').on('click', function(){ showStep(6); });

  $('#my_lessons_tutors_tab_add_extra_lessons_plus').on('click', function(){
    if(lessonCount < maxLessons) {
      lessonCount++;
      updateModal();
    }
  });
  $('#my_lessons_tutors_tab_add_extra_lessons_minus').on('click', function(){
    if(lessonCount > minLessons) {
      lessonCount--;
      updateModal();
    }
  });
  $('.my_lessons_tutors_tab_add_extra_lessons_continue_btn').on('click', function(){ showStep(2); });
  $('.my_lessons_tutors_tab_add_extra_lessons_step2_option').on('click', function(){
    var goToStep = $(this).attr('data-step');
    showStep(Number(goToStep));
    if(goToStep == "3") {
      $('.my_lessons_tutors_tab_add_extra_lessons_step3_optionbox').removeClass('selected');
      $('.my_lessons_tutors_tab_add_extra_lessons_step3_continue_btn').prop('disabled', true);
    }
  });
  $('.my_lessons_tutors_tab_add_extra_lessons_step3_optionbox').on('click', function(){
    $('.my_lessons_tutors_tab_add_extra_lessons_step3_optionbox').removeClass('selected');
    $(this).addClass('selected');
    $('.my_lessons_tutors_tab_add_extra_lessons_step3_continue_btn').prop('disabled', false);
  });
  $('.my_lessons_tutors_tab_add_extra_lessons_step3_continue_btn').on('click', function(){
    var selectedPlan = $('.my_lessons_tutors_tab_add_extra_lessons_step3_optionbox.selected').attr('data-plan');
    if(selectedPlan === 'custom') {
      showStep(4);
    } else {
      showStep(5);
    }
  });
  $('#my_lessons_tutors_tab_add_extra_lessons_step4_plus').on('click', function(){
    if(customPlanLessonCount < customPlanMax) {
      customPlanLessonCount++;
      updateCustomPlan();
    }
  });
  $('#my_lessons_tutors_tab_add_extra_lessons_step4_minus').on('click', function(){
    if(customPlanLessonCount > customPlanMin) {
      customPlanLessonCount--;
      updateCustomPlan();
    }
  });
  $('.my_lessons_tutors_tab_add_extra_lessons_step4_continue_btn').on('click', function(){ showStep(5); });

  function updateStep5Radios() {
    $('.my_lessons_tutors_tab_add_extra_lessons_step5_option').each(function(){
      var radio = $(this).find('.my_lessons_tutors_tab_add_extra_lessons_step5_option_radio');
      if($(this).hasClass('selected')) {
        radio.html('&#9679;');
      } else {
        radio.html('&#9675;');
      }
    });
    if ($('.my_lessons_tutors_tab_add_extra_lessons_step5_option[data-value="now"]').hasClass('selected')) {
      $('#now_detail').show();
      $('#next_billing_detail').hide();
      $('.my_lessons_tutors_tab_add_extra_lessons_step5_checkout_btn').text('Continue to checkout');
    } else {
      $('#now_detail').hide();
      $('#next_billing_detail').show();
      $('.my_lessons_tutors_tab_add_extra_lessons_step5_checkout_btn').text('Confirm');
    }
  }
  $('.my_lessons_tutors_tab_add_extra_lessons_step5_option').on('click', function(){
    $('.my_lessons_tutors_tab_add_extra_lessons_step5_option').removeClass('selected');
    $(this).addClass('selected');
    updateStep5Radios();
  });

  $('.my_lessons_tutors_tab_add_extra_lessons_step5_checkout_btn').on('click', function(){
    var selectedOption = $('.my_lessons_tutors_tab_add_extra_lessons_step5_option.selected').attr('data-value');
    if(selectedOption === 'next_billing') {
      showStep(7);
    } else if(selectedOption === 'now') {
      showStep(9); // Show the new payment modal
    } else {
      alert('Proceeding to checkout. Upgrade timing: ' + (selectedOption === 'now' ? 'Now' : 'Next Billing Date'));
      closeModal();
    }
  });

  // Existing Confirm Payment ($5.61) in step 6
  $('.my_lessons_tutors_tab_add_extra_lessons_step6_confirm_btn').on('click', function(){
    showStep(8); // If you have an 8th step for this flow, else closeModal();
    // Or closeModal(); or your logic
  });

  // Confirm in new step9
  $('#modal_step9_pay_btn').on('click', function(){
    // Show confirmation or next step as needed, for now just close
    alert("Payment confirmed! (Demo action, integrate your next step here)");
    closeModal();
  });

  $('.my_lessons_tutors_tab_add_extra_lessons_step7_btn').on('click', closeModal);

  // Initial state
  updateModal();
  updateCustomPlan();
  updateStep5Radios();
});

