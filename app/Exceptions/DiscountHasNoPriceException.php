<?php

namespace App\Exceptions;

use Exception;

class DiscountHasNoPrice extends Exception
{
  public function __construct($message, $code = 404, Exception $previous = null)
  {
    parent::__construct($message, $code, $previous);
  }

  public function report(Exception $exception)
  {
    if ($exception instanceof DiscountHasNoPrice) {
      \Log::error($exception->getMessage());
    }
  }
}
