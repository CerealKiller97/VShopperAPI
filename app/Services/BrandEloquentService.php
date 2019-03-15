<?php

namespace App\Services;

use App\DTO\BrandDTO;
use App\Models\Brand;
use App\Services\BaseService;
use App\Contracts\BrandContract;
use App\Http\Requests\BrandRequest;
use App\Exceptions\EntityNotFoundException;

class BrandEloquentService extends BaseService implements BrandContract
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
    $acc = auth()->user()->brands;
    $brand = Brand::find($id);

    $this->policy->can($acc, $brand, 'Brand');

    $brandDTO = new BrandDTO;

    $brandDTO->id = $brand->id;
    $brandDTO->name = $brand->name;

    return $brandDTO;
  }

  public function addBrand(BrandRequest $request)
  {
    auth()->user()->brands()->create($request->validated());
  }

  public function updateBrand(BrandRequest $request, int $id)
  {
    $acc = auth()->user()->brands;
    $brand = Brand::find($id);

    $this->policy->can($acc, $brand, 'Brand');

    $brand->fill($request->validated());
    $brand->save();
  }

  public function deleteBrand(int $id)
  {
    $acc = auth()->user()->brands;
    $brand = Brand::find($id);

    $this->policy->can($acc, $brand, 'Brand');

    $brand->delete();
  }

}
