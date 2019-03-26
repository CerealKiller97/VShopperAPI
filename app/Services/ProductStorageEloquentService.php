<?php

namespace App\Services;

use App\Models\Product;
use App\Models\Storage;
use App\Services\BaseService;
use App\Models\ProductStorage;
use App\Exceptions\BatchDeleteException;
use App\Contracts\ProductStorageContract;
use App\Exceptions\EntityNotFoundException;
use App\Http\Requests\ProductStorageRequest;
use App\Http\Requests\BatchProductStorageRequest;

class ProductStorageEloquentService extends BaseService implements ProductStorageContract
{
  public function addProductToStorage(ProductStorageRequest $request , int $id)
  {
    $storage = Storage::find($id);
    $account_id = auth()->user()->id;

    // Storage doesn't exist in DB
    if (!$storage) {
      throw new EntityNotFoundException('Storage not found');
    }

      // Storage doesn't belong to auth user
    if ($storage->account_id !== $account_id) {
      throw new EntityNotFoundException('Storage not found');
    }

    $product = Product::find($request->product_id);

    // Product doesn't exist in DB
    if (!$product) {
      throw new EntityNotFoundException('Product not found');
    }

    // Product doesn't belong to auth user
    if ($product->account->id !== $account_id) {
      throw new EntityNotFoundException('Product not found');
    }

    $data = $request->validated();

    ProductStorage::create([
      'product_id' => $data['product_id'],
      'storage_id' => $id,
      'quantity'   => $data['quantity']
    ]);

  }

  public function deleteProductFromStorage(BatchProductStorageRequest $request , int $id)
  {
    $storage = Storage::find($id);

    // Storage doesn't exist in DB
    if (!$storage) {
      throw new EntityNotFoundException('Storage not found');
    }

    $account_id = auth()->user()->id;

      // Storage doesn't belong to auth user
    if ($storage->account_id !== $account_id) {
      throw new EntityNotFoundException('Storage not found');
    }

    $data = $request->validated()['products'];


    $products = ProductStorage::whereIn('product_id', $data)
                              ->where('storage_id', $id)
                              ->count();

    if ($products === count($data)) {
      ProductStorage::whereIn('product_id', $data)
                    ->delete();
    } else {
      throw new BatchDeleteException('One of ids is not valid');
    }
  }

}
