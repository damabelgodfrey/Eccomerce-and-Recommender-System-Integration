<!--Top Nav bar -->
<?php
$sql ="SELECT * FROM categories WHERE parent = 0";
$pquery = $db->query($sql);
?>
<nav class="navbar navbar-default navbar-fixed-top" id="Nav">
  <div class="container">
  <a href="index.php" class="navbar-brand"> Ameritinz Supermart</a>
    <ul class="nav navbar-nav">
    <?php while($parent = mysqli_fetch_assoc($pquery)): ?>
    <?php
     $parent_id =$parent['id'];
     $sql2 = "SELECT * FROM categories WHERE parent = '$parent_id'";
     $cquery = $db->query($sql2);
     ?>
      <!-- Menu Items -->
      <li class="dropdown">
        <a href="#" class="dropdown-toggle" data-toggle="dropdown"><?php echo $parent['category']; ?><span class="caret"></span></a>
        <ul class="dropdown-menu" role="menu">
          <?php while($child = mysqli_fetch_assoc($cquery)): ?>
          <li><a href="category.php?cat=<?=$child['id'];?>"><?php echo $child['category']; ?></a></li>
        <?php endwhile; ?>
        </ul>
      </li>
    <?php endwhile; ?>
    <li><a href="sales.php"><span class=""></span>SALES</a></li>
    <li><a href="cart.php"><span class="glyphicon glyphicon-shopping-cart"></span>My Cart</a></li>

    <li class ="dropdown">
      <a href="#" class="dropdown-toggle" data-toggle="dropdown"> <?=(isset($customer_data['first'])?'Hello '. $customer_data['first']:'Account');?>
      <span class="caret"></span>
      </a>
      <ul class="dropdown-menu" role ="menu">
    <?php  if(isset($customer_data['first'])){ ?>
        <li><a href="account.php">Manage Account</a></li>
        <li><a href="change_password.php">Change Password</a></li>
        <li><a href="logout.php">Log Out</a></li>
    <?php  }else{ ?>
      <li><a href="login.php">Sign In</a></li>
      <li><a href="register.php">Register</a></li>

    <?php } ?>

      </ul>
    </li>
  </ul>
  </div>
</nav>
