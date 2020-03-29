<?php
    header('Content-Type: application/json');
    $data = json_decode(file_get_contents("php://input"));
    $var = $data->text;

    if ($var) {
        http_response_code(201);
        $str = "";
        $arr = explode(".", $var);

        //convert ascii to text
        // for ($i=0; $i<strlen($str); $i++) {
        //     $str_ar[$i] = chr($str[$i]);
        //     $str = $str.$str_ar[$i];
        // }
        
        for($i=0; $i<count($arr); $i++) {
            $str_arr[$i] = chr($arr[$i]);
            $str = $str_arr[$i];
        }
        

        echo json_encode(array(
            "data" => $str,
            "message" => "convert success"
        ));
    } 
    else {
        http_response_code(503);
        echo json_encode(array("message" => "Unable to convert"));
    }
?>