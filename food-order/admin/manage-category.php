<?php include('menu.php'); ?>
<div class="main">
    <div class="wrapper">
        <h1>Manage Category</h1><br><br>
        <?php 
        if(isset($_SESSION['add'])) {
            echo $_SESSION['add'];
            unset($_SESSION['add']);
        }

        if(isset($_SESSION['remove'])){
            echo $_SESSION['remove'];
            unset($_SESSION['remove']);

        }

        if(isset($_SESSION['delete'])){
            echo $_SESSION['delete'];
            unset($_SESSION['delete']);

        }
        if(isset($_SESSION['no_category_found'])){
            echo $_SESSION['no_category_found'];
            unset($_SESSION['no_category_found']);

        }
        if(isset($_SESSION['update'])){
            echo $_SESSION['update'];
            unset($_SESSION['update']);

        }

        ?><br><br>
        <a href="<?php echo SITEURL; ?>admin/add-category.php" class="btn-primary">Add Category</a>

        <table class="tbl-full ">
            <tr>
                <th>SN</th>
                <th>Title</th>
                <th>Image</th>
                <th>Featured</th>
                <th>Active</th>
                <th>Actions</th>
            </Dtr>

            <?php
            // Query to get all categories from the database
            $sql = "SELECT * FROM tbl_category";

            // Execute the query
            $res = mysqli_query($conn, $sql);

            // Count rows
            $count = mysqli_num_rows($res);

            // Create serial value as 1
            $sn = 1;

            // Check whether we have data in the database or not
            if($count > 0) {
                // We have data in the database so we fetch and display it
                while($row = mysqli_fetch_assoc($res)) {
                    $id = $row['id'];
                    $title = $row['title']; // Make sure to fetch title
                    $image_name = $row['image_name'];
                    $featured = $row['featured'];
                    $active = $row['active'];
                    ?>
                    <tr>
                        <td><?php echo $sn++; ?></td>
                        <td><?php echo $title; ?></td>
                        <td>
                            <?php
                            // Check whether image name is available or not
                            if($image_name != "") {
                                // Display the image
                                ?>
                                <img src="<?php echo SITEURL; ?>images/category/<?php echo $image_name; ?>" width="100px">
                                <?php
                            } else {
                                // Display the message
                                echo "<div class='error'>Image not Added</div>";
                            }
                            ?>
                        </td>
                        <td><?php echo $featured; ?></td>
                        <td><?php echo $active; ?></td>
                        <td>
                            <a href="<?php echo SITEURL;?>admin/update-category.php?id=<?php echo $id;?>" class="btn-secondary">Update Category</a>&nbsp;
                            <a href="<?php echo SITEURL;?>admin/delete-category.php?id=<?php echo $id;?>&image_name=<?php echo $image_name;?>" class="btn-danger">Delete Category</a>
                        </td>
                    </tr>
                    <?php
                }
            } else {
                // We don't have data so display error message
                ?>
                <tr>
                    <td colspan="6"><div class="error">No categories added</div></td>
                </tr>
                <?php
            }
            ?>
        </table><br><br><br>
    </div>
</div>
<?php include('footer.php'); ?>
