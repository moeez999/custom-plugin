  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600&display=swap" rel="stylesheet">

  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  <link rel="stylesheet" href="css/calendar_admin_details.css">
  <link rel="stylesheet" href="css/calendar_admin_details_create_cohort_tab_details.css">
  <link rel="stylesheet" href="css/calendar_admin_details_create_cohort_class_tab.css">
  <link rel="stylesheet" href="css/calendar_admin_details_create_cohort_merge_tab.css">
  <link rel="stylesheet" href="css/calendar_admin_details_create_cohort_add_time_tab.css">
  <link rel="stylesheet" href="css/calendar_admin_details_create_cohort.css">

<div class="calendar_admin_main_wrapper">

    <!-- Sidebar -->
    <aside class="calendar_admin_sidebar">
      <button class="calendar_admin_btn calendar_admin_btn_active" id="calendar_admin_details_create_cohort_open">Create Cohort</button>
      <button class="calendar_admin_btn">Manage Cohort</button>
      <button class="calendar_admin_btn" id="calendar_admin_details_merge">Merge Cohort</button>
      <button class="calendar_admin_btn" id="calendar_admin_details_1_1_class">1:1 Class</button>
      <button class="calendar_admin_btn" id="calendar_admin_details_conference">Conference</button>
      <button class="calendar_admin_btn" id="calendar_admin_details_peer_talk">Peer talk</button>
      <button class="calendar_admin_btn" id="calendar_admin_details_add_time_off">Add time off</button>
      <button class="calendar_admin_btn" id="calendar_admin_details_add_extra_slots">Add Extra Slots</button>
      <button class="calendar_admin_btn">Setup Availability</button>
      <div class="calendar_admin_tags_section">
        <h3>Tags</h3>
        <ul class="calendar_admin_tags_list">
          <li><span class="calendar_admin_tag_icon calendar_admin_tag_first"></span>First Student</li>
          <li><span class="calendar_admin_tag_icon calendar_admin_tag_student"></span>Student Class</li>
          <li><span class="calendar_admin_tag_icon calendar_admin_tag_cohort"></span>Cohort Class</li>
          <li><span class="calendar_admin_tag_icon calendar_admin_tag_conversation"></span>Conversational Class</li>
          <li><span class="calendar_admin_tag_icon calendar_admin_tag_busy"></span>Busy Time</li>
          <li><span class="calendar_admin_tag_icon calendar_admin_tag_google"></span>Google Calendar</li>
        </ul>
        <h3>Lesson status</h3>
        <ul class="calendar_admin_status_list">
          <li><span class="calendar_admin_status_icon calendar_admin_status_icon_confirmed"></span>Confirmed by the student</li>
          <li><span class="calendar_admin_status_icon calendar_admin_status_icon_not_confirmed"></span>Not confirmed by the student</li>
          <li><img src="https://cdn.jsdelivr.net/gh/twitter/twemoji@14.0.2/assets/svg/1F501.svg" style="width:14px;margin-right:6px;vertical-align:middle;">Weekly Class</li>
          <li><img src="https://cdn.jsdelivr.net/gh/twitter/twemoji@14.0.2/assets/svg/1F4C5.svg" style="width:14px;margin-right:6px;vertical-align:middle;">Single class</li>
        </ul>
      </div>
    </aside>




    <!-- Calendar Main -->
    <main class="calendar_admin_calendar_outer">
      <!-- Header -->
      <div class="calendar_admin_calendar_header">


  <button class="calendar_arrow_btn" id="prev-week">
    <svg width="20" height="20" viewBox="0 0 24 24">
      <polyline points="15 19 8 12 15 5" fill="none" stroke="#222" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
    </svg>
  </button>
  <button class="calendar_arrow_btn" id="next-week">
    <svg width="20" height="20" viewBox="0 0 24 24">
      <polyline points="9 5 16 12 9 19" fill="none" stroke="#222" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
    </svg>
  </button>
  <span class="calendar_admin_calendar_title" id="calendar-range"></span>



  <div class="calendar_admin_header_section">
      <div class="cohort-select dropdown" id="cohort-select">
        <span class="cohort-icon">&#9776;</span>
        Cohorts
        <span class="dropdown-arrow"><i class="fa fa-chevron-down" style="font-size:14px;"></i></span>
        <div class="dropdown-menu" id="cohort-dropdown">
          <form class="cohort-dropdown-list">
            <label><input type="checkbox" id="select-all-cohorts"> Select All</label>
            <label><input type="checkbox" name="cohort" value="FL1"> FL1</label>
            <label><input type="checkbox" name="cohort" value="FL2"> FL2</label>
            <label><input type="checkbox" name="cohort" value="TX1"> TX1</label>
            <label><input type="checkbox" name="cohort" value="TX2"> TX2</label>
          </form>
        </div>
      </div>


      <!-- Profile Dropdown -->
      <div class="profile-dropdown profile-dropdown-trigger" id="profile-dropdown-trigger">
        <img src="https://randomuser.me/api/portraits/women/15.jpg" class="profile-pic" alt="profile">
        dlinela
        <span class="dropdown-arrow"><i class="fa fa-chevron-down" style="font-size:14px;"></i></span>
        <div class="dropdown-menu profile-menu" id="profile-dropdown">
          <div class="profile-dropdown-list">
            <div class="profile-option"><div class="profile-option-header"><img src="https://randomuser.me/api/portraits/men/32.jpg"> Edwards</div></div>
            <div class="profile-option"><div class="profile-option-header"><img src="https://randomuser.me/api/portraits/women/15.jpg"> Daniela</div></div>
            <div class="profile-option"><div class="profile-option-header"><img src="https://randomuser.me/api/portraits/men/15.jpg"> Hawkins</div></div>
            <div class="profile-option"><div class="profile-option-header"><img src="https://randomuser.me/api/portraits/men/45.jpg"> Warren</div></div>
          </div>
        </div>
      </div>

          <button class="calendar_admin_menu_btn" style="background:#f7f7ff;color:#111;">Today</button>
          
          <div class="mb-3">
            <button class="calendar_admin_menu_btn calendar_admin_menu_btn_active" id="calendar_admin_semana_btn">
              Semana
            </button>
            <button class="calendar_admin_menu_btn" id="calendar_admin_agenda_btn" style="background:transparent;color:#bbb;">
              Agenda
            </button>
          </div>

        </div>
      </div>
















      
      
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8" />
<meta name="viewport" content="width=device-width,initial-scale=1" />
<title>Week Calendar – 7:00 start, 30m slots (no lines in gutter)</title>
<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<style>
  :root{
    --start-hour: 7;             /* grid starts at 7:00 AM */
    --end-hour: 24;

    /* 30-minute grid */
    --slot-h: 36px;              /* height of each 30 min slot */
    --rows: 34;                  /* set by JS: (end-start)*2 */

    /* colors */
    --page-bg:  #f5f6fb;
    --day-bg:   #f6f7fb;         /* empty-slot fill */
    --slot-line:#e6e8f2;         /* half-hour line */
    --hour-line:#dfe2ec;         /* stronger hour line */
    --col-border:#e1e3ec;        /* vertical day separators */

    --text: #0f1320;
    --muted:#6b7280;

    --event-radius: 5px;
    --stack-offset: 18px;        /* overlap offset */
    --stack-cap: 3;
  }

  *{box-sizing:border-box}
  body{margin:0;background:var(--page-bg);font-family:Inter,system-ui,Segoe UI,Roboto,Arial,sans-serif;color:var(--text)}
  .wrap{max-width:1220px;margin:20px auto;padding:0 14px}
  .cal{
    background:#fff;border:1px solid var(--col-border);border-radius:18px;overflow:hidden;
    box-shadow:0 10px 30px rgba(20,20,40,.08);
    width:1190px;
  }

  /* Header */
  .cal-head{
    display:grid;grid-template-columns:84px repeat(7,1fr);
    border-bottom:1px solid var(--col-border);background:#fafbff
  }
  .cal-head .gutter{border-right:1px solid var(--col-border)}
  .day-h{padding:14px 6px 12px;text-align:center}
  .day-h .dow{
    /* font-weight:700; */
    font-size:15px;
  
  }
  .day-h .dt{display:block;margin-top:2px;color:var(--muted);font-weight:600;font-size:13px}

  /* Grid (30m rows) */
  .grid{
    display:grid;grid-template-columns:84px repeat(7,1fr);
    max-height: calc(var(--rows) * var(--slot-h) + 2px);
    overflow:auto;
  }

  /* Time gutter (no slot lines here) */
  .gutter{
    position:sticky;left:0;z-index:5;background:#fff;border-right:1px solid var(--col-border)
  }
  .time-row{
    height:var(--slot-h);
    position:relative;
    /* remove any lines from the gutter */
    border-top: none !important;
  }
  .time-label{
    position:absolute; right:8px;
    background:#fff; padding:0 4px; font-size:12px; color:var(--muted);
    font-weight:600; line-height:1;
    /* place the label at the middle of the hour (between the two 30m slots) */
    top: calc(var(--slot-h) - 0.7em);
  }

  /* Day columns: gray background + real 30m borders with stronger hour lines */
  .day{
    position:relative; background:var(--day-bg);
    border-left:1px solid var(--col-border);     /* vertical day separators */
  }
  .day-inner{ position:relative; height:calc(var(--rows) * var(--slot-h)); }
  .day-inner .slots{
    position:absolute; inset:0; pointer-events:none; z-index:0;
    display:grid; grid-template-rows:repeat(var(--rows), var(--slot-h));
  }
  .day-inner .slots > div{ border-top:1px solid var(--slot-line); }
  .day-inner .slots > div:first-child{ border-top-color:var(--hour-line); }      /* 7:00 */
  .day-inner .slots > div:nth-child(2n+1){ border-top-color:var(--hour-line); }  /* each hour */

  /* Events (stacked-overlap, wide) */
  .event{
    position:absolute; z-index:1;
    background:#fff;border:2.5px solid #1f57ff;border-radius:var(--event-radius);
    padding:10px 12px;box-shadow:0 8px 18px rgba(25,35,60,.08);
    display:flex;flex-direction:column;gap:6px;overflow:hidden;
    width:calc(96% - 4px); left:4px;
  }
  .title{
    /* font-weight:800; */
    font-size:14px;
    letter-spacing:.2px;
  
  }
  .time{font-size:12px;font-weight:700;color:var(--muted)}
  .chip{display:inline-flex;align-items:center;gap:6px;font-size:12px;font-weight:700;color:#374151}
  .avatar{width:22px;height:22px;border-radius:50%;object-fit:cover;border:2px solid #fff;box-shadow:0 0 0 1px rgba(0,0,0,.05)}

  /* Color variants */
  .e-blue{border-color:#1f57ff}
  .e-green{border-color:#2faa7f}
  .e-rose{border-color:#ea3a3a}
  .e-purple{border-color:#a855f7}
  .e-gold{border-color:#d4a017}
  .e-gray{border-color:#d3d7df;background:#f4f5f8}

  /* Now line */
  .now{position:absolute;left:0;right:0;height:2px;background:#ff3b30;z-index:2}
  .now:before{content:"";position:absolute;width:10px;height:10px;border-radius:50%;background:#ff3b30;transform:translate(-50%,-4px)}

  @media (max-width:700px){
    .cal-head,.grid{grid-template-columns:70px repeat(7,320px)}
  }
</style>
</head>
<body>
<div class="wrap">
  <div class="cal">
    <div id="head" class="cal-head"><div class="gutter"></div></div>
    <div id="grid" class="grid">
      <div id="gutter" class="gutter"></div>
    </div>
  </div>
</div>

<script>
/* ===== CONFIG ===== */
const WEEK_START = new Date(2025,7,4);     // Monday Aug 4, 2025
const START_H = 7;                          // start at 7:00 AM
const END_H   = 24;
const SLOT_MIN = 30;                        // 2 slots per hour
const SLOT_H   = parseInt(getComputedStyle(document.documentElement).getPropertyValue('--slot-h')) || 36;
const PX_PER_MIN = SLOT_H / SLOT_MIN;
const STACK_OFFSET = parseInt(getComputedStyle(document.documentElement).getPropertyValue('--stack-offset')) || 18;
const STACK_CAP    = parseInt(getComputedStyle(document.documentElement).getPropertyValue('--stack-cap')) || 3;

/* Demo events */
const events = [
  { day:0, title:"FL1",          start:"07:00", end:"09:20", color:"e-blue",  repeat:true },
  { day:1, title:"Jonas",        start:"19:00", end:"19:25", color:"e-green", repeat:true },
  { day:2, title:"Conversation", start:"07:00", end:"08:00", color:"e-blue",  repeat:true },
  { day:2, title:"Conversation", start:"07:00", end:"08:00", color:"e-blue",  repeat:true },
  { day:2, title:"Conversation", start:"07:00", end:"08:00", color:"e-blue",  repeat:true },
  { day:2, title:"Team Meeting", start:"09:00", end:"10:00", color:"e-gray" },
  { day:5, title:"Peer Talk",    start:"07:30", end:"08:30", color:"e-purple",repeat:true },
  { day:4, title:"Mary Janes",   start:"09:00", end:"10:00", color:"e-blue",  avatar:"https://randomuser.me/api/portraits/women/44.jpg", repeat:true },
  { day:2, title:"Mary Janes",   start:"11:00", end:"12:00", color:"e-blue",  avatar:"https://randomuser.me/api/portraits/women/68.jpg" },
  { day:2, title:"Conversation", start:"12:00", end:"13:00", color:"e-blue",  repeat:true },
  { day:3, title:"Peer Talk",    start:"12:00", end:"13:00", color:"e-purple",repeat:true },
];

$(function(){
  const rows = (END_H - START_H) * (60 / SLOT_MIN);
  document.documentElement.style.setProperty('--rows', rows);

  const $head = $('#head'), $grid = $('#grid'), $gut = $('#gutter');
  const DOW = ['Mon','Tue','Wed','Thu','Fri','Sat','Sun'];

  // Header
  for(let i=0;i<7;i++){
    const d = new Date(WEEK_START); d.setDate(d.getDate()+i);
    $('<div class="day-h">')
      .append(`<span class="dow">${DOW[i]}</span>`)
      .append(`<span class="dt">${d.getDate()}</span>`)
      .appendTo($head);
  }

  // Time gutter: build 30m rows; label EVERY hour (7:00, 8:00, ...)
  for(let m=START_H*60; m<=END_H*60; m += SLOT_MIN){
    const $row = $('<div class="time-row">');
    if(m % 60 === 0){
      $row.append(`<div class="time-label">${fmt12(m)}</div>`);
    }
    $gut.append($row);
  }

  // Day columns with real borders for each 30m slot
  const dayEls = [];
  for(let i=0;i<7;i++){
    const $col   = $('<div class="day">');
    const $inner = $('<div class="day-inner">').appendTo($col);
    const $slots = $('<div class="slots">').appendTo($inner);
    for(let r=0;r<rows;r++){ $('<div>').appendTo($slots); }
    $grid.append($col);
    dayEls.push($inner); // events attach here
  }

  // Stacked-overlap layout
  const perDay = Array.from({length:7}, ()=>[]);
  events.forEach(e => perDay[e.day].push(prep(e)));

  perDay.forEach((list, di)=>{
    list.sort((a,b)=> a.start - b.start || a.end - b.end);
    const active = [];
    list.forEach(ev=>{
      for(let i=active.length-1;i>=0;i--) if(active[i].end <= ev.start) active.splice(i,1);
      ev.stackIndex = Math.min(active.length, STACK_CAP-1);
      active.push(ev);

      const top = (ev.start - START_H*60) * PX_PER_MIN;
      const h   = (ev.end   - ev.start) * PX_PER_MIN - 4;

      const leftPx = 4 + ev.stackIndex*STACK_OFFSET;
      const $ev = $(`<div class="event ${ev.color}">
          <div class="title">${ev.title}</div>
          <div class="time">${fmt12(ev.start)} – ${fmt12(ev.end)}</div>
          ${ev.avatar||ev.repeat ? `<div class="chip">
            ${ev.avatar? `<img class="avatar" src="${ev.avatar}" alt="">`:''}
            ${ev.repeat? '&#8635;':''}
          </div>`:''}
        </div>`).css({
          top: top+'px',
          height: h+'px',
          left: leftPx+'px',
          width: `calc(96% - ${leftPx}px)`
        });

      dayEls[di].append($ev);
    });
  });

  // Now line
  drawNow(); setInterval(drawNow, 60*1000);
  function drawNow(){
    $('.now').remove();
    const now = new Date();
    const ws = new Date(WEEK_START), we = new Date(ws); we.setDate(we.getDate()+7);
    if(now<ws || now>=we) return;
    const di = (now.getDay()+6)%7;
    const mins = now.getHours()*60 + now.getMinutes();
    if(mins < START_H*60 || mins > END_H*60) return;
    const y = (mins - START_H*60) * PX_PER_MIN;
    $('<div class="now">').css({top:y}).appendTo(dayEls[di]);
  }

  // helpers
  function prep(e){
    const [sh,sm]=e.start.split(':').map(Number);
    const [eh,em]=e.end.split(':').map(Number);
    return {...e,start:sh*60+sm,end:eh*60+em};
  }
  function fmt12(min){
    let h=Math.floor(min/60), m=min%60, ap=h>=12?'PM':'AM'; h=(h%12)||12;
    return `${h}:${String(m).padStart(2,'0')} ${ap}`;
  }
});
</script>
</body>
</html>














       <?php require_once('calendar_admin_details_agenda_tab.php'); ?>

    </main>
  </div>

  

<script>
$(function() {
  // On "Semana" button click
  $('#calendar_admin_semana_btn').on('click', function() {
    $(this).addClass('calendar_admin_menu_btn_active')
      .css({'background':'', 'color':''});
    $('#calendar_admin_agenda_btn')
      .removeClass('calendar_admin_menu_btn_active')
      .css({'background':'transparent', 'color':'#bbb'});
    $('#calendar_admin_calendar_flexrow').show();
    $('#calendar_admin_agenda_content').hide();
  });

  // On "Agenda" button click
  $('#calendar_admin_agenda_btn').on('click', function() {
    $(this).addClass('calendar_admin_menu_btn_active')
      .css({'background':'', 'color':''});
    $('#calendar_admin_semana_btn')
      .removeClass('calendar_admin_menu_btn_active')
      .css({'background':'transparent', 'color':'#bbb'});
    $('#calendar_admin_calendar_flexrow').hide();
    $('#calendar_admin_agenda_content').show();
  });
});
</script>


<script src="js/calendar_admin_details.js"></script>
<?php require_once('calendar_admin_details_create_cohort.php'); ?>
<script src="js/calendar_admin_details_create_cohort_tab_details.js"></script>
<script src="js/calendar_admin_details_create_cohort_class_tab.js"></script>
<script src="js/calendar_admin_details_create_cohort_merge_tab.js"></script>
<script src="js/calendar_admin_details_create_cohort_add_time_tab.js"></script>

<script src="js/calendar_admin_details_create_cohort.js"></script>

