<?php
    header('Content-Type: application/json');
    $data = json_decode(file_get_contents("php://input"));
    $chiperText = $data->text;
    $varKey = $data->key;

    if($chiperText) {
        http_response_code(201);

        $dekripText = "";
        $dekripText = dekripsi($chiperText, $varKey);
        $dekripResult = Decipher($dekripText, 3);

        echo json_encode(array(
            "data" => $dekripResult,
            "message" => "convert success",
        ));

    } else {
        http_response_code(503);
        echo json_encode(array("message" => "convert failed"));
        
    }

    //dekripsi
    function dekripsi($chiperText, $varKey){
        $string = '';
 
        $key = strtoupper($key);
        $key = preg_replace('/[^A-Z]+/', '', $key);
 
        $alfabetSatu    = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $alfabetDua     = ' ' . $key;
        $alfabetDuaString = '';
 
        for ($h=0; $h < strlen($alfabetDua); $h++) { 
            $huruf = substr($alfabetDua, $h, 1);
 
            if(!strpos($alfabetDuaString, $huruf))
            {
                $alfabetDuaString.= $huruf;
            }
        }
 
        $alfabetDua = $alfabetDuaString;
 
        for ($i=0; $i < strlen($alfabetSatu); $i++) { 
            $huruf = substr($alfabetSatu, $i, 1);
 
            if(!strpos($alfabetDua, $huruf))
            {
                $alfabetDua.= $huruf;
            }
        }
 
        $alfabetDua = trim($alfabetDua);
 
        for ($j=0; $j < strlen($chiperText); $j++) { 
            $huruf = substr($chiperText, $j, 1);
            $posisi = strpos($alfabetDua, $huruf);
 
            $string.= substr($alfabetSatu, $posisi, 1);
        }
 
        return $string;
    }

     //convert string to uppercase
     function cltn($char){
        $char = strtoupper($char);
        $ord = ord($char);
        return ($ord > 64 && $ord < 91) ? ($ord - 64) : false;
    }

    function encrypt_cipher($str, $plus){

        if( is_numeric($plus) && $plus <= 26 && is_string($str) ) {
            $al = array('a', 'b', 'c', 'd', 'e', 'f', 'g', 'h', 'i', 'j', 
            'k', 'l', 'm', 'n', 'o', 'p', 'q', 'r', 's', 't', 'u', 'v', 'w',
            'x', 'y', 'z');
            $nstr = '';

            foreach( str_split($str) as $i => $v ) {
                if( cltn($v) ) {
                    $ltn = cltn($v) - 1;
                        if( ( $ltn + $plus ) > 25 ) {
                            $nstr .= $al[( $ltn + $plus ) - 25];
                        }else{
                            $nstr .= $al[$ltn+$plus];
                        }
                    }else{
                        $nstr .= $v;
                    }
                }
                return $nstr;
        }else{
            return false;	
        }
    }

    function Cipher($ch, $key){
        if (!ctype_alpha($ch))
            return $ch;
        $offset = ord(ctype_upper($ch) ? 'A' : 'a');
        return chr(fmod(((ord($ch) + $key) - $offset), 26) + $offset);
	}

    error_reporting(E_ALL ^ (E_NOTICE | E_WARNING));
    function Encipher($input, $key) {
        $output = "";

        $inputArr = str_split($input);
        foreach ($inputArr as $ch)
            $output .= Cipher($ch, $key);

        return $output;
    }

    error_reporting(E_ALL ^ (E_NOTICE | E_WARNING));
    function Decipher($input, $key)
        {
            return Encipher($input, 26 - $key);
        }


?>