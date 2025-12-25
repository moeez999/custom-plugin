<?php
// my_students_details_lessons_plans_step2_skip_content.php
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <title>Latingles – Feedback</title>
    <meta name="viewport" content="width=device-width, initial-scale=1" />

    <!-- Tailwind CDN -->
    <script src="https://cdn.tailwindcss.com"></script>

    <!-- jQuery CDN (kept if your project expects it) -->
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <style>
        body {
            font-family: system-ui, -apple-system, BlinkMacSystemFont, "Segoe UI", sans-serif;
        }
    </style>
</head>

<body class="my_students_details_lessons_plans_step2_skip_content_body min-h-screen bg-white text-gray-900 flex flex-col">

    <!-- Header (from your right code, Skip -> Close icon) -->
    <header
        class="my_students_details_lessons_plans_step2_skip_content_header w-full flex items-center justify-between px-6 md:px-20 pt-8"
        id="my_students_details_lessons_plans_step2_skip_content_header">
        <!-- Logo -->
        <div class="my_students_details_lessons_plans_step2_skip_content_logo_wrap flex items-center gap-3">
            <a href="http://localhost/latingles_lms_v2/course/index.php">
                <div class="my_students_details_lessons_plans_step2_skip_content_logo_box w-30 h-30 flex items-center justify-center">
                    <img
                        id="my_students_details_lessons_plans_step2_skip_content_logo_img"
                        src="img/my_students/logo_header.svg"
                        alt="Latingles logo"
                        class="my_students_details_lessons_plans_step2_skip_content_logo_img w-full h-full object-contain" />
                </div>
            </a>
        </div>

        <!-- Close icon -->
        <a href="http://localhost/latingles_lms_v2/course/index.php">
            <button
                type="button"
                id="my_students_details_lessons_plans_step2_skip_content_close_button"
                class="my_students_details_lessons_plans_step2_skip_content_close_button w-10 h-10 rounded-lg hover:bg-gray-50 transition inline-flex items-center justify-center"
                aria-label="Close">
                <svg
                    id="my_students_details_lessons_plans_step2_skip_content_close_icon"
                    class="my_students_details_lessons_plans_step2_skip_content_close_icon w-5 h-5"
                    viewBox="0 0 24 24"
                    aria-hidden="true">
                    <path d="M18.3 5.7a1 1 0 0 0-1.4 0L12 10.6 7.1 5.7A1 1 0 0 0 5.7 7.1l4.9 4.9-4.9 4.9a1 1 0 1 0 1.4 1.4l4.9-4.9 4.9 4.9a1 1 0 0 0 1.4-1.4L13.4 12l4.9-4.9a1 1 0 0 0 0-1.4Z" fill="#111" />
                </svg>
            </button>
        </a>
    </header>

    <!-- Main content -->
    <main
        class="my_students_details_lessons_plans_step2_skip_content_main flex-1 flex items-center justify-center px-4 pb-12"
        id="my_students_details_lessons_plans_step2_skip_content_main">
        <div
            class="my_students_details_lessons_plans_step2_skip_content_center max-w-3xl w-full flex flex-col items-center text-center"
            id="my_students_details_lessons_plans_step2_skip_content_center">
            <!-- TWO overlapped images (like Figma) -->
            <div
                class="my_students_details_lessons_plans_step2_skip_content_cards_wrap relative mb-6 md:mb-8"
                id="my_students_details_lessons_plans_step2_skip_content_cards_wrap"
                style="width: 160px; height: 95px;">
                <!-- Left card (logo card) -->
                <img
                    id="my_students_details_lessons_plans_step2_skip_content_card_left_img"
                    src="img/my_students/skip_content_card_left.png"
                    alt="Latingles card"
                    class="my_students_details_lessons_plans_step2_skip_content_card_left_img absolute left-0 top-3 w-[92px] md:w-[96px] h-auto rotate-[-10deg] drop-shadow-[0_10px_18px_rgba(0,0,0,0.18)]" />

                <!-- Right card (profile card) -->
                <img
                    id="my_students_details_lessons_plans_step2_skip_content_card_right_img"
                    src="img/my_students/skip_content_card_right.png"
                    alt="Profile card"
                    class="my_students_details_lessons_plans_step2_skip_content_card_right_img absolute right-0 top-0 w-[92px] md:w-[96px] h-auto rotate-[8deg] drop-shadow-[0_10px_18px_rgba(0,0,0,0.18)]" />
            </div>

            <h1
                id="my_students_details_lessons_plans_step2_skip_content_title"
                class="my_students_details_lessons_plans_step2_skip_content_title font-bold tracking-[-0.2px] leading-[1.12] text-[clamp(28px,2.2vw,52px)]">
                Great! Thankyou For Proving<br />Your Feedback
            </h1>

            <a href="my_students_details_lessons_plans.php">
                <button
                    type="button"
                    id="my_students_details_lessons_plans_step2_skip_content_go_back_btn"
                    class="my_students_details_lessons_plans_step2_skip_content_go_back_btn mt-7 md:mt-9 w-[min(420px,86vw)] h-[clamp(44px,5vw,40px)] bg-[#ff1a00] text-white  text-[clamp(14px,1.6vw,18px)] rounded-[5px] border-[2px] border-black hover:brightness-[0.98] hover:-translate-y-[1px] active:translate-y-0 transition">
                    Go Back
                </button>
            </a>
        </div>
    </main>

    <script>
        // -----------------------------
        // All names start with:
        // my_students_details_lessons_plans_step2_skip_content_
        // -----------------------------

        const my_students_details_lessons_plans_step2_skip_content_leftCardFallbackSvg =
            "data:image/svg+xml;utf8," + encodeURIComponent(`
        <svg xmlns="http://www.w3.org/2000/svg" width="220" height="140" viewBox="0 0 220 140">
          <defs>
            <linearGradient id="g" x1="0" y1="0" x2="1" y2="1">
              <stop offset="0" stop-color="#00b3ff"/>
              <stop offset="0.55" stop-color="#ff2a00"/>
              <stop offset="1" stop-color="#003cff"/>
            </linearGradient>
          </defs>
          <rect x="10" y="18" width="200" height="104" rx="14" fill="#fff" stroke="#ececec" stroke-width="2"/>
          <g transform="translate(26,44)">
            <circle cx="20" cy="20" r="18" fill="url(#g)"/>
            <circle cx="20" cy="20" r="8" fill="#fff" opacity=".9"/>
          </g>
          <text x="86" y="82" font-family="Georgia, serif" font-size="14" fill="#111">LATINGLES</text>
        </svg>
      `);

        const my_students_details_lessons_plans_step2_skip_content_rightCardFallbackSvg =
            "data:image/svg+xml;utf8," + encodeURIComponent(`
        <svg xmlns="http://www.w3.org/2000/svg" width="220" height="140" viewBox="0 0 220 140">
          <rect x="10" y="18" width="200" height="104" rx="14" fill="#fff" stroke="#ececec" stroke-width="2"/>
          <rect x="118" y="34" width="74" height="74" rx="14" fill="#1f1f1f"/>
          <circle cx="155" cy="62" r="16" fill="#444"/>
          <path d="M138 100c6-11 34-11 40 0" fill="none" stroke="#2f2f2f" stroke-width="6" stroke-linecap="round"/>
          <rect x="26" y="50" width="74" height="12" rx="6" fill="#eaeaea"/>
          <rect x="26" y="72" width="58" height="12" rx="6" fill="#eaeaea"/>
        </svg>
      `);

        function my_students_details_lessons_plans_step2_skip_content_applyFallbackImage(my_students_details_lessons_plans_step2_skip_content_imgEl, my_students_details_lessons_plans_step2_skip_content_fallbackSrc) {
            if (!my_students_details_lessons_plans_step2_skip_content_imgEl) return;
            my_students_details_lessons_plans_step2_skip_content_imgEl.onerror = function() {
                this.onerror = null;
                this.src = my_students_details_lessons_plans_step2_skip_content_fallbackSrc;
            };
        }

        function my_students_details_lessons_plans_step2_skip_content_goBack() {
            if (window.history.length > 1) window.history.back();
            else window.location.href = "./";
        }

        function my_students_details_lessons_plans_step2_skip_content_close() {
            my_students_details_lessons_plans_step2_skip_content_goBack();
        }

        // Init
        const my_students_details_lessons_plans_step2_skip_content_leftImgEl =
            document.getElementById("my_students_details_lessons_plans_step2_skip_content_card_left_img");

        const my_students_details_lessons_plans_step2_skip_content_rightImgEl =
            document.getElementById("my_students_details_lessons_plans_step2_skip_content_card_right_img");

        const my_students_details_lessons_plans_step2_skip_content_goBackBtnEl =
            document.getElementById("my_students_details_lessons_plans_step2_skip_content_go_back_btn");

        const my_students_details_lessons_plans_step2_skip_content_closeBtnEl =
            document.getElementById("my_students_details_lessons_plans_step2_skip_content_close_button");

        my_students_details_lessons_plans_step2_skip_content_applyFallbackImage(
            my_students_details_lessons_plans_step2_skip_content_leftImgEl,
            my_students_details_lessons_plans_step2_skip_content_leftCardFallbackSvg
        );

        my_students_details_lessons_plans_step2_skip_content_applyFallbackImage(
            my_students_details_lessons_plans_step2_skip_content_rightImgEl,
            my_students_details_lessons_plans_step2_skip_content_rightCardFallbackSvg
        );

        my_students_details_lessons_plans_step2_skip_content_goBackBtnEl.addEventListener(
            "click",
            my_students_details_lessons_plans_step2_skip_content_goBack
        );

        my_students_details_lessons_plans_step2_skip_content_closeBtnEl.addEventListener(
            "click",
            my_students_details_lessons_plans_step2_skip_content_close
        );
    </script>

</body>

</html>