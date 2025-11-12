function openDropdownToBody(wrapperSelector, listSelector) {
  var $wrapper = $(wrapperSelector);
  var $list = $(listSelector);

  // Find position and size
  var offset = $wrapper.offset();
  var width = $wrapper.outerWidth();
  var height = $wrapper.outerHeight();

  // Move the list to body
  $list.appendTo('body').css({
    display: 'block',
    position: 'absolute',
    top: offset.top + height + 4,
    left: offset.left,
    width: width,
    zIndex: 99999
  });
  $wrapper.addClass('custom-dropdown-open');

  // Outside click closes dropdown
  $(document).on('mousedown.dropdown', function(e) {
    if (!$(e.target).closest(listSelector + ', ' + wrapperSelector).length) {
      closeDropdownToBody(wrapperSelector, listSelector);
    }
  });
}

function closeDropdownToBody(wrapperSelector, listSelector) {
  var $wrapper = $(wrapperSelector);
  var $list = $(listSelector);

  $wrapper.removeClass('custom-dropdown-open');
  $list.css({
    display: 'none',
    position: '',
    top: '',
    left: '',
    width: '',
    zIndex: ''
  });
  $list.appendTo($wrapper); // Move back into original wrapper
  $(document).off('mousedown.dropdown');
}

$(function() {
  // --- DROPDOWNS ---

  // Topic dropdown open/close
  $('#topicDropdownSelected').on('click', function(e) {
    if ($('#topicDropdownWrapper').hasClass('custom-dropdown-open')) {
      closeDropdownToBody('#topicDropdownWrapper', '#topicDropdownList');
    } else {
      openDropdownToBody('#topicDropdownWrapper', '#topicDropdownList');
    }
    e.stopPropagation();
  });

  // Topic item select
  $('#topicDropdownList').on('click', '.dropdown-item', function() {
    $('#topicDropdownText').text($(this).text());
    closeDropdownToBody('#topicDropdownWrapper', '#topicDropdownList');
  });

  // Topic create
  $('#createTopicBtn').on('click', function() {
    var val = $('#newTopicInput').val().trim();
    if(val) {
      $('#topicDropdownText').text(val);
      $('#newTopicInput').val('');
      closeDropdownToBody('#topicDropdownWrapper', '#topicDropdownList');
    }
  });

  // Assignment dropdown open/close
  $('#assignmentDropdownSelected').on('click', function(e) {
    if ($('#assignmentDropdownWrapper').hasClass('custom-dropdown-open')) {
      closeDropdownToBody('#assignmentDropdownWrapper', '#assignmentDropdownList');
    } else {
      openDropdownToBody('#assignmentDropdownWrapper', '#assignmentDropdownList');
    }
    e.stopPropagation();
  });

  // Accordion logic for Topic dropdown
  $('#topicDropdownList').on('click', '.accordion-toggle', function() {
    var acc = $(this).data('acc');
    $('#topicDropdownList .dropdown-group-label').not(this).parent().removeClass('open');
    $('#topicDropdownList .dropdown-items').not('[data-acc="'+acc+'"]').slideUp(120);
    var $group = $(this).parent();
    var $items = $group.find('.dropdown-items');
    if ($group.hasClass('open')) {
      $group.removeClass('open');
      $items.slideUp(120);
    } else {
      $group.addClass('open');
      $items.slideDown(140);
    }
  });

  // Accordion logic for Assignment dropdown
  $('#assignmentDropdownList').on('click', '.accordion-toggle', function() {
    var acc = $(this).data('acc');
    $('#assignmentDropdownList .dropdown-group-label').not(this).parent().removeClass('open');
    $('#assignmentDropdownList .dropdown-items').not('[data-acc="'+acc+'"]').slideUp(120);
    var $group = $(this).parent();
    var $items = $group.find('.dropdown-items');
    if ($group.hasClass('open')) {
      $group.removeClass('open');
      $items.slideUp(120);
    } else {
      $group.addClass('open');
      $items.slideDown(140);
    }
  });

  // --- MULTI-CHIP LOGIC (NEW) ---
  // Make sure you have: <div id="selectedAssignmentChipList" style="margin-top:10px;"></div> in your HTML

function addAssignmentChip() {
  var assignment = $('#assignmentDropdownText').text().trim();
  var startDate = $('#startcal-open-btn').val().trim();
  var dueDate = $('#duecal-open-btn').val().trim();

  // Time values
  var startHour = $('#startcal-hour').val();
  var startMin = $('#startcal-minute').val();
  var startAmPm = $('#startcal-ampm').val();

  var dueHour = $('#duecal-hour').val();
  var dueMin = $('#duecal-minute').val();
  var dueAmPm = $('#duecal-ampm').val();

  var startTime = `${startHour}:${startMin} ${startAmPm}`;
  var dueTime = `${dueHour}:${dueMin} ${dueAmPm}`;

  var fullStart = `${startDate} ${startTime}`;
  var fullDue = `${dueDate} ${dueTime}`;

  // Get group label (like "Homework")
  var $selectedItem = $('#assignmentDropdownList .dropdown-item').filter(function () {
    return $(this).text().trim() === assignment;
  });

  var label = '';
  if ($selectedItem.length) {
    label = $selectedItem.closest('.dropdown-group').find('.dropdown-group-label span').first().text().trim();
  }

  if (assignment !== '' && assignment !== 'Assignment' && startDate && dueDate) {
    var key = label + "|" + assignment + "|" + fullStart + "|" + fullDue;

    var alreadyExists = $('#selectedAssignmentChipList .assignment-chip').filter(function () {
      return $(this).data('chipKey') === key;
    }).length > 0;

    if (!alreadyExists) {
      var chipHtml =
        `<div class="custom-chip-bar assignment-chip" data-chip-key="${key}" style="margin-bottom: 8px;">
          <span class="chip-left" style="font-size:12px;">
            <span class="chip-label">${label ? label : ''}</span>
            <span class="chip-assignment"> ${assignment}:</span>
          </span>
          <div class="chip-details">
            <div style="display: flex; gap: 16px; font-size: 0.78rem; color: #888; ">
              <span style="margin-left: 30px;"><strong>Start Date</strong></span>
              <span style="margin-left:95px;"><strong>Due On</strong></span>
            </div>
            <div style="display: flex; gap: 16px; font-size: 0.9rem; color: #111;font-size:10px;">
              <span>${fullStart}</span>
              <span>–</span>
              <span>${fullDue}</span>
            </div>
          </div>
          <span class="chip-remove" title="Remove" style="margin-left: 12px; cursor: pointer;">&#10005;</span>
        </div>`;

      $('#selectedAssignmentChipList').append(chipHtml);
    }
  }
}








  // Remove individual chip (event delegation)
  $(document).on('click', '.chip-remove', function() {
    $(this).closest('.assignment-chip').remove();
  });










  // Assignment dropdown select: (NO CHIP added here! just update text)
  $('#assignmentDropdownList').on('click', '.dropdown-item', function() {
    $('#assignmentDropdownText').text($(this).text());
    closeDropdownToBody('#assignmentDropdownWrapper', '#assignmentDropdownList');
    // No chip added here
  });



















$(function () {
  let startDate = new Date(2024, 9, 1);
  let tempStart = new Date(startDate);
  let mStart = tempStart.getMonth();
  let yStart = tempStart.getFullYear();

  function renderStartCal(m, y, selected) {
    $('#startcal-monthyear').text(new Date(y, m).toLocaleString('default', { month: 'long', year: 'numeric' }));
    let f = new Date(y, m, 1), l = new Date(y, m + 1, 0);
    let days = l.getDate(), d = (f.getDay() + 6) % 7, html = '', today = new Date();

    for (let r = 0, day = 1; r < 6; r++) {
      for (let c = 0; c < 7; c++) {
        if (r === 0 && c < d || day > days) html += `<span class="supercal-date disabled"></span>`;
        else {
          let s = selected && day === selected.getDate() && m === selected.getMonth() && y === selected.getFullYear();
          let t = (m === today.getMonth() && y === today.getFullYear() && day === today.getDate());
          html += `<span class="supercal-date${s ? ' selected' : ''}${t ? ' today' : ''}" data-date="${y}-${m + 1}-${day}">${day}</span>`;
          day++;
        }
      }
    }
    $('#startcal-dates').html(html);
  }

  function populateStartTime() {
    for (let h = 1; h <= 12; h++) $('#startcal-hour').append(`<option>${h.toString().padStart(2, '0')}</option>`);
    for (let m = 0; m < 60; m += 5) $('#startcal-minute').append(`<option>${m.toString().padStart(2, '0')}</option>`);
    $('#startcal-ampm').append(`<option>AM</option><option>PM</option>`);
  }

  $('#startcal-open-btn').click(() => {
    tempStart = new Date(startDate);
    mStart = tempStart.getMonth();
    yStart = tempStart.getFullYear();
    renderStartCal(mStart, yStart, tempStart);
    populateStartTime();
    $('#startcal-backdrop, #startcal-modal').fadeIn(120);
  });

  $('#startcal-prev-month').click(() => {
    mStart--; if (mStart < 0) { mStart = 11; yStart--; }
    renderStartCal(mStart, yStart, tempStart);
  });

  $('#startcal-next-month').click(() => {
    mStart++; if (mStart > 11) { mStart = 0; yStart++; }
    renderStartCal(mStart, yStart, tempStart);
  });

  $('#startcal-dates').on('click', '.supercal-date:not(.disabled)', function () {
    $('#startcal-dates .supercal-date').removeClass('selected');
    $(this).addClass('selected');
    let [y, m, d] = $(this).data('date').split('-');
    tempStart = new Date(y, m - 1, d);
  });

  $('#startcal-done-btn').click(() => {
    startDate = new Date(tempStart);
    $('#startcal-open-btn').val(startDate.toDateString());
    $('#startcal-backdrop, #startcal-modal').fadeOut(120);
  });

  $('#startcal-close-btn, #startcal-backdrop').click(() => $('#startcal-backdrop, #startcal-modal').fadeOut(120));
});















$(function () {
  let dueDate = new Date(2024, 9, 1);
  let tempDue = new Date(dueDate);
  let mDue = tempDue.getMonth();
  let yDue = tempDue.getFullYear();

  function renderDueCal(m, y, selected) {
    $('#duecal-monthyear').text(new Date(y, m).toLocaleString('default', { month: 'long', year: 'numeric' }));
    let f = new Date(y, m, 1), l = new Date(y, m + 1, 0);
    let days = l.getDate(), d = (f.getDay() + 6) % 7, html = '', today = new Date();

    for (let r = 0, day = 1; r < 6; r++) {
      for (let c = 0; c < 7; c++) {
        if (r === 0 && c < d || day > days) html += `<span class="supercal-date disabled"></span>`;
        else {
          let s = selected && day === selected.getDate() && m === selected.getMonth() && y === selected.getFullYear();
          let t = (m === today.getMonth() && y === today.getFullYear() && day === today.getDate());
          html += `<span class="supercal-date${s ? ' selected' : ''}${t ? ' today' : ''}" data-date="${y}-${m + 1}-${day}">${day}</span>`;
          day++;
        }
      }
    }
    $('#duecal-dates').html(html);
  }

  function populateDueTime() {
    $('#duecal-hour, #duecal-minute, #duecal-ampm').empty();
    for (let h = 1; h <= 12; h++) $('#duecal-hour').append(`<option>${h.toString().padStart(2, '0')}</option>`);
    for (let m = 0; m < 60; m += 5) $('#duecal-minute').append(`<option>${m.toString().padStart(2, '0')}</option>`);
    $('#duecal-ampm').append(`<option>AM</option><option>PM</option>`);
  }

  $('#duecal-open-btn').click(function () {
    tempDue = new Date(dueDate);
    mDue = tempDue.getMonth();
    yDue = tempDue.getFullYear();
    renderDueCal(mDue, yDue, tempDue);
    populateDueTime();
    $('#duecal-backdrop, #duecal-modal').fadeIn(120);
  });

  $('#duecal-prev-month').click(function () {
    mDue--;
    if (mDue < 0) { mDue = 11; yDue--; }
    renderDueCal(mDue, yDue, tempDue);
  });

  $('#duecal-next-month').click(function () {
    mDue++;
    if (mDue > 11) { mDue = 0; yDue++; }
    renderDueCal(mDue, yDue, tempDue);
  });

  $('#duecal-dates').on('click', '.supercal-date:not(.disabled)', function () {
    $('#duecal-dates .supercal-date').removeClass('selected');
    $(this).addClass('selected');
    let [y, m, d] = $(this).data('date').split('-');
    tempDue = new Date(y, m - 1, d);
  });

  $('#duecal-done-btn').click(function () {
    dueDate = new Date(tempDue);
    $('#duecal-open-btn').val(dueDate.toDateString());

    // ✅ Add chip below
    if (typeof addAssignmentChip === 'function') {
      addAssignmentChip('#duecal-open-btn');
    }

    // ✅ Close modal
    $('#duecal-backdrop, #duecal-modal').fadeOut(120);
  });

  $('#duecal-close-btn, #duecal-backdrop').click(function () {
    $('#duecal-backdrop, #duecal-modal').fadeOut(120);
  });

  $(document).on('keydown', function (e) {
    if (e.key === "Escape") {
      $('#duecal-backdrop, #duecal-modal').fadeOut(120);
    }
  });
});

























  // NOTE: If you want to use this dropdown elsewhere, change IDs to classes!

// Show/hide student/group dropdown on note-link click
$('.note-link').on('click', function() {
  // Toggle note-area as before
  // Show/hide the note dropdown
  if($('#noteDropdownWrapper').is(':visible')) {
    $('#noteDropdownWrapper').slideUp(110);
    closeDropdownToBody('#noteDropdownWrapper', '#noteDropdownList');
  } else {
    
        $('.note-textarea').slideDown(140);
    $('#noteDropdownWrapper').slideDown(140);

  }
});

// Open/close logic for custom dropdown (select field)
$('#noteDropdownSelected').on('click', function(e) {
  if ($('#noteDropdownWrapper').hasClass('custom-dropdown-open')) {
    closeDropdownToBody('#noteDropdownWrapper', '#noteDropdownList');
  } else {
    openDropdownToBody('#noteDropdownWrapper', '#noteDropdownList');
    $('#noteDropdownSearch').focus();
  }
  e.stopPropagation();
});

// Item selection
$('#noteDropdownList').on('click', '.dropdown-item', function() {
  var name = $(this).text().trim();
  $('#noteDropdownText').text(name);
  closeDropdownToBody('#noteDropdownWrapper', '#noteDropdownList');
});

// Fuzzy search/filter logic
$('#noteDropdownSearch').on('input', function() {
  var val = $(this).val().toLowerCase();
  $('#noteDropdownItems .dropdown-item').each(function() {
    var txt = $(this).text().toLowerCase();
    $(this).toggle(txt.indexOf(val) !== -1);
  });
});

// Close on outside click (reusing closeDropdownToBody logic)
// Already handled via closeDropdownToBody above




// This will store selected avatar URL and name for the UI
$('#noteDropdownList').on('click', '.dropdown-item', function() {
  // Parse out the avatar and name from dropdown item
  var $item = $(this);
  var avatarSrc = '';
  var name = $item.text().trim();

  // Check if item has image or FL1 (badge)
  var $img = $item.find('img');
  var $badge = $item.find('span.note-avatar');

  if ($img.length) {
    avatarSrc = $img.attr('src');
    $('#noteForAvatar').attr('src', avatarSrc).show();
  } else if ($badge.length) {
    // Render badge as an SVG or fallback img, but for now use a data-uri or blank with initials
    // Here, just set blank src and show the FL1 text in avatar box
    $('#noteForAvatar').attr('src', '').hide(); // Hide for initials only
    $('#noteForAvatar').after('<span id="noteForBadge" class="note-avatar" style="background:#1743e3;margin-left:-39px;margin-top:0;position:relative;z-index:2;">'+$badge.text()+'</span>');
  } else {
    $('#noteForAvatar').attr('src', '').hide();
  }

  $('#noteForName').text(name);
  $('#noteForNameLabel').text(name);

  // Hide dropdown, show note UI
  closeDropdownToBody('#noteDropdownWrapper', '#noteDropdownList');
  $('#noteDropdownWrapper').slideUp(120);
  $('#noteForStudentSection').slideDown(180);

  // Remove any old badge avatars if needed
  $('#noteForAvatar').show();
  $('#noteForBadge').remove();

  // If selected is badge only (no image), swap avatar image for badge text
  if ($img.length === 0 && $badge.length) {
    $('#noteForAvatar').hide();
    $('#noteForBadge').show();
  }
});

// Optional: When you open the note section again, reset the UI
$('.note-link').on('click', function() {
  $('#noteForStudentSection').hide();
  $('#noteForAvatar').attr('src','').show();
  $('#noteForBadge').remove();
  $('#noteTextarea').val('');
});






// Handle note submission (chip add, dropdown reappear)
$('#noteSubmitBtn').on('click', function() {
  var noteText = $('#noteTextarea').val().trim();
  var name = $('#noteForName').text();
  var avatarSrc = $('#noteForAvatar').attr('src');
  var badge = $('#noteForBadge').text() || "";
  if (!noteText) return;

  // Build the chip
  var chipHtml = `<div class="custom-chip-bar note-chip" style="margin-bottom:7px;align-items:center;">
    ${avatarSrc 
      ? `<img src="${avatarSrc}" class="note-avatar" style="width:32px;height:32px;border-radius:9px;object-fit:cover;margin-right:8px;">`
      : badge
        ? `<span class="note-avatar" style="width:32px;height:32px;border-radius:9px;display:inline-flex;align-items:center;justify-content:center;font-size:1rem;background:#1743e3;color:#fff;margin-right:8px;">${badge}</span>`
        : ''
    }
    <span style="font-weight:600;margin-right:7px;">${name}</span>
    <span style="color:#8a8a8a;font-size:1.04rem;flex:1 1 auto;">${noteText}</span>
    <span class="chip-remove" style="font-size:1.43rem;padding:4px 8px 2px 8px;cursor:pointer;">&#10005;</span>
  </div>`;

  $('#noteChipsList').append(chipHtml);

  // Reset and show dropdown again
  $('#noteForStudentSection').hide();
  $('#noteForAvatar').attr('src','').show();
  $('#noteForBadge').remove();
  $('#noteTextarea').val('');
  $('#noteDropdownWrapper').slideDown(120);
});

// Remove chip on close
$(document).on('click', '.note-chip .chip-remove', function() {
  $(this).closest('.note-chip').remove();
});



});






































$(function() {
  // Initial value can be changed as desired
  let currentPercent = 25;

  function renderClassicSlider(percent) {
    let $track = $('.classic-slider-bar-track');
    $track.find('.classic-slider-thumb').remove();

    // Render thumb (no value inside)
    $track.append(`
      <div class="classic-slider-thumb" style="left:calc(${percent}% - 18px);"></div>
    `);

    // Track fill (progress)
    $track.css('background', `linear-gradient(90deg,#FF3B18 0 ${percent}%,#ededed ${percent}% 100%)`);

    // Highlight the closest label
    $('.classic-slider-bar-labels span').removeClass('selected');
    $('.classic-slider-bar-labels span').each(function() {
      let labelVal = parseInt($(this).text().replace('%','').trim());
      if (Math.abs(labelVal - percent) < 2) {
        $(this).addClass('selected');
      }
    });
  }

  function percentFromPageX(pageX) {
    let trackLeft = $('.classic-slider-bar-track').offset().left;
    let w = $('.classic-slider-bar-track').width();
    let rel = (pageX - trackLeft) / w;
    rel = Math.max(0, Math.min(1, rel));
    return rel * 100;
  }

  let dragging = false;
  $(document).on('mousedown touchstart', '.classic-slider-thumb', function(e) {
    dragging = true; e.preventDefault();
  });
  $(document).on('mousemove touchmove', function(e) {
    if (!dragging) return;
    let pageX = e.type === "touchmove" ? e.originalEvent.touches[0].pageX : e.pageX;
    let percent = percentFromPageX(pageX);
    currentPercent = percent;
    renderClassicSlider(currentPercent);
  });
  $(document).on('mouseup touchend', function() { dragging = false; });

  // Click bar to jump to any percent
  $('.classic-slider-bar-track').on('click', function(e) {
    let pageX = e.type === "touchstart" ? e.originalEvent.touches[0].pageX : e.pageX;
    let percent = percentFromPageX(pageX);
    currentPercent = percent;
    renderClassicSlider(currentPercent);
  });

  // Initial render
  renderClassicSlider(currentPercent);
});



















// =========================== progress start===============================//
const subscription_modal_progress_bar_progress = document.querySelector(
  ".subscription_modal_progress_bar_progressShow"
);
const subscription_modal_progress_bar_draggable = subscription_modal_progress_bar_progress.querySelector(
  ".subscription_modal_progress_bar_draggable"
);
const subscription_modal_progress_bar_draggable_percentage_value =
  subscription_modal_progress_bar_draggable.querySelector(
    ".subscription_modal_progress_bar_draggable_percentage_value"
  );
const subscription_modal_progress_bar_completed = document.querySelector(
  ".subscription_modal_progress_bar_completed"
);

let subscription_modal_progress_bar_isDragging = false;

subscription_modal_progress_bar_draggable.addEventListener("mousedown", (event) => {
  subscription_modal_progress_bar_isDragging = true;
  setTimeout(() => {
    subscription_modal_progress_bar_draggable_percentage_value.classList.add("active");
  }, 1000);
  document.addEventListener("mousemove", subscription_modal_progress_bar_onDrag);
  document.addEventListener("mouseup", () => {
    subscription_modal_progress_bar_isDragging = false;
    setTimeout(() => {
      subscription_modal_progress_bar_draggable_percentage_value.classList.remove("active");
    }, 1000);
    document.removeEventListener("mousemove", subscription_modal_progress_bar_onDrag);
  });
});

function subscription_modal_progress_bar_onDrag(event) {
  if (!subscription_modal_progress_bar_isDragging) return;

  let progressRect = subscription_modal_progress_bar_progress.getBoundingClientRect();
  let newLeft = event.clientX - progressRect.left;

  // Ensure the draggable stays within the progress bar
  if (newLeft < 0) newLeft = 0;
  if (newLeft > progressRect.width) newLeft = progressRect.width;

  // Calculate percentage
  let percentage = (newLeft / progressRect.width) * 100;
  percentage = Math.round(percentage);

  if (percentage > 100) percentage = 100;

  let draggableWidth = subscription_modal_progress_bar_draggable.offsetWidth;
  let adjustedLeft = `calc(${percentage}% - ${draggableWidth / 2}px)`;

  subscription_modal_progress_bar_draggable.style.left = adjustedLeft;
  subscription_modal_progress_bar_completed.style.width = `${percentage}%`;
  subscription_modal_progress_bar_draggable_percentage_value.textContent = `${percentage}%`;
}
// =========================== progress end===============================//




























// jQuery for Congratulations Modal
$(function() {
  // On submit button click, show the congrats modal and hide the previous modal
  $('.modal-submit-btn').on('click', function(e) {
    e.preventDefault();
    $('.custom-modal').hide(); // Hides the background modal
    $('#congratsModalBackdrop').fadeIn(120);
    $('#congratsModal').fadeIn(170);
  });

  // Close modal on "Okay" or clicking outside
  $('#congratsOkayBtn, #congratsModalBackdrop').on('click', function() {
    $('#congratsModalBackdrop').fadeOut(120);
    $('#congratsModal').fadeOut(170, function() {
      // Optionally show the previous modal again if needed:
      // $('.custom-modal').show();
    });
  });
});

