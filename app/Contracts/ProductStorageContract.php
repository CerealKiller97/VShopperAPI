<?php

declare(strict_types=1);

namespace App\Contracts;

use App\Http\Requests\{
    ProductStorageRequest,
    BatchProductStorageRequest

};

interface ProductStorageContract
{
    /**
     * @param ProductStorageRequest $request
     * @param int                   $id
     */
    public function addProductToStorage(ProductStorageRequest $request, int $id): void;

    /**
     * @param BatchProductStorageRequest $request
     * @param int                        $id
     */
    public function deleteProductFromStorage(BatchProductStorageRequest $request, int $id): void;
}

