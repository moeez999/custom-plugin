
    $(function(){
      // Close
      $('#my_lessons_details_reshedule_close').click(() => history.back());

      // Day click (highlight)
      $('#my_lessons_details_reshedule_table thead th').click(function(){
        var idx = $(this).index();
        // only days (not first th)
        if(idx === 0) return;
        $('#my_lessons_details_reshedule_table thead th').removeClass('active');
        $(this).addClass('active');
      });

      // Slot click
      $('#my_lessons_details_reshedule_table').on('click','.slot:not(.disabled)',function(){
        $('.slot').removeClass('selected');
        $(this).addClass('selected');
        // build new-time string
        var col = $(this).closest('td').index();
        var day = $('#my_lessons_details_reshedule_table thead th').eq(col).text();
        var time = $(this).data('time');
        var p = time.split(':'), h=+p[0], m=+p[1]+50;
        if(m>=60){h++;m-=60;}
        var end = (h<10?'0'+h:h)+':'+(m<10?'0'+m:m);
        var str = day+', '+time+'–'+end;
        $('#my_lessons_details_reshedule_new_time')
          .val(str).css('border','1px solid #000');
        $('#my_lessons_details_reshedule_clear').show();
        $('#my_lessons_details_reshedule_reschedule_btn')
          .addClass('enabled')
          .css({'cursor':'pointer','background':'#ff3b30'});
      });

      // Clear new time
      $('#my_lessons_details_reshedule_clear').click(function(){
        $('#my_lessons_details_reshedule_new_time').val('').css('border','1px dashed #ccc');
        $(this).hide();
        $('.slot').removeClass('selected');
        $('#my_lessons_details_reshedule_reschedule_btn')
          .removeClass('enabled')
          .css({'cursor':'not-allowed','background':'#ccc'});
      });

      // Tooltip on disabled slots
      $('#my_lessons_details_reshedule_table').on('mouseenter','.slot.disabled',function(){
        var $b=$(this), title=$b.data('tooltip-title'), sub=$b.data('tooltip-subtitle');
        var $tip=$('<div class="my_lessons_details_reshedule_tooltip">'+
                    '<div class="title">'+title+'</div>'+
                    '<div class="subtitle">'+sub+'</div>'+
                   '</div>');
        $('body').append($tip);
        var off=$b.offset(), bw=$b.outerWidth(),
            th=$tip.outerHeight(), tw=$tip.outerWidth();
        $tip.css({ left: off.left + bw/2 - tw/2, top: off.top - th - 8 });
        $b.data('tooltipEl',$tip);
      }).on('mouseleave','.slot.disabled',function(){
        var $t=$(this).data('tooltipEl'); if($t) $t.remove();
      });

      // Reschedule action
      $('#my_lessons_details_reshedule_reschedule_btn').click(function(){
        if(!$(this).hasClass('enabled')) return;
        alert('Rescheduled to: '+$('#my_lessons_details_reshedule_new_time').val());
      });
    });
