<?php
  require_once 'core/init.php';
  include 'includes/head.php';
  include 'includes/navigation.php';
//  include 'includes/headerfull.php';
//  include 'includes/leftbar.php';
  include '../ecommerce/includes/widgets/filters.php';
  include_once 'admin/includes/Pagination.class.php';
  $_SESSION['rdrurl'] = $_SERVER['REQUEST_URI'];
  $limit = 20;
  $offset = sanitize(!empty($_GET['page'])?(($_GET['page']-1)*$limit):0);

  if(isset($_GET['cat'])){
    $cat_id = sanitize($_GET['cat']);
  }else{
    $cat_id ='';
  }

  $sql ="SELECT * FROM products WHERE categories = '$cat_id' AND archive = 0 AND defective_product = 0 AND category_activate_flag =1";
  $productQ = $db->query($sql);
  $category = get_category($cat_id);
  $return = mysqli_num_rows($productQ);
  //initialize pagination class
  $pagConfig = array(
      'baseURL'=>'http://localhost:81/ecommerce/category'.'?cat='.$cat_id,
      'totalRows'=>$return,
      'perPage'=>$limit
  );
  $pagination =  new Pagination($pagConfig);
  $query = $db->query("SELECT * FROM products WHERE archive = 0 AND defective_product = 0 AND categories = '$cat_id'AND category_activate_flag =1 LIMIT $offset, $limit");
?>

  <div class="body">
    <div class="row">
      <div class="col-md-9">
        <div class="panel panel-default">
        <div class="panel-heading text-center"><h3><?=$category['parent']. ' '. $category['child'];?>
          <button onclick="openNav()" type="button" class=" filterbtn btn btn-info btn-sm pull-right">
                  <span class="glyphicon glyphicon-sort"></span> Sort Item
                </button></h3></div>
        <div class="panel-body">
        <?php if($query->num_rows > 0){ ?>
            <div class="posts_list">
              <?php while ($product = $query->fetch_assoc()) : ?>
               <div class="col-xs-6 col-sm-5 col-md-4 padding-0 animation">
                 <div class="polaroid text-center">
                   <div class="product_title">
                     <h4><?= $product['title']; ?></h4>
                   </div>
                   <?php $photos = explode(',',$product['image']); ?>
                   <div class="imgHolder">
                     <img onclick="detailsmodal('add',<?= $product['id']; ?>)" src="<?= $photos[0]; ?>" alt="<?= $product['title']; ?>" class="img-thumb" style="width:100%"/>
                      <?php if ($product['sales'] == 1): ?>
                        <span>
                          <button type ="button" id="sales" class="btn btn-xs btn-danger pull-left" onclick="detailsmodal('add',<?= $product['id']; ?>)">Sales</button>
                        </span>
                     <?php endif; ?>
                   </div>
                  <p></p><p class="list-price" style="color:grey">Was: <s>₦<?= $product['list_price']; ?></s>
                  <hi style="color:black" class="price">Now: ₦<?= $product['price']; ?></hi>
                  <!--<button type ="button" id="dbutton" class="btn btn-sm btn-danger" onclick="detailsmodal('add',
                  <?= $product['id']; ?>)">DETAILS</button> -->
               </div>
             </div>
       <?php endwhile;  ?>
    </div>
  <?php }else{?>
    <div class="bg-danger">
    <p class="text-center text-info">
      No product is in this category at the moment!
    </p>
  </div>
<?php } ?>
 </div>
<div class="panel-footer"><?php echo $pagination->createLinks(); ?></div>
</div></div>

<?php  include "includes/rightbar.php"; ?>
</div>
</div>
<?php
  include "includes/footer.php";
  ?>
