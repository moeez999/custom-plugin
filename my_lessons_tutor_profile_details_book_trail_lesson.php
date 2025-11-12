<!-- 1) jQuery -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>



<div id="my_lessons_tutor_profile_details_book_trial_lesson_backdrop"></div>

<!-- Step 1 -->
<div id="my_lessons_tutor_profile_details_book_trial_lesson_modal">
  <div class="my_lessons_tutor_profile_details_book_trial_lesson_header">
    <h2>Choose Your Trial Lesson Duration</h2>
    <span class="my_lessons_tutor_profile_details_book_trial_lesson_close">&times;</span>
  </div>
  <div class="my_lessons_tutor_profile_details_book_trial_lesson_content">
    <div class="my_lessons_tutor_profile_details_book_trial_lesson_option">
      <div class="icon">📋</div>
      <div class="text">
        <h3>25 minute trial lesson</h3>
        <p>Get to know the tutor, discuss your goals and learning plan.</p>
      </div>
      <div class="arrow">›</div>
    </div>
    <div class="my_lessons_tutor_profile_details_book_trial_lesson_option">
      <div class="icon">⚡</div>
      <div class="text">
        <h3>50 minute trial lesson</h3>
        <p>Get everything that’s in a 25-min lesson plus start learning.</p>
      </div>
      <div class="arrow">›</div>
    </div>
  </div>
</div>

<!-- Step 2 -->
<div id="my_lessons_tutor_profile_book_trail_lesson_modal">
  <div class="my_lessons_tutor_profile_book_trail_lesson_header">
    <div class="my_lessons_tutor_profile_book_trail_lesson_avatar">
      <img src="https://via.placeholder.com/40" alt="Tutor avatar">
    </div>
    <div class="my_lessons_tutor_profile_book_trail_lesson_title">
      <h2>Book a trial lesson</h2>
      <p>To meet your classmates and teachers</p>
    </div>
    <span class="my_lessons_tutor_profile_book_trail_lesson_close">&times;</span>
  </div>
  <div class="my_lessons_tutor_profile_book_trail_lesson_tabs">
    <button class="my_lessons_tutor_profile_book_trail_lesson_tab" data-duration="25">25 min</button>
    <button class="my_lessons_tutor_profile_book_trail_lesson_tab" data-duration="50">50 min</button>
  </div>
  <div class="my_lessons_tutor_profile_book_trail_lesson_calendar">
    <div class="my_lessons_tutor_profile_book_trail_lesson_calendar_header">
      <button class="my_lessons_tutor_profile_book_trail_lesson_prev">‹</button>
      <div class="my_lessons_tutor_profile_book_trail_lesson_month">May 13 – 19, 2025</div>
      <button class="my_lessons_tutor_profile_book_trail_lesson_next">›</button>
    </div>
    <div class="my_lessons_tutor_profile_book_trail_lesson_days"></div>
  </div>
  <div class="my_lessons_tutor_profile_book_trail_lesson_timezone">
    in your time zone Europe/Brussel (GMT +10:00)
  </div>
  <div class="my_lessons_tutor_profile_book_trail_lesson_times">
    <div class="my_lessons_tutor_profile_book_trail_lesson_group">
      <div class="icon">🌙</div> Night
      <div class="my_lessons_tutor_profile_book_trail_lesson_slots">
        <button class="slot">3:00 AM</button>
        <button class="slot">3:30 AM</button>
      </div>
    </div>
    <div class="my_lessons_tutor_profile_book_trail_lesson_group">
      <div class="icon">☀️</div> Morning
      <div class="my_lessons_tutor_profile_book_trail_lesson_slots">
        <button class="slot" disabled></button>
        <button class="slot">9:30 AM</button>
        <button class="slot">10:00 AM</button>
        <button class="slot">10:30 AM</button>
      </div>
    </div>
  </div>
  <div class="my_lessons_tutor_profile_book_trail_lesson_footer">
    <button id="my_lessons_tutor_profile_book_trail_lesson_continue">Continue</button>
  </div>
</div>

<!-- Step 3 -->
<div id="my_lessons_tutor_profile_book_trail_lesson_payment_modal">
  <div class="my_lessons_tutor_profile_book_trail_lesson_payment_header">
    <h2>How would you like to pay?</h2>
    <span class="my_lessons_tutor_profile_book_trail_lesson_payment_close">&times;</span>
  </div>
  <div class="my_lessons_tutor_profile_book_trail_lesson_payment_content">
    <div class="my_lessons_tutor_profile_book_trail_lesson_payment_option" data-choice="balance">
      <div class="icon">🏦</div>
      <div class="text">
        <h3>Use your balance</h3>
        <p>Transfer your unused balance to book a trial with Daniela</p>
      </div>
    </div>
    <div class="my_lessons_tutor_profile_book_trail_lesson_payment_option" data-choice="card">
      <div class="icon">💳</div>
      <div class="text">
        <h3>Charge your payment method</h3>
        <p>Go to checkout and pay for your lesson</p>
      </div>
    </div>
  </div>
</div>

<!-- Step 4 -->
<div id="my_lessons_tutor_profile_book_trail_lesson_balance_modal">
  <div class="my_lessons_tutor_profile_book_trail_lesson_balance_header">
    <button class="my_lessons_tutor_profile_book_trail_lesson_balance_back">←</button>
    <h2>Transfer from</h2>
    <span class="my_lessons_tutor_profile_book_trail_lesson_balance_close">&times;</span>
  </div>
  <div class="my_lessons_tutor_profile_book_trail_lesson_balance_content">
    <div class="my_lessons_tutor_profile_book_trail_lesson_balance_option" data-name="Karen V." data-balance="38">
      <img class="avatar" src="https://via.placeholder.com/40" alt="Karen V.">
      <div class="text">
        <h3>Karen V.</h3>
        <p>38$ to transfer</p>
      </div>
      <div class="arrow">›</div>
    </div>
    <div class="my_lessons_tutor_profile_book_trail_lesson_balance_option" data-name="David" data-balance="134">
      <img class="avatar" src="https://via.placeholder.com/40" alt="David">
      <div class="text">
        <h3>David</h3>
        <p>134$ to transfer</p>
      </div>
      <div class="arrow">›</div>
    </div>
  </div>
</div>

<!-- Step 5 -->
<div id="my_lessons_tutor_profile_book_trail_lesson_review_modal">
  <div class="my_lessons_tutor_profile_book_trail_lesson_review_header">
    <button class="my_lessons_tutor_profile_book_trail_lesson_review_back">←</button>
    <h2>Review your transfer</h2>
    <span class="my_lessons_tutor_profile_book_trail_lesson_review_close">&times;</span>
  </div>
  <div class="my_lessons_tutor_profile_book_trail_lesson_review_content">
    <div class="my_lessons_tutor_profile_book_trail_lesson_review_avatar_row">
      <img class="my_lessons_tutor_profile_book_trail_lesson_review_avatar" src="" alt="From">
      <span class="my_lessons_tutor_profile_book_trail_lesson_review_avatar_arrow">→</span>
      <img class="my_lessons_tutor_profile_book_trail_lesson_review_avatar" src="https://via.placeholder.com/40" alt="Daniela">
    </div>
    <div class="my_lessons_tutor_profile_book_trail_lesson_review_line">
      <span class="label">Balance with <span class="balance-name"></span></span>
      <span class="amount balance-amount"></span>
    </div>
    <div class="my_lessons_tutor_profile_book_trail_lesson_review_line">
      <span class="label lesson-label"></span>
      <span class="amount lesson-amount"></span>
    </div>
    <hr class="my_lessons_tutor_profile_book_trail_lesson_review_hr"/>
    <div class="my_lessons_tutor_profile_book_trail_lesson_review_line">
      <span class="label">Remaining balance with <span class="balance-name"></span></span>
      <span class="amount remaining-amount"></span>
    </div>
    <h3>What happens next?</h3>
    <ul class="my_lessons_tutor_profile_book_trail_lesson_review_list">
      <li></li><li></li>
    </ul>
  </div>
  <div class="my_lessons_tutor_profile_book_trail_lesson_review_footer">
    <button id="my_lessons_tutor_profile_book_trail_lesson_review_confirm">
      Confirm transfer
    </button>
  </div>
</div>

<!-- Step 6 -->
<div id="my_lessons_tutor_profile_book_trail_lesson_complete_modal">
  <div class="my_lessons_tutor_profile_book_trail_lesson_complete_header">
    <div class="complete_avatar_row">
      <img class="my_lessons_tutor_profile_book_trail_lesson_complete_avatar"
           src="https://via.placeholder.com/40" alt="Karen V.">
      <span class="my_lessons_tutor_profile_book_trail_lesson_complete_arrow">»»»</span>
      <div class="complete_avatar_wrapper">
        <img class="my_lessons_tutor_profile_book_trail_lesson_complete_avatar"
             src="https://via.placeholder.com/40" alt="Daniela">
        <span class="my_lessons_tutor_profile_book_trail_lesson_complete_badge">+1</span>
      </div>
    </div>
  </div>
  <div class="my_lessons_tutor_profile_book_trail_lesson_complete_content">
    <h2>Transfer complete</h2>
    <span class="my_lessons_tutor_profile_book_trail_lesson_review_close">&times;</span>

    <p>
      Nice! You have <strong>1 trial lesson</strong> with Daniela,
      and a <strong>$28</strong> Latingles credit for your future payments.
    </p>
  </div>
  <div class="my_lessons_tutor_profile_book_trail_lesson_complete_footer">
    <button id="my_lessons_tutor_profile_book_trail_lesson_complete_done">
      Done
    </button>
  </div>
</div>

