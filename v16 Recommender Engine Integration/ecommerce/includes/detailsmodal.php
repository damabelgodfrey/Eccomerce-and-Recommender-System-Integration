<?php
require_once $_SERVER['DOCUMENT_ROOT'].'/ecommerce/core/init.php';
$id = (int)sanitize($_POST['id']);
$mode = sanitize($_POST['mode']);
$sql = "SELECT * FROM products WHERE id = '$id'";
$result = $db->query($sql);
$product = mysqli_fetch_assoc($result);
$sizes = sizesToArray($product['sizes']);
$brand_id = $product['brand'];
$sql = "SELECT brand FROM brand WHERE id ='$brand_id'";
$brand_query = $db->query($sql);
$brand = mysqli_fetch_assoc($brand_query);
$tag = $product['p_keyword'];
 ?>
<!--Product Details light Box -->
<?php ob_start(); ?>
<div class="modal fade details-1" id="details-modal" tabindex="-1" role="dialog" aria-labelledby="details-1" aria-hidden="true" data-backdrop="static" data-keyboard="false">
  <div class="modal-dialog modal-lg " role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button class="close " type="button" onclick = "closeModal()" aria-label="close">
          <span aria-hidden="true">&times;</span>
        </button>
        <h2 class="modal-title text-center"><?= $product['title']; ?></h2>
      </div>
      <div class="modal-body">
        <div class"container-fluid ">
          <div class="row">
            <span id="modal_errors" class="bg-danger"></span>
            <div class=" fotorama col-md-6"
                    data-maxheight="400">
                <?php $photos = explode(',', $product['image']); //multiple image is seperated by ,
                foreach($photos as $photo): ?>
                   <img src="<?= $photo; ?>" alt="<?= $product['title']; ?>" class="detailmodal-img img-responsive">
                <?php endforeach; ?>
            </div>
            <div class="col-md-6">
              <h4>Product Details</h4>
              <?php ?>
              <p><?= nl2br($product['description']); ?><p> <hr><!--nl2br is to preserve line break-->
              <p><strong>Brand:</strong> <?= $brand['brand']; ?></p> <hr>
              <form action="add_cart" method="post" id="add_product_form">
                <input type="hidden" name="product_id" value="<?=$id;?>">
                <input type="hidden" name="available" id="available" value="">
                  <input type="hidden" name="price" id="price" value="">
                  <input type="hidden" name="dmode" id="dmode" value="" class= "form-control">
                <div class="form-group">
                  <div class=""><label for="quantity">Quantity:</label>
                    <input type="number" class="form-control" id="quantity" value="1"name="quantity" min="0" placeholder="Enter Quantity">
                  </div>
                </div>
                <div class="form-group">
                  <label for="pricelabel">Price: </label><input type="label" class="form-control" name="pricelabel" id="pricelabel" value="" placeholder="Choose Size to view price!" readonly>
                </div>
                <div class="form-group">
                  <label for="size">Size:</label>
                  <select name="size" id="size" class="form-control">
                    <option value="">Choose Size</option>
                    <?php foreach ($sizes as $msize){
                            $size = $msize['size'];
                            $price =$msize['price'];
                            $available =$msize['quantity'];
                            if($available <=0){
                              echo '<option value="'.$size.'" data-price="'.$price.'" data-available="'.$available.'">'.$size.' ( out of stock)</option>';
                            }elseif($available < 20){
                                echo '<option value="'.$size.'" data-price="'.$price.'" data-available="'.$available.'">'.$size.' ('.$available.' Remaining)</option>';
                            }else{
                               echo '<option value="'.$size.'"  data-price="'.$price.'" data-available="'.$available.'">'.$size.' ('. 'Available)</option>';
                            }
                     }?>
                  </select><p></p>
                  <div class="form-group">
                    <!-- <label for="description">Special Request:</label> -->
                    <textarea id="request" name="request"  class="form-control" pull-left maxlength="50" placeholder="Optional! Enter preference or special request e.g fragrance, colour etc" rows="2"></textarea>
                  </div>
                </div>
              </form>
         </div>
<?php //include 'featured.php'; ?>
        </div>
      </div>

  </div>
      <!--footer of the product detail pop up-->
    <div class="modal-footer">
     <?php if(is_logged_in()){ ?>
           <?php if($mode =='add'){ ?>
          <button class="btn btn-default"onclick="closeModal()">close</button>
          <button class="btn btn-success" onclick="add_to_cart('cart');return false;"><span class="glyphicon glyphicon-shopping-cart"></span>Add TO Cart</button>
          <button class="btn btn-info" onclick="add_to_cart('wish');return false;"><span class="glyphicon glyphicon-heart"></span>Add TO wishlist</button>
          <script type="text/javascript">
          $("#details-modal").draggable({
              handle: ".modal-header"
          });
          </script>


        <?php } ?>
           <?php if ($mode=='view'): ?>
             <div class="bg-danger">
               <p class="text-center text-warning">
                 Item Details view only!
                 <button class="btn btn-default" onclick="closeModal()">close</button>
               </p>
             </div>
           <?php endif; ?>
<?php  }else{?>
  <div class="bg-danger">
    <p class="text-center text-warning">
      <button class="btn btn-default"onclick="closeModal()">close</button>
      Login to Add and View Shopping Bag and saved Item!
      <a href="login" class="btn btn-warning" role="button">Login</a>
    </p>
  </div>
    <?php  } ?>
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
<<<<<<< HEAD
  alert("Something went wrong");
=======
>>>>>>> 00946282fd0ced214a37681e144e38779b687dd4
  jQuery('#details-modal').modal('hide');
  setTimeout(function(){
    jQuery('#details-modal').remove();
    jQuery('.modal.backdrop').remove();
  },500);
}

  function add_to_cart(dmode){
    jQuery('#modal_errors').html("");
    jQuery("#dmode").val(dmode);
    var size = jQuery('#size').val();
    var quantity = parseInt(jQuery('#quantity').val());
    var available = parseInt(jQuery('#available').val());
    var price = parseInt(jQuery('#price').val());
    var request = jQuery('#request').val();
    var error = '';
    var data = jQuery('#add_product_form').serialize();
    if(size =='' || quantity =='' || quantity == 0){
      error += '<p class="text-danger bg-danger text-center">Please choose a size and quantity!</p>';
      jQuery('#modal_errors').html(error);
      return;
    }else if(quantity > available){
      error += '<p class="text-danger bg-danger text-center">You added '+quantity+' quantity but there are less available in store at the moment.</p>';
      jQuery('#modal_errors').html(error);
      return;
    }else{
      jQuery.ajax({
        url : '/ecommerce/admin/parsers/add_cart.php',
        method : 'post',
        data : data,
        success : function(){
          location.reload(); // allow page to refresh so cookie can be accessible
        },
        error : function(){alert("Something went wrong")}
      });
    }
  }
</script>
<?php echo ob_get_clean(); ?>
