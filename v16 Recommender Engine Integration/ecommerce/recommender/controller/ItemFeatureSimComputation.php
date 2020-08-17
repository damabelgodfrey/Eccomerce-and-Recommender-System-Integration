<?php
/**
 * Compute the similarity between all items against current item
 */
class ItemFeatureSimComputation
{
  //uses several algoriths to compute item similarity using specified features
  //Product title, product descripted and product tag
  public static function getFeatureSimCoefficient($simAlgorithm,$CFArray,$clickedP_id){
    $product = new ProductController();
  if(count($CFArray)!=0){
      $OtherProductQuery = $product->getRecommendedCProduct($CFArray);
  }else{
    $OtherProductQuery = $product->getAllProducts();
  }
    $productQuery = $product->getProduct($clickedP_id);
    $recommendedArray = array();
    $stopWord = getStopwordsFromFile();
    foreach ($productQuery as $product) {
      $noOfSynonysPerword= 2;
      $tags =DictionaryLookUp::requestAllSynonyms($product['p_keyword'],$noOfSynonysPerword);
    //  $thisItemFeatures= processContent($stopWord, $product['title'].' '.$product['description'].' '.$tags);
       $thisItemFeatures= processContent($stopWord, $product['title'].' '.$product['description']);
       $thisItemTags= processContent($stopWord, $tags);
    }

    if(is_logged_in()){
    $user_email =   $_SESSION['user_email'];
      $transObj = new TransactionController();
      $idArray = $transObj->getUserTransactions($user_email);
      }
      foreach ($OtherProductQuery as $otherProduct) {
         $otherProductID=  $otherProduct['id'];
         $condition = 0;
        if(is_logged_in()){
            if($otherProductID != $clickedP_id && !array_key_exists($otherProductID,$idArray)){
              $condition = 1;
            }
        }else{
          if($otherProductID != $clickedP_id){
            $condition = 1;
          }
        }
        if($condition ==1){ //remove all product brought by users if logged in and the current clicked product
         //$otherItemFeatures = processContent($stopWord, $otherProduct['title'].' '.$otherProduct['description'].' '.$otherProduct['p_keyword']);
         //for weighted product property input
         $otherItemFeatures= processContent($stopWord, $otherProduct['title'].' '.$otherProduct['description']);
         $otherItemTags= processContent($stopWord, $otherProduct['p_keyword']);
         $p_aveRating = (double)$otherProduct['product_average_rating'];


        switch ($simAlgorithm) {
          case 'LevenshteinDistance':
            $result = LevenshteinDistance::getLevenshteinDistance($item1, $otherItemFeatures);
            //$result = levenshtein($item1, $item2);
            break;
          case 'JaccardSimilarityCoefficient':
            $result = JaccardSimilarity::getJaccardSimilarityCoefficient( $thisItemFeatures, $otherItemFeatures);
            break;
          case 'ConsineSimilarity':
            $result = ContentBased_CosineSimilarity::getCBConsineSimilarity($thisItemFeatures, $otherItemFeatures);
            break;
          case 'CosineRatingSimilarityWeighted':
            $result = ContentBased_CosineSimilarity::getCBCosineRatingSimilarityWeighted($item1, $item2,$p_aveRating);
            break;
          case 'CosineSimilarityRatingTagWeighted':
            $result = ContentBased_CosineSimilarity::getCBCosineSimilarityRatingTagWeighted($thisItemFeatures, $thisItemTags,
                                                                                       $otherItemFeatures, $otherItemTags,$p_aveRating);
            break;
          default:
            break;
         }
        if($result != 0){
          $recommendedArray1[$otherProduct['id'].' '.$otherProduct['title']] = to2Decimal($result); //send to file
          $recommendedArray[$otherProduct['id']] = to2Decimal($result);
        }
        }
    }
    if(isset($recommendedArray1)){
      arsort($recommendedArray1);
      debugfilewriter("\nContent Based Similarity\n");
      debugfilewriter($recommendedArray1);
      arsort($recommendedArray);
    }
    return $recommendedArray;
  }
}
