<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: POST, GET, OPTIONS");
header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept");

include ('connection.php');

$result=array();
$company_id = mysqli_real_escape_string($con, $_POST['company_id']);
$stmt = $con->prepare("SELECT * FROM general_expenses_list WHERE `company_id`='$company_id'");

if($stmt->execute()){
   $stmt=$stmt->get_result();
   while($row = $stmt->fetch_assoc()){
      array_push($result, $row);
   }    
   http_response_code(200);
   echo json_encode($result);
}else{
    $output['message'] = "Unable to fetch Data";
    echo json_encode($output);
    http_response_code(400);
}