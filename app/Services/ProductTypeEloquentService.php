<?php

namespace App\Services;

use App\DTO\ProductTypeDTO;
use App\Models\ProductType;
use App\Contracts\ProductTypeContract;
use App\Http\Requests\ProductTypeRequest;

class ProductTypeEloquentService implements ProductTypeContract
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
    $productType = ProductType::find($id);

    if (!$productType)
      throw new EntityNotFoundException('ProductType not found');

    $productTypeDTO = new ProductTypeDTO;

    $productTypeDTO->id = $productType->id;
    $productTypeDTO->name = $productType->name;
    $productTypeDTO->abbr = $productType->abbr;

    return $productTypeDTO;
  }

  public function addProductType(ProductTypeRequest $request)
  {
    $produtcType = ProductType::create($request->validated());
    auth()->user()->productTypes()->save($produtcType);
  }

  public function updateProductType(ProductTypeRequest $request, int $id)
  {
    $productType = ProductType::find($id);

    if (!$productType) {
      throw new EntityNotFoundException('Product type not found');
    }

    $productType->fill($request->validated());
    $productType->save();
  }

  public function deleteProductType(int $id)
  {
    $productType = ProductType::find($id);

    if (!$productType) {
      throw new EntityNotFoundException('Unit not found');
    }

    $productType->delete();
  }

}
