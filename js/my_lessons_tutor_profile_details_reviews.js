  $(function(){
    // open
    $('#my_lessons_tutor_profile_edit_button').on('click', function(){
      $('#my_lessons_tutor_profile_modal_backdrop, #my_lessons_tutor_profile_modal').fadeIn(200);
      $('.my_lessons_tutor_profile_modal_star_input span').addClass('selected').text('★');
    });
    // close
    function closeModal(){
      $('#my_lessons_tutor_profile_modal_backdrop, #my_lessons_tutor_profile_modal').fadeOut(200);
    }
    $('#my_lessons_tutor_profile_modal_close, #my_lessons_tutor_profile_modal_cancel, #my_lessons_tutor_profile_modal_backdrop').on('click', closeModal);
    // star rating input
    $('.my_lessons_tutor_profile_modal_star_input').on('click', 'span', function(){
      var val = +$(this).data('value');
      $('.my_lessons_tutor_profile_modal_star_input span').each(function(){
        var v = +$(this).data('value');
        if (v <= val) { $(this).addClass('selected').text('★'); }
        else { $(this).removeClass('selected').text('★').css('color','#ccc'); }
      });
    });
  });
