<?php
require_once '../core/init.php';
//is_logged_in function is in helper file
//check if user is logged in on any of the pages
if(!is_logged_in()){
  header('Location:Login.php');
}

include 'includes/head.php';
include 'includes/navigation.php';
?>
Administrator Home
<?php include 'includes/footer.php'; ?>
