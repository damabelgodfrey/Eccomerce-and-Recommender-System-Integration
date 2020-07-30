<?php
require_once $_SERVER['DOCUMENT_ROOT'].'/ecommerce/core/staff-init.php';
$dyear = sanitize(isset($_POST['year']) ?  $_POST['year'] : date('Y'));
$dmonth = sanitize(isset($_POST['month']) ?  $_POST['month'] : date('m'));
$dday = (int)sanitize(isset($_POST['day']) ?  $_POST['day'] : date('d'));
$monthL = sanitize(isset($_POST['monthlabel']) ?  $_POST['monthlabel'] : 'Error');
$count =1;

$staffTQuery = $db->query("SELECT * FROM transactions WHERE YEAR(txn_date) = '{$dyear}' AND MONTH(txn_date)= '{$dmonth}' AND DAY(txn_date)= '{$dday}'");

?>
<!--Product Details light Box -->
<?php ob_start(); ?>
<div class="modal fade details-1" id="details-modal" tabindex="-1" role="dialog" aria-labelledby="details-1" aria-hidden="true" data-backdrop="static" data-keyboard="false">
      <div class="modal-header">
        <button  class="close " type="button" onclick = "closeModal()" aria-label="close">
          <span aria-hidden="true">&times;</span>
        </button>
        <h2 class="modal-title text-center"><?=$dday;?> <?=$monthL;?> <?=$dyear;?></h2>
      </div>
      <div class="modal-body">
        <div class"container-fluid ">
          <table class="table table-bordered table-striped table-condensed table-hover">
            <thead class= "bg-primary"><th>Details</th>
              <th>
                <table class="table table-bordered table-striped table-condensed">Items Ordered
                 <thead class= "bg-primary"><th>Qty</th><th>Item</th><th>Size</th><th>Price</th><th>Category</th></thead>
               </table>
             </th>
            <th>Sub total</th><th>Grand Total</th></thead>
            <tbody>
              <?php
              if($staffTQuery->num_rows > 0){ ?>
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
                <td><?=$userT['full_name'];?><br><?=$userT['email'];?>
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
                        <td><?=money((int)$product['price']);?></td>
                        <td><?=$product['parent'].' ~ '.$product['child'];?></td>
                      </tr>
                      <?php } ?>
                    </tbody>
                  </table>
                </td>
                <td><?=money((int)$userT['sub_total']);?><br> DED: <?=($userT['tax'] != 0)?money((int)$userT['tax']):'N/A';?></td>
                <td><?=money((int)$userT['grand_total']);?><br>TYPE: <?=$userT['txn_type'];?><br></td>
              </tr>
              <?php $count++; ?>
            <?php endwhile; }?>
            </tbody>
          </table>


  </div>
      <!--footer of the product detail pop up-->
    </div>
</div>
<script>
$("#details-modal").draggable({
    handle: ".modal-header"
});
function closeModal(){
  jQuery('#details-modal').modal('hide');
  setTimeout(function(){
    jQuery('#details-modal').remove();
    jQuery('.modal.backdrop').remove();
  },500);
}
$('#details-modal').on('show', function () {
      $('.modal-body',this).css({width:'auto',height:'auto', 'max-height':'100%','max-width':'100%'});
});
</script>
<?php echo ob_get_clean(); ?>
