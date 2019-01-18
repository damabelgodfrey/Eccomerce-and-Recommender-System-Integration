<nav class="navbar navbar-default navbar-fixed-top" id="Nav">
  <div class="container">
    <ul class="nav navbar-nav">
      <!-- Menu Items -->
      <li><a href="index.php">My Dashboard</a></li>
      <li><a href="brands.php">Brands</a></li>
      <li><a href="categories.php">Categories</a></li>
      <li><a href="products.php">Products</a></li>
      <li><a href="archiveproducts.php">ArchiveProducts</a></li>
      <li><a href="slide.php">SlideShow Manager</a></li>
      <?php if(has_admin_permission('admin')): ?>
        <li><a href="users.php">Users</a></li>
      <?php endif; ?>
    <li class ="dropdown">
      <a href="#" class="dropdown-toggle" data-toggle="dropdown"> <?=(isset($user_data['first'])?'Hello '. $user_data['first']:'Account');?>
      <span class="caret"></span>
      </a>
          <ul class="dropdown-menu" role ="menu">
            <?php  if(isset($user_data['first'])){ ?>
              <li><a href="change_password.php">Change Password</a></li>
              <li><a href="logout.php">Log Out</a></li>
            <?php  }else{ ?>
              <li><a href="login.php">Sign In</a></li>
            <?php } ?>
          </ul>
    </li>
  </ul>
        <!-- <li class="dropdown">
        <a href="#" class="dropdown-toggle" data-toggle="dropdown"<span class="caret"></span></a>
        <ul class="dropdown-menu" role="menu">
          <li><a href="#"></a></li>
        </ul>
      </li> -->
  </div>
</nav>
