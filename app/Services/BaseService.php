<?php

namespace App\Services;

use App\Helpers\PolicyChecker;

class BaseService
{
  protected $policy;
  protected $user;

  public function __construct(PolicyChecker $policy)
  {
    $this->policy =  $policy;
  }
  // public function __construct()
  // {
  //   $this->user = Auth::user() ?? null;
  // }

}
