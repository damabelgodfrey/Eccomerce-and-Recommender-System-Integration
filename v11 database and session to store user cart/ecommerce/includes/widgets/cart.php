<h3 class="text-center">Shopping Cart</h3>
<div>
<?php
$cartQ = $db->query("SELECT * FROM cart WHERE username = '{$cart_id}'");
$return = mysqli_num_rows($cartQ);
  if($return != 1){ ?>
    <div class="bg-danger">
      <p class="text-center text-info">
        Your shopping Cart is empty!
      </p>
    </div>
    <?php
  }else{
        $results = mysqli_fetch_assoc($cartQ);
        $items = json_decode($results['items'],true);
        $sub_total = 0;
        ?>
        <table class="table table-condensed" id="cart_widget" >
        <tbody>
        <?php foreach($items as $item):
        $productQ = $db->query("SELECT * FROM products WHERE id = '{$item['id']}' ");
        $product = mysqli_fetch_assoc($productQ);
        ?>
        <tr>
        <td><?=$item['quantity'];?></td>
        <td><?=substr($product['title'],0,15);?></td>
        <td><?=money($item['quantity'] * (int)$item['price']);?></td>
        </tr>
        <?php
        $sub_total += ($item['quantity'] * (int)$item['price']);
         endforeach; ?>
         <tr id= subTcart>
           <td></td>
           <td>Sub Total</td>
           <td><?=money($sub_total);?></td>
         </tr>
         </tbody>
        </table>
    <a href ="cart.php" class="btn btn-xs btn-primary pull-right">View Cart</a>
    <div class="clearfix"></div>
<?php }?>
 </div>
