// Show custom plan step in DOWNGRADE
$(document).on('click', '.my_lesson_tutor_detail_change_your_plan_step2d_planoption', function() {
  if ($(this).find('.my_lesson_tutor_detail_change_your_plan_step2d_planoption_label').text().trim() === "Custom plans") {
    $('.my_lesson_tutor_detail_change_your_plan_modal_content').hide();
    $('.my_lesson_tutor_detail_change_your_plan_modal_content.step2dcustom').fadeIn(130);
    // Set default custom values for downgrade (you can set a default here)
    $('.my_lesson_tutor_detail_change_your_plan_step2dcustom_lessons').text('6');
    $('.my_lesson_tutor_detail_change_your_plan_step2dcustom_price').text('$52');
    window.downgradeCustomLessonCount = 6;
    return;
  }
  $('.my_lesson_tutor_detail_change_your_plan_step2d_planoption').removeClass('selected');
  $(this).addClass('selected');
  $('.my_lesson_tutor_detail_change_your_plan_step2d_continue_btn').prop('disabled', false);
  downgradeNewTitle = $(this).find('.my_lesson_tutor_detail_change_your_plan_step2d_planoption_label').text();
  downgradeNewDesc = $(this).find('.my_lesson_tutor_detail_change_your_plan_step2d_planoption_desc').text();
});

// Custom Plan Plus/Minus logic for DOWNGRADE
window.downgradeCustomLessonCount = 6;
function updateDowngradeCustomPlanPrice() {
  // Example: base $52 for 6 lessons, each extra lesson +$8, min 4, max 10 for demo
  let baseLessons = 6, basePrice = 52, perLesson = 8, min = 4, max = 10;
  let price = basePrice + (window.downgradeCustomLessonCount - baseLessons) * perLesson;
  if (window.downgradeCustomLessonCount < baseLessons) price = basePrice - (baseLessons - window.downgradeCustomLessonCount) * perLesson;
  if (price < 30) price = 30; // Minimum price
  $('.my_lesson_tutor_detail_change_your_plan_step2dcustom_lessons').text(window.downgradeCustomLessonCount);
  $('.my_lesson_tutor_detail_change_your_plan_step2dcustom_price').text('$' + price);
}
$(document).on('click', '.my_lesson_tutor_detail_change_your_plan_step2dcustom_plus', function() {
  if (window.downgradeCustomLessonCount < 10) {
    window.downgradeCustomLessonCount++;
    updateDowngradeCustomPlanPrice();
  }
});
$(document).on('click', '.my_lesson_tutor_detail_change_your_plan_step2dcustom_minus', function() {
  if (window.downgradeCustomLessonCount > 4) {
    window.downgradeCustomLessonCount--;
    updateDowngradeCustomPlanPrice();
  }
});

// Continue from downgrade custom plan to review
$(document).on('click', '.my_lesson_tutor_detail_change_your_plan_step2dcustom_continue_btn', function() {
  downgradeNewTitle = window.downgradeCustomLessonCount + " lessons every 4 week";
  downgradeNewDesc = $('.my_lesson_tutor_detail_change_your_plan_step2dcustom_price').text() + " every 4 weeks";
  $('.step3d-new-plan-title').text(downgradeNewTitle);
  $('.step3d-new-plan-desc').text(downgradeNewDesc);
  $('.my_lesson_tutor_detail_change_your_plan_modal_content').hide();
  $('.my_lesson_tutor_detail_change_your_plan_modal_content.step3d').fadeIn(130);
  $('.my_lesson_tutor_detail_change_your_plan_modal').removeClass('fullscreen confirmation');
});
// Back from downgrade custom to plans
$(document).on('click', '.my_lesson_tutor_detail_change_your_plan_step2dcustom_back', function() {
  $('.my_lesson_tutor_detail_change_your_plan_modal_content').hide();
  $('.my_lesson_tutor_detail_change_your_plan_modal_content.step2d').fadeIn(130);
});





  // Show custom plan step when "Custom plans" is clicked in upgrade plans
$(document).on('click', '.my_lesson_tutor_detail_change_your_plan_step2_planoption', function() {
  if ($(this).find('.my_lesson_tutor_detail_change_your_plan_step2_planoption_label').text().trim() === "Custom plans") {
    $('.my_lesson_tutor_detail_change_your_plan_modal_content').hide();
    $('.my_lesson_tutor_detail_change_your_plan_modal_content.step2custom').fadeIn(130);
    // Set default custom values
    $('.my_lesson_tutor_detail_change_your_plan_step2custom_lessons').text('11');
    $('.my_lesson_tutor_detail_change_your_plan_step2custom_price').text('$92');
    return;
  }
  $('.my_lesson_tutor_detail_change_your_plan_step2_planoption').removeClass('selected');
  $(this).addClass('selected');
  selectedPlanTitle = $(this).find('.my_lesson_tutor_detail_change_your_plan_step2_planoption_label').text();
  selectedPlanDesc = $(this).find('.my_lesson_tutor_detail_change_your_plan_step2_planoption_desc').text();
});

// Custom Plan Plus/Minus logic
var customLessonCount = 11;
function updateCustomPlanPrice() {
  // Example price: base $92 for 11 lessons, each extra lesson +$8, each lesson below 11 -$8 (min 4, max 20 for demo)
  let baseLessons = 11, basePrice = 92, perLesson = 8, min = 4, max = 20;
  let price = basePrice + (customLessonCount - baseLessons) * perLesson;
  if (customLessonCount < baseLessons) price = basePrice - (baseLessons - customLessonCount) * perLesson;
  if (price < 30) price = 30; // Minimum price
  $('.my_lesson_tutor_detail_change_your_plan_step2custom_lessons').text(customLessonCount);
  $('.my_lesson_tutor_detail_change_your_plan_step2custom_price').text('$' + price);
}
$(document).on('click', '.my_lesson_tutor_detail_change_your_plan_step2custom_plus', function() {
  if (customLessonCount < 20) {
    customLessonCount++;
    updateCustomPlanPrice();
  }
});
$(document).on('click', '.my_lesson_tutor_detail_change_your_plan_step2custom_minus', function() {
  if (customLessonCount > 4) {
    customLessonCount--;
    updateCustomPlanPrice();
  }
});

// Continue from custom plan
$(document).on('click', '.my_lesson_tutor_detail_change_your_plan_step2custom_continue_btn', function() {
  selectedPlanTitle = customLessonCount + " lessons every 4 week";
  selectedPlanDesc = $('.my_lesson_tutor_detail_change_your_plan_step2custom_price').text() + " every 4 weeks";
  $('.step3-new-plan-title').text(selectedPlanTitle);
  $('.step3-new-plan-desc').text(selectedPlanDesc);
  $('.my_lesson_tutor_detail_change_your_plan_modal_content').hide();
  $('.my_lesson_tutor_detail_change_your_plan_modal_content.step3').fadeIn(130);
  $('.my_lesson_tutor_detail_change_your_plan_modal').removeClass('fullscreen confirmation');
  $('.my_lesson_tutor_detail_change_your_plan_step3_when_row').removeClass('selected');
  $('.my_lesson_tutor_detail_change_your_plan_step3_when_row.when_now').addClass('selected');
  updateUpgradeBtn();
});
// Back from custom to plans
$(document).on('click', '.my_lesson_tutor_detail_change_your_plan_step2custom_back', function() {
  $('.my_lesson_tutor_detail_change_your_plan_modal_content').hide();
  $('.my_lesson_tutor_detail_change_your_plan_modal_content.step2').fadeIn(130);
});

let selectedPlanTitle = "3 lessons per week";
  let selectedPlanDesc = "12 lessons · $92 every 4 weeks";
  let downgradeNewTitle = "";
  let downgradeNewDesc = "";

  // Open modal
  $('.my_lesson_tutor_detail_change_your_plan_button').on('click', function() {
    $('.my_lesson_tutor_detail_change_your_plan_modal_backdrop').fadeIn(120);
    $('.my_lesson_tutor_detail_change_your_plan_modal').fadeIn(120);
    $('.my_lesson_tutor_detail_change_your_plan_modal_content').hide();
    $('.my_lesson_tutor_detail_change_your_plan_modal_content.step1').show();
    $('.my_lesson_tutor_detail_change_your_plan_modal').removeClass('fullscreen confirmation');
  });
  // Close
  $(document).on('click', '.my_lesson_tutor_detail_change_your_plan_modal_close, .my_lesson_tutor_detail_change_your_plan_modal_backdrop, .my_lesson_tutor_detail_change_your_plan_step5_btn', function() {
    $('.my_lesson_tutor_detail_change_your_plan_modal').fadeOut(120);
    $('.my_lesson_tutor_detail_change_your_plan_modal_backdrop').fadeOut(120);
    $('.my_lesson_tutor_detail_change_your_plan_modal').removeClass('fullscreen confirmation');
  });

  // Step 1 > Step 2 Upgrade
  $(document).on('click', '.my_lesson_tutor_detail_change_your_plan_upgrade', function() {
    $('.my_lesson_tutor_detail_change_your_plan_modal_content').hide();
    $('.my_lesson_tutor_detail_change_your_plan_modal_content.step2').fadeIn(130);
    $('.my_lesson_tutor_detail_change_your_plan_modal').removeClass('fullscreen confirmation');
  });

  // Step 1 > Step 2D Downgrade
  $(document).on('click', '.my_lesson_tutor_detail_change_your_plan_downgrade', function() {
    $('.my_lesson_tutor_detail_change_your_plan_modal_content').hide();
    $('.my_lesson_tutor_detail_change_your_plan_modal_content.step2d').fadeIn(130);
    $('.my_lesson_tutor_detail_change_your_plan_modal').removeClass('fullscreen confirmation');
    $('.my_lesson_tutor_detail_change_your_plan_step2d_planoption').removeClass('selected');
    $('.my_lesson_tutor_detail_change_your_plan_step2d_continue_btn').prop('disabled', true);
  });

  // UPGRADE Step2 plan select
  $(document).on('click', '.my_lesson_tutor_detail_change_your_plan_step2_planoption', function() {
    $('.my_lesson_tutor_detail_change_your_plan_step2_planoption').removeClass('selected');
    $(this).addClass('selected');
    selectedPlanTitle = $(this).find('.my_lesson_tutor_detail_change_your_plan_step2_planoption_label').text();
    selectedPlanDesc = $(this).find('.my_lesson_tutor_detail_change_your_plan_step2_planoption_desc').text();
  });

  // UPGRADE Step2 Continue
  $(document).on('click', '.my_lesson_tutor_detail_change_your_plan_step2_continue_btn', function() {
    $('.step3-new-plan-title').text(selectedPlanTitle);
    $('.step3-new-plan-desc').text(selectedPlanDesc);
    $('.my_lesson_tutor_detail_change_your_plan_modal_content').hide();
    $('.my_lesson_tutor_detail_change_your_plan_modal_content.step3').fadeIn(130);
    $('.my_lesson_tutor_detail_change_your_plan_modal').removeClass('fullscreen confirmation');
    $('.my_lesson_tutor_detail_change_your_plan_step3_when_row').removeClass('selected');
    $('.my_lesson_tutor_detail_change_your_plan_step3_when_row.when_now').addClass('selected');
    updateUpgradeBtn();
  });
  // UPGRADE Step3 When do you want
  function updateUpgradeBtn() {
    if ($('.my_lesson_tutor_detail_change_your_plan_step3_when_row.when_now').hasClass('selected')) {
      $('.my_lesson_tutor_detail_change_your_plan_step3_action_btn').text('Continue to checkout');
    } else {
      $('.my_lesson_tutor_detail_change_your_plan_step3_action_btn').text('Confirm');
    }
  }
  $(document).on('click', '.my_lesson_tutor_detail_change_your_plan_step3_when_row', function() {
    $('.my_lesson_tutor_detail_change_your_plan_step3_when_row').removeClass('selected');
    $(this).addClass('selected');
    updateUpgradeBtn();
  });
  // UPGRADE Step3 Continue/Confirm
  $(document).on('click', '.my_lesson_tutor_detail_change_your_plan_step3_action_btn', function() {
    if ($('.my_lesson_tutor_detail_change_your_plan_step3_when_row.when_now').hasClass('selected')) {
      // To payment full screen
      $('.my_lesson_tutor_detail_change_your_plan_modal_content').hide();
      $('.my_lesson_tutor_detail_change_your_plan_modal_content.step4').fadeIn(140);
      $('.my_lesson_tutor_detail_change_your_plan_modal').addClass('fullscreen').removeClass('confirmation');
    } else {
      // To confirmation
      $('.my_lesson_tutor_detail_change_your_plan_modal_content').hide();
      $('.my_lesson_tutor_detail_change_your_plan_modal_content.step5').fadeIn(140);
      $('.my_lesson_tutor_detail_change_your_plan_modal').removeClass('fullscreen').addClass('confirmation');
    }
  });

  // UPGRADE Step4 Confirm payment
  $(document).on('click', '.my_lesson_tutor_detail_change_your_plan_step4_confirmbtn', function() {
    $('.my_lesson_tutor_detail_change_your_plan_modal_content').hide();
    $('.my_lesson_tutor_detail_change_your_plan_modal_content.step5').fadeIn(140);
    $('.my_lesson_tutor_detail_change_your_plan_modal').removeClass('fullscreen').addClass('confirmation');
  });

  // Back buttons
  $(document).on('click', '.my_lesson_tutor_detail_change_your_plan_step2_back', function() {
    $('.my_lesson_tutor_detail_change_your_plan_modal_content').hide();
    $('.my_lesson_tutor_detail_change_your_plan_modal_content.step1').fadeIn(130);
    $('.my_lesson_tutor_detail_change_your_plan_modal').removeClass('fullscreen confirmation');
  });
  $(document).on('click', '.my_lesson_tutor_detail_change_your_plan_step3_back', function() {
    $('.my_lesson_tutor_detail_change_your_plan_modal_content').hide();
    $('.my_lesson_tutor_detail_change_your_plan_modal_content.step2').fadeIn(130);
    $('.my_lesson_tutor_detail_change_your_plan_modal').removeClass('fullscreen confirmation');
  });
  $(document).on('click', '.my_lesson_tutor_detail_change_your_plan_step2d_back', function() {
    $('.my_lesson_tutor_detail_change_your_plan_modal_content').hide();
    $('.my_lesson_tutor_detail_change_your_plan_modal_content.step1').fadeIn(130);
    $('.my_lesson_tutor_detail_change_your_plan_modal').removeClass('fullscreen confirmation');
  });

  // DOWNGRADE plan select
  $(document).on('click', '.my_lesson_tutor_detail_change_your_plan_step2d_planoption:not(.current)', function() {
    $('.my_lesson_tutor_detail_change_your_plan_step2d_planoption').removeClass('selected');
    $(this).addClass('selected');
    $('.my_lesson_tutor_detail_change_your_plan_step2d_continue_btn').prop('disabled', false);
    downgradeNewTitle = $(this).find('.my_lesson_tutor_detail_change_your_plan_step2d_planoption_label').text();
    downgradeNewDesc = $(this).find('.my_lesson_tutor_detail_change_your_plan_step2d_planoption_desc').text();
  });

  // DOWNGRADE Continue to Review
  $(document).on('click', '.my_lesson_tutor_detail_change_your_plan_step2d_continue_btn', function() {
    $('.step3d-new-plan-title').text(downgradeNewTitle);
    $('.step3d-new-plan-desc').text(downgradeNewDesc);
    $('.my_lesson_tutor_detail_change_your_plan_modal_content').hide();
    $('.my_lesson_tutor_detail_change_your_plan_modal_content.step3d').fadeIn(130);
    $('.my_lesson_tutor_detail_change_your_plan_modal').removeClass('fullscreen confirmation');
  });

  // DOWNGRADE: step3d Back
  $(document).on('click', '.my_lesson_tutor_detail_change_your_plan_step3d_back', function() {
    $('.my_lesson_tutor_detail_change_your_plan_modal_content').hide();
    $('.my_lesson_tutor_detail_change_your_plan_modal_content.step2d').fadeIn(130);
    $('.my_lesson_tutor_detail_change_your_plan_modal').removeClass('fullscreen confirmation');
  });

  // DOWNGRADE: Confirm button to Confirmation step5
  $(document).on('click', '.my_lesson_tutor_detail_change_your_plan_step3d_action_btn', function() {
    $('.my_lesson_tutor_detail_change_your_plan_modal_content').hide();
    $('.my_lesson_tutor_detail_change_your_plan_modal_content.step5').fadeIn(140);
    $('.my_lesson_tutor_detail_change_your_plan_modal').removeClass('fullscreen').addClass('confirmation');
  });
