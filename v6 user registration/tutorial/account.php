<?php
require_once '/core/init.php';
//is_logged_in function is in helper file
//check if user is logged in on any of the pages
if(!is_logged_in()){
  login_error_redirect();
}
//check if user hs permision to view page
include 'includes/head.php';
include 'includes/navigation.php';

if(isset($customer_data['email'])){
  $user_email = $customer_data['email'];
}else{
  login_error_redirect();
}


if(isset($_GET['edit'])){
  $errors =array();
  $edit_id =(int)$_GET['edit'];
  $AdressUserResults = $db->query("SELECT * FROM customer_user WHERE email = '$user_email'");
   //var_dump($AdressUserResults); die();
  $userAddress = mysqli_fetch_assoc($AdressUserResults);
  $street = ((isset($_POST['street']) && $_POST['street'] != '')?sanitize($_POST['street']):$userAddress['street']);
  $street2 = ((isset($_POST['street2']) && $_POST['street2'] != '')?sanitize($_POST['street2']):$userAddress['street2']);
  $city = ((isset($_POST['city']) && $_POST['city'] != '')?sanitize($_POST['city']):$userAddress['city']);
  $state = ((isset($_POST['state']) && $_POST['state'] != '')?sanitize($_POST['state']):$userAddress['state']);
  $zip_code = ((isset($_POST['zip_code']) && $_POST['zip_code'] != '')?sanitize($_POST['zip_code']):$userAddress['zip_code']);
  $country = ((isset($_POST['country']) && $_POST['country'] != '')?sanitize($_POST['country']):$userAddress['country']);


  if($_POST){
      $required = array('street', 'city','state', 'zip_code','country');
    foreach($required as $f){
      if(empty($_POST[$f])){
        $errors[]="You must fill all fields.";
        break;
      }
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

      $insertSql = "UPDATE customer_user SET street ='$street', street2 ='$street2', state = '$state', zip_code ='$zip_code', country = '$country'
      WHERE email='$user_email'";
      $db->query($insertSql);
      $_SESSION['success_flash'] .= $userAddress['full_name']. '! Your Address has been successful updated!';
      header('Location: account.php');

      }

    }

?>
<h2 class="text-center"><?=((isset($_GET['edit']))?'Update ':'');?>Address</h2><hr>
<div id='errors'> </div>
<form action="account.php?<?=((isset($_GET['edit']))?'edit='.$edit_id:'');?>" method="post" enctype="multipart/form-data">
  <div class="form-group col-md-6">
    <label for="name">Street:</label>
    <input type="text" name="street" id="street" class="form-control" value="<?=((isset($_GET['edit']))?$street:'');?>">
  </div>
  <div class="form-group col-md-6">
    <label for="street2">Street2:</label>
    <input type="text" name="street2" id="street2" class="form-control" value="<?=((isset($_GET['edit']))?$street2:'');?>">
  </div>
  <div class="form-group col-md-6">
    <label for="city">city:</label>
    <input type="text" name="city" id="city" class="form-control" value="<?=((isset($_GET['edit']))?$city:'');?>">
  </div>
  <div class="form-group col-md-6">
    <label for="state">state:</label>
    <input type="text" name="state" id="state" class="form-control" value="<?=((isset($_GET['edit']))?$state:'');?>">
  </div>
  <div class="form-group col-md-6">
    <label for="zip_code">zip_code:</label>
    <input type="text" name="zip_code" id="zip_code" class="form-control" value="<?=((isset($_GET['edit']))?$zip_code:'');?>">
  </div>
  <div class="form-group col-md-6">
    <label for="country">country:</label>
    <input type="text" name="country" id="country" class="form-control" value="<?=((isset($_GET['edit']))?$country:'');?>">
  </div>
  <div class="form-group col-md-6 text-right" style="margin-top:25px;">
    <a href="account.php" class="btn btn-default">Cancel</a>
    <input type="submit" value="<?=((isset($_GET['edit']))?'Update': '');?> Address" class="btn btn-primary">
  </div>
</form>
<?php

}else{

$userQuery = $db->query("SELECT * FROM customer_user WHERE id = '$user_id' AND email = '$user_email'");
$user = mysqli_fetch_assoc($userQuery)
?>
<h2 class="text-center">My Account </h2><hr>
<h2>Hi, <?=$user['full_name']; ?></h2>
<table class="table table-bordered table-striped table-condensed">
  <thead><th></th><th>Name</th><th>Emails</th><th>Address</th><th>Join Date</th><th>Last Login</th></thead>
  <tbody>
    <?php //while($user = mysqli_fetch_assoc($userQuery)): ?>
    <tr>
      <td>
        <!--Ensure the user cannot delete himself by not diplaying delete button on his info row -->


          <a href="change_password.php?<?=$user['id'];?>" class="btn btn-default btn-md"><span class ="glyphicon glyphicon-lock"> Change Password</span></a><hr>
          <a href="account.php?viewT=<?=$user['id'];?>" class="btn btn-default btn-md"><span class ="glyphicon glyphicon-shopping-cart"> View Orders</span></a><hr>
          <a href="account.php?edit=<?=$user['id'];?>" class="btn btn-default btn-md"><span class ="glyphicon glyphicon-pencil"> Update Address</span></a>

      </td>
      <td><?=$user['full_name'];?></td>
      <td><?=$user['email'];?></td>
      <td><?=$user['street'];?>, <?=$user['street2'];?> <?=$user['zip_code'];?>,<br><?=$user['city'];?> <?=$user['state'];?>, <?=$user['country'];?></td>
      <td><?=my_dateFormat($user['join_date']);?></td>
      <td><?=(($user['last_login'] =='0000-00-00 00:00:00')?'Never logged in':my_dateFormat($user['last_login']));?></td>
    </tr>
  <?php //endwhile; ?>
  </tbody>
</table><hr>
<?php }

if(isset($_GET['viewT'])){
   $count = 1;
    $userTQuery = $db->query("SELECT * FROM transactions WHERE email = '$user_email'");

    ?>
    <table class="table table-bordered table-striped table-condensed">
      <thead class= "bg-primary"><th>S/N</th><th>charge ID</th><th>Item Ordered</th><th>Payment Type</th><th>Purchase_Date</th><th>Sub total</th><th>Tax</th><th>Grand Total</th></thead>
      <tbody>
        <?php while($userT = mysqli_fetch_assoc($userTQuery)): ?>
        <tr>
          <td><?=$count;?></td>
          <td><?=$userT['charge_id'];?></td>
          <td><?=$userT['description'];?></td>
          <td><?=$userT['txn_type'];?></td>
          <td><?=my_dateFormat($userT['txn_date']);?></td>
          <td><?=$userT['sub_total'];?></td>
          <td><?=$userT['tax'];?></td>
          <td><?=$userT['grand_total'];?></td>
        </tr>
        <?php $count++; ?>
      <?php endwhile; ?>
      </tbody>
    </table>

<?php }include 'includes/footer.php'; ?>
