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

      // Teacher hover
      $('#teacherSection .teacher-card').hover(
      function() { $('#teacherSection .schedule-panel').addClass('visible'); },
      function() { $('#teacherSection .schedule-panel').removeClass('visible'); }
    );
    

    
    //  slider logic
     /* ====== STATE ====== */
  const find_groups_details_state = {
    priceCfg: { min: 1, max: 40, step: 1 },
    priceRange: { min: 1, max: 40 }
  };

  /* ====== ELEMENTS ====== */
  const $priceField = $('#find_groups_details_value_price');
  const $priceRead  = $('#find_groups_details_price_readout');
  const $priceTrack = $('#find_groups_details_price_track');
  const $priceFill  = $('#find_groups_details_price_fill');
  const $thumbMin   = $('#find_groups_details_price_thumb_min');
  const $thumbMax   = $('#find_groups_details_price_thumb_max');

  /* ====== UTILS ====== */
  const clamp = (v, min, max) => Math.max(min, Math.min(max, v));

  function valueToPercent(val){
    const { min, max } = find_groups_details_state.priceCfg;
    return ((val - min) / (max - min)) * 100;
  }

  function percentToValue(pct){
    const { min, max, step } = find_groups_details_state.priceCfg;
    if (!isFinite(pct)) return min;
    const raw = min + (pct / 100) * (max - min);
    return Math.round(raw / step) * step;
  }

  /* ====== UI UPDATE ====== */
  function updatePriceUI(){
    let { min, max } = find_groups_details_state.priceRange;
    const { max: cfgMax } = find_groups_details_state.priceCfg;

    if (!isFinite(min) || !isFinite(max)) return;
    if (min > max) [min, max] = [max, min];

    const leftPct  = valueToPercent(min);
    const rightPct = valueToPercent(max);

    $thumbMin.css('left', `${leftPct}%`);
    $thumbMax.css('left', `${rightPct}%`);

    $priceFill.css({
      left: `${Math.min(leftPct, rightPct)}%`,
      width: `${Math.abs(rightPct - leftPct)}%`
    });

    const maxLabel = max === cfgMax ? `${max}+` : max;

    $priceRead.text(`$${min} – $${maxLabel}`);
    $priceField
      .text(`${min} to ${maxLabel}`)
      .attr('title', `${min} to ${maxLabel}`);
  }

  /* ====== DRAG HANDLER ====== */
  function bindThumb($thumb, type){
    $thumb.on('pointerdown', function(e){
      e.preventDefault();
      this.setPointerCapture(e.pointerId);

      const rect = $priceTrack[0].getBoundingClientRect();
      if (!rect.width) return;

      const move = ev => {
        const x   = clamp(ev.clientX, rect.left, rect.right);
        const pct = ((x - rect.left) / rect.width) * 100;
        let val   = percentToValue(pct);

        if (type === 'min') {
          val = clamp(val,
            find_groups_details_state.priceCfg.min,
            find_groups_details_state.priceRange.max
          );
          find_groups_details_state.priceRange.min = val;
        } else {
          val = clamp(val,
            find_groups_details_state.priceRange.min,
            find_groups_details_state.priceCfg.max
          );
          find_groups_details_state.priceRange.max = val;
        }

        updatePriceUI();
      };

      const up = () => {
        $(window).off('pointermove', move);
        $(window).off('pointerup', up);
      };

      $(window).on('pointermove', move);
      $(window).on('pointerup', up);
    });
  }

  bindThumb($thumbMin, 'min');
  bindThumb($thumbMax, 'max');

  /* ====== INIT ====== */
  updatePriceUI();


// see more and hide functionality
$(document).on('click', '.see-more', function () {
  debugger;
  const index = $(this).data('target'); // 1

  const $targetDiv = $('#teacher_additional_' + index);
  const $teacherCard = $('#teacher_card_' + index);
  const $teacherCardBio = $('#teacher_card_bio_' + index);

  $targetDiv
    .removeClass('hidden');
  $teacherCardBio
    .addClass('hidden');   

  $(this).hide();
  
  $teacherCard
    .addClass('height-auto');
  $teacherCard
    .addClass('teacher-list-active');

  $('#teacher_card_hide_'+index).show();
});

$(document).on('click', '.hideit', function () {
  const index = $(this).data('target'); // 1
    debugger;
  const $targetDiv = $('#teacher_additional_' + index);
  const $teacherCard = $('#teacher_card_' + index);
  const $teacherCardBio = $('#teacher_card_bio_' + index);
  $teacherCardBio
      .removeClass('hidden');   

  $targetDiv
    .addClass('hidden');
 $teacherCard
    .removeClass('height-auto');
  $teacherCard
    .removeClass('teacher-list-active');

  $(this).hide();

  
  $('#teacher_card_see_'+index).show();
});


  });
