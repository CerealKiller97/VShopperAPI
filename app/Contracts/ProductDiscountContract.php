<?php

namespace App\Contracts;

use App\Http\Requests\DiscountRequest;

interface ProductDiscountContract
{
  public function addDiscountToProduct(DiscountRequest $request, int $id);
  public function upateDiscountFromProduct(DiscountRequest $request, int $id);
}

