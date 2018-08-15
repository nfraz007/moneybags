<?php
require_once '../../include/config.php';

logincheck();

if(isset($_REQUEST["people_id"]) && $_REQUEST["people_id"]!=""){
    $people_id=numOnly(filter_var($_REQUEST["people_id"],FILTER_SANITIZE_STRING));
    $user_id=$_SESSION["user_id"];

    if(peopleCheck($people_id)){
        $amount=-1*(int)getAmount($people_id);
        $remark="Settled";
        $current_date=date("Y-m-d H:i:s");
        $status=1;

        $query="insert into `moneybags_money` (`people_id`,`amount`,`remark`,`datetime`,`status`) values ('{$people_id}', '{$amount}', '{$remark}', '{$current_date}', '{$status}')";
        $result=mysqli_query($con,$query);
        if($result){
            if(updateAmount($people_id)){
                $output='{"status":"success", "remark":"Successfully settled"}';
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
    $output='{"status":"failure", "remark":"Invalid or Incomplete people recieved"}';
}

echo $output;

mysqli_close($con);
?>