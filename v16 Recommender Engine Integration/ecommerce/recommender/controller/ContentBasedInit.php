<?php
/**
 * compute recommendation from user profile at DateInterval or
 * fetch existing recommendation from for current user
 * @return product recommendation
 */
class ContentBasedInit {
 private static $run_interval = RECOMMENDER_ENGINE_INTERVAL;
 public static function requestRecommendation($user_id){
   $run_interval = self::$run_interval;
   $predictionFlag =0;
   $contentBasedP = array();
   $pObj= new PredictionController();
   $prediction = $pObj->getPrediction($user_id);
    if(count($prediction)==1){
      if($prediction[0]['content_based_last_updated'] == $run_interval){ //Runs prediction engine at specified interval
        $predictionFlag =1;
      }
    }
    if($predictionFlag ==1){
      foreach ($prediction as $predict) {
        $predictions = json_decode($predict['content_based_prediction'],true);
        foreach ($predictions as $key => $prediction){
         $contentBasedP[$prediction['product_id']] = $prediction['score'];
        }
      }
    }
     //  $contentBasedP = ContentBasedRecommenderEngine::computeContentBasedPrediction($user_id);
     //  $PC = new PredictionController();
     //  arsort($contentBasedP);
     // $PC->insertCFComputation("ContentBasedRecommender", $user_id, $contentBasedP); //insert prediction to database
    self::runContentBasedRecommendationEngine();
     return $contentBasedP;
  }

  public static function runContentBasedRecommendationEngine(){
    $recommendations = array();
    $updated_time = date("Y-m-d h:i:s", time());
    $uObj = new UserController();
    $Users = $uObj->getAllUser();
    foreach ($Users as $user) {
      $predicted_rating = ContentBasedRecommenderEngine::computeContentBasedPrediction($user['id']);
      if(count($predicted_rating) != 0){
        $recommendations[$user['id']] = $predicted_rating;
      }
    }
    $query = 'REPLACE INTO CBRecommendations VALUES';
    $query_parts = array();
    foreach ($recommendations as $userID => $prediction) {
      $query_parts[] = "('" . $userID . "', '" . $prediction . "', '" . $updated_time . "')";
     }
    $query .= implode(',', $query_parts);
    $PC = new PredictionController();
    $PC->insertContentbasedComputation($query); //insert or update prediction to database
  }
}
