<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Contracts\ProductContract;
use App\Http\Requests\{
    ProductRequest,
    ProductSearchRequest

};
use App\Exceptions\EntityNotFoundException;
use Illuminate\Http\JsonResponse as Response;
use Log;
use QueryException;

class ProductsController extends ApiController
{
    private $service;

    /**
     * ProductsController constructor.
     *
     * @param ProductContract $service
     */
    public function __construct(ProductContract $service)
    {
        $this->service = $service;
    }

    /**
     * Display a listing of the resource.
     *
     * @param ProductSearchRequest $request
     *
     * @return Response
     */
    public function index(ProductSearchRequest $request): Response
    {
        $products = $this->service->getProducts($request);
        return $this->Ok($products);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param ProductRequest $request
     *
     * @return Response
     */
    public function store(ProductRequest $request): Response
    {
        try {
            $this->service->addProduct($request);
            return $this->Created('Successfully added new product');
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
     * Display the specified resource.
     *
     * @param int $id
     *
     * @return Response
     */
    public function show(int $id): Response
    {
        try {
            $storage = $this->service->findProduct($id);
            return $this->Ok($storage);
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
     * @param ProductRequest $request
     * @param int            $id
     *
     * @return Response
     */
    public function update(ProductRequest $request, int $id): Response
    {
        try {
            $this->service->updateProduct($request, $id);
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
            $this->service->deleteProduct($id);
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
