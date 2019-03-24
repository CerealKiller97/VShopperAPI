<?php

namespace App\Exceptions;

use Exception;

class InvalidDiscountException extends Exception
{
  public function __construct($message, $code = 409, Exception $previous = null)
  {
    parent::__construct($message, $code, $previous);
  }

  public function report(Exception $exception)
  {
    if ($exception instanceof InvalidDiscountException) {
      \Log::error($exception->getMessage());
    }
  }
}
