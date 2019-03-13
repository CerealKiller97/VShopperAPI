<?php

namespace App\Services;

use App\DTO\BrandDTO;
use App\Models\Brand;
use App\Contracts\BrandContract;
use App\Http\Requests\BrandRequest;
use App\Exceptions\EntityNotFoundException;

class BrandEloquentService implements BrandContract
{
  public function getBrands() : array
  {
    $brands = auth()->user()->brands;
    $brandsArr = [];

    foreach ($brands as $brand)
    {
      $brandDTO = new BrandDTO;

      $brandDTO->id = $brand->id;
      $brandDTO->name = $brand->name;

      $brandsArr[] = $brandDTO;
    }

    return ['data' => $brandsArr];
  }

  public function findBrand(int $id) : BrandDTO
  {
    $brand = Brand::find($id);

    if (!$brand) {
      throw new EntityNotFoundException('Brand not found');
    }

    $brandDTO = new BrandDTO;

    $brandDTO->id = $brand->id;
    $brandDTO->name = $brand->name;

    return $brandDTO;
  }

  public function addBrand(BrandRequest $request)
  {
    // $brand = Brand::create($request->validated());
    auth()->user()->brands()->create($request->validated());
  }

  public function updateBrand(BrandRequest $request, int $id)
  {
    $brand = Brand::find($id);

    if (!$brand) {
      throw new EntityNotFoundException('Brand not found');
    }

    $brand->fill($request->validated());
    $brand->save();
  }

  public function deleteBrand(int $id)
  {
    $brand = Brand::find($id);

    if (!$brand) {
      throw new EntityNotFoundException('Brand not found');
    }

    $brand->delete();
  }

}
