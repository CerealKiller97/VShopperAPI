<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Http\Requests\PagedRequest;
use App\Contracts\StorageTypeContract;
use App\Http\Requests\StorageTypeRequest;
use App\Exceptions\EntityNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Log;
use QueryException;

class StorageTypesController extends ApiController
{
    private $service;

    public function __construct(StorageTypeContract $service)
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
        return $this->Ok($this->service->getStorageTypes($request));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return Response
     */
    public function store(StorageTypeRequest $request)
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
     * @return Response
     */
    public function show($id)
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
     * @param int $id
     * @return Response
     */
    public function update(StorageTypeRequest $request, $id)
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
     * @return Response
     */
    public function destroy($id)
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
