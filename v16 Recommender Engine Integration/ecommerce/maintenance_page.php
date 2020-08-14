<!-- Latest compiled and minified CSS -->
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
<link href="https://fonts.googleapis.com/css?family=Raleway" rel="stylesheet">

<style>
html,body{height:100%;}
h2{text-transform:uppercase;font-family:'Raleway', sans-serif !important; margin:0 0 30px 0 !important; color:#fff !important}

#cover{background:url(https://source.unsplash.com/KZHhnb6XsQI) no-repeat top center;background-size:cover;height:100%;text-align:center;color:white;display:flex;align-items:center; }
#cover::before{content:"";width:100%;height:100%;position:absolute;top:0;left:0;background-color:rgba(0,0,0,.85);}
#cover-caption{width:100%;}
#cover-caption img{margin:30px 0 0 0;}
.subscribeBx{width:500px;margin:auto;position:relative;}
.subscribeBx form{margin:20px 0 25px 0 !important;}
.subscribeBx .form-control{background-color:rgba(255,255,255,0.05);border:none;border-radius:0;color:#fff;border-bottom:1px solid #fff;padding:20px 10px;font-size: 16px;}
.subscribeBx .btn-submit .form-control {background-color: #f0ad4e;border:none;border-radius:0;color:#fff;border-bottom:1px solid #fff;padding:20px 10px;font-size: 16px;}
.subscribeBx .icon1{width:50px;height:50px;position:absolute;right:7px;top:10px;color:rgba(255,255,255,0.2);background-color:transparent;border:none;}
.subscribeBx i{font-size:20px;}
.socialMedia{width:350px;margin:15px auto;}
.socialMedia i{font-size:15px;margin:0 20px 0 0;}
ul.socialicons{list-style:none;margin:0;}
ul.socialicons li{display:inline-block;margin:0 0 0 0;padding:0 0 0 0;}
ul.socialicons li a{color:#fff;text-decoration:none;}
.subscribeBx .icon2 {
width: 50px;
height: 50px;
position: absolute;
right: 7px;
top: 50px;
color: rgba(255,255,255,0.2);
background-color: transparent;
border: none;
font-size: 26;
}

h2 span {
  font: "Oswald", sans-serif;
  letter-spacing: 0;
  padding: .25em 0 .325em;
  display: block;
  margin: 0 auto;
  text-shadow: 0 0 80px rgba(255, 255, 255, 0.5);
  /* Clip Background Image */
  background: url(https://files.fromsmash.com/ca387c86-299b-11e7-81a7-0afbd0dc3e17/roll_1493113479_optimized.jpg) repeat-y;
  -webkit-background-clip: text;
  /* Animate Background Image */
  -webkit-text-fill-color: transparent;
  -webkit-animation: aitf 80s linear infinite;
  /* Activate hardware acceleration for smoother animations */
  -webkit-transform: translate3d(0, 0, 0);
  -webkit-backface-visibility: hidden;
}

/* Animate Background Image */
@-webkit-keyframes aitf {
  0% {
    background-position: 0% 50%;
  }
  100% {
    background-position: 100% 50%;
  }
}

@media (max-width:9800px){
  #cover::before{display:none;}
  .col-clr{background: rgba(0,0,0,0.55);
    padding: 40px 0;}
}
</style>
<?php
require_once $_SERVER['DOCUMENT_ROOT'].'/ecommerce/core/init.php';
$email = ((isset($_POST['email']))?sanitize($_POST['email']):'');
$email =trim($email);
$password = ((isset($_POST['password']))?sanitize($_POST['password']):'');
$password = trim($password);
$errors =array();
if(isset($_POST['email'])){
  //form validatio
  if(empty($_POST['email']) || empty($_POST['email'])){
    $errors[] = 'You must provide email and password.';
  }elseif(!filter_var($email,FILTER_VALIDATE_EMAIL)){
    $errors[] = 'You must enter a valid email';
  }else{
  //check if email exist in the Database
  $query = $db->query("SELECT * FROM customer_user WHERE email = '$email'");
  $user = mysqli_fetch_assoc($query);
  $userCount = mysqli_num_rows($query);
    if($userCount == 0){
      $errors[] = 'The email or password provided does not march our record.';
    }elseif(!password_verify($password,$user['password'])){
      $errors[] = 'The email or password provided does not march our record.';
    }else{
      $user_permit = $user['permissions'];
      $user_id = $user['id'];
      $user_username = $user['username'];
      loginstaff($user_id,$user_username,$user_permit);
    }
  }
  }
 ?>

<body>

<section id="cover">
  <div id="cover-caption">
    <div class="container">
      <div class="row">
        <div class="col-md-12">
          <div class="col-clr">
            <h2>We will take off soon..</h2>
          <h5>Our Website Is Coming Soon. We`ll be here soon with our new Imagination.</h5>
          <p>Subscribe to be notified.</p>
          <div class="subscribeBx">
              <form action="maintenance_page.php" method="post">
                <input type="email" name="email" id="email" class="form-control" value="<?=$email;?>" placeholder="Enter Emails" required>
                <input type="password" name="password" id="password" class="form-control" value="<?=$password;?>" placeholder="Enter Password" required>
                <?php if(empty($_errors)){ ?>
                <div class="">
                  <?php
                  echo display_errors($errors);
                   ?>
                </div>
                <?php } ?>
                <div class="btn-submit">
                  <input type="submit" value="Login" class="btn btn-md form-control btn-submit">
                </div>
                <br>

              <i class="icon1 fa fa-envelope-o"></i>
              <i class=" icon2 fa fa-lock"></i>

            </form>
          </div>
          <div class="socialMedia">
            <ul class="socialicons">
              <li><a href="#"><i class="fa fa-facebook"></i></a></li>
              <li><a href="#"><i class="fa fa-twitter"></i></a></li>
              <li><a href="#"><i class="fa fa-google-plus"></i></a></li>
            </ul>
          </div>
        </div>
        </div>
      </div>
    </div>
  </div>
</section>

</body>

<!-- jQuery library -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.0/jquery.min.js"></script>

<!-- Latest compiled JavaScript -->
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
