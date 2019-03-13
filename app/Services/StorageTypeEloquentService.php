<?php

namespace App\Services;

use App\DTO\StorageTypeDTO;
use App\Models\StorageType;
use App\Contracts\StorageTypeContract;
use App\Http\Requests\StorageTypeRequest;
use App\Exceptions\EntityNotFoundException;

class StorageTypeEloquentService implements StorageTypeContract
{
  public function getStorageTypes() : array
  {
    $default = StorageType::default()->get()->toArray();
    $acc = auth()->user()->storageTypes->toArray();
    $storageTypes = array_merge($default, $acc);

    $storageTypesArr = [];
    foreach($storageTypes as $storageType)
    {
      $storageTypeDTO = new StorageTypeDTO;

      $storageTypeDTO->id = $storageType['id'];
      $storageTypeDTO->name = $storageType['name'];

      $storageTypesArr[] = $storageTypeDTO;
    }

    return ['data' => $storageTypesArr];
  }

  public function findStorageType(int $id): StorageTypeDTO
  {
    $storageType = StorageType::find($id);

    if (!$storageType) {
      throw new EntityNotFoundException('Storage type not found');
    }

    $storageTypeDTO = new StorageTypeDTO;

    $storageTypeDTO->id = $storageType->id;
    $storageTypeDTO->name = $storageType->name;


    return $storageTypeDTO;
  }

  public function addStorageType(StorageTypeRequest $request)
  {
    $storageType = StorageType::create($request->validated());
    auth()->user()->storageTypes()->save($storageType);
  }

  public function updateStorageType(StorageTypeRequest $request, int $id)
  {
    $storageType = StorageType::find($id);

    if (!$storageType) {
      throw new EntityNotFoundException('Storage type not found');
    }

    $storageType->fill($request->validated());
    $storageType->save();
  }

  public function deleteStorageType(int $id)
  {
    $storageType = StorageType::find($id);

    if (!$storageType) {
      throw new EntityNotFoundException('Storage type not found');
    }

    $storageType->delete();
  }

}
