<?php
include('../config/constants.php');

// Enable error reporting
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Start session if not already started in constants.php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// 1. Check whether the id and image value are set or not
if (isset($_GET['id']) && isset($_GET['image_name'])) {
    // Get the value and delete
    $id = $_GET['id'];
    $image_name = $_GET['image_name'];

    // 2. Remove the physical image file if available
    if ($image_name != "") {
        // Image is available, so remove it
        $path = "../images/category/" . $image_name;

        // Attempt to remove the image
        if (unlink($path) === false) {
            // Set the session message if image removal fails
            $_SESSION['remove'] = "<div class='error'>Failed to remove category image.</div>";
        }
    }

    // 3. Delete data from the database
    $sql = "DELETE FROM tbl_category WHERE id=$id";

    // Execute the query
    $res = mysqli_query($conn, $sql);

    // 4. Check whether the data is deleted from the database or not
    if ($res == true) {
        // Redirect to manage category page with success message
        $_SESSION['delete'] = "<div class='success'>Category Deleted Successfully</div>";
    } else {
        $_SESSION['delete'] = "<div class='error'>Failed to delete category. Error: " . mysqli_error($conn) . "</div>";
    }

    // Redirect to manage category
    header("location:" . SITEURL . 'admin/manage-category.php');
} else {
    // Redirect to manage category page
    header("location:" . SITEURL . 'admin/manage-category.php');
}
?>
