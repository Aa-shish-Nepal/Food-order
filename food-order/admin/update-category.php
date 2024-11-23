<?php include('menu.php'); ?>

<div class="main">
<div class="wrapper">
<h1>Update Category</h1>
<br><br>
<?php
//check whether the id is set or not
if (isset($_GET['id'])) {
    //get id and all other details
    $id = $_GET['id'];

    //create query to get all other details
    $sql = "SELECT * FROM tbl_category WHERE id=$id";
    $res = mysqli_query($conn, $sql);

    //counting the rows to check if the rows is valid or not
    $count = mysqli_num_rows($res);

    if ($count == 1) {
        //data is present so fetching it
        $row = mysqli_fetch_assoc($res); //stores all data in the form of row
        //getting individual data
        $title = $row['title'];
        $current_image = $row['image_name'];
        $featured = $row['featured'];
        $active = $row['active'];
    } else {
        //redirect to manage category with session message
        $_SESSION['no_category_found'] = "<div class='error'>Category not found.</div>";
        header("location:" . SITEURL . 'admin/manage-category.php');
    }
} else {
    //redirect to manage category
    header('location:' . SITEURL . 'admin/manage-category.php');
}
?>

<form action="" method="POST" enctype="multipart/form-data">
    <table class="tbl-30">
        <tr>
            <td>Title:</td>
            <td><input type="text" name="title" value="<?php echo $title; ?>"></td>
        </tr>
        
        <tr>
            <td>Current Image:</td>
            <td>
                <?php
                if ($current_image != "") {
                    //display the image
                    ?>
                    <img src="<?php echo SITEURL; ?>../images/category/<?php echo $current_image; ?>" width="150px">
                    <?php
                } else {
                    echo "<div class='error'>Image not added</div>";
                }
                ?>
            </td>
        </tr>
        
        <tr>
            <td>New Image:</td>
            <td>
                <input type="file" name="image">
            </td>
        </tr>

        <tr>
            <td>Featured:</td>
            <td>
                <input <?php if ($featured == "Yes") { echo "checked"; } ?> type="radio" name="featured" value="Yes">Yes
                <input <?php if ($featured == "No") { echo "checked"; } ?> type="radio" name="featured" value="No">No
            </td>
        </tr>
        <tr>
            <td>Active:</td>
            <td>
                <input <?php if ($active == "Yes") { echo "checked"; } ?> type="radio" name="active" value="Yes">Yes
                <input <?php if ($active == "No") { echo "checked"; } ?> type="radio" name="active" value="No">No
            </td>
        </tr>
        <tr>
            <td colspan="2">
                <input type="submit" name="submit" value="Update Category" class="btn-secondary">
                <input type="hidden" name="current_image" value="<?php echo $current_image; ?>">
                <input type="hidden" name="id" value="<?php echo $id; ?>">
            </td>
        </tr>
    </table>
</form>
</div></div>
<?php
if (isset($_POST['submit'])) {
    // Get all values from the form
    $id = $_POST['id'];
    $title = $_POST['title'];
    $current_image = $_POST['current_image'];
    $featured = $_POST['featured'];
    $active = $_POST['active'];
    
    // Check if a new image is selected
    if (isset($_FILES['image']['name']) && $_FILES['image']['name'] != "") {
        // New image selected; rename it
        $image_name = $_FILES['image']['name'];
        $ext = pathinfo($image_name, PATHINFO_EXTENSION);
        $image_name = "Food_Category_" . rand(000, 999) . '.' . $ext;
        $source_path = $_FILES['image']['tmp_name'];
        $destination_path = "../images/category/" . $image_name;

        // Upload the image
        if (move_uploaded_file($source_path, $destination_path) == false) {
            $_SESSION['update'] = "<div class='error'>Failed to upload image.</div>";
            header("location:" . SITEURL . 'admin/manage-category.php');
            exit();
        }

        // Remove the current image if available
        if ($current_image != "") {
            $remove_path = "../images/category/" . $current_image;
            if (file_exists($remove_path)) {
                unlink($remove_path);
            }
        }

        // Update the `$current_image` variable with the new image name
        $current_image = $image_name;
    }

    // Update the database with the new image name
    $sql2 = "UPDATE tbl_category SET 
                title='$title',
                image_name='$current_image', 
                featured='$featured',
                active='$active'
                WHERE id='$id'";

    // Execute the query
    $res2 = mysqli_query($conn, $sql2);

    // Redirect to manage category with a message
    if ($res2 == true) {
        $_SESSION['update'] = "<div class='success'>Category updated successfully</div>";
    } else {
        $_SESSION['update'] = "<div class='error'>Category update FAILED</div>";
    }
    header('location:' . SITEURL . 'admin/manage-category.php');
}
?>

<?php include('footer.php'); ?>
