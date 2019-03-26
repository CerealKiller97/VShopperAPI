<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\PagedRequest;
use App\Contracts\ProductTypeContract;
use App\Http\Controllers\ApiController;
use App\Http\Requests\ProductTypeRequest;
use App\Exceptions\EntityNotFoundException;

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
    public function index(PagedRequest $request)
    {
      return $this->Ok($this->service->getProductTypes($request));
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
          return $this->Created('Successfully added new product type');
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
          $productType = $this->service->findProductType($id);
          return $this->Ok($productType);
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
    public function update(ProductTypeRequest $request, $id)
    {
        try {
            $this->service->updateProductType($request, $id);
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
