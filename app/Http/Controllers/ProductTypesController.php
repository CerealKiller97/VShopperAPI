<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Http\Requests\{
    PagedRequest,
    ProductTypeRequest

};
use App\Contracts\ProductTypeContract;
use App\Exceptions\EntityNotFoundException;
use Illuminate\Http\JsonResponse as Response;
use Log;
use QueryException;

class ProductTypesController extends ApiController
{
    private $service;

    /**
     * ProductTypesController constructor.
     *
     * @param ProductTypeContract $service
     */
    public function __construct(ProductTypeContract $service)
    {
        $this->service = $service;
    }

    /**
     * Display a listing of the resource.
     *
     * @param PagedRequest $request
     *
     * @return Response
     */
    public function index(PagedRequest $request): Response
    {
        $productTypes = $this->service->getProductTypes($request);
        return $this->Ok($productTypes);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param ProductTypeRequest $request
     *
     * @return Response
     */
    public function store(ProductTypeRequest $request): Response
    {
        try {
            $this->service->addProductType($request);
            return $this->Created('Successfully added new product type');
        } catch (QueryException $e) {
            Log::error($e->getMessage());
            return $this->ServerError();
        } catch (Exception $e) {
            Log::error($e->getMessage());
            return $this->ServerError();
        }
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     *
     * @return Response
     */
    public function show(int $id): Response
    {
        try {
            $productType = $this->service->findProductType($id);
            return $this->Ok($productType);
        } catch (EntityNotFoundException $e) {
            Log::error($e->getMessage());
            return $this->NotFound($e->getMessage());
        } catch (Exception $e) {
            Log::error($e->getMessage());
            return $this->ServerError();
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param ProductTypeRequest $request
     * @param int     $id
     *
     * @return Response
     */
    public function update(ProductTypeRequest $request, $id): Response
    {
        try {
            $this->service->updateProductType($request, $id);
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

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     *
     * @return Response
     */
    public function destroy(int $id): Response
    {
        try {
            $this->service->deleteProductType($id);
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
