<?php
    include('../config/constants.php');
    //1. Destry the session
    session_destroy();// unsets $_seesion('user')

    //2. redirect to login page
    header('location:'.SITEURL.'admin/login.php');
?>