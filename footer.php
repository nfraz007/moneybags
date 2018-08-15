<footer class="page-footer w3-brown">
    <div class="container">
      <div class="row">
        <div class="col l6 s12">
          <h5 class="white-text">About Us</h5>
          <p class="grey-text text-lighten-4">We are a team of college students working on this project like it's our full time job. Any amount would help support and continue development on this project and is greatly appreciated.</p>


        </div>
        <div class="col l3 s12">
          <h5 class="white-text">Settings</h5>
          <ul>
            <li><a class="white-text" href="#!">Feedback</a></li>
            <li><a class="white-text" href="#!">Contact Us</a></li>
            <li><a class="white-text" href="#!">About Us</a></li>
            <li><a class="white-text" href="#!">Career</a></li>
          </ul>
        </div>
        <div class="col l3 s12">
          <h5 class="white-text">Connect</h5>
          <ul>
            <li><a class="white-text" href="#!">Facebook</a></li>
            <li><a class="white-text" href="#!">Google</a></li>
            <li><a class="white-text" href="#!">Twitter</a></li>
          </ul>
        </div>
      </div>
    </div>
    <div class="footer-copyright">
      <div class="container">
      Created by <a class="brown-text text-lighten-3" href="http://nfraz.co.nf" target="_blank">Nazish Fraz</a>
      </div>
    </div>
  </footer>


  <!--  Scripts-->
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert.min.js"></script>
  <script src="assets/js/materialize.js"></script>
  <script src="assets/js/init.js"></script>
  <script src="assets/amcharts/amcharts.js" type="text/javascript"></script>
  <script src="assets/amcharts/pie.js" type="text/javascript"></script>
  <script src="assets/amcharts/plugins/dataloader/dataloader.min.js" type="text/javascript"></script>
  <script src="assets/pagination/pagination.js" type="text/javascript"></script>

  </body>
</html>

<script>
$(document).ready(function(){
    $('.modal').modal();
    $('select').material_select();

    //**************************************************login modal function*************************************
    $('#login_btn').click(function(){
        if(login_validation()){
          $.post("userapi/user/login.php",
          {
            email:$("#login_email").val(),
            password:$("#login_password").val()
          },function(data){
            //console.log(data);
            var arr=JSON.parse(data);
            if(arr["status"]=="success"){
              //successfully created the account
              $("#login_email").val("");
              $("#login_password").val("");
              Materialize.toast(arr["remark"], 4000, "w3-teal");
              location.reload();
            }else{
              Materialize.toast(arr["remark"], 4000, "w3-pink");
            }
          });
        }
    });
    $('#login_email').keypress(function(e){
        if(e.which == 13){//Enter key pressed
            $('#login_btn').click();//Trigger search button click event
        }
    });
    $('#login_password').keypress(function(e){
        if(e.which == 13){//Enter key pressed
            $('#login_btn').click();//Trigger search button click event
        }
    });

    //********************************************register modal function*********************************
    $('#register_btn').click(function(){
        if(register_validation()){
          $.post("userapi/user/register.php",
          {
            fname:$("#register_fname").val(),
            lname:$("#register_lname").val(),
            email:$("#register_email").val(),
            password:$("#register_password").val()
          },function(data){
            //console.log(data);
            var arr=JSON.parse(data);
            if(arr["status"]=="success"){
              //successfully created the account
              $("#register_fname").val("");
              $("#register_lname").val("");
              $("#register_email").val("");
              $("#register_password").val("");
              $("#register_c_password").val("");
              Materialize.toast(arr["remark"], 4000, "w3-teal");
              $('#register').modal('close');
            }else{
              Materialize.toast(arr["remark"], 4000, "w3-pink");
            }
          });
        }
    });
    $('#register_fname').keypress(function(e){
        if(e.which == 13){//Enter key pressed
            $('#register_btn').click();//Trigger search button click event
        }
    });
    $('#register_lname').keypress(function(e){
        if(e.which == 13){//Enter key pressed
            $('#register_btn').click();//Trigger search button click event
        }
    });
    $('#register_email').keypress(function(e){
        if(e.which == 13){//Enter key pressed
            $('#register_btn').click();//Trigger search button click event
        }
    });
    $('#register_password').keypress(function(e){
        if(e.which == 13){//Enter key pressed
            $('#register_btn').click();//Trigger search button click event
        }
    });
    $('#register_c_password').keypress(function(e){
        if(e.which == 13){//Enter key pressed
            $('#register_btn').click();//Trigger search button click event
        }
    });

    //*******************************************************logout section**********************************
    $(".logout_btn").click(function(){
      $.post("userapi/user/logout.php","",
        function(data){
          var arr=JSON.parse(data);
          if(arr["status"]=="success"){
            Materialize.toast(arr["remark"], 4000, "w3-teal");
            location.replace("index.php");
          }else{
            Materialize.toast(arr["remark"], 4000, "w3-pink");
          }
      })
    });
});

function login_validation(){
  var msg="";
  var email=$("#login_email").val();
  var password=$("#login_password").val();
  var email_pattern = /^([a-z\d!#$%&'*+\-\/=?^_`{|}~\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]+(\.[a-z\d!#$%&'*+\-\/=?^_`{|}~\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]+)*|"((([ \t]*\r\n)?[ \t]+)?([\x01-\x08\x0b\x0c\x0e-\x1f\x7f\x21\x23-\x5b\x5d-\x7e\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]|\\[\x01-\x09\x0b\x0c\x0d-\x7f\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]))*(([ \t]*\r\n)?[ \t]+)?")@(([a-z\d\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]|[a-z\d\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF][a-z\d\-._~\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]*[a-z\d\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])\.)+([a-z\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]|[a-z\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF][a-z\d\-._~\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]*[a-z\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])\.?$/i;

  if(email==""){
    msg="Please Enter your Email";
  }else if(!email_pattern.test(email)){
    msg="Please Enter a correct email address";
  }else if(password==""){
    msg="Please Enter your Password";
  }else if(password.length<6){
    msg="Password must be atleast 6 characters";
  }else msg="";

  if(msg!=""){
    Materialize.toast(msg, 4000, "w3-pink");
    return false;
  }
  else return true;
}

function register_validation(){
  var msg="";
  var fname=$("#register_fname").val();
  var lname=$("#register_lname").val();
  var email=$("#register_email").val();
  var password=$("#register_password").val();
  var c_password=$("#register_c_password").val();
  var email_pattern = /^([a-z\d!#$%&'*+\-\/=?^_`{|}~\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]+(\.[a-z\d!#$%&'*+\-\/=?^_`{|}~\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]+)*|"((([ \t]*\r\n)?[ \t]+)?([\x01-\x08\x0b\x0c\x0e-\x1f\x7f\x21\x23-\x5b\x5d-\x7e\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]|\\[\x01-\x09\x0b\x0c\x0d-\x7f\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]))*(([ \t]*\r\n)?[ \t]+)?")@(([a-z\d\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]|[a-z\d\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF][a-z\d\-._~\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]*[a-z\d\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])\.)+([a-z\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]|[a-z\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF][a-z\d\-._~\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]*[a-z\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])\.?$/i;

  if(fname==""){
    msg="Please Enter your First Name";
  }else if(lname==""){
    msg="Please Enter your Last Name";
  }else if(email==""){
    msg="Please Enter your Email";
  }else if(!email_pattern.test(email)){
    msg="Please Enter a correct email address";
  }else if(password==""){
    msg="Please Enter your Password";
  }else if(c_password==""){
    msg="Please Enter your Comfirm Password";
  }else if(password!=c_password){
    msg="Password & Comfirm password is not same";
  }else if(password.length<6 && c_password.length<6){
    msg="Password must be atleast 6 characters";
  }else msg="";

  if(msg!=""){
    Materialize.toast(msg, 4000, "w3-pink");
    return false;
  }
  else return true;
}

//*************************************************************function determine the color************************
function get_text_color(amount){
  amount=parseInt(amount);
  if(amount>0){
    return "w3-text-teal";
  }else if(amount<0){
    return "w3-text-pink";
  }else{
    return "w3-text-black";
  }
}

//*************************************************************function for set page title************************
function set_page_name(name){
  $("#page_name").html(' / '+name);
}

</script>