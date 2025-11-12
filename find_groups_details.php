<!-- Tailwind -->
<script src="https://cdn.tailwindcss.com"></script>
<!-- jQuery -->
<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>

<style>
  :root{
    --find_groups_details-border:#e7e7ee;
    --find_groups_details-muted:#747684;
    --find_groups_details-text:#121117;
    --find_groups_details-active:#2764ff;
    --find_groups_details-active-soft:#e8efff;
    --find_groups_details-gray:#e5e7eb;
    --find_groups_details-black:#111827;
  }

  /* ===== Field cards ===== */
  .find_groups_details_card{
    border:1px solid var(--find_groups_details-border);
    border-radius:5px;background:#fff;height:68px;
    box-shadow:0 1px 0 rgba(18,17,23,.02);
    transition:border-color .15s, box-shadow .15s;
  }
  .find_groups_details_card--active{
    border-color:var(--find_groups_details-active)!important;
    box-shadow:0 1px 0 rgba(18,17,23,.02),0 0 0 3px rgba(39,100,255,.15);
  }
  .find_groups_details_label{
    font-size:11px;line-height:18px;color:var(--find_groups_details-muted);font-weight:500;
  }
  .find_groups_details_value{
    font-size:16px;line-height:22px;font-weight:600;color:var(--find_groups_details-text);
  }
  .find_groups_details_iconbtn{
    width:28px;height:28px;display:flex;align-items:center;justify-content:center;
    border-radius:9999px;color:#6b7280;
  }
  .find_groups_details_iconbtn:hover{background:#f3f4f6;color:#111827;}

  /* ===== Menus ===== */
  .find_groups_details_menu{
    border:1px solid var(--find_groups_details-border);
    border-radius:12px;background:#fff;
    box-shadow:0 8px 32px rgba(18,17,23,.15),0 16px 48px rgba(18,17,23,.12);
    min-width:280px;
  }
  .find_groups_details_menu_inner{padding:12px 16px;}
  .find_groups_details_menu_btn{
    width:100%;text-align:left;padding:10px 16px;border-radius:8px;
    font-size:15px;line-height:22px;color:#1c1b20;
  }
  .find_groups_details_menu_btn:hover{background:#f6f7fb;}

  /* search bar in “Class taught in” menu */
  .find_groups_details_search{
    display:flex;align-items:center;gap:8px;
    border:1px solid var(--find_groups_details-border);
    border-radius:10px;padding:8px 12px;margin-bottom:12px;
  }
  .find_groups_details_search input{
    flex:1;border:none;outline:none;font-size:15px;color:#1c1b20;background:transparent;
  }

  .find_groups_details_sectiontitle{font-size:14px;color:#6b7280;font-weight:600;margin:18px 0 10px;}
  .find_groups_details_titlelg{font-size:16px;color:#121117;font-weight:700;margin-bottom:8px;}

  /* ===== Chips for “I'm available” ===== */
  .find_groups_details_chip{
    border:1px solid var(--find_groups_details-border);
    background:#fff;border-radius:5px;
    padding:8px 18px;min-height:64px;
    display:flex;flex-direction:column;align-items:center;justify-content:center;gap:8px;
    transition:background .15s,border-color .15s, box-shadow .15s;
  }
  .find_groups_details_chip:hover{background:#f8f9fc;}
  .find_groups_details_chip--active{
    background:var(--find_groups_details-active-soft);
    border-color:#c9d6ff;box-shadow:inset 0 0 0 1px #c9d6ff;
  }
  .find_groups_details_chip_label{font-size:16px;font-weight:600;color:#1c1b20;}

  /* ===== Checkbox style (used by “Class taught in” & “Class Type”) ===== */
  .find_groups_details_checkoption{
    display:flex;align-items:center;justify-content:space-between;
    padding:10px 12px;border-radius:8px;cursor:pointer;
    font-size:15px;font-weight:500;color:#1c1b20;
  }
  .find_groups_details_checkoption:hover{background:#f6f7fb;}
  .find_groups_details_checkbox{
    width:18px;height:18px;border:1.5px solid #cbd5e1;border-radius:4px;
    display:flex;align-items:center;justify-content:center;
  }
  .find_groups_details_checkbox--checked{background:#ff3b30;border-color:#ff3b30;}
  .find_groups_details_checkbox--checked svg{color:#fff;}
  .find_groups_details_divider{height:1px;background:var(--find_groups_details-border);margin:8px 0;}

  /* ===== Price Range (custom slider) ===== */
  .find_groups_details_price_readout{
    font-weight:800;font-size:20px;letter-spacing:.2px;
    text-align:center;color:#111827;margin:6px 0 10px;
  }
  .find_groups_details_range_wrap{padding:6px 6px 14px 6px;}
  .find_groups_details_range_track{
    position:relative;height:8px;border-radius:9999px;background:var(--find_groups_details-gray);
  }
  .find_groups_details_range_fill{
    position:absolute;height:4px;border-radius:9999px;background:var(--find_groups_details-black);
    left:0;right:0;transform:translateZ(0);
  }
  .find_groups_details_range_thumb{
    position:absolute;top:50%;width:28px;height:28px;border-radius:8px;background:#fff;
    border:2px solid var(--find_groups_details-black);
    transform:translate(-50%,-50%);
    box-shadow:0 1px 2px rgba(0,0,0,.1);
    cursor:grab; touch-action:none;
  }
  .find_groups_details_range_thumb:active{cursor:grabbing;}
  .find_groups_details_price_hint{font-size:12px;color:#9ca3af;text-align:center;margin-top:6px;}
  
  /* hide scrollbars but allow scroll */
  .find_groups_details_noscroll::-webkit-scrollbar{width:0;height:0}
  .find_groups_details_noscroll{scrollbar-width:none;-ms-overflow-style:none}
</style>
<div class="max-w-[1600px] mx-auto px-4 md:px-6 py-4">
  <div id="find_groups_details_filters_row"
       class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-5 gap-3">

<!-- 1) English Level -->
<div class="relative" id="find_groups_details_level_wrap">
  <button type="button" 
          id="find_groups_details_btn_level" 
          class="find_groups_details_card w-full px-4 text-left flex items-center justify-between"
          aria-haspopup="listbox"            
          aria-expanded="false"              
          aria-controls="find_groups_details_menu_level">
    <span class="block">
      <span class="find_groups_details_label block">English Level</span>
      <span id="find_groups_details_value_level" class="find_groups_details_value">Begginer</span>
    </span>
  
    <span class="find_groups_details_iconbtn" aria-hidden="true">
      <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
           stroke-linecap="round" stroke-linejoin="round"><polyline points="6 9 12 15 18 9"/></svg>
    </span>
  </button>

  <!-- Menu -->
  <div id="find_groups_details_menu_level" 
       class="find_groups_details_menu absolute z-50 mt-2 hidden w-[240px] max-w-[92vw]"
       role="listbox"                         
       aria-labelledby="find_groups_details_btn_level">
    <div class="find_groups_details_menu_inner max-h-[70vh] overflow-auto find_groups_details_noscroll">
      <button class="find_groups_details_menu_btn" role="option" data-value="Begginer">Begginer</button>
      <button class="find_groups_details_menu_btn" role="option" data-value="Elementary">Elementary</button>
      <button class="find_groups_details_menu_btn" role="option" data-value="Intermediate">Intermediate</button>
      <button class="find_groups_details_menu_btn" role="option" data-value="Upper Intermediate">Upper Intermediate</button>
      <button class="find_groups_details_menu_btn" role="option" data-value="Advanced">Advanced</button>
    </div>
  </div>
</div>

    <!-- 2) I'm available (icons above numbers + Days) -->
    <div class="relative">
      <button type="button" id="find_groups_details_btn_available"
              class="find_groups_details_card w-full px-4 text-left flex items-center justify-between">
        <span class="block">
          <span class="find_groups_details_label block">I'm available</span>
          <span id="find_groups_details_value_available" class="find_groups_details_value">Anytime</span>
        </span>
        <span class="find_groups_details_iconbtn">
          <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
               stroke-linecap="round" stroke-linejoin="round"><polyline points="6 9 12 15 18 9"/></svg>
        </span>
      </button>

      <div id="find_groups_details_menu_available" class="find_groups_details_menu absolute z-50 mt-2 hidden w-[360px] max-w-[92vw]">
        <div class="find_groups_details_menu_inner max-h-[75vh] overflow-auto find_groups_details_noscroll">
          <div class="find_groups_details_titlelg">Times</div>

          <div class="find_groups_details_sectiontitle">Daytime</div>
          <div class="grid grid-cols-3 gap-3">
            <button class="find_groups_details_chip" data-group="time" data-value="9–12">
              <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                <circle cx="12" cy="12" r="4"/><path d="M12 2v2M12 20v2M4 12H2M22 12h-2M5 5l1.5 1.5M17.5 17.5L19 19M5 19l1.5-1.5M17.5 6.5L19 5"/>
              </svg>
              <span class="find_groups_details_chip_label">9–12</span>
            </button>
            <button class="find_groups_details_chip" data-group="time" data-value="12–15">
              <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                <circle cx="12" cy="12" r="4"/><path d="M12 2v2M12 20v2M4 12H2M22 12h-2M5 5l1.5 1.5M17.5 17.5L19 19M5 19l1.5-1.5M17.5 6.5L19 5"/>
              </svg>
              <span class="find_groups_details_chip_label">12–15</span>
            </button>
            <button class="find_groups_details_chip" data-group="time" data-value="15–18">
              <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                <circle cx="12" cy="12" r="4"/><path d="M12 2v2M12 20v2M4 12H2M22 12h-2M5 5l1.5 1.5M17.5 17.5L19 19M5 19l1.5-1.5M17.5 6.5L19 5"/>
              </svg>
              <span class="find_groups_details_chip_label">15–18</span>
            </button>
          </div>

          <div class="find_groups_details_sectiontitle">Evening and night</div>
          <div class="grid grid-cols-3 gap-3">
            <button class="find_groups_details_chip" data-group="time" data-value="18–21">
              <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                <path d="M17 18a5 5 0 0 0-10 0"/><path d="M12 9V2"/><path d="m4.22 10.22 1.42 1.42"/><path d="M1 18h22"/><path d="m18.36 11.64 1.42-1.42"/>
              </svg>
              <span class="find_groups_details_chip_label">18–21</span>
            </button>
            <button class="find_groups_details_chip" data-group="time" data-value="21–24">
              <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                <path d="M3 21c8-6 10-12 18-8"/>
              </svg>
              <span class="find_groups_details_chip_label">21–24</span>
            </button>
            <button class="find_groups_details_chip" data-group="time" data-value="0–3">
              <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                <path d="M21 12.79A9 9 0 1 1 11.21 3 7 7 0 0 0 21 12.79z"/>
              </svg>
              <span class="find_groups_details_chip_label">0–3</span>
            </button>
          </div>

          <div class="find_groups_details_sectiontitle">Morning</div>
          <div class="grid grid-cols-3 gap-3">
            <button class="find_groups_details_chip" data-group="time" data-value="3–6">
              <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                <path d="M12 2v4"/><path d="m4.93 4.93 2.83 2.83"/><circle cx="12" cy="13" r="4"/>
              </svg>
              <span class="find_groups_details_chip_label">3–6</span>
            </button>
            <button class="find_groups_details_chip" data-group="time" data-value="6–9">
              <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                <path d="M12 2v4"/><path d="M4 14h16"/><path d="M9 14a3 3 0 1 1 6 0"/>
              </svg>
              <span class="find_groups_details_chip_label">6–9</span>
            </button>
          </div>

          <div class="find_groups_details_titlelg mt-4">Days</div>
          <div class="grid grid-cols-4 gap-3">
            <button class="find_groups_details_chip py-3" data-group="day" data-value="Sun"><span class="find_groups_details_chip_label">Sun</span></button>
            <button class="find_groups_details_chip py-3" data-group="day" data-value="Mon"><span class="find_groups_details_chip_label">Mon</span></button>
            <button class="find_groups_details_chip py-3" data-group="day" data-value="Tue"><span class="find_groups_details_chip_label">Tue</span></button>
            <button class="find_groups_details_chip py-3" data-group="day" data-value="Wed"><span class="find_groups_details_chip_label">Wed</span></button>
            <button class="find_groups_details_chip py-3" data-group="day" data-value="Thu"><span class="find_groups_details_chip_label">Thu</span></button>
            <button class="find_groups_details_chip py-3" data-group="day" data-value="Fri"><span class="find_groups_details_chip_label">Fri</span></button>
            <button class="find_groups_details_chip py-3" data-group="day" data-value="Sat"><span class="find_groups_details_chip_label">Sat</span></button>
          </div>
        </div>
      </div>
    </div>

    <!-- 3) Class taught in (SEARCH + CHECKBOXES) -->
    <div class="relative">
      <button type="button" id="find_groups_details_btn_lang"
              class="find_groups_details_card w-full px-4 text-left flex items-center justify-between">
        <span class="block">
          <span class="find_groups_details_label block">Class taught in</span>
          <span id="find_groups_details_value_lang" class="find_groups_details_value">English &amp; Spanish</span>
        </span>
        <span class="find_groups_details_iconbtn">
          <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
               stroke-linecap="round" stroke-linejoin="round"><polyline points="6 9 12 15 18 9"/></svg>
        </span>
      </button>

      <div id="find_groups_details_menu_lang" class="find_groups_details_menu absolute z-50 mt-2 hidden w-[360px] max-w-[92vw]">
        <div class="find_groups_details_menu_inner max-h-[70vh] overflow-auto find_groups_details_noscroll">

          <div class="find_groups_details_search">
            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
              <circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/>
            </svg>
            <input id="find_groups_details_search_lang" type="text" placeholder="Type to search..."/>
          </div>

          <div class="find_groups_details_sectiontitle" style="margin-top:2px;">Popular</div>

          <div id="find_groups_details_lang_options">
            <div class="find_groups_details_checkoption" data-value="English & Spanish">
              English &amp; Spanish
              <div class="find_groups_details_checkbox find_groups_details_checkbox--checked">
                <svg width="12" height="12" fill="none" stroke="currentColor" stroke-width="3" viewBox="0 0 24 24"><polyline points="20 6 9 17 4 12"/></svg>
              </div>
            </div>
            <div class="find_groups_details_checkoption" data-value="English ( only )">
              English ( only )
              <div class="find_groups_details_checkbox"></div>
            </div>
          </div>

        </div>
      </div>
    </div>

    <!-- 4) Class Type (POPULAR + CHECKBOXES) -->
    <div class="relative">
      <button type="button" id="find_groups_details_btn_type"
              class="find_groups_details_card w-full px-4 text-left flex items-center justify-between">
        <span class="block">
          <span class="find_groups_details_label block">Class Type</span>
          <span id="find_groups_details_value_type" class="find_groups_details_value" title="Theoretical &amp; Conversational">Theoretical and…</span>
        </span>
        <span class="find_groups_details_iconbtn">
          <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
               stroke-linecap="round" stroke-linejoin="round"><polyline points="6 9 12 15 18 9"/></svg>
        </span>
      </button>

      <div id="find_groups_details_menu_type" class="find_groups_details_menu absolute z-50 mt-2 hidden w-[360px] max-w-[92vw]">
        <div class="find_groups_details_menu_inner max-h-[70vh] overflow-auto find_groups_details_noscroll">
          <div class="find_groups_details_sectiontitle" style="margin-top:2px;">Popular</div>

          <div id="find_groups_details_type_options">
            <div class="find_groups_details_checkoption" data-value="Theoretical & Conversational">
              Theoretical &amp; Conversational
              <div class="find_groups_details_checkbox find_groups_details_checkbox--checked">
                <svg width="12" height="12" fill="none" stroke="currentColor" stroke-width="3" viewBox="0 0 24 24"><polyline points="20 6 9 17 4 12"/></svg>
              </div>
            </div>
            <div class="find_groups_details_divider"></div>
            <div class="find_groups_details_checkoption" data-value="Conversational (only)">
              Conversational (only)
              <div class="find_groups_details_checkbox"></div>
            </div>
          </div>

        </div>
      </div>
    </div>

    <!-- 5) Price per Month (RANGE SLIDER) -->
    <div class="relative">
      <button type="button" id="find_groups_details_btn_price"
              class="find_groups_details_card w-full px-4 text-left flex items-center justify-between">
        <span class="block">
          <span class="find_groups_details_label block">Price per Month</span>
          <span id="find_groups_details_value_price" class="find_groups_details_value">1 to 40+</span>
        </span>
        <span class="find_groups_details_iconbtn">
          <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
               stroke-linecap="round" stroke-linejoin="round"><polyline points="6 9 12 15 18 9"/></svg>
        </span>
      </button>

      <div id="find_groups_details_menu_price" class="find_groups_details_menu absolute z-50 mt-2 hidden w-[360px] max-w-[92vw]">
        <div class="find_groups_details_menu_inner">
          <div id="find_groups_details_price_readout" class="find_groups_details_price_readout">$1 – $40+</div>

          <div class="find_groups_details_range_wrap">
            <div id="find_groups_details_price_track" class="find_groups_details_range_track">
              <div id="find_groups_details_price_fill" class="find_groups_details_range_fill"></div>
              <div id="find_groups_details_price_thumb_min" class="find_groups_details_range_thumb" style="left:0%"></div>
              <div id="find_groups_details_price_thumb_max" class="find_groups_details_range_thumb" style="left:100%"></div>
            </div>
            <div class="find_groups_details_price_hint">Drag the boxes to set your range</div>
          </div>
        </div>
      </div>
    </div>

  </div>
</div>

<script>
  /* ====== state ====== */
  const find_groups_details_state = {
    level: "Begginer",
    availableTimes: new Set(),
    availableDays: new Set(),
    lang: ["English & Spanish"],                  // multi-select (languages)
    typeSelections: ["Theoretical & Conversational"],
    // Price slider config + current values
    priceCfg: { min: 1, max: 40, step: 1 },
    priceRange: { min: 1, max: 40 }               // current selection
  };

  /* ====== helper: close all ====== */
  function find_groups_details_closeAll(){
    $('.find_groups_details_menu').addClass('hidden');
    $('.find_groups_details_card').removeClass('find_groups_details_card--active');
  }

  /* ====== bind simple menus (Level only) ====== */
  function find_groups_details_bindSimple(btnId, menuId, targetId, stateKey){
    const $btn=$(btnId), $menu=$(menuId), $val=$(targetId);
    $btn.on('click', function(e){
      e.stopPropagation();
      const isOpen=!$menu.hasClass('hidden');
      find_groups_details_closeAll();
      if(!isOpen){ $menu.removeClass('hidden'); $btn.addClass('find_groups_details_card--active'); }
    });
    $menu.on('mousedown click keydown keyup input', function(e){ e.stopPropagation(); });
    $menu.on('click','.find_groups_details_menu_btn',function(){
      const v=$(this).data('value');
      $val.text(v).attr('title',v);
      find_groups_details_state[stateKey]=v;
      find_groups_details_closeAll();
    });
  }
  find_groups_details_bindSimple('#find_groups_details_btn_level','#find_groups_details_menu_level','#find_groups_details_value_level','level');

  /* ====== I’m available (chips) ====== */
  const $availBtn   = $('#find_groups_details_btn_available');
  const $availMenu  = $('#find_groups_details_menu_available');
  const $availValue = $('#find_groups_details_value_available');

  $availBtn.on('click', function(e){
    e.stopPropagation();
    const isOpen=!$availMenu.hasClass('hidden');
    find_groups_details_closeAll();
    if(!isOpen){ $availMenu.removeClass('hidden'); $availBtn.addClass('find_groups_details_card--active'); }
  });
  $availMenu.on('mousedown click keydown keyup input', function(e){ e.stopPropagation(); });

  function find_groups_details_updateAvailableLabel(){
    const times=[...find_groups_details_state.availableTimes];
    const days=[...find_groups_details_state.availableDays];
    const picks=[...times, ...days];
    if(picks.length===0){ $availValue.text('Anytime').attr('title','Anytime'); return; }
    if(picks.length<=2){
      const label=picks.join(', ');
      $availValue.text(label).attr('title',label);
    }else{
      const label=`${picks.length} selected`;
      $availValue.text(label).attr('title',picks.join(', '));
    }
  }
  $availMenu.on('click','.find_groups_details_chip',function(){
    const group=$(this).data('group');  // "time" | "day"
    const val=$(this).data('value');
    $(this).toggleClass('find_groups_details_chip--active');
    const set = (group==='time') ? find_groups_details_state.availableTimes : find_groups_details_state.availableDays;
    if(set.has(val)){ set.delete(val); } else { set.add(val); }
    find_groups_details_updateAvailableLabel();
  });

  /* ====== Class taught in (search + checkbox) ====== */
  const $langBtn   = $('#find_groups_details_btn_lang');
  const $langMenu  = $('#find_groups_details_menu_lang');
  const $langValue = $('#find_groups_details_value_lang');

  $langBtn.on('click', function(e){
    e.stopPropagation();
    const isOpen=!$langMenu.hasClass('hidden');
    find_groups_details_closeAll();
    if(!isOpen){ $langMenu.removeClass('hidden'); $langBtn.addClass('find_groups_details_card--active'); }
  });
  $langMenu.on('mousedown click keydown keyup input', function(e){ e.stopPropagation(); });

  $('#find_groups_details_lang_options').on('click','.find_groups_details_checkoption',function(){
    const v=$(this).data('value');
    const $box=$(this).find('.find_groups_details_checkbox');
    const checked=$box.hasClass('find_groups_details_checkbox--checked');

    if(checked){
      $box.removeClass('find_groups_details_checkbox--checked').empty();
      find_groups_details_state.lang = find_groups_details_state.lang.filter(x=>x!==v);
    }else{
      $box.addClass('find_groups_details_checkbox--checked')
          .html('<svg width="12" height="12" fill="none" stroke="currentColor" stroke-width="3" viewBox="0 0 24 24"><polyline points="20 6 9 17 4 12"/></svg>');
      if(!find_groups_details_state.lang.includes(v)) find_groups_details_state.lang.push(v);
    }

    if(find_groups_details_state.lang.length===0){
      $langValue.text('Select...');
    }else if(find_groups_details_state.lang.length===1){
      $langValue.text(find_groups_details_state.lang[0]);
    }else{
      $langValue.text(find_groups_details_state.lang.length+' selected');
    }
  });

  $('#find_groups_details_search_lang').on('input', function(e){
    e.stopPropagation();
    const q=$(this).val().toLowerCase().trim();
    $('#find_groups_details_lang_options .find_groups_details_checkoption').each(function(){
      const t=$(this).data('value').toLowerCase();
      $(this).toggle(t.indexOf(q)>-1);
    });
  });

  /* ====== Class Type (checkbox menu) ====== */
  const $typeBtn   = $('#find_groups_details_btn_type');
  const $typeMenu  = $('#find_groups_details_menu_type');
  const $typeValue = $('#find_groups_details_value_type');

  $typeBtn.on('click', function(e){
    e.stopPropagation();
    const isOpen=!$typeMenu.hasClass('hidden');
    find_groups_details_closeAll();
    if(!isOpen){ $typeMenu.removeClass('hidden'); $typeBtn.addClass('find_groups_details_card--active'); }
  });
  $typeMenu.on('mousedown click keydown keyup input', function(e){ e.stopPropagation(); });

  $('#find_groups_details_type_options').on('click','.find_groups_details_checkoption',function(){
    const v=$(this).data('value');
    const $box=$(this).find('.find_groups_details_checkbox');
    const checked=$box.hasClass('find_groups_details_checkbox--checked');

    if(checked){
      $box.removeClass('find_groups_details_checkbox--checked').empty();
      find_groups_details_state.typeSelections = find_groups_details_state.typeSelections.filter(x=>x!==v);
    }else{
      $box.addClass('find_groups_details_checkbox--checked')
          .html('<svg width="12" height="12" fill="none" stroke="currentColor" stroke-width="3" viewBox="0 0 24 24"><polyline points="20 6 9 17 4 12"/></svg>');
      if(!find_groups_details_state.typeSelections.includes(v)) find_groups_details_state.typeSelections.push(v);
    }

    const sel = find_groups_details_state.typeSelections;
    if(sel.length===0){ $typeValue.text('Select...').attr('title',''); }
    else if(sel.length===1){
      if(sel[0]==='Theoretical & Conversational'){
        $typeValue.text('Theoretical and…').attr('title', sel[0]);
      }else{
        $typeValue.text(sel[0]).attr('title', sel[0]);
      }
    }else{
      $typeValue.text(sel.length+' selected').attr('title', sel.join(', '));
    }
  });

  /* ====== Price per Month (range slider) ====== */
  const $priceBtn   = $('#find_groups_details_btn_price');
  const $priceMenu  = $('#find_groups_details_menu_price');
  const $priceField = $('#find_groups_details_value_price');
  const $priceRead  = $('#find_groups_details_price_readout');

  const $priceTrack = $('#find_groups_details_price_track');
  const $priceFill  = $('#find_groups_details_price_fill');
  const $thumbMin   = $('#find_groups_details_price_thumb_min');
  const $thumbMax   = $('#find_groups_details_price_thumb_max');

  $priceBtn.on('click', function(e){
    e.stopPropagation();
    const isOpen=!$priceMenu.hasClass('hidden');
    find_groups_details_closeAll();
    if(!isOpen){ 
      $priceMenu.removeClass('hidden'); 
      $priceBtn.addClass('find_groups_details_card--active'); 
      find_groups_details_updatePriceUI(); // ensure visuals sync when opening
    }
  });
  $priceMenu.on('mousedown click keydown keyup input', function(e){ e.stopPropagation(); });

  function find_groups_details_clamp(val, min, max){ return Math.max(min, Math.min(max, val)); }

  function find_groups_details_valueToPercent(val){
    const {min,max} = find_groups_details_state.priceCfg;
    return ((val - min) / (max - min)) * 100;
  }
  function find_groups_details_percentToValue(pct){
    const {min,max,step} = find_groups_details_state.priceCfg;
    const val = min + (pct/100)*(max-min);
    // snap to step
    return Math.round(val/step)*step;
  }

  function find_groups_details_updatePriceUI(){
    const {min:selMin, max:selMax} = find_groups_details_state.priceRange;
    const {min:cfgMin, max:cfgMax} = find_groups_details_state.priceCfg;

    const leftPct  = find_groups_details_valueToPercent(selMin);
    const rightPct = find_groups_details_valueToPercent(selMax);

    $thumbMin.css('left', `${leftPct}%`);
    $thumbMax.css('left', `${rightPct}%`);

    // fill between thumbs
    const fillLeft = Math.min(leftPct,rightPct);
    const fillRight= Math.max(leftPct,rightPct);
    $priceFill.css({ left: `${fillLeft}%`, width: `${fillRight-fillLeft}%` });

    // readout text
    const maxLabel = (selMax === cfgMax) ? `${selMax}+` : `${selMax}`;
    $priceRead.text(`$${selMin} – $${maxLabel}`);

    // field label (outside)
    $priceField.text(selMax === cfgMax ? `${selMin} to ${selMax}+` : `${selMin} to ${selMax}`);
    $priceField.attr('title',$priceField.text());
  }

  // Dragging logic (pointer events)
  function find_groups_details_bindThumb($thumb, which){
    $thumb.on('pointerdown', function(e){
      e.preventDefault(); e.stopPropagation();
      this.setPointerCapture(e.pointerId);

      const rect = $priceTrack[0].getBoundingClientRect();
      const onMove = (pe)=>{
        const x = find_groups_details_clamp(pe.clientX, rect.left, rect.right);
        const pct = ((x - rect.left) / rect.width) * 100;
        let val = find_groups_details_percentToValue(pct);

        // enforce ordering (no crossing)
        if(which==='min'){
          val = Math.min(val, find_groups_details_state.priceRange.max);
          val = Math.max(val, find_groups_details_state.priceCfg.min);
          find_groups_details_state.priceRange.min = val;
        }else{
          val = Math.max(val, find_groups_details_state.priceRange.min);
          val = Math.min(val, find_groups_details_state.priceCfg.max);
          find_groups_details_state.priceRange.max = val;
        }
        find_groups_details_updatePriceUI();
      };
      const onUp = (pe)=>{
        $(window).off('pointermove', onMove);
        $(window).off('pointerup', onUp);
      };
      $(window).on('pointermove', onMove);
      $(window).on('pointerup', onUp);
    });
  }
  find_groups_details_bindThumb($thumbMin,'min');
  find_groups_details_bindThumb($thumbMax,'max');

  // Initialize UI once
  find_groups_details_updatePriceUI();

  /* ====== global closing ====== */
  $(document).on('click', find_groups_details_closeAll);
  $(document).on('keydown', e=>{ if(e.key==='Escape') find_groups_details_closeAll(); });
</script>
<?php require_once('find_groups_details_profile_section.php'); ?>