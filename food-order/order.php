<?php include('partials-front/menu.php'); ?>

<?php 
// Check whether food_id is set or not
if (isset($_GET['food_id'])) {
    // Get the food id and details of the selected food
    $food_id = $_GET['food_id'];
    
    // Get details of the selected food from the database
    $sql = "SELECT * FROM tbl_food WHERE id=$food_id";
    $res = mysqli_query($conn, $sql);
    
    // Check whether the query executed successfully or not
    if ($res == true) {
        // Count the rows to check if the food is available
        $count = mysqli_num_rows($res);
        // If food is available, get the details
        if ($count == 1) {
            $row = mysqli_fetch_assoc($res);
            $title = $row['title'];
            $price = $row['price'];
            $image_name = $row['image_name'];
        } else {
            // Food not available, redirect to home page
            header('location:' . SITEURL);
        }
    }
} else {
    // Redirect to home page if food_id is not set
    header('location:' . SITEURL);
}
?>

<!-- fOOD sEARCH Section Starts Here -->
<section class="food-search">
    <div class="container">
        
        <h2 class="text-center text-white">Fill this form to confirm your order.</h2>

        <form action="" method="POST" class="order">
            <fieldset>
                <legend>Selected Food</legend>

                <div class="food-menu-img">
                    <?php 
                    // Check if image is available
                    if ($image_name != "") {
                        // Image available
                        ?>
                        <img src="<?php echo SITEURL; ?>images/food/<?php echo $image_name; ?>" alt="<?php echo $title; ?>" class="img-responsive img-curve">
                        <?php
                    } else {
                        // Image not available
                        echo "<div class='error'>Image not available.</div>";
                    }
                    ?>
                </div>

                <div class="food-menu-desc">
                    <h3><?php echo $title; ?></h3>
                    <p class="food-price">$<?php echo $price; ?></p>

                    <div class="order-label">Quantity</div>
                    <input type="number" name="qty" class="input-responsive" value="1" required>
                    
                </div>

            </fieldset>
            
            <fieldset>
                <legend>Delivery Details</legend>
                <div class="order-label">Full Name</div>
                <input type="text" name="full_name" placeholder="E.g. John Doe" class="input-responsive" required>

                <div class="order-label">Phone Number</div>
                <input type="tel" name="contact" placeholder="E.g. 9876543210" class="input-responsive" required>

                <div class="order-label">Email</div>
                <input type="email" name="email" placeholder="E.g. email@example.com" class="input-responsive" required>

                <div class="order-label">Address</div>
                <textarea name="address" rows="5" placeholder="E.g. Street, City, Country" class="input-responsive" required></textarea>

                <input type="submit" name="submit" value="Confirm Order" class="btn btn-primary">
            </fieldset>

        </form>

        <?php
        // Check if the form is submitted
        if (isset($_POST['submit'])) {
            // Get all the details from the form
            $qty = $_POST['qty'];
            $total = $price * $qty; // Total price = price x qty
            $order_date = date("Y-m-d H:i:s"); // Order date
            $status = "Ordered"; // Status of the order
            $customer_name = $_POST['full_name'];
            $customer_contact = $_POST['contact'];
            $customer_email = $_POST['email'];
            $customer_address = $_POST['address'];
            
            // Save the order in the database
            $sql2 = "INSERT INTO tbl_order SET 
                food = '$title',
                price = $price,
                qty = $qty,
                total = $total,
                order_date = '$order_date',
                status = '$status',
                customer_name = '$customer_name',
                customer_contact = '$customer_contact',
                customer_email = '$customer_email',
                customer_address = '$customer_address'";
            
            // Execute the query
            $res2 = mysqli_query($conn, $sql2);
            
            // Check whether the query executed successfully or not
            if ($res2 == true) {
                // Order saved
                $_SESSION['order'] = "<div class='success'>Food Ordered Successfully.</div>";
                header('location:' . SITEURL);
            } else {
                // Failed to save order
                $_SESSION['order'] = "<div class='error'>Failed to Order Food.</div>";
                header('location:' . SITEURL);
            }
        }
        ?>
    </div>
</section>
<!-- fOOD sEARCH Section Ends Here -->

<?php include('partials-front/footer.php'); ?>
