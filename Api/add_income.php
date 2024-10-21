<?php 
header("Content-Type: application/json");
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Allow-Headers: Access-Control-Allow-Headers,Content-Type, Access-Control-Allow-Methods, Authorization,X-Requested-With");

include('connection.php');

// Sanitize input data
$Userid = mysqli_real_escape_string($con, $_POST['userid']);
$bankid = mysqli_real_escape_string($con, $_POST['bankid']);
$Amount = mysqli_real_escape_string($con, $_POST['amount']);
$Datetime = mysqli_real_escape_string($con, $_POST['date']);
$Pmodeid = mysqli_real_escape_string($con, $_POST['paymentmode']);
$company_id = mysqli_real_escape_string($con, $_POST['company_id']);
$Detial = mysqli_real_escape_string($con, $_POST['description']);

// Handle file upload
$pImage = 'NULL';
$baseDirectory = "../images/expense/";

if (!is_dir($baseDirectory)) {
    mkdir($baseDirectory, 0755, true);
}

if (isset($_FILES["image"]) && $_FILES["image"]["error"] == UPLOAD_ERR_OK) {
    $imageFileInfo = pathinfo($_FILES["image"]["name"]);
    $pImage = $imageFileInfo['filename'] . "_" . time() . "." . $imageFileInfo['extension'];
    $imageDestinationPath = $baseDirectory . $pImage;
    
    if (move_uploaded_file($_FILES["image"]["tmp_name"], $imageDestinationPath)) {
        $pImage = "'" . mysqli_real_escape_string($con, $pImage) . "'";
    } else {
        echo json_encode(["error" => "Failed to move uploaded file." , "code"=> 400]);
        exit();
    }
}else {
    $pImage = 'NULL';
}

// Insert data into add_income table
$query = "INSERT INTO `add_income`(`user_id`, `bank_id`, `amount`, `datetime`, `payment_mode`, `details`, `image`, `company_id`) VALUES ('$Userid','$bankid','$Amount','$Datetime','$Pmodeid','$Detial',$pImage, '$company_id')";

if (mysqli_query($con, $query)) {
    $income_id = mysqli_insert_id($con);

    // Fetch current amount from banks table
    $query3 = "SELECT `current_amount` FROM `banks` WHERE `id` = '$bankid'";
    $result = mysqli_query($con, $query3);
    if ($result) {
        $data = mysqli_fetch_assoc($result);
        $bank_current_amount = $data['current_amount'];
        $current_amount = $bank_current_amount + $Amount;

        // Insert data into bank_transaction table
        $query2 = "INSERT INTO `bank_transaction`(`income_id`, `user_id`, `bank_id`, `amount_add`, `amount_detect`, `current_amount`, `actual_amount`, `payment_mode`, `expense_id`, `date`, `company_id`) VALUES ('$income_id','$Userid','$bankid','$Amount','0','$current_amount','$bank_current_amount','$Pmodeid','0', '$Datetime', '$company_id')";
        if (mysqli_query($con, $query2)) {
            // Update current amount in banks table
            $update_query = "UPDATE `banks` SET `current_amount`='$current_amount' WHERE `id`='$bankid'";
            if (mysqli_query($con, $update_query)) {
                http_response_code(200);
                echo json_encode(array("code" => 200, "message" => "Income added successfully!", "last_id" => $income_id));
            } else {
                http_response_code(500);
                echo json_encode(array("code" => 500, "message" => "Failed to update bank amount! " . mysqli_error($con)));
            }
        } else {
            http_response_code(500);
            echo json_encode(array("code" => 500, "message" => "Failed to insert bank transaction! " . mysqli_error($con)));
        }
    } else {
        http_response_code(500);
        echo json_encode(array("code" => 500, "message" => "Failed to fetch current bank amount! " . mysqli_error($con)));
    }
} else {
    http_response_code(500);
    echo json_encode(array("code" => 500, "message" => "Failed to add income! " . mysqli_error($con)));
}
?>
