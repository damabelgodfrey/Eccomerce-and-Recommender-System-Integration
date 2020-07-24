<?php
  require_once 'core/init.php';
  include "includes/head.php";
  include "includes/navigation.php";
  //include "includes/headerfull.php";
  //include "includes/leftbar.php";
  include_once 'admin/includes/Pagination.class.php';
  //include '../ecommerce/includes/widgets/filtersnew.php';
  include '../ecommerce/includes/widgets/filters.php';
  $_SESSION['rdrurl'] = $_SERVER['REQUEST_URI'];
  $_SESSION['saleflag'] =$_SERVER['REQUEST_URI'];
  $limit = 20;
  $offset = sanitize(!empty($_GET['page'])?(($_GET['page']-1)*$limit):0);
  //get number of rows
  $queryNum = $db->query(sanitize("SELECT * FROM products WHERE sales= 1 AND defective_product = 0 AND archive = 0 AND category_activate_flag = 1"));
  $rowCount = mysqli_num_rows($queryNum);
  ?><div class="row"><?php
  if($rowCount > 0){
    $pagConfig = array(
        'baseURL'=>'http://localhost:81/ecommerce/sales',
        'totalRows'=>$rowCount,
        'perPage'=>$limit
    );
    $pagination =  new Pagination($pagConfig);
    //$querySales = $db->query("SELECT * FROM products WHERE sales = 1 ASC LIMIT $offset,$limit");
    $querySales = $db->query("SELECT * FROM products WHERE sales = 1 AND defective_product = 0 AND archive = 0 AND category_activate_flag = 1 LIMIT $offset,$limit");

  ?>
        <div class="col-md-9">
          <div class="panel panel-default">
          <div class="panel-heading text-center"><h3>⇩Ameritinz Sales⇩</h3>
            <button onclick="openNav()" type="button" class=" filterbtn btn btn-info btn-sm pull-right">
                      <span class="glyphicon glyphicon-sort"></span> Sort Item
                    </button>
          </div>
          <div class="panel-body">
          <?php
          if(isset($querySales) &&  $querySales->num_rows > 0){ ?>
              <div class="posts_list">
                  <?php while ($product = mysqli_fetch_assoc($querySales)) :
                  $listP = (int)$product['list_price'];
                  $actualP = (int)$product['price'];
                  $perOff = ($listP - $actualP )/ $listP;
                  $perOff = round($perOff * 100);
                  $photos = explode(',',$product['image']);
                     ?>
                   <div class="col-xs-6 col-sm-5 col-md-4 padding-0 animation">
                     <div class="polaroid text-center">
                       <div class="product_title">
                         <h4><strong><?= $product['title']; ?></strong></h4>
                       </div>
                       <div class="imgHolder">
                         <img onclick="detailsmodal('add',<?= $product['id']; ?>)" src="<?= $photos[0]; ?>" alt="<?= $product['title']; ?>" class="img-thumb" style="width:100%"/>
                          <?php if ($product['sales'] == 1): ?>
                            <span>
                              <button type ="button" id="sales" class="btn btn-xs btn-danger pull-left" onclick="detailsmodal('add',<?= $product['id']; ?>)">Sales</button>
                            </span>
                         <?php endif; ?>
                       </div>
                      <p></p><p class="list-price"><s>₦<?= $product['list_price']; ?></s></p>
                      <strong> <p class="price text-danger">₦<?= $product['price']; ?> (<?= $perOff ?>% off)</p></strong>
                      <!--<button type ="button" id="dbutton" class="btn btn-sm btn-danger" onclick="detailsmodal(
                      <?= $product['id']; ?>)">Details</button> -->
                   </div>
                   </div>
                 <?php endwhile;
               ?>
               </div>
             <?php }else{ ?>
               <div class="bg-danger">
                 <p class="text-center text-info">
                   No sale item is retrieved!
                 </p>
               </div>
            <?php } ?>
      </div>
       <div class="panel-footer"><?php echo $pagination->createLinks(); ?></div>
      </div>
    </div>
    <?php include "includes/rightbar.php"; ?>
<?php }else{ ?>
  <div class="bg-danger col-md-9">
    <p class="text-center text-info">
      No sale item is retrieved!
    </p>
  </div>
  <?php include "includes/rightbar.php"; ?>
<?php }

$db->close();
?></div><?php
       include "includes/footer.php";
  ?>
