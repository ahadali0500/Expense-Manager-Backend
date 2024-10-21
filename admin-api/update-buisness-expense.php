<?php
include('../Api/connection.php');

// Set headers for CORS and content type
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: POST, GET, OPTIONS");
header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept");

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Sanitize and validate input
    $id = mysqli_real_escape_string($con, $_POST['id']);
    $name = mysqli_real_escape_string($con, $_POST['name']);
    $status = mysqli_real_escape_string($con, $_POST['status']);
    $company_id = mysqli_real_escape_string($con, $_POST['company_id']);

    // Insert data into the database
    $dd = "UPDATE `business_expense_list` SET `name`='$name',`status`='$status' WHERE `id`='$id'";
    $cc = mysqli_query($con, $dd);


    // $cvb="UPDATE `business_expense_list` SET `status`='$departmentstatus' WHERE `company_id`='$company_id' AND `kuch`='5'";
    // mysqli_query($con, $cvb);

    // $cvxb="UPDATE `business_expense_list` SET `status`='$everydaystatus' WHERE `company_id`='$company_id' AND `kuch`='6'";
    // mysqli_query($con, $cvxb);

    // Check if the insert was successful and return the appropriate response
    if ($cc) {
        http_response_code(200);
        echo json_encode(["message" => "Buisness Expenses updated successfully", "code" => 200]);
    } else {
        http_response_code(500);
        echo json_encode(["error" => "Failed to update Buisness Expenses", "code" => 500]);
    }
} else {
    http_response_code(405);
    echo json_encode(["error" => "Method not allowed", "code" => 405]);
}

?>
