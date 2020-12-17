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
<?php include '../shared/partials/css.php'; ?>
</head>
<body>
<div class="container">
	<div class="row  section_padding_top">
		<div class="col-md-12">
			
			<div class="alert alert-danger"><strong>Cancelled!</strong> The transaction was cancelled, please try again.</div>
			
			<div class="payment_back">
				<a href="<?=$util->ClientHome()?>" class="btn btn_rounded" target="_parent"><img src="<?=$util->AppHome()?>/shared/img/icn-arrow-teal.svg"> BACK TO HOMEPAGE</a>
			</div>
		</div>
	</div>
</div>
</body>
<!-- Bootstrap core JavaScript -->
<?php include '../shared/partials/js.php'; ?>
</body>
</html>