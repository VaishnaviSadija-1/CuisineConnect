<?php include('partials/menu.php'); ?>

<div class="main-content">
    <div class="wrapper">
        <h1>Manage Order</h1>

        <br><br>

        <!-- Button to Add Order -->
        
        <br><br><br>

        <?php 
            if(isset($_SESSION['add'])){
                echo $_SESSION['add']; // Display message
                unset($_SESSION['add']); // Remove message
            }
            if(isset($_SESSION['delete'])){
                echo $_SESSION['delete']; // Display message
                unset($_SESSION['delete']); // Remove message
            }
            if(isset($_SESSION['update'])){
                echo $_SESSION['update']; // Display message
                unset($_SESSION['update']); // Remove message
            }
        ?>

        <table class="tbl-full">
            <thead>
                <tr>
                    <th>S.N.</th>
                    <th>Food</th>
                    <th>Price</th>
                    <th>Quantity</th>
                    <th>Total</th>
                    <th>Order Date</th>
                    <th>Status</th>
                    <th>Customer Name</th>
                    <th>Contact</th>
                    <th>Email</th>
                    <th>Address</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php
                    // SQL Query to Get all Orders
                    $sql = "SELECT * FROM tbl_order ORDER BY id DESC";
                    // Execute Query
                    $res = mysqli_query($conn, $sql);
                    // Count Rows
                    $count = mysqli_num_rows($res);

                    $sn = 1; // Create a Serial Number and set its initial value as 1

                    // Check whether we have orders or not
                    if($count > 0) {
                        // Orders available
                        while($row = mysqli_fetch_assoc($res)) {
                            $id = $row['id'];
                            $food = $row['food'];
                            $price = $row['price'];
                            $qty = $row['qty'];
                            $total = $price*$qty;
                            $order_date = $row['order_date'];
                            $status = $row['status'];
                            $customer_name = $row['customer_name'];
                            $customer_contact = $row['customer_contact'];
                            $customer_email = $row['customer_email'];
                            $customer_address = $row['customer_address'];
                            ?>

                            <tr>
                                <td><?php echo $sn++; ?></td>
                                <td><?php echo htmlspecialchars($food); ?></td>
                                <td><?php echo htmlspecialchars($price); ?></td>
                                <td><?php echo htmlspecialchars($qty); ?></td>
                                <td><?php echo htmlspecialchars($total); ?></td> <!-- Displaying Total -->
                                <td><?php echo htmlspecialchars($order_date); ?></td>
                                <td><?php echo htmlspecialchars($status); ?></td>
                                <td><?php echo htmlspecialchars($customer_name); ?></td>
                                <td><?php echo htmlspecialchars($customer_contact); ?></td>
                                <td><?php echo htmlspecialchars($customer_email); ?></td>
                                <td><?php echo htmlspecialchars($customer_address); ?></td>
                                <td>
                                    <a href="<?php echo SITEURL; ?>admin/update-order.php?id=<?php echo $id; ?>" class="btn-secondary">Update Order</a>
                                    
                                </td>
                            </tr>

                            <?php
                        }
                    } else {
                        // No Orders Found
                        ?>
                        <tr>
                            <td colspan="12"><div class="error">No Orders Found.</div></td>
                        </tr>
                        <?php
                    }
                ?>
            </tbody>
        </table>
    </div>
</div>

<?php include('partials/footer.php'); ?>
