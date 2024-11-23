<?php include('partials-front/menu.php'); ?>

<?php 
if (isset($_GET['category_id'])) {
    // Get category ID
    $category_id = $_GET['category_id'];

    // SQL query to get category title
    $sql = "SELECT title FROM tbl_category WHERE id = $category_id";
    $res = mysqli_query($conn, $sql);

    // Check if the query returned a result
    if ($res && mysqli_num_rows($res) > 0) {
        $row = mysqli_fetch_assoc($res);
        $category_title = $row['title'];
    } else {
        header('location:' . SITEURL);
        exit();
    }
} else {
    header('location:' . SITEURL);
    exit();
}
?>

<!-- Food Search Section Starts Here -->
<section class="food-search text-center">
    <div class="container">
        <h2>Foods on <a href="#" class="text-white">"<?php echo htmlspecialchars($category_title); ?>"</a></h2>
    </div>
</section>
<!-- Food Search Section Ends Here -->

<!-- Food Menu Section Starts Here -->
<section class="food-menu">
    <div class="container">
        <h2 class="text-center">Food Menu</h2>
        <?php 
        // SQL query to get foods based on category
        $sql2 = "SELECT * FROM tbl_food WHERE category_id = $category_id";
        $res2 = mysqli_query($conn, $sql2);

        // Check if any foods are available
        if ($res2 && mysqli_num_rows($res2) > 0) {
            while ($row2 = mysqli_fetch_assoc($res2)) {
                $title = $row2['title'];
                $price = $row2['price'];
                $description = $row2['description'];
                $image_name = $row2['image_name'];
                ?>
                
                <div class="food-menu-box">
                    <div class="food-menu-img">
                        <?php 
                        // Check if image is available
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
                        <a href="order.php?food_id=<?php echo $row2['id']; ?>" class="btn btn-primary">Order Now</a>
                    </div>
                </div>
                <?php
            }
        } else {
            // No food available
            echo "<div class='error'>Food not available</div>";
        }
        ?>
        <div class="clearfix"></div>
    </div>
</section>
<!-- Food Menu Section Ends Here -->
<?php include('partials-front/footer.php'); ?>


