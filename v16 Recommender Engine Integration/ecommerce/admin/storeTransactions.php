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
$errors=array();
$limit = 10;
$offset = sanitize(!empty($_GET['page'])?(($_GET['page']-1)*$limit):0);
if(isset($_POST['searchTransactions']) && !empty($_POST['searchTransactions'])) {
$search = sanitize($_POST['searchTransactions']);
  $query1 = $db->query("SELECT * FROM transactions WHERE full_name LIKE '%".$search."%' OR email LIKE '%".$search."%' OR status LIKE '%".$search."%'  OR charge_id LIKE '%".$search."%'");
  $rowCount = mysqli_num_rows($query1);
  $limit =$rowCount; //ignore pagination by setting limit to the returned rows
  $staffTQuery = $db->query("SELECT * FROM transactions WHERE full_name LIKE '%".$search."%' OR email LIKE '%".$search."%' OR status LIKE '%".$search."%' OR charge_id LIKE '%".$search."%' ORDER BY txn_date DESC LIMIT $offset,$limit");
    if(is_null($staffTQuery) || $rowCount ==0) {
      $errors[] = "The search item returns no result";
        if(!empty($errors)){
          echo display_errors($errors);
        }
      }
}else{
$queryNum = $db->query(sanitize("SELECT COUNT(*) as postNum FROM transactions"));
$resultNum = $queryNum->fetch_assoc();
$rowCount = $resultNum['postNum'];
$staffTQuery = $db->query("SELECT * FROM transactions ORDER BY txn_date DESC LIMIT $offset,$limit");

}
$pagConfig = array(
  'baseURL'=>'http://istore.epizy.com/ecommerce/admin/storeTransactions',
  'totalRows'=>$rowCount,
  'perPage'=>$limit
);
$pagination =  new Pagination($pagConfig);
$count = 1;
 ?>
<p></p>
<div class="box">
<h2 class="text-center">Transaction Table </h2><hr>
<div class="search-container">
  <form action="storeTransactions" method="post" required>
    <div class="form-group col-md-5">
      <input type="text" class="form-control" placeholder="Search Transactions.." name="searchTransactions">
      <button type="submit" class="btn btn btn-lg btn-default"><span class="glyphicon glyphicon-search"></span> Search Transaction</button>
    </div>
  </form>
</div>
</div>
<p></p>
<div class="box">
 <table class="table table-bordered table-striped table-condensed table-hover">
   <thead class= "bg-primary"><th>Status</th><th>Details</th><th>Charge</th>
     <th>
       <table class="table table-bordered table-striped table-condensed">Items Ordered
        <thead class= "bg-primary"><th>Qty</th><th>Item</th><th>Size</th><th>Price</th><th>Category</th></thead>
      </table>
    </th>
   <th>Summation</th></thead>
   <tbody>
     <?php
     if($staffTQuery->num_rows > 0){ ?>
         <div class="posts_list">
     <?php while($userT = $staffTQuery->fetch_assoc()):
     //  $cart = mysqli_fetch_assoc($userT);
       $items = json_decode($userT['items'],true);
       $idArray = array();
       $products = array();
       foreach ($items as $item) {
         if(!empty($item)){
           $idArray[] = $item['id'];
         }
       }

       $ids = implode(',',$idArray);
       $productQ = $db->query(
         "SELECT i.id as 'id', i.title as 'title', c.id as 'cid', c.category as 'child', p.category as 'parent'
         FROM products i
         LEFT JOIN categories c ON i.categories = c.id
         LEFT JOIN categories p ON c.parent = p.id
         WHERE i.id IN ({$ids})
         ");
         while ($p = mysqli_fetch_assoc($productQ)){
           foreach ($items as $item) {
             if ($item['id'] == $p['id']) {
               $x = $item;
               $products[] = array_merge($x,$p); //add item and product array
               continue;
             }
           }
         }
           ?>
     <tr <?=(strcasecmp($userT['status'], 'Not Complete') == 0)? ' class="danger"':''?>>
       <td><?=$count;?><p></p><?=$userT['status'];?></td>
       <td><?=$userT['full_name'];?><br><?=$userT['email'];?><br><?=$userT['phone'];?><br><br>
         <address>
           <?=$userT['street'];?><br>
           <?=(($userT['street2'] != '')?$userT['street2'].'<br>': '');?>
           <?=$userT['city'].', '.$userT['state'].', '.$userT['zip_code'];?><br>
           <?=$userT['country'];?><br>
         </address>
       </td>
       <td>ID: <?=$userT['charge_id'];?><br>
           TYPE: <?=$userT['txn_type'];?><br>
           DATE: <?=my_dateFormat($userT['txn_date']);?>
        </td>
       <td>
         <table class="table table-bordered table-striped table-condensed">
           <thead></thead>
           <tbody>
               <?php foreach($products as $product){ ?>
             <tr>
               <td><?=$product['quantity'];?></td>
               <td><?=$product['title'];?></td>
               <td><?=$product['size'];?> => <?=$product['request'];?></td>
               <td><?=money((int)$product['price']);?>
                       <?php if($product['discount'] > 0){?> <?=$product['discount'];?>% disc <?php } ?>
               </td>
               <td><?=$product['parent'].' ~ '.$product['child'];?></td>
             </tr>
             <?php } ?>
           </tbody>
         </table>
       </td>
       <td><?=money((int)$userT['sub_total']);?><br>
         <?=($userT['tax'] != 0)?'Tax:'.money((int)$userT['tax']):'';?>
         <br><?=($userT['discount'] != 0)?'Disc:'.money((int)$userT['discount']):'';?>
         <hr><p class="text-danger text-center">Sum: <?=money((int)$userT['grand_total']);?></p></td>
     </tr>
     <?php $count++; ?>
   <?php endwhile; }?>
   </tbody>
 </table>
</div>
<p></p>
<div class="box">
<?php echo $pagination->createLinks(); ?>
</div><p></p>
<?php include 'includes/footer.php'; ?>
