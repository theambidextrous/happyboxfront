<?php
session_start();
require_once '../lib/Order.php';

$allData = file_get_contents('php://input');
// $allData = '{"Body":{"stkCallback":{"MerchantRequestID":"9272-16323772-1","CheckoutRequestID":"ws_CO_221020202254031363","ResultCode":0,"ResultDesc":"The service request is processed successfully.","CallbackMetadata":{"Item":[{"Name":"Amount","Value":10.00},{"Name":"MpesaReceiptNumber","Value":"OJM1QWJ2BL"},{"Name":"Balance"},{"Name":"TransactionDate","Value":20201022224357},{"Name":"PhoneNumber","Value":254722463498}]}}}}';
file_put_contents("mpesaexpress.log", $allData, FILE_APPEND | LOCK_EX);
$token = 'faketoken';
if(isset($_SESSION['usr'])){
    $token = json_decode($_SESSION['usr'])->access_token;
}
if(!is_null(json_decode($allData, true))){
    $o = new Order($token);
    $o->process_mpesa_express(json_decode($allData, true));
}else{
    print '<h1>HTTP:200</h1>';
}
?>