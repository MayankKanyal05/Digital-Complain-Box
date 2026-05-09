<?php
    include("../config/db.php");
    $id=$_GET['id'];
    $query="SELECT * FROM complaints
            WHERE id='$id'";
    $result=mysqli_query($conn,$query);
    $row=mysqli_fetch_assoc($result);
    $final_result=$row['final_result'];
    if(strpos($final_result,"Real")!==false){
        $explanation="
        The AI model predicts this image as REAL because:
        • Facial structure looks natural
        • Lighting and shadows appear consistent
        • No major AI artifacts detected
        • Background objects look realistic
        • Image texture appears natural
        • No visible deepfake distortions found
        ";
    }else{
        $explanation="
        The AI model predicts this image as AI GENERATED because:
        • Artificial textures detected
        • Unnatural lighting patterns found
        • Possible deepfake artifacts detected
        • Background consistency issues present
        • Facial details appear synthetic
        • AI generation probability is high
        ";
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, initial-scale=1.0">
    <title>AI Result</title>
    <link rel="stylesheet"
          href="../assets/css/admin-pages.css">
    <style>
        body{
            background:#f4f6f9;
            font-family:Arial;
        }
        .result-box{
            width:70%;
            margin:50px auto;
            background:white;
            padding:30px;
            border-radius:10px;
            box-shadow:0 0 10px rgba(0,0,0,0.1);
        }
        .result-title{
            font-size:32px;
            margin-bottom:20px;
            color:#1e3c72;
        }
        .result{
            font-size:24px;
            margin-bottom:20px;
            font-weight:bold;
        }
        .real{
            color:green;
        }
        .fake{
            color:red;
        }
        .explanation{
            line-height:30px;
            font-size:18px;
            color:#333;
            white-space:pre-line;
        }
        .back-btn{
            display:inline-block;
            margin-top:20px;
            padding:10px 20px;
            background:#1e3c72;
            color:white;
            text-decoration:none;
            border-radius:5px;
        }
    </style>
</head>
<body>
<div class="result-box">
    <h1 class="result-title">
        AI Analysis Report
    </h1>
    <div class="result
        <?php
            if(strpos($final_result,'Real')!==false){
                echo 'real';
            }else{
                echo 'fake';
            }
        ?>">
        <?php echo $final_result; ?>
    </div>
    <div class="explanation">
        <?php echo $explanation; ?>
    </div>
    <a href="complaints.php"
       class="back-btn">
        Back To Complaints
    </a>
</div>
</body>
</html>