<?php

namespace App\Services;

use App\Models\Group;
use App\Models\Product;
use App\Models\Discount;
use App\Models\DiscountGroup;
use App\Services\BaseService;
use App\Http\Requests\DiscountRequest;
use App\Contracts\ProductDiscountContract;
use App\Exceptions\EntityNotFoundException;
use App\Exceptions\InvalidDiscountException;

class ProductDiscountEloquentService extends BaseService implements ProductDiscountContract
{
  public function addDiscountToProduct(DiscountRequest $request, int $id)
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

    if ($group_id) {
      $group = Group::find($group_id);

      if (!$group) {
        throw new EntityNotFoundException('Group not found');
      }

      // $productCurrentPrice = $product->prices->where('group_id', $group_id)->first()->amount;
      $productCurrentPrice = $product->prices->where('group_id', $group_id)->sortByDesc('created_at')->first()->amount;

      if ($data['amount'] > $productCurrentPrice) {
        throw new InvalidDiscountException('Discount must be lower than current price');
      }

      $discount_id = Discount::create([
        'product_id'  => $id,
        'amount'      => $data['amount'],
        'valid_from'  => $data['valid_from'],
        'valid_until' => $data['valid_until']
      ])->id;

      DiscountGroup::create([
        'discount_id' => $discount_id,
        'group_id'    => $group_id
      ]);
    } else {
      Discount::create([
        'product_id'  => $id,
        'amount'      => $data['amount'],
        'valid_from'  => $data['valid_from'],
        'valid_until' => $data['valid_until']
      ]);
    }
  }

  public function upateDiscountFromProduct(DiscountRequest $request, int $id)
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

    if ($group_id) {
      $group = Group::find($group_id);

      if (!$group) {
        throw new EntityNotFoundException('Group not found');
      }

      $tmp = DiscountGroup::where([
        ['group_id', $group_id]
      ])->latest()->first();

      $discount = Discount::where([
        ['product_id', $id],
        ['id', $tmp->discount_id ?? null]
      ])->first();

      $discount->update([
        'product_id'   => $id,
        'amount'       => $data['amount'],
        'valid_from'   => $data['valid_from'],
        'valid_until'  => $data['valid_until']
      ]);
    } else {
      $discountsForProduct = Discount::where('product_id', $id)->select('id')->get()->toArray();
      $isOk = DiscountGroup::whereIn('discount_id', $discountsForProduct)->select('discount_id')->get()->toArray();
      $whereNotIn = [];
      foreach($isOk as $key => $x)
      {
        $whereNotIn[] = $x['discount_id'];
      }

      $discountExcludingGroupDiscount = \DB::table('discounts')
                                           ->whereNotIn('id', $whereNotIn)
                                           ->get();

      $wantedDiscount = $discountExcludingGroupDiscount->filter(function ($item) use ($id) {
        return $item->product_id === $id;
      })->values()[0];

      $finallyDiscount = Discount::find($wantedDiscount->id);

      $finallyDiscount->update([
        'product_id'   => $id,
        'amount'       => $data['amount'],
        'valid_from'   => $data['valid_from'],
        'valid_until'  => $data['valid_until']
      ]);
    }
    // dd($dicount);
    // $dt = Carbon::now();

  }

}
