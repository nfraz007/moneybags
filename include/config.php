<?php
    session_start();
    require_once __DIR__."/../my_config.php";

    $server   = HOSTNAME;
    $username = USERNAME;
    $password = PASSWORD;
    $database = DATABASE;

    //smtp detail
    // $email_host=
       
    date_default_timezone_set('Asia/Kolkata');
    $con=mysqli_connect($server,$username,$password,$database) or die ("could not connect to mysql");

    $DATETIME_FORMAT="l, M j, Y @ g:ia";
    $HOSTNAME = BASE_URL;

   /* $hostname="http://kirostravels.goyalsoftwares.com/";
    $tour_img_location="assets/image/tour/";
    $blog_img_location="assets/image/blog/";
    $blog_cat_img_location="assets/image/blog_category/";
    $category_img_location="assets/image/category/";
    $product_img_location="assets/image/product/";

    require 'phpmailer/PHPMailerAutoload.php';*/
    require_once 'function.php';
?>