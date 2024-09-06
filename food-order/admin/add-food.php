<?php include('partials/menu.php'); ?>


<div class="main-content">
    <div class="wrapper">
        <h1>Add Food</h1>
    </div>

    <br><br>

    <?php 

        if(isset($_SESSION['upload'])){
        echo $_SESSION['upload'];//Display message
        unset($_SESSION['upload']);//remove message
        }


    ?>


    <form action="" method="POST" enctype="multipart/form-data">

        <table class="tbl-40">
            <tr>
                <td>Tittle: </td>

                <td>
                    <input type="text" name="tittle" placeholder="Tittle of the Fodd">
                </td>
            </tr>

            <tr>
                <td>Description: </td>
                <td>
                    <textarea name="description" cols="30" rows="5" placeholder="Description of the Food"></textarea>
                </td>
            </tr>

            <tr>
                <td>Price: </td>
                <td>
                    <input type="number" name="price">
                </td>
            </tr>

            <tr>
                <td>Select Image: </td>
                <td>
                    <input type="file" name="image">
                </td>
            </tr>

            <tr>
                <td>Category: </td>
                <td>
                    <select name="category">


                        <?php

                        //create php code to display active categories from database

                        $sql = "SELECT * FROM tbl_category WHERE active = 'Yes'";

                        $res = mysqli_query($conn, $sql);

                        //count rows to check weather we have category or not
                        $count = mysqli_num_rows($res);
                        if($count > 0) {
                            while($row=mysqli_fetch_assoc($res)){
                                $id = $row['id'];
                                $tittle = $row['tittle'];
                                ?>
                                <option value="<?php echo $id; ?>"><?php echo $tittle; ?></option>


                                <?php
                            }


                        }

                        else{

                            ?>
                            <option value="0">None</option>

                            <?php

                        }

                        //2. Display Dropdown



                        ?>
                    </select>
                </td>
            </tr>

            <tr>
                <td>Featured: </td>
                <td>
                    <input type="radio" name="featured" id="Yes"> Yes
                    <input type="radio" name="featured" id="No"> No
                </td>
            </tr>

            <tr>
                <td>Active:</td>
                <td>
                    <input type="radio" name="active" id="Yes"> Yes
                    <input type="radio" name="active" id="No"> No 
                </td>
            </tr>

            <tr>
                <td colspan="2">
                    <input type="submit" name="submit" value="Add Food" class="btn-secondary">
                </td>
            </tr>
        </table>



    </form>

    <?php
    //check button is clicked or not
    if(isset($_POST['submit'])){
        // echo "clicked";

        //1. get the data from form
        $tittle = $_POST['tittle'];
        $description = $_POST['description'];
        $price = $_POST['price'];
        $category = $_POST['category'];

        //check weather ythe featured and active button is pressed or not
        if(isset($_POST['featured'])){
            $featured = $_POST['featured'];
        }
        else{
            $featured= "No";

        }

        if(isset($_POST['active'])){
            $active = $_POST['active'];
        }
        else{
            $active= "No";
        }


        //2. upload the image if selected

        if(isset($_FILES['image']['name'])){
            $image_name = $_FILES['image']['name'];

            if($image_name != ""){
                //image is selected
                //1. rename the image
                $ext = end(explode('.', $image_name));

                $image_name = "Food-Name-".rand(0000,9999).".".$ext;

                //2. upload the image
                //get the drc path and dest path

                $src = $_FILES['image']['tmp_name'];

                //destination path
                $dst = "../images/food/".$image_name;

                $upload = move_uploaded_file($src, $dst);

                //check weather image uploaded or not
                if($upload == false) {
                    //redirect to add-food page
                    $_SESSION['upload'] = "<div class='error'>Failed to Upload Image.</div>";
                    header('location:'.SITEURL.'admin/add-food.php');
                    die();
                }
            }


        }
        else{
            $image_name = "";

        }

        //3. insert into database
        $sql2= "INSERT INTO tbl_food SET
            tittle = '$tittle',
            description= '$description',
            price = $price,
            image_name = '$image_name',
            category_id = '$category',
            feature = '$featured',
            active = '$active'

        
        ";

        $res2 = mysqli_query($conn, $sql2);

        if($res2 == true){
            $_SESSION['add'] = "<div class='success'>Food Added Succesfully.</div>";
            header('location:'.SITEURL.'admin/manage-food.php');

        }

        else{
            $_SESSION['add'] = "<div class='error'>Failes to add Food.</div>";
            header('location:'.SITEURL.'admin/manage-food.php');
        }

    }




    ?>
</div>














<?php include('partials/footer.php'); ?>