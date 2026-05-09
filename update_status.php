<?php
    include("../config/db.php");
    if(isset($_GET['id']) && isset($_GET['status'])){
        $id=$_GET['id'];
        $status=$_GET['status'];
        $query="UPDATE complaints
                SET status='$status'
                WHERE id='$id'";
        mysqli_query($conn,$query);
        header("Location:dashboard.php");
    }
?>