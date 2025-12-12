/* ====== CONFIG ====== */
const START_H = 7, END_H = 24, SLOT_MIN = 30;
const SLOT_H = parseInt(getComputedStyle(document.documentElement).getPropertyValue('--slot-h'))||36;
const PX_PER_MIN = SLOT_H / SLOT_MIN;
const STACK_OFFSET = 18, STACK_CAP = 3;
const REVEAL_FRONT = parseInt(getComputedStyle(document.documentElement).getPropertyValue('--reveal-front'))||12;
const REVEAL_MID   = parseInt(getComputedStyle(document.documentElement).getPropertyValue('--reveal-mid'))||8;

const DOW = ['Mon','Tue','Wed','Thu','Fri','Sat','Sun'];

/* ====== WHITE SLOT WINDOWS ======
   days: 'all' | [0..6]  (Mon=0 ... Sun=6)
   Or target a specific ISO date with { date:'YYYY-MM-DD', ... }
*/

const WHITE_SLOTS = [
  // Example per your ask: 10:00–11:00 PM and 11:00 PM–12:00 AM every day
  { days: 'all', start: '22:00', end: '23:00' },
  { days: 'all', start: '23:00', end: '24:00' },
  // More examples you can add later:
  // { days:[5,6], start:'18:00', end:'20:00' },
  // { date:'2025-08-31', start:'10:00', end:'12:00' },
];

/* ====== DATA ====== */
const events = [
  { day:2, title:"Conversation 1", start:"07:00", end:"08:00", color:"e-blue", repeat:true },
  { day:2, title:"Conversation 2", start:"07:00", end:"08:00", color:"e-blue", repeat:true },
  { day:2, title:"Conversation 3", start:"07:00", end:"08:00", color:"e-blue", repeat:true },
  { day:2, title:"Team Meeting",   start:"09:00", end:"10:00", color:"e-gray" },
  { day:4, title:"Mary Janes",     start:"09:00", end:"12:00", color:"e-blue", avatar:"https://randomuser.me/api/portraits/women/44.jpg", repeat:true },
  { day:2, title:"Mary Janes",     start:"11:00", end:"12:00", color:"e-blue", avatar:"https://randomuser.me/api/portraits/women/68.jpg" },
  { day:2, title:"Conversation",   start:"12:00", end:"13:00", color:"e-blue", repeat:true },
  { day:3, title:"Peer Talk",      start:"12:00", end:"13:00", color:"e-purple", repeat:true },
  { date:"2025-09-07", title:"Busy", start:"10:00", end:"11:15", color:"e-gold" },
  { date:"2025-09-07", title:"Demo Lesson", start:"07:00", end:"08:30", color:"e-green" }
];

/* ====== HELPERS ====== */
function pad2(n){return String(n).padStart(2,'0');}
function fmt12(min){let h=Math.floor(min/60),m=min%60,ap=h>=12?'PM':'AM';h=(h%12)||12;return `${h}:${pad2(m)} ${ap}`;}
function minutes(hhmm){const [h,m]=hhmm.split(':').map(Number);return h*60+m;}
function ymd(d){return `${d.getFullYear()}-${pad2(d.getMonth()+1)}-${pad2(d.getDate())}`;}
function mondayOf(date){
  const d=new Date(date.getFullYear(),date.getMonth(),date.getDate());
  const dow=(d.getDay()+6)%7; d.setDate(d.getDate()-dow); d.setHours(0,0,0,0); return d;
}
function rangeText(startDate){
  const endDate=new Date(startDate); endDate.setDate(endDate.getDate()+6);
  const opts={month:'long'}; const m1=startDate.toLocaleString('default',opts);
  const m2=endDate.toLocaleString('default',opts); const d1=startDate.getDate();
  const d2=endDate.getDate(); const y=startDate.getFullYear();
  return (m1!==m2)?`${m1} ${d1} - ${m2} ${d2}, ${y}`:`${m1} ${d1} - ${d2}, ${y}`;
}

/* NEW: check if a slot minute falls in any WHITE_SLOTS rule */
function isWhiteSlotFor(dayIndex, isoDate, minuteOfDay){
  const toMin = (hhmm) => {
    if (typeof hhmm === 'number') return hhmm;
    const [h,m] = String(hhmm).split(':').map(Number);
    return h*60 + (m||0);
  };
  for (const rule of WHITE_SLOTS){
    // date-specific rule
    if (rule.date){
      if (rule.date !== isoDate) continue;
    } else {
      // day-of-week rules
      if (rule.days === 'all'){
        // ok
      } else if (Array.isArray(rule.days)){
        if (!rule.days.includes(dayIndex)) continue;
      } else {
        continue;
      }
    }
    const s = toMin(rule.start), e = toMin(rule.end);
    if (minuteOfDay >= s && minuteOfDay < e) return true;
  }
  return false;
}

/* ====== STATE ====== */
let currentWeekStart = mondayOf(new Date());

$(function(){
  const rows=(END_H-START_H)*(60/SLOT_MIN);
  document.documentElement.style.setProperty('--rows',rows);

  /* ========= Create Cohort modal (uses your exact code) ========= */
  function openCreateCohortModal(){
    $('#calendar_admin_details_create_cohort_modal_backdrop').fadeIn();

    const $bd = $('#calendar_admin_details_create_cohort_modal_backdrop');
    $bd.find('.calendar_admin_details_create_cohort_tab').removeClass('active');
    $bd.find('.calendar_admin_details_create_cohort_tab[data-tab="cohort"]').addClass('active');

    $('#calendar_admin_details_create_cohort_content').html('');
    $('#mergeTabContent').css('display', 'none');
    $('#conferenceTabContent').css('display', 'none');
    $('#peerTalkTabContent').css('display', 'none');
    $('#addTimeTabContent').css('display', 'none');
    $('#addExtraSlotsTabContent').css('display', 'none');
    $('#mainModalContent').css('display', 'block');
    $('#classTabContent').css('display', 'none');
  }

  // Button → open same modal (kept your trigger class)
  $('.calendar_admin_details_create_cohort_open')
    .off('click.openCohort')
    .on('click.openCohort', function(e){ e.preventDefault(); openCreateCohortModal(); });

  /* ====== CLICK: event -> bring to front only ====== */
  let zSeed = 5000;
  $('#grid').off('mousedown', '.event').on('mousedown', '.event', function () {
    const $clicked = $(this);
    const $day = $clicked.closest('.day-inner');
    const cs = +$clicked.data('start'), ce = +$clicked.data('end');

    const $group = $day.find('.event').filter(function () {
      const s=+$(this).data('start'), e=+$(this).data('end');
      return !(e<=cs || s>=ce);
    });

    $group.each(function(){ this.style.zIndex=''; });
    this.style.zIndex = (++zSeed).toString();
  });

  /* ====== CLICK: empty slot -> open cohort modal ====== */
  $('#grid')
    .off('mousedown.emptySlot', '.day-inner')
    .on('mousedown.emptySlot', '.day-inner', function(e){
      if ($(e.target).closest('.event').length) return;
      openCreateCohortModal();
    });

  // First render
  renderWeek(true);

  // Navigation
  $('#prev-week').on('click',()=>{ currentWeekStart.setDate(currentWeekStart.getDate()-7); renderWeek(true); });
  $('#next-week').on('click',()=>{ currentWeekStart.setDate(currentWeekStart.getDate()+7); renderWeek(true); });

  // Now line heartbeat
  setInterval(drawNow,60*1000);

  /* ====== RENDER ====== */
  function renderWeek(resetScroll=false){
    // Header
    const $head=$('#head'); $head.find('.day-h').remove();
    for(let i=0;i<7;i++){
      const d=new Date(currentWeekStart); d.setDate(d.getDate()+i);
      $('<div class="day-h">')
        .append(`<span class="dow">${DOW[i]}</span>`)
        .append(`<span class="dt">${d.getDate()}</span>`)
        .appendTo($head);
    }
    $('#calendar-range').text(rangeText(currentWeekStart));

    // FULL GRID rebuild
    const $grid=$('#grid'); $grid.empty().append('<div id="gutter" class="gutter"></div>');
    const $gut=$('#gutter');
    for(let m=START_H*60; m<=END_H*60; m+=SLOT_MIN){
      const $row=$('<div class="time-row">');
      if(m%60===0) $row.append(`<div class="time-label">${fmt12(m)}</div>`);
      $gut.append($row);
    }

    const dayEls=[], weekDates=[];
    for(let i=0;i<7;i++){
      const d=new Date(currentWeekStart); d.setDate(d.getDate()+i);
      weekDates.push(ymd(d));

      const $col=$('<div class="day" style="z-index:0 !important">');
      const $inner=$('<div class="day-inner">').appendTo($col);
      $inner.attr('data-date', ymd(d));

      // CREATE SLOTS with white background when matched
      const $slots=$('<div class="slots">').appendTo($inner);
      for (let r = 0; r < rows; r++) {
        const minuteOfDay = START_H * 60 + r * SLOT_MIN;
        const makeWhite = isWhiteSlotFor(i, ymd(d), minuteOfDay);
        $('<div>').toggleClass('slot-white', makeWhite).appendTo($slots);
      }

      $grid.append($col); dayEls.push($inner);
    }

    // Prepare per-day buckets
    const perDay=Array.from({length:7},()=>[]);
    events.forEach(raw=>{
      let di=null;
      if(raw.date){ const idx=weekDates.indexOf(raw.date); if(idx===-1) return; di=idx; }
      else if(typeof raw.day==='number'){ di=raw.day; } else { return; }
      const e={...raw};
      e.start=(typeof e.start==='string')?minutes(e.start):e.start;
      e.end  =(typeof e.end  ==='string')?minutes(e.end)  :e.end;
      perDay[di].push(e);
    });

    // Overlap logic (unchanged)
    const MAX_LEFT = 4 + (STACK_CAP - 1) * STACK_OFFSET;

    perDay.forEach((list, di) => {
      list.sort((a, b) => a.start - b.start || a.end - b.end);

      const active = [];
      list.forEach(ev => {
        for (let i = active.length - 1; i >= 0; i--) {
          if (active[i].end <= ev.start) active.splice(i, 1);
        }
        active.push(ev);

        const conc = active.length;
        active.forEach(a => { a._max = Math.max(a._max || 0, conc); });

        ev.stackIndex = Math.min(conc - 1, STACK_CAP - 1);
      });

      list.forEach(ev => {
        const top = (ev.start - START_H * 60) * PX_PER_MIN;
        const h   = (ev.end - ev.start) * PX_PER_MIN - 4;

        const isSingleton = (ev._max || 1) === 1;
        const cssPos = isSingleton
          ? { left: '4px', width: 'calc(100% - 8px)' }
          : {
              left: (MAX_LEFT - ev.stackIndex * STACK_OFFSET) + 'px',
              width: `calc(100% - ${MAX_LEFT + 8}px)`
            };
        const $ev = $(`
          <div class="event ${ev.color || 'e-blue'}" data-start="${ev.start}" data-end="${ev.end}">
            <div class="ev-top">
              <div class="ev-left">${ev.avatar ? `<img class="ev-avatar" src="${ev.avatar}" alt="">` : ''}</div>
              ${ev.repeat ? `<span class="ev-repeat" title="Repeats">&#8635;</span>` : ''}
            </div>
            <div class="ev-when">${fmt12(ev.start)} – ${fmt12(ev.end)}</div>
            <div class="ev-title">${ev.title || ''}</div>
          </div>
        `).css({ top: top + 'px', height: h + 'px', ...cssPos });

        dayEls[di].append($ev);
      });
    });

    if(resetScroll) $grid.scrollTop(0);
    drawNow();
  }

  function drawNow(){
    $('.now').remove();
    const now=new Date();
    const ws=new Date(currentWeekStart), we=new Date(ws); we.setDate(we.getDate()+7);
    if(now<ws || now>=we) return;
    const di=(now.getDay()+6)%7;
    const mins=now.getHours()*60+now.getMinutes();
    if(mins<START_H*60 || mins>END_H*60) return;
    const y=(mins-START_H*60)*PX_PER_MIN;
    const dayInner = $('#grid .day .day-inner').eq(di);
    $('<div class="now">').css({top:y}).appendTo(dayInner);
  }
});
