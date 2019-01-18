<?php
require_once '../core/init.php';
//is_logged_in function is in helper file
//check if user is logged in on any of the pages
if(!is_logged_in()){
  header('Location:Login.php');
}

include 'includes/head.php';
include 'includes/navigation.php';
?>
<?php
  $txnQuery ="SELECT t.id, t.cart_id, t.full_name, t.description,
              t.txn_date,t.grand_total, c.items, c.paid, c.shipped
      FROM transactions t
      LEFT JOIN cart c ON t.cart_id = c.id
      WHERE c.paid = 1 AND c.shipped = 0
      ORDER BY t.txn_date";
  $txnResults = $db->query($txnQuery);

?>
<div class="col-md-12">
  <h3 class="text-center">Order To Ship</h3>
  <table class="table table-condesed table-bordered table-striped">
    <thead>
      <th></th><th>Name</th><th>Description</th><th>Total</th><th>Order Date</th>
    </thead>
    <tbody>
      <?php while ($order = mysqli_fetch_assoc($txnResults)): ?>
      <tr>
        <td> <?=$order['id'];?>⇒<a href="orders.php?txn_id=<?=$order['id'];?>" class="btn btn-xs btn-info">Details</td>
        <td><?=$order['full_name'];?></td>
        <td><?=$order['description'];?></td>
        <td><?=money($order['grand_total']);?></td>
        <td><?=my_dateFormat($order['txn_date']);?></td>
      </tr>
    <?php endwhile; ?>
  </tbody>
</table>
</div>
     <?php
  // Sets the top option to be the current year. (IE. the option that is chosen by default).
  $currently_selected1 = date('Y');
  $currently_selected2 = date('Y');
  // Year to start available options at
  $earliest_year = 2000;
  // Set your latest year you want in the range, in this case we use PHP to just set it to the current year.
  $latest_year = date('Y');
  $selected_val1 = (int)date("Y");
  $selected_val2 = $selected_val1-1;
?>
<form action="#" method="post">
    <div class="col-xs-2">
      <label for="Year">Yr1</label>
      <select class="col-xs-6" name="myYear">
      <!-- Loops over each int[year] from current year, back to the $earliest_year [1950] -->
      <?php foreach ( range( $latest_year, $earliest_year ) as $i ) { ?>
        <!-- Prints the option with the next year in range. -->
        <option value="<?=$selected_val1;?>"<?=(($i === $currently_selected1)? ' selected' : '');?>> <?=$i;?></option>
      <<?php } ?>
      </select>
    </div>
  <input type="submit" name="submit" value="Fetch Yr1 Sale" />
<?= var_dump($currently_selected1); ?>
<?= var_dump($i); ?>
<?= var_dump($selected_val1);?>

</form>
<form action="#" method="post">
  <!--For second year -->
    <div class="col-xs-2">
      <label for="Year2">Yr2</label>
      <select class="col-xs-6" name="myYear2">
      <!-- Loops over each int[year] from current year, back to the $earliest_year [1950] -->
      <?php foreach ( range( $latest_year, $earliest_year ) as $i ) { ?>
        <!-- Prints the option with the next year in range. -->
        <option value="<?=$i;?>"<?=(($i === $currently_selected2)? ' selected="selected"' : '');?>> <?=$i;?></option>
      <<?php } ?>
      </select>
    </div>
  <input type="submit" name="submit2" value="Fetch Yr1 Sale" />
  </form>
<?php


  if(isset($_POST['submit'])){
  $selected_val1 = (int)$_POST['myYear'];  // Storing Selected Value In Variable
  $thisYrQ = $db->query("SELECT grand_total,txn_date FROM transactions WHERE YEAR(txn_date) = $selected_val1");
  $lastYrQ = $db->query("SELECT grand_total,txn_date FROM transactions WHERE YEAR(txn_date) = '{$selected_val2}'");
}elseif(isset($_POST['submit2'])){
  $selected_val2 = $_POST['myYear2'];  // Storing Selected Value In Variable
  $thisYrQ = $db->query("SELECT grand_total,txn_date FROM transactions WHERE YEAR(txn_date) = '{$selected_val1}'");
  $lastYrQ = $db->query("SELECT grand_total,txn_date FROM transactions WHERE YEAR(txn_date) = '{$selected_val2}'");
}else{
$thisYrQ = $db->query("SELECT grand_total,txn_date FROM transactions WHERE YEAR(txn_date) = '{$selected_val1}'");
$lastYrQ = $db->query("SELECT grand_total,txn_date FROM transactions WHERE YEAR(txn_date) = '{$selected_val2}'");
}
   $current = array();
   $last = array();
   $currentTotal = 0;
   $lastTotal = 0;
   while($x = mysqli_fetch_assoc($thisYrQ)){

     $month = (int)date("m",strtotime($x['txn_date']));
     //add grand total to the month if that month is already in array with a grand total
     //add next grand total to previous grand total.
     if(!array_key_exists($month,$current)){
       $current[(int)$month] = $x['grand_total'];
     }else{
       $current[(int)$month] += $x['grand_total'];
     }
     //$current[(int)$month] += $x['grand_total'];
     $currentTotal += $x['grand_total'];
   }

   while($y = mysqli_fetch_assoc($lastYrQ)){
     $month = (int)date("m",strtotime($y['txn_date']));
     //add grand total to the month if that month is already in array with a grand total
     //add next grand total to previous grand total.
     if(!array_key_exists($month,$last)){
       $last[(int)$month] = $y['grand_total'];
     }else{
       $last[(int)$month] += $y['grand_total'];
     }
     $lastTotal += $y['grand_total'];
   }

  ?>
 <div class ="col-md-4">
   <h3 class="text-center">Sales By Month</h3>
   <table class="table table-condensed table-striped table-bordered">
   <thead>
     <th></th>
     <th>Yr2=> <?=$selected_val2;?></th>
     <th>Yr1=> <?=$selected_val1;?></th>
   </thead>
   <tbody>
     <?php for($i = 1; $i <= 12; $i++):
      $dt = DateTime::createFromFormat('!m',$i);
      $futureMonth = (date("m")>=$i)?money(0):''; //mark future month with no sale
      ?>
     <tr<?=(date("m")==$i)?' class="info"':'';?>>
       <td><?=$dt->format("F");?></td>
       <td><?=(array_key_exists($i,$last))?money($last[$i]):money(0);?></td>
       <td><?=(array_key_exists($i,$current))?money($current[$i]):$futureMonth;?></td>
     </tr>
   <?php endfor; ?>
   <tr>
      <td class= "bg-primary">Total</td>
      <td class= "bg-primary"><?=money($lastTotal);?></td>
      <td class= "bg-primary"><?=money($currentTotal);?></td>
   </tr>
   </tbody>
 </table>
</div>

<!--Story Inventory -->
<?php
 $iQuery = $db->query("SELECT * FROM products WHERE deleted = 0");
 $lowItems = array();
 while($product = mysqli_fetch_assoc($iQuery)){
   $item = array();
   $sizes = sizesToArray($product['sizes']);
   foreach ($sizes as $size) {
     if ($size['quantity']<= $size['threshold']) {
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
 }
}
?>
  <div class="col-md-8">
    <h3 class ="text-center"> Low Inventory <a href="inventory.php" class="btn btn-xs btn-info">View Full Inventory </a></h3>
    <table class="table table-condensed table-striped table-bordered">
      <thead>
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
