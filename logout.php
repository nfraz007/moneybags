<?php
   session_start();
   unset($_SESSION['user_id']);
   unset($_SESSION['fname']);
   // unset($_SESSION['country_id']);
   // unset($_SESSION['provider']);
   unset($_SESSION['country']);
   session_destroy();
   header("location: /");
?>