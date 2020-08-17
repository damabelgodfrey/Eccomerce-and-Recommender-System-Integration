<?php
/**
 *
 */

class JaccardSimilarity{
  public static function getJaccardSimilarityCoefficient($item1, $item2) {
  //$prepareItem1 = array_map('trim', explode( $separator, strtolower($item1) ));
  //$prepareItem2 = array_map('trim', explode( $separator, strtolower($item2) ));
  $tokens1 = preg_split('/[\s,]+/', strtolower($item1));
  $tokens2 = preg_split('/[\s,]+/', strtolower($item2));
  $unique_item1_arr = array_unique($tokens1);
	$unique_item2_arr = array_unique($tokens2);
  $arr_intersection = array_intersect( $unique_item2_arr, $unique_item1_arr ); //intersection
	$arr_union = array_unique(array_merge( $unique_item1_arr, $unique_item2_arr )); //union
	$jaccard_sim_coefficient = count( $arr_intersection ) / count( $arr_union ); //
	return $jaccard_sim_coefficient;
 }
}
