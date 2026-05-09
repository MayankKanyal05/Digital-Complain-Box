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
    if(mysqli_num_rows($user_result)>0){
        $user=mysqli_fetch_assoc($user_result);
    }else{
        die("User Not Found");
    }
    $message="";
    if(isset($_POST['submit'])){
        $complaint=mysqli_real_escape_string(
            $conn,
            $_POST['complaint']
        );
        $evidence_name=$_FILES['evidence']['name'];
        $temp_name=$_FILES['evidence']['tmp_name'];
        $folder="../assets/uploads/".$evidence_name;
        move_uploaded_file($temp_name,$folder);
        $ai_result="Not Checked";
        $confidence="0";
        if($temp_name!=""){
            $curl=curl_init();
            curl_setopt_array($curl,[
                CURLOPT_URL=>"http://127.0.0.1:5000/predict",
                CURLOPT_RETURNTRANSFER=>true,
                CURLOPT_POST=>true,
                CURLOPT_POSTFIELDS=>[
                    'image'=>new CURLFile($folder)
                ]
            ]);
            $response=curl_exec($curl);
            curl_close($curl);
            $data=json_decode($response,true);
            if(
                $data &&
                isset($data['result']) &&
                isset($data['confidence'])
            ){
                $ai_result=$data['result'];
                $confidence=$data['confidence'];
            }else{
                $ai_result="AI Error";
                $confidence="0";
            }
        }
        $query="INSERT INTO complaints
        (
            student_name,
            complaint,
            evidence,
            status,
            ai_result,
            confidence
        )
        VALUES
        (
            '".$user['name']."',
            '$complaint',
            '$evidence_name',
            'Pending',
            '$ai_result',
            '$confidence'
        )";
        $result=mysqli_query($conn,$query);
        if($result){
            $message="Complaint Submitted Successfully";
        }else{
            $message="Failed To Submit Complaint";
        }
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, initial-scale=1.0">
    <title>Submit Complaint</title>
    <link rel="stylesheet"
          href="../assets/css/usubmit.css">
    <link rel="stylesheet"
          href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
</head>
<body>
    <div class="container">
        <div class="complaint-box">
            <h1>Submit Complaint</h1>
            <p>
                Write your complaint clearly and briefly
            </p>
            <?php
                if($message!=""){
                    echo "<div class='message'>$message</div>";
                }
            ?>
            <form method="POST"
                  enctype="multipart/form-data">
                <div class="input-box">
                    <label>Student Name</label>
                    <input type="text"
                           value="<?php echo $user['name']; ?>"
                           readonly>
                </div>
                <div class="input-box">
                    <label>Complaint</label>
                    <textarea name="complaint"
                              placeholder="Enter Your Complaint"
                              required></textarea>
                </div>
                <div class="input-box">
                    <label>
                        Upload Evidence
                        (Image / Video / Audio)
                    </label>
                    <input type="file"
                           name="evidence"
                           accept="image/*,video/*,audio/*">
                </div>
                <button type="submit"
                        name="submit"
                        class="btn">
                    Submit Complaint
                </button>
            </form>
        </div>
    </div>
</body>
</html>