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
  private static $sim_Rating_product = array();
  private static $simSummation = array();
  private static $userMeanRating;

  public static function prediction1($ExistingMatrix,$user,$otherUser){
  $sim = self::$similarity;
  foreach($ExistingMatrix[$otherUser] as $key=>$value){
    if(!array_key_exists($key,$ExistingMatrix[$user])){
      if(!array_key_exists($key,self::$sim_Rating_product)){
        self::$sim_Rating_product[$key] = 0;
      }

      self::$sim_Rating_product[$key]+=$ExistingMatrix[$otherUser][$key]*$sim;
      if(!array_key_exists($key,self::$simSummation)){
        self::$simSummation[$key] = 0;
      }
      self::$simSummation[$key]+=$sim;
    }
  }
  }

  public static function computeRatingPrediction1(){
    $itemRatingPredictionArray = array();
    $sim_Rating_product =self::$sim_Rating_product;
    $simSummation= self::$simSummation;
    foreach ($sim_Rating_product as $key => $value) {
      if($simSummation[$key] != 0){
        $itemRatingPredictionArray[$key]= to2Decimal($value/$simSummation[$key]);
      }

    }
    arsort($itemRatingPredictionArray);
    debugfilewriter("\nComputed Item User Rating Prediction Collaborative Filtering 1\n");
    //debugfilewriter($itemRatingPredictionArray);
    RootMeanSquareEstimation::computeRootMeanSqEst($itemRatingPredictionArray);
  return $itemRatingPredictionArray;
  }

  public static function prediction2($ExistingMatrix,$user,$otherUser){
  $sim = self::$similarity;
    $otherUserCounter=0;
    $usertotalRating = 0;
    $userCounter = 0;
    $userTotalRating = 0;
    foreach($ExistingMatrix[$otherUser] as $key=>$value){
      $usertotalRating +=$value; //total of other user all ratings
      $otherUserCounter++;
     }
    foreach($ExistingMatrix[$user] as $key=>$value){
      $userTotalRating +=$value;
      $userCounter++;
    }
      $otherUserRatingMean = $usertotalRating/$otherUserCounter; // user mean rating
      self::$userMeanRating = $userTotalRating/$userCounter;
    foreach($ExistingMatrix[$otherUser] as $key=>$value){
      if(!array_key_exists($key,$ExistingMatrix[$user])){
        if(!array_key_exists($key,self::$sim_Rating_product)){
          self::$sim_Rating_product[$key] = 0;
        }
        $x = ($ExistingMatrix[$otherUser][$key]-$otherUserRatingMean)*$sim;
        self::$sim_Rating_product[$key]+=$x;
        if(!array_key_exists($key,self::$simSummation)){
          self::$simSummation[$key] = 0;
        }
        self::$simSummation[$key]+=$sim;
      }


    }
  }

  public static function computeRatingPrediction2(){
    $itemRatingPredictionArray = array();
    $sim_Rating_product =self::$sim_Rating_product;
    $simSummation= self::$simSummation;
    $userMeanR = self::$userMeanRating;
    foreach ($sim_Rating_product as $key => $value) {
      if($simSummation[$key] != 0){
        $itemRatingPredictionArray[$key]= to2Decimal($userMeanR +($value/$simSummation[$key]));
      }

    }
    arsort($itemRatingPredictionArray);
    debugfilewriter("\nComputed Item User Rating Prediction Collaborative Filtering 2\n");
    //debugfilewriter($itemRatingPredictionArray);
    RootMeanSquareEstimation::computeRootMeanSqEst($itemRatingPredictionArray);
    return $itemRatingPredictionArray;
  }


  public static function getPredict($allUserMatrix, $currentUser){
    self:: $sim_Rating_product = array();
    self::$simSummation =array();
     $rustart = getrusage();

    foreach($allUserMatrix as $otherUser =>$value){
      if($otherUser !=$currentUser){
  //   self::$similarity = EuclideanDistance::computeEuclideanDistance($allUserMatrix,$currentUser,$otherUser);
    self::$similarity = CollaboratingF_CosineSimilarity::computeF_CosineSimilarity($allUserMatrix,$currentUser,$otherUser);
    //self::$similarity = PearsonCorrelation::my_pearson_correlation2($allUserMatrix,$currentUser,$otherUser);
    //self::$similarity = CollaboratingF_AdjustedCosineSimilarity::conputeF_adjustedCosineSimilarity($allUserMatrix,$currentUser,$otherUser);
      self::prediction1($allUserMatrix,$currentUser,$otherUser);

      debugfilewriter("\nUser Similarity Coefficient".' '.$otherUser.' '.self::$similarity);
      }
    }
    $p1 = self::computeRatingPrediction1();

// Compute Algorithm 2
    self:: $sim_Rating_product = array();
    self::$simSummation =array();
    foreach($allUserMatrix as $otherUser =>$value){
      if($otherUser !=$currentUser){
  //   self::$similarity = EuclideanDistance::computeEuclideanDistance($allUserMatrix,$currentUser,$otherUser);
    self::$similarity = CollaboratingF_CosineSimilarity::computeF_CosineSimilarity($allUserMatrix,$currentUser,$otherUser);
    //self::$similarity = PearsonCorrelation::my_pearson_correlation2($allUserMatrix,$currentUser,$otherUser);
    //self::$similarity = CollaboratingF_AdjustedCosineSimilarity::conputeF_adjustedCosineSimilarity($allUserMatrix,$currentUser,$otherUser);
      self::prediction2($allUserMatrix,$currentUser,$otherUser);
      }
    }
    $ru = getrusage();
    echo "This process used " . rutime($ru, $rustart, "utime") .
        " ms for its computations\n";
    echo "It spent " . rutime($ru, $rustart, "stime") .
        " ms in system calls\n";
   $finalPredictionArray = array();
    $p2 = self::computeRatingPrediction2();
    foreach ($p1 as $key => $value) {
      $finalPredictionArray[$key]= to2Decimal(($value + $p2[$key])/2);
      // code...
    }
      debugfilewriter($p1);
      debugfilewriter($p2);
      debugfilewriter($finalPredictionArray);

  //  $p =($p1+$p2)/2;
  return $finalPredictionArray;

   }
}
