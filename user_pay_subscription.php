<style>
    /* backdrop */
#membership_withdraw_backdrop {
  display: none;
  position: fixed;
  top:0; left:0; right:0; bottom:0;
  background: rgba(0,0,0,0.5);
  z-index: 99;
}

/* modal container */
#membership_withdraw_modal {
  display: none;
  position: fixed;
  top:50%; left:50%;
  transform: translate(-50%, -50%);
  width: 90%; max-width: 400px;
  background: #fff;
  border-radius: 8px;
  box-shadow: 0 8px 24px rgba(0,0,0,0.2);
  z-index:100;
  font-family: sans-serif;
}

/* header */
.membership_withdraw_modal_header {
  display: flex;
  justify-content: space-between;
  align-items: center;
  padding: 16px;
}
.membership_withdraw_modal_header h2 {
  margin: 0;
  font-size: 1.25em;
  display: flex;
  align-items: center;
}
.membership_withdraw_close {
  background:none;
  border:none;
  font-size:1.5em;
  cursor:pointer;
}

/* body */
.membership_withdraw_modal_body {
  padding: 16px;
  font-size: 0.95em;
}
.membership_withdraw_modal_body p {
  margin: 0 0 12px;
}
.membership_withdraw_modal_body hr {
  border: none;
  border-top: 1px solid #eee;
  margin: 12px 0;
}
.membership_withdraw_price {
  text-align: center;
  font-size: 1.1em;
}

/* footer */
.membership_withdraw_modal_footer {
  padding: 16px;
}
#membership_withdraw_proceed_btn {
  width: 100%;
  background: #e60000;
  color: #fff;
  border: none;
  padding: 12px;
  font-size: 1em;
  border-radius: 4px;
  cursor: pointer;
}
</style>

<div id="membership_withdraw_backdrop"></div>
<div id="membership_withdraw_modal">
  <div class="membership_withdraw_modal_header">
    <h2><img src="lock-icon.svg" alt="" style="width:32px; vertical-align:middle; margin-right:8px;">Pay Subscription</h2>
    <button class="membership_withdraw_close">&times;</button>
  </div>
  <div class="membership_withdraw_modal_body">
    <p>Please, renew your subscription to access your account and classes.</p>
    <hr>
    <p class="membership_withdraw_price">Price: <strong>$20</strong></p>
  </div>
  <div class="membership_withdraw_modal_footer">
    <button id="membership_withdraw_proceed_btn">Pay Now</button>
  </div>
</div>


<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<script>
$(function(){
  $('#membership_withdraw_backdrop, #membership_withdraw_modal').fadeIn(200);

  $('.membership_withdraw_close, #membership_withdraw_backdrop').on('click', function(){
    $('#membership_withdraw_backdrop, #membership_withdraw_modal').fadeOut(200);
  });

  $('#membership_withdraw_proceed_btn').on('click', function(){
    alert('Taking you to payment gateway…');
  });
});
</script>

