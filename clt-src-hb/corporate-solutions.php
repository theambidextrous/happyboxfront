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
<title>HappyBox :: Corporate Solutions</title>

<!-- Bootstrap core CSS -->
<?php include 'shared/partials/css.php'; ?>
</head>

<body class="client_body">
<!-- Navigation -->
<?php include 'shared/partials/nav.php'; ?>
<!-- Page Content -->

<section class="contact_banner">
	<div class="container">
		<div class="row">
			<div class="col-md-12 text-center">
				<h3 class="text-white">CORPORATE SOLUTIONS</h3>
			</div>
		</div>
	</div>
</section>
<section class="contact_sub_banner">
	<div class="container">
		<div class="row justify-content-center">
			<div class="col-md-9 text-center desktop_view">
				<h4 class=""> Do you have a special request? Are you looking at a tailored gift for large numbers? Ready to make a very personalised gift?<br>
				Tell us about it!</h4>
			</div>
			<div class="col-md-9 text-center mobile_view">
				<h4 class=""> Do you have a special request?<br>
				Are you looking at a tailored gift for large numbers? Ready to make a very personalised gift?<br>
				<br>
				Tell us about it!</h4>
			</div>
		</div>
	</div>
</section>

<!--end discover our selection-->
<section class="container section_padding_top contact_content">
	<div class="row justify-content-center">
		<div class="col-md-5 contact_details">
			<h4 class="contact_title">Contact HAPPYBOX</h4>
			<div class="row">
				<div class="col-md-6 contact_p_txt">
					<p> <span class="contact_p"> <b>Contact Details</b></span><br>
						<b>Email:</b> <a href="mailto:customerservices@happybox.ke">customerservices@happybox.ke</a></p>
					<div class="col-md-6 contact_p_txt mobile_view ">
						<p> <span class="contact_p">  
						<b>Phone Number:</b> <a href="tel:+254112454540">+254 112 454 540</a><br><br>
						<b>Opening Hours </b></span><br>
							<b>Monday – Friday:</b> 9:00am - 5:00pm<br>
							<b>Saturday:</b> 9:00am – 12:00pm<br>
							<b>Sunday &amp; National Holidays:</b> Closed </p>
					</div>
					<p> <span class="contact_p"><b> Postal Address</b></span><br>
						P.O. Box 30275<br>
						00100<br>
						Nairobi<br>
						Kenya </p>
					<h3 class="send_us text-center mobile_view">SEND US YOUR ENQUIRY</h3>
				</div>
				<div class="col-md-6 contact_p_txt desktop_view">
					<p> <span class="contact_p">  
                                                <b>Phone Number:</b> <a href="tel:+254112454540">+254 112 454 540</a><br><br>
					<b>Opening Hours </b></span><br>
						<b>Monday – Friday:</b> 9:00am - 5:00pm<br>
						<b>Saturday:</b> 9:00am - 12:00pm<br>
						<b>Sunday &amp; National Holidays:</b> Closed </p>
				</div>
			</div>
		</div>
		<?=$util->msg_box()?>
		<div class="col-md-4 contact_form">
			<div class="form-group">
				<label for="name">Name</label>
				<input required type="text" class="form-control contact_control" name="name" placeholder="Required Field">
			</div>
			<div class="form-group">
				<label for="email">Email Address</label>
				<input required type="email" class="form-control contact_control" name="email" placeholder="Required Field">
			</div>
			<div class="form-group">
				<label for="Enquiry">Enquiry</label>
				<input required type="text" class="form-control contact_control" name="enquiry" placeholder="Required Field">
			</div>
			<div class="form-group">
				<label for="Details">Details</label>
				<textarea required class="form-control contact_control" rows="3" name="detail" placeholder="Please give us the details of your enquiry"></textarea>
			</div>
			<div class="form-group desktop_contact_btn">
				<button type="button" class="btn btn_contact" onclick="contact_msg('contactus')" >Send</button>
			</div>
		</div>
	</div>
	</form>
</section>
<!--end add to cart cards--> 
<!--our partners -->

<?php include 'shared/partials/partners.php';?>
<?php include 'shared/partials/footer.php';?>

<!-- Bootstrap core JavaScript -->

<?php include 'shared/partials/js.php';?>
<!-- pop up -->
<div class="modal fade" id="contactPop">
	<div class="modal-dialog general_pop_dialogue">
		<div class="modal-content">
			<div class="modal-body text-center">
				<div class="col-md-12 text-center forgot-dialogue-borderz">
					<h3 class="partner_blueh pink_title">THANK YOU! YOUR ENQUIRY HAS BEEN SENT.</h3>
					<p class="forgot_des text-center"> We will get back to you via email shortly. </p>
					<div>
						<img src="shared/img/btn-okay-orange.svg" class="password_ok_img" data-dismiss="modal"/>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>

<!-- end pop up -->

</body>
</html>
<script>  
$(document).ready(function(){

	contact_msg = function(FormId){
		waitingDialog.show('Sending... Please wait',{headerText:'',headerSize: 6,dialogSize:'sm'});
		var dataString = $("form[name=" + FormId + "]").serialize();
		$.ajax({
				type: 'post',
				url: '<?=$util->AjaxHome()?>?activity=contact-us',
				data: dataString,
				success: function(res){
						// console.log(res);
						var rtn = JSON.parse(res);
						if(rtn.hasOwnProperty("MSG")){
									$('#contactPop').modal('show');
									// $('#popupid').trigger('click');
									setTimeout(function(){
											location.reload();
									}, 3000);
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