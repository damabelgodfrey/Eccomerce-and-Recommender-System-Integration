<?php
  require_once 'core/init.php';
  include"includes/head.php";
  include"includes/navigation.php";
  include"includes/headerfull.php";
  include"includes/leftbar.php";

  $sql ="SELECT * FROM products WHERE featured = 1";
  $featured = $db->query($sql);
?>

    <!--main content -->
  <div class="col-md-8" id = detailLabel>
    <div class="row">
        <h2 class="text-center">⇩Ameritinz Specials⇩</h2>

        <?php while ($product = mysqli_fetch_assoc($featured)) : ?>
         <div class="col-sm-3 text-center">
          <h4><?= $product['title']; ?></h4>
           <?php $photos = explode(',',$product['image']); ?>
           <img onclick="detailsmodal(<?= $product['id']; ?>)" src="<?= $photos[0]; ?>" alt="<?= $product['title']; ?>" class="img-thumb" />
           <p></p><p class="list-price" style="color:grey">Was: <s>₦<?= $product['list_price']; ?></s></p>
           <p class="price">Now: ₦<?= $product['price']; ?></p>
           <button type ="button" class="btn btn-sm btn-success" onclick="detailsmodal(<?= $product['id']; ?>)">Details</button>
         </div>
       <?php endwhile; ?>
    </div>
  </div>

<?php

  include "includes/rightbar.php";
  include "includes/footer.php";
  ?>
