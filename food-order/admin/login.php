<?php include('../config/constants.php')?>
<html>
    <head>
        <title>Login-Food Order System</title>
        <link rel="stylesheet" href="../CSS/admin.css">

    </head>
    <div class="login">
        <h1 class="text-center">Login</h1><br><br>
        <?php
        if(isset($_SESSION['login'])){
            echo $_SESSION['login'];
            unset($_SESSION['login']);


        }
        if(isset($_SESSION['no-login-message'])){
            echo $_SESSION['no-login-message'];
            unset($_SESSION['no-login-message']);


        }

        ?>
        <br>
        <!--login form-->
        <form action="" method="POST" class="text-center">
            Username:
            <input type="text" name="username" placeholder="Enter Username"><br><br>
            Password:
            <input type="password" name="password" placeholder="Enter password"><br><br>
            <input type="submit" name="submit" value="login" class="btn-primary"><br><br>
        </form>
        <p>Created By -<a href="www.aashishnepal.com">Aashish  and alok </a></p>
    </div>
</html>
<?php
//check whether the submit button is clicked or not
if(isset($_POST['submit']))
{
    //get the data from login form
    $username=$_POST['username'];
     $password=md5($_POST['password']);
     //check whether the user with username and password exists or not
     $sql="SELECT * FROM tbl_admin WHERE username='$username' AND password='$password'";
    //execute the query
    $res=mysqli_query($conn,$sql);
    //counting rows to check whether the user exists or not
    $count=mysqli_num_rows($res);
    if($count==1)
    {
        //user is available and login success
        $_SESSION['user']=$username;//checking whether the user is logged in or not and logout will unset it
        $_SESSION['login']="<div class='success'>Login Successful.Welcome <?php echo $username;?></div>";
        
        //redirect to dashboard
    
        header('location:'.SITEURL.'admin/');
    }

    else{
        //user is not available and login failed
        $_SESSION['login']="<div class='error'>Username or password didnot match</div>";
        //redirect to dashboard
        header('location:'.SITEURL.'admin/login.php');
    }

}

?>