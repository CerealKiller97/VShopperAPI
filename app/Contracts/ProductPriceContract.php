<?php

namespace App\Contracts;

use App\Http\Requests\ProductPriceRequest;

interface ProductPriceContract
{
  public function addNewPriceToProduct(ProductPriceRequest $request , int $id); // product_id
  public function updatePriceToProduct(ProductPriceRequest $request , int $id);
}

