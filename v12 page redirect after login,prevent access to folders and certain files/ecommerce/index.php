<?php
  require_once 'core/init.php';
  include"includes/head.php";
  include"includes/navigation.php";
  //include"includes/headerpartial.php";

  $sql ="SELECT * FROM products WHERE featured = 1";
  $featured = $db->query($sql);
?>

    <!--main content -->
    <?php include '../ecommerce/includes/slidefrontpage.php'; ?>
  <div class="col-md-9" ><p></p>
    <div class="bar-top">
      <h3 class="text-center">⇩Ameritinz Specials⇩</h3>
    </div>
    <div class="row">
        <?php while ($product = mysqli_fetch_assoc($featured)) : ?>
         <div class="col-xs-6 col-sm-4 col-md-3 padding-index" id = detailLabel>
           <div class="polaroid text-center">

            <?php if ($product['sales'] == 1): ?>
              <button type ="button" id="sales" class="btn btn-xs btn-danger pull-left" onclick="detailsmodal(<?= $product['id']; ?>)">Sales</button>
            <?php endif; ?>  <!-- <img src="/ecommerce/images/headerlogo/images.png" alt="" class="img-thumb" style="width:100%"/> -->
            <div class="product_title">
              <h4><?= $product['title']; ?></h4>
            </div>
             <?php $photos = explode(',',$product['image']); ?>
            <img onclick="detailsmodal(<?= $product['id']; ?>)" src="<?= $photos[0]; ?>" alt="<?= $product['title']; ?>" class="img-thumb" style="width:100%"/>
            <p></p><p
            class="list-price" style="color:grey">Was: <s>₦<?= $product['list_price']; ?></s> <hi style="color:black" class="price">Now: ₦<?= $product['price']; ?></hi>
          </p>

            <button type ="button" id="dbutton"class="btn btn-sm btn-danger" onclick="detailsmodal(<?= $product['id']; ?>)">DETAILS</button>
         </div>
         </div>
       <?php endwhile; ?>
    </div>
  </div>
  <div class="col-md-3" ><p></p>
    <?php include '../ecommerce/includes/slide.php'; ?>
  </div>
<?php

//include "/includes/widgets/recent.php";

include "includes/footer.php";
  ?>
