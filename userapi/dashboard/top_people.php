<?php
require_once '../../include/config.php';

logincheck();

$user_id=numOnly($_SESSION["user_id"]);
$limit=10;
$people=array();

$query="select people_id,name,amount from `moneybags_people` where `user_id`='{$user_id}' order by popular desc,people_id desc limit {$limit}";
$result=mysqli_query($con,$query);
if(mysqli_num_rows($result)>0){
    while($row=mysqli_fetch_assoc($result)){
    	$people[]=$row;
    }
    $output='{"status":"success", "currency":"'.$_SESSION["currency"].'", "people":'.json_encode($people).'}';
}else{
    $output='{"status":"failure", "remark":"No people return"}';
}

echo $output;

mysqli_close($con);
?>