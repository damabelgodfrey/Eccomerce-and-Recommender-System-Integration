<style>
.cart_image img{
      display: block;
      margin-left: auto;
      margin-right: auto;
}
.cart_image tr{
  text-align:center;
   vertical-align: middle;
}

</style>

<?php
require_once 'core/init.php';
include 'includes/head.php';
include 'includes/navigation.php';

$_SESSION['rdrurl'] = $_SERVER['REQUEST_URI'];
$errors = array();
if(isset($user_name)){
$paid = 0;
$cartQ = $db->query("SELECT * FROM cart WHERE username = '{$user_name}' AND paid = '{$paid}'");
$return = mysqli_num_rows($cartQ);
  if($return != 1){
    $_SESSION['total_item_ordered'] = 0;
    ?>
    <div class="bg-danger">
      <p class="text-center text-info">
        Your shopping Bag is empty!
      </p>
    </div><?php
  }else{
    $formid = md5(rand(0,10000000));
    $CartResult = mysqli_fetch_assoc($cartQ);
    $MyCart_id = $CartResult['id'];
    $items = json_decode($CartResult['items'],true);
    $i = 1;
    $sub_total = 0;
    $item_count = 0;
    ?>
    <span id="cart_errors" class="bg-danger"></span>
    <div class="container col-md-8">
      <div class="panel panel-default">
      <div class="panel-heading"><div class="text-left">
         <h3>MY BAG</h3>
        </div>
      </div>
      <div class="bg-danger">
        <p class="text-center text-warning">
          Pls Note: Items are reserved in shoping bag for 60minutes!
        </p>
      </div>
      <div class="panel-body">
        <table class="table cart_image text-right">
           <thead class= item-table-header></thead>
           <tbody>
          <?php
            $itemcount = count($items);
            foreach($items as $item){
              $product_id =$item['id'];
              $itemcheck =1;
              $productQ = $db->query("SELECT * FROM products WHERE id = '{$product_id}'");
              if(mysqli_num_rows($productQ) > 0){
              $product = mysqli_fetch_assoc($productQ);
              $sizes = sizesToArray($product['sizes']); //function in helper file
              foreach($sizes as $size){
                  if($size['size'] == $item['size']){
                    $available = (int)$size['quantity'];
                }else{
                  $itemcheck =-1;
                }
              }
              ?>
              <tr>
                  <td>
                    <div class="pull-left">
                      [<?=$i;?>]
                    </div>
                    <div class=" cart_image ">
                      <div class=" fotorama" data-height="250px"data-width="250px">
                          <?php $photos = explode(',', $product['image']); //multiple image is seperated by ,
                          foreach($photos as $photo): ?>
                            <img src="<?= $photo; ?>" alt="<?= $product['title']; ?>">
                    <?php endforeach; ?>
                      </div>
                    </div>
                </td>
                <td>
                  <div class="">
                    <div class="pull-right">
                      <button class="btn btn-danger btn-xs glyphicon glyphicon-remove" onclick="update_cart('delete',
                      '<?=$MyCart_id;?>','<?=$product['id'];?>','<?=$item['size'];?>','<?=$item['quantity'];?>','<?=$available;?>');"></button>
                    </div>
                    <div class="pull-left" style="color:white">
                      <strong>Title:  </strong>
                    </div>
                    <div class="product_title pull-center">
                      <h3><?= $product['title']; ?></h3>
                    </div>
                    <div class="pull-left" style="color:white">
                      <strong>price:  </strong>
                    </div>
                        <strong> <p class="price text-danger"><?=money($item['quantity'] * $item['price']);?></p></strong> <p></p>
                      <div class="pull-left">
                        <strong>Qty:  </strong>
                      </div>
                      <button class="btn btn-xs btn-warning" onclick="update_cart('removeone','<?=$MyCart_id;?>','<?=$product['id'];?>',
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
                      </div><?=$item['size'];?><p></p><?=$item['request'];?>
                  </div>
                  <input readonly style="border:none"  type="label" class="form-control" name="" value="<?=$product['description'];?>"><p></p>
                  <button class="btn btn-info" onclick="carttowish('cart','<?=$MyCart_id;?>','<?=$item['id'];?>','<?=$item['size'];?>','<?=$item['quantity'];?>','<?=$available;?>','<?=$item['price'];?>','<?=$item['request'];?>');"><span class="glyphicon glyphicon-heart"> Save for later</span></button>
                  <button class="text-primary btn btn-sm" onclick="detailsmodal('view','<?=$product['id'];?>')">View Details</button>
                </td>
              </tr>
              <?php
              $i++;
              $item_count += $item['quantity'];
              $sub_total += ($item['price'] * $item['quantity']);
            }
          }
            $_SESSION['total_item_ordered'] = $item_count;
            $expireflag=0;
              if (TAXRATE == 0) {
                $grand_total = $sub_total;
                $tax = 0;
              }else{
              $tax = TAXRATE * $sub_total;
             //$tax = number_format($tax,2);
              $grand_total = $tax + $sub_total;
            }
            ?>
           </tbody>
         </table>
      </div>
    </div>
    </div>

    <div class="col-md-4">
      <div class="panel panel-default">
      <div class="panel-heading"><h3>Order Summary</h3></div>
      <div class="panel-body">
        <table class="table  table-condensed text-center">
          <thead class="totals-table-header"><th>Total Items</th><th>Sub Total</th><th>Tax</th><th>Grand Total</th></thead>
          <tbody>
            <tr>
              <td><?=$item_count;?></td>
              <td><?=money($sub_total);?></td>
              <td><?=money($tax);?></td>
              <td class="grandTotallabel"><?=money($grand_total);?></td>
            </tr>
          </tbody>
           </table><hr>

        <?php if(is_logged_in()){
             if(check_permission('editor')){ ?>
                   <button type="button" class="btn btn-primary pull-left" data-toggle="modal" data-target="#instorecheckoutModal">
                    <span class="glyphicon glyphicon-shopping-cart"></span> Instore Check out >>
                   </button>
                   <button type="button" class="btn btn-primary pull-right" data-toggle="modal" data-target="#checkoutModal">
                    <span class="glyphicon glyphicon-shopping-cart"></span> Check out >>
                   </button>
           <?php }else{?>
                   <button type="button" class="btn btn-primary pull-right" data-toggle="modal" data-target="#checkoutModal">
                    <span class="glyphicon glyphicon-shopping-cart"></span> Check Out >>
                   </button>
             <?php } ?>
        <?php }else{?>
              <a href="login" id= "login" class="btn btn-default pull-right btn-info"><span class ="glyphicon glyphicon-shopping-cart"> Login to Check Out</span></a>
        <?php } ?>
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
                <form action="thankYou.php" method="post" >
                  <span class="bg-danger" id="payment-errors"></span>
                    <?php include 'includes/cartOrderDetails.php'; include 'includes/addressDetails.php'; ?>
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
              </div>
              <div class="modal-body">
                <div class="row">
                  <form action="thankYou.php" method="post" id="payment-form">
                    <span class="bg-danger" id="payment-errors"></span>
                      <?php include 'includes/cartOrderDetails.php'; ?>
                    <div id="step1" style="display:block;">
                      <?php
                        include 'includes/addressDetails.php';
                       ?>
                    </div>
                    <div id="step2" style="display:none;">
                      <?php
                      include 'includes/cardDetails.php';
                       ?>
                </div>
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
    <div class="container col-md-12">
      <?php include '/wishlist.php'; ?>
    </div>
<?php }else{?>
  <div class="bg-danger">
    <p class="text-center text-warning">
      Login to Add and View Shopping Bag and wish Item!
    </p>
  </div><p></p>
  <?php include '../ecommerce/includes/trendingProduct.php'; ?><p></p>
<?php }?>
<?php include 'includes/footer.php' ?>
<script>

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
    var data ={
      'full_name' : jQuery('#full_name').val(),
      'email'     : jQuery('#email').val(),
      'street'     : jQuery('#street').val(),
      'street2'     : jQuery('#street2').val(),
      'city'     : jQuery('#city').val(),
      'state'     : jQuery('#state').val(),
      'zip_code'     : jQuery('#zip_code').val(),
      'phone'     : jQuery('#phone').val(),
      'country'     : jQuery('#country').val(),
    };
    jQuery.ajax({
      url : '/ecommerce/admin/parsers/check_address.php',
      method : 'POST',
      data : data,
      success : function(data){
        if(data != 'passed'){
          jQuery('#payment-errors').html(data);
          alert("Something went wrong. Address check might have failled verification. Please update address");
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
  Stripe.setPublishableKey('<?=STRIPE_PUBLIC;?>');


function stripeResponseHandler(status,response){
var $form = $('#payment-form');

if(response.error){
  //show errors on the $form
  $form.find('#payment-errors').text(response.error.message);
  $form.find('button').prop('disabled',false);
}else{
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
      $form.find('button').prop('disabled', true);
      Stripe.card.createToken($form, stripeResponseHandler);
      //prevent the form from submitting with the default action
      return false;
    });
  });

  function update_cart(mode,mycart_id,edit_id,edit_size,edit_quantity,edit_available){
    jQuery('#cart_errors').html("");
    var update_data = {'mode' : mode, "edit_id" : edit_id, "edit_size" : edit_size,"edit_quantity" : edit_quantity,"edit_available":edit_available};
    var cartCheck = {'mode' : mode, "cart_id" : mycart_id};
    jQuery.ajax({
      url : '/ecommerce/admin/parsers/cart_check.php',
      method : 'POST',
      data : cartCheck,
      success : function(data){
        if(data != 'success'){
          jQuery('#cart_errors').html(data);
          alert("Something went wrong. This item has either expired or removed");
        }
        if(data == 'success'){
          jQuery('#cart_errors').html("");
            jQuery.ajax({
              url : '/ecommerce/admin/parsers/update_cart.php',
              method : "post",
              data : update_data,
              success : function(data){location.reload();jQuery('#cart_errors').html(data);},
              error : function(){alert("Something went wrong");},
            });
          }
        location.reload();
          },
          errors : function(){alert("Something Went Wrong! Cart update was unsuccessful");},

        });

  }

  function wishlisttocart(mode,product_id,size,quantity,available,price,request){
    jQuery('#wish_errors').html("");
    var error = '';
    var product_available = {'dmode' : mode, "product_id" : product_id, "size" : size,"quantity" : quantity};
    var data_cart = {'dmode' : mode, "product_id" : product_id, "size" : size,"quantity" : quantity,"available":available,"price":price,"request":request};
    var data_update = {'mode' : 'wish', "edit_id" : product_id, "edit_size" : size,"edit_quantity" : quantity,"edit_available":available};
    jQuery.ajax({
      url : '/ecommerce/admin/parsers/check_product.php',
      method : 'POST',
      data : product_available,
      success : function(data){
        if(data != 'success'){
          jQuery('#wish_errors').html(data);
          alert("Something went wrong. Product availability could not be verified");
        }
        if(data == 'success'){
          jQuery('#wish_errors').html("");
            jQuery.ajax({
              url : '/ecommerce/admin/parsers/add_cart.php',
              method : "post",
              data : data_cart,
              success : function(){location.reload();},
              error : function(){alert("Something went wrong while adding product to cart.");},
            });
            jQuery.ajax({
              url : '/ecommerce/admin/parsers/update_cart.php',
              method : "post",
              data : data_update,
              success : function(){location.reload();},
              error : function(){alert("Something went wrong while updating cart.");},
            });
        }
      },
      errors : function(){alert("Something Went Wrong! Product availability check unsuccessful");},

    });
  }
  // This function update(remove) item from cart
  // return the item qty to product database
  // pdate(add) item to wishlist
  function carttowish(mode,mycart_id,product_id,size,quantity,available,price,request){
    jQuery('#wish_errors').html("");
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
</script>
