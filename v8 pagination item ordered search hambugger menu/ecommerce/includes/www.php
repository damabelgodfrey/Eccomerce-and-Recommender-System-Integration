<!DOCTYPE html>
<html lang="en">
<head>
  <title>Bootstrap Example</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
  <link rel="stylesheet" href="../css/main2.css">
</head>
<body>

  <?php
  require_once '../core/init.php';
  $sql ="SELECT * FROM categories WHERE parent = 0";
  $pquery = $db->query($sql); ?>
<nav class="navbar navbar-inverse">
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
        <div class="nav navbar-nav navbar-right">
          <li><a href="#"><span class="glyphicon glyphicon-user"></span> Sign Up</a></li>
          <li><a href="#"><span class="glyphicon glyphicon-log-in"></span> Login</a></li>
        </div>
    </div>
  </div>
</nav>
<?php

$sql ="SELECT * FROM products WHERE featured = 1";
$featured = $db->query($sql);
 ?>



  <!--main content -->
  <?php include 'slidefrontpage.php'; ?>
<div class="col-md-14" >
  <div class="row">
      <hr><h2 class="text-center">⇩Ameritinz Specials⇩</h2>
      <?php while ($product = mysqli_fetch_assoc($featured)) : ?>
       <div class="col-sm-3 text-center" id = detailLabel>
        <h4><?= $product['title']; ?></h4>
         <?php $photos = explode(',',$product['image']); ?>
         <img onclick="detailsmodal(<?= $product['id']; ?>)" src="<?= $photos[0]; ?>" alt="<?= $product['title']; ?>" class="img-thumb" />
         <p></p><p class="list-price" style="color:grey">Was: <s>₦<?= $product['list_price']; ?></s></p>
         <p class="price">Now: ₦<?= $product['price']; ?></p>
         <button type ="button" class="btn btn-sm btn-danger" onclick="detailsmodal(<?= $product['id']; ?>)">DETAILS</button>
       <hr></div>
     <?php endwhile; ?>
  </div>
</div>

<?php include "footer.php"; ?>
</body>
</html>
