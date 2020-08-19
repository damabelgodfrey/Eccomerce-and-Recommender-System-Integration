<?php
require_once $_SERVER['DOCUMENT_ROOT'].'/ecommerce/core/DBh.php';
require_once $_SERVER['DOCUMENT_ROOT'].'/ecommerce/recommender/controller/UserController.php';
class PredictionController extends DBh{

  public function getPrediction($username){
    $userObj = new UserController();
    $userID = $userObj->requestUserID($username);
    $sql = "SELECT * FROM predictions WHERE user_id = ?";
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
  //inserts user-user collaborative filtering computation to database
  //insert item prediction and user neibourhood ranking.
    public function insertCFComputation($type, $username, $CF){
      $predictionQ = $this->getPrediction($username);
      $predictionExistCheck = count($predictionQ);
      $userObj = new UserController();
      $userID = $userObj->requestUserID($username);
        $y = array();
        foreach ($CF as $key => $value) {
          switch ($type) {
            case 'userBasedCF':
            $predicted_rating[] = array(
                'product_id'       => $key,
                'predict_rating' => $value,
              );
              $y = $predicted_rating;
              break;
            case 'similarity':
            $ID = $userObj->requestUserID($key);

              $neibourhood_ranking[] = array(
                'user_id'          => $ID,
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
            default:
              // code...
              break;
          }
        }
        $CFC = json_encode($y);
        $updated_time = date("Y-m-d");
        if($predictionExistCheck == 0){
        if($type == "similarity"){
          $sql ="INSERT INTO predictions (neigbourhood_ranking, user_based_last_updated, user_id) VALUES (?,?,?)";
        }else if($type == "userBasedCF"){
          $sql ="INSERT INTO predictions (user_based_predicted, user_based_last_updated, user_id) VALUES (?,?,?)";
        }else{
          $sql ="INSERT INTO predictions (Item_based_prediction, item_based_last_updated, user_id) VALUES (?,?,?)";
        }
        $this->insertPrediction($sql,$CFC,$updated_time, $userID);
       }else{
        if($type == "similarity"){
          $sql ="UPDATE predictions SET neigbourhood_ranking = ?, user_based_last_updated = ? WHERE user_id = ?";
        }else if($type == "userBasedCF"){
          $sql ="UPDATE predictions SET 	user_based_predicted = ?, user_based_last_updated = ? WHERE user_id = ?";
        }else{
          $sql ="UPDATE predictions SET 	Item_based_prediction = ?, item_based_last_updated = ? WHERE user_id = ?";
        }
        $this->updatePrediction($sql,$CFC,$updated_time, $userID);
        }
    }
}
