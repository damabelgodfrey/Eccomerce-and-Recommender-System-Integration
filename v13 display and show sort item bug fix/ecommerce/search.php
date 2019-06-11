<?php
  require_once 'core/init.php';
  include 'includes/head.php';
  include 'includes/navigation.php';
  //include 'includes/headerfull.php';
  //include 'includes/leftbar.php';
  $_SESSION['rdrurl'] = $_SERVER['REQUEST_URI'];
  $errors = array();
  include '../ecommerce/includes/widgets/filtersnew.php';
if(isset($_POST['searchby'])){
    $sql ="SELECT * FROM products";
    $cat_id=(($_POST['cat'] != '')?sanitize($_POST['cat']):'');
    //append this condition to sql query
    if($cat_id =='' && $_SESSION['saleflag'] !='' ){
      $sql .= ' WHERE archive = 0 AND sales = 1';
    }else{
      $sql .= " WHERE categories = '{$cat_id}' AND archive = 0";
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
    $productQ = $db->query($sql);
    $category = get_category($cat_id);
  }elseif(isset($_POST['searchProduct'])) {
    $search = $_POST['searchProduct'];
    $productQ = $db->query("SELECT * FROM products WHERE (title LIKE '%".$search."%' OR description LIKE '%".$search."%' OR p_keyword LIKE '%".$search."%') AND archive = 0");
    $cat_id ='';
    $category = get_category($cat_id);
  }else{
    $sql ="SELECT * FROM products LIMIT 12";
    $productQ = $db->query($sql);
    $cat_id ='';
    $category = get_category($cat_id);
  }
  $return = mysqli_num_rows($productQ);
    if($return == 0){
      $errors[] ="Your Search return no result. Please refine your search!";
    }

  ?>

    <!--main content -->
  <div class="col-md-9"><p></p>
    <div class="row">
      <?php if($cat_id != ''): ?>
        <div class="">
          <h2 class="text-center"><?=$category['parent']. ' '. $category['child'];?></h2>
        </div>
      <?php else: ?>
        <h2 class="text-center">Ameritinz Supermart</h2>
      <?php endif; ?>

      <?php if(!empty($errors)){ ?>
        <div class="bg-danger">
          <p class="text-center text-info">
            Your Search return no result. Please refine your search!
          </p>
        </div>
      <?php }else{ ?>
        <?php while ($product = mysqli_fetch_assoc($productQ)) : ?>
         <div class="col-xs-4 col-sm-4 col-md-4 padding-0 animation">
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

       <?php endwhile;} ?>

    </div>
  </div>

<?php

  include "includes/rightbar.php";
  include "includes/footer.php";
  ?>
