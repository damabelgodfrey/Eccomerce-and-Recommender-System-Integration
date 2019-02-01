<?php
require_once '../core/init.php';
if(!is_logged_in()){
  login_error_redirect();
}
//check if user has permision to view page
if(!check_staff_permission('admin')){
  permission_error_redirect('index.php');
}
include 'includes/head.php';
include 'includes/navigation.php';
include_once 'includes/Pagination.class.php';
$limit = 10;
$offset = sanitize(!empty($_GET['page'])?(($_GET['page']-1)*$limit):0);
//get number of rows
$queryNum = $db->query(sanitize("SELECT COUNT(*) as postNum FROM products"));
$resultNum = $queryNum->fetch_assoc();
$rowCount = $resultNum['postNum'];
//initialize pagination class
$pagConfig = array(
    'baseURL'=>'http://localhost:81/ecommerce/admin/inventory.php',
    'totalRows'=>$rowCount,
    'perPage'=>$limit
);
$pagination =  new Pagination($pagConfig);
?>

<!--Store complete Inventory -->
<?php
 //$iQuery = $db->query("SELECT * FROM products WHERE archive = 0 ORDER BY title");
 $iQuery = $db->query("SELECT * FROM products ORDER BY id ASC LIMIT $offset,$limit");
 $iventory_Items = array();
 while($product = mysqli_fetch_assoc($iQuery)){
   $i_item = array();
   $sizes = sizesToArray($product['sizes']);
   foreach ($sizes as $size) {
     //if ($size['quantity']<= $size['threshold']) {
       $cat = get_category($product['categories']);
       $i_item = array(
         'id' => $product['id'],
       'title' => $product['title'],
       'size'  => $size['size'],
       'quantity'  => $size['quantity'],
       'threshold'  => $size['threshold'],
       'category'  => $cat['parent']. ' ~ '.$cat['child'],
     );
     $iventory_Items[] = $i_item;
   }
 //}
}
$count = 0;
?>
  <div class="col-md-12">
    <h3 class ="text-center"> Full Inventory</h3>
    <table class="table table-condensed table-striped table-bordered">
      <thead class= "bg-primary">
        <th>S/N</th>
        <th>Product</th>
        <th>Category</th>
        <th>Size</th>
        <th>Quantity</th>
        <th>Threshold</th>
      </thead>
      <tbody>
        <?php if($query->num_rows > 0){ ?>
            <div class="posts_list">
        <?php foreach ($iventory_Items as $I_item):?>
        <tr <?=($I_item['quantity'] == 0)? ' class="danger"':''?>>
          <td><?=$I_item['id'];?></td>
          <td><?=$I_item['title'];?></td>
          <td><?=$I_item['category'];?></td>
          <td><?=$I_item['size'];?></td>
          <td><?=$I_item['quantity'];?></td>
          <td><?=$I_item['threshold'];?></td>
        </tr>
      <?php endforeach; }?>
      </tbody>
    </table>
    <?php echo $pagination->createLinks(); ?>
  </div>
</div>

 <?php include 'includes/footer.php'; ?>
