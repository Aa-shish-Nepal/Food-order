<?php include('menu.php'); ?>
<!--menu section ends-->
       
<!--main section start-->
        <div class="main">
            <div class="wrapper">
           <h1>Manage Admin</h1><br><br>
           <?php
           if(isset($_SESSION['add'])){
            echo $_SESSION['add'];//displaying session message
            unset($_SESSION['add']);//removing session message
           }
           if(isset($_SESSION['delete'])){
            echo $_SESSION['delete'];
            unset($_SESSION['delete']);
           }

           if(isset($_SESSION['update'])){
            echo $_SESSION['update'];
            unset($_SESSION['update']);
           }

           
           if(isset($_SESSION['user-not-found'])){
            echo $_SESSION['user-not-found'];
            unset($_SESSION['user-not-found']);
           }

           if(isset($_SESSION['password-not-found'])){
            echo $_SESSION['password-not-found'];
            unset($_SESSION['password-not-found']);
           }

           if(isset($_SESSION['change-pwd'])){
            echo $_SESSION['change-pwd'];
            unset($_SESSION['change-pwd']);
           }


          

           ?>
           <br><br><br>
           <a href="add-admin.php" class="btn-primary">Add Admin</a>

           <table class="tbl-full">
            <tr>
                <th>SN</th>
                <th>Full Name</th>
                <th>Username</th>
                <th>Actions</th>
</tr>
<?php
//query to get all admin
$sql="SELECT * FROM tbl_admin";
//execute the query
$res=mysqli_query($conn,$sql);
//check whether the query is executed or not
if($res==TRUE)
{
    //count  Rows to check whether we have data in database or not
    $count=mysqli_num_rows($res);//function to get all the rows in database
   $sn=1; //create a value and assign the value
   //now check the number of rows
    if($count>0)
    {
        //Data is present is present in our database
        while($rows=mysqli_fetch_assoc($res)){
            $id=$rows['id'];
            $fullname=$rows['Fullname'];
            $username=$rows['username'];

            //display values
            ?>
            
<tr>
    <td><?php echo $sn++;?></td>
    <td><?php echo $fullname;?></td>
    <td><?php echo $username;?></td>
    <td>
        <a href="<?php echo SITEURL;?>admin/update-password.php?id=<?php echo $id;?>" class="btn-primary">Change Password </a>
    <a href="<?php echo SITEURL;?>admin/update-admin.php?id=<?php echo $id?>" class="btn-secondary">Update  </a>&nbsp;
    <a href="<?php echo SITEURL;?>admin/delete-admin.php?id=<?php echo $id;?>" class="btn-danger">  Delete </a>
    </td>
</tr>
<tr><?php



        }
    }
}
?>
<br></table><br><br><br>
        
            </div>
            
        </div>
       
        <!--main section ends-->
<div class="clearfix"></div>
  
          <?php include('footer.php');?>
          
