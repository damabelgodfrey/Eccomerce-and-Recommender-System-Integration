<Style>
.wish_image img{
      display: block;
      margin-left: auto;
      margin-right: auto;
}
.wish_image tr{
  text-align:center;
   vertical-align: middle;
}
.wishlistwidth{
  max-width: 1200px;
  margin-left: auto;
  margin-right: auto;
}

</Style>
<?php
require_once 'core/init.php';
include 'includes/head.php';
include 'includes/navigation.php';
$werrors = array();
if(isset($user_name)){
$wish = $db->query("SELECT * FROM wishlist WHERE userID = '{$user_id}'");
//$wish = $db->query("SELECT * FROM cart WHERE username = '{$user_name}' AND paid = '{$paid}'");
$returnW = mysqli_num_rows($wish);
  if($returnW != 1){
    $werrors[] ="Wish List empty";
  }else{
    $resultW = mysqli_fetch_assoc($wish);
    $wishItem_id = $resultW['userID'];
    $wishitems = json_decode($resultW['items'],true);
    $w_i = 1;
    $w_sub_total = 0;
    $w_item_count = 0;
  }
}else{
  $werrors[] ="Login to view wishlist";
}
?>
    <?php if(!empty($werrors)){ ?>
      <div class="bg-danger">
        <p class="text-center text-info">
          <?=$werrors[0];?>
        </p>
      </div>
    <?php } else{ ?>
      <div class="wishlistwidth">
        <div class="panel panel-default">
        <div class="panel-heading">
          <div class="text-left"> <h3>MY Saved Item</h3>
          </div>
        </div>
        <?php
      ?>
        <div class="panel-body text-center">
      <span id="wish_errors" class="bg-danger"></span>
      <?php
        foreach($wishitems as $wishitem){
          //$expireflag=1;
            $w_product_id =$wishitem['id'];
            $available = -1;
            $w_productQ = $db->query("SELECT * FROM products WHERE id = '{$w_product_id}'");
          if(mysqli_num_rows($w_productQ) > 0){
            $w_product = mysqli_fetch_assoc($w_productQ);
            $w_sizes = sizesToArray($w_product['sizes']); //function in helper file
            foreach($w_sizes as $w_size){
                if($w_size['size'] == $wishitem['size']){
                  $available = (int)$w_size['quantity'];
              }
            }
            ?>
            <div class="row">
                <div class="col-xs-6 text-center">
                    <div class="pull-left">
                      [<?=$w_i;?>]
                    </div>
                    <div class=" wish_image ">
                      <div class=" fotorama" data-minheight="200px"data-width="400px" data-maxheight="500">
                          <?php $photos = explode(',', $w_product['image']); //multiple image is seperated by ,
                          foreach($photos as $photo): ?>
                            <img src="<?= $photo; ?>" alt="<?= $w_product['title']; ?>">
                    <?php endforeach; ?>
                      </div>
                    </div>
                </div>
                  <div class="col-xs-6">
                    <div class="pull-right">
                      <button class="btn btnx btn-danger btn-xs glyphicon glyphicon-remove" onclick="update_cart('wishdelete','<?=$wishItem_id;?>','<?=$wishitem['id'];?>
                      ','<?=$wishitem['size'];?>','<?=$wishitem['quantity'];?>','<?=$available;?>');"></button>
                    </div>
                    <div class="pull-left" style="color:white">
                      <strong>Title:  </strong>
                    </div>
                    <div class="product_title pull-center">
                      <h3><?=$w_product['title'];?></h3>
                    </div>
                    <div class="pull-left" style="color:white">
                      <strong>price:  </strong>
                    </div>
                        <strong> <p class="price text-danger"><?=money($wishitem['quantity'] * $wishitem['price']);?></p></strong> <p></p>
                      <div class="pull-left">
                        <strong>Qty:  </strong>
                      </div>
                      <?php if($available <= 0){ ?>
                      <span class="text-danger">Out of stock</span>
                    <?php }elseif($wishitem['quantity'] > $available){ ?>
                      <?php $wishitem['quantity'] = $available; ?>
                        <?php }else{ ?>
                            <?=$wishitem['quantity'];?>
                        <?php } ?>
                       <p></p>
                      <div class="pull-left">
                        <strong>Size:  </strong>
                      </div><?=$wishitem['size'];?><p></p><?=$wishitem['request'];?>
                  <input readonly style="border:none"  type="label" class="form-control" name="" value="<?=$w_product['description'];?>"><p></p>
                  <button class="btn btn-md btn-info glyphicon glyphicon-shopping-cart " id="wishlisttocart" onclick="wishlisttocart('cart','<?=$wishitem['id'];?>','<?=$wishitem['size'];?>','<?=$wishitem['quantity'];?>','<?=$available;?>','<?=$wishitem['price'];?>','<?=$wishitem['request'];?>');">Add to cart</button>
                  <button class="text-primary btn btn-sm" onclick="detailsmodal('view','<?=$wishitem['id'];?>')">View Details</button>
                </div>
            <?php
            $w_i++;
            ?>
          </div><hr> <?php
          }else{
            $db->query("DELETE FROM wishlist WHERE userID = '{$user_id}'");
          }
        }
        ?>
  </div>
  <div class="panel-footer"></div>
  </div></div>
<?php } ?>
<?php include 'includes/footer.php' ?>
<script>
function wishlisttocart(mode,product_id,size,quantity,available,price,request){
  jQuery('#wish_errors').html("");
  $('.btn').prop('disabled', true);
  var error = '';
  var product_available = {'dmode' : mode, "product_id" : product_id, "size" : size,"quantity" : quantity};
  var data_cart = {'dmode' : mode, "product_id" : product_id, "size" : size,"quantity" : quantity,"available":available,"price":price,"request":request};
  var data_update = {'mode' : 'wish', "edit_id" : product_id, "edit_size" : size,"edit_quantity" : quantity,"edit_available":available};
  jQuery.ajax({
    url : '/ecommerce/admin/parsers/check_product.php',
    method : 'POST',
    data : product_available,
    success : function(data){
      if(data != 'success'){
        jQuery('#wish_errors').html(data);
        $('.btnx').prop('disabled', false);
      }
      if(data == 'success'){
        jQuery('#wish_errors').html("");
          jQuery.ajax({
            url : '/ecommerce/admin/parsers/add_cart.php',
            method : "post",
            data : data_cart,
            success : function(){location.reload();},
            error : function(){alert("Something went wrong while adding product to cart.");},
          });
          jQuery.ajax({
            url : '/ecommerce/admin/parsers/update_cart.php',
            method : "post",
            data : data_update,
            success : function(){location.reload();},
            error : function(){alert("Something went wrong while updating cart.");},
          });
      }
    },
    errors : function(){alert("Something Went Wrong! Product availability check unsuccessful");},
  });
}
</script>
