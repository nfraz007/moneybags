<?php
require_once '../../include/config.php';

logincheck();
userBlock();

if(isset($_REQUEST["people_id"]) && $_REQUEST["people_id"]!=""){
	$people_id=numOnly($_REQUEST["people_id"]);
    $user_id=$_SESSION["user_id"];

    if(peopleCheck($people_id)){
        //delete their money history
        $query="delete from `moneybags_money` where `people_id`='{$people_id}'";
        $result=mysqli_query($con,$query);
        if($result){
            $query="delete from `moneybags_people` where `people_id`='{$people_id}'";
            $result=mysqli_query($con,$query);
            if($result){
                $output='{"status":"success", "remark":"Successfully deleted"}';
            }else{
                $output='{"status":"failure", "remark":"Something is wrong"}';
            }
        }else{
            $output='{"status":"failure", "remark":"Something is wrong"}';
        }
    }else{
        $data='{"status":"failure", "remark":"Sorry, This people not exist"}';
    }
}else{
  $output='{"status":"failure", "remark":"Invalid or Incomplete data recieved"}';
}

echo $output;

mysqli_close($con);
?>