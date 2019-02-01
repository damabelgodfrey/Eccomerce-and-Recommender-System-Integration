<?php
  $sql ="SELECT * FROM categories WHERE parent = 0";
  $pquery = $db->query($sql);
  ?>
<div class="topnav" id="myTopnav">
  <a href="index.php" class="active">Ameritinz Logo</a>
  <?php while($parent = mysqli_fetch_assoc($pquery)): ?>
  <?php
   $parent_id =$parent['id'];
   $sql2 = "SELECT * FROM categories WHERE parent = '$parent_id'";
   $cquery = $db->query($sql2);
   ?>
      <div class="dropdown">
        <button class="dropbtn"><?php echo $parent['category']; ?>
          <i class="fa fa-caret-down"></i>
        </button>
        <div class="dropdown-content">
           <?php while($child = mysqli_fetch_assoc($cquery)): ?>
              <a href="category.php?cat=<?=$child['id'];?>"><?php echo $child['category']; ?></a>
            <?php endwhile; ?>
        </div>
      </div>
      <?php endwhile; ?>
  <a href="sales.php">Sales</a>
  <a href="cart.php"><span class="glyphicon glyphicon-shopping-cart"></span>My Cart</a>

      <div class="dropdown">
        <button class="dropbtn"><?=(isset($customer_data['first'])?'Hello '. $customer_data['first']:'Account');?>
          <i class="fa fa-caret-down"></i>
        </button>
        <div class="dropdown-content">
           <?php  if(isset($customer_data['first'])){ ?>
            <a href="account.php">Manage Account</a>
            <a href="change_password.php">Change Password</a>
            <a href="logout.php">Log Out</a>
           <?php  }else{ ?>
            <a href="login.php">Sign In</a>
            <a href="register.php">Register</a>
            <?php } ?>
        </div>
      </div>
      <a><div class="search-container">
            <form action="search.php" method="post">
              <input type="text" placeholder="Search Product.." name="searchProduct"><button type="submit">Submit</button>
            </form>
          </div>
        </a>
  <a href="javascript:void(0);" style="font-size:15px;" class="icon" onclick="myFunction()">&#9776;</a>
</div>

<script>
function myFunction() {
    var x = document.getElementById("myTopnav");
    if (x.className === "topnav") {
        x.className += " responsive";
    } else {
        x.className = "topnav";
    }
}
</script>
