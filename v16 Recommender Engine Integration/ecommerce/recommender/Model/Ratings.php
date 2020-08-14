<?php
require_once $_SERVER['DOCUMENT_ROOT'].'/ecommerce/core/DBh.php';
class Ratings extends DBh{

  public function getRatings($user_name){
    $sql = "SELECT * FROM ratings WHERE username = ?";
    $myQuerry = $this->getConnection()->prepare($sql);
    $myQuerry->execute([$user_name]);
    $results = $myQuerry->fetchAll();
    return $results;
  }

  public function getAllRatings(){
    $sql = "SELECT * FROM ratings";
    $myQuerry = $this->getConnection()->prepare($sql);
    $myQuerry->execute();
    $results = $myQuerry->fetchAll();
    return $results;
  }
  protected function setRatings($sql,$user_name,$updated_time,$rating_json){
    $myQuerry = $this->getConnection()->prepare($sql);
    $myQuerry->execute([$user_name,$updated_time,$rating_json]);
  }

  protected function updateRatings($sql,$rating_json,$updated_time, $user_name){
    $myQuerry = $this->getConnection()->prepare($sql);
    $myQuerry->execute([$rating_json, $updated_time, $user_name]);
  }

  protected function updateAveProductRating($sql,$newAvgRating,$rating_counter,$product_id){
    $myQuerry = $this->getConnection()->prepare($sql);
    $myQuerry->execute([$newAvgRating,$rating_counter,$product_id]);
  }
}
