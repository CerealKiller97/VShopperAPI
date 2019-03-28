<?php

namespace App\Services;

use App\Models\Group;
use App\Models\Product;
use App\Models\Discount;
use App\Models\DiscountGroup;
use App\Services\BaseService;
use App\Exceptions\DiscountHasNoPriceException;
use App\Http\Requests\DiscountRequest;
use App\Contracts\ProductDiscountContract;
use App\Exceptions\EntityNotFoundException;
use App\Exceptions\InvalidDiscountException;

class ProductDiscountEloquentService extends BaseService implements ProductDiscountContract
{
  public function addDiscountToProduct(DiscountRequest $request, int $id)
  {
    // Product check
    $acc = auth()->user()->products;
    $product = Product::find($id);
    $this->policy->can($acc, $product, 'Product');

    $data = $request->validated();
    $group_id = $data['group_id'] ?? null;

    if ($group_id) {
      $group = Group::find($group_id);

      if (!$group) {
        throw new EntityNotFoundException('Group not found');
      }

      // $productCurrentPrice = $product->prices->where('group_id', $group_id)->first()->amount;
      $productCurrentPrice = $product->prices->where('group_id', $group_id)->sortByDesc('created_at')->first()->amount ?? null;

      if ($productCurrentPrice === null) {
        throw new DiscountHasNoPriceException('Product doesnt have initial price');
      }

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
    $acc = auth()->user()->products;
    $product = Product::find($id);

    $this->policy->can($acc, $product, 'Product');

    $data = $request->validated();
    $group_id = $data['group_id'] ?? null;

    $amount = $data['amount'];

    if ($group_id) {
      $group = Group::with(['discounts'])->find($group_id) ?? null;
      if (!$group) {
        throw new EntityNotFoundException('Group not found');
      }

      $productCurrentPrice = $product->prices->where('group_id', $group_id)->sortByDesc('created_at')->first()->amount ?? null;
      if ($amount > $productCurrentPrice) {
        throw new InvalidDiscountException('Discount must be lower than current price');
      }

      if ($group) {
        $discount = $group->discounts->filter(function ($item) use ($product) {
          return $item->product_id === $product->id;
        })[0] ?? null;

        // dd($discount);

        $discount->update([
          'product_id'   => $id,
          'amount'       => $data['amount'],
          'valid_from'   => $data['valid_from'],
          'valid_until'  => $data['valid_until']
        ]);
      }

      // $tmp = DiscountGroup::where([
      //   ['group_id', $group_id]
      // ])->latest()->first();

      // // dd($tmp);

      // $discount = Discount::where([
      //   ['product_id', $id],
      //   ['id', $tmp->discount_id ?? null]
      // ])->first();

      // $discount->update([
      //   'product_id'   => $id,
      //   'amount'       => $data['amount'],
      //   'valid_from'   => $data['valid_from'],
      //   'valid_until'  => $data['valid_until']
      // ]);
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
  }
}

