<?php include('menu.php'); ?>

<?php
// First, check if ID is set; otherwise, unauthorized access
if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $sql2 = "SELECT * FROM tbl_food WHERE id=$id";
    $res2 = mysqli_query($conn, $sql2);

    if ($res2 && mysqli_num_rows($res2) > 0) {
        // Fetch data
        $row = mysqli_fetch_assoc($res2);
        $title = $row['title'];
        $description = $row['description'];
        $price = $row['price'];
        $current_image = $row['image_name'];
        $category = $row['category_id'];
        $featured = $row['featured'];
        $active = $row['active'];
    } else {
        // Redirect if food item not found
        header('location:' . SITEURL . 'admin/manage-food.php');
        exit();
    }
} else {
    header('location:' . SITEURL . 'admin/manage-food.php');
    exit();
}
?>

<div class="main">
    <div class="wrapper">
        <h1>Update Food</h1>
        <br><br>

        <!-- Create form -->
        <form action="" method="POST" enctype="multipart/form-data">
            <table class="tbl-30">
                <tr>
                    <td>Title</td>
                    <td>
                        <input type="text" name="title" value="<?php echo $title; ?>">
                    </td>
                </tr>

                <tr>
                    <td>Description</td>
                    <td>
                        <textarea name="description" cols="30" rows="5"><?php echo $description; ?></textarea>
                    </td>
                </tr>

                <tr>
                    <td>Price</td>
                    <td>
                        <input type="number" name="price" value="<?php echo $price; ?>">
                    </td>
                </tr>

                <tr>
                    <td>Current Image</td>
                    <td>
                        <?php
                        if ($current_image != "") {
                            echo "<img src='" . SITEURL . "images/food/" . $current_image . "' width='100px'><br>";
                        } else {
                            echo "<div class='error'>Image not added</div>";
                        }
                        ?>
                    </td>
                </tr>

                <tr>
                    <td>New Image</td>
                    <td>
                        <input type="file" name="image">
                    </td>
                </tr>

                <tr>
                    <td>Category</td>
                    <td>
                        <select name="category">
                            <?php
                            $sql = "SELECT * FROM tbl_category WHERE active='Yes'";
                            $res = mysqli_query($conn, $sql);
                            if ($res && mysqli_num_rows($res) > 0) {
                                while ($row = mysqli_fetch_assoc($res)) {
                                    $category_id = $row['id'];
                                    $category_title = $row['title'];
                                    echo "<option value='$category_id'" . ($category_id == $category ? " selected" : "") . ">$category_title</option>";
                                }
                            } else {
                                echo "<option value='0'>No Categories Found</option>";
                            }
                            ?>
                        </select>
                    </td>
                </tr>

                <tr>
                    <td>Featured:</td>
                    <td>
                        <input type="radio" name="featured" value="Yes" <?php if ($featured == "Yes") echo "checked"; ?>>Yes
                        <input type="radio" name="featured" value="No" <?php if ($featured == "No") echo "checked"; ?>>No
                    </td>
                </tr>

                <tr>
                    <td>Active:</td>
                    <td>
                        <input type="radio" name="active" value="Yes" <?php if ($active == "Yes") echo "checked"; ?>>Yes
                        <input type="radio" name="active" value="No" <?php if ($active == "No") echo "checked"; ?>>No
                    </td>
                </tr>

                <tr>
                    <td colspan="2">
                        <input type="submit" name="submit" value="Update Food" class="btn-secondary">
                    </td>
                </tr>
            </table>
        </form>

        <?php  
        // Check if the user has clicked the submit button
        if (isset($_POST['submit'])) {
            // 1. Get all the details from the form
            $title = $_POST['title'];
            $description = $_POST['description'];
            $price = $_POST['price'];
            $category = $_POST['category'];
            $featured = $_POST['featured'];
            $active = $_POST['active'];

            // 2. Handle image upload if a new image is selected
            if (isset($_FILES['image']['name']) && $_FILES['image']['name'] != "") {
                $image_name = $_FILES['image']['name'];
                $ext = end(explode('.', $image_name));
                $image_name = "Food_" . rand(000, 999) . '.' . $ext;

                $src_path = $_FILES['image']['tmp_name'];
                $dest_path = "../images/food/" . $image_name;

                // Upload new image
                $upload = move_uploaded_file($src_path, $dest_path);
                if ($upload == false) {
                    $_SESSION['upload'] = "<div class='error'>Failed to upload image.</div>";
                    header("location:" . SITEURL . "admin/manage-food.php");
                    exit();
                }

                // 3. Remove the current image if available
                if ($current_image != "") {
                    $remove_path = "../images/food/" . $current_image;
                    $remove = unlink($remove_path);
                    if ($remove == false) {
                        $_SESSION['remove-failed'] = "<div class='error'>Failed to remove current image.</div>";
                        header("location:" . SITEURL . "admin/manage-food.php");
                        exit();
                    }
                }
            } else {
                $image_name = $current_image;
            }

            // 4. Update the database
            $sql3 = "UPDATE tbl_food SET
                        title = '$title',
                        description = '$description',
                        price = $price,
                        image_name = '$image_name',
                        category_id = $category,
                        featured = '$featured',
                        active = '$active'
                     WHERE id = $id";

            $res3 = mysqli_query($conn, $sql3);

            if ($res3 == true) {
                $_SESSION['update'] = "<div class='success'>Food updated successfully.</div>";
                header("location:" . SITEURL . "admin/manage-food.php");
            } else {
                $_SESSION['update-failed'] = "<div class='error'>Failed to update food.</div>";
                header("location:" . SITEURL . "admin/manage-food.php");
            }
        }
        ?>
    </div>
</div>

<?php include('footer.php'); ?>
