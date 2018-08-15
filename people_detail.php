<?php
if(!isset($_REQUEST["id"]) || trim($_REQUEST["id"])==""){
	header("Location: people.php");
}
?>
<?php require_once 'header.php'; 

$people_id=numOnly(str_replace(" ","",trim($_REQUEST["id"])));
?>

<div class="container">
	<div class="w3-padding-8"></div>
	<div class="row">
		<div class="col s12">
			<ul class="collection with-header">
		        <li class="collection-header w3-border w3-border-black w3-bottombar w3-brown">
		        	<div>
		        		<h5 id="people_name"></h5>
		        		<p id="people_description"></p>
		        	</div>
		        </li>
		    </ul>
		</div>
	</div>
	<div class="row">
		<div class="col l4 m12 s12">
			<div class="card w3-border w3-border-black w3-hover-border-brown w3-bottombar">
	            <div class="card-content w3-center">
	            	<h4 id="people_balance"></h4>
	            	<p>Balance</p>
	            </div>
	        </div>
		</div>
		<div class="col l4 m12 s12">
			<div class="card w3-border w3-border-black w3-hover-border-brown w3-bottombar">
	            <div class="card-content w3-center">
	            	<h4 id="people_positive"></h4>
	            	<p>Total Inflow</p>
	            </div>
	        </div>
		</div>
		<div class="col l4 m12 s12">
			<div class="card w3-border w3-border-black w3-hover-border-brown w3-bottombar">
	            <div class="card-content w3-center">
	            	<h4 id="people_negative"></h4>
	            	<p>Total Outflow</p>
	            </div>
	        </div>
		</div>
	</div>
	<div class="row">
		<div class="col s12">
			<ul class="collapsible" data-collapsible="accordion">
			    <li>
			      <div class="collapsible-header w3-center">Filter</div>
			      <div class="collapsible-body row">
			      	<div class="col l6 m6 s12">
			      		<nav>
						    <div class="nav-wrapper w3-brown">
						      <form>
						        <div class="input-field">
						          <input type="search" id="people_search" placeholder="Search" required>
						          <label class="label-icon" for="search"><i class="fa fa-search"></i></label>
						          <i class="fa fa-close"></i>
						        </div>
						      </form>
						    </div>
						</nav>
			      	</div>
			      	<div class="col l6 m6 s12">
			      		<div class="input-field">
							<select id="limit">
							  <option value="" disabled selected>Choose your option</option>
							  <option value="10" selected>10</option>
							  <option value="20">20</option>
							  <option value="50">50</option>
							</select>
							<label>Limit</label>
						</div>
			      	</div>
			      	<div class="col l12 m12 s12">
			      		<p class="col l4 m4 s12">
					      <input name="radio_filter" class="radio_filter" type="radio" value="0" id="all" checked />
					      <label for="all">All</label>
					    </p>
					    <p class="col l4 m4 s12">
					      <input name="radio_filter" class="radio_filter" type="radio" value="1" id="positive" />
					      <label for="positive">Inflow</label>
					    </p>
					    <p class="col l4 m4 s12">
					      <input name="radio_filter" class="radio_filter" type="radio" value="-1" id="negative" />
					      <label for="negative">Outflow</label>
					    </p>
			      	</div>
			      </div>
			    </li>
			</ul>
		</div>
	</div>
	<div class="row">
		<div id="history">
			<div class="progress w3-brown">
			  	<div class="indeterminate"></div>
			</div>
		</div>
	</div>
	<div class="row">
		<div class="pagination" id="pagination"></div>
	</div>
	<div class="row">
		<div class="fixed-action-btn toolbar">
		    <a class="btn-floating btn-large w3-brown tooltipped" data-position="left" data-tooltip="Option">
		      <i class="large fa fa-bars"></i>
		    </a>
		    <ul>
		      <li class="waves-effect waves-light w3-hover-brown w3-black"><a href="#people_edit" class="tooltipped" data-position="top" data-tooltip="Edit People"><i class="fa fa-pencil"></i></a></li>
		      <li class="waves-effect waves-light w3-hover-brown w3-black"><a href="#money" class="tooltipped" data-position="top" data-tooltip="Money transaction update"><i class="fa fa-exchange"></i></a></li>
		      <li class="waves-effect waves-light w3-hover-brown w3-black"><a id="money_settle" class="tooltipped" data-position="top" data-tooltip="Settled"><i class="fa fa-handshake-o"></i></a></li>
		      <li class="waves-effect waves-light w3-hover-brown w3-black"><a id="history_delete_all_btn" class="tooltipped" data-position="top" data-tooltip="Clear all history"><i class="fa fa-trash"></i></a></li>
		    </ul>
	  	</div>
	</div>
</div>

<!-- Edit People Modal Structure -->
<div id="people_edit" class="modal">
	<div class="modal-content">
		<div class="row">
			<div class="input-field col s12">
			  <input id="people_edit_name" type="text" class="validate" data-length="20">
			  <label for="people_edit_name">Name</label>
			</div>
		</div>
		<div class="row">
			<div class="input-field col s12">
			  <input id="people_edit_description" type="text" class="validate" data-length="50">
			  <label for="people_edit_description">Description</label>
			</div>
		</div>
		<div class="row w3-center">
			<button class="waves-effect waves-light btn w3-brown" id="people_update_btn">Update People</button>
		</div>
	</div>
</div>

<!-- Money transaction update modal -->
<div id="money" class="modal">
	<div class="modal-content">
		<div class="row">
			<div class="col l6 m6 s12">
				<div class="input-field">
					<select id="money_type">
					  <option value="" disabled selected>Choose your option</option>
					  <option value="1">I give / I have to recieved</option>
					  <option value="-1">I recieved / I have to give</option>
					</select>
					<label>Type</label>
				</div>
				<div class="input-field">
				  <input id="money_amount" type="number" class="validate">
				  <label for="money_amount">Amount</label>
				</div>
				<div class="input-field">
				  <input id="money_remark" type="text" class="validate" data-length="50">
				  <label for="money_remark">Remark</label>
				</div>
				<button class="waves-effect waves-light btn w3-brown" id="money_btn">Update</button>
			</div>
			<div class="col l6 m6 s12">
				<ul class="w3-ul w3-small w3-text-teal">
					<li><b>I give / I have to recieved</b></li>
					<li>If you pay for them</li>
					<li>If you give them</li>
					<li>If they borrow from you</li>
					<li>If you will get any amount</li>
			    </ul>
			    <ul class="w3-ul w3-small w3-text-pink">
					<li><b>I recieved / I have to give</b></li>
					<li>If they pay for you</li>
					<li>If they give you</li>
					<li>If you borrow from them</li>
					<li>If you will give any amount</li>
			    </ul>
			</div>
		</div>
	</div>
</div>

<?php require_once 'footer.php'; ?>

<script>
var people_id='<?=$people_id?>';

//**********************************************document ready******************************************
$("document").ready(function(){
	set_page_name("Details");
	get_data();
	$('.collapsible').collapsible();
});

//********************************************get data from api******************************************
function get_data(){
	//first check whether this people really belogs to the login user, if not , then redirect to the people.php page
	$.post("userapi/people/people_check.php",
	{
		people_id:people_id
	},function(data){
		//console.log(data);
		var arr=JSON.parse(data);
		if(arr["status"]=="success"){
			print_data();
		}else{
			Materialize.toast(arr["remark"], 4000, "w3-pink");
			window.location="people";
		}
	});
}

//**********************************************print all data when recieved**************************************
function print_data(){
	print_data_people();
	print_data_count();
	pagination();
}

//**********************************************print the people detail******************************************
function print_data_people(){
	$.post("userapi/people/people_detail.php",
	{
		people_id:people_id
	},function(data){
		//console.log(data);
		var arr=JSON.parse(data);
		if(arr["status"]=="success"){
			$("#people_name").text(arr["people"][0]["name"]);
			$("#people_description").text(arr["people"][0]["description"]);

			//put data in edit people modal
			$("#people_edit_name").val(arr["people"][0]["name"]);
			$("#people_edit_description").val(arr["people"][0]["description"]);
			Materialize.updateTextFields();
		}else{
			Materialize.toast(arr["remark"], 4000, "w3-pink");
		}
	});
}

//***********************************************print the money count detail**********************************
function print_data_count(){
	$.post("userapi/money/money_count.php",
	{
		people_id:people_id
	},function(data){
		//console.log(data);
		var arr=JSON.parse(data);
		if(arr["status"]=="success"){
			$("#people_balance").html('<b class="'+get_text_color(arr["balance"])+'">'+arr["currency"]+" "+Math.abs(arr["balance"])+'</b>');
			$("#people_positive").html('<b class="'+get_text_color(arr["positive"])+'">'+arr["currency"]+" "+Math.abs(arr["positive"])+'</b>');
			$("#people_negative").html('<b class="'+get_text_color(arr["negative"])+'">'+arr["currency"]+" "+Math.abs(arr["negative"])+'</b>');
		}else{
			Materialize.toast(arr["remark"], 4000, "w3-pink");
		}
	});
}

//************************************************print user money history**************************************
function pagination(){
	var out="";
	var search=$("#people_search").val().trim();
	var limit=$("#limit").val().trim();
	var radio_filter=parseInt($('input:radio[name=radio_filter]:checked').val());
	$.post("userapi/money/money_list.php",
	{
		people_id:people_id,
		search:search,
		radio_filter:radio_filter,
		page:1,
		limit:limit
	},function(data){
		//console.log(data);
		var arr=JSON.parse(data);
		if(arr["status"]=="success"){
			$(".pagination").html("");
			$('.pagination').materializePagination({
			    lastPage: parseInt(arr["pagination"]),
			    onClickCallback: function(page){
			        print_data_history(page);
			    }
			});
		}else{
			out='<h4 class="w3-text-red w3-center">'+arr["remark"]+'</h4>';
			$(".pagination").html("");
		}
		$("#history").html(out);
	});
}

function print_data_history(page=1){
	var out="";
	var search=$("#people_search").val().trim();
	var limit=$("#limit").val().trim();
	var radio_filter=parseInt($('input:radio[name=radio_filter]:checked').val());
	$.post("userapi/money/money_list.php",
	{
		people_id:people_id,
		search:search,
		radio_filter:radio_filter,
		page:page,
		limit:limit
	},function(data){
		//console.log(data);
		var arr=JSON.parse(data);
		if(arr["status"]=="success"){
			for(i=0;i<arr["money"].length;i++){
				out+='<div class="col l6 m12 s12">';
					out+='<div class="card w3-hover-shadow w3-display-container">';
						out+='<div class="row w3-padding-small">';
				  			out+='<div class="col s8">';
				  				out+='<p class="w3-text-brown">'+arr["money"][i]["remark"]+'</p>';
				  			out+='</div>';
				  			out+='<div class="col s4 w3-right-align">';
				  				out+='<h5 class="'+get_text_color(arr["money"][i]["amount"])+'">'+arr["currency"]+' '+Math.abs(arr["money"][i]["amount"])+'</h5>';
				  				out+='<p class="w3-tiny">'+arr["money"][i]["datetime"]+'</p>';
				  			out+='</div>';
				  			out+='<div class="w3-display-middle w3-display-hover">';
				  				out+='<a class="waves-effect waves-light btn-floating w3-black w3-hover-brown tooltipped" data-money_id="'+arr["money"][i]["money_id"]+'" data-people_id="'+arr["money"][i]["people_id"]+'" id="history_delete_btn" data-position="top" data-tooltip="Delete"><i class="fa fa-trash w3-medium"></i></a>';
				  			out+='</div>';
			  			out+='</div>';
			    	out+='</div>';
				out+='</div>';
			}
		}else{
			out='<h4 class="w3-text-red w3-center">'+arr["remark"]+'</h4>';
		}
		$("#history").html(out);
		$('.tooltipped').tooltip();
	});
}

//***********************************************search when user type something********************************
$("#people_search").keyup(function(){
	pagination();
});

//**********************************************filter by selecting radio button refimeing**********************
$(".radio_filter").change(function(){
	pagination();
});

$("#limit").change(function(){
	pagination();
});

//***********************************************load more function*******************************************


//***********************************************************people update function*****************************
$("body").on("click","#people_update_btn",function(){
	var name=$("#people_edit_name").val().trim();
	var description=$("#people_edit_description").val().trim();

	$.post("userapi/people/people_update.php",
	{
		people_id:people_id,
		name:name,
		description:description
	},function(data){
		//console.log(data);
		var arr=JSON.parse(data);
		if(arr["status"]=="success"){
			$("#people_edit_name").val("");
			$("#people_edit_description").val("");
			print_data_people();
			$('#people_edit').modal('close');
			Materialize.toast(arr["remark"], 4000, "w3-teal");
		}else{
			Materialize.toast(arr["remark"], 4000, "w3-pink");
		}
	});
});

$('#people_edit_name').keypress(function(e){
    if(e.which == 13){//Enter key pressed
        $('#people_update_btn').click();//Trigger search button click event
    }
});

$('#people_edit_description').keypress(function(e){
    if(e.which == 13){//Enter key pressed
        $('#people_update_btn').click();//Trigger search button click event
    }
});

//*********************************************************money transaction modal****************************************
$("body").on("click","#money_btn",function(){
	var type=$("#money_type").val();
	var amount=$("#money_amount").val();
	var remark=$("#money_remark").val();

	$.post("userapi/money/money_add.php",
	{
		people_id:people_id,
		type:type,
		amount:amount,
		remark:remark
	},function(data){
		//console.log(data);
		var arr=JSON.parse(data);
		if(arr["status"]=="success"){
			$("#money_type").val("");
			$("#money_amount").val("");
			$("#money_remark").val("");
			
			Materialize.updateTextFields();
			$('select').material_select();
			print_data_count();
			pagination();
			$('#money').modal('close');
			Materialize.toast(arr["remark"], 4000, "w3-teal");
		}else{
			Materialize.toast(arr["remark"], 4000, "w3-pink");
		}
	});
});

$('#money_amount').keypress(function(e){
    if(e.which == 13){//Enter key pressed
        $('#money_btn').click();//Trigger search button click event
    }
});

$('#money_remark').keypress(function(e){
    if(e.which == 13){//Enter key pressed
        $('#money_btn').click();//Trigger search button click event
    }
});

//******************************************************when click on delete button**********************************
$("body").on("click","#history_delete_btn",function(){
	var money_id=$(this).data("money_id");
	
	swal({
	  title: "Are you sure ?",
	  text: "You will not be able to recover this data!",
	  type: "warning",
	  showCancelButton: true,
	  confirmButtonColor: "#DD6B55",
	  confirmButtonText: "Yes, delete it!",
	  closeOnConfirm: true
	},
	function(){
	  $.post("userapi/money/money_delete.php",
		{
			people_id:people_id,
			money_id:money_id
		},function(data){
			//console.log(data);
			var arr=JSON.parse(data);
			if(arr["status"]=="success"){
				print_data_count();
				pagination();
				Materialize.toast(arr["remark"], 4000, "w3-teal");
			}else{
				Materialize.toast(arr["remark"], 4000, "w3-pink");
			}
		});
	});
});

//**************************************************when click to settled button**********************************
$("body").on("click","#money_settle",function(){
	swal({
	  title: "You want to settled ?",
	  text: "It will reset your balance to zero",
	  type: "warning",
	  showCancelButton: true,
	  confirmButtonColor: "#DD6B55",
	  confirmButtonText: "Yes, do it!",
	  closeOnConfirm: true
	},
	function(){
	  $.post("userapi/money/money_settle.php",
		{
			people_id:people_id
		},function(data){
			//console.log(data);
			var arr=JSON.parse(data);
			if(arr["status"]=="success"){
				print_data_count();
				pagination();
				Materialize.toast(arr["remark"], 4000, "w3-teal");
			}else{
				Materialize.toast(arr["remark"], 4000, "w3-pink");
			}
		});
	});
});

//******************************************************when click on delete all button**********************************
$("body").on("click","#history_delete_all_btn",function(){
	swal({
	  title: "Are you sure ?",
	  text: "This will delete all transaction for this people",
	  type: "warning",
	  showCancelButton: true,
	  confirmButtonColor: "#DD6B55",
	  confirmButtonText: "Yes, delete all!",
	  closeOnConfirm: true
	},
	function(){
	  $.post("userapi/money/money_delete.php",
		{
			people_id:people_id
		},function(data){
			//console.log(data);
			var arr=JSON.parse(data);
			if(arr["status"]=="success"){
				print_data_count();
				pagination();
				Materialize.toast(arr["remark"], 4000, "w3-teal");
			}else{
				Materialize.toast(arr["remark"], 4000, "w3-pink");
			}
		});
	});
});

</script>