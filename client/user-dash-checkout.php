<?php
session_start();
require_once('../lib/Util.php');
require_once('../lib/User.php');
require_once('../lib/Picture.php');
require_once('../lib/Order.php');
$util = new Util();
$user = new User();
$picture = new Picture();
$util->ShowErrors(1);
if(!isset(json_decode($_SESSION['usr'])->access_token)){
    $_SESSION['next'] = 'user-dash-checkout.php';
    header("Location: user-login.php");
}
if(empty($_SESSION['unpaid_order'])){
    header("Location: user-dash-shipping.php");
}
$token = json_decode($_SESSION['usr'])->access_token;
$order = new Order($token);
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
<title>HappyBox :: User Checkout</title>

<!-- Bootstrap core CSS -->
<?php include '../shared/partials/css.php'; ?>
</head>

<body class="client_body">
<!-- Navigation -->
<?php include '../shared/partials/nav.php'; ?>

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

<!--end discover our selection-->
<section class="container section_padding_top  ">
	<div class="row">
		<div class="col-md-12">
			<h3 class="user_blue_title" >ORDER PAYMENT</h3>
		</div>
	</div>
	<!--progress strip-->
	<div class=" cart_progress_strip row">
		<div class="col-3 cart_strip">
		</div>
		<div class="col-3 shipping_strip">
		</div>
		<div class="col-3 summary_strip">
		</div>
		<div class="col-3 payment_strip">
		</div>
	</div>
	<br>
	<!--end progress strip-->
	<div class="row justify-content-center section_padding_top">
		<div class="col-md-12 text-center">
			<div class="card border_card_checkout">
				<?php
				$order_data = json_decode($order->get_one_byorder_limited($_SESSION['unpaid_order']), true)['data'];
				$bill_amount = number_format(($order_data['shipping_cost']+$order_data['subtotal']),0);
				$query_string = [
						'business' => $util->JpBusiness(),
						'order_id' => $_SESSION['unpaid_order'],
						'type' => 'cart',
						'amount1' => $bill_amount,
						'amount2' => 0,
						'amount5' => 0,
						'payee' => json_decode($_SESSION['usr'])->user->email,
						'shipping' => 'Sendy',
						'item' => 'Happy Box Voucher(s)',
						'channels' => '02610',
						'rurl' => $util->ClientHome().$util->JpReturn(),
						'curl' => $util->ClientHome().$util->JpCancel(),
						'furl' => $util->ClientHome().$util->JpFail()
				];
				// $util->Show($order_data);
				?>
				<b> ORDER NO: <?=$_SESSION['unpaid_order']?></b> <b> AMOUNT: KES <?=$bill_amount?></b> <br>
				Choose your preferred payment method to continue
			</div>
		</div>
		<div class="col-md-12">
			<div class="pay_strip" style="margin-bottom: 10px;margin-top: 10px;">
				<!-- <a href="" class="btn btn-sm btn-orange text-white">MPESA</a> 
        <a href="" class="btn btn-sm btn-orange text-white">CREDIT CARD</a> -->
				<ul class="nav nav-tabs" id="myTab" role="tablist">
					<li class="nav-item"> <a class="nav-link active btn btn-sm" id="mpesa-tab" data-toggle="tab" href="#mpesa" role="tab" aria-controls="mpesa" aria-selected="true">MPesa</a> </li>
					<li class="nav-item"> <a class="nav-link btn btn-sm" id="creditcard-tab" data-toggle="tab" href="#creditcard" role="tab" aria-controls="creditcard" aria-selected="false">Credit Card</a> </li>
				</ul>
				<div class="tab-content" id="myTabContent">
					<div class="tab-pane fade show active" id="mpesa" role="tabpanel" aria-labelledby="mpesa-tab">
						<h3>MPesa</h3>
						<p>Enter your Mpesa number below and click "Pay Now". The request will appear on your phone to enter your Mpesa PIN and complete the payment.<br> NB: Enter the number <strong>without country code e.g 07XX</strong></p>
						<div class="row">
							<div class="col-md-6">
								<div id="data">
								</div>
								<br>
								<form class="form_register_user" id="mpesa_pay_frm" name="mpesa_pay_frm">
									<div class="form-group col-md-12">
										<input type="hidden" value="<?=$_SESSION['unpaid_order']?>" name="ordernumber">
										<input type="hidden" value="<?=floor($order_data['shipping_cost']+$order_data['subtotal'])?>" name="orderamount">
										<input type="text" name="mpesaphone" class="form-control rounded_form_control" placeholder="Enter your mpesa phone e.g 07XX">
									</div>
									<p class="text-right col-md-12">
										<button type="button" onclick="mpesaPay('mpesa_pay_frm')" class="btn btn_rounded">Pay Now</button>
									</p>
        </form>
        <p id="retry_btn" class="payment_retry text-info" style="display:none;"><strong>Did not received PIN request?</strong> <a href="<?=$util->ClientHome()?>/user-dash-checkout.php">Click here to request again</a></p>
								<div id="back_btn" class="payment_back" style="display:none;">
					<a onclick="return confirm_click();" href="<?=$util->AppHome()?>" class="btn btn_rounded btn_checkout_back"><img src="<?=$util->AppHome()?>/shared/img/icn-arrow-teal.svg"> BACK TO HOMEPAGE</a>         
								</div>
							</div>
							<div class="col-md-6">
								<!-- instructions area -->
								<div id="msg"></div>
								<div id="express"></div>
								<!-- end debug -->
							</div>
						</div>
					</div>
					<div class="tab-pane fade" id="creditcard" role="tabpanel" aria-labelledby="creditcard-tab">
						<h3>Credit/debit Card</h3>
						<p>Pay securely with your credit/debit card.</p>
						<!-- jamboPay -->
						<div class="embed-responsive embed-responsive-16by9">
				<iframe id="jambopay_iframe" class="embed-responsive-item" frameBorder="0" src="https://www.jambopay.com/PreviewCart.aspx?<?=http_build_query($query_string)?>&target=_parent" scrolling="no">
                                </iframe>
						</div>
						<!-- end jamboPay -->
					</div>
				</div>
			</div>
		</div>
	</div>
	<!--   <div class="row justify-content-around section_padding_top">
		<div class="col-md-12">
			<div class="payment_back ">
				<a href="<?=$util->ClientHome()?>/user-dash-order-summary.php"><img src="<?=$util->AppHome()?>/shared/img/icn-arrow-teal.svg"> BACK TO ORDER SUMMARY</a>
			</div>
		</div>
	</div>--> 
</section>
<!--end add to cart cards--> 
<!-- pop up mpesa--> 
<!-- <button type="button" id="popupid" style="display:none;" class="btn btn_rounded" data-toggle="modal" data-target="#mpesaModal"></button>
	<div class="modal fade" id="mpesaModal">
			<div class="modal-dialog general_pop_dialogue">
					<div class="modal-content">
							<div class="modal-body text-center">
									<div class="col-md-12 text-center forgot-dialogue-borderz">
											<h3 class="partner_blueh">THANK YOU!</h3>
											<p class="forgot_des text-center txt-orange"><span id="vvv"></span></p>
									<div>
									<img src="<?=$util->AppHome()?>/shared/img/btn-okay-orange.svg" class="password_ok_img" data-dismiss="modal"/>
							</div>
					</div>
			</div>
	</div> --> 
<!--our partners -->
<?php include '../shared/partials/partners.php'; ?>
<?php include '../shared/partials/footer.php'; ?>
<!-- Bootstrap core JavaScript -->
<?php include '../shared/partials/js.php'; ?>
<script>
function confirm_click(){
 return confirm("You will not be able to complete your order if you navigate away from this page before you complete payment. Are you sure you want to navigate away? Click 'Cancel' to stay on this page.");
}
$(document).ready(function(){		
  s_event = function(){
			var source = new EventSource("<?=$util->AjaxHome()?>?activity=mpesa-express-status-check");
			source.onmessage = function(event){
			$('#data').html(event.data);
   $('#retry_btn').show();			
			$('#msg').hide();
			}
		}
		setTimeout(() => {
			s_event()
		}, 15000);

  //The back to homepage button should come later (after 30secs)
  setTimeout(function(){ $('#back_btn').show(); }, 30000);
		
		mpesaPay = function(FormId){
		waitingDialog.show('Sending... Please Wait',{headerText:'',headerSize: 6,dialogSize:'sm'});
		var dataString = $("form[name=" + FormId + "]").serialize();
		$.ajax({
			type: 'post',
			url: '<?=$util->AjaxHome()?>?activity=make-payment-mpesa',
			data: dataString,
			success: function(res){
				console.log(res);
				var rtn = JSON.parse(res);
				if(rtn.hasOwnProperty("MSG")){
					//Start Debug. To Comment out on prod
     //$('#c2b').text(rtn.c2b);
					//$('#express').text(rtn.exp);
					//$('#reg').text(rtn.reg);
					//$('#inst').html(rtn.inst);
     //End Debug
					$('#mpesa_pay_frm').hide();
					$('#msg').html(rtn.MSG);
					waitingDialog.hide();
					return;
				}
				else if(rtn.hasOwnProperty("ERR")){
					$('#msg').html(rtn.ERR);
					waitingDialog.hide();
					return;
				}
			}
		});
		}
});
</script>
<!--
<?php
if(strlen($_SESSION['status_chk_order'])){
?>
<script>
	$(document).ready(function(){
		s_event = function(){
			var source = new EventSource("<?=$util->AjaxHome()?>?activity=mpesa-express-status-check");
			source.onmessage = function(event){
   $('#data').html(event.data);
   $('#retry_btn').show();
			$('#back_btn').show();
			$('#msg').hide();
			}
		}
		setTimeout(() => {
			s_event()
		}, 15000);
	});
</script>
<?php
}
?>
-->
</body>
</html>
