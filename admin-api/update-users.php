<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: POST, GET, OPTIONS");
header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept");

include "../Api/connection.php";
$access = $_POST['access'];
$id = $_POST['id'];

$query = "UPDATE `users` SET `access`='$access' WHERE `id`='$id'";
$dt = mysqli_query($con, $query);
if ($dt) {
    http_response_code(200);
    echo json_encode([
        "message" => "Access assigned successfully!",
        "code" => 200,
    ]);
} else {
    http_response_code(500);
    echo json_encode([
        "message" => " Registration failed. Please try again later.",
        "code" => 500,
    ]);
}

?>
