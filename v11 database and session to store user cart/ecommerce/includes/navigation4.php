<!DOCTYPE html>
<html lang="en">
<head>
  <title>Bootstrap Example</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
</head>
<style media="screen">
body {margin:0;font-family:Arial
}

div.polaroid {
  background-color: white;
  box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2), 0 6px 20px 0 rgba(0, 0, 0, 0.19);
  margin-bottom: 40px;
  padding: 5px 0px;
}

div.container {
  text-align: center;
  padding: 10px 20px;
}
.padding-0{
    padding-right:8px;
    padding-left:8px;
}
.navbar {

  background-color: red;
  font: bold 16px sans-serif;
  font: white;
  color: white;
  position: fixed;
  top: 0;
  width: 100%;

}

#myNavbar a{
  color: white;
}
#myNavbar a:hover{
  background-color: darkblue;
}
.dropdown-menu {
    background-color: red;
    font: bold 16px sans-serif;
}


</style>
<body>

  <?php
  require_once '../core/init.php';
  $sql ="SELECT * FROM categories WHERE parent = 0";
  $pquery = $db->query($sql); ?>
<nav class="navbar navbar-default">
  <div class="container-fluid">
    <div class="navbar-header">
      <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#myNavbar">
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
      </button>
      <a id= "brand" class="navbar-brand" href="index.php">Ameritinz</a>
    </div>
    <div class="collapse navbar-collapse" id="myNavbar">
      <ul class="nav navbar-nav">
        <li><a href="index.php">Home</a></li>
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
              <li><a href="category.php?cat=<?=$child['id'];?>"><?php echo $child['category']; ?></a></li>
            <?php endwhile; ?>
          </ul>
        </li>
        <?php endwhile; ?>
        <li><a href="sales.php"><span class=""></span>SALES</a></li>
        <li><a href="cart.php"><span class="glyphicon glyphicon-shopping-cart"></span>My Cart</a></li>
      </ul>
      <form class="navbar-form navbar-left" action="search.php">
        <div class="form-group">
          <input type="text" class="form-control" placeholder="Search">
        </div>
        <button type="submit" class="btn btn-default">Submit</button>
      </form>
      <ul class="nav navbar-nav navbar-right">
        <li class="dropdown">
          <a class="dropdown-toggle" data-toggle="dropdown" href="#"><?=(isset($customer_data['first'])?'Hello '. $customer_data['first']:'Account');?><span class="caret"></span></a>
          <ul class="dropdown-menu">
            <?php  if(isset($customer_data['first'])){ ?>
             <li><a href="account.php">Manage Account</a></li>
             <li><a href="change_password.php">Change Password</a></li>
             <li><a href="logout.php">Log Out</a></li>
            <?php  }else{ ?>
              <li><a href="#"><span class="glyphicon glyphicon-user"></span> Sign Up</a></li>
              <li><a href="#"><span class="glyphicon glyphicon-log-in"></span> Login</a></li>
             <?php } ?>
          </ul>
        </li>

      </ul>
    </div>
  </div>
</nav>
<?php

$sql ="SELECT * FROM products WHERE featured = 1";
$featured = $db->query($sql);
 ?>



  <!--main content -->
  <div class ="main">
    <?php include 'slidefrontpage.php'; ?>
  <div class="col-md-14" >
    <div class="row">
        <hr><h2 class="text-center">⇩Ameritinz Specials⇩</h2>
        <?php while ($product = mysqli_fetch_assoc($featured)) : ?>
         <div class="col-sm-3 text-center" id = detailLabel>
           <div class="polaroid">
             <?php $photos = explode(',',$product['image']); ?>
             <h4><?= $product['title']; ?></h4>
            <img onclick="detailsmodal(<?= $product['id']; ?>)" src="<?= $photos[0]; ?>" alt="<?= $product['title']; ?>" class="img-thumb" style="width:100%"/>
            <p class="list-price" style="color:grey">Was: <s>₦<?= $product['list_price']; ?></s></p>
            <p class="price">Now: ₦<?= $product['price']; ?></p>
            <button type ="button" class="btn btn-sm btn-danger" onclick="detailsmodal(<?= $product['id']; ?>)">DETAILS</button>
         </div>
         </div>
       <?php endwhile; ?>
    </div>
  </div>

  <?php include "footer.php"; ?>
</div>
</body>
</html>
