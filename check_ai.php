<?php
include("../config/db.php");
if(isset($_GET['id'])){
    $id = $_GET['id'];
    $query = "SELECT * FROM complaints WHERE id='$id'";
    $result = mysqli_query($conn, $query);
    $row = mysqli_fetch_assoc($result);
    $evidence = $row['evidence'];
    $filepath = "../assets/uploads/" . $evidence;

    if(file_exists($filepath)){
        $url = "http://127.0.0.1:5000/predict";
        $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_URL => $url,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_POST => true,
            CURLOPT_POSTFIELDS => array(
                'file' => new CURLFILE($filepath)
            ),
        ));
        $response = curl_exec($curl);
        curl_close($curl);
        $result_data = json_decode($response, true);
       $ai_result = $result_data['result'] .
             " Image - Confidence: " .
             $result_data['confidence'] . "%";
        $update = "UPDATE complaints 
                   SET final_result='$ai_result'
                   WHERE id='$id'";
        mysqli_query($conn, $update);
        header("Location: complaints.php");
    }else{
        echo "Evidence file not found.";
    }
}else{
    echo "Invalid request.";
}
?>