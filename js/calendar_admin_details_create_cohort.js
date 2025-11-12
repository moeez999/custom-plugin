// ================= Tooltips =================
$('.cohort-tooltip-target').on('mouseenter focus', function() {
  var tid = $(this).attr('id') === 'cohortInput' ? '#tooltip-cohort' : '#tooltip-cohortshort';
  $(tid).fadeIn(100);
});
$('.cohort-tooltip-target').on('mouseleave blur', function() {
  var tid = $(this).attr('id') === 'cohortInput' ? '#tooltip-cohort' : '#tooltip-cohortshort';
  $(tid).fadeOut(100);
});


//============ Time dropdowns (LEFT) =============//
const times = [
  "05:30 PM","06:00 PM","06:30 PM","07:00 PM","07:30 PM",
  "08:00 PM","08:30 PM","09:00 PM","09:30 PM","10:00 PM",
  "10:30 PM","11:00 PM","11:30 PM","12:00 PM","12:30 PM","13:00 PM"
];

// ---- Google Calendar-style normalizer: 24h -> "HH:MM AM/PM"
function normalizeTimeTo12h(inputRaw){
  if(!inputRaw) return null;
  let s = String(inputRaw).trim().toLowerCase();

  // keep explicit am/pm, but standardize
  let ampmMatch = s.match(/(am|pm)$/);
  let explicit = ampmMatch ? ampmMatch[1] : null;
  if(explicit){ s = s.slice(0, -2); } // strip am/pm for parsing

  s = s.replace(/\s+/g,'');     // remove spaces
  s = s.replace('.',':');       // allow "7.30" -> "7:30"

  let hStr, mStr;
  if(s.includes(':')){
    [hStr, mStr] = s.split(':');
  } else if(/^\d+$/.test(s)){
    // "7" -> 7:00, "730"/"0730" -> 7:30, "1330" -> 13:30
    if(s.length <= 2){ hStr = s; mStr = '00'; }
    else { hStr = s.slice(0, s.length-2); mStr = s.slice(-2); }
  } else {
    return null;
  }

  let h = parseInt(hStr, 10);
  let m = parseInt(mStr || '0', 10);
  if(isNaN(h) || isNaN(m) || h < 0 || m < 0 || m > 59) return null;

  // Resolve AM/PM
  let ampm;
  if(explicit){
    ampm = explicit.toUpperCase();
    if(h === 0) h = 12;                 // "0am" => 12 AM
    if(h < 1 || h > 12) return null;    // invalid in explicit 12h
  } else {
    if(h > 23) return null;             // invalid 24h
    if(h === 0){ ampm = 'AM'; h = 12; }
    else if(h === 12){ ampm = 'PM'; }
    else if(h > 12){ ampm = 'PM'; h = h - 12; }
    else { ampm = 'AM'; }
  }

  const hh = (h < 10 ? '0' : '') + h;
  const mm = (m < 10 ? '0' : '') + m;
  return `${hh}:${mm} ${ampm}`;
}

// Render dropdown for a pill with a given filter + smart suggestion
function renderDropdown($dropdown, filterVal='') {
  $dropdown.empty();
  let filter = (filterVal && filterVal.trim().length > 0) ? filterVal.trim() : "";
  let filtered = filter ? times.filter(t =>
    t.toLowerCase().includes(filter.toLowerCase())
  ) : times.slice(); // if filter empty, show all

  // Smart suggestion based on 24h typed input
  const suggestion = normalizeTimeTo12h(filter);
  if(filter && suggestion && !filtered.some(t => t.toLowerCase() === suggestion.toLowerCase())){
    $dropdown.append('<div class="dropdown-item suggestion">'+suggestion+'</div>');
  }

  if(filtered.length === 0 && !suggestion){
    $dropdown.append('<div class="no-matches">No matches</div>');
    return;
  }
  filtered.forEach(t => {
    $dropdown.append('<div class="dropdown-item">'+t+'</div>');
  });
}

// Show dropdown and enable editing (LEFT)
$(document).on('click focus', '.custom-time-pill .time-input', function(e){
  let $pill = $(this).closest('.custom-time-pill');
  $('.custom-time-pill').not($pill).removeClass('active').find('.custom-time-dropdown').hide();
  $pill.addClass('active');
  $(this).removeAttr('readonly');
  let $dropdown = $pill.find('.custom-time-dropdown');
  renderDropdown($dropdown, ''); // show all times by default
  $dropdown.show();
  // place cursor at end
  let val = $(this).val(); this.value = ''; this.value = val;
  e.stopPropagation();
});

// Filter dropdown on input (LEFT)
$(document).on('input', '.custom-time-pill .time-input', function() {
  let $pill = $(this).closest('.custom-time-pill');
  let $dropdown = $pill.find('.custom-time-dropdown');
  renderDropdown($dropdown, $(this).val());
  $dropdown.show();
});

// Dropdown click: select time (LEFT)
$(document).on('mousedown', '.custom-time-dropdown .dropdown-item', function(e){
  let val = $(this).text();
  let $pill = $(this).closest('.custom-time-pill');
  $pill.find('.time-input').val(val);
  $pill.removeClass('active');
  $pill.find('.custom-time-dropdown').hide();
});

// Hide all dropdowns on outside click (LEFT)
$(document).on('mousedown', function(e){
  if (!$(e.target).closest('.custom-time-pill').length) {
    $('.custom-time-pill').removeClass('active');
    $('.custom-time-dropdown').hide();
    $('.time-input').attr('readonly', true);
  }
});

// Hide dropdown on blur (LEFT) (unless dropdown is active)
$(document).on('blur', '.custom-time-pill .time-input', function(){
  setTimeout(() => {
    if (!$(document.activeElement).closest('.custom-time-dropdown').length) {
      $('.custom-time-pill').removeClass('active');
      $('.custom-time-dropdown').hide();
      $('.time-input').attr('readonly', true);
    }
  }, 120);
});


//================== Time dropdowns (RIGHT SIDE OF MODAL) ===============================//
const rightTimes = [
  "05:30 PM","06:00 PM","06:30 PM","07:00 PM","07:30 PM",
  "08:00 PM","08:30 PM","09:00 PM","09:30 PM","10:00 PM",
  "10:30 PM","11:00 PM","11:30 PM","12:00 PM","12:30 PM","13:00 PM"
];

// Render dropdown (RIGHT) + smart suggestion
function renderRightDropdown($dropdown, filterVal='') {
  $dropdown.empty();
  let filter = (filterVal && filterVal.trim().length > 0) ? filterVal.trim() : "";
  let filtered = filter ? rightTimes.filter(t =>
    t.toLowerCase().includes(filter.toLowerCase())
  ) : rightTimes.slice();

  const suggestion = normalizeTimeTo12h(filter);
  if(filter && suggestion && !filtered.some(t => t.toLowerCase() === suggestion.toLowerCase())){
    $dropdown.append('<div class="dropdown-item suggestion">'+suggestion+'</div>');
  }

  if(filtered.length === 0 && !suggestion){
    $dropdown.append('<div class="no-matches">No matches</div>');
    return;
  }
  filtered.forEach(t => {
    $dropdown.append('<div class="dropdown-item">'+t+'</div>');
  });
}

// Show dropdown and enable editing (RIGHT)
$(document).on('click focus', '.calendar_admin_details_time_right_time-pill .calendar_admin_details_time_right_time-input', function(e){
  let $pill = $(this).closest('.calendar_admin_details_time_right_time-pill');
  $('.calendar_admin_details_time_right_time-pill').not($pill).removeClass('active').find('.calendar_admin_details_time_right_time-dropdown').hide();
  $pill.addClass('active');
  $(this).removeAttr('readonly');
  let $dropdown = $pill.find('.calendar_admin_details_time_right_time-dropdown');
  renderRightDropdown($dropdown, '');
  $dropdown.show();
  let val = $(this).val(); this.value = ''; this.value = val;
  e.stopPropagation();
});

// Filter dropdown on input (RIGHT)
$(document).on('input', '.calendar_admin_details_time_right_time-pill .calendar_admin_details_time_right_time-input', function() {
  let $pill = $(this).closest('.calendar_admin_details_time_right_time-pill');
  let $dropdown = $pill.find('.calendar_admin_details_time_right_time-dropdown');
  renderRightDropdown($dropdown, $(this).val());
  $dropdown.show();
});

// Dropdown click: select time (RIGHT)
$(document).on('mousedown', '.calendar_admin_details_time_right_time-dropdown .dropdown-item', function(e){
  let val = $(this).text();
  let $pill = $(this).closest('.calendar_admin_details_time_right_time-pill');
  $pill.find('.calendar_admin_details_time_right_time-input').val(val);
  $pill.removeClass('active');
  $pill.find('.calendar_admin_details_time_right_time-dropdown').hide();
});

// Hide all dropdowns on outside click (RIGHT)
$(document).on('mousedown', function(e){
  if (!$(e.target).closest('.calendar_admin_details_time_right_time-pill').length) {
    $('.calendar_admin_details_time_right_time-pill').removeClass('active');
    $('.calendar_admin_details_time_right_time-dropdown').hide();
    $('.calendar_admin_details_time_right_time-input').attr('readonly', true);
  }
});

// Hide dropdown on blur (RIGHT) (unless dropdown is active)
$(document).on('blur', '.calendar_admin_details_time_right_time-pill .calendar_admin_details_time_right_time-input', function(){
  setTimeout(() => {
    if (!$(document.activeElement).closest('.calendar_admin_details_time_right_time-dropdown').length) {
      $('.calendar_admin_details_time_right_time-pill').removeClass('active');
      $('.calendar_admin_details_time_right_time-dropdown').hide();
      $('.calendar_admin_details_time_right_time-input').attr('readonly', true);
    }
  }, 120);
});


//================== Commit typed time like Google Calendar (BOTH SIDES) ==================//
const TIME_INPUTS = '.custom-time-pill .time-input, .calendar_admin_details_time_right_time-pill .calendar_admin_details_time_right_time-input';

// Commit with Enter
$(document).on('keydown', TIME_INPUTS, function(e){
  if(e.key === 'Enter'){
    e.preventDefault();
    const norm = normalizeTimeTo12h($(this).val());
    if(norm){ $(this).val(norm); }
    // close its dropdown
    const $leftPill  = $(this).closest('.custom-time-pill');
    const $rightPill = $(this).closest('.calendar_admin_details_time_right_time-pill');
    $leftPill.removeClass('active').find('.custom-time-dropdown').hide();
    $rightPill.removeClass('active').find('.calendar_admin_details_time_right_time-dropdown').hide();
    $(this).attr('readonly', true).blur();
  }
});

// Commit on blur as well
$(document).on('blur', TIME_INPUTS, function(){
  const norm = normalizeTimeTo12h($(this).val());
  if(norm){ $(this).val(norm); }
});
