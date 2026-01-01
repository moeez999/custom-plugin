var me = {
  name: "You",
  avatar: "https://i.pravatar.cc/150?img=9"
};

// 3-dots for messages
var DOTS_ICON_PATH = "img/my_students/dots_icon.svg";

// other icons – change these paths whenever you want
var ICONS = {
  share:      "img/my_students/share_icon.svg",
  archive:    "img/my_students/archive_icon.svg",
  subject:    "img/my_students/subject_icon.svg",
  time:       "img/my_students/time_icon.svg",
  details:    "img/my_students/details_icon.png",
  schedule:   "img/my_students/schedule_icon.svg",
  classroom:  "img/my_students/classroom_icon.svg",
  review:     "img/my_students/review_icon.svg"
};

/* ===========================
   MESSAGE EDIT MENU (EMOJIS + ACTIONS)
   =========================== */

var my_messages_details_edit_message_menu_ICON_PATHS = {
  emoji_laugh:  "img/my_students/menu_emoji_laugh.png",
  emoji_smile:  "img/my_students/menu_emoji_smile.png",
  emoji_angry:  "img/my_students/menu_emoji_angry.png",
  emoji_shock:  "img/my_students/menu_emoji_shock.png",
  emoji_happy:  "img/my_students/menu_emoji_happy.png",

  action_reply:  "img/my_students/menu_action_reply.svg",
  action_copy:   "img/my_students/menu_action_copy.svg",
  action_edit:   "img/my_students/menu_action_edit.svg",
  action_delete: "img/my_students/menu_action_delete.svg"
};

var my_messages_details_edit_message_menu_HTML = `
  <div id="my_messages_details_edit_message_menu_container">
    <div class="my_messages_details_edit_message_menu_wrapper">

      <div class="my_messages_details_edit_message_menu_emoji_row">
        <button type="button" class="my_messages_details_edit_message_menu_emoji" data-action="emoji_laugh">
          <img src="${my_messages_details_edit_message_menu_ICON_PATHS.emoji_laugh}" alt="Laugh" class="my_messages_details_edit_message_menu_emoji_icon">
        </button>
        <button type="button" class="my_messages_details_edit_message_menu_emoji" data-action="emoji_smile">
          <img src="${my_messages_details_edit_message_menu_ICON_PATHS.emoji_smile}" alt="Smile" class="my_messages_details_edit_message_menu_emoji_icon">
        </button>
        <button type="button" class="my_messages_details_edit_message_menu_emoji" data-action="emoji_angry">
          <img src="${my_messages_details_edit_message_menu_ICON_PATHS.emoji_angry}" alt="Angry" class="my_messages_details_edit_message_menu_emoji_icon">
        </button>
        <button type="button" class="my_messages_details_edit_message_menu_emoji" data-action="emoji_shock">
          <img src="${my_messages_details_edit_message_menu_ICON_PATHS.emoji_shock}" alt="Shock" class="my_messages_details_edit_message_menu_emoji_icon">
        </button>
        <button type="button" class="my_messages_details_edit_message_menu_emoji" data-action="emoji_happy">
          <img src="${my_messages_details_edit_message_menu_ICON_PATHS.emoji_happy}" alt="Happy" class="my_messages_details_edit_message_menu_emoji_icon">
        </button>
      </div>

      <div class="my_messages_details_edit_message_menu_actions">
        <button type="button" class="my_messages_details_edit_message_menu_action" data-action="reply">
          <img src="${my_messages_details_edit_message_menu_ICON_PATHS.action_reply}" alt="Reply" class="my_messages_details_edit_message_menu_action_icon">
          <span class="my_messages_details_edit_message_menu_action_label">Reply</span>
        </button>

        <button type="button" class="my_messages_details_edit_message_menu_action" data-action="copy">
          <img src="${my_messages_details_edit_message_menu_ICON_PATHS.action_copy}" alt="Copy" class="my_messages_details_edit_message_menu_action_icon">
          <span class="my_messages_details_edit_message_menu_action_label">Copy</span>
        </button>

        <button type="button" class="my_messages_details_edit_message_menu_action" data-action="edit">
          <img src="${my_messages_details_edit_message_menu_ICON_PATHS.action_edit}" alt="Edit" class="my_messages_details_edit_message_menu_action_icon">
          <span class="my_messages_details_edit_message_menu_action_label">Edit</span>
        </button>

        <button type="button" class="my_messages_details_edit_message_menu_action my_messages_details_edit_message_menu_action--delete" data-action="delete">
          <img src="${my_messages_details_edit_message_menu_ICON_PATHS.action_delete}" alt="Delete" class="my_messages_details_edit_message_menu_action_icon">
          <span class="my_messages_details_edit_message_menu_action_label">Delete</span>
        </button>
      </div>
    </div>
  </div>
`;

var my_messages_details_edit_message_menu_currentTrigger = null;
var my_messages_details_edit_message_menu_currentMessage = null;

// compose mode: null | "reply" | "edit"
var my_messages_details_edit_message_menu_mode = null;
// edit target: {chatIdx, msgIdx}
var my_messages_details_edit_message_menu_editTarget = null;

/* ===========================
   INIT 3-DOTS MENU
   =========================== */

function my_messages_details_edit_message_menu_init() {
  if (!$('#my_messages_details_edit_message_menu_container').length) {
    $('body').append(my_messages_details_edit_message_menu_HTML);
  }

  // open/close on dots click
  $(document).on('click', '.message_all_more_icon', function (e) {
    e.stopPropagation();
    var $menu = $('#my_messages_details_edit_message_menu_container');
    if ($menu.is(':visible') && my_messages_details_edit_message_menu_currentTrigger === this) {
      my_messages_details_edit_message_menu_close();
    } else {
      my_messages_details_edit_message_menu_open(this);
    }
  });

  // close when clicking outside the menu
  $(document).on('click', function (e) {
    var $menu = $('#my_messages_details_edit_message_menu_container');
    if (!$menu.is(':visible')) return;
    if ($(e.target).closest('#my_messages_details_edit_message_menu_container').length) return;
    my_messages_details_edit_message_menu_close();
  });

  // emoji + actions click
  $('#my_messages_details_edit_message_menu_container').on(
    'click',
    '.my_messages_details_edit_message_menu_emoji, .my_messages_details_edit_message_menu_action',
    function (e) {
      e.stopPropagation();

      var $btn = $(this);
      var action = $btn.data('action') || '';

      // ----- emoji reaction -----
      if ($btn.hasClass('my_messages_details_edit_message_menu_emoji')) {
        var emojiSrc = $btn.find('img').attr('src');

        if (my_messages_details_edit_message_menu_currentMessage && emojiSrc) {
          var $msg = $(my_messages_details_edit_message_menu_currentMessage);
          var $content = $msg.find('.message_all_message_content').first();
          var $reaction = $content.find('.my_messages_details_edit_message_menu_reaction');

          if ($reaction.length === 0) {
            $reaction = $(`
              <div class="my_messages_details_edit_message_menu_reaction">
                <img src="${emojiSrc}" alt="" class="my_messages_details_edit_message_menu_reaction_icon">
              </div>
            `);
            $content.append($reaction);
          } else {
            $reaction.find('img').attr('src', emojiSrc);
          }
        }

        my_messages_details_edit_message_menu_close();
        return;
      }

      // ----- actions (reply, edit, copy, delete) -----
      if (!my_messages_details_edit_message_menu_currentMessage) {
        my_messages_details_edit_message_menu_close();
        return;
      }

      var $row    = $(my_messages_details_edit_message_menu_currentMessage);
      var chatIdx = parseInt($row.data('chat-idx'), 10);
      var msgIdx  = parseInt($row.data('msg-idx'), 10);

      if (isNaN(chatIdx) || isNaN(msgIdx)) {
        my_messages_details_edit_message_menu_close();
        return;
      }

      var chat    = chats[chatIdx];
      var message = chat.messages[msgIdx];
      if (!message) {
        my_messages_details_edit_message_menu_close();
        return;
      }

      if (action === 'reply') {
        my_messages_details_edit_message_menu_enterReplyMode(chat.name, message.text);
      } else if (action === 'edit') {
        my_messages_details_edit_message_menu_enterEditMode(chatIdx, msgIdx, message.text);
      } else if (action === 'copy') {
        if (navigator.clipboard && navigator.clipboard.writeText) {
          navigator.clipboard.writeText(message.text).catch(function () {});
        }
      } else if (action === 'delete') {
        // delete ONLY this message row
        chat.messages.splice(msgIdx, 1);

        // update preview from last message if any
        var lastMsg = chat.messages[chat.messages.length - 1];
        if (lastMsg) {
          chat.preview = lastMsg.text;
          chat.date    = lastMsg.date;
        } else {
          chat.preview = "";
        }

        my_messages_details_edit_message_menu_exitComposeMode();

        renderChatList(chatIdx);
        renderChat(chatIdx);
        renderDetails(chatIdx);
      }

      my_messages_details_edit_message_menu_close();
    }
  );
}

function my_messages_details_edit_message_menu_open(triggerEl) {
  var $trigger = $(triggerEl);
  var $menu = $('#my_messages_details_edit_message_menu_container');
  if (!$menu.length) return;

  my_messages_details_edit_message_menu_currentTrigger = triggerEl;
  my_messages_details_edit_message_menu_currentMessage =
    $trigger.closest('.message_all_message').get(0);

  $(my_messages_details_edit_message_menu_currentMessage)
    .addClass('my_messages_details_edit_message_menu_open');

  $menu.css({ display: 'block', visibility: 'hidden' });

  var triggerOffset = $trigger.offset();
  var triggerHeight = $trigger.outerHeight();
  var menuWidth = $menu.outerWidth();
  var windowWidth = $(window).width();

  var top  = triggerOffset.top + triggerHeight + 8;
  var left = triggerOffset.left - menuWidth + $trigger.outerWidth();
  var padding = 8;

  if (left < padding) left = padding;
  if (left + menuWidth > windowWidth - padding) {
    left = windowWidth - menuWidth - padding;
  }

  $menu.css({
    top:  top + 'px',
    left: left + 'px',
    visibility: 'visible'
  });
}

function my_messages_details_edit_message_menu_close() {
  var $menu = $('#my_messages_details_edit_message_menu_container');
  $menu.css({ display: 'none', visibility: '' });

  if (my_messages_details_edit_message_menu_currentMessage) {
    $(my_messages_details_edit_message_menu_currentMessage)
      .removeClass('my_messages_details_edit_message_menu_open');
  }

  my_messages_details_edit_message_menu_currentTrigger = null;
  my_messages_details_edit_message_menu_currentMessage = null;
}

/* ===========================
   REPLY / EDIT BAR HELPERS
   =========================== */

function my_messages_details_edit_message_menu_enterComposeMode(mode, titleText, previewText, editTarget) {
  my_messages_details_edit_message_menu_mode       = mode || null;
  my_messages_details_edit_message_menu_editTarget = editTarget || null;

  var $container = $('#my_messages_details_edit_message_menu_reply_container');
  if (!$container.length) return;

  $('#my_messages_details_edit_message_menu_reply_title').text(titleText || '');
  $('#my_messages_details_edit_message_menu_reply_preview').text(previewText || '');

  var $textarea = $('#message_all_compose textarea');
  if (mode === 'edit') {
    $textarea.val(previewText || '');
  } else {
    $textarea.val('');
  }

  $container.show();
  $('#message_all_compose').addClass('my_messages_details_edit_message_menu_has_mode');
  $textarea.focus();
}

function my_messages_details_edit_message_menu_enterReplyMode(name, text) {
  var title = 'Reply to ' + (name || '');
  my_messages_details_edit_message_menu_enterComposeMode('reply', title, text || '', null);
}

function my_messages_details_edit_message_menu_enterEditMode(chatIdx, msgIdx, text) {
  my_messages_details_edit_message_menu_enterComposeMode(
    'edit',
    'Edit Message',
    text || '',
    { chatIdx: chatIdx, msgIdx: msgIdx }
  );
}

function my_messages_details_edit_message_menu_exitComposeMode() {
  var $container = $('#my_messages_details_edit_message_menu_reply_container');
  if (!$container.length) return;

  $container.hide();
  $('#my_messages_details_edit_message_menu_reply_title').text('');
  $('#my_messages_details_edit_message_menu_reply_preview').text('');

  $('#message_all_compose').removeClass('my_messages_details_edit_message_menu_has_mode');
  $('#message_all_compose textarea').val('');

  my_messages_details_edit_message_menu_mode       = null;
  my_messages_details_edit_message_menu_editTarget = null;
}

/* send message / save edit */

function my_messages_details_edit_message_menu_sendCurrentText() {
  var $textarea = $('#message_all_compose textarea');
  var msg = $textarea.val().trim();
  if (!msg) return;

  var mode = my_messages_details_edit_message_menu_mode;

  // EDIT existing message
  if (mode === 'edit' && my_messages_details_edit_message_menu_editTarget) {
    var t = my_messages_details_edit_message_menu_editTarget;
    var chatIdx = t.chatIdx;
    var msgIdx  = t.msgIdx;

    if (chats[chatIdx] && chats[chatIdx].messages[msgIdx]) {
      chats[chatIdx].messages[msgIdx].text = msg;
      renderChatList(chatIdx);
      renderChat(chatIdx);
      renderDetails(chatIdx);
    }

    $textarea.val('');
    my_messages_details_edit_message_menu_exitComposeMode();
    return;
  }

  // NORMAL / REPLY -> push new message
  var $selected = $("#message_all_chat_list li.selected");
  var idx = $selected.data("idx");
  if (typeof idx === "undefined") idx = 0;

  var now = new Date();
  var hh = now.getHours().toString().padStart(2, '0');
  var mm = now.getMinutes().toString().padStart(2, '0');

  chats[idx].messages.push({
    from: "me",
    text: msg,
    time: hh + ":" + mm,
    date: "Today"
  });

  chats[idx].status = "read";
  chats[idx].unread_count = 0;

  renderChatList(idx);
  renderChat(idx);
  renderDetails(idx);

  $textarea.val('');

  if (mode === 'reply') {
    my_messages_details_edit_message_menu_exitComposeMode();
  }
}

/* ===========================
   CHAT DATA (with attachments)
   =========================== */

var chats = [
  {
    id: 1,
    name: "Daniela",
    avatar: "https://randomuser.me/api/portraits/women/44.jpg",
    status: "unread",
    date: "5/18/2025",
    preview: "You've added 4 hours of lessons!",
    details: {
      rating: 0,
      reviews: 12,
      price: "$10.00",
      subject: "English",
      tutorTime: "America/Mexico_City GMT -6:00",
      mainReason: "Career/business",
      knowledge: "Absolute beginner"
    },
    unread_count: 1,
    messages: [
      { from: "other", text: "Because I didn’t attend the lesson", time: "11:00", date: "5/18/2025" },
      { from: "me",   text: "Schedule your next lesson",          time: "11:02", date: "5/18/2025" },
      { from: "other", text: "Thank you for understanding.",      time: "11:03", date: "5/18/2025" },
      { from: "me",   text: "No worries, let me know if you want to reschedule!", time: "11:04", date: "5/18/2025" },
      { from: "other", text: "Sure, I will book a new lesson.",   time: "11:05", date: "5/18/2025" }
    ],
    attachments: [
      {
        date: "Wed, 07 May",
        from: "Latingles A.",
        time: "17:09",
        url: "https://docs.google.com/presentation/d/1-example-1",
        label: "Lesson slides – Unit 3",
        status: "Sent"
      },
      {
        date: "Wed, 14 May",
        from: "Latingles A.",
        time: "17:05",
        url: "https://docs.google.com/document/d/1-example-2",
        label: "Homework – Coffee shop dialog",
        status: "Sent"
      }
    ]
  },
  {
    id: 2,
    name: "Jonathan T.",
    avatar: "https://randomuser.me/api/portraits/men/45.jpg",
    status: "unread",
    date: "5/7/2025",
    preview: "Hi Latingles! preply sent me this m...",
    details: {
      rating: 0,
      reviews: 5,
      price: "$14.00",
      subject: "Business English",
      tutorTime: "America/Los_Angeles GMT -8:00",
      mainReason: "Job Interview",
      knowledge: "Intermediate"
    },
    unread_count: 1,
    messages: [
      { from: "other", text: "Hi Latingles! preply sent me this message.", time: "11:14", date: "5/7/2025" },
      { from: "me",   text: "Welcome Jonathan! How can I help you today?", time: "11:16", date: "5/7/2025" }
    ],
    attachments: [
      {
        date: "Tue, 06 May",
        from: "Latingles A.",
        time: "09:15",
        url: "https://docs.google.com/spreadsheets/d/1-example-3",
        label: "Interview vocabulary list",
        status: "Sent"
      }
    ]
  },
  {
    id: 3,
    name: "Karen V.",
    avatar: "https://randomuser.me/api/portraits/women/65.jpg",
    status: "read",
    date: "5/13/2025",
    preview: "You've added 4 hours of lessons!",
    details: {
      rating: 0,
      reviews: 8,
      price: "$11.00",
      subject: "English Conversation",
      tutorTime: "Europe/Madrid GMT +2:00",
      mainReason: "Travel",
      knowledge: "Upper beginner"
    },
    unread_count: 0,
    messages: [
      { from: "other", text: "You've added 4 hours of lessons!", time: "14:00", date: "5/13/2025" },
      { from: "me",   text: "Great, let's plan your next session!", time: "14:04", date: "5/13/2025" }
    ],
    attachments: []
  },
  {
    id: 4,
    name: "Eleanor D.",
    avatar: "https://randomuser.me/api/portraits/women/21.jpg",
    status: "archived",
    date: "5/6/2025",
    preview: "Hi Latingles, Thank you for shoin...",
    details: {
      rating: 0,
      reviews: 3,
      price: "$10.00",
      subject: "IELTS Prep",
      tutorTime: "Asia/Karachi GMT +5:00",
      mainReason: "IELTS Exam",
      knowledge: "Upper intermediate"
    },
    unread_count: 0,
    messages: [
      { from: "other", text: "Hi Latingles, Thank you for showing me the details.", time: "18:00", date: "5/6/2025" },
      { from: "me",   text: "You’re welcome Eleanor!", time: "18:04", date: "5/6/2025" }
    ],
    attachments: []
  }
];

/* ===========================
   EXTRA CHAT DATA (FOR SCROLL)
   =========================== */

var extraChats = [
  {
    id: 10,
    name: "Savannah Nguyen",
    avatar: "https://randomuser.me/api/portraits/women/32.jpg",
    status: "read",
    date: "5/03/2025",
    preview: "Hello! This is the link to join...",
    unread_count: 0,
    details: {
      rating: 0,
      reviews: 6,
      price: "$12.00",
      subject: "English",
      tutorTime: "America/New_York GMT -5:00",
      mainReason: "Conversation",
      knowledge: "Beginner"
    },
    messages: [
      { from: "other", text: "Hello! This is the link to join my class.", time: "16:20", date: "5/03/2025" },
      { from: "me", text: "Thanks Savannah!", time: "16:21", date: "5/03/2025" }
    ],
    attachments: []
  },
  {
    id: 11,
    name: "Guy Hawkins",
    avatar: "https://randomuser.me/api/portraits/men/52.jpg",
    status: "unread",
    date: "7/10/2025",
    preview: "You've added 4 hours of lessons!",
    unread_count: 2,
    details: {
      rating: 0,
      reviews: 9,
      price: "$13.00",
      subject: "Business English",
      tutorTime: "Europe/London GMT +1:00",
      mainReason: "Career growth",
      knowledge: "Intermediate"
    },
    messages: [
      { from: "other", text: "You've added 4 hours of lessons!", time: "09:40", date: "7/10/2025" },
      { from: "other", text: "Would you like to schedule?", time: "09:41", date: "7/10/2025" }
    ],
    attachments: []
  },
  {
    id: 12,
    name: "Jacob Jones",
    avatar: "https://randomuser.me/api/portraits/men/61.jpg",
    status: "read",
    date: "10/24/2024",
    preview: "Hello! This is the link to join...",
    unread_count: 0,
    details: {
      rating: 0,
      reviews: 14,
      price: "$15.00",
      subject: "IELTS",
      tutorTime: "Asia/Dubai GMT +4:00",
      mainReason: "Exam preparation",
      knowledge: "Upper intermediate"
    },
    messages: [
      { from: "other", text: "Hello! This is the link to join my lesson.", time: "12:10", date: "10/24/2024" },
      { from: "me", text: "Thanks Jacob!", time: "12:15", date: "10/24/2024" }
    ],
    attachments: []
  },
  {
    id: 13,
    name: "Ralph Edwards",
    avatar: "https://randomuser.me/api/portraits/men/18.jpg",
    status: "read",
    date: "10/24/2024",
    preview: "Hello! This is the link...",
    unread_count: 0,
    details: {
      rating: 0,
      reviews: 4,
      price: "$9.00",
      subject: "Grammar",
      tutorTime: "Europe/Berlin GMT +2:00",
      mainReason: "Basics",
      knowledge: "Absolute beginner"
    },
    messages: [
      { from: "other", text: "Hello! This is the link to join.", time: "15:00", date: "10/24/2024" }
    ],
    attachments: []
  },
  {
    id: 14,
    name: "Devon Lane",
    avatar: "https://randomuser.me/api/portraits/men/29.jpg",
    status: "unread",
    date: "5/01/2025",
    preview: "Hello! This is the link to join...",
    unread_count: 1,
    details: {
      rating: 0,
      reviews: 7,
      price: "$11.00",
      subject: "Conversation",
      tutorTime: "America/Chicago GMT -6:00",
      mainReason: "Fluency",
      knowledge: "Intermediate"
    },
    messages: [
      { from: "other", text: "Hello! This is the link to join my conversation class.", time: "17:10", date: "5/01/2025" }
    ],
    attachments: []
  }
];

/* merge into main chats list */
chats = chats.concat(extraChats);

/* ===========================
   HELPERS / RENDERING
   =========================== */

function updateUnreadBadge() {
  var count = chats.reduce(function (acc, chat) {
    return acc + (chat.status === "unread" || chat.unread_count > 0 ? 1 : 0);
  }, 0);

  var $badge = $('#message_all_tabs li[data-tab="unread"] .message_all_tab_badge');
  if ($badge.length) {
    $badge.text(count);
    if (count === 0) $badge.hide();
    else $badge.show();
  }
}

function renderChatList(selectedIdx) {
  var $list = $("#message_all_chat_list").empty();

  chats.forEach(function (chat, idx) {
    var selected = idx === selectedIdx ? "selected" : "";
    var status = chat.status;
    var unread = chat.unread_count > 0
      ? '<span class="unread_count_badge">' + chat.unread_count + "</span>"
      : "";

    var html = `
      <div class="chat-row-wrap">
        <li class="${selected}" data-idx="${idx}" data-status="${status}">
          <img class="message_all_chat_list_avatar" src="${chat.avatar}">
          <div class="message_all_chat_meta">
            <div class="message_all_chat_line1">
              <span class="message_all_name">${chat.name}</span>
              <span class="message_all_date">${chat.date}</span>
            </div>
            <div class="message_all_preview">${chat.preview}</div>
          </div>
          ${unread}
        </li>
        <hr class="chat-hr">
      </div>
    `;
    $list.append(html);
  });

  updateUnreadBadge();
}

function renderDetails(idx) {
  var chat = chats[idx];
  var details = chat.details;
  var ratingStars = "";
  for (var i = 0; i < 5; i++) ratingStars += "★";

  var detailsHTML = `
    <img class="details_profile_avatar" src="${chat.avatar}">
    <a href="my_lessons_tutor_profile.php" style="color:black;"><div class="details_profile_name">${chat.name}</div></a>
    <div class="details_profile_stars">${ratingStars}<a href="my_lessons_tutor_profile.php#my_lessons_tutor_profile_reviews_section" style="color:black;"><span class="details_profile_reviews">(${details.reviews})</span></a></div>
    <div class="details_profile_price">${details.price}<span class="details_profile_perlesson">per lesson</span></div>

    <div class="details_profile_btnrow">
      <button class="details_profile_btn" onclick="openShareModal()">
        <img src="${ICONS.share}" class="details_profile_icon" alt="Share">
        Share
      </button>
      <button class="details_profile_btn">
        <img src="${ICONS.archive}" class="details_profile_icon" alt="Archive">
        Archive
      </button>
    </div>

    <div class="details_section_label" style="margin-right:auto; padding-left: 16px;">
      <img src="${ICONS.subject}" class="details_section_icon" alt="">
      Subject
    </div>
    <div class="details_section_value" style="margin-right:auto; padding-left: 29px">${details.subject}</div>

    <div class="details_hr"></div>

    <div class="details_section_label" style="margin-right:auto;padding-left: 16px;">
      <img src="${ICONS.time}" class="details_section_icon" alt="">
      Tutor’s time
    </div>
    <div class="details_section_value"  style="margin-right:auto;padding-left: 29px;">${details.tutorTime}</div>

    <div class="details_hr"></div>

    <div class="details_section_label"  style="margin-right:auto;">
      <img src="${ICONS.details}" class="details_section_icon" alt="">
      Details
    </div>
    <div class="details_section_value" style="margin-right:auto; padding-left: 29px;">
      Main reason for lesson:<br>${details.mainReason}<br>
      Level of knowledge: ${details.knowledge}
    </div>
    <div style="height: 25px;"></div>
  `;

  $("#message_all_details_scroll").html(detailsHTML);

  var btnHTML = `<a href="./my_lessons_details_reshedule.php" class="w-100">
    <button class="message_all_btn_schedule">
      <img src="${ICONS.schedule}" class="message_all_btn_icon" alt="">
      Shedule Lesson
    </button></a>
    <button class="message_all_btn_white">
      <img src="${ICONS.classroom}" class="message_all_btn_icon" alt="">
      Entre Classroom
    </button>
    <button class="message_all_btn_white" id="my_lessons_tutor_profile_send_message_details_post_review_step1_open_modal_button">
      <img src="${ICONS.review}" class="message_all_btn_icon" alt="">
      Post Review
    </button>
  `;
  $("#message_all_details_btns").html(btnHTML);
}

/* ============ ATTACHMENTS RENDERING ============ */

function renderAttachments(idx) {
  var chat = chats[idx];
  var list = (chat && chat.attachments) ? chat.attachments : [];
  var $panelList = $('#message_all_attachments_list');
  if (!$panelList.length) return;

  if (!list.length) {
    $panelList.html('<div class="attachment_no_items">No attachments yet.</div>');
    return;
  }

  var html = "";
  var lastDate = "";

  list.forEach(function (att) {
    if (att.date && att.date !== lastDate) {
      html += '<div class="attachment_date_sep">' + att.date + '</div>';
      lastDate = att.date;
    }

    html += '<div class="attachment_item">';
    html +=   '<div class="attachment_sender_time">' +
                (att.from || '') +
                (att.time ? '<span class="attachment_time">' + att.time + '</span>' : '') +
              '</div>';
    if (att.url) {
      var label = att.label || att.url;
      html += '<a href="' + att.url + '" target="_blank" class="attachment_link">' +
                 label +
              '</a>';
    }
    if (att.status) {
      html += '<div class="attachment_status">' + att.status + '</div>';
    }
    html += '</div>';
  });

  $panelList.html(html);
}

/* ===========================
   RENDER CHAT MESSAGES
   =========================== */

function renderChat(idx) {
  var chat = chats[idx];

  $("#message_all_chat_header img").first().attr("src", chat.avatar);
  $("#message_all_chat_header .message_all_name").text(chat.name);

  var $msg = $("#message_all_messages").empty();
  var lastDate = "";

  chat.messages.forEach(function (m, msgIndex) {
    if (m.date && m.date !== lastDate) {
      $msg.append('<div class="message_all_date_separator">' + m.date + "</div>");
      lastDate = m.date;
    }

    var isMe = m.from === "me";
    var senderName = isMe ? me.name : chat.name;
    var senderAvatar = isMe ? me.avatar : chat.avatar;

    $msg.append(`
      <div class="message_all_message" data-chat-idx="${idx}" data-msg-idx="${msgIndex}">
        <img class="message_all_avatar" src="${senderAvatar}">
        <div class="message_all_message_content">
          <div class="message_all_message_header">
            <span class="message_all_sender">
              ${senderName}
              <span class="message_all_time">${m.time}</span>
            </span>
            <img src="${DOTS_ICON_PATH}" alt="More" class="message_all_more_icon" />
          </div>
          <div class="message_all_message_text">${m.text}</div>
        </div>
      </div>
    `);
  });

  $("#message_all_messages").scrollTop($("#message_all_messages")[0].scrollHeight);
}

/* ===========================
   EVENTS
   =========================== */

$('#message_all_tabs').on('click', 'li', function () {
  var tab = $(this).data('tab');

  $('#message_all_tabs li').removeClass('active');
  $(this).addClass('active');

  $("#message_all_chat_list li").each(function () {
    var $li = $(this);
    var idx = $li.data('idx');
    var chat = chats[idx];

    if (tab === 'all') {
      $li.show();
    } else if (tab === 'unread') {
      $li.toggle(chat.status === "unread" || chat.unread_count > 0);
    } else if (tab === 'archived') {
      $li.toggle(chat.status === "archived");
    }
  });
});

$("#message_all_chat_list").on("click", "li", function () {
  var idx = $(this).data("idx");

  if (chats[idx].unread_count > 0) {
    chats[idx].unread_count = 0;
    chats[idx].status = "read";
  }

  renderChatList(idx);
  renderChat(idx);
  renderDetails(idx);

  // hide attachments panel when switching chats
  $('#message_all_attachments_panel').hide();
});

// send on Enter
$('#message_all_compose textarea').on('keypress', function (e) {
  if (e.which === 13 && !e.shiftKey) {
    e.preventDefault();
    my_messages_details_edit_message_menu_sendCurrentText();
  }
});

// bottom-right buttons
$(document).on('click', '#my_messages_details_edit_message_menu_reply_cancel', function (e) {
  e.preventDefault();
  my_messages_details_edit_message_menu_exitComposeMode();
});

$(document).on('click', '#my_messages_details_edit_message_menu_reply_ok', function (e) {
  e.preventDefault();
  my_messages_details_edit_message_menu_sendCurrentText();
});

// close icon in header bar
$(document).on('click', '#my_messages_details_edit_message_menu_reply_close', function (e) {
  e.preventDefault();
  my_messages_details_edit_message_menu_exitComposeMode();
});

/* ATTACHMENTS TOGGLE / CLOSE */

$(document).on('click', '#message_all_attachments_toggle', function () {
  var $selected = $("#message_all_chat_list li.selected");
  var idx = $selected.data('idx');
  if (typeof idx === 'undefined') idx = 0;

  renderAttachments(idx);
  $('#message_all_attachments_panel').show();
});

$(document).on('click', '#message_all_attachments_close', function () {
  $('#message_all_attachments_panel').hide();
});

/* ===========================
   INIT
   =========================== */

$(function () {
  renderChatList(0);
  renderChat(0);
  renderDetails(0);
  my_messages_details_edit_message_menu_init();
});
