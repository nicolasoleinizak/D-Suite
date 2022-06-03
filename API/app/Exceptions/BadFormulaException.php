<?php

namespace App\Exceptions;

use Exception;
use App\Libraries\Jasonres;

class BadFormulaException extends Exception
{
    public function __construct($message){
        $this->message = $message;
    }
    public function render($request)
    {
        return Jasonres::error('REQ001', 'The formula is not well formed. '.$this->message);
    }
}
