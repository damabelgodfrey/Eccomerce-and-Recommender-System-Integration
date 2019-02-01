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
  <div class="col-md-9" >
    <div class="row">

        <hr><h2 class="text-center">⇩Ameritinz Specials⇩</h2>
        <?php while ($product = mysqli_fetch_assoc($featured)) : ?>
         <div class="col-xs-5 col-md-4 padding-index" id = detailLabel>
           <div class="polaroid text-center">
             <h4><?= $product['title']; ?></h4>
             <?php $photos = explode(',',$product['image']); ?>
            <img onclick="detailsmodal(<?= $product['id']; ?>)" src="<?= $photos[0]; ?>" alt="<?= $product['title']; ?>" class="img-thumb" style="width:100%"/>
            <p></p><p
            class="list-price" style="color:grey">Was: <s>₦<?= $product['list_price']; ?></s> <hi style="color:black" class="price">Now: ₦<?= $product['price']; ?></hi>
          </p>

            <button type ="button" class="btn btn-sm btn-danger" onclick="detailsmodal(<?= $product['id']; ?>)">DETAILS</button>
         </div>
         </div>
       <?php endwhile; ?>
    </div>
  </div>

<?php
include "/includes/widgets/recent.php";
include "includes/footer.php";
  ?>
