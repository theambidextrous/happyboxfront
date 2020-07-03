<?php
session_start();
require_once '../lib/Order.php';


$allData = file_get_contents('php://input');
file_put_contents("allData.log", $allData, FILE_APPEND | LOCK_EX);
$token = 'faketoken';
if(isset($_SESSION['usr'])){
    $token = json_decode($_SESSION['usr'])->access_token;
}
$o = new Order($token);
$o->process_mpesa_c2b(json_decode($allData, true));
?>