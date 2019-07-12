<?php

declare(strict_types=1);

namespace App\Contracts;

use App\DTO\ProductTypeDTO;
use App\Helpers\PagedResponse;
use App\Http\Requests\{
    PagedRequest,
    ProductTypeRequest

};

interface ProductTypeContract
{
    public function getProductTypes(PagedRequest $request): PagedResponse;

    public function findProductType(int $id): ProductTypeDTO;

    public function addProductType(ProductTypeRequest $request): void;

    public function updateProductType(ProductTypeRequest $request, int $id): void;

    public function deleteProductType(int $id): void;
}

