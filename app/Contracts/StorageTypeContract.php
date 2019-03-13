<?php

namespace App\Contracts;

use App\DTO\StorageTypeDTO;
use App\Http\Requests\StorageTypeRequest;

interface StorageTypeContract
{
  public function getStorages() : array;
  public function findStorage(int $id): StorageTypeDTO;
  public function addStorage(StorageTypeRequest $request) : void;
  public function updateStorage(StorageTypeRequest $request, int $id);
  public function deleteStorage(int $id);
}
