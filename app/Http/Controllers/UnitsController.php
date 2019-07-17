<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Contracts\UnitContract;
use App\Http\Requests\Units\{
    UnitRequest,
    UnitSearchRequest

};
use App\Exceptions\EntityNotFoundException;
use Illuminate\Http\JsonResponse as Response;
use Log;
use QueryException;

class UnitsController extends ApiController
{
    private $service;

    /**
     * UnitsController constructor.
     *
     * @param UnitContract $service
     */
    public function __construct(UnitContract $service)
    {
        $this->service = $service;
    }

    /**
     * Display a listing of the resource.
     *
     * @param UnitSearchRequest $request
     *
     * @return Response
     */
    public function index(UnitSearchRequest $request): Response
    {
        $units = $this->service->getUnits($request);
        return $this->Ok($units);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param UnitRequest $request
     *
     * @return Response
     */
    public function store(UnitRequest $request): Response
    {
        try {
            $this->service->addUnit($request);
            return $this->Created('Successfully added new unit');
        } catch (QueryException $e) {
            Log::error($e->getMessage());
            $this->ServerError();
        } catch (Exception $e) {
            Log::error($e->getMessage());
            $this->ServerError();
        }

    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     *
     * @return Response
     */
    public function show(int $id): Response
    {
        try {
            $unit = $this->service->findUnit($id);
            return $this->Ok($unit);
        } catch (EntityNotFoundException $e) {
            Log::error($e->getMessage());
            return $this->NotFound($e->getMessage());
        } catch (Exception $e) {
            Log::error($e->getMessage());
            $this->ServerError();
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param UnitRequest $request
     * @param int         $id
     *
     * @return Response
     */
    public function update(UnitRequest $request, int $id): Response
    {
        try {
            $this->service->updateUnit($request, $id);
            return $this->NoContent();
        } catch (EntityNotFoundException $e) {
            Log::error($e->getMessage());
            return $this->NotFound($e->getMessage());
        } catch (QueryException $e) {
            Log::error($e->getMessage());
            $this->ServerError();
        } catch (Exception $e) {
            Log::error($e->getMessage());
            $this->ServerError();
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     *
     * @return Response
     */
    public function destroy(int $id): Response
    {
        try {
            $this->service->deleteUnit($id);
            return $this->NoContent();
        } catch (EntityNotFoundException $e) {
            Log::error($e->getMessage());
            return $this->NotFound($e->getMessage());
        } catch (QueryException $e) {
            Log::error($e->getMessage());
            $this->ServerError();
        } catch (Exception $e) {
            Log::error($e->getMessage());
            $this->ServerError();
        }
    }
}
