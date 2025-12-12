<!-- ANONYMOUS FEEDBACK STEP 4 WRAPPER -->
<div id="my_lessons_tutor_profile_send_message_details_post_review_anonymous_feedback_step4_wrapper">

    <!-- Back arrow -->
    <button
        id="my_lessons_tutor_profile_send_message_details_post_review_anonymous_feedback_step4_back_button"
        aria-label="Back">
        ←
    </button>

    <!-- Avatar -->
    <div class="my_lessons_tutor_profile_send_message_details_post_review_anonymous_feedback_step4_avatar_wrapper">
        <img
            src="path/to/tutor-avatar.jpg"
            alt="Tutor avatar"
            class="my_lessons_tutor_profile_send_message_details_post_review_anonymous_feedback_step4_avatar">
    </div>

    <!-- Title -->
    <h1 class="my_lessons_tutor_profile_send_message_details_post_review_anonymous_feedback_step4_title">
        Please write down your review<br>for Daniela Canelon?
    </h1>

    <!-- Subtitle -->
    <p class="my_lessons_tutor_profile_send_message_details_post_review_anonymous_feedback_step4_subtitle">
        This rating is anonymous
    </p>

    <!-- Textarea -->
    <textarea
        id="my_lessons_tutor_profile_send_message_details_post_review_anonymous_feedback_step4_textarea"
        placeholder="Write your feedback...">exellent teacher</textarea>

    <!-- Done button -->
    <button id="my_lessons_tutor_profile_send_message_details_post_review_anonymous_feedback_step4_done_button">
        Done
    </button>

</div>

<!-- STEP 4 CSS -->
<style>
    #my_lessons_tutor_profile_send_message_details_post_review_anonymous_feedback_step4_wrapper {
        display: none;
        position: relative;
        padding-top: 10px;
        min-height: 480px;
    }

    /* Back arrow aligned with close X line */
    #my_lessons_tutor_profile_send_message_details_post_review_anonymous_feedback_step4_back_button {
        position: absolute;
        top: -52px;
        left: -12px;
        background: transparent;
        border: none;
        font-size: 28px;
        cursor: pointer;
        padding: 0;
        line-height: 1;
        color: #111827;
        transition: transform 0.1s ease, opacity 0.15s ease;
    }

    #my_lessons_tutor_profile_send_message_details_post_review_anonymous_feedback_step4_back_button:hover {
        transform: translateY(-1px);
        opacity: 0.85;
    }

    .my_lessons_tutor_profile_send_message_details_post_review_anonymous_feedback_step4_avatar_wrapper {
        margin-top: 12px;
        margin-bottom: 10px;
    }

    .my_lessons_tutor_profile_send_message_details_post_review_anonymous_feedback_step4_avatar {
        width: 44px;
        height: 44px;
        border-radius: 10px;
        object-fit: cover;
        display: block;
        background: #f9fafb;
    }

    .my_lessons_tutor_profile_send_message_details_post_review_anonymous_feedback_step4_title {
        font-size: 27px;
        font-weight: 700;
        color: #111827;
        margin: 10px 0 8px 0;
        line-height: 1.2;
    }

    .my_lessons_tutor_profile_send_message_details_post_review_anonymous_feedback_step4_subtitle {
        margin: 0 0 18px 0;
        color: #6b7280;
        font-size: 16px;
    }

    #my_lessons_tutor_profile_send_message_details_post_review_anonymous_feedback_step4_textarea {
        width: 100%;
        height: 120px;
        padding: 16px;
        border-radius: 5px;
        border: 2px solid #e5e7eb;
        box-sizing: border-box;
        font-size: 15px;
        resize: none;
        outline: none;
        background: #ffffff;
    }

    #my_lessons_tutor_profile_send_message_details_post_review_anonymous_feedback_step4_textarea:focus {
        border-color: #d1d5db;
    }

    /* Done button */
    #my_lessons_tutor_profile_send_message_details_post_review_anonymous_feedback_step4_done_button {
        width: 100%;
        position: absolute;
        left: 0;
        bottom: 0;
        padding: 10px 16px;
        border-radius: 5px;
        border: 2px solid #111827;
        background: #ff4013;
        color: #ffffff;
        font-weight: 700;
        font-size: 16px;
        cursor: pointer;
        box-shadow: none;
        transition: background-color 0.15s ease, transform 0.1s ease;
    }

    #my_lessons_tutor_profile_send_message_details_post_review_anonymous_feedback_step4_done_button:hover {
        background: #ff5b2a;
        transform: translateY(-1px);
    }
</style>

<!-- STEP 4 JS -->
<script>
    $(function() {

        /* Back → Step 3 */
        $("#my_lessons_tutor_profile_send_message_details_post_review_anonymous_feedback_step4_back_button").on("click", function() {
            $("#my_lessons_tutor_profile_send_message_details_post_review_anonymous_feedback_step4_wrapper").hide();
            $("#my_lessons_tutor_profile_send_message_details_post_review_anonymous_feedback_step3_wrapper").show();
        });

        /* ✅ Done → Step 5 (IMPORTANT FIX) */
        $("#my_lessons_tutor_profile_send_message_details_post_review_anonymous_feedback_step4_done_button").on("click", function() {

            // optional: capture textarea text
            var my_lessons_tutor_profile_send_message_details_post_review_anonymous_feedback_step4_text =
                $("#my_lessons_tutor_profile_send_message_details_post_review_anonymous_feedback_step4_textarea").val();

            console.log("Anonymous Step4 text:", my_lessons_tutor_profile_send_message_details_post_review_anonymous_feedback_step4_text);

            // Hide step4 and hide the main card (step1/2 + earlier wrappers)
            $("#my_lessons_tutor_profile_send_message_details_post_review_anonymous_feedback_step4_wrapper").hide();
            $("#my_lessons_tutor_profile_send_message_details_post_review_step1_step1_step2_card").hide();

            // Show step5 (step5 must be OUTSIDE the main card in the overlay)
            $("#my_lessons_tutor_profile_send_message_details_post_review_anonymous_feedback_step5_wrapper").show();
        });

    });
</script>