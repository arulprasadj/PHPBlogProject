<?php
// I have this script just to unset global vars and for session_destroy(), but I haven't created a link for "logout" yet.
require_once('connect.php');
unset($_SESSION['loggedin']);
unset($_SESSION['User_name']);
session_destroy();
header('location: login.php');
exit();
?>