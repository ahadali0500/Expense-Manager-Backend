<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: POST, GET, OPTIONS");
header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept");

include ('connection.php');

$result=array();

$stmt = $con->prepare("SELECT * FROM everday_expenses_list WHERE `company_id`='$company_id'");


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