
<link rel="stylesheet"  href="css/my_lesson_details.css"/>
<link rel="stylesheet" href="css/my_lesson_tutor_profile_details_send_message.css">

<div id="my_lessons_container">
    <!-- Header + Actions -->
    <h1 class="my_lessons_header">My Lessons</h1>
    <div class="my_lessons_actions">
      <button  class="openTransfer my_lessons_btn_outline">
        Transfer lessons or subscription
      </button>
      <div class="my_lessons_schedule_dropdown my_lessons_calendar_slot_empty">
        <button id="my_lessons_schedule_btn" class="my_lessons_btn_primary">
          + Schedule lesson <i class="fas fa-chevron-down"></i>
        </button>
        <div id="my_lessons_schedule_menu" class="my_lessons_dropdown_menu">
          <div class="my_lessons_schedule_option" data-type="weekly">
            <i class="fas fa-sync-alt my_lessons_option_icon"></i>
            <div class="my_lessons_option_text">
              <span class="my_lessons_recommended_pill">Recommended</span>
              <h4>Weekly lessons</h4>
              <p>Lessons are scheduled automatically for the same time every week</p>
            </div>
          </div>

          <div class="my_lessons_schedule_option" data-type="single">
            <i class="fas fa-calendar-alt my_lessons_option_icon"></i>
            <div class="my_lessons_option_text">
              <h4>Single lessons</h4>
              <p>Lessons happen once</p>
            </div>
          </div>

        </div>
      </div>
    </div>

    <!-- Tabs -->
    <ul id="my_lessons_tabs" class="my_lessons_tabs">
      <li class="my_lessons_tab_item active" data-target="#my_lessons_tab_lessons">
        <i class="fas fa-video"></i> Lessons
      </li>
      <li class="my_lessons_tab_item" data-target="#my_lessons_tab_calendar">
        <i class="fas fa-calendar-alt"></i> Calendar
      </li>
      <li class="my_lessons_tab_item" data-target="#my_lessons_tab_tutors">
        <i class="fas fa-user-graduate"></i> Tutors
      </li>
    </ul>

    <!-- Lessons Tab -->
    <div id="my_lessons_tab_lessons" class="my_lessons_tab_content" style="display:block;">
      <h2 class="my_lessons_section_heading">Upcoming lessons</h2>

      <!-- Tomorrow (recurring) -->
      <div class="my_lessons_lesson_card">
         <a href="my_lessons_tutor_profile.php"><img
          src="https://randomuser.me/api/portraits/women/4.jpg"
          alt="Daniela"
          class="my_lessons_lesson_avatar"/></a>
        <div class="my_lessons_lesson_details">
          <div class="my_lessons_lesson_header">
            <i class="fas fa-sync-alt my_lessons_lesson_icon"></i>
            <span class="my_lessons_lesson_time">
              Tomorrow, Nov 13, 15:00 – 15:50
            </span>
          </div>
          
          <div class="my_lessons_lesson_subject"> Daniala, English</div>

        </div>
        
        <div class="my_lessons_menu_section">
          <i class="fas fa-ellipsis-h my_lessons_menu_icon"></i>
        </div>
        <div class="my_lessons_card_menu">

          <ul>
            <li><a href="my_lessons_details_reshedule.php"><i class="fas fa-calendar-alt"></i> Reschedule</a></li>
            <li class="my_lessons_details_my_lessons_content_message_tutor_btn"><i class="fas fa-comment"></i> Message Tutor</li>
            <li><a href="my_lessons_tutor_profile.php"><i class="fas fa-user"></i> See Tutor Profile</a></li>
            <li class="my_lessons_cancel my_lesson_details_cancel__open"><i class="fas fa-ban"></i> Cancel</li>
          </ul>
        </div>
      </div>

      <?php require_once('my_lessons_details_my_lessons_content_message_tutor.php');?>

      <!-- One-off lessons -->
      <div class="my_lessons_lesson_card">
        <img
          src="https://randomuser.me/api/portraits/women/4.jpg"
          alt="Daniela"
          class="my_lessons_lesson_avatar"/>
        <div class="my_lessons_lesson_details">
          <div class="my_lessons_lesson_header">
            <span class="my_lessons_lesson_time">
              Thursday, Nov 14, 15:00 – 15:50
            </span>
          </div>
          <div class="my_lessons_lesson_subject"> Daniala, English</div>
        </div>
        <div class="my_lessons_menu_section">
          <i class="fas fa-ellipsis-h my_lessons_menu_icon"></i>
        </div>
        <div class="my_lessons_card_menu">
          <ul>
            <li><i class="fas fa-calendar-alt"></i> Reschedule</li>
            <li><i class="fas fa-comment"></i> Message Tutor</li>
            <li><i class="fas fa-user"></i> See Tutor Profile</li>
            <li class="my_lessons_cancel"><i class="fas fa-ban"></i> Cancel</li>
          </ul>
        </div>
      </div>

      <div class="my_lessons_lesson_card">
        <img
          src="https://randomuser.me/api/portraits/women/4.jpg"
          alt="Daniela"
          class="my_lessons_lesson_avatar"/>
        <div class="my_lessons_lesson_details">
          <div class="my_lessons_lesson_header">
            <span class="my_lessons_lesson_time">
              Monday, Nov 18, 15:00 – 15:50
            </span>
          </div>
          <div class="my_lessons_lesson_subject"> Daniala, English</div>
        </div>
        <div class="my_lessons_menu_section">
          <i class="fas fa-ellipsis-h my_lessons_menu_icon"></i>
        </div>
        <div class="my_lessons_card_menu">
          <ul>
            <li><i class="fas fa-calendar-alt"></i> Reschedule</li>
            <li><i class="fas fa-comment"></i> Message Tutor</li>
            <li><i class="fas fa-user"></i> See Tutor Profile</li>
            <li class="my_lessons_cancel"><i class="fas fa-ban"></i> Cancel</li>
          </ul>
        </div>
      </div>

      <div class="my_lessons_lesson_card">
        <img
          src="https://randomuser.me/api/portraits/women/4.jpg"
          alt="Daniela"
          class="my_lessons_lesson_avatar"/>
        <div class="my_lessons_lesson_details">
          <div class="my_lessons_lesson_header">
            <span class="my_lessons_lesson_time">
              Wednesday, Nov 20, 15:00 – 15:50
            </span>
          </div>
          <div class="my_lessons_lesson_subject"> Daniala, English</div>
        </div>
        <div class="my_lessons_menu_section">
          <i class="fas fa-ellipsis-h my_lessons_menu_icon"></i>
        </div>
        <div class="my_lessons_card_menu">
          <ul>
            <li><i class="fas fa-calendar-alt"></i> Reschedule</li>
            <li><i class="fas fa-comment"></i> Message Tutor</li>
            <li><i class="fas fa-user"></i> See Tutor Profile</li>
            <li class="my_lessons_cancel"><i class="fas fa-ban"></i> Cancel</li>
          </ul>
        </div>
      </div>

      <h2 class="my_lessons_section_heading">Weekly lessons</h2>

      <div class="my_lessons_lesson_card">
        <img
          src="https://randomuser.me/api/portraits/women/4.jpg"
          alt="Daniela"
          class="my_lessons_lesson_avatar"/>
        <div class="my_lessons_lesson_details">
          <div class="my_lessons_lesson_header">
            <i class="fas fa-sync-alt my_lessons_lesson_icon"></i>
            <span class="my_lessons_lesson_time">
              Every Wednesday, 15:00 – 15:50
            </span>
          </div>
          <div class="my_lessons_lesson_subject"> Daniala, English</div>
        </div>
        <div class="my_lessons_menu_section">
          <i class="fas fa-ellipsis-h my_lessons_menu_icon"></i>
        </div>
        <div class="my_lessons_card_menu">
          <ul>
            <li><i class="fas fa-calendar-alt"></i> Reschedule</li>
            <li><i class="fas fa-comment"></i> Message Tutor</li>
            <li><i class="fas fa-user"></i> See Tutor Profile</li>
            <li class="my_lessons_cancel"><i class="fas fa-ban"></i> Cancel</li>
          </ul>
        </div>
      </div>
    </div>
    
      <!-- Calendar Tab -->
      <div id="my_lessons_tab_calendar" class="my_lessons_tab_content">
        <?php  require_once('my_lessons_details_calendar_content.php');?>      
      </div>


<!-- Tutors Tab -->
<div id="my_lessons_tab_tutors" class="my_lessons_tab_content">
  <!-- Tutor 1 -->
  <div class="my_lessons_card" style="display: flex; align-items: center; justify-content: space-between; margin-bottom: 18px; position:relative;">
    <div style="display: flex; align-items: center;">
      <img class="my_lessons_avatar" src="https://randomuser.me/api/portraits/women/4.jpg" alt="Daniela" style="width:56px; height:56px; border-radius:50%; margin-right:18px;">
      <div>
        <a href="#" class="my_lessons_name" style="font-weight:bold; text-decoration:underline;">Daniela</a>
        <div style="color:#888;">English</div>
      </div>
    </div>
    <div style="text-align: right;">
      <div style="font-weight:bold;">11 lessons</div>
     
      <!-- <div style="color:#888; font-size:15px;">to schedule <i class="fas fa-sync-alt" style="color:#3fb37f; margin-left:5px;"></i></div> -->

        <div style="color:#888; font-size:15px; display:inline-block; position:relative;">
          to schedule 
          <span class="my-subscription-tooltip-anchor" style="position:relative;">
            <i class="fas fa-sync-alt" style="color:#3fb37f; margin-left:5px; cursor:pointer;"></i>
            <div class="my-subscription-tooltip">
              <div style="font-weight:600; font-size:19px; margin-bottom:6px;">Your Subscription</div>
              <div style="margin-bottom:4px;">8 lessons • $61.44 every 4 weeks</div>
              <div style="font-size:15px; margin-bottom:12px;">Next billing : 2025-03-18</div>
              <a href="YOUR_LINK_HERE" target="_blank" style="font-weight:600; text-decoration:underline; color:#fff;">View Setting</a>
            </div>
          </span>
        </div>

    
    </div>
    <div style="text-align: right;">
      <div style="font-weight:bold;">$5.40</div>
      <div style="color:#888; font-size:15px;">per lesson</div>
    </div>
    <div style="position:relative;">
      <span class="tutor-action-dot"><i class="fas fa-ellipsis-h"></i></span>
      <div class="tutor-action-menu">
        <ul>
          <li class="open_step1"><i class="fas fa-comment"></i> Message Tutor</li>
          <li class="my_lesson_tutor_detail_change_your_plan_button"><i class="fas fa-dollar-sign"></i> Change your plan</li>
          <a href="my_lessons_details_calendar_content_reschedule.php"><li><i class="fas fa-calendar-alt"></i> Schedule lessons</li></a>
          <li id="my_lessons_tutors_tab_add_extra_lessons_open_modal"><i class="fas fa-wallet"></i> Add extra lessons</li>
          <li class="openTransfer"><i class="fas fa-sync-alt"></i> Transfer lessons or subscription</li>
        </ul>
      </div>
    </div>
  </div>

  <!-- Tutor 2 -->
  <div class="my_lessons_card" style="display: flex; align-items: center; justify-content: space-between; margin-bottom: 18px; position:relative;">
    <div style="display: flex; align-items: center;">
      <img class="my_lessons_avatar" src="https://randomuser.me/api/portraits/women/68.jpg" alt="Patricia" style="width:56px; height:56px; border-radius:50%; margin-right:18px;">
      <div>
        <a href="#" class="my_lessons_name" style="font-weight:bold; text-decoration:underline;">Patricia</a>
        <div style="color:#888;">English</div>
      </div>
    </div>

    <div style="text-align: right;">
      <div style="font-weight:bold;">0 lessons</div>
      <div style="color:#888; font-size:15px;">to schedule</div>
    </div>
    <div style="text-align: right;">
      <div style="font-weight:bold;">$11.00</div>
      <div style="color:#888; font-size:15px;">per lesson</div>
    </div>
    <div style="position:relative;">
      <span class="tutor-action-dot"><i class="fas fa-ellipsis-h"></i></span>
      <div class="tutor-action-menu">
        <ul>
          <li><i class="fas fa-comment"></i> Message Tutor</li>
          <li><i class="fas fa-dollar-sign"></i> Change your plan</li>
          <li><i class="fas fa-calendar-alt"></i> Schedule lessons</li>
          <li><i class="fas fa-wallet"></i> Add extra lessons</li>
          <li><i class="fas fa-sync-alt"></i> Transfer lessons or subscription</li>
        </ul>
      </div>
    </div>
  </div>

  <!-- Tutor 3 -->
  <div class="my_lessons_card" style="display: flex; align-items: center; justify-content: space-between; margin-bottom: 18px; position:relative;">
    <div style="display: flex; align-items: center;">
      <img class="my_lessons_avatar" src="https://randomuser.me/api/portraits/men/32.jpg" alt="Guy Hawkins" style="width:56px; height:56px; border-radius:50%; margin-right:18px;">
      <div>
        <a href="#" class="my_lessons_name" style="font-weight:bold; text-decoration:underline;">Guy Hawkins</a>
        <div style="color:#888;">English</div>
      </div>
    </div>
    <div style="text-align: right;">
      <div style="font-weight:bold;">0 lessons</div>
      <div style="color:#888; font-size:15px;">to schedule</div>
    </div>
    <div style="text-align: right;">
      <div style="font-weight:bold;">$7.00</div>
      <div style="color:#888; font-size:15px;">per lesson</div>
    </div>
    <div style="position:relative;">
      <span class="tutor-action-dot"><i class="fas fa-ellipsis-h"></i></span>
      <div class="tutor-action-menu">
        <ul>
          <li><i class="fas fa-comment"></i> Message Tutor</li>
          <li><i class="fas fa-dollar-sign"></i> Change your plan</li>
          <li><i class="fas fa-calendar-alt"></i> Schedule lessons</li>
          <li><i class="fas fa-wallet"></i> Add extra lessons</li>
          <li><i class="fas fa-sync-alt"></i> Transfer lessons or subscription</li>
        </ul>
      </div>
    </div>
  </div>

  <!-- Tutor 4 -->
  <div class="my_lessons_card" style="display: flex; align-items: center; justify-content: space-between; margin-bottom: 18px;">
    <div style="display: flex; align-items: center;">
      <img class="my_lessons_avatar" src="https://randomuser.me/api/portraits/women/4.jpg" alt="Daniela" style="width:56px; height:56px; border-radius:50%; margin-right:18px;">
      <div>
        <a href="#" class="my_lessons_name" style="font-weight:bold; text-decoration:underline;">Daniela</a>
        <div style="color:#888;">English</div>
      </div>
    </div>
    <div style="text-align: right;">
      <div style="font-weight:bold;">1 lessons</div>
      <div style="color:#888; font-size:15px;">to schedule</div>
    </div>
    <div style="text-align: right;">
      <div style="font-weight:bold;">$5.00</div>
      <div style="color:#888; font-size:15px;">per lesson</div>
    </div>
    <div style="display:flex;gap:7px;">
      <button class="open_step1" style="background:transparent; border:1.5px solid #ececec; border-radius:8px; padding:7px 9px; margin-right:5px; cursor:pointer;">
        <i class="fas fa-comment" style="font-size:17px;"></i>
      </button>
      <a href="my_lessons_details_calendar_content_reschedule.php"><button style="background:#fff; border:2px solid #232323; border-radius:8px; padding:7px 17px; font-weight:bold; cursor:pointer;">
        Shedule Lesson
      </button></a>
    </div>
  </div>

  <!-- Tutor 5 -->
  <div class="my_lessons_card" style="display: flex; align-items: center; justify-content: space-between; margin-bottom: 18px;">
    <div style="display: flex; align-items: center;">
      <img class="my_lessons_avatar" src="https://randomuser.me/api/portraits/men/41.jpg" alt="Jacob Jones" style="width:56px; height:56px; border-radius:50%; margin-right:18px;">
      <div>
        <a href="#" class="my_lessons_name" style="font-weight:bold; text-decoration:underline;">Jacob Jones</a>
        <div style="color:#888;">English</div>
      </div>
    </div>
    <div style="text-align: right;">
      <div style="font-weight:bold;">Subscription cancelled</div>
    </div>
    <div style="text-align: right;">
      <div style="font-weight:bold;">$10.00</div>
      <div style="color:#888; font-size:15px;">per lesson</div>
    </div>
    <div style="display:flex;gap:7px;">
      <button style="background:transparent; border:1.5px solid #ececec; border-radius:8px; padding:7px 9px; margin-right:5px; cursor:pointer;">
        <i class="fas fa-comment" style="font-size:17px;"></i>
      </button>
      <button style="background:#fff; border:2px solid #232323; border-radius:8px; padding:7px 17px; font-weight:bold; cursor:pointer;">
        Resubscribe
      </button>
    </div>
  </div>
</div>

</div>

  <!-- jQuery + Logic -->
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  <script src="js/my_lessons_details.js"></script>
  <script src="js/my_lessons_tutor_profile_details_send_message.js"></script>

  <?php require_once('my_lesson_details_calendar_cancel.php');?>
  <?php require_once('my_lesson_details_calendar_empty_slot.php');
  ?>
  <?php require_once('my_lesson_details_calendar_show_details.php');?>
  <?php require_once('my_lesson_details_calendar_show_rating.php');?>
  <?php require_once('my_lesson_details_calendar_show_feedback.php'); ?>

  <?php require_once('../../theme/alpha/layout/transfer_lessons.php');?>

  <?php require_once('my_lessons_tutor_profile_details_send_message.php'); ?>
  <?php require_once('my_lesson_details_tutor_details.php');
  ?>



