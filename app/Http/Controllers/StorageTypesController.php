<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Http\Requests\{
    PagedRequest,
    StorageTypeRequest

};
use App\Contracts\StorageTypeContract;
use App\Exceptions\EntityNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse as Response;
use Log;
use QueryException;

class StorageTypesController extends ApiController
{
    private $service;

    /**
     * StorageTypesController constructor.
     *
     * @param StorageTypeContract $service
     */
    public function __construct(StorageTypeContract $service)
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
        $storageTypes = $this->service->getStorageTypes($request);
        return $this->Ok($storageTypes);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param StorageTypeRequest $request
     *
     * @return Response
     */
    public function store(StorageTypeRequest $request): Response
    {
        try {
            $this->service->addStorageType($request);
            return $this->Created('Successfully added new storage type');
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
            $storageType = $this->service->findStorageType($id);
            return $this->Ok($storageType);
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
     * @param int     $id
     *
     * @return Response
     */
    public function update(StorageTypeRequest $request, int $id): Response
    {
        try {
            $this->service->updateStorageType($request, $id);
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
            $this->service->deleteStorageType($id);
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
