<?php

declare(strict_types=1);

namespace App\Helpers;

use App\Models\Group;
use App\DTO\ProductDTO;
use App\Models\ProductStorage;

class ProductMapper
{

  public static function generateClientProductResponse(int $groupID, $product): ProductDTO
  {
    $productDTO = new ProductDTO;
    $productDTO->id = $product->id;
    $productDTO->name = $product->name;
    $productDTO->description = $product->description;
    $productDTO->brand = $product->brand->name;
    $productDTO->price = SELF::generatePriceByGroup($groupID, $product);
    $productDTO->discount = SELF::generateDiscountByGroup($groupID, $product);
    $productDTO->categories = SELF::generateCategories($product->categories);
    $productDTO->storages = SELF::generateStorages($product->storages, $product);
    $productDTO->images = SELF::generateImages($product->images, $product);

    return $productDTO;
  }

  public static function generatePriceByGroup(int $groupID, $product)
  {
    $price = null;

    if ($groupID) {
      $group = Group::find($groupID);
      if ($group === null) {
        $price = $product->prices->where('group_id', null)->sortByDesc('created_at')->first()->amount ?? null;
      } else {
        $price = $product->prices->where('group_id', $groupID)->sortByDesc('created_at')->first()->amount ?? null;

        // if ($price === null) {
        //   $price = $product->prices->where('group_id', null)->sortByDesc('created_at')->first()->amount;
        // } else {
        // }
      }
    } else {
      $price = $product->prices->where('group_id', null)->sortByDesc('created_at')->first()->amount;
    }

    return $price;
  }

  public static function generateDiscountByGroup(int $groupID, $product)
  {
    $discount = null;

    if ($groupID) {
      $groupDiscounts = Group::find($groupID)->discounts ?? null;

      if ($groupDiscounts) {
        $discount = $groupDiscounts->filter(function ($item) use ($product) {
          return $item->product_id === $product->id;
        })[0] ?? null;
      }

      // dd($discount);


      if ($discount) {
        $validDiscount = DiscountChecker::valid($discount);
        //
        $discount = $validDiscount;
        //check discount
      }
      // $discount = Discount::find($product->id)->latest()->first();
      // dd(
      //   DiscountGroup::where([
      //     ['group_id', $groupID],
      //     ['discount_id', $discount->id]
      //   ])->latest()->first()
      // );

    } else {
      $discount = null;
    }

    return $discount;
  }

  public static function generateCategories($categories)
  {
    $categoryInfo = $categories->map(function ($category) {
        $categoryObj = new \StdClass;
        $categoryObj->id = $category->id;
        $categoryObj->name = $category->name;

        return $categoryObj;
      });

    return $categoryInfo;
  }

  public static function generateImages($images, $product)
  {
    $imageInfo = $images->map(function ($image) use ($product) {
      $imageObj = new \StdClass;

      $imageObj->id = $image->id;
      $imageObj->src = $image->src;

      return $imageObj;
    });

    return $imageInfo;
  }

  public static function generateStorages($storages, $product)
  {
    $storageInfo = $storages->map(function ($storage) use ($product) {
      $storageObj = new \StdClass;
      $storageObj->type = $storage->type->name;
      $storageObj->address = $storage->address;
      $tmpQuantity = ProductStorage::where([
        ['storage_id', $storage->id],
        ['product_id', $product->id]
      ])->first();
      $storageObj->quantity = $tmpQuantity->quantity;
      $storageObj->unit = $product->unit->abbr;
      return $storageObj;
    });

    return $storageInfo;
  }

  public static function generatePricesPerGroupForAdminPanel()
  {
     // $pricesPerGroups = $tmpPrices->map(function ($pricesPerGroup) {
      //   $group = new \StdClass;


      //   if ($pricesPerGroup->group_id === null) {
      //       $group->name = 'Everyone';
      //       $group->price = $pricesPerGroup->amount;
      //   } else {
      //     $groupTmp = Group::find($pricesPerGroup->group_id);
      //     $group->name = $groupTmp->name;
      //     $group->price = $pricesPerGroup->amount;
      //   }

      //   return $group;
      // });

      // $productDTO->prices = $pricesPerGroups;
  }
}
