<?php

namespace App\Libraries;

class Jasonres{

    public static function respond(array $status, $data = []) {

        $success = false;
        $error_code = null;
        $message = '';

        if(isset($status['success'])){
            if(!$status['success']){
                $success = false;
                if(isset($status['error_code'])){
                    $error_code = $status['error_code'];
                }
                if(ErrorMessage::code_exists($error_code)){
                    $message = ErrorMessage::get($error_code);
                }
                elseif(isset($status['message'])){
                    $message = $status['message'];
                }
                else{
                    $message = 'Undefined error';
                }
            }
        } else {
            $success = true;
            if(isset($status['message'])){
                $message = $status['message'];
            }
        }

        return response()->json([
            'success' => $success, 
            'error_code' => $error_code,
            'message' => $message,
            'data' => $data
        ]);
    }
    
}