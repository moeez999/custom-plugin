<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Schedule your lessons</title>
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  <style>
    /* page layout */
    #my_lesson_tutor_profile_details_schedule_lesson_page {
      font-family: system-ui, sans-serif;
      display: flex;
      justify-content: space-between;
      padding: 20px;
      box-sizing: border-box;
    }

    /* LEFT SIDE */
    .my_lesson_tutor_profile_details_schedule_lesson_left {
      flex: 1;
      max-width: 65%;
    }
    .my_lesson_tutor_profile_details_schedule_lesson_header {
      display: flex;
      align-items: center;
      margin-bottom: 24px;
    }
    .my_lesson_tutor_profile_details_schedule_lesson_header img {
      height: 36px;
      margin-right: 12px;
    }
    .my_lesson_tutor_profile_details_schedule_lesson_header h1 {
      font-size: 24px;
      margin: 0;
    }

    /* TOP "Weekly / Single" TABS */
    .my_lesson_tutor_profile_details_schedule_lesson_type_tabs {
      display: flex;
      border: 1px solid #e0e0e0;
      border-radius: 8px;
      overflow: hidden;
      margin-bottom: 16px;
    }
    .my_lesson_tutor_profile_details_schedule_lesson_type_tab {
      flex: 1;
      background: #f6f7fa;
      border: none;
      padding: 16px;
      text-align: left;
      cursor: pointer;
    }
    .my_lesson_tutor_profile_details_schedule_lesson_type_tab.active {
      background: #fff;
    }
    .my_lesson_tutor_profile_details_schedule_lesson_type_tab .icon {
      font-size: 18px;
      vertical-align: middle;
      margin-right: 8px;
    }
    .my_lesson_tutor_profile_details_schedule_lesson_type_tab .title {
      font-weight: 500;
      font-size: 16px;
      display: inline-block;
      vertical-align: middle;
    }
    .my_lesson_tutor_profile_details_schedule_lesson_type_tab .desc {
      display: block;
      margin-top: 4px;
      font-size: 14px;
      color: #777;
    }

    /* DAY TABS */
    .my_lesson_tutor_profile_details_schedule_lesson_day_tabs {
      display: flex;
      gap: 16px;
      margin-bottom: 4px;
    }
    .my_lesson_tutor_profile_details_schedule_lesson_day_tab {
      flex: 1;
      background: none;
      border: none;
      font-size: 16px;
      color: #888;
      cursor: pointer;
      padding: 8px 0;
    }
    .my_lesson_tutor_profile_details_schedule_lesson_day_tab.active {
      color: #FF4740;
      font-weight: 500;
    }
    .my_lesson_tutor_profile_details_schedule_lesson_day_tab.has-selection {
      color: #000;
      font-weight: 500;
    }

    /* TIMEZONE INFO */
    .my_lesson_tutor_profile_details_schedule_lesson_timezone {
      font-size: 12px;
      color: #888;
      margin-bottom: 12px;
    }

    /* SCHEDULE GRID */
    .my_lesson_tutor_profile_details_schedule_lesson_grid {
      display: grid;
      grid-template-columns: repeat(7, 1fr);
      column-gap: 12px;
      row-gap: 12px;
    }
    .my_lesson_tutor_profile_details_schedule_lesson_time_slot {
      border: 1px solid #ccc;
      border-radius: 8px;
      padding: 10px 0;
      text-align: center;
      cursor: pointer;
      user-select: none;
      font-size: 14px;
      color: #333;
      background: #fff;
    }
    .my_lesson_tutor_profile_details_schedule_lesson_time_slot.selected {
      background: #000;
      color: #fff;
      border-color: #000;
    }

    /* RIGHT SIDE PANEL */
    .my_lesson_tutor_profile_details_schedule_lesson_side_panel {
      width: 300px;
      background: #fff;
      border-radius: 8px;
      box-shadow: 0 2px 12px rgba(0,0,0,0.1);
      padding: 20px;
      box-sizing: border-box;
      position: relative;
    }
    .my_lesson_tutor_profile_details_schedule_lesson_side_panel img {
      width: 100%;
      border-radius: 4px;
      margin-bottom: 12px;
    }
    .my_lesson_tutor_profile_details_schedule_lesson_side_panel h3 {
      margin: 0 0 4px;
      font-size: 18px;
    }

    /* -- NEW: Lesson-duration dropdown -- */
    .lesson-duration-container {
      position: relative;
      margin-bottom: 16px;
    }
    .lesson-duration {
      font-size: 14px;
      color: #555;
      padding: 8px 12px;
      border: 1px solid #ccc;
      border-radius: 6px;
      cursor: pointer;
      background: #fff;
      display: inline-block;
      user-select: none;
    }
    .lesson-duration-dropdown {
      display: none;
      position: absolute;
      top: 100%;
      left: 0;
      margin-top: 4px;
      width: 180px;
      background: #fff;
      border: 1px solid #e0e0e0;
      border-radius: 8px;
      box-shadow: 0 4px 12px rgba(0,0,0,0.15);
      list-style: none;
      padding: 8px 0;
      z-index: 1001;
    }
    .lesson-duration-dropdown li {
      padding: 8px 16px;
      cursor: pointer;
      position: relative;
      font-size: 14px;
      white-space: nowrap;
    }
    .lesson-duration-dropdown li:hover {
      background: #f6f7fa;
    }
    .lesson-duration-dropdown li.selected {
      font-weight: 500;
    }
    .lesson-duration-dropdown li .check {
      position: absolute;
      right: 16px;
      top: 50%;
      transform: translateY(-50%);
      color: #FF4740;
      font-size: 14px;
    }

    /* back to your existing styles */
    .my_lesson_tutor_profile_details_schedule_lesson_count {
      font-size: 16px;
      margin: 0 0 12px;
      font-weight: 500;
    }
    .my_lesson_tutor_profile_details_schedule_lesson_selected_list {
      list-style: none;
      padding: 0;
      margin: 0 0 16px;
    }
    .my_lesson_tutor_profile_details_schedule_lesson_selected_list li {
      border: 1px solid #000;
      border-radius: 6px;
      padding: 8px 12px;
      margin-bottom: 8px;
      position: relative;
      font-size: 14px;
      background: #fff;
    }
    .my_lesson_tutor_profile_details_schedule_lesson_selected_list .lesson-info {
      margin-bottom: 4px;
    }
    .my_lesson_tutor_profile_details_schedule_lesson_selected_list .start-date {
      font-size: 12px;
      color: #555;
    }
    .my_lesson_tutor_profile_details_schedule_lesson_selected_list .remove-lesson {
      position: absolute;
      top: 4px; right: 6px;
      cursor: pointer;
      font-weight: bold;
    }
    .my_lesson_tutor_profile_details_schedule_lesson_schedule_btn {
      display: block;
      width: 100%;
      padding: 12px 0;
      background: #ff2d00;
      color: #fff;
      border: none;
      border-radius: 6px;
      font-size: 16px;
      cursor: pointer;
      margin-bottom: 12px;
    }
    .my_lesson_tutor_profile_details_schedule_lesson_side_panel p {
      font-size: 12px;
      color: #666;
      text-align: center;
      margin: 0;
    }
  </style>
</head>
<body>

<div id="my_lesson_tutor_profile_details_schedule_lesson_page">
  <!-- LEFT: scheduler -->
  <div class="my_lesson_tutor_profile_details_schedule_lesson_left">
    <!-- header -->
    <div class="my_lesson_tutor_profile_details_schedule_lesson_header">
      <img src="logo.png" alt="Logo">
      <h1>Schedule your lessons</h1>
    </div>
    <!-- type tabs -->
    <div class="my_lesson_tutor_profile_details_schedule_lesson_type_tabs">
      <button class="my_lesson_tutor_profile_details_schedule_lesson_type_tab active" data-mode="weekly">
        <span class="icon">↻</span>
        <span class="title">Weekly lessons</span>
        <span class="desc">Repeat lessons at the same time every week</span>
      </button>
      <button class="my_lesson_tutor_profile_details_schedule_lesson_type_tab" data-mode="single">
        <span class="icon">📅</span>
        <span class="title">Single lessons</span>
        <span class="desc">Choose different times for each lesson</span>
      </button>
    </div>
    <!-- day tabs -->
    <div class="my_lesson_tutor_profile_details_schedule_lesson_day_tabs">
      <button class="my_lesson_tutor_profile_details_schedule_lesson_day_tab">Monday</button>
      <button class="my_lesson_tutor_profile_details_schedule_lesson_day_tab active">Tuesday</button>
      <button class="my_lesson_tutor_profile_details_schedule_lesson_day_tab">Wednesday</button>
      <button class="my_lesson_tutor_profile_details_schedule_lesson_day_tab">Thursday</button>
      <button class="my_lesson_tutor_profile_details_schedule_lesson_day_tab">Friday</button>
      <button class="my_lesson_tutor_profile_details_schedule_lesson_day_tab">Saturday</button>
      <button class="my_lesson_tutor_profile_details_schedule_lesson_day_tab">Sunday</button>
    </div>
    <!-- timezone info -->
    <div class="my_lesson_tutor_profile_details_schedule_lesson_timezone">
      In your time zone: America/New_York (GMT –5:00)
    </div>
    <!-- 7-column time-grid -->
    <div class="my_lesson_tutor_profile_details_schedule_lesson_grid">
      <div class="my_lesson_tutor_profile_details_schedule_lesson_time_slot" data-day="Tuesday"  data-time="03:00" style="grid-column:2; grid-row:2">03:00</div>
      <div class="my_lesson_tutor_profile_details_schedule_lesson_time_slot" data-day="Friday"   data-time="05:00" style="grid-column:5; grid-row:3">05:00</div>
      <div class="my_lesson_tutor_profile_details_schedule_lesson_time_slot" data-day="Friday"   data-time="05:30" style="grid-column:5; grid-row:4">05:30</div>
      <div class="my_lesson_tutor_profile_details_schedule_lesson_time_slot" data-day="Friday"   data-time="06:00" style="grid-column:5; grid-row:5">06:00</div>
      <div class="my_lesson_tutor_profile_details_schedule_lesson_time_slot" data-day="Friday"   data-time="06:30" style="grid-column:5; grid-row:6">06:30</div>
      <div class="my_lesson_tutor_profile_details_schedule_lesson_time_slot" data-day="Friday"   data-time="07:00" style="grid-column:5; grid-row:7">07:00</div>
      <div class="my_lesson_tutor_profile_details_schedule_lesson_time_slot" data-day="Sunday"   data-time="05:00" style="grid-column:7; grid-row:3">05:00</div>
    </div>
  </div>

  <!-- RIGHT: side panel -->
  <div class="my_lesson_tutor_profile_details_schedule_lesson_side_panel">
    <img src="https://via.placeholder.com/280x140" alt="Teacher photo">
    <h3>English with Daniela</h3>

    <!-- DURATION DROPDOWN -->
    <div class="lesson-duration-container">
      <div class="lesson-duration">50 min lessons ▾</div>
      <ul class="lesson-duration-dropdown">
        <li data-minutes="25">25 Minutes</li>
        <li data-minutes="50" class="selected">
          50 Minutes <span class="check">✓</span>
        </li>
        <li data-minutes="60">1 Hour</li>
        <li data-minutes="90">1.5 Hour</li>
      </ul>
    </div>

    <h4 class="my_lesson_tutor_profile_details_schedule_lesson_count">0 lessons to schedule</h4>
    <ul class="my_lesson_tutor_profile_details_schedule_lesson_selected_list"></ul>
    <button class="my_lesson_tutor_profile_details_schedule_lesson_schedule_btn">Schedule Weekly Lesson</button>
    <p>Cancel or reschedule for free up to 12 hrs before the lesson starts.</p>
  </div>
</div>

<script>
$(function(){
  // ===== duration dropdown logic =====
  var lessonDuration = 50; // in minutes
  $('.lesson-duration').on('click', function(e){
    e.stopPropagation();
    $('.lesson-duration-dropdown').toggle();
  });
  $('.lesson-duration-dropdown li').on('click', function(e){
    e.stopPropagation();
    var $li = $(this);
    lessonDuration = parseInt($li.attr('data-minutes'),10);
    // update label
    $('.lesson-duration').text($li.text() + ' lessons ▾');
    // highlight
    $('.lesson-duration-dropdown li').removeClass('selected').find('.check').remove();
    $li.addClass('selected').append('<span class="check">✓</span>');
    $('.lesson-duration-dropdown').hide();
  });
  // click outside to close
  $(document).on('click', function(){
    $('.lesson-duration-dropdown').hide();
  });

  // ===== your existing tabs + grid logic =====
  $('.my_lesson_tutor_profile_details_schedule_lesson_type_tab').click(function(){
    $('.my_lesson_tutor_profile_details_schedule_lesson_type_tab').removeClass('active');
    $(this).addClass('active');
  });
  $('.my_lesson_tutor_profile_details_schedule_lesson_day_tab').click(function(){
    $('.my_lesson_tutor_profile_details_schedule_lesson_day_tab').removeClass('active');
    $(this).addClass('active');
  });

  // slot click
  $('.my_lesson_tutor_profile_details_schedule_lesson_time_slot').click(function(){
    var $slot = $(this),
        day   = $slot.data('day'),
        time  = $slot.data('time'),
        liId  = 'li_'+day+'_'+time.replace(':','-');

    $slot.toggleClass('selected');

    // day-tab highlight
    var any = $('.my_lesson_tutor_profile_details_schedule_lesson_time_slot.selected')
                .filter(function(){ return $(this).data('day')===day; }).length;
    $('.my_lesson_tutor_profile_details_schedule_lesson_day_tab')
      .filter(function(){ return $(this).text()===day; })
      .toggleClass('has-selection', any>0);

    // compute end-time
    var parts = time.split(':'), h=parseInt(parts[0],10), m=parseInt(parts[1],10);
    m += lessonDuration;
    h += Math.floor(m/60);
    m %= 60;
    var end = (h<10?'0':'')+h+ ':' + (m<10?'0':'')+m;

    var $list = $('.my_lesson_tutor_profile_details_schedule_lesson_selected_list');
    if($slot.hasClass('selected')){
      var d = new Date(),
          mo= d.toLocaleString('en-us',{month:'short'}),
          da= d.getDate(),
          dateStr = mo + ' ' + da;
      var $li = $('<li>').attr('id', liId)
        .append('<div class="lesson-info">Every '+day+', '+time+' – '+end+'</div>')
        .append('<div class="start-date">Starts on '+dateStr+'</div>')
        .append('<span class="remove-lesson">×</span>');
      $list.append($li);
    } else {
      $('#'+liId).remove();
    }

    // update count
    var count = $list.children().length;
    $('.my_lesson_tutor_profile_details_schedule_lesson_count')
      .text(count+' lesson'+(count!==1?'s':'')+' to schedule');
  });

  // remove click
  $(document).on('click','.remove-lesson',function(){
    var $li   = $(this).closest('li'),
        parts = $li.find('.lesson-info').text().match(/Every (.*), (\d{2}:\d{2})/),
        day   = parts[1],
        time  = parts[2],
        liId  = 'li_'+day+'_'+time.replace(':','-');
    $li.remove();
    // untoggle slot
    $('.my_lesson_tutor_profile_details_schedule_lesson_time_slot')
      .filter(function(){
        return $(this).data('day')===day && $(this).data('time')===time;
      }).removeClass('selected');
    // update day highlight
    var any = $('.my_lesson_tutor_profile_details_schedule_lesson_time_slot.selected')
                .filter(function(){ return $(this).data('day')===day; }).length;
    $('.my_lesson_tutor_profile_details_schedule_lesson_day_tab')
      .filter(function(){ return $(this).text()===day; })
      .toggleClass('has-selection', any>0);
    // update count
    var count = $('.my_lesson_tutor_profile_details_schedule_lesson_selected_list').children().length;
    $('.my_lesson_tutor_profile_details_schedule_lesson_count')
      .text(count+' lesson'+(count!==1?'s':'')+' to schedule');
  });
});
</script>
</body>
</html>
