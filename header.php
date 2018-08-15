<?php require_once 'include/config.php';?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
  <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1.0, user-scalable=no"/>
  <title>MoneyBags | Your Transaction Reminder</title>

  <!-- CSS  -->
  <link rel="stylesheet" href="https://www.w3schools.com/lib/w3.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert.min.css">

  <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
  <link href="assets/css/materialize.css" type="text/css" rel="stylesheet" media="screen,projection"/>
  <!-- <link href="https://cdnjs.cloudflare.com/ajax/libs/materialize/0.97.6/css/materialize.min.css" rel="stylesheet" > -->
  <link href="assets/css/style.css" type="text/css" rel="stylesheet" media="screen,projection"/>

  <style>
	  	.pagination ul li{
	    padding-top:3px;
	    padding-right:10px;
	    padding-left:10px;
	}
  </style>
</head>
<body>
  <nav class="white" role="navigation">
    <div class="nav-wrapper container">
      <a id="logo-container" href="index.php" class="brand-logo w3-hover-text-brown">MoneyBags<span class="w3-small" id="page_name"></span></a>
      <ul class="right hide-on-med-and-down">
      	<?php
      		if(isset($_SESSION["user_id"]) && $_SESSION["user_id"]!=""){
      			echo '<li><a href="dashboard.php" class="w3-hover-brown">Dashboard</a></li>';
  				echo '<li><a href="people.php" class="w3-text-brown">People</a></li>';
  				echo '<li><a href="history.php" class="w3-text-brown">History</a></li>';
				echo '<li><a href="#help" class="w3-text-brown">Help</a></li>';
      			echo '<li><a class="dropdown-button w3-brown" data-activates="profile_dropdown" data-beloworigin="true">'.$_SESSION["fname"].' '.$_SESSION["lname"].'</a></li>';
      			echo '<ul id="profile_dropdown" class="dropdown-content">';
    				echo '<li><a href="settings.php" class="w3-text-brown">Settings</a></li>';
    				echo '<li><a class="logout_btn w3-text-brown">Logout</a></li>';
    			echo '</ul>';
      		}else{
      			echo '<li><a href="#login" class="w3-hover-brown">Login</a></li>';
        		echo '<li><a href="#register" class="w3-hover-brown">Register</a></li>';
      		}
      	?>
      </ul>

      <ul id="nav-mobile" class="side-nav">
      	<?php
      		if(isset($_SESSION["user_id"]) && $_SESSION["user_id"]!=""){
      			echo '<li><a class="w3-brown">'.$_SESSION["fname"].' '.$_SESSION["lname"].'</a></li>';
      			echo '<li><a href="dashboard.php" class="w3-hover-brown">Dashboard</a></li>';
      			echo '<li><a href="people.php" class="w3-hover-brown">People</a></li>';
      			echo '<li><a href="history.php" class="w3-hover-brown">History</a></li>';
				echo '<li><a href="#help" class="w3-hover-brown">Help</a></li>';
      			echo '<li><a href="settings.php" class="w3-hover-brown">Settings</a></li>';
				echo '<li><a class="logout_btn w3-hover-brown">Logout</a></li>';
      		}else{
      			echo '<li><a href="#login" class="w3-hover-teal">Login</a></li>';
        		echo '<li><a href="#register" class="w3-hover-teal">Register</a></li>';
      		}
      	?>
      </ul>
      <a href="#" data-activates="nav-mobile" class="button-collapse w3-text-brown"><i class="fa fa-bars"></i></a>
    </div>
  </nav>

<!-- Login Modal Structure -->
<div id="login" class="modal">
	<div class="modal-content">
		<div class="row">
			<div class="input-field col s12">
			  <input id="login_email" type="email" class="validate" value="test@gmail.com">
			  <label for="login_email">Email</label>
			</div>
		</div>
		<div class="row">
			<div class="input-field col s12">
			  <input id="login_password" type="password" class="validate" value="123456">
			  <label for="login_password">Password</label>
			</div>
		</div>
		<div class="row w3-center">
			<button class="waves-effect waves-light btn w3-brown" id="login_btn">Login</button>
		</div>
	</div>
</div>

<!-- Register Modal Structure -->
<div id="register" class="modal">
	<div class="modal-content">
		<div class="row">
		  	<div class="input-field col l6 m6 s12">
	        	<input id="register_fname" type="text" class="validate">
	          	<label for="register_fname">First Name</label>
	        </div>
	        <div class="input-field col l6 m6 s12">
	        	<input id="register_lname" type="text" class="validate">
	         	<label for="register_lname">Last Name</label>
	        </div>
		</div>
		<div class="row">
			<div class="input-field col s12">
			  <input id="register_email" type="email" class="validate">
			  <label for="register_email">Email</label>
			</div>
		</div>
		<div class="row">
			<div class="input-field col l6 m6 s12">
			  <input id="register_password" type="password" class="validate">
			  <label for="register_password">Password</label>
			</div>
			<div class="input-field col l6 m6 s12">
			  <input id="register_c_password" type="password" class="validate">
			  <label for="register_c_password">Confirm Password</label>
			</div>
		</div>
		<div class="row w3-center">
			<button class="waves-effect waves-light btn w3-brown" id="register_btn">Register</button>
		</div>
	</div>
</div>

<!-- Help Modal Structure -->
<div id="help" class="modal row w3-center">
	<div class="col l6 m6 s12 w3-teal">
		<div class="row">
			<h5>What It Means</h5>
		</div>
		<div class="row">
			<p>This color simply represent that you are in positive. you will get amount by your people. This color shows your Inflow amount.</p>
		</div>
	</div>
	<div class="col l6 m6 s12 w3-pink">
		<div class="row">
			<h5>What It Means</h5>
		</div>
		<div class="row">
			<p>This color simply represent that you are in negative. you have to give amount to your people. This color shows your Outflow amount.</p>
		</div>
	</div>
</div>