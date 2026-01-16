  $(function(){
    // open
    $('#my_lessons_tutor_profile_edit_button').on('click', function(){
      $('#my_lessons_tutor_profile_modal_backdrop, #my_lessons_tutor_profile_modal').fadeIn(200);
      $('.my_lessons_tutor_profile_modal_star_input span').addClass('selected').text('★');
    });
    // close
    function closeModal(){
      $('#my_lessons_tutor_profile_modal_backdrop, #my_lessons_tutor_profile_modal').fadeOut(200);
      $('#my_lessson_tutor_profile_detail_show_more_backdrop, #my_lessson_tutor_profile_detail_show_more_modal').fadeOut(200);
    }
    $('#my_lessons_tutor_profile_modal_close, #my_lessons_tutor_profile_modal_cancel, #my_lessons_tutor_profile_modal_backdrop').on('click', closeModal);
    $('#my_lessons_tutor_profile_modal_close').on('click', closeModal)
    
  });

  // star rating
$(document).on(
  'mouseenter',
  '.my_lessons_tutor_profile_modal_star_input svg',
  function () {
    const $container = $(this).closest('.my_lessons_tutor_profile_modal_star_input');
    const $stars = $container.find('svg');
    const index = $(this).index();

    $stars.each(function (i) {
      const $path = $(this).find('path');

      if (i <= index) {
        $path
          .attr('fill', '#000')
          .attr('fill-rule', 'nonzero')
          .attr('clip-rule', 'nonzero');
      } else {
        $path
          .attr('fill', '#4D4C5C')
          .attr('fill-rule', 'evenodd')
          .attr('clip-rule', 'evenodd');
      }
    });
  }
);

$(document).on(
  'mouseleave',
  '.my_lessons_tutor_profile_modal_star_input',
  function () {
    $(this).find('path')
      .attr('fill', '#4D4C5C')
      .attr('fill-rule', 'evenodd')
      .attr('clip-rule', 'evenodd');
  }
);


