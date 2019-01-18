<?php
require_once 'core/init.php';
// Set your secret key: remember to change this to your live secret key in production
// See your keys here: https://dashboard.stripe.com/account/apikeys
\Stripe\Stripe::setApiKey(STRIPE_PRIVATE);
//Get the rest of the post data
$full_name = sanitize($_POST['full_name']);
$email = sanitize($_POST['email']);
$street = sanitize($_POST['street']);
$street2 = sanitize($_POST['street2']);
$city = sanitize($_POST['city']);
$state = sanitize($_POST['state']);
$zip_code = sanitize($_POST['zip_code']);
$country = sanitize($_POST['country']);
$tax = sanitize($_POST['tax']);
$sub_total = sanitize($_POST['sub_total']);
$grand_total = sanitize($_POST['grand_total']);
$cart_id = sanitize($_POST['cart_id']);
$description = sanitize($_POST['description']);
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
//adjust inventory
$itemQ = $db->query("SELECT * FROM cart WHERE id ='{$cart_id}'");
$results = mysqli_fetch_assoc($itemQ);
$items = json_decode($results['items'],true);
foreach ($items as $item) {
  $newSizes = array();
  $item_id = $item['id'];
  $productQ = $db->query("SELECT sizes FROM products WHERE id='{$item_id}'");
  $product = mysqli_fetch_assoc($productQ);
  $sizes = sizesToArray($product['sizes']); //function in helper file
  foreach($sizes as $size){
      if($size['size'] == $item['size']){
        $q = $size['quantity'] - $item['quantity']; // subtract quantity ordered to that in database
        $newSizes[] = array('size' => $size['size'],'quantity' => $q,'threshold' => $size['threshold']);
      }else{
        $newSizes[] = array('size' => $size['size'],'quantity' => $size['quantity'], 'threshold' => $size['threshold']);
      }
    }
    $sizeString = sizesToString($newSizes);
    $db->query("UPDATE products SET sizes = '{$sizeString}' WHERE id='{$item_id}'");
  }

//update cart
$db->query("UPDATE cart SET paid = 1 WHERE id='{$cart_id}'");
$db->query("INSERT INTO transactions
(charge_id,cart_id,full_name,email,street,street2,city,state,zip_code,country,sub_total,tax,grand_total,description,txn_type) VALUES
('$charge->id','$cart_id','$full_name','$email','$street','$street2','$city','$state','$zip_code','$country','$sub_total','$tax','$grand_total','$description','$charge->object')");

$domain = ($_SERVER['HTTP_HOST'] != 'localhost:81')?'.'.$_SERVER['HTTP_HOST']:false;
setcookie(CART_COOKIE,'',1,"/",$domain,false);
include 'includes/head.php';
include 'includes/navigation.php';
include 'includes/headerpartial.php';
?>
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
<?php
include 'includes/footer.php';
} catch(\Stripe\Error\Card $e){
  //the card has been declined
  echo $e;
}
?>
