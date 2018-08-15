<?php
require_once '../../include/config.php';

logincheck();

if(isset($_REQUEST["people_id"]) && $_REQUEST["people_id"]!=""){
    if(isset($_REQUEST["name"]) && $_REQUEST["name"]!=""){
        if(isset($_REQUEST["description"]) && $_REQUEST["description"]!=""){
            $people_id=numOnly($_REQUEST["people_id"]);
            $name=filter_var($_REQUEST["name"],FILTER_SANITIZE_STRING);
            $description=filter_var($_REQUEST["description"],FILTER_SANITIZE_STRING);

            if(peopleCheck($people_id)){
                if(strlen($name)<=20){
                    if(strlen($description)<=50){
                        $query="update `moneybags_people` set `name`='{$name}', `description`='{$description}' where `people_id`=".$people_id;
                        $result=mysqli_query($con,$query);
                        if($result){
                            $output='{"status":"success", "remark":"Successfully updated"}';
                        }else{
                            $output='{"status":"failure", "remark":"Something is wrong"}';
                        }
                    }else{
                        $output='{"status":"failure", "remark":"Description must be less than 50 characters"}';
                    }
                }else{
                    $output='{"status":"failure", "remark":"Name must be less than 20 characters"}';
                }
            }else{
                $output='{"status":"failure", "remark":"Sorry, This people not exist"}';
            }
        }else{
          $output='{"status":"failure", "remark":"Invalid or Incomplete description recieved"}';
        }
    }else{
      $output='{"status":"failure", "remark":"Invalid or Incomplete name recieved"}';
    }
}else{
    $output='{"status":"failure", "remark":"Invalid or Incomplete data recieved"}';
}

echo $output;

mysqli_close($con);
?>