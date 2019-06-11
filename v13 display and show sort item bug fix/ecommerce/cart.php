<style>
.cart_image img{
      width: 200px;
      height: 200px;
      display: inline-table;
}
.cart_image tr{
  text-align:center;
}
</style>

<?php
require_once 'core/init.php';
include 'includes/head.php';
include 'includes/navigation.php';
//include 'includes/headerpartial.php';
$_SESSION['rdrurl'] = $_SERVER['REQUEST_URI'];
$errors = array();
$expireflag = 1;
$paid = 0;
if(isset($user_name)){
$cartQ = $db->query("SELECT * FROM cart WHERE username = '{$user_name}' AND paid = '{$paid}'");
$return = mysqli_num_rows($cartQ);
  if($return != 1){
    $errors[] ="Shopping cart empty";
  }else{
    $formid = md5(rand(0,10000000));
    $result = mysqli_fetch_assoc($cartQ);
    $items = json_decode($result['items'],true);
    $i = 1;
    $sub_total = 0;
    $item_count = 0;
  }
}else{
  $errors[] ="Shopping cart empty";
}
?>
<p></p>
<div class="container bar-top">
  <h3 class="text-center">⇩My Shopping Cart⇩</h3>
</div>
<div class="col-md-12">
<div class="row">
<?php if(!empty($errors)): ?>
  <div class="bg-danger">
    <p class="text-center text-info">
      Your shopping Cart is empty!
    </p>
  </div>
<?php else: ?>
 <table class="table table-bordered  table-striped  table-responsive table-hover cart_image">
   <thead class= item-table-header><th>#</th><th>Item</th><th>Price</th><th>Quantity</th><th>Size/Request</th><th>Sub Total</th></thead>
   <tbody>
  <?php
    $itemcount = count($items);
    foreach($items as $item){
      //$expireflag=1;
      $itemcount--;
      $product_id =$item['id'];
      $productQ = $db->query("SELECT * FROM products WHERE id = '{$product_id}'");
      $product = mysqli_fetch_assoc($productQ);
      $sizes = sizesToArray($product['sizes']); //function in helper file
      foreach($sizes as $size){
          if($size['size'] == $item['size']){
            $available = (int)$size['quantity'];

        }
      }

      ?>
      <tr>
        <td>[<?=$i;?>]
        <button class="btn btn-danger btn-xs glyphicon glyphicon-remove" onclick="update_cart('delete','<?=$product['id'];?>','<?=$item['size'];?>','<?=$item['quantity'];?>','<?=$available;?>');"> Remove</button></td>

          <td>
              <?=$product['title'];?><br>
          <?php $photos = explode(',',$product['image']); ?>

           <img onclick="detailsmodal(<?= $product['id']; ?>)" src="<?= $photos[0]; ?>" alt="<?= $product['title']; ?>"/>
        </td>

        <td><?=money($item['price']);?></td>
        <td>
              <button class="btn btn-xs btn-info" onclick="update_cart('removeone','<?=$product['id'];?>','<?=$item['size'];?>','<?=$item['quantity'];?>','<?=$available;?>');"><strong>-</strong></button>
              <?php
                 if($available == 0){?>
                      <?=$item['quantity'];?>
                      <span class="text-danger">Max</span>
              <?php }elseif($available < 0) { $item['quantity'] = 0?>
                 <?=$item['quantity'];?>
                  <span class="text-danger">Unavailable</span>
              <?php }else{?>
                      <?=$item['quantity'];?>
                      <button class="btn btn-xs btn-info" onclick="update_cart('addone','<?=$product['id'];?>','<?=$item['size'];?>','<?=$item['quantity'];?>','<?=$available;?>');"><strong>+</strong></button>
                  <?php }?>
        </td>
        <td><?=$item['size'];?><p></p><?=$item['request'];?></td>
        <td><?=money($item['quantity'] * $item['price']);?></td>
      </tr>
      <?php
      $i++;
      $item_count += $item['quantity'];
      $sub_total += ($item['price'] * $item['quantity']);
    }$expireflag=0;
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

 <h3>Order Summary</h3>
 <table class="table table-bordered table-condensed text-right">
   <thead class="totals-table-header"><th>Total Items</th><th>Sub Total</th><th>Tax</th><th>Grand Total</th></thead>
   <tbody>
     <tr>
       <?php $_SESSION['total_item_ordered'] = $item_count?>
       <td><?=$item_count;?></td>
       <td><?=money($sub_total);?></td>
       <td><?=money($tax);?></td>
       <td class="grandTotallabel"><?=money($grand_total);?></td>
     </tr>
   </tbody>
    </table>

    <!-- check out button -->
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
    </div><p></p>


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
<?php endif; ?>
</div>
</div>
<?php include '/wishlist.php'; ?>

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

  function update_cart(mode,edit_id,edit_size,edit_quantity,edit_available){
    var data = {'mode' : mode, "edit_id" : edit_id, "edit_size" : edit_size,"edit_quantity" : edit_quantity,"edit_available":edit_available};
    jQuery.ajax({
      url : '/ecommerce/admin/parsers/update_cart.php',
      method : "post",
      data : data,
      success : function(){location.reload();},
      error : function(){alert("Something went wrong");},
    });
  }

  function wishlisttocart(mode,product_id,size,quantity,available,price,request){
    var data = {'mode' : mode, "product_id" : product_id, "size" : size,"quantity" : quantity,"available":available,"price":price,"request":request};
    var data2 = {'mode' : mode, "edit_id" : product_id, "edit_size" : size,"edit_quantity" : quantity,"edit_available":available};
    jQuery.ajax({
      url : '/ecommerce/admin/parsers/add_cart.php',
      method : "post",
      data : data,
      success : function(){location.reload();},
      error : function(){alert("Something went wrong");},
    });
    jQuery.ajax({
      url : '/ecommerce/admin/parsers/update_cart.php',
      method : "post",
      data : data2,
      success : function(){location.reload();},
      error : function(){alert("Something went wrong");},
    });
  }

</script>
