<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8"/>
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Find Groups – Section (Names Static + Click Names to Switch)</title>

  <!-- Tailwind + jQuery -->
  <script src="https://cdn.tailwindcss.com"></script>
  <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet"/>

  <style>
    :root{
      --fgda-border:#000000;      /* black outer border */
      --fgda-inner:#E7E7EE;       /* inner box borders */
      --fgda-muted:#6B6E76;
      --fgda-text:#121117;
      --fgda-peach:#F23C2A;
    }
    html,body{font-family:Inter,system-ui,Segoe UI,Roboto,Helvetica,Arial,sans-serif;}
    .find_groups_details_available_card{border:2px solid var(--fgda-border); border-radius:14px; background:#fff;}
    .find_groups_details_available_badge{font-size:12px; line-height:18px; padding:2px 10px; border-radius:8px; font-weight:500; display:inline-flex; align-items:center; white-space:nowrap;}
    .find_groups_details_available_box{border:1px solid var(--fgda-inner); border-radius:10px; background:#fff;}
    .find_groups_details_available_num{width:36px; height:36px; border:1.5px solid var(--fgda-inner); border-radius:8px; display:flex; align-items:center; justify-content:center; font-weight:600; background:#fff;}
    .find_groups_details_available_input{border:1.5px solid #E4E7EE; border-radius:10px; height:46px; padding-left:40px; font-size:14px;}
    .find_groups_details_available_like svg{transition:transform .15s ease;}
    .find_groups_details_available_like:hover svg{transform:scale(1.05);}
    .find_groups_details_available_clickable{cursor:pointer;}
    .find_groups_details_available_active{outline:2px solid #919191; outline-offset:2px; border-radius:2px;}

    /* --- Details / Review styles --- */
    .find_groups_details_available_review_card{
      border:1px solid var(--fgda-inner);
      border-radius:12px;
      background:#fff;
    }
    .find_groups_details_available_star{width:18px;height:18px}
    .find_groups_details_available_toggle_link{font-weight:600;}
  </style>
</head>
<body class="bg-white text-[color:var(--fgda-text)]">

  <!-- =========================
       SECTION
       ========================= -->
  <section id="find_groups_details_available_section" class="py-8">
    <div id="find_groups_details_available_wrap" class="max-w-[1400px] mx-auto px-4">

      <!-- Heading + Search IN ONE ROW -->
      <div id="find_groups_details_available_search_bar_row"
           class="mb-5 flex flex-col gap-3 md:flex-row md:items-center md:justify-between">
        <h2 id="find_groups_details_available_heading"
            class="text-[28px] leading-[34px] font-semibold">
          50 Groups Available
        </h2>

        <div id="find_groups_details_available_search_wrap" class="relative w-full md:w-[360px]">
          <span id="find_groups_details_available_search_icon"
                class="absolute left-3 top-1/2 -translate-y-1/2 text-[#98A2B3]">
            <svg xmlns="http://www.w3.org/2000/svg" class="w-[18px] h-[18px]" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8">
              <circle cx="11" cy="11" r="8"/><path d="m21 21-4.3-4.3"/>
            </svg>
          </span>
          <input id="find_groups_details_available_search_input"
                 class="find_groups_details_available_input w-full"
                 placeholder="Search by name" type="text">
        </div>
      </div>

      <!-- Left & Right in one row -->
      <div id="find_groups_details_available_layout" class="grid grid-cols-1 lg:grid-cols-[1fr_360px] gap-6">

        <!-- ===== LEFT: MAIN CARD ===== -->
        <article id="find_groups_details_available_card" class="find_groups_details_available_card relative p-3 lg:h-[340px]">

          <!-- Heart -->
          <button id="find_groups_details_available_btn_like"
                  class="find_groups_details_available_like absolute top-4 right-4 w-9 h-9 rounded-full border border-[#E4E7EE] flex items-center justify-center bg-white"
                  aria-label="Save">
            <svg xmlns="http://www.w3.org/2000/svg" class="w-[20px] h-[20px]" viewBox="0 0 24 24" fill="none" stroke="#111" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round">
              <path d="M20.84 4.61a5.5 5.5 0 0 0-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 1 0-7.78 7.78L12 21.23l8.84-8.84a5.5 5.5 0 0 0 0-7.78Z"/>
            </svg>
          </button>

          <!-- 3-column grid -->
          <div id="find_groups_details_available_card_grid" class="grid grid-cols-[140px_minmax(0,1fr)_280px] gap-5 items-start">

            <!-- Avatar + pager -->
            <div id="find_groups_details_available_avatar_col">
              <div id="find_groups_details_available_avatar_wrap" class="relative w-[140px] h-[140px]">
                <img id="find_groups_details_available_avatar_img"
                     src="https://images.unsplash.com/photo-1544006659-f0b21884ce1d?q=80&w=800&auto=format&fit=crop"
                     alt="Profile" class="w-full h-full object-cover rounded-[12px]">
                <span id="find_groups_details_available_online_dot"
                      class="absolute bottom-2 right-2 w-[18px] h-[18px] bg-[#14C38E] rounded-[4px] border-2 border-white"></span>
              </div>
              <div id="find_groups_details_available_pager" class="flex gap-3 mt-3">
                <button id="find_groups_details_available_btn_page1" class="find_groups_details_available_num">1</button>
                <button id="find_groups_details_available_btn_page2" class="find_groups_details_available_num">2</button>
              </div>
            </div>

            <!-- Center content -->
            <div id="find_groups_details_available_center_col" class="min-w-0">
              <!-- Title single line -->
              <h3 id="find_groups_details_available_title"
                  class="text-[20px] font-semibold whitespace-nowrap overflow-hidden text-ellipsis">
                English Group Classes (Bilingual)
              </h3>
              
              <!-- badges -->
              <div id="find_groups_details_available_badges"
                   class="mt-2 flex items-center gap-2 whitespace-nowrap">
                <span id="find_groups_details_available_badge_beginner" class="find_groups_details_available_badge"
                      style="background:#E7F5EF; color:#0A7B64;">Begginer</span>
                <span id="find_groups_details_available_badge_lang" class="find_groups_details_available_badge"
                      style="background:#FBEAEA; color:#B42318;">English &amp; Spanish</span>
                <span id="find_groups_details_available_badge_conv" class="find_groups_details_available_badge"
                      style="background:#EEEAF9; color:#5B21B6;">Conversational (only)</span>
              </div>

              <!-- info boxes (names stay static) -->
              <div id="find_groups_details_available_info_grid" class="grid grid-cols-2 gap-3 mt-2 text-[12px]">
                <div id="find_groups_details_available_box_main_teacher"
                     class="find_groups_details_available_box p-2 find_groups_details_available_clickable"
                     role="button" tabindex="0" aria-label="Show Main Teacher profile (1)">
                  <p class="text-[13px] text-[color:var(--fgda-muted)] mb-1">Main Teacher :</p>
                  <p id="find_groups_details_available_main_name" class="font-semibold">Daniela Canelon</p>
                  <div class="flex items-center gap-2 mt-1 text-[color:var(--fgda-muted)]">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-[16px] h-[16px]" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6"><path d="M12 2a10 10 0 1 0 0 20 10 10 0 0 0 0-20Z"/><path d="M2 12h20"/><path d="M12 2a15.3 15.3 0 0 1 4 10 15.3 15.3 0 0 1-4 10 15.3 15.3 0 0 1-4-10 15.3 15.3 0 0 1 4-10Z"/></svg>
                    <span id="find_groups_details_available_main_lang">English (Native)</span>
                  </div>
                </div>

                <div id="find_groups_details_available_box_practice_teacher"
                     class="find_groups_details_available_box p-3 find_groups_details_available_clickable"
                     role="button" tabindex="0" aria-label="Show Practice Teacher profile (2)">
                  <p class="text-[13px] text-[color:var(--fgda-muted)] mb-1">Practice Teacher :</p>
                  <p id="find_groups_details_available_practice_name" class="font-semibold">Axley Perez</p>
                  <div class="flex items-center gap-2 mt-1 text-[color:var(--fgda-muted)]">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-[16px] h-[16px]" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6"><path d="M12 2a10 10 0 1 0 0 20 10 10 0 0 0 0-20Z"/><path d="M2 12h20"/><path d="M12 2a15.3 15.3 0 0 1 4 10 15.3 15.3 0 0 1-4 10 15.3 15.3 0 0 1-4-10 15.3 15.3 0 0 1 4-10Z"/></svg>
                    <span id="find_groups_details_available_practice_lang">English (Native)</span>
                  </div>
                </div>

                <div id="find_groups_details_available_box_students" class="find_groups_details_available_box p-3">
                  <p class="text-[13px] text-[color:var(--fgda-muted)] mb-1">Students</p>
                  <p class="font-semibold flex items-center gap-2">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-[16px] h-[16px]" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8"><path d="M20 21a8 8 0 1 0-16 0"/><circle cx="12" cy="7" r="4"/></svg>
                    <span id="find_groups_details_available_students_active">4 Active ,</span>
                  </p>
                  <p id="find_groups_details_available_students_max" class="text-[color:var(--fgda-muted)]">Max 10</p>
                </div>

                <div id="find_groups_details_available_box_schedule" class="find_groups_details_available_box p-3">
                  <p class="text-[13px] text-[color:var(--fgda-muted)] mb-1">Schedule :</p>
                  <p id="find_groups_details_available_schedule_1" class="font-semibold">Mon, Wed, – 8 PM EST</p>
                  <p id="find_groups_details_available_schedule_2" class="font-semibold">Fri – 8 PM EST</p>
                </div>
              </div>

              <!-- footer -->
              <div id="find_groups_details_available_footerline" class="mt-3 flex items-center justify-between text-[13px]">
                <p id="find_groups_details_available_footer_text" class="text-[color:var(--fgda-muted)]">
                  Certified tutor and polyglot with 5 year
                  <span style="margin-left: 50px; font-weight:600;">
                    <a href="#" id="find_groups_details_available_toggle" class="find_groups_details_available_toggle_link">See More...</a>
                  </span>
                </p>
              </div>

              <!-- EXPANDABLE DETAILS (hidden by default) -->
              <div id="find_groups_details_available_details" class="hidden mt-3">
                <!-- Full bio paragraph -->
                <p class="text-[14px] leading-6 text-[color:var(--fgda-text)]">
                  Certified tutor and polyglot with 5 years of experience — Hello there! I am Nicholas. I’m a digital nomad and I am 25.
                  I love teaching and I have been doing so for about 5 years. I have a currently pursuing a bachelor’s degree in Political
                  Science at the University of Maine. A fun fact about me is that apart from speaking 9 languages, I have traveled to over
                  60 countries.
                </p>

                <!-- Why Choose -->
                <h4 class="mt-5 font-semibold text-[16px]">Why Choose English Group Classes (Bilingual)</h4>

                <!-- Review card -->
                <div class="find_groups_details_available_review_card mt-3 p-4">
                  <div class="flex items-start gap-3">
                    <img src="https://images.unsplash.com/photo-1502685104226-ee32379fefbe?q=80&w=256&auto=format&fit=crop"
                         alt="Efren" class="w-12 h-12 rounded-md object-cover"/>
                    <div class="flex-1 min-w-0">
                      <div class="flex items-center justify-between">
                        <div class="font-semibold">Efren</div>
                        <div class="text-[12px] text-[color:var(--fgda-muted)]">September 14, 2024</div>
                      </div>

                      <!-- Stars -->
                      <div class="mt-1 flex gap-1">
                        <svg class="find_groups_details_available_star" viewBox="0 0 24 24" fill="currentColor"><path d="M12 17.27 18.18 21l-1.64-7.03L22 9.24l-7.19-.62L12 2 9.19 8.62 2 9.24l5.46 4.73L5.82 21 12 17.27Z"/></svg>
                        <svg class="find_groups_details_available_star" viewBox="0 0 24 24" fill="currentColor"><path d="M12 17.27 18.18 21l-1.64-7.03L22 9.24l-7.19-.62L12 2 9.19 8.62 2 9.24l5.46 4.73L5.82 21 12 17.27Z"/></svg>
                        <svg class="find_groups_details_available_star" viewBox="0 0 24 24" fill="currentColor"><path d="M12 17.27 18.18 21l-1.64-7.03L22 9.24l-7.19-.62L12 2 9.19 8.62 2 9.24l5.46 4.73L5.82 21 12 17.27Z"/></svg>
                        <svg class="find_groups_details_available_star" viewBox="0 0 24 24" fill="currentColor"><path d="M12 17.27 18.18 21l-1.64-7.03L22 9.24l-7.19-.62L12 2 9.19 8.62 2 9.24l5.46 4.73L5.82 21 12 17.27Z"/></svg>
                        <svg class="find_groups_details_available_star" viewBox="0 0 24 24" fill="currentColor"><path d="M12 17.27 18.18 21l-1.64-7.03L22 9.24l-7.19-.62L12 2 9.19 8.62 2 9.24l5.46 4.73L5.82 21 12 17.27Z"/></svg>
                      </div>

                      <p class="mt-2 text-[14px] leading-6 text-[color:var(--fgda-text)]">
                        He is an excellent teacher with incredible patience and effective teaching methods.
                        The classes are comprehensive, engaging, and dynamic. I truly enjoy learning English with him!
                      </p>
                    </div>
                  </div>
                </div>

                <!-- Hide link -->
                <div class="mt-4 text-center">
                  <a href="#" id="find_groups_details_available_hide" class="find_groups_details_available_toggle_link underline decoration-transparent hover:decoration-inherit">Hide Details</a>
                </div>
              </div>
            </div>

            <!-- Right: rating/price + CTAs (black borders on CTAs) -->
            <div id="find_groups_details_available_side_col">
              <div id="find_groups_details_available_rating_price" class="flex items-start gap-8">
                <div>
                  <div class="flex items-center gap-2">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-[18px] h-[18px]" viewBox="0 0 24 24" fill="currentColor"><path d="M12 17.27 18.18 21l-1.64-7.03L22 9.24l-7.19-.62L12 2 9.19 8.62 2 9.24l5.46 4.73L5.82 21 12 17.27Z"/></svg>
                    <span id="find_groups_details_available_rating_value" class="text-[18px] font-semibold">4.7</span>
                  </div>
                  <div id="find_groups_details_available_reviews_text" class="text-[12px] text-[color:var(--fgda-muted)] mt-1">8 reviews</div>
                </div>
                <div>
                  <div id="find_groups_details_available_price_value" class="text-[18px] font-semibold">$70</div>
                  <div id="find_groups_details_available_price_cycle" class="text-[12px] text-[color:var(--fgda-muted)]">Monthly</div>
                </div>
              </div>

              <div id="find_groups_details_available_cta_stack" class="mt-4 flex flex-col gap-3">
                <button id="find_groups_details_available_btn_book"
                        class="w-full h-[48px] rounded-[10px] font-semibold bg-[var(--fgda-peach)] text-white border-2 border-black">
                  Book trial lesson
                </button>
                <button id="find_groups_details_available_btn_message"
                        class="w-full h-[48px] rounded-[10px] font-semibold bg-white border-2 border-black">
                  Send a Message
                </button>
              </div>
            </div>
          </div>
        </article>

        <!-- ===== RIGHT: image mirrors left ===== -->
        <aside id="find_groups_details_available_right_rail">
          <div id="find_groups_details_available_video_card" class="relative rounded-[12px] overflow-hidden shadow-[0_8px_32px_rgba(18,17,23,.10)]">
            <img id="find_groups_details_available_video_img"
                 src="https://images.unsplash.com/photo-1544006659-f0b21884ce1d?q=80&w=1600&auto=format&fit=crop"
                 class="w-full h-[340px] object-cover" alt="profile large">
            <button id="find_groups_details_available_btn_play"
                    class="absolute right-5 bottom-5 w-[54px] h-[54px] rounded-full bg-[var(--fgda-peach)] text-white flex items-center justify-center"
                    aria-label="Play">
              <svg xmlns="http://www.w3.org/2000/svg" class="w-[22px] h-[22px]" viewBox="0 0 24 24" fill="currentColor"><path d="M8 5v14l11-7z"/></svg>
            </button>
          </div>
        </aside>

      </div>
    </div>
  </section>

  <!-- =========================
       JS
       ========================= -->
  <script>
    // Two profiles (you can extend)
    const find_groups_details_available_profiles = [
      {
        avatar:"https://images.unsplash.com/photo-1544006659-f0b21884ce1d?q=80&w=800&auto=format&fit=crop",
        studentsActive:"4 Active ,", studentsMax:"Max 10",
        schedule1:"Mon, Wed, – 8 PM EST", schedule2:"Fri – 8 PM EST",
        rating:"4.7", reviews:"8 reviews", price:"$70", cycle:"Monthly"
      },
      {
        avatar:"https://images.unsplash.com/photo-1527980965255-d3b416303d12?q=80&w=800&auto=format&fit=crop",
        studentsActive:"6 Active ,", studentsMax:"Max 10",
        schedule1:"Tue, Thu, – 9 PM EST", schedule2:"Sat – 7 PM EST",
        rating:"4.8", reviews:"12 reviews", price:"$75", cycle:"Monthly"
      }
    ];

    let find_groups_details_available_active_index = 0;

    // Renders details EXCEPT names (names remain static)
    function find_groups_details_available_render(i){
      const p = find_groups_details_available_profiles[i];
      $("#find_groups_details_available_avatar_img").attr("src", p.avatar);
      $("#find_groups_details_available_video_img").attr("src", p.avatar);

      $("#find_groups_details_available_students_active").text(p.studentsActive);
      $("#find_groups_details_available_students_max").text(p.studentsMax);
      $("#find_groups_details_available_schedule_1").text(p.schedule1);
      $("#find_groups_details_available_schedule_2").text(p.schedule2);
      $("#find_groups_details_available_rating_value").text(p.rating);
      $("#find_groups_details_available_reviews_text").text(p.reviews);
      $("#find_groups_details_available_price_value").text(p.price);
      $("#find_groups_details_available_price_cycle").text(p.cycle);

      // Update active styles for controls
      $('#find_groups_details_available_btn_page1, #find_groups_details_available_btn_page2')
        .removeClass('ring-2 ring-black');
      if(i===0){ $('#find_groups_details_available_btn_page1').addClass('ring-2 ring-black'); }
      if(i===1){ $('#find_groups_details_available_btn_page2').addClass('ring-2 ring-black'); }

      $('#find_groups_details_available_box_main_teacher, #find_groups_details_available_box_practice_teacher')
        .removeClass('find_groups_details_available_active');
      if(i===0){ $('#find_groups_details_available_box_main_teacher').addClass('find_groups_details_available_active'); }
      if(i===1){ $('#find_groups_details_available_box_practice_teacher').addClass('find_groups_details_available_active'); }

      find_groups_details_available_active_index = i;
    }

    // Heart toggle
    function find_groups_details_available_likeToggle(){
      $('#find_groups_details_available_btn_like').on('click', function(){
        $(this).toggleClass('is-liked');
        const liked = $(this).hasClass('is-liked');
        const $path = $('path', this);
        $path.attr('fill', liked ? '#F23C2A' : 'none')
             .attr('stroke', liked ? '#F23C2A' : '#111');
      });
    }

    // Expand / Collapse details
    function find_groups_details_available_detailsToggleInit(){
      const $card = $('#find_groups_details_available_card');
      const fixedHClass = 'lg:h-[340px]';

      function expand(){
        $('#find_groups_details_available_details').removeClass('hidden');
        $('#find_groups_details_available_toggle').text('Hide Details');
        // allow auto height on large screens
        $card.removeClass(fixedHClass);
        // scroll the top of the details into view for context
        document.getElementById('find_groups_details_available_details')
          .scrollIntoView({behavior:'smooth', block:'start', inline:'nearest'});
      }
      function collapse(){
        $('#find_groups_details_available_details').addClass('hidden');
        $('#find_groups_details_available_toggle').text('See More...');
        // restore fixed height
        if(!$card.hasClass(fixedHClass)) $card.addClass(fixedHClass);
      }

      // toggle from footer link
      $('#find_groups_details_available_toggle').on('click', function(e){
        e.preventDefault();
        const isHidden = $('#find_groups_details_available_details').hasClass('hidden');
        isHidden ? expand() : collapse();
      });

      // extra "Hide Details" link inside expanded area
      $('#find_groups_details_available_hide').on('click', function(e){
        e.preventDefault();
        collapse();
        // ensure footer is visible after collapsing
        document.getElementById('find_groups_details_available_footerline')
          .scrollIntoView({behavior:'smooth', block:'nearest', inline:'nearest'});
      });
    }

    // Controls wiring: 1/2 + Name/Box clicks
    function find_groups_details_available_controlsInit(){
      $('#find_groups_details_available_btn_page1').on('click', ()=>find_groups_details_available_render(0));
      $('#find_groups_details_available_btn_page2').on('click', ()=>find_groups_details_available_render(1));

      // Clicking the names or whole boxes acts like 1 / 2 buttons:
      $('#find_groups_details_available_box_main_teacher, #find_groups_details_available_main_name')
        .on('click keypress', (e)=>{ if(e.type==='click' || e.key==='Enter') find_groups_details_available_render(0); });

      $('#find_groups_details_available_box_practice_teacher, #find_groups_details_available_practice_name')
        .on('click keypress', (e)=>{ if(e.type==='click' || e.key==='Enter') find_groups_details_available_render(1); });

      // Initial state
      find_groups_details_available_render(0);
    }

    $(function(){
      find_groups_details_available_likeToggle();
      find_groups_details_available_controlsInit();
      find_groups_details_available_detailsToggleInit();

      // (Optional) search hook for future list:
      $('#find_groups_details_available_search_input').on('input', function(){
        const q = $(this).val().toLowerCase();
        // hook when you have multiple cards
      });
    });
  </script>




<?php require_once("find_groups_book_trail_lesson.php");?>

</body>
</html>
