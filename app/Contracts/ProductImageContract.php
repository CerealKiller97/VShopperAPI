<?php

declare(strict_types=1);

namespace App\Contracts;

use App\Http\Requests\{
    ImageRequest,
    ImageBatchRequest

};

interface ProductImageContract
{
    /**
     * @param ImageRequest $request
     * @param int          $id
     */
    public function addPicturesToProduct(ImageRequest $request, int $id): void; // product id

    /**
     * @param ImageBatchRequest $request
     * @param int               $id
     */
    public function deletePicturesFromProduct(ImageBatchRequest $request, int $id): void; // product id
}

