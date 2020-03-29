<?php
    header('Content-Type: application/json');
    $data = json_decode(file_get_contents("php://input"));
    $var = $data->text;
    print_r($data);
   
        if($var){
      
            // set response code - 201 created
            http_response_code(201);
            $ascii = "";
            //function convert texttoascii
            for ($i=0; $i<strlen($var); $i++) {
                    $ascii_ar[$i] = ord($var[$i]);
                    $ascii = $ascii.$ascii_ar[$i];
            }
            // var_dump($ascii);die;
            
            // tell the user
            echo json_encode(array(
                "data" => $ascii,
                "message" => "convert success",
            ));
        }
        else{
      
            // set response code - 503 service unavailable
            http_response_code(503);
      
            // tell the user
            echo json_encode(array("message" => "Unable to convert"));
        }

        function encrypt() {
            
    }
?>