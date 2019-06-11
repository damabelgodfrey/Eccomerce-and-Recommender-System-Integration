<form action="" method="post" id="num_size_form" name="num_size_form">
  <div class="input-group">
   <span class="input-group-addon" id="basic-addon1"><?php echo isset($_POST["num_size"]) ? htmlentities($_POST["num_size"]) : $sizerow; ?>
   <input type="hidden" name="num_size" id="num_size" value="" class= "form-control">

    <select name="sizerow" id="sizerow" class="">
      <option value="">Choose No Size</option>
      <?php $size_counts =[1,2,3,4,5,6,7,8,9,10,11,12];
      foreach ($size_counts as $sizecount) {
        $numrow = explode(',', $sizecount);
        $sizerowarray = $numrow[0];
        echo '<option value="'.$sizerowarray.'" data-sizerow="'.$sizerowarray.'".>'.$sizerowarray.'</option>';
      }?>
    </select>

  </span>
  </div>
</form>
<form action="" method="post" id="sort_form" name="sort_form">
<div class="input-group">
<span class="input-group-addon" id="basic-addon1"><?php echo isset($_POST["sort_type:"]) ? htmlentities($_POST["sort_type:"]) : $Prod_sort; ?>
<input type="hidden" name="sort_type" id="sort_type" value="" class= "form-control">

<select name="SsortType" id="SsortType" class="">
<option value="">Choose sort Type</option>
<?php $sort_counts =['Product Name','Product Price','Quantity Sold High','Quantity Sold Low','Recently Added'];
foreach ($sort_counts as $sort) {
  $sortType = explode(',', $sort);
  $sortTypearray = $sortType[0];
  echo '<option value="'.$sortTypearray.'" data-SsortType="'.$sortTypearray.'".>'.$sortTypearray.'</option>';
}?>
</select>

</span>
</div>
</form>

<script type="text/javascript">
//update the nmber of size input row
  jQuery('#sort_form').change(function(){
    var sortType = jQuery('#SsortType option:selected').data("SsortType");
    jQuery("#sort_type").val(sortType);
    jQuery( "#sort_form" ).submit();
    return false;

  });
  //update the nmber of size input row
    jQuery('#num_size_form').change(function(){
      var sizerow = jQuery('#sizerow option:selected').data("sizerow");
      jQuery("#num_size").val(sizerow);
      jQuery( "#num_size_form" ).submit();
      return false;

    });
</script>
