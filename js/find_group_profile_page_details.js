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

   $(function(){
     $('#direct-book-btn')
     .on('click', function(){
       $("#group_level_confirm_modal").removeClass("hidden");
       $("#glcm_step1").addClass("hidden"); //step 1
       $("#find_groups_book_trail_lesson_step2_container").addClass("hidden"); //step 1
       $("#find_groups_book_trail_lesson_step3_container").removeClass("hidden"); //step 3
       $("#find_groups_book_trail_lesson_step4_container").addClass("hidden"); //step 4
       
      });
    });

   $(function () {
  $('#group_schedule_calendar .label').on('click', function () {

    // active state
    $(".label").removeClass("active_day_label");
    $(this).addClass("active_day_label");

    // get elements
    const $button = $(this).closest('button');
    const dayShort = $button.find('div:first').text(); // mon, tue, etc
    const dateNum = $(this).text(); // 18, 19, etc

    // map short day → full day
    const dayMap = {
      sat: 'Saturday',
      sun: 'Sunday',
      mon: 'Monday',
      tue: 'Tuesday',
      wed: 'Wednesday',
      thu: 'Thursday',
      fri: 'Friday'
    };

    const fullDay = dayMap[dayShort.toLowerCase()];

    // update UI (month is static here)
    const dateText = `${fullDay}, March ${dateNum}`;

    $('#find_groups_book_trail_lesson_step2_date_x, \
      #find_groups_book_trail_lesson_step3_date, \
      #find_groups_book_trail_lesson_step2_date')
      .text(dateText);

  });
});



// video play
      $(document).on('click', '#video-pay-button', function () {
        $('#videoPopup').fadeIn(200);
      });

      $(document).on('click', '.video-close, #videoPopup', function (e) {
        // if ($(e.target).closest('.video-wrapper').length) return;

        const video = $('#videoPopup video').get(0);
        video.pause();
        video.currentTime = 0;

        $('#videoPopup').fadeOut(200);
      });


      $(function () {
   $(document).on(
    'click',
    '#open-message-popup',
    function(){
      $('#message_tutor_panel_screen_1')
        .removeClass('hidden')
    }
  );
})


// active 1 2 slider
// image elements
const lessonImg = document.querySelector('.my_lessons_tutor_profile_card_img');
const avatarImg = document.getElementById('find_groups_details_available_avatar_img');

// pager buttons
const pagerBtns = document.querySelectorAll('.find_groups_details_available_num');

// image source map (index-based)
const imageSources = [
  'img/daniela.svg', // page 1
  'img/axley.svg'    // page 2
];

// function to activate page
function activatePage(index) {
  // update images
  lessonImg.src = imageSources[index];
  avatarImg.src = imageSources[index];

  // update active ring
  pagerBtns.forEach(btn => {
    btn.classList.remove('ring-2', 'ring-black');
  });

  pagerBtns[index].classList.add('ring-2', 'ring-black');
}

// click handlers
pagerBtns.forEach((btn, index) => {
  btn.addEventListener('click', () => {
    activatePage(index);
  });
});


