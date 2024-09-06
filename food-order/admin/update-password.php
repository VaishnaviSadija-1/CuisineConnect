<link rel="stylesheet" href="../css/admin.css">
<?php include("partials/menu.php")  ?>

<div class="main-content">
    <div class="wrapper">
        <h1>Change Password</h1>
        <br><br>

        <?php

            if(isset($_GET['id'])){
                $id=$_GET['id'];
            }


        ?>

        <form action="" method="POST">
            <table class="tbl-40">
                <tr>
                    <td>CurrentPasword: </td>
                    <td>
                        <input type="password" name="current_password" placeholder="current password">
                    </td>

                </tr>

                <tr>
                    <td>New Pasword: </td>
                    <td>
                        <input type="password" name="new_password" placeholder="new password">
                    </td>
                </tr>

                <tr>
                    <td>Confirm Pasword: </td>
                    <td>
                        <input type="password" name="confirm_password" placeholder="confirm password">
                    </td>
                </tr>

                <tr>
                    <td colspan="2">
                        <input type="hidden" name="id" value="<?php echo $id; ?>">
                        <input type="submit" name="submit" value="Change Password" class="btn-secondary">
                    </td>
                </tr>
            </table>
        </form>
    </div>
</div>


<?php

if(isset($_POST['submit'])) {
    // echo "Cicked";

    //1.get data from form
    $id=$_POST['id'];
    $current_password = md5($_POST['current_password']);
    $new_password = md5($_POST['new_password']);
    $confirm_password = md5($_POST['confirm_password']);

    //2. check wether the user with current id and password exsits or not
     $sql = "SELECT * FROM tbl_admin WHERE id=$id AND password='$current_password'";

     //execute
     $res= mysqli_query($conn, $sql);

     if($res==true){
        $count = mysqli_num_rows($res);

        if($count == 1) {
            //user exsits and password can change
            // echo "user found";
            if($new_password==$confirm_password) {
                // echo "Password match";
                $sql2="UPDATE tbl_admin SET
                    password='$new_password'
                    WHERE id=$id
                ";

                $res2 = mysqli_query($conn, $sql2);


                //check weather the query is executed or not

                if($res2) {
                    $_SESSION['change-pwd'] = "<div class='success'>Password Changed Successfully. </div>";
                    //redirect the user
                    header('location:'.SITEURL.'admin/manage-admin.php');

                }

                else{
                    $_SESSION['change-pwd'] = "<div class='error'>Failed to change Password. </div>";
                    //redirect the user
                    header('location:'.SITEURL.'admin/manage-admin.php');

                }


            }
            else{
                $_SESSION['pwd-not-match'] = "<div class='error'>Password Did not Match. </div>";
                //redirect the user
                header('location:'.SITEURL.'admin/manage-admin.php');
            }
        }

        else{
            //user does't exsit set message and redirect
            $_SESSION['user-not-found'] = "<div class='error'>User Not Found. </div>";
            //redirect the user
            header('location:'.SITEURL.'admin/manage-admin.php');
        }
     }

}




?>










<?php include('partials/footer.php'); ?>