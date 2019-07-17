<?php

namespace App\Exceptions;

use Exception;
use Log;

class NotVerifiedException extends Exception
{
    public function __construct(string $message, $code = 409, Exception $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }

    public function report(Exception $exception)
    {
        if ($exception instanceof NotVerifiedException) {
            Log::error($exception->getMessage());
        }
    }
}
