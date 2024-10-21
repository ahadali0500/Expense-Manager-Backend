<?php
include('../Api/connection.php');

// Set headers for CORS and content type
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: POST, GET, OPTIONS");
header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept");

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Sanitize and validate input
    $name = mysqli_real_escape_string($con, $_POST['name']);
    $employee_type = mysqli_real_escape_string($con, $_POST['employee_type']);
    $date_of_joining = mysqli_real_escape_string($con, $_POST['date_of_joining']);
    $dpt_id = mysqli_real_escape_string($con, $_POST['dpt_id']);
    $company_id = mysqli_real_escape_string($con, $_POST['company_id']);

    // Default value for image
    $pImage = "";
    $baseDirectory = "../images/employees/";

    // Create directory if not exists
    if (!is_dir($baseDirectory)) {
        if (!mkdir($baseDirectory, 0755, true)) {
            http_response_code(500);
            echo json_encode(["error" => "Failed to create directory for image uploads.", "code" => 500]);
            exit();
        }
    }

    // Handle file upload
    if (isset($_FILES["image"]) && $_FILES["image"]["error"] == UPLOAD_ERR_OK) {
        $imageFileInfo = pathinfo($_FILES["image"]["name"]);
        $pImage = $imageFileInfo['filename'] . "_" . time() . "." . $imageFileInfo['extension'];
        $imageDestinationPath = $baseDirectory . $pImage;

        if (!move_uploaded_file($_FILES["image"]["tmp_name"], $imageDestinationPath)) {
            http_response_code(500);
            echo json_encode(["error" => "Failed to move uploaded file.", "code" => 500]);
            exit();
        }

        $pImage = mysqli_real_escape_string($con, $pImage);
    }

    // Insert data into the database
    $query = "INSERT INTO `employees_list`(`name`, `employee_type`, `date_of_joining`, `image`, `dept_id`, `company_id`) 
              VALUES ('$name', '$employee_type', '$date_of_joining', '$pImage', '$dpt_id', '$company_id')";

    $result = mysqli_query($con, $query);

    // Check if the insert was successful and return the appropriate response
    if ($result) {
        http_response_code(200);
        echo json_encode(["message" => "Employee added successfully", "code" => 200]);
    } else {
        http_response_code(500);
        echo json_encode(["error" => "Failed to add employee", "code" => 500, "details" => mysqli_error($con)]);
    }
} else {
    http_response_code(405);
    echo json_encode(["error" => "Method not allowed", "code" => 405]);
}

?>
