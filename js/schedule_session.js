  $(document).ready(function() {
    // Show first modal on page load
    $('.modal-backdrop, #sessionModal').fadeIn(170);

    // YES button shows Modal 2
    $('.modal-btn.yes').click(function() {
      $('#sessionModal').fadeOut(130, function() {
        $('#topicModal').fadeIn(170);
      });
    });
    
    
    // NO button closes all
    $('.modal-btn.no').click(function() {
      $('.modal-backdrop, #sessionModal, #topicModal').fadeOut(130);
    });

    // Backdrop closes any open modal
    $('.modal-backdrop').click(function() {
      $('.custom-modal:visible').fadeOut(130);
      $(this).fadeOut(130);
    });

    // Toggle note area in Modal 2
    $('.note-link').click(function() {
      $(this).toggleClass('open');
      $('.note-area').slideToggle(130);
    });

    // Prevent form submit and close modal
    $('#topicModal form').submit(function(e){
      e.preventDefault();
      alert("Submitted!");
      $('.modal-backdrop, #topicModal').fadeOut(130);
    });
  });



