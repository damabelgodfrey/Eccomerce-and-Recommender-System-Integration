<?php
  require_once 'core/init.php';
  include "includes/head.php";
  include "includes/navigation.php";
  //include "includes/headerfull.php";
  include "includes/leftbar.php";
  include_once 'admin/includes/Pagination.class.php';
  $limit = 12;
  $offset = sanitize(!empty($_GET['page'])?(($_GET['page']-1)*$limit):0);
  //get number of rows
  $queryNum = $db->query(sanitize("SELECT COUNT(*) as postNum FROM products WHERE sales= 1"));
  $resultNum = $queryNum->fetch_assoc();
  $rowCount = $resultNum['postNum'];

  //initialize pagination class
  $pagConfig = array(
      'baseURL'=>'http://localhost:81/ecommerce/sales.php',
      'totalRows'=>$rowCount,
      'perPage'=>$limit
  );
  $pagination =  new Pagination($pagConfig);
  //$querySales = $db->query("SELECT * FROM products WHERE sales = 1 ASC LIMIT $offset,$limit");
  $querySales = $db->query("SELECT * FROM products WHERE sales = 1 LIMIT $offset,$limit");
?>

    <!--main content -->
  <div class="col-md-8" id = detailLabel>
    <div class="row">
        <h2 class="text-center">⇩Ameritinz SALES⇩</h2>
        <?php
        if($querySales->num_rows > 0){ ?>
            <div class="posts_list">
                <?php while ($product = mysqli_fetch_assoc($querySales)) :
                $listP = (int)$product['list_price'];
                $actualP = (int)$product['price'];
                $perOff = ($listP - $actualP )/ $listP;
                $perOff = round($perOff * 100);
                   ?>
                 <div class="col-xs-4 padding-0" id = detailLabel>
                   <div class="polaroid text-center">
                     <h4><?= $product['title']; ?></h4>
                     <?php $photos = explode(',',$product['image']); ?>
                    <img onclick="detailsmodal(<?= $product['id']; ?>)" src="<?= $photos[0]; ?>" alt="<?= $product['title']; ?>" class="img-thumb" style="width:100%"/>
                    <p></p><p class="list-price"><s>₦<?= $product['list_price']; ?></s></p>
                    <strong> <p class="price text-danger">₦<?= $product['price']; ?> (<?= $perOff ?>% off)</p></strong>
                    <button type ="button" class="btn btn-sm btn-danger" onclick="detailsmodal(<?= $product['id']; ?>)">Details</button>
                 </div>
                 </div>
               <?php endwhile; }?>
             </div>

    </div>
    <?php echo $pagination->createLinks(); ?>
  </div><hr><br>

<?php
  include "includes/rightbar.php";
  include "includes/footer.php";
  ?>
