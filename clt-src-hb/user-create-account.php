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
<title>HappyBox :: User Create Account</title>

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
				<h3 class="text-white user_main_title_mob">CREATE YOUR HAPPYBOX ACCOUNT</h3>
			</div>
		</div>
	</div>
</section>
<section class=" user_account_sub_banner">
	<div class="container">
		<div class="row justify-content-center">
			<div class="col-md-9 text-center">
				<h5 class=""> To register your HAPPYBOX voucher you will need an account. Please login or create one. </h5>
			</div>
		</div>
	</div>
</section>

<!--end discover our selection-->
<section class="container section_padding_top contact_content" id="reset_div">
	<div class="row justify-content-center">
		<div class="col-md-5 user_login_l  ">
			<div class="card user_login_card user_create_l">
				<div class="card-body text-center">
					<h3 class="text-center">HAPPYBOX</h3> <h4 class="text-center">An experience for everyone</h4>
					<div class="step_div">
						<p> CHOOSE <strong>WHAT</strong> </p>
						<img src="shared/img/choose_what.svg" class="w-100"/>
					</div>
					<div class="step_div">
						<p> CHOOSE <strong>WHERE</strong> </p>
						<img src="shared/img/choose_where.svg" class="w-100"/>
					</div>
					<div class="step_div">
						<p> CHOOSE <strong>WHEN</strong> </p>
						<img src="shared/img/choose_when.svg" class="w-100"/>
					</div>
					<div class="step_div">
						<p> <span class="unique-font">Choose</span> <span class="special-font"><strong>HAPPYBOX</strong></span> </p>
						<img src="shared/img/choose_happy.svg" class="w-100"/>
					</div>
				</div>
			</div>
			<p class="text-center mobile_view mob_gray_txt"> <br>
				Already have an account? <a href="user-login.php" class=" bold_txt"><b> LOGIN</b> </a> </p>
			<p class="text-center gray_text small_p_margin_top desktop_view user_create_p"> <br>
				Already have an account? <a href="user-login.php" class=" bold_txt text-black"><b> LOGIN</b> </a> </p>
		</div>
		<div class="col-md-5  user_login_r">
			<div class=" user_create_r">
				<?=$util->msg_box()?>
				<form class="form_register_user" name='newaccount'>
					<div class="form-group">
						<label>First Name</label>
						<input type="text" name="fname" class="form-control rounded_form_control" placeholder="Required Field">
					</div>
					<div class="form-group">
						<label>Surname</label>
						<input type="text" name="sname" class="form-control rounded_form_control" placeholder="Required Field">
					</div>
					<div class="form-group">
						<label>Email Address</label>
						<input type="email" name="email" class="form-control rounded_form_control" placeholder="Required Field">
					</div>
					<div class="form-group">
						<label>Mobile</label>
						<input type="text" name="phone" class="form-control rounded_form_control" placeholder="Required Field">
					</div>
					<div class="form-group">
						<label>Password</label>
						<input id="input_password" type="password" name="password" class="form-control rounded_form_control" placeholder="Required Field">
						<div id="toggle_pwd_guide" class="password_requirements collapse">
							<span>&#10003; From 8 to 16 characters</span><br>
							<span>&#10003; At least 1 upper case letter</span><br>
							<span>&#10003; At least 1 number</span><br>
							<span>&#10003; At least 1 special character</span>
						</div>
					</div>
					<div class="form-group">
						<label>Confirm password</label>
						<input type="password" name="c_password" class="form-control rounded_form_control" placeholder="Required Field">
					</div>
					<p class="text-right text-right-mob-center">
						<button onclick="new_account('newaccount')" type="button" class="btn btn_rounded">CREATE YOUR ACCOUNT</button>
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
<!-- pop up -->
<button type="button" id="popupid" style="display:none;" class="btn btn_rounded" data-toggle="modal" data-target="#userCreatedModal"></button>
<div class="modal fade" id="userCreatedModal">
	<div class="modal-dialog general_pop_dialogue">
		<div class="modal-content">
			<div class="modal-body text-center">
				<div class="col-md-12 text-center forgot-dialogue-borderz">
					<h3 class="partner_blueh">YOU HAVE SUCCESSFULLY CREATED YOUR ACCOUNT!</h3>
					<p class="forgot_des text-center txt-orange">A confirmation email has been sent to you. Please click on the link to activate your account.</p>
					<div>
						<img src="shared/img/btn-okay-blue.svg"  class="password_ok_img" data-dismiss="modal"/>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<!-- end pop up --> 
<script>
  $(document).ready(function(){
    
		$("#input_password").focus(function(){
			$("#toggle_pwd_guide").collapse('show');
		});
		
		new_account = function(FormId){
    waitingDialog.show('Creating... Please wait',{headerText:'',headerSize: 6,dialogSize:'sm'});
    var dataString = $("form[name=" + FormId + "]").serialize();
    $.ajax({
        type: 'post',
        url: '<?=$util->AjaxHome()?>?activity=new-account',
        data: dataString,
        success: function(res){
            console.log(res);
            var rtn = JSON.parse(res);
            if(rtn.hasOwnProperty("MSG")){
                $("#reset_div").load(" #reset_div > *");
                // $("#reset_div").load(location.href + " #reset_div" );
                $('#popupid').trigger('click');
                        /* setTimeout(function(){
                    location.reload();
                }, 3000);*/
            $(location).attr('href', 'user-login.php')
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
</body>
</html>
