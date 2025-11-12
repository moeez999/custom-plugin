<!-- Tailwind CDN + jQuery -->
<script src="https://cdn.tailwindcss.com"></script>
<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>

<link rel="stylesheet" href="css/my_lessons_details_calendar_content.css">

<div class="w-full max-w-[1400px] mx-auto px-3 sm:px-4">
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
        <span class="legend_item"><img src="img/confirm_by_std.svg" alt="Confirmed" /> Confirmed by the student</span>
        <span class="legend_item"><img src="img/weekly_class.svg" alt="Weekly" /> Weekly Class</span>
        <span class="legend_item"><img src="img/single_class.svg" alt="Single" /> Single class</span>
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

  <!-- Price tooltip -->
  <div id="eventTooltip" class="event-tooltip arrow-left">
    <span class="inline-flex items-center rounded-md bg-green-100 text-green-700 text-[13px] px-2 py-1">Paid $5.40</span>
    <span class="inline-flex items-center gap-1 text-[14px] text-gray-800 font-semibold">
      <span aria-hidden="true">⭐</span><span>4</span>
    </span>
  </div>






<!-- Context menu -->
<style>
  /* keep menu-item links always black */
  .event-menu .menu-item {
    color: #000 !important;
    text-decoration: none !important;
    display: flex;
    align-items: center;
    gap: 6px;
  }

  .event-menu .menu-item:hover {
    color: #000 !important;   /* force black on hover */
    background: #f5f5f5;      /* optional: light hover background */
  }
</style>

<div id="eventMenu" class="event-menu arrow-left" role="menu" aria-hidden="true">
  <a href="my_lessons_details_reshedule.php" class="menu-item" role="menuitem">
    <img class="menu-icon-img" src="img/reshedule.svg" alt="Reschedule" />
    Reschedule
  </a>
  <div class="menu-item" role="menuitem"  id="my_lessons_details_calendar_content_message_tutor_btn">
    <img class="menu-icon-img" src="img/message_tutor.svg" alt="Message Tutor" />
    Message Tutor
  </div>

    <!-- <div class="menu-item" role="menuitem"> -->
      <a href="my_lessons_tutor_profile.php" class="menu-item" role="menuitem">
      <img class="menu-icon-img" src="img/see_tutor_profile.svg" alt="See Tutor Profile" />
        See Tutor Profile
      </a>
    <!-- </div> -->

  <div class="menu-sep"></div>
  <div class="menu-item my_lessons_cancel my_lesson_details_cancel__open" role="menuitem">
    <img class="menu-icon-img" src="img/cancel.svg" alt="Cancel" />
    Cancel
  </div>
</div>

<?php require_once('my_lessons_details_calendar_content_message_tutor.php');?>

  <!-- Which Tutor? Modal -->
  <div id="my_lessons_details_calendar_content_tutor_modal_root" class="hidden">
    <div id="my_lessons_details_calendar_content_tutor_modal_overlay"
         class="fixed inset-0 bg-black/40 backdrop-blur-[2px] z-[5000]"></div>

    <div id="my_lessons_details_calendar_content_tutor_modal_portal"
         class="fixed inset-0 z-[5001] grid place-items-center p-4">
      <div class="relative bg-white w-full max-w-[480px] rounded-2xl shadow-2xl ring-1 ring-black/5">
        <button id="my_lessons_details_calendar_content_tutor_btn_close"
                type="button"
                class="absolute top-4 right-4 inline-flex items-center justify-center w-9 h-9 rounded-full hover:bg-gray-100"
                aria-label="Close">
          <svg viewBox="0 0 24 24" class="w-5 h-5 text-gray-700" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
            <path d="M18 6 6 18M6 6l12 12"/>
          </svg>
        </button>

        <div class="px-6 pt-8 pb-3">
          <h3 class="text-center text-[28px] md:text-[25px] font-bold tracking-tight text-gray-900">
            Which tutor?
          </h3>
        </div>

        <!-- Scroll wrapper with hidden scrollbars -->
        <div id="my_lessons_details_calendar_content_tutor_scrollwrap"
             class="px-2 pb-4 max-h-[70vh] overflow-y-auto">
          <ul id="my_lessons_details_calendar_content_tutor_list" class="divide-y divide-gray-100">
            <!-- rows injected by JS -->
          </ul>
        </div>
      </div>
    </div>
  </div>

  <script src="js/my_lessons_details_calendar_content.js"></script>
