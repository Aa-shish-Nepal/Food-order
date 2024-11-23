<?php include('menu.php');?>
<div class="main">
    <div class="wrapper">
        <h1>Update Admin</h1>
        <br><br>
        <?php 
        //getting id of selected admin
        $id=$_GET['id'];
        //creating sql query to get the details
        $sql="SELECT * FROM tbl_admin WHERE id=$id";
        //Execute the query
        $res=mysqli_query($conn,$sql);
        //checking whether the query is executed or not
        if($res==true){
            $count=mysqli_num_rows($res);
            //check whether we have admin data or not
            if($count==1){
                //getting details 
               // echo"Admin available";
               $row=mysqli_fetch_assoc($res);
               $fullname=$row['Fullname'];
               $username=$row['username'];

            }
            else{
                //redirecting to manage admin page
                header('location:'.SITEURL.'admin/manage-admin.php');
            }
        }
        ?>
        <form action="" method="POST">
            <table class="tbl-30">
                <tr>
                    <td>Full Name:</td>
                    <td>
                        <input type="text" name="fullname" value="<?php echo $fullname;?> ">
                    </td>
                    

                </tr>

                <tr>
                    <td>Username</td>
                <td><input type="text" name="username" value="<?php echo $username;?>"></td></tr>
           <tr>
            <td colspan="2">
                <input type="hidden" name="id" value="<?php echo $id?>">
                <input type="submit" name="submit" value="update Admin" class="btn-secondary">

            </td>
           </tr>
            </table>
        </form>

    </div>
</div>
<?php //checking whether the submit button is clicked or not
if(isset($_POST['submit']))
{
   // echo"Button clicked";
   //Getting all the values from form to update
   $id=$_POST['id'];
   $fullname=$_POST['fullname'];
   $username=$_POST['username'];

   //creating a sql query to update admin in database
   $sql="UPDATE tbl_admin SET
   fullname='$fullname',
   username='$username'
   where id='$id'";

   //Executing the query
   $res=mysqli_query($conn,$sql);
   if($res==true)
   {
    //query is now executed
    $_SESSION['update']="<div class='success'>Admin updated successfully</div>";
    //redirect to manage admin page
    header('location:'.SITEURL.'admin/manage-admin.php');
   }
   else{
    //failed to update admin
    $_SESSION['update']="<div class='error'>Admin update failed</div>";

   }
}
 include('footer.php')?>
