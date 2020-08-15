<?php
$transQ = $db->query("SELECT * FROM cart ORDER BY id DESC LIMIT 10");
$return = mysqli_num_rows($transQ);
  if($return > 0){
    $results=array();
    while($row = mysqli_fetch_assoc($transQ)){
      $results[] =$row;
    }
    $row_count = $transQ->num_rows;
    $used_ids = array();
    $counter = 0;
    ?><div id="" class=" my-slider carousel slide" data-ride="carousel">
      <ol class="carousel-indicators">
        <li data-target=".my-slider" data-slide-to="0" class="active"></li><?php
    for($i=0;$i<$row_count;$i++){
      $json_items = $results[$i]['items'];
      $items = json_decode($json_items,true);
      foreach ($items as $item) {
        if(!in_array($item['id'],$used_ids)){
          $used_ids[] = $item['id'];
          ?><li data-target=".my-slider" data-slide-to="<?=$counter;?>"></li><?php
          $counter++;
        }
      }
    } ?>

      </ol>
    <div class="carousel-inner" role="listbox" id="menuslide">
      <?php $init = "item active";
      $maxC =0;
    foreach ($used_ids as $id):
      if($maxC < 10){
      $productQ = $db->query("SELECT * FROM products WHERE id='{$id}' AND archive = 0 AND defective_product = 0 AND category_activate_flag =1");
      $return = mysqli_num_rows($productQ);
      if($return == 1){
      $productT = mysqli_fetch_assoc($productQ);
      $Tphotos = explode(',',$productT['image']); ?>
                     <div class="<?=$init?> animation text-center">
                       <img onclick="detailsmodal('add',<?= $productT['id'] ?>)" src="<?=(isset($Tphotos[0])?$Tphotos[0]:'');?>">
                         <div class="carousel-caption">
                           <h1><?=(isset($productT['title'])?'':'');?></h1>
                         </div>
                     </div>

           <?php $init ="item" ?>
      <?php } $maxC++; }endforeach;
      ?>
    </div>
      <!-- Controls or next and prev buttons -->


      </div>
  <?php } ?>
