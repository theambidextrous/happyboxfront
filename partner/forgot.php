<?php
session_start();
require_once('../lib/Util.php');
require_once('../lib/User.php');
$util = new Util();
?>
<!DOCTYPE html>
<html lang="en">

<head>

  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=0" />
<!--meta words-->
<meta name="keywords" content="vouchers,birthday gift,valentine gift,gift a gift,christmas gift,easter gift,wedding gift,anniversary gift">
<meta name="description" content="HappyBox issues vouchers to its customers via its website. Each voucher is an opportunity to suggest an appropriate set of experiences for the recipient of the voucher.">
<meta name="robots" content="index, follow">
<link rel="canonical" href="https://happybox.ke/">
<meta property="og:locale" content="en_US">
<meta property="og:type" content="website">
<meta property="og:title" content="HappyBox">
<meta property="og:description" content="HappyBox issues vouchers to its customers via its website. Each voucher is an opportunity to suggest an appropriate set of experiences for the recipient of the voucher.">
<meta property="og:url" content="https://happybox.ke/">
<meta property="og:site_name" content="HappyBox">
<meta property="og:image" content="https://happybox.ke/shared/img/logo.svg">
<meta property="og:image:width" content="320">
<meta property="og:image:height" content="88">        
        <!--end meta words -->

  <title>Happy Box:: Partner Login</title>
  <!-- Bootstrap core CSS -->
 <?php include '../shared/partials/css.php'; ?>

</head>

<body class="partner_wrap">
  <!-- Navigation -->
 <?php include '../shared/partials/nav.php'; ?>
  <section  class="blue_band text-center">
			<h2 class="">HAPPYBOX PARTNER PORTAL</h2>
			</section>
<section class=" text-center section_60 partner_forgot">
            <div class="container">
			
               
                    <div class="row justify-content-center">
                    <div class="col-md-4 text-center ">
          <h3 class="partner_blueh">FORGOT YOUR PASSWORD?</h3>
          <?php ?>
          <p class="forgot_des text-center">Enter the email address you use to sign in, and we’ll send you a link to reset your password.</p>
          <?=$util->msg_box()?>
          <form class="p_login" method="post" name="forgot">
            <div class="form-group">
              <input type="email" name= "email" class="form-control rounded_form_control" placeholder="Email address">
            </div>
            <button type="button" onclick="forgot_pwd('forgot')" class="btn btn_rounded">SEND LINK</button>
            <p class="text-center gray_text small_p_margin_top">
              <a href="login.php">Back to login</a>
              <a href="become-a-partner.php">| Not a registered partner? SIGN UP</a>
            </p>
          </form>
          </div>

                </div>
              </div>
        </section>

<?php include '../shared/partials/footer.php';?>
  <!-- Page Content -->

  <!-- Bootstrap core JavaScript -->
  
<?php include '../shared/partials/js.php';?>
   
  
 
 
<!-- pop up -->
<button type="button" id="popupid" style="display:none;" class="btn btn_rounded" data-toggle="modal" data-target="#forgotModal"></button>
<div class="modal fade" id="forgotModal">
    <div class="modal-dialog general_pop_dialogue">
      <div class="modal-content">
        <div class="modal-body text-center">
          <div class="col-md-12 text-center forgot-dialogue-borderz">
            <h3 class="partner_blueh">YOUR REQUEST HAS BEEN SENT</h3>
            <p class="forgot_des text-center">Please check your emails for a link to reset your password</p>
            <div><img src="../shared/img/btn-okay-blue.svg" class="password_ok_img" data-dismiss="modal"/></div>
          </div>
      </div>
      </div>
    </div>
  </div>
  <!-- end popup -->
</body>
<script>
  $(document).ready(function(){
    forgot_pwd = function(FormId){
      waitingDialog.show('sending... Please wait',{headerText:'',headerSize: 6,dialogSize:'sm'});
      var dataString = $("form[name=" + FormId + "]").serialize();
      $.ajax({
          type: 'post',
          url: '<?=$util->AjaxHome()?>?activity=forgot-rest-link',
          data: dataString,
          success: function(res){
              console.log(res);
              var rtn = JSON.parse(res);
              if(rtn.hasOwnProperty("MSG")){
                  $("#reset_div").load(window.location.href + " #reset_div" );
                  $('#popupid').trigger('click');
                  waitingDialog.hide();
                  return;
              }
              else if(rtn.hasOwnProperty("ERR")){
                $('#err').text(rtn.ERR);
                $('#err').show(rtn.ERR);
                waitingDialog.hide();
                return;
              }
          }
      });
    }
  });  
</script>
</html>
