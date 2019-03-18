<?php

namespace App\Services;

use App\DTO\BrandDTO;
use App\Models\Brand;
use App\Services\BaseService;
use App\Helpers\PagedResponse;
use App\Contracts\BrandContract;
use App\Http\Requests\BrandRequest;
use App\Http\Requests\PagedRequest;
use App\Exceptions\EntityNotFoundException;

class BrandEloquentService extends BaseService implements BrandContract
{
  public function getBrands(PagedRequest $request) : PagedResponse
  {
    $page = $request->getPaging()->page;
    $perPage = $request->getPaging()->perPage;


    $brands = new Brand;
    $account_id =  auth()->user()->id;

    $acc = $brands->where('account_id', $account_id);
    $items = $this->generatePagedResponse($acc, $perPage, $page)->toArray();
    $brandsCount = auth()->user()->brands->count();

    $brands = auth()->user()->brands;
    $brandsArr = [];

    foreach ($items as $brand)
    {
      $brandDTO = new BrandDTO;

      $brandDTO->id = $brand['id'];
      $brandDTO->name = $brand['name'];

      $brandsArr[] = $brandDTO;
    }

    return new PagedResponse($brandsArr, $brandsCount, $page);
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
