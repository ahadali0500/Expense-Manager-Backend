<?php
include('../Api/connection.php');

// Set headers for CORS and content type
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: PUT, POST, GET, OPTIONS");
header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept");

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Sanitize and validate input
    $id = mysqli_real_escape_string($con, $_POST['id']);
    $name = mysqli_real_escape_string($con, $_POST['name']);
    $employee_type = mysqli_real_escape_string($con, $_POST['employee_type']);
    $date_of_joining = mysqli_real_escape_string($con, $_POST['date_of_joining']);
    $pre_img = mysqli_real_escape_string($con, $_POST['pre_img']);
    $status = mysqli_real_escape_string($con, $_POST['status']);
    $dpt_id = mysqli_real_escape_string($con, $_POST['dpt_id']);

    // Default value for image
    $pImage = $pre_img;
    $baseDirectory = "../images/employees/";

    // Handle file upload (if a new image is provided)
    if (isset($_FILES["image"]) && $_FILES["image"]["error"] == 0) {
        $imageFileInfo = pathinfo($_FILES["image"]["name"]);
        $pImage = $imageFileInfo['filename'] . "_" . time() . "." . $imageFileInfo['extension'];
        $imageDestinationPath = $baseDirectory . $pImage;

        if (move_uploaded_file($_FILES["image"]["tmp_name"], $imageDestinationPath)) {
            $pImage = mysqli_real_escape_string($con, $pImage);
        } else {
            echo json_encode(["error" => "Failed to move uploaded file.", "code" => 400]);
            exit();
        }
    }

    // SQL query to update the employee data
    $updateQuery = "
        UPDATE `employees_list`
        SET `name`='$name',
            `employee_type`='$employee_type',
            `date_of_joining`='$date_of_joining',
            `image`='$pImage',
            `status`='$status',
            `dept_id`='$dpt_id'
        WHERE `id`='$id'
    ";

    // Execute the query
    if (mysqli_query($con, $updateQuery)) {
        http_response_code(200);
        echo json_encode(["message" => "Employee updated successfully", "code" => 200]);
    } else {
        http_response_code(500);
        echo json_encode(["error" => "Failed to update Employee", "code" => 500]);
    }
} else {
    http_response_code(405);
    echo json_encode(["error" => "Method not allowed", "code" => 405]);
}

mysqli_close($con);
?>
