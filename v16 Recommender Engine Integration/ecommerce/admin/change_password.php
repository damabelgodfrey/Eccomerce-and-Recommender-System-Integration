<?php
require_once $_SERVER['DOCUMENT_ROOT'].'/ecommerce/core/staff-init.php';
if(!is_staff_logged_in()){
  login_error_redirect();
}
include 'includes/head.php';
?>

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
width: 320px;
position: absolute;
 margin: auto;
 top: 0;
 right: 0;
 bottom: 0;
 left: 0;
 height: 380px;
 box-shadow: 5px 7px 10px grey;
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
box-shadow: 0 1px #fff;
box-sizing: border-box;
color: #696969;
height: 39px;
margin: 31px 0 0 35px;
padding-left: 37px;
transition: box-shadow 0.3s;
width: 240px;
}
input[type="email"], input[type="text"] {
border: 1px solid #a1a3a3;
border-radius: 4px;
box-shadow: 0 1px #fff;
box-sizing: border-box;
color: #696969;
height: 39px;
margin: 31px 0 0 35px;
padding-left: 37px;
transition: box-shadow 0.3s;
width: 240px;
}
input[type="password"]:focus, input[type="text"]:focus {
box-shadow: 0 0 4px 1px rgba(55, 166, 155, 0.3);
outline: 0;
}

.forgot {
color: #7f7f7f;
display: inline-block;
float: right;
font: 12px/1 sans-serif;
left: -19px;
position: relative;
text-decoration: none;
top: -15px;
transition: color .4s;
}
.forgot:hover { color: #3b3b3b }
input[type="submit"] {
background-color: #404361;
border: 2px solid #2a2b3d;
border-radius: 10px;
box-shadow: inset 0 1px rgba(255,255,255,0.3);
box-sizing: border-box;
color: #f8f8f8;
font-weight: 700;
height: 39px;
margin: 12px 0 0 35px;
text-shadow: 0 -1px 0 #177c6a;
width: 240px;
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
    width: 50px;
    height: 15px;
    margin: 10;
    top: 262px;
    left: 150px;
}
.mylabel{
  position: absolute;
    display: inline-block;
    margin: 10;
    margin: 0px 0 0 0px;
    top: 270px;
    left: 40px;
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
  transform: translateX(39px);
}

.slider.round {
  border-radius: 34px;
}

.slider.round::before {
  border-radius: 50%;
}
</style>
<?php
$hashed = $staff_data['password'];
$old_password = ((isset($_POST['old_password']))?sanitize($_POST['old_password']):'');
$old_password = trim($old_password);
$password = ((isset($_POST['password']))?sanitize($_POST['password']):'');
$password = trim($password);
$confirm = ((isset($_POST['confirm']))?sanitize($_POST['confirm']):'');
$confirm = trim($confirm);
$new_hashed = password_hash($password, PASSWORD_DEFAULT);
$user_id = $staff_data['id'];
$errors =array();
if(isset($_SESSION['staff_rdrurl'])){
  $link= $_SESSION['staff_rdrurl'];
}else{
  $link = '/ecommerce/index';
}

if(isset($_SESSION['rdrurl'])){
  $link2= $_SESSION['rdrurl'];
}else{
  $link2 = '/ecommerce/index';
}
?>
<?php
if($_POST){
  //form validatio
  if(empty($_POST['old_password']) || empty($_POST['password']) || empty($_POST['confirm'])){
    $errors[] = 'You must fill in all fields';
  }else if ($password != $confirm ){
  $errors[] = 'The new password and confirm password does not match.';
 }else if(!is_accept_password($password)){
   $errors[] = ' Password must be atleast 6 characters( and contain at least one digit, one upper case letter, one lower case letter)';
}else if($password == $old_password){
  $errors[] = 'Choose a new password you have not used before.';
}else if(!password_verify($old_password,$hashed)){
    $errors[] = 'Your old password provided does not match that on our record. Please try again';
  }else{
    //
  }

  if(!empty($errors)){
    echo display_errors($errors);
  }else {
    //change password
<<<<<<< HEAD
        $repoObj= new UserController();
        $repoObj->updatepassword('staff',$new_hashed,$user_id);
=======
        $db->query("UPDATE users SET password = '$new_hashed' WHERE id = '$user_id'");
>>>>>>> 00946282fd0ced214a37681e144e38779b687dd4
        $_SESSION['success_flash'] = 'Your password has been updated!';
        header('Location: index.php');
      }
}
 ?>
<div class="login">
  <h1>Forget Password</h1>
  <form action="change_password.php" method="post">
  <input type="text" name="old_password" id="old_password" class="pass form-control" value="<?=$old_password;?>" placeholder="Old Password"required>
  <input type="password" name="password" id="password" class="pass form-control" value="<?=$password;?>" placeholder="New Password"required>
  <input type="password" name="confirm" id="confirm" class="pass form-control" value="<?=$confirm;?>" placeholder="Confirm New Password"required>
  <label class="switch">
    <input type="checkbox" class=" c" >
    <span class="slider round"></span>
  </label><br>
  <label class="mylabel">
    show password
  </label><p></p>
  <input type="submit" value="Change password" />
  <a href ="<?=$link?>" class="forget">Cancel</a>
</form>
</div>
<script src="http://code.jquery.com/jquery-1.11.0.min.js"></script>
<script>
$('.c').click(function(){
if (this.checked) {
  $('.pass').attr('type', 'text');
} else {
  $('.pass').attr('type', 'password');
}

});
</script>
<?php  include 'includes/footer.php'; ?>
