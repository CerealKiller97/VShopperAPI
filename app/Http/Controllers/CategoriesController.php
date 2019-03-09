<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Contracts\CategoryContract;
use App\Http\Requests\CategoryRequest;
use App\Http\Controllers\ApiController;
use App\Exceptions\EntityNotFoundException;

class CategoriesController extends ApiController
{
    public function __construct(CategoryContract $service)
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
        // return response()->json($this->service->getCategories(),SELF::OK);
        return response()->json($this->service->profileCategory(), SELF::OK);

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CategoryRequest $request)
    {
        try {
            $this->service->addCategory($request);
            return response()->json('Successfully added new category', SELF::CREATED);
        } catch (\QueryException $e) {
            \Log::error($e);
            return response()->json('Server error!', 500);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(int $id)
    {
        try {
            return response()->json($this->service->findCategory($id), SELF::OK);
        } catch (EntityNotFoundException $e) {
            return response()->json($e->getMessage());
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\CategoryRequest  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(CategoryRequest $request, int $id)
    {
        try {
            $this->service->updateCategory($request, $id);
            return response()->json('Successfully updated', SELF::NO_CONTENT);
        } catch (\Throwable $th) {
            throw $th;
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
            $this->service->deleteCategory($id);
            return response()->json('Successfully deleted', SELF::NO_CONTENT);
        } catch (\EntityNotFoundException $e) {
            return response()->json($e->getMessage());
        }
    }

    // public function profile()
    // {
    // }
}
