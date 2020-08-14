<?php
require_once '../core/staff-init.php';
//is_staff_logged_in function is in helper file
//check if user is logged in on any of the pages
if(!is_staff_logged_in()){
  login_error_redirect();
}
if (!isset($_SERVER['HTTP_REFERER'])){
    ?><hr><div class="bg-danger">
      <p class="text-center text-danger">
        Error!! That navigation pattern is forbidden!
      </p>
    </div>
    <a href="receivedmessage" class="btn btn-lg btn-default">Return</a>
    <?php
    exit();
  }
include 'includes/head.php';
include 'includes/navigation.php';
$_SESSION['staff_rdrurl'] = $_SERVER['REQUEST_URI'];
?>
<?php
if(isset($_GET['read']) && $_GET['read'] == 1) {
  $msg_id = sanitize($_GET['msg_id']);
  $db->query("UPDATE contact SET status = 'read' WHERE id = '{$msg_id}'");
  $_SESSION['success_flash'] = "The message has been marked as read!";
  header('Location: receivedmessage?status=1');
  ?><script>
  window.location.replace("http://localhost:81/ecommerce/admin/receivedmessage?status=0");
  </script><?php
exit();
}

if(isset($_GET['read']) && $_GET['read'] == 0) {
  $msg_id = sanitize($_GET['msg_id']);
  $db->query("UPDATE contact SET status = 'unread' WHERE id = '{$msg_id}'");
  $_SESSION['success_flash'] = "The message has been marked as unread!";
  header('Location: receivedmessage?status=0');
  ?><script>
  window.location.replace("http://localhost:81/ecommerce/admin/receivedmessage?status=0");
  </script><?php
exit();
}
?><p></p><?php
if(isset($_GET['msg_id'])) {
$msg_id = sanitize((int)$_GET['msg_id']);
$msgQuery = $db->query("SELECT * FROM contact WHERE id = '{$msg_id}'");
$msg = mysqli_fetch_assoc($msgQuery);

 ?>
 <div class="box">
<h2 class="text-center">Customer Message </h2>
<table class="table table-condesed table-bordered table-striped table-hover" id=orderTableHead1 >
  <thead class= "bg-primary">
    <th>Details</th><th>Message</th>
  </thead>
  <tbody>
    <tr>
      <td><?=$msg['name'];?><br><?=$msg['email'];?><br><?=$msg['msg_date'];?><br><?=$msg['url'];?><br><?=$msg['phone'];?></td>
      <td><?=$msg['subject'];?><br><?=$msg['message'];?></td>
    </tr>
</tbody>
</table>

<div class='pull-right'>
 <a href="receivedmessage" class="btn btn-large btn-default">go back</a>
 <?php if($msg['status'] == 'unread'){ ?>
 <a href="receivedmessage?read=1&msg_id=<?=$msg_id;?>" class="btn btn-primary btn-large" onclick="return confirmC()">Mark as Read</a>
<?php }else{ ?>
  <a href="receivedmessage?read=0&msg_id=<?=$msg_id;?>" class="btn btn-primary btn-large" onclick="return confirmC()">Mark as Unread</a>

<?php } ?>
</div>
</div>
<?php }else{ ?>
  <div class="box">
    <div class="col-md-12"><br>
  <?php
  if(isset($_GET['status']) && $_GET['status'] == 0) {
    $mesQuery =   "SELECT * FROM contact  ORDER BY msg_date" ;
    ?><a href="receivedmessage?status=1" class="btn btn-block btn-primary btn-large" >View unread messages</a>
    <h3 class="text-center">Inbox Messages</h3><?php
  }else {
    $mesQuery =   "SELECT * FROM contact WHERE status = 'unread' ORDER BY msg_date" ;
    ?><a href="receivedmessage?status=0" class="btn btn-block btn-primary btn-large" >View all inbox messages</a>
    <h3 class="text-center">Incoming Unread Messages</h3><?php
  }
    $msgResults = $db->query($mesQuery);
  $return = mysqli_num_rows($msgResults);
  if($return >0) {
  ?>
    <table class="table table-condesed table-bordered table-striped table-hover">
      <thead>
        <th></th><th>info</th><th>subject</th>
      </thead>
      <tbody>
        <?php while ($msg = mysqli_fetch_assoc($msgResults)): ?>
        <tr>
          <td><a href="receivedmessage?msg_id=<?=$msg['id'];?>" class="btn btn-xs btn-info">Message Details</td>
          <td><?=$msg['name'];?><br><?=$msg['email'];?></td>
          <td><?=$msg['subject'];?></td>
        </tr>
      <?php endwhile; ?>
    </tbody>
  </table>
  </div>
  <?php }else{ ?>
    <div class="bg-danger">
      <p class="text-center text-warning">
        <h2>No new message received!</h2>
      </p>
    </div>
  <?php } ?>

<?php } ?>
</div>
<?php include 'includes/footer.php'; ?>

<script>
function confirmC(){
var del=confirm("Are you sure you want to mark as read?");
if (del==true){
//   alert ("record deleted")
}
return del;
}
</script>
