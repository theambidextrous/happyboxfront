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
	<div class="row justify-content-aroundx section_padding_top">
		<div class="col-md-12">
			
			<div class="alert alert-danger"><strong>Failed!</strong> The transaction failed, please try again.</div>
			
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