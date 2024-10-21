<?php
include('../Api/connection.php');

// Set headers for CORS and content type
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: POST, GET, OPTIONS");
header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept");

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $bank_id = mysqli_real_escape_string($con, $_POST['bank_id']);
    $company_id = mysqli_real_escape_string($con, $_POST['company_id']);
    // Fetch data from the 'banks' table
    $query = "SELECT * FROM `banks` WHERE `id`='$bank_id' AND `company_id` = '$company_id' ";
    $result = mysqli_query($con, $query);
    
    if ($result) {
        $data = mysqli_fetch_assoc($result);

        http_response_code(200);
        echo json_encode(["code" => 200, "data" => $data]);
    } else {
        http_response_code(500);
        echo json_encode(["code" => 500, "error" => "Failed to fetch banks"]);
    }
} else {
    http_response_code(405);
    echo json_encode(["code" => 405, "error" => "Method not allowed"]);
}
?>
