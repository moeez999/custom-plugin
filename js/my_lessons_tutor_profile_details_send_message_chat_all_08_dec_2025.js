    var me = {
      name: "You",
      avatar: "https://i.pravatar.cc/150?img=9"
    };
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
          {from: "other", text: "Because I didn’t attend the lesson", time: "11:00", date: "5/18/2025"},
          {from: "me", text: "Schedule your next lesson", time: "11:02", date: "5/18/2025"},
          {from: "other", text: "Thank you for understanding.", time: "11:03", date: "5/18/2025"},
          {from: "me", text: "No worries, let me know if you want to reschedule!", time: "11:04", date: "5/18/2025"},
          {from: "other", text: "Sure, I will book a new lesson.", time: "11:05", date: "5/18/2025"}
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
          {from: "other", text: "Hi Latingles! preply sent me this message.", time: "11:14", date: "5/7/2025"},
          {from: "me", text: "Welcome Jonathan! How can I help you today?", time: "11:16", date: "5/7/2025"}
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
          {from: "other", text: "You've added 4 hours of lessons!", time: "14:00", date: "5/13/2025"},
          {from: "me", text: "Great, let's plan your next session!", time: "14:04", date: "5/13/2025"}
        ]
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
          {from: "other", text: "Hi Latingles, Thank you for showing me the details.", time: "18:00", date: "5/6/2025"},
          {from: "me", text: "You’re welcome Eleanor!", time: "18:04", date: "5/6/2025"}
        ]
      }
    ];

    function renderChatList(selectedIdx) {
      var $list = $("#message_all_chat_list").empty();
      chats.forEach(function(chat, idx) {
        var selected = (idx === selectedIdx) ? "selected" : "";
        var status = chat.status;
        var unread = chat.unread_count > 0 ? `<span class="unread_count_badge">${chat.unread_count}</span>` : "";
        var html = `
          <div class="chat-row-wrap">
            <li class="${selected}" data-idx="${idx}" data-status="${status}">
              <img class="message_all_chat_list_avatar" src="${chat.avatar}">
              <div class="message_all_chat_meta">
                <div class="message_all_chat_line1"><span class="message_all_name">${chat.name}</span><span class="message_all_date">${chat.date}</span></div>
                <div class="message_all_preview">${chat.preview}</div>
              </div>
              ${unread}
            </li>
            <hr class="chat-hr">
          </div>
        `;
        $list.append(html);
      });
    }

    // Details Panel with scroll & fixed buttons
    function renderDetails(idx) {
      var chat = chats[idx];
      var details = chat.details;
      var ratingStars = '';
      for (var i = 0; i < 5; i++) ratingStars += "☆";
      var detailsHTML = `
        <img class="details_profile_avatar" src="${chat.avatar}">
        <div class="details_profile_name">${chat.name}</div>
        <div class="details_profile_stars">${ratingStars}<span class="details_profile_reviews">(${details.reviews})</span></div>
        <div class="details_profile_price">${details.price}<span class="details_profile_perlesson">per lesson</span></div>
        <div class="details_profile_btnrow">
          <button class="details_profile_btn"  onclick="openShareModal()">
            <svg viewBox="0 0 24 24"><circle cx="18" cy="5" r="3"/><circle cx="6" cy="12" r="3"/><circle cx="18" cy="19" r="3"/><path d="M8.59 13.51l6.83 3.98M15.41 6.51l-6.82 3.98" stroke="#232323" stroke-width="2" fill="none"/></svg>
            Share
          </button>
          <button class="details_profile_btn">
            <svg viewBox="0 0 24 24"><rect x="4" y="7" width="16" height="13" rx="2" stroke="#232323" stroke-width="2" fill="none"/><path d="M4 7l8 6 8-6" stroke="#232323" stroke-width="2" fill="none"/></svg>
            Archive
          </button>
        </div>
        <div class="details_section_label"><svg viewBox="0 0 24 24"><path d="M4 6h16M4 10h16M4 14h16M4 18h16" stroke="#232323" stroke-width="2" fill="none"/></svg> Subject</div>
        <div class="details_section_value">${details.subject}</div>
        <div class="details_hr"></div>
        <div class="details_section_label"><svg viewBox="0 0 24 24"><path d="M9 4v2M15 4v2M4 8h16M5 4h14a1 1 0 0 1 1 1v14a1 1 0 0 1-1 1H5a1 1 0 0 1-1-1V5a1 1 0 0 1 1-1z" stroke="#232323" stroke-width="2" fill="none"/><circle cx="12" cy="16" r="1.5" fill="#232323"/></svg> Tutor’s time</div>
        <div class="details_section_value">${details.tutorTime}</div>
        <div class="details_hr"></div>
        <div class="details_section_label"><svg viewBox="0 0 24 24"><circle cx="12" cy="12" r="10" stroke="#232323" stroke-width="2" fill="none"/><circle cx="12" cy="16" r="1" fill="#232323"/><path d="M12 8v4" stroke="#232323" stroke-width="2" fill="none"/></svg> Details</div>
        <div class="details_section_value">Main reason for lesson:<br>${details.mainReason}<br>Level of knowledge: ${details.knowledge}</div>
        <div style="height: 25px;"></div>
      `;
      $("#message_all_details_scroll").html(detailsHTML);

      // --- Fixed Button Bar ---
      var btnHTML = `
        <button class="message_all_btn_schedule">
          <svg viewBox="0 0 24 24"><rect x="3" y="5" width="18" height="16" rx="2.5" stroke="#fff" stroke-width="2"/><path d="M16 3v4M8 3v4M3 9h18" stroke="#fff" stroke-width="2"/><circle cx="16" cy="13" r="1.5" fill="#fff"/></svg>
          Shedule Lesson
        </button>
        <button class="message_all_btn_white">
          <svg viewBox="0 0 24 24"><rect x="2" y="9" width="20" height="11" rx="2" stroke="#232323" stroke-width="2" fill="none"/><rect x="6.5" y="13.5" width="3" height="3" rx="1.5" fill="#232323"/><path d="M17 11v2" stroke="#232323" stroke-width="2" fill="none"/><path d="M14 13h6" stroke="#232323" stroke-width="2" fill="none"/></svg>
          Entre Classroom
        </button>
        <button class="message_all_btn_white">
          <svg viewBox="0 0 24 24"><path d="M15 20h7" stroke="#232323" stroke-width="2"/><rect x="2" y="4" width="20" height="13" rx="2" stroke="#232323" stroke-width="2" fill="none"/><path d="M7 8h10M7 12h4" stroke="#232323" stroke-width="2"/></svg>
          Post Review
        </button>
      `;
      $("#message_all_details_btns").html(btnHTML);
    }

    function renderChat(idx) {
      var chat = chats[idx];
      $("#message_all_chat_header img").attr("src", chat.avatar);
      $("#message_all_chat_header .message_all_name").text(chat.name);
      var $msg = $("#message_all_messages").empty();
      var lastDate = "";
      chat.messages.forEach(function(m, i) {
        if (m.date && m.date !== lastDate) {
          $msg.append(`<div class="message_all_date_separator">${m.date}</div>`);
          lastDate = m.date;
        }
        var isMe = m.from === "me";
        var senderName = isMe ? me.name : chat.name;
        var senderAvatar = isMe ? me.avatar : chat.avatar;
        var meClass = isMe ? "me" : "";
        $msg.append(`
          <div class="message_all_message ${meClass}">
            <img class="message_all_avatar" src="${senderAvatar}">
            <div class="message_all_message_content">
              <span>${senderName} <span style="color:${isMe ? '#fff':'#868686'};font-weight:400;">${m.time}</span></span>
              <div>${m.text}</div>
            </div>
          </div>
        `);
      });
      $("#message_all_messages").scrollTop($("#message_all_messages")[0].scrollHeight);
    }

    // Tab filtering
    $('#message_all_tabs').on('click', 'li', function() {
      var tab = $(this).data('tab');
      $('#message_all_tabs li').removeClass('active');
      $(this).addClass('active');
      $("#message_all_chat_list li").each(function() {
        var $li = $(this);
        if (tab === 'all') $li.show();
        else if (tab === 'unread') $li.toggle(chats[$li.data('idx')].status === "unread");
        else if (tab === 'archived') $li.toggle(chats[$li.data('idx')].status === "archived");
      });
    });

    // Chat switching (remove unread count when opened)
    $("#message_all_chat_list").on("click", "li", function() {
      var idx = $(this).data("idx");
      if (chats[idx].unread_count > 0) {
        chats[idx].unread_count = 0;
        chats[idx].status = "read";
      }
      renderChatList(idx);
      renderChat(idx);
      renderDetails(idx);
    });

    // Send message
    $('#message_all_compose textarea').on('keypress', function(e) {
      if (e.which === 13 && !e.shiftKey) {
        e.preventDefault();
        var msg = $(this).val().trim();
        if (msg) {
          var $selected = $("#message_all_chat_list li.selected");
          var idx = $selected.data("idx") || 0;
          var now = new Date();
          var hh = now.getHours().toString().padStart(2,'0');
          var mm = now.getMinutes().toString().padStart(2,'0');
          chats[idx].messages.push({from: "me", text: msg, time: hh+":"+mm, date: "Today"});
          chats[idx].status = "read";
          chats[idx].unread_count = 0;
          renderChatList(idx);
          renderChat(idx);
          renderDetails(idx);
          $(this).val('');
        }
      }
    });

    // On load
    $(function() {
      renderChatList(0);
      renderChat(0);
      renderDetails(0);
    });
