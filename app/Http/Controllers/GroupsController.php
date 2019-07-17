<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Contracts\GroupContract;
use App\Http\Requests\{
    GroupRequest,
    PagedRequest};
use App\Exceptions\EntityNotFoundException;
use Illuminate\Http\JsonResponse as Response;
use Log;
use QueryException;

class GroupsController extends ApiController
{
    private $service;

    /**
     * GroupsController constructor.
     *
     * @param GroupContract $service
     */
    public function __construct(GroupContract $service)
    {
        $this->service = $service;
    }

    /**
     * Display a listing of the resource.
     *
     * @param PagedRequest $request
     *
     * @return Response
     */
    public function index(PagedRequest $request): Response
    {
        $groups = $this->service->getGroups($request);
        return $this->Ok($groups);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param GroupRequest $request
     *
     * @return Response
     */
    public function store(GroupRequest $request): Response
    {
        try {
            $this->service->addGroup($request);
            return $this->Created('Successfully added new group');
        } catch (QueryException $e) {
            Log::error($e->getMessage());
            return $this->ServerError('Server Error');
        } catch (Exception $e) {
            Log::error($e->getMessage());
            return $this->ServerError('Server Error');
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
            $group = $this->service->findGroup($id);
            return $this->Ok($group);
        } catch (EntityNotFoundException $e) {
            Log::error($e->getMessage());
            return $this->NotFound('No group found');
        } catch (Exception $e) {
            Log::error($e->getMessage());
            return $this->ServerError('Server Error');
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param GroupRequest $request
     * @param int          $id
     *
     * @return Response
     */
    public function update(GroupRequest $request, int $id): Response
    {
        try {
            $this->service->updateGroup($request, $id);
            return $this->NoContent();
        } catch (EntityNotFoundException $e) {
            Log::error($e->getMessage());
            return $this->NotFound('No group found');
        } catch (QueryException $e) {
            Log::error($e->getMessage());
            return $this->ServerError('Server Error');
        } catch (Exception $e) {
            Log::error($e->getMessage());
            return $this->ServerError('Server Error');
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
            $this->service->deleteGroup($id);
            return $this->NoContent();
        } catch (EntityNotFoundException $e) {
            Log::error($e->getMessage());
            return $this->NotFound('No group found');
        } catch (QueryException $e) {
            Log::error($e->getMessage());
            return $this->ServerError('Server Error');
        } catch (Exception $e) {
            Log::error($e->getMessage());
            return $this->ServerError('Server Error');
        }
    }
}
