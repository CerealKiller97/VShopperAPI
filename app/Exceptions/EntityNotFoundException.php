<?php

declare(strict_types=1);

namespace App\Exceptions;

use Exception;
use Log;

class EntityNotFoundException extends Exception
{
    public function __construct(string $message = "", int $code = 404, Exception $previous = null)
    {
        parent::__construct("{$message} not found.", $code, $previous);
    }

    public function report(Exception $exception)
    {
        if ($exception instanceof EntityNotFoundException) {
            Log::error($exception->getMessage());
        }
    }
}
