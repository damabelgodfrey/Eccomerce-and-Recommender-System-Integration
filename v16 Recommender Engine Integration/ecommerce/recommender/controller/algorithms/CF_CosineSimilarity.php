<?php
/**
 *
 */
class CF_CosineSimilarity 
{
  //compute cosine similarity using user rating
  public static function computeF_CosineSimilarity($matrix,$user1,$Users2){
    $similarRatingGrid = array();
    $sumxx = 0;
    $sumxy = 0;
    $sumyy = 0;
    foreach ($matrix[$user1] as $key => $value) { //check if user has purchase a product also purchased by user2
      if(array_key_exists($key,$matrix[$Users2])){
          $similarRatingGrid[$key] = $value;
      }
    }
    if(count($similarRatingGrid) ==0){
      return 0;
    }else{
      foreach ($matrix[$user1] as $key => $user1Value) {
        if(array_key_exists($key,$matrix[$Users2])){
             $user1Pow = pow($user1Value,2);
             $user2Pow = pow( $matrix[$Users2][$key],2);
             $xy = $user1Value * $matrix[$Users2][$key];
             $sumxx += $user1Pow;
             $sumyy += $user2Pow;
             $sumxy += +  $xy;
        }
      }
    }

   return $sumxy/(sqrt($sumxx * $sumyy));
  }
}
