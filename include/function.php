<?php

function  upload_file($myfile,$dir,$max_file_size=102400)
{
    $error=0;
    $obj=new stdClass();
    $file_name=rinse(time().$_FILES[$myfile]['name']);
    $file_name=str_replace(" ", "", $file_name);
    $file_add=$_FILES[$myfile]['tmp_name'];
    
    $file_size = $_FILES[$myfile]['size'];
    if ($_FILES[$myfile]['error'] !== UPLOAD_ERR_OK) 
    {
       $error=1;
       $message="File not uploaded properly.";
    }
    elseif (($file_size > $max_file_size))
    {      
        $message = 'File too large. File must be within '.($max_file_size/1024).' KB.'; 
        $error=1;
     }

     $info = getimagesize($_FILES[$myfile]['tmp_name']);
    if ($info === FALSE) 
    {
       $error=1;
       $message="Unable to determine image type of uploaded file";
    }

    if (($info[2] !== IMAGETYPE_JPEG) && ($info[2] !== IMAGETYPE_PNG)) 
    {
       $error=1;
       $message="Only JPEG or PNG image allowed";
    }
    
    if($error==0)
    {
        if(move_uploaded_file($file_add,$dir."/".$file_name))
        {
            $message="file uploaded succesfuly";
        }
        else
        {
            $message = $_FILES[$myfile]['error'];
            $error=1;
                // $message=$dir;
        }
    }
    $obj->error=$error;
    $obj->message=$message;
    $obj->file_name=$file_name;

    return $obj;
  
}

function  upload_file_modified($myfile,$dir,$max_file_size=102400,$i)
{
    
    $error=0;
    $obj=new stdClass();
    $file_name=rinse(time().$_FILES[$myfile]['name'][$i]);
    $file_name=str_replace(" ", "", $file_name);
    $file_add=$_FILES[$myfile]['tmp_name'][$i];
    
    $file_size = $_FILES[$myfile]['size'][$i];
    if ($_FILES[$myfile]['error'][$i] !== UPLOAD_ERR_OK) 
    {
       $error=1;
       $message="File not uploaded properly.";
    }
    elseif (($file_size > $max_file_size))
    {      
        $message = 'File too large. File must be within '.($max_file_size/1024).' KB.'; 
        $error=1;
     }

    $info = getimagesize($_FILES[$myfile]['tmp_name'][$i]);
    $mime   = $info['mime'];
  
    if ($info === FALSE) 
    {
       $error=1;
       $message="Unable to determine image type of uploaded file";
    }
    
    if (($info[2] !== IMAGETYPE_JPEG) && ($info[2] !== IMAGETYPE_PNG)) 
    {
       $error=1;
       $message="Only JPEG or PNG image allowed";
    }
    
    if($error==0)
    {
        if(move_uploaded_file($file_add,$dir."/".$file_name))
        {
            $message="file uploaded succesfuly";
        }
        else
        {
            $message = $_FILES[$myfile]['error'];
            $error=1;
                // $message=$dir;
        }
    }
    $obj->error=$error;
    $obj->message=$message;
    $obj->file_name=$file_name;

    return $obj;
  
}


function deleteImage($path)
{
    global $hostname;
    $new_path=str_replace($hostname, "", $path);
    if(strlen($new_path)!=0)
    {
        return unlink("../../".$new_path);
        // return "inside";
    }
    return "0";
}
        
function redirect_to( $location = NULL ) {
    if ($location != NULL) {
      header("Location: {$location}");
      exit;
    }
}

function clean($input)
 {
  return preg_replace('/[^A-Za-z0-9 ]/', '', $input); // Removes special chars.
 }
function rinse($input)
{
    return preg_replace('/[^A-Za-z0-9\-,@.\ ]/', '', $input); // Removes special chars.
}

 function numOnly($input)
 {
  return preg_replace('/[^0-9]/', '', $input); // Removes special chars.
 }

function securityToken(){
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $randstring = '';
        for ($i = 0; $i < 10; $i++) {
            $randstring.=$characters[rand(0, strlen($characters))];
        }
        return $randstring;
}

function adminBlock(){
    $admin=array('2');
    if(in_array($_SESSION["admin_id"],$admin)) die('{"status":"failure","remark":"Sorry, This function is disabled"}');
}

function userBlock(){
    $user=array('3');
    if(in_array($_SESSION["user_id"],$user) && PRODUCTION) die('{"status":"failure","remark":"Sorry, This function is disabled"}');
}

function logincheck()
{
    global $con;

    if(isset($_SESSION["user_id"]))
    {
        $output='{"status":"success"}';
    }
    elseif(isset($_REQUEST["user_id"]) && isset($_REQUEST["security_token"]))
    {    
        $query="select `security_token` from `wryton_user` where `id`='".$_REQUEST["user_id"]."'";
        $result=mysqli_query($con,$query);
        $row=mysqli_fetch_array($result);
        if($row["security_token"]==$_REQUEST["security_token"]){
            $output='{"status":"success"}';
        }
        else
            $output='{"status":"failure","remark":"Incorrect Security token. User id entered is '.$_REQUEST["user_id"].' and security token entere is '.$_REQUEST["security_token"].'"}';
    }
    else
    {
        $output='{"status":"failure","remark":"You are not login, Please login"}';
    }

    $obj=json_decode($output,true);

    if($obj['status']!="success")
        die($output);
}

function admincheck()
{
    if(!isset($_SESSION["user_type"])=="admin")
    {
        die("You are not authorized for this request");
    }
}

function userLoginCheck()
{
    $data=logincheck();
    $arr=json_decode($data);
    if($arr->status!="success"){
        header("Location: index.php");
        die();
    }
}

function getIPAddress()
{
    $client  = @$_SERVER['HTTP_CLIENT_IP'];
    $forward = @$_SERVER['HTTP_X_FORWARDED_FOR'];
    $remote  = $_SERVER['REMOTE_ADDR'];

    if(filter_var($client, FILTER_VALIDATE_IP)){
        $ip = $client;
    }elseif(filter_var($forward, FILTER_VALIDATE_IP)){
        $ip = $forward;
    }else{
        $ip = $remote;
    }
    return $ip;
}

function pagination($query,$limit){
    global $con;
    $limit=(int)$limit;
    $row_count=mysqli_num_rows(mysqli_query($con,$query));
    return ceil($row_count/$limit);
}

function currencyList()
{
    global $con;
    $currency=array();

    $query="select * from `moneybags_currency` order by `name` asc";
    $result=mysqli_query($con,$query);
    if(mysqli_num_rows($result)>0){
        $output='{"status":"success","currency":';
        while ($row=mysqli_fetch_assoc($result)) {
            $currency[] = $row;
        }
        $output.=json_encode($currency).'}';
    }else{
        $output='{"status":"failure","remark":"No currency return"}';
    }
    return $output;
}

function dateList()
{
    global $con;
    $date=array();

    $query="select * from `moneybags_date` order by `date_id` asc";
    $result=mysqli_query($con,$query);
    if(mysqli_num_rows($result)>0){
        $output='{"status":"success","date":';
        while ($row=mysqli_fetch_assoc($result)) {
            $row["datetime"]=date($row["date"]);
            $date[] = $row;
        }
        $output.=json_encode($date).'}';
    }else{
        $output='{"status":"failure","remark":"No date return"}';
    }
    return $output;
}

function getAmount($people_id){
    global $con;

    $query="select sum(`amount`) as amount from `moneybags_money` where `people_id`='{$people_id}'";
    $result=mysqli_query($con,$query);
    if($result){
        $row=mysqli_fetch_assoc($result);
        return $row["amount"];
    }else{
        return 0;
    }
}

function updateAmount($people_id){
    global $con;

    $amount=(int)getAmount($people_id);
    $query="update `moneybags_people` set amount='{$amount}', popular=popular+1 where `people_id`='{$people_id}'";
    $result=mysqli_query($con,$query);
    if($result){
        return true;
    }else{
        return false;
    }
}

function peopleList($obj){
    global $con;

    $people=array();
    $query="select p.* from `moneybags_people` p where ";

    if(isset($obj->status) && $obj->status!=""){
     $query.= "p.`status` = ".$obj->status." and ";
    }

    if(isset($obj->user_id) && $obj->user_id!=""){
     $query.= "p.`user_id` = ".$obj->user_id." and ";
    }
     
    if (isset($obj->search)  && $obj->search!=""){
        $search = clean($obj->search);
        $query.="( `name` like '%".$search."%' or `description` like '%".$search."%' or `amount` like '%".$search."%' or `datetime` like '%".$search."%' ) and ";
    }

    if(isset($obj->radio_filter)  && $obj->radio_filter!=""){
        $radio_filter=(int)$obj->radio_filter;
        if($radio_filter>0){
            $query.="`amount`>0 and ";
        }elseif($radio_filter<0){
            $query.="`amount`<0 and ";
        }else{
            $query.=" ";
        }
    }

    $query.="1 order by p.`name` asc ";

    if(isset($obj->limit) && $obj->limit!=0){
        $limit=$obj->limit;
    }else{
        $limit=10;
    }

    if(isset($obj->page) && $obj->page!=0){
        $page=$obj->page;
    }else{
        $page=1;
    }

    $pagination=pagination($query,$limit);

    $query.=" limit {$limit} offset ".(($page-1)*$limit);
    $result = mysqli_query($con,$query);

    if(mysqli_num_rows($result) > 0){
        while ($row = mysqli_fetch_assoc($result))
        {
            $row["datetime"]=date($_SESSION["date"],strtotime($row["datetime"]));
            $people[] = $row;
        }
        $output='{"status":"success","currency":"'.$_SESSION["currency"].'", "pagination":"'.$pagination.'", "people":';
        $output.=json_encode($people);
        $output.="}";
    }else{
         $output='{"status":"failure","remark":"No People found"}';
    }
    return $output;
}

function peopleCheck($people_id){
    global $con;
    //this function tells whether a given people_id really belongs to the login user
    $people_id=numOnly(str_replace(" ","",$people_id));
    if($people_id!=""){
        $user_id=numOnly($_SESSION["user_id"]);
        $status=1;

        $query="select * from `moneybags_people` where `status`=1 and `people_id`=".$people_id." and `user_id`=".$user_id;
        $result=mysqli_query($con,$query);
        if(mysqli_num_rows($result)==1){
            return true;
        }else{
            return false;
        }
    }else{
      return false;
    }
}

function moneyList($obj){
    global $con;

    $money=array();

    $query="select p.people_id,p.user_id,p.name,m.* from `moneybags_money` m left join `moneybags_people` p on m.people_id=p.people_id where ";

    if(isset($obj->people_id) && $obj->people_id!=""){
        $query.= "p.`people_id` = ".$obj->people_id." and ";
    }

    if(isset($obj->user_id) && $obj->user_id!=""){
        $query.= "p.`user_id` = ".$obj->user_id." and ";
    }
     
    if(isset($obj->search)  && $obj->search!=""){
        $search = clean($obj->search);
        $query.="( p.`name` like '%".$search."%' or m.`remark` like '%".$search."%' or m.`amount` like '%".$search."%' or m.`datetime` like '%".$search."%' ) and ";
    }

    if(isset($obj->radio_filter)  && $obj->radio_filter!=""){
        $radio_filter=(int)$obj->radio_filter;
        if($radio_filter>0){
            $query.="m.`amount`>0 and ";
        }elseif($radio_filter<0){
            $query.="m.`amount`<0 and ";
        }else{
            $query.=" ";
        }
    }

    $query.="1 order by m.`datetime` desc ";

    if(isset($obj->limit) && $obj->limit!=0){
        $limit=$obj->limit;
    }else{
        $limit=10;
    }

    if(isset($obj->page) && $obj->page!=0){
        $page=$obj->page;
    }else{
        $page=1;
    }

    $pagination=pagination($query,$limit);

    $query.=" limit {$limit} offset ".(($page-1)*$limit);
    $result = mysqli_query($con,$query);

    if(mysqli_num_rows($result) > 0){
        while ($row = mysqli_fetch_assoc($result))
        {
            $row["datetime"]=date($_SESSION["date"],strtotime($row["datetime"]));
            $money[] = $row;
        }
        $output='{"status":"success","currency":"'.$_SESSION["currency"].'", "pagination":"'.$pagination.'", "money":';
        $output.=json_encode($money);
        $output.="}";
    }else{
         $output='{"status":"failure","remark":"No money history found"}';
    }
    return $output;
}

function moneyDelete($obj){
    global $con;

    if(isset($obj->people_id) && $obj->people_id!=""){
        $people_id=numOnly($obj->people_id);

        $query="delete from `moneybags_money` where `people_id`='{$people_id}'";

        if(isset($obj->money_id) && $obj->money_id!=""){
            $query.= "and `money_id` = '".$obj->money_id."'";
        }

        $result=mysqli_query($con,$query);
        if($result){
            if(updateAmount($people_id)){
                $output='{"status":"success", "remark":"Successfully deleted"}';
            }else{
                $output='{"status":"failure", "remark":"Something is wrong"}';
            }
        }else{
            $output='{"status":"failure", "remark":"Something is wrong"}';
        }
    }else{
        $output='{"status":"failure", "remark":"Invalid or Incomplete data recieved"}';
    }

    return $output;
}

function crypto($action, $string) {
    //for encrypt e, for decrypt d
    $output = false;

    $encrypt_method = "AES-256-CBC";
    $secret_key = 'askjhSVSanckanSVSja353aRG5aSGSSasdSaSGSGSGsS3Sf5adS';
    $secret_iv = '3S5S53sgsgssdJgs5gs3gHs6sg5shfg3fJfdJhdh3Hdfgfh2hds';

    // hash
    $key = hash('sha256', $secret_key);
    
    // iv - encrypt method AES-256-CBC expects 16 bytes - else you will get a warning
    $iv = substr(hash('sha256', $secret_iv), 0, 16);

    if( $action == 'encrypt' || $action=="e" ) {
        $output = openssl_encrypt($string, $encrypt_method, $key, 0, $iv);
        $output = base64_encode($output);
    }
    else if( $action == 'decrypt' || $action=="d" ){
        $output = openssl_decrypt(base64_decode($string), $encrypt_method, $key, 0, $iv);
    }
    return $output;
}

?>