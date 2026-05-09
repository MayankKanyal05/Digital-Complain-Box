<?php
    session_start();
    include("../config/db.php");
    if(!isset($_SESSION['admin'])){
        header("Location:login.php");
        exit();
    }
    $total_query="SELECT * FROM complaints";
    $total_result=mysqli_query($conn,$total_query);
    $total=mysqli_num_rows($total_result);
    $pending_query="SELECT * FROM complaints
                    WHERE status='Pending'";
    $pending_result=mysqli_query($conn,$pending_query);
    $pending=mysqli_num_rows($pending_result);
    $resolved_query="SELECT * FROM complaints
                     WHERE status='Resolved'";
    $resolved_result=mysqli_query($conn,$resolved_query);
    $resolved=mysqli_num_rows($resolved_result);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, initial-scale=1.0">
    <title>Reports</title>
    <link rel="stylesheet"
          href="../assets/css/admin-pages.css">
</head>
<body>
    <div class="main-content">
        <h1>Complaint Reports</h1>
        <div class="report-box">
            <div class="report-card">
                <h2><?php echo $total; ?></h2>
                <p>Total Complaints</p>
            </div>
            <div class="report-card">
                <h2><?php echo $pending; ?></h2>
                <p>Pending Complaints</p>
            </div>
            <div class="report-card">
                <h2><?php echo $resolved; ?></h2>
                <p>Resolved Complaints</p>
            </div>
        </div>
    </div>
</body>
</html>