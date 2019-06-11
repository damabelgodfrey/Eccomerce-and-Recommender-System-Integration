<?php
  require_once 'core/init.php';
  include "includes/head.php";
  include "includes/navigation.php";
  //include"includes/headerpartial.php";
  $_SESSION['rdrurl'] = $_SERVER['REQUEST_URI'];

?>
<?php  include '../ecommerce/includes/widgets/filtersnew.php';?>

    <?php include '../ecommerce/includes/slidefrontpage.php'; ?><p></p><p></p>

  <div class="col-md-3" ><p></p><p></p>
    <?php// include '../ecommerce/includes/slide.php'; ?>
  </div>



    <?php include '../ecommerce/includes/browseBycategory.php'; ?><p></p><p></p>

  <div >
    <?php include '../ecommerce/includes/slidemult.php'; ?><p></p><p></p>

  </div>
  <?php include '../ecommerce/includes/featured.php'; ?><p></p><p></p>
  <?php //include '../ecommerce/includes/slidemultrow.php'; ?><p></p><p></p>
<?php

//include "/includes/widgets/recent.php";

include "includes/footer.php";
  ?>
