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
						          <input type="search" id="history_search" placeholder="Search" required>
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
	<div class="w3-padding-24"></div>
</div>

<?php require_once 'footer.php'; ?>

<script>
$("document").ready(function(){
	set_page_name("History");
	pagination();
});

function pagination(){
	var out="";
	var search=$("#history_search").val().trim();
	var limit=$("#limit").val().trim();
	var radio_filter=parseInt($('input:radio[name=radio_filter]:checked').val());
	$.post("userapi/money/money_list.php",
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
		$("#history").html(out);
	});
}

function print_data(page=1){
	var out="";
	var search=$("#history_search").val().trim();
	var limit=$("#limit").val().trim();
	var radio_filter=parseInt($('input:radio[name=radio_filter]:checked').val());
	$.post("userapi/money/money_list.php",
	{
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
				  				out+='<a href="people_detail.php?id='+arr["money"][i]["people_id"]+'" class="w3-text-black w3-hover-text-brown"><h5>'+arr["money"][i]["name"]+'</h5></a>';
				  				out+='<p class="w3-small">'+arr["money"][i]["remark"]+'</p>';
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

$("#history_search").keyup(function(){
	pagination();
});

$(".radio_filter").change(function(){
	pagination();
});

$("#limit").change(function(){
	pagination();
});

//******************************************************when click on delete button**********************************
$("body").on("click","#history_delete_btn",function(){
	var money_id=$(this).data("money_id");
	var people_id=$(this).data("people_id");
	
	swal({
	  title: "Are you sure ?",
	  text: "you want to delete this transaction ?",
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
				pagination();
				Materialize.toast(arr["remark"], 4000, "w3-teal");
			}else{
				Materialize.toast(arr["remark"], 4000, "w3-pink");
			}
		});
	});
});

</script>