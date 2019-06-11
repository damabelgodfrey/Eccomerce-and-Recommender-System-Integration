<link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
  <!-- <script src="https://code.jquery.com/jquery-1.12.4.js"></script> -->
  <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
  <script>
  $( function() {
    $( "#slider-range" ).slider({
      range: true,
      min: 0,
      max: 10000,

      values: [ 1, 10000 ],
      slide: function( event, ui ) {
        $( "#amount" ).val(ui.values[ 0 ] + "-" + ui.values[ 1 ] );
        $( "#amountLabel" ).val( "₦" + ui.values[ 0 ] + " - ₦" + ui.values[ 1 ] );
      }
    });
    $( "#amount" ).val( $( "#slider-range" ).slider( "values", 0 ) +
      "-" + $( "#slider-range" ).slider( "values", 1 ) );

    $( "#amountLabel" ).val( "₦" + $( "#slider-range" ).slider( "values", 0 ) +
      " - ₦" + $( "#slider-range" ).slider( "values", 1 ) );
  } );
  </script>

<?php
$cat_id =((isset($_REQUEST['cat']))?sanitize($_REQUEST['cat']):'');
$price_sort = ((isset($_REQUEST['price_sort']))?sanitize($_REQUEST['price_sort']):'');
$min_price = ((isset($_REQUEST['min_price']))?sanitize($_REQUEST['min_price']):'');
$amount = ((isset($_REQUEST['amount']))?sanitize($_REQUEST['amount']):'');
$b = ((isset($_REQUEST['brand']))?sanitize($_REQUEST['brand']):'');
$brandQ= $db->query("SELECT * FROM brand ORDER BY brand");

?><p></p>
<div class="bar-top">
  <h3 id= "searchBy" >SORT</h3>
</div>
<h4 class ="text-center">Price</h4>
<form action="search" method="post" >
  <div class="form-group">
    <input type = "hidden" name="cat" value="<?=$cat_id;?>">
    <input type = "hidden" name="price_sort" value="0">
    <input type="radio" name="price_sort" value="low"<?=(($price_sort=='low')?'checked':'');?>>  Low to High<br><br>
    <input type="radio" name="price_sort" value="high"<?=(($price_sort=='high')?'checked':'');?>>  High to Low<br><br>
  <p>
    <div class="">
      <label for="amount">Range:</label>
      <input class="btn btn-warning" type="button" id="amountLabel" name="amountLabel" value="" style="border:0; color:white; font-weight:bold;">
      <input type="hidden" id="amount" name="amount" value="">
    </div><br>
    <div id="slider-range"></div>
  </p><hr>

    <h4 class="text-center">Brand in Store</h4>
    <input type="radio" name="brand" value=""<?=(($b == '')?' checked':'');?>>All<br>
     <?php while($brand=mysqli_fetch_assoc($brandQ)): ?>
       <input type ="radio" name="brand" value="<?=$brand['id'];?>"<?=(($b == $brand['id'])? ' checked':'');?>><?=$brand['brand'];?><br>
     <?php endwhile; ?>
     <input type="submit" class="form-control" value="Searchby" name="searchby" id="button" class="btn btn-primary">
     </div>
</form><hr>
<div class = "search-container">
  <form action="search" method="post">
    <div class="form-group">
      <input type="text" class="form-control" placeholder="Search Product.." name="searchProduct">
      <button type="submit" id="button" class="btn btn-default"><span class="glyphicon glyphicon-search"></span> Search</button>
    </div>
  </form>
</div>
