<?php include('menu.php'); ?>

<div class="main">
    <div class="wrapper">
        <h1>Add Food</h1>
        <br><br>

        <?php
        if(isset($_SESSION['add'])){
            echo $_SESSION['add'];
            unset($_SESSION['add']);
        }
        if(isset($_SESSION['upload'])){
            echo $_SESSION['upload'];
            unset($_SESSION['upload']);
        }
        ?>
        <form action="" method="POST" enctype="multipart/form-data">
            <table class="tbl-30">
                <tr>
                    <td>Title</td>
                    <td>
                        <input type="text" name="title" placeholder="Title of food">
                    </td>
                </tr>

                <tr>
                    <td>Description</td>
                    <td>
                        <textarea name="description" cols="30" rows="5" placeholder="Enter description of the food"></textarea>
                    </td>
                </tr>

                <tr>
                    <td>Price</td>
                    <td>
                        <input type="number" name="price">
                    </td>
                </tr>

                <tr>
                    <td>Select Image</td>
                    <td>
                        <input type="file" name="image">
                    </td>
                </tr>

                <tr>
                    <td>Category</td>
                    <td>
                        <select name="category">
                            <?php
                            // Create SQL to get all active categories from database
                            $sql = "SELECT * FROM tbl_category WHERE active='Yes'";
                            $res = mysqli_query($conn, $sql);

                            // Check if there are categories
                            $count = mysqli_num_rows($res);
                            if ($count > 0) {
                                while ($row = mysqli_fetch_assoc($res)) {
                                    $id = $row['id'];
                                    $title = $row['title'];
                                    ?>
                                    <option value="<?php echo $id; ?>"><?php echo $title; ?></option>
                                    <?php
                                }
                            } else {
                                ?>
                                <option value="0">No Categories Found</option>
                                <?php
                            }
                            ?>
                        </select>
                    </td>
                </tr>

                <tr>
                    <td>Featured:</td>
                    <td>
                        <input type="radio" name="featured" value="Yes">Yes
                        <input type="radio" name="featured" value="No">No
                    </td>
                </tr>

                <tr>
                    <td>Active:</td>
                    <td>
                        <input type="radio" name="active" value="Yes">Yes
                        <input type="radio" name="active" value="No">No
                    </td>
                </tr>

                <tr>
                    <td colspan="2">
                        <input type="submit" name="submit" value="Add Food" class="btn-secondary">
                    </td>
                </tr>
            </table>
        </form>

        <?php
        // Check if the form is submitted
        if (isset($_POST['submit'])) {
            // Get data from form fields
            $title = $_POST['title'];
            $description = $_POST['description'];
            $price = $_POST['price'];
            $category = $_POST['category'];
            $featured = isset($_POST['featured']) ? $_POST['featured'] : "No";
            $active = isset($_POST['active']) ? $_POST['active'] : "No";

            // Check if an image is uploaded
            if (isset($_FILES['image']['name']) && $_FILES['image']['name'] != "") {
                // Get the file name
                $image_name = $_FILES['image']['name'];
                
                // Split the file name to get the extension
                $image_parts = explode('.', $image_name);
                $ext = end($image_parts);

                // Rename the image file to avoid overwriting and ensure uniqueness
                $image_name = "Food_Name_" . rand(0000, 9999) . "." . $ext;

                // Image upload path
                $source_path = $_FILES['image']['tmp_name'];
                $destination_path = "../images/food/" . $image_name;

                // Attempt to upload the image
                $upload = move_uploaded_file($source_path, $destination_path);

                // Check if the image was successfully uploaded
                if ($upload == false) {
                    // Failed to upload image
                    $_SESSION['upload'] = "Failed to upload image.";
                    header("location:" . SITEURL . "admin/add-food.php");
                    die();
                }
            } else {
                // No image was selected
                $image_name = "";
            }

            // Insert data into the database
            $sql = "INSERT INTO tbl_food SET 
                title = '$title',
                description = '$description',
                price = $price,
                image_name = '$image_name',
                category_id = $category,
                featured = '$featured',
                active = '$active'
            ";

            // Execute the query
            $res = mysqli_query($conn, $sql);

            // Check if data insertion was successful
            if ($res == true) {
                // Data inserted successfully
                $_SESSION['add'] = "Food added successfully.";
                header('location:' . SITEURL . 'admin/manage-food.php');
            } else {
                // Failed to insert data
                $_SESSION['add'] = "Failed to add food.";
                header('location:' . SITEURL . 'admin/add-food.php');
            }
        }
        ?>

    </div>
</div>

<?php include('footer.php'); ?>
