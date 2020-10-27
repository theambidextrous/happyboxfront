<?php
session_start();
require_once('../lib/Util.php');
require_once('../lib/User.php');
require_once('../lib/Inventory.php');
require_once('../lib/Box.php');
require_once('../lib/Shipping.php');
require_once('../lib/Picture.php');
$util = new Util();
$user = new User();
$s = new Shipping();
if(!$util->is_client()){
    header('Location: user-login.php');
}
$picture = new Picture();
$util->ShowErrors(1);
$inventory = new Inventory();
$box = new Box();
$token = json_decode($_SESSION['usr'])->access_token;
$profile_data_ = json_decode($_SESSION['usr_info'])->data;
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
<meta name="description" content="">
<meta name="author" content="">
<title>HappyBox :: User Dashboard My Profile</title>

<!-- Bootstrap core CSS -->
<?php include 'shared/partials/css.php'; ?>
<style>
.user-profile {
	color: #c20a2b!important;
	text-decoration: none!important;
	border-bottom: solid 2px #04C1C9 !important;
}
</style>
</head>

<body class="client_body">
<!-- Navigation -->
<?php include 'shared/partials/nav.php'; ?>
<!-- Page Content -->
<section class=" user_account_sub_banner">
	<div class="container">
		<div class="row user_logged_in_nav">
			<div class="col-md-12">
				<?php include 'shared/partials/nav-mid.php'; ?>
			</div>
		</div>
	</div>
</section>
<!--end discover our selection-->
<section class="container section_padding_top contact_content" id="reset_div">
	<?php 
		$act_ = 1;
		// $util->Show($_SESSION['usr_shipping']);
		// unset($_SESSION['usr_shipping']);
		if(!isset($_SESSION['usr_shipping'])){
			$_SESSION['usr_shipping'] = $s->get_one($token, $profile_data_->internal_id);
		}
		$shipping_ = json_decode($_SESSION['usr_shipping'])->data;
		if($shipping_->customer_id){
			$act_ = 2;
		}
	?>
	<div class="row ">
		<div class="col-md-12">
			<h3 class="user_blue_title text-center">MY PROFILE DETAILS</h3>
			<p class="txt-orange text-center">Update your profile and delivery details here</p>
			<?=$util->msg_box()?>
		</div>
	</div>
	<div class="row justify-content-center user_profile_edit">
		<div class="col-md-4  ">
			<div class=" ">
				<h5 class="blue_text">PROFILE DETAILS</h5>
				<form class="form_register_user" id="edit_account_frm" name="edit_account_frm">
					<div class="form-group">
						<label>First Name</label>
						<input type="hidden" name="user_id" value="<?=json_decode($_SESSION['usr'])->user->id?>">
						<input type="text" name="fname" class="form-control rounded_form_control" value="<?=$profile_data_->fname?>">
					</div>
					<div class="form-group">
						<label>Surname</label>
						<input type="text" name="sname" class="form-control rounded_form_control" value="<?=$profile_data_->sname?>">
					</div>
					<div class="form-group">
						<label>Email Address</label>
						<input readonly type="email" name="email" class="form-control rounded_form_control" value="<?=json_decode($_SESSION['usr'])->user->email?>">
					</div>
					<div class="form-group">
						<label>Mobile</label>
						<input type="text" name="phone" class="form-control rounded_form_control" value="<?=$profile_data_->phone?>">
					</div>
					<p class="text-right">
						<button type="button" onclick="edit_account('edit_account_frm')" class="btn btn_rounded user_btn">UPDATE MY DETAILS</button>
					</p>
				</form>
			</div>
		</div>
		<div class="col-md-4 user_profile_right">
			<div class=" ">
				<h5 class="text-orange">PHYSICAL DELIVERY DETAILS</h5>
				<form class="form_register_user" name="ship_frm" id="ship_frm">
					<div class="form-group">
						<label>Address</label>
						<input type="hidden" name="act" value="<?=$act_?>">
						<input type="hidden" name="customer_id" value="<?=$profile_data_->internal_id?>">
						<input type="text" name="address" class="form-control rounded_form_control" value="<?=$shipping_->address?>">
					</div>
					<div class="form-group">
						<label>City</label>
						<input type="text" name="city" class="form-control rounded_form_control" value="<?=$shipping_->city?>">
					</div>
					<div class="form-group">
						<label>Province</label>
						<input type="text" name="province" class="form-control rounded_form_control" value="<?=$shipping_->province?>">
					</div>
					<div class="form-group">
						<label>Postal Code</label>
						<input type="text" name="postal_code" class="form-control rounded_form_control" value="<?=$shipping_->postal_code?>">
					</div>
					<p class="text-right">
						<button type="button" onclick="edit_shipping('ship_frm')" class="btn btn_rounded  btn-orange">UPDATE MY DELIVERY DETAILS</button>
					</p>
				</form>
			</div>
		</div>
	</div>
</section>
<!--end add to cart cards--> 
<!--our partners -->

<?php include 'shared/partials/partners.php'; ?>
<?php include 'shared/partials/footer.php'; ?>

<!-- Bootstrap core JavaScript -->

<?php include 'shared/partials/js.php'; ?>
</body>
<!-- pop up -->
<button type="button" id="popupid" style="display:none;" class="btn btn_rounded" data-toggle="modal" data-target="#userCreatedModal"></button>
<div class="modal fade" id="userCreatedModal">
	<div class="modal-dialog general_pop_dialogue">
		<div class="modal-content">
			<div class="modal-body text-center">
				<div class="col-md-12 text-center forgot-dialogue-borderz">
					<h3 class="partner_blueh">THANK YOU!</h3>
					<p class="forgot_des text-center txt-orange"><span id="vvv"></span></p>
					<div>
						<img src="shared/img/btn-okay-orange.svg" class="img-btn password_ok_img" data-dismiss="modal"/>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<script>
  $(document).ready(function(){

  // ============ SHIPPING =======================
  edit_shipping = function(FormId){
      waitingDialog.show('Updating... Please wait',{headerText:'',headerSize: 6,dialogSize:'sm'});
      var dataString = $("form[name=" + FormId + "]").serialize();
      // var dataString =  new FormData($('#' + FormId )[0]);
      // console.log(dataString);
      $.ajax({
          type: 'post',
          url: '<?=$util->AjaxHome()?>?activity=add-clt-shipping',
          data: dataString,
          success: function(res){
              console.log(res);
              var rtn = JSON.parse(res);
              if(rtn.hasOwnProperty("MSG")){
                //   $("#reset_div").load(window.location.href + " #reset_div" );
                  $('#vvv').text('Your shipping details have been updated.');
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
  // =============== ACCUNT DATA ================
  edit_account = function(FormId){
      waitingDialog.show('Updating... Please wait',{headerText:'',headerSize: 6,dialogSize:'sm'});
      // var dataString = $("form[name=" + FormId + "]").serialize();
      var dataString =  new FormData($('#' + FormId )[0]);
      $.ajax({
          type: 'post',
          url: '<?=$util->AjaxHome()?>?activity=edit-clt-account',
          data: dataString,
          contentType: false,
          processData: false,
          success: function(res){
              console.log(res);
              var rtn = JSON.parse(res);
              if(rtn.hasOwnProperty("MSG")){
                //   $("#reset_div").load(window.location.href + " #reset_div" );
                  $('#vvv').text('Your profile details have been updated.');
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
<!-- end pop up -->

</html>
