

<?php include('../config/constants.php'); ?>
<?php

//1. get the ID of admn to be deleted
$id = $_GET['id'];



//2. create SQL query to Delte Admin

$sql = "DELETE FROM tbl_admin WHERE id=$id";

//ecexute the query
$res = mysqli_query($conn, $sql);

//check weather the query ecuted or not

if($res == true){
    // echo "Admin Deleted";

    //create session variable to diplay message
    $_SESSION['delete'] = "<div class='success'>Admin Deleted Succesfully.</div>";
    //redirect to Manage Admin Page
    header('location:'.SITEURL.'admin/manage-admin.php');
}

else{
    $_SESSION['delete'] = "<div class='error'>Failed to Delete Admin. Try Again Later.</div>";
    header('location:'.SITEURL.'admin/manage-admin.php');
   // echo "Failed to Delete Admin";

}



//3. Redirect to Manage Admin page with message (success/error)







?>

