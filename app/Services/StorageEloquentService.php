<?php

namespace App\Services;

use Exception;
use App\Models\Image;
use App\DTO\StorageDTO;
use App\Models\Storage;
use App\Helpers\UploadFile;
use App\Models\StorageType;
use App\Models\StorageImage;
use Illuminate\Http\Request;
use App\Helpers\ImageRemover;
use App\Services\BaseService;
use App\Helpers\PagedResponse;
use App\Contracts\StorageContract;
use App\Http\Requests\ImageRequest;
use App\Http\Requests\StorageRequest;
use App\Helpers\ImagePivotTableRemover;
use App\Exceptions\BatchDeleteException;
use App\Http\Requests\ImageBatchRequest;
use App\Exceptions\EntityNotFoundException;
use App\Http\Requests\StorageSearchRequest;

class StorageEloquentService extends BaseService implements StorageContract
{
  public function getStorages(StorageSearchRequest $request) : PagedResponse
  {
    $page = $request->getPaging()->page;
    $perPage = $request->getPaging()->perPage;

    $storages = new Storage;
    $account_id =  auth()->user()->id;

    $acc = $storages->where('account_id', $account_id);
    $items = $this->generatePagedResponse($acc, $perPage, $page);
    $storagesCount = auth()->user()->storages->count();

    $storagesArr = [];

    foreach($items as $storage)
    {
      $storageDTO = new StorageDTO;

      $storageDTO->id = $storage->id;
      $storageDTO->address = $storage->address;
      $storageDTO->size = $storage->size;
      $storageDTO->storage_name = $storage->type->name;

      $tmp = $storage->images;
      $images = $tmp->map(function ($item) {
        $image = new \StdClass;
        $image->id = $item->id;
        $image->src = $item->src;

        return $image;
      });
      $storageDTO->images = $images;
      $storagesArr[] = $storageDTO;
    }
    return new PagedResponse($storagesArr, $storagesCount, $page);
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
    $storageDTO->storage_name = $storage->type->name;

    $storageImages = $storage->images;

    $images = $storageImages->map(function ($item) {
      $image = new \StdClass;
      $image->id = $item->id;
      $image->src = $item->src;

      return $image;
    });
    $storageDTO->images = $images;

    return $storageDTO;
  }

  public function addStorage(StorageRequest $request)
  {
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

}
