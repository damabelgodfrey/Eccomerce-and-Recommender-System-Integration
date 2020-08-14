<?php
require_once $_SERVER['DOCUMENT_ROOT'].'/ecommerce/core/staff-init.php';
include 'includes/head.php';

$email = ((isset($_POST['email']))?sanitize($_POST['email']):'');
$email =trim($email);
$password = ((isset($_POST['password']))?sanitize($_POST['password']):'');
$password = trim($password);
$errors =array();
if(isset($_SESSION['staff_rdrurl'])){
  $link= $_SESSION['staff_rdrurl'];
}else{
  $link = '/ecommerce/index';
}
?>

<?php
if($_POST){
  if(empty($_POST['email']) || empty($_POST['email'])){
    $errors[] = 'You must provide email and password.';
  }else if(!filter_var($email,FILTER_VALIDATE_EMAIL)){
    $errors[] = 'You must enter a valid email';
  }else{}


<<<<<<< HEAD
    //$query = $db->query("SELECT * FROM staffs WHERE email = '$email'");
    $repoObject = new UserController();
    $query =$repoObject->selectUser("staff",$email);
  //$user = mysqli_fetch_assoc($query);
    $userCount = count($query);
=======
    $query = $db->query("SELECT * FROM staffs WHERE email = '$email'");
    $user = mysqli_fetch_assoc($query);
    $userCount = mysqli_num_rows($query);
>>>>>>> 00946282fd0ced214a37681e144e38779b687dd4
    if($userCount == 0){
      $errors[] = 'The email provided does not exist on the system.';
      echo display_errors($errors);
    }else{
<<<<<<< HEAD
      foreach ($query as $user) {
        if(!password_verify($password,$user['password'])){
          $errors[] = 'Email or password is incorrect';
          echo display_errors($errors);
        }else{

        $staff_id = $user['id'];
        $staff_username = $user['username'];
        $staff_permission = $user['permissions'];
        loginstaff($staff_id,$staff_username,$staff_permission);
      }
      }

=======
      if(!password_verify($password,$user['password'])){
        $errors[] = 'Email or password is incorrect';
        echo display_errors($errors);
      }else{

      $staff_id = $user['id'];
      $staff_username = $user['username'];
      $staff_permission = $user['permissions'];
      loginstaff($staff_id,$staff_username,$staff_permission);
    }
>>>>>>> 00946282fd0ced214a37681e144e38779b687dd4
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
margin: 20px auto 0;
min-width: 400px;
max-width: 500px;
position: absolute;
 margin: auto;
 top: 0;
 right: 0;
 bottom: 0;
 left: 0;
 height: 320px;
 box-shadow: 5px 7px 10px grey;
 font-size: 16px;
 font-size: 18px;
}
.login h1 {
background-image: linear-gradient(#f1f3f3, #d4dae0);
border-bottom: 1px solid #a6abaf;
border-radius: 6px 6px 0 0;
box-sizing: border-box;
color: #2a2b3d;
display: block;
height: 45px;
font: 600 22px/1 'Open Sans', sans-serif;
padding-top: 10px;
margin: 0;
text-align: center;
text-shadow: 0 -1px 0 rgba(0,0,0,0.2), 0 1px 0 #fff;
user-select: none;
}
input[type="password"], input[type="text"] {
border: 1px solid #a1a3a3;
border-radius: 4px;
box-shadow: 0 1px #2a2b3d;
box-sizing: border-box;
color: #696969;
height: 39px;
margin: 31px 0 0 90px;
padding-left: 20px;
transition: box-shadow 0.3s;
width: 60%;
min-width: 350px;
max-width: 450px;
}
input[type="email"], input[type="text"] {
border: 1px solid #a1a3a3;
border-radius: 4px;
box-shadow: 0 1px #2a2b3d;
box-sizing: border-box;
color: #696969;
height: 39px;
margin: 31px 0 0 90px;
padding-left: 20px;
transition: box-shadow 0.3s;
width: 60%;
min-width: 350px;
max-width: 450px;
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
font: 12px/1 sans-serif;
left: -50px;
position: relative;
text-decoration: none;
top: -15px;
transition: color .4s;
}
.forgot:hover { color: white;}
input[type="submit"] {
  background-color: #404361;
  border: 2px solid #2a2b3d;
  border-radius: 10px;
  box-shadow: inset 0 1px rgba(255,255,255,0.3);
  box-sizing: border-box;
  color: #f8f8f8;
  font-weight: 700;
  height: 39px;
  margin: 12px 0 0 100px;
  text-shadow: 0 -1px 0 #177c6a;
  /* width: 60%; */
  min-width: 300px;
  max-width: 350px;
}
input[type="submit"]:hover, input[type="submit"]:focus {
background-image: linear-gradient(#2a2b3d,#404361)
}
input[type="submit"]:active {
background-image: linear-gradient(#2a2b3d, #404361);
padding: 0;
}


.switch {
position: absolute;
display: inline-block;
width: 30px;
height: 15px;
margin: 10;
margin: 12px 0 0 417px;
top: 146px
}
.show{
  margin: 12px 0 0 35px;
  color: white;
}

.switch input {
  display: none;
}

.slider {
  position: absolute;
  cursor: pointer;
  top: 0;
  left: 0;
  right: 0;
  bottom: 0;
  background-color: #cdcdcd;
  transition: 0.4s;
}
.click{
cursor: pointer;
background-color: #cdcdcd;
}
.slider::before {
  position: absolute;
  content: "";
  height: 10px;
  width: 8px;
  left: 2px;
  bottom: 3px;
  background-color: #ffffff;
  transition: 0.4s;
}

input:checked + .slider {
  background-color: #2a2b3d;
  border-width: thin;
  border-color: white;
}

input:focus + .slider {
  box-shadow: 0 0 1px #2a2b3d;
}

input:checked + .slider::before {
  transform: translateX(20px);
}

.slider.round {
  border-radius: 34px;
}

.slider.round::before {
  border-radius: 50%;
}
.myspan{
position: absolute;
height: 39px;
left: 60px;
top: 76px;
background-color: #404361;
width: 43px;
border: 1px solid #a1a3a3;
border-radius: 4px;

}
.myspan2{
  position: absolute;
  height: 39px;
  left: 60px;
  top: 146px;
  background-color: #404361;
  width: 43px;
  border: 1px solid #a1a3a3;
  border-radius: 4px;

}
.myfa{
  font-size: 35px;
  padding-left: 3px;
  padding-top: 0px;
  color: lightgrey;
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

  <h1>Admin</h1>
  <form action="login.php" method="post">
    <div class="place">
      <label class="myspan"><i class="myfa fa fa-envelope-o" aria-hidden="true"></i></label>
      <input type="email" name="email" id="email" class="" value="" placeholder="Enter Email" required >
      <label class="myspan2"><i class="myfa2 fa fa-lock" aria-hidden="true"></i></label>
      <input type="password" name="password" id="password" class="" value="" placeholder="Enter Password" required>
    </div>

  <p></p>
  <label class="switch">
    <input type="checkbox" class=" c" >
    <span class="slider round"></span>
  </label><br>
  <a class="forgot" href="#">forgot password?</a>
  <input type="submit" value="Sign In" />
</form>

</div>
<script src="http://code.jquery.com/jquery-1.11.0.min.js"></script>
<script>
$('.c').click(function(){
if (this.checked) {
  $('#password').attr('type', 'text');
} else {
  $('#password').attr('type', 'password');
}

});
</script>
