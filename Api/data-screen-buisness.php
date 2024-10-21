<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: POST, GET, OPTIONS");
header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept");

include ('connection.php');

$result = array();

$user_id = $_POST['user_id'];
$expense_type_id = $_POST['expense_type_id'];
$company_id = $_POST['company_id'];
$buisness_expense_id = $_POST['buisness_expense_id'];

// Sanitize inputs
$user_id = mysqli_real_escape_string($con, $user_id);
$company_id = mysqli_real_escape_string($con, $company_id);
$expense_type_id = mysqli_real_escape_string($con, $expense_type_id);
$buisness_expense_id = mysqli_real_escape_string($con, $buisness_expense_id);

// Build the query with conditional logic
$query = "SELECT * FROM `add-expense` WHERE `expense_type_id`='$expense_type_id' AND `buisness_expense_id`='$buisness_expense_id' AND `company_id` = '$company_id'";
if ($user_id != 0) {
    $query .= " AND `user_id`='$user_id'";
}
$query .= " ORDER BY `add-expense`.`date` DESC";
$stmt = $con->prepare($query);

if ($stmt->execute()) {
    $stmt = $stmt->get_result();
    while ($row = $stmt->fetch_assoc()) {
        array_push($result, $row);
    }
    http_response_code(200);
    echo json_encode($result);
} else {
    $output['message'] = "Unable to fetch Data";
    echo json_encode($output);
    http_response_code(400);
}
?>
