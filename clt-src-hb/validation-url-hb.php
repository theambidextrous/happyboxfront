<?php
$allData = file_get_contents('php://input');
file_put_contents("allData.log", $allData, FILE_APPEND | LOCK_EX);
?>