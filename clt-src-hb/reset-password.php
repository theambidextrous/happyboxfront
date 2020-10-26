<?php
session_start();
require_once('../lib/Util.php');
require_once('../lib/User.php');
require_once('../lib/Picture.php');
$util = new Util();
$user = new User();
$picture = new Picture();
$util->ShowErrors(1);
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
<meta name="description" content="">
<meta name="author" content="">
<title>HappyBox :: User Reset Password</title>

<!-- Bootstrap core CSS -->
<?php include 'shared/partials/css.php'; ?>
</head>

<body class="client_body">
<!-- Navigation -->
<?php include 'shared/partials/nav.php'; ?>
<!-- Page Content -->

<section class=" user_account">
	<div class="container">
		<div class="row">
			<div class="col-md-12 text-center">
				<h3 class="text-white">RESET YOUR HAPPYBOX ACCOUNT PASSWORD</h3>
			</div>
		</div>
	</div>
</section>
<section class=" user_account_sub_banner">
	<div class="container">
		<div class="row justify-content-center">
			<div class="col-md-9 text-center">
				<h5 class=""> To reset your HAPPYBOX account password you will need to complete the following form.</h5>
			</div>
		</div>
	</div>
</section>
<!--end discover our selection-->
<section class="container section_padding_top contact_content">
	<div class="row justify-content-center">
		<div class="col-md-8 user_login_l  ">
			<div class="card user_login_card user_create_l">
				<div class="card-body text-center">
					<h3 class="text-center">HAPPYBOX</h3> <h4 class="text-center">An experience for everyone</h4>
					<?php 
					if(!isset($_REQUEST['token'])){
							print $util->error_flash('Invalid token!');
					}else{
							if(isset($_POST['resetpwd'])){
									try{
											$util->ValidatePasswordStrength($_POST['password']);
											if($_POST['password'] != $_POST['password_confirmation']){
													print $util->error_flash('Passwords must match!');
											}elseif(!$user->is_valid_mail($_POST['email'])){
													print $util->error_flash('Invalid email!');
											}else{
													$body = [
															'email' => $_POST['email'],
															'password' => $_POST['password'],
															'password_confirmation' => $_POST['password_confirmation'],
															'token' => $_REQUEST['token']
													];
													$resp = $user->pwd_reset($body);
													if( json_decode($resp)->status == '0' ){
															print $util->success_flash('Account password reset.');
													}else{
															print $util->error_flash(json_decode($resp)->message);
													}
											}
									}catch(Exception $e ){
											print $util->error_flash($e->getMessage()); 
									}
							}
					?>
					<!-- start -->
					<form method="post">
						<div class="form_register_user">
							<p><strong>Good passwords should:-</strong></p>
							<i><span>1. Be at least 8 characters in length.</span> <span>2. Include at least one upper case letter.</span><span>3. Include one number.</span><span> 4. Include one special character.</span></i> <br>
							<br>
							<br>
							<div class="form-group">
								<div class="row">
									<div class="col-md-4">
										<label> Your Account Email Address</label>
									</div>
									<div class="col-md-8">
										<input type="email" name="email" class="form-control rounded_form_control" placeholder="Required Field">
									</div>
								</div>
							</div>
							<div class="form-group">
								<div class="row">
									<div class="col-md-4">
										<label> New Password</label>
									</div>
									<div class="col-md-8">
										<input type="password" class="form-control rounded_form_control" placeholder="Required Field" name="password">
									</div>
								</div>
							</div>
							<div class="form-group">
								<div class="row">
									<div class="col-md-4">
										<label>Confirm New Password</label>
									</div>
									<div class="col-md-8">
										<input type="password" class="form-control rounded_form_control" placeholder="Required Field" name="password_confirmation">
									</div>
								</div>
							</div>
							<p class="text-right">
								<button type="submit" class="btn btn_rounded" name="resetpwd">RESET PASSWORD</button>
							</p>
						</div>
					</form>
					<!-- end -->
					<?php
					}
					?>
				</div>
			</div>
			<br>
		</div>
		<!-- <div class="col-md-5  user_login_r">
				<div class=" user_create_r">
							 
				</div>
		</div> -->
	</div>
</section>
<!--end add to cart cards--> 
<!--our partners -->
<?php include 'shared/partials/partners.php'; ?>
<?php include 'shared/partials/footer.php'; ?>
<!-- Bootstrap core JavaScript -->
<?php include 'shared/partials/js.php'; ?>
<!-- pop up -->
<div class="modal fade" id="userCreatedModal">
	<div class="modal-dialog general_pop_dialogue">
		<div class="modal-content">
			<div class="modal-body text-center">
				<div class="col-md-12 text-center forgot-dialogue-borderz">
					<h3 class="partner_blueh">YOU HAVE SUCCESSFULLY RESET YOUR ACCOUNT PASSWORD!</h3> 
					<!-- <p class="forgot_des text-center txt-orange">You can now login.</p> -->
					<div>
						<img src="shared/img/btn-okay-blue.svg" class="password_ok_img" data-dismiss="modal"/>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>

<!-- end pop up -->

</body>
</html>
