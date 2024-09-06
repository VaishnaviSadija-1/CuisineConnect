<?php include('partials-front/menu.php'); ?>

    <!-- fOOD sEARCH Section Starts Here -->
    <section class="food-search text-center">
        <div class="container">

            <?php
                $search = $_POST['search'];

            ?>
            
            <h2>Foods on Your Search <a href="#" class="text-white"><?php echo $search; ?></a></h2>

        </div>
    </section>
    <!-- fOOD sEARCH Section Ends Here -->



    <!-- fOOD MEnu Section Starts Here -->
    <section class="food-menu">
        <div class="container">
            <h2 class="text-center">Food Menu</h2>
            <?php



            //sql query to get food based on search
            $sql = "SELECT * from tbl_food WHERE tittle LIKE '%$search%' OR  description LIKE '%$search%'";

            $res = mysqli_query($conn, $sql);

            $count = mysqli_num_rows($res);

            //check weather food is avilable or not

            if($count > 0) {
                //food avilable
                while($row = mysqli_fetch_assoc($res)){
                    //get the details
                    $id = $row['id'];
                    $tittle = $row['tittle'];
                    $price = $row['price'];
                    $description = $row['description'];
                    $image_name = $row['image_name'];
                    ?>
                <div class="food-menu-box">
                    <div class="food-menu-img">

                        <?php 
                            if($image_name == "") {
                                echo " <div class='error'> Image not Avilable </div>";
                            }

                            else{

                                ?>

                                <img src="<?php echo SITEURL;?>images/food/<?php echo $image_name; ?>" alt="Pizza" class="img-responsive img-curve">

                                <?php

                            }
                                    
                                    
                        ?>
                    </div>

                     <div class="food-menu-desc">
                    <h4><?php echo $tittle; ?></h4>
                    <p class="food-price"><?php echo $price; ?></p>
                    <p class="food-detail">
                        <?php echo $description; ?>
                    </p>
                    <br>

                    <a href="<?php echo SITEURL; ?>order.php?food_id=<?php echo $id; ?>" class="btn btn-primary">Order Now</a>
                </div>
            </div>

                    

                    <?php

                }
            }

            else{
                //food not avilable
                echo "<div class='error'>Food Not Found</div>";
            }

            ?>


            <div class="clearfix"></div>

            

        </div>

    </section>
    <!-- fOOD Menu Section Ends Here -->

    <!-- social Section Starts Here -->


    <?php include('partials-front/footer.php'); ?>