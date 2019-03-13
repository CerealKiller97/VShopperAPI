<?php

namespace App\Contracts;

use App\DTO\StorageDTO;
use App\Http\Requests\StorageRequest;

interface StorageContract
{
  public function getStorages() : array;
  public function findStorage(int $id) : StorageDTO;
  public function addStorage(StorageRequest $request);
  public function updateStorage(StorageRequest $request, int $id);
  public function deleteStorage(int $id);
}
