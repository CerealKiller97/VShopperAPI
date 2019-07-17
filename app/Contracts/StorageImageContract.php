<?php

declare(strict_types=1);

namespace App\Contracts;

use App\Http\Requests\{
    ImageRequest,
    ImageBatchRequest

};

interface StorageImageContract
{
    /**
     * @param ImageRequest $request
     * @param int          $id
     */
    public function addPicturesToStorage(ImageRequest $request, int $id): void;

    /**
     * @param ImageBatchRequest $request
     * @param int               $id
     */
    public function deletePicturesToStorage(ImageBatchRequest $request, int $id): void;
}

