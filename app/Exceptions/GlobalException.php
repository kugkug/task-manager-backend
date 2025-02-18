<?php

namespace App\Exceptions;

use Exception;
use Throwable;

class GlobalException extends Exception
{
    private const MESSAGE = "Cannot continue, please try again later!";
    protected $message, $status_code;
    
    public function __construct($message=null, $status_code=500) {
        $this->message = $message ?? self::MESSAGE;
        $this->status_code = $status_code;
    }
    
    public function render() {         
        return response()->json([
            'status' => 'error',
            'message' => $this->message,
        ], $this->status_code);
    }
}