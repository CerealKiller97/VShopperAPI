<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Contracts\ProductContract;
use App\Http\Requests\ProductRequest;
use App\Http\Controllers\ApiController;
use App\Exceptions\EntityNotFoundException;
use App\Http\Requests\ProductSearchRequest;

class ProductsController extends ApiController
{

    public function __construct(ProductContract $service)
    {
        parent::__construct($service);
        $this->service = $service;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(ProductSearchRequest $request)
    {
      return response()->json($this->service->getProducts($request), SELF::OK);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ProductRequest $request)
    {
        try {
            $this->service->addProduct($request);
            return response()->json('Successfully added new product', SELF::CREATED);
          } catch (EntityNotFoundException $e) {
            \Log::error($e->getMessage());
            return response()->json($e->getMessage(), SELF::NOT_FOUND);
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
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
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
