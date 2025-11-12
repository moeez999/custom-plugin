<style>/* ===== Custom Recurrence Modal Styles ===== */
#customRecurrenceModalBackdrop {
  display: none; position: fixed; z-index: 3002;
  top: 0; left: 0; right: 0; bottom: 0;
  background: rgba(0,0,0,0.15);
}
#customRecurrenceModal {
  background: #fff; border-radius: 17px;
  box-shadow: 0 8px 34px 0 rgba(0,0,0,.20);
  width: 330px; max-width: 97vw;
  margin: 6vh auto 0 auto; position: relative;
  padding: 28px 24px 24px 24px;
  animation: fadeIn .17s;
}
#customRecurrenceModal .customrec-title {
  font-size: 1.22rem;
  font-weight: bold;
  margin-bottom: 14px;
  letter-spacing: -.5px;
}
#customRecurrenceModal .customrec-close {
  position: absolute; top: 18px; right: 20px; font-size: 22px; cursor: pointer; font-weight: bold; color: #232323;
}
.customrec-row {
  margin-bottom: 20px;
}
.customrec-repeat-every {
  display: flex; align-items: center; gap: 12px;
  margin-top: 2px; margin-bottom: 2px;
}
.customrec-repeat-every input {
  width: 32px; text-align: center; font-size: 1.15rem;
  border: none; background: #f5f5f7; border-radius: 7px;
  font-weight: 500; margin: 0 4px;
}
.customrec-interval-btn {
  background: #fff;
  border: 2px solid #232323;
  border-radius: 50%;
  width: 32px; height: 32px;
  font-size: 1.25rem;
  cursor: pointer;
  color: #232323;
  display: flex; align-items: center; justify-content: center;
  transition: border .14s;
}
.customrec-interval-btn:active { border-color: #fe2e0c; color: #fe2e0c; }

.customrec-dropdown {
  margin-left: 5px;
  min-width: 75px;
  border: 1.4px solid #c9c9c9;
  border-radius: 8px;
  font-size: 1.02rem;
  background: #fff;
  padding: 6px 10px 6px 13px;
  cursor: pointer;
}

.customrec-divider {
  border: none; border-top: 1.4px solid #ececec;
  margin: 16px 0;
}

.customrec-repeat-days {
  display: flex; gap: 10px;
  justify-content: center; margin-top: 6px; margin-bottom: 12px;
}
.customrec-repeat-day {
  width: 38px; height: 38px; background: #f7f7f7;
  border-radius: 50%; border: 2px solid #ececec;
  font-size: 1.08rem; color: #232323;
  display: flex; align-items: center; justify-content: center;
  cursor: pointer; transition: border .13s, background .13s, color .13s;
  font-weight: 600;
}
.customrec-repeat-day.selected {
  background: #fff;
  border: 2px solid #1736e6;
  color: #1736e6;
}
.customrec-ends-options {
  margin-top: 11px;
}
.customrec-end-radio-row {
  display: flex; align-items: center; gap: 12px; margin-bottom: 10px;
}
.customrec-radio {
  accent-color: #1736e6; width: 20px; height: 20px;
}
.customrec-end-date, .customrec-end-occurrences {
  background: #f3f3f3; border-radius: 8px;
  border: none; padding: 8px 13px; font-size: 1.08rem;
  margin-left: 4px; color: #bbb; min-width: 98px;
}
.customrec-end-date:enabled, .customrec-end-occurrences:enabled {
  color: #232323; background: #fff; border: 1.2px solid #dadada;
}
.customrec-occurrence-interval {
  display: flex; align-items: center; gap: 7px;
}
.customrec-occurrence-btn {
  background: #fff;
  border: 2px solid #232323;
  border-radius: 50%;
  width: 32px; height: 32px;
  font-size: 1.13rem;
  cursor: pointer;
  color: #232323;
  display: flex; align-items: center; justify-content: center;
}
.customrec-occurrence-btn:active { border-color: #fe2e0c; color: #fe2e0c; }
.customrec-occurrence-label {
  color: #bbb;
  font-size: 1.05rem;
  min-width: 70px;
  margin: 0 5px 0 5px;
}
.customrec-btn-row {
  display: flex; gap: 12px; margin-top: 18px; justify-content: space-between;
}
.customrec-btn-cancel {
  flex: 1 1 0;
  background: #fff; border: 2px solid #232323; color: #232323;
  font-weight: 600; font-size: 1.12rem; border-radius: 8px; padding: 12px 0;
  cursor: pointer; transition: background .13s, color .13s, border .13s;
}
.customrec-btn-cancel:hover { background: #f7f7f7; }
.customrec-btn-done {
  flex: 1 1 0;
  background: #fe2e0c; border: none; color: #fff;
  font-weight: 700; font-size: 1.12rem; border-radius: 8px; padding: 12px 0;
  cursor: pointer; box-shadow: 0 3px 14px 0 rgba(254,46,12,.07);
  transition: background .13s;
}
.customrec-btn-done:hover { background: #d52b0e; }

@media (max-width: 500px) {
  #customRecurrenceModal { padding: 12px 2vw 17px 2vw; }
  .customrec-repeat-day { width: 31px; height: 31px; font-size: 1rem; }
  .customrec-dropdown { font-size: .95rem; padding: 4px 6px 4px 10px; }
}

</style>


<!-- === Custom Recurrence Modal === -->
<div id="customRecurrenceModalBackdrop">
  <div id="customRecurrenceModal">
    <span class="customrec-close" id="customrec_close">&times;</span>
    <div class="customrec-title">Custom Recurrence</div>

    <div class="customrec-row" style="margin-bottom: 13px;">
      <label>Repeat Every</label>
      <div class="customrec-repeat-every">

        <button class="customrec-interval-btn" id="customrec_minus">−</button>
        <input type="text" id="customrec_interval" value="1" readonly>
        <button class="customrec-interval-btn" id="customrec_plus">+</button>
        <select class="customrec-dropdown" id="customrec_period">
          <option value="day">Day</option>
          <option value="week" selected>Week</option>
          <option value="month">Month</option>
          <option value="year">Year</option>
        </select>
      </div>
    </div>

    <hr class="customrec-divider">

<div class="customrec-row" id="customrec_repeat_on_row">
  <label>Repeat on</label>
  <div class="customrec-repeat-days" id="customrec_days">
    <div class="customrec-repeat-day" data-day="0">S</div>
    <div class="customrec-repeat-day" data-day="1">M</div>
    <div class="customrec-repeat-day" data-day="2">T</div>
    <div class="customrec-repeat-day" data-day="3">W</div>
    <div class="customrec-repeat-day" data-day="4">T</div>
    <div class="customrec-repeat-day" data-day="5">F</div>
    <div class="customrec-repeat-day" data-day="6">S</div>
  </div>
</div>


    <hr class="customrec-divider">

    <div class="customrec-row customrec-ends-options">
      <div class="customrec-end-radio-row">
        <input type="radio" name="customrec_end" id="customrec_end_never" class="customrec-radio" checked>
        <label for="customrec_end_never">Year</label>
      </div>
      <div class="customrec-end-radio-row">
        <input type="radio" name="customrec_end" id="customrec_end_on" class="customrec-radio">
        <label for="customrec_end_on">On</label>
        <input type="date" id="customrec_end_on_date" class="customrec-end-date" disabled>
      </div>
      <div class="customrec-end-radio-row">
        <input type="radio" name="customrec_end" id="customrec_end_after" class="customrec-radio">
        <label for="customrec_end_after">After</label>
        <div class="customrec-occurrence-interval">
          <button class="customrec-occurrence-btn" id="customrec_occur_minus">−</button>
          <input type="text" id="customrec_occur_value" value="13" readonly class="customrec-end-occurrences" disabled>
          <span class="customrec-occurrence-label">occurrences</span>
          <button class="customrec-occurrence-btn" id="customrec_occur_plus">+</button>
        </div>
      </div>
    </div>

    <div class="customrec-btn-row">
      <button class="customrec-btn-cancel" id="customrec_cancel">Cancel</button>
      <button class="customrec-btn-done" id="customrec_done">Done</button>
    </div>
  </div>
</div>



<script>
  // ===== Custom Recurrence Modal JS =====
$(document).ready(function () {
  // Show/Hide modal
  $('.cohort_schedule_btn').on('click', function(){
    $('#customRecurrenceModalBackdrop').fadeIn();
  });
  $('.customrec-close, #customrec_cancel, #customRecurrenceModalBackdrop').on('click', function(e){
    if(e.target === this || $(e.target).hasClass('customrec-close') || e.target.id === 'customrec_cancel') {
      $('#customRecurrenceModalBackdrop').fadeOut();
    }
  });

  // Repeat Every +/- logic
  let recInt = 1;
  $('#customrec_plus').on('click', function(){ 
    recInt++; 
    $('#customrec_interval').val(recInt); 
  });
  $('#customrec_minus').on('click', function(){ 
    if(recInt>1) recInt--; 
    $('#customrec_interval').val(recInt); 
  });

  // Repeat Days select logic
  $('#customrec_days .customrec-repeat-day').on('click', function(){
    $(this).toggleClass('selected');
  });

  // Ends: radio control
  $('input[name="customrec_end"]').on('change', function(){
    let v = $(this).attr('id');
    $('#customrec_end_on_date').prop('disabled', v!=='customrec_end_on');
    $('#customrec_occur_value').prop('disabled', v!=='customrec_end_after');
    $('#customrec_occur_minus, #customrec_occur_plus').prop('disabled', v!=='customrec_end_after');
  });

  // Occurrences +/- logic
  let occInt = 13;
  $('#customrec_occur_plus').on('click', function(){ 
    if($('#customrec_end_after').is(':checked')) {
      occInt++; 
      $('#customrec_occur_value').val(occInt);
    }
  });
  $('#customrec_occur_minus').on('click', function(){ 
    if($('#customrec_end_after').is(':checked') && occInt>1) {
      occInt--; 
      $('#customrec_occur_value').val(occInt);
    }
  });

  // Done/Cancel buttons: just closes modal for now
  $('#customrec_done').on('click', function(){
    $('#customRecurrenceModalBackdrop').fadeOut();
    // Here you can trigger your actual recurrence data logic!
  });







  // Show/hide "Repeat on" row based on period
  function applyRepeatOnVisibility() {
    const val = $('#customrec_period').val();
    if (val === 'day') {
      // Hide and clear selections when switching to "Day"
      $('#customrec_repeat_on_row').slideUp(120);
      $('#customrec_days .customrec-repeat-day').removeClass('selected');
    } else {
      $('#customrec_repeat_on_row').slideDown(120);
    }
  }

  // React on dropdown change
  $('#customrec_period').on('change', applyRepeatOnVisibility);

  // Ensure correct initial state (default is Week → visible)
  applyRepeatOnVisibility();








});

</script>


