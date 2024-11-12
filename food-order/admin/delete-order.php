<?php
// Include menu file for database connection and session handling
include('menu.php');

// Check if 'id' is set in the URL
if (isset($_GET['id'])) {
    // Get the ID of the order to be deleted
    $id = $_GET['id'];

    // Create SQL query to delete the order
    $sql = "DELETE FROM tbl_order WHERE id=$id";

    // Execute the query
    $res = mysqli_query($conn, $sql);

    // Check if the query executed successfully
    if ($res == true) {
        // Set success message in session
        $_SESSION['delete'] = "<div class='success'>Order Deleted Successfully.</div>";
    } else {
        // Set error message in session
        $_SESSION['delete'] = "<div class='error'>Failed to Delete Order. Try Again.</div>";
    }

    // Redirect to manage order page with the correct URL
    header('location:' . SITEURL . 'admin/manage-order.php');
} else {
    // Redirect to manage order page if 'id' is not set in the URL
    header('location:' . SITEURL . 'admin/manage-order.php');
}

?>
