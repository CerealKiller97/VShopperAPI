<?php

declare(strict_types=1);

namespace App\Contracts;

use App\Http\Requests\DiscountRequest;

interface ProductDiscountContract
{
    /**
     * @param DiscountRequest $request
     * @param int             $id
     */
    public function addDiscountToProduct(DiscountRequest $request, int $id): void;

    /**
     * @param DiscountRequest $request
     * @param int             $id
     */
    public function updateDiscountFromProduct(DiscountRequest $request, int $id): void;
}

