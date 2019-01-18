<?php
require_once '../core/init.php';
if(!is_logged_in()){
  login_error_redirect();
}
//check if user has permision to view page
if(!has_admin_permission()){
  permission_error_redirect('index.php');
}
include 'includes/head.php';
include 'includes/navigation.php';
?>
<!--Story Inventory -->
<?php
 $iQuery = $db->query("SELECT * FROM products WHERE deleted = 0 ORDER BY title");
 $lowItems = array();
 while($product = mysqli_fetch_assoc($iQuery)){
   $item = array();
   $sizes = sizesToArray($product['sizes']);
   foreach ($sizes as $size) {
     //if ($size['quantity']<= $size['threshold']) {
       $cat = get_category($product['categories']);
       $item = array(
       'title' => $product['title'],
       'size'  => $size['size'],
       'quantity'  => $size['quantity'],
       'threshold'  => $size['threshold'],
       'category'  => $cat['parent']. ' ~ '.$cat['child'],
     );
     $lowItems[] = $item;
   }
 //}
}
?>
  <div class="col-md-8">
    <h3 class ="text-center"> Full Inventory <a href="index.php" class="btn btn-xs btn-info">View Low Inventory </a></h3>
    <table class="table table-condensed table-striped table-bordered">
      <thead class= "bg-primary">
        <th>Product</th>
        <th>Category</th>
        <th>Size</th>
        <th>Quantity</th>
        <th>Threshold</th>
      </thead>
      <tbody>
        <?php foreach ($lowItems as $item): ?>
        <tr <?=($item['quantity'] == 0)? ' class="danger"':''?>>
          <td><?=$item['title'];?></td>
          <td><?=$item['category'];?></td>
          <td><?=$item['size'];?></td>
          <td><?=$item['quantity'];?></td>
          <td><?=$item['threshold'];?></td>
        </tr>
      <?php endforeach; ?>
      </tbody>
    </table>
  </div>
</div>

 <?php include 'includes/footer.php'; ?>
