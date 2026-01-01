<!-- ANONYMOUS FEEDBACK STEP 5 (THANK YOU) -->
<div
    class="my_lessons_tutor_profile_send_message_details_post_review_anonymous_feedback_step5_card"
    id="my_lessons_tutor_profile_send_message_details_post_review_anonymous_feedback_step5_wrapper"
    style="display:none;">

    <!-- Close button -->
    <button
        id="my_lessons_tutor_profile_send_message_details_post_review_anonymous_feedback_step5_close_button"
        aria-label="Close">
        &times;
    </button>

    <!-- Centered stacked logo + avatar -->
    <div class="my_lessons_tutor_profile_send_message_details_post_review_anonymous_feedback_step5_avatar_stack">

        <div class="my_lessons_tutor_profile_send_message_details_post_review_anonymous_feedback_step5_logo_wrapper">
            <img
                src="./img/images/platform-logo.svg"
                alt="Logo"
                class="my_lessons_tutor_profile_send_message_details_post_review_anonymous_feedback_step5_logo_image">
        </div>

        <div class="my_lessons_tutor_profile_send_message_details_post_review_anonymous_feedback_step5_user_wrapper">
            <img
                src="./img/images/teacher.jpg"
                alt="Tutor"
                class="my_lessons_tutor_profile_send_message_details_post_review_anonymous_feedback_step5_user_image">
        </div>

    </div>

    <!-- Message -->
    <h2 class="my_lessons_tutor_profile_send_message_details_post_review_anonymous_feedback_step5_title">
        Great! Thankyou For proving<br>your feedback
    </h2>

    <!-- Done button -->
    <button id="my_lessons_tutor_profile_send_message_details_post_review_anonymous_feedback_step5_done_button">
        Done
    </button>
</div>

<!-- STEP 5 CSS -->
<style>
    .my_lessons_tutor_profile_send_message_details_post_review_anonymous_feedback_step5_card {
        background: #ffffff;
        border-radius: 5px;
        max-width: 520px;
        width: 100%;
        min-height: 320px;
        box-shadow: 0 24px 70px rgba(15, 23, 42, 0.25);
        padding: 60px 32px 26px;
        position: relative;
        box-sizing: border-box;
        margin: 0 16px;
    }

    /* Close button */
    #my_lessons_tutor_profile_send_message_details_post_review_anonymous_feedback_step5_close_button {
        position: absolute;
        top: 18px;
        right: 20px;
        border: none;
        background: transparent;
        font-size: 28px;
        color: #111827;
        cursor: pointer;
        line-height: 1;
        transition: transform 0.1s ease, opacity 0.15s ease;
    }

    #my_lessons_tutor_profile_send_message_details_post_review_anonymous_feedback_step5_close_button:hover {
        transform: translateY(-1px);
        opacity: 0.85;
    }

    /* Avatar stack */
    .my_lessons_tutor_profile_send_message_details_post_review_anonymous_feedback_step5_avatar_stack {
        position: relative;
        width: 120px;
        height: 90px;
        margin: 0 auto 26px auto;
    }

    .my_lessons_tutor_profile_send_message_details_post_review_anonymous_feedback_step5_logo_wrapper {
        position: absolute;
        left: 0;
        top: 14px;
        width: 76px;
        height: 56px;
        border-radius: 10px;
        background: #ffffff;
        display: flex;
        align-items: center;
        justify-content: center;
        box-shadow: 0 12px 30px rgba(15, 23, 42, 0.12);
    }

    .my_lessons_tutor_profile_send_message_details_post_review_anonymous_feedback_step5_logo_image {
        width: 58px;
        height: 40px;
        object-fit: contain;
        display: block;
    }

    .my_lessons_tutor_profile_send_message_details_post_review_anonymous_feedback_step5_user_wrapper {
        position: absolute;
        right: 0;
        top: 0;
        transform: rotate(-6deg);
        width: 60px;
        height: 60px;
        border-radius: 10px;
        overflow: hidden;
        box-shadow: 0 12px 30px rgba(0, 0, 0, 0.18);
        background: #fff;
    }

    .my_lessons_tutor_profile_send_message_details_post_review_anonymous_feedback_step5_user_image {
        width: 100%;
        height: 100%;
        object-fit: cover;
        display: block;
    }

    .my_lessons_tutor_profile_send_message_details_post_review_anonymous_feedback_step5_title {
        text-align: center;
        font-size: 28px;
        line-height: 1.2;
        font-weight: 700;
        color: #111827;
        margin: 0 0 28px 0;
    }

    #my_lessons_tutor_profile_send_message_details_post_review_anonymous_feedback_step5_done_button {
        display: block;
        width: 100%;
        padding: 10px 16px;
        border-radius: 5px;
        border: 2px solid #111827;
        background: #ff4013;
        color: #ffffff;
        font-size: 16px;
        font-weight: 700;
        cursor: pointer;
        transition: background-color 0.15s ease, transform 0.1s ease;
    }

    #my_lessons_tutor_profile_send_message_details_post_review_anonymous_feedback_step5_done_button:hover {
        background: #ff5b2a;
        transform: translateY(-1px);
    }
</style>

<!-- STEP 5 JS -->
<script>
    function my_lessons_tutor_profile_send_message_details_post_review_anonymous_feedback_step5_close_all() {

        // Hide step5
        $("#my_lessons_tutor_profile_send_message_details_post_review_anonymous_feedback_step5_wrapper").hide();

        // Hide overlay
        $("#my_lessons_tutor_profile_send_message_details_post_review_step1_modal_overlay").css("display", "none");

        // Reset main card and wrappers
        $("#my_lessons_tutor_profile_send_message_details_post_review_step1_step1_step2_card").show();

        $("#my_lessons_tutor_profile_send_message_details_post_review_step1_wrapper").show();
        $("#my_lessons_tutor_profile_send_message_details_post_review_step2_wrapper").hide();

        $("#my_lessons_tutor_profile_send_message_details_post_review_anonymous_feedback_step2_wrapper").hide();
        $("#my_lessons_tutor_profile_send_message_details_post_review_anonymous_feedback_step3_wrapper").hide();
        $("#my_lessons_tutor_profile_send_message_details_post_review_anonymous_feedback_step4_wrapper").hide();

        // Hide old thank-you card if exists
        $("#my_lessons_tutor_profile_send_message_details_post_review_step3_card").hide();
    }

    $(function() {
        $("#my_lessons_tutor_profile_send_message_details_post_review_anonymous_feedback_step5_done_button").on("click", function() {
            my_lessons_tutor_profile_send_message_details_post_review_anonymous_feedback_step5_close_all();
        });

        $("#my_lessons_tutor_profile_send_message_details_post_review_anonymous_feedback_step5_close_button").on("click", function() {
            my_lessons_tutor_profile_send_message_details_post_review_anonymous_feedback_step5_close_all();
        });
    });
</script>