
<link rel="stylesheet" href="css/my_lesson_details_tutor_details.css">
<link rel="stylesheet" href="css/my_lesson_details_tutor_details_change_your_plan.css">

<!-- Trigger Button (for demo/testing) -->
<!-- <button id="my_lessons_tutors_tab_add_extra_lessons_open_modal" style="margin:36px 18px;">Add Extra Lessons</button> -->
<div id="my_lessons_tutors_tab_add_extra_lessons_modal_backdrop"></div>
<div id="my_lessons_tutors_tab_add_extra_lessons_modal">
  <!-- Step 1: Add Extra Lessons -->
  <div class="my_lessons_tutors_tab_add_extra_lessons_step1" style="display:block;">
    <div class="my_lessons_tutors_tab_add_extra_lessons_header">
      <button class="back-arrow" title="Back" style="visibility:visible;">&#8592;</button>
      <button class="close-icon" title="Close">&times;</button>
    </div>
    <img class="my_lessons_tutors_tab_add_extra_lessons_profile_img" src="https://randomuser.me/api/portraits/women/44.jpg" alt="Tutor Profile"/>
    <div class="my_lessons_tutors_tab_add_extra_lessons_content">
      <div class="my_lessons_tutors_tab_add_extra_lessons_title">Add Extra Lessons With Daniela</div>
      <div class="my_lessons_tutors_tab_add_extra_lessons_desc">
        Buy more lessons without changing your plan. Schedule these lessons before Jan 07.
      </div>

      <div class="my_lessons_tutors_tab_add_extra_lessons_counter_row">
        <button class="my_lessons_tutors_tab_add_extra_lessons_counter_btn" id="my_lessons_tutors_tab_add_extra_lessons_minus">-</button>
        <span class="my_lessons_tutors_tab_add_extra_lessons_counter_number" id="my_lessons_tutors_tab_add_extra_lessons_count">2</span>
        <button class="my_lessons_tutors_tab_add_extra_lessons_counter_btn" id="my_lessons_tutors_tab_add_extra_lessons_plus">+</button>
      </div>
      <div class="my_lessons_tutors_tab_add_extra_lessons_counter_label">extra lessons</div>
      <hr class="my_lessons_tutors_tab_add_extra_lessons_divider"/>
      <div class="my_lessons_tutors_tab_add_extra_lessons_total">Total: $<span id="my_lessons_tutors_tab_add_extra_lessons_total_price">10</span></div>
      <button class="my_lessons_tutors_tab_add_extra_lessons_continue_btn">Continue</button>
    </div>
  </div>
  <!-- Step 2: Upgrade Plan Instead -->
  <div class="my_lessons_tutors_tab_add_extra_lessons_step2" style="display:none;">
    <div class="my_lessons_tutors_tab_add_extra_lessons_header">
      <button class="back-arrow" title="Back">&#8592;</button>
      <button class="close-icon" title="Close">&times;</button>
    </div>
    <div class="my_lessons_tutors_tab_add_extra_lessons_step2_title">Upgrade Your Plan Instead?</div>
    <div class="my_lessons_tutors_tab_add_extra_lessons_step2_desc">
      Get a bigger plan so you don’t have to add extra lessons every cycle.
    </div>
    <div class="my_lessons_tutors_tab_add_extra_lessons_step2_option" tabindex="0" data-step="3">
      <span class="my_lessons_tutors_tab_add_extra_lessons_step2_icon">&#10227;</span>
      <span>
        <strong>Yes Upgrade Now</strong>
        <small>Get more lessons every cycle</small>
      </span>
    </div>
    <div class="my_lessons_tutors_tab_add_extra_lessons_step2_option" tabindex="0" data-step="6">
      <span class="my_lessons_tutors_tab_add_extra_lessons_step2_icon">&#10227;</span>
      <span>
        <strong>Continue adding extra lesson</strong>
        <small>one time change will not affect next cycle</small>
      </span>
    </div>
  </div>
  <!-- Step 3: Plan Upgrade Options -->
  <div class="my_lessons_tutors_tab_add_extra_lessons_step3" style="display:none;">
    <div class="my_lessons_tutors_tab_add_extra_lessons_header">
      <button class="back-arrow" title="Back">&#8592;</button>
      <button class="close-icon" title="Close">&times;</button>
    </div>
    <img class="my_lessons_tutors_tab_add_extra_lessons_step3_profile_img" src="https://randomuser.me/api/portraits/women/44.jpg" alt="Tutor Profile"/>
    <div class="my_lessons_tutors_tab_add_extra_lessons_step3_title">
      Upgrade your plan to <span class="red">improve your English skills faster</span>
    </div>
    <div class="my_lessons_tutors_tab_add_extra_lessons_step3_currentplan">
      <b>Current plan:</b> 8 lessons &bull; $61.44 every 4 weeks
    </div>
    <div class="my_lessons_tutors_tab_add_extra_lessons_step3_optionbox" tabindex="0" data-plan="12">
      <strong>12 lessons</strong>
      <small>$92 every 4 weeks</small>
    </div>
    <div class="my_lessons_tutors_tab_add_extra_lessons_step3_optionbox" tabindex="0" data-plan="16">
      <strong>16 lessons</strong>
      <small>$123 every 4 weeks</small>
    </div>
    <div class="my_lessons_tutors_tab_add_extra_lessons_step3_optionbox" tabindex="0" data-plan="custom">
      <strong>Custom plans</strong>
      <small>Choose the right number of lessons for you</small>
    </div>
    <div class="my_lessons_tutors_tab_add_extra_lessons_step3_footer">
      Prices are for our standard lesson time of 50 min
    </div>
    <button class="my_lessons_tutors_tab_add_extra_lessons_step3_continue_btn" disabled>Continue</button>
  </div>
  <!-- Step 4: Custom Plan -->
  <div class="my_lessons_tutors_tab_add_extra_lessons_step4" style="display:none;">
    <div class="my_lessons_tutors_tab_add_extra_lessons_header">
      <button class="back-arrow" title="Back">&#8592;</button>
      <button class="close-icon" title="Close">&times;</button>
    </div>
    <div class="my_lessons_tutors_tab_add_extra_lessons_step4_title">Create A Plan That Works Best For You</div>
    <div class="my_lessons_tutors_tab_add_extra_lessons_step4_currentplan">
      <b>Current plan:</b> 8 lessons &bull; $61.44 every 4 weeks
    </div>
    <div class="my_lessons_tutors_tab_add_extra_lessons_step4_counter_row">
      <button class="my_lessons_tutors_tab_add_extra_lessons_step4_counter_btn" id="my_lessons_tutors_tab_add_extra_lessons_step4_minus">-</button>
      <span class="my_lessons_tutors_tab_add_extra_lessons_step4_counter_number" id="my_lessons_tutors_tab_add_extra_lessons_step4_count">9</span>
      <button class="my_lessons_tutors_tab_add_extra_lessons_step4_counter_btn" id="my_lessons_tutors_tab_add_extra_lessons_step4_plus">+</button>
    </div>
    <div class="my_lessons_tutors_tab_add_extra_lessons_step4_counter_label">lessons every 4 week</div>
    <hr class="my_lessons_tutors_tab_add_extra_lessons_step4_divider"/>
    <div class="my_lessons_tutors_tab_add_extra_lessons_step4_total">
      $<span id="my_lessons_tutors_tab_add_extra_lessons_step4_total_price">72</span> every 4 weeks
    </div>
    <button class="my_lessons_tutors_tab_add_extra_lessons_step4_continue_btn">Continue</button>
  </div>
  <!-- Step 5: Review Your Changes -->
  <div class="my_lessons_tutors_tab_add_extra_lessons_step5" style="display:none;">
    <div class="my_lessons_tutors_tab_add_extra_lessons_header">
      <button class="back-arrow" title="Back">&#8592;</button>
      <button class="close-icon" title="Close">&times;</button>
    </div>
    <img class="my_lessons_tutors_tab_add_extra_lessons_step5_profile_img" src="https://randomuser.me/api/portraits/women/44.jpg" alt="Tutor Profile"/>
    <div class="my_lessons_tutors_tab_add_extra_lessons_step5_title">Review Your Changes</div>
    <div class="my_lessons_tutors_tab_add_extra_lessons_step5_plan_summary">
      2 lessons per week
    </div>
    <div class="my_lessons_tutors_tab_add_extra_lessons_step5_plan_desc">
      8 lessons &bull; $61 every 4 weeks
    </div>
    <div class="my_lessons_tutors_tab_add_extra_lessons_step5_arrow">&#8595;</div>
    <div class="my_lessons_tutors_tab_add_extra_lessons_step5_plan_summary">
      3 lessons per week
    </div>
    <div class="my_lessons_tutors_tab_add_extra_lessons_step5_plan_desc">
      12 lessons &bull; $92 every 4 weeks
    </div>
    <hr class="my_lessons_tutors_tab_add_extra_lessons_step5_divider"/>
    <div class="my_lessons_tutors_tab_add_extra_lessons_step5_when_label">
      When do you want to upgrade?
    </div>
    <div class="my_lessons_tutors_tab_add_extra_lessons_step5_options_group">
      <div class="my_lessons_tutors_tab_add_extra_lessons_step5_option selected" data-value="now">
        <span class="my_lessons_tutors_tab_add_extra_lessons_step5_option_icon">&#128197;</span>
        <div class="my_lessons_tutors_tab_add_extra_lessons_step5_option_content">
          <div class="my_lessons_tutors_tab_add_extra_lessons_step5_option_title">Now</div>
          <div class="my_lessons_tutors_tab_add_extra_lessons_step5_option_sub" id="now_detail" style="display:block;">
            Start your new plan and make a payment today. Schedule all your remaining lessons from the current plan before Apr 07.
          </div>
        </div>
        <span class="my_lessons_tutors_tab_add_extra_lessons_step5_option_radio">&#9679;</span>
      </div>
      <div class="my_lessons_tutors_tab_add_extra_lessons_step5_option" data-value="next_billing">
        <span class="my_lessons_tutors_tab_add_extra_lessons_step5_option_icon">&#128181;</span>
        <div class="my_lessons_tutors_tab_add_extra_lessons_step5_option_content">
          <div class="my_lessons_tutors_tab_add_extra_lessons_step5_option_title">
            On your next billing date, Mar 18
          </div>
          <div class="my_lessons_tutors_tab_add_extra_lessons_step5_option_sub" id="next_billing_detail">
            Your total is $100 and includes a $11 processing fee.<br>
            We’ll renew your plan automatically using your saved payment method.
          </div>
        </div>
        <span class="my_lessons_tutors_tab_add_extra_lessons_step5_option_radio">&#9675;</span>
      </div>
    </div>
    <button class="my_lessons_tutors_tab_add_extra_lessons_step5_checkout_btn">Continue to checkout</button>
  </div>
  <!-- Step 6: Confirm Payment -->
  <div class="my_lessons_tutors_tab_add_extra_lessons_step6" style="display:none;">
    <div class="my_lessons_tutors_tab_add_extra_lessons_step6_header">
      <button class="back-arrow" title="Back">&#8592;</button>
      <button class="close-icon" title="Close">&times;</button>
    </div>
    <div class="my_lessons_tutors_tab_add_extra_lessons_step6_title">Confirm Payment</div>
    <div class="my_lessons_tutors_tab_add_extra_lessons_step6_item">
      <span class="my_lessons_tutors_tab_add_extra_lessons_step6_item_label">1 extra lesson</span>
      <span class="step6-badge">Expires May 3</span>
      <span style="margin-left: auto; font-weight: 500;">$4.97</span>
    </div>
    <table class="my_lessons_tutors_tab_add_extra_lessons_step6_table">
      <tr>
        <td>Taxes &amp; fees <span class="step6-q-icon" title="Includes service fee and tax.">?</span></td>
        <td>$0.65</td>
      </tr>
      <tr>
        <td class="step6-total-label">Total</td>
        <td class="step6-total">$5.61</td>
      </tr>
    </table>
    <div class="my_lessons_tutors_tab_add_extra_lessons_step6_payment">
      <img src="https://upload.wikimedia.org/wikipedia/commons/4/41/Visa_Logo.png" alt="Visa"/>
      Visa ****7583
      <span class="step6-down-arrow">&#9660;</span>
    </div>
    <button class="my_lessons_tutors_tab_add_extra_lessons_step6_confirm_btn">Confirm $5.61</button>
    <div class="my_lessons_tutors_tab_add_extra_lessons_step6_policy">
      By pressing the "Confirm payment · $5.61" button, you agree to
      <a href="#" target="_blank">latingles’s Refund and Payment Policy</a>
    </div>
  </div>
  <!-- Step 7: Confirmed Change -->
  <div class="my_lessons_tutors_tab_add_extra_lessons_step7" style="display:none;">
    <div class="my_lessons_tutors_tab_add_extra_lessons_step7_top">
      <button class="my_lessons_tutors_tab_add_extra_lessons_step7_close" title="Close">&times;</button>
      <span class="my_lessons_tutors_tab_add_extra_lessons_step7_badge">1</span>
      <div class="my_lessons_tutors_tab_add_extra_lessons_step7_title">
        We Have Confirmed Your Change.
      </div>
    </div>
    <div class="my_lessons_tutors_tab_add_extra_lessons_step7_content">
      <div class="my_lessons_tutors_tab_add_extra_lessons_step7_info">
        starting may 01, your weekly plan will be <span class="my_lessons_tutors_tab_add_extra_lessons_step7_bold">7 lessons every 4 week</span>
      </div>
      <button class="my_lessons_tutors_tab_add_extra_lessons_step7_btn">Okay, thanks!</button>
    </div>
  </div>



    <!-- Step 8: Success / Extra Lessons Added -->
  <div class="my_lessons_tutors_tab_add_extra_lessons_step8">
    <div class="my_lessons_tutors_tab_add_extra_lessons_step8_header">
      <button class="close-icon" title="Close">&times;</button>
    </div>
    <div class="my_lessons_tutors_tab_add_extra_lessons_step8_icon">
      <!-- Success SVG badge (tick inside orange) -->
      <svg width="56" height="56" viewBox="0 0 56 56" fill="none">
        <circle cx="28" cy="28" r="28" fill="#fff0ec"/>
        <path d="M38.48 20.53a2.07 2.07 0 0 0-2.92.06l-8.08 8.23-3.08-3.11a2.07 2.07 0 0 0-2.95 2.9l4.53 4.59a2.07 2.07 0 0 0 2.95 0l9.54-9.71a2.07 2.07 0 0 0-.09-2.96Z" fill="#fff"/>
        <circle cx="28" cy="28" r="18" fill="#fe330a"/>
        <path d="M38.48 20.53a2.07 2.07 0 0 0-2.92.06l-8.08 8.23-3.08-3.11a2.07 2.07 0 0 0-2.95 2.9l4.53 4.59a2.07 2.07 0 0 0 2.95 0l9.54-9.71a2.07 2.07 0 0 0-.09-2.96Z" fill="#fff"/>
      </svg>
    </div>
    <div class="my_lessons_tutors_tab_add_extra_lessons_step8_title">Extra Lessons Added</div>
    <div class="my_lessons_tutors_tab_add_extra_lessons_step8_text">
      Congratulations! You have successfully added new lessons to your account. Enjoy your learning journey!
    </div>
    <a href="my_lesson_tutor_profile_detail_schedule_lesson.php"><button class="confirm_payment_2nd_tab_btn_success" id="confirm_payment_2nd_tab_btn_success">Schedule lessons</button></a>
  </div>



    <!-- Step 9: New Payment Modal for "Now" -->
  <div class="my_lessons_tutors_tab_add_extra_lessons_step9">
    <div class="modal-main-row">
      <!-- LEFT: Tutor & Order -->
      <div class="modal-left">
        <div class="modal-header-payment">
          <span class="modal-payment-title">Payment method</span>
          <button class="close-icon" id="modal_step9_close">&times;</button>
        </div>
        <div class="modal-tutor-row">
          <img class="modal-tutor-img" src="https://randomuser.me/api/portraits/women/44.jpg" alt="Daniela" />
          <div>
            <div class="modal-tutor-name">Daniela <img src="https://upload.wikimedia.org/wikipedia/en/a/ae/Flag_of_the_United_Kingdom.svg" width="20" style="vertical-align:middle;border-radius:4px;margin-left:3px"/></div>
            <div class="modal-tutor-rating">&#9733; 5 <span style="color:#888;">(65 reviews)</span></div>
            <div class="modal-tutor-meta">&#128218; 17 students &nbsp; &#9201; 3128 lessons &nbsp; &#128197; 20 years teaching</div>
          </div>
        </div>
        <div style="font-size:1.11rem;font-weight:700;color:#222;margin-bottom:4px;">
          2 lessons per week
        </div>
        <div style="color:#56596b;margin-bottom:11px;font-size:1.03rem;">
          That’s 8 lessons every 4 weeks<br>Standard lessons last 50 minutes
        </div>
        <div class="modal-order-section">
          <div class="modal-order-title">Your order</div>
          <div class="modal-order-row"><span>8 lessons</span><span>$192.00</span></div>
          <div class="modal-order-row"><span>Processing fee <span title="Includes processing and transaction fee" style="cursor:pointer;">&#9432;</span></span><span>$0.30</span></div>
          <div class="modal-order-total"><span>Total</span><span>$192.00</span></div>
        </div>
        <a href="#" class="modal-promo-link">Have a promo code?</a>
        <div class="modal-hint-box">
          <span style="font-size:1.15rem;">&#10003;</span> 
          You can change your tutor for free or cancel your subscription at any time
        </div>
      </div>
      <!-- RIGHT: Payment Method & Reviews -->
      <div class="modal-right">
        <div class="modal-payment-title2">Payment method</div>
        <div class="modal-payment-method-select">
          <img src="https://upload.wikimedia.org/wikipedia/commons/4/41/Visa_Logo.png" alt="Visa"/>
          Visa ****7583
        </div>
        <button class="modal-payment-btn" id="modal_step9_pay_btn">Confirm payment · $7.50</button>
        <div class="modal-payment-policy">
          By pressing the "Confirm payment · $7.50" button, you agree to
          <a href="#">Latingles Refund and Payment Policy</a>
        </div>
        <div class="modal-review-section">
          <div class="modal-review-title">&#9733; 5 &nbsp; 65 reviews</div>
          <div class="modal-review-list">
            <div class="modal-review-author">Wassim</div>
            <div class="modal-review-item">
              I would love to have the chance to express my high appreciation and gratitude to this respectable and respectful tutor, Mr Jonathan. There is much to say but in brief, he is very professional,
              <span style="color:#2323ff;cursor:pointer;">Read more</span>
            </div>
            <div class="modal-review-nav">
              <button class="modal-review-nav-btn">&#8592;</button>
              <button class="modal-review-nav-btn">&#8594;</button>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <!-- END Step 9 -->

</div>

<?php require_once('my_lesson_details_tutor_details_change_your_plan.php');?>

<script src="js/my_lessons_details_tutor_details.js"></script>
<script src="js/my_lessons_details_tutor_details_change_your_plan.js"></script>
