<?php
$werrors = array();
if(isset($user_name)){
$wish = $db->query("SELECT * FROM wishlist WHERE username = '{$user_name}'");
//$wish = $db->query("SELECT * FROM cart WHERE username = '{$user_name}' AND paid = '{$paid}'");
$returnW = mysqli_num_rows($wish);
  if($returnW != 1){
    $werrors[] ="Wish List empty";
  }else{

    $resultW = mysqli_fetch_assoc($wish);
    $wishItem_id = $resultW['id'];
    $wishitems = json_decode($resultW['items'],true);
    $i = 1;
    $w_sub_total = 0;
    $w_item_count = 0;
  }
}else{
  $werrors[] ="Wish List is empty. Login to view wishlist";
}
?>
<div class="panel panel-default">
  <div class="panel-heading text-center">
    <div class="form-group">
      <button id="wishSaved" class=" form-control btn btn-warning"onclick="wishListFunction()">Click to View Saved Item in Wish List</button>
  </div>
</div>

<div class="" id="myWish">
<div class="panel-body">
    <?php if(!empty($werrors)){ ?>
      <div class="bg-danger">
        <p class="text-center text-info">
          Your Wish List is empty!
        </p>
      </div>
    <?php } else{ ?>
      <span id="wish_errors" class="bg-danger"></span>
     <table class="table table-bordered table-condensed table-striped  table-responsive">
       <thead class= item-table-header><th>#</th><th>Item</th><th>Price</th><th>Size/Request</th><th>Quantity</th></thead>
       <tbody>
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
            <tr>
              <td>
                [<?=$i;?>]
                <button class="btn btn-danger btn-md glyphicon glyphicon-remove" onclick="update_cart('wishdelete','<?=$wishItem_id;?>','<?=$wishitem['id'];?>
                ','<?=$wishitem['size'];?>','<?=$wishitem['quantity'];?>','<?=$available;?>');"></button>
              <?php if($available <= 0){ ?>
              <span class="text-danger">Out of stock</span>
            <?php }elseif($wishitem['quantity'] > $available){ ?>
              <?php $wishitem['quantity'] = $available; ?>
                  <button class="btn btn-md btn-info glyphicon glyphicon-shopping-cart" onclick="wishlisttocart('cart','<?=$wishitem['id'];?>','<?=$wishitem['size'];?>','<?=$wishitem['quantity'];?>','<?=$available;?>','<?=$wishitem['price'];?>','<?=$wishitem['request'];?>');">Add to cart</button>
                <?php }else{ ?>
                  <button class="btn btn-md btn-info glyphicon glyphicon-shopping-cart" onclick="wishlisttocart('cart','<?=$wishitem['id'];?>','<?=$wishitem['size'];?>','<?=$wishitem['quantity'];?>','<?=$available;?>','<?=$wishitem['price'];?>','<?=$wishitem['request'];?>');">Add to cart</button>
                <?php } ?>
                </td>
              <td><?=$w_product['title'];?><br>
                <button class="text-primary btn btn-sm" onclick="detailsmodal('view','<?=$wishitem['id'];?>')">View Details</button>
              </td>
              <td><?=money($wishitem['price']);?></td>
              <td><?=$wishitem['size'];?><p></p><?=$wishitem['request'];?></td>
              <td><?=$wishitem['quantity'];?></td>
            </tr>
            <?php
            $i++;
          }else{
            $db->query("DELETE FROM wishlist WHERE username = '{$user_name}'");
          }
        }
        ?>
       </tbody>
     </table>
    <?php } ?>
</div></div></div>
<script>
function wishListFunction() {
  var x = document.getElementById("myWish");
  if (x.style.display === "none") {
      x.style.display = "block";
  } else {
      x.style.display = "none";
  }
  var y = document.getElementById("wishSaved");
  if (y.innerHTML === "Click to View Saved Item in Wish List") {
    y.innerHTML = "Hide Saved Item";
  } else {
    y.innerHTML = "Click to View Saved Item in Wish List";
  }
}
$(document).ready(function(){
  var x = document.getElementById("myWish");
 x.style.display = "none";
});
</script>
