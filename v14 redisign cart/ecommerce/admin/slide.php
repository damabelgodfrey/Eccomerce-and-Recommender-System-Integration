<?php
require_once $_SERVER['DOCUMENT_ROOT'].'/ecommerce/core/staff-init.php';
//check if user is logged in on any of the pages
if(!is_staff_logged_in()){
  login_error_redirect();
}
if(!check_staff_permission('editor')){
  error_redirect('index','You do not have clearance to view that page');
}
include 'includes/head.php';
include 'includes/navigation.php';
$slide_image ='';
$flag = 0;
$dbpath = '';
//delete a slides
if(isset($_GET['delete'])){
  if(check_staff_permission('admin')){
  $delete_id = sanitize($_GET['delete']);
  $SlideResults= $db->query("SELECT * FROM slide WHERE id='$delete_id'");
  $slideimage = mysqli_fetch_assoc($SlideResults);
  $image_url =$_SERVER['DOCUMENT_ROOT'].$slideimage['image'];
  unlink($image_url);
  $deleteSlideResults= $db->query("DELETE FROM slide WHERE id='$delete_id'");
  $db->query("UPDATE slide SET id =id -1 WHERE id > $delete_id ORDER BY id DESC");
  header('Location: slide');
  }else{
    $message = "Please! You do not have sufficient clearance to delete product.";
    permission_ungranted('slide',$message);
  }
}
// set and unset featured slide
if(isset($_GET['status'])){
  $id =(int)$_GET['id'];
  $status = (int)$_GET['status'];
  $statussql = "UPDATE slide SET status = '$status' WHERE id = '$id'";
  $db->query($statussql);
  header('Location: slide');
}
//set flag for slide to link to a paticular product modal
if(isset($_GET['flag'])){
  $id =(int)$_GET['id'];
  $flag = (int)$_GET['flag'];
  $flagsql = "UPDATE slide SET flag = '$flag' WHERE id = '$id'";
  $db->query($flagsql);
  header('Location: slide');
}

$arrayR[] = array();
$slideQ = $db->query("SELECT * FROM slide WHERE status = 1 ORDER BY id LIMIT 6");
while($row = mysqli_fetch_assoc($slideQ)){
  $arrayR[] =$row['title'].'??$'.$row['caption'].'??$'.$row['image'].'??$'.$row['url'];

}

if(isset($_GET['add']) || isset($_GET['edit'])){
  if(check_staff_permission('editor')){
  $title =((isset($_POST['title']) && $_POST['title'] != '')?sanitize($_POST['title']):'');
  $caption =((isset($_POST['caption']) && $_POST['caption'] != '')?sanitize($_POST['caption']):'');
  $linkUrl =((isset($_POST['url']) && $_POST['url'] != '')?sanitize($_POST['url']):'');

  //$slide_image = ''; // if get is not set
  // store edit id if edit button is clicked
    if(isset($_GET['edit'])){
          $edit_id =(int)$_GET['edit'];
          $EditSlideResults = $db->query("SELECT * FROM slide WHERE id='$edit_id'");
          $slide = mysqli_fetch_assoc($EditSlideResults);
          if(isset($_GET['delete_image'])){
            $image_url =$_SERVER['DOCUMENT_ROOT'].$slide['image'];
            unlink($image_url);
            $db->query("UPDATE slide SET image = '' WHERE id='$edit_id'");
            header('Location: slide?edit='.$edit_id);
          }

          $title = ((isset($_POST['title']) && $_POST['title'] != '')?sanitize($_POST['title']):$slide['title']);

          $caption = ((isset($_POST['caption']) && $_POST['caption'] != '')?sanitize($_POST['caption']):$slide['caption']);
          $linkUrl = ((isset($_POST['url']) && $_POST['url'] != '')?sanitize($_POST['url']):$slide['url']);
          $slide_image = (($slide['image'] != '')?$slide['image']:'');
          $dbpath = $slide_image;
        }

    if($_POST){
      $errors=array();
      $required = array('title','caption','url',); //required field on the add slide date_create_from_format

        if(isset($_GET['edit'])){
          $nameQuery = $db->query("SELECT * FROM slide WHERE title='$title' AND id != $edit_id");
        }else{
          $nameQuery = $db->query("SELECT * FROM slide WHERE title='$title'");
        }
        foreach($required as $field){
          if($_POST[$field] ==''){
            $errors[]= 'All fields with Asterisk are required.';
            $flag = 1;
            break;

          }
        }
        $nameCount = mysqli_num_rows($nameQuery);
        if($nameCount !=0 ){
          $errors[] = 'The slide with that name already exist in database';
          $flag = 1;
        }
      //image property appear as shown bellow
      //array(1) { ["photo"]=> array(5) { ["name"]=> string(16) "examplePhoto.png" ["type"]=> string(9) "image/png" ["tmp_name"]=> string(24) "C:\xampp\tmp\php6EBB.tmp" ["error"]=> int(0) ["size"]=> int(153623) } }
      if(!empty($_FILES)){
        $photo = $_FILES['photo'];
        $name= $photo['name'];
        //$fileName = $nameArray[0];
        $nameArray = explode('.',$name); // explode the photo string sperated by , which shows info properties about the photo
        $fileExt = end(explode('.',$name));
        $mime = explode('/',$photo['type']);
        $mimeType = $mime[0];
        $mineExt = end(explode('/',$photo['type']));
        $tmpLoc = $photo['tmp_name'];
        $fileSize = $photo['size'];
        $allowedImageExt =array('png','jpg','jpeg','gif');
        $uploadName =$title.'.'.$fileExt;
        $uploadPath = BASEURL.'images/slides/'.$uploadName;
        $dbpath = '/ecommerce/images/slides/'.$uploadName;
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
        if(isset($_GET['add'])){
          $id =1;
          //add new slide at top of page
          $db->query("UPDATE slide SET id =id +1 ORDER BY id DESC");
          $insertSql = "INSERT INTO slide (`id`,`title`,`caption`,`image`,`url`)
          VALUES ('$id','$title','$caption','$dbpath','$linkUrl')";
        }
        if(isset($_GET['edit'])){
          $insertSql = "UPDATE slide SET `title` ='$title', `caption` ='$caption', `image` = '$dbpath', `url` = '$linkUrl'
          WHERE id='$edit_id'";
        }
       $db->query($insertSql);
       header('Location: slide');
      }
    }
      ?>
      <h2 class="text-center"><?=((isset($_GET['edit']))?'Edit ':'Add A New ');?>Slide</h2><hr>
    <!-- if edit is clicked set the post option to edit id else set to add slide( add=1)-->
      <form action="slide?<?=((isset($_GET['edit']))?'edit='.$edit_id:'add=1');?>" method="POST" enctype="multipart/form-data">
        <div class="form-group col-md-3">
          <label for="title">Title*:</label>
          <input type="text" name="title" class="form-control" id="title" value="<?=$title?>" placeholder="Enter Unique Title" required>
        </div>

        <!-- caption label -->
       <div class="form-group col-md-3">
         <label for="caption">caption*:</label>
         <input type="text" id="caption" name="caption" class="form-control" value="<?=$caption;?>" placeholder="Enter space for no caption" required>
       </div>
       <!-- label -->
       <div class="form-group col-md-3">
         <label for="url">Link Url*:</label>
         <input type="text" id="url" name="url" class="form-control" value="<?=$linkUrl;?>" placeholder="Enter link url or product name[on flag ID]" required>
       </div>

        <!--photo label -->
        <div class="form-group col-md-6">
          <?php if($slide_image != ''): ?>
            <div class="saved-image">
            <img src="<?=$slide_image;?>" alt="saved image"/><br>
            <a href="slide?delete_image=1&edit=<?=$edit_id;?>" class="text-danger">Delete Image</a>
          </div>
        <?php else:?>
          <label for="photo">slide Photo*:</label>
          <input type="file" name="photo" id="photo" class="form-control" required>
        <?php endif; ?>
        </div>
         <!--photo label -->
         <div class= "form-group pull-right">
           <a href="slide" class="btn btn-default">Cancel</a>
           <input type="submit" value="<?=((isset($_GET['edit']))?'Edit ':'Add ');?> Slide" class="btn btn-success">
         </div><div class="clearfix"></div>
         </div>
      </form>
      <!-- Sizes Modal -->
    <?php
  }else{
    $message = "Please! You do not have sufficient clearance to perform that action.";
    permission_ungranted('slide',$message);
  }
}else{

$slideQ = $db->query("SELECT * FROM slide  ORDER BY id LIMIT 6");

?>
<h2 class="text-center">SLIDES</h2>
<a href="slide?add=1" class ="btn btn-success pull-right" id="add-product-btn">Add Slides</a><div class="clearfix"></div>
<hr>
<table class="table table-bordered table-condensed table-striped">
  <tbody><th>Action</th><th>Title</th><th>Caption</th><th>Link URL/Product</th><th>Flag</th><th>ON/OFF</th></thead>
<tbody>
    <?php while($slide =mysqli_fetch_assoc($slideQ)):?>

    <tr>
        <td>
          <a href ="slide?edit=<?=$slide['id'];?>" class= "btn btn-xs btn-info"><span class="glyphicon glyphicon-pencil"></span><a/>
          <a href ="slide?delete=<?=$slide['id'];?>" class= "btn btn-xs btn-danger " onclick="return deleletconfirm()"><span class="glyphicon glyphicon-remove"></span><a/>
        </td>
      <td><?=$slide['title'];?></td>
      <td><?=$slide['caption'];?></</td> <!--the money function is in helper class to add the dollar sign -->
      <td><?=$slide['url'];?></td>
      <td><a href = "slide?flag=<?=(($slide['flag']== 0)?'1':'0');?>&id=<?=$slide['id'];?>" class = "btn btn-xs btn-default">
        <span class = "glyphicon glyphicon-<?=(($slide['flag']==1)?'minus':'plus');?>"></span>
      </a>&nbsp Link By<?=(($slide['flag'] == 1)?' Product':' Page Url');?></td>
      <td><a href = "slide?status=<?=(($slide['status']== 0)?'1':'0');?>&id=<?=$slide['id'];?>" class = "btn btn-xs btn-default">
        <span class = "glyphicon glyphicon-<?=(($slide['status']==1)?'minus':'plus');?>"></span>
      </a> <?=(($slide['status'] == 1)?'ON':'OFF');?></td>


    </tr>
  <?php endwhile; ?>
</tbody>

</table>
<?php } include 'includes/footer.php'; ?>

<!--This script calls the get_child_options function in admin footer.php
to enable automatic selected of child category especially in slide edit mode
 when the parent category is loaded from database-->
<script>
jQuery('document').ready(function(){
  get_child_options('<?=$category;?>');
});
</script>

<script>
function deleletconfirm(){
var del=confirm("Are you sure you want to delete this product?");
if (del==true){
//   alert ("record deleted")
}
return del;
}
</script>
