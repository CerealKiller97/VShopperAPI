<?php

namespace App\Services;

use App\Models\Product;
use App\Models\Storage;
use App\Models\ProductStorage;
use App\Exceptions\BatchDeleteException;
use App\Contracts\ProductStorageContract;
use App\Http\Requests\ProductStorageRequest;
use App\Http\Requests\BatchProductStorageRequest;

class ProductStorageEloquentService extends BaseService implements ProductStorageContract
{
  public function addProductToStorage(ProductStorageRequest $request , int $id)
  {
    // Storage check
    $acc = auth()->user()->storages;
    $storage = Storage::find($id);
    $this->policy->can($acc, $storage, 'Storage');

    // Product check
    $acc = auth()->user()->products;
    $product = Product::find($request->product_id);
    $this->policy->can($acc, $product, 'Product');

    $data = $request->validated();

    ProductStorage::create([
      'product_id' => $data['product_id'],
      'storage_id' => $id,
      'quantity'   => $data['quantity']
    ]);
  }

  public function deleteProductFromStorage(BatchProductStorageRequest $request , int $id)
  {
    $acc = auth()->user()->storages;
    $storage = Storage::find($id);

    //$eager = Storage::with(['products'])->where('id', $id)->first();

    $this->policy->can($acc, $storage, 'Storage');

    $data = $request->validated()['products'];

    $products = ProductStorage::whereIn('product_id', $data)
                              ->where('storage_id', $id)
                              ->count();

    if ($products === count($data)) {
      $storage->products()->detach($data);
    } else {
      throw new BatchDeleteException('One of ids is not valid');
    }
  }
}

