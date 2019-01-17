<?php
require_once '../core/init.php';
//is_logged_in function is in helper file
//check if user is logged in on any of the pages
if(!is_logged_in()){
  login_error_redirect();
}
//check if user hs permision to view page
if(!has_admin_permission()){
  permission_error_redirect('index.php');
}
include 'includes/head.php';
include 'includes/navigation.php';
//delete a user


if(isset($_GET['delete'])){
  $delete_id = sanitize($_GET['delete']);
  $delUserResults = $db->query("SELECT * FROM users WHERE id = '$delete_id'");
  $userP = mysqli_fetch_assoc($delUserResults);
  $Dpermissions = explode(',', $userP['permissions']); //check user data permissions
  //Prevent pro user from being deleted.
  if(in_array('pro',$Dpermissions,true)){
  permission_ungranted('users.php');
  }else{
  $db->query("DELETE FROM users WHERE id = '$delete_id'");
  $_SESSION['success_flash'] .= $userP['full_name']. ' user has been successfully deleted from the databese!';
  header('Location:users.php');
  }
}
if(isset($_GET['add']) || isset($_GET['edit'])){
  $PermissionQuery = $db->query("SELECT * FROM permissions ORDER BY permissions"); //get brand from database
  $name = ((isset($_POST['name']))?sanitize($_POST['name']):'');
  $email = ((isset($_POST['email']))?sanitize($_POST['email']):'');
  $password = ((isset($_POST['password']))?sanitize($_POST['password']):'');
  $confirm = ((isset($_POST['confirm']))?sanitize($_POST['confirm']):'');
  $permissions = ((isset($_POST['permissions']))?sanitize($_POST['permissions']):'');
  $errors =array();
  $permissions1 = '';
  if(isset($_GET['edit'])){
        $edit_id =(int)$_GET['edit'];
        $EditUserResults = $db->query("SELECT * FROM users WHERE id='$edit_id'");
        $user = mysqli_fetch_assoc($EditUserResults);
        $Edit_permissions = explode(',', $user['permissions']);
        //pro user cannot be deleted.
        if(in_array('pro',$Edit_permissions,true)){
        permission_ungranted('users.php');
        }else{
        $name1 = ((isset($_POST['name']) && $_POST['name'] != '')?sanitize($_POST['name']):$user['full_name']);
        $email1 = ((isset($_POST['email']) && $_POST['email'] != '')?sanitize($_POST['email']):$user['email']);
        $last_login = ((isset($_POST['last_login']) && $_POST['last_login'] != '')?sanitize($_POST['last_login']):$user['last_login']);
        $permissions1 = ((isset($_POST['permissions']) && $_POST['permissions'] != '')?sanitize($_POST['permissions']):$user['permissions']);
        $password = $user['password'];
        $confirm = $user['password'];
      }
  }

  if($_POST){
    if(isset($_GET['edit'])){
      $required = array('name', 'email', 'permissions','last_login');
      $emailQuery = $db->query("SELECT * FROM users WHERE email='$email' AND id != $edit_id");
    }else{
      $required = array('name', 'email', 'permissions','password', 'confirm');
      $emailQuery = $db->query("SELECT * FROM users WHERE email='$email'");
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


    if($password != $confirm){
      $errors[] = 'Your password do not match.';
    }


    if (!is_accept_password($password)){
    $errors[] = ' Password must be atleast 6 characters( and contain at least one digit, one upper case letter, one lower case letter)';
    }

    if(!filter_var($email,FILTER_VALIDATE_EMAIL)){
      $errors[] = 'Your email is not in acceptale format';
    }
    if(!empty($errors)){
      echo display_errors($errors);
    }else{
      //add to database

        if(isset($_GET['edit'])){
          $insertSql = "UPDATE users SET full_name ='$name1', email ='$email1', permissions = '$permissions1',last_login ='$last_login'
          WHERE id='$edit_id'";
           //$updatesql = "UPDATE categories SET category = '$category', parent = '$post_parent' WHERE id = '$edit_id'";


          $db->query($insertSql);
         $_SESSION['success_flash'] .= $name1. ' user has been updated!';


          header('Location: users.php');
        }else{
          $hashed =password_hash($password,PASSWORD_DEFAULT);
        $db->query("INSERT INTO users (full_name,email,password,permissions) values('$name','$email','$hashed','$permissions')");
          $_SESSION['success_flash'] .= $name. ' User has been added!';
          header('Location: users.php');
        }
      }

    }

?>
<h2 class="text-center"><?=((isset($_GET['edit']))?'Edit ':'Add A New ');?>User</h2><hr>
<form action="users.php?<?=((isset($_GET['edit']))?'edit='.$edit_id:'add=1');?>" method="post" enctype="multipart/form-data">
  <div class="form-group col-md-6">
    <label for="name">Full Name:</label>
    <input type="text" name="name" id="name" class="form-control" value="<?=((isset($_GET['edit']))?$name1:$name);?>">
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
        <!-- option is set to brand pulled on edit box we are in edit mode or set to no brand selected
        if we are in add brand in add product mode -->
        <option value="<?=$b['permissions'];?>"<?=(($permissions1 == $b['permissions'])?'selected':'');?>><?=$b['permissions'];?></option>
      <?php endwhile; ?>

    </select>

  </div>
  <div class="form-group col-md-6 text-right" style="margin-top:25px;">
    <a href="users.php" class="btn btn-default">Cancel</a>
    <input type="submit" value="<?=((isset($_GET['edit']))?'Edit': 'Add');?> User" class="btn btn-primary">
  </div>
</form>
<?php

}else{
$userQuery =$db->query("SELECT * FROM users ORDER BY full_name");
?>
<h2>Users</h2>
<a href="users.php?add=1" class="btn btn-success pull-right" id="add-user-btn">Add New User</a>
<hr>
<table class="table table-bordered table-striped table-condensed">
  <thead><th></th><th>Name</th><th>Emails</th><th>Join Date</th><th>Last Login</th><th>Permissions</th></thead>
  <tbody>
    <?php while($user = mysqli_fetch_assoc($userQuery)): ?>
    <tr>
      <td>
        <!--Ensure the user cannot delete himself by not diplaying delete button on his info row -->
        <?php if($user['id'] != $user_data['id']): ?>
          <a href="users.php?delete=<?=$user['id'];?>" class="btn btn-default btn-xs"><span class ="glyphicon glyphicon-remove-sign"></span></a>
          <a href="users.php?edit=<?=$user['id'];?>" class="btn btn-default btn-xs"><span class ="glyphicon glyphicon-pencil"></span></a>
        <?php endif; ?>
      </td>
      <td><?=$user['full_name'];?></td>
      <td><?=$user['email'];?></td>
      <td><?=my_dateFormat($user['join_date']);?></td>
      <td><?=(($user['last_login'] =='0000-00-00 00:00:00')?'Never logged in':my_dateFormat($user['last_login']));?></td>
      <td><?=$user['permissions'];?></td>
    </tr>
  <?php endwhile; ?>
  </tbody>
</table>
<?php }include 'includes/footer.php'; ?>
