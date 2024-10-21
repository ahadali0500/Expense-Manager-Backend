<?php
include('../Api/connection.php');

// Set headers for CORS and content type
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: POST, GET, OPTIONS");
header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept");


    $company_id = mysqli_real_escape_string($con, $_POST['company_id']);

    // Fetch data from the 'banks' table
    $query = "SELECT * FROM `business_expense_list` WHERE `company_id`='$company_id' ";
    $result = mysqli_query($con, $query);
    
    if ($result) {
        $banks = [];

        while ($row = mysqli_fetch_assoc($result)) {
            $banks[] = $row;
        }

        http_response_code(200);
        echo json_encode(["code" => 200, "data" => $banks]);
    } else {
        http_response_code(500);
        echo json_encode(["code" => 500, "error" => "Failed to fetch banks"]);
    }

?>
