<?php
session_start();
require_once('../lib/Util.php');
require_once('../lib/User.php');
require_once('../lib/Inventory.php');
require_once('../lib/Box.php');
require_once('../lib/Picture.php');
$util = new Util();
$user = new User();
$picture = new Picture();
$util->ShowErrors(1);
if(!$util->is_client()){
    header('Location: user-login.php');
}
$inventory = new Inventory();
$box = new Box();
$token = json_decode($_SESSION['usr'])->access_token;
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
<meta name="description" content="">
<meta name="author" content="">
<title>HappyBox :: User Activate Voucher</title>
<!-- Bootstrap core CSS -->
<?php include '../shared/partials/css.php'; ?>
<style>
.user-register {
	color: #c20a2b!important;
	text-decoration: none!important;
	border-bottom: solid 2px #04C1C9 !important;
}
</style>
</head>

<body class="client_body client_login">
<!-- Navigation -->
<?php include '../shared/partials/nav.php'; ?>
<!--user dash nav-->
<section class="">
	<div class="container">
		<div class="row">
			<div class="col-md-12 text-center">
			</div>
		</div>
	</div>
</section>

<!--end user dash nav--> 
<!-- Page Content -->
<section class=" user_account_sub_banner desktop_view">
	<div class="container">
		<div class="row user_logged_in_nav">
			<div class="col-md-12">
				<?php include '../shared/partials/nav-mid.php'; ?>
			</div>
		</div>
	</div>
</section>
<!--mobile header start-->
<section class=" user_account mobile_view">
	<div class="container">
		<div class="row">
			<div class="col-md-12 text-center">
				<h3 class="text-white user_main_title_mob">REGISTER YOUR HAPPYBOX VOUCHER</h3>
			</div>
		</div>
	</div>
</section>
<!--mobile header end--> 
<!--end discover our selection-->
<section class="container section_60 ">
	<div class="row justify-content-center">
		<div class="col-md-5  text-center user_activate_l desktop_view">
			<h3 class="user_blue_title ">REGISTER YOUR VOUCHER</h3>
			<p class="txt-orange">Enter your voucher code and click activate</p>
			<div class="card border_blue_radius text-center user_activate_card">
				<form name="activate_vcher" class="activate_v_class">
					<?=$util->msg_box()?>
					<div class="row">
						<div class="col-md-8">
							<input type="hidden" name="customer_user_id" value="<?=json_decode($_SESSION['usr_info'])->data->internal_id?>">
							<input type="text" name="vcode" class="form-control rounded_form_control vcode text-left" placeholder="Enter your voucher code here">
						</div>
						<div class="col-md-4">
							<button type="button" onclick="activate_voucher('activate_vcher')" class="btn btn_rounded btn-orange">ACTIVATE</button>
						</div>
					</div>
				</form>
			</div>
		</div>
		<div class="col-md-5 desktop_view">
			<div class="user_activate_r">
				<div class="user_activate_steps">
					<img src="<?=$util->AppHome()?>/shared/img/user_iwant.png" class="w-100"/>
					<div class="border_blue_radius card_v_steps">
						<div class="user_activate_steps_i">
							<div class="row">
								<div class="col-1">
									<span class="inline_div inline_div_first">1</span>
								</div>
								<div class="col-11">
									<b>ACTIVATE</b> your voucher
								</div>
							</div>
						</div>
						<div class="user_activate_steps_i user_activate_steps_i_mid">
							<div class="row">
								<div class="col-1">
									<span class="inline_div">2</span>
								</div>
								<div class="col-11">
									<b>SELECT</b> one experience in the booklet
								</div>
							</div>
						</div>
						<div class="user_activate_steps_i user_activate_steps_i_mid">
							<div class="row">
								<div class="col-1">
									<span class="inline_div ">3</span>
								</div>
								<div class="col-11 book_row">
									<b>BOOK</b> your experience with the partner and share your voucher code with them
								</div>
							</div>
						</div>
						<div class="user_activate_steps_i user_activate_steps_i_last">
							<div class="row">
								<div class="col-1">
									<span class="inline_div_last inline_div ">4</span>
								</div>
								<div class="col-11">
									<b> ENJOY</b> your experience
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
		<!-- start mobile-->
		
		<div class="col-md-5 mobile_view">
			<div class="user_activate_r">
				<div class="user_activate_steps">
					<img src="<?=$util->AppHome()?>/shared/img/user_iwant.png" class="w-100 desktop_view"/> <img src="<?=$util->AppHome()?>/shared/img/iwant_mob.png" class="w-100 neg_img mobile_view"/>
					<div class="border_blue_radius card_v_steps">
						<div class="user_activate_steps_i">
							<div class="row">
								<div class="col-3">
									<span class="inline_div inline_div_first">1</span>
								</div>
								<div class="col-9 neg_top">
									<b>ACTIVATE</b> your voucher
								</div>
							</div>
						</div>
						<div class="user_activate_steps_i user_activate_steps_i_mid">
							<div class="row">
								<div class="col-3">
									<span class="inline_div">2</span>
								</div>
								<div class="col-9 neg_top">
									<b>SELECT</b> one experience in the booklet
								</div>
							</div>
						</div>
						<div class="user_activate_steps_i user_activate_steps_i_mid">
							<div class="row">
								<div class="col-3">
									<span class="inline_div ">3</span>
								</div>
								<div class="col-9 neg_top">
									<b>BOOK</b> your experience with the partner and share your voucher code with them
								</div>
							</div>
						</div>
						<div class="user_activate_steps_i user_activate_steps_i_last">
							<div class="row">
								<div class="col-3">
									<span class="inline_div_last inline_div ">4</span>
								</div>
								<div class="col-9 neg_top">
									<b> ENJOY</b> your experience
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
		<div class="col-md-5  text-center user_activate_l mobile_view">
			<h3 class="user_blue_title ">REGISTER YOUR VOUCHER</h3>
			<p class="txt-orange">Enter your voucher code and click activate code</p>
			<div class="card border_blue_radius text-center user_activate_card no_border_mob">
				<form name="activate_v" class="activate_v_class">
					<?=$util->msg_box()?>
					<div class="row">
						<div class="col-md-8">
							<input type="hidden" name="customer_user_id" value="<?=json_decode($_SESSION['usr_info'])->data->internal_id?>">
							<input type="text" name="vcode" class="form-control rounded_form_control vcode" placeholder="Required Field">
						</div>
						<div class="col-md-4">
							<br class="mobile_view">
							<button type="button" onclick="activate_voucher('activate_v')" class="btn btn_rounded btn-orange user_activate_btn_orange">ACTIVATE</button>
						</div>
					</div>
				</form>
			</div>
		</div>
	</div>
</section>
<!--end add to cart cards--> 
<!--our partners -->
<?php include '../shared/partials/partners.php'; ?>
<?php include '../shared/partials/footer.php'; ?>
<!-- Bootstrap core JavaScript -->
<?php include '../shared/partials/js.php'; ?>
<!-- pop up -->
<button type="button" id="popupid" style="display:none;" class="btn btn_rounded" data-toggle="modal" data-target="#userVoucherActivate"></button>
<div class="modal fade" id="userVoucherActivate">
	<div class="modal-dialog general_pop_dialogue">
		<div class="modal-content">
			<div class="modal-body text-center">
				<div class="col-md-12 text-center forgot-dialogue-borderz">
					<h3 class="partner_blueh ">YOUR VOUCHER HAS BEEN SUCCESSFULLY ACTIVATED!</h3>
					<p class="forgot_des text-center txt-orange"> You will receive an email confirming your voucher activation. </p>
					<p class="forgot_des text-center txt-orange"> Remember to redeem your experience before <b><span id="vvv"></span></b> </p>
					<div>
						<img src="<?=$util->AppHome()?>/shared/img/btn-okay-orange.svg" class="password_ok_img" data-dismiss="modal"/>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<!-- end pop up -->
</body>
<script>  
    $(document).ready(function(){
      activate_voucher = function(FormId){
      waitingDialog.show('Activating... Please wait',{headerText:'',headerSize: 6,dialogSize:'sm'});
      var dataString = $("form[name=" + FormId + "]").serialize();
      $.ajax({
          type: 'post',
          url: '<?=$util->AjaxHome()?>?activity=activate-clt-voucher',
          data: dataString,
          success: function(res){
              console.log(res);
              var rtn = JSON.parse(res);
              if(rtn.hasOwnProperty("MSG")){
                  $("#reset_div").load(window.location.href + " #reset_div" );
                  $("#vvv").text(rtn.Valid);
                  $('#err').hide();
                  $('.vcode').val("");
                  $('#popupid').trigger('click');
                  waitingDialog.hide();
                  return;
              }
              else if(rtn.hasOwnProperty("ERR")){
                  $('#err').text(rtn.ERR);
                  $('#err').show();
                  waitingDialog.hide();
                  return;
              }
          }
      });
      }
  });  
</script>
</html>
