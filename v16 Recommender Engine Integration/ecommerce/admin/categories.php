<?php
  require_once $_SERVER['DOCUMENT_ROOT'].'/ecommerce/core/staff-init.php';
  //check if user is logged in on any of the pages
  if(!is_staff_logged_in()){
    login_error_redirect();
  }
  if(isset($_GET['delete']) && !empty($_GET['delete'])){
    if(check_staff_permission('admin')){
      $delete_id = (int)$_GET['delete'];  //pull the value from the url
      $delete_id = sanitize($delete_id);
      $sql = "SELECT * FROM categories WHERE id = '$delete_id'";
      $result = $db->query($sql);
      $category = mysqli_fetch_assoc($result);
      //if parent category has sub category delete sub categories
        if($category['parent'] == 0){
            $sql = "DELETE FROM categories WHERE parent = '$delete_id'";
            $db->query($sql);
          }
         //delete parent category
          $dsql = "DELETE FROM categories WHERE id = '$delete_id'";
          $db->query($dsql);
          $_SESSION['success_flash'] .= $category['category']. ' successfully Deleted from Category!';
          header('Location: categories');
    }else{
      permission_ungranted('categories');
    }
 }
  include 'includes/head.php';
  include 'includes/navigation.php';
  if (!isset($_SERVER['HTTP_REFERER'])){
      ?><hr><div class="bg-danger">
        <p class="text-center text-danger">
          Error!! That navigation pattern is forbidden!
        </p>
      </div>
      <a href="categories" class="btn btn-lg btn-default">Return</a>
      <?php
      exit();

    }
  $_SESSION['staff_rdrurl'] = $_SERVER['REQUEST_URI'];
  $sql = "SELECT * FROM categories WHERE parent =0";
  $result =$db->query($sql);
  $errors= array();
  $category = '';
  $post_parent ='';
  //Edit CATEGORIES
  if(isset($_GET['edit']) && !empty($_GET['edit'])){
    if(check_staff_permission('editor')){
      $edit_id = (int)$_GET['edit'];
      $edit_id = sanitize($edit_id);
      $edit_sql = "SELECT * FROM categories WHERE id = '$edit_id'";
      $edit_result = $db->query($edit_sql);
      $edit_category = mysqli_fetch_assoc($edit_result);
    }else{
      permission_ungranted('categories');
    }
  }
  //Delete category

 if(isset($_GET['active'])){
     if(check_staff_permission('admin')){
    $id =(int)$_GET['id'];
     $active = sanitize((int)$_GET['active']);
     $sql = "SELECT * FROM categories WHERE id = '$id'";
     $result = $db->query($sql);
     $category = mysqli_fetch_assoc($result);
       if($category['parent'] == 0){
         //if parent category is deactivated then deactivate its child category.
           if($active == 0){
             $sql = "UPDATE categories SET active = '$active' WHERE parent = '$id'";
             $childQuery = $db->query("SELECT * FROM categories WHERE parent = '$id'");
             while($child = mysqli_fetch_assoc($childQuery)){
               $childID = $child['id'];
               $psql = "UPDATE products SET category_activate_flag = $active WHERE categories = '$childID'";
                $db->query($psql);
             }
             $asql = "UPDATE categories SET active = $active WHERE id = '$id'";
             $db->query($sql);
            $db->query($asql);
           }else{
             $asql = "UPDATE categories SET active = $active WHERE id = '$id'";
             $db->query($asql);
           }
           header('Location: categories');
        }else{
          $catID = $category['parent'];
          $result = $db->query("SELECT * FROM categories WHERE id = '$catID'");
          $category = mysqli_fetch_assoc($result);
          //if parent category is inactive refuse to activate child category
          if($category['active'] == 1){
            $asql = "UPDATE categories SET active = '$active' WHERE id = '$id'";
            $psql = "UPDATE products SET category_activate_flag = $active WHERE categories = '$id'";
            $db->query($asql);
            $db->query($psql);
           header('Location: categories');
         }else{
           $errors [].= 'The parent category ['. $category['category'].'] of that child category is inactive. Activate parent category ['.$category['category'].'] first!';
           $display =display_errors($errors); ?>
           <!--Display error on screen by using jquery to plug in the html-->
           <script>
             jQuery('document').ready(function(){
               jQuery('#errors2').html('<?=$display; ?>');
             });
           </script>
           <?php
         }
        }
   }else{
     $message = "Please! You do not have sufficient clearance to put product on sale.";
     permission_ungranted('categories',$message);
   }
 }
  //Process form
  if(isset($_POST) && !empty($_POST)){
      $post_parent =  sanitize(trim($_POST['parent'])); //trim remove white space and sanitize deactivate html code
      $category = sanitize(trim($_POST['category']));
      $sqlform = "SELECT * FROM categories WHERE category = '$category' AND parent = '$post_parent'";
      if(isset($_GET['edit'])){
        $id =$edit_category['id'];
        $sqlform = "SELECT * FROM categories WHERE category = '$category' AND parent = '$post_parent' AND id != '$id'";
      }
      $fresult = $db->query($sqlform);
      $row_count = mysqli_num_rows($fresult);
      if(!check_staff_permission('editor')){
      $errors[].= 'You do not have the clearance to add category!';
      }
      // if category is blank
      if($category ==''){
        $errors[].= 'The category cannot be left blank';
      }
      if($row_count > 0){
        $errors[] .= $category. ' already exists. Please choose a new category.';
      }
      //Display Errors or update Database
      if(!empty($errors)){
        //pass errors into display_errors function in helpers.php to return the error as html
        $display =display_errors($errors); ?>
        <!--Display error on screen by using jquery to plug in the html-->
        <script>
          jQuery('document').ready(function(){
            jQuery('#errors').html('<?=$display; ?>');
          });
        </script>
      <?php }else{
        //if we are editing then update not insert
        if(isset($_GET['edit'])){
          $updatesql = "UPDATE categories SET category = '$category', parent = '$post_parent' WHERE id = '$edit_id'";
          $_SESSION['success_flash'] .= $category. ' successfully updated to Category!';
        }else{
          $updatesql = "INSERT INTO categories (category, parent) VALUES ('$category', '$post_parent')";
          $_SESSION['success_flash'] .= $category. ' successfully added to category!';
        }
        $db->query($updatesql);
        header('Location: categories'); //refresh page
        $url =  "//{$_SERVER['HTTP_HOST']}{$_SERVER['REQUEST_URI']}";
        $escaped_url = htmlspecialchars( $url, ENT_QUOTES, 'UTF-8' );
        $escaped_url = array_shift(explode("?", $escaped_url));
        ?><script>
        var val = " <?php echo $escaped_url ?> ";
          window.location.replace(val);
        </script><?php
        exit();
      }
    }
  //set category box to empty string but if edit is clicked set to edit value
  $category_value ='';
  $parent_value =0;
  if(isset($_GET['edit'])){
    $category_value = $edit_category['category'];
    $parent_value = $edit_category['parent'];
  }else{
    if(isset($_POST) && !isset($_GET['active'])){
      $category_value = $category; //keep category name in box even if it fails
      $parent_value = $post_parent; //if form is submitted set parent to the parent value on the submitted form
    }
  }
 ?>
<p></p>
  <div class="row">
    <div class="box">
      <h2 class = "text-center">CATEGORIES</h2><hr>
      <div class="col-md-4">
       <form class ="form action=categories<?=((isset($_GET['edit']))?'?edit='.$edit_id:'add'); ?>" method="post">
         <p><?=((isset($_GET['edit']))?'Edit': 'Add A');?> Category</p> <!-- set to add category (default) if there is no edit category request -->
         <div id='errors'> </div> <!-- print error just above add a category label-->
         <div class ="form-group">
           <label for="parent">Parent</label>
             <select class="form-control" name="parent" id="parent">
               <option value ="0"<?=(($parent_value == 0)?'selected="selected"':'');?>>PARENT</option>
               <?php while($parent = mysqli_fetch_assoc($result)): ?>
                 <option value ="<?=$parent['id'];?>"<?=(($parent_value == $parent['id'])?' selected="selected"':'');?>><?=$parent['category'];?></option>
               <?php endwhile; ?>
             </select>
           </div>
           <div class="form-group">
             <label for ="category">Category</label>
             <input type="text" class="form-control" id="category" name ="category" value = "<?=$category_value;?>">
           </div>
           <div class="form-group">
             <!--Add or edit category button -->
             <input type="submit" value="<?=((isset($_GET['edit']))?'Edit': 'Add');?> Category" class= "btn btn-success pull-right">
             <?php
               if(isset($_GET['edit'])){
                ?>
                <a href="categories" class="btn btn-default">Cancel</a>
                <?php
               }
             ?>
           </div>
         </form>
       </div>
  </div> <p></p>
    <div class="box">
        <div class="col-md-8">
          <div id='errors2'> </div>
          <table class="table table-bordered table-hover">
          <thead>
            <th>Category</th><th>Parent</th><th>Flag</th><th>Action</th>
          </thead>
          <tbody>
            <?php
            $sql = "SELECT * FROM categories WHERE parent =0";
            $result =$db->query($sql);
            while($parent = mysqli_fetch_assoc($result)):
              $parent_id =(int)$parent['id'];
              $sql2 = "SELECT * FROM categories WHERE parent ='$parent_id'";
              $cresult =$db->query($sql2);
            ?>
             <tr class= "bg-primary">
               <td><?=$parent['category'];?></td>
               <td>Parent</td>
               <td>
                 <a href = "categories?active=<?=(($parent['active']== 0)?'1':'0');?>&id=<?=$parent['id'];?>" class = "btn btn-xs <?=(($parent['active'] == 1)?'btn-success':'btn-default');?> ">
                   <span class = "glyphicon glyphicon-<?=(($parent['active']==1)?'minus':'plus');?>"></span>
                 </a>&nbsp <?=(($parent['active'] == 1)?'Active':'Inactive');?>
                </td>
                <td>
                  <a href="categories?edit=<?=$parent['id'];?>" class="btn btn-info btn-xs"><span class="glyphicon glyphicon-pencil"></span></a>
                  <a href="categories?delete=<?=$parent['id'];?>" class="btn btn-danger btn-xs" onclick="return deleleconfirmP('<?=$parent['category'];?>')"><span class="glyphicon glyphicon-remove-sign"></span></a>
                </td>
             </tr>
             <?php while($child =mysqli_fetch_assoc($cresult)):  ?>
               <tr class= "bg-info">
                 <td><?=$child['category'];?></td>
                 <td><?=$parent['category'];?></td>
                 <td>
                   <a href = "categories?active=<?=(($child['active']== 0)?'1':'0');?>&id=<?=$child['id'];?>" class = "btn btn-xs <?=(($child['active'] == 1)?'btn-success':'btn-default');?> ">
                     <span class = "glyphicon glyphicon-<?=(($child['active']==1)?'minus':'plus');?>"></span>
                   </a>&nbsp <?=(($child['active'] == 1)?'':'');?>
                 <td>
                   <a href="categories?edit=<?=$child['id'];?>" class="btn btn-default btn-xs"><span class="glyphicon glyphicon-pencil"></span></a>
                   <a href="categories?delete=<?=$child['id'];?>" class="btn btn-default btn-xs" onclick="return deleteconfirm('<?=$parent['category'];?>','<?=$child['category'];?>')"><span class="glyphicon glyphicon-remove-sign"></span></a>
                  </td>
                 </td>
               </tr>
             <?php endwhile;?>
           <?php endwhile;?>
          </tbody>
        </table>
    </div></div>
  </div><p></p>
 <?php include 'includes/footer.php' ?>

 <script>
 function deleteconfirm(pcat,ccat){
 var ccat = ccat;
 var pcat = pcat;
 var del=confirm('[ ' + ccat + ' ] child category is about to be deleted from [ '+ pcat +' ] parent category. Do you wish to contnue?');
 if (del==true){
 //   alert ("record deleted")
 }
 return del;
 }

 function deleleconfirmP(pcategory){
 var pcat = pcategory
 var del=confirm('[ ' + pcat + ' ] parent category is about to be deleted! All child category under '+ pcat + '  parent category will also be deleted. Continue?');
 if (del==true){
 //   alert ("record deleted")
 }
 return del;
 }

 </script>
