<?php
require_once $_SERVER['DOCUMENT_ROOT'].'/tutorial/core/init.php';
//check if user is logged in on any of the pages
if(!is_logged_in()){
  login_error_redirect();
}
include 'includes/head.php';
include 'includes/navigation.php';
//delete a products
if(isset($_GET['delete'])){
  if(has_admin_permission('admin')){
  $id = sanitize($_GET['delete']);
  //IF YOU Want to delete product without archieve
  $db->query("DELETE FROM products WHERE id='$id'");
  header('Location: products.php');
  }else{
    permission_ungranted('products.php');
  }
}
if(isset($_GET['archive'])){
  if(has_editor_permission('editor')){
    $p_id=sanitize($_GET['archive']);
    //instead of deleting the product we simply update it to archive
    $db->query("UPDATE products SET deleted =1 WHERE id='$p_id'");
    $p_featured = 0; //turn featured off if you archive a product
    $p_featuredsql = "UPDATE products SET featured = '$a_featured' WHERE id = '$p_id'";
    $db->query($p_featuredsql);
    header('Location: products.php');
    }else{
      permission_ungranted('products.php');
    }
}
$dbpath = '';
// if add button is pressed display add product section else show added product
if(isset($_GET['add']) || isset($_GET['edit'])){
  if(has_editor_permission('editor')){
  $brandQuery = $db->query("SELECT * FROM brand ORDER BY brand"); //get brand from database
  $parentQuery = $db->query("SELECT * FROM categories WHERE parent = 0 ORDER BY category"); //in database parent column is zero while child is not zero(referencing parent)
  $title =((isset($_POST['title']) && $_POST['title'] != '')?sanitize($_POST['title']):'');
  $brand = ((isset($_POST['brand']) && !empty($_POST['brand']))?sanitize($_POST['brand']):'');
  $parent = ((isset($_POST['parent']) && !empty($_POST['parent']))?sanitize($_POST['parent']):'');
  $category = ((isset($_POST['child']) && !empty($_POST['child']))?sanitize($_POST['child']):'');
  $price =((isset($_POST['price']) && $_POST['price'] != '')?sanitize($_POST['price']):'');
  $list_price =((isset($_POST['list_price']) && $_POST['list_price'] != '')?sanitize($_POST['list_price']):'');
  $description =((isset($_POST['description']) && $_POST['description'] != '')?sanitize($_POST['description']):'');
  $sizes =((isset($_POST['sizes']) && $_POST['sizes'] != '')?sanitize($_POST['sizes']):'');
  $sizes =rtrim($sizes, ','); //remove last comma from sizes string
  //$saved_image = ''; // if get is not set
  // store edit id if edit button is clicked
    if(isset($_GET['edit'])){
          $edit_id =(int)$_GET['edit'];
          $EditProductResults = $db->query("SELECT * FROM products WHERE id='$edit_id'");
          $product = mysqli_fetch_assoc($EditProductResults);
          if(isset($_GET['delete_image'])){
            $image_url =$_SERVER['DOCUMENT_ROOT'].$product['image'];
            unlink($image_url);
            $db->query("UPDATE products SET image = '' WHERE id='$edit_id'");
            header('Location: products.php?edit='.$edit_id);
          }
          $category = ((isset($_POST['child']) && $_POST['child'] != '')?sanitize($_POST['child']):$product['categories']);
          $title = ((isset($_POST['title']) && $_POST['title'] != '')?sanitize($_POST['title']):$product['title']);
          $brand = ((isset($_POST['brand']) && $_POST['brand'] != '')?sanitize($_POST['brand']):$product['brand']);
          $parentQ =$db->query("SELECT * FROM categories WHERE id='$category'");
          $parentResult = mysqli_fetch_assoc($parentQ);
          $parent = ((isset($_POST['parent']) && $_POST['parent'] != '')?sanitize($_POST['parent']):$parentResult['parent']);
          $price = ((isset($_POST['price']) && $_POST['price'] != '')?sanitize($_POST['price']):$product['price']);
          $list_price = ((isset($_POST['list_price']) && $_POST['list_price'] != '')?sanitize($_POST['list_price']):$product['list_price']);
          $description = ((isset($_POST['description']) && $_POST['description'] != '')?sanitize($_POST['description']):$product['description']);
          $sizes = ((isset($_POST['sizes']) && $_POST['sizes'] != '')?sanitize($_POST['sizes']):$product['sizes']);
          $sizes =rtrim($sizes, ',');
          $saved_image = (($product['image'] != '')?$product['image']:'');
          $dbpath = $saved_image;
        }
    If(!empty($sizes)) {
      $sizeString = sanitize($sizes);
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

    if($_POST){
      $errors=array();
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
        $uploadName =md5(microtime()).'.'.$fileExt;
        $uploadPath = BASEURL.'images/products/'.$uploadName;
        $dbpath = '/tutorial/images/products/'.$uploadName;
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
        move_uploaded_file($tmpLoc,$uploadPath);

         $insertSql = "INSERT INTO products (`title`,`price`,`list_price`,`brand`,`categories`,`sizes`,`image`,`description`)
        VALUES ('$title','$price','$list_price','$brand','$category','$sizes','$dbpath','$description')";
        if(isset($_GET['edit'])){
          echo "update to database";
          $insertSql = "UPDATE products SET `title` ='$title', `price` ='$price', `list_price` = '$list_price',
          `brand` ='$brand', `categories` = '$category', `sizes` = '$sizes', `image` = '$dbpath', `description` = '$description'
          WHERE id='$edit_id'";

        }
       $db->query($insertSql);
       header('Location: products.php');
      }
    }
      ?>
      <h2 class="text-center"><?=((isset($_GET['edit']))?'Edit ':'Add A New ');?>Product</h2><hr>
    <!-- if edit is clicked set the post option to edit id else set to add product( add=1)-->
      <form action="products.php?<?=((isset($_GET['edit']))?'edit='.$edit_id:'add=1');?>" method="POST" enctype="multipart/form-data">
        <div class="form-group col-md-3">
          <label for="title">Title*:</label>
          <input type="text" name="title" class="form-control" id="title" value="<?=$title?>">
        </div>
        <div class="form-group col-md-3">
          <label for="brand">Brand*:</label>
          <select class= "form-control" id = "brand" name ="brand">
          <option value=""<?=(($brand =='')?'selected':'');?>></option> <!--list all brand in drop menu on default -->
            <?php while($b = mysqli_fetch_assoc($brandQuery)): ?>
              <!-- option is set to brand pulled on edit box we are in edit mode or set to no brand selected
              if we are in add brand in add product mode -->
              <option value="<?=$b['id'];?>"<?=(($brand == $b['id'])?'selected':'');?>><?=$b['brand'];?></option>
            <?php endwhile; ?>

          </select>
       </div>
       <div class="form-group col-md-3">
         <label for ="parent">Parent Category*:</label>
         <select class ="form-control" id="parent" name ="parent">
           <option value=""<?=(($parent == '')?'selected':''); ?>></option>
           <?php while($p = mysqli_fetch_assoc($parentQuery)): ?>
             <option value="<?=$p['id'];?>"<?=(($parent == $p['id'])?'selected':'');?>><?=$p['category'];?></option>
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
         <input type="text" id="price" name="price" class="form-control" value="<?=$price;?>">
       </div>
       <!--List Price label -->
       <div class="form-group col-md-3">
         <label for="list_price">List Price:</label>
         <input type="text" id="list_price" name="list_price" class="form-control" value="<?=$list_price;?>">
       </div>
       <!--Quantity & Sizes label -->
       <div class="form-group col-md-3">
       <label>Quantity & Sizes*:</label>
       <button class="btn btn-default form-control" onclick="jQuery('#sizesModal').modal('toggle');return false">Quantity & Sizes</button>
       </div>
       <div class ="form-group col-md-3">
         <label for="sizes">Sizes & Qty Preview</label>
         <input type="text" class="form-control" name="sizes" id="sizes" value="<?=$sizes;?>" readonly>
       </div>
        <!--photo label -->
        <div class="form-group col-md-6">
          <?php if($saved_image != ''): ?>
            <div class="saved-image">
            <img src="<?=$saved_image;?>" alt="saved image"/><br>
            <a href="products.php?delete_image=1&edit=<?=$edit_id;?>" class="text-danger">Delete Image</a>
          </div>
        <?php else:?>
          <label for="photo">Product Photo:</label>
          <input type="file" name="photo" id="photo" class="form-control">
        <?php endif; ?>
        </div>
         <!--List Price label -->
         <div class="form-group col-md-6">
           <label for="description">description:</label>
           <textarea id="description" name="description"  class="form-control" rows="6"><?=$description;?></textarea>
         </div>
         <!--photo label -->
         <div class= "form-group pull-right">
           <a href="products.php" class="btn btn-default">Cancel</a>
           <input type="submit" value="<?=((isset($_GET['edit']))?'Edit ':'Add ');?> Product" class="btn btn-success">
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
    permission_ungranted('products.php');
  }
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
          <a href ="products.php?archive=<?=$product['id'];?>" class= "btn btn-xs btn-default"><span class="glyphicon glyphicon-off"></span><a/>
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
<?php } include 'includes/footer.php'; ?>

<!--This script calls the get_child_options function in admin footer.php
to enable automatic selected of child category especially in product edit mode
 when the parent category is loaded from database-->
<script>
jQuery('document').ready(function(){
  get_child_options('<?=$category;?>');
});
</script>
