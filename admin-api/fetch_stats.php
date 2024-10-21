<?php
include('../Api/connection.php');
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: POST, GET, OPTIONS");
header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept");


$company_id=$_POST['company_id'];

$dd="SELECT * FROM `general_expenses_list`";
$cc=mysqli_query($con, $dd);
$general_expenses_list=mysqli_num_rows($cc);

$dd2="SELECT * FROM `business_expense_list`";
$cc2=mysqli_query($con, $dd2);
$business_expense_list=mysqli_num_rows($cc2);

$dd3="SELECT * FROM `departments`";
$cc3=mysqli_query($con, $dd3);
$departments=mysqli_num_rows($cc3);

$dd4="SELECT * FROM `department_purchasing_list`";
$cc4=mysqli_query($con, $dd4);
$department_purchasing_list=mysqli_num_rows($cc4);

$dd5="SELECT * FROM `everday_expenses_list`";
$cc5=mysqli_query($con, $dd5);
$everday_expenses_list=mysqli_num_rows($cc5);


$dd6="SELECT * FROM `banks`";
$cc6=mysqli_query($con, $dd6);
$banks=mysqli_num_rows($cc6);

$dd7="SELECT * FROM `users`";
$cc7=mysqli_query($con, $dd7);
$users=mysqli_num_rows($cc7);

$dd8="SELECT * FROM `employees_list`";
$cc8=mysqli_query($con, $dd8);
$employees_list=mysqli_num_rows($cc8);


$dd9="SELECT * FROM `company-expense-type` WHERE `company_id`='$company_id' ";
$cc9=mysqli_query($con, $dd9);
$data = [];
while ($row = mysqli_fetch_assoc($cc9)) {
    $data[] = $row;
}

    $output['general_expenses_list'] = $general_expenses_list;
    $output['business_expense_list'] = $business_expense_list;
    $output['departments'] = $departments;
    $output['department_purchasing_list'] = $department_purchasing_list;
    $output['employees_list'] = $employees_list; 
    $output['banks'] = $banks; 
    $output['everday_expenses_list'] = $everday_expenses_list; 
    $output['users'] = $users; 
    $output['data'] = $data; 

    echo json_encode($output);
    ?>
