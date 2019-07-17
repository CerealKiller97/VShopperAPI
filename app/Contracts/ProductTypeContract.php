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
    /**
     * @param PagedRequest $request
     *
     * @return PagedResponse
     */
    public function getProductTypes(PagedRequest $request): PagedResponse;

    /**
     * @param int $id
     *
     * @return ProductTypeDTO
     */
    public function findProductType(int $id): ProductTypeDTO;

    /**
     * @param ProductTypeRequest $request
     */
    public function addProductType(ProductTypeRequest $request): void;

    /**
     * @param ProductTypeRequest $request
     * @param int                $id
     */
    public function updateProductType(ProductTypeRequest $request, int $id): void;

    /**
     * @param int $id
     */
    public function deleteProductType(int $id): void;
}

