<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Contracts\BrandContract;
use App\Http\Requests\BrandRequest;
use App\Http\Controllers\ApiController;
use App\Exceptions\EntityNotFoundException;


class BrandsController extends ApiController
{
    public function __construct(BrandContract $service)
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
        return response()->json($this->service->getBrands(), SELF::OK);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(BrandRequest $request)
    {
        try {
            $this->service->addBrand($request);
            return response()->json('Successfully added new brand', SELF::CREATED);
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
            $brand = $this->service->findBrand($id);
            return response()->json($brand, SELF::OK);
          } catch (EntityNotFoundException $e) {
            \Log::error($e->getMessage());
            return response()->json('Brand not found', SELF::NOT_FOUND);
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
    public function update(BrandRequest $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
