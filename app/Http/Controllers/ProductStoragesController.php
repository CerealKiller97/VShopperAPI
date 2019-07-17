<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Exceptions\{
    BatchDeleteException,
    EntityNotFoundException

};
use App\Contracts\ProductStorageContract;
use App\Http\Requests\{
    ProductStorageRequest,
    BatchProductStorageRequest

};
use Log;
use Illuminate\Http\JsonResponse as Response;

class ProductStoragesController extends ApiController
{
    private $service;

    /**
     * ProductStoragesController constructor.
     *
     * @param ProductStorageContract $service
     */
    public function __construct(ProductStorageContract $service)
    {
        $this->service = $service;
    }

    /**
     * @param ProductStorageRequest $request
     * @param int                   $id
     *
     * @return Response
     */
    public function add(ProductStorageRequest $request, int $id): Response
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

    /**
     * @param BatchProductStorageRequest $request
     * @param int                        $id
     *
     * @return Response
     */
    public function delete(BatchProductStorageRequest $request, int $id): Response
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
