<?php

declare(strict_types=1);

namespace App\Contracts;

use App\Http\Requests\{
    ImageRequest,
    ImageBatchRequest

};

interface StorageImageContract
{
    public function addPicturesToStorage(ImageRequest $request, int $id): void;

    public function deletePicturesToStorage(ImageBatchRequest $request, int $id): void;
}

