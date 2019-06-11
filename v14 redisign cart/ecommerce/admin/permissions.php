<?php
require_once '../core/staff-init.php';
//check if user is logged in on any of the pages
if(!is_staff_logged_in()){
  login_error_redirect();
}
if(!check_staff_permission('admin')){
  permission_error_redirect('index');
}
include 'includes/head.php';
include 'includes/navigation.php';
$_SESSION['staff_rdrurl'] = $_SERVER['REQUEST_URI'];
$sql ="SELECT * FROM permissions";
$Presults =$db->query($sql);
$errors = array();

//Edit Brands
if(isset($_GET['Pedit']) && !empty($_GET['Pedit'])){
  if(check_staff_permission('pro')){
    $Pedit_id = sanitize((int)$_GET['Pedit']); //get id (row no) of brand within the table to delete
    $Psql2 = "SELECT * FROM permissions WHERE id='$Pedit_id'";
    $Pedit_result = $db->query($Psql2); //pass sql state as a query on the database
    $epermission = mysqli_fetch_assoc($Pedit_result); //access the content of row to be eddited into an associated array.
  }else{
    $message = "Please! You do not have sufficient clearance to Edit permissions.";
    permission_ungranted('permissions.php',$message);
  }
//header('Location: brands.php'); //redirect bark to the page
}
//delete
if(isset($_GET['Pdelete']) && !empty($_GET['Pdelete'])){
  if(check_staff_permission('pro')){
    $Pdelete_id = (int)$_GET['Pdelete']; //get id (row no) of brand within the table to delete
    $Pdelete_id =sanitize($Pdelete_id);
    $sql = "DELETE FROM permissions WHERE id='$Pdelete_id'";
    $db->query($sql); //pass sql state as a query on the database
    header('Location: permissions.php'); //redirect bark to the page

  }else{
    $message = "Please! You do not have sufficient clearance to delete permissions.";
    permission_ungranted('permissions.php',$message);
  }
}
// if add form is submitted
if(isset($_POST['add_submit'])){
  if(check_staff_permission('pro')){
    $permission =trim(sanitize($_POST['permission']));
    if($permission == ''){
      $errors[] .='You must enter a permission string:';
    }
      //check if we are editing a brand to what already exist in Database
    $sql = "SELECT * FROM permissions WHERE permission = '$permission'";
    if(isset($_GET['Pedit'])){
      $sql = "SELECT * FROM permissions WHERE permission = '$permission' AND id != '$Pedit_id'";
    }
    $result = $db->query($sql);
    $count = mysqli_num_rows($result); //check how many time the user input appear in database
    // if it exist in database
    if($count > 0) {
      $errors[] .=$permission.'  already exist. please choose another Permission Level...';
    }
    //display errors if error occur then it will be in the errors array
    if(!empty($errors)){
      echo display_errors($errors); // echo the error to screen
    }else{
      //add brand to database because no error was caught hence error array is empty
       $sql ="INSERT INTO permissions (permission) VALUES ('$permission')";
       //if we are adding to database by update(edit) override normal edit query
       if(isset($_GET['Pedit'])){
         $sql = "UPDATE permissions SET permission = '$permission' WHERE id = '$Pedit_id'";
       }
       $db->query($sql);
       header('Location:permissions.php'); //reload page
      }
  }else{
    $message = "Please! You do not have sufficient clearance to add or edit Permissions.";
    permission_ungranted('permissions.php',$message);
  }
}
?>
<div class="container col-md-12">
  <h2 class="text-center">Permissions</h2> <hr>
  <div class ="text-center">
    <!-- clicking edit button should post (brands.php?edit=2) 2 is edit id -->
  <form class = "form-inline" action="permissions.php<?=((isset($_GET['Pedit']))?'?Pedit='.$Pedit_id:''); ?>" method="post">
    <div class="form-group">
      <?php
      $P_value = ''; //set to empty string
        if(isset($_GET['Pedit'])){
          $P_value = $epermission['permission'];
        }else{
          if(isset($_POST['permission'])){
            $P_value =sanitize($_POST['permission']);
          }
        }
       ?>
      <label for="permissions"><?=((isset($_GET['Pedit']))?'Edit':'Add A'); ?> Permission:</label>

      <input type="text" name="permission" id="mypermission" class ="form-control" value ="<?=$P_value; ?>">
      <!--show cancel button if edit is clicked  -->
      <?php if(isset($_GET['Pedit'])): ?>
        <a href="permissions.php" class="btn btn-default">Cancel</a>
      <?php endif; ?>
        <!--change to edit button if edit is clicked else add brand label on button -->
      <input type ="submit" name="add_submit" value="<?=((isset($_GET['Pedit']))?'Edit': 'Add');?> permissions" class="btn btn-success">
    </div>
  </form>
  </div><hr>
  <table class="table table-bordered table-striped table-brand table-condensed table-hover">
    <thead>
      <th>Action</th><th>Permission Level</th>
    </thead>
    <tbody>
      <?php while($permission = mysqli_fetch_assoc($Presults)): ?>
      <tr>
        <td><a href="permissions.php?Pedit=<?=$permission['id']; ?>" class="btn btn-info btn-xs"><span class="glyphicon glyphicon-pencil"></span></a>&nbsp&nbsp
        <a href="permissions.php?Pdelete=<?=$permission['id']; ?>" class="btn btn-danger btn-xs" onclick="return Pdeleteconfirm()"><span class="glyphicon glyphicon-remove-sign"></span></a></td>
        <td><?=$permission['permission']; ?></td>
    </tr>
    <?php endwhile; ?>
    </tbody>
  </table>
</div><hr>
<?php include 'includes/footer.php'; ?>
<script>
function Pdeleteconfirm(){
var del=confirm("Are you sure you want to delete this Permision Level?");
if (del==true){
//   alert ("record deleted")
}
return del;
}
</script>
