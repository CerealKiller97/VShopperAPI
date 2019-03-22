<?php

namespace App\Contracts;

use App\DTO\ProductTypeDTO;
use App\Helpers\PagedResponse;
use App\Http\Requests\PagedRequest;
use App\Http\Requests\ProductTypeRequest;

interface ProductTypeContract
{
  public function getProductTypes(PagedRequest $request) : PagedResponse;
  public function findProductType(int $id) : ProductTypeDTO;
  public function addProductType(ProductTypeRequest $request);
  public function updateProductType(ProductTypeRequest $request, int $id);
  public function deleteProductType(int $id);
}
