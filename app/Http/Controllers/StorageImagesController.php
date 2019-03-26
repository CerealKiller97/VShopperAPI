<?php

namespace App\Http\Controllers;

use Exception;
use Illuminate\Http\Request;
use App\Http\Requests\ImageRequest;
use App\Contracts\StorageImageContract;
use App\Http\Controllers\ApiController;
use Illuminate\Database\QueryException;
use App\Exceptions\BatchDeleteException;
use App\Http\Requests\ImageBatchRequest;
use App\Exceptions\EntityNotFoundException;

class StorageImagesController extends ApiController
{
    public function __construct(StorageImageContract $service)
    {
      parent::__construct($service);
      $this->service = $service;
    }

    public function add(ImageRequest $request, int $id)
    {
      try {
        $this->service->addPicturesToStorage($request, $id);
        return $this->Created('Successfully added new picture to storage');
      } catch(EntityNotFoundException $e) {
        \Log::error($e->getMessage());
        return $this->NotFound($e->getMessage());
      } catch(Exception $e) {
        \Log::error($e->getMessage());
        return $this->ServerError();
      }
    }

    public function delete(ImageBatchRequest $request, int $id)
    {
      try {
        $this->service-> deletePicturesToStorage($request, $id);
        return $this->NoContent();
      } catch(BatchDeleteException $e) {
        \Log::error($e->getMessage());
        return $this->Conflitct($e->getMessage());
       }  catch(Exception $e) {
        \Log::error($e->getMessage());
        return $this->ServerError();
      }
    }
}
