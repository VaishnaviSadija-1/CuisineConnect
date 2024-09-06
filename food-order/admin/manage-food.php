<?php include('partials/menu.php'); ?>

<div class="main-content">
    <div class="wrapper">
        <h1>Manage Food</h1>

        <br><br>

        <!-- Button to Add Food -->
        <a href="<?php echo SITEURL;?>admin/add-food.php" class="btn-primary">Add Food</a>
        <br><br><br>

        <?php 
            if(isset($_SESSION['add'])){
                echo $_SESSION['add']; // Display message
                unset($_SESSION['add']); // Remove message
            }
        ?>

        <table class="tbl-full">
            <tr>
                <th>S.N.</th>
                <th>Title</th>
                <th>Price</th>
                <th>Image</th>
                <th>Featured</th>
                <th>Active</th>
                <th>Actions</th>
            </tr>

            <?php
                $sql = "SELECT * FROM tbl_food";
                $res = mysqli_query($conn, $sql);
                $count = mysqli_num_rows($res);
                $sn = 1;

                // Check whether we have data in the database or not
                if($count > 0) {
                    // We have data in the database
                    while($row = mysqli_fetch_assoc($res)) {
                        $id = $row['id'];
                        $tittle = $row['tittle'];
                        $price = $row['price'];
                        $image_name = $row['image_name'];
                        $featured = $row['feature'];
                        $active = $row['active'];
                        ?>

                        <tr>
                            <td><?php echo $sn++; ?></td>
                            <td><?php echo $tittle; ?></td>
                            <td><?php echo $price; ?></td>
                            <td>
                                <?php
                                // Check whether we have an image or not
                                if($image_name == "") {
                                    echo "<div class='error'>Image Not Added.</div>";
                                } else {
                                    ?>
                                    <img src="<?php echo SITEURL; ?>images/food/<?php echo $image_name; ?>" width="80px">
                                    <?php
                                }
                                ?>
                            </td>
                            <td><?php echo $featured; ?></td>
                            <td><?php echo $active; ?></td>
                            <td>
                                <a href="<?php echo SITEURL; ?>admin/update-food.php?id=<?php echo $id; ?>" class="btn-secondary">Update Food</a>
                                <a href="<?php echo SITEURL; ?>admin/delete-food.php?id=<?php echo $id; ?>&image_name=<?php echo $image_name; ?>" class="btn-danger">Delete Food</a>
                            </td>
                        </tr>
                        <?php
                    }
                } else {
                    // We do not have data in the database
                    ?>
                    <tr>
                        <td colspan="7"><div class="error">No Food Added.</div></td>
                    </tr>
                    <?php
                }
            ?>
        </table>
    </div>
</div>

<?php include('partials/footer.php'); ?>
