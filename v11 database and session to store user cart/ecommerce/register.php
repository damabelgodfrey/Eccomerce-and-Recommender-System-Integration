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
$successflag =0;
$errors = array();
$successes = array();
//delete a user
if(isset($_POST['C_register'])){
  $username = ((isset($_POST['username']))?sanitize($_POST['username']):'');
  $name = ((isset($_POST['full_name']))?sanitize($_POST['full_name']):'');
  $phone = ((isset($_POST['phone']))?sanitize($_POST['phone']):'');
  $email = ((isset($_POST['email']))?sanitize($_POST['email']):'');
  $password = ((isset($_POST['password']))?sanitize($_POST['password']):'');
  $confirm = ((isset($_POST['confirm']))?sanitize($_POST['confirm']):'');
  $permission = ((isset($_POST['permission']))?sanitize($_POST['permission']):'');
  $permissions = '';
  $required = array('username','full_name','phone', 'email','password', 'confirm');
  $emailQuery = $db->query("SELECT * FROM customer_user WHERE email='$email'");

    foreach($required as $f){
      if(empty($_POST[$f])){
        $errors[]="You must fill all fields.";
        break;
      }
    }


    $emailCount = mysqli_num_rows($emailQuery);
    if($emailCount !=0){
      $errors[] = 'That email or username already exist with a different user';
    }
    if (!is_accept_phone_no($phone)){
    $errors[] = 'Phone number must have 11 figures. e.g 08030342243';
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
          $db->query("INSERT INTO customer_user (username,full_name,phone,email,password,permissions) values('$username','$name','$phone','$email','$hashed','$permissions')");
          //$_SESSION['success_flash'] .= $name. ' You can now log in!';
          //header('Location: index.php');
          $counter = $db->query("SELECT * FROM customer_user WHERE email='$email'");
          $confirm = mysqli_num_rows($counter);
          if($confirm == 0){
              $errors[] = 'Error occur while registering you! Try again';
          }
          if(!empty($errors)){
            echo display_errors($errors);
          }else{
          $successflag =1;
          $successes [] = 'Registration successful! Click return to website button';
          $s_display =display_success($successes); ?>
          <script>
            jQuery('document').ready(function(){
              jQuery('#success').html('<?=$s_display; ?>');
            });
          </script>
        <?php
        }
      }
    }
 ?>
  <title> Ameritinz Supermart </title>
<div class="container-fluid col-md-12">
      <?php if($successflag==1){ $successflag = 0;?>
      <div id='success'> </div>
      <a href="index.php" class="btn btn-lg btn-success btn-block form-control"> Return to Website</a>
      <a href="login.php" class="btn btn-lg btn-success btn-block form-control"> Login</a>

    <?php }else{ ?>
      <div id='errors'> </div>
     <form class="form-signin" method="POST">
       <div id="registerLabel">
         <h2  class="text-center form-signin-heading">Sign Up</h2> <p></p>
       </div>
       <div class="input-group">
        <span class="input-group-addon" id="basic-addon1"><i class="" aria-hidden="true">@</i></span>
       <input type="text" maxlength="20" name="username" class="form-control" placeholder="username"
       value="<?php echo isset($_POST["username"]) ? htmlentities($_POST["username"]) : ''; ?>" required autofocus>
     </div>
     <p></p>
       <div class="input-group">
        <span class="input-group-addon" id="basic-addon1"><i class="glyphicon glyphicon-user" aria-hidden="true"></i></span>
       <input type="text" name="full_name" class="form-control" placeholder="full_name"
       value="<?php echo isset($_POST["full_name"]) ? htmlentities($_POST["full_name"]) : ''; ?>">
     </div>
     <p></p>
     <div class="input-group">
        <span class="input-group-addon" id="basic-addon1"><i class=" glyphicon glyphicon-phone" aria-hidden="true"></i></span>
        <input type="number" name="phone" id="phone" class="form-control"
         value="<?php echo isset($_POST["phone"]) ? htmlentities($_POST["phone"]) : ''; ?>" placeholder="e.g 08030342243" required>
     </div><p></p>
     <div class="input-group">
        <span class="input-group-addon" id="basic-addon1"><i class="fa fa-envelope-open" aria-hidden="true"></i></span>
       <input type="email" name="email" id="inputEmail" class="form-control" placeholder="Email address"
        value="<?php echo isset($_POST["email"]) ? htmlentities($_POST["email"]) : ''; ?>"required>
     </div>
     <p></p>
      <div class="input-group">
        <span class="input-group-addon" id="basic-addon1"><i class="glyphicon glyphicon-lock" aria-hidden="true"></i></span>
        <input type="password" name="password" id="inputPassword" class="form-control" placeholder="Password" required>
     </div><p></p>
     <div class="input-group">
       <span class="input-group-addon" id="basic-addon1"><i class="glyphicon glyphicon-lock" aria-hidden="true"></i></span>
       <input type="password" name="confirm" id="inputPassword" class="form-control" placeholder="confirm" required>
    </div><p></p>
       <button class="btn btn-lg btn-primary btn-block" name="C_register" type="submit">Register</button>
       <a class="btn btn-lg btn-cancel btn-block" href="index.php">Cancel</a>
     <?php } ?>
     </form>
</div>
<?php include 'includes/footer.php'; ?>
