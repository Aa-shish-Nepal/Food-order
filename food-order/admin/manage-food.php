<?php include('menu.php'); ?>

<div class="main">
    <div class="wrapper">
        <h1>Manage Food</h1>
        <br><br>

        <?php 
        if (isset($_SESSION['add'])) {
            echo $_SESSION['add'];
            unset($_SESSION['add']);
        }
        
        if (isset($_SESSION['delete'])) {
            echo $_SESSION['delete'];
            unset($_SESSION['delete']);
        }

        if (isset($_SESSION['upload'])) {
            echo $_SESSION['upload'];
            unset($_SESSION['upload']);
        }

        if (isset($_SESSION['update'])) {
            echo $_SESSION['update'];
            unset($_SESSION['update']);
        }
        
        if (isset($_SESSION['remove'])) {
            echo $_SESSION['remove'];
            unset($_SESSION['remove']);
        }

        if(isset($_SESSION['remove-failed'])){
            echo($_SESSION['remove-failed']);
            unset($_SESSION['remove-failed']);
        }
        
        if(isset($_SESSION['delete'])){
            echo($_SESSION['delete']);
            unset($_SESSION['delete']);
        }

        if(isset($_SESSION['update-failed'])){
            echo($_SESSION['update-failed']);
            unset($_SESSION['update-failed']); 
        }
        ?>
        <br><br>

        <a href="<?php echo SITEURL; ?>admin/add-food.php" class="btn-primary">Add Food</a>

        <table class="tbl-full">
            <tr>
                <th>SN</th>
                <th>Title</th>
                <th>Description</th>
                <th>Price</th>
                <th>Image</th>
                <th>Category</th>
                <th>Featured</th>
                <th>Active</th>
                <th>Actions</th>
            </tr>

            <?php
            // Query to get all food items from the database
            $sql = "SELECT * FROM tbl_food";

            // Execute the query
            $res = mysqli_query($conn, $sql);

            // Count rows
            $count = mysqli_num_rows($res);

            // Serial number variable
            $sn = 1;

            // Check if there are food items in the database
            if ($count > 0) {
                // Food items exist in the database
                while ($row = mysqli_fetch_assoc($res)) {
                    $id = $row['id'];
                    $title = $row['title'];
                    $description = $row['description'];
                    $price = $row['price'];
                    $image_name = $row['image_name'];
                    $category_id = $row['category_id'];
                    $featured = $row['featured'];
                    $active = $row['active'];

                    ?>
                    <tr>
                        <td><?php echo $sn++; ?></td>
                        <td><?php echo $title; ?></td>
                        <td><?php echo $description; ?></td>
                        <td><?php echo $price; ?></td>
                        <td>
                            <?php 
                            // Check if an image is available
                            if ($image_name != "") {
                                // Display the image
                                ?>
                                <img src="<?php echo SITEURL; ?>images/food/<?php echo $image_name; ?>" width="100px">
                                <?php
                            } else {
                                // Display message if no image is found
                                echo "<div class='error'>Image not available</div>";
                            }
                            ?>
                        </td>
                        <td><?php echo $category_id; ?></td>
                        <td><?php echo $featured; ?></td>
                        <td><?php echo $active; ?></td>
                        <td>
                            <a href="<?php echo SITEURL; ?>admin/update-food.php?id=<?php echo $id; ?>" class="btn-secondary">Update Food</a>
                            &nbsp;
                            <a href="<?php echo SITEURL; ?>admin/delete-food.php?id=<?php echo $id; ?>&image_name=<?php echo $image_name; ?>" class="btn-danger">Delete Food</a>
                        </td>
                    </tr>
                    <?php
                }
            } else {
                // No food items found in the database
                ?>
                <tr>
                    <td colspan="9"><div class="error">No food items added</div></td>
                </tr>
                <?php
            }
            ?>
        </table>
        <br><br><br>
    </div>
</div>

<?php include('footer.php'); ?>
