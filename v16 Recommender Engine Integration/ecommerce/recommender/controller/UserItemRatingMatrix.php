<?php
/**
 *
 */
class UserItemRatingMatrix {

  public static function createRatingMatrix(){
     $ratingCObj = new RatingController();
     $allRatingsQ = $ratingCObj->getAllRatings();
     $matrix = array();
     foreach($allRatingsQ as $allRatings){
       $userRatings = $allRatings['product_rating'];
       $product_rating = json_decode($userRatings,true);
       foreach ($product_rating as $p_rating){
         $id     =  $p_rating['product_id'];
         $user   =  $allRatings['username'];
         $rating =  $p_rating['rating'];
         $matrix[$user][$id]= $rating;
       }
     }
     debugfilewriter("\nUser Item Rating Matrix\n");
     debugfilewriter($matrix);
     return $matrix;
 }
}
