<?php
require_once $_SERVER['DOCUMENT_ROOT'].'/ecommerce/recommender/Model/Products.php';
/**
 *
 */
  class ProductController extends Products{
    function __construct()
    {

    }

    // display recommended product on ecommerce
    public function getRecommendedCProduct($recommendedArray){
    $productIDs = array();
     foreach($recommendedArray as $item =>$predictionValue){
     if($predictionValue > 0.01 && (int)sanitize($_POST['id']) != $item){
       $productIDs[] = $item;
     }
    }
    $ids = implode(',',$productIDs);

    return $this->getGroupProduct($ids);
    }


}
