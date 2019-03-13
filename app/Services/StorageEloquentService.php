<?php

namespace App\Services;

use App\DTO\StorageDTO;
use App\Models\Storage;
use App\Contracts\StorageContract;
use App\Http\Requests\StorageRequest;
use App\Exceptions\EntityNotFoundException;

class StorageEloquentService implements StorageContract
{
  public function getStorages() : array
  {
    $storages = auth()->user()->storages;
    $storagesArr = [];

    foreach($storages as $storage)
    {
      $storageDTO = new StorageDTO;

      $storageDTO->id = $storage->id;
      $storageDTO->address = $storage->address;
      $storageDTO->size = $storage->size;
      $storageDTO->storage_type_id = $storage->storage_type_id;
      $storageDTO->storage_name = $storage->type->name;

      $storagesArr[] = $storageDTO;
    }

    return ['data' => $storagesArr];
  }

  public function findStorage(int $id) : StorageDTO
  {
    $storage = Storage::find($id);

    if (!$storage) {
      throw new EntityNotFoundException('Storage not found');
    }

    $storageDTO = new StorageDTO;

    $storageDTO->id = $storage->id;
    $storageDTO->address = $storage->address;
    $storageDTO->size = $storage->size;
    $storageDTO->storage_type_id = $storage->storage_type_id;
    $storageDTO->storage_name = $storage->type->name;

    return $storageDTO;
  }

  public function addStorage(StorageRequest $request)
  {
    $storage = Storage::create($request->validated());
    auth()->user()->storages()->save($storage);
  }

  public function updateStorage(StorageRequest $request, int $id)
  {
    $storage = Storage::find($id);

    if (!$storage) {
      throw new EntityNotFoundException('Storage not found');
    }

    $storage->fill($request->validated());
    $storage->save();
  }

  public function deleteStorage(int $id)
  {
    $storage = Storage::find($id);

    if (!$storage) {
      throw new EntityNotFoundException('Storage not found');
    }

    $storage->delete();
  }
}

