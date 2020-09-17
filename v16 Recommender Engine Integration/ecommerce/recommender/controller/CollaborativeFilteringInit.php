<?php
require_once $_SERVER['DOCUMENT_ROOT'].'/ecommerce/recommender/controller/UserItemRatingMatrix.php';
require_once $_SERVER['DOCUMENT_ROOT'].'/ecommerce/recommender/controller/ItemFeatureSimComputation.php';
/**
 *Intialise the item based and user based collaborative filtering.
 */
class CollaborativeFilteringInit
{
  private static $run_interval = RECOMMENDER_ENGINE_INTERVAL;
  const PREDICTION_ALGORITHM_VARIANT = "A2";
  const RATING_MATRIX_TYPE = "not_nomalised";
  public static function getUserRatingMetrix($user_id){
    $currentUserItemRatingMatrix =UserItemRatingMatrix::createRatingMatrix("User",$user_id);
    return $currentUserItemRatingMatrix;
  }
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
       return $finalPredictionArray;
     }else{

      if(self::RATING_MATRIX_TYPE == "normalised"){
        $userItemRatingMatrix =UserItemRatingMatrix::normalisedMeanRatingMatrix("AllUser");
      }else{
        $userItemRatingMatrix =UserItemRatingMatrix::createRatingMatrix("AllUser",0);
      }
      $currentUserItemRatingMatrix = self::getUserRatingMetrix($user_id);
      if(count($currentUserItemRatingMatrix) ==1){ //check if user has existing rating
        $simAlgorithm = "CosineSimilarity";
        $PredictionAlgoVariant = self:: PREDICTION_ALGORITHM_VARIANT;
        if($PredictionAlgoVariant == "A1"){
          $finalPredictionArray = UserBasedCollaborativeFiltering::getPredict($simAlgorithm,$PredictionAlgoVariant,$userItemRatingMatrix, $user_id);
          debugfilewriter("\n Prediction form Algorithm A1 Results\n");
        }else{
          $finalPredictionArray = UserBasedCollaborativeFiltering::getPredict($simAlgorithm,$PredictionAlgoVariant,$userItemRatingMatrix, $user_id);
          debugfilewriter("\n Prediction form Algorithm A2 Results\n");
        }
        debugfilewriter($finalPredictionArray);
        $pObj2 = new PredictionController();
        $pObj2->insertCFComputation("userBasedCF", $user_id, $finalPredictionArray);
        return $finalPredictionArray;
      }else{
        return false;
      }
    }
  }

 public static function Recommend($user_id,$finalPredictionArray,$clickedItem_id){
   $finalCPrediction =array();
   $recommended = array();
   if(count($finalPredictionArray) != 0){
      $simAlgorithm ="CosineSimilarityRatingTagWeighted";
    //compute the similarity between all user predicted item to the item clicked by the user
     $recommendedArrayCSimilairity =ItemFeatureSimcomputation::getFeatureSimCoefficient("CollaborativeFilteringInit",$simAlgorithm,$finalPredictionArray,$clickedItem_id);//compute content similarity between final predicted items and clicked product
    //takes user item rating collaborative Filtering result and similarity score to item on user view
    // to compute final weighted score.
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
   }else{
    return $recommended;
   }
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
      $userM = self::getUserRatingMetrix($user_id);
      if(count($userM)!= 0){
        $userItemRatingMatrix = array();
        foreach ($userM as $user_id => $itemRating) {
          foreach ($itemRating as $item_id => $rating) {
            $userItemRatingMatrix[$item_id]= $rating;
          }
        }
        $itemUserCF = ItemBasedCollaborativeFiltering::computeItemBasedCF($user_id,$userItemRatingMatrix);
        }
     }
     return $itemUserCF;
  }
  }
