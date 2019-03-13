<?php

namespace App\Contracts;

use App\DTO\ProductTypeDTO;
use App\Http\Requests\ProductTypeRequest;

interface ProductTypeContract
{
  public function getProductTypes() : array;
  public function findProductType(int $id) : ProductTypeDTO;
  public function addProductType(ProductTypeRequest $request);
  public function updateProductType(ProductTypeRequest $request, int $id);
  public function deleteProductType(int $id);
}
