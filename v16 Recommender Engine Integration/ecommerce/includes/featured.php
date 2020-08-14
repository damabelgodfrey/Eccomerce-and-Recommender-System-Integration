<?php
$sql ="SELECT * FROM products WHERE featured = 1 AND defective_product = 0 AND archive = 0 AND category_activate_flag =1";
$featured = $db->query($sql);
?>
<div class="imagecontainer bar-top">
	<div class="row" >
      <h3 class="text-center">⇩Featured Product⇩</h3>
		<div class="MultiCarousel" data-items="2,3,4,4" data-slide="2" id="MultiCarousel"  data-interval="1000">
              <div class="MultiCarousel-inner">
              <?php while ($product = mysqli_fetch_assoc($featured)) : ?>
                <div class="item ">
                    <div class="pad15  imagecontainer animation polaroid text-center ">
                       <?php if ($product['sales'] == 1): ?>
                         <button type ="button" id="sales" class="btn btn-xs btn-danger pull-left" onclick="detailsmodal('add',<?= $product['id']; ?>)">Sales</button>
                       <?php endif; ?>  <!-- <img src="/ecommerce/images/headerlogo/images.png" alt="" class="img-thumb" style="width:100%"/> -->
                       <div class="product_title">
                         <strong><h4><?= $product['title']; ?></h4></strong>
                       </div>
                        <?php $photos = explode(',',$product['image']); ?>
                       <img onclick="detailsmodal('add',<?= $product['id']; ?>)" src="<?= $photos[0]; ?>" alt="<?= $product['title']; ?>" class="img-thumb" style="width:100%"/>
                       <p></p><p
                       class="list-price" style="color:grey">Was: <s>₦<?= $product['list_price']; ?></s>
											 <hi style="color:black" class="price">Now: ₦<?= $product['price']; ?></hi>
                     </p>
                       <!-- <button type ="button" id="dbutton"class="btn btn-sm btn-danger" onclick="detailsmodal('add',<?= $product['id']; ?>)">DETAILS</button> -->
                  </div>
                  </div>
              <?php endwhile; ?>
              </div>
            <button class="btn btn-danger leftLst"><<</button>
            <button class="btn btn-danger rightLst">>></button>
        </div>
	</div>
</div>
