<link rel="stylesheet" href="../css/admin.css">
<?php include("partials/menu.php")  ?>

<div class="main-content">
    <div class="wrapper">
        <h1>Add Admin</h1>
        <br><br>

        <?php 

            if(isset($_SESSION['add'])){
            echo $_SESSION['add'];//Display message
            unset($_SESSION['add']);//remove message
            }


        ?>

        <form action="" method="POST">

        <table class="tbl-40">
            <tr>
                <td>Full Name</td>
                <td>
                    <input type="text" name="full_name" placeholder="Enter Your Name">
                </td>
            </tr>

            <tr>
                <td>UserName</td>
                <td>
                    <input type="text" name="username" placeholder="Your username">
                </td>
            </tr>

            <tr>
                <td>Password</td>
                <td>
                    <input type="password" name ="password" placeholder="Your password">
                </td>
            </tr>

            <tr>
                <td colspan="2">
                    <input type="submit" name="submit"value="Add Admin" class="btn-secondary">
                </td>
            </tr>

        </table>
        </form>
    </div>
</div>


<?php include("partials/footer.php")  ?>

<?php
    //process the value from form and save it in Database
    //check weather the submit button is clicked or not

    if(isset($_POST['submit'])){
        // //Button Clicked
        // echo "Button Clicked";

        //1. get the Data from Form
        $_full_name = $_POST['full_name'];
        $_username = $_POST['username'];
        $_password = md5($_POST['password']);//Password Encryption with md5

        //2. SQL Query to save data to Database
        $sql = "INSERT INTO tbl_admin SET
            full_name = '$_full_name',
            username = '$_username',
            password = '$_password'
        ";


        
        //3. Executing Query and Saving Data into Database
        $res = mysqli_query($conn, $sql) or die(mysqli_error($conn));

        //4. Check Wearther the data is inserted or not and display appropriate message
        if($res == true){
           // echo "Data Inserted";
           //Create a Session Variable to Display Message
           $_SESSION['add'] = "Admin Added Succesfully";
           //Redirect Page to Manage Admin
           header("location:".SITEURL.'admin/manage-admin.php');
        }

        else{
            //echo "Data not Inserted";
            // echo "Data Inserted";
           //Create a Session Variable to Display Message
           $_SESSION['add'] = "Failed to ADD Admin";
           //Redirect Page to Manage Admin
           header("location:".SITEURL.'admin/add-admin.php');
        }
 
    }


?>