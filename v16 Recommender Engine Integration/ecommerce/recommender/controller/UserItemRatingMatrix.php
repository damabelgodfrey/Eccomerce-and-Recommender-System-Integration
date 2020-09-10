<?php
/**
 * Computes user rating metrix
 *@return item rating metrix all current or all registered users
 */
class UserItemRatingMatrix {
  //Compute rating metrix
  public static function createRatingMatrix($type,$userID){
     $ratingCObj = new RatingController();
     if ($type =='AllUser') {
       $allRatingsQ = $ratingCObj->getAllRatings();
     }else{
       $allRatingsQ = $ratingCObj->getRatings($userID);
     }
     $UserRatingMatrix = array();
     foreach($allRatingsQ as $allRatings){
       $userRatings = $allRatings['product_rating'];
       $product_rating = json_decode($userRatings,true);
       foreach ($product_rating as $p_rating){
         $id     =  $p_rating['product_id'];
         $user_id   =  $allRatings['userID'];
         $rating =  $p_rating['rating'];
         $UserRatingMatrix[$user_id][$id]= $rating;
       }
     }
     debugfilewriter("\nUser Item Rating Matrix\n");
     debugfilewriter($UserRatingMatrix);
     return $UserRatingMatrix;
 }

 public static function createRatingMatrix2($type,$userID){
    $ratingCObj = new RatingController();
    if ($type =='AllUser') {
      $allRatingsQ = $ratingCObj->getAllRatings();
    }else{
      $allRatingsQ = $ratingCObj->getRatings($userID);
    }
    $UserRatingMatrix = array();
    foreach($allRatingsQ as $allRatings){
      $userRatings = $allRatings['product_rating'];
      $product_rating = json_decode($userRatings,true);
      foreach ($product_rating as $p_rating){
        $id     =  $p_rating['product_id'];
        $user_id   =  $allRatings['userID'];
       // get $user_name

       // get product name
       $Obj = new ProductController();
       $p = $Obj->getProduct($id);
       $p_title = $p[0]['title'];

       $obj2 = new UserController();
       $u = $obj2->selectUser("customer",$user_id);
       $u_name = $u[0]['username'];
        $rating =  $p_rating['rating'];
        $UserRatingMatrix[$u_name][$p_title]= $rating;
      }
    }
    debugfilewriter("\nUser Item Rating Matrix\n");
    debugfilewriter($UserRatingMatrix);
    return $UserRatingMatrix;
}
}
