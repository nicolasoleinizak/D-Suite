<?php

namespace App\Libraries;

class JSONResponse{
    public $success;
    public $error_code = null;
    public $message = "";
    public $data;

    function __construct (array $status, iterable $data = []) {

        $this->data = $data;

        if(isset($status['success'])){
            if(!$status['success']){
                $this->success = false;
                if(isset($status['error_code'])){
                    $this->error_code = $status['error_code'];
                }
                if(ErrorMessage::code_exists($this->error_code)){
                    $this->message = ErrorMessage::get($this->error_code);
                }
                elseif(isset($status['message'])){
                    $this->message = $status['message'];
                }
                else{
                    $this->message = 'Undefined error';
                }
            }
        } else {
            $this->success = true;
            if(isset($status['message'])){
                $this->message = $status['message'];
            }
        }
    }
    
}