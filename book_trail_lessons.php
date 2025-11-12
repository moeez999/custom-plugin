<!-- Modal Overlay -->
<div id="trialModalOverlay" class="modal-overlay">
  <div class="modal-window">
    <!-- STEP 1 -->
    <div id="step1" class="modal-content book_trial_step1">
      <div class="step-header">
        <span id="step1Close" class="step-close">&times;</span>
        <h2 class="step-title">Choose Your Trial Lesson Duration</h2>
      </div>
      <div class="step-body">
        <div class="duration-option" data-duration="25">
          <span class="opt-icon">&#127891;</span>
          <div class="opt-text">
            <h3>25 minute trial lesson</h3>
            <p>Get to know the tutor, discuss your goals and learning plan.</p>
          </div>
          <span class="opt-arrow">&rsaquo;</span>
        </div>
        <div class="duration-option" data-duration="50">
          <span class="opt-icon">&#9889;</span>
          <div class="opt-text">
            <h3>50 minute trial lesson</h3>
            <p>Get everything that’s in a 25-min lesson plus start learning.</p>
          </div>
          <span class="opt-arrow">&rsaquo;</span>
        </div>
      </div>
    </div>

    <!-- STEP 2 -->
    <div id="step2" class="modal-content book_trial_step2" style="display:none;">
      <div class="step-header">
        <span id="step2Back" class="step-back">&larr;</span>
        <h2 class="step-title">Book a trial lesson</h2>
        <span id="step2Close" class="step-close">&times;</span>
      </div>
      <div class="step-body">
        <div class="duration-tabs">
          <button class="duration-tab" data-duration="25">25 min</button>
          <button class="duration-tab" data-duration="50">50 min</button>
        </div>
        <hr>
        <div class="calendar-nav">
          <button id="prevWeek" class="nav-arrow">&larr;</button>
          <div class="week-label">September 16–22, 2024</div>
          <button id="nextWeek" class="nav-arrow">&rarr;</button>
        </div>
        <div class="calendar-days">
          <div class="day"><span class="day-name">sat</span><span class="day-num">16</span></div>
          <div class="day"><span class="day-name">sun</span><span class="day-num">17</span></div>
          <div class="day selected"><span class="day-name">mon</span><span class="day-num">18</span></div>
          <div class="day"><span class="day-name">tue</span><span class="day-num">19</span></div>
          <div class="day today"><span class="day-name">wed</span><span class="day-num">20</span></div>
          <div class="day"><span class="day-name">thu</span><span class="day-num">21</span></div>
          <div class="day"><span class="day-name">fri</span><span class="day-num">22</span></div>
        </div>
        <div class="time-section">
          <span class="time-icon">&#9790;</span><span class="time-label">Night</span>
        </div>
        <div class="time-slots">
          <button class="time-slot">3:00 AM</button>
          <button class="time-slot">3:30 AM</button>
        </div>
        <div class="time-section">
          <span class="time-icon">&#9728;</span><span class="time-label">Morning</span>
        </div>
        <div class="time-slots">
          <button class="time-slot">9:30 AM</button>
          <button class="time-slot">10:00 AM</button>
          <button class="time-slot">10:30 AM</button>
          <button class="time-slot">11:00 AM</button>
        </div>
        <button id="continueToStep3" class="btn-continue">
          Continue
        </button>
      </div>
    </div>

    <!-- STEP 3 -->
    <div id="step3" class="modal-content book_trial_step3" style="display:none;">
      <div class="step-header">
        <span id="step3Back" class="step-back">&larr;</span>
        <h2 class="step3-title">Confirm your subscription</h2>
        <span id="step3Close" class="step-close">&times;</span>
      </div>
      <div class="step-body">
        <div class="order-container">

          <!-- Teacher Card -->
          <div class="teacher-card">
            <div class="teacher-subject">English</div>
            <div class="teacher-profile">
              <img src="https://randomuser.me/api/portraits/women/4.jpg"
                   alt="Daniela" class="teacher-avatar">
              <div class="teacher-info">
                <p class="teacher-name">Daniela</p>
                <p class="teacher-rating">★ 5 (20 reviews)</p>
                <div class="teacher-tags">
                  <span class="tag verified">Verified</span>
                  <span class="tag professional">Professional</span>
                </div>
              </div>
            </div>
            <hr>
            <ul class="lessons-info">
              <li>5 lessons per week</li>
              <li>That’s 20 lessons every 4 weeks</li>
              <li>Standard lessons last 50 minutes</li>
            </ul>
            <hr>
            <div class="your-order">
              <h3>Your order</h3>
              <div class="order-line">
                <span>20 lessons (US$5.40/lesson)</span>
                <span>US$108.00</span>
              </div>
              <div class="order-line">
                <span>Processing fee <span class="tooltip">?</span></span>
                <span>US$5.40</span>
              </div>
              <hr>
              <div class="order-total">
                <span>Total</span>
                <span>US$113.40 <small>every 4 weeks</small></span>
              </div>
              <a href="#" class="promo-link">Have a promo code?</a>


            <div class="promo-cta">
              <p>You can switch tutors at no cost or cancel your subscription anytime.</p>
            </div>
            <div class="promo-disclaimer">
              <p><strong>US$113.40</strong> will be charged to your saved payment method every <strong>4 weeks</strong> for <strong>20 lessons</strong>, unless you cancel.</p>
            </div>


            </div>
          </div>

          <!-- Payment & Reviews -->
          <div class="payment-section">
            <label for="paymentSelect">Payment Method</label>
            <select id="paymentSelect" class="payment-select">
              <option>Visa **** **** **** 1267</option>
            </select>
            <button id="confirmSubscription" class="btn-confirm">
              Confirm monthly subscription
            </button>

            <div class="review-carousel">
              <button id="prevReview" class="rev-arrow">&larr;</button>
              <button id="nextReview" class="rev-arrow">&rarr;</button>
            </div>
            <div class="review-card">
              <img src="https://randomuser.me/api/portraits/men/32.jpg"
                   alt="John" class="review-avatar">
              <div class="review-content">
                <p class="review-author">John</p>
                <p>Daniela is the nicest, and most engaging teacher I’ve ever met. He has very good patience, and I would recommend booking a class with him.</p>
              </div>
            </div>


          </div>

        </div>
      </div>
    </div>

  </div>
</div>