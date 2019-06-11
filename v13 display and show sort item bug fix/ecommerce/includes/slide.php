<?php
//
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
} ?>
<div class="clearfix"></div>
<div class="bar-top">
<h3 class="text-center">  ⇩TRENDING⇩</h3>
<div id="my-slider" class="carousel slide" data-ride="carousel">
  <ol class="carousel-indicators">
    <li data-target="#my-slider" data-slide-to="0" class="active"></li>
    <li data-target="#my-slider" data-slide-to="1"></li>
    <li data-target="#my-slider" data-slide-to="2"></li>
    <li data-target="#my-slider" data-slide-to="3"></li>
    <li data-target="#my-slider" data-slide-to="4"></li>
  </ol>
<div class="carousel-inner" role="listbox" id="myCarousalIndexsidebar">
  <?php $init = "item active";
foreach ($used_ids as $id):
  $productQ = $db->query("SELECT * FROM products WHERE id='{$id}'");
  $productT = mysqli_fetch_assoc($productQ);
  $Tphotos = explode(',',$productT['image']); ?>
                 <div class="<?=$init?> animation">
                   <img onclick="detailsmodal(<?= $productT['id'] ?>)" src="<?=(isset($Tphotos[0])?$Tphotos[0]:'');?>">
                     <div class="carousel-caption">
                       <h1><?=(isset($productT['title'])?'':'');?></h1>
                       <button type ="button" id="dbuttoncarousal" class="btn btn-sm btn-danger" onclick="detailsmodal(<?= $productT['id'] ?>)">SHOP</button>
                     </div>
                 </div>

       <?php $init ="item" ?>
  <?php endforeach; ?>
</div>
  <!-- Controls or next and prev buttons -->
  <a class="left carousel-control" href="#my-slider" role="button" data-slide="prev">
    <span class="glyphicon glyphicon-chevron-left"></span>
    <span class="sr-only">Previous</span>
  </a>
  <a class="right carousel-control" href="#my-slider" role="button" data-slide="next">
    <span class="glyphicon glyphicon-chevron-right"></span>
    <span class="sr-only">Next</span>
  </a>

  </div>
</div>
