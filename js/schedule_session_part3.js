    $(function() {
  // Hide all modals initially
  $('.custom-modal-overlay').hide();

  // On "NO" button click (assume your NO button has id="noBtn")
  $('#btn_no').on('click', function(e) {
    
    e.preventDefault();
    $('.custom-modal-overlay').hide(); // Hide all
$('#absenceModal').css('display', 'flex');
  });

  // Absence Modal: Close/back
  $('#absenceCloseBtn, #absenceBackBtn').on('click', function() {
    $('#absenceModal').hide();
  });

  // (Optional) Submit handler for absence
  $('.absence-submit-btn').on('click', function(e) {
    e.preventDefault();
    // You can validate and process form here
    alert('Reason submitted!');
    $('#absenceModal').hide();
  });
});


$(function(){
  // Open custom select
  $('#absenceSelectTrigger').on('click', function(e){
    var $wrap = $(this).closest('.absence-select-wrapper');
    $('.absence-select-wrapper').not($wrap).removeClass('open');
    $wrap.toggleClass('open');
    e.stopPropagation();
  });
  // Select option
  $('#absenceCustomList .custom-select-option').on('click', function(){
    var $option = $(this);
    $option.closest('.custom-select-list').find('.custom-select-option').removeClass('selected');
    $option.addClass('selected');
    var text = $option.text();
    var val  = $option.data('value');
    $('#absenceSelectTrigger .custom-select-placeholder').text(text).css('color','#232323');
    $('#absenceReason').val(val);
    $option.closest('.absence-select-wrapper').removeClass('open');
  });
  // Outside click closes
  $(document).on('mousedown', function(e){
    if (!$(e.target).closest('.absence-select-wrapper').length) {
      $('.absence-select-wrapper').removeClass('open');
    }
  });
  // Keyboard support
  $('#absenceSelectTrigger').on('keydown', function(e){
    if(e.key === "Enter" || e.key === " "){
      $(this).click();
      e.preventDefault();
    }
  });
});

