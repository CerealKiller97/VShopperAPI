<?php

namespace App\Http\Controllers;

use App\Contracts\UnitContract;
use App\Http\Requests\UnitRequest;
use App\Http\Requests\PagedRequest;
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
    public function index(PagedRequest $request)
    {
      return $this->Ok($this->service->getUnits($request));
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
          return $this->Created('Successfully added new unit');
        } catch (\QueryException $e) {
          \Log::error($e->getMessage());
          $this->ServerError();
        } catch (Exception $e) {
          \Log::error($e->getMessage());
          $this->ServerError();
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
        return $this->Ok($unit);
      } catch (EntityNotFoundException $e) {
        \Log::error($e->getMessage());
        return $this->NotFound($e->getMessage());
      } catch (Exception $e) {
        \Log::error($e->getMessage());
        $this->ServerError();
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
        return $this->NoContent();
      } catch (EntityNotFoundException $e) {
        \Log::error($e->getMessage());
        return $this->NotFound($e->getMessage());
      } catch(\QueryException $e) {
        \Log::error($e->getMessage());
        $this->ServerError();
      } catch(Exception $e) {
        \Log::error($e->getMessage());
        $this->ServerError();
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
        return $this->NoContent();
      } catch (EntityNotFoundException $e) {
        \Log::error($e->getMessage());
        return $this->NotFound($e->getMessage());
      } catch(\QueryException $e) {
        \Log::error($e->getMessage());
        $this->ServerError();
      } catch(Exception $e) {
        \Log::error($e->getMessage());
        $this->ServerError();
      }
    }
}
