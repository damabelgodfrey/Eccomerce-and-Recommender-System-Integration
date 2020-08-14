<style>
body {background-color: #2a2b3d}
.navbar-default {
    background-color: #6f6486 !important;
    border: none !important;
    border-radius: 0 !important;
    margin: 0 !important
	}
  .navbar-default .navbar-nav>li>a {
    color: #ffffff;
    line-height: 65px !important;
    padding: 0 10px !important;
  }
  .box {
    background-color: #404361;
    padding: 15px;
    overflow: hidden;
    color: #ffffff;
  }
  .table th{
    text-align:center;
    box-shadow: 7px 7px 15px rgba(0, 0, 0, 0.6);
    font-size: 16px;
    background-color: #2a2b3d;
    color: white;
  }
  .table{
    font-size: 14px;
    background-color: #c5c8e6;
    color: black;
  }
  .navbar-default .navbar-nav>li>a:focus, .navbar-default .navbar-nav>li>a:hover {
    color: white;
    font-size: 15px;
    text-decoration: underline;
  }
  .main-color {
      color: #ffc107;
  }
.navbar-default .navbar-brand {
  color: white;
  font-size: 22px;
}
  @media (max-width: 767px){
.navbar-default .navbar-nav .open .dropdown-menu>li>a {
    color: #f9f7f7;
  }
  .navbar-default .navbar-nav .open .dropdown-menu>li>a:focus, .navbar-default .navbar-nav .open .dropdown-menu>li>a:hover {
    color: white;
    font-size: 15px;
    text-decoration: underline;
  }
  .navbar-nav .open .dropdown-menu {
    background-color:#404361;
  }
  .navbar-collapse{
    background-color:#2a2b3d;
  }
  .navbar-fixed-bottom .navbar-collapse, .navbar-fixed-top {
    max-height: 50px;
  }
  .navbar-fixed-bottom .navbar-collapse, .navbar-fixed-top .navbar-collapse {;
    max-width: 350px;
    box-shadow: 4px 7px 10px grey;
    /* for many li items remove this bellow to give a scrol*/
    max-height: 100%;
  }
}
</style>
<?php
if(isset($_SESSION['total_item_ordered'])){
  $total_message= $_SESSION['total_item_ordered'];
}else{
  $total_item ='';
}
$status = 'unread';
$msgQ = $db->query("SELECT * FROM contact WHERE status = '{$status}'");
$return = mysqli_num_rows($msgQ);
?>

<?php if(!check_staff_permission('staff')){ ?>
  <div class="bg-danger">
    <p class="text-center text-warning">
      <h2>Your credential is yet to be verified. Please log in below!</h2>
    </p>
  </div>
  <p></p><div class=""><a href="login" class="btn btn-lg btn-primary"><strong>Login>></strong></a>  </div>

<?php exit; } ?>
<div class="nav-top">
  <div class="">
        <p></p><div class="pull-left"><a href="#" class="btn btn-sm btn-danger">ORIGINALITY IS OUR SIGNATURE..</a>  </div>
        <p></p><div class="pull-right"><a href="../../ecommerce/index" class="btn btn-sm btn-primary"><strong>VISIT WEBSITE >></strong></a>  </div>
  </div>
</div>
<nav class="navbar navbar-default navbar-fixed-top head-room">
<div class="container-fluid">
  <div class="navbar-header">
    <button type="button" class="navbar-toggle active" data-toggle="collapse" data-target="#myNavbar">
      <span class="icon-bar"></span>
      <span class="icon-bar"></span>
      <span class="icon-bar"></span>
    </button>
    <a class="navbar-brand" href="index">my<span class="main-color">Dashboard</span></a>

    <ul class="nav navbar-nav navbar-left contact_msg">
<li>
        <?php if($return == 0) {?>
          <a href="receivedmessage"><i  class="glyphicon glyphicon glyphicon-envelope" aria-hidden="true"></i></a>
      <?php }else{ ?>
        <a href="receivedmessage" ><i  class="glyphicon glyphicon glyphicon-envelope" aria-hidden="true"></i><span  id="msgCount"><?=$return;?></span></a>
      <?php } ?>
</li>

    </ul>
  </div>
  <div class="collapse navbar-collapse" id="myNavbar">
    <ul class="nav navbar-nav">
      <?php if(check_staff_permission('admin')): ?>
      <li class="dropdown">
        <a class="dropdown-toggle" data-toggle="dropdown" href="#">My Dashboard<span class="caret"></span></a>
        <ul class="dropdown-menu">
            <li><a href="orderedItem">Order To Ship</a></li>
            <li><a href="inventory">Inventory</a></li>
            <li><a href="storeTransactions">View Transactions</a></li>
            <li><a href="exploresales">Explore Sales</a></li>
        </ul>
      </li>
    <?php endif; ?>
      <?php if(check_staff_permission('admin')): ?>
        <li class="dropdown">
          <a class="dropdown-toggle" data-toggle="dropdown" href="#">My Admin<span class="caret"></span></a>
          <ul class="dropdown-menu">
            <li><a href="staff_account">Staff Account</a></li>
            <li><a href="customer_account">Customers</a></li>
            <li><a href="permissions">Permissions</a></li>
            <li><a href="staff_rank">Staff Rank</a></li>
            <li><a href="refresh_page">Return Product</a></li>
          </ul>
        </li>
      <?php endif; ?>
      <li class="dropdown">
        <a class="dropdown-toggle" data-toggle="dropdown" href="#">Product Manager<span class="caret"></span></a>
        <ul class="dropdown-menu">
          <li><a href="brands">Brands Manager</a></li>
          <li><a href="categories">Categories Manager</a></li>
          <li><a href="archiveproducts">Archive Products</a></li>
          <li><a href="slide">SlideShow Manager</a></li>
          <li><a href="announcement">Announcent Manager</a></li>
        </ul>
      </li>
      <li><a href="products">Products</a></li>
    </ul>
    <ul class="nav navbar-nav navbar-right">
      <li class="dropdown">
        <a class="dropdown-toggle" data-toggle="dropdown" href="#"><?=(isset($staff_data['first'])?'Hello '. $staff_data['first']:'Account');?><span class="caret"></span></a>
        <ul class="dropdown-menu">
          <?php  if(isset($staff_data['first'])){ ?>
            <li><a href="change_password">Change Password</a></li>
            <li><a href="logout">Log Out</a></li>
          <?php  }else{ ?>
            <li><a href="login">Sign In</a></li>
          </ul>
          <?php } ?>
        </ul>
      </li>
    </ul>
  </div>
</div>
</nav>
<div class="body-top">
  <p></p>
</div>
<script>
jQuery(window).scroll(function(){
  if($(this).scrollTop()> 0){
    $('.navbar-fixed-top').removeClass('head-room');
  }else{
    $('.navbar-fixed-top').addClass('head-room');
  }});
</script>
