<?php
include "slideCarousalScriptCss.php";
<<<<<<< HEAD
$obj= new cartRepoController();
$transQ = $obj->selectAllCart();
$results=array();
foreach($transQ as $result){
  $results[] =$result;
}
$noOfrows = count($transQ);
$used_ids = array();
for($i=0;$i<$noOfrows;$i++){
=======
$transQ = $db->query("SELECT * FROM cart WHERE paid = 1 ORDER BY id DESC LIMIT 10");
$results=array();
while($row = mysqli_fetch_assoc($transQ)){
  $results[] =$row;
}
$row_count = $transQ->num_rows;
$used_ids = array();
for($i=0;$i<$row_count;$i++){
>>>>>>> 00946282fd0ced214a37681e144e38779b687dd4
  $json_items = $results[$i]['items'];
  $items = json_decode($json_items,true);
  foreach ($items as $item) {
    if(!in_array($item['id'],$used_ids)){
      $used_ids[] = $item['id'];
    }
  }
} ?>
<div class="container bar-top">
	<div class="row" >
      <h3 class="text-center">⇩Trending Products⇩</h3>
		<div class="MultiCarousel" data-items="2,3,4,4" data-slide="2" id="MultiCarousel"  data-interval="1000">
              <div class="MultiCarousel-inner">
              <?php foreach ($used_ids as $id):
                $productQ = $db->query("SELECT * FROM products WHERE id='{$id}' AND defective_product = 0 AND archive = 0 AND category_activate_flag =1");
                $return = mysqli_num_rows($productQ);
                if($return == 1){
                $productT = mysqli_fetch_assoc($productQ);
                $Tphotos = explode(',',$productT['image']); ?>
                <div class="item " >
                    <div class="pad15 imagecontainer animation polaroid text-center ">
                     <img onclick="detailsmodal('add',<?= $productT['id'] ?>)" src="<?=(isset($Tphotos[0])?$Tphotos[0]:'');?>"><p></p>
                     <p><strong><?=(isset($productT['title'])?$productT['title']:'');?></strong></p>
                  </div>
                  </div>

              <?php } endforeach; ?>
              </div>
            <button class="btn btn-danger leftLst"><<</button>
            <button class="btn btn-danger rightLst">>></button>
        </div>
	</div>
</div>
