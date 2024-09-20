<?php
session_start();


if ((!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] != true) && $_SESSION['usertype'] != 'admin') {
    $login = true;
    header("location: ../login.php");
    exit;
}
$login = true;
$page_name = "";
if (!$page_name){
    $page_name = "Admin Panel";
}
?>