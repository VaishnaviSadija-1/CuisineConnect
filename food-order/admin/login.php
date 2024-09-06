<?php include('../config/constants.php'); ?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Food Order System</title>
    <link rel="stylesheet" href="../css/admin2.css">
    <style>
        /* Additional styles for login form */
        body {
            background-color: #f4f4f4;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }

        .login {
            background-color: #fff;
            padding: 40px;
            border-radius: 10px;
            box-shadow: 0 0 15px rgba(0, 0, 0, 0.1);
            text-align: center;
        }

        .login h1 {
            margin-bottom: 30px;
            color: #333;
        }

        .login input[type="text"],
        .login input[type="password"] {
            width: 100%;
            padding: 12px;
            margin: 10px 0;
            border: 1px solid #ddd;
            border-radius: 5px;
        }

        .login input[type="submit"] {
            width: 100%;
            padding: 12px;
            border: none;
            border-radius: 5px;
            background-color: #1e90ff;
            color: white;
            font-size: 16px;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        .login input[type="submit"]:hover {
            background-color: #3742fa;
        }

        .login p {
            margin-top: 20px;
        }

        .login .success {
            color: #2ed573;
            margin-bottom: 20px;
        }

        .login .error {
            color: #ff4757;
            margin-bottom: 20px;
        }
    </style>
</head>
<body>
    <div class="login">
        <h1 class="text-center">Login</h1>

        <?php 
            if(isset($_SESSION['login'])){
                echo '<div class="success">' . $_SESSION['login'] . '</div>';
                unset($_SESSION['login']);
            }

            if(isset($_SESSION['no-login-message'])){
                echo '<div class="error">' . $_SESSION['no-login-message'] . '</div>';
                unset($_SESSION['no-login-message']);
            }
        ?>

        <form action="" method="POST" class="text-center">
            <input type="text" name="username" placeholder="Enter Username" required>
            <input type="password" name="password" placeholder="Enter Password" required>
            <input type="submit" name="submit" value="Login" class="btn-primary">
        </form>

        <p class="text-center">Created By- <a href="#">Aryan Pasreja</a></p>
    </div>

    <?php
        if(isset($_POST['submit'])) {
            $username = $_POST['username'];
            $password = md5($_POST['password']);
            $sql = "SELECT * FROM tbl_admin WHERE username='$username' AND password='$password'";
            $res = mysqli_query($conn, $sql);
            $count = mysqli_num_rows($res);

            if($count == 1) {
                $_SESSION['login'] = "<div class='success'>Login Successful</div>";
                $_SESSION['user'] = $username;
                header('location:' . SITEURL . 'admin/'); 
            } else {
                $_SESSION['login'] = "<div class='error'>Username or Password did not match</div>";
                header('location:' . SITEURL . 'admin/login.php'); 
            }
        }
    ?>
</body>
</html>
