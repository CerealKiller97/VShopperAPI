<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Contracts\BrandContract;
use App\Http\Requests\BrandRequest;
use App\Http\Requests\PagedRequest;
use App\Exceptions\EntityNotFoundException;
use Log;
use QueryException;
use Illuminate\Http\JsonResponse as Response;

class BrandsController extends ApiController
{
    private $service;

    public function __construct(BrandContract $service)
    {
        $this->service = $service;
    }

    /**
     * Get all brands
     *
     * @bodyParam name string optional The name of the brand.
     * @bodyParam perPage int optional Total number of brands per page.
     * @bodyParam page int Parameter page represents that page you want to see brands.
     * @response 200 {
     *  "data": [
     * {
     * "id": 1,
     * "name": "Brand name"
     * }
     * ],
     * "total": 1,
     * "currentPage": 1
     *
     * }
     */
    public function index(PagedRequest $request)
    {
        $brands = $this->service->getBrands($request);
        return $this->Ok($brands);
    }

    /**
     * Add a new brand.
     *
     * @bodyParam  name string required Represents name of brand
     * @response 201 {
     *   "message": "Successfully added new brand."
     * }
     * @response 500 {
     *   "error": "Server error please try again."
     * }
     */
    public function store(BrandRequest $request): Response
    {
        try {
            $this->service->addBrand($request);
            return $this->Created('Successfully added new brand');
        } catch (QueryException $e) {
            Log::error($e->getMessage());
            return $this->ServerError();
        } catch (Exception $e) {
            Log::error($e->getMessage());
            return $this->ServerError();
        }
    }

    /**
     * Get the specified brand.
     *
     * @queryParam id required The id of the brand
     * @response 200 {
     *   "id": 1,
     *   "name": "Brand name"
     * }
     * @response 404 {
     *   "error": "Brand not found"
     * }
     */
    public function show(int $id)
    {
        try {
            $brand = $this->service->findBrand($id);
            return $this->Ok($brand);
        } catch (EntityNotFoundException $e) {
            Log::error($e->getMessage());
            return $this->NotFound($e->getMessage());
        } catch (Exception $e) {
            Log::error($e->getMessage());
            return $this->ServerError();
        }
    }

    /**
     * Update a specific brand.
     *
     * @queryParam id required The id of the brand
     * @bodyParam  name string required Represents name of brand
     * @response 204 {
     *
     * }
     *
     * @response 404 {
     *   "error": "Brand not found"
     * }
     *
     * @response 500 {
     *   "error": "Server error please try again."
     * }
     */
    public function update(BrandRequest $request, $id)
    {
        try {
            $this->service->updateBrand($request, $id);
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
     * Delete a specific brand.
     *
     * @queryParam id required The id of the brand
     * @response 204 {
     *
     * }
     *
     * @response 404 {
     *   "error": "Brand not found"
     * }
     *
     * @response 500 {
     *   "error": "Server error please try again."
     * }
     */
    public function destroy($id)
    {
        try {
            $this->service->deleteBrand($id);
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
