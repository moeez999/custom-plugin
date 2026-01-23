    <link rel="stylesheet" href="css/my_lessons_tutor_profile_details.css">
    <link rel="stylesheet" href="css/my_lessons_tutor_profile_details_reviews.css">
    <!-- <link rel="stylesheet" href="css/my_lessons_tutor_profile_details_show_more.css"> -->
    <link rel="stylesheet" href="css/my_lessons_tutor_profile_details_post_reviews.css">
    <link rel="stylesheet" href="css/book_trail_lessons.css">
    <link rel="stylesheet" href="css/send_message_steps.css">
    <link rel="stylesheet" href="css/my_lesson_tutor_profile_details_send_message.css">
       <!-- Tailwind -->
    <script src="https://cdn.tailwindcss.com"></script>

    <div id="my_lessons_tutor_profile_container">
      <!-- video popup -->
    <div id="videoPopup" class="video-popup">
      <div class="video-wrapper">
        <span class="video-close">&times;</span>
        <video controls>
          <source src="video.mp4" type="video/mp4">
        </video>
      </div>
    </div>
    <!-- LEFT COLUMN -->
    <div id="my_lessons_tutor_profile_left">

      <!-- Intro -->
      <div class="my_lessons_tutor_profile_intro">
        <div class="my_lessons_tutor_profile_image-wrapper">
          <img src="img/images/daniela.png" alt="Daniela" class="my_lessons_tutor_profile_image">
        </div>
        <div class="my_lessons_tutor_profile_header">
          <h1>Daniela <span class="my_lessons_tutor_profile_verified">
            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
              <path d="M21.5599 10.7391L20.1999 9.15908C19.9399 8.85908 19.7299 8.29908 19.7299 7.89908V6.19908C19.7299 5.13908 18.8599 4.26908 17.7999 4.26908H16.0999C15.7099 4.26908 15.1399 4.05908 14.8399 3.79908L13.2599 2.43908C12.5699 1.84908 11.4399 1.84908 10.7399 2.43908L9.16988 3.80908C8.86988 4.05908 8.29988 4.26908 7.90988 4.26908H6.17988C5.11988 4.26908 4.24988 5.13908 4.24988 6.19908V7.90908C4.24988 8.29908 4.03988 8.85908 3.78988 9.15908L2.43988 10.7491C1.85988 11.4391 1.85988 12.5591 2.43988 13.2491L3.78988 14.8391C4.03988 15.1391 4.24988 15.6991 4.24988 16.0891V17.7991C4.24988 18.8591 5.11988 19.7291 6.17988 19.7291H7.90988C8.29988 19.7291 8.86988 19.9391 9.16988 20.1991L10.7499 21.5591C11.4399 22.1491 12.5699 22.1491 13.2699 21.5591L14.8499 20.1991C15.1499 19.9391 15.7099 19.7291 16.1099 19.7291H17.8099C18.8699 19.7291 19.7399 18.8591 19.7399 17.7991V16.0991C19.7399 15.7091 19.9499 15.1391 20.2099 14.8391L21.5699 13.2591C22.1499 12.5691 22.1499 11.4291 21.5599 10.7391ZM16.1599 10.1091L11.3299 14.9391C11.1893 15.0795 10.9986 15.1584 10.7999 15.1584C10.6011 15.1584 10.4105 15.0795 10.2699 14.9391L7.84988 12.5191C7.55988 12.2291 7.55988 11.7491 7.84988 11.4591C8.13988 11.1691 8.61988 11.1691 8.90988 11.4591L10.7999 13.3491L15.0999 9.04908C15.3899 8.75908 15.8699 8.75908 16.1599 9.04908C16.4499 9.33908 16.4499 9.81908 16.1599 10.1091Z" fill="#1F3A93"/>
            </svg>
          </span>
          </h1>
          <p>Learn English with a dedicated and passionate teacher with 10 years of experience! Book your first class today.</p>
          <ul class="my_lessons_tutor_profile_features">
            <li><img src="img/tickk.svg" style="height: 24px; width: 24px;"> 
            <div>
              <p class="mt-0 mb-2"> Trials are 100% refundable </p>
              <p class="mt-0 mb-0">Try another tutor for free or get a refund</p>
            </div>
           </li>
            <li style="margin-top: 20px;">
              <img src="img/bhat.svg" style="height: 24px; width: 24px;"> 
              <div>
                <p class="mt-0 mb-2"> Teaches </p>
                <p class="mt-0 mb-0"> English lessons</p>
              </div>  
            </li>
          </ul>
        </div>
      </div>

      <!-- About -->
      <section class="my_lessons_tutor_profile_about">
        <h2>About me</h2>
        <p>Hi! I’m Daniela, an experienced English teacher with over a decade of helping students master the language. I’m passionate about creating engaging, personalized lessons that align with each student’s unique goals and learning style. My mission is to make language learning enjoyable and effective, empowering you to achieve fluency and confidence in English. I’m excited to guide you on your journey to success!</p>
      </section>

      <!-- Languages -->
      <section class="my_lessons_tutor_profile_languages mb-5">
        <h2>I speak</h2>
        <div style="margin-top: 12px;">
          <span class="my_lessons_tutor_profile_lang">
            Spanish <span class="my_lessons_tutor_profile_badge_native">Native</span>
          </span>
          <span class="my_lessons_tutor_profile_lang">
            English <span class="my_lessons_tutor_profile_badge_proficient">Proficient C2</span>
          </span>
        </div>
      </section>
      
      <!-- Reviews -->
      <section id="my_lessons_tutor_profile_reviews_section" style="margin-top: 40px;">
        <div class="d-flex justify-space-between mb-5 justify-between">
          <h2 class="group-profile-heading">What my students say</h2>
          <button class="my_lessons_tutor_profile_toggle_reviews" id="my_lessons_tutor_profile_details_post_review_trigger">Post Review</button>
        </div>
        <!-- Rating summary -->
        <div id="my_lessons_tutor_profile_rating_summary">
          <div class="my_lessons_tutor_profile_avg" style="margin-top: -11px;">
            <span class="my_lessons_tutor_profile_avg_value">4.7</span>
            <div class="my_lessons_tutor_profile_stars" style="margin-block: 5px 9px;display: flex; gap: 7px;">
              <img src="img/star-review.svg">
              <img src="img/star-review.svg">
              <img src="img/star-review.svg">
              <img src="img/star-review.svg">
              <img src="img/star-review.svg">
            </div>
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
                  <strong>Efren</strong> <span class="text-[14px]" style="color: var(--text-muted)">September 14, 2024</span> 
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
              <div class="my_lessons_tutor_profile_review_stars d-flex" style="margin-top: 12px; gap: 7px">
                 <img src="img/star-review.svg">
                  <img src="img/star-review.svg">
                  <img src="img/star-review.svg">
                  <img src="img/star-review.svg">
                  <img src="img/star-review.svg">
              </div>
              <div class="my_lessons_tutor_profile_review_text text-[14px]" style="margin-top: 12px;">He is an excellent teacher with incredible patience and effective teaching methods!</div>
          </div>
           <div>
            <div class="my_lessons_tutor_profile_review_item">
              <img src="img/images/daniela.png" alt="Efren" class="my_lessons_tutor_profile_review_avatar">
              <div class="my_lessons_tutor_profile_review_meta">
                <div class="my_lessons_tutor_profile_review_header text-[16px]">
                  <strong>Efren</strong> <span class="text-[14px]" style="color: var(--text-muted)">September 14, 2024</span> 
                </div>
              </div>
              
            </div>
              <div class="my_lessons_tutor_profile_review_stars d-flex" style="margin-top: 12px; gap: 7px">
                 <img src="img/star-review.svg">
                  <img src="img/star-review.svg">
                  <img src="img/star-review.svg">
                  <img src="img/star-review.svg">
                  <img src="img/star-review.svg">
              </div>
              <div class="my_lessons_tutor_profile_review_text text-[14px]" style="margin-top: 12px;">He is an excellent teacher with incredible patience and effective teaching methods!</div>
                <a href="#" class="my_lessson_tutor_profile_detail_show_more_trigger" style="margin-top: 12px; font-size: 14px; text-decoration: underline; color: var(--text-muted)">Show More</a>
          </div>
           <div>
            <div class="my_lessons_tutor_profile_review_item">
              <img src="img/images/daniela.png" alt="Efren" class="my_lessons_tutor_profile_review_avatar">
              <div class="my_lessons_tutor_profile_review_meta">
                <div class="my_lessons_tutor_profile_review_header text-[16px]">
                  <strong>Efren</strong> <span class="text-[14px]" style="color: var(--text-muted)">September 14, 2024</span> 
                </div>
              </div>
              
            </div>
             <div class="my_lessons_tutor_profile_review_stars d-flex" style="margin-top: 15px; gap: 7px">
                 <img src="img/star-review.svg">
                  <img src="img/star-review.svg">
                  <img src="img/star-review.svg">
                  <img src="img/star-review.svg">
                  <img src="img/star-review.svg">
              </div>
              <div class="my_lessons_tutor_profile_review_text text-[14px]" style="margin-top: 15px;">He is an excellent teacher with incredible patience and effective teaching methods!</div>
          </div>
           <div>
            <div class="my_lessons_tutor_profile_review_item">
              <img src="img/images/daniela.png" alt="Efren" class="my_lessons_tutor_profile_review_avatar">
              <div class="my_lessons_tutor_profile_review_meta">
                <div class="my_lessons_tutor_profile_review_header text-[16px]">
                  <strong>Efren</strong> <span class="text-[14px]" style="color: var(--text-muted)">September 14, 2024</span> 
                </div>
              </div>
              
            </div>
             <div class="my_lessons_tutor_profile_review_stars d-flex" style="margin-top: 15px; gap: 7px">
                 <img src="img/star-review.svg">
                  <img src="img/star-review.svg">
                  <img src="img/star-review.svg">
                  <img src="img/star-review.svg">
                  <img src="img/star-review.svg">
              </div>
              <div class="my_lessons_tutor_profile_review_text text-[14px]" style="margin-top: 15px;">He is an excellent teacher with incredible patience and effective teaching methods!</div>
          </div>

        </div>
        <div style="display: flex; justify-content: center">

          <button class="my_lessons_tutor_profile_toggle_reviews my_lessson_tutor_profile_detail_show_more_trigger" style="margin-top: 47px;">
            Show all 8 reviews
          </button>
        </div>
        
      </section>


      <!-- Schedule -->
      <section id="my_lessons_tutor_profile_schedule" class="mt-5">
        <h2>Schedule</h2>
        <div class="my_lessons_tutor_profile_notice mt-4">
          <img src="img/infoo.svg">
          <span>
            Choose the time for your first lesson. The timings are displayed in your local timezone.
          </span>
        </div>

        <div class="my_lessons_tutor_profile_toggle_duration">
          <button id="my_lessons_tutor_profile_25min" class="active">25 mins</button>
          <button id="my_lessons_tutor_profile_50min">50 mins</button>
        </div>

        <div class="my_lessons_tutor_profile_week_nav">
          <div class="d-flex gap-0">

            <button id="my_lessons_tutor_profile_prev_week">
              <img src="img/left-small-arrow.svg">
            </button>
            <button id="my_lessons_tutor_profile_next_week">
              <img src="img/right-small-arrow.svg">
            </button>
          </div>
          <span id="my_lessons_tutor_profile_week_label">Mar 11–17, 2025</span>
          

          <div class="my_lessons_tutor_profile_timezone_select">
            <span id="my_lessons_tutor_profile_timezone_label">
              <p id="my_lessons_tutor_profile_timezone_name"> America/New_York </p>
              <p id="my_lessons_tutor_profile_timezone_gmt">GMT -4:00 </p>
            </span>
            <span class="arrow">
              <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                  <path fill-rule="evenodd" clip-rule="evenodd" d="M17.9762 9.21996C17.8737 9.09171 17.747 8.98491 17.6032 8.90565C17.4594 8.82639 17.3015 8.77623 17.1383 8.75803C16.9752 8.73983 16.81 8.75395 16.6523 8.79958C16.4946 8.8452 16.3475 8.92145 16.2192 9.02396L12.0002 12.399L7.78022 9.02396C7.65275 8.91539 7.50477 8.83354 7.34506 8.78327C7.18534 8.73299 7.01716 8.71531 6.85048 8.73129C6.68381 8.74726 6.52204 8.79655 6.37479 8.87625C6.22753 8.95594 6.09778 9.06441 5.99325 9.19521C5.88872 9.326 5.81153 9.47647 5.76627 9.63768C5.721 9.79888 5.70859 9.96754 5.72976 10.1336C5.75093 10.2997 5.80525 10.4599 5.8895 10.6046C5.97376 10.7493 6.08622 10.8756 6.22022 10.976L11.2202 14.976C11.4417 15.1528 11.7168 15.2492 12.0002 15.2492C12.2837 15.2492 12.5587 15.1528 12.7802 14.976L17.7802 10.976C17.9085 10.8735 18.0153 10.7467 18.0945 10.603C18.1738 10.4592 18.2239 10.3012 18.2421 10.1381C18.2603 9.9749 18.2462 9.80976 18.2006 9.65206C18.155 9.49436 18.0787 9.34719 17.9762 9.21896V9.21996Z" fill="#121117"/>
              </svg>

            </span>
            <ul id="my_lessons_tutor_profile_timezone_dropdown">
              <li><span class="timezonez">America/New_York </span><span>GMT -4:00</span></li>
              <li><span class="timezonez">Europe/London GMT </span><span>+1:00</span></li>
              <li><span class="timezonez">Asia/Tokyo GMT </span><span>+9:00</span></li>
            </ul>
          </div>
        </div>

        <div class="my_lessons_tutor_profile_timeline">
          <div class="my_lessons_tutor_profile_timeline_progress"></div>
          <div class="my_lessons_tutor_profile_timeline_progress active"></div>
          <div class="my_lessons_tutor_profile_timeline_progress active"></div>
          <div class="my_lessons_tutor_profile_timeline_progress active"></div>
          <div class="my_lessons_tutor_profile_timeline_progress active"></div>
          <div class="my_lessons_tutor_profile_timeline_progress active"></div>
          <div class="my_lessons_tutor_profile_timeline_progress active"></div>
        </div>

        <div class="my_lessons_tutor_profile_slots hide-slots" id="slot-box">
          <!-- Tue 11 -->  
          <div class="my_lessons_tutor_profile_day">
            <div class="my_lessons_tutor_profile_day_label" style="opacity: 0.8">Tue<br><span>11</span></div>
            <div class="my_lessons_tutor_profile_times">
            
            </div>
          </div>
          <!-- Wed 12 -->  
          <div class="my_lessons_tutor_profile_day">
            <div class="my_lessons_tutor_profile_day_label">Wed<br><span>12</span></div>
            <div class="my_lessons_tutor_profile_times">
              <a href="#">20:00</a>
              <a href="#">20:30</a>
            </div>
          </div>
          <!-- Thu 13 -->  
          <div class="my_lessons_tutor_profile_day">
            <div class="my_lessons_tutor_profile_day_label">Thu<br><span>13</span></div>
            <div class="my_lessons_tutor_profile_times">
              <a href="#">06:00</a>
              <a href="#">06:30</a>
              <a href="#">07:00</a>
              <a href="#">18:30</a>
              <a href="#">19:00</a>
              <a href="#">20:30</a>
            </div>
          </div>
          <!-- Fri 14 -->  
          <div class="my_lessons_tutor_profile_day">
            <div class="my_lessons_tutor_profile_day_label">Fri<br><span>14</span></div>
            <div class="my_lessons_tutor_profile_times">
              <a href="#">13:30</a>
              <a href="#">14:00</a>
              <a href="#">14:30</a>
              <a href="#">15:00</a>
              <a href="#">15:30</a>
              <a href="#">16:00</a>
              <a href="#">16:30</a>
              <a href="#">17:00</a>
              <a href="#">17:30</a>
            </div>
          </div>
          <!-- Sat 15 -->  
          <div class="my_lessons_tutor_profile_day">
            <div class="my_lessons_tutor_profile_day_label">Sat<br><span>15</span></div>
            <div class="my_lessons_tutor_profile_times">
              <a href="#">17:00</a>
              <a href="#">17:30</a>
              <a href="#">18:00</a>
              <a href="#">18:30</a>
              <a href="#">19:00</a>
              <a href="#">19:30</a>
            </div>
          </div>
          <!-- Sun 16 -->  
          <div class="my_lessons_tutor_profile_day">
            <div class="my_lessons_tutor_profile_day_label">Sun<br><span>16</span></div>
            <div class="my_lessons_tutor_profile_times">
              <a href="#">18:30</a>
              <a href="#">19:00</a>
              <a href="#">19:30</a>
              <a href="#">20:00</a>
              <a href="#">20:30</a>
            </div>
          </div>
          <!-- Mon 17 -->  
          <div class="my_lessons_tutor_profile_day">
            <div class="my_lessons_tutor_profile_day_label">Mon<br><span>17</span></div>
            <div class="my_lessons_tutor_profile_times">
              <a href="#">06:00</a>
              <a href="#">06:30</a>
              <a href="#">07:00</a>
            </div>
          </div>
        </div>

        <button class="view-schedule" id="view-full-schedule">view full schedule</button>
      </section>

      <div id="my_lesson_tutor_profile_resume">
      <h2 style="margin-bottom: 20px">Resume</h2>
      <ul class="my_lesson_tutor_profile_resume_tabs">
        <li class="my_lesson_tutor_profile_resume_tab active" data-tab="work">Work experience</li>
        <li class="my_lesson_tutor_profile_resume_tab" data-tab="cert">Certifications</li>
      </ul>

    <div class="my_lesson_tutor_profile_resume_contents">
      <!-- Work experience -->
      <div class="my_lesson_tutor_profile_resume_tab_content" id="my_lesson_tutor_profile_resume_work">
        <div class="my_lesson_tutor_profile_resume_item">
          <div class="my_lesson_tutor_profile_resume_year">2021 — 2024</div>
          <div class="my_lesson_tutor_profile_resume_details">
            <p class="my_lesson_tutor_profile_resume_title">English For Kids</p>
            <p class="my_lesson_tutor_profile_resume_subtitle">English Teacher</p>
          </div>
        </div>
        <div class="my_lesson_tutor_profile_resume_item">
          <div class="my_lesson_tutor_profile_resume_year">2018 — 2021</div>
          <div class="my_lesson_tutor_profile_resume_details">
            <p class="my_lesson_tutor_profile_resume_title">Godel College Toluca</p>
            <p class="my_lesson_tutor_profile_resume_subtitle">English Teacher</p>
          </div>
        </div>
        <div class="my_lesson_tutor_profile_resume_item">
          <div class="my_lesson_tutor_profile_resume_year">2016 — 2017</div>
          <div class="my_lesson_tutor_profile_resume_details">
            <p class="my_lesson_tutor_profile_resume_title">Linguatec Language Center</p>
            <p class="my_lesson_tutor_profile_resume_subtitle">English Teacher</p>
          </div>
        </div>
        <div class="my_lesson_tutor_profile_resume_item">
          <div class="my_lesson_tutor_profile_resume_year">2014 — 2016</div>
          <div class="my_lesson_tutor_profile_resume_details">
            <p class="my_lesson_tutor_profile_resume_title">Interlingua Language Center</p>
            <p class="my_lesson_tutor_profile_resume_subtitle">English Teacher</p>
          </div>
        </div>
      </div>

      <!-- Certifications -->
      <div class="my_lesson_tutor_profile_resume_tab_content" id="my_lesson_tutor_profile_resume_cert" style="display:none;">
        <!-- Put your certifications markup here -->
       <div class="my_lesson_tutor_profile_resume_item">
          <div class="my_lesson_tutor_profile_resume_year">2021 — 2024</div>
          <div class="my_lesson_tutor_profile_resume_details">
            <p class="my_lesson_tutor_profile_resume_title">English For Kids</p>
            <p class="my_lesson_tutor_profile_resume_subtitle">English Teacher</p>
          </div>
        </div>
      </div>
    </div>
  </div>






<section id="my_lesson_tutor_profile_my_specialities" style="margin-top: 40px;">
  <h2 style="font-weight: 600">My specialties</h2>

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






<section id="my_lessons_tutor_profile_tiles">
  <h2 style="font-weight: 600;">You might also like</h2>
  <div class="my_lessons_tutor_profile_tiles_container">
    <button id="my_lessons_tutor_profile_tiles_prev" class="my_lessons_tutor_profile_tiles_nav">
      <img src="img/slider-arrow.svg" style="transform: rotate(180deg)">
    </button>
    <div class="my_lessons_tutor_profile_tiles_wrapper">
      <!-- Tile 1 -->
      <div class="my_lessons_tutor_profile_tiles_item">
        <div class="my_lessons_tutor_profile_tiles_imgwrap">
          <img src="img/person1.svg" alt="Gladys" class="my_lessons_tutor_profile_tiles_img">
          <div class="d-flex gap-2 my_lessons_tutor_profile_tiles_detailz items-center">
            <h3 class="my_lessons_tutor_profile_tiles_name">Gladys</h3>
            <div class="my_lessons_tutor_profile_tiles_flag"><img src="img/flag1.svg"></div>
          </div>
        </div>
        <div class="my_lessons_tutor_profile_tiles_rating"><img src="img/starrr.svg">  <span id="rating-no"> 5</span> <span>(11)</span></div>
        <p class="my_lessons_tutor_profile_tiles_desc">
          Certified English Tutor with 10+ Years’ Experience Making
        </p>
        <div class="my_lessons_tutor_profile_tiles_price">
          <!-- <strong>US$8</strong> / lesson -->
           <div>US$8</div>
           <p> / lesson</p>
        </div>
      </div>
      <!-- Tile 2 -->
      <div class="my_lessons_tutor_profile_tiles_item">
        <div class="my_lessons_tutor_profile_tiles_imgwrap">
          <img src="img/person2.svg" alt="Angel" class="my_lessons_tutor_profile_tiles_img">
          <div class="d-flex gap-2 my_lessons_tutor_profile_tiles_detailz">
            <h3 class="my_lessons_tutor_profile_tiles_name">Angel</h3>
            <div class="my_lessons_tutor_profile_tiles_flag"><img src="img/flag2.svg"></div>
          </div>
        </div>
        <div class="my_lessons_tutor_profile_tiles_rating"><img src="img/starrr.svg">  <span id="rating-no"> 4.9</span> <span>(49)</span></div>
        <p class="my_lessons_tutor_profile_tiles_desc">
          Certified tutor with 7 years of experience of teaching English and
        </p>
        <div class="my_lessons_tutor_profile_tiles_price">
           <div>US$5</div>
           <p> / lesson</p>
        </div>
      </div>
      <!-- Tile 3 -->
      <div class="my_lessons_tutor_profile_tiles_item">
        <div class="my_lessons_tutor_profile_tiles_imgwrap">
          <img src="img/person3.svg" alt="Kristin" class="my_lessons_tutor_profile_tiles_img">
          <div class="d-flex gap-2 my_lessons_tutor_profile_tiles_detailz">
            <h3 class="my_lessons_tutor_profile_tiles_name">Kristin</h3>
            <div class="my_lessons_tutor_profile_tiles_flag"><img src="img/flag3.svg"></div>
          </div>
        </div>
        <div class="my_lessons_tutor_profile_tiles_rating"><img src="img/starrr.svg">  <span id="rating-no"> 5</span> <span>(44)</span></div>
        <p class="my_lessons_tutor_profile_tiles_desc">
          Certified English Tutor with 5 years of experience
        </p>
        <div class="my_lessons_tutor_profile_tiles_price">
           <div>US$8</div>
           <p> / lesson</p>
        </div>
      </div>
      <!-- Tile 4 -->
      <div class="my_lessons_tutor_profile_tiles_item">
        <div class="my_lessons_tutor_profile_tiles_imgwrap">
          <img src="img/person4.svg" alt="Ronald" class="my_lessons_tutor_profile_tiles_img">
          <div class="d-flex gap-2 my_lessons_tutor_profile_tiles_detailz">
            <h3 class="my_lessons_tutor_profile_tiles_name">Ronald</h3>
            <div class="my_lessons_tutor_profile_tiles_flag"><img src="img/flag1.svg"></div>
          </div>
        </div>
        <div class="my_lessons_tutor_profile_tiles_rating"><img src="img/starrr.svg">  <span id="rating-no"> 5</span> <span>(33)</span></div>
        <p class="my_lessons_tutor_profile_tiles_desc">
          certified English teacher with 5 years of experien
        </p>
        <div class="my_lessons_tutor_profile_tiles_price">
           <div>US$10</div>
           <p> / lesson</p>
        </div>
      </div>
      <!-- Tile 5 -->
      <div class="my_lessons_tutor_profile_tiles_item">
        <div class="my_lessons_tutor_profile_tiles_imgwrap">
          <img src="img/person1.svg" alt="Ronald" class="my_lessons_tutor_profile_tiles_img">
          <div class="d-flex gap-2 my_lessons_tutor_profile_tiles_detailz">
            <h3 class="my_lessons_tutor_profile_tiles_name">Gladys</h3>
            <div class="my_lessons_tutor_profile_tiles_flag"><img src="img/flag2.svg"></div>
          </div>
        </div>
        <div class="my_lessons_tutor_profile_tiles_rating"><img src="img/starrr.svg"> <span id="rating-no"> 5</span> <span>(33)</span></div>
        <p class="my_lessons_tutor_profile_tiles_desc">
          certified English teacher with 5 years of experien
        </p>
        <div class="my_lessons_tutor_profile_tiles_price">
           <div>US$20</div>
           <p> / lesson</p>
        </div>
      </div>
      <!-- … add more tiles if you like … -->
    </div>
    <button id="my_lessons_tutor_profile_tiles_next" class="my_lessons_tutor_profile_tiles_nav">
      <img src="img/slider-arrow.svg">
    </button>
  </div>
</section>






    </div><!-- /left -->
    



    <!-- RIGHT CARD -->
    <div id="my_lessons_tutor_profile_right">
      <div class="my_lessons_tutor_profile_card">
        <div class="my_lessons_tutor_profile_card_media">
          <img src="img/danielaa.svg" alt="Lesson preview" class="my_lessons_tutor_profile_card_img" style="border-radius: 8px;">
          <div id="video-pay-button" class="my_lessons_tutor_profile_card_play">
            <svg style="margin-right: -3px;" width="16" height="20" viewBox="0 0 16 20" fill="none" xmlns="http://www.w3.org/2000/svg">
              <mask id="path-1-inside-1_22337_27594" fill="white">
              <path d="M0 0H16V20H0V0Z"></path>
              </mask>
              <g clip-path="url(#paint0_diamond_22337_27594_clip_path)" data-figma-skip-parse="true" mask="url(#path-1-inside-1_22337_27594)"><g transform="matrix(0.016 0 0 0.01 0 10)"><rect x="0" y="0" width="1062.5" height="1100" fill="url(#paint0_diamond_22337_27594)" opacity="1" shape-rendering="crispEdges"></rect><rect x="0" y="0" width="1062.5" height="1100" transform="scale(1 -1)" fill="url(#paint0_diamond_22337_27594)" opacity="1" shape-rendering="crispEdges"></rect><rect x="0" y="0" width="1062.5" height="1100" transform="scale(-1 1)" fill="url(#paint0_diamond_22337_27594)" opacity="1" shape-rendering="crispEdges"></rect><rect x="0" y="0" width="1062.5" height="1100" transform="scale(-1)" fill="url(#paint0_diamond_22337_27594)" opacity="1" shape-rendering="crispEdges"></rect></g></g><path d="M0 0V-10H-16V0H0ZM0 20H-16V30H0V20ZM0 0V10H16V0V-10H0V0ZM16 20V10H0V20V30H16V20ZM0 20H16V0H0H-16V20H0Z" data-figma-gradient-fill="{&quot;type&quot;:&quot;GRADIENT_DIAMOND&quot;,&quot;stops&quot;:[{&quot;color&quot;:{&quot;r&quot;:1.0,&quot;g&quot;:1.0,&quot;b&quot;:1.0,&quot;a&quot;:1.0},&quot;position&quot;:0.99999988079071045},{&quot;color&quot;:{&quot;r&quot;:0.0,&quot;g&quot;:0.0,&quot;b&quot;:0.0,&quot;a&quot;:0.0},&quot;position&quot;:1.0}],&quot;stopsVar&quot;:[{&quot;color&quot;:{&quot;r&quot;:1.0,&quot;g&quot;:1.0,&quot;b&quot;:1.0,&quot;a&quot;:1.0},&quot;position&quot;:0.99999988079071045},{&quot;color&quot;:{&quot;r&quot;:0.0,&quot;g&quot;:0.0,&quot;b&quot;:0.0,&quot;a&quot;:0.0},&quot;position&quot;:1.0}],&quot;transform&quot;:{&quot;m00&quot;:32.0,&quot;m01&quot;:0.0,&quot;m02&quot;:-16.0,&quot;m10&quot;:0.0,&quot;m11&quot;:20.0,&quot;m12&quot;:0.0},&quot;opacity&quot;:1.0,&quot;blendMode&quot;:&quot;NORMAL&quot;,&quot;visible&quot;:true}" mask="url(#path-1-inside-1_22337_27594)"></path>
              <defs>
              <clipPath id="paint0_diamond_22337_27594_clip_path"><path d="M0 0V-10H-16V0H0ZM0 20H-16V30H0V20ZM0 0V10H16V0V-10H0V0ZM16 20V10H0V20V30H16V20ZM0 20H16V0H0H-16V20H0Z" mask="url(#path-1-inside-1_22337_27594)"></path></clipPath><linearGradient id="paint0_diamond_22337_27594" x1="0" y1="0" x2="500" y2="500" gradientUnits="userSpaceOnUse">
              <stop offset="1" stop-color="white"></stop>
              <stop offset="1" stop-opacity="0"></stop>
              </linearGradient>
              </defs>
            </svg>

          </div>
        </div>
        <div class="my_lessons_tutor_profile_card_stats">
          <div class="d-flex gap-1 flex-column">
            <div class="my_lessons_tutor_profile_rating_value">4.7</div>
            <div class="my_lessons_tutor_profile_lessons">17 reviews</div>
          </div>
          <div class="d-flex gap-1 flex-column">
            <div class="my_lessons_tutor_profile_rating_value">858</div>
            <div class="my_lessons_tutor_profile_lessons">lessons</div>
          </div>
          <div class="d-flex gap-1 flex-column">
            <div class="my_lessons_tutor_profile_rating_value">US$8</div>
            <div class="my_lessons_tutor_profile_lessons">U50-min lesson</div>
          </div>
        </div>
        <div class="my_lessons_tutor_profile_card_actions">

          <button  id="openTrialModal" class="my_lessons_tutor_profile_btn my_lessons_tutor_profile_btn_primary" style="display: flex; align-items: center; justify-content: center;">
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
          <svg width="20" height="20" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
            <path fill-rule="evenodd" clip-rule="evenodd" d="M10.7489 4.95C11.1333 4.56749 11.5899 4.26517 12.0922 4.06059C12.5944 3.85602 13.1323 3.75326 13.6746 3.75829C14.2169 3.76333 14.7528 3.87605 15.2512 4.08992C15.7495 4.30378 16.2004 4.61453 16.5777 5.00411C16.955 5.39369 17.2511 5.85434 17.4489 6.35931C17.6466 6.86429 17.7421 7.40352 17.7297 7.94569C17.7173 8.48787 17.5974 9.02218 17.3768 9.51761C17.1562 10.013 16.8394 10.4597 16.4447 10.8317L9.99805 16.875L3.55222 10.8317C3.16218 10.4586 2.84977 10.012 2.63295 9.51776C2.41612 9.02347 2.29918 8.49119 2.28884 7.95154C2.2785 7.41189 2.37496 6.87552 2.57269 6.3733C2.77041 5.87107 3.06549 5.41289 3.44095 5.02513C3.81641 4.63737 4.26483 4.32767 4.76043 4.11386C5.25602 3.90005 5.789 3.78634 6.3287 3.77928C6.8684 3.77222 7.40418 3.87195 7.90519 4.07272C8.40621 4.2735 8.86258 4.57136 9.24805 4.94917L9.99805 5.69917L10.7489 4.95Z"></path>
          </svg>

          <span >Save to my list</span>
          </button>

        </div>
        <div class="my_lessons_tutor_profile_card_footer" style="margin-top: 20px">
          <div class="gap-2 d-flex">
            <svg class="mt-1" width="14" height="12" viewBox="0 0 14 12" fill="none" xmlns="http://www.w3.org/2000/svg">
              <path fill-rule="evenodd" clip-rule="evenodd" d="M12.8047 0H9.47133V1.33333H11.1953L7.138 5.39067L5.276 3.52867L4.80467 3.05733L4.33333 3.52867L0 7.862L0.942667 8.80467L4.80467 4.94267L6.66667 6.80467L7.138 7.276L7.60933 6.80467L12.138 2.276V4H13.4713V0H12.8047ZM1.138 10.5H3.138V11.8333H1.138V10.5ZM6.47133 8.5H4.47133V11.8333H6.47133V8.5ZM13.138 7.16667V11.8333H11.138V7.16667H13.138ZM9.80467 9.83333H7.80467V11.8333H9.80467V9.83333Z" fill="#121117"/>
            </svg>
            <div>
              <div class="my_lessons_tutor_profile_popular">Popular</div>
              <div class="my_lessons_tutor_profile_response mt-1" style="margin-bottom: 12px;"> 32 lesson bookings in the last 48 hours</div>
            </div>
          </div> 
          <div class="my_lessons_tutor_profile_response">
            <svg width="16" height="16" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg">
              <path fill-rule="evenodd" clip-rule="evenodd" d="M7.99967 13.3335C6.58519 13.3335 5.22863 12.7716 4.22844 11.7714C3.22824 10.7712 2.66634 9.41465 2.66634 8.00016C2.66634 6.58567 3.22824 5.22912 4.22844 4.22893C5.22863 3.22873 6.58519 2.66683 7.99967 2.66683C9.41416 2.66683 10.7707 3.22873 11.7709 4.22893C12.7711 5.22912 13.333 6.58567 13.333 8.00016C13.333 9.41465 12.7711 10.7712 11.7709 11.7714C10.7707 12.7716 9.41416 13.3335 7.99967 13.3335ZM1.33301 8.00016C1.33301 4.31816 4.31767 1.3335 7.99967 1.3335C11.6817 1.3335 14.6663 4.31816 14.6663 8.00016C14.6663 11.6822 11.6817 14.6668 7.99967 14.6668C4.31767 14.6668 1.33301 11.6822 1.33301 8.00016ZM8.66634 4.66683C8.66634 4.49002 8.5961 4.32045 8.47108 4.19543C8.34606 4.0704 8.17649 4.00016 7.99967 4.00016C7.82286 4.00016 7.65329 4.0704 7.52827 4.19543C7.40325 4.32045 7.33301 4.49002 7.33301 4.66683V8.00016C7.33301 8.17697 7.40325 8.34654 7.52827 8.47157C7.65329 8.59659 7.82286 8.66683 7.99967 8.66683H9.99967C10.1765 8.66683 10.3461 8.59659 10.4711 8.47157C10.5961 8.34654 10.6663 8.17697 10.6663 8.00016C10.6663 7.82335 10.5961 7.65378 10.4711 7.52876C10.3461 7.40373 10.1765 7.3335 9.99967 7.3335H8.66634V4.66683Z" fill="#121117"/>
            </svg>
            <div>Usually responds in 2 hours</div>
          </div>
        </div>
      </div>
    </div><!-- /right -->
 </div><!-- /container -->



 <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
 <?php require_once('my_lessons_tutor_profile_details_reviews.php');?>
 <?php require_once('my_lessons_tutor_profile_details_show_more.php');?>
 <?php require_once('my_lessons_tutor_profile_details_post_reviews.php');?>
 <?php require_once('book_trail_lessons.php'); ?>

  <?php require_once('send_message_steps.php'); ?>


  <script src="js/my_lessons_tutor_profile_details.js"></script>
  <script src="js/my_lessons_tutor_profile_details_reviews.js"></script>
  <script src="js/my_lessons_tutor_profile_details_show_more.js"></script>
  <script src="js/my_lessons_tutor_profile_details_post_reviews.js"></script>
  <script src="js/book_trail_lessons.js"></script>
<script src="js/send_message_steps.js"></script>
