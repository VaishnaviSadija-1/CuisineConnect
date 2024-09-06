<link rel="stylesheet" href="../css/admin.css">
<?php include('partials/menu.php'); ?>


<div class="main-content">
    <div class="wrapper">
        <h1>Add Category</h1>

        <br><br>

        <?php 

            if(isset($_SESSION['add'])){
            echo $_SESSION['add'];//Display message
            unset($_SESSION['add']);//remove message
            }

            if(isset($_SESSION['upload'])){
                echo $_SESSION['upload'];//Display message
                unset($_SESSION['upload']);//remove message
            }


        ?>

        <br><br>

        <!-- Add Category form start -->
        <form action="" method="POST" enctype="multipart/form-data">

        <table class="tbl-40">
            <tr>
                <td>Tittle:</td>
                <td>
                    <input type="text" name="tittle" placeholder="Category Tittle">
                </td>
            </tr>

            <tr>
                <td>Select Image: </td>
                <td>
                    <input type="file" name="image">
                </td>
            </tr>

            

            <tr>
                <td>Featured:</td>
                <td>
                    <input type="radio" name="featured" value="Yes"> Yes
                    <input type="radio" name="featured" value="No"> No
                </td>
            </tr>




            <tr>
                <td>Active:</td>
                <td>
                    <input type="radio" name="active" value="Yes"> Yes
                    <input type="radio" name="active" value="No"> No
                </td>
            </tr>



            <tr>
                <td colspan="2">
                    <input type="submit" name="submit" value="Add Category" class="btn-secondary">
                </td>
            </tr>
        </table>
        </form>
        <!-- Add Category form ends -->
        <?php

        //check weather the submit or not
        if(isset($_POST['submit'])){
            // echo "clicked";

            //1. Get the vallue from form
            $tittle =  mysqli_real_escape_string($conn, $_POST['tittle']);

            //for radio input type we need to check weather the button is selected or not
            if(isset($_POST['featured'])) {
                //get the vaue from form
                $featured = $_POST['featured'];
            }
            else{
                //set the default value
                $featured = "No";
            }

            //for radio input type we need to check weather the button is selected or not
            if(isset($_POST['active'])) {
                //get the vaue from form
                $active = $_POST['active'];
            }
            else{
                //set the default value
                $active = "No";
            }

            //check weather the image is selecetd or not and set the value for image name accordingly
            if(isset($_FILES['image']['name'])){
                //Upload the image
                //to upload the image we need image name,souce path and destination path
                $image_name = $_FILES['image']['name'];

                //Upload the image only if image is selected
                if($image_name != "") {

                

                    //auto rename the image(jpg,png,gif etc) eg: "special.food1.jpg"
                    $temp = explode('.', $image_name);
                    $ext = end($temp);

                    //rename the image
                    $image_name = "Food_Category_".rand(0000,9999).'.'.$ext;//e.g. Food_Category_834.jpg




                    $source_path = $_FILES['image']['tmp_name'];
                    $destination_path = "../images/category/".$image_name;

                    //FInnaly upload the image
                    $upload = move_uploaded_file($source_path,$destination_path);

                    //check weather the image is uploaded or not
                    if($upload==false) {
                        $_SESSION['upload'] = "<div class='error'>Failed to Uppload Image. </div>";
                        header('location:'.SITEURL.'admin/add-category.php');
                        //stop the process
                        die();
                    }

                }


            }

            else{
                //don't upload the image and set image_name value as blank 
            }

            // print_r($_FILES['image']);

            // die();//break the code here

            //2. Create sql query to insert category into database
            $sql = "INSERT INTO tbl_category SET
                    tittle='$tittle',
                    image_name='$image_name',
                    featured='$featured',
                    active='$active'
            ";

            //3. Execute the query and save in database
            $res = mysqli_query($conn, $sql);

            //4. Check weather the query is executed or not and data added or not
            if($res) {
                //query executed
                $_SESSION['add'] = "<div class='success'>Category Added Succesfully</div>";
                header('location:'.SITEURL.'admin/manage-category.php');
            }

            else{
                //failed to add category
                $_SESSION['add'] = "<div class='error'>Failed to Add Category</div>";
                header('location:'.SITEURL.'admin/add-category.php');
            }
        }




        ?>
    </div>
</div>

<?php include('partials/footer.php'); ?>