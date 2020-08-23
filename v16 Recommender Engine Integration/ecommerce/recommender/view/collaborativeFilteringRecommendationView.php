<?php
require_once $_SERVER['DOCUMENT_ROOT'].'/ecommerce/recommender/controller/CollaborativeFilteringInit.php';
//require_once $_SERVER['DOCUMENT_ROOT'].'/ecommerce/recommender/controller/ItemFeatureSimComputation.php';
//user based
 $recommendedUserBasedCF = CollaborativeFilteringInit::userBasedCFinit($user_id);
 $recommendedItemBasedCF = CollaborativeFilteringInit::itemBasedCFinit($user_id);

 $recommendedOnClickedItemBased = CollaborativeFilteringInit::Recommend($user_id,$recommendedItemBasedCF,$id);
 //$recommendedOnClickedUserBased = CollaborativeFilteringInit::Recommend($user_name,$recommendedUserBasedCF,$id);

//$recommended = getRecommendedProduct($db,$recommendedArray);
$return = count($recommendedOnClickedItemBased);
if($return > 0){ ?>
        <div class="col-md-12">
        <div class="panel panel-default">
        <div class="panel-heading text-center"><h3>⇩ Final recommendation⇩</h3>
        </div>
        <div class="panel-body">
            <div class="posts_list">
                <?php foreach ($recommendedOnClickedItemBased as $product) :
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
$recommendedUserBased = $obj->requestGroupProduct($recommendedUserBasedCF);
//$recommended = getRecommendedProduct($db,$recommendedArray);
$return = count($recommendedUserBased);
if($return > 0){ ?>
        <div class="col-md-12">
        <div class="panel panel-default">
        <div class="panel-heading text-center"><h3>⇩ Similar Users Also Purchase ⇩</h3>
        </div>
        <div class="panel-body">
            <div class="posts_list">
                <?php foreach ($recommendedUserBased as $product) :
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
$ItemCFRecommended = $obj->requestGroupProduct($recommendedItemBasedCF);
$return = count($ItemCFRecommended);
if($return > 0){ ?>
        <div class="col-md-12">
        <div class="panel panel-default">
        <div class="panel-heading text-center"><h3>⇩ Recommendation Based on Item you have Rated Before ⇩</h3>
        </div>
        <div class="panel-body">
            <div class="posts_list">
                <?php foreach ($ItemCFRecommended as $product) :
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
