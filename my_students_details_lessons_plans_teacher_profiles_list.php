<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <title>Latingles – Teacher Profiles</title>
  <meta name="viewport" content="width=device-width, initial-scale=1" />

  <!-- Tailwind CDN -->
  <script src="https://cdn.tailwindcss.com"></script>

  <!-- jQuery CDN -->
  <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>

  <style>
    body {
      font-family: system-ui, -apple-system, BlinkMacSystemFont, "Segoe UI", sans-serif;
    }
  </style>
</head>

<body class="min-h-screen bg-white text-gray-900 flex flex-col">

  <!-- Header (UNCHANGED / kept as you said ignore my header) -->
  <header class="w-full flex items-center justify-between px-6 pt-8">
    <div class="flex items-center gap-3">
      <div class="w-30 h-30 flex items-center justify-center">
        <img
          src="img/my_students/logo_header.svg"
          alt="Latingles logo icon"
          class="w-full h-full object-contain" />
      </div>
    </div>

    <!-- Close icon (replaces top-right button) -->
    <button
      id="my_students_details_lessons_plans_teacher_profiles_list_closeBtn"
      type="button"
      aria-label="Close"
      class="w-10 h-10 flex items-center justify-center rounded-full hover:bg-gray-100 transition">
      <!-- X icon -->
      <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 text-gray-900" viewBox="0 0 24 24" fill="none"
        stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
        <path d="M18 6L6 18"></path>
        <path d="M6 6l12 12"></path>
      </svg>
    </button>
  </header>

  <!-- Main content (REPLACED with Teacher Profiles content) -->
  <main
    id="my_students_details_lessons_plans_teacher_profiles_list_canvas"
    class="flex-1 flex items-start justify-center px-4 pb-12 pt-10 md:pt-14">
    <div class="w-full max-w-3xl">

      <!-- Title -->
      <h1 class="text-3xl md:text-4xl font-semibold tracking-tight leading-tight text-gray-900 mb-5">
        Ready Continue Learning With Wade<br class="hidden md:block" />
        Warren?
      </h1>

      <!-- Subtitle -->
      <p class="text-sm font-semibold text-gray-900 mb-4">
        Is Wade Warren Is Tutor For You?
      </p>

      <!-- Wade card -->
      <div class="w-full border border-gray-200 rounded-lg bg-white p-4 md:p-5 flex flex-col md:flex-row md:items-center md:justify-between gap-4 md:gap-6 mb-10">
        <div class="flex items-center gap-3 min-w-0">
          <!-- Removed border radius from profile picture -->
          <div class="w-11 h-11 overflow-hidden bg-gray-200 flex-shrink-0">
            <img
              src="img/lessons_plans/lesson_plan_profile.png"
              alt="Wade"
              class="w-full h-full object-cover" />
          </div>

          <div class="min-w-0">
            <div class="text-base font-semibold text-gray-900 truncate">Wade W</div>

            <div class="flex items-center gap-2 text-xs text-gray-900 mt-0.5">
              <img
                src="img/lessons_plans/lesson_plan_star.svg"
                alt="Star"
                class="w-3.5 h-3.5 object-contain -translate-y-[1px]" />
              <span class="font-medium">4.7</span>
              <span class="text-gray-500 font-medium">17 reviews</span>
            </div>
          </div>
        </div>

        <!-- Added black 2px solid border on red button -->
        <button
          id="my_students_details_lessons_plans_teacher_profiles_list_keepBtn"
          type="button"
          class="w-full md:w-auto md:min-w-[310px] px-5 py-3 rounded-lg bg-[#ff3b10] hover:bg-[#e3340f] text-white text-sm font-semibold transition border-2 border-black">
          Keep learning withWade Warren
        </button>
      </div>

      <!-- Recommended -->
      <h2 class="text-2xl md:text-3xl font-semibold tracking-tight text-gray-900 mb-4">
        Try one of these recommended
      </h2>

      <!-- Grid -->
      <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
        <!-- Card 1 -->
        <div>
          <div class="relative h-[170px] rounded-lg overflow-hidden bg-gray-200">
            <img
              src="img/lessons_plans/مريم ا..png"
              alt="Gladys"
              class="w-full h-full object-cover" />
            <div class="absolute left-2.5 bottom-2.5 flex items-center gap-2 text-white font-semibold text-sm drop-shadow">
              <span>Gladys</span>
              <!-- Flag icon -->
              <img
                src="img/lessons_plans/Lebanon.svg"
                alt="Lebanon flag"
                class="w-4 h-3 rounded-[2px] object-cover shadow" />
            </div>
          </div>

          <div class="pt-3">
            <div class="flex items-center gap-2 text-xs font-semibold text-gray-900 mb-2">
              <img
                src="img/lessons_plans/lesson_plan_star.svg"
                alt="Star"
                class="w-3.5 h-3.5 object-contain -translate-y-[1px]" />
              <span>5</span>
              <span class="text-gray-500 font-semibold">(11)</span>
            </div>

            <p class="text-[13px] leading-5 text-gray-900 font-normal mb-3 min-h-[42px]">
              Certified English Tutor with 10+ Years’ Experience Making
            </p>

            <p class="text-[18px] leading-6 font-semibold text-gray-900">US$8</p>
            <p class="text-[13px] text-gray-500 font-medium mt-0.5">/ lesson</p>
          </div>
        </div>

        <!-- Card 2 -->
        <div>
          <div class="relative h-[170px] rounded-lg overflow-hidden bg-gray-200">
            <img
              src="img/lessons_plans/Jamil M..png"
              alt="Angel"
              class="w-full h-full object-cover" />
            <div class="absolute left-2.5 bottom-2.5 flex items-center gap-2 text-white font-semibold text-sm drop-shadow">
              <span>Angel</span>
              <!-- Flag icon -->
              <img
                src="img/lessons_plans/Egypt.svg"
                alt="Egypt flag"
                class="w-4 h-3 rounded-[2px] object-cover shadow" />
            </div>
          </div>

          <div class="pt-3">
            <div class="flex items-center gap-2 text-xs font-semibold text-gray-900 mb-2">
              <img
                src="img/lessons_plans/lesson_plan_star.svg"
                alt="Star"
                class="w-3.5 h-3.5 object-contain -translate-y-[1px]" />
              <span>4.9</span>
              <span class="text-gray-500 font-semibold">(49)</span>
            </div>

            <p class="text-[13px] leading-5 text-gray-900 font-normal mb-3 min-h-[42px]">
              Certified tutor with 7 years of experience of teaching English
            </p>

            <p class="text-[22px] leading-6 font-semibold text-gray-900">US$5</p>
            <p class="text-[13px] text-gray-500 font-medium mt-0.5">/ lesson</p>
          </div>
        </div>

        <!-- Card 3 -->
        <div>
          <div class="relative h-[170px] rounded-lg overflow-hidden bg-gray-200">
            <img
              src="img/lessons_plans/Picture.png"
              alt="Kristin"
              class="w-full h-full object-cover" />
            <div class="absolute left-2.5 bottom-2.5 flex items-center gap-2 text-white font-semibold text-sm drop-shadow">
              <span>Kristin</span>
              <!-- Flag icon -->
              <img
                src="img/lessons_plans/Lebanon.svg"
                alt="Lebanon flag"
                class="w-4 h-3 rounded-[2px] object-cover shadow" />
            </div>
          </div>

          <div class="pt-3">
            <div class="flex items-center gap-2 text-xs font-semibold text-gray-900 mb-2">
              <img
                src="img/lessons_plans/lesson_plan_star.svg"
                alt="Star"
                class="w-3.5 h-3.5 object-contain -translate-y-[1px]" />
              <span>5</span>
              <span class="text-gray-500 font-semibold">(44)</span>
            </div>

            <p class="text-[13px] leading-5 text-gray-900 font-normal mb-3 min-h-[42px]">
              Certified English Tutor with 5 years of experience
            </p>

            <p class="text-[22px] leading-6 font-semibold text-gray-900">US$8</p>
            <p class="text-[13px] text-gray-500 font-medium mt-0.5">/ lesson</p>
          </div>
        </div>

        <!-- Card 4 -->
        <div>
          <div class="relative h-[170px] rounded-lg overflow-hidden bg-gray-200">
            <img
              src="img/lessons_plans/Container.png"
              alt="Ronald"
              class="w-full h-full object-cover" />
            <div class="absolute left-2.5 bottom-2.5 flex items-center gap-2 text-white font-semibold text-sm drop-shadow">
              <span>Ronald</span>
              <!-- Flag icon -->
              <img
                src="img/lessons_plans/Egypt.svg"
                alt="Egypt flag"
                class="w-4 h-3 rounded-[2px] object-cover shadow" />
            </div>
          </div>

          <div class="pt-3">
            <div class="flex items-center gap-2 text-xs font-semibold text-gray-900 mb-2">
              <img
                src="img/lessons_plans/lesson_plan_star.svg"
                alt="Star"
                class="w-3.5 h-3.5 object-contain -translate-y-[1px]" />
              <span>5</span>
              <span class="text-gray-500 font-semibold">(33)</span>
            </div>

            <p class="text-[13px] leading-5 text-gray-900 font-normal mb-3 min-h-[42px]">
              certified English teacher with 5years of experience
            </p>

            <p class="text-[22px] leading-6 font-semibold text-gray-900">US$20</p>
            <p class="text-[13px] text-gray-500 font-medium mt-0.5">/ lesson</p>
          </div>
        </div>
      </div>
    </div>
  </main>
  
  <script>
    // JS only for functionality (prefix names kept)
    (function() {
      const my_students_details_lessons_plans_teacher_profiles_list_canvas =
        document.getElementById("my_students_details_lessons_plans_teacher_profiles_list_canvas");

      const my_students_details_lessons_plans_teacher_profiles_list_closeBtn =
        document.getElementById("my_students_details_lessons_plans_teacher_profiles_list_closeBtn");

      const my_students_details_lessons_plans_teacher_profiles_list_keepBtn =
        document.getElementById("my_students_details_lessons_plans_teacher_profiles_list_keepBtn");

      // Redirect to home page
      function my_students_details_lessons_plans_teacher_profiles_list_goHome() {
        // update this path if your home page is different (example: "index.html")
        window.location.href = "http://localhost/latingles_lms_v2/course/index.php";
      }

      function my_students_details_lessons_plans_teacher_profiles_list_onKeepLearning() {
        // Replace with your real logic
        alert("Keep learning clicked!");
      }

      if (my_students_details_lessons_plans_teacher_profiles_list_closeBtn) {
        my_students_details_lessons_plans_teacher_profiles_list_closeBtn.addEventListener(
          "click",
          my_students_details_lessons_plans_teacher_profiles_list_goHome
        );
      }

      if (my_students_details_lessons_plans_teacher_profiles_list_keepBtn) {
        my_students_details_lessons_plans_teacher_profiles_list_keepBtn.addEventListener(
          "click",
          my_students_details_lessons_plans_teacher_profiles_list_onKeepLearning
        );
      }

      document.addEventListener("keydown", function(my_students_details_lessons_plans_teacher_profiles_list_event) {
        if (my_students_details_lessons_plans_teacher_profiles_list_event.key === "Escape") {
          my_students_details_lessons_plans_teacher_profiles_list_goHome();
        }
      });
    })();
  </script>
</body>

</html>