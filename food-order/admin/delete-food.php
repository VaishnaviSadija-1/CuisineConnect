<?php include('../config/constants.php'); ?>

<?php
// Check whether the id and image_name value is set or not
if(isset($_GET['id']) && isset($_GET['image_name'])) {
    // Get the value and delete
    $id = $_GET['id'];
    $image_name = $_GET['image_name'];

    // Remove the physical image file if available
    if($image_name != "") {
        // Image is available
        $path = "../images/food/" . $image_name;
        $remove = unlink($path);

        if($remove == false) {
            // Set the session message
            $_SESSION['remove'] = "<div class='error'>Failed to remove Food Image.</div>";
            header('location:' . SITEURL . 'admin/manage-food.php');
            // Redirect to manage food page
            // Stop the process
            die();
        }
    }

    // Delete data from database
    $sql = "DELETE FROM tbl_food WHERE id=$id";

    // Execute the query
    $res = mysqli_query($conn, $sql);

    // Check whether the query executed or not
    if($res == true) {
        // Create session variable to display message
        $_SESSION['delete'] = "<div class='success'>Food Deleted Successfully.</div>";
        // Redirect to Manage Food Page
        header('location:' . SITEURL . 'admin/manage-food.php');
    } else {
        $_SESSION['delete'] = "<div class='error'>Failed to Delete Food. Try Again Later.</div>";
        header('location:' . SITEURL . 'admin/manage-food.php');
    }
} else {
    // Redirect to manage food page
    $_SESSION['unauthorized'] = "<div class='error'>Unauthorized Access.</div>";
    header('location:' . SITEURL . 'admin/manage-food.php');
}
?>
