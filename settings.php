<?php require_once 'header.php'; 
$currency_list=json_decode(currencyList());
$date_list=json_decode(dateList());
?>

<div class="container">
	<div class="w3-padding-24"></div>
	<div class="row">
		<div class="col l6 m6 s12">
			<h5>Profile Settings</h5>
		</div>
		<div class="col l6 m6 s12">
			<div class="input-field">
			  <input id="email" type="email" class="validate" disabled>
			  <label for="email">Email</label>
			</div>
			<div class="input-field">
			  <input id="fname" type="text" class="validate">
			  <label for="fname">First Name</label>
			</div>
			<div class="input-field">
			  <input id="lname" type="text" class="validate">
			  <label for="lname">Last Name</label>
			</div>
			<div class="input-field">
				<select id="gender">
				  <option value="" disabled selected>Choose your option</option>
				  <option value="male">Male</option>
				  <option value="female">Female</option>
				  <option value="other">Other</option>
				</select>
				<label>Gender</label>
			</div>
			<div class="w3-center">
				<button class="waves-effect waves-light btn w3-brown" id="profile_btn">Update</button>
			</div>
		</div>
	</div>
	<hr>
	<div class="row">
		<div class="col l6 m6 s12">
			<h5>Other Settings</h5>
		</div>
		<div class="col l6 m6 s12">
			<div class="input-field">
				<select id="currency">
				  <option value="" disabled selected>Choose your option</option>
				  <?php
				  	for($i=0;$i<sizeof($currency_list->currency);$i++){
				  		echo '<option value="'.$currency_list->currency[$i]->currency_id.'">'.$currency_list->currency[$i]->name.' / '.$currency_list->currency[$i]->short.' ( '.$currency_list->currency[$i]->html.' )</option>';
				  	}
				  ?>
				</select>
				<label>Currency</label>
			</div>
			<div class="input-field">
				<select id="date">
				  <option value="" disabled selected>Choose your option</option>
				  <?php
				  	for($i=0;$i<sizeof($date_list->date);$i++){
				  		echo '<option value="'.$date_list->date[$i]->date_id.'">'.$date_list->date[$i]->datetime.'</option>';
				  	}
				  ?>
				</select>
				<label>Date</label>
			</div>
			<div class="w3-center">
				<button class="waves-effect waves-light btn w3-brown" id="other_btn">Update</button>
			</div>
		</div>
	</div>
	<hr>
	<div class="row">
		<div class="col l6 m6 s12">
		<h5>Password Settings</h5>
		</div>
		<div class="col l6 m6 s12">
			<div class="input-field">
			  <input id="old_password" type="password" class="validate">
			  <label for="old_password">Old Password</label>
			</div>
			<div class="input-field">
			  <input id="new_password" type="password" class="validate">
			  <label for="new_password">New Password</label>
			</div>
			<div class="input-field">
			  <input id="new_c_password" type="password" class="validate">
			  <label for="new_c_password">Confirm New Password</label>
			</div>
			<div class="w3-center">
				<button class="waves-effect waves-light btn w3-brown" id="password_btn">Update</button>
			</div>
		</div>
	</div>
	<div class="w3-padding-24"></div>
</div>

<?php require_once 'footer.php'; ?>

<script>

$("document").ready(function(){
	set_page_name("Settings");
	get_data();
});

function get_data(){
	$.post("userapi/user/user_detail.php",
	{

	},function(data){
		//console.log(data);
		var arr=JSON.parse(data);
		if(arr["status"]=="success"){
			$("#email").val(arr["user"][0]["email"]);
			$("#fname").val(arr["user"][0]["fname"]);
			$("#lname").val(arr["user"][0]["lname"]);
			$("#gender").val(arr["user"][0]["gender"]);
			$("#currency").val(arr["user"][0]["currency_id"]);
			$("#date").val(arr["user"][0]["date_id"]);
			Materialize.updateTextFields();
			$('select').material_select();
		}else{
			Materialize.toast(arr["remark"], 4000, "w3-pink");
		}
	});
}

$("#profile_btn").click(function(){
	var fname = $("#fname").val();
	var lname = $("#lname").val();
	var gender = $("#gender").val();

	if(fname!=""){
		if(lname!=""){
			if(gender!=""){
				$.post("userapi/user/update_profile.php",
					{
						fname:fname,
						lname:lname,
						gender:gender
					},function(data){
						//console.log(data);
						var arr=JSON.parse(data);
						if(arr["status"]=="success"){
							get_data();
							Materialize.toast(arr["remark"], 4000, "w3-teal");
						}else{
							Materialize.toast(arr["remark"], 4000, "w3-pink");
						}
					});
			}else{
				Materialize.toast("Please select your gender", 4000, "w3-pink");
			}
		}else{
			Materialize.toast("Last Name is empty", 4000, "w3-pink");
		}
	}else{
		Materialize.toast("First Name is empty", 4000, "w3-pink");
	}
});

$("#other_btn").click(function(){
	var currency_id = $("#currency").val();
	var date_id = $("#date").val();

	if(currency_id!="" && date_id!=""){
		$.post("userapi/user/update_other.php",
			{
				currency_id:currency_id,
				date_id:date_id
			},function(data){
				//console.log(data);
				var arr=JSON.parse(data);
				if(arr["status"]=="success"){
					get_data();
					Materialize.toast(arr["remark"], 4000, "w3-teal");
				}else{
					Materialize.toast(arr["remark"], 4000, "w3-pink");
				}
			});
	}else{
		Materialize.toast("Please select currency and date", 4000, "w3-pink");
	}
});

$("#password_btn").click(function(){
	var old_password = $("#old_password").val();
	var new_password = $("#new_password").val();
	var new_c_password = $("#new_c_password").val();

	if(old_password!=""){
		if(new_password!=""){
			if(new_c_password!=""){
				if(old_password.length>=6 && new_password.length>=6 && new_c_password.length>=6){
					if(new_password==new_c_password){
						$.post("userapi/user/update_password.php",
							{
								old_password:old_password,
								new_password:new_password,
								new_c_password:new_c_password
							},function(data){
								//console.log(data);
								var arr=JSON.parse(data);
								if(arr["status"]=="success"){
									$("#old_password").val("");
									$("#new_password").val("");
									$("#new_c_password").val("");
									Materialize.updateTextFields();
									Materialize.toast(arr["remark"], 4000, "w3-teal");
								}else{
									Materialize.toast(arr["remark"], 4000, "w3-pink");
								}
							});
					}else{
						Materialize.toast("Confirm new password is not same", 4000, "w3-pink");
					}
				}else{
					Materialize.toast("Password must contain atleast 6 characters", 4000, "w3-pink");
				}
			}else{
				Materialize.toast("Confirm New Password is empty", 4000, "w3-pink");
			}
		}else{
			Materialize.toast("New Password is empty", 4000, "w3-pink");
		}
	}else{
		Materialize.toast("Old Password is empty", 4000, "w3-pink");
	}
});

</script>