<?php
//  require_once 'core/init.php';
  $slideQ = $db->query("SELECT * FROM slide WHERE status = 1 ORDER BY id LIMIT 6");

//var_dump($slideTitle2);var_dump($url); die();
  ?>
  <div id="my-slider1" class="carousel slide" data-ride="carousel">
    <!-- indicators dot nov -->
    <ol class="carousel-indicators">
      <li data-target="#my-slider1" data-slide-to="0" class="active"></li>
      <li data-target="#my-slider1" data-slide-to="1"></li>
      <li data-target="#my-slider1" data-slide-to="2"></li>
      <li data-target="#my-slider1" data-slide-to="3"></li>
      <li data-target="#my-slider1" data-slide-to="4"></li>
      <li data-target="#my-slider1" data-slide-to="5"></li>
    </ol>

    <!-- Wrapper for slides -->
    <div class="carousel-inner" role="listbox" id="myCarousalIndex">
      <?php $init = "item active";
    while ($slide = mysqli_fetch_assoc($slideQ)){
      if($slide['flag'] == 1){
      $productQ = $db->query("SELECT id FROM products WHERE (title LIKE '%".$slide['url']."%' OR description LIKE '%".$slide['url']."%' OR p_keyword LIKE '%".$slide['url']."%') AND archive = 0 LIMIT 1");
      $product = mysqli_fetch_assoc($productQ);
      $product_id = $product['id']; ?>
    <?php } ?>
      <div class="<?=$init?> animation">
                 <?php if (isset($product_id) && $slide['flag'] == 1){?>
                 <img onclick="detailsmodal(<?= $product_id ?>)"src="<?=(isset($slide['image'])?$slide['image']:'');?>">
               <?php }else{ ?>
                 <a href="<?=(isset($slide['url'])?$slide['url']:'');?>"><img src="<?=(isset($slide['image'])?$slide['image']:'');?>"></a>
               <?php } ?>
                   <div class="carousel-caption">
                     <h1><?=(isset($slide['caption'])?'':'');?></h1>
                    <!-- <?php if (isset($product_id) && $slide['flag'] == 1){?>
                     <button type ="button" id="dbuttoncarousal" class="btn btn-sm btn-danger" onclick="detailsmodal(<?= $product_id ?>)">DETAILS</button>
                     <?php }else{ ?>
                       <a href="<?=(isset($slide['url'])?$slide['url']:'');?>" target=""><button type="button" class="btn btn-lg btn-secondary">View Details >></button></a>
                     <?php } ?> -->
                   </div>
               </div>
           <?php $init ="item" ?>
      <?php }?>
    </div>
    <!-- Controls or next and prev buttons -->
    <a class="left carousel-control" href="#my-slider1" role="button" data-slide="prev">
      <span class="glyphicon glyphicon-chevron-left"></span>
      <span class="sr-only">Previous</span>
    </a>
    <a class="right carousel-control" href="#my-slider1" role="button" data-slide="next">
      <span class="glyphicon glyphicon-chevron-right"></span>
      <span class="sr-only">Next</span>
    </a>


  </div>
