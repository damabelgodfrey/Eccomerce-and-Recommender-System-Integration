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
      $finalCPrediction[$key] = to2Decimal($y+ $x);
    }
  }
  arsort($finalCPrediction);
  return $finalCPrediction;
}

//write output to file
function debugfilewriter($result2file){
  $mystopwordFile = $_SERVER['DOCUMENT_ROOT']."/ecommerce/files/debuggerfile.txt";
  file_put_contents($mystopwordFile, print_r($result2file, true), FILE_APPEND | LOCK_EX);
}

//return number in two decimal places
function to2Decimal($value){
  return sprintf('%0.2f', $value);
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
// remove common word and reduce words to their core root
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

//get script run tie and system usage
function rutime($ru, $rus, $index) {
    return ($ru["ru_$index.tv_sec"]*1000 + intval($ru["ru_$index.tv_usec"]/1000))
     -  ($rus["ru_$index.tv_sec"]*1000 + intval($rus["ru_$index.tv_usec"]/1000));
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
