<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8"/>
<meta name="viewport" content="width=device-width, initial-scale=1"/>
<title>Message Tutor Panel</title>

<script src="https://cdn.tailwindcss.com"></script>
<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>

<style>
  /* --- Visuals --- */
  .my_lessons_details_my_lessons_content_message_tutor_shadow{ box-shadow:0 24px 60px rgba(0,0,0,.22); }
  .my_lessons_details_my_lessons_content_message_tutor_scroll{ -ms-overflow-style:none; scrollbar-width:none; }
  .my_lessons_details_my_lessons_content_message_tutor_scroll::-webkit-scrollbar{ width:0; height:0; }
  .my_lessons_details_my_lessons_content_message_tutor_bubble{ transition:background-color .15s ease, box-shadow .15s ease; }
  /* .my_lessons_details_my_lessons_content_message_tutor_bubble:hover{ background:#ececf3; box-shadow:0 4px 16px rgba(0,0,0,.08); } */
  .my_lessons_details_my_lessons_content_message_tutor_input:focus{ outline:none; }

  /* --- CRITICAL FIX: kill any global counters/pseudo content inside this panel --- */
  .my_lessons_details_my_lessons_content_message_tutor_panel {
    border-radius: 8px;
    color: #121117;
    font-family: "Poppins", sans-serif;
  }
  .my_lessons_details_my_lessons_content_message_tutor_panel,
  .my_lessons_details_my_lessons_content_message_tutor_panel *{
    list-style: none !important;
    counter-reset: none !important;
    counter-increment: none !important;
  }
  .my_lessons_details_my_lessons_content_message_tutor_panel::before,
  .my_lessons_details_my_lessons_content_message_tutor_panel::after,
  .my_lessons_details_my_lessons_content_message_tutor_panel *::before,
  .my_lessons_details_my_lessons_content_message_tutor_panel *::after{
    content: none !important;   /* nukes injected “100” from ::before/::after anywhere in panel */
  }
  .message-header {
    padding-inline: 24px;
    box-shadow: 0px -3px 22.1px 0px #12111726;
  }
  .my_lessons_details_my_lessons_content_message_tutor_feed  {
    padding-inline: 24px;
    padding-top: 12px;
    margin-bottom: 40px;
  }
</style>
</head>

<body class="bg-gray-50 min-h-screen flex items-center justify-center p-6">

<!-- Example trigger -->
<!-- <button type="button"
        class="my_lessons_details_my_lessons_content_message_tutor_btn px-4 py-2 bg-black text-white rounded-lg">
  Message Tutor
</button> -->

<!-- Panel -->
<div id="message_tutor_panel_screen_1" class="hidden my_lessons_details_my_lessons_content_message_tutor_panel fixed bottom-6 right-6 z-[2147483647]
            w-[494px] max-w-[95vw] max-h-[79vh] h-[671px] bg-white border border-gray-200 
            my_lessons_details_my_lessons_content_message_tutor_shadow
            flex flex-col overflow-hidden justify-between">

    <!-- Header -->
    <div class="message-header">
      <div class="flex items-center justify-between h-[40px]" style="height: 64px;
      width: calc(100% + 48px);
      margin-left: -24px;
      padding-inline: 24px;
      border-bottom: 1px solid #DCDCE5;">
        <div class="flex items-center gap-2">
          <button type="button" id="message_tutor_panel_screen_back_1"
                  class="my_lessons_details_my_lessons_content_message_tutor_back w-9 h-9 rounded-full hover:bg-gray-100 flex items-center justify-center"
                  aria-label="Back">
            <svg class="min-w-[40px]" width="40" height="40" viewBox="0 0 40 40" fill="none" xmlns="http://www.w3.org/2000/svg">
              <path fill-rule="evenodd" clip-rule="evenodd" d="M15.9141 20.9932L27.9141 20.9932L27.9141 18.9932L15.9141 18.9932L21.2071 13.7002L19.7931 12.2862L12.0861 19.9932L19.7931 27.7002L21.2071 26.2862L15.9141 20.9932Z" fill="#121117"/>
            </svg>

          </button>
          <img src="https://i.pravatar.cc/80?img=5" alt="Daniela" class="w-[40px] h-[40px] rounded-full object-cover"/>
          <a href="#" class="text-[18px] ml-1 font-[500] underline hover:text-[#121117]">Daniela</a>
        </div>

        <div class="flex items-center" style="gap: 12px;">
          <button type="button" id="attachment-btn"
                  class="w-9 h-9 rounded-full hover:bg-gray-100 flex items-center justify-center"
                  aria-label="Docs">
          <svg class="min-w-[40px]" width="40" height="40" viewBox="0 0 40 40" fill="none" xmlns="http://www.w3.org/2000/svg">
            <path d="M17 12H11V28H29V15H19L17 12ZM27 17V26H13V17H27Z" fill="#121117"/>
          </svg>

          </button>
          <button type="button"
                  class="my_lessons_details_my_lessons_content_message_tutor_close w-9 h-9 rounded-full hover:bg-gray-100 flex items-center justify-center"
                  aria-label="Close">
            <svg class="min-w-[40px]" width="40" height="40" viewBox="0 0 40 40" fill="none" xmlns="http://www.w3.org/2000/svg">
              <path fill-rule="evenodd" clip-rule="evenodd" d="M15.414 14L14 15.414L18.95 20.364L14 25.314L15.414 26.728L20.364 21.778L25.314 26.728L26.728 25.314L21.778 20.364L26.728 15.414L25.314 14L20.364 18.95L15.414 14Z" fill="#121117"/>
            </svg>

          </button>
        </div>
      </div>

      <!-- Centered “Schedule Lessons” -->
      <div class="pointer h-[56px] flex justify-center hover:bg-[#F4F4F8]" style="margin-left: -24px;
      width: calc(100% + 48px);
      padding-inline: 24px;
      border-radius: 20px; margin-bottom: 2px;">
        <a href="my_lessons_details_calendar_content_reschedule.php"
          class="gap-[12px] inline-flex items-center  text-[14px] font-semibold hover:text-black">
          <svg width="22" height="21" viewBox="0 0 22 21" fill="none" xmlns="http://www.w3.org/2000/svg">
              <path d="M19.5383 0H17.4888V2.04947C17.4888 2.45937 17.1473 2.73263 16.8057 2.73263C16.4641 2.73263 16.1225 2.45937 16.1225 2.04947V0H5.192V2.04947C5.192 2.45937 4.85042 2.73263 4.50884 2.73263C4.16726 2.73263 3.82568 2.45937 3.82568 2.04947V0H1.77621C0.751473 0 0 0.888105 0 2.04947V4.50884H21.861V2.04947C21.861 0.888105 20.6314 0 19.5383 0ZM0 5.94347V18.4453C0 19.6749 0.751473 20.4947 1.84453 20.4947H19.6066C20.6997 20.4947 21.9294 19.6066 21.9294 18.4453V5.94347H0ZM6.0801 17.4205H4.44052C4.16726 17.4205 3.894 17.2156 3.894 16.874V15.1661C3.894 14.8928 4.09895 14.6196 4.44052 14.6196H6.14842C6.42168 14.6196 6.69494 14.8245 6.69494 15.1661V16.874C6.62663 17.2156 6.42168 17.4205 6.0801 17.4205ZM6.0801 11.2721H4.44052C4.16726 11.2721 3.894 11.0672 3.894 10.7256V9.01768C3.894 8.74442 4.09895 8.47115 4.44052 8.47115H6.14842C6.42168 8.47115 6.69494 8.6761 6.69494 9.01768V10.7256C6.62663 11.0672 6.42168 11.2721 6.0801 11.2721ZM11.5454 17.4205H9.83747C9.56421 17.4205 9.29094 17.2156 9.29094 16.874V15.1661C9.29094 14.8928 9.49589 14.6196 9.83747 14.6196H11.5454C11.8186 14.6196 12.0919 14.8245 12.0919 15.1661V16.874C12.0919 17.2156 11.8869 17.4205 11.5454 17.4205ZM11.5454 11.2721H9.83747C9.56421 11.2721 9.29094 11.0672 9.29094 10.7256V9.01768C9.29094 8.74442 9.49589 8.47115 9.83747 8.47115H11.5454C11.8186 8.47115 12.0919 8.6761 12.0919 9.01768V10.7256C12.0919 11.0672 11.8869 11.2721 11.5454 11.2721ZM17.0106 17.4205H15.3027C15.0295 17.4205 14.7562 17.2156 14.7562 16.874V15.1661C14.7562 14.8928 14.9611 14.6196 15.3027 14.6196H17.0106C17.2839 14.6196 17.5571 14.8245 17.5571 15.1661V16.874C17.5571 17.2156 17.3522 17.4205 17.0106 17.4205ZM17.0106 11.2721H15.3027C15.0295 11.2721 14.7562 11.0672 14.7562 10.7256V9.01768C14.7562 8.74442 14.9611 8.47115 15.3027 8.47115H17.0106C17.2839 8.47115 17.5571 8.6761 17.5571 9.01768V10.7256C17.5571 11.0672 17.3522 11.2721 17.0106 11.2721Z" fill="black"/>
          </svg>
          <span class="underline">Schedule Lessons</span>
        </a>
      </div>
    </div>

    <!-- Today pill -->
    <div class="pt-[17px] pb-[20px] d-flex items-center justify-center">
      <div class="h-[26px] my_lessons_details_my_lessons_content_message_tutor_today
                bg-[#F4F4F8] text-[#6A697C] text-[12px] rounded-[4px] flex items-center w-[92px] justify-center">
        Today
      </div>
    </div>

    <!-- Feed -->
    <div class="my_lessons_details_my_lessons_content_message_tutor_feed
                my_lessons_details_my_lessons_content_message_tutor_scroll flex-1 overflow-y-auto space-y-7 max-h-[324px]">

      <!-- Daniela -->
      <div class="flex items-start gap-[12px]">
        <img src="https://i.pravatar.cc/80?img=5" alt="Daniela" class="w-8 h-8 rounded-full"/>
        <div>
          <div class="flex items-center text-[16px] font-[400]">
            Daniela <span style="margin-top:-3px" class="text-[12px] text-[#6A697C] align-middle ml-1">09:34</span>
          </div>
          <div class="mt-[11px] leading-relaxed text-[#4D4C5C] text-[16px] font-[300]" data-ml_msgtext>
            Good morning, I want to confirm our meeting today and ask if the meeting will take place within
            the Latingles virtual classroom or will you provide the information?
          </div>
        </div>
      </div>

      <!-- Latingles bubble -->
      <div class="flex items-start gap-[12px]">
        <img src="img/logoo.svg" class="w-8 h-8" alt="Latingles"/>
        <div class="flex-1">
          <div class="relative flex items-center justify-space text-[16px] font-[400]">
            <div>Latingles <span style="margin-top:-3px" class="text-[12px] text-[#6A697C] align-middle">11:06</span></div>
            <div>
              <button type="button" class="d-none absolute right-2 top-0 w-8 h-8 rounded-full flex items-center justify-center"
                    aria-label="More" style="transform: translateY(-10%);">
                  <svg class="w-5 h-5" viewBox="0 0 24 24" fill="currentColor">
                    <circle cx="5" cy="12" r="1.5"></circle>
                    <circle cx="12" cy="12" r="1.5"></circle>
                    <circle cx="19" cy="12" r="1.5"></circle>
                  </svg>
              </button>
            </div>
          </div>

          <div class="relative  rounded-xl  mt-[11px] text-[#4D4C5C] text-[16px] font-[300]
                      my_lessons_details_my_lessons_content_message_tutor_bubble"
              data-ml_msgtext>
            I’m already in, is anyone joining
          </div>
        </div>
      </div>

      <!-- Latingles -->
      <div class="flex items-start gap-[12px]">
        <img src="img/logoo.svg" class="w-8 h-8" alt="Latingles"/>
        <div>
          <div class="flex items-center text-[16px] font-[400]">
            Latingles <span  style="margin-top:-3px" class="text-[12px] text-[#6A697C] align-middle ml-1">11:06</span>
          </div>
          <div class="mt-[11px] leading-relaxed text-[#4D4C5C] text-[16px] font-[300]" data-ml_msgtext>
            Yes Please wait for me ! Thank you
          </div>
        </div>
      </div>
    </div>

    <!-- Composer -->
    <div class="px-[24px] pb-[24px]">
      <div class="relative min-h-[100px] rounded-[8px] px-[20px] pt-[13px]" style="border: 2px solid #DCDCE5">
        <textarea
          class="my_lessons_details_my_lessons_content_message_tutor_input w-full resize-none text-[15px] placeholder:text-gray-400 px-1 leading-relaxed"
          rows="3" placeholder="Your message">
        </textarea>
          <div class=" w-100 d-flex justify-between absolute bottom-[13px] flex items-center">
            <div class="flex items-center gap-[20px]">
              <button type="button" class=" rounded-full  " title="Attach">
              <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path d="M12 23.75C10.2103 23.7484 8.49431 23.0367 7.22878 21.7712C5.96326 20.5057 5.25159 18.7897 5.25 17V5C5.25 2.38 7.38 0.25 10 0.25C12.62 0.25 14.75 2.38 14.75 5V16C14.75 17.516 13.516 18.75 12 18.75C10.484 18.75 9.25 17.516 9.25 16V7C9.25 6.80109 9.32902 6.61032 9.46967 6.46967C9.61032 6.32902 9.80109 6.25 10 6.25C10.1989 6.25 10.3897 6.32902 10.5303 6.46967C10.671 6.61032 10.75 6.80109 10.75 7V16C10.7681 16.3193 10.9076 16.6196 11.1401 16.8392C11.3725 17.0589 11.6802 17.1813 12 17.1813C12.3198 17.1813 12.6275 17.0589 12.8599 16.8392C13.0924 16.6196 13.2319 16.3193 13.25 16V5C13.25 3.208 11.792 1.75 10 1.75C8.208 1.75 6.75 3.208 6.75 5V17C6.75 19.894 9.106 22.25 12 22.25C14.894 22.25 17.25 19.894 17.25 17V7C17.25 6.80109 17.329 6.61032 17.4697 6.46967C17.6103 6.32902 17.8011 6.25 18 6.25C18.1989 6.25 18.3897 6.32902 18.5303 6.46967C18.671 6.61032 18.75 6.80109 18.75 7V17C18.7484 18.7897 18.0367 20.5057 16.7712 21.7712C15.5057 23.0367 13.7897 23.7484 12 23.75Z" fill="black"/>
                </svg>

              </button>
              <button type="button" class=" rounded-full  x" title="Emoji">
                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path d="M12 0C9.62663 0 7.30655 0.703788 5.33316 2.02236C3.35977 3.34094 1.8217 5.21509 0.913451 7.4078C0.00519938 9.60051 -0.232441 12.0133 0.230582 14.3411C0.693605 16.6689 1.83649 18.8071 3.51472 20.4853C5.19295 22.1635 7.33115 23.3064 9.65892 23.7694C11.9867 24.2324 14.3995 23.9948 16.5922 23.0866C18.7849 22.1783 20.6591 20.6402 21.9776 18.6668C23.2962 16.6935 24 14.3734 24 12C24 8.8174 22.7357 5.76516 20.4853 3.51472C18.2348 1.26428 15.1826 0 12 0ZM16.3926 7.68789C16.6973 7.68758 16.9951 7.77765 17.2485 7.94668C17.5019 8.11572 17.6995 8.35614 17.8162 8.63751C17.9329 8.91887 17.9635 9.22854 17.9042 9.52732C17.8448 9.82609 17.6982 10.1005 17.4828 10.3159C17.2674 10.5313 16.9929 10.678 16.6942 10.7373C16.3954 10.7967 16.0857 10.7661 15.8044 10.6494C15.523 10.5326 15.2826 10.3351 15.1135 10.0817C14.9445 9.82826 14.8544 9.5304 14.8547 9.22579C14.8547 8.81791 15.0168 8.42675 15.3052 8.13833C15.5936 7.84992 15.9848 7.68789 16.3926 7.68789ZM7.60737 7.68789C7.91199 7.68758 8.20985 7.77765 8.46325 7.94668C8.71666 8.11572 8.91422 8.35614 9.03094 8.63751C9.14765 8.91887 9.17827 9.22854 9.11892 9.52732C9.05957 9.82609 8.91292 10.1005 8.69753 10.3159C8.48213 10.5313 8.20768 10.678 7.9089 10.7373C7.61013 10.7967 7.30046 10.7661 7.01909 10.6494C6.73773 10.5326 6.49731 10.3351 6.32827 10.0817C6.15923 9.82826 6.06917 9.5304 6.06948 9.22579C6.0699 8.81804 6.23206 8.42712 6.52038 8.1388C6.8087 7.85048 7.19963 7.68831 7.60737 7.68789ZM18.7579 15.06C18.2542 17.9353 15.42 19.9295 12 19.9295C8.58001 19.9295 5.74737 17.9353 5.24369 15.06C5.23828 15.0308 5.23511 15.0013 5.23422 14.9716C5.23422 14.5563 5.73948 14.2879 6.18158 14.4395C7.88685 15.0284 9.87632 15.3284 12.0016 15.3284C14.1268 15.3284 16.1163 15.0284 17.8216 14.4395C18.2621 14.2816 18.769 14.5547 18.769 14.9716C18.7676 15.0013 18.7639 15.0309 18.7579 15.06Z" fill="black"/>
                </svg>

                    </button>
                  </div>
                  <button style="margin-right: 35px;" type="button" class=" rounded-full " title="Voice">
                  <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path d="M12.0001 16.615C13.2695 16.615 14.3558 16.1631 15.2597 15.2596C16.1633 14.3562 16.6152 13.2693 16.6152 12V4.61551C16.6152 3.34621 16.1637 2.25979 15.2597 1.35588C14.3558 0.45218 13.2695 0 12.0001 0C10.7309 0 9.6444 0.45218 8.74055 1.35588C7.83664 2.25964 7.38477 3.34621 7.38477 4.61551V12C7.38477 13.2692 7.83684 14.3562 8.74055 15.2596C9.64425 16.1631 10.7309 16.615 12.0001 16.615Z" fill="black"/>
                <path d="M20.0325 9.50506C19.8504 9.32234 19.6335 9.23096 19.3835 9.23096C19.1338 9.23096 18.9175 9.32234 18.7345 9.50506C18.552 9.68773 18.4607 9.90405 18.4607 10.154V12.0002C18.4607 13.7791 17.8283 15.3007 16.5639 16.5651C15.2998 17.8295 13.7781 18.4617 11.9991 18.4617C10.2202 18.4617 8.69863 17.8295 7.43413 16.5651C6.16978 15.301 5.53766 13.7792 5.53766 12.0002V10.154C5.53766 9.90405 5.44628 9.68773 5.26366 9.50506C5.08093 9.32234 4.86482 9.23096 4.61466 9.23096C4.3645 9.23096 4.14813 9.32234 3.96551 9.50506C3.78274 9.68773 3.69141 9.90405 3.69141 10.154V12.0002C3.69141 14.1252 4.40067 15.9739 5.81879 17.5458C7.23696 19.1178 8.98935 20.0192 11.076 20.2498V22.1538H7.38376C7.13375 22.1538 6.91744 22.2453 6.73477 22.428C6.55205 22.6106 6.46066 22.827 6.46066 23.077C6.46066 23.3266 6.55205 23.5435 6.73477 23.726C6.91744 23.9086 7.13375 24.0002 7.38376 24.0002H16.6142C16.8642 24.0002 17.0808 23.9087 17.2632 23.726C17.4461 23.5435 17.5376 23.3267 17.5376 23.077C17.5376 22.8271 17.4461 22.6107 17.2632 22.428C17.0809 22.2453 16.8642 22.1538 16.6142 22.1538H12.9224V20.2498C15.0087 20.0192 16.761 19.1178 18.1793 17.5458C19.5976 15.9739 20.3071 14.1252 20.3071 12.0002V10.154C20.3071 9.9041 20.2155 9.68794 20.0325 9.50506Z" fill="black"/>
                </svg>

            </button>
          </div>
      </div>
    </div>
</div>
<!-- Panel -->
<div id="message_tutor_panel_screen_2" class="hidden my_lessons_details_my_lessons_content_message_tutor_panel fixed bottom-6 right-6 z-[2147483647]
            w-[494px] max-w-[95vw] max-h-[79vh] h-[671px] bg-white border border-gray-200 
            my_lessons_details_my_lessons_content_message_tutor_shadow
             flex-col overflow-hidden justify-between">
    
    <!-- Header -->
    <div class="message-header">
      <div class="flex items-center justify-between h-[40px]" style="height: 64px;
          width: calc(100% + 48px);
          margin-left: -24px;
          padding-inline: 24px;
          border-bottom: 1px solid #DCDCE5;">
        <div class="flex items-center gap-2">
          <button type="button" id="message_tutor_panel_screen_back_2"
                  class="my_lessons_details_my_lessons_content_message_tutor_back w-9 h-9 rounded-full hover:bg-gray-100 flex items-center justify-center"
                  aria-label="Back">
            <svg class="min-w-[40px]" width="40" height="40" viewBox="0 0 40 40" fill="none" xmlns="http://www.w3.org/2000/svg">
              <path fill-rule="evenodd" clip-rule="evenodd" d="M15.9141 20.9932L27.9141 20.9932L27.9141 18.9932L15.9141 18.9932L21.2071 13.7002L19.7931 12.2862L12.0861 19.9932L19.7931 27.7002L21.2071 26.2862L15.9141 20.9932Z" fill="#121117"/>
            </svg>

          </button>
          <p href="#" class="text-[18px] ml-1 font-[600] hover:text-[#121117]">Attachment</p>
        </div>

        <div class="flex items-center" style="gap: 12px;">
          <button type="button" style="visibility: hidden;"
                  class="w-9 h-9 rounded-full hover:bg-gray-100 flex items-center justify-center"
                  aria-label="Docs">
          <svg class="min-w-[40px]" width="40" height="40" viewBox="0 0 40 40" fill="none" xmlns="http://www.w3.org/2000/svg">
            <path d="M17 12H11V28H29V15H19L17 12ZM27 17V26H13V17H27Z" fill="#121117"/>
          </svg>

          </button>
          <button type="button"
                  class="my_lessons_details_my_lessons_content_message_tutor_close w-9 h-9 rounded-full hover:bg-gray-100 flex items-center justify-center"
                  aria-label="Close">
            <svg class="min-w-[40px]" width="40" height="40" viewBox="0 0 40 40" fill="none" xmlns="http://www.w3.org/2000/svg">
              <path fill-rule="evenodd" clip-rule="evenodd" d="M15.414 14L14 15.414L18.95 20.364L14 25.314L15.414 26.728L20.364 21.778L25.314 26.728L26.728 25.314L21.778 20.364L26.728 15.414L25.314 14L20.364 18.95L15.414 14Z" fill="#121117"/>
            </svg>

          </button>
        </div>
      </div>
      
    </div>

    <!-- Today pill -->
    <div class="pt-[17px] pb-[20px] d-flex items-center justify-center">
      <div class="h-[26px] my_lessons_details_my_lessons_content_message_tutor_today
                bg-[#F4F4F8] text-[#6A697C] text-[12px] rounded-[4px] flex items-center w-[92px] justify-center">
        Today
      </div>
    </div>

     <!-- Feed -->
    <div class="my_lessons_details_my_lessons_content_message_tutor_feed
                my_lessons_details_my_lessons_content_message_tutor_scroll flex-1 overflow-y-auto space-y-7 max-h-[324px]">

      <!-- Daniela -->
      <div class="flex items-start gap-[12px]">
        <img src="https://i.pravatar.cc/80?img=5" alt="Daniela" class="w-8 h-8 rounded-full"/>
        <div>
          <div class="flex items-center text-[16px] font-[400]">
            Daniela <span style="margin-top:-3px" class="text-[12px] text-[#6A697C] align-middle ml-1">09:34</span>
          </div>
          <div class="mt-[11px] leading-relaxed text-[16px] font-[600]" data-ml_msgtext>
            https://meet.google.com/vbo-qjai-eqt
          </div>
        </div>
      </div>

    </div>

</div>

<script>
$(function(){
  // Use long, namespaced vars per your request
  const $my_lessons_details_my_lessons_content_message_tutor_document = $(document);

  // OPEN
  $my_lessons_details_my_lessons_content_message_tutor_document.on(
    'click',
    '.my_lessons_details_my_lessons_content_message_tutor_btn',
    function(){
      $('#message_tutor_panel_screen_1') .addClass('hidden')
      $('#message_tutor_panel_screen_2') .removeClass('hidden')
    }
  );

  // CLOSE (back & close)
$my_lessons_details_my_lessons_content_message_tutor_document.on(
  'click',
  '.my_lessons_details_my_lessons_content_message_tutor_panel #message_tutor_panel_screen_back_1, \
   .my_lessons_details_my_lessons_content_message_tutor_panel .my_lessons_details_my_lessons_content_message_tutor_close',
  function () {
    $('#message_tutor_panel_screen_1').addClass('hidden');
    $('#message_tutor_panel_screen_2').addClass('hidden');
  }
);


  $my_lessons_details_my_lessons_content_message_tutor_document.on(
    'click',
    '.my_lessons_details_my_lessons_content_message_tutor_panel #message_tutor_panel_screen_back_2',
    function(){
      $('#message_tutor_panel_screen_2') .addClass('hidden')
      $('#message_tutor_panel_screen_1') .removeClass('hidden')
    }
  );

   $my_lessons_details_my_lessons_content_message_tutor_document.on(
    'click',
    '#attachment-btn',
    function(){
      $('#message_tutor_panel_screen_2') .removeClass('hidden');
      $('#message_tutor_panel_screen_1') .addClass('hidden');
  });
  // --- Guard function: strip any injected leading numbers (e.g., "100 ") from text nodes
  function my_lessons_details_my_lessons_content_message_tutor_stripInjectedNumbers($root){
    $root.find('[data-ml_msgtext], .my_lessons_details_my_lessons_content_message_tutor_today').each(function(){
      const node = $(this).contents().filter(function(){ return this.nodeType === 3; }).get(0);
      if (node){
        const raw = node.nodeValue || '';
        const clean = raw.replace(/^\s*\d+\s+/, '');  // remove "100 " or "123 "
        if (clean !== raw) node.nodeValue = clean;
      } else {
        const txt = $(this).text();
        const clean2 = txt.replace(/^\s*\d+\s+/, '');
        if (clean2 !== txt) $(this).text(clean2);
      }
    });
  }

  // TEXTAREA autogrow
  $my_lessons_details_my_lessons_content_message_tutor_document.on(
    'input',
    '.my_lessons_details_my_lessons_content_message_tutor_panel .my_lessons_details_my_lessons_content_message_tutor_input',
    function(){
      this.style.height = 'auto';
      this.style.height = Math.min(this.scrollHeight, 140) + 'px';
    }
  );

  // Enter to send (no Shift)
  $my_lessons_details_my_lessons_content_message_tutor_document.on(
    'keydown',
    '.my_lessons_details_my_lessons_content_message_tutor_panel .my_lessons_details_my_lessons_content_message_tutor_input',
    function(e){
      if (e.key === 'Enter' && !e.shiftKey){
        e.preventDefault();
        const $my_lessons_details_my_lessons_content_message_tutor_panel = $(this).closest('.my_lessons_details_my_lessons_content_message_tutor_panel');
        const $my_lessons_details_my_lessons_content_message_tutor_feed  = $my_lessons_details_my_lessons_content_message_tutor_panel.find('.my_lessons_details_my_lessons_content_message_tutor_feed');
        const $my_lessons_details_my_lessons_content_message_tutor_input = $(this);

        const my_lessons_details_my_lessons_content_message_tutor_text = $my_lessons_details_my_lessons_content_message_tutor_input.val().trim();
        if(!my_lessons_details_my_lessons_content_message_tutor_text) return;

        const my_lessons_details_my_lessons_content_message_tutor_now = new Date();
        const my_lessons_details_my_lessons_content_message_tutor_hh = String(my_lessons_details_my_lessons_content_message_tutor_now.getHours()).padStart(2,'0');
        const my_lessons_details_my_lessons_content_message_tutor_mm = String(my_lessons_details_my_lessons_content_message_tutor_now.getMinutes()).padStart(2,'0');

        const my_lessons_details_my_lessons_content_message_tutor_safeHtml =
          $('<div>').text(my_lessons_details_my_lessons_content_message_tutor_text).html().replace(/^\s*\d+\s+/, '');

        const my_lessons_details_my_lessons_content_message_tutor_bubble =
          `<div class="flex items-start gap-3">
            <img src="https://api.iconify.design/twemoji:fire.svg" class="w-8 h-8" alt="You"/>
            <div>
              <div class="text-sm font-semibold text-gray-900">You
                <span class="text-xs text-gray-500 align-middle">${my_lessons_details_my_lessons_content_message_tutor_hh}:${my_lessons_details_my_lessons_content_message_tutor_mm}</span>
              </div>
              <div class="mt-1 text-[15px] text-gray-800" data-ml_msgtext>${my_lessons_details_my_lessons_content_message_tutor_safeHtml}</div>
            </div>
          </div>`;

        $my_lessons_details_my_lessons_content_message_tutor_feed.append(my_lessons_details_my_lessons_content_message_tutor_bubble);
        $my_lessons_details_my_lessons_content_message_tutor_input.val('').trigger('input');
        $my_lessons_details_my_lessons_content_message_tutor_feed.scrollTop($my_lessons_details_my_lessons_content_message_tutor_feed[0].scrollHeight);
        my_lessons_details_my_lessons_content_message_tutor_stripInjectedNumbers($my_lessons_details_my_lessons_content_message_tutor_panel);
      }
    }
  );

  // Responsive height/width per viewport
  function my_lessons_details_my_lessons_content_message_tutor_applyMobile(){
    $('.my_lessons_details_my_lessons_content_message_tutor_panel').each(function(){
      const $my_lessons_details_my_lessons_content_message_tutor_panel = $(this);
      const $my_lessons_details_my_lessons_content_message_tutor_feed  = $my_lessons_details_my_lessons_content_message_tutor_panel.find('.my_lessons_details_my_lessons_content_message_tutor_feed');
      if (window.matchMedia('(max-width:640px)').matches){
        $my_lessons_details_my_lessons_content_message_tutor_panel.css({ width:'min(95vw,560px)' });
        $my_lessons_details_my_lessons_content_message_tutor_feed.css('max-height','72vh');
      } else {
        $my_lessons_details_my_lessons_content_message_tutor_panel.css({ width:'' });
        $my_lessons_details_my_lessons_content_message_tutor_feed.css('max-height','68vh');
      }
    });
  }
  // my_lessons_details_my_lessons_content_message_tutor_applyMobile();
  $(window).on('resize', my_lessons_details_my_lessons_content_message_tutor_applyMobile);

  // Initial sanitize
  $('.my_lessons_details_my_lessons_content_message_tutor_panel').each(function(){
    my_lessons_details_my_lessons_content_message_tutor_stripInjectedNumbers($(this));
  });
});
</script>

</body>
</html>
