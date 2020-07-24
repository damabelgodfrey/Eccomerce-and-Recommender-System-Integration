<style>
.closebtn.closemycart {
  position: absolute;
  top: 0;
  right: 25px;
  font-size: 36px;
  margin-left: 50px;
  color: red;
}
@media (min-width: 768px) {
	.closebtn.closemycart {
    top: 25px;
	}
	}
</style>

<div class="panel panel-default">
<div class="panel-heading text-center">
<a href ="cart" class="btn btn-block btn-primary ">Goto Shopping Bag</a>
<a href="javascript:void(0)" class="closebtn closemycart pull-right" onclick="closecart()">&times;</a>

</div>
<?php
$paid = 0;
$return = 0;
if(isset($user_name)){
$cartQ = $db->query("SELECT * FROM cart WHERE username = '{$user_name}' AND paid = '{$paid}' ");
$return = mysqli_num_rows($cartQ);
}
  if($return != 1){ ?>

    <div class="bg-danger">
      <p class="text-center text-info">
        Your shopping Cart is empty!
      </p>
    </div>
    <?php
  }else{
        $results = mysqli_fetch_assoc($cartQ);
        $_SESSION['cartid'] = $results['id']; // id of the cart
        $items = json_decode($results['items'],true);

        $sub_total = 0;
        ?>

            <table class="table " id="cart_widget" >
            <tbody>
            <?php foreach($items as $item):
            $productQ = $db->query("SELECT * FROM products WHERE id = '{$item['id']}' ");
            $product = mysqli_fetch_assoc($productQ);
            ?>
            <tr>
              <td>
                <div class=" fotorama" data-height="60px"data-width="70px">
                    <?php $photos = explode(',', $product['image']); //multiple image is seperated by ,
                    foreach($photos as $photo): ?>
                      <img src="<?= $photo; ?>" alt="<?= $product['title']; ?>">
              <?php endforeach; ?>
                </div>
              </td>
            <td>
              <div>
             (<?=$item['quantity'];?>) <?=substr($product['title'],0,15);?>
            <?=money($item['quantity'] * (int)$item['price']);?></td>
            <div>
            </tr>
            <?php
            $sub_total += ($item['quantity'] * (int)$item['price']);
            ?><?php
             endforeach; ?>
             <button  class="btn btn-block btn-default ">Sub Total <?=money($sub_total);?></button>
             </tbody>
            </table>

<?php }?>
 </div>
