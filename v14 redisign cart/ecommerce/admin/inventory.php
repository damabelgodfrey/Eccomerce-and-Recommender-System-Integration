<?php
require_once '../core/staff-init.php';
if(!is_staff_logged_in()){
  login_error_redirect();
}
//check if user has permision to view page
if(!check_staff_permission('admin')){
  permission_error_redirect('index');
}
include 'includes/head.php';
include 'includes/navigation.php';
include_once 'includes/Pagination.class.php';
$_SESSION['staff_rdrurl'] = $_SERVER['REQUEST_URI'];
$errors=array();
$limit = 10;
$offset = sanitize(!empty($_GET['page'])?(($_GET['page']-1)*$limit):0);
if(isset($_POST['searchInventory']) && !empty($_POST['searchInventory'])) {
$search = sanitize($_POST['searchInventory']);
$query1 = $db->query("SELECT * FROM products WHERE title LIKE '%".$search."%' OR description LIKE '%".$search."%'");
$rowCount = mysqli_num_rows($query1);
$limit =$rowCount; //ignore pagination by setting limit to the returned rows
$iQuery = $db->query("SELECT * FROM products WHERE title LIKE '%".$search."%' OR description LIKE '%".$search."%' ORDER BY title ASC LIMIT $offset,$limit");
  if(is_null($iQuery) || $rowCount ==0) {
      $errors[] = "The search item returns no result";
        if(!empty($errors)){
          echo display_errors($errors);
        }
      }
}else{
$queryNum = $db->query(sanitize("SELECT COUNT(*) as postNum FROM products"));
$resultNum = $queryNum->fetch_assoc();
$rowCount = $resultNum['postNum'];
$iQuery = $db->query("SELECT * FROM products ORDER BY title ASC LIMIT $offset,$limit");
}
$pagConfig = array(
    'baseURL'=>'http://localhost:81/ecommerce/admin/inventory',
    'totalRows'=>$rowCount,
    'perPage'=>$limit
);
$pagination =  new Pagination($pagConfig);
?>

    <h2 class ="text-center"> Full Inventory</h2>
    <div class="search-container">
      <form action="inventory" method="post" required>
        <div class="form-group col-md-5">
          <input type="text" class="form-control" placeholder="Search Inventory.." name="searchInventory">
          <button type="submit" class="btn btn btn-lg btn-default"><span class="glyphicon glyphicon-search"></span> Search Inventory</button>
        </div>
      </form>
    </div>
    <table id="table-inventory" class="table table-striped table-bordered table-condensed table-hover">
      <thead class= "bg-primary">
        <th>S/N</th>
        <th>Product</th>
        <th>Category</th>
        <th>
          <table class="table table-bordered table-striped table-condensed">
           <thead class= "bg-primary"><th>Size</th><th>Price</th><th>Qty</th><th>Threshold</th></thead>
         </table>
     </th>
      </thead>
      <tbody>
        <?php if($iQuery->num_rows > 0){ ?>
            <div class="posts_list">
        <?php foreach ($iQuery as $I_item):
          $cat = get_category($I_item['categories']);
          ?>
        <tr>
          <td><?=$I_item['id'];?></td>
          <td><?=$I_item['title'];?></td>
          <td><?=$cat['parent']. ' ~ '.$cat['child'];?></td>
          <td>
              <table class="table table-bordered table-striped table-condensed">
                <thead></thead>
                <tbody>
                    <?php $sqt = sizesToArray($I_item['sizes']);?>
                    <?php foreach ($sqt as $sqts): ?>
                  <tr>
                    <td><strong>Size</strong> => <?=$sqts['size'];?></td>
                    <td><strong>Price</strong> => <?=$sqts['price'];?></td>
                    <td><strong>Qty</strong> => <?=$sqts['quantity'];?></td>
                    <td><strong>Threshold</strong> => <?=$sqts['threshold'];?></td>
                  </tr>
                  <?php endforeach; ?>
                </tbody>
              </table>
          </td>
        </tr>
      <?php endforeach; }?>
      </tbody>
    </table>
    <?php echo $pagination->createLinks(); ?>
  </div>
 <?php include 'includes/footer.php'; ?>
