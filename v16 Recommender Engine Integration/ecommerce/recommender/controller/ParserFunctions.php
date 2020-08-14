<?php
//takes user item rating collaborative Filtering result and content similarity of item
// to compute final score.
function FinalCompositePrediction($recommendedArrayCF,$recommendedArrayCSimilairity){
  $finalCPrediction =array();
  $CFW = 0.5;
  $CSimScore = 0.5;
//$intersect = array_intersect($recommendedArrayCF,$recommendedArrayCSimilairity)
  foreach ($recommendedArrayCSimilairity as $key => $value) {

    if(array_key_exists($key,$recommendedArrayCF)){
      $y = $value * $CSimScore;
      $x = $recommendedArrayCF[$key] * $CFW;
      $finalCPrediction[$key] = $y+ $x;
    }
  }
  arsort($finalCPrediction);
  return $finalCPrediction;
}

//uses several algoriths to compute item similarity using specified features
//Product title, product descripted and product tag
function computeItemSimilarityCoefficient($CFArray, $clickedP_id){
  $product = new ProductController();
if(count($CFArray)!=0){
    $OtherProductQuery = $product->getRecommendedCProduct($CFArray);
}else{
  $OtherProductQuery = $product->getAllProducts();
}
  // get all product in this array $CFArray

  $productQuery = $product->getProduct($clickedP_id);
  $recommendedArray = array();
  $stopWord = getStopwordsFromFile();
  foreach ($productQuery as $product) {
    //request $synonymsArray
    $noOfSynonysPerword= 2;
    $tags =DictionaryLookUp::requestAllSynonyms($product['p_keyword'],$noOfSynonysPerword);
  //  $item1= processContent($stopWord, $product['title'].' '.$product['description'].' '.$tags);
   // for weighted product property input
     $thisItemProperties= processContent($stopWord, $product['title'].' '.$product['description']);
     $thisItemTags= processContent($stopWord, $tags);
  //end
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
       //$item2 = processContent($stopWord, $otherProduct['title'].' '.$otherProduct['description'].' '.$otherProduct['p_keyword']);
       //for weighted product property input
       $otherItemProperties= processContent($stopWord, $otherProduct['title'].' '.$otherProduct['description']);
       $otherItemTags= processContent($stopWord, $otherProduct['p_keyword']);
       $p_aveRating = (double)$otherProduct['product_average_rating'];

      //$result = LevenshteinDistance::getLevenshteinDistance($item1, $item2);
      //$result = levenshtein($item1, $item2);
      //$result = JaccardSimilarity::getJaccardSimilarityCoefficient( $item1, $item2);
     //$result = ContentBased_CosineSimilarity::getCBConsineSimilarity($item1, $item2);
     //$result = ContentBased_CosineSimilarity::getCBCosineRatingSimilarityWeighted($item1, $item2,$p_aveRating);
     $result = ContentBased_CosineSimilarity::getCBCosineSimilarityRatingTagWeighted($thisItemProperties, $thisItemTags,$otherItemProperties, $otherItemTags,$p_aveRating);
      if($result != 0){
        $recommendedArray1[$otherProduct['id'].' '.$otherProduct['title']] = $result; //send to file
        $recommendedArray[$otherProduct['id']] = $result;
      }
      }
  }
  arsort($recommendedArray1);
  debugfilewriter("\nContent Based Similarity\n");
  debugfilewriter($recommendedArray1);
  arsort($recommendedArray);
  return $recommendedArray;
}
//write output to file
function debugfilewriter($result2file){
  $mystopwordFile = $_SERVER['DOCUMENT_ROOT']."/ecommerce/files/debuggerfile.txt";
  file_put_contents($mystopwordFile, print_r($result2file, true), FILE_APPEND | LOCK_EX);
}


//read stopword from file to array
function getStopwordsFromFile(){
  $mystopwordFile = $_SERVER['DOCUMENT_ROOT']."/ecommerce/files/stopwords.txt";
  $file_handle = fopen($mystopwordFile, "r");
  $theData = fread($file_handle, filesize($mystopwordFile));
  $stopword_array = array();
  $my_array = explode(",", $theData);
  foreach($my_array as $stopword)
  {
    $stopword_array[] = trim($stopword,"'");
  }
  fclose($file_handle);
  return $stopword_array;
}
// remove common word and reduce word to their core root
function processContent($stopword_array,$contentAtribute){
  $prepare_content = preg_split('/[^[:alnum:]]+/', strtolower($contentAtribute));
  $item_string =implode(' ', array_unique($prepare_content));
  $stemmed_parts = array();
  $content_ = preg_replace('/\b('.implode('|',$stopword_array).')\b/','',$item_string); //remove common words
  $content_arr = explode(' ',$content_);
  foreach ($content_arr as $word) {
    $stemmed_word = PorterStemmer::Stem($word);
    $stemmed_parts[] = $stemmed_word;
  }
  return implode(' ', $stemmed_parts);
}
//
// function predict ( $userID , $itemID ) {
// $denom = 0.0 ; // denominator
// $numer = 0.0 ; // numerator
// $k = $itemID ;
// $sql = "SELECT r.itemID , r.ratingValue FROM rating.r WHERE r.userID=$userID AND r.itemID <>
// $itemID" ;
// $dbresult = mysqlquery ( $sql , $connection);
// // f o r a l l i tem s the u s e r has r a t e d
// while ( $row = mysqlfetchassoc ( $dbresult)) {
//   $j = $row ['itemID'] ;
//   $ratingValue = $row ['ratingValue'] ;
//   // g e t the number o f tim e s k and j have both been rated by the same user
//   $sql2= "SELECT d.count , d.sum FROM devd WHERE itemID1=$k AND itemID2=$j";
//   $countresult = mysqlquery($sql2 , $connection);
//   //skip the calculation if it isn’t found
//   if(mysqlnumrows ( $countresult) > 0) {
//   $count = mysqlresult ( $countresult , 0 , "count");
//   $sum = mysqlresult( $countresult, 0 , "sum") ;
//   // c a l c u l a t e the a v e r a g e
//   $average = $sum / $count ;
//   // inc remen t denominator by count
//   $denom += $count ;
//   // inc remen t the numerator
//   $numer += $count ∗ ( $average + $ratingValue ) ;
//    }
// }
// if( $denom == 0)
//    return 0 ;
// else
//    return ( $numer / $denom ) ;
// }
