<?php

namespace App\Contracts;

use App\DTO\StorageTypeDTO;
use App\Helpers\PagedResponse;
use App\Http\Requests\PagedRequest;
use App\Http\Requests\StorageTypeRequest;

interface StorageTypeContract
{
  public function getStorageTypes(PagedRequest $request);// : PagedResponse;
  public function findStorageType(int $id): StorageTypeDTO;
  public function addStorageType(StorageTypeRequest $request);
  public function updateStorageType(StorageTypeRequest $request, int $id);
  public function deleteStorageType(int $id);
}
