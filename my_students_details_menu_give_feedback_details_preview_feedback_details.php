<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <title>Feedback Preview</title>

    <style>
        /* ========== GLOBAL / LAYOUT ========== */
        body.my_students_details_menu_give_feedback_details_preview_feedback_details_php_body {
            margin: 0;
            padding: 0;
            font-family: system-ui, -apple-system, BlinkMacSystemFont, "Segoe UI", sans-serif;
            background: #f5f5f7;
            color: #111827;
        }

        .my_students_details_menu_give_feedback_details_preview_feedback_details_php_page_wrapper {
            min-height: 100vh;
            display: flex;
            flex-direction: column;
        }

        /* ========== TOP PREVIEW BAR ========== */
        .my_students_details_menu_give_feedback_details_preview_feedback_details_php_preview_bar {
            background: #fff5c2;
            color: #000000ff;
            padding: 15px 16px;
            font-size: 15px;
            display: flex;
            align-items: center;
            justify-content: center;
            text-align: center;

            /* Make bar full-bleed (no side gaps) */
            width: 99vw;
            margin-left: calc(50% - 50vw);
            box-sizing: border-box;
        }

        .my_students_details_menu_give_feedback_details_preview_feedback_details_php_preview_bar_icon {
            margin-right: 8px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
        }

        .my_students_details_menu_give_feedback_details_preview_feedback_details_php_preview_bar_icon img {
            width: 16px;
            height: 16px;
            display: block;
        }

        /* ========== MAIN CONTENT ========== */
        .my_students_details_menu_give_feedback_details_preview_feedback_details_php_main {
            flex: 1 0 auto;
            padding: 32px 16px 96px;
            /* bottom padding so content isn't hidden behind footer */
            display: flex;
            justify-content: center;
            box-sizing: border-box;
        }

        .my_students_details_menu_give_feedback_details_preview_feedback_details_php_content {
            width: 100%;
            max-width: 960px;
        }

        /* Header (avatar + title) */
        .my_students_details_menu_give_feedback_details_preview_feedback_details_php_header {
            text-align: center;
            margin-bottom: 32px;
        }

        .my_students_details_menu_give_feedback_details_preview_feedback_details_php_avatar_wrapper {
            width: 80px;
            height: 80px;
            border-radius: 5px;
            overflow: hidden;
            margin: 0 auto 12px;
        }

        .my_students_details_menu_give_feedback_details_preview_feedback_details_php_avatar_image {
            width: 100%;
            height: 100%;
            object-fit: cover;
            display: block;
        }

        .my_students_details_menu_give_feedback_details_preview_feedback_details_php_subtitle {
            font-size: 18px;
            color: #000;
            margin-bottom: 8px;
            font-weight: 600;
        }

        .my_students_details_menu_give_feedback_details_preview_feedback_details_php_title {
            font-size: 40px;
            line-height: 1.2;
            font-weight: 700;
            margin: 0;
        }

        /* Sections */
        .my_students_details_menu_give_feedback_details_preview_feedback_details_php_section {
            margin-bottom: 32px;
        }

        .my_students_details_menu_give_feedback_details_preview_feedback_details_php_section_title {
            font-size: 20px;
            font-weight: 600;
            margin-bottom: 4px;
        }

        .my_students_details_menu_give_feedback_details_preview_feedback_details_php_section_subtitle {
            font-size: 16px;
            color: #6b7280;
            margin-bottom: 16px;
        }

        /* Card wrapper */
        .my_students_details_menu_give_feedback_details_preview_feedback_details_php_card {
            background: #f6f6f6;
            border-radius: 10px;
            border: 1px solid #e5e7eb;
            padding: 16px 20px;
            box-shadow: 0 2px 8px rgba(15, 23, 42, 0.06);
        }

        /* Progress grid inside card */
        .my_students_details_menu_give_feedback_details_preview_feedback_details_php_progress_grid {
            display: grid;
            grid-template-columns: repeat(2, minmax(0, 1fr));
            gap: 12px 24px;
            font-size: 14px;
        }

        .my_students_details_menu_give_feedback_details_preview_feedback_details_php_progress_label {
            font-weight: 600;
            margin-bottom: 4px;
        }

        .my_students_details_menu_give_feedback_details_preview_feedback_details_php_tag {
            display: inline-flex;
            align-items: center;
            padding: 6px 10px;
            border-radius: 5px;
            background: #c7f5df;
            font-size: 13px;
            color: #000000ff;
            font-weight: 500;
        }

        .my_students_details_menu_give_feedback_details_preview_feedback_details_php_tag_icon,
        .my_students_details_menu_give_feedback_details_preview_feedback_details_php_tag_next_step_icon {
            margin-right: 6px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
        }

        .my_students_details_menu_give_feedback_details_preview_feedback_details_php_tag_icon img,
        .my_students_details_menu_give_feedback_details_preview_feedback_details_php_tag_next_step_icon img {
            width: 14px;
            height: 14px;
            display: block;
        }

        /* Next steps tag (red) */
        .my_students_details_menu_give_feedback_details_preview_feedback_details_php_tag_next_step {
            background: #fee2e2;
            color: #000000ff;
        }

        /* Note card layout */
        .my_students_details_menu_give_feedback_details_preview_feedback_details_php_note_header {
            display: flex;
            align-items: center;
            margin-bottom: 12px;
            font-weight: 600;
        }

        .my_students_details_menu_give_feedback_details_preview_feedback_details_php_note_avatar {
            width: 40px;
            height: 40px;
            border-radius: 5px;
            overflow: hidden;
            margin-right: 10px;
            flex-shrink: 0;
        }

        .my_students_details_menu_give_feedback_details_preview_feedback_details_php_note_avatar img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            display: block;
        }

        .my_students_details_menu_give_feedback_details_preview_feedback_details_php_note_name {
            font-size: 15px;
        }

        .my_students_details_menu_give_feedback_details_preview_feedback_details_php_note_text {
            font-size: 14px;
            color: #111827;
            line-height: 1.6;
            white-space: pre-line;
        }

        /* ========== STICKY FOOTER BAR ========== */
        .my_students_details_menu_give_feedback_details_preview_feedback_details_php_footer {
            position: sticky;
            bottom: 0;
            background: #ffffff;
            border-top: 1px solid #e5e7eb;
            box-shadow: 0 -4px 12px rgba(15, 23, 42, 0.12);
            padding: 12px 16px;
            display: flex;
            justify-content: center;
            z-index: 20;

            /* Make footer full-bleed (no side gaps) */
            width: 99vw;
            margin-left: calc(50% - 50vw);
            box-sizing: border-box;
        }

        .my_students_details_menu_give_feedback_details_preview_feedback_details_php_footer_inner {
            width: 100%;
            max-width: 1350px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 12px;
        }

        /* Exit preview button */
        .my_students_details_menu_give_feedback_details_preview_feedback_details_php_exit_button {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            padding: 13px 16px;
            border-radius: 5px;
            border: 1px solid #d1d5db;
            background: #ffffff;
            cursor: pointer;
            font-size: 14px;
            font-weight: 500;
        }

        .my_students_details_menu_give_feedback_details_preview_feedback_details_php_exit_icon {
            display: inline-flex;
            align-items: center;
            justify-content: center;
        }

        .my_students_details_menu_give_feedback_details_preview_feedback_details_php_exit_icon img {
            width: 16px;
            height: 16px;
            display: block;
        }

        /* Send feedback button (red) */
        .my_students_details_menu_give_feedback_details_preview_feedback_details_php_send_button {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            padding: 13px 24px;
            border-radius: 5px;
            border: 2px solid #000000;
            background: #ff7aac;
            color: #000000;
            font-size: 14px;
            font-weight: 600;
            cursor: pointer;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.18);
            transition: box-shadow 0.15s ease, transform 0.1s ease, filter 0.1s ease;
            white-space: nowrap;
        }

        .my_students_details_menu_give_feedback_details_preview_feedback_details_php_send_button:hover {
            filter: brightness(1.05);
            box-shadow: 0 6px 16px rgba(0, 0, 0, 0.28);
            transform: translateY(-1px);
        }

        .my_students_details_menu_give_feedback_details_preview_feedback_details_php_send_icon {
            display: inline-flex;
            align-items: center;
            justify-content: center;
        }

        .my_students_details_menu_give_feedback_details_preview_feedback_details_php_send_icon img {
            width: 16px;
            height: 16px;
            display: block;
        }

        /* ========== RESPONSIVE ========== */
        @media (max-width: 768px) {
            .my_students_details_menu_give_feedback_details_preview_feedback_details_php_title {
                font-size: 24px;
            }

            .my_students_details_menu_give_feedback_details_preview_feedback_details_php_progress_grid {
                grid-template-columns: 1fr;
            }
        }

        @media (max-width: 640px) {
            .my_students_details_menu_give_feedback_details_preview_feedback_details_php_footer_inner {
                flex-direction: column;
                align-items: stretch;
            }

            .my_students_details_menu_give_feedback_details_preview_feedback_details_php_exit_button,
            .my_students_details_menu_give_feedback_details_preview_feedback_details_php_send_button {
                width: 100%;
                justify-content: center;
            }
        }
    </style>
</head>

<body class="my_students_details_menu_give_feedback_details_preview_feedback_details_php_body">
    <div class="my_students_details_menu_give_feedback_details_preview_feedback_details_php_page_wrapper">

        <!-- Top preview bar -->
        <div class="my_students_details_menu_give_feedback_details_preview_feedback_details_php_preview_bar">
            <span class="my_students_details_menu_give_feedback_details_preview_feedback_details_php_preview_bar_icon">
                <img src="img/my_students/preview_eye.svg" alt="Preview mode" />
            </span>
            <span>
                <strong>You're in preview mode.</strong> This is how Latingles will view your feedback. It will be sent
                via the Preply chat.
            </span>
        </div>

        <!-- Main content -->
        <main class="my_students_details_menu_give_feedback_details_preview_feedback_details_php_main">
            <div class="my_students_details_menu_give_feedback_details_preview_feedback_details_php_content">

                <!-- Header -->
                <header class="my_students_details_menu_give_feedback_details_preview_feedback_details_php_header">
                    <div class="my_students_details_menu_give_feedback_details_preview_feedback_details_php_avatar_wrapper">
                        <!-- Replace src with real image if you have one -->
                        <img
                            src="https://images.pexels.com/photos/415829/pexels-photo-415829.jpeg?auto=compress&cs=tinysrgb&w=400"
                            alt="Teacher avatar"
                            class="my_students_details_menu_give_feedback_details_preview_feedback_details_php_avatar_image" />
                    </div>
                    <div class="my_students_details_menu_give_feedback_details_preview_feedback_details_php_subtitle">
                        New feedback from Daniela 🎉
                    </div>
                    <h1 class="my_students_details_menu_give_feedback_details_preview_feedback_details_php_title">
                        Great job so far! Here’s a look at<br />
                        your progress and next steps.
                    </h1>
                </header>

                <!-- Your progress -->
                <section class="my_students_details_menu_give_feedback_details_preview_feedback_details_php_section">
                    <h2 class="my_students_details_menu_give_feedback_details_preview_feedback_details_php_section_title">
                        Your progress
                    </h2>
                    <p class="my_students_details_menu_give_feedback_details_preview_feedback_details_php_section_subtitle">
                        Areas where Daniela has seen you improve.
                    </p>

                    <div class="my_students_details_menu_give_feedback_details_preview_feedback_details_php_card">
                        <div class="my_students_details_menu_give_feedback_details_preview_feedback_details_php_progress_grid">
                            <!-- Effort -->
                            <div>
                                <div class="my_students_details_menu_give_feedback_details_preview_feedback_details_php_progress_label">
                                    Effort
                                </div>
                                <div class="my_students_details_menu_give_feedback_details_preview_feedback_details_php_tag">
                                    <span class="my_students_details_menu_give_feedback_details_preview_feedback_details_php_tag_icon">
                                        <img src="img/my_students/feedback_progress.svg" alt="" />
                                    </span>
                                    <span>Taking regular lessons</span>
                                </div>
                            </div>

                            <!-- Speaking -->
                            <div>
                                <div class="my_students_details_menu_give_feedback_details_preview_feedback_details_php_progress_label">
                                    Speaking
                                </div>
                                <div class="my_students_details_menu_give_feedback_details_preview_feedback_details_php_tag">
                                    <span class="my_students_details_menu_give_feedback_details_preview_feedback_details_php_tag_icon">
                                        <img src="img/my_students/feedback_progress.svg" alt="" />
                                    </span>
                                    <span>Pronunciation</span>
                                </div>
                            </div>

                            <!-- Listening -->
                            <div>
                                <div class="my_students_details_menu_give_feedback_details_preview_feedback_details_php_progress_label">
                                    Listening
                                </div>
                                <div class="my_students_details_menu_give_feedback_details_preview_feedback_details_php_tag">
                                    <span class="my_students_details_menu_give_feedback_details_preview_feedback_details_php_tag_icon">
                                        <img src="img/my_students/feedback_progress.svg" alt="" />
                                    </span>
                                    <span>Listening for the main idea</span>
                                </div>
                            </div>

                            <!-- Writing example (optional) -->
                            <div>
                                <div class="my_students_details_menu_give_feedback_details_preview_feedback_details_php_progress_label">
                                    Writing
                                </div>
                                <div class="my_students_details_menu_give_feedback_details_preview_feedback_details_php_tag">
                                    <span class="my_students_details_menu_give_feedback_details_preview_feedback_details_php_tag_icon">
                                        <img src="img/my_students/feedback_progress.svg" alt="" />
                                    </span>
                                    <span>Using new vocabulary</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>

                <!-- Your next steps -->
                <section class="my_students_details_menu_give_feedback_details_preview_feedback_details_php_section">
                    <h2 class="my_students_details_menu_give_feedback_details_preview_feedback_details_php_section_title">
                        Your next steps
                    </h2>
                    <p class="my_students_details_menu_give_feedback_details_preview_feedback_details_php_section_subtitle">
                        Areas that Daniela recommends you focus on in the next month.
                    </p>

                    <div class="my_students_details_menu_give_feedback_details_preview_feedback_details_php_card">
                        <div class="my_students_details_menu_give_feedback_details_preview_feedback_details_php_progress_grid">
                            <div>
                                <div class="my_students_details_menu_give_feedback_details_preview_feedback_details_php_progress_label">
                                    Effort
                                </div>
                                <div
                                    class="my_students_details_menu_give_feedback_details_preview_feedback_details_php_tag my_students_details_menu_give_feedback_details_preview_feedback_details_php_tag_next_step">
                                    <span
                                        class="my_students_details_menu_give_feedback_details_preview_feedback_details_php_tag_next_step_icon">
                                        <img src="img/my_students/feedback_next_step.svg" alt="" />
                                    </span>
                                    <span>Time talking in lessons</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>

                <!-- Note from Daniela -->
                <section class="my_students_details_menu_give_feedback_details_preview_feedback_details_php_section">
                    <h2 class="my_students_details_menu_give_feedback_details_preview_feedback_details_php_section_title">
                        A note from Daniela
                    </h2>

                    <div class="my_students_details_menu_give_feedback_details_preview_feedback_details_php_card">
                        <div
                            class="my_students_details_menu_give_feedback_details_preview_feedback_details_php_note_header">
                            <div
                                class="my_students_details_menu_give_feedback_details_preview_feedback_details_php_note_avatar">
                                <img
                                    src="https://images.pexels.com/photos/415829/pexels-photo-415829.jpeg?auto=compress&cs=tinysrgb&w=400"
                                    alt="Daniela" />
                            </div>
                            <div
                                class="my_students_details_menu_give_feedback_details_preview_feedback_details_php_note_name">
                                Daniela
                            </div>
                        </div>

                        <div class="my_students_details_menu_give_feedback_details_preview_feedback_details_php_note_text">
                            Hello Latingles!

                            I've really enjoyed having you in my lessons and getting to know you these past couple of
                            weeks! You've been working hard towards your goal, so I'd like to highlight your progress
                            and share a few tips for moving forward. It's a pleasure to be part of your learning
                            journey!

                            ✨ Your highlights

                            I've noticed you're taking lessons regularly, which is great! Your pronunciation is getting
                            better, and you're doing a good job listening for the main idea in conversations. Keep up
                            the good work!

                            💕 What we will focus on next

                            In our coming lessons, we're going to work on increasing the time you spend talking. This
                            will help you become more fluent and confident in your Spanish speaking skills. It's all
                            about practice!

                            Recommended out-of-class activities

                            To help you practice more, try watching a Spanish-speaking show or YouTube channel for about
                            30 minutes each day. Choose something that interests you, and focus on listening to the way
                            they speak and pronounce words. This will be a fun way to improve your listening and
                            speaking skills outside of class.

                            Thank you for your hard work and dedication. I'm looking forward to continuing to work with
                            you and help you make even more progress. See you in our next class!
                        </div>
                    </div>
                </section>
            </div>
        </main>

        <!-- Sticky footer -->
        <footer class="my_students_details_menu_give_feedback_details_preview_feedback_details_php_footer">
            <div class="my_students_details_menu_give_feedback_details_preview_feedback_details_php_footer_inner">

                <a href="my_students_details_menu_give_feedback.php">
                    <button type="button"
                        class="my_students_details_menu_give_feedback_details_preview_feedback_details_php_exit_button">
                        <span
                            class="my_students_details_menu_give_feedback_details_preview_feedback_details_php_exit_icon">
                            <img src="img/my_students/exit.svg" alt="Exit preview" />
                        </span>
                        <span>Exit preview mode</span>
                    </button>
                </a>

                <button type="button"
                    class="my_students_details_menu_give_feedback_details_preview_feedback_details_php_send_button"
                    onclick="my_students_details_menu_give_feedback_details_preview_feedback_details_php_handle_send_feedback()">
                    <span>Send feedback</span>
                    <span
                        class="my_students_details_menu_give_feedback_details_preview_feedback_details_php_send_icon">
                        <img src="img/my_students/send_feedback.svg" alt="Send" />
                    </span>
                </button>
            </div>
        </footer>
    </div>

    <script>
        // Simple demo handlers; replace with real navigation / API logic.        
        function my_students_details_menu_give_feedback_details_preview_feedback_details_php_handle_exit_preview() {
            alert('Exit preview mode (demo)');
        }

        function my_students_details_menu_give_feedback_details_preview_feedback_details_php_handle_send_feedback() {
            alert('Send feedback (demo)');
        }
    </script>
</body>

</html>