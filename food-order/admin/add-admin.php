<?php include('menu.php'); ?>
<div class="main">
    <div class="wrapper">
        <h1>Add Admin</h1>
        <br><br>
        <?php
           if(isset($_SESSION['add'])){
            echo $_SESSION['add'];//displaying session message
            unset($_SESSION['add']);//removing session message
           }
           ?>
        <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST">
            <table>
                <tr>
                    <td>Full name</td>
                    <td><input type="text" name="fullname" placeholder="Enter your fullname" required></td>
                </tr>
                <tr>
                    <td>Username</td>
                    <td><input type="text" name="username" placeholder="Enter your username" required></td>
                </tr>
                <tr>
                    <td>Password</td>
                    <td><input type="password" name="password" placeholder="Enter your password" required></td>
                </tr>
                <tr>
                    <td colspan="2">
                        <input type="submit" name="submit" value="Add Admin" class="btn-secondary">
                    </td>
                </tr>
            </table>
        </form>
    </div>
</div>

<?php include('footer.php'); ?>

<?php 
// Include database connection

// Process the form submission
if (isset($_POST['submit'])) {
    // Get the data from the form
    $fullname = isset($_POST['fullname']) ? $_POST['fullname'] : '';
    $username = isset($_POST['username']) ? $_POST['username'] : '';
    $password = isset($_POST['password']) ? md5($_POST['password']) : '';

    // SQL query to save the data into the database
    $sql = "INSERT INTO tbl_admin (Fullname, username, password) VALUES ('$fullname', '$username', '$password')";

    // Execute the query
    $res = mysqli_query($conn, $sql);

    // Check for query execution
    if ($res == TRUE) {
//now that the data is inserted ,we now create a session variable to display message 
 $_SESSION['add']= "Admin Added Successfully";
//Redirecting the page  to manage admin page
header("location:".SITEURL.'admin/manage-admin.php');
}
  else {

 $_SESSION['add']= "Failed to Add Admin";
//Redirecting the page  to manage admin page
header("location:".SITEURL.'admin/manage-admin.php')  ;  }

}
?>