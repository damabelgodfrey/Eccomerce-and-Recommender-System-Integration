<?php
require_once $_SERVER['DOCUMENT_ROOT'].'/ecommerce/recommender/Model/Ratings.php';
/**
 * This class controls all computions and redirection regarding ratings
 */
class RatingController extends Ratings{
  //This funcion rate a product
  public function RateProduct($product_id, $rating,$user_id,$ratingType){
    $ratingQ = $this->getRatings($user_id);
    $ratingExistCheck = count($ratingQ);
    $updated_time = date("Y-m-d h:i:s", time());
    $product_rating = array();
    if($ratingType == "explicit"){ //purchase automatically asign a 5 rating to the product, while add to cart or wishlist asign a 4 rating
      $rating = $rating;
    }else if($ratingType == "purchase"){
      $rating = $rating ;
    }else{
      $rating = $rating; //user behavior e.g add to cart or wish liist
    }
    $product_rating[] = array(
        'product_id' => +$product_id,
        'ratingType' => $ratingType,
        'rating'     => +$rating,
      );
  if($ratingExistCheck != 1){ //insert user rating row to database if user have not rated any product previously
    $rating_json = json_encode($product_rating);
    $sql = "INSERT INTO ratings (userID,last_updated,product_rating) VALUES (?,?,?)";
    $this->setRatings($sql,$user_id,$updated_time,$rating_json);
  }else{//update existing product_rating json object
    $previosu_rating_match = 'false';
    $new_rating = array();
  foreach ($ratingQ as $ratingtable){
    $previous_product_rating = json_decode($ratingtable['product_rating'],true); //makes it an associated array not an object
      foreach ($previous_product_rating as $p_rating){
        if($product_id == $p_rating['product_id']){ //update rating if the product was rated previously by user
          if($ratingType == 'explicit'){
          $p_rating['rating'] = +$product_rating[0]['rating'];
        }else if($p_rating['ratingType'] != 'explicit' && $ratingType = 'purchase'){
          $p_rating['rating'] = +$product_rating[0]['rating'];
        }else{}//do not update existing rating on add to cart or wish list event if explict rating on product exist
      $previosu_rating_match = 'true';
      }
      $new_rating[] = $p_rating;
    }
    if($previosu_rating_match == 'false'){//add new rating if user have not previously rated this product
      $new_rating = array_merge($product_rating,$previous_product_rating);
    }
      $rating_json = json_encode($new_rating);
      $sql ="UPDATE ratings SET product_rating = ?, last_updated = ? WHERE userID = ?";
      $this->updateRatings($sql,$rating_json,$updated_time,$user_id);
    }
  }
      $this->computeProductAverageRating($product_id);
  }

// Get product rating given to a product by a user
  public function getProductRatingForUser($product_id, $user_id) : int{
    $returnRating = 0; //rating or zero no rating
    $ratingQ = $this->getRatings($user_id);
    if(count($ratingQ) ==1){
      foreach ($ratingQ as $ratingtable) {
      $product_rating = json_decode($ratingtable['product_rating'],true); //makes it an associated array not an object
        foreach ($product_rating as $p_rating){
          if($product_id == $p_rating['product_id']){
          $returnRating =  $p_rating['rating'];
          }
        }
      }
    }
  return $returnRating;
  }

  //compute product average rating.
  //update product average rating in product table
public  function computeProductAverageRating($product_id){
  $ratingQ = $this->getAllRatings();
  if(count($ratingQ) >0){
    $rating_counter = 0;
    $summation =0;
    foreach ($ratingQ as $ratingtable){
      $current_product_rating = json_decode($ratingtable['product_rating'],true);
      foreach ($current_product_rating as $p_rating){
        if($product_id == $p_rating['product_id']){
          $summation = $summation + $p_rating['rating'];
          $rating_counter++;
        }
      }
    }
    if($summation != 0){
      $newAvgRating = number_format(($summation/$rating_counter),1);
      $pObj = new ProductController();
      $pObj->updateAveProductRating($newAvgRating,$rating_counter,$product_id);
     }
    }
  }
}
