<?php
require_once $_SERVER['DOCUMENT_ROOT'].'/ecommerce/core/init.php';
include 'includes/head.php';

$email = ((isset($_POST['email']))?sanitize($_POST['email']):'');
$email =trim($email);
$password = ((isset($_POST['password']))?sanitize($_POST['password']):'');
$password = trim($password);
$errors =array();
?>
<style>
body{
  background-image: url("/ecommerce/images/headerlogo/login-image.png");
  background-size: 100vw 100vh;
  background-attachment: fixed;
}
</style>
<div id="login-form">
<div>

<?php
if($_POST){
  //form validatio
  if(empty($_POST['email']) || empty($_POST['email'])){
    $errors[] = 'You must provide email and password.';
  }
  // validate Email
  if(!filter_var($email,FILTER_VALIDATE_EMAIL)){
    $errors[] = 'You must enter a valid email';
  }

  //password is more than 6 characters
  if(strlen($password) < 6){
    $errors[] = 'Password must be atleast 6 characters';
  }
  //check if email exist in the Database
  $query = $db->query("SELECT * FROM users WHERE email = '$email'");
  $user = mysqli_fetch_assoc($query);
  $userCount = mysqli_num_rows($query);
  if($userCount == 0){
    $errors[] = 'The email provided does not exist on the system.';
  }
  if(!password_verify($password,$user['password'])){
    $errors[] = 'The password provided does not match that on our record. Please try again';
  }

  if(!empty($errors)){
    echo display_errors($errors);
  }else {
    //log user in
    $user_id = $user['id'];
    login($user_id); //login function is in helpers file
  }
}
 ?>

</div>
<!--<img class = "display" src="/ecommerce/images/headerlogo/login-image.png" alt=""> -->
<h2 class="text-center" style="color:white" >AMERITINZ ADMIN</h2><hr>
<form action="login.php" method="post">
  <div class="form-group">
    <label style="color:white" for="email">Email:</label>
    <input type="email" name="email" id="email" class="form-control" value="<?=$email;?>" placeholder="Enter Email"required>
  </div>
  <div class="form-group">
    <label style="color:white" for="password">Password:</label>
    <input type="password" name="password" id="password" class="form-control" value="<?=$password;?>" placeholder="Enter Password" required>
  </div>
  <div class="form-group">
    <input type="submit" value="Login" class="btn btn-primary btn-lg">
  </div>
</form>
<p class="text-right"><a href="/ecommerce/index.php" alt="home">Visit Site<a><p/>
</div>
<?php  include 'includes/footer.php'; ?>
