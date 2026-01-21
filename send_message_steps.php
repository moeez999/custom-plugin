<!-- Modal -->
<div id="send_message_modal" class="send_message_overlay" style="display: none">
  <div class="send_message_container">
    <span id="send_message_close" class="send_message_close">&times;</span>

    <!-- Step 1 -->
    <div class="send_message_step send_message_step1" style="display: none" data-step="1">
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
    <div class="send_message_step send_message_step2" style="display: none" data-step="2">
      <img src="https://randomuser.me/api/portraits/women/4.jpg" alt="Tutor Avatar" class="send_message_avatar"/>
      <h2 class="send_message_title mb-3">Message sent</h2>
      <p class="send_message_subtitle" style="margin-bottom:25px !important;">Excited to start your learning journey? <br>
          Book lesson now, secure the best lesson time.
      </p>
      <button id="send_message_book" class="send_message_btn send_message_primary"><span class="send_message_icon"><img src="img/iconify.svg"></span>Book trial lesson</button>
      <button id="send_message_more" class="send_message_btn send_message_secondary">Show More Tutors</button>
    </div>

    <!-- Step 3 -->
    <div class="send_message_step send_message_step3" style="display: none" data-step="3">
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
    <div class="send_message_step send_message_step4" style="display: none" data-step="4">
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
    <div class="send_message_step send_message_step5" style="display: none" data-step="5">
      <div class="send_message_checkout">
        <div class="checkout_left">
          <div class="profile-details-container">
            <img src="https://dev.latingles.com/img/subs/1.png" alt="" height="64px" width="64px" style="margin-bottom: 8px;">
            <div class="container-details-profile">
                    <div class="top-header">
                        <div class="teacher-text"> Daniela </div>
                        <svg width="24" height="19" viewBox="0 0 24 19" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <g clip-path="url(#clip0_20545_58769)">
                            <g clip-path="url(#clip1_20545_58769)">
                            <mask id="mask0_20545_58769" style="mask-type:luminance" maskUnits="userSpaceOnUse" x="-1" y="0" width="26" height="19">
                            <path d="M-0.0078125 0.25H24.0563V18.298H-0.0078125V0.25Z" fill="white"></path>
                            </mask>
                            <g mask="url(#mask0_20545_58769)">
                            <path d="M-6.02344 0.25H30.0733V18.2984H-6.02344V0.25Z" fill="#000066"></path>
                            <path d="M-6.02344 0.25V2.26785L26.0377 18.2984H30.0733V16.2806L-1.98784 0.25H-6.02344ZM30.0733 0.25V2.26782L-1.98784 18.2984H-6.02344V16.2805L26.0377 0.25H30.0733Z" fill="white"></path>
                            <path d="M9.01686 0.25V18.2984H15.033V0.25H9.01686ZM-6.02344 6.26612V12.2822H30.0733V6.26612H-6.02344Z" fill="white"></path>
                            <path d="M-6.02344 7.46934V11.079H30.0733V7.46934H-6.02344ZM10.2201 0.25V18.2984H13.8297V0.25H10.2201ZM-6.02344 18.2984L6.0088 12.2822H8.69922L-3.33302 18.2984H-6.02344ZM-6.02344 0.25L6.0088 6.26612H3.31838L-6.02344 1.59528V0.25ZM15.3506 6.26612L27.3828 0.25H30.0733L18.041 6.26612H15.3506ZM30.0733 18.2984L18.041 12.2822H20.7315L30.0733 16.9531V18.2984Z" fill="#CC0000"></path>
                            </g>
                            </g>
                            </g>
                            <rect x="0.5" y="0.5" width="23" height="17.5" rx="1.5" stroke="#121117" stroke-opacity="0.56"></rect>
                            <defs>
                            <clipPath id="clip0_20545_58769">
                            <rect width="24" height="18.5" rx="2" fill="white"></rect>
                            </clipPath>
                            <clipPath id="clip1_20545_58769">
                            <rect width="24" height="18" fill="white" transform="translate(0 0.25)"></rect>
                            </clipPath>
                            </defs>
                        </svg>
                        <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path fill-rule="evenodd" clip-rule="evenodd" d="M12 3H4V18L12 22L20 18V3H12ZM10.5 15.414L17.207 8.707L15.793 7.293L10.5 12.586L8.207 10.293L6.793 11.707L10.5 15.414Z" fill="#121117"></path>
                        </svg>

                    </div>
                    <div class="bottom-section">
                        <svg width="16" height="16" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M7.99964 2L9.4803 5.96133L13.7056 6.146L10.3956 8.77933L11.5263 12.854L7.99964 10.52L4.47297 12.854L5.60297 8.77867L2.29297 6.14533L6.5183 5.96133L7.99964 2Z" fill="#121117"></path>
                        </svg>
                        <span class="rating">5</span>
                        <span style="margin-left: 8px; color: #4D4C5C;">(65 reviews)</span>
                    </div>
            </div>
          </div>
          <!--  -->
          <div class="duty-info" style="margin-top: 20px;">
            <div class="info-teacher">
                <div class="info-first d-flex gap-1">
                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M12 21L5 17.2V11.2L1 9L12 3L23 9V17H21V10.1L19 11.2V17.2L12 21ZM12 12.7L18.85 9L12 5.3L5.15 9L12 12.7ZM12 18.725L17 16.025V12.25L12 15L7 12.25V16.025L12 18.725Z" fill="#121117"></path>
                    </svg>
                    <span style="margin-left: 4px;">17</span>
                </div>
                <span style="margin-top: 4px;" class="label-tex">Students</span>
            </div>
            <div class="info-teacher">
                <div class="info-first d-flex gap-1">
                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path fill-rule="evenodd" clip-rule="evenodd" d="M11.41 12.823L6.802 8.218L4.681 8.924L1.5 5.742L4.682 4.682L5.742 1.5L8.925 4.682L8.166 6.855L12.772 11.46L11.41 12.823ZM9.41 2.338L11.12 4.048C12.7689 3.86585 14.4336 4.20078 15.8837 5.00643C17.3338 5.81208 18.4976 7.0486 19.214 8.54483C19.9304 10.0411 20.1639 11.723 19.8823 13.3578C19.6007 14.9926 18.8178 16.4994 17.642 17.6697C16.4663 18.84 14.9558 19.6158 13.3197 19.8898C11.6836 20.1637 10.0028 19.9223 8.50991 19.1989C7.01705 18.4756 5.78599 17.306 4.98713 15.8521C4.18827 14.3982 3.86113 12.732 4.051 11.084L2.347 9.38C2.11607 10.2342 1.99938 11.1152 2 12C2 17.523 6.477 22 12 22C17.523 22 22 17.523 22 12C22 6.477 17.523 2 12 2C11.105 2 10.237 2.118 9.411 2.338H9.41ZM6.206 10.431L8.006 12.231C8.05069 13.0049 8.31927 13.7491 8.77907 14.3731C9.23887 14.9971 9.87008 15.4742 10.596 15.7461C11.3218 16.0181 12.1111 16.0733 12.8677 15.905C13.6244 15.7367 14.3159 15.3522 14.858 14.7982C15.4002 14.2442 15.7698 13.5447 15.9217 12.7846C16.0737 12.0245 16.0015 11.2366 15.714 10.5167C15.4265 9.79688 14.936 9.17607 14.3022 8.7298C13.6684 8.28353 12.9186 8.03103 12.144 8.003L10.366 6.225C11.641 5.86472 12.9995 5.93661 14.2294 6.42946C15.4592 6.92231 16.4914 7.8084 17.1648 8.94947C17.8382 10.0905 18.115 11.4224 17.9519 12.7373C17.7888 14.0522 17.1951 15.2761 16.2634 16.2182C15.3317 17.1602 14.1144 17.7673 12.8013 17.9448C11.4883 18.1223 10.1535 17.8602 9.00507 17.1994C7.85666 16.5386 6.95928 15.5163 6.45293 14.2919C5.94659 13.0675 5.85976 11.7099 6.206 10.431Z" fill="#121117"></path>
                    </svg>
                    <span style="margin-left: 4px;">3128</span>
                </div>
                <span style="margin-top: 4px;" class="label-tex">lessons completed</span>
            </div>
            <div class="info-teacher">
                <div class="info-first d-flex gap-1">
                  <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path fill-rule="evenodd" clip-rule="evenodd" d="M10 3H7V5H3V20H21V5H17V3H14V5H10V3ZM14 8V7H10V8H7V7H5V18H19V7H17V8H14ZM9 10H7V12H9V10ZM7 14H9V16H7V14ZM13 14H11V16H13V14ZM11 10H13V12H11V10ZM17 10H15V12H17V10Z" fill="#121117"></path>
                    </svg>
                    <span style="margin-left: 4px;">20</span>
                </div>
                <span style="margin-top: 4px;" class="label-tex">years teaching</span>
            </div>
          </div>
          <div style="margin-top: 20px; border: 1px solid #1211170F; border-radius: 8px; background: #F4F4F8; padding: 16px 20px; position: relative">
            <div class="d-flex items-center justify-space">
              <div class="text-left">
                <p style="color: ##121117; font-size: 16px; font-family: 'Figtree', sans-serif;  font-weight: 600">Perfect for business topics</p>
                <p style="color: #4D4C5C; font-size: 16px; font-family: 'Figtree', sans-serif; ">Experienced with learners like you</p>
              </div>
              <img src="img/progress.svg" style="position: absolute; right: 0; bottom:0">
            </div>   
      
          </div>
          <div class="w-100" style="margin-block: 20px; padding-block: 16px; border-block:1px solid #DCDCE5;">
              <p style="text-align: left;font-weight: 500 !important; font-size: 16px !important;">   Your trial lesson</p>
              <div class="d-flex items-center mt-3 mb-3">
                <div class="text-center" style="width: 48px; padding-right: 12px; border-right: 1px solid #DCDCE5;">
                    <p style="color: #6A697C; font-size: 14px; font-family: 'Figtree', sans-serif;  font-weight: 600">May</p>
                    <p style="color: #121117; font-size: 16px; font-family: 'Figtree', sans-serif;  font-weight: 600">9</p>
                </div>  
                <div style="margin-left: 12px;">
                   <p class="text-left" style="color: #121117; font-size: 16px; font-family: 'Figtree', sans-serif;  font-weight: 600">Friday, 11:30 – 11:55</p>
                    <p style="color: #4D4C5C; font-size: 14px; font-family: 'Figtree', sans-serif;  font-weight: 600">Time zone: Europe/Madrid (GMT +2:00)</p>
                </div>
              </div>
          </div>
          <div class="total-text d-flex justify-content-between w-100" style="margin-top: 16px; margin-bottom: 12px">
              <p>Your order</p>
          </div>
          <div class="lesson-bill-box w-100">
              <div class="d-flex justify-content-between">
                  <p style="color: #121117; font-size: 16px; font-family: 'Figtree', sans-serif;  font-weight: 400">25-min lesson</p>
                  <p style="color: #121117; font-size: 16px; font-family: 'Figtree', sans-serif;  font-weight: 600"> $12.00</p>
              </div>
              <div class="d-flex justify-content-between">
                  <div class="d-flex gap-2">
                    <span style="color: #121117; font-size: 16px; font-family: 'Figtree', sans-serif;  font-weight: 400">Processing fee</span>
                    <img src="img/questionn.svg">
                  </div>
                  <p style="color: #121117; font-size: 16px; font-family: 'Figtree', sans-serif;  font-weight: 600">$0.30 </p>
              </div>
               <div class="d-flex justify-content-between">
                  <div class="d-flex gap-2">
                    <span style="color: #121117; font-size: 16px; font-family: 'Figtree', sans-serif;  font-weight: 400;">Your Latingles credit</span>
                    <img src="img/questionn.svg">
                  </div>
                  <p style="color: #121117; font-size: 16px; font-family: 'Figtree', sans-serif;  font-weight: 600;color: #067560;"> -$4.80</p>
              </div>
          </div>
          <div class="total-text d-flex justify-content-between w-100" style="margin-top: 16px; margin-bottom: 20px">
              <p>Total</p>
              <p>$0.00</p>
          </div>
           <p class="text-left" style="margin-bottom: 20px;color: #121117; font-size: 16px; font-weight: 500; text-decoration: underline;">Have a promo code?</p>
          <div class="light-blue-container w-100 d-flex" style=" gap: 12px; height: auto !important; background: #D8F8F2 !important; border-radius: 2px;">
              <div style="height: 24px; width: 24px; min-height: 24px; min-width: 24px;">
                  <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                      <path fill-rule="evenodd" clip-rule="evenodd" d="M15.291 4.055L12 2L8.709 4.055L4.929 4.929L4.055 8.709L2 12L4.055 15.291L4.929 19.071L8.709 19.945L12 22L15.291 19.945L19.071 19.071L19.945 15.291L22 12L19.945 8.709L19.071 4.929L15.291 4.055ZM9.793 15.707L10.5 16.414L11.207 15.707L17.207 9.707L15.793 8.293L10.5 13.586L8.207 11.293L6.793 12.707L9.793 15.707Z" fill="#121117"></path>
                  </svg>
              </div>
              <div>
                <p class="text-left" style="font-size: 16px; font-family: 'Figtree', sans-serif; font-weight: 600;">Free replacement or refund</p>
                <p class="text-left" style="font-size: 16px; font-family: 'Figtree', sans-serif;">You can change your tutor for free or cancel your subscription at any time</p>
              </div>
          </div>
          <!--  -->
          <!--  -->
        </div>
        <div class="checkout_right">
          <h3 class="super_heading" style="margin-bottom: 48px;">Payment Method</h3>
          <div class="payment-selector mb-3" id="yui_3_18_1_1_1769011004028_47">
            <div class="card-info">
                <img class="card-icon" src="img/visa.png" alt="Visa card icon">
                <span class="card-details">Visa ****7583</span>
            </div>
            <img class="dropdown-icon" src="img/down-arrow.svg" alt="Dropdown arrow">
          </div>
          <button id="send_message_confirm" class="confirm_button" style="margin-bottom: 18px;">Confirm monthly subscription</button>
          <p class="text-left" style="margin-bottom: 24px;font-size: 14px; color: #4D4C5C; font-family: 'Figtree', sans-serif;">By pressing the "Confirm payment · $7.50" button, you agree to <span style="color: #121117;text-decoration: underline;">Latingles Refund and Payment Policy</span></p>
          <div class="checkout-review-box pd-4">
            <!-- arrow -->
            <div class="d-flex justify-between items-center mt-4">
              <!-- first -->
               <div class="d-flex gap-2 items-center">
              <div class="d-flex items-center" style="border: 1px solid #DCDCE5; border-radius: 8px; width: 80px; height: 42px; padding-inline: 17px; gap: 12px">
                <svg class="find_groups_details_available_star" viewBox="0 0 24 24" fill="currentColor">
                  <path d="M12 17.27 18.18 21l-1.64-7.03L22 9.24l-7.19-.62L12 2 9.19 8.62 2 9.24l5.46 4.73L5.82 21 12 17.27Z"></path>
                </svg>
                 <p style="font-size: 16px; font-family: 'Figtree', sans-serif; font-weight: 600;">5</p>
              </div>
                <p style="font-size: 16px; font-family: 'Figtree', sans-serif; font-weight: 400;">65 reviews</p>
            
              </div>
              <!-- first -->
              <div class="d-flex items-center" style="border-radius: 8px; border:2px solid #DCDCE5; height: 44px; width: 118px;">
                <div class="arrowz" style="border-right: 2px solid #DCDCE5;"><img src="img/left-arroww.svg"></div>
                <div class="arrowz">
                <img src="img/right-arro.svg"></div>
              </div>
            </div>
            <div class="checkout-review-window mt-3">
              <div class="d-flex items-center gap-3">
                <img src="img/pcz.svg">
                <span  style="font-size: 16px; font-family: 'Figtree', sans-serif; font-weight: 600;">Wassim</span>
              </div>
              <p class="mt-3 text-left" style="font-size: 16px; font-family: 'Figtree', sans-serif; font-weight: 400;">I would love to have the chance to express my high appreciation
                and gratitude to this respectable and respectful tutor, Mr
                Jonathan. There is much to say but in brief, he is very professional,
                <span class="d-none" id="review-x-1">extra-ordinary capable and super</span>
              </p>
              <p class="reveal-review text-left mt-3 pointer" data-target="review-x-1" style="font-size: 16px; font-family: 'Figtree', sans-serif; font-weight: 600; text-decoration: underline" class="mt-3 text-left">Read more</p>
            </div>
            <!-- arrow -->
          </div>
    
        </div>
      </div>
    </div>

  </div>
</div>
