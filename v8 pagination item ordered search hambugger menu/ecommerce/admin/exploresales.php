<?php
require_once '../core/init.php';
//is_logged_in function is in helper file
//check if user is logged in on any of the pages
if(!is_logged_in()){
  header('Location:Login.php');
}
include 'includes/head.php';
include 'includes/navigation.php';
include_once 'includes/Pagination.class.php';
$limit = 10;
$offset = sanitize(!empty($_GET['page'])?(($_GET['page']-1)*$limit):0);
?>
<!--Story Inventory -->
<?php
 $iQuery = $db->query("SELECT * FROM products ORDER BY title ASC LIMIT $offset,$limit");
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
$rowCount= count($lowItems);
//initialize pagination class
$pagConfig = array(
    'baseURL'=>'http://localhost:81/ecommerce/admin/exploresales.php',
    'totalRows'=>$rowCount,
    'perPage'=>$limit
);
$pagination =  new Pagination($pagConfig);
?>
  <div class="col-md-12">
    <h3 class ="text-center"> Low Inventory</h3>
    <table class="table table-condensed table-striped table-bordered">
      <thead>
        <th>Product</th>
        <th>Category</th>
        <th>Size</th>
        <th>Quantity</th>
        <th>Threshold</th>
      </thead>
      <tbody>
        <?php if($query->num_rows > 0){ ?>
            <div class="posts_list">
              <?php foreach ($lowItems as $item): ?>
              <tr <?=($item['quantity'] == 0)? ' class="danger"':''?>>
                <td><?=$item['title'];?></td>
                <td><?=$item['category'];?></td>
                <td><?=$item['size'];?></td>
                <td><?=$item['quantity'];?></td>
                <td><?=$item['threshold'];?></td>
              </tr>
      <?php endforeach; }?>
      </tbody>
    </table>
    <?php echo $pagination->createLinks(); ?><hr><br>
  </div>
  <?php
// Sets the top option to be the current year. (IE. the option that is chosen by default).
$currently_selected1 = date('Y');
$currently_selected2 = date('Y');
// Year to start available options at
$earliest_year = 2015;
$latest_year = date('Y');
$selected_val1 = (int)date("Y");
$selected_val2 = $selected_val1-1;
?>
<hr><br>
<form action="exploresales.php" method="post">
    <div class="form-group col-md-3">
       <label for="Year">Year 1</label>
       <select class="form-control" name="myYear1" placeholder="Choose Year" required>
          <option value="">Choose Year</option>
         <?php foreach ( range( $latest_year, $earliest_year ) as $i ) { ?>
                 <option value="<?=$i;?>"<?=(($i === $currently_selected1)? ' selected' : '');?>> <?=$i;?></option>
         <<?php } ?>
       </select>
    </div>
    <div class="form-group col-md-3">
       <label for="Year">Year 2</label>
       <select class="form-control" name="myYear2" placeholder="Choose Year" required>
         <option value="">Choose Year</option>
       <?php foreach(range( $latest_year, $earliest_year ) as $i ) { ?>
               <option value="<?=$i;?>"<?=(($i === $currently_selected2)? 'selected' : '');?>> <?=$i;?></option>
       <?php } ?>
       </select>
    </div>
    <div class="form-group col-md-8">
        <input type="submit" name="submit" class="btn btn-success" value="Fetch Monthly Sale" />
    </div><div class="clearfix"></div>
</form>
<?php
if(isset($_POST['submit'])){
  $selected_val1 = (int)((isset($_POST['myYear1']))?sanitize($_POST['myYear1']):'');
  $selected_val2 = (int)((isset($_POST['myYear2']))?sanitize($_POST['myYear2']):'');
  $thisYrQ = $db->query("SELECT grand_total,txn_date FROM transactions WHERE YEAR(txn_date) = $selected_val1");
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
  <th>Month</th>
  <th><?=$selected_val1;?></th>
  <th><?=$selected_val2;?></th>
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
