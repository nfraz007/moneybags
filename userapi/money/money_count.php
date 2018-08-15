<?php
require_once '../../include/config.php';

logincheck();

if(isset($_REQUEST["people_id"]) && $_REQUEST["people_id"]!=""){
	$people_id=numOnly($_REQUEST["people_id"]);
    $status=1;

    $query="SELECT SUM(CASE WHEN amount<0 THEN amount ELSE 0 END) as negative,
       SUM(CASE WHEN amount>=0 THEN amount ELSE 0 END) as positive
        FROM moneybags_money where people_id=".$people_id;
    $result=mysqli_query($con,$query);
    if(mysqli_num_rows($result)==1){
        $row=mysqli_fetch_assoc($result);
        $positive=(int)$row["positive"];
        $negative=(int)$row["negative"];
        $balance=$positive+$negative;

    	$output='{"status":"success", "currency":"'.$_SESSION["currency"].'", "balance":"'.$balance.'", "positive":"'.$positive.'", "negative":"'.$negative.'"}';
    }else{
    	$output='{"status":"failure", "remark":"Sorry, Something is wrong"}';
    }
}else{
  $output='{"status":"failure", "remark":"Invalid or Incomplete data recieved"}';
}

echo $output;

mysqli_close($con);
?>