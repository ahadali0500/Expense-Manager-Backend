<?php
include('../Api/connection.php');

// Set headers for CORS and content type
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: POST, GET, OPTIONS");
header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept");

 
    // Sanitize and validate input
    $name = mysqli_real_escape_string($con, $_POST['name']);
    $email = mysqli_real_escape_string($con, $_POST['email']);
    $password = mysqli_real_escape_string($con, $_POST['password']);

    $dd="SELECT * FROM `company` WHERE `email`='$email'";
    $cc=mysqli_query($con, $dd);
    if(mysqli_num_rows($cc)>0){
        http_response_code(200);
        echo json_encode(["message" => "Email is already used!", "code" => 400]);
        die();
    }
    // Default value for image
    $pImage = 'NULL';
    $baseDirectory = "../images/company/";

    // Create directory if not exists
    if (!is_dir($baseDirectory)) {
        mkdir($baseDirectory, 0755, true);
    }

    // Handle file upload
    if (isset($_FILES["image"]) && $_FILES["image"]["error"] == UPLOAD_ERR_OK) {
        $imageFileInfo = pathinfo($_FILES["image"]["name"]);
        $pImage = $imageFileInfo['filename'] . "_" . time() . "." . $imageFileInfo['extension'];
        $imageDestinationPath = $baseDirectory . $pImage;

        if (move_uploaded_file($_FILES["image"]["tmp_name"], $imageDestinationPath)) {
            $pImage = "'" . mysqli_real_escape_string($con, $pImage) . "'";
        } else {
            http_response_code(500);
            echo json_encode(["error" => "Failed to move uploaded file", "code" => 500]);
            exit();
        }
    }

    // Insert data into the database
    $query = "INSERT INTO `company`(`name`, `email`, `password`, `logo`) VALUES ('$name','$email','$password',$pImage)";
    $result = mysqli_query($con, $query);
    $company_id = mysqli_insert_id($con);


    $ccc="INSERT INTO `company-expense-type`(`expense_type_id`, `company_id`, `expense_name`) VALUES (1,'$company_id','General Expense')";
    mysqli_query($con, $ccc);

    $cx="INSERT INTO `company-expense-type`(`expense_type_id`, `company_id`, `expense_name`) VALUES (2,'$company_id','Bussiness Expense')";
    mysqli_query($con, $cx);

    $xzxc="INSERT INTO `business_expense_list`(`name`, `status`, `company_id`, `kuch`) VALUES ('Department Expense','1','$company_id','5')";
    mysqli_query($con, $xzxc);

    $xzxcxx="INSERT INTO `business_expense_list`(`name`, `status`, `company_id`, `kuch`) VALUES ('Everyday Expense','1','$company_id','6')";
    mysqli_query($con, $xzxcxx);

    $xzxcxx33="INSERT INTO `department_expense`(`name`, `dpt_expense_type`, `company_id`, `status`) VALUES ('Compensation','1','$company_id','1')";
    mysqli_query($con, $xzxcxx33);

    $xzxcxx33="INSERT INTO `department_expense`(`name`, `dpt_expense_type`, `company_id`, `status`) VALUES ('Purchasing Tools','2','$company_id','1')";
    mysqli_query($con, $xzxcxx33);

    $xzxcxcvv="INSERT INTO `compensation_list`(`type`, `company_id`, `comp_id_type`, `status`) VALUES ('Employees','$company_id','1','1')";
    mysqli_query($con, $xzxcxcvv);

    $xzxcx334jdn="INSERT INTO `compensation_list`(`type`, `company_id`, `comp_id_type`, `status`) VALUES ('Invsertor/Partnership','$company_id','2','1')";
    mysqli_query($con, $xzxcx334jdn);

    $xzxcxx3ss3="INSERT INTO `compensation_list`(`type`, `company_id`, `comp_id_type`, `status`) VALUES ('Contractor','$company_id','3','1')";
    mysqli_query($con, $xzxcxx3ss3);
    

    // Check if the insert was successful and return the appropriate response
    if ($result) {
        http_response_code(200);
        echo json_encode(["message" => "Company added successfully", "code" => 200]);
    } else {
        http_response_code(500);
        echo json_encode(["error" => "Failed to add Company", "code" => 500]);
    }

?>
