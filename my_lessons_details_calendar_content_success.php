<!-- ===== Success Modal: We've rescheduled your lesson ===== -->
<!-- Tailwind utilities assumed to be loaded on the page -->

<style>
  /* Minimal custom vars just for color + soft shadow */
  .my_lessons_details_reshedule_succes_backdrop { background:#ffd6cc; } /* soft peach */
  .my_lessons_details_reshedule_succes_shadow { box-shadow:0 12px 36px rgba(0,0,0,.16); }
</style>

<div id="my_lessons_details_reshedule_succes_overlay"
     class="fixed inset-0 z-[1200] hidden">
  <!-- Backdrop -->
  <div class="absolute inset-0 my_lessons_details_reshedule_succes_backdrop"></div>

  <!-- Modal content (centered) -->
  <div class="relative h-full w-full flex items-center justify-center p-4">
    <!-- Close (X) -->
    <button id="my_lessons_details_reshedule_succes_close"
            class="absolute top-6 right-6 text-2xl leading-none text-black/80 hover:text-black"
            aria-label="Close">×</button>

    <!-- Panel -->
    <div id="my_lessons_details_reshedule_succes_panel"
         class="w-full max-w-[720px] text-center">
      <!-- Tutor avatar -->
      <img src="https://i.pravatar.cc/96?img=12" alt="Tutor"
           class="mx-auto h-14 w-14 rounded-lg ring-2 ring-white my_lessons_details_reshedule_succes_shadow" />

      <!-- Title -->
      <h1 class="mt-4 font-extrabold text-[#0f1115] text-center
                 text-[clamp(26px,5vw,46px)] leading-snug">
        We’ve rescheduled<br class="hidden md:block"> your lesson.
      </h1>

      <!-- Lesson meta -->
      <div class="mt-4">
        <p class="font-semibold text-[#0f1115]">English With Daniela</p>
        <p class="text-sm md:text-base text-[#4b515b]">Thu, 5 Feb, 5:00–05:50</p>
      </div>

      <!-- Continue button -->
      <button id="my_lessons_details_reshedule_succes_continue"
              class="mt-8 mx-auto inline-flex w-full md:w-[420px] justify-center items-center
                     h-12 rounded-xl bg-black text-white font-semibold
                     hover:opacity-90 transition my_lessons_details_reshedule_succes_shadow">
        Continue
      </button>
    </div>
  </div>
</div>

<script>
  // ===== jQuery wiring (prefix everywhere) =====
  $(function () {
    // Elements
    const $my_lessons_details_reshedule_succes_overlay  = $('#my_lessons_details_reshedule_succes_overlay');
    const $my_lessons_details_reshedule_succes_panel    = $('#my_lessons_details_reshedule_succes_panel');
    const $my_lessons_details_reshedule_succes_close    = $('#my_lessons_details_reshedule_succes_close');
    const $my_lessons_details_reshedule_succes_continue = $('#my_lessons_details_reshedule_succes_continue');
    const $my_lessons_details_reshedule_succes_backdrop = $('.my_lessons_details_reshedule_succes_backdrop');

    // Trigger: your existing confirm button in the first modal (bind only if present)
    const $firstModalConfirm = $('#my_lessons_reschedule_details_lesson_modal_content_confirm');

    // Open function (prefixed)
    function my_lessons_details_reshedule_succes_open() {
      $my_lessons_details_reshedule_succes_overlay.removeClass('hidden');
      $my_lessons_details_reshedule_succes_panel
        .css({ opacity: 0, transform: 'translateY(16px)' })
        .animate({ opacity: 1 }, 180, function () {
          $(this).css('transform', 'translateY(0)');
        });
    }

    // Redirect function (prefixed)
    function my_lessons_details_reshedule_succes_redirect() {
      window.location.href = 'my_lessons.php';
    }

    // Expose open() globally in case you need to trigger it elsewhere
    window.my_lessons_details_reshedule_succes_open = my_lessons_details_reshedule_succes_open;

    // Hook confirm from the first modal (only if it exists and is enabled)
    if ($firstModalConfirm.length) {
      $firstModalConfirm.on('click', function (e) {
        if ($(this).prop('disabled')) return;
        e.preventDefault();
        my_lessons_details_reshedule_succes_open();
      });
    }

    // Clicks for Close and Continue (redirect)
    $my_lessons_details_reshedule_succes_close.on('click', my_lessons_details_reshedule_succes_redirect);
    $my_lessons_details_reshedule_succes_continue.on('click', my_lessons_details_reshedule_succes_redirect);

    // Backdrop click should also redirect
    $my_lessons_details_reshedule_succes_backdrop.on('click', my_lessons_details_reshedule_succes_redirect);

    // ESC key to redirect when modal is open
    $(document).on('keydown', function (e) {
      if (e.key === 'Escape' && !$my_lessons_details_reshedule_succes_overlay.hasClass('hidden')) {
        my_lessons_details_reshedule_succes_redirect();
      }
    });
  });
</script>
<!-- ===== /Success Modal ===== -->
