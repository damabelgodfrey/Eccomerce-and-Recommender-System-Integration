<?php
require_once $_SERVER['DOCUMENT_ROOT'].'/ecommerce/core/DBh.php';
require_once $_SERVER['DOCUMENT_ROOT'].'/ecommerce/recommender/controller/UserController.php';
class PredictionController extends DBh{

  public function getPrediction($userID){
    $sql = "SELECT * FROM predictions WHERE userID = ?";
    $myQuerry = $this->getConnection()->prepare($sql);
    $myQuerry->execute([$userID]);
    $results = $myQuerry->fetchAll();
    return $results;
  }

  public function insertPrediction($sql,$CFC,$updated_time, $userID){
    $myQuerry = $this->getConnection()->prepare($sql);
    $myQuerry->execute([$CFC,$updated_time, $userID]);
  }
  public function updatePrediction($sql,$CFC,$updated_time, $userID){
    $myQuerry = $this->getConnection()->prepare($sql);
    $myQuerry->execute([$CFC,$updated_time, $userID]);
  }
  public function insertContentbasedComputation($query){
    $myQuerry = $this->getConnection()->prepare($query);
    $myQuerry->execute();
  }
  //inserts user-user collaborative filtering computation to database
  //insert item prediction and user neibourhood ranking.
    public function insertCFComputation($type, $userID, $CF){
      $predictionQ = $this->getPrediction($userID);
      $predictionExistCheck = count($predictionQ);
      $y = array();
      if(count($CF) != 0){
        foreach ($CF as $key => $value) {
          $value = floatval($value);
          $key = +$key;
          switch ($type) {
            case 'userBasedCF':
            $predicted_rating[] = array(
                'product_id'       => $key,
                'predicted_rating' => $value,
              );
              $y = $predicted_rating;
              break;
            case 'UserBasedNearestNeigbour':
              $neibourhood_ranking[] = array(
                'user_id'          => $key,
                'sim_score' => $value,
              );
              $y = $neibourhood_ranking;
              break;
              case 'itemBasedCF':

                $predicted_item_rating_ranking[] = array(
                  'product_id'          => $key,
                  'predicted_rating' => $value,
                );
                $y = $predicted_item_rating_ranking;
                break;
                case 'ContentBasedRecommender':

                  $predicted_items[] = array(
                    'product_id'          => $key,
                    'score' => $value,
                  );
                  $y = $predicted_items;
            default:
              // code...
              break;
          }
        }
        $CFC = json_encode($y);
        $updated_time = date("Y-m-d");
        if($predictionExistCheck == 0 || count($y) == 0){
        if($type == "UserBasedNearestNeigbour"){
          $sql ="INSERT INTO predictions (neigbourhood_ranking, user_based_last_updated, userID) VALUES (?,?,?)";
        }else if($type == "userBasedCF"){
          $sql ="INSERT INTO predictions (user_based_prediction, user_based_last_updated, userID) VALUES (?,?,?)";
        }else if($type == "itemBasedCF"){
          $sql ="INSERT INTO predictions (Item_based_prediction, item_based_last_updated, userID) VALUES (?,?,?)";
        }else{
          $sql ="INSERT INTO predictions (content_based_prediction, content_based_last_updated, userID) VALUES (?,?,?)";
        }
      //  $this->insertPrediction($sql,$CFC,$updated_time, $userID);
       }else{
        // var_dump($type);
        if($type == "UserBasedNearestNeigbour"){
          $sql ="UPDATE predictions SET neigbourhood_ranking = ?, user_based_last_updated = ? WHERE userID = ?";
        }else if($type == "userBasedCF"){
          $sql ="UPDATE predictions SET 	user_based_prediction = ?, user_based_last_updated = ? WHERE userID = ?";
        }else if($type == "itemBasedCF"){
          $sql ="UPDATE predictions SET 	Item_based_prediction = ?, item_based_last_updated = ? WHERE userID = ?";
        }else{
          $sql ="UPDATE predictions SET 	content_based_prediction = ?, content_based_last_updated = ? WHERE userID = ?";
        }
        if (count($y) != 0) {
        //   $this->updatePrediction($sql,$CFC,$updated_time, $userID);
        }
        }
      }
    }
}
