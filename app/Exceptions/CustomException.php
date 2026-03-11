<?php

namespace App\Exceptions;

use Exception;

class CustomException extends Exception
{

public function render($request)
{
    return response()->json([
        'status'=>false,
        'message'=>$this->getMessage()
    ],400);
}

}