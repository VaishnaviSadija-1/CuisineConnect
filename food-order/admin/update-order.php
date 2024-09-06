<?php include('partials/menu.php'); ?>

<div class="main-content">
    <div class="wrapper">
        <h1>Update Order</h1>

        <br><br>

        <?php
        // Check if the ID is set
        if(isset($_GET['id'])){
            // Get the ID and fetch order details
            $id = $_GET['id'];
            // Create SQL query to get the order details
            $sql = "SELECT * FROM tbl_order WHERE id=$id";
            $res = mysqli_query($conn, $sql);
            $count = mysqli_num_rows($res);

            if($count == 1) {
                // Order found, get the details
                $row = mysqli_fetch_assoc($res);
                $food = $row['food'];
                $price = $row['price'];
                $qty = $row['qty'];
                $total = $row['total'];
                $order_date = $row['order_date'];
                $status = $row['status'];
                $customer_name = $row['customer_name'];
                $customer_contact = $row['customer_contact'];
                $customer_email = $row['customer_email'];
                $customer_address = $row['customer_address'];
            } else {
                // Order not found, redirect to manage order page with an error message
                $_SESSION['no-order-found'] = "<div class='error'>Order Not Found</div>";
                header('location:'.SITEURL.'admin/manage-order.php');
            }
        } else {
            // Redirect to manage order page
            header('location:'.SITEURL.'admin/manage-order.php');
        }
        ?>

        <form action="" method="POST">
            <table class="tbl-40">
                <tr>
                    <td>Food: </td>
                    <td><input type="text" name="food" value="<?php echo htmlspecialchars($food); ?>"></td>
                </tr>
                <tr>
                    <td>Price: </td>
                    <td><input type="text" name="price" value="<?php echo htmlspecialchars($price); ?>"></td>
                </tr>
                <tr>
                    <td>Quantity: </td>
                    <td><input type="number" name="qty" value="<?php echo htmlspecialchars($qty); ?>"></td>
                </tr>
                <tr>
                    <td>Total: </td>
                    <td><input type="text" name="total" value="<?php echo htmlspecialchars($total); ?>"></td>
                </tr>
                <tr>
                    <td>Order Date: </td>
                    <td><input type="datetime-local" name="order_date" value="<?php echo htmlspecialchars($order_date); ?>"></td>
                </tr>
                <tr>
                    <td>Status: </td>
                    <td>
                        <select name="status">
                            <option <?php if($status == "Ordered"){echo "selected";} ?> value="Ordered">Ordered</option>
                            <option <?php if($status == "On Delivery"){echo "selected";} ?> value="On Delivery">On Delivery</option>
                            <option <?php if($status == "Delivered"){echo "selected";} ?> value="Delivered">Delivered</option>
                            <option <?php if($status == "Cancelled"){echo "selected";} ?> value="Cancelled">Cancelled</option>
                        </select>
                    </td>
                </tr>
                <tr>
                    <td>Customer Name: </td>
                    <td><input type="text" name="customer_name" value="<?php echo htmlspecialchars($customer_name); ?>"></td>
                </tr>
                <tr>
                    <td>Customer Contact: </td>
                    <td><input type="text" name="customer_contact" value="<?php echo htmlspecialchars($customer_contact); ?>"></td>
                </tr>
                <tr>
                    <td>Customer Email: </td>
                    <td><input type="email" name="customer_email" value="<?php echo htmlspecialchars($customer_email); ?>"></td>
                </tr>
                <tr>
                    <td>Customer Address: </td>
                    <td><textarea name="customer_address" cols="30" rows="5"><?php echo htmlspecialchars($customer_address); ?></textarea></td>
                </tr>
                <tr>
                    <td colspan="2">
                        <input type="hidden" name="id" value="<?php echo $id; ?>">
                        <input type="submit" name="submit" value="Update Order" class="btn-secondary">
                    </td>
                </tr>
            </table>
        </form>

        <?php
        if(isset($_POST['submit'])) {
            // Get all the details from the form
            $id = $_POST['id'];
            $food = $_POST['food'];
            $price = $_POST['price'];
            $qty = $_POST['qty'];
            $total = $_POST['total'];
            $order_date = $_POST['order_date'];
            $status = $_POST['status'];
            $customer_name = $_POST['customer_name'];
            $customer_contact = $_POST['customer_contact'];
            $customer_email = $_POST['customer_email'];
            $customer_address = $_POST['customer_address'];

            // Update the order in the database
            $sql2 = "UPDATE tbl_order SET 
                food = '$food',
                price = '$price',
                qty = '$qty',
                total = '$total',
                order_date = '$order_date',
                status = '$status',
                customer_name = '$customer_name',
                customer_contact = '$customer_contact',
                customer_email = '$customer_email',
                customer_address = '$customer_address'
                WHERE id=$id
            ";

            $res2 = mysqli_query($conn, $sql2);

            if($res2 == true) {
                // Order updated
                $_SESSION['update'] = "<div class='success'>Order Updated Successfully.</div>";
                header('location:'.SITEURL.'admin/manage-order.php');
            } else {
                // Failed to update order
                $_SESSION['update'] = "<div class='error'>Failed to Update Order.</div>";
                header('location:'.SITEURL.'admin/manage-order.php');
            }
        }
        ?>

    </div>
</div>

<?php include('partials/footer.php'); ?>
