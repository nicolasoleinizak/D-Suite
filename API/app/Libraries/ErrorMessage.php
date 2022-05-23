<?php

namespace App\Libraries;

class ErrorMessage{

    static $error_messages = [
        'AUT001' => 'The user is not logged',
        'AUT002' => 'The user has not permission to access this organization',
        'AUT003' => 'The user has not permissions to read on this module',
        'AUT004' => 'The user has not permissions to write on this module',
        'AUT005' => 'The user has not superadmin permissions',
        'REQ001' => 'There is an error with the information provided, or the provided information is not enough',
        'REQ002' => 'The required information was not found on the database',
        'REQ003' => 'The id provided does not match with the organization',
        'SRV001' => 'Internal server error'
    ];

    public static function code_exists($error_code){
        return array_key_exists($error_code, self::$error_messages);
    }

    public static function get($error_code){
        if(self::code_exists($error_code)){
            return self::$error_messages[$error_code];
        } else {
            return null;
        }
    }
}