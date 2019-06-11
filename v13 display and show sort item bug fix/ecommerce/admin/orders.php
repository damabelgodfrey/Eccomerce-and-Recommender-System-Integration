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
$_SESSION['staff_rdrurl'] = $_SERVER['REQUEST_URI'];

//complete orders
if(isset($_GET['complete']) && $_GET['complete'] == 1) {
  $cart_id = sanitize($_GET['cart_id']);
  $db->query("UPDATE cart SET shipped = 1 WHERE id = '{$cart_id}'");
  $db->query("UPDATE transactions SET status = 'Complete' WHERE cart_id = '{$cart_id}'");
  $_SESSION['success_flash'] = "The Order Has been Completed!";
  header('Location: index');
}

$txn_id = sanitize((int)$_GET['txn_id']);
$txnQuery = $db->query("SELECT * FROM transactions WHERE id = '{$txn_id}'");
$txn = mysqli_fetch_assoc($txnQuery);
$cart_id = $txn['cart_id'];
$cartQ = $db->query("SELECT * FROM cart WHERE id = '{$cart_id}'");
$cart = mysqli_fetch_assoc($cartQ);
$items = json_decode($cart['items'],true);
$idArray = array();
$products = array();

foreach ($items as $item) {
  $idArray[] = $item['id'];
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
<h2 class="text-center">Items Ordered </h2>
<table class="table table-condesed table-bordered table-striped table-hover" id=orderTableHead1 >
  <thead class= "bg-primary">
    <th>Title</th><th>Quantity</th><th>Category</th><th>Size/Request</th>
  </thead>
  <tbody>
    <?php foreach($products as $product): ?>
    <tr>
      <td><?=$product['title'];?></td>
      <td><?=$product['quantity'];?></td>
      <td><?=$product['parent'].' ~ '.$product['child'];?></td>
      <td><?=$product['size'];?> => <?=$product['request'];?></td>
    </tr>
  <?php endforeach; ?>
</tbody>
</table>

<div class="row">
  <div class="col-md-6">
    <h3 class="text-center">Order Details</h3>
    <table class="table table-condesed table-bordered table-striped" id=orderTableHead2>
      <tbody>
        <tr>
           <td class= "bg-primary">Sub Total</td>
           <td><?=money($txn['sub_total']);?></td>
        </tr>
        <tr>
          <td class= "bg-primary">Tax</td>
          <td><?=money($txn['tax']);?></td>
        </tr>
        <tr>
          <td class= "bg-primary">Grand Total</td>
          <td><?=money($txn['grand_total']);?></td>
         </tr>
        <tr>
          <td class= "bg-primary">Order Date</td>
          <td><?=my_dateFormat($txn['txn_date']);?></td>
         </tr>
      </tbody>
    </table>
  </div>
  <div class="col-md-6">
  <h3 class="text-center">Shipping Address</h3>
  <address>
    <?=$txn['full_name']; ?><br>
    <?=$txn['street']; ?><br>
    <?=($txn['street2'] != '')?$txn['street2'].'<br>':''; ?>
    <?=$txn['city'].', '. $txn['state'].' '.$txn['zip_code']; ?><br>
    <?=$txn['country']; ?><br>
  </address>
  </div>
</div>
<div class='pull-right'>
 <a href="orderedItem" class="btn btn-large btn-default">Cancel</a>
 <a href="orders?complete=1&cart_id=<?=$cart_id;?>" class="btn btn-primary btn-large" onclick="return confirmC()">Complete Order</a>
 </div>

 <?php include 'includes/footer.php'; ?>
 <script>
 function confirmC(){
 var del=confirm("Are you sure you want to complete order?");
 if (del==true){
 //   alert ("record deleted")
 }
 return del;
 }
 </script>
