<?php 
session_start();
require_once('../lib/Util.php');
require_once('../lib/User.php');
require_once('../lib/Picture.php');
require_once('../lib/Order.php');
$util = new Util();
$user = new User();
$picture = new Picture();
// $util->ShowErrors(1);

$allData = file_get_contents('php://input');
// $allData = 'JP_TRANID=31825170&JP_MERCHANT_ORDERID=KUOU8DG8OM&JP_ITEM_NAME=Happybox&JP_AMOUNT=24300.00&JP_CURRENCY=KES&JP_TIMESTAMP=20201103153135&JP_PASSWORD=719c2ac5d1f8a073914f25e6f2b6e754&JP_CHANNEL=VISA';
file_put_contents("jpLogs.log", $allData, FILE_APPEND | LOCK_EX);
parse_str($allData, $_POST);
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
<title>HappyBox :: Jambopay Checkout</title>

<!-- Bootstrap core CSS -->
<?php include '../shared/partials/css.php'; ?>
</head>
<body>
<div class="container">
	<div class="row  section_padding_top">
		<div class="col-md-12">
			
			<?php
			$token = 'faketoken';
			if(isset($_SESSION['usr'])){
				$token = json_decode($_SESSION['usr'])->access_token;
			}
			if( !is_null($_POST) ){
				$o = new Order($token);
				$o->process_jp($_POST);
			}
			// exit(json_encode(['action' => 'the end']));
			?>
			<div class="payment_back"><a href="<?=$util->ClientHome()?>" class="btn btn_rounded btn_checkout_back" target="_parent"><img src="<?=$util->AppHome()?>/shared/img/icn-arrow-teal.svg"> BACK TO HOMEPAGE</a>
			</div>
		</div>
	</div>
</div>
</body>
<!-- Bootstrap core JavaScript -->
<?php include '../shared/partials/js.php'; ?>
</body>
</html>