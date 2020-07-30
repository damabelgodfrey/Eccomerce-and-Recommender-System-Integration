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
if(isset($_POST['searchInventory'])){
    if(empty($_POST['searchInventory'])){
        $errors[] = "Please input search item into the search box";
        if(!empty($errors)){
          echo display_errors($errors);

        }
    }else{
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
        <br>
        <p></p>
        <div class="box">
        <div class="text-center">
          <h3>⇩Full Inventory⇩</h3>
        </div>
        <div class="panel panel-default">
        <div class="panel-heading text-center">
          <div class="search-container form-group">
            <form action="inventory" method="post">
              <div class="col-xs-4 pull-left">
                <input type="text" class="pull-left form-control" placeholder="Search Inventory.." name="searchInventory" required>
              </div>
              <div class="col-xs-2 pull-left">
                <button type="submit" class=" pull-left btn btn btn-md btn-default"><span class="glyphicon glyphicon-search"></span> Search</button>
              </div>
            </form>
            </div>
        <div class="text-center col-xs-4 pull-right">
          <h3><a href="lowinventory" class ="btn btn-lg btn-success pull-right form-control" id="add-product-btn">View Low Inventory</a></h3>
        </div><br><br>
        <?php if(isset($_POST["searchInventory"])){?>
          <form action="inventory" method="post">
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
        <table id="" class="table table-striped table-bordered table-condensed table-hover">
            <thead class= "bg-primary">
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
                <td><a href ="products?edit=<?=$I_item['id'];?>" class= "btn btn-info btn-xs"><span class="glyphicon glyphicon-pencil"> </span></a>
                <?=$I_item['title'];?></td>
                <td><?=$cat['parent']. ' ~ '.$cat['child'];?></td>
                <td>
                    <table class="table table-bordered table-striped table-condensed">
                      <thead></thead>
                      <tbody>
                          <?php $sqt = sizesToArray($I_item['sizes']);?>
                          <?php foreach ($sqt as $sqts): ?>
                        <tr>
                          <td><?=$sqts['size'];?></td>
                          <td><?=$sqts['price'];?></td>
                          <td><?=$sqts['quantity'];?></td>
                          <td><?=$sqts['threshold'];?></td>
                        </tr>
                        <?php endforeach; ?>
                      </tbody>
                    </table>
                </td>
              </tr>
            <?php endforeach; }?>
            </tbody>
          </table>
        </div></div><p></p>
        <div class="box">
          <div class="panel-footer"><?php  echo $pagination->createLinks(); ?></div>
        </div>
        <p></p><br><hr>
   <?php include 'includes/footer.php'; ?>
