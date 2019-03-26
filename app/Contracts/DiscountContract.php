<?php

namespace App\Contracts;

use App\Http\Requests\DiscountRequest;

interface DiscountContract
{
  public function getDiscounts();
  public function findDiscount(int $id);
  public function addDiscountToProduct(DiscountRequest $request, int $product_id);
  public function addDiscountToGroup(DiscountRequest $request, int $group_id);
  public function deleteDiscount();

}
