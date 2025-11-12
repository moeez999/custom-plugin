  <!-- FontAwesome + jQuery -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css"/>
  <!-- <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script> -->
   
  <div id="my_lessons_page">
    <!-- YOUR PAGE CONTENT -->
    <header><!-- … --></header>
    <main><!-- … --></main>

    <!-- TRIGGER BUTTON -->
    <!-- <button id="open_step1" style="position:absolute; top:200px; right:80px;">Send Message</button> -->

    <!-- BACKDROP -->
    <div id="my_modal_backdrop"></div>

    <!-- STEP 1: Send Message Modal -->
    <div id="send_message_modal" class="my_modal">
      <div class="my_modal_header">
        <div class="left">
          <i class="fas fa-arrow-left back_to_list"></i>
          <img src="https://via.placeholder.com/32" alt="Daniela">
          <h2>Daniela</h2>
        </div>
        <div class="right">
          <a href="#"><i class="fas fa-calendar-alt"></i>Schedule Lessons</a>
          <i class="fas fa-folder"></i>
          <i class="fas fa-times close_all"></i>
        </div>
      </div>
      <div id="send_message_body">
        <div class="sm_date">Today</div>
        <div class="sm_msg">
          <img class="avatar" src="https://via.placeholder.com/28" alt="">
          <div class="content">
            <div class="meta">Daniela <span>09:34</span></div>
            <p>Good morning, I want to confirm our meeting today…</p>
          </div>
        </div>
        <div class="sm_msg">
          <img class="avatar" src="https://via.placeholder.com/28" alt="">
          <div class="content">
            <div class="meta">Latingles <span>11:06</span></div>
            <p>I'm already in, is anyone joining</p>
          </div>
        </div>
        <div class="sm_msg">
          <img class="avatar" src="https://via.placeholder.com/28" alt="">
          <div class="content">
            <div class="meta">Latingles <span>11:06</span></div>
            <p>Yes Please wait for me! Thank you</p>
          </div>
        </div>
      </div>
      <div id="send_message_footer">
        <i class="fas fa-paperclip icon"></i>
        <i class="far fa-smile icon"></i>
        <input type="text" placeholder="Your message">
        <i class="fas fa-microphone send"></i>
      </div>
    </div>

    <!-- STEP 2: Messages List Modal -->
    <div id="messages_list_modal" class="my_modal">
      <div class="my_modal_header">
        <div class="left">
          <i class="fas fa-arrow-left back_to_step1"></i>
          <h2>Messages</h2>
        </div>
        <div class="right">
          <i class="fas fa-expand-arrows-alt"></i>
          <i class="fas fa-times close_all"></i>
        </div>
      </div>
      <div id="messages_list_body">
        <div class="msgs_tabs">
          <div class="tab active">All</div>
          <div class="tab">Unread <span class="badge">2</span></div>
          <div class="tab">Archived</div>
        </div>
        <!-- Sample Items -->
        <div class="message_item">
          <img src="https://via.placeholder.com/36" alt="">
          <div class="info">
            <h3>Daniela</h3>
            <p>But I must explain to you how all this mistaken…</p>
          </div>
          <div class="date">Sat</div>
        </div>
        <div class="message_item">
          <img src="https://via.placeholder.com/36" alt="">
          <div class="info">
            <h3>Wade Warren</h3>
            <p>No one rejects, dislikes, or avoids pleasure itself…</p>
          </div>
          <div class="date">Fri</div>
        </div>
        <div class="message_item">
          <img src="https://via.placeholder.com/36" alt="">
          <div class="info">
            <h3>Camila</h3>
            <p>On the other hand, we denounce with righteous…</p>
          </div>
          <div class="date">Mon</div>
        </div>
        <!-- add more as needed -->
      </div>
    </div>

  </div><!-- /#my_lessons_page -->

