<?php
require_once '../core/init.php';
//is_logged_in function is in helper file
//check if user is logged in on any of the pages
if(!is_logged_in()){
  header('Location:Login');
}

include 'includes/head.php';
include 'includes/navigation.php';
?>
<?php
//  $txnQuery ="SELECT t.id, t.cart_id, t.full_name, t.description,
          //    t.txn_date,t.grand_total, c.items, c.paid, c.shipped
    //  FROM transactions t
    //  LEFT JOIN cart c ON t.cart_id = c.id
    //  WHERE c.paid = 1 AND c.shipped = 0
    //  ORDER BY t.txn_date";

  $txnQuery =   "SELECT * FROM transactions WHERE status = 'Not Complete' ORDER BY txn_date" ;
  $txnResults = $db->query($txnQuery);

?>
<div class="col-md-12">
  <h3 class="text-center">Order To Ship</h3>
  <table class="table table-condesed table-bordered table-striped table-hover">
    <thead>
      <th></th><th>Name</th><th>Description</th><th>Total</th><th>Order Date</th>
    </thead>
    <tbody>
      <?php while ($order = mysqli_fetch_assoc($txnResults)): ?>
      <tr>
        <td> <?=$order['id'];?>⇒<a href="orders?txn_id=<?=$order['id'];?>" class="btn btn-xs btn-info">Details</td>
        <td><?=$order['full_name'];?></td>
        <td><?=$order['description'];?></td>
        <td><?=money($order['grand_total']);?></td>
        <td><?=my_dateFormat($order['txn_date']);?></td>
      </tr>
    <?php endwhile; ?>
  </tbody>
</table>
</div>

<?php include 'includes/footer.php'; ?>
