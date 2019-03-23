<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Contracts\ProductContract;
use App\Http\Controllers\ApiController;
use App\Exceptions\EntityNotFoundException;
use App\Http\Requests\ProductStorageRequest;

class ProductStoragesController extends ApiController
{
    public function __construct(ProductContract $service)
    {
        parent::__construct($service);
        $this->service = $service;
    }

    public function add(ProductStorageRequest $request ,int $id)
    {
        try {
            $this->service->addProductToStorage($request, $id);
            return response()->json('Successfully added new product to storage', SELF::CREATED);
          } catch(EntityNotFoundException $e) {
            \Log::error($e->getMessage());
            return response()->json($e->getMessage(), SELF::NOT_FOUND);
          } catch(Exception $e) {
            \Log::error($e->getMessage());
            return response()->json('Server Error', SELF::INTERNAL_SERVER_ERROR);
          }
    }

    public function delete(ProductStorageRequest $request ,int $id)
    {
        # code...
    }
}
