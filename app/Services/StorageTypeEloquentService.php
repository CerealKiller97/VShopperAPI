<?php

namespace App\Services;

use App\DTO\StorageTypeDTO;
use App\Models\StorageType;
use App\Services\BaseService;
use App\Helpers\PagedResponse;
use App\Http\Requests\PagedRequest;
use App\Contracts\StorageTypeContract;
use App\Http\Requests\StorageTypeRequest;

class StorageTypeEloquentService extends BaseService implements StorageTypeContract
{
  public function getStorageTypes(PagedRequest $request) //: PagedResponse
  {
    $page = $request->getPaging()->page;
    $perPage = $request->getPaging()->perPage;
    $name = $request->getPaging()->name;

    $storageTypes = new StorageType;
    $account_id =  auth()->user()->id;

    $acc = $storageTypes->where('account_id', $account_id);
    $items = $this->generatePagedResponse($acc, $perPage, $page, $name)->toArray();
    $storageTypesCount = auth()->user()->storageTypes->count();


    $default = StorageType::default()->get()->toArray();
    $acc = auth()->user()->storageTypes->toArray();
    $storageTypes = array_merge($default, $acc);
    $storageTypesTotal = count($storageTypes);

    // dd($storageTypes);

    $storageTypesArr = [];
    foreach($storageTypes as $storageType)
    {
      $storageTypeDTO = new StorageTypeDTO;

      $storageTypeDTO->id = $storageType['id'];
      $storageTypeDTO->name = $storageType['name'];

      $storageTypesArr[] = $storageTypeDTO;
    }

    return new PagedResponse($storageTypesArr, $storageTypesTotal, $page);
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
