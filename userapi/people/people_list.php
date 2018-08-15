<?php
require_once '../../include/config.php';

logincheck();

$obj=(object)$_REQUEST;
$obj->status="1";
$obj->user_id=$_SESSION["user_id"];
$data=peopleList($obj);

echo $data;

mysqli_close($con);
?>