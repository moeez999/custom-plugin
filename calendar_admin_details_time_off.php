<!-- ===== Modal (standalone; not inside calendar) ===== -->
<link rel="stylesheet" href="<?php echo $CFG->wwwroot; ?>/local/customplugin/css/calendar_admin_details_time_off.css">

<div id="latBusyBackdrop" class="latmodal-backdrop" aria-hidden="true">
  <div class="latmodal-dialog" role="dialog" aria-modal="true" aria-labelledby="latBusyTitle">
    <div class="latmodal-header">
      <h5 id="latBusyTitle" class="latmodal-title mb-0">Time off</h5>
      <button type="button" class="latmodal-close" id="latBusyClose" aria-label="Close">
        <svg width="16" height="16" viewBox="0 0 24 24"><path d="M18 6L6 18M6 6l12 12" stroke="#4a4a4a" stroke-width="2" stroke-linecap="round"/></svg>
      </button>
    </div>
    <div class="latmodal-hr"></div>

    <div class="latmodal-body">
      <div class="latmodal-busyline">
        <span class="ring"></span>
        <span class="latmodal-busytext">Busy Time</span>
      </div>
      <div class="latmodal-dt-row">
        <svg class="latmodal-icon" viewBox="0 0 24 24" fill="none">
          <circle cx="12" cy="12" r="9" stroke="#111" stroke-width="1.6"/>
          <path d="M12 7v5l3 2" stroke="#111" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round"/>
        </svg>
        <div class="latmodal-dt-wrap">
          <div class="latmodal-col-date">
            <div id="latDate" class="latmodal-date">—</div>
            <div id="latWeekday" class="latmodal-weekday">—</div>
          </div>
          <div class="latmodal-vbar"></div>
          <div>
            <div class="latmodal-time">
              <span id="latStart">—</span>
              <span style="display:inline-flex;vertical-align:middle">
                <svg width="22" height="16" viewBox="0 0 24 24"><path d="M4 12h14M13 5l7 7-7 7" fill="none" stroke="#111" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg>
              </span>
              <span id="latEnd">—</span>
            </div>
            <div id="latDuration" class="latmodal-duration">—</div>
          </div>
        </div>
      </div>
    </div>
        <div class="latmodal-footer">
          <button type="button" class="latmodal-btn-cancel" id="latCancelBtn">
            Cancel time off
          </button>
        </div>
  </div>
</div>

<script>
// ===== jQuery version (minimal) =====
(function ($) {
  // Helpers
  function minutesToHM(m) {
    m = Number(m) || 0;
    var h = Math.floor(m / 60), mm = m % 60;
    return (h < 10 ? '0' : '') + h + ':' + (mm < 10 ? '0' : '') + mm;
  }
  function weekdayFromISO(iso) {
    var d = new Date(iso);
    return ['Sunday','Monday','Tuesday','Wednesday','Thursday','Friday','Saturday'][d.getDay()] || '';
  }

  function openLatModal() {
    var $b = $('#latBusyBackdrop');
    var $dlg = $b.find('.latmodal-dialog');
    $b.css('display','flex');
    setTimeout(function(){ $dlg.addClass('show'); }, 0);
  }
  function closeLatModal() {
    var $b = $('#latBusyBackdrop');
    var $dlg = $b.find('.latmodal-dialog');
    $dlg.removeClass('show');
    setTimeout(function(){ $b.hide(); }, 180);
  }

  // Close actions
  $('#latBusyClose').on('click', closeLatModal);
  $('#latBusyBackdrop').on('click', function(e){ if (e.target === this) closeLatModal(); });
  $(document).on('keydown', function(e){ if (e.key === 'Escape' && $('#latBusyBackdrop').is(':visible')) closeLatModal(); });

  // Open on clicking any calendar event with class "event e-gold"
  $(document).on('click', '.event.e-gold', function () {
    var $ev = $(this);

    // Get start/end minutes from the event element
    var startMin = Number($ev.attr('data-start')) || 0;
    var endMin   = Number($ev.attr('data-end')) || 0;

    // Find the parent day to read its ISO date
    var iso = $ev.closest('.day-inner').attr('data-date') || '';

    // Fill modal
    $('#latDate').text(iso);
    $('#latWeekday').text(iso ? weekdayFromISO(iso) : '');
    $('#latStart').text(minutesToHM(startMin));
    $('#latEnd').text(minutesToHM(endMin));

    var dur = endMin - startMin;
    if (dur < 0) dur = 0;
    $('#latDuration').text(dur + ' minutes');

    // Show modal
    openLatModal();
  });

$('#latCancelBtn').on('click', function(){
  $('#latBusyClose').trigger('click'); // reuse close logic
});

})(jQuery);


</script>
