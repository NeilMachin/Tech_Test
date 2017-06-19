<?php
session_start();
##require('connect_db.php');

unset($_SESSION['employee_id']);

#$url = 'http://' . $_SERVER['HTTP_HOST'] . dirname($_SERVER['PHP_SELF']);
#$url = rtrim($url, '/\\');
#$url .= '/oin_employee_update.php';
##header("Location: $url");

header('Location: oin_login.php'); ## employee_update.php');
exit();

