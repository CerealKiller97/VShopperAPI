<?php

namespace App\Exceptions;

use Exception;

class BatchDeleteException extends Exception
{
  public function __construct($message, $code = 409, Exception $previous = null)
  {
    parent::__construct($message, $code, $previous);
  }

  public function report(Exception $exception)
  {
    if ($exception instanceof BatchDeleteException) {
      \Log::error($exception->getMessage());
    }
  }
}
