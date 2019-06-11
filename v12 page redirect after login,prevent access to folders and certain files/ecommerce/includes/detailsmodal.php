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
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <button class="close" type="button" onclick = "closeModal()" aria-label="close">
          <span aria-hidden="true">&times;</span>
        </button>
        <h2 class="modal-title text-center"><?= $product['title']; ?></h2>
      </div>
      <div class="modal-body">
        <div class"container-fluid">
          <div class="row">
            <span id="modal_errors" class="bg-danger"></span>
            <div class="col-md-6 fotorama">
              <div id="fotorama">
                <?php $photos = explode(',', $product['image']); //multiple image is seperated by ,
                foreach($photos as $photo): ?>
                   <img src="<?= $photo; ?>" alt="<?= $product['title']; ?>" class="details img-responsive modalfotorama">
                <?php endforeach; ?>
              </div>
            </div>
            <div class="col-md-6">
              <h4>Product Details</h4>
              <p><?= nl2br($product['description']); ?><p> <hr><!--nl2br is to preserve line break-->
              <p><strong>Brand:</strong> <?= $brand['brand']; ?></p> <hr>

              <form action="add_cart" method="post" id="add_product_form">
                <input type="hidden" name="product_id" value="<?=$id;?>">
                <input type="hidden" name="available" id="available" value="">
                  <input type="hidden" name="price" id="price" value="">

                <div class="form-group">
                  <div class=""><label for="quantity">Quantity:</label>
                    <input type="number" class="form-control" id="quantity" name="quantity" min="0" placeholder="Enter Quantity">
                  </div>
                </div>
                <div class="form-group">
                  <label for="pricelabel">Price: </label><input type="label" class="form-control" name="pricelabel" id="pricelabel" value="" placeholder="Choose Size to view price!" readonly>
                </div>
                <div class="form-group">
                  <label for="size">Size:</label>
                  <select name="size" id="size" class="form-control">
                    <option value="">Choose Size</option>

                    <?php foreach ($size_array as $string) {

                      $string_array = explode(':', $string);
                      $size = $string_array[0];
                      $price =(int)$string_array[1];
                      $available =(int)$string_array[2];

                    if($available ==0){
                      echo '<option value="'.$size.'" data-price="'.$price.'" data-available="'.$available.'">'.$size.' ( out of stock)</option>';
                    }elseif($available < 20){
                        echo '<option value="'.$size.'" data-price="'.$price.'" data-available="'.$available.'">'.$size.' ('.$available.' Remaining)</option>';

                     }else{
                       echo '<option value="'.$size.'"  data-price="'.$price.'" data-available="'.$available.'">'.$size.' ('. 'Available)</option>';
                     }
                    //  }
                      //echo '<option value="'.$size.'">'.$size.' ('.$quantity.' Available)</option>';
                    } ?>

                  </select><p></p>
                  <div class="form-group">
                    <!-- <label for="description">Special Request:</label> -->
                    <textarea id="request" name="request"  class="form-control" pull-left maxlength="50" placeholder="Optional! Enter preference or special request e.g fragrance, colour etc" rows="2"></textarea>
                  </div>
                </div>
              </form>
         </div>
        </div>
      </div>

  </div>
  <!--footer of the product detail pop up-->
<div class="modal-footer">
 <button class="btn btn-default"onclick="closeModal()">close</button>
 <?php if(is_logged_in()){
   echo '<button class="btn btn-warning" onclick="add_to_cart();return false;"><span class="glyphicon glyphicon-shopping-cart"></span>Add TO Cart</button>';
 }else{
   echo '<a href="login" class="btn btn-warning" role="button">Login to add to cart</a>';
  } ?>
</div>
  </div>
</div>
</div>
<script>
 jQuery('#size').change(function(){
   var available = jQuery('#size option:selected').data("available");
   jQuery('#available').val(available);
   var price = jQuery('#size option:selected').data("price");
   jQuery('#price').val(price);
   if(typeof price === 'undefined'){
     jQuery('#pricelabel').val('choose size');
   }else{
     var pricelabel = '₦';
   jQuery('#pricelabel').val(pricelabel+=price);
}

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
