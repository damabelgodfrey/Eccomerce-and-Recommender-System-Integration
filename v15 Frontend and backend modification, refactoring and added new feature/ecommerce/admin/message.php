<?php
require_once '../core/staff-init.php';
if(!is_staff_logged_in()){
  login_error_redirect();
}
//check if user has permision to view page
if(!check_staff_permission('admin')){
  permission_error_redirect('index');
}
include 'includes/head.php';
include 'includes/navigation.php';
$_SESSION['staff_rdrurl'] = $_SERVER['REQUEST_URI'];

//complete orders
if(isset($_GET['read']) && $_GET['read'] == 1) {
  $msg_id = sanitize($_GET['msg_id']);
  $db->query("UPDATE contact SET status = 'read' WHERE id = '{$msg_id}'");
  $_SESSION['success_flash'] = "The message has been marked as read!";
  header('Location: receivedmessage');

}
if(isset($_GET['msg_id'])) {
$msg_id = sanitize((int)$_GET['msg_id']);
$msgQuery = $db->query("SELECT * FROM contact WHERE id = '{$msg_id}'");
$msg = mysqli_fetch_assoc($msgQuery);

 ?>
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
 <a href="receivedmessage" class="btn btn-large btn-default">Cancel</a>
 <a href="message?read=1&msg_id=<?=$msg_id;?>" class="btn btn-primary btn-large" onclick="return confirmC()">Mark as Read</a>
</div>

<?php } include 'includes/footer.php'; ?>
 <script>
 function confirmC(){
 var del=confirm("Are you sure you want to mark as read?");
 if (del==true){
 //   alert ("record deleted")
 }
 return del;
 }
 </script>
