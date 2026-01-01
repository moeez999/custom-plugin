<!-- STEP 2 WRAPPER -->
<div id="my_lessons_tutor_profile_send_message_details_post_review_step2_wrapper">

    <!-- Back button -->
    <button id="my_lessons_tutor_profile_send_message_details_post_review_step2_back_button">
        <div class="back-arrow">
            <img src="./img/arrow-back.svg">
        </div>
    </button>

    <!-- Avatar -->
    <div class="my_lessons_tutor_profile_send_message_details_post_review_step2_avatar_wrapper">
        <img
            src="./img/images/teacher.jpg"
            alt="Tutor avatar"
            class="my_lessons_tutor_profile_send_message_details_post_review_step2_avatar">
    </div>

    <!-- Title -->
    <h1 class="my_lessons_tutor_profile_send_message_details_post_review_step2_title">
        Please write down your review for Daniela Canelon?
    </h1>

    <!-- Subtitle -->
    <p class="my_lessons_tutor_profile_send_message_details_post_review_step2_subtitle">
        Help other students choose the right tutor
    </p>

    <!-- Stars -->
    <div class="my_lessons_tutor_profile_send_message_details_post_review_step2_stars">
        <span class="my_lessons_tutor_profile_send_message_details_post_review_step2_star" data-star="1">☆</span>
        <span class="my_lessons_tutor_profile_send_message_details_post_review_step2_star" data-star="2">☆</span>
        <span class="my_lessons_tutor_profile_send_message_details_post_review_step2_star" data-star="3">☆</span>
        <span class="my_lessons_tutor_profile_send_message_details_post_review_step2_star" data-star="4">☆</span>
        <span class="my_lessons_tutor_profile_send_message_details_post_review_step2_star" data-star="5">☆</span>
    </div>

    <!-- Textarea -->
    <textarea
        id="my_lessons_tutor_profile_send_message_details_post_review_step2_textarea"
        placeholder="Write your review here..."></textarea>

    <!-- Post Review Button -->
    <button id="my_lessons_tutor_profile_send_message_details_post_review_step2_submit_button">
        Post review
    </button>

</div>

<!-- STEP 2 CSS -->
<style>
    #my_lessons_tutor_profile_send_message_details_post_review_step2_wrapper {
        display: none;
        /* hidden until step1 continues */
    }

    /* Back arrow aligned with close icon (top-left) */
    #my_lessons_tutor_profile_send_message_details_post_review_step2_back_button {
        position: absolute;
        top: 18px;
        left: 20px;
        background: none;
        border: none;
        font-size: 24px;
        cursor: pointer;
        padding: 0;
        line-height: 1;
    }

    .my_lessons_tutor_profile_send_message_details_post_review_step2_avatar_wrapper {
        margin-bottom: 10px;
    }

    .my_lessons_tutor_profile_send_message_details_post_review_step2_avatar {
        width: 44px;
        height: 44px;
        border-radius: 10px;
        object-fit: cover;
        display: block;
        background: #f9fafb;
    }

    .my_lessons_tutor_profile_send_message_details_post_review_step2_title {
        font-size: 28px;
        font-weight: 700;
        color: #111827;
        margin: 10px 0 0 0;
        line-height: 1.3;
    }

    .my_lessons_tutor_profile_send_message_details_post_review_step2_subtitle {
        margin-top: 6px;
        color: #6b7280;
        font-size: 15px;
    }

    .my_lessons_tutor_profile_send_message_details_post_review_step2_stars {
        font-size: 36px;
        margin: 18px 0;
        cursor: pointer;
        display: flex;
        gap: 14px;
        color: #4b5563;
    }

    .my_lessons_tutor_profile_send_message_details_post_review_step2_star {
        user-select: none;
    }

    #my_lessons_tutor_profile_send_message_details_post_review_step2_textarea {
        width: 100%;
        height: 130px;
        padding: 16px;
        border-radius: 8px;
        border: 1px solid #e5e7eb;
        box-sizing: border-box;
        font-size: 15px;
        resize: vertical;
    }

    #my_lessons_tutor_profile_send_message_details_post_review_step2_submit_button {
        width: 100%;
        margin-top: 20px;
        padding: 10px;
        border-radius: 5px;
        border: 2px solid #111827;
        background: #ff4013;
        color: #ffffff;
        font-size: 16px;
        font-weight: 600;
        cursor: pointer;
        transition: background-color 0.15s ease, transform 0.1s ease;
        /* same as step1 */
    }

    /* Hover effect same as step1 button */
    #my_lessons_tutor_profile_send_message_details_post_review_step2_submit_button:hover {
        background: #ff5b2a;
        transform: translateY(-1px);
    }
</style>

<!-- STEP 2 JS -->
<script>
    var my_lessons_tutor_profile_send_message_details_post_review_step2_rating = 0;

    $(function() {
        /* STAR CLICK */
        $(".my_lessons_tutor_profile_send_message_details_post_review_step2_star").on("click", function() {
            my_lessons_tutor_profile_send_message_details_post_review_step2_rating = $(this).data("star");

            $(".my_lessons_tutor_profile_send_message_details_post_review_step2_star").each(function(index, el) {
                var starNumber = $(el).data("star");
                $(el).text(
                    starNumber <= my_lessons_tutor_profile_send_message_details_post_review_step2_rating ?
                    "★" :
                    "☆"
                );
            });
        });

        /* BACK TO STEP 1 */
        $("#my_lessons_tutor_profile_send_message_details_post_review_step2_back_button").on("click", function() {
            $("#my_lessons_tutor_profile_send_message_details_post_review_step2_wrapper").hide();
            $("#my_lessons_tutor_profile_send_message_details_post_review_step1_wrapper").show();
        });

        /* POST REVIEW → STEP 3 */
        $("#my_lessons_tutor_profile_send_message_details_post_review_step2_submit_button").on("click", function() {
            var reviewText = $("#my_lessons_tutor_profile_send_message_details_post_review_step2_textarea").val();
            console.log(
                "Step2 Rating:",
                my_lessons_tutor_profile_send_message_details_post_review_step2_rating,
                "Review:",
                reviewText
            );

            // Hide step1/2 card and show step3 card
            $("#my_lessons_tutor_profile_send_message_details_post_review_step1_step1_step2_card").hide();
            $("#my_lessons_tutor_profile_send_message_details_post_review_step3_card").show();
        });
    });
</script>