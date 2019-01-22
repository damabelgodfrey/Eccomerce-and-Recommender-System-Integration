<?php
  require_once 'core/init.php';
  include 'includes/head.php';
  include 'includes/navigation.php';
  //include 'includes/headerfull.php';
  include 'includes/leftbar.php';

if(isset($_POST['searchby'])){
    $sql ="SELECT * FROM products";
    $cat_id=(($_POST['cat'] != '')?sanitize($_POST['cat']):'');
    //append this condition to sql query
    if($cat_id ==''){
      $sql .= ' WHERE archive = 0';
    }else{
      $sql .= " WHERE categories = '{$cat_id}' AND archive = 0";
    }
    $price_sort = (($_POST['price_sort'] != '')?sanitize($_POST['price_sort']):'');
    $min_price = (($_POST['min_price'] != '')?sanitize($_POST['min_price']):'');
    $max_price = (($_POST['max_price'] != '')?sanitize($_POST['max_price']):'');
    $brand = (($_POST['brand'] != '')?sanitize($_POST['brand']):'');
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
    $productQ = $db->query("SELECT * FROM products WHERE title LIKE '%".$search."%' OR description LIKE '%".$search."%'");
    $cat_id ='';
    $category = get_category($cat_id);
  }else{
    $sql ="SELECT * FROM products LIMIT 12";
    $productQ = $db->query($sql);
    $cat_id ='';
    $category = get_category($cat_id);
  }


  ?>

    <!--main content -->
  <div class="col-md-8">
    <div class="row">
      <?php if($cat_id != ''): ?>
        <h2 class="text-center"><?=$category['parent']. ' '. $category['child'];?></h2>
      <?php else: ?>
        <h2 class="text-center">Ameritinz Supermart</h2>
      <?php endif; ?>
        <?php while ($product = mysqli_fetch_assoc($productQ)) : ?>
         <div class="col-xs-4 padding-0" id = detailLabel>
           <div class="polaroid text-center">
             <h4><?= $product['title']; ?></h4>
             <?php $photos = explode(',',$product['image']); ?>
            <img onclick="detailsmodal(<?= $product['id']; ?>)" src="<?= $photos[0]; ?>" alt="<?= $product['title']; ?>" class="img-thumb" style="width:100%"/>
            <p></p><p class="list-price" style="color:grey">Was: <s>₦<?= $product['list_price']; ?></s></p>
            <p class="price">Now: ₦<?= $product['price']; ?></p>
            <button type ="button" class="btn btn-sm btn-danger" onclick="detailsmodal(<?= $product['id']; ?>)">DETAILS</button>
         </div>
         </div>

       <?php endwhile; ?>
    </div>
  </div>

<?php

  include "includes/rightbar.php";
  include "includes/footer.php";
  ?>
