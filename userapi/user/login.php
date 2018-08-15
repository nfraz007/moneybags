<?php
require_once '../../include/config.php';

if(isset($_REQUEST["email"]) && $_REQUEST["email"]!=""){
  if(isset($_REQUEST["password"]) && $_REQUEST["password"]!="" && strlen($_REQUEST["password"])>=6){
    $email = filter_var($_REQUEST["email"], FILTER_SANITIZE_EMAIL);
    $password=md5($_REQUEST["password"]);

    $query="select * from `moneybags_user` where `email`='{$email}' and `password`='{$password}'";
    $result=mysqli_query($con,$query);
    if(mysqli_num_rows($result)==1){
      //return a valid user
      $row=mysqli_fetch_assoc($result);
      $user_id=$row["user_id"];
      $fname=$row["fname"];
      $lname=$row["lname"];
      $email=$row["email"];
      $currency_id=$row["currency_id"];
      $verified=$row["verified"];
      $status=$row["status"];

      //extra work, get user currency
      $currency="";
      $query="select `html` from `moneybags_currency` where `currency_id`='{$currency_id}'";
      $result=mysqli_query($con,$query);
      if(mysqli_num_rows($result)==1){
        $row=mysqli_fetch_assoc($result);
        $currency=$row["html"];
      }else{
        $currency="&#8377;";
      }

      //extra work, get user date
      $date="";
      $query="select `date` from `moneybags_date` where `date_id`='{$date_id}'";
      $result=mysqli_query($con,$query);
      if(mysqli_num_rows($result)==1){
        $row=mysqli_fetch_assoc($result);
        $date=$row["date"];
      }else{
        $date="M-d-Y";
      }

      if($status==1){
        if($verified==1){
          $query="insert into `moneybags_user_history` (`user_id`,`ip_address`,`datetime`) values ('{$user_id}', '".getIPAddress()."', '".date("Y-m-d H:i:s")."')";
          if(mysqli_query($con,$query)){
            $output = '{"status":"success","remark":"you are successfully login","user_id":"'.$user_id.'","fname":"'.$fname.'","lname":"'.$lname.'","email":"'.$email.'", "currency":"'.$currency.'", "date":"'.$date.'" }';
            $_SESSION["user_id"]=$user_id;
            $_SESSION["fname"]=$fname;
            $_SESSION["lname"]=$lname;
            $_SESSION["email"]=$email;
            $_SESSION["currency"]=$currency;
            $_SESSION["date"]=$date;
          }else{
            $output='{"status":"failure", "remark":"Something is wrong with query"}';
          }
        }else{
          $output='{"status":"failure", "remark":"Your account is not verified, please verify your account"}';
        }
      }else{
        $output='{"status":"failure", "remark":"Sorry you are blocked by MoneyBags"}';
      }
    }else{
      $output='{"status":"failure", "remark":"Invalid email or password recieved"}';
    }
  }else{
    $output='{"status":"failure", "remark":"Invalid or Incomplete password recieved"}';
  }
}else{
  $output='{"status":"failure", "remark":"Invalid or Incomplete email recieved"}';
}

echo $output;
mysqli_close($con);
?>