<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Contracts\VendorContract;
use App\Http\Requests\PagedRequest;
use App\Http\Requests\VendorRequest;
use App\Exceptions\EntityNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse as Response;
use Log;
use QueryException;

class VendorsController extends ApiController
{
    private $service;

    public function __construct(VendorContract $service)
    {
        $this->service = $service;
    }

    /**
     * Display a listing of the resource.
     *
     * @param PagedRequest $request
     * @return Response
     */
    public function index(PagedRequest $request): Response
    {
        $vendors = $this->service->getVendors($request);
        return $this->Ok($vendors);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return Response
     */
    public function store(VendorRequest $request): Response
    {
        try {
            $this->service->addVendor($request);
            return $this->Created('Successfully added new vendor');
        } catch (QueryException $e) {
            Log::error($e->getMessage());
            return $this->ServerError();
        } catch (Exception $e) {
            Log::error($e->getMessage());
            return $this->ServerError();
        }
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return Response
     */
    public function show(int $id): Response
    {
        try {
            $vendor = $this->service->findVendor($id);
            return $this->Ok($vendor);
        } catch (EntityNotFoundException $e) {
            Log::error($e->getMessage());
            return $this->NotFound($e->getMessage());
        } catch (Exception $e) {
            Log::error($e->getMessage());
            return $this->ServerError();
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param VendorRequest $request
     * @param int $id
     * @return Response
     */
    public function update(VendorRequest $request, $id): Response
    {
        try {
            $this->service->updateVendor($request, $id);
            return $this->NoContent();
        } catch (EntityNotFoundException $e) {
            Log::error($e->getMessage());
            return $this->NotFound($e->getMessage());
        } catch (QueryException $e) {
            Log::error($e->getMessage());
            return $this->ServerError();
        } catch (Exception $e) {
            Log::error($e->getMessage());
            return $this->ServerError();
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return Response
     */
    public function destroy(int $id): Response
    {
        try {
            $this->service->deleteVendor($id);
            return $this->NoContent();
        } catch (EntityNotFoundException $e) {
            Log::error($e->getMessage());
            return $this->NotFound($e->getMessage());
        } catch (QueryException $e) {
            Log::error($e->getMessage());
            return $this->ServerError();
        } catch (Exception $e) {
            Log::error($e->getMessage());
            return $this->ServerError();
        }
    }
}
