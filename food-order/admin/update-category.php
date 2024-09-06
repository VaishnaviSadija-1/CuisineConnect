<?php include('partials/menu.php'); ?>



<div class="main-content">
    <div class="wrapper">
        <h1>Update Category</h1>

        <br><br>

        <?php

        if(isset($_GET['id'])){
            //gget the id and all other detailss
            echo"getting the data";
            $id = $_GET['id'];
            //craete sql query to get all other details
            $sql = "SELECT * FROM tbl_category WHERE id=$id";

            $res = mysqli_query($conn, $sql);

            //count rows to check weather the id is valis or not

            $count = mysqli_num_rows($res);

            if($count == 1) {
                //get all the data
                $row = mysqli_fetch_assoc($res);
                $tittle = $row['tittle'];
                $current_image = $row['image_name'];
                $featured = $row['featured'];
                $active = $row['active'];


            }

            else{
                //redirect to manage-category page
                $_SESSION['no-category-found'] = "<div class='error'>Category Not Found</div>";
                header('location:'.SITEURL.'admin/manage-category.php');
            }
        }

        else{
            //redirect to manage category
            header('location:'.SITEURL.'admin/manage-category.php');
        }



        ?>

        <form action="" method="POST" enctype="multipart/form-data">
        <table class="tbl-40">
            <tr>
                <td>Tittle: </td>
                <td>
                    <input type="text" name="tittle" value="<?php echo $tittle; ?>">
                </td>
            </tr>

            <tr>
                <td>Current Image: </td>
                <td>
                    <?php

                    if($current_image != "") {
                        //display the image

                        ?>

                        <img src="<?php echo SITEURL; ?>images/category/<?php echo $current_image; ?>" width="120px">


                        <?php
                    }

                    else{
                        //display menssage
                        echo "<div class='error'>Imange Not Added</div>";
                    }



                    ?>
                </td>
            </tr>

            <tr>
                <td>New Image: </td>
                <td>
                    <input type="file" name="image">
                </td>
            </tr>

            <tr>
                <td>Featured: </td>
                <td>
                    <input <?php if($featured == "Yes"){echo "checked";} ?> type="radio" name="featured" value="Yes"> Yes
                    <input <?php if($featured == "No"){echo "checked";} ?> type="radio" name="featured" value="No"> No
                </td>
            </tr>

            <tr>
                <td>Actve: </td>
                <td>
                    <input <?php if($active == "Yes"){echo "checked";} ?>type="radio" name="active" value="Yes"> Yes
                    <input <?php if($active == "No"){echo "checked";} ?> type="radio" name="active" value="No"> No
                </td>
            </tr>

            <tr>
                <td>
                    <input type="hidden" name="current_image" value="<?php echo $current_image; ?>">
                    <input type="hidden" name="id" value="<?php echo $id; ?>">
                    <input type="submit" name="submit" value="submit" value="update-category" class="btn-secondary">
                </td>

            </tr>



            
        </table>
        </form>

        <?php


        if(isset($_POST['submit'])) {
            // echo "clicked";

            //1. Get all the value from our form
            $id = $_POST['id'];
            $tittle = $_POST['tittle'];
            $current_image = $_POST['current_image'];
            $featured = $_POST['featured'];
            $active = $_POST['active'];

            //2. Updating the new imaage if selected
            if(isset($_FILES['image']['name'])){

                $image_name = $_FILES['image']['name'];

                if($image_name != ""){
                    //image avilable

                    //upload the new image
                    //auto rename the image(jpg,png,gif etc) eg: "special.food1.jpg"
                    $temp = explode('.', $image_name);
                    $ext = end($temp);

                    //rename the image
                    $image_name = "Food_Category_".rand(000,999).'.'.$ext;//e.g. Food_Category_834.jpg




                    $source_path = $_FILES['image']['tmp_name'];
                    $destination_path = "../images/category/".$image_name;

                    //FInnaly upload the image
                    $upload = move_uploaded_file($source_path,$destination_path);

                    //check weather the image is uploaded or not
                    if($upload==false) {
                        $_SESSION['upload'] = "<div class='error'>Failed to Uppload Image. </div>";
                        header('location:'.SITEURL.'admin/manage-category.php');
                        //stop the process
                        die();
                    }

                    if($current_image != "") {
                        //remove the current image
                        $remove_path = "../images/category/".$current_image;
                        $remove = unlink($remove_path);

                        //check wether the the image is removed or not

                        if($remove == false) {
                            $_SESSION['failed-remove'] = "<div class='error'>Failed to remove the image</div>";
                            header('location:'.SITEURL.'admin/manage-category.php');
                            die();

                        }
                        
                    }


                }

                else{
                    $image_name = $current_image;
                }

            }

            else{
                $image_name = $current_image;
            }

            //3. update the database
            $sql2 = "UPDATE tbl_category SET
                tittle='$tittle',
                image_name = '$image_name',
                featured = '$featured',
                active = '$active'
                WHERE id=$id
            ";

            $res2 = mysqli_query($conn, $sql2);

            //4. redirect to manage category with message

            if($res2==true) {
                $_SESSION['update'] = "<div class='success'>Category Updated Succesfully</div>";
                header('location:'.SITEURL.'admin/manage-category.php');
            }

            else{
                $_SESSION['update'] = "<div class='success'>Failed to Update Category</div>";
                header('location:'.SITEURL.'admin/manage-category.php');  
            }
            
        }




        ?>


    </div>
</div>



<?php include('partials/footer.php'); ?>