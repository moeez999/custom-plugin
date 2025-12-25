<link rel="stylesheet" href="css/my_lesson_tutor_profile_details_send_message_chat_all.css">
<link rel="stylesheet" href="css/my_lessons_tutor_profile_details_send_message_chat_all_share_modal.css">

<div id="message_all_container">
  <!-- LEFT SIDEBAR -->
  <div id="message_all_sidebar">
    <ul id="message_all_tabs">
      <li class="active" data-tab="all">All</li>
      <li data-tab="unread">
        Unread
        <span class="message_all_tab_badge">0</span>
      </li>
      <li data-tab="archived">Archived</li>
    </ul>
    <ul id="message_all_chat_list"></ul>
  </div>

  <!-- MIDDLE CHAT PANEL -->
  <div id="message_all_chat_window">
    <div id="message_all_chat_header">
      <img src="" alt="">
      <div class="message_all_name"></div>

      <!-- ATTACHMENTS TOGGLE BUTTON -->

      <!-- Archive icon (existing) -->
      <div class="message_all_actions" title="Archive" id="message_all_attachments_toggle">
        <img src="img/my_students/header_archive_icon.svg"
          class="message_all_header_icon"
          alt="Archive"
          style="width:17px; height:15px; border-radius: 0px !important;">
      </div>
    </div>

    <!-- messages rendered dynamically by JS (scrolls independently) -->
    <div id="message_all_messages"></div>

    <!-- COMPOSE AREA (frozen at bottom of middle column) -->
    <div id="message_all_compose">

      <!-- Reply / Edit bar (hidden by default) -->
      <div id="my_messages_details_edit_message_menu_reply_container" style="display:none;">
        <div class="my_messages_details_edit_message_menu_reply_header">
          <div class="my_messages_details_edit_message_menu_reply_texts">
            <div id="my_messages_details_edit_message_menu_reply_title"
              class="my_messages_details_edit_message_menu_reply_title">
              <!-- Reply to Daniela / Edit Message -->
            </div>
            <div id="my_messages_details_edit_message_menu_reply_preview"
              class="my_messages_details_edit_message_menu_reply_preview">
              <!-- original message preview -->
            </div>
          </div>
          <button type="button"
            id="my_messages_details_edit_message_menu_reply_close"
            class="my_messages_details_edit_message_menu_reply_close">
            ×
          </button>
        </div>
      </div>

      <textarea placeholder="Your message"></textarea>

      <div class="message_all_compose_actions">
        <img src="img/my_students/upload_icon.svg"
          class="message_all_compose_icon"
          alt="Attach">
        <img src="img/my_students/emoji_icon.svg"
          class="message_all_compose_icon"
          alt="Emoji">
        <img src="img/my_students/voice_icon.svg"
          class="message_all_compose_icon message_all_compose_icon_right"
          alt="Voice">

        <!-- bottom-right X / ✓ buttons -->
        <div class="my_messages_details_edit_message_menu_actions_btnwrap">
          <button type="button"
            id="my_messages_details_edit_message_menu_reply_cancel"
            class="my_messages_details_edit_message_menu_reply_btn my_messages_details_edit_message_menu_reply_btn--cancel">
            ×
          </button>
          <button type="button"
            id="my_messages_details_edit_message_menu_reply_ok"
            class="my_messages_details_edit_message_menu_reply_btn my_messages_details_edit_message_menu_reply_btn--ok">
            ✓
          </button>
        </div>
      </div>
    </div>
  </div>

  <!-- RIGHT DETAILS PANEL -->
  <div id="message_all_details_wrap">
    <div id="message_all_details_header">Details</div>
    <div id="message_all_details_scroll"></div>
    <div id="message_all_details_btns"></div>

    <!-- ATTACHMENTS OVERLAY PANEL (covers details when open) -->
    <div id="message_all_attachments_panel">
      <div id="message_all_attachments_header">
        <span>Attachments</span>
        <button type="button" id="message_all_attachments_close">×</button>
      </div>
      <div id="message_all_attachments_list"></div>
    </div>
  </div>
</div>

<?php require_once('my_lessons_tutor_profile_details_send_message_chat_all_share_modal.php'); ?>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="js/my_lessons_tutor_profile_details_send_message_chat_all.js"></script>
<script src="js/my_lessons_tutor_profile_details_send_message_chat_all_share_modal.js"></script>

<?php require_once('my_lessons_tutor_profile_send_message_details_post_review.php'); ?>