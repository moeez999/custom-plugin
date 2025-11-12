/* Build hour labels + 30-min boxes; color the middle gray band between START and END hours */
(function(){
  const $timeCol = $('#calendar_admin_details_setup_availablity_timecol');
  for (let h=0; h<24; h++){
    const label = (h<10? '0'+h : h)+':00';
    $timeCol.append('<div class="calendar_admin_details_setup_availablity_hourlabel">'+label+'</div>');
  }

  const css = getComputedStyle(document.documentElement);
  const nightStartHour = parseFloat(css.getPropertyValue('--cal-setup-night-start-hour')) || 1;
  const nightEndHour   = parseFloat(css.getPropertyValue('--cal-setup-night-end-hour'))   || 5;
  const startHalf = Math.round(nightStartHour * 2);
  const endHalf   = Math.round(nightEndHour   * 2); // exclusive

  $('.calendar_admin_details_setup_availablity_day').each(function(){
    const $col = $(this);
    for (let i=0; i<48; i++){
      const $slot = $('<div class="calendar_admin_details_setup_availablity_halfbox"></div>');
      if(i >= startHalf && i < endHalf){ $slot.addClass('calendar_admin_details_setup_availablity_nightbg'); }
      $col.append($slot);
    }
  });
})();

/* Popular slots toggle */
$('#calendar_admin_details_setup_availablity_popular_toggle').on('change', function(){
  $('#calendar_admin_details_setup_availablity_heat').css('display', this.checked ? 'grid' : 'none');
});

/* Drag + resize demo (15 min snap) */
(function(){
  const hourPx = parseFloat(getComputedStyle(document.documentElement).getPropertyValue('--cal-setup-hour')) || 60;
  const snap = hourPx/4, $layer = $('#calendar_admin_details_setup_availablity_blocks');
  let dragging=null, resizing=null;
  const clamp=(v,min,max)=>Math.max(min, Math.min(max, v));

  $layer.on('mousedown touchstart', '.calendar_admin_details_setup_availablity_block', function(e){
    if($(e.target).closest('.calendar_admin_details_setup_availablity_resize').length) return;
    const y = e.pageY || e.originalEvent.touches?.[0].pageY;
    dragging = { $el:$(this), startY:y, startTop:parseFloat($(this).css('top')) };
    $('body').addClass('user-select-none');
  });

  $layer.on('mousedown touchstart', '.calendar_admin_details_setup_availablity_resize', function(e){
    const $el=$(this).closest('.calendar_admin_details_setup_availablity_block');
    const y = e.pageY || e.originalEvent.touches?.[0].pageY;
    resizing = { $el, startY:y, startH:$el.outerHeight() };
    e.stopPropagation(); $('body').addClass('user-select-none');
  });

  $(document).on('mousemove touchmove', function(e){
    const y = e.pageY || e.originalEvent.touches?.[0]?.pageY;
    if(dragging){
      let top = dragging.startTop + (y - dragging.startY);
      const maxTop = $layer.height() - dragging.$el.outerHeight();
      top = clamp(Math.round(top/snap)*snap, 0, maxTop);
      dragging.$el.css('top', top+'px');
    }else if(resizing){
      let h = resizing.startH + (y - resizing.startY);
      const maxH = $layer.height() - parseFloat(resizing.$el.css('top'));
      h = clamp(Math.round(h/snap)*snap, snap*2, maxH);
      resizing.$el.css('height', h+'px');
    }
  });
  $(document).on('mouseup touchend', function(){ dragging=null; resizing=null; $('body').removeClass('user-select-none'); });
  $('<style>.user-select-none{user-select:none;-webkit-user-select:none}</style>').appendTo(document.head);
})();

/* Tutor dropdown */
(function(){
  const people = [
    {name:'Edwards', img:'https://randomuser.me/api/portraits/men/32.jpg'},
    {name:'Daniela', img:'https://randomuser.me/api/portraits/women/65.jpg'},
    {name:'Hawkins', img:'https://randomuser.me/api/portraits/men/15.jpg'},
    {name:'Lane',    img:'https://randomuser.me/api/portraits/men/41.jpg'},
    {name:'Warren',  img:'https://randomuser.me/api/portraits/men/72.jpg'},
    {name:'Fox',     img:'https://randomuser.me/api/portraits/men/11.jpg'}
  ];

  const $btn = $('#calendar_admin_details_setup_availablity_userbtn');
  const $menu = $('<div id="calendar_admin_details_setup_availablity_menu" class="calendar_admin_details_setup_availablity_menu" role="menu" aria-hidden="true"></div>');
  people.forEach(p=>{
    $menu.append(
      `<div class="calendar_admin_details_setup_availablity_menu_item" role="menuitem" tabindex="0" data-name="${p.name}" data-img="${p.img}">
         <img class="calendar_admin_details_setup_availablity_menu_avatar" src="${p.img}" alt="">
         <div class="calendar_admin_details_setup_availablity_menu_name">${p.name}</div>
       </div>`
    );
  });
  $('body').append($menu);

  function pos(){ const r=$btn[0].getBoundingClientRect(), gap=8; let l=r.left, t=r.bottom+gap, w=$menu.outerWidth(), vw=innerWidth; if(l+w>vw-12) l=vw-w-12; $menu.css({left:l+scrollX, top:t+scrollY}); }
  function open(){ pos(); $menu.show(); $btn.addClass('open').attr('aria-expanded','true'); $(document).on('click._m',dcl); $(document).on('keydown._m',k); }
  function close(){ $menu.hide(); $btn.removeClass('open').attr('aria-expanded','false'); $(document).off('click._m keydown._m'); }
  function dcl(e){ if(!$(e.target).closest('#calendar_admin_details_setup_availablity_menu,#calendar_admin_details_setup_availablity_userbtn').length) close(); }
  function k(e){ if(e.key==='Escape') close(); }
  $btn.on('click',()=> $menu.is(':visible')?close():open());
  $(window).on('resize scroll',()=>{ if($menu.is(':visible')) pos(); });
  $menu.on('click keydown', '.calendar_admin_details_setup_availablity_menu_item', function(e){
    if(e.type==='keydown'&&e.key!=='Enter') return;
    $('#calendar_admin_details_setup_availablity_username').text($(this).data('name'));
    $('#calendar_admin_details_setup_availablity_avatar').attr('src', $(this).data('img'));
    close();
  });
})();
