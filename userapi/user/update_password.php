<?php
require_once '../../include/config.php';

logincheck();
userBlock();

if(isset($_REQUEST["old_password"]) && $_REQUEST["old_password"]!="" && strlen($_REQUEST["old_password"])>=6){
	if(isset($_REQUEST["new_password"]) && $_REQUEST["new_password"]!="" && strlen($_REQUEST["new_password"])>=6){
		$user_id=numOnly($_SESSION["user_id"]);

		$old_password=md5($_REQUEST["old_password"]);
        $new_password=md5($_REQUEST["new_password"]);

        $query="select * from `moneybags_user` where `password`='{$old_password}' and `user_id`=".$user_id;
        $result=mysqli_query($con,$query);
        if(mysqli_num_rows($result)==1){
            $query="update `moneybags_user` set `password`='{$new_password}' where `user_id`=".$user_id;
            $result=mysqli_query($con,$query);
            if($result){
                $output='{"status":"success", "remark":"Successfully updated"}';
            }else{
                $output='{"status":"failure", "remark":"Something is wrong"}';
            }
        }else{
            $output='{"status":"failure", "remark":"Your old password is wrong"}';
        }
	}else{
	  $output='{"status":"failure", "remark":"Invalid or Incomplete New Password recieved"}';
	}
}else{
  $output='{"status":"failure", "remark":"Invalid or Incomplete Old Password recieved"}';
}

echo $output;
mysqli_close($con);
?>