<!-- user/dashboard.php -->
<?php
    session_start();
    include("../config/db.php");

    if(!isset($_SESSION['user'])){
        header("Location:login.php");
        exit();
    }
    $email=$_SESSION['user'];
    $user_query="SELECT * FROM users WHERE email='$email'";
    $user_result=mysqli_query($conn,$user_query);
    $user=mysqli_fetch_assoc($user_result);
    $complaint_query="SELECT * FROM complaints 
                      WHERE student_name='".$user['name']."' 
                      ORDER BY id DESC";
    $complaint_result=mysqli_query($conn,$complaint_query);
    $total_query="SELECT * FROM complaints 
                  WHERE student_name='".$user['name']."'";
    $total_result=mysqli_query($conn,$total_query);
    $total_complaints=mysqli_num_rows($total_result);
    $pending_query="SELECT * FROM complaints 
                    WHERE student_name='".$user['name']."' 
                    AND status='Pending'";
    $pending_result=mysqli_query($conn,$pending_query);
    $pending_complaints=mysqli_num_rows($pending_result);
    $resolved_query="SELECT * FROM complaints 
                     WHERE student_name='".$user['name']."' 
                     AND status='Resolved'";
    $resolved_result=mysqli_query($conn,$resolved_query);
    $resolved_complaints=mysqli_num_rows($resolved_result);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, initial-scale=1.0">
    <title>User Dashboard</title>
    <link rel="stylesheet"
          href="../assets/css/udashboard.css">
    <link rel="stylesheet"
          href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
</head>
<body>
    <div class="sidebar">
        <div class="logo">
            <h2>DC BOX</h2>
        </div>
        <ul>
            <li class="active">
                <a href="#">
                    <i class="fa-solid fa-house"></i>
                    <span>Dashboard</span>
                </a>
            </li>
            <li>
                <a href="submit.php">
                    <i class="fa-solid fa-pen"></i>
                    <span>Submit Complaint</span>
                </a>
            </li>
            <li>
                <a href="status.php">
                    <i class="fa-solid fa-clock"></i>
                    <span>Complaint Status</span>
                </a>
            </li>
            <li>
                <a href="logout.php">
                    <i class="fa-solid fa-right-from-bracket"></i>
                    <span>Logout</span>
                </a>
            </li>
        </ul>
    </div>
    <div class="main-content">
        <div class="topbar">
            <h1>User Dashboard</h1>
            <div class="profile">
                <i class="fa-solid fa-user"></i>
                <?php echo $user['name']; ?>
            </div>
        </div>
        <div class="cards">
            <div class="card">
                <i class="fa-solid fa-message"></i>
                <h2><?php echo $total_complaints; ?></h2>
                <p>Total Complaints</p>
            </div>
            <div class="card">
                <i class="fa-solid fa-clock"></i>
                <h2><?php echo $pending_complaints; ?></h2>
                <p>Pending Complaints</p>
            </div>
            <div class="card">
                <i class="fa-solid fa-circle-check"></i>
                <h2><?php echo $resolved_complaints; ?></h2>
                <p>Resolved Complaints</p>
            </div>
        </div>
        <div class="table-section">
            <h2>Your Complaints</h2>
            <table>
                <tr>
                    <th>ID</th>
                    <th>Complaint</th>
                    <th>Status</th>
                </tr>
                <?php while($row=mysqli_fetch_assoc($complaint_result)){ ?>
                    <tr>
                        <td><?php echo $row['id']; ?></td>
                        <td><?php echo $row['complaint']; ?></td>
                        <td>
                            <?php if($row['status']=="Pending"){ ?>
                                <span class="pending">
                                    Pending
                                </span>
                            <?php } else { ?>
                                <span class="resolved">
                                    Resolved
                                </span>
                            <?php } ?>
                        </td>
                    </tr>
                <?php } ?>
            </table>
        </div>
    </div>
</body>
</html>