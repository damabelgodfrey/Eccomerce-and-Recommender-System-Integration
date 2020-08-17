<?php
/**
 *
 */
class LevenshteinDistance
{

  public static function getLevenshteinDistance($text1, $text2) {
      $len1 = strlen($text1);
      $len2 = strlen($text2);
      for($i = 0; $i <= $len1; $i++)
          $distance[$i][0] = $i;
      for($j = 0; $j <= $len2; $j++)
          $distance[0][$j] = $j;
      for($i = 1; $i <= $len1; $i++)
          for($j = 1; $j <= $len2; $j++)
              $distance[$i][$j] = min($distance[$i - 1][$j] + 1, $distance[$i][$j - 1] + 1, $distance[$i - 1][$j - 1] + ($text1[$i - 1] != $text2[$j - 1]));
      return (1/(1+sqrt($distance[$len1][$len2])));
  }
}
