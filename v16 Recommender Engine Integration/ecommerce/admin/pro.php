<style>
#msgCount {
font-size: 10px;
background: red;
color: #fff;
padding: 0 5px;
vertical-align: super;
border-radius: 50%;
behavior: url(PIE.htc);
border: 1px solid #fff;
}

#message-drop{
    background-color: lightgrey;
    box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2), 0 6px 20px 0 rgba(0, 0, 0, 0.19);

}

$errors = 'The parent category ['. $category['category'].'] of that child category is inactive. Activate parent category ['.$category['category'].'] first!';
$display =display_errors($errors); ?>
<!--Display error on screen by using jquery to plug in the html-->
<script>
  jQuery('document').ready(function(){
    jQuery('#errors2').html('<?=$display; ?>');
  });
</script>
<?php
@media (min-width: 768px) {
  .msg{
    border: none;
    position: absolute;
    right: 25%;
    z-index: 2;
    top: 0px;
  }
  #message-drop{
      width: 500px;

  }
  }
  @media (max-width: 768px) {
    .navbar-toggle {

    }
    .navbar-nav>li>a {
    }
    .msg{
      border: none;
      position: absolute;
      right: 35%;
      z-index: 2;
      top: 0px;
    }
  }
</style>
<script>
jQuery(window).scroll(function(){
  if($(this).scrollTop()> 0){
    $('.navbar-fixed-top').removeClass('head-room');
  }else{
    $('.navbar-fixed-top').addClass('head-room');
  }});
</script>
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
    <a id= "brand" class="navbar-brand" href="index">Ameritinz</a>
    <ul class="nav navbar-nav navbar-right msg">
    <li class="dropdown">
      <?php if($return == 0) {?>
      <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"><i  class="glyphicon glyphicon glyphicon-envelope" aria-hidden="true"></i></a>
    <?php }else{ ?>
      <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"><i  class="glyphicon glyphicon glyphicon-envelope" aria-hidden="true"></i><span  id="msgCount"><?=$return;?></span></a>
    <?php } ?>
   <ul  class="dropdown-menu" id="message-drop">
    <?php  if($return < 1){ ?>
      <div class="bg-danger">
        <p class="text-center text-info">
            No new message received!
        </p>
      </div>
    <?php  }else{ ?>
      <li>
        <?php
          $msgQuery =   "SELECT * FROM contact WHERE status = 'unread' ORDER BY msg_date" ;
          $msgResults = $db->query($msgQuery);
         $return = mysqli_num_rows($msgResults);
         $msgQuery =   "SELECT * FROM contact WHERE status = 'unread' ORDER BY msg_date LIMIT 4" ;
         $msgResults = $db->query($msgQuery);
        ?>
        <div class="col-md-12">
          <h3 class="text-center">Incoming Messages</h3>
          <a href ="receivedmessage" class="btn btn-block btn-primary ">Goto Inbox</a>

          <table class="table table-condesed table-bordered table-striped table-hover">
            <thead>
              <th>info</th><th>subject</th>
            </thead>
            <tbody>
              <?php while ($msg = mysqli_fetch_assoc($msgResults)): ?>
              <tr>
                <td><?=$msg['name'];?><br><?=$msg['email'];?><br><?=$msg['msg_date'];?></td>
                <td><?=$msg['subject'];?><br>
                <a href="message?msg_id=<?=$msg['id'];?>" class="btn btn-xs btn-info">View Details</a>
                </td>
              </tr>
            <?php endwhile; ?>
          </tbody>
        </table>
        <?php if($return > 4) {
          $remainder = $return - 4;?>
          <a href ="receivedmessage" class="btn btn-block btn-primary "><?= $remainder; ?> more unread message(s) in inbox</a>

        <?php } ?>
        </div>
      </li>
     <?php } ?>
   </ul>
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
