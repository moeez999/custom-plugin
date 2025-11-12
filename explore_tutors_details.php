

<link rel="stylesheet" href="css/explore_tutors_details.css">
<link rel="stylesheet" href="css/book_trail_lessons.css">
<link rel="stylesheet" href="css/send_message_steps.css">

<div class="filters">
  <!-- 1: Class taught in -->
  <div class="filter">
    <div class="filter-button">
      <span class="label">Class taught in</span>
      <div class="selection">
        <span class="value">English &amp; Spanish</span>
        <span class="icon">▾</span>
      </div>
    </div>
    <div class="dropdown_filters">
      <div class="search-wrapper">
        <input type="text" placeholder="Type to search..." />
        <span class="search-icon">🔍</span>
      </div>
      <ul>
        <li class="section-label">Popular</li>
        <li class="item">
          <span>English &amp; Spanish</span>
          <span class="checkbox selected"></span>
        </li>
        <li class="item">
          <span>English (only)</span>
          <span class="checkbox"></span>
        </li>
        <li class="item">
          <span>Spanish (only)</span>
          <span class="checkbox"></span>
        </li>
      </ul>
    </div>
  </div>

  <!-- 2: English Level -->
  <div class="filter">
    <div class="filter-button">
      <span class="label">English Level</span>
      <div class="selection">
        <span class="value">Basic</span>
        <span class="icon">▾</span>
      </div>
    </div>
    <div class="dropdown_filters">
      <ul>
        <li class="item">Basic</li>
        <li class="item">Beginner</li>
        <li class="item">Elementary</li>
        <li class="item">Intermediate</li>
        <li class="item">Upper Intermediate</li>
        <li class="item">Advanced</li>
      </ul>
    </div>
  </div>

  <!-- 3: Availability -->
  <div class="filter">
    <div class="filter-button">
      <span class="label">I'm available</span>
      <div class="selection">
        <span class="value">Anytime</span>
        <span class="icon">▾</span>
      </div>
    </div>
    <div class="dropdown_filters">
      <li class="section-label">Times</li>
      <div class="segment-group">
        <div class="segment-label">Daytime</div>
        <div class="segment-options">
          <div class="time-option"><span>🌅</span>9–12</div>
          <div class="time-option"><span>☀️</span>12–15</div>
          <div class="time-option"><span>🌤️</span>15–18</div>
        </div>
      </div>
      <div class="segment-group">
        <div class="segment-label">Evening & night</div>
        <div class="segment-options">
          <div class="time-option"><span>🌇</span>18–21</div>
          <div class="time-option"><span>🌙</span>21–24</div>
          <div class="time-option"><span>🌑</span>0–3</div>
        </div>
      </div>
      <div class="segment-group">
        <div class="segment-label">Morning</div>
        <div class="segment-options">
          <div class="time-option"><span>🌙</span>3–6</div>
          <div class="time-option"><span>🌅</span>6–9</div>
        </div>
      </div>
      <li class="section-label">Days</li>
      <div class="day-options">
        <div class="day-option">Sun</div>
        <div class="day-option">Mon</div>
        <div class="day-option">Tue</div>
        <div class="day-option">Wed</div>
        <div class="day-option">Thu</div>
        <div class="day-option">Fri</div>
        <div class="day-option">Sat</div>
      </div>
    </div>
  </div>

  <!-- 4: Class Type -->
  <div class="filter">
    <div class="filter-button">
      <span class="label">Class Type</span>
      <div class="selection">
        <span class="value">Theoretical &amp; Conversational</span>
        <span class="icon">▾</span>
      </div>
    </div>
    <div class="dropdown_filters">
      <ul>
        <li class="section-label">Popular</li>
        <li class="item">
          <span>Theoretical &amp; Conversational</span>
          <span class="checkbox selected"></span>
        </li>
        <li class="item">
          <span>Conversational (only)</span>
          <span class="checkbox"></span>
        </li>
      </ul>
    </div>
  </div>

  <!-- 5: Price per Month with slider -->
  <div class="filter">
    <div class="filter-button">
      <span class="label">Price per Month</span>
      <div class="selection">
        <span class="value">$1 – $40+</span>
        <span class="icon">▾</span>
      </div>
    </div>
    <div class="dropdown_filters slider-dropdown_filters">
      <div class="range-label">
        $<span id="min-val">1</span> – $<span id="max-val">40+</span>
      </div>
      <div class="slider-container">
        <div class="slider-track"></div>
        <input type="range" class="range-min" min="1" max="100" value="1">
        <input type="range" class="range-max" min="1" max="100" value="40">
      </div>
    </div>
  </div>
</div>


  <!-- Teacher Section -->
  <section id="teacherSection">
    <div class="teacher-card">
      <div class="teacher-avatar"><img src="https://randomuser.me/api/portraits/women/4.jpg" alt="Daniela"/></div>
      <div class="teacher-details">
        <div class="teacher-header">
          <h3 class="teacher-name">Daniela <span class="verified">✔️</span></h3>
          <button class="favorite">♡</button>
        </div>
        <ul class="meta-list">
          <li>🎓 English</li>
          <li>👥 30 active students • 1,260 lessons</li>
          <li>🌐 English (Native)</li>
        </ul>
        <p class="bio">Hi! I’m Daniela, an experienced English teacher with over a decade of helping students master the language. I’m passionate about creating engaging lessons tailored to each learner’s needs.</p>
        <a class="see-more">See More...</a>
      </div>
      <div class="action-panel">
        <div class="rating">★ 4.7 <small>17 reviews</small></div>
        <div class="stats"><div>858<small>lessons</small></div><div>US$8<small>50-min lesson</small></div></div>
        <button class="btn-primary" id="openTrialModal">Book trial lesson US$0</button>
        <button class="btn-outline" id="send_message_btn">Send a Message</button>
      </div>
      
    </div>
    <div class="schedule-panel">
      <div class="schedule-preview"><span class="play-icon">▶</span></div>
      <button class="schedule-btn">View full schedule</button>
    </div>
  </section>

  <?php require_once('book_trail_lessons.php');?>
  <?php require_once('send_message_steps.php');?>

  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  <script src="js/explore_tutors_details.js"></script>
  <script src="js/book_trail_lessons.js"></script>
  <script src="js/send_message_steps.js"></script>









































