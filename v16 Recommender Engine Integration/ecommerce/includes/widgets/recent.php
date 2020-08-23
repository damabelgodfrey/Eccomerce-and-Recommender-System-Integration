<?php
$transQ = $db->query("SELECT * FROM cart ORDER BY id DESC LIMIT 3");
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
<div class="col-md-9" >
  <div class="row">
        <h2 class="text-center">⇩Ameritinz Trending Product⇩</h2>
    <?php foreach ($used_ids as $id):
      $productQ = $db->query("SELECT * FROM products WHERE id='{$id}'");
      ?>
            <?php while ($productT = mysqli_fetch_assoc($productQ)) : ?>
                 <div class="col-xs-4 padding-index" id = detailLabel>
                   <div class="polaroid text-center">
                     <h4><?= $productT['title']; ?></h4>
                     <?php $Tphotos = explode(',',$productT['image']); ?>
                    <img onclick="detailsmodal(<?= $productT['id']; ?>)" src="<?= $Tphotos[0]; ?>" alt="<?= $productT['title']; ?>" class="img-thumb" style="width:100%"/>
                    <p></p>
                    <button type ="button" class="btn btn-sm btn-danger" onclick="detailsmodal(<?= $productT['id']; ?>)">SHOP TRENDING</button>
                 </div>
                 </div>
           <?php endwhile; ?>

      <?php endforeach;?>

    </div>
    </div>
  <!--
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
</div> -->
