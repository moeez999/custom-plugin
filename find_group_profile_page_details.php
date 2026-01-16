    <link rel="stylesheet" href="css/find_group_profile_page_details.css">
    <link rel="stylesheet" href="css/find_group_profile_page_details_reviews.css">
    <link rel="stylesheet" href="css/find_group_profile_page_details_post_reviews.css">
    <link rel="stylesheet" href="css/my_lessons_tutor_profile_details_book_trial_lesson.css">
    <link rel="stylesheet" href="css/my_lesson_tutor_profile_details_send_message.css">

      <!-- Tailwind + jQuery -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <div id="find_group_profile_container">

    <!-- LEFT COLUMN -->
    <div id="my_lessons_tutor_profile_left">

      <!-- Intro -->
         <!-- 3-column grid -->
          <div id="find_groups_details_available_card_grid" class="grid grid-cols-[160px_minmax(0,1fr)] gap-4 items-start">

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
                  <p class="text-[16px] text-[color:var(--fgda-muted)] mb-1">Main Teacher :</p>
                  <p id="find_groups_details_available_main_name" class="font-semibold text-[16px]">Daniela Canelon</p>
                  <div class="flex items-center gap-2 mt-1 text-[color:var(--fgda-muted)] text-[16px] ">
                    <svg width="16" height="16" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M12.0438 11.8642L11.3911 10.5586L10.7383 11.8642H12.0438Z" fill="#4D4C5C"/>
                        <path d="M14.5942 6.78242H13.9301V5.37733C13.9301 5.31178 13.9163 5.24696 13.8897 5.18706C13.8631 5.12716 13.8243 5.0735 13.7756 5.02955C13.727 4.98561 13.6697 4.95235 13.6074 4.93193C13.5451 4.9115 13.4792 4.90437 13.414 4.91098C13.3394 4.91855 11.6676 5.10761 10.8352 6.78242H10.1541V7.8102C10.1541 9.10223 9.10297 10.1534 7.81097 10.1534H6.78319V14.5935C6.78319 15.3685 7.41378 15.9991 8.18884 15.9991H14.5942C15.3693 15.9991 15.9999 15.3685 15.9999 14.5935V8.18811C15.9999 7.41302 15.3693 6.78242 14.5942 6.78242ZM9.09059 13.0628L10.9722 9.29952C11.0111 9.22164 11.071 9.15615 11.145 9.11038C11.2191 9.06461 11.3044 9.04036 11.3915 9.04036C11.4786 9.04036 11.5639 9.06461 11.638 9.11038C11.712 9.15615 11.7719 9.22164 11.8108 9.29952L13.6924 13.0628C13.8082 13.2944 13.7143 13.5759 13.4828 13.6917C13.2513 13.8075 12.9697 13.7136 12.8539 13.4821L12.5131 12.8004H10.27L9.92916 13.4821C9.84703 13.6463 9.68147 13.7413 9.50953 13.7413C9.43909 13.7413 9.36756 13.7254 9.30028 13.6917C9.06869 13.5759 8.97484 13.2944 9.09059 13.0628ZM5.05241 3.94727H4.16406C4.22206 4.41167 4.37072 4.80214 4.60825 5.11677C4.84575 4.80214 4.99441 4.41167 5.05241 3.94727Z" fill="#4D4C5C"/>
                        <path d="M7.81106 9.21672C8.58616 9.21672 9.21672 8.58613 9.21672 7.81107V1.40569C9.21672 0.630598 8.58612 3.89877e-06 7.81106 3.89877e-06H1.40569C0.630594 3.89877e-06 0 0.630598 0 1.40569V7.81107C0 8.58616 0.630594 9.21672 1.40566 9.21672H2.06978V10.6218C2.06978 10.6874 2.08353 10.7522 2.11014 10.8121C2.13675 10.872 2.17562 10.9256 2.22425 10.9696C2.27288 11.0135 2.33019 11.0468 2.39247 11.0672C2.45476 11.0876 2.52063 11.0948 2.58584 11.0882C2.66047 11.0806 4.33228 10.8915 5.16463 9.21672H7.81106ZM4.85819 6.52729C4.77276 6.48163 4.68941 6.43221 4.60838 6.37916C4.52734 6.43221 4.44399 6.48164 4.35856 6.52729C3.55875 6.95385 2.76034 6.95875 2.72675 6.95875C2.46788 6.95875 2.258 6.74888 2.258 6.49C2.258 6.23113 2.46788 6.02125 2.72675 6.02125C2.73088 6.02122 3.30922 6.01282 3.88469 5.71713C3.55544 5.2955 3.29594 4.72341 3.22097 3.94813H2.72672C2.46784 3.94813 2.25797 3.73825 2.25797 3.47938C2.25797 3.2205 2.46784 3.01063 2.72672 3.01063H4.13963V2.72672C4.13963 2.46785 4.3495 2.25797 4.60838 2.25797C4.86725 2.25797 5.07713 2.46785 5.07713 2.72672V3.01063H6.49C6.74887 3.01063 6.95875 3.2205 6.95875 3.47938C6.95875 3.73825 6.74887 3.94813 6.49 3.94813H5.99581C5.92081 4.72341 5.66134 5.2955 5.33209 5.71713C5.90753 6.01282 6.48597 6.02119 6.49194 6.02125C6.75081 6.02125 6.95972 6.23113 6.95972 6.49C6.95972 6.74888 6.74887 6.95875 6.49 6.95875C6.45641 6.95875 5.658 6.95388 4.85819 6.52729ZM11.4272 2.68185C11.5187 2.77338 11.6387 2.81916 11.7586 2.81916C11.8785 2.81916 11.9985 2.77341 12.09 2.68185C12.2731 2.49879 12.2731 2.202 12.09 2.01894L11.9555 1.88438C13.6807 1.9866 15.0531 3.42235 15.0531 5.17285C15.0531 5.43172 15.263 5.6416 15.5219 5.6416C15.7808 5.6416 15.9906 5.43172 15.9906 5.17285C15.9906 2.90182 14.1924 1.04313 11.9451 0.94516L12.09 0.800191C12.2731 0.617129 12.2731 0.320348 12.09 0.137285C11.907 -0.0457461 11.6102 -0.0457773 11.4271 0.137285L10.4863 1.07813C10.3033 1.26119 10.3033 1.55797 10.4863 1.74104L11.4272 2.68185ZM4.5635 13.3088C4.38047 13.1257 4.08366 13.1257 3.90059 13.3088C3.71753 13.4918 3.71753 13.7886 3.90059 13.9717L4.03516 14.1063C2.30988 14.0041 0.9375 12.5683 0.9375 10.8178C0.9375 10.5589 0.727625 10.349 0.46875 10.349C0.209875 10.349 0 10.5589 0 10.8178C0 13.0888 1.79822 14.9475 4.04556 15.0455L3.90059 15.1904C3.71753 15.3735 3.71753 15.6703 3.90059 15.8533C3.99213 15.9449 4.11209 15.9906 4.23203 15.9906C4.35197 15.9906 4.47197 15.9449 4.56347 15.8533L5.50428 14.9125C5.68734 14.7294 5.68734 14.4327 5.50428 14.2496L4.5635 13.3088Z" fill="#4D4C5C"/>
                    </svg>
  
                    <span id="find_groups_details_available_main_lang">English (Native)</span>
                  </div>
                </div>

                <div id="find_groups_details_available_box_practice_teacher"
                     class="find_groups_details_available_box find_groups_details_available_clickable text-[16px] "
                     role="button" tabindex="0" aria-label="Show Practice Teacher profile (2)">
                  <p class="text-[16px] text-[color:var(--fgda-muted)] mb-1">Practice Teacher :</p>
                  <p id="find_groups_details_available_practice_name" class="font-semibold text-[16px]" style="opacity: 0.6">Axley Perez</p>
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
                  <p class="text-[16px] text-[color:var(--fgda-muted)] mb-1">Students</p>
                  <div class="font-semibold flex items-center gap-2">
                    <svg width="15" height="17" viewBox="0 0 15 17" fill="none" xmlns="http://www.w3.org/2000/svg">
                      <path d="M6.91347 8.10589C8.02705 8.10589 8.99134 7.70647 9.77924 6.91843C10.5671 6.13057 10.9665 5.16653 10.9665 4.05283C10.9665 2.93945 10.5671 1.97532 9.77911 1.18716C8.99108 0.39939 8.02692 0 6.91347 0C5.79974 0 4.83567 0.39939 4.0478 1.18729C3.25994 1.97519 2.86038 2.93936 2.86038 4.05283C2.86038 5.16653 3.2599 6.1307 4.04794 6.9186C4.83597 7.70637 5.80013 8.10589 6.91347 8.10589ZM14.0052 12.9395C13.9825 12.6116 13.9366 12.2539 13.8689 11.8763C13.8006 11.4957 13.7127 11.136 13.6074 10.8072C13.4986 10.4674 13.3507 10.1318 13.1679 9.81017C12.9782 9.47638 12.7553 9.18571 12.5052 8.94654C12.2437 8.69633 11.9235 8.49516 11.5532 8.34838C11.1843 8.20245 10.7754 8.1285 10.338 8.1285C10.1662 8.1285 10.0001 8.19897 9.67923 8.40786C9.45117 8.55637 9.22243 8.70383 8.99302 8.85024C8.77258 8.99071 8.47396 9.12231 8.1051 9.24145C7.74525 9.35789 7.37988 9.41695 7.01924 9.41695C6.65863 9.41695 6.29335 9.35789 5.93311 9.24145C5.56468 9.12241 5.26606 8.99085 5.04585 8.85038C4.79048 8.68719 4.55943 8.53828 4.35901 8.4077C4.03857 8.19884 3.8723 8.12834 3.70054 8.12834C3.26299 8.12834 2.85424 8.20242 2.48538 8.34854C2.11537 8.49503 1.79506 8.6962 1.53328 8.94667C1.28333 9.18597 1.06033 9.47648 0.870826 9.81017C0.688156 10.1318 0.540258 10.4672 0.431372 10.8073C0.3262 11.1361 0.238283 11.4957 0.169987 11.8763C0.102316 12.2534 0.0563686 12.6113 0.0336252 12.9399C0.0110008 13.2707 -0.000213241 13.6021 3.07016e-06 13.9336C3.07016e-06 14.812 0.279234 15.5231 0.829875 16.0475C1.37371 16.5651 2.09328 16.8276 2.96835 16.8276H11.0709C11.946 16.8276 12.6653 16.5652 13.2093 16.0476C13.76 15.5235 14.0393 14.8123 14.0393 13.9335C14.0391 13.5944 14.0277 13.26 14.0052 12.9395Z" fill="#4D4C5C"/>
                    </svg>
                
                    <p id="find_groups_details_available_students_active text-[16px]" style="display: inline-block; font-size: 16px; font-weight: 600; margin-top: 1px;">4 Active ,</p>
                  </div>
                  <p id="find_groups_details_available_students_max text-[16px]" class="text-[color:var(--fgda-muted)]" style="font-size: 16px;">Max 10</p>
                </div>

                <div id="find_groups_details_available_box_schedule" class="find_groups_details_available_box p-3">
                  <p class="text-[16px] text-[color:var(--fgda-muted)] mb-1">Schedule :</p>
                  <p id="find_groups_details_available_schedule_1" class="font-semibold text-[16px]">Mon, Wed, – 8 PM EST</p>
                  <p id="find_groups_details_available_schedule_2" class="font-semibold text-[16px]">Fri – 8 PM EST</p>
                </div>
              </div>
            </div>
          </div>

      <!-- About -->
      <section style="margin-top: 32px;">
        <h2 class="group-profile-heading">About English Group Classes (Bilingual)</h2>
        <p class="group-subheading">Hi! I’m Daniela, an experienced English teacher with over a decade of helping students master the language. I’m passionate about creating engaging, personalized lessons that align with each student’s unique goals and learning style...</p>
      </section>

      
      <!-- Reviews -->
      <section id="my_lessons_tutor_profile_reviews_section" style="margin-top: 40px;">
        <div class="d-flex justify-space-between mb-5 justify-between">
          <h2 class="group-profile-heading">What my students say</h2>
          <button class="my_lessons_tutor_profile_toggle_reviews" id="my_lessons_tutor_profile_details_post_review_trigger">Post Review</button>
        </div>
        <!-- Rating summary -->
        <div id="my_lessons_tutor_profile_rating_summary">
          <div class="my_lessons_tutor_profile_avg">
            <span class="my_lessons_tutor_profile_avg_value">4.7</span>
            <div class="my_lessons_tutor_profile_stars">★★★★★</div>
            <div class="my_lessons_tutor_profile_total_reviews">17 reviews</div>
          </div>
          <ul class="my_lessons_tutor_profile_bars">
            <li>
              <span class="my_lessons_tutor_profile_bar_label">5</span>
              <div class="my_lessons_tutor_profile_bar_bg">
                <div class="my_lessons_tutor_profile_bar_fill" style="width:88%;"></div>
              </div>
              <span class="my_lessons_tutor_profile_bar_count">(15)</span>
            </li>
            <li>
              <span class="my_lessons_tutor_profile_bar_label">4</span>
              <div class="my_lessons_tutor_profile_bar_bg">
                <div class="my_lessons_tutor_profile_bar_fill" style="width:6%;"></div>
              </div>
              <span class="my_lessons_tutor_profile_bar_count">(1)</span>
            </li>
            <li>
              <span class="my_lessons_tutor_profile_bar_label">3</span>
              <div class="my_lessons_tutor_profile_bar_bg">
                <div class="my_lessons_tutor_profile_bar_fill" style="width:0%;"></div>
              </div>
              <span class="my_lessons_tutor_profile_bar_count">(0)</span>
            </li>
            <li>
              <span class="my_lessons_tutor_profile_bar_label">2</span>
              <div class="my_lessons_tutor_profile_bar_bg">
                <div class="my_lessons_tutor_profile_bar_fill" style="width:0%;"></div>
              </div>
              <span class="my_lessons_tutor_profile_bar_count">(0)</span>
            </li>
            <li>
              <span class="my_lessons_tutor_profile_bar_label">1</span>
              <div class="my_lessons_tutor_profile_bar_bg">
                <div class="my_lessons_tutor_profile_bar_fill" style="width:6%;"></div>
              </div>
              <span class="my_lessons_tutor_profile_bar_count">(1)</span>
            </li>
          </ul>
        </div>


        <!-- Reviews grid -->
        <div id="my_lessons_tutor_profile_reviews_list" class="my_lessons_tutor_profile_collapsed">
          <div>
            <div class="my_lessons_tutor_profile_review_item">
              <img src="img/images/daniela.png" alt="Efren" class="my_lessons_tutor_profile_review_avatar">
              <div class="my_lessons_tutor_profile_review_meta">
                <div class="my_lessons_tutor_profile_review_header text-[16px]">
                  <strong>Efren</strong> <span class="text-[14px]">September 14, 2024</span> 
                </div>
              </div>
              <div style="flex: 1; display: flex; justify-content: end;">
                  <!-- Edit Button -->
                  <button id="my_lessons_tutor_profile_edit_button" class="my_lessons_tutor_profile_edit_button">
                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                      <path d="M3 17.4601V20.5001C3 20.7801 3.22 21.0001 3.5 21.0001H6.54C6.67 21.0001 6.8 20.9501 6.89 20.8501L17.81 9.94006L14.06 6.19006L3.15 17.1001C3.05 17.2001 3 17.3201 3 17.4601ZM20.71 7.04006C21.1 6.65006 21.1 6.02006 20.71 5.63006L18.37 3.29006C17.98 2.90006 17.35 2.90006 16.96 3.29006L15.13 5.12006L18.88 8.87006L20.71 7.04006Z" fill="black"/>
                    </svg>
                  </button>
              </div> 
            </div>
              <div class="my_lessons_tutor_profile_review_stars" style="margin-top: 12px;">★★★★★</div>
              <div class="my_lessons_tutor_profile_review_text text-[14px]" style="margin-top: 12px;">He is an excellent teacher with incredible patience and effective teaching methods!</div>
          </div>
           <div>
            <div class="my_lessons_tutor_profile_review_item">
              <img src="img/images/daniela.png" alt="Efren" class="my_lessons_tutor_profile_review_avatar">
              <div class="my_lessons_tutor_profile_review_meta">
                <div class="my_lessons_tutor_profile_review_header text-[16px]">
                  <strong>Efren</strong> <span class="text-[14px]">September 14, 2024</span> 
                </div>
              </div>
              
            </div>
              <div class="my_lessons_tutor_profile_review_stars" style="margin-top: 12px;">★★★★★</div>
              <div class="my_lessons_tutor_profile_review_text text-[14px]" style="margin-top: 12px;">He is an excellent teacher with incredible patience and effective teaching methods!</div>
                <a href="#" class="my_lessson_tutor_profile_detail_show_more_trigger" style="margin-top: 12px; font-size: 14px; text-decoration: underline">Show More</a>
          </div>
           <div>
            <div class="my_lessons_tutor_profile_review_item">
              <img src="img/images/daniela.png" alt="Efren" class="my_lessons_tutor_profile_review_avatar">
              <div class="my_lessons_tutor_profile_review_meta">
                <div class="my_lessons_tutor_profile_review_header text-[16px]">
                  <strong>Efren</strong> <span class="text-[14px]">September 14, 2024</span> 
                </div>
              </div>
              
            </div>
              <div class="my_lessons_tutor_profile_review_stars" style="margin-top: 12px;">★★★★★</div>
              <div class="my_lessons_tutor_profile_review_text text-[14px]" style="margin-top: 12px;">He is an excellent teacher with incredible patience and effective teaching methods!</div>
          </div>
           <div>
            <div class="my_lessons_tutor_profile_review_item">
              <img src="img/images/daniela.png" alt="Efren" class="my_lessons_tutor_profile_review_avatar">
              <div class="my_lessons_tutor_profile_review_meta">
                <div class="my_lessons_tutor_profile_review_header text-[16px]">
                  <strong>Efren</strong> <span class="text-[14px]">September 14, 2024</span> 
                </div>
              </div>
              
            </div>
              <div class="my_lessons_tutor_profile_review_stars" style="margin-top: 12px;">★★★★★</div>
              <div class="my_lessons_tutor_profile_review_text text-[14px]" style="margin-top: 12px;">He is an excellent teacher with incredible patience and effective teaching methods!</div>
          </div>

        </div>
        <div style="display: flex; justify-content: center">

          <button class="my_lessons_tutor_profile_toggle_reviews my_lessson_tutor_profile_detail_show_more_trigger" style="margin-top: 47px;">
            Show all 8 reviews
          </button>
        </div>
        
      </section>

      <!-- schedule -->
       <div class="" style="padding: 31px; border: 0.5px solid #00000033;
          border-radius: 12px;
          margin-top: 40px;">
        <div class="mt-2 flex items-center" style="gap: 15px;">
          <div class="w-10 h-10  bg-[#F5FBED] flex flex-col items-center justify-center text-[#4D7C25] leading-none" style="border-radius:4px;     height: 62px;
            width: 62px;">
           <img src="img/images/daniela.png" alt="Efren">
          </div>
          <div>
            <div class="text-[24px] font-semibold text-[#121117] leading-tight">Book a trial lesson with this group</div>
            <div class="text-[18px] text-[#6B6E76] mt-1">To meet your classmates and teachers</div>
          </div>
        </div>

        <div class="mt-4 flex items-center justify-between">
          <button style="width: 60px; height: 51px; border-radius: 11px" id="find_groups_book_trail_lesson_step2_btn_prev" class=" rounded-md border border-[#E4E7EE] flex items-center justify-center" aria-label="Previous week">
            <svg width="10" height="18" viewBox="0 0 10 18" fill="none" xmlns="http://www.w3.org/2000/svg">
              <path d="M0.000462143 8.90754C0.000352475 8.80119 0.021257 8.69586 0.0619741 8.59761C0.102691 8.49936 0.162418 8.41013 0.237725 8.33503L8.33544 0.237314C8.65186 -0.0791046 9.16424 -0.0791046 9.48046 0.237314C9.79668 0.553732 9.79688 1.06611 9.48046 1.38233L1.95525 8.90754L9.48046 16.4328C9.79688 16.7492 9.79688 17.2616 9.48046 17.5778C9.16404 17.894 8.65166 17.8942 8.33544 17.5778L0.237725 9.48005C0.162418 9.40495 0.102691 9.31571 0.0619741 9.21747C0.021257 9.11922 0.000352465 9.01389 0.000462143 8.90754Z" fill="black"/>
            </svg>

          </button>
          <div id="find_groups_book_trail_lesson_step2_week" class="text-[20px] font-semibold text-[#121117]">September 16–22 , 2024</div>
          <button style="width: 60px; height: 51px; border-radius: 11px" id="find_groups_book_trail_lesson_step2_btn_next" class=" rounded-md border border-[#E4E7EE] flex items-center justify-center" aria-label="Next week">
            <svg width="10" height="18" viewBox="0 0 10 18" fill="none" xmlns="http://www.w3.org/2000/svg">
              <path d="M9.71731 8.90754C9.71742 8.80119 9.69652 8.69586 9.6558 8.59761C9.61508 8.49936 9.55536 8.41013 9.48005 8.33503L1.38233 0.237314C1.06591 -0.0791046 0.55353 -0.0791046 0.237314 0.237314C-0.0789021 0.553732 -0.0791045 1.06611 0.237314 1.38233L7.76252 8.90754L0.237314 16.4328C-0.0791038 16.7492 -0.0791038 17.2616 0.237315 17.5778C0.553733 17.894 1.06612 17.8942 1.38233 17.5778L9.48005 9.48005C9.55536 9.40495 9.61508 9.31571 9.6558 9.21747C9.69652 9.11922 9.71742 9.01389 9.71731 8.90754Z" fill="black"/>
            </svg>
          </button>
        </div>

        <div id="" class="mt-3 d-flex" style="justify-content: space-between;  font-family: 'Figtree', sans-serif; font-weight: 700">
          <button type="button" class="select-none w-47 h-70" data-key="sat">
            <div class="text-[15px] text-[#6B6E76]">sat</div>
            <div class="mt-1 w-9 h-9 mx-auto rounded-full flex items-center justify-center text-[#121117]">16</div>
          </button>
        
          <button type="button" class="select-none w-47 h-70" data-key="sun">
            <div class="text-[15px] text-[#6B6E76]">sun</div>
            <div class="mt-1 w-9 h-9 mx-auto rounded-full flex items-center justify-center text-[#121117]">17</div>
          </button>
        
          <button type="button" class="select-none w-47 h-70" data-key="mon">
            <div class="text-[15px] text-[#121117] font-semibold">mon</div>
            <div class="mt-1 w-9 h-9 mx-auto rounded-full flex items-center justify-center bg-[#FF2500] text-white">18</div>
          </button>
        
          <button type="button" class="select-none w-47 h-70" data-key="tue">
            <div class="text-[15px] text-[#6B6E76]">tue</div>
            <div class="mt-1 w-9 h-9 mx-auto rounded-full flex items-center justify-center text-[#121117]">19</div>
          </button>
      
          <button type="button" class="select-none w-47 h-70" data-key="wed">
            <div class="text-[15px] text-[#6B6E76]">wed</div>
            <div class="mt-1 w-9 h-9 mx-auto rounded-full flex items-center justify-center text-[#121117]">20</div>
          </button>
        
          <button type="button" class="select-none w-47 h-70" data-key="thu">
            <div class="text-[15px] text-[#6B6E76]">thu</div>
            <div class="mt-1 w-9 h-9 mx-auto rounded-full flex items-center justify-center text-[#121117]">21</div>
          </button>
        
          <button type="button" class="select-none w-47 h-70" data-key="fri">
            <div class="text-[15px] text-[#6B6E76]">fri</div>
            <div class="mt-1 w-9 h-9 mx-auto rounded-full flex items-center justify-center text-[#121117]">22</div>
          </button>
        </div>

        <div class="mt-4 grid grid-cols-1 sm:grid-cols-2 gap-4">
          <div class="find_groups_book_trail_lesson_step2_box rounded-xl p-3">
            <div class="text-[14px] text-[#6B6E76] mb-1">Date :</div>
            <div id="find_groups_book_trail_lesson_step2_date" class="text-[16px] font-semibold">Monday, March 18</div>
          </div>
          <div class="find_groups_book_trail_lesson_step2_box rounded-xl p-3">
            <div class="text-[14px] text-[#6B6E76] mb-1">Time</div>
            <div id="find_groups_book_trail_lesson_step2_time" class="text-[16px] font-semibold">8 PM</div>
          </div>
        </div>
        <div class="mt-2 grid grid-cols-1 sm:grid-cols-2 gap-4">
          <div></div>
          <div>
 <div class="text-[12px] text-[#6B6E76]">
          in your time zone Europe/Brussel<br>(GMT +10:00)
        </div>
          </div>

        </div>

       

        <button class="button-continue mt-4 w-full h-[48px] text-[18px] rounded-[10px] font-semibold bg-[var(--fgda-peach)] text-white border-2 border-black">
          Continue
        </button>
      </div>

<!-- speciality -->
  <section id="my_lesson_tutor_profile_my_specialities" style="margin-top: 40px;">
  <h2 class="group-profile-heading">My specialties</h2>

  <div class="my_lesson_tutor_profile_my_specialities_item">
    <div class="my_lesson_tutor_profile_my_specialities_header">
      <span class="speciality-item">Conversational English</span>
      <span class="my_lesson_tutor_profile_my_specialities_arrow">
        <svg width="12" height="7" viewBox="0 0 12 7" fill="none" xmlns="http://www.w3.org/2000/svg">
          <path fill-rule="evenodd" clip-rule="evenodd" d="M6 7L0 1.39L1.487 0L6 4.22L10.513 0L12 1.39L6 7Z" fill="#121117"/>
        </svg>

      </span>
    </div>
    <div class="my_lesson_tutor_profile_my_specialities_content">
      <p>
        Conversational English refers to the type of English used in everyday communication. It is the informal language spoken between people in various social settings, such as at work, with friends, or in casual situations. Unlike formal English,
      </p>
    </div>
  </div>

  <div class="my_lesson_tutor_profile_my_specialities_item">
    <div class="my_lesson_tutor_profile_my_specialities_header">
      <span class="speciality-item">Business English</span>
      <span class="my_lesson_tutor_profile_my_specialities_arrow">
         <svg width="12" height="7" viewBox="0 0 12 7" fill="none" xmlns="http://www.w3.org/2000/svg">
          <path fill-rule="evenodd" clip-rule="evenodd" d="M6 7L0 1.39L1.487 0L6 4.22L10.513 0L12 1.39L6 7Z" fill="#121117"/>
        </svg>

      </span>
    </div>
    <div class="my_lesson_tutor_profile_my_specialities_content">
      <p>
        Business English covers the language skills needed in professional settings—presentations, negotiations, emails, and meetings. You’ll learn vocabulary and phrases that make you sound confident and clear in the boardroom.
      </p>
    </div>
  </div>

  <div class="my_lesson_tutor_profile_my_specialities_item">
    <div class="my_lesson_tutor_profile_my_specialities_header">
      <span class="speciality-item">English for beginners</span>
      <span class="my_lesson_tutor_profile_my_specialities_arrow">
         <svg width="12" height="7" viewBox="0 0 12 7" fill="none" xmlns="http://www.w3.org/2000/svg">
          <path fill-rule="evenodd" clip-rule="evenodd" d="M6 7L0 1.39L1.487 0L6 4.22L10.513 0L12 1.39L6 7Z" fill="#121117"/>
        </svg>

      </span>
    </div>
    <div class="my_lesson_tutor_profile_my_specialities_content">
      <p>
        This course is designed for complete beginners. We start with the alphabet, basic greetings, and simple sentence structures—building your confidence one small step at a time.
      </p>
    </div>
  </div>

  <div class="my_lesson_tutor_profile_my_specialities_item">
    <div class="my_lesson_tutor_profile_my_specialities_header">
      <span class="speciality-item">American English</span>
      <span class="my_lesson_tutor_profile_my_specialities_arrow">
         <svg width="12" height="7" viewBox="0 0 12 7" fill="none" xmlns="http://www.w3.org/2000/svg">
          <path fill-rule="evenodd" clip-rule="evenodd" d="M6 7L0 1.39L1.487 0L6 4.22L10.513 0L12 1.39L6 7Z" fill="#121117"/>
        </svg>

      </span>
    </div>
    <div class="my_lesson_tutor_profile_my_specialities_content">
      <p>
        Focus on pronunciation, idioms, and vocabulary specific to American English. Great for anyone planning to live, work, or study in the U.S.
      </p>
    </div>
  </div>

  <div class="my_lesson_tutor_profile_my_specialities_item">
    <div class="my_lesson_tutor_profile_my_specialities_header">
      <span class="speciality-item">Intensive English</span>
      <span class="my_lesson_tutor_profile_my_specialities_arrow">
         <svg width="12" height="7" viewBox="0 0 12 7" fill="none" xmlns="http://www.w3.org/2000/svg">
          <path fill-rule="evenodd" clip-rule="evenodd" d="M6 7L0 1.39L1.487 0L6 4.22L10.513 0L12 1.39L6 7Z" fill="#121117"/>
        </svg>

      </span>
    </div>
    <div class="my_lesson_tutor_profile_my_specialities_content">
      <p>
        Rapid-fire lessons designed to boost your fluency fast—daily practice in speaking, listening, reading, and writing.
      </p>
    </div>
  </div>
</section>




    </div><!-- /left -->
    



    <!-- RIGHT CARD -->
    <div id="my_lessons_tutor_profile_right" style="border-radius: 12px;">
      <div class="my_lessons_tutor_profile_card">
        <div class="my_lessons_tutor_profile_card_media">
          <img src="img/daniela.svg" alt="Lesson preview" class="my_lessons_tutor_profile_card_img" width = 352px height = 158px style="border-radius: 8px;">
          <div class="my_lessons_tutor_profile_card_play">
            <svg style="margin-right: -3px;" width="16" height="20" viewBox="0 0 16 20" fill="none" xmlns="http://www.w3.org/2000/svg">
              <mask id="path-1-inside-1_22337_27594" fill="white">
              <path d="M0 0H16V20H0V0Z"/>
              </mask>
              <g clip-path="url(#paint0_diamond_22337_27594_clip_path)" data-figma-skip-parse="true" mask="url(#path-1-inside-1_22337_27594)"><g transform="matrix(0.016 0 0 0.01 0 10)"><rect x="0" y="0" width="1062.5" height="1100" fill="url(#paint0_diamond_22337_27594)" opacity="1" shape-rendering="crispEdges"/><rect x="0" y="0" width="1062.5" height="1100" transform="scale(1 -1)" fill="url(#paint0_diamond_22337_27594)" opacity="1" shape-rendering="crispEdges"/><rect x="0" y="0" width="1062.5" height="1100" transform="scale(-1 1)" fill="url(#paint0_diamond_22337_27594)" opacity="1" shape-rendering="crispEdges"/><rect x="0" y="0" width="1062.5" height="1100" transform="scale(-1)" fill="url(#paint0_diamond_22337_27594)" opacity="1" shape-rendering="crispEdges"/></g></g><path d="M0 0V-10H-16V0H0ZM0 20H-16V30H0V20ZM0 0V10H16V0V-10H0V0ZM16 20V10H0V20V30H16V20ZM0 20H16V0H0H-16V20H0Z" data-figma-gradient-fill="{&#34;type&#34;:&#34;GRADIENT_DIAMOND&#34;,&#34;stops&#34;:[{&#34;color&#34;:{&#34;r&#34;:1.0,&#34;g&#34;:1.0,&#34;b&#34;:1.0,&#34;a&#34;:1.0},&#34;position&#34;:0.99999988079071045},{&#34;color&#34;:{&#34;r&#34;:0.0,&#34;g&#34;:0.0,&#34;b&#34;:0.0,&#34;a&#34;:0.0},&#34;position&#34;:1.0}],&#34;stopsVar&#34;:[{&#34;color&#34;:{&#34;r&#34;:1.0,&#34;g&#34;:1.0,&#34;b&#34;:1.0,&#34;a&#34;:1.0},&#34;position&#34;:0.99999988079071045},{&#34;color&#34;:{&#34;r&#34;:0.0,&#34;g&#34;:0.0,&#34;b&#34;:0.0,&#34;a&#34;:0.0},&#34;position&#34;:1.0}],&#34;transform&#34;:{&#34;m00&#34;:32.0,&#34;m01&#34;:0.0,&#34;m02&#34;:-16.0,&#34;m10&#34;:0.0,&#34;m11&#34;:20.0,&#34;m12&#34;:0.0},&#34;opacity&#34;:1.0,&#34;blendMode&#34;:&#34;NORMAL&#34;,&#34;visible&#34;:true}" mask="url(#path-1-inside-1_22337_27594)"/>
              <defs>
              <clipPath id="paint0_diamond_22337_27594_clip_path"><path d="M0 0V-10H-16V0H0ZM0 20H-16V30H0V20ZM0 0V10H16V0V-10H0V0ZM16 20V10H0V20V30H16V20ZM0 20H16V0H0H-16V20H0Z" mask="url(#path-1-inside-1_22337_27594)"/></clipPath><linearGradient id="paint0_diamond_22337_27594" x1="0" y1="0" x2="500" y2="500" gradientUnits="userSpaceOnUse">
              <stop offset="1" stop-color="white"/>
              <stop offset="1" stop-opacity="0"/>
              </linearGradient>
              </defs>
            </svg>

        </div>
        <div class="rating_charges_section">
            <div class="d-flex gap-3 items-center">
                <div>
                  <div class="d-flex gap-1 items-center">
                    <div class="text-[25px]">★</div>
                    <p class="text-[21px]" style="color: #121117; font-weight: 500">4.7</p>
                  </div>
                  <p class="text-[14px]" style="color: #4D4C5C">17 reviews</p>
                </div>
                <div style="
                      height: 58px;
                      display: flex;
                      flex-direction: column;
                      justify-content: space-between;
                      margin-top: 1px;
                  ">
                  <div class="d-flex gap-1" style="margin-top: 2px;">
                    <p class="text-[21px]"style="color: #121117; font-weight: 500">$70</p>
                  </div>
                  <p class="text-[14px]" style="color: #4D4C5C">Monthly</p>
                </div>
            </div>
        </div>
        <div class="my_lessons_tutor_profile_card_actions">

          <button  id="my_lessons_tutor_profile_details_book_trial_lesson_btn" class="my_lessons_tutor_profile_btn my_lessons_tutor_profile_btn_primary" style="display: flex; align-items: center; justify-content: center;">
          <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
            <path fill-rule="evenodd" clip-rule="evenodd" d="M14 10L15 2L2 14H11L10 22L22 10H14Z" fill="white"/>
          </svg>
          <span style="margin-left: 8px;" class="find_groups_details_available_btn_book"> Book trial lesson</span>
          </button>

          <button class="my_lessons_tutor_profile_btn my_lessons_tutor_profile_btn_outline" id="open_step1" style="display: flex; align-items: center; justify-content: center;">
            <svg width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink">
              <rect width="20" height="20" fill="url(#pattern0_22337_27599)"/>
              <defs>
              <pattern id="pattern0_22337_27599" patternContentUnits="objectBoundingBox" width="1" height="1">
              <use xlink:href="#image0_22337_27599" transform="scale(0.00195312)"/>
              </pattern>
                <image id="image0_22337_27599" width="512" height="512" preserveAspectRatio="none" xlink:href="data:image/png;base64,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"/>
              </defs>
            </svg>

          <span style="margin-left: 8px;">Send a Message</span>  
          </button>
         <button class="save_list my_lessons_tutor_profile_btn my_lessons_tutor_profile_btn_outline">
          <svg
            width="20"
            height="20"
            viewBox="0 0 20 20"
            xmlns="http://www.w3.org/2000/svg"
            aria-hidden="true" >
            <path
              fill-rule="evenodd"
              clip-rule="evenodd"
              d="M10.7489 4.95C11.1333 4.56749 11.5899 4.26517 12.0922 4.06059C12.5944 3.85602 13.1323 3.75326 13.6746 3.75829C14.2169 3.76333 14.7528 3.87605 15.2512 4.08992C15.7495 4.30378 16.2004 4.61453 16.5777 5.00411C16.955 5.39369 17.2511 5.85434 17.4489 6.35931C17.6466 6.86429 17.7421 7.40352 17.7297 7.94569C17.7173 8.48787 17.5974 9.02218 17.3768 9.51761C17.1562 10.013 16.8394 10.4597 16.4447 10.8317L9.99805 16.875L3.55222 10.8317C3.16218 10.4586 2.84977 10.012 2.63295 9.51776C2.41612 9.02347 2.29918 8.49119 2.28884 7.95154C2.2785 7.41189 2.37496 6.87552 2.57269 6.3733C2.77041 5.87107 3.06549 5.41289 3.44095 5.02513C3.81641 4.63737 4.26483 4.32767 4.76043 4.11386C5.25602 3.90005 5.789 3.78634 6.3287 3.77928C6.8684 3.77222 7.40418 3.87195 7.90519 4.07272C8.40621 4.2735 8.86258 4.57136 9.24805 4.94917L9.99805 5.69917L10.7489 4.95Z"
            />
          </svg>

          <span>Save to my list</span>
        </button>

        </div>
      </div>
    </div><!-- /right -->
 </div><!-- /container -->

 <style>
/* default icon */
.save_list {
  display: flex;
  align-items: center;
  justify-content: center;
  gap: 8px;
  color: #111;
  cursor: pointer;
}
.save_list svg path {
  fill: none;
  stroke: #000;
}

/* saved state */
.save_list.is-saved {
  color: #121117;
}

.save_list.is-saved svg path {
  fill: currentColor;
  stroke: #111;
}
 </style>

 <script>
$(document).on('click', '.save_list', function () {
  const $btn = $(this);
  const $text = $btn.find('span');

  const isSaved = $btn.toggleClass('is-saved').hasClass('is-saved');

  $text.text(isSaved ? 'Saved' : 'Save to my list');
});



  </script>


<?php require_once('find_group_profile_page_details_reviews.php');?>
<?php require_once("find_groups_book_trail_lesson.php");?>
<?php require_once('find_group_profile_page_details_show_more.php');?>
<?php require_once('find_group_profile_page_details_post_reviews.php');?>

<!-- js -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="js/find_group_profile_page_details_reviews.js"></script>
<script src="js/find_group_profile_page_details_show_more.js"></script>
<script src="js/find_group_profile_page_details_post_reviews.js"></script>

 <!-- check if needed -->
 <?php require_once('find_group_profile_page_details_book_trail_lesson.php');?>
 <?php require_once('find_group_profile_page_details_send_message.php');?>


  <script src="js/my_lessons_tutor_profile_details.js"></script>
  <script src="js/my_lessons_tutor_profile_details_book_trial_lesson.js"></script>
  <script src="js/my_lessons_tutor_profile_details_send_message.js"></script>

  