<?php
require_once $_SERVER['DOCUMENT_ROOT'].'/ecommerce/core/staff-init.php';
if(!is_staff_logged_in()){
  login_error_redirect();
}
include 'includes/head.php';
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
<div id="login-form">
<div>
<?php
if($_POST){
  //form validatio
  if(empty($_POST['old_password']) || empty($_POST['password']) || empty($_POST['confirm'])){
    $errors[] = 'You must fill in all fields';
  }
  //password is more than 6 characters
  if (!is_accept_password($password)){
  $errors[] = ' Password must be atleast 6 characters( and contain at least one digit, one upper case letter, one lower case letter)';
  }
  //check if new password matches confirm password
  if($password != $confirm){
    $errors[] = 'The new password and confirm password does not match.';
  }
  if(!password_verify($old_password,$hashed)){
    $errors[] = 'Your old password provided does not match that on our record. Please try again';
  }
  if(!empty($errors)){
    echo display_errors($errors);
  }else {
    //change password
        $db->query("UPDATE users SET password = '$new_hashed' WHERE id = '$user_id'");
        $_SESSION['success_flash'] = 'Your password has been updated!';
        header('Location: index.php');
      }
    }
 ?>
</div>
<h2 class="text-center" style="color:white" >Change Password</h2><hr>
<form action="change_password" method="post" >
  <div class="form-group">
    <label style="color:white" for="old_password">Old Password:</label>
    <input type="password" name="old_password" id="old_password" class="form-control" value="<?=$old_password;?>" placeholder="Old Password"required>
  </div>
  <div class="form-group">
    <label style="color:white" for="password">New Password:</label>
    <input type="password" name="password" id="password" class="form-control" value="<?=$password;?>" placeholder="New Password"required>
  </div>
  <div class="form-group">
    <label style="color:white" for="confirm">Confirm New Password:</label>
    <input type="password" name="confirm" id="confirm" class="form-control" value="<?=$confirm;?>" placeholder="Confirm New Password"required>
  </div>
  <div class="form-group">
    <a href ="<?=$link?>" class="btn btn-default">Cancel</a>
    <input type="submit" value="Change password" class="btn btn-primary btn-lg">
  </div>
</form>
<p class="text-right"><a href="<?=$link2?>" alt="home">Visit Site<a><p/>
</div>
<?php  include 'includes/footer.php'; ?>
