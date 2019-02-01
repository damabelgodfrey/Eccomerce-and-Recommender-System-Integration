<div class="nav-top">
  <div class="">
        <p></p><div class="pull-left"><a href="#" class="btn btn-sm btn-danger">ORIGINALITY IS OUR SIGNATURE..</a>  </div>
        <p></p><div class="pull-right"><a href="../../ecommerce/index.php" class="btn btn-sm btn-primary"><strong>VISIT WEBSITE >></strong></a>  </div>
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
    <a id= "brand" class="navbar-brand" href="index.php">Ameritinz</a>
  </div>
  <div class="collapse navbar-collapse" id="myNavbar">
    <ul class="nav navbar-nav">
      <li><a href="index.php">Home</a></li>
      <li class="dropdown">
        <a class="dropdown-toggle" data-toggle="dropdown" href="#">My Dashboard<span class="caret"></span></a>
        <ul class="dropdown-menu">
            <li><a href="orderedItem.php">Order To Ship</a></li>
            <li><a href="inventory.php">Inventory</a></li>
            <li><a href="storeTransactions.php">View Transactions</a></li>
            <li><a href="exploresales.php">Explore Sales</a></li>
        </ul>
      </li>

      <li><a href="brands.php">Brands</a></li>
      <li><a href="categories.php">Categories</a></li>
      <li><a href="products.php">Products</a></li>
      <li><a href="archiveproducts.php">ArchiveProducts</a></li>
      <li><a href="slide.php">SlideShow Manager</a></li>
      <?php if(check_staff_permission('admin')): ?>
        <li><a href="users.php">Users</a></li>
      <?php endif; ?>
    </ul>
    <ul class="nav navbar-nav navbar-right">
      <li class="dropdown">
        <a class="dropdown-toggle" data-toggle="dropdown" href="#"><?=(isset($user_data['first'])?'Hello '. $user_data['first']:'Account');?><span class="caret"></span></a>
        <ul class="dropdown-menu">
          <?php  if(isset($user_data['first'])){ ?>
            <li><a href="change_password.php">Change Password</a></li>
            <li><a href="logout.php">Log Out</a></li>
          <?php  }else{ ?>
            <li><a href="login.php">Sign In</a></li>
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
