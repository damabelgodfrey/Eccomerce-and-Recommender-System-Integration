<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
<?php
require_once $_SERVER['DOCUMENT_ROOT'].'/ecommerce/core/init.php';
include 'includes/head.php';

$email = ((isset($_POST['email']))?sanitize($_POST['email']):'');
$email =trim($email);
$password = ((isset($_POST['password']))?sanitize($_POST['password']):'');
$password = trim($password);
$errors =array();
if(isset($_SESSION['rdrurl'])){
  $link= $_SESSION['rdrurl'];
}else{
  $link = '/ecommerce/index';
}
?>
<style>
body{
  background-image: url("ecommerce/images/headerlogo/background.jpg");
  background-size: 100vw 100vh;
  background-attachment: fixed;
}
</style>


<?php
if($_POST){
  if(empty($_POST['email']) || empty($_POST['email'])){
    $errors[] = 'You must provide email and password.';
  }else if(!filter_var($email,FILTER_VALIDATE_EMAIL)){
    $errors[] = 'You must enter a valid email';
  }else{}


    //$query = $db->query("SELECT * FROM customer_user WHERE email = '$email'");
    $repoObject = new UserController();
    $query =$repoObject->selectUser("customer",$email);
    $userCount = count($query);
    if($userCount == 0){
      $errors[] = 'The email provided does not exist on the system.';
    }else{
      foreach ($query as $user) {
        if(!password_verify($password,$user['password'])){
          $errors[] = 'Email or password is incorrect';
        }else{
        $staff_id = $user['id'];
        $staff_username = $user['username'];
        $staff_permission = $user['permissions'];
        loginCustomer($staff_id,$staff_username,$staff_permission);
        }
      }
  }
}
 ?>

</div>
<!--<img class = "display" src="/ecommerce/images/headerlogo/login-image.png" alt=""> -->
<style media="screen">
html { height: 100% }
body {
background-color: #2a2b3d;
}
.login {
background: #404361;
border: 1px solid #42464b;
border-radius: 6px;
/* margin: 20px auto 0; */
/* min-width: 400px; */
padding-top: 10;
max-width: 570px;
position: absolute;
margin: auto;
top: 0;
right: 0;
bottom: 0;
left: 0;
height: 320px;
box-shadow: 5px 7px 10px grey;
font-size: 18px;
border-radius: 60px;
/*  background-image: url(../images/headerlogo/logo.jpg); */
}
.login h1 {
background-image: linear-gradient(#404361, #e8f0fe);
/* border-bottom: 1px solid #a6abaf; */
border-radius: 40px 40px 0 0;
box-sizing: border-box;
color: #2a2b3d;
display: block;
height: 45px;
/* font: 600 22px/1 'Open Sans', sans-serif; */
/* padding-top: 10px; */
margin: 0;
text-align: center;
text-shadow: 0 -1px 0 rgba(0,0,0,0.2), 0 1px 0 #fff;
user-select: none;
/* padding-left: 100px; */
}
input[type="password"], input[type="text"] {
border: 1px solid #a1a3a3;
border-radius: 4px;
box-shadow: 0 1px #2a2b3d;
box-sizing: border-box;
color: #696969;
height: 39px;
/* margin: 31px 0 0 120px; */
padding-left: 20px;
transition: box-shadow 0.3s;
width: 60%;
max-width: 550px;
top: 52px;
left: 22.3%;
position: relative;
z-index: 2;
}
input[type="email"], input[type="text"] {
border: 1px solid #a1a3a3;
border-radius: 4px;
box-shadow: 0 1px #2a2b3d;
box-sizing: border-box;
color: #696969;
height: 39px;
/* margin: 31px 0 0 120px; */
padding-left: 20px;
transition: box-shadow 0.3s;
width: 60%;
max-width: 450px;
top: 21px;
left: 22.3%;
position: relative;
z-index: 2;
}
input[type="password"]:focus, input[type="text"]:focus {
box-shadow: 0 0 6px 5px rgba(55, 166, 155, 0.3);
outline: 0;
border: 2px solid rgba(55, 166, 155, 0.3);
}
input[type="email"]:focus, input[type="text"]:focus {
  box-shadow: 0 0 6px 5px rgba(55, 166, 155, 0.3);
  outline: 0;
  border: 2px solid rgba(55, 166, 155, 0.3);
}
.forgot {
  color: #c3d9ec;
  display: inline-block;
  float: right;
  font: 14px/1 sans-serif;
  position: absolute;
  text-decoration: none;
  transition: color .4s;
  right: 17%;
  top: 60%;
  position: absolute;
}
.forgot:hover { color: white;}
input[type="submit"] {
  background-color: #404361;
  border: 2px solid #2a2b3d;
  border-radius: 10px;
  box-shadow: inset 0 1px rgba(255,255,255,0.3);
  box-sizing: border-box;
  color: #c3d9ec;
  font-weight: 700;
  height: 39px;
  /* margin: 0 0 0 110px; */
  text-shadow: 0 -1px 0 #177c6a;
  width: 60%;
  max-width: 350px;
  left: 19%;
  top: 213px;
  position: absolute;
}
input[type="submit"]:hover, input[type="submit"]:focus {
background-image: linear-gradient(#2a2b3d,#404361)
}
input[type="submit"]:active {
background-image: linear-gradient(#2a2b3d, #404361);
padding: 0;
}

.returnB{
  color: #c3d9ec;
background-color: #2a2b3d;
right: 45px;
top: 91%;
position: absolute;
border-radius: 20px 20px 20px 20px;
width: 150px;
}
.returnB:hover { color: #337ab7;width: 160px;}
.register{
color: #c3d9ec;
background-color: #2a2b3d;
left: 45px;
top: 91%;
position: absolute;
border-radius: 20px 20px 20px 20px;
width: 150px;
}
.register:hover { color: #337ab7;width: 160px;}
.switch {
  position: absolute;
  display: inline-block;
  width: 30px;
  height: 15px;
  /* margin: 10; */
  left: 78%;
  top: 158px;
  z-index: 4;
}
.show{
  margin: 12px 0 0 35px;
  color: white;
}

.switch input {
  display: none;
}
.password_vis_check{
  cursor: pointer;
}
.click{
cursor: pointer;
background-color: #cdcdcd;
}

.myspan{
position: absolute;
height: 39px;
left: 16%;
top: 76px;
background-color: #404361;
width: 43px;
border: 1px solid #a1a3a3;
border-radius: 4px;
z-index: 3;

}
.myerrors{
  position: absolute;
  left: 0px;
  top: 45px;
  width: 100%;
  font-size: 14px;
}
.myspan2{
  position: absolute;
  height: 39px;
  left: 16%;
  top: 146px;
  background-color: #404361;
  width: 43px;
  border: 1px solid #a1a3a3;
  border-radius: 4px;
  z-index: 3;
}
.myemail{
  position: absolute;
height: 39px;
left: 140px;
top: 88px;
font-size: 12px;
color: #c3d9ec;
display: none;
}
.mypassword{
  position: absolute;
      height: 39px;
      left: 140px;
      top: 190px;
font-size: 12px;
color: #c3d9ec;
display: none;
}
.myfa{
  font-size: 35px;
  padding-left: 3px;
  padding-top: 0px;
  color: lightgrey;
  z-index: 10
}
.myfa2{
  font-size: 40px;
  padding-left: 7.6px;
  padding-top: 0px;
  color: lightgrey;
}
.place{
  padding-left: 7.6px;
}
</style>
<div class="login">

  <h1>Customer login</h1>
  <form action="login" method="post">
    <div class="place form-group">
      <label class="myspan"><i class="myfa fa fa-envelope-o" aria-hidden="true"></i></label>
      <div id ="myerrors"class="myerrors">
        <?=display_errors($errors);?>
      </div>
      <input type="email" name="email" id="email" class="form-control" value="" placeholder="Enter Email" autocomplete="off" required onfocus="myFunctionemail(this)" onblur="myFunctionemailonblur()" >
      <div id="myemail"class="myemail">
      </div>
      <label class="myspan2"><i class="myfa2 fa fa-lock" aria-hidden="true"></i></label>
      <input type="password" name="password" id="password" class="form-control" value=" " autocomplete="off" placeholder="Enter Password" required onfocus="myFunctionpassword(this)" onblur="myFunctionpasswordonblur()">
      <div id="mypassword"class="mypassword">
      </div>
    </div>

  <p></p>
  <label class="switch">
    <input type="checkbox" class="password_vis" >
    <span class=""><i id="mypasswordcheck"class="password_vis_check fa fa-eye fa-eye-slash "  aria-hidden="true"></i></span>
  </label><br>
  <a class="forgot" href="#">forgot password?</a>
  <input type="submit" value="Sign In" />
</form>
<p class=" text-right"><a href="register" class="btn register btn-sm"><span > Register</span></a><p/>
<p class=" text-right"><a href="<?=$link;?>" class="btn returnB btn-sm"><span > Visit/Return to Site</span></a><p/>


</div>
<script src="http://code.jquery.com/jquery-1.11.0.min.js"></script>
<script>

//email
function myFunctionemail(x) {
  document.getElementById('mypassword').innerHTML = '';
  document.getElementById("myemail").style.color = '#c3d9ec';
  document.getElementById("myemail").style.autocomplete = 'off';
  document.getElementById("myemail").style.display = 'block';
    document.getElementById('myemail').innerHTML = 'Enter Email!';

    if( !$(x).val() ) {
      document.getElementById('myemail').innerHTML = '';
    }else{
      document.getElementById("myemail").style.top = '88px';
      document.getElementById("myemail").style.left = '150px';
      $("#myemail").animate({top: '118px'});
      $("#myemail").animate({left: '90px'});
    }
}
function myFunctionemailonblur(x) {
    if( $(x).val() ) {
      document.getElementById('myemail').innerHTML = 'Enter Email';

    }else{
      document.getElementById('myemail').innerHTML = '';

    }
}
$("#email").on("change keyup paste click", function(){
  var input = document.querySelector('input');

this.addEventListener('input', function()
{
  $("#myemail").animate({top: '118px'});
  $("#myemail").animate({left: '90px'});
  document.getElementById("myemail").style.color = 'orange';
  document.getElementById('myemail').innerHTML = 'Entering email...';
  document.getElementById('mypassword').innerHTML = '';


});
  if( !$(this).val() ) {
    document.getElementById('myemail').innerHTML = '';
  }

})

//password
function myFunctionpassword(y) {
  document.getElementById('myemail').innerHTML = '';
  document.getElementById("mypassword").style.color = '#c3d9ec';
  document.getElementById("mypassword").style.display = 'block';
  document.getElementById('mypassword').innerHTML = 'Enter Password!';

    $("#mypassword").animate({top: '190px'});
    $("#mypassword").animate({left: '90px'});
    if( !$(y).val() ) {
      document.getElementById('mypassword').innerHTML = '';
    }else{
      document.getElementById("mypassword").style.top = '150px';
      document.getElementById("mypassword").style.left = '150px';
      $("#mypassword").animate({top: '190px'});
      $("#mypassword").animate({left: '90px'});
    }
}
function myFunctionpasswordonblur(y) {
    if( $(y).val() ) {
      document.getElementById('mypassword').innerHTML = 'Enter Password';
    }else{
      document.getElementById('mypassword').innerHTML = '';

    }
}

$("#password").on("change keyup paste click", function(){
  var input = document.querySelector('input');

this.addEventListener('input', function()
{
  document.getElementById("mypassword").style.color = 'orange';
  document.getElementById('mypassword').innerHTML = 'Entering password...';

});
if( !$(this).val() ) {
  document.getElementById('mypassword').innerHTML = '';
}
})
$('.password_vis').click(function(){
  var element = document.getElementById("mypasswordcheck");
if (this.checked) {
element.classList.remove("fa-eye-slash");
element.style.color = 'orange';
document.getElementById("password").style.top = '52px';
document.getElementById("mypassword").style.color = 'orange';
$('#password').attr('type', 'text');
document.getElementById('mypassword').innerHTML = 'Password visibility on..';
} else {
element.style.color = 'grey';
element.classList.add("fa-eye-slash");
$('#password').attr('type', 'password');
document.getElementById('mypassword').innerHTML = '';
document.getElementById("mypassword").style.color = '#c3d9ec';
}

});
</script>
<script src='http://code.jquery.com/jquery-latest.js'></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>
