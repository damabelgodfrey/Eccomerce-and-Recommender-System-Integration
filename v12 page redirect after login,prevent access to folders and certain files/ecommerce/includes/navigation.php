<div class="nav-top">
  <div class="">
        <p></p><div class="pull-right"><a href="sales" class="btn btn-sm btn-danger">Click here to shop Ameritinz sales up to 50% off now..</a>  </div>
        <p></p><div class="pull-left"><a href="sales" class="btn btn-sm btn-primary">SHOP TRENDING..click here >></a>  </div>
  </div>
</div>

<?php
$sql ="SELECT * FROM categories WHERE parent = 0";
$pquery = $db->query($sql); ?>
<nav class="navbar navbar-default navbar-fixed-top head-room">
<div class="container-fluid">
  <div class="navbar-header">
    <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#myNavbar">
      <span class="icon-bar"></span>
      <span class="icon-bar"></span>
      <span class="icon-bar"></span>
    </button>
    <a class="navbar-brand" id= "brand" href="index">
        <p></p><img alt="AMERITINZ" src="...">
    </a>
  </div>
  <div class="collapse navbar-collapse" id="myNavbar">
    <ul class="nav navbar-nav">
    <!--  <li><a class="fa fa-fw fa-home href="index">Home</a></li> -->
      <?php while($parent = mysqli_fetch_assoc($pquery)): ?>
      <?php
       $parent_id =$parent['id'];
       $sql2 = "SELECT * FROM categories WHERE parent = '$parent_id'";
       $cquery = $db->query($sql2);
       ?>
      <li class="dropdown">
        <a class="dropdown-toggle" data-toggle="dropdown" href="#"><?php echo $parent['category']; ?><span class="caret"></span></a>
        <ul class="dropdown-menu">
          <?php while($child = mysqli_fetch_assoc($cquery)): ?>
            <li><a href="category?cat=<?=$child['id'];?>"><?php echo $child['category']; ?></a></li>
          <?php endwhile; ?>
        </ul>
      </li>
      <?php endwhile; ?>
      <li><a href="sales">SALES</a></li>
      <li><a href="cart"><span class="glyphicon glyphicon-shopping-cart"></span>My Cart</a></li>
    </ul>
    <form class="navbar-form navbar-left" action="search" method="post">
      <div class="form-group">
        <input type="text" class="form-control" placeholder="Search Product.." name="searchProduct">
      </div>
      <button type="submit" class="btn btn-default"><span class="glyphicon glyphicon-search"></span> Search</button>
    </form>
    <ul class="nav navbar-nav navbar-right">
      <li class="dropdown">
        <a class="dropdown-toggle" data-toggle="dropdown" href="#"><?=(isset($user_data['first'])?'Hello '. $user_data['first']:'Account');?><span class="caret"></span></a>
        <ul class="dropdown-menu">
          <?php  if(isset($user_data['first'])){ ?>
           <li><a href="account">Manage Account</a></li>
           <li><a href="change_password">Change Password</a></li>
           <li><a href="logout">Log Out</a></li>
          <?php  }else{ ?>
            <li><a href="register"><span class="glyphicon glyphicon-user"></span> Sign Up</a></li>
            <li><a href="login"><span class="glyphicon glyphicon-log-in"></span> Login</a></li>
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
<div class="container-fluid">
