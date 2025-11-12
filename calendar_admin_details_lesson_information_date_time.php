<style>/* Backdrop */
.calendar_admin_details_lesson_info_date_time_calendar_backdrop{
  position:fixed; inset:0; display:none; align-items:center; justify-content:center;
  background:rgba(0,0,0,.25); z-index:5000; padding:20px;
}

/* Dialog */
.calendar_admin_details_lesson_info_date_time_calendar_dialog{
  width:360px; max-width:95vw; background:#fff; border-radius:18px;
  box-shadow:0 18px 50px rgba(0,0,0,.22); padding:14px 14px 18px;
}

/* Header */
.calendar_admin_details_lesson_info_date_time_calendar_header{
  display:flex; align-items:center; justify-content:space-between; margin-bottom:6px;
}
.calendar_admin_details_lesson_info_date_time_calendar_month{
  margin:0; font-weight:800; font-size:1.25rem; color:#111;
}
.calendar_admin_details_lesson_info_date_time_calendar_nav{
  width:42px; height:42px; border-radius:12px; background:#f5f6fb; border:1px solid #ececf3;
  display:grid; place-items:center; cursor:pointer;
}

/* Weekdays + grid */
.calendar_admin_details_lesson_info_date_time_calendar_weekdays{
  display:grid; grid-template-columns:repeat(7,1fr); gap:6px;
  color:#8b8b95; font-weight:800; font-size:12px; margin:8px 4px 6px;
}
.calendar_admin_details_lesson_info_date_time_calendar_grid{
  display:grid; grid-template-columns:repeat(7,1fr); gap:6px; padding:0 4px;
}
.calendar_admin_details_lesson_info_date_time_calendar_day{
  height:44px; border-radius:12px; border:1px solid transparent; background:#fff;
  display:flex; align-items:center; justify-content:center; cursor:pointer; font-weight:700; color:#20242c;
}
.calendar_admin_details_lesson_info_date_time_calendar_day:hover{
  background:#f7f8fb;
}
.calendar_admin_details_lesson_info_date_time_calendar_day--selected{
  border-color:#ff3b00; color:#ff3b00; background:#fff;
}

/* Done button */
.calendar_admin_details_lesson_info_date_time_calendar_done{
  margin-top:14px; width:100%; height:52px;
  background:#ff3b00; color:#fff; border:0; border-radius:16px;
  font-weight:900; letter-spacing:.2px; cursor:pointer;
}
</style>

<!-- Calendar modal (shared) -->
<div id="calendar_admin_details_lesson_info_date_time_calendar_backdrop"
     class="calendar_admin_details_lesson_info_date_time_calendar_backdrop"
     aria-hidden="true">
  <div class="calendar_admin_details_lesson_info_date_time_calendar_dialog"
       role="dialog" aria-modal="true" aria-labelledby="calendar_admin_details_lesson_info_date_time_calendar_title">
    <div class="calendar_admin_details_lesson_info_date_time_calendar_header">
      <button type="button" class="calendar_admin_details_lesson_info_date_time_calendar_nav"
              id="calendar_admin_details_lesson_info_date_time_calendar_prev" aria-label="Previous month">
        <svg width="20" height="20" viewBox="0 0 24 24"><polyline points="15 19 8 12 15 5" fill="none" stroke="#111" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg>
      </button>

      <h5 id="calendar_admin_details_lesson_info_date_time_calendar_title"
          class="calendar_admin_details_lesson_info_date_time_calendar_month">August 2025</h5>

      <button type="button" class="calendar_admin_details_lesson_info_date_time_calendar_nav"
              id="calendar_admin_details_lesson_info_date_time_calendar_next" aria-label="Next month">
        <svg width="20" height="20" viewBox="0 0 24 24"><polyline points="9 19 16 12 9 5" fill="none" stroke="#111" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg>
      </button>
    </div>

    <div class="calendar_admin_details_lesson_info_date_time_calendar_weekdays">
      <div>Mo</div><div>Tu</div><div>We</div><div>Th</div><div>Fr</div><div>Sa</div><div>Su</div>
    </div>

    <div id="calendar_admin_details_lesson_info_date_time_calendar_grid"
         class="calendar_admin_details_lesson_info_date_time_calendar_grid"></div>

    <button type="button"
            id="calendar_admin_details_lesson_info_date_time_calendar_done"
            class="calendar_admin_details_lesson_info_date_time_calendar_done">
      Done
    </button>
  </div>
</div>


<script>
(function($){
  // State
  var _targetBtn = null;           // jQuery object of the button that opened the calendar
  var _sel = new Date();           // currently selected date
  var _viewY = _sel.getFullYear(); // month being viewed
  var _viewM = _sel.getMonth();

  var $bd = $('#calendar_admin_details_lesson_info_date_time_calendar_backdrop');
  var $grid = $('#calendar_admin_details_lesson_info_date_time_calendar_grid');
  var $title = $('#calendar_admin_details_lesson_info_date_time_calendar_title');

  // Helpers
  function fmtLong(d){
    return d.toLocaleDateString(undefined,{weekday:'long',year:'numeric',month:'long',day:'numeric'});
  }
  function monthName(y,m){
    return new Date(y,m,1).toLocaleString(undefined,{month:'long'})+' '+y;
  }
  function isoDate(d){
    return d.toISOString().slice(0,10);
  }
  function parseISO(s){
    // s: "YYYY-MM-DD"
    var p = (s||'').split('-'); if(p.length!==3) return new Date();
    return new Date(+p[0], +p[1]-1, +p[2]);
  }

  // Render calendar grid (weeks start Monday)
  function render(){
    $title.text(monthName(_viewY,_viewM));
    $grid.empty();

    var first = new Date(_viewY,_viewM,1);
    var startIdx = (first.getDay()+6)%7; // Monday=0
    var daysInMonth = new Date(_viewY,_viewM+1,0).getDate();

    for(var i=0;i<startIdx;i++) $grid.append('<div></div>');

    for(var d=1; d<=daysInMonth; d++){
      (function(day){
        var dateObj = new Date(_viewY,_viewM,day);
        var $b = $('<button type="button" class="calendar_admin_details_lesson_info_date_time_calendar_day"></button>').text(day);
        if(dateObj.toDateString() === _sel.toDateString()){
          $b.addClass('calendar_admin_details_lesson_info_date_time_calendar_day--selected');
        }
        $b.on('click', function(){
          _sel = dateObj;
          $grid.find('.calendar_admin_details_lesson_info_date_time_calendar_day--selected')
               .removeClass('calendar_admin_details_lesson_info_date_time_calendar_day--selected');
          $(this).addClass('calendar_admin_details_lesson_info_date_time_calendar_day--selected');
        });
        $grid.append($b);
      })(d);
    }
  }

  function openWithSeed($button, iso){
    _targetBtn = $button;
    var base = iso ? parseISO(iso) : new Date();
    _sel = new Date(base.getFullYear(), base.getMonth(), base.getDate());
    _viewY = _sel.getFullYear(); _viewM = _sel.getMonth();
    render();
    $bd.css('display','flex').hide().fadeIn(120);
  }
  function close(){
    $bd.fadeOut(120, function(){ $bd.hide(); });
  }

  // Navigation
  $('#calendar_admin_details_lesson_info_date_time_calendar_prev').on('click', function(){
    _viewM--; if(_viewM<0){_viewM=11; _viewY--;} render();
  });
  $('#calendar_admin_details_lesson_info_date_time_calendar_next').on('click', function(){
    _viewM++; if(_viewM>11){_viewM=0; _viewY++;} render();
  });

  // Done -> write back to the opening pill
  $('#calendar_admin_details_lesson_info_date_time_calendar_done').on('click', function(){
    if(!_targetBtn) return close();
    var $span = $('#calendar_admin_details_lesson_info_date_time_from_text'); // works for your current row
    // If you later reuse for "until", pass its span via event payload; see hook below.

    _targetBtn.attr('data-iso', isoDate(_sel));
    $span.text(fmtLong(_sel));
    close();
  });

  // Backdrop click / ESC
  $bd.on('click', function(e){ if(e.target === this) close(); });
  $(document).on('keydown', function(e){ if(e.key==='Escape' && $bd.is(':visible')) close(); });

  // === Hook: open when the date pill event fires (from our row script) ===
  // payload: { $button, iso, label, $span (optional) }
  $(document).on('calendar_admin_details_lesson_info_date_time:open_datepicker', function(_e, payload){
    // If caller provides a specific span to update, swap it in
    if (payload && payload.$span) {
      // temporarily map the DOM id we write into on Done:
      $('#calendar_admin_details_lesson_info_date_time_from_text').attr('id','__tmp_old_from_text');
      $(payload.$span).attr('id','calendar_admin_details_lesson_info_date_time_from_text');
      $('#__tmp_old_from_text').attr('id','calendar_admin_details_lesson_info_date_time_from_text_backup');
      $('#calendar_admin_details_lesson_info_date_time_from_text_backup').removeAttr('id'); // clean
    }
    openWithSeed(payload && payload.$button ? payload.$button : null, payload && payload.iso ? payload.iso : '');
  });

})(jQuery);
</script>
