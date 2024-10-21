<?php
include('../Api/connection.php');

// Set headers for CORS and content type
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: POST, GET, OPTIONS");
header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept");

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $company_id = mysqli_real_escape_string($con, $_POST['company_id']);
    // Fetch data from the 'banks' table
    $query = "SELECT * FROM `business_expense_list` WHERE `company_id`='$company_id' AND (`kuch`='6' OR `kuch`='5')";
    $result = mysqli_query($con, $query);
    
    if ($result) {
        $data=[];
        while($dt = mysqli_fetch_assoc($result)){
             $data[]=$dt;
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
