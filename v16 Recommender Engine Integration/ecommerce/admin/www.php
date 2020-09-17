<?php
/**
 * compute content based recommendation from user profile
 * compute siilarity between user profile and item profile
 * @return ranked products based on similarity to user profile.
 */
class ContentBasedRecommender
{
  const SIMILARITY_THRESHOLD = 0; // specify similarity threshold.
  const ALGORITHM = "ConsineSimilarity";
  const PRODUCT_PROPERTY = "tags";
  // get user profile
  private static function getUserProfile($user_id){
  $profilerObj = new UserProfiller();
  $profiles = $profilerObj->getUserProfile($user_id);
  $existingProfiling = array();
  foreach ($profiles as $key => $profile) {
    $itemIDCatBrand = explode('::',$profile['itemID_cat_brand']);
    $itemCatArr = explode(',',$itemIDCatBrand[1]);
    $itemBrandArr = explode(',',$itemIDCatBrand[2]);
    $existingProfiling = json_decode($profile['profile'],true);
  }
  $obj = new productController();
  $brands = $obj->getBrandSet($itemBrandArr);
  $categories = $obj->getCategorySet($itemCatArr);
  $brand="";
  $cat = "";
  foreach ($brands as $key => $value) {
   $brand .= $value['brand'].' ';
  }
  foreach ($categories as $key => $value) {
   $cat .= $value['category'].' ';
  }

  $cat = trim($cat);
  $brand = trim($brand);
  echo "<pre>";
  var_dump($cat);
  echo "</pre>";
 die();

  foreach ($existingProfiling as $key => $profile) {
      $weight = $profile['weight'];
      for ($i=0; $i < $weight; $i++) {
        $profileTokens[]= $profile['token'];
      }
  }

  $profileTokens = trim(implode(' ', $profileTokens));
  return $profileTokens;
  }
 //uses several algorithms to compute item similarity using specified features
 //product descripted and product tag
 //ranks all processed items by similarity score against current user profile.
 public static function computeContentBasedPrediction($user_id): array{
  $recommendedArray = array();
  $userProfileTokens = self::getUserProfile($user_id);
  if($userProfileTokens != " ") {
   $noOfSynonysPerword = 2;
   $product = new ProductController();
   $stopWord = getStopwordsFromFile();

   //$OtherProducts = $product->getAllProducts();
   $itempObj = new ItemProfiller();
   $itemProfiles = $itempObj->getAllItemProfile();
   $user_email =   $_SESSION['user_email'];
   $transObj = new TransactionController();
   $purchaseItemIDArr = $transObj->getUserTransactions($user_email);
   foreach ($OtherProducts as $otherProduct) {
     $otherProductID=  $otherProduct['id'];
     $purchaseCheck = 0;
     if(!array_key_exists($otherProductID,$purchaseItemIDArr)){ //exclude products already bought by user
      $purchaseCheck = 1;
     }
     if($purchaseCheck ==1){
      $tags =DictionaryLookUp::requestAllSynonyms($otherProduct['p_keyword'],$noOfSynonysPerword);
      if(self::PRODUCT_PROPERTY =="Tags"){
        $otherItemTokens= processContent($stopWord, $tags);
      }else{
        $otherItemTokens= processContent($stopWord, $tags.' '.$otherProduct['description']);
      }
      $p2_aveRating = (double)$otherProduct['product_average_rating'];
     switch (self::ALGORITHM) {
       case 'LevenshteinDistance':
         $result = D_LevenshteinDistance::getLevenshteinDistance($otherItemTokens, $userProfileTokens);
         break;
       case 'JaccardSimilarityCoefficient':
         $result2 = JaccardSimilarity::getJaccardSimilarity($otherItemTokens, " ", $userProfileTokens, " ");
         break;
       case 'ConsineSimilarity':
         $result = TokenBasedCosineSimilarity::getCBConsineSimilarity($otherItemTokens, $userProfileTokens);
         break;
       case 'CosineRatingSimilarityWeighted':
         $result = TokenBasedCosineSimilarity::getCBCosineRatingSimilarityWeighted($thisItemFeatures, $otherItemFeatures, $p2_aveRating);
         break;
       default:
         break;
      }
     if($result != self::SIMILARITY_THRESHOLD){
       $recommendedArray[$otherProductID] = to2Decimal($result);
     }
   }
 }
    if(count($recommendedArray) != 0){
     arsort($recommendedArray);
     $recommendedArray = array_slice($recommendedArray, 0, 5, true);
     debugfilewriter("\nContentBasedRecommender.' => '.content Based Recommendation\n");
     debugfilewriter($recommendedArray);
    }
  }
   return $recommendedArray;
 }

}

 ?>
