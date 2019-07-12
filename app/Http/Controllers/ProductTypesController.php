<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Http\Requests\PagedRequest;
use App\Contracts\ProductTypeContract;
use App\Http\Requests\ProductTypeRequest;
use App\Exceptions\EntityNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Log;
use QueryException;

class ProductTypesController extends ApiController
{
    private $service;

    public function __construct(ProductTypeContract $service)
    {
        $this->service = $service;
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index(PagedRequest $request)
    {
        return $this->Ok($this->service->getProductTypes($request));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return Response
     */
    public function store(ProductTypeRequest $request)
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
     * @return Response
     */
    public function show($id)
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
     * @param Request $request
     * @param int $id
     * @return Response
     */
    public function update(ProductTypeRequest $request, $id)
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
     * @return Response
     */
    public function destroy($id)
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
