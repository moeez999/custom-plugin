
<link rel="stylesheet" href="css/schedule_session.css">
<link rel="stylesheet" href="css/schedule_session_part2.css">
<link rel="stylesheet" href="css/schedule_session_part3.css">


<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>

  <!-- Modal Overlay -->

<div class="modal-backdrop"></div>

<!-- MODAL 1 -->
<div class="custom-modal" id="sessionModal">
  <div class="modal-header">
    <h2>Did you teach your<br>session with FL1 on<br>November 11?</h2>
  </div>
  <div class="modal-body">
    <p>
      Please confirm whether you conducted your scheduled session with FL1 on November 11. Your response helps ensure accurate attendance and lesson tracking.
    </p>
  </div>
  <div class="modal-actions">
    <button class="modal-btn yes">Yes</button>
    <button class="modal-btn no" id="btn_no">No</button>
  </div>
</div>
 
  <?php require_once('schedule_session_part2.php');?>
  <?php require_once('schedule_session_part3.php');?>

  <script src="js/schedule_session.js"></script>
  <script src="js/schedule_session_part2.js"></script>
  <script src="js/schedule_session_part3.js"></script>

