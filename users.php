<?php
    session_start();
    include("../config/db.php");
    if(!isset($_SESSION['admin'])){
        header("Location:login.php");
        exit();
    }
    $query="SELECT * FROM users ORDER BY id DESC";
    $result=mysqli_query($conn,$query);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, initial-scale=1.0">
    <title>Manage Users</title>
    <link rel="stylesheet"
          href="../assets/css/admin-pages.css">
</head>
<body>
    <div class="main-content">
        <h1>All Users</h1>
        <table>
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Email</th>
                <th>Total Complaints</th>
                <th>Created At</th>
            </tr>
            <?php while($row=mysqli_fetch_assoc($result)){ ?>
                <?php
                    $name=$row['name'];
                    $complaint_query="SELECT * FROM complaints
                                      WHERE student_name='$name'";
                    $complaint_result=mysqli_query($conn,$complaint_query);
                    $total_complaints=mysqli_num_rows($complaint_result);
                ?>
                <tr>
                    <td><?php echo $row['id']; ?></td>
                    <td><?php echo $row['name']; ?></td>
                    <td><?php echo $row['email']; ?></td>
                    <td><?php echo $total_complaints; ?></td>
                    <td><?php echo $row['created_at']; ?></td>
                </tr>
            <?php } ?>
        </table>
    </div>
</body>
</html>