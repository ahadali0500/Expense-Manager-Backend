<?php 
header("Content-Type: application/json");
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Allow-Headers: Access-Control-Allow-Headers,Content-Type, Access-Control-Allow-Methods, Authorization,X-Requested-With");

include('connection.php');

// Sanitize and validate input
$expense_type_id = isset($_POST['expense_type_id']) ? intval($_POST['expense_type_id']) : 0;
$general_expense_id = isset($_POST['general_expense_id']) ? intval($_POST['general_expense_id']) : 0;
$buisness_expense_id = isset($_POST['buisness_expense_id']) ? intval($_POST['buisness_expense_id']) : 0;
$department_id = isset($_POST['department_id']) ? intval($_POST['department_id']) : 0;
$departments_expense_id = isset($_POST['departments_expense_id']) ? intval($_POST['departments_expense_id']) : 0;
$departments_compensation_id = isset($_POST['departments_compensation_id']) ? intval($_POST['departments_compensation_id']) : 0;
$departments_employee_id = isset($_POST['departments_employee_id']) ? intval($_POST['departments_employee_id']) : 0;
$departments_purchase_id = isset($_POST['departments_purchase_id']) ? intval($_POST['departments_purchase_id']) : 0;
$payment_mode_id = isset($_POST['payment_mode_id']) ? intval($_POST['payment_mode_id']) : 0;
$amount = isset($_POST['amount']) ? floatval($_POST['amount']) : 0;
$description = isset($_POST['description']) ? $_POST['description'] : '';
$bank_id = isset($_POST['bank_id']) ? intval($_POST['bank_id']) : 0;
$user_id = isset($_POST['user_id']) ? intval($_POST['user_id']) : 0;
$company_id = isset($_POST['company_id']) ? intval($_POST['company_id']) : 0;
$everyday_expense_id = isset($_POST['everyday_expense_id']) ? intval($_POST['everyday_expense_id']) : 0;
$date = isset($_POST['date']) ? $_POST['date'] : '';
$transaction_by = isset($_POST['transaction_by']) ? intval($_POST['transaction_by']) : 0;

$description = mysqli_real_escape_string($con, $description);
$date = mysqli_real_escape_string($con, $date);

// Fetch bank data
$bb = "SELECT * FROM `banks` WHERE `id` = '$bank_id' AND `company_id` = '$company_id'";
$bbdt = mysqli_query($con, $bb);
$bankData = mysqli_fetch_assoc($bbdt);

if (!$bankData) {
    echo json_encode(["message" => "Bank not found!", "code"=> 400]);
    exit();
}

$bank_current_amount = $bankData['current_amount'];
$current_amount = $bank_current_amount - $amount;

if ($bank_current_amount <= 0 || $amount > $bank_current_amount) {
    echo json_encode(["message" => "Bank account does not have sufficient balance!", "code"=> 400]);
    exit();
}

// Handle file upload
$pImage = 'NULL';
$baseDirectory = "../images/expense/";

if (!is_dir($baseDirectory)) {
    mkdir($baseDirectory, 0755, true);
}

if (isset($_FILES["screenshot"]) && $_FILES["screenshot"]["error"] == UPLOAD_ERR_OK) {
    $imageFileInfo = pathinfo($_FILES["screenshot"]["name"]);
    $pImage = $imageFileInfo['filename'] . "_" . time() . "." . $imageFileInfo['extension'];
    $imageDestinationPath = $baseDirectory . $pImage;

    if (!move_uploaded_file($_FILES["screenshot"]["tmp_name"], $imageDestinationPath)) {
        echo json_encode(["error" => "Failed to move uploaded file.", "code"=> 400]);
        exit();
    }
    $pImage = "'" . mysqli_real_escape_string($con, $pImage) . "'";
}

// Insert expense
$query = "INSERT INTO `add-expense` (`user_id`,`bank_id`,`expense_type_id`, `general_expense_id`, `buisness_expense_id`, `department_id`, `departments_expense_id`, `departments_compensation_id`, `departments_employee_id`, `departments_purchase_id`, `payment_mode_id`, `everyday_expense_id`, `amount`, `date`, `description`, `screenshot`, `transaction_by`, `company_id`) 
VALUES ($user_id, $bank_id, $expense_type_id, $general_expense_id, $buisness_expense_id, $department_id, $departments_expense_id, $departments_compensation_id, $departments_employee_id, $departments_purchase_id, $payment_mode_id, $everyday_expense_id, $amount, '$date', '$description', $pImage, '$transaction_by', '$company_id')";

if (mysqli_query($con, $query)) {
    $expense_id = mysqli_insert_id($con);

    // Insert bank transaction
    $bt = "INSERT INTO `bank_transaction`(`income_id`, `user_id`, `bank_id`, `amount_add`, `amount_detect`, `current_amount`, `actual_amount`, `payment_mode`, `expense_id`, `date`, `company_id`) 
    VALUES ('0', '$user_id', '$bank_id', '0', '$amount', '$current_amount', '$bank_current_amount', '$payment_mode_id', '$expense_id', '$date', '$company_id')";

    if (mysqli_query($con, $bt)) {
        $cvv = "UPDATE `banks` SET `current_amount`='$current_amount' WHERE `id` = '$bank_id'";
        mysqli_query($con, $cvv);

        echo json_encode(["message" => "New expense added successfully.", "code"=> 200]);
    } else {
        echo json_encode(["error" => "Failed to insert bank transaction.", "code"=> 400]);
    }
} else {
    echo json_encode(["error" => "Failed to add expense.", "code"=> 400]);
}
?>
