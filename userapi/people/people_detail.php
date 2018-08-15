<?php
require_once '../../include/config.php';

logincheck();

if(isset($_REQUEST["people_id"]) && $_REQUEST["people_id"]!=""){
	$people_id=numOnly($_REQUEST["people_id"]);
    $status=1;
    $people=array();

    $query="select * from `moneybags_people` where `status`=1 and `people_id`=".$people_id;
    $result=mysqli_query($con,$query);
    if(mysqli_num_rows($result)==1){
        $row=mysqli_fetch_assoc($result);
        $people[]=$row;

    	$output='{"status":"success", "people":'.json_encode($people).'}';
    }else{
    	$output='{"status":"failure", "remark":"Sorry, This people not exist."}';
    }
}else{
  $output='{"status":"failure", "remark":"Invalid or Incomplete data recieved"}';
}

echo $output;

mysqli_close($con);
?>