<?php
require_once '../../include/config.php';

logincheck();

$user_id=numOnly($_SESSION["user_id"]);

$query="SELECT SUM(CASE WHEN amount>0 THEN amount ELSE 0 END) as positive,
   SUM(CASE WHEN amount<0 THEN amount ELSE 0 END) as negative
    FROM moneybags_people where user_id='{$user_id}'";
$result=mysqli_query($con,$query);
if(mysqli_num_rows($result)==1){
    $row=mysqli_fetch_assoc($result);
    $positive=$row["positive"];
    $negative=$row["negative"];

    $output='{"status":"success", "currency":"'.$_SESSION["currency"].'", "positive":"'.$positive.'", "negative":"'.$negative.'"}';
}else{
    $output='{"status":"failure", "remark":"Sorry, Something is wrong"}';
}

echo $output;

mysqli_close($con);
?>