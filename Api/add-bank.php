$actual_amount = $_POST['actual_amount'];<?php
include('../Api/connection.php');
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: POST, GET, OPTIONS");
header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept");

$bank_name = $_POST['bank_name'];
$current_amount = $_POST['current_amount'];
$company_id = $_POST['company_id'];


$pImage = "NULL";
$baseDirectory = "../images/bank/";

if (!is_dir($baseDirectory)) {
    mkdir($baseDirectory, 0755, true);
}

if (isset($_FILES["image"]) && $_FILES["image"]["error"] == UPLOAD_ERR_OK) {
    $imageFileInfo = pathinfo($_FILES["image"]["name"]);
    $pImage = $imageFileInfo['filename'] . "_" . time() . "." . $imageFileInfo['extension'];
    $imageDestinationPath = $baseDirectory . $pImage;
    
    if (move_uploaded_file($_FILES["image"]["tmp_name"], $imageDestinationPath)) {
        $pImage = "'" . mysqli_real_escape_string($con, $pImage) . "'";
    } else {
        echo json_encode(["error" => "Failed to move uploaded file." , "code"=> 400]);
        exit();
    }
}



$dd="INSERT INTO `banks`(`bank_name`, `current_amount`, `actual_amount`, `image`, `company_id`) VALUES ('$bank_name','$current_amount','$actual_amount',$pImage, '$company_id')";
$cc=mysqli_query($con, $dd);
if(mysqli_num_rows($cc)>0){
    http_response_code(200);
    $output['code'] = 200;
    echo json_encode($output);
}else {
    http_response_code(404);
    $output['code'] = 404;
    echo json_encode($output);
}

return $output;
?>
