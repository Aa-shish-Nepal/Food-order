<?php include('menu.php'); ?>

<div class="main">
    <div class="wrapper">
        <h1>Update Order</h1>
        <br><br>

        <?php
        // Check if 'id' is set in the URL
        if (isset($_GET['id'])) {
            $id = $_GET['id'];

            // Fetch order details from the database
            $sql = "SELECT * FROM tbl_order WHERE id=$id";
            $res = mysqli_query($conn, $sql);

            // Check if the query was successful
            if ($res == true) {
                $count = mysqli_num_rows($res);

                // Check if the order exists
                if ($count == 1) {
                    // Fetch order data
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
                    // Order not found, set the session message and redirect to manage orders
                    $_SESSION['update'] = "<div class='error'>Order Not Found.</div>";
                    header('location: ' . SITEURL . 'manageorder.php');
                    exit();
                }
            } else {
                // Database query failed, set the session message and redirect to manage orders
                $_SESSION['update'] = "<div class='error'>Failed to fetch order details.</div>";
                header('location: ' . SITEURL . 'admin/manage-order.php');
                exit();
            }
        } else {
            // Redirect to manage order page if id is not set
            header('location: ' . SITEURL . 'admin/manage-order.php');
            exit();
        }
        ?>

        <form action="" method="POST">
            <table class="tbl-30">
                <tr>
                    <td>Food Name:</td>
                    <td><b><?php echo $food; ?></b></td>
                </tr>

                <tr>
                    <td>Price:</td>
                    <td><b>$<?php echo number_format($price, 2); ?></b></td>
                </tr>

                <tr>
                    <td>Qty:</td>
                    <td>
                        <input type="number" name="qty" value="<?php echo $qty; ?>" required>
                    </td>
                </tr>

                <tr>
                    <td>Status:</td>
                    <td>
                        <select name="status">
                            <option <?php if ($status == "Ordered") echo "selected"; ?> value="Ordered">Ordered</option>
                            <option <?php if ($status == "On Delivery") echo "selected"; ?> value="On Delivery">On Delivery</option>
                            <option <?php if ($status == "Delivered") echo "selected"; ?> value="Delivered">Delivered</option>
                            <option <?php if ($status == "Cancelled") echo "selected"; ?> value="Cancelled">Cancelled</option>
                        </select>
                    </td>
                </tr>

                <tr>
                    <td>Customer Name:</td>
                    <td>
                        <input type="text" name="customer_name" value="<?php echo $customer_name; ?>" required>
                    </td>
                </tr>

                <tr>
                    <td>Contact:</td>
                    <td>
                        <input type="text" name="customer_contact" value="<?php echo $customer_contact; ?>" required>
                    </td>
                </tr>

                <tr>
                    <td>Email:</td>
                    <td>
                        <input type="email" name="customer_email" value="<?php echo $customer_email; ?>" required>
                    </td>
                </tr>

                <tr>
                    <td>Address:</td>
                    <td>
                        <textarea name="customer_address" rows="5" required><?php echo $customer_address; ?></textarea>
                    </td>
                </tr>

                <tr>
                    <td colspan="2">
                        <input type="hidden" name="id" value="<?php echo $id; ?>">
                        <input type="hidden" name="price" value="<?php echo $price; ?>">
                        <input type="submit" name="submit" value="Update Order" class="btn-secondary">
                    </td>
                </tr>
            </table>
        </form>

        <?php
        // Check if the form is submitted
        if (isset($_POST['submit'])) {
            // Get updated details from the form
            $id = $_POST['id'];
            $qty = $_POST['qty'];
            $price = $_POST['price'];
            $total = $price * $qty;
            $status = $_POST['status'];
            $customer_name = $_POST['customer_name'];
            $customer_contact = $_POST['customer_contact'];
            $customer_email = $_POST['customer_email'];
            $customer_address = $_POST['customer_address'];

            // Update the order in the database
            $sql2 = "UPDATE tbl_order SET 
                        qty = $qty, 
                        total = $total, 
                        status = '$status', 
                        customer_name = '$customer_name', 
                        customer_contact = '$customer_contact', 
                        customer_email = '$customer_email', 
                        customer_address = '$customer_address' 
                    WHERE id = $id";

            $res2 = mysqli_query($conn, $sql2);

            // Check if the update was successful
            if ($res2 == true) {
                $_SESSION['update'] = "<div class='success'>Order Updated Successfully.</div>";
            } else {
                $_SESSION['update'] = "<div class='error'>Failed to Update Order.</div>";
            }

            // Redirect to manage order page
            header('location: ' . SITEURL . 'admin/manage-order.php');
            exit();
        }
        ?>

    </div>
</div>

<?php include('footer.php'); ?>
