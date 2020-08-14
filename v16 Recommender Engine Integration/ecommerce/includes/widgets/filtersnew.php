<link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
  <!-- <script src="https://code.jquery.com/jquery-1.12.4.js"></script> -->
  <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
  </style>
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

  function prodSortFunction() {
    var x = document.getElementById("myDIV");
    if (x.style.display === "none") {
        x.style.display = "block";
    } else {
        x.style.display = "none";
    }
    var y = document.getElementById("sortB");
    if (y.innerHTML === "Click to Sort Items") {
      y.innerHTML = "Hide Sort Box";
    } else {
      y.innerHTML = "Click to Sort Items";
    }
}
$(document).ready(function(){
    var x = document.getElementById("myDIV");
    x.style.display = "none";
});

  </script>

<?php
$cat_id =((isset($_REQUEST['cat']))?sanitize($_REQUEST['cat']):'');
$price_sort = ((isset($_REQUEST['price_sort']))?sanitize($_REQUEST['price_sort']):'');
$min_price = ((isset($_REQUEST['min_price']))?sanitize($_REQUEST['min_price']):'');
$amount = ((isset($_REQUEST['amount']))?sanitize($_REQUEST['amount']):'');
$b = ((isset($_REQUEST['brand']))?sanitize($_REQUEST['brand']):'');
$brandQ= $db->query("SELECT * FROM brand ORDER BY brand");

?>

  <div class="bodycontainer-fluid text-center sortfilter" id="">
    <div class="form-group">
      <button id="sortB" class="sortD form-control btn btn-default"onclick="prodSortFunction()">Click to Sort Items</button>
  </div>
</div>

<div class="bar-top" id="myDIV">
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
