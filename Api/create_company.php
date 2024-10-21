<?php 
// echo 'php';
include "connection.php";
$company_name = $_POST["company_name"];
$company_key = $_POST["company_key"];
$password = $_POST["password"];
$description = $_POST["description"];
$pImage = "";

$ch = "SELECT * FROM `company` WHERE `company_key`='$company_key'";
$dtv = mysqli_query($con, $ch);


if (!mysqli_num_rows($dtv) > 0) {

    $pImage = "";

    $baseDirectory = "../images/users/";
    if (!is_dir($baseDirectory)) {
        mkdir($baseDirectory, 0755, true);
    }

    if (isset($_FILES["image"]) && $_FILES["image"]["error"] == UPLOAD_ERR_OK) {
        $imageFileInfo = pathinfo($_FILES["image"]["name"]);
        $pImage =
            $imageFileInfo["filename"] .
            "_" .
            time() .
            "." .
            $imageFileInfo["extension"];
        $imageDestinationPath = $baseDirectory . $pImage;

        if (
            move_uploaded_file(
                $_FILES["image"]["tmp_name"],
                $imageDestinationPath
            )
        ) {
            $pImage = "'" . mysqli_real_escape_string($con, $pImage) . "'";
        } else {
            echo json_encode([
                "error" => "Failed to move uploaded file.",
                "code" => 400,
            ]);
            exit();
        }
    }
    
    $query_ = "INSERT INTO `company`(`company_name`, `company_key`, `description`, `logo`) VALUES ('$company_name','$company_key','$password', $pImage)";
    $dt_ = mysqli_query($con, $query_);
    if($dt_){
        $company_id = mysqli_insert_id($con);

        $query = "INSERT INTO `users`(`name`, `email`, `password`,`image`, `access`, `company_id`, `company_key`) VALUES ('$company_name','','$password', $pImage, '1', '$company_id', '$company_key')";
        $dt = mysqli_query($con, $query);
        if ($dt) {
            http_response_code(200);
            echo json_encode([
                "code" => 200,
                "message" => "Your company register successfully!",
                "status" => true,
            ]);
        }
        else{

            http_response_code(400);
            echo json_encode([
                "code" => 400,
                "error" => mysqli_error($con),
                "message" => "User Registration failed. Please try again later.!",
                "status" => false,
            ]);
        }
    }
    else{
            http_response_code(400);
            echo json_encode([
                "code" => 400,
                "error" => mysqli_error($con),
                "message" => "Company Registration failed. Please try again later.!",
                "status" => false,
            ]);
        } 
} else {
    http_response_code(409);
    echo json_encode([
        "code" => 409,
        "message" => "Company Key is already used by someone.",
        "status" => false,
    ]);
}

?>