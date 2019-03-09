<?php

namespace App\Contracts;

use App\DTO\ProductTypeDTO;
use App\Http\Requests\ProductTypeRequest;

interface ProductTypeContract
{
  public function getAllProductsTypes();
  public function findProductType(int $id) :ProductTypeDTO;
  public function addProduct(ProductTypeRequest $request);
  public function updateProduct(ProductTypeRequest $request, int $id);
  public function removeProduct(int $id);
}
