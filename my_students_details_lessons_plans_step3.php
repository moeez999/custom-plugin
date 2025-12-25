<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Latingles - Learning Plan</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- Tailwind CSS CDN -->
    <script src="https://cdn.tailwindcss.com"></script>

    <!-- jQuery CDN -->
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"
        integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo="
        crossorigin="anonymous"></script>

    <style>
        .my_students_details_lessons_plans_step3_page-wrapper {
            min-height: 100vh;
            background-color: #ffffff;
        }

        .my_students_details_lessons_plans_step3_main-layout {
            width: 100%;
            max-width: 100%;
        }

        .my_students_details_lessons_plans_step3_primary-btn {
            background-color: #ff3b1f;
            transition: background-color 0.2s ease, transform 0.1s ease;
            border: 2px solid black;

        }

        .my_students_details_lessons_plans_step3_primary-btn:hover {
            background-color: #e62f14;
            transform: translateY(-1px);
        }

        .my_students_details_lessons_plans_step3_primary-btn:active {
            transform: translateY(0);
        }

        .my_students_details_lessons_plans_step3_language-btn {
            border: 1px solid #e5e7eb;
        }

        .my_students_details_lessons_plans_step3_check-icon {
            width: 18px;
            height: 18px;
        }

        @media (max-width: 768px) {
            .my_students_details_lessons_plans_step3_main-content {
                padding: 1.5rem 1.25rem 2.5rem 1.25rem;
            }

            .my_students_details_lessons_plans_step3_left-section,
            .my_students_details_lessons_plans_step3_right-section {
                padding-top: 1.25rem;
            }
        }
    </style>
</head>

<body class="my_students_details_lessons_plans_step3_page-wrapper">

    <!-- Top header -->
    <header id="my_students_details_lessons_plans_step3_header"
        class="border-b border-slate-200">
        <div class="my_students_details_lessons_plans_step3_main-layout mx-auto px-6 md:px-14 py-5 flex items-center justify-between">
            <a href="http://localhost/latingles_lms_v2/course/index.php">
                <div class="my_students_details_lessons_plans_step3_logo flex items-center space-x-3">
                    <!-- Replace src with your real logo -->

                    <img id="my_students_details_lessons_plans_step3_logo_img"
                        src="img/my_students/logo_header.svg"
                        alt="LATINGLES Logo"
                        class="my_students_details_lessons_plans_step3_logo_img w-30 h-30">
                </div>
            </a>
            <button id="my_students_details_lessons_plans_step3_language_button"
                class="my_students_details_lessons_plans_step3_language-btn flex items-center gap-2 px-4 py-2 rounded-md bg-white text-sm text-slate-700">
                <span class="my_students_details_lessons_plans_step3_language-label">English, USD</span>
                <span class="my_students_details_lessons_plans_step3_language-chevron text-xs">▼</span>
            </button>
        </div>
    </header>

    <!-- Main content -->
    <main id="my_students_details_lessons_plans_step3_main_content"
        class="my_students_details_lessons_plans_step3_main-content">
        <div class="my_students_details_lessons_plans_step3_main-layout mx-auto flex flex-col md:flex-row">

            <!-- Left section (50%) -->
            <section id="my_students_details_lessons_plans_step3_left_section"
                class="my_students_details_lessons_plans_step3_left-section w-full md:w-1/2 px-6 md:px-14 py-8 md:py-12 flex flex-col justify-start">
                <div class="my_students_details_lessons_plans_step3_illustration mb-6">
                    <!-- Replace with your actual illustration -->
                    <img id="my_students_details_lessons_plans_step3_illustration_img"
                        src="img/my_students/lessons_plan_icon.svg"
                        alt="Progress Illustration"
                        class="my_students_details_lessons_plans_step3_illustration_img w-20 h-20">
                </div>

                <h1 id="my_students_details_lessons_plans_step3_heading"
                    class="my_students_details_lessons_plans_step3_heading text-2xl md:text-[28px] font-semibold text-slate-900 leading-snug mb-4 max-w-xl">
                    Great! Sounds like Wade Warren is<br class="hidden md:block"> the tutor for you.
                </h1>

                <p id="my_students_details_lessons_plans_step3_description"
                    class="my_students_details_lessons_plans_step3_description text-sm md:text-base text-slate-600 leading-relaxed max-w-xl">
                    Next step: we recommend this learning plan to help you reach your goal. This
                    plan is flexible – change tutors, pause, or cancel whenever you need.
                </p>
            </section>

            <!-- Right section (50%, grey background) -->
            <section id="my_students_details_lessons_plans_step3_right_section"
                class="my_students_details_lessons_plans_step3_right-section w-full md:w-1/2 bg-[#f5f5f7] px-4 md:px-10 py-8  flex items-start justify-center" style="height: 615px;">
                <div class="my_students_details_lessons_plans_step3_plan-panel w-full h-full flex relative">

                    <!-- Close icon -->
                    <a href="http://localhost/latingles_lms_v2/course/index.php">
                        <button id="my_students_details_lessons_plans_step3_close_btn"
                            class="my_students_details_lessons_plans_step3_close-btn absolute top-1 right-0 w-8 h-8 flex text-lg leading-none"
                            style="font-size: 30px;">
                            ×
                        </button>
                    </a>

                    <!-- White card -->
                    <div class="my_students_details_lessons_plans_step3_plan-card bg-white rounded-lg shadow-sm p-6 md:p-7 max-w-[620px] w-full mx-auto" style="margin-left:10px; border: 1.5px solid #e4e4e4;">

                        <!-- Card header -->
                        <div class="my_students_details_lessons_plans_step3_plan-header flex items-center justify-between mb-4">
                            <h2 class="my_students_details_lessons_plans_step3_plan-title text-base font-semibold text-slate-900" style="font-size: 1.2rem;">
                                Your learning plan
                            </h2>
                            <button class="my_students_details_lessons_plans_step3_plan-see-all text-xs font-medium text-slate-1000 underline" style="font-size: 15px;">
                                See All Plans
                            </button>
                        </div>

                        <!-- Divider -->
                        <hr class="my_students_details_lessons_plans_step3_divider border-slate-200 mb-4 md:mb-5">

                        <!-- Plan title + subtext -->
                        <div class="my_students_details_lessons_plans_step3_plan-info mb-5">
                            <p class="my_students_details_lessons_plans_step3_plan-main text-2xl font-semibold text-slate-900 mb-1">
                                3 lessons per week
                            </p>
                            <p class="my_students_details_lessons_plans_step3_plan-sub text-xs text-slate-500" style="color: #494949;font-weight: 500;">
                                That’s 12 lessons every 4 weeks at $108.00.
                            </p>
                        </div>

                        <!-- Price row -->
                        <div class="my_students_details_lessons_plans_step3_price-row flex items-end gap-8 mb-6">
                            <div class="my_students_details_lessons_plans_step3_price-column">
                                <p class="my_students_details_lessons_plans_step3_price-main text-3xl font-semibold text-slate-900 leading-none mb-1">
                                    $5
                                </p>
                                <p class="my_students_details_lessons_plans_step3_price-caption text-xs text-slate-500" style="font-weight: 500;color: #494949;">
                                    per 50-min lesson
                                </p>
                            </div>

                            <div class="my_students_details_lessons_plans_step3_price-column" style="margin-left:20%;">
                                <p class="my_students_details_lessons_plans_step3_price-main text-3xl font-semibold text-slate-900 leading-none mb-1">
                                    $60
                                </p>
                                <p class="my_students_details_lessons_plans_step3_price-caption text-xs text-slate-500" style="font-weight: 500;color: #494949;">
                                    Every 4 week
                                </p>
                            </div>
                        </div>

                        <!-- CTA button -->
                        <button id="my_students_details_lessons_plans_step3_checkout_btn"
                            class="my_students_details_lessons_plans_step3_primary-btn w-full py-3 rounded-md text-white text-md font-semibold mb-6">
                            Continue to checkout
                        </button>

                        <!-- Bullet list -->
                        <ul class="my_students_details_lessons_plans_step3_benefits space-y-6 text-xs md:text-sm text-slate-700">
                            <li class="my_students_details_lessons_plans_step3_benefit-item flex items-start gap-2">
                                <span class="my_students_details_lessons_plans_step3_check-icon flex-shrink-0 rounded-full flex items-center justify-center">
                                    <img id="my_students_details_lessons_plans_step3_tick_icon_1"
                                        src="img/my_students/lessons_plan_tick_icon.svg"
                                        alt="Tick icon"
                                        class="my_students_details_lessons_plans_step3_tick-img w-4 h-4">
                                </span>
                                <span style="font-weight: 600;">You have 12 lessons to schedule every month</span>
                            </li>

                            <li class="my_students_details_lessons_plans_step3_benefit-item flex items-start gap-2">
                                <span class="my_students_details_lessons_plans_step3_check-icon flex-shrink-0 rounded-full flex items-center justify-center">
                                    <img id="my_students_details_lessons_plans_step3_tick_icon_2"
                                        src="img/my_students/lessons_plan_tick_icon.svg"
                                        alt="Tick icon"
                                        class="my_students_details_lessons_plans_step3_tick-img w-4 h-4">
                                </span>
                                <span style="font-weight: 600;">You choose the length of your lessons</span>
                            </li>

                            <li class="my_students_details_lessons_plans_step3_benefit-item flex items-start gap-2">
                                <span class="my_students_details_lessons_plans_step3_check-icon flex-shrink-0 rounded-full flex items-center justify-center">
                                    <img id="my_students_details_lessons_plans_step3_tick_icon_3"
                                        src="img/my_students/lessons_plan_tick_icon.svg"
                                        alt="Tick icon"
                                        class="my_students_details_lessons_plans_step3_tick-img w-4 h-4">
                                </span>
                                <span style="font-weight: 600;">Switch tutors for free at any time</span>
                            </li>

                            <li class="my_students_details_lessons_plans_step3_benefit-item flex items-start gap-2">
                                <span class="my_students_details_lessons_plans_step3_check-icon flex-shrink-0 rounded-full flex items-center justify-center">
                                    <img id="my_students_details_lessons_plans_step3_tick_icon_4"
                                        src="img/my_students/lessons_plan_tick_icon.svg"
                                        alt="Tick icon"
                                        class="my_students_details_lessons_plans_step3_tick-img w-4 h-4">
                                </span>
                                <span style="font-weight: 600;">Pause or cancel your plan for free at any time</span>
                            </li>
                        </ul>
                    </div>
                </div>
            </section>
        </div>
    </main>

    <script>
        // Simple jQuery interactions (all names prefixed)

        var my_students_details_lessons_plans_step3_selectedPlan = '3_lessons_per_week';

        function my_students_details_lessons_plans_step3_handleCheckoutClick() {
            console.log('Selected plan:', my_students_details_lessons_plans_step3_selectedPlan);
            alert('Continuing to checkout for: ' + my_students_details_lessons_plans_step3_selectedPlan);
        }

        $(document).ready(function() {
            $('#my_students_details_lessons_plans_step3_checkout_btn').on('click', function(e) {
                e.preventDefault();
                my_students_details_lessons_plans_step3_handleCheckoutClick();
            });

            $('#my_students_details_lessons_plans_step3_language_button').on('click', function() {
                alert('Language & currency selector clicked.');
            });

            // close button logic is commented as in your version
            // $('#my_students_details_lessons_plans_step3_close_btn').on('click', function() {
            //     $('#my_students_details_lessons_plans_step3_right_section').fadeOut(200);
            // });
        });
    </script>
</body>

</html>