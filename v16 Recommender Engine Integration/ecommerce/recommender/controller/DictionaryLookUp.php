<?php
class DictionaryLookUp
{
    /**
    * var @ $apikey @ $language @$endpoint @$info
    */
    private static $apikey = "aIlI0krLFXTDoHG58XSw"; // : replace test_only with your own key
    private static $language = "en_US"; // you can use: en_US, es_ES, de_DE, fr_FR, it_IT
    private static $endpoint = "http://thesaurus.altervista.org/thesaurus/v1";
    private static $info;
    //
    private static function sendRequest($word){
      $ch = curl_init();
      $la = self::$language;
      $key = self::$apikey;
      $endpoint = self::$endpoint;
      curl_setopt($ch, CURLOPT_URL, "$endpoint?word=".urlencode($word)."&language=$la&key=$key&output=json");
      curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
      $result = curl_exec($ch);
      self::$info = curl_getinfo($ch);
      curl_close($ch);
      return $result;
    }

    public static function getSynonyms($word,$noOfSynonyms){
         $returnResult =  self:: sendRequest($word);
         $returnInfo = self::$info;
      if($returnInfo['http_code'] == 200) {
        $my_wordList =  self::getresults($returnResult);
        $genericTerm = array();
        $similarTerm = array();
        $otherTerm = array();
        foreach ($my_wordList as $key =>$wordArray) {
          foreach ($wordArray as $key2 =>$word) {
              if(strpos($word, 'similar term')){
                $st= str_ireplace('(similar term)', '', $word);
                if(str_word_count($st)==1){ //discard when 2 words is returned as synonyms result
                 $genericTerm[] = $st;
                }
              }else if(strpos($word, 'generic term')){
                 $st= str_ireplace('(generic term)', '', $word);
                 if(str_word_count($st)==1){
                  $genericTerm[] = $st;
                 }
              }else{
                if(str_word_count($word) == 1){
                  $otherTerm[]= $word;
                }
              }
          }
        }
        if(count($similarTerm) <3){
          //$similarTerm = array_unique(array_merge($similarTerm,$otherTerm));
          $similarTerm = array_merge($similarTerm,$otherTerm);
        }
        if(count($similarTerm) > $noOfSynonyms){ //specify number of array to return
          $similarTerm = array_slice($similarTerm, 0, $noOfSynonyms);
        }
     return $similarTerm;
   }else {
       return;
    }
  }

    public static function getresults($returnResult){
    $my_wordList = array();
      $results = json_decode($returnResult, true);
      foreach ($results["response"] as $wordList) {
       $my_wordList[] = explode('|',$wordList["list"]["synonyms"]);
      }
      return $my_wordList;

 }

 public static function requestAllSynonyms($productTagKeywords,$noOfSynonyms){
  $wordArray = explode(' ',$productTagKeywords);
  $result = array();
   foreach ($wordArray as $word) {
       $synonymsArray= self::getSynonyms($word,$noOfSynonyms);
       if($synonymsArray != null){
         foreach ($synonymsArray as $word) {
          $result[] = $word;
       }
     }
   }
   $merged = array_merge($wordArray,$result);
   $c_result = implode(' ', $merged);
   return $c_result;
 }
}
?>
