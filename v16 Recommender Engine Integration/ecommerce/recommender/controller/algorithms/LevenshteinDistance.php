<?php
/**
 *
 */
class LevenshteinDistance
{

  public static function getLevenshteinDistance($token1, $token2) {
      $charCount1 = strlen($token1);
      $charCount2 = strlen($token2);
      for($i = 0; $i <= $charCount1; $i++){
        $distance[$i][0] = $i;
      }
      for($j = 0; $j <= $charCount2; $j++){
        $distance[0][$j] = $j;
      }
      for($i = 1; $i <= $charCount1; $i++){
        for($j = 1; $j <= $charCount2; $j++){
          $distance[$i][$j] = min($distance[$i - 1][$j] + 1, $distance[$i][$j - 1] + 1, $distance[$i - 1][$j - 1] + ($token1[$i - 1] != $token2[$j - 1]));
        }
      }
      $y = sqrt($distance[$charCount1][$charCount2]);
      return (1/(1+$y));
  }
}
