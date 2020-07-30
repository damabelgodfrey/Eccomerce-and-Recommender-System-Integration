<script>
/* Latest compiled and minified JavaScript included as External Resource
$(document).ready(function(){
    $(".dropdown").hover(
        function() {
            $('.dropdown-menu', this).not('.in .dropdown-menu').stop(true,true).slideDown("400");
            $(this).toggleClass('open');
        },
        function() {
            $('.dropdown-menu', this).not('.in .dropdown-menu').stop(true,true).slideUp("400");
            $(this).toggleClass('open');
        }
    );
}); */
function myFunction(x) {
  alert('hh');
  x.classList.toggle("active");
}
</script>
<style>

body {
  font-family: 'Open Sans', 'sans-serif';
}

.navbar-toggle .middlebar {
	  top: 1px;
}

.navbar-toggle .bottombar {
  	top: 2px;
}

.navbar-toggle .icon-bar {
	  position: relative;
	  transition: all 500ms ease-in-out;
}

.navbar-toggle.active .topbar {
	  top: 6px;
	  transform: rotate(45deg);
    background-color: red;
}

.navbar-toggle.active .middlebar {
	  background-color: transparent;
}

.navbar-default .navbar-toggle.active .bottombar {
	  top: -6px;
	  transform: rotate(-45deg);
    background-color: red;
}

.mega-dropdown {
  position: static !important;
}
.mega-dropdown-menu {
    padding: 20px 0px;
    width: 100%;
    box-shadow: none;
    -webkit-box-shadow: none;
}
.mega-dropdown-menu > li > ul {
  padding: 0;
  margin: 0;
}
.mega-dropdown-menu > li > ul > li {
  list-style: none;
}
.mega-dropdown-menu > li > ul > li > a {
  display: block;
  color: #222;
  padding: 3px 5px;
}
.mega-dropdown-menu > li ul > li > a:hover,
.mega-dropdown-menu > li ul > li > a:focus {
  text-decoration: none;
}
.mega-dropdown-menu .dropdown-header {
  font-size: 18px;
  color: #ff3546;
  padding: 5px 60px 5px 5px;
  line-height: 30px;
}

#login-dp{
    min-width: 250px;
    padding: 14px 14px 0;
    overflow:hidden;
    background-color:rgba(255,255,255,.8);
}
#login-dp .help-block{
    font-size:12px
}
#login-dp .bottom{
    background-color:rgba(255,255,255,.8);
    border-top:1px solid #ddd;
    clear:both;
    padding:14px;
}
#login-dp .social-buttons{
    margin:12px 0
}
#login-dp .social-buttons a{
    width: 49%;
}
#login-dp .form-group {
    margin-bottom: 10px;
}
.btn-fb{
    color: #fff;
    background-color:#3b5998;
}
.btn-fb:hover{
    color: #fff;
    background-color:#496ebc
}
.btn-tw{
    color: #fff;
    background-color:#55acee;
}
.btn-tw:hover{
    color: #fff;
    background-color:#59b5fa;
}

.navbar{
  min-height: 80px;
  font-size: 14px;
  background-color: #f9f2ec;
  margin-bottom: 1px;



}
.dropdown-menu{
    background-color:white;
    box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2), 0 6px 20px 0 rgba(0, 0, 0, 0.19);
}
.navbar-nav > li > a {
  /* (80px - line-height of 27px) / 2 = 26.5px */
  padding-top: 26.5px;
  padding-bottom: 26.5px;
  line-height: 27px;
font-size: 16px;
}
.navbar-brand {
  background: url(../ecommerce/images/headerlogo/logo.jpg) center / contain no-repeat;
  width: 120px;
  padding: 0 15px;
  height: 80px;
  line-height: 27px;
}
ul.nav li.sales a {
    background-color: red !important;
    color:white;
    opacity: 0.7;
}
.glyphicon.glyphicon-user{
  font-size: 20px;
  color: green;
}
.glyphicon.glyphicon-user.logoutuser{
  font-size: 20px;
  color: black;
}

/* apply to screen less or equal to that indicated */
@media (max-width: 767px) {
  .navbar-toggle {
  /* (80px - button height 34px) / 2 = 23px */
  margin-top: 23px;
  padding: 10px 10px !important;
  float: right;
  margin-left:5px;
  margin-right: 5px;
  border: none;
	background: transparent !important;
  }
  .navbar-nav>li>a {
      padding-top: 10px;
      padding-bottom: 10px;
  }
  .cart{
    border: none;
    position: absolute;
    right: 35%;
    z-index: 2;
    top: 4px;
  }
	.cart2{
    border: none;
    position: absolute;
    right: 35%;
    z-index: 2;
    top: 8px;
  }
    .wishlogo_pos{
    border: none;
    position: absolute;
    right: 25%;
    z-index: 2;
    top: 8px;
  }
  .account-pos{
    border: none;
    position: absolute;
    right: 15%;
    z-index: 3;
    top: 8px;
  }
.search_pos{
    border: none;
    position: absolute;
    right:50%;
    z-index: 1;
    top: 17px;
    font-size: 25px;
}
.navbar-collapse {
    border-top: 1px solid transparent;
    box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2), 0 6px 20px 0 rgba(0, 0, 0, 0.19);
  }
.navbar.navbar-collapse {
 background-color: #F1EEED;
}
  .navbar-toggle{
    display: block;
  }
	#login-dp{
		background-color: white;
	}
	#login-dp .bottom{
		background-color: inherit;
		border-top:0 none;
	}
}

/* apply to screen greater or equal to that indicated */
@media (min-width: 768px) {
	.navbar-nav .open .dropdown-menu {
    position: absolute;
    float: none;
		z-index: 5;
	}
  .cart{
    border: none;
    position: absolute;
    right: 25%;
    z-index: 2;
    top: -5px;
  }
	.cart2{
		border: none;
		position: absolute;
		right: 25%;
		z-index: 2;
		top: 2px;
	}
  .wishlogo_pos{
    border: none;
    position: absolute;
    right: 15%;
    z-index: 2;
    top: 2px;
  }
  .account-pos{
    border: none;
    position: absolute;
    right: 5%;
    z-index: 3;
    top: 2px;
  }
 .search_pos{
    border: none;
    position: absolute;
    right:35%;
    z-index: 1;
    top: 25px;
    font-size: 25px;
 }
}
</style>

<?php
  if(isset($_SESSION['maintenance_admin_login'])  && $_SESSION['maintenance_admin_login']=='true'){
  }else if(isset($_SESSION['maintenance_admin_login']) && $_SESSION['maintenance_admin_login']=='false'){
    $_SESSION['error_flash'] = 'you do not have the clearance to log in with that credential!';
    //maintainance_redirect();
  }else{
    // maintainance_redirect();
  }
$paid =0;
$unique_item_count =0;
$total_item_count =0;
$cart_exist = 0;
if(isset($user_name)){
$cartQ = $db->query("SELECT * FROM cart WHERE username = '{$user_name}' AND paid = '{$paid}'");
$return = mysqli_num_rows($cartQ);
if($return == 1){
$CartResult = mysqli_fetch_assoc($cartQ);
$items = json_decode($CartResult['items'],true);
$unique_item_count = count($items);
$cart_exist = 1;
/**foreach($items as $item){
  $total_item_count += $item['quantity'];
  }
*/
}
}
$sql ="SELECT * FROM categories WHERE parent = 0 AND active = 1";
$pquery = $db->query($sql); ?>
<?php
if(isset($_POST['droploginsubmit'])){
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
  $query = $db->query("SELECT * FROM customer_user WHERE email = '$email'");
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
    $user_username = $user['username'];
    loginCustomer($user_id,$user_username); //login function is in helpers file
  }
}
 ?>

<div class="bodycontainer-fluid topbar-social-icon navbar navbar-default">
	<h5 class="position-social-icon">
    <div class="rows">
      <div class="col-xs-6">
        Speed, Security and trust
      </div>
        <div class="col-xs-6">
          <div class="footer-icons pull-right" id = "socialHover">
            <?php if(isset($globalsettings['facebook_id']) && $globalsettings['facebook_id']){ ?>
            <a target="_blank" href="https://<?=$globalsettings['facebook_id'];?>" id = "facebook" class="facebook"><i class="fa fa-facebook"></i></a>
          <?php } ?>
          <?php if(isset($globalsettings['twitter_id']) && $globalsettings['twitter_id'] != ''){ ?>
            <a target="_blank" href="https://<?=$globalsettings['twitter_id'];?>" id = "twitter" class="twitter"><i class="fa fa-twitter"></i></a>
          <?php } ?>
            <?php if(isset($globalsettings['instagram_id']) && $globalsettings['instagram_id'] !=''){ ?>
            <a target="_blank" href="https://<?=$globalsettings['instagram_id'];?>" id = "instagram" class="google"><i class="fa fa-instagram"></i></a>
          <?php } ?>
            <?php if(isset($globalsettings['linkedin_id']) && $globalsettings['linkedin_id'] != ''){ ?>
            <a target="_blank" href="https://<?=$globalsettings['linkedin_id'];?>" id = "linkedin" class="linkedin"><i class="fa fa-linkedin"></i></a>
          <?php } ?>
        		<!-- <a href="#" id = "youtube" class="youtube"><i class="fa fa-youtube"></i></a> -->
        	</div>
        </div>

    </div>
</h5>
</div>

<div class="containert navbar-fixed-top head-room">
  <nav class="navbar navbar-default" id="myNavbar">
    <div class="container-fluid">
    <div class="navbar-header">
      <button  id="navbar-toggle"type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
        <span  class="icon-bar topbar"></span>
        <span class="icon-bar middlebar"></span>
        <span class="icon-bar bottombar"></span>
      </button>
    <a id="mybrandlogo" class="navbar-brand" href="index"></a>
	</div>
 <ul class="nav navbar-nav navbar-right account-pos">
 <li class="dropdown">
   <?php  if(isset($user_data['first'])){ ?>
   <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"><i class="glyphicon glyphicon-user userlog" aria-hidden="true"></i><span class="caret_none"></span></a>
   <?php  }else{ ?>
     <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"><i class="glyphicon glyphicon-user logoutuser userlog" aria-hidden="true"></i><span class="caret_none"></span></a>
   <?php } ?>
<ul id="login-dp" class="dropdown-menu">
 <?php  if(isset($user_data['first'])){ ?>
  <li><a href="account">Manage Account</a></li>
  <?php if(check_permission('staff')): ?>
   <li><a href="../ecommerce/admin/index">Login Admin</a></li>
<?php endif; ?>

  <li><a href="change_password">Change Password</a></li>
  <li><a href="logout">Log Out</a></li>
 <?php  }else{ ?>
   <li>
     <?php include '../ecommerce/includes/widgets/login_dropdown.php';?>
   </li>
  <?php } ?>
</ul>
 </li>
</ul>
<ul class="nav navbar-nav navbar-right wishlogo_pos">
   <li><a href="wishlist" ><i  class="navWishicon fa fa-heart fa-lg" aria-hidden="true"></i></a></li>
 </ul>
 <?php if ($cart_exist == 0): ?>
 <ul class="nav navbar-nav navbar-right cart2">
 <li class="dropdown">
		<a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"><i  class="fa fa-shopping-bag fa-lg" aria-hidden="true"></i></a>
	 <?php else: ?>
		<ul class="nav navbar-nav navbar-right cart">
		<li class="dropdown">
		 <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"><i  class="fa fa-shopping-bag fa-lg" aria-hidden="true"></i><span  id="cartCount"><?=$unique_item_count;?></span></a>
	 <?php endif; ?>
<ul  class="dropdown-menu">
 <?php  if(!isset($user_data['first'])){ ?>
   <div class="bg-danger">
     <p class="text-center text-info">
         Login to Add and View Shopping Bag and Saved Item!
     </p>
   </div>
 <?php  }else{ ?>
   <li>
     <?php  include '../ecommerce/includes/widgets/cart.php';?>
   </li>
  <?php } ?>
</ul>
 </li>
</ul>
  <?php  include '../ecommerce/includes/widgets/search.php';?>
  <div class="navbar-collapse collapse">
		<ul class="nav navbar-nav">
			<li class="dropdown mega-dropdown">
				<a href="#" class="dropdown-toggle" data-toggle="dropdown">Men <span class="caret"></span></a>
				<ul class="dropdown-menu mega-dropdown-menu">
          <li class="dropdown-header">TRENDING</li>
  <li class="col-sm-4 col-md-4 "><p></p>
        <ul>
            <?php //include '../ecommerce/includes/slidefrontpage.php'; ?><p></p><p></p>
                <?php //include '../ecommerce/includes/trendingProduct.php'; ?><p></p><p></p>
                     <?php include '../ecommerce/includes/slide.php'; ?>
        </ul>
      </li>
      <?php while($parent = mysqli_fetch_assoc($pquery)): ?>
      <?php
       $parent_id =$parent['id'];
       $sql2 = "SELECT * FROM categories WHERE parent = '$parent_id' AND active = 1";
       $cquery = $db->query($sql2);
       ?>
          <li class="col-sm-2 col-md-2">
        <ul>
          <li class="dropdown-header"><?php echo $parent['category']; ?></li>
          <?php while($child = mysqli_fetch_assoc($cquery)): ?>
             <li> <a class="dropdown-headerlist" href="category?cat=<?=$child['id'];?>"><?php echo $child['category']; ?></a>  <li>
          <?php endwhile; ?>
        </ul>
      </li>
    <?php endwhile;
    ?>
    </ul>
			</li>
            <li class="dropdown mega-dropdown">
    			<a href="#" class="dropdown-toggle" data-toggle="dropdown">Women <span class="caret"></span></a>
				<ul class="dropdown-menu mega-dropdown-menu">
					<li class="col-sm-3">
    					<ul>
							<li class="dropdown-header">Features</li>
							<li><a href="#">Auto Carousel</a></li>
              <li><a href="#">Carousel Control</a></li>
              <li><a href="#">Left & Right Navigation</a></li>
							<li><a href="#">Four Columns Grid</a></li>
							<li class="divider"></li>
							<li class="dropdown-header">Fonts</li>
              <li><a href="#">Glyphicon</a></li>
							<li><a href="#">Google Fonts</a></li>
						</ul>
					</li>
					<li class="col-sm-3">
						<ul>
							<li class="dropdown-header">Plus</li>
							<li><a href="#">Navbar Inverse</a></li>
							<li><a href="#">Pull Right Elements</a></li>
							<li><a href="#">Coloured Headers</a></li>
							<li><a href="#">Primary Buttons & Default</a></li>
						</ul>
					</li>
					<li class="col-sm-3">
						<ul>
							<li class="dropdown-header">Much more</li>
              <li><a href="#">Easy to Customize</a></li>
							<li><a href="#">Calls to action</a></li>
							<li><a href="#">Custom Fonts</a></li>
							<li><a href="#">Slide down on Hover</a></li>
						</ul>
					</li>
              <li class="col-sm-3">
    					<ul>
							<li class="dropdown-header">Women Collection</li>
                            <div id="womenCollection" class="carousel slide" data-ride="carousel">
                              <div class="carousel-inner">
                                <div class="item active">
                                    <a href="#"><img src="http://placehold.it/254x150/3498db/f5f5f5/&text=New+Collection" class="img-responsive" alt="product 1"></a>
                                    <h4><small>Summer dress floral prints</small></h4>
                                    <button class="btn btn-primary" type="button">49,99 €</button> <button href="#" class="btn btn-default" type="button"><span class="glyphicon glyphicon-heart"></span> Add to Wishlist</button>
                                </div><!-- End Item -->
                                <div class="item">
                                    <a href="#"><img src="http://placehold.it/254x150/ff3546/f5f5f5/&text=New+Collection" class="img-responsive" alt="product 2"></a>
                                    <h4><small>Gold sandals with shiny touch</small></h4>
                                    <button class="btn btn-primary" type="button">9,99 €</button> <button href="#" class="btn btn-default" type="button"><span class="glyphicon glyphicon-heart"></span> Add to Wishlist</button>
                                </div><!-- End Item -->
                                <div class="item">
                                    <a href="#"><img src="http://placehold.it/254x150/2ecc71/f5f5f5/&text=New+Collection" class="img-responsive" alt="product 3"></a>
                                    <h4><small>Denin jacket stamped</small></h4>
                                    <button class="btn btn-primary" type="button">49,99 €</button> <button href="#" class="btn btn-default" type="button"><span class="glyphicon glyphicon-heart"></span> Add to Wishlist</button>
                                </div><!-- End Item -->
                              </div><!-- End Carousel Inner -->
                              <!-- Controls -->
                              <a class="left carousel-control" href="#womenCollection" role="button" data-slide="prev">
                                <span class="glyphicon glyphicon-chevron-left" aria-hidden="true"></span>
                                <span class="sr-only">Previous</span>
                              </a>
                              <a class="right carousel-control" href="#womenCollection" role="button" data-slide="next">
                                <span class="glyphicon glyphicon-chevron-right" aria-hidden="true"></span>
                                <span class="sr-only">Next</span>
                              </a>
                            </div><!-- /.carousel -->
                            <li class="divider"></li>
                            <li><a href="#">View all Collection <span class="glyphicon glyphicon-chevron-right pull-right"></span></a></li>
						</ul>
					</li>
				</ul>
			</li>
            <li id="sales" class="sales"><a href="sales">Sales </a></li>
		</ul>
	</div><!-- /.nav-collapse -->
  </nav>
</div>
</div>
  <!--main content -->
<div class="bodycontainer-fluid maincontent">
