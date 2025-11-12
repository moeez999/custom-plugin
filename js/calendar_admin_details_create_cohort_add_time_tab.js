
$('.calendar_admin_details_create_cohort_tab').click(function () {
  $('.calendar_admin_details_create_cohort_tab').removeClass('active');
  $(this).addClass('active');
  let tab = $(this).data('tab');
  $('#mainModalContent').toggle(tab === "cohort");
  $('#conferenceTabContent').toggle(tab === "conference");
  $('#peerTalkTabContent').toggle(tab === "peertalk");
  $('#mergeTabContent').toggle(tab === "merge");
  $('#addTimeTabContent').toggle(tab === "addtime");
  // ...other tabs if any...
  // Hide all if not any of the above
});



// --- Add Time tab calendar and time picker logic ---

let addTimeDateTargetBtn = null; // which button is setting date

// Show calendar modal for "From" or "Until"
$('#addTimeFromDateBtn, #addTimeUntilDateBtn').click(function(e){
  e.preventDefault();
  addTimeDateTargetBtn = $(this);
  // Set month to now
  let now = new Date();
  mergeCalendarMonth = {year: now.getFullYear(), month: now.getMonth()};
  mergeSelectedCalendarDate = null;
  $('#mergeCalendarModalBackdrop').fadeIn(100);
  mergeRenderCalendarModal();
});
// When date chosen, set button text as above (already in mergeCalendarDoneBtn click!)

// Show time picker modal for "From" or "Until"
$('#addTimeFromTimeBtn, #addTimeUntilTimeBtn').click(function(e){
  e.preventDefault();
  let $btn = $(this);
  let times = [];
  let start = 10; // 5:00 AM
  let end = 47;   // 11:30 PM
  for (let i = start; i <= end; i++) {
    let hour = Math.floor(i/2);
    let min = i%2 === 0 ? "00" : "30";
    let hour12 = ((hour+11)%12+1);
    let ampm = hour < 12 ? "AM" : "PM";
    let str = hour12.toString().padStart(2, "0") + ":" + min + " " + ampm;
    times.push(str);
  }
  let html = "";
  for (let t of times) html += `<li>${t}</li>`;
  $('#timeModal ul').html(html);

  // Position
  let offset = $btn.offset();
  let left = offset.left + $btn.outerWidth()/2 - 105; // Centered (210px wide)
  let top = offset.top + $btn.outerHeight() + 2;
  if ($(window).width() < 500) {
    left = "50%"; top = $(window).scrollTop() + $(window).height() * 0.22;
    $('#timeModal').css({ left: left, top: top, transform: "translate(-50%,0)" });
  } else {
    $('#timeModal').css({ left: left, top: top, transform: "none" });
  }
  $('#timeModalBackdrop').show().data('targetBtn', $btn);
});

// When time selected
$('#timeModal').off("click", "li").on("click", "li", function(){
  let $btn = $('#timeModalBackdrop').data('targetBtn');
  $btn.text($(this).text()).addClass('selected');
  $('#timeModalBackdrop').hide();
});

// Reuse your calendar modal logic for Done button (already sets button text and adds .selected)
// If you want to distinguish between Add Time and Merge calendar targets, you can check which button was last clicked.

