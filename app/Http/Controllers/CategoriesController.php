<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Contracts\CategoryContract;
use App\Http\Requests\{
    PagedRequest,
    CategoryRequest

};
use App\Exceptions\EntityNotFoundException;
use Illuminate\Http\JsonResponse as Response;
use Log;
use QueryException;

class CategoriesController extends ApiController
{
    private $service;

    /**
     * CategoriesController constructor.
     *
     * @param CategoryContract $service
     */
    public function __construct(CategoryContract $service)
    {
        $this->service = $service;
    }

    /**
     *  Get all categories for authenticated user. There are some default categories. Default per page is 50
     *
     * @queryParam name string optional The name of the categories.
     * @queryParam perPage int optional Total number of categories per page.
     * @queryParam page int optional Parameter page represents that page you want to see categories.
     * @response   200 {
     *  "data": [
     * {
     * "id": 1,
     * "name": "Category",
     * "subcategory_id": null,
     * "image": null || full path
     * }
     * ],
     * "total": 1,
     * "currentPage": 1
     *
     * }
     * @param PagedRequest $request
     *
     * @return Response
     */
    public function index(PagedRequest $request): Response
    {
        $categories = $this->service->getCategories($request);
        return $this->Ok($categories);
    }

    /**
     * Add a new category.
     *
     * @bodyParam name string required Represents category name.
     * @bodyParam subcategory_id int optional Represents category subcategory_id.
     * @bodyParam image string optional Represents category image.
     *
     * @response  201 {
     *   "message": "Successfully added new category"
     * }
     *
     * @response  500 {
     *   "error" : "Server error, please try later."
     * }
     *
     * @param CategoryRequest $request
     *
     * @return Response
     */
    public function store(CategoryRequest $request): Response
    {
        try {
            $this->service->addCategory($request);
            return $this->Created('Successfully added new category');
        } catch (QueryException $e) {
            Log::error($e->getMessage());
            return $this->ServerError();
        } catch (Exception $e) {
            Log::error($e->getMessage());
            return $this->ServerError();
        }
    }

    /**
     * Get the specified category details.
     *
     * @queryParam id int optional Represents category id.
     *
     * @response   200 {
     *    {
     * "id": 1,
     * "name": "Category",
     * "subcategory_id": null,
     * "image": null || full path
     * }
     * }
     * @response   404 {
     *    "error": "Category not found"
     * }
     *
     * @param int $id
     *
     * @return Response
     */
    public function show(int $id): Response
    {
        try {
            $unit = $this->service->findCategory($id);
            return $this->Ok($unit);
        } catch (EntityNotFoundException $e) {
            Log::error($e->getMessage());
            return $this->NotFound($e->getMessage());
        } catch (Exception $e) {
            Log::error($e->getMessage());
            return $this->ServerError();
        }
    }

    /**
     * Update the specified category.
     *
     * @bodyParam name string required Represents category name.
     * @bodyParam subcategory_id int optional Represents category subcategory_id.
     * @bodyParam image string optional Represents category image.
     *
     * @response  204 {
     *
     * }
     *
     * @response  404 {
     *    "error": "Category not found"
     * }
     *
     * @response  500 {
     *   "error" : "Server error, please try later."
     * }
     *
     * @param CategoryRequest $request
     * @param int             $id
     *
     * @return Response
     */
    public function update(CategoryRequest $request, int $id): Response
    {
        try {
            $this->service->updateCategory($request, $id);
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
     * Remove the specific category.
     *
     * @queryParam  int id integer required Represents category id.
     * @response    204 {
     *
     * }
     *
     * @response    404 {
     *    "error": "Category not found"
     * }
     *
     * @param int $id
     *
     * @return Response
     */
    public function destroy(int $id): Response
    {
        try {
            $this->service->deleteCategory($id);
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

