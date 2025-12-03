<!-- Tailwind CSS CDN -->
<script src="https://cdn.tailwindcss.com"></script>

<!-- jQuery CDN -->
<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>

<style>
    /* Modal gradient border similar to snapshot */
    .my_students_details_menu_give_feedback_details_create_draft_card-border {
        background: linear-gradient(90deg, #ff4fa3, #4fe1ff);
        padding: 1px;
        /* thin border */
        border-radius: 5px;
    }

    .my_students_details_menu_give_feedback_details_create_draft_card-inner {
        border-radius: 5px;
    }

    /* Primary button style (modal + outer trigger) */
    .my_students_details_menu_give_feedback_details_create_draft_button_primary {
        background-color: #ff4fa3;
        border: 2px solid #000000ff;
        color: #ffffff;
        transition: background-color 0.15s ease, box-shadow 0.15s ease,
            transform 0.1s ease;
    }

    .my_students_details_menu_give_feedback_details_create_draft_button_primary:hover {
        background-color: #ff6bb0;
        box-shadow: 0 4px 10px rgba(0, 0, 0, 0.15);
        transform: translateY(-1px);
    }

    .my_students_details_menu_give_feedback_details_create_draft_button_primary:active {
        transform: translateY(0);
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
    }

    /* Secondary button (Cancel) */
    .my_students_details_menu_give_feedback_details_create_draft_button_secondary {
        background-color: #ffffff;
        border: 2px solid #d1d5db;
        color: #111827;
        transition: background-color 0.15s ease, box-shadow 0.15s ease;
    }

    .my_students_details_menu_give_feedback_details_create_draft_button_secondary:hover {
        background-color: #f9fafb;
        box-shadow: 0 3px 7px rgba(0, 0, 0, 0.08);
    }

    /* Custom dropdown button */
    .my_students_details_menu_give_feedback_details_create_draft_dropdown_button {
        border: 1px solid #d1d5db;
        background-color: #ffffff;
        transition: border-color 0.15s ease, box-shadow 0.15s ease,
            background-color 0.15s ease;
    }

    .my_students_details_menu_give_feedback_details_create_draft_dropdown_button:hover {
        background-color: #f9fafb;
        border: 2px solid #000000ff;
        box-shadow: 0 3px 7px rgba(0, 0, 0, 0.08);
    }

    .my_students_details_menu_give_feedback_details_create_draft_dropdown_button_active {
        border-color: #f472b6;
        box-shadow: 0 0 0 2px rgba(244, 114, 182, 0.3);
    }

    /* Dropdown list */
    .my_students_details_menu_give_feedback_details_create_draft_dropdown_list {
        max-height: 260px;
        overflow-y: auto;
    }

    .my_students_details_menu_give_feedback_details_create_draft_dropdown_option {
        transition: background-color 0.12s ease;
    }

    .my_students_details_menu_give_feedback_details_create_draft_dropdown_option:hover {
        background-color: #f3f4f6;
    }

    .my_students_details_menu_give_feedback_details_create_draft_dropdown_option_selected {
        background-color: #f3f4f6;
    }
</style>

<!-- Trigger button (outside modal) -->
<!-- <button
    id="my_students_details_menu_give_feedback_details_create_draft_open_button"
    class="my_students_details_menu_give_feedback_details_create_draft_button_open my_students_details_menu_give_feedback_details_create_draft_button_primary px-6 py-3 rounded-lg font-semibold shadow-md text-base md:text-lg">
    Create draft
</button> -->

<!-- Overlay + Modal -->
<div
    id="my_students_details_menu_give_feedback_details_create_draft_overlay"
    class="my_students_details_menu_give_feedback_details_create_draft_overlay fixed inset-0 bg-black/50 flex items-center justify-center px-4 z-50 hidden">
    <!-- Card with gradient border -->
    <div
        class="my_students_details_menu_give_feedback_details_create_draft_card-border max-w-md w-full">
        <div
            id="my_students_details_menu_give_feedback_details_create_draft_modal"
            class="my_students_details_menu_give_feedback_details_create_draft_modal bg-white my_students_details_menu_give_feedback_details_create_draft_card-inner p-8 shadow-xl">
            <!-- Icon -->
            <div class="flex justify-center mb-4">
                <!-- Sparkle icon image (replace src with your own asset if needed) -->
                <img
                    class="my_students_details_menu_give_feedback_details_create_draft_icon h-8 w-8"
                    src="https://cdn-icons-png.flaticon.com/512/1828/1828884.png"
                    alt="Sparkle icon" />
            </div>

            <!-- Title -->
            <h2
                class="my_students_details_menu_give_feedback_details_create_draft_title text-center text-xl md:text-2xl font-bold text-gray-900 leading-snug mb-6">
                Which language should the<br class="hidden sm:block">
                assistant use to create your draft?
            </h2>

            <!-- Choose language label -->
            <label
                for="my_students_details_menu_give_feedback_details_create_draft_language_select"
                class="my_students_details_menu_give_feedback_details_create_draft_label block text-gray-800 mb-2 font-medium">
                Choose language
            </label>

            <!-- Custom select wrapper -->
            <div
                id="my_students_details_menu_give_feedback_details_create_draft_dropdown_wrapper"
                class="my_students_details_menu_give_feedback_details_create_draft_select_wrapper relative mb-6">
                <!-- Real select (kept hidden for form compatibility) -->
                <select
                    id="my_students_details_menu_give_feedback_details_create_draft_language_select"
                    class="hidden">
                    <option value="English" selected>English</option>
                    <option value="Bahasa Indonesia">Bahasa Indonesia</option>
                    <option value="Deutsch">Deutsch</option>
                    <option value="Español">Español</option>
                    <option value="Français">Français</option>
                    <option value="Italiano">Italiano</option>
                    <option value="Nederlands">Nederlands</option>
                </select>

                <!-- Visible custom dropdown button -->
                <button
                    type="button"
                    id="my_students_details_menu_give_feedback_details_create_draft_dropdown_button"
                    class="my_students_details_menu_give_feedback_details_create_draft_dropdown_button w-full rounded-lg px-4 py-3 pr-10 flex items-center justify-between text-gray-900 text-sm md:text-base">
                    <span
                        id="my_students_details_menu_give_feedback_details_create_draft_selected_text">
                        English
                    </span>

                    <!-- Dropdown arrow as image -->
                    <span
                        class="my_students_details_menu_give_feedback_details_create_draft_arrow pointer-events-none flex items-center" style="margin-right:-20px; margin-top:5px;">
                        <img
                            class="h-4 w-4"
                            src="https://cdn-icons-png.flaticon.com/512/271/271210.png"
                            alt="Arrow icon" />
                    </span>
                </button>

                <!-- Custom dropdown list -->
                <div
                    id="my_students_details_menu_give_feedback_details_create_draft_dropdown_list"
                    class="my_students_details_menu_give_feedback_details_create_draft_dropdown_list absolute left-0 right-0 bottom-full mb-2 bg-white rounded-xl shadow-lg border border-gray-200 hidden z-10">
                    <ul class="divide-y divide-gray-200 text-sm md:text-base">
                        <li
                            class="my_students_details_menu_give_feedback_details_create_draft_dropdown_option my_students_details_menu_give_feedback_details_create_draft_dropdown_option_selected px-4 py-2 cursor-pointer"
                            data-value="English">
                            English
                        </li>
                        <li
                            class="my_students_details_menu_give_feedback_details_create_draft_dropdown_option px-4 py-2 cursor-pointer"
                            data-value="Bahasa Indonesia">
                            Bahasa Indonesia
                        </li>
                        <li
                            class="my_students_details_menu_give_feedback_details_create_draft_dropdown_option px-4 py-2 cursor-pointer"
                            data-value="Deutsch">
                            Deutsch
                        </li>
                        <li
                            class="my_students_details_menu_give_feedback_details_create_draft_dropdown_option px-4 py-2 cursor-pointer"
                            data-value="Español">
                            Español
                        </li>
                        <li
                            class="my_students_details_menu_give_feedback_details_create_draft_dropdown_option px-4 py-2 cursor-pointer"
                            data-value="Français">
                            Français
                        </li>
                        <li
                            class="my_students_details_menu_give_feedback_details_create_draft_dropdown_option px-4 py-2 cursor-pointer"
                            data-value="Italiano">
                            Italiano
                        </li>
                        <li
                            class="my_students_details_menu_give_feedback_details_create_draft_dropdown_option px-4 py-2 cursor-pointer"
                            data-value="Nederlands">
                            Nederlands
                        </li>
                    </ul>
                </div>
            </div>

            <!-- Primary button -->
            <button
                id="my_students_details_menu_give_feedback_details_create_draft_submit_button"
                class="my_students_details_menu_give_feedback_details_create_draft_button_submit my_students_details_menu_give_feedback_details_create_draft_button_primary w-full rounded-lg font-semibold text-lg py-3 mb-4">
                Create draft
            </button>

            <!-- Secondary button -->
            <button
                id="my_students_details_menu_give_feedback_details_create_draft_cancel_button"
                class="my_students_details_menu_give_feedback_details_create_draft_button_cancel my_students_details_menu_give_feedback_details_create_draft_button_secondary w-full rounded-lg font-semibold text-lg py-3">
                Cancel
            </button>
        </div>
    </div>
</div>

<script>
    // jQuery logic with required prefix
    var my_students_details_menu_give_feedback_details_create_draft_is_open = false;
    var my_students_details_menu_give_feedback_details_create_draft_is_dropdown_open = false;

    function my_students_details_menu_give_feedback_details_create_draft_openModal() {
        $('#my_students_details_menu_give_feedback_details_create_draft_overlay').removeClass('hidden');
        my_students_details_menu_give_feedback_details_create_draft_is_open = true;
    }

    function my_students_details_menu_give_feedback_details_create_draft_closeModal() {
        $('#my_students_details_menu_give_feedback_details_create_draft_overlay').addClass('hidden');
        my_students_details_menu_give_feedback_details_create_draft_is_open = false;
        my_students_details_menu_give_feedback_details_create_draft_closeDropdown();
    }

    function my_students_details_menu_give_feedback_details_create_draft_openDropdown() {
        $('#my_students_details_menu_give_feedback_details_create_draft_dropdown_list').removeClass('hidden');
        $('#my_students_details_menu_give_feedback_details_create_draft_dropdown_button')
            .addClass('my_students_details_menu_give_feedback_details_create_draft_dropdown_button_active');
        my_students_details_menu_give_feedback_details_create_draft_is_dropdown_open = true;
    }

    function my_students_details_menu_give_feedback_details_create_draft_closeDropdown() {
        $('#my_students_details_menu_give_feedback_details_create_draft_dropdown_list').addClass('hidden');
        $('#my_students_details_menu_give_feedback_details_create_draft_dropdown_button')
            .removeClass('my_students_details_menu_give_feedback_details_create_draft_dropdown_button_active');
        my_students_details_menu_give_feedback_details_create_draft_is_dropdown_open = false;
    }

    $(document).ready(function() {
        // Open when main button clicked
        $('#my_students_details_menu_give_feedback_details_create_draft_open_button').on('click', function() {
            my_students_details_menu_give_feedback_details_create_draft_openModal();
        });

        // Close on Cancel button
        $('#my_students_details_menu_give_feedback_details_create_draft_cancel_button').on('click', function() {
            my_students_details_menu_give_feedback_details_create_draft_closeModal();
        });

        // Optional: close when clicking outside the modal content
        $('#my_students_details_menu_give_feedback_details_create_draft_overlay').on('click', function(e) {
            if ($(e.target).is('#my_students_details_menu_give_feedback_details_create_draft_overlay')) {
                my_students_details_menu_give_feedback_details_create_draft_closeModal();
            }
        });

        // ESC key closes modal
        $(document).on('keydown', function(e) {
            if (e.key === 'Escape' && my_students_details_menu_give_feedback_details_create_draft_is_open) {
                my_students_details_menu_give_feedback_details_create_draft_closeModal();
            }
        });

        // Toggle dropdown on button click
        $('#my_students_details_menu_give_feedback_details_create_draft_dropdown_button').on('click', function(e) {
            e.stopPropagation();
            if (my_students_details_menu_give_feedback_details_create_draft_is_dropdown_open) {
                my_students_details_menu_give_feedback_details_create_draft_closeDropdown();
            } else {
                my_students_details_menu_give_feedback_details_create_draft_openDropdown();
            }
        });

        // Handle option click
        $('.my_students_details_menu_give_feedback_details_create_draft_dropdown_option').on('click', function(e) {
            e.stopPropagation();

            var my_students_details_menu_give_feedback_details_create_draft_value = $(this).data('value');
            var my_students_details_menu_give_feedback_details_create_draft_text = $(this).text();

            // Update visible text
            $('#my_students_details_menu_give_feedback_details_create_draft_selected_text').text(
                my_students_details_menu_give_feedback_details_create_draft_text
            );

            // Update hidden select value
            $('#my_students_details_menu_give_feedback_details_create_draft_language_select').val(
                my_students_details_menu_give_feedback_details_create_draft_value
            );

            // Visual selected state
            $('.my_students_details_menu_give_feedback_details_create_draft_dropdown_option')
                .removeClass('my_students_details_menu_give_feedback_details_create_draft_dropdown_option_selected');
            $(this).addClass('my_students_details_menu_give_feedback_details_create_draft_dropdown_option_selected');

            my_students_details_menu_give_feedback_details_create_draft_closeDropdown();
        });

        // Close dropdown when clicking anywhere outside dropdown wrapper
        $(document).on('click', function(e) {
            if (
                !$(e.target).closest(
                    '#my_students_details_menu_give_feedback_details_create_draft_dropdown_wrapper'
                ).length
            ) {
                my_students_details_menu_give_feedback_details_create_draft_closeDropdown();
            }
        });
    });
</script>