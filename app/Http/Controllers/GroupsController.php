<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Contracts\GroupContract;
use App\Http\Requests\GroupRequest;
use App\Http\Requests\PagedRequest;
use App\Http\Controllers\ApiController;
use App\Exceptions\EntityNotFoundException;

class GroupsController extends ApiController
{
    public function __construct(GroupContract $service)
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
      return $this->Ok($this->service->getGroups($request));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(GroupRequest $request)
    {
        try {
            $this->service->addGroup($request);
            return $this->created('Successfully added new group');
          } catch (\QueryException $e) {
            \Log::error($e->getMessage());
            return $this->ServerError('Server Error');
          } catch (Exception $e) {
            \Log::error($e->getMessage());
            return $this->ServerError('Server Error');
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
        $group = $this->service->findGroup($id);
        return $this->Ok($group);
      } catch (EntityNotFoundException $e) {
        \Log::error($e->getMessage());
        return $this->NotFound('No group found');
      } catch (Exception $e) {
        \Log::error($e->getMessage());
        return $this->ServerError('Server Error');
      }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(GroupRequest $request, $id)
    {
        try {
            $this->service->updateGroup($request, $id);
            return $this->NoContent();
          } catch (EntityNotFoundException $e) {
            \Log::error($e->getMessage());
            return $this->NotFound('No group found');
          } catch(\QueryException $e) {
            \Log::error($e->getMessage());
            return $this->ServerError('Server Error');
          } catch(Exception $e) {
            \Log::error($e->getMessage());
            return $this->ServerError('Server Error');
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
          $this->service->deleteGroup($id);
          return $this->NoContent();
        } catch (EntityNotFoundException $e) {
          \Log::error($e->getMessage());
          return $this->NotFound('No group found');
        } catch(\QueryException $e) {
          \Log::error($e->getMessage());
          return $this->ServerError('Server Error');
        } catch(Exception $e) {
          \Log::error($e->getMessage());
          return $this->ServerError('Server Error');
        }
    }
}
