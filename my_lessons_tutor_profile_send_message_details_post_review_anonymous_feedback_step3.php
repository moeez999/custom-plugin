<!-- ANONYMOUS FEEDBACK STEP 3 WRAPPER -->
<div id="my_lessons_tutor_profile_send_message_details_post_review_anonymous_feedback_step3_wrapper">

    <!-- Back arrow (top-left) -->
    <button
        id="my_lessons_tutor_profile_send_message_details_post_review_anonymous_feedback_step3_back_button"
        aria-label="Back">
        ←
    </button>

    <!-- Title -->
    <h1 class="my_lessons_tutor_profile_send_message_details_post_review_anonymous_feedback_step3_title">
        What did Not like in Daniela?
    </h1>

    <!-- Subtitle -->
    <p class="my_lessons_tutor_profile_send_message_details_post_review_anonymous_feedback_step3_subtitle">
        Choose one or more options
    </p>

    <!-- GRID WRAPPER (so we can inject child row position using CSS grid placement) -->
    <div class="my_lessons_tutor_profile_send_message_details_post_review_anonymous_feedback_step3_grid_wrapper">

        <!-- Professional approach (Parent) -->
        <button type="button"
            id="my_lessons_tutor_profile_send_message_details_post_review_anonymous_feedback_step3_chip_professional_approach"
            class="my_lessons_tutor_profile_send_message_details_post_review_anonymous_feedback_step3_chip my_lessons_tutor_profile_send_message_details_post_review_anonymous_feedback_step3_chip_parent"
            data-my_lessons_tutor_profile_send_message_details_post_review_anonymous_feedback_step3_chip="professional_approach">
            <img src="path/to/professional-approach-icon.png" alt=""
                class="my_lessons_tutor_profile_send_message_details_post_review_anonymous_feedback_step3_chip_icon">
            <span>Professional approach</span>
        </button>

        <!-- Lesson delivery -->
        <button type="button"
            class="my_lessons_tutor_profile_send_message_details_post_review_anonymous_feedback_step3_chip"
            data-my_lessons_tutor_profile_send_message_details_post_review_anonymous_feedback_step3_chip="lesson_delivery">
            <img src="path/to/lesson-delivery-icon.png" alt=""
                class="my_lessons_tutor_profile_send_message_details_post_review_anonymous_feedback_step3_chip_icon">
            <span>Lesson delivery</span>
        </button>

        <!-- CHILD ROW (must appear right after Professional approach) -->
        <div
            id="my_lessons_tutor_profile_send_message_details_post_review_anonymous_feedback_step3_professional_children_row"
            class="my_lessons_tutor_profile_send_message_details_post_review_anonymous_feedback_step3_children_row">

            <button type="button"
                class="my_lessons_tutor_profile_send_message_details_post_review_anonymous_feedback_step3_child_chip"
                data-my_lessons_tutor_profile_send_message_details_post_review_anonymous_feedback_step3_child_chip="teaching_method">
                Teaching method
            </button>

            <button type="button"
                class="my_lessons_tutor_profile_send_message_details_post_review_anonymous_feedback_step3_child_chip"
                data-my_lessons_tutor_profile_send_message_details_post_review_anonymous_feedback_step3_child_chip="right_pace">
                Right pace
            </button>

            <button type="button"
                class="my_lessons_tutor_profile_send_message_details_post_review_anonymous_feedback_step3_child_chip"
                data-my_lessons_tutor_profile_send_message_details_post_review_anonymous_feedback_step3_child_chip="good_preparation">
                Good preparation
            </button>

            <button type="button"
                class="my_lessons_tutor_profile_send_message_details_post_review_anonymous_feedback_step3_child_chip"
                data-my_lessons_tutor_profile_send_message_details_post_review_anonymous_feedback_step3_child_chip="on_time">
                On time
            </button>

            <button type="button"
                class="my_lessons_tutor_profile_send_message_details_post_review_anonymous_feedback_step3_child_chip"
                data-my_lessons_tutor_profile_send_message_details_post_review_anonymous_feedback_step3_child_chip="knowledgeable">
                Knowledgeable
            </button>
        </div>

        <!-- Call and classroom -->
        <button type="button"
            class="my_lessons_tutor_profile_send_message_details_post_review_anonymous_feedback_step3_chip"
            data-my_lessons_tutor_profile_send_message_details_post_review_anonymous_feedback_step3_chip="call_and_classroom">
            <img src="path/to/call-and-classroom-icon.png" alt=""
                class="my_lessons_tutor_profile_send_message_details_post_review_anonymous_feedback_step3_chip_icon">
            <span>Call and classroom</span>
        </button>

        <!-- Tutor personality -->
        <button type="button"
            class="my_lessons_tutor_profile_send_message_details_post_review_anonymous_feedback_step3_chip"
            data-my_lessons_tutor_profile_send_message_details_post_review_anonymous_feedback_step3_chip="tutor_personality">
            <img src="path/to/tutor-personality-icon.png" alt=""
                class="my_lessons_tutor_profile_send_message_details_post_review_anonymous_feedback_step3_chip_icon">
            <span>Tutor personality</span>
        </button>

        <!-- Clear communication -->
        <button type="button"
            class="my_lessons_tutor_profile_send_message_details_post_review_anonymous_feedback_step3_chip"
            data-my_lessons_tutor_profile_send_message_details_post_review_anonymous_feedback_step3_chip="clear_communication">
            <img src="path/to/clear-communication-icon.png" alt=""
                class="my_lessons_tutor_profile_send_message_details_post_review_anonymous_feedback_step3_chip_icon">
            <span>Clear communication</span>
        </button>

        <!-- Something else -->
        <button type="button"
            class="my_lessons_tutor_profile_send_message_details_post_review_anonymous_feedback_step3_chip"
            data-my_lessons_tutor_profile_send_message_details_post_review_anonymous_feedback_step3_chip="something_else">
            <img src="path/to/something-else-icon.png" alt=""
                class="my_lessons_tutor_profile_send_message_details_post_review_anonymous_feedback_step3_chip_icon">
            <span>Something else</span>
        </button>

    </div>

    <!-- Hidden selected list -->
    <input
        type="hidden"
        id="my_lessons_tutor_profile_send_message_details_post_review_anonymous_feedback_step3_selected_items"
        value="">

    <!-- Bottom button -->
    <button id="my_lessons_tutor_profile_send_message_details_post_review_anonymous_feedback_step3_submit_button">
        Give Feedback
    </button>

</div>

<!-- ANONYMOUS FEEDBACK STEP 3 CSS -->
<style>
    #my_lessons_tutor_profile_send_message_details_post_review_anonymous_feedback_step3_wrapper {
        display: none;
        position: relative;
        padding-top: 10px;
        min-height: 540px;
    }

    /* Back arrow aligned with close (X) */
    #my_lessons_tutor_profile_send_message_details_post_review_anonymous_feedback_step3_back_button {
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

    #my_lessons_tutor_profile_send_message_details_post_review_anonymous_feedback_step3_back_button:hover {
        transform: translateY(-1px);
        opacity: 0.85;
    }

    .my_lessons_tutor_profile_send_message_details_post_review_anonymous_feedback_step3_title {
        font-size: 28px;
        font-weight: 700;
        color: #111827;
        margin: 0 0 10px 0;
        line-height: 1.2;
    }

    .my_lessons_tutor_profile_send_message_details_post_review_anonymous_feedback_step3_subtitle {
        margin: 0 0 18px 0;
        color: #6b7280;
        font-size: 16px;
    }

    .my_lessons_tutor_profile_send_message_details_post_review_anonymous_feedback_step3_grid_wrapper {
        display: grid;
        grid-template-columns: repeat(2, 1fr);
        gap: 12px;
        margin-top: 10px;
        margin-bottom: 10px;
    }

    /* Parent chips */
    .my_lessons_tutor_profile_send_message_details_post_review_anonymous_feedback_step3_chip {
        width: 100%;
        border: 2px solid #e5e7eb;
        border-radius: 5px;
        background: #ffffff;
        padding: 10px 4px;
        display: flex;
        align-items: center;
        gap: 10px;
        cursor: pointer;
        font-size: 14px;
        font-weight: 500;
        color: #111827;
        box-sizing: border-box;
        justify-content: flex-start;
        text-align: left;
        transition: border-color 0.15s ease, transform 0.1s ease, background-color 0.15s ease;
    }

    .my_lessons_tutor_profile_send_message_details_post_review_anonymous_feedback_step3_chip:hover {
        transform: translateY(-1px);
        background: #f9fafb;
    }

    .my_lessons_tutor_profile_send_message_details_post_review_anonymous_feedback_step3_chip_selected {
        border-color: #111827;
        background: #ffffff;
    }

    .my_lessons_tutor_profile_send_message_details_post_review_anonymous_feedback_step3_chip_icon {
        width: 18px;
        height: 18px;
        object-fit: contain;
        display: block;
    }

    /* CHILD ROW: appears directly after Professional approach (same grid, full width) */
    .my_lessons_tutor_profile_send_message_details_post_review_anonymous_feedback_step3_children_row {
        grid-column: 1 / -1;
        display: none;
        gap: 10px;
        flex-wrap: wrap;
        margin-top: -2px;
        margin-bottom: 6px;
    }

    /* Child chips (light gray background like your snapshot) */
    .my_lessons_tutor_profile_send_message_details_post_review_anonymous_feedback_step3_child_chip {
        border: 2px solid #e5e7eb;
        border-radius: 8px;
        background: #f3f4f6;
        /* ✅ light gray */
        padding: 10px 12px;
        cursor: pointer;
        font-size: 14px;
        font-weight: 500;
        color: #111827;
        transition: border-color 0.15s ease, transform 0.1s ease, background-color 0.15s ease;
    }

    .my_lessons_tutor_profile_send_message_details_post_review_anonymous_feedback_step3_child_chip:hover {
        transform: translateY(-1px);
        background: #e5e7eb;
    }

    .my_lessons_tutor_profile_send_message_details_post_review_anonymous_feedback_step3_child_chip_selected {
        border-color: #111827;
        background: #f3f4f6;
    }

    /* bottom button */
    #my_lessons_tutor_profile_send_message_details_post_review_anonymous_feedback_step3_submit_button {
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

    #my_lessons_tutor_profile_send_message_details_post_review_anonymous_feedback_step3_submit_button:hover {
        background: #ff5b2a;
        transform: translateY(-1px);
    }

    @media (max-width: 520px) {
        .my_lessons_tutor_profile_send_message_details_post_review_anonymous_feedback_step3_grid_wrapper {
            grid-template-columns: 1fr;
        }
    }
</style>

<!-- ANONYMOUS FEEDBACK STEP 3 JS -->
<script>
    var my_lessons_tutor_profile_send_message_details_post_review_anonymous_feedback_step3_selected_items = [];

    function my_lessons_tutor_profile_send_message_details_post_review_anonymous_feedback_step3_sync_hidden_field() {
        $("#my_lessons_tutor_profile_send_message_details_post_review_anonymous_feedback_step3_selected_items")
            .val(my_lessons_tutor_profile_send_message_details_post_review_anonymous_feedback_step3_selected_items.join(","));
    }

    $(function() {

        /* Parent chip multi-select */
        $(".my_lessons_tutor_profile_send_message_details_post_review_anonymous_feedback_step3_chip").on("click", function() {

            var value = $(this).data("my_lessons_tutor_profile_send_message_details_post_review_anonymous_feedback_step3_chip");

            if ($(this).hasClass("my_lessons_tutor_profile_send_message_details_post_review_anonymous_feedback_step3_chip_selected")) {

                $(this).removeClass("my_lessons_tutor_profile_send_message_details_post_review_anonymous_feedback_step3_chip_selected");
                my_lessons_tutor_profile_send_message_details_post_review_anonymous_feedback_step3_selected_items =
                    my_lessons_tutor_profile_send_message_details_post_review_anonymous_feedback_step3_selected_items.filter(function(v) {
                        return v !== value;
                    });

                if (value === "professional_approach") {
                    $("#my_lessons_tutor_profile_send_message_details_post_review_anonymous_feedback_step3_professional_children_row").hide();

                    $(".my_lessons_tutor_profile_send_message_details_post_review_anonymous_feedback_step3_child_chip")
                        .removeClass("my_lessons_tutor_profile_send_message_details_post_review_anonymous_feedback_step3_child_chip_selected");

                    var childrenValues = ["teaching_method", "right_pace", "good_preparation", "on_time", "knowledgeable"];
                    my_lessons_tutor_profile_send_message_details_post_review_anonymous_feedback_step3_selected_items =
                        my_lessons_tutor_profile_send_message_details_post_review_anonymous_feedback_step3_selected_items.filter(function(v) {
                            return childrenValues.indexOf(v) === -1;
                        });
                }

            } else {

                $(this).addClass("my_lessons_tutor_profile_send_message_details_post_review_anonymous_feedback_step3_chip_selected");
                my_lessons_tutor_profile_send_message_details_post_review_anonymous_feedback_step3_selected_items.push(value);

                if (value === "professional_approach") {
                    $("#my_lessons_tutor_profile_send_message_details_post_review_anonymous_feedback_step3_professional_children_row")
                        .css("display", "flex");
                }
            }

            my_lessons_tutor_profile_send_message_details_post_review_anonymous_feedback_step3_sync_hidden_field();
        });

        /* Child chip multi-select */
        $(".my_lessons_tutor_profile_send_message_details_post_review_anonymous_feedback_step3_child_chip").on("click", function() {
            var childValue = $(this).data("my_lessons_tutor_profile_send_message_details_post_review_anonymous_feedback_step3_child_chip");

            if ($(this).hasClass("my_lessons_tutor_profile_send_message_details_post_review_anonymous_feedback_step3_child_chip_selected")) {
                $(this).removeClass("my_lessons_tutor_profile_send_message_details_post_review_anonymous_feedback_step3_child_chip_selected");
                my_lessons_tutor_profile_send_message_details_post_review_anonymous_feedback_step3_selected_items =
                    my_lessons_tutor_profile_send_message_details_post_review_anonymous_feedback_step3_selected_items.filter(function(v) {
                        return v !== childValue;
                    });
            } else {
                $(this).addClass("my_lessons_tutor_profile_send_message_details_post_review_anonymous_feedback_step3_child_chip_selected");
                my_lessons_tutor_profile_send_message_details_post_review_anonymous_feedback_step3_selected_items.push(childValue);
            }

            my_lessons_tutor_profile_send_message_details_post_review_anonymous_feedback_step3_sync_hidden_field();
        });

        /* Back → anonymous step2 */
        $("#my_lessons_tutor_profile_send_message_details_post_review_anonymous_feedback_step3_back_button").on("click", function() {
            $("#my_lessons_tutor_profile_send_message_details_post_review_anonymous_feedback_step3_wrapper").hide();
            $("#my_lessons_tutor_profile_send_message_details_post_review_anonymous_feedback_step2_wrapper").show();
        });

        /* Submit (hook later) */
        $("#my_lessons_tutor_profile_send_message_details_post_review_anonymous_feedback_step3_submit_button").on("click", function() {
            $("#my_lessons_tutor_profile_send_message_details_post_review_anonymous_feedback_step3_wrapper").hide();
            $("#my_lessons_tutor_profile_send_message_details_post_review_anonymous_feedback_step4_wrapper").show();
        });


        
    });
</script>