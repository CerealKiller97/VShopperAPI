<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Exceptions\BatchDeleteException;
use App\Contracts\ProductStorageContract;
use App\Exceptions\EntityNotFoundException;
use App\Http\Requests\ProductStorageRequest;
use App\Http\Requests\BatchProductStorageRequest;
use Log;

class ProductStoragesController extends ApiController
{
    private $service;

    public function __construct(ProductStorageContract $service)
    {
        $this->service = $service;
    }

    public function add(ProductStorageRequest $request, int $id)
    {
        try {
            $this->service->addProductToStorage($request, $id);
            return $this->Created('Successfully added new product to storage');
        } catch (EntityNotFoundException $e) {
            Log::error($e->getMessage());
            return $this->NotFound($e->getMessage());
        } catch (Exception $e) {
            Log::error($e->getMessage());
            return $this->ServerError();
        }
    }

    public function delete(BatchProductStorageRequest $request, int $id)
    {
        try {
            $this->service->deleteProductFromStorage($request, $id);
            return $this->NoContent();
        } catch (BatchDeleteException $e) {
            Log::error($e->getMessage());
            return $this->Conflitct($e->getMessage());
        } catch (EntityNotFoundException $e) {
            Log::error($e->getMessage());
            return $this->NotFound($e->getMessage());
        } catch (Exception $e) {
            Log::error($e->getMessage());
            return $this->ServerError();
        }
    }
}
