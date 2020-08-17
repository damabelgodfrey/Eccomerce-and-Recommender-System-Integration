<?php
require_once $_SERVER['DOCUMENT_ROOT'].'/ecommerce/recommender/controller/UserItemRatingMatrix.php';
require_once $_SERVER['DOCUMENT_ROOT'].'/ecommerce/recommender/controller/ItemFeatureSimComputation.php';
 $predictionFlag =0;
 $finalPredictionArray = array();
 $rObj= new RatingController();
 $userRating = $rObj->getRatings($user_name);
 $today = date("Y-m-d");
 if(count($userRating)==1){
   if($userRating[0]['cf_last_updated'] == $today){ //Runs prediction once per day
     $predictionFlag =1;
   }
 }
 if($predictionFlag == 1){
   foreach ($userRating as $rating) {
     $predictions = json_decode($rating['predicted_rating'],true);
     foreach ($predictions as $key => $prediction){
      $finalPredictionArray[$prediction['product_id']] = $prediction['predict_rating'];
     }
   }
 }else{
  $userItemRatingMatrix =UserItemRatingMatrix::createRatingMatrix();
  $simAlgorithm = "CosineSimilarity";
  $A1 = CollaborativeRatingPredictionA1::getPredict($simAlgorithm,$userItemRatingMatrix, $user_name);
  $A2 = CollaborativeRatingPredictionA2::getPredict($simAlgorithm,$userItemRatingMatrix, $user_name);
  foreach ($A1 as $key => $value) {
    $finalPredictionArray[$key]= to2Decimal(($value + $A2[$key])/2);
  }
  debugfilewriter($A1);
  debugfilewriter($A2);
  debugfilewriter($finalPredictionArray);
  $rObj2 = new RatingController();
  $rObj2->insertCFComputation("prediction", $user_name, $finalPredictionArray);
}
$simAlgorithm ="CosineSimilarityRatingTagWeighted";
$recommendedArrayCSimilairity =ItemFeatureSimcomputation::getFeatureSimCoefficient($simAlgorithm,$finalPredictionArray,$id);//compute content similarity between predicted user item and clicked product

$displayFinalPredict = FinalCompositePrediction($finalPredictionArray,$recommendedArrayCSimilairity);
debugfilewriter($finalPredictionArray);
debugfilewriter($recommendedArrayCSimilairity);
debugfilewriter($displayFinalPredict);
$obj = new ProductController();
$recommended = $obj->getRecommendedCProduct($displayFinalPredict);
//$recommended = getRecommendedProduct($db,$recommendedArray);
$return = count($recommended);
if($return > 0){ ?>
        <div class="col-md-12">
        <div class="panel panel-default">
        <div class="panel-heading text-center"><h3>⇩ Final recommendation ⇩</h3>
        </div>
        <div class="panel-body">
            <div class="posts_list">
                <?php foreach ($recommended as $product) :
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
  <div class="bg-info">
    <p class="text-center text-info">
      No recommendation made at this time!
    </p>
  </div>
<?php } ?>
<?php
$obj = new ProductController();
$recommended = $obj->getRecommendedCProduct($finalPredictionArray);
//$recommended = getRecommendedProduct($db,$recommendedArray);
$return = count($recommended);
if($return > 0){ ?>
        <div class="col-md-12">
        <div class="panel panel-default">
        <div class="panel-heading text-center"><h3>⇩ Similar Users Also Purchase ⇩</h3>
        </div>
        <div class="panel-body">
            <div class="posts_list">
                <?php foreach ($recommended as $product) :
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
  <div class="bg-info">
    <p class="text-center text-info">
      No recommendation made at this time!
    </p>
  </div>
<?php } ?>
