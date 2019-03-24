<?php

namespace App\Services;

use Carbon\Carbon;
use App\Models\Unit;
use App\Models\Brand;
use App\Models\Group;
use App\Models\Image;
use App\Models\Price;
use App\Models\Vendor;
use App\DTO\ProductDTO;
use App\Models\Product;
use App\Models\Storage;
use App\Models\Category;
use App\Models\Discount;
use App\Helpers\UploadFile;
use App\Models\ProductType;
use App\Models\ProductImage;
use App\Models\DiscountGroup;
use App\Services\BaseService;
use App\Helpers\PagedResponse;
use App\Models\ProductStorage;
use App\Models\CategoryProduct;
use App\Contracts\ProductContract;
use App\Http\Requests\ImageRequest;
use App\Http\Requests\ProductRequest;
use App\Http\Requests\DiscountRequest;
use App\Helpers\ImagePivotTableRemover;
use App\Exceptions\BatchDeleteException;
use App\Http\Requests\ImageBatchRequest;
use App\Http\Requests\ProductPriceRequest;
use App\Exceptions\EntityNotFoundException;
use App\Http\Requests\ProductSearchRequest;
use App\Exceptions\InvalidDiscountException;
use App\Http\Requests\ProductStorageRequest;
use App\Http\Requests\BatchProductStorageRequest;

class ProductEloquentService extends BaseService implements ProductContract
{
  public function getProducts(ProductSearchRequest $request) //: PagedResponse
  {
    $page = $request->getPaging()->page;
    $perPage = $request->getPaging()->perPage;
    $name = $request->getPaging()->name;

    $product = new Product;
    $account_id =  auth()->user()->id;

    dd(auth()->user()->products);

    $acc = $product->where('account_id', $account_id)->get();

    $productArr = [];

    foreach($acc as $product)
    {
      $productDTO = new ProductDTO;

      $productDTO->id = $product->id;
      $productDTO->name = $product->name;
      $productDTO->description = $product->description;

      // $productDTO->brand = $product->brand->name;

      // Brand packing
      $tmpBrand = $product->brand;
      $brandObj = new \StdClass;
      $brandObj->id = $tmpBrand->id;
      $brandObj->name = $tmpBrand->name;

      $productDTO->brand = $brandObj;

      // unit packing
      $tmpUnit = $product->unit;
      $unitObj = new \StdClass;
      $unitObj->id = $tmpUnit->id;
      $unitObj->unit = $tmpUnit->name;

      $productDTO->unit = $unitObj;

      // images
      $tmpImages = $product->images;
      $images = $tmpImages->map(function ($item) {
        $image = new \StdClass;

        $image->id = $item->id;
        $image->src = $item->src;

        return $image;
      });

      // storages

      $tmpStorages = $product->storages;

      $arrayStorages = [];

      $temporaryStorages = $tmpStorages->map(function ($item) use ($product) {
        $storage = new \StdClass;
        $storage->name = $item->address;
        $storage->type = $item->type->name;

        // $tmp = ProductStorage::where([
        //   ['product_id', $product->id]
        // ])->get()
        //   ->toArray();
        $queryBuilderTmp = \DB::table('product_storage')
                              ->select('quantity')
                              ->where([
                                ['product_id', $product->id]
                              ])
                              ->get();

          foreach($queryBuilderTmp as $x)
          {
            $storage->quantity = $x;
            continue;
          }

        return $storage;
      });

      dd($temporaryStorages);

      // foreach($tmpStorages as $item)
      // {
      //   $storage = new \StdClass;
      //   $storage->name = $item->address;

      //   $pivot = ProductStorage::where([
      //     ['product_id', $product->id]
      //   ])->get();
      //   dd($pivot);
      //   $storage->quantity = $pivot->quantity;
      //   $arrayStorages[] = $storage;
      // }

      // dd($arrayStorages);

      // $storages = $tmpStorages->map(function ($item) use ($product) {
      //   $array = [];
      //   $storage = new \StdClass;
      //   $storage->name = $item->address;

      //   $pivot = ProductStorage::where([
      //     ['product_id', $product->id]
      //   ])->get();



      //   // $x = $pivot->map(function ($i) use ($storage, $item) {
      //   //   $storage = new \StdClass;
      //   //   $storage->name = $item->address;
      //   //   $storage->quantity = $i->quantity;
      //   //   return $storage;
      //   // });

      //   // dd($pivot);

      //   // $quantity = $pivot->quantity;

      //   // $storage->quantity = $quantity;

      //   // return $storage;
      // });


      $productDTO->storages = $tmpStorages;

      $productDTO->images = $images;

      $productArr[] = $productDTO;
    }

    return ['data' => $productArr];
  }

  public function findProduct(int $id) : ProductDTO
  {
     // $group_id = $request->validated()['group_id'] ?? null;
    // $product = Product::find($id);

    //  dd($product->prices->where('group_id', $group_id)->first());
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

    $brand = Brand::find($data['brand_id']);

    if (!$brand) {
      throw new EntityNotFoundException('Brand not found');
    }

    $account_id = auth()->user()->id;

    if ($brand->account_id !== $account_id) {
      throw new EntityNotFoundException('Brand not found');
    }

    $vendor = Vendor::find($data['vendor_id']);

    if (!$vendor) {
      throw new EntityNotFoundException('Vendor not found');
    }

    $account_id = auth()->user()->id;

    if ($vendor->account_id !== $account_id) {
      throw new EntityNotFoundException('Vendor not found');
    }

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

  }

  public function removeProduct(int $id)
  {

  }

  public function addPicturesToProduct(ImageRequest $request, int $id)
  {
    $product = Product::find($id);

    if (!$product) {
      throw new EntityNotFoundException('Product not found');
    }

    $user_id = auth()->user()->id;

    // Storage doesn't belong to auth user, but exist in DB
    if ($user_id !== $product->account->id) {
      throw new EntityNotFoundException('Product not found');
    }

    $images = $request->validated()['images'];

    foreach ($images as $image)
    {
      $src = UploadFile::move($image);
      $image_id = Image::create($src)->id;
      $storageImage = ProductImage::create([
        'product_id' => $id,
        'image_id'   => $image_id
      ]);
    }
  }

  public function deletePicturesFromProduct(ImageBatchRequest $request, int $id)
  {
    $imageIDS = $request->validated()['images'];

    ImagePivotTableRemover::remove('image_product', $imageIDS, $id);
  }

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

      $productCurrentPrice = $product->prices->where('group_id', $group_id)->first()->amount;

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

    // $discount = Discount::where('product_id', $id)->get();

    // // dd($discount);


    // dd($tmp->discount_id);

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
      // $discount_id = Discount::create([
      //   'product_id'  => $id,
      //   'amount'      => $data['amount'],
      //   'valid_from'  => $data['valid_from'],
      //   'valid_until' => $data['valid_until']
      // ])->id;

      // DiscountGroup::create([
      //   'discount_id' => $discount_id,
      //   'group_id'    => $group_id
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

      // dd($finallyDiscount);
      $finallyDiscount->update([
        'product_id'   => $id,
        'amount'       => $data['amount'],
        'valid_from'   => $data['valid_from'],
        'valid_until'  => $data['valid_until']
        // $request->validated()
      ]);

      // dd(
      //   Discount::whereNotIn('id', [$whereNotIn])->get()
      //           // ->where('product_id', $id)
      //           // ->get()
      // );

      // $arrayString = implode(',', $isOk['id']);

      // dd($arrayString);

      // dd('no group id discount is for all');
      // dd($dicount);

      // Discount::create([
      //   'product_id'  => $id,
      //   'amount'      => $data['amount'],
      //   'valid_from'  => $data['valid_from'],
      //   'valid_until' => $data['valid_until']
      // ]);
    }

    // $dicount = Discount::where('product_id', $id)->latest()->first();

    // dd($dicount);
    // $dt = Carbon::now();

  }

}
