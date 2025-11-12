

<!-- Congratulations Modal (for YES flow) -->
<div id="congratsModal" class="custom-modal-overlay" style="display:none;">
  <div class="custom-modal-content">
    <img src="https://cdn-icons-png.flaticon.com/512/3159/3159066.png" alt="Nice!" class="congrats-emoji" />
    <div class="congrats-title">Congratulations!</div>
    <div class="congrats-desc">You’ve successfully completed 100% of the session.<br>Great job guiding your students!</div>
    <button class="congrats-btn" id="congratsOkBtn">Okay, thanks!</button>
  </div>
</div>

<!-- Session Absence Modal (for NO flow) -->
<div id="absenceModal" class="custom-modal-overlay" style="display:none;">
  <div class="absence-modal-content">
    <button class="absence-back-btn" id="absenceBackBtn">&#8592;</button>
    <button class="absence-close-btn" id="absenceCloseBtn">&times;</button>
    <div class="absence-title">Session Absence</div>
    <div class="absence-desc">
      It seems you haven’t joined this session. Please select a reason for your absence.
    </div>
    <div class="absence-label">Please choose a reason for cancel lesson</div>



            <div class="absence-select-wrapper">
            <div class="custom-select-selected" tabindex="0" id="absenceSelectTrigger">
                <span class="custom-select-placeholder">Select Reason</span>
                <span class="custom-select-arrow">&#9662;</span>
            </div>
            <div class="custom-select-list" id="absenceCustomList">
                <div class="custom-select-option" data-value="health">The timing isn’t working out today.</div>
                <div class="custom-select-option" data-value="tech">There are some tech issues, so we can't run the class.</div>
                <div class="custom-select-option" data-value="teacher">The teacher isn’t available right now.</div>
                <div class="custom-select-option" data-value="personal">He’s not able to make it today.</div>
                <div class="custom-select-option" data-value="students">Not enough students showed up, so we’ll skip this one.</div>
            </div>
            <input type="hidden" id="absenceReason" class="absence-select" value="" />
            </div>




    
    <textarea class="absence-textarea" id="absenceExplain" placeholder="explain the reason..."></textarea>
    <button class="absence-submit-btn">Submit</button>
  </div>
</div>


