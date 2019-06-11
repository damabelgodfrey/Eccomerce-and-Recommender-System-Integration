<?php
  require_once 'core/init.php';
  include "includes/head.php";
  include "includes/navigation.php";
  //include"includes/headerpartial.php";
  $_SESSION['rdrurl'] = $_SERVER['REQUEST_URI'];
?>
<?php  include '../ecommerce/includes/widgets/filtersnew.php';?>

    <?php include '../ecommerce/includes/slidefrontpage.php'; ?><p></p><p></p>

    <?php include '../ecommerce/includes/browseBycategory.php'; ?><p></p><p></p>

  <div >
    <?php include '../ecommerce/includes/trendingProduct.php'; ?><p></p><p></p>

  </div>
  <?php include '../ecommerce/includes/featured.php'; ?><p></p><p></p>
<?php

include "includes/footer.php";
  ?>
