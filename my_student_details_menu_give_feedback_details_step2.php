<?php
// my_student_details_menu_give_feedback_details_step2.php
?>

<section class="section" id="focusSection" style="display:none;">
  <header class="section-header">
  </header>
  <button class="choose-areas-btn" id="focusChooseBtn">
    <span class="choose-areas-btn-icon">＋</span>
    <span>Choose up to 3 areas</span>
  </button>
</section>

<!-- STEP 3: Latingles's next steps summary -->
<section class="section" id="step2NextStepsSection" style="display:none;">
  <div class="progress-header">
    <button type="button" class="progress-header-edit" id="step2EditAreasBtn">Edit</button>
  </div>

  <div class="card">
    <div class="progress-summary">
      <div>
        <div class="progress-label">Effort</div>
        <div id="step2SummaryEffort"></div>
      </div>
      <div>
        <div class="progress-label">Speaking</div>
        <div id="step2SummarySpeaking"></div>
      </div>
      <div>
        <div class="progress-label">Listening</div>
        <div id="step2SummaryListening"></div>
      </div>
    </div>
  </div>
</section>

<div class="divider" id="step2NextStepsDivider" style="display:none;"></div>

<!-- STEP 3: Wrap up your feedback with a short note -->
<section class="section" id="step2WrapSection" style="display:none;">
  <header class="section-header">
    <div class="wrap-note-subtitle">
      A thoughtful note makes all the difference! Use the teaching assistant to create a draft based on the
      feedback you’ve shared, and edit to add your personal touch.
    </div>
  </header>

  <div class="note-options">
    <button type="button" class="note-option-btn note-option-btn-primary" id="askAssistantBtn">
      <span class="note-option-icon">
        <!-- sparkle / magic icon -->
        <img src="img/my_students/ask_assistant_icon.svg" alt="Magic">
      </span>
      <span>Ask assistant to create a draft</span>
    </button>

    <button type="button" class="note-option-btn note-option-btn-secondary" id="typeNoteBtn">
      <span class="note-option-icon">
        <!-- pencil icon -->
        <img src="img/my_students/type_note_icon.svg" alt="Type">
      </span>
      <span>Type your note</span>
    </button>
  </div>
</section>

<!-- STEP 2 MODAL: Choose up to 3 areas to focus on next -->
<div class="modal-backdrop" id="step2AreasModal">
  <div class="modal" role="dialog" aria-modal="true" aria-labelledby="step2AreasModalTitle">
    <div class="modal-header">
      <h2 class="modal-title" id="step2AreasModalTitle">
        Choose up to 3 areas for Latingles to focus on next
      </h2>
      <button class="modal-close" id="step2AreasModalClose" type="button">
        <svg viewBox="0 0 20 20" fill="none">
          <path d="M5 5l10 10M15 5 5 15" stroke="#111827" stroke-width="1.6" stroke-linecap="round" />
        </svg>
      </button>
    </div>

    <div class="modal-body">
      <!-- Effort -->
      <div class="modal-group">
        <div class="modal-group-title">
          <span class="icon">😊</span>
          <span>Effort</span>
        </div>
        <div class="area-pill-row">
          <button class="area-pill step2-area-pill" data-category="Effort" data-label="Time talking in lessons">Time talking in lessons</button>
          <button class="area-pill step2-area-pill" data-category="Effort" data-label="Motivation">Motivation</button>
          <button class="area-pill step2-area-pill" data-category="Effort" data-label="Curiosity">Curiosity</button>
          <button class="area-pill step2-area-pill" data-category="Effort" data-label="Out-of-class activities">Out-of-class activities</button>
          <button class="area-pill step2-area-pill" data-category="Effort" data-label="Taking regular lessons">Taking regular lessons</button>
          <button class="area-pill step2-area-pill" data-category="Effort" data-label="Willing to experiment">Willing to experiment</button>
          <button class="area-pill step2-area-pill" data-category="Effort" data-label="Effective learning techniques">Effective learning techniques</button>
        </div>
      </div>

      <!-- Speaking -->
      <div class="modal-group">
        <div class="modal-group-title">
          <span class="icon">💬</span>
          <span>Speaking</span>
        </div>
        <div class="area-pill-row">
          <button class="area-pill step2-area-pill" data-category="Speaking" data-label="Fluency">Fluency</button>
          <button class="area-pill step2-area-pill" data-category="Speaking" data-label="Clarity">Clarity</button>
          <button class="area-pill step2-area-pill" data-category="Speaking" data-label="Pronunciation">Pronunciation</button>
          <button class="area-pill step2-area-pill" data-category="Speaking" data-label="Sounding confident">Sounding confident</button>
          <button class="area-pill step2-area-pill" data-category="Speaking" data-label="Organising ideas">Organising ideas</button>
          <button class="area-pill step2-area-pill" data-category="Speaking" data-label="Self-correction">Self-correction</button>
        </div>
      </div>

      <!-- Listening -->
      <div class="modal-group">
        <div class="modal-group-title">
          <span class="icon">🎧</span>
          <span>Listening</span>
        </div>
        <div class="area-pill-row">
          <button class="area-pill step2-area-pill" data-category="Listening" data-label="Listening for the main idea">Listening for the main idea</button>
          <button class="area-pill step2-area-pill" data-category="Listening" data-label="Listening for details">Listening for details</button>
          <button class="area-pill step2-area-pill" data-category="Listening" data-label="Offering responses">Offering responses</button>
          <button class="area-pill step2-area-pill" data-category="Listening" data-label="Good turn-taking">Good turn-taking</button>
        </div>
      </div>
    </div>

    <div class="modal-footer">
      <div class="areas-count" id="step2AreasCount">0/3 areas</div>
      <div class="modal-actions">
        <button type="button" class="btn btn-ghost" id="step2AreasCancelBtn">Cancel</button>
        <button type="button" class="btn btn-primary" id="step2AreasSaveBtn">Save</button>
      </div>
    </div>
  </div>
</div>
