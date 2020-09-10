<?php
require_once $_SERVER['DOCUMENT_ROOT'].'/ecommerce/core/init.php';
//is_logged_in function is in helper file
//check if user is logged in on any of the pages
if(!is_logged_in()){
  login_error_redirect();
}
//check if user hs permision to view page
include 'includes/head.php';
include 'includes/navigation.php';

if(isset($user_data['email'])){
  $user_email = $user_data['email'];
}else{
  login_error_redirect();
}
  $successflag = 0;
  $errors = array();
  $successes = array();
  $ratingRun = 'false';
  //exlicit rating
  //Rate product by monitoring a rating get request from user
  if(isset($_GET['rate']) && $ratingRun == 'false'){
    $rateString = ($_GET['rate']);
    $rate = explode("%",$rateString);
    try {
      $P_rateID = sanitize((int)$rate[0]);
      $P_ratingValue = sanitize((int)$rate[1]);
      //RateProduct($P_rateID,$P_ratingValue ,$user_id,"explicit");
      $rating = new RatingController();
      $rating->RateProduct($P_rateID, $P_ratingValue,$user_id,'explicit');
      $ratingRun = 'true';
    } catch (\Exception $e) {
    $errors[] = "Rating update have not been verified to be successful";
    $error = $e.getMessage();
    debugfilewriter($error);
    }

    ?>
    <script>
      window.location.replace("http://localhost:81/ecommerce/account");
    </script>
    <?php
  }
if(isset($_GET['edit']) && $successflag == 0){
  $edit_id =(int)$_GET['edit'];
  $uobj = new UserController();
  $AdressUserResults = $uobj->selectUserByEmail("customer",$user_email);
  //$AdressUserResults = $db->query("SELECT * FROM customer_user WHERE email = '$user_email'");
   //var_dump($AdressUserResults); die();
  //$userAddress = mysqli_fetch_assoc($AdressUserResults);
  foreach ($AdressUserResults as $userAddress ) {
    $userAddress = $userAddress;
  }
  $street = ((isset($_POST['street']) && $_POST['street'] != '')?sanitize($_POST['street']):$userAddress['street']);
  $street2 = ((isset($_POST['street2']) && $_POST['street2'] != '')?sanitize($_POST['street2']):$userAddress['street2']);
  $city = ((isset($_POST['city']) && $_POST['city'] != '')?sanitize($_POST['city']):$userAddress['city']);
  $state = ((isset($_POST['state']) && $_POST['state'] != '')?sanitize($_POST['state']):$userAddress['state']);
  $zip_code = ((isset($_POST['zip_code']) && $_POST['zip_code'] != '')?sanitize($_POST['zip_code']):$userAddress['zip_code']);
  $phone = ((isset($_POST['phone']) && $_POST['phone'] != '')?sanitize($_POST['phone']):$userAddress['phone']);
  $country = ((isset($_POST['country']) && $_POST['country'] != '')?sanitize($_POST['country']):$userAddress['country']);

  if(isset($_POST['address'])){
      $required = array('street', 'city','state', 'zip_code','country','phone');
    foreach($required as $f){
      if(empty($_POST[$f])){
        $errors[]="You must fill all fields.";
        break;
      }
    }
    if (!is_accept_phone_no($phone)){
    $errors[] = 'Phone number must have 11 figures. e.g 08030342243';
    }
    if(!empty($errors)){
      //pass errors into display_errors function in helpers.php to return the error as html
      $display =display_errors($errors); ?>
      <!--Display error on screen by using jquery to plug in the html-->
      <script>
        jQuery('document').ready(function(){
          jQuery('#errors').html('<?=$display; ?>');
        });
      </script>
    <?php
    }else{
    //  $insertSql = "UPDATE customer_user SET street ='$street', street2 ='$street2', state = '$state',city = '$city', zip_code ='$zip_code', phone='$phone', country = '$country'
    //  WHERE email='$user_email'";
      $db->query($insertSql);
      //$_SESSION['success_flash'] .= $userAddress['full_name']. '! Your Address has been successful updated!';
      $obj = new UserController();
      $obj->updateUserAddress($street,$street2,$state,$city,$zip_code,$phone,$country,$user_email);
      $successflag = 1;
      }
    }

?>
<div class="container-fluid"><!-- bootstrap class that makes it responsive -->
  <?php if ($successflag==1){ ?>
    <div id='success'> </div>
    <a href="account" class="btn btn-lg btn-success"> Return Back to account</a>
    <?php  if(isset($_SESSION['rdrurl'])){ ?>
      <a href="<?=$_SESSION['rdrurl']?>" class="btn btn-lg btn-success "> Return to previous page..</a>
  <?php } ?>
    <?php }else{ ?>
      <h2 class="text-center"><?=((isset($_GET['edit']))?'Update ':'');?>Address</h2><hr>
      <div id='errors'> </div>
    <form action="account.php?<?=((isset($_GET['edit']))?'edit='.$edit_id:'');?>" method="post" enctype="multipart/form-data">
      <div class="form-group col-md-6">
        <label for="name">Street:</label>
        <input type="text" name="street" id="street" class="form-control" value="<?=((isset($_GET['edit']))?$street:'');?>" required>
      </div>
      <div class="form-group col-md-6">
        <label for="street2">Street2:</label>
        <input type="text" name="street2" id="street2" class="form-control" value="<?=((isset($_GET['edit']))?$street2:'');?>">
      </div>
      <div class="form-group col-md-6">
        <label for="city">city:</label>
        <input type="text" name="city" id="city" class="form-control" value="<?=((isset($_GET['edit']))?$city:'');?>" required>
      </div>
      <div class="form-group col-md-6">
        <label for="state">state:</label>
        <input type="text" name="state" id="state" class="form-control" value="<?=((isset($_GET['edit']))?$state:'');?>" required>
      </div>
      <div class="form-group col-md-6">
        <label for="zip_code">zip_code:</label>
        <input type="text" name="zip_code" id="zip_code" class="form-control" value="<?=((isset($_GET['edit']))?$zip_code:'');?>">
      </div>
      <div class="form-group col-md-6">
        <label for="phone">Tel:</label>
        <input type="number" name="phone" id="phone" class="form-control" value="<?=((isset($_GET['edit']))?$phone:'');?>" required>
      </div>
      <div class="form-group col-md-6">
        <label for="country">country:</label>
        <input type="text" name="country" id="country" class="form-control" value="<?=((isset($_GET['edit']))?$country:'');?>" required>
      </div>
      <div class="form-group col-md-6 text-right" style="margin-top:25px;">
        <a href="account" class="btn btn-default">Cancel</a>
        <input type="submit" name ='address'value="<?=((isset($_GET['edit']))?'Update': '');?> Address" class="btn btn-primary">
      </div>
    </form>
      <?php } ?>
  </div>
<?php
}else{
$userQuery = $db->query("SELECT * FROM customer_user WHERE email = '$user_email'");
$user = mysqli_fetch_assoc($userQuery)
?>
<h2 class="text-center">My Account </h2><hr>
<h2>Hi, <?=$user['username']; ?></h2>
<table class="table table-bordered table-striped table-condensed">
  <thead><th></th><th>Name</th><th>Emails</th><th>Address</th><th>Join Date</th><th>Last Login</th></thead>
  <tbody>
    <tr>
      <td>
          <a href="change_password?<?=$user['id'];?>" class="btn bg-primary btn-md"><span class ="glyphicon glyphicon-lock"> Change Password</span></a><hr>
          <button id="myOrders" class="glyphicon glyphicon-shopping-cart btn bg-primary"onclick="transFunction()"> Show My Orders</button><hr>
          <!--<a href="account?viewT=<?=$user['id'];?>" class="btn btn-default btn-md"><span class ="glyphicon glyphicon-shopping-cart"> View Orders</span></a><hr> -->
          <a href="account?edit=<?=$user['id'];?>" class="btn bg-primary btn-md"><span class ="glyphicon glyphicon-pencil"> Update Address</span></a>
      </td>
      <td><?=$user['full_name'];?></td>
      <td><?=$user['email'];?></td>
      <td><?=$user['street'];?>, <?=$user['street2'];?> <?=$user['zip_code'];?>,<br><?=$user['city'];?> <?=$user['state'];?>, <?=$user['country'];?></td>
      <td><?=my_dateFormat($user['join_date']);?></td>
      <td><?=(($user['last_login'] =='0000-00-00 00:00:00')?'Never logged in':my_dateFormat($user['last_login']));?></td>
    </tr>
  </tbody>
</table><hr>
<?php }

   $count = 1;
    $userTQuery = $db->query("SELECT * FROM transactions WHERE email = '$user_email' ORDER BY `id` DESC");
    ?>
    <div id="orderContainer"class="countainer">
    <div class="panel panel-default">
      <div class="panel-heading text-center"><h3>Order Table</h3>
        <button id="myOrders" class="btn btn-warning pull-right"onclick="transFunction()"> Hide My Orders</button>
    </div>
    <table class="table table-bordered table-striped table-condensed">
      <thead class= "bg-primary"><th>S/N</th><th>Details</th>
        <th>Item Ordered
            <table class="table table-bordered table-condensed">
             <thead class= "bg-primary"><th>Qty</th><th>Item</th><th>Size</th><th>Price</th></thead>
           </table>
        </th>
        <th>Total</th></thead>
      <tbody>
        <?php while($userT = mysqli_fetch_assoc($userTQuery)):
        //  $cart = mysqli_fetch_assoc($userT);
          $items = json_decode($userT['items'],true);
          $idArray = array();
          $products = array();

          foreach ($items as $item) {
            $idArray[] = $item['id'];
          }
          $ids = implode(',',$idArray);
          $productQ = $db->query(
            "SELECT i.id as 'id', i.title as 'title',i.product_average_rating as 'product_average_rating', c.id as 'cid', c.category as 'child', p.category as 'parent'
            FROM products i
            LEFT JOIN categories c ON i.categories = c.id
            LEFT JOIN categories p ON c.parent = p.id
            WHERE i.id IN ({$ids})
            ");
            while ($p = mysqli_fetch_assoc($productQ)){
              foreach ($items as $item) {
                if ($item['id'] == $p['id']) {
                  $x = $item;
                  $products[] = array_merge($x,$p); //add item and product array
                  continue;
                }
              }
            }
              ?>
        <tr>
          <td><?=$count;?></td>
          <td>
            ID: <?=$userT['charge_id'];?><br>
            TYPE: <?=$userT['txn_type'];?><br>
            DATE: <?=my_dateFormat($userT['txn_date']);?>
          </td>
          <td>
            <table class="table table-bordered table-condensed">
              <thead></thead>
              <tbody>
                  <?php foreach($products as $product){ ?>
                <tr>
                  <td><?=$product['quantity'];?></td>
                  <td><?=$product['title'];?><br><?=$product['parent'].' ~ '.$product['child'];
                  ?><p> <?php    $rating = new RatingController();
                        $userRating= $rating->getProductRatingForUser($product['id'], $user_id);
                  if($userRating == 0) {?>
                      <p><label class="text-info"for="rating">Please Rate Product:</label>
                    <?php }else{ ?>
                    <label class="text-warning"for="rating">Your Previous Rating:</label>
                    <?php echo $userRating; ?> <span class="fa fa-star checkedRating"> </span></p>
                      <p><label class="text-info"for="rating">Update Rating:</label>
                      <?php } ?>
                    <a onmouseover="rateChoiceOver(this)" onmouseout="rateChoiceRelease(this)" href ="account?rate=<?=$product['id'];?>%1" class= "btn btn-xs btn-default uncheckedcheckedRaing" ><span class="fa fa-star uncheckedcheckedRaing"></span><a/>
                    <a onmouseover="rateChoiceOver(this)" onmouseout="rateChoiceRelease(this)" href ="account?rate=<?=$product['id'];?>%2" class= "btn btn-xs btn-default" ><span class="fa fa-star uncheckedcheckedRaing"></span><a/>
                    <a onmouseover="rateChoiceOver(this)" onmouseout="rateChoiceRelease(this)" href ="account?rate=<?=$product['id'];?>%3" class= "btn btn-xs btn-default" ><span class="fa fa-star uncheckedcheckedRaing"></span><a/>
                    <a onmouseover="rateChoiceOver(this)" onmouseout="rateChoiceRelease(this)" href ="account?rate=<?=$product['id'];?>%4" class= "btn btn-xs btn-default" ><span class="fa fa-star uncheckedcheckedRaing"></span><a/>
                    <a onmouseover="rateChoiceOver(this)" onmouseout="rateChoiceRelease(this)" href ="account?rate=<?=$product['id'];?>%5" class= "btn btn-xs btn-default" ><span class="fa fa-star uncheckedcheckedRaing"></span><a/>
                </td>
                  </td>
                  <td><?=$product['size'];?><p></p><?=$product['request'];?></td>
                  <td><?=$product['price'];?></td>
                </tr>
                <?php } ?>
              </tbody>
            </table>
          </td>
          <td>
            <?=$userT['sub_total'];?><br>
            DED: <?=$userT['tax'];?><hr>
            <?=$userT['grand_total'];?></td>
        </tr>
        <?php $count++; ?>
      <?php endwhile; ?>
      </tbody>
    </table>
</div>
</div>
<?php include 'includes/footer.php'; ?>
<script>
function transFunction() {
  var x = document.getElementById("orderContainer");
  if (x.style.display === "none") {
      x.style.display = "block";
  } else {
      x.style.display = "none";
  }
  var y = document.getElementById("myOrders");
  if (y.innerHTML === " Show My Orders") {
    y.innerHTML = " Hide My Orders";
  } else {
    y.innerHTML = " Show My Orders";
  }
}
$(document).ready(function(){
  var x = document.getElementById("orderContainer");
  x.style.display = "block";
});

function rateChoiceOver(x){
  x.style.width = "30px";
}

function rateChoiceRelease(x){
   x.style.width = "20px";
    x.style.color = "grey";
}
</script>
