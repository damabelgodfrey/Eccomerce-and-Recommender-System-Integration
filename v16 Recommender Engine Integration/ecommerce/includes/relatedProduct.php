<?php
$query = $db->query("SELECT * FROM products WHERE p_keyword LIKE '%".$tag."%' AND archive = 0");
?>

<div class="col-md-12">
  <div class="row"><p></p>
      <div class="">
        <h2>Related Product</h2>
      </div>
            <?php while ($product = $query->fetch_assoc()) : ?>
             <div class="col-xs-5 col-sm-4 col-md-4 padding-0 animation">
               <div class="polaroid text-center">
                 <?php if ($product['sales'] == 1): ?>
                   <button type ="button" id="sales" class="btn btn-xs btn-danger pull-left" onclick="detailsmodal(<?= $product['id']; ?>)">Sales</button>
                 <?php endif; ?>
                 <div class="product_title">
                   <h4><?= $product['title']; ?></h4>
                 </div>
                 <?php $photos = explode(',',$product['image']); ?>
                <img onclick="detailsmodal(<?= $product['id']; ?>)" src="<?= $photos[0]; ?>" alt="<?= $product['title']; ?>" class="img-thumb" style="width:100%"/>
                <p></p><p class="list-price" style="color:grey">Was: <s>₦<?= $product['list_price']; ?></s></p>
                <p class="price">Now: ₦<?= $product['price']; ?></p>
                <button type ="button" id="dbutton" class="btn btn-sm btn-danger" onclick="detailsmodal(<?= $product['id']; ?>)">DETAILS</button>
             </div>
           </div>
     <?php endwhile;  ?>
</div>
<!-- display pagination links -->
<?php echo $pagination->createLinks(); ?>
</div>
 ?>
