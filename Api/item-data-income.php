<?php
include('../Api/connection.php');

// Set headers for CORS and content type
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: POST, GET, OPTIONS");
header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept");

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = mysqli_real_escape_string($con, $_POST['id']);
    // Fetch data from the 'banks' table
    $query = "SELECT * FROM `add_income` WHERE `id`='$id AND `company_id`='$company_id''";
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
        echo json_encode(["code" => 500, "error" => "Failed to Income"]);
    }
} else {
    http_response_code(405);
    echo json_encode(["code" => 405, "error" => "Method not allowed"]);
}
?>
