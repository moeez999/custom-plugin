<?php
// my_student_details_menu_give_feedback_details_step3.php
?>

<!-- STEP 3: Full note editor (shown after clicking "Type your note") -->
<section class="section" id="noteEditorSection" style="display:none;">
  <header class="section-header">
    <div class="wrap-note-subtitle">
      A thoughtful note makes all the difference! Use the teaching assistant to create a draft based on the feedback
      you’ve shared, and edit to add your personal touch.
    </div>
  </header>

  <div class="note-editor-label">Your note</div>

  <div class="note-editor-card">
    <textarea
      id="noteTextarea"
      class="note-editor-textarea"
      maxlength="600"
      placeholder="Hello Latingles!&#10;&#10;Write a short, encouraging message that sums up their progress and next steps.">
Hello Latingles!

I've really enjoyed having you in my lessons and getting to know you these past couple of weeks! You’ve been working hard towards your goal, so I’d like to highlight your progress and share a few tips for moving forward. It’s a pleasure to be part of your learning journey!
    </textarea>

    <div class="note-editor-footer">
      <div class="note-editor-actions">
        <button type="button" class="note-editor-small-btn" id="my_students_details_menu_give_feedback_details_create_draft_open_button">
          <span class="note-editor-small-icon">
            <img src="img/my_students/gen_feedback.svg" alt="Magic">
          </span>
          <span>Generate feedback</span>
        </button>

        <button type="button" class="note-editor-small-btn" id="btnMessageTemplates">
          <span class="note-editor-small-icon">
            <img src="img/my_students/message_temp.svg" alt="Templates">
          </span>
          <span>Message templates</span>
        </button>
      </div>

      <!-- AI bubble on the right side (just visual for now) -->
      <div class="note-editor-ai">
        <button type="button" class="note-editor-ai-btn" aria-label="Edit">
          <img src="img/my_students/note_edit_icon.svg" alt="">
        </button>
        <button type="button" class="note-editor-ai-btn note-editor-ai-btn-main" aria-label="AI assistant">
          <img src="img/my_students/note_bot_icon.svg" alt="">
        </button>
      </div>
    </div>
  </div>

  <div class="note-pro-tip">
    <span class="note-pro-tip-icon">
      <img src="img/my_students/pro_tip.svg" alt="Pro tip">
    </span>
    <span class="note-pro-tip-label">Pro tip:</span>
    <span>Give a preview of the upcoming lessons to motivate your student.</span>
  </div>

  <div class="note-bottom-divider"></div>

  <div class="note-bottom-actions">
    <a href="my_students_details_menu_give_feedback_details_preview_feedback_details.php" type="button" class="bottom-btn bottom-btn-ghost" id="previewFeedbackBtn">
      <span class="bottom-btn-icon">
        <img src="img/my_students/prev_feedback.svg" alt="Preview">
      </span>
      <span>Preview feedback</span>
 </a>

    <button type="button" class="bottom-btn bottom-btn-primary" id="sendFeedbackBtn">
      <span>Send feedback</span>
      <span class="bottom-btn-icon">
        <img src="img/my_students/send_feedback.svg" alt="Send">
      </span>
    </button>
  </div>
</section>
