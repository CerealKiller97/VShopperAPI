<?php

declare(strict_types=1);

namespace App\Contracts;

use App\Http\Requests\ProductPriceRequest;

interface ProductPriceContract
{
    public function addNewPriceToProduct(ProductPriceRequest $request, int $id): void; // product_id

    public function updatePriceToProduct(ProductPriceRequest $request, int $id): void;
}

