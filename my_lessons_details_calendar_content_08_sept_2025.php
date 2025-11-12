<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8" />
<meta name="viewport" content="width=device-width, initial-scale=1" />
<title>My Lessons – Weekly Calendar</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>

<style>
  :root{
    --my-lessons-details-calendar-content-gutter: 78px;
    --my-lessons-details-calendar-content-slot-h: 56px;   /* 30-min height */
    --my-lessons-details-calendar-content-day-border:#ececf2;
    --my-lessons-details-calendar-content-grid-border:#f1f1f6;
    --my-lessons-details-calendar-content-muted:#8b8e98;
    --my-lessons-details-calendar-content-brand:#2764ff;
    --my-lessons-details-calendar-content-now:#ff3b1f;
    --my-lessons-details-calendar-content-shadow: 0 10px 22px rgba(20,20,20,.10);
    --my-lessons-details-calendar-content-font: Inter, system-ui, -apple-system, "Segoe UI", Roboto, "Helvetica Neue", Arial, "Noto Sans";
  }
  body{ font-family:var(--my-lessons-details-calendar-content-font); background:#fff; }

  /* Header */
  .my_lessons_details_calendar_content_header{
    display:flex; align-items:center; justify-content:space-between; gap:16px; padding:18px 8px 6px;
  }
  .my_lessons_details_calendar_content_nav{ display:flex; align-items:center; gap:12px; }

  /* Today (pill) */
  .my_lessons_details_calendar_content_btn_today{
    border:1px solid #dcdce6; background:#f5f5fb; height:44px; padding:0 16px; border-radius:12px; font-weight:700;
    box-shadow:0 2px 0 #ffffff inset;
  }

  /* Segmented arrows */
  .my_lessons_details_calendar_content_seg{
    display:flex; border:1px solid #dcdce6; border-radius:12px; overflow:hidden; height:44px; background:#fff;
  }
  .my_lessons_details_calendar_content_seg button{
    width:56px; height:100%; border:0; background:#fff; font-size:18px; line-height:1; display:flex; align-items:center; justify-content:center;
  }
  .my_lessons_details_calendar_content_seg button + button{ border-left:1px solid #e9e9f2; }
  .my_lessons_details_calendar_content_seg button:hover{ background:#f7f7fb; }
  .my_lessons_details_calendar_content_range{ font-weight:800; letter-spacing:.1px; margin-left:8px; }

  .my_lessons_details_calendar_content_legend{ display:flex; gap:22px; align-items:center; color:#333; font-weight:600; }
  .my_lessons_details_calendar_content_legend i{ margin-right:8px; }

  /* Week layout */
  .my_lessons_details_calendar_content_weekwrap{ padding:12px; }
  .my_lessons_details_calendar_content_week{ position:relative; display:flex; width:100%; }
  .my_lessons_details_calendar_content_gutter{
    width:var(--my-lessons-details-calendar-content-gutter); position:relative; border-right:1px solid var(--my-lessons-details-calendar-content-day-border);
  }
  .my_lessons_details_calendar_content_times{ position:relative; height:100%; padding-top:0; }
  .my_lessons_details_calendar_content_time{
    position:absolute; left:0; right:8px; height:calc(var(--my-lessons-details-calendar-content-slot-h) * 2);
    display:flex; align-items:center; justify-content:flex-end; color:var(--my-lessons-details-calendar-content-muted);
    font-size:12px; padding-right:10px; pointer-events:none;
  }

  .my_lessons_details_calendar_content_columns{
    flex:1 1 auto; display:grid; grid-template-columns: repeat(7, 1fr);
    border-right:1px solid var(--my-lessons-details-calendar-content-day-border);
  }
  .my_lessons_details_calendar_content_col{ position:relative; border-left:1px solid var(--my-lessons-details-calendar-content-day-border); }

  /* Day header */
  .my_lessons_details_calendar_content_dayhead{
    position:sticky; top:0; z-index:2; background:#fff; padding:12px 10px; text-align:center; border-bottom:1px solid var(--my-lessons-details-calendar-content-day-border);
    font-weight:600; color:#6b6e7a;
  }
  .my_lessons_details_calendar_content_dayhead.is-today{ color:var(--my-lessons-details-calendar-content-brand); font-weight:900; }

  /* Grid (two slots per hour) */
  .my_lessons_details_calendar_content_slots{ position:relative; }
  .my_lessons_details_calendar_content_slot{
    height:var(--my-lessons-details-calendar-content-slot-h); border-top:1px solid var(--my-lessons-details-calendar-content-grid-border);
  }
  /* Darker line at the START of each hour (odd slot = first 30 mins). */
  .my_lessons_details_calendar_content_slot:nth-child(2n+1){ border-top-color:#e1e3ec; }

  /* Events layer fills entire column; we compute offsets from the slots container top */
  .my_lessons_details_calendar_content_evwrap{
    position:absolute; left:0; right:0; top:0; bottom:0;
  }
  .my_lessons_details_calendar_content_event{
    position:absolute; left:0; right:0;
    border-radius:6px;
    padding:8px 10px; background:#fff;
    box-shadow:0 2px 6px rgba(20,20,20,.08);
    border:1px solid #e0e0e0;
    display:flex; gap:8px; align-items:center; font-size:13px; font-weight:600;
  }
  .my_lessons_details_calendar_content_event img{ width:24px;height:24px;border-radius:50%; }
  .my_lessons_details_calendar_content_event p{ margin:0; font-weight:700; }
  .my_lessons_details_calendar_content_event .my_lessons_details_calendar_content_small{ font-size:12px; color:#222; font-weight:700; opacity:.75; }
  .my_lessons_details_calendar_content_event.confirmed{ background:#fff; border:2px solid #fe2e0c; }
  .my_lessons_details_calendar_content_event.recurring{ background:#ffe7e6; border:1px solid #f09790; }
  .my_lessons_details_calendar_content_event.single{ background:#e6f2ff; border:1px solid #9bc0ff; }
  .my_lessons_details_calendar_content_event .my_lessons_details_calendar_content_icon{ margin-left:auto; font-size:16px; }

  /* NOW indicator (same origin as events) */
  .my_lessons_details_calendar_content_now{ position:absolute; left:0; right:0; height:0; pointer-events:none; }
  .my_lessons_details_calendar_content_now:before{
    content:""; position:absolute; left:6px; top:-3px; width:8px; height:8px; border-radius:50%;
    background:var(--my-lessons-details-calendar-content-now);
    box-shadow:0 0 0 2px #fff, 0 0 0 4px rgba(255,59,31,.18);
  }
  .my_lessons_details_calendar_content_now:after{
    content:""; position:absolute; left:12px; right:8px; top:0; height:2px; background:var(--my-lessons-details-calendar-content-now);
  }

  @media (max-width: 992px){
    :root{ --my-lessons-details-calendar-content-gutter: 58px; --my-lessons-details-calendar-content-slot-h: 48px; }
    .my_lessons_details_calendar_content_dayhead{ font-size:13px; }
  }
  @media (max-width: 680px){
    .my_lessons_details_calendar_content_legend{ display:none; }
    .my_lessons_details_calendar_content_dayhead span[data-type="dow"]{ display:none; }
  }
</style>
</head>
<body>

<div class="container-fluid">

  <!-- Header -->
  <div class="my_lessons_details_calendar_content_header">
    <div class="my_lessons_details_calendar_content_nav">
      <button id="my_lessons_details_calendar_content_btn_today" class="my_lessons_details_calendar_content_btn_today">Today</button>

      <div class="my_lessons_details_calendar_content_seg" role="group" aria-label="Week navigation">
        <button id="my_lessons_details_calendar_content_btn_prev" aria-label="Previous week">‹</button>
        <button id="my_lessons_details_calendar_content_btn_next" aria-label="Next week">›</button>
      </div>

      <span id="my_lessons_details_calendar_content_range" class="my_lessons_details_calendar_content_range"></span>
    </div>

    <div class="my_lessons_details_calendar_content_legend">
      <span><i>✔️</i>Confirmed by the student</span>
      <span><i>🔄</i>Weekly Class</span>
      <span><i>📅</i>Single class</span>
    </div>
  </div>

  <!-- Week grid -->
  <div class="my_lessons_details_calendar_content_weekwrap">
    <div id="my_lessons_details_calendar_content_week" class="my_lessons_details_calendar_content_week">
      <!-- Left time gutter -->
      <div class="my_lessons_details_calendar_content_gutter">
        <div id="my_lessons_details_calendar_content_times" class="my_lessons_details_calendar_content_times"></div>
      </div>
      <!-- 7 columns -->
      <div id="my_lessons_details_calendar_content_columns" class="my_lessons_details_calendar_content_columns"></div>
    </div>
  </div>

</div>

<script>
(function($){
  /* ===== CONFIG ===== */
  const my_lessons_details_calendar_content_START_H = 6;   // 06:00
  const my_lessons_details_calendar_content_END_H   = 19;  // 19:00
  const my_lessons_details_calendar_content_SLOTS_PER_HOUR = 2; // 30-min
  const my_lessons_details_calendar_content_SLOT_H = () => parseInt(getComputedStyle(document.documentElement).getPropertyValue('--my-lessons-details-calendar-content-slot-h'))||56;
  const my_lessons_details_calendar_content_DOW = ['Mon','Tue','Wed','Thu','Fri','Sat','Sun'];

  /* ===== STATE ===== */
  let my_lessons_details_calendar_content_weekStart = startOfWeek(new Date()); // Monday 00:00

  let my_lessons_details_calendar_content_events = [
    { date:'2025-09-09', start:'07:00', end:'08:00', type:'confirmed', name:'Mary inamJanes', avatar:'https://randomuser.me/api/portraits/women/82.jpg', icon:'✔️' },
    { date:'2025-09-09', start:'07:00', end:'08:00', type:'recurring', name:'Mary Janes', avatar:'https://randomuser.me/api/portraits/women/68.jpg', icon:'🔄' },
    { date:'2025-09-09', start:'10:00', end:'11:00', type:'single',    name:'Mary Janes', avatar:'https://randomuser.me/api/portraits/women/82.jpg', icon:'📅' },
    { date:'2025-09-09', start:'13:00', end:'14:00', type:'single',    name:'Mary Janes', avatar:'https://randomuser.me/api/portraits/women/82.jpg', icon:'📅' },
    { date:'2025-09-12', start:'15:00', end:'16:00', type:'recurring', name:'Mary Janes', avatar:'https://randomuser.me/api/portraits/women/68.jpg', icon:'🔄' },
    { date:'2025-09-11', start:'16:00', end:'17:00', type:'confirmed', name:'Mary Janes', avatar:'https://randomuser.me/api/portraits/women/12.jpg', icon:'✔️' },
    { date:'2025-09-10', start:'09:00', end:'10:00', type:'single', name:'Mary Janes', avatar:'https://randomuser.me/api/portraits/women/1.jpg', icon:'📅' }
  ];

  /* ===== INIT ===== */
  $(function(){
    my_lessons_details_calendar_content_buildStaticGrid();
    my_lessons_details_calendar_content_renderWeek();
    my_lessons_details_calendar_content_bindNav();
    my_lessons_details_calendar_content_tickNow();
    setInterval(my_lessons_details_calendar_content_tickNow, 60*1000);

    $(window).on('resize', function(){
      my_lessons_details_calendar_content_syncGutterToGrid(true); // rebuild labels on resize
      my_lessons_details_calendar_content_renderWeek();
    });
  });

  /* ===== HELPERS ===== */
  function pad(n){ return (n<10?'0':'') + n; }
  function parseHM(hm){ const [h,m]=hm.split(':').map(Number); return h*60+m; }

  function startOfWeek(dt){
    const d = new Date(dt.getFullYear(), dt.getMonth(), dt.getDate());
    const day = (d.getDay()+6)%7; // Mon=0
    d.setDate(d.getDate()-day); d.setHours(0,0,0,0);
    return d;
  }
  function addDays(dt,n){ const d=new Date(dt); d.setDate(d.getDate()+n); return d; }
  function toISODate(dt){ return `${dt.getFullYear()}-${pad(dt.getMonth()+1)}-${pad(dt.getDate())}`; }

  function formatRangeLabel(weekStart){
    const start = addDays(weekStart,0);
    const end   = addDays(weekStart,6);
    const s = start.toLocaleDateString(undefined,{ month:'short', day:'2-digit' });
    const e = end.toLocaleDateString(undefined,{ month:'short', day:'2-digit' });
    return `${s} – ${e}, ${end.getFullYear()}`;
  }

  /* ===== DOM-based positioning helpers ===== */

  // px from the top of the column's event layer to the top of the slots container
  function my_lessons_details_calendar_content_getColumnOrigin(colEl){
    const evwrap = colEl.querySelector('.my_lessons_details_calendar_content_evwrap');
    const slots  = colEl.querySelector('.my_lessons_details_calendar_content_slots');
    if(!evwrap || !slots) return 0;
    const origin = Math.round(slots.getBoundingClientRect().top - evwrap.getBoundingClientRect().top);
    return origin < 0 ? 0 : origin;
  }

  // px from the evwrap to the exact time (uses slot origin + slot index)
  function my_lessons_details_calendar_content_getTopForTime(colEl, minutesFromStart){
    const origin = my_lessons_details_calendar_content_getColumnOrigin(colEl);
    const slotIndex = Math.floor(minutesFromStart / 30);
    const remainder = minutesFromStart % 30;
    const top = origin + slotIndex*my_lessons_details_calendar_content_SLOT_H() + (remainder/30)*my_lessons_details_calendar_content_SLOT_H();
    return top;
  }

  // align the left time gutter to the grid using the first column's origin
  // if rebuild=true we also rebuild the labels using *top-of-hour* positions
  function my_lessons_details_calendar_content_syncGutterToGrid(rebuild=false){
    const colEl = document.querySelector('.my_lessons_details_calendar_content_col');
    if(!colEl) return;

    const colTop   = colEl.getBoundingClientRect().top;
    const slotsTop = colEl.querySelector('.my_lessons_details_calendar_content_slots').getBoundingClientRect().top;
    const padTop = Math.max(0, Math.round(slotsTop - colTop));
    const $times = $('#my_lessons_details_calendar_content_times').css('padding-top', padTop + 'px');

    if(rebuild){
      const slotH = my_lessons_details_calendar_content_SLOT_H();
      const start = my_lessons_details_calendar_content_START_H;
      const end   = my_lessons_details_calendar_content_END_H;
      $times.empty().css('height', ((end-start)*2*slotH) + 'px');

      // ✅ Place labels on the TOP of each hour (not mid-hour)
      for(let h=start; h<end; h++){
        const topPx = ((h - start) * 2) * slotH; // <— changed from "+1" mid-hour to top-of-hour
        const label = (h%12===0?12:(h%12)) + ':00' + (h<12?' AM':' PM');
        $times.append(`<div class="my_lessons_details_calendar_content_time" style="top:${topPx}px">${label}</div>`);
      }
    }
  }

  /* ===== BUILD GRID ===== */
  function my_lessons_details_calendar_content_buildStaticGrid(){
    const $cols = $('#my_lessons_details_calendar_content_columns').empty();

    for(let d=0; d<7; d++){
      const $col = $(`
        <div class="my_lessons_details_calendar_content_col" data-day="${d}">
          <div class="my_lessons_details_calendar_content_dayhead">
            <span data-type="dow"></span> <span data-type="date"></span>
          </div>
          <div class="my_lessons_details_calendar_content_slots"></div>
          <div class="my_lessons_details_calendar_content_evwrap"></div>
        </div>
      `);
      const $slots = $col.find('.my_lessons_details_calendar_content_slots');
      for(let h=my_lessons_details_calendar_content_START_H; h<my_lessons_details_calendar_content_END_H; h++){
        for(let s=0; s<my_lessons_details_calendar_content_SLOTS_PER_HOUR; s++){
          $slots.append(`<div class="my_lessons_details_calendar_content_slot" data-h="${h}" data-s="${s}"></div>`);
        }
      }
      $cols.append($col);
    }

    // hour labels — now placed on the TOP of the hour
    const totalSlots = (my_lessons_details_calendar_content_END_H - my_lessons_details_calendar_content_START_H) * my_lessons_details_calendar_content_SLOTS_PER_HOUR;
    const $times = $('#my_lessons_details_calendar_content_times').css('height', `calc(${totalSlots} * var(--my-lessons-details-calendar-content-slot-h))`).empty();
    for(let h=my_lessons_details_calendar_content_START_H; h<my_lessons_details_calendar_content_END_H; h++){
      const topPx = ((h - my_lessons_details_calendar_content_START_H) * 2) * my_lessons_details_calendar_content_SLOT_H(); // <— changed
      const label = (h%12===0?12:(h%12)) + ':00' + (h<12?' AM':' PM');
      $times.append(`<div class="my_lessons_details_calendar_content_time" style="top:${topPx}px">${label}</div>`);
    }

    my_lessons_details_calendar_content_syncGutterToGrid();
  }

  /* ===== RENDER WEEK ===== */
  function my_lessons_details_calendar_content_renderWeek(){
    $('#my_lessons_details_calendar_content_range').text(formatRangeLabel(my_lessons_details_calendar_content_weekStart));

    const today = new Date(); const todayISO = toISODate(today);
    $('.my_lessons_details_calendar_content_col').each(function(idx){
      const d = addDays(my_lessons_details_calendar_content_weekStart, idx);
      const iso = toISODate(d);
      const $head = $(this).find('.my_lessons_details_calendar_content_dayhead');
      $head.toggleClass('is-today', iso===todayISO);
      $head.find('[data-type="dow"]').text(my_lessons_details_calendar_content_DOW[idx]);
      $head.find('[data-type="date"]').text(d.getDate());
      $(this).find('.my_lessons_details_calendar_content_evwrap').empty();
      $(this).find('.my_lessons_details_calendar_content_now').remove();
    });

    // re-sync gutter (responsive & header changes). Rebuild = false is fine here
    my_lessons_details_calendar_content_syncGutterToGrid(false);

    const weekEnd = addDays(my_lessons_details_calendar_content_weekStart, 6);
    const startISO = toISODate(my_lessons_details_calendar_content_weekStart);
    const endISO   = toISODate(weekEnd);

    const evs = my_lessons_details_calendar_content_events.filter(ev => ev.date >= startISO && ev.date <= endISO);

    // Place events (snap exactly to grid)
    evs.forEach(ev=>{
      const evDate = new Date(ev.date+'T00:00:00');
      const dayIdx = (evDate.getDay()+6)%7; // Mon=0
      const $col = $(`.my_lessons_details_calendar_content_col[data-day="${dayIdx}"]`);
      if(!$col.length) return;

      const colEl = $col.get(0);
      const startM = parseHM(ev.start);
      const endM   = parseHM(ev.end);
      const calStartM = my_lessons_details_calendar_content_START_H * 60;

      const top    = my_lessons_details_calendar_content_getTopForTime(colEl, startM - calStartM);
      const height = ((endM - startM) / 30) * my_lessons_details_calendar_content_SLOT_H();

      const $ev = $(`
        <div class="my_lessons_details_calendar_content_event ${ev.type}" style="top:${Math.max(top,0)}px;height:${Math.max(height,40)}px">
          <img src="${ev.avatar}" alt="">
          <div>
            <div class="my_lessons_details_calendar_content_small">${ev.start}–${ev.end}</div>
            <p>${ev.name}</p>
          </div>
          <div class="my_lessons_details_calendar_content_icon">${ev.icon||''}</div>
        </div>
      `);
      $col.find('.my_lessons_details_calendar_content_evwrap').append($ev);
    });

    // Draw NOW line after render
    my_lessons_details_calendar_content_tickNow();
  }

  /* ===== NOW line — same DOM-based positioning ===== */
  function my_lessons_details_calendar_content_tickNow(){
    $('.my_lessons_details_calendar_content_now').remove();

    const now = new Date();
    const nowISO = toISODate(now);
    const weekStartISO = toISODate(my_lessons_details_calendar_content_weekStart);
    const weekEndISO   = toISODate(addDays(my_lessons_details_calendar_content_weekStart,6));
    if(nowISO < weekStartISO || nowISO > weekEndISO) return;

    const dayIdx = (now.getDay()+6)%7;
    const minutes = now.getHours()*60 + now.getMinutes();
    const calStartM = my_lessons_details_calendar_content_START_H * 60;
    const calEndM   = my_lessons_details_calendar_content_END_H   * 60;
    if(minutes < calStartM || minutes > calEndM) return;

    const $col = $(`.my_lessons_details_calendar_content_col[data-day="${dayIdx}"]`);
    const colEl = $col.get(0);
    const top = my_lessons_details_calendar_content_getTopForTime(colEl, minutes - calStartM);
    $col.find('.my_lessons_details_calendar_content_evwrap').append(`<div class="my_lessons_details_calendar_content_now" style="top:${top}px"></div>`);
  }

  /* ===== NAV ===== */
  function my_lessons_details_calendar_content_bindNav(){
    $('#my_lessons_details_calendar_content_btn_prev').on('click', function(){
      my_lessons_details_calendar_content_weekStart = addDays(my_lessons_details_calendar_content_weekStart, -7);
      my_lessons_details_calendar_content_renderWeek();
    });
    $('#my_lessons_details_calendar_content_btn_next').on('click', function(){
      my_lessons_details_calendar_content_weekStart = addDays(my_lessons_details_calendar_content_weekStart, +7);
      my_lessons_details_calendar_content_renderWeek();
    });
    $('#my_lessons_details_calendar_content_btn_today').on('click', function(){
      my_lessons_details_calendar_content_weekStart = startOfWeek(new Date());
      my_lessons_details_calendar_content_renderWeek();
    });
  }
})(jQuery);
</script>
</body>
</html>
