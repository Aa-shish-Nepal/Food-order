<?php
include('../config/constants.php');
include('../CSS/admin.css');

//1.Getting id of admin to be deleted
$id=$_GET['id'];
//2. Create SQL Query to delete Admin
$sql="DELETE FROM tbl_admin WHERE id=$id;";
//Execute the query
$res=mysqli_query($conn,$sql);

//check whether query is executed successfully or not
if($res==true)
{
    //success   echo"Admin Deleted";
    //Create session variable to display above message in same webpage
    $_SESSION['delete']="<div class='success'>Admin Deleted Successfully</div>";    //Redirect to Manage Admin page
    header('location:'.SITEURL.'admin/manage-admin.php');

}
else{
    //failed echo"Failed to delete admin";
    $_SESSION['delete']="<div class='error'>Failed to delete admin</div>";
    header('location:'.SITEURL.'admin/manage-admin.php');


}
//3.Return to manage admin page with message(success/error)














?>