<!-- ===== Modal (standalone; not inside calendar) ===== -->
<style>
  .latmodal-backdrop{position:fixed;inset:0;display:none;align-items:center;justify-content:center;background:rgba(0,0,0,.45);z-index:5000;padding:18px}
  .latmodal-dialog{width:520px;max-width:92vw;background:#fff;border-radius:10px;box-shadow:0 18px 60px rgba(0,0,0,.22);transform:translateY(10px);opacity:0;transition:opacity .18s ease,transform .18s ease}
  .latmodal-dialog.show{opacity:1;transform:translateY(0)}
  .latmodal-header{padding:16px 22px 12px;display:flex;align-items:flex-start;justify-content:space-between}
  .latmodal-title{color:#e53935;font-weight:700;font-size:1.05rem;line-height:1;position:relative;display:inline-block;padding-bottom:10px;margin-top:2px}
  .latmodal-title:after{content:"";position:absolute;left:0;bottom:-24px;height:3px;width:92px;background:#e53935;border-radius:2px}
  .latmodal-hr{height:1px;background:#ececec}
  .latmodal-close{border:0;background:transparent;width:34px;height:34px;opacity:.8;margin-top:2px;cursor:pointer}
  .latmodal-close:hover{opacity:1}
  .latmodal-body{padding:14px 22px 10px}
  .latmodal-busyline{display:flex;align-items:center;gap:12px;margin-bottom:6px}
  .latmodal-busyline .ring{width:18px;height:18px;border-radius:50%;background:#fff;border:2px solid #f1c94a;display:inline-block}
  .latmodal-busytext{font-weight:700;color:#111}
  .latmodal-dt-row{display:flex;align-items:flex-start;gap:12px;margin-top:14px}
  .latmodal-icon{width:20px;height:20px;margin-top:2px;opacity:.95}
  .latmodal-dt-wrap{display:flex;align-items:flex-start;gap:18px}
  .latmodal-col-date{min-width:180px}
  .latmodal-date{font-weight:700;color:#1b1c1d}
  .latmodal-weekday{color:#7b7f86;margin-top:4px}
  .latmodal-vbar{width:1px;background:#e6e6e6;height:40px;margin:0 6px}
  .latmodal-time{font-weight:700;color:#0f141a}
  .latmodal-duration{color:#6c7a89;font-weight:700;font-size:.95rem;margin-top:6px}

  .latmodal-footer{ padding:12px 22px 18px 22px; }
  .latmodal-btn-cancel{
    width:100%; 
    border:2px solid #e53935; 
    color:#e53935; 
    background:#fff; 
    font-weight:700;
    border-radius:12px; 
    padding:12px 16px; 
    cursor:pointer;
    font-size:1rem;
  }
  .latmodal-btn-cancel:hover{ background:#fff6f6; }

</style>

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
