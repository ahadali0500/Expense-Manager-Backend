<?php
include('../Api/connection.php');
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: POST, GET, OPTIONS");
header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept");

$email = $_POST['email'];
$password = $_POST['password'];
$dd="SELECT * FROM `company` WHERE `email`='$email' AND `password`='$password'";
$cc=mysqli_query($con, $dd);
if(mysqli_num_rows($cc)>0){
    $data=mysqli_fetch_assoc($cc);
    $company_id=$data['id'];
    $ddc="SELECT * FROM `company-expense-type` WHERE `company_id`='$company_id'";
    $ccx=mysqli_query($con, $ddc);
    $dt=[];
    while($dat=mysqli_fetch_assoc($ccx)){
    $dt[]=$dat;
    }
    http_response_code(200);
    $output['code'] = 200;
    $output['data'] = $data;
    $output['expenseCate'] = $dt;
  
    echo json_encode($output);

}else {
    http_response_code(404);
    $output['code'] = 404;
    $output['data'] = "";
    echo json_encode($output);
}

return $output;
?>
