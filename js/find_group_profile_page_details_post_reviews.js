  $(function(){
    // Open Post-Review modal
    $('#my_lessons_tutor_profile_details_post_review_trigger').on('click', function(e){
      e.preventDefault();
      $('#my_lessons_tutor_profile_details_post_review_backdrop, #my_lessons_tutor_profile_details_post_review_modal')
        .fadeIn(200);
    });

    // Close either modal (× or backdrop)
    $('.my_lessons_tutor_profile_details_post_review_close, #my_lessons_tutor_profile_details_post_review_backdrop')
      .on('click', function(){
        $('#my_lessons_tutor_profile_details_post_review_backdrop')
          .fadeOut(200);
        $('#my_lessons_tutor_profile_details_post_review_modal, #my_lessons_tutor_profile_details_post_review_thankyou_modal')
          .fadeOut(200);
      });

    // On Post-review submit → hide Post-Review modal, show Thank-You modal
    $('#my_lessons_tutor_profile_details_post_review_submit').on('click', function(){
      $('#my_lessons_tutor_profile_details_post_review_modal').fadeOut(200, function(){
        $('#my_lessons_tutor_profile_details_post_review_thankyou_modal').fadeIn(200);
      });
    });
  });
