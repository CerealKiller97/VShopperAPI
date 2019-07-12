<?php

declare(strict_types=1);

namespace App\Contracts;

use App\Http\Requests\ImageRequest;
use App\Http\Requests\ImageBatchRequest;

interface ProductImageContract
{
    public function addPicturesToProduct(ImageRequest $request, int $id): void; // product id

    public function deletePicturesFromProduct(ImageBatchRequest $request, int $id): void; // product id
}

