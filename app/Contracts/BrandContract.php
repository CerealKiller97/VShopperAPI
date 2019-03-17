<?php

namespace App\Contracts;

use App\DTO\BrandDTO;
use App\Http\Requests\BrandRequest;

interface BrandContract
{
  public function getBrands() : array;
  public function findBrand(int $id) : BrandDTO;
  public function addBrand(BrandRequest $request);
  public function updateBrand(BrandRequest $request, int $id);
  public function deleteBrand(int $id);
}
