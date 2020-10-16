<?php 
session_start();
require_once('../lib/Util.php');
require_once('../lib/User.php');
$util = new Util();
$util->ShowErrors();
$user = new User();
session_destroy();
$user->is_loggedin();
header('Location: ' . $util->PartnerHome());
?>
