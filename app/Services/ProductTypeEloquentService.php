<?php

namespace App\Services;

use App\DTO\ProductTypeDTO;
use App\Models\ProductType;
use App\Services\BaseService;
use App\Helpers\PagedResponse;
use App\Http\Requests\PagedRequest;
use App\Contracts\ProductTypeContract;
use App\Http\Requests\ProductTypeRequest;

class ProductTypeEloquentService extends BaseService implements ProductTypeContract
{
  public function getProductTypes(PagedRequest $request) : PagedResponse
  {
    $page = $request->getPaging()->page;
    $perPage = $request->getPaging()->perPage;
    $name = $request->getPaging()->name;

    $productTypes = new ProductType;
    $account_id =  auth()->user()->id;

    $acc = $productTypes->where('account_id', $account_id);
    $items = $this->generatePagedResponse($acc, $perPage, $page, $name);
    $productTypesCount = auth()->user()->productTypes->count();

    $default = ProductType::default()->get();

    $final = $default->merge($items);

    $unitsCount = $final->count();

    $productTypesArr = [];

    foreach($final as $productType)
    {
      $productTypeDTO = new ProductTypeDTO;

      $productTypeDTO->id = $productType->id;
      $productTypeDTO->name = $productType->name;

      $productTypesArr[] = $productTypeDTO;
    }

    return new PagedResponse($productTypesArr, $unitsCount, $page);
  }

  public function findProductType(int $id) : ProductTypeDTO
  {
    $acc = auth()->user()->productTypes;
    $productType = ProductType::find($id);

    $this->policy->can($acc, $productType, 'Product type');

    $productTypeDTO = new ProductTypeDTO;

    $productTypeDTO->id = $productType->id;
    $productTypeDTO->name = $productType->name;
    $productTypeDTO->abbr = $productType->abbr;

    return $productTypeDTO;
  }

  public function addProductType(ProductTypeRequest $request)
  {
    $productType = ProductType::create($request->validated());
    auth()->user()->productTypes()->save($productType);
  }

  public function updateProductType(ProductTypeRequest $request, int $id)
  {
    $acc = auth()->user()->productTypes;
    $productType = ProductType::find($id);

    $this->policy->can($acc, $productType, 'Product type');

    $productType->fill($request->validated());
    $productType->save();
  }

  public function deleteProductType(int $id)
  {
    $acc = auth()->user()->productTypes;
    $productType = ProductType::find($id);

    $this->policy->can($acc, $productType, 'Product type');

    $productType->delete();
  }

}
