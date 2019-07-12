<?php

declare(strict_types=1);

namespace App\Contracts;

use App\DTO\BrandDTO;
use App\Helpers\PagedResponse;
use App\Http\Requests\{
    BrandRequest,
    PagedRequest

};

interface BrandContract
{
    public function getBrands(PagedRequest $request): PagedResponse;

    public function findBrand(int $id): BrandDTO;

    public function addBrand(BrandRequest $request): void;

    public function updateBrand(BrandRequest $request, int $id): void;

    public function deleteBrand(int $id): void;
}
