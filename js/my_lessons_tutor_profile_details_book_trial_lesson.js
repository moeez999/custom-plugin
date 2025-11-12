$(function(){
  var $back   = $('#my_lessons_tutor_profile_details_book_trial_lesson_backdrop'),
      $mod1   = $('#my_lessons_tutor_profile_details_book_trial_lesson_modal'),
      $mod2   = $('#my_lessons_tutor_profile_book_trail_lesson_modal'),
      $mod3   = $('#my_lessons_tutor_profile_book_trail_lesson_payment_modal'),
      $mod4   = $('#my_lessons_tutor_profile_book_trail_lesson_balance_modal'),
      $mod5   = $('#my_lessons_tutor_profile_book_trail_lesson_review_modal'),
      $mod6   = $('#my_lessons_tutor_profile_book_trail_lesson_complete_modal'),
      priceMap= {25:10, 50:18},
      selDur, selName, selBal;
      
  // Calendar state & render
  var startDate     = new Date(2025,4,13),
      selectedIndex = 2,
      months        = ["Jan","Feb","Mar","Apr","May","Jun","Jul","Aug","Sep","Oct","Nov","Dec"];
  function formatRange(s){
    var e=new Date(s); e.setDate(e.getDate()+6);
    return months[s.getMonth()]+' '+s.getDate()+' – '+
           months[e.getMonth()]+' '+e.getDate()+', '+s.getFullYear();
  }
  function renderCal(){
    $('.my_lessons_tutor_profile_book_trail_lesson_month').text(formatRange(startDate));
    var days=['Sun','Mon','Tue','Wed','Thu','Fri','Sat'],
        $d=$('.my_lessons_tutor_profile_book_trail_lesson_days').empty();
    for(var i=0;i<7;i++){
      var dt=new Date(startDate); dt.setDate(dt.getDate()+i);
      var $day=$('<div>').addClass('my_lessons_tutor_profile_book_trail_lesson_day')
        .append($('<div>').text(days[dt.getDay()]))
        .append($('<span>').text(dt.getDate()));
      if(i===selectedIndex) $day.addClass('selected');
      $d.append($day);
    }
  }

  // OPEN Step1
  $('#my_lessons_tutor_profile_details_book_trial_lesson_btn').click(function(){
    $back.fadeIn(200); $mod1.fadeIn(200);
  });

  // GLOBAL CLOSE
  $back.add(
    '.my_lessons_tutor_profile_details_book_trial_lesson_close,'+
    '.my_lessons_tutor_profile_book_trail_lesson_close,'+
    '.my_lessons_tutor_profile_book_trail_lesson_payment_close,'+
    '.my_lessons_tutor_profile_book_trail_lesson_balance_close,'+
    '.my_lessons_tutor_profile_book_trail_lesson_review_close'
  ).on('click',function(){
    $mod1.add($mod2).add($mod3).add($mod4).add($mod5).add($mod6).fadeOut(200);
    $back.fadeOut(200);
  });

  // 1→2
  $('.my_lessons_tutor_profile_details_book_trial_lesson_option').click(function(){
    selDur = +$(this).find('h3').text();
    $mod1.fadeOut(200,function(){
      $('.my_lessons_tutor_profile_book_trail_lesson_tab').removeClass('active')
        .filter('[data-duration="'+selDur+'"]').addClass('active');
      renderCal(); $mod2.fadeIn(200);
    });
  });

  // CALENDAR NAV
  $('.my_lessons_tutor_profile_book_trail_lesson_prev').click(function(){
    startDate.setDate(startDate.getDate()-7); renderCal();
  });
  $('.my_lessons_tutor_profile_book_trail_lesson_next').click(function(){
    startDate.setDate(startDate.getDate()+7); renderCal();
  });

  // TAB SWITCH
  $('.my_lessons_tutor_profile_book_trail_lesson_tab').click(function(){
    $('.my_lessons_tutor_profile_book_trail_lesson_tab').removeClass('active');
    $(this).addClass('active');
    selDur = +$(this).data('duration');
  });

  // 2→3
  $('#my_lessons_tutor_profile_book_trail_lesson_continue').click(function(){
    $mod2.fadeOut(200,function(){ $mod3.fadeIn(200); });
  });

  // 3→4 (match Step2 height)
  $('.my_lessons_tutor_profile_book_trail_lesson_payment_option[data-choice="balance"]').click(function(){
    var h = $mod2.outerHeight();
    $mod4.css('height',h+'px');
    $mod3.fadeOut(200,function(){ $mod4.fadeIn(200); });
  });

  // 4 back→3
  $('.my_lessons_tutor_profile_book_trail_lesson_balance_back').click(function(){
    $mod4.fadeOut(200,function(){ $mod3.fadeIn(200); });
  });

  // 4→5
  $('.my_lessons_tutor_profile_book_trail_lesson_balance_option').click(function(){
    selName    = $(this).data('name');
    selBal     = +$(this).data('balance');
    var cost   = priceMap[selDur]||0,
        remain = selBal - cost;

    // populate Step5
    var $r=$mod5;
    $r.find('.my_lessons_tutor_profile_book_trail_lesson_review_avatar_row img').first()
      .attr('src', $(this).find('img').attr('src'));
    $r.find('.balance-name').text(selName);
    $r.find('.balance-amount').text('$'+selBal);
    $r.find('.lesson-label').text(selDur+'-min trial lesson with Daniela');
    $r.find('.lesson-amount').text('$'+cost);
    $r.find('.remaining-amount').text('$'+remain);
    $r.find('.my_lessons_tutor_profile_book_trail_lesson_review_list li').eq(0)
      .text('You’ll get a '+selDur+'-min trial lesson ($'+cost+') with Daniela');
    $r.find('.my_lessons_tutor_profile_book_trail_lesson_review_list li').eq(1)
      .text('You’ll still have $'+remain+' with '+selName);

    $mod4.fadeOut(200,function(){ $mod5.fadeIn(200); });
  });

  // 5 back→4
  $('.my_lessons_tutor_profile_book_trail_lesson_review_back').click(function(){
    $mod5.fadeOut(200,function(){ $mod4.fadeIn(200); });
  });

  // 5→6 (also match Step2 height)
  $('#my_lessons_tutor_profile_book_trail_lesson_review_confirm').click(function(){
    var h = $mod2.outerHeight();
    $mod6.css('height',h+'px');
    $mod5.fadeOut(200,function(){ $mod6.fadeIn(200); });
  });

  // 6 Done
  $('#my_lessons_tutor_profile_book_trail_lesson_complete_done').click(function(){
    $mod6.fadeOut(200); $back.fadeOut(200);
  });
});
