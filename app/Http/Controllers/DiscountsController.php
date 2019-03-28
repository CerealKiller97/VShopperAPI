<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Exceptions\DiscountHasNoPrice;
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
            return $this->Created('Successfully added new discount to product');
        } catch(EntityNotFoundException $e) {
            \Log::error($e->getMessage());
            return $this->NotFound($e->getMessage());
          } catch(DiscountHasNoPrice $e) {
            \Log::error($e->getMessage());
            return $this->NotFound($e->getMessage());
          } catch(InvalidDiscountException $e) {
            \Log::error($e->getMessage());
            return $this->Conflitct($e->getMessage());
          } catch(\QueryException $e) {
            \Log::error($e->getMessage());
            return $this->ServerError();
          } catch(Exception $e) {
            \Log::error($e->getMessage());
            return $this->ServerError();
          }
    }

    public function update(DiscountRequest $request, int $id)
    {
      try {
        $this->service->upateDiscountFromProduct($request, $id);
        return $this->NoContent();
      } catch(EntityNotFoundException $e) {
        \Log::error($e->getMessage());
        return $this->NotFound($e->getMessage());
      }  catch(InvalidDiscountException $e) {
        \Log::error($e->getMessage());
        return $this->NotFound($e->getMessage());
      } catch(\QueryException $e) {
        \Log::error($e->getMessage());
        return $this->ServerError();
      } catch(Exception $e) {
        \Log::error($e->getMessage());
        return $this->ServerError();
      }
    }
}
