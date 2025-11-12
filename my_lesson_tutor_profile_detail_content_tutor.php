<!-- Which Tutor? modal -->
<div id="my_lessons_details_calendar_content_tutor_modal_root" class="hidden">
  <!-- Backdrop -->
  <div id="my_lessons_details_calendar_content_tutor_modal_overlay"
       class="fixed inset-0 bg-black/40 backdrop-blur-[2px] z-[5000]"></div>

  <!-- Modal container (centers the card) -->
  <div id="my_lessons_details_calendar_content_tutor_modal_portal"
       class="fixed inset-0 z-[5001] grid place-items-center p-4">

    <!-- Card -->
    <div class="bg-white w-full max-w-[560px] rounded-2xl shadow-2xl ring-1 ring-black/5">
      <!-- Header -->
      <div class="flex items-center justify-between px-6 py-5 border-b border-gray-100">
        <h3 class="text-2xl font-extrabold tracking-tight">Which tutor?</h3>
        <button id="my_lessons_details_calendar_content_tutor_btn_close"
                type="button"
                class="inline-flex items-center justify-center w-9 h-9 rounded-full hover:bg-gray-100"
                aria-label="Close">
          <!-- X icon -->
          <svg viewBox="0 0 24 24" class="w-5 h-5 text-gray-600" fill="none" stroke="currentColor" stroke-width="2">
            <path d="M18 6 6 18M6 6l12 12"/>
          </svg>
        </button>
      </div>

      <!-- List -->
      <div class="px-2 py-2 max-h-[70vh] overflow-y-auto">
        <ul id="my_lessons_details_calendar_content_tutor_list" class="divide-y divide-gray-100">
          <!-- rows injected by JS -->
        </ul>
      </div>
    </div>
  </div>
</div>

<script>
/** Demo data — replace with your real tutors list when ready */
const my_lessons_details_calendar_content_tutor_tutors = [
  { id: 1, name: "Daniela",       lessons: 11, avatar: "https://i.pravatar.cc/80?img=47" },
  { id: 2, name: "Wade Warren",   lessons:  8, avatar: "https://i.pravatar.cc/80?img=12" },
  { id: 3, name: "Albert Flores", lessons: 15, avatar: "https://i.pravatar.cc/80?img=32" },
  { id: 4, name: "Annette Black", lessons:  0, avatar: "https://i.pravatar.cc/80?img=61" },
  { id: 5, name: "Daniel A.",     lessons:  0, avatar: "https://i.pravatar.cc/80?img=23" },
];

/** Build one row */
function my_lessons_details_calendar_content_tutor_buildRow(tutor){
  const lessonsLabel = `${tutor.lessons} lesson${tutor.lessons === 1 ? "" : "s"} to schedule`;
  return `
    <li>
      <button type="button"
        class="w-full flex items-center gap-3 px-4 py-3 hover:bg-gray-50 focus:outline-none"
        data-id="${tutor.id}">
        <img class="w-10 h-10 rounded-lg object-cover" src="${tutor.avatar}" alt="${tutor.name}" />
        <div class="flex-1 text-left">
          <div class="font-semibold text-gray-900 leading-tight">${tutor.name}</div>
          <div class="text-sm text-gray-500">${lessonsLabel}</div>
        </div>
        <svg viewBox="0 0 24 24" class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" stroke-width="2">
          <path d="m9 6 6 6-6 6"/>
        </svg>
      </button>
    </li>`;
}

/** Render list */
function my_lessons_details_calendar_content_tutor_renderList(tutors){
  const $list = $("#my_lessons_details_calendar_content_tutor_list").empty();
  tutors.forEach(t => $list.append(my_lessons_details_calendar_content_tutor_buildRow(t)));
}

/** Open/Close controls */
function my_lessons_details_calendar_content_tutor_openModal(tutors){
  my_lessons_details_calendar_content_tutor_renderList(tutors || my_lessons_details_calendar_content_tutor_tutors);
  $("#my_lessons_details_calendar_content_tutor_modal_root").removeClass("hidden");
  $("body").addClass("overflow-hidden");
}

function my_lessons_details_calendar_content_tutor_closeModal(){
  $("#my_lessons_details_calendar_content_tutor_modal_root").addClass("hidden");
  $("body").removeClass("overflow-hidden");
}

/** Bind triggers:
 *  - Click any .slot (your empty half-hour cells) -> open modal
 *  - Close on overlay, X or ESC
 */
function my_lessons_details_calendar_content_tutor_bindEmptySlotClicks(){
  // Open only when clicking *empty* slots (not events)
  $(document).on("click", ".slot", function(e){
    // extra guard: ignore if somehow an event is the target
    if ($(e.target).closest(".event").length) return;
    my_lessons_details_calendar_content_tutor_openModal();
  });

  // Close handlers
  $("#my_lessons_details_calendar_content_tutor_modal_overlay")
    .on("click", my_lessons_details_calendar_content_tutor_closeModal);
  $("#my_lessons_details_calendar_content_tutor_btn_close")
    .on("click", my_lessons_details_calendar_content_tutor_closeModal);
  $(document).on("keydown", function(e){
    if(e.key === "Escape") my_lessons_details_calendar_content_tutor_closeModal();
  });

  // Optional: handle row clicks
  $(document).on("click", "#my_lessons_details_calendar_content_tutor_list button", function(){
    const id = $(this).data("id");
    // TODO: replace with your navigation/action
    console.log("Tutor selected:", id);
    my_lessons_details_calendar_content_tutor_closeModal();
  });
}

/** Init on ready */
$(function(){
  my_lessons_details_calendar_content_tutor_bindEmptySlotClicks();
});
</script>

