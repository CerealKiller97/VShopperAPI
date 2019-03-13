<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Contracts\StorageTypeContract;
use App\Http\Controllers\ApiController;
use App\Http\Requests\StorageTypeRequest;
use App\Exceptions\EntityNotFoundException;

class StorageTypesController extends ApiController
{
    public function __construct(StorageTypeContract $service)
    {
      parent::__construct($service);
      $this->service = $service;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
      return response()->json($this->service->getStorageTypes(), SELF::OK);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StorageTypeRequest $request)
    {
        try {
            $this->service->addStorageType($request);
            return response()->json('Successfully added new storage type', SELF::CREATED);
          } catch (\QueryException $e) {
            \Log::error($e->getMessage());
            return response()->json('Server Error', SELF::INTERNAL_SERVER_ERROR);
          } catch (Exception $e) {
            \Log::error($e->getMessage());
            return response()->json('Server Error', SELF::INTERNAL_SERVER_ERROR);
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
            $storageType = $this->service->findStorageType($id);
            return response()->json($storageType, SELF::OK);
          } catch (EntityNotFoundException $e) {
            \Log::error($e->getMessage());
            return response()->json('Storage type found', SELF::NOT_FOUND);
          } catch (Exception $e) {
            \Log::error($e->getMessage());
            return response()->json('Server error');
          }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(StorageTypeRequest $request, $id)
    {
        try {
            $this->service->updateStorageType($request, $id);
            return response()->json(null, SELF::NO_CONTENT);
          } catch (EntityNotFoundException $e) {
            \Log::error($e->getMessage());
            return response()->json($e->getMessage(), SELF::NOT_FOUND);
          } catch(\QueryException $e) {
            \Log::error($e->getMessage());
            return response()->json('Server Error', SELF::INTERNAL_SERVER_ERROR);
          } catch(Exception $e) {
            \Log::error($e->getMessage());
            return response()->json('Server Error', SELF::INTERNAL_SERVER_ERROR);
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
            $this->service->deleteStorageType($id);
            return response()->json(null, SELF::NO_CONTENT);
          } catch (EntityNotFoundException $e) {
            \Log::error($e->getMessage());
            return response()->json($e->getMessage(), SELF::NOT_FOUND);
          } catch(\QueryException $e) {
            \Log::error($e->getMessage());
            return response()->json('Server Error', SELF::INTERNAL_SERVER_ERROR);
          } catch(Exception $e) {
            \Log::error($e->getMessage());
            return response()->json('Server Error', SELF::INTERNAL_SERVER_ERROR);
          }
    }
}
