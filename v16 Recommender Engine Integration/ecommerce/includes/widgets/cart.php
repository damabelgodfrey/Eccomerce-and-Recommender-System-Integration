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
<<<<<<< HEAD
$cartRepObj = new CartRepoController();
$cartQ = $cartRepObj->selectCart($user_name);
$return = count($cartQ);
=======
$cartQ = $db->query("SELECT * FROM cart WHERE username = '{$user_name}' AND paid = '{$paid}' ");
$return = mysqli_num_rows($cartQ);
>>>>>>> 00946282fd0ced214a37681e144e38779b687dd4
}
  if($return != 1){ ?>

    <div class="bg-danger">
      <p class="text-center text-info">
        Your shopping Cart is empty!
      </p>
    </div>
    <?php
  }else{
<<<<<<< HEAD
        foreach ($cartQ as $results) {
          $_SESSION['cartid'] = $results['id']; // id of the cart
          $items = json_decode($results['items'],true);
        }
=======
        $results = mysqli_fetch_assoc($cartQ);
        $_SESSION['cartid'] = $results['id']; // id of the cart
        $items = json_decode($results['items'],true);

>>>>>>> 00946282fd0ced214a37681e144e38779b687dd4
        $sub_total = 0;
        ?>

            <table class="table " id="cart_widget" >
            <tbody>
<<<<<<< HEAD
            <?php foreach($items as $item){
            //$productQ = $db->query("SELECT * FROM products WHERE id = '{$item['id']}' ");
            $prodObj = new ProductController();
            $productQ = $prodObj->getProduct($item['id']);
            foreach ($productQ as $product){
=======
            <?php foreach($items as $item):
            $productQ = $db->query("SELECT * FROM products WHERE id = '{$item['id']}' ");
            $product = mysqli_fetch_assoc($productQ);
>>>>>>> 00946282fd0ced214a37681e144e38779b687dd4
            ?>
            <tr>
              <td>
                <div class=" fotorama" data-height="60px"data-width="70px">
<<<<<<< HEAD
                    <?php

                      $photos = explode(',', $product['image']); //multiple image is seperated by ,
                      foreach($photos as $photo){ ?>
                        <img src="<?= $photo; ?>" alt="<?= $product['title']; ?>">
                <?php }
                  ?>
=======
                    <?php $photos = explode(',', $product['image']); //multiple image is seperated by ,
                    foreach($photos as $photo): ?>
                      <img src="<?= $photo; ?>" alt="<?= $product['title']; ?>">
              <?php endforeach; ?>
>>>>>>> 00946282fd0ced214a37681e144e38779b687dd4
                </div>
              </td>
            <td>
              <div>
             (<?=$item['quantity'];?>) <?=substr($product['title'],0,15);?>
<<<<<<< HEAD
            <?=money($item['quantity'] * (int)$item['price']);?>
            </div>
          </td>

            </tr>
            <?php
            $sub_total += ($item['quantity'] * (int)$item['price']);
            ?>
             <button  class="btn btn-block btn-default ">Sub Total <?=money($sub_total);?></button>
             <?php
           }}?>
=======
            <?=money($item['quantity'] * (int)$item['price']);?></td>
            <div>
            </tr>
            <?php
            $sub_total += ($item['quantity'] * (int)$item['price']);
            ?><?php
             endforeach; ?>
             <button  class="btn btn-block btn-default ">Sub Total <?=money($sub_total);?></button>
>>>>>>> 00946282fd0ced214a37681e144e38779b687dd4
             </tbody>
            </table>

<?php }?>
<<<<<<< HEAD
=======
 </div>
>>>>>>> 00946282fd0ced214a37681e144e38779b687dd4
