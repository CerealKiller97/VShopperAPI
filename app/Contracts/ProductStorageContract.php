<?php

declare(strict_types=1);

namespace App\Contracts;

use App\Http\Requests\ProductStorageRequest;
use App\Http\Requests\BatchProductStorageRequest;

interface ProductStorageContract
{
    public function addProductToStorage(ProductStorageRequest $request, int $id): void;

    public function deleteProductFromStorage(BatchProductStorageRequest $request, int $id): void;
}

