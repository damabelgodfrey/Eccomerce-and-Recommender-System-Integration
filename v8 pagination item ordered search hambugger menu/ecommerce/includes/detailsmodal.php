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
$sizestring = $product['sizes'];
$sizestring =rtrim($sizestring,','); //remove the lst comma from size
$size_array =explode(',', $sizestring);
 ?>
<!--Product Details light Box -->
<?php ob_start(); ?>
<div class="modal fade details-1" id="details-modal" tabindex="-1" role="dialog" aria-labelledby="details-1" aria-hidden="true">
  <div class="modal-dialog modal-1g">
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
            <div class="col-sm-6 fotorama">
              <?php $photos = explode(',', $product['image']); //multiple image is seperated by ,
              foreach($photos as $photo): ?>
                 <img src="<?= $photo; ?>" alt="<?= $product['title']; ?>" class="details img-responsive">
              <?php endforeach; ?>
            </div>
            <div class="col-sm-6">
              <h4>Product Details</h4>
              <p><?= nl2br($product['description']); ?><p> <!--nl2br is to preserve line break-->
              <hr>
              <p>Price: ₦<?= $product['price']; ?></p> <!-- add currency symbol to price-->
              <p>Brand: <?= $brand['brand']; ?></p>

              <form action="add_cart.php" method="post" id="add_product_form">
                <input type="hidden" name="product_id" value="<?=$id;?>">
                <input type="hidden" name="available" id="available" value="">
                <div class="form-group">
                  <div class="col-xs-5"><label for="quantity">Quantity:</label>
                    <input type="number" class="form-control" id="quantity" name="quantity" min="0">
                  </div><br>
                  <div class="col-xs-9">&nbsp;</div>
                </div><br><br>
                <div class="form-group">
                  <label for="size">Size:</label>
                  <select name="size" id="size" class="form-control">
                    <option value=""></option>
                    <?php foreach ($size_array as $string) {
                      $string_array = explode(':', $string);
                      $size = $string_array[0];
                      $available =$string_array[1];
                      //$size = intval($size);
                      //$available = intval($available);


                      //display product quantityavailability when product in store is 10 and bellow
                    //  if ($num_quantity < 11) {
                      //  echo '<option value="'.$size.'">'.$size.' ('.$available.' Remaining)</option>';
                    //  }else {
                    if($available ==0){
                      echo '<option value="'.$size.'" data-available="'.$available.'">'.$size.' ('.$available.' out of stock)</option>';
                    }elseif($available < 20){
                        echo '<option value="'.$size.'" data-available="'.$available.'">'.$size.' ('.$available.' Remaining)</option>';

                     }else{
                       echo '<option value="'.$size.'" data-available="'.$available.'">'.$size.' ('.' Available)</option>';
                     }
                    //  }
                      //echo '<option value="'.$size.'">'.$size.' ('.$quantity.' Available)</option>';
                    } ?>

                  </select>
                </div>
              </form>
         </div>
        </div>
      </div>
         <!--footer of the product detail pop up-->
      <div class="modal-footer">
        <button class="btn btn-default"onclick="closeModal()">close</button>
        <button class="btn btn-warning" onclick="add_to_cart();return false;"><span class="glyphicon glyphicon-shopping-cart"></span>Add TO Cart</button>
      </div>
  </div>
  </div>
</div>
</div>
<script>
 jQuery('#size').change(function(){
   var available = jQuery('#size option:selected').data("available");
   jQuery('#available').val(available);
 });

$(function() {
  $('.fotorama').fotorama({'loop':true,'autoplay':true});
});
  function closeModal(){
    jQuery('#details-modal').modal('hide');
    setTimeout(function(){
      jQuery('#details-modal').remove();
      jQuery('.modal.backdrop').remove();
    },500);
  }
</script>
<?php echo ob_get_clean(); ?>
