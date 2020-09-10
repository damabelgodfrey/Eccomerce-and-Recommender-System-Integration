<?php
/**
*
 */
class RatingBasedCosineSimilarity
{
  //compute cosine similarity using user rating
  public static function computeF_CosineSimilarity($matrix,$currentUser,$otherUser){
    $similarRatingGrid = array();
    $sumxx = 0;
    $sumxy = 0;
    $sumyy = 0;
    if(isset($matrix[$currentUser])){
      foreach ($matrix[$currentUser] as $key => $currentURating) { //check if user have rated a product also purchased by user2
        if(array_key_exists($key,$matrix[$otherUser])){
            $similarRatingGrid[$key] = $currentURating;
        }
      }
      if(count($similarRatingGrid) ==0){
        return 0;
      }else{
        foreach ($matrix[$currentUser] as $key => $currentUserRating) {
          if(array_key_exists($key,$matrix[$otherUser])){
               $otherUserRating = $matrix[$otherUser][$key];
               $currentUserRatingProduct = pow($currentUserRating,2);
               $otherUserRatingProduct = pow($otherUserRating,2);
               $xy = $currentUserRating * $otherUserRating;
               $sumxx += $currentUserRatingProduct;
               $sumyy += $otherUserRatingProduct;
               $sumxy += +$xy;
          }
        }
      }

     return $sumxy/(sqrt($sumxx * $sumyy));
    }else{
      return false;
    }
 }
}
