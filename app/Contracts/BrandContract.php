<?php

namespace App\Contracts;

use App\Http\Requests\BrandRequest;

interface BrandContract
{
  public function getBrands();
  public function addBrand(BrandRequest $request);
  public function findBrand(int $id);
  public function deleteBrand(int $id);
  public function updateBrand(BrandRequest $request, int $id);
}
