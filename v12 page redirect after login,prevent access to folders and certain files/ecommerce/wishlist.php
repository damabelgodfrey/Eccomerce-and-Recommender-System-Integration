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
    $wishitems = json_decode($resultW['items'],true);
    $i = 1;
    $w_sub_total = 0;
    $w_item_count = 0;
  }
}else{
  $werrors[] ="Wish List empty";
}
?>

<h2 class="text-center">My Wish List</h2><hr>
<?php if(!empty($werrors)){ ?>
  <div class="bg-danger">
    <p class="text-center text-info">
      Your Wish List is empty!
    </p>
  </div>
<?php } else{ ?>

 <table class="table table-bordered table-condensed table-striped  table-responsive">
   <thead class= item-table-header><th>#</th><th>Item</th><th>Price</th><th>Size/Request</th><th>Quantity</th></thead>
   <tbody>
  <?php
    foreach($wishitems as $wishitem){
      //$expireflag=1;
      $w_product_id =$wishitem['id'];
      $w_productQ = $db->query("SELECT * FROM products WHERE id = '{$w_product_id}'");
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
          <button class="btn btn-danger btn-md glyphicon glyphicon-remove" onclick="update_cart('wish','<?=$w_product['id'];?>','<?=$wishitem['size'];?>','<?=$wishitem['quantity'];?>','<?=$available;?>');"> Remove</button>
        <?php if($available <= 0){ ?>
        <span class="text-danger">Out of stock</span>
      <?php }elseif($wishitem['quantity'] > $available){ ?>
        <?php $wishitem['quantity'] = $available; ?>
            <button class="btn btn-md btn-info glyphicon glyphicon-shopping-cart" onclick="wishlisttocart('wish','<?=$wishitem['id'];?>','<?=$wishitem['size'];?>','<?=$wishitem['quantity'];?>','<?=$available;?>','<?=$wishitem['price'];?>','<?=$wishitem['request'];?>');">Add back to cart</button>
          <?php }else{ ?>
            <button class="btn btn-md btn-info glyphicon glyphicon-shopping-cart" onclick="wishlisttocart('wish','<?=$wishitem['id'];?>','<?=$wishitem['size'];?>','<?=$wishitem['quantity'];?>','<?=$available;?>','<?=$wishitem['price'];?>','<?=$wishitem['request'];?>');">Add back to cart</button>
          <?php } ?>
          </td>
        <td><?=$w_product['title'];?><br>
          <a class="text-primary" onclick="cartmodal('<?=$w_product['id'];?>')">View Details</a>
        </td>
        <td><?=money($wishitem['price']);?></td>
        <td><?=$wishitem['size'];?><p></p><?=$wishitem['request'];?></td>
        <td><?=$wishitem['quantity'];?></td>
      </tr>
      <?php
      $i++;

    }
    ?>
   </tbody>
 </table>
<?php } ?>
