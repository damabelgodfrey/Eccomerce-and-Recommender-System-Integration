<?php
$cat_id =((isset($_REQUEST['cat']))?sanitize($_REQUEST['cat']):'');
$price_sort = ((isset($_REQUEST['price_sort']))?sanitize($_REQUEST['price_sort']):'');
$min_price = ((isset($_REQUEST['min_price']))?sanitize($_REQUEST['min_price']):'');
$max_price = ((isset($_REQUEST['max_price']))?sanitize($_REQUEST['max_price']):'');
$b = ((isset($_REQUEST['brand']))?sanitize($_REQUEST['brand']):'');
$brandQ= $db->query("SELECT * FROM brand ORDER BY brand");

?>
<h3 id= "searchBy" >Search BY:</h3>
<h4 class ="text-center">Price</h4>
<form action="search.php" method="post" >
  <div class="form-group">
    <input type = "hidden" name="cat" value="<?=$cat_id;?>">
    <input type = "hidden" name="price_sort" value="0">
    <input type="radio" name="price_sort" value="low"<?=(($price_sort=='low')?'checked':'');?>>  Low to High<br><br>
    <input type="radio" name="price_sort" value="high"<?=(($price_sort=='high')?'checked':'');?>>  High to Low<br><br>
    <input type="number" class="form-control" name="min_price" class="price-range" placeholder="Min #" value="<?=$min_price;?>">
    <div class="">
      <p> To</p>
    </div>
    <input type="number" class="form-control" name="max_price" class="price-range" placeholder="max #" value="<?=$max_price;?>"><br><br>
    <h4 class="text-center">Brand in Store</h4>
    <input type="radio" name="brand" value=""<?=(($b == '')?' checked':'');?>>All<br>
     <?php while($brand=mysqli_fetch_assoc($brandQ)): ?>
       <input type ="radio" name="brand" value="<?=$brand['id'];?>"<?=(($b == $brand['id'])? ' checked':'');?>><?=$brand['brand'];?><br>
     <?php endwhile; ?>
     <input type="submit" class="form-control" value="searchby" name="searchby" class="btn btn-primary">
     </div>
</form><hr>
<div class = "search-container">
  <form action="search.php" method="post">
    <div class="form-group">
      <input type="text" class="form-control" placeholder="Search Product.." name="searchProduct">
      <button type="submit" class="btn btn-default"><span class="glyphicon glyphicon-search"></span> Search</button>
    </div>
  </form>
</div>
