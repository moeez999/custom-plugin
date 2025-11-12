<link rel="stylesheet" href="css/my_lessons_details_reshedule.css"/>

<?php
require_once("../../config.php");
// require_once($CFG->dirroot. '/course/lib.php');

$PAGE->requires->css(new moodle_url('./style.css?v=' . time()), true);
$PAGE->requires->css(new moodle_url('./course.css?v=' . time()), true);

echo $OUTPUT->header();
require_once('custom_header.php');
?>

<script src="https://cdn.tailwindcss.com"></script>
<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>

<style>
  /* === Tabs (exact like snapshot) === */
  .my-tabs-group{ border-radius: 18px; }
  .my_lessons_details_reshedule_tab_btn{
    background:#f3f4f8; color:#0f1115; border:1px solid #E6E7EF;
    box-shadow:0 1px 0 rgba(16,18,27,.04);
    transition:background .15s, box-shadow .15s, border-color .15s;
  }
  .my_lessons_details_reshedule_tab_btn[data-active="true"]{ background:#fff; }
  .mytab-right{ margin-left:-1px; } /* collapse middle seam */
  /* OUTER corners rounded, inner corners square */
  .my_lessons_details_reshedule_tab_btn[data-side="left"]{
    border-top-left-radius:5px;border-bottom-left-radius:5px;border-top-right-radius:0;border-bottom-right-radius:0;
  }
  .my_lessons_details_reshedule_tab_btn[data-side="right"]{
    border-top-right-radius:5px;border-bottom-right-radius:5px;border-top-left-radius:0;border-bottom-left-radius:0;
  }
  .my_lessons_details_reshedule_tab_btn:hover{ background:rgba(246,247,251,.9); }
  .my_lessons_details_reshedule_tab_btn[data-active="true"]:hover{ background:#fff; }
  .tab-ico{ width:22px;height:22px; display:block; }

  /* Show/Hide date+pager (Single only shows) */
  #my_lessons_details_reshedule_datebar[data-visible="false"]{ display:none; }

  /* Left pane polish */
  .my_lessons_details_reshedule_scrollbarNone { -ms-overflow-style: none; scrollbar-width: none; }
  .my_lessons_details_reshedule_scrollbarNone::-webkit-scrollbar { display: none; }
  .my_lessons_details_reshedule_cell { min-height:56px; display:flex; align-items:center; justify-content:center; }

  /* Time slot pills */
  .my_lessons_details_reshedule_slot{
    width:168px;height:56px;max-width:90vw;display:flex;align-items:center;justify-content:center;
    padding:0 14px;background:#fff;color:#0f1115;font-weight:500;font-size:16px;line-height:1;user-select:none;cursor:pointer;
    border:2px solid #e6e7ef;border-radius:5px;box-shadow:0 1px 0 rgba(16,18,27,.04);
    transition:transform .06s ease, background-color .12s ease, border-color .12s ease, color .12s ease, box-shadow .12s ease;
  }
  .my_lessons_details_reshedule_slot:hover{ background:#fbfbfe;border-color:#dfe2ea;box-shadow:0 2px 6px rgba(16,18,27,.06); }
  .my_lessons_details_reshedule_slot:active{ transform:scale(.985); }
  .my_lessons_details_reshedule_selected{ background:#0f1115!important;color:#fff!important;border-color:#0f1115!important;box-shadow:0 4px 10px rgba(16,18,27,.16); }
  .my_lessons_details_reshedule_disabled{ background:#f2f3f7!important;color:#a6adba!important;border-color:#dadce6!important;cursor:not-allowed!important;box-shadow:none!important; }
  .my_lessons_details_reshedule_redborder{ border-color:#ff3b1f!important; }

  /* Tooltip */
  .my_lessons_details_reshedule_tip{
    position:fixed; z-index:9999; background:#0f1115; color:#fff;
    padding:10px 14px; border-radius:5px; font-weight:500; font-size: 10px;
    box-shadow:0 10px 24px rgba(0,0,0,.25); max-width:min(90vw,420px);
  }
  .my_lessons_details_reshedule_tip .my_lessons_details_reshedule_tip_sub{ display:block; margin-top:2px; font-weight:600; color:#cfd3dc; }
  .my_lessons_details_reshedule_tip:after{ content:""; position:absolute; left:50%; transform:translateX(-50%); top:100%; border:7px solid transparent; border-top-color:#0f1115; }

  /* Duration dropdown cleanup */
  #my_lessons_details_reshedule_duration_menu ul{ list-style:none!important; padding-left:0!important; counter-reset:none!important; }
  #my_lessons_details_reshedule_duration_menu li{ list-style:none!important; counter-increment:none!important; }
  #my_lessons_details_reshedule_duration_menu li::marker{ content:""!important; }
  #my_lessons_details_reshedule_duration_menu *::before, #my_lessons_details_reshedule_duration_menu *::after{ content:none!important; display:none!important; }
  #my_lessons_details_reshedule_duration_menu .mylessons-row{ line-height: 20px; }
  #my_lessons_details_reshedule_duration_menu{ --menu-radius: 12px; border-radius: var(--menu-radius); box-shadow: 0 12px 28px rgba(16,18,27,.12); }
  #my_lessons_details_reshedule_duration_menu .mylessons-row:hover{ background:#f2f3f7; }

  /* TZ text */
  #my_lessons_details_reshedule_tzbar{ font-size:12px; line-height:20px; color:#6b7280; font-weight:500; }
  #my_lessons_details_reshedule_tzText { font-size:12px; line-height:20px; color:#6b7280; font-weight:500; }

  /* Pager icons */
  .mylessons-pager-ico{ width:16px;height:16px;display:block;pointer-events:none;filter:none; }
  .mylessons-pager-btn:active .mylessons-pager-ico{ transform: translateX(-1px); }
  #my_lessons_details_reshedule_next:active .mylessons-pager-ico{ transform: translateX(1px); }

  /* Close X */
  #my_lessons_details_reshedule_close{
    width: 32px !important; height: 32px !important; border-radius: 4px; background: transparent; color: #3e3e3e !important;
    line-height: 1; transition: background-color .15s ease, color .15s ease, box-shadow .15s ease; z-index: 50;
  }
  #my_lessons_details_reshedule_close:hover{ background: #e1e3e7; color:#000; box-shadow: 0 6px 16px rgba(16,18,27,.12); }

  /* CTA */
  #my_lessons_details_reshedule_cta, #my_lessons_details_reshedule_cta *{ list-style:none!important; counter-reset:none!important; counter-increment:none!important; }
  #my_lessons_details_reshedule_cta::before, #my_lessons_details_reshedule_cta::after{ content:none!important; display:none!important; }
  #my_lessons_details_reshedule_cta[disabled]{ background:#FF3B1F0D!important; color:#6B6F7D!important; border-color:#AEB1BF!important; cursor:not-allowed!important; }
  #my_lessons_details_reshedule_cta.active-red{ background:#FF3B1F!important; color:#fff!important; border-color:#000!important; }
  button#my_lessons_details_reshedule_cta[disabled],
  button#my_lessons_details_reshedule_cta[disabled].active-red,
  button#my_lessons_details_reshedule_cta[disabled]:hover,
  button#my_lessons_details_reshedule_cta[disabled]:focus{
    background:#CFCFDC!important; color:#6B6F7D!important; border:1px solid #AEB1BF!important; box-shadow:none!important; pointer-events:none;
  }

  /* Right-panel placeholders + filled items */
  .rp-item{
    height:48px; display:flex; align-items:center; padding:0 14px;
    border:1px dashed #E5E7EB; border-radius:12px; color:#6B7280; font-weight:500;
    background:#fff;
  }
  .rp-chosen{
    display:flex; flex-direction:column; gap:4px;
    border:2px solid #0f1115; border-radius:5px; padding:10px 44px 10px 14px; background:#fff; position:relative;
  }
  .rp-chosen-title{ font-weight:600; color:#0f1115; }
  .rp-chosen-sub{ font-size:13px; color:#6B7280; }
  .rp-remove{
    position:absolute; right:8px; top:50%; transform:translateY(-50%);
    width:28px;height:28px;
    /* border-radius:8px; */
    display:grid;place-items:center;
    /* border:1px solid #E5E7EB;background:#fff; */
  }
  .rp-remove:hover{ background:#f4f4f6; }
</style>

<div class="max-w-[1600px] mx-auto py-6 h-screen overflow-hidden">
  <div class="grid grid-cols-1 lg:grid-cols-12 h-full gap-6">

    <!-- LEFT -->
    <div class="lg:col-span-7 overflow-y-auto pr-3 my_lessons_details_reshedule_scrollbarNone" id="my_lessons_details_reshedule_leftpane" style="margin-top:20px; margin-left:10%;">

      <!-- ── FROZEN HEADER: tabs → date+pager → days -->
      <div class="sticky top-0 z-20 bg-white" style="width:720px;">
        <!-- TABS -->
        <div id="my_lessons_details_reshedule_tabs" class="mt-1">
          <div class="my-tabs-group flex gap-0">
            <!-- Weekly -->
            <button
              id="my_lessons_details_reshedule_tab_weekly"
              type="button"
              data-tab="weekly"
              data-side="left"
              class="my_lessons_details_reshedule_tab_btn mytab-left group flex items-center gap-3 flex-1 px-4 py-3 ring-0">
              <span class="inline-flex h-9 w-9 shrink-0 items-center justify-center">
                <img class="tab-ico" src="img/weekly_lesson_reschedule.svg" alt="">
              </span>
              <span class="text-left">
                <span class="block text-[16px] leading-5 font-semibold">Weekly lessons</span>
                <span class="block text-[13px] leading-5 text-gray-500">Repeat lessons at the same time every week</span>
              </span>
            </button>

            <!-- Single -->
            <button
              id="my_lessons_details_reshedule_tab_single"
              type="button"
              data-tab="single"
              data-side="right"
              class="my_lessons_details_reshedule_tab_btn mytab-right group flex items-center gap-3 flex-1 px-4 py-3 ring-0">
              <span class="inline-flex h-9 w-9 shrink-0 items-center justify-center">
                <img class="tab-ico" src="img/single_lesson_reschedule.svg" alt="">
              </span>
              <span class="text-left">
                <span class="block text-[16px] leading-5 font-semibold">Single lessons</span>
                <span class="block text-[13px] leading-5 text-gray-500">Choose different times for each lesson</span>
              </span>
            </button>
          </div>
        </div>

        <!-- DATE + PAGER (below tabs; Single only) -->
        <div id="my_lessons_details_reshedule_datebar" data-visible="false" class="flex items-center justify-between pt-3">
          <h1 id="my_lessons_details_reshedule_weekLabel" class="text-3xl font-extrabold tracking-tight" style="font-size: 20px;font-weight: 500;">Feb 16 – 22, 2025</h1>

          <div id="my_lessons_details_reshedule_pager"
               class="inline-flex items-stretch rounded-[6px] overflow-hidden border border-[#E6E7EF] shadow-[0_1px_0_rgba(16,18,27,0.04)] bg-white"
               aria-label="Change week">
            <button id="my_lessons_details_reshedule_prev"
                    class="w-12 h-9 grid place-items-center hover:bg-gray-50 focus:outline-none"
                    aria-label="Previous week">
              <svg viewBox="0 0 16 16" class="mylessons-pager-ico" fill="#121117" aria-hidden="true">
                <path fill-rule="evenodd" clip-rule="evenodd" d="M10.5 13L6 8l4.5-5 1.1 1.05L8.2 8l3.4 3.95L10.5 13z"/>
              </svg>
            </button>
            <div class="w-px bg-[#E6E7EF]"></div>
            <button id="my_lessons_details_reshedule_next"
                    class="w-12 h-9 grid place-items-center hover:bg-gray-50 focus:outline-none"
                    aria-label="Next week">
              <svg viewBox="0 0 16 16" class="mylessons-pager-ico" fill="#121117" aria-hidden="true">
                <path fill-rule="evenodd" clip-rule="evenodd" d="M5.5 3L10 8l-4.5 5-1.1-1.05L7.8 8 4.4 4.05 5.5 3z"/>
              </svg>
            </button>
          </div>
        </div>

        <!-- DAYS -->
        <div id="my_lessons_details_reshedule_days" class="grid grid-cols-7 gap-x-4 pb-2 border-b border-gray-200" style="margin-top:2%;"></div>
      </div>

      <!-- TZ -->
      <div id="my_lessons_details_reshedule_tzbar"
           class="mt-2 mb-2 text-[14px] leading-[20px] text-[#6b7280] font-medium">
        In your time zone:
        <span id="my_lessons_details_reshedule_tzText" class="font-medium">
          America/New_York (GMT -5:00)
        </span>
      </div>

      <!-- GRID -->
      <div id="my_lessons_details_reshedule_grid" class="mt-2 grid grid-cols-7 gap-x-4 gap-y-2"></div>
      <div class="py-6"></div>
    </div>

    <!-- RIGHT -->
    <div class="lg:col-span-4">
      <div class="sticky top-6">
        <div class="relative">
          <!-- Close -->
          <button id="my_lessons_details_reshedule_close" style="margin-right:-35px;font-size:30px;top:10px;"
                  class="absolute -top-2 -right-2 w-6 h-6 flex items-center justify-center text-[18px] leading-none text-gray-700 hover:text-black"
                  aria-label="Close">×</button>

          <div class="border border-gray-200 rounded-md bg-white shadow-[0_10px_28px_rgba(16,18,27,0.06)] p-5 max-w-md ml-auto">
            <!-- Tutor + Duration -->
            <div class="flex items-start gap-4">
              <img class="w-12 h-12 rounded-xl object-cover"
                   src="https://images.unsplash.com/photo-1517841905240-472988babdf9?q=80&w=400&auto=format&fit=crop" alt="">
              <div class="flex-1">
                <div class="text-lg font-semibold">English with Daniela</div>

                <div id="my_lessons_details_reshedule_duration_wrap" class="relative inline-block mt-1">
                  <button id="my_lessons_details_reshedule_duration_toggle"
                          class="text-sm underline underline-offset-2 font-medium flex items-center gap-1"
                          type="button" aria-haspopup="true" aria-expanded="false">
                    <span id="my_lessons_details_reshedule_duration_label">50 min lessons</span>
                    <svg class="my_lessons_details_reshedule_caret" viewBox="0 0 16 16" aria-hidden="true">
                      <path d="M4 6.5l4 4 4-4" fill="none" stroke="currentColor"
                            stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round"/>
                    </svg>
                  </button>

                  <div id="my_lessons_details_reshedule_duration_menu"
                       class="hidden absolute left-0 mt-2 w-[260px] rounded-xl border border-gray-200 bg-white shadow-xl z-30">
                    <div class="py-1 text-[14px] leading-[20px]" role="menu">
                      <button class="my_lessons_details_reshedule_duration_item mylessons-row w-full text-left px-3 py-2 hover:bg-gray-100" data-value="25 minutes" role="menuitem">
                        <div class="flex items-center justify-between gap-3">
                          <span>25 Minutes</span>
                          <span class="my_lessons_details_reshedule_check hidden">✓</span>
                        </div>
                      </button>
                      <div class="mx-3 my-1 h-px bg-gray-200"></div>
                      <button class="my_lessons_details_reshedule_duration_item mylessons-row w-full text-left px-3 py-2 hover:bg-gray-100" data-value="50 minutes" data-selected="true" role="menuitem">
                        <div class="flex items-center justify-between gap-3">
                          <span>50 Minutes</span>
                          <span class="my_lessons_details_reshedule_check">✓</span>
                        </div>
                      </button>
                      <div class="mx-3 my-1 h-px bg-gray-200"></div>
                      <button class="my_lessons_details_reshedule_duration_item mylessons-row w-full text-left px-3 py-2 hover:bg-gray-100" data-value="1 hour, 20 minutes" role="menuitem">
                        <div class="flex items-center justify-between gap-3">
                          <span>1 Hour</span>
                          <span class="my_lessons_details_reshedule_check hidden">✓</span>
                        </div>
                      </button>
                      <div class="mx-3 my-1 h-px bg-gray-200"></div>
                      <button class="my_lessons_details_reshedule_duration_item mylessons-row w-full text-left px-3 py-2 hover:bg-gray-100" data-value="1 hour, 50 minutes" role="menuitem">
                        <div class="flex items-center justify-between gap-3">
                          <span>1.5 Hour</span>
                          <span class="my_lessons_details_reshedule_check hidden">✓</span>
                        </div>
                      </button>
                    </div>
                  </div>
                </div>
                <!-- /Duration -->
              </div>
            </div>

            <!-- Right-panel header + list (3 max) -->
            <div id="my_lessons_details_reshedule_lessons_counter" class="mt-4 mb-3 text-[16px] font-semibold text-gray-900">3 lessons to schedule</div>
            <div id="my_lessons_details_reshedule_list" class="flex flex-col gap-3"></div>

            <button id="my_lessons_details_reshedule_cta" disabled
                    class="w-full rounded-md h-12 mt-4 font-semibold border border-gray-300 bg-gray-200 text-gray-500 cursor-not-allowed" style="border: 2px solid black !important;">
              Schedule
            </button>

            <p class="text-black-500 text-center mt-3 text-sm leading-4" style="font-size:12px;">
              Cancel or reschedule for free up to 12 hrs<br>before the lesson starts.
            </p>

            <!-- Hide legacy “New lesson time” area -->
            <div class="hidden">
              <div class="mt-4 text-base font-semibold">New lesson time</div>
              <div id="my_lessons_details_reshedule_chipfield" class="flex flex-col gap-2 mt-1">
                <div id="my_lessons_details_reshedule_placeholder"
                     class="h-12 flex items-center px-4 border border-gray-300 rounded-xl text-gray-400 font-medium">
                  Lesson
                </div>
              </div>
            </div>

          </div>
        </div>
      </div>
    </div>

  </div>
</div>

<?php require_once('my_lessons_details_calendar_content_weekly_schedule_lesson.php');?>
<?php //require_once('my_lessons_details_calendar_content_success.php'); ?>

<?php
echo $OUTPUT->footer();
?>

<script>
(function($){
  /* ====================== TABS / STATE ====================== */
  let my_lessons_details_reshedule_activeTab = 'weekly';  // 'weekly' | 'single'
  const MAX_SLOTS = 3;

  // separate state per tab
  const state = {
    weekly: { weekIndex: 0, selectedKeys: new Set(), selections: [] },
    single: { weekIndex: 0, selectedKeys: new Set(), selections: [] }
  };

  const $tabWeekly = $('#my_lessons_details_reshedule_tab_weekly');
  const $tabSingle = $('#my_lessons_details_reshedule_tab_single');
  const $datebar = $('#my_lessons_details_reshedule_datebar');

  const $cta = $('#my_lessons_details_reshedule_cta');
  const $counter = $('#my_lessons_details_reshedule_lessons_counter');
  const $list = $('#my_lessons_details_reshedule_list');

  /* ====================== DATA ====================== */
  const weeks = [
    {
      label: "Feb 16 – 22, 2025",
      days: ["Sun 16","Mon 17","Tue 18","Wed 19","Thu 20","Fri 21","Sat 22"],
      slots: {
        "Sun 16":["03:00","05:00","07:30","08:00"],
        "Mon 17":["07:30","08:00"],
        "Tue 18":["03:00","05:00","06:00","06:30","07:00","07:30","08:00"],
        "Wed 19":["05:00","06:00","06:30","07:30","08:00"],
        "Thu 20":["03:00","07:00","07:30","08:00"],
        "Fri 21":["03:00","07:30"],
        "Sat 22":[]
      },
      disabled: new Set([]),
      redBorder: new Set([])
    },
    {
      label: "Feb 23 – Mar 1, 2025",
      days: ["Sun 23","Mon 24","Tue 25","Wed 26","Thu 27","Fri 28","Sat 1"],
      slots: {
        "Sun 23":["05:00","07:00","07:30","08:00"],
        "Mon 24":["05:30","06:00","06:30","07:00","07:30","08:00"],
        "Tue 25":["07:30","08:00"],
        "Wed 26":["03:00","07:30"],
        "Thu 27":["05:00","07:00","07:30","08:00"],
        "Fri 28":["03:00","07:30","08:00"],
        "Sat 1":[]
      },
      disabled: new Set([]),
      redBorder: new Set([])
    }
  ];

  /* ====================== HELPERS ====================== */
  const abbrToFull = {Sun:"Sunday", Mon:"Monday", Tue:"Tuesday", Wed:"Wednesday", Thu:"Thursday", Fri:"Friday", Sat:"Saturday"};
  const monthShort = ["Jan","Feb","Mar","Apr","May","Jun","Jul","Aug","Sep","Oct","Nov","Dec"];

  function getActiveState(){ return state[my_lessons_details_reshedule_activeTab]; }

  function addMinutes(hhmm, add=50){
    const [h,m]=hhmm.split(':').map(Number);
    const total=h*60+m+add, hh=Math.floor(total/60)%24, mm=total%60;
    const pad = n => String(n).padStart(2,'0');
    return `${pad(hh)}:${pad(mm)}`;
  }

  function parseWeekMeta(label){
    // Examples: "Feb 16 – 22, 2025"  OR "Feb 23 – Mar 1, 2025"
    const m = label.match(/^([A-Za-z]+)\s+(\d+)\s+–\s+([A-Za-z]+)?\s*(\d+),\s*(\d{4})$/);
    if(!m) return null;
    const startMonthName = m[1], startDay = +m[2];
    const endMonthName = m[3] || startMonthName, endDay = +m[4], year = +m[5];
    return {
      year,
      start: { monthName: startMonthName, monthIndex: monthShort.indexOf(startMonthName), day: startDay },
      end:   { monthName: endMonthName,   monthIndex: monthShort.indexOf(endMonthName),   day: endDay }
    };
  }

  function dateFromWeekAndDay(weekLabel, dayKey){
    // dayKey like "Fri 21"
    const meta = parseWeekMeta(weekLabel);
    if(!meta) return null;
    const dayNum = +dayKey.split(' ')[1];
    // decide month: if dayNum < start.day => end.month (for cross-month weeks), else start.month
    const useEndMonth = dayNum < meta.start.day;
    const mi = useEndMonth ? meta.end.monthIndex : meta.start.monthIndex;
    return new Date(meta.year, mi, dayNum);
  }

  function formatSingleMain(weekLabel, dayKey, time){
    // "Fri, Feb 21, 03:00 – 03:50"
    const abbr = dayKey.split(' ')[0];
    const date = dateFromWeekAndDay(weekLabel, dayKey);
    const mon = monthShort[date.getMonth()];
    const day = date.getDate();
    return `${abbr}, ${mon} ${day}, ${time} – ${addMinutes(time, 50)}`;
  }

  function formatWeeklyMain(dayKey, time){
    // "Every Sunday, 05:00 – 05:50"
    const abbr = dayKey.split(' ')[0];
    const full = abbrToFull[abbr] || abbr;
    return `Every ${full}, ${time} – ${addMinutes(time, 50)}`;
  }
  function formatWeeklySub(weekLabel, dayKey){
    // "Starts on Feb 23" (next occurrence = selected date + 7 days)
    const d = dateFromWeekAndDay(weekLabel, dayKey);
    d.setDate(d.getDate() + 7);
    return `Starts on ${monthShort[d.getMonth()]} ${d.getDate()}`;
  }

  function allTimesSorted(week){
    const set=new Set(); week.days.forEach(d=>week.slots[d]?.forEach(t=>set.add(t)));
    return [...set].sort((a,b)=> (+a.slice(0,2)*60+ +a.slice(3)) - (+b.slice(0,2)*60+ +b.slice(3)));
  }

  function clearTip(){ if(window.__my_tip){ window.__my_tip.remove(); window.__my_tip=null; } }

  function updateHeaderByTab(){ $datebar.attr('data-visible', my_lessons_details_reshedule_activeTab === 'single' ? 'true' : 'false'); }

  /* Right panel: build 3 slots: filled items or placeholders */
  function renderRightPanel(){
    const st = getActiveState();
    const week = weeks[st.weekIndex];

    // Header shows remaining to schedule
    const remaining = Math.max(0, MAX_SLOTS - st.selections.length);
    $counter.text(`${remaining} lesson${remaining===1?'':'s'} to schedule`);

    // CTA
    if(st.selections.length > 0){
      $cta.prop("disabled", false).addClass("active-red")
          .text(my_lessons_details_reshedule_activeTab==='weekly' ? 'Schedule Weekly Lesson' : 'Schedule');
    }else{
      $cta.prop("disabled", true).removeClass("active-red")
          .text(my_lessons_details_reshedule_activeTab==='weekly' ? 'Schedule Weekly Lesson' : 'Schedule');
    }

    // List
    $list.empty();
    for(let i=0;i<MAX_SLOTS;i++){
      const s = st.selections[i];
      if(s){
        // filled item
        const sub = (my_lessons_details_reshedule_activeTab==='weekly')
          ? `<div class="rp-chosen-sub">${formatWeeklySub(week.label, s.day)}</div>` : '';
        $list.append(`
          <div class="rp-chosen" data-key="${s.key}">
            <div class="rp-chosen-title">${
              my_lessons_details_reshedule_activeTab==='weekly'
                ? formatWeeklyMain(s.day, s.time)
                : formatSingleMain(week.label, s.day, s.time)
            }</div>
            ${sub}
            <button type="button" class="rp-remove" aria-label="Remove" data-key="${s.key}">×</button>
          </div>
        `);
      }else{
        // placeholder
        const label = my_lessons_details_reshedule_activeTab==='weekly'
          ? `Weekly lesson ${i+1}` : `lesson ${i+1}`;
        $list.append(`<div class="rp-item">${label}</div>`);
      }
    }
  }

  /* ====================== RENDER ====================== */
  function renderDays(week){
    const $row = $("#my_lessons_details_reshedule_days").empty();

    if(my_lessons_details_reshedule_activeTab === 'weekly'){
      week.days.forEach((d,i)=>{
        const [abbr] = d.split(' ');
        const full = abbrToFull[abbr] || abbr;
        const isSun = i===0;
        $row.append(`
          <div class="flex justify-center">
            <div class="${isSun?'bg-red-50 text-red-600 font-semibold':'text-gray-900 font-medium'} px-3 py-2 rounded-xl">${full}</div>
          </div>
        `);
      });
    }else{
      week.days.forEach((d,i)=>{
        const isSun = i===0;
        $row.append(`
          <div class="flex justify-center">
            <div class="${isSun?'bg-red-50 text-red-600 font-semibold':'text-gray-900 font-medium'} px-3 py-2 rounded-xl">${d}</div>
          </div>
        `);
      });
    }
  }

  function renderGrid(){
    const st = getActiveState();
    const week = weeks[st.weekIndex];

    $("#my_lessons_details_reshedule_weekLabel").text(week.label);
    renderDays(week);

    const times = allTimesSorted(week);
    const $grid = $("#my_lessons_details_reshedule_grid").empty();

    times.forEach(time=>{
      week.days.forEach(day=>{
        const key=`${time}@${day}`;
        if(week.slots[day]?.includes(time)){
          const isDisabled = week.disabled.has(key);
          const isRed = week.redBorder.has(key);
          const isSelected = st.selectedKeys.has(key);
          const classes = `my_lessons_details_reshedule_slot ${isDisabled?'my_lessons_details_reshedule_disabled':''} ${isSelected?'my_lessons_details_reshedule_selected':''} ${isRed?'my_lessons_details_reshedule_redborder':''}`;
          $grid.append(`
            <div><div class="my_lessons_details_reshedule_cell">
              <div class="${classes}" data-key="${key}" data-time="${time}" data-day="${day}">${time}</div>
            </div></div>
          `);
        }else{
          $grid.append(`<div><div class="my_lessons_details_reshedule_cell"><div class="h-14 w-[168px] max-w-[90vw]"></div></div></div>`);
        }
      });
    });
  }

  function renderAll(){
    updateHeaderByTab();
    renderGrid();
    renderRightPanel();
  }

  /* ====================== EVENTS ====================== */
  function setActiveTab(tab){
    my_lessons_details_reshedule_activeTab = tab;
    $('.my_lessons_details_reshedule_tab_btn').attr('data-active', 'false');
    if(tab === 'weekly') $tabWeekly.attr('data-active', 'true');
    if(tab === 'single') $tabSingle.attr('data-active', 'true');
    renderAll();
  }
  $tabWeekly.on('click', () => setActiveTab('weekly'));
  $tabSingle.on('click', () => setActiveTab('single'));

  // Add/Remove selection
  function addSelection(day, time){
    const st = getActiveState();
    const key = `${time}@${day}`;
    if(st.selectedKeys.has(key)) return;               // already added
    if(st.selections.length >= MAX_SLOTS) return;      // limit 3

    st.selectedKeys.add(key);
    st.selections.push({ key, day, time });
  }
  function removeSelection(key){
    const st = getActiveState();
    st.selectedKeys.delete(key);
    const idx = st.selections.findIndex(s => s.key === key);
    if(idx > -1) st.selections.splice(idx, 1);
  }

  // slot click
  $(document).on("click",".my_lessons_details_reshedule_slot",function(){
    const st = getActiveState();
    const $el=$(this);
    const day=$el.data("day");
    const time=$el.data("time");
    const key=`${time}@${day}`;
    const week = weeks[st.weekIndex];

    if(week.disabled.has(key)){
      clearTip();
      const r = $el[0].getBoundingClientRect();
      window.__my_tip = $(`<div class="my_lessons_details_reshedule_tip">Your Lesson With Daniela <span class="my_lessons_details_reshedule_tip_sub">7:00 – 7:25 PM</span></div>`).appendTo(document.body);
      const t = window.__my_tip[0].getBoundingClientRect();
      const top = r.top - t.height - 10;
      const left = Math.max(8, Math.min(r.left + (r.width - t.width)/2, window.innerWidth - t.width - 8));
      window.__my_tip.css({top:`${Math.max(8,top)}px`, left:`${left}px`});
      return;
    }

    clearTip();

    // Toggle: if selected, remove; else add (up to 3)
    if(st.selectedKeys.has(key)){
      removeSelection(key);
    }else{
      addSelection(day, time);
    }

    renderAll();
  });

  // remove via X in right list
  $(document).on("click", ".rp-remove", function(){
    const key = $(this).data('key');
    removeSelection(key);
    renderAll();
  });

  // prev/next (affect current tab only)
  $("#my_lessons_details_reshedule_prev").on("click",function(){
    const st = getActiveState();
    st.weekIndex = (st.weekIndex - 1 + weeks.length) % weeks.length;
    clearTip();
    renderAll();
  });
  $("#my_lessons_details_reshedule_next").on("click",function(){
    const st = getActiveState();
    st.weekIndex = (st.weekIndex + 1) % weeks.length;
    clearTip();
    renderAll();
  });

  // close panel
  $("#my_lessons_details_reshedule_close").on("click",()=> window.history.length>1 ? window.history.back() : window.close());

  // dropdown
  function openMenu(){ $("#my_lessons_details_reshedule_duration_menu").removeClass("hidden"); $("#my_lessons_details_reshedule_duration_toggle").attr("aria-expanded","true"); }
  function closeMenu(){ $("#my_lessons_details_reshedule_duration_menu").addClass("hidden"); $("#my_lessons_details_reshedule_duration_toggle").attr("aria-expanded","false"); }
  $("#my_lessons_details_reshedule_duration_toggle").on("click",function(e){
    e.stopPropagation(); const menu=$("#my_lessons_details_reshedule_duration_menu"); menu.hasClass("hidden")?openMenu():closeMenu();
  });
  $(document).on("click",".my_lessons_details_reshedule_duration_item",function(e){
    e.stopPropagation();
    const value=$(this).data("value");
    $("#my_lessons_details_reshedule_duration_label").text(value.replace(" minutes"," min").replace("hour, ","hr, ")+" lessons");
    $(".my_lessons_details_reshedule_duration_item").each(function(){
      const isSel = $(this).data("value")===value;
      $(this).find(".my_lessons_details_reshedule_check").toggleClass("hidden", !isSel);
    });
    closeMenu();
  });

  // cleanup
  $(document).on("click", e=>{
    if(!$(e.target).closest(".my_lessons_details_reshedule_slot,.my_lessons_details_reshedule_tip,#my_lessons_details_reshedule_duration_wrap").length){
      clearTip(); closeMenu();
    }
  });
  $("#my_lessons_details_reshedule_leftpane").on("scroll", ()=>{ clearTip(); closeMenu(); });
  $(window).on("resize", ()=>{ clearTip(); closeMenu(); });
  $(document).on("keydown", e=>{ if(e.key==="Escape"){ clearTip(); closeMenu(); } });

  // init: Weekly selected by default
  setActiveTab('weekly');










  // === Open the full-screen "Weekly Schedule" modal when CTA is clicked ===
// (Attach inside the scheduler IIFE so we can read state, weeks, activeTab)
$("#my_lessons_details_reshedule_cta")
  .off("click.weeklyModal")
  .on("click.weeklyModal", function () {
    // ignore if CTA is disabled
    if ($(this).prop("disabled")) return;

    // open only for WEEKLY flow
    if (my_lessons_details_reshedule_activeTab !== "weekly") return;

    // need at least one selected slot
    const st = state.weekly;
    if (!st || !st.selections || st.selections.length === 0) return;

    const sel = st.selections[0];                 // first chosen selection
    const week = weeks[st.weekIndex];
    if (!week) return;

    // parse duration from the visible dropdown label (defaults to 50)
    const raw = $("#my_lessons_details_reshedule_duration_label").text() || "50 min lessons";
    let minutes = 50;
    if (/25/.test(raw)) minutes = 25;
    else if (/1\.?5/.test(raw)) minutes = 90;
    else if (/1\s*Hour/.test(raw)) minutes = 60;

    // make sure the modal open function exists
    if (typeof window.my_lessons_details_calendar_content_weekly_schedule_lesson_open === "function") {
      window.my_lessons_details_calendar_content_weekly_schedule_lesson_open({
        tutorName: "Daniela",
        tutorAvatar: "https://images.unsplash.com/photo-1517841905240-472988babdf9?q=80&w=400&auto=format&fit=crop",
        weekLabel: week.label,   // e.g. "Feb 23 – Mar 1, 2025"
        dayKey: sel.day,         // e.g. "Sun 23"
        time: sel.time,          // e.g. "05:00"
        durationMinutes: minutes // 25 / 50 / 60 / 90 parsed above
      });
    } else {
      console.warn("Weekly schedule modal not found. Did you include my_lessons_details_calendar_content_weekly_schedule_lesson.php?");
    }
  });

})(jQuery);












</script>


