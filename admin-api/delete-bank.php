<?php
include('../Api/connection.php');

// Set headers for CORS and content type
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: DELETE, GET, OPTIONS");
header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept");


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Sanitize and validate input
    $bank_id = mysqli_real_escape_string($con, $_POST['bank_id']);

    // Check if bank exists
    $checkQuery = "SELECT * FROM `banks` WHERE `id`='$bank_id'";
    $checkResult = mysqli_query($con, $checkQuery);

    if (mysqli_num_rows($checkResult) > 0) {
        // Delete bank record from database
        $deleteQuery = "DELETE FROM `banks` WHERE `id`='$bank_id'";
        $deleteResult = mysqli_query($con, $deleteQuery);

        if ($deleteResult) {
            http_response_code(200);
            echo json_encode(["message" => "Bank deleted successfully", "code" => 200]);
        } else {
            http_response_code(500);
            echo json_encode(["error" => "Failed to delete bank", "code" => 500]);
        }
    } else {
        http_response_code(404);
        echo json_encode(["error" => "Bank not found", "code" => 404]);
    }
} else {
    http_response_code(405);
    echo json_encode(["error" => "Method not allowed", "code" => 405]);
}

?>
