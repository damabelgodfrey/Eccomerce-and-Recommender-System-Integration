<?php
require_once $_SERVER['DOCUMENT_ROOT'].'/ecommerce/core/DBh.php';
class cartRepoController extends DBh{
  public function insertCart($items_json, $user_name,$cart_expire,$exp_time){
    $sql = "INSERT INTO cart (items,username,expire_date,exp_time) VALUES (?,?,?,?)";
    $myQuerry = $this->getConnection()->prepare($sql);
    $myQuerry->execute([$items_json, $user_name,$cart_expire,$exp_time]);
    return $myQuerry->lastInsertId();
  }

  public function updateCart($items_json,$cart_expire,$exp_time,$user_name){
    $sql = "UPDATE cart SET items = ?, expire_date = ?, exp_time = ? WHERE username = ?";
    $myQuerry = $this->getConnection()->prepare($sql);
    $myQuerry->execute([$items_json,$cart_expire,$exp_time,$user_name]);
  }

  public function deleteCart($user_name){
    $sql = "DELETE FROM cart WHERE username = ?";
    $myQuerry = $this->getConnection()->prepare($sql);
    $myQuerry->execute([$user_name]);
  }
  public function selectCart($input){
    if(is_int($input)){
      $sql = "SELECT * FROM cart WHERE id = ?";
    }else{
      $sql = "SELECT * FROM cart WHERE username = ?";
    }
    $myQuerry = $this->getConnection()->prepare($sql);
    $myQuerry->execute([$input]);
    $results = $myQuerry->fetchAll();
    return $results;
  }
  public function selectAllCart(){
    $sql = "SELECT * FROM cart ORDER BY id DESC LIMIT 10";
    $myQuerry = $this->getConnection()->prepare($sql);
    $myQuerry->execute();
    $results = $myQuerry->fetchAll();
    return $results;
  }
}
