<?php

namespace App\Http\Controllers;

use Exception;
use Illuminate\Http\Request;
use App\Contracts\ProductContract;
use App\Http\Requests\ImageRequest;
use App\Http\Controllers\ApiController;
use App\Exceptions\BatchDeleteException;
use App\Http\Requests\ImageBatchRequest;
use App\Exceptions\EntityNotFoundException;

class ProductImagesController extends ApiController
{
    public function __construct(ProductContract $service)
    {
        parent::__construct($service);
        $this->service = $service;
    }

    public function add(ImageRequest $request, int $id)
    {
        try {
            $this->service->addPicturesToProduct($request, $id);
            return response()->json('Successfully added new picture to product', SELF::CREATED);
          } catch(EntityNotFoundException $e) {
            \Log::error($e->getMessage());
            return response()->json($e->getMessage(), SELF::NOT_FOUND);
          } catch(Exception $e) {
            \Log::error($e->getMessage());
            return response()->json('Server Error', SELF::INTERNAL_SERVER_ERROR);
          }
    }

    public function delete(ImageBatchRequest $request, int $id)
    {
        try {
            $this->service-> deletePicturesFromProduct($request, $id);
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
