let startDate = new Date();
startDate.setHours(0,0,0,0);
// Always set to Monday of current week
startDate.setDate(startDate.getDate() - ((startDate.getDay() + 6) % 7));

// ====== DATE RANGE ======
function getDateRangeText2(startDate) {
  let endDate = new Date(startDate);
  endDate.setDate(endDate.getDate() + 6);
  let opts = { month: 'long' };
  let m1 = startDate.toLocaleString('default', opts);
  let d1 = startDate.getDate();
  let m2 = endDate.toLocaleString('default', opts);
  let d2 = endDate.getDate();
  let y = startDate.getFullYear();
  if (m1 !== m2) return `${m1} ${d1} - ${m2} ${d2}, ${y}`;
  return `${m1} ${d1} - ${d2}, ${y}`;
}

function renderTopbarRange() {
  $('#calendar-range').text(getDateRangeText2(startDate));
}

// ====== WEEK NAVIGATION ======
function prevWeek() { startDate.setDate(startDate.getDate() - 7); updateCalendar(); }
function nextWeek() { startDate.setDate(startDate.getDate() + 7); updateCalendar(); }
function goToday() { startDate = new Date(); updateCalendar(); }

// ====== TAB SWITCHING ======
function switchTab(tab) {
  if (tab === 'agenda') {
    $('#agenda-btn').addClass('active');
    $('#semana-btn').removeClass('active');
    $('#calendar-grid-wrapper').hide();
    $('#agendaList').show();
  } else {
    $('#agenda-btn').removeClass('active');
    $('#semana-btn').addClass('active');
    $('#calendar-grid-wrapper').show();
    $('#agendaList').hide();
  }
}

// ====== UPDATE CALENDAR ======
function updateCalendar() {
  renderTopbarRange();
  // no hours, days, or grid rendering
}

// ====== DROPDOWN HELPERS ======
function closeAllDropdowns() { $('.dropdown-menu, .profile-menu').hide(); }
function showDropdownMenu($trigger, $dropdown) {
  closeAllDropdowns();
  let offset = $trigger.offset();
  let height = $trigger.outerHeight();
  $dropdown.css({
    display: 'block',
    top: offset.top + height + 4,
    left: offset.left
  });
}

// ====== DOCUMENT READY ======
$(function(){
  updateCalendar();
  $('#agendaList').hide();

  // Dropdown actions
  $('#cohort-select').click(function(e){
    e.stopPropagation();
    showDropdownMenu($(this), $('#cohort-dropdown'));
    $('#profile-dropdown').hide();
  });
  $('#profile-dropdown-trigger').click(function(e){
    e.stopPropagation();
    showDropdownMenu($(this), $('#profile-dropdown'));
    $('#cohort-dropdown').hide();
  });
  
  $(document).click(function(){ closeAllDropdowns(); });
  $('.dropdown-menu, .profile-menu').click(function(e){ e.stopPropagation(); });

  $('#select-all-cohorts').on('change', function(){
    $(this).closest('form').find('input[type="checkbox"]').not(this).prop('checked', this.checked);
  });

  $('.profile-option').on('click', function(){
    let img = $(this).find('img').attr('src');
    let name = $(this).find('.profile-option-header').text().trim();
    $('#profile-dropdown-trigger .profile-pic').attr('src', img);
    $('#profile-dropdown-trigger').contents().filter(function(){ return this.nodeType == 3; }).remove();
    $('#profile-dropdown-trigger').append(document.createTextNode(' ' + name));
    $('#profile-dropdown').hide();
  });

  // Tabs
  $('#agenda-btn').click(() => switchTab('agenda'));
  $('#semana-btn').click(() => switchTab('semana'));

  // Navigation
  $('#prev-week').click(() => prevWeek());
  $('#next-week').click(() => nextWeek());
  $('#today-btn').click(() => goToday());
});
