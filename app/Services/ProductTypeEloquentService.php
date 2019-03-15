<?php

namespace App\Services;

use App\DTO\ProductTypeDTO;
use App\Models\ProductType;
use App\Services\BaseService;
use App\Contracts\ProductTypeContract;
use App\Http\Requests\ProductTypeRequest;

class ProductTypeEloquentService extends BaseService implements ProductTypeContract
{
  public function getProductTypes() : array
  {
    $default = ProductType::default()->get()->toArray();
    $acc = auth()->user()->productTypes->toArray();
    $productTypes = array_merge($default, $acc);

    $productTypesArr = [];
    foreach($productTypes as $productType)
    {
      $productTypeDTO = new ProductTypeDTO;

      $productTypeDTO->id = $productType['id'];
      $productTypeDTO->name = $productType['name'];

      $productTypesArr[] = $productTypeDTO;
    }

    return ['data' => $productTypesArr];
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
