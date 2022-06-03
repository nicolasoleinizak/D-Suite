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
            $message = ErrorMessage::get($error_code).
                $alternative_message != ''? '. '.$alternative_message : '.';
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

    public static function sendData($data){
        if($data){
            return self::success('', $data);
        } else{
            return self::error('REQ002');
        }
    }

    
}