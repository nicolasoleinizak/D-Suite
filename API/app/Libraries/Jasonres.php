<?php

namespace App\Libraries;

class Jasonres{
    
    public static function success($message, $data = []){
        return response()->json([
            'success' => true,
            'message' => isset($message)? $message : '',
            'data' => $data
        ]);
    }
    
    public static function error ($error_code, $alternative_message = '') {

        if(ErrorMessage::code_exists($error_code)){
            $message = ErrorMessage::get($error_code);
        }
        elseif($alternative_message != ''){
            $message = $alternative_message;
        }
        else{
            $message = 'Undefined error';
        }

        return response()->json([
            'success' => false,
            'error_code' => $error_code,
            'message' => $message
        ]);
    }

    
}