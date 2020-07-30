<?php
require_once '../core/staff-init.php';
if(!is_staff_logged_in()){
  login_error_redirect();
}
//check if user has permision to view page
if(!check_staff_permission('admin')){
  permission_error_redirect('index.php');
}
include 'includes/head.php';
include 'includes/navigation.php';
?><style>
.box .footerPanel-color {
  color: black;
}
</style><?php
include_once 'includes/Pagination.class.php';
if(isset($_POST['searchInventory'])){
    if(empty($_POST['searchInventory'])){
        $errors[] = "Please input search item into the search box";
        if(!empty($errors)){
          echo display_errors($errors);
        }
    }else{
$search = sanitize($_POST['searchInventory']);
$iQuery = $db->query("SELECT * FROM products WHERE title LIKE '%".$search."%' OR description LIKE '%".$search."%' ORDER BY title ASC ");
  $rowCount = mysqli_num_rows($iQuery);
  if(is_null($iQuery) || $rowCount ==0) {
      $errors[] = "The search item returns no result";
        if(!empty($errors)){
          echo display_errors($errors);
        }
      }
    }
}else{
   $iQuery = $db->query("SELECT * FROM products ORDER BY title ASC ");
 }
   $lowItems = array();
   while($product = mysqli_fetch_assoc($iQuery)){
     $item = array();
     $sizes = sizesToArray($product['sizes']);
     foreach ($sizes as $size) {
       if ($size['quantity']<= $size['threshold']) {
         $cat = get_category($product['categories']);
         $item = array(
         'id' => $product['id'],
         'title' => $product['title'],
         'size'  => $size['size'],
         'price'  => $size['price'],
         'quantity'  => $size['quantity'],
         'threshold'  => $size['threshold'],
         'category'  => $cat['parent']. ' ~ '.$cat['child'],
       );
       $lowItems[] = $item;
     }
   }
  }
  $rowCount= count($lowItems);
  ?>
  <br>
  <p></p>
  <div class="box">
  <div class="text-center">
    <h3>⇩Low Inventory⇩</h3>
  </div>
  <div class="panel panel-default">
  <div class="panel-heading text-center">
    <div class="search-container form-group">
      <form action="lowinventory" method="post">
        <div class="col-xs-4 pull-left">
          <input type="text" class="pull-left form-control" placeholder="Search Inventory.." name="searchInventory" required>
        </div>
        <div class="col-xs-2 pull-left">
          <button type="submit" class=" pull-left btn btn btn-md btn-default"><span class="glyphicon glyphicon-search"></span> Search</button>
        </div>
      </form>
      </div>
  <div class="text-center col-xs-4 pull-right">
    <h3><a href="inventory" class ="btn btn-lg btn-success pull-right form-control" id="add-product-btn">View Full Inventory</a></h3>
  </div><br><br>
  <?php if(isset($_POST["searchInventory"])){?>
    <form action="lowinventory" method="post">
      <div class="input-group col-xs-12">
       <span class="input-group-addon" id="productsortbar"><?= ((isset($_POST["searchInventory"]))?sanitize(($_POST["searchInventory"])):''); ?>
         <button type="submit" class="btn btn btn-md btn-success"><span class="glyphicon glyphicon-refresh" name ="reset"></span>Reset</button>
      </span>
      </div>
    </form>
  <?php } ?>
</div></div>
</div><p></p><br>
  <div class="box">
      <table class="table table-condensed table-striped table-bordered table-hover">
        <thead>
          <th>Product</th>
          <th>Category</th>
          <th>Size</th>
          <th>Price</th>
          <th>Quantity</th>
          <th>Threshold</th>
        </thead>
        <tbody>
          <?php if($iQuery->num_rows > 0){ ?>
              <div class="posts_list">
                <?php foreach ($lowItems as $item): ?>
                <tr <?=($item['quantity'] == 0)? ' class="danger"':''?>>
                  <td><a href ="products?edit=<?=$item['id'];?>" class= "btn btn-info btn-xs"><span class="glyphicon glyphicon-pencil"> </span></a>
                  <?=$item['title'];?></td>
                  <td><?=$item['category'];?></td>
                  <td><?=$item['size'];?></td>
                  <td><?=$item['price'];?></td>
                  <td><?=$item['quantity'];?></td>
                  <td><?=$item['threshold'];?></td>
                </tr>
        <?php endforeach; }?>
        </tbody>
      </table>
    </div></div><p></p>
    <div class="box">
      <div class="panel-footer footerPanel-color">Showing: [<?=$rowCount; ?>] of low Item size below threshold</div>
    </div>
    <p></p><br><hr>
 <?php include 'includes/footer.php'; ?>
