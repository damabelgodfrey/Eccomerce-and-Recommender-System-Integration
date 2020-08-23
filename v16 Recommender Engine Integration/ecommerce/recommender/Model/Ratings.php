<?php
require_once $_SERVER['DOCUMENT_ROOT'].'/ecommerce/core/DBh.php';
/**
 *
 */
class Ratings extends DBh{

  public function getRatings(&$userID){
    $sql = "SELECT * FROM ratings WHERE userID = ?";
    $myQuerry = $this->getConnection()->prepare($sql);
    $myQuerry->execute([$userID]);
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

  protected function setRatings($sql,$user_id,$updated_time,$rating_json){
    $myQuerry = $this->getConnection()->prepare($sql);
    $myQuerry->execute([$user_id,$updated_time,$rating_json]);
  }

  protected function updateRatings($sql,$rating_json,$updated_time, $userID){
    $myQuerry = $this->getConnection()->prepare($sql);
    $myQuerry->execute([$rating_json, $updated_time, $userID]);
  }
}
