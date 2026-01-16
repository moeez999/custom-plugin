  $(function(){
    var $form = $('.my_lessson_tutor_profile_detail_show_more_edit_body');

    // Open modal
    $('.my_lessson_tutor_profile_detail_show_more_trigger').on('click', function(e){
      e.preventDefault();
      $('#my_lessson_tutor_profile_detail_show_more_backdrop, #my_lessson_tutor_profile_detail_show_more_modal')
        .fadeIn(200);
      $form.hide();
    });

    // Close modal
    $('.my_lessson_tutor_profile_detail_show_more_close, #my_lessson_tutor_profile_detail_show_more_backdrop').on('click', function(){
      $('#my_lessson_tutor_profile_detail_show_more_backdrop, #my_lessson_tutor_profile_detail_show_more_modal')
        .fadeOut(200);
    });

    // Per-review Edit: hide only its own content, insert form below
    $('#my_lessson_tutor_profile_detail_show_more_review_edit').on('click', function(){
      var $rev = $(this).closest('.review');
      // hide stars, text, reply
      $rev.find('.rating, > p, .reply').hide();
      // move & show form
      $form.insertAfter($rev).hide().slideDown(200);
    });

    // Cancel: restore hidden review content & hide form
    $('#my_lessson_tutor_profile_detail_show_more_cancel_edit').on('click', function(){
      var $prev = $form.prev('.review');
      $prev.find('.rating, > p, .reply').show();
      $form.slideUp(200);
    });

    // Update: hook AJAX then close
    $('#my_lessson_tutor_profile_detail_show_more_update_edit').on('click', function(){
      $('#my_lessson_tutor_profile_detail_show_more_backdrop, #my_lessson_tutor_profile_detail_show_more_modal')
        .fadeOut(200);
    });
  });
