<?php include('partials-front/menu.php'); ?>


    <!-- Food Search Section Starts Here -->
    <section class="food-search text-center">
        <div class="container">
            <?php
            // Get the search keyword
            $search = isset($_POST['search']) ? $_POST['search'] : '';
            ?>
            <h2>Foods on Your Search: <span class="text-white">"<?php echo htmlspecialchars($search); ?>"</span></h2>
        </div>
    </section>
    <!-- Food Search Section Ends Here -->

    <!-- Food Menu Section Starts Here -->
    <section class="food-menu">
        <div class="container">
            <h2 class="text-center">Food Menu</h2>
            <?php
            // Database connection
            include('config/constants.php');

            // Query to search for foods based on the search keyword
            $sql = "SELECT * FROM tbl_food WHERE title LIKE '%$search%' OR description LIKE '%$search%'";
            $res = mysqli_query($conn, $sql);

            // Check if any food is available
            if ($res && mysqli_num_rows($res) > 0) {
                while ($row = mysqli_fetch_assoc($res)) {
                    // Get food details
                    $id = $row['id'];
                    $title = $row['title'];
                    $price = $row['price'];
                    $description = $row['description'];
                    $image_name = $row['image_name'];
                    ?>
                    <div class="food-menu-box">
                        <div class="food-menu-img">
                            <?php
                            if ($image_name == "") {
                                echo "<div class='error'>Image not available</div>";
                            } else {
                                ?>
                                <img src="images/food/<?php echo $image_name; ?>" alt="<?php echo htmlspecialchars($title); ?>" class="img-responsive img-curve">
                                <?php
                            }
                            ?>
                        </div>

                        <div class="food-menu-desc">
                            <h4><?php echo htmlspecialchars($title); ?></h4>
                            <p class="food-price">$<?php echo number_format($price, 2); ?></p>
                            <p class="food-detail"><?php echo htmlspecialchars($description); ?></p>
                            <br>
                            <a href="order.php?food_id=<?php echo $id; ?>" class="btn btn-primary">Order Now</a>
                        </div>
                    </div>
                    <?php
                }
            } else {
                // Food not found
                echo "<div class='error'>Food not found</div>";
            }
            ?>
            <div class="clearfix"></div>
        </div>
    </section>
    <!-- Food Menu Section Ends Here -->
    <?php include('partials-front/footer.php'); ?>

