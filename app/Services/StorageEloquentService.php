<?php

namespace App\Services;

use App\Models\Image;
use App\DTO\StorageDTO;
use App\Models\Storage;
use App\Helpers\UploadFile;
use App\Services\BaseService;
use App\Contracts\StorageContract;
use App\Http\Requests\StorageRequest;

class StorageEloquentService extends BaseService implements StorageContract
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
    $acc = auth()->user()->storages;
    $storage = Storage::find($id);

    $this->policy->can($acc, $storage, 'Storage');

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
    // $storage = Storage::create($request->validated());
    // auth()->user()->storages()->save($storage);
    auth()->user()->storages()->create($request->validated());
  }

  public function updateStorage(StorageRequest $request, int $id)
  {
    $acc = auth()->user()->storages;
    $storage = Storage::find($id);

    $this->policy->can($acc, $storage, 'Storage');

    $storage->fill($request->validated());
    $storage->save();
  }

  public function deleteStorage(int $id)
  {
    $acc = auth()->user()->storages;
    $storage = Storage::find($id);

    $this->policy->can($acc, $storage, 'Storage');

    $storage->delete();
  }

  public function addPicturesToStorage(array $images, int $id)
  {
    foreach($images as $image)
    {
      $src = UploadFile::move($image);

      $image_id = Image::create($src)->id;


    }
  }
}

