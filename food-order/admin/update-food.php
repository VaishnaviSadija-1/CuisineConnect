<link rel="stylesheet" href="../css/admin.css">
<?php include('partials/menu.php'); ?>

<div class="main-content">
    <div class="wrapper">
        <h1>Update Food</h1>

        <br><br>

        <?php 
            //1. Get the id of the selected Food
            $id = $_GET['id'];

            //2. Create SQL query to get the details
            $sql = "SELECT * FROM tbl_food WHERE id=$id";

            //Execute the query
            $res = mysqli_query($conn, $sql);

            //Check whether the query is executed or not
            if($res) {
                $count = mysqli_num_rows($res);

                if($count == 1) {
                    //Get the details
                    $row = mysqli_fetch_assoc($res);

                    $tittle = $row['tittle'];
                    $description = $row['description'];
                    $price = $row['price'];
                    $current_image = $row['image_name'];
                    $category_id = $row['category_id'];
                    $featured = $row['feature'];
                    $active = $row['active'];
                } else {
                    //Redirect to manage food page
                    header('location:'.SITEURL.'admin/manage-food.php');
                }
            }
        ?>

        <form action="" method="POST" enctype="multipart/form-data">
            <table class="tbl-40">
                <tr>
                    <td>Title</td>
                    <td>
                        <input type="text" name="tittle" value="<?php echo $tittle; ?>">
                    </td>
                </tr>

                <tr>
                    <td>Description</td>
                    <td>
                        <textarea name="description" cols="30" rows="5"><?php echo $description; ?></textarea>
                    </td>
                </tr>

                <tr>
                    <td>Price</td>
                    <td>
                        <input type="number" name="price" value="<?php echo $price; ?>">
                    </td>
                </tr>

                <tr>
                    <td>Current Image</td>
                    <td>
                        <?php 
                            if($current_image != "") {
                                // Display the image
                                ?>
                                <img src="<?php echo SITEURL; ?>images/food/<?php echo $current_image; ?>" width="150px">
                                <?php
                            } else {
                                // Display message
                                echo "<div class='error'>Image Not Added.</div>";
                            }
                        ?>
                    </td>
                </tr>

                <tr>
                    <td>New Image</td>
                    <td>
                        <input type="file" name="image">
                    </td>
                </tr>

                <tr>
                    <td>Category</td>
                    <td>
                        <select name="category">
                            <?php
                                // Create PHP code to display categories
                                $sql2 = "SELECT * FROM tbl_category WHERE active='Yes'";
                                $res2 = mysqli_query($conn, $sql2);
                                $count2 = mysqli_num_rows($res2);

                                if($count2 > 0) {
                                    while($row2 = mysqli_fetch_assoc($res2)) {
                                        $category_id_db = $row2['id'];
                                        $category_tittle = $row2['tittle'];
                                        ?>
                                        <option <?php if($category_id == $category_id_db) {echo "selected";} ?> value="<?php echo $category_id_db; ?>"><?php echo $category_tittle; ?></option>
                                        <?php
                                    }
                                } else {
                                    ?>
                                    <option value="0">No Category Found</option>
                                    <?php
                                }
                            ?>
                        </select>
                    </td>
                </tr>

                <tr>
                    <td>Featured</td>
                    <td>
                        <input <?php if($featured == "Yes") {echo "checked";} ?> type="radio" name="featured" value="Yes"> Yes 
                        <input <?php if($featured == "No") {echo "checked";} ?> type="radio" name="featured" value="No"> No
                    </td>
                </tr>

                <tr>
                    <td>Active</td>
                    <td>
                        <input <?php if($active == "Yes") {echo "checked";} ?> type="radio" name="active" value="Yes"> Yes 
                        <input <?php if($active == "No") {echo "checked";} ?> type="radio" name="active" value="No"> No
                    </td>
                </tr>

                <tr>
                    <td colspan="2">
                        <input type="hidden" name="current_image" value="<?php echo $current_image; ?>">
                        <input type="hidden" name="id" value="<?php echo $id; ?>">
                        <input type="submit" name="submit" value="Update Food" class="btn-secondary">
                    </td>
                </tr>
            </table>
        </form>

        <?php 
            // Check whether the submit button is clicked or not
            if(isset($_POST['submit'])) {
                // Get all the values from the form
                $id = $_POST['id'];
                $tittle = $_POST['tittle'];
                $description = $_POST['description'];
                $price = $_POST['price'];
                $current_image = $_POST['current_image'];
                $category_id = $_POST['category'];
                $featured = $_POST['featured'];
                $active = $_POST['active'];

                // Update the new image if selected
                if(isset($_FILES['image']['name'])) {
                    $image_name = $_FILES['image']['name'];

                    // Check whether the image is available or not
                    if($image_name != "") {
                        // Image is available
                        // A. Upload the new image
                        // Auto rename our image
                        $ext = end(explode('.', $image_name)); // Gets the extension of the image

                        $image_name = "Food-Name-".rand(0000, 9999).".".$ext; // This will be renamed image

                        $src_path = $_FILES['image']['tmp_name']; // Source path
                        $dest_path = "../images/food/".$image_name; // Destination path

                        // Finally upload the image
                        $upload = move_uploaded_file($src_path, $dest_path);

                        // Check whether the image is uploaded or not
                        if($upload == false) {
                            // Failed to upload the image
                            $_SESSION['upload'] = "<div class='error'>Failed to Upload Image.</div>";
                            header('location:'.SITEURL.'admin/manage-food.php');
                            die();
                        }

                        // B. Remove the current image if available
                        if($current_image != "") {
                            $remove_path = "../images/food/".$current_image;

                            $remove = unlink($remove_path);

                            // Check whether the image is removed or not
                            // If failed to remove then display message and stop the process
                            if($remove == false) {
                                // Failed to remove the image
                                $_SESSION['remove-failed'] = "<div class='error'>Failed to Remove Current Image.</div>";
                                header('location:'.SITEURL.'admin/manage-food.php');
                                die();
                            }
                        }
                    } else {
                        $image_name = $current_image;
                    }
                } else {
                    $image_name = $current_image;
                }

                // Create a SQL query to update food
                $sql3 = "UPDATE tbl_food SET
                    tittle = '$tittle',
                    description = '$description',
                    price = '$price',
                    image_name = '$image_name',
                    category_id = '$category_id',
                    feature = '$featured',
                    active = '$active'
                    WHERE id='$id'
                ";

                // Execute the SQL query
                $res3 = mysqli_query($conn, $sql3);

                // Check whether the query is executed or not
                if($res3) {
                    // Query executed and food updated
                    $_SESSION['update'] = "<div class='success'>Food Updated Successfully.</div>";
                    header('location:'.SITEURL.'admin/manage-food.php');
                } else {
                    // Failed to update food
                    $_SESSION['update'] = "<div class='error'>Failed to Update Food.</div>";
                    header('location:'.SITEURL.'admin/manage-food.php');
                }
            }
        ?>

    </div>
</div>

<?php include('partials/footer.php'); ?>
