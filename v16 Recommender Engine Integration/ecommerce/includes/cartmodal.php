<?php
require_once '../core/init.php';
$id = $_POST['id'];
$id = (int)$id;
$sql = "SELECT * FROM products WHERE id = '$id'";
$result = $db->query($sql);
$product = mysqli_fetch_assoc($result);
$brand_id = $product['brand'];
$sql = "SELECT brand FROM brand WHERE id ='$brand_id'";
$brand_query = $db->query($sql);
$brand = mysqli_fetch_assoc($brand_query);
 ?>
<!--Product Details light Box -->
<?php ob_start(); ?>
<div class="modal fade details-1" id="cart-modal" tabindex="-1" role="dialog" aria-labelledby="details-1" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <button class="close" type="button" onclick = "closeModal()" aria-label="close">
          <span aria-hidden="true">&times;</span>
        </button>
        <h4 class="modal-title text-center"><?= $product['title']; ?></h4>
      </div>
      <div class="modal-body">
        <div class"container-fluid">
          <div class="row">
            <span id="modal_errors" class="bg-danger"></span>
            <div class="col-sm-6 fotorama"data-maxheight="400">>
              <?php $photos = explode(',', $product['image']); //multiple image is seperated by ,
              foreach($photos as $photo): ?>

                 <img src="<?= $photo; ?>" alt="<?= $product['title']; ?>" class="details img-responsive">

              <?php endforeach; ?>
          </div>
            <div class="col-sm-6">
              <h4>Product Details</h4>
              <p><?= nl2br($product['description']); ?><p> <!--nl2br is to preserve line break-->
              <hr>
              <p>Brand: <?= $brand['brand']; ?></p>

         </div>
        </div>
      </div>
         <!--footer of the product detail pop up-->
      <div class="modal-footer">
        <button class="btn btn-default"onclick="closeModal()">close</button>
      </div>
  </div>
  </div>
</div>
</div>
<script>

$(function() {
  $('.fotorama').fotorama({'loop':true,'autoplay':true});
});
  function closeModal(){
    jQuery('#cart-modal').modal('hide');
    setTimeout(function(){
      jQuery('#cart-modal').remove();
      jQuery('.modal.backdrop').remove();
    },500);
  }
</script>
<?php echo ob_get_clean(); ?>
