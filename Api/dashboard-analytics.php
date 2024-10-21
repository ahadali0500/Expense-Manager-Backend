<?php
include('../Api/connection.php');

// Set headers for CORS and content type
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: POST, GET, OPTIONS");
header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept");

    $company_id = $_POST['company_id'];
    // Fetch data from the 'banks' table
    $query = "SELECT * FROM `bank_transaction` WHERE `company_id` = '$company_id'";
    $result = mysqli_query($con, $query);
    
    if ($result) {
        $income = 0;
        $spending = 0;


        while ($row = mysqli_fetch_assoc($result)) {
            $income = $income + $row['amount_add'];
            $spending = $spending + $row['amount_detect'];

        }

        http_response_code(200);
        echo json_encode(["code" => 200, "income" => $income, "spending"=> $spending]);
    } else {
        http_response_code(500);
        echo json_encode(["code" => 500, "error" => "Failed to fetch banks"]);
    }

?>
