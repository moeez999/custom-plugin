<!-- Modal -->
<div id="send_message_modal" class="send_message_overlay" style="display:none;">
  <div class="send_message_container">
    <span id="send_message_close" class="send_message_close">&times;</span>

    <!-- Step 1 -->
    <div class="send_message_step send_message_step1 active" data-step="1">
      <img src="https://randomuser.me/api/portraits/women/4.jpg" alt="Tutor Avatar" class="send_message_avatar"/>
      <h2 class="send_message_title">Contact Daniela</h2>
      <p class="send_message_subtitle">Introduce yourself to the tutor, share your learning goals and ask any questions</p>
      <textarea id="send_message_text" class="send_message_textarea" placeholder="Hi Daniela! …"></textarea>
      <div class="send_message_share">
        <label><input type="checkbox" id="send_message_checkbox"/>Get the response you’re looking for. Share your message with other tutors</label>
        <div class="send_message_share_images">
          <img src="https://randomuser.me/api/portraits/men/32.jpg" alt="Tutor 1"/>
          <img src="https://randomuser.me/api/portraits/women/65.jpg" alt="Tutor 2"/>
        </div>
      </div>
      <button id="send_message_submit" class="send_message_button">Send message</button>
    </div>

    <!-- Step 2 -->
    <div class="send_message_step send_message_step2" data-step="2">
      <img src="https://randomuser.me/api/portraits/women/4.jpg" alt="Tutor Avatar" class="send_message_avatar"/>
      <h2 class="send_message_title">Message sent</h2>
      <p class="send_message_subtitle">Excited to start your learning journey?<br/>Book lesson now, secure the best lesson time.</p>
      <button id="send_message_book" class="send_message_btn send_message_primary"><span class="send_message_icon">⚡</span>Book trial lesson</button>
      <button id="send_message_more" class="send_message_btn send_message_secondary">Show More Tutors</button>
    </div>

    <!-- Step 3 -->
    <div class="send_message_step send_message_step3" data-step="3">
      <div class="send_message_header3">
        <img src="https://randomuser.me/api/portraits/women/4.jpg" alt="Tutor Avatar" class="send_message_avatar3"/>
        <div>
          <h2 class="send_message_title3">Book a trial lesson</h2>
          <p class="send_message_subtitle3">To meet your classmates and teachers</p>
        </div>
      </div>
      <div class="send_message_tabs">
        <button id="send_message_tab25" class="send_message_tab active">25 min</button>
        <button id="send_message_tab50" class="send_message_tab">50 min</button>
      </div>
      <div class="send_message_calendar">
        <button id="send_message_prev_week" class="send_message_nav">&lsaquo;</button>
        <div class="send_message_week">
          <div class="send_message_date"><div class="send_message_day">sat</div><div class="send_message_number">16</div></div>
          <div class="send_message_date"><div class="send_message_day">sun</div><div class="send_message_number">17</div></div>
          <div class="send_message_date selected"><div class="send_message_day">mon</div><div class="send_message_number">18</div></div>
          <div class="send_message_date"><div class="send_message_day">tue</div><div class="send_message_number">19</div></div>
          <div class="send_message_date"><div class="send_message_day">wed</div><div class="send_message_number">20</div></div>
          <div class="send_message_date"><div class="send_message_day">thu</div><div class="send_message_number">21</div></div>
          <div class="send_message_date"><div class="send_message_day">fri</div><div class="send_message_number">22</div></div>
        </div>
        <button id="send_message_next_week" class="send_message_nav">&rsaquo;</button>
      </div>
      <div class="send_message_section">
        <div class="send_message_section_title">🌙 Night</div>
        <div class="send_message_slots">
          <button class="send_message_slot">3:00 AM</button>
          <button class="send_message_slot">3:30 AM</button>
        </div>
      </div>
      <div class="send_message_section">
        <div class="send_message_section_title">☀️ Morning</div>
        <div class="send_message_slots">
          <button class="send_message_slot">9:30 AM</button>
          <button class="send_message_slot">10:00 AM</button>
          <button class="send_message_slot">10:30 AM</button>
          <button class="send_message_slot">11:00 AM</button>
        </div>
      </div>
      <button id="send_message_continue" class="send_message_button">Continue</button>
    </div>

    <!-- Step 4 -->
    <div class="send_message_step send_message_step4" data-step="4">
      <div class="send_message_checkout">
        <div class="checkout_left">
          <div class="teacher_card">
            <img src="https://randomuser.me/api/portraits/women/4.jpg" alt="Avatar" class="tc_avatar"/>
            <div><div class="tc_lang">English</div><h3 class="tc_name">Daniela</h3></div>
            <div class="tc_rating">★ 5 <span>(20 reviews)</span></div>
          </div>
          <div class="tc_badges">
            <span class="badge verified">Verified</span>
            <span class="badge professional">Professional</span>
          </div>
          <hr/>
          <div class="lesson_info">
            <p>5 lessons per week</p>
            <ul>
              <li>That’s 20 lessons every 4 weeks</li>
              <li>Standard lessons last 50 minutes</li>
            </ul>
          </div>
          <hr/>
          <div class="order_summary">
            <h4>Your order</h4>
            <div class="order_line"><span>20 lessons (US$5.40/lesson)</span><span>US$108.00</span></div>
            <div class="order_line"><span>Processing fee <span class="tooltip">?</span></span><span>US$5.40</span></div>
            <hr/>
            <div class="order_total"><strong>Total</strong><span>US$113.40 <small>every 4 weeks</small></span></div>
            <a href="#" class="promo_code">Have a promo code?</a>
          </div>
          <div class="info_box info_switch">
            <span class="info_icon">✔️</span>
            <p>You can switch tutors at no cost or cancel your subscription anytime.</p>
          </div>
          <div class="info_box info_charge">
            <p><strong>US$113.40</strong> will be charged to your saved payment method every <strong>4 weeks</strong> for <strong>20 lessons</strong>, unless you cancel.</p>
          </div>
        </div>
        <div class="checkout_right">
          <h3>Payment Method</h3>
          <div class="payment_select">
            <img src="https://i.imgur.com/5RpwZVQ.png" alt="Visa" class="card_icon"/>
            <span>**** **** **** 1267</span>
            <span class="select_arrow">▾</span>
          </div>
          <button id="send_message_confirm" class="confirm_button">Confirm monthly subscription</button>
          <hr/>
          <div class="review_carousel">
            <div class="review_rating">★ 5 <span>20 reviews</span></div>
            <div class="review_nav"><button id="review_prev">‹</button><button id="review_next">›</button></div>
            <div class="review_card"><img src="https://randomuser.me/api/portraits/men/45.jpg" alt="John" class="review_avatar"/><p>Daniela is the nicest, and most engaging teacher I've ever met. He has very good patience, and I would recommend booking a class with him.</p><div class="review_author">John</div></div>
          </div>
        </div>
      </div>
    </div>

  </div>
</div>
