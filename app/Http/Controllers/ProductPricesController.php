<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Contracts\ProductPriceContract;
use App\Http\Requests\ProductPriceRequest;
use App\Exceptions\EntityNotFoundException;
use Log;
use QueryException;

class ProductPricesController extends ApiController
{
    private $service;

    public function __construct(ProductPriceContract $service)
    {
        $this->service = $service;
    }

    public function add(ProductPriceRequest $request, int $id)
    {
        try {
            $this->service->addNewPriceToProduct($request, $id);
            return $this->Created('Successfully added new price to product');
        } catch (EntityNotFoundException $e) {
            Log::error($e->getMessage());
            return $this->NotFound($e->getMessage());
        } catch (QueryException $e) {
            Log::error($e->getMessage());
            return $this->ServerError();
        } catch (Exception $e) {
            Log::error($e->getMessage());
            return $this->ServerError();
        }
    }

    public function update(ProductPriceRequest $request, int $id)
    {
        try {
            $this->service->updatePriceToProduct($request, $id);
            return $this->NoContent();
        } catch (EntityNotFoundException $e) {
            Log::error($e->getMessage());
            return $this->NotFound($e->getMessage());
        } catch (QueryException $e) {
            Log::error($e->getMessage());
            return $this->ServerError();
        } catch (Exception $e) {
            Log::error($e->getMessage());
            return $this->ServerError();
        }
    }
}
