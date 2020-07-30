<?php
require_once $_SERVER['DOCUMENT_ROOT'].'/ecommerce/core/staff-init.php';
$staff_username = $_SESSION['staff_username'];
$date = date("Y-m-d H:i:s"); //this is the date format of the Database
$db->query("UPDATE users SET last_login = '$date' WHERE username = '$staff_username'");
unset($_SESSION['staff_id']);
unset($_SESSION['staff_username']);
unset($_SESSION['maintenance_admin_login']);
header('Location: login');
?>
