<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Contracts\ProductTypeContract;
use App\Http\Controllers\ApiController;
use App\Http\Requests\ProductTypeRequest;

class ProductTypesController extends ApiController
{
    public function __construct(ProductTypeContract $service)
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
        return response()->json($this->service->getProductTypes(), SELF::OK);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ProductTypeRequest $request)
    {
        try {
            $this->service->addProductType($request);
            return response()->json('Successfully added new product type', SELF::CREATED);
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
            $productType = $this->service->findProductType($id);
            return response()->json($productType, SELF::OK);
          } catch (EntityNotFoundException $e) {
            \Log::error($e->getMessage());
            return response()->json('No product type found');
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
    public function update(ProductTypeRequest $request, $id)
    {
        try {
            $this->service->updateProductType($request, $id);
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
            $this->service->deleteProductType($id);
            return response()->json(null, SELF::NO_CONTENT);
          } catch(\QueryException $e) {
            \Log::error($e->getMessage());
            return response()->json('Server Error', SELF::INTERNAL_SERVER_ERROR);
          } catch(Exception $e) {
            \Log::error($e->getMessage());
            return response()->json('Server Error', SELF::INTERNAL_SERVER_ERROR);
          }
    }
}
