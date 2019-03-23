<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Contracts\ProductContract;
use App\Http\Controllers\ApiController;
use App\Http\Requests\ProductPriceRequest;
use App\Exceptions\EntityNotFoundException;

class ProductPricesController extends ApiController
{
    public function __construct(ProductContract $service)
    {
        parent::__construct($service);
        $this->service = $service;
    }

    public function add(ProductPriceRequest $request, int $id)
    {
        try {
            $this->service->addNewPriceToProduct($request, $id);
            return response()->json('Successfully added new price to product', SELF::CREATED);
        } catch(EntityNotFoundException $e) {
            \Log::error($e->getMessage());
            return response()->json($e->getMessage(), SELF::NOT_FOUND);
          } catch(\QueryException $e) {
            \Log::error($e->getMessage());
            return response()->json('Server error', INTERNAL_SERVER_ERROR);
          } catch(Exception $e) {
            \Log::error($e->getMessage());
            return response()->json('Server Error', SELF::INTERNAL_SERVER_ERROR);
          }
    }

    public function update(ProductPriceRequest $request, int $id)
    {
        try {
            $this->service->updatePriceToProduct($request, $id);
        } catch (\Throwable $th) {
            //throw $th;
        }
    }
}