<?php
require_once $_SERVER['DOCUMENT_ROOT'].'/ecommerce/recommender/controller/UserItemRatingMatrix.php';
require_once $_SERVER['DOCUMENT_ROOT'].'/ecommerce/recommender/controller/ItemFeatureSimComputation.php';
require_once $_SERVER['DOCUMENT_ROOT'].'/ecommerce/recommender/controller/PredictionController.php';
/**
 *
 */
class ItemBasedCollaborativeFiltering
{
private static $sim;
private static $ItemPeerGroups = array();
private static $userItemRatingMatrix = array();
public static $sim_Rating_product =array();
public static $simSummation =array();
public static function getUserMetrix($user_name){
    $type ="User";
    $userItemRatingMatrix =UserItemRatingMatrix::createRatingMatrix($type,$user_name);
    self::$userItemRatingMatrix;
    return $userItemRatingMatrix;
  }
  //get item id
  //compute similarity of each item to the item id
  // keep top 5 item.
  //if similar item exist in array remove the item with lower score and retain higher score item.
  //foreach of the top 5 item compute the prediction using the item id rating and the sim score and return an array with items
  // id and sim score
public static function computeItemSimilarity($user_name){
   $userItemRatingMatrix = self::getUserMetrix($user_name);
   $simAlgorithm ="CosineSimilarityRatingTagWeighted";
   $EmptyArray =array(); //compares product ID rated by user to all other product.
  foreach ($userItemRatingMatrix as $username => $idArray) {
    foreach ($idArray as $id => $rating){
    $ItemPeerGroup = ItemFeatureSimComputation::getFeatureSimCoefficient($simAlgorithm,$EmptyArray,$id,$rating);
    $ItemPeerGroup = array_slice($ItemPeerGroup, 0, 5, true); //pick top 5
      $ItemPeerGroups[$id.'?'.$rating]=  $ItemPeerGroup;
    }
      //compute prediction sim*rating/$sim
      self::prediction($ItemPeerGroups);
  }
  self::$ItemPeerGroups = $ItemPeerGroups;
  $A3 = self::computeRatingPrediction($user_name);
  return $A3;
  }
  public static function prediction($ItemPeerGroups){
  //$sim = $similarity;
  foreach ($ItemPeerGroups as $current_item_id => $ItemPeerGroup) {
    $id_rating = explode('?',$current_item_id);
    $rating = (int)$id_rating[1];
    $id = (int)$id_rating[0];
    $obj = new ProductController();
    foreach ($ItemPeerGroup as $other_item_id => $similarity) {
      //var_dump($similarity); die(); itemRating * rating/sd(itemRating,rating)
      //prediction uses the weigted average of rating of the user for set of similar items and the avarage rating of individual item .
      $itemAverageRating = $obj->getProduct($other_item_id);
      if(count($itemAverageRating) == 1){
        if($itemAverageRating[0]['product_average_rating'] != " "){
          $otheritemAveRating =(double)$itemAverageRating[0]['product_average_rating'];
          $finalWeightedRating = ($rating * 0.75) + ($otheritemAveRating * 0.25);
        }else{
          $finalWeightedRating = $rating;
        }
      }else{
        $finalWeightedRating = $rating;
      }
        if(!array_key_exists($id,self::$sim_Rating_product)){
          self::$sim_Rating_product[$id] = 0;
        }
        self::$sim_Rating_product[$id]+=$finalWeightedRating*$similarity;
        if(!array_key_exists($id,self::$simSummation)){
          self::$simSummation[$id] = 0;
        }
        self::$simSummation[$id]+=$similarity;
      }
    }
  }
//compute summation of Sim*RU1/sum of simmilarity
  public static function computeRatingPrediction($user_name){
    $itemRatingPredictionArray = array();
    $sim_Rating_product =self::$sim_Rating_product;
    $simSummation= self::$simSummation;
    foreach ($sim_Rating_product as $key => $value) {
      if($simSummation[$key] != 0){
        $itemRatingPredictionArray[$key]= to2Decimal($value/$simSummation[$key]);
      }

    }
    //RootMeanSquareEstimation::computeRootMeanSqEst($itemRatingPredictionArray);
    //pass peer predicted rating to all items in each similar peer group.
    arsort($itemRatingPredictionArray);
    $ItemPrediction = array();
    $ItemPeerGroups =self::$ItemPeerGroups;
    foreach ($itemRatingPredictionArray as $p_id => $predictedRating) {
      foreach ($ItemPeerGroups as $other_item_id => $ItemPeerGroup) {
        //echo "<pre>";
       //  var_dump($predictedRating);
       //  var_dump($other_item_id);
       $_id_rating = explode('?',$other_item_id);
       $_id = $_id_rating[0];
          if($_id+0 == $p_id+0){
         foreach ($ItemPeerGroup as $id => $similarity) {

             if(!array_key_exists($id,$ItemPrediction)){ //if an item appear in multiple item group assign the higher rating
               $ItemPrediction[$id] = $predictedRating;
             }else{
               if($ItemPrediction[$id]+0 < $predictedRating+0){
                 $ItemPrediction[$id] = $predictedRating;
               }
             }
           }

         }
      }
    }
    debugfilewriter("Item Item Collaborative Filtering Results\n");
    debugfilewriter("User Rating Matrix");
    $y =self::$userItemRatingMatrix;
    debugfilewriter($y);
    debugfilewriter("Item Peer Group");
    debugfilewriter($ItemPeerGroups);
    debugfilewriter("Final Rating");
    debugfilewriter($ItemPrediction);
    $FinalItemPrediction = array_slice($ItemPrediction, 0, 10, true); //upto 10 top rated item
    //write to database
    $predictObj = new PredictionController();
    $predictObj ->insertCFComputation("itemBasedCF", $user_name, $FinalItemPrediction);
  return $FinalItemPrediction;
  }
}
