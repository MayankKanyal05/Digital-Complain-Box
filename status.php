<?php
    session_start();
    include("../config/db.php");
    if(!isset($_SESSION['user'])){
        header("Location:login.php");
        exit();
    }
    $email=$_SESSION['user'];
    $user_query="SELECT * FROM users 
                 WHERE email='$email'";
    $user_result=mysqli_query($conn,$user_query);
    $user=mysqli_fetch_assoc($user_result);
    $query="SELECT * FROM complaints
            WHERE student_name='".$user['name']."'
            ORDER BY id DESC";
    $result=mysqli_query($conn,$query);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, initial-scale=1.0">
    <title>Complaint Status</title>
    <link rel="stylesheet"
          href="../assets/css/ustatus.css">
    <link rel="stylesheet"
          href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
</head>
<body>
    <div class="sidebar">
        <div class="logo">
            <h2>DC BOX</h2>
        </div>
        <ul>
            <li>
                <a href="dashboard.php">
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
            <li class="active">
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
            <h1>Complaint Status</h1>
            <div class="profile">
                <i class="fa-solid fa-user"></i>
                <?php echo $user['name']; ?>
            </div>
        </div>
        <div class="table-section">
            <table>
                <tr>
                    <th>ID</th>
                    <th>Complaint</th>
                    <th>Evidence</th>
                    <th>Status</th>
                    <th>Date</th>
                </tr>
                <?php while($row=mysqli_fetch_assoc($result)){ ?>
                    <tr>
                        <td>
                            <?php echo $row['id']; ?>
                        </td>
                        <td>
                            <?php echo $row['complaint']; ?>
                        </td>
                        <td>
                            <?php
                                if($row['evidence']!=""){
                            ?>
                                <a href="../assets/uploads/<?php echo $row['evidence']; ?>"
                                   target="_blank"
                                   class="view-btn">
                                    View
                                </a>
                            <?php
                                }else{
                                    echo "No Evidence";
                                }
                            ?>
                        </td>
                        <td>
                            <?php
                                if($row['status']=="Pending"){
                            ?>
                                <span class="pending">
                                    Pending
                                </span>
                            <?php
                                }elseif($row['status']=="Resolved"){
                            ?>
                                <span class="resolved">
                                    Resolved
                                </span>
                            <?php
                                }else{
                            ?>
                                <span class="progress">
                                    In Progress
                                </span>
                            <?php
                                }
                            ?>
                        </td>
                        <td>
                            <?php echo $row['created_at']; ?>
                        </td>
                    </tr>
                <?php } ?>
            </table>
        </div>
    </div>
</body>
</html>