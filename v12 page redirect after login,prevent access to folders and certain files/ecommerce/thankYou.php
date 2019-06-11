<?php
require_once 'core/init.php';
include 'includes/head.php';
if(!is_logged_in()){
  login_error_redirect();
}
$successes = array();
$errors = array();
if (isset($_POST['formid']) && isset($_SESSION['formid']) && $_POST["formid"] == $_SESSION["formid"]){
//Get the rest of the post data
$full_name = (($_POST['full_name'] != '')?sanitize($_POST['full_name']):'');
$email = (($_POST['email'] != '')?sanitize($_POST['email']):'');
$street = (($_POST['street'] != '')?sanitize($_POST['street']):'');
$street2 = (($_POST['street2'] != '')?sanitize($_POST['street2']):'');
$city = (($_POST['city'] != '')?sanitize($_POST['city']):'');
$state = (($_POST['state'] != '')?sanitize($_POST['state']):'');
$zip_code = (($_POST['zip_code'] != '')?sanitize($_POST['zip_code']):'');
$country = (($_POST['country'] != '')?sanitize($_POST['country']):'');
$tax = (($_POST['tax'] != '')?sanitize($_POST['tax']):'');
$sub_total = (($_POST['sub_total'] != '')?sanitize($_POST['sub_total']):'');
$grand_total = (($_POST['grand_total'] != '')?sanitize($_POST['grand_total']):'');
$cart_id = ((isset($_SESSION['cartid']) != '')?sanitize($_SESSION['cartid']):'');
$description = (($_POST['description'] != '')?sanitize($_POST['description']):'');

if(isset($_POST['instorePurchase'])){
  $transactionType = (($_POST['tType'] != '')?sanitize($_POST['tType']):'');
  $characters = 'BCDFGHJKLMNPQRSTUVWXWZbcdfghjklmnpqrstvwxyz0123456789';
  $string = '';
  $random_string_length =15;
  $max = strlen($characters) - 1;
    for ($i = 0; $i < $random_string_length; $i++) {
         $string .= $characters[mt_rand(0, $max)];
    }
  $chargeId = $transactionType.$string;
}
if(isset($_POST['cardPurchase'])){
  //create new form id to prevent resubmission of form
  //form id generated from cart.php into session then changes
 $_SESSION["formid"] = md5(rand(0,10000000));
  // Set your secret key: remember to change this to your live secret key in production
  // See your keys here: https://dashboard.stripe.com/account/apikeys
  \Stripe\Stripe::setApiKey(STRIPE_PRIVATE);
  //$charge_amount = number_format($grand_total,2) * 100; //convert to kobo if dollar then cent
  $charge_amount = $grand_total * 100; //convert to kobo if dollar then cent
  $metadata = array(
    "cart_id" => $cart_id,
    "tax" => $tax,
    "sub_total" => $sub_total,
  );
  // Token is created using Checkout or Elements!
  // Get the payment token ID submitted by the form:
    try{
    $token = $_POST['stripeToken'];
    $charge = \Stripe\Charge::create(array(
        "amount" => $charge_amount,
        "currency" => CURRENCY,
        "source" => $token,
        "description" => $description,
        "receipt_email" => $email,
         "metadata"  => $metadata,

      )
    );
    }catch(\Stripe\Error\Card $e){
      //the card has been declined
      echo $e;
    }
  }
if(isset($_POST['instorePurchase']) || isset($_POST['cardPurchase'])){
//adjust inventory
$itemQ = $db->query("SELECT * FROM cart WHERE id ='{$cart_id}'");
$results = mysqli_fetch_assoc($itemQ);
$itemsOrdered = $results['items'];
$items = json_decode($results['items'],true);

foreach ($items as $item) {
  $newSizes = array();
  $qtyOrdered = array();
  $item_id = $item['id'];
  $productQ = $db->query("SELECT sizes,sold FROM products WHERE id='{$item_id}'");
  $product = mysqli_fetch_assoc($productQ);
  $sizes = sizesToArray($product['sizes']); //function in helper file
  $string = $product['sold'];
  $soldArray = explode(':',$string);
  $qty =(int)$soldArray[0];
  $tprice =(int)$soldArray[1];
  foreach($sizes as $size){
      if($size['size'] == $item['size']){
        //$q = $size['quantity'] - $item['quantity']; // subtract quantity ordered to that in database
        $qty = $qty + $item['quantity']; // subtract quantity ordered to that in database
        $tprice = $tprice + ($item['price'] * $item['quantity']);
        //$newSizes[] = array('size' => $size['size'],'price' => $size['price'],'quantity' => $q,'threshold' => $size['threshold']);
        $qtyOrdered[] = array('quantity' => $qty,'price' =>$tprice);
      }else{
        //$newSizes[] = array('size' => $size['size'],'price' => $size['price'],'quantity' => $size['quantity'], 'threshold' => $size['threshold']);
         //$qtyOrdered[] = array('quantity' => $solds['quantity'],'price' =>$solds['price']);
      }
    }



    //$sizeString = sizesToString($newSizes);
    $orderedString = qtysoldToString($qtyOrdered);
  //  $db->query("UPDATE products SET sizes = '{$sizeString}' WHERE id='{$item_id}'");
    $db->query("UPDATE products SET sold = '{$orderedString}' WHERE id='{$item_id}'");
  }

//update cart
$db->query("UPDATE cart SET paid = 1 WHERE id='{$cart_id}'");
if(isset($_POST['instorePurchase'])){
  $db->query("INSERT INTO transactions
  (charge_id,cart_id,full_name,email,street,street2,city,state,zip_code,country,items,sub_total,tax,grand_total,description,txn_type) VALUES
  ('$chargeId','$cart_id','$full_name','$email','$street','$street2','$city','$state','$zip_code','$country','$itemsOrdered','$sub_total','$tax','$grand_total','$description','$transactionType')");
  //$db->query("UPDATE transactions SET items = '{$itemsOrdered}' WHERE id = '{$cart_id}'");
  $_SESSION["formid"] = md5(rand(0,10000000));
}else{
  $db->query("INSERT INTO transactions
  (charge_id,cart_id,full_name,email,street,street2,city,state,zip_code,country,items,sub_total,tax,grand_total,description,txn_type) VALUES
  ('$charge->id','$cart_id','$full_name','$email','$street','$street2','$city','$state','$zip_code','$country','$itemsOrdered','$sub_total','$tax','$grand_total','$description','$charge->object')");
}


//$domain = ($_SERVER['HTTP_HOST'] != 'localhost:81')?'.'.$_SERVER['HTTP_HOST']:false;
//setcookie(CART_COOKIE,'',1,"/",$domain,false);
include 'includes/navigation.php';
if(isset($_POST['instorePurchase'])){
  $message = "Instore Transaction Complete";
echo "<script type='text/javascript'>alert('$message');</script>";
  ?>
  <?php }else{ ?>
    <hi class="text-center text-success">Thank You </h1>
      <p> Your card has been successfully charged <?=money($grand_total);?>, You have been emailed a receipt. Please
          check your span folder if email is not in your inbox. additional, you can print this page as your reference.</p>
      <p>Your receipt no is: <strong><?=$cart_id;?></strong></p>
      <p>Your order will be shipped to the address below</P>
      <address>
        <?=$full_name;?><br>
        <?=$street;?><br>
        <?=(($street2 != '')?$street2.'<br>': '');?>
        <?=$city.','.$state.''.$zip_code;?><br>
        <?=$country;?><br>
      </address>
  <?php } ?>
       <div class="container-fluid">
        <div id='success'> </div>
        <a href="index" class="btn btn-lg btn-success form-control"> Transaction Complete Continue Shopping</a>
      </div>
    <?php
   include 'includes/footer.php';

 }
}else{
?>
<div class="container-fluid">
    <div id='success'> </div>
    <a href="index" class="btn btn-lg btn-success form-control"> Continue Shopping</a>
  </div>
<?php }include 'includes/footer.php'; ?>
