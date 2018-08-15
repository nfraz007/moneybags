<?php
require_once '../../include/config.php';

logincheck();

$obj=(object)$_REQUEST;
$output=moneyDelete($obj);

echo $output;

mysqli_close($con);
?>