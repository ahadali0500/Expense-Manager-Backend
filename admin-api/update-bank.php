<?php
include('../Api/connection.php');

// Enable error reporting for debugging
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Set headers for CORS and content type
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: PUT, GET, OPTIONS, POST");
header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept");

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Check if all required fields are present and sanitize inputs
    $bank_id = isset($_POST['bank_id']) ? mysqli_real_escape_string($con, $_POST['bank_id']) : null;
    $bank_name = isset($_POST['bank_name']) ? mysqli_real_escape_string($con, $_POST['bank_name']) : null;
    $pre_img = isset($_POST['pre_img']) ? mysqli_real_escape_string($con, $_POST['pre_img']) : null;
    $status = isset($_POST['status']) ? mysqli_real_escape_string($con, $_POST['status']) : null;

  

    // Default value for image
    $pImage = $pre_img;
    $baseDirectory = "../images/bank/";

    // Create directory if it doesn't exist
    if (!is_dir($baseDirectory)) {
        mkdir($baseDirectory, 0755, true);
    }

    // Handle file upload (if a new image is provided)
    if (isset($_FILES["image"]) && $_FILES["image"]["error"] == UPLOAD_ERR_OK) {
        $imageFileInfo = pathinfo($_FILES["image"]["name"]);
        $fileExtension = strtolower($imageFileInfo['extension']);
        $allowedTypes = ['jpg', 'jpeg', 'png', 'gif'];

        if (!in_array($fileExtension, $allowedTypes)) {
            http_response_code(400);
            echo json_encode(["error" => "Invalid file type", "code" => 400]);
            exit();
        }

        $pImage = $imageFileInfo['filename'] . "_" . time() . "." . $fileExtension;
        $imageDestinationPath = $baseDirectory . $pImage;

        if (!move_uploaded_file($_FILES["image"]["tmp_name"], $imageDestinationPath)) {
            http_response_code(500);
            echo json_encode(["error" => "Failed to move uploaded file", "code" => 500]);
            exit();
        }

        $pImage = mysqli_real_escape_string($con, $pImage);
    }

    // Update data in the database
    $updateQuery = "UPDATE `banks` SET `bank_name`='$bank_name', `image`='$pImage', `status`='$status' WHERE `id`='$bank_id'";
    $result = mysqli_query($con, $updateQuery);

    // Check if the update was successful and return the appropriate response
    if ($result) {
        http_response_code(200);
        echo json_encode(["message" => "Bank updated successfully", "code" => 200]);
    } else {
        http_response_code(500);
        echo json_encode(["error" => "Failed to update bank", "code" => 500, "sql_error" => mysqli_error($con)]);
    }
} else {
    http_response_code(405);
    echo json_encode(["error" => "Method not allowed", "code" => 405]);
}
?>
