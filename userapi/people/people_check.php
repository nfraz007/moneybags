<?php
require_once '../../include/config.php';

logincheck();

if(isset($_REQUEST["people_id"]) && $_REQUEST["people_id"]!=""){
	$people_id=numOnly($_REQUEST["people_id"]);
    $user_id=numOnly($_SESSION["user_id"]);
    $status=1;

    $query="select * from `moneybags_people` where `status`=1 and `people_id`=".$people_id." and `user_id`=".$user_id;
    $result=mysqli_query($con,$query);
    if(mysqli_num_rows($result)==1){
    	$output='{"status":"success"}';
    }else{
    	$output='{"status":"failure", "remark":"Sorry, This people not exist"}';
    }
}else{
  $output='{"status":"failure", "remark":"Invalid or Incomplete data recieved"}';
}

echo $output;

mysqli_close($con);
?>