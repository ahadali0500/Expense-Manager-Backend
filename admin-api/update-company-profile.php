<?php
include('../Api/connection.php');

// Set headers for CORS and content type
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: PUT, GET, OPTIONS, POST");
header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept");

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Sanitize and validate input
    $name = mysqli_real_escape_string($con, $_POST['name']);
    $password = mysqli_real_escape_string($con, $_POST['password']);
    $id = mysqli_real_escape_string($con, $_POST['id']);
    $pre_img = mysqli_real_escape_string($con, $_POST['pre_img']);

    // Default value for image
    $pImage = $pre_img;
    $baseDirectory = "../images/company/";

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
    $updateQuery = "UPDATE `company` SET `name`='$name', `password`='$password', `logo`='$pImage' WHERE `id`='$id'";
    $result = mysqli_query($con, $updateQuery);
     
    $ff = "SELECT * FROM `company` WHERE `id`='$id'";
    $res = mysqli_query($con, $ff);
    $data = mysqli_fetch_assoc($res);

    // Check if the update was successful and return the appropriate response
    if ($result) {
        http_response_code(200);
        echo json_encode(["message" => "Profile updated successfully", "code" => 200, "data" => $data]);
    } else {
        http_response_code(500);
        echo json_encode(["error" => "Failed to update profile", "code" => 500]);
    }
} else {
    http_response_code(405);
    echo json_encode(["error" => "Method not allowed", "code" => 405]);
}
?>
