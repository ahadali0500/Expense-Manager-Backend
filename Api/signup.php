<?php 
// echo 'php';
include "connection.php";
$fullName = $_POST["name"];
$email = $_POST["email"];
$company_id = $_POST["company_id"];
$company_key = $_POST["company_key"];
$password = $_POST["password"];
$pImage = "";

$ch = "SELECT * FROM `users` WHERE `email`='$email'";
$dtv = mysqli_query($con, $ch);


if (!mysqli_num_rows($dtv) > 0) {
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
    $query = "INSERT INTO `users`(`name`, `email`, `password`,`image`, `access`, `company_id`, `company_key`) VALUES ('$fullName','$email','$password','$pImage', '0', '$company_id', '$company_key')";
    $dt = mysqli_query($con, $query);
    if ($dt) {
        http_response_code(200);
        echo json_encode([
            "code" => 200,
            "message" => "Your Account created successfully!",
            "status" => true,
        ]);
    }
    else{

        http_response_code(400);
        echo json_encode([
            "code" => 400,
            "message" => "Registration failed. Please try again later.!",
            "status" => false,
        ]);
    }
} else {
    http_response_code(409);
    echo json_encode([
        "code" => 409,
        "message" => "Email is already used by someone.",
        "status" => false,
    ]);
}

?>