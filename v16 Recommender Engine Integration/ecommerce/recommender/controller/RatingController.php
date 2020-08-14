<?php
require_once $_SERVER['DOCUMENT_ROOT'].'/ecommerce/recommender/Model/Ratings.php';

class RatingController extends Ratings{
  //This funcion rate a product
  public function RateProduct($product_id, $rating,$user_name,$ratingType){
      $ratingQ = $this->getRatings($user_name);
      $ratingExistCheck = count($ratingQ);
      $updated_time = date("Y-m-d h:i:s", time());
      $product_rating = array();
      if($ratingType == "explicit"){ //purchase automatically asign a 5 rating to the product, while add to cart or wishlist asign a 4 rating
        $rating = $rating;
      }else if($ratingType == "purchase"){
        $rating = PURCHASE_RATING;
      }else{
        $rating = CART_WISH_RATING; //user behavior e.g add to cart or wish liist
      }
      $product_rating[] = array(
          'product_id'            => $product_id,
          'ratingType' => $ratingType,
          'rating'    => $rating,
        );
    if($ratingExistCheck != 1){ //insert user rating row to database if user have not rated any product previously
      $rating_json = json_encode($product_rating);
        $sql = "INSERT INTO ratings (username,last_updated,product_rating) VALUES (?,?,?)";
      $this->setRatings($sql,$user_name,$updated_time,$rating_json);
    }else{//update existing product_rating json object
      $previosu_rating_match = 'false';
      $new_rating = array();
    foreach ($ratingQ as $ratingtable){
      $previous_product_rating = json_decode($ratingtable['product_rating'],true); //makes it an associated array not an object
        foreach ($previous_product_rating as $p_rating){
          if($product_id == $p_rating['product_id']){ //update rating if the product was rated previously by user
            if($ratingType == 'explicit'){
            $p_rating['rating'] = $product_rating[0]['rating'];
          }else if($p_rating['ratingType'] != 'explicit' && $ratingType = 'purchase'){
            $p_rating['rating'] = $product_rating[0]['rating'];
          }else{}//do not update existing rating on add to cart or wish list event
        $previosu_rating_match = 'true';
        }
        $new_rating[] = $p_rating;
      }
      if($previosu_rating_match == 'false'){//add new rating if user have not rated previously rated this product
        $new_rating = array_merge($product_rating,$previous_product_rating);
      }
        $rating_json = json_encode($new_rating);
        $sql ="UPDATE ratings SET product_rating = ?, last_updated = ? WHERE username = ?";
        $this->updateRatings($sql,$rating_json,$updated_time,$user_name);
        $_SESSION['success_flash'] = 'rating update successful..';
      }
    }
        $this->computeProductAverageRating($product_id);
  }

  public function getProductRatingForUser($product_id, $user){
    $returnRating = 0; //rating or zero no rating
    $ratingQ = $this->getRatings($user);
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
      $sql ="UPDATE products SET product_average_rating = ?, product_rating_counter = ? WHERE id = ?";
      $this->setProductRating($sql,$newAvgRating,$rating_counter,$product_id);
     }
    }
  }
} ?>
