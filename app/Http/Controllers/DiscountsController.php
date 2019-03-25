<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\DiscountRequest;
use App\Http\Controllers\ApiController;
use App\Contracts\ProductDiscountContract;
use App\Exceptions\EntityNotFoundException;
use App\Exceptions\InvalidDiscountException;

class DiscountsController extends ApiController
{
    public function __construct(ProductDiscountContract $service)
    {
        parent::__construct($service);
        $this->service = $service;
    }

    public function add(DiscountRequest $request, int $id)
    {
        try {
            $this->service->addDiscountToProduct($request, $id);
            return response()->json('Successfully added new price to product', SELF::CREATED);
        } catch(EntityNotFoundException $e) {
            \Log::error($e->getMessage());
            return response()->json($e->getMessage(), SELF::NOT_FOUND);
          } catch(InvalidDiscountException $e) {
            \Log::error($e->getMessage());
            return response()->json($e->getMessage(), SELF::CONFLICT);
          } catch(\QueryException $e) {
            \Log::error($e->getMessage());
            return response()->json('Server error', SELF::INTERNAL_SERVER_ERROR);
          } catch(Exception $e) {
            \Log::error($e->getMessage());
            return response()->json('Server Error', SELF::INTERNAL_SERVER_ERROR);
          }
    }

    public function update(DiscountRequest $request, int $id)
    {
      try {
        $this->service->upateDiscountFromProduct($request, $id);
        return response()->json(null, SELF::NO_CONTENT);
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
}
