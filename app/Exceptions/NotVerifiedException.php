<?php

namespace App\Exceptions;

use Exception;

class NotVerifiedException extends Exception
{
  public function __construct($message, $code = 500, Exception $previous = null)
  {
    parent::__construct($message, $code, $previous);
  }

  public function report(Exception $exception)
  {
    if ($exception instanceof NotVerifiedException) {
      \Log::error($exception->getMessage());
    }
  }
}
