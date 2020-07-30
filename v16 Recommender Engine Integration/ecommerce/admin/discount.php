<?php require_once '../core/staff-init.php';
//check if user is logged in on any of the pages
if(!is_staff_logged_in()){
  login_error_redirect();
}
include 'includes/head.php';
include 'includes/navigation.php'; ?>
<style>
.switch {
  position: absolute;
display: inline-block;
width: 60px;
height: 25px;
margin: 10;
margin: 4px 0 0 88px;
z-index: 100;
}

.switch input {
  display: none;
}

.slider {
  position: absolute;
  cursor: pointer;
  top: 0;
  left: 0;
  right: 0;
  bottom: 0;
  background-color: #cdcdcd;
  transition: 0.4s;
}
.click{
cursor: pointer;
background-color: #cdcdcd;
}
.slider::before {
  position: absolute;
  content: "";
  height: 18px;
  width: 8px;
  left: 2px;
  bottom: 3px;
  background-color: #ffffff;
  transition: 0.4s;
}

input:checked + .slider {
  background-color: #2a2b3d;
  border-width: thin;
  border-color: white;
}

input:focus + .slider {
  box-shadow: 0 0 1px #2a2b3d;
}

input:checked + .slider::before {
  transform: translateX(45px);
}

.slider.round {
  /* border-radius: 34px; */
border-top-right-radius: 34px;
border-bottom-right-radius: 34px
}

.slider.round::before {
  border-radius: 50%;
}
#disc_code{padding-left: 70px;
  border-top-right-radius: 34px;
  border-bottom-right-radius: 34px;
  max-width: 600px;
}
.box{
overflow: visible;
}

</style>
<?php
$_SESSION['staff_rdrurl'] = $_SERVER['REQUEST_URI'];
//get Discounts from database
$sql ="SELECT * FROM discount ORDER BY expiry";
$results =$db->query($sql);
$errors = array();
//delete
if(isset($_GET['delete']) && !empty($_GET['delete'])){
  if(check_staff_permission('admin')){
    $delete_id = (int)$_GET['delete']; //get id (row no) of brand within the table to delete
    $delete_id =sanitize($delete_id);
    $sql = "DELETE FROM discount WHERE id='$delete_id'";
    $db->query($sql); //pass sql state as a query on the database
    $message = $discount_code. ' code has been deleted!';
    succes_redirect('discount',$message);

  }else{
    $message = "Please! You do not have sufficient clearance to delete Discount.";
    permission_ungranted('discount',$message);
  }
}
if(isset($_GET['status'])){
    if(check_staff_permission('admin')){
    $id =(int)$_GET['id'];
    $status = (int)$_GET['status'];
    $sql = "UPDATE discount SET status = '$status' WHERE id = '$id'";
    $db->query($sql);
    $message =' discount code status changed!';
    succes_redirect('discount',$message);
  }else{
    $message = "Please! You do not have sufficient clearance to put product on sale.";
    permission_ungranted('products',$message);
  }

}
if(isset($_GET['edit'])){
$edit_id =(int)$_GET['edit'];
$EditUserResults = $db->query("SELECT * FROM discount WHERE id='$edit_id'");
$discount = mysqli_fetch_assoc($EditUserResults);
}
// if add form is submitted
if(isset($_POST['add_submit'])){
  if(check_staff_permission('editor')){
    $discount_code = ((isset($_POST['disc_code']) && $_POST['disc_code'] != '')?sanitize($_POST['disc_code']):$discount['disc_code']);
    $discount_code = trim($discount_code);
    $discount_use = ((isset($_POST['no_use']) && $_POST['no_use'] != '')?sanitize($_POST['no_use']):$discount['no_use']);
    $discount_expiry = ((isset($_POST['expiry']) && $_POST['expiry'] != '')?sanitize($_POST['expiry']):$discount['expiry']);
    $discount_percent = ((isset($_POST['disc_percent']) && $_POST['disc_percent'] != '')?sanitize($_POST['disc_percent']):$discount['disc_percent']);

    if($discount_code == ''){
      $errors[] .='You must enter a brand:';
    }
      //check if we are editing a discount to what already exist in Database
    $sql = "SELECT * FROM discount WHERE disc_code = '$discount_code'";
    if(isset($_GET['edit'])){
      $edit_id =(int)$_GET['edit'];
      $sql = "SELECT * FROM discount WHERE disc_code = '$discount_code' AND id != '$edit_id'";
    }
    $result = $db->query($sql);
    $count = mysqli_num_rows($result); //check how many time the user input appear in database
    // if it exist in database
    if($count > 0) {
      $errors[] ='...the discount code '.$discount_code.'  already exist. please choose or generate another discount code...';
    }
    //display errors if error occur then it will be in the errors array
    if(!empty($errors)){?>
    <br><hr>
      <?php
      echo display_errors($errors); // echo the error to screen
    }else{
       if(isset($_GET['edit'])){
         $sql = "UPDATE discount SET disc_code ='$discount_code',no_use ='$discount_use', expiry='$discount_expiry', disc_percent ='$discount_percent'
         WHERE id='$edit_id'";
         $db->query($sql);
         $message = $discount_code. ' code has been updated!';
         succes_redirect('discount',$message);
       }else{
         $db->query("INSERT INTO discount (disc_code,no_use,expiry,disc_percent) values('$discount_code','$discount_use','$discount_expiry','$discount_percent')");
         $message= $discount_code. ' code has been added!';
         succes_redirect('discount',$message);
       }
      }
  }else{
    $message = "Please! You do not have sufficient clearance to add or edit brand.";
    permission_ungranted('discount',$message);
  }
}
?>
<p></p><br>
  <div class="container-fluid box">
    <div class="row">
  <h2 class="text-center">Discount
    <?php if(!isset($_GET['add']) && !isset($_GET['edit'])){ ?>
  <a href="discount?add=1" class=" btn btn-md btn-success pull-right" id="">Add New Discount</a>
<?php } ?>
  </h2><hr>
    <?php if(isset($_GET['add']) || isset($_GET['edit'])){ ?>
        <div class ="text-center">
          <label for="discount"><?=((isset($_GET['edit']))?'Edit':'Add A'); ?> Discount:</label>
        </div>
      <form class = "" action="discount.php<?=((isset($_GET['edit']))?'?edit='.$edit_id:''); ?>" method="post">
      <?php
      $discount_code = '';
      $discount_percent = '';
      $discount_expiry = '';
      $discount_use = '';
        if(isset($_GET['edit'])){
          $discount_code = $discount['disc_code'];
          $discount_percent = $discount['disc_percent'];
          $discount_expiry = $discount['expiry'];
          $discount_use = $discount['no_use'];
        }else{
          if(isset($_POST['discount'])){
            $discount_code =sanitize($_POST['disc_code']);
            $discount_percent =sanitize($_POST['disc_percent']);
            $discount_expiry =sanitize($_POST['expiry']);
            $discount_use =sanitize($_POST['no_use']);
          }
        }
       ?>
      <div class="form-group col-sm-12">
        <label class="switch">
          <input type="checkbox" class=" c" >
          <span class="slider round"></span>
        </label>
        <div class="input-group">
           <span class="input-group-addon" id="basic-adkdon1">Disc_code</span>
           <input type="text"  maxlength="16"name="disc_code" id="disc_code" class="form-control" value="<?=$discount_code; ?>" placeholder="discount code" required>
      </div>
      </div>
      <div class="form-group col-sm-3">
        <div class="input-group">
           <span class="input-group-addon" id="basic-addon1">Disc%</span>
           <input maxlength="3" type="number" name="disc_percent" id="disc_percent" class="form-control" value="<?=$discount_percent; ?>" placeholder="Discount percent" required>
      </div>
      </div>
      <div class='col-sm-3'>
      <div class="form-group date">
        <div class="form-group">
          <div class='input-group date' id='datetimepicker1'>
              <input type='text' name="expiry" id="expiry"value="<?=$discount_expiry; ?>"class="form-control"/>
              <span class="input-group-addon">
                  <span class="glyphicon glyphicon-calendar"></span>
              </span>
          </div>
        </div>
      </div>
    </div>
      <div class="form-group col-sm-3">
        <div class="input-group">
           <span class="input-group-addon" id="basic-addon1">No of Use</span>
           <input type="number" name="no_use" id="no_use" class="form-control" value="<?=$discount_use; ?>" placeholder="no of use">
      </div>
      </div>
      <a href="discount" class="btn btn-default">Cancel</a>
      <input type ="submit" name="add_submit"value="<?=((isset($_GET['edit']))?'Edit': 'Add');?> Discount" class="btn btn-success ">
  </form>
<br>
<?php }else{ ?>
  <table class="table table-bordered table-striped table-brand table-condensed table-hover">
    <thead>
      <th>Action</th><th>Discount Code</th><th>Discount %</th><th>Disc Expiry</th><th>Created Date</th><th>number of Use</th><th>Status</th>
    </thead>
    <tbody>
  <?php while($discount = mysqli_fetch_assoc($results)):
      if (strtotime((new DateTime())->format("Y-m-d H:i:s")) > strtotime($discount['expiry'])) {
        $state =1;
        $status =0;
         $edit_id = $discount['id'];
        $sql = "UPDATE discount SET state ='$state',status ='$status'
        WHERE id='$edit_id'";
        $db->query($sql);
    } else {
        $state =0;
        $edit_id = $discount['id'];
        $sql = "UPDATE discount SET state ='$state'
        WHERE id='$edit_id'";
        $db->query($sql);
    }
      ?>
      <tr>
        <td><a href="discount.php?edit=<?=$discount['id']; ?>" class="btn btn-info btn-xs"><span class="glyphicon glyphicon-pencil"></span></a>&nbsp&nbsp
        <a href="discount.php?delete=<?=$discount['id']; ?>" class="btn btn-danger btn-xs" onclick="return deleteconfirm()"><span class="glyphicon glyphicon-remove-sign"></span></a></td>
        <td><?php if($discount['state'] == 1) {?>
        <s style="color:grey">  <?=$discount['disc_code']; ?></s>
        <?php }else{ ?>
          <?=$discount['disc_code']; ?>
        <?php } ?>
        </td>
        <td><?=$discount['disc_percent']; ?></td>
        <td><?=$discount['expiry']; ?>
        <?=(($discount['state'] == 1)?'Expired':'');?>
      </td>
        <td><?=$discount['created_date']; ?></td>
        <td><?=$discount['no_use']; ?></td>
        <td><a href = "discount?status=<?=(($discount['status']== 0)?'1':'0');?>&id=<?=$discount['id'];?>" class = "btn btn-xs <?=(($discount['status'] == 1)?'btn-success':'btn-default');?> ">
          <span class = "glyphicon glyphicon-<?=(($discount['status']==1)?'minus':'plus');?>"></span>
        </a>&nbsp <?=(($discount['status'] == 1)?'Active':'OFF');?></td>
    </tr>
    <?php endwhile; ?>
    </tbody>
  </table>
<?php } ?>
</div>
</div>
  <hr>
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
<div style="color:white">
<?php include 'includes/footer.php'; ?>
</div>
<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.17.1/moment.min.js"></script>
<link rel="stylesheet"
  href="https://rawgit.com/Eonasdan/bootstrap-datetimepicker/master/build/css/bootstrap-datetimepicker.min.css">
<script src="https://rawgit.com/Eonasdan/bootstrap-datetimepicker/master/build/js/bootstrap-datetimepicker.min.js"></script>
<style media="screen">
  body{
    background-color: #2a2b3d;
  }
</style>
<script>
function deleteconfirm(){
var del=confirm("Are you sure you want to delete this Discount?");
if (del==true){
//   alert ("record deleted")
}
return del;
}

$('.c').click(function(){
if (this.checked) {
  var result   = makeid(16);
  document.getElementById("disc_code").value = result;
} else {
  document.getElementById("disc_code").value = '';

}
});

function makeid(length){
   var result           = '';
   var characters       = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789';
   var charactersLength = characters.length;
   for ( var i = 0; i < length; i++ ) {
      result += characters.charAt(Math.floor(Math.random() * charactersLength));
   }
   return result;
}
$('#datetimepicker1').datetimepicker({
    defaultDate: new Date(),
    format: 'YYYY-MM-DD H:mm:ss',
    sideBySide: true,
    minDate: new Date(),
});
</script>
