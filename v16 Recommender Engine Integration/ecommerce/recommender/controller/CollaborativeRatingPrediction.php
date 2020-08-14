<?php
require_once $_SERVER['DOCUMENT_ROOT'].'/ecommerce/recommender/controller/EuclideanDistance.php';
require_once $_SERVER['DOCUMENT_ROOT'].'/ecommerce/recommender/controller/CollaboratingF_CosineSimilarity.php';
require_once $_SERVER['DOCUMENT_ROOT'].'/ecommerce/recommender/controller/CollaboratingF_AdjustedCosineSimilarity.php';
require_once $_SERVER['DOCUMENT_ROOT'].'/ecommerce/recommender/controller/PearsonCorrelation.php';
/**
 *
 */
class CollaborativeRatingPrediction
{

  private static $similarity;
  private static $total = array();
  private static $simsums = array();

  public static function prediction($ExistingMatrix,$user,$otherUser){
  $sim = self::$similarity;
  foreach($ExistingMatrix[$otherUser] as $key=>$value){
    if(!array_key_exists($key,$ExistingMatrix[$user])){
      if(!array_key_exists($key,self::$total)){
        self::$total[$key] = 0;
      }

      self::$total[$key]+=$ExistingMatrix[$otherUser][$key]*$sim;
      if(!array_key_exists($key,self::$simsums)){
        self::$simsums[$key] = 0;
      }
      self::$simsums[$key]+=$sim;
    }
  }
  }

  public static function computeRatingPrediction(){
    $itemRatingPredictionArray = array();
    $total =self::$total;
    $simsums= self::$simsums;
    foreach ($total as $key => $value) {
      if($simsums[$key] != 0){
        $itemRatingPredictionArray[$key]= $value/$simsums[$key];
      }

    }
    arsort($itemRatingPredictionArray);
    debugfilewriter("\nComputed Item User Rating Prediction Collaborative Filtering\n");
    //debugfilewriter($itemRatingPredictionArray);
    RootMeanSquareEstimation::computeRootMeanSqEst($itemRatingPredictionArray);
  return $itemRatingPredictionArray;
  }

  public static function getPredict($allUserMatrix, $currentUser){
    self:: $total = array();
    self::$simsums =array();
    foreach($allUserMatrix as $otherUser =>$value){
      if($otherUser !=$currentUser){
  //   self::$similarity = EuclideanDistance::computeEuclideanDistance($allUserMatrix,$currentUser,$otherUser);
    self::$similarity = CollaboratingF_CosineSimilarity::computeF_CosineSimilarity($allUserMatrix,$currentUser,$otherUser);
    //self::$similarity = PearsonCorrelation::my_pearson_correlation2($allUserMatrix,$currentUser,$otherUser);
    //self::$similarity = CollaboratingF_AdjustedCosineSimilarity::conputeF_adjustedCosineSimilarity($allUserMatrix,$currentUser,$otherUser);
      self::prediction($allUserMatrix,$currentUser,$otherUser);

      debugfilewriter("\nUser Similarity Coefficient".' '.$otherUser.' '.self::$similarity);
      }
    }

  return self::computeRatingPrediction();

   }
}
