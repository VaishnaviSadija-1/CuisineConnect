<?php
//Authorization or Access Control
//check weather the user is looged in or not

if(!isset($_SESSION['user'])) {
    //user is not looged in
    //redirect to login page with message
    $_SESSION['no-login-message'] = "<div class='error text-center'>Please login to access Admin Panel</div>";
    //Redirect to login page
    header('location:'.SITEURL.'admin/login.php');

}



?>