<?php
    include("../config/db.php");
    $message="";
    if(isset($_POST['register'])){
        $name=mysqli_real_escape_string($conn,$_POST['name']);
        $email=mysqli_real_escape_string($conn,$_POST['email']);
        $password=mysqli_real_escape_string($conn,$_POST['password']);
        $check_query="SELECT * FROM users 
                      WHERE email='$email'";
        $check_result=mysqli_query($conn,$check_query);
        if(mysqli_num_rows($check_result)>0){
            $message="Email already exists";
        }else{
            $query="INSERT INTO users(name,email,password)
                    VALUES('$name','$email','$password')";
            if(mysqli_query($conn,$query)){
                $message="Registration Successful";
            }else{
                $message="Registration Failed";
            }
        }
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, initial-scale=1.0">
    <title>User Registration</title>
    <link rel="stylesheet"
          href="../assets/css/uregister.css">
    <link rel="stylesheet"
          href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
</head>
<body>
    <div class="container">
        <div class="register-box">
            <h1>Create Account</h1>
            <p>
                Register to submit and track complaints
            </p>
            <?php
                if($message!=""){
                    echo "<div class='message'>$message</div>";
                }
            ?>
            <form method="POST">
                <div class="input-box">
                    <label>Full Name</label>
                    <input type="text"
                           name="name"
                           placeholder="Enter Full Name"
                           required>
                </div>
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
                        name="register"
                        class="btn">

                    Register
                </button>
            </form>
            <div class="login-link">
                Already have an account?
                <a href="login.php">
                    Login
                </a>
            </div>
        </div>
    </div>
</body>
</html>