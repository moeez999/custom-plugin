
$('.calendar_admin_details_create_cohort_tab').click(function () {
  $('.calendar_admin_details_create_cohort_tab').removeClass('active');
  $(this).addClass('active');
  let tab = $(this).data('tab');
  $('#mainModalContent').toggle(tab === "cohort");
  $('#conferenceTabContent').toggle(tab === "conference");
  $('#peerTalkTabContent').toggle(tab === "peertalk");
  $('#mergeTabContent').toggle(tab === "merge");
  if (!["cohort", "conference", "peertalk", "merge"].includes(tab)){
    $('#mainModalContent, #conferenceTabContent, #peerTalkTabContent, #mergeTabContent').hide();
  }
});

// Dropdown logic
$('#mergeClosingCohortBtn').click(function(e){
  e.stopPropagation();
  $(this).addClass('active');
  $('#mergeClosingCohortList').toggle();
  $('#mergeJoiningCohortList').hide();
});
$('#mergeClosingCohortList li').click(function(e){
  e.stopPropagation();
  $('#mergeClosingCohortSelected').text($(this).text());
  $('#mergeClosingCohortList li').removeClass('selected');
  $(this).addClass('selected');
  $('#mergeClosingCohortList').hide();
  $('#mergeClosingCohortBtn').removeClass('active');
});
$('#mergeJoiningCohortBtn').click(function(e){
  e.stopPropagation();
  $(this).addClass('active');
  $('#mergeJoiningCohortList').toggle();
  $('#mergeClosingCohortList').hide();
});
$('#mergeJoiningCohortList li').click(function(e){
  e.stopPropagation();
  $('#mergeJoiningCohortSelected').text($(this).text());
  $('#mergeJoiningCohortList li').removeClass('selected');
  $(this).addClass('selected');
  $('#mergeJoiningCohortList').hide();
  $('#mergeJoiningCohortBtn').removeClass('active');
});
$(document).click(function(){
  $('#mergeClosingCohortList, #mergeJoiningCohortList').hide();
  $('#mergeClosingCohortBtn, #mergeJoiningCohortBtn').removeClass('active');
});









// Calendar logic
//let mergeDateTargetBtn = null;
// let mergeCalendarMonth = null;
// let mergeSelectedCalendarDate = null;

function mergeDaysInMonth(year, month) {
  return new Date(year, month+1, 0).getDate();
}
// Show modal on button click
$('#mergeClosingDateBtn, #mergeMergingDateBtn').click(function(e){
  e.preventDefault();
  mergeDateTargetBtn = $(this);
  // Show modal
  $('#mergeCalendarModalBackdrop').fadeIn(100);
  // Set calendar month to current or to the already selected date
  let now = new Date();
  mergeCalendarMonth = {year: now.getFullYear(), month: now.getMonth()};
  mergeSelectedCalendarDate = null;
  mergeRenderCalendarModal();
});

// Month navigation
$(document).on('click', '.merge-calendar-prev', function(){
  mergeCalendarMonth.month--;
  if(mergeCalendarMonth.month < 0) {
    mergeCalendarMonth.month = 11; mergeCalendarMonth.year--;
  }
  mergeRenderCalendarModal();
});
$(document).on('click', '.merge-calendar-next', function(){
  mergeCalendarMonth.month++;
  if(mergeCalendarMonth.month > 11) {
    mergeCalendarMonth.month = 0; mergeCalendarMonth.year++;
  }
  mergeRenderCalendarModal();
});

// Day select
$(document).on('click', '.merge-calendar-day', function(){
  $('.merge-calendar-day').removeClass('selected');
  $(this).addClass('selected');
  let day = parseInt($(this).attr('data-day'));
  mergeSelectedCalendarDate = new Date(mergeCalendarMonth.year, mergeCalendarMonth.month, day);
});

// Done button
$('.merge-calendar-done-btn').click(function(){
  if(mergeDateTargetBtn && mergeSelectedCalendarDate){
    let d = mergeSelectedCalendarDate;
    let nice = d.toLocaleDateString('en-GB', { day: '2-digit', month:'short', year:'numeric' });
    mergeDateTargetBtn.text(nice).addClass('selected');
    $('#mergeCalendarModalBackdrop').fadeOut(120);
    mergeDateTargetBtn = null;
  }
});

// Click outside modal closes it
$('#mergeCalendarModalBackdrop').click(function(e){
  if(e.target === this) $(this).fadeOut(120);
});


// Render function
function mergeRenderCalendarModal(){
  const monthNames = ["January","February","March","April","May","June","July","August","September","October","November","December"];
  let y = mergeCalendarMonth.year, m = mergeCalendarMonth.month;
  $('#mergeCalendarMonth').text(`${monthNames[m]} ${y}`);
  let html = '';
  let dayHeaders = ['Mo','Tu','We','Th','Fr','Sa','Su'];
  for(let d=0;d<7;d++) html += `<div class="merge-calendar-day-header">${dayHeaders[d]}</div>`;
  let firstDay = new Date(y,m,1).getDay(); firstDay = (firstDay+6)%7;
  let totalDays = mergeDaysInMonth(y,m);
  let prevMonthDays = firstDay;
  let day = 1;
  for(let i=0;i<prevMonthDays;i++) html += `<div class="merge-calendar-day-inactive"></div>`;
  for(let d=1; d<=totalDays; d++){
    let sel = mergeSelectedCalendarDate &&
      mergeSelectedCalendarDate.getFullYear() === y &&
      mergeSelectedCalendarDate.getMonth() === m &&
      mergeSelectedCalendarDate.getDate() === d ? ' selected' : '';
    html += `<div class="merge-calendar-day${sel}" data-day="${d}">${d}</div>`;
    day++;
  }
  let rem = (prevMonthDays + totalDays)%7;
  if(rem>0) for(let i=rem;i<7;i++) html += `<div class="merge-calendar-day-inactive"></div>`;
  $('.merge-calendar-days').html(html);
}







