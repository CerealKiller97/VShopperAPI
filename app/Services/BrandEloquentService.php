<?php

namespace App\Services;

use App\DTO\BrandDTO;
use App\Contracts\BrandContract;
use App\Http\Requests\BrandRequest;

class BrandEloquentService implements BrandContract
{
  public function getBrands() : array
  {

  }

  public function findBrand(int $id) : BrandDTO
  {

  }

  public function addBrand(BrandRequest $request)
  {

  }

  public function updateBrand(BrandRequest $request, int $id)
  {

  }

  public function deleteBrand(int $id)
  {

  }

}
