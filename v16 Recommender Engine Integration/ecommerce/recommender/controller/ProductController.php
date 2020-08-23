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
    public function requestGroupProduct($recommendedArray){
    $productIDs = array();
     foreach($recommendedArray as $item =>$predictionValue){
     if($predictionValue > 0.01 && (int)sanitize($_POST['id']) != $item){
       $productIDs[] = $item;
     }
    }
    $ids = implode(',',$productIDs);

    return $this->getGroupProduct($ids);
    }

    public function updateAveProductRating($newAvgRating,$rating_counter,$product_id){
        $sql ="UPDATE products SET product_average_rating = ?, product_rating_counter = ? WHERE id = ?";
        $this->setProductAveRating($sql,$newAvgRating,$rating_counter,$product_id);

    }
}
