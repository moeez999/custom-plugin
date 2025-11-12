
<!-- MODAL 2 -->
<div class="custom-modal" id="topicModal" style="display:none;">
  <div class="modal2-content">
    <span class="supercal-close" id="topic_modal_close">&times;</span>
    
    <form style="margin-top:25px;">
      <div class="modal-row">

        <div class="modal-col" style="flex:2;">
          <!-- Topic Dropdown -->

          <div class="custom-dropdown-wrapper" id="topicDropdownWrapper">
            <div class="custom-dropdown-selected" tabindex="0" id="topicDropdownSelected">
              <span id="topicDropdownText">Select Topic</span>
              <span class="dropdown-arrow">&#9662;</span>
            </div>
            <div class="custom-dropdown-list" id="topicDropdownList">
              <div class="dropdown-create-row">
                <input type="text" class="dropdown-create-input" placeholder="Create a new topic if not listed" id="newTopicInput">
                <button type="button" class="dropdown-create-btn" id="createTopicBtn">&#10003;</button>
              </div>
              <div class="dropdown-group">
                <div class="dropdown-group-label accordion-toggle" data-acc="1">
                  <span>A1 - Level 1</span>
                  <span class="accordion-arrow">&#9662;</span>
                </div>
                <div class="dropdown-items" data-acc="1">
                  <div class="dropdown-item">Alphabet</div>
                  <div class="dropdown-item">Number</div>
                  <div class="dropdown-item">Self Introduction</div>
                  <div class="dropdown-item">Verb Be</div>
                  <div class="dropdown-item">Demonstratives</div>
                  <div class="dropdown-item">Present Continuous</div>
                </div>
              </div>
              <div class="dropdown-group">
                <div class="dropdown-group-label accordion-toggle" data-acc="2">
                  <span>A1 - Level 2</span>
                  <span class="accordion-arrow">&#9662;</span>
                </div>
                <div class="dropdown-items" data-acc="2" style="display:none;">
                  <div class="dropdown-item">Past Simple</div>
                  <div class="dropdown-item">Future Intentions</div>
                  <div class="dropdown-item">Family Members</div>
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="modal-col" style="flex:1.1;">
          <div class="readonly-box">Target Sessions : 3</div>
        </div>
      </div>
      <div class="modal-row">
        <div class="modal-col" style="flex:2;">


















          <!-- Assignment Dropdown -->
          <div class="custom-dropdown-wrapper" id="assignmentDropdownWrapper">
            <div class="custom-dropdown-selected" tabindex="0" id="assignmentDropdownSelected">
              <span id="assignmentDropdownText">Assignment</span>
              <span class="dropdown-arrow">&#9662;</span>
            </div>
            <div class="custom-dropdown-list" id="assignmentDropdownList">
              <div class="dropdown-group">
                <div class="dropdown-group-label accordion-toggle" data-acc="a1">
                  <span>Homework</span>
                  <span class="accordion-arrow">&#9662;</span>
                </div>
                <div class="dropdown-items" data-acc="a1">
                  <div class="dropdown-item">HW1</div>
                  <div class="dropdown-item">HW2</div>
                  <div class="dropdown-item">HW3</div>
                  <div class="dropdown-item">HW4</div>
                </div>
              </div>
              <div class="dropdown-group">
                <div class="dropdown-group-label accordion-toggle" data-acc="a2">
                  <span>Quizzes</span>
                  <span class="accordion-arrow">&#9662;</span>
                </div>
                <div class="dropdown-items" data-acc="a2" style="display:none;">
                  <div class="dropdown-item">Quiz 1</div>
                  <div class="dropdown-item">Quiz 2</div>
                  <div class="dropdown-item">Quiz 3</div>
                </div>
              </div>
              <div class="dropdown-group">
                <div class="dropdown-group-label accordion-toggle" data-acc="a3">
                  <span>Exams</span>
                  <span class="accordion-arrow">&#9662;</span>
                </div>
                <div class="dropdown-items" data-acc="a3" style="display:none;">
                  <div class="dropdown-item">Midterm</div>
                  <div class="dropdown-item">Final</div>
                </div>
              </div>
            </div>
          </div>























  </div>






                <!-- START DATE INPUT -->
                <div class="modal-col" style="flex:1.1; position:relative;">
                  <input class="custom-input" id="startcal-open-btn" style="padding-right:32px; cursor:pointer;" readonly value="1 Oct, 2024">
                  <span class="icon-btn" style="right:20px; top:25px; font-size:1.28rem; pointer-events:none;">
                    <!-- icon -->
                  </span>
                  <div style="position:absolute; top:3px; left:16px; font-size:12px; color:#bababa; pointer-events:none;">Start Date</div>
                </div>



                <!-- DUE ON INPUT -->
                <div class="modal-col" style="flex:1.1; position:relative;">
                  <input class="custom-input" id="duecal-open-btn" style="padding-right:32px; cursor:pointer;" readonly value="1 Oct, 2024">
                  <span class="icon-btn" style="right:20px; top:25px; font-size:1.28rem; pointer-events:none;">
                    <!-- icon -->
                  </span>
                  <div style="position:absolute; top:3px; left:16px; font-size:12px; color:#bababa; pointer-events:none;">Due On</div>
                </div>
                  <div id="dueon-chip-container" style="margin-top:8px;"></div>


  
  
      </div>


        <!-- Selected Assignment Chip -->
        <div id="selectedAssignmentChipList" style="margin-top:10px;"></div>

        <div class="selected-assignment-chip" id="selectedAssignmentChip" style="display:none;">
        <span class="chip-title" id="selectedAssignmentLabel"></span>
        <span class="chip-detail" id="selectedAssignmentDetail"></span>
        <span class="chip-remove" id="removeAssignmentChip" title="Remove">&#10005;</span>
      </div>



      <div class="note-link" tabindex="0">Make a note for student or group <span class="dropdown-arrow">&#9660;</span></div>
      <div class="note-area">

          <!-- Student/Group Dropdown -->
          <div class="custom-dropdown-wrapper" id="noteDropdownWrapper" style="display:none; margin-bottom:12px;">
            <div class="custom-dropdown-selected" tabindex="0" id="noteDropdownSelected">
              <span id="noteDropdownText">Select Student or Group</span>
              <span class="dropdown-arrow">&#9662;</span>
            </div>
            <div class="custom-dropdown-list" id="noteDropdownList">
              <div style="padding: 12px;">
                <input type="text" class="custom-input" id="noteDropdownSearch" placeholder="Search for student or group" style="font-size:1.03rem; background: #fafbfc;">
              </div>
              <div class="dropdown-group" id="noteDropdownItems">
                <!-- Example items. Replace with your dynamic content if needed -->
                <div class="dropdown-item"><span class="note-avatar" style="background:#1743e3;">FL1</span> Florida 1</div>
                <div class="dropdown-item"><img class="note-avatar" src="https://randomuser.me/api/portraits/women/68.jpg"> Daniela</div>
                <div class="dropdown-item"><img class="note-avatar" src="https://randomuser.me/api/portraits/men/65.jpg"> Kristin Watson</div>
                <div class="dropdown-item"><img class="note-avatar" src="https://randomuser.me/api/portraits/men/66.jpg"> Courtney Henry</div>
                <div class="dropdown-item"><img class="note-avatar" src="https://randomuser.me/api/portraits/women/69.jpg"> Theresa Webb</div>
                <div class="dropdown-item"><img class="note-avatar" src="https://randomuser.me/api/portraits/men/67.jpg"> Arlene McCoy</div>
              </div>
            </div>
          </div>


               <div id="noteChipsList" style="margin-bottom:15px;"></div>



                <!-- Selected Student/Group "note for" UI -->
              <div id="noteForStudentSection" style="display:none; margin-bottom:22px;">
                <div style="display:flex;align-items:center;gap:11px;margin-bottom:7px;">
                  <img id="noteForAvatar" src="" class="note-avatar" style="width:39px;height:39px;">
                  <span id="noteForName" style="font-weight:600;font-size:1.12rem;"></span>
                </div>
                <div style="font-size:1.05rem;margin-bottom:7px;">
                  Write a note for <span id="noteForNameLabel" style="font-weight:500;"></span>
                </div>
                <textarea class="note-textarea" placeholder="First name" id="noteTextarea"></textarea>
                <button type="button" id="noteSubmitBtn" style="width:25%;margin-top:18px;padding:10px 0 10px 0;background:#fff;color:#232323;font-size:1rem;font-weight:500;border:2px solid #232323;border-radius:10px;cursor:pointer;transition:.14s;">Submit</button>
              </div>






      </div>









<style>
.subscription_modal_progress_bar_container {
  width: 100%;
  max-width: 500px;
  margin: 32px auto;
  height: 81px;
  border-radius: 128px;
  background: #fff;
  border: 1px solid #d1d5db;
  box-shadow: 0 39px 39px 0 rgba(0, 0, 0, 0.03), 0 9px 22px 0 rgba(0, 0, 0, 0.03);
  padding: 6px 28px;
  display: flex;
  justify-content: center;
  align-items: center;
  position: relative;
}

.subscription_modal_progress_bar_progress {
  width: 100%;
  height: 8px;
  border-radius: 4px;
  background: #eaecf0;
  position: relative;
}

.subscription_modal_progress_bar_completed {
  width: var(--progressComplete, 65%);
  height: 8px;
  border-radius: 4px;
  background: #ff2500;
  position: absolute;
  top: 0;
  left: 0;
}

.subscription_modal_progress_bar_start_point,
.subscription_modal_progress_bar_end_point {
  position: absolute;
  top: 90%;
  display: flex;
  flex-direction: column;
  align-items: center;
  font-size: 12px;
  color: #0008;
  font-weight: 600;
}

.subscription_modal_progress_bar_start_point {
  left: -5px;
}
.subscription_modal_progress_bar_end_point {
  right: -13px;
}

.subscription_modal_progress_bar_point_01 {
  display: flex;
  flex-direction: column;
  align-items: center;
  position: absolute;
  top: -24px;
  width: 30px;
}
.subscription_modal_progress_bar_pointer {
  width: 20px;
  height: 20px;
  border-radius: 50%;
  background: #ff2500;
  display: flex;
  align-items: center;
  justify-content: center;
}
.subscription_modal_progress_bar_pointer span {
  color: #fff;
  font-weight: 600;
  font-size: 12px;
}
.subscription_modal_progress_bar_point_01 svg {
  margin-top: 7px;
}
.subscription_modal_progress_bar_point_01 p {
  font-size: 12px;
  color: #0008;
  font-weight: 600;
}

.subscription_modal_progress_bar_draggable {
  top: -8px;
  display: flex;
  flex-direction: column;
  align-items: flex-end;
  position: absolute;
  transform: translateX(-2px);
  z-index: 2;
  width: 30px;
}
.subscription_modal_progress_bar_draggable_pointer {
  width: 23px;
  height: 23px;
  border-radius: 50%;
  border: 1px solid #ff2500;
  background: #fff;
  box-shadow: 0 4px 8px -2px rgba(16,24,40,0.1),
    0 2px 4px -2px rgba(16,24,40,0.06);
}
.subscription_modal_progress_bar_draggable p {
  font-weight: 600;
  font-size: 12px;
  color: #000;
  visibility: hidden;
  opacity: 0;
  transition: 0.3s;
  margin-top: 2px;
}
.subscription_modal_progress_bar_draggable p.active {
  visibility: visible;
  opacity: 1;
}
</style>

<div class="subscription_modal_progress_bar_container">
  <div class="subscription_modal_progress_bar_progress subscription_modal_progress_bar_progressShow">
    <div
      class="subscription_modal_progress_bar_completed"
      style="--progressComplete: 65%"
    ></div>

    <div class="subscription_modal_progress_bar_start_point">
      <svg xmlns="http://www.w3.org/2000/svg" width="10" height="10" viewBox="0 0 10 10" fill="none">
        <path d="M6.29904 8.75C5.72169 9.75 4.27831 9.75 3.70096 8.75L0.236859 2.75C-0.340491 1.75 0.381197 0.500001 1.5359 0.500001L8.4641 0.5C9.6188 0.5 10.3405 1.75 9.76314 2.75L6.29904 8.75Z" fill="#FF2500"/>
      </svg>
      <p>0%</p>
    </div>

    <div class="subscription_modal_progress_bar_point_01" style="left: calc(25% - 14px)">
      <div class="subscription_modal_progress_bar_pointer"><span>1</span></div>
      <svg xmlns="http://www.w3.org/2000/svg" width="10" height="10" viewBox="0 0 10 10" fill="none">
        <path d="M6.29904 8.75C5.72169 9.75 4.27831 9.75 3.70096 8.75L0.236859 2.75C-0.340491 1.75 0.381197 0.500001 1.5359 0.500001L8.4641 0.5C9.6188 0.5 10.3405 1.75 9.76314 2.75L6.29904 8.75Z" fill="#FF2500"/>
      </svg>
      <p>25%</p>
    </div>

    <div class="subscription_modal_progress_bar_point_01" style="left: calc(60% - 14px)">
      <div class="subscription_modal_progress_bar_pointer"><span>2</span></div>
      <svg xmlns="http://www.w3.org/2000/svg" width="10" height="10" viewBox="0 0 10 10" fill="none">
        <path d="M6.29904 8.75C5.72169 9.75 4.27831 9.75 3.70096 8.75L0.236859 2.75C-0.340491 1.75 0.381197 0.500001 1.5359 0.500001L8.4641 0.5C9.6188 0.5 10.3405 1.75 9.76314 2.75L6.29904 8.75Z" fill="#FF2500"/>
      </svg>
      <p>60%</p>
    </div>

    <div class="subscription_modal_progress_bar_draggable" style="left: 64%">
      <div class="subscription_modal_progress_bar_draggable_pointer"></div>
      <p class="subscription_modal_progress_bar_draggable_percentage_value">80%</p>
    </div>

    <div class="subscription_modal_progress_bar_end_point">
      <svg xmlns="http://www.w3.org/2000/svg" width="10" height="10" viewBox="0 0 10 10" fill="none">
        <path d="M6.29904 8.75C5.72169 9.75 4.27831 9.75 3.70096 8.75L0.236859 2.75C-0.340491 1.75 0.381197 0.500001 1.5359 0.500001L8.4641 0.5C9.6188 0.5 10.3405 1.75 9.76314 2.75L6.29904 8.75Z" fill="#eaecf0"/>
      </svg>
      <p>100%</p>
    </div>
  </div>
</div>






  </form>



  </div>

   <div class="modal-footer">
    <button type="submit" class="modal-submit-btn">Submit</button>
  </div>


</div>






<!-- START DATE MODAL -->
<div class="supercal-backdrop" id="startcal-backdrop" style="display:none;"></div>
<div class="supercal-modal" id="startcal-modal" style="display:none;">
  <span class="supercal-close" id="startcal-close-btn">&times;</span>
  <div class="supercal-header" style="margin-top:35px;">
    <button type="button" class="supercal-arrow" id="startcal-prev-month">&#8592;</button>
    <span class="supercal-title" id="startcal-monthyear">October 2024</span>
    <button type="button" class="supercal-arrow" id="startcal-next-month">&#8594;</button>
  </div>
  <div class="supercal-days">
    <span>Mo</span><span>Tu</span><span>We</span><span>Th</span><span>Fr</span><span>Sa</span><span>Su</span>
  </div>
  <div class="supercal-dates" id="startcal-dates"></div>
  <div class="supercal-time-row">
    <select id="startcal-hour" class="supercal-time-select"></select>
    <span class="supercal-time-colon">:</span>
    <select id="startcal-minute" class="supercal-time-select"></select>
    <select id="startcal-ampm" class="supercal-time-select"></select>
  </div>
  <button type="button" class="supercal-confirm" id="startcal-done-btn">Done</button>
</div>









<!-- DUE ON MODAL -->
<div class="supercal-backdrop" id="duecal-backdrop" style="display:none;"></div>
<div class="supercal-modal" id="duecal-modal" style="display:none;">
  <span class="supercal-close" id="duecal-close-btn">&times;</span>
  <div class="supercal-header" style="margin-top:35px;">
    <button type="button" class="supercal-arrow" id="duecal-prev-month">&#8592;</button>
    <span class="supercal-title" id="duecal-monthyear">October 2024</span>
    <button type="button" class="supercal-arrow" id="duecal-next-month">&#8594;</button>
  </div>
  <div class="supercal-days">
    <span>Mo</span><span>Tu</span><span>We</span><span>Th</span><span>Fr</span><span>Sa</span><span>Su</span>
  </div>
  <div class="supercal-dates" id="duecal-dates"></div>
  <div class="supercal-time-row">
    <select id="duecal-hour" class="supercal-time-select"></select>
    <span class="supercal-time-colon">:</span>
    <select id="duecal-minute" class="supercal-time-select"></select>
    <select id="duecal-ampm" class="supercal-time-select"></select>
  </div>
  <button type="button" class="supercal-confirm" id="duecal-done-btn">Done</button>
</div>











<!-- CHIP HTML: Place this after your assignment and date fields -->
<div class="selected-assignment-chip" id="selectedAssignmentChip" style="display:none; margin-top:10px;">
  <span class="chip-title" id="selectedAssignmentLabel"></span>
  <span class="chip-detail" id="selectedAssignmentDetail"></span>
  <span class="chip-remove" id="removeAssignmentChip" title="Remove" style="cursor:pointer;">&#10005;</span>
</div>

<!-- CALENDAR MODAL HTML (should be at the end of body, outside modals) -->

<!-- <div class="supercal-backdrop" id="supercal-backdrop"></div>
<div class="supercal-modal" id="supercal-modal">
  <div class="supercal-header">
    <button type="button" class="supercal-arrow" id="supercal-prev-month">&#8592;</button>
    <span class="supercal-title" id="supercal-monthyear">October 2024</span>
    <button type="button" class="supercal-arrow" id="supercal-next-month">&#8594;</button>
    <span class="supercal-close" id="supercal-close-btn">&times;</span>
  </div>
  <div class="supercal-days">
    <span>Mo</span><span>Tu</span><span>We</span><span>Th</span><span>Fr</span><span>Sa</span><span>Su</span>
  </div>
  <div class="supercal-dates" id="supercal-dates"></div>
  <button type="button" class="supercal-confirm" id="supercal-done-btn">Done</button>
</div> -->











<!-- Congratulations Modal -->
<div id="congratsModalBackdrop" style="display:none;"></div>
<div id="congratsModal" style="display:none;">
  <div class="congrats-content">
    <img src="https://cdn-icons-png.flaticon.com/512/3159/3159066.png" 
         alt="Celebration" class="congrats-icon" />
    <h2>Congratulations!</h2>
    <p>
      You’ve successfully completed 100% of the session.<br>
      Great job guiding your students!
    </p>
    <button type="button" id="congratsOkayBtn">Okay, thanks!</button>
  </div>
</div>


















