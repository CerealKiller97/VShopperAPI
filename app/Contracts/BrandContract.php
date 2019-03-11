<?php

namespace App\Contracts;

use App\Http\Requests\BrandRequest;

interface BrandContract
{
  public function getBrands();
  public function findBrand(int $id);
  public function addBrand(BrandRequest $request);
  public function updateBrand(BrandRequest $request, int $id);
  public function deleteBrand(int $id);
}
