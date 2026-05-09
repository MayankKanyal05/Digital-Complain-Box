<?php
    include("../config/db.php");
    if(isset($_GET['id'])){
        $id=$_GET['id'];
        $query="DELETE FROM complaints
                WHERE id='$id'";
        mysqli_query($conn,$query);
        header("Location:complaints.php");
    }
?>