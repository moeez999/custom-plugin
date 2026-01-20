<!-- Modal -->
<div id="send_message_modal" class="send_message_overlay" style="display: none;">
  <div class="send_message_container">
    <span id="send_message_close" class="send_message_close">&times;</span>

    <!-- Step 1 -->
    <div class="send_message_step send_message_step1" data-step="1">
      <img src="https://randomuser.me/api/portraits/women/4.jpg" alt="Tutor Avatar" class="send_message_avatar"/>
      <h2 class="send_message_title mb-0">Contact Daniela</h2>
      <p class="send_message_subtitle mt-1">Introduce yourself to the tutor, share your learning goals and ask any questions</p>
      <textarea id="send_message_text" class="send_message_textarea" placeholder="Hi Daniela! …"></textarea>
      <div class="send_message_share d-flex justify-between">
        <div style="display: flex;
                align-items: flex-start;
                justify-content: start;
                text-align: left;">
                <span class="checkbox selected send-message-checkbox" style="min-width: 20px; margin-right: 10px; cursor: pointer"></span>
                <p>Get the response you’re looking for. Share your message with other tutors</p>
        </div>
        <div class="send_message_share_images" style="min-width: 60px;display: flex;
              align-items: center;">
          <img src="https://randomuser.me/api/portraits/men/4.jpg" alt="Tutor 1"/>
          <img src="https://randomuser.me/api/portraits/women/4.jpg" alt="Tutor 2"/>
          <img src="https://randomuser.me/api/portraits/women/65.jpg" alt="Tutor 3"/>
        </div>
      </div>
      <button id="send_message_submit" class="send_message_button">Send message</button>
    </div>

    <!-- Step 2 -->
    <div class="send_message_step send_message_step2" data-step="2">
      <img src="https://randomuser.me/api/portraits/women/4.jpg" alt="Tutor Avatar" class="send_message_avatar"/>
      <h2 class="send_message_title mb-3">Message sent</h2>
      <p class="send_message_subtitle" style="margin-bottom:25px !important;">Excited to start your learning journey? <br>
          Book lesson now, secure the best lesson time.
      </p>
      <button id="send_message_book" class="send_message_btn send_message_primary"><span class="send_message_icon"><img src="img/iconify.svg"></span>Book trial lesson</button>
      <button id="send_message_more" class="send_message_btn send_message_secondary">Show More Tutors</button>
    </div>

    <!-- Step 3 -->
    <div class="send_message_step send_message_step3" data-step="3">
      <div class="send_message_header3">
        <img src="https://randomuser.me/api/portraits/women/4.jpg" alt="Tutor Avatar" class="send_message_avatar3"/>
        <div style="text-align: left">
          <h2 class="send_message_title3">Book a trial lesson</h2>
          <p class="send_message_subtitle3">To meet your classmates and teachers</p>
        </div>
      </div>
      <div class="send_message_tabs">
        <button id="send_message_tab25" class="send_message_tab active">25 min</button>
        <button id="send_message_tab50" class="send_message_tab">50 min</button>
      </div>
      <div class="calendar-box">
        <div class="arrow-box-calendar">
            <div class="arrow-calendar" data-target="1">
              <img src="img/left-arrow.svg">
            </div>
            <h2 class="cal-heading d-none" id="hed-1">May 6 – 12, 2025</h2>
            <h2 class="cal-heading" id="hed-2">May 13 – 19, 2025</h2>
             <div class="arrow-calendar" data-target="2">
              <img src="img/right-arrow.svg">
            </div>
        </div>
        <div class="send_message_calendar">
          <div class="send_message_week d-none" id="cal-1">
            <div class="send_message_date selected"><div class="send_message_day">tue</div><div class="send_message_number">19</div></div>
            <div class="send_message_date"><div class="send_message_day">wed</div><div class="send_message_number">20</div></div>
            <div class="send_message_date"><div class="send_message_day">thu</div><div class="send_message_number">21</div></div>
            <div class="send_message_date"><div class="send_message_day">fri</div><div class="send_message_number">22</div></div>
            <div class="send_message_date"><div class="send_message_day">sat</div><div class="send_message_number">16</div></div>
            <div class="send_message_date"><div class="send_message_day">sun</div><div class="send_message_number">17</div></div>
            <div class="send_message_date"><div class="send_message_day">mon</div><div class="send_message_number">18</div></div>
          </div>
          <div class="send_message_week"  id="cal-2">
            <div class="send_message_date"><div class="send_message_day">tue</div><div class="send_message_number">19</div></div>
            <div class="send_message_date selected"><div class="send_message_day">wed</div><div class="send_message_number">20</div></div>
            <div class="send_message_date"><div class="send_message_day">thu</div><div class="send_message_number">21</div></div>
            <div class="send_message_date"><div class="send_message_day">fri</div><div class="send_message_number">22</div></div>
            <div class="send_message_date"><div class="send_message_day">sat</div><div class="send_message_number">16</div></div>
            <div class="send_message_date"><div class="send_message_day">sun</div><div class="send_message_number">17</div></div>
            <div class="send_message_date"><div class="send_message_day">mon</div><div class="send_message_number">18</div></div>
          </div>
        </div>
      </div>
      <div class="timer-section">
        <p class="g-heading">in your time zone Europe/Brussel (GMT +10:00)</p>
        <div class="send_message_section">
          <div class="send_message_section_title" style="display: flex; gap: 12px; align-items: center">
            <img src="img/night.svg"> <span>Night</span>
          </div>
          <div class="send_message_slots">
            <button class="send_message_slot">3:00 AM</button>
            <button class="send_message_slot">3:30 AM</button>
          </div>
        </div>
        <div class="send_message_section">
          <div class="send_message_section_title" style="display: flex; gap: 12px; align-items: center">
            <img src="img/morning.svg"> <span>Night</span>
          </div>
          <div class="send_message_slots">
            <button class="send_message_slot" style="visibility: hidden;">3:00 AM</button>
            <button class="send_message_slot">9:30 AM</button>
          </div>
          <div class="send_message_slots mtt-12">
            <button class="send_message_slot">10:00 AM</button>
            <button class="send_message_slot">10:30 AM</button>
          </div>
          <div class="send_message_slots mtt-12">
            <button class="send_message_slot">11:00 AM</button>
            <button class="send_message_slot" style="visibility: hidden;">3:30 AM</button>
          </div>
          <div class="send_message_slots mtt-12">
            <button class="send_message_slot">12:00 PM</button>
            <button class="send_message_slot" style="visibility: hidden;">3:30 AM</button>
          </div>
        </div>
        <div class="send_message_section">
          <div class="send_message_section_title" style="display: flex; gap: 12px; align-items: center">
            <img src="img/afternoon.svg"> <span>Afternoon</span>
          </div>
          <div class="send_message_slots">
            <button class="send_message_slot">2:00 PM</button>
            <button class="send_message_slot">2:30 PM</button>
          </div>
          <div class="send_message_slots mtt-12">
            <button class="send_message_slot">3:00 PM</button>
            <button class="send_message_slot" style="visibility: hidden;">3:30 AM</button>
          </div>
          <div class="send_message_slots mtt-12">
            <button class="send_message_slot">4:00 PM</button>
            <button class="send_message_slot" style="visibility: hidden;">3:30 AM</button>
          </div>
          <div class="send_message_slots mtt-12">
            <button class="send_message_slot">5:00 PM</button>
            <button class="send_message_slot" style="visibility: hidden;">3:30 AM</button>
          </div>
        </div>
      </div>
      <div style="padding-top: 10px;
      border-top: 1px solid #00000033;
      margin-left: -24px;
      width: calc(100% + 48px);
      padding-inline: 24px;">
       <button id="send_message_book_c" class="send_message_button">Continue</button>
      </div>
    </div>

     <!-- Step 4 -->
    <div class="send_message_step send_message_step4" data-step="4">
      <h2 class="send_message_title text-left" style="margin-block: 24px;">How would you like to pay?</h2>
      <div class="send_message_step_4_to_5 choose-payment-meth">
        <svg width="20" height="16" viewBox="0 0 20 16" fill="none" xmlns="http://www.w3.org/2000/svg">
          <path fill-rule="evenodd" clip-rule="evenodd" d="M2 2H16V4H12C10.9391 4 9.92172 4.42143 9.17157 5.17157C8.42143 5.92172 8 6.93913 8 8C8 9.06087 8.42143 10.0783 9.17157 10.8284C9.92172 11.5786 10.9391 12 12 12H16V14H2V2ZM18 12V16H0V0H18V4H20V12H18ZM10 8C10 7.46957 10.2107 6.96086 10.5858 6.58579C10.9609 6.21071 11.4696 6 12 6C12.5304 6 13.0391 6.21071 13.4142 6.58579C13.7893 6.96086 14 7.46957 14 8C14 8.53043 13.7893 9.03914 13.4142 9.41421C13.0391 9.78929 12.5304 10 12 10C11.4696 10 10.9609 9.78929 10.5858 9.41421C10.2107 9.03914 10 8.53043 10 8Z" fill="black"/>
        </svg>
        <p class="balance_heading mb-2 mt-2">Use your balance</p>
        <p class="balance_sub_heading">Transfer your unused balance to book a trial with Daniela</p>

      </div>
      <div class="send_message_step_4_to_5 choose-payment-meth mt-3">
        <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
          <path fill-rule="evenodd" clip-rule="evenodd" d="M19 12V17H5V12H19ZM19 9V7H5V9H19ZM3 5H21V19H3V5Z" fill="black"/>
        </svg>
        <p class="balance_heading mb-2 mt-1">Charge your payment method</p>
        <p class="balance_sub_heading">Go to checkout and pay for your lesson</p>

      </div>
     </div>

    <!-- Step 5 -->
    <div class="send_message_step send_message_step5" data-step="5">
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
