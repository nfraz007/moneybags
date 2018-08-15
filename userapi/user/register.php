<?php
require_once '../../include/config.php';

if(!PRODUCTION){
  if(isset($_REQUEST["fname"]) && $_REQUEST["fname"]!=""){
    if(isset($_REQUEST["lname"]) && $_REQUEST["lname"]!=""){
      if(isset($_REQUEST["email"]) && $_REQUEST["email"]!=""){
        if(isset($_REQUEST["password"]) && $_REQUEST["password"]!="" && strlen($_REQUEST["password"])>=6){
          $fname=filter_var($_REQUEST["fname"],FILTER_SANITIZE_STRING);
          $lname=filter_var($_REQUEST["lname"],FILTER_SANITIZE_STRING);
          $email = filter_var($_REQUEST["email"], FILTER_SANITIZE_EMAIL);
          $password=md5($_REQUEST["password"]);

          $query="select * from `moneybags_user` where `email`='{$email}'";
          $result=mysqli_query($con,$query);
          if(mysqli_num_rows($result)==0){
            //user is not exist. insert into db
            $currency_id=1;//default currency id indian rupee
            $status=0;//user is inactive. when admin will activate this user, user can login
            $verified=1;//user is verified
            $otp=mt_rand(1000,9999);
            $security_key=md5($otp);
            $current_date=date("Y-m-d H:i:s");
            //send mail
            $query="INSERT INTO `moneybags_user`(`currency_id`,`fname`,`lname`,`email`,`password`,`verified`,`status`,`registered_on`) VALUES ('{$currency_id}','{$fname}','{$lname}', '{$email}','{$password}', '{$verified}', '{$status}', '{$current_date}')";
            if(mysqli_query($con,$query)){
              
              $output='{"status":"success", "remark":"Your account is created. please login and enjoy MoneyBags"}';
            }else{
              $output='{"status":"failure", "remark":"Something is wrong with query"}';
            }
          }else{
            //user exist
            $output='{"status":"failure", "remark":"Email is already exist"}';
          }
        }else{
          $output='{"status":"failure", "remark":"Invalid or Incomplete password recieved"}';
        }
      }else{
        $output='{"status":"failure", "remark":"Invalid or Incomplete email recieved"}';
      }
    }else{
      $output='{"status":"failure", "remark":"Invalid or Incomplete last name recieved"}';
    }
  }else{
    $output='{"status":"failure", "remark":"Invalid or Incomplete first name recieved"}';
  }
}else{
  $output='{"status":"failure", "remark":"Sorry, This function is disabled"}';
}
echo $output;
mysqli_close($con);
   
?>