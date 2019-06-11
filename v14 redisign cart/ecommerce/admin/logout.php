<?php
require_once $_SERVER['DOCUMENT_ROOT'].'/ecommerce/core/staff-init.php';
unset($_SESSION['staff_id']);
unset($_SESSION['staff_username']);
header('Location: login')
?>
