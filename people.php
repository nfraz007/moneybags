<?php require_once 'header.php'; ?>

<div class="container">
	<div class="w3-padding-8"></div>
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
		<div id="people">
			<div class="progress w3-brown">
			  	<div class="indeterminate"></div>
			</div>
		</div>
	</div>
	<div class="row">
		<div class="pagination" id="pagination"></div>
	</div>
	<div class="row">
		<div class="fixed-action-btn">
		    <a class="btn-floating btn-large w3-brown tooltipped" href="#people_add" data-position="left" data-tooltip="Add People"><i class="large fa fa-plus"></i></a>
	  	</div>
	</div>
	<div class="w3-padding-24"></div>
</div>

<!-- Add People Modal Structure -->
<div id="people_add" class="modal">
	<div class="modal-content">
		<div class="row">
			<div class="input-field col s12">
			  <input id="people_add_name" type="text" class="validate" data-length="20">
			  <label for="people_add_name">Name</label>
			</div>
		</div>
		<div class="row">
			<div class="input-field col s12">
			  <input id="people_add_description" type="text" class="validate" data-length="50">
			  <label for="people_add_description">Description</label>
			</div>
		</div>
		<div class="row w3-center">
			<button class="waves-effect waves-light btn w3-brown" id="people_add_btn">Add People</button>
		</div>
	</div>
</div>

<!-- Edit People Modal Structure -->
<div id="people_edit" class="modal">
	<div class="modal-content">
		<input type="hidden" id="people_edit_people_id">
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

<?php require_once 'footer.php'; ?>

<script>
$("document").ready(function(){
	set_page_name("People");
	pagination();
});

function pagination(){
	var out="";
	var search=$("#people_search").val().trim();
	var limit=$("#limit").val().trim();
	var radio_filter=parseInt($('input:radio[name=radio_filter]:checked').val());
	$.post("userapi/people/people_list.php",
	{
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
			        print_data(page);
			    }
			});
		}else{
			out='<h4 class="w3-text-red w3-center">'+arr["remark"]+'</h4>';
			$(".pagination").html("");
		}
		$("#people").html(out);
	});
}

function print_data(page=1){
	var out="";
	var search=$("#people_search").val().trim();
	var limit=$("#limit").val().trim();
	var radio_filter=parseInt($('input:radio[name=radio_filter]:checked').val());
	$.post("userapi/people/people_list.php",
	{
		search:search,
		radio_filter:radio_filter,
		page:page,
		limit:limit
	},function(data){
		//console.log(data);
		var arr=JSON.parse(data);
		if(arr["status"]=="success"){
			for(i=0;i<arr["people"].length;i++){
				out+='<div class="col l6 m12 s12">';
					out+='<div class="card w3-hover-shadow w3-display-container">';
						out+='<div class="row w3-padding-small">';
				  			out+='<div class="col s8">';
				  				out+='<a href="people_detail.php?id='+arr["people"][i]["people_id"]+'" class="w3-text-black w3-hover-text-brown"><h5>'+arr["people"][i]["name"]+'</h5></a>';
				  				out+='<p class="w3-small">'+arr["people"][i]["description"]+'</p>';
				  			out+='</div>';
				  			out+='<div class="col s4 w3-right-align">';
				  				out+='<h5 class="'+get_text_color(arr["people"][i]["amount"])+'">'+arr["currency"]+' '+Math.abs(arr["people"][i]["amount"])+'</h5>';
				  				out+='<p class="w3-tiny">'+arr["people"][i]["datetime"]+'</p>';
				  			out+='</div>';
				  			out+='<div class="w3-display-middle w3-display-hover">';
				  				out+='<a id="people_detail_btn" data-people_id="'+arr["people"][i]["people_id"]+'" href="people_detail.php?id='+arr["people"][i]["people_id"]+'" class="waves-effect waves-light btn-floating w3-black w3-hover-brown tooltipped" data-position="top" data-tooltip="Detail/History"><i class="fa fa-user w3-medium"></i></a>&nbsp;';
				            	//out+='<a id="people_help_btn" data-amount="'+arr["people"][i]["amount"]+'" class="waves-effect waves-light btn-floating w3-black w3-hover-brown tooltipped" data-position="top" data-tooltip="Help"><i class="fa fa-question w3-medium"></i></a>&nbsp;';
				              	out+='<a id="people_edit_btn" data-people_id="'+arr["people"][i]["people_id"]+'" href="#people_edit" class="waves-effect waves-light btn-floating w3-black w3-hover-brown tooltipped" data-position="top" data-tooltip="Edit"><i class="fa fa-pencil w3-medium"></i></a>&nbsp;';
								out+='<button id="people_delete_btn" data-people_id="'+arr["people"][i]["people_id"]+'" class="waves-effect waves-light btn-floating w3-black w3-hover-brown tooltipped" data-position="top" data-tooltip="Delete"><i class="fa fa-trash w3-medium"></i></button>';
				  			out+='</div>';
			  			out+='</div>';
			    	out+='</div>';
				out+='</div>';
			}
		}else{
			out='<h4 class="w3-text-red w3-center">'+arr["remark"]+'</h4>';
		}
		$("#people").html(out);
		$('.modal').modal();
		$('.tooltipped').tooltip();
	});
}

$("#people_search").keyup(function(){
	pagination();
});

$(".radio_filter").change(function(){
	pagination();
});

$("#limit").change(function(){
	pagination();
});

//*********************************************add people function*************************************
$("#people_add_btn").click(function(){
	var name=$("#people_add_name").val().trim();
	var description=$("#people_add_description").val().trim();

	$.post("userapi/people/people_add.php",
	{
		name:name,
		description:description
	},function(data){
		//console.log(data);
		var arr=JSON.parse(data);
		if(arr["status"]=="success"){
			$("#people_add_name").val("");
			$("#people_add_description").val("");
			Materialize.updateTextFields();
			pagination();
			$('#people_add').modal('close');
			Materialize.toast(arr["remark"], 4000, "w3-teal");
		}else{
			Materialize.toast(arr["remark"], 4000, "w3-pink");
		}
	});
});

$('#people_add_name').keypress(function(e){
    if(e.which == 13){//Enter key pressed
        $('#people_add_btn').click();//Trigger search button click event
    }
});

$('#people_add_description').keypress(function(e){
    if(e.which == 13){//Enter key pressed
        $('#people_add_btn').click();//Trigger search button click event
    }
});

//***********************************************************delete people function*********************************
$("body").on("click","#people_delete_btn",function(){
	var people_id=$(this).data("people_id");
	swal({
	  title: "Are you sure ?",
	  text: "You will not be able to recover this people!",
	  type: "warning",
	  showCancelButton: true,
	  confirmButtonColor: "#DD6B55",
	  confirmButtonText: "Yes, delete it!",
	  closeOnConfirm: true
	},
	function(){
	  $.post("userapi/people/people_delete.php",
	  {
	  	people_id:people_id
	  },function(data){
	  	var arr=JSON.parse(data);
	  	if(arr["status"]=="success"){
	  		pagination();
			Materialize.toast(arr["remark"], 4000, "w3-teal");
	  	}else{
	  		Materialize.toast(arr["remark"], 4000, "w3-pink");
	  	}
	  });
	});
});

//*********************************************************people edit get data function*****************************
$("body").on("click","#people_edit_btn",function(){
	var people_id=$(this).data("people_id");
	$("#people_edit_people_id").val(people_id);
	$.post("userapi/people/people_detail.php",
	{
		people_id:people_id
	},function(data){
		//console.log(data);
		var arr=JSON.parse(data);
		if(arr["status"]=="success"){
			$("#people_edit_name").val(arr["people"][0]["name"]);
			$("#people_edit_description").val(arr["people"][0]["description"]);
			Materialize.updateTextFields();
		}else{
			Materialize.toast(arr["remark"], 4000, "w3-pink");
		}
	});
});

//***********************************************************people update function*****************************
$("body").on("click","#people_update_btn",function(){
	var people=$("#people_edit_people_id").val();
	var name=$("#people_edit_name").val().trim();
	var description=$("#people_edit_description").val().trim();

	$.post("userapi/people/people_update.php",
	{
		people_id:people,
		name:name,
		description:description
	},function(data){
		//console.log(data);
		var arr=JSON.parse(data);
		if(arr["status"]=="success"){
			$("#people_edit_people_id").val("");
			$("#people_edit_name").val("");
			$("#people_edit_description").val("");
			pagination();
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

//****************************************************people help function***************************************
$("body").on("click","#people_help_btn",function(){
	var amount=parseInt($(this).data("amount"));
	if(amount>0){
		Materialize.toast("I will get "+amount,4000, "w3-teal");
	}else if(amount<0){
		Materialize.toast("I have to pay "+Math.abs(amount),4000, "w3-pink");
	}else{
		Materialize.toast("Nothing to say",4000);
	}
});

</script>