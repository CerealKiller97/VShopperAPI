<?php

declare(strict_types=1);

namespace App\Exceptions;

use Exception;
use Log;

class BatchDeleteException extends Exception
{
    public function __construct(string $message, int $code = 409, Exception $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }

    public function report(Exception $exception)
    {
        if ($exception instanceof BatchDeleteException) {
            Log::error($exception->getMessage());
        }
    }
}
