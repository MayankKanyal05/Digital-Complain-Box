<?php
    session_start();
    include("../config/db.php");
    if(!isset($_SESSION['admin'])){
        header("Location:login.php");
        exit();
    }
    $query="SELECT * FROM complaints
            WHERE status='Resolved'
            ORDER BY id DESC";
    $result=mysqli_query($conn,$query);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, initial-scale=1.0">
    <title>Resolved Complaints</title>
    <link rel="stylesheet"
          href="../assets/css/admin-pages.css">
</head>
<body>
    <div class="main-content">
        <h1>Resolved Complaints</h1>
        <table>
            <tr>
                <th>ID</th>
                <th>Student</th>
                <th>Complaint</th>
                <th>Status</th>
            </tr>
            <?php while($row=mysqli_fetch_assoc($result)){ ?>
                <tr>
                    <td><?php echo $row['id']; ?></td>
                    <td><?php echo $row['student_name']; ?></td>
                    <td><?php echo $row['complaint']; ?></td>
                    <td>
                        <span class="resolved">
                            Resolved
                        </span>
                    </td>
                </tr>
            <?php } ?>
        </table>
    </div>
</body>
</html>