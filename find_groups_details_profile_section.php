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
      --fgda-peach:#FF2500;
    }
    html,body{font-family:Inter,system-ui,Segoe UI,Roboto,Helvetica,Arial,sans-serif;}
    .find_groups_details_available_card{border:1px solid #0000001F; border-radius:10px; background:#fff;    box-shadow: 0px 9.38px 21.56px 0px #00000008, 0px 88.13px 52.5px 0px #00000005, 0px 156.56px 62.81px 0px #00000000, 0px 244.69px 68.44px 0px #00000000;
      cursor: pointer;}
    .find_groups_details_available_card:hover{border:2px solid var(--fgda-border)}
    .find_groups_details_available_badge{font-size:14px; line-height:18px; padding:2px 10px; border-radius:4px; font-weight:400; display:inline-flex; align-items:center; white-space:nowrap; color: #121117}
    .find_groups_details_available_box{border:1px solid #DCDCE5; background:#fff;}
    .find_groups_details_available_num{width:36px; height:36px; border:1.5px solid var(--fgda-inner); border-radius:8px; display:flex; align-items:center; justify-content:center; font-weight:600; background:#fff;}
    .find_groups_details_available_input{border:1.5px solid #E4E7EE; border-radius:10px; height:46px; padding-left:40px; font-size:14px; box-shadow: none;}
    .find_groups_details_available_like svg{transition:transform .15s ease;}
    .find_groups_details_available_like:hover svg{transform:scale(1.05);}
    .find_groups_details_available_clickable{cursor:pointer;}
    /* .find_groups_details_available_active{outline:2px solid #919191; outline-offset:2px; border-radius:2px;} */

    /* --- Details / Review styles --- */
    .find_groups_details_available_review_card{
      border:1px solid var(--fgda-inner);
      border-radius:12px;
      background:#fff;
    }
    .find_groups_details_available_star{width:18px;height:18px}
    .find_groups_details_available_toggle_link{font-weight:600;}
    .teacher-name {
      font-weight: 600;
      font-size: 14px !important;
      color: #000000;
    }
    #find_groups_details_available_box_practice_teacher,
    #find_groups_details_available_box_schedule,
    #find_groups_details_available_box_students,
    #find_groups_details_available_box_main_teacher {
      padding: 11px !important;
    }
    #find_groups_details_available_students_max,
    #find_groups_details_available_main_lang,
    #find_groups_details_available_practice_lang {
      font-weight: 400;
      font-size: 14px !important;
      color: var(--fgda-muted)
    }
    #find_groups_details_available_footerline {
      display: none;
    }
    .s2-col:has(#find_groups_details_available_details.hidden) #find_groups_details_available_footerline{
         display: block
    }

    .find_groups_details_available_card:has(#find_groups_details_available_details.hidden) .find_groups_details_available_cta_stack{
      height: calc(100% - 100px) !important;
    }

    #glcm_take_test:hover,
    #glcm_click_here:hover,
    .find_groups_details_available_toggle_link:hover{
      color: var(--fgda-peach) !important;
    }


    #glcm_confirm:hover,
    #find_groups_book_trail_lesson_step4_btn_goback:hover,
    #find_groups_book_trail_lesson_step3_btn_confirm:hover,
    #find_groups_book_trail_lesson_step2_btn_continue:hover,
    .flow-next-btn:hover,
    .find_groups_details_available_btn_book:hover {
      background: rgba(255, 88, 60, 1) !important;
    }

    #find_groups_book_trail_lesson_step3_btn_cancel:hover,
    .find_groups_details_available_btn_message:hover {
    background:#f6f7fb !important;
    }
    .find_groups_details_available_like {
      z-index: 1;
    }
    .find_groups_details_available_like.is-liked path {
      fill: #000;
      stroke: #000;
    }
    .video-popup {
      position: fixed;
      inset: 0;
      background: rgba(0,0,0,0.7);
      display: none;
      z-index: 9999;
    }

    .video-wrapper {
      position: absolute;
      top: 50%;
      left: 50%;
      transform: translate(-50%, -50%);
      width: 80vw;
      max-width: 900px;
      aspect-ratio: 16 / 9;
      background: #000;
       border-radius: 3%;
    }

    .video-wrapper video {
      width: 100%;
      height: 100%;
      object-fit: cover;
      border-radius: 3%;
    }

    .video-close {
      position: absolute;
      top: 0px;
      right: 14px;
      color: #fff;
      font-size: 28px;
      cursor: pointer;
      z-index: 999;
    }

  </style>
</head>
<body class="bg-white text-[color:var(--fgda-text)]">

  <!-- =========================
       SECTION
       ========================= -->
  <section id="find_groups_details_available_section" style="margin-top: 24px; max-width: 1280px;
    margin: 0 auto;" class="poppins">
    <div id="find_groups_details_available_wrap">

      <!-- Heading + Search IN ONE ROW -->
      <div id="find_groups_details_available_search_bar_row"
           class="flex flex-col gap-3 md:flex-row md:items-center md:justify-between" style="margin-block: 24px;">
        <h2 id="find_groups_details_available_heading"
            class="text-[24px] leading-[34px] font-semibold">
          50 Groups Available
        </h2>

        <div id="find_groups_details_available_search_wrap" class="relative w-full md:w-[360px]">
          <span id="find_groups_details_available_search_icon"
                class="absolute left-3 top-1/2 -translate-y-1/2 text-[#98A2B3]">
                      <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                  <path fill-rule="evenodd" clip-rule="evenodd" d="M10.5001 0.962891C12.3006 0.962647 14.0661 1.46097 15.6007 2.40262C17.1353 3.34428 18.3792 4.69248 19.1945 6.2978C20.0099 7.90312 20.3647 9.70285 20.2198 11.4975C20.075 13.2922 19.4359 15.0117 18.3736 16.4654L22.8106 20.9024L20.6897 23.0249L16.2527 18.5864C15.0094 19.4945 13.5687 20.0952 12.0486 20.3394C10.5285 20.5837 8.97211 20.4644 7.50694 19.9915C6.04177 19.5185 4.70942 18.7054 3.61897 17.6185C2.52852 16.5316 1.71096 15.2019 1.23322 13.7383C0.755484 12.2747 0.631146 10.7187 0.870386 9.19784C1.10963 7.67693 1.70564 6.2343 2.60965 4.98803C3.51365 3.74177 4.69994 2.7273 6.07141 2.02768C7.44288 1.32806 8.96054 0.963176 10.5001 0.962891ZM10.5001 3.96289C9.61373 3.96289 8.73598 4.13748 7.91704 4.4767C7.09809 4.81592 6.35397 5.31312 5.72718 5.93992C5.10038 6.56672 4.60318 7.31083 4.26396 8.12978C3.92474 8.94873 3.75015 9.82647 3.75015 10.7129C3.75015 11.5993 3.92474 12.4771 4.26396 13.296C4.60318 14.115 5.10038 14.8591 5.72718 15.4859C6.35397 16.1127 7.09809 16.6099 7.91704 16.9491C8.73598 17.2883 9.61373 17.4629 10.5001 17.4629C12.2904 17.4629 14.0072 16.7517 15.2731 15.4859C16.539 14.22 17.2502 12.5031 17.2502 10.7129C17.2502 8.92268 16.539 7.20579 15.2731 5.93992C14.0072 4.67405 12.2904 3.96289 10.5001 3.96289Z" fill="#6A697C"/>
          </svg>
          </span>
          <input id="find_groups_details_available_search_input"
                 class="find_groups_details_available_input w-full"
                 placeholder="Search by name" type="text">
        </div>
      </div>

      <!-- Left & Right in one row -->
      <div id="find_groups_details_available_layout" class="grid grid-cols-1 lg:grid-cols-[1fr_364px] gap-8">

        <!-- ===== LEFT: MAIN CARD ===== -->
        <article id="find_groups_details_available_card" class="find_groups_details_available_card relative lg:h-[350px]" style="padding: 24px;">

          <!-- Heart -->
          <button id="find_groups_details_available_btn_like"
                  class="find_groups_details_available_like absolute top-4 right-4 w-9 h-9  flex items-center justify-center bg-white"
                  aria-label="Save">
            <svg xmlns="http://www.w3.org/2000/svg" class="w-[20px] h-[20px]" viewBox="0 0 24 24" fill="none" stroke="#111" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round">
              <path d="M20.84 4.61a5.5 5.5 0 0 0-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 1 0-7.78 7.78L12 21.23l8.84-8.84a5.5 5.5 0 0 0 0-7.78Z"/>
            </svg>
          </button>

          <!-- 3-column grid -->
          <div id="find_groups_details_available_card_grid" class="grid grid-cols-[160px_minmax(0,1fr)_260px] gap-4 items-start">

            <!-- Avatar + pager -->
            <div id="find_groups_details_available_avatar_col">
              <div id="find_groups_details_available_avatar_wrap" class="relative w-[160px] h-[160px]">
                <img id="find_groups_details_available_avatar_img"
                     src="https://images.unsplash.com/photo-1544006659-f0b21884ce1d?q=80&w=800&auto=format&fit=crop"
                     alt="Profile" class="w-full h-full object-cover rounded-[4px]">
                <span id="find_groups_details_available_online_dot"
                      class="absolute bottom-2 right-2 w-[18px] h-[18px] bg-[#14C38E] rounded-[4px] border-2 border-white"></span>
              </div>
              <div id="find_groups_details_available_pager" class="flex gap-3 mt-3">
                <button id="find_groups_details_available_btn_page1" class="find_groups_details_available_num ring-2 ring-black">1</button>
                <button id="find_groups_details_available_btn_page2" class="find_groups_details_available_num">2</button>
              </div>
            </div>

            <!-- Center content -->
            <div id="find_groups_details_available_center_col" class="min-w-0 s2-col" >
              <!-- Title single line -->
               <a href="find_group_profile_page.php">
                <h3 id="find_groups_details_available_title"
                    class="text-[20px] font-semibold whitespace-nowrap overflow-hidden text-ellipsis">
                  English Group Classes (Bilingual)
                </h3>
              </a>
              
              <!-- badges -->
              <div id="find_groups_details_available_badges"
                   class="mt-2 flex items-center gap-2 whitespace-nowrap">
                <span id="find_groups_details_available_badge_beginner" class="find_groups_details_available_badge"
                      style="background:#D8F8F2; color:#121117;">Begginer</span>
                <span id="find_groups_details_available_badge_lang" class="find_groups_details_available_badge"
                      style="background:#F8D8D8; color:#121117;">English &amp; Spanish</span>
                <span id="find_groups_details_available_badge_conv" class="find_groups_details_available_badge"
                      style="background:#E0D8F8; color:#121117;">Conversational (only)</span>
              </div>

              <!-- info boxes (names stay static) -->
              <div id="find_groups_details_available_info_grid" class="grid grid-cols-2 gap-3 text-[12px]" style="margin-top: 12px;">
                <div id="find_groups_details_available_box_main_teacher"
                     class="find_groups_details_available_box find_groups_details_available_clickable"
                     role="button" tabindex="0" aria-label="Show Main Teacher profile (1)">
                  <p class="text-[14px] text-[color:var(--fgda-muted)] mb-1">Main Teacher :</p>
                  <p id="find_groups_details_available_main_name" class="font-semibold teacher-name">Daniela Canelon</p>
                  <div class="flex items-center gap-2 mt-1 text-[color:var(--fgda-muted)]">
                    <svg width="16" height="16" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M12.0438 11.8642L11.3911 10.5586L10.7383 11.8642H12.0438Z" fill="#4D4C5C"/>
                        <path d="M14.5942 6.78242H13.9301V5.37733C13.9301 5.31178 13.9163 5.24696 13.8897 5.18706C13.8631 5.12716 13.8243 5.0735 13.7756 5.02955C13.727 4.98561 13.6697 4.95235 13.6074 4.93193C13.5451 4.9115 13.4792 4.90437 13.414 4.91098C13.3394 4.91855 11.6676 5.10761 10.8352 6.78242H10.1541V7.8102C10.1541 9.10223 9.10297 10.1534 7.81097 10.1534H6.78319V14.5935C6.78319 15.3685 7.41378 15.9991 8.18884 15.9991H14.5942C15.3693 15.9991 15.9999 15.3685 15.9999 14.5935V8.18811C15.9999 7.41302 15.3693 6.78242 14.5942 6.78242ZM9.09059 13.0628L10.9722 9.29952C11.0111 9.22164 11.071 9.15615 11.145 9.11038C11.2191 9.06461 11.3044 9.04036 11.3915 9.04036C11.4786 9.04036 11.5639 9.06461 11.638 9.11038C11.712 9.15615 11.7719 9.22164 11.8108 9.29952L13.6924 13.0628C13.8082 13.2944 13.7143 13.5759 13.4828 13.6917C13.2513 13.8075 12.9697 13.7136 12.8539 13.4821L12.5131 12.8004H10.27L9.92916 13.4821C9.84703 13.6463 9.68147 13.7413 9.50953 13.7413C9.43909 13.7413 9.36756 13.7254 9.30028 13.6917C9.06869 13.5759 8.97484 13.2944 9.09059 13.0628ZM5.05241 3.94727H4.16406C4.22206 4.41167 4.37072 4.80214 4.60825 5.11677C4.84575 4.80214 4.99441 4.41167 5.05241 3.94727Z" fill="#4D4C5C"/>
                        <path d="M7.81106 9.21672C8.58616 9.21672 9.21672 8.58613 9.21672 7.81107V1.40569C9.21672 0.630598 8.58612 3.89877e-06 7.81106 3.89877e-06H1.40569C0.630594 3.89877e-06 0 0.630598 0 1.40569V7.81107C0 8.58616 0.630594 9.21672 1.40566 9.21672H2.06978V10.6218C2.06978 10.6874 2.08353 10.7522 2.11014 10.8121C2.13675 10.872 2.17562 10.9256 2.22425 10.9696C2.27288 11.0135 2.33019 11.0468 2.39247 11.0672C2.45476 11.0876 2.52063 11.0948 2.58584 11.0882C2.66047 11.0806 4.33228 10.8915 5.16463 9.21672H7.81106ZM4.85819 6.52729C4.77276 6.48163 4.68941 6.43221 4.60838 6.37916C4.52734 6.43221 4.44399 6.48164 4.35856 6.52729C3.55875 6.95385 2.76034 6.95875 2.72675 6.95875C2.46788 6.95875 2.258 6.74888 2.258 6.49C2.258 6.23113 2.46788 6.02125 2.72675 6.02125C2.73088 6.02122 3.30922 6.01282 3.88469 5.71713C3.55544 5.2955 3.29594 4.72341 3.22097 3.94813H2.72672C2.46784 3.94813 2.25797 3.73825 2.25797 3.47938C2.25797 3.2205 2.46784 3.01063 2.72672 3.01063H4.13963V2.72672C4.13963 2.46785 4.3495 2.25797 4.60838 2.25797C4.86725 2.25797 5.07713 2.46785 5.07713 2.72672V3.01063H6.49C6.74887 3.01063 6.95875 3.2205 6.95875 3.47938C6.95875 3.73825 6.74887 3.94813 6.49 3.94813H5.99581C5.92081 4.72341 5.66134 5.2955 5.33209 5.71713C5.90753 6.01282 6.48597 6.02119 6.49194 6.02125C6.75081 6.02125 6.95972 6.23113 6.95972 6.49C6.95972 6.74888 6.74887 6.95875 6.49 6.95875C6.45641 6.95875 5.658 6.95388 4.85819 6.52729ZM11.4272 2.68185C11.5187 2.77338 11.6387 2.81916 11.7586 2.81916C11.8785 2.81916 11.9985 2.77341 12.09 2.68185C12.2731 2.49879 12.2731 2.202 12.09 2.01894L11.9555 1.88438C13.6807 1.9866 15.0531 3.42235 15.0531 5.17285C15.0531 5.43172 15.263 5.6416 15.5219 5.6416C15.7808 5.6416 15.9906 5.43172 15.9906 5.17285C15.9906 2.90182 14.1924 1.04313 11.9451 0.94516L12.09 0.800191C12.2731 0.617129 12.2731 0.320348 12.09 0.137285C11.907 -0.0457461 11.6102 -0.0457773 11.4271 0.137285L10.4863 1.07813C10.3033 1.26119 10.3033 1.55797 10.4863 1.74104L11.4272 2.68185ZM4.5635 13.3088C4.38047 13.1257 4.08366 13.1257 3.90059 13.3088C3.71753 13.4918 3.71753 13.7886 3.90059 13.9717L4.03516 14.1063C2.30988 14.0041 0.9375 12.5683 0.9375 10.8178C0.9375 10.5589 0.727625 10.349 0.46875 10.349C0.209875 10.349 0 10.5589 0 10.8178C0 13.0888 1.79822 14.9475 4.04556 15.0455L3.90059 15.1904C3.71753 15.3735 3.71753 15.6703 3.90059 15.8533C3.99213 15.9449 4.11209 15.9906 4.23203 15.9906C4.35197 15.9906 4.47197 15.9449 4.56347 15.8533L5.50428 14.9125C5.68734 14.7294 5.68734 14.4327 5.50428 14.2496L4.5635 13.3088Z" fill="#4D4C5C"/>
                    </svg>
  
                    <span id="find_groups_details_available_main_lang">English (Native)</span>
                  </div>
                </div>

                <div id="find_groups_details_available_box_practice_teacher"
                     class="find_groups_details_available_box find_groups_details_available_clickable"
                     role="button" tabindex="0" aria-label="Show Practice Teacher profile (2)">
                  <p class="text-[14px] text-[color:var(--fgda-muted)] mb-1">Practice Teacher :</p>
                  <p id="find_groups_details_available_practice_name" class="font-semibold teacher-name">Axley Perez</p>
                  <div class="flex items-center gap-2 mt-1 text-[color:var(--fgda-muted)]">
                    <svg width="16" height="16" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M12.0438 11.8642L11.3911 10.5586L10.7383 11.8642H12.0438Z" fill="#4D4C5C"/>
                        <path d="M14.5942 6.78242H13.9301V5.37733C13.9301 5.31178 13.9163 5.24696 13.8897 5.18706C13.8631 5.12716 13.8243 5.0735 13.7756 5.02955C13.727 4.98561 13.6697 4.95235 13.6074 4.93193C13.5451 4.9115 13.4792 4.90437 13.414 4.91098C13.3394 4.91855 11.6676 5.10761 10.8352 6.78242H10.1541V7.8102C10.1541 9.10223 9.10297 10.1534 7.81097 10.1534H6.78319V14.5935C6.78319 15.3685 7.41378 15.9991 8.18884 15.9991H14.5942C15.3693 15.9991 15.9999 15.3685 15.9999 14.5935V8.18811C15.9999 7.41302 15.3693 6.78242 14.5942 6.78242ZM9.09059 13.0628L10.9722 9.29952C11.0111 9.22164 11.071 9.15615 11.145 9.11038C11.2191 9.06461 11.3044 9.04036 11.3915 9.04036C11.4786 9.04036 11.5639 9.06461 11.638 9.11038C11.712 9.15615 11.7719 9.22164 11.8108 9.29952L13.6924 13.0628C13.8082 13.2944 13.7143 13.5759 13.4828 13.6917C13.2513 13.8075 12.9697 13.7136 12.8539 13.4821L12.5131 12.8004H10.27L9.92916 13.4821C9.84703 13.6463 9.68147 13.7413 9.50953 13.7413C9.43909 13.7413 9.36756 13.7254 9.30028 13.6917C9.06869 13.5759 8.97484 13.2944 9.09059 13.0628ZM5.05241 3.94727H4.16406C4.22206 4.41167 4.37072 4.80214 4.60825 5.11677C4.84575 4.80214 4.99441 4.41167 5.05241 3.94727Z" fill="#4D4C5C"/>
                        <path d="M7.81106 9.21672C8.58616 9.21672 9.21672 8.58613 9.21672 7.81107V1.40569C9.21672 0.630598 8.58612 3.89877e-06 7.81106 3.89877e-06H1.40569C0.630594 3.89877e-06 0 0.630598 0 1.40569V7.81107C0 8.58616 0.630594 9.21672 1.40566 9.21672H2.06978V10.6218C2.06978 10.6874 2.08353 10.7522 2.11014 10.8121C2.13675 10.872 2.17562 10.9256 2.22425 10.9696C2.27288 11.0135 2.33019 11.0468 2.39247 11.0672C2.45476 11.0876 2.52063 11.0948 2.58584 11.0882C2.66047 11.0806 4.33228 10.8915 5.16463 9.21672H7.81106ZM4.85819 6.52729C4.77276 6.48163 4.68941 6.43221 4.60838 6.37916C4.52734 6.43221 4.44399 6.48164 4.35856 6.52729C3.55875 6.95385 2.76034 6.95875 2.72675 6.95875C2.46788 6.95875 2.258 6.74888 2.258 6.49C2.258 6.23113 2.46788 6.02125 2.72675 6.02125C2.73088 6.02122 3.30922 6.01282 3.88469 5.71713C3.55544 5.2955 3.29594 4.72341 3.22097 3.94813H2.72672C2.46784 3.94813 2.25797 3.73825 2.25797 3.47938C2.25797 3.2205 2.46784 3.01063 2.72672 3.01063H4.13963V2.72672C4.13963 2.46785 4.3495 2.25797 4.60838 2.25797C4.86725 2.25797 5.07713 2.46785 5.07713 2.72672V3.01063H6.49C6.74887 3.01063 6.95875 3.2205 6.95875 3.47938C6.95875 3.73825 6.74887 3.94813 6.49 3.94813H5.99581C5.92081 4.72341 5.66134 5.2955 5.33209 5.71713C5.90753 6.01282 6.48597 6.02119 6.49194 6.02125C6.75081 6.02125 6.95972 6.23113 6.95972 6.49C6.95972 6.74888 6.74887 6.95875 6.49 6.95875C6.45641 6.95875 5.658 6.95388 4.85819 6.52729ZM11.4272 2.68185C11.5187 2.77338 11.6387 2.81916 11.7586 2.81916C11.8785 2.81916 11.9985 2.77341 12.09 2.68185C12.2731 2.49879 12.2731 2.202 12.09 2.01894L11.9555 1.88438C13.6807 1.9866 15.0531 3.42235 15.0531 5.17285C15.0531 5.43172 15.263 5.6416 15.5219 5.6416C15.7808 5.6416 15.9906 5.43172 15.9906 5.17285C15.9906 2.90182 14.1924 1.04313 11.9451 0.94516L12.09 0.800191C12.2731 0.617129 12.2731 0.320348 12.09 0.137285C11.907 -0.0457461 11.6102 -0.0457773 11.4271 0.137285L10.4863 1.07813C10.3033 1.26119 10.3033 1.55797 10.4863 1.74104L11.4272 2.68185ZM4.5635 13.3088C4.38047 13.1257 4.08366 13.1257 3.90059 13.3088C3.71753 13.4918 3.71753 13.7886 3.90059 13.9717L4.03516 14.1063C2.30988 14.0041 0.9375 12.5683 0.9375 10.8178C0.9375 10.5589 0.727625 10.349 0.46875 10.349C0.209875 10.349 0 10.5589 0 10.8178C0 13.0888 1.79822 14.9475 4.04556 15.0455L3.90059 15.1904C3.71753 15.3735 3.71753 15.6703 3.90059 15.8533C3.99213 15.9449 4.11209 15.9906 4.23203 15.9906C4.35197 15.9906 4.47197 15.9449 4.56347 15.8533L5.50428 14.9125C5.68734 14.7294 5.68734 14.4327 5.50428 14.2496L4.5635 13.3088Z" fill="#4D4C5C"/>
                    </svg>  
                  <span id="find_groups_details_available_practice_lang">English (Native)</span>
                  </div>
                </div>

                <div id="find_groups_details_available_box_students" class="find_groups_details_available_box p-3">
                  <p class="text-[14px] text-[color:var(--fgda-muted)] mb-1">Students</p>
                  <p class="font-semibold flex items-center gap-2">
                    <svg width="15" height="17" viewBox="0 0 15 17" fill="none" xmlns="http://www.w3.org/2000/svg">
                      <path d="M6.91347 8.10589C8.02705 8.10589 8.99134 7.70647 9.77924 6.91843C10.5671 6.13057 10.9665 5.16653 10.9665 4.05283C10.9665 2.93945 10.5671 1.97532 9.77911 1.18716C8.99108 0.39939 8.02692 0 6.91347 0C5.79974 0 4.83567 0.39939 4.0478 1.18729C3.25994 1.97519 2.86038 2.93936 2.86038 4.05283C2.86038 5.16653 3.2599 6.1307 4.04794 6.9186C4.83597 7.70637 5.80013 8.10589 6.91347 8.10589ZM14.0052 12.9395C13.9825 12.6116 13.9366 12.2539 13.8689 11.8763C13.8006 11.4957 13.7127 11.136 13.6074 10.8072C13.4986 10.4674 13.3507 10.1318 13.1679 9.81017C12.9782 9.47638 12.7553 9.18571 12.5052 8.94654C12.2437 8.69633 11.9235 8.49516 11.5532 8.34838C11.1843 8.20245 10.7754 8.1285 10.338 8.1285C10.1662 8.1285 10.0001 8.19897 9.67923 8.40786C9.45117 8.55637 9.22243 8.70383 8.99302 8.85024C8.77258 8.99071 8.47396 9.12231 8.1051 9.24145C7.74525 9.35789 7.37988 9.41695 7.01924 9.41695C6.65863 9.41695 6.29335 9.35789 5.93311 9.24145C5.56468 9.12241 5.26606 8.99085 5.04585 8.85038C4.79048 8.68719 4.55943 8.53828 4.35901 8.4077C4.03857 8.19884 3.8723 8.12834 3.70054 8.12834C3.26299 8.12834 2.85424 8.20242 2.48538 8.34854C2.11537 8.49503 1.79506 8.6962 1.53328 8.94667C1.28333 9.18597 1.06033 9.47648 0.870826 9.81017C0.688156 10.1318 0.540258 10.4672 0.431372 10.8073C0.3262 11.1361 0.238283 11.4957 0.169987 11.8763C0.102316 12.2534 0.0563686 12.6113 0.0336252 12.9399C0.0110008 13.2707 -0.000213241 13.6021 3.07016e-06 13.9336C3.07016e-06 14.812 0.279234 15.5231 0.829875 16.0475C1.37371 16.5651 2.09328 16.8276 2.96835 16.8276H11.0709C11.946 16.8276 12.6653 16.5652 13.2093 16.0476C13.76 15.5235 14.0393 14.8123 14.0393 13.9335C14.0391 13.5944 14.0277 13.26 14.0052 12.9395Z" fill="#4D4C5C"/>
                    </svg>
 
                  <span id="find_groups_details_available_students_active" class= "teacher-name mt-1">4 Active ,</span>
                  </p>
                  <p id="find_groups_details_available_students_max" class="text-[color:var(--fgda-muted)]">Max 10</p>
                </div>

                <div id="find_groups_details_available_box_schedule" class="find_groups_details_available_box p-3">
                  <p class="text-[14px] text-[color:var(--fgda-muted)] mb-1">Schedule :</p>
                  <p id="find_groups_details_available_schedule_1" class="font-semibold teacher-name">Mon, Wed, – 8 PM EST</p>
                  <p id="find_groups_details_available_schedule_2" class="font-semibold teacher-name">Fri – 8 PM EST</p>
                </div>
              </div>

              <!-- footer -->
              <div id="find_groups_details_available_footerline" class="mt-3 flex items-center justify-between text-[14px]">
                <p id="find_groups_details_available_footer_text" class="text-[color:var(--fgda-muted)]">
                  Certified tutor and polyglot with 5 year
                  <span style="margin-left: 15px; font-weight:600;">
                    <a href="#" id="find_groups_details_available_toggle" class="find_groups_details_available_toggle_link" style="color: #000000">See More...</a>
                  </span>
                </p>
              </div>

              <!-- EXPANDABLE DETAILS (hidden by default) -->
              <div id="find_groups_details_available_details" class="hidden mt-3">
                <!-- Full bio paragraph -->
                <p class="text-[16px] leading-6 text-[color:var(--fgda-text)]">
                  Certified tutor and polyglot with 5 years of experience — Hello there! I am Nicholas. I’m a digital nomad and I am 25.
                  I love teaching and I have been doing so for about 5 years. I have a currently pursuing a bachelor’s degree in Political
                  Science at the University of Maine. A fun fact about me is that apart from speaking 9 languages, I have traveled to over
                  60 countries.
                </p>

                <!-- Why Choose -->
                <h4 class="mt-3 font-semibold text-[14px]">Why Choose English Group Classes (Bilingual)</h4>

                <!-- Review card -->
                <div class="find_groups_details_available_review_card mt-3 p-3">
                  <div class="flex items-start gap-3">
                    <img src="https://images.unsplash.com/photo-1502685104226-ee32379fefbe?q=80&w=256&auto=format&fit=crop"
                         alt="Efren" class="w-12 h-12 rounded-md object-cover"/>
                    <div class="flex-1 min-w-0">
                      <div class="">
                        <div class="">Efren</div>
                        <div class="text-[12px] text-[color:var(--fgda-muted)]">September 14, 2024</div>
                      </div>
                  </div>
                  </div>
                      <!-- Stars -->
                      <div class="flex gap-1" style="margin-top: 12px;">
                        <svg class="find_groups_details_available_star" viewBox="0 0 24 24" fill="currentColor"><path d="M12 17.27 18.18 21l-1.64-7.03L22 9.24l-7.19-.62L12 2 9.19 8.62 2 9.24l5.46 4.73L5.82 21 12 17.27Z"/></svg>
                        <svg class="find_groups_details_available_star" viewBox="0 0 24 24" fill="currentColor"><path d="M12 17.27 18.18 21l-1.64-7.03L22 9.24l-7.19-.62L12 2 9.19 8.62 2 9.24l5.46 4.73L5.82 21 12 17.27Z"/></svg>
                        <svg class="find_groups_details_available_star" viewBox="0 0 24 24" fill="currentColor"><path d="M12 17.27 18.18 21l-1.64-7.03L22 9.24l-7.19-.62L12 2 9.19 8.62 2 9.24l5.46 4.73L5.82 21 12 17.27Z"/></svg>
                        <svg class="find_groups_details_available_star" viewBox="0 0 24 24" fill="currentColor"><path d="M12 17.27 18.18 21l-1.64-7.03L22 9.24l-7.19-.62L12 2 9.19 8.62 2 9.24l5.46 4.73L5.82 21 12 17.27Z"/></svg>
                        <svg class="find_groups_details_available_star" viewBox="0 0 24 24" fill="currentColor"><path d="M12 17.27 18.18 21l-1.64-7.03L22 9.24l-7.19-.62L12 2 9.19 8.62 2 9.24l5.46 4.73L5.82 21 12 17.27Z"/></svg>
                      </div>

                      <p class="text-[14px] leading-6 text-[color:var(--fgda-muted)]" style="margin-top: 12px;">
                        He is an excellent teacher with incredible patience and effective teaching methods.
                        The classes are comprehensive, engaging, and dynamic. I truly enjoy learning English with him!
                      </p>
                  </div>
                

                <!-- Hide link -->
                <div class="mt-4 text-left">
                  <a href="#" style="color: #000000; text-decoration: underline" id="find_groups_details_available_hide" class="find_groups_details_available_toggle_link underline decoration-transparent hover:decoration-inherit">Hide Details</a>
                </div>
              </div>
            </div>

            <!-- Right: rating/price + CTAs (black borders on CTAs) -->
            <div id="find_groups_details_available_side_col" style=" padding-left: 9px; position: relative; height: 100%;">
              <div id="find_groups_details_available_rating_price" class="flex items-start gap-8" style="justify-content: end;
              position: relative;
              top: 22%;
              right: 0%;">
                <div>
                  <div class="flex items-center gap-2">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-[18px] h-[18px]" viewBox="0 0 24 24" fill="currentColor"><path d="M12 17.27 18.18 21l-1.64-7.03L22 9.24l-7.19-.62L12 2 9.19 8.62 2 9.24l5.46 4.73L5.82 21 12 17.27Z"/></svg>
                    <span id="find_groups_details_available_rating_value" class="text-[21px] font-semibold">4.7</span>
                  </div>
                  <div id="find_groups_details_available_reviews_text" class="text-[14px] text-[color:var(--fgda-muted)] mt-1">8 reviews</div>
                </div>
                <div>
                  <div id="find_groups_details_available_price_value" class="text-[21px] font-semibold">$70</div>
                  <div id="find_groups_details_available_price_cycle" class="text-[14px] text-[color:var(--fgda-muted)]  mt-1">Monthly</div>
                </div>
              </div>

              <div id="find_groups_details_available_cta_stack" class="find_groups_details_available_cta_stack flex flex-col gap-3" style="height: calc(100% - 112px);
              width: 100%;
              justify-content: end;">
                <button id="find_groups_details_available_btn_book"
                        class="find_groups_details_available_btn_book w-full h-[48px] rounded-[10px] font-semibold bg-[var(--fgda-peach)] text-white border-2 border-black">
                  Book trial lesson
                </button>
                <button id="find_groups_details_available_btn_message"
                        class="w-full h-[48px] rounded-[10px] font-semibold bg-white border-2 border-black find_groups_details_available_btn_message">
                  Send a Message
                </button>
              </div>
            </div>
          </div>
        </article>

        <!-- ===== RIGHT: image mirrors left ===== -->
        <aside id="find_groups_details_available_right_rail" style="max-height: 306px;">
          <div id="find_groups_details_available_video_card" class="relative rounded-[10px] overflow-hidden shadow-[0_8px_32px_rgba(18,17,23,.10)]" style="height:306px">
            <img id="find_groups_details_available_video_img"
                 src="https://images.unsplash.com/photo-1544006659-f0b21884ce1d?q=80&w=1600&auto=format&fit=crop"
                 class="w-full h-[350px] object-cover" alt="profile large">
            <button id="find_groups_details_available_btn_play"
                    class="absolute right-5 bottom-5 w-[54px] h-[54px] rounded-full bg-[var(--fgda-peach)] text-white flex items-center justify-center"
                    aria-label="Play">
              <svg xmlns="http://www.w3.org/2000/svg" class="w-[30px] h-[30px]" viewBox="0 0 24 24" fill="currentColor"><path d="M8 5v14l11-7z"/></svg>
            </button>
          </div>
        </aside>

      </div>

       <!-- Left & Right in one row -->
      <div id="find_groups_details_available_layout" class="grid grid-cols-1 lg:grid-cols-[1fr_364px] gap-8 mt-4">

        <!-- ===== LEFT: MAIN CARD ===== -->
        <article id="find_groups_details_available_card" class="find_groups_details_available_card relative lg:h-[350px]" style="padding: 24px;">

          <!-- Heart -->
          <button id="find_groups_details_available_btn_like"
                  class="find_groups_details_available_like absolute top-4 right-4 w-9 h-9  flex items-center justify-center bg-white"
                  aria-label="Save">
            <svg xmlns="http://www.w3.org/2000/svg" class="w-[20px] h-[20px]" viewBox="0 0 24 24" fill="none" stroke="#111" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round">
              <path d="M20.84 4.61a5.5 5.5 0 0 0-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 1 0-7.78 7.78L12 21.23l8.84-8.84a5.5 5.5 0 0 0 0-7.78Z"/>
            </svg>
          </button>

          <!-- 3-column grid -->
          <div id="find_groups_details_available_card_grid" class="grid grid-cols-[160px_minmax(0,1fr)_260px] gap-4 items-start">

            <!-- Avatar + pager -->
            <div id="find_groups_details_available_avatar_col">
              <div id="find_groups_details_available_avatar_wrap" class="relative w-[160px] h-[160px]">
                <img id="find_groups_details_available_avatar_img"
                     src="https://images.unsplash.com/photo-1544006659-f0b21884ce1d?q=80&w=800&auto=format&fit=crop"
                     alt="Profile" class="w-full h-full object-cover rounded-[4px]">
                <span id="find_groups_details_available_online_dot"
                      class="absolute bottom-2 right-2 w-[18px] h-[18px] bg-[#14C38E] rounded-[4px] border-2 border-white"></span>
              </div>
              <div id="find_groups_details_available_pager" class="flex gap-3 mt-3">
                <button id="find_groups_details_available_btn_page1" class="find_groups_details_available_num ring-2 ring-black">1</button>
                <button id="find_groups_details_available_btn_page2" class="find_groups_details_available_num">2</button>
              </div>
            </div>

            <!-- Center content -->
            <div id="find_groups_details_available_center_col" class="min-w-0 s2-col" >
              <!-- Title single line -->
               <a href="find_group_profile_page.php">
                <h3 id="find_groups_details_available_title"
                    class="text-[20px] font-semibold whitespace-nowrap overflow-hidden text-ellipsis">
                  English Group Classes (Bilingual)
                </h3>
              </a>
              <!-- badges -->
              <div id="find_groups_details_available_badges"
                   class="mt-2 flex items-center gap-2 whitespace-nowrap">
                <span id="find_groups_details_available_badge_beginner" class="find_groups_details_available_badge"
                      style="background:#D8F8F2; color:#121117;">Begginer</span>
                <span id="find_groups_details_available_badge_lang" class="find_groups_details_available_badge"
                      style="background:#F8D8D8; color:#121117;">English &amp; Spanish</span>
                <span id="find_groups_details_available_badge_conv" class="find_groups_details_available_badge"
                      style="background:#E0D8F8; color:#121117;">Conversational (only)</span>
              </div>

              <!-- info boxes (names stay static) -->
              <div id="find_groups_details_available_info_grid" class="grid grid-cols-2 gap-3 text-[12px]" style="margin-top: 12px;">
                <div id="find_groups_details_available_box_main_teacher"
                     class="find_groups_details_available_box find_groups_details_available_clickable"
                     role="button" tabindex="0" aria-label="Show Main Teacher profile (1)">
                  <p class="text-[14px] text-[color:var(--fgda-muted)] mb-1">Main Teacher :</p>
                  <p id="find_groups_details_available_main_name" class="font-semibold teacher-name">Daniela Canelon</p>
                  <div class="flex items-center gap-2 mt-1 text-[color:var(--fgda-muted)]">
                    <svg width="16" height="16" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M12.0438 11.8642L11.3911 10.5586L10.7383 11.8642H12.0438Z" fill="#4D4C5C"/>
                        <path d="M14.5942 6.78242H13.9301V5.37733C13.9301 5.31178 13.9163 5.24696 13.8897 5.18706C13.8631 5.12716 13.8243 5.0735 13.7756 5.02955C13.727 4.98561 13.6697 4.95235 13.6074 4.93193C13.5451 4.9115 13.4792 4.90437 13.414 4.91098C13.3394 4.91855 11.6676 5.10761 10.8352 6.78242H10.1541V7.8102C10.1541 9.10223 9.10297 10.1534 7.81097 10.1534H6.78319V14.5935C6.78319 15.3685 7.41378 15.9991 8.18884 15.9991H14.5942C15.3693 15.9991 15.9999 15.3685 15.9999 14.5935V8.18811C15.9999 7.41302 15.3693 6.78242 14.5942 6.78242ZM9.09059 13.0628L10.9722 9.29952C11.0111 9.22164 11.071 9.15615 11.145 9.11038C11.2191 9.06461 11.3044 9.04036 11.3915 9.04036C11.4786 9.04036 11.5639 9.06461 11.638 9.11038C11.712 9.15615 11.7719 9.22164 11.8108 9.29952L13.6924 13.0628C13.8082 13.2944 13.7143 13.5759 13.4828 13.6917C13.2513 13.8075 12.9697 13.7136 12.8539 13.4821L12.5131 12.8004H10.27L9.92916 13.4821C9.84703 13.6463 9.68147 13.7413 9.50953 13.7413C9.43909 13.7413 9.36756 13.7254 9.30028 13.6917C9.06869 13.5759 8.97484 13.2944 9.09059 13.0628ZM5.05241 3.94727H4.16406C4.22206 4.41167 4.37072 4.80214 4.60825 5.11677C4.84575 4.80214 4.99441 4.41167 5.05241 3.94727Z" fill="#4D4C5C"/>
                        <path d="M7.81106 9.21672C8.58616 9.21672 9.21672 8.58613 9.21672 7.81107V1.40569C9.21672 0.630598 8.58612 3.89877e-06 7.81106 3.89877e-06H1.40569C0.630594 3.89877e-06 0 0.630598 0 1.40569V7.81107C0 8.58616 0.630594 9.21672 1.40566 9.21672H2.06978V10.6218C2.06978 10.6874 2.08353 10.7522 2.11014 10.8121C2.13675 10.872 2.17562 10.9256 2.22425 10.9696C2.27288 11.0135 2.33019 11.0468 2.39247 11.0672C2.45476 11.0876 2.52063 11.0948 2.58584 11.0882C2.66047 11.0806 4.33228 10.8915 5.16463 9.21672H7.81106ZM4.85819 6.52729C4.77276 6.48163 4.68941 6.43221 4.60838 6.37916C4.52734 6.43221 4.44399 6.48164 4.35856 6.52729C3.55875 6.95385 2.76034 6.95875 2.72675 6.95875C2.46788 6.95875 2.258 6.74888 2.258 6.49C2.258 6.23113 2.46788 6.02125 2.72675 6.02125C2.73088 6.02122 3.30922 6.01282 3.88469 5.71713C3.55544 5.2955 3.29594 4.72341 3.22097 3.94813H2.72672C2.46784 3.94813 2.25797 3.73825 2.25797 3.47938C2.25797 3.2205 2.46784 3.01063 2.72672 3.01063H4.13963V2.72672C4.13963 2.46785 4.3495 2.25797 4.60838 2.25797C4.86725 2.25797 5.07713 2.46785 5.07713 2.72672V3.01063H6.49C6.74887 3.01063 6.95875 3.2205 6.95875 3.47938C6.95875 3.73825 6.74887 3.94813 6.49 3.94813H5.99581C5.92081 4.72341 5.66134 5.2955 5.33209 5.71713C5.90753 6.01282 6.48597 6.02119 6.49194 6.02125C6.75081 6.02125 6.95972 6.23113 6.95972 6.49C6.95972 6.74888 6.74887 6.95875 6.49 6.95875C6.45641 6.95875 5.658 6.95388 4.85819 6.52729ZM11.4272 2.68185C11.5187 2.77338 11.6387 2.81916 11.7586 2.81916C11.8785 2.81916 11.9985 2.77341 12.09 2.68185C12.2731 2.49879 12.2731 2.202 12.09 2.01894L11.9555 1.88438C13.6807 1.9866 15.0531 3.42235 15.0531 5.17285C15.0531 5.43172 15.263 5.6416 15.5219 5.6416C15.7808 5.6416 15.9906 5.43172 15.9906 5.17285C15.9906 2.90182 14.1924 1.04313 11.9451 0.94516L12.09 0.800191C12.2731 0.617129 12.2731 0.320348 12.09 0.137285C11.907 -0.0457461 11.6102 -0.0457773 11.4271 0.137285L10.4863 1.07813C10.3033 1.26119 10.3033 1.55797 10.4863 1.74104L11.4272 2.68185ZM4.5635 13.3088C4.38047 13.1257 4.08366 13.1257 3.90059 13.3088C3.71753 13.4918 3.71753 13.7886 3.90059 13.9717L4.03516 14.1063C2.30988 14.0041 0.9375 12.5683 0.9375 10.8178C0.9375 10.5589 0.727625 10.349 0.46875 10.349C0.209875 10.349 0 10.5589 0 10.8178C0 13.0888 1.79822 14.9475 4.04556 15.0455L3.90059 15.1904C3.71753 15.3735 3.71753 15.6703 3.90059 15.8533C3.99213 15.9449 4.11209 15.9906 4.23203 15.9906C4.35197 15.9906 4.47197 15.9449 4.56347 15.8533L5.50428 14.9125C5.68734 14.7294 5.68734 14.4327 5.50428 14.2496L4.5635 13.3088Z" fill="#4D4C5C"/>
                    </svg>
  
                    <span id="find_groups_details_available_main_lang">English (Native)</span>
                  </div>
                </div>

                <div id="find_groups_details_available_box_practice_teacher"
                     class="find_groups_details_available_box find_groups_details_available_clickable"
                     role="button" tabindex="0" aria-label="Show Practice Teacher profile (2)">
                  <p class="text-[14px] text-[color:var(--fgda-muted)] mb-1">Practice Teacher :</p>
                  <p id="find_groups_details_available_practice_name" class="font-semibold teacher-name">Axley Perez</p>
                  <div class="flex items-center gap-2 mt-1 text-[color:var(--fgda-muted)]">
                    <svg width="16" height="16" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M12.0438 11.8642L11.3911 10.5586L10.7383 11.8642H12.0438Z" fill="#4D4C5C"/>
                        <path d="M14.5942 6.78242H13.9301V5.37733C13.9301 5.31178 13.9163 5.24696 13.8897 5.18706C13.8631 5.12716 13.8243 5.0735 13.7756 5.02955C13.727 4.98561 13.6697 4.95235 13.6074 4.93193C13.5451 4.9115 13.4792 4.90437 13.414 4.91098C13.3394 4.91855 11.6676 5.10761 10.8352 6.78242H10.1541V7.8102C10.1541 9.10223 9.10297 10.1534 7.81097 10.1534H6.78319V14.5935C6.78319 15.3685 7.41378 15.9991 8.18884 15.9991H14.5942C15.3693 15.9991 15.9999 15.3685 15.9999 14.5935V8.18811C15.9999 7.41302 15.3693 6.78242 14.5942 6.78242ZM9.09059 13.0628L10.9722 9.29952C11.0111 9.22164 11.071 9.15615 11.145 9.11038C11.2191 9.06461 11.3044 9.04036 11.3915 9.04036C11.4786 9.04036 11.5639 9.06461 11.638 9.11038C11.712 9.15615 11.7719 9.22164 11.8108 9.29952L13.6924 13.0628C13.8082 13.2944 13.7143 13.5759 13.4828 13.6917C13.2513 13.8075 12.9697 13.7136 12.8539 13.4821L12.5131 12.8004H10.27L9.92916 13.4821C9.84703 13.6463 9.68147 13.7413 9.50953 13.7413C9.43909 13.7413 9.36756 13.7254 9.30028 13.6917C9.06869 13.5759 8.97484 13.2944 9.09059 13.0628ZM5.05241 3.94727H4.16406C4.22206 4.41167 4.37072 4.80214 4.60825 5.11677C4.84575 4.80214 4.99441 4.41167 5.05241 3.94727Z" fill="#4D4C5C"/>
                        <path d="M7.81106 9.21672C8.58616 9.21672 9.21672 8.58613 9.21672 7.81107V1.40569C9.21672 0.630598 8.58612 3.89877e-06 7.81106 3.89877e-06H1.40569C0.630594 3.89877e-06 0 0.630598 0 1.40569V7.81107C0 8.58616 0.630594 9.21672 1.40566 9.21672H2.06978V10.6218C2.06978 10.6874 2.08353 10.7522 2.11014 10.8121C2.13675 10.872 2.17562 10.9256 2.22425 10.9696C2.27288 11.0135 2.33019 11.0468 2.39247 11.0672C2.45476 11.0876 2.52063 11.0948 2.58584 11.0882C2.66047 11.0806 4.33228 10.8915 5.16463 9.21672H7.81106ZM4.85819 6.52729C4.77276 6.48163 4.68941 6.43221 4.60838 6.37916C4.52734 6.43221 4.44399 6.48164 4.35856 6.52729C3.55875 6.95385 2.76034 6.95875 2.72675 6.95875C2.46788 6.95875 2.258 6.74888 2.258 6.49C2.258 6.23113 2.46788 6.02125 2.72675 6.02125C2.73088 6.02122 3.30922 6.01282 3.88469 5.71713C3.55544 5.2955 3.29594 4.72341 3.22097 3.94813H2.72672C2.46784 3.94813 2.25797 3.73825 2.25797 3.47938C2.25797 3.2205 2.46784 3.01063 2.72672 3.01063H4.13963V2.72672C4.13963 2.46785 4.3495 2.25797 4.60838 2.25797C4.86725 2.25797 5.07713 2.46785 5.07713 2.72672V3.01063H6.49C6.74887 3.01063 6.95875 3.2205 6.95875 3.47938C6.95875 3.73825 6.74887 3.94813 6.49 3.94813H5.99581C5.92081 4.72341 5.66134 5.2955 5.33209 5.71713C5.90753 6.01282 6.48597 6.02119 6.49194 6.02125C6.75081 6.02125 6.95972 6.23113 6.95972 6.49C6.95972 6.74888 6.74887 6.95875 6.49 6.95875C6.45641 6.95875 5.658 6.95388 4.85819 6.52729ZM11.4272 2.68185C11.5187 2.77338 11.6387 2.81916 11.7586 2.81916C11.8785 2.81916 11.9985 2.77341 12.09 2.68185C12.2731 2.49879 12.2731 2.202 12.09 2.01894L11.9555 1.88438C13.6807 1.9866 15.0531 3.42235 15.0531 5.17285C15.0531 5.43172 15.263 5.6416 15.5219 5.6416C15.7808 5.6416 15.9906 5.43172 15.9906 5.17285C15.9906 2.90182 14.1924 1.04313 11.9451 0.94516L12.09 0.800191C12.2731 0.617129 12.2731 0.320348 12.09 0.137285C11.907 -0.0457461 11.6102 -0.0457773 11.4271 0.137285L10.4863 1.07813C10.3033 1.26119 10.3033 1.55797 10.4863 1.74104L11.4272 2.68185ZM4.5635 13.3088C4.38047 13.1257 4.08366 13.1257 3.90059 13.3088C3.71753 13.4918 3.71753 13.7886 3.90059 13.9717L4.03516 14.1063C2.30988 14.0041 0.9375 12.5683 0.9375 10.8178C0.9375 10.5589 0.727625 10.349 0.46875 10.349C0.209875 10.349 0 10.5589 0 10.8178C0 13.0888 1.79822 14.9475 4.04556 15.0455L3.90059 15.1904C3.71753 15.3735 3.71753 15.6703 3.90059 15.8533C3.99213 15.9449 4.11209 15.9906 4.23203 15.9906C4.35197 15.9906 4.47197 15.9449 4.56347 15.8533L5.50428 14.9125C5.68734 14.7294 5.68734 14.4327 5.50428 14.2496L4.5635 13.3088Z" fill="#4D4C5C"/>
                    </svg>  
                  <span id="find_groups_details_available_practice_lang">English (Native)</span>
                  </div>
                </div>

                <div id="find_groups_details_available_box_students" class="find_groups_details_available_box p-3">
                  <p class="text-[14px] text-[color:var(--fgda-muted)] mb-1">Students</p>
                  <p class="font-semibold flex items-center gap-2">
                    <svg width="15" height="17" viewBox="0 0 15 17" fill="none" xmlns="http://www.w3.org/2000/svg">
                      <path d="M6.91347 8.10589C8.02705 8.10589 8.99134 7.70647 9.77924 6.91843C10.5671 6.13057 10.9665 5.16653 10.9665 4.05283C10.9665 2.93945 10.5671 1.97532 9.77911 1.18716C8.99108 0.39939 8.02692 0 6.91347 0C5.79974 0 4.83567 0.39939 4.0478 1.18729C3.25994 1.97519 2.86038 2.93936 2.86038 4.05283C2.86038 5.16653 3.2599 6.1307 4.04794 6.9186C4.83597 7.70637 5.80013 8.10589 6.91347 8.10589ZM14.0052 12.9395C13.9825 12.6116 13.9366 12.2539 13.8689 11.8763C13.8006 11.4957 13.7127 11.136 13.6074 10.8072C13.4986 10.4674 13.3507 10.1318 13.1679 9.81017C12.9782 9.47638 12.7553 9.18571 12.5052 8.94654C12.2437 8.69633 11.9235 8.49516 11.5532 8.34838C11.1843 8.20245 10.7754 8.1285 10.338 8.1285C10.1662 8.1285 10.0001 8.19897 9.67923 8.40786C9.45117 8.55637 9.22243 8.70383 8.99302 8.85024C8.77258 8.99071 8.47396 9.12231 8.1051 9.24145C7.74525 9.35789 7.37988 9.41695 7.01924 9.41695C6.65863 9.41695 6.29335 9.35789 5.93311 9.24145C5.56468 9.12241 5.26606 8.99085 5.04585 8.85038C4.79048 8.68719 4.55943 8.53828 4.35901 8.4077C4.03857 8.19884 3.8723 8.12834 3.70054 8.12834C3.26299 8.12834 2.85424 8.20242 2.48538 8.34854C2.11537 8.49503 1.79506 8.6962 1.53328 8.94667C1.28333 9.18597 1.06033 9.47648 0.870826 9.81017C0.688156 10.1318 0.540258 10.4672 0.431372 10.8073C0.3262 11.1361 0.238283 11.4957 0.169987 11.8763C0.102316 12.2534 0.0563686 12.6113 0.0336252 12.9399C0.0110008 13.2707 -0.000213241 13.6021 3.07016e-06 13.9336C3.07016e-06 14.812 0.279234 15.5231 0.829875 16.0475C1.37371 16.5651 2.09328 16.8276 2.96835 16.8276H11.0709C11.946 16.8276 12.6653 16.5652 13.2093 16.0476C13.76 15.5235 14.0393 14.8123 14.0393 13.9335C14.0391 13.5944 14.0277 13.26 14.0052 12.9395Z" fill="#4D4C5C"/>
                    </svg>
 
                  <span id="find_groups_details_available_students_active" class= "teacher-name mt-1">4 Active ,</span>
                  </p>
                  <p id="find_groups_details_available_students_max" class="text-[color:var(--fgda-muted)]">Max 10</p>
                </div>

                <div id="find_groups_details_available_box_schedule" class="find_groups_details_available_box p-3">
                  <p class="text-[14px] text-[color:var(--fgda-muted)] mb-1">Schedule :</p>
                  <p id="find_groups_details_available_schedule_1" class="font-semibold teacher-name">Mon, Wed, – 8 PM EST</p>
                  <p id="find_groups_details_available_schedule_2" class="font-semibold teacher-name">Fri – 8 PM EST</p>
                </div>
              </div>

              <!-- footer -->
              <div id="find_groups_details_available_footerline" class="mt-3 flex items-center justify-between text-[14px]">
                <p id="find_groups_details_available_footer_text" class="text-[color:var(--fgda-muted)]">
                  Certified tutor and polyglot with 5 year
                  <span style="margin-left: 15px; font-weight:600;">
                    <a href="#" id="find_groups_details_available_toggle" class="find_groups_details_available_toggle_link" style="color: #000000">See More...</a>
                  </span>
                </p>
              </div>

              <!-- EXPANDABLE DETAILS (hidden by default) -->
              <div id="find_groups_details_available_details" class="hidden mt-3">
                <!-- Full bio paragraph -->
                <p class="text-[16px] leading-6 text-[color:var(--fgda-text)]">
                  Certified tutor and polyglot with 5 years of experience — Hello there! I am Nicholas. I’m a digital nomad and I am 25.
                  I love teaching and I have been doing so for about 5 years. I have a currently pursuing a bachelor’s degree in Political
                  Science at the University of Maine. A fun fact about me is that apart from speaking 9 languages, I have traveled to over
                  60 countries.
                </p>

                <!-- Why Choose -->
                <h4 class="mt-3 font-semibold text-[14px]">Why Choose English Group Classes (Bilingual)</h4>

                <!-- Review card -->
                <div class="find_groups_details_available_review_card mt-3 p-3">
                  <div class="flex items-start gap-3">
                    <img src="https://images.unsplash.com/photo-1502685104226-ee32379fefbe?q=80&w=256&auto=format&fit=crop"
                         alt="Efren" class="w-12 h-12 rounded-md object-cover"/>
                    <div class="flex-1 min-w-0">
                      <div class="">
                        <div class="">Efren</div>
                        <div class="text-[12px] text-[color:var(--fgda-muted)]">September 14, 2024</div>
                      </div>
                  </div>
                  </div>
                      <!-- Stars -->
                      <div class="flex gap-1" style="margin-top: 12px;">
                        <svg class="find_groups_details_available_star" viewBox="0 0 24 24" fill="currentColor"><path d="M12 17.27 18.18 21l-1.64-7.03L22 9.24l-7.19-.62L12 2 9.19 8.62 2 9.24l5.46 4.73L5.82 21 12 17.27Z"/></svg>
                        <svg class="find_groups_details_available_star" viewBox="0 0 24 24" fill="currentColor"><path d="M12 17.27 18.18 21l-1.64-7.03L22 9.24l-7.19-.62L12 2 9.19 8.62 2 9.24l5.46 4.73L5.82 21 12 17.27Z"/></svg>
                        <svg class="find_groups_details_available_star" viewBox="0 0 24 24" fill="currentColor"><path d="M12 17.27 18.18 21l-1.64-7.03L22 9.24l-7.19-.62L12 2 9.19 8.62 2 9.24l5.46 4.73L5.82 21 12 17.27Z"/></svg>
                        <svg class="find_groups_details_available_star" viewBox="0 0 24 24" fill="currentColor"><path d="M12 17.27 18.18 21l-1.64-7.03L22 9.24l-7.19-.62L12 2 9.19 8.62 2 9.24l5.46 4.73L5.82 21 12 17.27Z"/></svg>
                        <svg class="find_groups_details_available_star" viewBox="0 0 24 24" fill="currentColor"><path d="M12 17.27 18.18 21l-1.64-7.03L22 9.24l-7.19-.62L12 2 9.19 8.62 2 9.24l5.46 4.73L5.82 21 12 17.27Z"/></svg>
                      </div>

                      <p class="text-[14px] leading-6 text-[color:var(--fgda-muted)]" style="margin-top: 12px;">
                        He is an excellent teacher with incredible patience and effective teaching methods.
                        The classes are comprehensive, engaging, and dynamic. I truly enjoy learning English with him!
                      </p>
                  </div>
                

                <!-- Hide link -->
                <div class="mt-4 text-left">
                  <a href="#" style="color: #000000;text-decoration: underline" id="find_groups_details_available_hide" class="find_groups_details_available_toggle_link underline decoration-transparent hover:decoration-inherit">Hide Details</a>
                </div>
              </div>
            </div>

            <!-- Right: rating/price + CTAs (black borders on CTAs) -->
            <div id="find_groups_details_available_side_col" style=" padding-left: 9px; position: relative; height: 100%;">
              <div id="find_groups_details_available_rating_price" class="flex items-start gap-8" style="justify-content: end;
              position: relative;
              top: 22%;
              right: 0%;">
                <div>
                  <div class="flex items-center gap-2">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-[18px] h-[18px]" viewBox="0 0 24 24" fill="currentColor"><path d="M12 17.27 18.18 21l-1.64-7.03L22 9.24l-7.19-.62L12 2 9.19 8.62 2 9.24l5.46 4.73L5.82 21 12 17.27Z"/></svg>
                    <span id="find_groups_details_available_rating_value" class="text-[21px] font-semibold">4.7</span>
                  </div>
                  <div id="find_groups_details_available_reviews_text" class="text-[14px] text-[color:var(--fgda-muted)] mt-1">8 reviews</div>
                </div>
                <div>
                  <div id="find_groups_details_available_price_value" class="text-[21px] font-semibold">$70</div>
                  <div id="find_groups_details_available_price_cycle" class="text-[14px] text-[color:var(--fgda-muted)]  mt-1">Monthly</div>
                </div>
              </div>

              <div id="find_groups_details_available_cta_stack" class="find_groups_details_available_cta_stack flex flex-col gap-3" style="height: calc(100% - 112px);
              width: 100%;
              justify-content: end;">
                <button id="find_groups_details_available_btn_book"
                        class="find_groups_details_available_btn_book w-full h-[48px] rounded-[10px] font-semibold bg-[var(--fgda-peach)] text-white border-2 border-black">
                  Book trial lesson
                </button>
                <button id="find_groups_details_available_btn_message"
                        class="w-full h-[48px] rounded-[10px] font-semibold bg-white border-2 border-black find_groups_details_available_btn_message">
                  Send a Message
                </button>
              </div>
            </div>
          </div>
        </article>

        <!-- ===== RIGHT: image mirrors left ===== -->
        <aside id="find_groups_details_available_right_rail" style="max-height: 306px;">
          <div id="find_groups_details_available_video_card" class="relative rounded-[10px] overflow-hidden shadow-[0_8px_32px_rgba(18,17,23,.10)]" style="height:306px">
            <img id="find_groups_details_available_video_img"
                 src="https://images.unsplash.com/photo-1544006659-f0b21884ce1d?q=80&w=1600&auto=format&fit=crop"
                 class="w-full h-[350px] object-cover" alt="profile large">
            <button id="find_groups_details_available_btn_play"
                    class="absolute right-5 bottom-5 w-[54px] h-[54px] rounded-full bg-[var(--fgda-peach)] text-white flex items-center justify-center"
                    aria-label="Play">
              <svg xmlns="http://www.w3.org/2000/svg" class="w-[30px] h-[30px]" viewBox="0 0 24 24" fill="currentColor"><path d="M8 5v14l11-7z"/></svg>
            </button>
          </div>
        </aside>

      </div>

        <!-- Left & Right in one row -->
      <div id="find_groups_details_available_layout" class="grid grid-cols-1 lg:grid-cols-[1fr_364px] gap-8 mt-4">

        <!-- ===== LEFT: MAIN CARD ===== -->
        <article id="find_groups_details_available_card" class="find_groups_details_available_card relative lg:h-[350px]" style="padding: 24px;">

          <!-- Heart -->
          <button id="find_groups_details_available_btn_like"
                  class="find_groups_details_available_like absolute top-4 right-4 w-9 h-9  flex items-center justify-center bg-white"
                  aria-label="Save">
            <svg xmlns="http://www.w3.org/2000/svg" class="w-[20px] h-[20px]" viewBox="0 0 24 24" fill="none" stroke="#111" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round">
              <path d="M20.84 4.61a5.5 5.5 0 0 0-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 1 0-7.78 7.78L12 21.23l8.84-8.84a5.5 5.5 0 0 0 0-7.78Z"/>
            </svg>
          </button>

          <!-- 3-column grid -->
          <div id="find_groups_details_available_card_grid" class="grid grid-cols-[160px_minmax(0,1fr)_260px] gap-4 items-start">

            <!-- Avatar + pager -->
            <div id="find_groups_details_available_avatar_col">
              <div id="find_groups_details_available_avatar_wrap" class="relative w-[160px] h-[160px]">
                <img id="find_groups_details_available_avatar_img"
                     src="https://images.unsplash.com/photo-1544006659-f0b21884ce1d?q=80&w=800&auto=format&fit=crop"
                     alt="Profile" class="w-full h-full object-cover rounded-[4px]">
                <span id="find_groups_details_available_online_dot"
                      class="absolute bottom-2 right-2 w-[18px] h-[18px] bg-[#14C38E] rounded-[4px] border-2 border-white"></span>
              </div>
              <div id="find_groups_details_available_pager" class="flex gap-3 mt-3">
                <button id="find_groups_details_available_btn_page1" class="find_groups_details_available_num">1</button>
                <button id="find_groups_details_available_btn_page2" class="find_groups_details_available_num">2</button>
              </div>
            </div>

            <!-- Center content -->
            <div id="find_groups_details_available_center_col" class="min-w-0 s2-col" >
              <!-- Title single line -->
              <a href="find_group_profile_page.php">
                <h3 id="find_groups_details_available_title"
                    class="text-[20px] font-semibold whitespace-nowrap overflow-hidden text-ellipsis">
                  English Group Classes (Bilingual)
                </h3>
              </a>
              <!-- badges -->
              <div id="find_groups_details_available_badges"
                   class="mt-2 flex items-center gap-2 whitespace-nowrap">
                <span id="find_groups_details_available_badge_beginner" class="find_groups_details_available_badge"
                      style="background:#D8F8F2; color:#121117;">Begginer</span>
                <span id="find_groups_details_available_badge_lang" class="find_groups_details_available_badge"
                      style="background:#F8D8D8; color:#121117;">English &amp; Spanish</span>
                <span id="find_groups_details_available_badge_conv" class="find_groups_details_available_badge"
                      style="background:#E0D8F8; color:#121117;">Conversational (only)</span>
              </div>

              <!-- info boxes (names stay static) -->
              <div id="find_groups_details_available_info_grid" class="grid grid-cols-2 gap-3 text-[12px]" style="margin-top: 12px;">
                <div id="find_groups_details_available_box_main_teacher"
                     class="find_groups_details_available_box find_groups_details_available_clickable"
                     role="button" tabindex="0" aria-label="Show Main Teacher profile (1)">
                  <p class="text-[14px] text-[color:var(--fgda-muted)] mb-1">Main Teacher :</p>
                  <p id="find_groups_details_available_main_name" class="font-semibold teacher-name">Daniela Canelon</p>
                  <div class="flex items-center gap-2 mt-1 text-[color:var(--fgda-muted)]">
                    <svg width="16" height="16" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M12.0438 11.8642L11.3911 10.5586L10.7383 11.8642H12.0438Z" fill="#4D4C5C"/>
                        <path d="M14.5942 6.78242H13.9301V5.37733C13.9301 5.31178 13.9163 5.24696 13.8897 5.18706C13.8631 5.12716 13.8243 5.0735 13.7756 5.02955C13.727 4.98561 13.6697 4.95235 13.6074 4.93193C13.5451 4.9115 13.4792 4.90437 13.414 4.91098C13.3394 4.91855 11.6676 5.10761 10.8352 6.78242H10.1541V7.8102C10.1541 9.10223 9.10297 10.1534 7.81097 10.1534H6.78319V14.5935C6.78319 15.3685 7.41378 15.9991 8.18884 15.9991H14.5942C15.3693 15.9991 15.9999 15.3685 15.9999 14.5935V8.18811C15.9999 7.41302 15.3693 6.78242 14.5942 6.78242ZM9.09059 13.0628L10.9722 9.29952C11.0111 9.22164 11.071 9.15615 11.145 9.11038C11.2191 9.06461 11.3044 9.04036 11.3915 9.04036C11.4786 9.04036 11.5639 9.06461 11.638 9.11038C11.712 9.15615 11.7719 9.22164 11.8108 9.29952L13.6924 13.0628C13.8082 13.2944 13.7143 13.5759 13.4828 13.6917C13.2513 13.8075 12.9697 13.7136 12.8539 13.4821L12.5131 12.8004H10.27L9.92916 13.4821C9.84703 13.6463 9.68147 13.7413 9.50953 13.7413C9.43909 13.7413 9.36756 13.7254 9.30028 13.6917C9.06869 13.5759 8.97484 13.2944 9.09059 13.0628ZM5.05241 3.94727H4.16406C4.22206 4.41167 4.37072 4.80214 4.60825 5.11677C4.84575 4.80214 4.99441 4.41167 5.05241 3.94727Z" fill="#4D4C5C"/>
                        <path d="M7.81106 9.21672C8.58616 9.21672 9.21672 8.58613 9.21672 7.81107V1.40569C9.21672 0.630598 8.58612 3.89877e-06 7.81106 3.89877e-06H1.40569C0.630594 3.89877e-06 0 0.630598 0 1.40569V7.81107C0 8.58616 0.630594 9.21672 1.40566 9.21672H2.06978V10.6218C2.06978 10.6874 2.08353 10.7522 2.11014 10.8121C2.13675 10.872 2.17562 10.9256 2.22425 10.9696C2.27288 11.0135 2.33019 11.0468 2.39247 11.0672C2.45476 11.0876 2.52063 11.0948 2.58584 11.0882C2.66047 11.0806 4.33228 10.8915 5.16463 9.21672H7.81106ZM4.85819 6.52729C4.77276 6.48163 4.68941 6.43221 4.60838 6.37916C4.52734 6.43221 4.44399 6.48164 4.35856 6.52729C3.55875 6.95385 2.76034 6.95875 2.72675 6.95875C2.46788 6.95875 2.258 6.74888 2.258 6.49C2.258 6.23113 2.46788 6.02125 2.72675 6.02125C2.73088 6.02122 3.30922 6.01282 3.88469 5.71713C3.55544 5.2955 3.29594 4.72341 3.22097 3.94813H2.72672C2.46784 3.94813 2.25797 3.73825 2.25797 3.47938C2.25797 3.2205 2.46784 3.01063 2.72672 3.01063H4.13963V2.72672C4.13963 2.46785 4.3495 2.25797 4.60838 2.25797C4.86725 2.25797 5.07713 2.46785 5.07713 2.72672V3.01063H6.49C6.74887 3.01063 6.95875 3.2205 6.95875 3.47938C6.95875 3.73825 6.74887 3.94813 6.49 3.94813H5.99581C5.92081 4.72341 5.66134 5.2955 5.33209 5.71713C5.90753 6.01282 6.48597 6.02119 6.49194 6.02125C6.75081 6.02125 6.95972 6.23113 6.95972 6.49C6.95972 6.74888 6.74887 6.95875 6.49 6.95875C6.45641 6.95875 5.658 6.95388 4.85819 6.52729ZM11.4272 2.68185C11.5187 2.77338 11.6387 2.81916 11.7586 2.81916C11.8785 2.81916 11.9985 2.77341 12.09 2.68185C12.2731 2.49879 12.2731 2.202 12.09 2.01894L11.9555 1.88438C13.6807 1.9866 15.0531 3.42235 15.0531 5.17285C15.0531 5.43172 15.263 5.6416 15.5219 5.6416C15.7808 5.6416 15.9906 5.43172 15.9906 5.17285C15.9906 2.90182 14.1924 1.04313 11.9451 0.94516L12.09 0.800191C12.2731 0.617129 12.2731 0.320348 12.09 0.137285C11.907 -0.0457461 11.6102 -0.0457773 11.4271 0.137285L10.4863 1.07813C10.3033 1.26119 10.3033 1.55797 10.4863 1.74104L11.4272 2.68185ZM4.5635 13.3088C4.38047 13.1257 4.08366 13.1257 3.90059 13.3088C3.71753 13.4918 3.71753 13.7886 3.90059 13.9717L4.03516 14.1063C2.30988 14.0041 0.9375 12.5683 0.9375 10.8178C0.9375 10.5589 0.727625 10.349 0.46875 10.349C0.209875 10.349 0 10.5589 0 10.8178C0 13.0888 1.79822 14.9475 4.04556 15.0455L3.90059 15.1904C3.71753 15.3735 3.71753 15.6703 3.90059 15.8533C3.99213 15.9449 4.11209 15.9906 4.23203 15.9906C4.35197 15.9906 4.47197 15.9449 4.56347 15.8533L5.50428 14.9125C5.68734 14.7294 5.68734 14.4327 5.50428 14.2496L4.5635 13.3088Z" fill="#4D4C5C"/>
                    </svg>
  
                    <span id="find_groups_details_available_main_lang">English (Native)</span>
                  </div>
                </div>

                <div id="find_groups_details_available_box_practice_teacher"
                     class="find_groups_details_available_box find_groups_details_available_clickable"
                     role="button" tabindex="0" aria-label="Show Practice Teacher profile (2)">
                  <p class="text-[14px] text-[color:var(--fgda-muted)] mb-1">Practice Teacher :</p>
                  <p id="find_groups_details_available_practice_name" class="font-semibold teacher-name">Axley Perez</p>
                  <div class="flex items-center gap-2 mt-1 text-[color:var(--fgda-muted)]">
                    <svg width="16" height="16" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M12.0438 11.8642L11.3911 10.5586L10.7383 11.8642H12.0438Z" fill="#4D4C5C"/>
                        <path d="M14.5942 6.78242H13.9301V5.37733C13.9301 5.31178 13.9163 5.24696 13.8897 5.18706C13.8631 5.12716 13.8243 5.0735 13.7756 5.02955C13.727 4.98561 13.6697 4.95235 13.6074 4.93193C13.5451 4.9115 13.4792 4.90437 13.414 4.91098C13.3394 4.91855 11.6676 5.10761 10.8352 6.78242H10.1541V7.8102C10.1541 9.10223 9.10297 10.1534 7.81097 10.1534H6.78319V14.5935C6.78319 15.3685 7.41378 15.9991 8.18884 15.9991H14.5942C15.3693 15.9991 15.9999 15.3685 15.9999 14.5935V8.18811C15.9999 7.41302 15.3693 6.78242 14.5942 6.78242ZM9.09059 13.0628L10.9722 9.29952C11.0111 9.22164 11.071 9.15615 11.145 9.11038C11.2191 9.06461 11.3044 9.04036 11.3915 9.04036C11.4786 9.04036 11.5639 9.06461 11.638 9.11038C11.712 9.15615 11.7719 9.22164 11.8108 9.29952L13.6924 13.0628C13.8082 13.2944 13.7143 13.5759 13.4828 13.6917C13.2513 13.8075 12.9697 13.7136 12.8539 13.4821L12.5131 12.8004H10.27L9.92916 13.4821C9.84703 13.6463 9.68147 13.7413 9.50953 13.7413C9.43909 13.7413 9.36756 13.7254 9.30028 13.6917C9.06869 13.5759 8.97484 13.2944 9.09059 13.0628ZM5.05241 3.94727H4.16406C4.22206 4.41167 4.37072 4.80214 4.60825 5.11677C4.84575 4.80214 4.99441 4.41167 5.05241 3.94727Z" fill="#4D4C5C"/>
                        <path d="M7.81106 9.21672C8.58616 9.21672 9.21672 8.58613 9.21672 7.81107V1.40569C9.21672 0.630598 8.58612 3.89877e-06 7.81106 3.89877e-06H1.40569C0.630594 3.89877e-06 0 0.630598 0 1.40569V7.81107C0 8.58616 0.630594 9.21672 1.40566 9.21672H2.06978V10.6218C2.06978 10.6874 2.08353 10.7522 2.11014 10.8121C2.13675 10.872 2.17562 10.9256 2.22425 10.9696C2.27288 11.0135 2.33019 11.0468 2.39247 11.0672C2.45476 11.0876 2.52063 11.0948 2.58584 11.0882C2.66047 11.0806 4.33228 10.8915 5.16463 9.21672H7.81106ZM4.85819 6.52729C4.77276 6.48163 4.68941 6.43221 4.60838 6.37916C4.52734 6.43221 4.44399 6.48164 4.35856 6.52729C3.55875 6.95385 2.76034 6.95875 2.72675 6.95875C2.46788 6.95875 2.258 6.74888 2.258 6.49C2.258 6.23113 2.46788 6.02125 2.72675 6.02125C2.73088 6.02122 3.30922 6.01282 3.88469 5.71713C3.55544 5.2955 3.29594 4.72341 3.22097 3.94813H2.72672C2.46784 3.94813 2.25797 3.73825 2.25797 3.47938C2.25797 3.2205 2.46784 3.01063 2.72672 3.01063H4.13963V2.72672C4.13963 2.46785 4.3495 2.25797 4.60838 2.25797C4.86725 2.25797 5.07713 2.46785 5.07713 2.72672V3.01063H6.49C6.74887 3.01063 6.95875 3.2205 6.95875 3.47938C6.95875 3.73825 6.74887 3.94813 6.49 3.94813H5.99581C5.92081 4.72341 5.66134 5.2955 5.33209 5.71713C5.90753 6.01282 6.48597 6.02119 6.49194 6.02125C6.75081 6.02125 6.95972 6.23113 6.95972 6.49C6.95972 6.74888 6.74887 6.95875 6.49 6.95875C6.45641 6.95875 5.658 6.95388 4.85819 6.52729ZM11.4272 2.68185C11.5187 2.77338 11.6387 2.81916 11.7586 2.81916C11.8785 2.81916 11.9985 2.77341 12.09 2.68185C12.2731 2.49879 12.2731 2.202 12.09 2.01894L11.9555 1.88438C13.6807 1.9866 15.0531 3.42235 15.0531 5.17285C15.0531 5.43172 15.263 5.6416 15.5219 5.6416C15.7808 5.6416 15.9906 5.43172 15.9906 5.17285C15.9906 2.90182 14.1924 1.04313 11.9451 0.94516L12.09 0.800191C12.2731 0.617129 12.2731 0.320348 12.09 0.137285C11.907 -0.0457461 11.6102 -0.0457773 11.4271 0.137285L10.4863 1.07813C10.3033 1.26119 10.3033 1.55797 10.4863 1.74104L11.4272 2.68185ZM4.5635 13.3088C4.38047 13.1257 4.08366 13.1257 3.90059 13.3088C3.71753 13.4918 3.71753 13.7886 3.90059 13.9717L4.03516 14.1063C2.30988 14.0041 0.9375 12.5683 0.9375 10.8178C0.9375 10.5589 0.727625 10.349 0.46875 10.349C0.209875 10.349 0 10.5589 0 10.8178C0 13.0888 1.79822 14.9475 4.04556 15.0455L3.90059 15.1904C3.71753 15.3735 3.71753 15.6703 3.90059 15.8533C3.99213 15.9449 4.11209 15.9906 4.23203 15.9906C4.35197 15.9906 4.47197 15.9449 4.56347 15.8533L5.50428 14.9125C5.68734 14.7294 5.68734 14.4327 5.50428 14.2496L4.5635 13.3088Z" fill="#4D4C5C"/>
                    </svg>  
                  <span id="find_groups_details_available_practice_lang">English (Native)</span>
                  </div>
                </div>

                <div id="find_groups_details_available_box_students" class="find_groups_details_available_box p-3">
                  <p class="text-[14px] text-[color:var(--fgda-muted)] mb-1">Students</p>
                  <p class="font-semibold flex items-center gap-2">
                    <svg width="15" height="17" viewBox="0 0 15 17" fill="none" xmlns="http://www.w3.org/2000/svg">
                      <path d="M6.91347 8.10589C8.02705 8.10589 8.99134 7.70647 9.77924 6.91843C10.5671 6.13057 10.9665 5.16653 10.9665 4.05283C10.9665 2.93945 10.5671 1.97532 9.77911 1.18716C8.99108 0.39939 8.02692 0 6.91347 0C5.79974 0 4.83567 0.39939 4.0478 1.18729C3.25994 1.97519 2.86038 2.93936 2.86038 4.05283C2.86038 5.16653 3.2599 6.1307 4.04794 6.9186C4.83597 7.70637 5.80013 8.10589 6.91347 8.10589ZM14.0052 12.9395C13.9825 12.6116 13.9366 12.2539 13.8689 11.8763C13.8006 11.4957 13.7127 11.136 13.6074 10.8072C13.4986 10.4674 13.3507 10.1318 13.1679 9.81017C12.9782 9.47638 12.7553 9.18571 12.5052 8.94654C12.2437 8.69633 11.9235 8.49516 11.5532 8.34838C11.1843 8.20245 10.7754 8.1285 10.338 8.1285C10.1662 8.1285 10.0001 8.19897 9.67923 8.40786C9.45117 8.55637 9.22243 8.70383 8.99302 8.85024C8.77258 8.99071 8.47396 9.12231 8.1051 9.24145C7.74525 9.35789 7.37988 9.41695 7.01924 9.41695C6.65863 9.41695 6.29335 9.35789 5.93311 9.24145C5.56468 9.12241 5.26606 8.99085 5.04585 8.85038C4.79048 8.68719 4.55943 8.53828 4.35901 8.4077C4.03857 8.19884 3.8723 8.12834 3.70054 8.12834C3.26299 8.12834 2.85424 8.20242 2.48538 8.34854C2.11537 8.49503 1.79506 8.6962 1.53328 8.94667C1.28333 9.18597 1.06033 9.47648 0.870826 9.81017C0.688156 10.1318 0.540258 10.4672 0.431372 10.8073C0.3262 11.1361 0.238283 11.4957 0.169987 11.8763C0.102316 12.2534 0.0563686 12.6113 0.0336252 12.9399C0.0110008 13.2707 -0.000213241 13.6021 3.07016e-06 13.9336C3.07016e-06 14.812 0.279234 15.5231 0.829875 16.0475C1.37371 16.5651 2.09328 16.8276 2.96835 16.8276H11.0709C11.946 16.8276 12.6653 16.5652 13.2093 16.0476C13.76 15.5235 14.0393 14.8123 14.0393 13.9335C14.0391 13.5944 14.0277 13.26 14.0052 12.9395Z" fill="#4D4C5C"/>
                    </svg>
 
                  <span id="find_groups_details_available_students_active" class= "teacher-name mt-1">4 Active ,</span>
                  </p>
                  <p id="find_groups_details_available_students_max" class="text-[color:var(--fgda-muted)]">Max 10</p>
                </div>

                <div id="find_groups_details_available_box_schedule" class="find_groups_details_available_box p-3">
                  <p class="text-[14px] text-[color:var(--fgda-muted)] mb-1">Schedule :</p>
                  <p id="find_groups_details_available_schedule_1" class="font-semibold teacher-name">Mon, Wed, – 8 PM EST</p>
                  <p id="find_groups_details_available_schedule_2" class="font-semibold teacher-name">Fri – 8 PM EST</p>
                </div>
              </div>

              <!-- footer -->
              <div id="find_groups_details_available_footerline" class="mt-3 flex items-center justify-between text-[14px]">
                <p id="find_groups_details_available_footer_text" class="text-[color:var(--fgda-muted)]">
                  Certified tutor and polyglot with 5 year
                  <span style="margin-left: 15px; font-weight:600;">
                    <a href="#" id="find_groups_details_available_toggle" class="find_groups_details_available_toggle_link" style="color: #000000">See More...</a>
                  </span>
                </p>
              </div>

              <!-- EXPANDABLE DETAILS (hidden by default) -->
              <div id="find_groups_details_available_details" class="hidden mt-3">
                <!-- Full bio paragraph -->
                <p class="text-[16px] leading-6 text-[color:var(--fgda-text)]">
                  Certified tutor and polyglot with 5 years of experience — Hello there! I am Nicholas. I’m a digital nomad and I am 25.
                  I love teaching and I have been doing so for about 5 years. I have a currently pursuing a bachelor’s degree in Political
                  Science at the University of Maine. A fun fact about me is that apart from speaking 9 languages, I have traveled to over
                  60 countries.
                </p>

                <!-- Why Choose -->
                <h4 class="mt-3 font-semibold text-[14px]">Why Choose English Group Classes (Bilingual)</h4>

                <!-- Review card -->
                <div class="find_groups_details_available_review_card mt-3 p-3">
                  <div class="flex items-start gap-3">
                    <img src="https://images.unsplash.com/photo-1502685104226-ee32379fefbe?q=80&w=256&auto=format&fit=crop"
                         alt="Efren" class="w-12 h-12 rounded-md object-cover"/>
                    <div class="flex-1 min-w-0">
                      <div class="">
                        <div class="">Efren</div>
                        <div class="text-[12px] text-[color:var(--fgda-muted)]">September 14, 2024</div>
                      </div>
                  </div>
                  </div>
                      <!-- Stars -->
                      <div class="flex gap-1" style="margin-top: 12px;">
                        <svg class="find_groups_details_available_star" viewBox="0 0 24 24" fill="currentColor"><path d="M12 17.27 18.18 21l-1.64-7.03L22 9.24l-7.19-.62L12 2 9.19 8.62 2 9.24l5.46 4.73L5.82 21 12 17.27Z"/></svg>
                        <svg class="find_groups_details_available_star" viewBox="0 0 24 24" fill="currentColor"><path d="M12 17.27 18.18 21l-1.64-7.03L22 9.24l-7.19-.62L12 2 9.19 8.62 2 9.24l5.46 4.73L5.82 21 12 17.27Z"/></svg>
                        <svg class="find_groups_details_available_star" viewBox="0 0 24 24" fill="currentColor"><path d="M12 17.27 18.18 21l-1.64-7.03L22 9.24l-7.19-.62L12 2 9.19 8.62 2 9.24l5.46 4.73L5.82 21 12 17.27Z"/></svg>
                        <svg class="find_groups_details_available_star" viewBox="0 0 24 24" fill="currentColor"><path d="M12 17.27 18.18 21l-1.64-7.03L22 9.24l-7.19-.62L12 2 9.19 8.62 2 9.24l5.46 4.73L5.82 21 12 17.27Z"/></svg>
                        <svg class="find_groups_details_available_star" viewBox="0 0 24 24" fill="currentColor"><path d="M12 17.27 18.18 21l-1.64-7.03L22 9.24l-7.19-.62L12 2 9.19 8.62 2 9.24l5.46 4.73L5.82 21 12 17.27Z"/></svg>
                      </div>

                      <p class="text-[14px] leading-6 text-[color:var(--fgda-muted)]" style="margin-top: 12px;">
                        He is an excellent teacher with incredible patience and effective teaching methods.
                        The classes are comprehensive, engaging, and dynamic. I truly enjoy learning English with him!
                      </p>
                  </div>
                

                <!-- Hide link -->
                <div class="mt-4 text-left">
                  <a href="#" style="color: #000000;text-decoration: underline" id="find_groups_details_available_hide" class="find_groups_details_available_toggle_link underline decoration-transparent hover:decoration-inherit">Hide Details</a>
                </div>
              </div>
            </div>

            <!-- Right: rating/price + CTAs (black borders on CTAs) -->
            <div id="find_groups_details_available_side_col" style=" padding-left: 9px; position: relative; height: 100%;">
              <div id="find_groups_details_available_rating_price" class="flex items-start gap-8" style="justify-content: end;
              position: relative;
              top: 22%;
              right: 0%;">
                <div>
                  <div class="flex items-center gap-2">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-[18px] h-[18px]" viewBox="0 0 24 24" fill="currentColor"><path d="M12 17.27 18.18 21l-1.64-7.03L22 9.24l-7.19-.62L12 2 9.19 8.62 2 9.24l5.46 4.73L5.82 21 12 17.27Z"/></svg>
                    <span id="find_groups_details_available_rating_value" class="text-[21px] font-semibold">4.7</span>
                  </div>
                  <div id="find_groups_details_available_reviews_text" class="text-[14px] text-[color:var(--fgda-muted)] mt-1">8 reviews</div>
                </div>
                <div>
                  <div id="find_groups_details_available_price_value" class="text-[21px] font-semibold">$70</div>
                  <div id="find_groups_details_available_price_cycle" class="text-[14px] text-[color:var(--fgda-muted)]  mt-1">Monthly</div>
                </div>
              </div>

              <div id="find_groups_details_available_cta_stack" class="find_groups_details_available_cta_stack flex flex-col gap-3" style="height: calc(100% - 112px);
              width: 100%;
              justify-content: end;">
                <button id="find_groups_details_available_btn_book"
                        class="find_groups_details_available_btn_book w-full h-[48px] rounded-[10px] font-semibold bg-[var(--fgda-peach)] text-white border-2 border-black">
                  Book trial lesson
                </button>
                <button id="find_groups_details_available_btn_message"
                        class="w-full h-[48px] rounded-[10px] font-semibold bg-white border-2 border-black find_groups_details_available_btn_message">
                  Send a Message
                </button>
              </div>
            </div>
          </div>
        </article>

        <!-- ===== RIGHT: image mirrors left ===== -->
        <aside id="find_groups_details_available_right_rail" style="max-height: 306px;">
          <div id="find_groups_details_available_video_card" class="relative rounded-[10px] overflow-hidden shadow-[0_8px_32px_rgba(18,17,23,.10)]" style="height:306px">
            <img id="find_groups_details_available_video_img"
                 src="https://images.unsplash.com/photo-1544006659-f0b21884ce1d?q=80&w=1600&auto=format&fit=crop"
                 class="w-full h-[350px] object-cover" alt="profile large">
            <button id="find_groups_details_available_btn_play"
                    class="absolute right-5 bottom-5 w-[54px] h-[54px] rounded-full bg-[var(--fgda-peach)] text-white flex items-center justify-center"
                    aria-label="Play">
              <svg xmlns="http://www.w3.org/2000/svg" class="w-[30px] h-[30px]" viewBox="0 0 24 24" fill="currentColor"><path d="M8 5v14l11-7z"/></svg>
            </button>
          </div>
        </aside>

      </div>

    </div>
  </section>
    <!-- video popup -->
    <div id="videoPopup" class="video-popup">
      <div class="video-wrapper">
        <span class="video-close">&times;</span>
        <video controls>
          <source src="video.mp4" type="video/mp4">
        </video>
      </div>
    </div>

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
    // function find_groups_details_available_likeToggle(){
    //   $('#find_groups_details_available_btn_like').on('click', function(){
    //     $(this).toggleClass('is-liked');
    //     const liked = $(this).hasClass('is-liked');
    //     const $path = $('path', this);
    //     $path.attr('fill', liked ? '#F23C2A' : 'none')
    //          .attr('stroke', liked ? '#F23C2A' : '#111');
    //   });
    // }
    $(document).on('click', '.find_groups_details_available_like', function () {
      $(this).toggleClass('is-liked');
    });

    // Expand / Collapse details
    function find_groups_details_available_detailsToggleInit(){
      const $card = $('#find_groups_details_available_card');
      const fixedHClass = 'lg:h-[350px]';

      function expand(){
        $('#find_groups_details_available_details').removeClass('hidden');
        $('#find_groups_details_available_toggle').text('Hide Details');
        // allow auto height on large screens
        $card.removeClass(fixedHClass);
        // scroll the top of the details into view for context
        // document.getElementById('find_groups_details_available_details')
        //   .scrollIntoView({behavior:'smooth', block:'start', inline:'nearest'});
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
      // find_groups_details_available_likeToggle();
      find_groups_details_available_controlsInit();
      find_groups_details_available_detailsToggleInit();

      // (Optional) search hook for future list:
      $('#find_groups_details_available_search_input').on('input', function(){
        const q = $(this).val().toLowerCase();
        // hook when you have multiple cards
      });
    });
  </script>

  <script>
      $(document).on('click', '#find_groups_details_available_btn_play', function () {
        $('#videoPopup').fadeIn(200);
      });

      $(document).on('click', '.video-close, #videoPopup', function (e) {
        // if ($(e.target).closest('.video-wrapper').length) return;

        const video = $('#videoPopup video').get(0);
        video.pause();
        video.currentTime = 0;

        $('#videoPopup').fadeOut(200);
      });
  </script>



<?php require_once("find_groups_book_trail_lesson.php");?>

</body>
</html>
