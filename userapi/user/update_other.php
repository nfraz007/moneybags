<?php
require_once '../../include/config.php';

logincheck();

if(isset($_REQUEST["currency_id"]) && $_REQUEST["currency_id"]!=""){
    if(isset($_REQUEST["date_id"]) && $_REQUEST["date_id"]!=""){
        $user_id=numOnly($_SESSION["user_id"]);

        $currency_id=numOnly($_REQUEST["currency_id"]);
        $date_id=numOnly($_REQUEST["date_id"]);

        $query="select * from `moneybags_currency` where `currency_id`=".$currency_id;
        $result=mysqli_query($con,$query);
        if(mysqli_num_rows($result)==1){
            $row=mysqli_fetch_assoc($result);
            $currency=$row["html"];

            $query="select * from `moneybags_date` where `date_id`=".$date_id;
            $result=mysqli_query($con,$query);
            if(mysqli_num_rows($result)==1){
                $row=mysqli_fetch_assoc($result);
                $date=$row["date"];

                $query="update `moneybags_user` set `currency_id`='{$currency_id}', `date_id`='{$date_id}' where `user_id`=".$user_id;
                $result=mysqli_query($con,$query);
                if($result){
                    $_SESSION["currency"]=$currency;
                    $_SESSION["date"]=$date;
                    $output='{"status":"success", "remark":"Successfully updated"}';
                }else{
                    $output='{"status":"failure", "remark":"Something is wrong"}';
                }
            }else{
                $output='{"status":"failure", "remark":"No Such Date exist"}';
            }
        }else{
            $output='{"status":"failure", "remark":"No Such Country exist"}';
        }
    }else{
        $output='{"status":"failure", "remark":"Invalid or Incomplete Date recieved"}';
    }
}else{
  $output='{"status":"failure", "remark":"Invalid or Incomplete Currency recieved"}';
}

echo $output;
mysqli_close($con);
?>