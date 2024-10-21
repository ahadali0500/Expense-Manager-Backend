<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: POST, GET, OPTIONS");
header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept");



include('connection.php');

$code = $_POST['code'];
$sql = "SELECT * FROM `codeRecoverPassword` WHERE `code`='$code'";
$queryResult = mysqli_query($con,$sql);


if (mysqli_num_rows($queryResult)>0) {
    http_response_code(200);
    echo json_encode(array("code" => 200));
} else {
    echo json_encode(array("code" => 400));
    http_response_code(400);
}
?>
