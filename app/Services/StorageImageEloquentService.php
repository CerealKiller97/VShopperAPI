<?php

declare(strict_types=1);

namespace App\Services;

use App\Models\{
    Image,
    Storage,
    StorageImage

};
use App\Helpers\{
    UploadFile,
    ImagePivotTableRemover

};
use App\Http\Requests\{
    ImageRequest,
    ImageBatchRequest

};
use App\Contracts\StorageImageContract;
use App\Exceptions\{
    EntityNotFoundException,
    BatchDeleteException

};

class StorageImageEloquentService extends BaseService implements StorageImageContract
{
    /**
     * @param ImageRequest $request
     * @param int          $id
     *
     * @throws EntityNotFoundException
     */
    public function addPicturesToStorage(ImageRequest $request, int $id): void
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

        foreach ($images as $image) {
            $src = UploadFile::move($image);
            $image_id = Image::create($src)->id;
            $storageImage = StorageImage::create(['storage_id' => $id, 'image_id' => $image_id]);
        }
    }

    /**
     * @param ImageBatchRequest $request
     * @param int               $id
     *
     * @throws BatchDeleteException
     */
    public function deletePicturesToStorage(ImageBatchRequest $request, int $id): void
    {
        $imageIDS = $request->validated()['images'];

        ImagePivotTableRemover::remove('image_storage', $imageIDS, $id);
    }
}
