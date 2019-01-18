<h3 class = "text-center">Trending Products</h3>
<?php
$transQ = $db->query("SELECT * FROM cart WHERE paid = 1 ORDER BY id DESC LIMIT 5");
$results=array();
while($row = mysqli_fetch_assoc($transQ)){
  $results[] =$row;
}
$row_count = $transQ->num_rows;
$used_ids = array();
for($i=0;$i<$row_count;$i++){
  $json_items = $results[$i]['items'];
  $items = json_decode($json_items,true);
  foreach ($items as $item) {
    if(!in_array($item['id'],$used_ids)){
      $used_ids[] = $item['id'];
    }
  }
}
?>
<div id="recent_widget">
  <table class="table table-condensed text-center">




    <?php foreach ($used_ids as $id):
      $productQ = $db->query("SELECT * FROM products WHERE id='{$id}'");
      $product = mysqli_fetch_assoc($productQ);
      ?>
    <tr>
      <td>
        <?=substr($product['title'],0,15);?>
        <img src="<?= $product['image']; ?>" alt="<?= $product['title']; ?>" onclick="detailsmodal(<?= $product['id']; ?>)" class="detailsrightbar img-responsive">
      </td>
      <td>
        <a class="text-primary" onclick="detailsmodal('<?=$id;?>')"><?=money($product['price']);?></a>
      </td>
    </tr>
  <?php endforeach;?>
</table>
</div>
  <div class="col-sm-20 fotorama ">
<?php foreach ($used_ids as $id):
  $productQ = $db->query("SELECT * FROM products WHERE id='{$id}'");
  $product = mysqli_fetch_assoc($productQ);
  ?>

  <?php $photos = explode(',', $product['image']); //multiple image is seperated by ,
  foreach($photos as $photo): ?>
  <img src="<?= $photo; ?>" alt="<?= $product['title']; ?>" onclick="detailsmodal(<?= $product['id']; ?>)" class="detailsrightbar img-responsive">
  <?php endforeach; ?>


<?php endforeach;?>
</div>
