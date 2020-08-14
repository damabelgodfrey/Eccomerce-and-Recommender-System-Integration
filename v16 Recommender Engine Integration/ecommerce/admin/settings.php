
<style media="screen">
  .submitB{
    position: fixed;
    right: 1px;
    top: 21%;
    z-index: 1000
  }
  .logo_image img{
     max-height: 200px;
     max-width: 200px;
  }
</style>
<?php
//require_once '../core/staff-init.php';
require_once $_SERVER['DOCUMENT_ROOT'].'/ecommerce/core/staff-init.php';

if(!is_staff_logged_in()){
  login_error_redirect();
}
if(!check_staff_permission('admin')){
  permission_error_redirect('index');
}
//include 'includes/head.php';
//include 'includes/navigation.php';
//include_once 'includes/Pagination.class.php';
include $_SERVER['DOCUMENT_ROOT'].'/ecommerce/admin/includes/head.php';
include $_SERVER['DOCUMENT_ROOT'].'/ecommerce/admin/includes/navigation.php';
$_SESSION['staff_rdrurl'] = $_SERVER['REQUEST_URI'];
$settingsR = $db->query("SELECT * FROM settings");
$settings = mysqli_fetch_assoc($settingsR);
$c_id = $settings['id'];
$c_name = ((isset($_POST['c_name']))?sanitize($_POST['c_name']):$settings['company_name']);
$c_logo = ((isset($_POST['c_logo']))?sanitize($_POST['c_logo']):$settings['logo']);
$logopath =$c_logo;
$c_product = ((isset($_POST['c_product']))?sanitize($_POST['c_product']):$settings['product']);
$c_address = ((isset($_POST['c_address']))?sanitize($_POST['c_address']):$settings['address']);
$c_about = ((isset($_POST['c_about']))?sanitize($_POST['c_about']):$settings['about']);
$c_email = ((isset($_POST['c_email']))?sanitize($_POST['c_email']):$settings['email']);
$c_city = ((isset($_POST['c_city']))?sanitize($_POST['c_city']):$settings['city']);
$c_country = ((isset($_POST['c_country']))?sanitize($_POST['c_country']):$settings['country']);
$c_tel = ((isset($_POST['c_tel']))?sanitize($_POST['c_tel']):$settings['tel']);
$c_slogan = ((isset($_POST['c_slogan']))?sanitize($_POST['c_slogan']):$settings['slogan']);
$c_facebook_id = ((isset($_POST['c_facebook_id']))?sanitize($_POST['c_facebook_id']):$settings['facebook_id']);
$c_instagram_id = ((isset($_POST['c_instagram_id']))?sanitize($_POST['c_instagram_id']):$settings['instagram_id']);
$c_twitter_id = ((isset($_POST['c_twitter_id']))?sanitize($_POST['c_twitter_id']):$settings['twitter_id']);
$c_linkedin_id = ((isset($_POST['c_linkedin_id']))?sanitize($_POST['c_linkedin_id']):$settings['linkedin_id']);
$c_youtube_id = ((isset($_POST['c_youtube_id']))?sanitize($_POST['c_youtube_id']):$settings['youtube_id']);
$c_currency = ((isset($_POST['c_currency']))?sanitize($_POST['c_currency']):$settings['currency']);
$c_maintenance_status = ((isset($_POST['c_maintenance_status']))?sanitize($_POST['c_maintenance_status']):$settings['maintenance_status']);
if(isset($_GET['delete_logo'])){
  if(check_staff_permission('admin')){
  $QResults= $db->query("SELECT * FROM settings");
  $logoimage = mysqli_fetch_assoc($QResults);
  $logo_url =$_SERVER['DOCUMENT_ROOT'].$logoimage['logo'];
  unlink($logo_url);
  $db->query("UPDATE settings SET logo = ''");
  redirect('settings');
  }else{
    $message = "Please! You do not have sufficient clearance to delete product.";
    permission_ungranted('settings',$message);
  }
}
if(isset($_GET['mstatus'])){
  if(check_staff_permission('admin')){
    $status = (int)$_GET['mstatus'];
  $db->query("UPDATE settings SET maintenance_status = '$status'");
  redirect('settings');
  }else{
    $message = "Please! You do not have sufficient clearance to delete product.";
    permission_ungranted('settings',$message);
  }
}
if(isset($_POST['settings'])){
  $c_id = $settings['id'];
  $c_name = ((isset($_POST['c_name']))?sanitize($_POST['c_name']):$settings['company_name']);
  $c_logo = ((isset($_POST['c_logo']))?sanitize($_POST['c_logo']):$settings['logo']);
  $logopath =$c_logo;
  $c_product = ((isset($_POST['c_product']))?sanitize($_POST['c_product']):$settings['product']);
  $c_address = ((isset($_POST['c_address']))?sanitize($_POST['c_address']):$settings['address']);
  $c_about = ((isset($_POST['c_about']))?sanitize($_POST['c_about']):$settings['about']);
  $c_email = ((isset($_POST['c_email']))?sanitize($_POST['c_email']):$settings['email']);
  $c_city = ((isset($_POST['c_city']))?sanitize($_POST['c_city']):$settings['city']);
  $c_country = ((isset($_POST['c_country']))?sanitize($_POST['c_country']):$settings['country']);
  $c_tel = ((isset($_POST['c_tel']))?sanitize($_POST['c_tel']):$settings['tel']);
  $c_slogan = ((isset($_POST['c_slogan']))?sanitize($_POST['c_slogan']):$settings['slogan']);
  $c_facebook_id = ((isset($_POST['c_facebook_id']))?sanitize($_POST['c_facebook_id']):$settings['facebook_id']);
  $c_instagram_id = ((isset($_POST['c_instagram_id']))?sanitize($_POST['c_instagram_id']):$settings['instagram_id']);
  $c_twitter_id = ((isset($_POST['c_twitter_id']))?sanitize($_POST['c_twitter_id']):$settings['twitter_id']);
  $c_linkedin_id = ((isset($_POST['c_linkedin_id']))?sanitize($_POST['c_linkedin_id']):$settings['linkedin_id']);
  $c_youtube_id = ((isset($_POST['c_youtube_id']))?sanitize($_POST['c_youtube_id']):$settings['youtube_id']);
  $c_currency = ((isset($_POST['c_currency']))?sanitize($_POST['c_currency']):$settings['currency']);
  $c_maintenance_status = ((isset($_POST['c_maintenance_status']))?sanitize($_POST['c_maintenance_status']):$settings['maintenance_status']);
if(!empty($_FILES)){
  $logo = $_FILES['c_logo'];
  $name= $logo['name'];
  //$fileName = $nameArray[0];
  $nameArray = explode('.',$name); // explode the photo string sperated by , which shows info properties about the photo
  $fileExt = end(explode('.',$name));
  $mime = explode('/',$logo['type']);
  $mimeType = $mime[0];
  $mineExt = end(explode('/',$logo['type']));
  $tmpLoc = $logo['tmp_name'];
  $fileSize = $logo['size'];
  $allowedImageExt =array('jpg');
  $uploadName ='logo.'.$fileExt;
  $uploadPath = BASEURL.'images/headerlogo/'.$uploadName;
  $logopath = '/ecommerce/images/headerlogo/'.$uploadName;
  //if upload is not an image
  if($mimeType != 'image'){
    $errors[] = 'The file uploaded is not an image. Upload an image file please.';
  }else if(!in_array($fileExt, $allowedImageExt)){
    $errors[] = "The photo must be of file extension [jpg]";
  }else if($fileSize > 15000000){
    $errors[] = "File size must not exceed 15mb)";
  }else if($fileExt != $mineExt && ($mineExt == 'jpeg' && $fileExt != 'jpg')){
    $errors[] ='File extention does not match the file';
  }else {
    move_uploaded_file($tmpLoc,$uploadPath);
  }
}
if(!empty($errors)){
  echo display_errors($errors);
}else{
  $insertSql = "UPDATE settings SET
  company_name ='$c_name', logo ='$logopath', product='$c_product', address ='$c_address',about ='$c_about',city ='$c_city',country ='$c_country',
  email ='$c_email', tel ='$c_tel', slogan='$c_slogan', facebook_id ='$c_facebook_id',instagram_id ='$c_instagram_id',twitter_id ='$c_twitter_id',
  linkedin_id ='$c_linkedin_id',youtube_id ='$c_youtube_id',currency = '$c_currency'";
  $db->query($insertSql);
  $_SESSION['success_flash'] .=' Settings has been updated!';
  redirect('settings');
}
}
?>

<div class="box">
<form action="settings" method="post" enctype="multipart/form-data">
<div class="col-md-12">
  <h2 class="text-center">Settings</h2><hr>
  <div class="form-group col-xs-12 text-center">
    <label for="maintainance">maintenance Status:</label>
    <a type="button" href = "settings?mstatus=<?=(($settings['maintenance_status']== 0)?'1':'0');?>&id=<?=$settings['id'];?>" class = "btn btn-sm <?=(($settings['maintenance_status'] == 1)?'btn-success':'btn-default');?> ">
      <span class = "glyphicon glyphicon-<?=(($settings['maintenance_status']==1)?'minus':'plus');?>"></span>
    </a>&nbsp <?=(($settings['maintenance_status'] == 1)?'Active':'OFF');?>
  </div>
</div>
  <div class="form-group col-sm-3">
    <label for="c_name">Company Name:</label>
    <input type="text" name="c_name" id="c_name" class="form-control" value="<?=$c_name;?>" required>
  </div>
    <div class="form-group col-sm-3">
    <label for="c_product">Product type:</label>
    <input type="text" name="c_product" id="c_product" class="form-control" value="<?=$c_product;?>" required>
  </div>
  <div class="form-group col-sm-6">
    <label for="c_slogan">Slogan:</label>
    <input type="text" name="c_slogan" id="c_slogan" class="form-control" value="<?=$c_slogan;?>">
  </div>
  <div  class="form-group col-sm-6">
    <?php if($c_logo != ''): ?>
      <div class="logo_image ">
      <img src="<?=$c_logo;?>" alt="saved image"/><br>
      <a href="settings?delete_logo=1&delete=<?=$c_id;?>" class="text-danger">Delete Logo</a>
    </div>
  <?php else:?>
    <label for="c_logo">Logo:</label>
    <input type="file" name="c_logo" id="c_logo" class="form-control" required>
  <?php endif; ?>
  </div>
  <div class="form-group col-sm-6">
    <label for="c_address">About US</label>
    <textarea id="c_about" name="c_about" value="" class="form-control" maxlength="50" placeholder="Company brief" rows="8" required><?=$c_about;?></textarea>
  </div>
</div> <p></p>
  <div class="box">
    <h3 class="text-center">Address Settings</h3>
  </div>
  <p></p>
  <div class="box">
    <div class="form-group col-sm-4">
    <label for="c_address">Address</label>
    <textarea id="c_address" name="c_address" value="" class="form-control" maxlength="50" placeholder="Enter Address" rows="8" required><?=$c_address;?></textarea>
  </div>
<div class="col-sm-8">
  <div class="form-group col-xs-6">
    <label for="phone">Tel</label>
    <div class="input-group">
       <span class="input-group-addon" id="basic-addon1">+234</span>
       <input type="number" name="c_tel" id="c_tel" class="form-control" value="<?=$c_tel;?>" placeholder="e.g 08030342243" >
  </div>
  </div>

  <div class="form-group col-xs-6">
    <label for="email">Email:</label>
    <input type="email" name="c_email" id="c_email" class="form-control" value="<?=$c_email;?>" required>
  </div>
  <div class="form-group col-xs-6">
    <label for="c_city">City:</label>
    <input type="text" name="c_city" id="c_city" class="form-control" value="<?=$c_city;?>" required>
  </div>
  <div class="form-group col-xs-6">
      <label for="c_country">Countries:</label>
      <select name="c_country" class="form-control" >
        <option value="<?=$c_country;?>"><?=$c_country;?></option>
    <?php
    foreach($countries as $c_country) {
    ?>
    <option value="<?= $c_country ?>" title="<?= htmlspecialchars($c_country) ?>"><?= htmlspecialchars($c_country) ?></option>
    <?php
    }
    ?>
  </select>
  </div>
  </div>
  <p></p>
  <input type="submit" value="Save changes" name="settings" class="submitB mybutton btn btn-primary pull-right">

</div>
  <p></p>
<br>
  <div class="box col-md-12">
    <h3 class="text-center">Social Media Settings</h3>
  </div>
  <p></p>
  <div class="box">
  <div class="form-group col-xs-6">
    <label for="c_facebook_id">Facebook ID:</label>
    <input type="text" name="c_facebook_id" id="c_facebook_id" class="form-control" value="<?=$c_facebook_id;?>">
  </div>
  <div class="form-group col-xs-6">
    <label for="c_instagram_id">Instagram ID:</label>
    <input type="text" name="c_instagram_id" id="c_instagram_id" class="form-control" value="<?=$c_instagram_id;?>">
  </div>
  <div class="form-group col-xs-6">
    <label for="c_linkedin_id">linkedin ID:</label>
    <input type="text" name="c_linkedin_id" id="c_linkedin_id" class="form-control" value="<?=$c_linkedin_id;?>">
  </div>
  <div class="form-group col-xs-6">
    <label for="c_twitter_id">Twitter ID:</label>
    <input type="text" name="c_twitter_id" id="c_twitter_id" class="form-control" value="<?=$c_twitter_id;?>">
  </div>
  <div class="form-group col-xs-6">
    <label for="c_youtube_id">Youtube ID:</label>
    <input type="text" name="c_youtube_id" id="c_youtube_id" class="form-control" value="<?=$c_youtube_id;?>">
  </div>
  <div class="form-group col-xs-6">
    <label for="c_currency">Currency:</label>
    <input type="text" name="c_currency" id="c_currency" class="form-control" value="<?=$c_currency;?>">
  </div>
  <div class="form-group col-xs-6 text-right" style="margin-top:25px;">
    <a href="index" class="btn btn-default">Cancels</a>
    <input type="submit" value="settings" name="settings" class="mybutton btn btn-primary">
  </div>
</form>
</div>

<?php include $_SERVER['DOCUMENT_ROOT'].'/ecommerce/admin/includes/footer.php'; ?>
