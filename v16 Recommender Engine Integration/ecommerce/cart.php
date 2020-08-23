<script type="text/javascript" src="https://js.stripe.com/v2/"></script>
<?php
require_once 'core/init.php';
include 'includes/head.php';
include 'includes/navigation.php';
?>
<style>
.cart_image img{
      display: block;
      margin-left: auto;
      margin-right: auto;
}
.cart_image {
  text-align:center;
   vertical-align: middle;
}
.panel-body2 {
    padding: 5px;
}
</style>
<?php

WeatherReporter::getWeatherReport($user_id);
$_SESSION['rdrurl'] = $_SERVER['REQUEST_URI'];
$errors = array();
if(isset($_GET['deleted']) && !empty($_GET['deleted'])){
   unset($_SESSION['discount']);
    $message = 'Discount removed successfully.';
    succes_redirect('cart',$message);
}
$cartRepObj= new cartRepoController();
if(isset($user_id)){
  $cartRepObj = new CartRepoController();
  $cartQ = $cartRepObj->selectCart($user_id);

$return = count($cartQ);
  if($return != 1){
    $_SESSION['total_item_ordered'] = 0;
    if(isset($_SESSION['discount'])){
      unset($_SESSION['discount']);
    }

    ?>
    <div class="bg-danger">
      <h3><p class="text-center text-info">
          Your shopping Bag is empty!
      </p>
      </h3>
    </div>
    <div class="container col-md-9">
    </div><p></p><hr>
    <?php include '../ecommerce/includes/trendingProduct.php'; ?><p></p><p></p>
    <?php
  }else{
    $formid = md5(rand(0,10000000));
    foreach ($cartQ as $CartResult) {
      $MyCart_id = (int)$CartResult['userID'];
      $items = json_decode($CartResult['items'],true);
    }

    $i = 1;
    $sub_total = 0;
    $item_count = 0;
    ?>
    <div class="row">
    <span id="cart_errors" class="bg-danger"></span>
    <div class="container-fluid col-md-8">
      <div class="panel panel-default">
      <div class="panel-heading"><div class="text-left">
         <h3>MY BAG</h3>
        </div>
      </div>
      <?php
    ?>
      <div class="bg-danger text-center text-warning">
          Pls Note: Items are reserved in shoping bag for 60minutes!
      </div>
      <div class="panel-body">
        <div class=" text-center">
          <?php
            $itemcount = count($items);
            $CartRepObj = new ProductController();
            foreach($items as $item){
              $product_id =$item['id'];
              $itemcheck =1;
              $productQ = $CartRepObj->getProduct($product_id);
              if(count($productQ) > 0){
              foreach ($productQ as $product ) {
              $sizes = sizesToArray($product['sizes']);
              foreach($sizes as $size){
                  if($size['size'] == $item['size']){
                    $available = (int)$size['quantity'];
                }else{
                  $itemcheck =-1;
                }
              }
              ?>
              <div class="row">
                  <div class="col-xs-6">
                    <div class="pull-left">
                      [<?=$i;?>]
                    </div>
                    <div class=" cart_image ">
                      <div class=" fotorama" data-height="300px"data-width="350px">
                          <?php $photos = explode(',', $product['image']); //multiple image is seperated by ,
                          foreach($photos as $photo): ?>
                            <img src="<?= $photo; ?>" alt="<?= $product['title']; ?>">
                    <?php endforeach; ?>
                      </div>
                    </div>
                </div>
                <div class="col-xs-6">
                    <div class="pull-right">
                      <button class="btn btn-danger btn-xs glyphicon glyphicon-remove" onclick="update_cart('delete',
                      '<?=$MyCart_id;?>','<?=$product['id'];?>','<?=$item['size'];?>','<?=$item['quantity'];?>','<?=$available;?>');"></button>
                    </div>
                    <div class="product_title pull-center">
                      <h3><?= $product['title']; ?></h3>
                    </div>
                    <div class="pull-left" style="color:white">
                      <strong>price:  </strong>
                    </div>
                    <?php if($item['discount'] > 0){ ?>
                        <strong> <p class="price"><s><?=money($item['quantity'] * $item['price']);?></s></p></strong>

                      <?php }else{?>

                        <strong> <p class="price text-danger"><?=money($item['quantity'] * $item['price']);?></p></strong>
                      <?php }?>

                         <p></p>
                      <div class="pull-left">
                        <strong>Qty:  </strong>
                      </div>
                      <button class="btn btn-warning btn-xs glyphicon" onclick="update_cart('removeone','<?=$MyCart_id;?>','<?=$product['id'];?>',
                            '<?=$item['size'];?>','<?=$item['quantity'];?>','<?=$available;?>');"> <strong>-</strong></button>

                  <?php
                     if($available <= 0){?>
                          <?=$item['quantity'];?>
                          <span class="text-danger">Max</span>
                  <?php }else{?>
                          <?=$item['quantity'];?>
                          <button class="btn btn-xs btn-warning" onclick="update_cart('addone','<?=$MyCart_id;?>','<?=$product['id'];?>','<?=$item['size'];?>','<?=$item['quantity'];?>','<?=$available;?>');"><strong>+</strong></button>
                      <?php }?>
                      <p></p>
                      <div class="pull-left">
                        <strong>Size:  </strong>
                      </div><?=$item['size'];?>
                      <p></p>
                      <?php
                     if($item['discount'] > 0){
              $disc = (($item['discount']/100) * $item['price']);
                    $item['price'] = $item['price']-$disc;
                         ?>
                      <div class="pull-left">
                        <strong>Dsc: <?=$item['discount'];?>%</strong>
                      </div>
                        <strong> <div class="price text-danger"><?=money($item['quantity'] * $item['price']);?></div></strong>
                      <?php }?>
                      <p></p>
                      <?=$item['request'];?>
                  <input readonly style="border:none"  type="label" class="form-control" name="" value="<?=$product['description'];?>"><p></p>
                  <?php if($item['discount'] > 0){ ?>
                  <button disabled class="btn btn-info" id="carttowish" onclick="carttowish('cart','<?=$MyCart_id;?>','<?=$item['id'];?>','<?=$item['size'];?>','<?=$item['quantity'];?>','<?=$available;?>','<?=$item['price'];?>','<?=$item['request'];?>');"><span class="glyphicon glyphicon-heart"> On Discount</span></button>
                <?php }else{?>
                  <button class="btn btn-info" id="carttowish" onclick="carttowish('cart','<?=$MyCart_id;?>','<?=$item['id'];?>','<?=$item['size'];?>','<?=$item['quantity'];?>','<?=$available;?>','<?=$item['price'];?>','<?=$item['request'];?>');"><span class="glyphicon glyphicon-heart"> Save for later</span></button>

                <?php } ?>
                  <button class="text-primary btn btn-sm" onclick="detailsmodal('view','<?=$product['id'];?>')">View Details</button>
                </div>
              </div><hr>
              <?php
              $i++;
              $item_count += $item['quantity'];
              $sub_total += ($item['price'] * $item['quantity']);
            }
          }
        //////

          }
            $expireflag=0;
              if (TAXRATE == 0) {
                $grand_total = $sub_total;
                $tax = 0;
              }else{
              $tax = TAXRATE * $sub_total;
             //$tax = number_format($tax,2);
              $grand_total = $tax + $sub_total;
            }
            if(isset($_SESSION["discount"])){
              $discountT = $_SESSION["discount"] * $sub_total;
              $grand_total = $sub_total - $discountT;
            }
            ?>
         </div>
      </div>
      <div class="panel-footer">
      </div>
    </div>
    </div>
    <?php

     ?>
    <div class="col-md-4">
      <div class="panel panel-default">
      <div class="panel-heading"><h3 class="text-center">Order Summary</h3>
      </div>
      <div class="panel-body panel-body2">
        <table class="table  table-condensed text-center">
          <thead class=""><th>Details</th><th>Sub Total</th><th>Sum</th></thead>
          <tbody>
            <tr>
              <td>Item: <?=$item_count;?><br>
                <?php if (isset($_SESSION["discount"]) && $_SESSION["discount"] != 0){ ?>
                  Disc: <?= $_SESSION["my_discount"];?>%
                  <a href="cart.php?deleted=1" class="btn btn-warning btn-xs" onclick="return deleteconfirm()"><span class="glyphicon glyphicon-remove-sign"></span></a>

                <?php }?><br>
              <?=((isset($tax) && $tax > 0)?'Tax: '.$tax:'');?>
            </td>
              <td><?=money($sub_total);?></td>
              <td style="color: green"class=""><strong><?=money($grand_total);?></strong></td>
            </tr>
          </tbody>
        </table>

        <?php if(is_logged_in()){
             if(check_permission('editor')){ ?>
                   <button type="button" class="btn btn-sm btn-primary pull-left" data-toggle="modal" data-target="#instorecheckoutModal">
                    <span class="glyphicon glyphicon-shopping-cart"></span> Instore >>
                   </button>
                   <button type="button" class="btn  btn-sm btn-primary pull-right" data-toggle="modal" data-target="#checkoutModal">
                    <span class="glyphicon glyphicon-shopping-cart"></span> Check out >>
                   </button>
           <?php }else{?>
                   <button type="button" class="btn btn-sm btn-primary pull-right" data-toggle="modal" data-target="#checkoutModal">
                    <span class="glyphicon glyphicon-shopping-cart"></span> Check Out >>
                   </button>
             <?php } ?>
        <?php }else{?>
              <a href="login" id= "login" class="btn btn-default pull-right btn-info"><span class ="glyphicon glyphicon-shopping-cart"> Login to Check Out</span></a>
        <?php } ?>
      </div>
      <div class="panel-footer text-center">
        <?php  include '../ecommerce/includes/widgets/discountadder.php';?>
      </div>
      </div>
      <div class="panel panel-default">
        <div class="panel-heading text-center"><h4>⇩Trending⇩</h4></div>
        <div class="panel-body panel-body2">
          <?php include '../ecommerce/includes/slide.php'; ?>
        </div>
      </div>
    </div>
  </div>
    <?php } ?>

        <!-- Store purchase  -->
      <div class="modal fade" id="instorecheckoutModal" tabindex="-1" role="dialog" aria-labelledby="checkoutModal1Label">
        <div class="modal-dialog modal-lg" role="document">
          <div class="modal-content">
            <div class="modal-header">
              <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
              <h4 class="modal-title" id="checkoutModalLabel">Instore Address</h4>

            </div>
            <div class="modal-body">
              <div class="row">
                <form action="thankYou" method="post" >
                  <span class="bg-danger" id="payment-errors2"></span>
                  <h3 class="text-center">
                    <label for=""><?=money($grand_total);?></label>
                  </h3>
                    <?php include 'includes/cartOrderDetails.php';
                    include $_SERVER['DOCUMENT_ROOT'].'/ecommerce/includes/addressDetails.php';
                    ?>

                    <?php
                    $_SESSION["formid"] = $formid?>
                    <input type="hidden" value="<?=$formid ?>" name="formid" />
                    <div class="from-group col-md-6">
                    <?php $tType = ((isset($_REQUEST['tType']))?sanitize($_REQUEST['tType']):''); ?>
                    <input type = "hidden" name="tType" value="cash">
                    <hr><input type="radio" id = 'tType' name="tType" value="pos"<?=(($tType=='pos')?'checked':'');?>>  ORDER BY POS<br><br>
                    <input type="radio" id = 'tType' name="tType" value="cash"<?=(($tType=='cash')?'checked':'');?>>  ORDER BY CASH<br><br>
                  </div>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
              <button type="submit" class="btn btn-primary zerocheck" name="instorePurchase" >Check Out Instore >></button>
              </form>
            </div>
            </div>
            </div>
          </div>
        </div>


    <!-- Address and Card Modal  -->
        <div class="modal fade" id="checkoutModal" tabindex="-1" role="dialog" aria-labelledby="checkoutModalLabel">
          <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
              <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="checkoutModalLabel2">Shipping Address</h4>
                <h4 class="text-center">
                  <label for=""><?=money($grand_total);?></label>
                </h4>
              </div>
              <div class="modal-body">
                <div class="row">
                  <form action="thankYou" method="post" id="payment-form">
                    <span class="bg-danger" id="payment-errors"></span>
                      <?php include 'includes/cartOrderDetails.php'; ?>
                    <div id="step1" style="display:block;">
                      <?php
                         include $_SERVER['DOCUMENT_ROOT'].'/ecommerce/includes/addressDetails.php';
                       ?>
                     </div>
                    <div id="step2" style="display:none;">
                      <div class="bg-danger text-center text-warning">
                          Pls Note: For added security, your card information is not stored on our server!
                      </div>
                      <?php
                      include 'includes/cardDetails.php';
                       ?>
                </div>
               <input type="hidden" name="stripTrans" value="stripTrans">
              <?php $_SESSION["formid"] = $formid; ?>
                <input type="hidden" value="<?php echo htmlspecialchars($_SESSION["formid"]); ?>" name="formid" />
              </div>
              <div class="modal-footer">
                <a href="account?edit=<?=$user_data['id'];?>" id= "editAddress" class="btn btn-default pull-left btn-md btn-info"><span class ="glyphicon glyphicon-pencil"> Update Address</span></a>
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary" onclick="check_address();" id="next_button">Next >></button>
                <button type="button" class="btn btn-primary" onclick="back_address();" id="back_button" style="display:none;"><< Back</button>
                <button type="submit" class="btn btn-primary" name = "cardPurchase" id="checkout_button" style="display:none;">Check Out >></button>
                </form>
              </div>
              </div>
              </div>
            </div>
          </div>

<?php }else{?>
  <div class="bg-danger">
    <p class="text-center text-warning">
      <a href="login" class="btn btn-info" role="button">Login</a>
      Login to Add and View Shopping Bag and Saved Item!
      <a href="index" class="btn btn-info" role="button">Continue Shopping</a>
    </p>
  </div><p></p>
  <?php include '../ecommerce/includes/trendingProduct.php'; ?><p></p>
<?php }?>
<?php include 'includes/footer.php' ?>
<script>


  Stripe.setPublishableKey('<?=STRIPE_PUBLIC;?>');


function stripeResponseHandler(status,response){
var $form = $('#payment-form');

if(response.error){
  //show errors on the $form
  $form.find('#payment-errors').text(response.error.message);
  $form.find('#checkout_button').prop('disabled',false);
}else{
//  $form.find('#checkout_button').prop('disabled',true);
  //response contains id and card, which contains additional card Details
  var token = response.id;
  //insert the token into the form so it get submited to the server
  $form.append($('<input type="hidden" name="stripeToken" />').val(token));
  // and submit
  $form.get(0).submit();
  }
};

  jQuery(function($) {
    $('#payment-form').submit(function(event){
      var $form =$(this);
      //disable the submit button to prevent repeated clicks
      $form.find('#checkout_button').prop('disabled', true);
      Stripe.card.createToken($form, stripeResponseHandler);
      //prevent the form from submitting with the default action
      return false;
    });
  });
  function deleteconfirm(){
  var del=confirm("Are you sure you want to remove discount?");
  if (del==true){
  //   alert ("record deleted")
  }
  return del;
  }
  // This function update(remove) item from cart
  // return the item qty to product database
  // pdate(add) item to wishlist
  function carttowish(mode,mycart_id,product_id,size,quantity,available,price,request){
    jQuery('#wish_errors').html("");
    $('.btn').prop('disabled', true);
    var error = '';
    var cartCheck = {'mode' : 'cart', "cart_id" : mycart_id};
    var cart_data = {'dmode' : 'wish', "product_id" : product_id, "size" : size,"quantity" : quantity,
                 "available":available,"price":price,"request":request};
    var update_data = {'mode' : 'delete', "edit_id" : product_id, "edit_size" : size,"edit_quantity" : quantity,
                 "edit_available":available};
   jQuery.ajax({
     url : '/ecommerce/admin/parsers/cart_check.php',
     method : 'POST',
     data : cartCheck,
     success : function(data){
       if(data != 'success'){
         jQuery('#cart_errors').html(data);
         alert("Something went wrong. Your cart is either expired or has been moved. Plz refresh page and check saved item");
       }
       if(data == 'success'){
         jQuery('#cart_errors').html("");
            jQuery.ajax({
              url : '/ecommerce/admin/parsers/add_cart.php',
              method : "post",
              data : cart_data,
              success : function(){location.reload();},
              error : function(){alert("An error occur while adding product to wishlist");},
            });
            jQuery.ajax({
              url : '/ecommerce/admin/parsers/update_cart.php',
              method : "post",
              data : update_data,
              success : function(){location.reload();},
              error : function(){alert("Something went wrong; cart update unsuccessful");},
            });
          }
        },
        errors : function(){alert("Something Went Wrong! Product availability check unsuccessful");},

    });
  }

  function back_address(){
    jQuery('#payment-errors').html("");
    jQuery('#step1').css("display","block");
    jQuery('#step2').css("display","none");
    jQuery('#next_button').css("display","inline-block");
    jQuery('#editAddress').css("display","inline-block");
    jQuery('#back_button').css("display","none");
    jQuery('#checkout_button').css("display","none");
    jQuery('#checkoutModalLabel2').html("Shipping Address");
  }
  function check_address(){
    var my_data ={
      'full_name' : jQuery('.full_name').val(),
      'email'     : jQuery('.email').val(),
      'street'     : jQuery('.street').val(),
      'street2'     : jQuery('.street2').val(),
      'city'     : jQuery('.city').val(),
      'state'     : jQuery('.state').val(),
      'zip_code'     : jQuery('.zip_code').val(),
      'phone'     : jQuery('.phone').val(),
      'country'     : jQuery('.country').val(),
    };
    jQuery.ajax({
      url : '/ecommerce/admin/parsers/check_address.php',
      method : 'POST',
      data : my_data,
      success : function(data){
        if(data != 'passed'){
          jQuery('#payment-errors').html(data);
          //alert("Something went wrong. Address check might have failled verification. Please update address");
        }
        if(data == 'passed'){
          jQuery('#payment-errors').html("");
          jQuery('#step1').css("display","none");
          jQuery('#step2').css("display","block");
          jQuery('#next_button').css("display","none");
          jQuery('#editAddress').css("display","none");
          jQuery('#back_button').css("display","inline-block");
          jQuery('#checkout_button').css("display","inline-block");
          jQuery('#checkoutModalLabel2').html("Enter Your Card Details");

        }
      },
      errors : function(){alert("Something Went Wrong! Please ensure you update your address.");},

    });
  }
</script>
