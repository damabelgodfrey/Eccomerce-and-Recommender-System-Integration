<?php
require_once $_SERVER['DOCUMENT_ROOT'].'/ecommerce/recommender/controller/ContentBasedInit.php';
$EmptyArray = array();
$simAlgorithm ="LevenshteinDistance";
$return = 0;
if(!is_logged_in()){
$recommendedArray = ItemFeatureSimComputation::getFeatureSimCoefficient("contentBasedRecommendationView",$simAlgorithm,$EmptyArray,$id);
$obj = new ProductController();
$recommended = $obj->requestGroupProduct($recommendedArray); //fetch product recommended

 $wObj = new WeatherReporter();
 $wObj->getWeatherReport();
$return = count($recommended);
}else{
  $recommendedArray = ContentBasedInit::requestRecommendation($user_id);
  $obj = new ProductController();
  $recommended = $obj->requestGroupProduct($recommendedArray); //fetch product recommended
  $return = count($recommended);
}

if($return > 0){ ?>
        <div class="col-md-12">
        <div class="panel panel-default">
          <?php if(is_logged_in()) {
            ?> <div class="panel-heading text-center"><h3>⇩ Content Based => Based on previous item ⇩</h3> <?php
          }else {
            ?><div class="panel-heading text-center"><h3>⇩ You may also like ⇩</h3> <?php
          }?>

        </div>
        <div class="panel-body">
            <div class="posts_list">
                <?php foreach($recommended as $product) :
                $listP = (int)$product['list_price'];
                $actualP = (int)$product['price'];
                $perOff = ($listP - $actualP )/ $listP;
                $perOff = round($perOff * 100);
                $photos = explode(',',$product['image']);
                   ?>
                 <div class="col-xs-6 col-sm-5 col-md-4 padding-0 animation">
                   <div class="polaroid text-center">
                     <div class="product_title">
                       <h4><strong><?= $product['title']; ?></strong></h4>
                     </div>
                     <div class="imgHolder">
                       <img onclick="detailsmodal('add',<?= $product['id']; ?>)" src="<?= $photos[0]; ?>" alt="<?= $product['title']; ?>" class="img-thumb" style="width:100%"/>
                        <?php if ($product['sales'] == 1): ?>
                          <span>
                            <button type ="button" id="sales" class="btn btn-xs btn-danger pull-left" onclick="detailsmodal('add',<?= $product['id']; ?>)">Sales</button>
                          </span>
                       <?php endif; ?>
                     </div>
                    <p></p><p class="list-price"><s>$<?= $product['list_price']; ?></s></p>
                    <strong> <p class="price text-danger">$<?= $product['price']; ?> (<?= $perOff ?>% off)</p></strong>
                    <!--<button type ="button" id="dbutton" class="btn btn-sm btn-danger" onclick="detailsmodal(
                    <?= $product['id']; ?>)">Details</button> -->
                 </div>
                 </div>
               <?php endforeach;
             ?>
             </div>
    </div>
     <div class="panel-footer"><?php echo $return; ?></div>
    </div>
  </div>
<?php }else{ ?>
<?php } ?>
