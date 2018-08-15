<?php
require_once '../../include/config.php';

logincheck();

$positive=array();
$negative=array();

$user_id=numOnly($_SESSION["user_id"]);
$query1="select name,amount from `moneybags_people` where amount>0 and user_id='{$user_id}'";
$query2="select name,amount from `moneybags_people` where amount<0 and user_id='{$user_id}'";

$result1=mysqli_query($con,$query1);
$result2=mysqli_query($con,$query2);

if($result1 && $result2){
	$output='{"status":"success"';
	//fetch 1st data
	while ($row=mysqli_fetch_assoc($result1)){
		$name=$row["name"];
		$amount=$row["amount"];
		$row="";
		$row["name"]=$name;
		$row["amount"]=abs($amount);
		$positive[]=$row;
	}
	$output.=', "positive":'.json_encode($positive);

	//fetch 2nd data
	while ($row=mysqli_fetch_assoc($result2)){
		$name=$row["name"];
		$amount=$row["amount"];
		$row="";
		$row["name"]=$name;
		$row["amount"]=abs($amount);
		$negative[]=$row;
	}
	$output.=', "negative":'.json_encode($negative);
	$output.='}';
}else{
	$output='{"status":"failure", "remark":"Something is wrong"}';
}

echo $output;

mysqli_close($con);
?>