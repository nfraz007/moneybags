<?php
require_once '../../include/config.php';

logincheck();

if(isset($_REQUEST["amount"]) && $_REQUEST["amount"]!=""){
	if(isset($_REQUEST["remark"]) && $_REQUEST["remark"]!=""){
        if(isset($_REQUEST["people_id"]) && $_REQUEST["people_id"]!=""){
            if(isset($_REQUEST["type"]) && ( $_REQUEST["type"]=="1" || $_REQUEST["type"]=="-1" )){
                $people_id=numOnly(filter_var($_REQUEST["people_id"],FILTER_SANITIZE_STRING));
                $amount=(int)filter_var($_REQUEST["amount"],FILTER_SANITIZE_STRING);
                $remark=filter_var($_REQUEST["remark"],FILTER_SANITIZE_STRING);
                $type=(int)filter_var($_REQUEST["type"],FILTER_SANITIZE_STRING);
                $user_id=$_SESSION["user_id"];
                $current_date=date("Y-m-d H:i:s");
                $status=1;

                if(peopleCheck($people_id)){
                    if($amount>0 && $amount<=100000){
                        if(strlen($remark)<=50){
                            $amount=$amount*$type;
                            $query="insert into `moneybags_money` (`people_id`,`amount`,`remark`,`datetime`,`status`) values ('{$people_id}', '{$amount}', '{$remark}', '{$current_date}', '{$status}')";
                            $result=mysqli_query($con,$query);
                            if($result){
                                if(updateAmount($people_id)){
                                    $output='{"status":"success", "remark":"Successfully added"}';
                                }else{
                                    $output='{"status":"failure", "remark":"Something is wrong"}';
                                }
                            }else{
                                $output='{"status":"failure", "remark":"Something is wrong"}';
                            }
                        }else{
                            $output='{"status":"failure", "remark":"Remark must be less than 50 characters"}';
                        }
                    }else{
                        $output='{"status":"failure", "remark":"Amount must be in range 1 to 1,00,000"}';
                    }
                }else{
                    $output='{"status":"failure", "remark":"Sorry, This people not exist"}';
                }
            }else{
                $output='{"status":"failure", "remark":"Invalid or Incomplete data recieved"}';
            }
        }else{
            $output='{"status":"failure", "remark":"Invalid or Incomplete people recieved"}';
        }
	}else{
	  $output='{"status":"failure", "remark":"Invalid or Incomplete remark recieved"}';
	}
}else{
  $output='{"status":"failure", "remark":"Invalid or Incomplete amount recieved"}';
}

echo $output;

mysqli_close($con);
?>