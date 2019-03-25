<?php

namespace App\Contracts;

use App\Http\Requests\ImageRequest;
use App\Http\Requests\ImageBatchRequest;

interface ProductImageContract
{
  public function addPicturesToProduct(ImageRequest $request, int $id); // product id
  public function deletePicturesFromProduct(ImageBatchRequest $request, int $id); // product id
}
