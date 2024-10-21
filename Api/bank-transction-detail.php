<?php
include('../Api/connection.php');

// Set headers for CORS and content type
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: POST, GET, OPTIONS");
header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept");

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $bank_id = mysqli_real_escape_string($con, $_POST['bank_id']);
    $user_id = mysqli_real_escape_string($con, $_POST['user_id']);
    $company_id = mysqli_real_escape_string($con, $_POST['company_id']);
    
    // Fetch data from the 'banks' table
$query = "SELECT * FROM `bank_transaction` WHERE `bank_id`='$bank_id' AND `company_id`='$company_id'";

// Check if user_id is not zero, add the condition for user_id
if ($user_id != 0) {
    $query .= " AND `user_id`='$user_id'";
}

// Add the ORDER BY clause
$query .= " ORDER BY `bank_transaction`.`date` DESC";
$result = mysqli_query($con, $query);
    
    if ($result) {
        $data = [];

        while ($row = mysqli_fetch_assoc($result)) {
            $data[] = $row;
        }

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
