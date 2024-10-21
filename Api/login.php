<?php
header("Access-Control-Allow-Origin: *");
include('connection.php');
   
             $useremail=$_POST['email'];
             $userpassword=$_POST['password'];
             
             
           $Query = "SELECT * FROM `users` WHERE  email = '".$useremail."' AND password = '".$userpassword."'";
            //$Query;
            $run=mysqli_query($con,$Query);
           if(mysqli_num_rows($run) > 0)
            {
              $data=mysqli_fetch_assoc($run);
              http_response_code(200);
              $json['statusCode']=200;
              $json['data']=$data;
              echo json_encode($json);
            }
            else
            {
                http_response_code(200);
                $json['statusCode']=400;
                $json['message'] = "Invalid username or password";
                echo json_encode($json);
         
            }


 ?>