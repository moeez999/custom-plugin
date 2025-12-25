<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Awesome! What did you like?</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Tailwind CSS CDN -->
    <script src="https://cdn.tailwindcss.com"></script>

    <!-- jQuery CDN -->
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>

    <style>
        body {
            font-family: system-ui, -apple-system, BlinkMacSystemFont,
                "Segoe UI", sans-serif;
        }

        /* Selected chip style (for any selected button) */
        .my_students_details_lessons_plans_step2_chip_selected {
            background-color: #ffffff !important;
            color: #111827 !important;
            border-color: #000000 !important;
            border-width: 2px !important;
        }

        /* Child chips default background (light gray like Figma) */
        .my_students_details_lessons_plans_step2_child_chip {
            background-color: #f4f4f5;
        }

        /* Hover effect for parent buttons (the 6 main chips) */
        .my_students_details_lessons_plans_step2_parent_button:hover {
            background-color: #f4f4f5;
        }
    </style>
</head>

<body class="my_students_details_lessons_plans_step2_body min-h-screen bg-white flex flex-col">

    <!-- Top row: back arrow & skip button -->
    <div
        class="my_students_details_lessons_plans_step2_top_row w-full px-4 md:px-8 pt-4 flex items-center justify-between">
        <!-- Back button (icon only) -->
        <a href="my_students_details_lessons_plans.php"><button
                id="my_students_details_lessons_plans_step2_back_button"
                type="button"
                class="my_students_details_lessons_plans_step2_back_btn inline-flex items-center justify-center w-8 h-8 rounded-[5px] focus:outline-none">
                <img
                    src="img/my_students/back_arrow_icon.svg"
                    alt="Back"
                    class="my_students_details_lessons_plans_step2_back_icon w-4 h-4 object-contain">
            </button>
        </a>
        <div class="my_students_details_lessons_plans_step2_top_spacer flex-1"></div>

        <!-- Skip this step button -->
        <a href="my_students_details_lessons_plans_step2_skip_content.php">
            <button
                id="my_students_details_lessons_plans_step2_skip_button"
                type="button"
                class="my_students_details_lessons_plans_step2_skip_btn text-xs sm:text-sm md:text-base border border-gray-300 bg-white rounded-[5px] px-4 py-1.5 hover:border-gray-400 transition">
                Skip this step
            </button>
        </a>
    </div>

    <!-- Main content -->
    <main class="my_students_details_lessons_plans_step2_main flex-1 flex flex-col items-center px-4 pb-24" style="margin-top: 17%;">
        <div class="my_students_details_lessons_plans_step2_container max-w-3xl w-full text-center">

            <!-- Heading -->
            <h1 class="my_students_details_lessons_plans_step2_heading text-2xl md:text-4xl font-semibold tracking-tight mb-3">
                Awesome! What did you like?
            </h1>

            <!-- Sub text -->
            <p class="my_students_details_lessons_plans_step2_subtitle text-gray-500 text-sm md:text-base">
                Choose one or more options
            </p>

            <!-- Options (initially only 6) -->
            <div
                class="my_students_details_lessons_plans_step2_options_wrapper mt-10 md:mt-12 flex flex-wrap gap-3 md:gap-4 justify-center">

                <!-- Professional approach (parent that expands) -->
                <button
                    id="my_students_details_lessons_plans_step2_professional_parent"
                    type="button"
                    class="my_students_details_lessons_plans_step2_option_button
                           my_students_details_lessons_plans_step2_parent_with_children
                           my_students_details_lessons_plans_step2_parent_button
                           inline-flex items-center gap-2 border border-gray-300 rounded-[5px] px-4 py-2 bg-white
                           text-xs sm:text-sm md:text-base shadow-sm transition"
                    data-option="professional_approach"
                    data-has-children="true">
                    <img
                        src="img/my_students/professional_approach.svg"
                        alt="Professional approach icon"
                        class="my_students_details_lessons_plans_step2_option_icon w-4 h-4 md:w-5 md:h-5 object-contain">
                    <span class="my_students_details_lessons_plans_step2_option_label">
                        Professional approach
                    </span>
                </button>

                <!-- Lesson delivery (parent that expands) -->
                <button
                    id="my_students_details_lessons_plans_step2_lesson_parent"
                    type="button"
                    class="my_students_details_lessons_plans_step2_option_button
                           my_students_details_lessons_plans_step2_parent_with_children
                           my_students_details_lessons_plans_step2_parent_button
                           inline-flex items-center gap-2 border border-gray-300 rounded-[5px] px-4 py-2 bg-white
                           text-xs sm:text-sm md:text-base shadow-sm transition"
                    data-option="lesson_delivery"
                    data-has-children="true">
                    <img
                        src="img/my_students/lesson_delivery.svg"
                        alt="Lesson delivery icon"
                        class="my_students_details_lessons_plans_step2_option_icon w-4 h-4 md:w-5 md:h-5 object-contain">
                    <span class="my_students_details_lessons_plans_step2_option_label">
                        Lesson delivery
                    </span>
                </button>

                <!-- Call and classroom -->
                <button
                    type="button"
                    class="my_students_details_lessons_plans_step2_option_button
                           my_students_details_lessons_plans_step2_parent_button
                           inline-flex items-center gap-2 border border-gray-300 rounded-[5px] px-4 py-2 bg-white
                           text-xs sm:text-sm md:text-base shadow-sm transition"
                    data-option="call_and_classroom">
                    <img
                        src="img/my_students/call_and_classroom.svg"
                        alt="Call and classroom icon"
                        class="my_students_details_lessons_plans_step2_option_icon w-4 h-4 md:w-5 md:h-5 object-contain">
                    <span class="my_students_details_lessons_plans_step2_option_label">
                        Call and classroom
                    </span>
                </button>

                <!-- Tutor personality -->
                <button
                    type="button"
                    class="my_students_details_lessons_plans_step2_option_button
                           my_students_details_lessons_plans_step2_parent_button
                           inline-flex items-center gap-2 border border-gray-300 rounded-[5px] px-4 py-2 bg-white
                           text-xs sm:text-sm md:text-base shadow-sm transition"
                    data-option="tutor_personality">
                    <img
                        src="img/my_students/tutor_personality.svg"
                        alt="Tutor personality icon"
                        class="my_students_details_lessons_plans_step2_option_icon w-4 h-4 md:w-5 md:h-5 object-contain">
                    <span class="my_students_details_lessons_plans_step2_option_label">
                        Tutor personality
                    </span>
                </button>

                <!-- Clear communication -->
                <button
                    type="button"
                    class="my_students_details_lessons_plans_step2_option_button
                           my_students_details_lessons_plans_step2_parent_button
                           inline-flex items-center gap-2 border border-gray-300 rounded-[5px] px-4 py-2 bg-white
                           text-xs sm:text-sm md:text-base shadow-sm transition"
                    data-option="clear_communication">
                    <img
                        src="img/my_students/clear_communication.svg"
                        alt="Clear communication icon"
                        class="my_students_details_lessons_plans_step2_option_icon w-4 h-4 md:w-5 md:h-5 object-contain">
                    <span class="my_students_details_lessons_plans_step2_option_label">
                        Clear communication
                    </span>
                </button>

                <!-- Something else -->
                <button
                    type="button"
                    class="my_students_details_lessons_plans_step2_option_button
                           my_students_details_lessons_plans_step2_parent_button
                           inline-flex items-center gap-2 border border-gray-300 rounded-[5px] px-4 py-2 bg-white
                           text-xs sm:text-sm md:text-base shadow-sm transition"
                    data-option="something_else">
                    <!-- <img
                        src="img/my_students/something_else.svg"
                        alt="Something else icon"
                        class="my_students_details_lessons_plans_step2_option_icon w-4 h-4 md:w-5 md:h-5 object-contain"> -->


                    <span class="my_students_details_lessons_plans_step2_option_label">
                        Something else
                    </span>
                </button>

            </div>

            <!-- "Something else" textarea section (hidden by default) -->
            <div
                id="my_students_details_lessons_plans_step2_something_else_section"
                class="my_students_details_lessons_plans_step2_something_else_section hidden max-w-3xl mx-auto w-full mt-10 text-left">
                <hr class="my_students_details_lessons_plans_step2_something_else_hr border-t border-gray-200 mb-6">
                <label
                    for="my_students_details_lessons_plans_step2_something_else_textarea"
                    class="my_students_details_lessons_plans_step2_something_else_label block text-sm md:text-base font-medium text-gray-800 mb-2">
                    Tell us more about your experience
                </label>
                <div class="my_students_details_lessons_plans_step2_something_else_textarea_wrapper relative">
                    <textarea
                        id="my_students_details_lessons_plans_step2_something_else_textarea"
                        maxlength="1000"
                        class="my_students_details_lessons_plans_step2_something_else_textarea w-full border border-gray-200 rounded-[5px] px-4 py-4 text-sm md:text-base placeholder:text-gray-400 focus:outline-none focus:border-gray-400 resize-none min-h-[140px]"
                        placeholder="Tell us more about your experience"></textarea>
                    <span
                        id="my_students_details_lessons_plans_step2_something_else_counter"
                        class="my_students_details_lessons_plans_step2_something_else_counter absolute bottom-3 right-4 text-xs text-gray-400">
                        0 / 1000
                    </span>
                </div>
            </div>

        </div>
    </main>

    <!-- Submit button fixed near bottom -->
    <div
        class="my_students_details_lessons_plans_step2_submit_container fixed bottom-6 left-0 right-0 flex justify-center px-4">
        <a href="my_students_details_lessons_plans_step3.php" style='width:500px; margin-left:110px;'><button
                id="my_students_details_lessons_plans_step2_submit_button"
                class="my_students_details_lessons_plans_step2_submit_btn w-full max-w-xs md:max-w-sm py-2  bg-[#ff3b00] text-white rounded-[5px] text-base md:text-lg font-semibold shadow-md hover:opacity-95 transition border-[2px] border-black"
                type="button">
                Submit
            </button>
        </a>
    </div>

    <!-- Hidden div to keep Tailwind from purging classes we might add dynamically -->
    <div class="hidden my_students_details_lessons_plans_step2_tailwind_safety bg-black text-white border-black"></div>

    <script>
        // Store selected options
        const my_students_details_lessons_plans_step2_selectedOptions = [];

        // Children config for parents
        const my_students_details_lessons_plans_step2_childrenConfig = {
            professional_approach: [{
                    key: 'teaching_method',
                    label: 'Teaching method'
                },
                {
                    key: 'right_pace',
                    label: 'Right pace'
                },
                {
                    key: 'good_preparation',
                    label: 'Good preparation'
                },
                {
                    key: 'on_time',
                    label: 'On time'
                },
                {
                    key: 'knowledgeable',
                    label: 'Knowledgeable'
                }
            ],
            lesson_delivery: [{
                    key: 'lesson_clarity',
                    label: 'Clarity'
                },
                {
                    key: 'lesson_engagement',
                    label: 'Engagement'
                },
                {
                    key: 'lesson_use_of_resources',
                    label: 'Use of resources'
                },
                {
                    key: 'lesson_pacing',
                    label: 'Pacing'
                },
                {
                    key: 'lesson_student_involvement',
                    label: 'Student involvement'
                }
            ]
        };

        function my_students_details_lessons_plans_step2_toggleOption(optionKey, $button) {
            const idx = my_students_details_lessons_plans_step2_selectedOptions.indexOf(optionKey);

            if (idx === -1) {
                my_students_details_lessons_plans_step2_selectedOptions.push(optionKey);
                $button.addClass('my_students_details_lessons_plans_step2_chip_selected');
                $button.attr('aria-pressed', 'true');
            } else {
                my_students_details_lessons_plans_step2_selectedOptions.splice(idx, 1);
                $button.removeClass('my_students_details_lessons_plans_step2_chip_selected');
                $button.attr('aria-pressed', 'false');
            }
        }

        function my_students_details_lessons_plans_step2_createChildrenForParent($parent, optionKey) {
            if ($parent.data('childrenCreated')) return;

            const config = my_students_details_lessons_plans_step2_childrenConfig[optionKey] || [];
            let $created = $();

            config.forEach(function(child) {
                const $btn = $('<button></button>')
                    .attr('type', 'button')
                    .addClass(
                        'my_students_details_lessons_plans_step2_option_button ' +
                        'my_students_details_lessons_plans_step2_child_chip ' +
                        'inline-flex items-center gap-2 border border-gray-300 rounded-[5px] px-4 py-2 ' +
                        'text-xs sm:text-sm md:text-base shadow-sm transition hidden'
                    )
                    .attr('data-option', child.key)
                    .append(
                        $('<span></span>')
                        .addClass('my_students_details_lessons_plans_step2_option_label')
                        .text(child.label)
                    );

                $created = $created.add($btn);
            });

            // Insert right after parent so layout matches design
            $parent.after($created);
            $parent.data('childrenCreated', true);
            $parent.data('childrenElements', $created);
        }

        $(function() {
            const $wrapper = $('.my_students_details_lessons_plans_step2_options_wrapper');

            // Delegated click handler (works for dynamic children)
            $wrapper.on('click', '.my_students_details_lessons_plans_step2_option_button', function() {
                const $this = $(this);
                const optionKey = $this.data('option');
                const hasChildren = $this.data('has-children') === true || $this.data('has-children') === "true";

                my_students_details_lessons_plans_step2_toggleOption(optionKey, $this);
                const isSelected = $this.hasClass('my_students_details_lessons_plans_step2_chip_selected');

                // Expansion behavior for parents with children
                if (hasChildren && my_students_details_lessons_plans_step2_childrenConfig[optionKey]) {
                    // Ensure children exist
                    my_students_details_lessons_plans_step2_createChildrenForParent($this, optionKey);
                    const $children = $this.data('childrenElements');

                    if (isSelected) {
                        // Show children with light background
                        $children.removeClass('hidden');
                    } else {
                        // Hide children and clear their selections
                        $children.each(function() {
                            const $child = $(this);
                            const childKey = $child.data('option');
                            const idx = my_students_details_lessons_plans_step2_selectedOptions.indexOf(childKey);
                            if (idx !== -1) {
                                my_students_details_lessons_plans_step2_selectedOptions.splice(idx, 1);
                            }
                            $child
                                .addClass('hidden')
                                .removeClass('my_students_details_lessons_plans_step2_chip_selected')
                                .attr('aria-pressed', 'false');
                        });
                    }
                }

                // Show/hide "Something else" textarea section
                if (optionKey === 'something_else') {
                    const $section = $('#my_students_details_lessons_plans_step2_something_else_section');
                    const $textarea = $('#my_students_details_lessons_plans_step2_something_else_textarea');
                    const $counter = $('#my_students_details_lessons_plans_step2_something_else_counter');

                    if (isSelected) {
                        $section.removeClass('hidden');
                    } else {
                        $section.addClass('hidden');
                        $textarea.val('');
                        $counter.text('0 / 1000');
                    }
                }
            });

            // Textarea character counter
            $('#my_students_details_lessons_plans_step2_something_else_textarea').on('input', function() {
                const length = $(this).val().length;
                $('#my_students_details_lessons_plans_step2_something_else_counter')
                    .text(length + ' / 1000');
            });

            $('#my_students_details_lessons_plans_step2_submit_button').on('click', function() {
                console.log('Selected options:',
                    my_students_details_lessons_plans_step2_selectedOptions);
                console.log('Something else text:',
                    $('#my_students_details_lessons_plans_step2_something_else_textarea').val());
            });

            $('#my_students_details_lessons_plans_step2_back_button').on('click', function() {
                console.log('Back clicked');
                // window.history.back(); // enable for real back navigation
            });

            $('#my_students_details_lessons_plans_step2_skip_button').on('click', function() {
                console.log('Skip this step clicked');
                // Add your skip navigation logic here
            });
        });
    </script>

</body>

</html>