<?php
session_start();
require_once('../lib/Util.php');
require_once('../lib/User.php');
$util = new Util();
?>
<html lang="en">

<head>

  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="">
  <meta name="author" content="">

  <title>Happy Box:: Partner Login</title>
  <!-- Bootstrap core CSS -->
 <?php include '../shared/partials/css.php'; ?>

</head>

<body>
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
                                        <p class="forgot_des text-center">
                      Enter the email address you use to sign in, and we’ll send you a link to reset your password.                      
                                        </p>
                        <form class="p_login">
						<div class="form-group">

  <input type="text" class="form-control rounded_form_control" placeholder="Email address">
</div>


                                    <button type="submit" class="btn btn_rounded">SEND LINK</button>
                                <p class="text-center gray_text small_p_margin_top">
								<a href="">Forgot password?</a>
									<a href="">| Not a registered partner? SIGN UP</a>
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
   <script>
    $(document).ready(function(){
        $("#forgotModal").modal('show');
    });
</script>
<!-- end pop up -->
 

</body>

</html>
