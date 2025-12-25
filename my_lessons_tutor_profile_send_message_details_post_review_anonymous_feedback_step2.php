<!-- ANONYMOUS FEEDBACK STEP 2 WRAPPER -->
<div id="my_lessons_tutor_profile_send_message_details_post_review_anonymous_feedback_step2_wrapper">

    <!-- Back arrow (top-left) -->
    <button
        id="my_lessons_tutor_profile_send_message_details_post_review_anonymous_feedback_step2_back_button"
        aria-label="Back">
        ←
    </button>

    <!-- Avatar -->
    <div class="my_lessons_tutor_profile_send_message_details_post_review_anonymous_feedback_step2_avatar_wrapper">
        <img
            src="path/to/tutor-avatar.jpg"
            alt="Tutor avatar"
            class="my_lessons_tutor_profile_send_message_details_post_review_anonymous_feedback_step2_avatar">
    </div>

    <!-- Title -->
    <h1 class="my_lessons_tutor_profile_send_message_details_post_review_anonymous_feedback_step2_title">
        How did it go with Daniela<br>Canelon?
    </h1>

    <!-- Subtitle -->
    <p class="my_lessons_tutor_profile_send_message_details_post_review_anonymous_feedback_step2_subtitle">
        This rating is anonymous
    </p>

    <!-- Options -->
    <div class="my_lessons_tutor_profile_send_message_details_post_review_anonymous_feedback_step2_options_grid">

        <!-- Bad -->
        <div
            class="my_lessons_tutor_profile_send_message_details_post_review_anonymous_feedback_step2_option_card"
            data-my_lessons_tutor_profile_send_message_details_post_review_anonymous_feedback_step2_value="bad">

            <div class="my_lessons_tutor_profile_send_message_details_post_review_anonymous_feedback_step2_option_icon_box">
                <!-- icon as image placeholder (update path later) -->
                <img
                    src="path/to/bad-icon.png"
                    alt="Bad icon"
                    class="my_lessons_tutor_profile_send_message_details_post_review_anonymous_feedback_step2_option_icon">
            </div>

            <div class="my_lessons_tutor_profile_send_message_details_post_review_anonymous_feedback_step2_option_text">
                Bad
            </div>
        </div>

        <!-- Okay -->
        <div
            class="my_lessons_tutor_profile_send_message_details_post_review_anonymous_feedback_step2_option_card"
            data-my_lessons_tutor_profile_send_message_details_post_review_anonymous_feedback_step2_value="okay">

            <div class="my_lessons_tutor_profile_send_message_details_post_review_anonymous_feedback_step2_option_icon_box">
                <img
                    src="path/to/okay-icon.png"
                    alt="Okay icon"
                    class="my_lessons_tutor_profile_send_message_details_post_review_anonymous_feedback_step2_option_icon">
            </div>

            <div class="my_lessons_tutor_profile_send_message_details_post_review_anonymous_feedback_step2_option_text">
                Okay
            </div>
        </div>

        <!-- Great -->
        <div
            class="my_lessons_tutor_profile_send_message_details_post_review_anonymous_feedback_step2_option_card"
            data-my_lessons_tutor_profile_send_message_details_post_review_anonymous_feedback_step2_value="great">

            <div class="my_lessons_tutor_profile_send_message_details_post_review_anonymous_feedback_step2_option_icon_box">
                <img
                    src="path/to/great-icon.png"
                    alt="Great icon"
                    class="my_lessons_tutor_profile_send_message_details_post_review_anonymous_feedback_step2_option_icon">
            </div>

            <div class="my_lessons_tutor_profile_send_message_details_post_review_anonymous_feedback_step2_option_text">
                Great
            </div>
        </div>

    </div>

    <!-- hidden value holder (for later) -->
    <input
        type="hidden"
        id="my_lessons_tutor_profile_send_message_details_post_review_anonymous_feedback_step2_selected_value"
        value="">

</div>

<!-- ANONYMOUS FEEDBACK STEP 2 CSS -->
<style>
    #my_lessons_tutor_profile_send_message_details_post_review_anonymous_feedback_step2_wrapper {
        display: none;
        /* only show after step1 anonymous -> continue */
    }

    /* Back arrow same top line as X */
    #my_lessons_tutor_profile_send_message_details_post_review_anonymous_feedback_step2_back_button {
        position: absolute;
        top: 8px;
        left: 20px;
        background: transparent;
        border: none;
        font-size: 28px;
        cursor: pointer;
        padding: 0;
        line-height: 1;
        color: #111827;
    }

    .my_lessons_tutor_profile_send_message_details_post_review_anonymous_feedback_step2_avatar_wrapper {
        margin-top: 12px;
        margin-bottom: 10px;
    }

    .my_lessons_tutor_profile_send_message_details_post_review_anonymous_feedback_step2_avatar {
        width: 44px;
        height: 44px;
        border-radius: 10px;
        object-fit: cover;
        display: block;
        background: #f9fafb;
    }

    .my_lessons_tutor_profile_send_message_details_post_review_anonymous_feedback_step2_title {
        font-size: 28px;
        line-height: 1.25;
        font-weight: 700;
        color: #111827;
        margin: 10px 0 8px 0;
    }

    .my_lessons_tutor_profile_send_message_details_post_review_anonymous_feedback_step2_subtitle {
        margin: 0 0 22px 0;
        color: #6b7280;
        font-size: 15px;
    }

    .my_lessons_tutor_profile_send_message_details_post_review_anonymous_feedback_step2_options_grid {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 14px;
        margin-top: 10px;
    }

    .my_lessons_tutor_profile_send_message_details_post_review_anonymous_feedback_step2_option_card {
        border: 2px solid #e5e7eb;
        border-radius: 8px;
        padding: 18px 14px;
        cursor: pointer;
        background: #ffffff;
        min-height: 110px;
        box-sizing: border-box;
        display: flex;
        flex-direction: column;
        justify-content: flex-start;
        transition: border-color 0.15s ease, transform 0.1s ease;
    }

    .my_lessons_tutor_profile_send_message_details_post_review_anonymous_feedback_step2_option_card:hover {
        transform: translateY(-1px);
    }

    .my_lessons_tutor_profile_send_message_details_post_review_anonymous_feedback_step2_option_card_selected {
        border-color: #111827;
    }

    .my_lessons_tutor_profile_send_message_details_post_review_anonymous_feedback_step2_option_icon_box {
        width: 34px;
        height: 34px;
        display: flex;
        align-items: center;
        justify-content: center;
        margin-bottom: 14px;
    }

    .my_lessons_tutor_profile_send_message_details_post_review_anonymous_feedback_step2_option_icon {
        width: 28px;
        height: 28px;
        object-fit: contain;
        display: block;
    }

    .my_lessons_tutor_profile_send_message_details_post_review_anonymous_feedback_step2_option_text {
        font-size: 18px;
        font-weight: 700;
        color: #111827;
    }

    @media (max-width: 520px) {
        .my_lessons_tutor_profile_send_message_details_post_review_anonymous_feedback_step2_options_grid {
            grid-template-columns: 1fr;
        }
    }
</style>

<!-- ANONYMOUS FEEDBACK STEP 2 JS -->
<script>
    var my_lessons_tutor_profile_send_message_details_post_review_anonymous_feedback_step2_selected = "";

    $(function() {

        /* Select Bad/Okay/Great */
        $(".my_lessons_tutor_profile_send_message_details_post_review_anonymous_feedback_step2_option_card")
            .on("click", function() {

                $(".my_lessons_tutor_profile_send_message_details_post_review_anonymous_feedback_step2_option_card")
                    .removeClass("my_lessons_tutor_profile_send_message_details_post_review_anonymous_feedback_step2_option_card_selected");

                $(this).addClass("my_lessons_tutor_profile_send_message_details_post_review_anonymous_feedback_step2_option_card_selected");

                my_lessons_tutor_profile_send_message_details_post_review_anonymous_feedback_step2_selected =
                    $(this).data("my_lessons_tutor_profile_send_message_details_post_review_anonymous_feedback_step2_value");

                $("#my_lessons_tutor_profile_send_message_details_post_review_anonymous_feedback_step2_selected_value")
                    .val(my_lessons_tutor_profile_send_message_details_post_review_anonymous_feedback_step2_selected);

                // ✅ OPEN STEP 3
                $("#my_lessons_tutor_profile_send_message_details_post_review_anonymous_feedback_step2_wrapper").hide();
                $("#my_lessons_tutor_profile_send_message_details_post_review_anonymous_feedback_step3_wrapper").show();
            });

    });
</script>