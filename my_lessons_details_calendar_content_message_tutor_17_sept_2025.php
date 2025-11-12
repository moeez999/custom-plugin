<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8"/>
<meta name="viewport" content="width=device-width, initial-scale=1"/>
<title>Message Tutor Panel</title>

<script src="https://cdn.tailwindcss.com"></script>
<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>

<style>
  /* --- Visuals --- */
  .my_lessons_details_calendar_content_message_tutor_shadow{ box-shadow:0 24px 60px rgba(0,0,0,.22); }
  .my_lessons_details_calendar_content_message_tutor_scroll{ -ms-overflow-style:none; scrollbar-width:none; }
  .my_lessons_details_calendar_content_message_tutor_scroll::-webkit-scrollbar{ width:0; height:0; }
  .my_lessons_details_calendar_content_message_tutor_bubble{ transition:background-color .15s ease, box-shadow .15s ease; }
  .my_lessons_details_calendar_content_message_tutor_bubble:hover{ background:#ececf3; box-shadow:0 4px 16px rgba(0,0,0,.08); }
  .my_lessons_details_calendar_content_message_tutor_input:focus{ outline:none; }

  /* --- CRITICAL FIX: kill any global counters/pseudo content inside this panel --- */
  #my_lessons_details_calendar_content_message_tutor_panel,
  #my_lessons_details_calendar_content_message_tutor_panel *{
    list-style: none !important;
    counter-reset: none !important;
    counter-increment: none !important;
  }
  #my_lessons_details_calendar_content_message_tutor_panel::before,
  #my_lessons_details_calendar_content_message_tutor_panel::after,
  #my_lessons_details_calendar_content_message_tutor_panel *::before,
  #my_lessons_details_calendar_content_message_tutor_panel *::after{
    content: none !important;   /* nukes injected “100” from ::before/::after anywhere in panel */
  }

</style>
</head>

<body class="bg-gray-50 min-h-screen flex items-center justify-center p-6">

<!-- Panel -->
  <div id="my_lessons_details_calendar_content_message_tutor_panel"
       class="fixed bottom-6 right-6 z-[2147483647] hidden
              w-[520px] max-w-[95vw] bg-white border border-gray-200 rounded-2xl
              my_lessons_details_calendar_content_message_tutor_shadow
              flex flex-col overflow-hidden">

    <!-- Header -->
    <div class="px-5 pt-4">
      <div class="flex items-center justify-between">
        <div class="flex items-center gap-3">
          <button type="button" id="my_lessons_details_calendar_content_message_tutor_back"
                  class="w-9 h-9 rounded-full hover:bg-gray-100 flex items-center justify-center"
                  aria-label="Back">
            <svg class="w-5 h-5" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                 stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
              <polyline points="15 18 9 12 15 6"></polyline>
            </svg>
          </button>
          <img src="https://i.pravatar.cc/80?img=5" alt="Daniela" class="w-9 h-9 rounded-full object-cover"/>
          <a href="#" class="text-[17px] font-semibold text-gray-900 underline">Daniela</a>
        </div>

        <div class="flex items-center gap-2">
          <button type="button"
                  class="w-9 h-9 rounded-full hover:bg-gray-100 flex items-center justify-center"
                  aria-label="Docs">
            <svg class="w-5 h-5" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                 stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
              <rect x="3" y="3" width="18" height="18" rx="2"></rect>
              <line x1="9" y1="3" x2="9" y2="21"></line>
            </svg>
          </button>
          <button type="button" id="my_lessons_details_calendar_content_message_tutor_close"
                  class="w-9 h-9 rounded-full hover:bg-gray-100 flex items-center justify-center"
                  aria-label="Close">
            <svg class="w-5 h-5" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                 stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
              <line x1="18" y1="6" x2="6" y2="18"></line>
              <line x1="6" y1="6" x2="18" y2="18"></line>
            </svg>
          </button>
        </div>
      </div>

      <!-- Centered “Schedule Lessons” -->
      <div class="mt-3 flex justify-center">
        <a href="#"
           class="inline-flex items-center gap-2 text-[15px] font-semibold text-gray-800 hover:text-black">
          <svg class="w-5 h-5" viewBox="0 0 24 24" fill="none" stroke="currentColor"
               stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
            <rect x="3" y="4" width="18" height="18" rx="2"></rect>
            <line x1="16" y1="2" x2="16" y2="6"></line>
            <line x1="8" y1="2" x2="8" y2="6"></line>
            <line x1="3" y1="10" x2="21" y2="10"></line>
          </svg>
          <span>Schedule Lessons</span>
        </a>
      </div>
    </div>

    <div class="mt-3 h-[1px] bg-gray-100"></div>

    <!-- Today pill -->
    <div class="px-5 py-3">
      <div id="my_lessons_details_calendar_content_message_tutor_today"
           class="mx-auto w-fit bg-gray-100 text-gray-700 text-sm font-medium rounded-md px-4 py-1.5">
        Today
      </div>
    </div>

    <!-- Feed -->
    <div id="my_lessons_details_calendar_content_message_tutor_feed"
         class="my_lessons_details_calendar_content_message_tutor_scroll flex-1 overflow-y-auto px-5 pb-2 space-y-6"
         style="max-height: 68vh;">

      <!-- Daniela -->
      <div class="flex items-start gap-3">
        <img src="https://i.pravatar.cc/80?img=5" alt="Daniela" class="w-8 h-8 rounded-full"/>
        <div>
          <div class="text-sm font-semibold text-gray-900">
            Daniela <span class="text-xs text-gray-500 align-middle">09:34</span>
          </div>
          <div class="mt-1 text-[15px] leading-relaxed text-gray-800"
               data-ml_msgtext>
            Good morning, I want to confirm our meeting today and ask if the meeting will take place within
            the Latingles virtual classroom or will you provide the information?
          </div>
        </div>
      </div>

      <!-- Latingles bubble -->
      <div class="flex items-start gap-3">
        <img src="https://api.iconify.design/twemoji:fire.svg" class="w-8 h-8" alt="Latingles"/>
        <div class="flex-1">
          <div class="text-sm font-semibold text-gray-900">
            Latingles <span class="text-xs text-gray-500 align-middle">11:06</span>
          </div>

          <div class="relative mt-1 rounded-xl px-4 py-3 bg-gray-100 text-[15px] text-gray-800
                      my_lessons_details_calendar_content_message_tutor_bubble"
               data-ml_msgtext>
            I’m already in, is anyone joining
            <button type="button"
                    class="absolute right-2 top-2 w-8 h-8 rounded-full hover:bg-gray-200 flex items-center justify-center"
                    aria-label="More">
              <svg class="w-5 h-5" viewBox="0 0 24 24" fill="currentColor">
                <circle cx="5" cy="12" r="1.5"></circle>
                <circle cx="12" cy="12" r="1.5"></circle>
                <circle cx="19" cy="12" r="1.5"></circle>
              </svg>
            </button>
          </div>
        </div>
      </div>

      <!-- Latingles -->
      <div class="flex items-start gap-3">
        <img src="https://api.iconify.design/twemoji:fire.svg" class="w-8 h-8" alt="Latingles"/>
        <div>
          <div class="text-sm font-semibold text-gray-900">
            Latingles <span class="text-xs text-gray-500 align-middle">11:06</span>
          </div>
          <div class="mt-1 text-[15px] text-gray-800" data-ml_msgtext>
            Yes Please wait for me ! Thank you
          </div>
        </div>
      </div>
    </div>

    <!-- Composer -->
    <div class="px-5 pb-5 pt-2">
      <div class="border border-gray-200 rounded-2xl px-3 pt-3 pb-2">
        <textarea id="my_lessons_details_calendar_content_message_tutor_input"
                  class="my_lessons_details_calendar_content_message_tutor_input w-full resize-none text-[15px] placeholder:text-gray-400 px-1 leading-relaxed"
                  rows="3" placeholder="Your message"></textarea>
        <div class="mt-1.5 flex items-center justify-between">
          <div class="flex items-center gap-1.5">
            <button type="button" class="w-9 h-9 rounded-full hover:bg-gray-100 flex items-center justify-center" title="Attach">
              <svg class="w-5 h-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <path d="M21.44 11.05l-9.19 9.19a6 6 0 01-8.49-8.49l9.19-9.19a4 4 0 015.66 5.66l-9.2 9.2a2 2 0 11-2.83-2.83l8.49-8.49"/>
              </svg>
            </button>
            <button type="button" class="w-9 h-9 rounded-full hover:bg-gray-100 flex items-center justify-center" title="Emoji">
              <span class="text-xl">😊</span>
            </button>
          </div>
          <button type="button" class="w-9 h-9 rounded-full hover:bg-gray-100 flex items-center justify-center" title="Voice">
            <svg class="w-5 h-5" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                 stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
              <rect x="9" y="2" width="6" height="11" rx="3"></rect>
              <path d="M5 10v2a7 7 0 0014 0v-2"></path>
              <line x1="12" y1="19" x2="12" y2="22"></line>
              <line x1="8" y1="22" x2="16" y2="22"></line>
            </svg>
          </button>
        </div>
      </div>
      <div class="pt-1 text-xs text-gray-400">Press Enter to send • Shift+Enter for new line</div>
    </div>
  </div>

<script>
$(function(){
  const $panel = $('#my_lessons_details_calendar_content_message_tutor_panel');
  const $feed  = $('#my_lessons_details_calendar_content_message_tutor_feed');
  const $input = $('#my_lessons_details_calendar_content_message_tutor_input');

  // open/close
  $('.my_lessons_details_calendar_content_message_tutor_btn').on('click', function(){ $panel.removeClass('hidden'); });
  $('#my_lessons_details_calendar_content_message_tutor_close, #my_lessons_details_calendar_content_message_tutor_back')
    .on('click', function(){ $panel.addClass('hidden'); });

  // --- Guard function: strip any injected leading numbers (e.g., "100 ") from text nodes
  function stripInjectedNumbers($root){
    $root.find('[data-ml_msgtext], #my_lessons_details_calendar_content_message_tutor_today').each(function(){
      // operate only on the first text node in the element
      const node = $(this).contents().filter(function(){ return this.nodeType === 3; }).get(0);
      if (node){
        const raw = node.nodeValue || '';
        const clean = raw.replace(/^\s*\d+\s+/, '');  // remove "100 " or "123 "
        if (clean !== raw) node.nodeValue = clean;
      } else {
        // fallback: replace full text if no direct text node
        const txt = $(this).text();
        const clean2 = txt.replace(/^\s*\d+\s+/, '');
        if (clean2 !== txt) $(this).text(clean2);
      }
    });
  }

  // sanitize immediately and on open (in case global scripts mutate late)
  stripInjectedNumbers($panel);
  $('.my_lessons_details_calendar_content_message_tutor_btn').on('click', function(){
    // defer slightly after open to allow any late injectors to run
    setTimeout(()=>stripInjectedNumbers($panel), 0);
  });

  // textarea autogrow
  $input.on('input', function(){
    this.style.height = 'auto';
    this.style.height = Math.min(this.scrollHeight, 140) + 'px';
  });

  // Enter to send (no button)
  $input.on('keydown', function(e){
    if (e.key === 'Enter' && !e.shiftKey){
      e.preventDefault();
      const txt = $input.val().trim();
      if(!txt) return;
      const now = new Date();
      const hh = String(now.getHours()).padStart(2,'0');
      const mm = String(now.getMinutes()).padStart(2,'0');

      const safe = $('<div>').text(txt).html().replace(/^\s*\d+\s+/, ''); // sanitize user message too
      const bubble = `
        <div class="flex items-start gap-3">
          <img src="https://api.iconify.design/twemoji:fire.svg" class="w-8 h-8" alt="You"/>
          <div>
            <div class="text-sm font-semibold text-gray-900">You <span class="text-xs text-gray-500 align-middle">${hh}:${mm}</span></div>
            <div class="mt-1 text-[15px] text-gray-800" data-ml_msgtext>${safe}</div>
          </div>
        </div>`;
      $feed.append(bubble);
      $input.val('').trigger('input');
      $feed.scrollTop($feed[0].scrollHeight);
      stripInjectedNumbers($panel); // ensure no numbers got injected post-append
    }
  });
  
  // responsive height
  const applyMobile = () => {
    if (window.matchMedia('(max-width:640px)').matches){
      $panel.css({ width:'min(95vw,560px)' });
      $feed.css('max-height','72vh');
    } else {
      $panel.css({ width:'' });
      $feed.css('max-height','68vh');
    }
  };
  applyMobile();
  $(window).on('resize', applyMobile);
});
</script>

</body>
</html>
