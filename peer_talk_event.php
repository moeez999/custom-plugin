<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8"/>
<meta name="viewport" content="width=device-width, initial-scale=1"/>
<title>Peer Talk Events Dropdown</title>

<link rel="preconnect" href="https://fonts.googleapis.com">
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700&display=swap" rel="stylesheet">
<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<script src="https://cdn.tailwindcss.com"></script>

<style>
  :root{
    --peer_talk_events_border:#E4E7EE;
    --peer_talk_events_text:#121117;
    --peer_talk_events_muted:#9CA3AF;
    --peer_talk_events_accent:#ff3b1f;               /* red accent for card border/dot */
    --peer_talk_events_join_start:#ff5a2f;           /* join gradient */
    --peer_talk_events_join_end:#ff2a10;
  }
  body{ font-family:'Inter', system-ui, -apple-system, Segoe UI, Roboto, Helvetica, Arial, sans-serif; }
  .peer_talk_events_shadow{ box-shadow:0 8px 32px rgba(18,17,23,.15), 0 16px 48px rgba(18,17,23,.12); }
  .peer_talk_events_box{ border:1px solid var(--peer_talk_events_border); }
  .peer_talk_events_chip{ border:1px solid var(--peer_talk_events_border); border-radius:9999px; padding:.375rem .75rem; }
  .peer_talk_events_badge{ width:28px; height:28px; border-radius:9999px; display:inline-flex; align-items:center; justify-content:center; font-weight:600; font-size:.75rem; }
  .peer_talk_events_checkbox{ width:24px; height:24px; border:2px solid #CBD5E1; border-radius:.5rem; display:inline-flex; align-items:center; justify-content:center; background:#fff; cursor:pointer; }
  .peer_talk_events_checkbox.checked{ background:#111827; border-color:#111827; }
  .peer_talk_events_checkbox.checked:after{ content:""; width:10px; height:10px; background:#fff; border-radius:.25rem; }
  .peer_talk_events_noscrollbar{ scrollbar-width:none; -ms-overflow-style:none; }
  .peer_talk_events_noscrollbar::-webkit-scrollbar{ width:0; height:0; }
  .peer_talk_events_caret{ transition:transform .18s ease; }
  .peer_talk_events_caret--open{ transform:rotate(180deg); }

  /* ===== Room card styles (exact snapshot) ===== */
  .peer_talk_events_roomcard{ border:1.5px solid var(--peer_talk_events_accent); border-radius:18px; }
  .peer_talk_events_timerpill{
    border:1px solid #E5E7EB; background:#fff; border-radius:9999px;
    padding:2px 8px; font-size:12px; display:inline-flex; align-items:center; gap:6px;
  }
  .peer_talk_events_reddot{ width:8px; height:8px; background:var(--peer_talk_events_accent); border-radius:9999px; display:inline-block; }

  .peer_talk_events_joinbtn{
    background:linear-gradient(180deg, var(--peer_talk_events_join_start), var(--peer_talk_events_join_end));
    color:#fff;
    border:2px solid #000;          /* ⬅ black border */
    border-radius:9999px;
    font-weight:700;
    width:95px; height:36px;
    box-shadow: inset 0 1px 0 rgba(255,255,255,.35);
  }
  .peer_talk_events_watchbtn{
    background:#fff;
    color:#111;
    border:2px solid #000;          /* ⬅ black border */
    border-radius:9999px;
    font-weight:700;
    width:95px; height:36px;
  }

  /* Compact table-like spacing inside card */
  .peer_talk_events_rowline{ height:1px; background:#E5E7EB; }
</style>
</head>
<body class="bg-white text-[15px] text-slate-900 font-['Inter']">

<div class="max-w-[1200px] mx-auto px-4 md:px-6 py-8">
  <div class="flex flex-col md:flex-row gap-8 items-start">

    <!-- LEFT (40%) -->
    <section class="w-full md:w-2/5">
      <h2 class="text-[18px] font-semibold mb-3">Speaking events</h2>

      <!-- FIELD + CALENDAR ICON (outside) -->
      <div class="flex items-center gap-2">
        <!-- input/select -->
        <div class="relative flex-1">
          <button id="peer_talk_events_field"
                  type="button"
                  class="peer_talk_events_box w-full h-[48px] rounded-xl px-4 pr-12 text-left flex items-center justify-between hover:bg-slate-50 focus:outline-none" style="border:2px solid black;">
            <span id="peer_talk_events_field_label" class="text-slate-500">Select Speaking events</span>
            <svg id="peer_talk_events_caret" class="peer_talk_events_caret w-5 h-5 text-slate-700 absolute right-3"
                 viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
              <path d="M6 9l6 6 6-6"/>
            </svg>
          </button>
          
          <!-- DROPDOWN PANEL -->
          <div id="peer_talk_events_panel"
               class="hidden absolute z-50 mt-2 w-full bg-white rounded-xl peer_talk_events_box peer_talk_events_shadow">
            <!-- <div class="flex items-center justify-between px-5 py-3 border-b border-slate-100">
              <div class="font-semibold text-[16px]">Events</div>
              <button id="peer_talk_events_close" class="w-9 h-9 rounded-lg hover:bg-slate-100 grid place-items-center" aria-label="Close">
                <svg class="w-5 h-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M18 6L6 18M6 6l12 12"/></svg>
              </button>
            </div> -->

            <!-- list body -->
            <div class="max-h-[420px] overflow-auto peer_talk_events_noscrollbar p-2">
              <ul id="peer_talk_events_list" class="flex flex-col gap-2">

                <!-- ITEM 1 -->
                <li class="peer_talk_events_item peer_talk_events_box rounded-xl">
                  <button type="button" class="peer_talk_events_row w-full px-4 py-3 flex items-center justify-between rounded-xl">
                    <span class="font-semibold">Peer talk 1</span>
                    <span class="peer_talk_events_checkbox" data-name="Peer talk 1" role="checkbox" aria-checked="false"></span>
                  </button>
                  <div class="peer_talk_events_expand px-4 pb-4 hidden">
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                      <div>
                        <div class="text-slate-800 font-semibold mb-2">Attending Cohorts</div>
                        <div class="flex items-center gap-3 peer_talk_events_chip mb-2"><span class="peer_talk_events_badge bg-lime-100 text-lime-800">FL1</span><span>Florida 1</span></div>
                        <div class="flex items-center gap-3 peer_talk_events_chip mb-2"><span class="peer_talk_events_badge bg-purple-100 text-purple-800">TX1</span><span>Texas 1</span></div>
                        <div class="flex items-center gap-3 peer_talk_events_chip mb-2"><span class="peer_talk_events_badge bg-emerald-100 text-emerald-800">FL3</span><span>Florida 3</span></div>
                        <div class="flex items-center gap-3 peer_talk_events_chip"><span class="peer_talk_events_badge bg-lime-100 text-lime-800">FL2</span><span>Florida 2</span></div>
                      </div>
                      <div>
                        <div class="text-slate-800 font-semibold mb-2">Attending Teachers</div>
                        <div class="flex items-center gap-3 peer_talk_events_chip mb-2"><img class="w-7 h-7 rounded-full object-cover" src="https://i.pravatar.cc/48?img=11"><span>jackson</span></div>
                        <div class="flex items-center gap-3 peer_talk_events_chip mb-2"><img class="w-7 h-7 rounded-full object-cover" src="https://i.pravatar.cc/48?img=12"><span>Hawkins</span></div>
                        <div class="flex items-center gap-3 peer_talk_events_chip mb-2"><img class="w-7 h-7 rounded-full object-cover" src="https://i.pravatar.cc/48?img=13"><span>Warren</span></div>
                        <div class="flex items-center gap-3 peer_talk_events_chip"><img class="w-7 h-7 rounded-full object-cover" src="https://i.pravatar.cc/48?img=14"><span>Fox</span></div>
                      </div>
                    </div>
                  </div>
                </li>

                <!-- ITEM 2 -->
                <li class="peer_talk_events_item peer_talk_events_box rounded-xl">
                  <button type="button" class="peer_talk_events_row w-full px-4 py-3 flex items-center justify-between rounded-xl">
                    <span class="font-semibold">Peer talk 2</span>
                    <span class="peer_talk_events_checkbox" data-name="Peer talk 2" role="checkbox" aria-checked="false"></span>
                  </button>
                  <div class="peer_talk_events_expand px-4 pb-4 hidden"><p class="text-slate-600">Details for Peer talk 2</p></div>
                </li>

                <!-- ITEM 3 -->
                <li class="peer_talk_events_item peer_talk_events_box rounded-xl">
                  <button type="button" class="peer_talk_events_row w-full px-4 py-3 flex items-center justify-between rounded-xl">
                    <span class="font-semibold">Peer talk 3</span>
                    <span class="peer_talk_events_checkbox" data-name="Peer talk 3" role="checkbox" aria-checked="false"></span>
                  </button>
                  <div class="peer_talk_events_expand px-4 pb-4 hidden"><p class="text-slate-600">Details for Peer talk 3</p></div>
                </li>

                <!-- ITEM 4 -->
                <li class="peer_talk_events_item peer_talk_events_box rounded-xl">
                  <button type="button" class="peer_talk_events_row w-full px-4 py-3 flex items-center justify-between rounded-xl">
                    <span class="font-semibold">Peer talk 4</span>
                    <span class="peer_talk_events_checkbox" data-name="Peer talk 4" role="checkbox" aria-checked="false"></span>
                  </button>
                  <div class="peer_talk_events_expand px-4 pb-4 hidden"><p class="text-slate-600">Details for Peer talk 4</p></div>
                </li>

                <!-- ITEM 5 -->
                <li class="peer_talk_events_item peer_talk_events_box rounded-xl">
                  <button type="button" class="peer_talk_events_row w-full px-4 py-3 flex items-center justify-between rounded-xl">
                    <span class="font-semibold">Peer talk 5</span>
                    <span class="peer_talk_events_checkbox" data-name="Peer talk 5" role="checkbox" aria-checked="false"></span>
                  </button>
                  <div class="peer_talk_events_expand px-4 pb-4 hidden"><p class="text-slate-600">Details for Peer talk 5</p></div>
                </li>

              </ul>
            </div>
          </div>
        </div>

        <!-- Calendar OUTSIDE -->
        <a href="calendar_admin.php?event_id=2"><button type="button" class="peer_talk_events_box w-10 h-10 rounded-lg grid place-items-center hover:bg-slate-50" aria-label="Calendar">
          <svg class="w-5 h-5 text-slate-700" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
            <rect x="3" y="4" width="18" height="18" rx="2"/><path d="M16 2v4M8 2v4M3 10h18"/>
          </svg>
        </button></a>
      </div>

      <!-- ===== Room card (AFTER DROPDOWN) ===== -->
      <div class="peer_talk_events_roomcard mt-6 bg-white">
        <!-- header -->
        <div class="px-4 lg:px-5 pt-3">
          <div class="grid grid-cols-12 items-center">
            <div class="col-span-6 sm:col-span-5 flex items-center gap-3">
              <div class="text-[13px] font-semibold">Room 1</div>
              <span class="peer_talk_events_timerpill">
                <span class="peer_talk_events_reddot"></span>
                <span>5:43</span>
              </span>
            </div>
            <div class="hidden sm:block sm:col-span-2 text-[12px] text-[color:var(--peer_talk_events_muted)]">Cohort</div>
            <div class="hidden sm:block sm:col-span-2 text-[12px] text-[color:var(--peer_talk_events_muted)]">Level</div>
            <!-- right column intentionally empty in header -->
            <div class="hidden sm:block sm:col-span-3"></div>
          </div>
        </div>

        <!-- body rows + actions column -->
        <div class="px-4 lg:px-5 pb-3">
          <div class="grid grid-cols-12 items-center">
            <!-- left block (two rows) -->
            <div class="col-span-9">
              <!-- row 1 -->
              <div class="grid grid-cols-9 items-center py-1">
                <div class="col-span-5 flex items-center gap-3">
                  <img class="w-6 h-6 rounded-full object-cover" src="https://i.pravatar.cc/72?img=20" alt="Devon Lane">
                  <div class="text-[12px]">Devon Lane</div>
                </div>
                <div class="hidden sm:block col-span-2">FL1</div>
                <div class="hidden sm:block col-span-2">2</div>
              </div>
              <div class="peer_talk_events_rowline"></div>
              <!-- row 2 -->
              <div class="grid grid-cols-9 items-center py-1">
                <div class="col-span-5 flex items-center gap-3">
                  <img class="w-6 h-6 rounded-full object-cover" src="https://i.pravatar.cc/72?img=28" alt="Kristin Watson">
                  <div class="text-[12px]">Kristin Watson</div>
                </div>
                <div class="hidden sm:block col-span-2">FL1</div>
                <div class="hidden sm:block col-span-2">2</div>
              </div>
            </div>

            <!-- actions column (vertical buttons) -->
            <div class="col-span-3 flex flex-col items-end justify-center gap-3">
              <button class="peer_talk_events_joinbtn">Join</button>
              <button class="peer_talk_events_watchbtn">Watch</button>
            </div>
          </div>
        </div>
      </div>
      <!-- ===== /Room card ===== -->

    </section>

    <!-- RIGHT (60%) -->
    <section class="w-full md:w-3/5">
      <h2 class="text-[18px] font-semibold mb-3">Details</h2>
      <div id="peer_talk_events_rightbox" class="rounded-xl border border-slate-200 p-5 min-h-[220px]">
        <p class="text-slate-600">Select an event from the left dropdown to see details here.</p>
      </div>
    </section>

  </div>
</div>

<script>
  const peer_talk_events_state = { open:false };

  function peer_talk_events_openPanel() {
    peer_talk_events_state.open = true;
    $('#peer_talk_events_panel').removeClass('hidden');
    $('#peer_talk_events_caret').addClass('peer_talk_events_caret--open');
  }
  function peer_talk_events_closePanel() {
    peer_talk_events_state.open = false;
    $('#peer_talk_events_panel').addClass('hidden');
    $('#peer_talk_events_caret').removeClass('peer_talk_events_caret--open');
  }

  $(function(){
    // Toggle dropdown
    $('#peer_talk_events_field').on('click', function(e){
      e.stopPropagation();
      peer_talk_events_state.open ? peer_talk_events_closePanel() : peer_talk_events_openPanel();
    });
    $('#peer_talk_events_close').on('click', function(e){
      e.stopPropagation(); peer_talk_events_closePanel();
    });
    $(document).on('click', function(){ if(peer_talk_events_state.open) peer_talk_events_closePanel(); });
    $('#peer_talk_events_panel').on('click', function(e){ e.stopPropagation(); });

    // Expand/collapse rows
    $('.peer_talk_events_row').on('click', function(e){
      if($(e.target).closest('.peer_talk_events_checkbox').length) return;
      const $item = $(this).closest('.peer_talk_events_item');
      const $expand = $item.find('.peer_talk_events_expand');
      $('.peer_talk_events_expand').not($expand).addClass('hidden');
      $expand.toggleClass('hidden');
    });

    // Checkbox toggle only
    $('.peer_talk_events_checkbox').on('click', function(e){
      e.stopPropagation();
      const $cb = $(this);
      $('.peer_talk_events_checkbox').not($cb).removeClass('checked').attr('aria-checked','false');
      $cb.toggleClass('checked');
      $cb.attr('aria-checked', $cb.hasClass('checked') ? 'true' : 'false');
    });

    // Default expand first
    $('.peer_talk_events_item').first().find('.peer_talk_events_expand').removeClass('hidden');
  });
</script>
</body>
</html>
