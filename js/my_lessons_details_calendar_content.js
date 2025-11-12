(function($){
  $.fx.off = true;

  const START_H = 6, END_H = 19, SLOTS_PER_HOUR = 2;
  const SLOT_H = () => parseInt(getComputedStyle(document.documentElement).getPropertyValue('--slot-h'))||36;
  const HEADER_H = () => parseInt(getComputedStyle(document.documentElement).getPropertyValue('--calendar-header-h'))||56;
  const DOW = ['Mon','Tue','Wed','Thu','Fri','Sat','Sun'];

  const ICONS = {
    confirmed: 'img/yellow.svg',
    recurring: 'img/default.svg',
    single:    'img/default.svg',
    default:   'img/default.svg'
  };

  let weekStart = startOfWeek(new Date());

  const events = [
    { date:'2025-09-09', start:'07:00', end:'08:00', type:'confirmed', name:'Mary Janes', avatar:'https://randomuser.me/api/portraits/women/82.jpg' },
    { date:'2025-09-09', start:'10:00', end:'11:00', type:'single',    name:'Mary Janes', avatar:'https://randomuser.me/api/portraits/women/68.jpg' },
    { date:'2025-09-11', start:'16:00', end:'17:00', type:'confirmed', name:'Mary Janes', avatar:'https://randomuser.me/api/portraits/women/12.jpg' },
    { date:'2025-09-12', start:'07:00', end:'08:00', type:'recurring', name:'Mary Janes', avatar:'https://randomuser.me/api/portraits/women/45.jpg' }
  ];

  const my_lessons_details_calendar_content_tutor_tutors = [
    { id: 1, name: "Daniela",       lessons: 11, avatar: "https://i.pravatar.cc/80?img=47" },
    { id: 2, name: "Wade Warren",   lessons:  8, avatar: "https://i.pravatar.cc/80?img=12" },
    { id: 3, name: "Albert Flores", lessons: 15, avatar: "https://i.pravatar.cc/80?img=32" },
    { id: 4, name: "Annette Black", lessons:  0, avatar: "https://i.pravatar.cc/80?img=61" },
    { id: 5, name: "Daniel A.",     lessons:  0, avatar: "https://i.pravatar.cc/80?img=23" },
  ];

  $(function(){
    buildStaticGrid();
    drawTimes();
    renderWeek();
    bindNav();
    tickNow();
    setInterval(tickNow, 60*1000);
    $(window).on('resize', function(){ drawTimes(); renderWeek(); });

    bindInteractions();
    my_lessons_details_calendar_content_tutor_bindEmptySlotClicks();
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
      if(!$(this).find('.tooltip-overlay').length){
        $(this).find('.evwrap').append('<div class="tooltip-overlay"></div>');
      }
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

  function hidePanels(){
    $('.tooltip-overlay').hide();
    $('#eventTooltip').hide();
    $('#eventMenu').hide();
  }

  function bindInteractions(){
    const $tip  = $('#eventTooltip');
    const $menu = $('#eventMenu');

    function anchorAndClamp($panel, $ev, opts){
      const $wrap = $ev.closest('.evwrap');
      const $overlay = $wrap.find('.tooltip-overlay');
      $panel.appendTo($wrap).css({ display:'block', visibility:'hidden' });

      const panelH = $panel.outerHeight();
      const evPos  = $ev.position();
      const evW    = $ev.outerWidth();
      const evH    = $ev.outerHeight();
      const wrapH  = $wrap.innerHeight();

      const gap = opts.gap ?? 14;
      const pad = 8;

      const left = evPos.left + evW + gap; // right side
      let top = evPos.top + (evH - panelH)/2;
      top = Math.max(pad, Math.min(top, wrapH - panelH - pad));

      $panel.removeClass('arrow-right').addClass('arrow-left')
            .css({ left, top, visibility:'visible' });
      $overlay.show();
    }

    $(document).off('click.tooltip').on('click.tooltip', '.event.confirmed', function(e){
      e.stopPropagation();
      hidePanels();
      anchorAndClamp($tip, $(this), { gap: 14 });
    });

    $(document).off('click.menu').on('click.menu', '.event.recurring', function(e){
      e.stopPropagation();
      hidePanels();
      anchorAndClamp($menu, $(this), { gap: 14 });
    });

    $(document).on('click', hidePanels);
    $(window).on('resize scroll', hidePanels);
    $(document).on('click', '.tooltip-overlay', hidePanels);

    $tip.on('click', e => e.stopPropagation());
    $menu.on('click', e => e.stopPropagation());
  }

function my_lessons_details_calendar_content_tutor_buildRow(tutor){
  const lessonsLabel = `${tutor.lessons} lesson${tutor.lessons === 1 ? "" : "s"} to schedule`;
  return `
    <li>
      <a href="my_lessons_details_calendar_content_reschedule.php?id=${tutor.id}"
         class="w-full flex items-center gap-4 px-4 py-4 hover:bg-gray-50 focus:outline-none">
        <img class="w-11 h-11 rounded-md object-cover" src="${tutor.avatar}" alt="${tutor.name}" />
        <div class="flex-1 text-left">
          <div class="font-semibold text-gray-900 leading-tight text-[16px]">${tutor.name}</div>
          <div class="text-[14px] text-black-700">${lessonsLabel}</div>
        </div>
        <svg viewBox="0 0 24 24"
             class="w-5 h-5 text-black-500"
             fill="none"
             stroke="currentColor"
             stroke-width="2"
             stroke-linecap="round"
             stroke-linejoin="round">
          <path d="M9 5l7 7-7 7"/>
        </svg>
      </a>
    </li>`;
}


  function my_lessons_details_calendar_content_tutor_renderList(tutors){
    const $list = $("#my_lessons_details_calendar_content_tutor_list").empty();
    (tutors || []).forEach(t => $list.append(my_lessons_details_calendar_content_tutor_buildRow(t)));
  }

  function my_lessons_details_calendar_content_tutor_openModal(tutors){
    hidePanels();
    my_lessons_details_calendar_content_tutor_renderList(tutors || my_lessons_details_calendar_content_tutor_tutors);
    $("#my_lessons_details_calendar_content_tutor_modal_root").removeClass("hidden");
    $("body").addClass("overflow-hidden");
  }

  function my_lessons_details_calendar_content_tutor_closeModal(){
    $("#my_lessons_details_calendar_content_tutor_modal_root").addClass("hidden");
    $("body").removeClass("overflow-hidden");
  }

  function my_lessons_details_calendar_content_tutor_bindEmptySlotClicks(){
    $(document).on("click", ".evwrap", function(e){
      const $target = $(e.target);
      if ($target.closest(".event, #eventTooltip, #eventMenu").length) return;
      my_lessons_details_calendar_content_tutor_openModal();
    });

    $("#my_lessons_details_calendar_content_tutor_modal_overlay")
      .on("click", my_lessons_details_calendar_content_tutor_closeModal);
    $("#my_lessons_details_calendar_content_tutor_btn_close")
      .on("click", my_lessons_details_calendar_content_tutor_closeModal);
    $(document).on("keydown", function(e){
      if(e.key === "Escape") my_lessons_details_calendar_content_tutor_closeModal();
    });

    $(document).on("click", "#my_lessons_details_calendar_content_tutor_list button", function(){
      const id = $(this).data("id");
      console.log("Tutor selected:", id);
      my_lessons_details_calendar_content_tutor_closeModal();
    });
  }

})(jQuery);
