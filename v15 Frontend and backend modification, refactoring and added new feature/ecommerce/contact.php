<style>
@import url(https://fonts.googleapis.com/css?family=Open+Sans:400italic,400,300,600);

* {
	margin:0;
	padding:0;
	box-sizing:border-box;
	-webkit-box-sizing:border-box;
	-moz-box-sizing:border-box;
	-webkit-font-smoothing:antialiased;
	-moz-font-smoothing:antialiased;
	-o-font-smoothing:antialiased;
	font-smoothing:antialiased;
	text-rendering:optimizeLegibility;
}

body {
	font-family:"Open Sans", Helvetica, Arial, sans-serif;
	font-weight:300;
	font-size: 12px;
	line-height:30px;
	color:#777;
	background:#0CF;
}

.contactcontainer {
	max-width:500px;
	width:100%;
	margin:0 auto;
	position:relative;
}

#contact input[type="text"], #contact input[type="email"], #contact input[type="tel"], #contact input[type="url"], #contact textarea, #contact button[type="submit"] { font:400 12px/16px "Open Sans", Helvetica, Arial, sans-serif; }

#contact {
	background:#F9F9F9;
	padding:25px;
	margin:50px 0;
}

#contact h3 {
	color: #F96;
	display: block;
	font-size: 30px;
	font-weight: 400;
}

#contact h4 {
	margin:5px 0 15px;
	display:block;
	font-size:13px;
}

fieldset {
	border: medium none !important;
	margin: 0 0 10px;
	min-width: 100%;
	padding: 0;
	width: 100%;
}

#contact input[type="text"], #contact input[type="email"], #contact input[type="tel"], #contact input[type="url"], #contact textarea {
	width:100%;
	border:1px solid #CCC;
	background:#FFF;
	margin:0 0 5px;
	padding:10px;
}

#contact input[type="text"]:hover, #contact input[type="email"]:hover, #contact input[type="tel"]:hover, #contact input[type="url"]:hover, #contact textarea:hover {
	-webkit-transition:border-color 0.3s ease-in-out;
	-moz-transition:border-color 0.3s ease-in-out;
	transition:border-color 0.3s ease-in-out;
	border:1px solid #AAA;
}

#contact textarea {
	height:100px;
	max-width:100%;
  resize:none;
}

#contact button[type="submit"] {
	cursor:pointer;
	width:100%;
	border:none;
	background:#0CF;
	color:#FFF;
	margin:0 0 5px;
	padding:10px;
	font-size:15px;
}

#contact button[type="submit"]:hover {
	background:#09C;
	-webkit-transition:background 0.3s ease-in-out;
	-moz-transition:background 0.3s ease-in-out;
	transition:background-color 0.3s ease-in-out;
}

#contact button[type="submit"]:active { box-shadow:inset 0 1px 3px rgba(0, 0, 0, 0.5); }

#contact input:focus, #contact textarea:focus {
	outline:0;
	border:1px solid #999;
}
::-webkit-input-placeholder {
 color:#888;
}
:-moz-placeholder {
 color:#888;
}
::-moz-placeholder {
 color:#888;
}
:-ms-input-placeholder {
 color:#888;
}

.error {
    color: red;
}
</style>
<?php
require_once $_SERVER['DOCUMENT_ROOT'].'/ecommerce/core/init.php';
include 'includes/head.php';
include 'includes/navigation.php';
$successflag =0;
$errors = array();
$successes = array();
$name_error = $email_error = $phone_error = $url_error = "";
$name = $email = $phone = $message = $url = $success = "";
if(isset($_SESSION['rdrurl'])){
  $link= $_SESSION['rdrurl'];
}else{
  $link = '/ecommerce/index';
}

function test_input($data) {
  $data = trim($data);
  $data = stripslashes($data);
  $data = htmlspecialchars($data);
  return $data;
}

if(isset($_POST['contact_submit'])){
  if (isset($_SESSION['contactid'])){
        if(empty($_POST["name"])) {
        $name_error = "Name is required";
        }else{
        $name = test_input($_POST["name"]);
        // check if name only contains letters and whitespace
        if (!preg_match("/^[a-zA-Z ]*$/",$name)) {
        $name_error = "Only letters and white space allowed";
        }
        }
        if(empty($_POST["email"])) {
        $email_error = "Email is required";
        }else{
        $email = test_input($_POST["email"]);
        // check if e-mail address is well-formed
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $email_error = "Invalid email format";
        }
        }
        if (empty($_POST["phone"])) {
        $phone_error = "Phone is required";
        }else{
        $phone = test_input($_POST["phone"]);
        // check if e-mail address is well-formed
        if (!preg_match("/^(\d[\s-]?)?[\(\[\s-]{0,2}?\d{3}[\)\]\s-]{0,2}?\d{3}[\s-]?\d{4}$/i",$phone)){
            $phone_error = "Invalid phone number";
        }
        }
        if (empty($_POST["url"])) {
        $url_error = "";
        } else {
        $url = test_input($_POST["url"]);
        // check if URL address syntax is valid (this regular expression also allows dashes in the URL)
        if(!preg_match("/\b(?:(?:https?|ftp):\/\/|www\.)[-a-z0-9+&@#\/%?=~_|!:,.;]*[-a-z0-9+&@#\/%=~_|]/i",$url)) {
            $url_error = "Invalid URL";
        }
        }
        $subject = ((isset($_POST['subject']))?sanitize($_POST['subject']):'');
        $message = ((isset($_POST['message']))?sanitize($_POST['message']):'');

    if ($name_error == '' and $email_error == '' and $phone_error == '' and $url_error == ''){
      if(!empty($errors)){
          echo display_errors($errors);
      }else{
          $message_body = '';
          unset($_POST['contact_submit']);
          foreach ($_POST as $key => $value) {
                  $message_body .= "$key: $value\n";
          }
					$msg_date = date("Y-m-d H:i:s"); //this is the date format of database
					$db->query("INSERT INTO contact (name,email,phone,url,subject,message,msg_date) values('$name','$email','$phone','$url','$subject','$message','$msg_date')");
					//$_SESSION['success_flash'] .= $name. ' You can now log in!';
					//header('Location: index.php');
					$counter = $db->query("SELECT * FROM contact WHERE email='$email' AND message ='$message' AND subject = '$subject' ");
					$confirm = mysqli_num_rows($counter);
					if($confirm == 0){
							$errors[] = 'Error occur while receiving your contact message! Try again';
							echo display_errors($errors);
					}
        $db->close();
				unset($_SESSION['contactid']);
        $successflag =1;
        $successes [] = 'message sent successful! Click return to website button';
        $s_display =display_success($successes);?>
        <script>
            jQuery('document').ready(function(){
            jQuery('#success').html('<?=$s_display; ?>');
            });
        </script>
        <div id="success">
        </div>
        <div class="alert alert-success" role="alert">
        <h2>Thank you!</h2> Your message has been sent to our office and we will reply as soon as possible.
        </div>
        <?php
        }
   }
  }else{ ?>
      <div class="alert alert-success" role="alert">
          <h2>Thank you!</h2> Your message has already been sent and we will reply as soon as possible.
      </div>
<?php }
}
?>
<div class="contactcontainer">
  <form id="contact" action="contact" method="post">
    <h3>Quick Contact</h3>
    <h4>Contact us today, and get reply with in 24 hours!</h4>
    <fieldset>
      <input placeholder="Your name" type="text" name="name" value="<?= $name ?>" tabindex="1" autofocus>
      <span class="error"><?= $name_error ?></span>
    </fieldset>
    <fieldset>
      <input placeholder="Your Email Address" type="text" name="email" value="<?= $email ?>" tabindex="2">
      <span class="error"><?= $email_error ?></span>
    </fieldset>
    <fieldset>
      <input placeholder="Your Phone Number" type="text" name="phone" value="<?= $phone ?>" tabindex="3">
      <span class="error"><?= $phone_error ?></span>
    </fieldset>
    <fieldset>
      <input placeholder="Your Web Site starts with http://" type="text" name="url" value="<?= $url ?>" tabindex="4" >
      <span class="error"><?= $url_error ?></span>
    </fieldset>
    <fieldset>
      <label for="subject">
      <span>Subject: </span></label>
      <select id="subject" name="subject" tabindex="4">
         <option value="Product Price Question">Product Price Question</option>
         <option value="Delivery Information">Delivery Information</option>
         <option value="Customer Service and Complaint">Customer Service and Complaint</option>
      </select>
    </fieldset>
    <fieldset>
      <textarea value="<?= $message ?>" name="message" tabindex="5">
      </textarea>
    </fieldset>
      <?php
      $contactid = md5(rand(0,10000000));
      $_SESSION["contactid"] = $contactid;?>
    <button name="contact_submit" type="submit" id="contact-submit" data-submit="...Sending">Submit</button>
  </form>
</div>
<?php
include 'includes/footer.php';
?>
