<?php include('menu.php');?>
<div class="main">
    <div class="wrapper">
        <h1>Change password</h1>
        <br><br>
        <?php
        if(isset($_GET['id'])){

        $id=$_GET['id'];
        }
        ?>

        <form action="" method="POST">
            <table class="tbl-30">
                <tr>
                    <td>Old password:</td>
                    <td>
                        <input type="password" name="current_password" placeholder="old password">

                    </td>
                </tr>
                <tr>
                    <td>New password:</td>
                    <td>
                        <input type="password" name="new_password" placeholder="new password">

                    </td>
                </tr>
                <tr>
                    <td>Confirm password:</td>
                    <td>
                        <input type="password" name="confirm_password" placeholder="confirm password">

                    </td>
                </tr>
                <tr><td colspan="2">
                    <input type="hidden" name="id" value="<?php echo $id;?>">
                    <input type="submit" name="submit" value="change password" class="btn-primary">
                </td></tr>
            </table>
        </form>
    </div>
</div>
<?php  
//checking whether the submit button is clicked or not
if(isset($_POST['submit']))
{
    //getting the password change form data
    $id=$_POST['id'];
    $current_password=md5($_POST['current_password']);
    $new_password=md5($_POST['new_password']);
    $confirm_password=md5($_POST['confirm_password']);

//checking whether the user with current id and password exists or not
$sql="SELECT * FROM tbl_admin WHERE id=$id AND password='$current_password'";
//executing the query
$res=mysqli_query($conn,$sql);
if($res==true){
    //checking whether the data is available or not
    $count=mysqli_num_rows($res);
    if($count==1){
        //user exists and the password can be changed
       // echo"USer found";
       //checking whether the new password and confirm password match
       if($new_password==$confirm_password)
       {
        //updating the password
        $sql2="UPDATE tbl_admin SET
        password='$new_password' WHERE id=$id";
        //executing the query
        $res2=mysqli_query($conn,$sql2);
        //check whether the query is executed or not
        if($res2==true){
            //display the message
            $_SESSION['change-pwd']="<div class='success'>Password Changed Successfully</div>";
            //redirecting
            header('location:'.SITEURL.'admin/manage-admin.php');
        
        }
        else{
            //display error message
            $_SESSION['change-pwd']="<div class='error'>Password Changed Failed</div>";
    //redirecting
    header('location:'.SITEURL.'admin/manage-admin.php');
}

}

        
       else{
        $_SESSION['password-not-found']="<div class='error'>password did  not match</div>";
        header('location:'.SITEURL.'admin/manage-admin.php');

       }


    }
    else {
        //user doesnt exist and the password cannot be changed
        $_SESSION['user-not-found']="<div class='error'>User not found</div>";
    //redirecting
    header('location:'.SITEURL.'admin/manage-admin.php');
}
}
}

    
    
    
    ?>
<?php include('footer.php');?>
