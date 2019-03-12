<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Contracts\VendorContract;
use App\Http\Requests\VendorRequest;
use App\Http\Controllers\ApiController;

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
    public function index()
    {
      return response()->json($this->service->getVendors(), SELF::OK);
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
            return response()->json('Successfully added new vendor', SELF::CREATED);
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
            $vendor = $this->service->findVendor($id);
            return response()->json($vendor, SELF::OK);
          } catch (EntityNotFoundException $e) {
            \Log::error($e->getMessage());
            return response()->json('No vendor found');
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
    public function update(VendorRequest $request, $id)
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
