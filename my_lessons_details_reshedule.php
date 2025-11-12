 <link rel="stylesheet" href="css/my_lessons_details_reshedule.css"/>
<?php
require_once("../../config.php");
echo $OUTPUT->header();
?>
<script src="https://cdn.tailwindcss.com"></script>
<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>

<div class="max-w-[1600px] mx-auto py-6 h-screen overflow-hidden">
  <div class="grid grid-cols-1 lg:grid-cols-12 h-full gap-6">

    <!-- LEFT -->
    <div class="lg:col-span-8 overflow-y-auto pr-3 my_lessons_details_reshedule_scrollbarNone" id="my_lessons_details_reshedule_leftpane" style="margin-top:20px; margin-left:10%;">

      <!-- 🔒 FROZEN HEADER: heading + pager + timezone + days -->
      <div class="sticky top-0 z-20 bg-white">
        <!-- heading + pager -->
        <div class="flex items-center justify-between pt-1">
          <h1 id="my_lessons_details_reshedule_weekLabel" class="text-3xl font-extrabold tracking-tight" style="font-size: 20px;font-weight: 500;">Feb 1 – 7, 2025</h1>
          <!-- Prev / Next (snapshot style) -->
          <div
            id="my_lessons_details_reshedule_pager"
            class="inline-flex items-stretch rounded-[6px] overflow-hidden border border-[#E6E7EF] shadow-[0_1px_0_rgba(16,18,27,0.04)] bg-white"
            aria-label="Change week"
          >
            <button id="my_lessons_details_reshedule_prev"
              class="w-12 h-9 grid place-items-center hover:bg-gray-50 focus:outline-none"
              aria-label="Previous week">
                  <!-- Left chevron (inline) -->
                  <svg viewBox="0 0 16 16" class="mylessons-pager-ico" fill="#121117" aria-hidden="true">
                    <path fill-rule="evenodd" clip-rule="evenodd"
                          d="M10.5 13L6 8l4.5-5 1.1 1.05L8.2 8l3.4 3.95L10.5 13z"/>
                  </svg>
            </button>
            <div class="w-px bg-[#E6E7EF]"></div>
            <button id="my_lessons_details_reshedule_next"
              class="w-12 h-9 grid place-items-center hover:bg-gray-50 focus:outline-none"
              aria-label="Next week">

                <!-- Right chevron (inline) -->
                <svg viewBox="0 0 16 16" class="mylessons-pager-ico" fill="#121117" aria-hidden="true">
                  <path fill-rule="evenodd" clip-rule="evenodd"
                        d="M5.5 3L10 8l-4.5 5-1.1-1.05L7.8 8 4.4 4.05 5.5 3z"/>
                </svg>
           
            </button>
          </div>
        </div>

        <!-- days row (aligned with grid) -->
        <div id="my_lessons_details_reshedule_days" class="grid grid-cols-7 gap-x-4 pb-2 border-b border-gray-200" style="margin-top:2%;">
        </div>

      </div>

          <!-- ✅ Non-sticky timezone bar (new position) -->
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
          <!-- Close: plain X like snapshot -->
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

                        <button class="my_lessons_details_reshedule_duration_item mylessons-row w-full text-left px-3 py-2 hover:bg-gray-100"
                                data-value="25 minutes" role="menuitem">
                          <div class="flex items-center justify-between gap-3">
                            <span>25 Minutes</span>
                            <span class="my_lessons_details_reshedule_check hidden">✓</span>
                          </div>
                        </button>

                        <div class="mx-3 my-1 h-px bg-gray-200"></div>

                        <button class="my_lessons_details_reshedule_duration_item mylessons-row w-full text-left px-3 py-2 hover:bg-gray-100"
                                data-value="50 minutes" data-selected="true" role="menuitem">
                          <div class="flex items-center justify-between gap-3">
                            <span>50 Minutes</span>
                            <span class="my_lessons_details_reshedule_check">✓</span>
                          </div>
                        </button>

                        <div class="mx-3 my-1 h-px bg-gray-200"></div>

                        <button class="my_lessons_details_reshedule_duration_item mylessons-row w-full text-left px-3 py-2 hover:bg-gray-100"
                                data-value="1 hour, 20 minutes" role="menuitem">
                          <div class="flex items-center justify-between gap-3">
                            <span>1 Hour</span>
                            <span class="my_lessons_details_reshedule_check hidden">✓</span>
                          </div>
                        </button>

                        <div class="mx-3 my-1 h-px bg-gray-200"></div>

                        <button class="my_lessons_details_reshedule_duration_item mylessons-row w-full text-left px-3 py-2 hover:bg-gray-100"
                                data-value="1 hour, 50 minutes" role="menuitem">
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

            <div class="mt-4 text-base font-semibold">Current lesson time</div>
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
                    class="w-full rounded-md  h-12 mt-4 font-semibold border border-gray-300 bg-gray-200 text-gray-500 cursor-not-allowed" style="border: 2px solid black !important;">
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
