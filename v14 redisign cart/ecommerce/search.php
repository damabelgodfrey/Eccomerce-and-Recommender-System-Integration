<?php
  require_once 'core/init.php';
  include 'includes/head.php';
  include 'includes/navigation.php';
  //include 'includes/headerfull.php';
  //include 'includes/leftbar.php';
  include_once 'admin/includes/Pagination.class.php';
  //$_SESSION['rdrurl'] = $_SERVER['REQUEST_URI'];
  $errors = array();
  include '../ecommerce/includes/widgets/filtersnew.php';
if(isset($_POST['searchby'])){
    $sql ="SELECT * FROM products WHERE archive = 0";
    $cat_id=(($_POST['cat'] != '')?sanitize($_POST['cat']):'');
    //append this condition to sql query

    if(isset($cat_id) && $cat_id !=''){
      $sql .= " AND categories = '{$cat_id}'";
    }

    if(isset($_SERVER['HTTP_REFERER'])){
      $a = $_SERVER['HTTP_REFERER'];
      if (strpos($a, 'sales') !== false) {
          $sql .= ' AND sales = 1';
      }
    }
    $price_sort = (($_POST['price_sort'] != '')?sanitize($_POST['price_sort']):'');
    $brand = (($_POST['brand'] != '')?sanitize($_POST['brand']):'');
    $amount= (($_POST['amount'] != '')?sanitize($_POST['amount']):''); // return value ₦1 - ₦1000

    $amount = explode('-',$amount);
    $min_price = (int)$amount[0];
    $max_price = (int)$amount[1];
 //var_dump($min_price);  var_dump($max_price); die();

    if($min_price != ''){
      $sql .= " AND price >= '{$min_price}'";
    }
    if($max_price != ''){
      $sql .= " AND price <= '{$max_price}'";
    }
    if($brand != ''){
      $sql .= " AND brand = '{$brand}'";
    }
    if($price_sort == 'low'){
      $sql .= " ORDER BY price";
    }
    if($price_sort == 'high'){
      $sql .= " ORDER BY price DESC";
    }
    $category = get_category($cat_id);
    $productQ = $db->query($sql);
    $return = mysqli_num_rows($productQ);
    var_dump($sql);
    var_dump($_SESSION['saleflag']);
    var_dump($_SERVER['HTTP_REFERER']);
  }
  if(isset($_POST['searchProduct'])) {
    $search = sanitize($_POST['searchProduct']);
    if($search ==''){
      $errors[] ="Please input a search criteria!";
    }
    $sql ="SELECT * FROM products WHERE (title LIKE '%".$search."%' OR description LIKE '%".$search."%' OR p_keyword LIKE '%".$search."%') AND archive = 0";
    $cat_id ='';
    $category = get_category($cat_id);
    $productQ = $db->query($sql);
    $return = mysqli_num_rows($productQ);
  }

    if(isset($return) && $return == 0){
      $errors[] ="Your Search return no result. Please refine your search!";
    }
    if(!$_POST){
      $errors[] ="Null search criteria or item sent for a search. Please input a search criteria!";
    }
  ?>

    <!--main content -->
  <div class="col-md-9">
    <div class="row">
      <div class="panel panel-default">
      <div class="panel-heading text-center"><h3><?=((isset($_POST['cat']) && $cat_id != '')?$category['parent']. ' '. $category['child']:'Ameritinz Supermart');?></h3></div>
      <div class="panel-body">
      <?php if(!empty($errors) || (isset($return) && $return == 0)){ ?>
        <div class="bg-danger">
          <p class="text-center text-info">
            <?=$errors[0];?>
          </p>
        </div>
      <?php }else{
              while ($product = mysqli_fetch_assoc($productQ)) : ?>
               <div class="col-xs-4 col-sm-4 col-md-4 padding-0 animation">
                 <div class="polaroid text-center">
                   <?php if ($product['sales'] == 1): ?>
                     <button type ="button" id="sales" class="btn btn-xs btn-danger pull-left" onclick="detailsmodal(<?= $product['id']; ?>)">Sales</button>
                   <?php endif; ?>
                   <div class="product_title">
                     <h4><?= $product['title']; ?></h4>
                   </div>
                   <?php $photos = explode(',',$product['image']); ?>
                  <img onclick="detailsmodal('add',<?= $product['id']; ?>)" src="<?= $photos[0]; ?>" alt="<?= $product['title']; ?>" class="img-thumb" style="width:100%"/>
                  <p></p><p class="list-price" style="color:grey">Was: <s>₦<?= $product['list_price']; ?></s></p>
                  <p class="price">Now: ₦<?= $product['price']; ?></p>
                  <!--<button type ="button" id="dbutton" class="btn btn-sm btn-danger" onclick="detailsmodal(
                  <?= $product['id']; ?>)">DETAILS</button> -->
               </div>
               </div>

             <?php endwhile; }?>
         <?php ?>
     </div>
     <div class="panel-footer"></div>
   </div>
    </div>
  </div>

<?php

  include "includes/rightbar.php";
  include "includes/footer.php";
  ?>
