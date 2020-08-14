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
include_once $_SERVER['DOCUMENT_ROOT'].'/ecommerce/admin/includes/Pagination.class.php';
$_SESSION['staff_rdrurl'] = $_SERVER['REQUEST_URI'];
if (!isset($_SERVER['HTTP_REFERER'])){?>
  <div class="bg-danger">
    <p class="text-center text-danger">
      Error!! That navigation pattern is forbidden!
    </p>
  </div>
  <?php
  exit;
  }
$errors=array();
$proflag = 'false';
//delete a user
if(isset($_GET['delete'])){
  $delete_id = sanitize($_GET['delete']);
  $delUserResults = $db->query("SELECT * FROM staffs WHERE id = '$delete_id'");
  $userP = mysqli_fetch_assoc($delUserResults);
  $Dpermissions = explode(',', $userP['permissions']); //check user data permissions
  if(check_staff_permission('pro') && !in_array('pro',$Dpermissions,true)){
    $db->query("DELETE FROM staffs WHERE id = '$delete_id'");
  }else{
    if(check_staff_permission('admin')){
      //Prevent pro user from being deleted.
        if(in_array('pro',$Dpermissions,true) || in_array('admin',$Dpermissions,true)){
          //$message = "Please! You do not have sufficient clearance to delete this staff.";
        //permission_ungranted('staff_account',$message);
        ?><div class="alert alert-danger">
      <strong>Error!</strong> Please! You do not have sufficient clearance to delete this staff.
      </div><?php
        }else{
        $db->query("DELETE FROM staffs WHERE id = '$delete_id'");
        $_SESSION['success_flash'] .= $userP['full_name']. ' has been successfully deleted.';
        succes_redirect('staff_account',$message);
        }
    }
  }
}
if(isset($_GET['delete_photo'])){
  if(check_staff_permission('admin')){
  $id = sanitize($_GET['delete_photo']);
  $QResults= $db->query("SELECT * FROM staffs WHERE id='$id'");
  $photoimage = mysqli_fetch_assoc($QResults);
  $photo_url =$_SERVER['DOCUMENT_ROOT'].$photoimage['photo'];
  unlink($photo_url);
  $db->query("UPDATE staffs SET photo = '' WHERE id = '$id'");
  $_SESSION['success_flash'] = ' staff photo deleted!';
  redirect('staff_account?edit='.$id.'');
  }else{
    $message = "Please! You do not have sufficient clearance to delete staff photo.";
    permission_ungranted('staff_account',$message);
  }
}

if(isset($_GET['add']) || isset($_GET['edit'])){
  $PermissionQuery = $db->query("SELECT * FROM permissions");
  $RankQuery = $db->query("SELECT * FROM ranks");
  $username = ((isset($_POST['username']))?sanitize($_POST['username']):'');
  $name = ((isset($_POST['name']))?sanitize($_POST['name']):'');
  $phone = ((isset($_POST['phone']))?sanitize($_POST['phone']):'');
  $email = ((isset($_POST['email']))?sanitize($_POST['email']):'');
  $password = ((isset($_POST['password']))?sanitize($_POST['password']):'');
  $confirm = ((isset($_POST['confirm']))?sanitize($_POST['confirm']):'');
  $photo = ((isset($_POST['photo']))?sanitize($_POST['photo']):'');
  $photopath = $photo;
  $permissions = ((isset($_POST['permissions']))?sanitize($_POST['permissions']):'');
  $permissions1 = '';
  $ranks = ((isset($_POST['rank']))?sanitize($_POST['rank']):'');
  $ranks1 = '';
  if(isset($_GET['edit'])){
        $edit_id =(int)$_GET['edit'];
        $EditUserResults = $db->query("SELECT * FROM staffs WHERE id='$edit_id'");
        $user = mysqli_fetch_assoc($EditUserResults);
        $Edit_permissions = explode(',', $user['permissions']);
        $userid = $user['id'];
        if(check_staff_permission('pro') && !in_array('pro',$Edit_permissions,true)){ // pro can edit all but not one with pro.
            $proflag = 'true';
        }
        //pro user cannot be edited and an admin cannot edit a pro and an admin.
        if($proflag == 'false' && check_staff_permission('admin') && ((in_array('pro',$Edit_permissions,true) ||  in_array('admin',$Edit_permissions,true)))){
          $message = "Please! You do not have sufficient clearance to edit this staff.";
        permission_ungranted('staff_account',$message);
        }else{
        $username1 = ((isset($_POST['username1']) && $_POST['username1'] != '')?sanitize($_POST['username1']):$user['username']);
        $name1 = ((isset($_POST['name']) && $_POST['name'] != '')?sanitize($_POST['name']):$user['full_name']);
        $phone1 = ((isset($_POST['phone']) && $_POST['phone'] != '')?sanitize($_POST['phone']):$user['phone']);
        $email1 = ((isset($_POST['email']) && $_POST['email'] != '')?sanitize($_POST['email']):$user['email']);
        $photo = ((isset($_POST['photo']) && $_POST['photo'] != '')?sanitize($_POST['photo']):$user['photo']);
        $photopath = $photo;
        $last_login = ((isset($_POST['last_login']) && $_POST['last_login'] != '')?sanitize($_POST['last_login']):$user['last_login']);
        $permissions1 = ((isset($_POST['permissions']) && $_POST['permissions'] != '')?sanitize($_POST['permissions']):$user['permissions']);
        $ranks1 = ((isset($_POST['rank']) && $_POST['rank'] != '')?sanitize($_POST['rank']):$user['rank']);
        $password = $user['password'];
        $confirm = $user['password'];
      }
  }

  if($_POST){
    if(isset($_GET['edit'])){
      $required = array('username','name', 'phone','email', 'permissions','last_login');
      $emailQuery = $db->query("SELECT * FROM staffs WHERE email='$email' AND id != $edit_id");
    }else{
      $required = array('username','name', 'phone','email', 'permissions','password', 'confirm');
      $emailQuery = $db->query("SELECT * FROM staffs WHERE email='$email'");
    }

    foreach($required as $f){
      if(empty($_POST[$f])){
        $errors[]="You must fill all fields.";
        break;
      }
    }
    $emailCount = mysqli_num_rows($emailQuery);
    if($emailCount !=0){
      $errors[] = 'That email already exist with a different user';
    }

    if (!is_accept_phone_no($phone)){
    $errors[] = 'Phone number must have 234 extension and maximun of 11 figures. e.g 08030342243';
    }
    if($password != $confirm){
      $errors[] = 'Your password do not match.';
    }


    if (!is_accept_password($password)){
    $errors[] = ' Password must be atleast 6 characters( and contain at least one digit, one upper case letter, one lower case letter)';
    }

    if(!filter_var($email,FILTER_VALIDATE_EMAIL)){
      $errors[] = 'Your email is not in acceptale format';
    }
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
      $allowedImageExt =array('jpg','gif','png');
    //  $radomchar = substr(md5(microtime()),rand(0,26),10);
      $uploadName =((isset($username1))?$username1:$username).'.'.$fileExt;
      $uploadPath = BASEURL.'images/staffs/'.$uploadName;
      $photopath = '/ecommerce/images/staffs/'.$uploadName;
      //if upload is not an image
      if($mimeType != 'image'){
        $errors[] = 'The file uploaded is not an image. Upload an image file please.';
      }else if(!in_array($fileExt, $allowedImageExt)){
        $errors[] = "The photo must be of file extension ['jpg','gif','png']";
      }else if($fileSize > 8000000){
        $errors[] = "File size must not exceed 8mb)";
      }else if($fileExt != $mineExt && ($mineExt == 'jpeg' && $fileExt != 'jpg')){
        $errors[] ='File extention does not match the file';
      }else {
        move_uploaded_file($tmpLoc,$uploadPath);
      }
    }
    if(!empty($errors)){
      echo display_errors($errors);
    }else{
      //add to database
        $editP = explode(',',$permissions1);
        $addP = explode(',',$permissions);
        //prevent an admin from given a staff a pro and admin clearance.
        if(isset($_GET['edit'])){
          if(!check_staff_permission('pro') && check_staff_permission('admin') && (in_array('pro',$editP,true) ||in_array('admin',$editP,true))){
            $message = "Please! You do not have clearance to update to that permission level";
            permission_ungranted('staff_account?edit='.$edit_id.'',$message);
            //break;
          }else{
            if(check_staff_permission('pro')){
              $insertSql = "UPDATE staffs SET username ='$username1',full_name ='$name1', phone='$phone1', email ='$email1', photo ='$photopath', permissions = '$permissions1', rank = '$ranks1',last_login ='$last_login'
              WHERE id='$edit_id'";
<<<<<<< HEAD

=======
>>>>>>> 00946282fd0ced214a37681e144e38779b687dd4
            }else{
              $insertSql = "UPDATE staffs SET username ='$username1',full_name ='$name1', phone='$phone1', email ='$email1', photo ='$photopath',permissions = '$permissions1',last_login ='$last_login'
              WHERE id='$edit_id'";
            }
            //$updatesql = "UPDATE categories SET category = '$category', parent = '$post_parent' WHERE id = '$edit_id'";
            $db->query($insertSql);
            $message = $name1. ' staff has been updated!';
            succes_redirect('staff_account?edit='.$edit_id.'',$message);
          }

        }else{
          // only an pro can assign all permssion level. Admin can asign editor downward.
            if(!check_staff_permission('pro') && check_staff_permission('admin') && in_array('pro',$addP,true) && in_array('admin',$addP,true)){
              $message = "Please! You do not have clearance to add that permission level";
              permission_ungranted('staff_account?add=1',$message);
              //break;
            }else{
              $hashed =password_hash($password,PASSWORD_DEFAULT);
              $db->query("INSERT INTO staffs (username,full_name,phone,email,password,permissions,rank,photo) values('$username','$name','$phone','$email','$hashed','$permissions','$ranks','$photopath')");
              $_SESSION['success_flash'] .= $name. ' staff has been added!';
              succes_redirect('staff_account',$message);
            }
        }
      }
    }
?>
<p></p>
<div class="box">
<h2 class="text-center"><?=((isset($_GET['edit']))?'Edit ':'Add A New ');?>User</h2><hr>
<form action="staff_account?<?=((isset($_GET['edit']))?'edit='.$edit_id:'add=1');?>" method="post" enctype="multipart/form-data">
  <div class="form-group col-md-6">
    <label for="username">User Name:</label>
    <input type="text" name="username" id="username" class="form-control" value="<?=((isset($_GET['edit']))?$username1:$username);?>">
  </div>
  <div class="form-group col-md-6">
    <label for="name">Full Name:</label>
    <input type="text" name="name" id="name" class="form-control" value="<?=((isset($_GET['edit']))?$name1:$name);?>">
  </div>
  <div class="form-group col-md-6">
    <label for="phone">Tel:</label>
    <div class="input-group">
       <span class="input-group-addon" id="basic-addon1">+234</span>
       <input type="number" name="phone" id="phone" class="form-control" value="<?=((isset($_GET['edit']))?$phone1:$phone);?>" placeholder="e.g 08030342243" required>
  </div>
  </div>
  <div class="form-group col-md-6">
    <label for="email">Email:</label>
    <input type="email" name="email" id="email" class="form-control" value="<?=((isset($_GET['edit']))?$email1:$email);?>">
  </div>
  <?php if(isset($_GET['edit'])): ?>
    <div class="form-group col-md-6">
      <label for="last login">Last Login:</label>
      <input type="text" name="last_login" id="last_login" class="form-control" value="<?=((isset($_GET['edit']))?$last_login:'');?>">
    </div>
  <?php else:?>
    <div class="form-group col-md-6">
      <label for="password">Password:</label>
      <input type="password" name="password" id="password" class="form-control" value="<?=$password;?>">
    </div>
    <div class="form-group col-md-6">
      <label for="confirm">Confirm Password:</label>
      <input type="password" name="confirm" id="confirm" class="form-control" value="<?=$confirm;?>">
    </div>
<?php endif; ?>
  <div class="form-group col-md-6">
    <label for="permissions">Permissions:</label>
    <select class= "form-control" id = "permissions" name ="permissions">
    <option value=""<?=(($permissions =='')?'selected':'');?>></option> <!--list all brand in drop menu on default -->
      <?php while($b = mysqli_fetch_assoc($PermissionQuery)): ?>
        <option value="<?=$b['permission'];?>"<?=(($permissions1 == $b['permission'])?'selected':'');?>><?=$b['permission'];?></option>
      <?php endwhile; ?>
    </select>
  </div>
  <div class="form-group col-md-6">
    <?php if(check_staff_permission('pro')){ ?>
      <label for="rank">Staff Rank:</label>
      <select class= "form-control" id = "rank" name ="rank" required>
    <?php }else{ ?>
        <div class="bg-danger text-center text-info">
          <p class="text-center text-info">
            Staff Rank: Higher Clearance Required!
          </p>
        </div>
        <select class= "form-control" id = "rank" name ="rank" disabled>
  <?php  } ?>
    <option value=""<?=(($ranks =='')?'selected':'');?>></option>
      <?php while($b = mysqli_fetch_assoc($RankQuery)):?>
        <option value="<?=$b['rank'];?>"<?=(($ranks1 == $b['rank'])?'selected':'');?>><?=$b['rank'];?></option>
      <?php endwhile; ?>
    </select>
  </div>
  <div class="form-group col-xs-6">
    <?php if($photo != ''): ?>
      <div class="saved-image">
      <img src="<?=$photo;?>" alt="saved image"/><br>
      <a href="staff_account?delete_photo=<?=$edit_id;?>" class="text-danger">Delete Logo</a>
    </div>
  <?php else:?>
    <label for="photo">Photo:</label>
    <input type="file" name="photo" id="photo" class="form-control" required>
  <?php endif; ?>
  </div>
  <div class="form-group col-md-6 text-right" style="margin-top:25px;">
    <a href="staff_account" class="btn btn-default">Return</a>
    <input type="submit" value="<?=((isset($_GET['edit']))?'Edit': 'Add');?> User" class="btn btn-primary">
  </div>
</form>
</div>
<?php

}else{
$limit = 10;
$offset = sanitize(!empty($_GET['page'])?(($_GET['page']-1)*$limit):0);
if(isset($_POST['searchStaff']) && !empty($_POST['searchStaff'])) {
$search = sanitize($_POST['searchStaff']);
$query1 = $db->query("SELECT * FROM staffs WHERE full_name LIKE '%".$search."%' OR email LIKE '%".$search."%' ORDER BY full_name");
$rowCount = mysqli_num_rows($query1);
$limit =$rowCount; //ignore pagination by setting limit to the returned rows
$userQuery = $db->query("SELECT * FROM staffs WHERE full_name LIKE '%".$search."%' OR email LIKE '%".$search."%' ORDER BY full_name LIMIT $offset,$limit");
  if(is_null($userQuery) || $rowCount ==0) {
    $errors[] = "The search item returns no result";
      if(!empty($errors)){
        echo display_errors($errors);
      }
    }
}else{
$queryNum = $db->query(sanitize("SELECT COUNT(*) as postNum FROM staffs ORDER BY full_name"));
$resultNum = $queryNum->fetch_assoc();
$rowCount = $resultNum['postNum'];
$userQuery = $db->query("SELECT * FROM staffs ORDER BY full_name LIMIT $offset,$limit");
}

$pagConfig = array(
  'baseURL'=>'http://localhost:81/ecommerce/admin/customer.php',
  'totalRows'=>$rowCount,
  'perPage'=>$limit
);
$pagination =  new Pagination($pagConfig);

?>
<div class="box">
<h2>Hello! <?=$staff_data['username'];?></h2>
<br>
    <div class="col-md-6">
      <form action="staff_account" method="post">
        <div class="form-group">
          <input type="text" class="form-control" placeholder="Search customer details.." name="searchStaff" required>
          <button type="submit" class="btn btn btn-sm btn-default"><span class="glyphicon glyphicon-search"></span> Search Staff</button>
        </div>
      </form>
    </div>
    <div class="col-md-6">
      <div class="col-md-3">
      <a href="staff_account?add=1" class=" btn btn-lg btn-success pull-right" id="add-user-btn">Add New Staff</a>
        </div>
      <div class="col-md-3">
      <a href="customer_account" class=" btn btn-lg btn-success pull-left" id="add-user-btn">View Registered Customer</a>
        </div>
    </div>
  </div>
<p></p>
<div class="box">
<table class="table table-bordered table-striped table-condensed table-hover">
  <thead><th>Action</th><th>Name</th><th>Emails</th><th>Join Date</th><th>Last Login</th><th>Permissions</th><th>Ranks</th></thead>
  <tbody>
  <?php  if($userQuery->num_rows > 0){ ?>
        <div class="posts_list">
          <?php while($user = mysqli_fetch_assoc($userQuery)): ?>
          <tr>
            <td>
              <!--Ensure the user cannot delete himself by not diplaying delete button on his info row -->
              <?php if($user['username'] != $staff_data['username']){ ?>
                <a href="staff_account?delete=<?=$user['id'];?>" class="btn btn-danger btn-xs" onclick="return deleletconfirm()"><span class ="glyphicon glyphicon-remove-sign"></span></a>
                <a href="staff_account?edit=<?=$user['id'];?>" class="btn btn-info btn-xs" ><span class ="glyphicon glyphicon-pencil"></span></a>
              <?php }else {?>
                <a class="btn btn-success btn-xs" ><span class ="glyphicon glyphicon-user"><strong></strong></span></a>
                <a href="staff_account?edit=<?=$user['id'];?>" class="btn btn-info btn-xs" ><span class ="glyphicon glyphicon-pencil"></span></a>
              <?php  }?>
            </td>
            <td><?=$user['full_name'];?></td>
            <td><?=$user['email'];?></td>
            <td><?=my_dateFormat($user['join_date']);?></td>
            <td><?=(($user['last_login'] =='0000-00-00 00:00:00')?'Never logged in':my_dateFormat($user['last_login']));?></td>
            <td><?=$user['permissions'];?></td>
            <td><?=$user['rank'];?></td>
          </tr>
        <?php endwhile; ?>
  </tbody>
</table>
</div> <p></p>

<?php echo $pagination->createLinks(); }?>

<hr>

<?php }include 'includes/footer.php'; ?>

<script>
function deleletconfirm(){
var del=confirm("Are you sure you want to delete this product?");
if (del==true){
//   alert ("record deleted")
}
return del;
}
</script>
