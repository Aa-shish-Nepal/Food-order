
<?php include('partials-front/menu.php'); ?>

    <!-- Food Search Section Starts Here -->
    <section class="food-search text-center">
        <div class="container">
            <form action="food-search.php" method="POST">
                <input type="search" name="search" placeholder="Search for Food.." required>
                <input type="submit" name="submit" value="Search" class="btn btn-primary">
            </form>
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

            // Query to fetch active and featured foods
            $sql = "SELECT * FROM tbl_food WHERE active='Yes' AND featured='Yes'";
            $res = mysqli_query($conn, $sql);

            // Check if foods are available
            if (mysqli_num_rows($res) > 0) {
                while ($row = mysqli_fetch_assoc($res)) {
                    $food_id = $row['id'];
                    $food_title = $row['title'];
                    $food_price = $row['price'];
                    $food_description = $row['description'];
                    $food_image_name = $row['image_name'];
                    ?>

                    <div class="food-menu-box">
                        <div class="food-menu-img">
                            <?php
                            if ($food_image_name == "") {
                                echo "<div class='error'>Image not available</div>";
                            } else {
                                ?>
                                <img src="images/food/<?php echo $food_image_name; ?>" alt="<?php echo $food_title; ?>" class="img-responsive img-curve">
                                <?php
                            }
                            ?>
                        </div>

                        <div class="food-menu-desc">
                            <h4><?php echo $food_title; ?></h4>
                            <p class="food-price">$<?php echo $food_price; ?></p>
                            <p class="food-detail"><?php echo $food_description; ?></p>
                            <br>
                            <a href="order.php?food_id=<?php echo $food_id; ?>" class="btn btn-primary">Order Now</a>
                        </div>
                    </div>

                    <?php
                }
            } else {
                echo "<div class='error'>Food not available</div>";
            }
            ?>

            <div class="clearfix"></div>
        </div>
    </section>
    <!-- Food Menu Section Ends Here -->
    <?php include('partials-front/footer.php'); ?>

