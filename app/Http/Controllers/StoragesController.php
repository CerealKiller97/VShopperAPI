<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Contracts\StorageContract;
use App\Http\Requests\StorageRequest;
use App\Http\Controllers\ApiController;
use App\Exceptions\EntityNotFoundException;
use App\Http\Requests\StorageSearchRequest;

class StoragesController extends ApiController
{
    public function __construct(StorageContract $service)
    {
        parent::__construct($service);
        $this->service = $service;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(StorageSearchRequest $request)
    {
      return $this->Ok($this->service->getStorages($request));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StorageRequest $request)
    {
        try {
            $this->service->addStorage($request);
            return $this->Created('Successfully added new storage');
          } catch (\QueryException $e) {
            \Log::error($e->getMessage());
            return $this->ServerError();
          } catch (Exception $e) {
            \Log::error($e->getMessage());
            return $this->ServerError();
          }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        try {
            $storage = $this->service->findStorage($id);
            return $this->Ok($storage);
          } catch (EntityNotFoundException $e) {
            \Log::error($e->getMessage());
            return $this->NotFound($e->getMessage());
          } catch (Exception $e) {
            \Log::error($e->getMessage());
            return $this->ServerError();
          }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(StorageRequest $request, $id)
    {
        try {
            $this->service->updateStorage($request, $id);
            return $this->NoContent();
          } catch(EntityNotFoundException $e) {
            \Log::error($e->getMessage());
            return $this->NotFound($e->getMessage());
          } catch(\QueryException $e) {
            \Log::error($e->getMessage());
            return $this->ServerError();
          } catch(Exception $e) {
            \Log::error($e->getMessage());
            return $this->ServerError();
          }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try {
            $this->service->deleteStorage($id);
            return $this->NoContent();
          } catch (EntityNotFoundException $e) {
            \Log::error($e->getMessage());
            return $this->NotFound($e->getMessage());
          } catch(\QueryException $e) {
            \Log::error($e->getMessage());
            return $this->ServerError();
          } catch(Exception $e) {
            \Log::error($e->getMessage());
            return $this->ServerError();
          }
    }
}
