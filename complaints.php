<?php
    session_start();
    include("../config/db.php");
    if(!isset($_SESSION['admin'])){
        header("Location:login.php");
        exit();
    }
    $query="SELECT * FROM complaints ORDER BY id DESC";
    $result=mysqli_query($conn,$query);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, initial-scale=1.0">
    <title>Manage Complaints</title>
    <link rel="stylesheet"
          href="../assets/css/admin-pages.css">
    <link rel="stylesheet"
          href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
</head>
<body>
    <div class="main-content">
        <h1>All Complaints</h1>
        <table>
            <tr>
                <th>ID</th>
                <th>Student</th>
                <th>Complaint</th>
                <th>Evidence</th>
                <th>Status</th>
                <th>Final Result</th>
                <th>Action</th>
            </tr>
            <?php while($row=mysqli_fetch_assoc($result)){ ?>
                <tr>
                    <td><?php echo $row['id']; ?></td>
                    <td><?php echo $row['student_name']; ?></td>
                    <td><?php echo $row['complaint']; ?></td>
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
                                echo "No File";
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
                            }elseif($row['status']=="In Review"){
                        ?>
                            <span class="review">
                                In Review
                            </span>
                        <?php
                            }else{
                        ?>
                            <span class="resolved">
                                Resolved
                            </span>
                        <?php
                            }
                        ?>
                    </td>
                    <td>
                        <?php
                            if($row['final_result']==""){
                        ?>
                            <span class="not-check">
                                Not Checked
                            </span>
                        <?php
                            }else{
                                echo $row['final_result'];
                            }
                        ?>
                    </td>
                    <td>
                        <a href="check_ai.php?id=<?php echo $row['id']; ?>"
                           class="generated-btn">
                            AI Generated
                        </a>
                        <?php if($row['status']=="Pending"){ ?>
                            <a href="update_status.php?id=<?php echo $row['id']; ?>&status=In Review"
                               class="review-btn">
                                Review
                            </a>
                            <a href="update_status.php?id=<?php echo $row['id']; ?>&status=Resolved"
                               class="resolve-btn">
                                Resolve
                            </a>
                        <?php }elseif($row['status']=="In Review"){ ?>
                            <a href="update_status.php?id=<?php echo $row['id']; ?>&status=Resolved"
                               class="resolve-btn">
                                Resolve
                            </a>
                        <?php }else{ ?>
                            <span class="done-text">
                                Completed
                            </span>
                        <?php } ?>
                    </td>
                </tr>
            <?php } ?>
        </table>
    </div>
</body>
</html>
