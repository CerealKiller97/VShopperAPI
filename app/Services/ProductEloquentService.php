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
use App\Helpers\DiscountChecker;
use App\Http\Requests\ImageRequest;
use App\Http\Requests\ProductRequest;
use Illuminate\Support\Facades\Crypt;
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


    $eagerLoadingTest = Product::with([
      'storages',
      'prices',
      'discounts',
      'brand'
    ])->get();

    // dd($eagerLoadingTest);

    $product = new Product;
    $account_id =  auth()->user()->id;

    // Getting group id from request
    $groupID = request()->header('group');

    $acc = $product->where('account_id', $account_id);

    $x = $this->generatePagedResponse($acc, $perPage, $page, $name);

    $a =(auth()->user()->products);

    if ($request->minPrice || $request->maxPrice) {
      $acc->join('prices', 'products.id', '=', 'prices.product_id');
    }

    if ($request->minPrice) {
      // $acc->join('prices', 'products.id', '=', 'prices.product_id')
      $acc->where('amount', '>' , $request->minPrice)
          ->where('group_id', '=', $groupID);

          dd($acc->get());
    }

    if ($request->maxPrice) {
      dd($request->maxPrice);
    }
    // $group = Crypt::decrypt($groupID);
    //dd($x);
    //dd(Crypt::decrypt($x));


    // $x = $product->prices;

    // dd($x);


    $productArr = [];

    foreach($a as $product)
    {
      $productDTO = new ProductDTO;

      $productDTO->id = $product->id;
      $productDTO->name = $product->name;
      $productDTO->description = $product->description;
      $productDTO->brand = $product->brand->name;

      $price = null;

      if ($groupID) {
        $group = Group::find($groupID);
        if ($group === null) {
          $price = $product->prices->where('group_id', null)->sortByDesc('created_at')->first()->amount;
        } else {
          $price = $product->prices->where('group_id', $groupID)->sortByDesc('created_at')->first()->amount;

          // if ($price === null) {
          //   $price = $product->prices->where('group_id', null)->sortByDesc('created_at')->first()->amount;
          // } else {
          // }
        }
      } else {
        $price = $product->prices->where('group_id', null)->sortByDesc('created_at')->first()->amount;
      }

      $productDTO->price = $price;

      $discountTable = Discount::where('product_id', $product->id)->get();

      $discount = null;

      $groupDiscounts = Group::find($groupID); //->discounts

      if ($groupDiscounts) {
        $discountForGroup = $groupDiscounts->discounts->sortByDesc('created_at')->first();
        // dd($discountForGroup);
        if ($discountForGroup) {
          $discount = DiscountChecker::valid($discountForGroup, $groupID);
        }
      } else {
        // proveriti da li postoji popust za sve?
        $discount = null;
        //dd('group doesnt exist');
        // look for everyone's discount
      }

      $productDTO->discount = $discount;

      // dd($discountTable);

      // $discounts = DiscountGroup::where([
      //   ['group_id', $groupID]
      // ])->get();

      // dd($discounts);

      // DiscountChecker::valid($discountTable, $groupID);

      // dd($product->prices->where('group_id', $groupID));

      // $productDTO->price = $product->prices->where('group_id', $groupID)->sortByDesc('created_at')->first()->amount;

      $tmpCategories = $product->categories;

      $categoryInfo = $tmpCategories->map(function ($category) {
        $categoryObj = new \StdClass;
        $categoryObj->id = $category->id;
        $categoryObj->name = $category->name;

        return $categoryObj;
      });

      $productDTO->categories = $categoryInfo;


      // dd($tmpPrices);

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

      $tmpStorages = $product->storages;

      $storageInfo = $tmpStorages->map(function ($storage) use ($product) {
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

      $productDTO->storages = $storageInfo;

      $tmpImages = $product->images;

      $imageInfo = $tmpImages->map(function ($image) use ($product) {
        $imageObj = new \StdClass;

        $imageObj->id = $image->id;
        $imageObj->src = $image->src;

        return $imageObj;
      });

      $tmpDiscounts = $product->discounts;

      $discountInfo = $tmpDiscounts->map(function ($discount) use ($product) {
        $discountObj = new \StdClass;

        // dd($discount);

        $discountsForProduct = Discount::where('product_id', $product->id)->select('id')->get()->toArray();
        $isOk = DiscountGroup::whereIn('discount_id', $discountsForProduct)->select('discount_id')->get()->toArray();

        $whereNotIn = [];
        foreach($isOk as $key => $x)
        {
          $whereNotIn[] = $x['discount_id'];
        }

        $group = new \StdClass;
        $tmpPivot = DiscountGroup::whereIn(
          'discount_id', $whereNotIn
        )->select('group_id')
         ->get()
         ->toArray();

        foreach($tmpPivot as $x)
        {
          $g = Group::find($x['group_id']); // ->orderBy('created_at', 'ASC')->first()->discounts[0];

          // $tmp = Group::find($x['group_id']);
          // $g->sort(function ($a, $b) {
          //   return $b->created_at < $a->created_at;
          // });
          // dd($g);

          $discountObj->name = $g->name;
        }
        $discountObj->discount = $discount->amount;
        $discountObj->valid_until = $discount->valid_until;



        // Default discount
        $discountsForProduct = Discount::where('product_id', $product->id)->select('id')->get()->toArray();
        $isOk = DiscountGroup::whereIn('discount_id', $discountsForProduct)->select('discount_id')->get()->toArray();
        $whereNotIn = [];
        foreach($isOk as $key => $x)
        {
          $whereNotIn[] = $x['discount_id'];
        }

        $discountExcludingGroupDiscount = \DB::table('discounts')
                                             ->whereNotIn('id', $whereNotIn)
                                             ->get();

        $wantedDiscount = $discountExcludingGroupDiscount->filter(function ($item) use ($product) {
          return $item->product_id === $product->id;
        })->values()[0];

        $finallyDiscount = Discount::find($wantedDiscount->id);

        // if ($tmpPivot->group_id) {
        //   $tmpG = Group::find($tmpPivot->group_id);
        //   $group->name = $tmpG->name;
        //   $group->discount = $discount->amount;
        // } elseif ($tmpPivot->group_id === null) {
        //   dd('mozda svi cena');
        // }

        // if ($pricesPerGroup->group_id === null) {
        //     $group->name = 'Everyone';
        //     $group->price = $pricesPerGroup->amount;
        // } else {
        //   $groupTmp = Group::find($pricesPerGroup->group_id);
        //   $group->name = $groupTmp->name;
        //   $group->price = $pricesPerGroup->amount;
        // }
        return $discountObj;
      });

      // $productDTO->discounts = $discountInfo;

      $productDTO->images = $imageInfo;

      $productArr[] = $productDTO;
    }

    return new PagedResponse($productArr, 5, $page);
  }

  public function findProduct(int $id) : ProductDTO
  {
    $product = Product::find($id);

    if (!$product) {
      throw new EntityNotFoundException('Product not found');
    }

    $account_id = auth()->user()->id;

    if ($product->account_id !== $account_id) {
      throw new EntityNotFoundException('Product not found');
    }

    $groupID = request()->header('group');


    $x = $product->prices->where('group_id', $groupID)->sortByDesc('created_at')->first();

    $price = null;

    if ($groupID) {
      $group = Group::find($groupID);
      if($group === null) {
        $price = $product->prices->where('group_id', null)->sortByDesc('created_at')->first()->amount;
      } else {
        $price = $product->prices->where('group_id', $groupID)->sortByDesc('created_at')->first()->amount;
      }
    } else {
      $price = $product->prices->where('group_id', null)->sortByDesc('created_at')->first()->amount;
    }

    $productDTO = new ProductDTO;

    $productDTO->id = $product->id;
    $productDTO->name = $product->name;
    $productDTO->description = $product->description;
    $productDTO->brand = $product->brand->name;

    $tmpCategories = $product->categories;

    $categoryInfo = $tmpCategories->map(function ($category) {
      $categoryObj = new \StdClass;
      $categoryObj->id = $category->id;
      $categoryObj->name = $category->name;

      return $categoryObj;
    });

    $productDTO->categories = $categoryInfo;

    $tmpPrices = $product->prices;

    $pricesPerGroups = $tmpPrices->map(function ($pricesPerGroup) {
      $group = new \StdClass;
      // dd($pricesPerGroup);
      if ($pricesPerGroup->group_id === null) {
          $group->name = 'Everyone';
          $group->price = $pricesPerGroup->amount;
      } else {
        $groupTmp = Group::find($pricesPerGroup->group_id);
        $group->name = $groupTmp->name;
        $group->price = $pricesPerGroup->amount;
      }

      return $group;
    });

    //$productDTO->prices = $pricesPerGroups;

    $productDTO->price = $price;

    $tmpStorages = $product->storages;

    $storageInfo = $tmpStorages->map(function ($storage) use ($product) {
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

    $productDTO->storages = $storageInfo;

    $tmpImages = $product->images;

    $imageInfo = $tmpImages->map(function ($image) use ($product) {
      $imageObj = new \StdClass;

      $imageObj->id = $image->id;
      $imageObj->src = $image->src;

      return $imageObj;
    });

    $tmpDiscounts = $product->discounts;

    $discountInfo = $tmpDiscounts->map(function ($discount) use ($product) {
      $discountObj = new \StdClass;


      $discountsForProduct = Discount::where('product_id', $product->id)->select('id')->get()->toArray();
      $isOk = DiscountGroup::whereIn('discount_id', $discountsForProduct)->select('discount_id')->get()->toArray();

      $whereNotIn = [];
      foreach($isOk as $key => $x)
      {
        $whereNotIn[] = $x['discount_id'];
      }

      $group = new \StdClass;
      $tmpPivot = DiscountGroup::whereIn(
        'discount_id', $whereNotIn
      )->select('group_id')
       ->get()
       ->toArray();

      foreach($tmpPivot as $x)
      {
        $g = Group::find($x['group_id']);
        $discountObj->name = $g->name;
      }


      $discountObj->discount = $discount->amount;
      $discountObj->valid_until = $discount->valid_until;

      // Default discount
      $discountsForProduct = Discount::where('product_id', $product->id)->select('id')->get()->toArray();
      $isOk = DiscountGroup::whereIn('discount_id', $discountsForProduct)->select('discount_id')->get()->toArray();
      $whereNotIn = [];
      foreach($isOk as $key => $x)
      {
        $whereNotIn[] = $x['discount_id'];
      }

      $discountExcludingGroupDiscount = \DB::table('discounts')
                                           ->whereNotIn('id', $whereNotIn)
                                           ->get();

      $wantedDiscount = $discountExcludingGroupDiscount->filter(function ($item) use ($product) {
        return $item->product_id === $product->id;
      })->values()[0];

      $finallyDiscount = Discount::find($wantedDiscount->id);

      // if ($tmpPivot->group_id) {
      //   $tmpG = Group::find($tmpPivot->group_id);
      //   $group->name = $tmpG->name;
      //   $group->discount = $discount->amount;
      // } elseif ($tmpPivot->group_id === null) {
      //   dd('mozda svi cena');
      // }

      // if ($pricesPerGroup->group_id === null) {
      //     $group->name = 'Everyone';
      //     $group->price = $pricesPerGroup->amount;
      // } else {
      //   $groupTmp = Group::find($pricesPerGroup->group_id);
      //   $group->name = $groupTmp->name;
      //   $group->price = $pricesPerGroup->amount;
      // }
      return $discountObj;
    });

    $productDTO->discounts = $discountInfo;

    $productDTO->images = $imageInfo;

    return $productDTO;
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
    $acc = auth()->user()->products;
    $product = Product::find($id);

    $this->policy->can($acc, $product, 'Product');

    $product->fill($request->validated());
    $product->save();
  }

  public function deleteProduct(int $id)
  {
    $acc = auth()->user()->products;
    $product = Product::find($id);

    $this->policy->can($acc, $product, 'Product');

    $product->delete();
  }

  // public function addPicturesToProduct(ImageRequest $request, int $id)
  // {
  //   $product = Product::find($id);

  //   if (!$product) {
  //     throw new EntityNotFoundException('Product not found');
  //   }

  //   $user_id = auth()->user()->id;

  //   // Storage doesn't belong to auth user, but exist in DB
  //   if ($user_id !== $product->account->id) {
  //     throw new EntityNotFoundException('Product not found');
  //   }

  //   $images = $request->validated()['images'];

  //   foreach ($images as $image)
  //   {
  //     $src = UploadFile::move($image);
  //     $image_id = Image::create($src)->id;
  //     $storageImage = ProductImage::create([
  //       'product_id' => $id,
  //       'image_id'   => $image_id
  //     ]);
  //   }
  // }

  // public function deletePicturesFromProduct(ImageBatchRequest $request, int $id)
  // {
  //   $imageIDS = $request->validated()['images'];

  //   ImagePivotTableRemover::remove('image_product', $imageIDS, $id);
  // }

  // public function addProductToStorage(ProductStorageRequest $request , int $id)
  // {
  //   $storage = Storage::find($id);
  //   $account_id = auth()->user()->id;

  //   // Storage doesn't exist in DB
  //   if (!$storage) {
  //     throw new EntityNotFoundException('Storage not found');
  //   }

  //     // Storage doesn't belong to auth user
  //   if ($storage->account_id !== $account_id) {
  //     throw new EntityNotFoundException('Storage not found');
  //   }

  //   $product = Product::find($request->product_id);

  //   // Product doesn't exist in DB
  //   if (!$product) {
  //     throw new EntityNotFoundException('Product not found');
  //   }

  //   // Product doesn't belong to auth user
  //   if ($product->account->id !== $account_id) {
  //     throw new EntityNotFoundException('Product not found');
  //   }

  //   $data = $request->validated();

  //   ProductStorage::create([
  //     'product_id' => $data['product_id'],
  //     'storage_id' => $id,
  //     'quantity'   => $data['quantity']
  //   ]);

  // }

  // public function deleteProductFromStorage(BatchProductStorageRequest $request , int $id)
  // {
  //   $storage = Storage::find($id);

  //   // Storage doesn't exist in DB
  //   if (!$storage) {
  //     throw new EntityNotFoundException('Storage not found');
  //   }

  //   $account_id = auth()->user()->id;

  //     // Storage doesn't belong to auth user
  //   if ($storage->account_id !== $account_id) {
  //     throw new EntityNotFoundException('Storage not found');
  //   }

  //   $data = $request->validated()['products'];


  //   $products = ProductStorage::whereIn('product_id', $data)
  //                             ->where('storage_id', $id)
  //                             ->count();

  //   if ($products === count($data)) {
  //     ProductStorage::whereIn('product_id', $data)
  //                   ->delete();
  //   } else {
  //     throw new BatchDeleteException('One of ids is not valid');
  //   }
  // }

  // public function addNewPriceToProduct(ProductPriceRequest $request , int $id)
  // {
  //   $product = Product::find($id);

  //   if (!$product) {
  //     throw new EntityNotFoundException('Product not found');
  //   }

  //   $account_id = auth()->user()->id;

  //   // Product doesn't belong to auth user
  //   if ($product->account->id !== $account_id) {
  //     throw new EntityNotFoundException('Product not found');
  //   }

  //   $data = $request->validated();
  //   $group_id = $data['group_id'] ?? null;
  //   $amount = $data['amount'];

  //   // group id has been passed
  //   if ($group_id) {
  //     $group = Group::find($group_id);

  //     if (!$group) {
  //       throw new EntityNotFoundException('Group not found');
  //     }


  //     if (($group->account_id === null) || ($group->account_id === $account_id)) {
  //       Price::create([
  //         'product_id' => $id,
  //         'amount'     => $amount,
  //         'group_id'   => $group_id
  //       ]);
  //     }
  //   } else { // price is for everyone not specific price for group
  //     Price::create([
  //       'product_id' => $id,
  //       'amount'     => $amount,
  //       'group_id'   => $group_id
  //     ]);
  //   }
  // }

  // public function updatePriceToProduct(ProductPriceRequest $request , int $id)
  // {
  //   $product = Product::find($id);

  //   if (!$product) {
  //     throw new EntityNotFoundException('Product not found');
  //   }

  //   $account_id = auth()->user()->id;

  //   // Product doesn't belong to auth user
  //   if ($product->account->id !== $account_id) {
  //     throw new EntityNotFoundException('Product not found');
  //   }

  //   $data = $request->validated();
  //   $group_id = $data['group_id'] ?? null;
  //   $amount = $data['amount'];

  //   if ($group_id) {

  //     $group = Group::find($group_id);

  //     if (!$group) {
  //       throw new EntityNotFoundException('Group not found');
  //     }

  //     $productPrice = Price::where([
  //       ['product_id', $id],
  //       ['group_id', $group_id]
  //     ])
  //     ->latest()->first();
  //     $productPrice->update([
  //       'amount'     => $amount,
  //       'product_id' => $id,
  //       'group_id'   => $group_id
  //     ]);

  //   } else {
  //     // group_id not passed for all users

  //     $productPrice = Price::where([
  //       ['product_id', $id],
  //       ['group_id', null]
  //     ])
  //     ->latest()->first();
  //     $productPrice->update([
  //       'amount'     => $amount,
  //       'product_id' => $id
  //     ]);
  //   }
  // }

  // public function addDiscountToProduct(DiscountRequest $request, int $id)
  // {
  //   $product = Product::find($id);

  //   if (!$product) {
  //     throw new EntityNotFoundException('Product not found');
  //   }

  //   $account_id = auth()->user()->id;

  //   // Product doesn't belong to auth user
  //   if ($product->account->id !== $account_id) {
  //     throw new EntityNotFoundException('Product not found');
  //   }

  //   $data = $request->validated();
  //   $group_id = $data['group_id'] ?? null;

  //   if ($group_id) {
  //     $group = Group::find($group_id);

  //     if (!$group) {
  //       throw new EntityNotFoundException('Group not found');
  //     }

  //     $productCurrentPrice = $product->prices->where('group_id', $group_id)->first()->amount;

  //     if ($data['amount'] > $productCurrentPrice) {
  //       throw new InvalidDiscountException('Discount must be lower than current price');
  //     }

  //     $discount_id = Discount::create([
  //       'product_id'  => $id,
  //       'amount'      => $data['amount'],
  //       'valid_from'  => $data['valid_from'],
  //       'valid_until' => $data['valid_until']
  //     ])->id;

  //     DiscountGroup::create([
  //       'discount_id' => $discount_id,
  //       'group_id'    => $group_id
  //     ]);
  //   } else {
  //     Discount::create([
  //       'product_id'  => $id,
  //       'amount'      => $data['amount'],
  //       'valid_from'  => $data['valid_from'],
  //       'valid_until' => $data['valid_until']
  //     ]);
  //   }
  // }

  // public function upateDiscountFromProduct(DiscountRequest $request, int $id)
  // {
  //   $product = Product::find($id);

  //   if (!$product) {
  //     throw new EntityNotFoundException('Product not found');
  //   }

  //   $account_id = auth()->user()->id;

  //   // Product doesn't belong to auth user
  //   if ($product->account->id !== $account_id) {
  //     throw new EntityNotFoundException('Product not found');
  //   }

  //   $data = $request->validated();
  //   $group_id = $data['group_id'] ?? null;

  //   if ($group_id) {
  //     $group = Group::find($group_id);

  //     if (!$group) {
  //       throw new EntityNotFoundException('Group not found');
  //     }

  //     $tmp = DiscountGroup::where([
  //       ['group_id', $group_id]
  //     ])->latest()->first();

  //     $discount = Discount::where([
  //       ['product_id', $id],
  //       ['id', $tmp->discount_id ?? null]
  //     ])->first();

  //     $discount->update([
  //       'product_id'   => $id,
  //       'amount'       => $data['amount'],
  //       'valid_from'   => $data['valid_from'],
  //       'valid_until'  => $data['valid_until']
  //     ]);
  //   } else {
  //     $discountsForProduct = Discount::where('product_id', $id)->select('id')->get()->toArray();
  //     $isOk = DiscountGroup::whereIn('discount_id', $discountsForProduct)->select('discount_id')->get()->toArray();
  //     $whereNotIn = [];
  //     foreach($isOk as $key => $x)
  //     {
  //       $whereNotIn[] = $x['discount_id'];
  //     }

  //     $discountExcludingGroupDiscount = \DB::table('discounts')
  //                                          ->whereNotIn('id', $whereNotIn)
  //                                          ->get();

  //     $wantedDiscount = $discountExcludingGroupDiscount->filter(function ($item) use ($id) {
  //       return $item->product_id === $id;
  //     })->values()[0];

  //     $finallyDiscount = Discount::find($wantedDiscount->id);

  //     $finallyDiscount->update([
  //       'product_id'   => $id,
  //       'amount'       => $data['amount'],
  //       'valid_from'   => $data['valid_from'],
  //       'valid_until'  => $data['valid_until']
  //     ]);
  //   }
  //   // dd($dicount);
  //   // $dt = Carbon::now();

  // }
}
