<!-- ================== ONE MODAL, FOUR STEPS (Step-1 boxes snug + larger) ================== -->
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700&display=swap">
<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<script src="https://cdn.tailwindcss.com"></script>

<style>
  .glcm_backdrop{background:rgba(0,0,0,.45)}
  .glcm_shadow{box-shadow:0 12px 36px rgba(0,0,0,.18), 0 24px 64px rgba(0,0,0,.12)}
  .glcm_boxborder{border:1.5px solid #E4E7EE}
  .find_groups_book_trail_lesson_step2_box{border:1.5px solid #E4E7EE}
  .find_groups_book_trail_lesson_step3_box{border:1.5px solid #E4E7EE}

  /* Step-1 level boxes: bigger and perfectly centered */
  .glcm_level_box{
    border:1.5px solid #E4E7EE;
    border-radius:12px;
    height:60px;
    display:flex;
    align-items:center;
    justify-content:center;
    background:#fff;
    width:100%;
    min-width:170px;           /* gives each box a nice presence */
  }
  .glcm_level_text{
    font-weight:600;
    font-size:16px;
    color:#5E8F2F;
    line-height:1;
    text-align:center;
    width:100%;
  }
</style>

<div id="group_level_confirm_modal" class="fixed inset-0 z-[2000] hidden">
  <div class="absolute inset-0 glcm_backdrop"></div>

  <div class="relative h-full w-full flex items-center justify-center p-3 sm:p-4">
    <div class="relative w-full max-w-[460px] rounded-xl bg-white glcm_shadow">

      <!-- Close (X) -->
      <button id="glcm_close"
              class="absolute right-3.5 top-3.5 w-10 h-10 rounded-full flex items-center justify-center text-black/80 hover:bg-black/5"
              aria-label="Close">
        <svg xmlns="http://www.w3.org/2000/svg" class="w-[18px] h-[18px]" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
          <path d="M18 6 6 18M6 6l12 12"/>
        </svg>
      </button>

      <!-- ===== STEP 1 ===== -->
      <div id="glcm_step1" class="px-4 pt-6 pb-5 sm:px-7 sm:pt-7 sm:pb-6 font-[Inter,system-ui]">
        <h2 class="text-[28px] sm:text-[25px] leading-[1.15] font-bold text-[#121117] mb-4">
          Confirm Group Level
        </h2>

        <!-- Boxes row now uses 1fr / auto / 1fr so '=' is tight between boxes -->
        <div class="grid grid-cols-1 sm:[grid-template-columns:1fr_auto_1fr] items-center gap-2 mb-2" style="margin-left:-8px;">
          <div class="text-center">
            <div class="text-[12px] text-[#000000] mb-1">Selected group level</div>
            <div class="glcm_level_box">
              <span id="glcm_left_level" class="glcm_level_text">Begginer</span>
            </div>
          </div>

          <div class="flex items-center justify-center h-[60px] px-1" style="margin-top:15px;">
            <span class="text-[22px] font-bold text-[#121117]">=</span>
          </div>

          <div class="text-center">
            <div class="text-[12px] text-[#000000] mb-1">Selected group level</div>
            <div class="glcm_level_box">
              <span id="glcm_right_level" class="glcm_level_text">Begginer</span>
            </div>
          </div>
        </div>

        <p id="glcm_message" class="text-[15px] leading-[1.55] text-[#6B6E76]">
          Your English level matches the group. Therefore, you can proceed with the subscription.
        </p>

        <div class="mt-4 mb-3 border-t border-[#E4E7EE]"></div>

        <div class="space-y-2.5 text-[15px]">
          <div class="flex items-baseline justify-between gap-2">
            <span class="text-[#6B6E76]">Don't know your English level.</span>
            <a id="glcm_take_test" href="#" class="font-semibold underline decoration-transparent hover:decoration-inherit">Take a test</a>
          </div>
          <div class="flex items-baseline justify-between gap-2">
            <span class="text-[#6B6E76]">If you need a different group level.</span>
            <a id="glcm_click_here" href="#" class="font-semibold underline decoration-transparent hover:decoration-inherit">Click here</a>
          </div>
        </div>

        <button id="glcm_confirm" class="mt-5 w-full h-[48px] rounded-[10px] font-semibold bg-[var(--fgda-peach)] text-white border-2 border-black">
          Confirm
        </button>
      </div>

      <!-- ===== STEP 2 ===== -->
      <div id="find_groups_book_trail_lesson_step2_container" class="hidden px-5 pb-5 pt-5 sm:px-6 sm:pb-6 sm:pt-6 font-[Inter,system-ui]">
        <div class="flex items-center" style="margin-left:-30px;">
          <button id="find_groups_book_trail_lesson_step2_btn_back"
                  class="w-10 h-10 rounded-full flex items-center justify-center hover:bg-black/5" aria-label="Back" style="margin-top:-30px;">
            <svg xmlns="http://www.w3.org/2000/svg" class="w-[18px] h-[18px]" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M15 18 9 12l6-6"/></svg>
          </button>
        </div>

        <div class="mt-2 flex items-center gap-3">
          <div class="w-10 h-10 border border-[#E4E7EE] bg-[#F5FBED] flex flex-col items-center justify-center text-[#4D7C25] leading-none" style="border-radius:4px;">
            <div class="text-[12px] font-semibold">FL1</div>
            <div class="text-[9px] mt-[2px]">Florida 1</div>
          </div>
          <div>
            <div class="text-[16px] font-semibold text-[#121117] leading-tight">Book a trial lesson</div>
            <div class="text-[11px] text-[#6B6E76] -mt-0.5">To meet your classmates and teachers</div>
          </div>
        </div>

        <div class="mt-4 flex items-center justify-between">
          <button id="find_groups_book_trail_lesson_step2_btn_prev"
                  class="w-10 h-10 rounded-md border border-[#E4E7EE] flex items-center justify-center" aria-label="Previous week">
            <svg xmlns="http://www.w3.org/2000/svg" class="w-[18px] h-[18px]" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M15 18 9 12l6-6"/></svg>
          </button>
          <div id="find_groups_book_trail_lesson_step2_week" class="text-[16px] font-semibold text-[#121117]">September 16–22 , 2024</div>
          <button id="find_groups_book_trail_lesson_step2_btn_next"
                  class="w-10 h-10 rounded-md border border-[#E4E7EE] flex items-center justify-center" aria-label="Next week">
            <svg xmlns="http://www.w3.org/2000/svg" class="w-[18px] h-[18px]" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="m9 18 6-6-6-6"/></svg>
          </button>
        </div>

        <div id="find_groups_book_trail_lesson_step2_days" class="mt-3 grid grid-cols-7 gap-3 text-center"></div>

        <div class="mt-5 grid grid-cols-1 sm:grid-cols-2 gap-4">
          <div class="find_groups_book_trail_lesson_step2_box rounded-xl p-3">
            <div class="text-[13px] text-[#6B6E76] mb-1">Date :</div>
            <div id="find_groups_book_trail_lesson_step2_date" class="text-[12px] font-semibold">Monday, March 18</div>
          </div>
          <div class="find_groups_book_trail_lesson_step2_box rounded-xl p-3">
            <div class="text-[13px] text-[#6B6E76] mb-1">Time</div>
            <div id="find_groups_book_trail_lesson_step2_time" class="text-[12px] font-semibold">8 PM</div>
          </div>
        </div>

        <div class="mt-2 text-[12px] text-[#6B6E76]">
          in your time zone Europe/Brussel<br/>(GMT +10:00)
        </div>

        <button id="find_groups_book_trail_lesson_step2_btn_continue"
                class="mt-5 w-full h-[48px] rounded-[10px] font-semibold bg-[var(--fgda-peach)] text-white border-2 border-black">
          Continue
        </button>
      </div>

      <!-- ===== STEP 3 ===== -->
      <div id="find_groups_book_trail_lesson_step3_container" class="hidden px-5 pb-5 pt-5 sm:px-6 sm:pb-6 sm:pt-6 font-[Inter,system-ui]">
        <div class="flex items-center" style="margin-top:-25px; margin-left:-30px;">
          <button id="find_groups_book_trail_lesson_step3_btn_back"
                  class="w-10 h-10 rounded-full flex items-center justify-center hover:bg-black/5" aria-label="Back">
            <svg xmlns="http://www.w3.org/2000/svg" class="w-[18px] h-[18px]" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M15 18 9 12l6-6"/></svg>
          </button>
        </div>

        <div class="mt-2 flex items-center gap-3">
          <div class="w-10 h-10 border border-[#E4E7EE] bg-[#F5FBED] flex flex-col items-center justify-center text-[#4D7C25] leading-none" style="border-radius:10px;">
            <div class="text-[12px] font-semibold">FL1</div>
            <div class="text-[9px] mt-[2px]">Florida 1</div>
          </div>
          <div>
            <div class="text-[24px] sm:text-[28px] font-bold text-[#121117] leading-tight">Confirm Your Trial Lesson</div>
            <div class="text-[14px] text-[#6B6E76] mt-2">
              You're just one step away from booking your trial lesson!<br/>
              Please confirm the details below to get started.
            </div>
          </div>
        </div>

        <div class="mt-5 grid grid-cols-1 sm:grid-cols-2 gap-4">
          <div class="find_groups_book_trail_lesson_step3_box rounded-xl p-4">
            <div class="text-[13px] text-[#6B6E76] mb-1">Date :</div>
            <div id="find_groups_book_trail_lesson_step3_date" class="text-[18px] font-semibold">Monday, March 18</div>
          </div>
          <div class="find_groups_book_trail_lesson_step3_box rounded-xl p-4">
            <div class="text-[13px] text-[#6B6E76] mb-1">Time</div>
            <div id="find_groups_book_trail_lesson_step3_time" class="text-[18px] font-semibold">8 PM</div>
          </div>
        </div>

        <div class="mt-2 text-[12px] text-[#6B6E76]">
          in your time zone Europe/Brussel<br/>(GMT +10:00)
        </div>

        <button id="find_groups_book_trail_lesson_step3_btn_confirm"
                class="mt-5 w-full h-[52px] rounded-xl bg-[#F23C2A] text-white font-semibold text-[18px]">
          Confirm Booking
        </button>

        <button id="find_groups_book_trail_lesson_step3_btn_cancel"
                class="mt-3 w-full h-[52px] rounded-xl bg-white text-[#121117] font-semibold text-[18px] border-2 border-black/80">
          Cancel
        </button>
      </div>

      <!-- ===== STEP 4 (Success) ===== -->
      <div id="find_groups_book_trail_lesson_step4_container" class="hidden px-6 pt-10 pb-8 text-center font-[Inter,system-ui]">
        <div class="mx-auto w-12 h-12 rounded-full bg-[#F23C2A] flex items-center justify-center">
          <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" class="w-6 h-6" fill="none" stroke="#fff" stroke-width="3" stroke-linecap="round" stroke-linejoin="round">
            <polyline points="20 6 9 17 4 12"/>
          </svg>
        </div>
        <h3 class="mt-5 text-[24px] sm:text-[28px] font-bold text-[#121117]">Your Trial Lesson Is Booked!</h3>
        <p class="mt-3 text-[#6B6E76] text-[15px] leading-[1.6] max-w-[460px] mx-auto">
          Congratulations! Your trial lesson has been successfully booked. We look forward to seeing you soon!
        </p>
        <button id="find_groups_book_trail_lesson_step4_btn_goback"
                class="mt-6 w-full h-[52px] rounded-xl bg-[#F23C2A] text-white font-semibold text-[18px] border-2 border-black/80">
          Go Back
        </button>
      </div>
      <!-- /STEP 4 -->
    </div>
  </div>
</div>

<script>
(function(){
  const $overlay = $('#group_level_confirm_modal');
  const $body = $('body');
  const $step1 = $('#glcm_step1');
  const $step2 = $('#find_groups_book_trail_lesson_step2_container');
  const $step3 = $('#find_groups_book_trail_lesson_step3_container');
  const $step4 = $('#find_groups_book_trail_lesson_step4_container');

  function find_groups_book_trail_lesson_step1_open(opts={}){
    const left = opts.left || $('#find_groups_details_available_btn_book').data('left-level') || 'Begginer';
    const right = opts.right || $('#find_groups_details_available_btn_book').data('right-level') || left;
    $('#glcm_left_level').text(left);
    $('#glcm_right_level').text(right);
    const matches = (left.trim().toLowerCase() === right.trim().toLowerCase());
    $('#glcm_message').text(matches
      ? 'Your English level matches the group. Therefore, you can proceed with the subscription.'
      : 'Your English level does not match this group. Please choose a different group level or take a quick test.');

    $step2.addClass('hidden'); $step3.addClass('hidden'); $step4.addClass('hidden');
    $step1.removeClass('hidden');
    $overlay.removeClass('hidden'); $body.addClass('overflow-hidden');
  }
  window.find_groups_book_trail_lesson_step1_open = find_groups_book_trail_lesson_step1_open;

  $(document).on('click', '#find_groups_details_available_btn_book', function(e){
    e.preventDefault(); find_groups_book_trail_lesson_step1_open();
  });

  function modalClose(){ $overlay.addClass('hidden'); $body.removeClass('overflow-hidden'); }
  $('#glcm_close').on('click', modalClose);
  $overlay.on('click', e => { if(e.target === e.currentTarget) modalClose(); });
  $(document).on('keydown', e => { if(e.key==='Escape' && !$overlay.hasClass('hidden')) modalClose(); });

  $('#glcm_take_test').on('click', e => { e.preventDefault(); modalClose(); });

  function openEnglishLevelDropdown(){
    if (window.find_groups_details_openLevelMenu) { window.find_groups_details_openLevelMenu(); return true; }
    const btn = document.getElementById('find_groups_details_btn_level');
    if(btn){ btn.scrollIntoView({behavior:'smooth', block:'center'}); setTimeout(()=>btn.click(), 60); return true; }
    return false;
  }
  $('#glcm_click_here').on('click', function(e){ e.preventDefault(); modalClose(); setTimeout(openEnglishLevelDropdown, 120); });

  $('#glcm_confirm').on('click', function(){ $step1.addClass('hidden'); $step2.removeClass('hidden'); });

  /* ----- Step 2 ----- */
  const DAYS = [
    {key:'sat', short:'sat', full:'Saturday',   num:16},
    {key:'sun', short:'sun', full:'Sunday',     num:17},
    {key:'mon', short:'mon', full:'Monday',     num:18},
    {key:'tue', short:'tue', full:'Tuesday',    num:19},
    {key:'wed', short:'wed', full:'Wednesday',  num:20},
    {key:'thu', short:'thu', full:'Thursday',   num:21},
    {key:'fri', short:'fri', full:'Friday',     num:22},
  ];
  const MONTH_LABEL = 'March';
  const $daysWrap = $('#find_groups_book_trail_lesson_step2_days');

  function renderDays(selected='mon'){
    $daysWrap.empty();
    DAYS.forEach(d=>{
      const active = d.key === selected;
      $daysWrap.append(`
        <button type="button" class="select-none" data-key="${d.key}">
          <div class="text-[12px] ${active ? 'text-[#121117] font-semibold' : 'text-[#6B6E76]'}">${d.short}</div>
          <div class="mt-1 w-9 h-9 mx-auto rounded-full flex items-center justify-center ${active ? 'bg-[#F23C2A] text-white' : 'text-[#121117]'}">${d.num}</div>
        </button>
      `);
    });
    const sel = DAYS.find(x=>x.key===selected) || DAYS[2];
    $('#find_groups_book_trail_lesson_step2_date').text(`${sel.full}, ${MONTH_LABEL} ${sel.num}`);
  }
  renderDays('mon');
  $daysWrap.on('click', 'button', function(){ renderDays($(this).data('key')); });

  $('#find_groups_book_trail_lesson_step2_btn_back').on('click', function(){ $step2.addClass('hidden'); $step1.removeClass('hidden'); });
  $('#find_groups_book_trail_lesson_step2_btn_prev, #find_groups_book_trail_lesson_step2_btn_next').on('click', e => e.preventDefault());

  $('#find_groups_book_trail_lesson_step2_btn_continue').on('click', function(){
    const selectedDate = $('#find_groups_book_trail_lesson_step2_date').text().trim();
    const selectedTime = $('#find_groups_book_trail_lesson_step2_time').text().trim();
    find_groups_book_trail_lesson_step3_open({date:selectedDate, time:selectedTime});
  });

  /* ----- Step 3 ----- */
  function find_groups_book_trail_lesson_step3_open(opts={}){
    if(opts.date) $('#find_groups_book_trail_lesson_step3_date').text(opts.date);
    if(opts.time) $('#find_groups_book_trail_lesson_step3_time').text(opts.time);
    $step2.addClass('hidden'); $step1.addClass('hidden'); $step4.addClass('hidden');
    $step3.removeClass('hidden');
  }
  window.find_groups_book_trail_lesson_step3_open = find_groups_book_trail_lesson_step3_open;

  $('#find_groups_book_trail_lesson_step3_btn_back').on('click', function(){ $step3.addClass('hidden'); $step2.removeClass('hidden'); });
  $('#find_groups_book_trail_lesson_step3_btn_cancel').on('click', function(){ modalClose(); });
  $('#find_groups_book_trail_lesson_step3_btn_confirm').on('click', function(){ find_groups_book_trail_lesson_step4_open(); });

  /* ----- Step 4 ----- */
  function find_groups_book_trail_lesson_step4_open(){
    $step1.addClass('hidden'); $step2.addClass('hidden'); $step3.addClass('hidden');
    $step4.removeClass('hidden');
  }
  window.find_groups_book_trail_lesson_step4_open = find_groups_book_trail_lesson_step4_open;

  $('#find_groups_book_trail_lesson_step4_btn_goback').on('click', function(){ modalClose(); });
})();
</script>
<!-- ================== /ONE MODAL, FOUR STEPS ================== -->
