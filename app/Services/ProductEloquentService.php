<?php

namespace App\Services;

use App\Models\Unit;
use App\Models\Brand;
use App\Models\Vendor;
use App\DTO\ProductDTO;
use App\Models\Product;
use App\Models\Category;
use App\Models\ProductType;
use App\Helpers\PagedResponse;
use App\Helpers\ProductMapper;
use App\Models\CategoryProduct;
use App\Contracts\ProductContract;
use App\Http\Requests\ProductRequest;
use App\Exceptions\EntityNotFoundException;
use App\Http\Requests\ProductSearchRequest;

class ProductEloquentService extends BaseService implements ProductContract
{
  public function getProducts(ProductSearchRequest $request) //: PagedResponse
  {
    $page = $request->getPaging()->page;
    $perPage = $request->getPaging()->perPage;
    $name = $request->getPaging()->name;

    $account_id =  auth()->user()->id;

    $product = Product::with([
      'storages',
      'prices',
      'discounts',
      'brand'
    ])->where('account_id', $account_id);

    // dd($product);

    $x = $this->generatePagedResponse($product, $perPage, $page, $name);

    dd($x);
    // if ($request->minPrice ) {
    //   $product->join('prices', 'products.id', '=', 'prices.product_id');
    // }

    // Getting group id from request
    $groupID = request()->header('group');

    $totalProductsInDB =auth()->user()->products;

    $totalCount = $totalProductsInDB->count();

    // dd($product->prices);

    if ($request->minPrice) {
      // $acc->join('prices', 'products.id', '=', 'prices.product_id')
      dd($product->prices);
           $product->prices->where('amount', '>' , $request->minPrice)
                           ->where('group_id', '=', $groupID);

          dd($product);
    }

// $x = $this->generatePagedResponse($acc, $perPage, $page, $name);

    if ($request->maxPrice) {
      dd($request->maxPrice);
    }
    // $group = Crypt::decrypt($groupID);
    //dd($x);
    //dd(Crypt::decrypt($x));

    $productArr = [];

    foreach($totalProductsInDB as $product)
    {
      $productDTO = ProductMapper::generateClientProductResponse($groupID, $product);

      $productArr[] = $productDTO;
    }

    return new PagedResponse($productArr, $totalCount, $page);
  }

  public function findProduct(int $id) : ProductDTO
  {
    $product = Product::with([
      'prices',
      'categories',
      'storages',
      'images'
    ])->find($id);

    $acc = auth()->user()->products;

    $this->policy->can($acc, $product, 'Product');

    $groupID = request()->header('group');

    $x = $product->prices->where('group_id', $groupID)->sortByDesc('created_at')->first();

    return ProductMapper::generateClientProductResponse($groupID, $product);
  }

  public function addProduct(ProductRequest $request)
  {
    $data = $request->validated();

    $unit = Unit::find($data['unit_id']);

    if (!$unit) {
      throw new EntityNotFoundException('Unit not found');
    }

    $account_id = auth()->user()->id;

    if (!($unit->account_id === null) || ($unit->account_id === $account_id)) {
      throw new EntityNotFoundException('Unit not found');
      dd('unit id not ok');
    }

    // Brand check
    $acc = auth()->user()->brands;
    $brand = Brand::find($data['brand_id']);

    $this->policy->can($acc, $brand, 'Brand');

    // Vendor check
    $acc = auth()->user()->vendors;
    $vendor = Vendor::find($data['vendor_id']);

    $this->policy->can($acc, $vendor, 'Vendor');


    $productType = ProductType::find($data['product_type_id']);

    if (!$productType) {
      throw new EntityNotFoundException('Product type not found');
    }

    if ($productType->account !== null) {
      if ($productType->account_id !== $account_id) {
        throw new EntityNotFoundException('Product type not found');
      }
    }

    $categoriesArr = $data['categories'];
    $count = 0;
    $defaultCategories = Category::DEFAULT_CATEGORY_IDS;

    // dd($categoriesArr);

    foreach($categoriesArr as $c)
    {
      if (in_array($c, $defaultCategories)) {
        $count++;
      }
    }


    $categoriesOk = Category::whereIn('id', $categoriesArr)
                            ->where('account_id', $account_id)
                            ->count();


    if (($categoriesOk + $count) === count($categoriesArr)) {
      $product = Product::create([
        'account_id'      => $account_id,
        'unit_id'         => $data['unit_id'],
        'brand_id'        => $data['brand_id'],
        'vendor_id'       => $data['vendor_id'],
        'product_type_id' => $data['product_type_id'],
        'name'            => $data['name'],
        'description'     => $data['description']
      ]);

      auth()->user()->products()->save($product);

      $batchArray = [];

      for ($i = 0; $i < (count($categoriesArr)); $i++) {
        $arr = [
          'product_id'  => $product->id,
          'category_id' => $categoriesArr[$i]
        ];
        $batchArray[] = $arr;
      }

      CategoryProduct::insert($batchArray);

    } else {
      throw new EntityNotFoundException('One of categories doesnt exist');
    }

  }

  public function updateProduct(ProductRequest $request, int $id)
  {
    $acc = auth()->user()->products;
    $product = Product::find($id);

    $this->policy->can($acc, $product, 'Product');

    $data = $request->validated();

    $product->update([
      'unit_id'         => $data['unit_id'],
      'brand_id'        => $data['brand_id'],
      'vendor_id'       => $data['vendor_id'],
      'product_type_id' => $data['product_type_id'],
      'name'            => $data['name'],
      'description'     => $data['description']
    ]);

    $categories = $data['categories'];

    Product::find($id)
           ->categories()
           ->sync($categories);
  }

  public function deleteProduct(int $id)
  {
    $acc = auth()->user()->products;
    $product = Product::find($id);

    $this->policy->can($acc, $product, 'Product');

    $product->delete();
  }
}
