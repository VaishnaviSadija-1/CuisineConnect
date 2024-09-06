<?php include('partials/menu.php'); ?>

<!-- Main Content Section Starts -->
<div class="main-content">
    <div class="wrapper">
        <h1>Dashboard</h1>

        <?php 
            if(isset($_SESSION['login'])){
                echo $_SESSION['login']; // Display message
                unset($_SESSION['login']); // Remove message
            }
        ?>
        <br><br>

        <div class="col-4 text-center">
            <h1>
                <?php 
                    // SQL query to get the number of categories
                    $sql = "SELECT COUNT(*) AS count FROM tbl_category";
                    $res = mysqli_query($conn, $sql);
                    $row = mysqli_fetch_assoc($res);
                    echo $row['count'];
                ?>
            </h1>
            <br>
            Categories
        </div>

        <div class="col-4 text-center">
            <h1>
                <?php 
                    // SQL query to get the number of food items
                    $sql2 = "SELECT COUNT(*) AS count FROM tbl_food";
                    $res2 = mysqli_query($conn, $sql2);
                    $row2 = mysqli_fetch_assoc($res2);
                    echo $row2['count'];
                ?>
            </h1>
            <br>
            Food Items
        </div>

        <div class="col-4 text-center">
            <h1>
                <?php 
                    // SQL query to get the number of orders
                    $sql3 = "SELECT COUNT(*) AS count FROM tbl_order";
                    $res3 = mysqli_query($conn, $sql3);
                    $row3 = mysqli_fetch_assoc($res3);
                    echo $row3['count'];
                ?>
            </h1>
            <br>
            Total Orders
        </div>

        <div class="col-4 text-center">
            <h1>
                <?php 
                    // SQL query to calculate the total revenue
                    $sql4 = "SELECT SUM(total) AS total FROM tbl_order WHERE status='Delivered'";
                    $res4 = mysqli_query($conn, $sql4);
                    $row4 = mysqli_fetch_assoc($res4);
                    echo '$'.$row4['total'];
                ?>
            </h1>
            <br>
            Revenue Generated
        </div>

        <div class="clearfix"></div>

        <br><br>

        <h2>Recent Orders</h2>
        <table class="tbl-full">
            <tr>
                <th>S.N.</th>
                <th>Food</th>
                <th>Price</th>
                <th>Qty</th>
                <th>Total</th>
                <th>Order Date</th>
                <th>Status</th>
                <th>Customer Name</th>
                <th>Contact</th>
                <th>Email</th>
                <th>Address</th>
            </tr>

            <?php 
                // SQL query to get the recent 10 orders
                $sql5 = "SELECT * FROM tbl_order ORDER BY id DESC LIMIT 10";
                $res5 = mysqli_query($conn, $sql5);
                $count5 = mysqli_num_rows($res5);
                $sn = 1; // Serial number variable

                if($count5 > 0){
                    while($row5 = mysqli_fetch_assoc($res5)){
                        $id = $row5['id'];
                        $food = $row5['food'];
                        $price = $row5['price'];
                        $qty = $row5['qty'];
                        $total = $price*$qty;
                        $order_date = $row5['order_date'];
                        $status = $row5['status'];
                        $customer_name = $row5['customer_name'];
                        $customer_contact = $row5['customer_contact'];
                        $customer_email = $row5['customer_email'];
                        $customer_address = $row5['customer_address'];

                        ?>
                        <tr>
                            <td><?php echo $sn++; ?>.</td>
                            <td><?php echo $food; ?></td>
                            <td><?php echo $price; ?></td>
                            <td><?php echo $qty; ?></td>
                            <td><?php echo $total; ?></td>
                            <td><?php echo $order_date; ?></td>
                            <td><?php echo $status; ?></td>
                            <td><?php echo $customer_name; ?></td>
                            <td><?php echo $customer_contact; ?></td>
                            <td><?php echo $customer_email; ?></td>
                            <td><?php echo $customer_address; ?></td>
                        </tr>
                        <?php
                    }
                } else {
                    echo "<tr><td colspan='11' class='error'>Orders not Available</td></tr>";
                }
            ?>
        </table>

    </div>
    
</div>
<!-- Main Content Section Ends -->

<?php include('partials/footer.php'); ?>
