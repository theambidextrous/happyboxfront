<?php
session_start();
require_once('../lib/Util.php');
require_once('../lib/User.php');
require_once('../lib/Picture.php');
$util = new Util();
$user = new User();
$picture = new Picture();
$util->ShowErrors(1);
// $util->ShowErrors();
$err = $msg = '';
if(isset($_POST['login'])){
	try{
			$user = new User(null, $_POST['email'], $_POST['password']);
			$news = '';
			if( isset($_POST['news']) && $_POST['news'] == '1'){
				$news = '00';
			}
			$login = $user->login($news);
		//   print $login;
		 if(isset(json_decode($login)->status)){
					if(json_decode($login)->status == '0'){
							$_SESSION['usr'] = $login;
							$info = $user->get_details(json_decode($login)->user->id);
							$_SESSION['usr_info'] = $info;
							if(!$util->is_client()){
									throw new Exception('Permission denied!');
									session_destroy();
							}
							if(isset($_SESSION['next'])){
								$util->redirect_to($_SESSION['next']);
							}else{
								$util->redirect_to('user-dash-activate-voucher.php');
							}
					}else{
							$err = $util->error_flash(json_decode($login)->message);
					}
		 }else{
			$err = $util->error_flash('No response from server');
		 }
	}catch(Exception $e){
			$err = $util->error_flash($e->getMessage());
			session_destroy();
	}
 }
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
<title>HappyBox :: User Login Page</title>
<!-- Bootstrap core CSS -->
<?php include '../shared/partials/css.php'; ?>
</head>

<body class="client_body client_login">
<!-- Navigation -->
<?php include '../shared/partials/nav.php'; ?>
<!-- Page Content -->

<section class=" user_account">
	<div class="container">
		<div class="row">
			<div class="col-md-12 text-center">
				<h3 class="text-white user_main_title_mob">USER LOGIN</h3>
			</div>
		</div>
	</div>
</section>
<section class=" user_account_sub_banner">
	<div class="container">
		<div class="row justify-content-center">
			<div class="col-md-9 text-center">
				<h5 class="">Please login or create an account.</h5>
			</div>
		</div>
	</div>
</section>

<!--end discover our selection-->
<section class="container section_padding_top contact_content">
	<div class="row justify-content-center">
		<div class="col-md-5 user_login_l  ">
			<h3 class="user_account_title text-center">HAPPYBOX ACCOUNT LOGIN</h3>
			<form class="user_login" method="post">
				<?=$err?>
				<div class="form-group">
					<input type="email" name="email" class="form-control rounded_form_control" placeholder="Email address">
				</div>
				<div class="form-group">
					<input type="password" name="password" class="form-control rounded_form_control" placeholder="Password">
				</div>
				<div class="form-group user_blue_border">
					<div class="form-check">
						<label class="form-check-label">
                <input type="checkbox" name="news" class="form-check-input" value="1"> <span class="span_blue"> Stay Connected</span> 
                </label> <br>
						<small class="text-orange">Sign-up for news on latest deals and new boxes</small>
					</div>
				</div>
				<p class="text-center">
					<button type="submit" name="login" class="btn btn_rounded">LOGIN</button>
				</p>
				<p class="text-center gray_text small_p_margin_top"> <a href="user-forgot.php">Forgot password?</a> </p>
				<p class="text-orange text-center"> Don't have an account yet? </p>
				<p class="text-center mob_bottom_marg"> <a href="user-create-account.php" class="btn btn_rounded">CREATE YOUR ACCOUNT </a> </p>
			</form>
		</div>
		<div class="col-md-5  user_login_r mob_bottom_marg">
			<div class="card user_login_card">
				<div class="card-header bg_card_blue text-center text-white">
					<b>Why register your voucher early?</b>
				</div>
				<div class="card-body">
					<div class="row user_login_card_col">
						<div class="col-2">
							<img src="<?=$util->AppHome()?>/shared/img/icons/check_orange.svg" class="list_icon">
						</div>
						<div class="col-10">
							Consult the validity status of your box
						</div>
					</div>
					<div class="row user_login_card_col user_login_card_col2">
						<div class="col-2">
							<img src="<?=$util->AppHome()?>/shared/img/icons/check_orange.svg" class="list_icon">
						</div>
						<div class="col-10">
							Receive an email reminder to book your experience before your voucher expires
						</div>
					</div>
					<div class="row user_login_card_col">
						<div class="col-2">
							<img src="<?=$util->AppHome()?>/shared/img/icons/check_orange.svg" class="list_icon">
						</div>
						<div class="col-10">
							Activate the loss and theft warranty
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</section>
<!--end add to cart cards--> 
<!--our partners -->

<?php include '../shared/partials/partners.php';?>
<?php include '../shared/partials/footer.php';?>

<!-- Bootstrap core JavaScript -->

<?php include '../shared/partials/js.php';?>
</body>
</html>
