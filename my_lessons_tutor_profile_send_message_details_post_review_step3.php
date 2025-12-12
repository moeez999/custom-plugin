<!-- STEP 3 CARD: separate modal look -->
<div class="my_lessons_tutor_profile_send_message_details_post_review_step3_card"
     id="my_lessons_tutor_profile_send_message_details_post_review_step3_card"
     style="display:none;">

    <!-- Close button -->
    <button
        id="my_lessons_tutor_profile_send_message_details_post_review_step3_close_button"
        aria-label="Close">
        &times;
    </button>

    <!-- Centered stacked avatars/logo -->
    <div class="my_lessons_tutor_profile_send_message_details_post_review_step3_avatar_stack">
        <div class="my_lessons_tutor_profile_send_message_details_post_review_step3_avatar_logo_wrapper">
            <img src="path/to/platform-logo.png"
                 alt="Logo"
                 class="my_lessons_tutor_profile_send_message_details_post_review_step3_avatar_logo">
        </div>
        <div class="my_lessons_tutor_profile_send_message_details_post_review_step3_avatar_user_wrapper">
            <img src="path/to/tutor-avatar.jpg"
                 alt="Tutor"
                 class="my_lessons_tutor_profile_send_message_details_post_review_step3_avatar_user">
        </div>
    </div>

    <!-- Message -->
    <h2 class="my_lessons_tutor_profile_send_message_details_post_review_step3_title">
        Great! Thank you for proving your feedback
    </h2>

    <!-- Done button -->
    <button id="my_lessons_tutor_profile_send_message_details_post_review_step3_done_button">
        Done
    </button>
</div>

<!-- STEP 3 CSS -->
<style>
    .my_lessons_tutor_profile_send_message_details_post_review_step3_card {
        background: #ffffff;
        border-radius: 5px;
        max-width: 500px;
        width: 100%;
        min-height: 260px;
        box-shadow: 0 24px 70px rgba(15, 23, 42, 0.25);
        padding: 60px 32px 26px;
        position: relative;
        box-sizing: border-box;
        margin: 0 16px;
    }
    
    /* close button */
    #my_lessons_tutor_profile_send_message_details_post_review_step3_close_button {
        position: absolute;
        top: 5px;
        right: 20px;
        border: none;
        background: transparent;
        font-size: 30px;
        color: #9ca3af;
        cursor: pointer;
    }

    #my_lessons_tutor_profile_send_message_details_post_review_step3_close_button:hover {
        color: #4b5563;
    }

    /* avatar stack */
    .my_lessons_tutor_profile_send_message_details_post_review_step3_avatar_stack {
        position: relative;
        width: 90px;
        height: 90px;
        margin: 0 auto 24px auto;
    }

    .my_lessons_tutor_profile_send_message_details_post_review_step3_avatar_logo_wrapper {
        position: absolute;
        inset: 0;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .my_lessons_tutor_profile_send_message_details_post_review_step3_avatar_logo {
        width: 70px;
        height: 70px;
        border-radius: 14px;
        box-shadow: 0 12px 30px rgba(15, 23, 42, 0.15);
        object-fit: cover;
    }

    .my_lessons_tutor_profile_send_message_details_post_review_step3_avatar_user_wrapper {
        position: absolute;
        top: 35px;
        left: 40px;
        transform: rotate(-6deg);
    }

    .my_lessons_tutor_profile_send_message_details_post_review_step3_avatar_user {
        width: 54px;
        height: 54px;
        border-radius: 10px;
        object-fit: cover;
        box-shadow: 0 10px 25px rgba(0, 0, 0, 0.2);
    }

    .my_lessons_tutor_profile_send_message_details_post_review_step3_title {
        text-align: center;
        font-size: 26px;
        line-height: 1.3;
        font-weight: 700;
        color: #111827;
        margin: 0 0 28px 0;
    }

    #my_lessons_tutor_profile_send_message_details_post_review_step3_done_button {
        display: block;
        width: 100%;
        padding: 10px;
        border-radius: 5px;
        border: 2px solid #111827;
        background: #ff4013;
        color: #ffffff;
        font-size: 16px;
        font-weight: 600;
        cursor: pointer;
    }
</style>

<!-- STEP 3 JS -->
<script>
    $(function () {
        function my_lessons_tutor_profile_send_message_details_post_review_step3_close_all() {
            // Hide overlay and reset view back to step1 card for next time
            $("#my_lessons_tutor_profile_send_message_details_post_review_step1_modal_overlay").css("display", "none");

            $("#my_lessons_tutor_profile_send_message_details_post_review_step3_card").hide();
            $("#my_lessons_tutor_profile_send_message_details_post_review_step1_step1_step2_card").show();
            $("#my_lessons_tutor_profile_send_message_details_post_review_step1_wrapper").show();
            $("#my_lessons_tutor_profile_send_message_details_post_review_step2_wrapper").hide();
        }

        $("#my_lessons_tutor_profile_send_message_details_post_review_step3_done_button").on("click", function () {
            my_lessons_tutor_profile_send_message_details_post_review_step3_close_all();
        });

        $("#my_lessons_tutor_profile_send_message_details_post_review_step3_close_button").on("click", function () {
            my_lessons_tutor_profile_send_message_details_post_review_step3_close_all();
        });
    });
</script>
