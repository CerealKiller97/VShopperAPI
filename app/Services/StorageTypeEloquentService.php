<?php

namespace App\Services;

use App\DTO\StorageTypeDTO;
use App\Models\StorageType;
use App\Services\BaseService;
use App\Contracts\StorageTypeContract;
use App\Http\Requests\StorageTypeRequest;

class StorageTypeEloquentService extends BaseService implements StorageTypeContract
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
    $acc = auth()->user()->storageTypes;
    $storageType = StorageType::find($id);

    $this->policy->can($acc, $storageType, 'Storage type');

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
    $acc = auth()->user()->storageTypes;
    $storageType = StorageType::find($id);

    $this->policy->can($acc, $storageType, 'Storage type');

    $storageType->fill($request->validated());
    $storageType->save();
  }

  public function deleteStorageType(int $id)
  {
    $acc = auth()->user()->storageTypes;
    $storageType = StorageType::find($id);

    $this->policy->can($acc, $storageType, 'Storage type');

    $storageType->delete();
  }

}
