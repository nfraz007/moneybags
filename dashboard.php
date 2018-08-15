<?php require_once 'header.php';
$obj=new stdClass();
$obj->status="1";
$obj->user_id=$_SESSION["user_id"];
$people_list=json_decode(peopleList($obj));
?>

<div class="container">
	<div class="row">
		<div class="col l6 m6 s12">
			<div id="positive" style="width: 100%; height: 300px;"></div>
			<div class="row">
				<div class="col s12">
					<div class="card w3-center w3-text-teal w3-border w3-border-black w3-hover-border-teal w3-bottombar">
		            	<h4 id="positive_total"></h4>
		            	<p>Total Inflow</p>
			        </div>
				</div>
			</div>
		</div>
		<div class="col l6 m6 s12">
			<div id="negative" style="width: 100%; height: 300px;"></div>
			<div class="row">
				<div class="col s12">
					<div class="card w3-center w3-text-pink w3-border w3-border-black w3-hover-border-pink w3-bottombar">
		            	<h4 id="negative_total"></h4>
		            	<p>Total Outflow</p>
			        </div>
				</div>
			</div>
		</div>
	</div>
	<div class="row">
		<div class="col l6 m12 s12">
			<ul class="collection with-header w3-border w3-border-black w3-bottombar">
		        <li class="collection-header w3-border-black w3-bottombar w3-brown"><h5>Recent Transaction</h5></li>
		        <div id="transaction"></div>
		        <a class="collection-item w3-center w3-text-black w3-hover-text-brown" href="history.php"><div>View All</div></a>
		    </ul>
		</div>
		<div class="col l6 m12 s12">
			<ul class="collection with-header w3-border w3-border-black w3-bottombar">
		        <li class="collection-header w3-border-black w3-bottombar w3-brown"><h5>Top People</h5></li>
		        <div id="top_people"></div>
		        <a class="collection-item w3-center w3-text-black w3-hover-text-brown" href="people.php"><div>View All</div></a>
		    </ul>
		</div>
	</div>
	<div class="row">
		<div class="fixed-action-btn">
		    <a class="btn-floating btn-large w3-brown tooltipped" href="#option" data-position="left" data-tooltip="Option"><i class="large fa fa-bars"></i></a>
	  	</div>
	</div>
</div>

<!-- Option Modal Structure -->
<div id="option" class="modal">
	<div class="modal-content">
		<div class="row">
			<div class="col l6 m6 s12">
				<div class="input-field">
					<select id="option_people">
					  <option value="" disabled selected>Choose your option</option>
					  <?php
					  	for($i=0;$i<sizeof($people_list->people);$i++){
					  		echo '<option value="'.$people_list->people[$i]->people_id.'">'.$people_list->people[$i]->name.'</option>';
					  	}
					  ?>
					</select>
					<label>People</label>
				</div>
			</div>
			<div class="col l6 m6 s12">
				<div class="input-field">
					<select id="option_type" disabled>
					  <option value="" disabled selected>Choose your option</option>
					  <option value="1">I give / I have to recieved</option>
					  <option value="-1">I recieved / I have to give</option>
					</select>
					<label>Type</label>
				</div>
				<div class="input-field">
				  <input id="option_amount" type="number" class="validate" disabled>
				  <label for="option_amount">Amount</label>
				</div>
				<div class="input-field">
				  <input id="option_remark" type="text" class="validate" disabled data-length="50">
				  <label for="option_remark">Remark</label>
				</div>
			</div>
		</div>
		<div class="row w3-center">
			<button class="waves-effect waves-light btn w3-brown" id="option_btn" disabled>Update</button>
		</div>
	</div>
</div>

<?php require_once 'footer.php'; ?>

<script>

$("document").ready(function(){
	set_page_name("Dashboard");
	print_data();
});

function print_data(){
	print_pie();
	print_count();
	print_transaction();
	print_top_people();
}

function print_pie(){
	$.post("userapi/dashboard/dashboard.php",
	{

	},function(data){
		//console.log(data);
		var arr=JSON.parse(data);
		if(arr["status"]=="success"){
			positive(arr["positive"]);
			negative(arr["negative"]);
		}else{
			Materialize.toast(arr["remark"], 4000, "w3-pink");
		}
	});
}

function positive(data){
	var chart;

    var chart = AmCharts.makeChart("positive",{
	  "type"    : "pie",
	  "titleField"  : "name",
	  "valueField"  : "amount",
	  "radius" : "100",
	  "labelRadius" : 5,
	  "baseColor" : "#009688",
	  "outlineColor" : "#FFFFFF",
      "outlineAlpha" : 1,
      "outlineThickness" : 1,
	  "dataProvider"  : data
	});
}

function negative(data){
	var chart;

    var chart = AmCharts.makeChart("negative",{
	  "type"    : "pie",
	  "titleField"  : "name",
	  "valueField"  : "amount",
	  "radius" : "100",
	  "labelRadius" : 5,
	  "baseColor" : "#e91e63",
	  "outlineColor" : "#FFFFFF",
      "outlineAlpha" : 1,
      "outlineThickness" : 1,
	  "dataProvider"  : data
	});
}

function print_count(){
	$.post("userapi/dashboard/dashboard_count.php",
	{

	},function(data){
		//console.log(data);
		var arr=JSON.parse(data);
		if(arr["status"]=="success"){
			$("#positive_total").html('<b class="'+get_text_color(arr["positive"])+'">'+arr["currency"]+" "+Math.abs(arr["positive"])+'</b>');
			$("#negative_total").html('<b class="'+get_text_color(arr["negative"])+'">'+arr["currency"]+" "+Math.abs(arr["negative"])+'</b>');
		}else{
			Materialize.toast(arr["remark"], 4000, "w3-pink");
		}
	})
}

function print_transaction(){
	var out="";
	$.post("userapi/money/money_list.php",
	{
		limit:10
	},function(data){
		//console.log(data);
		var arr=JSON.parse(data);
		if(arr["status"]=="success"){
			for(i=0;i<arr["money"].length;i++){
	        	out+='<a class="collection-item w3-text-black w3-hover-text-brown" href="people_detail.php?id='+arr["money"][i]["people_id"]+'"><div><span class="badge '+get_text_color(arr["money"][i]["amount"])+'">'+arr["currency"]+' '+Math.abs(arr["money"][i]["amount"])+'</span>'+arr["money"][i]["name"]+'<span class="w3-tiny w3-text-brown"> ( '+arr["money"][i]["datetime"]+' )</span></div><div class="w3-tiny w3-text-brown">'+arr["money"][i]["remark"]+'</div></a>';
	        }
		}else{
			out='<li class="collection-item"><div>'+arr["remark"]+'</div></li>';
		}
		$("#transaction").html(out);
	});
}

function print_top_people(){
	var out="";
	$.post("userapi/dashboard/top_people.php",
	{

	},function(data){
		//console.log(data);
		var arr=JSON.parse(data);
		if(arr["status"]=="success"){
			for(i=0;i<arr["people"].length;i++){
	        	out+='<a class="collection-item w3-text-black w3-hover-text-brown" href="people_detail.php?id='+arr["people"][i]["people_id"]+'"><span class="badge"><i class="fa fa-arrow-right"></i></span><div>'+arr["people"][i]["name"]+'<span class="'+get_text_color(arr["people"][i]["amount"])+'"> ('+arr["currency"]+' '+Math.abs(arr["people"][i]["amount"])+')</span></div></a>';
	        }
		}else{
			out='<li class="collection-item"><div>'+arr["remark"]+'</div></li>';
		}
		$("#top_people").html(out);
	});
}

//***************************************option modal ****************************************************
$("#option_people").change(function(){
	$("#option_type").prop("disabled",false);
	$("#option_amount").prop("disabled",false);
	$("#option_remark").prop("disabled",false);
	$("#option_btn").prop("disabled",false);
	$('select').material_select();
});

$("body").on("click","#option_btn",function(){
	var people_id=$("#option_people").val();
	var type=$("#option_type").val();
	var amount=$("#option_amount").val();
	var remark=$("#option_remark").val();

	$.post("userapi/money/money_add.php",{
		people_id:people_id,
		type:type,
		amount:amount,
		remark:remark
	},function(data){
		//console.log(data);
		var arr=JSON.parse(data);
		if(arr["status"]=="success"){
			$("#option_people").val("");
			$("#option_type").val("");
			$("#option_amount").val("");
			$("#option_remark").val("");

			$("#option_type").prop("disabled",true);
			$("#option_amount").prop("disabled",true);
			$("#option_remark").prop("disabled",true);
			$("#option_btn").prop("disabled",true);
			
			Materialize.updateTextFields();
			$('select').material_select();
			print_data();
			$('#option').modal('close');
			Materialize.toast(arr["remark"], 4000, "w3-teal");
		}else{
			Materialize.toast(arr["remark"], 4000, "w3-pink");
		}
	});
});

$('#option_amount').keypress(function(e){
    if(e.which == 13){//Enter key pressed
        $('#option_btn').click();//Trigger search button click event
    }
});

$('#option_remark').keypress(function(e){
    if(e.which == 13){//Enter key pressed
        $('#option_btn').click();//Trigger search button click event
    }
});
</script>