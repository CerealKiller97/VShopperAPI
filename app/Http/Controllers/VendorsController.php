<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Contracts\VendorContract;
use App\Http\Requests\PagedRequest;
use App\Http\Requests\VendorRequest;
use App\Http\Controllers\ApiController;
use App\Exceptions\EntityNotFoundException;

class VendorsController extends ApiController
{
    public function __construct(VendorContract $service)
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
      return $this->Ok($this->service->getVendors($request));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(VendorRequest $request)
    {
      try {
          $this->service->addVendor($request);
          return $this->Created('Successfully added new vendor');
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
        $vendor = $this->service->findVendor($id);
        return $this->Ok($vendor);
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
    public function update(VendorRequest $request, $id)
    {
      try {
        $this->service->updateVendor($request, $id);
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
        $this->service->deleteVendor($id);
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
