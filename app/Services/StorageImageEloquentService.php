<?php

namespace App\Services;

use App\Models\Image;
use App\Models\Storage;
use App\Helpers\UploadFile;
use App\Models\StorageImage;
use App\Services\BaseService;
use App\Http\Requests\ImageRequest;
use App\Contracts\StorageImageContract;
use App\Helpers\ImagePivotTableRemover;
use App\Http\Requests\ImageBatchRequest;
use App\Exceptions\EntityNotFoundException;

class StorageImageEloquentService extends BaseService implements StorageImageContract
{
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
    $imageIDS = $request->validated()['images'];

    ImagePivotTableRemover::remove('image_storage', $imageIDS, $id);
  }
}
