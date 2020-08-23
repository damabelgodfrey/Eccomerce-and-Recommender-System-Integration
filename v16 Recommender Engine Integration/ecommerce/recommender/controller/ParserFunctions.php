<?php
//write output to file
function debugfilewriter($result2file){
  $mystopwordFile = $_SERVER['DOCUMENT_ROOT']."/ecommerce/files/debuggerfile.txt";
  file_put_contents($mystopwordFile, print_r($result2file, true), FILE_APPEND | LOCK_EX);
}

//return number in two decimal places
function to2Decimal($value){
  return sprintf('%0.2f', $value);
}

//get getrusage
function my_getrusage($rustart,$rend){
  $rustart = getrusage();
  $rend = getrusage();
  echo "This process used " . rutime($rend, $rustart, "utime") ." ms for its computations\n";
  echo "It spent " . rutime($rend, $rustart, "stime") ." ms in system calls\n";
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
