<?php
include('../Api/connection.php');

// Set headers for CORS and content type
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: POST, GET, OPTIONS");
header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept");

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Sanitize and validate input
    $dept_name = mysqli_real_escape_string($con, $_POST['dept_name']);
    $status = mysqli_real_escape_string($con, $_POST['status']);
    $company_id = mysqli_real_escape_string($con, $_POST['company_id']);

   
    // Insert data into the database
    $dd = "INSERT INTO `departments`(`dept_name`, `status`,`company_id`) VALUES ('$dept_name','$status','$company_id')";
    $cc = mysqli_query($con, $dd);

    // Check if the insert was successful and return the appropriate response
    if ($cc) {
        http_response_code(200);
        echo json_encode(["message" => "Department added successfully", "code" => 200]);
    } else {
        http_response_code(500);
        echo json_encode(["error" => "Failed to add Department", "code" => 500]);
    }
} else {
    http_response_code(405);
    echo json_encode(["error" => "Method not allowed", "code" => 405]);
}

?>
