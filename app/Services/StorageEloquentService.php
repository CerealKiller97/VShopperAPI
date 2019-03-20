<?php

namespace App\Services;

use App\Models\Image;
use App\DTO\StorageDTO;
use App\Models\Storage;
use App\Helpers\UploadFile;
use App\Models\StorageType;
use App\Models\StorageImage;
use Illuminate\Http\Request;
use App\Services\BaseService;
use App\Helpers\PagedResponse;
use App\Contracts\StorageContract;
use App\Http\Requests\ImageRequest;
use App\Http\Requests\StorageRequest;
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
    $storageDTO->storage_type_id = $storage->storage_type_id;
    $storageDTO->storage_name = $storage->type->name;

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

    if (!$request->images) {
      $storage->fill($request->validated());
      $storage->save();
    } else {
      $src = UploadFile::move($request->images);

      $image_id = Image::create($src)->id;
      StorageImage::create([
        'storage_id' => $id,
        'image_id'   => $image_id
      ]);
    }

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

    $images = ($request->all()['images']);
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
    $imageIDS = $request->validated()['images'];

    foreach ($imageIDS as $imageID)
    { // Delete from pivot table
      $i = StorageImage::getByImageID($imageID)->get()[0];
      $i->delete();
      // Delete from Image table
      $image =Image::find($imageID);
      // Delete file from server
      unlink(public_path('/') . $image->src);
      $image->delete();
    }

    Image::destroy($imageIDS);
  }

}

