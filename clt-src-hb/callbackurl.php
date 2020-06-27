<?php
session_start();
require_once '../lib/Util.php';
$util = new Util();
require_once '../lib/Box.php';
require_once '../lib/Picture.php';
require_once '../lib/Order.php';

$allData = file_get_contents('php://input');
file_put_contents("mpesaexpress.log", $allData, FILE_APPEND | LOCK_EX);
$o = new Order('faketoken');
$o->process_mpesa_express(json_encode($allData, true));
?>