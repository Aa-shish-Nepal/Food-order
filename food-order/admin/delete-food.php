<?php
include('../config/constants.php');

// 1. Check whether the id and image value are set or not
if (isset($_GET['id']) && isset($_GET['image_name'])) {
    
    // Get the id and image name values
    $id = $_GET['id'];
    $image_name = $_GET['image_name'];

    // Remove the physical image file if available
    if ($image_name != "") {
        $path = "../images/food/" . $image_name;
        $remove = unlink($path);

        // Check if the image was successfully removed
        if ($remove == false) {
            // Failed to remove image
            $_SESSION['remove'] = "<div class='error'>Failed to remove image</div>";
            header('location:' . SITEURL . 'admin/manage-food.php');
            die(); // Stop the process
        }
    }

    // Delete food from the database
    $sql = "DELETE FROM tbl_food WHERE id=$id";
    $res = mysqli_query($conn, $sql);

    // Check for success
    if ($res == true) {
        // Successfully deleted
        $_SESSION['remove-success'] = "<div class='success'>Successfully deleted</div>";
    } else {
        // Failed to delete
        $_SESSION['remove-failed'] = "<div class='error'>Failed to delete</div>";
    }
    
    // Redirect to manage-food page
    header('location:' . SITEURL . 'admin/manage-food.php');

} else {
    // If id and image values are not set, it's unauthorized access
    $_SESSION['delete'] = "<div class='error'>Unauthorized access</div>";
    // Redirect
    header('location:' . SITEURL . 'admin/manage-food.php');
}
?>
