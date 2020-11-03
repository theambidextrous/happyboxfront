<?php 
session_start();
require_once '../lib/Order.php';

$allData = file_get_contents('php://input');
file_put_contents("jpLogs.log", $allData, FILE_APPEND | LOCK_EX);
/* 
$token = 'faketoken';
if(isset($_SESSION['usr'])){
    $token = json_decode($_SESSION['usr'])->access_token;
}
if( !is_null($_POST) ){
    $o = new Order($token);
    $o->process_jb($_POST);
    echo '<div class="alert alert-success">Thank you! Your payment was completed successfully.</div>';
}else{
    print '<h1>HTTP:200</h1>';
}
 */
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
			//************************ CHECK IF VALUES HAVE BEEN SET *****************
			if (isset($_POST['JP_PASSWORD'])) {
				//Print response from JamboPay - DEV PURPOSE ONLY
				echo '<pre>';
				print_r($_POST);
				echo '</pre>';	
				
				$JP_TRANID = $_POST['JP_TRANID'];
				$JP_MERCHANT_ORDERID = $_POST['JP_MERCHANT_ORDERID'];
				$JP_ITEM_NAME = $_POST['JP_ITEM_NAME'];
				$JP_AMOUNT = $_POST['JP_AMOUNT'];
				$JP_CURRENCY = $_POST['JP_CURRENCY'];
				$JP_TIMESTAMP = $_POST['JP_TIMESTAMP'];
				$JP_PASSWORD = $_POST['JP_PASSWORD'];
				$JP_CHANNEL = $_POST['JP_CHANNEL'];
				
				//$sharedkey, IS ONLY SHARED BETWEEN THE MERCHANT AND JAMBOPAY. THE KEY SHOULD BE SECRET ********************
				
				//Make sure you get the key from JamboPay Support team
				$sharedkey = '6127482F-35BC-42FF-A466-276C577E7DF3';
				
				$str = $JP_MERCHANT_ORDERID . $JP_AMOUNT . $JP_CURRENCY . $sharedkey . $JP_TIMESTAMP;
				
				//**************** VERIFY *************************
				if (md5(utf8_encode($str)) == $JP_PASSWORD) {
					//VALID
					//if valid, mark order as paid
					
					echo '<div class="alert alert-success"><strong>Thank you!</strong> Your payment was completed successfully.</div>';		
				}else{
					//INVALID TRANSACTION
					
					echo '<div class="alert alert-danger"><strong>Failed!</strong> The transaction failed, please try again.</div>';			
				}
			}			
			?>
			
			<div class="payment_back">
				<a href="<?=$util->ClientHome()?>"><img src="shared/img/icn-arrow-teal.svg"> BACK TO HOMEPAGE</a>
			</div>
		</div>
	</div>
</div>
</body>
<!-- Bootstrap core JavaScript -->
<?php include 'shared/partials/js.php'; ?>
</body>
</html>