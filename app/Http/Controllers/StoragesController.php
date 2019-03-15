<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Contracts\StorageContract;
use App\Http\Requests\StorageRequest;
use App\Http\Controllers\ApiController;
use App\Exceptions\EntityNotFoundException;

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
    public function index()
    {
      return response()->json($this->service->getStorages(), SELF::OK);
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
            return response()->json('Successfully added new storage', SELF::CREATED);
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
            $storage = $this->service->findStorage($id);
            return response()->json($storage, SELF::OK);
          } catch (EntityNotFoundException $e) {
            \Log::error($e->getMessage());
            return response()->json('Storage not found', SELF::NOT_FOUND);
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
    public function update(StorageRequest $request, $id)
    {
        try {
            $this->service->updateStorage($request, $id);
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
            $this->service->deleteStorage($id);
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
