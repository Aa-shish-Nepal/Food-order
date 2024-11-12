<?php

//Authorization
//checking whether the user is logged in or not

if(!isset($_SESSION['user'])){
//user is not logged in and redirecting to login page with message
$_SESSION['no-login-message']="<div class='error>Please login to access Admin panel.</div>";
header('location:'.SITEURL.'admin/login.php');


}
?>