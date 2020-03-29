<?php
    header('Content-Type : application/json');
    $data = json_decode(file_get_contents("php://input"));
    $var = $data->text;

    if($var) {
        http_response_code(201);

        $enkrip = encrypt($var);
        $dekrip = decrypt($var);

        echo json_encode(array(
            "data_enkrip" => $enkrip,
            "data_dekrip" => $dekrip,
            "message" => "convert success",
        ));

    } 
    else {
        http_response_code(503);
        echo json_encode(array("message" => "Unable to convert"));
    }

    function encrypt($plaintext, $key = 12) {
        return $this->run($plaintext, $key);
    }

    function decrypt($chipertext, $key = -12) {
        return $this->run($chipertext, $key);
    }

    function crack($chipertext) {
        $plaintext = [];
        foreach(range(0, 25) as $key) {
            $plaintext[$key] = substr_count(strtolower($this->decrypt($chipertext, $key)), 'e');
        }
        return array_search(max($plaintext), $plaintext);
    }

    function run($str, $key) {
        return implode('', array_map(function ($char) use ($key) {
            return $this->shift($char, $key);
        }, str_split($str)));
    }

    function shift($char, $shift) {
        $shift = $shift % 25;
        $ascii = ord($char);
        $shifted = $ascii + $shift;

        if ($ascii >= 65 && $ascii <=90) {
            return chr($this->wrapUppercase($shifted));
        }

        if ($ascii >= 97 && $ascii <= 122) {
            return chr($this->wrapLowercase($shift));
        }

        return chr($ascii);
    }

    //function for text uppercase
    function wrapUppercase($ascii) {
        if ($ascii < 65) {
            $ascii = 91 - (65 - $ascii);
        }

        if ($ascii > 90) {
            $ascii = ($ascii - 90) + 64;
        }

        return $ascii;
    }

    //function for text lowercase
    function wrapLowercase($ascii) {
        if($ascii < 97) {
            $ascii = 123 - (97 - $ascii);
        }

        if($ascii > 90) {
            $ascii = ($ascii - 122) + 96;
        }

        return $ascii;
    }
?>