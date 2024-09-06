

<?php include('../config/constants.php'); ?>
<?php



//check weather the id and image_name value is set or not
if(isset($_GET['id']) && isset($_GET['image_name'])) {
    //Get the value and delte
    $id = $_GET['id'];
    $image_name = $_GET['image_name'];

    //remove the physical image file if avilable
    if($image_name != ""){
        //image is avlable
        $path = "../images/category/".$image_name;
        $remove = unlink($path);

        if($remove == false) {
            //Set the seesion message
            $_SESSION['remove'] = "<div class='error'>Failed to remove Category Image.</div>";
            header('location:'.SITEURL/'admin/manage-category.php');
            //redirect to manage category page
            //stop the process
            die();
        }

    }


    //delte data from database
    $sql = "DELETE FROM tbl_category WHERE id=$id";

    //ecexute the query
    $res = mysqli_query($conn, $sql);

    //check weather the query ecuted or not

    if($res == true){
        // echo "Admin Deleted";

        //create session variable to diplay message
        $_SESSION['delete'] = "<div class='success'>Category Deleted Succesfully.</div>";
        //redirect to Manage Admin Page
        header('location:'.SITEURL.'admin/manage-category.php');
    }

    else{
        $_SESSION['delete'] = "<div class='error'>Failed to Delete Category. Try Again Later.</div>";
        header('location:'.SITEURL.'admin/manage-category.php');
    // echo "Failed to Delete Admin";

    }



    //redirect to manage-category page
}



?>

