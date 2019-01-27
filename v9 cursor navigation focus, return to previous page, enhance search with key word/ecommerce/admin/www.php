
<?php
require_once $_SERVER['DOCUMENT_ROOT'].'/ecommerce/core/init.php';
//check if user is logged in on any of the pages
if(!is_logged_in()){
  login_error_redirect();
}
include 'includes/head.php';

include 'includes/navigation.php';

$sizerow = (int)1;
if(isset($_POST['num_size'])){
  var_dump($sizerow= (int)$_POST['num_size']);
}?>

<form action="" method="post" id="num_size_form" name="num_size_form">
  <div class="input-group">
   <span class="input-group-addon" id="basic-addon1"><?php echo isset($_POST["num_size"]) ? htmlentities($_POST["num_size"]) : $sizerow; ?>
   <input type="hidden" name="num_size" id="num_size" value="" class= "form-control">

    <select name="sizerow" id="sizerow" class="">
      <option value="">Choose No Size</option>
      <?php $size_counts =[1,2,3,4,5,6,7,8,9,10,11,12];
      foreach ($size_counts as $sizes) {
        $numrow = explode(',', $sizes);
        $sizerowarray = $numrow[0];
        echo '<option value="'.$sizerowarray.'" data-sizerow="'.$sizerowarray.'".>'.$sizerowarray.'</option>';
      }?>
    </select>
  </div>
  </span>
</form>
<?php


?>
<?php include 'includes/footer.php'; ?>
<script>
jQuery('#num_size_form').change(function(){

  var sizerow = jQuery('#sizerow option:selected').data("sizerow");
  jQuery("#num_size").val(sizerow);
  jQuery( "#num_size_form" ).submit();
  return false;

});
</script>
