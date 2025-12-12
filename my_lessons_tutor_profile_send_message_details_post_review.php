<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Post Review – Step 1</title>

    <!-- jQuery (shared) -->
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>

    <style>
        /* ================= BASE ================= */
        body {
            margin: 0;
            font-family: system-ui, -apple-system, BlinkMacSystemFont, "Segoe UI", sans-serif;
        }


        .my_lessons_tutor_profile_send_message_details_post_review_step1_demo_page_center {
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            background: #f3f4f6;
        }

        /* ================= OVERLAY ================= */
        #my_lessons_tutor_profile_send_message_details_post_review_step1_modal_overlay {
            position: fixed;
            inset: 0;
            display: none;
            align-items: center;
            justify-content: center;
            background: rgba(0, 0, 0, 0.35);
            z-index: 9999;
        }

        /* ================= MODAL CARD (STEP1 + STEP2) ================= */
        .my_lessons_tutor_profile_send_message_details_post_review_step1_modal_card {
            background: #ffffff;
            border-radius: 5px;
            max-width: 460px;
            width: 100%;
            min-height: 360px;
            box-shadow: 0 24px 70px rgba(15, 23, 42, 0.25);
            padding: 70px 32px 26px;
            position: relative;
            box-sizing: border-box;
        }

        @media (max-width: 640px) {
            .my_lessons_tutor_profile_send_message_details_post_review_step1_modal_card {
                margin: 0 16px;
                padding: 22px 18px 22px;
                border-radius: 16px;
            }
        }

        /* Close button for step1/step2 card */
        #my_lessons_tutor_profile_send_message_details_post_review_step1_modal_close_button {
            position: absolute;
            top: 5px;
            right: 20px;
            border: none;
            background: transparent;
            font-size: 30px;
            color: #9ca3af;
            cursor: pointer;
        }

        #my_lessons_tutor_profile_send_message_details_post_review_step1_modal_close_button:hover {
            color: #4b5563;
        }

        /* ================= STEP 1 STYLES ================= */

        .my_lessons_tutor_profile_send_message_details_post_review_step1_modal_header {
            display: flex;
            flex-direction: column;
            align-items: flex-start;
            margin-bottom: 18px;
            margin-top: 6px;
        }

        .my_lessons_tutor_profile_send_message_details_post_review_step1_modal_avatar_wrapper {
            margin-bottom: 10px;
        }

        .my_lessons_tutor_profile_send_message_details_post_review_step1_modal_avatar {
            width: 44px;
            height: 44px;
            border-radius: 10px;
            object-fit: cover;
            display: block;
            background: #f9fafb;
        }

        .my_lessons_tutor_profile_send_message_details_post_review_step1_modal_title {
            font-size: 28px;
            line-height: 1.35;
            font-weight: 700;
            color: #111827;
            margin: 0;
        }

        @media (max-width: 480px) {
            .my_lessons_tutor_profile_send_message_details_post_review_step1_modal_title {
                font-size: 18px;
            }
        }

        .my_lessons_tutor_profile_send_message_details_post_review_step1_options_wrapper {
            margin-top: 8px;
            margin-bottom: 26px;
        }

        .my_lessons_tutor_profile_send_message_details_post_review_step1_option_label {
            display: block;
            margin-bottom: 10px;
            cursor: pointer;
        }

        .my_lessons_tutor_profile_send_message_details_post_review_step1_option_card {
            display: flex;
            align-items: center;
            justify-content: space-between;
            border-radius: 5px;
            border: 1px solid #e5e7eb;
            background: #ffffff;
            height: 60px;
            padding: 0 20px;
            box-sizing: border-box;
            transition: border-color 0.15s ease, background-color 0.15s ease;
        }

        .my_lessons_tutor_profile_send_message_details_post_review_step1_option_card_unselected {}

        .my_lessons_tutor_profile_send_message_details_post_review_step1_option_card_selected {
            border-width: 2px;
            border-color: #111827;
            background-color: #ffffff;
        }

        .my_lessons_tutor_profile_send_message_details_post_review_step1_option_left {
            display: flex;
            align-items: center;
            gap: 14px;
        }

        .my_lessons_tutor_profile_send_message_details_post_review_step1_option_icon_box {
            width: 40px;
            height: 40px;
            border-radius: 8px;
            background: #f3f4f6;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .my_lessons_tutor_profile_send_message_details_post_review_step1_option_icon_image {
            width: 22px;
            height: 22px;
            object-fit: contain;
            display: block;
        }

        .my_lessons_tutor_profile_send_message_details_post_review_step1_option_text {
            font-size: 15px;
            font-weight: 500;
            color: #111827;
            white-space: nowrap;
        }

        .my_lessons_tutor_profile_send_message_details_post_review_step1_radio_outer {
            width: 22px;
            height: 22px;
            border-radius: 999px;
            border: 2px solid #d1d5db;
            display: flex;
            align-items: center;
            justify-content: center;
            box-sizing: border-box;
            background: #ffffff;
        }

        .my_lessons_tutor_profile_send_message_details_post_review_step1_radio_inner {
            width: 11px;
            height: 11px;
            border-radius: 999px;
            background: #000;
            opacity: 0;
        }

        .my_lessons_tutor_profile_send_message_details_post_review_step1_radio_outer_selected {
            border-color: #111827;
        }

        .my_lessons_tutor_profile_send_message_details_post_review_step1_radio_inner_selected {
            opacity: 1;
        }

        .my_lessons_tutor_profile_send_message_details_post_review_step1_radio_input {
            display: none;
        }

        #my_lessons_tutor_profile_send_message_details_post_review_step1_continue_button {
            width: 100%;
            margin-top: 8px;
            padding: 10px 16px;
            border-radius: 5px;
            border: 2px solid #111827;
            background: #ff4013;
            color: #ffffff;
            font-weight: 600;
            font-size: 15px;
            cursor: pointer;
            box-shadow: none;
            transition: background-color 0.15s ease, transform 0.1s ease;
        }

        #my_lessons_tutor_profile_send_message_details_post_review_step1_continue_button:hover {
            background: #ff5b2a;
            transform: translateY(-1px);
        }
    </style>
</head>

<body>

    <!-- DEMO TRIGGER (move this into your actual layout) -->
        <!-- <button id="my_lessons_tutor_profile_send_message_details_post_review_step1_open_modal_button">
            Post Review
        </button> -->

    <!-- ================= OVERLAY ================= -->
    <div id="my_lessons_tutor_profile_send_message_details_post_review_step1_modal_overlay">

        <!-- STEP 1 + STEP 2 CARD -->
        <div class="my_lessons_tutor_profile_send_message_details_post_review_step1_modal_card"
            id="my_lessons_tutor_profile_send_message_details_post_review_step1_step1_step2_card">

            <!-- Close -->
            <button
                id="my_lessons_tutor_profile_send_message_details_post_review_step1_modal_close_button"
                aria-label="Close">
                &times;
            </button>

            <!-- ========== STEP 1 CONTENT ========== -->
            <div id="my_lessons_tutor_profile_send_message_details_post_review_step1_wrapper">

                <div class="my_lessons_tutor_profile_send_message_details_post_review_step1_modal_header">
                    <div class="my_lessons_tutor_profile_send_message_details_post_review_step1_modal_avatar_wrapper">
                        <img
                            src="path/to/tutor-avatar.jpg"
                            alt="Daniela avatar"
                            class="my_lessons_tutor_profile_send_message_details_post_review_step1_modal_avatar">
                    </div>
                    <h1 class="my_lessons_tutor_profile_send_message_details_post_review_step1_modal_title">
                        How Would You Prefer to Share Your Feedback for Daniela Canelon?
                    </h1>
                </div>

                <!-- Options -->
                <div class="my_lessons_tutor_profile_send_message_details_post_review_step1_options_wrapper">

                    <!-- Public Review -->
                    <label class="my_lessons_tutor_profile_send_message_details_post_review_step1_option_label">
                        <input
                            type="radio"
                            name="my_lessons_tutor_profile_send_message_details_post_review_step1_feedback_type"
                            value="public_review"
                            class="my_lessons_tutor_profile_send_message_details_post_review_step1_radio_input">
                        <div
                            class="my_lessons_tutor_profile_send_message_details_post_review_step1_option_card my_lessons_tutor_profile_send_message_details_post_review_step1_option_card_unselected"
                            data-my_lessons_tutor_profile_send_message_details_post_review_step1_option="public_review">
                            <div class="my_lessons_tutor_profile_send_message_details_post_review_step1_option_left">
                                <div class="my_lessons_tutor_profile_send_message_details_post_review_step1_option_icon_box">
                                    <img
                                        src="path/to/public-review-icon.png"
                                        alt="Public review icon"
                                        class="my_lessons_tutor_profile_send_message_details_post_review_step1_option_icon_image">
                                </div>
                                <div class="my_lessons_tutor_profile_send_message_details_post_review_step1_option_text">
                                    Public Review
                                </div>
                            </div>

                            <div class="my_lessons_tutor_profile_send_message_details_post_review_step1_radio_outer">
                                <div class="my_lessons_tutor_profile_send_message_details_post_review_step1_radio_inner"></div>
                            </div>
                        </div>
                    </label>

                    <!-- Anonymous Feedback -->
                    <label class="my_lessons_tutor_profile_send_message_details_post_review_step1_option_label">
                        <input
                            type="radio"
                            name="my_lessons_tutor_profile_send_message_details_post_review_step1_feedback_type"
                            value="anonymous_feedback"
                            class="my_lessons_tutor_profile_send_message_details_post_review_step1_radio_input">
                        <div
                            class="my_lessons_tutor_profile_send_message_details_post_review_step1_option_card my_lessons_tutor_profile_send_message_details_post_review_step1_option_card_unselected"
                            data-my_lessons_tutor_profile_send_message_details_post_review_step1_option="anonymous_feedback">
                            <div class="my_lessons_tutor_profile_send_message_details_post_review_step1_option_left">
                                <div class="my_lessons_tutor_profile_send_message_details_post_review_step1_option_icon_box">
                                    <img
                                        src="path/to/anonymous-feedback-icon.png"
                                        alt="Anonymous feedback icon"
                                        class="my_lessons_tutor_profile_send_message_details_post_review_step1_option_icon_image">
                                </div>
                                <div class="my_lessons_tutor_profile_send_message_details_post_review_step1_option_text">
                                    Anonymous Feedback
                                </div>
                            </div>

                            <div class="my_lessons_tutor_profile_send_message_details_post_review_step1_radio_outer">
                                <div class="my_lessons_tutor_profile_send_message_details_post_review_step1_radio_inner"></div>
                            </div>
                        </div>
                    </label>
                </div>

                <!-- Continue -->
                <button id="my_lessons_tutor_profile_send_message_details_post_review_step1_continue_button">
                    Continue
                </button>
            </div>

            <!-- STEP 2 CONTENT (INCLUDED) -->
            <?php include 'my_lessons_tutor_profile_send_message_details_post_review_step2.php'; ?>
            <?php include 'my_lessons_tutor_profile_send_message_details_post_review_anonymous_feedback_step2.php'; ?>
            <?php include 'my_lessons_tutor_profile_send_message_details_post_review_anonymous_feedback_step3.php'; ?>
            <?php include 'my_lessons_tutor_profile_send_message_details_post_review_anonymous_feedback_step4.php'; ?>

        </div>

        <!-- STEP 3 CARD (SEPARATE MODAL) -->
        <?php include 'my_lessons_tutor_profile_send_message_details_post_review_step3.php'; ?>
        <?php include 'my_lessons_tutor_profile_send_message_details_post_review_anonymous_feedback_step5.php'; ?>



    </div>

    <!-- ================= STEP 1 JS ONLY ================= -->
    <script>
        var my_lessons_tutor_profile_send_message_details_post_review_step1_selected_option = null;

        function my_lessons_tutor_profile_send_message_details_post_review_step1_update_option_styles() {
            $(".my_lessons_tutor_profile_send_message_details_post_review_step1_option_card")
                .removeClass("my_lessons_tutor_profile_send_message_details_post_review_step1_option_card_selected")
                .addClass("my_lessons_tutor_profile_send_message_details_post_review_step1_option_card_unselected");

            $(".my_lessons_tutor_profile_send_message_details_post_review_step1_radio_outer")
                .removeClass("my_lessons_tutor_profile_send_message_details_post_review_step1_radio_outer_selected");

            $(".my_lessons_tutor_profile_send_message_details_post_review_step1_radio_inner")
                .removeClass("my_lessons_tutor_profile_send_message_details_post_review_step1_radio_inner_selected");

            if (!my_lessons_tutor_profile_send_message_details_post_review_step1_selected_option) {
                return;
            }

            var activeCard = $(
                '.my_lessons_tutor_profile_send_message_details_post_review_step1_option_card[data-my_lessons_tutor_profile_send_message_details_post_review_step1_option="' +
                my_lessons_tutor_profile_send_message_details_post_review_step1_selected_option +
                '"]'
            );

            activeCard
                .removeClass("my_lessons_tutor_profile_send_message_details_post_review_step1_option_card_unselected")
                .addClass("my_lessons_tutor_profile_send_message_details_post_review_step1_option_card_selected");

            activeCard.find(".my_lessons_tutor_profile_send_message_details_post_review_step1_radio_outer")
                .addClass("my_lessons_tutor_profile_send_message_details_post_review_step1_radio_outer_selected");

            activeCard.find(".my_lessons_tutor_profile_send_message_details_post_review_step1_radio_inner")
                .addClass("my_lessons_tutor_profile_send_message_details_post_review_step1_radio_inner_selected");
        }

        $(function() {
            /* MODAL OPEN/CLOSE */
            $("#my_lessons_tutor_profile_send_message_details_post_review_step1_open_modal_button").on("click", function() {
                $("#my_lessons_tutor_profile_send_message_details_post_review_step1_modal_overlay").css("display", "flex");

                // reset to step1 view
                $("#my_lessons_tutor_profile_send_message_details_post_review_step1_wrapper").show();
                $("#my_lessons_tutor_profile_send_message_details_post_review_step2_wrapper").hide();
                $("#my_lessons_tutor_profile_send_message_details_post_review_anonymous_feedback_step2_wrapper").hide(); // ✅ add this

                $("#my_lessons_tutor_profile_send_message_details_post_review_step1_step1_step2_card").show();
                $("#my_lessons_tutor_profile_send_message_details_post_review_step3_card").hide();
            });

            $("#my_lessons_tutor_profile_send_message_details_post_review_step1_modal_close_button").on("click", function() {
                $("#my_lessons_tutor_profile_send_message_details_post_review_step1_modal_overlay").css("display", "none");
            });

            $("#my_lessons_tutor_profile_send_message_details_post_review_step1_modal_overlay").on("click", function(e) {
                if (e.target === this) {
                    $("#my_lessons_tutor_profile_send_message_details_post_review_step1_modal_overlay").css("display", "none");
                }
            });

            /* STEP1 option click */
            $(".my_lessons_tutor_profile_send_message_details_post_review_step1_option_card").on("click", function() {
                var newOption = $(this).data(
                    "my_lessons_tutor_profile_send_message_details_post_review_step1_option"
                );

                my_lessons_tutor_profile_send_message_details_post_review_step1_selected_option = newOption;

                $("input[name='my_lessons_tutor_profile_send_message_details_post_review_step1_feedback_type']").prop("checked", false);

                $("input[name='my_lessons_tutor_profile_send_message_details_post_review_step1_feedback_type'][value='" +
                    my_lessons_tutor_profile_send_message_details_post_review_step1_selected_option +
                    "']").prop("checked", true);

                my_lessons_tutor_profile_send_message_details_post_review_step1_update_option_styles();
            });

            /* CONTINUE → show STEP2 */
            $("#my_lessons_tutor_profile_send_message_details_post_review_step1_continue_button").on("click", function() {

                if (my_lessons_tutor_profile_send_message_details_post_review_step1_selected_option === "anonymous_feedback") {
                    $("#my_lessons_tutor_profile_send_message_details_post_review_step1_wrapper").hide();
                    $("#my_lessons_tutor_profile_send_message_details_post_review_step2_wrapper").hide();
                    $("#my_lessons_tutor_profile_send_message_details_post_review_anonymous_feedback_step2_wrapper").show();

                    return;
                }

                // default (public review step2)
                $("#my_lessons_tutor_profile_send_message_details_post_review_step1_wrapper").hide();
                $("#my_lessons_tutor_profile_send_message_details_post_review_anonymous_feedback_step2_wrapper").hide();
                $("#my_lessons_tutor_profile_send_message_details_post_review_anonymous_feedback_step3_wrapper").hide();

                $("#my_lessons_tutor_profile_send_message_details_post_review_step2_wrapper").show();
            });



        });
    </script>
</body>

</html>