<?php
require_once $_SERVER['DOCUMENT_ROOT'].'/tutorial/core/init.php';
include 'includes/head.php';
include 'includes/navigation.php';

// if add button is pressed display add product section else show added product
if(isset($_GET['add'])){
$brandQuery = $db->query("SELECT * FROM brand ORDER BY brand"); //get brand from database
$parentQuery = $db->query("SELECT * FROM categories WHERE parent = 0 ORDER BY category"); //in database parent column is zero while child is not zero(referencing parent)

if($_POST){
  $errors=array();
  If(!empty($_POST['sizes'])) {
    $sizeString = sanitize($_POST['sizes']);
    $sizeString =rtrim($sizeString,',');
    $sizesArray = explode(',',$sizeString);
    $sArray =array();
    $qArray =array();
    foreach($sizesArray as $ss){
      $s = explode(':', $ss); //seperate content of array using (;) as delimeter
      $sArray[] =$s[0]; //first element of array is size
      $qArray[] =$s[1]; //first element of array is quantity
    }
  }else{$sizesArray = array();}
  $required = array('title','brand','price','child','sizes'); //required field on the add product date_create_from_format
  foreach($required as $field){
    if($_POST[$field] ==''){
      $errors[]= 'All fields with Asterisk are required.';
      break;
    }
  }
  //image property appear as shown bellow
  //array(1) { ["photo"]=> array(5) { ["name"]=> string(16) "examplePhoto.png" ["type"]=> string(9) "image/png" ["tmp_name"]=> string(24) "C:\xampp\tmp\php6EBB.tmp" ["error"]=> int(0) ["size"]=> int(153623) } }
  if(!empty($_FILES)){
    var_dump($_FILES);
    $photo = $_FILES['photo'];
    $name= $photo['name'];
    $nameArray = explode('.',$name); // explode the photo string sperated by , which shows info properties about the photo
    $fileName = $nameArray[0];
    $fileExt = $nameArray[1];
    $mime = explode('/',$photo['type']);
    $mimeType = $mime[0];
    $mineExt = $mime[1];
    $tmpLoc = $photo['tmp_name'];
    $fileSize = $photo['size'];
    $allowedImageExt =array('png','jpg','jpeg','gif');
    //if upload is not an image
    if($mimeType != 'image'){
      $errors[] = 'The file uploaded is not an image. Upload an image file please.';
    }
    if(!in_array($fileExt, $allowedImageExt)){
      $errors[] = "The photo must be of file extension [png, jpg, jpeg or gif]";
    }
    //check file sizes
    if($fileSize > 15000000){
      $errors[] = "File size must not exceed 15mb)";
    }

    if($fileExt != $mineExt && ($mineExt == 'jpeg' && $fileExt != 'jpg')){
      $errors[] ='File extention does not match the file';
    }
  }
  if(!empty($errors)){
    echo display_errors($errors);
  }else{
    //upload file and insert into database
  }
}
  ?>
  <h2 class="text-center">Add A New Product</h2><hr>
  <form action="products.php?add=1" method="POST" enctype="multipart/form-data">
    <div class="form-group col-md-3">
      <label for="title">Title*:</label>
      <input type="text" name="title" class="form-control" id="title" value="<?=((isset($_POST['title']))?sanitize($_POST['title']):'');?>">
    </div>
    <div class="form-group col-md-3">
      <label for="brand">Brand*:</label>
      <select class= "form-control" id = "brand" name ="brand">
      <option value=""<?=((isset($_POST['brand']) && $_POST['brand'] =='')?'selected':'');?>></option> <!--list all brand in drop menu on default -->
        <?php while($brand = mysqli_fetch_assoc($brandQuery)): ?>
          <option value="<?=$brand['id'];?>"<?=((isset($_POST['brand'])  && $_POST['brand'] == $brand['id'])?'selected':'');?>><?=$brand['brand'];?></option>
        <?php endwhile; ?>
      </select>
   </div>
   <div class="form-group col-md-3">
     <label for ="parent">Parent Category*:</label>
     <select class ="form-control" id="parent" name ="parent">
       <option value=""<?=((isset($_POST['parent']) && $_POST['parent'] == '')?'selected':''); ?>></option>
       <?php while($parent = mysqli_fetch_assoc($parentQuery)): ?>
         <option value="<?=$parent['id'];?>"<?=((isset($_POST['parent']) && $_POST['parent'] == $parent['id'])?'select':'');?>><?=$parent['category'];?></option>
       <?php endwhile; ?>
     </select>
   </div>
   <div class ="form-group col-md-3">
     <label for="child">Child Category*:</label> <!--A listener is in the footer to dynamically load child of the parent selected -->
     <select id ="child" name="child" class ="form-control">
     </select>
   </div>
    <!-- Price label -->
   <div class="form-group col-md-3">
     <label for="price">Price*:</label>
     <input type="text" id="list_price" name="list_price" class="form-control" value="<?=((isset($_POST['price']))?sanitize($_POST['price']):'');?>">
   </div>
   <!--List Price label -->
   <div class="form-group col-md-3">
     <label for="price">List Price:</label>
     <input type="text" id="list_price" name="price" class="form-control" value="<?=((isset($_POST['list_price']))?sanitize($_POST['list_price']):'');?>">
   </div>
   <!--Quantity & Sizes label -->
   <div class="form-group col-md-3">
   <label>Quantity & Sizes*:</label>
   <button class="btn btn-default form-control" onclick="jQuery('#sizesModal').modal('toggle');return false">Quantity & Sizes</button>
   </div>
   <div class ="form-group col-md-3">
     <label for="sizes">Sizes & Qty Preview</label>
     <input type="text" class="form-control" name="sizes" id="sizes" value="<?=((isset($_POST['sizes']))?$_POST['sizes']:'');?>" readonly>
   </div>
    <!--photo label -->
    <div class="form-group col-md-6">
      <label for="photo">Product Photo:</label>
      <input type="file" name="photo" id="photo" class="form-control">
    </div>
     <!--List Price label -->
     <div class="form-group col-md-6">
       <label for="description">description:</label>
       <textarea id="description" name="description"  class="form-control" rows="6"><?=((isset($_POST['description']))?sanitize($_POST['description']):'');?></textarea>
     </div>
     <!--photo label -->
     <div class= "form-group pull-right">
       <input type="submit" value="Add Product" class="form-control btn btn-success">
     </div><div class="clearfix"></div>
     </div>
  </form>
  <!-- Sizes Modal -->
  <div class="modal fade" id="sizesModal" tabindex="-1" role="dialog" aria-labelledby="sizesModalLabel">
    <div class="modal-dialog modal-lg" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
          <h4 class="modal-title" id="sizesModalLabel">Size & Quantity</h4>
        </div>
        <div class="modal-body">
          <div class="container-fluid">
          <?php for($i=1; $i<=12; $i++): ?>
          <div class="form-group col-md-4">
            <label for="size<?=$i;?>">Size:</label>
            <input type="text" name="size<?=$i;?>" id="size<?=$i;?>" value="<?=((!empty($sArray[$i-1]))?$sArray[$i-1]:'');?>"  class= "form-control">
          </div>
          <div class="form-group col-md-2">
            <label for="qty<?=$i;?>">Quantity:</label>
            <input type="number" name="qty<?=$i;?>" id="qty<?=$i;?>" value="<?=((!empty($qArray[$i-1]))?$qArray[$i-1]:'');?>" min="0" class= "form-control">
          </div>

          <?php endfor; ?>
        </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
          <!--Onclick fires a function updateSizes() in admin/footer.php -->
          <button type="button" class="btn btn-primary" onclick="updateSizes();jQuery('#sizesModal').modal('toggle');return false;">Save changes</button>
        </div>
      </div>
    </div>
  </div>
<?php
}else{
$sql ="SELECT * FROM products WHERE deleted = 0";
$product_results =$db->query($sql);

// set and unset featured product
if(isset($_GET['featured'])){
  $id =(int)$_GET['id'];
  $featured = (int)$_GET['featured'];
  $featuredsql = "UPDATE products SET featured = '$featured' WHERE id = '$id'";
  $db->query($featuredsql);
  header('Location: products.php');
}
?>
<h2 class="text-center">Products</h2>
<a href="products.php?add=1" class ="btn btn-success pull-right" id="add-product-btn">Add Product</a><div class="clearfix"></div>
<hr>
<table class="table table-bordered table-condensed table-striped">
  <tbody><th></th><th>Product</th><th>Price</th><th>Category</th><th>Featured</th><th>Sold</th></thead>
<tbody>
  <?php while($product =mysqli_fetch_assoc($product_results)):
    $childID = $product['categories'];
    $category_sql = "SELECT * FROM categories WHERE id = '$childID'";
    $result = $db->query($category_sql);
    $child = mysqli_fetch_assoc($result);
    $parentID = $child['parent'];
    $parent_sql = "SELECT * FROM categories WHERE id = '$parentID'";
    $parent_result =$db->query($parent_sql);
    $parent = mysqli_fetch_assoc($parent_result);
    $category = $parent['category'].'-'.$child['category'];


  ?>
    <tr>
        <td>
          <a href ="products.php?edit=<?=$product['id'];?>" class= "btn btn-xs btn-default"><span class="glyphicon glyphicon-pencil"></span><a/>
          <a href ="products.php?delete=<?=$product['id'];?>" class= "btn btn-xs btn-default"><span class="glyphicon glyphicon-remove"></span><a/>
        </td>
      <td><?=$product['title'];?></td>
      <td><?=money($product['price']);?></</td> <!--the money function is in helper class to add the dollar sign -->
      <td><?=$category;?></td>
      <td><a href = "products.php?featured=<?=(($product['featured']== 0)?'1':'0');?>&id=<?=$product['id'];?>" class = "btn btn-xs btn-default">
        <span class = "glyphicon glyphicon-<?=(($product['featured']==1)?'minus':'plus');?>"></span>
      </a>&nbsp <?=(($product['featured'] == 1)?'Featured Product':'');?></td>
      <td>0</td>
    </tr>
  <?php endwhile; ?>
</tbody>

</table>
<?php }
include 'includes/footer.php';
