<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <title>Latingles – Feedback</title>
    <meta name="viewport" content="width=device-width, initial-scale=1" />

    <!-- Tailwind CDN -->
    <script src="https://cdn.tailwindcss.com"></script>

    <!-- jQuery CDN -->
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>

    <style>
        body {
            font-family: system-ui, -apple-system, BlinkMacSystemFont, "Segoe UI",
                sans-serif;
        }
    </style>
</head>

<body class="min-h-screen bg-white text-gray-900 flex flex-col">

    <!-- Header -->
    <header class="w-full flex items-center justify-between px-6 md:px-20 pt-8">
        <!-- Logo -->
        <div class="flex items-center gap-3">
            <!-- Logo icon as image placeholder -->
            <a href="http://localhost/latingles_lms_v2/course/index.php">
                <div class="w-30 h-30 flex items-center justify-center">
                    <img
                        src="img/my_students/logo_header.svg"
                        alt="Latingles logo icon"
                        class="w-full h-full object-contain" />
                </div>
              </a>
            </div>

        <!-- Skip button -->
        <a href="my_students_details_lessons_plans_teacher_profiles_list.php"><button
                class="px-5 py-2 text-sm md:text-base border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50 transition">
                Skip
            </button></a>
    </header>

    <!-- Main content -->
    <main class="flex-1 flex items-center justify-center px-4 pb-12">
        <div class="max-w-3xl w-full flex flex-col items-center">

            <!-- Avatar centered -->
            <div class="flex justify-center w-full mb-6 md:mb-8">
                <div
                    class="w-16 h-16 md:w-20 md:h-20 mx-auto overflow-hidden border border-gray-200 shadow-sm">
                    <!-- Avatar image placeholder -->
                    <img
                        src="img/my_students/profile_img.png"
                        alt="Wade Warren"
                        class="w-full h-full object-cover" />
                </div>
            </div>

            <!-- Text block -->
            <div class="w-full text-center">
                <h1
                    class="text-2xl md:text-4xl font-semibold tracking-tight mb-3 md:mb-4">
                    How did it go with Wade Warren?
                </h1>

                <p class="text-gray-500 text-sm md:text-base max-w-xl mx-auto">
                    This is only shared with Latingles, so please be honest.
                </p>
            </div>

            <!-- Rating options -->
            <div
                class="mt-10 md:mt-12 grid grid-cols-1 md:grid-cols-3 gap-4 md:gap-6 max-w-2xl w-full">
                <!-- Bad -->
                <button
                    type="button"
                    class="rating-card group w-full h-32 md:h-36 border border-gray-200 rounded-2xl bg-white flex flex-col items-start justify-center gap-3 px-6 hover:border-gray-400 hover:shadow-md transition"
                    data-rating="bad">
                    <!-- Icon placeholder -->
                    <img
                        src="img/my_students/dislike_icon.svg"
                        alt="Bad icon"
                        class="w-6 h-6 md:w-7 md:h-7 object-contain" />
                    <span class="text-sm md:text-base font-medium text-gray-800">
                        Bad
                    </span>
                </button>

                <!-- Okay -->
                <button
                    type="button"
                    class="rating-card group w-full h-32 md:h-36 border border-gray-200 rounded-2xl bg-white flex flex-col items-start justify-center gap-3 px-6 hover:border-gray-400 hover:shadow-md transition"
                    data-rating="okay">
                    <!-- Icon placeholder -->
                    <img
                        src="img/my_students/like_icon.svg"
                        alt="Okay icon"
                        class="w-6 h-6 md:w-7 md:h-7 object-contain" />
                    <span class="text-sm md:text-base font-medium text-gray-800">
                        Okay
                    </span>
                </button>

                <!-- Great -->
                <a href="my_students_details_lessons_plans_step2.php"><button
                        type="button"
                        class="rating-card group w-full h-32 md:h-36 border border-gray-200 rounded-2xl bg-white flex flex-col items-start justify-center gap-3 px-6 hover:border-gray-400 hover:shadow-md transition"
                        data-rating="great">
                        <!-- Icon placeholder -->
                        <img
                            src="img/my_students/great_icon.svg"
                            alt="Great icon"
                            class="w-6 h-6 md:w-7 md:h-7 object-contain" />
                        <span class="text-sm md:text-base font-medium text-gray-800">
                            Great
                        </span>
                    </button>
                </a>
            </div>
        </div>
    </main>

    <!-- Hidden element so Tailwind keeps these classes for active state -->
    <div class="hidden ring-2 ring-indigo-500 ring-offset-2 ring-offset-white"></div>

    <!-- jQuery for card selection -->
    <script>
        $(function() {
            $(".rating-card").on("click", function() {
                $(".rating-card")
                    .removeClass(
                        "ring-2 ring-indigo-500 ring-offset-2 ring-offset-white border-transparent"
                    )
                    .addClass("border-gray-200");
                $(this)
                    .addClass(
                        "ring-2 ring-indigo-500 ring-offset-2 ring-offset-white border-transparent"
                    )
                    .removeClass("border-gray-200");
                // const value = $(this).data("rating"); // if you need the selected value
            });
        });
    </script>

</body>

</html>