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
        <?php if($query->num_rows > 0){ ?>
            <div class="posts_list">
              <?php foreach ($lowItems as $item): ?>
              <tr <?=($item['quantity'] == 0)? ' class="danger"':''?>>
                <td><?=$item['title'];?></td>
                <td><?=$item['category'];?></td>
                <td><?=$item['size'];?></td>
                <td><?=$item['price'];?></td>
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
$selected_yr1 = (int)date("Y");
$selected_yr2 = $selected_yr1-1;
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
      <div id = "errors"class=""></div>
    </div><div class="clearfix"></div>
</form>
<?php
if(isset($_POST['submit'])){
  $selected_yr1 = (int)((isset($_POST['myYear1']))?sanitize($_POST['myYear1']):'');
  $selected_yr2 = (int)((isset($_POST['myYear2']))?sanitize($_POST['myYear2']):'');
  if ($selected_yr1===$selected_yr2) {
    ?> <script>
    var error = '';
    error += '<p class="text-warning bg-danger text-center">Plz note both year chosen is similar!</p>';
    jQuery('#errors').html(error);
    </script><?php
  }
  $year1YrQ = $db->query("SELECT grand_total,txn_date FROM transactions WHERE YEAR(txn_date) = '{$selected_yr1}'");
  $year2YrQ = $db->query("SELECT grand_total,txn_date FROM transactions WHERE YEAR(txn_date) = '{$selected_yr2}'");
}else{
  $year1YrQ = $db->query("SELECT grand_total,txn_date FROM transactions WHERE YEAR(txn_date) = '{$selected_yr1}'");
  $year2YrQ = $db->query("SELECT grand_total,txn_date FROM transactions WHERE YEAR(txn_date) = '{$selected_yr2}'");
}

$year1 = array();
$year2 = array();
$year1Total = 0;
$year2Total = 0;
while($x = mysqli_fetch_assoc($year1YrQ)){
  $month1 = (int)date("m",strtotime($x['txn_date']));
  //add grand total to the month if that month is already in array with a grand total
  //add next grand total to previous grand total.
    if(!array_key_exists($month1,$year1)){
      $year1[(int)$month1] = $x['grand_total'];
    }else{
      $year1[(int)$month1] += $x['grand_total'];
    }
  //$year1[(int)$month1] += $x['grand_total'];
  $year1Total += $x['grand_total'];
}

while($y = mysqli_fetch_assoc($year2YrQ)){
  $month2 = (int)date("m",strtotime($y['txn_date']));
    if(!array_key_exists($month2,$year2)){
      $year2[(int)$month2] = $y['grand_total'];
    }else{
      $year2[(int)$month2] += $y['grand_total'];
    }
  $year2Total += $y['grand_total'];
}


?>
<div class ="col-md-4">
<h3 class="text-center">Sales By Month</h3>
  <table class="table table-condensed table-striped table-bordered">
  <thead>
  <th>Month</th>
  <th><?=$selected_yr1;?></th>
  <th><?=$selected_yr2;?></th>
  </thead>
      <tbody>
      <?php for($i = 1; $i <= 12; $i++):
             $dt = DateTime::createFromFormat('!m',$i);
             $futureMonth1 =  (date("m") < $i && $selected_yr1 >=(int)date("Y"))?'':money(0); //mark future month with no sale
             $futureMonth2 =  (date("m") < $i && $selected_yr2 >=(int)date("Y"))?'':money(0);
       ?>
        <tr<?=(date("m")==$i)?' class="info"':'';?>>
          <td><?=$dt->format("F");?></td>
          <td><?=(array_key_exists($i,$year1))?money($year1[$i]):$futureMonth1;?></td>
          <td><?=(array_key_exists($i,$year2))?money($year2[$i]):$futureMonth2;?></td>
        </tr>
      <?php endfor; ?>
        <tr>
         <td class= "bg-primary">Total</td>
         <td class= "bg-primary"><?=money($year1Total);?></td>
         <td class= "bg-primary"><?=money($year2Total);?></td>
        </tr>
      </tbody>
  </table>
</div>
<script>
;(function($){

  /**
   * Store scroll position for and set it after reload
   *
   * @return {boolean} [loacalStorage is available]
   */
  $.fn.scrollPosReaload = function(){
      if (localStorage) {
          var posReader = localStorage["posStorage"];
          if (posReader) {
              $(window).scrollTop(posReader);
              localStorage.removeItem("posStorage");
          }
          $(this).click(function(e) {
              localStorage["posStorage"] = $(window).scrollTop();
          });

          return true;
      }

      return false;
  }

  /* ================================================== */

  $(document).ready(function() {
      // Feel free to set it for any element who trigger the reload
      $('select').scrollPosReaload();
  });

}(jQuery));
</script>
