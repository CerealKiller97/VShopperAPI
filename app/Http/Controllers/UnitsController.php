<?php

namespace App\Http\Controllers;

use App\Contracts\UnitContract;
use App\Http\Requests\UnitRequest;
use App\Http\Controllers\ApiController;
use App\Exceptions\EntityNotFoundException;

class UnitsController extends ApiController
{
    public function __construct(UnitContract $service)
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
      return response()->json($this->service->getUnits(), SELF::OK);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(UnitRequest $request)
    {
        try {
          $this->service->addUnit($request);
          return response()->json('Successfully added new unit', SELF::CREATED);
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
        $unit = $this->service->findUnit($id);
        return response()->json($unit, SELF::OK);
      } catch (EntityNotFoundException $e) {
        \Log::error($e->getMessage());
        return response()->json('No unit found', SELF::NOT_FOUND);
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
    public function update(UnitRequest $request, $id)
    {
      try {
        $this->service->updateUnit($request, $id);
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
        $this->service->deleteUnit($id);
        return response()->json('Successfully deleted unit', SELF::NO_CONTENT);
      } catch(\QueryException $e) {
        \Log::error($e->getMessage());
        return response()->json('Server Error', SELF::INTERNAL_SERVER_ERROR);
      } catch(Exception $e) {
        \Log::error($e->getMessage());
        return response()->json('Server Error', SELF::INTERNAL_SERVER_ERROR);
      }
    }
}
