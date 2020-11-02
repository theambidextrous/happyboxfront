<?php 
session_start();
require_once '../lib/Order.php';

$allData = file_get_contents('php://input');
file_put_contents("jpLogs.log", $allData, FILE_APPEND | LOCK_EX);
$token = 'faketoken';
if(isset($_SESSION['usr'])){
    $token = json_decode($_SESSION['usr'])->access_token;
}
if( !is_null($_POST) ){
    $o = new Order($token);
    $o->process_jb($_POST);
    print('<h1>FINAL DESTINATION</h1>');
}else{
    print '<h1>HTTP:200</h1>';
}

// put your code here
// $logfile = 'logs.log';
// $datetime = date('dmY_His');
// $jpData = file_get_contents('php://input');
// file_put_contents('jpLogs.log', $jpData.PHP_EOL, FILE_APPEND | LOCK_EX);

// if (isset($_POST['JP_PASSWORD'])) {

//     $JP_TRANID = $_POST['JP_TRANID'];
//     $JP_MERCHANT_ORDERID = $_POST['JP_MERCHANT_ORDERID'];
//     $JP_ITEM_NAME = $_POST['JP_ITEM_NAME'];
//     $JP_AMOUNT = $_POST['JP_AMOUNT'];
//     $JP_CURRENCY = $_POST['JP_CURRENCY'];
//     $JP_TIMESTAMP = $_POST['JP_TIMESTAMP'];
//     $JP_PASSWORD = $_POST['JP_PASSWORD'];
//     $JP_CHANNEL = $_POST['JP_CHANNEL'];

//     //$sharedkey, IS ONLY SHARED BETWEEN THE MERCHANT AND JAMBOPAY. THE KEY SHOULD BE SECRET ********************

//     //Make sure you get the key from JamboPay Support team
//     $sharedkey = '6127482F-35BC-42FF-A466-276C577E7DF3';

//     $str = $JP_MERCHANT_ORDERID . $JP_AMOUNT . $JP_CURRENCY . $sharedkey . $JP_TIMESTAMP;

//     //**************** VERIFY *************************
//     if (md5(utf8_encode($str)) == $JP_PASSWORD) {
//         //VALID
//         //if valid, mark order as paid

//     }else{
//         //INVALID TRANSACTION

//     }
// }
?>