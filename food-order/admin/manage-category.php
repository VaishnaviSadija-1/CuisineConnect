<?php include('partials/menu.php'); ?>


<div class="main-content">
    <div class="wrapper">
        <h1>Manage Category</h1>

        <br><br>

        <?php 
            if(isset($_SESSION['add'])){
                echo "<div class='success'>" . $_SESSION['add'] . "</div>"; // Display message
                unset($_SESSION['add']); // Remove message
            }

            if(isset($_SESSION['remove'])){
                echo $_SESSION['remove'];
                unset($_SESSION['remove']); // Remove message
            }

            if(isset($_SESSION['delete'])){
                echo $_SESSION['delete'];
                unset($_SESSION['delete']); // Remove message
            }

            if(isset($_SESSION['no-category-found'])){
                echo $_SESSION['no-category-found'];
                unset($_SESSION['no-category-found']); // Remove message
            }

            if(isset($_SESSION['update'])){
                echo $_SESSION['update'];
                unset($_SESSION['update']); // Remove message
            }

            if(isset($_SESSION['upload'])){
                echo $_SESSION['upload'];
                unset($_SESSION['upload']); // Remove message
            }

            if(isset($_SESSION['failed-remove'])){
                echo $_SESSION['failed-remove'];
                unset($_SESSION['failed-remove']); // Remove message
            }
        ?>
        <br><br>

        <!-- Button to Add Category -->
        <a href="<?php echo SITEURL; ?>admin/add-category.php" class="btn-primary">Add Category</a>
        <br><br><br>

        <table class="tbl-full">
            <tr>
                <th>S.N.</th>
                <th>Tittle</th>
                <th>Image</th>
                <th>Featured</th>
                <th>Active</th>
            </tr>

            <?php

            $sql = "SELECT * FROM tbl_category";

            $res=mysqli_query($conn, $sql);

            $count = mysqli_num_rows($res);

            $sn=1;

            //check weather we have data in database or not

            if($count > 0) {
                //we have data in data base
                while($row=mysqli_fetch_assoc($res)) {
                    $id = $row['id'];
                    $tittle = $row['tittle'];
                    $image_name = $row['image_name'];
                    $featured = $row['featured'];
                    $active = $row['active'];

                    ?>
                    <tr>
                        <td><?php echo $sn++; ?></td>
                        <td><?php echo $tittle; ?></td>

                        <td>
                            
                            <?php 

                            if($image_name!="") {
                                //Display the image
                                ?>

                                <img src="<?php echo SITEURL;  ?>images/category/<?php echo $image_name;  ?>" width="80px">


                                <?php
                            }

                            else{
                                //display the messahe
                                echo "<div class='error'>Image not Added</div>";
                            }
                        
                        
                            ?>
                        
                        </td>

                        <td><?php echo $featured; ?></td>
                        <td><?php echo $active; ?></td>
                        <td>
                            <a href="<?php echo SITEURL; ?>admin/update-category.php?id=<?php echo $id; ?>" class="btn-secondary">Update Category</a>
                            <a href="<?php echo SITEURL; ?>admin/delete-category.php?id=<?php echo $id; ?>&image_name=<?php echo $image_name; ?>" class="btn-danger">Delete Category</a>
                        </td>
                    </tr>



                    <?php
                }

            }

            else{
                //we do not have data in database
                ?>

                <tr>
                    <td colspan="6"><div class="error">no Category Added. </div></td>
                </tr>

                <?php
            }




            ?>

            


        </table>
    </div>
</div>

<?php include('partials/footer.php'); ?>
