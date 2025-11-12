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
    --slot-h: 36px;
    --calendar-header-h: 56px;
    --gutter-w: 78px;
    --day-border:#ececf2;
    --grid-border:#f1f1f6;
    --hour-line:#e1e3ec;
    --muted:#8b8e98;
    --text:#121117;
    --brand:#2764ff;
    --now:#ff3b1f;
    --btn-border:#d1d5db;
    --btn-bg:#f3f4f6;
    --icon:#60646c;
    --font: Inter, system-ui, -apple-system, "Segoe UI", Roboto, "Helvetica Neue", Arial, "Noto Sans";
    --event-x-gap: 0px;
  }
  html,body{ height:100%; }
  body{ font-family:var(--font); background:#fff; color:var(--text); }

  .cal_header{ display:flex; align-items:center; justify-content:space-between; padding:16px 12px 10px; background:#fff; }
  .cal_header_left{ display:flex; align-items:center; gap:14px; }
  .btn_today{ height:40px; padding:0 16px; border-radius:5px; border:2px solid var(--btn-border); background:#fff; color:#374151; font-weight:600; font-size:14px; }
  .btn_today.is-current{ background:var(--btn-bg); }
  .seg{ display:inline-flex; height:40px; border:2px solid var(--btn-border); border-radius:5px; overflow:hidden; background:#fff; }
  .seg button{ width:52px; height:100%; border:0; background:transparent; display:flex; align-items:center; justify-content:center; cursor:pointer; }
  .seg button + button{ border-left:2px solid var(--btn-border); }
  .seg button:hover{ background:#f7f7fb; }
  .seg svg{ width:18px; height:18px; fill:var(--icon); }
  .range{ margin-left:8px; font-weight:700; font-size:18px; letter-spacing:.1px; }
  .legend{ display:flex; gap:26px; align-items:center; }
  .legend_item{ display:flex; align-items:center; gap:8px; color:#4b4f56; font-weight:500; font-size:14px; }
  .legend img{ width:18px; height:18px; display:block; }

  .cal_wrap{ padding:12px; }
  .week{ position:relative; display:flex; width:100%; border:1px solid var(--day-border); border-radius:12px; overflow:hidden; background:#fff; }
  .gridlines{
    position:absolute; left:var(--gutter-w); right:0; top:var(--calendar-header-h); bottom:0; z-index:0; pointer-events:none;
    background:
      repeating-linear-gradient(to bottom, var(--grid-border), var(--grid-border) 1px, transparent 1px, transparent var(--slot-h)),
      repeating-linear-gradient(to bottom, var(--hour-line), var(--hour-line) 1px, transparent 1px, transparent calc(var(--slot-h) * 2));
  }
  .gutter{ width:var(--gutter-w); position:relative; border-right:1px solid var(--day-border); background:#fff; z-index:1; }
  .gutter_head{ height:var(--calendar-header-h); border-bottom:1px solid var(--day-border); background:#fff; position:sticky; top:0; z-index:2; }
  .times{ position:relative; height:100%; padding-top:var(--calendar-header-h); }
  .time{ position:absolute; left:0; right:8px; height:calc(var(--slot-h) * 2); display:flex; align-items:center; justify-content:flex-end; color:var(--muted); font-size:13px; font-weight:600; padding-right:10px; pointer-events:none; }

  .cols{ flex:1 1 auto; display:grid; grid-template-columns: repeat(7, 1fr); background:transparent; z-index:1; }
  .col{ position:relative; border-left:1px solid var(--day-border); border-bottom:1px solid var(--day-border); }
  .dayhead{ position:sticky; top:0; z-index:2; background:#fff; height:var(--calendar-header-h); display:flex; align-items:center; justify-content:center; border-bottom:1px solid var(--day-border); font-weight:600; color:#6b6e7a; }
  .dayhead.is-today{ color:var(--brand); font-weight:700; }
  .slots{ position:relative; }
  .slot{ height:var(--slot-h); border:0; }
  .evwrap{ position:absolute; left:0; right:0; top:0; bottom:0; }

  /* Event card */
  .event{
    position:absolute; left:var(--event-x-gap); right:var(--event-x-gap);
    border-radius:10px; padding:8px 10px; background:#fff; border:1px solid #e5e6eb; box-shadow:0 4px 10px rgba(20,20,20,.08);
    display:block; overflow:hidden;
  }
  .event .avatar{ position:absolute; top:8px; left:10px; width:24px; height:24px; border-radius:50%; }
  .event .badge-icon{
    position:absolute; top:8px; right:10px; width:24px; height:24px; border-radius:50%;
    background:#fff; border:1px solid #e1e3ec; display:flex; align-items:center; justify-content:center;
    box-shadow:0 2px 4px rgba(0,0,0,.05);
  }
  .event .badge-icon img{ width:14px; height:14px; display:block; }
  .event-body{ margin-top:26px; text-align:left; }
  .event-body .small{ font-size:10px; color:#222; opacity:.75; margin:0 0 2px 0; line-height:1.2; }
  .event-body p{ margin:0; font-weight:700; line-height:1.2; font-size:12px; }

  .event.confirmed{ background:#fff; border:2px solid #fe2e0c; }
  .event.recurring{ background:#ffe7e6; border:1px solid #f09790; }
  .event.single{ background:#e6f2ff; border:1px solid #9bc0ff; }

  .now{ position:absolute; left:0; right:0; height:0; pointer-events:none; }
  .now:before{ content:""; position:absolute; left:8px; top:-3px; width:8px; height:8px; border-radius:50%; background:var(--now); box-shadow:0 0 0 2px #fff, 0 0 0 4px rgba(255,59,31,.18); }
  .now:after{ content:""; position:absolute; left:14px; right:8px; top:0; height:2px; background:var(--now); }

  @media (max-width: 992px){
    :root{ --gutter-w: 58px; --slot-h: 34px; --calendar-header-h: 52px; }
    .dayhead{ font-size:13px; }
    .legend{ display:none; }
  }
  @media (max-width: 680px){ .legend{ display:none; } }
</style>
</head>
<body>
<div class="container-fluid">
  <div class="cal_header">
    <div class="cal_header_left">
      <button id="btn_today" class="btn_today">Today</button>
      <div class="seg" role="group" aria-label="Week navigation">
        <button id="btn_prev" aria-label="Previous week">
          <svg viewBox="0 0 24 24" aria-hidden="true"><path d="M14.71 6.7L13.29 5.3 6.59 12l6.7 6.7 1.42-1.41L9.41 12l5.3-5.3Z"/></svg>
        </button>
        <button id="btn_next" aria-label="Next week">
          <svg viewBox="0 0 24 24" aria-hidden="true"><path d="M9.29 17.3 10.71 18.7 17.41 12 10.71 5.3 9.29 6.71 14.59 12 9.29 17.3Z"/></svg>
        </button>
      </div>
      <span id="range" class="range"></span>
    </div>

    <div class="legend">
      <span class="legend_item">
        <img src="img/confirm_by_std.svg" alt="Confirmed icon" />
        Confirmed by the student
      </span>
      <span class="legend_item">
        <img src="img/weekly_class.svg" alt="Weekly class icon" />
        Weekly Class
      </span>
      <span class="legend_item">
        <img src="img/single_class.svg" alt="Single class icon" />
        Single class
      </span>
    </div>
  </div>

  <div class="cal_wrap">
    <div class="week">
      <div class="gridlines"></div>
      <div class="gutter">
        <div class="gutter_head"></div>
        <div id="times" class="times"></div>
      </div>
      <div id="cols" class="cols"></div>
    </div>
  </div>
</div>

<script>
(function($){
  const START_H = 6, END_H = 19, SLOTS_PER_HOUR = 2;
  const SLOT_H = () => parseInt(getComputedStyle(document.documentElement).getPropertyValue('--slot-h'))||36;
  const HEADER_H = () => parseInt(getComputedStyle(document.documentElement).getPropertyValue('--calendar-header-h'))||56;
  const DOW = ['Mon','Tue','Wed','Thu','Fri','Sat','Sun'];

  // Map event types to your SVGs (adjust paths as you like)
  const ICONS = {
    confirmed: 'img/yellow.svg', // e.g., check
    recurring: 'img/default.svg', // e.g., calendar/loop
    single:    'img/default.svg', // set to another svg if you have it
    default:   'img/default.svg'
  };

  let weekStart = startOfWeek(new Date());

  const events = [
    { date:'2025-09-09', start:'07:00', end:'08:00', type:'confirmed', name:'Mary Janes', avatar:'https://randomuser.me/api/portraits/women/82.jpg' },
    { date:'2025-09-09', start:'07:00', end:'08:00', type:'recurring', name:'Mary Janes', avatar:'https://randomuser.me/api/portraits/women/68.jpg' },
    { date:'2025-09-09', start:'10:00', end:'11:00', type:'single',    name:'Mary Janes', avatar:'https://randomuser.me/api/portraits/women/82.jpg' },
    { date:'2025-09-12', start:'15:00', end:'16:00', type:'recurring', name:'Mary Janes', avatar:'https://randomuser.me/api/portraits/women/68.jpg' },
    { date:'2025-09-11', start:'16:00', end:'17:00', type:'confirmed', name:'Mary Janes', avatar:'https://randomuser.me/api/portraits/women/12.jpg' },
    { date:'2025-09-10', start:'09:00', end:'10:00', type:'single',    name:'Mary Janes', avatar:'https://randomuser.me/api/portraits/women/1.jpg' }
  ];

  $(function(){
    buildStaticGrid();
    drawTimes();
    renderWeek();
    bindNav();
    tickNow();
    setInterval(tickNow, 60*1000);
    $(window).on('resize', function(){ drawTimes(); renderWeek(); });
  });

  function pad(n){ return (n<10?'0':'') + n; }
  function parseHM(hm){ const [h,m]=hm.split(':').map(Number); return h*60+m; }
  function startOfWeek(dt){ const d=new Date(dt.getFullYear(),dt.getMonth(),dt.getDate()); const day=(d.getDay()+6)%7; d.setDate(d.getDate()-day); d.setHours(0,0,0,0); return d; }
  function addDays(dt,n){ const d=new Date(dt); d.setDate(d.getDate()+n); return d; }
  function toISODate(dt){ return `${dt.getFullYear()}-${pad(dt.getMonth()+1)}-${pad(dt.getDate())}`; }
  function formatRangeLabel(){
    const s = addDays(weekStart,0);
    const e = addDays(weekStart,6);
    const sTxt = s.toLocaleDateString(undefined,{ month:'short', day:'2-digit' });
    const eTxt = e.toLocaleDateString(undefined,{ day:'2-digit' });
    return `${sTxt}–${eTxt} , ${e.getFullYear()}`;
  }
  function updateTodayPill(){
    const todayStart = startOfWeek(new Date()).getTime();
    const showingStart = startOfWeek(weekStart).getTime();
    $('#btn_today').toggleClass('is-current', todayStart === showingStart);
  }
  function drawTimes(){
    const $times = $('#times').empty();
    const totalSlots = (END_H - START_H) * SLOTS_PER_HOUR;
    $times.css('height', (totalSlots * SLOT_H()) + 'px');
    for(let h=START_H; h<END_H; h++){
      const topPx = ((h - START_H) * 2) * SLOT_H();
      const label = (h%12===0?12:(h%12)) + ':00';
      $times.append(`<div class="time" style="top:${topPx}px">${label}</div>`);
    }
  }
  function buildStaticGrid(){
    const $cols = $('#cols').empty();
    for(let d=0; d<7; d++){
      const $col = $(`
        <div class="col" data-day="${d}">
          <div class="dayhead"><span data-type="dow"></span>&nbsp;<span data-type="date"></span></div>
          <div class="slots"></div>
          <div class="evwrap"></div>
        </div>
      `);
      const $slots = $col.find('.slots');
      for(let h=START_H; h<END_H; h++){
        for(let s=0; s<SLOTS_PER_HOUR; s++){
          $slots.append(`<div class="slot" data-h="${h}" data-s="${s}"></div>`);
        }
      }
      $cols.append($col);
    }
  }

  function renderWeek(){
    $('#range').text(formatRangeLabel());
    updateTodayPill();

    const todayISO = toISODate(new Date());
    $('.col').each(function(idx){
      const d = addDays(weekStart, idx);
      const iso = toISODate(d);
      const $head = $(this).find('.dayhead');
      $head.toggleClass('is-today', iso===todayISO);
      $head.find('[data-type="dow"]').text(DOW[idx]);
      $head.find('[data-type="date"]').text(d.getDate());
      $(this).find('.evwrap').empty();
      $(this).find('.now').remove();
    });

    const startISO = toISODate(weekStart);
    const endISO   = toISODate(addDays(weekStart, 6));
    const evs = events.filter(ev => ev.date >= startISO && ev.date <= endISO);

    evs.forEach(ev=>{
      const dayIdx = (new Date(ev.date+'T00:00:00').getDay()+6)%7;
      const $col = $(`.col[data-day="${dayIdx}"]`);
      if(!$col.length) return;

      const startM = parseHM(ev.start), endM = parseHM(ev.end), calStartM = START_H*60;
      const top = ((startM - calStartM)/30)*SLOT_H() + HEADER_H();
      const height = ((endM - startM)/30)*SLOT_H();

      const iconSrc = ICONS[ev.type] || ICONS.default;

      $col.find('.evwrap').append(
        `<div class="event ${ev.type}" style="top:${Math.max(top,0)}px;height:${Math.max(height,40)}px">
          <img class="avatar" src="${ev.avatar}" alt="">
          <span class="badge-icon"><img src="${iconSrc}" alt=""></span>
          <div class="event-body">
            <div class="small">${ev.start}–${ev.end}</div>
            <p>${ev.name}</p>
          </div>
        </div>`
      );
    });

    tickNow();
  }

  function tickNow(){
    $('.now').remove();
    const now = new Date(), nowISO = toISODate(now);
    const wkStart = toISODate(weekStart), wkEnd = toISODate(addDays(weekStart,6));
    if(nowISO < wkStart || nowISO > wkEnd) return;

    const minutes = now.getHours()*60 + now.getMinutes();
    if(minutes < START_H*60 || minutes > END_H*60) return;

    const dayIdx = (now.getDay()+6)%7;
    const top = ((minutes - START_H*60)/30)*SLOT_H() + HEADER_H();
    $(`.col[data-day="${dayIdx}"] .evwrap`).append(`<div class="now" style="top:${top}px"></div>`);
  }

  function bindNav(){
    $('#btn_prev').on('click', ()=>{ weekStart = new Date(weekStart.getFullYear(), weekStart.getMonth(), weekStart.getDate()-7); renderWeek(); });
    $('#btn_next').on('click', ()=>{ weekStart = new Date(weekStart.getFullYear(), weekStart.getMonth(), weekStart.getDate()+7); renderWeek(); });
    $('#btn_today').on('click', ()=>{ weekStart = startOfWeek(new Date()); renderWeek(); });
  }
})(jQuery);
</script>
</body>
</html>
