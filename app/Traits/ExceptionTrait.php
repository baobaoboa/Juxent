<?php

namespace App\Traits;
use Illuminate\Validation\ValidationException;

trait ExceptionTrait {
    private function throwException($errorCode,$message) {
        throw ValidationException::withMessages([
            'message' => $message[0],
            'code' => $errorCode[0]
        ]);
    }
}

