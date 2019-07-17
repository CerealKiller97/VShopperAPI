<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Contracts\StorageContract;
use App\Http\Requests\StorageRequest;
use App\Exceptions\EntityNotFoundException;
use App\Http\Requests\StorageSearchRequest;
use Illuminate\Http\JsonResponse as Response;
use Log;
use QueryException;

class StoragesController extends ApiController
{
    private $service;

    /**
     * StoragesController constructor.
     *
     * @param StorageContract $service
     */
    public function __construct(StorageContract $service)
    {
        $this->service = $service;
    }

    /**
     * Display a listing of the resource.
     *
     * @param StorageSearchRequest $request
     *
     * @return Response
     */
    public function index(StorageSearchRequest $request): Response
    {
        $storages = $this->service->getStorages($request);
        return $this->Ok($storages);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param StorageRequest $request
     *
     * @return Response
     */
    public function store(StorageRequest $request): Response
    {
        try {
            $this->service->addStorage($request);
            return $this->Created('Successfully added new storage');
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
            $storage = $this->service->findStorage($id);
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
     * @param StorageRequest $request
     * @param int            $id
     *
     * @return Response
     */
    public function update(StorageRequest $request, int $id): Response
    {
        try {
            $this->service->updateStorage($request, $id);
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
            $this->service->deleteStorage($id);
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
