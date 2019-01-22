<?php
require_once '/core/init.php';
//is_logged_in function is in helper file
//check if user is logged in on any of the pages
//if(!is_logged_in()){
//  login_error_redirect();
//}
//check if user hs permision to view page
include 'includes/head.php';
include 'includes/navigation.php';
//delete a user
if($_POST){
  $name = ((isset($_POST['full_name']))?sanitize($_POST['full_name']):'');
  $email = ((isset($_POST['email']))?sanitize($_POST['email']):'');
  $password = ((isset($_POST['password']))?sanitize($_POST['password']):'');
  $confirm = ((isset($_POST['confirm']))?sanitize($_POST['confirm']):'');
  $permission = ((isset($_POST['permission']))?sanitize($_POST['permission']):'');
  $errors =array();
  $permissions = '';
  $required = array('full_name', 'email','password', 'confirm');
  $emailQuery = $db->query("SELECT * FROM customer_user WHERE email='$email'");

    foreach($required as $f){
      if(empty($_POST[$f])){
        $errors[]="You must fill all fields.";
        break;
      }
    }


    $emailCount = mysqli_num_rows($emailQuery);
    if($emailCount !=0){
      $errors[] = 'That email already exist with a different user';
    }


    if($password != $confirm){
      $errors[] = 'Your password do not match.';
    }


    if (!is_accept_password($password)){
    $errors[] = ' Password must be atleast 6 characters( and contain at least one digit, one upper case letter, one lower case letter)';
    }

    if(!filter_var($email,FILTER_VALIDATE_EMAIL)){
      $errors[] = 'Your email is not in acceptale format';
    }
    if(!empty($errors)){
      echo display_errors($errors);
    }else{
      //add to database
          $hashed =password_hash($password,PASSWORD_DEFAULT);
          $permissions = 'customer';
        $db->query("INSERT INTO customer_user (full_name,email,password,permissions) values('$name','$email','$hashed','$permission')");
          $_SESSION['success_flash'] .= $name. ' have succesfully registered!';
          header('Location: index.php');
        }
    }
 ?>
<html>
<head>
  <title> Ameritinz Supermart </title>
  <!-- Latest compiled and minified CSS -->
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" >
<!-- Optional theme -->
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" >
<link rel="stylesheet" href="styles.css" >
<!-- Latest compiled and minified JavaScript -->
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
<body>
<div class="container">
     <form class="form-signin" method="POST">
       <h2 class="form-signin-heading">Please Register</h2>
       <div class="input-group">
      <span class="input-group-addon" id="basic-addon1">@</span>
      <input type="text" name="username" class="form-control" placeholder="Username" required>
      <input type="text" name="full_name" class="form-control" placeholder="full_name" required>
       </div>
       <label for="inputEmail" class="sr-only">Email address</label>
       <input type="email" name="email" id="inputEmail" class="form-control" placeholder="Email address" required autofocus>
       <label for="inputPassword" class="sr-only">Password</label>
       <input type="password" name="password" id="inputPassword" class="form-control" placeholder="Password" required>
       <label for="inputPassword" class="sr-only">Confirm Password</label>
       <input type="password" name="confirm" id="inputPassword" class="form-control" placeholder="Confirm" required>
       <button class="btn btn-lg btn-primary btn-block" type="submit">Register</button>
       <a class="btn btn-lg btn-cancel btn-block" href="index.php">Cancel</a>
     </form>
</div>
</body>

</html>


<?php include 'includes/footer.php'; ?>
