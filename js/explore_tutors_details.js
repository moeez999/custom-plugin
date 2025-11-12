  $(function() {
    function updateTrack() {
      var min = +$('.range-min').val(),
          max = +$('.range-max').val();
      if (min > max) [min, max] = [max, min];
      var pMin = (min-1)/99*100, pMax = (max-1)/99*100;
      $('.slider-track').css({ left: pMin + '%', width: (pMax-pMin) + '%' });
      $('#min-val').text(min);
      $('#max-val').text(max === 100? '100+' : max);
      $('.filter-button[data-type="price"] .value')
        .text('$' + min + ' – $' + (max === 100? '100+' : max));
    }

    $('.filter-button').on('click', function(e) {
      e.stopPropagation();
      var $dd = $(this).next('.dropdown_filters'),
          open = $dd.hasClass('open');
      $('.dropdown_filters, .filter-button').removeClass('open');
      if (!open) $(this).addClass('open'), $dd.addClass('open');
    });

    $(document).on('click', function(e) {
      if (!$(e.target).closest('.filter').length)
        $('.dropdown_filters, .filter-button').removeClass('open');
    });

    $('.dropdown_filters li.item').on('click', function(e) {
      e.stopPropagation();
      var $cb = $(this).find('.checkbox'),
          $filter = $(this).closest('.filter');
      if ($cb.length) {
        $cb.toggleClass('selected');
      } else {
        var text = $(this).text().trim();
        $filter.find('.filter-button .value').text(text);
        $filter.find('.dropdown_filters, .filter-button').removeClass('open');
      }
    });

    $('.time-option, .day-option').on('click', function(e) {
      e.stopPropagation();
      $(this).toggleClass('selected');
    });

    $('.range-min, .range-max').on('input change', updateTrack);
    // tag your Price filter-button with data-type so updateTrack can find it:
    $('.filter-button').filter(function() {
      return $(this).find('.label').text().trim() === 'Price per Month';
    }).attr('data-type','price');

    updateTrack();



      // Teacher hover
      $('#teacherSection .teacher-card').hover(
      function() { $('#teacherSection .schedule-panel').addClass('visible'); },
      function() { $('#teacherSection .schedule-panel').removeClass('visible'); }
      );






  });
