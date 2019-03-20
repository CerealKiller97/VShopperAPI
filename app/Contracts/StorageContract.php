<?php

namespace App\Contracts;

use App\DTO\StorageDTO;
use Illuminate\Http\Request;
use App\Helpers\PagedResponse;
use App\Http\Requests\ImageRequest;
use App\Http\Requests\StorageRequest;
use App\Http\Requests\ImageBatchRequest;
use App\Http\Requests\StorageSearchRequest;

interface StorageContract
{
  public function getStorages(StorageSearchRequest $request) : PagedResponse;
  public function findStorage(int $id) : StorageDTO;
  public function addStorage(StorageRequest $request);
  public function updateStorage(StorageRequest $request, int $id);
  public function deleteStorage(int $id);
  public function addPicturesToStorage(ImageRequest $request, int $id);
  public function deletePicturesToStorage(ImageBatchRequest $request, int $id);

}
