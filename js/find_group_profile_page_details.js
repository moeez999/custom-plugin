$(document).on('click', '.save_list', function () {
  const $btn = $(this);
  const $text = $btn.find('span');

  const isSaved = $btn.toggleClass('is-saved').hasClass('is-saved');

  $text.text(isSaved ? 'Saved' : 'Save to my list');
});


  $(function(){
    $('#my_lesson_tutor_profile_my_specialities')
      .on('click', '.my_lesson_tutor_profile_my_specialities_header', function(){
        var $item = $(this).closest('.my_lesson_tutor_profile_my_specialities_item');
        $item.toggleClass('active');
        $item.find('.my_lesson_tutor_profile_my_specialities_content')
             .slideToggle(200);
      });
  });
