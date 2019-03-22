<?php

namespace App\Http\Controllers;

use Exception;
use Illuminate\Http\Request;
use App\Contracts\StorageContract;
use App\Http\Requests\ImageRequest;
use App\Http\Controllers\ApiController;
use Illuminate\Database\QueryException;
use App\Exceptions\BatchDeleteException;
use App\Http\Requests\ImageBatchRequest;

class StorageImagesController extends ApiController
{
    public function __construct(StorageContract $service)
    {
        parent::__construct($service);
        $this->service = $service;
    }

    public function add(ImageRequest $request, int $id)
    {
      try {
        $this->service->addPicturesToStorage($request, $id);
        return response()->json('Successfully added new picture to storage', SELF::CREATED);
      } catch(\QueryException $e) {
        \Log::error($e->getMessage());
        return response()->json('Server Error', SELF::INTERNAL_SERVER_ERROR);
      } catch(Exception $e) {
        \Log::error($e->getMessage());
        return response()->json('Server Error', SELF::INTERNAL_SERVER_ERROR);
      }
    }

    public function delete(ImageBatchRequest $request, int $id)
    {
      try {
        $this->service-> deletePicturesToStorage($request, $id);
        return response()->json(null, SELF::NO_CONTENT);
      } catch(BatchDeleteException $e) {
        \Log::error($e->getMessage());
        return response()->json($e->getMessage(), SELF::CONFLICT);
       }  catch(Exception $e) {
        \Log::error($e->getMessage());
        return response()->json($e->getMessage(), SELF::INTERNAL_SERVER_ERROR);
      }
    }
}
