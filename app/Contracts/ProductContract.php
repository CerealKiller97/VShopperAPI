<?php

declare(strict_types=1);

namespace App\Contracts;

use App\DTO\ProductDTO;
use App\Http\Requests\{
    ProductRequest,
    ProductSearchRequest

};

interface ProductContract
{
    public function getProducts(ProductSearchRequest $request); // : PagedResponse;

    public function findProduct(int $id): ProductDTO;

    public function addProduct(ProductRequest $request): void;

    public function updateProduct(ProductRequest $request, int $id): void;

    public function deleteProduct(int $id): void;
}

