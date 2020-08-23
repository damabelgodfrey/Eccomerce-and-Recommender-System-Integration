<?php
/**
 *
 */
class UserItemRatingMatrix {

  public static function createRatingMatrix($type,$userID){
     $ratingCObj = new RatingController();
     if ($type =='AllUser') {
       $allRatingsQ = $ratingCObj->getAllRatings();
     }else{
       $allRatingsQ = $ratingCObj->getRatings($userID);
     }
     $matrix = array();
     foreach($allRatingsQ as $allRatings){
       $userRatings = $allRatings['product_rating'];
       $product_rating = json_decode($userRatings,true);
       foreach ($product_rating as $p_rating){
         $id     =  $p_rating['product_id'];
         $user_id   =  $allRatings['userID'];
         $rating =  $p_rating['rating'];
         $matrix[$user_id][$id]= $rating;
       }
     }
     debugfilewriter("\nUser Item Rating Matrix\n");
     debugfilewriter($matrix);
     return $matrix;
 }
}
