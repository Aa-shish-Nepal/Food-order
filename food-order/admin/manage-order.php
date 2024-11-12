<?php include('menu.php'); ?>

<div class="main">
    <div class="wrapper">
        <h1>Manage Orders</h1>
        <br><br>

        <?php
        // Display session messages if set
        if (isset($_SESSION['update'])) {
            echo $_SESSION['update'];
            unset($_SESSION['update']);
        }
        ?>
        <br><br>

        <table class="tbl-full">
            <tr>
                <th>SN</th>
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
                <th>Actions</th>
            </tr>

            <?php
            // Fetch all orders from the database
            $sql = "SELECT * FROM tbl_order ORDER BY id DESC";
            $res = mysqli_query($conn, $sql);

            // Check whether the query executed successfully
            if ($res == true) {
                $count = mysqli_num_rows($res);
                $sn = 1; // Serial number

                if ($count > 0) {
                    // Orders available, fetch each order
                    while ($row = mysqli_fetch_assoc($res)) {
                        $id = $row['id'];
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
                        ?>

                        <tr>
                            <td><?php echo $sn++; ?>.</td>
                            <td><?php echo $food; ?></td>
                            <td>$<?php echo number_format($price, 2); ?></td>
                            <td><?php echo $qty; ?></td>
                            <td>$<?php echo number_format($total, 2); ?></td>
                            <td><?php echo date('d-M-Y', strtotime($order_date)); ?></td>

                            <td>
                                <?php
                                // Display status with color coding
                                $status_color = "";
                                switch ($status) {
                                    case "Ordered":
                                        $status_color = "blue";
                                        break;
                                    case "On Delivery":
                                        $status_color = "orange";
                                        break;
                                    case "Delivered":
                                        $status_color = "green";
                                        break;
                                    case "Cancelled":
                                        $status_color = "red";
                                        break;
                                }
                                echo "<label style='color: $status_color;'>$status</label>";
                                ?>
                            </td>

                            <td><?php echo $customer_name; ?></td>
                            <td><?php echo $customer_contact; ?></td>
                            <td title="<?php echo $customer_email; ?>">
                                <?php echo (strlen($customer_email) > 20) ? substr($customer_email, 0, 20) . '...' : $customer_email; ?>
                            </td>
                            <td title="<?php echo $customer_address; ?>">
                                <?php echo (strlen($customer_address) > 30) ? substr($customer_address, 0, 30) . '...' : $customer_address; ?>
                            </td>
                            <td>
                                <a href="update-order.php?id=<?php echo $id; ?>" class="btn-secondary">Update</a>
                                <a href="delete-order.php?id=<?php echo $id; ?>" class="btn-danger" onclick="return confirm('Are you sure you want to delete this order?');">Delete</a>
                            </td>
                        </tr>

                        <?php
                    }
                } else {
                    // No orders found
                    echo "<tr><td colspan='12' class='error text-center'>No Orders Available.</td></tr>";
                }
            } else {
                echo "<tr><td colspan='12' class='error text-center'>Failed to Retrieve Orders.</td></tr>";
            }
            ?>
        </table>
        <br><br><br>
    </div>
</div>

<?php include('footer.php'); ?>
