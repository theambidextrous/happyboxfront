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

$allData = file_get_contents('php://input');
// $allData = 'JP_TRANID=31825170&JP_MERCHANT_ORDERID=WTNZQVE3UQ&JP_ITEM_NAME=Happybox&JP_AMOUNT=25300.00&JP_CURRENCY=KES&JP_TIMESTAMP=20201103153135&JP_PASSWORD=719c2ac5d1f8a073914f25e6f2b6e754&JP_CHANNEL=VISA';
file_put_contents("jpLogs.log", $allData, FILE_APPEND | LOCK_EX);
parse_str($allData, $_POST);
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
<meta name="description" content="">
<meta name="author" content="">
<title>HappyBox :: Jambopay Checkout</title>

<!-- Bootstrap core CSS -->
<?php include 'shared/partials/css.php'; ?>
</head>
<body>
<div class="container">
	<div class="row justify-content-around section_padding_top">
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
			<div class="payment_back">
				<a href="<?=$util->ClientHome()?>" class="btn btn_rounded" target="_parent"><img src="shared/img/icn-arrow-teal.svg"> BACK TO HOMEPAGE</a>
			</div>
		</div>
	</div>
</div>
</body>
<!-- Bootstrap core JavaScript -->
<?php include 'shared/partials/js.php'; ?>
</body>
</html>