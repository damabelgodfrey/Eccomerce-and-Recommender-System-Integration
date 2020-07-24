<link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
  <!-- <script src="https://code.jquery.com/jquery-1.12.4.js"></script> -->
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
<style media="screen">

.sidenav {
  height: 60%;
  width: 0;
  position: fixed;
  z-index: 1;
  top: 80px;
  left: 0;
  background-color: none;
  overflow-x: hidden;
  transition: 0.5s;
  padding-top: 60px;
}

.sidenav a {
  padding: 8px 8px 8px 32px;
  text-decoration: none;
  font-size: 25px;
  color: red;
  display: block;
  transition: 0.3s;
}

.sidenav a:hover {
  color: #f1f1f1;
}

.sidenav .closebtn {
  position: absolute;
  top: 0;
  right: 0px;
  font-size: 36px;
}
.filter {

}
@media screen and (max-height: 450px) {
  .sidenav {padding-top: 45px;}
  .sidenav a {font-size: 18px;}
}
</style>
<?php
$cat_id =((isset($_REQUEST['cat']))?sanitize($_REQUEST['cat']):'');
$price_sort = ((isset($_REQUEST['price_sort']))?sanitize($_REQUEST['price_sort']):'');
$min_price = ((isset($_REQUEST['min_price']))?sanitize($_REQUEST['min_price']):'');
$amount = ((isset($_REQUEST['amount']))?sanitize($_REQUEST['amount']):'');
$b = ((isset($_REQUEST['brand']))?sanitize($_REQUEST['brand']):'');
$brandQ= $db->query("SELECT * FROM brand ORDER BY brand");
?>
<div class="filter" id="filter">
<div id="" class="sidenav mySidenav">
  <div class="bar-top" id="myDIV">
    <a href="javascript:void(0)" class="closebtn" onclick="closeNav()">&times;</a>
  <div class="panel-body">
    <form action="search" method="post" enctype="multipart/form-data">
      <div class="form-group col-md-3">
        <input type = "hidden" name="cat" value="<?=$cat_id;?>">
        <label for="brand">Price*:</label>
        <select class= "form-control sizerowcheck" id = "price_sort" name ="price_sort" >
        <option value=""<?=(($price_sort =='')?'selected':'');?>>Choose Price Sort</option> <!--list all brand in drop menu on default -->
            <option value="low"<?=(($price_sort=='low')?'selected':'');?>>Low to High</option><hr>
            <option value="high"<?=(($price_sort=='high')?'selected':'');?>>High to Low</option>
        </select>
    </div>
        <div class="form-group col-md-3">
          <label for="amount">Range:</label>
          <input class=" btn btn-warning" type="button" id="amountLabel" name="amountLabel" value="" style="border:0; color:white; font-weight:bold;">
          <input type="hidden" id="amount" name="amount" value="">
          <p></p><div class="" id="slider-range"></div>
          </div>
          <div class="form-group col-md-3">
        <label for="amount">Brand:</label>
         <select class= "form-control sizerowcheck" id = "mybrand" name ="brand" >
         <option value=""<?=(($b =='')?'selected':'');?>>All Brands</option> <!--list all brand in drop menu on default -->
           <?php while($brand = mysqli_fetch_assoc($brandQ)): ?>
             <option value="<?=$brand['id'];?>"<?=(($b == $brand['id'])?'selected':'');?>><?=$brand['brand'];?></option>
           <?php endwhile; ?>
         </select>
       </div>
       <div class= "form-group ">
         <input type="submit" value="Submit" name="searchby" id="button" class="btn btn-sm btn-success form-control submitbtn">
       </div><div class="clearfix"></div>
    </form>
    </div>
  </div>
</div>
</div>
<script>
function openNav() {
  document.getElementsByClassName('mySidenav')[0].style.width="75%";
   $(".filterbtn").hide();
}

function closeNav() {
   $(".filterbtn").show();
     document.getElementsByClassName('mySidenav')[0].style.width="0";
}
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
