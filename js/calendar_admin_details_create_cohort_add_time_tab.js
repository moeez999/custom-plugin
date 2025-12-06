$(".calendar_admin_details_create_cohort_tab").click(function () {
  $(".calendar_admin_details_create_cohort_tab").removeClass("active");
  $(this).addClass("active");
  let tab = $(this).data("tab");
  $("#mainModalContent").toggle(tab === "cohort");
  $("#conferenceTabContent").toggle(tab === "conference");
  $("#peerTalkTabContent").toggle(tab === "peertalk");
  $("#mergeTabContent").toggle(tab === "merge");
  $("#addTimeTabContent").toggle(tab === "addtime");
  // ...other tabs if any...
  // Hide all if not any of the above
});

// --- Add Time tab calendar and time picker logic ---

let addTimeDateTargetBtn = null; // which button is setting date

// Show calendar modal for "From" or "Until"
$("#addTimeFromDateBtn, #addTimeUntilDateBtn").click(function (e) {
  e.preventDefault();
  addTimeDateTargetBtn = $(this);
  // Set month to now
  let now = new Date();
  mergeCalendarMonth = { year: now.getFullYear(), month: now.getMonth() };
  mergeSelectedCalendarDate = null;
  $("#mergeCalendarModalBackdrop").fadeIn(100);
  mergeRenderCalendarModal();
});
// When date chosen, set button text as above (already in mergeCalendarDoneBtn click!)

// Show time picker modal for "From" or "Until"
$("#addTimeFromTimeBtn, #addTimeUntilTimeBtn").click(function (e) {
  e.preventDefault();
  let $btn = $(this);
  let times = [];
  // Generate standardized times from 12:00 AM to 11:30 PM with 30-minute intervals
  for (let h = 0; h < 24; h++) {
    for (let m = 0; m < 60; m += 30) {
      let hour12 = h % 12 === 0 ? 12 : h % 12;
      let period = h >= 12 ? "PM" : "AM";
      let mm = m < 10 ? "0" + m : m;
      times.push(`${hour12}:${mm} ${period}`);
    }
  }
  let html = "";
  for (let t of times) html += `<li>${t}</li>`;
  $("#timeModal ul").html(html);

  // Position
  let offset = $btn.offset();
  let left = offset.left + $btn.outerWidth() / 2 - 105; // Centered (210px wide)
  let top = offset.top + $btn.outerHeight() + 2;
  if ($(window).width() < 500) {
    left = "50%";
    top = $(window).scrollTop() + $(window).height() * 0.22;
    $("#timeModal").css({
      left: left,
      top: top,
      transform: "translate(-50%,0)",
    });
  } else {
    $("#timeModal").css({ left: left, top: top, transform: "none" });
  }
  $("#timeModalBackdrop").show().data("targetBtn", $btn);
});

// When time selected
$("#timeModal")
  .off("click", "li")
  .on("click", "li", function () {
    let $btn = $("#timeModalBackdrop").data("targetBtn");
    $btn.text($(this).text()).addClass("selected");
    $("#timeModalBackdrop").hide();
  });

// Reuse your calendar modal logic for Done button (already sets button text and adds .selected)
// If you want to distinguish between Add Time and Merge calendar targets, you can check which button was last clicked.
