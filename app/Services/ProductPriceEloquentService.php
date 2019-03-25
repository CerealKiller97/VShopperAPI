<?php

namespace App\Services;

use App\Models\Group;
use App\Models\Price;
use App\Models\Product;
use App\Services\BaseService;
use App\Contracts\ProductPriceContract;
use App\Http\Requests\ProductPriceRequest;
use App\Exceptions\EntityNotFoundException;

class ProductPriceEloquentService extends BaseService implements ProductPriceContract
{
  public function addNewPriceToProduct(ProductPriceRequest $request , int $id)
  {
    $product = Product::find($id);

    if (!$product) {
      throw new EntityNotFoundException('Product not found');
    }

    $account_id = auth()->user()->id;

    // Product doesn't belong to auth user
    if ($product->account->id !== $account_id) {
      throw new EntityNotFoundException('Product not found');
    }

    $data = $request->validated();
    $group_id = $data['group_id'] ?? null;
    $amount = $data['amount'];

    // group id has been passed
    if ($group_id) {
      $group = Group::find($group_id);

      if (!$group) {
        throw new EntityNotFoundException('Group not found');
      }


      if (($group->account_id === null) || ($group->account_id === $account_id)) {
        Price::create([
          'product_id' => $id,
          'amount'     => $amount,
          'group_id'   => $group_id
        ]);
      }
    } else { // price is for everyone not specific price for group
      Price::create([
        'product_id' => $id,
        'amount'     => $amount,
        'group_id'   => $group_id
      ]);
    }
  }

  public function updatePriceToProduct(ProductPriceRequest $request , int $id)
  {
    $product = Product::find($id);

    if (!$product) {
      throw new EntityNotFoundException('Product not found');
    }

    $account_id = auth()->user()->id;

    // Product doesn't belong to auth user
    if ($product->account->id !== $account_id) {
      throw new EntityNotFoundException('Product not found');
    }

    $data = $request->validated();
    $group_id = $data['group_id'] ?? null;
    $amount = $data['amount'];

    if ($group_id) {

      $group = Group::find($group_id);

      if (!$group) {
        throw new EntityNotFoundException('Group not found');
      }

      $productPrice = Price::where([
        ['product_id', $id],
        ['group_id', $group_id]
      ])
      ->latest()->first();
      $productPrice->update([
        'amount'     => $amount,
        'product_id' => $id,
        'group_id'   => $group_id
      ]);

    } else {
      // group_id not passed for all users

      $productPrice = Price::where([
        ['product_id', $id],
        ['group_id', null]
      ])
      ->latest()->first();
      $productPrice->update([
        'amount'     => $amount,
        'product_id' => $id
      ]);
    }
  }
}
