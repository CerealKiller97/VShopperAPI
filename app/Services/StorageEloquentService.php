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
    $items = $this->generatePagedResponse($acc, $perPage, $page)->toArray();
    $storagesCount = auth()->user()->storages->count();

    $storagesArr = [];

    foreach($items as $storage)
    {
      $storageDTO = new StorageDTO;

      $storageDTO->id = $storage['id'];
      $storageDTO->address = $storage['address'];
      $storageDTO->size = $storage['size'];
      $storageDTO->storage_name = ($storage['storage_type_id'])
         ? StorageType::find($storage['storage_type_id'])->name
         : null;

      $tmp = Storage::find($storage['id'])->images;
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

  public function addPicturesToStorage(ImageRequest $request, int $id)
  {
    $storage = Storage::find($id);

    if (!$storage) {
      throw new EntityNotFoundException('Storage not found');
    }

    $user_id = auth()->user()->id;

    // Storage doesn't belong to auth user, but exist in DB
    if ($user_id !== $storage->account->id) {
      throw new EntityNotFoundException('Storage not found');
    }

    $images = $request->validated()['images'];

    foreach ($images as $image)
    {
      $src = UploadFile::move($image);
      $image_id = Image::create($src)->id;
      $storageImage = StorageImage::create([
        'storage_id' => $id,
        'image_id'   => $image_id
      ]);
    }
  }

  public function deletePicturesToStorage(ImageBatchRequest $request, int $id)
  {
    $account_id = auth()->user()->id;

    $imageIDS = $request->validated()['images'];

    // $this->policy->canDeleteFromPivotTable('image_storage', $imageIDS, $id, 'storage_id');

    $images = StorageImage::whereIn('image_id',  $imageIDS)
                          ->where('storage_id', $id)
                          ->count();

    // $images = \DB::table('image_storage')
    //                ->whereIn('image_id', $imageIDS)
    //                ->where('storage_id', $id)
    //                ->count();

    if ($images === count($imageIDS)) {
      StorageImage::whereIn('image_id',  $imageIDS)->delete();
    } else {
      throw new BatchDeleteException('One of ids is not valid');
    }
  }
}

