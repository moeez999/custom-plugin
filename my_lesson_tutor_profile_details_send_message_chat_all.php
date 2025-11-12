  <link rel="stylesheet" href="css/my_lesson_tutor_profile_details_send_message_chat_all.css">

 <link rel="stylesheet" href="css/my_lessons_tutor_profile_details_send_message_chat_all_share_modal.css">
  

  <div id="message_all_container">
    <div id="message_all_sidebar">
      <ul id="message_all_tabs">
        <li class="active" data-tab="all">All</li>
        <li data-tab="unread">Unread <span class="message_all_tab_badge">5</span></li>
        <li data-tab="archived">Archived</li>
      </ul>
      <ul id="message_all_chat_list"></ul>
    </div>
    <div id="message_all_chat_window">
      <div id="message_all_chat_header">
        <img src="">
        <div class="message_all_name"></div>
        <div class="message_all_actions">
          <svg viewBox="0 0 24 24"><rect x="2" y="6" width="20" height="14" rx="3" stroke="#232323" stroke-width="2" fill="none"/><path d="M2 8h20" stroke="#232323" stroke-width="2"/></svg>
        </div>
      </div>
      <div id="message_all_messages"></div>
      
      
      <div id="message_all_compose">
  <textarea placeholder="Your message"></textarea>
  <div class="message_all_compose_actions">
    <!-- Attach Icon (Paperclip) -->
    <svg viewBox="0 0 24 24" width="26" height="26">
      <path d="M16.5 13.5l-6.9 6.9a5 5 0 1 1-7.1-7.1l13-13a5 5 0 1 1 7.1 7.1L10.5 19.5a3 3 0 1 1-4.2-4.2l12.5-12.5" stroke="#232323" stroke-width="2" fill="none"/>
    </svg>
    <!-- Emoji Icon -->
    <svg viewBox="0 0 24 24" width="26" height="26">
      <circle cx="12" cy="12" r="10" stroke="#232323" stroke-width="2" fill="none"/>
      <circle cx="9" cy="10" r="1"/>
      <circle cx="15" cy="10" r="1"/>
      <path d="M8 15s1.5 2 4 2 4-2 4-2" stroke="#232323" stroke-width="2" fill="none"/>
    </svg>
    <!-- Microphone Icon (right-aligned) -->
    <svg viewBox="0 0 24 24" width="26" height="26" style="margin-left:auto;">
      <rect x="9" y="2" width="6" height="12" rx="3" stroke="#232323" stroke-width="2" fill="none"/>
      <path d="M5 11v1a7 7 0 0 0 14 0v-1M12 19v3" stroke="#232323" stroke-width="2" fill="none"/>
    </svg>
  </div>
</div>

      
</div>
    <!-- Details Panel -->
    <div id="message_all_details_wrap">
      <div id="message_all_details_scroll"></div>
      <div id="message_all_details_btns"></div>
    </div>
  </div>

  <?php require_once('my_lessons_tutor_profile_details_send_message_chat_all_share_modal.php');?>

  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

  <script src="js/my_lessons_tutor_profile_details_send_message_chat_all.js"></script>
  <script src="js/my_lessons_tutor_profile_details_send_message_chat_all_share_modal.js"></script>
  


