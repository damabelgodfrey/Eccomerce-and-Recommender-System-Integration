<?php
require_once '../core/init.php';
include 'includes/head.php';
include 'includes/navigation.php';
//get brands from database
$sql ="SELECT * FROM brand ORDER BY brand";
$results =$db->query($sql);
$errors = array();

//Edit Brands
if(isset($_GET['edit']) && !empty($_GET['edit'])){
$edit_id = (int)$_GET['edit']; //get id (row no) of brand within the table to delete
$edit_id =sanitize($edit_id);
$sql2 = "SELECT * FROM brand WHERE id='$edit_id'";
$edit_result = $db->query($sql2); //pass sql state as a query on the database
$eBrand = mysqli_fetch_assoc($edit_result); //access the content of row to be eddited into an associated array.

//header('Location: brands.php'); //redirect bark to the page
}
//delete
if(isset($_GET['delete']) && !empty($_GET['delete'])){
$delete_id = (int)$_GET['delete']; //get id (row no) of brand within the table to delete
$delete_id =sanitize($delete_id);
$sql = "DELETE FROM brand WHERE id='$delete_id'";
$db->query($sql); //pass sql state as a query on the database
header('Location: brands.php'); //redirect bark to the page

}
// if add form is submitted
if(isset($_POST['add_submit'])){
    $brand =sanitize($_POST['brand']); //store user brand input and sanitize for security()
    // remove any white space before typed input brands

    $brand = trim($brand);

    //check is brand is blank put error message in $errors aray
    if($brand == ''){
      $errors[] .='You must enter a brand:';
    }
      //check if we are editing a brand to what already exist in Database
    $sql = "SELECT * FROM brand WHERE brand = '$brand'";
    if(isset($_GET['edit'])){
      $sql = "SELECT * FROM brand WHERE brand = '$brand' AND id != '$edit_id'";
    }
    $result = $db->query($sql);
    $count = mysqli_num_rows($result); //check how many time the user input appear in database
    // if it exist in database
    if($count > 0) {
      $errors[] .=$brand.'  already exist. please choose another brand name...';
    }
    //display errors if error occur then it will be in the errors array
    if(!empty($errors)){
      echo display_errors($errors); // echo the error to screen
    }else{
      //add brand to database because no error was caught hence error array is empty
       $sql ="INSERT INTO brand (brand) VALUES ('$brand')";
       //if we are adding to database by update(edit) override normal edit query
       if(isset($_GET['edit'])){
         $sql = "UPDATE brand SET brand = '$brand' WHERE id = '$edit_id'";
       }
       $db->query($sql);
       header('Location:brands.php'); //reload page
      }
  }
?>
<h2 class="text-center">Brands</h2> <hr>
<!--Brand form  -->
<!--for the action =brand.php line if is set then edit and concatenate (with . sign)
   -->
  <!-- condition of if else within an echo (isset($_POST['brand']) if success do $_POST['brand'] if false do ''   -->
<!--a bootstrap form class  -->
<div class ="text-center">
  <!-- clicking edit button should post (brands.php?edit=2) 2 is edit id -->
<form class = "form-inline" action="brands.php<?=((isset($_GET['edit']))?'?edit='.$edit_id:''); ?>" method="post">
  <div class="form-group">
    <?php
    $brand_value = ''; //set to empty string
      if(isset($_GET['edit'])){
        $brand_value = $eBrand['brand'];
      }else{
        if(isset($_POST['brand'])){
          $brand_value =sanitize($_POST['brand']);
        }
      }
     ?>
    <label for="brand"><?=((isset($_GET['edit']))?'Edit':'Add A'); ?> Brand:</label>

    <input type="text" name="brand" id="brand" class ="form-control" value ="<?=$brand_value; ?>">
    <!--show cancel button if edit is clicked  -->
    <?php if(isset($_GET['edit'])): ?>
      <a href="brands.php" class="btn btn-default">Cancel</a>
    <?php endif; ?>
      <!--change to edit button if edit is clicked else add brand label on button -->
    <input type ="submit" name="add_submit" value="<?=((isset($_GET['edit']))?'Edit': 'Add');?> Brand" class="btn btn-success">
  </div>
</form>
</div><hr>
<table class="table table-bordered table-striped table-auto table-condensed">
  <thead>
    <th></th><th>Brand</th><th></th>
  </thead>
  <tbody>
    <?php while($brand = mysqli_fetch_assoc($results)): ?>
    <tr>
      <td><a href="brands.php?edit=<?=$brand['id']; ?>" class="btn btn-xs btn-default"><span class="glyphicon glyphicon-pencil"></span></a></td>
      <td><?=$brand['brand']; ?></td>
      <td><a href="brands.php?delete=<?=$brand['id']; ?>" class="btn btn-xs btn-default"><span class="glyphicon glyphicon-remove-sign"></span></a></td>
    </tr>
  <?php endwhile; ?>
  </tbody>
</table>
<?php include 'includes/footer.php'; ?>
