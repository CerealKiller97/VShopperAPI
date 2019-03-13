<?php

namespace App\Services;

use App\DTO\ProductDTO;
use App\Models\Product;
use App\Contracts\ProductContract;
use App\Http\Requests\ProductRequest;

class ProductEloquentService implements ProductContract
{
  public function getProducts() : array
  {

  }

  public function findProduct(int $id) : ProductDTO
  {

  }

  public function addProduct(ProductRequest $request)
  {

  }

  public function updateProduct(ProductRequest $request, int $id)
  {

  }

  public function removeProduct(int $id)
  {

  }

  public function addPictureToProduct(int $id)
  {

  }

}
