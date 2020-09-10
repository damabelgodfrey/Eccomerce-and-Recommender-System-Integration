<?php
/**
 *
 */
class EuclideanDistance
{
  //conpute similarity distance
  public static function computeEuclideanDistance($UserRatingMatrix, $user1,$Users2){
    $similar = array();
    $sum = 0;
    if(isset($UserRatingMatrix[$user1])){
      foreach ($UserRatingMatrix[$user1] as $key => $value) { //check if user has purchase a product also purchased by user2
        if(array_key_exists($key,$UserRatingMatrix[$Users2])){
            $similar[$key] = $value;
        }
      }
      if(count($similar) ==0){
        return 0;
      }
      foreach ($UserRatingMatrix[$user1] as $key => $value) {
        if(array_key_exists($key,$UserRatingMatrix[$Users2])){
             $sum = $sum + pow($value - $UserRatingMatrix[$Users2][$key],2);
        }
      }
     return 1/(1+sqrt($sum));

      // foreach ($matrix[$user1] as $key => $value) {
      //   if(array_key_exists($key,$matrix[$Users2])){
      //          $sum += ($value - $matrix[$Users2][$key]) * ($value - $matrix[$Users2][$key]);
      //      }
      //    }
      //     return sqrt($sum);
    }else{
      return false;
    }
  }
}
