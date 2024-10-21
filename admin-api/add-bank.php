<?php
include('../Api/connection.php');

// Set headers for CORS and content type
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: POST, GET, OPTIONS");
header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept");

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    
    function getFormattedDate() {
        $date = new DateTime();
        $date->setTime(0, 0, 0);
        return $date->format('Y-m-d H:i:s');
    }

    $date=getFormattedDate();
    // Sanitize and validate input
    $bank_name = mysqli_real_escape_string($con, $_POST['bank_name']);
    $current_amount = filter_var($_POST['current_amount'], FILTER_VALIDATE_FLOAT);
    $actual_amount = filter_var($_POST['actual_amount'], FILTER_VALIDATE_FLOAT);
    $status = mysqli_real_escape_string($con, $_POST['status']);
    $company_id = mysqli_real_escape_string($con, $_POST['company_id']);

    if ($current_amount === false || $actual_amount === false) {
        http_response_code(400);
        echo json_encode(["error" => "Invalid numeric values", "code" => 400]);
        exit();
    }

    // Default value for image
    $pImage = null;
    $baseDirectory = "../images/bank/";

    // Create directory if not exists
    if (!is_dir($baseDirectory) && !mkdir($baseDirectory, 0755, true)) {
        http_response_code(500);
        echo json_encode(["error" => "Failed to create directory for image uploads", "code" => 500]);
        exit();
    }
 
    // Handle file upload
    if (isset($_FILES["image"]) && $_FILES["image"]["error"] == UPLOAD_ERR_OK) {
        $imageFileInfo = pathinfo($_FILES["image"]["name"]);
        $pImage = $imageFileInfo['filename'] . "_" . time() . "." . $imageFileInfo['extension'];
        $imageDestinationPath = $baseDirectory . $pImage;

        // Validate file type
        $allowedTypes = ['jpg', 'jpeg', 'png', 'gif'];
        if (!in_array(strtolower($imageFileInfo['extension']), $allowedTypes)) {
            http_response_code(400);
            echo json_encode(["error" => "Invalid file type", "code" => 400]);
            exit();
        }

        if (!move_uploaded_file($_FILES["image"]["tmp_name"], $imageDestinationPath)) {
            http_response_code(500);
            echo json_encode(["error" => "Failed to move uploaded file", "code" => 500]);
            exit();
        }
    }

    // Use prepared statements to prevent SQL injection
    $query = "INSERT INTO `banks`(`bank_name`, `current_amount`, `actual_amount`, `image`, `status`, `company_id`) VALUES (?, ?, ?, ?, ?, ?)";
    $stmt = mysqli_prepare($con, $query);

    $bank_id = mysqli_insert_id($con);

    // $ff="INSERT INTO `bank_transaction`(`income_id`, `user_id`, `bank_id`, `amount_add`, `amount_detect`, `current_amount`, `actual_amount`, `payment_mode`, `expense_id`, `date`, `company_id`) VALUES ('0','0','$bank_id','$current_amount','0','$current_amount','$current_amount','16','0','$date','$company_id')";
    // mysqli_query($con, $ff);

    if ($stmt) {
        mysqli_stmt_bind_param($stmt, "sddssi", $bank_name, $current_amount, $actual_amount, $pImage, $status, $company_id);

        if (mysqli_stmt_execute($stmt)) {
            http_response_code(200);
            echo json_encode(["message" => "Bank added successfully", "code" => 200]);
        } else {
            http_response_code(500);
            echo json_encode(["error" => "Failed to add bank", "code" => 500, "details" => mysqli_stmt_error($stmt)]);
        }

        mysqli_stmt_close($stmt);
    } else {
        http_response_code(500);
        echo json_encode(["error" => "Failed to prepare statement", "code" => 500, "details" => mysqli_error($con)]);
    }

} else {
    http_response_code(405);
    echo json_encode(["error" => "Method not allowed", "code" => 405]);
}
?>
