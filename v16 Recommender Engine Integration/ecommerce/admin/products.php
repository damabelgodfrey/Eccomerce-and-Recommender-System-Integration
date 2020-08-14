<?php
require_once $_SERVER['DOCUMENT_ROOT'].'/ecommerce/core/staff-init.php';

//check if user is logged in on any of the pages
if(!is_staff_logged_in()){
  login_error_redirect();
}
include 'includes/head1.php';
?>
<!--<script src="https://cloud.tinymce.com/stable/tinymce.min.js"></script>
<script>tinymce.init({ selector:'textarea' });</script>-->
 <?php
include 'includes/navigation1.php';
//include pagination class file
include_once 'includes/Pagination.class.php';
$_SESSION['staff_rdrurl'] = $_SERVER['REQUEST_URI'];
$errors=array();
$saved_image ='';
$flag = 0;
$num_size = 2;
$sizerow = '';
$Prod_sort ='undefined';
$editsizelength ='';
$photoCount =0;
if (isset($_SERVER['HTTP_REFERER'])){
      $_SESSION['one_back'] = $_SERVER['HTTP_REFERER']?: NULL;
      $_SESSION['two_back'] = $_SESSION['one_back'] ?: NULL;
      $path = $_SESSION['one_back'];
      $path2 = $_SESSION['two_back'];
  }else{?>
    <div class="bg-danger">
      <p class="text-center text-danger">
        Error!! That navigation pattern is forbidden!
      </p>
    </div>
    <a href="products" class="btn btn-lg btn-default">Return</a>

    <?php
    exit;
  }
if(isset($_POST['num_size'])){
  $sizerow= sanitize((int)$_POST['num_size']);
}
//delete a products and delete the image url from file
if(isset($_GET['delete'])){
  if(check_staff_permission('admin')){
  $id = sanitize($_GET['delete']);
  $deleteResults= $db->query("SELECT * FROM products WHERE id='$id'");
  $productimage = mysqli_fetch_assoc($deleteResults);
  $imgi = 0;
  $images = explode(',',$productimage['image']);
    foreach($images as $image){
    $image_url =$_SERVER['DOCUMENT_ROOT'].$images[$imgi];
    unlink($image_url);
    $imgi++;
    }
  $db->query("DELETE FROM products WHERE id='$id'");
  $db->query("UPDATE products SET id =id -1 WHERE id > $id ORDER BY id DESC");
  header('Location: products');
  }else{
    $message = "Please! You do not have sufficient clearance to delete product.";
    permission_ungranted('products',$message);
  }
}
if(isset($_GET['reset']) && check_staff_permission('pro')){
  $r_id=sanitize($_GET['reset']);
  $soldReset = "0:0";
  $insertSql = "UPDATE products SET `sold` ='$soldReset'
  WHERE id='$r_id'";
  $db->query($insertSql);
  header('Location:'.$path);
}
if(isset($_GET['archive'])){
  if(check_staff_permission('editor')){
    $p_id=sanitize($_GET['archive']);
      $p_featured = 0; //turn featured off if you archive a product
      $p_sales =0;
      $p_archive =1;
    //instead of deleting the product we simply update it to archive
  //  $p_featuredsql->query("UPDATE products SET deleted =1 AND sales = 0 WHERE id='$p_id'");
    $insertSql = "UPDATE products SET `archive` ='$p_archive', `sales` ='$p_sales', `featured` = '$p_featured'
    WHERE id='$p_id'";
    $db->query($insertSql);
    header('Location:'.$path);
    }else{
      $message = "Please! You do not have sufficient clearance to archive product.";
      permission_ungranted('products',$message);
    }
}
$dbpath = '';
// if add button is pressed display add product section else show added product
if(isset($_GET['add']) || isset($_GET['edit'])){
  if(check_staff_permission('editor')){
  $brandQuery = $db->query("SELECT * FROM brand ORDER BY brand"); //get brand from database
  $parentQuery = $db->query("SELECT * FROM categories WHERE parent = 0 ORDER BY category"); //in database parent column is zero while child is not zero(referencing parent)
  $title =((isset($_POST['title']) && $_POST['title'] != '')?sanitize($_POST['title']):'');
  $brand = ((isset($_POST['brand']) && !empty($_POST['brand']))?sanitize($_POST['brand']):'');
  $parent = ((isset($_POST['parent']) && !empty($_POST['parent']))?sanitize($_POST['parent']):'');
  $category = ((isset($_POST['child']) && !empty($_POST['child']))?sanitize($_POST['child']):'');
  $price =((isset($_POST['price']) && $_POST['price'] != '')?sanitize($_POST['price']):'');
  $list_price =((isset($_POST['list_price']) && $_POST['list_price'] != '')?sanitize($_POST['list_price']):'');
  $description =((isset($_POST['description']) && $_POST['description'] != '')?sanitize($_POST['description']):'');
  $p_keyword =((isset($_POST['p_keyword']) && $_POST['p_keyword'] != '')?sanitize($_POST['p_keyword']):'');
  $sizes =((isset($_POST['sizes']) && $_POST['sizes'] != '')?sanitize($_POST['sizes']):'');
  $sizes =rtrim($sizes, ','); //remove last comma from sizes string
  //$saved_image = ''; // if get is not set
  // store edit id if edit button is clicked
    if(isset($_GET['edit'])){
          $edit_id =(int)$_GET['edit'];
          $EditProductResults = $db->query("SELECT * FROM products WHERE id='$edit_id'");
          $product = mysqli_fetch_assoc($EditProductResults);
          if(isset($_GET['delete_image'])){
            $imgi = (int)$_GET['imgi'] - 1;
            $images = explode(',',$product['image']);
            $image_url =$_SERVER['DOCUMENT_ROOT'].$images[$imgi];
            unlink($image_url);
            unset($images[$imgi]);
            $imageString = implode(',',$images); //turn it back to string
            $db->query("UPDATE products SET image = '{$imageString}' WHERE id='$edit_id'");
            header('Location: products?edit='.$edit_id);
            $url =  "//{$_SERVER['HTTP_HOST']}{$_SERVER['REQUEST_URI']}";
            $escaped_url = htmlspecialchars( $url, ENT_QUOTES, 'UTF-8' );
            $escaped_url = array_shift(explode("?", $escaped_url));
            $escaped_url .='?edit='.$edit_id;
            ?><script>
            var val = " <?php echo $escaped_url ?> ";
              window.location.replace(val);
            </script><?php
            exit();
          }
          if(isset($_GET['delete_all_image'])){
            $imgi = 0;
            $images = explode(',',$product['image']);
              foreach($images as $image){
              $image_url =$_SERVER['DOCUMENT_ROOT'].$images[$imgi];
              unlink($image_url);
              unset($images[$imgi]);
              $imgi++;
              }
              $db->query("UPDATE products SET image = '' WHERE id='$edit_id'");
              header('Location: products?edit='.$edit_id);
              $url =  "//{$_SERVER['HTTP_HOST']}{$_SERVER['REQUEST_URI']}";
              $escaped_url = htmlspecialchars( $url, ENT_QUOTES, 'UTF-8' );
              $escaped_url = array_shift(explode("?", $escaped_url));
              $escaped_url .='?edit='.$edit_id;
              ?><script>
              var val = " <?php echo $escaped_url ?> ";
                window.location.replace(val);
              </script><?php
              exit();

              }
          $category = ((isset($_POST['child']) && $_POST['child'] != '')?sanitize($_POST['child']):$product['categories']);
          $title = ((isset($_POST['title']) && $_POST['title'] != '')?sanitize($_POST['title']):$product['title']);
          $brand = ((isset($_POST['brand']) && $_POST['brand'] != '')?sanitize($_POST['brand']):$product['brand']);
          $parentQ =$db->query("SELECT * FROM categories WHERE id='$category'");
          $parentResult = mysqli_fetch_assoc($parentQ);
          $parent = ((isset($_POST['parent']) && $_POST['parent'] != '')?sanitize($_POST['parent']):$parentResult['parent']);
          $price = ((isset($_POST['price']) && $_POST['price'] != '')?sanitize($_POST['price']):$product['price']);
          $list_price = ((isset($_POST['list_price']))?sanitize($_POST['list_price']):$product['list_price']);
          $description = ((isset($_POST['description']))?sanitize($_POST['description']):$product['description']);
          $p_keyword = ((isset($_POST['p_keyword']))?sanitize($_POST['p_keyword']):$product['p_keyword']);
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
      $pArray = array();
      $qArray =array();
      $tArray = array();

      foreach($sizesArray as $ss){
        $s = explode(':', $ss); //seperate content of array using (;) as delimeter
        $sArray[] = $s[0]; //first element of array is size
        $pArray[] = $s[1]; // price
        $qArray[] = $s[2]; // quantity
        $tArray[] = $s[3]; // threshold
        $editsizelength++;
      }
    }else{$sizesArray = array();}

    if($_POST && !isset($_POST['num_size'])){
      $required = array('title','p_keyword','brand','price','child','sizes'); //required field on the add product date_create_from_format
      $tempLoc =array();
      $allowedImageExt =array('png','jpg','jpeg','gif');
      $uploadPath =array();

      if(isset($_GET['add'])){
        $nameQuery = $db->query("SELECT * FROM products WHERE title='$title'");
        $nameCount = mysqli_num_rows($nameQuery);
        if($nameCount !=0 ){
          $errors[] = 'The product with that name already exist in database';
          $flag = 1;
        }
      }

      foreach($required as $field){
        if($_POST[$field] ==''){
          $errors[]= 'All fields with Asterisk are required.';
          $flag = 1;
          break;
        }
      }

      if($price > $list_price){
        $errors[] = "Normally, current Price should not be greater than List Price.";
      }

      if(isset($_FILES['photo']['name'])){
        $photoCount = count($_FILES['photo']['name']);

      //image property appear as shown bellow
      //array(1) { ["photo"]=> array(5) { ["name"]=> string(16) "examplePhoto.png" ["type"]=> string(9) "image/png" ["tmp_name"]=> string(24) "C:\xampp\tmp\php6EBB.tmp" ["error"]=> int(0) ["size"]=> int(153623) } }
      if($photoCount > 0 && $flag == 0){
        for($i = 0; $i < $photoCount; $i++){
          $name= $_FILES['photo']['name'][$i];
          $nameArray = explode('.',$name);
          //$fileName = $nameArray[0];
          //$fileExt = $nameArray[1];
          //$fileExt = end(explode('.',$name));
          $namestring = explode(".", $name);
          $fileExt = strtolower(array_pop($namestring));
          $fileName = array_shift($namestring);
          $mime = explode('/',$_FILES['photo']['type'][$i]);
          $mimeType = $mime[0];
          //$mineExt = $mime[1];
          $minetype = (explode('/',$_FILES['photo']['type'][$i]));
          $mineExt = strtolower(array_pop($minetype));
          $tmpLoc []= $_FILES['photo']['tmp_name'][$i];
          $fileSize = $_FILES['photo']['size'][$i];
          $radomchar = substr(md5(microtime()),rand(0,26),5);;
          $uploadName =$title.$radomchar.'.'.$fileExt;
          $uploadPath []= BASEURL.'images/products/'.$uploadName;

          if($i != 0){
            $dbpath .= ',';
          }
          $dbpath .= '/ecommerce/images/products/'.$uploadName;
          //if upload is not an image
          if($mimeType != 'image'){
            $errors[] = 'Empty image uploaded or file uploaded is not an image. Upload an image file please.';
          }
          if(!in_array($fileExt, $allowedImageExt)){
            $errors[] = "The photo must be of file extension [png, jpg, jpeg or gif]";
          }
          //check file sizes
          if($fileSize > 15000000){
            $errors[] = "File size must not exceed 15mb";
          }

          if($fileExt != $mineExt && ($mineExt == 'jpeg' && $fileExt != 'jpg')){
            $errors[] ='File extention does not match the file';
          }
        }
      }
    }

      if(!empty($errors)){
        $flag = 0;
        echo display_errors($errors);
      }else{
        if($photoCount > 0) {
        //upload file and insert into database
          for($i = 0; $i<$photoCount; $i++){
             move_uploaded_file($tmpLoc[$i],$uploadPath[$i]);
           }
       }
          if(isset($_GET['add'])){
            $qtyOrdered = "0:0";
           $insertSql = "INSERT INTO products (`title`,`price`,`list_price`,`brand`,`categories`,`sizes`,`image`,`description`,`p_keyword`,`sold`)
            VALUES ('$title','$price','$list_price','$brand','$category','$sizes','$dbpath','$description','$p_keyword','$qtyOrdered')";
           $d_action = 'Update';
<<<<<<< HEAD
=======
           $db->query($insertSql);
>>>>>>> 00946282fd0ced214a37681e144e38779b687dd4
           ?>
           <div class="alert alert-success" role="alert">
           <h2>Thank you!</h2> Product added Successfully.
           </div><?php
             header('Location: products');
             if ($db->query($insertSql) === TRUE) {
              $last_id = $db->insert_id;
              ?><p></p>
              <div class="box">
              <div class="col-md-6">
                <a href="products" class="btn btn-block btn-primary btn-large" >Return to Product page</a>
              </div>
              <div class="col-md-6">
                <a href="products?edit=<?=$last_id;?>" class="btn btn-block btn-primary btn-large" >View just added product</a>
              <div>
              </div>
              <?php
              } else {
              echo "Error adding product to database";
              exit();
              }
          ?>

          <?php
            exit();
        }
        if(isset($_GET['edit'])){
          $insertSql = "UPDATE products SET `title` ='$title', `price` ='$price', `list_price` = '$list_price',
          `brand` ='$brand', `categories` = '$category', `sizes` = '$sizes', `image` = '$dbpath',
          `description` = '$description', `p_keyword` = '$p_keyword',`defective_product` = '0'
          WHERE id='$edit_id'";
          $d_action = 'Adding Product';
          $db->query($insertSql);
          ?>
          <div class="alert alert-success" role="alert">
          <h2>Thank you!</h2> Product Updated Successfully.
          </div><?php
            header('Location: products');
            ?>
            <a href="products" class="btn btn-block btn-primary btn-large" >Return to Product page</a>
            <?php
              exit();
        }

      }
    }
      ?>
  <div class="container-fluid">
    <div class="box">
      <h2 class="text-center"><?=((isset($_GET['edit']))?'Edit ':'Add A New ');?>Product</h2><hr>
      <span id="modal_errors" class="bg-danger"></span>
      <form action="" method="post" id="num_size_form" name="num_size_form">
        <div class="input-group">
         <span class="input-group-addon" id="productsortbar"><?php echo isset($_POST["num_size"]) ? htmlentities($_POST["num_size"]) : $Prod_sort; ?>
         <input type="hidden" name="num_size" id="num_size" value="" class= "form-control">
          <select name="sizerow" id="sizerow" class="">
            <option value="">Choose No Size</option>
            <?php $size_counts =[1,2,3,4,5,6,7,8,9,10,11,12];
            foreach ($size_counts as $sizecount) {
              $numrow = explode(',', $sizecount);
              $sizerowarray = $numrow[0];
              echo '<option value="'.$sizerowarray.'" data-sizerow="'.$sizerowarray.'".>'.$sizerowarray.'</option>';
            }?>
          </select>
        </span>
        </div>
      </form>
      </div>
    <!-- if edit is clicked set the post option to edit id else set to add product( add=1)-->
    <div class="box">
      <form action="products?<?=((isset($_GET['edit']))?'edit='.$edit_id:'add=1');?>" method="POST" enctype="multipart/form-data">
        <div class="form-group col-md-3">
          <label for="title">Title*:</label>
          <input type="text" name="title" class="form-control" id="title" value="<?=$title?>" maxlength="20" placeholder="Enter name of product" required>
        </div>
        <div class="form-group col-md-3">
          <label for="brand">Brand*:</label>
          <select class= "form-control sizerowcheck" id = "mybrand" name ="brand" >
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
         <select class ="form-control sizerowcheck" id="parent" name ="parent" >
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
         <input type="number" pattern="![^0-9]" id="price" name="price" class="form-control" value="<?=$price;?>" placeholder="Enter currect price" required>
       </div>
       <!--List Price label -->
       <div class="form-group col-md-3">
         <label for="list_price">List Price:</label>
         <input type="number" id="list_price" name="list_price" class="form-control" value="<?=$list_price;?>" placeholder="Enter list price" required>
       </div>
       <!--Quantity & Sizes label -->
       <div class="form-group col-md-3">
       <label>Sizes Prices Quantity  & Threshold*:</label>
<<<<<<< HEAD
       <button class="btn btn-default form-control" onclick="jQuery('#sizesModal').modal('toggle');return false">Enter Size Price..</button>
=======
       <button class="btn btn-default form-control" onclick="jQuery('#sizesModal').modal('toggle');return false">Sizes, Prices & Quantity</button>
>>>>>>> 00946282fd0ced214a37681e144e38779b687dd4
       </div>
       <div class ="form-group col-md-3">
         <label for="sizes">Sizes Prices Qty & Threshold Preview</label>
         <input type="text" class="form-control" name="sizes" id="sizes" value="<?=$sizes;?>" readonly>
       </div>
        <!--photo label -->
        <div class="form-group col-md-6">
          <?php if($saved_image != ''): ?>
            <?php
             $imgi = 1;
             $images = explode(',',$saved_image); ?>
             <a href="products?delete_all_image=1&edit=<?=$edit_id;?>" class="text-danger"><strong>Delete All Images</strong></a><hr>
<<<<<<< HEAD

             <div class="fotorama">
               <?php foreach($images as $image) : ?>
=======
             <?php foreach($images as $image) : ?>
>>>>>>> 00946282fd0ced214a37681e144e38779b687dd4
                <div class="saved-image container col-md-3">
                <img src="<?=$image;?>" alt="saved image"/><br><br>
                <a href="products?delete_image=1&edit=<?=$edit_id;?>&imgi=<?=$imgi;?>" class="text-danger">Delete Image</a>
                </div>
               <?php
               $imgi++;
               endforeach; ?>
<<<<<<< HEAD
               </div>
=======
>>>>>>> 00946282fd0ced214a37681e144e38779b687dd4
        <?php else:?>
          <label for="photo">Product Photo:</label>
          <input type="file" name="photo[]" id="photo" class="form-control" multiple required>
        <?php endif; ?>
        </div>
        <div class="form-group col-md-6">
          <label for="p_keyword">Keyword*:</label>
          <input type="text" name="p_keyword" class="form-control" id="p_keyword" value="<?=$p_keyword?>" placeholder="Enter keyword to enable product search" required>
        </div>
        <div class="form-group col-md-6">
          <label for="description">Product Description:</label>
          <textarea id="description" name="description"  class="form-control" rows="6"><?=$description;?></textarea>
        </div><div></div>
        <div class= "form-group col-md-6">
          <?php   if(!empty($errors)){
              ?><div>
              <?php echo display_errors($errors); ?>
              </div><?php
            } ?>
          <div class= "form-group col-md-6">
            <input type="submit" value="<?=((isset($_GET['edit']))?'Edit ':'Add ');?> Product" class="btn btn-lg btn-success form-control submitbtn">

          </div>
            <div class= "form-group col-md-6">
              <a href="products" class="btn btn-lg btn-default form-control">Cancel</a>
            </div>
        </div>
      </form>
    </div>
  </div><p></p>
      <!-- Sizes Modal -->
<<<<<<< HEAD
          <div class="modal fade details-1" id="sizesModal" tabindex="-1" role="dialog" aria-labelledby="sizesModalLabel" aria-hidden="true" data-backdrop="static" data-keyboard="false">
=======
      <div class="modal fade" id="sizesModal" tabindex="-1" role="dialog" aria-labelledby="sizesModalLabel">
        <div class="modal-dialog modal-lg" role="document">
          <div class="modal-content">
>>>>>>> 00946282fd0ced214a37681e144e38779b687dd4
            <div class="modal-header">
              <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
              <h4 class="modal-title" id="sizesModalLabel">Size, Price & Quantity</h4>
            </div>
            <div class="modal-body">
              <div class="container-fluid">
<<<<<<< HEAD
              <?php
              $sizerowVer = (isset($_POST['num_size'])?$sizerow:$editsizelength);
              for($i=1; $i<=$sizerowVer; $i++): ?>
              <div class="Box">
              <div class="form-group col-sm-3">
                <label for="size<?=$i;?>">Size:</label>
                <input type="text" name="size<?=$i;?>" id="size<?=$i;?>" value="<?=((!empty($sArray[$i-1]))?$sArray[$i-1]:'');?>"  class= "form-control">
              </div>
              <div class="form-group col-sm-3">
                <label for="price<?=$i;?>">Price:</label>
                <input type="number" name="price<?=$i;?>" id="price<?=$i;?>" value="<?=((!empty($pArray[$i-1]))?$pArray[$i-1]:'');?>" min="0" class= "form-control">
              </div>
              <div class="form-group col-sm-3">
                <label for="qty<?=$i;?>">Quantity:</label>
                <input type="number" name="qty<?=$i;?>" id="qty<?=$i;?>" value="<?=((!empty($qArray[$i-1]))?$qArray[$i-1]:'');?>" min="0" class= "form-control">
              </div>
              <div class="form-group col-sm-3">
                <label for="threshold<?=$i;?>">Threshold:</label>
                <input type="number" name="threshold<?=$i;?>" id="threshold<?=$i;?>" value="<?=((!empty($tArray[$i-1]))?$tArray[$i-1]:'');?>" min="0" class= "form-control">
              </div>
            </div><br>
              <?php endfor; ?>
              <span class="modal_errors" class="bg-danger"></span>
=======
               <span id="modal_errors" class="bg-danger"></span>
              <?php
              $sizerowVer = (isset($_POST['num_size'])?$sizerow:$editsizelength);
              for($i=1; $i<=$sizerowVer; $i++): ?>
              <div class="form-group col-md-3">
                <label for="size<?=$i;?>">Size:</label>
                <input type="text" name="size<?=$i;?>" id="size<?=$i;?>" value="<?=((!empty($sArray[$i-1]))?$sArray[$i-1]:'');?>"  class= "form-control">
              </div>
              <div class="form-group col-md-3">
                <label for="price<?=$i;?>">Price:</label>
                <input type="number" name="price<?=$i;?>" id="price<?=$i;?>" value="<?=((!empty($pArray[$i-1]))?$pArray[$i-1]:'');?>" min="0" class= "form-control">
              </div>
              <div class="form-group col-md-3">
                <label for="qty<?=$i;?>">Quantity:</label>
                <input type="number" name="qty<?=$i;?>" id="qty<?=$i;?>" value="<?=((!empty($qArray[$i-1]))?$qArray[$i-1]:'');?>" min="0" class= "form-control">
              </div>
              <div class="form-group col-md-3">
                <label for="threshold<?=$i;?>">Threshold:</label>
                <input type="number" name="threshold<?=$i;?>" id="threshold<?=$i;?>" value="<?=((!empty($tArray[$i-1]))?$tArray[$i-1]:'');?>" min="0" class= "form-control">
              </div>
              <?php endfor; ?>
>>>>>>> 00946282fd0ced214a37681e144e38779b687dd4
            </div>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
              <!--Onclick fires a function updateSizes() in admin/footer -->
              <button type="button" class="btn btn-primary modalbtn" onclick="updateSizes();jQuery('#sizesModal').modal('toggle');return false;">Save changes</button>
            </div>
          </div>
<<<<<<< HEAD
=======
        </div>
      </div>
>>>>>>> 00946282fd0ced214a37681e144e38779b687dd4
    <?php
  }else{
    $message = "Please! You do not have sufficient clearance to perform that action.";
    permission_ungranted('products',$message);
  }
}else{
  // set and unset featured product
  if(isset($_GET['featured'])){
    if(check_staff_permission('editor')){
      $id =(int)$_GET['id'];
      $featured = (int)$_GET['featured'];
      $featuredsql = "UPDATE products SET featured = '$featured' WHERE id = '$id'";
      $db->query($featuredsql);
      header('Location:'.$path);
    }else{
      $message = "Please! You do not have sufficient clearance to feature a product.";
      permission_ungranted('products',$message);
    }

  }

  if(isset($_GET['sales'])){
      if(check_staff_permission('admin')){$id =(int)$_GET['id'];
      $sales = (int)$_GET['sales'];
      $salessql = "UPDATE products SET sales = '$sales' WHERE id = '$id'";
      $db->query($salessql);
      header('Location:'.$path);
    }else{
      $message = "Please! You do not have sufficient clearance to put product on sale.";
      permission_ungranted('products',$message);
    }

  }

  $limit = 10;
  $offset = sanitize(!empty($_GET['page'])?(($_GET['page']-1)*$limit):0);
if(isset($_POST['searchProduct']) && !empty($_POST['searchProduct'])) {
  $search = sanitize($_POST['searchProduct']);
  $query1 = $db->query("SELECT * FROM products WHERE (title LIKE '%".$search."%' OR description LIKE '%".$search."%'OR p_keyword LIKE '%".$search."%') AND archive = 0");
  $rowCount = mysqli_num_rows($query1);
  $limit =$rowCount; //ignore pagination by setting limit to the returned rows
  $query = $db->query("SELECT * FROM products WHERE (title LIKE '%".$search."%' OR description LIKE '%".$search."%'OR p_keyword LIKE '%".$search."%') AND archive = 0 LIMIT $offset,$limit");
    if(is_null($query) || $rowCount ==0) {
      $errors[] = "The search item returns no result";
        if(!empty($errors)){
          echo display_errors($errors);
        }
      }
}else{
  $queryNum = $db->query(sanitize("SELECT COUNT(*) as postNum FROM products WHERE archive= 0"));
  $resultNum = $queryNum->fetch_assoc();
  $rowCount = $resultNum['postNum'];

    if(isset($_POST['sort_type'])){
      $Prod_sort= sanitize($_POST['sort_type']);
      if($Prod_sort =='Quantity Sold High'){
        $query = $db->query("SELECT *, CAST(SUBSTRING_INDEX(`sold`, ':', 1) AS UNSIGNED) AS `first_part` FROM `products` ORDER BY `first_part` DESC");
      }else if($Prod_sort =='Quantity Sold Low'){
        $query = $db->query("SELECT *, CAST(SUBSTRING_INDEX(`sold`, ':', 1) AS UNSIGNED) AS `first_part` FROM `products` ORDER BY `first_part` ASC");
      }else if($Prod_sort =='Highest Price Total'){
        $query = $db->query("SELECT *, CAST(SUBSTRING_INDEX(`sold`, ':', -1) AS UNSIGNED) AS `second_part` FROM `products` ORDER BY `second_part` DESC");
      }else if($Prod_sort =='Product Name'){
        $query = $db->query("SELECT * FROM `products` WHERE archive = 0 ORDER BY `products`.`title` ASC ");
      }else if($Prod_sort =='Product Price'){
        $query = $db->query("SELECT * FROM `products` WHERE archive = 0 ORDER BY `products`.`price` DESC ");
      }else if($Prod_sort =='Recently Added'){
        $query = $db->query("SELECT * FROM `products` WHERE archive = 0 ORDER BY `products`.`id` DESC");
      }else if($Prod_sort =='Sales'){
        $query = $db->query("SELECT * FROM `products` WHERE archive = 0 ORDER BY `products`.`sales` DESC");
      }else if($Prod_sort =='Featured'){
        $query = $db->query("SELECT * FROM `products` WHERE archive = 0 ORDER BY `products`.`featured` DESC");
      }else{
        $query = $db->query("SELECT * FROM products WHERE archive = 0  ORDER BY `products`.`defective_product` DESC LIMIT $offset,$limit");
      }
  }else{
     $query = $db->query("SELECT * FROM products WHERE archive = 0  ORDER BY `products`.`defective_product` DESC LIMIT $offset,$limit");

  }
}

$pagConfig = array(
<<<<<<< HEAD
    'baseURL'=>'http://localhost:81/ecommerce/admin/products',
=======
    'baseURL'=>'http://istore.epizy.com/ecommerce/admin/products',
>>>>>>> 00946282fd0ced214a37681e144e38779b687dd4
    'totalRows'=>$rowCount,
    'perPage'=>$limit
);
$pagination =  new Pagination($pagConfig);

?>
<hr>
<div class="box">
<div class="panel panel-default">
<div class="panel-heading text-center">
  <div class="search-container form-group">
    <form action="products" method="post">
      <div class="col-xs-4 pull-left">
        <input type="text" class="pull-left form-control" placeholder="Input Product to Search.." name="searchProduct" required>
      </div>
      <div class="col-xs-2 pull-left">
        <button type="submit" class=" pull-left btn btn btn-md btn-default"><span class="glyphicon glyphicon-search"></span> Search</button>

      </div>
    </form>
  </div>
  <div class="text-center col-xs-4 pull-right">
    <h3><a href="products?add=1" class ="btn btn-lg btn-success pull-right form-control" id="add-product-btn">Add Product</a></h3>
  </div><br><br>
  <form action="" method="post" id="sort_form" name="sort_form">
    <div class="input-group col-xs-12">
     <span class="input-group-addon" id="productsortbar"><?= ((isset($_POST["sort_type"]))?sanitize(($_POST["sort_type"])):$Prod_sort); ?>
     <input type="hidden" name="sort_type" id="sort_type" value="" class= "form-control">
      <select name="sortchoice" id="sortchoice" class="">
        <option value="">Choose sort Type</option>
        <?php $sort_counts =['Recently Added','Product Name','Product Price','Sales','Featured','Quantity Sold High','Quantity Sold Low','Highest Price Total'];
        foreach ($sort_counts as $sort) {
          $sortType = explode(',', $sort);
          $sortTypearray = $sortType[0];
          echo '<option value="'.$sortTypearray.'" data-sortchoice="'.$sortTypearray.'".>'.$sortTypearray.'</option>';
        }?>
      </select>

    </span>
    </div>
  </form>
</div><p></p>
<div class="box">
  <h3 class="text-center">⇩PRODUCTS TABLE⇩</h3>
  <div class="panel-body">
    <table class="table table-bordered table-condensed table-striped table-hover">
      <thead><th>Action</th><th>Product</th><th>Price</th><th>Category</th><th>Featured</th><th>Sales</th>
        <th>
          <div class="input-group">
           <span class="input-group-addon" id="">Sold [Qty & Price]
           </span>
          </div>
      </th>
    </thead>
    <tbody>
      <?php
      if($query->num_rows > 0){ ?>
          <div class="posts_list">
      <?php while($product = $query->fetch_assoc()):
        $defectiveflag = 0;
        $sold = $product['sold'];
        $sold = explode(':',$sold);
        $soldP = $sold[0];
        $soldQty = $sold[1];
        $childID = $product['categories'];
        $category_sql = "SELECT * FROM categories WHERE id = '$childID'";
        $result = $db->query($category_sql);
        $child = mysqli_fetch_assoc($result);
        $parentID = $child['parent'];
        $parent_sql = "SELECT * FROM categories WHERE id = '$parentID'";
        $parent_result =$db->query($parent_sql);
        $parent = mysqli_fetch_assoc($parent_result);
        $category = $parent['category'].'-'.$child['category'];
        $sizes = sizesToArray($product['sizes']);
      foreach($sizes as $size){
            if($size['size'] == ''|| $size['price']==''|| $size['quantity'] == ''|| (int)$size['quantity'] < 0){
              $defectiveflag = 1;
            }
          }
        if($defectiveflag==1 || $parent['category'] == ''|| $child['category'] == ''|| $product['title']==''|| $product['price']==''|| $product['list_price']==''){
          $id= $product['id'];
          $defectiveflag = 1;
          $defect_sql = "UPDATE products SET defective_product= 1 WHERE id = '$id'";
          $defect_result =$db->query($defect_sql);
        }
      ?>
        <tr <?=($product['defective_product'] == 1)? ' class="danger"':''?>>
            <td>
              <a href ="products?edit=<?=$product['id'];?>" class= "btn btn-info btn-xs"><span <?=($product['defective_product'] == 0)? 'class="glyphicon glyphicon-pencil"':''?> ></span><?=($product['defective_product'] == 1)? 'E':''?><a/>
              <a href ="products?delete=<?=$product['id'];?>" class= "btn btn-danger btn-xs" onclick="return deleletconfirm()"><span class="glyphicon glyphicon-remove"></span><a/>
              <a href ="products?archive=<?=$product['id'];?>" class= "btn btn-xs btn-warning" onclick="return archiveconfirm()"><span class="glyphicon glyphicon-off"></span><a/>
          </td>
          <td><?=$product['title'];?></td>
          <td><?=money($product['price']);?></</td> <!--the money function is in helper class to add the dollar sign -->
          <td>
            <?=$category;?>
          </td>
          <td><a type="button" href = "products?featured=<?=(($product['featured']== 0)?'1':'0');?>&id=<?=$product['id'];?>" class = "btn btn-sm <?=(($product['featured'] == 1)?'btn-success':'btn-default');?> ">
            <span class = "glyphicon glyphicon-<?=(($product['featured']==1)?'minus':'plus');?>"></span>
          </a>&nbsp <?=(($product['featured'] == 1)?'Featured':'');?></td>

          <td><a href = "products?sales=<?=(($product['sales']== 0)?'1':'0');?>&id=<?=$product['id'];?>" class = "btn btn-sm <?=(($product['sales'] == 1)?'btn-success':'btn-default');?> ">
            <span class = "glyphicon glyphicon-<?=(($product['sales']==1)?'minus':'plus');?>"></span>
          </a>&nbsp <?=(($product['sales'] == 1)?'Sales':'');?></td>
          <td>

            <div class="input-group">
            <?php if(check_staff_permission('pro')){ ?>
            <span class="input-group-addon" id=""><a href ="products?reset=<?=$product['id'];?>" class= "btn btn-xs btn-warning" onclick="return resetconfirm()"><span  class="glyphicon glyphicon-refresh"></span><a/></span>
            <input type="button" name="sold" id="sold" value="<?=$soldP;?>" class= "form-control" >
            <input type="button" name="sold" id="sold" value="<?=money((int)$soldQty);?>" class= "form-control" >
          <?php }else{ ?>
             <span class="input-group-addon" id=""><?=$soldP;?></span>
             <input type="button" name="sold" id="sold" value="<?=money((int)$soldQty);?>" class= "form-control">
           <?php } ?>
            </div>
           <td>
        </tr>
      <?php endwhile;} ?>

    </tbody>

    </table>
    </div>
    <?php if(!isset($_POST['sort_type'])){
    ?>
  </div><p></p>
   <div class="panel-footer"><?php  echo $pagination->createLinks(); }?></div>
 </div>
</div><p></p>
<?php } include 'includes/footer1.php'; ?>

<!--This script calls the get_child_options function in admin footer.php
to enable automatic selected of child category especially in product edit mode
 when the parent category is loaded from database-->
<script>

jQuery('#sort_form').change(function(){
  var sortchoice = jQuery('#sortchoice option:selected').data("sortchoice");
  jQuery("#sort_type").val(sortchoice);
  jQuery( "#sort_form" ).submit();
  return false;

});

//update the nmber of size input row
  jQuery('#num_size_form').change(function(){
    var sizerow = jQuery('#sizerow option:selected').data("sizerow");
    jQuery("#num_size").val(sizerow);
    jQuery( "#num_size_form" ).submit();
    return false;

  });

jQuery('document').ready(function(){
  get_child_options('<?=$category;?>');
});

<<<<<<< HEAD
// check the number of size rows is chosen first
  jQuery('#title').change(function(){
    var row = '<?php echo $sizerowVer; ?>';
    if(row == ''){
      var error = '';
      $('.sizerowcheck').prop('disabled', true);
      error += '<p class="text-danger text-center">Plz choose the number of sizes for this product first!</p>';
      jQuery('#modal_errors').html(error);
      return;
    }else{
      $('.sizerowcheck').prop('disabled', false);
      return;
    }

  });


//create and update number of rows to input product size.
  function updateSizes(){
    var sizeString = '';
    var error = '';
    var row = '<?php echo $sizerowVer; ?>';
    jQuery('#modal_errors').html("");
      jQuery('.modal_errors').html("");
    for(var i=1;i<=row;i++){
      //run this if statement if the size string is not empty
      if(jQuery('#size'+i).val() !='' && jQuery('#price'+i).val() !=''&& jQuery('#qty'+i).val() !='' && jQuery('#threshold'+i).val() !=''){ //in javascript + is concatenate and period in php
        sizeString += jQuery('#size' +i).val()+':'+jQuery('#price' +i).val()+':'+jQuery('#qty'+i).val()+':'+jQuery('#threshold'+i).val()+',';
        $('.submitbtn').prop('disabled', false);
      }else{
        error += '<p class="text-danger text-center">Plz fill out all the rows. To remove unwanted rows go back and choose number of size rows needed!</p>';
          jQuery('#modal_errors').html(error);
          jQuery('.modal_errors').html(error);
          $('.submitbtn').prop('disabled', true);
          exit();
          return;
    }

    }
    if(typeof row === 'undefined'){
      row = 0;
      alert("Error! Number of row is not choosen");
    }
    jQuery('#sizes').val(sizeString);
  }
=======
>>>>>>> 00946282fd0ced214a37681e144e38779b687dd4

function deleletconfirm(){
  var del=confirm("Are you sure you want to delete this product?");
    if (del==true){
    //   alert ("record deleted")
    }
  return del;
}

function archiveconfirm(){
  var arc=confirm("Are you sure you want to archive this product?");
  if (arc==true){
  //   alert ("record deleted")
  }
  return del;
}
function resetconfirm(){
  var arc=confirm("Are you sure you want to reset this product quantity and amount sold?");
  if (arc==true){
  //   alert ("record deleted")
  }
  return del;
}

;(function($){

  /**
   * Store scroll position for and set it after reload
   *
   * @return {boolean} [loacalStorage is available]
   */
  $.fn.scrollPosReaload = function(){
      if (localStorage) {
          var posReader = localStorage["posStorage"];
          if (posReader) {
              $(window).scrollTop(posReader);
              localStorage.removeItem("posStorage");
          }
          $(this).click(function(e) {
              localStorage["posStorage"] = $(window).scrollTop();
          });

          return true;
      }

      return false;
  }

  /* ================================================== */

  $(document).ready(function() {
      // Feel free to set it for any element who trigger the reload
     $('select').scrollPosReaload();
     $('input').scrollPosReaload();
     $('button').scrollPosReaload();

  });

}(jQuery));

</script>
