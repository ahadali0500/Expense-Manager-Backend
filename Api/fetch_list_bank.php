<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: POST, GET, OPTIONS");
header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept");

include ('connection.php');

$result=array();
$company_id = mysqli_real_escape_string($con, $_POST['company_id']);
$stmt = $con->prepare("SELECT * FROM banks WHERE `company_id`='$company_id'");


if($stmt->execute()){
   $stmt=$stmt->get_result();
   while($row = $stmt->fetch_assoc()){
      array_push($result, $row);
   }  
   $query = "SELECT * FROM `bank_transaction`";
   $result_2 = mysqli_query($con, $query);

       if ($result_2) {
        $income = 0;
        $spending = 0;
        while ($row_2 = mysqli_fetch_assoc($result_2)) {
            $income = $income + $row_2['amount_add'];
            $spending = $spending + $row_2['amount_detect'];
        }
        http_response_code(200);
        echo json_encode(["code" => 200, "income" => $income, "spending"=> $spending,  "data"=> $result]);
    } else {
        http_response_code(500);
        echo json_encode(["code" => 500, "error" => "Failed to fetch banks"]);
    }  
}else{
    $output['message'] = "Unable to fetch Data";
    echo json_encode($output);
    http_response_code(400);
}