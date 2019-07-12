<?php

declare(strict_types=1);

namespace App\Contracts;

use App\Http\Requests\DiscountRequest;

interface ProductDiscountContract
{
    public function addDiscountToProduct(DiscountRequest $request, int $id);

    public function updateDiscountFromProduct(DiscountRequest $request, int $id);
}

