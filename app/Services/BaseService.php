<?php

declare(strict_types=1);

namespace App\Services;

use App\Helpers\PolicyChecker;
use Illuminate\Database\Eloquent\Builder as Model;
use stdClass;

abstract class BaseService
{
    protected $policy;

    public function __construct(PolicyChecker $policy)
    {
        $this->policy = $policy;
    }

    public function generatePagedResponse(Model $model, stdClass $request)
    {
        if ($request->perPage) {
            $model->limit($request->perPage);
        }

        if ($request->page) {
            $model->offset(($request->page - 1) * $request->perPage)->limit($request->perPage);
        }

        if ($request->name) {
            $model->whereRaw('LOWER(`name`) LIKE ? ', [trim(strtolower($request->name)) . '%']);
            // $model->whereRaw('name', 'LIKE', '%' . strtolower($name));
        }

        return $model->get();
    }
}
