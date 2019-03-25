<?php

namespace App\Contracts;

use App\Http\Requests\ImageRequest;
use App\Http\Requests\ImageBatchRequest;

interface StorageImageContract
{
  public function addPicturesToStorage(ImageRequest $request, int $id);
  public function deletePicturesToStorage(ImageBatchRequest $request, int $id);
}

