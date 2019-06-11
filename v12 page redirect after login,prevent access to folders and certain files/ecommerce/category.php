<?php
  require_once 'core/init.php';
  include 'includes/head.php';
  include 'includes/navigation.php';
//  include 'includes/headerfull.php';
  include 'includes/leftbar.php';
  include_once 'admin/includes/Pagination.class.php';
  $_SESSION['rdrurl'] = $_SERVER['REQUEST_URI'];
  $limit = 12;
  $offset = sanitize(!empty($_GET['page'])?(($_GET['page']-1)*$limit):0);

  if(isset($_GET['cat'])){
    $cat_id = sanitize($_GET['cat']);
  }else{
    $cat_id ='';
  }

  $sql ="SELECT * FROM products WHERE categories = '$cat_id' AND archive = 0";
  $pCountQ = $db->query($sql);
  $category = get_category($cat_id);
  $rowCount = 0;
  while ($numRow = mysqli_fetch_assoc($pCountQ)){
    $rowCount++;
  }
  //initialize pagination class
  $pagConfig = array(
      'baseURL'=>'http://localhost:81/ecommerce/category.php'.'?cat='.$cat_id,
      'totalRows'=>$rowCount,
      'perPage'=>$limit
  );
  $pagination =  new Pagination($pagConfig);
  $query = $db->query("SELECT * FROM products WHERE archive = 0 AND categories = '$cat_id' LIMIT $offset,$limit");
?>

    <!--main content -->
  <div class="col-md-8">
    <div class="row"><p></p>
        <div class="">
          <h2 class="text-center"><?=$category['parent']. ' '. $category['child'];?></h2>
        </div>
        <?php if($query->num_rows > 0){ ?>
            <div class="posts_list">
              <?php while ($product = $query->fetch_assoc()) : ?>
               <div class="col-xs-4 col-sm-4 col-md-4 padding-0" id = animation>
                 <div class="polaroid text-center">
                   <?php if ($product['sales'] == 1): ?>
                     <button type ="button" id="sales" class="btn btn-xs btn-danger pull-left" onclick="detailsmodal(<?= $product['id']; ?>)">Sales</button>
                   <?php endif; ?>
                   <div class="product_title">
                     <h4><?= $product['title']; ?></h4>
                   </div>
                   <?php $photos = explode(',',$product['image']); ?>
                  <img onclick="detailsmodal(<?= $product['id']; ?>)" src="<?= $photos[0]; ?>" alt="<?= $product['title']; ?>" class="img-thumb" style="width:100%"/>
                  <p></p><p class="list-price" style="color:grey">Was: <s>₦<?= $product['list_price']; ?></s></p>
                  <p class="price">Now: ₦<?= $product['price']; ?></p>
                  <button type ="button" id="dbutton" class="btn btn-sm btn-danger" onclick="detailsmodal(<?= $product['id']; ?>)">DETAILS</button>
               </div>
             </div>
       <?php endwhile;  ?>
    </div><hr>
   <?php } ?>
 </div>
  <!-- display pagination links -->
 <?php echo $pagination->createLinks(); ?>
</div>

<?php

  include "includes/rightbar.php";
  include "includes/footer.php";
  ?>
