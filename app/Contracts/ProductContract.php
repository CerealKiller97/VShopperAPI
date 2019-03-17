<?php

namespace App\Contracts;

use App\DTO\ProductDTO;
use App\Http\Requests\ProductRequest;

interface ProductContract
{
  public function getProducts() : array;
  public function findProduct(int $id) : ProductDTO;
  public function addProduct(ProductRequest $request);
  public function updateProduct(ProductRequest $request, int $id);
  public function removeProduct(int $id);
  public function addPictureToProduct(int $id); // product id
}
