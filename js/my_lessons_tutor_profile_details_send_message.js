    $(function(){
      // Open Step 1
      $('.open_step1').on('click',()=>{
        $('#my_modal_backdrop, #send_message_modal').fadeIn(200);
      });

      // “Back” inside Step 1 → open Step 2
      $('#send_message_modal .back_to_list').on('click',()=>{
        $('#send_message_modal').hide();
        $('#messages_list_modal').fadeIn(200);
      });

      // “Back” inside Step 2 → return to Step 1
      $('#messages_list_modal .back_to_step1').on('click',()=>{
        $('#messages_list_modal').hide();
        $('#send_message_modal').fadeIn(200);
      });

      // Close everything
      $('.close_all').on('click',()=>{
        $('#my_modal_backdrop, .my_modal').fadeOut(200);
      });
    });
