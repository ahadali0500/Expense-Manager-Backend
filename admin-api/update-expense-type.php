<?php
header("Access-Control-Allow-Origin: *"); // Change this to your allowed origin(s) in production
header("Access-Control-Allow-Methods: POST, GET, OPTIONS");
header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept");

// if ($_SERVER['REQUEST_METHOD'] === 'POST') {
try {

    $output = array();
    include('../Api/connection.php');
    $company_id = $_POST['company_id'];
    $businessExpense = ($_POST['businessExpense']=="") ? "Business Expense" : $_POST['businessExpense'];
    $generalExpense = ($_POST['generalExpense']=="")? "General Expense" : $_POST['generalExpense'];
    $businessstatus = ($_POST['businessstatus']=="true") ? 0 : 1;
    $generalstatus = ($_POST['generalstatus']=="true") ? 0 : 1;
    $department = ($_POST['department']=="true" && $_POST['businessstatus']=="true") ? 0 : 1;
    $everyday = ($_POST['everyday']=="true" && $_POST['businessstatus']=="true") ? 0 : 1;
    $Compensations = ($_POST['Compensations']=="true" && $_POST['department']=="true" && $_POST['businessstatus']=="true") ? 0 : 1;
    $PurchasingTools = ($_POST['PurchasingTools']=="true" && $_POST['department']=="true" && $_POST['businessstatus']=="true") ? 0 : 1;
    $Employees = ($_POST['Employees']=="true" && $_POST['Compensations']=="true" && $_POST['department']=="true" && $_POST['businessstatus']=="true") ? 0 : 1;
    $Partnership = ($_POST['Partnership']=="true" && $_POST['Compensations']=="true" && $_POST['department']=="true" && $_POST['businessstatus']=="true") ? 0 : 1;
    $Contractor = ($_POST['Contractor']=="true" && $_POST['Compensations']=="true" && $_POST['department']=="true" && $_POST['businessstatus']=="true") ? 0 : 1;

// Update company-expense-type table
$sql = "UPDATE `company-expense-type` SET 
    `expense_name` = '$generalExpense', 
    `status` = '$generalstatus'
    WHERE `company_id` = '$company_id' AND `expense_type_id` = '1'";

$sql2 = "UPDATE `company-expense-type` SET 
    `expense_name` = '$businessExpense', 
    `status` = '$businessstatus' , `everyday`='$everyday', `department`='$department', `PurchasingTools`='$PurchasingTools', `Compensations`='$Compensations',
    `Contractor`='$Contractor', `Employees`='$Employees',  `Partnership`='$Partnership'
    WHERE `company_id` = '$company_id' AND `expense_type_id` = '2'";

if (mysqli_query($con, $sql)) {

    if(mysqli_query($con, $sql2)){
    $sql3 = "UPDATE `business_expense_list` SET 
        `status` = '$department' 
        WHERE `company_id` = '$company_id' AND `kuch` = '5'";
    mysqli_query($con, $sql3);

    $sql4 = "UPDATE `business_expense_list` SET 
        `status` = '$everyday'
        WHERE `company_id` = '$company_id' AND `kuch` = '6'";
    mysqli_query($con, $sql4);

    $sqlcc = "UPDATE `department_expense` SET `status` = '$Compensations' WHERE `company_id` = '$company_id' AND `dpt_expense_type` = '1'";
    mysqli_query($con, $sqlcc);
    $sqlccx = "UPDATE `department_expense` SET `status` = '$PurchasingTools' WHERE `company_id` = '$company_id' AND `dpt_expense_type` = '2'";
    mysqli_query($con, $sqlccx);

    $sqlcc = "UPDATE `compensation_list` SET `status` = '$Employees' WHERE `company_id` = '$company_id' AND `comp_id_type` = '1'";
    mysqli_query($con, $sqlcc);
    $sqlccx = "UPDATE `compensation_list` SET `status` = '$Partnership' WHERE `company_id` = '$company_id' AND `comp_id_type` = '2'";
    mysqli_query($con, $sqlccx);
    $sqlccx = "UPDATE `compensation_list` SET `status` = '$Contractor' WHERE `company_id` = '$company_id' AND `comp_id_type` = '3'";
    mysqli_query($con, $sqlccx);

    $ddc="SELECT * FROM `company-expense-type` WHERE `company_id`='$company_id'";
    $ccx=mysqli_query($con, $ddc);
    $dt=[];
    while($dat=mysqli_fetch_assoc($ccx)){
        $dt[]=$dat;
    }


        http_response_code(200);
        $output['code'] = 200;
        $output['expenseCate'] = $dt;
        $output['message'] = "Expenses updated successfully";

    }else{
        http_response_code(400);
        $output['code'] = 400;
        $output['message'] = "Failed to update Business Expenses";
    }
    
} else {
    http_response_code(400);
    $output['code'] = 400;
    $output['message'] = "Failed to update General Expenses";
}

} catch (Exception $e) {
    error_log($e->getMessage());
    $output['code'] = 500;
    $output['message'] = $e->getMessage();
}
// } else {
//     $output['code'] = 405;
//     $output['message'] = "Invalid request method";
// }

mysqli_close($con);
echo json_encode($output);
?>
