<?php
    session_start();
    include("../config/db.php");
    $message="";
    if(isset($_POST['login'])){
        $email=mysqli_real_escape_string($conn,$_POST['email']);
        $password=mysqli_real_escape_string($conn,$_POST['password']);
        $query="SELECT * FROM users 
                WHERE email='$email' 
                AND password='$password'";
        $result=mysqli_query($conn,$query);
        if(mysqli_num_rows($result)>0){
            $_SESSION['user']=$email;
            header("Location:dashboard.php");
            exit();
        }else{
            $message="Invalid Email or Password";
        }
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, initial-scale=1.0">
    <title>User Login</title>
    <link rel="stylesheet"
          href="../assets/css/ulogin.css">
    <link rel="stylesheet"
          href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
</head>
<body>
    <div class="container">
        <div class="login-box">
            <h1>User Login</h1>
            <p>
                Login to access your complaint dashboard
            </p>
            <?php
                if($message!=""){
                    echo "<div class='message'>$message</div>";
                }
            ?>
            <form method="POST">
                <div class="input-box">
                    <label>Email</label>
                    <input type="email"
                           name="email"
                           placeholder="Enter Email"
                           required>
                </div>
                <div class="input-box">
                    <label>Password</label>
                    <input type="password"
                           name="password"
                           placeholder="Enter Password"
                           required>
                </div>
                <button type="submit"
                        name="login"
                        class="btn">
                    Login
                </button>
            </form>
            <div class="register-link">
                Don't have an account?
                <a href="register.php">
                    Register
                </a>
            </div>
            <a href="../admin/login.php"
               class="admin-btn">
                <i class="fa-solid fa-user-shield"></i>
                Switch To Admin Login
            </a>
        </div>
    </div>
</body>
</html>