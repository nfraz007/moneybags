<?php
require_once '../../include/config.php';

logincheck();
userBlock();

if(isset($_REQUEST["name"]) && $_REQUEST["name"]!=""){
	if(isset($_REQUEST["description"]) && $_REQUEST["description"]!=""){
		$name=filter_var($_REQUEST["name"],FILTER_SANITIZE_STRING);
        $description=filter_var($_REQUEST["description"],FILTER_SANITIZE_STRING);
        $user_id=$_SESSION["user_id"];
        $current_date=date("Y-m-d H:i:s");
        $status=1;

        if(strlen($name)<=20){
            if(strlen($description)<=50){
                $query="insert into `moneybags_people` (`user_id`,`name`,`description`,`datetime`,`status`) values ('{$user_id}', '{$name}', '{$description}', '{$current_date}', '{$status}')";
		        $result=mysqli_query($con,$query);
		        if($result){
		        	$output='{"status":"success", "remark":"Successfully added"}';
		        }else{
		        	$output='{"status":"failure", "remark":"Something is wrong"}';
		        }
            }else{
                $output='{"status":"failure", "remark":"Description must be less than 50 characters"}';
            }
        }else{
            $output='{"status":"failure", "remark":"Name must be less than 20 characters"}';
        }
	}else{
	  $output='{"status":"failure", "remark":"Invalid or Incomplete description recieved"}';
	}
}else{
  $output='{"status":"failure", "remark":"Invalid or Incomplete name recieved"}';
}

echo $output;

mysqli_close($con);
?>