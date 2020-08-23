<?php
require_once $_SERVER['DOCUMENT_ROOT'].'/ecommerce/recommender/controller/UserItemRatingMatrix.php';
require_once $_SERVER['DOCUMENT_ROOT'].'/ecommerce/recommender/controller/ItemFeatureSimComputation.php';
/**
 *Intialise the item based and user based collaborative filtering.
 */
class CollaborativeFilteringInit
{
private static $run_interval = RECOMMENDER_ENGINE_INTERVAL;
  public static function userBasedCFinit($user_id){
    //user based
    $run_interval = self::$run_interval;
     $predictionFlag =0;
     $finalPredictionArray = array();
     $pObj= new PredictionController();
     $prediction = $pObj->getPrediction($user_id);
     if(count($prediction)==1){
       if($prediction[0]['user_based_last_updated'] == $run_interval){ //Runs prediction once per day
         $predictionFlag =1;
       }
     }
     if($predictionFlag == 1){
       foreach ($prediction as $predict) {
         $predictions = json_decode($predict['user_based_prediction'],true);
         foreach ($predictions as $key => $prediction){
          $finalPredictionArray[$prediction['product_id']] = $prediction['predicted_rating'];
         }
       }
     }else{
       $type = "AllUser";
      $userItemRatingMatrix =UserItemRatingMatrix::createRatingMatrix($type,$user_id);
      $simAlgorithm = "CosineSimilarity";
      $A1 = UserBasedCollaborativeFilteringA1::getPredict($simAlgorithm,$userItemRatingMatrix, $user_id);
      $A2 = UserBasedCollaborativeFilteringA2::getPredict($simAlgorithm,$userItemRatingMatrix, $user_id);
      foreach ($A1 as $key => $value) {
        $finalPredictionArray[$key]= to2Decimal(($value + $A2[$key])/2);
      }
      debugfilewriter("\nAlgorithm One Results\n");
      debugfilewriter($A1);
      debugfilewriter("\nAlgorithm Two Results\n"); 
      debugfilewriter($A2);
      debugfilewriter($finalPredictionArray);
      $pObj2 = new PredictionController();
      $pObj2->insertCFComputation("userBasedCF", $user_id, $finalPredictionArray);
    }
    return $finalPredictionArray;
  }

 public static function Recommend($user_id,$finalPredictionArray,$clickedItem_id){
    $simAlgorithm ="CosineSimilarityRatingTagWeighted";
    //compute the similarity between all user predicted item to the item clicked by the user
    $recommendedArrayCSimilairity =ItemFeatureSimcomputation::getFeatureSimCoefficient("CollaborativeFilteringInit",$simAlgorithm,$finalPredictionArray,$clickedItem_id);//compute content similarity between final predicted items and clicked product
    //takes user item rating collaborative Filtering result and similarity score to item on user view
    // to compute final weighted score.
      $finalCPrediction =array();
      $CFW = 0.5;
      $CSimScore = 0.5;
      foreach ($recommendedArrayCSimilairity as $key => $value) {
        if(array_key_exists($key,$finalPredictionArray)){
          $y = $value * $CSimScore;
          $x = $finalPredictionArray[$key] * $CFW;
          $finalCPrediction[$key] = to2Decimal($y+ $x);
        }
      }
    arsort($finalCPrediction);
    debugfilewriter("Predicted output\n");
    debugfilewriter($finalPredictionArray);
    debugfilewriter("\n Predicted Item similarity to item on current view (clicked item).' => '$clickedItem_id\n");
    debugfilewriter($recommendedArrayCSimilairity);
    debugfilewriter("\nFinal weighted Prediction\n");
    debugfilewriter($finalCPrediction);
    $obj = new ProductController();
    $recommended = $obj->requestGroupProduct($finalCPrediction);
    return $recommended;
  }
  public static function itemBasedCFInit($user_id){
    $run_interval = self::$run_interval;
    $predictionFlag =0;
    $itemUserCF = array();
    $pObj= new PredictionController();
    $prediction = $pObj->getPrediction($user_id);
    if(count($prediction)==1){
      if($prediction[0]['item_based_last_updated'] == $run_interval){ //Runs prediction engine at specified interval
        $predictionFlag =1;
      }
    }
    if($predictionFlag ==1){
      foreach ($prediction as $predict) {
        $predictions = json_decode($predict['item_based_prediction'],true);
        foreach ($predictions as $key => $prediction){
         $itemUserCF[$prediction['product_id']] = $prediction['predicted_rating'];
        }
      }
    }else{
    $itemUserCF = ItemBasedCollaborativeFiltering::computeItemSimilarity($user_id);
  }
    return $itemUserCF;
  }
}
