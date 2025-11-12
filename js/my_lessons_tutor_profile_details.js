    $(function(){
      // Reviews toggle
      // $('#my_lessons_tutor_profile_toggle_reviews').click(function(){
      //   var $list = $('#my_lessons_tutor_profile_reviews_list');
      //   var collapsed = $list.hasClass('my_lessons_tutor_profile_collapsed');
      //   $list.toggleClass('my_lessons_tutor_profile_collapsed', !collapsed)
      //        .toggleClass('my_lessons_tutor_profile_expanded', collapsed);
      //   $(this).text(collapsed ? 'Show less' : 'Show all 8 reviews');
      // });

      // Duration toggle
      $('.my_lessons_tutor_profile_toggle_duration button').click(function(){
        $('.my_lessons_tutor_profile_toggle_duration button').removeClass('active');
        $(this).addClass('active');
      });

      // Week navigation
      let ws = new Date(2025,2,11);
      function updateWeek(){
        const opts={month:'short',day:'numeric'};
        let e = new Date(ws); e.setDate(e.getDate()+6);
        $('#my_lessons_tutor_profile_week_label')
          .text(`${ws.toLocaleDateString('en-US',opts)}–${e.toLocaleDateString('en-US',opts)}, ${e.getFullYear()}`);
      }
      updateWeek();
      $('#my_lessons_tutor_profile_prev_week').click(()=>{ ws.setDate(ws.getDate()-7); updateWeek(); });
      $('#my_lessons_tutor_profile_next_week').click(()=>{ ws.setDate(ws.getDate()+7); updateWeek(); });

      // Timezone dropdown
      $('.my_lessons_tutor_profile_timezone_select').click(e=>{
        e.stopPropagation();
        $('#my_lessons_tutor_profile_timezone_dropdown').toggle();
      });
      $('#my_lessons_tutor_profile_timezone_dropdown li').click(function(){
        $('#my_lessons_tutor_profile_timezone_label').text($(this).text());
        $('#my_lessons_tutor_profile_timezone_dropdown').hide();
      });
      $(document).click(()=>$('#my_lessons_tutor_profile_timezone_dropdown').hide());

      // Slot selection
      $('.my_lessons_tutor_profile_times a').click(function(e){
        e.preventDefault();
        $('.my_lessons_tutor_profile_times a').removeClass('selected');
        $(this).addClass('selected');
      });
    });




    $(function(){
      $('.my_lesson_tutor_profile_resume_tab').on('click', function(){
        var tab = $(this).data('tab');
        // Tabs
        $('.my_lesson_tutor_profile_resume_tab').removeClass('active');
        $(this).addClass('active');
        // Contents
        $('.my_lesson_tutor_profile_resume_tab_content').hide();
        $('#my_lesson_tutor_profile_resume_' + tab).show();
      });
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
    var $wrap = $('.my_lessons_tutor_profile_tiles_wrapper');
    var scrollAmount = 240; // approx tile width + gap

    $('#my_lessons_tutor_profile_tiles_next').on('click', function(){
      $wrap.animate({ scrollLeft: '+=' + scrollAmount }, 300);
    });
    $('#my_lessons_tutor_profile_tiles_prev').on('click', function(){
      $wrap.animate({ scrollLeft: '-=' + scrollAmount }, 300);
    });
  });

