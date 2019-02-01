<?php
require_once $_SERVER['DOCUMENT_ROOT'].'/ecommerce/core/init.php';
if(!is_logged_in()){
  login_error_redirect();
}
include 'includes/head.php';

$hashed = $user_data['password'];
$old_password = ((isset($_POST['old_password']))?sanitize($_POST['old_password']):'');
$old_password = trim($old_password);
$password = ((isset($_POST['password']))?sanitize($_POST['password']):'');
$password = trim($password);
$confirm = ((isset($_POST['confirm']))?sanitize($_POST['confirm']):'');
$confirm = trim($confirm);
$new_hashed = password_hash($password, PASSWORD_DEFAULT);
$user_id = $user_data['id'];
$errors =array();
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

      /*$PUpdateConfirm = "SELECT * FROM users WHERE id = '$user_id'";
        $pass_result = $db->query($PUpdateConfirm);
        $checkPass = mysqli_fetch_assoc($pass_result);
        $DatabeasePass = (string)$checkPass['password'];
        $ValPass = (string) $new_hashed;
        echo $ValPass;
        echo "  seperte   ";
        echo $DatabeasePass;
        if($ValPass= $DatabeasePass){
          $_SESSION['success_flash'] = 'Your password has been updated!';
          header('Location: index.php');
        }else{
          $errors[] = 'Password change was not successful.';
          echo display_errors($errors);
        } */
      }
 ?>

</div>
<!--<img class = "display" src="/ecommerce/images/headerlogo/login-image.png" alt=""> -->
<h2 class="text-center" style="color:white" >Change Password</h2><hr>
<form action="change_password.php" method="post">
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
    <a href ="index.php" class="btn btn-default">Cancel</a>
    <input type="submit" value="Change password" class="btn btn-primary btn-lg">
  </div>
</form>
<p class="text-right"><a href="/ecommerce/index.php" alt="home">Visit Site<a><p/>
</div>
<?php  include 'includes/footer.php'; ?>
