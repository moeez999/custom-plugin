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


<div class="max-w-[1600px] mx-auto py-6 h-screen overflow-hidden">
  <div class="grid grid-cols-1 lg:grid-cols-12 h-full gap-6">

    <!-- LEFT -->
    <div class="lg:col-span-8 overflow-y-auto pr-3 my_lessons_details_reshedule_scrollbarNone" id="my_lessons_details_reshedule_leftpane" style="margin-top:20px; margin-left:10%;">

      <!-- 🔒 FROZEN HEADER: heading + pager + tabs + timezone + days -->
      <div class="sticky top-0 z-20 bg-white">
        <!-- heading + pager -->
        <div class="flex items-center justify-between pt-1">
          <h1 id="my_lessons_details_reshedule_weekLabel" class="text-3xl font-extrabold tracking-tight" style="font-size: 20px;font-weight: 500;">Feb 1 – 7, 2025</h1>
          <!-- Prev / Next -->
          <div
            id="my_lessons_details_reshedule_pager"
            class="inline-flex items-stretch rounded-[6px] overflow-hidden border border-[#E6E7EF] shadow-[0_1px_0_rgba(16,18,27,0.04)] bg-white"
            aria-label="Change week"
          >
            <button id="my_lessons_details_reshedule_prev"
              class="w-12 h-9 grid place-items-center hover:bg-gray-50 focus:outline-none"
              aria-label="Previous week">
              <svg viewBox="0 0 16 16" class="mylessons-pager-ico" fill="#121117" aria-hidden="true">
                <path fill-rule="evenodd" clip-rule="evenodd"
                      d="M10.5 13L6 8l4.5-5 1.1 1.05L8.2 8l3.4 3.95L10.5 13z"/>
              </svg>
            </button>
            <div class="w-px bg-[#E6E7EF]"></div>
            <button id="my_lessons_details_reshedule_next"
              class="w-12 h-9 grid place-items-center hover:bg-gray-50 focus:outline-none"
              aria-label="Next week">
              <svg viewBox="0 0 16 16" class="mylessons-pager-ico" fill="#121117" aria-hidden="true">
                <path fill-rule="evenodd" clip-rule="evenodd"
                      d="M5.5 3L10 8l-4.5 5-1.1-1.05L7.8 8 4.4 4.05 5.5 3z"/>
              </svg>
            </button>
          </div>
        </div>

        <!-- === NEW: TOP TABS (Weekly | Single) === -->
        <div id="my_lessons_details_reshedule_tabs" class="mt-3">
          <div class="grid grid-cols-2 gap-3">
            <!-- Weekly -->
            <button
              id="my_lessons_details_reshedule_tab_weekly"
              type="button"
              data-tab="weekly"
              class="my_lessons_details_reshedule_tab_btn group flex items-center gap-3 w-full rounded-2xl border border-gray-200 bg-white px-4 py-3 shadow-[0_1px_0_rgba(16,18,27,0.04)] ring-0">
              <span class="inline-flex h-9 w-9 shrink-0 items-center justify-center rounded-xl border border-gray-200">
                <svg viewBox="0 0 24 24" class="h-5 w-5" fill="none" stroke="currentColor" stroke-width="1.6">
                  <rect x="3.5" y="4.5" width="17" height="15" rx="2.5"></rect>
                  <path d="M16 2.5v4M8 2.5v4M3.5 9.5h17"></path>
                  <path d="M9 13l2 2 4-4"></path>
                </svg>
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
              class="my_lessons_details_reshedule_tab_btn group flex items-center gap-3 w-full rounded-2xl border border-gray-200 bg-white px-4 py-3 shadow-[0_1px_0_rgba(16,18,27,0.04)] ring-0">
              <span class="inline-flex h-9 w-9 shrink-0 items-center justify-center rounded-xl border border-gray-200">
                <svg viewBox="0 0 24 24" class="h-5 w-5" fill="none" stroke="currentColor" stroke-width="1.6">
                  <rect x="3.5" y="4.5" width="17" height="15" rx="2.5"></rect>
                  <path d="M16 2.5v4M8 2.5v4M3.5 9.5h17"></path>
                  <circle cx="12" cy="14" r="2.6"></circle>
                </svg>
              </span>
              <span class="text-left">
                <span class="block text-[16px] leading-5 font-semibold">Single lessons</span>
                <span class="block text-[13px] leading-5 text-gray-500">Choose different times for each lesson</span>
              </span>
            </button>
          </div>
        </div>
        <!-- /tabs -->

        <!-- days row (aligned with grid) -->
        <div id="my_lessons_details_reshedule_days" class="grid grid-cols-7 gap-x-4 pb-2 border-b border-gray-200" style="margin-top:2%;"></div>
      </div>

      <!-- ✅ Non-sticky timezone bar (unchanged) -->
      <div id="my_lessons_details_reshedule_tzbar"
           class="mt-2 mb-2 text-[14px] leading-[20px] text-[#6b7280] font-medium">
        In your time zone:
        <span id="my_lessons_details_reshedule_tzText" class="font-medium">
          America/New_York (GMT -5:00)
        </span>
      </div>

      <!-- time grid -->
      <div id="my_lessons_details_reshedule_grid" class="mt-2 grid grid-cols-7 gap-x-4 gap-y-2"></div>
      <div class="py-6"></div>
    </div>

    <!-- RIGHT -->
    <div class="lg:col-span-3">
      <div class="sticky top-6">
        <div class="relative">
          <!-- Close: plain X -->
          <button id="my_lessons_details_reshedule_close" style="margin-right:-35px;font-size:30px;top:10px;"
                  class="absolute -top-2 -right-2 w-6 h-6 flex items-center justify-center text-[18px] leading-none text-gray-700 hover:text-black"
                  aria-label="Close">×</button>

          <div class="border border-gray-200 rounded-md bg-white shadow-[0_10px_28px_rgba(16,18,27,0.06)] p-5 max-w-md ml-auto">
            <!-- Tutor + Duration dropdown -->
            <div class="flex items-start gap-4">
              <img class="w-12 h-12 rounded-xl object-cover"
                   src="https://images.unsplash.com/photo-1517841905240-472988babdf9?q=80&w=400&auto=format&fit=crop" alt="">
              <div class="flex-1">
                <div class="text-lg font-semibold">English with Daniela</div>

                <!-- Duration dropdown trigger + menu -->
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

                  <!-- Menu -->
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

            <!-- NEW: live counter like snapshot -->
            <div id="my_lessons_details_reshedule_lessons_counter"
                 class="mt-4 mb-2 text-[14px] font-medium text-gray-800 hidden">0 lessons to schedule</div>

            <div class="mt-2 text-base font-semibold">Current lesson time</div>
            <div id="my_lessons_details_reshedule_currentTime" class="text-gray-500 mt-1 mb-3 text-[15px]">
              Mon, Feb 2, 07:30 – 08:20
            </div>

            <div class="text-base font-semibold">New lesson time</div>
            <div id="my_lessons_details_reshedule_chipfield" class="flex flex-col gap-2 mt-1">
              <div id="my_lessons_details_reshedule_placeholder"
                   class="h-12 flex items-center px-4 border border-gray-300 rounded-xl text-gray-400 font-medium">
                Lesson
              </div>
            </div>

            <button id="my_lessons_details_reshedule_cta" disabled
                    class="w-full rounded-md h-12 mt-4 font-semibold border border-gray-300 bg-gray-200 text-gray-500 cursor-not-allowed" style="border: 2px solid black !important;">
              Reschedule
            </button>
            <p class="text-black-500 text-center mt-3 text-sm leading-4" style="font-size:12px;">
              Cancel or reschedule for free up to 12 hrs<br>before the lesson starts.
            </p>
          </div>
        </div>
      </div>
    </div>

  </div>
</div>

<?php require_once('my_lessons_details_reshedule_modal_content.php');?>

<?php require_once('my_lessons_details_calendar_content_success.php'); ?>

<?php
echo $OUTPUT->footer();
?>
<script src="js/my_lessons_details_reshedule.js"></script>

<!-- === ADDITIVE JS: tabs + chip behavior and a generic slot click hook === -->
<script>
(function($){
  // ---- State
  let my_lessons_details_reshedule_activeTab = 'weekly';  // 'weekly' | 'single'
  const selectedSlots = []; // {id, dayLabel, start, end}

  // ---- Elements
  const $tabWeekly = $('#my_lessons_details_reshedule_tab_weekly');
  const $tabSingle = $('#my_lessons_details_reshedule_tab_single');

  const $chipField = $('#my_lessons_details_reshedule_chipfield');
  const $placeholder = $('#my_lessons_details_reshedule_placeholder');
  const $cta = $('#my_lessons_details_reshedule_cta');
  const $counter = $('#my_lessons_details_reshedule_lessons_counter');

  // TABS
  function setActiveTab(tab){
    my_lessons_details_reshedule_activeTab = tab;
    $('.my_lessons_details_reshedule_tab_btn').attr('data-active', 'false');
    if(tab === 'weekly') $tabWeekly.attr('data-active', 'true');
    if(tab === 'single') $tabSingle.attr('data-active', 'true');
  }
  $tabWeekly.on('click', () => setActiveTab('weekly'));
  $tabSingle.on('click', () => setActiveTab('single'));
  setActiveTab('weekly'); // default like snapshot

  // RIGHT PANEL HELPERS
  function refreshCounter(){
    if(selectedSlots.length === 0){
      $counter.addClass('hidden');
      return;
    }
    $counter.removeClass('hidden');
    const n = selectedSlots.length;
    $counter.text(`${n} lesson${n>1?'s':''} to schedule`);
  }
  function enableCTA(enabled){
    if(enabled){
      $cta.prop('disabled', false)
          .removeClass('bg-gray-200 text-gray-500 cursor-not-allowed')
          .addClass('bg-[#fe2e0c] text-white hover:opacity-95'); // snapshot-style orange
    }else{
      $cta.prop('disabled', true)
          .removeClass('bg-[#fe2e0c] text-white hover:opacity-95')
          .addClass('bg-gray-200 text-gray-500 cursor-not-allowed');
    }
  }

  function renderPlaceholder(){
    if(selectedSlots.length === 0) $placeholder.removeClass('hidden');
    else $placeholder.addClass('hidden');
  }

  function chipHtml(slot){
    return `
      <div class="my_lessons_details_reshedule_chip flex items-center justify-between gap-3 rounded-xl border border-gray-300 px-4 py-3">
        <div>
          <div class="text-[15px] font-semibold">${slot.dayLabel}, ${slot.start} – ${slot.end}</div>
          <div class="text-[13px] text-gray-500 mt-0.5">
            ${my_lessons_details_reshedule_activeTab === 'weekly' ? 'Every ' + slot.dayLabel : 'Single lesson'}
          </div>
        </div>
        <button type="button" class="my_lessons_details_reshedule_chip_remove text-gray-500 hover:text-black" data-id="${slot.id}" aria-label="Remove">×</button>
      </div>`;
  }
  function rerenderChips(){
    $chipField.find('.my_lessons_details_reshedule_chip').remove();
    selectedSlots.forEach(s => $chipField.append(chipHtml(s)));
    renderPlaceholder();
    refreshCounter();
    enableCTA(selectedSlots.length > 0);
  }

  // Public helper you can call from anywhere (keeps your existing grid code intact)
  window.my_lessons_details_reshedule_addSelection = function(dayLabel, start, end){
    // normalize day to short label if needed
    const map = {Monday:'Mon', Tuesday:'Tue', Wednesday:'Wed', Thursday:'Thu', Friday:'Fri', Saturday:'Sat', Sunday:'Sun'};
    const label = map[dayLabel] || dayLabel;
    const id = `${label}-${start}-${end}-${Date.now()}`;
    selectedSlots.push({id, dayLabel: label, start, end});
    rerenderChips();
  };

  // Remove chip
  $chipField.on('click', '.my_lessons_details_reshedule_chip_remove', function(){
    const id = $(this).data('id');
    const idx = selectedSlots.findIndex(s => s.id === id);
    if(idx > -1){
      selectedSlots.splice(idx, 1);
      rerenderChips();
    }
  });

  // === Generic hook: if your time slots have this class + data-attrs, they auto-add ===
  // Example for each slot element:
  // <button class="my_lessons_details_reshedule_slotBtn" data-day="Sunday" data-start="05:00" data-end="05:50">05:00</button>
  $(document).on('click', '.my_lessons_details_reshedule_slotBtn', function(){
    const day = $(this).data('day');     // e.g. "Sunday" or "Sun"
    const start = $(this).data('start'); // "05:00"
    const end = $(this).data('end');     // "05:50"
    if(!day || !start || !end) return;
    window.my_lessons_details_reshedule_addSelection(day, start, end);
  });

})(jQuery);
</script>
