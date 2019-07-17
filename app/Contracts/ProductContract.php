<?php

declare(strict_types=1);

namespace App\Contracts;

use App\DTO\ProductDTO;
use App\Helpers\PagedResponse;
use App\Http\Requests\{
    ProductRequest,
    ProductSearchRequest

};

interface ProductContract
{
    /**
     * @param ProductSearchRequest $request
     *
     * @return mixed
     */
    public function getProducts(ProductSearchRequest $request): PagedResponse;

    /**
     * @param int $id
     *
     * @return ProductDTO
     */
    public function findProduct(int $id): ProductDTO;

    /**
     * @param ProductRequest $request
     */
    public function addProduct(ProductRequest $request): void;

    /**
     * @param ProductRequest $request
     * @param int            $id
     */
    public function updateProduct(ProductRequest $request, int $id): void;

    /**
     * @param int $id
     */
    public function deleteProduct(int $id): void;
}

