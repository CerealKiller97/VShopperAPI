<?php

namespace App\Services;

use App\Helpers\PolicyChecker;
use Illuminate\Database\Eloquent\Builder as Model;

abstract class BaseService
{
  protected $policy;

  public function __construct(PolicyChecker $policy)
  {
    $this->policy =  $policy;
  }

  // FIX: Fix name response count back to front

  public function generatePagedResponse(Model $model, $perPage, $page, $name = null)
  {
    if ($perPage) {
      $model->limit($perPage);
    }

    if ($page) {
      $model->offset(($page - 1) * $perPage)->limit($perPage);
    }

    if ($name) {
      $model->whereRaw('LOWER(`name`) LIKE ? ',[trim(strtolower($name)).'%']);
      // $model->whereRaw('name', 'LIKE', '%' . strtolower($name));
    }

    return $model->get();
  }
}
