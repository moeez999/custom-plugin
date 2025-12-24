  
$(function(){
      // Schedule dropdown
      $('#my_lessons_schedule_btn').on('click', function(e){
        e.stopPropagation();
        $('#my_lessons_schedule_menu').toggle();
      });
      $(document).on('click', function(){
        $('#my_lessons_schedule_menu').hide();
      });
      $('.my_lessons_schedule_option').on('click', function(){
        var type = $(this).data('type');
        console.log('Selected schedule type:', type);
        $('#my_lessons_schedule_menu').hide();
      });

      // Tab switching
      $('#my_lessons_tabs .my_lessons_tab_item').on('click', function(){
        var tgt = $(this).data('target');
        $('.my_lessons_tab_item').removeClass('active');
        $(this).addClass('active');
        $('.my_lessons_tab_content').hide();
        $(tgt).show();
      });

      // 3-dot menu in Lessons tab
      $('.my_lessons_lesson_card .my_lessons_menu_icon').on('click', function(e){

        e.stopPropagation();
        // hide any open menus
        $('.my_lessons_card_menu').hide();
        // show this card’s menu
        $(this).closest('.my_lessons_lesson_card').find('.my_lessons_card_menu').show();
      });
      // click outside closes menus
      $(document).on('click', function(){
        $('.my_lessons_card_menu').hide();
      });
      // menu actions
      $('.my_lessons_card_menu li').on('click', function(){
        var action = $(this).text().trim();
        console.log('Lesson action:', action);
        $(this).closest('.my_lessons_card_menu').hide();
      });
    });



$(document).ready(function () {
  // Helper: get Monday of the week
  function getMonday(d) {
    d = new Date(d);
    var day = d.getDay(),
      diff = d.getDate() - day + (day === 0 ? -6 : 1);
    d.setDate(diff);
    d.setHours(0,0,0,0);
    return d;
  }

  // Global State
  var today = new Date();
  today.setHours(0,0,0,0);
  var currentMonday = getMonday(today);

  function pad(num) {
    return num < 10 ? '0' + num : num;
  }

  function renderWeek(startDate) {
    var days = [];
    for (let i = 0; i < 7; i++) {
      let d = new Date(startDate);
      d.setDate(startDate.getDate() + i);
      days.push(d);
    }

    // Update week range at the top
    let rangeStr = days[0].toLocaleString('default', { month: 'long', day: '2-digit' }) +
      '–' + (days[6].getDate().toString().padStart(2, '0')) + ', ' + days[6].getFullYear();
    $('.my_lessons_calendar_date').text(rangeStr);

    // Update headers
    $('.calendar-day-header').each(function (i) {
      var day = days[i];
      var name = ['Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat', 'Sun'][i];
      var label = name + ' ' + day.getDate();
      $(this).text(label);
      $(this).attr('data-date', day.toISOString().slice(0, 10));
      $(this).find('.my_lessons_today_line').remove();
      $(this).css('position', '');
    });

    // Remove all previous lines and highlights
    $('.calendar-day-header, tbody tr td').removeClass('highlight-today');
    $('.my_lessons_today_line').remove();

    // Find which column is today
    var todayCol = -1;
    var currentRealToday = new Date();
    currentRealToday.setHours(0,0,0,0);
    days.forEach(function (day, i) {
      if (day.toDateString() === currentRealToday.toDateString()) {
        todayCol = i;
      }
    });

    // If today is in view, highlight header and cells
    if (todayCol !== -1) {
      $('.calendar-day-header').eq(todayCol).addClass('highlight-today');
      $('tbody tr').each(function () {
        var $tds = $(this).find('td');
        if ($tds.length === 1) {
          // Only one cell, highlight it (for colspan=7)
          $tds.addClass('highlight-today');
        } else if ($tds.length > todayCol) {
          $tds.eq(todayCol).addClass('highlight-today');
        }
      });

      // -- CURRENT TIME LINE LOGIC --
      var now = new Date();
      var nowMinutes = now.getHours() * 60 + now.getMinutes();

      var $rows = $('.my_lessons_calendar_table tbody tr');
      var placed = false;

      $rows.each(function (rowIdx) {
        var $th = $(this).find('th').first();
        var startTime = $th.text().trim();

        // Parse time (assume format "6:00" or "07:00")
        var match = startTime.match(/^(\d{1,2}):(\d{2})$/);
        if (!match) return;

        var startHour = parseInt(match[1], 10);
        var startMin = parseInt(match[2], 10);
        var startTotal = startHour * 60 + startMin;

        // Find next row time
        var $nextRow = $rows.eq(rowIdx + 1);
        var nextTime = $nextRow.length ? $nextRow.find('th').first().text().trim() : null;
        var endTotal;
        if (nextTime) {
          var nextMatch = nextTime.match(/^(\d{1,2}):(\d{2})$/);
          if (nextMatch) {
            endTotal = parseInt(nextMatch[1], 10) * 60 + parseInt(nextMatch[2], 10);
          } else {
            endTotal = startTotal + 60; // fallback: next hour
          }
        } else {
          endTotal = startTotal + 60; // fallback: next hour
        }

        // Is now between this and next?
        if (nowMinutes >= startTotal && nowMinutes < endTotal && !placed) {
          // Always use the correct TD:
          var $tds = $(this).find('td');
          var $cell;
          if ($tds.length === 1) {
            // Only one cell: colspan=7
            $cell = $tds.first();
          } else if ($tds.length > todayCol) {
            // Multiple columns, use today's column
            $cell = $tds.eq(todayCol);
          }
          if ($cell && $cell.length) {
            var rowHeight = $cell.outerHeight();
            var fraction = (nowMinutes - startTotal) / (endTotal - startTotal);
            var topOffset = rowHeight * fraction;

            $cell.css('position', 'relative');
            $cell.append(`
              <div class="my_lessons_today_line" style="top:${topOffset}px;">
                <span class="my_lessons_today_line_dot"></span>
                <span class="my_lessons_today_line_bar"></span>
              </div>
            `);
            placed = true;
          }
        }
      });

      // If before the first slot, put at top of first cell
      if (!placed && $rows.length > 0) {
        var $firstRowTds = $rows.first().find('td');
        var $firstCell;
        if ($firstRowTds.length === 1) {
          $firstCell = $firstRowTds.first();
        } else if ($firstRowTds.length > todayCol) {
          $firstCell = $firstRowTds.eq(todayCol);
        }
        if ($firstCell && $firstCell.length) {
          $firstCell.css('position', 'relative');
          $firstCell.append(`
            <div class="my_lessons_today_line" style="top:0;">
              <span class="my_lessons_today_line_dot"></span>
              <span class="my_lessons_today_line_bar"></span>
            </div>
          `);
        }
      }
      // -- END TIME LINE LOGIC --
    }
  }

  // Initial render
  renderWeek(currentMonday);

  // Prev week
  $('#prevWeek').click(function () {
    currentMonday = new Date(currentMonday);
    currentMonday.setDate(currentMonday.getDate() - 7);
    renderWeek(currentMonday);
  });

  // Next week
  $('#nextWeek').click(function () {
    currentMonday = new Date(currentMonday);
    currentMonday.setDate(currentMonday.getDate() + 7);
    renderWeek(currentMonday);
  });

  // Today
  $('#todayBtn').click(function () {
    today = new Date();
    today.setHours(0,0,0,0);
    currentMonday = getMonday(today);
    renderWeek(currentMonday);
  });

  // Optional: Auto-update line every minute (uncomment to use)
  // setInterval(function() { renderWeek(currentMonday); }, 60000);

});




$(function() {
  // Only one open at a time
  $(document).on('click', '.tutor-action-dot', function(e) {
    e.stopPropagation();
    // Close other open menus
    $('.tutor-action-menu').hide();
    // Show this one
    var $menu = $(this).next('.tutor-action-menu');
    $menu.css('display', 'block');
  });

  // Hide menu on click outside
  $(document).on('click', function() {
    $('.tutor-action-menu').hide();
  });

  // Prevent closing when clicking inside the menu
  $(document).on('click', '.tutor-action-menu', function(e) {
    e.stopPropagation();
  });
});


$(function() {
  let tooltipTimeout = null;

  // Show tooltip on icon hover
  $(document).on('mouseenter', '.my-subscription-tooltip-anchor', function() {
    clearTimeout(tooltipTimeout);
    $('.my-subscription-tooltip').hide();
    $(this).find('.my-subscription-tooltip').show();
  });

  // Keep open on tooltip hover
  $(document).on('mouseenter', '.my-subscription-tooltip', function() {
    clearTimeout(tooltipTimeout);
    $(this).show();
  });

  // Hide with 2s delay on icon leave
  $(document).on('mouseleave', '.my-subscription-tooltip-anchor', function() {
    let $tooltip = $(this).find('.my-subscription-tooltip');
    tooltipTimeout = setTimeout(function() {
      $tooltip.hide();
    }, 1000); // 2 seconds delay
  });

  // Hide with 2s delay on tooltip leave
  $(document).on('mouseleave', '.my-subscription-tooltip', function() {
    let $tooltip = $(this);
    tooltipTimeout = setTimeout(function() {
      $tooltip.hide();
    }, 1000); // 2 seconds delay
  });

  // Cancel hiding if you come back in!
  $(document).on('mouseenter', '.my-subscription-tooltip-anchor, .my-subscription-tooltip', function() {
    clearTimeout(tooltipTimeout);
  });
});


