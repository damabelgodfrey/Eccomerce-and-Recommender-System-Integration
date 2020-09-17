<?php
require_once $_SERVER['DOCUMENT_ROOT'].'/ecommerce/recommender/controller/algorithms/EuclideanDistance.php';
require_once $_SERVER['DOCUMENT_ROOT'].'/ecommerce/recommender/controller/algorithms/RatingBasedCosineSimilarity.php';
require_once $_SERVER['DOCUMENT_ROOT'].'/ecommerce/recommender/controller/algorithms/CF_AdjustedCosineSimilarity.php';
require_once $_SERVER['DOCUMENT_ROOT'].'/ecommerce/recommender/controller/algorithms/PearsonCorrelation.php';
require_once $_SERVER['DOCUMENT_ROOT'].'/ecommerce/recommender/controller/PredictionController.php';
/**
 *
 */
class UserBasedCollaborativeFiltering
{

  private static $similarity;
  private static $sim_Rating_product = array();
  private static $simSummation = array();
  private static $userMeanRating;
  public static function getPredict($simAlgorithm,$PredictionAlgoVariant,$allUserMatrix, $currentUser){
  self:: $sim_Rating_product = array();
  self::$simSummation =array();
  $userSimilarityArr = array();
  if(isset($allUserMatrix[$currentUser])){
    foreach($allUserMatrix as $otherUser =>$value){
      if($otherUser !=$currentUser){
        switch ($simAlgorithm) {
          case 'CosineSimilarity':
            self::$similarity = RatingBasedCosineSimilarity::computeF_CosineSimilarity($allUserMatrix,$currentUser,$otherUser);
            break;

          case 'EuclideanDistance':
            self::$similarity = EuclideanDistance::computeEuclideanDistance($allUserMatrix,$currentUser,$otherUser);
            break;

          case 'PearsonCorrelation':
            self::$similarity = PearsonCorrelation::my_pearson_correlation2($allUserMatrix,$currentUser,$otherUser);
            break;

          case 'AdjustedCosineSim':
            self::$similarity = CF_AdjustedCosineSimilarity::conputeF_adjustedCosineSimilarity($allUserMatrix,$currentUser,$otherUser);
            break;

          default:
            break;
        }
        if ($PredictionAlgoVariant == "P1" ) {
          self::predictionP1($allUserMatrix,$currentUser,$otherUser);

        } else {
          self::predictionP2($allUserMatrix,$currentUser,$otherUser);

        }

      debugfilewriter("\nUser Similarity Coefficient ".' '.$otherUser.' '.self::$similarity);
      if(self::$similarity != 0){ // store only similar user
        $userSimilarityArr[$otherUser] = self::$similarity;
       }
      }
    }
  }
  if ($PredictionAlgoVariant == "P1" ) {

    $prediction = self::computeRatingPredictionP1();
  }else{
    $prediction = self::computeRatingPredictionP2();
  }
    $SC = new PredictionController();
    arsort($userSimilarityArr);
    $SC->insertCFComputation("UserBasedNearestNeigbour", $currentUser, $userSimilarityArr); //insert nearest neighbour to database
    return $prediction;
  }
   // compute the summation of the product of other user rating and similarity between this user and other user
   //compute the summaration of the similarity
   //Sim*RU1 and sum of simmilarity
  public static function predictionP1($ExistingMatrix,$currentUser,$otherUser){
  $sim = self::$similarity;
  if(isset($ExistingMatrix[$currentUser])){
    foreach($ExistingMatrix[$otherUser] as $key=>$value){
      if(!array_key_exists($key,$ExistingMatrix[$currentUser])){
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
  }
//compute summation of Sim*RU1/sum of simmilarity
  public static function computeRatingPredictionP1(){
    $itemRatingPredictionArray = array();
    $sim_Rating_product =self::$sim_Rating_product;
    $simSummation= self::$simSummation;
    foreach ($sim_Rating_product as $key => $value) {
      if($simSummation[$key] != 0){
        $itemRatingPredictionArray[$key]= to2Decimal($value/$simSummation[$key]);
      }

    }
    arsort($itemRatingPredictionArray);
    RootMeanSquareEstimation::computeRootMeanSqEst($itemRatingPredictionArray);
  return $itemRatingPredictionArray;
  }

  public static function computeRatingPredictionP2(){
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
    debugfilewriter("\nRoot Mean Sqaure Estimation A2\n");
    RootMeanSquareEstimation::computeRootMeanSqEst($itemRatingPredictionArray);
    return $itemRatingPredictionArray;
  }

  public static function predictionP2($ExistingMatrix,$currentUser,$otherUser){
  $sim = self::$similarity;
    $otherUserCounter=0;
    $otherUserTotalRating = 0;
    $userCounter = 0;
    $userTotalRating = 0;
    if(isset($ExistingMatrix[$currentUser])){ //check if current user has a rating in user metrix
      foreach($ExistingMatrix[$otherUser] as $key=>$value){
        $otherUserTotalRating +=$value; //total of other user all ratings
        $otherUserCounter++;
       }
      foreach($ExistingMatrix[$currentUser] as $key=>$value){
        $userTotalRating +=$value;
        $userCounter++;
      }
        $otherUserRatingMean = $otherUserTotalRating/$otherUserCounter; // user mean rating
        self::$userMeanRating = $userTotalRating/$userCounter;
      foreach($ExistingMatrix[$otherUser] as $key=>$value){
        if(!array_key_exists($key,$ExistingMatrix[$currentUser])){
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
  }
}
