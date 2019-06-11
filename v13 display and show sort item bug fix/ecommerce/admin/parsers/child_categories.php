<?php
//access dtabase object in staff_init.php
require_once $_SERVER['DOCUMENT_ROOT'].'/ecommerce/core/init.php';
//require_once $_SERVER['DOCUMENT_ROOT'].'/ecommerce/core/staff_init.php';
$parentID =(int)$_POST['parentID']; //see admin footer for parent ID
$selected = sanitize($_POST['selected']);
$childQuery = $db->query("SELECT * FROM categories WHERE parent = '$parentID' ORDER BY category");
ob_start(); ?>
<option value=""></option>
<?php while($child = mysqli_fetch_assoc($childQuery)): ?>
  <option value="<?=$child['id'];?>"<?=(($selected == $child['id'])?'selected':'');?>><?=$child['category'];?></option>
<?php endwhile; ?>
<?php echo ob_get_clean();?> <!-- release the memory from the buffer created and echo result to be received in footer.php-->
